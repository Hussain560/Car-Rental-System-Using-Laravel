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
                    <h1 class="page-header-title">Edit Customer</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.customers.update', $customer) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">First Name</label>
                                <input type="text" name="FirstName" class="form-control" value="{{ old('FirstName', $customer->FirstName) }}" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="LastName" class="form-control" value="{{ old('LastName', $customer->LastName) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="Email" class="form-control" value="{{ old('Email', $customer->Email) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="PhoneNumber" class="form-control" value="{{ old('PhoneNumber', $customer->PhoneNumber) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Emergency Phone</label>
                                <input type="text" name="EmergencyPhone" class="form-control" value="{{ old('EmergencyPhone', $customer->EmergencyPhone) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">National ID</label>
                                <input type="text" class="form-control" value="{{ $customer->NationalID }}" readonly disabled>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Gender</label>
                                <select name="Gender" class="form-select" required>
                                    <option value="Male" {{ old('Gender', $customer->Gender) === 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('Gender', $customer->Gender) === 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" name="DateOfBirth" class="form-control" value="{{ old('DateOfBirth', $customer->DateOfBirth->format('Y-m-d')) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">License Expiry Date</label>
                                <input type="date" name="LicenseExpiryDate" class="form-control" value="{{ old('LicenseExpiryDate', $customer->LicenseExpiryDate->format('Y-m-d')) }}" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Address</label>
                                <textarea name="Address" class="form-control" rows="3" required>{{ old('Address', $customer->Address) }}</textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Account Status</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input type="radio" name="AccountStatus" class="form-check-input" 
                                               value="Active" {{ $customer->AccountStatus === 'Suspended' ? '' : 'checked' }}
                                               id="statusActive">
                                        <label class="form-check-label text-success" for="statusActive">
                                            <i class="bi bi-check-circle me-1"></i> Active
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" name="AccountStatus" class="form-check-input" 
                                               value="Suspended" {{ $customer->AccountStatus === 'Suspended' ? 'checked' : '' }}
                                               id="statusSuspended">
                                        <label class="form-check-label text-danger" for="statusSuspended">
                                            <i class="bi bi-slash-circle me-1"></i> Suspended
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <hr class="my-4">
                            </div>

                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary" id="updateBtn">
                                        <span class="d-inline-flex align-items-center">
                                            <span class="spinner-border spinner-border-sm d-none me-2" id="loadingSpinner"></span>
                                            <span id="buttonText">Update Customer</span>
                                        </span>
                                    </button>
                                    <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.querySelector('form').addEventListener('submit', function() {
    const btn = document.getElementById('updateBtn');
    const spinner = document.getElementById('loadingSpinner');
    const text = document.getElementById('buttonText');
    
    btn.disabled = true;
    spinner.classList.remove('d-none');
    text.textContent = 'Processing...';
});
</script>
@endpush

@endsection
