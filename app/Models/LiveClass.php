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
        if ($this->isEnded()) return false;
        
        // If status is forced to 'live', it's live
        if (strtolower($this->status) === 'live') return true;
        
        // Allow joining 15 minutes before official start time
        if (!$this->start_time) return false;
        
        return now()->greaterThanOrEqualTo($this->start_time->copy()->subMinutes(15));
    }
}
