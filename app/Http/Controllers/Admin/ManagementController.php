<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\PlanPrice;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Reminder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class ManagementController extends Controller
{
    public function transactionPage(Request $request)
    {
        $transactions = Payment::with([
            'user.plan',
            'invoice'
        ])
            ->latest()
            ->get()
            ->map(function ($payment) {

                return [
                    'id'         => $payment->id,
                    'txn_id'     => $payment->stripe_payment_id ?? 'N/A',
                    'tnx_order'  => optional($payment->invoice)->invoice_id ?? 'N/A',
                    'user_name'  => optional($payment->user)->first_name . ' ' .
                        optional($payment->user)->last_name,
                    'user_email' => optional($payment->user)->email,
                    'plan_name'  => optional(optional($payment->user)->plan)->plan_name ?? 'No Plan',
                    'order_ref'  => optional($payment->invoice)->invoice_id ?? 'N/A',
                    'amount'     => $payment->amount,
                    'invoice_path' => optional($payment->invoice)->invoice_path,
                    'status'     => strtolower($payment->status),
                    'method'     => $payment->payment_mode,
                    'date'       => $payment->created_at->format('d M Y'),
                    'items'      => [
                        optional(optional($payment->user)->plan)->plan_name
                    ],
                ];
            });


        return view('admin.transactions', compact('transactions'));
    }

    public function adminCategory(Request $request)
    {
        $categories = Category::with(['subcategories'])
            ->withCount('reminders')
            ->where('status', 'Active')
            ->orderBy('name')
            ->get()
            ->map(function ($category) {

                return [
                    'id'            => $category->id,
                    'name'          => $category->name,
                    'icon'          => $category->icon,
                    'color'         => $category->color,
                    'bg'            => $category->color . '20',
                    'desc'          => $category->description,
                    'total'         => $category->reminders_count,

                    'subcategories' => $category->subcategories->map(function ($sub) {

                        return [
                            'id'    => $sub->id,
                            'name'  => $sub->name,

                            'total' => Reminder::where('subcategory_id', $sub->id)
                                ->count()
                        ];
                    })
                ];
            });

        return view('admin.category', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name'        => 'required|unique:categories,name',
            'icon'        => 'required',
            'color'       => 'required',
            'description' => 'nullable',
        ]);

        Category::create([
            'name'          => $request->name,
            'description'   => $request->description,
            'icon'          => $request->icon,
            'color'         => $request->color,
            'status'        => 'Active',
            'is_special'    => 0,
            'role'          => 'admin',
            'created_by_id' => Auth::guard('admin')->id(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Category created successfully'
        ]);
    }

    public function storeSubcategory(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|unique:sub_categories,name',
            'description' => 'nullable',
        ], [
            'category_id.required' => 'Parent category is required.',
            'name.required'        => 'Subcategory name is required.',
        ]);

        SubCategory::create([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'description' => $request->description,
            'role'        => 'admin',
            'created_by'  => Auth::guard('admin')->id(),
            'status'      => 'Active',
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Subcategory created successfully'
        ]);
    }

   public function userManagement(Request $request)
{
    $plans= PlanPrice::where('status','Active')->get();
    $users = User::with(['plan', 'reminders'])
        ->latest()
        ->get()
        ->map(function ($user) {
            return [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'initials' => strtoupper(
                    substr($user->first_name, 0, 1) .
                    substr($user->last_name, 0, 1)
                ),
                'color' => '#7c3aed',
                'plan' => $user->plan->plan_name ?? 'Free',
                'rems' => $user->reminders->count(),
                'status' => $user->status == 'active' ? 'active' : 'suspended',
                'joined' => $user->created_at->format('d M Y'),
                'profile' => $user->profile
                    ? asset($user->profile)
                    : null,
            ];
        });

    return view('admin.users', compact('users','plans'));
}
public function deleteUser($id)
{
    $user = User::findOrFail($id);

    // Delete profile image
    if($user->profile && File::exists(public_path('profile/'.$user->profile))){

        File::delete(public_path('profile/'.$user->profile));

    }

    // Delete invoice files
    foreach($user->invoices as $invoice){

        if($invoice->invoice_path && File::exists(public_path($invoice->invoice_path))){

            File::delete(public_path($invoice->invoice_path));

        }

    }

    // Delete related data
    $user->reminders()->delete();
    $user->payments()->delete();
    $user->invoices()->delete();

    if($user->notificationSetting){

        $user->notificationSetting()->delete();

    }

    // Delete user
    $user->delete();

    return response()->json([
        'status' => true,
        'message' => 'User deleted successfully'
    ]);
}

public function toggleUserStatus(Request $request)
{
    $user = User::findOrFail($request->id);

    $user->status = $user->status === 'active'
        ? 'suspended'
        : 'active';

    $user->save();

    return response()->json([
        'status' => true,
        'user_status' => $user->status,
        'message' => 'User status updated successfully'
    ]);
}

public function updateUser(Request $request)
{
    $request->validate([
        'id' => 'required|exists:users,id',
        'first_name' => 'required|max:255',
        'last_name' => 'required|max:255',
        'phone' => 'nullable|digits_between:10,15',
        'plan' => 'required',
        'status' => 'required|in:active,suspended',
    ]);

    $user = User::findOrFail($request->id);

    $plan = PlanPrice::where('plan_name',$request->plan)->first();

    $user->update([
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'phone' => $request->phone,
        'status' => $request->status,
        'plan_id' => $plan?->id,
    ]);

    return response()->json([
        'status' => true,
        'message' => 'User updated successfully'
    ]);
}
}
