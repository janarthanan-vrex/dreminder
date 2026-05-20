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

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'title' => 'required|string|min:3|max:100',
    //         'category_id' => 'required|integer|exists:categories,id',
    //         'subcategory_name' => 'required|string|max:100',
    //         'reminder_date' => 'required|date|after_or_equal:today',
    //         'reminder_time' => 'required',
    //         'description' => 'nullable|string|max:200',
    //         'provider' => 'nullable|string|max:100',
    //         'cost' => 'nullable|numeric|min:0',
    //         'payment_frequency' => 'nullable|string|max:50',
    //     ]);

    //     // 🔥 FIND CATEGORY
    //     $category = Category::find($request->category_id);

    //     // 🔥 CHECK EXISTING SUBCATEGORY
    //     $subcategory = SubCategory::where(
    //         'category_id',
    //         $request->category_id
    //     )
    //         ->whereRaw(
    //             'LOWER(name) = ?',
    //             [strtolower($request->subcategory_name)]
    //         )
    //         ->first();

    //     // 🔥 IF NOT EXISTS → CREATE CUSTOM SUBCATEGORY
    //     if (!$subcategory) {
    //         $subcategory = SubCategory::create([
    //             'category_id' => $request->category_id,
    //             'name' => ucfirst($request->subcategory_name),
    //             'description' => null,
    //             'role' => 'user',
    //             'created_by' => Auth::id(),
    //             'status' => 'Active',
    //         ]);
    //     }

    //     // 🔥 STORE REMINDER
    //     $reminder = Reminder::create([
    //         'user_id' => Auth::id(),
    //         'category_id' => $request->category_id,
    //         'subcategory_id' => $subcategory->id,
    //         'title' => ucfirst($request->title),
    //         'end_reminder_date' => $request->reminder_date,
    //         'reminder_date' => $request->reminder_date,
    //         'reminder_time' => $request->reminder_time,
    //         'description' => $request->description,
    //         'provider' => $request->provider,
    //         'cost' => $request->cost,
    //         'payment_frequency' => $request->payment_frequency,
    //         'status' => 'Active',
    //     ]);

    //     // 🔥 STORE ACTIVITY
    //     Activity::create([
    //         'user_id' => Auth::id(),
    //         'reminder_id' => $reminder->id,
    //         'description' => 'Reminder created for category "' . $category->name .
    //             '" and subcategory "' . $subcategory->name . '"',
    //         'is_auto_generate' => 0,
    //     ]);

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Reminder created successfully'
    //     ]);
    // }


    public function store(Request $request)
    {
        
        $request->validate(
            [
                'title' => 'required|string|min:3|max:100',
                'category_id' => 'required|integer|exists:categories,id',
                'subcategory_name' => 'required|string|max:100',
                'end_reminder_date' => 'required|date|after_or_equal:today',
                'reminder_time' => 'required',
                'description' => 'nullable|string|max:200',
                'provider' => 'nullable|string|max:100',
                'cost' => 'nullable|numeric|min:0',
                'payment_frequency' => 'nullable|string|max:50',
            ],
            [
                'category_id.required' => 'Category name is required.',
                'category_id.exists' => 'Selected category is invalid.',
                'subcategory_name.required' => 'Subcategory name is required.',
                'end_reminder_date.required' => 'End reminder date is required.',
                'end_reminder_date.after_or_equal' => 'End reminder date cannot be in the past.',
                'reminder_time.required' => 'Reminder time is required.',
            ]
        );
        $category = Category::findOrFail($request->category_id);

        $subcategory = SubCategory::where('category_id', $request->category_id)
            ->whereRaw('LOWER(name) = ?', [strtolower($request->subcategory_name)])
            ->first();

        if (!$subcategory) {
            $subcategory = SubCategory::create([
                'category_id' => $request->category_id,
                'name' => ucfirst($request->subcategory_name),
                'description' => null,
                'role' => 'user',
                'created_by' => Auth::id(),
                'status' => 'Active',
            ]);
        }

        $endDate = Carbon::parse($request->end_reminder_date);

        $today = now();

        $reminderDate = Carbon::create(
            $today->year,
            $today->month,
            $endDate->day
        );

        if ($reminderDate->lt($today)) {
            $reminderDate->addMonth();
        }

        $reminder = Reminder::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'subcategory_id' => $subcategory->id,
            'title' => ucfirst($request->title),
            'reminder_date' => $reminderDate->toDateString(),
            'end_reminder_date' => $endDate->toDateString(),
            'reminder_time' => $request->reminder_time,
            'description' => $request->description,
            'provider' => $request->provider,
            'cost' => $request->cost,
            'payment_frequency' => $request->payment_frequency,
            'status' => 'Active',
        ]);

        $frequency = strtolower($reminder->payment_frequency ?? '');

        $monthsMap = [
            'monthly' => 1,
            'quarterly' => 3,
            'half-yearly' => 6,
            'annually' => 12,
        ];

        $months = $monthsMap[$frequency] ?? 0;

        $startDate = Carbon::parse($reminder->reminder_date);

        $current = $startDate->copy();

        $originalDay = $startDate->day;

        while ($current->lte($endDate)) {

            ReminderHistory::create([
                'user_id' => Auth::id(),
                'reminder_id' => $reminder->id,
                'reminder_date' => $current->toDateString(),
                'reminder_time' => $reminder->reminder_time,
                'status' => 'pending',
            ]);

            if ($months === 0) {
                break;
            }

            $next = $current->copy()->addMonths($months);

            $lastDay = $next->daysInMonth;

            $current = $next->day(min($originalDay, $lastDay));
        }

        Activity::create([
            'user_id' => Auth::id(),
            'reminder_id' => $reminder->id,
            'description' => 'Reminder created for category "' .
                $category->name .
                '" and subcategory "' .
                $subcategory->name .
                '"',
            'is_auto_generate' => 0,
        ]);

        return response()->json([
            'status' => true,
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

        // 🔥 STORE ACTIVITY
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

    public function update(Request $request, $id)
    {

        // ── Resolve category slug → integer ID if needed
        $categoryInput = $request->input('category_id');

        if (!is_numeric($categoryInput)) {
            // It's a slug — find the real category ID
            $category = \App\Models\Category::where('status', 'active')
                ->get()
                ->first(fn($cat) => \Str::slug($cat->name) === $categoryInput);

            if (!$category) {
                return response()->json([
                    'errors' => [
                        'category_id' => ['Invalid category selected.']
                    ]
                ], 422);
            }

            // Replace slug with real integer ID for validation
            $request->merge(['category_id' => $category->id]);
        }

        $request->validate([
            'title'            => 'required|string|min:3|max:100',
            'category_id'      => 'required|integer|exists:categories,id',
            'subcategory_name' => 'required|string|max:100',
            'end_reminder_date'    => 'required|date',
            'reminder_time'    => 'required',
            'description'      => 'nullable|string|max:200',
            'provider'         => 'nullable|string|max:100',
            'cost'             => 'nullable|numeric|min:0',
            'payment_frequency' => 'nullable|string|max:50',
        ]);

        $reminder = Reminder::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $category = Category::find($request->category_id);

        // 🔥 Find subcategory id from name
        $subcategory = SubCategory::where('category_id', $request->category_id)
            ->where('name', $request->subcategory_name)
            ->first();

        $reminder->update([
            'category_id'      => $request->category_id,
            'subcategory_id'   => $subcategory?->id,
            'title'            => $request->title,
            'end_reminder_date'    => $request->end_reminder_date,
            'reminder_time'    => $request->reminder_time,
            'description'      => $request->description,
            'provider'         => $request->provider,
            'cost'             => $request->cost,
            'payment_frequency' => $request->payment_frequency,
        ]);

        // 🔥 STORE ACTIVITY
        Activity::create([
            'user_id' => Auth::id(),
            'reminder_id' => $reminder->id,
            'description' => 'Reminder updated for category "' .
                $category?->name . '" and subcategory "' .
                $subcategory?->name . '"',
            'is_auto_generate' => 0,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Reminder updated successfully'
        ]);
    }
}
