@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title">Office Locations</h1>
                <span class="text-muted">Manage all rental office locations</span>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.offices.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Add New Office
                </a>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.offices.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="Maintenance" {{ request('status') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="search" class="form-label">Search</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Search by name, email, location, or city...">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    @if(request()->hasAny(['search', 'status']))
                        <a href="{{ route('admin.offices.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-x-circle me-1"></i> Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Offices Table -->
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead class="thead-light">
                    <tr>
                        <th>Office Info</th>
                        <th>Contact Details</th>
                        <th>Location</th>
                        <th>Operating Hours</th>
                        <th>Status</th>
                        <th>Resources</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($offices as $office)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($office->ImagePath)
                                    <img src="{{ asset($office->ImagePath) }}" alt="{{ $office->Name }}" 
                                         class="rounded me-3" style="width: 64px; height: 64px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                         style="width: 64px; height: 64px;">
                                        <i class="bi bi-building text-primary fs-4"></i>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mb-0">{{ $office->Name }}</h6>
                                    <small class="text-muted">#{{ $office->OfficeID }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <div class="mb-1">
                                    <i class="bi bi-envelope-fill me-1 text-secondary" data-bs-toggle="tooltip" title="Email"></i>
                                    <span>{{ $office->Email }}</span>
                                </div>
                                <div class="mb-1">
                                    <i class="bi bi-telephone-fill me-1 text-secondary" data-bs-toggle="tooltip" title="Phone"></i>
                                    <span>{{ $office->PhoneNumber }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <div class="mb-1">
                                    <i class="bi bi-geo-alt-fill me-1 text-secondary" data-bs-toggle="tooltip" title="Location"></i>
                                    <span>{{ $office->Location }}</span>
                                </div>
                                <div class="mb-1">
                                    <i class="bi bi-pin-map-fill me-1 text-secondary" data-bs-toggle="tooltip" title="Address"></i>
                                    <span>{{ $office->Address }}</span>
                                </div>
                                <div class="mb-1">
                                    <i class="bi bi-buildings-fill me-1 text-secondary" data-bs-toggle="tooltip" title="City"></i>
                                    <span>{{ $office->City }}</span>
                                    <i class="bi bi-postcard-fill ms-2 me-1 text-secondary" data-bs-toggle="tooltip" title="Postal Code"></i>
                                    <small>{{ $office->PostalCode }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-clock-fill me-2 text-secondary" data-bs-toggle="tooltip" title="Opening Hours"></i>
                                <span>{{ \Carbon\Carbon::parse($office->OpeningTime)->format('H:i') }} - {{ \Carbon\Carbon::parse($office->ClosingTime)->format('H:i') }}</span>
                            </div>
                        </td>
                        <td>
                            @if($office->Status == 'Active')
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle me-1"></i> Active
                                </span>
                            @elseif($office->Status == 'Maintenance')
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-tools me-1"></i> Maintenance
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    <i class="bi bi-x-circle me-1"></i> Inactive
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <div class="mb-1">
                                    <i class="bi bi-car-front-fill me-1 text-secondary" data-bs-toggle="tooltip" title="Vehicles"></i>
                                    <span>{{ $office->vehicles_count }} {{ Str::plural('Vehicle', $office->vehicles_count) }}</span>
                                </div>
                                <div>
                                    <i class="bi bi-people-fill me-1 text-secondary" data-bs-toggle="tooltip" title="Employees"></i>
                                    <span>{{ $office->admins_count }} {{ Str::plural('Employee', $office->admins_count) }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="text-end">
                            <div class="btn-group">
                                <a href="{{ route('admin.offices.show', $office) }}" 
                                   class="btn btn-sm btn-info" title="View Details">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.offices.edit', $office) }}" 
                                   class="btn btn-sm btn-primary" title="Edit Office">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal{{ $office->OfficeID }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal{{ $office->OfficeID }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Delete Office</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete the office "{{ $office->Name }}" in {{ $office->City }}?</p>
                                            @if($office->vehicles_count > 0)
                                                <div class="alert alert-warning">
                                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                                    This office has {{ $office->vehicles_count }} vehicles assigned. 
                                                    These vehicles will need to be reassigned or removed.
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <form action="{{ route('admin.offices.destroy', $office) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <div class="mb-3">
                                <i class="bi bi-building display-4 text-muted"></i>
                            </div>
                            <h4>No Offices Found</h4>
                            <p class="text-muted">
                                @if(request()->hasAny(['search', 'status', 'city']))
                                    Try adjusting your filters or add a new office.
                                @else
                                    Start by adding a new office location.
                                @endif
                            </p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($offices->hasPages())
        <div class="mt-4">
            {{ $offices->links() }}
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