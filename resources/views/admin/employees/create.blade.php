@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="page-header mb-4">
        <div class="col">
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('admin.employees.index') }}" class="btn btn-icon btn-light">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h1 class="page-header-title">Add New Employee</h1>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <!-- Step Progress Bar -->
                    <div class="row mb-4">
                        <div class="col">
                            <div class="progress" style="height: 4px;">
                                <div class="progress-bar" role="progressbar" id="stepProgress"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <span class="step-indicator active" data-step="1">Personal Info</span>
                                <span class="step-indicator" data-step="2">Contact Details</span>
                                <span class="step-indicator" data-step="3">Employment Info</span>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('admin.employees.store') }}" method="POST" enctype="multipart/form-data" id="employeeForm">
                        @csrf
                        
                        <!-- Step 1: Personal Information -->
                        <div class="step-content" id="step1">
                            <h5 class="mb-3">Personal Information</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="first_name" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="last_name" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                    <?php 
                                        $maxDate = date('Y-m-d', strtotime('-18 years'));
                                    ?>
                                    <input type="date" class="form-control" name="date_of_birth" 
                                           max="{{ $maxDate }}" 
                                           required>
                                    <div class="form-text">Must be at least 18 years old</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nationality <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nationality" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">National ID <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="national_id" 
                                           maxlength="10" pattern="[0-9]{10}"
                                           placeholder="Enter 10 digits" required>
                                    <div class="form-text">National ID must be 10 digits</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">ID Expiry Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="id_expiry_date" 
                                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                           required>
                                    <div class="form-text">ID must not be expired</div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Contact Information -->
                        <div class="step-content d-none" id="step2">
                            <h5 class="mb-3">Contact Information</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">+966</span>
                                        <input type="text" class="form-control" name="phone_number" 
                                               maxlength="9" placeholder="5XXXXXXXX" required 
                                               pattern="[0-9]{9}">
                                    </div>
                                    <div class="form-text">Enter 9 digits without the prefix</div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Address <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="address" rows="2" required></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Emergency Contact Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="emergency_contact_name" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Emergency Contact Number <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">+966</span>
                                        <input type="text" class="form-control" name="emergency_contact" 
                                               maxlength="9" placeholder="5XXXXXXXX" required
                                               pattern="[0-9]{9}">
                                    </div>
                                    <div class="form-text">Enter 9 digits without the prefix</div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Employment Information -->
                        <div class="step-content d-none" id="step3">
                            <h5 class="mb-3">Employment Information</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Username <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="username" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Office Location <span class="text-danger">*</span></label>
                                    <select name="office_id" class="form-select" required>
                                        <option value="">Select Office</option>
                                        @foreach($offices as $office)
                                            <option value="{{ $office->OfficeID }}">
                                                {{ $office->Name }} ({{ $office->Location }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Join Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="join_date" value="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Profile Image</label>
                                    <input type="file" class="form-control" name="image" accept="image/*">
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary" id="prevBtn" style="display: none;">Previous</button>
                            <button type="button" class="btn btn-primary" id="nextBtn">Next</button>
                            <button type="submit" class="btn btn-success" id="submitBtn" style="display: none;">Create Employee</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5>Note</h5>
                    <p class="text-muted mb-0">
                        A random password will be generated for the new employee. 
                        They will be required to change it upon their first login.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .step-indicator { color: #6c757d; }
    .step-indicator.active { color: #0d6efd; font-weight: 600; }
    .progress-bar { transition: width .3s ease; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('employeeForm');
    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('prevBtn');
    const submitBtn = document.getElementById('submitBtn');
    const progressBar = document.getElementById('stepProgress');
    let currentStep = 1;
    const totalSteps = 3;

    function validateStep(step) {
        const currentStepDiv = document.getElementById('step' + step);
        const inputs = currentStepDiv.querySelectorAll('input[required], select[required], textarea[required]');
        let isValid = true;

        inputs.forEach(input => {
            if (!input.value) {
                isValid = false;
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
            }
        });

        return isValid;
    }

    function updateStep(step) {
        document.querySelectorAll('.step-content').forEach(el => el.classList.add('d-none'));
        document.getElementById('step' + step).classList.remove('d-none');
        
        document.querySelectorAll('.step-indicator').forEach(el => {
            el.classList.remove('active');
            if (parseInt(el.dataset.step) <= step) {
                el.classList.add('active');
            }
        });

        progressBar.style.width = ((step - 1) / (totalSteps - 1) * 100) + '%';
        
        prevBtn.style.display = step > 1 ? 'block' : 'none';
        nextBtn.style.display = step < totalSteps ? 'block' : 'none';
        submitBtn.style.display = step === totalSteps ? 'block' : 'none';
    }

    nextBtn.addEventListener('click', () => {
        if (validateStep(currentStep)) {
            if (currentStep < totalSteps) {
                currentStep++;
                updateStep(currentStep);
            }
        }
    });

    prevBtn.addEventListener('click', () => {
        if (currentStep > 1) {
            currentStep--;
            updateStep(currentStep);
        }
    });

    // Add real-time validation
    document.querySelectorAll('input[required], select[required], textarea[required]').forEach(input => {
        input.addEventListener('blur', function() {
            if (!this.value) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    });

    // Add date validation
    const dobInput = document.querySelector('input[name="date_of_birth"]');
    dobInput.addEventListener('change', function() {
        const selectedDate = new Date(this.value);
        const today = new Date();
        const age = today.getFullYear() - selectedDate.getFullYear();
        
        if (age < 18) {
            this.value = ''; // Clear invalid date
            alert('Employee must be at least 18 years old');
        }
    });

    // Add ID expiry date validation
    const idExpiryInput = document.querySelector('input[name="id_expiry_date"]');
    idExpiryInput.addEventListener('change', function() {
        const selectedDate = new Date(this.value);
        const today = new Date();
        
        if (selectedDate <= today) {
            this.value = ''; // Clear invalid date
            alert('ID Expiry Date must be in the future');
        }
    });

    // Prevent form submission if current step is invalid
    form.addEventListener('submit', function(e) {
        if (!validateStep(currentStep)) {
            e.preventDefault();
        }
    });
});
</script>
@endpush

@if(session('generated_password'))
<div class="modal fade" id="passwordModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Generated Password</h5>
                <div class="ms-2">
                    <span id="timer" class="badge bg-info">35</span>
                </div>
            </div>
            <div class="modal-body">
                <div class="alert alert-info mb-3">
                    <p class="mb-1"><strong>Generated password for new employee:</strong></p>
                    <code class="fs-5">{{ session('generated_password') }}</code>
                    <p class="mt-2 mb-0"><small>Please make sure to save or share this password securely.</small></p>
                </div>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" id="timerBar" style="width: 100%"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="closeModal">Got it!</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = new bootstrap.Modal(document.getElementById('passwordModal'));
        const timerElement = document.getElementById('timer');
        const timerBar = document.getElementById('timerBar');
        const closeBtn = document.getElementById('closeModal');
        let timeLeft = 35;
        
        modal.show();
        
        const timer = setInterval(() => {
            timeLeft--;
            timerElement.textContent = timeLeft;
            timerBar.style.width = (timeLeft / 35 * 100) + '%';
            
            if (timeLeft <= 0) {
                clearInterval(timer);
                modal.hide();
            }
        }, 1000);

        closeBtn.addEventListener('click', () => {
            clearInterval(timer);
            modal.hide();
        });
    });
</script>
@endpush
@endif
@endsection
