<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\PlanPrice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class AuthController extends Controller
{
    public function registerpage()
    {
        $plans = PlanPrice::where('status', 'Active')->get();
        $first_plan = PlanPrice::where('status', 'Active')->first();
        $stripeKey = config('services.stripe.key');
        return view('register', compact('plans', 'stripeKey', 'first_plan'));
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

    public function magicLogin($id, $token)
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


    // ─── Registration Store ────────────────────────────────────────────
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'firstName'       => 'required|string|max:100',
    //         'lastName'        => 'required|string|max:100',
    //         'email'           => 'required|email|unique:users,email|max:255',
    //         'password'        => ['required', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
    //         'confirmPassword' => 'required|same:password',
    //         'terms'           => 'accepted',
    //         'address1'        => 'required|string|max:255',
    //         'address2'        => 'nullable|string|max:255',
    //         'postcode'        => ['required', 'regex:/^[A-Z]{1,2}\d[A-Z\d]?\s?\d[A-Z]{2}$/i'],
    //         'country'         => 'required|string|max:100',
    //         'phone'           => ['required', 'regex:/^\+?[\d\s\-]{10,15}$/'],
    //         'plan_id'         => 'required|exists:plan_price,id',
    //         'cardName'        => 'required|string|max:255',
    //         'cardNumber'      => 'required|string',
    //         'expiry'          => ['required', 'regex:/^\d{2}\/\d{2}$/'],
    //         'cvv'             => 'required|string',
    //         'stripeToken'     => 'required|string',
    //         'coupon_code'     => 'nullable|string|max:100',
    //     ], [
    //         'firstName.required'       => 'First name is required.',
    //         'lastName.required'        => 'Last name is required.',
    //         'email.required'           => 'Email address is required.',
    //         'email.email'              => 'Please enter a valid email address.',
    //         'email.unique'             => 'This email is already registered.',
    //         'password.required'        => 'Password is required.',
    //         'password.min'             => 'Password must be at least 8 characters.',
    //         'password.regex'           => 'Password must contain uppercase, lowercase and a number.',
    //         'confirmPassword.required' => 'Please confirm your password.',
    //         'confirmPassword.same'     => 'Passwords do not match.',
    //         'terms.accepted'           => 'You must accept the Terms & Conditions.',
    //         'address1.required'        => 'Address line 1 is required.',
    //         'postcode.required'        => 'Post code is required.',
    //         'postcode.regex'           => 'Please enter a valid UK postcode (e.g. SW1A 1AA).',
    //         'country.required'         => 'Country is required.',
    //         'phone.required'           => 'Phone number is required.',
    //         'phone.regex'              => 'Please enter a valid phone number (10-15 digits).',
    //         'plan_id.required'         => 'Please select a plan.',
    //         'plan_id.exists'           => 'Selected plan is invalid.',
    //         'cardName.required'        => 'Name on card is required.',
    //         'cardNumber.required'      => 'Card number is required.',
    //         'expiry.required'          => 'Expiry date is required.',
    //         'expiry.regex'             => 'Expiry must be in MM/YY format.',
    //         'cvv.required'             => 'CVV is required.',
    //         'stripeToken.required'     => 'Payment token missing. Please re-enter card details.',
    //     ]);

    //      // Email Verification GUID
    //     $data = random_bytes(16);
    //     $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    //     $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    //     $guid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));

    //     $plan = PlanPrice::findOrFail($request->plan_id);

    //     // ─── Server-side coupon + amount calculation ───────────────────
    //     $couponCode     = null;
    //     $discountAmount = 0.00;
    //     $finalAmount    = (float) $plan->total_price;

    //     if (!empty($request->coupon_code)) {
    //         $coupon = Coupon::where('code', strtoupper(trim($request->coupon_code)))
    //             ->where('status', 'active')
    //             ->whereDate('start_date', '<=', now())
    //             ->whereDate('expiry_date', '>=', now())
    //             ->first();

    //         if ($coupon) {
    //             $couponCode = $coupon->code;
    //             if ($coupon->coupon_type === 'percentage') {
    //                 $discountAmount = round($plan->total_price * $coupon->discount / 100, 2);
    //             } else {
    //                 $discountAmount = min((float) $coupon->discount, $plan->total_price);
    //             }
    //             $finalAmount = round(max(0, $plan->total_price - $discountAmount), 2);
    //         }
    //     }

    //     $chargeAmountPence = (int) ($finalAmount * 100);

    //     try {
    //         Stripe::setApiKey(config('services.stripe.secret'));

    //         $customer = Customer::create([
    //             'email'  => $request->email,
    //             'name'   => $request->firstName . ' ' . $request->lastName,
    //             'source' => $request->stripeToken,
    //         ]);

    //         $charge = \Stripe\Charge::create([
    //             'amount'      => $chargeAmountPence,
    //             'currency'    => 'gbp',
    //             'customer'    => $customer->id,
    //             'description' => $plan->plan_name . ' Plan - Annual Subscription'
    //                 . ($couponCode ? " (Coupon: {$couponCode})" : ''),
    //         ]);

    //         if ($charge->status !== 'succeeded') {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Payment was not successful. Please try again.',
    //             ], 422);
    //         }

    //         [$expMonth, $expYear] = explode('/', $request->expiry);

    //         $user = User::create([
    //             'first_name' => $request->firstName,
    //             'last_name'  => $request->lastName,
    //             'email'      => $request->email,
    //             'email_verification_code' => $guid,
    //             'password'   => Hash::make($request->password),
    //             'phone'      => $request->phone,
    //             'address1'   => $request->address1,
    //             'address2'   => $request->address2,
    //             'postcode'   => strtoupper($request->postcode),
    //             'country'    => 'United Kingdom',
    //             'plan_id'    => $plan->id,
    //             'status'     => 'active',
    //         ]);

    //         Payment::create([
    //             'user_id'           => $user->id,
    //             'card_holder_name'  => $request->cardName,
    //             'card_last_four'    => substr(str_replace([' ', '•'], '', $request->cardNumber), -4),
    //             'exp_month'         => trim($expMonth),
    //             'exp_year'          => '20' . trim($expYear),
    //             'stripe_payment_id' => $charge->id,
    //             'discount'          => $discountAmount,   // server-verified discount
    //             'amount'            => $finalAmount,       // server-verified final amount
    //             'currency'          => 'GBP',
    //             'status'            => 'successful',
    //         ]);

    //         auth()->login($user);

    //         return response()->json([
    //             'success'  => true,
    //             'redirect' => route('loginpage'),
    //         ]);

    //     } catch (\Stripe\Exception\CardException $e) {
    //         return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
    //     } catch (\Exception $e) {
    //         Log::error('Registration error: ' . $e->getMessage());
    //         return response()->json(['success' => false, 'message' => 'Something went wrong. Please try again.'], 500);
    //     }
    // }

    public function store(Request $request)
    {
        $request->validate([
            'firstName'       => 'required|string|max:100',
            'lastName'        => 'required|string|max:100',
            'email'           => 'required|email|unique:users,email|max:255',
            'password'        => ['required', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
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
            'password.required'        => 'Password is required.',
            'password.min'             => 'Password must be at least 8 characters.',
            'password.regex'           => 'Password must contain uppercase, lowercase and a number.',
            'confirmPassword.required' => 'Please confirm your password.',
            'confirmPassword.same'     => 'Passwords do not match.',
            'terms.accepted'           => 'You must accept the Terms & Conditions.',
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
                'status'            => 'successful',
            ]);

            // ── Invoice + PDF + Email ──────────────────────────────────────
            $invoiceId   = 'INV-' . now()->format('Ymd') . '-' . str_pad($payment->id, 5, '0', STR_PAD_LEFT);

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
        }
    }

   public function login(Request $request)
{
    
    // ✅ Validation
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6'
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

        $request->validate([
            'email' => 'required|email:rfc,dns'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'This email is not registered with us.'
            ]);
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

    } catch (\Illuminate\Validation\ValidationException $e) {

        return response()->json([
            'status' => false,
            'message' => $e->errors()['email'][0] ?? 'Validation error'
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'status' => false,
            'message' => 'Something went wrong'
        ]);
    }
}
}
