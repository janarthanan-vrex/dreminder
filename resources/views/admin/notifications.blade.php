@extends('admin.layouts.app')
@section('content')

<!-- ═══ NOTIFICATIONS ═══ -->
<section id="page-notifications" class="page active">
    <div
        style="
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        "
    >
        <div>
            <h2 class="font-jakarta" style="font-size: 1.3rem; font-weight: 800">
                Notification Center
            </h2>
            <p style="font-size: 1.2re; color: var(--text3); margin-top: 3px">
                Manage system-wide notifications
            </p>
        </div>
        <button class="btn btn-primary btn-sm" onclick="openModal('send-notif-modal')">
            <i class="ri-send-plane-line"></i> Send Notification
        </button>
    </div>
    <div class="tab-bar">
        <button class="tab-btn active" onclick="swTab('notif','inbox',this)">
            Inbox <span class="badge badge-red" style="font-size: 0.6rem; padding: 1px 6px">5</span>
        </button>
        <button class="tab-btn" onclick="swTab('notif','broadcast',this)">Broadcast</button>
    </div>
    <div id="notif-tab-inbox" class="tab-pane active">
        <div style="display: flex; flex-direction: column; gap: 8px" id="admin-notif-list"></div>
    </div>
    <div id="notif-tab-broadcast" class="tab-pane">
        <div class="card" style="padding: 24px">
            <div class="section-title">Broadcast Message</div>
            <div class="form-row">
                <label class="label">Target Audience</label
                ><select class="inp">
                    <option>All Users</option>
                    <option>Active Users</option>
                    <option>Pro Plan Users</option>
                    <option>Inactive (30+ days)</option>
                </select>
            </div>
            <div class="form-row">
                <label class="label">Channel</label>
                <div style="display: flex; gap: 8px; flex-wrap: wrap">
                    <label
                        style="
                            display: flex;
                            align-items: center;
                            gap: 6px;
                            font-size: 1.2re;
                            color: var(--text2);
                            cursor: pointer;
                        "
                        ><input type="checkbox" style="accent-color: var(--purple)" checked />
                        Email</label
                    ><label
                        style="
                            display: flex;
                            align-items: center;
                            gap: 6px;
                            font-size: 1.2re;
                            color: var(--text2);
                            cursor: pointer;
                        "
                        ><input type="checkbox" style="accent-color: var(--purple)" /> SMS</label
                    ><label
                        style="
                            display: flex;
                            align-items: center;
                            gap: 6px;
                            font-size: 1.2re;
                            color: var(--text2);
                            cursor: pointer;
                        "
                        ><input type="checkbox" style="accent-color: var(--purple)" checked />
                        Push</label
                    ><label
                        style="
                            display: flex;
                            align-items: center;
                            gap: 6px;
                            font-size: 1.2re;
                            color: var(--text2);
                            cursor: pointer;
                        "
                        ><input type="checkbox" style="accent-color: var(--purple)" />
                        WhatsApp</label
                    >
                </div>
            </div>
            <div class="form-row">
                <label class="label">Subject</label
                ><input class="inp" placeholder="Notification subject…" />
            </div>
            <div class="form-row">
                <label class="label">Message</label
                ><textarea
                    class="inp"
                    rows="4"
                    placeholder="Write your message…"
                    style="resize: vertical"
                ></textarea>
            </div>
            <div style="display: flex; gap: 8px; justify-content: flex-end">
                <button class="btn btn-ghost btn-sm">Preview</button
                ><button
                    class="btn btn-primary btn-sm"
                    onclick="toast('Broadcast sent to 1,284 users!','success')"
                >
                    <i class="ri-send-plane-line"></i> Send Now
                </button>
            </div>
        </div>
    </div>
   
</section>
@endsection
