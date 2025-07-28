<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MenuService;
use App\Models\User;
use App\Models\Booking;
use App\Models\Room;
use App\Models\FerrySchedule;
use App\Models\FerryTicket;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function dashboard()
    {
        $menuItems = $this->menuService->getAdminMenu();
        
        // Get statistics for admin dashboard
        $stats = [
            'total_users' => User::count(),
            'total_bookings' => Booking::count(),
            'total_rooms' => Room::count(),
            'total_ferry_schedules' => FerrySchedule::count(),
            'total_ferry_tickets' => FerryTicket::count(),
            'recent_bookings' => Booking::with(['user', 'room'])->latest()->take(5)->get(),
            'recent_users' => User::latest()->take(5)->get(),
        ];
        
        return view('admin.dashboard', compact('menuItems', 'stats'));
    }

    public function users()
    {
        $menuItems = $this->menuService->getAdminMenu();
        $users = User::with('roles')->paginate(15);
        
        return view('admin.users.index', compact('menuItems', 'users'));
    }

    public function rooms()
    {
        $menuItems = $this->menuService->getAdminMenu();
        $rooms = Room::paginate(15);
        
        return view('admin.rooms.index', compact('menuItems', 'rooms'));
    }

    public function bookings()
    {
        $menuItems = $this->menuService->getAdminMenu();
        $bookings = Booking::with(['user', 'room'])->paginate(15);
        
        return view('admin.bookings.index', compact('menuItems', 'bookings'));
    }

    public function ferrySchedules()
    {
        $menuItems = $this->menuService->getAdminMenu();
        $schedules = FerrySchedule::with('creator')->paginate(15);
        
        return view('admin.ferry.schedules.index', compact('menuItems', 'schedules'));
    }

    public function ferryTickets()
    {
        $menuItems = $this->menuService->getAdminMenu();
        $tickets = FerryTicket::with(['user', 'booking', 'ferrySchedule'])->paginate(15);
        
        return view('admin.ferry.tickets.index', compact('menuItems', 'tickets'));
    }

    public function reports()
    {
        $menuItems = $this->menuService->getAdminMenu();
        
        // Generate report data
        $reports = [
            'booking_stats' => [
                'total' => Booking::count(),
                'this_month' => Booking::whereMonth('created_at', now()->month)->count(),
                'this_year' => Booking::whereYear('created_at', now()->year)->count(),
            ],
            'user_stats' => [
                'total' => User::count(),
                'visitors' => User::role('visitor')->count(),
                'hotel_owners' => User::role('hotel_owner')->count(),
                'ferry_operators' => User::role('ferry_operator')->count(),
                'admins' => User::role('admin')->count(),
            ],
            'revenue_stats' => [
                'total_bookings' => Booking::count(),
                'total_room_revenue' => Room::sum('price'),
                'total_ferry_revenue' => FerryTicket::sum('price'),
            ],
        ];
        
        return view('admin.reports.index', compact('menuItems', 'reports'));
    }
} 