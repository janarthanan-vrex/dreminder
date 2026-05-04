<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function userDashboard(Request $request){
        $user=Auth::user();
        return view('user.dashboard',compact('user'));
    }
    public function userProfile(Request $request){
        $user = Auth::user()->load('plan');
        return view('user.profile',compact('user'));
    }

    public function updateProfile(Request $request)
{
    // dd($request->all());
    $user = Auth::user();

    $request->validate([
        'first_name' => 'required|string|max:50',
        'last_name'  => 'required|string|max:50',
        'email'      => 'required|email|unique:users,email,' . $user->id,
        'phone'      => 'required|string|max:20',
        'postcode'   => 'required|string|max:20',
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
}
