<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveClassBranch extends Model
{
    protected $fillable = [
        'course_id',
        'trainer_id',
        'name',
        'status',
        'description',
        'learning_outcomes',
        'price',
        'thumbnail',
        'is_standalone'
    ];

    /**
     * Get effective metadata for display.
     * Fallback to course data if not standalone.
     */
    public function getDisplayMetadata()
    {
        if ($this->is_standalone) {
            return (object) [
                'title' => $this->name,
                'description' => $this->description,
                'learning_outcomes' => $this->learning_outcomes,
                'price' => $this->price,
                'thumbnail' => $this->thumbnail,
                'is_standalone' => true
            ];
        }

        // Fallback to course
        if ($this->course) {
            return (object) [
                'title' => $this->course->title,
                'description' => $this->course->description,
                'learning_outcomes' => $this->course->learning_outcomes,
                'price' => $this->course->price,
                'thumbnail' => $this->course->thumbnail,
                'is_standalone' => false
            ];
        }

        // Minimal fallback
        return (object) [
            'title' => $this->name,
            'description' => 'Interactive live sessions.',
            'learning_outcomes' => '',
            'price' => 0,
            'thumbnail' => null,
            'is_standalone' => true
        ];
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function trainers()
    {
        return $this->belongsToMany(User::class, 'live_class_branch_trainer', 'live_class_branch_id', 'trainer_id')->withTimestamps();
    }

    public function liveClasses()
    {
        return $this->hasMany(LiveClass::class, 'live_class_branch_id');
    }
}
