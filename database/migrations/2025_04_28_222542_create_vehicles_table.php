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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id('VehicleID');
            $table->string('Make', 50);
            $table->string('Model', 50);
            $table->integer('Year');
            $table->string('LicensePlate', 7);
            $table->string('SerialNumber', 50)->nullable();
            $table->date('DateOfExpiry')->nullable();
            $table->string('Color', 30)->nullable();
            $table->enum('Category', ['Sedan', 'SUV', 'Crossover', 'Small Cars']);
            $table->enum('Status', ['Available', 'Rented', 'Maintenance'])->default('Available');
            $table->string('ImagePath', 255)->nullable();
            $table->decimal('DailyRate', 10, 2)->nullable();
            $table->foreignId('OfficeID')->nullable()->constrained('offices', 'OfficeID');
            $table->integer('PassengerCapacity')->default(4);
            $table->integer('LuggageCapacity')->default(2)->comment('Number of luggage pieces');
            $table->integer('Doors')->default(4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
