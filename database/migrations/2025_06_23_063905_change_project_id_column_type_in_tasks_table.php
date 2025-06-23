<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Langsung ubah tipe data tanpa drop foreign key
            // karena foreign key tidak ada
            $table->string('project_id')->change();
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->bigInteger('project_id')->unsigned()->change();
        });
    }
};
