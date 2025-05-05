<?php

namespace App\Policies;

use App\Models\Office;
use App\Models\Admin;
use App\Models\CarRentalUser;

class OfficePolicy
{
    public function viewAny(CarRentalUser|Admin|null $user): bool
    {
        return true; // Anyone can view office locations
    }

    public function view(CarRentalUser|Admin|null $user, Office $office): bool
    {
        return true; // Anyone can view office details
    }

    public function create(Admin $user): bool
    {
        return $user->Role === 'Manager';
    }

    public function update(Admin $user, Office $office): bool
    {
        return $user->Role === 'Manager';
    }

    public function delete(Admin $user, Office $office): bool
    {
        return $user->Role === 'Manager';
    }

    public function assignVehicles(Admin $user, Office $office): bool
    {
        return in_array($user->Role, ['Manager', 'Employee']);
    }
}
