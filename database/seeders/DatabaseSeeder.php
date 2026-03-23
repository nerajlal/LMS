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

        // ── Courses ─────────────────────────────────
        $courseModels = [];
        $courses = [
            [
                'title' => 'Full Stack Web Development',
                'description' => 'Learn HTML, CSS, JavaScript, React, Node.js, and deploy real projects from scratch.',
                'thumbnail' => '',
                'price' => 14999,
                'instructor_name' => 'Prof. Rao',
            ],
            [
                'title' => 'Data Science & Machine Learning',
                'description' => 'Master Python, Pandas, NumPy, Scikit-learn, and TensorFlow for real-world ML problems.',
                'thumbnail' => '',
                'price' => 19999,
                'instructor_name' => 'Prof. Sharma',
            ],
            [
                'title' => 'UI/UX Design Masterclass',
                'description' => 'Design beautiful, user-friendly interfaces using Figma, Sketch, and design principles.',
                'thumbnail' => '',
                'price' => 9999,
                'instructor_name' => 'Prof. Nair',
            ],
        ];

        foreach ($courses as $courseData) {
            $course = Course::firstOrCreate(
                ['title' => $courseData['title']],
                $courseData
            );
            $courseModels[] = $course;

            // Batch for each course
            $batch = Batch::firstOrCreate(
                ['course_id' => $course->id, 'name' => 'Batch 2026 — Jan'],
                [
                    'course_id' => $course->id,
                    'name' => 'Batch 2026 — Jan',
                    'start_date' => '2026-01-15',
                    'end_date' => '2026-06-15',
                    'status' => 'active',
                ]
            );

            // Lessons for each course
            for ($i = 1; $i <= 5; $i++) {
                Lesson::firstOrCreate(
                    ['course_id' => $course->id, 'order' => $i],
                    [
                        'course_id' => $course->id,
                        'title' => "Lesson $i: Core Foundations",
                        'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                        'order' => $i,
                    ]
                );
            }

            // Admission for student
            if ($course->title === 'Full Stack Web Development') {
                Admission::firstOrCreate(
                    ['user_id' => $student->id, 'course_id' => $course->id],
                    [
                        'user_id' => $student->id,
                        'course_id' => $course->id,
                        'batch_id' => $batch->id,
                        'status' => 'approved',
                        'details' => json_encode(['phone' => '9876543210', 'address' => 'Kerala, India']),
                    ]
                );
            }
        }

        // Seed Live Classes & Materials
        foreach ($courseModels as $course) {
            \App\Models\LiveClass::create([
                'course_id' => $course->id,
                'title' => 'Advanced Session: ' . $course->title,
                'instructor_name' => 'Dr. Arpit Rao',
                'start_time' => now()->addDays(2)->format('Y-m-d 16:00:00'),
                'duration' => '90 mins',
                'zoom_link' => 'https://zoom.us/j/123456789',
                'status' => 'upcoming',
            ]);

            \App\Models\StudyMaterial::create([
                'course_id' => $course->id,
                'title' => 'Mastering ' . $course->title . '.pdf',
                'file_path' => '/storage/materials/sample.pdf',
                'file_type' => 'PDF',
                'file_size' => '2.4 MB',
            ]);
        }

        $this->command->info('✅ EduLMS demo data seeded successfully!');
        $this->command->info('   Admin:   admin@edulms.com / password');
        $this->command->info('   Trainer: trainer@edulms.com / password');
        $this->command->info('   Student: student@edulms.com / password');
    }
}
