@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title">Dashboard</h1>
                <span class="text-muted">Welcome to Admin Panel</span>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 rounded-circle bg-primary bg-opacity-10 p-3">
                    <i class="bi bi-car-front fs-4 text-primary"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <h6 class="mb-1">Active Rentals</h6>
                    <h3 class="mb-0">{{ $stats['active_rentals'] }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection