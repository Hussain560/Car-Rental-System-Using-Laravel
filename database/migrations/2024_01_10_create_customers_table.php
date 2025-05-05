<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id('CustomerID');
            $table->string('Username')->unique();
            $table->string('Password');
            $table->string('FirstName');
            $table->string('LastName');
            $table->string('PhoneNumber');
            $table->string('Email')->unique();
            $table->string('NationalID');
            $table->text('Address');
            $table->date('DateOfBirth');
            $table->enum('Gender', ['Male', 'Female']);
            $table->string('EmergencyPhone');
            $table->date('LicenseExpiryDate');
            $table->timestamp('LastLogin')->nullable();
            $table->enum('AccountStatus', ['active', 'suspended', 'blocked'])->default('active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
