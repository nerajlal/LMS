<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LoginDataOnlySeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin user ──────────────────────────────
        User::updateOrCreate(
            ['email' => 'admin@edulms.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'is_admin' => true,
                'is_trainer' => false,
                'is_active' => true,
            ]
        );

        // ── Trainer user ────────────────────────────
        User::updateOrCreate(
            ['email' => 'trainer@edulms.com'],
            [
                'name' => 'Expert Trainer',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'is_trainer' => true,
                'is_active' => true,
                'whatsapp_number' => '+919876543210',
                'linkedin_url' => 'https://linkedin.com/search/results/all/?keywords=expert-trainer',
            ]
        );

        // ── Student user ────────────────────────────
        User::updateOrCreate(
            ['email' => 'student@edulms.com'],
            [
                'name' => 'Rahul Sharma',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'is_trainer' => false,
                'is_active' => true,
                'whatsapp_number' => '+919999999999',
                'linkedin_url' => 'https://linkedin.com/in/rahul-sharma',
            ]
        );

        $this->command->info('✅ Login Data Seeded: Admin, Trainer, and Student accounts are ready. Password for all is "password".');
    }
}
