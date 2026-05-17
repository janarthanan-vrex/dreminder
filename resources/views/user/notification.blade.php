@extends('user.layouts.app')
@section('content')

<section id="page-notifications" class="">
    <div style="margin-bottom:16px">
        <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800;color:#f1f5f9">Notifications</h2>
        <p style="font-size:.82rem;color:#64748b;margin-top:3px">Manage notification preferences and view your notification history</p>
    </div>

    <!-- TABS -->
   <div class="tabs-container" style="margin-bottom:20px">
    <div class="tabs-header" style="display:flex;gap:6px;border-bottom:1px solid rgba(255,255,255,.06);margin-bottom:20px">
        <button class="tab-btn active" onclick="switchTab('settings')" data-tab="settings">
            <i class="ri-settings-3-line"></i>
            <span>Settings</span>
        </button>

        <button class="tab-btn" onclick="switchTab('history')" data-tab="history">
            <i class="ri-history-line"></i>
            <span>History</span>
            <span class="badge-count"
                style="background:#7c3aed;color:#fff !important;font-size:.65rem;padding:2px 6px;border-radius:10px;font-weight:700;margin-left:4px">
                3
            </span>
        </button>
    </div>

    <!-- TAB 1: SETTINGS -->
    <div class="tab-content active" id="tab-settings">

        <form id="notification-form">

            <div class="g2" style="margin-bottom:16px">

                <!-- CHANNELS -->
                <div class="card" style="padding:18px">

                    <h3 class="font-jakarta"
                        style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:4px">
                        Notification Channels
                    </h3>

                    <p style="font-size:.78rem;color:#64748b;margin-bottom:14px">
                        Enable or disable notification methods
                    </p>

                    <div style="display:flex;flex-direction:column;gap:10px">

                        <!-- EMAIL -->
                        <div style="display:flex;align-items:center;justify-content:space-between;padding:12px;border-radius:12px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06)">

                            <div style="display:flex;align-items:center;gap:10px">

                                <div class="cat-ico"
                                    style="width:36px;height:36px;background:rgba(20,184,166,.12)">
                                    <i class="ri-mail-line"
                                        style="color:#2dd4bf;font-size:.95rem"></i>
                                </div>

                                <div>
                                    <div style="font-size:.85rem;font-weight:600;color:#94a3b8">
                                        Email
                                    </div>

                                    <div style="font-size:.73rem;color:#64748b">
                                        kishore@example.com
                                    </div>
                                </div>
                            </div>

                            <label style="cursor:pointer">

                                <input type="checkbox"
                                    hidden
                                    name="email_notify"
                                    id="email_notify"
                                    value="1">

                                <button type="button"
                                    class="toggle on"
                                    onclick="
                                        this.classList.toggle('on');
                                        document.getElementById('email_notify').checked =
                                        this.classList.contains('on');
                                    ">
                                </button>

                            </label>

                        </div>

                        <!-- PUSH -->
                        <div style="display:flex;align-items:center;justify-content:space-between;padding:12px;border-radius:12px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06)">

                            <div style="display:flex;align-items:center;gap:10px">

                                <div class="cat-ico"
                                    style="width:36px;height:36px;background:rgba(124,58,237,.15)">
                                    <i class="ri-notification-3-line"
                                        style="color:#a78bfa;font-size:.95rem"></i>
                                </div>

                                <div>
                                    <div style="font-size:.85rem;font-weight:600;color:#94a3b8">
                                        Push Notifications
                                    </div>

                                    <div style="font-size:.73rem;color:#64748b">
                                        Browser & mobile app
                                    </div>
                                </div>
                            </div>

                            <label style="cursor:pointer">

                                <input type="checkbox"
                                    hidden
                                    name="push_notify"
                                    id="push_notify"
                                    value="1">

                                <button type="button"
                                    class="toggle"
                                    onclick="
                                        this.classList.toggle('on');
                                        document.getElementById('push_notify').checked =
                                        this.classList.contains('on');
                                    ">
                                </button>

                            </label>

                        </div>

                    </div>
                </div>

                <!-- ALERT TIMINGS -->
                <div class="card" style="padding:18px">

                    <h3 class="font-jakarta"
                        style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:4px">
                        Alert Timing
                    </h3>

                    <p style="font-size:.78rem;color:#64748b;margin-bottom:14px">
                        When to receive notifications before Dates
                    </p>

                    <div style="display:flex;flex-direction:column;gap:6px">

                        <label style="display:flex;align-items:center;gap:10px;padding:10px;border-radius:10px;cursor:pointer;background:rgba(255,255,255,.02);border:1px solid rgba(255,255,255,.05)">

                            <input type="checkbox"
                                checked
                                name="before_30_days"
                                value="1"
                                style="accent-color:#7c3aed;width:15px;height:15px">

                            <div>
                                <div style="font-size:.85rem;font-weight:500;color:#94a3b8">
                                    30 days before
                                </div>

                                <div style="font-size:.72rem;color:#64748b">
                                    Early planning alert
                                </div>
                            </div>

                        </label>

                        <label style="display:flex;align-items:center;gap:10px;padding:10px;border-radius:10px;cursor:pointer;background:rgba(255,255,255,.02);border:1px solid rgba(255,255,255,.05)">

                            <input type="checkbox"
                                checked
                                name="before_7_days"
                                value="1"
                                style="accent-color:#7c3aed;width:15px;height:15px">

                            <div>
                                <div style="font-size:.85rem;font-weight:500;color:#94a3b8">
                                    7 days before
                                </div>

                                <div style="font-size:.72rem;color:#64748b">
                                    One week reminder
                                </div>
                            </div>

                        </label>

                        <label style="display:flex;align-items:center;gap:10px;padding:10px;border-radius:10px;cursor:pointer;background:rgba(255,255,255,.02);border:1px solid rgba(255,255,255,.05)">

                            <input type="checkbox"
                                checked
                                name="before_3_days"
                                value="1"
                                style="accent-color:#7c3aed;width:15px;height:15px">

                            <div>
                                <div style="font-size:.85rem;font-weight:500;color:#94a3b8">
                                    3 days before
                                </div>

                                <div style="font-size:.72rem;color:#64748b">
                                    Important alert
                                </div>
                            </div>

                        </label>

                        <label style="display:flex;align-items:center;gap:10px;padding:10px;border-radius:10px;cursor:pointer;background:rgba(255,255,255,.02);border:1px solid rgba(255,255,255,.05)">

                            <input type="checkbox"
                                checked
                                name="before_1_day"
                                value="1"
                                style="accent-color:#7c3aed;width:15px;height:15px">

                            <div>
                                <div style="font-size:.85rem;font-weight:500;color:#94a3b8">
                                    1 day before
                                </div>

                                <div style="font-size:.72rem;color:#64748b">
                                    Final reminder
                                </div>
                            </div>

                        </label>

                        <label style="display:flex;align-items:center;gap:10px;padding:10px;border-radius:10px;cursor:pointer;background:rgba(255,255,255,.02);border:1px solid rgba(255,255,255,.05)">

                            <input type="checkbox"
                                name="on_day"
                                value="1"
                                style="accent-color:#7c3aed;width:15px;height:15px">

                            <div>
                                <div style="font-size:.85rem;font-weight:500;color:#94a3b8">
                                    On the day
                                </div>

                                <div style="font-size:.72rem;color:#64748b">
                                    Date notification
                                </div>
                            </div>

                        </label>

                    </div>
                </div>

            </div>

            <!-- INFO -->
            <div class="card"
                style="padding:18px;margin-bottom:16px;background:rgba(124,58,237,.05);border:1px solid rgba(124,58,237,.2)">

                <div style="display:flex;align-items:flex-start;gap:12px">

                    <div style="width:40px;height:40px;border-radius:12px;background:rgba(124,58,237,.15);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <i class="ri-information-line"
                            style="color:#a78bfa;font-size:1.1rem"></i>
                    </div>

                    <div>
                        <h4 style="font-size:.87rem;font-weight:700;color:#f1f5f9;margin-bottom:6px">
                            Delivery & Reliability
                        </h4>

                        <ul style="font-size:.78rem;color:#94a3b8;line-height:1.7;padding-left:18px">
                            <li>Email notifications are sent instantly but may take 1-5 minutes to arrive</li>
                            <li>SMS delivery typically takes 5-30 seconds depending on your carrier</li>
                            <li>WhatsApp messages require an active internet connection</li>
                            <li>Push notifications work on devices with the DRemind app installed</li>
                        </ul>
                    </div>

                </div>
            </div>

            <!-- BUTTONS -->
            <div style="display:flex;gap:10px;justify-content:flex-end">

                <button type="button"
                    class="btn btn-ghost"
                    onclick="toast('Settings reset to default','info')">

                    <i class="ri-refresh-line"></i>
                    Reset
                </button>

                <button type="submit"
                    class="btn btn-primary">

                    <i class="ri-save-line"></i>
                    Save Preferences
                </button>

            </div>

        </form>

    </div>
</div>

<script>

document
.getElementById('notification-form')
.addEventListener('submit', async function(e){

    e.preventDefault();

    const formData = new FormData(this);

    const data = {

        email_notify: formData.has('email_notify') ? 1 : 0,

        push_notify: formData.has('push_notify') ? 1 : 0,

        before_30_days: formData.has('before_30_days') ? 1 : 0,

        before_7_days: formData.has('before_7_days') ? 1 : 0,

        before_3_days: formData.has('before_3_days') ? 1 : 0,

        before_1_day: formData.has('before_1_day') ? 1 : 0,

        on_day: formData.has('on_day') ? 1 : 0,
    };

    try {

        const res = await fetch('/notification-settings/update', {

            method: 'POST',

            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]')
                    .content,
                'Accept': 'application/json'
            },

            body: JSON.stringify(data)
        });

        const result = await res.json();

        if(result.status){

            toast(result.message, 'success');

        } else {

            toast('Something went wrong', 'error');
        }

    } catch(err){

        console.log(err);

        toast('Server error', 'error');
    }

});

</script>

    <!-- TAB 2: HISTORY -->
    <div class="tab-content" id="tab-history" style="display:none">
        <div style="display:flex;flex-wrap:wrap;gap:10px;margin-bottom:16px">
            <div class="search-box" style="flex:1;min-width:200px">
                <i class="ri-search-line" style="color:#64748b;font-size:.9rem"></i>
                <input id="notif-search" placeholder="Search notifications…" style="font-size:.85rem;color:inherit" oninput="filterNotifications()">
            </div>
            <select class="inp" style="width:auto;min-width:140px" id="notif-type" onchange="filterNotifications()">
                <option value="all">All Types</option>
                <option value="reminder">Reminders</option>
                <option value="system">System</option>
                <option value="shared">Shared</option>
                <option value="completed">Completed</option>
            </select>
            <select class="inp" style="width:auto;min-width:140px" id="notif-filter" onchange="filterNotifications()">
                <option value="all">All Time</option>
                <option value="today">Today</option>
                <option value="week">This Week</option>
                <option value="month">This Month</option>
                <option value="unread">Unread Only</option>
            </select>
            <button class="btn btn-ghost btn-sm" onclick="markAllRead()" title="Mark all as read">
                <i class="ri-check-double-line"></i> Mark All Read
            </button>
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
            <span style="font-size:.75rem;color:#64748b;font-weight:600">
                <span id="notif-count">0</span> notifications
                <span id="unread-count" style="color:#f59e0b"></span>
            </span>
            <button class="btn btn-ghost btn-sm" onclick="clearAllNotifications()">
                <i class="ri-delete-bin-line"></i> Clear All
            </button>
        </div>

        <div id="notif-list" style="display:flex;flex-direction:column;gap:8px">
            <!-- Unread Notifications -->
            <div class="notif-item unread" data-type="reminder" data-date="today">
                <div style="display:flex;align-items:flex-start;gap:10px">
                    <div style="width:36px;height:36px;border-radius:10px;background:rgba(245,158,11,.12);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <i class="ri-alarm-line" style="color:#f59e0b"></i>
                    </div>
                    <div style="flex:1">
                        <div style="font-size:.87rem;font-weight:600;color:#f1f5f9">Car Insurance Due Soon</div>
                        <div style="font-size:.76rem;color:#64748b;margin-top:2px">Your car insurance renewal is due in 3 days (Apr 19, 2026)</div>
                        <div style="font-size:.72rem;color:#475569;margin-top:4px">
                            <i class="ri-time-line"></i> 2 hours ago
                            <span style="margin:0 6px">•</span>
                            <span style="color:#f59e0b">via Email & SMS</span>
                        </div>
                    </div>
                    <div style="display:flex;gap:4px;flex-shrink:0">
                        <button class="btn btn-ghost btn-xs" onclick="markAsRead(this)" title="Mark as read">
                            <i class="ri-check-line"></i>
                        </button>
                        <button class="btn btn-ghost btn-xs" onclick="deleteNotification(this)" title="Delete">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="notif-item unread" data-type="reminder" data-date="today">
                <div style="display:flex;align-items:flex-start;gap:10px">
                    <div style="width:36px;height:36px;border-radius:10px;background:rgba(239,68,68,.12);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <i class="ri-error-warning-line" style="color:#ef4444"></i>
                    </div>
                    <div style="flex:1">
                        <div style="font-size:.87rem;font-weight:600;color:#f1f5f9">Overdue: Netflix Subscription</div>
                        <div style="font-size:.76rem;color:#64748b;margin-top:2px">Your Netflix subscription was due yesterday (Apr 15, 2026)</div>
                        <div style="font-size:.72rem;color:#475569;margin-top:4px">
                            <i class="ri-time-line"></i> 5 hours ago
                            <span style="margin:0 6px">•</span>
                            <span style="color:#ef4444">via All Channels</span>
                        </div>
                    </div>
                    <div style="display:flex;gap:4px;flex-shrink:0">
                        <button class="btn btn-ghost btn-xs" onclick="markAsRead(this)" title="Mark as read">
                            <i class="ri-check-line"></i>
                        </button>
                        <button class="btn btn-ghost btn-xs" onclick="deleteNotification(this)" title="Delete">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="notif-item unread" data-type="reminder" data-date="today">
                <div style="display:flex;align-items:flex-start;gap:10px">
                    <div style="width:36px;height:36px;border-radius:10px;background:rgba(124,58,237,.12);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <i class="ri-notification-badge-line" style="color:#a78bfa"></i>
                    </div>
                    <div style="flex:1">
                        <div style="font-size:.87rem;font-weight:600;color:#f1f5f9">Upcoming: MOT Due in 7 Days</div>
                        <div style="font-size:.76rem;color:#64748b;margin-top:2px">Your vehicle MOT is due on Apr 23, 2026. Book your appointment soon.</div>
                        <div style="font-size:.72rem;color:#475569;margin-top:4px">
                            <i class="ri-time-line"></i> 1 day ago
                            <span style="margin:0 6px">•</span>
                            <span style="color:#a78bfa">via Email</span>
                        </div>
                    </div>
                    <div style="display:flex;gap:4px;flex-shrink:0">
                        <button class="btn btn-ghost btn-xs" onclick="markAsRead(this)" title="Mark as read">
                            <i class="ri-check-line"></i>
                        </button>
                        <button class="btn btn-ghost btn-xs" onclick="deleteNotification(this)" title="Delete">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Read Notifications -->
            <div class="notif-item" data-type="completed" data-date="today">
                <div style="display:flex;align-items:flex-start;gap:10px">
                    <div style="width:36px;height:36px;border-radius:10px;background:rgba(16,185,129,.12);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <i class="ri-check-double-line" style="color:#10b981"></i>
                    </div>
                    <div style="flex:1">
                        <div style="font-size:.87rem;font-weight:600;color:#94a3b8">Reminder Completed</div>
                        <div style="font-size:.76rem;color:#64748b;margin-top:2px">You marked "Gym Membership Renewal" as complete</div>
                        <div style="font-size:.72rem;color:#475569;margin-top:4px">
                            <i class="ri-time-line"></i> 1 day ago
                        </div>
                    </div>
                    <button class="btn btn-ghost btn-xs" onclick="deleteNotification(this)" title="Delete">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                </div>
            </div>

            <div class="notif-item" data-type="shared" data-date="week">
                <div style="display:flex;align-items:flex-start;gap:10px">
                    <div style="width:36px;height:36px;border-radius:10px;background:rgba(20,184,166,.12);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <i class="ri-share-line" style="color:#2dd4bf"></i>
                    </div>
                    <div style="flex:1">
                        <div style="font-size:.87rem;font-weight:600;color:#94a3b8">Reminder Shared</div>
                        <div style="font-size:.76rem;color:#64748b;margin-top:2px">You shared "Mum's Birthday" with 5 people</div>
                        <div style="font-size:.72rem;color:#475569;margin-top:4px">
                            <i class="ri-time-line"></i> 2 days ago
                        </div>
                    </div>
                    <button class="btn btn-ghost btn-xs" onclick="deleteNotification(this)" title="Delete">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                </div>
            </div>

            <div class="notif-item" data-type="system" data-date="week">
                <div style="display:flex;align-items:flex-start;gap:10px">
                    <div style="width:36px;height:36px;border-radius:10px;background:rgba(6,182,212,.12);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <i class="ri-shield-check-line" style="color:#06b6d4"></i>
                    </div>
                    <div style="flex:1">
                        <div style="font-size:.87rem;font-weight:600;color:#94a3b8">Account Security Update</div>
                        <div style="font-size:.76rem;color:#64748b;margin-top:2px">Your password was successfully changed from a new device</div>
                        <div style="font-size:.72rem;color:#475569;margin-top:4px">
                            <i class="ri-time-line"></i> 3 days ago
                        </div>
                    </div>
                    <button class="btn btn-ghost btn-xs" onclick="deleteNotification(this)" title="Delete">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                </div>
            </div>

            <div class="notif-item" data-type="reminder" data-date="week">
                <div style="display:flex;align-items:flex-start;gap:10px">
                    <div style="width:36px;height:36px;border-radius:10px;background:rgba(16,185,129,.12);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <i class="ri-calendar-check-line" style="color:#10b981"></i>
                    </div>
                    <div style="flex:1">
                        <div style="font-size:.87rem;font-weight:600;color:#94a3b8">Reminder Created</div>
                        <div style="font-size:.76rem;color:#64748b;margin-top:2px">You created a new reminder: "Dentist Appointment"</div>
                        <div style="font-size:.72rem;color:#475569;margin-top:4px">
                            <i class="ri-time-line"></i> 5 days ago
                        </div>
                    </div>
                    <button class="btn btn-ghost btn-xs" onclick="deleteNotification(this)" title="Delete">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                </div>
            </div>

            <div class="notif-item" data-type="system" data-date="month">
                <div style="display:flex;align-items:flex-start;gap:10px">
                    <div style="width:36px;height:36px;border-radius:10px;background:rgba(124,58,237,.12);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <i class="ri-vip-crown-line" style="color:#a78bfa"></i>
                    </div>
                    <div style="flex:1">
                        <div style="font-size:.87rem;font-weight:600;color:#94a3b8">Subscription Renewed</div>
                        <div style="font-size:.76rem;color:#64748b;margin-top:2px">Your DRemind annual membership has been renewed. Thank you!</div>
                        <div style="font-size:.72rem;color:#475569;margin-top:4px">
                            <i class="ri-time-line"></i> 1 week ago
                        </div>
                    </div>
                    <button class="btn btn-ghost btn-xs" onclick="deleteNotification(this)" title="Delete">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        <div id="notif-empty" style="display:none;text-align:center;padding:60px 0">
            <div style="font-size:3.5rem;color:rgba(255,255,255,.1);margin-bottom:10px">
                <i class="ri-notification-off-line"></i>
            </div>
            <div class="font-jakarta" style="font-weight:700;font-size:1.05rem;color:#94a3b8;margin-bottom:6px">No Notifications</div>
            <div style="font-size:.83rem;color:#64748b">You're all caught up!</div>
        </div>
    </div>
    </div>
</section>

<style>
    /* Tab Styles */
    .tabs-header {
        position: relative;
    }

    .tab-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border: none;
        background: transparent;
        color: #64748b;
        font-size: .85rem;
        font-weight: 600;
        border-bottom: 2px solid transparent;
        cursor: pointer;
        transition: all .3s;
        position: relative;
    }

    .tab-btn:hover {
        color: #94a3b8;
        background: rgba(255, 255, 255, .02);
    }

    .tab-btn.active {
        color: #f1f5f9;
        border-bottom-color: #7c3aed;
    }

    .tab-btn i {
        font-size: 1rem;
    }

    .tab-content {
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Notification Item Styles */
    .notif-item {
        padding: 14px;
        border-radius: 12px;
        background: rgba(255, 255, 255, .02);
        border: 1px solid rgba(255, 255, 255, .06);
        transition: all .3s;
    }

    .notif-item:hover {
        background: rgba(255, 255, 255, .04);
        border-color: rgba(255, 255, 255, .1);
    }

    .notif-item.unread {
        background: rgba(124, 58, 237, .05);
        border-color: rgba(124, 58, 237, .2);
    }

    .notif-item.unread::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 60%;
        background: #7c3aed;
        border-radius: 0 4px 4px 0;
    }

    .notif-item {
        position: relative;
    }
</style>

<script>
    // Tab Switching
    function switchTab(tabName) {
        // Remove active class from all tabs
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        document.querySelectorAll('.tab-content').forEach(content => {
            content.style.display = 'none';
            content.classList.remove('active');
        });

        // Add active class to selected tab
        document.querySelector(`[data-tab="${tabName}"]`).classList.add('active');
        document.getElementById(`tab-${tabName}`).style.display = 'block';
        document.getElementById(`tab-${tabName}`).classList.add('active');

        // Update count if switching to history
        if (tabName === 'history') {
            updateNotificationCount();
        }
    }

    // Filter Notifications
    function filterNotifications() {
        const searchVal = document.getElementById('notif-search').value.toLowerCase();
        const typeVal = document.getElementById('notif-type').value;
        const filterVal = document.getElementById('notif-filter').value;
        const items = document.querySelectorAll('#notif-list .notif-item');

        let visibleCount = 0;
        let unreadCount = 0;

        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            const type = item.dataset.type;
            const date = item.dataset.date;
            const isUnread = item.classList.contains('unread');

            let show = true;

            // Search filter
            if (searchVal && !text.includes(searchVal)) show = false;

            // Type filter
            if (typeVal !== 'all' && type !== typeVal) show = false;

            // Date filter
            if (filterVal === 'unread' && !isUnread) show = false;
            if (filterVal !== 'all' && filterVal !== 'unread' && date !== filterVal) show = false;

            item.style.display = show ? 'block' : 'none';
            if (show) {
                visibleCount++;
                if (isUnread) unreadCount++;
            }
        });

        document.getElementById('notif-count').textContent = visibleCount;
        document.getElementById('unread-count').textContent = unreadCount > 0 ? `(${unreadCount} unread)` : '';
        document.getElementById('notif-empty').style.display = visibleCount === 0 ? 'block' : 'none';
        document.getElementById('notif-list').style.display = visibleCount === 0 ? 'none' : 'flex';
    }

    // Update Notification Count
    function updateNotificationCount() {
        const items = document.querySelectorAll('#notif-list .notif-item');
        const unreadItems = document.querySelectorAll('#notif-list .notif-item.unread');

        document.getElementById('notif-count').textContent = items.length;
        document.getElementById('unread-count').textContent = unreadItems.length > 0 ? `(${unreadItems.length} unread)` : '';

        // Update badge on tab
        const badge = document.querySelector('[data-tab="history"] .badge-count');
        if (badge) {
            badge.textContent = unreadItems.length;
            badge.style.display = unreadItems.length > 0 ? 'inline-block' : 'none';
        }
    }

    // Mark as Read
    function markAsRead(btn) {
        const item = btn.closest('.notif-item');
        item.classList.remove('unread');
        btn.remove();
        updateNotificationCount();
        toast('Notification marked as read', 'success');
    }

    // Mark All Read
    function markAllRead() {
        const unreadItems = document.querySelectorAll('#notif-list .notif-item.unread');
        unreadItems.forEach(item => {
            item.classList.remove('unread');
            const readBtn = item.querySelector('[onclick*="markAsRead"]');
            if (readBtn) readBtn.remove();
        });
        updateNotificationCount();
        toast('All notifications marked as read', 'success');
    }

    // Delete Notification
    function deleteNotification(btn) {
        const item = btn.closest('.notif-item');
        item.style.opacity = '0';
        item.style.transform = 'translateX(-20px)';
        setTimeout(() => {
            item.remove();
            updateNotificationCount();
            filterNotifications();
        }, 300);
        toast('Notification deleted', 'info');
    }

    // Clear All Notifications
    function clearAllNotifications() {
        if (!confirm('Are you sure you want to clear all notifications? This cannot be undone.')) return;

        const items = document.querySelectorAll('#notif-list .notif-item');
        items.forEach((item, index) => {
            setTimeout(() => {
                item.style.opacity = '0';
                item.style.transform = 'translateX(-20px)';
                setTimeout(() => item.remove(), 300);
            }, index * 50);
        });

        setTimeout(() => {
            updateNotificationCount();
            filterNotifications();
            toast('All notifications cleared', 'success');
        }, items.length * 50 + 400);
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', () => {
        updateNotificationCount();
    });
</script>

@endsection