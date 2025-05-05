@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-icon btn-light">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="page-header-title">Booking #{{ $booking->BookingID }}</h1>
                        <span class="badge bg-{{ 
                            $booking->Status === 'Pending' ? 'warning' : 
                            ($booking->Status === 'Confirmed' ? 'primary' : 
                            ($booking->Status === 'In Progress' ? 'success' :
                            ($booking->Status === 'Completed' ? 'info' : 'danger'))) 
                        }}">{{ $booking->Status }}</span>
                    </div>
                </div>
            </div>
            <div class="col-auto">
                @if($booking->Status === 'Pending')
                    <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" 
                            data-bs-target="#confirmModal">
                        <i class="bi bi-check2 me-1"></i> Confirm
                    </button>
                @endif
                @if($booking->Status === 'Confirmed')
                    <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" 
                            data-bs-target="#startProgressModal">
                        <i class="bi bi-box-arrow-right me-1"></i> Start Rental
                    </button>
                @endif
                @if($booking->Status === 'In Progress')
                    <button type="button" class="btn btn-info me-2" data-bs-toggle="modal" 
                            data-bs-target="#completeModal">
                        <i class="bi bi-check2-all me-1"></i> Complete Rental
                    </button>
                @endif
                @if(in_array($booking->Status, ['Pending', 'Confirmed']))
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" 
                            data-bs-target="#cancelModal">
                        <i class="bi bi-x-circle me-1"></i> Cancel
                    </button>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Booking Details -->
        <div class="col-xl-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-header-title">Booking Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 mb-4">
                            <label class="small mb-1 text-muted">Pick-up Date</label>
                            <div class="fs-5">{{ $booking->PickupDate->format('M d, Y') }}</div>
                        </div>
                        <div class="col-sm-6 mb-4">
                            <label class="small mb-1 text-muted">Return Date</label>
                            <div class="fs-5">{{ $booking->ReturnDate->format('M d, Y') }}</div>
                        </div>
                        <div class="col-sm-6 mb-4">
                            <label class="small mb-1 text-muted">Duration</label>
                            <div class="fs-5">{{ $booking->PickupDate->diffInDays($booking->ReturnDate) }} days</div>
                        </div>
                        <div class="col-sm-6 mb-4">
                            <label class="small mb-1 text-muted">Pick-up Location</label>
                            <div class="fs-5">{{ $booking->PickupLocation }}</div>
                        </div>
                        <div class="col-sm-6 mb-4">
                            <label class="small mb-1 text-muted">Total Cost</label>
                            <div class="fs-5"><x-currency :amount="$booking->TotalCost" /></div>
                        </div>
                        <div class="col-sm-6 mb-4">
                            <label class="small mb-1 text-muted">Booking Date</label>
                            <div class="fs-5">{{ $booking->BookingDate->format('M d, Y H:i') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vehicle Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-header-title">Vehicle Information</h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            @if($booking->vehicle->ImagePath)
                                <img src="{{ Storage::url($booking->vehicle->ImagePath) }}" 
                                     alt="{{ $booking->vehicle->Make }} {{ $booking->vehicle->Model }}" 
                                     class="rounded" style="width: 120px; height: 120px; object-fit: cover;">
                            @else
                                <div class="bg-secondary rounded d-flex align-items-center justify-content-center" 
                                     style="width: 120px; height: 120px;">
                                    <i class="bi bi-car-front text-white display-4"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <label class="small mb-1 text-muted">Make & Model</label>
                                    <div class="fs-5">{{ $booking->vehicle->Make }} {{ $booking->vehicle->Model }}</div>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="small mb-1 text-muted">Year</label>
                                    <div class="fs-5">{{ $booking->vehicle->Year }}</div>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="small mb-1 text-muted">License Plate</label>
                                    <div class="fs-5">{{ $booking->vehicle->LicensePlate }}</div>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="small mb-1 text-muted">Category</label>
                                    <div class="fs-5">{{ $booking->vehicle->Category }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Booking Status</h5>
                    <div class="btn-group">
                        @if($booking->Status === 'Confirmed')
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#pickupModal">
                                <i class="bi bi-box-arrow-right me-1"></i>Mark as Picked Up
                            </button>
                        @elseif($booking->Status === 'In Progress')
                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#returnModal">
                                <i class="bi bi-box-arrow-in-left me-1"></i>Mark as Returned
                            </button>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <i class="bi bi-circle-fill text-{{ in_array($booking->Status, ['Pending', 'Confirmed', 'In Progress', 'Completed']) ? 'warning' : 'secondary' }}"></i>
                            <span>Pending</span>
                        </div>
                        <div class="timeline-item">
                            <i class="bi bi-circle-fill text-{{ in_array($booking->Status, ['Confirmed', 'In Progress', 'Completed']) ? 'primary' : 'secondary' }}"></i>
                            <span>Confirmed</span>
                        </div>
                        <div class="timeline-item">
                            <i class="bi bi-circle-fill text-{{ in_array($booking->Status, ['In Progress', 'Completed']) ? 'success' : 'secondary' }}"></i>
                            <span>In Progress</span>
                        </div>
                        <div class="timeline-item">
                            <i class="bi bi-circle-fill text-{{ $booking->Status === 'Completed' ? 'info' : 'secondary' }}"></i>
                            <span>Completed</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pickup Modal -->
            <div class="modal fade" id="pickupModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirm Vehicle Pickup</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <p>Are you sure you want to mark this vehicle as picked up?</p>
                                <input type="hidden" name="status" value="In Progress">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">Confirm Pickup</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Return Modal -->
            <div class="modal fade" id="returnModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirm Vehicle Return</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <p>Are you sure you want to mark this vehicle as returned?</p>
                                <input type="hidden" name="status" value="Completed">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-info">Confirm Return</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Start Progress Modal -->
            @if($booking->Status === 'Confirmed')
            <div class="modal fade" id="startProgressModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Start Rental</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <p>Confirm that the customer has picked up the vehicle and the rental period has started?</p>
                                <input type="hidden" name="status" value="In Progress">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Start Rental</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <!-- Customer Information -->
        <div class="col-xl-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-header-title">Customer Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="small mb-1 text-muted">Name</label>
                        <div class="fs-5">{{ $booking->user->FirstName }} {{ $booking->user->LastName }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1 text-muted">Email</label>
                        <div>
                            <a href="mailto:{{ $booking->user->Email }}" class="text-decoration-none">
                                {{ $booking->user->Email }}
                            </a>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1 text-muted">Phone</label>
                        <div>
                            <a href="tel:{{ $booking->user->PhoneNumber }}" class="text-decoration-none">
                                {{ $booking->user->PhoneNumber }}
                            </a>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1 text-muted">National ID</label>
                        <div>{{ $booking->user->NationalID }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1 text-muted">License Expiry</label>
                        <div>{{ $booking->user->LicenseExpiryDate->format('M d, Y') }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1 text-muted">Emergency Contact</label>
                        <div>{{ $booking->user->EmergencyPhone }}</div>
                    </div>
                    <hr>
                    <a href="{{ route('admin.customers.show', $booking->user) }}" class="btn btn-primary w-100">
                        <i class="bi bi-person me-1"></i> View Customer Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Update Modals -->
@if($booking->Status === 'Pending')
<!-- Confirm Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1">
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

@if(in_array($booking->Status, ['Pending', 'Confirmed']))
<!-- Cancel Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1">
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

@if($booking->Status === 'Confirmed')
<!-- Complete Modal -->
<div class="modal fade" id="completeModal" tabindex="-1">
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
@endsection

@push('styles')
<style>
.timeline {
    position: relative;
    display: flex;
    justify-content: space-between;
    margin: 2rem 0;
}

.timeline::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 2px;
    background: #dee2e6;
    z-index: 1;
}

.timeline-item {
    position: relative;
    z-index: 2;
    background: white;
    padding: 0 1rem;
    text-align: center;
}

.timeline-item i {
    display: block;
    margin-bottom: 0.5rem;
}
</style>
@endpush