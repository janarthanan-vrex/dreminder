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
use App\Models\AuditLog;

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
            $price    = (float)($request->price[$key] ?? 0);
            $vat      = (float)($request->vat[$key] ?? 0);
            $features = $request->features[$key] ?? [];

            $data = [
                'plan_name'   => $planName,
                'icon'        => $request->icon[$key]        ?? null,
                'range'       => $request->range[$key]       ?? null,
                'color'       => $request->color[$key]       ?? '#7c3aed',
                'price'       => $price,
                'vat'         => $vat,
                'total_price' => $price + $vat,
                'expiry_date' => $request->expiry_date[$key] ?? null,
                'status'      => $request->status[$key]      ?? 'Active',
                'features'    => $features,
                'description' => $request->description[$key] ?? null,
            ];

            $planId = $request->plan_id[$key] ?? null;

            // ── Helper: features array → readable string ──────────────────────
            $featuresToString = function ($val) {
                if (empty($val)) return '—';
                if (is_array($val)) return implode(', ', array_filter($val));
                if (is_string($val)) {
                    $decoded = json_decode($val, true);
                    return is_array($decoded)
                        ? implode(', ', array_filter($decoded))
                        : $val;
                }
                return '—';
            };

            if ($planId) {
                // ── UPDATE ────────────────────────────────────────────────────
                $existing = PlanPrice::find($planId);

                if ($existing) {
                    $before = [
                        'name'        => $existing->plan_name,
                        'price'       => '£' . number_format($existing->price, 2),
                        'vat'         => '£' . number_format($existing->vat, 2),
                        'total_price' => '£' . number_format($existing->total_price, 2),
                        'status'      => $existing->status                       ?? '—',
                        'features'    => $featuresToString($existing->features),
                        // expiry_date only if it had a value before
                        ...($existing->expiry_date
                            ? ['expiry_date' => $existing->expiry_date]
                            : []
                        ),
                    ];

                    PlanPrice::where('id', $planId)->update($data);

                    $newExpiry = $request->expiry_date[$key] ?? null;

                    $after = [
                        'name'        => $planName,
                        'price'       => '£' . number_format($price, 2),
                        'vat'         => '£' . number_format($vat, 2),
                        'total_price' => '£' . number_format($price + $vat, 2),
                        'status'      => $request->status[$key] ?? 'Active',
                        'features'    => $featuresToString($features),
                        // expiry_date only if it had a value before (keep keys in sync)
                        ...($existing->expiry_date
                            ? ['expiry_date' => $newExpiry ?? '—']
                            : []
                        ),
                    ];

                    $fieldLabels = [
                        'name'        => 'Plan Name',
                        'price'       => 'Price',
                        'vat'         => 'VAT',
                        'total_price' => 'Total Price',
                        'status'      => 'Status',
                        'features'    => 'Features',
                        'expiry_date' => 'Expiry Date',
                    ];

                    $changedFields = [];
                    foreach ($before as $k => $oldVal) {
                        if ((string) $oldVal !== (string) $after[$k]) {
                            $changedFields[] = [
                                'field' => $fieldLabels[$k],
                                'old'   => $oldVal,
                                'new'   => $after[$k],
                            ];
                        }
                    }

                    if (!empty($changedFields)) {
                        $summary = count($changedFields) === 1
                            ? '1 Field Updated'
                            : count($changedFields) . ' Fields Updated';

                        AuditLog::record('Updated', 'Plans', $summary, $changedFields);
                    }
                }
            } else {
                // ── CREATE ────────────────────────────────────────────────────
                PlanPrice::create($data);

                $createFields = [
                    ['field' => 'Plan Name',   'old' => null, 'new' => $planName],
                    ['field' => 'Price',       'old' => null, 'new' => '£' . number_format($price, 2)],
                    ['field' => 'VAT',         'old' => null, 'new' => '£' . number_format($vat, 2)],
                    ['field' => 'Total Price', 'old' => null, 'new' => '£' . number_format($price + $vat, 2)],
                    ['field' => 'Status',      'old' => null, 'new' => $request->status[$key] ?? 'Active'],
                    ['field' => 'Features',    'old' => null, 'new' => $featuresToString($features)],
                ];

                // Only add expiry_date row if it was actually provided
                if (!empty($request->expiry_date[$key])) {
                    $createFields[] = [
                        'field' => 'Expiry Date',
                        'old'   => null,
                        'new'   => $request->expiry_date[$key],
                    ];
                }

                AuditLog::record('Created', 'Plans', 'Created Record', $createFields);
            }
        }

        return response()->json([
            'status'  => true,
            'message' => 'Plans saved successfully!',
        ]);
    }

    public function deletePlan($id)
    {
        $plan = PlanPrice::findOrFail($id);

        // ── Audit Log BEFORE delete ───────────────────────────────────────────
        AuditLog::record('Deleted', 'Plans', 'Deleted Record', [
            ['field' => 'Plan Name',   'old' => $plan->plan_name,                          'new' => null],
            ['field' => 'Price',       'old' => '£' . number_format($plan->price, 2),      'new' => null],
            ['field' => 'Total Price', 'old' => '£' . number_format($plan->total_price, 2), 'new' => null],
            ['field' => 'Status',      'old' => $plan->status ?? '—',                      'new' => null],
            ['field' => 'Action',      'old' => 'Plan Permanently Removed',                'new' => null],
        ]);

        $plan->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Plan deleted successfully!',
        ]);
    }

    /* ── Coupon CRUD ── */
    public function createCoupon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code'         => 'required|string|unique:coupons,code',
            'coupon_type'  => 'required|in:percentage,fixed',
            'discount'     => 'required|numeric|min:0',
            'expiry_date'  => 'required|date',
            'status'       => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $maxPlanPrice = PlanPrice::max('total_price');

        if ($request->coupon_type === 'fixed') {

            if ($request->discount > $maxPlanPrice) {
                return response()->json([
                    'status' => false,
                    'errors' => [
                        'discount' => [
                            "Fixed discount cannot exceed the highest plan price (£{$maxPlanPrice})."
                        ]
                    ]
                ], 422);
            }
        } elseif ($request->coupon_type === 'percentage') {

            if ($request->discount > 100) {
                return response()->json([
                    'status' => false,
                    'errors' => [
                        'discount' => [
                            'Percentage discount cannot exceed 100%.'
                        ]
                    ]
                ], 422);
            }
        }

        $coupon = \App\Models\Coupon::create([
            'code'        => strtoupper($request->code),
            'coupon_type' => $request->coupon_type,
            'discount'    => $request->discount,
            'start_date'  => now(),
            'expiry_date' => $request->expiry_date,
            'status'      => $request->status,
        ]);

        // ── Audit Log ────────────────────────────────────────────────────────
        AuditLog::record('Created', 'Coupons', 'Created Record', [
            ['field' => 'Code',        'old' => null, 'new' => strtoupper($request->code)],
            ['field' => 'Type',        'old' => null, 'new' => ucfirst($request->coupon_type)],
            ['field' => 'Discount',    'old' => null, 'new' => $request->coupon_type === 'percentage'
                ? $request->discount . '%'
                : '£' . number_format($request->discount, 2)],
            ['field' => 'Expiry Date', 'old' => null, 'new' => $request->expiry_date],
            ['field' => 'Status',      'old' => null, 'new' => ucfirst($request->status)],
        ]);

        // Format date as string to prevent timezone conversion
        $coupon->expiry_date = $coupon->expiry_date ? $coupon->expiry_date->format('Y-m-d') : null;

        return response()->json(['status' => true, 'message' => 'Coupon created!', 'coupon' => $coupon]);
    }

    public function updateCoupon(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'code'        => 'required|string|unique:coupons,code,' . $id,
            'coupon_type' => 'required|in:percentage,fixed',
            'discount'    => 'required|numeric|min:0',
            'expiry_date' => 'required|date',
            'status'      => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }
        $maxPlanPrice = PlanPrice::max('total_price');

if ($request->coupon_type === 'fixed') {

    if ($request->discount > $maxPlanPrice) {
        return response()->json([
            'status' => false,
            'errors' => [
                'discount' => [
                    "Fixed discount cannot exceed the highest plan price (£{$maxPlanPrice})."
                ]
            ]
        ], 422);
    }

} elseif ($request->coupon_type === 'percentage') {

    if ($request->discount > 100) {
        return response()->json([
            'status' => false,
            'errors' => [
                'discount' => [
                    'Percentage discount cannot exceed 100%.'
                ]
            ]
        ], 422);
    }

}

        $coupon = \App\Models\Coupon::findOrFail($id);

        // ── Snapshot BEFORE ───────────────────────────────────────────────────
        $formatDiscount = fn($type, $value) => $type === 'percentage'
            ? $value . '%'
            : '£' . number_format($value, 2);

        $before = [
            'code'        => $coupon->code,
            'coupon_type' => ucfirst($coupon->coupon_type),
            'discount'    => $formatDiscount($coupon->coupon_type, $coupon->discount),
            'expiry_date' => $coupon->expiry_date
                ? \Carbon\Carbon::parse($coupon->expiry_date)->format('Y-m-d')
                : null,
            'status'      => ucfirst($coupon->status),
        ];

        $coupon->update([
            'code'        => strtoupper($request->code),
            'coupon_type' => $request->coupon_type,
            'discount'    => $request->discount,
            'expiry_date' => $request->expiry_date,
            'status'      => $request->status,
        ]);

        // ── Snapshot AFTER ────────────────────────────────────────────────────
        $after = [
            'code'        => strtoupper($request->code),
            'coupon_type' => ucfirst($request->coupon_type),
            'discount'    => $formatDiscount($request->coupon_type, $request->discount),
            'expiry_date' => $request->expiry_date,
            'status'      => ucfirst($request->status),
        ];

        $fieldLabels = [
            'code'        => 'Code',
            'coupon_type' => 'Type',
            'discount'    => 'Discount',
            'expiry_date' => 'Expiry Date',
            'status'      => 'Status',
        ];

        $changedFields = [];
        foreach ($before as $key => $oldVal) {
            if ((string) $oldVal !== (string) $after[$key]) {
                $changedFields[] = [
                    'field' => $fieldLabels[$key],
                    'old'   => $oldVal,
                    'new'   => $after[$key],
                ];
            }
        }

        if (!empty($changedFields)) {
            $summary = count($changedFields) === 1
                ? '1 Field Updated'
                : count($changedFields) . ' Fields Updated';

            AuditLog::record('Updated', 'Coupons', $summary, $changedFields);
        }

        // Format date as string to prevent timezone conversion
        $coupon->expiry_date = $coupon->expiry_date ? $coupon->expiry_date->format('Y-m-d') : null;

        return response()->json(['status' => true, 'message' => 'Coupon updated!', 'coupon' => $coupon]);
    }

    public function deleteCoupon($id)
    {
        $coupon = \App\Models\Coupon::findOrFail($id);

        // ── Audit Log BEFORE delete ───────────────────────────────────────────
        AuditLog::record('Deleted', 'Coupons', 'Deleted Record', [
            ['field' => 'Code',        'old' => $coupon->code,                                        'new' => null],
            ['field' => 'Type',        'old' => ucfirst($coupon->coupon_type),                        'new' => null],
            ['field' => 'Discount',    'old' => $coupon->coupon_type === 'percentage'
                ? $coupon->discount . '%'
                : '£' . number_format($coupon->discount, 2),          'new' => null],
            ['field' => 'Expiry Date', 'old' => $coupon->expiry_date,                                 'new' => null],
            ['field' => 'Status',      'old' => ucfirst($coupon->status),                             'new' => null],
        ]);

        $coupon->delete();

        return response()->json(['status' => true, 'message' => 'Coupon deleted!']);
    }

    public function getCoupons()
    {
        $coupons = \App\Models\Coupon::latest()->get();

        // Convert to array and format dates to prevent timezone conversion
        $formattedCoupons = $coupons->map(function ($coupon) {
            return [
                'id'            => $coupon->id,
                'code'          => $coupon->code,
                'coupon_type'   => $coupon->coupon_type,
                'discount'      => $coupon->discount,
                'expiry_date'   => $coupon->expiry_date ? $coupon->expiry_date->format('Y-m-d') : null,
                'start_date'    => $coupon->start_date ? $coupon->start_date->format('Y-m-d') : null,
                'status'        => $coupon->status,
                'created_at'    => $coupon->created_at,
                'updated_at'    => $coupon->updated_at,
            ];
        })->toArray();

        return response()->json(['status' => true, 'coupons' => $formattedCoupons]);
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

    //      public function saveTermsCondition(Request $request)
    // {
    //     $request->validate([
    //         'content' => 'required',
    //     ]);

    //     // ── Read old value BEFORE saving ─────────────────────────────────────
    //     $existing = TermsPage::where('slug', 'terms-condition')->first();
    //     $isNew    = !$existing;

    //     TermsPage::updateOrCreate(
    //         ['slug' => 'terms-condition'],
    //         [
    //             'title'   => 'Terms & Conditions',
    //             'content' => $request->content,
    //         ]
    //     );

    //     // ── Audit Log ────────────────────────────────────────────────────────
    //     if ($isNew) {
    //         AuditLog::record('Created', 'Settings', 'Created Record', [
    //             ['field' => 'Page',    'old' => null, 'new' => 'Terms & Conditions'],
    //             ['field' => 'Content', 'old' => null, 'new' => \Str::limit(strip_tags($request->content), 80)],
    //         ]);
    //     } else {
    //         $oldContent = \Str::limit(strip_tags($existing->content), 80);
    //         $newContent = \Str::limit(strip_tags($request->content),  80);

    //         if ($oldContent !== $newContent) {
    //             AuditLog::record('Updated', 'Settings', 'Terms & Conditions Updated', [
    //                 ['field' => 'Page',    'old' => 'Terms & Conditions', 'new' => null],
    //                 ['field' => 'Content', 'old' => $oldContent,          'new' => $newContent],
    //             ]);
    //         }
    //     }

    //     return response()->json([
    //         'status'  => true,
    //         'message' => 'Terms & Conditions saved successfully.',
    //     ]);
    // }

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

        // ── Audit Log ────────────────────────────────────────────────────────
        $category = FaqCategory::find($data['faq_category_id']);

        AuditLog::record('Created', 'FAQ', 'Created Record', [
            ['field' => 'Category', 'old' => null, 'new' => $category?->name ?? '—'],
            ['field' => 'Question', 'old' => null, 'new' => \Str::limit($data['question'], 80)],
            ['field' => 'Answer',   'old' => null, 'new' => \Str::limit($data['answer'],   80)],
            ['field' => 'Status',   'old' => null, 'new' => ucfirst($data['status'] ?? 'draft')],
        ]);

        return response()->json(['success' => true, 'faq' => $faq->load('category')]);
    }

    public function updateFaq(Request $request, Faq $faq)
    {
        $data = $request->validate([
            'question' => 'sometimes|required|string|max:500',
            'answer'   => 'sometimes|required|string',
            'status'   => 'sometimes|in:active,draft',
        ]);

        // ── Snapshot BEFORE ───────────────────────────────────────────────────
        $before = [
            'question' => \Str::limit($faq->question, 80),
            'answer'   => \Str::limit($faq->answer,   80),
            'status'   => ucfirst($faq->status ?? 'draft'),
        ];

        $faq->update($data);

        // ── Snapshot AFTER ────────────────────────────────────────────────────
        $after = [
            'question' => \Str::limit($data['question'] ?? $faq->question, 80),
            'answer'   => \Str::limit($data['answer']   ?? $faq->answer,   80),
            'status'   => ucfirst($data['status']        ?? $faq->status ?? 'draft'),
        ];

        $fieldLabels = [
            'question' => 'Question',
            'answer'   => 'Answer',
            'status'   => 'Status',
        ];

        $changedFields = [];
        foreach ($before as $key => $oldVal) {
            if ((string) $oldVal !== (string) $after[$key]) {
                $changedFields[] = [
                    'field' => $fieldLabels[$key],
                    'old'   => $oldVal,
                    'new'   => $after[$key],
                ];
            }
        }

        if (!empty($changedFields)) {
            $summary = count($changedFields) === 1
                ? '1 Field Updated'
                : count($changedFields) . ' Fields Updated';

            AuditLog::record('Updated', 'FAQ', $summary, $changedFields);
        }

        return response()->json(['success' => true, 'faq' => $faq]);
    }

    public function destroyFaq(Faq $faq)
    {
        // ── Audit Log BEFORE delete ───────────────────────────────────────────
        AuditLog::record('Deleted', 'FAQ', 'Deleted Record', [
            ['field' => 'Category', 'old' => optional($faq->category)->name ?? '—',  'new' => null],
            ['field' => 'Question', 'old' => \Str::limit($faq->question, 80),         'new' => null],
            ['field' => 'Status',   'old' => ucfirst($faq->status ?? 'draft'),        'new' => null],
        ]);

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
            'name.required' => 'Category name is required',
            'name.unique'   => 'Category name already taken',
        ]);

        $data['slug']       = Str::slug($data['name']);
        $data['sort_order'] = (FaqCategory::max('sort_order') ?? 0) + 1;

        $category = FaqCategory::create($data);

        // ── Audit Log ────────────────────────────────────────────────────────
        AuditLog::record('Created', 'FAQ', 'Created Record', [
            ['field' => 'Name',        'old' => null, 'new' => $data['name']],
            ['field' => 'Description', 'old' => null, 'new' => $data['description'] ?? '—'],
            ['field' => 'Icon',        'old' => null, 'new' => $data['icon']        ?? '—'],
            ['field' => 'Slug',        'old' => null, 'new' => $data['slug']],
        ]);

        return response()->json([
            'success'  => true,
            'category' => $category,
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

        // ── Snapshot BEFORE ───────────────────────────────────────────────────
        $before = [
            'name'        => $faqCategory->name,
            'description' => $faqCategory->description ?? '—',
            'icon'        => $faqCategory->icon         ?? '—',
            'is_visible'  => $faqCategory->is_visible   ? 'Visible' : 'Hidden',
        ];

        $faqCategory->update($data);

        // ── Snapshot AFTER ────────────────────────────────────────────────────
        $after = [
            'name'        => $data['name']        ?? $faqCategory->name,
            'description' => $data['description'] ?? '—',
            'icon'        => $data['icon']        ?? '—',
            'is_visible'  => isset($data['is_visible'])
                ? ($data['is_visible'] ? 'Visible' : 'Hidden')
                : $before['is_visible'],
        ];

        $fieldLabels = [
            'name'        => 'Name',
            'description' => 'Description',
            'icon'        => 'Icon',
            'is_visible'  => 'Visibility',
        ];

        $changedFields = [];
        foreach ($before as $key => $oldVal) {
            if ((string) $oldVal !== (string) $after[$key]) {
                $changedFields[] = [
                    'field' => $fieldLabels[$key],
                    'old'   => $oldVal,
                    'new'   => $after[$key],
                ];
            }
        }

        if (!empty($changedFields)) {
            $summary = count($changedFields) === 1
                ? '1 Field Updated'
                : count($changedFields) . ' Fields Updated';

            AuditLog::record('Updated', 'FAQ', $summary, $changedFields);
        }

        return response()->json(['success' => true, 'category' => $faqCategory]);
    }


    public function destroyCategory(FaqCategory $faqCategory)
    {
        // ── Audit Log BEFORE delete ───────────────────────────────────────────
        AuditLog::record('Deleted', 'FAQ', 'Deleted Record', [
            ['field' => 'Name',        'old' => $faqCategory->name,                'new' => null],
            ['field' => 'Description', 'old' => $faqCategory->description ?? '—',  'new' => null],
            ['field' => 'Visibility',  'old' => $faqCategory->is_visible ? 'Visible' : 'Hidden', 'new' => null],
            ['field' => 'Action',      'old' => 'Category & FAQs Permanently Removed',           'new' => null],
        ]);

        $faqCategory->delete();

        return response()->json(['success' => true]);
    }
}
