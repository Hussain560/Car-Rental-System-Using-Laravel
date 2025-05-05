<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('maintenance', function (Blueprint $table) {
            $table->id('MaintenanceID');
            $table->foreignId('VehicleID')->constrained('vehicles', 'VehicleID');
            $table->date('StartDate');
            $table->date('EndDate')->nullable();
            $table->string('MaintenanceType', 50);
            $table->text('Description');
            $table->decimal('Cost', 10, 2);
            $table->enum('Status', ['In Progress', 'Completed'])->default('In Progress');
            $table->timestamp('CreatedAt')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance');
    }
};
