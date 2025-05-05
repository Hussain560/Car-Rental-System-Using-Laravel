<?php

namespace App\Policies;

use App\Models\Vehicle;
use App\Models\Admin;
use App\Models\CarRentalUser;

class VehiclePolicy
{
    public function viewAny(CarRentalUser|Admin|null $user): bool
    {
        return true; // Anyone can view vehicles
    }

    public function view(CarRentalUser|Admin|null $user, Vehicle $vehicle): bool
    {
        return true; // Anyone can view vehicle details
    }

    public function create(Admin $user): bool
    {
        return in_array($user->Role, ['Manager', 'Employee']);
    }

    public function update(Admin $user, Vehicle $vehicle): bool
    {
        return in_array($user->Role, ['Manager', 'Employee']);
    }

    public function delete(Admin $user, Vehicle $vehicle): bool
    {
        return $user->Role === 'Manager';
    }

    public function manageStatus(Admin $user, Vehicle $vehicle): bool
    {
        return in_array($user->Role, ['Manager', 'Employee']);
    }
}
