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
.section-card-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;cursor:pointer}
.section-card-header h4{font-size:.9rem;font-weight:700;color:var(--text);display:flex;align-items:center;gap:8px}
.toggle-switch{position:relative;width:40px;height:22px;flex-shrink:0}
.toggle-switch input{opacity:0;width:0;height:0}
.toggle-slider{position:absolute;inset:0;background:var(--ctrl-bg);border-radius:22px;cursor:pointer;transition:.3s}
.toggle-slider::before{content:'';position:absolute;width:16px;height:16px;left:3px;top:3px;background:var(--text);border-radius:50%;transition:.3s}
.toggle-switch input:checked+.toggle-slider{background:var(--purple)}
.toggle-switch input:checked+.toggle-slider::before{transform:translateX(18px)}
.sortable-item{display:flex;align-items:center;gap:10px;padding:10px 14px;background:var(--row-bg);border:1px solid var(--border);border-radius:var(--radius-sm);cursor:grab;margin-bottom:8px}
.stat-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:10px}
.stat-mini{background:var(--row-bg);border:1px solid var(--border);border-radius:12px;padding:14px;text-align:center}
.seo-score{display:flex;align-items:center;gap:10px;padding:14px 18px;border-radius:12px;background:rgba(16,185,129,.06);border:1px solid rgba(16,185,129,.15);margin-bottom:16px}
.seo-score-circle{width:52px;height:52px;border-radius:50%;background:conic-gradient(var(--green) 0% 82%,var(--border) 82%);display:flex;align-items:center;justify-content:center;font-size:.8rem;font-weight:800;color:var(--green);flex-shrink:0}
.char-count{font-size:.68rem;color:var(--text4);text-align:right;margin-top:4px}
.char-count.warn{color:var(--amber)}.char-count.bad{color:var(--red)}
.team-card{background:var(--row-bg);border:1px solid var(--border);border-radius:12px;padding:16px;display:flex;gap:12px;align-items:flex-start;margin-bottom:10px}
.team-avatar{width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,var(--purple),#6d28d9);display:flex;align-items:center;justify-content:center;font-weight:800;color:#fff;font-size:.85rem;flex-shrink:0}
</style>

<div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px">
    <div>
        <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800">CMS — About Page</h2>
        <p style="font-size:.8rem;color:var(--text3);margin-top:3px">Edit all about page content and SEO settings</p>
    </div>
    <div style="display:flex;gap:8px">
        <a href="about" target="_blank" class="btn btn-ghost btn-sm"><i class="ri-eye-line"></i> Preview</a>
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

    <!-- Hero -->
    <div class="section-card">
        <div class="section-card-header">
            <h4><i class="ri-flag-line" style="color:var(--purple)"></i> Page Hero</h4>
            <i class="ri-arrow-down-s-line" style="color:var(--text3)"></i>
        </div>
        <div class="g2">
            <div class="field-group"><label class="label">Badge Label</label><input class="inp" value="Our Story"></div>
            <div class="field-group"><label class="label">Headline (before gradient)</label><input class="inp" value="Built to help you keep"></div>
        </div>
        <div class="field-group"><label class="label">Headline Gradient Text</label><input class="inp" value="more of your money."></div>
        <div class="field-group"><label class="label">Subheadline</label><textarea class="inp-area inp" rows="2">DRemind was born from a simple frustration — too many people lose thousands every year to forgotten renewals and loyalty tax. We decided to fix that.</textarea></div>
    </div>

    <!-- Mission -->
    <div class="section-card">
        <div class="section-card-header">
            <h4><i class="ri-bullseye-line" style="color:var(--cyan,#06b6d4)"></i> Mission Section</h4>
            <div style="display:flex;align-items:center;gap:10px">
                <label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label>
                <i class="ri-arrow-down-s-line" style="color:var(--text3)"></i>
            </div>
        </div>
        <div class="g2">
            <div class="field-group"><label class="label">Section Badge</label><input class="inp" value="Our Mission"></div>
            <div class="field-group"><label class="label">Heading (before gradient)</label><input class="inp" value="Empowering people to be"></div>
        </div>
        <div class="g2">
            <div class="field-group"><label class="label">Heading Gradient Text</label><input class="inp" value="financially savvy"></div>
            <div class="field-group"><label class="label">Founded Year</label><input class="inp" value="2022" type="number"></div>
        </div>
        <div class="field-group"><label class="label">Paragraph 1</label><textarea class="inp-area inp" rows="2">We believe every household deserves to know when their insurance, energy contracts, and subscriptions are up for renewal — and to have enough time to switch to a better deal.</textarea></div>
        <div class="field-group"><label class="label">Paragraph 2</label><textarea class="inp-area inp" rows="2">DRemind is the intelligent reminder platform that works silently in the background, so you never pay the loyalty tax again.</textarea></div>

        <div class="section-title" style="margin:14px 0 10px">Stats Badges (right card)</div>
        <div class="stat-grid">
            <div class="stat-mini">
                <div class="label" style="display:block">Active Users</div>
                <input class="inp" value="50000+" style="text-align:center">
            </div>
            <div class="stat-mini">
                <div class="label" style="display:block">Countries</div>
                <input class="inp" value="8" style="text-align:center">
            </div>
            <div class="stat-mini">
                <div class="label" style="display:block">Reminders Sent</div>
                <input class="inp" value="2M+" style="text-align:center">
            </div>
            <div class="stat-mini">
                <div class="label" style="display:block">App Rating</div>
                <input class="inp" value="4.9★" style="text-align:center">
            </div>
        </div>

        <div class="section-title" style="margin:16px 0 10px">Feature Points (3)</div>
        <div id="mission-points">
            <div class="sortable-item">
                <i class="ri-draggable" style="color:var(--text4)"></i>
                <input class="inp" value="ri-bullseye-line" style="width:160px" placeholder="Icon class">
                <input class="inp" value="Purpose-driven" placeholder="Title">
                <input class="inp" value="Every feature we build is aimed at putting money back in your pocket." placeholder="Description">
                <input type="color" value="#7c3aed" style="width:32px;height:32px;border:none;border-radius:8px;background:none;cursor:pointer">
            </div>
            <div class="sortable-item">
                <i class="ri-draggable" style="color:var(--text4)"></i>
                <input class="inp" value="ri-shield-check-line" style="width:160px" placeholder="Icon class">
                <input class="inp" value="Privacy first" placeholder="Title">
                <input class="inp" value="Your data is encrypted, never sold, fully GDPR & APPs compliant." placeholder="Description">
                <input type="color" value="#10b981" style="width:32px;height:32px;border:none;border-radius:8px;background:none;cursor:pointer">
            </div>
            <div class="sortable-item">
                <i class="ri-draggable" style="color:var(--text4)"></i>
                <input class="inp" value="ri-global-line" style="width:160px" placeholder="Icon class">
                <input class="inp" value="Global reach" placeholder="Title">
                <input class="inp" value="Available in 8 countries with full local privacy compliance." placeholder="Description">
                <input type="color" value="#06b6d4" style="width:32px;height:32px;border:none;border-radius:8px;background:none;cursor:pointer">
            </div>
        </div>
        <button class="btn btn-ghost btn-sm" style="margin-top:6px" onclick="addMissionPoint()"><i class="ri-add-line"></i> Add Point</button>
    </div>

    <!-- Values -->
    <div class="section-card">
        <div class="section-card-header">
            <h4><i class="ri-heart-line" style="color:var(--red,#ef4444)"></i> Values Section</h4>
            <div style="display:flex;align-items:center;gap:10px">
                <label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label>
                <i class="ri-arrow-down-s-line" style="color:var(--text3)"></i>
            </div>
        </div>
        <div class="g2" style="margin-bottom:12px">
            <div class="field-group"><label class="label">Section Badge</label><input class="inp" value="Our Values"></div>
            <div class="field-group"><label class="label">Section Title</label><input class="inp" value="What we stand for"></div>
        </div>
        <div class="section-title" style="margin-bottom:10px">Value Cards (4)</div>
        <div id="value-cards">
            <div class="sortable-item"><i class="ri-draggable" style="color:var(--text4)"></i><input class="inp" value="💡" style="width:60px;text-align:center"><input class="inp" value="Transparency" placeholder="Title"><input class="inp" value="No hidden fees, no data selling. What you see is what you get." placeholder="Description"><button class="btn btn-danger btn-sm"><i class="ri-delete-bin-line"></i></button></div>
            <div class="sortable-item"><i class="ri-draggable" style="color:var(--text4)"></i><input class="inp" value="🚀" style="width:60px;text-align:center"><input class="inp" value="Simplicity" placeholder="Title"><input class="inp" value="Set up in under 2 minutes. No complicated settings." placeholder="Description"><button class="btn btn-danger btn-sm"><i class="ri-delete-bin-line"></i></button></div>
            <div class="sortable-item"><i class="ri-draggable" style="color:var(--text4)"></i><input class="inp" value="🔒" style="width:60px;text-align:center"><input class="inp" value="Security" placeholder="Title"><input class="inp" value="Bank-level encryption on all your data, always." placeholder="Description"><button class="btn btn-danger btn-sm"><i class="ri-delete-bin-line"></i></button></div>
            <div class="sortable-item"><i class="ri-draggable" style="color:var(--text4)"></i><input class="inp" value="🌍" style="width:60px;text-align:center"><input class="inp" value="Accessibility" placeholder="Title"><input class="inp" value="Free forever plan so everyone can benefit." placeholder="Description"><button class="btn btn-danger btn-sm"><i class="ri-delete-bin-line"></i></button></div>
        </div>
        <button class="btn btn-ghost btn-sm" style="margin-top:6px" onclick="addValueCard()"><i class="ri-add-line"></i> Add Value</button>
    </div>

    <!-- Team Section -->
    <div class="section-card">
        <div class="section-card-header">
            <h4><i class="ri-team-line" style="color:var(--amber,#f59e0b)"></i> Team Section</h4>
            <div style="display:flex;align-items:center;gap:10px">
                <label class="toggle-switch"><input type="checkbox" id="team-visible"><span class="toggle-slider"></span></label>
                <span style="font-size:.72rem;color:var(--text4)">Hidden on frontend</span>
                <i class="ri-arrow-down-s-line" style="color:var(--text3)"></i>
            </div>
        </div>
        <div class="g2" style="margin-bottom:12px">
            <div class="field-group"><label class="label">Section Title</label><input class="inp" value="The people behind DRemind"></div>
        </div>
        <div id="team-members">
            <div class="team-card">
                <div class="team-avatar">JT</div>
                <div style="flex:1;display:grid;grid-template-columns:1fr 1fr;gap:8px">
                    <input class="inp" value="Kishore Thompson" placeholder="Name">
                    <input class="inp" value="CEO & Co-founder" placeholder="Role">
                    <input class="inp" value="JT" placeholder="Initials" style="width:80px">
                    <input class="inp" value="10+ years in fintech. Previously at Monzo and TransferWise." placeholder="Bio">
                </div>
                <div style="display:flex;flex-direction:column;gap:6px">
                    <select class="inp" style="font-size:.72rem"><option>Purple</option><option>Cyan</option><option>Green</option></select>
                    <button class="btn btn-danger btn-sm"><i class="ri-delete-bin-line"></i></button>
                </div>
            </div>
            <div class="team-card">
                <div class="team-avatar" style="background:linear-gradient(135deg,#06b6d4,#0891b2)">SR</div>
                <div style="flex:1;display:grid;grid-template-columns:1fr 1fr;gap:8px">
                    <input class="inp" value="Sophie Reynolds" placeholder="Name">
                    <input class="inp" value="CTO & Co-founder" placeholder="Role">
                    <input class="inp" value="SR" placeholder="Initials" style="width:80px">
                    <input class="inp" value="Full-stack engineer with a passion for clean, fast interfaces." placeholder="Bio">
                </div>
                <div style="display:flex;flex-direction:column;gap:6px">
                    <select class="inp" style="font-size:.72rem"><option>Cyan</option><option>Purple</option><option>Green</option></select>
                    <button class="btn btn-danger btn-sm"><i class="ri-delete-bin-line"></i></button>
                </div>
            </div>
        </div>
        <button class="btn btn-ghost btn-sm" style="margin-top:8px" onclick="addTeamMember()"><i class="ri-user-add-line"></i> Add Member</button>
    </div>

    <!-- Global Section -->
    <div class="section-card">
        <div class="section-card-header">
            <h4><i class="ri-global-line" style="color:var(--green,#10b981)"></i> Global Availability Section</h4>
            <div style="display:flex;align-items:center;gap:10px">
                <label class="toggle-switch"><input type="checkbox" id="global-visible"><span class="toggle-slider"></span></label>
                <span style="font-size:.72rem;color:var(--text4)">Hidden on frontend</span>
                <i class="ri-arrow-down-s-line" style="color:var(--text3)"></i>
            </div>
        </div>
        <div class="g2" style="margin-bottom:12px">
            <div class="field-group"><label class="label">Section Title</label><input class="inp" value="Helping savers worldwide"></div>
        </div>
        <div class="section-title" style="margin-bottom:10px">Countries</div>
        <div id="countries-list" style="display:grid;grid-template-columns:repeat(4,1fr);gap:8px">
            <div style="background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.07);border-radius:10px;padding:10px;display:flex;align-items:center;gap:8px">
                <input class="inp" value="AU" style="width:50px;text-align:center;font-weight:700">
                <input class="inp" value="Australia">
                <input class="inp" value="ACCC Compliant" style="font-size:.72rem">
            </div>
            <div style="background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.07);border-radius:10px;padding:10px;display:flex;align-items:center;gap:8px">
                <input class="inp" value="UK" style="width:50px;text-align:center;font-weight:700">
                <input class="inp" value="United Kingdom">
                <input class="inp" value="GDPR Compliant" style="font-size:.72rem">
            </div>
            <div style="background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.07);border-radius:10px;padding:10px;display:flex;align-items:center;gap:8px">
                <input class="inp" value="US" style="width:50px;text-align:center;font-weight:700">
                <input class="inp" value="United States">
                <input class="inp" value="CCPA Compliant" style="font-size:.72rem">
            </div>
            <div style="background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.07);border-radius:10px;padding:10px;display:flex;align-items:center;gap:8px">
                <input class="inp" value="IN" style="width:50px;text-align:center;font-weight:700">
                <input class="inp" value="India">
                <input class="inp" value="PDPB" style="font-size:.72rem">
            </div>
        </div>
        <button class="btn btn-ghost btn-sm" style="margin-top:10px"><i class="ri-add-line"></i> Add Country</button>
    </div>

</div>

<!-- SEO TAB -->
<div class="cms-tab-content" id="tab-seo">
    <div class="g2" style="align-items:start">
        <div style="flex:2">
            <div class="section-card">
                <div class="section-title" style="margin-bottom:14px"><i class="ri-file-text-line"></i> Page Meta</div>
                <div class="field-group">
                    <label class="label">Meta Title</label>
                    <input class="inp" id="meta-title" value="About DRemind — Our Story & Mission" oninput="updateCharCount('meta-title','tc-title',60)">
                    <div class="char-count" id="tc-title">37/60</div>
                </div>
                <div class="field-group">
                    <label class="label">Meta Description</label>
                    <textarea class="inp-area inp" id="meta-desc" rows="3" oninput="updateCharCount('meta-desc','tc-desc',160)">Learn about DRemind's mission to help households save money on insurance, subscriptions and renewals. Founded 2022, serving 8 countries.</textarea>
                    <div class="char-count" id="tc-desc">141/160</div>
                </div>
                <div class="field-group"><label class="label">Meta Keywords</label><input class="inp" value="about DRemind, our mission, subscription tracker, payment reminder app"></div>
                <div class="field-group"><label class="label">Canonical URL</label><input class="inp" value="https://dremin.co.uk/about"></div>
                <div class="g2">
                    <div class="field-group"><label class="label">Robots</label><select class="inp"><option>index, follow</option><option>noindex, follow</option></select></div>
                    <div class="field-group"><label class="label">Sitemap Priority</label><select class="inp"><option>0.8 — High</option><option>1.0 — Homepage</option><option>0.5 — Normal</option></select></div>
                </div>
            </div>
            <div class="section-card">
                <div class="section-title" style="margin-bottom:14px"><i class="ri-code-line"></i> Schema Markup</div>
                <div class="field-group"><label class="label">Schema Type</label><select class="inp"><option>Organization</option><option>WebPage</option><option>AboutPage</option><option>Custom JSON-LD</option></select></div>
                <div class="field-group"><label class="label">Custom JSON-LD</label>
                    @verbatim
                    <textarea class="inp-area inp" rows="6" style="font-family:monospace;font-size:.8rem">{
                        "@context": "https://schema.org",
                        "@type": "Organization",
                        "name": "DRemind",
                        "url": "https://dremin.co.uk",
                        "foundingDate": "2022",
                        "address": {
                            "@type": "PostalAddress",
                            "addressCountry": "GB"
                        }
                        }
                    </textarea>
                    @endverbatim
                </div>
            </div>
        </div>
        <div>
            <div class="card" style="padding:18px;position:sticky;top:90px">
                <div class="section-title" style="margin-bottom:14px"><i class="ri-google-line"></i> SERP Preview</div>
                <div style="background:var(--bg2);border-radius:12px;padding:16px 18px;border:1px solid var(--border)">
                    <div style="font-size:.68rem;color:var(--text4);margin-bottom:5px">https://dremin.co.uk › about</div>
                    <div style="font-size:1rem;color:#8ab4f8;font-weight:500;margin-bottom:6px">About DRemind — Our Story & Mission</div>
                    <div style="font-size:.82rem;color:var(--text3);line-height:1.6">Learn about DRemind's mission to help households save money on insurance, subscriptions and renewals...</div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
function switchTab(t){document.querySelectorAll('.cms-tab-content').forEach(c=>c.classList.remove('active'));document.querySelectorAll('.cms-tab-btn').forEach(b=>b.classList.remove('active'));document.getElementById('tab-'+t).classList.add('active');document.getElementById('tab-btn-'+t).classList.add('active')}
function updateCharCount(i,c,m){var el=document.getElementById(i),cnt=document.getElementById(c);if(!el||!cnt)return;var l=el.value.length;cnt.textContent=l+'/'+m;cnt.className='char-count'+(l>m?' bad':l>m*.85?' warn':'')}
function addMissionPoint(){var l=document.getElementById('mission-points');var d=document.createElement('div');d.className='sortable-item';d.innerHTML='<i class="ri-draggable" style="color:var(--text4)"></i><input class="inp" placeholder="ri-icon-name" style="width:160px"><input class="inp" placeholder="Title"><input class="inp" placeholder="Description"><input type="color" value="#7c3aed" style="width:32px;height:32px;border:none;border-radius:8px;cursor:pointer"><button class="btn btn-danger btn-sm" onclick="this.closest(\'.sortable-item\').remove()"><i class="ri-delete-bin-line"></i></button>';l.appendChild(d)}
function addValueCard(){var l=document.getElementById('value-cards');var d=document.createElement('div');d.className='sortable-item';d.innerHTML='<i class="ri-draggable" style="color:var(--text4)"></i><input class="inp" placeholder="Emoji" style="width:60px;text-align:center"><input class="inp" placeholder="Title"><input class="inp" placeholder="Description"><button class="btn btn-danger btn-sm" onclick="this.closest(\'.sortable-item\').remove()"><i class="ri-delete-bin-line"></i></button>';l.appendChild(d)}
function addTeamMember(){var l=document.getElementById('team-members');var d=document.createElement('div');d.className='team-card';d.innerHTML='<div class="team-avatar" style="background:linear-gradient(135deg,#7c3aed,#06b6d4)">?</div><div style="flex:1;display:grid;grid-template-columns:1fr 1fr;gap:8px"><input class="inp" placeholder="Name" oninput="this.closest(\'.team-card\').querySelector(\'.team-avatar\').textContent=this.value.split(\' \').map(n=>n[0]).join(\'\').substring(0,2).toUpperCase()"><input class="inp" placeholder="Role"><input class="inp" placeholder="Initials" style="width:80px"><input class="inp" placeholder="Bio"></div><button class="btn btn-danger btn-sm" onclick="this.closest(\'.team-card\').remove()"><i class="ri-delete-bin-line"></i></button>';l.appendChild(d)}
function saveAll(){if(typeof toast==='function')toast('About page saved!','success');else alert('Saved!')}
</script>

@endsection