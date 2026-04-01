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
        Schema::table('live_classes', function (Blueprint $table) {
            $table->string('recording_url')->nullable()->after('zoom_link');
            $table->text('recording_description')->nullable()->after('recording_url');
        });
    }

    public function down(): void
    {
        Schema::table('live_classes', function (Blueprint $table) {
            $table->dropColumn(['recording_url', 'recording_description']);
        });
    }
};
