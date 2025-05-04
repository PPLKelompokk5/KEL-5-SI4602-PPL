<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// RUN COMMAND INI SEBELUM MIGRATE
// composer require doctrine/dbal

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reimbursts', function (Blueprint $table) {
            $table->unsignedBigInteger('nominal')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reimbursts', function (Blueprint $table) {
            $table->decimal('nominal', 15, 2)->change();
        });
    }
};
