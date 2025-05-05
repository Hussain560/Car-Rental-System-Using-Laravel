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
        Schema::table('offices', function (Blueprint $table) {
            // Add new columns
            $table->string('Name', 100)->after('OfficeID')->nullable();
            $table->string('Email', 100)->after('Name')->nullable()->unique();
            $table->string('Address', 255)->after('PhoneNumber')->nullable();
            $table->string('City', 100)->after('Address')->nullable();
            $table->string('PostalCode', 10)->after('City')->nullable();
            $table->enum('Status', ['Active', 'Inactive', 'Maintenance'])->after('PostalCode')->default('Active');
            $table->time('OpeningTime')->after('Status')->nullable()->default('08:00:00');
            $table->time('ClosingTime')->after('OpeningTime')->nullable()->default('20:00:00');
            $table->text('Description')->after('ClosingTime')->nullable();
            $table->text('Notes')->after('Description')->nullable();
            
            // Make existing PhoneNumber column nullable if it's not already
            $table->string('PhoneNumber', 20)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offices', function (Blueprint $table) {
            // Drop new columns
            $table->dropColumn([
                'Name', 
                'Email', 
                'Address',
                'City',
                'PostalCode',
                'Status',
                'OpeningTime',
                'ClosingTime',
                'Description',
                'Notes'
            ]);
        });
    }
};
