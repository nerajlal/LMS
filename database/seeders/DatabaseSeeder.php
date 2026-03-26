<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\Batch;
use App\Models\Lesson;
use App\Models\Admission;
use App\Models\Fee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin user ──────────────────────────────
        $admin = User::firstOrCreate(
        ['email' => 'admin@edulms.com'],
        [
            'name' => 'Admin User',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]
        );

        // ── Trainer user ────────────────────────────
        $trainer = User::firstOrCreate(
        ['email' => 'trainer@edulms.com'],
        [
            'name' => 'Expert Trainer',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'is_trainer' => true,
        ]
        );

        // ── Student user ────────────────────────────
        $student = User::firstOrCreate(
        ['email' => 'student@edulms.com'],
        [
            'name' => 'Rahul Sharma',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]
        );

        // ── Seed Courses & Enrollments for testing ────────────────
        // $course1 = Course::create([
        //     'title' => 'Advanced Laravel Mastery',
        //     'instructor_name' => 'Expert Trainer',
        //     'price' => 4999,
        //     'description' => 'Master advanced Laravel concepts including Design Patterns and Architecture.',
        // ]);

        // $course2 = Course::create([
        //     'title' => 'Premium UI Design',
        //     'instructor_name' => 'Expert Trainer',
        //     'price' => 2999,
        //     'description' => 'Learn the secrets of high-fidelity web design using Tailwind and Alpine.',
        // ]);

        /*
         // Enroll student in these courses with different progress
         Admission::create([
         'user_id' => $student->id,
         'course_id' => $course1->id,
         'status' => 'approved',
         'progress' => 65,
         ]);
         Admission::create([
         'user_id' => $student->id,
         'course_id' => $course2->id,
         'status' => 'approved',
         'progress' => 20,
         ]);
         */

        $this->command->info('✅ EduLMS reset to clean state successfully!');
        $this->command->info('   Admin:   admin@edulms.com / password');
        $this->command->info('   Trainer: trainer@edulms.com / password');
        $this->command->info('   Student: student@edulms.com / password');
    }
}
