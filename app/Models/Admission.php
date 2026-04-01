<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Admission extends Model {
    protected $fillable = ['user_id', 'course_id', 'batch_id', 'status', 'details', 'progress', 'certificate_path', 'completed_lessons'];
    protected $casts = [
        'details' => 'array',
        'completed_lessons' => 'array'
    ];
    public function course() { return $this->belongsTo(Course::class); }
    public function batch()  { return $this->belongsTo(LiveClassBranch::class, 'batch_id'); }
    public function user()   { return $this->belongsTo(\App\Models\User::class); }
    public function examResults() { return $this->hasMany(CourseExamResult::class); }
    public function latestExamResult() { return $this->hasOne(CourseExamResult::class)->latestOfMany(); }
}
