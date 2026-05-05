<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function userDashboard(Request $request)
    {
        $user = Auth::user();
        return view('user.dashboard', compact('user'));
    }
    public function userProfile(Request $request)
    {
        $user = Auth::user()->load('plan');
        return view('user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name'  => 'required|string|max:50',
            'email'      => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|digits_between:10,15',
            'postcode' => [
                'required',
                'regex:/^(GIR 0AA|[A-Z]{1,2}\d{1,2}[A-Z]?\s?\d[A-Z]{2})$/i'
            ],
            'profile'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // ========================
        // IMAGE UPLOAD (public/profile)
        // ========================
        if ($request->hasFile('profile')) {

            // delete old image
            if ($user->profile && File::exists(public_path($user->profile))) {
                File::delete(public_path($user->profile));
            }

            $file = $request->file('profile');

            $filename = time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();

            $destinationPath = public_path('profile');

            $file->move($destinationPath, $filename);

            // store in DB like profile/xxxx.png
            $user->profile = 'profile/' . $filename;
        }

        // ========================
        // UPDATE USER DATA
        // ========================
        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->email      = $request->email;
        $user->phone      = $request->phone;
        $user->postcode   = $request->postcode;

        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully',
            'user' => $user,
            'image_url' => $user->profile
                ? asset($user->profile)
                : null
        ]);
    }


    public function changePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => [
                'required',
                'min:8',
                'regex:/[A-Z]/',        // at least 1 uppercase
                'regex:/[a-z]/',        // at least 1 lowercase
                'regex:/[0-9]/',        // at least 1 number
                'regex:/[@$!%*#?&]/'    // at least 1 special character
            ],
            'confirm_password' => 'required|same:new_password'
        ], [
            'new_password.regex' => 'Password must contain at least 1 uppercase, 1 lowercase, 1 number, and 1 special character',
            'confirm_password.same' => 'Confirm password does not match'
        ]);

        // 🔴 Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => false,
                'errors' => [
                    'current_password' => ['Current password is incorrect']
                ]
            ], 422);
        }

        // 🔴 Prevent same password
        if (Hash::check($request->new_password, $user->password)) {
            return response()->json([
                'status' => false,
                'errors' => [
                    'new_password' => ['New password must be different from current password']
                ]
            ], 422);
        }

        // ✅ Update password
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Password updated successfully'
        ]);
    }
}
