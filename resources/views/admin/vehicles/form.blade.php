@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title">{{ isset($vehicle) ? 'Edit Vehicle' : 'Add New Vehicle' }}</h1>
                <span class="text-muted">{{ isset($vehicle) ? 'Update vehicle information' : 'Create a new vehicle entry' }}</span>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ isset($vehicle) ? route('admin.vehicles.update', $vehicle) : route('admin.vehicles.store') }}" 
                  method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($vehicle))
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <!-- Basic Information -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="make" class="form-label">Make <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('make') is-invalid @enderror" id="make" 
                                   name="make" value="{{ old('make', $vehicle->Make ?? '') }}" required>
                            @error('make')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="model" class="form-label">Model <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('model') is-invalid @enderror" id="model" 
                                   name="model" value="{{ old('model', $vehicle->Model ?? '') }}" required>
                            @error('model')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="year" class="form-label">Year <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('year') is-invalid @enderror" id="year" 
                                   name="year" value="{{ old('year', $vehicle->Year ?? '') }}" min="2000" max="{{ date('Y') + 1 }}" required>
                            @error('year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                <option value="">Select Category</option>
                                @foreach(['Sedan', 'SUV', 'Crossover', 'Small Cars'] as $category)
                                    <option value="{{ $category }}" {{ old('category', $vehicle->Category ?? '') == $category ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Additional Details -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="license_plate" class="form-label">License Plate <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('license_plate') is-invalid @enderror" id="license_plate" 
                                   name="license_plate" value="{{ old('license_plate', $vehicle->LicensePlate ?? '') }}" required>
                            @error('license_plate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="serial_number" class="form-label">Serial Number</label>
                            <input type="text" class="form-control @error('serial_number') is-invalid @enderror" id="serial_number" 
                                   name="serial_number" value="{{ old('serial_number', $vehicle->SerialNumber ?? '') }}">
                            @error('serial_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="color" class="form-label">Color</label>
                            <input type="text" class="form-control @error('color') is-invalid @enderror" id="color" 
                                   name="color" value="{{ old('color', $vehicle->Color ?? '') }}">
                            @error('color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="date_of_expiry" class="form-label">Registration Expiry Date</label>
                            <input type="date" class="form-control @error('date_of_expiry') is-invalid @enderror" id="date_of_expiry" 
                                   name="date_of_expiry" value="{{ old('date_of_expiry', $vehicle->DateOfExpiry ?? '') }}">
                            @error('date_of_expiry')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Rental Information -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="daily_rate" class="form-label">Daily Rate (SAR) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" class="form-control @error('daily_rate') is-invalid @enderror" 
                                   id="daily_rate" name="daily_rate" value="{{ old('daily_rate', $vehicle->DailyRate ?? '') }}" required>
                            @error('daily_rate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="office_id" class="form-label">Office Location</label>
                            <select class="form-select @error('office_id') is-invalid @enderror" id="office_id" name="office_id">
                                <option value="">Select Office</option>
                                @foreach($offices as $office)
                                    <option value="{{ $office->OfficeID }}" 
                                        {{ old('office_id', $vehicle->OfficeID ?? '') == $office->OfficeID ? 'selected' : '' }}>
                                        {{ $office->Location }}
                                    </option>
                                @endforeach
                            </select>
                            @error('office_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="">Select Status</option>
                                @foreach(['Available', 'Maintenance'] as $status)
                                    <option value="{{ $status }}" {{ old('status', $vehicle->Status ?? '') == $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Vehicle Specifications -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="passenger_capacity" class="form-label">Passenger Capacity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('passenger_capacity') is-invalid @enderror" 
                                   id="passenger_capacity" name="passenger_capacity" 
                                   value="{{ old('passenger_capacity', $vehicle->PassengerCapacity ?? '4') }}" min="1" required>
                            @error('passenger_capacity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="luggage_capacity" class="form-label">Luggage Capacity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('luggage_capacity') is-invalid @enderror" 
                                   id="luggage_capacity" name="luggage_capacity" 
                                   value="{{ old('luggage_capacity', $vehicle->LuggageCapacity ?? '2') }}" min="0" required>
                            @error('luggage_capacity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="doors" class="form-label">Number of Doors <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('doors') is-invalid @enderror" 
                                   id="doors" name="doors" value="{{ old('doors', $vehicle->Doors ?? '4') }}" min="2" required>
                            @error('doors')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Vehicle Image -->
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="image_path" class="form-label">Vehicle Image</label>
                            <input type="file" class="form-control @error('image_path') is-invalid @enderror" 
                                   id="image_path" name="image_path" accept="image/*">
                            @error('image_path')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if(isset($vehicle) && $vehicle->ImagePath)
                                <div class="mt-2">
                                    <img src="{{ Storage::url($vehicle->ImagePath) }}" alt="Current vehicle image" 
                                         class="rounded" style="max-height: 100px;">
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="col-12">
                        <hr class="my-4">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.vehicles.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                {{ isset($vehicle) ? 'Update Vehicle' : 'Create Vehicle' }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection