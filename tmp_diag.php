<?php
$userId = 3;
echo "Payments for User ID {$userId}:\n";
foreach(\App\Models\Payment::where('user_id', $userId)->get() as $p) {
    echo "ID: {$p->id} | Amount: ₹{$p->amount} | Status: {$p->status}\n";
}
echo "\nAdmissions for User ID {$userId}:\n";
foreach(\App\Models\Admission::where('user_id', $userId)->get() as $a) {
    echo "ID: {$a->id} | Status: {$a->status} | Created: {$a->created_at}\n";
}
echo "\nFee for User ID {$userId}:\n";
foreach(\App\Models\Fee::where('user_id', $userId)->get() as $f) {
    echo "ID: {$f->id} | Total: ₹{$f->total_amount} | Paid: ₹{$f->paid_amount} | Status: {$f->status}\n";
}
