<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Customer;
use App\Models\Booking;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookingPolicy
{
    use HandlesAuthorization;

    public function viewAny(Customer|Admin $user): bool
    {
        return true;
    }

    public function view(Customer|Admin $user, Booking $booking): bool
    {
        if ($user instanceof Admin) {
            return true;
        }
        return $user->UserID === $booking->UserID; // Changed from id to UserID
    }

    public function create(Customer $user): bool
    {
        return $user->AccountStatus === 'Active';
    }

    public function update(Admin $user, Booking $booking): bool
    {
        return true;
    }

    public function cancel(Customer|Admin $user, Booking $booking): bool
    {
        if ($user instanceof Admin) {
            return true;
        }

        // Allow customer to cancel their own pending or confirmed bookings
        return $user->UserID === $booking->UserID && 
               in_array($booking->Status, ['Pending', 'Confirmed']);
    }

    public function delete(Admin $user, Booking $booking): bool
    {
        return $user->Role === 'Manager';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Booking $booking): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Booking $booking): bool
    {
        return false;
    }
}
