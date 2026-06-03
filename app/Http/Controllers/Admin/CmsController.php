<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlanPrice;
use Illuminate\Support\Facades\Validator;

class CmsController extends Controller
{
    public function pricingPage()
    {
        $plans = PlanPrice::latest()->get();
        return view('admin.admin-pricing', compact('plans'));
    }

    public function savePlan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plan_name.*'   => 'required|string|max:255',
            'price.*'       => 'required|numeric|min:0',
            'vat.*'         => 'required|numeric|min:0',
            'expiry_date.*' => 'nullable|date',
        ], [
            'plan_name.*.required' => 'Plan name is required',
            'price.*.required'     => 'Price is required',
            'price.*.numeric'      => 'Price must be a number',
            'vat.*.required'       => 'VAT is required',
            'vat.*.numeric'        => 'VAT must be a number',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        foreach ($request->plan_name as $key => $planName) {
            $price = (float)($request->price[$key] ?? 0);
            $vat   = (float)($request->vat[$key] ?? 0);

            $data = [
                'plan_name'   => $planName,
                'icon'        => $request->icon[$key] ?? null,
                'range'       => $request->range[$key] ?? null,
                'color'       => $request->color[$key] ?? '#7c3aed',
                'price'       => $price,
                'vat'         => $vat,
                'total_price' => $price + $vat,
                'expiry_date' => $request->expiry_date[$key] ?? null,
                'status'      => $request->status[$key] ?? 'Active',
                'features'    => $request->features[$key] ?? [],
                'description' => $request->description[$key] ?? null,
            ];

            $planId = $request->plan_id[$key] ?? null;

            if ($planId) {
                PlanPrice::where('id', $planId)->update($data);
            } else {
                PlanPrice::create($data);
            }
        }

        return response()->json([
            'status'  => true,
            'message' => 'Plans saved successfully!'
        ]);
    }

    public function deletePlan($id)
    {
        $plan = PlanPrice::findOrFail($id);
        $plan->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Plan deleted successfully!'
        ]);
    }

    /* ── Coupon CRUD ── */
    public function createCoupon(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'code'             => 'required|string|unique:coupons,code',
            'coupon_type'    => 'required|in:percentage,fixed',
            'discount'   => 'required|numeric|min:0',
            'expiry_date'      => 'required|date',
            'status'           => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $coupon = \App\Models\Coupon::create([
            'code'         => strtoupper($request->code),
            'coupon_type'  => $request->coupon_type,
            'discount'     => $request->discount,
            'start_date'   => now(),
            'expiry_date'  => $request->expiry_date,
            'status'       => $request->status,
        ]);

        return response()->json(['status' => true, 'message' => 'Coupon created!', 'coupon' => $coupon]);
    }

    public function updateCoupon(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'code'           => 'required|string|unique:coupons,code,' . $id,
            'coupon_type'  => 'required|in:percentage,fixed',
            'discount' => 'required|numeric|min:0',
            'expiry_date'    => 'required|date',
            'status'         => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $coupon = \App\Models\Coupon::findOrFail($id);
        $coupon->update($request->only('code', 'discount_type', 'discount_value', 'expiry_date', 'status'));

        return response()->json(['status' => true, 'message' => 'Coupon updated!', 'coupon' => $coupon]);
    }

    public function deleteCoupon($id)
    {
        \App\Models\Coupon::findOrFail($id)->delete();
        return response()->json(['status' => true, 'message' => 'Coupon deleted!']);
    }

    public function getCoupons()
    {
        $coupons = \App\Models\Coupon::latest()->get();
        return response()->json(['status' => true, 'coupons' => $coupons]);
    }
}
