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
        
        $user = Auth::user();

    $activities = Activity::with(['reminder.category', 'reminder.subcategory'])
        ->where('user_id', $user->id)
        ->latest()
        ->get()
        ->map(function ($activity) {
            $reminder  = $activity->reminder;
            $category  = $reminder?->category;

            return [
                'id'          => $activity->id,
                'description' => $activity->description,
                'is_seen'     => $activity->is_seen,
                'is_auto'     => $activity->is_auto_generate,
                'created_at'  => $activity->created_at->diffForHumans(),
                'raw_date'    => $activity->created_at->format('d M Y'),
                'reminder'    => $reminder ? [
                    'id'    => $reminder->id,
                    'title' => $reminder->title,
                ] : null,
                'category' => $category ? [
                    'name'  => $category->name,
                    'icon'  => $category->icon,
                    'color' => $category->color,
                ] : null,
            ];
        });

    $unreadCount = $activities->where('is_seen', 0)->count();

    return view('user.notification', compact('activities', 'unreadCount'));
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

    public function markNotificationRead($id)
{
    Activity::where('id', $id)->where('user_id', Auth::id())->update(['is_seen' => 1]);
    return response()->json(['status' => true, 'message' => 'Marked as read']);
}

public function deleteNotification($id)
{
    Activity::where('id', $id)->where('user_id', Auth::id())->delete();
    return response()->json(['status' => true, 'message' => 'Notification deleted']);
}

public function markAllRead()
{
    Activity::where('user_id', Auth::id())->update(['is_seen' => 1]);
    return response()->json(['status' => true, 'message' => 'All marked as read']);
}

public function clearAllNotifications()
{
    Activity::where('user_id', Auth::id())->delete();
    return response()->json(['status' => true, 'message' => 'All notifications cleared']);
}
}
