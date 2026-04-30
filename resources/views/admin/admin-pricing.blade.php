@extends('admin.layouts.app')
@section('content')

<style>
.cms-tab-btn{padding:10px 18px;background:transparent;border:none;color:var(--text3);font-size:.8rem;font-weight:600;cursor:pointer;border-bottom:2px solid transparent;transition:all .2s;display:flex;align-items:center;gap:6px}
.cms-tab-btn:hover{color:var(--text2)}.cms-tab-btn.active{color:var(--purple);border-bottom-color:var(--purple)}
.cms-tab-content{display:none}.cms-tab-content.active{display:block}
.field-group{margin-bottom:16px}
.field-group .label{margin-bottom:6px;display:block;font-size:.75rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em}
.inp-area{width:100%;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:10px 14px;color:var(--text);font-size:.85rem;resize:vertical;font-family:inherit;transition:border-color .2s}
.inp-area:focus{outline:none;border-color:var(--purple)}
.section-card{background:var(--card);border:1px solid var(--border);border-radius:var(--radius);padding:20px;margin-bottom:14px}
.char-count{font-size:.68rem;color:var(--text4);text-align:right;margin-top:4px}.char-count.warn{color:var(--amber)}.char-count.bad{color:var(--red)}
.seo-score{display:flex;align-items:center;gap:10px;padding:14px 18px;border-radius:12px;background:rgba(16,185,129,.06);border:1px solid rgba(16,185,129,.15);margin-bottom:16px}
.seo-score-circle{width:52px;height:52px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.8rem;font-weight:800;color:var(--green);flex-shrink:0}
.toggle-switch{position:relative;width:40px;height:22px;flex-shrink:0}
.toggle-switch input{opacity:0;width:0;height:0}
.toggle-slider{position:absolute;inset:0;background:var(--ctrl-bg);border-radius:22px;cursor:pointer;transition:.3s}
.toggle-slider::before{content:'';position:absolute;width:16px;height:16px;left:3px;top:3px;background:var(--text);border-radius:50%;transition:.3s}
.toggle-switch input:checked+.toggle-slider{background:var(--purple)}
.toggle-switch input:checked+.toggle-slider::before{transform:translateX(18px)}
.sortable-item{display:flex;align-items:center;gap:10px;padding:10px 14px;background:var(--row-bg);border:1px solid var(--border);border-radius:var(--radius-sm);cursor:grab;margin-bottom:8px}
.drag-handle{color:var(--text4);font-size:1.1rem;flex-shrink:0}

/* ---- Multi-Plan Styles ---- */
.plan-tab-bar{display:flex;gap:6px;align-items:center;margin-bottom:18px;flex-wrap:wrap}
.plan-tab{padding:7px 16px;border-radius:100px;font-size:.78rem;font-weight:700;cursor:pointer;border:1px solid var(--border);background:var(--row-bg);color:var(--text3);transition:all .2s;display:flex;align-items:center;gap:6px;white-space:nowrap}
.plan-tab:hover{border-color:rgba(124,58,237,.3);color:var(--text2)}
.plan-tab.active{background:rgba(124,58,237,.15);border-color:rgba(124,58,237,.35);color:var(--purple-light)}
.plan-tab .plan-tab-close{width:16px;height:16px;border-radius:50%;background:var(--ctrl-bg);display:flex;align-items:center;justify-content:center;font-size:.6rem;flex-shrink:0;transition:background .2s}
.plan-tab .plan-tab-close:hover{background:rgba(239,68,68,.3);color:#fca5a5}
.plan-editor{display:none}.plan-editor.active{display:block}
.add-plan-btn{padding:7px 14px;border-radius:100px;font-size:.78rem;font-weight:700;cursor:pointer;border:1px dashed rgba(124,58,237,.4);background:transparent;color:rgba(124,58,237,.7);transition:all .2s;display:flex;align-items:center;gap:5px}
.add-plan-btn:hover{border-color:rgba(124,58,237,.8);color:var(--purple-light);background:rgba(124,58,237,.08)}

.price-preview{background:linear-gradient(135deg,rgba(124,58,237,.12),rgba(6,182,212,.06));border:1px solid rgba(124,58,237,.25);border-radius:24px;padding:24px;text-align:center;margin-bottom:12px;position:relative}
.price-preview .plan-badge-indicator{position:absolute;top:10px;right:10px;font-size:.6rem;font-weight:800;padding:3px 8px;border-radius:100px;background:rgba(124,58,237,.2);color:var(--purple-light);border:1px solid rgba(124,58,237,.3)}

.popular-badge{display:inline-flex;align-items:center;gap:5px;padding:4px 12px;border-radius:100px;font-size:.65rem;font-weight:800;background:linear-gradient(135deg,var(--purple),var(--cyan));color:var(--text2);margin-bottom:10px;text-transform:uppercase;letter-spacing:.05em}

.plan-color-dot{width:10px;height:10px;border-radius:50%;flex-shrink:0}

.billing-toggle-wrap{display:flex;align-items:center;gap:10px;padding:10px 14px;background:var(--bg2);border:1px solid var(--border2);border-radius:var(--radius-sm);margin-bottom:16px}

.coupon-row{display:grid;grid-template-columns:1fr 120px 120px auto;gap:8px;align-items:center;padding:10px 14px;background:var(--bg2);border:1px solid var(--border2);border-radius:var(--radius-sm);margin-bottom:6px}

.plan-sort-item{display:flex;align-items:center;gap:12px;padding:12px 16px;background:var(--row-bg);border:1px solid var(--border);border-radius:12px;margin-bottom:8px;cursor:grab}
.plan-sort-color{width:32px;height:32px;border-radius:var(--radius-xs);flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:800;color:var(--text2)}
</style>

<div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px">
    <div>
        <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800">Pricing Module</h2>
        <p style="font-size:.8rem;color:var(--text3);margin-top:3px">Manage multiple plans, features, hero content and SEO</p>
    </div>
    <div style="display:flex;gap:8px">
        <a href="pricing" target="_blank" class="btn btn-ghost btn-sm"><i class="ri-eye-line"></i> Preview</a>
        <button class="btn btn-primary btn-sm" onclick="saveAll()"><i class="ri-save-line"></i> Save & Publish</button>
    </div>
</div>

<!-- Page Tabs -->
<div style="display:flex;gap:8px;margin-bottom:20px;border-bottom:2px solid rgba(255,255,255,.05)">
    <button class="cms-tab-btn active" onclick="switchTab('plans')" id="tab-btn-plans"><i class="ri-price-tag-3-line"></i> Plans</button>
    <button class="cms-tab-btn" onclick="switchTab('hero')" id="tab-btn-hero"><i class="ri-flag-line"></i> Hero</button>
    <button class="cms-tab-btn" onclick="switchTab('coupons')" id="tab-btn-coupons"><i class="ri-coupon-line"></i> Coupons</button>
    <button class="cms-tab-btn" onclick="switchTab('seo')" id="tab-btn-seo"><i class="ri-search-eye-line"></i> SEO</button>
</div>

<!-- ============================== PLANS TAB ============================== -->
<div class="cms-tab-content active" id="tab-plans">

    <!-- Global Settings -->
    <div class="section-card" style="margin-bottom:18px">
        <div class="section-title" style="margin-bottom:14px"><i class="ri-settings-3-line" style="color:var(--purple)"></i> Global Plan Settings</div>
        <div class="g2">
            <div class="field-group">
                <label class="label">Layout Style</label>
                <select class="inp" id="layout-style" onchange="updateAllPreviews()">
                    <option value="cards">Side-by-Side Cards</option>
                    <option value="toggle">Toggle (Monthly / Annual)</option>
                    <option value="single">Single Plan (Spotlight)</option>
                    <option value="table">Comparison Table</option>
                </select>
            </div>
            <div class="field-group">
                <label class="label">Currency Symbol</label>
                <div style="display:flex;gap:6px;flex-wrap:wrap;margin-top:4px">
                    <button class="btn btn-primary btn-sm" onclick="setGlobalCurrency('£',this)">£ GBP</button>
                    <button class="btn btn-ghost btn-sm" onclick="setGlobalCurrency('$',this)">$ USD</button>
                    <button class="btn btn-ghost btn-sm" onclick="setGlobalCurrency('€',this)">€ EUR</button>
                    <button class="btn btn-ghost btn-sm" onclick="setGlobalCurrency('A$',this)">A$ AUD</button>
                </div>
            </div>
        </div>
        <div class="g2">
            <div class="field-group">
                <label class="label">Section Heading (before gradient)</label>
                <input class="inp" value="Everything.">
            </div>
            <div class="field-group">
                <label class="label">Heading Gradient Text</label>
                <input class="inp" value="One Price.">
            </div>
        </div>
        <div class="field-group">
            <label class="label">Section Description</label>
            <textarea class="inp-area inp" rows="2">No tiers. No hidden upgrades. No monthly charges. Just full access to DRemind for a simple annual fee.</textarea>
        </div>
        <div class="g2">
            <div class="field-group">
                <label class="label">Billing Toggle — Monthly Label</label>
                <input class="inp" value="Monthly" id="billing-monthly-label">
            </div>
            <div class="field-group">
                <label class="label">Billing Toggle — Annual Label</label>
                <input class="inp" value="Annual" id="billing-annual-label">
            </div>
        </div>
        <div class="billing-toggle-wrap">
            <label class="toggle-switch"><input type="checkbox" id="show-billing-toggle" checked><span class="toggle-slider"></span></label>
            <span style="font-size:.8rem;color:var(--text2);font-weight:600">Show billing period toggle on page</span>
            <span style="font-size:.72rem;color:var(--text4);margin-left:auto">Lets visitors switch between monthly and annual pricing</span>
        </div>
    </div>

    <!-- Plan Tabs Editor -->
    <div class="section-card">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;flex-wrap:wrap;gap:10px">
            <div class="section-title" style="margin:0"><i class="ri-layout-column-line" style="color:var(--accent)"></i> Plan Editor</div>
            <div style="display:flex;align-items:center;gap:8px">
                <span style="font-size:.72rem;color:var(--text4)">Drag plans below to reorder</span>
                <button class="btn btn-ghost btn-sm" onclick="openModal('reorder-plans-modal')"><i class="ri-drag-move-2-line"></i> Reorder</button>
            </div>
        </div>

        <!-- Plan Tabs -->
        <div class="plan-tab-bar" id="plan-tab-bar">
            <button class="plan-tab active" onclick="switchPlan(0,this)" id="plan-tab-0">
                <span class="plan-color-dot" style="background:#10b981"></span>
                Free
            </button>
            <button class="plan-tab" onclick="switchPlan(1,this)" id="plan-tab-1">
                <span class="plan-color-dot" style="background:#7c3aed"></span>
                Pro
                <span class="plan-tab-close" onclick="deletePlan(1,event)"><i class="ri-close-line"></i></span>
            </button>
            <button class="plan-tab" onclick="switchPlan(2,this)" id="plan-tab-2">
                <span class="plan-color-dot" style="background:#06b6d4"></span>
                Enterprise
                <span class="plan-tab-close" onclick="deletePlan(2,event)"><i class="ri-close-line"></i></span>
            </button>
            <button class="add-plan-btn" onclick="addNewPlan()"><i class="ri-add-line"></i> Add Plan</button>
        </div>

        <!-- Plan 0: Free -->
        <div class="plan-editor active" id="plan-editor-0">
            <div class="g2" style="align-items:start">
                <div style="flex:2">
                    <!-- Plan Identity -->
                    <div style="background:rgba(255,255,255,.015);border:1px solid rgba(255,255,255,.06);border-radius:12px;padding:16px;margin-bottom:12px">
                        <div style="font-size:.75rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;margin-bottom:12px">Plan Identity</div>
                        <div class="g2">
                            <div class="field-group"><label class="label">Plan Name</label><input class="inp plan-name-inp" data-plan="0" value="Free" oninput="syncPlanTab(0)"></div>
                            <div class="field-group"><label class="label">Plan Badge / Tagline</label><input class="inp" value="Get Started"></div>
                        </div>
                        <div class="g2">
                            <div class="field-group">
                                <label class="label">Accent Color</label>
                                <div style="display:flex;gap:8px;align-items:center;margin-top:4px">
                                    <input type="color" class="plan-color-inp" data-plan="0" value="#10b981" oninput="syncPlanColor(0,this.value)" style="width:38px;height:38px;border:none;background:transparent;cursor:pointer;border-radius:8px">
                                    <input class="inp" value="#10b981" style="flex:1;font-family:monospace">
                                </div>
                            </div>
                            <div class="field-group">
                                <label class="label">Is "Popular" / Highlighted?</label>
                                <div style="display:flex;align-items:center;gap:8px;margin-top:10px">
                                    <label class="toggle-switch"><input type="checkbox"><span class="toggle-slider"></span></label>
                                    <span style="font-size:.8rem;color:var(--text3)">Show "Most Popular" badge</span>
                                </div>
                            </div>
                        </div>
                        <div class="g2">
                            <div class="field-group"><label class="label">Popular Badge Text</label><input class="inp" value="Most Popular" placeholder="e.g. Best Value"></div>
                            <div class="field-group">
                                <label class="label">Plan Visibility</label>
                                <div style="display:flex;align-items:center;gap:8px;margin-top:10px">
                                    <label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label>
                                    <span style="font-size:.8rem;color:var(--text3)">Show on page</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing -->
                    <div style="background:rgba(255,255,255,.015);border:1px solid rgba(255,255,255,.06);border-radius:12px;padding:16px;margin-bottom:12px">
                        <div style="font-size:.75rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;margin-bottom:12px">Pricing</div>
                        <div class="g2">
                            <div class="field-group"><label class="label">Monthly Price (base)</label><input class="inp" id="p0-price-m" type="number" step="0.01" value="0.00" oninput="calcPlanTax(0,'m')"></div>
                            <div class="field-group"><label class="label">Annual Price (base)</label><input class="inp" id="p0-price-a" type="number" step="0.01" value="0.00" oninput="calcPlanTax(0,'a')"></div>
                        </div>
                        <div class="g2">
                            <div class="field-group"><label class="label">VAT Rate (%)</label><input class="inp" id="p0-vat" type="number" step="0.1" value="0" oninput="calcPlanTax(0,'m');calcPlanTax(0,'a')"></div>
                            <div class="field-group"><label class="label">Price Display Override</label><input class="inp" id="p0-override" placeholder="e.g. Free, Contact Us, Custom" value="Free"></div>
                        </div>
                        <div class="g2">
                            <div class="field-group"><label class="label">Period Label</label><input class="inp" value="/ month"></div>
                            <div class="field-group"><label class="label">Price Sub-label</label><input class="inp" value="No credit card required"></div>
                        </div>
                        <div class="g2">
                            <div class="field-group"><label class="label">Savings Label (annual)</label><input class="inp" placeholder="e.g. Save 20%"></div>
                            <div class="field-group"><label class="label">Trial Days</label><input class="inp" type="number" value="0" placeholder="0 = no trial"></div>
                        </div>
                    </div>

                    <!-- Features -->
                    <div style="background:rgba(255,255,255,.015);border:1px solid rgba(255,255,255,.06);border-radius:12px;padding:16px;margin-bottom:12px">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
                            <div style="font-size:.75rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em">Feature List</div>
                            <button class="btn btn-ghost btn-sm" onclick="addFeature('features-0')"><i class="ri-add-line"></i> Add Feature</button>
                        </div>
                        <div id="features-0">
                            <div class="sortable-item"><i class="ri-draggable drag-handle"></i><i class="ri-check-line" style="color:#10b981;font-size:1.1rem;flex-shrink:0"></i><input class="inp" value="Up to 5 reminders"><select class="inp" style="width:90px;flex-shrink:0"><option>✓ Check</option><option>✕ Cross</option><option>— Dash</option></select><div style="display:flex;align-items:center;gap:6px"><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label><button class="btn btn-danger btn-sm" onclick="this.closest('.sortable-item').remove()"><i class="ri-delete-bin-line"></i></button></div></div>
                            <div class="sortable-item"><i class="ri-draggable drag-handle"></i><i class="ri-check-line" style="color:#10b981;font-size:1.1rem;flex-shrink:0"></i><input class="inp" value="Email notifications"><select class="inp" style="width:90px;flex-shrink:0"><option>✓ Check</option><option>✕ Cross</option><option>— Dash</option></select><div style="display:flex;align-items:center;gap:6px"><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label><button class="btn btn-danger btn-sm" onclick="this.closest('.sortable-item').remove()"><i class="ri-delete-bin-line"></i></button></div></div>
                            <div class="sortable-item"><i class="ri-draggable drag-handle"></i><i class="ri-close-line" style="color:var(--red);font-size:1.1rem;flex-shrink:0"></i><input class="inp" value="Push notifications"><select class="inp" style="width:90px;flex-shrink:0"><option>✓ Check</option><option selected>✕ Cross</option><option>— Dash</option></select><div style="display:flex;align-items:center;gap:6px"><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label><button class="btn btn-danger btn-sm" onclick="this.closest('.sortable-item').remove()"><i class="ri-delete-bin-line"></i></button></div></div>
                            <div class="sortable-item"><i class="ri-draggable drag-handle"></i><i class="ri-close-line" style="color:var(--red);font-size:1.1rem;flex-shrink:0"></i><input class="inp" value="Priority support"><select class="inp" style="width:90px;flex-shrink:0"><option>✓ Check</option><option selected>✕ Cross</option><option>— Dash</option></select><div style="display:flex;align-items:center;gap:6px"><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label><button class="btn btn-danger btn-sm" onclick="this.closest('.sortable-item').remove()"><i class="ri-delete-bin-line"></i></button></div></div>
                        </div>
                    </div>

                    <!-- CTA -->
                    <div style="background:rgba(255,255,255,.015);border:1px solid rgba(255,255,255,.06);border-radius:12px;padding:16px">
                        <div style="font-size:.75rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;margin-bottom:12px">CTA Button</div>
                        <div class="g2">
                            <div class="field-group"><label class="label">Button Label</label><input class="inp" value="Get Started Free"></div>
                            <div class="field-group"><label class="label">Button URL</label><input class="inp" value="register?plan=free"></div>
                        </div>
                        <div class="g2">
                            <div class="field-group"><label class="label">Button Style</label><select class="inp"><option>btn-ghost (Outline)</option><option>btn-primary (Purple gradient)</option><option>btn-secondary (Cyan)</option></select></div>
                            <div class="field-group"><label class="label">Button Icon</label><input class="inp" value="ri-user-line"></div>
                        </div>
                        <div class="field-group"><label class="label">Sub-label under button</label><input class="inp" value="No credit card needed"></div>
                    </div>
                </div>

                <!-- Mini Preview -->
                <div style="flex:1;position:sticky;top:90px">
                    <div class="price-preview" id="preview-0">
                        <div class="plan-badge-indicator">Free Plan</div>
                        <div style="font-size:.72rem;font-weight:700;color:#10b981;text-transform:uppercase;letter-spacing:.08em;margin-bottom:8px">Get Started</div>
                        <div style="font-size:2.2rem;font-weight:900;color:var(--text2)">Free</div>
                        <div style="font-size:.75rem;color:var(--text4);margin-bottom:14px">No credit card required</div>
                        <div style="border-top:1px solid rgba(255,255,255,.08);padding-top:14px;text-align:left;max-width:180px;margin:0 auto;font-size:.78rem;color:var(--text2)">
                            <div style="display:flex;align-items:center;gap:7px;margin-bottom:7px"><i class="ri-check-line" style="color:#10b981"></i> Up to 5 reminders</div>
                            <div style="display:flex;align-items:center;gap:7px;margin-bottom:7px"><i class="ri-check-line" style="color:#10b981"></i> Email notifications</div>
                            <div style="display:flex;align-items:center;gap:7px;margin-bottom:7px;opacity:.45"><i class="ri-close-line" style="color:var(--red)"></i> Push notifications</div>
                            <div style="display:flex;align-items:center;gap:7px;opacity:.45"><i class="ri-close-line" style="color:var(--red)"></i> Priority support</div>
                        </div>
                        <button class="btn btn-ghost" style="width:100%;justify-content:center;margin-top:14px;font-size:.82rem">Get Started Free</button>
                        <div style="font-size:.68rem;color:var(--text4);margin-top:8px">No credit card needed</div>
                    </div>
                    <div style="padding:12px;background:rgba(255,255,255,.02);border:1px solid rgba(255,255,255,.06);border-radius:10px">
                        <div style="font-size:.7rem;color:var(--text4);margin-bottom:6px">Plan order / position</div>
                        <div style="display:flex;align-items:center;gap:6px">
                            <span style="font-size:.8rem;color:var(--text3)">Position:</span>
                            <select class="inp" style="flex:1"><option>1 — First (Left)</option><option>2 — Middle</option><option>3 — Last (Right)</option></select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Plan 1: Pro -->
        <div class="plan-editor" id="plan-editor-1">
            <div class="g2" style="align-items:start">
                <div style="flex:2">
                    <div style="background:rgba(255,255,255,.015);border:1px solid rgba(255,255,255,.06);border-radius:12px;padding:16px;margin-bottom:12px">
                        <div style="font-size:.75rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;margin-bottom:12px">Plan Identity</div>
                        <div class="g2">
                            <div class="field-group"><label class="label">Plan Name</label><input class="inp plan-name-inp" data-plan="1" value="Pro" oninput="syncPlanTab(1)"></div>
                            <div class="field-group"><label class="label">Plan Badge / Tagline</label><input class="inp" value="Most Popular"></div>
                        </div>
                        <div class="g2">
                            <div class="field-group">
                                <label class="label">Accent Color</label>
                                <div style="display:flex;gap:8px;align-items:center;margin-top:4px">
                                    <input type="color" class="plan-color-inp" data-plan="1" value="#7c3aed" oninput="syncPlanColor(1,this.value)" style="width:38px;height:38px;border:none;background:transparent;cursor:pointer;border-radius:8px">
                                    <input class="inp" value="#7c3aed" style="flex:1;font-family:monospace">
                                </div>
                            </div>
                            <div class="field-group">
                                <label class="label">Is "Popular" / Highlighted?</label>
                                <div style="display:flex;align-items:center;gap:8px;margin-top:10px">
                                    <label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label>
                                    <span style="font-size:.8rem;color:var(--text3)">Show "Most Popular" badge</span>
                                </div>
                            </div>
                        </div>
                        <div class="g2">
                            <div class="field-group"><label class="label">Popular Badge Text</label><input class="inp" value="Most Popular"></div>
                            <div class="field-group">
                                <label class="label">Plan Visibility</label>
                                <div style="display:flex;align-items:center;gap:8px;margin-top:10px">
                                    <label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label>
                                    <span style="font-size:.8rem;color:var(--text3)">Show on page</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="background:rgba(255,255,255,.015);border:1px solid rgba(255,255,255,.06);border-radius:12px;padding:16px;margin-bottom:12px">
                        <div style="font-size:.75rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;margin-bottom:12px">Pricing</div>
                        <div class="g2">
                            <div class="field-group"><label class="label">Monthly Price (base)</label><input class="inp" id="p1-price-m" type="number" step="0.01" value="4.99" oninput="calcPlanTax(1,'m')"></div>
                            <div class="field-group"><label class="label">Annual Price (base)</label><input class="inp" id="p1-price-a" type="number" step="0.01" value="2.00" oninput="calcPlanTax(1,'a')"></div>
                        </div>
                        <div class="g2">
                            <div class="field-group"><label class="label">VAT Rate (%)</label><input class="inp" id="p1-vat" type="number" step="0.1" value="20" oninput="calcPlanTax(1,'m');calcPlanTax(1,'a')"></div>
                            <div class="field-group"><label class="label">Price Display Override</label><input class="inp" id="p1-override" placeholder="Leave empty to use calculated price"></div>
                        </div>
                        <div class="g2">
                            <div class="field-group"><label class="label">Period Label</label><input class="inp" value="/ month"></div>
                            <div class="field-group"><label class="label">Price Sub-label</label><input class="inp" value="£2.00 + £0.40 VAT billed annually"></div>
                        </div>
                        <div class="g2">
                            <div class="field-group"><label class="label">Savings Label (annual)</label><input class="inp" value="Save 33%"></div>
                            <div class="field-group"><label class="label">Trial Days</label><input class="inp" type="number" value="14" placeholder="0 = no trial"></div>
                        </div>
                    </div>
                    <div style="background:rgba(255,255,255,.015);border:1px solid rgba(255,255,255,.06);border-radius:12px;padding:16px;margin-bottom:12px">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
                            <div style="font-size:.75rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em">Feature List</div>
                            <button class="btn btn-ghost btn-sm" onclick="addFeature('features-1')"><i class="ri-add-line"></i> Add Feature</button>
                        </div>
                        <div id="features-1">
                            <div class="sortable-item"><i class="ri-draggable drag-handle"></i><i class="ri-check-line" style="color:#7c3aed;font-size:1.1rem;flex-shrink:0"></i><input class="inp" value="Unlimited reminders"><select class="inp" style="width:90px;flex-shrink:0"><option>✓ Check</option><option>✕ Cross</option><option>— Dash</option></select><div style="display:flex;align-items:center;gap:6px"><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label><button class="btn btn-danger btn-sm" onclick="this.closest('.sortable-item').remove()"><i class="ri-delete-bin-line"></i></button></div></div>
                            <div class="sortable-item"><i class="ri-draggable drag-handle"></i><i class="ri-check-line" style="color:#7c3aed;font-size:1.1rem;flex-shrink:0"></i><input class="inp" value="Email & push notifications"><select class="inp" style="width:90px;flex-shrink:0"><option>✓ Check</option><option>✕ Cross</option><option>— Dash</option></select><div style="display:flex;align-items:center;gap:6px"><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label><button class="btn btn-danger btn-sm" onclick="this.closest('.sortable-item').remove()"><i class="ri-delete-bin-line"></i></button></div></div>
                            <div class="sortable-item"><i class="ri-draggable drag-handle"></i><i class="ri-check-line" style="color:#7c3aed;font-size:1.1rem;flex-shrink:0"></i><input class="inp" value="Smart scheduling system"><select class="inp" style="width:90px;flex-shrink:0"><option>✓ Check</option><option>✕ Cross</option><option>— Dash</option></select><div style="display:flex;align-items:center;gap:6px"><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label><button class="btn btn-danger btn-sm" onclick="this.closest('.sortable-item').remove()"><i class="ri-delete-bin-line"></i></button></div></div>
                            <div class="sortable-item"><i class="ri-draggable drag-handle"></i><i class="ri-check-line" style="color:#7c3aed;font-size:1.1rem;flex-shrink:0"></i><input class="inp" value="Full access to all features"><select class="inp" style="width:90px;flex-shrink:0"><option>✓ Check</option><option>✕ Cross</option><option>— Dash</option></select><div style="display:flex;align-items:center;gap:6px"><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label><button class="btn btn-danger btn-sm" onclick="this.closest('.sortable-item').remove()"><i class="ri-delete-bin-line"></i></button></div></div>
                            <div class="sortable-item"><i class="ri-draggable drag-handle"></i><i class="ri-check-line" style="color:#7c3aed;font-size:1.1rem;flex-shrink:0"></i><input class="inp" value="Priority support"><select class="inp" style="width:90px;flex-shrink:0"><option>✓ Check</option><option>✕ Cross</option><option>— Dash</option></select><div style="display:flex;align-items:center;gap:6px"><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label><button class="btn btn-danger btn-sm" onclick="this.closest('.sortable-item').remove()"><i class="ri-delete-bin-line"></i></button></div></div>
                        </div>
                    </div>
                    <div style="background:rgba(255,255,255,.015);border:1px solid rgba(255,255,255,.06);border-radius:12px;padding:16px">
                        <div style="font-size:.75rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;margin-bottom:12px">CTA Button</div>
                        <div class="g2">
                            <div class="field-group"><label class="label">Button Label</label><input class="inp" value="Get Full Access Now"></div>
                            <div class="field-group"><label class="label">Button URL</label><input class="inp" value="register?plan=pro-annual"></div>
                        </div>
                        <div class="g2">
                            <div class="field-group"><label class="label">Button Style</label><select class="inp"><option>btn-ghost (Outline)</option><option selected>btn-primary (Purple gradient)</option><option>btn-secondary (Cyan)</option></select></div>
                            <div class="field-group"><label class="label">Button Icon</label><input class="inp" value="ri-user-add-line"></div>
                        </div>
                        <div class="field-group"><label class="label">Sub-label under button</label><input class="inp" value="One payment. 365 days of peace of mind."></div>
                    </div>
                </div>
                <div style="flex:1;position:sticky;top:90px">
                    <div class="price-preview" id="preview-1" style="border-color:rgba(124,58,237,.4);box-shadow:0 0 40px rgba(124,58,237,.15)">
                        <div class="plan-badge-indicator">Pro Plan</div>
                        <div class="popular-badge"><i class="ri-vip-crown-line"></i> Most Popular</div>
                        <div style="font-size:.72rem;font-weight:700;color:#c4b5fd;text-transform:uppercase;letter-spacing:.08em;margin-bottom:8px">Annual Plan</div>
                        <div style="display:flex;align-items:flex-end;justify-content:center;gap:6px;margin-bottom:4px">
                            <span style="font-size:2.2rem;font-weight:900;color:var(--text2)">£2.40</span>
                            <span style="font-size:.8rem;color:var(--text4);margin-bottom:6px">/ year</span>
                        </div>
                        <div style="font-size:.72rem;color:var(--text4);margin-bottom:14px">£2.00 + £0.40 VAT</div>
                        <div style="background:rgba(124,58,237,.15);border-radius:100px;padding:3px 10px;font-size:.68rem;font-weight:700;color:#c4b5fd;display:inline-block;margin-bottom:14px">Save 33% vs monthly</div>
                        <div style="border-top:1px solid rgba(255,255,255,.08);padding-top:14px;text-align:left;max-width:180px;margin:0 auto;font-size:.78rem;color:var(--text2)">
                            <div style="display:flex;align-items:center;gap:7px;margin-bottom:7px"><i class="ri-check-line" style="color:#7c3aed"></i> Unlimited reminders</div>
                            <div style="display:flex;align-items:center;gap:7px;margin-bottom:7px"><i class="ri-check-line" style="color:#7c3aed"></i> Email & push</div>
                            <div style="display:flex;align-items:center;gap:7px"><i class="ri-check-line" style="color:#7c3aed"></i> Priority support</div>
                        </div>
                        <button class="btn btn-primary" style="width:100%;justify-content:center;margin-top:14px;font-size:.82rem">Get Full Access Now</button>
                        <div style="font-size:.68rem;color:var(--text4);margin-top:8px">One payment. 365 days.</div>
                    </div>
                    <div style="padding:12px;background:rgba(255,255,255,.02);border:1px solid rgba(255,255,255,.06);border-radius:10px">
                        <div style="font-size:.7rem;color:var(--text4);margin-bottom:6px">Plan order / position</div>
                        <div style="display:flex;align-items:center;gap:6px">
                            <span style="font-size:.8rem;color:var(--text3)">Position:</span>
                            <select class="inp" style="flex:1"><option>1 — First (Left)</option><option selected>2 — Middle</option><option>3 — Last (Right)</option></select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Plan 2: Enterprise -->
        <div class="plan-editor" id="plan-editor-2">
            <div class="g2" style="align-items:start">
                <div style="flex:2">
                    <div style="background:rgba(255,255,255,.015);border:1px solid rgba(255,255,255,.06);border-radius:12px;padding:16px;margin-bottom:12px">
                        <div style="font-size:.75rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;margin-bottom:12px">Plan Identity</div>
                        <div class="g2">
                            <div class="field-group"><label class="label">Plan Name</label><input class="inp plan-name-inp" data-plan="2" value="Enterprise" oninput="syncPlanTab(2)"></div>
                            <div class="field-group"><label class="label">Plan Badge / Tagline</label><input class="inp" value="For Teams"></div>
                        </div>
                        <div class="g2">
                            <div class="field-group">
                                <label class="label">Accent Color</label>
                                <div style="display:flex;gap:8px;align-items:center;margin-top:4px">
                                    <input type="color" class="plan-color-inp" data-plan="2" value="#06b6d4" oninput="syncPlanColor(2,this.value)" style="width:38px;height:38px;border:none;background:transparent;cursor:pointer;border-radius:8px">
                                    <input class="inp" value="#06b6d4" style="flex:1;font-family:monospace">
                                </div>
                            </div>
                            <div class="field-group">
                                <label class="label">Is "Popular" / Highlighted?</label>
                                <div style="display:flex;align-items:center;gap:8px;margin-top:10px">
                                    <label class="toggle-switch"><input type="checkbox"><span class="toggle-slider"></span></label>
                                    <span style="font-size:.8rem;color:var(--text3)">Show "Most Popular" badge</span>
                                </div>
                            </div>
                        </div>
                        <div class="g2">
                            <div class="field-group"><label class="label">Popular Badge Text</label><input class="inp" value="Best Value"></div>
                            <div class="field-group">
                                <label class="label">Plan Visibility</label>
                                <div style="display:flex;align-items:center;gap:8px;margin-top:10px">
                                    <label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label>
                                    <span style="font-size:.8rem;color:var(--text3)">Show on page</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="background:rgba(255,255,255,.015);border:1px solid rgba(255,255,255,.06);border-radius:12px;padding:16px;margin-bottom:12px">
                        <div style="font-size:.75rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;margin-bottom:12px">Pricing</div>
                        <div class="g2">
                            <div class="field-group"><label class="label">Monthly Price (base)</label><input class="inp" id="p2-price-m" type="number" step="0.01" value="9.99" oninput="calcPlanTax(2,'m')"></div>
                            <div class="field-group"><label class="label">Annual Price (base)</label><input class="inp" id="p2-price-a" type="number" step="0.01" value="7.99" oninput="calcPlanTax(2,'a')"></div>
                        </div>
                        <div class="g2">
                            <div class="field-group"><label class="label">VAT Rate (%)</label><input class="inp" id="p2-vat" type="number" step="0.1" value="20" oninput="calcPlanTax(2,'m');calcPlanTax(2,'a')"></div>
                            <div class="field-group"><label class="label">Price Display Override</label><input class="inp" id="p2-override" placeholder="e.g. Contact Us"></div>
                        </div>
                        <div class="g2">
                            <div class="field-group"><label class="label">Period Label</label><input class="inp" value="/ month per seat"></div>
                            <div class="field-group"><label class="label">Price Sub-label</label><input class="inp" value="Billed annually · Min. 5 seats"></div>
                        </div>
                        <div class="g2">
                            <div class="field-group"><label class="label">Savings Label (annual)</label><input class="inp" value="Save 20%"></div>
                            <div class="field-group"><label class="label">Trial Days</label><input class="inp" type="number" value="30" placeholder="0 = no trial"></div>
                        </div>
                    </div>
                    <div style="background:rgba(255,255,255,.015);border:1px solid rgba(255,255,255,.06);border-radius:12px;padding:16px;margin-bottom:12px">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
                            <div style="font-size:.75rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em">Feature List</div>
                            <button class="btn btn-ghost btn-sm" onclick="addFeature('features-2')"><i class="ri-add-line"></i> Add Feature</button>
                        </div>
                        <div id="features-2">
                            <div class="sortable-item"><i class="ri-draggable drag-handle"></i><i class="ri-check-line" style="color:#06b6d4;font-size:1.1rem;flex-shrink:0"></i><input class="inp" value="Everything in Pro"><select class="inp" style="width:90px;flex-shrink:0"><option>✓ Check</option><option>✕ Cross</option><option>— Dash</option></select><div style="display:flex;align-items:center;gap:6px"><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label><button class="btn btn-danger btn-sm" onclick="this.closest('.sortable-item').remove()"><i class="ri-delete-bin-line"></i></button></div></div>
                            <div class="sortable-item"><i class="ri-draggable drag-handle"></i><i class="ri-check-line" style="color:#06b6d4;font-size:1.1rem;flex-shrink:0"></i><input class="inp" value="Team management dashboard"><select class="inp" style="width:90px;flex-shrink:0"><option>✓ Check</option><option>✕ Cross</option><option>— Dash</option></select><div style="display:flex;align-items:center;gap:6px"><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label><button class="btn btn-danger btn-sm" onclick="this.closest('.sortable-item').remove()"><i class="ri-delete-bin-line"></i></button></div></div>
                            <div class="sortable-item"><i class="ri-draggable drag-handle"></i><i class="ri-check-line" style="color:#06b6d4;font-size:1.1rem;flex-shrink:0"></i><input class="inp" value="SSO & advanced security"><select class="inp" style="width:90px;flex-shrink:0"><option>✓ Check</option><option>✕ Cross</option><option>— Dash</option></select><div style="display:flex;align-items:center;gap:6px"><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label><button class="btn btn-danger btn-sm" onclick="this.closest('.sortable-item').remove()"><i class="ri-delete-bin-line"></i></button></div></div>
                            <div class="sortable-item"><i class="ri-draggable drag-handle"></i><i class="ri-check-line" style="color:#06b6d4;font-size:1.1rem;flex-shrink:0"></i><input class="inp" value="Dedicated account manager"><select class="inp" style="width:90px;flex-shrink:0"><option>✓ Check</option><option>✕ Cross</option><option>— Dash</option></select><div style="display:flex;align-items:center;gap:6px"><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label><button class="btn btn-danger btn-sm" onclick="this.closest('.sortable-item').remove()"><i class="ri-delete-bin-line"></i></button></div></div>
                        </div>
                    </div>
                    <div style="background:rgba(255,255,255,.015);border:1px solid rgba(255,255,255,.06);border-radius:12px;padding:16px">
                        <div style="font-size:.75rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;margin-bottom:12px">CTA Button</div>
                        <div class="g2">
                            <div class="field-group"><label class="label">Button Label</label><input class="inp" value="Contact Sales"></div>
                            <div class="field-group"><label class="label">Button URL</label><input class="inp" value="contact?subject=enterprise"></div>
                        </div>
                        <div class="g2">
                            <div class="field-group"><label class="label">Button Style</label><select class="inp"><option>btn-ghost (Outline)</option><option>btn-primary (Purple gradient)</option><option selected>btn-secondary (Cyan)</option></select></div>
                            <div class="field-group"><label class="label">Button Icon</label><input class="inp" value="ri-building-line"></div>
                        </div>
                        <div class="field-group"><label class="label">Sub-label under button</label><input class="inp" value="Custom contracts available"></div>
                    </div>
                </div>
                <div style="flex:1;position:sticky;top:90px">
                    <div class="price-preview" id="preview-2" style="background:linear-gradient(135deg,rgba(6,182,212,.1),rgba(124,58,237,.06));border-color:rgba(6,182,212,.25)">
                        <div class="plan-badge-indicator" style="background:rgba(6,182,212,.2);color:#67e8f9;border-color:rgba(6,182,212,.3)">Enterprise</div>
                        <div style="font-size:.72rem;font-weight:700;color:#67e8f9;text-transform:uppercase;letter-spacing:.08em;margin-bottom:8px">For Teams</div>
                        <div style="display:flex;align-items:flex-end;justify-content:center;gap:6px;margin-bottom:4px">
                            <span style="font-size:2.2rem;font-weight:900;color:var(--text2)">£9.59</span>
                            <span style="font-size:.8rem;color:var(--text4);margin-bottom:6px">/ month per seat</span>
                        </div>
                        <div style="font-size:.72rem;color:var(--text4);margin-bottom:14px">Billed annually · Min. 5 seats</div>
                        <div style="background:rgba(6,182,212,.12);border-radius:100px;padding:3px 10px;font-size:.68rem;font-weight:700;color:#67e8f9;display:inline-block;margin-bottom:14px">30-day free trial</div>
                        <div style="border-top:1px solid rgba(255,255,255,.08);padding-top:14px;text-align:left;max-width:180px;margin:0 auto;font-size:.78rem;color:var(--text2)">
                            <div style="display:flex;align-items:center;gap:7px;margin-bottom:7px"><i class="ri-check-line" style="color:#06b6d4"></i> Everything in Pro</div>
                            <div style="display:flex;align-items:center;gap:7px;margin-bottom:7px"><i class="ri-check-line" style="color:#06b6d4"></i> Team dashboard</div>
                            <div style="display:flex;align-items:center;gap:7px"><i class="ri-check-line" style="color:#06b6d4"></i> Account manager</div>
                        </div>
                        <button class="btn btn-secondary" style="width:100%;justify-content:center;margin-top:14px;font-size:.82rem">Contact Sales</button>
                        <div style="font-size:.68rem;color:var(--text4);margin-top:8px">Custom contracts available</div>
                    </div>
                    <div style="padding:12px;background:rgba(255,255,255,.02);border:1px solid rgba(255,255,255,.06);border-radius:10px">
                        <div style="font-size:.7rem;color:var(--text4);margin-bottom:6px">Plan order / position</div>
                        <div style="display:flex;align-items:center;gap:6px">
                            <span style="font-size:.8rem;color:var(--text3)">Position:</span>
                            <select class="inp" style="flex:1"><option>1 — First (Left)</option><option>2 — Middle</option><option selected>3 — Last (Right)</option></select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Value Line -->
    <div class="section-card">
        <div class="section-title" style="margin-bottom:14px"><i class="ri-text"></i> Bottom Value Line</div>
        <div class="g2">
            <div class="field-group"><label class="label">Value Line Text</label><input class="inp" value="That's just £0.20 per month — less than a cup of tea ☕"></div>
            <div class="field-group">
                <label class="label">Show Value Line</label>
                <div style="display:flex;align-items:center;gap:8px;margin-top:10px">
                    <label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label>
                    <span style="font-size:.8rem;color:var(--text3)">Visible on page</span>
                </div>
            </div>
        </div>
        <div class="g2">
            <div class="field-group"><label class="label">Guarantee Badge Text</label><input class="inp" value="30-day money back guarantee"></div>
            <div class="field-group"><label class="label">Trust Icons (comma separated)</label><input class="inp" value="ri-shield-check-line,ri-lock-line,ri-secure-payment-line"></div>
        </div>
    </div>
</div>

<!-- HERO TAB -->
<div class="cms-tab-content" id="tab-hero">
    <div class="section-card">
        <div class="section-title" style="margin-bottom:14px"><i class="ri-flag-line"></i> Page Hero</div>
        <div class="g2">
            <div class="field-group"><label class="label">Badge Text</label><input class="inp" value="Plans & Pricing"></div>
            <div class="field-group"><label class="label">Badge Icon</label><input class="inp" value="ri-vip-crown-line"></div>
        </div>
        <div class="g2">
            <div class="field-group"><label class="label">Headline (before gradient)</label><input class="inp" value="Simple pricing that"></div>
            <div class="field-group"><label class="label">Headline Gradient Text</label><input class="inp" value="pays for itself."></div>
        </div>
        <div class="field-group"><label class="label">Subheadline</label><textarea class="inp-area inp" rows="2">Start free, then upgrade only if you need more power. Most households never pay a cent.</textarea></div>
        <div class="g2">
            <div class="field-group"><label class="label">Particle Theme</label><select class="inp"><option>mixed</option><option>purple</option><option>cyan</option></select></div>
            <div class="field-group"><label class="label">Particle Count</label><input class="inp" type="number" value="60"></div>
        </div>
        <div class="g2">
            <div class="field-group"><label class="label">Breadcrumb Parent</label><input class="inp" value="Home"></div>
            <div class="field-group"><label class="label">Breadcrumb Current</label><input class="inp" value="Pricing"></div>
        </div>
    </div>
</div>

<!-- COUPONS TAB -->
<div class="cms-tab-content" id="tab-coupons">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
        <div class="section-title" style="margin:0">Discount Coupons</div>
        <button class="btn btn-primary btn-sm" onclick="openModal('add-coupon-modal')"><i class="ri-add-line"></i> New Coupon</button>
    </div>
    <div class="card" style="padding:0;overflow:hidden;margin-bottom:14px">
        <table class="data-table">
            <thead><tr><th>Code</th><th>Discount</th><th>Applies To</th><th>Type</th><th>Usage</th><th>Expires</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                <tr>
                    <td><div style="font-weight:700;font-family:monospace;letter-spacing:.08em">LAUNCH20</div></td>
                    <td><span class="badge badge-green">20% off</span></td>
                    <td><span style="font-size:.78rem;color:var(--text3)">All Plans</span></td>
                    <td><span style="font-size:.78rem;color:var(--text3)">Percentage</span></td>
                    <td><span style="font-size:.78rem">48 / 100</span></td>
                    <td><span style="font-size:.78rem;color:var(--text3)">Jun 30, 2026</span></td>
                    <td><span class="badge badge-green">Active</span></td>
                    <td><div style="display:flex;gap:4px"><button class="btn btn-ghost btn-sm"><i class="ri-edit-line"></i></button><button class="btn btn-danger btn-sm"><i class="ri-delete-bin-line"></i></button></div></td>
                </tr>
                <tr>
                    <td><div style="font-weight:700;font-family:monospace;letter-spacing:.08em">PROONLY</div></td>
                    <td><span class="badge badge-purple">50% off</span></td>
                    <td><span style="font-size:.78rem;color:var(--text3)">Pro Plan only</span></td>
                    <td><span style="font-size:.78rem;color:var(--text3)">Percentage</span></td>
                    <td><span style="font-size:.78rem">12 / 50</span></td>
                    <td><span style="font-size:.78rem;color:var(--text3)">Dec 31, 2026</span></td>
                    <td><span class="badge badge-green">Active</span></td>
                    <td><div style="display:flex;gap:4px"><button class="btn btn-ghost btn-sm"><i class="ri-edit-line"></i></button><button class="btn btn-danger btn-sm"><i class="ri-delete-bin-line"></i></button></div></td>
                </tr>
                <tr>
                    <td><div style="font-weight:700;font-family:monospace;letter-spacing:.08em">EARLYBIRD</div></td>
                    <td><span class="badge badge-amber">£0.50 off</span></td>
                    <td><span style="font-size:.78rem;color:var(--text3)">All Plans</span></td>
                    <td><span style="font-size:.78rem;color:var(--text3)">Fixed Amount</span></td>
                    <td><span style="font-size:.78rem">200 / 200</span></td>
                    <td><span style="font-size:.78rem;color:var(--red)">Expired</span></td>
                    <td><span class="badge badge-red">Expired</span></td>
                    <td><div style="display:flex;gap:4px"><button class="btn btn-ghost btn-sm"><i class="ri-edit-line"></i></button><button class="btn btn-danger btn-sm"><i class="ri-delete-bin-line"></i></button></div></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="section-card">
        <div class="section-title" style="margin-bottom:14px"><i class="ri-settings-3-line"></i> Coupon Settings</div>
        <div class="field-group"><label class="label">Invalid Coupon Error Message</label><input class="inp" value="This coupon code is invalid or has expired."></div>
        <div class="field-group"><label class="label">Applied Coupon Success Message</label><input class="inp" value="Coupon applied! Your discount has been applied at checkout."></div>
    </div>
</div>

<!-- SEO TAB -->
<div class="cms-tab-content" id="tab-seo">
    <div class="g2" style="align-items:start">
        <div style="flex:2">
            <div class="section-card">
                <div class="section-title" style="margin-bottom:14px"><i class="ri-file-text-line"></i> Page Meta</div>
                <div class="field-group"><label class="label">Meta Title</label><input class="inp" id="mt" value="Pricing — DRemind | Plans from Free to Enterprise" oninput="cc('mt','tc-mt',60)"><div class="char-count" id="tc-mt">50/60</div></div>
                <div class="field-group"><label class="label">Meta Description</label><textarea class="inp-area inp" id="md" rows="3" oninput="cc('md','tc-md',160)">DRemind offers flexible plans for every household. Start free, upgrade to Pro for £2.40/year, or go Enterprise for teams. Unlimited reminders, email & push notifications.</textarea><div class="char-count" id="tc-md">160/160</div></div>
                <div class="field-group"><label class="label">Keywords</label><input class="inp" value="DRemind pricing, free plan, pro plan, enterprise, subscription cost, annual plan"></div>
                <div class="field-group"><label class="label">Canonical URL</label><input class="inp" value="https://dremin.co.uk/pricing"></div>
                <div class="g2">
                    <div class="field-group"><label class="label">Robots</label><select class="inp"><option>index, follow</option></select></div>
                    <div class="field-group"><label class="label">Priority</label><select class="inp"><option>0.8 — High</option><option>1.0 — Homepage</option></select></div>
                </div>
            </div>
        </div>
        <div>
            <div class="card" style="padding:18px;position:sticky;top:90px">
                <div class="section-title" style="margin-bottom:14px"><i class="ri-google-line"></i> SERP Preview</div>
                <div style="background:var(--bg2);border-radius:12px;padding:14px;border:1px solid var(--border)">
                    <div style="font-size:.65rem;color:var(--text4);margin-bottom:4px">dremin.co.uk › pricing</div>
                    <div style="font-size:.95rem;color:#8ab4f8;font-weight:500;margin-bottom:5px">Pricing — DRemind | Plans from Free to Enterprise</div>
                    <div style="font-size:.8rem;color:var(--text3);line-height:1.6">DRemind offers flexible plans for every household. Start free, upgrade to Pro for £2.40/year, or go Enterprise...</div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Add Coupon Modal -->
<div class="modal-bg" id="add-coupon-modal">
    <div class="modal-box" style="max-width:560px">
        <div class="modal-header">
            <div><h3 class="font-jakarta" style="font-weight:700;font-size:.95rem"><i class="ri-coupon-line" style="color:var(--purple);margin-right:6px"></i>New Coupon</h3></div>
            <button class="modal-close" onclick="closeModal('add-coupon-modal')"><i class="ri-close-line"></i></button>
        </div>
        <div class="g2">
            <div class="field-group"><label class="label">Coupon Code <span style="color:var(--red)">*</span></label><input class="inp" id="coupon-code" placeholder="e.g. SAVE20" style="text-transform:uppercase"></div>
            <div class="field-group"><label class="label">Discount Type</label><select class="inp" id="coupon-type"><option value="percent">Percentage (%)</option><option value="fixed">Fixed Amount</option></select></div>
        </div>
        <div class="g2">
            <div class="field-group"><label class="label">Discount Value</label><input class="inp" id="coupon-val" type="number" placeholder="e.g. 20"></div>
            <div class="field-group"><label class="label">Applies To</label><select class="inp"><option>All Plans</option><option>Free Plan only</option><option>Pro Plan only</option><option>Enterprise Plan only</option></select></div>
        </div>
        <div class="g2">
            <div class="field-group"><label class="label">Max Uses</label><input class="inp" type="number" placeholder="Leave empty = unlimited"></div>
            <div class="field-group"><label class="label">Expiry Date</label><input class="inp" type="date"></div>
        </div>
        <div class="g2">
            <div class="field-group"><label class="label">Status</label><select class="inp"><option>Active</option><option>Inactive</option></select></div>
            <div class="field-group"><label class="label">One-use per user?</label><div style="display:flex;align-items:center;gap:8px;margin-top:10px"><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label><span style="font-size:.8rem;color:var(--text3)">Yes</span></div></div>
        </div>
        <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:8px">
            <button class="btn btn-ghost btn-sm" onclick="closeModal('add-coupon-modal')">Cancel</button>
            <button class="btn btn-primary btn-sm" onclick="createCoupon()"><i class="ri-check-line"></i> Create Coupon</button>
        </div>
    </div>
</div>

<!-- Reorder Plans Modal -->
<div class="modal-bg" id="reorder-plans-modal">
    <div class="modal-box" style="max-width:440px">
        <div class="modal-header">
            <div><h3 class="font-jakarta" style="font-weight:700;font-size:.95rem"><i class="ri-drag-move-2-line" style="color:var(--purple);margin-right:6px"></i>Reorder Plans</h3></div>
            <button class="modal-close" onclick="closeModal('reorder-plans-modal')"><i class="ri-close-line"></i></button>
        </div>
        <p style="font-size:.8rem;color:var(--text3);margin-bottom:16px">Drag to set the display order of plans on the pricing page.</p>
        <div id="reorder-list">
            <div class="plan-sort-item"><i class="ri-draggable drag-handle"></i><div class="plan-sort-color" style="background:#10b981">F</div><span style="font-size:.9rem;font-weight:700;color:var(--text)">Free</span><span style="font-size:.72rem;color:var(--text4);margin-left:auto">Position 1</span></div>
            <div class="plan-sort-item"><i class="ri-draggable drag-handle"></i><div class="plan-sort-color" style="background:#7c3aed">P</div><span style="font-size:.9rem;font-weight:700;color:var(--text)">Pro</span><span style="font-size:.72rem;color:var(--text4);margin-left:auto">Position 2</span></div>
            <div class="plan-sort-item"><i class="ri-draggable drag-handle"></i><div class="plan-sort-color" style="background:#06b6d4">E</div><span style="font-size:.9rem;font-weight:700;color:var(--text)">Enterprise</span><span style="font-size:.72rem;color:var(--text4);margin-left:auto">Position 3</span></div>
        </div>
        <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:16px">
            <button class="btn btn-ghost btn-sm" onclick="closeModal('reorder-plans-modal')">Cancel</button>
            <button class="btn btn-primary btn-sm" onclick="closeModal('reorder-plans-modal');if(typeof toast==='function')toast('Order saved!','success')"><i class="ri-check-line"></i> Save Order</button>
        </div>
    </div>
</div>

<script>
var globalCurrency = '£';
var planCount = 3;

function switchTab(t){
    document.querySelectorAll('.cms-tab-content').forEach(c=>c.classList.remove('active'));
    document.querySelectorAll('.cms-tab-btn').forEach(b=>b.classList.remove('active'));
    document.getElementById('tab-'+t).classList.add('active');
    document.getElementById('tab-btn-'+t).classList.add('active');
}

function switchPlan(idx,btn){
    document.querySelectorAll('.plan-tab').forEach(t=>t.classList.remove('active'));
    document.querySelectorAll('.plan-editor').forEach(e=>e.classList.remove('active'));
    if(btn) btn.classList.add('active');
    var ed = document.getElementById('plan-editor-'+idx);
    if(ed) ed.classList.add('active');
}

function syncPlanTab(idx){
    var inp = document.querySelector('.plan-name-inp[data-plan="'+idx+'"]');
    var tab = document.getElementById('plan-tab-'+idx);
    if(!inp||!tab) return;
    var dot = tab.querySelector('.plan-color-dot');
    var close = tab.querySelector('.plan-tab-close');
    tab.innerHTML = '';
    if(dot) tab.appendChild(dot);
    tab.appendChild(document.createTextNode(' '+inp.value));
    if(close) tab.appendChild(close);
}

function syncPlanColor(idx,color){
    var dot = document.querySelector('#plan-tab-'+idx+' .plan-color-dot');
    if(dot) dot.style.background = color;
}

function setGlobalCurrency(sym,btn){
    globalCurrency = sym;
    document.querySelectorAll('[onclick^="setGlobalCurrency"]').forEach(b=>b.classList.remove('btn-primary'));
    btn.classList.add('btn-primary');
}

function calcPlanTax(planIdx,period){
    var priceEl = document.getElementById('p'+planIdx+'-price-'+period);
    var vatEl = document.getElementById('p'+planIdx+'-vat');
    if(!priceEl||!vatEl) return;
    var base = parseFloat(priceEl.value)||0;
    var vat = parseFloat(vatEl.value)||0;
    var total = base + (base*vat/100);
    // Update preview price if period is annual
    if(period==='a'){
        var prev = document.getElementById('preview-'+planIdx);
        if(prev){
            var priceSpan = prev.querySelector('[style*="font-weight:900"]');
            if(priceSpan&&base>0) priceSpan.textContent = globalCurrency+total.toFixed(2);
        }
    }
}

function addFeature(listId){
    var list = document.getElementById(listId);
    if(!list) return;
    var d = document.createElement('div');
    d.className = 'sortable-item';
    d.innerHTML = '<i class="ri-draggable drag-handle"></i><i class="ri-check-line" style="color:var(--green);font-size:1.1rem;flex-shrink:0"></i><input class="inp" placeholder="New feature..."><select class="inp" style="width:90px;flex-shrink:0"><option>✓ Check</option><option>✕ Cross</option><option>— Dash</option></select><div style="display:flex;align-items:center;gap:6px"><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label><button class="btn btn-danger btn-sm" onclick="this.closest(\'.sortable-item\').remove()"><i class="ri-delete-bin-line"></i></button></div>';
    list.appendChild(d);
}

function addNewPlan(){
    var idx = planCount;
    planCount++;
    var colors = ['#f59e0b','#ef4444','#8b5cf6','#ec4899','#14b8a6'];
    var color = colors[idx % colors.length];

    // Add tab
    var bar = document.getElementById('plan-tab-bar');
    var addBtn = bar.querySelector('.add-plan-btn');
    var tab = document.createElement('button');
    tab.className = 'plan-tab';
    tab.id = 'plan-tab-'+idx;
    tab.onclick = function(){ switchPlan(idx, this); };
    tab.innerHTML = '<span class="plan-color-dot" style="background:'+color+'"></span> New Plan <span class="plan-tab-close" onclick="deletePlan('+idx+',event)"><i class="ri-close-line"></i></span>';
    bar.insertBefore(tab, addBtn);

    // Add editor
    var editorsWrap = document.getElementById('plan-tab-bar').parentElement;
    var ed = document.createElement('div');
    ed.className = 'plan-editor';
    ed.id = 'plan-editor-'+idx;
    ed.innerHTML = `
    <div class="g2" style="align-items:start">
        <div style="flex:2">
            <div style="background:rgba(255,255,255,.015);border:1px solid rgba(255,255,255,.06);border-radius:12px;padding:16px;margin-bottom:12px">
                <div style="font-size:.75rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;margin-bottom:12px">Plan Identity</div>
                <div class="g2">
                    <div class="field-group"><label class="label">Plan Name</label><input class="inp plan-name-inp" data-plan="${idx}" value="New Plan" oninput="syncPlanTab(${idx})"></div>
                    <div class="field-group"><label class="label">Plan Badge / Tagline</label><input class="inp" value=""></div>
                </div>
                <div class="g2">
                    <div class="field-group">
                        <label class="label">Accent Color</label>
                        <div style="display:flex;gap:8px;align-items:center;margin-top:4px">
                            <input type="color" class="plan-color-inp" data-plan="${idx}" value="${color}" oninput="syncPlanColor(${idx},this.value)" style="width:38px;height:38px;border:none;background:transparent;cursor:pointer;border-radius:8px">
                            <input class="inp" value="${color}" style="flex:1;font-family:monospace">
                        </div>
                    </div>
                    <div class="field-group">
                        <label class="label">Is "Popular" / Highlighted?</label>
                        <div style="display:flex;align-items:center;gap:8px;margin-top:10px">
                            <label class="toggle-switch"><input type="checkbox"><span class="toggle-slider"></span></label>
                            <span style="font-size:.8rem;color:var(--text3)">Show badge</span>
                        </div>
                    </div>
                </div>
            </div>
            <div style="background:rgba(255,255,255,.015);border:1px solid rgba(255,255,255,.06);border-radius:12px;padding:16px;margin-bottom:12px">
                <div style="font-size:.75rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;margin-bottom:12px">Pricing</div>
                <div class="g2">
                    <div class="field-group"><label class="label">Monthly Price (base)</label><input class="inp" id="p${idx}-price-m" type="number" step="0.01" value="0.00"></div>
                    <div class="field-group"><label class="label">Annual Price (base)</label><input class="inp" id="p${idx}-price-a" type="number" step="0.01" value="0.00"></div>
                </div>
                <div class="g2">
                    <div class="field-group"><label class="label">VAT Rate (%)</label><input class="inp" id="p${idx}-vat" type="number" step="0.1" value="20"></div>
                    <div class="field-group"><label class="label">Price Display Override</label><input class="inp" placeholder="e.g. Free, Contact Us"></div>
                </div>
                <div class="g2">
                    <div class="field-group"><label class="label">Period Label</label><input class="inp" value="/ month"></div>
                    <div class="field-group"><label class="label">Price Sub-label</label><input class="inp" placeholder="Billed annually"></div>
                </div>
            </div>
            <div style="background:rgba(255,255,255,.015);border:1px solid rgba(255,255,255,.06);border-radius:12px;padding:16px;margin-bottom:12px">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
                    <div style="font-size:.75rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em">Feature List</div>
                    <button class="btn btn-ghost btn-sm" onclick="addFeature('features-${idx}')"><i class="ri-add-line"></i> Add Feature</button>
                </div>
                <div id="features-${idx}">
                    <div class="sortable-item"><i class="ri-draggable drag-handle"></i><i class="ri-check-line" style="color:${color};font-size:1.1rem;flex-shrink:0"></i><input class="inp" placeholder="Feature name..."><select class="inp" style="width:90px;flex-shrink:0"><option>✓ Check</option><option>✕ Cross</option><option>— Dash</option></select><div style="display:flex;align-items:center;gap:6px"><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label><button class="btn btn-danger btn-sm" onclick="this.closest('.sortable-item').remove()"><i class="ri-delete-bin-line"></i></button></div></div>
                </div>
            </div>
            <div style="background:rgba(255,255,255,.015);border:1px solid rgba(255,255,255,.06);border-radius:12px;padding:16px">
                <div style="font-size:.75rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;margin-bottom:12px">CTA Button</div>
                <div class="g2">
                    <div class="field-group"><label class="label">Button Label</label><input class="inp" value="Get Started"></div>
                    <div class="field-group"><label class="label">Button URL</label><input class="inp" placeholder="register?plan=..."></div>
                </div>
                <div class="g2">
                    <div class="field-group"><label class="label">Button Style</label><select class="inp"><option>btn-ghost (Outline)</option><option selected>btn-primary (Purple gradient)</option><option>btn-secondary (Cyan)</option></select></div>
                    <div class="field-group"><label class="label">Button Icon</label><input class="inp" value="ri-user-add-line"></div>
                </div>
            </div>
        </div>
        <div style="flex:1;position:sticky;top:90px">
            <div class="price-preview" id="preview-${idx}" style="border-color:rgba(255,255,255,.12)">
                <div class="plan-badge-indicator" style="background:rgba(255,255,255,.1);color:rgba(255,255,255,.6);border-color:rgba(255,255,255,.15)">New Plan</div>
                <div style="font-size:2rem;font-weight:900;color:var(--text2);margin:12px 0">£0.00</div>
                <div style="font-size:.72rem;color:var(--text4);margin-bottom:14px">/ month</div>
                <div style="border-top:1px solid rgba(255,255,255,.08);padding-top:14px;text-align:left;max-width:180px;margin:0 auto;font-size:.78rem;color:var(--text2)">
                    <div style="color:var(--text4);text-align:center;padding:12px">No features added yet</div>
                </div>
                <button class="btn btn-primary" style="width:100%;justify-content:center;margin-top:14px;font-size:.82rem">Get Started</button>
            </div>
        </div>
    </div>`;
    editorsWrap.appendChild(ed);
    switchPlan(idx, tab);
    if(typeof toast==='function') toast('New plan added!','success');
}

function deletePlan(idx,event){
    event.stopPropagation();
    if(!confirm('Delete this plan?')) return;
    var tab = document.getElementById('plan-tab-'+idx);
    var ed = document.getElementById('plan-editor-'+idx);
    if(tab) tab.remove();
    if(ed) ed.remove();
    // Switch to first available
    var firstTab = document.querySelector('.plan-tab');
    if(firstTab){
        var firstIdx = firstTab.id.replace('plan-tab-','');
        switchPlan(firstIdx, firstTab);
    }
    if(typeof toast==='function') toast('Plan deleted','info');
}

function cc(i,c,m){
    var el=document.getElementById(i),cnt=document.getElementById(c);
    if(!el||!cnt)return;
    var l=el.value.length;
    cnt.textContent=l+'/'+m;
    cnt.className='char-count'+(l>m?' bad':l>m*.85?' warn':'');
}

function createCoupon(){
    var code=document.getElementById('coupon-code').value.trim();
    if(!code){if(typeof toast==='function')toast('Coupon code required','error');return;}
    if(typeof toast==='function')toast('Coupon "'+code+'" created!','success');
    closeModal('add-coupon-modal');
}

function saveAll(){
    if(typeof toast==='function')toast('Pricing page saved & published!','success');
}
</script>

@endsection