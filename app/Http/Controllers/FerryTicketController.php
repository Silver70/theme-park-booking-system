<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MenuService;
use App\Models\FerrySchedule;
use App\Models\FerryTicket;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FerryTicketController extends Controller
{
    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function index()
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
            ->orderBy('departure_time', 'asc') // Order by earliest departure first
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

        // Get the earliest available schedule
        $selectedSchedule = $availableSchedules->first();

        // Create ferry ticket with assigned schedule
        $ferryTicket = FerryTicket::create([
            'user_id' => $booking->user_id,
            'booking_id' => $booking->id,
            'ferry_schedule_id' => $selectedSchedule->id,
            'price' => 25.00, // Default ferry ticket price
        ]);

        return redirect()->route('ferry.tickets.validate')
            ->with('success', 'Ferry pass issued successfully for ' . $booking->user->name . '! Ticket ID: ' . $ferryTicket->id . 
                   ' | Assigned to ferry departing on ' . $selectedSchedule->departure_time->format('M j, Y \a\t g:i A') . 
                   ' from ' . $selectedSchedule->origin . ' to ' . $selectedSchedule->destination);
    }

    public function create()
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
    
    public function store(Request $request)
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
}
