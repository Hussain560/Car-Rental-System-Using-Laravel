@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.customers.index') }}" class="btn btn-icon btn-light">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="page-header-title">Customer Profile</h1>
                        <span class="badge bg-{{ 
                            $customer->AccountStatus === 'Active' ? 'success' : 
                            ($customer->AccountStatus === 'Suspended' ? 'danger' : 'secondary') 
                        }}">{{ $customer->AccountStatus }}</span>
                    </div>
                </div>
            </div>
            <div class="col-auto">
                @if($customer->AccountStatus === 'Active')
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" 
                            data-bs-target="#suspendModal">
                        <i class="bi bi-slash-circle me-1"></i> Suspend Account
                    </button>
                @elseif($customer->AccountStatus === 'Suspended')
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" 
                            data-bs-target="#activateModal">
                        <i class="bi bi-check-circle me-1"></i> Activate Account
                    </button>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Customer Information -->
        <div class="col-xl-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-header-title">Customer Information</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="avatar avatar-xl bg-soft-primary rounded-circle mx-auto mb-3">
                            <span class="avatar-initials display-6">
                                {{ strtoupper(substr($customer->FirstName, 0, 1) . substr($customer->LastName, 0, 1)) }}
                            </span>
                        </div>
                        <h4 class="mb-1">{{ $customer->FirstName }} {{ $customer->LastName }}</h4>
                        <span class="text-muted">Customer since {{ $customer->CreatedAt->format('M Y') }}</span>
                    </div>

                    <div class="mb-4">
                        <h6>Contact Information</h6>
                        <dl class="row">
                            <dt class="col-sm-4">Email</dt>
                            <dd class="col-sm-8">
                                <a href="mailto:{{ $customer->Email }}" class="text-decoration-none">
                                    {{ $customer->Email }}
                                </a>
                            </dd>

                            <dt class="col-sm-4">Phone</dt>
                            <dd class="col-sm-8">
                                <a href="tel:{{ $customer->PhoneNumber }}" class="text-decoration-none">
                                    {{ $customer->PhoneNumber }}
                                </a>
                            </dd>

                            <dt class="col-sm-4">Emergency</dt>
                            <dd class="col-sm-8">
                                <a href="tel:{{ $customer->EmergencyPhone }}" class="text-decoration-none">
                                    {{ $customer->EmergencyPhone }}
                                </a>
                            </dd>
                        </dl>
                    </div>

                    <div class="mb-4">
                        <h6>Personal Information</h6>
                        <dl class="row">
                            <dt class="col-sm-4">National ID</dt>
                            <dd class="col-sm-8">{{ $customer->NationalID }}</dd>

                            <dt class="col-sm-4">Gender</dt>
                            <dd class="col-sm-8">{{ $customer->Gender }}</dd>

                            <dt class="col-sm-4">Birth Date</dt>
                            <dd class="col-sm-8">{{ $customer->DateOfBirth->format('M d, Y') }}</dd>

                            <dt class="col-sm-4">Age</dt>
                            <dd class="col-sm-8">{{ $customer->DateOfBirth->age }} years</dd>
                        </dl>
                    </div>

                    <div class="mb-4">
                        <h6>Address</h6>
                        <p class="text-muted mb-0">{{ $customer->Address }}</p>
                    </div>

                    <div>
                        <h6>License Information</h6>
                        <dl class="row mb-0">
                            @php
                                $expiryDate = \Carbon\Carbon::parse($customer->LicenseExpiryDate);
                                $isExpired = $expiryDate->isPast();
                                $isExpiringSoon = !$isExpired && $expiryDate->diffInDays(now()) <= 30;
                            @endphp
                            <dt class="col-sm-4">Status</dt>
                            <dd class="col-sm-8">
                                <span class="badge bg-{{ $isExpired ? 'danger' : ($isExpiringSoon ? 'warning' : 'success') }}">
                                    {{ $isExpired ? 'Expired' : ($isExpiringSoon ? 'Expiring Soon' : 'Valid') }}
                                </span>
                            </dd>

                            <dt class="col-sm-4">Expiry Date</dt>
                            <dd class="col-sm-8">{{ $expiryDate->format('M d, Y') }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rental History -->
        <div class="col-xl-8 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <div class="row justify-content-between align-items-center flex-grow-1">
                        <div class="col-md">
                            <h5 class="card-header-title">Rental History</h5>
                        </div>
                        <div class="col-auto">
                            <!-- Stats Counter Cards -->
                            <div class="d-flex gap-3">
                                <div class="border rounded px-3 py-2">
                                    <span class="d-block fw-semibold">{{ $customer->bookings->count() }}</span>
                                    <span class="d-block text-muted small">Total Rentals</span>
                                </div>
                                <div class="border rounded px-3 py-2">
                                    <span class="d-block fw-semibold">
                                        <x-currency :amount="$customer->bookings->sum('TotalCost')" />
                                    </span>
                                    <span class="d-block text-muted small">Total Spent</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Booking ID</th>
                                    <th>Vehicle</th>
                                    <th>Dates</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customer->bookings->sortByDesc('BookingDate') as $booking)
                                <tr>
                                    <td>#{{ $booking->BookingID }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($booking->vehicle->ImagePath)
                                                <img src="{{ Storage::url($booking->vehicle->ImagePath) }}" 
                                                     alt="{{ $booking->vehicle->Make }} {{ $booking->vehicle->Model }}" 
                                                     class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="bg-secondary rounded me-2 d-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px;">
                                                    <i class="bi bi-car-front text-white"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <span class="d-block">{{ $booking->vehicle->Make }} {{ $booking->vehicle->Model }}</span>
                                                <small class="text-muted">{{ $booking->vehicle->LicensePlate }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span>{{ $booking->PickupDate->format('M d, Y') }}</span>
                                            <small class="text-muted">to {{ $booking->ReturnDate->format('M d, Y') }}</small>
                                        </div>
                                    </td>
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
                                        <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-light">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="bi bi-calendar2-x display-4 text-muted d-block mb-3"></i>
                                        <h5>No Bookings Found</h5>
                                        <p class="text-muted mb-0">This customer hasn't made any bookings yet.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Update Modals -->
@if($customer->AccountStatus === 'Active')
<!-- Suspend Modal -->
<div class="modal fade" id="suspendModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Suspend Customer Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.customers.update-status', $customer) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <p>Are you sure you want to suspend this customer's account?</p>
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        This will prevent the customer from making new bookings.
                    </div>
                    <input type="hidden" name="status" value="Suspended">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Suspend Account</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@if($customer->AccountStatus === 'Suspended')
<!-- Activate Modal -->
<div class="modal fade" id="activateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Activate Customer Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.customers.update-status', $customer) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <p>Are you sure you want to activate this customer's account?</p>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        This will allow the customer to make bookings again.
                    </div>
                    <input type="hidden" name="status" value="Active">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Activate Account</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@push('styles')
<style>
    .avatar-xl {
        width: 5rem;
        height: 5rem;
        font-size: 2rem;
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
</style>
@endpush
@endsection