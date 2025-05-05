@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title">Employee Management</h1>
                <span class="text-muted">Manage your employees</span>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.employees.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Add New Employee
                </a>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.employees.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="Suspended" {{ request('status') == 'Suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label">Office Location</label>
                    <select name="office_id" class="form-select">
                        <option value="">All Offices</option>
                        @foreach($offices as $office)
                            <option value="{{ $office->OfficeID }}" 
                                {{ request('office_id') == $office->OfficeID ? 'selected' : '' }}>
                                {{ $office->Location }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" 
                           placeholder="Search by name, email or phone..."
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <div class="d-grid gap-2 w-100">
                        <button type="submit" class="btn btn-primary">Search</button>
                        @if(request()->hasAny(['status', 'office_id', 'search']))
                            <a href="{{ route('admin.employees.index') }}" class="btn btn-outline-secondary">
                                Clear Filters
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Employees Table -->
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Contact</th>
                        <th>Office</th>
                        <th>Status</th>
                        <th>Last Login</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $employee)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($employee->ImagePath)
                                    <img src="{{ asset($employee->ImagePath) }}" 
                                         alt="{{ $employee->FirstName }}" 
                                         class="rounded-circle me-3"
                                         style="width: 40px; height: 40px; object-fit: cover;">
                                @else
                                    <div class="bg-secondary rounded-circle me-3 d-flex align-items-center justify-content-center"
                                         style="width: 40px; height: 40px;">
                                        <i class="bi bi-person text-white"></i>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mb-0">{{ $employee->FirstName }} {{ $employee->LastName }}</h6>
                                    <small class="text-muted">{{ $employee->Username }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>
                                <i class="bi bi-envelope text-secondary me-1"></i> {{ $employee->Email }}
                            </div>
                            <div>
                                <i class="bi bi-telephone text-secondary me-1"></i> {{ $employee->PhoneNumber }}
                            </div>
                        </td>
                        <td>
                            {{ $employee->office ? $employee->office->Location : 'Not Assigned' }}
                        </td>
                        <td>
                            <span class="badge bg-{{ 
                                $employee->Status === 'Active' ? 'success' : 
                                ($employee->Status === 'Inactive' ? 'secondary' : 'warning') 
                            }}">
                                {{ $employee->Status }}
                            </span>
                        </td>
                        <td>
                            {{ optional($employee->LastLogin)->format('M d, Y H:i') ?? 'Never' }}
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.employees.show', $employee) }}" 
                                   class="btn btn-sm btn-info" title="View Details">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.employees.edit', $employee) }}" 
                                   class="btn btn-sm btn-primary" title="Edit Employee">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <div class="mb-3">
                                <i class="bi bi-people display-4 text-muted"></i>
                            </div>
                            <h4>No Employees Found</h4>
                            <p class="text-muted">Add new employees or adjust your search filters.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($employees->hasPages())
            <div class="card-footer">
                {{ $employees->links() }}
            </div>
        @endif
    </div>
</div>
@endsection