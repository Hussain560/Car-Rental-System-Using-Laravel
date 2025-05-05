<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->unsignedBigInteger('OfficeID')->nullable()->after('adminid');
            $table->foreign('OfficeID')->references('OfficeID')->on('offices')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropForeign(['OfficeID']);
            $table->dropColumn('OfficeID');
        });
    }
};
