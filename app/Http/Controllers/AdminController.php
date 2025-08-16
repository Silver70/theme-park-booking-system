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
        
        // Generate detailed report data
        $reports = [
            'booking_stats' => [
                'total' => Booking::count(),
                'this_month' => Booking::whereMonth('created_at', now()->month)->count(),
                'this_year' => Booking::whereYear('created_at', now()->year)->count(),
                'last_month' => Booking::whereMonth('created_at', now()->subMonth()->month)->count(),
                'pending' => Booking::where('check_in_date', '>', now())->count(),
                'active' => Booking::where('check_in_date', '<=', now())->where('check_out_date', '>', now())->count(),
                'completed' => Booking::where('check_out_date', '<=', now())->count(),
            ],
            'user_stats' => [
                'total' => User::count(),
                'visitors' => User::role('visitor')->count(),
                'hotel_owners' => User::role('hotel_owner')->count(),
                'ferry_operators' => User::role('ferry_operator')->count(),
                'admins' => User::role('admin')->count(),
                'verified_users' => User::whereNotNull('email_verified_at')->count(),
                'unverified_users' => User::whereNull('email_verified_at')->count(),
                'new_this_month' => User::whereMonth('created_at', now()->month)->count(),
            ],
            'revenue_stats' => [
                'total_bookings' => Booking::count(),
                'total_room_revenue' => Room::sum('price'),
                'total_ferry_revenue' => FerryTicket::sum('price'),
                'monthly_revenue' => $this->getMonthlyRevenue(),
                'top_rooms' => $this->getTopPerformingRooms(),
                'ferry_usage' => $this->getFerryUsageStats(),
            ],
            'room_stats' => [
                'total_rooms' => Room::count(),
                'available_rooms' => Room::where('is_available', true)->count(),
                'occupied_rooms' => Room::where('is_available', false)->count(),
                'room_types' => Room::selectRaw('capacity, COUNT(*) as count')->groupBy('capacity')->get(),
            ],
            'ferry_stats' => [
                'total_schedules' => FerrySchedule::count(),
                'active_schedules' => FerrySchedule::where('departure_time', '>', now())->count(),
                'total_tickets' => FerryTicket::count(),
                'used_tickets' => FerryTicket::where('is_used', true)->count(),
                'unused_tickets' => FerryTicket::where('is_used', false)->count(),
            ],
        ];
        
        return view('admin.reports.index', compact('menuItems', 'reports'));
    }

    private function getMonthlyRevenue()
    {
        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthBookings = Booking::whereYear('created_at', $date->year)
                                  ->whereMonth('created_at', $date->month)
                                  ->count();
            $monthRevenue = Room::whereHas('bookings', function($query) use ($date) {
                $query->whereYear('created_at', $date->year)
                      ->whereMonth('created_at', $date->month);
            })->sum('price');
            
            $months->push([
                'month' => $date->format('M Y'),
                'bookings' => $monthBookings,
                'revenue' => $monthRevenue,
            ]);
        }
        return $months;
    }

    private function getTopPerformingRooms()
    {
        return Room::withCount('bookings')
                  ->orderBy('bookings_count', 'desc')
                  ->limit(5)
                  ->get()
                  ->map(function($room) {
                      return [
                          'name' => $room->name,
                          'bookings' => $room->bookings_count,
                          'revenue' => $room->price * $room->bookings_count,
                      ];
                  });
    }

    private function getFerryUsageStats()
    {
        return FerrySchedule::withCount('ferryTickets')
                          ->orderBy('ferry_tickets_count', 'desc')
                          ->limit(5)
                          ->get()
                          ->map(function($schedule) {
                              return [
                                  'route' => $schedule->origin . ' → ' . $schedule->destination,
                                  'tickets' => $schedule->ferry_tickets_count,
                                  'revenue' => FerryTicket::where('ferry_schedule_id', $schedule->id)->sum('price'),
                              ];
                          });
    }

    public function exportReports(Request $request)
    {
        $type = $request->get('type', 'all');
        $format = $request->get('format', 'csv');
        
        $data = $this->getExportData($type);
        
        if ($format === 'csv') {
            return $this->exportToCSV($data, $type);
        } else {
            return $this->exportToPDF($data, $type);
        }
    }

    public function viewAnalytics()
    {
        $menuItems = $this->menuService->getAdminMenu();
        
        $chartData = [
            'monthly_revenue' => $this->getMonthlyRevenue()->toArray(),
            'user_growth' => $this->getUserGrowthData()->toArray(),
            'room_occupancy' => $this->getRoomOccupancyData()->toArray(),
            'ferry_usage' => $this->getFerryUsageStats()->toArray(),
            'top_rooms' => $this->getTopPerformingRooms()->toArray(),
        ];
        
        return view('admin.reports.analytics', compact('menuItems', 'chartData'));
    }

    private function getExportData($type)
    {
        switch ($type) {
            case 'bookings':
                return Booking::with(['user', 'room'])->get()->map(function($booking) {
                    return [
                        'ID' => $booking->id,
                        'Guest' => $booking->user->name,
                        'Email' => $booking->user->email,
                        'Room' => $booking->room->name,
                        'Check-in' => $booking->check_in_date->format('Y-m-d'),
                        'Check-out' => $booking->check_out_date->format('Y-m-d'),
                        'Status' => $booking->check_out_date->isPast() ? 'Completed' : 'Active',
                        'Created' => $booking->created_at->format('Y-m-d H:i:s'),
                    ];
                });
                
            case 'users':
                return User::with('roles')->get()->map(function($user) {
                    return [
                        'ID' => $user->id,
                        'Name' => $user->name,
                        'Email' => $user->email,
                        'Role' => $user->getRoleNames()->first() ?? 'No Role',
                        'Verified' => $user->email_verified_at ? 'Yes' : 'No',
                        'Joined' => $user->created_at->format('Y-m-d H:i:s'),
                    ];
                });
                
            case 'revenue':
                return [
                    'total_revenue' => Room::sum('price') + FerryTicket::sum('price'),
                    'room_revenue' => Room::sum('price'),
                    'ferry_revenue' => FerryTicket::sum('price'),
                    'total_bookings' => Booking::count(),
                    'total_tickets' => FerryTicket::count(),
                ];
                
            default:
                return [
                    'bookings' => $this->getExportData('bookings'),
                    'users' => $this->getExportData('users'),
                    'revenue' => $this->getExportData('revenue'),
                ];
        }
    }

    private function exportToCSV($data, $type)
    {
        $filename = $type . '_report_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($data, $type) {
            $file = fopen('php://output', 'w');
            
            if ($type === 'revenue') {
                fputcsv($file, array_keys($data));
                fputcsv($file, array_values($data));
            } else {
                if (count($data) > 0) {
                    fputcsv($file, array_keys($data[0]));
                    foreach ($data as $row) {
                        fputcsv($file, $row);
                    }
                }
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    private function exportToPDF($data, $type)
    {
        // For now, return CSV as PDF functionality would require additional packages
        return $this->exportToCSV($data, $type);
    }

    private function getUserGrowthData()
    {
        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $count = User::whereYear('created_at', $date->year)
                        ->whereMonth('created_at', $date->month)
                        ->count();
            
            $months->push([
                'month' => $date->format('M Y'),
                'users' => $count,
            ]);
        }
        return $months;
    }

    private function getRoomOccupancyData()
    {
        return Room::withCount('bookings')->get()->map(function($room) {
            return [
                'name' => $room->name,
                'capacity' => $room->capacity,
                'bookings' => $room->bookings_count,
                'occupancy_rate' => $room->bookings_count > 0 ? round(($room->bookings_count / 30) * 100, 2) : 0,
            ];
        });
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