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
        'recording_url',
        'recording_description',
        'status',
        'live_class_branch_id',
    ];

    protected $casts = [
        'start_time' => 'datetime',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function liveClassBranch()
    {
        return $this->belongsTo(LiveClassBranch::class, 'live_class_branch_id');
    }

    /**
     * Check if the class has finished (Start + Duration + 10 mins)
     */
    public function isEnded()
    {
        if (!$this->start_time) return false;
        
        // Extract numeric minutes from duration string (e.g., "60 mins" -> 60)
        preg_match('/(\d+)/', $this->duration, $matches);
        $minutes = isset($matches[1]) ? intval($matches[1]) : 0;
        
        // Calculate end time with 10 minute buffer
        $endTime = $this->start_time->copy()->addMinutes($minutes)->addMinutes(10);
        
        return now()->greaterThan($endTime);
    }

    /**
     * Check if the class is currently active for joining (15 mins early buffer)
     */
    public function isLive()
    {
        // Admins and Trainers skip most time checks once it's close or status is live
        if ($this->isEnded()) return false;
        
        // Force live if status is set
        if (strtolower($this->status) === 'live') return true;
        
        // Safety check for start time
        if (!$this->start_time) return false;

        // Active if now is after (start - 15 mins)
        return now()->isAfter($this->start_time->copy()->subMinutes(15));
    }
}
