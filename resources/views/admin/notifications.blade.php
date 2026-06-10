@extends('admin.layouts.app')
@section('content')

<!-- ═══ NOTIFICATIONS ═══ -->
 @if(!auth('admin')->user()->hasPermission('Notifications','notifications.action'))
<style>
.action-btn {
    display: none !important;
}
</style>
@endif
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
        <button class="btn btn-primary btn-sm hidden" onclick="openModal('send-notif-modal')">
            <i class="ri-send-plane-line"></i> Send Notification
        </button>
    </div>
    <div class="tab-bar">
       <button class="tab-btn active" onclick="swTab('notif','inbox',this)">
    Inbox
    <span id="notif-count" class="badge badge-red" style="font-size:.6rem;padding:1px 6px">
         {{ $notifications->count() }}
    </span>
</button>
        <button class="tab-btn hidden" onclick="swTab('notif','broadcast',this)">Broadcast</button>
    </div>
   <div id="notif-actions" style="display:flex;justify-content:flex-end;gap:8px;margin:12px 0">
      @if(auth('admin')->user()->hasPermission('Notifications', 'notifications.action'))
    <button class="btn btn-success btn-sm" onclick="markAllNotificationsRead()">
        <i class="ri-check-double-line"></i> Mark All Read
    </button>

    <button class="btn btn-danger btn-sm" onclick="deleteAllNotifications()">
        <i class="ri-delete-bin-6-line"></i> Delete All
    </button>
    @endif
</div>
    <div id="notif-tab-inbox" class="tab-pane active">
        <div style="display: flex; flex-direction: column; gap: 8px" id="admin-notif-list"></div>
    </div>

</section>
<script>
    window.NOTIFICATIONS_DATA = @json($notifications->values());
   
</script>
@endsection
