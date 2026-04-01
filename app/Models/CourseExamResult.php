<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseExamResult extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'admission_id',
        'total_questions',
        'total_correct',
        'score',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }
}
