@extends('layouts.customer')

@section('title', 'Welcome to Car Rental Service')

@section('content')
<!-- Hero Section with Search Form -->
<section class="hero-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="search-form-container">
                    <h2 class="text-center mb-4">Rent a Car</h2>
                    <form action="{{ route('fleet') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <select name="pickup_location" class="form-select" required>
                                    <option value="">Select a location</option>
                                    @foreach($offices as $office)
                                        <option value="{{ $office->OfficeID }}">{{ $office->Location }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <input type="date" name="pickup_date" class="form-control" placeholder="mm/dd/yyyy" required>
                            </div>
                            <div class="col-md-6">
                                <input type="date" name="return_date" class="form-control" placeholder="mm/dd/yyyy" required>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary w-100">Search Cars</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Cars Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2>Featured Cars in Our Fleet</h2>
            <p class="text-muted">Bestsellers, discounts, and all new cars in our fleet</p>
            <a href="{{ route('fleet') }}" class="btn btn-outline-primary">Explore All Cars</a>
        </div>

        @if($featuredVehicles->count() > 0)
            <div id="featuredCars" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach($featuredVehicles->chunk(3) as $key => $chunk)
                        <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                            <div class="row">
                                @foreach($chunk as $vehicle)
                                    <div class="col-md-4">
                                        <div class="card h-100">
                                            @if($vehicle->ImagePath)
                                                <img src="{{ asset($vehicle->ImagePath) }}" class="card-img-top" alt="{{ $vehicle->Make }} {{ $vehicle->Model }}">
                                            @else
                                                <div class="card-img-top bg-light text-center py-4">
                                                    <i class="bi bi-car-front display-1"></i>
                                                </div>
                                            @endif
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $vehicle->Make }} {{ $vehicle->Model }}</h5>
                                                <p class="card-text">
                                                    <span class="badge bg-primary">{{ $vehicle->Category }}</span>
                                                </p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="fs-5">
                                                        <span class="price">
                                                            <img src="{{ asset('images/Saudi_Riyal_Symbol.svg') }}" alt="SAR" 
                                                                 style="height: 1em; margin-right: 2px; vertical-align: middle;">
                                                            {{ number_format((float)$vehicle->DailyRate, 2) }}
                                                        </span>
                                                        / day
                                                    </span>
                                                    <a href="{{ route('fleet') }}" class="btn btn-outline-primary btn-sm">View Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#featuredCars" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark rounded-circle" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#featuredCars" data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-dark rounded-circle" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        @else
            <div class="text-center text-muted">
                <p>No featured cars available at the moment</p>
            </div>
        @endif
    </div>
</section>

<!-- Office Locations Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Our Offices</h2>
        <div class="row row-cols-1 row-cols-md-2 g-4">
            @foreach($offices as $office)
                <div class="col">
                    <div class="card h-100">
                        <div class="row g-0">
                            <div class="col-md-4">
                                @if($office->ImagePath)
                                    <img src="{{ asset($office->ImagePath) }}" 
                                         class="img-fluid rounded-start h-100" style="object-fit: cover;"
                                         alt="{{ $office->Location }} Office">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                        <i class="bi bi-building display-4 text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $office->Location }} Branch</h5>
                                    <p class="card-text">
                                        <i class="bi bi-geo-alt me-2"></i>{{ $office->Address }}
                                    </p>
                                    <p class="card-text">
                                        <i class="bi bi-telephone me-2"></i>{{ $office->PhoneNumber }}<br>
                                        <i class="bi bi-envelope me-2"></i>{{ $office->Email }}
                                    </p>
                                    <p class="card-text">
                                        <i class="bi bi-clock me-2"></i>
                                        {{ \Carbon\Carbon::parse($office->OpeningTime)->format('h:i A') }} - 
                                        {{ \Carbon\Carbon::parse($office->ClosingTime)->format('h:i A') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Our Categories</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card category-card">
                    <img src="{{ asset('images/categories/Yaris_2025.png') }}" 
                         class="card-img-top" alt="Small Cars" style="height: 200px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Small Cars</h5>
                        <p class="card-text">Perfect for city driving and economy</p>
                        <a href="{{ route('fleet', ['category' => 'Small Cars']) }}" class="btn btn-outline-primary">View Cars</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card category-card">
                    <img src="{{ asset('images/categories/sonata_2025.jpg') }}" 
                         class="card-img-top" alt="Sedan & Compact" style="height: 200px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Sedan</h5>
                        <p class="card-text">Comfortable and efficient for everyday use</p>
                        <a href="{{ route('fleet', ['category' => 'Sedan']) }}" class="btn btn-outline-primary">View Cars</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card category-card">
                    <img src="{{ asset('images/categories/Rav4_2025.jpeg') }}" 
                         class="card-img-top" alt="SUV & Crossover" style="height: 200px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h5 class="card-title">SUV & Crossover</h5>
                        <p class="card-text">Spacious and versatile for any adventure</p>
                        <a href="{{ route('fleet', ['category' => 'SUV & Crossover']) }}" class="btn btn-outline-primary">View Cars</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Date validation for search form
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        const pickupDate = document.querySelector('input[name="pickup_date"]');
        const returnDate = document.querySelector('input[name="return_date"]');
        
        pickupDate.min = today;
        returnDate.min = today;
        
        pickupDate.addEventListener('change', function() {
            returnDate.min = this.value;
            if (returnDate.value && returnDate.value < this.value) {
                returnDate.value = this.value;
            }
        });
    });
</script>
@endpush
