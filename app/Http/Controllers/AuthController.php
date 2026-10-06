<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\PlanPrice;
use App\Models\User;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use App\Models\Setting;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class AuthController extends Controller
{
    // public function registerpage()
    // {
    //     $plans = PlanPrice::where('status', 'Active')->get();
    //     $first_plan = PlanPrice::where('status', 'Active')->first();
    //     $stripeKey = config('services.stripe.key');
    //     return view('register', compact('plans', 'stripeKey', 'first_plan'));
    // }
    
    public function registerpage(Request $request)
    {
        $plans = PlanPrice::where('status', 'Active')->get();
        $selectedPlan = null;

        if ($request->filled('plan_id')) {
            $selectedPlan = PlanPrice::where('status', 'Active')
                ->where('id', $request->query('plan_id'))
                ->first();
        }

        $first_plan = $selectedPlan ?? $plans->first();
        $stripeKey = config('services.stripe.key');

        return view('register', compact('plans', 'stripeKey', 'first_plan', 'selectedPlan'));
    }

    public function logout(Request $request)
    {
        Auth::logout(); // log the user out

        $request->session()->invalidate(); // clear session
        $request->session()->regenerateToken(); // new CSRF token

        return redirect()->route('loginpage'); // or wherever you want
    }

    public function loginpage()
    {
        return view('login');
    }

    // ─── Coupon Validation Endpoint ────────────────────────────────────
    // public function applyCoupon(Request $request)
    // {
    //     $request->validate([
    //         'code'    => 'required|string',
    //         'plan_id' => 'required|exists:plan_price,id',
    //     ]);

    //     $coupon = Coupon::where('code', strtoupper(trim($request->code)))
    //         ->where('status', 'active')
    //         ->whereDate('start_date', '<=', now())
    //         ->whereDate('expiry_date', '>=', now())
    //         ->first();

    //     if (!$coupon) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Invalid or expired coupon code.',
    //         ]);
    //     }

    //     $plan = PlanPrice::findOrFail($request->plan_id);

    //     if ($coupon->coupon_type === 'percentage') {
    //         $discount   = round($plan->total_price * $coupon->discount / 100, 2);
    //         $finalPrice = round($plan->total_price - $discount, 2);
    //     } else {
    //         $discount   = min((float) $coupon->discount, $plan->total_price);
    //         $finalPrice = round(max(0, $plan->total_price - $discount), 2);
    //     }
        
    //       // Prevent final price from becoming zero or negative
    //     if ($finalPrice <= 1) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Coupon discount cannot make the plan price zero or less.',
    //         ]);
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'coupon'  => [
    //             'code'        => $coupon->code,
    //             'discount'    => (float) $coupon->discount,
    //             'coupon_type' => $coupon->coupon_type,
    //         ],
    //         'preview' => [
    //             'original_price'  => $plan->total_price,
    //             'discount_amount' => $discount,
    //             'final_price'     => $finalPrice,
    //         ],
    //     ]);
    // }
    
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
            ]);
        }

        $plan = PlanPrice::findOrFail($request->plan_id);

        if ($coupon->coupon_type === 'percentage') {
            $discount   = round($plan->total_price * $coupon->discount / 100, 2);
            $finalPrice = round($plan->total_price - $discount, 2);
        } else {
            $discount   = min((float) $coupon->discount, $plan->total_price);
            $finalPrice = round(max(0, $plan->total_price - $discount), 2);
        }

<<<<<<< HEAD
        // Prevent final price from becoming zero or negative
        if ($finalPrice <= 1) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon discount cannot make the plan price zero or less.',
=======
        // ✅ Stripe's minimum chargeable amount for GBP is £0.30 (30 pence).
        // Using pence (integers) avoids float comparison issues.
        $finalPricePence    = (int) round($finalPrice * 100);
        $minChargeablePence = 30; // Stripe GBP minimum

        if ($finalPricePence < $minChargeablePence) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon discount cannot make the plan price less than £0.30.',
>>>>>>> 14b4245 (full updated code)
            ]);
        }

        return response()->json([
            'success' => true,
            'coupon'  => [
                'code'        => $coupon->code,
                'discount'    => (float) $coupon->discount,
                'coupon_type' => $coupon->coupon_type,
            ],
            'preview' => [
                'original_price'  => $plan->total_price,
                'discount_amount' => $discount,
                'final_price'     => $finalPrice,
            ],
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


    public function magicLogin($id, $token, Request $request)
    {
        $user = User::where('id', $id)
            ->where('email_verification_code', $token)
            ->where('status', 'active')
            ->first();

        if (!$user) {
            return redirect()->route('loginpage')
                ->with('error', 'Invalid or expired link');
        }

        // ✅ Login using default user guard
        Auth::login($user);


        // Optional: expire token after use
        // $user->email_verification_code = null;
        // $user->save();

        return redirect()->route('user.dashboard');
    }
    
    public function createPaymentIntent(Request $request)
{
    $request->validate([
        'plan_id'     => 'required|exists:plan_price,id',
        'coupon_code' => 'nullable|string|max:100',
        'email'       => 'required|email', // just for metadata, not saved yet
    ]);

<<<<<<< HEAD
    public function store(Request $request)
    {
        $request->validate([
            'firstName'       => 'required|string|max:100',
            'lastName'        => 'required|string|max:100',
            'email' => [
                'required',
                'email:rfc,dns',
                'regex:/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/',
                'unique:users,email',
                'max:255'
            ],
            'password' => [
                                'required',
                                'min:8',
                                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).+$/'
                            ],
            'confirmPassword' => 'required|same:password',
            'terms'           => 'accepted',
            'address1'        => 'required|string|max:255',
            'address2'        => 'nullable|string|max:255',
            'postcode'        => ['required', 'regex:/^[A-Z]{1,2}\d[A-Z\d]?\s?\d[A-Z]{2}$/i'],
            'country'         => 'nullable|string|max:100',
            'phone'           => ['required', 'regex:/^\+?[\d\s\-]{10,15}$/'],
            'plan_id'         => 'required|exists:plan_price,id',
            'cardName'        => 'required|string|max:255',
            'cardNumber'      => 'required|string',
            'expiry'          => ['required', 'regex:/^\d{2}\/\d{2}$/'],
            'cvv'             => 'required|string',
            'stripeToken'     => 'required|string',
            'coupon_code'     => 'nullable|string|max:100',
        ], [
            'firstName.required'       => 'First name is required.',
            'lastName.required'        => 'Last name is required.',
            'email.required'           => 'Email address is required.',
            'email.email'              => 'Please enter a valid email address.',
            'email.unique'             => 'This email is already registered.',
            'email.regex' => 'Please enter a valid email domain.',
            'password.required'        => 'Password is required.',
            'password.min'             => 'Password must be at least 8 characters.',
            'password.regex'           => 'Password must contain at least 1 uppercase letter, 1 lowercase letter, 1 number and 1 special character.',
            'confirmPassword.required' => 'Please confirm your password.',
            'confirmPassword.same'     => 'Passwords do not match.',
            'terms.accepted'           => 'You must accept the Terms & Conditions and Privacy Policy.',
            'address1.required'        => 'Address line 1 is required.',
            'postcode.required'        => 'Post code is required.',
            'postcode.regex'           => 'Please enter a valid UK postcode (e.g. SW1A 1AA).',
            'country.required'         => 'Country is required.',
            'phone.required'           => 'Phone number is required.',
            'phone.regex'              => 'Please enter a valid phone number (10-15 digits).',
            'plan_id.required'         => 'Please select a plan.',
            'plan_id.exists'           => 'Selected plan is invalid.',
            'cardName.required'        => 'Name on card is required.',
            'cardNumber.required'      => 'Card number is required.',
            'expiry.required'          => 'Expiry date is required.',
            'expiry.regex'             => 'Expiry must be in MM/YY format.',
            'cvv.required'             => 'CVV is required.',
            'stripeToken.required'     => 'Payment token missing. Please re-enter card details.',
        ]);

        // Email Verification GUID
        $data    = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        $guid    = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));

        $plan = PlanPrice::findOrFail($request->plan_id);

        // Server-side coupon + amount calculation
        $couponCode     = null;
        $discountAmount = 0.00;
        $finalAmount    = (float) $plan->total_price;

        if (!empty($request->coupon_code)) {
            $coupon = Coupon::where('code', strtoupper(trim($request->coupon_code)))
                ->where('status', 'active')
                ->whereDate('start_date', '<=', now())
                ->whereDate('expiry_date', '>=', now())
                ->first();

            if ($coupon) {
                $couponCode = $coupon->code;
                if ($coupon->coupon_type === 'percentage') {
                    $discountAmount = round($plan->total_price * $coupon->discount / 100, 2);
                } else {
                    $discountAmount = min((float) $coupon->discount, $plan->total_price);
                }
                $finalAmount = round(max(0, $plan->total_price - $discountAmount), 2);
            }
        }

        $chargeAmountPence = (int) ($finalAmount * 100);

        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $customer = Customer::create([
                'email'  => $request->email,
                'name'   => $request->firstName . ' ' . $request->lastName,
                'source' => $request->stripeToken,
            ]);

            $charge = \Stripe\Charge::create([
                'amount'      => $chargeAmountPence,
                'currency'    => 'gbp',
                'customer'    => $customer->id,
                'description' => $plan->plan_name . ' Plan - Annual Subscription'
                    . ($couponCode ? " (Coupon: {$couponCode})" : ''),
            ]);

            if ($charge->status !== 'succeeded') {
                return response()->json(['success' => false, 'message' => 'Payment was not successful. Please try again.'], 422);
            }

            [$expMonth, $expYear] = explode('/', $request->expiry);

            $user = User::create([
                'first_name'              => ucfirst($request->firstName),
                'last_name'               => ucfirst($request->lastName),
                'email'                   => $request->email,
                'email_verification_code' => $guid,
                'password'                => Hash::make($request->password),
                'phone'                   => $request->phone,
                'address1'                => $request->address1,
                'address2'                => $request->address2,
                'postcode'                => strtoupper($request->postcode),
                'country'                 => 'United Kingdom',
                'plan_id'                 => $plan->id,
                'status'                  => 'active',
            ]);

            $payment = Payment::create([
                'user_id'           => $user->id,
                'card_holder_name'  => $request->cardName,
                'card_last_four'    => substr(str_replace([' ', '•'], '', $request->cardNumber), -4),
                'exp_month'         => trim($expMonth),
                'exp_year'          => '20' . trim($expYear),
                'stripe_payment_id' => $charge->id,
                'discount'          => $discountAmount,
                'amount'            => $finalAmount,
                'currency'          => 'GBP',
                'payment_mode'       => 'card',
                'status'            => 'successful',
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

             Activity::create(
            [
                'user_id' => $user->id,
                'title'       => 'New Registration - ' . $user->first_name . ' ' . $user->last_name,
                'description' => "A new user, {$user->first_name} {$user->last_name} ({$user->email}), has successfully registered an account.",
                'notify_for' => 'admin',
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

            $verifyUrl = route('verify.email',$user->email);

            Mail::send('emails.verify_mail', [
                'user' => $user,
                'verifyUrl' => $verifyUrl
            ], function ($m) use ($user) {
                $m->from(config('mail.from.address'), config('mail.from.name'));
                $m->to($user->email, $user->first_name . ' ' . $user->last_name)
                ->subject('Verify Your Email');
            });
            // ── End Invoice + PDF + Email ──────────────────────────────────

            auth()->login($user);

            return response()->json([
                'success'  => true,
                'redirect' => route('loginpage'),
            ]);
        } catch (\Stripe\Exception\CardException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please try again.'], 500);
=======
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
>>>>>>> 14b4245 (full updated code)
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


    
     public function store(Request $request)
    {
    $request->validate([
        'firstName'       => 'required|string|max:100',
        'lastName'        => 'required|string|max:100',
        'email' => [
            'required',
            'email:rfc,dns',
            'regex:/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/',
            'unique:users,email',
            'max:255'
        ],
        'password' => [
            'required',
            'min:8',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).+$/'
        ],
        'confirmPassword' => 'required|same:password',
        'terms'           => 'accepted',
        'address1'        => 'required|string|max:255',
        'address2'        => 'nullable|string|max:255',
        'postcode'        => ['required', 'regex:/^[A-Z]{1,2}\d[A-Z\d]?\s?\d[A-Z]{2}$/i'],
        'country'         => 'nullable|string|max:100',
        'phone'           => ['required', 'regex:/^\+?[\d\s\-]{10,15}$/'],
        'plan_id'         => 'required|exists:plan_price,id',
        'cardName'        => 'required|string|max:255',
        'cardNumber'      => 'required|string',
        'expiry'          => ['required', 'regex:/^\d{2}\/\d{2}$/'],
        'cvv'             => 'required|string',
        'stripeToken'     => 'required|string',
        'coupon_code'     => 'nullable|string|max:100',
    ], [
        'firstName.required'       => 'First name is required.',
        'lastName.required'        => 'Last name is required.',
        'email.required'           => 'Email address is required.',
        'email.email'              => 'Please enter a valid email address.',
        'email.unique'             => 'This email is already registered.',
        'email.regex' => 'Please enter a valid email domain.',
        'password.required'        => 'Password is required.',
        'password.min'             => 'Password must be at least 8 characters.',
        'password.regex'           => 'Password must contain at least 1 uppercase letter, 1 lowercase letter, 1 number and 1 special character.',
        'confirmPassword.required' => 'Please confirm your password.',
        'confirmPassword.same'     => 'Passwords do not match.',
        'terms.accepted'           => 'You must accept the Terms & Conditions and Privacy Policy.',
        'address1.required'        => 'Address line 1 is required.',
        'postcode.required'        => 'Post code is required.',
        'postcode.regex'           => 'Please enter a valid UK postcode (e.g. SW1A 1AA).',
        'country.required'         => 'Country is required.',
        'phone.required'           => 'Phone number is required.',
        'phone.regex'              => 'Please enter a valid phone number (10-15 digits).',
        'plan_id.required'         => 'Please select a plan.',
        'plan_id.exists'           => 'Selected plan is invalid.',
        'cardName.required'        => 'Name on card is required.',
        'cardNumber.required'      => 'Card number is required.',
        'expiry.required'          => 'Expiry date is required.',
        'expiry.regex'             => 'Expiry must be in MM/YY format.',
        'cvv.required'             => 'CVV is required.',
        'stripeToken.required'     => 'Payment token missing. Please re-enter card details.',
    ]);

    // Email Verification GUID
    $data    = random_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    $guid    = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));

    $plan = PlanPrice::findOrFail($request->plan_id);

    // Server-side coupon + amount calculation
    $couponCode     = null;
    $discountAmount = 0.00;
    $finalAmount    = (float) $plan->total_price;

    if (!empty($request->coupon_code)) {
        $coupon = Coupon::where('code', strtoupper(trim($request->coupon_code)))
            ->where('status', 'active')
            ->whereDate('start_date', '<=', now())
            ->whereDate('expiry_date', '>=', now())
            ->first();

        if ($coupon) {
            $couponCode = $coupon->code;
            if ($coupon->coupon_type === 'percentage') {
                $discountAmount = round($plan->total_price * $coupon->discount / 100, 2);
            } else {
                $discountAmount = min((float) $coupon->discount, $plan->total_price);
            }
            $finalAmount = round(max(0, $plan->total_price - $discountAmount), 2);
        }
    }

    // ✅ Stripe's minimum chargeable amount for GBP is £0.30 (30 pence).
    // Using pence (integers) avoids float comparison issues.
    $finalAmountPence   = (int) round($finalAmount * 100);
    $minChargeablePence = 30; // Stripe GBP minimum

    if ($finalAmountPence < $minChargeablePence) {
        return response()->json([
            'success' => false,
            'message' => 'The final amount must be at least £0.30 after applying any coupon.',
        ], 422);
    }

    $chargeAmountPence = $finalAmountPence;

    try {
        Stripe::setApiKey(config('services.stripe.secret'));

        $customer = Customer::create([
            'email'  => $request->email,
            'name'   => $request->firstName . ' ' . $request->lastName,
            'source' => $request->stripeToken,
        ]);

        $charge = \Stripe\Charge::create([
            'amount'      => $chargeAmountPence,
            'currency'    => 'gbp',
            'customer'    => $customer->id,
            'description' => $plan->plan_name . ' Plan - Annual Subscription'
                . ($couponCode ? " (Coupon: {$couponCode})" : ''),
        ]);

        if ($charge->status !== 'succeeded') {
            Log::error('Registration error: Stripe charge did not succeed', [
                'charge_id'     => $charge->id ?? null,
                'charge_status' => $charge->status ?? null,
                'plan_id'       => $plan->id,
                'email'         => $request->email,
            ]);

            return response()->json(['success' => false, 'message' => 'Payment was not successful. Please try again.'], 422);
        }

        [$expMonth, $expYear] = explode('/', $request->expiry);

        $user = User::create([
            'first_name'              => ucfirst($request->firstName),
            'last_name'               => ucfirst($request->lastName),
            'email'                   => $request->email,
            'email_verification_code' => $guid,
            'password'                => Hash::make($request->password),
            'phone'                   => $request->phone,
            'address1'                => $request->address1,
            'address2'                => $request->address2,
            'postcode'                => strtoupper($request->postcode),
            'country'                 => 'United Kingdom',
            'plan_id'                 => $plan->id,
            'status'                  => 'active',
        ]);

        $payment = Payment::create([
            'user_id'           => $user->id,
            'card_holder_name'  => $request->cardName,
            'card_last_four'    => substr(str_replace([' ', '•'], '', $request->cardNumber), -4),
            'exp_month'         => trim($expMonth),
            'exp_year'          => '20' . trim($expYear),
            'stripe_payment_id' => $charge->id,
            'discount'          => $discountAmount,
            'amount'            => $finalAmount,
            'currency'          => 'GBP',
            'payment_mode'       => 'card',
            'status'            => 'successful',
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

        Activity::create(
            [
                'user_id' => $user->id,
                'title'       => 'New Registration - ' . $user->first_name . ' ' . $user->last_name,
                'description' => "A new user, {$user->first_name} {$user->last_name} ({$user->email}), has successfully registered an account.",
                'notify_for' => 'admin',
            ]
        );

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

        // ── End Invoice + PDF + Email ──────────────────────────────────

        auth()->login($user);

        return response()->json([
            'success'  => true,
            'redirect' => route('user.dashboard'),
        ]);
    } catch (\Stripe\Exception\CardException $e) {
        Log::error('Registration error (Stripe CardException): ' . $e->getMessage(), [
            'stripe_code'  => $e->getStripeCode(),
            'decline_code' => $e->getDeclineCode(),
            'http_status'  => $e->getHttpStatus(),
            'email'        => $request->email,
            'plan_id'      => $request->plan_id,
        ]);

        return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
    } catch (\Exception $e) {
        Log::error('Registration error: ' . $e->getMessage(), [
            'exception' => get_class($e),
            'file'      => $e->getFile(),
            'line'      => $e->getLine(),
            'trace'     => $e->getTraceAsString(),
            'email'     => $request->email,
            'plan_id'   => $request->plan_id,
        ]);

        return response()->json(['success' => false, 'message' => 'Something went wrong. Please try again.'], 500);
    }
}
    

    public function login(Request $request)
    {

        // ✅ Validation
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        $user = User::where('email', $request->email)->first();

        // ❌ User not found
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 401);
        }

        // ❌ Password incorrect
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Password is incorrect'
            ], 401);
        }

        // ❌ User inactive
        if ($user->status != 'active') {
            return response()->json([
                'status' => false,
                'message' => 'User is inactive'
            ], 403);
        }

        // ✅ Login with remember me
        Auth::login($user, $request->remember);

        // ✅ 🔔 SAVE FCM TOKEN HERE
        if ($request->has('fcm_token')) {
            $user->update([
                'fcm_token' => $request->fcm_token
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Login successful'
        ]);
    }

    public function saveToken(Request $request)
    {

        $request->validate([
            'token' => 'required'
        ]);

        auth()->user()->update([
            'fcm_token' => $request->token
        ]);

        return response()->json([
            'status' => true
        ]);
    }

    public function forgotPasswordPage()
    {

        return view('forgot-password');
    }

    public function storeForgotPassword(Request $request)
    {
        
         
        try {

            $validator = \Validator::make($request->all(), [
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
                ]);
            }

            $token = \Str::random(64);

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
                'message' => 'Reset link sent successfully'
            ]);
        } catch (\Exception $e) {

            \Log::error($e); // 🔥 important for debugging

            return response()->json([
                'status' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function showResetForm($token, Request $request)
    {
        $reset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('role', 'user')
            ->first();

        // Check token exists
        if (!$reset) {
            return redirect()
                ->route('forgotpassword.page')
                ->with('error', 'Invalid reset link');
        }

        // Check token match
        if (!hash_equals($reset->token, $token)) {
            return redirect()
                ->route('forgotpassword.page')
                ->with('error', 'Invalid reset token');
        }

        // Check token expiry (60 minutes)
        if (Carbon::parse($reset->created_at)->addMinutes(60)->isPast()) {

            // Optional: delete expired token
            DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->delete();

            return redirect()
                ->route('forgotpassword.page')
                ->with('error', 'Reset link expired');
        }

        return view('reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
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

<<<<<<< HEAD
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }


        // Find reset record
        $reset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('role', 'user') // 👈 change role
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
=======
    // Check token expiry (60 minutes)
    if (Carbon::parse($reset->created_at)->addMinutes(15)->isPast()) {
>>>>>>> 14b4245 (full updated code)

        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return response()->json([
            'status' => true,
            'message' => 'Password reset successful'
        ]);
    }

   public function verifyEmail($email)
{
<<<<<<< HEAD
    $user = User::where('email',$email)->first();
    if(!$user){
        return redirect()->route('loginpage')
            ->with('error','User not found');
    }
    // Already verified
    if($user->is_verified == 1){
        return redirect()->route('loginpage')
            ->with('success','Email already verified');
=======
    $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'token' => ['required'],
            'new_password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'
            ],
            'new_password_confirmation' => [
                'required'
            ]
        ], [
            'new_password.required' => 'New password is required',
            'new_password.min' => 'Password must be at least 8 characters',
            'new_password.confirmed' => 'Passwords do not match',
            'new_password.regex' => 'Password must contain uppercase, lowercase, number and special character',
            'new_password_confirmation.required' => 'Confirm password is required',
        ]);
                
                if ($validator->fails()) {
                    return response()->json([
                        'status' => false,
                        'errors' => $validator->errors()
                        ], 422);
                        }
                        
                       
    // Find reset record
    $reset = DB::table('password_reset_tokens')
        ->where('email', $request->email)
        ->where('role', 'user') // 👈 change role
        ->first();

    if (!$reset) {
        return response()->json([
            'status' => false,
            'message' => 'Invalid reset request'
        ], 400);
>>>>>>> 14b4245 (full updated code)
    }

    // Verify email
    $user->update([
        'is_verified' => 1
    ]);

    return redirect()->route('loginpage')
        ->with('success','Email verified successfully');
}

public function verifyEmail($email)
{
    $user = User::where('email', $email)->first();

    if (!$user) {
        return redirect()->route('loginpage')
            ->with('error', 'User not found');
    }

    // Already verified
    if ($user->is_verified == 1) {
        if (Auth::check()) {
            return redirect()->route('user.dashboard')
                ->with('success', 'Email already verified');
        }

        return redirect()->route('loginpage')
            ->with('success', 'Email already verified');
    }

    // Verify email
    $user->update([
        'is_verified' => 1
    ]);

    if (Auth::check()) {
        return redirect()->route('user.dashboard')
            ->with('success', 'Email verified successfully');
    }

    return redirect()->route('loginpage')
        ->with('success', 'Email verified successfully');
}

}
