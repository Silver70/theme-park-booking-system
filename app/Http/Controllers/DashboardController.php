<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MenuService;

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
}
