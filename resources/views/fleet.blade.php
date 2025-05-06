@extends('layouts.customer')

@section('title', 'Our Fleet')

@section('content')
<div class="container py-5">
    <h1 class="page-title mb-4">Available Vehicles</h1>

    <!-- Category Tabs -->
    <div class="filter-tabs mb-4">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link {{ !request('category') ? 'active' : '' }}" href="{{ route('fleet') }}">
                    <i class="bi bi-grid-3x3-gap me-1"></i>All Fleet
                </a>
            </li>
            @foreach(['Small Cars', 'Sedan', 'SUV & Crossover'] as $categoryTab)
                <li class="nav-item">
                    <a class="nav-link {{ request('category') == $categoryTab ? 'active' : '' }}" 
                       href="{{ route('fleet', ['category' => $categoryTab]) }}">
                       <i class="bi bi-{{ $categoryTab === 'Small Cars' ? 'car-front' : ($categoryTab === 'Sedan' ? 'car-front-fill' : 'truck') }} me-1"></i>
                       {{ $categoryTab }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Filters -->
    <div class="filter-panel card mb-4">
        <div class="card-body">
            <form action="{{ route('fleet') }}" method="GET" class="row g-3" id="fleet-filter-form">
                <!-- Date Range -->
                <div class="col-md-3">
                    <label class="form-label required">Rental Period</label>
                    <div class="input-group">
                        <input type="date" name="pickup_date" class="form-control" 
                               value="{{ request('pickup_date') }}" 
                               min="{{ date('Y-m-d') }}" required>
                        <input type="date" name="return_date" class="form-control" 
                               value="{{ request('return_date') }}" required>
                    </div>
                    @if(isset($requireDates) && $requireDates)
                        <div class="alert alert-info mt-3">
                            <i class="bi bi-info-circle me-2"></i>
                            Please select rental dates to view available vehicles
                        </div>
                    @endif
                </div>
                <!-- Sort By -->
                <div class="col-md-3">
                    <label class="form-label">Sort By</label>
                    <select name="sort" class="form-select">
                        <option value="">Default</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price (Low to High)</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price (High to Low)</option>
                    </select>
                </div>

                <!-- Location -->
                <div class="col-md-3">
                    <label class="form-label">Location</label>
                    <select name="pickup_location" class="form-select">
                        <option value="">All Locations</option>
                        @foreach($offices as $office)
                            <option value="{{ $office->OfficeID }}" {{ request('pickup_location') == $office->OfficeID ? 'selected' : '' }}>
                                {{ $office->Location }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Price Range -->
                <div class="col-md-3">
                    <label class="form-label">Price Range (SAR)</label>
                    <div class="input-group">
                        <input type="number" name="min_price" class="form-control" placeholder="Min" 
                               value="{{ request('min_price', 50) }}" min="50" max="3200">
                        <input type="number" name="max_price" class="form-control" placeholder="Max" 
                               value="{{ request('max_price', 3200) }}" min="50" max="3200">
                    </div>
                </div>

                <!-- Actions -->
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                    @if(request()->hasAny(['category', 'sort', 'pickup_location', 'min_price', 'max_price', 'pickup_date', 'return_date']))
                        <a href="{{ route('fleet') }}" class="btn btn-outline-secondary">Clear Filters</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Vehicles Grid -->
    @if(!isset($requireDates) || !$requireDates)
        <!-- Refined Vehicle Cards -->
        <div class="vehicle-grid">
            @forelse($vehicles as $vehicle)
                <div class="vehicle-card">
                    <div class="card h-100">
                        <div class="row g-0">
                            <div class="col-md-4 vehicle-image-container">
                                @if($vehicle->ImagePath)
                                    <img src="{{ asset($vehicle->ImagePath) }}" 
                                         class="vehicle-image" 
                                         alt="{{ $vehicle->Make }} {{ $vehicle->Model }}">
                                @else
                                    <div class="vehicle-image-placeholder">
                                        <i class="bi bi-car-front"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-8">
                                <div class="card-body d-flex flex-column h-100">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h5 class="vehicle-title">{{ $vehicle->Make }} {{ $vehicle->Model }} {{ $vehicle->Year }}</h5>
                                            <span class="vehicle-category">{{ $vehicle->Category }}</span>
                                        </div>
                                        <div class="vehicle-price">
                                            <x-currency :amount="$vehicle->DailyRate" />
                                            <small class="text-muted">/day</small>
                                        </div>
                                    </div>
                                    
                                    <div class="vehicle-specs">
                                        <div class="row g-2">
                                            <div class="col-6 col-md-3">
                                                <i class="bi bi-people me-2"></i>{{ $vehicle->PassengerCapacity }} seats
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <i class="bi bi-briefcase me-2"></i>{{ $vehicle->LuggageCapacity }} bags
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <i class="bi bi-gear me-2"></i>Automatic
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <i class="bi bi-door-closed me-2"></i>{{ $vehicle->Doors }} doors
                                            </div>
                                        </div>
                                    </div>

                                    <div class="vehicle-location">
                                        <i class="bi bi-geo-alt"></i>
                                        {{ $vehicle->office ? $vehicle->office->Location : 'Location not specified' }}
                                    </div>

                                    <div class="mt-auto pt-3 text-end">
                                        @auth
                                            <a href="{{ route('user.bookings.create', [
                                                'vehicle' => $vehicle->VehicleID,
                                                'pickup_date' => request('pickup_date'),
                                                'return_date' => request('return_date')
                                            ]) }}" class="btn btn-primary">Book Now</a>
                                        @else
                                            <button type="button" 
                                                    class="btn btn-primary btn-book" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#loginModal">
                                                Book Now
                                            </button>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>No vehicles found matching your criteria.
                    </div>
                </div>
            @endforelse
        </div>
    @endif

    <!-- Pagination with enhanced styling -->
    <div class="pagination-container">
        {{ $vehicles->links() }}
    </div>
</div>

<!-- Login Modal -->
@guest
<div class="modal fade" id="loginModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Authentication Required</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Please login or register to continue with the rental process.</p>
            </div>
            <div class="modal-footer">
                <a href="{{ route('customer.login') }}" class="btn btn-primary">Login</a>
                <a href="{{ route('customer.register') }}" class="btn btn-outline-primary">Register</a>
            </div>
        </div>
    </div>
</div>
@endguest
@endsection

@push('styles')
<style>
.page-title {
    font-weight: 600;
    color: #2c3e50;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
}

.filter-tabs .nav-pills {
    gap: 0.5rem;
    flex-wrap: wrap;
    border-bottom: 1px solid #dee2e6;
    padding-bottom: 1rem;
}

.filter-tabs .nav-link {
    border-radius: 50rem;
    padding: 0.5rem 1.25rem;
    transition: all 0.3s ease;
    font-weight: 500;
    background-color: #e9ecef;  /* Changed from #f8f9fa */
    color: #495057;            /* Changed from #6c757d */
    border: 1px solid #dee2e6; /* Added border */
}

.filter-tabs .nav-link:not(.active) {
    background-color: #e9ecef;
    color: #495057;
}

.filter-tabs .nav-link.active {
    background-color: #0d6efd;
    color: #fff;
    border-color: #0d6efd;
}

.filter-tabs .nav-link:hover:not(.active) {
    background-color: #dee2e6;
    color: #212529;
}

.filter-panel {
    background: #fff;
    border-radius: 1rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
    border: none;
}

.vehicle-card {
    margin-bottom: 1.5rem;
}

.vehicle-card .card {
    border-radius: 1rem;
    border: none;
    box-shadow: 0 0.25rem 0.5rem rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.vehicle-card .card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
}

.vehicle-image-container {
    border-radius: 1rem 0 0 1rem;
    overflow: hidden;
}

.vehicle-image, .vehicle-image-placeholder {
    width: 100%;
    height: 100%;
    object-fit: cover;
    min-height: 250px;
}

.vehicle-image-placeholder {
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
}

.vehicle-image-placeholder i {
    font-size: 4rem;
    color: #adb5bd;
}

.vehicle-title {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.vehicle-category {
    display: inline-block;
    padding: 0.35rem 0.75rem;
    border-radius: 50rem;
    font-size: 0.875rem;
    font-weight: 500;
    background: #e9ecef;
    color: #495057;
}

.vehicle-specs {
    font-size: 0.875rem;
    color: #6c757d;
}

.vehicle-location {
    font-size: 0.875rem;
    color: #6c757d;
    margin-top: 1rem;
}

.btn-book {
    padding: 0.5rem 1.5rem;
    border-radius: 50rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-book:hover {
    transform: translateY(-1px);
    box-shadow: 0 0.25rem 0.5rem rgba(13,110,253,0.3);
}

.pagination-container {
    margin-top: 2rem;
}

@media (max-width: 767.98px) {
    .vehicle-image-container {
        border-radius: 1rem 1rem 0 0;
    }
    
    .vehicle-image, .vehicle-image-placeholder {
        min-height: 200px;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Date validation
    const pickupDate = document.querySelector('input[name="pickup_date"]');
    const returnDate = document.querySelector('input[name="return_date"]');

    if (pickupDate && returnDate) {
        pickupDate.addEventListener('change', function() {
            returnDate.min = this.value;
            if (returnDate.value && returnDate.value < this.value) {
                returnDate.value = this.value;
            }
        });
    }
});

function checkVehicleAvailability(vehicleId, pickupDate, returnDate) {
    return fetch(`/check-vehicle-availability`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ vehicle_id: vehicleId, pickup_date: pickupDate, return_date: returnDate })
    })
    .then(response => response.json());
}

// Add event listeners to date inputs in booking form
document.querySelectorAll('input[type="date"]').forEach(input => {
    input.addEventListener('change', async function() {
        const form = this.closest('form');
        const pickupDate = form.querySelector('input[name="pickup_date"]').value;
        const returnDate = form.querySelector('input[name="return_date"]').value;
        
        if (pickupDate && returnDate) {
            const result = await checkVehicleAvailability(
                '{{ $vehicle->VehicleID ?? "" }}',
                pickupDate,
                returnDate
            );
            
            if (!result.available) {
                alert(result.message);
                this.value = '';
            }
        }
    });
});
</script>
@endpush
