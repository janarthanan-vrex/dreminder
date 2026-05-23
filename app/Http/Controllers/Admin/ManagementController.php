<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\PlanPrice;
use App\Models\User;

class ManagementController extends Controller
{
    public function transactionPage(Request $request)
    {
        $transactions = Payment::with([
            'user.plan',
            'invoice'
        ])
        ->latest()
        ->get()
        ->map(function ($payment) {

            return [
                'id'         => $payment->id,
                'txn_id'     => $payment->stripe_payment_id ?? 'N/A',
                'tnx_order'  => optional($payment->invoice)->invoice_id ?? 'N/A',
                'user_name'  => optional($payment->user)->first_name . ' ' .
                                optional($payment->user)->last_name,
                'user_email' => optional($payment->user)->email,
                'plan_name'  => optional(optional($payment->user)->plan)->plan_name ?? 'No Plan',
                'order_ref'  => optional($payment->invoice)->invoice_id ?? 'N/A',
                'amount'     => $payment->amount,
                'status'     => strtolower($payment->status),
                'method'     => $payment->payment_mode,
                'date'       => $payment->created_at->format('d M Y'),
                'items'      => [
                    optional(optional($payment->user)->plan)->plan_name
                ],
            ];
        });
       

        return view('admin.transactions', compact('transactions'));
    }
}
