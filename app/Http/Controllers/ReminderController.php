<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Reminder;
use App\Models\Category;
use App\Models\SubCategory;


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

public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|min:3|max:100',
        'category_id' => 'required|integer|exists:categories,id',
        'subcategory_name' => 'required|string|max:100',
      'reminder_date' => 'required|date|after_or_equal:today',
        'reminder_time' => 'required',
        'description' => 'nullable|string|max:200',
        'provider' => 'nullable|string|max:100',
        'cost' => 'nullable|numeric|min:0',
        'payment_frequency' => 'nullable|string|max:50',
    ]);

    // 🔥 FIND CATEGORY
    $category = Category::find($request->category_id);

    // 🔥 CHECK EXISTING SUBCATEGORY
    $subcategory = SubCategory::where(
            'category_id',
            $request->category_id
        )
        ->whereRaw(
            'LOWER(name) = ?',
            [strtolower($request->subcategory_name)]
        )
        ->first();

    // 🔥 IF NOT EXISTS → CREATE CUSTOM SUBCATEGORY
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

    // 🔥 STORE REMINDER
    Reminder::create([
        'user_id' => Auth::id(),
        'category_id' => $request->category_id,
        'subcategory_id' => $subcategory->id,
        'title' => ucfirst($request->title),
        'end_reminder_date' => $request->reminder_date,
        'reminder_date' => $request->reminder_date,
        'reminder_time' => $request->reminder_time,
        'description' => $request->description,
        'provider' => $request->provider,
        'cost' => $request->cost,
        'payment_frequency' => $request->payment_frequency,
        'status' => 'Active',
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Reminder created successfully'
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
    $reminder->delete();
    return response()->json([
        'status' => true,
        'message' => 'Reminder deleted successfully'
    ]);
}

public function update(Request $request, $id)
{
    $request->validate([
        'title'            => 'required|string|min:3|max:100',
        'category_id'      => 'required|integer|exists:categories,id',
        'subcategory_name' => 'required|string|max:100',
        'reminder_date'    => 'required|date',
        'reminder_time'    => 'required',
        'description'      => 'nullable|string|max:200',
        'provider'         => 'nullable|string|max:100',
        'cost'             => 'nullable|numeric|min:0',
        'payment_frequency'=> 'nullable|string|max:50',
    ]);

    $reminder = Reminder::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    // 🔥 Find subcategory id from name
    $subcategory = SubCategory::where('category_id', $request->category_id)
        ->where('name', $request->subcategory_name)
        ->first();

    $reminder->update([
        'category_id'      => $request->category_id,
        'subcategory_id'   => $subcategory?->id,
        'title'            => $request->title,
        'reminder_date'    => $request->reminder_date,
        'reminder_time'    => $request->reminder_time,
        'description'      => $request->description,
        'provider'         => $request->provider,
        'cost'             => $request->cost,
        'payment_frequency'=> $request->payment_frequency,
    ]);

    return response()->json([
        'status'  => true,
        'message' => 'Reminder updated successfully'
    ]);
}
    
}
