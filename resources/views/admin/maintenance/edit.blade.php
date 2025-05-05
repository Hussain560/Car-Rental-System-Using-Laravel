@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.maintenance.index') }}" class="btn btn-icon btn-light">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <h1 class="page-header-title">Edit Maintenance Record</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.maintenance.update', $maintenance) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Vehicle <span class="text-danger">*</span></label>
                                <select class="form-select" name="vehicle_id" required>
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{ $vehicle->VehicleID }}" 
                                            {{ $maintenance->VehicleID == $vehicle->VehicleID ? 'selected' : '' }}>
                                            {{ $vehicle->Make }} {{ $vehicle->Model }} ({{ $vehicle->LicensePlate }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Maintenance Type <span class="text-danger">*</span></label>
                                <select class="form-select" name="maintenance_type" required>
                                    <option value="Routine Service" {{ $maintenance->MaintenanceType == 'Routine Service' ? 'selected' : '' }}>Routine Service</option>
                                    <option value="Repair" {{ $maintenance->MaintenanceType == 'Repair' ? 'selected' : '' }}>Repair</option>
                                    <option value="Inspection" {{ $maintenance->MaintenanceType == 'Inspection' ? 'selected' : '' }}>Inspection</option>
                                    <option value="Tire Service" {{ $maintenance->MaintenanceType == 'Tire Service' ? 'selected' : '' }}>Tire Service</option>
                                    <option value="Oil Change" {{ $maintenance->MaintenanceType == 'Oil Change' ? 'selected' : '' }}>Oil Change</option>
                                    <option value="Brake Service" {{ $maintenance->MaintenanceType == 'Brake Service' ? 'selected' : '' }}>Brake Service</option>
                                    <option value="Battery Service" {{ $maintenance->MaintenanceType == 'Battery Service' ? 'selected' : '' }}>Battery Service</option>
                                    <option value="AC Service" {{ $maintenance->MaintenanceType == 'AC Service' ? 'selected' : '' }}>AC Service</option>
                                    <option value="Body Work" {{ $maintenance->MaintenanceType == 'Body Work' ? 'selected' : '' }}>Body Work</option>
                                    <option value="Engine Service" {{ $maintenance->MaintenanceType == 'Engine Service' ? 'selected' : '' }}>Engine Service</option>
                                    <option value="Transmission" {{ $maintenance->MaintenanceType == 'Transmission' ? 'selected' : '' }}>Transmission Service</option>
                                    <option value="Other" {{ $maintenance->MaintenanceType == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Start Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="start_date" 
                                       value="{{ $maintenance->StartDate->format('Y-m-d') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">End Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="end_date" 
                                       value="{{ $maintenance->EndDate->format('Y-m-d') }}" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="description" rows="3" required>{{ $maintenance->Description }}</textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Cost (SAR) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <img src="/images/Saudi_Riyal_Symbol.svg" alt="SAR" style="height: 1em;">
                                    </span>
                                    <input type="number" step="0.01" min="1" class="form-control" 
                                           name="cost" value="{{ $maintenance->Cost }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" name="status" required>
                                    <option value="Scheduled" {{ $maintenance->Status == 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                                    <option value="In Progress" {{ $maintenance->Status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="Completed" {{ $maintenance->Status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('admin.maintenance.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Record</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const startDateInput = document.querySelector('input[name="start_date"]');
        const endDateInput = document.querySelector('input[name="end_date"]');
        
        endDateInput.min = startDateInput.value;
        
        startDateInput.addEventListener('change', function() {
            endDateInput.min = this.value;
            if (endDateInput.value && endDateInput.value < this.value) {
                endDateInput.value = this.value;
            }
        });
    });
</script>
@endpush
