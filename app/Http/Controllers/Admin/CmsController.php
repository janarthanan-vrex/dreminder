<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlanPrice;
use App\Models\PrivacyPolicy;
use App\Models\TermsPage;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
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

   public function privacyPolicy(Request $request)
{
    $policy = PrivacyPolicy::where('slug', 'privacy-policy')->first();

    return view('admin.admin-cms-privacy', [
        'content' => $policy?->content
    ]);
}

    public function savePrivacyPolicy(Request $request)
    {
        $request->validate([
            'content' => 'required',
        ]);

        PrivacyPolicy::updateOrCreate(
            ['slug' => 'privacy-policy'],
            [
                'title'   => 'Privacy Policy',
                'content' => $request->content, // Store HTML directly
            ]
        );

        return response()->json([
            'status'  => true,
            'message' => 'Privacy Policy saved successfully.'
        ]);
    }


    public function termsCondition(Request $request)
{
    $terms = TermsPage::where('slug', 'terms-condition')->first();

    return view('admin.admin-cms-terms', [
        'content' => $terms?->content
    ]);
}

     public function saveTermsCondition(Request $request)
    {
        $request->validate([
            'content' => 'required',
        ]);

        TermsPage::updateOrCreate(
            ['slug' => 'terms-condition'],
            [
                'title'   => 'Terms & Conditions',
                'content' => $request->content, // Store HTML directly
            ]
        );

        return response()->json([
            'status'  => true,
            'message' => 'Terms & Conditions saved successfully.'
        ]);
    }

     /* ─── FAQ CMS Page ─── */
    public function faqPage()
    {
        $categories = FaqCategory::withCount('faqs')
            ->with(['faqs' => fn($q) => $q->orderBy('sort_order')])
            ->orderBy('sort_order')
            ->get();

        return view('admin.admin-cms-faq', compact('categories'));
    }

    /* ─── FAQ CRUD ─── */
    public function storeFaq(Request $request)
    {
        $data = $request->validate([
            'faq_category_id' => 'required|exists:faq_categories,id',
            'question'        => 'required|string|max:500',
            'answer'          => 'required|string',
            'status'          => 'in:active,draft',
        ]);

        $data['sort_order'] = Faq::where('faq_category_id', $data['faq_category_id'])->max('sort_order') + 1;
        $faq = Faq::create($data);

        return response()->json(['success' => true, 'faq' => $faq->load('category')]);
    }

    public function updateFaq(Request $request, Faq $faq)
    {
        $data = $request->validate([
            'question' => 'sometimes|required|string|max:500',
            'answer'   => 'sometimes|required|string',
            'status'   => 'sometimes|in:active,draft',
        ]);

        $faq->update($data);

        return response()->json(['success' => true, 'faq' => $faq]);
    }

    public function destroyFaq(Faq $faq)
    {
        $faq->delete();
        return response()->json(['success' => true]);
    }

    public function reorderFaqs(Request $request)
    {
        $request->validate(['items' => 'required|array', 'items.*.id' => 'required|exists:faqs,id']);

        foreach ($request->items as $item) {
            Faq::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json(['success' => true]);
    }

    /* ─── Category CRUD ─── */
   public function storeCategory(Request $request)
{
   $data = $request->validate([
    'name'        => 'required|string|max:100|unique:faq_categories,name',
    'description' => 'nullable|string|max:255',
    'icon'        => 'nullable|string|max:100',
    'color'       => 'nullable|string|max:20',
], [
    // Custom error messages
    'name.required' => 'Category name is required',
    'name.unique'   => 'Category name already taken',
]);

    $data['slug'] = Str::slug($data['name']);
    $data['sort_order'] = (FaqCategory::max('sort_order') ?? 0) + 1;

    $category = FaqCategory::create($data);

    return response()->json([
        'success' => true,
        'category' => $category
    ]);
}

    public function updateCategory(Request $request, FaqCategory $faqCategory)
    {
        $data = $request->validate([
           'name' => [
            'sometimes',
            'required',
            'string',
            'max:100',
            Rule::unique('faq_categories', 'name')->ignore($faqCategory->id),
        ],
            'description' => 'nullable|string|max:255',
            'icon'        => 'nullable|string|max:100',
            'color'       => 'nullable|string|max:20',
            'is_visible'  => 'sometimes|boolean',
        ]);

        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $faqCategory->update($data);

        return response()->json(['success' => true, 'category' => $faqCategory]);
    }

    public function destroyCategory(FaqCategory $faqCategory)
    {
        $faqCategory->delete(); // cascades to faqs
        return response()->json(['success' => true]);
    }

}
