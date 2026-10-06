<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Reminder;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Activity;
use App\Models\ReminderHistory;
use Illuminate\Validation\Rule;


class ReminderController extends Controller
{

    public function userReminders(Request $request)
    {
        $user = Auth::user();

        // reminders with relations
        $reminders = Reminder::with([
            'category',
            'subcategory'
        ])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        // categories with subcategories
        $categories = Category::with('subcategories')
            ->where('status', 'Active')
            ->get();

        return view('user.reminders', compact(
            'user',
            'reminders',
            'categories'
        ));
    }

<<<<<<< HEAD


    public function store(Request $request)
    {
            $category = Category::find($request->category_id);
=======
   

    public function store(Request $request)
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
>>>>>>> 14b4245 (full updated code)

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

<<<<<<< HEAD
            // =====================================================
            // CHECK PAST TIME FOR TODAY
            // =====================================================

            $selectedDateTime = Carbon::parse(
                $request->end_reminder_date . ' ' . $request->reminder_time
            );
=======
       
>>>>>>> 14b4245 (full updated code)

            if (
                Carbon::parse($request->end_reminder_date)->isToday()
                && $selectedDateTime->lt(now())
            ) {

<<<<<<< HEAD
                return response()->json([
                    'status' => false,
                    'errors' => [
                        'reminder_time' => [
                            'Selected reminder time has already passed.'
                        ]
                    ]
                ], 422);
            }

=======
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
>>>>>>> 14b4245 (full updated code)


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

            // âœ… KEY FIX: Carbon::today() = midnight 00:00:00
            // now() has current time (e.g. 12:31:32), so Carbon::create(..., 21) at 00:00:00
            // would be "less than" now() on the same day â€” wrongly jumping to next month.
            $today       = Carbon::today();
            $originalDay = $endDate->day;

            // Build safe reminderDate capped to current month's actual days
            $firstOfCurrentMonth = Carbon::create($today->year, $today->month, 1);
            $lastDay             = $firstOfCurrentMonth->daysInMonth;
            $reminderDate        = Carbon::create($today->year, $today->month, min($originalDay, $lastDay));

            // Both are now midnight â€” date-only comparison, no time mismatch
            if ($reminderDate->lt($today)) {
                $firstOfNextMonth = Carbon::create($today->year, $today->month, 1)->addMonth();
                $lastDay          = $firstOfNextMonth->daysInMonth;
                $reminderDate     = Carbon::create($firstOfNextMonth->year, $firstOfNextMonth->month, min($originalDay, $lastDay));
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
                'status'  => true,
                'message' => 'Reminder created successfully',
            ]);
    }


    public function deleteReminder($id)
    {
        $user = Auth::user();

        $reminder = Reminder::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$reminder) {
            return response()->json([
                'status' => false,
                'message' => 'Reminder not found'
            ], 404);
        }

        // Store names before delete
        $categoryName = optional($reminder->category)->name;
        $subcategoryName = optional($reminder->subcategory)->name;

        // ðŸ”¥ STORE ACTIVITY
        Activity::create([
            'user_id' => $user->id,
            'reminder_id' => $reminder->id,
            'description' => '"' . $reminder->title . '" Reminder deleted for category "' .
                $categoryName . '" and subcategory "' .
                $subcategoryName . '"',
            'is_auto_generate' => 0,
        ]);

        // Delete reminder
        ReminderHistory::where('reminder_id', $reminder->id)->delete();
        $reminder->delete();

        return response()->json([
            'status' => true,
            'message' => 'Reminder deleted successfully'
        ]);
    }

<<<<<<< HEAD
   
=======

>>>>>>> 14b4245 (full updated code)

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'             => 'required|string|min:3|max:100',
            'category_id'       => 'required|integer|exists:categories,id',
            'subcategory_name'  => 'required|string|max:100',
<<<<<<< HEAD
            'end_reminder_date' => 'required|date',
=======
            'end_reminder_date' => 'required|date|after_or_equal:today',
>>>>>>> 14b4245 (full updated code)
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
<<<<<<< HEAD
            ->where('name', $request->subcategory_name)
            ->first();

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
=======
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
            'reminder_date'     => $isSpecialCategory ? $endDate->toDateString() : $newReminderDate->toDateString(),
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
                    'reminder_date' => $endDate->toDateString(),
>>>>>>> 14b4245 (full updated code)
                    'reminder_time' => $request->reminder_time,
                    'status'        => 'pending',
                ]);
            } else {
                // No history at all — create the single entry
                ReminderHistory::create([
                    'user_id'       => Auth::id(),
                    'reminder_id'   => $reminder->id,
<<<<<<< HEAD
                    'reminder_date' => $newReminderDate->toDateString(),
=======
                    'reminder_date' => $endDate->toDateString(),
>>>>>>> 14b4245 (full updated code)
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
            'status'  => true,
            'message' => 'Reminder updated successfully',
        ]);
    }
<<<<<<< HEAD
=======



>>>>>>> 14b4245 (full updated code)
}
