<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Update existing statuses
        DB::statement("ALTER TABLE bookings MODIFY COLUMN Status ENUM('Pending', 'Confirmed', 'In Progress', 'Completed', 'Cancelled')");
    }

    public function down()
    {
        DB::statement("ALTER TABLE bookings MODIFY COLUMN Status ENUM('Pending', 'Confirmed', 'Completed', 'Cancelled')");
    }
};
