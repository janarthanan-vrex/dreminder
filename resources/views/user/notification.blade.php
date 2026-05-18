@extends('user.layouts.app')
@section('content')

<style>
    .tabs-header { position: relative; }

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
        background: rgba(255,255,255,.02);
    }

    .tab-btn.active {
        color: #f1f5f9;
        border-bottom-color: #7c3aed;
    }

    .tab-btn i { font-size: 1rem; }

    .tab-content { animation: fadeIn 0.3s ease-in-out; }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ── Notification items ── */
    .notif-item {
        padding: 14px;
        border-radius: 12px;
        background: rgba(255,255,255,.02);
        border: 1px solid rgba(255,255,255,.06);
        transition: all .3s;
        position: relative;
    }

    .notif-item:hover {
        background: rgba(255,255,255,.04);
        border-color: rgba(255,255,255,.1);
    }

    .notif-item.unread {
        background: rgba(124,58,237,.05);
        border-color: rgba(124,58,237,.2);
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

    .notif-item.removing {
        opacity: 0;
        transform: translateX(-20px);
        transition: all .3s;
    }

    /* ── Category icon dot ── */
    .cat-dot {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: .95rem;
    }

    /* ── Empty state ── */
    .notif-empty-state {
        text-align: center;
        padding: 60px 0;
    }

    .notif-empty-state i {
        font-size: 3.5rem;
        color: rgba(255,255,255,.1);
        display: block;
        margin-bottom: 10px;
    }
</style>

<section id="page-notifications">

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
                @if($unreadCount > 0)
                <span class="badge-count"
                    style="background:#7c3aed;color:#fff;font-size:.65rem;padding:2px 6px;border-radius:10px;font-weight:700;margin-left:4px"
                    id="tab-unread-badge">
                    {{ $unreadCount }}
                </span>
                @else
                <span class="badge-count"
                    style="background:#7c3aed;color:#fff;font-size:.65rem;padding:2px 6px;border-radius:10px;font-weight:700;margin-left:4px;display:none"
                    id="tab-unread-badge">
                    0
                </span>
                @endif
            </button>

        </div>

        <!-- ════════════════════════════════════════
             TAB 1: SETTINGS
        ════════════════════════════════════════ -->
        <div class="tab-content active" id="tab-settings">

            <form id="notification-form">

                <div class="g2" style="margin-bottom:16px">

                    <!-- CHANNELS -->
                    <div class="card" style="padding:18px">

                        <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:4px">
                            Notification Channels
                        </h3>

                        <p style="font-size:.78rem;color:#64748b;margin-bottom:14px">
                            Enable or disable notification methods
                        </p>

                        <div style="display:flex;flex-direction:column;gap:10px">

                            <!-- EMAIL -->
                            <div style="display:flex;align-items:center;justify-content:space-between;padding:12px;border-radius:12px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06)">
                                <div style="display:flex;align-items:center;gap:10px">
                                    <div class="cat-ico" style="width:36px;height:36px;background:rgba(20,184,166,.12)">
                                        <i class="ri-mail-line" style="color:#2dd4bf;font-size:.95rem"></i>
                                    </div>
                                    <div>
                                        <div style="font-size:.85rem;font-weight:600;color:#94a3b8">Email</div>
                                        <div style="font-size:.73rem;color:#64748b">{{ auth()->user()->email }}</div>
                                    </div>
                                </div>
                                <label style="cursor:pointer">
                                    <input type="checkbox" hidden name="email_notify" id="email_notify" value="1">
                                    <button type="button" class="toggle on"
                                        onclick="this.classList.toggle('on');document.getElementById('email_notify').checked=this.classList.contains('on')">
                                    </button>
                                </label>
                            </div>

                            <!-- PUSH -->
                            <div style="display:flex;align-items:center;justify-content:space-between;padding:12px;border-radius:12px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06)">
                                <div style="display:flex;align-items:center;gap:10px">
                                    <div class="cat-ico" style="width:36px;height:36px;background:rgba(124,58,237,.15)">
                                        <i class="ri-notification-3-line" style="color:#a78bfa;font-size:.95rem"></i>
                                    </div>
                                    <div>
                                        <div style="font-size:.85rem;font-weight:600;color:#94a3b8">Push Notifications</div>
                                        <div style="font-size:.73rem;color:#64748b">Browser &amp; mobile app</div>
                                    </div>
                                </div>
                                <label style="cursor:pointer">
                                    <input type="checkbox" hidden name="push_notify" id="push_notify" value="1">
                                    <button type="button" class="toggle"
                                        onclick="this.classList.toggle('on');document.getElementById('push_notify').checked=this.classList.contains('on')">
                                    </button>
                                </label>
                            </div>

                        </div>
                    </div>

                    <!-- ALERT TIMINGS -->
                    <div class="card" style="padding:18px">

                        <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:4px">
                            Alert Timing
                        </h3>

                        <p style="font-size:.78rem;color:#64748b;margin-bottom:14px">
                            When to receive notifications before Dates
                        </p>

                        <div style="display:flex;flex-direction:column;gap:6px">

                            @foreach([
                                ['before_30_days', '30 days before', 'Early planning alert',  true],
                                ['before_7_days',  '7 days before',  'One week reminder',      true],
                                ['before_3_days',  '3 days before',  'Important alert',        true],
                                ['before_1_day',   '1 day before',   'Final reminder',         true],
                                ['on_day',         'On the day',     'Date notification',      false],
                            ] as [$name, $label, $sub, $checked])
                            <label style="display:flex;align-items:center;gap:10px;padding:10px;border-radius:10px;cursor:pointer;background:rgba(255,255,255,.02);border:1px solid rgba(255,255,255,.05)">
                                <input type="checkbox"
                                    {{ $checked ? 'checked' : '' }}
                                    name="{{ $name }}"
                                    value="1"
                                    style="accent-color:#7c3aed;width:15px;height:15px">
                                <div>
                                    <div style="font-size:.85rem;font-weight:500;color:#94a3b8">{{ $label }}</div>
                                    <div style="font-size:.72rem;color:#64748b">{{ $sub }}</div>
                                </div>
                            </label>
                            @endforeach

                        </div>
                    </div>

                </div>

                <!-- INFO BOX -->
                <div class="card" style="padding:18px;margin-bottom:16px;background:rgba(124,58,237,.05);border:1px solid rgba(124,58,237,.2)">
                    <div style="display:flex;align-items:flex-start;gap:12px">
                        <div style="width:40px;height:40px;border-radius:12px;background:rgba(124,58,237,.15);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                            <i class="ri-information-line" style="color:#a78bfa;font-size:1.1rem"></i>
                        </div>
                        <div>
                            <h4 style="font-size:.87rem;font-weight:700;color:#f1f5f9;margin-bottom:6px">Delivery &amp; Reliability</h4>
                            <ul style="font-size:.78rem;color:#94a3b8;line-height:1.7;padding-left:18px">
                                <li>Email notifications are sent instantly but may take 1–5 minutes to arrive</li>
                                <li>Push notifications work on devices with the DRemind app installed</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- BUTTONS -->
                <div style="display:flex;gap:10px;justify-content:flex-end">
                    <button type="button" class="btn btn-ghost" onclick="toast('Settings reset to default','info')">
                        <i class="ri-refresh-line"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-save-line"></i> Save Preferences
                    </button>
                </div>

            </form>

        </div>

        <!-- ════════════════════════════════════════
             TAB 2: HISTORY (real DB data)
        ════════════════════════════════════════ -->
        <div class="tab-content" id="tab-history" style="display:none">

            <!-- Toolbar -->
            <div style="display:flex;flex-wrap:wrap;gap:10px;margin-bottom:16px">

                <div class="search-box" style="flex:1;min-width:200px">
                    <i class="ri-search-line" style="color:#64748b;font-size:.9rem"></i>
                    <input id="notif-search" placeholder="Search notifications…"
                        style="font-size:.85rem;color:inherit"
                        oninput="filterNotifications()">
                </div>

                <select class="inp" style="width:auto;min-width:140px" id="notif-filter" onchange="filterNotifications()">
                    <option value="all">All</option>
                    <option value="unread">Unread Only</option>
                    <option value="read">Read Only</option>
                </select>

                <button class="btn btn-ghost btn-sm" onclick="markAllReadAjax()">
                    <i class="ri-check-double-line"></i> Mark All Read
                </button>

            </div>

            <!-- Count row -->
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
                <span style="font-size:.75rem;color:#64748b;font-weight:600">
                    <span id="notif-count">{{ $activities->count() }}</span> notifications
                    <span id="unread-label" style="color:#f59e0b">
                        @if($unreadCount > 0)({{ $unreadCount }} unread)@endif
                    </span>
                </span>
                <button class="btn btn-ghost btn-sm" onclick="clearAllAjax()">
                    <i class="ri-delete-bin-line"></i> Clear All
                </button>
            </div>

            <!-- Notification list -->
            <div id="notif-list" style="display:flex;flex-direction:column;gap:8px">

                @forelse($activities as $activity)

                @php
                    $isUnread = !$activity['is_seen'];
                    $cat      = $activity['category'];
                    $reminder = $activity['reminder'];

                    // derive an icon color & bg from the category data
                    $catIcon  = $cat['icon']  ?? 'ri-bell-line';
                    $catColor = $cat['color'] ?? '#94a3b8';
                    $catBg    = 'rgba(' . implode(',', sscanf($catColor, '#%02x%02x%02x')) . ',.12)';
                    $catName  = $cat['name']  ?? 'System';
                @endphp

                <div class="notif-item {{ $isUnread ? 'unread' : '' }}"
                     data-id="{{ $activity['id'] }}"
                     data-seen="{{ $activity['is_seen'] }}">

                    <div style="display:flex;align-items:flex-start;gap:10px">

                        <!-- Category icon -->
                        <div class="cat-dot" style="background:{{ $catBg }}">
                            <i class="{{ $catIcon }}" style="color:{{ $catColor }}"></i>
                        </div>

                        <!-- Body -->
                        <div style="flex:1">

                            @if($reminder)
                            <div style="font-size:.87rem;font-weight:600;color:{{ $isUnread ? '#f1f5f9' : '#94a3b8' }}">
                                {{ $reminder['title'] }}
                            </div>
                            @endif

                            <div style="font-size:.76rem;color:#64748b;margin-top:2px">
                                {{ $activity['description'] }}
                            </div>

                            <div style="font-size:.72rem;color:#475569;margin-top:4px;display:flex;align-items:center;gap:6px">
                                <i class="ri-time-line"></i>
                                {{ $activity['created_at'] }}
                                @if($catName !== 'System')
                                <span style="margin:0 2px">•</span>
                                <span style="color:{{ $catColor }}">{{ $catName }}</span>
                                @endif
                            </div>

                        </div>

                        <!-- Actions -->
                        <div style="display:flex;gap:4px;flex-shrink:0">

                            @if($isUnread)
                            <button class="btn btn-ghost btn-xs"
                                onclick="markReadAjax({{ $activity['id'] }}, this)"
                                title="Mark as read">
                                <i class="ri-check-line"></i>
                            </button>
                            @endif

                            <button class="btn btn-ghost btn-xs"
                                onclick="deleteNotifAjax({{ $activity['id'] }}, this)"
                                title="Delete">
                                <i class="ri-delete-bin-line"></i>
                            </button>

                        </div>

                    </div>

                </div>

                @empty

                <div class="notif-empty-state" id="notif-empty-initial">
                    <i class="ri-notification-off-line"></i>
                    <div class="font-jakarta" style="font-weight:700;font-size:1.05rem;color:#94a3b8;margin-bottom:6px">
                        No Notifications
                    </div>
                    <div style="font-size:.83rem;color:#64748b">You're all caught up!</div>
                </div>

                @endforelse

            </div>

            <!-- JS-driven empty state (shown when all filtered/deleted) -->
            <div id="notif-empty" style="display:none" class="notif-empty-state">
                <i class="ri-notification-off-line"></i>
                <div class="font-jakarta" style="font-weight:700;font-size:1.05rem;color:#94a3b8;margin-bottom:6px">
                    No Notifications
                </div>
                <div style="font-size:.83rem;color:#64748b">You're all caught up!</div>
            </div>

        </div>

    </div>
</section>

<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;

/* ─── Tab switching ──────────────────────────────────── */
function switchTab(tabName) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(c => {
        c.style.display = 'none';
        c.classList.remove('active');
    });
    document.querySelector(`[data-tab="${tabName}"]`).classList.add('active');
    const el = document.getElementById('tab-' + tabName);
    el.style.display = 'block';
    el.classList.add('active');
    if (tabName === 'history') refreshCounts();
}

/* ─── Counts ─────────────────────────────────────────── */
function refreshCounts() {
    const items    = document.querySelectorAll('#notif-list .notif-item');
    const visible  = [...items].filter(i => i.style.display !== 'none');
    const unread   = visible.filter(i => i.classList.contains('unread'));

    document.getElementById('notif-count').textContent   = visible.length;
    document.getElementById('unread-label').textContent  = unread.length > 0 ? `(${unread.length} unread)` : '';

    const badge = document.getElementById('tab-unread-badge');
    if (badge) {
        badge.textContent    = unread.length;
        badge.style.display  = unread.length > 0 ? 'inline-block' : 'none';
    }

    // show/hide empty state
    const anyVisible = visible.length > 0;
    document.getElementById('notif-empty').style.display     = anyVisible ? 'none' : 'block';
    document.getElementById('notif-list').style.display      = anyVisible ? 'flex'  : 'none';
    const initial = document.getElementById('notif-empty-initial');
    if (initial) initial.style.display = 'none';
}

/* ─── Filter ─────────────────────────────────────────── */
function filterNotifications() {
    const q      = document.getElementById('notif-search').value.toLowerCase();
    const filter = document.getElementById('notif-filter').value;

    document.querySelectorAll('#notif-list .notif-item').forEach(item => {
        const text     = item.textContent.toLowerCase();
        const isUnread = item.classList.contains('unread');

        let show = true;
        if (q && !text.includes(q))            show = false;
        if (filter === 'unread' && !isUnread)  show = false;
        if (filter === 'read'   &&  isUnread)  show = false;

        item.style.display = show ? 'block' : 'none';
    });

    refreshCounts();
}

/* ─── Mark single as read ────────────────────────────── */
async function markReadAjax(id, btn) {
    try {
        const res    = await fetch(`/notifications/${id}/mark-read`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        });
        const result = await res.json();
        if (!res.ok) { toast(result.message, 'error'); return; }

        const item = btn.closest('.notif-item');
        item.classList.remove('unread');
        item.dataset.seen = '1';
        // update title color
        const title = item.querySelector('[style*="font-weight:600"]');
        if (title) title.style.color = '#94a3b8';
        // remove the mark-read button
        btn.remove();
        refreshCounts();
        toast(result.message, 'success');

    } catch (err) {
        console.error(err);
        toast('Something went wrong', 'error');
    }
}

/* ─── Mark ALL as read ───────────────────────────────── */
async function markAllReadAjax() {
    try {
        const res    = await fetch('/notifications/mark-all-read', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        });
        const result = await res.json();
        if (!res.ok) { toast(result.message, 'error'); return; }

        document.querySelectorAll('#notif-list .notif-item.unread').forEach(item => {
            item.classList.remove('unread');
            item.dataset.seen = '1';
            const title = item.querySelector('[style*="font-weight:600"]');
            if (title) title.style.color = '#94a3b8';
            // remove per-item read button
            const readBtn = item.querySelector('[onclick*="markReadAjax"]');
            if (readBtn) readBtn.remove();
        });
        refreshCounts();
        toast(result.message, 'success');

    } catch (err) {
        console.error(err);
        toast('Something went wrong', 'error');
    }
}

/* ─── Delete single ──────────────────────────────────── */
async function deleteNotifAjax(id, btn) {
    try {
        const res    = await fetch(`/notifications/${id}/delete`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        });
        const result = await res.json();
        if (!res.ok) { toast(result.message, 'error'); return; }

        const item = btn.closest('.notif-item');
        item.classList.add('removing');
        setTimeout(() => {
    item.remove();
    refreshCounts();
    location.reload();
}, 300);
        toast(result.message, 'info');

    } catch (err) {
        console.error(err);
        toast('Something went wrong', 'error');
    }
}

/* ─── Clear ALL ──────────────────────────────────────── */
async function clearAllAjax() {
    if (!confirm('Clear all notifications? This cannot be undone.')) return;
    try {
        const res    = await fetch('/notifications/clear-all', {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        });
        const result = await res.json();
        if (!res.ok) { toast(result.message, 'error'); return; }

        const items = document.querySelectorAll('#notif-list .notif-item');
        items.forEach((item, i) => {
            setTimeout(() => {
                item.classList.add('removing');
                setTimeout(() => item.remove(), 300);
            }, i * 40);
        });
       setTimeout(() => { refreshCounts(); location.reload(); }, items.length * 40 + 350);
        toast(result.message, 'success');

    } catch (err) {
        console.error(err);
        toast('Something went wrong', 'error');
    }
}

/* ─── Settings form ──────────────────────────────────── */
document.getElementById('notification-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    const fd   = new FormData(this);
    const data = {
        email_notify:  fd.has('email_notify')  ? 1 : 0,
        push_notify:   fd.has('push_notify')   ? 1 : 0,
        before_30_days: fd.has('before_30_days') ? 1 : 0,
        before_7_days:  fd.has('before_7_days')  ? 1 : 0,
        before_3_days:  fd.has('before_3_days')  ? 1 : 0,
        before_1_day:   fd.has('before_1_day')   ? 1 : 0,
        on_day:         fd.has('on_day')          ? 1 : 0,
    };
    try {
        const res    = await fetch('/notification-settings/update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        });
        const result = await res.json();
        toast(result.status ? result.message : 'Something went wrong', result.status ? 'success' : 'error');
    } catch (err) {
        console.error(err);
        toast('Server error', 'error');
    }
});

/* ─── Boot ───────────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', refreshCounts);
</script>

@endsection