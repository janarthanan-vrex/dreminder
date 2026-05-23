<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    public function loginPage(Request $request)
    {
        return view('admin.admin-login');
    }

    // public function adminLogin(Request $request)
    // {
    //     // ── Validation errors → field specific ──────────────────────────────
    //     $validator = \Validator::make($request->all(), [
    //         'email'    => 'required|email',
    //         'password' => 'required|min:8',
    //     ], [
    //         'email.required'    => 'Email address is required.',
    //         'email.email'       => 'Please enter a valid email address.',
    //         'password.required' => 'Password is required.',
    //         'password.min'      => 'Password must be at least 8 characters.',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'success' => false,
    //             'errors'  => $validator->errors(),
    //         ], 422);
    //     }

    //     // ── Check email exists ───────────────────────────────────────────────
    //     $admin = \App\Models\Admin::where('email', $request->email)->first();

    //     if (!$admin) {
    //         return response()->json([
    //             'success' => false,
    //             'errors'  => ['email' => ['No account found with this email address.']],
    //         ], 401);
    //     }

    //     // ── Check password ───────────────────────────────────────────────────
    //     if (!\Hash::check($request->password, $admin->password)) {
    //         return response()->json([
    //             'success' => false,
    //             'errors'  => ['password' => ['The password you entered is incorrect.']],
    //         ], 401);
    //     }

    //     // ── Check status ─────────────────────────────────────────────────────
    //     if ($admin->status !== 'active') {
    //         return response()->json([
    //             'success' => false,
    //             'errors'  => ['email' => ['Your account has been deactivated. Contact support.']],
    //         ], 403);
    //     }

    //     // ── All good → login ─────────────────────────────────────────────────
    //     Auth::guard('admin')->login($admin, $request->boolean('remember_me'));
    //     $request->session()->regenerate();

    //     return response()->json([
    //         'success'  => true,
    //         'redirect' => route('admin.dashboard'),
    //     ]);
    // }

    public function adminLogin(Request $request)
    {
// dd($request->all());
        // ── Validation ───────────────────────────────────────────────────────
        $validator = \Validator::make($request->all(), [
            'name'     => 'required|string',
            'password' => 'required|min:8',
        ], [
            'name.required'     => 'Name is required.',
            'password.required' => 'Password is required.',
            'password.min'      => 'Password must be at least 8 characters.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        // ── Check name exists ────────────────────────────────────────────────
        $admin = \App\Models\Admin::where('name', $request->name)->first();

        if (!$admin) {
            return response()->json([
                'success' => false,
                'errors'  => ['name' => ['No account found with this name.']],
            ], 401);
        }

        // ── Check password ───────────────────────────────────────────────────
        if (!\Hash::check($request->password, $admin->password)) {
            return response()->json([
                'success' => false,
                'errors'  => ['password' => ['The password you entered is incorrect.']],
            ], 401);
        }

        // ── Check status ─────────────────────────────────────────────────────
        if ($admin->status !== 'active') {
            return response()->json([
                'success' => false,
                'errors'  => ['name' => ['Your account has been deactivated. Contact support.']],
            ], 403);
        }

        // ── All good → login ─────────────────────────────────────────────────
        Auth::guard('admin')->login($admin, $request->boolean('remember_me'));
        $request->session()->regenerate();

        return response()->json([
            'success'  => true,
            'redirect' => route('admin.dashboard'),
        ]);
    }

public function adminLogout(Request $request)
{
    // dd("fds");
    auth()->guard('admin')->logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect()->route('admin.login');
}

    public function adminDashboard(Request $request)
    {

        return view('admin.dashboard');
    }

    public function adminForgotPage(Request $request){
        return view('admin.admin-forgot-password');
    }

    public function storeForgotPassword(Request $request)
{
    try {
        // ── Validate ─────────────────────────────────────────────────────
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email',
        ], [
            'email.required' => 'Email address is required.',
            'email.email'    => 'Please enter a valid email address.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        // ── Check admin exists ────────────────────────────────────────────
        $admin = \App\Models\Admin::where('email', $request->email)->first();

        if (!$admin) {
            return response()->json([
                'status'  => false,
                'message' => 'This email is not registered with us.',
            ], 404);
        }

        // ── Check admin is active ─────────────────────────────────────────
        if ($admin->status !== 'active') {
            return response()->json([
                'status'  => false,
                'message' => 'Your account has been deactivated. Contact support.',
            ], 403);
        }

        // ── Generate token & store in DB ──────────────────────────────────
        $token = \Str::random(64);

        \DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'role' => 'admin',
                'token'      => $token,
                'created_at' => now(),
            ]
        );

        // ── Send mail ─────────────────────────────────────────────────────
        \Mail::send('emails.admin_reset_link', [
            'admin' => $admin,
            'token' => $token,
            'email' => $request->email,
        ], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Admin Password Reset Link');
        });

        return response()->json([
            'status'  => true,
            'message' => 'Reset link sent successfully',
        ]);

    } catch (\Exception $e) {
        \Log::error('Admin forgot password error: ' . $e->getMessage());

        return response()->json([
            'status'  => false,
            'message' => 'Something went wrong. Please try again.',
        ], 500);
    }
}

public function showAdminResetForm($token, Request $request)
{
    $reset = DB::table('password_reset_tokens')
        ->where('email', $request->email)
        ->where('role', 'admin')
        ->first();

    // Check token exists
    if (!$reset) {
        return redirect()
            ->route('admin.forgotPage')
            ->with('error', 'Invalid reset link');
    }

    // Check token match
    if (!hash_equals($reset->token, $token)) {
        return redirect()
            ->route('admin.forgotPage')
            ->with('error', 'Invalid reset token');
    }

    // Check token expiry (60 minutes)
    if (Carbon::parse($reset->created_at)->addMinutes(60)->isPast()) {

        // Optional: delete expired token
        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return redirect()
            ->route('admin.forgotPage')
            ->with('error', 'Reset link expired');
    }

    return view('admin.admin-reset-password', [
        'token' => $token,
        'email' => $request->email
    ]);
}

 public function adminResetPassword(Request $request)
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
                        
    $user = Admin::where('email', $request->email)
           
            ->first();

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
    ]);
}

}
