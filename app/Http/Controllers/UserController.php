<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Reminder;
use Carbon\Carbon;




class UserController extends Controller
{
   public function userDashboard(Request $request)
{
    $user = Auth::user();

    $categories = Category::with([
        'subcategories' => function ($query) {
            $query->where('status', 'Active');
        }
    ])
    ->where('status', 'Active')
    ->get();

    // Create an immutable or safely managed instance of current time
    $now = Carbon::now();

    // 1. Active reminders (upcoming + today remaining) - Excluding completed
    $activeReminders = Reminder::where('user_id', $user->id)
        ->where('status', 'Active')
        ->where('reminder_status', '!=', 'completed')
        ->where(function ($query) use ($now) {
            $query->whereDate('reminder_date', '>', $now->toDateString())
                ->orWhere(function ($q) use ($now) {
                    $q->whereDate('reminder_date', $now->toDateString())
                      ->whereTime('reminder_time', '>=', $now->toTimeString());
                });
        })
        ->count();

    // 2. Due this week - Excluding completed & using safe date copies
    $dueThisWeek = Reminder::where('user_id', $user->id)
        ->where('status', 'Active')
        ->where('reminder_status', '!=', 'completed')
        ->whereBetween('reminder_date', [
            $now->copy()->startOfWeek()->toDateString(), // copy() prevents mutating $now
            $now->copy()->endOfWeek()->toDateString()
        ])
        ->count();

    // 3. Completed reminders (Ensured lowercase match to match database value)
    $completedReminders = Reminder::where('user_id', $user->id)
        ->where('reminder_status', 'completed') 
        ->count();

    // 4. Today's reminders - Remaining or total for today (Excluding completed)
    $todayReminders = Reminder::where('user_id', $user->id)
        ->where('status', 'Active')
        ->where('reminder_status', '!=', 'completed')
        ->whereDate('reminder_date', $now->toDateString()) // Safely uses original date
        ->count();

    // 5. 🔥 UPCOMING REMINDERS (Top 5 list, excluding completed)
    $upcomingReminders = Reminder::with([
        'category',
        'subcategory'
    ])
        ->where('user_id', $user->id)
        ->where('status', 'Active')
        ->where('reminder_status', '!=', 'completed')
        ->whereDate('reminder_date', '>=', $now->toDateString())
        ->orderBy('reminder_date')
        ->orderBy('reminder_time')
        ->take(5)
        ->get()
        ->map(function ($r) {
            return [
                'id' => $r->id,
                'title' => $r->title,
                'category' => $r->category?->name,
                'icon' => $r->category?->icon,
                'color' => $r->category?->color,
                'subcategory' => $r->subcategory?->name,
                'dueDate' => $r->reminder_date,
                'dueTime' => $r->reminder_time,
                'status' => strtolower($r->status),
                'reminder_status' => strtolower($r->reminder_status), // Added for frontend context
                'provider' => $r->provider
            ];
        });

    return view('user.dashboard', compact(
        'user',
        'categories',
        'activeReminders',
        'dueThisWeek',
        'completedReminders',
        'todayReminders',
        'upcomingReminders'
    ));
}
    
    public function userProfile(Request $request)
    {
        $user = Auth::user()->load('plan');
        return view('user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name'  => 'required|string|max:50',
            'email'      => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|digits_between:10,15',
            'address1' => 'required|string|max:100',
            'address2' => 'nullable|string|max:100',
            'postcode' => [
                'required',
                'regex:/^(GIR 0AA|[A-Z]{1,2}\d{1,2}[A-Z]?\s?\d[A-Z]{2})$/i'
            ],
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
        $user->address1      = $request->address1;
        $user->address2      = $request->address2;

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

    public function changePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => [
                'required',
                'min:8',
                'regex:/[A-Z]/',        // at least 1 uppercase
                'regex:/[a-z]/',        // at least 1 lowercase
                'regex:/[0-9]/',        // at least 1 number
                'regex:/[@$!%*#?&]/'    // at least 1 special character
            ],
            'confirm_password' => 'required|same:new_password'
        ], [
            'new_password.regex' => 'Password must contain at least 1 uppercase, 1 lowercase, 1 number, and 1 special character',
            'confirm_password.same' => 'Confirm password does not match'
        ]);

        // 🔴 Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => false,
                'errors' => [
                    'current_password' => ['Current password is incorrect']
                ]
            ], 422);
        }

        // 🔴 Prevent same password
        if (Hash::check($request->new_password, $user->password)) {
            return response()->json([
                'status' => false,
                'errors' => [
                    'new_password' => ['New password must be different from current password']
                ]
            ], 422);
        }

        // ✅ Update password
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Password updated successfully'
        ]);
    }
    
    public function userTransaction(Request $request)
    {
        $user = Auth::user();

        $invoices = Invoice::with(['plan', 'payment', 'user'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $ordersData = $invoices->map(function ($invoice) {
            $firstName = $invoice->user->first_name ?? '';
            $lastName  = $invoice->user->last_name  ?? '';
            $fullName  = trim($firstName . ' ' . $lastName);
            $txnId     = $invoice->invoice_id ? $invoice->invoice_id : ('TXN-' . $invoice->id);
            $orderId   = str_pad((string) $invoice->id, 5, '0', STR_PAD_LEFT);
            $planName  = ($invoice->plan && $invoice->plan->plan_name) ? $invoice->plan->plan_name : 'N/A';
            $status    = $invoice->payment_id ? 'completed' : 'pending';
            $type      = $invoice->type ? $invoice->type : 'N/A';

            return [
                'id'        => $invoice->id,
                'txn_id'    => $txnId,
                'order_ref' => 'ORD-' . $orderId,
                'customer'  => [
                    'name'  => ($fullName !== '') ? $fullName : 'Unknown User',
                    'email' => $invoice->user->email ?? '',
                    'color' => '#7c3aed',
                ],
                'plan_name' => $planName,
                'amount'    => (float) ($invoice->amount ?? 0),
                'discount'  => (float) ($invoice->discount ?? 0),
                'type'      => $type,
                'status'    => $status,
                'date'      => $invoice->created_at->format('Y-m-d H:i:s'),
                'dateStr'   => $invoice->created_at->format('d M Y'),
                'invoice_path' => $invoice->invoice_path ?? null,   // ← ADD THIS
            ];
        })->values()->toArray();

        return view('user.transactions', compact('user', 'invoices', 'ordersData'));
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
                    });
            }
        ])
            ->where('status', 'Active')
            ->get();

        // 🔥 REMINDERS
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
                    'category' => $r->category->id,
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

        // 🔥 TOTAL CATEGORY COUNT
        $totalCategories = $categories->count();

        // 🔥 CUSTOM SUBCATEGORY COUNT
        $customSubCount = SubCategory::where('role', 'user')
            ->where('created_by', $user->id)
            ->count();
            // dd($customSubCount);

        // 🔥 MOST USED CATEGORY
        $mostUsedCategory = Reminder::select('category_id')
            ->where('user_id', $user->id)
            ->groupBy('category_id')
            ->orderByRaw('COUNT(*) DESC')
            ->first();

        $mostUsedCategoryName = '—';

        if ($mostUsedCategory) {

            $cat = Category::find(
                $mostUsedCategory->category_id
            );

            $mostUsedCategoryName = $cat?->name ?? '—';
        }
        return view('user.category', compact('user', 'categories', 'reminders', 'totalCategories', 'customSubCount', 'mostUsedCategoryName'));
    }
    public function storeSubCategory(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'category_id' => 'required|exists:categories,id',

            'name' => 'required|string|min:3|max:50',

            'description' => 'nullable|string|max:100',
        ]);

        // 🔥 CHECK DUPLICATE
        $exists = SubCategory::where('category_id', $request->category_id)
            ->where('name', $request->name)
            ->exists();

        if ($exists) {

            return response()->json([
                'status' => false,
                'errors' => [
                    'name' => ['Subcategory already exists']
                ]
            ], 422);
        }

        // ✅ STORE
        SubCategory::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'role' => 'user',
            'created_by' => $user->id,
            'status' => 'Active',
            'description' => $request->description,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Subcategory added successfully'
        ]);
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
        $subcategory->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Subcategory updated successfully'
        ]);
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
        ]);
    }

   public function calenderView(Request $request)
{
    $userId = auth()->id();

    // ── Full CATS with subs — KEY = integer ID (not slug)
    $fullCats = \App\Models\Category::where('status', 'active')
        ->with(['subcategories' => function ($q) {
            $q->where('status', 'active');
        }])
        ->get()
        ->mapWithKeys(function ($cat) {
            return [
                $cat->id => [                          // ✅ integer ID as key
                    'name'  => $cat->name,
                    'color' => $cat->color ?? '#94a3b8',
                    'icon'  => $cat->icon  ?? 'ri-alarm-line',
                    'bg'    => 'rgba(148,163,184,.15)',
                    'subs'  => $cat->subcategories->map(fn($sub) => [
                        'id'          => $sub->id,
                        'name'        => $sub->name,
                        'role'        => $sub->role,
                        'description' => $sub->description,
                        'created_by'  => $sub->created_by,
                    ])->toArray(),
                ]
            ];
        });

    // ── Slim CAL_CATS for chip colours — KEY = integer ID (not slug)
    $categories = $fullCats->map(fn($c) => collect($c)->except('subs'));

    // ── Reminder histories
    $histories = \App\Models\ReminderHistory::with([
            'reminder.category',
            'reminder.subcategory',
        ])
        ->where('user_id', $userId)
        ->get()
        ->map(function ($h) {
            $reminder = $h->reminder;
            if (!$reminder) return null;

            return [
                'id'                => $h->id,
                'reminder_id'       => $h->reminder_id,
                'title'             => $reminder->title,
                'category'          => $reminder->category_id,  // ✅ integer ID (not slug)
                'subcategory'       => $reminder->subcategory?->name ?? '',
                'dueDate'           => $h->reminder_date
                                         ? \Carbon\Carbon::parse($h->reminder_date)->format('Y-m-d')
                                         : null,
                'dueTime'           => $h->reminder_time,
                'provider'          => $reminder->provider,
                'cost'              => $reminder->cost,
                'frequency'         => $reminder->payment_frequency,
                'status'            => $h->status,
                'reminder_status'   => $reminder->reminder_status,
                'description'       => $reminder->description,
                'end_reminder_date' => $reminder->end_reminder_date,
            ];
        })
        ->filter()
        ->values();

    return view('user.calendar', compact('histories', 'categories', 'fullCats'));
}


}
