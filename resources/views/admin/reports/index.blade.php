@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title">Reports & Analytics</h1>
                <span class="text-muted">View business performance metrics and generate reports</span>
            </div>
            <div class="col-auto">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-download me-2"></i> Export Report
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.reports.export', ['type' => 'bookings']) }}">
                                <i class="bi bi-calendar3 me-2"></i> Bookings Report
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.reports.export', ['type' => 'revenue']) }}">
                                <i class="bi bi-currency-dollar me-2"></i> Revenue Report
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.reports.export', ['type' => 'vehicles']) }}">
                                <i class="bi bi-car-front me-2"></i> Vehicle Utilization
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.reports.export', ['type' => 'maintenance']) }}">
                                <i class="bi bi-tools me-2"></i> Maintenance Report
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Date Range Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form id="reportFilterForm" class="row g-3 align-items-end">
                <div class="col-sm-4">
                    <label class="form-label">Date Range</label>
                    <select class="form-select" id="dateRange" name="date_range">
                        <option value="today">Today</option>
                        <option value="yesterday">Yesterday</option>
                        <option value="last7days" selected>Last 7 Days</option>
                        <option value="last30days">Last 30 Days</option>
                        <option value="thisMonth">This Month</option>
                        <option value="lastMonth">Last Month</option>
                        <option value="custom">Custom Range</option>
                    </select>
                </div>
                <div class="col-sm-3 custom-date-range d-none">
                    <label class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="startDate" name="start_date">
                </div>
                <div class="col-sm-3 custom-date-range d-none">
                    <label class="form-label">End Date</label>
                    <input type="date" class="form-control" id="endDate" name="end_date">
                </div>
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-filter me-2"></i> Apply Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Revenue Overview -->
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2">Total Revenue</h6>
                    <div class="row align-items-center">
                        <div class="col">
                            <h2 class="mb-1">SAR {{ number_format($totalRevenue, 2) }}</h2>
                            <span class="text-{{ $revenueGrowth >= 0 ? 'success' : 'danger' }}">
                                <i class="bi bi-arrow-{{ $revenueGrowth >= 0 ? 'up' : 'down' }}"></i>
                                {{ abs($revenueGrowth) }}%
                            </span>
                            <span class="text-muted">vs previous period</span>
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-soft-primary p-2">
                                <i class="bi bi-currency-dollar fs-4"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2">Total Bookings</h6>
                    <div class="row align-items-center">
                        <div class="col">
                            <h2 class="mb-1">{{ $totalBookings }}</h2>
                            <span class="text-{{ $bookingsGrowth >= 0 ? 'success' : 'danger' }}">
                                <i class="bi bi-arrow-{{ $bookingsGrowth >= 0 ? 'up' : 'down' }}"></i>
                                {{ abs($bookingsGrowth) }}%
                            </span>
                            <span class="text-muted">vs previous period</span>
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-soft-info p-2">
                                <i class="bi bi-calendar3 fs-4"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2">Vehicle Utilization</h6>
                    <div class="row align-items-center">
                        <div class="col">
                            <h2 class="mb-1">{{ $utilizationRate }}%</h2>
                            <span class="text-{{ $utilizationGrowth >= 0 ? 'success' : 'danger' }}">
                                <i class="bi bi-arrow-{{ $utilizationGrowth >= 0 ? 'up' : 'down' }}"></i>
                                {{ abs($utilizationGrowth) }}%
                            </span>
                            <span class="text-muted">vs previous period</span>
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-soft-success p-2">
                                <i class="bi bi-car-front fs-4"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2">Average Daily Rate</h6>
                    <div class="row align-items-center">
                        <div class="col">
                            <h2 class="mb-1">SAR {{ number_format($averageDailyRate, 2) }}</h2>
                            <span class="text-{{ $rateGrowth >= 0 ? 'success' : 'danger' }}">
                                <i class="bi bi-arrow-{{ $rateGrowth >= 0 ? 'up' : 'down' }}"></i>
                                {{ abs($rateGrowth) }}%
                            </span>
                            <span class="text-muted">vs previous period</span>
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-soft-warning p-2">
                                <i class="bi bi-graph-up fs-4"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Revenue Chart -->
        <div class="col-xl-8">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-header-title">Revenue Trends</h5>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Booking Status -->
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-header-title">Booking Status Distribution</h5>
                </div>
                <div class="card-body">
                    <canvas id="bookingStatusChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Vehicle Category Performance -->
        <div class="col-xl-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-header-title">Category Performance</h5>
                </div>
                <div class="card-body">
                    <canvas id="categoryChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Office Performance -->
        <div class="col-xl-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-header-title">Office Performance</h5>
                </div>
                <div class="card-body">
                    <canvas id="officeChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Maintenance Costs -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-header-title">Recent Maintenance Costs</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Vehicle</th>
                                <th>Maintenance Type</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th class="text-end">Cost (SAR)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentMaintenance as $maintenance)
                            <tr>
                                <td>
                                    {{ $maintenance->vehicle->Make }} {{ $maintenance->vehicle->Model }}
                                    ({{ $maintenance->vehicle->Year }})
                                </td>
                                <td>{{ $maintenance->MaintenanceType }}</td>
                                <td>{{ $maintenance->StartDate->format('M d, Y') }}</td>
                                <td>
                                    {{ $maintenance->EndDate ? $maintenance->EndDate->format('M d, Y') : 'In Progress' }}
                                </td>
                                <td>
                                    <span class="badge bg-{{ $maintenance->Status === 'Completed' ? 'success' : 'warning' }}">
                                        {{ $maintenance->Status }}
                                    </span>
                                </td>
                                <td class="text-end">{{ number_format($maintenance->Cost, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-light fw-bold">
                            <tr>
                                <td colspan="5">Total Maintenance Cost</td>
                                <td class="text-end">{{ number_format($totalMaintenanceCost, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .bg-soft-primary {
        background-color: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
    }
    .bg-soft-info {
        background-color: rgba(13, 202, 240, 0.1);
        color: #0dcaf0;
    }
    .bg-soft-success {
        background-color: rgba(25, 135, 84, 0.1);
        color: #198754;
    }
    .bg-soft-warning {
        background-color: rgba(255, 193, 7, 0.1);
        color: #ffc107;
    }
    .badge {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Date range toggling
    document.getElementById('dateRange').addEventListener('change', function() {
        const customDateFields = document.querySelectorAll('.custom-date-range');
        if (this.value === 'custom') {
            customDateFields.forEach(field => field.classList.remove('d-none'));
        } else {
            customDateFields.forEach(field => field.classList.add('d-none'));
        }
    });

    // Revenue Chart
    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($revenueTrend->pluck('date')) !!},
            datasets: [{
                label: 'Revenue',
                data: {!! json_encode($revenueTrend->pluck('amount')) !!},
                borderColor: '#0d6efd',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'SAR ' + value;
                        }
                    }
                }
            }
        }
    });

    // Booking Status Chart
    new Chart(document.getElementById('bookingStatusChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($bookingStatus->pluck('status')) !!},
            datasets: [{
                data: {!! json_encode($bookingStatus->pluck('count')) !!},
                backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#dc3545']
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

    // Category Performance Chart
    new Chart(document.getElementById('categoryChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($categoryPerformance->pluck('category')) !!},
            datasets: [{
                label: 'Bookings',
                data: {!! json_encode($categoryPerformance->pluck('bookings')) !!},
                backgroundColor: '#0d6efd'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Office Performance Chart
    new Chart(document.getElementById('officeChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($officePerformance->pluck('location')) !!},
            datasets: [{
                label: 'Revenue',
                data: {!! json_encode($officePerformance->pluck('revenue')) !!},
                backgroundColor: '#198754'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'SAR ' + value;
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection