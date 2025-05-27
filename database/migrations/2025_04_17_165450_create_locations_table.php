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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();

            // project_id adalah string (varchar 10)
            $table->string('project_id', 10);

            $table->string('name');
            $table->boolean('status')->default(true); // default aktif
            $table->timestamps();

            // Foreign key ke projects.id (string)
            $table->foreign('project_id')
                  ->references('id')
                  ->on('projects')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
        });

        Schema::dropIfExists('locations');
    }
};