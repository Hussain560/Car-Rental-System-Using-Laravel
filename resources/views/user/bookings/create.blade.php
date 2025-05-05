@extends('layouts.customer')

@section('content')
<div class="container py-5">
    <div class="booking-wizard">
        <!-- Progress Bar -->
        <div class="progress-container mb-4">
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 25%;" id="booking-progress"></div>
            </div>
            <div class="step-indicators d-flex justify-content-between mt-2">
                <span class="step-indicator active" data-step="1">Vehicle Details</span>
                <span class="step-indicator" data-step="2">Customer Details</span>
                <span class="step-indicator" data-step="3">Additional Services</span>
                <span class="step-indicator" data-step="4">Summary</span>
            </div>
        </div>

        <form id="booking-form" action="{{ route('user.bookings.store', $vehicle) }}" method="POST">
            @csrf
            <!-- Step 1: Vehicle Details -->
            <div class="booking-step" id="step-1">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Vehicle Details</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <img src="{{ asset($vehicle->ImagePath) }}" class="img-fluid rounded" alt="{{ $vehicle->Make }} {{ $vehicle->Model }}">
                            </div>
                            <div class="col-md-8">
                                <h5>{{ $vehicle->Make }} {{ $vehicle->Model }} {{ $vehicle->Year }}</h5>
                                <p class="text-muted">{{ $vehicle->Category }}</p>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Pick-up Date</label>
                                        <input type="text" class="form-control" 
                                               value="{{ \Carbon\Carbon::parse($pickup_date)->format('M d, Y') }}" 
                                               readonly>
                                        <input type="hidden" name="pickup_date" value="{{ $pickup_date }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Return Date</label>
                                        <input type="text" class="form-control" 
                                               value="{{ \Carbon\Carbon::parse($return_date)->format('M d, Y') }}" 
                                               readonly>
                                        <input type="hidden" name="return_date" value="{{ $return_date }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Pick-up Location</label>
                                        <input type="text" class="form-control" value="{{ $vehicle->office->Location }}" readonly>
                                        <input type="hidden" name="pickup_location" value="{{ $vehicle->office->Location }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2: Customer Details -->
            <div class="booking-step" id="step-2" style="display: none;">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Customer Details</h4>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" value="{{ Auth::user()->FirstName }} {{ Auth::user()->LastName }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="{{ Auth::user()->Email }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="text" class="form-control" value="{{ Auth::user()->PhoneNumber }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Emergency Contact</label>
                                <input type="text" class="form-control" value="{{ Auth::user()->EmergencyPhone }}" readonly>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Address</label>
                                <textarea class="form-control" rows="2" readonly>{{ Auth::user()->Address }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3: Additional Services -->
            <div class="booking-step" id="step-3" style="display: none;">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Additional Services</h4>
                        <div class="form-check additional-service">
                            <input type="checkbox" class="form-check-input" id="open_km" name="additional_services[]" value="Open KM">
                            <label class="form-check-label" for="open_km">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Open KM</h6>
                                        <small class="text-muted">Unlimited kilometers during rental period</small>
                                    </div>
                                    <span class="service-price">
                                        <x-currency :amount="70" /> / rental
                                    </span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 4: Summary -->
            <div class="booking-step" id="step-4" style="display: none;">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Booking Summary</h4>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <h6>Vehicle Information</h6>
                                <ul class="list-unstyled">
                                    <li><strong>Vehicle:</strong> {{ $vehicle->Make }} {{ $vehicle->Model }} {{ $vehicle->Year }}</li>
                                    <li><strong>Category:</strong> {{ $vehicle->Category }}</li>
                                    <li><strong>Daily Rate:</strong> <x-currency :amount="$vehicle->DailyRate" /></li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6>Rental Details</h6>
                                <ul class="list-unstyled">
                                    <li><strong>Pick-up Date:</strong> <span id="summary-pickup-date"></span></li>
                                    <li><strong>Return Date:</strong> <span id="summary-return-date"></span></li>
                                    <li><strong>Location:</strong> {{ $vehicle->office->Location }}</li>
                                </ul>
                            </div>
                            <div class="col-12">
                                <h6>Additional Services</h6>
                                <div id="summary-services">No additional services selected</div>
                            </div>
                            <div class="col-12">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">Cost Breakdown</h6>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Daily Rate × <span id="summary-days">0</span> days</span>
                                            <span id="summary-base-cost">0.00</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2" id="services-cost-row" style="display: none !important;">
                                            <span>Additional Services</span>
                                            <span id="summary-services-cost">0.00</span>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between fw-bold">
                                            <span>Total Cost</span>
                                            <span id="summary-total-cost">0.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-secondary" id="prev-step" style="display: none;">Previous</button>
                <button type="button" class="btn btn-primary" id="next-step">Next</button>
                <button type="submit" class="btn btn-success" id="confirm-booking" style="display: none;">Confirm Booking</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
.booking-wizard {
    max-width: 900px;
    margin: 0 auto;
}

.progress {
    height: 0.5rem;
}

.step-indicator {
    font-size: 0.875rem;
    color: #6c757d;
    position: relative;
    text-align: center;
}

.step-indicator.active {
    color: #0d6efd;
    font-weight: 500;
}

.additional-service {
    padding: 1rem;
    border: 1px solid #dee2e6;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
}

.service-price {
    font-weight: 500;
    color: #198754;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentStep = 1;
    const totalSteps = 4;
    const form = document.getElementById('booking-form');
    const nextBtn = document.getElementById('next-step');
    const prevBtn = document.getElementById('prev-step');
    const confirmBtn = document.getElementById('confirm-booking');
    const progressBar = document.querySelector('.progress-bar');

    // Update step visibility and progress
    function updateStep(step) {
        // Hide all steps
        document.querySelectorAll('.booking-step').forEach(el => {
            el.style.display = 'none';
        });
        
        // Show current step
        document.getElementById(`step-${step}`).style.display = 'block';
        
        // Update progress bar
        const progress = (step / totalSteps) * 100;
        progressBar.style.width = `${progress}%`;
        
        // Update step indicators
        document.querySelectorAll('.step-indicator').forEach(el => {
            el.classList.remove('active');
            if (parseInt(el.dataset.step) <= step) {
                el.classList.add('active');
            }
        });
        
        // Update button visibility
        prevBtn.style.display = step > 1 ? 'block' : 'none';
        nextBtn.style.display = step < totalSteps ? 'block' : 'none';
        confirmBtn.style.display = step === totalSteps ? 'block' : 'none';
    }

    // Validate current step
    function validateStep(step) {
        const currentStepEl = document.getElementById(`step-${step}`);
        const requiredFields = currentStepEl.querySelectorAll('input[required], select[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });

        // Special validation for dates in step 1
        if (step === 1) {
            const pickupDate = document.querySelector('input[name="pickup_date"]');
            const returnDate = document.querySelector('input[name="return_date"]');
            
            if (pickupDate.value && returnDate.value) {
                if (new Date(returnDate.value) <= new Date(pickupDate.value)) {
                    returnDate.classList.add('is-invalid');
                    isValid = false;
                }
            }
        }

        return isValid;
    }

    // Event listeners for navigation buttons
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

    // Date validation for rental period
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

    // Additional services cost calculation
    const openKmCheckbox = document.getElementById('open_km');
    if (openKmCheckbox) {
        openKmCheckbox.addEventListener('change', updateTotalCost);
    }

    function updateTotalCost() {
        const pickupDate = new Date(document.querySelector('input[name="pickup_date"]').value);
        const returnDate = new Date(document.querySelector('input[name="return_date"]').value);
        const dailyRate = {{ $vehicle->DailyRate }};
        const openKm = document.getElementById('open_km').checked;
        
        // Calculate days
        const days = Math.ceil((returnDate - pickupDate) / (1000 * 60 * 60 * 24));
        
        // Calculate costs
        const baseCost = days * dailyRate;
        const servicesCost = openKm ? 70 : 0;
        const totalCost = baseCost + servicesCost;
        
        // Update summary
        document.getElementById('summary-days').textContent = days;
        document.getElementById('summary-base-cost').textContent = baseCost.toFixed(2);
        document.getElementById('summary-services-cost').textContent = servicesCost.toFixed(2);
        document.getElementById('summary-total-cost').textContent = totalCost.toFixed(2);
        document.getElementById('services-cost-row').style.display = openKm ? 'flex' : 'none';
        
        // Update dates
        document.getElementById('summary-pickup-date').textContent = pickupDate.toLocaleDateString();
        document.getElementById('summary-return-date').textContent = returnDate.toLocaleDateString();
        
        // Update services summary
        const servicesDiv = document.getElementById('summary-services');
        servicesDiv.textContent = openKm ? 'Open KM (Unlimited kilometers)' : 'No additional services selected';
    }

    // Add event listeners for dates
    document.querySelectorAll('input[type="date"]').forEach(input => {
        input.addEventListener('change', updateTotalCost);
    });

    // Initialize the form
    updateStep(currentStep);
});
</script>
@endpush
