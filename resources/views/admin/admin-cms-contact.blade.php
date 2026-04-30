{{-- ============================================================
     admin-cms-contact.blade.php
     ============================================================ --}}
@extends('admin.layouts.app')
@section('content')
<style>
.cms-tab-btn{padding:10px 18px;background:transparent;border:none;color:var(--text3);font-size:.8rem;font-weight:600;cursor:pointer;border-bottom:2px solid transparent;transition:all .2s;display:flex;align-items:center;gap:6px}.cms-tab-btn:hover{color:var(--text2)}.cms-tab-btn.active{color:var(--purple);border-bottom-color:var(--purple)}
.cms-tab-content{display:none}.cms-tab-content.active{display:block}
.field-group{margin-bottom:16px}.field-group .label{margin-bottom:6px;display:block;font-size:.75rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em}
.inp-area{width:100%;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:10px 14px;color:var(--text);font-size:.85rem;resize:vertical;font-family:inherit;transition:border-color .2s}.inp-area:focus{outline:none;border-color:var(--purple)}
.section-card{background:var(--card);border:1px solid var(--border);border-radius:var(--radius);padding:20px;margin-bottom:14px}
.char-count{font-size:.68rem;color:var(--text4);text-align:right;margin-top:4px}.char-count.warn{color:var(--amber)}.char-count.bad{color:var(--red)}
.seo-score{display:flex;align-items:center;gap:10px;padding:14px 18px;border-radius:12px;background:rgba(16,185,129,.06);border:1px solid rgba(16,185,129,.15);margin-bottom:16px}
.seo-score-circle{width:52px;height:52px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.8rem;font-weight:800;flex-shrink:0}
.social-row{display:flex;align-items:center;gap:10px;padding:10px 14px;background:var(--bg2);border:1px solid var(--border2);border-radius:var(--radius-sm);margin-bottom:8px}
.hours-row{display:grid;grid-template-columns:140px 1fr 1fr auto;gap:8px;align-items:center;padding:8px 12px;background:var(--bg2);border:1px solid var(--border2);border-radius:var(--radius-xs);margin-bottom:6px}
</style>

<div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px">
    <div><h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800">CMS — Contact Page</h2><p style="font-size:.8rem;color:var(--text3);margin-top:3px">Edit contact details, office info, map and SEO</p></div>
    <div style="display:flex;gap:8px"><a href="contact" target="_blank" class="btn btn-ghost btn-sm"><i class="ri-eye-line"></i> Preview</a><button class="btn btn-primary btn-sm" onclick="saveAll()"><i class="ri-save-line"></i> Save & Publish</button></div>
</div>

<div style="display:flex;gap:8px;margin-bottom:20px;border-bottom:2px solid rgba(255,255,255,.05)">
    <button class="cms-tab-btn active" onclick="switchTab('content')" id="tab-btn-content"><i class="ri-layout-line"></i> Content</button>
    <button class="cms-tab-btn" onclick="switchTab('form')" id="tab-btn-form"><i class="ri-file-list-3-line"></i> Form Fields</button>
    <button class="cms-tab-btn" onclick="switchTab('seo')" id="tab-btn-seo"><i class="ri-search-eye-line"></i> SEO & Meta</button>
</div>

<!-- CONTENT TAB -->
<div class="cms-tab-content active" id="tab-content">

    <!-- Hero -->
    <div class="section-card">
        <div class="section-title" style="margin-bottom:14px"><i class="ri-flag-line"></i> Page Hero</div>
        <div class="g2"><div class="field-group"><label class="label">Badge Label</label><input class="inp" value="Get In Touch"></div><div class="field-group"><label class="label">Headline</label><input class="inp" value="We'd love to hear from you."></div></div>
        <div class="field-group"><label class="label">Subheadline</label><input class="inp" value="Have a question, feedback, or just want to say hi? Our team typically responds within 24 hours."></div>
    </div>

    <!-- Office Info -->
    <div class="section-card">
        <div class="section-title" style="margin-bottom:14px"><i class="ri-building-line"></i> Office Information</div>
        <div class="g2">
            <div class="field-group"><label class="label">Street Address</label><textarea class="inp-area inp" rows="3">Unit 5, Martinbridge Trading Estate,
240–242 Lincoln Road,
Enfield, United Kingdom, EN1 1SP.</textarea></div>
            <div>
                <div class="field-group"><label class="label">Primary Email</label><input class="inp" value="info@winngoodremind.co.uk" type="email"></div>
                <div class="field-group"><label class="label">Primary Email Label</label><input class="inp" value="General enquiries & support"></div>
                <div class="field-group"><label class="label">Support Email</label><input class="inp" value="support@winngoodremind.co.uk" type="email"></div>
                <div class="field-group"><label class="label">Support Email Label</label><input class="inp" value="Technical support"></div>
            </div>
        </div>
        <div class="g2">
            <div class="field-group"><label class="label">Phone Number</label><input class="inp" value="+020 3376 5250"></div>
            <div class="field-group"><label class="label">Phone Hours</label><input class="inp" value="Mon–Fri, 9am–6pm GMT"></div>
        </div>
    </div>

    <!-- Social Links -->
    <div class="section-card">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
            <div class="section-title" style="margin:0"><i class="ri-links-line"></i> Social Links</div>
            <button class="btn btn-ghost btn-sm" onclick="addSocial()"><i class="ri-add-line"></i> Add</button>
        </div>
        <div id="social-links">
            <div class="social-row"><select class="inp" style="width:160px"><option>ri-facebook-fill</option><option>ri-instagram-line</option><option>ri-twitter-x-line</option><option>ri-linkedin-fill</option><option>ri-youtube-line</option></select><input class="inp" value="Facebook" placeholder="Label"><input class="inp" value="#" placeholder="URL"><button class="btn btn-danger btn-sm" onclick="this.closest('.social-row').remove()"><i class="ri-delete-bin-line"></i></button></div>
            <div class="social-row"><select class="inp" style="width:160px"><option>ri-instagram-line</option><option>ri-facebook-fill</option><option>ri-twitter-x-line</option><option>ri-linkedin-fill</option></select><input class="inp" value="Instagram" placeholder="Label"><input class="inp" value="#" placeholder="URL"><button class="btn btn-danger btn-sm" onclick="this.closest('.social-row').remove()"><i class="ri-delete-bin-line"></i></button></div>
            <div class="social-row"><select class="inp" style="width:160px"><option>ri-twitter-x-line</option><option>ri-facebook-fill</option><option>ri-instagram-line</option><option>ri-linkedin-fill</option></select><input class="inp" value="Twitter / X" placeholder="Label"><input class="inp" value="#" placeholder="URL"><button class="btn btn-danger btn-sm" onclick="this.closest('.social-row').remove()"><i class="ri-delete-bin-line"></i></button></div>
            <div class="social-row"><select class="inp" style="width:160px"><option>ri-linkedin-fill</option><option>ri-facebook-fill</option><option>ri-twitter-x-line</option></select><input class="inp" value="LinkedIn" placeholder="Label"><input class="inp" value="#" placeholder="URL"><button class="btn btn-danger btn-sm" onclick="this.closest('.social-row').remove()"><i class="ri-delete-bin-line"></i></button></div>
        </div>
    </div>

    <!-- Map Section -->
    <div class="section-card">
        <div class="section-title" style="margin-bottom:14px"><i class="ri-map-pin-2-line"></i> Map Section</div>
        <div class="g2">
            <div class="field-group"><label class="label">Section Badge</label><input class="inp" value="Find Us"></div>
            <div class="field-group"><label class="label">Section Title</label><input class="inp" value="Visit our office"></div>
        </div>
        <div class="field-group"><label class="label">Description</label><input class="inp" value="We're located in Enfield, North London. Drop by for a coffee or schedule a meeting with our team."></div>
        <div class="field-group"><label class="label">Google Maps Embed URL</label><textarea class="inp-area inp" rows="3">https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2476.8326449567334!2d-0.05669882346679688!3d51.65067900463867!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x48761f5e0f0f0f0f%3A0x0!2s240-242+Lincoln+Rd...</textarea></div>
        <div class="field-group"><label class="label">Get Directions URL (Google Maps link)</label><input class="inp" value="https://maps.google.com/?q=240-242+Lincoln+Road+Enfield+EN1+1SP+UK"></div>
        <div class="section-title" style="margin:14px 0 10px">Office Hours Cards</div>
        <div id="office-hours">
            <div class="hours-row"><input class="inp" value="Office Hours" placeholder="Label"><input class="inp" value="Monday – Friday" placeholder="Line 1"><input class="inp" value="9:00 AM – 6:00 PM GMT" placeholder="Line 2"><button class="btn btn-danger btn-sm" onclick="this.closest('.hours-row').remove()"><i class="ri-delete-bin-line"></i></button></div>
            <div class="hours-row"><input class="inp" value="Parking" placeholder="Label"><input class="inp" value="Free on-site parking" placeholder="Line 1"><input class="inp" value="available for visitors" placeholder="Line 2"><button class="btn btn-danger btn-sm" onclick="this.closest('.hours-row').remove()"><i class="ri-delete-bin-line"></i></button></div>
            <div class="hours-row"><input class="inp" value="Public Transport" placeholder="Label"><input class="inp" value="10 min walk from" placeholder="Line 1"><input class="inp" value="Enfield Town Station" placeholder="Line 2"><button class="btn btn-danger btn-sm" onclick="this.closest('.hours-row').remove()"><i class="ri-delete-bin-line"></i></button></div>
        </div>
        <button class="btn btn-ghost btn-sm" style="margin-top:8px" onclick="addHoursCard()"><i class="ri-add-line"></i> Add Card</button>
    </div>
</div>

<!-- FORM FIELDS TAB -->
<div class="cms-tab-content" id="tab-form">
    <div class="section-card">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
            <div class="section-title" style="margin:0"><i class="ri-draft-line"></i> Contact Form Fields</div>
            <button class="btn btn-ghost btn-sm" onclick="addFormField()"><i class="ri-add-line"></i> Add Field</button>
        </div>
        <div style="background:rgba(255,255,255,.02);border-radius:10px;overflow:hidden;border:1px solid rgba(255,255,255,.06)">
            <table class="data-table">
                <thead><tr><th>Field Label</th><th>Placeholder</th><th>Type</th><th>Required</th><th>Visible</th><th>Order</th></tr></thead>
                <tbody id="form-fields-tbody">
                    <tr><td><input class="inp" value="First Name" style="font-size:.78rem"></td><td><input class="inp" value="Enter Your First Name" style="font-size:.78rem"></td><td><select class="inp" style="font-size:.78rem"><option>text</option><option>email</option><option>tel</option><option>textarea</option><option>select</option></select></td><td><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label></td><td><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label></td><td><input class="inp" type="number" value="1" style="width:60px;font-size:.78rem"></td></tr>
                    <tr><td><input class="inp" value="Last Name" style="font-size:.78rem"></td><td><input class="inp" value="Enter Your Last Name" style="font-size:.78rem"></td><td><select class="inp" style="font-size:.78rem"><option>text</option></select></td><td><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label></td><td><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label></td><td><input class="inp" type="number" value="2" style="width:60px;font-size:.78rem"></td></tr>
                    <tr><td><input class="inp" value="Email Address" style="font-size:.78rem"></td><td><input class="inp" value="Enter Your Email" style="font-size:.78rem"></td><td><select class="inp" style="font-size:.78rem"><option>email</option></select></td><td><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label></td><td><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label></td><td><input class="inp" type="number" value="3" style="width:60px;font-size:.78rem"></td></tr>
                    <tr><td><input class="inp" value="Phone Number" style="font-size:.78rem"></td><td><input class="inp" value="+44 020 0000 0000" style="font-size:.78rem"></td><td><select class="inp" style="font-size:.78rem"><option>tel</option></select></td><td><label class="toggle-switch"><input type="checkbox"><span class="toggle-slider"></span></label></td><td><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label></td><td><input class="inp" type="number" value="4" style="width:60px;font-size:.78rem"></td></tr>
                    <tr><td><input class="inp" value="Subject" style="font-size:.78rem"></td><td><input class="inp" value="Select a topic..." style="font-size:.78rem"></td><td><select class="inp" style="font-size:.78rem"><option>select</option></select></td><td><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label></td><td><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label></td><td><input class="inp" type="number" value="5" style="width:60px;font-size:.78rem"></td></tr>
                    <tr><td><input class="inp" value="Message" style="font-size:.78rem"></td><td><input class="inp" value="Tell us how we can help..." style="font-size:.78rem"></td><td><select class="inp" style="font-size:.78rem"><option>textarea</option></select></td><td><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label></td><td><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label></td><td><input class="inp" type="number" value="6" style="width:60px;font-size:.78rem"></td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="section-card">
        <div class="section-title" style="margin-bottom:14px"><i class="ri-settings-3-line"></i> Subject Dropdown Options</div>
        <div id="subject-options">
            <div class="g2" style="margin-bottom:6px"><input class="inp" value="General Enquiry"><button class="btn btn-danger btn-sm" onclick="this.closest('.g2').remove()"><i class="ri-delete-bin-line"></i></button></div>
            <div class="g2" style="margin-bottom:6px"><input class="inp" value="Technical Support"><button class="btn btn-danger btn-sm" onclick="this.closest('.g2').remove()"><i class="ri-delete-bin-line"></i></button></div>
            <div class="g2" style="margin-bottom:6px"><input class="inp" value="Billing & Plans"><button class="btn btn-danger btn-sm" onclick="this.closest('.g2').remove()"><i class="ri-delete-bin-line"></i></button></div>
            <div class="g2" style="margin-bottom:6px"><input class="inp" value="Feature Request"><button class="btn btn-danger btn-sm" onclick="this.closest('.g2').remove()"><i class="ri-delete-bin-line"></i></button></div>
            <div class="g2" style="margin-bottom:6px"><input class="inp" value="Partnership Opportunity"><button class="btn btn-danger btn-sm" onclick="this.closest('.g2').remove()"><i class="ri-delete-bin-line"></i></button></div>
            <div class="g2" style="margin-bottom:6px"><input class="inp" value="Press & Media"><button class="btn btn-danger btn-sm" onclick="this.closest('.g2').remove()"><i class="ri-delete-bin-line"></i></button></div>
        </div>
        <button class="btn btn-ghost btn-sm" style="margin-top:8px" onclick="addSubject()"><i class="ri-add-line"></i> Add Option</button>
    </div>

    <div class="section-card">
        <div class="section-title" style="margin-bottom:14px"><i class="ri-mail-settings-line"></i> Form Settings</div>
        <div class="g2">
            <div class="field-group"><label class="label">Send Submissions To</label><input class="inp" value="info@winngoodremind.co.uk" type="email"></div>
            <div class="field-group"><label class="label">CC Email (optional)</label><input class="inp" placeholder="another@email.com" type="email"></div>
        </div>
        <div class="g2">
            <div class="field-group"><label class="label">Success Message</label><input class="inp" value="Message sent successfully!"></div>
            <div class="field-group"><label class="label">Success Subtext</label><input class="inp" value="We'll get back to you within 24 hours."></div>
        </div>
        <div class="g2">
            <div class="field-group"><label class="label">Submit Button Label</label><input class="inp" value="Send Message"></div>
            <div class="field-group"><label class="label">Privacy Checkbox Text</label><input class="inp" value="I agree to the Privacy Policy and consent to being contacted."></div>
        </div>
    </div>
</div>

<!-- SEO TAB -->
<div class="cms-tab-content" id="tab-seo">
    <div class="g2" style="align-items:start">
        <div style="flex:2">
            <div class="section-card">
                <div class="section-title" style="margin-bottom:14px"><i class="ri-file-text-line"></i> Page Meta</div>
                <div class="field-group"><label class="label">Meta Title</label><input class="inp" id="meta-title" value="Contact DRemind — Get In Touch" oninput="cc('meta-title','tc-title',60)"><div class="char-count" id="tc-title">31/60</div></div>
                <div class="field-group"><label class="label">Meta Description</label><textarea class="inp-area inp" id="meta-desc" rows="3" oninput="cc('meta-desc','tc-desc',160)">Contact DRemind's support team. We respond within 24 hours. Office at Enfield, London. Email info@winngoodremind.co.uk or call +020 3376 5250.</textarea><div class="char-count" id="tc-desc">143/160</div></div>
                <div class="field-group"><label class="label">Keywords</label><input class="inp" value="contact DRemind, support, help, DRemind office London"></div>
                <div class="field-group"><label class="label">Canonical URL</label><input class="inp" value="https://dremin.co.uk/contact"></div>
                <div class="g2"><div class="field-group"><label class="label">Robots</label><select class="inp"><option>index, follow</option></select></div><div class="field-group"><label class="label">Priority</label><select class="inp"><option>0.5 — Normal</option></select></div></div>
            </div>
            <div class="section-card">
                <div class="section-title" style="margin-bottom:14px"><i class="ri-code-line"></i> Schema — ContactPage</div>
                <div class="field-group"><label class="label">Schema Type</label><select class="inp"><option>ContactPage</option><option>WebPage</option><option>Custom JSON-LD</option></select></div>
                <div class="field-group">
                    @verbatim    
                    <textarea class="inp-area inp" rows="6" style="font-family:monospace;font-size:.78rem">{
                        "@context": "https://schema.org",
                        "@type": "ContactPage",
                        "name": "Contact DRemind",
                        "url": "https://dremin.co.uk/contact",
                        "contactPoint": {
                            "@type": "ContactPoint",
                            "telephone": "+02033765250",
                            "contactType": "customer service",
                            "availableLanguage": "English"
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
                <div style="background:var(--bg2);border-radius:12px;padding:14px;border:1px solid var(--border)">
                    <div style="font-size:.65rem;color:var(--text4);margin-bottom:4px">dremin.co.uk › contact</div>
                    <div style="font-size:.95rem;color:#8ab4f8;font-weight:500;margin-bottom:5px">Contact DRemind — Get In Touch</div>
                    <div style="font-size:.8rem;color:var(--text3);line-height:1.6">Contact DRemind's support team. We respond within 24 hours. Office at Enfield, London...</div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
function switchTab(t){document.querySelectorAll('.cms-tab-content').forEach(c=>c.classList.remove('active'));document.querySelectorAll('.cms-tab-btn').forEach(b=>b.classList.remove('active'));document.getElementById('tab-'+t).classList.add('active');document.getElementById('tab-btn-'+t).classList.add('active')}
function cc(i,c,m){var el=document.getElementById(i),cnt=document.getElementById(c);if(!el||!cnt)return;var l=el.value.length;cnt.textContent=l+'/'+m;cnt.className='char-count'+(l>m?' bad':l>m*.85?' warn':'')}
function addSocial(){var d=document.createElement('div');d.className='social-row';d.innerHTML='<select class="inp" style="width:160px"><option>ri-facebook-fill</option><option>ri-instagram-line</option><option>ri-twitter-x-line</option><option>ri-linkedin-fill</option><option>ri-youtube-line</option><option>ri-tiktok-line</option></select><input class="inp" placeholder="Label"><input class="inp" placeholder="URL"><button class="btn btn-danger btn-sm" onclick="this.closest(\'.social-row\').remove()"><i class="ri-delete-bin-line"></i></button>';document.getElementById('social-links').appendChild(d)}
function addHoursCard(){var d=document.createElement('div');d.className='hours-row';d.innerHTML='<input class="inp" placeholder="Label"><input class="inp" placeholder="Line 1"><input class="inp" placeholder="Line 2"><button class="btn btn-danger btn-sm" onclick="this.closest(\'.hours-row\').remove()"><i class="ri-delete-bin-line"></i></button>';document.getElementById('office-hours').appendChild(d)}
function addFormField(){var tb=document.getElementById('form-fields-tbody');var tr=document.createElement('tr');tr.innerHTML='<td><input class="inp" placeholder="Field Label" style="font-size:.78rem"></td><td><input class="inp" placeholder="Placeholder" style="font-size:.78rem"></td><td><select class="inp" style="font-size:.78rem"><option>text</option><option>email</option><option>tel</option><option>textarea</option><option>select</option></select></td><td><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label></td><td><label class="toggle-switch"><input type="checkbox" checked><span class="toggle-slider"></span></label></td><td><input class="inp" type="number" value="0" style="width:60px;font-size:.78rem"></td>';tb.appendChild(tr)}
function addSubject(){var d=document.createElement('div');d.className='g2';d.style.marginBottom='6px';d.innerHTML='<input class="inp" placeholder="Option text"><button class="btn btn-danger btn-sm" onclick="this.closest(\'.g2\').remove()"><i class="ri-delete-bin-line"></i></button>';document.getElementById('subject-options').appendChild(d)}
function saveAll(){if(typeof toast==='function')toast('Contact page saved!','success')}
</script>
@endsection