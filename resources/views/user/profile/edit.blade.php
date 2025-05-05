@extends('layouts.customer')

@section('title', 'Edit Profile')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Profile</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">First Name</label>
                                <input type="text" name="FirstName" class="form-control @error('FirstName') is-invalid @enderror" 
                                       value="{{ old('FirstName', Auth::user()->FirstName) }}" required>
                                @error('FirstName')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="LastName" class="form-control @error('LastName') is-invalid @enderror" 
                                       value="{{ old('LastName', Auth::user()->LastName) }}" required>
                                @error('LastName')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="Email" class="form-control @error('Email') is-invalid @enderror" 
                                       value="{{ old('Email', Auth::user()->Email) }}" required>
                                @error('Email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="PhoneNumber" class="form-control @error('PhoneNumber') is-invalid @enderror" 
                                       value="{{ old('PhoneNumber', Auth::user()->PhoneNumber) }}" required>
                                @error('PhoneNumber')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Emergency Contact</label>
                                <input type="text" name="EmergencyPhone" class="form-control @error('EmergencyPhone') is-invalid @enderror" 
                                       value="{{ old('EmergencyPhone', Auth::user()->EmergencyPhone) }}" required>
                                @error('EmergencyPhone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Address</label>
                                <textarea name="Address" class="form-control @error('Address') is-invalid @enderror" 
                                          rows="2" required>{{ old('Address', Auth::user()->Address) }}</textarea>
                                @error('Address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12">
                                <hr>
                                <h5>Change Password</h5>
                                <p class="text-muted small">Leave blank if you don't want to change the password</p>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Current Password</label>
                                <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror">
                                @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">New Password</label>
                                <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror">
                                @error('new_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" class="form-control">
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Update Profile</button>
                                <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
