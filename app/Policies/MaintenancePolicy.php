<?php

namespace App\Policies;

use App\Models\Maintenance;
use App\Models\Admin;

class MaintenancePolicy
{
    public function viewAny(Admin $user): bool
    {
        return true;
    }

    public function view(Admin $user, Maintenance $maintenance): bool
    {
        return true;
    }

    public function create(Admin $user): bool
    {
        return in_array($user->Role, ['Manager', 'Employee']);
    }

    public function update(Admin $user, Maintenance $maintenance): bool
    {
        return in_array($user->Role, ['Manager', 'Employee']);
    }

    public function delete(Admin $user, Maintenance $maintenance): bool
    {
        return $user->Role === 'Manager';
    }

    public function completeService(Admin $user, Maintenance $maintenance): bool
    {
        return in_array($user->Role, ['Manager', 'Employee']) && 
               $maintenance->Status === 'In Progress';
    }
}
