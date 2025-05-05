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
        Schema::create('offices', function (Blueprint $table) {
            $table->id('OfficeID');
            $table->string('Name', 100);
            $table->string('Email', 100)->unique();
            $table->string('PhoneNumber', 20);
            $table->string('Location', 100);
            $table->string('Address', 255);
            $table->string('City', 100);
            $table->string('PostalCode', 10);
            $table->enum('Status', ['Active', 'Inactive', 'Maintenance'])->default('Active');
            $table->time('OpeningTime');
            $table->time('ClosingTime');
            $table->text('Description')->nullable();
            $table->text('Notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offices');
    }
};
