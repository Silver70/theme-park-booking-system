<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MenuService;
use App\Models\FerrySchedule;
use App\Models\FerryTicket;
use Illuminate\Support\Facades\Auth;

class FerryScheduleController extends Controller
{
    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function index()
    {
        $menuItems = $this->menuService->getFerryOperatorMenu();
        $schedules = FerrySchedule::orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Add fresh capacity data to each schedule
        $schedules->getCollection()->transform(function ($schedule) {
            $ticketCount = FerryTicket::where('ferry_schedule_id', $schedule->id)->count();
            $schedule->fresh_tickets_issued = $ticketCount;
            $schedule->fresh_remaining_capacity = $schedule->seats_available - $ticketCount;
            $schedule->fresh_capacity_display = $ticketCount . '/' . $schedule->seats_available;
            $schedule->fresh_is_full = $ticketCount >= $schedule->seats_available;
            return $schedule;
        });
        
        return view('ferry.schedules.index', compact('menuItems', 'schedules'));
    }

    public function publicIndex()
    {
        $schedules = FerrySchedule::whereNull('cancelled_at')
            ->where('departure_time', '>', now())
            ->orderBy('departure_time')
            ->paginate(12);
        
        // Add fresh capacity data to each schedule
        $schedules->getCollection()->transform(function ($schedule) {
            $ticketCount = FerryTicket::where('ferry_schedule_id', $schedule->id)->count();
            $schedule->fresh_tickets_issued = $ticketCount;
            $schedule->fresh_remaining_capacity = $schedule->seats_available - $ticketCount;
            $schedule->fresh_capacity_display = $ticketCount . '/' . $schedule->seats_available;
            $schedule->fresh_is_full = $ticketCount >= $schedule->seats_available;
            return $schedule;
        });
        
        return view('schedules.index', compact('schedules'));
    }

    public function create()
    {
        $menuItems = $this->menuService->getFerryOperatorMenu();
        return view('ferry.schedules.create', compact('menuItems'));
    }

    public function store(Request $request)
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

    public function edit($id)
    {
        $menuItems = $this->menuService->getFerryOperatorMenu();
        $schedule = FerrySchedule::findOrFail($id);
        return view('ferry.schedules.edit', compact('menuItems', 'schedule'));
    }

    public function update(Request $request, $id)
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
    
    public function cancel($id)
    {
        $schedule = FerrySchedule::findOrFail($id);
        $schedule->cancelled_at = now();
        $schedule->save();
        return redirect()->route('ferry.schedules')->with('success', 'Ferry schedule cancelled successfully!');
    }
}
