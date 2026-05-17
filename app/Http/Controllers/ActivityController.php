<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reminder;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Activity;
use App\Models\UserNotificationSetting;
class ActivityController extends Controller
{
    public function userNotifications()
    {
        
        $activities = Activity::with('reminder')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('user.notification', compact('activities'));
    }

    public function updateOrCreate(Request $request)
    {
        $request->validate([
            'email_notify'   => 'nullable|boolean',
            'push_notify'    => 'nullable|boolean',

            'before_30_days' => 'nullable|boolean',
            'before_7_days'  => 'nullable|boolean',
            'before_3_days'  => 'nullable|boolean',
            'before_1_day'   => 'nullable|boolean',
            'on_day'         => 'nullable|boolean',
        ]);

        $setting = UserNotificationSetting::updateOrCreate(

            [
                'user_id' => Auth::id()
            ],

            [
                'email_notify'   => $request->email_notify ?? false,
                'push_notify'    => $request->push_notify ?? false,

                'before_30_days' => $request->before_30_days ?? false,
                'before_7_days'  => $request->before_7_days ?? false,
                'before_3_days'  => $request->before_3_days ?? false,
                'before_1_day'   => $request->before_1_day ?? false,
                'on_day'         => $request->on_day ?? false,
            ]
        );

        return response()->json([
            'status' => true,
            'message' => 'Notification settings saved successfully',
            'data' => $setting
        ]);
    }
}
