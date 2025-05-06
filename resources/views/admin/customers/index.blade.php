@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 rounded-circle bg-primary bg-opacity-10 p-3">
                            <i class="bi bi-people fs-4 text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Total Customers</h6>
                            <h3 class="mb-0">{{ $stats['total'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 rounded-circle bg-success bg-opacity-10 p-3">
                            <i class="bi bi-person-check fs-4 text-success"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Active Customers</h6>
                            <h3 class="mb-0">{{ $stats['active'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 rounded-circle bg-danger bg-opacity-10 p-3">
                            <i class="bi bi-person-x fs-4 text-danger"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Suspended</h6>
                            <h3 class="mb-0">{{ $stats['suspended'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 rounded-circle bg-warning bg-opacity-10 p-3">
                            <i class="bi bi-exclamation-triangle fs-4 text-warning"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Expired License</h6>
                            <h3 class="mb-0">{{ $stats['expired_license'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title">Customer Management</h1>
                <span class="text-muted">View and manage customer accounts</span>
            </div>
            <div class="col-auto">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="exportDropdown" 
                            data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-download me-1"></i> Export
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.customers.export', ['format' => 'csv']) }}">
                                <i class="bi bi-filetype-csv me-2"></i> Export as CSV
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.customers.export', ['format' => 'pdf']) }}">
                                <i class="bi bi-filetype-pdf me-2"></i> Export as PDF
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.customers.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Search</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" name="search" value="{{ request('search') }}" 
                               placeholder="Name, Email, ID...">
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Account Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="Active" {{ request('status') === 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Suspended" {{ request('status') === 'Suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">License Status</label>
                    <select name="license_status" class="form-select">
                        <option value="">All</option>
                        <option value="valid" {{ request('license_status') === 'valid' ? 'selected' : '' }}>Valid</option>
                        <option value="expiring_soon" {{ request('license_status') === 'expiring_soon' ? 'selected' : '' }}>Expiring Soon</option>
                        <option value="expired" {{ request('license_status') === 'expired' ? 'selected' : '' }}>Expired</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Sort By</label>
                    <select name="sort" class="form-select">
                        <option value="recent" {{ request('sort') === 'recent' ? 'selected' : '' }}>Recently Added</option>
                        <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Name</option>
                        <option value="bookings" {{ request('sort') === 'bookings' ? 'selected' : '' }}>Total Bookings</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-funnel me-1"></i>Apply Filters
                        </button>
                        @if(request()->hasAny(['search', 'status', 'license_status', 'sort']))
                            <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-1"></i>Clear
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Customers Table -->
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Contact</th>
                        <th>License Info</th>
                        <th>Stats</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $customer)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm bg-soft-primary rounded-circle me-3">
                                    <span class="avatar-initials">
                                        {{ strtoupper(substr($customer->FirstName, 0, 1) . substr($customer->LastName, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $customer->FirstName }} {{ $customer->LastName }}</h6>
                                    <small class="text-muted">ID: {{ $customer->NationalID }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <a href="mailto:{{ $customer->Email }}" class="text-decoration-none">
                                    {{ $customer->Email }}
                                </a>
                                <a href="tel:{{ $customer->PhoneNumber }}" class="text-decoration-none">
                                    {{ $customer->PhoneNumber }}
                                </a>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                @php
                                    $expiryDate = \Carbon\Carbon::parse($customer->LicenseExpiryDate);
                                    $isExpired = $expiryDate->isPast();
                                    $isExpiringSoon = !$isExpired && $expiryDate->diffInDays(now()) <= 30;
                                @endphp
                                <span class="badge bg-{{ $isExpired ? 'danger' : ($isExpiringSoon ? 'warning' : 'success') }} mb-1">
                                    {{ $isExpired ? 'Expired' : ($isExpiringSoon ? 'Expiring Soon' : 'Valid') }}
                                </span>
                                <small class="text-muted">
                                    Expires: {{ $expiryDate->format('M d, Y') }}
                                </small>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span>{{ $customer->bookings_count }} bookings</span>
                                <small class="text-muted">
                                    Last: {{ $customer->bookings_count > 0 ? $customer->bookings->sortByDesc('BookingDate')->first()->BookingDate->format('M d, Y') : 'Never' }}
                                </small>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-{{ 
                                $customer->AccountStatus === 'Active' ? 'success' : 
                                ($customer->AccountStatus === 'Suspended' ? 'danger' : 'secondary') 
                            }}">
                                {{ $customer->AccountStatus }}
                            </span>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-icon" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a href="{{ route('admin.customers.show', $customer) }}" class="dropdown-item">
                                            <i class="bi bi-eye me-2"></i> View Details
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.customers.edit', $customer) }}" class="dropdown-item">
                                            <i class="bi bi-pencil me-2"></i> Edit
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($customers->isEmpty())
            <div class="text-center py-4">
                <div class="mb-3">
                    <i class="bi bi-people display-4 text-muted"></i>
                </div>
                <h4>No Customers Found</h4>
                <p class="text-muted">Try adjusting your filters to see more results.</p>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($customers->hasPages())
        <div class="mt-4">
            {{ $customers->appends(request()->query())->links() }}
        </div>
    @endif
</div>

@push('styles')
<style>
    .avatar {
        width: 2.375rem;
        height: 2.375rem;
        font-size: 0.875rem;
    }
    .avatar-initials {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        font-weight: 500;
    }
    .bg-soft-primary {
        background-color: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
    }
    .table-responsive {
        padding-bottom: 100px;
    }

    .dropdown-menu {
        margin-top: 0 !important;
    }

    tr:last-child .dropdown-menu {
        bottom: 100%;
        top: auto !important;
        transform: none !important;
    }
</style>
@endpush
@endsection