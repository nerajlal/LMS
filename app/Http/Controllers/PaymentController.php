<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentController extends Controller
{
    public function create()
    {
        $fees = \App\Models\Fee::where('user_id', auth()->id())->get();
        return Inertia::render('Payments/Create', compact('fees'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        // TODO: Initiate PhonePe payment here
        // $response = PhonePeService::initiate($data['amount'], auth()->user(), route('payments.callback'));

        $payment = Payment::create([
            'user_id'    => auth()->id(),
            'amount'     => $data['amount'],
            'payment_id' => null,
            'status'     => 'pending',
            'type'       => 'course_fee',
        ]);

        // Redirect to PhonePe payment URL
        // return redirect($response->payment_url);

        return redirect()->route('fees.index')->with('info', 'Payment initiated. Complete it on the gateway.');
    }

    public function callback(Request $request)
    {
        // TODO: Verify PhonePe callback signature
        // Update payment status
        return redirect()->route('fees.index')->with('success', 'Payment received!');
    }
}
