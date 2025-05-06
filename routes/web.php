<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\OfficeController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\PasswordChangeController;
use App\Http\Controllers\Admin\PasswordController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\EmployeeProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FleetController;
use App\Http\Controllers\Auth\CustomerController;

// Public routes - Customer facing pages
Route::controller(HomeController::class)->group(function () {
    // Default homepage
    Route::get('/', 'index')->name('home');
    // Explicit home route
    Route::get('/home', 'index')->name('home.show');
});

// Fleet routes
Route::controller(FleetController::class)->group(function () {
    Route::get('/fleet', 'index')->name('fleet');
    // Add route for filtered results
    Route::get('/fleet/search', 'search')->name('fleet.search');
});

// Currency component route for AJAX requests
Route::get('/render-currency', function () {
    $amount = request('amount', 0);
    return view('components.currency', ['amount' => $amount]);
});

// Vehicle availability check
Route::post('/check-vehicle-availability', [FleetController::class, 'checkAvailability'])
    ->name('vehicle.check-availability');

// Authentication routes
Route::middleware('guest')->group(function () {
    // Customer auth routes
    Route::get('customer-login', [LoginController::class, 'showLoginForm'])->name('customer.login');
    Route::post('customer-login', [LoginController::class, 'login'])->name('customer.login.submit');
    Route::get('customer-register', [CustomerController::class, 'showRegistrationForm'])->name('customer.register');
    Route::post('customer-register', [CustomerController::class, 'register'])->name('customer.register.submit');
    
    // Admin auth routes - restore original routes
    Route::get('admin/login', [LoginController::class, 'showAdminLoginForm'])->name('admin.login');
    Route::post('admin/login', [LoginController::class, 'adminLogin']);
});

// Add logout routes
Route::post('customer-logout', [LoginController::class, 'logout'])->name('customer.logout');
Route::post('admin/logout', [LoginController::class, 'adminLogout'])->name('admin.logout');

// User routes
Route::middleware(['auth'])->group(function () {
    // Profile routes
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Single booking routes group
    Route::prefix('bookings')->name('user.bookings.')->group(function () {
        Route::get('/', [BookingController::class, 'index'])->name('index');
        Route::get('/create/{vehicle}', [FleetController::class, 'bookNow'])->name('create');
        Route::post('/store/{vehicle}', [BookingController::class, 'store'])->name('store');
        Route::get('/{booking}', [BookingController::class, 'show'])->name('show');
        Route::post('/{booking}/cancel', [BookingController::class, 'cancel'])->name('cancel');
    });

    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

// Admin routes accessible to all employees
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('vehicles', VehicleController::class);
    Route::resource('maintenance', MaintenanceController::class);
    Route::resource('bookings', AdminBookingController::class)->only(['index', 'show']);
    Route::put('bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.update-status');
    Route::get('customers', [AdminCustomerController::class, 'index'])->name('customers.index');
    Route::get('customers/{customer}', [AdminCustomerController::class, 'show'])->name('customers.show');
    Route::get('/customers/export', [AdminCustomerController::class, 'export'])->name('customers.export');
});

// Admin routes requiring manager role
Route::prefix('admin')->middleware(['auth:admin'])->name('admin.')->group(function () {
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/employees/show-credentials', [EmployeeController::class, 'showCredentials'])
        ->name('employees.show_credentials');
    Route::resource('employees', EmployeeController::class);
    Route::resource('offices', OfficeController::class);
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/revenue', [ReportController::class, 'revenue'])->name('reports.revenue');
    Route::get('reports/utilization', [ReportController::class, 'vehicleUtilization'])->name('reports.utilization');
    Route::get('reports/maintenance', [ReportController::class, 'maintenanceCosts'])->name('reports.maintenance');
    Route::get('reports/export', [ReportController::class, 'exportReports'])->name('reports.export');
    Route::put('customers/{customer}/status', [AdminCustomerController::class, 'updateStatus'])->name('customers.update-status');
    Route::get('bookings/export', [AdminBookingController::class, 'export'])->name('bookings.export');
    Route::resource('maintenance', MaintenanceController::class);

    // Customer management routes (using AdminCustomerController)
    Route::get('customers', [AdminCustomerController::class, 'index'])->name('customers.index');
    Route::get('customers/{customer}', [AdminCustomerController::class, 'show'])->name('customers.show');
    Route::get('customers/{customer}/bookings', [AdminCustomerController::class, 'bookingHistory'])->name('customers.bookings');
    Route::put('customers/{customer}/status', [AdminCustomerController::class, 'updateStatus'])->name('customers.update-status');
    Route::get('/customers/export', [AdminCustomerController::class, 'export'])->name('customers.export');
});

Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Password change routes
    Route::get('/password/change', [PasswordController::class, 'showChangeForm'])->name('password.change');
    Route::post('/password/update', [PasswordController::class, 'update'])->name('password.update');
    
    // Add this route
    Route::get('/profile', [AdminProfileController::class, 'show'])->name('profile.show');
    
    // Other routes...
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // ...existing routes...
    Route::get('/customers/{customer}/edit', [AdminCustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/{customer}', [AdminCustomerController::class, 'update'])->name('customers.update');
    // ...existing routes...
});

require __DIR__.'/auth.php';
