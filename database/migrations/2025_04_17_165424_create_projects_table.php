<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->string('id', 10)->primary();

            $table->string('name');
            $table->date('start');
            $table->date('end');

            $table->unsignedBigInteger('pd')->nullable();
            $table->unsignedBigInteger('pm')->nullable();
            $table->enum('type', ['Pendampingan', 'Semi-Pendampingan', 'Mentoring', 'Perpetuation']);

            $table->bigInteger('nilai_kontrak');
            $table->integer('roi_percent');
            $table->bigInteger('roi_idr')->nullable();

            $table->boolean('status')->default(true);

            $table->unsignedBigInteger('client_id')->nullable(); // ✅ harus nullable untuk nullOnDelete

            $table->timestamps();

            // Foreign keys
            $table->foreign('pd')->references('id')->on('employees')->nullOnDelete();
            $table->foreign('pm')->references('id')->on('employees')->nullOnDelete();
            $table->foreign('client_id')->references('id')->on('clients')->nullOnDelete(); // ✅ now valid
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};