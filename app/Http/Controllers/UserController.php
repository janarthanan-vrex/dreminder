<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function userDashboard(Request $request){
        $user=Auth::user();
        return view('user.dashboard',compact('user'));
    }
}
