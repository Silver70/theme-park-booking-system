<?php

namespace App\Http\Controllers;

use App\Models\DashboardImage;
use App\Services\MenuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminDashboardImageController extends Controller
{
    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function index()
    {
        $menuItems = $this->menuService->getAdminMenu();
        $images = DashboardImage::orderBy('display_position')
            ->orderBy('display_order')
            ->get()
            ->groupBy('display_position');
        
        return view('admin.dashboard-images.index', compact('menuItems', 'images'));
    }

    public function create()
    {
        $menuItems = $this->menuService->getAdminMenu();
        return view('admin.dashboard-images.create', compact('menuItems'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'display_position' => 'required|in:top,middle,bottom',
            'display_order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $imagePath = $request->file('image')->store('dashboard-images', 'public');

        DashboardImage::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
            'display_position' => $request->display_position,
            'display_order' => $request->display_order,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.dashboard-images.index')
            ->with('success', 'Dashboard image uploaded successfully!');
    }

    public function edit(DashboardImage $dashboardImage)
    {
        $menuItems = $this->menuService->getAdminMenu();
        return view('admin.dashboard-images.edit', compact('menuItems', 'dashboardImage'));
    }

    public function update(Request $request, DashboardImage $dashboardImage)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'display_position' => 'required|in:top,middle,bottom',
            'display_order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'display_position' => $request->display_position,
            'display_order' => $request->display_order,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            if ($dashboardImage->image_path) {
                Storage::disk('public')->delete($dashboardImage->image_path);
            }
            $data['image_path'] = $request->file('image')->store('dashboard-images', 'public');
        }

        $dashboardImage->update($data);

        return redirect()->route('admin.dashboard-images.index')
            ->with('success', 'Dashboard image updated successfully!');
    }

    public function destroy(DashboardImage $dashboardImage)
    {
        if ($dashboardImage->image_path) {
            Storage::disk('public')->delete($dashboardImage->image_path);
        }
        
        $dashboardImage->delete();

        return redirect()->route('admin.dashboard-images.index')
            ->with('success', 'Dashboard image deleted successfully!');
    }

    public function toggleStatus(DashboardImage $dashboardImage)
    {
        $dashboardImage->update([
            'is_active' => !$dashboardImage->is_active
        ]);

        $status = $dashboardImage->is_active ? 'activated' : 'deactivated';
        return redirect()->back()
            ->with('success', "Dashboard image {$status} successfully!");
    }
}
