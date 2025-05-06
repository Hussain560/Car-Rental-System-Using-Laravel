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
                            $booking->Status === 'Pending' ? 'warning text-dark' : 
                            ($booking->Status === 'Confirmed' ? 'info text-white' : 
                            ($booking->Status === 'Active Rental' ? 'primary' :
                            ($booking->Status === 'Completed' ? 'success' : 'danger'))) 
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
                            data-bs-target="#startRentalModal">
                        <i class="bi bi-car-front me-1"></i> Start Rental
                    </button>
                @endif
                @if($booking->Status === 'Active Rental')
                    @if(now()->startOfDay()->equalTo($booking->ReturnDate->startOfDay()))
                        <button type="button" class="btn btn-info me-2" data-bs-toggle="modal" 
                                data-bs-target="#completeModal">
                            <i class="bi bi-check2-all me-1"></i> Complete Rental
                        </button>
                    @else
                        <button type="button" class="btn btn-info me-2" disabled title="Can only complete on return date">
                            <i class="bi bi-check2-all me-1"></i> Complete Rental
                        </button>
                    @endif
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
                                <img src="{{ url($booking->vehicle->ImagePath) }}" 
                                     alt="{{ $booking->vehicle->Make }} {{ $booking->vehicle->Model }}" 
                                     class="rounded" style="width: 180px; height: 120px; object-fit: cover;">
                            @else
                                <div class="bg-secondary rounded d-flex align-items-center justify-content-center" 
                                     style="width: 180px; height: 120px;">
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
                <div class="card-header">
                    <h5 class="card-title mb-0">Booking Status</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="progress-line"></div>
                        <div class="timeline-item {{ in_array($booking->Status, ['Pending', 'Confirmed', 'Active Rental', 'Completed']) ? 'active' : '' }}">
                            <div class="timeline-icon bg-warning {{ $booking->Status === 'Pending' ? 'current' : '' }}">
                                <i class="bi bi-clock"></i>
                            </div>
                            <span class="status-label">Pending</span>
                            @if($booking->Status === 'Pending')
                                <div class="status-indicator bg-warning text-dark">Current Status</div>
                            @endif
                        </div>
                        <div class="timeline-item {{ in_array($booking->Status, ['Confirmed', 'Active Rental', 'Completed']) ? 'active' : '' }}">
                            <div class="timeline-icon bg-info {{ $booking->Status === 'Confirmed' ? 'current' : '' }}">
                                <i class="bi bi-check2"></i>
                            </div>
                            <span class="status-label">Confirmed</span>
                            @if($booking->Status === 'Confirmed')
                                <div class="status-indicator bg-info text-white">Current Status</div>
                            @endif
                        </div>
                        <div class="timeline-item {{ in_array($booking->Status, ['Active Rental', 'Completed']) ? 'active' : '' }}">
                            <div class="timeline-icon bg-primary {{ $booking->Status === 'Active Rental' ? 'current' : '' }}">
                                <i class="bi bi-car-front"></i>
                            </div>
                            <span class="status-label">Active Rental</span>
                            @if($booking->Status === 'Active Rental')
                                <div class="status-indicator bg-primary text-white">Current Status</div>
                            @endif
                        </div>
                        <div class="timeline-item {{ $booking->Status === 'Completed' ? 'active' : '' }}">
                            <div class="timeline-icon bg-success {{ $booking->Status === 'Completed' ? 'current' : '' }}">
                                <i class="bi bi-check2-all"></i>
                            </div>
                            <span class="status-label">Completed</span>
                            @if($booking->Status === 'Completed')
                                <div class="status-indicator bg-success text-white">Current Status</div>
                            @endif
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

            <!-- Start Rental Modal -->
            @if($booking->Status === 'Confirmed')
            <div class="modal fade" id="startRentalModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Start Vehicle Rental</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Please ensure the following before starting the rental:
                                    <ul class="mb-0 mt-2">
                                        <li>Customer has provided valid ID</li>
                                        <li>Payment has been processed</li>
                                        <li>Vehicle inspection is completed</li>
                                    </ul>
                                </div>
                                <p>Are you sure you want to start the rental period for this vehicle?</p>
                                <input type="hidden" name="status" value="Active Rental">
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
                        <div class="fs-5">{{ $booking->customer->FirstName }} {{ $booking->customer->LastName }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1 text-muted">Email</label>
                        <div>
                            <a href="mailto:{{ $booking->customer->Email }}" class="text-decoration-none">
                                {{ $booking->customer->Email }}
                            </a>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1 text-muted">Phone</label>
                        <div>
                            <a href="tel:{{ $booking->customer->PhoneNumber }}" class="text-decoration-none">
                                {{ $booking->customer->PhoneNumber }}
                            </a>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1 text-muted">National ID</label>
                        <div>{{ $booking->customer->NationalID }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1 text-muted">License Expiry</label>
                        <div>{{ $booking->customer->LicenseExpiryDate->format('M d, Y') }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1 text-muted">Emergency Contact</label>
                        <div>{{ $booking->customer->EmergencyPhone }}</div>
                    </div>
                    <hr>
                    <a href="{{ route('admin.customers.show', $booking->customer) }}" class="btn btn-primary w-100">
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
    margin: 3rem 0;
    padding: 0 2rem;
}

.progress-line {
    position: absolute;
    top: 24px;
    left: 0;
    right: 0;
    height: 4px;
    background: #e9ecef;
    z-index: 1;
}

.timeline-item {
    position: relative;
    z-index: 2;
    text-align: center;
    min-width: 120px;
}

.timeline-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 0.75rem;
    border: 3px solid #fff;
    box-shadow: 0 0 0 3px #dee2e6;
    transition: all 0.3s ease;
}

.timeline-item.active .timeline-icon {
    background: #e9ecef;
    box-shadow: 0 0 0 3px #0d6efd;
}

.timeline-icon.current {
    transform: scale(1.1);
    background: #0d6efd !important;
    box-shadow: 0 0 0 3px currentColor, 0 0 15px rgba(0, 0, 0, 0.2) !important;
}

.timeline-item i {
    font-size: 1.4rem;
    color: #6c757d;
}

.timeline-item.active i,
.timeline-icon.current i {
    color: #fff;
}

.status-label {
    display: block;
    font-size: 0.95rem;
    color: #6c757d;
    margin-bottom: 0.25rem;
}

.timeline-item.active .status-label {
    color: #212529;
    font-weight: 600;
}

.status-indicator {
    display: inline-block;
    font-size: 0.75rem;
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    margin-top: 0.25rem;
    font-weight: 500;
}

.btn-loading {
    position: relative;
    pointer-events: none;
    opacity: 0.8;
}

.btn-loading .spinner-border {
    position: relative;
    top: -1px;
    width: 1rem;
    height: 1rem;
    margin-right: 0.5rem;
    border-width: 0.15em;
}
</style>
@endpush

@push('scripts')
<script>
document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
    const modal = document.querySelector(button.dataset.bsTarget);
    if (!modal) return;

    const form = modal.querySelector('form');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        if (!submitBtn) return;

        const originalHtml = submitBtn.innerHTML;
        submitBtn.classList.add('btn-loading');
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <span class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </span>
            Processing...
        `;
    });
});
</script>
@endpush