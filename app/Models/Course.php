<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['title', 'description', 'thumbnail', 'price', 'instructor_name'];

    public function lessons()   { return $this->hasMany(Lesson::class); }
    public function batches()   { return $this->hasMany(Batch::class); }
    public function admissions(){ return $this->hasMany(Admission::class); }
    public function enrollments(){ return $this->hasMany(Enrollment::class); }
}
