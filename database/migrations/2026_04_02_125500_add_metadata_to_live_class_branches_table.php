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
        Schema::table('live_class_branches', function (Blueprint $table) {
            $table->text('description')->nullable();
            $table->text('learning_outcomes')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->string('thumbnail')->nullable();
            $table->boolean('is_standalone')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('live_class_branches', function (Blueprint $table) {
            $table->dropColumn(['description', 'learning_outcomes', 'price', 'thumbnail', 'is_standalone']);
        });
    }
};
