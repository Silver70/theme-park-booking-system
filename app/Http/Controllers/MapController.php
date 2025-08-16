<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        $locations = Location::active()->ordered()->get();
        
        return view('map.index', compact('locations'));
    }
}
