@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.offices.index') }}" class="btn btn-icon btn-light">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="page-header-title">{{ isset($office) ? 'Edit Office' : 'Add New Office' }}</h1>
                        <span class="text-muted">
                            {{ isset($office) ? 'Update office location details' : 'Create a new office location' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ isset($office) ? route('admin.offices.update', $office) : route('admin.offices.store') }}" 
                          method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @if(isset($office))
                            @method('PUT')
                        @endif

                        <!-- Basic Information -->
                        <div class="mb-4">
                            <h5>Basic Information</h5>
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label class="form-label" for="name">Office Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $office->Name ?? '') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-6">
                                    <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', $office->Email ?? '') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-6">
                                    <label class="form-label" for="phone_number">Phone Number <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">+966</span>
                                        <input type="tel" class="form-control @error('phone_number') is-invalid @enderror" 
                                               id="phone_number" name="phone_number" 
                                               value="{{ old('phone_number', substr($office->PhoneNumber ?? '', 4)) }}"
                                               pattern="[0-9]{9}" placeholder="5XXXXXXXX" required>
                                    </div>
                                    @error('phone_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-6">
                                    <label class="form-label" for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        <option value="Active" {{ (old('status', $office->Status ?? '') === 'Active') ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="Inactive" {{ (old('status', $office->Status ?? '') === 'Inactive') ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                        <option value="Maintenance" {{ (old('status', $office->Status ?? '') === 'Maintenance') ? 'selected' : '' }}>
                                            Under Maintenance
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Image Upload -->
                        <div class="mb-4">
                            <h5>Office Image</h5>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label" for="image">Office Image</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                           id="image" name="image" accept="image/*">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if(isset($office) && $office->ImagePath)
                                        <div class="mt-2">
                                            <img src="{{ asset($office->ImagePath) }}" alt="Current office image" 
                                                 class="rounded" style="max-height: 100px;">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Location Information -->
                        <div class="mb-4">
                            <h5>Location Information</h5>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label" for="location">Location <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                           id="location" name="location" 
                                           value="{{ old('location', $office->Location ?? '') }}" required>
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-12">
                                    <label class="form-label" for="address">Street Address <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                           id="address" name="address" 
                                           value="{{ old('address', $office->Address ?? '') }}" required>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-6">
                                    <label class="form-label" for="city">City <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                           id="city" name="city" value="{{ old('city', $office->City ?? '') }}" required>
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-6">
                                    <label class="form-label" for="postal_code">Postal Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('postal_code') is-invalid @enderror" 
                                           id="postal_code" name="postal_code" 
                                           value="{{ old('postal_code', $office->PostalCode ?? '') }}" 
                                           pattern="[0-9]{5}" placeholder="12345" required>
                                    @error('postal_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Operation Hours -->
                        <div class="mb-4">
                            <h5>Operation Hours</h5>
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label class="form-label" for="opening_time">Opening Time <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control @error('opening_time') is-invalid @enderror" 
                                           id="opening_time" name="opening_time" 
                                           value="{{ old('opening_time', isset($office) ? \Carbon\Carbon::parse($office->OpeningTime)->format('H:i') : '') }}" required>
                                    @error('opening_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-6">
                                    <label class="form-label" for="closing_time">Closing Time <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control @error('closing_time') is-invalid @enderror" 
                                           id="closing_time" name="closing_time" 
                                           value="{{ old('closing_time', isset($office) ? \Carbon\Carbon::parse($office->ClosingTime)->format('H:i') : '') }}" required>
                                    @error('closing_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="mb-4">
                            <h5>Additional Information</h5>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label" for="description">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="3">{{ old('description', $office->Description ?? '') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        Provide any additional information about this office location that may be helpful.
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label" for="notes">Internal Notes</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                                              id="notes" name="notes" rows="3">{{ old('notes', $office->Notes ?? '') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        These notes are for internal use only and won't be shown to customers.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('admin.offices.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                {{ isset($office) ? 'Update Office' : 'Create Office' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-header-title">Guidelines</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6>Required Information</h6>
                        <ul class="text-muted small mb-0">
                            <li>Office name should be unique and descriptive</li>
                            <li>Valid email address for office communications</li>
                            <li>Saudi phone number starting with 5</li>
                            <li>Complete address with postal code</li>
                            <li>Operation hours in 24-hour format</li>
                        </ul>
                    </div>

                    <div>
                        <h6>Office Status</h6>
                        <div class="mb-3">
                            <strong class="d-block text-success mb-2">Active</strong>
                            <ul class="text-muted small mb-0">
                                <li>Fully operational</li>
                                <li>Can accept new bookings</li>
                                <li>Visible to customers</li>
                            </ul>
                        </div>
                        <div class="mb-3">
                            <strong class="d-block text-warning mb-2">Under Maintenance</strong>
                            <ul class="text-muted small mb-0">
                                <li>Temporarily closed</li>
                                <li>No new bookings allowed</li>
                                <li>Existing bookings need review</li>
                            </ul>
                        </div>
                        <div>
                            <strong class="d-block text-secondary mb-2">Inactive</strong>
                            <ul class="text-muted small mb-0">
                                <li>Permanently closed</li>
                                <li>Hidden from customers</li>
                                <li>Historical data preserved</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Format phone number
    document.getElementById('phone_number').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 9) {
            value = value.substr(0, 9);
        }
        e.target.value = value;
    });
</script>
@endpush
@endsection