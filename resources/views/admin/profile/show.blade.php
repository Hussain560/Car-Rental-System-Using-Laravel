@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Profile Card -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    @if($admin->ImagePath)
                        <img src="{{ asset($admin->ImagePath) }}" 
                             alt="Profile Picture" 
                             class="rounded-circle mb-3"
                             style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="bg-secondary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                             style="width: 150px; height: 150px;">
                            <i class="bi bi-person-fill text-white" style="font-size: 4rem;"></i>
                        </div>
                    @endif
                    
                    <h4>{{ $admin->FirstName }} {{ $admin->LastName }}</h4>
                    <p class="text-muted mb-2">{{ $admin->Role }}</p>
                    <span class="badge bg-{{ $admin->Status === 'Active' ? 'success' : 'secondary' }}">
                        {{ $admin->Status }}
                    </span>

                    <div class="mt-3">
                        <a href="{{ route('admin.password.change') }}" class="btn btn-outline-primary">
                            <i class="bi bi-key me-1"></i> Reset Password
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details Card -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Employee Information</h5>
                    <hr>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="text-muted">Username</label>
                            <p class="mb-0">{{ $admin->Username }}</p>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted">Email</label>
                            <p class="mb-0">{{ $admin->Email }}</p>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted">Phone Number</label>
                            <p class="mb-0">{{ $admin->PhoneNumber }}</p>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted">Join Date</label>
                            <p class="mb-0">{{ $admin->JoinDate ? $admin->JoinDate->format('M d, Y') : 'N/A' }}</p>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted">Office</label>
                            <p class="mb-0">{{ $admin->office ? $admin->office->Name : 'Not Assigned' }}</p>
                        </div>

                        <div class="col-12">
                            <label class="text-muted">Address</label>
                            <p class="mb-0">{{ $admin->Address }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
