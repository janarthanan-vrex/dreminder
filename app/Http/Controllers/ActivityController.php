<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reminder;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Activity;
use App\Models\Feedback;
use App\Models\UserNotificationSetting;

class ActivityController extends Controller
{
    public function userNotifications()
    {
        $user = Auth::user();

        $activities = Activity::with(['reminder.category', 'reminder.subcategory'])
            ->where('user_id', $user->id)
            ->where(function ($query) {
                $query->where('notify_for', '!=', 'admin')
                    ->orWhereNull('notify_for')
                    ->orWhere('notify_for', '');
            })
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

        $settings = UserNotificationSetting::firstOrCreate(
            ['user_id' => $user->id],
            [
                'email_notify'   => false,
                'push_notify'    => false,
                'before_30_days' => false,
                'before_7_days'  => false,
                'before_3_days'  => false,
                'before_1_day'   => false,
                'on_day'         => false,
            ]
        );

        return view('user.notification', compact('activities', 'unreadCount', 'settings'));
    }
    public function updateOrCreate(Request $request)
    {
        // Strip seconds from time inputs (DB stores H:i:s, browser re-sends them)
        if ($request->filled('start_time')) {
            $request->merge(['start_time' => substr($request->start_time, 0, 5)]);
        }
        if ($request->filled('end_time')) {
            $request->merge(['end_time' => substr($request->end_time, 0, 5)]);
        }

         $request->validate([
                'email_notify'   => 'nullable|boolean',
                'push_notify'    => 'nullable|boolean',
                'before_30_days' => 'nullable|boolean',
                'before_7_days'  => 'nullable|boolean',
                'before_3_days'  => 'nullable|boolean',
                'before_1_day'   => 'nullable|boolean',
                'on_day'         => 'nullable|boolean',
                'quit_hours'     => 'nullable|boolean',
            
                'start_time' => 'required_if:quit_hours,1|nullable|date_format:H:i',
                'end_time'   => 'required_if:quit_hours,1|nullable|date_format:H:i',
            ],[
                'start_time.required_if' => 'Start time is required.',
                'end_time.required_if'   => 'End time is required.',
            ]);

        $quietOn = (bool) ($request->quit_hours ?? false);

        $existingSetting = UserNotificationSetting::firstOrNew([
            'user_id' => Auth::id()
        ]);

        $setting = UserNotificationSetting::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'email_notify' => $request->has('email_notify')
                    ? $request->email_notify
                    : $existingSetting->email_notify,

                'push_notify' => $request->has('push_notify')
                    ? $request->push_notify
                    : $existingSetting->push_notify,

                'before_30_days' => $request->before_30_days ?? false,
                'before_7_days'  => $request->before_7_days ?? false,
                'before_3_days'  => $request->before_3_days ?? false,
                'before_1_day'   => $request->before_1_day ?? false,
                'on_day'         => $request->on_day ?? false,
                'quit_hours'     => $quietOn,
                'start_time'     => $quietOn && $request->start_time ? $request->start_time . ':00' : null,
                'end_time'       => $quietOn && $request->end_time ? $request->end_time . ':00' : null,
            ]
        );

        return response()->json([
            'status'  => true,
            'message' => 'Notification settings saved successfully',
            'data'    => $setting,
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

    public function userAnalytics(Request $request)
    {
        $user = Auth::user();
        $days = $request->days ?? 7;
        $query = Reminder::where('user_id', $user->id);
        if ($days != 'all') {
            $query->whereDate(
                'created_at',
                '>=',
                now()->subDays($days)
            );
        }
        $reminders = $query->get();
        $totalReminders = $reminders->count();
        $completedReminders = $reminders
            ->where('reminder_status', 'completed')
            ->count();
        $pendingReminders = $reminders
            ->where('reminder_status', 'pending')
            ->count();
        $totalCost = 0;
        foreach ($reminders as $reminder) {

            if (
                !$reminder->cost ||
                !$reminder->reminder_date ||
                !$reminder->end_reminder_date
            ) {
                continue;
            }
            $cost = (float) $reminder->cost;
            $start = \Carbon\Carbon::parse($reminder->reminder_date);
            $end = \Carbon\Carbon::parse($reminder->end_reminder_date);
            $months = $start->diffInMonths($end) + 1;
            switch ($reminder->payment_frequency) {
                case 'Monthly':
                    $totalCost += $cost * $months;
                    break;
                case 'Quarterly':
                    $totalCost += $cost * ceil($months / 3);
                    break;
                case 'Half-Yearly':
                    $totalCost += $cost * ceil($months / 6);
                    break;
                case 'Annually':
                    $totalCost += $cost * ceil($months / 12);
                    break;
                default:
                    $totalCost += $cost;
                    break;
            }
        }

        // Activity Chart
        $activityLabels = [];
        $createdData = [];
        $completedData = [];

        $loopDays = $days == 'all' ? 30 : $days;

        for ($i = $loopDays - 1; $i >= 0; $i--) {

            $date = now()->subDays($i);

            $activityLabels[] = $date->format('d M');

            $createdData[] = $reminders
                ->filter(fn($r) => $r->created_at->format('Y-m-d') == $date->format('Y-m-d'))
                ->count();

            $completedData[] = $reminders
                ->filter(
                    fn($r) =>
                    strtolower($r->reminder_status) == 'completed' &&
                        $r->updated_at->format('Y-m-d') == $date->format('Y-m-d')
                )
                ->count();
        }

        // Category Chart
        $categoryLabels = [];
        $categoryTotals = [];
$excludedCategories = ['Aeeeeeeeeeeeeeeei Poooooo'];
        $categories = $reminders
            ->groupBy('category_id');

        foreach ($categories as $group) {

            $categoryLabels[] = optional($group->first()->category)->name ?? 'Unknown';

            $categoryTotals[] = $group->count();
        }

        // Completion Chart
        $completionChart = [
            $completedReminders,
            $pendingReminders
        ];

        // Monthly Spending
    // Monthly Spending — spread cost across current year based on payment_frequency
$monthlySpending = array_fill(1, 12, 0.0);
$currentYear = now()->year;

$allReminders = Reminder::where('user_id', $user->id)
    ->whereNotNull('cost')
    ->whereNotNull('reminder_date')
    ->whereNotNull('end_reminder_date')
    ->whereNotNull('payment_frequency')
    ->get();

foreach ($allReminders as $r) {
    $cost      = (float) $r->cost;
    $frequency = strtolower($r->payment_frequency);
    $start     = \Carbon\Carbon::parse($r->reminder_date);
    $end       = \Carbon\Carbon::parse($r->end_reminder_date);

    $monthsMap = [
        'monthly'     => 1,
        'quarterly'   => 3,
        'half-yearly' => 6,
        'annually'    => 12,
    ];

    $interval = $monthsMap[$frequency] ?? null;

    if ($interval === null) {
        // One-time: only if reminder_date falls in current year
        if ($start->year === $currentYear) {
            $monthlySpending[$start->month] += $cost;
        }
        continue;
    }

    // Walk through payment months between start and end
    $current = $start->copy();
    while ($current->lte($end)) {
        if ($current->year === $currentYear) {
            $monthlySpending[$current->month] += $cost;
        }

        // Advance by interval (safe from day overflow)
        $firstOfMonth = \Carbon\Carbon::create($current->year, $current->month, 1)
            ->addMonths($interval);
        $originalDay = $start->day;
        $lastDay     = $firstOfMonth->daysInMonth;
        $current     = \Carbon\Carbon::create(
            $firstOfMonth->year,
            $firstOfMonth->month,
            min($originalDay, $lastDay)
        );
    }
}

// Convert to 0-indexed array for JSON (Jan=index 0)
$monthlySpending = array_values($monthlySpending);
        return view('user.analytics', compact(
            'totalReminders',
            'completedReminders',
            'pendingReminders',
            'totalCost',
            'activityLabels',
            'createdData',
            'completedData',
            'categoryLabels',
            'categoryTotals',
            'completionChart',
            'monthlySpending',
            'currentYear',
            'days'
        ));
    }
    
    public function userAnalyticsData(Request $request)
{
    $user = Auth::user();
    $days = $request->days ?? 7;
    $query = Reminder::where('user_id', $user->id);
    if ($days != 'all') {
        $query->whereDate('created_at', '>=', now()->subDays($days));
    }
    $reminders = $query->get();

    $totalReminders    = $reminders->count();
    $completedReminders = $reminders->where('reminder_status', 'completed')->count();
    $pendingReminders  = $reminders->where('reminder_status', 'pending')->count();

    // Total Cost
    $totalCost = 0;
    foreach ($reminders as $reminder) {
        if (!$reminder->cost || !$reminder->reminder_date || !$reminder->end_reminder_date) continue;
        $cost   = (float) $reminder->cost;
        $start  = \Carbon\Carbon::parse($reminder->reminder_date);
        $end    = \Carbon\Carbon::parse($reminder->end_reminder_date);
        $months = $start->diffInMonths($end) + 1;
        switch ($reminder->payment_frequency) {
            case 'Monthly':     $totalCost += $cost * $months; break;
            case 'Quarterly':   $totalCost += $cost * ceil($months / 3); break;
            case 'Half-Yearly': $totalCost += $cost * ceil($months / 6); break;
            case 'Annually':    $totalCost += $cost * ceil($months / 12); break;
            default:            $totalCost += $cost;
        }
    }

    // Activity Chart
    $activityLabels = []; $createdData = []; $completedData = [];
    $loopDays = $days == 'all' ? 30 : $days;
    for ($i = $loopDays - 1; $i >= 0; $i--) {
        $date = now()->subDays($i);
        $activityLabels[] = $date->format('d M');
        $createdData[]    = $reminders->filter(fn($r) => $r->created_at->format('Y-m-d') == $date->format('Y-m-d'))->count();
        $completedData[]  = $reminders->filter(fn($r) => strtolower($r->reminder_status) == 'completed' && $r->updated_at->format('Y-m-d') == $date->format('Y-m-d'))->count();
    }

    // Category Chart
    $categoryLabels = []; $categoryTotals = [];
    foreach ($reminders->groupBy('category_id') as $group) {
        $categoryLabels[] = optional($group->first()->category)->name ?? 'Unknown';
        $categoryTotals[] = $group->count();
    }

    // Monthly Spending
    $monthlySpending = array_fill(1, 12, 0.0);
    $currentYear = now()->year;
    $allReminders = Reminder::where('user_id', $user->id)
        ->whereNotNull('cost')->whereNotNull('reminder_date')
        ->whereNotNull('end_reminder_date')->whereNotNull('payment_frequency')->get();

    foreach ($allReminders as $r) {
        $cost = (float) $r->cost;
        $frequency = strtolower($r->payment_frequency);
        $start = \Carbon\Carbon::parse($r->reminder_date);
        $end   = \Carbon\Carbon::parse($r->end_reminder_date);
        $monthsMap = ['monthly' => 1, 'quarterly' => 3, 'half-yearly' => 6, 'annually' => 12];
        $interval  = $monthsMap[$frequency] ?? null;
        if ($interval === null) {
            if ($start->year === $currentYear) $monthlySpending[$start->month] += $cost;
            continue;
        }
        $current = $start->copy();
        while ($current->lte($end)) {
            if ($current->year === $currentYear) $monthlySpending[$current->month] += $cost;
            $firstOfMonth = \Carbon\Carbon::create($current->year, $current->month, 1)->addMonths($interval);
            $originalDay  = $start->day;
            $lastDay      = $firstOfMonth->daysInMonth;
            $current      = \Carbon\Carbon::create($firstOfMonth->year, $firstOfMonth->month, min($originalDay, $lastDay));
        }
    }

    return response()->json([
        'totalReminders'     => $totalReminders,
        'completedReminders' => $completedReminders,
        'pendingReminders'   => $pendingReminders,
        'totalCost'          => number_format($totalCost, 2),
        'activityLabels'     => $activityLabels,
        'createdData'        => $createdData,
        'completedData'      => $completedData,
        'categoryLabels'     => $categoryLabels,
        'categoryTotals'     => $categoryTotals,
        'completionChart'    => [$completedReminders, $pendingReminders],
        'monthlySpending'    => array_values($monthlySpending),
    ]);
}

   public function userFeedback(Request $request)
{
    $feedbacks = Feedback::where('user_id', auth()->id())
        ->latest()
        ->get();

    return view('user.feedback', compact('feedbacks'));
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

        Feedback::create([
           'user_id' => $user->id,
            'subject' => $request->subject,
            'message' => $request->message,
            'priority' => $request->priority,
            'is_receive' => $request->is_receive ?? 0,
            'admin_reply' => null,
        ]);

        Activity::create(
            [
                'user_id' => $user->id,
                'title'       => 'Feedback from ' . $user->first_name . ' ' . $user->last_name . ' - ' . $request->subject,
                'description' => $request->message,
                'notify_for' => 'admin',

            ]);

        return response()->json([
            'status' => true,
            'message' => 'Feedback submitted successfully',
        ]);
    }
}
