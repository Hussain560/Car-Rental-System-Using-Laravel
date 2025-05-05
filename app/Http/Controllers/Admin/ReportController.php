<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function revenue(Request $request)
    {
        $query = Booking::where('Status', 'Completed');

        if ($request->has('date_from') && $request->has('date_to')) {
            $query->whereBetween('BookingDate', [$request->date_from, $request->date_to]);
        }

        $revenue = $query->sum('TotalCost');
        $bookings = $query->count();

        $monthlyRevenue = Booking::where('Status', 'Completed')
            ->select(DB::raw('MONTH(BookingDate) as month'), DB::raw('SUM(TotalCost) as total'))
            ->groupBy('month')
            ->get();

        return view('admin.reports.revenue', compact('revenue', 'bookings', 'monthlyRevenue'));
    }

    public function vehicleUtilization()
    {
        $vehicles = Vehicle::withCount(['bookings' => function($query) {
            $query->where('Status', 'Completed');
        }])
        ->with(['maintenanceRecords' => function($query) {
            $query->where('Status', 'Completed');
        }])
        ->get();

        $utilization = $vehicles->map(function($vehicle) {
            $totalDays = now()->diffInDays($vehicle->created_at);
            $rentedDays = $vehicle->bookings->sum(function($booking) {
                return \Carbon\Carbon::parse($booking->PickupDate)
                    ->diffInDays($booking->ReturnDate);
            });
            $maintenanceDays = $vehicle->maintenanceRecords->sum(function($maintenance) {
                return \Carbon\Carbon::parse($maintenance->StartDate)
                    ->diffInDays($maintenance->EndDate);
            });
            
            return [
                'vehicle' => $vehicle,
                'utilization_rate' => $totalDays > 0 ? ($rentedDays / $totalDays) * 100 : 0,
                'maintenance_rate' => $totalDays > 0 ? ($maintenanceDays / $totalDays) * 100 : 0
            ];
        });

        return view('admin.reports.utilization', compact('utilization'));
    }

    public function maintenanceCosts()
    {
        $totalCosts = Maintenance::where('Status', 'Completed')
            ->select('VehicleID', DB::raw('SUM(Cost) as total_cost'))
            ->groupBy('VehicleID')
            ->with('vehicle')
            ->get();

        $monthlyDistribution = Maintenance::where('Status', 'Completed')
            ->select(DB::raw('MONTH(StartDate) as month'), DB::raw('SUM(Cost) as total'))
            ->groupBy('month')
            ->get();

        return view('admin.reports.maintenance', compact('totalCosts', 'monthlyDistribution'));
    }

    public function exportReports(Request $request)
    {
        $type = $request->input('type', 'revenue');
        
        // Implementation for exporting reports based on type
        // Could use Laravel Excel or other export libraries
        
        return response()->download('report.csv');
    }
}
