<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseQuestion;
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
        // ── Seed Course Assessments ──────────────────
        $mepQuestions = [
            [
                'question' => 'What does HVAC stand for in MEP engineering?',
                'option_a' => 'High Voltage Alternating Current',
                'option_b' => 'Heating, Ventilation, and Air Conditioning',
                'option_c' => 'Heat Velocity And Cooling',
                'option_d' => 'Heavy Volume Air Control',
                'correct_option' => 'B',
                'points' => 10,
            ],
            [
                'question' => 'Which system is primarily responsible for domestic water supply?',
                'option_a' => 'Mechanical',
                'option_b' => 'Electrical',
                'option_c' => 'Plumbing',
                'option_d' => 'Firefighting',
                'correct_option' => 'C',
                'points' => 10,
            ],
        ];

        foreach ($mepQuestions as $q) {
            CourseQuestion::firstOrCreate(
                ['course_id' => $course1->id, 'question' => $q['question']],
                $q
            );
        }

        $bimQuestions = [
            [
                'question' => 'What does LOD stand for in Building Information Modeling?',
                'option_a' => 'Level of Design',
                'option_b' => 'Line of Development',
                'option_c' => 'Level of Development',
                'option_d' => 'Limit of Drafting',
                'correct_option' => 'C',
                'points' => 10,
            ],
            [
                'question' => 'Which software is the industry standard for 3D clash detection?',
                'option_a' => 'Revit Architecture',
                'option_b' => 'Navisworks Manage',
                'option_c' => 'AutoCAD 3D',
                'option_d' => 'SketchUp Pro',
                'correct_option' => 'B',
                'points' => 10,
            ],
        ];

        foreach ($bimQuestions as $q) {
            CourseQuestion::firstOrCreate(
                ['course_id' => $course2->id, 'question' => $q['question']],
                $q
            );
        }


        $this->command->info('✅ Login Data & Courses Seeded: Admin, Trainer, Student accounts, and Official Curriculum are ready. Password: "password".');
    }
}
