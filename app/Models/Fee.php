<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Fee extends Model {
    protected $fillable = ['user_id', 'course_id', 'total_amount', 'paid_amount', 'due_date', 'status'];
    public function user() { return $this->belongsTo(\App\Models\User::class); }
    public function course() { return $this->belongsTo(\App\Models\Course::class); }
    public function payments() { return $this->hasMany(\App\Models\Payment::class); }
}
