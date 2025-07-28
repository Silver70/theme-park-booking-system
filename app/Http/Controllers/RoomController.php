<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return view('rooms.index', compact('rooms'));
    }

    public function show($id)
    {
        $room = Room::findOrFail($id);
        return view('rooms.show', compact('room'));
    }

    public function book(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        
        $request->validate([
            'check_in_date' => 'required|date|after:today',
            'check_out_date' => 'required|date|after:check_in_date',
        ], [
            'check_in_date.after' => 'Check-in date must be in the future.',
            'check_out_date.after' => 'Check-out date must be after check-in date.',
        ]);

        // Check if the room is available for the selected dates
        $conflictingBookings = Booking::where('room_id', $room->id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('check_in_date', [$request->check_in_date, $request->check_out_date])
                    ->orWhereBetween('check_out_date', [$request->check_in_date, $request->check_out_date])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('check_in_date', '<=', $request->check_in_date)
                            ->where('check_out_date', '>=', $request->check_out_date);
                    });
            })
            ->exists();

        if ($conflictingBookings) {
            return redirect()->back()
                ->withErrors(['check_in_date' => 'This room is not available for the selected dates.'])
                ->withInput();
        }

        // Create the booking
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
        ]);

        return redirect()->route('home')
            ->with('success', 'Booking created successfully! Your room has been reserved.');
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date|after:today',
            'check_out_date' => 'required|date|after:check_in_date',
        ]);

        $room = Room::findOrFail($request->room_id);
        
        $conflictingBookings = Booking::where('room_id', $room->id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('check_in_date', [$request->check_in_date, $request->check_out_date])
                    ->orWhereBetween('check_out_date', [$request->check_in_date, $request->check_out_date])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('check_in_date', '<=', $request->check_in_date)
                            ->where('check_out_date', '>=', $request->check_out_date);
                    });
            })
            ->exists();

        return response()->json([
            'available' => !$conflictingBookings,
            'message' => $conflictingBookings ? 'Room is not available for selected dates.' : 'Room is available for selected dates.'
        ]);
    }
} 