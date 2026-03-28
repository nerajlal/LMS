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
        $branches = \DB::table('live_class_branches')->whereNotNull('trainer_id')->get();
        
        foreach ($branches as $branch) {
            \DB::table('live_class_branch_trainer')->insertOrIgnore([
                'live_class_branch_id' => $branch->id,
                'trainer_id' => $branch->trainer_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No simple way to reverse without potentially deleting explicitly assigned collaborators
    }
};
