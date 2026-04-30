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
.legal-section-row{background:var(--bg2);border:1px solid var(--border);border-radius:var(--radius);padding:18px;margin-bottom:10px;position:relative}
.legal-section-row:hover{border-color:rgba(124,58,237,.2)}
.legal-section-row .drag-handle{position:absolute;top:18px;left:14px;color:var(--text4);cursor:grab;font-size:1.1rem}
.legal-section-inner{padding-left:28px}
.bullet-row{display:flex;align-items:center;gap:8px;margin-bottom:6px}
.section-badge{display:inline-flex;align-items:center;gap:4px;padding:3px 8px;border-radius:var(--radius-xs);font-size:.65rem;font-weight:700}
.section-badge.active{background:rgba(16,185,129,.12);color:var(--green);border:1px solid rgba(16,185,129,.2)}
.section-badge.hidden{background:var(--ctrl-bg);color:var(--text4);border:1px solid var(--border)}
</style>

<div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px">
    <div>
        <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800">CMS — Privacy Policy</h2>
        <p style="font-size:.8rem;color:var(--text3);margin-top:3px">Edit all privacy policy sections, hero and SEO settings</p>
    </div>
    <div style="display:flex;gap:8px">
        <span style="font-size:.75rem;color:var(--text4);align-self:center">Last updated: <span id="lastUpdated" style="color:var(--text2)">Apr 28, 2026</span></span>
        <button class="btn btn-ghost btn-sm" onclick="updateDate()"><i class="ri-calendar-event-line"></i> Update Date</button>
        <a href="privacy" target="_blank" class="btn btn-ghost btn-sm"><i class="ri-eye-line"></i> Preview</a>
        <button class="btn btn-primary btn-sm" onclick="saveAll()"><i class="ri-save-line"></i> Save & Publish</button>
    </div>
</div>

<!-- Tabs -->
<div style="display:flex;gap:8px;margin-bottom:20px;border-bottom:2px solid rgba(255,255,255,.05)">
    <button class="cms-tab-btn active" onclick="switchTab('content')" id="tab-btn-content"><i class="ri-layout-line"></i> Content & Sections</button>
    <button class="cms-tab-btn" onclick="switchTab('hero')" id="tab-btn-hero"><i class="ri-flag-line"></i> Hero</button>
    <button class="cms-tab-btn" onclick="switchTab('seo')" id="tab-btn-seo"><i class="ri-search-eye-line"></i> SEO & Meta</button>
</div>

<!-- CONTENT TAB -->
<div class="cms-tab-content active" id="tab-content">

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;flex-wrap:wrap;gap:8px">
        <div style="display:flex;align-items:center;gap:10px">
            <div class="section-title" style="margin:0">Policy Sections</div>
            <span class="badge badge-purple" id="section-count">11 Sections</span>
        </div>
        <div style="display:flex;gap:8px">
            <button class="btn btn-ghost btn-sm" onclick="expandAll()"><i class="ri-expand-diagonal-line"></i> Expand All</button>
            <button class="btn btn-ghost btn-sm" onclick="collapseAll()"><i class="ri-contract-diagonal-line"></i> Collapse All</button>
            <button class="btn btn-primary btn-sm" onclick="openModal('add-section-modal')"><i class="ri-add-line"></i> Add Section</button>
        </div>
    </div>

    <div id="sections-list">

        <!-- Section 1 -->
        <div class="legal-section-row" data-section="1">
            <i class="ri-draggable drag-handle"></i>
            <div class="legal-section-inner">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
                    <div style="display:flex;align-items:center;gap:10px">
                        <span style="font-size:.72rem;font-weight:800;color:var(--text4);min-width:24px">01</span>
                        <input class="inp" value="1. Acceptance of Terms" style="font-weight:700;font-size:.9rem;flex:1;max-width:400px">
                        <span class="section-badge active"><i class="ri-eye-line"></i> Visible</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:6px">
                        <button class="btn btn-ghost btn-sm" onclick="toggleSectionBody(this)" title="Expand"><i class="ri-arrow-down-s-line"></i></button>
                        <button class="btn btn-ghost btn-sm" onclick="toggleVisibility(this)" title="Toggle visibility"><i class="ri-eye-line"></i></button>
                        <button class="btn btn-danger btn-sm" onclick="deleteSection(this)" title="Delete"><i class="ri-delete-bin-line"></i></button>
                    </div>
                </div>
                <div class="section-body" style="display:none">
                    <div class="field-group">
                        <label class="label">Content Type</label>
                        <select class="inp" style="max-width:200px" onchange="switchContentType(this)">
                            <option value="paragraphs" selected>Paragraphs</option>
                            <option value="bullets">Bullet Points</option>
                            <option value="mixed">Paragraphs + Bullets</option>
                        </select>
                    </div>
                    <div class="paragraphs-area">
                        <div class="field-group">
                            <label class="label">Paragraph 1</label>
                            <textarea class="inp-area inp" rows="3">By accessing, registering, or using DRemind ("Service"), you agree to be bound by these Terms of Use and all applicable laws and regulations. These terms constitute a legally binding agreement between you and DRemind.</textarea>
                        </div>
                        <div class="field-group">
                            <label class="label">Paragraph 2</label>
                            <textarea class="inp-area inp" rows="3">If you do not agree with any part of these terms, you must not use our Services. Continued use of the platform indicates your acceptance of any future updates or modifications to these Terms.</textarea>
                        </div>
                        <button class="btn btn-ghost btn-sm" onclick="addParagraph(this)"><i class="ri-add-line"></i> Add Paragraph</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2 -->
        <div class="legal-section-row" data-section="2">
            <i class="ri-draggable drag-handle"></i>
            <div class="legal-section-inner">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
                    <div style="display:flex;align-items:center;gap:10px">
                        <span style="font-size:.72rem;font-weight:800;color:var(--text4);min-width:24px">02</span>
                        <input class="inp" value="2. Information We Collect" style="font-weight:700;font-size:.9rem;flex:1;max-width:400px">
                        <span class="section-badge active"><i class="ri-eye-line"></i> Visible</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:6px">
                        <button class="btn btn-ghost btn-sm" onclick="toggleSectionBody(this)"><i class="ri-arrow-down-s-line"></i></button>
                        <button class="btn btn-ghost btn-sm" onclick="toggleVisibility(this)"><i class="ri-eye-line"></i></button>
                        <button class="btn btn-danger btn-sm" onclick="deleteSection(this)"><i class="ri-delete-bin-line"></i></button>
                    </div>
                </div>
                <div class="section-body" style="display:none">
                    <div class="field-group">
                        <label class="label">Content Type</label>
                        <select class="inp" style="max-width:200px" onchange="switchContentType(this)">
                            <option value="paragraphs">Paragraphs</option>
                            <option value="bullets" selected>Bullet Points</option>
                            <option value="mixed">Paragraphs + Bullets</option>
                        </select>
                    </div>
                    <div class="bullets-area">
                        <label class="label">Bullet Points</label>
                        <div class="bullets-list" id="bullets-2">
                            <div class="bullet-row"><i class="ri-draggable" style="color:var(--text4);cursor:grab"></i><input class="inp" value="Name, email address, and contact details provided during registration."><button class="btn btn-danger btn-sm" onclick="this.closest('.bullet-row').remove()"><i class="ri-delete-bin-line"></i></button></div>
                            <div class="bullet-row"><i class="ri-draggable" style="color:var(--text4);cursor:grab"></i><input class="inp" value="Reminder data including names, dates, and categories you enter."><button class="btn btn-danger btn-sm" onclick="this.closest('.bullet-row').remove()"><i class="ri-delete-bin-line"></i></button></div>
                            <div class="bullet-row"><i class="ri-draggable" style="color:var(--text4);cursor:grab"></i><input class="inp" value="Device information, browser type, and usage analytics."><button class="btn btn-danger btn-sm" onclick="this.closest('.bullet-row').remove()"><i class="ri-delete-bin-line"></i></button></div>
                            <div class="bullet-row"><i class="ri-draggable" style="color:var(--text4);cursor:grab"></i><input class="inp" value="Payment information processed securely via our payment provider."><button class="btn btn-danger btn-sm" onclick="this.closest('.bullet-row').remove()"><i class="ri-delete-bin-line"></i></button></div>
                        </div>
                        <button class="btn btn-ghost btn-sm" style="margin-top:8px" onclick="addBullet(this)"><i class="ri-add-line"></i> Add Bullet</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 3 -->
        <div class="legal-section-row" data-section="3">
            <i class="ri-draggable drag-handle"></i>
            <div class="legal-section-inner">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
                    <div style="display:flex;align-items:center;gap:10px">
                        <span style="font-size:.72rem;font-weight:800;color:var(--text4);min-width:24px">03</span>
                        <input class="inp" value="3. How We Use Your Information" style="font-weight:700;font-size:.9rem;flex:1;max-width:400px">
                        <span class="section-badge active"><i class="ri-eye-line"></i> Visible</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:6px">
                        <button class="btn btn-ghost btn-sm" onclick="toggleSectionBody(this)"><i class="ri-arrow-down-s-line"></i></button>
                        <button class="btn btn-ghost btn-sm" onclick="toggleVisibility(this)"><i class="ri-eye-line"></i></button>
                        <button class="btn btn-danger btn-sm" onclick="deleteSection(this)"><i class="ri-delete-bin-line"></i></button>
                    </div>
                </div>
                <div class="section-body" style="display:none">
                    <div class="field-group">
                        <label class="label">Content Type</label>
                        <select class="inp" style="max-width:200px"><option>Bullet Points</option><option>Paragraphs</option><option>Mixed</option></select>
                    </div>
                    <div class="bullets-area">
                        <label class="label">Bullet Points</label>
                        <div class="bullets-list">
                            <div class="bullet-row"><i class="ri-draggable" style="color:var(--text4);cursor:grab"></i><input class="inp" value="To provide, operate, and improve the DRemind service."><button class="btn btn-danger btn-sm" onclick="this.closest('.bullet-row').remove()"><i class="ri-delete-bin-line"></i></button></div>
                            <div class="bullet-row"><i class="ri-draggable" style="color:var(--text4);cursor:grab"></i><input class="inp" value="To send reminder notifications, alerts, and service updates."><button class="btn btn-danger btn-sm" onclick="this.closest('.bullet-row').remove()"><i class="ri-delete-bin-line"></i></button></div>
                            <div class="bullet-row"><i class="ri-draggable" style="color:var(--text4);cursor:grab"></i><input class="inp" value="To process billing and manage your subscription."><button class="btn btn-danger btn-sm" onclick="this.closest('.bullet-row').remove()"><i class="ri-delete-bin-line"></i></button></div>
                            <div class="bullet-row"><i class="ri-draggable" style="color:var(--text4);cursor:grab"></i><input class="inp" value="To comply with legal obligations and protect user safety."><button class="btn btn-danger btn-sm" onclick="this.closest('.bullet-row').remove()"><i class="ri-delete-bin-line"></i></button></div>
                        </div>
                        <button class="btn btn-ghost btn-sm" style="margin-top:8px" onclick="addBullet(this)"><i class="ri-add-line"></i> Add Bullet</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 4 -->
        <div class="legal-section-row" data-section="4">
            <i class="ri-draggable drag-handle"></i>
            <div class="legal-section-inner">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
                    <div style="display:flex;align-items:center;gap:10px">
                        <span style="font-size:.72rem;font-weight:800;color:var(--text4);min-width:24px">04</span>
                        <input class="inp" value="4. Data Sharing & Third Parties" style="font-weight:700;font-size:.9rem;flex:1;max-width:400px">
                        <span class="section-badge active"><i class="ri-eye-line"></i> Visible</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:6px">
                        <button class="btn btn-ghost btn-sm" onclick="toggleSectionBody(this)"><i class="ri-arrow-down-s-line"></i></button>
                        <button class="btn btn-ghost btn-sm" onclick="toggleVisibility(this)"><i class="ri-eye-line"></i></button>
                        <button class="btn btn-danger btn-sm" onclick="deleteSection(this)"><i class="ri-delete-bin-line"></i></button>
                    </div>
                </div>
                <div class="section-body" style="display:none">
                    <div class="field-group"><label class="label">Content Type</label><select class="inp" style="max-width:200px"><option>Paragraphs</option><option>Bullets</option></select></div>
                    <div class="field-group"><label class="label">Paragraph 1</label><textarea class="inp-area inp" rows="3">We do not sell, rent, or trade your personal information to third parties for marketing purposes. Your data is yours.</textarea></div>
                    <div class="field-group"><label class="label">Paragraph 2</label><textarea class="inp-area inp" rows="3">We may share data with trusted service providers (e.g. payment processors, email delivery services) who act as data processors under strict confidentiality agreements and only to the extent necessary to deliver our service.</textarea></div>
                    <button class="btn btn-ghost btn-sm" onclick="addParagraph(this)"><i class="ri-add-line"></i> Add Paragraph</button>
                </div>
            </div>
        </div>

        <!-- Section 5 -->
        <div class="legal-section-row" data-section="5">
            <i class="ri-draggable drag-handle"></i>
            <div class="legal-section-inner">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
                    <div style="display:flex;align-items:center;gap:10px">
                        <span style="font-size:.72rem;font-weight:800;color:var(--text4);min-width:24px">05</span>
                        <input class="inp" value="5. Data Security" style="font-weight:700;font-size:.9rem;flex:1;max-width:400px">
                        <span class="section-badge active"><i class="ri-eye-line"></i> Visible</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:6px">
                        <button class="btn btn-ghost btn-sm" onclick="toggleSectionBody(this)"><i class="ri-arrow-down-s-line"></i></button>
                        <button class="btn btn-ghost btn-sm" onclick="toggleVisibility(this)"><i class="ri-eye-line"></i></button>
                        <button class="btn btn-danger btn-sm" onclick="deleteSection(this)"><i class="ri-delete-bin-line"></i></button>
                    </div>
                </div>
                <div class="section-body" style="display:none">
                    <div class="field-group"><label class="label">Content Type</label><select class="inp" style="max-width:200px"><option selected>Paragraphs</option><option>Bullets</option><option>Mixed</option></select></div>
                    <div class="field-group"><label class="label">Paragraph 1</label><textarea class="inp-area inp" rows="3">We use AES-256 encryption for all data at rest and TLS 1.3 for data in transit. We undergo annual third-party security audits and are fully GDPR, CCPA, and Australian Privacy Act compliant.</textarea></div>
                    <button class="btn btn-ghost btn-sm" onclick="addParagraph(this)"><i class="ri-add-line"></i> Add Paragraph</button>
                </div>
            </div>
        </div>

        <!-- Section 6 -->
        <div class="legal-section-row" data-section="6">
            <i class="ri-draggable drag-handle"></i>
            <div class="legal-section-inner">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
                    <div style="display:flex;align-items:center;gap:10px">
                        <span style="font-size:.72rem;font-weight:800;color:var(--text4);min-width:24px">06</span>
                        <input class="inp" value="6. Cookies & Tracking" style="font-weight:700;font-size:.9rem;flex:1;max-width:400px">
                        <span class="section-badge active"><i class="ri-eye-line"></i> Visible</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:6px">
                        <button class="btn btn-ghost btn-sm" onclick="toggleSectionBody(this)"><i class="ri-arrow-down-s-line"></i></button>
                        <button class="btn btn-ghost btn-sm" onclick="toggleVisibility(this)"><i class="ri-eye-line"></i></button>
                        <button class="btn btn-danger btn-sm" onclick="deleteSection(this)"><i class="ri-delete-bin-line"></i></button>
                    </div>
                </div>
                <div class="section-body" style="display:none">
                    <div class="field-group"><label class="label">Content Type</label><select class="inp" style="max-width:200px"><option selected>Paragraphs</option></select></div>
                    <div class="field-group"><label class="label">Paragraph 1</label><textarea class="inp-area inp" rows="3">We use essential cookies to keep you logged in and remember your preferences. We do not use third-party advertising cookies or cross-site tracking technologies.</textarea></div>
                    <button class="btn btn-ghost btn-sm" onclick="addParagraph(this)"><i class="ri-add-line"></i> Add Paragraph</button>
                </div>
            </div>
        </div>

        <!-- Section 7 -->
        <div class="legal-section-row" data-section="7">
            <i class="ri-draggable drag-handle"></i>
            <div class="legal-section-inner">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
                    <div style="display:flex;align-items:center;gap:10px">
                        <span style="font-size:.72rem;font-weight:800;color:var(--text4);min-width:24px">07</span>
                        <input class="inp" value="7. Your Rights (GDPR & CCPA)" style="font-weight:700;font-size:.9rem;flex:1;max-width:400px">
                        <span class="section-badge active"><i class="ri-eye-line"></i> Visible</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:6px">
                        <button class="btn btn-ghost btn-sm" onclick="toggleSectionBody(this)"><i class="ri-arrow-down-s-line"></i></button>
                        <button class="btn btn-ghost btn-sm" onclick="toggleVisibility(this)"><i class="ri-eye-line"></i></button>
                        <button class="btn btn-danger btn-sm" onclick="deleteSection(this)"><i class="ri-delete-bin-line"></i></button>
                    </div>
                </div>
                <div class="section-body" style="display:none">
                    <div class="field-group"><label class="label">Content Type</label><select class="inp" style="max-width:200px"><option>Paragraphs</option><option selected>Bullet Points</option></select></div>
                    <div class="bullets-area">
                        <div class="bullets-list">
                            <div class="bullet-row"><i class="ri-draggable" style="color:var(--text4);cursor:grab"></i><input class="inp" value="Right to access — Request a copy of all data we hold about you."><button class="btn btn-danger btn-sm" onclick="this.closest('.bullet-row').remove()"><i class="ri-delete-bin-line"></i></button></div>
                            <div class="bullet-row"><i class="ri-draggable" style="color:var(--text4);cursor:grab"></i><input class="inp" value="Right to rectification — Correct inaccurate personal data."><button class="btn btn-danger btn-sm" onclick="this.closest('.bullet-row').remove()"><i class="ri-delete-bin-line"></i></button></div>
                            <div class="bullet-row"><i class="ri-draggable" style="color:var(--text4);cursor:grab"></i><input class="inp" value="Right to erasure — Request deletion of your personal data."><button class="btn btn-danger btn-sm" onclick="this.closest('.bullet-row').remove()"><i class="ri-delete-bin-line"></i></button></div>
                            <div class="bullet-row"><i class="ri-draggable" style="color:var(--text4);cursor:grab"></i><input class="inp" value="Right to portability — Export your data in a machine-readable format."><button class="btn btn-danger btn-sm" onclick="this.closest('.bullet-row').remove()"><i class="ri-delete-bin-line"></i></button></div>
                            <div class="bullet-row"><i class="ri-draggable" style="color:var(--text4);cursor:grab"></i><input class="inp" value="Right to object — Opt out of processing for certain purposes."><button class="btn btn-danger btn-sm" onclick="this.closest('.bullet-row').remove()"><i class="ri-delete-bin-line"></i></button></div>
                        </div>
                        <button class="btn btn-ghost btn-sm" style="margin-top:8px" onclick="addBullet(this)"><i class="ri-add-line"></i> Add Bullet</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 8 -->
        <div class="legal-section-row" data-section="8">
            <i class="ri-draggable drag-handle"></i>
            <div class="legal-section-inner">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
                    <div style="display:flex;align-items:center;gap:10px">
                        <span style="font-size:.72rem;font-weight:800;color:var(--text4);min-width:24px">08</span>
                        <input class="inp" value="8. Data Retention" style="font-weight:700;font-size:.9rem;flex:1;max-width:400px">
                        <span class="section-badge active"><i class="ri-eye-line"></i> Visible</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:6px">
                        <button class="btn btn-ghost btn-sm" onclick="toggleSectionBody(this)"><i class="ri-arrow-down-s-line"></i></button>
                        <button class="btn btn-ghost btn-sm" onclick="toggleVisibility(this)"><i class="ri-eye-line"></i></button>
                        <button class="btn btn-danger btn-sm" onclick="deleteSection(this)"><i class="ri-delete-bin-line"></i></button>
                    </div>
                </div>
                <div class="section-body" style="display:none">
                    <div class="field-group"><label class="label">Paragraph 1</label><textarea class="inp-area inp" rows="3">We retain your personal data only as long as necessary to provide the service or as required by law. Upon account deletion, your data is permanently removed within 30 days.</textarea></div>
                    <button class="btn btn-ghost btn-sm" onclick="addParagraph(this)"><i class="ri-add-line"></i> Add Paragraph</button>
                </div>
            </div>
        </div>

        <!-- Section 9 -->
        <div class="legal-section-row" data-section="9">
            <i class="ri-draggable drag-handle"></i>
            <div class="legal-section-inner">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
                    <div style="display:flex;align-items:center;gap:10px">
                        <span style="font-size:.72rem;font-weight:800;color:var(--text4);min-width:24px">09</span>
                        <input class="inp" value="9. International Transfers" style="font-weight:700;font-size:.9rem;flex:1;max-width:400px">
                        <span class="section-badge active"><i class="ri-eye-line"></i> Visible</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:6px">
                        <button class="btn btn-ghost btn-sm" onclick="toggleSectionBody(this)"><i class="ri-arrow-down-s-line"></i></button>
                        <button class="btn btn-ghost btn-sm" onclick="toggleVisibility(this)"><i class="ri-eye-line"></i></button>
                        <button class="btn btn-danger btn-sm" onclick="deleteSection(this)"><i class="ri-delete-bin-line"></i></button>
                    </div>
                </div>
                <div class="section-body" style="display:none">
                    <div class="field-group"><label class="label">Paragraph 1</label><textarea class="inp-area inp" rows="3">DRemind operates globally. When data is transferred outside the EU/EEA, we ensure adequate protections via Standard Contractual Clauses (SCCs) or equivalent mechanisms.</textarea></div>
                    <button class="btn btn-ghost btn-sm" onclick="addParagraph(this)"><i class="ri-add-line"></i> Add Paragraph</button>
                </div>
            </div>
        </div>

        <!-- Section 10 -->
        <div class="legal-section-row" data-section="10">
            <i class="ri-draggable drag-handle"></i>
            <div class="legal-section-inner">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
                    <div style="display:flex;align-items:center;gap:10px">
                        <span style="font-size:.72rem;font-weight:800;color:var(--text4);min-width:24px">10</span>
                        <input class="inp" value="10. Changes to This Policy" style="font-weight:700;font-size:.9rem;flex:1;max-width:400px">
                        <span class="section-badge active"><i class="ri-eye-line"></i> Visible</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:6px">
                        <button class="btn btn-ghost btn-sm" onclick="toggleSectionBody(this)"><i class="ri-arrow-down-s-line"></i></button>
                        <button class="btn btn-ghost btn-sm" onclick="toggleVisibility(this)"><i class="ri-eye-line"></i></button>
                        <button class="btn btn-danger btn-sm" onclick="deleteSection(this)"><i class="ri-delete-bin-line"></i></button>
                    </div>
                </div>
                <div class="section-body" style="display:none">
                    <div class="field-group"><label class="label">Paragraph 1</label><textarea class="inp-area inp" rows="3">We may update this Privacy Policy periodically. We'll notify you of material changes via email or an in-app notice at least 14 days before they take effect.</textarea></div>
                    <button class="btn btn-ghost btn-sm" onclick="addParagraph(this)"><i class="ri-add-line"></i> Add Paragraph</button>
                </div>
            </div>
        </div>

        <!-- Section 11 -->
        <div class="legal-section-row" data-section="11">
            <i class="ri-draggable drag-handle"></i>
            <div class="legal-section-inner">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
                    <div style="display:flex;align-items:center;gap:10px">
                        <span style="font-size:.72rem;font-weight:800;color:var(--text4);min-width:24px">11</span>
                        <input class="inp" value="11. Contact Us" style="font-weight:700;font-size:.9rem;flex:1;max-width:400px">
                        <span class="section-badge active"><i class="ri-eye-line"></i> Visible</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:6px">
                        <button class="btn btn-ghost btn-sm" onclick="toggleSectionBody(this)"><i class="ri-arrow-down-s-line"></i></button>
                        <button class="btn btn-ghost btn-sm" onclick="toggleVisibility(this)"><i class="ri-eye-line"></i></button>
                        <button class="btn btn-danger btn-sm" onclick="deleteSection(this)"><i class="ri-delete-bin-line"></i></button>
                    </div>
                </div>
                <div class="section-body" style="display:none">
                    <div class="field-group"><label class="label">Paragraph</label><textarea class="inp-area inp" rows="2">For privacy-related questions or to exercise your rights, please contact our Data Protection Officer at info@winngoodremind.co.uk.</textarea></div>
                    <div class="g2">
                        <div class="field-group"><label class="label">Contact Email</label><input class="inp" value="info@winngoodremind.co.uk" type="email"></div>
                        <div class="field-group"><label class="label">DPO Name (optional)</label><input class="inp" placeholder="Data Protection Officer name"></div>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /sections-list -->

    <!-- Global settings -->
    <div class="section-card" style="margin-top:20px">
        <div class="section-title" style="margin-bottom:14px"><i class="ri-settings-3-line"></i> Document Settings</div>
        <div class="g2">
            <div class="field-group"><label class="label">Document Title (shown in heading)</label><input class="inp" value="Privacy Policy"></div>
            <div class="field-group"><label class="label">Effective Date</label><input class="inp" type="date" value="2026-04-28"></div>
        </div>
        <div class="g2">
            <div class="field-group"><label class="label">Governing Law</label><input class="inp" value="United Kingdom"></div>
            <div class="field-group"><label class="label">Version Number</label><input class="inp" value="2.1"></div>
        </div>
        <div class="field-group"><label class="label">Show "Last Updated" date on frontend</label>
            <label class="toggle-switch" style="margin-top:6px"><input type="checkbox" checked><span class="toggle-slider"></span></label>
        </div>
    </div>

</div>

<!-- HERO TAB -->
<div class="cms-tab-content" id="tab-hero">
    <div class="section-card">
        <div class="section-title" style="margin-bottom:14px"><i class="ri-flag-line"></i> Hero Section</div>
        <div class="g2">
            <div class="field-group"><label class="label">Badge Text</label><input class="inp" value="Privacy Policy"></div>
            <div class="field-group"><label class="label">Badge Icon</label><input class="inp" value="ri-shield-user-line" placeholder="Remix Icon class"></div>
        </div>
        <div class="g2">
            <div class="field-group"><label class="label">Headline (before gradient)</label><input class="inp" value="Your data."></div>
            <div class="field-group"><label class="label">Headline Gradient Text</label><input class="inp" value="Your control."></div>
        </div>
        <div class="field-group"><label class="label">Subheadline</label><textarea class="inp-area inp" rows="2">We take privacy and security seriously. Review the key policies that govern how DRemind works.</textarea></div>
        <div class="g2">
            <div class="field-group"><label class="label">Breadcrumb Parent Label</label><input class="inp" value="Home"></div>
            <div class="field-group"><label class="label">Breadcrumb Parent Link</label><input class="inp" value="index"></div>
        </div>
        <div class="field-group"><label class="label">Breadcrumb Current Label</label><input class="inp" value="Legal"></div>
        <div class="g2">
            <div class="field-group"><label class="label">Particle Theme</label><select class="inp"><option>purple</option><option>cyan</option><option>mixed</option></select></div>
            <div class="field-group"><label class="label">Particle Count</label><input class="inp" type="number" value="40"></div>
        </div>
    </div>
</div>

<!-- SEO TAB -->
<div class="cms-tab-content" id="tab-seo">
    <div class="g2" style="align-items:start">
        <div style="flex:2">
            <div class="section-card">
                <div class="section-title" style="margin-bottom:14px"><i class="ri-file-text-line"></i> Page Meta</div>
                <div class="field-group"><label class="label">Meta Title</label><input class="inp" id="mt" value="Privacy Policy — DRemind" oninput="cc('mt','tc-mt',60)"><div class="char-count" id="tc-mt">23/60</div></div>
                <div class="field-group"><label class="label">Meta Description</label><textarea class="inp-area inp" id="md" rows="3" oninput="cc('md','tc-md',160)">DRemind's Privacy Policy — how we collect, use, protect and respect your personal data. GDPR, CCPA, and APPs compliant.</textarea><div class="char-count" id="tc-md">120/160</div></div>
                <div class="field-group"><label class="label">Keywords</label><input class="inp" value="DRemind privacy policy, data protection, GDPR, CCPA, personal data"></div>
                <div class="field-group"><label class="label">Canonical URL</label><input class="inp" value="https://dremin.co.uk/privacy"></div>
                <div class="g2">
                    <div class="field-group"><label class="label">Robots</label><select class="inp"><option>index, follow</option><option>noindex, follow</option></select></div>
                    <div class="field-group"><label class="label">Priority</label><select class="inp"><option>0.3 — Low</option><option>0.5 — Normal</option></select></div>
                </div>
            </div>
            <div class="section-card">
                <div class="section-title" style="margin-bottom:14px"><i class="ri-code-line"></i> Schema</div>
                <div class="field-group"><label class="label">Schema Type</label><select class="inp"><option>WebPage</option><option>PrivacyPolicy</option><option>Custom JSON-LD</option></select></div>
                @verbatim
                <textarea class="inp-area inp" rows="5" style="font-family:monospace;font-size:.78rem">{
                    "@context": "https://schema.org",
                    "@type": "WebPage",
                    "name": "Privacy Policy",
                    "url": "https://dremin.co.uk/privacy"
                    }
                </textarea>
                @endverbatim
            </div>
        </div>
        <div>
            <div class="card" style="padding:18px;position:sticky;top:90px">
                <div class="section-title" style="margin-bottom:14px"><i class="ri-google-line"></i> SERP Preview</div>
                <div style="background:var(--bg2);border-radius:12px;padding:14px;border:1px solid var(--border)">
                    <div style="font-size:.65rem;color:var(--text4);margin-bottom:4px">dremin.co.uk › privacy</div>
                    <div style="font-size:.95rem;color:#8ab4f8;font-weight:500;margin-bottom:5px">Privacy Policy — DRemind</div>
                    <div style="font-size:.8rem;color:var(--text3);line-height:1.6">DRemind's Privacy Policy — how we collect, use, protect and respect your personal data. GDPR, CCPA, and APPs compliant.</div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Add Section Modal -->
<div class="modal-bg" id="add-section-modal">
    <div class="modal-box" style="max-width:560px">
        <div class="modal-header">
            <div><h3 class="font-jakarta" style="font-weight:700;font-size:.95rem"><i class="ri-add-circle-line" style="color:var(--purple);margin-right:6px"></i>Add Policy Section</h3></div>
            <button class="modal-close" onclick="closeModal('add-section-modal')"><i class="ri-close-line"></i></button>
        </div>
        <div class="field-group"><label class="label">Section Title <span style="color:var(--red)">*</span></label><input class="inp" id="new-section-title" placeholder="e.g. 12. Children's Privacy"></div>
        <div class="field-group"><label class="label">Content Type</label><select class="inp" id="new-section-type"><option>Paragraphs</option><option>Bullet Points</option><option>Mixed</option></select></div>
        <div class="field-group"><label class="label">Initial Content</label><textarea class="inp-area inp" id="new-section-content" rows="4" placeholder="Enter the section content..."></textarea></div>
        <div class="field-group"><label class="label">Position</label><select class="inp" id="new-section-pos"><option>End of document</option><option>After section 1</option><option>After section 5</option><option>After section 10</option></select></div>
        <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:8px">
            <button class="btn btn-ghost btn-sm" onclick="closeModal('add-section-modal')">Cancel</button>
            <button class="btn btn-primary btn-sm" onclick="addSection()"><i class="ri-check-line"></i> Add Section</button>
        </div>
    </div>
</div>

<script>
function switchTab(t){document.querySelectorAll('.cms-tab-content').forEach(c=>c.classList.remove('active'));document.querySelectorAll('.cms-tab-btn').forEach(b=>b.classList.remove('active'));document.getElementById('tab-'+t).classList.add('active');document.getElementById('tab-btn-'+t).classList.add('active')}
function cc(i,c,m){var el=document.getElementById(i),cnt=document.getElementById(c);if(!el||!cnt)return;var l=el.value.length;cnt.textContent=l+'/'+m;cnt.className='char-count'+(l>m?' bad':l>m*.85?' warn':'')}
function toggleSectionBody(btn){var body=btn.closest('.legal-section-inner').querySelector('.section-body');var icon=btn.querySelector('i');if(!body)return;var hidden=body.style.display==='none';body.style.display=hidden?'':'none';icon.className=hidden?'ri-arrow-up-s-line':'ri-arrow-down-s-line'}
function toggleVisibility(btn){var badge=btn.closest('.legal-section-inner').querySelector('.section-badge');var active=badge.classList.contains('active');badge.classList.toggle('active',!active);badge.classList.toggle('hidden',active);badge.innerHTML=active?'<i class="ri-eye-off-line"></i> Hidden':'<i class="ri-eye-line"></i> Visible'}
function deleteSection(btn){if(confirm('Delete this section?'))btn.closest('.legal-section-row').remove();updateCount()}
function updateCount(){document.getElementById('section-count').textContent=document.querySelectorAll('#sections-list .legal-section-row').length+' Sections'}
function expandAll(){document.querySelectorAll('.section-body').forEach(b=>b.style.display='');document.querySelectorAll('[onclick="toggleSectionBody(this)"] i').forEach(i=>i.className='ri-arrow-up-s-line')}
function collapseAll(){document.querySelectorAll('.section-body').forEach(b=>b.style.display='none');document.querySelectorAll('[onclick="toggleSectionBody(this)"] i').forEach(i=>i.className='ri-arrow-down-s-line')}
function addParagraph(btn){var container=btn.closest('.section-body');var fg=document.createElement('div');fg.className='field-group';var count=container.querySelectorAll('textarea').length+1;fg.innerHTML='<label class="label">Paragraph '+count+'</label><textarea class="inp-area inp" rows="3" placeholder="Enter paragraph text..."></textarea><button class="btn btn-danger btn-sm" style="margin-top:4px" onclick="this.closest(\'.field-group\').remove()"><i class="ri-delete-bin-line"></i></button>';btn.before(fg)}
function addBullet(btn){var list=btn.previousElementSibling;var row=document.createElement('div');row.className='bullet-row';row.innerHTML='<i class="ri-draggable" style="color:var(--text4);cursor:grab"></i><input class="inp" placeholder="Enter bullet point..."><button class="btn btn-danger btn-sm" onclick="this.closest(\'.bullet-row\').remove()"><i class="ri-delete-bin-line"></i></button>';list.appendChild(row)}
function switchContentType(sel){var body=sel.closest('.section-body');var v=sel.value;body.querySelectorAll('.paragraphs-area,.bullets-area').forEach(a=>a.style.display='none');var target=v==='bullets'?body.querySelector('.bullets-area'):body.querySelector('.paragraphs-area');if(target)target.style.display=''}
function addSection(){var t=document.getElementById('new-section-title').value.trim();if(!t){if(typeof toast==='function')toast('Section title required','error');return}if(typeof toast==='function')toast('Section added!','success');closeModal('add-section-modal');updateCount()}
function updateDate(){document.getElementById('lastUpdated').textContent=new Date().toLocaleDateString('en-GB',{day:'numeric',month:'short',year:'numeric'})}
function saveAll(){if(typeof toast==='function')toast('Privacy Policy saved!','success');else alert('Saved!')}
</script>

@endsection
