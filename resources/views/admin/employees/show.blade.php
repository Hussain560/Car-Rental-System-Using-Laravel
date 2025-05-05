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
                    <h1 class="page-header-title">Employee Profile</h1>
                </div>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.employees.edit', $employee) }}" class="btn btn-primary">
                    <i class="bi bi-pencil me-1"></i> Edit Employee
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Profile Card -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    @if($employee->ImagePath)
                        <img src="{{ asset($employee->ImagePath) }}" 
                             alt="Profile" class="rounded-circle mb-3"
                             style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="bg-secondary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                             style="width: 150px; height: 150px;">
                            <i class="bi bi-person-fill text-white" style="font-size: 4rem;"></i>
                        </div>
                    @endif
                    <h4>{{ $employee->FirstName }} {{ $employee->LastName }}</h4>
                    <p class="text-muted mb-2">{{ $employee->Role }}</p>
                    <div class="mb-3">
                        <span class="badge bg-{{ 
                            $employee->Status === 'Active' ? 'success' : 
                            ($employee->Status === 'Inactive' ? 'secondary' : 'warning') 
                        }}">
                            {{ $employee->Status }}
                        </span>
                    </div>
                    <div class="text-muted">
                        <div><i class="bi bi-building me-2"></i>{{ $employee->office->Name ?? 'Not Assigned' }}</div>
                        <div><i class="bi bi-geo-alt me-2"></i>{{ $employee->office->Location ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Employee Details -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-header-title">Employee Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Username</h6>
                            <div>{{ $employee->Username }}</div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">National ID</h6>
                            <div>{{ $employee->NationalID }}</div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Email</h6>
                            <div>{{ $employee->Email }}</div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Phone Number</h6>
                            <div>{{ $employee->PhoneNumber }}</div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Date of Birth</h6>
                            <div>{{ $employee->DateOfBirth ? $employee->DateOfBirth->format('M d, Y') : 'N/A' }}</div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Join Date</h6>
                            <div>{{ $employee->JoinDate ? $employee->JoinDate->format('M d, Y') : 'N/A' }}</div>
                        </div>
                        <div class="col-12">
                            <h6 class="text-muted mb-1">Address</h6>
                            <div>{{ $employee->Address }}</div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Emergency Contact</h6>
                            <div>{{ $employee->EmergencyContactName }}</div>
                            <div class="text-muted">{{ $employee->EmergencyContact }}</div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">ID Expiry Date</h6>
                            <div>{{ $employee->IDExpiryDate ? $employee->IDExpiryDate->format('M d, Y') : 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
