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
                    <h1 class="page-header-title">New Maintenance Record</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.maintenance.store') }}" method="POST">
                        @csrf
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Vehicle <span class="text-danger">*</span></label>
                                <select class="form-select @error('vehicle_id') is-invalid @enderror" name="vehicle_id" required>
                                    <option value="">Select Vehicle</option>
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{ $vehicle->VehicleID }}">
                                            {{ $vehicle->Make }} {{ $vehicle->Model }} ({{ $vehicle->LicensePlate }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('vehicle_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Maintenance Type <span class="text-danger">*</span></label>
                                <select class="form-select @error('maintenance_type') is-invalid @enderror" name="maintenance_type" required>
                                    <option value="">Select Type</option>
                                    <option value="Routine Service">Routine Service</option>
                                    <option value="Repair">Repair</option>
                                    <option value="Inspection">Inspection</option>
                                    <option value="Tire Service">Tire Service</option>
                                    <option value="Oil Change">Oil Change</option>
                                    <option value="Brake Service">Brake Service</option>
                                    <option value="Battery Service">Battery Service</option>
                                    <option value="AC Service">AC Service</option>
                                    <option value="Body Work">Body Work</option>
                                    <option value="Engine Service">Engine Service</option>
                                    <option value="Transmission">Transmission Service</option>
                                    <option value="Other">Other</option>
                                </select>
                                @error('maintenance_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Start Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="start_date" required>
                                <div class="invalid-feedback" id="start-date-feedback"></div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">End Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="end_date" required>
                                <div class="invalid-feedback" id="end-date-feedback"></div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          name="description" rows="3" required></textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Cost (SAR) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <img src="/images/Saudi_Riyal_Symbol.svg" alt="SAR" style="height: 1em;">
                                    </span>
                                    <input type="number" step="0.01" min="1" class="form-control" name="cost" required>
                                </div>
                                <div class="invalid-feedback" id="cost-feedback"></div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                                    <option value="Scheduled">Scheduled</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Completed">Completed</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('admin.maintenance.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Record</button>
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
        const costInput = document.querySelector('input[name="cost"]');
        
        const today = new Date().toISOString().split('T')[0];
        startDateInput.min = today;
        
        function showError(input, message) {
            input.classList.add('is-invalid');
            input.classList.remove('is-valid');
            const feedback = document.getElementById(`${input.name}-feedback`);
            if (feedback) {
                feedback.innerHTML = message;
                feedback.style.display = 'block';
            }
        }

        function showSuccess(input) {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
            const feedback = document.getElementById(`${input.name}-feedback`);
            if (feedback) {
                feedback.style.display = 'none';
            }
        }

        startDateInput.addEventListener('blur', function() {
            if (this.value < today) {
                showError(this, 'The start date cannot be in the past');
            } else {
                showSuccess(this);
            }
        });

        endDateInput.addEventListener('blur', function() {
            if (this.value < startDateInput.value) {
                showError(this, 'The end date must be after or equal to the start date');
            } else {
                showSuccess(this);
            }
        });

        costInput.addEventListener('blur', function() {
            if (this.value < 1) {
                showError(this, 'The cost must be at least <img src="/images/Saudi_Riyal_Symbol.svg" alt="SAR" style="height: 1em;"> 1');
            } else {
                showSuccess(this);
            }
        });

        // Update end date constraints when start date changes
        startDateInput.addEventListener('change', function() {
            endDateInput.min = this.value;
        });
    });
</script>
@endpush
