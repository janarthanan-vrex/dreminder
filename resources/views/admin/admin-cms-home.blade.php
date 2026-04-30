@extends('admin.layouts.app')
@section('content')

<style>
.cms-tab-btn{padding:10px 18px;background:transparent;border:none;color:var(--text3);font-size:.8rem;font-weight:600;cursor:pointer;border-bottom:2px solid transparent;transition:all .2s;display:flex;align-items:center;gap:6px}
.cms-tab-btn:hover{color:var(--text2)}
.cms-tab-btn.active{color:var(--purple);border-bottom-color:var(--purple)}
.cms-tab-content{display:none}.cms-tab-content.active{display:block}
.field-group{margin-bottom:16px}
.field-group .label{margin-bottom:6px;display:block;font-size:.75rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em}
.inp-area{width:100%;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:10px 14px;color:var(--text);font-size:.85rem;resize:vertical;font-family:inherit;transition:border-color .2s}
.inp-area:focus{outline:none;border-color:var(--purple)}
.seo-score{display:flex;align-items:center;gap:10px;padding:14px 18px;border-radius:12px;background:rgba(16,185,129,.06);border:1px solid rgba(16,185,129,.15);margin-bottom:16px}
.seo-score-circle{width:52px;height:52px;border-radius:50%;background:conic-gradient(var(--green) 0% 78%,var(--border) 78%);display:flex;align-items:center;justify-content:center;font-size:.8rem;font-weight:800;color:var(--green);position:relative;flex-shrink:0}
.char-count{font-size:.68rem;color:var(--text4);text-align:right;margin-top:4px}
.char-count.warn{color:var(--amber)} .char-count.bad{color:var(--red)}
.section-card{background:var(--card);border:1px solid var(--border);border-radius:var(--radius);padding:20px;margin-bottom:14px}
.section-card-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;cursor:pointer}
.section-card-header h4{font-size:.9rem;font-weight:700;color:var(--text);display:flex;align-items:center;gap:8px}
.toggle-switch{position:relative;width:40px;height:22px;flex-shrink:0}
.toggle-switch input{opacity:0;width:0;height:0}
.toggle-slider{position:absolute;inset:0;background:var(--ctrl-bg);border-radius:22px;cursor:pointer;transition:.3s}
.toggle-slider::before{content:'';position:absolute;width:16px;height:16px;left:3px;top:3px;background:var(--text);border-radius:50%;transition:.3s}
.toggle-switch input:checked+.toggle-slider{background:var(--purple)}
.toggle-switch input:checked+.toggle-slider::before{transform:translateX(18px)}
.sortable-list{display:flex;flex-direction:column;gap:8px}
.sortable-item{display:flex;align-items:center;gap:10px;padding:10px 14px;background:var(--row-bg);border:1px solid var(--border);border-radius:var(--radius-sm);cursor:grab}
.sortable-item:active{cursor:grabbing;opacity:.7}
.drag-handle{color:var(--text4);font-size:1.1rem}
.feature-row{display:grid;grid-template-columns:40px 1fr 1fr auto;gap:8px;align-items:center;margin-bottom:8px}
.icon-picker{display:flex;flex-wrap:wrap;gap:6px;max-height:160px;overflow-y:auto;padding:8px;background:var(--bg3);border-radius:var(--radius-sm);border:1px solid var(--border2)}
.icon-opt{width:34px;height:34px;display:flex;align-items:center;justify-content:center;border-radius:var(--radius-xs);cursor:pointer;font-size:1rem;transition:all .2s;border:1px solid transparent}
.icon-opt:hover{background:rgba(124,58,237,.15);border-color:rgba(124,58,237,.3)}
.icon-opt.selected{background:rgba(124,58,237,.2);border-color:var(--purple);color:var(--purple)}
.preview-badge{display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:var(--radius-xs);font-size:.7rem;font-weight:700;background:rgba(6,182,212,.1);color:var(--cyan);border:1px solid rgba(6,182,212,.15)}
</style>

<div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px">
    <div>
        <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800">CMS — Home Page</h2>
        <p style="font-size:.8rem;color:var(--text3);margin-top:3px">Edit content, sections, and SEO for the homepage</p>
    </div>
    <div style="display:flex;gap:8px">
        <a href="index" target="_blank" class="btn btn-ghost btn-sm"><i class="ri-eye-line"></i> Preview</a>
        <button class="btn btn-primary btn-sm" onclick="saveAll()"><i class="ri-save-line"></i> Save & Publish</button>
    </div>
</div>

<!-- Tabs -->
<div style="display:flex;gap:8px;margin-bottom:20px;border-bottom:2px solid rgba(255,255,255,.05)">
    <button class="cms-tab-btn active" onclick="switchTab('content')" id="tab-btn-content"><i class="ri-layout-line"></i> Content</button>
    <button class="cms-tab-btn" onclick="switchTab('seo')" id="tab-btn-seo"><i class="ri-search-eye-line"></i> SEO & Meta</button>
</div>

<!-- CONTENT TAB -->
<div class="cms-tab-content active" id="tab-content">

    <!-- Hero Section -->
    <div class="section-card">
        <div class="section-card-header" onclick="toggleSection('hero')">
            <h4><i class="ri-home-4-line" style="color:var(--purple)"></i> Hero Section</h4>
            <div style="display:flex;align-items:center;gap:10px">
                <span class="preview-badge"><i class="ri-eye-line"></i> Visible</span>
                <i class="ri-arrow-down-s-line" id="hero-arrow" style="color:var(--text3);transition:.3s"></i>
            </div>
        </div>
        <div id="hero-body">
            <div class="g2">
                <div class="field-group">
                    <label class="label">Main Headline Line 1</label>
                    <input class="inp" value="Never Miss" placeholder="e.g. Never Miss">
                </div>
                <div class="field-group">
                    <label class="label">Headline Line 2 (Gradient Text)</label>
                    <input class="inp" value="A Payment" placeholder="e.g. A Payment">
                </div>
            </div>
            <div class="g2">
                <div class="field-group">
                    <label class="label">Headline Line 3</label>
                    <input class="inp" value="Again." placeholder="Line 3">
                </div>
                <div class="field-group">
                    <label class="label">Subheadline</label>
                    <input class="inp" value="Winngoo DRemind intelligently tracks your bills..." placeholder="Subheadline text">
                </div>
            </div>
            <div class="field-group">
                <label class="label">Supporting Text (small)</label>
                <input class="inp" value="Join 50,000+ users who save an average of $480/year...">
            </div>
            <div class="g2">
                <div class="field-group">
                    <label class="label">Primary CTA Label</label>
                    <input class="inp" value="Download Free">
                </div>
                <div class="field-group">
                    <label class="label">Primary CTA URL</label>
                    <input class="inp" value="#cta" placeholder="#cta or /register">
                </div>
            </div>
            <div class="g2">
                <div class="field-group">
                    <label class="label">Secondary CTA Label</label>
                    <input class="inp" value="Explore Features">
                </div>
                <div class="field-group">
                    <label class="label">Secondary CTA URL</label>
                    <input class="inp" value="#features">
                </div>
            </div>
            <div class="g2">
                <div class="field-group">
                    <label class="label">Trust Stat 1 (Rating)</label>
                    <input class="inp" value="4.9 Rating">
                </div>
                <div class="field-group">
                    <label class="label">Trust Stat 2</label>
                    <input class="inp" value="Bank-Grade Security">
                </div>
            </div>
        </div>
    </div>

    <!-- How It Works -->
    <div class="section-card">
        <div class="section-card-header" onclick="toggleSection('hiw')">
            <h4><i class="ri-flow-chart" style="color:var(--cyan,#06b6d4)"></i> How It Works</h4>
            <div style="display:flex;align-items:center;gap:10px">
                <label class="toggle-switch" onclick="e=>e.stopPropagation()">
                    <input type="checkbox" checked id="hiw-visible">
                    <span class="toggle-slider"></span>
                </label>
                <i class="ri-arrow-down-s-line" id="hiw-arrow" style="color:var(--text3);transition:.3s"></i>
            </div>
        </div>
        <div id="hiw-body">
            <div class="g2" style="margin-bottom:12px">
                <div class="field-group">
                    <label class="label">Section Heading</label>
                    <input class="inp" value="How It Works">
                </div>
                <div class="field-group">
                    <label class="label">Section Subheading</label>
                    <input class="inp" value="Register in three simple steps and take control of your payments forever.">
                </div>
            </div>
            <div class="section-title" style="margin-bottom:10px">Steps (3)</div>
            <div id="hiw-steps" class="sortable-list">
                <!-- Step 1 -->
                <div class="sortable-item">
                    <i class="ri-draggable drag-handle"></i>
                    <div style="flex:1;display:grid;grid-template-columns:1fr 2fr;gap:8px">
                        <input class="inp" value="Add Your Reminders" placeholder="Step title">
                        <input class="inp" value="Set up your bills, subscriptions..." placeholder="Step description">
                    </div>
                    <select class="inp" style="width:auto">
                        <option>ri-add-circle-line</option><option>ri-notification-badge-line</option><option>ri-wallet-3-line</option>
                    </select>
                </div>
                <div class="sortable-item">
                    <i class="ri-draggable drag-handle"></i>
                    <div style="flex:1;display:grid;grid-template-columns:1fr 2fr;gap:8px">
                        <input class="inp" value="Get Smart Alerts" placeholder="Step title">
                        <input class="inp" value="Receive intelligent notifications..." placeholder="Step description">
                    </div>
                    <select class="inp" style="width:auto">
                        <option>ri-notification-badge-line</option><option>ri-add-circle-line</option><option>ri-wallet-3-line</option>
                    </select>
                </div>
                <div class="sortable-item">
                    <i class="ri-draggable drag-handle"></i>
                    <div style="flex:1;display:grid;grid-template-columns:1fr 2fr;gap:8px">
                        <input class="inp" value="Save Money" placeholder="Step title">
                        <input class="inp" value="Compare prices before renewals..." placeholder="Step description">
                    </div>
                    <select class="inp" style="width:auto">
                        <option>ri-wallet-3-line</option><option>ri-add-circle-line</option><option>ri-notification-badge-line</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Use Cases / Bento Grid -->
    <div class="section-card">
        <div class="section-card-header" onclick="toggleSection('usecases')">
            <h4><i class="ri-grid-line" style="color:var(--green,#10b981)"></i> Use Cases (Bento Grid)</h4>
            <div style="display:flex;align-items:center;gap:10px">
                <label class="toggle-switch"><input type="checkbox" checked id="usecases-visible"><span class="toggle-slider"></span></label>
                <i class="ri-arrow-down-s-line" id="usecases-arrow" style="color:var(--text3);transition:.3s"></i>
            </div>
        </div>
        <div id="usecases-body">
            <div class="g2" style="margin-bottom:12px">
                <div class="field-group"><label class="label">Section Title</label><input class="inp" value="Built For Everyone"></div>
                <div class="field-group"><label class="label">Section Subtitle</label><input class="inp" value="From individuals to families and small businesses — DRemind adapts to your life."></div>
            </div>
            <div class="section-title" style="margin-bottom:10px">Bento Cards</div>
            <div id="bento-cards" class="sortable-list">
                <div class="sortable-item"><i class="ri-draggable drag-handle"></i><div style="flex:1;display:grid;grid-template-columns:1fr 2fr;gap:8px"><input class="inp" value="Track All Subscriptions"><input class="inp" value="Keep all your streaming, software..."></div><span class="badge badge-purple">Featured</span></div>
                <div class="sortable-item"><i class="ri-draggable drag-handle"></i><div style="flex:1;display:grid;grid-template-columns:1fr 2fr;gap:8px"><input class="inp" value="Insurance Alerts"><input class="inp" value="Get warned 30, 14, and 3 days before..."></div><span class="badge badge-red">Normal</span></div>
                <div class="sortable-item"><i class="ri-draggable drag-handle"></i><div style="flex:1;display:grid;grid-template-columns:1fr 2fr;gap:8px"><input class="inp" value="Price Comparison"><input class="inp" value="Before auto-renew, DRemind checks..."></div><span class="badge badge-amber">Normal</span></div>
                <div class="sortable-item"><i class="ri-draggable drag-handle"></i><div style="flex:1;display:grid;grid-template-columns:1fr 2fr;gap:8px"><input class="inp" value="Renewal Notifications"><input class="inp" value="Annual domains, licenses, warranties..."></div><span class="badge" style="background:rgba(6,182,212,.1);color:var(--secondary,#06b6d4)">Normal</span></div>
                <div class="sortable-item"><i class="ri-draggable drag-handle"></i><div style="flex:1;display:grid;grid-template-columns:1fr 2fr;gap:8px"><input class="inp" value="Smart Budget Alerts"><input class="inp" value="Set monthly spending limits..."></div><span class="badge" style="background:rgba(236,72,153,.1);color:#f472b6">Normal</span></div>
                <div class="sortable-item"><i class="ri-draggable drag-handle"></i><div style="flex:1;display:grid;grid-template-columns:1fr 2fr;gap:8px"><input class="inp" value="Family Management"><input class="inp" value="Share household bills..."></div><span class="badge badge-green">Normal</span></div>
            </div>
            <button class="btn btn-ghost btn-sm" style="margin-top:10px" onclick="addBentoCard()"><i class="ri-add-line"></i> Add Card</button>
        </div>
    </div>

    <!-- Global Network Section -->
    <div class="section-card">
        <div class="section-card-header" onclick="toggleSection('globe')">
            <h4><i class="ri-global-line" style="color:var(--amber,#f59e0b)"></i> Global Network Section</h4>
            <div style="display:flex;align-items:center;gap:10px">
                <label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label>
                <i class="ri-arrow-down-s-line" id="globe-arrow" style="color:var(--text3);transition:.3s"></i>
            </div>
        </div>
        <div id="globe-body">
            <div class="g2" style="margin-bottom:12px">
                <div class="field-group"><label class="label">Section Title</label><input class="inp" value="Trusted Worldwide"></div>
                <div class="field-group"><label class="label">Subtitle</label><input class="inp" value="Our intelligent network spans the globe, protecting users' finances across 140+ countries."></div>
            </div>
            <div class="section-title" style="margin-bottom:10px">Feature Points</div>
            <div id="globe-points" class="sortable-list">
                <div class="sortable-item"><i class="ri-draggable drag-handle"></i><div style="flex:1;display:grid;grid-template-columns:1fr 2fr;gap:8px"><input class="inp" value="Predictive Analytics"><input class="inp" value="Analyzes your spending patterns..."></div><input class="inp" placeholder="ri-brain-line" value="ri-brain-line" style="width:140px"></div>
                <div class="sortable-item"><i class="ri-draggable drag-handle"></i><div style="flex:1;display:grid;grid-template-columns:1fr 2fr;gap:8px"><input class="inp" value="Real-Time Monitoring"><input class="inp" value="Continuously monitors subscription..."></div><input class="inp" placeholder="ri-flashlight-line" value="ri-flashlight-line" style="width:140px"></div>
                <div class="sortable-item"><i class="ri-draggable drag-handle"></i><div style="flex:1;display:grid;grid-template-columns:1fr 2fr;gap:8px"><input class="inp" value="Bank-Grade Security"><input class="inp" value="256-bit AES encryption..."></div><input class="inp" placeholder="ri-lock-2-line" value="ri-lock-2-line" style="width:140px"></div>
                <div class="sortable-item"><i class="ri-draggable drag-handle"></i><div style="flex:1;display:grid;grid-template-columns:1fr 2fr;gap:8px"><input class="inp" value="Spending Insights Dashboard"><input class="inp" value="Visual breakdowns of where..."></div><input class="inp" placeholder="ri-bar-chart-grouped-line" value="ri-bar-chart-grouped-line" style="width:140px"></div>
            </div>
            <button class="btn btn-ghost btn-sm" style="margin-top:10px"><i class="ri-add-line"></i> Add Point</button>
        </div>
    </div>

</div>

<!-- SEO TAB -->
<div class="cms-tab-content" id="tab-seo">
    <div class="g2" style="align-items:start;gap:16px">
        <div style="flex:2">
            <div class="section-card" style="margin-bottom:14px">
                <div class="section-title" style="margin-bottom:14px"><i class="ri-file-text-line"></i> Page Meta</div>
                <div class="field-group">
                    <label class="label">Meta Title <span style="color:var(--text4);font-weight:400;text-transform:none">(50–60 chars recommended)</span></label>
                    <input class="inp" id="meta-title" value="DRemind — Never Miss A Payment Again" oninput="updateCharCount('meta-title','tc-title',60)">
                    <div class="char-count" id="tc-title">37/60</div>
                </div>
                <div class="field-group">
                    <label class="label">Meta Description <span style="color:var(--text4);font-weight:400;text-transform:none">(150–160 chars recommended)</span></label>
                    <textarea class="inp-area inp" id="meta-desc" rows="3" oninput="updateCharCount('meta-desc','tc-desc',160)">DRemind intelligently tracks your bills, subscriptions and insurance renewals. Join 50,000+ users saving an average of $480/year.</textarea>
                    <div class="char-count" id="tc-desc">131/160</div>
                </div>
                <div class="field-group">
                    <label class="label">Meta Keywords</label>
                    <input class="inp" value="payment reminders, subscription tracker, bill reminder, insurance renewal, DRemind" placeholder="keyword1, keyword2, ...">
                </div>
                <div class="field-group">
                    <label class="label">Canonical URL</label>
                    <input class="inp" value="https://dremin.co.uk/" placeholder="https://yourdomain.com/">
                </div>
            </div>

            <div class="section-card" style="margin-bottom:14px">
                <div class="section-title" style="margin-bottom:14px"><i class="ri-robot-line"></i> Robots & Indexing</div>
                <div class="g2">
                    <div class="field-group">
                        <label class="label">Robots Meta</label>
                        <select class="inp">
                            <option>index, follow</option>
                            <option>noindex, follow</option>
                            <option>index, nofollow</option>
                            <option>noindex, nofollow</option>
                        </select>
                    </div>
                    <div class="field-group">
                        <label class="label">Priority (Sitemap)</label>
                        <select class="inp">
                            <option>1.0 — Homepage</option>
                            <option>0.8 — High</option>
                            <option>0.5 — Normal</option>
                            <option>0.3 — Low</option>
                        </select>
                    </div>
                </div>
                <div class="field-group">
                    <label class="label">Change Frequency (Sitemap)</label>
                    <select class="inp"><option>daily</option><option>weekly</option><option>monthly</option></select>
                </div>
            </div>

            <div class="section-card">
                <div class="section-title" style="margin-bottom:14px"><i class="ri-code-line"></i> Schema Markup</div>
                <div class="field-group">
                    <label class="label">Schema Type</label>
                    <select class="inp" onchange="updateSchema(this.value)">
                        <option>WebSite</option>
                        <option>Organization</option>
                        <option>SoftwareApplication</option>
                        <option>Custom JSON-LD</option>
                    </select>
                </div>
                <div class="field-group">
                    <label class="label">Custom JSON-LD (Optional override)</label>
                    @verbatim
                    <textarea class="inp-area inp" rows="6" style="font-family:monospace;font-size:.8rem">{
                        "@context": "https://schema.org",
                        "@type": "SoftwareApplication",
                        "name": "DRemind",
                        "applicationCategory": "FinanceApplication",
                        "operatingSystem": "iOS, Android, Web",
                        "offers": {
                            "@type": "Offer",
                            "price": "0",
                            "priceCurrency": "GBP"
                        }
                        }</textarea>
                        @endverbatim
                </div>
            </div>
        </div>

        <!-- SERP Preview -->
        <div style="flex:1">
            <div class="card" style="padding:18px;position:sticky;top:90px">
                <div class="section-title" style="margin-bottom:14px"><i class="ri-google-line"></i> SERP Preview</div>
                <div style="background:var(--bg2);border-radius:12px;padding:16px 18px;border:1px solid var(--border)">
                    <div style="font-size:.68rem;color:var(--text4);margin-bottom:5px">https://dremin.co.uk</div>
                    <div style="font-size:1rem;color:#8ab4f8;font-weight:500;margin-bottom:6px;cursor:pointer" id="serp-title">DRemind — Never Miss A Payment Again</div>
                    <div style="font-size:.82rem;color:var(--text3);line-height:1.6" id="serp-desc">DRemind intelligently tracks your bills, subscriptions and insurance renewals. Join 50,000+ users saving an average of $480/year.</div>
                </div>

                <div class="section-title" style="margin:18px 0 12px"><i class="ri-smartphone-line"></i> Mobile Preview</div>
                <div style="background:var(--bg2);border-radius:12px;padding:14px 16px;border:1px solid var(--border)">
                    <div style="font-size:.65rem;color:var(--text4);margin-bottom:4px">dremin.co.uk</div>
                    <div style="font-size:.88rem;color:#8ab4f8;font-weight:500;margin-bottom:5px" id="serp-title-m">DRemind — Never Miss A Payment Again</div>
                    <div style="font-size:.75rem;color:var(--text3);line-height:1.5" id="serp-desc-m">DRemind intelligently tracks your bills, subscriptions and insurance renewals...</div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
function switchTab(t) {
    document.querySelectorAll('.cms-tab-content').forEach(function(c){c.classList.remove('active')});
    document.querySelectorAll('.cms-tab-btn').forEach(function(b){b.classList.remove('active')});
    document.getElementById('tab-'+t).classList.add('active');
    document.getElementById('tab-btn-'+t).classList.add('active');
}

function toggleSection(id) {
    var body = document.getElementById(id+'-body');
    var arrow = document.getElementById(id+'-arrow');
    if (!body) return;
    var hidden = body.style.display === 'none';
    body.style.display = hidden ? '' : 'none';
    if (arrow) arrow.style.transform = hidden ? '' : 'rotate(-90deg)';
}

function updateCharCount(inputId, countId, max) {
    var el = document.getElementById(inputId);
    var cnt = document.getElementById(countId);
    if (!el || !cnt) return;
    var len = el.value.length;
    cnt.textContent = len + '/' + max;
    cnt.className = 'char-count' + (len > max ? ' bad' : len > max * .85 ? ' warn' : '');
    // Update SERP preview
    if (inputId === 'meta-title') {
        var t = el.value;
        document.getElementById('serp-title').textContent = t;
        document.getElementById('serp-title-m').textContent = t;
    }
    if (inputId === 'meta-desc') {
        var d = el.value;
        document.getElementById('serp-desc').textContent = d;
        document.getElementById('serp-desc-m').textContent = d.substring(0, 120) + (d.length > 120 ? '...' : '');
    }
}

function addBentoCard() {
    var list = document.getElementById('bento-cards');
    var div = document.createElement('div');
    div.className = 'sortable-item';
    div.innerHTML = '<i class="ri-draggable drag-handle"></i><div style="flex:1;display:grid;grid-template-columns:1fr 2fr;gap:8px"><input class="inp" placeholder="Card title"><input class="inp" placeholder="Card description"></div><button class="btn btn-danger btn-sm" onclick="this.closest(\'.sortable-item\').remove()"><i class="ri-delete-bin-line"></i></button>';
    list.appendChild(div);
}

function saveAll() {
    if (typeof toast === 'function') toast('Home page saved & published!', 'success');
    else alert('Saved!');
}

function updateSchema(v) {}
</script>

@endsection