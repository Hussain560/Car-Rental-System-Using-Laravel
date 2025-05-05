<?php

namespace App\Policies;

use App\Models\Admin;

class AdminPolicy
{
    public function viewAny(Admin $user): bool
    {
        return $user->Role === 'Manager';
    }

    public function view(Admin $user, Admin $targetAdmin): bool
    {
        return $user->Role === 'Manager' || $user->AdminID === $targetAdmin->AdminID;
    }

    public function create(Admin $user): bool
    {
        return $user->Role === 'Manager';
    }

    public function update(Admin $user, Admin $targetAdmin): bool
    {
        // Managers can update any admin, employees can only update themselves
        return $user->Role === 'Manager' || $user->AdminID === $targetAdmin->AdminID;
    }

    public function delete(Admin $user, Admin $targetAdmin): bool
    {
        // Only managers can delete, and they can't delete themselves
        return $user->Role === 'Manager' && $user->AdminID !== $targetAdmin->AdminID;
    }

    public function updateRole(Admin $user, Admin $targetAdmin): bool
    {
        // Only managers can change roles, and they can't change their own role
        return $user->Role === 'Manager' && $user->AdminID !== $targetAdmin->AdminID;
    }

    public function viewReports(Admin $user): bool
    {
        return in_array($user->Role, ['Manager', 'Employee']);
    }
}
