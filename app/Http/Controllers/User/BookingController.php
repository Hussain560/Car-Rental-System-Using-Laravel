<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
            'pickup_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:pickup_date',
            'pickup_location' => 'required|string',
            'total_cost' => 'required|numeric|min:0'
        ]);

        // Create booking
        $booking = Booking::create([
            'UserID' => Auth::id(),
            'VehicleID' => $vehicle->VehicleID,
            'PickupDate' => $validated['pickup_date'],
            'ReturnDate' => $validated['return_date'],
            'PickupLocation' => $validated['pickup_location'],
            'TotalCost' => $validated['total_cost'],
            'Status' => 'Pending',
            'AdditionalServices' => $request->has('additional_services') ? json_encode($request->additional_services) : null
        ]);

        return redirect()->route('user.bookings.index')
            ->with('success', 'Booking created successfully');
    }

    public function show(Booking $booking)
    {
        if (! Gate::allows('view', $booking)) {
            abort(403);
        }
        $booking->load('vehicle');
        return view('user.bookings.show', compact('booking'));
    }

    public function cancel(Booking $booking)
    {
        // Check if user can cancel this booking
        if (Auth::id() !== $booking->UserID || !in_array($booking->Status, ['Pending', 'Confirmed'])) {
            abort(403, 'You are not authorized to cancel this booking.');
        }

        $booking->update(['Status' => 'Cancelled']);

        return redirect()->route('user.bookings.index')
            ->with('success', 'Booking cancelled successfully');
    }
}
