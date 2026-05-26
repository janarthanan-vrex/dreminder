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
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function loginPage(Request $request)
    {
        return view('admin.admin-login');
    }
    public function adminProfile(Request $request){
         $admin = Auth::guard('admin')->user();
       
        return view('admin.profile',compact('admin'));
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

public function updateProfile(Request $request)
{
   
    $request->validate([
        'name'          => 'required|string|max:255',
        'phone' => 'nullable|digits_between:10,15',
        'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $admin = Auth::guard('admin')->user();

    $data = [
        'name'  => $request->name,
        'phone' => $request->phone,
    ];

    // Image Upload
    if ($request->hasFile('profile_image')) {

        // Delete old image
        if ($admin->profile_image &&
            File::exists(public_path('profile/' . $admin->profile_image))) {

            File::delete(public_path('profile/' . $admin->profile_image));
        }

        $image = $request->file('profile_image');

        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

        $image->move(public_path('profile'), $imageName);

        $data['profile_image'] = $imageName;
    }

    $admin->update($data);

   return response()->json([
    'status' => true,
    'message' => 'Profile updated successfully'
]);
}

public function changePassword(Request $request)
{
    $admin = Auth::guard('admin')->user();

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
    ],[
        'new_password.regex' => 'Password must contain uppercase, lowercase, number and special character',
        'confirm_password.same' => 'Confirm password does not match'
    ]);

    // Current Password Check
    if(!Hash::check($request->current_password,$admin->password)){

        return response()->json([
            'status' => false,
            'errors' => [
                'current_password' => ['Current password is incorrect']
            ]
        ],422);

    }

    // Same Password Check
    if(Hash::check($request->new_password,$admin->password)){

        return response()->json([
            'status' => false,
            'errors' => [
                'new_password' => ['New password must be different from current password']
            ]
        ],422);

    }

    // Update Password
    $admin->update([
        'password' => Hash::make($request->new_password)
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Password updated successfully'
    ]);
}

}
