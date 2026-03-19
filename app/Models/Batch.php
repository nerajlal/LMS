<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Batch extends Model {
    protected $fillable = ['course_id', 'name', 'start_date', 'end_date', 'status'];
    public function course() { return $this->belongsTo(Course::class); }
    public function admissions() { return $this->hasMany(Admission::class); }
}
