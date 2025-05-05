<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Office;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured vehicles (newest 5 available vehicles)
        $featuredVehicles = Vehicle::where('Status', 'Available')
            ->latest()
            ->take(5)
            ->get();
            
        // Get office locations
        $offices = Office::all();
        
        // Get unique vehicle categories
        $categories = Vehicle::select('Category')
            ->distinct()
            ->pluck('Category');
            
        return view('home', compact('featuredVehicles', 'offices', 'categories'));
    }
}
