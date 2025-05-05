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
                    <h1 class="page-header-title">Office Details</h1>
                </div>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.offices.edit', $office) }}" class="btn btn-primary">
                    <i class="bi bi-pencil me-1"></i> Edit Office
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Office Image & Stats -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    @if($office->ImagePath)
                        <img src="{{ asset($office->ImagePath) }}" 
                             alt="{{ $office->Name }}" 
                             class="img-fluid rounded mb-3"
                             style="max-height: 200px; width: 100%; object-fit: cover;">
                    @endif
                    <h4 class="mb-1">{{ $office->Name }}</h4>
                    <p class="text-muted mb-3">{{ $office->Location }}</p>
                    <span class="badge bg-{{ $office->Status === 'Active' ? 'success' : ($office->Status === 'Inactive' ? 'secondary' : 'warning') }}">
                        {{ $office->Status }}
                    </span>

                    <hr class="my-4">

                    <div class="row g-3">
                        <div class="col-6">
                            <div class="fs-5 mb-1">{{ $office->vehicles_count }}</div>
                            <div class="text-muted small">Vehicles</div>
                        </div>
                        <div class="col-6">
                            <div class="fs-5 mb-1">{{ $office->admins_count }}</div>
                            <div class="text-muted small">Employees</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Office Details -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-header-title">Office Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Contact Information</h6>
                            <dl class="row">
                                <dt class="col-5">Email:</dt>
                                <dd class="col-7">{{ $office->Email }}</dd>

                                <dt class="col-5">Phone:</dt>
                                <dd class="col-7">{{ $office->PhoneNumber }}</dd>
                            </dl>
                        </div>

                        <div class="col-md-6">
                            <h6 class="text-muted mb-1">Operating Hours</h6>
                            <dl class="row">
                                <dt class="col-5">Opens:</dt>
                                <dd class="col-7">{{ \Carbon\Carbon::parse($office->OpeningTime)->format('h:i A') }}</dd>

                                <dt class="col-5">Closes:</dt>
                                <dd class="col-7">{{ \Carbon\Carbon::parse($office->ClosingTime)->format('h:i A') }}</dd>
                            </dl>
                        </div>

                        <div class="col-12">
                            <h6 class="text-muted mb-1">Location Details</h6>
                            <dl class="row">
                                <dt class="col-3">Address:</dt>
                                <dd class="col-9">{{ $office->Address }}</dd>

                                <dt class="col-3">City:</dt>
                                <dd class="col-9">{{ $office->City }}</dd>

                                <dt class="col-3">Postal Code:</dt>
                                <dd class="col-9">{{ $office->PostalCode }}</dd>
                            </dl>
                        </div>

                        @if($office->Description)
                        <div class="col-12">
                            <h6 class="text-muted mb-1">Description</h6>
                            <p class="mb-0">{{ $office->Description }}</p>
                        </div>
                        @endif

                        @if($office->Notes)
                        <div class="col-12">
                            <h6 class="text-muted mb-1">Additional Notes</h6>
                            <p class="mb-0">{{ $office->Notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
