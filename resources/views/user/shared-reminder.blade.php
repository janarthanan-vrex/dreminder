@extends('user.layouts.app')
@section('content')

<section id="page-shared" class="">
    <div style="margin-bottom:16px">
        <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800;color:#f1f5f9">Shared Reminders</h2>
        <p style="font-size:.82rem;color:#64748b;margin-top:3px">Manage reminders you've shared and received</p>
    </div>
    <div class="g4" style="margin-bottom:20px">
        <div class="stat-card">
            <div style="width:40px;height:40px;border-radius:11px;background:rgba(20,184,166,.12);display:flex;align-items:center;justify-content:center;margin-bottom:10px"><i class="ri-share-forward-line" style="color:#2dd4bf;font-size:1.1rem"></i></div>
            <div class="font-jakarta" style="font-size:1.5rem;font-weight:800;color:#f1f5f9" id="shared-by-me-cnt">0</div>
            <div style="font-size:.72rem;color:#64748b;margin-top:3px;font-weight:600">Shared by Me</div>
        </div>
        <div class="stat-card">
            <div style="width:40px;height:40px;border-radius:11px;background:rgba(16,185,129,.12);display:flex;align-items:center;justify-content:center;margin-bottom:10px"><i class="ri-inbox-line" style="color:#10b981;font-size:1.1rem"></i></div>
            <div class="font-jakarta" style="font-size:1.5rem;font-weight:800;color:#f1f5f9">5</div>
            <div style="font-size:.72rem;color:#64748b;margin-top:3px;font-weight:600">Shared with Me</div>
        </div>
        <div class="stat-card">
            <div style="width:40px;height:40px;border-radius:11px;background:rgba(124,58,237,.15);display:flex;align-items:center;justify-content:center;margin-bottom:10px"><i class="ri-team-line" style="color:#a78bfa;font-size:1.1rem"></i></div>
            <div class="font-jakarta" style="font-size:1.5rem;font-weight:800;color:#f1f5f9">18</div>
            <div style="font-size:.72rem;color:#64748b;margin-top:3px;font-weight:600">Total Recipients</div>
        </div>
        <div class="stat-card">
            <div style="width:40px;height:40px;border-radius:11px;background:rgba(245,158,11,.12);display:flex;align-items:center;justify-content:center;margin-bottom:10px"><i class="ri-calendar-check-line" style="color:#f59e0b;font-size:1.1rem"></i></div>
            <div class="font-jakarta" style="font-size:1.5rem;font-weight:800;color:#f1f5f9">8</div>
            <div style="font-size:.72rem;color:#64748b;margin-top:3px;font-weight:600">This Month</div>
        </div>
    </div>
    <div style="display:flex;border-bottom:1px solid rgba(255,255,255,.06);margin-bottom:16px;overflow-x:auto">
        <button class="tab-btn active" onclick="swTab('shared','by-me',this)"><i class="ri-share-forward-line"></i> By Me</button>
        <button class="tab-btn" onclick="swTab('shared','with-me',this)"><i class="ri-inbox-line"></i> With Me</button>
        <button class="tab-btn" onclick="swTab('shared','history',this)"><i class="ri-history-line"></i> History</button>
    </div>
    <div id="shared-tab-by-me" class="tab-pane active" data-group="shared">
        <div id="shared-by-me-list" style="display:flex;flex-direction:column;gap:10px"></div>
    </div>
    <div id="shared-tab-with-me" class="tab-pane" data-group="shared">
        <div class="card" style="padding:18px">
            <div style="display:flex;align-items:flex-start;gap:14px">
                <div class="cat-ico" style="background:rgba(20,184,166,.12)"><i class="ri-flight-takeoff-line" style="color:#2dd4bf"></i></div>
                <div style="flex:1">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px">
                        <div class="font-jakarta" style="font-weight:600;font-size:.9rem;color:#f1f5f9">Family Holiday to Spain</div>
                        <span class="badge badge-teal">Travel</span>
                    </div>
                    <div style="font-size:.78rem;color:#64748b;margin-bottom:10px">Passport Renewal · Jul 15, 2026</div>
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px">
                        <span style="font-size:.75rem;color:#64748b">Shared by:</span>
                        <div class="sav">SW</div>
                        <span style="font-size:.84rem;font-weight:600;color:#94a3b8">Sarah Wilson</span>
                    </div>
                    <div style="display:flex;gap:8px">
                        <button class="btn btn-primary btn-sm" onclick="toast('Added to your reminders!','success')"><i class="ri-add-circle-line"></i> Add to Mine</button>
                        <button class="btn btn-ghost btn-sm" onclick="toast('Viewing reminder…','info')">View</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="shared-tab-history" class="tab-pane" data-group="shared">
        <div style="display:flex;flex-direction:column;gap:10px">
            <div class="act-item" style="display:flex;align-items:center;gap:10px">
                <div style="width:36px;height:36px;border-radius:10px;background:rgba(16,185,129,.12);display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="ri-share-forward-line" style="color:#10b981"></i></div>
                <div style="flex:1">
                    <div style="font-size:.87rem;font-weight:600;color:#f1f5f9">Shared "Mum's Birthday" via WhatsApp</div>
                    <div style="font-size:.75rem;color:#64748b">5 recipients · Apr 12, 2026 at 14:32</div>
                </div><span class="badge badge-green">Delivered</span>
            </div>
            <div class="act-item" style="display:flex;align-items:center;gap:10px">
                <div style="width:36px;height:36px;border-radius:10px;background:rgba(20,184,166,.12);display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="ri-mail-send-line" style="color:#2dd4bf"></i></div>
                <div style="flex:1">
                    <div style="font-size:.87rem;font-weight:600;color:#f1f5f9">Shared "Car Insurance" via Email</div>
                    <div style="font-size:.75rem;color:#64748b">sarah@example.com · Apr 10, 2026</div>
                </div><span class="badge badge-teal">Sent</span>
            </div>
            <div class="act-item" style="display:flex;align-items:center;gap:10px">
                <div style="width:36px;height:36px;border-radius:10px;background:rgba(244,63,94,.12);display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="ri-close-circle-line" style="color:#f43f5e"></i></div>
                <div style="flex:1">
                    <div style="font-size:.87rem;font-weight:600;color:#f1f5f9">Revoked "Netflix Subscription"</div>
                    <div style="font-size:.75rem;color:#64748b">john@example.com · Apr 8, 2026</div>
                </div><span class="badge badge-red">Revoked</span>
            </div>
        </div>
    </div>
</section>

@endsection
