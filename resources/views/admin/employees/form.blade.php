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
                    <div>
                        <h1 class="page-header-title">{{ isset($employee) ? 'Edit Employee' : 'Add New Employee' }}</h1>
                        <span class="text-muted">
                            {{ isset($employee) ? 'Update employee information' : 'Create a new employee account' }}
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
                    <form action="{{ isset($employee) ? route('admin.employees.update', $employee) : route('admin.employees.store') }}" 
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(isset($employee))
                            @method('PUT')
                        @endif

                        <!-- Personal Information -->
                        <div class="mb-4">
                            <h5>Personal Information</h5>
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label class="form-label" for="first_name">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                           id="first_name" name="first_name" 
                                           value="{{ old('first_name', $employee->FirstName ?? '') }}" required>
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-6">
                                    <label class="form-label" for="last_name">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                           id="last_name" name="last_name" 
                                           value="{{ old('last_name', $employee->LastName ?? '') }}" required>
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-6">
                                    <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" 
                                           value="{{ old('email', $employee->Email ?? '') }}" required>
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
                                               value="{{ old('phone_number', substr($employee->PhoneNumber ?? '', 4)) }}"
                                               pattern="[0-9]{9}" placeholder="5XXXXXXXX" required>
                                    </div>
                                    @error('phone_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Account Information -->
                        <div class="mb-4">
                            <h5>Account Information</h5>
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label class="form-label" for="username">Username <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                           id="username" name="username" 
                                           value="{{ old('username', $employee->Username ?? '') }}" required>
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-6">
                                    <label class="form-label" for="role">Role <span class="text-danger">*</span></label>
                                    <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                        <option value="">Select Role</option>
                                        @if(auth()->guard('admin')->user()->Role === 'Manager')
                                            <option value="Manager" {{ (old('role', $employee->Role ?? '') === 'Manager') ? 'selected' : '' }}>
                                                Manager
                                            </option>
                                        @endif
                                        <option value="Employee" {{ (old('role', $employee->Role ?? '') === 'Employee') ? 'selected' : '' }}>
                                            Employee
                                        </option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                @if(!isset($employee))
                                <div class="col-sm-6">
                                    <label class="form-label" for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-6">
                                    <label class="form-label" for="password_confirmation">
                                        Confirm Password <span class="text-danger">*</span>
                                    </label>
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation" required>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Profile Image -->
                        <div class="mb-4">
                            <h5>Profile Image</h5>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        @if(isset($employee) && $employee->ImagePath)
                                            <img src="{{ Storage::url($employee->ImagePath) }}" 
                                                 alt="{{ $employee->FirstName }} {{ $employee->LastName }}"
                                                 class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                                        @else
                                            <div class="avatar avatar-xxl bg-soft-primary rounded-circle">
                                                <span class="avatar-initials display-4">
                                                    {{ isset($employee) ? strtoupper(substr($employee->FirstName, 0, 1) . substr($employee->LastName, 0, 1)) : 'NA' }}
                                                </span>
                                            </div>
                                        @endif
                                        <div class="flex-grow-1">
                                            <label class="form-label" for="image">Upload New Image</label>
                                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                                   id="image" name="image" accept="image/*">
                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">
                                                Recommended: Square image, at least 200x200 pixels. Max size: 2MB.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                {{ isset($employee) ? 'Update Employee' : 'Create Employee' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-header-title">Guidelines</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6>Username Requirements</h6>
                        <ul class="text-muted small mb-0">
                            <li>At least 4 characters long</li>
                            <li>Can contain letters and numbers</li>
                            <li>No special characters except underscore</li>
                            <li>Must be unique in the system</li>
                        </ul>
                    </div>

                    @if(!isset($employee))
                    <div class="mb-4">
                        <h6>Password Requirements</h6>
                        <ul class="text-muted small mb-0">
                            <li>At least 8 characters long</li>
                            <li>Must contain at least one uppercase letter</li>
                            <li>Must contain at least one lowercase letter</li>
                            <li>Must contain at least one number</li>
                            <li>Must contain at least one special character</li>
                        </ul>
                    </div>
                    @endif

                    <div>
                        <h6>Role Permissions</h6>
                        <div class="mb-3">
                            <strong class="d-block text-dark mb-2">Manager</strong>
                            <ul class="text-muted small mb-0">
                                <li>Full system access</li>
                                <li>Can manage all employees</li>
                                <li>Can promote/demote roles</li>
                                <li>Access to financial reports</li>
                            </ul>
                        </div>
                        <div>
                            <strong class="d-block text-dark mb-2">Employee</strong>
                            <ul class="text-muted small mb-0">
                                <li>Basic system access</li>
                                <li>Can manage bookings</li>
                                <li>Can view reports</li>
                                <li>Limited administrative actions</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            @if(isset($employee))
            <div class="card">
                <div class="card-header">
                    <h5 class="card-header-title">Password Management</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">To change the employee's password, use the password reset functionality.</p>
                    <a href="{{ route('admin.employees.password.reset', $employee) }}" class="btn btn-soft-primary btn-sm">
                        Reset Password
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .avatar-xxl {
        width: 100px;
        height: 100px;
        font-size: 2.5rem;
    }
    .avatar-initials {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        font-weight: 500;
    }
    .bg-soft-primary {
        background-color: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
    }
    .btn-soft-primary {
        color: #0d6efd;
        background-color: rgba(13, 110, 253, 0.1);
        border-color: transparent;
    }
    .btn-soft-primary:hover {
        color: #fff;
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-format phone number input
    document.getElementById('phone_number').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 9) {
            value = value.substr(0, 9);
        }
        e.target.value = value;
    });

    // Preview image before upload
    document.getElementById('image').addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.querySelector('.avatar-xxl');
                if (preview.tagName === 'DIV') {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = 'Profile Preview';
                    img.className = 'rounded-circle';
                    img.style.width = '100px';
                    img.style.height = '100px';
                    img.style.objectFit = 'cover';
                    preview.parentNode.replaceChild(img, preview);
                } else {
                    preview.src = e.target.result;
                }
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });
</script>
@endpush
@endsection