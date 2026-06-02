@extends('admin.layouts.app')
@section('content')

<style>
    .cms-tab-btn {
        padding: 10px 18px;
        background: transparent;
        border: none;
        color: var(--text3);
        font-size: .8rem;
        font-weight: 600;
        cursor: pointer;
        border-bottom: 2px solid transparent;
        transition: all .2s;
        display: flex;
        align-items: center;
        gap: 6px
    }
    .cms-tab-btn:hover { color: var(--text2) }
    .cms-tab-btn.active { color: var(--purple); border-bottom-color: var(--purple) }
    .cms-tab-content { display: none }
    .cms-tab-content.active { display: block }
    .field-group { margin-bottom: 16px }
    .field-group .label {
        margin-bottom: 6px;
        display: block;
        font-size: .75rem;
        font-weight: 700;
        color: var(--text3);
        text-transform: uppercase;
        letter-spacing: .05em
    }
    .inp-area {
        width: 100%;
        background: var(--surface2);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 10px 14px;
        color: var(--text);
        font-size: .85rem;
        resize: vertical;
        font-family: inherit;
        transition: border-color .2s
    }
    .inp-area:focus { outline: none; border-color: var(--purple) }
    .section-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 20px;
        margin-bottom: 14px
    }
    .sortable-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        background: var(--row-bg);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        cursor: grab;
        margin-bottom: 8px
    }
    .plan-tab-bar {
        display: flex;
        gap: 6px;
        align-items: center;
        margin-bottom: 18px;
        flex-wrap: wrap
    }
    .plan-tab {
        padding: 7px 16px;
        border-radius: 100px;
        font-size: .78rem;
        font-weight: 700;
        cursor: pointer;
        border: 1px solid var(--border);
        background: var(--row-bg);
        color: var(--text3);
        transition: all .2s;
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap
    }
    .plan-tab:hover { border-color: rgba(124,58,237,.3); color: var(--text2) }
    .plan-tab.active {
        background: rgba(124,58,237,.15);
        border-color: rgba(124,58,237,.35);
        color: var(--purple-light)
    }
    .plan-tab .plan-tab-close {
        width: 16px; height: 16px;
        border-radius: 50%;
        background: var(--ctrl-bg);
        display: flex; align-items: center; justify-content: center;
        font-size: .6rem; flex-shrink: 0;
        transition: background .2s
    }
    .plan-tab .plan-tab-close:hover { background: rgba(239,68,68,.3); color: #fca5a5 }
    .plan-editor { display: none }
    .plan-editor.active { display: block }
    .add-plan-btn {
        padding: 7px 14px;
        border-radius: 100px;
        font-size: .78rem;
        font-weight: 700;
        cursor: pointer;
        border: 1px dashed rgba(124,58,237,.4);
        background: transparent;
        color: rgba(124,58,237,.7);
        transition: all .2s;
        display: flex; align-items: center; gap: 5px
    }
    .add-plan-btn:hover {
        border-color: rgba(124,58,237,.8);
        color: var(--purple-light);
        background: rgba(124,58,237,.08)
    }
    .plan-color-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0 }
    .total-price-box {
        background: rgba(16,185,129,.06);
        border: 1px solid rgba(16,185,129,.2);
        border-radius: var(--radius-sm);
        padding: 10px 14px;
        font-size: .92rem; font-weight: 800; color: #10b981
    }
    .feature-serial {
        width: 22px; height: 22px;
        border-radius: 6px;
        background: rgba(124,58,237,.12);
        color: var(--purple-light);
        font-size: .65rem; font-weight: 800;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0
    }
    .coupon-search-bar { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; flex-wrap: wrap }
    .coupon-search-bar .inp { max-width: 260px }
    .cpn-pagination {
        display: flex; align-items: center; gap: 6px;
        justify-content: flex-end;
        padding: 10px 14px;
        border-top: 1px solid var(--border)
    }
    .cpn-page-btn {
        width: 30px; height: 30px;
        border-radius: 6px;
        border: 1px solid var(--border);
        background: var(--row-bg);
        color: var(--text3);
        font-size: .75rem; font-weight: 700;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: all .2s
    }
    .cpn-page-btn:hover { border-color: rgba(124,58,237,.4); color: var(--purple-light) }
    .cpn-page-btn.active {
        background: rgba(124,58,237,.15);
        border-color: rgba(124,58,237,.4);
        color: var(--purple-light)
    }
    .cpn-page-info { font-size: .72rem; color: var(--text3); margin-right: 4px }
    .error-msg { display: block; margin-top: 4px; font-size: .72rem; color: #ef4444; min-height: 16px }
    .coupon-error-msg { display: block; margin-top: 4px; font-size: .72rem; color: #ef4444; min-height: 16px }
</style>

<div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px">
    <div>
        <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800">Pricing Module</h2>
        <p style="font-size:.8rem;color:var(--text3);margin-top:3px">Manage plans and coupons</p>
    </div>
    <button type="button" class="btn btn-primary btn-sm" onclick="saveAll()">
        <i class="ri-save-line"></i> Save & Publish
    </button>
</div>

<!-- Page Tabs -->
<div style="display:flex;gap:8px;margin-bottom:20px;border-bottom:2px solid rgba(255,255,255,.05)">
    <button class="cms-tab-btn active" onclick="switchTab('plans')" id="tab-btn-plans">
        <i class="ri-price-tag-3-line"></i> Plans
    </button>
    <button class="cms-tab-btn" onclick="switchTab('coupons')" id="tab-btn-coupons">
        <i class="ri-coupon-line"></i> Coupons
    </button>
</div>

<!-- ============================== PLANS TAB ============================== -->
<div class="cms-tab-content active" id="tab-plans">
    <form id="plan-form" onsubmit="return false;">
        <div class="section-card">

            <!-- Plan tab pills -->
            <div class="plan-tab-bar" id="plan-tab-bar">
                @foreach($plans as $key => $plan)
                <button type="button"
                    class="plan-tab {{ $key == 0 ? 'active' : '' }}"
                    onclick="switchPlan({{ $key }}, this)"
                    id="plan-tab-{{ $key }}">
                    <span class="plan-color-dot" style="background:{{ $plan->color }}"></span>
                    {{ $plan->plan_name }}
                    <span class="plan-tab-close" onclick="deletePlan({{ $plan->id }}, event, {{ $key }})">
                        <i class="ri-close-line"></i>
                    </span>
                </button>
                @endforeach

                <button type="button" class="add-plan-btn" onclick="addNewPlan()">
                    <i class="ri-add-line"></i> Add Plan
                </button>
            </div>

            <!-- Plan editors (existing from DB) -->
            @foreach($plans as $key => $plan)
            <div class="plan-editor {{ $key == 0 ? 'active' : '' }}" id="plan-editor-{{ $key }}">

                <input type="hidden" name="plan_id[]" value="{{ $plan->id }}">

                <div class="g2">
                    <div class="field-group">
                        <label class="label">Plan Name <span style="color:#ef4444">*</span></label>
                        <input class="inp plan-name-inp"
                            data-plan="{{ $key }}"
                            name="plan_name[]"
                            value="{{ $plan->plan_name }}"
                            oninput="syncPlanTab({{ $key }}); hideError(this)">
                        <small class="error-msg"></small>
                    </div>
                    <div class="field-group">
                        <label class="label">Plan Icon (Remix Icon class)</label>
                        <input class="inp" name="icon[]" value="{{ $plan->icon ?? '' }}">
                    </div>
                </div>

                <div class="g2">
                    <div class="field-group">
                        <label class="label">Accent Color <span style="color:#ef4444">*</span></label>
                        <div style="display:flex;gap:8px;align-items:center;margin-top:4px">
                            <input type="color"
                                class="plan-color-inp"
                                data-plan="{{ $key }}"
                                name="color[]"
                                value="{{ $plan->color }}"
                                oninput="syncPlanColor({{ $key }}, this.value)"
                                style="width:38px;height:38px;border:none;background:transparent;cursor:pointer;border-radius:8px">
                            <input class="inp" id="color-text-{{ $key }}"
                                value="{{ $plan->color }}" readonly
                                style="flex:1;font-family:monospace">
                        </div>
                    </div>
                    <div class="field-group">
                        <label class="label">Price <span style="color:#ef4444">*</span></label>
                        <input class="inp"
                            id="p{{ $key }}-price"
                            type="number" step="0.01"
                            name="price[]"
                            value="{{ $plan->price }}"
                            oninput="calcTotal({{ $key }}); hideError(this)">
                        <small class="error-msg"></small>
                    </div>
                </div>

                <div class="g2">
                    <div class="field-group">
                        <label class="label">VAT</label>
                        <input class="inp"
                            id="p{{ $key }}-vat"
                            type="number" step="0.01"
                            name="vat[]"
                            value="{{ $plan->vat }}"
                            oninput="calcTotal({{ $key }})">
                    </div>
                    <div class="field-group">
                        <label class="label">Total Price</label>
                        <div class="total-price-box" id="p{{ $key }}-total">
                            £{{ number_format($plan->total_price, 2) }}
                        </div>
                    </div>
                </div>

                <div class="field-group">
                    <label class="label">Description</label>
                    <input type="text" class="inp" name="description[]" value="{{ $plan->description ?? '' }}">
                </div>

                <div class="field-group hidden">
                    <label class="label">Expiry Date</label>
                    <input type="date" class="inp" name="expiry_date[]"
                        value="{{ $plan->expiry_date ? $plan->expiry_date->format('Y-m-d') : '' }}">
                    <small class="error-msg"></small>
                </div>

                <div class="field-group hidden">
                    <label class="label">Status</label>
                    <select class="inp" name="status[]">
                        <option value="Active"   {{ $plan->status == 'Active'   ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ $plan->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;margin-top:4px">
                    <label class="label" style="margin:0">Features</label>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="addFeature('features-{{ $key }}')">
                        <i class="ri-add-line"></i> Add Feature
                    </button>
                </div>

                <div id="features-{{ $key }}">
                    @foreach($plan->features ?? [] as $featureKey => $feature)
                    <div class="sortable-item">
                        <span class="feature-serial">{{ $featureKey + 1 }}</span>
                        <input class="inp feature-inp"
                            name="features[{{ $key }}][]"
                            value="{{ $feature }}"
                            style="flex:1" readonly>
                        <button type="button" class="btn btn-ghost btn-sm" onclick="toggleFeatureEdit(this)">
                            <i class="ri-edit-line"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeFeature(this, 'features-{{ $key }}')">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </div>
                    @endforeach
                </div>

            </div>
            @endforeach

            <!-- New plan editors appended here by JS -->
            <div id="plan-editors-container"></div>

        </div>
    </form>
</div>

<!-- ============================== COUPONS TAB ============================== -->
<div class="cms-tab-content" id="tab-coupons">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
        <div class="section-title" style="margin:0">Discount Coupons</div>
        <button type="button" class="btn btn-primary btn-sm" onclick="openModal('add-coupon-modal')">
            <i class="ri-add-line"></i> New Coupon
        </button>
    </div>

    <div class="coupon-search-bar">
        <div style="position:relative;flex:1;max-width:260px">
            <i class="ri-search-line" style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--text4);font-size:.85rem"></i>
            <input class="inp" id="coupon-search" placeholder="Search code, type…"
                style="padding-left:32px" oninput="couponSearch()">
        </div>
        <span id="coupon-count-label" style="font-size:.72rem;color:var(--text3);margin-left:2px"></span>
    </div>

    <div class="card" style="padding:0;overflow:hidden">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Discount Type</th>
                    <th>Discount Value</th>
                    <th>Expiry Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="coupon-table-body"></tbody>
        </table>
        <div class="cpn-pagination" id="coupon-pagination"></div>
    </div>
</div>

<!-- ── Add Coupon Modal ── -->
<div class="modal-bg" id="add-coupon-modal">
    <div class="modal-box" style="max-width:480px">
        <div class="modal-header">
            <h3 class="font-jakarta" style="font-weight:700;font-size:.95rem">
                <i class="ri-coupon-line" style="color:var(--purple);margin-right:6px"></i>New Coupon
            </h3>
            <button class="modal-close" onclick="closeModal('add-coupon-modal')"><i class="ri-close-line"></i></button>
        </div>
        <div class="field-group">
            <label class="label">Coupon Code <span style="color:#ef4444">*</span></label>
            <input class="inp" id="coupon-code" placeholder="e.g. SAVE20" style="text-transform:uppercase"
                oninput="clearOneError('coupon-code','add-code-err')">
            <small class="coupon-error-msg" id="add-code-err"></small>
        </div>
        <div class="g2">
            <div class="field-group">
                <label class="label">Discount Type</label>
                <select class="inp" id="coupon-type">
                    <option value="percentage">percentage (%)</option>
                    <option value="fixed">Fixed Amount (£)</option>
                </select>
            </div>
            <div class="field-group">
                <label class="label">Discount Value <span style="color:#ef4444">*</span></label>
                <input class="inp" id="coupon-val" type="number" placeholder="e.g. 20"
                    oninput="clearOneError('coupon-val','add-val-err')">
                <small class="coupon-error-msg" id="add-val-err"></small>
            </div>
        </div>
        <div class="g2">
            <div class="field-group">
                <label class="label">Expiry Date</label>
                <input class="inp" id="coupon-expiry" type="date"
                    oninput="clearOneError('coupon-expiry','add-expiry-err')">
                <small class="coupon-error-msg" id="add-expiry-err"></small>
            </div>
            <div class="field-group">
                <label class="label">Status</label>
                <select class="inp" id="coupon-status">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>
        </div>
        <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:8px">
            <button type="button" class="btn btn-ghost btn-sm" onclick="closeModal('add-coupon-modal')">Cancel</button>
            <button type="button" class="btn btn-primary btn-sm" onclick="createCoupon()">
                <i class="ri-check-line"></i> Create Coupon
            </button>
        </div>
    </div>
</div>

<!-- ── Edit Coupon Modal ── -->
<div class="modal-bg" id="edit-coupon-modal">
    <div class="modal-box" style="max-width:480px">
        <div class="modal-header">
            <h3 class="font-jakarta" style="font-weight:700;font-size:.95rem">
                <i class="ri-edit-line" style="color:var(--blue);margin-right:6px"></i>Edit Coupon
            </h3>
            <button class="modal-close" onclick="closeModal('edit-coupon-modal')"><i class="ri-close-line"></i></button>
        </div>
        <input type="hidden" id="edit-coupon-id">
        <div class="field-group">
            <label class="label">Coupon Code <span style="color:#ef4444">*</span></label>
            <input class="inp" id="edit-coupon-code" placeholder="e.g. SAVE20" style="text-transform:uppercase"
                oninput="clearOneError('edit-coupon-code','edit-code-err')">
            <small class="coupon-error-msg" id="edit-code-err"></small>
        </div>
        <div class="g2">
            <div class="field-group">
                <label class="label">Discount Type</label>
                <select class="inp" id="edit-coupon-type">
                    <option value="percentage">percentage (%)</option>
                    <option value="fixed">Fixed Amount (£)</option>
                </select>
            </div>
            <div class="field-group">
                <label class="label">Discount Value <span style="color:#ef4444">*</span></label>
                <input class="inp" id="edit-coupon-val" type="number" placeholder="e.g. 20"
                    oninput="clearOneError('edit-coupon-val','edit-val-err')">
                <small class="coupon-error-msg" id="edit-val-err"></small>
            </div>
        </div>
        <div class="g2">
            <div class="field-group">
                <label class="label">Expiry Date</label>
                <input class="inp" id="edit-coupon-expiry" type="date"
                    oninput="clearOneError('edit-coupon-expiry','edit-expiry-err')">
                <small class="coupon-error-msg" id="edit-expiry-err"></small>
            </div>
            <div class="field-group">
                <label class="label">Status</label>
                <select class="inp" id="edit-coupon-status">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>
        </div>
        <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:8px">
            <button type="button" class="btn btn-ghost btn-sm" onclick="closeModal('edit-coupon-modal')">Cancel</button>
            <button type="button" class="btn btn-primary btn-sm" onclick="updateCoupon()">
                <i class="ri-check-line"></i> Update Coupon
            </button>
        </div>
    </div>
</div>

<script>
/* ═══════════════════════════════════════════════
   CONFIG
═══════════════════════════════════════════════ */
var globalCurrency  = '£';
var planCount       = {{ count($plans) }};  // next available index
var SAVE_PLAN_URL   = "{{ route('save.plan') }}";
var DELETE_PLAN_URL = "{{ url('/admin/delete-plan') }}";
var COUPON_URL      = "{{ url('/admin/coupons') }}";
var CSRF            = document.querySelector('meta[name="csrf-token"]').content;

/* ═══════════════════════════════════════════════
   TAB SWITCHING
═══════════════════════════════════════════════ */
function switchTab(t) {
    document.querySelectorAll('.cms-tab-content').forEach(c => c.classList.remove('active'));
    document.querySelectorAll('.cms-tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + t).classList.add('active');
    document.getElementById('tab-btn-' + t).classList.add('active');
    if (t === 'coupons') loadCoupons();
}

/* ═══════════════════════════════════════════════
   PLAN TAB SWITCHING
═══════════════════════════════════════════════ */
function switchPlan(idx, btn) {
    document.querySelectorAll('.plan-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.plan-editor').forEach(e => e.classList.remove('active'));
    if (btn) btn.classList.add('active');
    var ed = document.getElementById('plan-editor-' + idx);
    if (ed) ed.classList.add('active');
}

function syncPlanTab(idx) {
    var inp = document.querySelector('.plan-name-inp[data-plan="' + idx + '"]');
    var tab = document.getElementById('plan-tab-' + idx);
    if (!inp || !tab) return;
    // preserve dot and close span, only update text node
    var dot   = tab.querySelector('.plan-color-dot');
    var close = tab.querySelector('.plan-tab-close');
    tab.innerHTML = '';
    if (dot) tab.appendChild(dot);
    tab.appendChild(document.createTextNode(' ' + (inp.value.trim() || 'New Plan') + ' '));
    if (close) tab.appendChild(close);
}

function syncPlanColor(idx, color) {
    var dot = document.querySelector('#plan-tab-' + idx + ' .plan-color-dot');
    if (dot) dot.style.background = color;
    var txt = document.getElementById('color-text-' + idx);
    if (txt) txt.value = color;
}

function calcTotal(planIdx) {
    var priceEl = document.getElementById('p' + planIdx + '-price');
    var vatEl   = document.getElementById('p' + planIdx + '-vat');
    var totalEl = document.getElementById('p' + planIdx + '-total');
    if (!priceEl || !vatEl || !totalEl) return;
    var total = (parseFloat(priceEl.value) || 0) + (parseFloat(vatEl.value) || 0);
    totalEl.textContent = globalCurrency + total.toFixed(2);
}

/* ═══════════════════════════════════════════════
   FEATURE HELPERS
═══════════════════════════════════════════════ */
function reindexFeatures(listId) {
    var list = document.getElementById(listId);
    if (!list) return;
    list.querySelectorAll('.sortable-item').forEach(function(item, i) {
        var s = item.querySelector('.feature-serial');
        if (s) s.textContent = i + 1;
    });
}

function addFeature(listId) {
    var list = document.getElementById(listId);
    if (!list) return;
    var count = list.querySelectorAll('.sortable-item').length + 1;
    // derive plan index from listId e.g. "features-3" → "3"
    var planIdx = listId.replace('features-', '');
    var d = document.createElement('div');
    d.className = 'sortable-item';
    d.innerHTML =
        '<span class="feature-serial">' + count + '</span>' +
        '<input class="inp feature-inp" name="features[' + planIdx + '][]" placeholder="New feature..." style="flex:1">' +
        '<button type="button" class="btn btn-ghost btn-sm" onclick="toggleFeatureEdit(this)"><i class="ri-edit-line"></i></button>' +
        '<button type="button" class="btn btn-danger btn-sm" onclick="removeFeature(this,\'' + listId + '\')"><i class="ri-delete-bin-line"></i></button>';
    list.appendChild(d);
    var inp = d.querySelector('.feature-inp');
    inp.removeAttribute('readonly');
    inp.focus();
}

function toggleFeatureEdit(btn) {
    var inp  = btn.closest('.sortable-item').querySelector('.feature-inp');
    var icon = btn.querySelector('i');
    if (inp.hasAttribute('readonly')) {
        inp.removeAttribute('readonly');
        inp.focus();
        icon.className = 'ri-check-line';
        btn.classList.remove('btn-ghost');
        btn.classList.add('btn-primary');
    } else {
        inp.setAttribute('readonly', '');
        icon.className = 'ri-edit-line';
        btn.classList.remove('btn-primary');
        btn.classList.add('btn-ghost');
    }
}

function removeFeature(btn, listId) {
    btn.closest('.sortable-item').remove();
    reindexFeatures(listId);
}

/* ═══════════════════════════════════════════════
   ADD NEW PLAN (client-side only until Save)
═══════════════════════════════════════════════ */
function addNewPlan() {
    var idx    = planCount++;
    var colors = ['#f59e0b','#ef4444','#8b5cf6','#ec4899','#14b8a6'];
    var color  = colors[idx % colors.length];

    /* ── create tab pill ── */
    var bar    = document.getElementById('plan-tab-bar');
    var addBtn = bar.querySelector('.add-plan-btn');
    var tab    = document.createElement('button');
    tab.type      = 'button';
    tab.className = 'plan-tab';
    tab.id        = 'plan-tab-' + idx;
    tab.innerHTML =
        '<span class="plan-color-dot" style="background:' + color + '"></span>' +
        ' New Plan ' +
        '<span class="plan-tab-close" onclick="deletePlan(null, event, ' + idx + ')"><i class="ri-close-line"></i></span>';
    tab.onclick = function() { switchPlan(idx, tab); };
    bar.insertBefore(tab, addBtn);

    /* ── create editor ── */
    var editor = document.createElement('div');
    editor.className = 'plan-editor';
    editor.id        = 'plan-editor-' + idx;
    editor.innerHTML =
        '<input type="hidden" name="plan_id[]" value="">' +
        '<div class="g2">' +
            '<div class="field-group">' +
                '<label class="label">Plan Name <span style="color:#ef4444">*</span></label>' +
                '<input class="inp plan-name-inp" name="plan_name[]" data-plan="' + idx + '" placeholder="Enter Plan Name"' +
                '       oninput="syncPlanTab(' + idx + '); hideError(this)">' +
                '<small class="error-msg"></small>' +
            '</div>' +
            '<div class="field-group">' +
                '<label class="label">Plan Icon (Remix Icon class)</label>' +
                '<input class="inp" name="icon[]" placeholder="ri-star-line">' +
            '</div>' +
        '</div>' +
        '<div class="g2">' +
            '<div class="field-group">' +
                '<label class="label">Accent Color</label>' +
                '<div style="display:flex;gap:8px;align-items:center;margin-top:4px">' +
                    '<input type="color" class="plan-color-inp" data-plan="' + idx + '" value="' + color + '"' +
                    '       oninput="syncPlanColor(' + idx + ', this.value)"' +
                    '       style="width:38px;height:38px;border:none;background:transparent;cursor:pointer;border-radius:8px">' +
                    '<input class="inp" id="color-text-' + idx + '" value="' + color + '" readonly style="flex:1;font-family:monospace">' +
                '</div>' +
            '</div>' +
            '<div class="field-group">' +
                '<label class="label">Price <span style="color:#ef4444">*</span></label>' +
                '<input class="inp" type="number" step="0.01" name="price[]" id="p' + idx + '-price" value="0"' +
                '       oninput="calcTotal(' + idx + '); hideError(this)">' +
                '<small class="error-msg"></small>' +
            '</div>' +
        '</div>' +
        '<div class="g2">' +
            '<div class="field-group">' +
                '<label class="label">VAT</label>' +
                '<input class="inp" type="number" step="0.01" name="vat[]" id="p' + idx + '-vat" value="0"' +
                '       oninput="calcTotal(' + idx + ')">' +
            '</div>' +
            '<div class="field-group">' +
                '<label class="label">Total Price</label>' +
                '<div class="total-price-box" id="p' + idx + '-total">£0.00</div>' +
            '</div>' +
        '</div>' +
        '<div class="field-group">' +
            '<label class="label">Description</label>' +
            '<input type="text" class="inp" name="description[]" placeholder="Short description">' +
        '</div>' +
        '<div class="field-group hidden">' +
            '<label class="label">Expiry Date</label>' +
            '<input type="date" class="inp" name="expiry_date[]">' +
            '<small class="error-msg"></small>' +
        '</div>' +
        '<div class="field-group hidden">' +
            '<label class="label">Status</label>' +
            '<select class="inp" name="status[]">' +
                '<option value="Active">Active</option>' +
                '<option value="Inactive">Inactive</option>' +
            '</select>' +
        '</div>' +
        '<div style="display:flex;justify-content:space-between;margin:10px 0">' +
            '<label class="label">Features</label>' +
            '<button type="button" class="btn btn-ghost btn-sm" onclick="addFeature(\'features-' + idx + '\')">' +
                '<i class="ri-add-line"></i> Add Feature' +
            '</button>' +
        '</div>' +
        '<div id="features-' + idx + '">' +
            '<div class="sortable-item">' +
                '<span class="feature-serial">1</span>' +
                '<input class="inp feature-inp" name="features[' + idx + '][]" placeholder="Feature name..." style="flex:1">' +
                '<button type="button" class="btn btn-ghost btn-sm" onclick="toggleFeatureEdit(this)"><i class="ri-edit-line"></i></button>' +
                '<button type="button" class="btn btn-danger btn-sm" onclick="removeFeature(this,\'features-' + idx + '\')"><i class="ri-delete-bin-line"></i></button>' +
            '</div>' +
        '</div>';

    /* ── append editor to the container INSIDE the form ── */
    document.getElementById('plan-editors-container').appendChild(editor);

    /* ── switch to new tab AFTER DOM is updated ── */
    switchPlan(idx, tab);
    calcTotal(idx);
    toast?.('New plan added!', 'success');
}

/* ═══════════════════════════════════════════════
   DELETE PLAN
   - existing DB plans: dbId = numeric id, clientIdx = blade key
   - new client-only plans: dbId = null, clientIdx = planCount index
═══════════════════════════════════════════════ */
function deletePlan(dbId, event, clientIdx) {
    event.stopPropagation();
    if (!confirm('Delete this plan?')) return;

    function doRemove(idx) {
        var tab = document.getElementById('plan-tab-' + idx);
        var ed  = document.getElementById('plan-editor-' + idx);
        if (tab) tab.remove();
        if (ed)  ed.remove();
        // switch to first remaining tab
        var firstTab = document.querySelector('.plan-tab');
        if (firstTab) {
            var firstIdx = firstTab.id.replace('plan-tab-', '');
            switchPlan(firstIdx, firstTab);
        }
        toast?.('Plan deleted', 'info');
    }

    if (dbId) {
        fetch(DELETE_PLAN_URL + '/' + dbId, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(function(data) {
            if (data.status) {
                doRemove(clientIdx);
            } else {
                toast?.('Delete failed: ' + (data.message || ''), 'error');
            }
        })
        .catch(function() { toast?.('Server error', 'error'); });
    } else {
        doRemove(clientIdx);
    }
}

/* ═══════════════════════════════════════════════
   SAVE ALL PLANS
═══════════════════════════════════════════════ */
function saveAll() {
    var form     = document.getElementById('plan-form');
    var formData = new FormData(form);

    // clear previous errors
    document.querySelectorAll('#plan-form .error-msg').forEach(el => el.textContent = '');
    document.querySelectorAll('#plan-form .inp').forEach(el => el.style.borderColor = '');

    fetch(SAVE_PLAN_URL, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': CSRF },
        body: formData
    })
    .then(async function(response) {
        var data = await response.json();

        if (!response.ok) {
            if (data.errors) {
                // Laravel errors keyed as "plan_name.0", "price.2" etc.
                Object.entries(data.errors).forEach(function([key, msgs]) {
                    var parts = key.split('.');
                    var field = parts[0];       // e.g. "plan_name"
                    var index = parseInt(parts[1], 10); // e.g. 0

                    var inputs = document.querySelectorAll('#plan-form [name="' + field + '[]"]');
                    var input  = inputs[index];

                    if (input) {
                        input.style.borderColor = '#ef4444';
                        var errEl = input.parentElement.querySelector('.error-msg');
                        if (errEl) errEl.textContent = msgs[0];

                        // auto-switch to the tab that has this error
                        // find the enclosing plan-editor and its index
                        var editor = input.closest('.plan-editor');
                        if (editor) {
                            var edIdx = editor.id.replace('plan-editor-', '');
                            var planTab = document.getElementById('plan-tab-' + edIdx);
                            if (planTab) switchPlan(edIdx, planTab);
                        }
                    }
                });
            }
            toast?.('Validation failed — please fix the errors', 'error');
            return;
        }
        toast?.(data.message, 'success');
    })
    .catch(function() { toast?.('Server error', 'error'); });
}

function hideError(el) {
    var errEl = el.parentElement.querySelector('.error-msg');
    if (errEl) errEl.textContent = '';
    el.style.borderColor = '';
}

/* ═══════════════════════════════════════════════
   COUPON CRUD
═══════════════════════════════════════════════ */
var cpnPage    = 1;
var cpnPerPage = 5;
var cpnFilter  = '';
var cpnAll     = [];

function loadCoupons() {
    fetch(COUPON_URL, {
        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
    })
    .then(r => r.json())
    .then(function(data) {
        cpnAll  = (data.coupons || []).map(formatCoupon);
        cpnPage = 1;
        renderCoupons();
    })
    .catch(function() { toast?.('Failed to load coupons', 'error'); });
}

function formatCoupon(c) {
    var dispVal   = c.coupon_type === 'percentage'
        ? c.discount + '%'
        : '£' + parseFloat(c.discount).toFixed(2);
    var typeLabel = c.coupon_type === 'percentage' ? 'Percentage' : 'Fixed Amount';
    var badgeCls  = c.coupon_type === 'percentage' ? 'badge-green' : 'badge-amber';
    var rawExpiry = c.expiry_date ? c.expiry_date.substring(0, 10) : '';
    var dispExp   = rawExpiry
        ? new Date(rawExpiry + 'T00:00:00').toLocaleDateString('en-GB', { day:'numeric', month:'short', year:'numeric' })
        : '—';
    var statusCls = c.status === 'Active' ? 'badge-green' : 'badge-red';
    return {
        id: c.id, code: c.code,
        typeLabel: typeLabel, dispVal: dispVal, badgeCls: badgeCls,
        expiry: dispExp, status: c.status, statusCls: statusCls,
        _rawVal: c.discount, _type: c.coupon_type, _expiryRaw: rawExpiry
    };
}

function couponRowHTML(c) {

    var today = new Date();

    var expiryDate = c.expiry
        ? new Date(c.expiry)
        : null;

    var statusText = '';
    var statusStyle = '';

    // EXPIRED FIRST
    if (expiryDate && expiryDate < today) {

        statusText = 'Expired';

        statusStyle =
            'background:#FEF3C7;color:#D97706;border:1px solid #FCD34D;';

    }
    else if (
        String(c.status).toLowerCase() === 'active'
    ) {

        statusText = 'Active';

        statusStyle =
            'background:#DCFCE7;color:#059669;border:1px solid #86EFAC;';

    }
    else {

        statusText = 'Inactive';

        statusStyle =
            'background:#FEE2E2;color:#DC2626;border:1px solid #FCA5A5;';
    }

    return '<tr>' +

        '<td><div style="font-weight:700;font-family:monospace;letter-spacing:.08em">' +
            c.code +
        '</div></td>' +

        '<td><span style="font-size:.78rem;color:var(--text3)">' +
            c.typeLabel +
        '</span></td>' +

        '<td><span class="badge ' + c.badgeCls + '">' +
            c.dispVal +
        '</span></td>' +

        '<td><span style="font-size:.78rem;color:var(--text3)">' +
            c.expiry +
        '</span></td>' +

        '<td><span class="badge" style="' + statusStyle + '">' +
            statusText +
        '</span></td>' +

        '<td><div style="display:flex;gap:4px">' +

            '<button type="button" class="btn btn-ghost btn-sm" onclick="editCoupon(' + c.id + ')">' +
                '<i class="ri-edit-line"></i>' +
            '</button>' +

            '<button type="button" class="btn btn-danger btn-sm" onclick="deleteCoupon(' + c.id + ')">' +
                '<i class="ri-delete-bin-line"></i>' +
            '</button>' +

        '</div></td>' +

    '</tr>';
}
function renderCoupons() {
    var filtered = cpnAll.filter(function(c) {
        if (!cpnFilter) return true;
        var q = cpnFilter.toLowerCase();
        return c.code.toLowerCase().includes(q) ||
               c.typeLabel.toLowerCase().includes(q) ||
               c.status.toLowerCase().includes(q);
    });
    var total = filtered.length;
    var pages = Math.max(1, Math.ceil(total / cpnPerPage));
    if (cpnPage > pages) cpnPage = pages;
    var slice = filtered.slice((cpnPage - 1) * cpnPerPage, cpnPage * cpnPerPage);

    document.getElementById('coupon-table-body').innerHTML = slice.length
        ? slice.map(couponRowHTML).join('')
        : '<tr><td colspan="6" style="text-align:center;padding:28px;color:var(--text4);font-size:.8rem">' +
          '<i class="ri-coupon-line" style="display:block;font-size:1.6rem;margin-bottom:6px;opacity:.3"></i>No coupons found</td></tr>';

    document.getElementById('coupon-count-label').textContent =
        total + ' coupon' + (total !== 1 ? 's' : '') + (cpnFilter ? ' found' : '');

    var pag   = document.getElementById('coupon-pagination');
    if (pages <= 1) { pag.innerHTML = ''; return; }
    var html  = '<span class="cpn-page-info">Page ' + cpnPage + ' of ' + pages + '</span>';
    html += '<button class="cpn-page-btn" onclick="cpnGoPage(' + (cpnPage - 1) + ')"' +
            (cpnPage === 1 ? ' disabled style="opacity:.35;cursor:default"' : '') + '>&#8249;</button>';
    for (var p = 1; p <= pages; p++) {
        html += '<button class="cpn-page-btn' + (p === cpnPage ? ' active' : '') + '" onclick="cpnGoPage(' + p + ')">' + p + '</button>';
    }
    html += '<button class="cpn-page-btn" onclick="cpnGoPage(' + (cpnPage + 1) + ')"' +
            (cpnPage === pages ? ' disabled style="opacity:.35;cursor:default"' : '') + '>&#8250;</button>';
    pag.innerHTML = html;
}

function cpnGoPage(p) {
    var pages = Math.max(1, Math.ceil(cpnAll.length / cpnPerPage));
    if (p < 1 || p > pages) return;
    cpnPage = p;
    renderCoupons();
}

function couponSearch() {
    cpnFilter = document.getElementById('coupon-search').value.trim();
    cpnPage   = 1;
    renderCoupons();
}

/* ── Create coupon ── */
function createCoupon() {
    var code   = document.getElementById('coupon-code').value.trim().toUpperCase();
    var type   = document.getElementById('coupon-type').value;
    var val    = document.getElementById('coupon-val').value.trim();
    var expiry = document.getElementById('coupon-expiry').value;
    var status = document.getElementById('coupon-status').value;

    // clear errors
    clearOneError('coupon-code',   'add-code-err');
    clearOneError('coupon-val',    'add-val-err');
    clearOneError('coupon-expiry', 'add-expiry-err');

    fetch(COUPON_URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            code: code,
            coupon_type: type,
            discount: val,
            expiry_date: expiry || null,
            status: status
        })
    })
    .then(async function(r) {
        var data = await r.json();
        if (!r.ok) {
            showCouponErrors(data.errors, {
                code:           { inputId: 'coupon-code',   errId: 'add-code-err'   },
                discount: { inputId: 'coupon-val',    errId: 'add-val-err'    },
                expiry_date:    { inputId: 'coupon-expiry', errId: 'add-expiry-err' }
            });
            return;
        }
        cpnAll.unshift(formatCoupon(data.coupon));
        document.getElementById('coupon-code').value   = '';
        document.getElementById('coupon-val').value    = '';
        document.getElementById('coupon-expiry').value = '';
        closeModal('add-coupon-modal');
        cpnPage = 1;
        renderCoupons();
       toast?.(data.message, 'success');
    })
    .catch(function() { toast?.('Server error', 'error'); });
}

/* ── Open edit coupon modal ── */
function editCoupon(id) {
    var c = cpnAll.find(function(x) { return x.id === id; });
    if (!c) return;
    document.getElementById('edit-coupon-id').value      = id;
    document.getElementById('edit-coupon-code').value    = c.code;
    document.getElementById('edit-coupon-val').value     = c._rawVal;
    document.getElementById('edit-coupon-type').value    = c._type;
    document.getElementById('edit-coupon-status').value  = c.status;
    document.getElementById('edit-coupon-expiry').value  = c._expiryRaw;
    // clear stale errors
    clearOneError('edit-coupon-code',   'edit-code-err');
    clearOneError('edit-coupon-val',    'edit-val-err');
    clearOneError('edit-coupon-expiry', 'edit-expiry-err');
    openModal('edit-coupon-modal');
}

/* ── Update coupon ── */
function updateCoupon() {
    var id     = document.getElementById('edit-coupon-id').value;
    var code   = document.getElementById('edit-coupon-code').value.trim().toUpperCase();
    var type   = document.getElementById('edit-coupon-type').value;
    var val    = document.getElementById('edit-coupon-val').value.trim();
    var expiry = document.getElementById('edit-coupon-expiry').value;
    var status = document.getElementById('edit-coupon-status').value;

    clearOneError('edit-coupon-code',   'edit-code-err');
    clearOneError('edit-coupon-val',    'edit-val-err');
    clearOneError('edit-coupon-expiry', 'edit-expiry-err');

    fetch(COUPON_URL + '/' + id, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            code: code,
            coupon_type: type,
            discount: val,
            expiry_date: expiry || null,
            status: status
        })
    })
    .then(async function(r) {
        var data = await r.json();
        if (!r.ok) {
            showCouponErrors(data.errors, {
                code:           { inputId: 'edit-coupon-code',   errId: 'edit-code-err'   },
                discount: { inputId: 'edit-coupon-val',    errId: 'edit-val-err'    },
                expiry_date:    { inputId: 'edit-coupon-expiry', errId: 'edit-expiry-err' }
            });
            return;
        }
        var idx = cpnAll.findIndex(function(x) { return x.id == id; });
        if (idx !== -1) cpnAll[idx] = formatCoupon(data.coupon);
        closeModal('edit-coupon-modal');
        renderCoupons();
        toast?.('"' + code + '" updated!', 'success');
    })
    .catch(function() { toast?.('Server error', 'error'); });
}

/* ── Delete coupon ── */
function deleteCoupon(id) {
    openConfirm(
        'Delete this coupon?',
        function () {
            fetch(COUPON_URL + '/' + id, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json'
                }
            })
            .then(r => r.json())
            .then(function(data) {
                if (data.status) {
                    cpnAll = cpnAll.filter(x => x.id !== id);
                    renderCoupons();
                    toast?.(data.message || 'Coupon deleted','info');
                } else {
                    toast?.(data.message || 'Delete failed','error');
                }

            })
            .catch(function() {

                toast?.('Server error', 'error');

            });

        }
    );
}
/* ── Coupon error helpers ── */
function showCouponErrors(errors, fieldMap) {
    if (!errors) return;
    Object.entries(errors).forEach(function([key, msgs]) {
        var mapping = fieldMap[key];
        if (!mapping) return;
        var inp = document.getElementById(mapping.inputId);
        var err = document.getElementById(mapping.errId);
        if (inp) inp.style.borderColor = '#ef4444';
        if (err) err.textContent = msgs[0];
    });
    toast?.('Please fix the errors', 'error');
}

function clearOneError(inputId, errId) {
    var inp = document.getElementById(inputId);
    var err = document.getElementById(errId);
    if (inp) inp.style.borderColor = '';
    if (err) err.textContent = '';
}

/* ── Init ── */
document.addEventListener('DOMContentLoaded', function() {
    @foreach($plans as $key => $plan)
        calcTotal({{ $key }});
    @endforeach
});
</script>

@endsection