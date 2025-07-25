<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MenuService;
use App\Models\FerrySchedule;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    // hotel dashboard

    public function hotelDashboard()
    {
        $menuItems = $this->menuService->getHotelMenu();
        return view('hotel.dashboard', compact('menuItems'));
    }
    
    // ferry operator dashboard

    public function ferryOperatorDashboard()
    {
        $menuItems = $this->menuService->getFerryOperatorMenu();
        return view('ferry.dashboard', compact('menuItems'));
    }

    public function ferrySchedules()
    {
        $menuItems = $this->menuService->getFerryOperatorMenu();
        $schedules = FerrySchedule::orderBy('created_at', 'desc')->paginate(10);
        return view('ferry.schedules.index', compact('menuItems', 'schedules'));
    }

    public function createFerrySchedule()
    {
        $menuItems = $this->menuService->getFerryOperatorMenu();
        return view('ferry.schedules.create', compact('menuItems'));
    }

    public function storeFerrySchedule(Request $request)
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
}
