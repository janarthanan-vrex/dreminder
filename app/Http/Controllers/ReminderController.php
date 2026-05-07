<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Reminder;
use App\Models\Category;
use App\Models\SubCategory;


class ReminderController extends Controller
{

public function store(Request $request)
    {
       
        $request->validate([

            'title' => 'required|string|min:3|max:100',

            'category_id' => 'required|integer|exists:categories,id',

            'subcategory_name' => 'required|string|max:100',

            'reminder_date' => 'required|date',

            'reminder_time' => 'required',

            'description' => 'nullable|string|max:200',

            'provider' => 'nullable|string|max:100',

            'cost' => 'nullable|numeric|min:0',

            'payment_frequency' => 'nullable|string|max:50',

        ]);

        // 🔥 find subcategory id from name
        $subcategory = SubCategory::where('category_id', $request->category_id)

            ->where('name', $request->subcategory_name)

            ->first();

        Reminder::create([

            'user_id' => Auth::id(),

            'category_id' => $request->category_id,

            'subcategory_id' => $subcategory?->id,

            'title' => $request->title,

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
    
}
