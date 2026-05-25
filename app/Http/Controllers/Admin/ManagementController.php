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

    // public function adminCategory(Request $request)
    // {
    //     $categories = Category::where('status', 'Active')
    //         ->orderBy('name')
    //         ->get();

    //     return view('admin.category', compact('categories'));
    // }

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
                'bg'            => $category->color.'20',
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
],[
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
}
