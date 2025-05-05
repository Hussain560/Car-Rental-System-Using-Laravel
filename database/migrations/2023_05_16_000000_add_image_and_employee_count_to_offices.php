<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('offices', function (Blueprint $table) {
            $table->string('ImagePath')->nullable()->after('Notes');
            $table->integer('EmployeeCount')->default(0)->after('ImagePath');
        });
    }

    public function down(): void
    {
        Schema::table('offices', function (Blueprint $table) {
            $table->dropColumn(['ImagePath', 'EmployeeCount']);
        });
    }
};
