<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: Add the new project_id column
        Schema::table('reimbursts', function (Blueprint $table) {  // Changed from 'reimbursements' to 'reimbursts'
            if (!Schema::hasColumn('reimbursts', 'project_id')) {
                $table->unsignedBigInteger('project_id')->after('nama_pengaju')->nullable();
                $table->foreign('project_id')->references('id')->on('projects');
            }
        });

        // Step 3: Drop the old nama_project column
        Schema::table('reimbursts', function (Blueprint $table) {
            if (Schema::hasColumn('reimbursts', 'nama_project')) {
                $table->dropColumn('nama_project');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Step 1: Add back the nama_project column
        Schema::table('reimbursts', function (Blueprint $table) {
            if (!Schema::hasColumn('reimbursts', 'nama_project')) {
                $table->string('nama_project', 255)->after('nama_pengaju')->nullable();
            }
        });

        // Step 2: Transfer data back from project_id to nama_project
        $reimbursements = DB::table('reimbursts')->whereNotNull('project_id')->get();

        foreach ($reimbursements as $reimbursement) {
            // Get the project name
            $project = DB::table('projects')->where('id', $reimbursement->project_id)->first();

            if ($project) {
                // Update the nama_project field
                DB::table('reimbursts')
                    ->where('id', $reimbursement->id)
                    ->update(['nama_project' => $project->name]);
            }
        }

        // Step 3: Drop the project_id column and its foreign key
        Schema::table('reimbursts', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropColumn('project_id');
        });
    }
};
