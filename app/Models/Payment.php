<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Payment extends Model {
    protected $fillable = ['user_id', 'fee_id', 'amount', 'payment_id', 'status', 'type'];
    public function user() { return $this->belongsTo(\App\Models\User::class); }
    public function fee() { return $this->belongsTo(\App\Models\Fee::class); }
}
