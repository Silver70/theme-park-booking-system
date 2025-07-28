<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MenuService;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;

class HotelStaffController extends Controller
{
    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function dashboard()
    {
        $menuItems = $this->menuService->getHotelStaffMenu();
        $stats = [
            'total_rooms' => Room::count(),
            'total_bookings' => Booking::count(),
            'recent_bookings' => Booking::with(['user', 'room'])->latest()->take(5)->get(),
        ];
        return view('hotelstaff.dashboard', compact('menuItems', 'stats'));
    }

    public function reports()
    {
        $menuItems = $this->menuService->getHotelStaffMenu();
        $reports = [
            'booking_stats' => [
                'total' => Booking::count(),
                'this_month' => Booking::whereMonth('created_at', now()->month)->count(),
                'this_year' => Booking::whereYear('created_at', now()->year)->count(),
            ],
        ];
        return view('hotelstaff.reports.index', compact('menuItems', 'reports'));
    }
} 