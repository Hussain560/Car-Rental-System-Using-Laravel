<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Auth::user()->bookings()
            ->with('vehicle')
            ->latest('BookingDate')
            ->paginate(10);
            
        return view('user.bookings.index', compact('bookings'));
    }

    public function create(Vehicle $vehicle)
    {
        return view('user.bookings.create', compact('vehicle'));
    }

    public function store(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'pickup_date' => 'required|date|after:today',
            'return_date' => 'required|date|after:pickup_date',
            'pickup_location' => 'required|string|max:100'
        ]);

        // Check vehicle availability for the selected dates
        $conflictingBookings = Booking::where('VehicleID', $vehicle->VehicleID)
            ->where('Status', '!=', 'Cancelled')
            ->where(function($query) use ($validated) {
                $query->whereBetween('PickupDate', [$validated['pickup_date'], $validated['return_date']])
                    ->orWhereBetween('ReturnDate', [$validated['pickup_date'], $validated['return_date']]);
            })->exists();

        if ($conflictingBookings) {
            return back()->withErrors(['dates' => 'Vehicle is not available for the selected dates']);
        }

        // Calculate total cost
        $days = Carbon::parse($validated['pickup_date'])->diffInDays(Carbon::parse($validated['return_date']));
        $totalCost = $days * $vehicle->DailyRate;

        $booking = Booking::create([
            'UserID' => Auth::id(),
            'VehicleID' => $vehicle->VehicleID,
            'PickupDate' => $validated['pickup_date'],
            'ReturnDate' => $validated['return_date'],
            'PickupLocation' => $validated['pickup_location'],
            'TotalCost' => $totalCost,
            'Status' => 'Pending'
        ]);

        return redirect()->route('user.bookings.show', $booking)
            ->with('success', 'Booking created successfully');
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        $booking->load('vehicle');
        return view('user.bookings.show', compact('booking'));
    }

    public function cancel(Booking $booking)
    {
        $this->authorize('cancel', $booking);

        if (!in_array($booking->Status, ['Pending', 'Confirmed'])) {
            return back()->withErrors(['status' => 'This booking cannot be cancelled']);
        }

        $booking->update(['Status' => 'Cancelled']);

        if ($booking->vehicle->Status === 'Rented') {
            $booking->vehicle->update(['Status' => 'Available']);
        }

        return redirect()->route('user.bookings.index')
            ->with('success', 'Booking cancelled successfully');
    }
}
