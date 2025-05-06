@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title">Add New Vehicle</h1>
                <span class="text-muted">Create a new vehicle entry</span>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.vehicles.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back to Vehicles
                </a>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card">
        <div class="card-body">
            <form id="vehicle-wizard-form" action="{{ route('admin.vehicles.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Step Progress -->
                <div class="vehicle-wizard-progress mb-4">
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <span class="step-indicator active" data-step="1">Basic Info</span>
                        <span class="step-indicator" data-step="2">Specifications</span>
                        <span class="step-indicator" data-step="3">Status & Location</span>
                        <span class="step-indicator" data-step="4">Vehicle Image</span>
                    </div>
                </div>

                <!-- Step 1: Basic Information -->
                <div class="vehicle-wizard-step" id="step-1">
                    <h4 class="mb-3">Basic Vehicle Information</h4>
                    
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="make" class="form-label">Make <span class="text-danger">*</span></label>
                            <select class="form-select" id="make" name="make" required>
                                <option value="">Select a make</option>
                                <option value="Toyota">Toyota</option>
                                <option value="Hyundai">Hyundai</option>
                                <option value="Honda">Honda</option>
                                <option value="Nissan">Nissan</option>
                                <option value="Kia">Kia</option>
                                <option value="Chevrolet">Chevrolet</option>
                                <option value="Ford">Ford</option>
                                <option value="GMC">GMC</option>
                                <option value="Mitsubishi">Mitsubishi</option>
                                <option value="Mazda">Mazda</option>
                                <option value="Changan">Changan</option>
                                <option value="MG">MG</option>
                                <option value="Geely">Geely</option>
                                <option value="Geely">Chery</option>
                                <option value="Haval">Haval</option>
                                <option value="Jetour">Jetour</option>
                                <option value="Genesis">Genesis</option>
                                <option value="Mercedes-Benz">Mercedes-Benz</option>
                                <option value="BMW">BMW</option>
                                <option value="Lexus">Lexus</option>
                                <option value="Audi">Audi</option>
                                <option value="Infiniti">Infiniti</option>
                            </select>
                            @error('make')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4">
                            <label for="model" class="form-label">Model <span class="text-danger">*</span></label>
                            <select class="form-select" id="model" name="model" required disabled>
                                <option value="">Select make first</option>
                            </select>
                            @error('model')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="category_display" class="form-label">Category</label>
                            <input type="text" class="form-control" id="category_display" readonly>
                            <input type="hidden" id="category" name="category">
                            @error('category')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4">
                            <label for="year" class="form-label">Year <span class="text-danger">*</span></label>
                            <select class="form-select" id="year" name="year" required>
                                <option value="">Select a year</option>
                                @php
                                    $currentYear = date('Y');
                                    // KSA regulation: vehicles must be no older than 5 years
                                    for ($year = $currentYear; $year >= ($currentYear - 5); $year--) {
                                        echo "<option value=\"{$year}\">{$year}</option>";
                                    }
                                @endphp
                            </select>
                            <small class="form-text text-muted">
                                According to KSA regulations, rental vehicles must be no older than 5 years.
                            </small>
                            @error('year')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4">
                            <label for="license_plate" class="form-label">License Plate <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="license_plate" name="license_plate" 
                                   pattern="^[A-Za-z]{1,3}[0-9]{1,4}$"
                                   maxlength="7" required placeholder="e.g ABC1234"
                                   ">
                            <div class="form-text">Enter 1-3 letters followed by 1-4 numbers (e.g., SSF1234, A10, A1, AB123)</div>
                            @error('license_plate')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4">
                            <label for="color" class="form-label">Color <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="color" name="color" maxlength="30" required>
                            @error('color')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="serial_number" class="form-label">Serial Number</label>
                            <input type="text" class="form-control" id="serial_number" name="serial_number" 
                                   maxlength="7" placeholder="1234567" pattern="[0-9]{7}"
                                   onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                            <small class="form-text text-muted">
                                Enter the 7-digit serial number found on the vehicle registration card (numbers only).
                            </small>
                            @error('serial_number')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="date_of_expiry" class="form-label">Date of Expiry</label>
                            <input type="date" class="form-control" id="date_of_expiry" name="date_of_expiry" 
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                            <div class="form-text">Expiry date must be in the future</div>
                            @error('date_of_expiry')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Step 2: Vehicle Specifications -->
                <div class="vehicle-wizard-step" id="step-2" style="display: none;">
                    <h4 class="mb-3">Vehicle Specifications</h4>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="daily_rate" class="form-label">Daily Rate <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">@include('components.currency', ['amount' => ''])</span>
                                <input type="number" class="form-control" id="daily_rate" name="daily_rate" min="50" step="0.01" required>
                            </div>
                            @error('daily_rate')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="transmission" class="form-label">Transmission</label>
                            <input type="text" class="form-control" id="transmission" value="Automatic" readonly>
                        </div>
                        
                        <div class="col-md-4">
                            <label for="passenger_capacity" class="form-label">Passenger Capacity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="passenger_capacity" name="passenger_capacity" min="1" value="4" required>
                            @error('passenger_capacity')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4">
                            <label for="luggage_capacity" class="form-label">Luggage Capacity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="luggage_capacity" name="luggage_capacity" min="0" value="2" required>
                            @error('luggage_capacity')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4">
                            <label for="doors" class="form-label">Doors <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="doors" name="doors" min="2" value="4" required>
                            @error('doors')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Step 3: Status & Location -->
                <div class="vehicle-wizard-step" id="step-3" style="display: none;">
                    <h4 class="mb-3">Status & Location</h4>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="Available" selected>Available</option>
                                <option value="Maintenance">Maintenance</option>
                            </select>
                            @error('status')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="office_id" class="form-label">Office Location <span class="text-danger">*</span></label>
                            <select class="form-select" id="office_id" name="office_id" required>
                                <option value="">Select an office</option>
                                @foreach($offices as $office)
                                    <option value="{{ $office->OfficeID }}">{{ $office->Location }}</option>
                                @endforeach
                            </select>
                            @error('office_id')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Step 4: Vehicle Image -->
                <div class="vehicle-wizard-step" id="step-4" style="display: none;">
                    <h4 class="mb-3">Vehicle Image</h4>
                    
                    <div class="row">
                        <div class="col-md-8 mx-auto text-center">
                            <div class="image-upload-area mb-3 p-4 border rounded">
                                <img id="preview-image" src="{{ asset('images/cars/default.jpg') }}" alt="Vehicle Preview" class="img-fluid mb-3" style="max-height: 250px;">
                                
                                <div class="mb-3">
                                    <label for="image_path" class="form-label">Upload Vehicle Image</label>
                                    <input class="form-control" type="file" id="image_path" name="image_path" 
                                           accept="image/jpeg,image/png,image/jpg" onchange="validateImage(this)">
                                    <small class="form-text text-muted">
                                        Allowed formats: JPG, JPEG, PNG only.<br>
                                        Recommended size: 800x600 pixels, Max file size: 2MB.<br>
                                        The image will be saved with the naming convention: [Make]-[Model]-[Year].jpg<br>
                                        If no image is uploaded, the default image will be used.
                                    </small>
                                    <div class="invalid-feedback" id="image-error"></div>
                                    <div class="alert alert-danger mt-2 d-none" id="file-size-error">
                                        File is too large! Maximum size allowed is 2MB.
                                    </div>
                                </div>
                            </div>
                            
                            @error('image_path')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-summary mt-4">
                        <h5>Vehicle Summary</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-group mb-3">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Make:</span><span id="summary-make"></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Model:</span><span id="summary-model"></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Year:</span><span id="summary-year"></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Category:</span><span id="summary-category"></span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-group mb-3">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Status:</span><span id="summary-status"></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Daily Rate:</span><span id="summary-daily-rate"></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Passenger Capacity:</span><span id="summary-passenger-capacity"></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>License Plate:</span><span id="summary-license-plate"></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Office Location:</span><span id="summary-office-location"></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Navigation Buttons -->
                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-secondary" id="prev-step" style="display: none;">
                        <i class="bi bi-arrow-left"></i> Previous
                    </button>
                    <button type="button" class="btn btn-primary" id="next-step">
                        Next <i class="bi bi-arrow-right"></i>
                    </button>
                    <button type="submit" class="btn btn-success" id="submit-vehicle" style="display: none;">
                        <i class="bi bi-check-lg"></i> Add Vehicle
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .vehicle-wizard-progress .step-indicator {
        position: relative;
        font-size: 0.9rem;
        color: #6c757d;
    }
    
    .vehicle-wizard-progress .step-indicator.active {
        color: #0d6efd;
        font-weight: bold;
    }
    
    .vehicle-wizard-progress .step-indicator::before {
        content: attr(data-step);
        display: flex;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
        background-color: #6c757d;
        color: white;
        border-radius: 50%;
        position: absolute;
        top: -30px;
        left: 50%;
        transform: translateX(-50%);
    }
    
    .vehicle-wizard-progress .step-indicator.active::before {
        background-color: #0d6efd;
    }
    
    .image-upload-area {
        background-color: #f8f9fa;
        border: 2px dashed #dee2e6;
    }
</style>
@endpush

@push('scripts')
<script>
    // Car models database with their categories
    const carModelsData = {
        Toyota: {
            'Corolla': 'Sedan',
            'Camry': 'Sedan',
            'Crown': 'Sedan',
            'Avalon': 'Sedan',
            'Yaris': 'Small Cars',
            'Corolla Cross': 'Crossover',
            'RAV4': 'Crossover',
            'CH-R': 'Crossover',
            'Venza': 'Crossover',
            'Fortuner': 'SUV', 
            'Highlander': 'SUV',
            'Land Cruiser': 'SUV',
            '4Runner': 'SUV',
            'Sequoia': 'SUV',
            'Hilux': 'SUV'
        },
        Hyundai: {
            'Elantra': 'Sedan',
            'Sonata': 'Sedan',
            'Azera': 'Sedan',
            'Accent': 'Small Cars',
            'i10': 'Small Cars',
            'i20': 'Small Cars',
            'Bayon': 'Crossover',
            'Venue': 'Crossover',
            'Kona': 'Crossover', 
            'Tucson': 'Crossover',
            'Creta': 'SUV',
            'Santa Fe': 'SUV',
            'Palisade': 'SUV',
            'Veracruz': 'SUV'
        },
        Nissan: {
            'Sunny': 'Small Cars',
            'Versa': 'Small Cars',
            'Altima': 'Sedan', 
            'Maxima': 'Sedan',
            'Sentra': 'Sedan',
            'Kicks': 'Crossover',
            'Rogue': 'Crossover',
            'Murano': 'Crossover',
            'X-Trail': 'SUV',
            'Pathfinder': 'SUV',
            'Patrol': 'SUV',
            'Armada': 'SUV'
        },
        Honda: {
            'City': 'Small Cars',
            'Fit': 'Small Cars',
            'Civic': 'Sedan',
            'Accord': 'Sedan',
            'Insight': 'Sedan',
            'HR-V': 'Crossover',
            'BR-V': 'Crossover',
            'CR-V': 'SUV',
            'Pilot': 'SUV',
            'Passport': 'SUV'
        },
        Ford: {
            'Figo': 'Small Cars',
            'Fiesta': 'Small Cars',
            'Fusion': 'Sedan',
            'Taurus': 'Sedan',
            'Escape': 'Crossover',
            'Edge': 'Crossover',
            'Territory': 'Crossover',
            'Explorer': 'SUV',
            'Expedition': 'SUV',
            'Bronco': 'SUV',
            'F-150': 'SUV'
        },
        Chevrolet: {
            'Spark': 'Small Cars',
            'Sonic': 'Small Cars',
            'Malibu': 'Sedan',
            'Impala': 'Sedan',
            'Camaro': 'Sedan',
            'Trax': 'Crossover', 
            'Equinox': 'Crossover',
            'Blazer': 'Crossover',
            'Traverse': 'SUV',
            'Tahoe': 'SUV',
            'Suburban': 'SUV',
            'Captiva': 'SUV'
        },
        Kia: {
            'Pegas': 'Small Cars',
            'Rio': 'Small Cars',
            'Cerato': 'Sedan',
            'K5': 'Sedan',
            'Optima': 'Sedan',
            'Seltos': 'Crossover',
            'Soul': 'Crossover',
            'Sportage': 'SUV',
            'Sorento': 'SUV',
            'Telluride': 'SUV'
        },
        'Mercedes-Benz': {
            'A-Class': 'Small Cars',
            'CLA': 'Small Cars',
            'C-Class': 'Sedan',
            'E-Class': 'Sedan', 
            'S-Class': 'Sedan',
            'GLA': 'Crossover',
            'GLB': 'Crossover',
            'GLC': 'Crossover',
            'GLE': 'SUV',
            'GLS': 'SUV',
            'G-Class': 'SUV'
        },
        BMW: {
            '1 Series': 'Small Cars',
            '2 Series': 'Small Cars',
            '3 Series': 'Sedan',
            '5 Series': 'Sedan',
            '7 Series': 'Sedan',
            'X1': 'Crossover',
            'X2': 'Crossover',
            'X3': 'Crossover',
            'X4': 'Crossover',
            'X5': 'SUV',
            'X6': 'SUV', 
            'X7': 'SUV'
        },
        Lexus: {
            'CT': 'Small Cars',
            'UX': 'Small Cars',
            'IS': 'Sedan',
            'ES': 'Sedan',
            'LS': 'Sedan',
            'NX': 'Crossover',
            'RX': 'Crossover',
            'GX': 'SUV',
            'LX': 'SUV',
            'RX L': 'SUV'
        },
        GMC: {
            'Acadia': 'SUV',
            'Terrain': 'Crossover',
            'Yukon': 'SUV',
            'Sierra': 'SUV',
            'Canyon': 'SUV'
        },
        Mitsubishi: {
            'Mirage': 'Small Cars',
            'Attrage': 'Sedan',
            'Lancer': 'Sedan',
            'Eclipse Cross': 'Crossover',
            'ASX': 'Crossover',
            'Outlander': 'SUV',
            'Pajero': 'SUV',
            'Montero Sport': 'SUV'
        },
        Mazda: {
            'Mazda2': 'Small Cars',
            'Mazda3': 'Sedan',
            'Mazda6': 'Sedan',
            'CX-3': 'Crossover',
            'CX-30': 'Crossover',
            'CX-5': 'SUV',
            'CX-9': 'SUV'
        },
        Changan: {
            'Alsvin': 'Sedan',
            'Eado': 'Sedan',
            'CS15': 'Crossover',
            'CS35': 'Crossover',
            'CS55': 'SUV',
            'CS75': 'SUV',
            'CS85': 'SUV',
            'CS95': 'SUV'
        },
        MG: {
            'MG3': 'Small Cars',
            'MG4': 'Small Cars',
            'MG5': 'Sedan',
            'MG6': 'Sedan',
            'GT': 'Sedan',
            'ZS': 'Crossover',
            'HS': 'Crossover',
            'RX5': 'SUV',
            'RX8': 'SUV'
        },
        Geely: {
            'GC6': 'Sedan',
            'Emgrand': 'Sedan',
            'Coolray': 'Crossover',
            'Azkarra': 'Crossover',
            'Okavango': 'SUV',
            'Monjaro': 'SUV',
            'X70': 'SUV'
        },
        Chery: {
            'Arrizo3': 'Sedan',
            'Arrizo5': 'Sedan',
            'Arrizo7': 'Sedan',
            'Tiggo2': 'Crossover',
            'Tiggo3': 'Crossover',
            'Tiggo4': 'Crossover',
            'Tiggo7': 'SUV',
            'Tiggo8': 'SUV'
        },
        Haval: {
            'Jolion': 'Crossover',
            'H2': 'Crossover',
            'H4': 'Crossover',
            'H6': 'Crossover',
            'H8': 'SUV',
            'H9': 'SUV',
            'Big Dog': 'SUV'
        },
        Jetour: {
            'X70': 'Crossover',
            'X90': 'SUV',
            'X95': 'SUV',
            'Dashing': 'Crossover'
        },
        Genesis: {
            'G70': 'Sedan',
            'G80': 'Sedan',
            'G90': 'Sedan',
            'GV60': 'Crossover',
            'GV70': 'Crossover',
            'GV80': 'SUV'
        },
        Audi: {
            'A1': 'Small Cars',
            'A3': 'Sedan',
            'A4': 'Sedan',
            'A5': 'Sedan',
            'A6': 'Sedan',
            'A7': 'Sedan',
            'A8': 'Sedan',
            'Q2': 'Crossover',
            'Q3': 'Crossover',
            'Q5': 'SUV',
            'Q7': 'SUV',
            'Q8': 'SUV'
        },
        Infiniti: {
            'Q30': 'Small Cars',
            'Q50': 'Sedan',
            'Q60': 'Sedan',
            'QX30': 'Crossover',
            'QX50': 'Crossover',
            'QX55': 'Crossover',
            'QX60': 'SUV',
            'QX80': 'SUV'
        }
    };

    document.addEventListener('DOMContentLoaded', function() {
        let currentStep = 1;
        const totalSteps = 4;
        
        const nextBtn = document.getElementById('next-step');
        const prevBtn = document.getElementById('prev-step');
        const submitBtn = document.getElementById('submit-vehicle');
        const progressBar = document.querySelector('.progress-bar');
        
        // Make and model selection logic
        const makeSelect = document.getElementById('make');
        const modelSelect = document.getElementById('model');
        const categoryDisplay = document.getElementById('category_display');
        const categoryInput = document.getElementById('category');
        
        // Update models when make is selected
        makeSelect.addEventListener('change', function() {
            const make = this.value;
            
            // Clear current options
            modelSelect.innerHTML = '<option value="">Select a model</option>';
            categoryDisplay.value = '';
            categoryInput.value = '';
            
            // Add new options if make is selected
            if (make && carModelsData[make]) {
                Object.entries(carModelsData[make]).forEach(([model, category]) => {
                    const option = document.createElement('option');
                    option.value = model;
                    option.textContent = model;
                    option.dataset.category = category;
                    modelSelect.appendChild(option);
                });
                modelSelect.disabled = false;
            } else {
                modelSelect.disabled = true;
            }
        });
        
        // Update category when model is selected
        modelSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.dataset.category) {
                categoryDisplay.value = selectedOption.dataset.category;
                categoryInput.value = selectedOption.dataset.category;
            } else {
                categoryDisplay.value = '';
                categoryInput.value = '';
            }
        });
        
        // File input preview
        const imageInput = document.getElementById('image_path');
        const previewImage = document.getElementById('preview-image');
        
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
        
        // Navigation functions
        function updateStep(step) {
            // Hide all steps
            document.querySelectorAll('.vehicle-wizard-step').forEach(el => {
                el.style.display = 'none';
            });
            
            // Show current step
            document.getElementById(`step-${step}`).style.display = 'block';
            
            // Update progress bar
            const progress = (step / totalSteps) * 100;
            progressBar.style.width = `${progress}%`;
            progressBar.setAttribute('aria-valuenow', progress);
            progressBar.textContent = `${progress}%`;
            
            // Update step indicators
            document.querySelectorAll('.step-indicator').forEach(el => {
                el.classList.remove('active');
            });
            document.querySelector(`.step-indicator[data-step="${step}"]`).classList.add('active');
            
            // Show/hide navigation buttons
            prevBtn.style.display = step > 1 ? 'block' : 'none';
            nextBtn.style.display = step < totalSteps ? 'block' : 'none';
            submitBtn.style.display = step === totalSteps ? 'block' : 'none';
            
            // If on the last step, update the summary
            if (step === totalSteps) {
                updateSummary();
            }
        }
        
        function updateSummary() {
            document.getElementById('summary-make').textContent = document.getElementById('make').value;
            document.getElementById('summary-model').textContent = document.getElementById('model').value;
            document.getElementById('summary-year').textContent = document.getElementById('year').value;
            document.getElementById('summary-category').textContent = document.getElementById('category_display').value;
            document.getElementById('summary-status').textContent = document.getElementById('status').value;
            
            // Get the daily rate value
            const dailyRateValue = document.getElementById('daily_rate').value || '0';
            
            // Create a temporary hidden div to hold the currency component
            const tempDiv = document.createElement('div');
            tempDiv.style.display = 'none';
            document.body.appendChild(tempDiv);
            
            // Use fetch to get the rendered currency component with the current daily rate
            fetch(`/render-currency?amount=${dailyRateValue}`)
                .then(response => response.text())
                .then(html => {
                    // Set the HTML content to the summary-daily-rate element
                    document.getElementById('summary-daily-rate').innerHTML = html;
                    // Remove the temporary div
                    document.body.removeChild(tempDiv);
                })
                .catch(error => {
                    // Fallback in case of error
                    document.getElementById('summary-daily-rate').innerHTML = `<span class="price">
                        <img src="/images/Saudi_Riyal_Symbol.svg" alt="SAR" style="height: 1em; margin-right: 2px; vertical-align: middle;">
                        ${parseFloat(dailyRateValue).toFixed(2)}
                    </span>`;
                    // Remove the temporary div
                    document.body.removeChild(tempDiv);
                });
            
            document.getElementById('summary-passenger-capacity').textContent = document.getElementById('passenger_capacity').value;
            document.getElementById('summary-license-plate').textContent = document.getElementById('license_plate').value;
            
            // Add office location to summary
            const officeSelect = document.getElementById('office_id');
            const selectedOffice = officeSelect.options[officeSelect.selectedIndex];
            document.getElementById('summary-office-location').textContent = selectedOffice.text || 'Not selected';
        }
        
        // Validate current step
        function validateStep(step) {
            let isValid = true;
            
            if (step === 1) {
                // Basic Info validation
                const requiredFields = ['make', 'model', 'year', 'license_plate', 'color'];  // Added 'color'
                requiredFields.forEach(field => {
                    const input = document.getElementById(field);
                    if (!input.value.trim()) {
                        input.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        input.classList.remove('is-invalid');
                    }
                });
                
                // Make sure category is set
                if (!categoryInput.value) {
                    modelSelect.classList.add('is-invalid');
                    isValid = false;
                }
            } else if (step === 2) {
                // Specifications validation
                const dailyRate = document.getElementById('daily_rate');
                const passengerCapacity = document.getElementById('passenger_capacity');
                const luggageCapacity = document.getElementById('luggage_capacity');
                const doors = document.getElementById('doors');
                
                if (!dailyRate.value || dailyRate.value < 50) {
                    dailyRate.classList.add('is-invalid');
                    isValid = false;
                } else {
                    dailyRate.classList.remove('is-invalid');
                }
                
                if (!passengerCapacity.value || passengerCapacity.value < 1) {
                    passengerCapacity.classList.add('is-invalid');
                    isValid = false;
                } else {
                    passengerCapacity.classList.remove('is-invalid');
                }
                
                if (!luggageCapacity.value || luggageCapacity.value < 0) {
                    luggageCapacity.classList.add('is-invalid');
                    isValid = false;
                } else {
                    luggageCapacity.classList.remove('is-invalid');
                }
                
                if (!doors.value || doors.value < 2) {
                    doors.classList.add('is-invalid');
                    isValid = false;
                } else {
                    doors.classList.remove('is-invalid');
                }
            } else if (step === 3) {
                // Status & Location validation
                const status = document.getElementById('status');
                const officeLocation = document.getElementById('office_id');

                if (!status.value) {
                    status.classList.add('is-invalid');
                    isValid = false;
                } else {
                    status.classList.remove('is-invalid');
                }

                if (!officeLocation.value) {
                    officeLocation.classList.add('is-invalid');
                    // Create or update error message
                    let errorDiv = officeLocation.nextElementSibling;
                    if (!errorDiv || !errorDiv.classList.contains('invalid-feedback')) {
                        errorDiv = document.createElement('div');
                        errorDiv.classList.add('invalid-feedback');
                        officeLocation.parentNode.appendChild(errorDiv);
                    }
                    errorDiv.textContent = 'Please select an office location';
                    isValid = false;
                } else {
                    officeLocation.classList.remove('is-invalid');
                }
            }
            
            return isValid;
        }
        
        // Event listeners
        nextBtn.addEventListener('click', function() {
            if (validateStep(currentStep)) {
                currentStep++;
                updateStep(currentStep);
            }
        });
        
        prevBtn.addEventListener('click', function() {
            currentStep--;
            updateStep(currentStep);
        });
        
        // Form submission
        const form = document.getElementById('vehicle-wizard-form');
        form.addEventListener('submit', function(e) {
            if (!validateStep(currentStep)) {
                e.preventDefault();
            }
            const imageInput = document.getElementById('image_path');
            if (imageInput.files.length > 0) {
                const isValid = validateImage(imageInput);
                if (!isValid) {
                    e.preventDefault();
                }
            }
        });
        
        // Initialize form
        updateStep(currentStep);

        // Add date of expiry validation
        const expiryInput = document.querySelector('input[name="date_of_expiry"]');
        expiryInput.addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const today = new Date();
            
            if (selectedDate <= today) {
                this.value = ''; // Clear invalid date
                alert('Expiry date must be in the future');
            }
        });

        // Add license plate validation
        const licensePlateInput = document.getElementById('license_plate');
        licensePlateInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
            if (!this.value.match(/^[A-Z]{0,3}[0-9]{0,4}$/)) {
                this.value = this.value.replace(/[^A-Z0-9]/g, '');
                const letters = this.value.match(/^[A-Z]+/) || [''];
                const numbers = this.value.match(/[0-9]+$/) || [''];
                this.value = letters[0].slice(0,3) + numbers[0].slice(0,4);
            }
        });

        // Add serial number validation
        const serialInput = document.getElementById('serial_number');
        serialInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Update image validation function
        function validateImage(input) {
            const file = input.files[0];
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            const maxSize = 2 * 1024 * 1024; // 2MB
            
            const errorDiv = document.getElementById('image-error');
            const sizeErrorDiv = document.getElementById('file-size-error');
            input.classList.remove('is-invalid');
            errorDiv.textContent = '';
            sizeErrorDiv.classList.add('d-none');
            
            if (file) {
                // Check file size first
                if (file.size > maxSize) {
                    input.value = '';
                    document.getElementById('preview-image').src = '{{ asset("images/cars/default.jpg") }}';
                    input.classList.add('is-invalid');
                    errorDiv.textContent = 'File size must be less than 2MB';
                    sizeErrorDiv.classList.remove('d-none');
                    sizeErrorDiv.textContent = `Current file size: ${(file.size / (1024 * 1024)).toFixed(2)}MB. Maximum allowed: 2MB`;
                    return false;
                }

                // Then check file type
                if (!allowedTypes.includes(file.type)) {
                    input.value = '';
                    document.getElementById('preview-image').src = '{{ asset("images/cars/default.jpg") }}';
                    input.classList.add('is-invalid');
                    errorDiv.textContent = 'Invalid file type. Please upload JPG, JPEG or PNG files only.';
                    return false;
                }
                
                // Valid file, show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                }
                reader.readAsDataURL(file);
                return true;
            }
            return true;
        }

        // Add form validation for image on submit
        form.addEventListener('submit', function(e) {
            const imageInput = document.getElementById('image_path');
            if (imageInput.files.length > 0 && !validateImage(imageInput)) {
                e.preventDefault();
                // Scroll to error message
                document.querySelector('.image-upload-area').scrollIntoView({ behavior: 'smooth' });
            }
            // ...rest of your form validation...
        });
    });
</script>
@endpush
@endsection