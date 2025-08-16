<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\FerryTicket;
use App\Models\FerrySchedule;
use App\Models\FerryTicketRequest;
use App\Models\DashboardImage;
use App\Services\CacheService;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    public function index()
    {
        $user = Auth::user();
        
        // Get the user's most recent active booking
        $booking = Booking::with(['room', 'ferryTickets.ferrySchedule'])
            ->where('user_id', $user->id)
            ->where('check_out_date', '>=', now())
            ->orderBy('check_in_date', 'desc')
            ->first();
            
        // Check if user has a ferry ticket for this booking
        $ferryTicket = null;
        $hasFerryPass = false;
        $ferryPassAssigned = false;
        
        if ($booking) {
            $ferryTicket = FerryTicket::where('booking_id', $booking->id)->first();
            
            if ($ferryTicket) {
                $hasFerryPass = true;
                $ferryPassAssigned = !is_null($ferryTicket->ferry_schedule_id);
            }
        }
        
        // Get available ferry schedules for booking
        $availableSchedules = collect();
        $purchaseSchedules = collect();
        
        if ($booking) {
            $bookingDates = [
                'start' => $booking->check_in_date->copy()->subDay(),
                'end' => $booking->check_out_date->copy()->addDay()
            ];
            
            $schedules = $this->cacheService->getFerrySchedulesWithCounts($user->id, $bookingDates);
            
            // Filter schedules with available capacity
            $availableSchedulesData = $schedules->filter(function ($schedule) {
                return ($schedule->seats_available - $schedule->ferry_tickets_count) > 0;
            });
            
            if (!$ferryPassAssigned) {
                $availableSchedules = $availableSchedulesData;
            }
            
            $purchaseSchedules = $availableSchedulesData;
        }
        
        // Get user's ferry ticket requests
        $ferryRequests = collect();
        if ($booking) {
            $ferryRequests = FerryTicketRequest::with(['ferrySchedule'])
                ->where('user_id', $user->id)
                ->where('booking_id', $booking->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }
        
        // If user has no active booking, redirect to rooms page
        if (!$booking) {
            return redirect()->route('rooms.index');
        }
        
        // Get active dashboard images using cache
        $dashboardImages = $this->cacheService->getDashboardImages();
        
        return view('home', compact(
            'booking', 
            'ferryTicket', 
            'hasFerryPass', 
            'ferryPassAssigned', 
            'availableSchedules',
            'purchaseSchedules',
            'ferryRequests',
            'dashboardImages'
        ));
    }

    /**
     * Show ferry schedules for visitors
     */
    public function ferrySchedules()
    {
        $user = Auth::user();
        
        // Check if user has a valid hotel booking
        $booking = Booking::where('user_id', $user->id)
            ->where('check_out_date', '>=', now())
            ->first();
            
        if (!$booking) {
            return redirect()->route('rooms.index')
                ->with('error', 'You need a valid hotel booking to view ferry schedules.');
        }
        
        // Filter schedules to dates relevant to the user's stay
        // Show schedules from 1 day before check-in to 1 day after check-out
        $startDate = $booking->check_in_date->copy()->subDay();
        $endDate = $booking->check_out_date->copy()->addDay();
        
        $schedules = FerrySchedule::whereNull('cancelled_at')
            ->where('departure_time', '>', now())
            ->whereBetween('departure_time', [$startDate, $endDate])
            ->orderBy('departure_time', 'asc')
            ->get()
            ->map(function ($schedule) {
                $ticketCount = FerryTicket::where('ferry_schedule_id', $schedule->id)->count();
                $schedule->remaining_capacity = $schedule->seats_available - $ticketCount;
                $schedule->is_available = $schedule->remaining_capacity > 0;
                return $schedule;
            });
        
        return view('ferry.schedules', compact('schedules', 'booking'));
    }

    /**
     * Show ferry ticket request form
     */
    public function requestTicket()
    {
        $user = Auth::user();
        
        // Check if user has a valid hotel booking
        $booking = Booking::where('user_id', $user->id)
            ->where('check_out_date', '>=', now())
            ->first();
            
        if (!$booking) {
            return redirect()->route('rooms.index')
                ->with('error', 'You need a valid hotel booking to request ferry tickets.');
        }
        
        // Filter schedules to dates relevant to the user's stay
        // Show schedules from 1 day before check-in to 1 day after check-out
        $startDate = $booking->check_in_date->copy()->subDay();
        $endDate = $booking->check_out_date->copy()->addDay();
        
        // Get available schedules
        $schedules = FerrySchedule::whereNull('cancelled_at')
            ->where('departure_time', '>', now())
            ->whereBetween('departure_time', [$startDate, $endDate])
            ->orderBy('departure_time', 'asc')
            ->get()
            ->filter(function ($schedule) {
                $ticketCount = FerryTicket::where('ferry_schedule_id', $schedule->id)->count();
                $remainingCapacity = $schedule->seats_available - $ticketCount;
                return $remainingCapacity > 0;
            });
        
        return view('ferry.request', compact('schedules', 'booking'));
    }

    /**
     * Submit ferry ticket request
     */
    public function submitRequest(Request $request)
    {
        $user = Auth::user();
        
        // Validate request
        $request->validate([
            'ferry_schedule_id' => 'required|exists:ferry_schedules,id',
            'quantity' => 'required|integer|min:1|max:5',
            'notes' => 'nullable|string|max:500',
        ]);
        
        // Check if user has a valid hotel booking
        $booking = Booking::where('user_id', $user->id)
            ->where('check_out_date', '>=', now())
            ->first();
            
        if (!$booking) {
            return redirect()->route('rooms.index')
                ->with('error', 'You need a valid hotel booking to request ferry tickets.');
        }
        
        // Get ferry schedule and check capacity
        $schedule = FerrySchedule::findOrFail($request->ferry_schedule_id);
        $currentTicketCount = FerryTicket::where('ferry_schedule_id', $schedule->id)->count();
        $remainingCapacity = $schedule->seats_available - $currentTicketCount;
        
        if ($remainingCapacity < $request->quantity) {
            return redirect()->back()
                ->withErrors(['quantity' => "Only {$remainingCapacity} seats available for this schedule."])
                ->withInput();
        }
        
        // Check if user already has a pending request for this schedule
        $existingRequest = FerryTicketRequest::where('user_id', $user->id)
            ->where('ferry_schedule_id', $schedule->id)
            ->where('status', FerryTicketRequest::STATUS_PENDING)
            ->first();
            
        if ($existingRequest) {
            return redirect()->back()
                ->withErrors(['ferry_schedule_id' => 'You already have a pending request for this schedule.'])
                ->withInput();
        }
        
        // Calculate total price (assuming $25 per ticket)
        $pricePerTicket = 25.00;
        $totalPrice = $pricePerTicket * $request->quantity;
        
        // Create ferry ticket request
        FerryTicketRequest::create([
            'user_id' => $user->id,
            'booking_id' => $booking->id,
            'ferry_schedule_id' => $schedule->id,
            'quantity' => $request->quantity,
            'total_price' => $totalPrice,
            'status' => FerryTicketRequest::STATUS_PENDING,
            'notes' => $request->notes,
        ]);
        
        return redirect()->route('visitor-dashboard')
            ->with('success', "Ferry ticket request submitted successfully! Your request is now pending review by our ferry operators. Request ID: #" . FerryTicketRequest::latest()->first()->id);
    }

    /**
     * Show user's ferry ticket requests
     */
    public function myRequests()
    {
        $user = Auth::user();
        
        // Check if user has a valid hotel booking
        $booking = Booking::where('user_id', $user->id)
            ->where('check_out_date', '>=', now())
            ->first();
            
        if (!$booking) {
            return redirect()->route('rooms.index')
                ->with('error', 'You need a valid hotel booking to view ferry requests.');
        }
        
        $requests = FerryTicketRequest::with(['ferrySchedule'])
            ->where('user_id', $user->id)
            ->where('booking_id', $booking->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('ferry.my-requests', compact('requests', 'booking'));
    }

    /**
     * Show user's all bookings
     */
    public function myBookings()
    {
        $user = Auth::user();
        
        // Get all bookings for the current user
        $bookings = Booking::with(['room', 'ferryTickets.ferrySchedule', 'ferryTicketRequests'])
            ->where('user_id', $user->id)
            ->orderBy('check_in_date', 'desc')
            ->paginate(10);
        
        return view('bookings.my-bookings', compact('bookings'));
    }


} 