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
use Illuminate\Support\Facades\Hash;


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

    // User Management Methods
    public function showUser(User $user)
    {
        $menuItems = $this->menuService->getAdminMenu();
        return view('admin.users.show', compact('menuItems', 'user'));
    }

    public function editUser(User $user)
    {
        $menuItems = $this->menuService->getAdminMenu();
        return view('admin.users.edit', compact('menuItems', 'user'));
    }

    public function createUser()
    {
        $menuItems = $this->menuService->getAdminMenu();
        return view('admin.users.create', compact('menuItems'));
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:visitor,hotel_owner,ferry_operator,admin',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->assignRole($validated['role']);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
    }

    public function deleteUser(User $user)
    {
        // Prevent admin from deleting themselves
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot delete your own account!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }

    public function toggleEmailVerification(User $user)
    {
        if ($user->email_verified_at) {
            $user->email_verified_at = null;
            $message = 'Email verification removed.';
        } else {
            $user->email_verified_at = now();
            $message = 'Email verified successfully.';
        }

        $user->save();

        return redirect()->back()->with('success', $message);
    }



    // Room Management Methods
    public function showRoom(Room $room)
    {
        $menuItems = $this->menuService->getAdminMenu();
        return view('admin.rooms.show', compact('menuItems', 'room'));
    }



    // Booking Management Methods
    public function showBooking(Booking $booking)
    {
        $menuItems = $this->menuService->getAdminMenu();
        return view('admin.bookings.show', compact('menuItems', 'booking'));
    }

    // Ferry Management Methods
    public function showFerrySchedule(FerrySchedule $schedule)
    {
        $menuItems = $this->menuService->getAdminMenu();
        return view('admin.ferry.schedules.show', compact('menuItems', 'schedule'));
    }

    public function showFerryTicket(FerryTicket $ticket)
    {
        $menuItems = $this->menuService->getAdminMenu();
        return view('admin.ferry.tickets.show', compact('menuItems', 'ticket'));
    }
} 