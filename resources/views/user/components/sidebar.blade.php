
<style>
    @media (max-width:768px) {
        .mob-toggle{display: none !important;}
        .mob-close{display:block !important;}
    }
    .mob-close{display:none;}
</style>

<aside id="sidebar" class="sidebar flex flex-col">
    <!-- Logo -->
    <div style="display:flex;align-items:center;gap:10px;padding:16px 12px;border-bottom:1px solid rgba(255,255,255,.06);flex-shrink:0;align-self: center;">
        <div class="logo-txt lbl logoo" style="display:flex;align-items:center;gap:8px;overflow:hidden;white-space:nowrap">
            <img src="https://www.vishakarex.in/assets/img/projects/d-remind.png" alt="">
        </div>
        <button onclick="toggleSidebar()" class="mob-toggle" style="margin-left:auto;flex-shrink:0;width:28px;height:28px;border-radius:8px;display:flex;align-items:center;justify-content:center;background:none;border:none;color:#64748b;cursor:pointer;transition:all .2s" onmouseover="this.style.color='#a78bfa'" onmouseout="this.style.color='#64748b'">
            <i class="ri-menu-line" style="font-size:.9rem"></i>
        </button>
        <button onclick="mobileClose()" class="mob-close" style="margin-left:auto;flex-shrink:0;width:28px;height:28px;border-radius:8px;align-items:center;justify-content:center;background:none;border:none;color:#64748b;cursor:pointer;transition:all .2s" onmouseover="this.style.color='#a78bfa'" onmouseout="this.style.color='#64748b'">
            <i class="ri-close-line" style="font-size:.9rem"></i>
        </button>
    </div>

    <!-- Nav -->
    <nav style="flex:1;overflow-y:auto;overflow-x:hidden;padding:8px 8px">
        <div class="section-lbl"><span>Main</span></div>
        <a class="nav-link" href="user-dashboard"><i class="ri-dashboard-3-line" style="font-size:1.05rem;flex-shrink:0"></i><span class="lbl">Dashboard</span></a>
        <a class="nav-link" href="user-analytics"><i class="ri-bar-chart-box-line" style="font-size:1.05rem;flex-shrink:0"></i><span class="lbl">Analytics</span></a>
        <div class="section-lbl" style="margin-top:4px"><span>Reminders</span></div>
        <a class="nav-link" href="user-reminders"><i class="ri-alarm-line" style="font-size:1.05rem;flex-shrink:0"></i><span class="lbl">My Reminders</span></a>
        <!--<a class="nav-link" href="user-create-reminder"><i class="ri-add-circle-line" style="font-size:1.05rem;flex-shrink:0"></i><span class="lbl">Create Reminder</span></a>-->
        <a class="nav-link" href="user-calendar"><i class="ri-calendar-event-line" style="font-size:1.05rem;flex-shrink:0"></i><span class="lbl">Calendar View</span></a>
        <a class="nav-link" href="user-category"><i class="ri-folder-3-line" style="font-size:1.05rem;flex-shrink:0"></i><span class="lbl">Category</span></a>
        <!-- <a class="nav-link" href="user-reminder-history"><i class="ri-history-line" style="font-size:1.05rem;flex-shrink:0"></i><span class="lbl">Reminder History</span></a> -->
        <!-- <a class="nav-link" href="user-templates"><i class="ri-file-list-3-line" style="font-size:1.05rem;flex-shrink:0"></i><span class="lbl">Templates</span></a> -->
        <!-- <a class="nav-link" href="user-shared-reminders"><i class="ri-share-line" style="font-size:1.05rem;flex-shrink:0"></i><span class="lbl">Shared Reminders</span></a> -->
        <div class="section-lbl" style="margin-top:4px"><span>Account</span></div>
        <a class="nav-link" href="user-profile"><i class="ri-user-3-line" style="font-size:1.05rem;flex-shrink:0"></i><span class="lbl">Settings</span></a>
        <a class="nav-link" href="user-notification"><i class="ri-notification-3-line" style="font-size:1.05rem;flex-shrink:0"></i><span class="lbl" style="flex:1">Notifications</span><span class="nav-notif-badge badge badge-red" id="notif-count" style="font-size:.58rem">3</span></a>
        <a class="nav-link" href="user-membership"><i class="ri-vip-crown-line" style="font-size:1.05rem;flex-shrink:0"></i><span class="lbl">Membership</span></a>
        <!-- <a class="nav-link" href="user-transaction"><i class="ri-exchange-dollar-line" style="font-size:1.05rem;flex-shrink:0"></i><span class="lbl">Transaction</span></a> -->
        <a class="nav-link" href="user-transactions"><i class="ri-shopping-bag-3-line" style="font-size:1.05rem;flex-shrink:0"></i><span class="lbl">Transactions</span></a>
        <!-- <div class="section-lbl" style="margin-top:4px"><span>Support</span></div>
        <a class="nav-link" href="user-help"><i class="ri-question-line" style="font-size:1.05rem;flex-shrink:0"></i><span class="lbl">Help & Support</span></a>
        <a class="nav-link" href="user-feedback"><i class="ri-feedback-line" style="font-size:1.05rem;flex-shrink:0"></i><span class="lbl">Feedback</span></a> -->
        <!-- <div class="section-lbl" style="margin-top:4px"><span>Insights</span></div> -->
    </nav>

    <!-- User -->
    <div style="padding:10px 8px;border-top:1px solid rgba(255,255,255,.06);flex-shrink:0">
        <div class="user-row" style="display:flex;align-items:center;gap:9px;overflow:hidden">
            <div id="av-box" style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#7c3aed,#0d9488);display:flex;align-items:center;justify-content:center;color:#fff;font-size:.8rem;font-weight:700;flex-shrink:0;cursor:pointer;overflow:hidden" onclick="go('profile')">JM</div>
            <div class="user-meta lbl" style="flex:1;min-width:0;overflow:hidden">
                <div style="font-size:.82rem;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis" id="user-name">{{$user->first_name ?? ''}} {{$user->last_name ?? ''}}</div>
                <div style="font-size:.7rem;color:#64748b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{$user->email}}</div>
            </div>
            <button class="logout-btn btn btn-xs btn-ghost" onclick="handleLogout()" style="flex-shrink:0;padding:5px 7px" title="Logout"><i class="ri-logout-box-r-line"></i></button>
        </div>
    </div>
</aside>


<script>
    var logoutUrl = "{{ route('logout') }}";
    var loginUrl = "{{ route('loginpage') }}";
    var csrfToken = "{{ csrf_token() }}";
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const links = document.querySelectorAll(".nav-link");
    const currentUrl = window.location.href;

    links.forEach(link => {
        const linkUrl = link.href;

        // Exact match OR partial match (for dynamic routes)
        if (currentUrl === linkUrl || currentUrl.startsWith(linkUrl)) {
            link.classList.add("active");
        }
    });

    
});
</script>