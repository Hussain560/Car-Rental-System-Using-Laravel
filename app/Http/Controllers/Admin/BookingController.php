<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['customer', 'vehicle']);

        if ($request->has('status')) {
            $query->where('Status', $request->status);
        }

        if ($request->has('date_from') && $request->has('date_to')) {
            $query->whereBetween('PickupDate', [$request->date_from, $request->date_to]);
        }

        $bookings = $query->latest('BookingDate')->paginate(10);

        // Calculate statistics
        $stats = [
            'total' => Booking::count(),
            'pending' => Booking::where('Status', 'Pending')->count(),
            'confirmed' => Booking::where('Status', 'Confirmed')->count(),
            'completed' => Booking::where('Status', 'Completed')->count(),
            'cancelled' => Booking::where('Status', 'Cancelled')->count(),
            'active' => Booking::where('Status', 'Active Rental')->count(),
            'revenue' => Booking::where('Status', '!=', 'Cancelled')->sum('TotalCost')
        ];

        return view('admin.bookings.index', compact('bookings', 'stats'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['customer', 'vehicle']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:Pending,Confirmed,Active Rental,Completed,Cancelled'
        ]);

        $booking->update([
            'Status' => $validated['status']
        ]);

        return redirect()->back()->with('success', 'Booking status updated successfully');
    }

    public function export(Request $request)
    {
        $query = Booking::with(['user', 'vehicle']);

        if ($request->has('status')) {
            $query->where('Status', $request->status);
        }

        if ($request->has('date_from') && $request->has('date_to')) {
            $query->whereBetween('PickupDate', [$request->date_from, $request->date_to]);
        }

        $bookings = $query->get();

        // Generate CSV or PDF export
        // Implementation depends on your export library choice

        return response()->download('bookings-export.csv');
    }

    protected function isReadyForRental(Booking $booking)
    {
        return $booking->Status === 'Confirmed' && 
               now()->startOfDay()->lte($booking->PickupDate->startOfDay()) && 
               now()->startOfDay()->lte($booking->ReturnDate->startOfDay());
    }

    protected function canComplete(Booking $booking)
    {
        return $booking->Status === 'Active Rental' && 
               now()->startOfDay()->equalTo($booking->ReturnDate->startOfDay());
    }
}
