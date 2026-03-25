<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['title', 'description', 'thumbnail', 'price', 'instructor_name', 'youtube_link', 'learning_outcomes'];

    public function lessons()   { return $this->hasMany(Lesson::class); }

    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Fee::class);
    }

    public function liveClasses()
    {
        return $this->hasMany(LiveClass::class);
    }

    public function studyMaterials()
    {
        return $this->hasMany(StudyMaterial::class);
    }

    public function batches()   { return $this->hasMany(Batch::class); }
    public function admissions(){ return $this->hasMany(Admission::class); }
    public function enrollments(){ return $this->hasMany(Enrollment::class); }
}
