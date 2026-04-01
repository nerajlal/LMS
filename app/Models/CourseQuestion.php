<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseQuestion extends Model
{
    protected $fillable = [
        'course_id',
        'question',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_option',
        'points',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
