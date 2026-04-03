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
        $admin = User::updateOrCreate(
            ['email' => 'admin@edulms.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'is_admin' => true,
                'is_active' => true,
            ]
        );

        // ── Trainer user ────────────────────────────
        $trainer = User::updateOrCreate(
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
        $student = User::updateOrCreate(
            ['email' => 'student@edulms.com'],
            [
                'name' => 'Rahul Sharma',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'is_active' => true,
                'whatsapp_number' => '+919999999999',
                'linkedin_url' => 'https://linkedin.com/in/rahul-sharma',
            ]
        );

        $students = [$student];
        $studentNames = ['Aiswarya Nair', 'Arjun Das', 'Meera Krishnan'];
        $studentEmails = ['aiswarya@example.com', 'arjun@example.com', 'meera@example.com'];

        foreach ($studentNames as $index => $name) {
            $students[] = User::updateOrCreate(
                ['email' => $studentEmails[$index]],
                [
                    'name' => $name,
                    'password' => Hash::make('password'),
                    'is_admin' => false,
                    'is_active' => true,
                    'whatsapp_number' => '+91888888888' . $index,
                ]
            );
        }

        // ── Seed Official Curriculum ────────────────
        $course1 = Course::updateOrCreate(
            ['id' => 1],
            [
                'title' => 'Professional Diploma in MEP',
                'instructor_name' => 'Expert Trainer',
                'price' => 12000,
                'description' => 'Comprehensive training in Mechanical, Electrical, and Plumbing engineering systems.',
                'thumbnail' => '/images/courses/mep_thumbnail_v2.png',
                'learning_outcomes' => "HVAC Design Fundamentals\nElectrical Load Estimation\nPlumbing Network Schematics\nFirefighting System Layouts",
                'youtube_link' => 'https://youtu.be/jA35u7B9VFg?si=X-Homrzbbz8A-KUY',
            ]
        );

        $course2 = Course::updateOrCreate(
            ['id' => 2],
            [
                'title' => 'Master Diploma in BIM',
                'instructor_name' => 'Expert Trainer',
                'price' => 15000,
                'description' => 'Advanced Building Information Modeling masterclass for architectural professionals.',
                'thumbnail' => '/images/courses/bim_thumbnail_v2.png',
                'learning_outcomes' => "Revit Architecture & MEP\nNavisworks Clash Detection\nBIM 360 Collaboration\n4D Construction Scheduling",
                'youtube_link' => 'https://youtu.be/jA35u7B9VFg?si=X-Homrzbbz8A-KUY',
            ]
        );

        // ── Seed Institutional Batches ──────────────
        $batch1 = \App\Models\LiveClassBranch::updateOrCreate(
            ['id' => 1],
            [
                'name' => 'MEP Diploma - Q2 Elite Cohort',
                'course_id' => $course1->id,
                'status' => 'active',
                'trainer_id' => $trainer->id,
                'description' => 'A premium morning cohort focusing on large-scale industrial MEP projects.',
                'learning_outcomes' => "Master High-Rise HVAC Design\nCalculate Commercial Power Loads\nDesign Efficient Drainage Systems",
                'price' => 12000,
                'is_standalone' => false,
            ]
        );
        $batch1->trainers()->sync([$trainer->id]);

        $batch3 = \App\Models\LiveClassBranch::updateOrCreate(
            ['id' => 3],
            [
                'name' => 'BIM Masterclass - Global Phase',
                'course_id' => $course2->id,
                'status' => 'active',
                'trainer_id' => $trainer->id,
                'description' => 'Intensive BIM training with international project standards (ISO 19650).',
                'learning_outcomes' => "ISO 19650 Compliance\nAdvanced Clash Detection\nBIM Manager Workflows",
                'price' => 15000,
                'is_standalone' => false,
            ]
        );
        $batch3->trainers()->sync([$trainer->id]);

        // ── Seed STANDALONE Batch (No Course Link) ──
        $batch4 = \App\Models\LiveClassBranch::updateOrCreate(
            ['id' => 4],
            [
                'name' => 'Advanced AEC Project Management',
                'course_id' => null, // Standalone
                'status' => 'active',
                'trainer_id' => $trainer->id,
                'description' => 'A dedicated 4-week intensive program on managing multi-disciplinary AEC projects without pre-recorded filler.',
                'learning_outcomes' => "Project Lifecycle Management\nRisk Identification & Mitigation\nAEC Specific Contract Clauses\nStakeholder Communication",
                'price' => 8500,
                'is_standalone' => true,
                'thumbnail' => 'https://images.unsplash.com/photo-1541888946425-d81bb19480c5?auto=format&fit=crop&q=80&w=1200',
            ]
        );
        $batch4->trainers()->sync([$trainer->id]);

        // ── Seed Live Sessions ──────────────────────
        $now = now();
        
        // 1. Session for MEP (Linked)
        \App\Models\LiveClass::updateOrCreate(
            ['title' => 'HVAC Design Load Calculations'],
            [
                'course_id' => $course1->id,
                'live_class_branch_id' => $batch1->id,
                'instructor_name' => 'Expert Trainer',
                'start_time' => $now->copy()->addDays(2)->setTime(10, 0),
                'duration' => '90 mins',
                'zoom_link' => 'https://zoom.us/j/123456789',
                'status' => 'scheduled',
            ]
        );

        // 2. Session for STANDALONE Batch (Course ID is NULL)
        \App\Models\LiveClass::updateOrCreate(
            ['title' => 'Project Kick-off & Risk Assessment'],
            [
                'course_id' => null, // Standalone Session
                'live_class_branch_id' => $batch4->id,
                'instructor_name' => 'Expert Trainer',
                'start_time' => $now->copy()->addDays(1)->setTime(18, 0),
                'duration' => '60 mins',
                'zoom_link' => 'https://meet.google.com/aec-pm-session',
                'status' => 'scheduled',
            ]
        );

        // ── Seed Student Enrollments ────────────────
        
        // Rahul: Enrolled & Paid in MEP (Course 1)
        $admission1 = Admission::updateOrCreate(
            ['user_id' => $student->id, 'course_id' => $course1->id],
            ['batch_id' => $batch1->id, 'status' => 'approved', 'progress' => 15]
        );
        Fee::updateOrCreate(
            ['user_id' => $student->id, 'course_id' => $course1->id],
            ['original_amount' => 12000, 'total_amount' => 12000, 'paid_amount' => 12000, 'status' => 'paid']
        );

        // Aiswarya: Enrolled & PENDING in Standalone AEC (Batch 4)
        $details = json_encode(['full_name' => 'Aiswarya Nair', 'whatsapp_number' => '+919988776655']);
        $admission2 = Admission::updateOrCreate(
            ['user_id' => $students[1]->id, 'batch_id' => $batch4->id],
            ['status' => 'pending', 'details' => $details]
        );
        Fee::updateOrCreate(
            ['user_id' => $students[1]->id, 'batch_id' => $batch4->id],
            ['original_amount' => 8500, 'total_amount' => 8500, 'paid_amount' => 0, 'status' => 'pending']
        );

        // Arjun: Enrolled & APPROVED in Standalone AEC (Batch 4)
        $admission3 = Admission::updateOrCreate(
            ['user_id' => $students[2]->id, 'batch_id' => $batch4->id],
            ['status' => 'approved', 'details' => $details]
        );
        Fee::updateOrCreate(
            ['user_id' => $students[2]->id, 'batch_id' => $batch4->id],
            ['original_amount' => 8500, 'total_amount' => 8500, 'paid_amount' => 8500, 'status' => 'paid']
        );

        $this->command->info('✅ Seeder synchronized with Live Campus Architecture.');
    }
}
