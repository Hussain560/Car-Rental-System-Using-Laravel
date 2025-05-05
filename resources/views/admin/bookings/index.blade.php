@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title">Booking Management</h1>
                <span class="text-muted">Manage and track all bookings</span>
            </div>
            <div class="col-auto">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="exportDropdown" 
                            data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-download me-1"></i> Export
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.bookings.export', ['format' => 'csv']) }}">
                                <i class="bi bi-filetype-csv me-2"></i> Export as CSV
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.bookings.export', ['format' => 'pdf']) }}">
                                <i class="bi bi-filetype-pdf me-2"></i> Export as PDF
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.bookings.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Confirmed" {{ request('status') === 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="Completed" {{ request('status') === 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Cancelled" {{ request('status') === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="date_from" class="form-label">From</label>
                    <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-3">
                    <label for="date_to" class="form-label">To</label>
                    <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <h5 class="mb-1">{{ $stats['total'] }}</h5>
                            <span>Total Bookings</span>
                        </div>
                        <div class="avatar bg-light-primary p-2">
                            <i class="bi bi-calendar2-week text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <h5 class="mb-1">{{ $stats['pending'] }}</h5>
                            <span>Pending</span>
                        </div>
                        <div class="avatar bg-light-warning p-2">
                            <i class="bi bi-clock text-warning fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <h5 class="mb-1">{{ $stats['active'] }}</h5>
                            <span>Active Rentals</span>
                        </div>
                        <div class="avatar bg-light-success p-2">
                            <i class="bi bi-check2-circle text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <h5 class="mb-1"><x-currency :amount="$stats['revenue']" /></h5>
                            <span>Total Revenue</span>
                        </div>
                        <div class="avatar bg-light-info p-2">
                            <i class="bi bi-currency-dollar text-info fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bookings Table -->
    <div class="card">
        <div class="table-responsive booking-table-container">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Customer</th>
                        <th>Vehicle</th>
                        <th>Dates</th>
                        <th>Location</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                    <tr>
                        <td>#{{ $booking->BookingID }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm bg-light rounded-circle me-2">
                                    <span class="avatar-initials">
                                        {{ strtoupper(substr($booking->customer->FirstName, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <span class="d-block">{{ $booking->customer->FirstName }} {{ $booking->customer->LastName }}</span>
                                    <small class="text-muted">{{ $booking->customer->Email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span>{{ $booking->vehicle->Make }} {{ $booking->vehicle->Model }}</span>
                                <small class="text-muted">{{ $booking->vehicle->LicensePlate }}</small>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span>{{ $booking->PickupDate->format('M d, Y') }}</span>
                                <small class="text-muted">to {{ $booking->ReturnDate->format('M d, Y') }}</small>
                            </div>
                        </td>
                        <td>{{ $booking->PickupLocation }}</td>
                        <td><x-currency :amount="$booking->TotalCost" /></td>
                        <td>
                            <span class="badge bg-{{ 
                                $booking->Status === 'Pending' ? 'warning' : 
                                ($booking->Status === 'Confirmed' ? 'success' : 
                                ($booking->Status === 'Completed' ? 'info' : 'danger')) 
                            }}">
                                {{ $booking->Status }}
                            </span>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-icon" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.bookings.show', $booking) }}">
                                            <i class="bi bi-eye me-2"></i> View Details
                                        </a>
                                    </li>
                                    @if($booking->Status === 'Pending')
                                    <li>
                                        <button type="button" class="dropdown-item" data-bs-toggle="modal" 
                                                data-bs-target="#confirmModal{{ $booking->BookingID }}">
                                            <i class="bi bi-check2 me-2"></i> Confirm Booking
                                        </button>
                                    </li>
                                    @endif
                                    @if(in_array($booking->Status, ['Pending', 'Confirmed']))
                                    <li>
                                        <button type="button" class="dropdown-item" data-bs-toggle="modal" 
                                                data-bs-target="#cancelModal{{ $booking->BookingID }}">
                                            <i class="bi bi-x-circle me-2"></i> Cancel Booking
                                        </button>
                                    </li>
                                    @endif
                                    @if($booking->Status === 'Confirmed')
                                    <li>
                                        <button type="button" class="dropdown-item" data-bs-toggle="modal" 
                                                data-bs-target="#completeModal{{ $booking->BookingID }}">
                                            <i class="bi bi-check2-all me-2"></i> Mark as Completed
                                        </button>
                                    </li>
                                    @endif
                                </ul>
                            </div>

                            <!-- Confirm Modal -->
                            @if($booking->Status === 'Pending')
                            <div class="modal fade" id="confirmModal{{ $booking->BookingID }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Confirm Booking</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <p>Are you sure you want to confirm this booking?</p>
                                                <input type="hidden" name="status" value="Confirmed">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-success">Confirm Booking</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Cancel Modal -->
                            @if(in_array($booking->Status, ['Pending', 'Confirmed']))
                            <div class="modal fade" id="cancelModal{{ $booking->BookingID }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Cancel Booking</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <p>Are you sure you want to cancel this booking?</p>
                                                <input type="hidden" name="status" value="Cancelled">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, Keep It</button>
                                                <button type="submit" class="btn btn-danger">Yes, Cancel It</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Complete Modal -->
                            @if($booking->Status === 'Confirmed')
                            <div class="modal fade" id="completeModal{{ $booking->BookingID }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Complete Booking</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <p>Are you sure this rental has been completed?</p>
                                                <input type="hidden" name="status" value="Completed">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-success">Mark as Completed</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($bookings->isEmpty())
            <div class="text-center py-4">
                <div class="mb-3">
                    <i class="bi bi-calendar2-x display-4 text-muted"></i>
                </div>
                <h4>No Bookings Found</h4>
                <p class="text-muted">Try adjusting your filters to see more results.</p>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($bookings->hasPages())
        <div class="mt-4">
            {{ $bookings->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
.booking-table-container {
    padding-bottom: 60px; /* Add padding at bottom */
    position: relative;
}

.dropdown-menu {
    position: absolute;
    z-index: 1000;
    transform: translate3d(0px, 40px, 0px) !important;
}

/* Ensure last row actions are visible */
tr:last-child .dropdown-menu {
    transform: translate3d(0px, -100%, 0px) !important;
}
</style>
@endpush