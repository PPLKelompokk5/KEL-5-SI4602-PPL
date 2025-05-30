<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kpis', function (Blueprint $table) {
            $table->id();
            $table->string('project_id', 10);
            $table->string('indikator');
            $table->string('uom');
            $table->float('target');
            $table->float('base')->nullable();
            $table->integer('bulan')->nullable();
            $table->float('level_1')->nullable();
            $table->float('level_2')->nullable();
            $table->float('level_3')->nullable();
            $table->float('level_4')->nullable();
            $table->float('level_5')->nullable();
            $table->float('level_6')->nullable();
            $table->float('level_7')->nullable();
            $table->float('level_8')->nullable();
            $table->float('level_9')->nullable();
            $table->float('level_10')->nullable();
            $table->timestamps();

            // Optional: foreign key constraint
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kpis');
    }
};