@extends('admin.layouts.dashboard-app')

@section('content')
<!-- Quick Navigation Cards -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 bg-light-subtle">
            <div class="card-body">
                <h5 class="card-title">Navigation</h5>
                <div class="row g-3">
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="{{ route('admin.vehicles.index') }}" class="text-decoration-none">
                            <div class="card dashboard-nav-card text-center h-100 py-3">
                                <div class="card-body p-2">
                                    <i class="bi bi-car-front-fill fs-3 text-primary mb-2"></i>
                                    <h6 class="mb-0">Vehicles</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="{{ route('admin.maintenance.index') }}" class="text-decoration-none">
                            <div class="card dashboard-nav-card text-center h-100 py-3">
                                <div class="card-body p-2">
                                    <i class="bi bi-tools fs-3 text-secondary mb-2"></i>
                                    <h6 class="mb-0">Maintenance</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="{{ route('admin.bookings.index') }}" class="text-decoration-none">
                            <div class="card dashboard-nav-card text-center h-100 py-3">
                                <div class="card-body p-2">
                                    <i class="bi bi-calendar2-check fs-3 text-success mb-2"></i>
                                    <h6 class="mb-0">Bookings</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="{{ route('admin.customers.index') }}" class="text-decoration-none">
                            <div class="card dashboard-nav-card text-center h-100 py-3">
                                <div class="card-body p-2">
                                    <i class="bi bi-people-fill fs-3 text-info mb-2"></i>
                                    <h6 class="mb-0">Customers</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    
                    @if(Auth::guard('admin')->user()->Role === 'Manager')
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="{{ route('admin.employees.index') }}" class="text-decoration-none">
                            <div class="card dashboard-nav-card text-center h-100 py-3">
                                <div class="card-body p-2">
                                    <i class="bi bi-person-badge-fill fs-3 text-dark mb-2"></i>
                                    <h6 class="mb-0">Employees</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="{{ route('admin.offices.index') }}" class="text-decoration-none">
                            <div class="card dashboard-nav-card text-center h-100 py-3">
                                <div class="card-body p-2">
                                    <i class="bi bi-building fs-3 text-warning mb-2"></i>
                                    <h6 class="mb-0">Offices</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="{{ route('admin.reports.index') }}" class="text-decoration-none">
                            <div class="card dashboard-nav-card text-center h-100 py-3">
                                <div class="card-body p-2">
                                    <i class="bi bi-graph-up fs-3 text-danger mb-2"></i>
                                    <h6 class="mb-0">Reports</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Page Header -->
<div class="page-header mb-4">
    <h1 class="page-title">Dashboard Overview</h1>
    <p class="text-muted">Welcome back, {{ Auth::guard('admin')->user()->FirstName }}!</p>
</div>

<!-- Statistics Cards Row -->
<div class="row g-4 mb-4">
    <!-- Total Vehicles Card -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar avatar-lg bg-primary-subtle">
                            <i class="bi bi-car-front-fill fs-4"></i>
                        </div>
                    </div>
                    <div>
                        <h6 class="card-title mb-0">Total Vehicles</h6>
                        <h2 class="mb-0">{{ $stats['total_vehicles'] }}</h2>
                        <small class="text-muted">{{ $stats['available_vehicles'] }} Available</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Bookings Card -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar avatar-lg bg-success-subtle">
                            <i class="bi bi-calendar2-check fs-4"></i>
                        </div>
                    </div>
                    <div>
                        <h6 class="card-title mb-0">Active Bookings</h6>
                        <h2 class="mb-0">{{ $stats['active_bookings'] }}</h2>
                        <small class="text-muted">This month</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Customers Card -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar avatar-lg bg-info-subtle">
                            <i class="bi bi-people-fill fs-4"></i>
                        </div>
                    </div>
                    <div>
                        <h6 class="card-title mb-0">Total Customers</h6>
                        <h2 class="mb-0">{{ $stats['total_customers'] }}</h2>
                        <small class="text-muted">Active accounts</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Card -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar avatar-lg bg-warning-subtle">
                            <i class="bi bi-currency-dollar fs-4"></i>
                        </div>
                    </div>
                    <div>
                        <h6 class="card-title mb-0">Monthly Revenue</h6>
                        <h2 class="mb-0"><x-currency :amount="$stats['monthly_revenue']" /></h2>
                        <small class="text-muted">This month</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-4 mb-4">
    <!-- Revenue Chart -->
    <div class="col-12 col-xl-8">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Revenue Overview</h5>
            </div>
            <div class="card-body">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Vehicle Utilization -->
    <div class="col-12 col-xl-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Vehicle Utilization</h5>
            </div>
            <div class="card-body">
                <canvas id="utilizationChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity and Maintenance -->
<div class="row g-4">
    <!-- Recent Bookings -->
    <div class="col-12 col-xl-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Recent Bookings</h5>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Customer</th>
                            <th>Vehicle</th>
                            <th>Pickup Date</th>
                            <th>Status</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentBookings as $booking)
                        <tr>
                            <td>#{{ $booking->BookingID }}</td>
                            <td>{{ $booking->customer->FirstName }} {{ $booking->customer->LastName }}</td>
                            <td>{{ $booking->vehicle->Make }} {{ $booking->vehicle->Model }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->PickupDate)->format('M d, Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $booking->Status === 'Pending' ? 'warning' : ($booking->Status === 'Confirmed' ? 'success' : ($booking->Status === 'Completed' ? 'info' : 'danger')) }}">
                                    {{ $booking->Status }}
                                </span>
                            </td>
                            <td><x-currency :amount="$booking->TotalCost" /></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Maintenance Status -->
    <div class="col-12 col-xl-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Vehicles in Maintenance</h5>
                <a href="{{ route('admin.maintenance.index') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body">
                @foreach($maintenanceVehicles as $vehicle)
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-shrink-0">
                        <div class="avatar avatar-sm bg-light">
                            <i class="bi bi-tools text-secondary"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p class="mb-0">{{ $vehicle->Make }} {{ $vehicle->Model }}</p>
                        <small class="text-muted">Since {{ \Carbon\Carbon::parse($vehicle->maintenanceRecords->first()->StartDate)->format('M d, Y') }}</small>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="badge bg-warning">In Progress</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.dashboard-nav-card {
    transition: all 0.2s ease;
    border: 1px solid rgba(0,0,0,.125);
}
.dashboard-nav-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}
.avatar {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 0.5rem;
}

.avatar-sm {
    width: 32px;
    height: 32px;
}

.avatar-lg {
    width: 56px;
    height: 56px;
}

.bg-primary-subtle { background-color: rgba(13, 110, 253, 0.1); }
.bg-success-subtle { background-color: rgba(25, 135, 84, 0.1); }
.bg-info-subtle { background-color: rgba(13, 202, 240, 0.1); }
.bg-warning-subtle { background-color: rgba(255, 193, 7, 0.1); }
.bg-light-subtle { background-color: rgba(248, 249, 250, 0.3); }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript">
// Pre-define the PHP variables as JavaScript variables
const availableVehicles = {{ $stats['available_vehicles'] ?? 0 }};
const rentedVehicles = {{ $stats['rented_vehicles'] ?? 0 }};
const maintenanceVehicles = {{ $stats['maintenance_vehicles'] ?? 0 }};

document.addEventListener('DOMContentLoaded', function() {
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const monthlyLabels = @json($monthlyRevenue->pluck("month"));
    const monthlyData = @json($monthlyRevenue->pluck("total"));
    
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Revenue',
                data: monthlyData,
                borderColor: '#0d6efd',
                tension: 0.3,
                fill: true,
                backgroundColor: 'rgba(13, 110, 253, 0.1)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: (context) => {
                            const value = context.parsed.y;
                            return 'SAR ' + value.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'SAR ' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Vehicle Utilization Chart
    const utilizationCtx = document.getElementById('utilizationChart').getContext('2d');
    const utilizationData = [
        availableVehicles,
        rentedVehicles,
        maintenanceVehicles
    ];
    
    new Chart(utilizationCtx, {
        type: 'doughnut',
        data: {
            labels: ['Available', 'Rented', 'Maintenance'],
            datasets: [{
                data: utilizationData,
                backgroundColor: [
                    '#198754',
                    '#0dcaf0',
                    '#ffc107'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
</script>
@endpush
@endsection