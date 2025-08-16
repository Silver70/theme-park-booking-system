<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MenuService;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HotelStaffBookingController extends Controller
{
    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function index()
    {
        $menuItems = $this->menuService->getHotelStaffMenu();
        $bookings = Booking::with(['user', 'room'])->paginate(15);
        return view('hotelstaff.bookings.index', compact('menuItems', 'bookings'));
    }

    public function create()
    {
        $menuItems = $this->menuService->getHotelStaffMenu();
        $rooms = Room::all();
        $users = User::all();
        return view('hotelstaff.bookings.create', compact('menuItems', 'rooms', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date|after:today',
            'check_out_date' => 'required|date|after:check_in_date',
        ]);
        Booking::create($request->only(['user_id', 'room_id', 'check_in_date', 'check_out_date']));
        return redirect()->route('hotelstaff.bookings.index')->with('success', 'Booking created successfully.');
    }

    public function edit($id)
    {
        $menuItems = $this->menuService->getHotelStaffMenu();
        $booking = Booking::findOrFail($id);
        $rooms = Room::all();
        $users = User::all();
        return view('hotelstaff.bookings.edit', compact('menuItems', 'booking', 'rooms', 'users'));
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date|after:today',
            'check_out_date' => 'required|date|after:check_in_date',
        ]);
        $booking->update($request->only(['user_id', 'room_id', 'check_in_date', 'check_out_date']));
        return redirect()->route('hotelstaff.bookings.index')->with('success', 'Booking updated successfully.');
    }

    public function confirm($id)
    {
        $booking = Booking::findOrFail($id);
        
        if (!$booking->canBeConfirmed()) {
            return redirect()->route('hotelstaff.bookings.index')->with('error', 'This booking cannot be confirmed.');
        }
        
        $booking->update([
            'booking_status' => 'confirmed',
            'confirmed_at' => now(),
            'confirmed_by' => Auth::id(),
        ]);
        
        return redirect()->route('hotelstaff.bookings.index')->with('success', 'Booking confirmed successfully.');
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['booking_status' => 'cancelled']);
        return redirect()->route('hotelstaff.bookings.index')->with('success', 'Booking cancelled successfully.');
    }
} 