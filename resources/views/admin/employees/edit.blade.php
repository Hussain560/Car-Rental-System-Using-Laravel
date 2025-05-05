@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.employees.index') }}" class="btn btn-icon btn-light">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <h1 class="page-header-title">Edit Employee</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.employees.update', $employee) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3">
                            <!-- Personal Information -->
                            <div class="col-12"><h5>Personal Information</h5></div>

                            <div class="col-md-6">
                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="first_name" 
                                       value="{{ old('first_name', $employee->FirstName) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="last_name" 
                                       value="{{ old('last_name', $employee->LastName) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="date_of_birth" 
                                       value="{{ old('date_of_birth', optional($employee->DateOfBirth)->format('Y-m-d')) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nationality <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nationality" 
                                       value="{{ old('nationality', $employee->Nationality) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">National ID <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="national_id" 
                                       value="{{ old('national_id', $employee->NationalID) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">ID Expiry Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="id_expiry_date" 
                                       value="{{ old('id_expiry_date', optional($employee->IDExpiryDate)->format('Y-m-d')) }}" required>
                            </div>

                            <!-- Contact Information -->
                            <div class="col-12"><h5 class="mt-4">Contact Information</h5></div>

                            <div class="col-md-6">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" 
                                       value="{{ old('email', $employee->Email) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">+966</span>
                                    <input type="text" class="form-control" name="phone_number" 
                                           value="{{ old('phone_number', substr($employee->PhoneNumber, 4)) }}" 
                                           maxlength="9" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Address <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="address" rows="2" required>{{ old('address', $employee->Address) }}</textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Emergency Contact Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="emergency_contact_name" 
                                       value="{{ old('emergency_contact_name', $employee->EmergencyContactName) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Emergency Contact Number <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">+966</span>
                                    <input type="text" class="form-control" name="emergency_contact" 
                                           value="{{ old('emergency_contact', substr($employee->EmergencyContact, 4)) }}" 
                                           maxlength="9" required>
                                </div>
                            </div>

                            <!-- Employment Information -->
                            <div class="col-12"><h5 class="mt-4">Employment Information</h5></div>

                            <div class="col-md-6">
                                <label class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="username" 
                                       value="{{ old('username', $employee->Username) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Office <span class="text-danger">*</span></label>
                                <select name="office_id" class="form-select" required>
                                    @foreach($offices as $office)
                                        <option value="{{ $office->OfficeID }}" 
                                            {{ old('office_id', $employee->OfficeID) == $office->OfficeID ? 'selected' : '' }}>
                                            {{ $office->Name }} ({{ $office->Location }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Join Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="join_date" 
                                       value="{{ old('join_date', optional($employee->JoinDate)->format('Y-m-d')) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select" required>
                                    <option value="Active" {{ old('status', $employee->Status) == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ old('status', $employee->Status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="Suspended" {{ old('status', $employee->Status) == 'Suspended' ? 'selected' : '' }}>Suspended</option>
                                </select>
                            </div>

                            <!-- Profile Image -->
                            <div class="col-12">
                                <label class="form-label">Profile Image</label>
                                <div class="d-flex align-items-center gap-3">
                                    @if($employee->ImagePath)
                                        <img src="{{ asset($employee->ImagePath) }}" 
                                             alt="Current Profile" class="rounded-circle"
                                             style="width: 64px; height: 64px; object-fit: cover;">
                                    @endif
                                    <input type="file" class="form-control" name="image" accept="image/*">
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Employee</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
