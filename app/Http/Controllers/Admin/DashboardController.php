<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\Booking;
use App\Models\Customer; // Changed from CarRentalUser
use App\Models\Maintenance;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $stats = $this->getStatistics();

        // Get recent bookings
        $recentBookings = Booking::with(['customer', 'vehicle'])  // Changed from 'user' to 'customer'
            ->orderBy('BookingDate', 'desc')
            ->limit(5)
            ->get();

        // Get vehicles in maintenance
        $maintenanceVehicles = Vehicle::whereHas('maintenanceRecords', function($query) {
            $query->where('Status', 'In Progress');
        })->with(['maintenanceRecords' => function($query) {
            $query->where('Status', 'In Progress')
                  ->orderBy('StartDate', 'desc');
        }])->limit(5)->get();

        // Get monthly revenue data for the chart
        $monthlyRevenue = $this->getMonthlyRevenue();

        return view('admin.dashboard.index', compact(
            'stats',
            'recentBookings',
            'maintenanceVehicles',
            'monthlyRevenue'
        ));
    }

    private function getStatistics()
    {
        $now = Carbon::now();
        $monthStart = $now->copy()->startOfMonth();
        $monthEnd = $now->copy()->endOfMonth();

        // Get vehicles currently being rented (based on booking dates)
        $rentedVehicleIds = Booking::where('Status', 'Confirmed')
            ->where('PickupDate', '<=', $now)
            ->where('ReturnDate', '>=', $now)
            ->pluck('VehicleID');

        return [
            'total_vehicles' => Vehicle::count(),
            'available_vehicles' => Vehicle::where('Status', 'Available')
                                        ->whereNotIn('VehicleID', $rentedVehicleIds)
                                        ->count(),
            'rented_vehicles' => $rentedVehicleIds->count(),
            'maintenance_vehicles' => Vehicle::where('Status', 'Maintenance')->count(),
            'active_bookings' => Booking::whereBetween('PickupDate', [$monthStart, $monthEnd])
                ->where('Status', 'Confirmed')
                ->count(),
            'total_customers' => Customer::where('AccountStatus', 'Active')->count(), // Changed from CarRentalUser
            'monthly_revenue' => Booking::whereBetween('BookingDate', [$monthStart, $monthEnd])
                ->where('Status', '!=', 'Cancelled')
                ->sum('TotalCost'),
        ];
    }

    private function getMonthlyRevenue()
    {
        return DB::table('bookings')
            ->select(
                DB::raw('DATE_FORMAT(BookingDate, "%b %Y") as month'),
                DB::raw('SUM(TotalCost) as total')
            )
            ->where('Status', '!=', 'Cancelled')
            ->whereDate('BookingDate', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('BookingDate', 'asc')
            ->get();
    }
}
