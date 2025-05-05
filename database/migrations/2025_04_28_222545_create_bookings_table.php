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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id('BookingID');
            $table->foreignId('UserID')->constrained('car_rental_users', 'UserID');
            $table->foreignId('VehicleID')->constrained('vehicles', 'VehicleID');
            $table->date('PickupDate');
            $table->date('ReturnDate');
            $table->string('PickupLocation', 100);
            $table->decimal('TotalCost', 10, 2);
            $table->enum('Status', ['Pending', 'Confirmed', 'Completed', 'Cancelled'])->default('Pending');
            $table->dateTime('BookingDate')->useCurrent();
            $table->timestamp('UpdatedAt')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
