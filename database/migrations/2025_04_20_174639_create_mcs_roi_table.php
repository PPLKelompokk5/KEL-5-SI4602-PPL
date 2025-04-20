<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mcs_roi', function (Blueprint $table) {
            $table->id();
            $table->string('project_id', 10); // harus sama tipe & panjangnya
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
    
            $table->string('indicator');
            $table->bigInteger('harga');
            $table->double('target');
            $table->string('uom');
            $table->bigInteger('target_idr')->nullable();
    
            $table->timestamps();
        });
    }    

    public function down(): void
    {
        Schema::dropIfExists('mcs_roi');
    }
};