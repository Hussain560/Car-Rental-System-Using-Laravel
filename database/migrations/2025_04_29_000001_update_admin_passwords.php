<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class UpdateAdminPasswords extends Migration
{
    public function up()
    {
        // Get all admins
        $admins = Admin::all();
        
        foreach ($admins as $admin) {
            // Check if password is not already using Bcrypt
            if (strlen($admin->Password) !== 60 || !str_starts_with($admin->Password, '$2y$')) {
                // Update with a default password that they must change on first login
                $admin->Password = Hash::make('ChangeMe123!');
                $admin->save();
            }
        }
    }

    public function down()
    {
        // Cannot reliably revert password hashing
    }
}