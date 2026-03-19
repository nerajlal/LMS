<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Enrollment extends Model {
    protected $fillable = ['user_id', 'course_id', 'batch_id', 'status'];
    public function course() { return $this->belongsTo(Course::class); }
    public function batch()  { return $this->belongsTo(Batch::class); }
    public function user()   { return $this->belongsTo(\App\Models\User::class); }
}
