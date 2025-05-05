@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title">Vehicle Management</h1>
                <span class="text-muted">Manage your vehicle fleet</span>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.vehicles.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Add New Vehicle
                </a>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.vehicles.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="category" class="form-label">Category</label>
                    <select name="category" id="category" class="form-select">
                        <option value="">All Categories</option>
                        <option value="Sedan" {{ request('category') == 'Sedan' ? 'selected' : '' }}>Sedan</option>
                        <option value="SUV" {{ request('category') == 'SUV' ? 'selected' : '' }}>SUV</option>
                        <option value="Crossover" {{ request('category') == 'Crossover' ? 'selected' : '' }}>Crossover</option>
                        <option value="Small Cars" {{ request('category') == 'Small Cars' ? 'selected' : '' }}>Small Cars</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="Available" {{ request('status') == 'Available' ? 'selected' : '' }}>Available</option>
                        <option value="Rented" {{ request('status') == 'Rented' ? 'selected' : '' }}>Rented</option>
                        <option value="Maintenance" {{ request('status') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="office" class="form-label">Office Location</label>
                    <select name="office_id" id="office" class="form-select">
                        <option value="">All Locations</option>
                        @foreach($offices as $office)
                            <option value="{{ $office->OfficeID }}" {{ request('office_id') == $office->OfficeID ? 'selected' : '' }}>{{ $office->Location }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">Apply Filters</button>
                    @if(request()->hasAny(['category', 'status', 'office_id']))
                        <a href="{{ route('admin.vehicles.index') }}" class="btn btn-outline-secondary">Clear Filters</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Vehicles Table -->
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>Vehicle</th>
                        <th>Details</th>
                        <th>Office Location</th>
                        <th>Status</th>
                        <th>Daily Rate</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vehicles as $vehicle)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($vehicle->ImagePath)
                                    <img src="{{ asset($vehicle->ImagePath) }}" alt="{{ $vehicle->Make }} {{ $vehicle->Model }}" 
                                         class="rounded me-3" style="width: 64px; height: 64px; object-fit: cover;">
                                @else
                                    <div class="bg-secondary rounded me-3 d-flex align-items-center justify-content-center" 
                                         style="width: 64px; height: 64px;">
                                        <i class="bi bi-car-front text-white fs-4"></i>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mb-0">{{ $vehicle->Make }} {{ $vehicle->Model }}</h6>
                                    <small class="text-muted">{{ $vehicle->Year }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <div class="mb-1">
                                    <i class="bi bi-tag-fill me-1 text-secondary" data-bs-toggle="tooltip" title="Category"></i>
                                    <span>{{ $vehicle->Category }}</span>
                                </div>
                                <div class="mb-1">
                                    <i class="bi bi-credit-card-2-front me-1 text-secondary" data-bs-toggle="tooltip" title="License Plate"></i>
                                    <span>{{ $vehicle->LicensePlate }}</span>
                                </div>
                                <div class="mb-1">
                                    <i class="bi bi-upc-scan me-1 text-secondary" data-bs-toggle="tooltip" title="Car Serial Number"></i>
                                    <span>{{ $vehicle->SerialNumber ?: 'N/A' }}</span>
                                </div>
                                <div class="mb-1">
                                    <i class="bi bi-palette-fill me-1 text-secondary" data-bs-toggle="tooltip" title="Color"></i>
                                    <span>{{ $vehicle->Color ?: 'N/A' }}</span>
                                </div>
                                <div class="mb-1">
                                    <i class="bi bi-calendar-event me-1 text-secondary" data-bs-toggle="tooltip" title="License Expiry Date"></i>
                                    <span>{{ $vehicle->DateOfExpiry ? $vehicle->DateOfExpiry->format('M d, Y') : 'N/A' }}</span>
                                </div>
                                <div>
                                    <i class="bi bi-person-fill me-1 text-secondary" data-bs-toggle="tooltip" title="Passenger Capacity"></i>
                                    <span>{{ $vehicle->PassengerCapacity }}</span>
                                    <i class="bi bi-briefcase-fill ms-2 me-1 text-secondary" data-bs-toggle="tooltip" title="Luggage Capacity"></i>
                                    <span>{{ $vehicle->LuggageCapacity }}</span>
                                    <i class="bi bi-door-closed-fill ms-2 me-1 text-secondary" data-bs-toggle="tooltip" title="Doors"></i>
                                    <span>{{ $vehicle->Doors }}</span>
                                </div>
                            </div>
                        </td>
                        <td>{{ $vehicle->office ? $vehicle->office->Location : 'Not Assigned' }}</td>
                        <td>
                            <span class="badge bg-{{ $vehicle->Status === 'Available' ? 'success' : ($vehicle->Status === 'Rented' ? 'info' : 'warning') }}">
                                {{ $vehicle->Status }}
                            </span>
                        </td>
                        <td><x-currency :amount="$vehicle->DailyRate" /></td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.vehicles.show', $vehicle) }}" 
                                   class="btn btn-sm btn-info" title="View Details">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.vehicles.edit', $vehicle) }}" 
                                   class="btn btn-sm btn-primary" title="Edit Vehicle">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal{{ $vehicle->VehicleID }}"
                                        title="Delete Vehicle">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>

                            <!-- Delete Confirmation Modal -->
                            <div class="modal fade" id="deleteModal{{ $vehicle->VehicleID }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Delete Vehicle</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete this vehicle?</p>
                                            <div class="alert alert-warning">
                                                <i class="bi bi-exclamation-triangle me-2"></i>
                                                This action cannot be undone.
                                            </div>
                                            <div class="d-flex align-items-center mb-3">
                                                @if($vehicle->ImagePath)
                                                    <img src="{{ asset($vehicle->ImagePath) }}" 
                                                         alt="Vehicle" class="rounded me-3"
                                                         style="width: 50px; height: 50px; object-fit: cover;">
                                                @endif
                                                <div>
                                                    <h6 class="mb-0">{{ $vehicle->Make }} {{ $vehicle->Model }}</h6>
                                                    <small class="text-muted">{{ $vehicle->LicensePlate }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <form action="{{ route('admin.vehicles.destroy', $vehicle) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete Vehicle</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($vehicles->isEmpty())
            <div class="text-center py-4">
                <div class="mb-3">
                    <i class="bi bi-car-front display-4 text-muted"></i>
                </div>
                <h4>No Vehicles Found</h4>
                <p class="text-muted">Try adjusting your filters or add a new vehicle.</p>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($vehicles->hasPages())
        <div class="mt-4">
            {{ $vehicles->links() }}
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush