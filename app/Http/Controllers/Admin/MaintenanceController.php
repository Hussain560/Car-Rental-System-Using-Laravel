<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenances = Maintenance::with('vehicle')->latest()->paginate(10);
        return view('admin.maintenance.index', compact('maintenances'));
    }

    public function create()
    {
        $vehicles = Vehicle::where('Status', '!=', 'Maintenance')->get();
        return view('admin.maintenance.create', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,VehicleID',
            'maintenance_type' => 'required|string|max:100',
            'start_date' => [
                'required',
                'date',
                'after_or_equal:today',
                function ($attribute, $value, $fail) {
                    if (strtotime($value) < strtotime('today midnight')) {
                        $fail('The start date cannot be in the past.');
                    }
                },
            ],
            'end_date' => [
                'required',
                'date',
                'after_or_equal:start_date',
                function ($attribute, $value, $fail) use ($request) {
                    if (strtotime($value) < strtotime($request->start_date)) {
                        $fail('The end date must be after or equal to the start date.');
                    }
                },
            ],
            'description' => 'required|string',
            'cost' => 'required|numeric|min:1',
            'status' => 'required|in:Scheduled,In Progress,Completed'
        ], [
            'end_date.after_or_equal' => 'The end date must be equal to or after the start date',
            'start_date.after_or_equal' => 'The start date cannot be in the past',
            'cost.min' => 'The cost must be at least 1 SAR'
        ]);

        \DB::beginTransaction();

        try {
            $maintenance = Maintenance::create([
                'VehicleID' => $validated['vehicle_id'],
                'MaintenanceType' => $validated['maintenance_type'],
                'StartDate' => $validated['start_date'],
                'EndDate' => $validated['end_date'],
                'Description' => $validated['description'],
                'Cost' => $validated['cost'],
                'Status' => $validated['status'],
            ]);

            // Update vehicle status based on maintenance dates
            $this->updateVehicleStatus(
                $validated['vehicle_id'],
                $validated['start_date'],
                $validated['end_date'],
                $validated['status']
            );

            \DB::commit();

            return redirect()->route('admin.maintenance.index')
                ->with('success', 'Maintenance record created successfully');
        } catch (\Exception $e) {
            \DB::rollback();
            return back()->with('error', 'Error creating maintenance record: ' . $e->getMessage());
        }
    }

    public function edit(Maintenance $maintenance)
    {
        $vehicles = Vehicle::all();
        return view('admin.maintenance.edit', compact('maintenance', 'vehicles'));
    }

    public function update(Request $request, Maintenance $maintenance)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,VehicleID',
            'maintenance_type' => 'required|string|max:100',
            'start_date' => [
                'required',
                'date',
            ],
            'end_date' => [
                'required',
                'date',
                'after_or_equal:start_date',
            ],
            'description' => 'required|string',
            'cost' => 'required|numeric|min:1',
            'status' => 'required|in:Scheduled,In Progress,Completed'
        ]);

        \DB::beginTransaction();

        try {
            $maintenance->update([
                'VehicleID' => $validated['vehicle_id'],
                'MaintenanceType' => $validated['maintenance_type'],
                'StartDate' => $validated['start_date'],
                'EndDate' => $validated['end_date'],
                'Description' => $validated['description'],
                'Cost' => $validated['cost'],
                'Status' => $validated['status'],
            ]);

            // Update vehicle status based on maintenance dates
            $this->updateVehicleStatus(
                $validated['vehicle_id'],
                $validated['start_date'],
                $validated['end_date'],
                $validated['status']
            );

            \DB::commit();
            return redirect()->route('admin.maintenance.index')
                ->with('success', 'Maintenance record updated successfully');
        } catch (\Exception $e) {
            \DB::rollback();
            return back()->with('error', 'Error updating maintenance record: ' . $e->getMessage());
        }
    }

    private function updateVehicleStatus($vehicleId, $startDate, $endDate, $maintenanceStatus = null)
    {
        $vehicle = Vehicle::find($vehicleId);

        // If maintenance is completed, set vehicle to Available
        if ($maintenanceStatus === 'Completed') {
            $vehicle->update(['Status' => 'Available']);
            return;
        }

        $now = Carbon::now();
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);
        
        if ($now->between($startDate, $endDate)) {
            $vehicle->update(['Status' => 'Maintenance']);
        } else if ($now->lessThan($startDate)) {
            $vehicle->update(['Status' => 'Available']);
        }
    }
}
