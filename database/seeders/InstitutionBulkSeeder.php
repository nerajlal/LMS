<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\LiveClassBranch;
use App\Models\LiveClass;
use App\Models\Lesson;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class InstitutionBulkSeeder extends Seeder
{
    public function run(): void
    {
        $sarah = User::where('email', 'sarah@edulms.com')->first();
        $arjun = User::where('email', 'arjun@edulms.com')->first();
        $mark = User::where('email', 'mark@edulms.com')->first();

        if (!$sarah || !$arjun || !$mark) {
            $this->command->error('Faculties not found. Please run Sarah setup subagent first.');
            return;
        }

        $faculties = [
            ['user' => $sarah, 'specialization' => 'MEP'],
            ['user' => $arjun, 'specialization' => 'BIM'],
            ['user' => $mark, 'specialization' => 'AEC Management'],
        ];

        $courseTemplates = [
            'MEP' => [
                ['title' => 'Advanced HVAC Layouts', 'price' => 11000],
                ['title' => 'Electrical Infrastructure for High-Rises', 'price' => 13500],
            ],
            'BIM' => [
                ['title' => 'Master Diploma in BIM', 'price' => 18000],
                ['title' => 'Revit Architecture & MEP', 'price' => 14000],
                ['title' => 'Navisworks Clash Detection', 'price' => 12500],
            ],
            'AEC Management' => [
                ['title' => 'Institutional AEC Project Management', 'price' => 9500],
                ['title' => 'Lean Construction Methodologies', 'price' => 10500],
                ['title' => 'Sustainable Urban Design', 'price' => 15000],
            ],
        ];

        // Create remaining Courses (Already 1 MEP exists for Sarah)
        foreach ($faculties as $faculty) {
            $user = $faculty['user'];
            $spec = $faculty['specialization'];
            
            foreach ($courseTemplates[$spec] as $c) {
                $course = Course::create([
                    'title' => $c['title'],
                    'instructor_name' => $user->name,
                    'price' => $c['price'],
                    'description' => "Professional certificate program in {$c['title']} by {$user->name}.",
                    'thumbnail' => "https://images.unsplash.com/photo-1541888946425-d81bb19480c5?auto=format&fit=crop&q=80&w=600",
                    'learning_outcomes' => "Mastery level knowledge in {$c['title']}\nIndustry standard workflows\nIndependent project certification",
                ]);

                // Add 3 standard lessons per course
                for ($i = 1; $i <= 3; $i++) {
                    Lesson::create([
                        'course_id' => $course->id,
                        'title' => "Module {$i}: Introduction to {$c['title']}",
                        'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                        'order' => $i,
                    ]);
                }
            }
        }

        // Create 15 Live Batches (Already 1 exists for Sarah)
        $statuses = ['active', 'active', 'active']; // All 'active' but we will vary session times
        $allCourses = Course::all();
        
        for ($i = 1; $i <= 14; $i++) {
            $faculty = $faculties[$i % 3];
            $course = $allCourses->random();
            
            $batch = LiveClassBranch::create([
                'name' => "{$course->title} - Global Cohort " . ($i + 1),
                'course_id' => $course->id,
                'status' => 'active',
                'trainer_id' => $faculty['user']->id,
                'description' => "Premium live sessions for {$course->title}.",
                'price' => $course->price,
                'is_standalone' => false,
            ]);
            $batch->trainers()->sync([$faculty['user']->id]);

            // Add 3 sessions per batch: Ended, Ongoing, Upcoming
            $now = Carbon::now();
            
            // Session 1: Ended (Yesterday)
            LiveClass::create([
                'title' => 'Kickoff & Fundamentals',
                'course_id' => $course->id,
                'live_class_branch_id' => $batch->id,
                'instructor_name' => $faculty['user']->name,
                'start_time' => $now->copy()->subDays(1)->setTime(10, 0),
                'duration' => '90 mins',
                'status' => 'ended',
                'zoom_link' => 'https://zoom.us/j/ended-session',
            ]);

            // Session 2: Ongoing (In 1 hour)
            LiveClass::create([
                'title' => 'Advanced Implementation',
                'course_id' => $course->id,
                'live_class_branch_id' => $batch->id,
                'instructor_name' => $faculty['user']->name,
                'start_time' => $now->copy()->addHour(),
                'duration' => '90 mins',
                'status' => 'scheduled',
                'zoom_link' => 'https://zoom.us/j/ongoing-session',
            ]);

            // Session 3: Upcoming (Next week)
            LiveClass::create([
                'title' => 'Project Review',
                'course_id' => $course->id,
                'live_class_branch_id' => $batch->id,
                'instructor_name' => $faculty['user']->name,
                'start_time' => $now->copy()->addDays(7)->setTime(14, 0),
                'duration' => '90 mins',
                'status' => 'scheduled',
                'zoom_link' => 'https://zoom.us/j/upcoming-session',
            ]);
        }

        $this->command->info('✅ Institution Bulk Population Complete: 9 Courses, 15 Batches, 45+ Live Sessions.');
    }
}
