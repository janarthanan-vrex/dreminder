<div class="topbar">
    <div class="topbar-left">
        <button class="tb-btn mobile-menu-btn" onclick="openMobile()">
            <i class="ri-menu-line"></i>
        </button>
        <button class="tb-btn hide-mobile" onclick="toggleSidebar()">
            <i class="ri-layout-left-line"></i>
        </button>
        <div>
            <div class="tb-title" id="page-title">Dashboard</div>
            <div class="tb-breadcrumb">Admin Panel · D-Remind</div>
        </div>
    </div>
    <div class="topbar-right">
        <a class="tb-btn notif-btn" href="index">
            <i class="ri-global-line"></i><span class="notif-dot"></span>
        </a>
        <div class="search-box hide-mobile" style="width: 200px">
            <i class="ri-search-line" style="color: var(--text3); font-size: 0.85rem"></i>
            <input placeholder="Quick search…" />
        </div>
        <div class="tb-divider hide-mobile"></div>
        <a class="tb-btn notif-btn" href="admin-notifications">
            <i class="ri-notification-3-line"></i><span class="notif-dot"></span>
        </a>

        <button class="tb-btn" onclick="toggleTheme()">
            <i class="ri-moon-line" id="theme-icon"></i>
        </button>
        <a class="tb-btn" href="admin-settings">
            <i class="ri-user-settings-line"></i>
        </a>
    </div>
</div>