<header class="topbar">
    <div style="display:flex;align-items:center;gap:12px">
        <button id="mobile-menu-btn" onclick="openMobile()" style="display:none;width:36px;height:36px;border-radius:10px;background:none;border:none;color:#94a3b8;cursor:pointer;font-size:1.1rem;align-items:center;justify-content:center;transition:all .2s" class="md-show"><i class="ri-menu-line"></i></button>
        <h1 id="page-title" class="font-jakarta" style="font-weight:700;font-size:1.05rem;color:#f1f5f9"></h1>
    </div>
    <div style="display:flex;align-items:center;gap:8px">
        <button onclick="window.location.href='index'" 
            class="btn btn-icon btn-ghost" 
            style="position:relative" 
            title="Help">
            <i class="ri-global-line" style="font-size:1rem"></i>
        </button>
        
    <!-- Help -->
        <button onclick="window.location.href='user-help'" 
                class="btn btn-icon btn-ghost" 
                style="position:relative" 
                title="Help">
            <i class="ri-question-line" style="font-size:1rem"></i>
        </button>

        <!-- Feedback -->
        <button onclick="window.location.href='user-feedback'" 
            class="btn btn-icon btn-ghost" 
            style="position:relative" 
            title="Feedback">
            <i class="ri-feedback-line" style="font-size:1rem"></i>
        </button>

        <!-- Reminder Modal Button -->
        <button class="btn btn-primary btn-sm mobile-hide-xs" onclick="openReminderModal()" style="padding:7px 14px">
            <i class="ri-add-line"></i>
            <span class="mobile-hide-sm">New Reminder</span>
        </button>

        <!-- Theme Button -->
        <button onclick="window.location.href='user-notification'" class="btn btn-icon btn-ghost" style="position:relative" title="Notifications">
            <i class="ri-notification-3-line" style="font-size:1rem"></i>
            <span id="notif-dot" style="position:absolute;top:6px;right:6px;width:8px;height:8px;background:#f43f5e;border-radius:50%;border:2px solid #090918"></span>
        </button>
        
        <button onclick="toggleTheme()" class="theme-pill" title="Toggle theme">
            <div class="theme-dot"><i id="theme-icon" class="ri-moon-line" style="font-size:.55rem"></i></div>
        </button>
    </div>
    
</header>