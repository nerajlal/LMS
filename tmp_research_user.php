<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Fee;
use App\Models\Payment;
use App\Models\Admission;

$userId = 3; // The user from previous cleanup

echo "Researching User ID: " . $userId . "\n";

$fees = Fee::where('user_id', $userId)->get();
echo "Fees Found: " . $fees->count() . "\n";
foreach($fees as $f) {
    echo " - Fee ID " . $f->id . " | Total: " . $f->total_amount . " | Paid: " . $f->paid_amount . "\n";
}

$payments = Payment::where('user_id', $userId)->get();
echo "Payments Found: " . $payments->count() . "\n";
foreach($payments as $p) {
    echo " - Payment ID " . $p->id . " | Amount: " . $p->amount . " | Type: " . $p->type . "\n";
}

$admissions = Admission::where('user_id', $userId)->get();
echo "Admissions Found: " . $admissions->count() . "\n";
foreach($admissions as $a) {
    echo " - Admission ID " . $a->id . " | Course ID: " . $a->course_id . "\n";
}
