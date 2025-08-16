<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MenuService;

use App\Models\FerrySchedule;
use App\Models\FerryTicket;
use App\Models\FerryTicketRequest;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



class DashboardController extends Controller
{
    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    // hotel dashboard

    public function hotelDashboard()
    {
        $menuItems = $this->menuService->getHotelMenu();
        return view('hotel.dashboard', compact('menuItems'));
    }
    
    // ferry operator dashboard

    public function ferryOperatorDashboard()
    {
        $menuItems = $this->menuService->getFerryOperatorMenu();
        return view('ferry.dashboard', compact('menuItems'));
    }


    /**
     * Show ferry ticket requests for validation
     */
    public function ferryTicketRequests()
    {
        $menuItems = $this->menuService->getFerryOperatorMenu();
        
        $requests = FerryTicketRequest::with(['user', 'booking', 'ferrySchedule'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('ferry.requests.index', compact('menuItems', 'requests'));
    }

    /**
     * Approve a ferry ticket request
     */
    public function approveRequest($id)
    {
        $request = FerryTicketRequest::findOrFail($id);
        
        // Check if user has a valid hotel booking
        $booking = $request->booking;
        if (!$booking || $booking->check_out_date < now()) {
            return redirect()->back()
                ->withErrors(['error' => 'User does not have a valid hotel booking.']);
        }
        
        // Check ferry schedule capacity
        $schedule = $request->ferrySchedule;
        $currentTicketCount = FerryTicket::where('ferry_schedule_id', $schedule->id)->count();
        $remainingCapacity = $schedule->seats_available - $currentTicketCount;
        
        if ($remainingCapacity < $request->quantity) {
            return redirect()->back()
                ->withErrors(['error' => 'Not enough seats available for this schedule.']);
        }
        
        // Create ferry tickets
        for ($i = 0; $i < $request->quantity; $i++) {
            FerryTicket::create([
                'user_id' => $request->user_id,
                'booking_id' => $request->booking_id,
                'ferry_schedule_id' => $request->ferry_schedule_id,
                'price' => $request->total_price / $request->quantity,
                'is_used' => false,
            ]);
        }
        
        // Update request status
        $request->update([
            'status' => FerryTicketRequest::STATUS_APPROVED,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);
        
        return redirect()->back();
    }

    /**
     * Deny a ferry ticket request
     */
    public function denyRequest(Request $request, $id)
    {
        $ticketRequest = FerryTicketRequest::findOrFail($id);
        
        $request->validate([
            'denial_reason' => 'required|string|max:500',
        ]);
        
        $ticketRequest->update([
            'status' => FerryTicketRequest::STATUS_DENIED,
            'denial_reason' => $request->denial_reason,
            'denied_at' => now(),
        ]);
        
        return redirect()->back();
    }


    public function assignFerrySchedule(Request $request)
    {
        $request->validate([
            'ferry_ticket_id' => 'required|exists:ferry_tickets,id',
            'ferry_schedule_id' => 'required|exists:ferry_schedules,id',
        ]);

        $ferryTicket = FerryTicket::findOrFail($request->ferry_ticket_id);
        $schedule = FerrySchedule::findOrFail($request->ferry_schedule_id);

        // Check if the user owns this ticket
        if ($ferryTicket->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'You can only assign schedules to your own ferry tickets.');
        }

        // Check if schedule is available
        $currentTicketCount = FerryTicket::where('ferry_schedule_id', $schedule->id)->count();
        $remainingCapacity = $schedule->seats_available - $currentTicketCount;

        if ($remainingCapacity <= 0) {
            return redirect()->back()->with('error', 'This ferry schedule is at full capacity.');
        }

        // Assign the schedule to the ferry ticket
        $ferryTicket->ferry_schedule_id = $schedule->id;
        $ferryTicket->save();

        return redirect()->route('visitor-dashboard')->with('success', 'Ferry schedule assigned successfully! Your ferry pass is now confirmed.');
    }


}
