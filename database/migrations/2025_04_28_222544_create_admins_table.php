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
        Schema::create('admins', function (Blueprint $table) {
            $table->id('AdminID');
            $table->string('Username', 50);
            $table->string('Password', 255);
            $table->string('FirstName', 50);
            $table->string('LastName', 50);
            $table->string('PhoneNumber', 15);
            $table->string('Email', 100);
            $table->enum('Role', ['Manager', 'Employee'])->default('Employee');
            $table->dateTime('LastLogin')->nullable();
            $table->timestamp('CreatedAt')->useCurrent();
            $table->timestamp('UpdatedAt')->useCurrent()->useCurrentOnUpdate();
            $table->enum('Status', ['Active', 'Inactive', 'Suspended'])->default('Active');
            $table->string('ImagePath', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
