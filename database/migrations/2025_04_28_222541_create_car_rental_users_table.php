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
        Schema::create('car_rental_users', function (Blueprint $table) {
            $table->id('UserID');
            $table->string('Username', 50);
            $table->string('Password', 255);
            $table->string('FirstName', 50);
            $table->string('LastName', 50);
            $table->string('PhoneNumber', 20);
            $table->string('Email', 100);
            $table->string('NationalID', 10);
            $table->text('Address');
            $table->timestamp('CreatedAt')->useCurrent();
            $table->timestamp('UpdatedAt')->useCurrent()->useCurrentOnUpdate();
            $table->date('DateOfBirth')->nullable();
            $table->enum('Gender', ['Male', 'Female'])->default('Male');
            $table->string('EmergencyPhone', 20)->nullable();
            $table->date('LicenseExpiryDate')->nullable();
            $table->dateTime('LastLogin')->nullable();
            $table->enum('AccountStatus', ['Active', 'Suspended', 'Inactive'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_rental_users');
    }
};
