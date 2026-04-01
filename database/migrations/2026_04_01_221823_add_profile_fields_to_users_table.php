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
        Schema::table('users', function (Blueprint $user) {
            $user->string('whatsapp_number')->nullable()->after('email');
            $user->string('linkedin_url')->nullable()->after('whatsapp_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $user) {
            $user->dropColumn(['whatsapp_number', 'linkedin_url']);
        });
    }
};
