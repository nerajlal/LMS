<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentController extends Controller
{
    public function create()
    {
        $fees = \App\Models\Fee::with('course')
            ->where('user_id', auth()->id())
            ->where('status', '!=', 'paid')
            ->get();
            
        return Inertia::render('Payments/Create', compact('fees'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'fee_id' => 'required|exists:fees,id',
            'amount' => 'required|numeric|min:1',
        ]);

        $fee = \App\Models\Fee::findOrFail($data['fee_id']);
        
        // Ensure user owns this fee
        if ($fee->user_id !== auth()->id()) {
            abort(403);
        }

        // TODO: Initiate PhonePe payment here
        // $response = PhonePeService::initiate($data['amount'], auth()->user(), route('payments.callback'));

        $payment = Payment::create([
            'user_id'    => auth()->id(),
            'fee_id'     => $fee->id, // Assuming a fee_id column exists or needs adding
            'amount'     => $data['amount'],
            'payment_id' => 'TXN_' . uniqid(),
            'status'     => 'success', // Simulating instant success for now
            'type'       => 'course_fee',
        ]);

        // Update fee status
        $fee->paid_amount += $data['amount'];
        if ($fee->paid_amount >= $fee->total_amount) {
            $fee->status = 'paid';
        } else {
            $fee->status = 'partially_paid';
        }
        $fee->save();

        return redirect()->route('fees.index')->with('success', 'Payment successful! Your course access is updated.');
    }

    public function callback(Request $request)
    {
        // TODO: Verify PhonePe callback signature
        // Update payment status
        return redirect()->route('fees.index')->with('success', 'Payment received!');
    }
}
