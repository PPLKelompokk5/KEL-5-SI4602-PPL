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
        Schema::create('reimbursts', function (Blueprint $table) {
            $table->id();
            $table->string('id_karyawan')->unique();
            $table->string('nama_reimburse');
            $table->string('nama_pengaju');
            $table->string('nama_project');
            $table->decimal('nominal');
            $table->enum('status_approval', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reimbursts');
    }
};
