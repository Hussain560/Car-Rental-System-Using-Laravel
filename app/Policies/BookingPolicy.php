<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\CarRentalUser;
use App\Models\Admin;

class BookingPolicy
{
    public function viewAny(CarRentalUser|Admin $user): bool
    {
        return true;
    }

    public function view(CarRentalUser|Admin $user, Booking $booking): bool
    {
        if ($user instanceof Admin) {
            return true;
        }
        return $user->UserID === $booking->UserID;
    }

    public function create(CarRentalUser $user): bool
    {
        return $user->AccountStatus === 'Active';
    }

    public function update(Admin $user, Booking $booking): bool
    {
        return true;
    }

    public function cancel(CarRentalUser|Admin $user, Booking $booking): bool
    {
        if ($user instanceof Admin) {
            return true;
        }
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
