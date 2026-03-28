<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveClass extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'instructor_name',
        'start_time',
        'duration',
        'zoom_link',
        'status',
        'live_class_branch_id',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function liveClassBranch()
    {
        return $this->belongsTo(LiveClassBranch::class, 'live_class_branch_id');
    }
}
