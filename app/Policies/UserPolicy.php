<?php

namespace App\Policies;

use App\Models\CarRentalUser;
use App\Models\Admin;

class UserPolicy
{
    public function viewAny(Admin $user): bool
    {
        return in_array($user->Role, ['Manager', 'Employee']);
    }

    public function view(Admin|CarRentalUser $user, CarRentalUser $targetUser): bool
    {
        if ($user instanceof Admin) {
            return in_array($user->Role, ['Manager', 'Employee']);
        }
        return $user->UserID === $targetUser->UserID;
    }

    public function create(Admin $user): bool
    {
        return in_array($user->Role, ['Manager', 'Employee']);
    }

    public function update(Admin|CarRentalUser $user, CarRentalUser $targetUser): bool
    {
        if ($user instanceof Admin) {
            return in_array($user->Role, ['Manager', 'Employee']);
        }
        return $user->UserID === $targetUser->UserID && $user->AccountStatus === 'Active';
    }

    public function delete(Admin|CarRentalUser $user, CarRentalUser $targetUser): bool
    {
        if ($user instanceof Admin) {
            return $user->Role === 'Manager';
        }
        return $user->UserID === $targetUser->UserID && 
               !$targetUser->bookings()->whereIn('Status', ['Pending', 'Confirmed'])->exists();
    }

    public function updateStatus(Admin $user, CarRentalUser $targetUser): bool
    {
        return $user->Role === 'Manager';
    }

    public function viewBookingHistory(Admin|CarRentalUser $user, CarRentalUser $targetUser): bool
    {
        if ($user instanceof Admin) {
            return in_array($user->Role, ['Manager', 'Employee']);
        }
        return $user->UserID === $targetUser->UserID;
    }
}
