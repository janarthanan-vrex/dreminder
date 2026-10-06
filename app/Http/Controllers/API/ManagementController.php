<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reminder;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ReminderHistory;
use App\Models\Activity;
use Carbon\Carbon;
use App\Models\UserNotificationSetting;
use Illuminate\Validation\Rule;

class ManagementController extends Controller
{
    public function userReminders(Request $request)
    {
        $user = Auth::user();

        $reminders = Reminder::with(['category', 'subcategory'])
            ->where('user_id', $user->id)
            ->latest()
            ->get()
            ->map(function ($reminder) {
                return [
                    'id' => $reminder->id,
                    'title' => $reminder->title,
                    'category' => $reminder->category?->name,
                    'color' => $reminder->category?->color,
                    'icon' => $reminder->category?->icon,
                    'subcategory' => $reminder->subcategory?->name,
                    'reminder_date' => $reminder->reminder_date,
                    'reminder_time' => $reminder->reminder_time,
                    'status' => $reminder->status,
                    'reminder_status' => $reminder->reminder_status,
                    'provider' => $reminder->provider,
                    'cost' => $reminder->cost,
                    'description' => $reminder->description,
                    'payment_frequency' => $reminder->payment_frequency,
                ];
            });

        // Categories with subcategories
        $categories = Category::with('subcategories')
            ->where('status', 'Active')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Reminders fetched successfully',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->first_name . ' ' . $user->last_name,
                    'email' => $user->email,
                ],
                'reminders' => $reminders,
                'categories' => $categories
            ]
        ], 200);
    }

    public function deleteReminder($id)
    {
        $user = Auth::user();

        $reminder = Reminder::with(['category', 'subcategory'])
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$reminder) {
            return response()->json([
                'status' => false,
                'message' => 'Reminder not found'
            ], 404);
        }

        $categoryName = optional($reminder->category)->name;
        $subcategoryName = optional($reminder->subcategory)->name;

        Activity::create([
            'user_id' => $user->id,
            'reminder_id' => $reminder->id,
            'description' => '"' . $reminder->title .
                '" Reminder deleted for category "' .
                $categoryName .
                '" and subcategory "' .
                $subcategoryName . '"',
            'is_auto_generate' => 0,
        ]);

        ReminderHistory::where('reminder_id', $reminder->id)->delete();

        $reminder->delete();

        return response()->json([
            'status' => true,
            'message' => 'Reminder deleted successfully'
        ], 200);
    }

    public function updateReminder(Request $request, $id)
    {
        $request->validate([
            'title'             => 'required|string|min:3|max:100',
            'category_id'       => 'required|integer|exists:categories,id',
            'subcategory_name'  => 'required|string|max:100',
            'end_reminder_date' => 'required|date',
            'reminder_time'     => 'required',
            'description'       => 'nullable|string|max:200',
            'provider'          => 'nullable|string|max:100',
            'cost'              => 'nullable|numeric|min:0',
            'payment_frequency' => 'nullable|string|max:50',
        ]);

        $selectedDateTime = Carbon::parse(
            $request->end_reminder_date . ' ' . $request->reminder_time
        );

        if (
            Carbon::parse($request->end_reminder_date)->isToday()
            && $selectedDateTime->lt(now())
        ) {
            return response()->json([
                'status' => false,
                'errors' => [
                    'reminder_time' => ['Selected reminder time has already passed.']
                ]
            ], 422);
        }

        $reminder = Reminder::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $category = Category::find($request->category_id);

        // ✅ Special category check — force provider, cost, payment_frequency to null
        $isSpecialCategory = in_array(strtolower($category->name), ['special day', 'others']);

        $provider         = $isSpecialCategory ? null : $request->provider;
        $cost             = $isSpecialCategory ? null : $request->cost;
        $paymentFrequency = $isSpecialCategory ? null : $request->payment_frequency;

        $subcategory = SubCategory::where('category_id', $request->category_id)
            ->whereRaw('LOWER(name) = ?', [strtolower($request->subcategory_name)])
            ->where('role', 'user')
            ->where('created_by', Auth::id())
            ->first();

        if (!$subcategory) {
            $subcategory = SubCategory::create([
                'category_id' => $request->category_id,
                'name'        => ucfirst($request->subcategory_name),
                'description' => null,
                'role'        => 'user',
                'created_by'  => Auth::id(),
                'status'      => 'Active',
            ]);
        }

        $endDate     = Carbon::parse($request->end_reminder_date);
        $today       = Carbon::today();
        $originalDay = $endDate->day;

        // ======================================================
        // RECALCULATE reminder_date IF end_reminder_date CHANGED
        // ======================================================

        $oldReminderDate = Carbon::parse($reminder->reminder_date);

        if ($oldReminderDate->day !== $originalDay) {
            $firstOfCurrentMonth = Carbon::create($today->year, $today->month, 1);
            $lastDay             = $firstOfCurrentMonth->daysInMonth;
            $newReminderDate     = Carbon::create($today->year, $today->month, min($originalDay, $lastDay));

            if ($newReminderDate->lt($today)) {
                $firstOfNextMonth = Carbon::create($today->year, $today->month, 1)->addMonth();
                $lastDay          = $firstOfNextMonth->daysInMonth;
                $newReminderDate  = Carbon::create($firstOfNextMonth->year, $firstOfNextMonth->month, min($originalDay, $lastDay));
            }
        } else {
            $newReminderDate = $oldReminderDate->copy();
        }

        $reminder->update([
            'category_id'       => $request->category_id,
            'subcategory_id'    => $subcategory?->id,
            'title'             => $request->title,
            'reminder_date'     => $newReminderDate->toDateString(),
            'end_reminder_date' => $endDate->toDateString(),
            'reminder_time'     => $request->reminder_time,
            'description'       => $request->description,
            'provider'          => $provider,           // ✅ null if Special Day / Others
            'cost'              => $cost,               // ✅ null if Special Day / Others
            'payment_frequency' => $paymentFrequency,   // ✅ null if Special Day / Others
            'status'            => 'Active',
        ]);

        // ======================================================
        // DELETE FUTURE PENDING HISTORIES
        // ======================================================

        if ($isSpecialCategory) {
            // ✅ Special Day / Others — keep only the FIRST (oldest) history entry,
            // delete everything else (all other pending entries)
            $firstHistory = ReminderHistory::where('reminder_id', $reminder->id)
                ->orderBy('reminder_date', 'asc')
                ->first();

            ReminderHistory::where('reminder_id', $reminder->id)
                ->when($firstHistory, fn($q) => $q->where('id', '!=', $firstHistory->id))
                ->delete();

            // Update the single kept entry with new reminder_time
            if ($firstHistory) {
                $firstHistory->update([
                    'reminder_date' => $newReminderDate->toDateString(),
                    'reminder_time' => $request->reminder_time,
                    'status'        => 'pending',
                ]);
            } else {
                // No history at all — create the single entry
                ReminderHistory::create([
                    'user_id'       => Auth::id(),
                    'reminder_id'   => $reminder->id,
                    'reminder_date' => $newReminderDate->toDateString(),
                    'reminder_time' => $request->reminder_time,
                    'status'        => 'pending',
                ]);
            }
        } else {
            // ======================================================
            // NORMAL CATEGORY — delete future pending and regenerate
            // ======================================================

            ReminderHistory::where('reminder_id', $reminder->id)
                ->where('status', 'pending')
                ->whereDate('reminder_date', '>=', $today->toDateString())
                ->delete();

            $frequency = strtolower($paymentFrequency ?? '');

            $monthsMap = [
                'monthly'     => 1,
                'quarterly'   => 3,
                'half-yearly' => 6,
                'annually'    => 12,
            ];

            $months  = $monthsMap[$frequency] ?? 0;
            $current = $newReminderDate->copy();

            while ($current->lte($endDate)) {

                // Skip sent/completed records — keep as is
                $exists = ReminderHistory::where('reminder_id', $reminder->id)
                    ->whereDate('reminder_date', $current->toDateString())
                    ->exists();

                if (!$exists) {
                    ReminderHistory::create([
                        'user_id'       => Auth::id(),
                        'reminder_id'   => $reminder->id,
                        'reminder_date' => $current->toDateString(),
                        'reminder_time' => $request->reminder_time,
                        'status'        => 'pending',
                    ]);
                }

                if ($months === 0) {
                    break;
                }

                // Add months from 1st — prevents day overflow (May 31 + 1month = Jul 1 bug)
                $firstOfCurrentMonth = Carbon::create($current->year, $current->month, 1);
                $nextMonth           = $firstOfCurrentMonth->addMonths($months);
                $lastDay             = $nextMonth->daysInMonth;
                $current             = Carbon::create($nextMonth->year, $nextMonth->month, min($originalDay, $lastDay));
            }
        }

        Activity::create([
            'user_id'          => Auth::id(),
            'reminder_id'      => $reminder->id,
            'description'      => 'Reminder updated for category "' .
                $category?->name . '" and subcategory "' . $subcategory?->name . '"',
            'is_auto_generate' => 0,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Reminder updated successfully',
        ], 200);
    }

    public function storeReminder(Request $request)
    {
        $category = Category::find($request->category_id);

        $isSpecialCategory = $category &&
            in_array(strtolower($category->name), ['special day', 'others']);

        $request->validate(
            [
                'title'             => 'required|string|min:3|max:100',
                'category_id'       => 'required|integer|exists:categories,id',
                'subcategory_name'  => 'required|string|max:100',
                'end_reminder_date' => 'required|date|after_or_equal:today',
                'reminder_time'     => 'required',
                'description'       => 'nullable|string|max:200',
                'provider'          => 'nullable|string|max:100',
                'cost'              => 'nullable|numeric|min:0',
                'payment_frequency' => [
                    Rule::requiredIf(!$isSpecialCategory),
                    'nullable',
                    'string',
                    'max:50'
                ],
            ],
            [
                'category_id.required'             => 'Category name is required.',
                'category_id.exists'               => 'Selected category is invalid.',
                'subcategory_name.required'        => 'Subcategory name is required.',
                'end_reminder_date.required'       => 'End reminder date is required.',
                'end_reminder_date.after_or_equal' => 'End reminder date cannot be in the past.',
                'reminder_time.required'           => 'Reminder time is required.',
            ]
        );

        // =====================================================
        // CHECK PAST TIME FOR TODAY
        // =====================================================

        $selectedDateTime = Carbon::parse(
            $request->end_reminder_date . ' ' . $request->reminder_time
        );

        if (
            Carbon::parse($request->end_reminder_date)->isToday()
            && $selectedDateTime->lt(now())
        ) {

            return response()->json([
                'status' => false,
                'errors' => [
                    'reminder_time' => [
                        'Selected reminder time has already passed.'
                    ]
                ]
            ], 422);
        }



        $provider         = $isSpecialCategory ? null : $request->provider;
        $cost             = $isSpecialCategory ? null : $request->cost;
        $paymentFrequency = $isSpecialCategory ? null : $request->payment_frequency;

        $subcategory = SubCategory::where('category_id', $request->category_id)
            ->whereRaw('LOWER(name) = ?', [strtolower($request->subcategory_name)])
            ->where('role', 'user')                    // ✅ only user-created
            ->where('created_by', Auth::id())          // ✅ only this user's own
            ->first();

        if (!$subcategory) {
            $subcategory = SubCategory::create([
                'category_id' => $request->category_id,
                'name'        => ucfirst($request->subcategory_name),
                'description' => null,
                'role'        => 'user',
                'created_by'  => Auth::id(),
                'status'      => 'Active',
            ]);
        }

        $endDate     = Carbon::parse($request->end_reminder_date);

        if ($isSpecialCategory) {
            // ✅ For Special Day / Others: reminder_date is simply the end_reminder_date.
            // No day-of-month / current-month capping logic needed here.
            $originalDay  = $endDate->day;
            $reminderDate = $endDate->copy();
        } 
        
        else {
            $today       = Carbon::today();
            $now         = now();
            $originalDay = $endDate->day;
            $frequency   = strtolower($request->payment_frequency ?? '');

            $monthsMap = [
                'monthly'     => 1,
                'quarterly'   => 3,
                'half-yearly' => 6,
                'annually'    => 12,
            ];
            $months = $monthsMap[$frequency] ?? 0;

            if ($months === 0) {
                // One-time reminder — just use end_reminder_date itself
                $reminderDate = $endDate->copy();
            } else {

                // Simplest safe base: use end date's month/day but go back enough years
                $baseYear = $today->year - 10; // safe enough starting point
                $lastDay  = Carbon::create($baseYear, $endDate->month, 1)->daysInMonth;
                $current  = Carbon::create($baseYear, $endDate->month, min($originalDay, $lastDay));

                // Walk forward by $months intervals until we pass today
                while (true) {
                    $currentDateTime = Carbon::parse($current->toDateString() . ' ' . $request->reminder_time);

                    $isPast = $current->lt($today)
                        || ($current->isToday() && $currentDateTime->lte($now));

                    if (!$isPast) {
                        break; // this is our first valid reminder_date
                    }

                    // Jump forward by frequency interval
                    $firstOfMonth = Carbon::create($current->year, $current->month, 1)->addMonths($months);
                    $lastDay      = $firstOfMonth->daysInMonth;
                    $current      = Carbon::create($firstOfMonth->year, $firstOfMonth->month, min($originalDay, $lastDay));
                }

                $reminderDate = $current;

                // Safety cap
                if ($reminderDate->gt($endDate)) {
                    $reminderDate = $endDate->copy();
                }
            }
        }
        $reminder = Reminder::create([
            'user_id'           => Auth::id(),
            'category_id'       => $request->category_id,
            'subcategory_id'    => $subcategory->id,
            'title'             => ucfirst($request->title),
            'reminder_date'     => $reminderDate->toDateString(),
            'end_reminder_date' => $endDate->toDateString(),
            'reminder_time'     => $request->reminder_time,
            'description'       => $request->description,
            'provider'          => $provider,
            'cost'              => $cost,
            'payment_frequency' => $paymentFrequency,
            'status'            => 'Active',
        ]);

        $frequency = strtolower($paymentFrequency ?? '');

        $monthsMap = [
            'monthly'     => 1,
            'quarterly'   => 3,
            'half-yearly' => 6,
            'annually'    => 12,
        ];

        $months  = $monthsMap[$frequency] ?? 0;
        $current = Carbon::parse($reminder->reminder_date);

        while ($current->lte($endDate)) {

            ReminderHistory::create([
                'user_id'       => Auth::id(),
                'reminder_id'   => $reminder->id,
                'reminder_date' => $current->toDateString(),
                'reminder_time' => $reminder->reminder_time,
                'status'        => 'pending',
            ]);

            if ($months === 0) {
                break;
            }

            // Add months from the 1st â€” prevents day overflow (May 31 + 1month = Jul 1 bug)
            $firstOfCurrentMonth = Carbon::create($current->year, $current->month, 1);
            $nextMonth           = $firstOfCurrentMonth->addMonths($months);
            $lastDay             = $nextMonth->daysInMonth;
            $current             = Carbon::create($nextMonth->year, $nextMonth->month, min($originalDay, $lastDay));
        }

        Activity::create([
            'user_id'          => Auth::id(),
            'reminder_id'      => $reminder->id,
            'description'      => 'Reminder created for category "' .
                $category->name . '" and subcategory "' . $subcategory->name . '"',
            'is_auto_generate' => 0,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Reminder created successfully',
            'data' => [
                'id' => $reminder->id,
                'title' => $reminder->title,
                'reminder_date' => $reminder->reminder_date,
                'end_reminder_date' => $reminder->end_reminder_date,
                'reminder_time' => $reminder->reminder_time,
            ]
        ], 201);
    }

    public function calendarView(Request $request)
    {
        $userId = auth()->id();

        // Full Categories
        $fullCats = Category::where('status', 'active')
            ->with([
                'subcategories' => function ($q) {
                    $q->where('status', 'active');
                }
            ])
            ->get()
            ->mapWithKeys(function ($cat) {
                return [
                    $cat->id => [
                        'name'  => $cat->name,
                        'color' => $cat->color ?? '#94a3b8',
                        'icon'  => $cat->icon ?? 'ri-alarm-line',
                        'bg'    => 'rgba(148,163,184,.15)',
                        'subs'  => $cat->subcategories->map(function ($sub) {
                            return [
                                'id'          => $sub->id,
                                'name'        => $sub->name,
                                'role'        => $sub->role,
                                'description' => $sub->description,
                                'created_by'  => $sub->created_by,
                            ];
                        })->values()
                    ]
                ];
            });

        $categories = $fullCats->map(function ($c) {
            return collect($c)->except('subs');
        });

        $histories = ReminderHistory::with([
            'reminder.category',
            'reminder.subcategory'
        ])
            ->where('user_id', $userId)
            ->get()
            ->map(function ($h) {

                $reminder = $h->reminder;

                if (!$reminder) {
                    return null;
                }

                return [
                    'id' => $h->id,
                    'reminder_id' => $h->reminder_id,
                    'title' => $reminder->title,
                    'category' => $reminder->category_id,
                    'subcategory' => $reminder->subcategory?->name ?? '',
                    'dueDate' => $h->reminder_date
                        ? Carbon::parse($h->reminder_date)->format('Y-m-d')
                        : null,
                    'dueTime' => $h->reminder_time,
                    'provider' => $reminder->provider,
                    'cost' => $reminder->cost,
                    'frequency' => $reminder->payment_frequency,
                    'status' => $h->status,
                    'reminder_status' => $reminder->reminder_status,
                    'description' => $reminder->description,
                    'end_reminder_date' => $reminder->end_reminder_date,
                ];
            })
            ->filter()
            ->values();

        return response()->json([
            'status' => true,
            'message' => 'Calendar data fetched successfully',
            'data' => [
                'categories' => $categories,
                'full_categories' => $fullCats,
                'histories' => $histories
            ]
        ], 200);
    }

    public function storeSubCategory(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|min:3|max:50',
            'description' => 'nullable|string|max:100',
        ]);

        $exists = SubCategory::where('category_id', $request->category_id)
            ->whereRaw('LOWER(name) = ?', [strtolower($request->name)])
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => false,
                'errors' => [
                    'name' => ['Subcategory already exists']
                ]
            ], 422);
        }

        $subcategory = SubCategory::create([
            'category_id' => $request->category_id,
            'name' => ucfirst($request->name),
            'role' => 'user',
            'created_by' => $user->id,
            'status' => 'Active',
            'description' => $request->description,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Subcategory added successfully',
            'data' => [
                'id' => $subcategory->id,
                'category_id' => $subcategory->category_id,
                'name' => $subcategory->name,
                'description' => $subcategory->description
            ]
        ], 201);
    }

    public function updateSubcategory(Request $request, $id)
    {
        $user = Auth::user();
        $subcategory = SubCategory::where('id', $id)
            ->where('created_by', $user->id)
            ->where('role', 'user')
            ->first();

        if (!$subcategory) {
            return response()->json([
                'status' => false,
                'message' => 'Subcategory not found'
            ], 404);
        }

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|min:2|max:50',
            'description' => 'nullable|string|max:100',
        ]);

        // Check duplicate except current record
        $exists = SubCategory::where('category_id', $request->category_id)
            ->whereRaw('LOWER(name) = ?', [strtolower($request->name)])
            ->where('id', '!=', $subcategory->id)
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => false,
                'errors' => [
                    'name' => ['Subcategory already exists']
                ]
            ], 422);
        }

        $subcategory->update([
            'category_id' => $request->category_id,
            'name' => ucfirst($request->name),
            'description' => $request->description,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Subcategory updated successfully',
            'data' => [
                'id' => $subcategory->id,
                'category_id' => $subcategory->category_id,
                'name' => $subcategory->name,
                'description' => $subcategory->description
            ]
        ], 200);
    }

    public function deleteSubcategory($id)
    {
        $user = Auth::user();

        $subcategory = SubCategory::where('id', $id)
            ->where('created_by', $user->id)
            ->where('role', 'user')
            ->first();

        if (!$subcategory) {
            return response()->json([
                'status' => false,
                'message' => 'Subcategory not found'
            ], 404);
        }

        $subcategory->delete();

        return response()->json([
            'status' => true,
            'message' => 'Subcategory deleted successfully'
        ], 200);
    }
    public function userCategory(Request $request)
    {
    $user = Auth::user();

    $categories = Category::with([
        'subcategories' => function ($query) use ($user) {
            $query->where('status', 'Active')
                ->where(function ($q) use ($user) {
                    $q->where('role', 'admin')
                        ->orWhere(function ($subQ) use ($user) {
                            $subQ->where('role', 'user')
                                ->where('created_by', $user->id);
                        });
                })
                ->latest();
        }
    ])
    ->where('status', 'Active')
    ->get();

    $reminders = Reminder::with([
        'category',
        'subcategory'
    ])
    ->where('user_id', $user->id)
    ->latest()
    ->get()
    ->map(function ($r) {
        return [
            'id' => $r->id,
            'title' => $r->title,
            'category_id' => $r->category?->id,
            'category_name' => $r->category?->name,
            'subcategory' => optional($r->subcategory)->name,
            'dueDate' => $r->reminder_date,
            'dueTime' => $r->reminder_time,
            'description' => $r->description,
            'provider' => $r->provider,
            'cost' => $r->cost,
            'frequency' => $r->payment_frequency,
            'status' => $r->reminder_status,
            'createdAt' => $r->created_at,
        ];
    });

    $totalCategories = $categories->count();

    $customSubCount = SubCategory::where('role', 'user')
        ->where('created_by', $user->id)
        ->count();

    $mostUsedCategory = Reminder::select('category_id')
        ->where('user_id', $user->id)
        ->groupBy('category_id')
        ->orderByRaw('COUNT(*) DESC')
        ->first();

    $mostUsedCategoryName = '—';

    if ($mostUsedCategory) {
        $cat = Category::find($mostUsedCategory->category_id);
        $mostUsedCategoryName = $cat?->name ?? '—';
    }

    return response()->json([
        'status' => true,
        'message' => 'Categories fetched successfully',
        'data' => [
            'categories' => $categories,
            'reminders' => $reminders,
            'statistics' => [
                'total_categories' => $totalCategories,
                'custom_subcategories' => $customSubCount,
                'most_used_category' => $mostUsedCategoryName
            ]
        ]
    ], 200);
}
     public function updateOrCreate(Request $request)
    {
        if ($request->filled('start_time')) {
            $request->merge([
                'start_time' => substr($request->start_time, 0, 5)
            ]);
        }

        if ($request->filled('end_time')) {
            $request->merge([
                'end_time' => substr($request->end_time, 0, 5)
            ]);
        }

        $request->validate([
            'email_notify'   => 'nullable|boolean',
            'push_notify'    => 'nullable|boolean',
            'quit_hours'     => 'nullable|boolean',

            'start_time' => 'required_if:quit_hours,1|nullable|date_format:H:i',
            'end_time'   => 'required_if:quit_hours,1|nullable|date_format:H:i',
        ], [
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
                'quit_hours'     => $quietOn,
                'start_time'     => $quietOn && $request->start_time ? $request->start_time . ':00' : null,
                'end_time'       => $quietOn && $request->end_time ? $request->end_time . ':00' : null,
            ]
        );

        return response()->json([
            'status'  => true,
            'message' => 'Notification settings saved successfully.',
            'data'    => $setting,
        ], 200);
    }
    
    public function markNotificationRead($id)
    {
        $activity = Activity::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$activity) {
            return response()->json([
                'status' => false,
                'message' => 'Notification not found.'
            ], 404);
        }

        $activity->update([
            'is_seen' => 1
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Notification marked as read.',
            'data' => $activity
        ], 200);
    }
    public function markAllRead()
    {
        $updated = Activity::where('user_id',Auth::id())
            ->where('is_seen', 0)
            ->update(['is_seen' => 1]);   
            return response()->json([
                'status' => true,
                'message' => 'All notifications marked as read.',
                'updated_count' => $updated
            ],200);              
    }
    public function clearAllNotifications()
    {
        Activity::where('user_id', Auth::id())->delete();
        return response()->json(['status' => true, 'message' => 'All notifications cleared']);
    }
    
    public function deleteNotification($id)
{
    $notification = Activity::where('id', $id)
        ->where('user_id', Auth::id())
        ->first();

    if (!$notification) {
        return response()->json([
            'status' => false,
            'message' => 'Notification not found.'
        ], 404);
    }

    $notification->delete();

    return response()->json([
        'status' => true,
        'message' => 'Notification deleted successfully.'
    ]);
}
}
