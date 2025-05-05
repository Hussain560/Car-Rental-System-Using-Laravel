<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::withCount('bookings')
            ->with(['bookings' => function($query) {
                $query->latest('BookingDate');
            }]);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('FirstName', 'like', "%{$search}%")
                  ->orWhere('LastName', 'like', "%{$search}%")
                  ->orWhere('Email', 'like', "%{$search}%")
                  ->orWhere('PhoneNumber', 'like', "%{$search}%")
                  ->orWhere('NationalID', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('AccountStatus', $request->status);
        }

        // License status filter
        if ($request->filled('license_status')) {
            $today = now();
            switch ($request->license_status) {
                case 'expired':
                    $query->whereDate('LicenseExpiryDate', '<', $today);
                    break;
                case 'expiring_soon':
                    $query->whereDate('LicenseExpiryDate', '>=', $today)
                          ->whereDate('LicenseExpiryDate', '<=', $today->addDays(30));
                    break;
                case 'valid':
                    $query->whereDate('LicenseExpiryDate', '>', $today->addDays(30));
                    break;
            }
        }

        // Sorting
        switch ($request->get('sort', 'recent')) {
            case 'name':
                $query->orderBy('FirstName')->orderBy('LastName');
                break;
            case 'bookings':
                $query->orderByDesc('bookings_count');
                break;
            default:
                $query->latest('created_at'); // Changed from CreatedAt to created_at
        }

        $customers = $query->paginate(10)->withQueryString();
        
        $stats = [
            'total' => Customer::count(),
            'active' => Customer::where('AccountStatus', 'Active')->count(),
            'suspended' => Customer::where('AccountStatus', 'Suspended')->count(),
            'expired_license' => Customer::whereDate('LicenseExpiryDate', '<', now())->count()
        ];

        return view('admin.customers.index', compact('customers', 'stats'));
    }

    public function show(Customer $customer)
    {
        $customer->load(['bookings' => function ($query) {
            $query->latest('BookingDate')->limit(5);
        }]);
        return view('admin.customers.show', compact('customer'));
    }

    public function updateStatus(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'status' => 'required|in:Active,Suspended,Inactive'
        ]);

        $customer->update([
            'AccountStatus' => $validated['status']
        ]);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer status updated successfully');
    }

    public function bookingHistory(Customer $customer)
    {
        $bookings = $customer->bookings()
            ->with('vehicle')
            ->latest('BookingDate')
            ->paginate(10);
            
        return view('admin.customers.bookings', compact('customer', 'bookings'));
    }
}
