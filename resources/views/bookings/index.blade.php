@extends('layouts.customer')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">My Bookings</h1>

    <div class="row g-4">
        @forelse($bookings as $booking)
            <div class="col-md-6">
                <div class="card h-100">
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
                                <div class="fs-5 mb-1">
                                    <x-currency :amount="$booking->TotalCost" />
                                </div>
                                <small class="text-muted">Booking #{{ $booking->BookingID }}</small>
                            </div>
                        </div>

                        <ul class="list-unstyled mb-3">
                            <li><i class="bi bi-calendar3 me-2"></i>{{ $booking->PickupDate->format('M d, Y') }} - {{ $booking->ReturnDate->format('M d, Y') }}</li>
                            <li><i class="bi bi-geo-alt me-2"></i>{{ $booking->PickupLocation }}</li>
                            @if($booking->AdditionalServices)
                                <li><i class="bi bi-plus-circle me-2"></i>{{ $booking->AdditionalServices }}</li>
                            @endif
                        </ul>

                        @if($booking->Status === 'Pending')
                            <form action="{{ route('user.bookings.cancel', $booking) }}" method="POST" class="mt-3">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger" 
                                        onclick="return confirm('Are you sure you want to cancel this booking?')">
                                    <i class="bi bi-x-circle me-2"></i>Cancel Booking
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>You haven't made any bookings yet.
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
