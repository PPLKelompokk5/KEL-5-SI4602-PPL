<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('presences', function (Blueprint $table) {
            $table->id();

            // Tetap gunakan foreignId untuk BIGINT
            $table->foreignId('employees_id')->constrained('employees')->onDelete('cascade');

            // Ubah jadi string agar cocok dengan projects.id
            $table->string('project_id', 10);

            $table->foreignId('location_id')->nullable()->constrained('locations')->onDelete('set null');

            $table->date('date');
            $table->time('timestamp');

            $table->timestamps();

            // Definisikan foreign key secara manual untuk project_id
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presences');
    }
};