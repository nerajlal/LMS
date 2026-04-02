<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['code', 'discount_amount', 'student_email', 'batch_id', 'course_id', 'user_id', 'is_used'];

    public function course()
    {
        return $this->belongsTo(\App\Models\Course::class, 'course_id');
    }

    public function batch()
    {
        return $this->belongsTo(\App\Models\LiveClassBranch::class, 'batch_id');
    }

    public function trainer()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
