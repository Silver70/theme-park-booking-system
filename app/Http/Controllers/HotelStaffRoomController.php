<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MenuService;
use App\Models\Room;

class HotelStaffRoomController extends Controller
{
    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function index()
    {
        $menuItems = $this->menuService->getHotelStaffMenu();
        $rooms = Room::paginate(15);
        return view('hotelstaff.rooms.index', compact('menuItems', 'rooms'));
    }

    public function create()
    {
        $menuItems = $this->menuService->getHotelStaffMenu();
        return view('hotelstaff.rooms.create', compact('menuItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);
        Room::create($request->only(['name', 'description', 'image', 'price']));
        return redirect()->route('hotelstaff.rooms.index')->with('success', 'Room created successfully.');
    }

    public function edit($id)
    {
        $menuItems = $this->menuService->getHotelStaffMenu();
        $room = Room::findOrFail($id);
        return view('hotelstaff.rooms.edit', compact('menuItems', 'room'));
    }

    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);
        $room->update($request->only(['name', 'description', 'image', 'price']));
        return redirect()->route('hotelstaff.rooms.index')->with('success', 'Room updated successfully.');
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();
        return redirect()->route('hotelstaff.rooms.index')->with('success', 'Room deleted successfully.');
    }
} 