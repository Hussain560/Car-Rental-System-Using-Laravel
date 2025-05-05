<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('maintenance', function (Blueprint $table) {
            \DB::statement("ALTER TABLE maintenance MODIFY Status ENUM('Scheduled', 'In Progress', 'Completed') NOT NULL DEFAULT 'Scheduled'");
        });
    }

    public function down(): void
    {
        Schema::table('maintenance', function (Blueprint $table) {
            \DB::statement("ALTER TABLE maintenance MODIFY Status VARCHAR(255)");
        });
    }
};
