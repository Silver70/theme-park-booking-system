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

    public function ferrySchedules()
    {
        $menuItems = $this->menuService->getFerryOperatorMenu();
        $schedules = FerrySchedule::orderBy('departure_time', 'asc')
            ->paginate(10);
        
        // Add fresh capacity data to each schedule
        $schedules->getCollection()->transform(function ($schedule) {
            $ticketCount = FerryTicket::where('ferry_schedule_id', $schedule->id)->count();
            $schedule->fresh_tickets_issued = $ticketCount;
            $schedule->fresh_remaining_capacity = $schedule->seats_available - $ticketCount;
            $schedule->fresh_capacity_display = $ticketCount . '/' . $schedule->seats_available;
            $schedule->fresh_is_full = $ticketCount >= $schedule->seats_available;
            
            // Add status based on departure time and cancellation
            if ($schedule->cancelled_at) {
                $schedule->status = 'cancelled';
            } elseif ($schedule->departure_time < now()) {
                $schedule->status = 'completed';
            } else {
                $schedule->status = 'scheduled';
            }
            
            return $schedule;
        });
        
        return view('ferry.schedules.index', compact('menuItems', 'schedules'));
    }

    public function createFerrySchedule()
    {
        $menuItems = $this->menuService->getFerryOperatorMenu();
        return view('ferry.schedules.create', compact('menuItems'));
    }

    public function storeFerrySchedule(Request $request)
    {
        $validated = $request->validate([
            'departure_time' => 'required|date|after:now',
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'seats_available' => 'required|integer|min:1|max:200',
        ]);

        $validated['created_by'] = Auth::id();

        FerrySchedule::create($validated);


        return redirect()->route('ferry.schedules')->with('success', 'Ferry schedule created successfully!');
    }

    public function editFerrySchedule($id)
    {
        $menuItems = $this->menuService->getFerryOperatorMenu();
        $schedule = FerrySchedule::findOrFail($id);
        return view('ferry.schedules.edit', compact('menuItems', 'schedule'));
    }

    public function updateFerrySchedule(Request $request, $id)
    {
        $validated = $request->validate([
            'departure_time' => 'required|date|after:now',
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'seats_available' => 'required|integer|min:1|max:200',
        ]);

        $schedule = FerrySchedule::findOrFail($id);
        $schedule->update($validated);

        return redirect()->route('ferry.schedules')->with('success', 'Ferry schedule updated successfully!');
    }
    
    public function cancelFerrySchedule($id)
    {
        $schedule = FerrySchedule::findOrFail($id);
        $schedule->cancelled_at = now();
        $schedule->save();
        return redirect()->route('ferry.schedules')->with('success', 'Ferry schedule cancelled successfully!');
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

    public function ferryTickets()
    {
        $menuItems = $this->menuService->getFerryOperatorMenu();
        $tickets = FerryTicket::with(['user', 'booking', 'ferrySchedule'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('ferry.tickets.index', compact('menuItems', 'tickets'));
    }

    public function validateTicket()
    {
        $menuItems = $this->menuService->getFerryOperatorMenu();
        return view('ferry.tickets.validate.index', compact('menuItems'));
    }

    public function submitValidation(Request $request)
    {
        $request->validate([
            'booking_reference' => 'nullable|string',
            'customer_name' => 'nullable|string',
        ], [
            'booking_reference.string' => 'Please enter a valid booking reference.',
            'customer_name.string' => 'Please enter a valid customer name.',
        ]);

        // At least one field must be provided
        if (empty($request->booking_reference) && empty($request->customer_name)) {
            return redirect()->back()
                ->withErrors(['booking_reference' => 'Please provide either a booking reference or customer name.'])
                ->withInput();
        }

        $booking = null;

        // Search by booking reference (ID) first
        if (!empty($request->booking_reference)) {
            $booking = Booking::with(['user', 'room'])
                ->where('id', $request->booking_reference)
                ->first();
        }

        // If not found and customer name provided, search by customer name
        if (!$booking && !empty($request->customer_name)) {
            $booking = Booking::with(['user', 'room'])
                ->whereHas('user', function($query) use ($request) {
                    $query->where('name', 'LIKE', '%' . $request->customer_name . '%');
                })
                ->first();
        }

        if (!$booking) {
            $error_message = 'No booking found';
            if ($request->booking_reference && $request->customer_name) {
                $error_message .= ' for booking reference "' . $request->booking_reference . '" or customer "' . $request->customer_name . '"';
            } elseif ($request->booking_reference) {
                $error_message .= ' with booking reference "' . $request->booking_reference . '"';
            } else {
                $error_message .= ' for customer "' . $request->customer_name . '"';
            }
            
            return redirect()->back()
                ->with('validation_error', $error_message)
                ->withInput();
        }

        // Check if ferry ticket already exists for this booking
        $existingTicket = FerryTicket::where('booking_id', $booking->id)->first();
        if ($existingTicket) {
            return redirect()->back()
                ->with('validation_error', 'Ferry pass has already been issued for this booking.')
                ->withInput();
        }

        return redirect()->back()->with('booking', $booking);
    }

    public function issueFerryPass(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id'
        ]);

        $booking = Booking::with(['user'])->findOrFail($request->booking_id);

        // Check if ferry ticket already exists
        $existingTicket = FerryTicket::where('booking_id', $booking->id)->first();
        if ($existingTicket) {
            return redirect()->route('ferry.tickets.validate')
                ->with('validation_error', 'Ferry pass has already been issued for this booking.');
        }

        // Check if there are any available schedules
        $availableSchedules = FerrySchedule::whereNull('cancelled_at')
            ->where('departure_time', '>', now())
            ->get()
            ->filter(function ($schedule) {
                $ticketCount = FerryTicket::where('ferry_schedule_id', $schedule->id)->count();
                $remainingCapacity = $schedule->seats_available - $ticketCount;
                return $remainingCapacity > 0;
            });

        if ($availableSchedules->isEmpty()) {
            return redirect()->route('ferry.tickets.validate')
                ->with('validation_error', 'No ferry schedules are currently available with remaining capacity.');
        }

        // Create ferry ticket (schedule will be assigned later when customer books)
        $ferryTicket = FerryTicket::create([
            'user_id' => $booking->user_id,
            'booking_id' => $booking->id,
            'ferry_schedule_id' => null, // Can be assigned later when customer books specific schedule
            'price' => 25.00, // Default ferry ticket price
        ]);

        return redirect()->route('ferry.tickets.validate')
            ->with('success', 'Ferry pass issued successfully for ' . $booking->user->name . '! Ticket ID: ' . $ferryTicket->id);
    }

    public function createFerryTicket()
    {
        $menuItems = $this->menuService->getFerryOperatorMenu();
        
        // Get bookings that don't have ferry tickets yet
        $bookings = Booking::with(['user', 'room'])
            ->whereDoesntHave('ferryTickets')
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Get available ferry schedules (not cancelled, in future, and not full)
        $schedules = FerrySchedule::whereNull('cancelled_at')
            ->where('departure_time', '>', now())
            ->get()
            ->filter(function ($schedule) {
                // Get fresh count of tickets for each schedule
                $ticketCount = FerryTicket::where('ferry_schedule_id', $schedule->id)->count();
                $remainingCapacity = $schedule->seats_available - $ticketCount;
                return $remainingCapacity > 0; // Only show schedules that have remaining capacity
            })
            ->sortBy('departure_time');
            
        return view('ferry.tickets.create', compact('menuItems', 'bookings', 'schedules'));
    }
    
    public function storeFerryTicket(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'ferry_schedule_id' => 'required|exists:ferry_schedules,id',
            'price' => 'required|numeric|min:0|max:200',
        ]);

        // Check if ferry ticket already exists for this booking
        $existingTicket = FerryTicket::where('booking_id', $request->booking_id)->first();
        if ($existingTicket) {
            return redirect()->back()
                ->withErrors(['booking_id' => 'Ferry ticket already exists for this booking.'])
                ->withInput();
        }

        // Get booking details
        $booking = Booking::with('user')->findOrFail($request->booking_id);
        
        // Get ferry schedule and check capacity with fresh count
        $schedule = FerrySchedule::findOrFail($request->ferry_schedule_id);
        
        // Get fresh count of tickets for this schedule
        $currentTicketCount = FerryTicket::where('ferry_schedule_id', $schedule->id)->count();
        $remainingCapacity = $schedule->seats_available - $currentTicketCount;
        
        if ($remainingCapacity <= 0) {
            return redirect()->back()
                ->withErrors(['ferry_schedule_id' => 'This ferry schedule is at full capacity (' . $currentTicketCount . '/' . $schedule->seats_available . '). No seats remaining.'])
                ->withInput();
        }

        // Create ferry ticket
        $ferryTicket = FerryTicket::create([
            'user_id' => $booking->user_id,
            'booking_id' => $request->booking_id,
            'ferry_schedule_id' => $request->ferry_schedule_id,
            'price' => $request->price,
        ]);

        return redirect()->route('ferry.tickets.create')
            ->with('success', 'Ferry ticket created successfully for ' . $booking->user->name . '! Ticket ID: ' . $ferryTicket->id);
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
