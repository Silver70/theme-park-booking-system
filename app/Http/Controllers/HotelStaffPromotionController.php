<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MenuService;
use App\Models\Promotion;

class HotelStaffPromotionController extends Controller
{
    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function index()
    {
        $menuItems = $this->menuService->getHotelStaffMenu();
        $promotions = Promotion::paginate(15);
        return view('hotelstaff.promotions.index', compact('menuItems', 'promotions'));
    }

    public function create()
    {
        $menuItems = $this->menuService->getHotelStaffMenu();
        return view('hotelstaff.promotions.create', compact('menuItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'discount' => 'required|numeric|min:0|max:100',
        ]);
        Promotion::create($request->only(['title', 'description', 'start_date', 'end_date', 'discount']));
        return redirect()->route('hotelstaff.promotions.index')->with('success', 'Promotion created successfully.');
    }

    public function edit($id)
    {
        $menuItems = $this->menuService->getHotelStaffMenu();
        $promotion = Promotion::findOrFail($id);
        return view('hotelstaff.promotions.edit', compact('menuItems', 'promotion'));
    }

    public function update(Request $request, $id)
    {
        $promotion = Promotion::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'discount' => 'required|numeric|min:0|max:100',
        ]);
        $promotion->update($request->only(['title', 'description', 'start_date', 'end_date', 'discount']));
        return redirect()->route('hotelstaff.promotions.index')->with('success', 'Promotion updated successfully.');
    }

    public function destroy($id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->delete();
        return redirect()->route('hotelstaff.promotions.index')->with('success', 'Promotion deleted successfully.');
    }
} 