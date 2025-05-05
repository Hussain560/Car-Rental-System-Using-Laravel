@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title">Maintenance Records</h1>
                <span class="text-muted">Manage vehicle maintenance records</span>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.maintenance.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> New Maintenance Record
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Vehicle</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Dates</th>
                        <th>Cost</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($maintenances as $maintenance)
                        <tr>
                            <td>
                                {{ $maintenance->vehicle->Make }} {{ $maintenance->vehicle->Model }}
                                <div class="small text-muted">{{ $maintenance->vehicle->LicensePlate }}</div>
                            </td>
                            <td>{{ $maintenance->MaintenanceType }}</td>
                            <td>{{ Str::limit($maintenance->Description, 50) }}</td>
                            <td>
                                <div>Start: {{ $maintenance->StartDate->format('Y-m-d') }}</div>
                                <div>End: {{ $maintenance->EndDate->format('Y-m-d') }}</div>
                            </td>
                            <td>
                                <x-currency :amount="$maintenance->Cost" />
                            </td>
                            <td>
                                @php
                                    $statusClass = [
                                        'Scheduled' => 'bg-info',
                                        'In Progress' => 'bg-warning',
                                        'Completed' => 'bg-success'
                                    ][$maintenance->Status] ?? 'bg-secondary';
                                @endphp
                                <span class="badge {{ $statusClass }}">{{ $maintenance->Status }}</span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.maintenance.edit', $maintenance) }}" 
                                       class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="mb-3">
                                    <i class="bi bi-wrench display-4 text-muted"></i>
                                </div>
                                <h4>No Maintenance Records Found</h4>
                                <p class="text-muted">Start by adding a new maintenance record.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($maintenances->hasPages())
        <div class="mt-4">
            {{ $maintenances->links() }}
        </div>
    @endif
</div>
@endsection