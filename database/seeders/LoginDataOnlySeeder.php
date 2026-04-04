<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LoginDataOnlySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Clear everything for a clean start
        User::where('email', '!=', 'admin@edulms.com')->delete();

        // 2. Ensure Main Admin Exists
        User::updateOrCreate(
            ['email' => 'admin@edulms.com'],
            [
                'name' => 'Main Administrator',
                'password' => Hash::make('password'),
                'is_admin' => true,
                'is_active' => true,
            ]
        );

        $this->command->info('✅ Login Data Reset: Only Main Admin (admin@edulms.com / password) remains.');
    }
}
