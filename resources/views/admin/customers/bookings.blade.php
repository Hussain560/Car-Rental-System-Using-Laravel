@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-icon btn-light">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="page-header-title">Booking History</h1>
                        <p class="mb-0">{{ $customer->FirstName }} {{ $customer->LastName }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Vehicle</th>
                        <th>Dates</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td>#{{ $booking->BookingID }}</td>
                            <td>
                                <div class="d-flex align-items-center">
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
                                }}">{{ $booking->Status }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-light">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">No bookings found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $bookings->links() }}
    </div>
</div>
@endsection
