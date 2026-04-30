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
.char-count{font-size:.68rem;color:var(--text4);text-align:right;margin-top:4px}
.char-count.warn{color:var(--amber)}.char-count.bad{color:var(--red)}
.seo-score{display:flex;align-items:center;gap:10px;padding:14px 18px;border-radius:12px;background:rgba(16,185,129,.06);border:1px solid rgba(16,185,129,.15);margin-bottom:16px}
.seo-score-circle{width:52px;height:52px;border-radius:50%;background:conic-gradient(var(--green) 0% 88%,var(--border) 88%);display:flex;align-items:center;justify-content:center;font-size:.8rem;font-weight:800;color:var(--green);flex-shrink:0}

/* FAQ item specific */
.faq-cat-section{margin-bottom:20px}
.faq-cat-header{display:flex;align-items:center;justify-content:space-between;padding:12px 16px;background:var(--row-bg);border:1px solid var(--border);border-radius:12px;margin-bottom:8px;cursor:pointer}
.faq-cat-header h4{display:flex;align-items:center;gap:8px;font-size:.88rem;font-weight:700;color:var(--text)}
.faq-item-row{display:flex;align-items:flex-start;gap:10px;padding:12px 14px;background:var(--bg2);border:1px solid var(--border2);border-radius:var(--radius-sm);margin-bottom:6px;position:relative}
.faq-item-row:hover{border-color:rgba(124,58,237,.2)}
.drag-handle{color:var(--text4);font-size:1.1rem;padding-top:10px;cursor:grab;flex-shrink:0}
.faq-item-body{flex:1}
.faq-item-actions{display:flex;flex-direction:column;gap:4px;flex-shrink:0}
.faq-status-badge{display:inline-flex;align-items:center;gap:4px;padding:3px 8px;border-radius:var(--radius-xs);font-size:.65rem;font-weight:700;cursor:pointer}
.faq-status-badge.published{background:rgba(16,185,129,.12);color:var(--green);border:1px solid rgba(16,185,129,.2)}
.faq-status-badge.draft{background:rgba(245,158,11,.12);color:var(--amber);border:1px solid rgba(245,158,11,.2)}

/* Category color pills */
.cat-color-opt{width:22px;height:22px;border-radius:50%;cursor:pointer;border:2px solid transparent;transition:all .2s}
.cat-color-opt:hover,.cat-color-opt.selected{border-color:var(--text3);transform:scale(1.15)}
</style>

<div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px">
    <div>
        <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800">CMS — FAQ Page</h2>
        <p style="font-size:.8rem;color:var(--text3);margin-top:3px">Manage questions, categories, hero text and SEO</p>
    </div>
    <div style="display:flex;gap:8px">
        <a href="faq" target="_blank" class="btn btn-ghost btn-sm"><i class="ri-eye-line"></i> Preview</a>
        <button class="btn btn-primary btn-sm" onclick="openModal('add-faq-modal')"><i class="ri-add-line"></i> Add FAQ</button>
        <button class="btn btn-primary btn-sm" onclick="saveAll()"><i class="ri-save-line"></i> Save & Publish</button>
    </div>
</div>

<!-- Tabs -->
<div style="display:flex;gap:8px;margin-bottom:20px;border-bottom:2px solid rgba(255,255,255,.05)">
    <button class="cms-tab-btn active" onclick="switchTab('content')" id="tab-btn-content"><i class="ri-layout-line"></i> Content & FAQs</button>
    <button class="cms-tab-btn" onclick="switchTab('categories')" id="tab-btn-categories"><i class="ri-folder-line"></i> Categories</button>
    <button class="cms-tab-btn" onclick="switchTab('seo')" id="tab-btn-seo"><i class="ri-search-eye-line"></i> SEO & Meta</button>
</div>

<!-- CONTENT TAB -->
<div class="cms-tab-content active" id="tab-content">

    <!-- Hero -->
    <div class="section-card">
        <div class="section-title" style="margin-bottom:14px"><i class="ri-flag-line"></i> Page Hero</div>
        <div class="g2">
            <div class="field-group"><label class="label">Badge Label</label><input class="inp" value="Frequently Asked Questions"></div>
            <div class="field-group"><label class="label">Headline (before gradient)</label><input class="inp" value="Got questions?"></div>
        </div>
        <div class="g2">
            <div class="field-group"><label class="label">Headline Gradient Text</label><input class="inp" value="We've got answers."></div>
            <div class="field-group"><label class="label">Subheadline</label><input class="inp" value="Everything you need to know about DRemind — from getting started to managing your account."></div>
        </div>
        <div class="g2">
            <div class="field-group"><label class="label">Search Placeholder Text</label><input class="inp" value="Search questions..."></div>
            <div class="field-group">
                <label class="label">Show Search Bar</label>
                <label class="toggle-switch" style="margin-top:8px"><input type="checkbox" checked><span class="toggle-slider"></span></label>
            </div>
        </div>
    </div>

    <!-- FAQ Items by Category -->
    <div class="g2" style="align-items:center;margin-bottom:12px">
        <div class="section-title" style="margin:0">FAQ Items <span class="badge badge-purple" style="margin-left:8px" id="total-faqs">16 Total</span></div>
        <div style="display:flex;gap:8px;margin-left:auto">
            <input type="text" class="inp" placeholder="Search FAQs..." style="width:220px" oninput="filterFAQs(this.value)">
            <select class="inp" style="width:auto" onchange="filterByCategory(this.value)">
                <option value="">All Categories</option>
                <option>General</option><option>Account</option><option>Reminders</option><option>Pricing</option><option>Privacy</option>
            </select>
        </div>
    </div>

    <!-- General Category -->
    <div class="faq-cat-section" id="cat-general">
        <div class="faq-cat-header" onclick="toggleCat('general')">
            <h4><i class="ri-information-line" style="color:var(--purple)"></i> General <span class="badge badge-purple" style="font-size:.65rem">4</span></h4>
            <div style="display:flex;align-items:center;gap:8px">
                <button class="btn btn-ghost btn-sm" onclick="event.stopPropagation();openAddInCategory('General')"><i class="ri-add-line"></i></button>
                <i class="ri-arrow-down-s-line" style="color:var(--text3)"></i>
            </div>
        </div>
        <div id="general-items">
            <div class="faq-item-row">
                <i class="ri-draggable drag-handle"></i>
                <div class="faq-item-body">
                    <input class="inp" value="What is DRemind?" style="margin-bottom:8px;font-weight:600">
                    <textarea class="inp-area inp" rows="2">DRemind is a smart reminder web app that tracks expiry dates for your insurance, utility plans, subscriptions, vehicle registrations, passports, and more.</textarea>
                </div>
                <div class="faq-item-actions">
                    <span class="faq-status-badge published" onclick="toggleStatus(this)"><i class="ri-eye-line"></i> Published</span>
                    <button class="btn btn-ghost btn-sm" onclick="openEditFAQ(this)"><i class="ri-edit-line"></i>Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteFAQ(this)"><i class="ri-delete-bin-line"></i>Delete</button>
                </div>
            </div>
            <div class="faq-item-row">
                <i class="ri-draggable drag-handle"></i>
                <div class="faq-item-body">
                    <input class="inp" value="Who is DRemind for?" style="margin-bottom:8px;font-weight:600">
                    <textarea class="inp-area inp" rows="2">DRemind is for anyone who wants to stay on top of recurring expenses. Homeowners, renters, families, business owners, and frequent travellers all find it incredibly useful.</textarea>
                </div>
                <div class="faq-item-actions">
                    <span class="faq-status-badge published" onclick="toggleStatus(this)"><i class="ri-eye-line"></i> Published</span>
                    <button class="btn btn-ghost btn-sm" onclick="openEditFAQ(this)"><i class="ri-edit-line"></i>Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteFAQ(this)"><i class="ri-delete-bin-line"></i>Delete</button>
                </div>
            </div>
            <div class="faq-item-row">
                <i class="ri-draggable drag-handle"></i>
                <div class="faq-item-body">
                    <input class="inp" value="Which countries does DRemind support?" style="margin-bottom:8px;font-weight:600">
                    <textarea class="inp-area inp" rows="2">DRemind is available in Australia, New Zealand, United States, United Kingdom, Canada, Ireland, India, and Singapore.</textarea>
                </div>
                <div class="faq-item-actions">
                    <span class="faq-status-badge published" onclick="toggleStatus(this)"><i class="ri-eye-line"></i> Published</span>
                    <button class="btn btn-ghost btn-sm"><i class="ri-edit-line"></i>Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteFAQ(this)"><i class="ri-delete-bin-line"></i>Delete</button>
                </div>
            </div>
            <div class="faq-item-row">
                <i class="ri-draggable drag-handle"></i>
                <div class="faq-item-body">
                    <input class="inp" value="How much money can I save?" style="margin-bottom:8px;font-weight:600">
                    <textarea class="inp-area inp" rows="2">Our users save an average of $2,847 per year by switching to better deals across insurance, energy, telecom, and subscriptions.</textarea>
                </div>
                <div class="faq-item-actions">
                    <span class="faq-status-badge draft" onclick="toggleStatus(this)"><i class="ri-draft-line"></i> Draft</span>
                    <button class="btn btn-ghost btn-sm"><i class="ri-edit-line"></i>Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteFAQ(this)"><i class="ri-delete-bin-line"></i>Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Account Category -->
    <div class="faq-cat-section" id="cat-account">
        <div class="faq-cat-header" onclick="toggleCat('account')">
            <h4><i class="ri-user-line" style="color:var(--green,#10b981)"></i> Account & Access <span class="badge badge-green" style="font-size:.65rem">4</span></h4>
            <div style="display:flex;align-items:center;gap:8px">
                <button class="btn btn-ghost btn-sm" onclick="event.stopPropagation();openAddInCategory('Account')"><i class="ri-add-line"></i></button>
                <i class="ri-arrow-down-s-line" style="color:var(--text3)"></i>
            </div>
        </div>
        <div id="account-items">
            <div class="faq-item-row"><i class="ri-draggable drag-handle"></i><div class="faq-item-body"><input class="inp" value="How do I create an account?" style="margin-bottom:8px;font-weight:600"><textarea class="inp-area inp" rows="2">Click "Register", enter your name and email, choose a password — no credit card required. Setup takes under 2 minutes.</textarea></div><div class="faq-item-actions"><span class="faq-status-badge published" onclick="toggleStatus(this)"><i class="ri-eye-line"></i> Published</span><button class="btn btn-ghost btn-sm"><i class="ri-edit-line"></i>Edit</button><button class="btn btn-danger btn-sm" onclick="deleteFAQ(this)"><i class="ri-delete-bin-line"></i>Delete</button></div></div>
            <div class="faq-item-row"><i class="ri-draggable drag-handle"></i><div class="faq-item-body"><input class="inp" value="Can I use DRemind on multiple devices?" style="margin-bottom:8px;font-weight:600"><textarea class="inp-area inp" rows="2">Yes! DRemind syncs in real time across all your devices. Access via web app from any browser, or download the iOS and Android apps.</textarea></div><div class="faq-item-actions"><span class="faq-status-badge published" onclick="toggleStatus(this)"><i class="ri-eye-line"></i> Published</span><button class="btn btn-ghost btn-sm"><i class="ri-edit-line"></i>Edit</button><button class="btn btn-danger btn-sm" onclick="deleteFAQ(this)"><i class="ri-delete-bin-line"></i>Delete</button></div></div>
            <div class="faq-item-row"><i class="ri-draggable drag-handle"></i><div class="faq-item-body"><input class="inp" value="I forgot my password. How do I reset it?" style="margin-bottom:8px;font-weight:600"><textarea class="inp-area inp" rows="2">On the login page, click "Forgot password?" and enter your email. You'll receive a reset link within a few minutes.</textarea></div><div class="faq-item-actions"><span class="faq-status-badge published" onclick="toggleStatus(this)"><i class="ri-eye-line"></i> Published</span><button class="btn btn-ghost btn-sm"><i class="ri-edit-line"></i>Edit</button><button class="btn btn-danger btn-sm" onclick="deleteFAQ(this)"><i class="ri-delete-bin-line"></i>Delete</button></div></div>
            <div class="faq-item-row"><i class="ri-draggable drag-handle"></i><div class="faq-item-body"><input class="inp" value="How do I delete my account?" style="margin-bottom:8px;font-weight:600"><textarea class="inp-area inp" rows="2">Go to Settings → Account → Delete Account. All data will be permanently removed within 30 days.</textarea></div><div class="faq-item-actions"><span class="faq-status-badge published" onclick="toggleStatus(this)"><i class="ri-eye-line"></i> Published</span><button class="btn btn-ghost btn-sm"><i class="ri-edit-line"></i>Edit</button><button class="btn btn-danger btn-sm" onclick="deleteFAQ(this)"><i class="ri-delete-bin-line"></i>Delete</button></div></div>
        </div>
    </div>

    <!-- Reminders Category -->
    <div class="faq-cat-section" id="cat-reminders">
        <div class="faq-cat-header" onclick="toggleCat('reminders')">
            <h4><i class="ri-notification-3-line" style="color:var(--cyan,#06b6d4)"></i> Reminders & Alerts <span class="badge" style="font-size:.65rem;background:rgba(6,182,212,.1);color:var(--cyan,#06b6d4)">3</span></h4>
            <div style="display:flex;align-items:center;gap:8px"><button class="btn btn-ghost btn-sm" onclick="event.stopPropagation();openAddInCategory('Reminders')"><i class="ri-add-line"></i></button><i class="ri-arrow-down-s-line" style="color:var(--text3)"></i></div>
        </div>
        <div id="reminders-items">
            <div class="faq-item-row"><i class="ri-draggable drag-handle"></i><div class="faq-item-body"><input class="inp" value="How do I add a reminder?" style="margin-bottom:8px;font-weight:600"><textarea class="inp-area inp" rows="2">Tap the "+" button in the dock or click "Quick Add". Enter the name, expiry date, category, and preferred alert timing.</textarea></div><div class="faq-item-actions"><span class="faq-status-badge published" onclick="toggleStatus(this)"><i class="ri-eye-line"></i> Published</span><button class="btn btn-ghost btn-sm"><i class="ri-edit-line"></i>Edit</button><button class="btn btn-danger btn-sm" onclick="deleteFAQ(this)"><i class="ri-delete-bin-line"></i>Delete</button></div></div>
            <div class="faq-item-row"><i class="ri-draggable drag-handle"></i><div class="faq-item-body"><input class="inp" value="How will I receive my reminders?" style="margin-bottom:8px;font-weight:600"><textarea class="inp-area inp" rows="2">DRemind sends reminders via push notifications, email alerts, and in-app notifications.</textarea></div><div class="faq-item-actions"><span class="faq-status-badge published" onclick="toggleStatus(this)"><i class="ri-eye-line"></i> Published</span><button class="btn btn-ghost btn-sm"><i class="ri-edit-line"></i>Edit</button><button class="btn btn-danger btn-sm" onclick="deleteFAQ(this)"><i class="ri-delete-bin-line"></i>Delete</button></div></div>
            <div class="faq-item-row"><i class="ri-draggable drag-handle"></i><div class="faq-item-body"><input class="inp" value="Can I snooze or reschedule a reminder?" style="margin-bottom:8px;font-weight:600"><textarea class="inp-area inp" rows="2">Yes. From any notification, you can snooze for 1, 3, or 7 days.</textarea></div><div class="faq-item-actions"><span class="faq-status-badge published" onclick="toggleStatus(this)"><i class="ri-eye-line"></i> Published</span><button class="btn btn-ghost btn-sm"><i class="ri-edit-line"></i>Edit</button><button class="btn btn-danger btn-sm" onclick="deleteFAQ(this)"><i class="ri-delete-bin-line"></i>Delete</button></div></div>
        </div>
    </div>

    <!-- Pricing -->
    <div class="faq-cat-section" id="cat-pricing">
        <div class="faq-cat-header" onclick="toggleCat('pricing')">
            <h4><i class="ri-price-tag-3-line" style="color:var(--amber,#f59e0b)"></i> Pricing & Plans <span class="badge badge-amber" style="font-size:.65rem">3</span></h4>
            <div style="display:flex;align-items:center;gap:8px"><button class="btn btn-ghost btn-sm" onclick="event.stopPropagation();openAddInCategory('Pricing')"><i class="ri-add-line"></i></button><i class="ri-arrow-down-s-line" style="color:var(--text3)"></i></div>
        </div>
        <div id="pricing-items">
            <div class="faq-item-row"><i class="ri-draggable drag-handle"></i><div class="faq-item-body"><input class="inp" value="Is DRemind really free?" style="margin-bottom:8px;font-weight:600"><textarea class="inp-area inp" rows="2">Yes! The free plan is genuinely free — no credit card, no hidden fees, no time limit.</textarea></div><div class="faq-item-actions"><span class="faq-status-badge published" onclick="toggleStatus(this)"><i class="ri-eye-line"></i> Published</span><button class="btn btn-ghost btn-sm"><i class="ri-edit-line"></i>Edit</button><button class="btn btn-danger btn-sm" onclick="deleteFAQ(this)"><i class="ri-delete-bin-line"></i>Delete</button></div></div>
            <div class="faq-item-row"><i class="ri-draggable drag-handle"></i><div class="faq-item-body"><input class="inp" value="What does the Pro plan include?" style="margin-bottom:8px;font-weight:600"><textarea class="inp-area inp" rows="2">Pro ($4.99/month or $49.99/year) unlocks unlimited reminders, advanced scheduling, family sharing for up to 5 members, data export, detailed analytics, and priority support.</textarea></div><div class="faq-item-actions"><span class="faq-status-badge published" onclick="toggleStatus(this)"><i class="ri-eye-line"></i> Published</span><button class="btn btn-ghost btn-sm"><i class="ri-edit-line"></i>Edit</button><button class="btn btn-danger btn-sm" onclick="deleteFAQ(this)"><i class="ri-delete-bin-line"></i>Delete</button></div></div>
            <div class="faq-item-row"><i class="ri-draggable drag-handle"></i><div class="faq-item-body"><input class="inp" value="Can I cancel my Pro subscription anytime?" style="margin-bottom:8px;font-weight:600"><textarea class="inp-area inp" rows="2">Absolutely. Cancel anytime from Settings → Billing → Cancel Subscription. No cancellation fees.</textarea></div><div class="faq-item-actions"><span class="faq-status-badge published" onclick="toggleStatus(this)"><i class="ri-eye-line"></i> Published</span><button class="btn btn-ghost btn-sm"><i class="ri-edit-line"></i>Edit</button><button class="btn btn-danger btn-sm" onclick="deleteFAQ(this)"><i class="ri-delete-bin-line"></i>Delete</button></div></div>
        </div>
    </div>

    <!-- Privacy -->
    <div class="faq-cat-section" id="cat-privacy">
        <div class="faq-cat-header" onclick="toggleCat('privacy')">
            <h4><i class="ri-shield-check-line" style="color:var(--red,#ef4444)"></i> Privacy & Security <span class="badge badge-red" style="font-size:.65rem">2</span></h4>
            <div style="display:flex;align-items:center;gap:8px"><button class="btn btn-ghost btn-sm" onclick="event.stopPropagation();openAddInCategory('Privacy')"><i class="ri-add-line"></i></button><i class="ri-arrow-down-s-line" style="color:var(--text3)"></i></div>
        </div>
        <div id="privacy-items">
            <div class="faq-item-row"><i class="ri-draggable drag-handle"></i><div class="faq-item-body"><input class="inp" value="Is my data safe with DRemind?" style="margin-bottom:8px;font-weight:600"><textarea class="inp-area inp" rows="2">Yes. We use AES-256 encryption for data at rest and TLS 1.3 for all data in transit. We undergo annual third-party security audits.</textarea></div><div class="faq-item-actions"><span class="faq-status-badge published" onclick="toggleStatus(this)"><i class="ri-eye-line"></i> Published</span><button class="btn btn-ghost btn-sm"><i class="ri-edit-line"></i>Edit</button><button class="btn btn-danger btn-sm" onclick="deleteFAQ(this)"><i class="ri-delete-bin-line"></i>Delete</button></div></div>
            <div class="faq-item-row"><i class="ri-draggable drag-handle"></i><div class="faq-item-body"><input class="inp" value="Do you sell my data to third parties?" style="margin-bottom:8px;font-weight:600"><textarea class="inp-area inp" rows="2">Never. We do not sell, rent, or share your personal data with advertisers or third parties.</textarea></div><div class="faq-item-actions"><span class="faq-status-badge published" onclick="toggleStatus(this)"><i class="ri-eye-line"></i> Published</span><button class="btn btn-ghost btn-sm"><i class="ri-edit-line"></i>Edit</button><button class="btn btn-danger btn-sm" onclick="deleteFAQ(this)"><i class="ri-delete-bin-line"></i>Delete</button></div></div>
        </div>
    </div>

</div>

<!-- CATEGORIES TAB -->
<div class="cms-tab-content" id="tab-categories">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
        <div class="section-title" style="margin:0">Manage Categories</div>
        <button class="btn btn-primary btn-sm" onclick="openModal('add-cat-modal')"><i class="ri-add-line"></i> New Category</button>
    </div>
    <div class="card" style="padding:0;overflow:hidden">
        <table class="data-table">
            <thead><tr><th>Category</th><th>Icon</th><th>Color</th><th>FAQ Count</th><th>Visible</th><th>Sort Order</th><th>Actions</th></tr></thead>
            <tbody>
                <tr><td><div style="font-weight:700">General</div><div style="font-size:.72rem;color:var(--text4)">General questions about DRemind</div></td><td><i class="ri-information-line" style="color:var(--purple);font-size:1.1rem"></i> ri-information-line</td><td><div style="display:flex;align-items:center;gap:6px"><div style="width:18px;height:18px;border-radius:50%;background:var(--purple)"></div>#7c3aed</div></td><td><span class="badge badge-purple">4</span></td><td><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label></td><td><input type="number" class="inp" value="1" style="width:60px"></td><td><div style="display:flex;gap:4px"><button class="btn btn-ghost btn-sm"><i class="ri-edit-line"></i>Edit</button><button class="btn btn-danger btn-sm"><i class="ri-delete-bin-line"></i>Delete</button></div></td></tr>
                <tr><td><div style="font-weight:700">Account</div><div style="font-size:.72rem;color:var(--text4)">Account and access related questions</div></td><td><i class="ri-user-line" style="color:var(--green);font-size:1.1rem"></i> ri-user-line</td><td><div style="display:flex;align-items:center;gap:6px"><div style="width:18px;height:18px;border-radius:50%;background:var(--green)"></div>#10b981</div></td><td><span class="badge badge-green">4</span></td><td><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label></td><td><input type="number" class="inp" value="2" style="width:60px"></td><td><div style="display:flex;gap:4px"><button class="btn btn-ghost btn-sm"><i class="ri-edit-line"></i>Edit</button><button class="btn btn-danger btn-sm"><i class="ri-delete-bin-line"></i>Delete</button></div></td></tr>
                <tr><td><div style="font-weight:700">Reminders</div><div style="font-size:.72rem;color:var(--text4)">Alerts and notification questions</div></td><td><i class="ri-notification-3-line" style="color:#06b6d4;font-size:1.1rem"></i> ri-notification-3-line</td><td><div style="display:flex;align-items:center;gap:6px"><div style="width:18px;height:18px;border-radius:50%;background:#06b6d4"></div>#06b6d4</div></td><td><span class="badge" style="background:rgba(6,182,212,.1);color:#06b6d4">3</span></td><td><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label></td><td><input type="number" class="inp" value="3" style="width:60px"></td><td><div style="display:flex;gap:4px"><button class="btn btn-ghost btn-sm"><i class="ri-edit-line"></i>Edit</button><button class="btn btn-danger btn-sm"><i class="ri-delete-bin-line"></i>Delete</button></div></td></tr>
                <tr><td><div style="font-weight:700">Pricing</div><div style="font-size:.72rem;color:var(--text4)">Plans and billing questions</div></td><td><i class="ri-price-tag-3-line" style="color:var(--amber);font-size:1.1rem"></i> ri-price-tag-3-line</td><td><div style="display:flex;align-items:center;gap:6px"><div style="width:18px;height:18px;border-radius:50%;background:var(--amber)"></div>#f59e0b</div></td><td><span class="badge badge-amber">3</span></td><td><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label></td><td><input type="number" class="inp" value="4" style="width:60px"></td><td><div style="display:flex;gap:4px"><button class="btn btn-ghost btn-sm"><i class="ri-edit-line"></i>Edit</button><button class="btn btn-danger btn-sm"><i class="ri-delete-bin-line"></i>Delete</button></div></td></tr>
                <tr><td><div style="font-weight:700">Privacy</div><div style="font-size:.72rem;color:var(--text4)">Data & security questions</div></td><td><i class="ri-shield-check-line" style="color:var(--red);font-size:1.1rem"></i> ri-shield-check-line</td><td><div style="display:flex;align-items:center;gap:6px"><div style="width:18px;height:18px;border-radius:50%;background:var(--red)"></div>#ef4444</div></td><td><span class="badge badge-red">2</span></td><td><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label></td><td><input type="number" class="inp" value="5" style="width:60px"></td><td><div style="display:flex;gap:4px"><button class="btn btn-ghost btn-sm"><i class="ri-edit-line"></i>Edit</button><button class="btn btn-danger btn-sm"><i class="ri-delete-bin-line"></i>Delete</button></div></td></tr>
            </tbody>
        </table>
    </div>
</div>

<!-- SEO TAB -->
<div class="cms-tab-content" id="tab-seo">
    <div class="g2" style="align-items:start">
        <div style="flex:2">
            <div class="seo-score"><div class="seo-score-circle">88</div><div><div style="font-size:.85rem;font-weight:700;color:var(--text)">Excellent SEO Score</div><div style="font-size:.75rem;color:var(--text3);margin-top:3px">1 minor improvement available</div></div></div>
            <div class="section-card">
                <div class="section-title" style="margin-bottom:14px"><i class="ri-file-text-line"></i> Page Meta</div>
                <div class="field-group"><label class="label">Meta Title</label><input class="inp" id="meta-title" value="FAQ — DRemind Help Center" oninput="cc('meta-title','tc-title',60)"><div class="char-count" id="tc-title">26/60</div></div>
                <div class="field-group"><label class="label">Meta Description</label><textarea class="inp-area inp" id="meta-desc" rows="3" oninput="cc('meta-desc','tc-desc',160)">Find answers to all common questions about DRemind — account setup, reminders, pricing plans, privacy, and more. We've got you covered.</textarea><div class="char-count" id="tc-desc">138/160</div></div>
                <div class="field-group"><label class="label">Keywords</label><input class="inp" value="DRemind FAQ, help center, subscription tracker questions, billing questions"></div>
                <div class="field-group"><label class="label">Canonical URL</label><input class="inp" value="https://dremin.co.uk/faq"></div>
                <div class="g2"><div class="field-group"><label class="label">Robots</label><select class="inp"><option>index, follow</option></select></div><div class="field-group"><label class="label">Priority</label><select class="inp"><option>0.5 — Normal</option><option>0.8 — High</option></select></div></div>
            </div>
            <div class="section-card">
                <div class="section-title" style="margin-bottom:14px"><i class="ri-code-line"></i> Schema — FAQ Page</div>
                <div style="padding:12px;background:rgba(0,0,0,.3);border-radius:10px;font-family:monospace;font-size:.78rem;color:var(--text2);border:1px solid rgba(255,255,255,.06)">Auto-generated FAQ schema from above items will be injected here. Each published question creates a FAQPage schema entry.</div>
                <div class="field-group" style="margin-top:12px"><label class="label">Custom additions to FAQ Schema (JSON-LD)</label><textarea class="inp-area inp" rows="4" style="font-family:monospace;font-size:.78rem">// Add any custom entries here — they will be merged with auto-generated schema</textarea></div>
            </div>
        </div>
        <div>
            <div class="card" style="padding:18px;position:sticky;top:90px">
                <div class="section-title" style="margin-bottom:14px"><i class="ri-google-line"></i> SERP Preview</div>
                <div style="background:var(--bg2);border-radius:12px;padding:16px 18px;border:1px solid var(--border)">
                    <div style="font-size:.68rem;color:var(--text4);margin-bottom:5px">dremin.co.uk › faq</div>
                    <div style="font-size:1rem;color:#8ab4f8;font-weight:500;margin-bottom:6px">FAQ — DRemind Help Center</div>
                    <div style="font-size:.82rem;color:var(--text3);line-height:1.6">Find answers to all common questions about DRemind — account setup, reminders, pricing plans, privacy, and more.</div>
                </div>
                <div style="margin-top:14px;padding:10px;background:var(--bg2);border-radius:var(--radius-xs);border:1px solid var(--border2)">
                    <div style="font-size:.7rem;color:var(--text4);margin-bottom:8px">FAQ Rich Snippet Preview:</div>
                    <div style="font-size:.78rem;color:#8ab4f8;margin-bottom:4px">▾ What is DRemind?</div>
                    <div style="font-size:.78rem;color:#8ab4f8;margin-bottom:4px">▾ How do I create an account?</div>
                    <div style="font-size:.78rem;color:#8ab4f8">▾ Is DRemind really free?</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add FAQ Modal -->
<div class="modal-bg" id="add-faq-modal">
    <div class="modal-box" style="max-width:600px">
        <div class="modal-header">
            <div><h3 class="font-jakarta" style="font-weight:700;font-size:.95rem"><i class="ri-question-line" style="color:var(--purple);margin-right:6px"></i>Add FAQ Item</h3></div>
            <button class="modal-close" onclick="closeModal('add-faq-modal')"><i class="ri-close-line"></i></button>
        </div>
        <div class="field-group"><label class="label">Category</label><select class="inp" id="faq-cat"><option>General</option><option>Account</option><option>Reminders</option><option>Pricing</option><option>Privacy</option></select></div>
        <div class="field-group"><label class="label">Question <span style="color:var(--red)">*</span></label><input class="inp" id="faq-q" placeholder="Enter the question..."></div>
        <div class="field-group"><label class="label">Answer <span style="color:var(--red)">*</span></label><textarea class="inp-area inp" id="faq-a" rows="4" placeholder="Enter the answer..."></textarea></div>
        <div class="g2">
            <div class="field-group"><label class="label">Status</label><select class="inp" id="faq-status"><option>Published</option><option>Draft</option></select></div>
            <div class="field-group"><label class="label">Sort Order</label><input class="inp" type="number" id="faq-order" value="0" placeholder="0"></div>
        </div>
        <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:4px">
            <button class="btn btn-ghost btn-sm" onclick="closeModal('add-faq-modal')">Cancel</button>
            <button class="btn btn-primary btn-sm" onclick="addFAQ()"><i class="ri-check-line"></i> Add FAQ</button>
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal-bg" id="add-cat-modal">
    <div class="modal-box" style="max-width:480px">
        <div class="modal-header">
            <div><h3 class="font-jakarta" style="font-weight:700;font-size:.95rem"><i class="ri-folder-add-line" style="color:var(--purple);margin-right:6px"></i>New Category</h3></div>
            <button class="modal-close" onclick="closeModal('add-cat-modal')"><i class="ri-close-line"></i></button>
        </div>
        <div class="field-group"><label class="label">Category Name <span style="color:var(--red)">*</span></label><input class="inp" id="cat-name" placeholder="e.g. Technical Support"></div>
        <div class="field-group"><label class="label">Description</label><input class="inp" id="cat-desc" placeholder="Short description..."></div>
        <div class="field-group"><label class="label">Icon (Remix Icon class)</label><input class="inp" id="cat-icon" value="ri-question-line" placeholder="ri-question-line"></div>
        <div class="field-group"><label class="label">Color</label><div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:4px">
            <div class="cat-color-opt selected" style="background:#7c3aed" onclick="selectCatColor(this,'#7c3aed')"></div>
            <div class="cat-color-opt" style="background:#10b981" onclick="selectCatColor(this,'#10b981')"></div>
            <div class="cat-color-opt" style="background:#06b6d4" onclick="selectCatColor(this,'#06b6d4')"></div>
            <div class="cat-color-opt" style="background:#f59e0b" onclick="selectCatColor(this,'#f59e0b')"></div>
            <div class="cat-color-opt" style="background:#ef4444" onclick="selectCatColor(this,'#ef4444')"></div>
            <div class="cat-color-opt" style="background:#ec4899" onclick="selectCatColor(this,'#ec4899')"></div>
        </div></div>
        <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:8px">
            <button class="btn btn-ghost btn-sm" onclick="closeModal('add-cat-modal')">Cancel</button>
            <button class="btn btn-primary btn-sm" onclick="addCategory()"><i class="ri-check-line"></i> Create</button>
        </div>
    </div>
</div>

<script>
var selectedCatColor = '#7c3aed';
function switchTab(t){document.querySelectorAll('.cms-tab-content').forEach(c=>c.classList.remove('active'));document.querySelectorAll('.cms-tab-btn').forEach(b=>b.classList.remove('active'));document.getElementById('tab-'+t).classList.add('active');document.getElementById('tab-btn-'+t).classList.add('active')}
function toggleCat(id){var el=document.getElementById(id+'-items');if(el)el.style.display=el.style.display==='none'?'':'none'}
function cc(i,c,m){var el=document.getElementById(i),cnt=document.getElementById(c);if(!el||!cnt)return;var l=el.value.length;cnt.textContent=l+'/'+m;cnt.className='char-count'+(l>m?' bad':l>m*.85?' warn':'')}
function filterFAQs(q){document.querySelectorAll('.faq-item-row').forEach(r=>{r.style.display=!q||r.textContent.toLowerCase().includes(q.toLowerCase())?'':'none'})}
function filterByCategory(cat){document.querySelectorAll('.faq-cat-section').forEach(s=>{s.style.display=!cat||s.id.includes(cat.toLowerCase())?'':'none'})}
function toggleStatus(el){var published=el.classList.contains('published');el.classList.toggle('published',!published);el.classList.toggle('draft',published);el.innerHTML=published?'<i class="ri-draft-line"></i> Draft':'<i class="ri-eye-line"></i> Published'}
function deleteFAQ(btn){if(confirm('Delete this FAQ?'))btn.closest('.faq-item-row').remove()}
function openAddInCategory(cat){document.getElementById('faq-cat').value=cat;openModal('add-faq-modal')}
function openEditFAQ(btn){}
function addFAQ(){var q=document.getElementById('faq-q').value.trim(),a=document.getElementById('faq-a').value.trim();if(!q||!a){if(typeof toast==='function')toast('Question and answer required','error');return}if(typeof toast==='function')toast('FAQ added!','success');closeModal('add-faq-modal')}
function selectCatColor(el,c){document.querySelectorAll('.cat-color-opt').forEach(o=>o.classList.remove('selected'));el.classList.add('selected');selectedCatColor=c}
function addCategory(){var n=document.getElementById('cat-name').value.trim();if(!n){if(typeof toast==='function')toast('Category name required','error');return}if(typeof toast==='function')toast('Category created!','success');closeModal('add-cat-modal')}
function saveAll(){if(typeof toast==='function')toast('FAQ page saved!','success')}
</script>

@endsection