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
            ]
        );

        $studentNames = [
            'Aiswarya Nair', 'Arjun Das', 'Meera Krishnan', 'Siddharth Menon', 'Sneha Pillai'
        ];
        
        $studentEmails = [
            'aiswarya@example.com', 'arjun@example.com', 'meera@example.com', 'sid@example.com', 'sneha@example.com'
        ];

        $students = [$student];
        foreach ($studentNames as $index => $name) {
            $students[] = User::updateOrCreate(
                ['email' => $studentEmails[$index]],
                [
                    'name' => $name,
                    'password' => Hash::make('password'),
                    'is_admin' => false,
                    'is_active' => true,
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
                'learning_outcomes' => 'HVAC Design, Electrical Systems, Plumbing Networks, Firefighting Systems.',
                'youtube_link' => 'https://youtu.be/jA35u7B9VFg?si=X-Homrzbbz8A-KUY',
            ]
        );

        $course2 = Course::updateOrCreate(
            ['id' => 2],
            [
                'title' => 'Master Diploma in BIM',
                'instructor_name' => 'Expert Trainer',
                'price' => 12000,
                'description' => 'Advanced Building Information Modeling masterclass for architectural professionals.',
                'thumbnail' => '/images/courses/bim_thumbnail_v2.png',
                'learning_outcomes' => 'Revit Architecture, Navisworks, BIM Coordination, 4D/5D Simulation.',
                'youtube_link' => 'https://youtu.be/jA35u7B9VFg?si=X-Homrzbbz8A-KUY',
            ]
        );

        // ── Seed Course Lessons ─────────────────────
        $mepLessons = [
            ['title' => 'HVAC Design Fundamentals', 'video_url' => 'https://youtu.be/jA35u7B9VFg'],
            ['title' => 'Electrical System Schematics', 'video_url' => 'https://youtu.be/jA35u7B9VFg'],
            ['title' => 'Plumbing Network Design', 'video_url' => 'https://youtu.be/jA35u7B9VFg'],
            ['title' => 'Firefighting Systems Overview', 'video_url' => 'https://youtu.be/jA35u7B9VFg'],
            ['title' => 'BOP Selection & Pipe Sizing', 'video_url' => 'https://youtu.be/jA35u7B9VFg'],
        ];

        foreach ($mepLessons as $l) {
            \App\Models\Lesson::updateOrCreate(
                ['title' => $l['title'], 'course_id' => $course1->id],
                $l
            );
        }

        $bimLessons = [
            ['title' => 'BIM 360 Collaboration', 'video_url' => 'https://youtu.be/jA35u7B9VFg'],
            ['title' => 'Revit Families Engineering', 'video_url' => 'https://youtu.be/jA35u7B9VFg'],
            ['title' => 'Clash Detection Workflow', 'video_url' => 'https://youtu.be/jA35u7B9VFg'],
            ['title' => '4D Construction Scheduling', 'video_url' => 'https://youtu.be/jA35u7B9VFg'],
            ['title' => 'Quantity Takeoff from BIM', 'video_url' => 'https://youtu.be/jA35u7B9VFg'],
        ];

        foreach ($bimLessons as $l) {
            \App\Models\Lesson::updateOrCreate(
                ['title' => $l['title'], 'course_id' => $course2->id],
                $l
            );
        }

        // ── Seed Institutional Batches ──────────────
        $batch1 = \App\Models\LiveClassBranch::updateOrCreate(
            ['id' => 1],
            [
                'name' => 'MEP Diploma - Morning',
                'course_id' => $course1->id,
                'status' => 'active',
                'trainer_id' => $trainer->id,
            ]
        );
        $batch1->trainers()->sync([$trainer->id]);

        $batch2 = \App\Models\LiveClassBranch::updateOrCreate(
            ['id' => 2],
            [
                'name' => 'MEP Diploma - Evening',
                'course_id' => $course1->id,
                'status' => 'active',
                'trainer_id' => $trainer->id,
            ]
        );
        $batch2->trainers()->sync([$trainer->id]);

        $batch3 = \App\Models\LiveClassBranch::updateOrCreate(
            ['id' => 3],
            [
                'name' => 'BIM Diploma - Phase 1',
                'course_id' => $course2->id,
                'status' => 'active',
                'trainer_id' => $trainer->id,
            ]
        );
        $batch3->trainers()->sync([$trainer->id]);

        // ── Seed Student Enrollment ─────────────────
        $admission = Admission::updateOrCreate(
            ['user_id' => $student->id, 'course_id' => $course1->id],
            [
                'batch_id' => $batch1->id,
                'status' => 'approved',
                'progress' => 0,
            ]
        );

        $fee = Fee::updateOrCreate(
            ['user_id' => $student->id, 'course_id' => $course1->id],
            [
                'original_amount' => 12000,
                'total_amount' => 12000,
                'paid_amount' => 12000,
                'status' => 'paid',
            ]
        );

        \App\Models\Payment::updateOrCreate(
            ['fee_id' => $fee->id],
            [
                'user_id' => $student->id,
                'amount' => 12000,
                'payment_id' => 'PAY' . time(),
                'status' => 'success',
                'type' => 'online',
            ]
        );

        // ── Seed Live Class History (Recordings) ────
        $now = now();
        
        // MEP Session 1 (Recorded)
        \App\Models\LiveClass::updateOrCreate(
            ['title' => 'Introduction to HVAC Systems'],
            [
                'course_id' => $course1->id,
                'live_class_branch_id' => $batch1->id,
                'instructor_name' => 'Expert Trainer',
                'start_time' => $now->copy()->subDays(2)->setTime(10, 0),
                'duration' => '90 mins',
                'zoom_link' => 'https://zoom.us/j/123456789',
                'recording_url' => 'https://youtu.be/jA35u7B9VFg?si=X-Homrzbbz8A-KUY',
                'recording_description' => 'Detailed walkthrough of HVAC fundamentals and load calculations.',
                'status' => 'completed',
            ]
        );

        // MEP Session 2 (Recorded)
        \App\Models\LiveClass::updateOrCreate(
            ['title' => 'Electrical Load Estimation'],
            [
                'course_id' => $course1->id,
                'live_class_branch_id' => $batch1->id,
                'instructor_name' => 'Expert Trainer',
                'start_time' => $now->copy()->subDays(1)->setTime(10, 0),
                'duration' => '60 mins',
                'zoom_link' => 'https://zoom.us/j/123456789',
                'recording_url' => 'https://youtu.be/jA35u7B9VFg?si=X-Homrzbbz8A-KUY',
                'recording_description' => 'Calculating connected loads and diversity factors for commercial buildings.',
                'status' => 'completed',
            ]
        );

        // BIM Session 1 (Recorded)
        \App\Models\LiveClass::updateOrCreate(
            ['title' => 'Revit Architecture Basics'],
            [
                'course_id' => $course2->id,
                'live_class_branch_id' => $batch3->id,
                'instructor_name' => 'Expert Trainer',
                'start_time' => $now->copy()->subDays(3)->setTime(14, 0),
                'duration' => '120 mins',
                'zoom_link' => 'https://zoom.us/j/987654321',
                'recording_url' => 'https://youtu.be/jA35u7B9VFg?si=X-Homrzbbz8A-KUY',
                'recording_description' => 'Setting up levels, grids, and basic wall hierarchies in Revit.',
                'status' => 'completed',
            ]
        );

        $this->command->info('✅ Session recordings provisioned.');

        // ── Seed Course Exam Questions ────────────
        // MEP Questions (Course 1)
        $mepQuestions = [
            [
                'question' => 'What is the standard unit for measuring cooling capacity in HVAC systems?',
                'option_a' => 'Watts',
                'option_b' => 'Tons of Refrigeration (TR)',
                'option_c' => 'Joules',
                'option_d' => 'Amperes',
                'correct_option' => 'b',
            ],
            [
                'question' => 'Which component is responsible for increasing the pressure of refrigerant in a cycle?',
                'option_a' => 'Evaporator',
                'option_b' => 'Condenser',
                'option_c' => 'Compressor',
                'option_d' => 'Expansion Valve',
                'correct_option' => 'c',
            ],
            [
                'question' => 'In electrical systems, what does "DB" stand for?',
                'option_a' => 'Digital Board',
                'option_b' => 'Distribution Board',
                'option_c' => 'Direct Battery',
                'option_d' => 'Data Bus',
                'correct_option' => 'b',
            ],
            [
                'question' => 'What is the primary purpose of a "P-Trap" in plumbing?',
                'option_a' => 'To increase water pressure',
                'option_b' => 'To filter out solid waste',
                'option_c' => 'To prevent sewer gases from entering buildings',
                'option_d' => 'To store emergency water',
                'correct_option' => 'c',
            ],
            [
                'question' => 'Which refrigerant is commonly used in VRF systems?',
                'option_a' => 'R-22',
                'option_b' => 'R-410A',
                'option_c' => 'Nitrogen',
                'option_d' => 'Propane',
                'correct_option' => 'b',
            ],
            [
                'question' => 'What is the standard frequency of AC power in India?',
                'option_a' => '60 Hz',
                'option_b' => '50 Hz',
                'option_c' => '100 Hz',
                'option_d' => '120 Hz',
                'correct_option' => 'b',
            ],
        ];

        foreach ($mepQuestions as $q) {
            \App\Models\CourseQuestion::updateOrCreate(
                ['question' => $q['question'], 'course_id' => $course1->id],
                $q
            );
        }

        // BIM Questions (Course 2)
        $bimQuestions = [
            [
                'question' => 'Which software is most commonly used for BIM Coordination and Clash Detection?',
                'option_a' => 'AutoCAD',
                'option_b' => 'Adobe Photoshop',
                'option_c' => 'Navisworks',
                'option_d' => 'SketchUp',
                'correct_option' => 'c',
            ],
            [
                'question' => 'What is "Level of Development" (LOD) in a BIM context?',
                'option_a' => 'The height of the building',
                'option_b' => 'The speed of the computer hardware',
                'option_c' => 'The maturity and detail of the model elements',
                'option_d' => 'The amount of floors processed',
                'correct_option' => 'c',
            ],
            [
                'question' => 'In Revit, which file extension is used for Families?',
                'option_a' => '.rvt',
                'option_b' => '.rfa',
                'option_c' => '.rte',
                'option_d' => '.rft',
                'correct_option' => 'b',
            ],
        ];

        foreach ($bimQuestions as $q) {
            \App\Models\CourseQuestion::updateOrCreate(
                ['question' => $q['question'], 'course_id' => $course2->id],
                $q
            );
        }

        // ── Seed Course Testimonials (Feedback) ───
        $feedbackData = [
            [
                'user_id' => $student->id,
                'course_id' => $course1->id,
                'rating' => 5,
                'comment' => 'The MEP course is exceptionally detailed. The load calculations section was a game changer for my career.',
            ],
            [
                'user_id' => $student->id,
                'course_id' => $course2->id,
                'rating' => 4,
                'comment' => 'Great BIM curriculum. Navisworks coordination workflow was explained very clearly.',
            ],
        ];

        foreach ($feedbackData as $fb) {
            \App\Models\CourseFeedback::updateOrCreate(
                ['user_id' => $fb['user_id'], 'course_id' => $fb['course_id']],
                $fb
            );
        }

        // ── Seed Live Class Attendance ────────────
        // Record student attendance for both sessions
        $pastClasses = \App\Models\LiveClass::where('status', 'completed')->get();
        foreach ($pastClasses as $class) {
            foreach ($students as $s) {
                \App\Models\LiveClassAttendance::updateOrCreate(
                    ['user_id' => $s->id, 'live_class_id' => $class->id],
                    ['joined_at' => $class->start_time->copy()->addMinutes(rand(1, 15))]
                );
            }
        }

        $this->command->info('✅ Multi-student Feedback and Attendance logs provisioned.');
        $this->command->info('✅ EduLMS Fresh Synchronization Complete!');
    }
}
