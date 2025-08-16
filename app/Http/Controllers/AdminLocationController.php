<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Services\MenuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminLocationController extends Controller
{
    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function index()
    {
        $menuItems = $this->menuService->getAdminMenu();
        $locations = Location::ordered()->get();
        
        return view('admin.locations.index', compact('menuItems', 'locations'));
    }

    public function create()
    {
        $menuItems = $this->menuService->getAdminMenu();
        return view('admin.locations.create', compact('menuItems'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'type' => 'required|in:resort,restaurant,activity,point_of_interest,transport',
            'icon_color' => 'required|string|regex:/^#[0-9A-F]{6}$/i',
            'is_active' => 'boolean',
            'display_order' => 'integer|min:0',
        ]);

        Location::create($validated);

        return redirect()->route('admin.locations.index')->with('success', 'Location added successfully!');
    }

    public function edit(Location $location)
    {
        $menuItems = $this->menuService->getAdminMenu();
        return view('admin.locations.edit', compact('menuItems', 'location'));
    }

    public function update(Request $request, Location $location)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'type' => 'required|in:resort,restaurant,activity,point_of_interest,transport',
            'icon_color' => 'required|string|regex:/^#[0-9A-F]{6}$/i',
            'is_active' => 'boolean',
            'display_order' => 'integer|min:0',
        ]);

        $location->update($validated);

        return redirect()->route('admin.locations.index')->with('success', 'Location updated successfully!');
    }

    public function destroy(Location $location)
    {
        $location->delete();

        return redirect()->route('admin.locations.index')->with('success', 'Location deleted successfully!');
    }

    public function toggleStatus(Location $location)
    {
        $location->update(['is_active' => !$location->is_active]);
        
        $status = $location->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "Location {$status} successfully!");
    }
}
