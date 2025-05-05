<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VehicleController extends Controller
{
    private function handleImageUpload($image, $vehicle, $oldImagePath = null)
    {
        if ($oldImagePath) {
            $imagePath = str_replace('storage/', '', $oldImagePath);
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        $fileName = Str::slug($vehicle['make'] . '-' . $vehicle['model'] . '-' . $vehicle['year']) 
            . '-' . time() . '.' . $image->getClientOriginalExtension();
        
        $path = $image->storeAs('images/vehicles', $fileName, 'public');
        return 'storage/' . $path;
    }

    private function removeImage($imagePath)
    {
        if ($imagePath) {
            // Remove from storage disk
            $path = str_replace('storage/', '', $imagePath);
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            
            // Also check and remove the physical file if it exists
            $fullPath = public_path($imagePath);
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }
    }

    public function index(Request $request)
    {
        $query = Vehicle::with('office');

        // Filter by category
        if ($request->filled('category')) {
            $query->where('Category', $request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('Status', $request->status);
        }

        // Filter by office location
        if ($request->filled('office_id')) {
            $query->where('OfficeID', $request->office_id);
        }

        $vehicles = $query->paginate(10)->withQueryString(); // Show 10 vehicles per page and include query params in pagination links
        $offices = Office::all();
        
        return view('admin.vehicles.index', compact('vehicles', 'offices'));
    }

    public function create()
    {
        $offices = Office::all();
        return view('admin.vehicles.create', compact('offices'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'make' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'year' => 'required|integer',
            'license_plate' => 'required|string|max:7|unique:vehicles,LicensePlate',
            'serial_number' => 'nullable|string|max:50',
            'date_of_expiry' => 'nullable|date',
            'color' => 'nullable|string|max:30',
            'category' => 'required|in:Sedan,SUV,Crossover,Small Cars',
            'status' => 'required|in:Available,Rented,Maintenance',
            'image_path' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
            'daily_rate' => 'nullable|numeric',
            'office_id' => 'nullable|exists:offices,OfficeID',
            'passenger_capacity' => 'required|integer|min:1',
            'luggage_capacity' => 'required|integer|min:0',
            'doors' => 'required|integer|min:2'
        ]);

        // Create data array for vehicle with proper column names
        $vehicleData = [
            'Make' => $validated['make'],
            'Model' => $validated['model'],
            'Year' => $validated['year'],
            'LicensePlate' => $validated['license_plate'],
            'SerialNumber' => $validated['serial_number'],
            'DateOfExpiry' => $validated['date_of_expiry'],
            'Color' => $validated['color'],
            'Category' => $validated['category'],
            'Status' => $validated['status'],
            'DailyRate' => $validated['daily_rate'],
            'OfficeID' => $validated['office_id'],
            'PassengerCapacity' => $validated['passenger_capacity'],
            'LuggageCapacity' => $validated['luggage_capacity'],
            'Doors' => $validated['doors']
        ];

        // Handle image upload
        if ($request->hasFile('image_path')) {
            $vehicleData['ImagePath'] = $this->handleImageUpload(
                $request->file('image_path'),
                [
                    'make' => $validated['make'],
                    'model' => $validated['model'],
                    'year' => $validated['year']
                ]
            );
        }

        // Create the vehicle
        Vehicle::create($vehicleData);

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Vehicle created successfully');
    }

    public function edit(Vehicle $vehicle)
    {
        $offices = Office::all();
        return view('admin.vehicles.edit', compact('vehicle', 'offices'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'make' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'year' => 'required|integer',
            'license_plate' => 'required|string|max:7|unique:vehicles,LicensePlate,'.$vehicle->VehicleID.',VehicleID',
            'serial_number' => 'nullable|string|max:50',
            'date_of_expiry' => 'nullable|date',
            'color' => 'nullable|string|max:30',
            'category' => 'required|in:Sedan,SUV,Crossover,Small Cars',
            'status' => 'required|in:Available,Rented,Maintenance',
            'image_path' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
            'daily_rate' => 'nullable|numeric',
            'office_id' => 'nullable|exists:offices,OfficeID',
            'passenger_capacity' => 'required|integer|min:1',
            'luggage_capacity' => 'required|integer|min:0',
            'doors' => 'required|integer|min:2'
        ]);

        // Create data array for vehicle with proper column names
        $vehicleData = [
            'Make' => $validated['make'],
            'Model' => $validated['model'],
            'Year' => $validated['year'],
            'LicensePlate' => $validated['license_plate'],
            'SerialNumber' => $validated['serial_number'],
            'DateOfExpiry' => $validated['date_of_expiry'],
            'Color' => $validated['color'],
            'Category' => $validated['category'],
            'Status' => $validated['status'],
            'DailyRate' => $validated['daily_rate'],
            'OfficeID' => $validated['office_id'],
            'PassengerCapacity' => $validated['passenger_capacity'],
            'LuggageCapacity' => $validated['luggage_capacity'],
            'Doors' => $validated['doors']
        ];

        // Handle image upload
        if ($request->hasFile('image_path')) {
            $vehicleData['ImagePath'] = $this->handleImageUpload(
                $request->file('image_path'),
                [
                    'make' => $validated['make'],
                    'model' => $validated['model'],
                    'year' => $validated['year']
                ],
                $vehicle->ImagePath
            );
        }

        // Update the vehicle
        $vehicle->update($vehicleData);

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Vehicle updated successfully');
    }

    public function destroy(Vehicle $vehicle)
    {
        try {
            \DB::beginTransaction();

            // Remove the vehicle image
            $this->removeImage($vehicle->ImagePath);

            // Delete the vehicle
            $vehicle->delete();

            \DB::commit();
            return redirect()->route('admin.vehicles.index')
                ->with('success', 'Vehicle deleted successfully');

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Vehicle deletion failed: ' . $e->getMessage());
            return redirect()->route('admin.vehicles.index')
                ->with('error', 'Error deleting vehicle: ' . $e->getMessage());
        }
    }

    public function show(Vehicle $vehicle)
    {
        return view('admin.vehicles.show', compact('vehicle'));
    }
}
