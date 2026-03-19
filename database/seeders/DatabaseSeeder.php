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
        ['email' => 'admin@gmail.com'],
        [
            'name' => 'Admin User',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]
        );

        // ── Student user ────────────────────────────
        $student = User::firstOrCreate(
        ['email' => 'student@gmail.com'],
        [
            'name' => 'Rahul Sharma',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]
        );

        // ── Courses ─────────────────────────────────
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
            [
                'title' => 'Mobile App Development with Flutter',
                'description' => 'Build cross-platform iOS and Android apps using Google\'s Flutter framework and Dart.',
                'thumbnail' => '',
                'price' => 12999,
                'instructor_name' => 'Prof. Kumar',
            ],
        ];

        foreach ($courses as $courseData) {
            $course = Course::firstOrCreate(
            ['title' => $courseData['title']],
                $courseData
            );

            // Batch for each course
            $batch = Batch::firstOrCreate(
            ['course_id' => $course->id, 'name' => 'Batch 2026 — January'],
            [
                'course_id' => $course->id,
                'name' => 'Batch 2026 — January',
                'start_date' => '2026-01-15',
                'end_date' => '2026-06-15',
                'status' => 'active',
            ]
            );

            // Lessons for each course
            $lessons = [
                ['title' => 'Introduction & Setup', 'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'order' => 1],
                ['title' => 'Core Concepts Deep Dive', 'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'order' => 2],
                ['title' => 'Building Your First Project', 'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'order' => 3],
                ['title' => 'Advanced Techniques', 'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'order' => 4],
                ['title' => 'Deployment & Best Practices', 'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'order' => 5],
            ];

            foreach ($lessons as $lessonData) {
                Lesson::firstOrCreate(
                ['course_id' => $course->id, 'order' => $lessonData['order']],
                    array_merge($lessonData, ['course_id' => $course->id])
                );
            }

            // Admission for student to first 2 courses only
            if (in_array($course->title, ['Full Stack Web Development', 'Data Science & Machine Learning'])) {
                $admission = Admission::firstOrCreate(
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

        // ── Fee record for student ───────────────────
        Fee::firstOrCreate(
        ['user_id' => $student->id],
        [
            'user_id' => $student->id,
            'total_amount' => 14999,
            'paid_amount' => 5000,
            'due_date' => now()->addDays(30),
            'status' => 'pending',
        ]
        );

        $this->command->info('✅ EduLMS demo data seeded successfully!');
        $this->command->info('   Admin:   admin@edulms.com / password');
        $this->command->info('   Student: student@edulms.com / password');
    }
}
