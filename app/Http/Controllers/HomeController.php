<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\FerryTicket;
use App\Models\FerrySchedule;
use App\Models\DashboardImage;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
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
        if ($booking && !$ferryPassAssigned) {
            $availableSchedules = FerrySchedule::whereNull('cancelled_at')
                ->where('departure_time', '>', now())
                ->get()
                ->filter(function ($schedule) {
                    $ticketCount = FerryTicket::where('ferry_schedule_id', $schedule->id)->count();
                    $remainingCapacity = $schedule->seats_available - $ticketCount;
                    return $remainingCapacity > 0;
                })
                ->sortBy('departure_time');
        }
        
        // If user has no active booking, redirect to rooms page
        if (!$booking) {
            return redirect()->route('rooms.index');
        }
        
        // Get active dashboard images
        $dashboardImages = DashboardImage::active()
            ->ordered()
            ->get()
            ->groupBy('display_position');
        
        return view('home', compact(
            'booking', 
            'ferryTicket', 
            'hasFerryPass', 
            'ferryPassAssigned', 
            'availableSchedules',
            'dashboardImages'
        ));
    }
} 