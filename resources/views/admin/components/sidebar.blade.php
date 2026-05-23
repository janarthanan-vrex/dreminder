<aside class="sidebar" id="sidebar">
    <div class="logo-txt lbl logoo" style="display:flex;align-items:center;gap:8px;overflow:hidden;white-space:nowrap">
        <img style="width: stretch; padding: 15px 26px 0px 0px;" src="https://www.vishakarex.in/assets/img/projects/d-remind.png" alt="">
    </div>
    <nav class="sb-nav">
        
        <div class="sb-section">Overview</div>
        <a class="nav-item" href="admin-dashboard"><i class="ri-dashboard-line"></i><span class="nav-lbl">Dashboard</span></a>
        <a class="nav-item" href="admin-analytics"><i class="ri-bar-chart-2-line"></i><span class="nav-lbl">Analytics</span></a>

        <div class="sb-section">Management</div>
        <a class="nav-item" href="admin-users"><i class="ri-group-line"></i><span class="nav-lbl">Users</span><span class="nav-badge">3</span></a>
        <a class="nav-item" href="admin-reminders"><i class="ri-alarm-line"></i><span class="nav-lbl">Reminders</span></a>
        <a class="nav-item" href="admin-calendar"><i class="ri-calendar-line"></i><span class="nav-lbl">Calendar</span></a>
        <a class="nav-item" href="admin-transactions"><i class="ri-bank-card-line"></i><span class="nav-lbl">Transactions</span></a>
        <a class="nav-item" href="admin-category"><i class="ri-folder-3-line"></i><span class="nav-lbl">Categories</span></a>
        <a class="nav-item" href="admin-notifications"><i class="ri-notification-3-line"></i><span class="nav-lbl">Notifications</span><span class="nav-badge">5</span></a>

        <div class="sb-section">Pricing</div>
        <a class="nav-item" href="admin-pricing"><i class="ri-vip-crown-line"></i><span class="nav-lbl">Pricing</span></a>

        <div class="sb-section">Content</div>
        <a class="nav-item" href="admin-blog"><i class="ri-article-line"></i><span class="nav-lbl">Blog</span></a>

        <div class="sb-section">Team</div>
        <a class="nav-item" href="admin-staff"><i class="ri-team-line"></i><span class="nav-lbl">Staff</span></a>
        <a class="nav-item" href="admin-roles"><i class="ri-key-2-line"></i><span class="nav-lbl">Roles & Permissions</span></a>

        <div class="sb-section">CMS</div>
        <a class="nav-item" href="admin-cms-home"><i class="ri-home-4-line"></i><span class="nav-lbl">Home</span></a>
        <a class="nav-item" href="admin-cms-about"><i class="ri-information-line"></i><span class="nav-lbl">About</span></a>
        <a class="nav-item" href="admin-cms-faq"><i class="ri-question-line"></i><span class="nav-lbl">FAQ</span></a>
        <a class="nav-item" href="admin-cms-contact"><i class="ri-contacts-line"></i><span class="nav-lbl">Contact</span></a>
        <a class="nav-item" href="admin-cms-terms"><i class="ri-file-list-3-line"></i><span class="nav-lbl">Terms & Conditions</span></a>
        <a class="nav-item" href="admin-cms-privacy"><i class="ri-shield-user-line"></i><span class="nav-lbl">Privacy Policy</span></a>

        <div class="sb-section">System</div>
        <a class="nav-item" href="admin-settings"><i class="ri-settings-3-line"></i><span class="nav-lbl">Settings</span></a>
        <a class="nav-item" href="admin-audit"><i class="ri-shield-check-line"></i><span class="nav-lbl">Audit Log</span></a>
        <a class="nav-item" href="admin-feedback"><i class="ri-feedback-line"></i><span class="nav-lbl">Feedback</span></a>

<form id="logoutForm" action="{{ route('admin.logout') }}" method="POST">
    @csrf
</form>

<a class="nav-item" style="color:var(--red)" onclick="handleLogout()">
    <i class="ri-logout-box-r-line"></i>
    <span class="nav-lbl">Logout</span>
</a>

<script>
    function handleLogout() {
        document.getElementById('logoutForm').submit();
    }
</script>

    </nav>
    <div class="sb-user">
        <a class="sb-user-row" href="admin-profile">
            <div class="sb-avatar">SA</div>
            <div class="sb-user-info">
                <div class="sb-user-name">Super Admin</div>
                <div class="sb-user-role">System Administrator</div>
            </div>
</a>
    </div>
</aside>
<script>
    function setActiveNav() {
      const currentPage = window.location.pathname.split('/').pop().split('.')[0];
      const navItems = document.querySelectorAll('.nav-item');
      
      navItems.forEach(item => {
        item.classList.remove('active');
        
        const href = item.getAttribute('href');
        
        if (href && (href === currentPage || href.includes(currentPage))) {
          item.classList.add('active');
        }
      });
    }
    
    document.addEventListener('DOMContentLoaded', setActiveNav);
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const navItems = document.querySelectorAll('.nav-item');
    const container = document.querySelector('.sb-nav');

    const currentPage = window.location.pathname.split('/').pop();

    let activeItem = null;

    navItems.forEach(item => {
        item.classList.remove('active');

        const href = item.getAttribute('href');

        if (href && currentPage.includes(href)) {
            item.classList.add('active');
            activeItem = item;
        }

        // click scroll
        item.addEventListener('click', function () {
            setTimeout(() => centerItem(this), 50);
        });
    });

    // initial load scroll
    if (activeItem) {
        setTimeout(() => centerItem(activeItem), 100);
    }

    function centerItem(el) {
        const containerRect = container.getBoundingClientRect();
        const itemRect = el.getBoundingClientRect();

        const scrollOffset = itemRect.top - containerRect.top;

        const center = scrollOffset - (container.clientHeight / 2) + (el.clientHeight / 2);

        container.scrollBy({
            top: center,
            behavior: 'smooth'
        });
    }

});
</script>