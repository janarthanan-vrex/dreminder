@extends('user.layouts.app')
@section('content')

<section id="page-feedback" class="">
    <div style="margin-bottom:16px">
        <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800;color:#f1f5f9">We Value Your Feedback</h2>
        <p style="font-size:.82rem;color:#64748b;margin-top:3px">Help us improve D-Remind by sharing your thoughts</p>
    </div>
    <div class="g2">
        <div class="card" style="padding:22px">
            <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:14px">Share Your Thoughts</h3>
            <form onsubmit="submitFeedback(event)">
                <div style="margin-bottom:14px"><label style="display:block;font-size:.67rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:6px">Type <span style="color:#f43f5e">*</span></label><select class="inp" id="fb-type" required>
                        <option value="">Select type…</option>
                        <option>General Suggestion</option>
                        <option>Bug Report</option>
                        <option>Feature Request</option>
                        <option>Compliment</option>
                        <option>Complaint</option>
                    </select></div>
                <div style="margin-bottom:14px"><label style="display:block;font-size:.67rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:6px">Subject <span style="color:#f43f5e">*</span></label><input class="inp" id="fb-subject" placeholder="Brief title (5–100 chars)" minlength="5" maxlength="100" required></div>
                <div style="margin-bottom:14px"><label style="display:block;font-size:.67rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:6px">Category</label><select class="inp">
                        <option value="">Related to…</option>
                        <option>Reminders</option>
                        <option>Notifications</option>
                        <option>Calendar</option>
                        <option>Analytics</option>
                        <option>Mobile</option>
                        <option>Billing</option>
                        <option>Other</option>
                    </select></div>
                <div style="margin-bottom:14px"><label style="display:block;font-size:.67rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:6px">Message <span style="color:#f43f5e">*</span></label><textarea class="inp" id="fb-msg" rows="5" placeholder="Describe your feedback in detail… (min 10 chars)" minlength="10" required oninput="document.getElementById('fb-len').textContent=this.value.length" style="resize:vertical"></textarea>
                    <div style="font-size:.72rem;color:#475569;margin-top:4px;text-align:right"><span id="fb-len">0</span> characters</div>
                </div>
                <div style="margin-bottom:14px"><label style="display:block;font-size:.67rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:8px">Priority</label>
                    <div style="display:flex;gap:8px;flex-wrap:wrap"><button type="button" class="pri-btn sel" onclick="selPri(this)">Low</button><button type="button" class="pri-btn" onclick="selPri(this)">Medium</button><button type="button" class="pri-btn" onclick="selPri(this)">High</button><button type="button" class="pri-btn" onclick="selPri(this)">Critical</button></div>
                </div>
                <div style="margin-bottom:18px"><label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:.84rem;color:#64748b"><input type="checkbox" style="accent-color:#7c3aed;width:14px;height:14px"> Allow team to contact me about this feedback</label></div>
                <div style="display:flex;gap:10px;justify-content:flex-end"><button type="reset" class="btn btn-ghost" onclick="document.getElementById('fb-len').textContent='0'"><i class="ri-refresh-line"></i> Clear</button><button type="submit" class="btn btn-primary"><i class="ri-send-plane-line"></i> Submit Feedback</button></div>
            </form>
        </div>
        <div style="display:flex;flex-direction:column;gap:14px">
            <div class="card" style="padding:18px">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px">
                    <div style="width:42px;height:42px;border-radius:12px;background:rgba(16,185,129,.12);display:flex;align-items:center;justify-content:center"><i class="ri-thumb-up-line" style="color:#10b981;font-size:1.1rem"></i></div>
                    <div>
                        <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9">Your Past Feedback</h3>
                        <div style="font-size:.75rem;color:#64748b">3 submissions</div>
                    </div>
                </div>
                <div style="display:flex;flex-direction:column;gap:8px">
                    <div style="padding:12px;border-radius:10px;border:1px solid rgba(16,185,129,.25);background:rgba(16,185,129,.04)">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:4px"><span style="font-size:.85rem;font-weight:600;color:#94a3b8">Add recurring reminders</span><span class="badge badge-green"><i class="ri-check-line"></i> Resolved</span></div>
                        <div style="font-size:.75rem;color:#64748b">Feature Request · Apr 10</div>
                    </div>
                    <div style="padding:12px;border-radius:10px;border:1px solid rgba(245,158,11,.2);background:rgba(245,158,11,.04)">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:4px"><span style="font-size:.85rem;font-weight:600;color:#94a3b8">Calendar export feature</span><span class="badge badge-amber"><i class="ri-time-line"></i> Pending</span></div>
                        <div style="font-size:.75rem;color:#64748b">Feature Request · Apr 14</div>
                    </div>
                    <div style="padding:12px;border-radius:10px;border:1px solid rgba(20,184,166,.2);background:rgba(20,184,166,.04)">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:4px"><span style="font-size:.85rem;font-weight:600;color:#94a3b8">Great app, loving it!</span><span class="badge badge-teal"><i class="ri-eye-line"></i> Reviewed</span></div>
                        <div style="font-size:.75rem;color:#64748b">Compliment · Mar 28</div>
                    </div>
                </div>
            </div>
            <div class="card" style="padding:16px;text-align:center"><a href="mailto:support@winngoodremind.co.uk" style="font-size:.84rem;color:#a78bfa;font-weight:600;text-decoration:none"><i class="ri-mail-line" style="margin-right:4px"></i>support@winngoodremind.co.uk</a></div>
        </div>
    </div>
</section>

@endsection
