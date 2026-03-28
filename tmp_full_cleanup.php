<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Fee;
use App\Models\Payment;
use App\Models\Admission;

$userId = 3;

echo "Cleaning up all records for User ID: " . $userId . "\n";

$admissionsCount = Admission::where('user_id', $userId)->delete();
echo "Deleted " . $admissionsCount . " Admissions.\n";

$paymentsCount = Payment::where('user_id', $userId)->delete();
echo "Deleted " . $paymentsCount . " Payments.\n";

$feesCount = Fee::where('user_id', $userId)->delete();
echo "Deleted " . $feesCount . " Fees.\n";

echo "Cleanup completed successfully.\n";
