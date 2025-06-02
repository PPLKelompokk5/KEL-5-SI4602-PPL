<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Pastikan kolom project_id ada sebelum di-drop
        if (Schema::hasTable('reimbursts') && Schema::hasColumn('reimbursts', 'project_id')) {
            Schema::table('reimbursts', function (Blueprint $table) {
                // $table->dropColumn('project_id');
            });
        }

        // Tambahkan kolom project_id bertipe string
        Schema::table('reimbursts', function (Blueprint $table) {
            // $table->string('project_id', 255)->after('nama_pengaju')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop kolom string project_id jika ada
        if (Schema::hasTable('reimbursts') && Schema::hasColumn('reimbursts', 'project_id')) {
            Schema::table('reimbursts', function (Blueprint $table) {
                $table->dropColumn('project_id');
            });
        }

        // Tambahkan kembali kolom project_id sebagai unsignedBigInteger
        Schema::table('reimbursts', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->after('nama_pengaju')->nullable();
            // Tidak perlu foreign key karena memang tidak ada
        });
    }
};
