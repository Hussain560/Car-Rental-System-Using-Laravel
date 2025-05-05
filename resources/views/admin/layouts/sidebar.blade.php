<div class="sidebar bg-dark text-white" id="adminSidebar">
    <div class="sidebar-header p-3 border-bottom">
        <div class="user-info">
            <h6 class="mb-0">Welcome,</h6>
            <p class="mb-0">{{ Auth::guard('admin')->user()->FirstName }} {{ Auth::guard('admin')->user()->LastName }}</p>
            <small class="text-muted">{{ Auth::guard('admin')->user()->Role }}</small>
        </div>
    </div>

    <div class="sidebar-menu p-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house-fill me-2"></i> Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.vehicles.index') }}" class="nav-link {{ request()->routeIs('admin.vehicles.*') ? 'active' : '' }}">
                    <i class="bi bi-car-front-fill me-2"></i> Vehicles
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.maintenance.index') }}" class="nav-link {{ request()->routeIs('admin.maintenance.*') ? 'active' : '' }}">
                    <i class="bi bi-tools me-2"></i> Vehicle Maintenance
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.bookings.index') }}" class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar2-check me-2"></i> Bookings
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.customers.index') }}" class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill me-2"></i> Customers
                </a>
            </li>

            @if(Auth::guard('admin')->user()->Role === 'Manager')
            <li class="nav-item">
                <a href="{{ route('admin.employees.index') }}" class="nav-link {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}">
                    <i class="bi bi-person-badge-fill me-2"></i> Employees
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.offices.index') }}" class="nav-link {{ request()->routeIs('admin.offices.*') ? 'active' : '' }}">
                    <i class="bi bi-building me-2"></i> Offices
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <i class="bi bi-graph-up me-2"></i> Reports
                </a>
            </li>
            @endif
        </ul>
    </div>

    <div class="sidebar-footer p-3 border-top mt-auto">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger w-100">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </button>
        </form>
    </div>
</div>