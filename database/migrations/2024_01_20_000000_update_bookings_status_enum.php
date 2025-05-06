<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateBookingsStatusEnum extends Migration
{
    public function up()
    {
        // First, modify any existing 'In Progress' records to 'Active Rental'
        DB::table('bookings')
            ->where('Status', 'In Progress')
            ->update(['Status' => 'Active Rental']);

        // Then update the enum
        DB::statement("ALTER TABLE bookings MODIFY COLUMN Status ENUM('Pending', 'Confirmed', 'Active Rental', 'Completed', 'Cancelled') NOT NULL DEFAULT 'Pending'");
    }

    public function down()
    {
        // Convert back 'Active Rental' to 'In Progress' first
        DB::table('bookings')
            ->where('Status', 'Active Rental')
            ->update(['Status' => 'In Progress']);

        // Then revert the enum
        DB::statement("ALTER TABLE bookings MODIFY COLUMN Status ENUM('Pending', 'Confirmed', 'In Progress', 'Completed', 'Cancelled') NOT NULL DEFAULT 'Pending'");
    }
}
