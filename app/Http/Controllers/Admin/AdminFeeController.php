<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fee;

class AdminFeeController extends Controller
{
    public function index()
    {
        $fees = Fee::with('user')
            ->latest()
            ->paginate(20);

        $stats = [
            'total_due'       => Fee::where('status', 'pending')->sum('total_amount'),
            'total_collected' => Fee::where('status', 'paid')->sum('paid_amount'),
        ];

        return view('admin.fees.index', compact('fees', 'stats'));
    }

    public function markPaid(Fee $fee)
    {
        $fee->update([
            'paid_amount' => $fee->total_amount,
            'status'      => 'paid',
        ]);
        return back()->with('success', 'Fee marked as paid.');
    }
}
