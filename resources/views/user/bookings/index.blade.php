@extends('layouts.customer')

@section('title', 'My Bookings')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">My Bookings</h1>
        <a href="{{ route('fleet') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>New Booking
        </a>
    </div>

    <div class="row g-4">
        @forelse($bookings as $booking)
            <div class="col-md-6">
                <div class="card h-100 booking-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="card-title mb-1">{{ $booking->vehicle->Make }} {{ $booking->vehicle->Model }}</h5>
                                <span class="badge bg-{{ 
                                    $booking->Status === 'Pending' ? 'warning' : 
                                    ($booking->Status === 'Confirmed' ? 'success' : 
                                    ($booking->Status === 'Completed' ? 'info' : 'danger')) 
                                }}">{{ $booking->Status }}</span>
                            </div>
                            <div class="text-end">
                                <div class="fs-5 fw-bold mb-1">
                                    <x-currency :amount="$booking->TotalCost" />
                                </div>
                                <small class="text-muted">#{{ $booking->BookingID }}</small>
                            </div>
                        </div>

                        <div class="booking-details mb-3">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="d-flex align-items-center text-muted">
                                        <i class="bi bi-calendar3 me-2"></i>
                                        <span>{{ $booking->PickupDate->format('M d, Y') }} - {{ $booking->ReturnDate->format('M d, Y') }}</span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex align-items-center text-muted">
                                        <i class="bi bi-geo-alt me-2"></i>
                                        <span>{{ $booking->PickupLocation }}</span>
                                    </div>
                                </div>
                                @if($booking->AdditionalServices)
                                    <div class="col-12">
                                        <div class="d-flex align-items-center text-muted">
                                            <i class="bi bi-plus-circle me-2"></i>
                                            <span>{{ $booking->AdditionalServices }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if($booking->Status === 'Pending')
                            <div class="mt-3 d-flex justify-content-end">
                                <form action="{{ route('user.bookings.cancel', $booking) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm" 
                                            onclick="return confirm('Are you sure you want to cancel this booking?')">
                                        <i class="bi bi-x-circle me-2"></i>Cancel Booking
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info" role="alert">
                    <i class="bi bi-info-circle me-2"></i>
                    You haven't made any bookings yet. 
                    <a href="{{ route('fleet') }}" class="alert-link">Browse our fleet</a> to make your first booking.
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $bookings->links() }}
    </div>
</div>
@endsection

@push('styles')
<style>
.booking-card {
    transition: transform 0.2s;
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.booking-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.badge {
    padding: 0.5em 1em;
    font-weight: 500;
}

.booking-details {
    font-size: 0.9rem;
}
</style>
@endpush
