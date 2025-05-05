<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->date('DateOfBirth')->nullable()->after('LastName');
            $table->string('EmergencyContact', 20)->nullable()->after('PhoneNumber');
            $table->string('EmergencyContactName', 100)->nullable()->after('EmergencyContact');
            $table->string('Address', 255)->nullable()->after('EmergencyContactName');
            $table->date('JoinDate')->nullable()->after('Status');
            $table->string('Nationality', 50)->nullable()->after('JoinDate');
            $table->string('NationalID', 20)->nullable()->after('Nationality');
            $table->date('IDExpiryDate')->nullable()->after('NationalID');
        });
    }

    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn([
                'DateOfBirth',
                'EmergencyContact',
                'EmergencyContactName',
                'Address',
                'JoinDate',
                'Nationality',
                'NationalID',
                'IDExpiryDate'
            ]);
        });
    }
};
