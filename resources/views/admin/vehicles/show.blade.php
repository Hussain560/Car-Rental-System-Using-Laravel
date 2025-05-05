@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.vehicles.index') }}" class="btn btn-icon btn-light">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <h1 class="page-header-title">Vehicle Details</h1>
                </div>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.vehicles.edit', $vehicle) }}" class="btn btn-primary">
                    <i class="bi bi-pencil me-1"></i> Edit Vehicle
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Vehicle Image Card -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    @if($vehicle->ImagePath)
                        <img src="{{ asset($vehicle->ImagePath) }}" 
                             alt="{{ $vehicle->Make }} {{ $vehicle->Model }}"
                             class="img-fluid rounded mb-3" 
                             style="max-height: 300px; width: 100%; object-fit: cover;">
                    @else
                        <div class="bg-secondary rounded mb-3 d-flex align-items-center justify-content-center"
                             style="height: 300px;">
                            <i class="bi bi-car-front text-white" style="font-size: 5rem;"></i>
                        </div>
                    @endif
                    <h3 class="mb-0">{{ $vehicle->Make }} {{ $vehicle->Model }}</h3>
                    <p class="text-muted">{{ $vehicle->Year }}</p>
                    <span class="badge bg-{{ 
                        $vehicle->Status === 'Available' ? 'success' : 
                        ($vehicle->Status === 'Rented' ? 'info' : 'warning') 
                    }} fs-6">
                        {{ $vehicle->Status }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Vehicle Details -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-header-title">Vehicle Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <!-- Basic Information -->
                        <div class="col-md-6">
                            <h6 class="mb-3">Basic Information</h6>
                            <dl class="row">
                                <dt class="col-5 text-muted">Category</dt>
                                <dd class="col-7">{{ $vehicle->Category }}</dd>

                                <dt class="col-5 text-muted">License Plate</dt>
                                <dd class="col-7">{{ $vehicle->LicensePlate }}</dd>

                                <dt class="col-5 text-muted">Serial Number</dt>
                                <dd class="col-7">{{ $vehicle->SerialNumber ?: 'N/A' }}</dd>

                                <dt class="col-5 text-muted">Color</dt>
                                <dd class="col-7">{{ $vehicle->Color ?: 'N/A' }}</dd>
                            </dl>
                        </div>

                        <!-- Specifications -->
                        <div class="col-md-6">
                            <h6 class="mb-3">Specifications</h6>
                            <dl class="row">
                                <dt class="col-5 text-muted">Passengers</dt>
                                <dd class="col-7">{{ $vehicle->PassengerCapacity }} persons</dd>

                                <dt class="col-5 text-muted">Luggage</dt>
                                <dd class="col-7">{{ $vehicle->LuggageCapacity }} pieces</dd>

                                <dt class="col-5 text-muted">Doors</dt>
                                <dd class="col-7">{{ $vehicle->Doors }}</dd>

                                <dt class="col-5 text-muted">Daily Rate</dt>
                                <dd class="col-7"><x-currency :amount="$vehicle->DailyRate" /></dd>
                            </dl>
                        </div>

                        <!-- Location & Status -->
                        <div class="col-12">
                            <h6 class="mb-3">Location & Status</h6>
                            <dl class="row">
                                <dt class="col-3 text-muted">Office Location</dt>
                                <dd class="col-9">
                                    {{ $vehicle->office ? $vehicle->office->Name . ' (' . $vehicle->office->Location . ')' : 'Not Assigned' }}
                                </dd>

                                <dt class="col-3 text-muted">License Expiry</dt>
                                <dd class="col-9">
                                    {{ $vehicle->DateOfExpiry ? $vehicle->DateOfExpiry->format('M d, Y') : 'N/A' }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
