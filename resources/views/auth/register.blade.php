@extends('layouts.customer')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Customer Registration</h4>
                </div>
                
                <!-- Progress Bar -->
                <div class="px-4 pt-4">
                    <div class="progress mb-3">
                        <div class="progress-bar" role="progressbar" style="width: 25%;" id="registration-progress"></div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="step-indicator active" data-step="1">Account</span>
                        <span class="step-indicator" data-step="2">Personal</span>
                        <span class="step-indicator" data-step="3">Contact</span>
                        <span class="step-indicator" data-step="4">License</span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('customer.register.submit') }}" id="registration-form">
                        @csrf
                        
                        <!-- Step 1: Account Information -->
                        <div class="registration-step" id="step-1">
                            <h5 class="mb-4">Account Information</h5>
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label">Username <span class="text-danger">*</span></label>
                                    <input type="text" name="Username" class="form-control @error('Username') is-invalid @enderror" required>
                                    @error('Username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="Email" class="form-control @error('Email') is-invalid @enderror" required>
                                    @error('Email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="Password" class="form-control @error('Password') is-invalid @enderror" required>
                                    @error('Password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                    <input type="password" name="Password_confirmation" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Personal Information -->
                        <div class="registration-step" id="step-2" style="display: none;">
                            <h5 class="mb-4">Personal Information</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" name="FirstName" class="form-control @error('FirstName') is-invalid @enderror" required>
                                    @error('FirstName')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" name="LastName" class="form-control @error('LastName') is-invalid @enderror" required>
                                    @error('LastName')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                    <input type="date" name="DateOfBirth" class="form-control @error('DateOfBirth') is-invalid @enderror" required>
                                    @error('DateOfBirth')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Gender <span class="text-danger">*</span></label>
                                    <select name="Gender" class="form-select @error('Gender') is-invalid @enderror" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    @error('Gender')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Contact Information -->
                        <div class="registration-step" id="step-3" style="display: none;">
                            <h5 class="mb-4">Contact Information</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                    <input type="tel" name="PhoneNumber" class="form-control @error('PhoneNumber') is-invalid @enderror" required>
                                    @error('PhoneNumber')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Emergency Phone <span class="text-danger">*</span></label>
                                    <input type="tel" name="EmergencyPhone" class="form-control @error('EmergencyPhone') is-invalid @enderror" required>
                                    @error('EmergencyPhone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Address <span class="text-danger">*</span></label>
                                    <textarea name="Address" class="form-control @error('Address') is-invalid @enderror" rows="3" required></textarea>
                                    @error('Address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <!-- Step 4: License Information -->
                        <div class="registration-step" id="step-4" style="display: none;">
                            <h5 class="mb-4">License Information</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">National ID <span class="text-danger">*</span></label>
                                    <input type="text" name="NationalID" class="form-control @error('NationalID') is-invalid @enderror" required>
                                    @error('NationalID')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">License Expiry Date <span class="text-danger">*</span></label>
                                    <input type="date" name="LicenseExpiryDate" class="form-control @error('LicenseExpiryDate') is-invalid @enderror" required>
                                    @error('LicenseExpiryDate')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-secondary" id="prev-step" style="display: none;">Previous</button>
                            <button type="button" class="btn btn-primary" id="next-step">Next</button>
                            <button type="submit" class="btn btn-success" id="submit-form" style="display: none;">Complete Registration</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.card {
    border-radius: 1rem;
    border: none;
}

.card-header {
    border-radius: 1rem 1rem 0 0 !important;
    padding: 1.5rem;
}

.form-label {
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.form-control {
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 500;
}

.step-indicator {
    color: #6c757d;
    font-size: 0.875rem;
    font-weight: 500;
}

.step-indicator.active {
    color: #0d6efd;
    font-weight: 600;
}

.progress {
    height: 0.5rem;
}

.progress-bar {
    background-color: #0d6efd;
    transition: width 0.3s ease;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentStep = 1;
    const totalSteps = 4;
    const form = document.getElementById('registration-form');
    const nextBtn = document.getElementById('next-step');
    const prevBtn = document.getElementById('prev-step');
    const submitBtn = document.getElementById('submit-form');
    const progressBar = document.querySelector('.progress-bar');

    function updateStep(step) {
        document.querySelectorAll('.registration-step').forEach(el => el.style.display = 'none');
        document.getElementById(`step-${step}`).style.display = 'block';
        
        // Update progress bar and indicators
        const progress = (step / totalSteps) * 100;
        progressBar.style.width = `${progress}%`;
        
        document.querySelectorAll('.step-indicator').forEach(el => {
            el.classList.toggle('active', parseInt(el.dataset.step) <= step);
        });
        
        // Show/hide navigation buttons
        prevBtn.style.display = step > 1 ? 'block' : 'none';
        nextBtn.style.display = step < totalSteps ? 'block' : 'none';
        submitBtn.style.display = step === totalSteps ? 'block' : 'none';
    }

    nextBtn.addEventListener('click', () => {
        if (validateStep(currentStep)) {
            currentStep++;
            updateStep(currentStep);
        }
    });

    prevBtn.addEventListener('click', () => {
        currentStep--;
        updateStep(currentStep);
    });

    function validateStep(step) {
        const currentStepEl = document.getElementById(`step-${step}`);
        const inputs = currentStepEl.querySelectorAll('input[required], select[required], textarea[required]');
        let isValid = true;

        inputs.forEach(input => {
            if (!input.value) {
                input.classList.add('is-invalid');
                isValid = false;
            } else {
                input.classList.remove('is-invalid');
            }
        });

        return isValid;
    }
});
</script>
@endpush
