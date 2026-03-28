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
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function liveClasses()
    {
        return $this->hasMany(LiveClass::class, 'live_class_branch_id');
    }
}
