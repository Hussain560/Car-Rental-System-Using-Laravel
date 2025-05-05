@extends('layouts.customer')

@section('title', 'My Profile')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">My Profile</h4>
                    <a href="{{ route('profile.edit') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-pencil me-1"></i>Edit Profile
                    </a>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Full Name</h6>
                            <p class="mb-0">{{ Auth::user()->FirstName }} {{ Auth::user()->LastName }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Email</h6>
                            <p class="mb-0">{{ Auth::user()->Email }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Phone Number</h6>
                            <p class="mb-0">{{ Auth::user()->PhoneNumber }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Emergency Contact</h6>
                            <p class="mb-0">{{ Auth::user()->EmergencyPhone }}</p>
                        </div>
                        <div class="col-12">
                            <h6 class="text-muted mb-1">Address</h6>
                            <p class="mb-0">{{ Auth::user()->Address }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Date of Birth</h6>
                            <p class="mb-0">{{ Auth::user()->DateOfBirth ? Auth::user()->DateOfBirth->format('M d, Y') : 'Not set' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">License Expiry</h6>
                            <p class="mb-0">{{ Auth::user()->LicenseExpiryDate ? Auth::user()->LicenseExpiryDate->format('M d, Y') : 'Not set' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
