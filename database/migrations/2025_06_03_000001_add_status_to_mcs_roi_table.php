<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mcs_roi', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('target_idr');
        });
    }

    public function down(): void
    {
        Schema::table('mcs_roi', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
