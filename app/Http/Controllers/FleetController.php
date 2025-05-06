<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Office;
use Illuminate\Http\Request;

class FleetController extends Controller
{
    public function index(Request $request)
    {
        // Require rental period
        if (!$request->filled(['pickup_date', 'return_date'])) {
            return view('fleet', [
                'vehicles' => Vehicle::where('VehicleID', 0)->paginate(10), // Empty paginated result
                'offices' => Office::all(),
                'categories' => ['Small Cars', 'Sedan', 'SUV & Crossover'],
                'requireDates' => true
            ]);
        }

        $query = Vehicle::query();
        
        // Filter out vehicles with overlapping bookings
        $query->whereDoesntHave('bookings', function($query) use ($request) {
            $query->where('Status', '!=', 'Cancelled')
                  ->where(function($q) use ($request) {
                      $q->whereBetween('PickupDate', [$request->pickup_date, $request->return_date])
                        ->orWhereBetween('ReturnDate', [$request->pickup_date, $request->return_date])
                        ->orWhere(function($q) use ($request) {
                            $q->where('PickupDate', '<=', $request->pickup_date)
                              ->where('ReturnDate', '>=', $request->return_date);
                        });
                  });
        });

        // Category filter
        if ($request->filled('category')) {
            if ($request->category === 'SUV & Crossover') {
                $query->whereIn('Category', ['SUV', 'Crossover']);
            } else {
                $query->where('Category', $request->category);
            }
        }
        
        // Location filter
        if ($request->filled('pickup_location')) {
            $query->where('OfficeID', $request->pickup_location);
        }

        // Price range filter
        if ($request->filled('min_price')) {
            $query->where('DailyRate', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('DailyRate', '<=', $request->max_price);
        }

        // Date availability filter
        if ($request->filled('pickup_date') && $request->filled('return_date')) {
            $query->whereDoesntHave('bookings', function($query) use ($request) {
                $query->where('Status', '!=', 'Cancelled')
                    ->where(function($q) use ($request) {
                        $q->whereBetween('PickupDate', [$request->pickup_date, $request->return_date])
                          ->orWhereBetween('ReturnDate', [$request->pickup_date, $request->return_date])
                          ->orWhere(function($q) use ($request) {
                              $q->where('PickupDate', '<=', $request->pickup_date)
                                ->where('ReturnDate', '>=', $request->return_date);
                          });
                    });
            });
        }

        // Sort options
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('DailyRate', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('DailyRate', 'desc');
                    break;
                default:
                    $query->orderBy('Make')->orderBy('Model');
            }
        } else {
            $query->orderBy('Make')->orderBy('Model');
        }

        // Only show available vehicles
        $query->where('Status', 'Available');

        $vehicles = $query->with('office')->paginate(10);
        $offices = Office::all();
        $categories = ['Small Cars', 'Sedan', 'SUV & Crossover'];

        return view('fleet', compact('vehicles', 'offices', 'categories'));
    }

    public function checkAvailability(Request $request)
    {
        $vehicle = Vehicle::find($request->vehicle_id);
        
        if (!$vehicle) {
            return response()->json(['available' => false, 'message' => 'Vehicle not found']);
        }

        $isAvailable = !$vehicle->bookings()
            ->where('Status', '!=', 'Cancelled')
            ->where(function($query) use ($request) {
                $query->whereBetween('PickupDate', [$request->pickup_date, $request->return_date])
                      ->orWhereBetween('ReturnDate', [$request->pickup_date, $request->return_date])
                      ->orWhere(function($q) use ($request) {
                          $q->where('PickupDate', '<=', $request->pickup_date)
                            ->where('ReturnDate', '>=', $request->return_date);
                      });
            })
            ->exists();

        return response()->json([
            'available' => $isAvailable,
            'message' => $isAvailable ? 'Vehicle is available' : 'Vehicle is not available for selected dates'
        ]);
    }

    public function bookNow(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        
        // Get dates from all possible request parameters (query string, post data, etc)
        $pickup_date = $request->pickup_date ?: $request->query('pickup_date');
        $return_date = $request->return_date ?: $request->query('return_date');

        // Validate dates exist
        if (!$pickup_date || !$return_date) {
            return redirect()->route('fleet')
                ->with('error', 'Please select rental dates first');
        }

        // Format dates to ensure consistency
        $pickup_date = date('Y-m-d', strtotime($pickup_date));
        $return_date = date('Y-m-d', strtotime($return_date));
        
        return view('user.bookings.create', compact('vehicle', 'pickup_date', 'return_date'));
    }
}
