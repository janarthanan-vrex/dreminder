<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Customer;
use App\Models\PlanPrice;
use App\Models\Coupon;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\Activity;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Reminder;
use App\Models\Feedback;
use App\Models\UserNotificationSetting;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
            'fcm_api' => 'nullable'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 401);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Password is incorrect'
            ], 401);
        }

        if ($user->status != 'active') {
            return response()->json([
                'status' => false,
                'message' => 'User is inactive'
            ], 403);
        }

        // Save FCM token
        if ($request->fcm_api) {
            $user->update([
                'fcm_api' => $request->fcm_api
            ]);
        }

        // ✅ CREATE TOKEN (IMPORTANT)
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user
        ]);
    }
    
     public function checkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $exists = User::where('email', strtolower(trim($request->email)))->exists();
        return response()->json(['exists' => $exists]);
    }
    
        public function checkPhone(Request $request)
        {
    // Sanitize phone number before checking if needed, or keep it strict
    $request->validate(['phone' => 'required']);
    
    $exists = User::where('phone', trim($request->phone))->exists();
    return response()->json(['exists' => $exists]);
}

    // public function register(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [

    //         'firstName'       => 'required|string|max:100',
    //         'lastName'        => 'required|string|max:100',

    //         'email' => [
    //             'required',
    //             'email:rfc,dns',
    //             'unique:users,email'
    //         ],

    //         'password' => [
    //             'required',
    //             'min:8',
    //             'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).+$/'
    //         ],

    //         'confirmPassword' => 'required|same:password',

    //         'address1' => 'required|string|max:255',
    //         'address2' => 'nullable|string|max:255',

    //         'postcode' => [
    //             'required',
    //             'regex:/^[A-Z]{1,2}\d[A-Z\d]?\s\d[A-Z]{2}$/i'
    //         ],

    //         'phone' => [
    //             'required',
    //             'regex:/^\+?[\d\s\-]{10,15}$/'
    //         ],

    //         'plan_id' => 'required|exists:plan_price,id',

    //         'cardName' => 'required|string|max:255',
    //         'cardNumber' => 'required|string',
    //         'expiry' => 'required|regex:/^\d{2}\/\d{2}$/',
    //         'cvv' => 'required|string',
    //         'stripeToken' => 'required|string',

    //         'coupon_code' => 'nullable|string|max:100',

    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'success' => false,
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }

    //     try {

    //         // Generate GUID
    //         $data = random_bytes(16);
    //         $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    //         $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    //         $guid = vsprintf(
    //             '%s%s-%s-%s-%s-%s%s%s',
    //             str_split(bin2hex($data), 4)
    //         );

    //         $plan = PlanPrice::findOrFail($request->plan_id);

    //         $couponCode = null;
    //         $discountAmount = 0;
    //         $finalAmount = (float) $plan->total_price;

    //         if ($request->filled('coupon_code')) {

    //             $coupon = Coupon::where('code', strtoupper(trim($request->coupon_code)))
    //                 ->where('status', 'active')
    //                 ->whereDate('start_date', '<=', now())
    //                 ->whereDate('expiry_date', '>=', now())
    //                 ->first();

    //             if ($coupon) {

    //                 $couponCode = $coupon->code;

    //                 if ($coupon->coupon_type == 'percentage') {
    //                     $discountAmount = round(
    //                         $plan->total_price * $coupon->discount / 100,
    //                         2
    //                     );
    //                 } else {
    //                     $discountAmount = min(
    //                         $coupon->discount,
    //                         $plan->total_price
    //                     );
    //                 }

    //                 $finalAmount = round(
    //                     max(0, $plan->total_price - $discountAmount),
    //                     2
    //                 );
    //             }
    //         }

    //         Stripe::setApiKey(config('services.stripe.secret'));

    //         $customer = Customer::create([
    //             'email' => $request->email,
    //             'name' => $request->firstName . ' ' . $request->lastName,
    //             'source' => $request->stripeToken,
    //         ]);

    //         $charge = \Stripe\Charge::create([
    //             'amount' => $finalAmount * 100,
    //             'currency' => 'gbp',
    //             'customer' => $customer->id,
    //             'description' => $plan->plan_name,
    //         ]);

    //         if ($charge->status !== 'succeeded') {

    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Payment failed'
    //             ], 422);
    //         }

    //         $user = User::create([

    //             'first_name' => ucfirst($request->firstName),
    //             'last_name' => ucfirst($request->lastName),
    //             'email' => $request->email,
    //             'email_verification_code' => $guid,
    //             'password' => Hash::make($request->password),
    //             'phone' => $request->phone,
    //             'address1' => $request->address1,
    //             'address2' => $request->address2,
    //             'postcode' => strtoupper($request->postcode),
    //             'country' => 'United Kingdom',
    //             'plan_id' => $plan->id,
    //             'status' => 'active'
    //         ]);

    //         [$month, $year] = explode('/', $request->expiry);

    //         $payment = Payment::create([
    //             'user_id' => $user->id,
    //             'card_holder_name' => $request->cardName,
    //             'card_last_four' => substr(
    //                 preg_replace('/\D/', '', $request->cardNumber),
    //                 -4
    //             ),
    //             'exp_month' => $month,
    //             'exp_year' => '20' . $year,
    //             'stripe_payment_id' => $charge->id,
    //             'discount' => $discountAmount,
    //             'amount' => $finalAmount,
    //             'currency' => 'GBP',
    //             'payment_mode' => 'card',
    //             'status' => 'successful'
    //         ]);

    //         // ── Invoice + PDF + Email ──────────────────────────────────────
    //         $invoiceId = 'INV-' . str_pad($payment->id, 3, '0', STR_PAD_LEFT);

    //         // ✅ Only invoices folder (no year/month)
    //         $invoiceDir  = public_path('invoices');
    //         $invoicePath = 'invoices/' . $invoiceId . '.pdf';

    //         // Create folder if not exists
    //         if (!file_exists($invoiceDir)) {
    //             mkdir($invoiceDir, 0755, true);
    //         }

    //         // Save in DB
    //         Invoice::create([
    //             'user_id'      => $user->id,
    //             'plan_id'      => $plan->id,
    //             'payment_id'   => $payment->id,
    //             'invoice_id'   => $invoiceId,
    //             'amount'       => $finalAmount,
    //             'invoice_path' => $invoicePath,
    //             'type'         => 'paid',
    //         ]);

    //         // Generate PDF
    //         $pdf = \PDF::loadView('emails.invoice_view', [
    //             'user'           => $user,
    //             'payment'        => $payment,
    //             'plan'           => $plan,
    //             'invoiceId'      => $invoiceId,
    //             'basePrice'      => (float) $plan->price,
    //             'vatAmount'      => (float) ($plan->vat ?? 0),
    //             'discount'       => $discountAmount,
    //             'couponCode'     => $couponCode,
    //             'finalAmount'    => $finalAmount,
    //             'currencySymbol' => '£',
    //             'issueDate'      => now()->format('d M Y'),
    //             'dueDate'        => now()->format('d M Y'),
    //             'isPaid'         => true,
    //             'balance'        => 0,
    //         ]);

    //         // Save PDF
    //         $pdf->save(public_path($invoicePath));

    //         Activity::create([
    //             'user_id' => $user->id,
    //             'title' => 'New Registration - ' . $user->first_name,
    //             'description' => 'New user registered',
    //             'notify_for' => 'admin'
    //         ]);

    //         Mail::send('emails.user_register', [
    //             'user'      => $user,
    //             'plan'      => $plan,
    //             'invoiceId' => $invoiceId,
    //             'amount'    => $finalAmount,
    //             'discount'  => $discountAmount,
    //         ], function ($m) use ($user, $pdf, $invoiceId) {
    //             $m->from(config('mail.from.address'), config('mail.from.name'));
    //             $m->to($user->email, $user->first_name . ' ' . $user->last_name)
    //                 ->subject('Payment Successful - Invoice ' . $invoiceId)
    //                 ->attachData($pdf->output(), $invoiceId . '.pdf', ['mime' => 'application/pdf']);
    //         });

    //         $verifyUrl = route('verify.email', $user->email);

    //         Mail::send('emails.verify_mail', [
    //             'user' => $user,
    //             'verifyUrl' => $verifyUrl
    //         ], function ($m) use ($user) {
    //             $m->from(config('mail.from.address'), config('mail.from.name'));
    //             $m->to($user->email, $user->first_name . ' ' . $user->last_name)
    //                 ->subject('Verify Your Email');
    //         });

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Registration successful',
    //             'data' => [
    //                 'user_id' => $user->id,
    //                 'name' => $user->first_name . ' ' . $user->last_name,
    //                 'email' => $user->email,
    //                 'plan' => $plan->plan_name,
    //                 'amount' => $finalAmount
    //             ]
    //         ], 201);
    //     } catch (\Stripe\Exception\CardException $e) {

    //         return response()->json([
    //             'success' => false,
    //             'message' => $e->getMessage()
    //         ], 422);
    //     } catch (\Exception $e) {

    //         Log::error($e->getMessage());

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Something went wrong'
    //         ], 500);
    //     }
    // }
    
    public function register(Request $request)
{
    $validator = Validator::make($request->all(), [

        'firstName'       => 'required|string|max:100',
        'lastName'        => 'required|string|max:100',

        'email' => [
            'required',
            'email:rfc,dns',
            'unique:users,email'
        ],

        'password' => [
            'required',
            'min:8',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).+$/'
        ],

        'confirmPassword' => 'required|same:password',

        'address1' => 'required|string|max:255',
        'address2' => 'nullable|string|max:255',

        'postcode' => [
            'required',
            'regex:/^[A-Z]{1,2}\d[A-Z\d]?\s\d[A-Z]{2}$/i'
        ],

        'phone' => [
            'required',
            'regex:/^\+?[\d\s\-]{10,15}$/'
        ],

        'plan_id' => 'required|exists:plan_price,id',

        'cardName' => 'nullable|string|max:255',
        'cardNumber' => 'nullable|string',
        'expiry' => 'nullable|regex:/^\d{2}\/\d{2}$/',
        'cvv' => 'nullable|string',
        'stripeToken' => 'required|string',

        'coupon_code' => 'nullable|string|max:100',

    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    try {

        // Generate GUID
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        $guid = vsprintf(
            '%s%s-%s-%s-%s-%s%s%s',
            str_split(bin2hex($data), 4)
        );

        $plan = PlanPrice::findOrFail($request->plan_id);

        $couponCode = null;
        $discountAmount = 0;
        $finalAmount = (float) $plan->total_price;

        if ($request->filled('coupon_code')) {

            $coupon = Coupon::where('code', strtoupper(trim($request->coupon_code)))
                ->where('status', 'active')
                ->whereDate('start_date', '<=', now())
                ->whereDate('expiry_date', '>=', now())
                ->first();

            if ($coupon) {

                $couponCode = $coupon->code;

                if ($coupon->coupon_type == 'percentage') {
                    $discountAmount = round(
                        $plan->total_price * $coupon->discount / 100,
                        2
                    );
                } else {
                    $discountAmount = min(
                        $coupon->discount,
                        $plan->total_price
                    );
                }

                $finalAmount = round(
                    max(0, $plan->total_price - $discountAmount),
                    2
                );
            }
        }

        // ── Verify PaymentIntent instead of creating a Charge ──────────
        Stripe::setApiKey(config('services.stripe.secret'));

        $intent = PaymentIntent::retrieve($request->stripeToken);

        if ($intent->status !== 'succeeded') {
            Log::error('Registration error: PaymentIntent not succeeded', [
                'payment_intent_id' => $intent->id,
                'status'            => $intent->status,
                'email'             => $request->email,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Payment was not successful. Current status: ' . $intent->status
            ], 422);
        }

        // Use the amount actually charged on the intent as source of truth
        $finalAmount = $intent->amount / 100;

        // Try to pull real card details from the PaymentMethod used
        $cardLastFour = substr(preg_replace('/\D/', '', $request->cardNumber), -4);
        $expMonth = null;
        $expYear = null;

        if ($intent->payment_method) {
            try {
                $pm = \Stripe\PaymentMethod::retrieve($intent->payment_method);
                if ($pm->card) {
                    $cardLastFour = $pm->card->last4;
                    $expMonth = $pm->card->exp_month;
                    $expYear = $pm->card->exp_year;
                }
            } catch (\Exception $e) {
                Log::error('Could not retrieve PaymentMethod: ' . $e->getMessage());
            }
        }

        // Fallback to the expiry field from the request if PM lookup failed
        if (!$expMonth || !$expYear) {
            [$month, $year] = explode('/', $request->expiry);
            $expMonth = trim($month);
            $expYear = '20' . trim($year);
        }
        // ── End PaymentIntent verification ──────────────────────────────

        $user = User::create([

            'first_name' => ucfirst($request->firstName),
            'last_name' => ucfirst($request->lastName),
            'email' => $request->email,
            'email_verification_code' => $guid,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'postcode' => strtoupper($request->postcode),
            'country' => 'United Kingdom',
            'plan_id' => $plan->id,
            'status' => 'active'
        ]);

        $payment = Payment::create([
            'user_id' => $user->id,
            'card_holder_name' => $request->cardName,
            'card_last_four' => $cardLastFour,
            'exp_month' => $expMonth,
            'exp_year' => $expYear,
            'stripe_payment_id' => $intent->id,
            'discount' => $discountAmount,
            'amount' => $finalAmount,
            'currency' => 'GBP',
            'payment_mode' => 'card',
            'status' => 'successful'
        ]);

        // ── Invoice + PDF + Email ──────────────────────────────────────
        $invoiceId = 'INV-' . str_pad($payment->id, 3, '0', STR_PAD_LEFT);

        // ✅ Only invoices folder (no year/month)
        $invoiceDir  = public_path('invoices');
        $invoicePath = 'invoices/' . $invoiceId . '.pdf';

        // Create folder if not exists
        if (!file_exists($invoiceDir)) {
            mkdir($invoiceDir, 0755, true);
        }

        // Save in DB
        Invoice::create([
            'user_id'      => $user->id,
            'plan_id'      => $plan->id,
            'payment_id'   => $payment->id,
            'invoice_id'   => $invoiceId,
            'amount'       => $finalAmount,
            'invoice_path' => $invoicePath,
            'type'         => 'paid',
        ]);

        // Generate PDF
        $pdf = \PDF::loadView('emails.invoice_view', [
            'user'           => $user,
            'payment'        => $payment,
            'plan'           => $plan,
            'invoiceId'      => $invoiceId,
            'basePrice'      => (float) $plan->price,
            'vatAmount'      => (float) ($plan->vat ?? 0),
            'discount'       => $discountAmount,
            'couponCode'     => $couponCode,
            'finalAmount'    => $finalAmount,
            'currencySymbol' => '£',
            'issueDate'      => now()->format('d M Y'),
            'dueDate'        => now()->format('d M Y'),
            'isPaid'         => true,
            'balance'        => 0,
        ]);

        // Save PDF
        $pdf->save(public_path($invoicePath));

        Activity::create([
            'user_id' => $user->id,
            'title' => 'New Registration - ' . $user->first_name,
            'description' => 'New user registered',
            'notify_for' => 'admin'
        ]);

        Mail::send('emails.user_register', [
            'user'      => $user,
            'plan'      => $plan,
            'invoiceId' => $invoiceId,
            'amount'    => $finalAmount,
            'discount'  => $discountAmount,
        ], function ($m) use ($user, $pdf, $invoiceId) {
            $m->from(config('mail.from.address'), config('mail.from.name'));
            $m->to($user->email, $user->first_name . ' ' . $user->last_name)
                ->subject('Payment Successful - Invoice ' . $invoiceId)
                ->attachData($pdf->output(), $invoiceId . '.pdf', ['mime' => 'application/pdf']);
        });

        $verifyUrl = route('verify.email', $user->email);

        Mail::send('emails.verify_mail', [
            'user' => $user,
            'verifyUrl' => $verifyUrl
        ], function ($m) use ($user) {
            $m->from(config('mail.from.address'), config('mail.from.name'));
            $m->to($user->email, $user->first_name . ' ' . $user->last_name)
                ->subject('Verify Your Email');
        });

        return response()->json([
            'success' => true,
            'message' => 'Registration successful',
            'data' => [
                'user_id' => $user->id,
                'name' => $user->first_name . ' ' . $user->last_name,
                'email' => $user->email,
                'plan' => $plan->plan_name,
                'amount' => $finalAmount
            ]
        ], 201);
    } catch (\Stripe\Exception\CardException $e) {

        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 422);
    } catch (\Exception $e) {

        Log::error($e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Something went wrong'
        ], 500);
    }
}
    
        public function createPaymentIntent(Request $request)
        {
    $request->validate([
        'plan_id'     => 'required|exists:plan_price,id',
        'coupon_code' => 'nullable|string|max:100',
        'email'       => 'required|email', // just for metadata, not saved yet
    ]);

    $plan = PlanPrice::findOrFail($request->plan_id);

    $discountAmount = 0.00;
    $finalAmount = (float) $plan->total_price;
    $couponCode = null;

    if (!empty($request->coupon_code)) {
        $coupon = Coupon::where('code', strtoupper(trim($request->coupon_code)))
            ->where('status', 'active')
            ->whereDate('start_date', '<=', now())
            ->whereDate('expiry_date', '>=', now())
            ->first();

        if ($coupon) {
            $couponCode = $coupon->code;
            $discountAmount = $coupon->coupon_type === 'percentage'
                ? round($plan->total_price * $coupon->discount / 100, 2)
                : min((float) $coupon->discount, $plan->total_price);
            $finalAmount = round(max(0, $plan->total_price - $discountAmount), 2);
        }
    }

    $finalAmountPence = (int) round($finalAmount * 100);

    if ($finalAmountPence < 30) {
        return response()->json(['success' => false, 'message' => 'Amount must be at least £0.30.'], 422);
    }

    Stripe::setApiKey(config('services.stripe.secret'));

    $intent = \Stripe\PaymentIntent::create([
        'amount'   => $finalAmountPence,
        'currency' => 'gbp',
        'metadata' => [
            'plan_id'     => $plan->id,
            'coupon_code' => $couponCode,
            'email'       => $request->email,
        ],
        'automatic_payment_methods' => ['enabled' => true],
    ]);

    return response()->json([
        'success'          => true,
        'payment_intent_id'=> $intent->id,
        'client_secret'    => $intent->client_secret,
        'final_amount'     => $finalAmount,
        'discount_amount'  => $discountAmount,
    ]);
}

    public function forgotPassword(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'email' => 'required|email:rfc,dns'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'This email is not registered with us.'
                ], 404);
            }

            $token = Str::random(64);

            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $request->email],
                [
                    'role' => 'user',
                    'token' => $token,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );

            Mail::send('emails.user_reset_link', [
                'user' => $user,
                'token' => $token,
                'email' => $request->email
            ], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('User Reset Password');
            });

            return response()->json([
                'status' => true,
                'message' => 'Reset link sent successfully',
                'data' => [
                    'email' => $request->email,
                    'token' => $token
                ]
            ], 200);
        } catch (\Exception $e) {

            Log::error('Forgot Password Error : ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Server error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'token' => ['required'],
            'new_password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'
            ],
        ], [
            'new_password.required' => 'New password is required',
            'new_password.min' => 'Password must be at least 8 characters',
            'new_password.confirmed' => 'Passwords do not match',
            'new_password.regex' => 'Password must contain uppercase, lowercase, number and special character',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $reset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('role', 'user')
            ->first();

        if (!$reset) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid reset request'
            ], 400);
        }

        if (!hash_equals($reset->token, $request->token)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or expired token'
            ], 400);
        }

        if (Carbon::parse($reset->created_at)->addMinutes(60)->isPast()) {
            return response()->json([
                'status' => false,
                'message' => 'Token expired'
            ], 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return response()->json([
            'status' => true,
            'message' => 'Password reset successful'
        ], 200);
    }
    
    public function verifyResetToken(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => ['required', 'email'],
        'token' => ['required', 'string'],
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    $reset = DB::table('password_reset_tokens')
        ->where('email', $request->email)
        ->where('role', 'user')
        ->first();

    if (!$reset) {
        return response()->json([
            'status' => false,
            'message' => 'Invalid reset request'
        ], 400);
    }

    if (!hash_equals($reset->token, $request->token)) {
        return response()->json([
            'status' => false,
            'message' => 'Invalid or expired token'
        ], 400);
    }

    if (Carbon::parse($reset->created_at)->addMinutes(15)->isPast()) {
        return response()->json([
            'status' => false,
            'message' => 'Token expired'
        ], 400);
    }

    return response()->json([
        'status' => true,
        'message' => 'Token is valid'
    ], 200);
}
    
     public function getPlans(Request $request)
    {
        $plans = planPrice::all();
        return response()->json([
            'status' => true,
            'message' => 'Plans fetched successfully',
            'plans' => $plans
        ], 200);
    }

    public function getCoupons(Request $request)
    {
        $coupons = Coupon::all();
        return response()->json([
            'status' => true,
            'message' => 'Coupons fetched successfully',
            'coupons' => $coupons
        ], 200);
    }

    public function getCategory(Request $request)
    {
        $category = Category::all();

        return response()->json([
            'status' => true,
            'message' => 'All categories fetched successfully',
            'category' => $category
        ], 200);
    }

    public function getSubCategory(Request $request){
        $user = Auth::user();
        $subcategory = SubCategory::where('created_by',$user->id)
                        ->where('role','user')
                        ->where('status','Active')
                        ->get();
        return response()->json([
            'status' => 'true',
            'message' => 'Subcategory fetched successfully',
            'subcategory' => $subcategory
        ],200);                
    }
    public function dashboard(Request $request)
    {
        $user = Auth::user();

        $categories = Category::with([
            'subcategories' => function ($query) {
                $query->where('status', 'Active');
            }
        ])
            ->where('status', 'Active')
            ->get();

        $now = Carbon::now();

        $activeReminders = Reminder::where('user_id', $user->id)
            ->where('status', 'Active')
            ->where('reminder_status', '!=', 'completed')
            ->where(function ($query) use ($now) {
                $query->whereDate('reminder_date', '>', $now->toDateString())
                    ->orWhere(function ($q) use ($now) {
                        $q->whereDate('reminder_date', $now->toDateString())
                            ->whereTime('reminder_time', '>=', $now->toTimeString());
                    });
            })
            ->count();

        $dueThisWeek = Reminder::where('user_id', $user->id)
            ->where('status', 'Active')
            ->where('reminder_status', '!=', 'completed')
            ->whereBetween('reminder_date', [
                $now->copy()->startOfWeek()->toDateString(),
                $now->copy()->endOfWeek()->toDateString()
            ])
            ->count();

        $completedReminders = Reminder::where('user_id', $user->id)
            ->where('reminder_status', 'completed')
            ->count();

        $todayReminders = Reminder::where('user_id', $user->id)
            ->where('status', 'Active')
            ->where('reminder_status', '!=', 'completed')
            ->whereDate('reminder_date', $now->toDateString())
            ->count();

        $upcomingReminders = Reminder::with([
            'category',
            'subcategory'
        ])
            ->where('user_id', $user->id)
            ->where('status', 'Active')
            ->where('reminder_status', '!=', 'completed')
            ->whereDate('reminder_date', '>=', $now->toDateString())
            ->orderBy('reminder_date')
            ->orderBy('reminder_time')
            ->take(5)
            ->get()
            ->map(function ($r) {
                return [
                    'id' => $r->id,
                    'title' => $r->title,
                    'category' => $r->category?->name,
                    'icon' => $r->category?->icon,
                    'color' => $r->category?->color,
                    'subcategory' => $r->subcategory?->name,
                    'due_date' => $r->reminder_date,
                    'due_time' => $r->reminder_time,
                    'status' => strtolower($r->status),
                    'reminder_status' => strtolower($r->reminder_status),
                    'provider' => $r->provider
                ];
            });

        return response()->json([
            'status' => true,
            'message' => 'Dashboard data fetched successfully',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->first_name . ' ' . $user->last_name,
                    'email' => $user->email,
                    'is_verified' => $user->is_verified,
                    'profile' => $user->profile? asset($user->profile) : null
                ],

                'statistics' => [
                    'active_reminders' => $activeReminders,
                    'due_this_week' => $dueThisWeek,
                    'completed_reminders' => $completedReminders,
                    'today_reminders' => $todayReminders,
                ],

                'categories' => $categories,

                'upcoming_reminders' => $upcomingReminders
            ]
        ], 200);
    }
    public function userProfile(Request $request)
    {
        $user = Auth::user();
        return response()->json([
            'status' => 'true',
            'message' => 'User Profile',
            'user' => $user
        ], 200);
    }
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name'  => 'required|string|max:50',
            'email'      => 'required|email|unique:users,email,' . $user->id,
            'phone'      => 'required|digits_between:10,15',
            'address1'   => 'required|string|max:100',
            'address2'   => 'nullable|string|max:100',
            'postcode'   => [
                'required',
                'regex:/^(GIR 0AA|[A-Z]{1,2}\d{1,2}[A-Z]?\s\d[A-Z]{2})$/i'
            ],
            'profile'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload Profile Image
        if ($request->hasFile('profile')) {

            if ($user->profile && File::exists(public_path($user->profile))) {
                File::delete(public_path($user->profile));
            }

            $file = $request->file('profile');

            $filename = time() . '_' . rand(1000, 9999) . '.' .
                $file->getClientOriginalExtension();

            $destinationPath = public_path('profile');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);

            $user->profile = 'profile/' . $filename;
        }

        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->email      = $request->email;
        $user->phone      = $request->phone;
        $user->postcode   = strtoupper($request->postcode);
        $user->address1   = $request->address1;
        $user->address2   = $request->address2;

        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully',
            'user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'postcode' => $user->postcode,
                'address1' => $user->address1,
                'address2' => $user->address2,
                'profile' => $user->profile,
                'image_url' => $user->profile
                    ? asset($user->profile)
                    : null
            ]
        ], 200);
    }

    public function userTransaction(Request $request)
{
    $user = Auth::user();
    $invoices = Invoice::with(['plan', 'payment', 'user'])
        ->where('user_id', $user->id)
        ->latest()
        ->get();
    $transactions = $invoices->map(function ($invoice) {
        $firstName = $invoice->user->first_name ?? '';
        $lastName  = $invoice->user->last_name ?? '';
        $fullName = trim($firstName . ' ' . $lastName);
        return [
            'id' => $invoice->id,
            'txn_id' => $invoice->invoice_id ?: 'TXN-' . $invoice->id,
            'order_ref' => 'ORD-' . str_pad($invoice->id, 5, '0', STR_PAD_LEFT),
            'customer' => [
                'name' => $fullName ?: 'Unknown User',
                'email' => $invoice->user->email ?? '',
                'color' => '#7c3aed',
            ],
            'plan_name' => $invoice->plan->plan_name ?? 'N/A',
            'amount' => (float) ($invoice->amount ?? 0),
            'discount' => (float) ($invoice->discount ?? 0),
            'type' => $invoice->type ?? 'N/A',
            'status' => $invoice->payment_id
                ? 'completed'
                : 'pending',
            'date' => $invoice->created_at->format('Y-m-d H:i:s'),
            'dateStr' => $invoice->created_at->format('d M Y'),
            'invoice_path' => $invoice->invoice_path
                ? asset($invoice->invoice_path)
                : null,
        ];
    });
    return response()->json([
        'status' => true,
        'message' => 'Transactions fetched successfully',
        'total_transactions' => $transactions->count(),
        'transactions' => $transactions
    ], 200);
}

public function userNotifications()
{
    $user = Auth::user();

    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'Unauthenticated'
        ], 401);
    }

    $activities = Activity::with([
        'reminder.category',
        'reminder.subcategory'
    ])
    ->where('user_id', $user->id)
    ->where(function ($query) {
        $query->where('notify_for', '!=', 'admin')
            ->orWhereNull('notify_for')
            ->orWhere('notify_for', '');
    })
    ->latest()
    ->get()
    ->map(function ($activity) {

        $reminder = $activity->reminder;
        $category = $reminder?->category;

        return [
            'id' => $activity->id,
            'description' => $activity->description,
            'is_seen' => (bool) $activity->is_seen,
            'is_auto' => (bool) $activity->is_auto_generate,
            'created_at' => $activity->created_at->diffForHumans(),
            'raw_date' => $activity->created_at->format('d M Y'),

            'reminder' => $reminder ? [
                'id' => $reminder->id,
                'title' => $reminder->title,
            ] : null,

            'category' => $category ? [
                'name' => $category->name,
                'icon' => $category->icon,
                'color' => $category->color,
            ] : null,
        ];
    });

    $unreadCount = $activities->where('is_seen', true)->count();

    $settings = UserNotificationSetting::firstOrCreate(
        ['user_id' => $user->id],
        [
            'email_notify' => false,
            'push_notify' => false,
            'before_30_days' => false,
            'before_7_days' => false,
            'before_3_days' => false,
            'before_1_day' => false,
            'on_day' => false,
        ]
    );

    return response()->json([
        'status' => true,
        'message' => 'Notifications fetched successfully',
        'unread_count' => $activities->where('is_seen', 0)->count(),
        'settings' => $settings,
        'notifications' => $activities
    ], 200);
}

public function storeFeedback(Request $request)
{
    $request->validate([
        'subject' => 'required|string|min:5|max:100',
        'message' => 'required|string|min:10',
        'priority' => 'required|string|in:Low,Medium,High,Critical',
        'is_receive' => 'nullable|boolean',
    ], [
        'subject.required' => 'Subject is required',
        'message.required' => 'Message is required',
        'priority.required' => 'Please select priority',
    ]);

    $user = Auth::user();

    $feedback = Feedback::create([
        'user_id' => $user->id,
        'subject' => $request->subject,
        'message' => $request->message,
        'priority' => $request->priority,
        'is_receive' => $request->is_receive ?? 0,
        'admin_reply' => null,
    ]);

    Activity::create([
        'user_id' => $user->id,
        'title' => 'Feedback from '.$user->first_name.' '.$user->last_name.' - '.$request->subject,
        'description' => $request->message,
        'notify_for' => 'admin',
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Feedback submitted successfully',
        'data' => [
            'id' => $feedback->id,
            'subject' => $feedback->subject,
            'priority' => $feedback->priority,
            'created_at' => $feedback->created_at
        ]
    ], 201);
}

public function changePassword(Request $request)
{
    $user = auth()->user();

    $request->validate([
        'current_password' => 'required',
        'new_password' => [
            'required',
            'min:8',
            'regex:/[A-Z]/',
            'regex:/[a-z]/',
            'regex:/[0-9]/',
            'regex:/[@$!%*#?&]/'
        ],
        'confirm_password' => 'required|same:new_password'
    ], [
        'new_password.regex' => 'Password must contain at least 1 uppercase, 1 lowercase, 1 number, and 1 special character',
        'confirm_password.same' => 'Confirm password does not match'
    ]);

    // Check current password
    if (!Hash::check($request->current_password, $user->password)) {

        return response()->json([
            'status' => false,
            'errors' => [
                'current_password' => [
                    'Current password is incorrect'
                ]
            ]
        ], 422);
    }

    // Prevent same password
    if (Hash::check($request->new_password, $user->password)) {

        return response()->json([
            'status' => false,
            'errors' => [
                'new_password' => [
                    'New password must be different from current password'
                ]
            ]
        ], 422);
    }

    $user->update([
        'password' => Hash::make($request->new_password)
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Password updated successfully'
    ], 200);
}

public function verifyEmail(Request $request)
{
    $request->validate([
        'email' => 'required|email'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'User not found'
        ], 404);
    }

    if ($user->is_verified) {
        return response()->json([
            'status' => true,
            'message' => 'Email already verified'
        ]);
    }

    $user->update([
        'is_verified' => 1
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Email verified successfully'
    ]);
}


public function applyCoupon(Request $request)
    {
        $request->validate([
            'code'    => 'required|string',
            'plan_id' => 'required|exists:plan_price,id',
        ]);

        $coupon = Coupon::where('code', strtoupper(trim($request->code)))
            ->where('status', 'active')
            ->whereDate('start_date', '<=', now())
            ->whereDate('expiry_date', '>=', now())
            ->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired coupon code.',
            ], 404);
        }

        $plan = PlanPrice::findOrFail($request->plan_id);

        if ($coupon->coupon_type === 'percentage') {
            $discount = round($plan->total_price * $coupon->discount / 100, 2);
            $finalPrice = round($plan->total_price - $discount, 2);
        } else {
            $discount = min((float) $coupon->discount, $plan->total_price);
            $finalPrice = round(max(0, $plan->total_price - $discount), 2);
        }

        // Stripe minimum charge for GBP (£0.30)
        $finalPricePence = (int) round($finalPrice * 100);
        $minChargeablePence = 30;

        if ($finalPricePence < $minChargeablePence) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon discount cannot make the plan price less than £0.30.',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully.',
            'coupon' => [
                'code' => $coupon->code,
                'discount' => (float) $coupon->discount,
                'coupon_type' => $coupon->coupon_type,
            ],
            'preview' => [
                'original_price' => $plan->total_price,
                'discount_amount' => $discount,
                'final_price' => $finalPrice,
            ],
        ], 200);
    }



}
