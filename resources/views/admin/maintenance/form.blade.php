@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title">{{ isset($maintenance) ? 'Edit Maintenance Record' : 'New Maintenance Record' }}</h1>
                <span class="text-muted">{{ isset($maintenance) ? 'Update maintenance information' : 'Create a new maintenance record' }}</span>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ isset($maintenance) ? route('admin.maintenance.update', $maintenance) : route('admin.maintenance.store') }}" 
                  method="POST">
                @csrf
                @if(isset($maintenance))
                    @method('PUT')
                @endif

                <div class="row">
                    <!-- Vehicle Selection -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="vehicle_id" class="form-label">Vehicle <span class="text-danger">*</span></label>
                            <select class="form-select @error('vehicle_id') is-invalid @enderror" id="vehicle_id" name="vehicle_id" required>
                                <option value="">Select Vehicle</option>
                                @foreach($vehicles as $vehicle)
                                    <option value="{{ $vehicle->VehicleID }}" 
                                        {{ old('vehicle_id', $maintenance->VehicleID ?? '') == $vehicle->VehicleID ? 'selected' : '' }}>
                                        {{ $vehicle->Make }} {{ $vehicle->Model }} ({{ $vehicle->LicensePlate }})
                                    </option>
                                @endforeach
                            </select>
                            @error('vehicle_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="maintenance_type" class="form-label">Maintenance Type <span class="text-danger">*</span></label>
                            <select class="form-select @error('maintenance_type') is-invalid @enderror" id="maintenance_type" name="maintenance_type" required>
                                <option value="">Select Type</option>
                                <option value="Routine Service" {{ old('maintenance_type', $maintenance->MaintenanceType ?? '') == 'Routine Service' ? 'selected' : '' }}>
                                    Routine Service
                                </option>
                                <option value="Repair" {{ old('maintenance_type', $maintenance->MaintenanceType ?? '') == 'Repair' ? 'selected' : '' }}>
                                    Repair
                                </option>
                                <option value="Inspection" {{ old('maintenance_type', $maintenance->MaintenanceType ?? '') == 'Inspection' ? 'selected' : '' }}>
                                    Inspection
                                </option>
                                <option value="Tire Service" {{ old('maintenance_type', $maintenance->MaintenanceType ?? '') == 'Tire Service' ? 'selected' : '' }}>
                                    Tire Service
                                </option>
                                <option value="Body Work" {{ old('maintenance_type', $maintenance->MaintenanceType ?? '') == 'Body Work' ? 'selected' : '' }}>
                                    Body Work
                                </option>
                            </select>
                            @error('maintenance_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Dates and Cost -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" 
                                   name="start_date" value="{{ old('start_date', $maintenance->StartDate ?? date('Y-m-d')) }}" required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" 
                                   name="end_date" value="{{ old('end_date', $maintenance->EndDate ?? '') }}">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="cost" class="form-label">Cost <x-currency :amount="0"/> <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" class="form-control @error('cost') is-invalid @enderror" 
                                   id="cost" name="cost" value="{{ old('cost', $maintenance->Cost ?? '') }}" required>
                            @error('cost')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" 
                                      name="description" rows="4" required>{{ old('description', $maintenance->Description ?? '') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="In Progress" {{ old('status', $maintenance->Status ?? '') == 'In Progress' ? 'selected' : '' }}>
                                    In Progress
                                </option>
                                <option value="Completed" {{ old('status', $maintenance->Status ?? '') == 'Completed' ? 'selected' : '' }}>
                                    Completed
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="col-12">
                        <hr class="my-4">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.maintenance.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                {{ isset($maintenance) ? 'Update Record' : 'Create Record' }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection