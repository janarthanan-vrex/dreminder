<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D-Remind — Winngoo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <link href="{{ asset('assets/css/user.css') }}" rel="stylesheet">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        jakarta: ['Plus Jakarta Sans', 'sans-serif'],
                        dm: ['DM Sans', 'sans-serif'],
                        mono: ['DM Mono', 'monospace']
                    },
                    colors: {
                        brand: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            200: '#ddd6fe',
                            300: '#c4b5fd',
                            400: '#a78bfa',
                            500: '#8b5cf6',
                            600: '#7c3aed',
                            700: '#6d28d9',
                            800: '#5b21b6',
                            900: '#4c1d95'
                        },
                        teal: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            200: '#99f6e4',
                            300: '#5eead4',
                            400: '#2dd4bf',
                            500: '#14b8a6',
                            600: '#0d9488',
                            700: '#0f766e',
                            800: '#115e59',
                            900: '#134e4a'
                        },
                    },
                }
            }
        }
    </script>
</head>

<body>
    <div id="toast-area"></div>

    <!-- Mobile Sidebar Overlay -->
    <div id="sb-overlay" onclick="closeMobile()"></div>

    <div style="display:flex;height:100vh;overflow:hidden">

        <!-- ========== SIDEBAR ========== -->
        <aside id="sidebar" class="sidebar flex flex-col">
            <!-- Logo -->
            <div style="display:flex;align-items:center;gap:10px;padding:16px 12px;border-bottom:1px solid rgba(255,255,255,.06);flex-shrink:0;align-self: center;">
                <div class="logo-txt lbl logoo" style="display:flex;align-items:center;gap:8px;overflow:hidden;white-space:nowrap">
                    <img src="https://www.vishakarex.in/assets/img/projects/d-remind.png" alt="">
                </div>
                <button onclick="toggleSidebar()" style="margin-left:auto;flex-shrink:0;width:28px;height:28px;border-radius:8px;display:flex;align-items:center;justify-content:center;background:none;border:none;color:#64748b;cursor:pointer;transition:all .2s" onmouseover="this.style.color='#a78bfa'" onmouseout="this.style.color='#64748b'">
                    <i class="ri-menu-line" style="font-size:.9rem"></i>
                </button>
            </div>

            <!-- Nav -->
            <nav style="flex:1;overflow-y:auto;overflow-x:hidden;padding:8px 8px">
                <div class="section-lbl"><span>Main</span></div>
                <a class="nav-link" onclick="go('dashboard')"><i class="ri-dashboard-3-line" style="font-size:1.05rem;flex-shrink:0"></i><span class="lbl">Dashboard</span></a>
                <a class="nav-link" onclick="go('reminders')"><i class="ri-alarm-line" style="font-size:1.05rem;flex-shrink:0"></i><span class="lbl">My Reminders</span></a>
                <a class="nav-link" onclick="openReminderModal()"><i class="ri-add-circle-line" style="font-size:1.05rem;flex-shrink:0"></i><span class="lbl">Create Reminder</span></a>
                <a class="nav-link" onclick="go('calendar')"><i class="ri-calendar-event-line" style="font-size:1.05rem;flex-shrink:0"></i><span class="lbl">Calendar View</span></a>
                <a class="nav-link" onclick="go('templates')"><i class="ri-file-list-3-line" style="font-size:1.05rem;flex-shrink:0"></i><span class="lbl">Templates</span></a>
                <a class="nav-link" onclick="go('shared')"><i class="ri-share-line" style="font-size:1.05rem;flex-shrink:0"></i><span class="lbl">Shared Reminders</span></a>
                <div class="section-lbl" style="margin-top:4px"><span>Account</span></div>
                <a class="nav-link" onclick="go('profile')"><i class="ri-user-3-line" style="font-size:1.05rem;flex-shrink:0"></i><span class="lbl">Profile</span></a>
                <a class="nav-link" onclick="go('notifications')"><i class="ri-notification-3-line" style="font-size:1.05rem;flex-shrink:0"></i><span class="lbl" style="flex:1">Notifications</span><span class="nav-notif-badge badge badge-red" id="notif-count" style="font-size:.58rem">3</span></a>
                <a class="nav-link" onclick="go('membership')"><i class="ri-vip-crown-line" style="font-size:1.05rem;flex-shrink:0"></i><span class="lbl">Membership</span></a>
                <div class="section-lbl" style="margin-top:4px"><span>Insights</span></div>
                <a class="nav-link" onclick="go('categories')"><i class="ri-folder-3-line" style="font-size:1.05rem;flex-shrink:0"></i><span class="lbl">Categories</span></a>
                <a class="nav-link" onclick="go('analytics')"><i class="ri-bar-chart-box-line" style="font-size:1.05rem;flex-shrink:0"></i><span class="lbl">Analytics</span></a>
                <div class="section-lbl" style="margin-top:4px"><span>Support</span></div>
                <a class="nav-link" onclick="go('help')"><i class="ri-question-line" style="font-size:1.05rem;flex-shrink:0"></i><span class="lbl">Help & Support</span></a>
                <a class="nav-link" onclick="go('feedback')"><i class="ri-feedback-line" style="font-size:1.05rem;flex-shrink:0"></i><span class="lbl">Feedback</span></a>
            </nav>

            <!-- User -->
            <div style="padding:10px 8px;border-top:1px solid rgba(255,255,255,.06);flex-shrink:0">
                <div class="user-row" style="display:flex;align-items:center;gap:9px;overflow:hidden">
                    <div id="av-box" style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#7c3aed,#0d9488);display:flex;align-items:center;justify-content:center;color:#fff;font-size:.8rem;font-weight:700;flex-shrink:0;cursor:pointer;overflow:hidden" onclick="go('profile')">JM</div>
                    <div class="user-meta lbl" style="flex:1;min-width:0;overflow:hidden">
                        <div style="font-size:.82rem;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis" id="user-name-sb">Kishore Rex</div>
                        <div style="font-size:.7rem;color:#64748b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">Kishore@example.com</div>
                    </div>
                    <button class="logout-btn btn btn-xs btn-ghost" onclick="handleLogout()" style="flex-shrink:0;padding:5px 7px" title="Logout"><i class="ri-logout-box-r-line"></i></button>
                </div>
            </div>
        </aside>

        <!-- ========== MAIN ========== -->
        <div style="flex:1;display:flex;flex-direction:column;overflow:hidden;min-width:0">

            <!-- TOPBAR -->
            <header class="topbar">
                <div style="display:flex;align-items:center;gap:12px">
                    <button id="mobile-menu-btn" onclick="openMobile()" style="display:none;width:36px;height:36px;border-radius:10px;background:none;border:none;color:#94a3b8;cursor:pointer;font-size:1.1rem;align-items:center;justify-content:center;transition:all .2s" class="md-show"><i class="ri-menu-line"></i></button>
                    <h1 id="page-title" class="font-jakarta" style="font-weight:700;font-size:1.05rem;color:#f1f5f9"></h1>
                </div>
                <div style="display:flex;align-items:center;gap:8px">
                    <button class="btn btn-primary btn-sm mobile-hide-xs" onclick="openReminderModal()" style="padding:7px 14px"><i class="ri-add-line"></i><span class="mobile-hide-sm">New Reminder</span></button>
                    <button onclick="go('notifications')" class="btn btn-icon btn-ghost" style="position:relative" title="Notifications">
                        <i class="ri-notification-3-line" style="font-size:1rem"></i>
                        <span id="notif-dot" style="position:absolute;top:6px;right:6px;width:8px;height:8px;background:#f43f5e;border-radius:50%;border:2px solid #090918"></span>
                    </button>
                    <button onclick="toggleTheme()" class="theme-pill" title="Toggle theme">
                        <div class="theme-dot"><i id="theme-icon" class="ri-moon-line" style="font-size:.55rem"></i></div>
                    </button>
                </div>
            </header>

            <!-- CONTENT -->
            <main id="main" style="flex:1;overflow-y:auto;padding:24px;overflow-x:hidden">

                <!-- ===== DASHBOARD ===== -->
                <section id="page-dashboard" class="page">
                    <div style="margin-bottom:24px">
                        <h2 class="font-jakarta" style="font-size:1.5rem;font-weight:800;color:#f1f5f9"><span id="greeting">Good morning</span>, Kishore! <span class="pulse-soft">☀️</span></h2>
                        <p id="dash-summary" style="font-size:.84rem;color:#64748b;margin-top:4px"></p>
                    </div>
                    <div class="g4" style="margin-bottom:24px">
                        <div class="stat-card">
                            <div style="width:40px;height:40px;border-radius:11px;background:rgba(124,58,237,.15);display:flex;align-items:center;justify-content:center;margin-bottom:12px"><i class="ri-alarm-line" style="color:#a78bfa;font-size:1.1rem"></i></div>
                            <div class="font-jakarta" style="font-size:1.6rem;font-weight:800;color:#f1f5f9" id="s-active">0</div>
                            <div style="font-size:.73rem;color:#64748b;margin-top:3px;font-weight:600">Active Reminders</div>
                        </div>
                        <div class="stat-card">
                            <div style="width:40px;height:40px;border-radius:11px;background:rgba(245,158,11,.12);display:flex;align-items:center;justify-content:center;margin-bottom:12px"><i class="ri-time-line" style="color:#f59e0b;font-size:1.1rem"></i></div>
                            <div class="font-jakarta" style="font-size:1.6rem;font-weight:800;color:#f59e0b" id="s-week">0</div>
                            <div style="font-size:.73rem;color:#64748b;margin-top:3px;font-weight:600">Due This Week</div>
                        </div>
                        <div class="stat-card">
                            <div style="width:40px;height:40px;border-radius:11px;background:rgba(16,185,129,.12);display:flex;align-items:center;justify-content:center;margin-bottom:12px"><i class="ri-check-double-line" style="color:#10b981;font-size:1.1rem"></i></div>
                            <div class="font-jakarta" style="font-size:1.6rem;font-weight:800;color:#10b981" id="s-done">0</div>
                            <div style="font-size:.73rem;color:#64748b;margin-top:3px;font-weight:600">Completed</div>
                        </div>
                        <div class="stat-card">
                            <div style="width:40px;height:40px;border-radius:11px;background:rgba(244,63,94,.12);display:flex;align-items:center;justify-content:center;margin-bottom:12px"><i class="ri-error-warning-line" style="color:#f43f5e;font-size:1.1rem"></i></div>
                            <div class="font-jakarta" style="font-size:1.6rem;font-weight:800;color:#f43f5e" id="s-over">0</div>
                            <div style="font-size:.73rem;color:#64748b;margin-top:3px;font-weight:600">Overdue</div>
                        </div>
                    </div>
                    <div class="g2" style="margin-bottom:24px">
                        <div class="card" style="padding:20px">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
                                <h3 class="font-jakarta" style="font-weight:700;font-size:.93rem;color:#f1f5f9">Upcoming Reminders</h3>
                                <button class="btn btn-ghost btn-sm" onclick="go('reminders')">View All <i class="ri-arrow-right-line"></i></button>
                            </div>
                            <div id="dash-list" style="display:flex;flex-direction:column;gap:8px"></div>
                        </div>
                        <div class="card" style="padding:20px">
                            <h3 class="font-jakarta" style="font-weight:700;font-size:.93rem;color:#f1f5f9;margin-bottom:16px">Activity — Last 30 Days</h3>
                            <div style="position:relative;height:220px"><canvas id="dash-chart"></canvas></div>
                        </div>
                    </div>
                    <div class="card" style="padding:20px">
                        <h3 class="font-jakarta" style="font-weight:700;font-size:.93rem;color:#f1f5f9;margin-bottom:16px">Quick Actions</h3>
                        <div style="display:flex;flex-wrap:wrap;gap:10px">
                            <button class="btn btn-primary" onclick="openReminderModal()"><i class="ri-add-circle-line"></i> Create Reminder</button>
                            <button class="btn btn-teal" onclick="go('calendar')"><i class="ri-calendar-line"></i> View Calendar</button>
                            <button class="btn btn-ghost" onclick="go('templates')"><i class="ri-file-copy-line"></i> Use Template</button>
                            <button class="btn btn-ghost" onclick="go('analytics')"><i class="ri-bar-chart-line"></i> Analytics</button>
                            <button class="btn btn-ghost" onclick="go('shared')"><i class="ri-share-line"></i> Shared</button>
                            <button class="btn btn-ghost" onclick="go('categories')"><i class="ri-folder-line"></i> Categories</button>
                        </div>
                    </div>
                </section>

                <!-- ===== MY REMINDERS ===== -->
                <section id="page-reminders" class="page">
                    <div style="margin-bottom:16px">
                        <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800;color:#f1f5f9">All Reminders</h2>
                        <p id="rem-count-label" style="font-size:.82rem;color:#64748b;margin-top:3px"></p>
                    </div>
                    <div style="display:flex;flex-wrap:wrap;gap:10px;margin-bottom:12px">
                        <div class="search-box" style="flex:1;min-width:200px"><i class="ri-search-line" style="color:#64748b;font-size:.9rem"></i><input id="rem-search" placeholder="Search reminders…" oninput="loadReminders()" style="font-size:.85rem;color:inherit"></div>
                        <select class="inp" style="width:auto;min-width:155px" id="rem-cat" onchange="loadReminders()">
                            <option value="all">All Categories</option>
                        </select>
                        <select class="inp" style="width:auto;min-width:140px" id="rem-status" onchange="loadReminders()">
                            <option value="all">All Status</option>
                            <option value="active">Active</option>
                            <option value="upcoming">Upcoming (30d)</option>
                            <option value="expired">Overdue</option>
                            <option value="completed">Completed</option>
                        </select>
                        <select class="inp" style="width:auto;min-width:160px" id="rem-sort" onchange="loadReminders()">
                            <option value="date-asc">Date ↑</option>
                            <option value="date-desc">Date ↓</option>
                            <option value="title-asc">Title A–Z</option>
                            <option value="created-desc">Recently Added</option>
                        </select>
                        <button class="btn btn-ghost btn-sm" onclick="resetFilters()" title="Reset filters"><i class="ri-refresh-line"></i></button>
                    </div>
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
                        <div style="display:flex;gap:6px">
                            <button class="view-btn active" id="vl" onclick="setView('list')"><i class="ri-list-check"></i> List</button>
                            <button class="view-btn" id="vg" onclick="setView('grid')"><i class="ri-grid-line"></i> Grid</button>
                        </div>
                        <span style="font-size:.75rem;color:#64748b;font-weight:600"><span id="rem-display-count">0</span> reminders</span>
                    </div>
                    <div id="rem-list" style="display:flex;flex-direction:column;gap:8px"></div>
                    <div id="rem-grid" style="display:none;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px"></div>
                    <div id="rem-empty" style="display:none;text-align:center;padding:60px 0">
                        <div style="font-size:3.5rem;color:rgba(255,255,255,.1);margin-bottom:10px"><i class="ri-inbox-2-line"></i></div>
                        <div class="font-jakarta" style="font-weight:700;font-size:1.05rem;color:#94a3b8;margin-bottom:6px">No Reminders Found</div>
                        <div style="font-size:.83rem;color:#64748b;margin-bottom:14px">Try adjusting your filters or create a new reminder</div>
                        <button class="btn btn-primary" onclick="openReminderModal()"><i class="ri-add-line"></i> Create Reminder</button>
                    </div>
                </section>

                <!-- ===== CREATE REMINDER ===== -->
                <section id="page-create" class="page">
                    <div style="max-width:720px;margin:0 auto">
                        <div style="margin-bottom:16px">
                            <h2 class="font-jakarta" id="create-title" style="font-size:1.3rem;font-weight:800;color:#f1f5f9">Create New Reminder</h2>
                            <p style="font-size:.82rem;color:#64748b;margin-top:3px">Fill in the details to set your reminder</p>
                        </div>
                        <div class="card" style="padding:24px;margin-bottom:16px">
                            <form id="rem-form" onsubmit="submitReminder(event)">
                                <div style="margin-bottom:18px">
                                    <label style="display:block;font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:7px">Title <span style="color:#f43f5e">*</span></label>
                                    <input class="inp" id="r-title" placeholder="e.g. Car Insurance Renewal" maxlength="100">
                                    <div style="font-size:.72rem;color:#475569;margin-top:4px">3–100 characters</div>
                                </div>
                                <div class="g2" style="margin-bottom:18px">
                                    <div>
                                        <label style="display:block;font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:7px">Category <span style="color:#f43f5e">*</span></label>
                                        <select class="inp" id="r-cat" onchange="updateSubs()">
                                            <option value="">Select category…</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label style="display:block;font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:7px">Subcategory <span style="color:#f43f5e">*</span></label>
                                        <select class="inp" id="r-sub" disabled>
                                            <option value="">Select category first…</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="g2" style="margin-bottom:18px">
                                    <div>
                                        <label style="display:block;font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:7px">Date <span style="color:#f43f5e">*</span></label>
                                        <input class="inp" type="date" id="r-date">
                                    </div>
                                    <div>
                                        <label style="display:block;font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:7px">Time <span style="color:#f43f5e">*</span></label>
                                        <input class="inp" type="time" id="r-time" value="09:00">
                                    </div>
                                </div>
                                <div style="margin-bottom:18px">
                                    <label style="display:block;font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:7px">Description <span style="color:#64748b;font-weight:400;text-transform:none">(Optional · max 200 chars)</span></label>
                                    <textarea class="inp" id="r-desc" rows="3" maxlength="200" placeholder="Brief notes…" oninput="document.getElementById('desc-len').textContent=this.value.length" style="resize:vertical"></textarea>
                                    <div style="font-size:.72rem;color:#475569;margin-top:4px"><span id="desc-len">0</span>/200</div>
                                </div>
                                <div id="opt-fields" style="display:none">
                                    <div class="g2" style="margin-bottom:18px">
                                        <div>
                                            <label style="display:block;font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:7px">Provider</label>
                                            <input class="inp" id="r-provider" placeholder="e.g. AA Insurance" maxlength="50">
                                        </div>
                                        <div>
                                            <label style="display:block;font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:7px">Cost (£)</label>
                                            <input class="inp" type="number" id="r-cost" placeholder="0.00" min="0" step="0.01">
                                        </div>
                                    </div>
                                    <div style="margin-bottom:18px">
                                        <label style="display:block;font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:7px">Payment Frequency</label>
                                        <select class="inp" id="r-freq">
                                            <option value="">—</option>
                                            <option>Monthly</option>
                                            <option>Quarterly</option>
                                            <option>Half-Yearly</option>
                                            <option>Annually</option>
                                        </select>
                                    </div>
                                </div>
                                <div style="display:flex;gap:10px;justify-content:flex-end;padding-top:16px;border-top:1px solid rgba(255,255,255,.06)">
                                    <button type="button" class="btn btn-ghost" onclick="cancelCreate()"><i class="ri-close-line"></i> Cancel</button>
                                    <button type="submit" class="btn btn-primary" id="create-btn"><i class="ri-check-line"></i> <span id="create-btn-txt">Create Reminder</span></button>
                                </div>
                            </form>
                        </div>
                        <div class="card" style="padding:18px">
                            <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:10px"><i class="ri-lightbulb-line" style="color:#f59e0b;margin-right:4px"></i> Quick Tips</h3>
                            <div style="display:flex;flex-direction:column;gap:8px">
                                <div style="display:flex;gap:8px;font-size:.83rem;color:#64748b"><i class="ri-checkbox-circle-line" style="color:#10b981;margin-top:2px;flex-shrink:0"></i>Use clear, descriptive titles to identify reminders later</div>
                                <div style="display:flex;gap:8px;font-size:.83rem;color:#64748b"><i class="ri-checkbox-circle-line" style="color:#10b981;margin-top:2px;flex-shrink:0"></i>Set reminders at least 30 days in advance for best coverage</div>
                                <div style="display:flex;gap:8px;font-size:.83rem;color:#64748b"><i class="ri-checkbox-circle-line" style="color:#10b981;margin-top:2px;flex-shrink:0"></i>Add provider and cost details to track expenses over time</div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- ===== CALENDAR ===== -->
                <section id="page-calendar" class="page">
                    <div class="card" style="padding:14px;margin-bottom:16px;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:10px">
                        <div style="display:flex;gap:8px">
                            <button class="btn btn-ghost btn-sm" onclick="prevMonth()"><i class="ri-arrow-left-s-line"></i> Prev</button>
                            <button class="btn btn-ghost btn-sm" onclick="goToday()"><i class="ri-calendar-today-line"></i> Today</button>
                            <button class="btn btn-ghost btn-sm" onclick="nextMonth()">Next <i class="ri-arrow-right-s-line"></i></button>
                        </div>
                        <div id="cal-label" class="font-jakarta" style="font-weight:700;font-size:1rem;color:#f1f5f9"></div>
                        <button class="btn btn-ghost btn-sm" onclick="toast('Calendar exported!','success')"><i class="ri-download-2-line"></i> Export</button>
                    </div>
                    <div class="g2">
                        <div class="card" style="padding:16px;grid-column:1/-1">
                            <div style="display:grid;grid-template-columns:repeat(7,1fr);gap:4px;margin-bottom:6px">
                                <div style="text-align:center;font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;padding:6px 0">Sun</div>
                                <div style="text-align:center;font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;padding:6px 0">Mon</div>
                                <div style="text-align:center;font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;padding:6px 0">Tue</div>
                                <div style="text-align:center;font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;padding:6px 0">Wed</div>
                                <div style="text-align:center;font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;padding:6px 0">Thu</div>
                                <div style="text-align:center;font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;padding:6px 0">Fri</div>
                                <div style="text-align:center;font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;padding:6px 0">Sat</div>
                            </div>
                            <div id="cal-grid" style="display:grid;grid-template-columns:repeat(7,1fr);gap:4px"></div>
                        </div>
                        <div class="card" style="padding:18px">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
                                <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9">Events This Month</h3>
                                <span class="badge badge-purple" id="month-ev-cnt">0 Events</span>
                            </div>
                            <div id="month-events" style="display:flex;flex-direction:column;gap:6px;max-height:320px;overflow-y:auto"></div>
                        </div>
                        <div class="card" style="padding:18px">
                            <h3 class="font-jakarta" id="sel-day-title" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:14px">Select a day</h3>
                            <div id="sel-day-events">
                                <div style="text-align:center;padding:40px 0;color:#64748b"><i class="ri-calendar-line" style="font-size:2rem;display:block;margin-bottom:8px;opacity:.4"></i>
                                    <p style="font-size:.84rem">Click on a day to view events</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- ===== TEMPLATES ===== -->
                <section id="page-templates" class="page">
                    <div style="margin-bottom:16px">
                        <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800;color:#f1f5f9">Quick Start Templates</h2>
                        <p style="font-size:.82rem;color:#64748b;margin-top:3px">Create reminders faster with pre-configured templates</p>
                    </div>
                    <div style="display:flex;flex-wrap:wrap;gap:10px;margin-bottom:20px">
                        <div class="search-box" style="flex:1;min-width:200px"><i class="ri-search-line" style="color:#64748b;font-size:.9rem"></i><input id="tmpl-search" placeholder="Search templates…" oninput="filterTemplates()" style="font-size:.85rem;color:inherit"></div>
                        <select class="inp" style="width:auto;min-width:165px" id="tmpl-cat" onchange="filterTemplates()">
                            <option value="">All Categories</option>
                            <option value="motor-vehicle">Motor Vehicle</option>
                            <option value="subscriptions">Subscriptions</option>
                            <option value="special-days">Special Days</option>
                            <option value="insurance">Insurance</option>
                            <option value="home">Home</option>
                            <option value="health">Health</option>
                            <option value="travel">Travel</option>
                            <option value="pet-care">Pet Care</option>
                            <option value="tv-telephone-mobile">TV & Mobile</option>
                        </select>
                    </div>
                    <div id="tmpl-container"></div>
                </section>

                <!-- ===== SHARED REMINDERS ===== -->
                <section id="page-shared" class="page">
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

                <!-- ===== PROFILE ===== -->
                <section id="page-profile" class="page">
                    <div class="g2">
                        <div class="card" style="padding:24px">
                            <h3 class="font-jakarta" style="font-weight:700;font-size:.93rem;color:#f1f5f9;margin-bottom:18px">Personal Information</h3>
                            <div style="display:flex;align-items:center;gap:16px;margin-bottom:22px">
                                <div style="position:relative;cursor:pointer" onclick="document.getElementById('av-inp').click()">
                                    <div id="av-preview" style="width:76px;height:76px;border-radius:18px;background:linear-gradient(135deg,#7c3aed,#0d9488);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.5rem;font-weight:700;box-shadow:0 6px 20px rgba(124,58,237,.35);overflow:hidden" id="av-big">JM</div>
                                    <div style="position:absolute;bottom:-6px;right:-6px;width:26px;height:26px;border-radius:8px;background:#7c3aed;display:flex;align-items:center;justify-content:center;border:2px solid #090918"><i class="ri-camera-line" style="color:#fff;font-size:.7rem"></i></div>
                                </div>
                                <input type="file" id="av-inp" style="display:none" accept="image/*" onchange="handleAvatar(event)">
                                <div>
                                    <div class="font-jakarta" style="font-weight:700;font-size:1.05rem;color:#f1f5f9" id="profile-display-name">Kishore Rex</div>
                                    <div style="font-size:.75rem;color:#64748b;margin-top:2px">Pro Member · Since April 2026</div>
                                    <button class="btn btn-ghost btn-xs" style="margin-top:8px" onclick="document.getElementById('av-inp').click()"><i class="ri-upload-line"></i> Change Photo</button>
                                </div>
                            </div>
                            <div style="display:flex;flex-direction:column;gap:14px">
                                <div><label style="display:block;font-size:.67rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:6px">Full Name <span style="color:#f43f5e">*</span></label><input class="inp" id="p-name" value="Kishore Rex"></div>
                                <div><label style="display:block;font-size:.67rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:6px">Email <span style="color:#f43f5e">*</span></label><input class="inp" type="email" id="p-email" value="Kishore@example.com"></div>
                                <div><label style="display:block;font-size:.67rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:6px">Phone</label><input class="inp" type="tel" id="p-phone" value="+44 7700 900123"></div>
                                <div class="g2">
                                    <div><label style="display:block;font-size:.67rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:6px">Country</label><select class="inp">
                                            <option selected>United Kingdom</option>
                                            <option>Ireland</option>
                                            <option>United States</option>
                                            <option>Canada</option>
                                            <option>Australia</option>
                                        </select></div>
                                    <div><label style="display:block;font-size:.67rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:6px">Postcode</label><input class="inp" value="EN1 1SP"></div>
                                </div>
                                <button class="btn btn-primary" style="justify-content:center;width:100%" onclick="saveProfile()"><i class="ri-save-line"></i> Save Changes</button>
                            </div>
                        </div>
                        <div style="display:flex;flex-direction:column;gap:16px">
                            <div class="card" style="padding:22px">
                                <h3 class="font-jakarta" style="font-weight:700;font-size:.93rem;color:#f1f5f9;margin-bottom:16px">Security Settings</h3>
                                <div style="display:flex;flex-direction:column;gap:12px">
                                    <div><label style="display:block;font-size:.67rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:6px">Current Password <span style="color:#f43f5e">*</span></label><input class="inp" type="password" placeholder="Enter current password"></div>
                                    <div><label style="display:block;font-size:.67rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:6px">New Password <span style="color:#f43f5e">*</span></label><input class="inp" type="password" placeholder="Min 8 chars, 1 uppercase, 1 number"></div>
                                    <div><label style="display:block;font-size:.67rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:6px">Confirm Password <span style="color:#f43f5e">*</span></label><input class="inp" type="password" placeholder="Re-enter new password"></div>
                                    <button class="btn btn-primary" style="justify-content:center;width:100%" onclick="toast('Password updated successfully!','success')"><i class="ri-lock-password-line"></i> Update Password</button>
                                </div>
                            </div>
                            <div class="card" style="padding:18px">
                                <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:10px">Preferences</h3>
                                <div style="display:flex;flex-direction:column;gap:10px">
                                    <div style="display:flex;align-items:center;justify-content:space-between;padding:10px;border-radius:10px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06)">
                                        <div style="font-size:.84rem;font-weight:500;color:#94a3b8">Email Digest (Weekly)</div><button class="toggle on" onclick="this.classList.toggle('on')"></button>
                                    </div>
                                    <div style="display:flex;align-items:center;justify-content:space-between;padding:10px;border-radius:10px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06)">
                                        <div style="font-size:.84rem;font-weight:500;color:#94a3b8">Marketing Emails</div><button class="toggle" onclick="this.classList.toggle('on')"></button>
                                    </div>
                                    <div style="display:flex;align-items:center;justify-content:space-between;padding:10px;border-radius:10px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06)">
                                        <div style="font-size:.84rem;font-weight:500;color:#94a3b8">2-Factor Auth</div><button class="toggle" onclick="this.classList.toggle('on')"></button>
                                    </div>
                                </div>
                            </div>
                            <div class="danger-zone">
                                <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f43f5e;margin-bottom:6px"><i class="ri-alert-line" style="margin-right:4px"></i> Danger Zone</h3>
                                <p style="font-size:.8rem;color:#64748b;margin-bottom:10px">Permanently delete your account and all data. This cannot be undone.</p>
                                <button class="btn btn-danger btn-sm" onclick="confirm_act('Delete your account? All data will be permanently removed.',()=>toast('Account deletion initiated. You will receive an email confirmation.','warning'))"><i class="ri-delete-bin-2-line"></i> Delete Account</button>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- ===== NOTIFICATIONS ===== -->
                <section id="page-notifications" class="page">
                    <div style="margin-bottom:16px">
                        <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800;color:#f1f5f9">Notification Settings</h2>
                        <p style="font-size:.82rem;color:#64748b;margin-top:3px">Configure how and when you receive reminder alerts</p>
                    </div>
                    <div class="g2" style="margin-bottom:16px">
                        <div class="card" style="padding:18px">
                            <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:4px">Notification Channels</h3>
                            <p style="font-size:.78rem;color:#64748b;margin-bottom:14px">Enable or disable notification methods</p>
                            <div style="display:flex;flex-direction:column;gap:10px">
                                <div style="display:flex;align-items:center;justify-content:space-between;padding:12px;border-radius:12px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06)">
                                    <div style="display:flex;align-items:center;gap:10px">
                                        <div class="cat-ico" style="width:36px;height:36px;background:rgba(20,184,166,.12)"><i class="ri-mail-line" style="color:#2dd4bf;font-size:.95rem"></i></div>
                                        <div>
                                            <div style="font-size:.85rem;font-weight:600;color:#94a3b8">Email</div>
                                            <div style="font-size:.73rem;color:#64748b">Kishore@example.com</div>
                                        </div>
                                    </div>
                                    <button class="toggle on" onclick="this.classList.toggle('on')"></button>
                                </div>
                                <div style="display:flex;align-items:center;justify-content:space-between;padding:12px;border-radius:12px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06)">
                                    <div style="display:flex;align-items:center;gap:10px">
                                        <div class="cat-ico" style="width:36px;height:36px;background:rgba(16,185,129,.12)"><i class="ri-message-2-line" style="color:#10b981;font-size:.95rem"></i></div>
                                        <div>
                                            <div style="font-size:.85rem;font-weight:600;color:#94a3b8">SMS</div>
                                            <div style="font-size:.73rem;color:#64748b">+44 7700 900123</div>
                                        </div>
                                    </div>
                                    <button class="toggle on" onclick="this.classList.toggle('on')"></button>
                                </div>
                                <div style="display:flex;align-items:center;justify-content:space-between;padding:12px;border-radius:12px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06)">
                                    <div style="display:flex;align-items:center;gap:10px">
                                        <div class="cat-ico" style="width:36px;height:36px;background:rgba(124,58,237,.15)"><i class="ri-notification-3-line" style="color:#a78bfa;font-size:.95rem"></i></div>
                                        <div>
                                            <div style="font-size:.85rem;font-weight:600;color:#94a3b8">Push Notifications</div>
                                            <div style="font-size:.73rem;color:#64748b">Browser & mobile app</div>
                                        </div>
                                    </div>
                                    <button class="toggle" onclick="this.classList.toggle('on')"></button>
                                </div>
                                <div style="display:flex;align-items:center;justify-content:space-between;padding:12px;border-radius:12px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06)">
                                    <div style="display:flex;align-items:center;gap:10px">
                                        <div class="cat-ico" style="width:36px;height:36px;background:rgba(37,211,102,.12)"><i class="ri-whatsapp-line" style="color:#25D366;font-size:.95rem"></i></div>
                                        <div>
                                            <div style="font-size:.85rem;font-weight:600;color:#94a3b8">WhatsApp</div>
                                            <div style="font-size:.73rem;color:#64748b">+44 7700 900123</div>
                                        </div>
                                    </div>
                                    <button class="toggle on" onclick="this.classList.toggle('on')"></button>
                                </div>
                            </div>
                        </div>
                        <div class="card" style="padding:18px">
                            <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:4px">Alert Timing</h3>
                            <p style="font-size:.78rem;color:#64748b;margin-bottom:14px">When to receive notifications before Dates</p>
                            <div style="display:flex;flex-direction:column;gap:6px">
                                <label style="display:flex;align-items:center;gap:10px;padding:10px;border-radius:10px;cursor:pointer;background:rgba(255,255,255,.02);border:1px solid rgba(255,255,255,.05)"><input type="checkbox" checked style="accent-color:#7c3aed;width:15px;height:15px">
                                    <div>
                                        <div style="font-size:.85rem;font-weight:500;color:#94a3b8">30 days before</div>
                                        <div style="font-size:.72rem;color:#64748b">Early planning alert</div>
                                    </div>
                                </label>
                                <label style="display:flex;align-items:center;gap:10px;padding:10px;border-radius:10px;cursor:pointer;background:rgba(255,255,255,.02);border:1px solid rgba(255,255,255,.05)"><input type="checkbox" checked style="accent-color:#7c3aed;width:15px;height:15px">
                                    <div>
                                        <div style="font-size:.85rem;font-weight:500;color:#94a3b8">7 days before</div>
                                        <div style="font-size:.72rem;color:#64748b">One week reminder</div>
                                    </div>
                                </label>
                                <label style="display:flex;align-items:center;gap:10px;padding:10px;border-radius:10px;cursor:pointer;background:rgba(255,255,255,.02);border:1px solid rgba(255,255,255,.05)"><input type="checkbox" checked style="accent-color:#7c3aed;width:15px;height:15px">
                                    <div>
                                        <div style="font-size:.85rem;font-weight:500;color:#94a3b8">3 days before</div>
                                        <div style="font-size:.72rem;color:#64748b">Important alert</div>
                                    </div>
                                </label>
                                <label style="display:flex;align-items:center;gap:10px;padding:10px;border-radius:10px;cursor:pointer;background:rgba(255,255,255,.02);border:1px solid rgba(255,255,255,.05)"><input type="checkbox" checked style="accent-color:#7c3aed;width:15px;height:15px">
                                    <div>
                                        <div style="font-size:.85rem;font-weight:500;color:#94a3b8">1 day before</div>
                                        <div style="font-size:.72rem;color:#64748b">Final reminder</div>
                                    </div>
                                </label>
                                <label style="display:flex;align-items:center;gap:10px;padding:10px;border-radius:10px;cursor:pointer;background:rgba(255,255,255,.02);border:1px solid rgba(255,255,255,.05)"><input type="checkbox" style="accent-color:#7c3aed;width:15px;height:15px">
                                    <div>
                                        <div style="font-size:.85rem;font-weight:500;color:#94a3b8">On the day</div>
                                        <div style="font-size:.72rem;color:#64748b">Date notification</div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card" style="padding:18px;margin-bottom:16px">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
                            <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9">Recent Notifications</h3>
                            <button class="btn btn-ghost btn-sm" onclick="clearNotifs()"><i class="ri-delete-bin-line"></i> Clear All</button>
                        </div>
                        <div id="notif-list" style="display:flex;flex-direction:column;gap:8px">
                            <div class="notif-item unread" style="display:flex;align-items:flex-start;gap:10px">
                                <div style="width:36px;height:36px;border-radius:10px;background:rgba(245,158,11,.12);display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="ri-alarm-line" style="color:#f59e0b"></i></div>
                                <div style="flex:1">
                                    <div style="font-size:.87rem;font-weight:600;color:#f1f5f9">Car Insurance Due Soon</div>
                                    <div style="font-size:.76rem;color:#64748b;margin-top:2px">Your car insurance renewal is due in 3 days (Apr 19, 2026)</div>
                                    <div style="font-size:.72rem;color:#475569;margin-top:4px"><i class="ri-time-line"></i> 2 hours ago</div>
                                </div>
                                <button class="btn btn-ghost btn-xs" onclick="this.closest('.notif-item').classList.remove('unread');this.remove()" style="flex-shrink:0"><i class="ri-check-line"></i></button>
                            </div>
                            <div class="notif-item" style="display:flex;align-items:flex-start;gap:10px">
                                <div style="width:36px;height:36px;border-radius:10px;background:rgba(16,185,129,.12);display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="ri-check-double-line" style="color:#10b981"></i></div>
                                <div style="flex:1">
                                    <div style="font-size:.87rem;font-weight:600;color:#94a3b8">Reminder Completed</div>
                                    <div style="font-size:.76rem;color:#64748b;margin-top:2px">You marked "Gym Membership Renewal" as complete</div>
                                    <div style="font-size:.72rem;color:#475569;margin-top:4px"><i class="ri-time-line"></i> 1 day ago</div>
                                </div>
                            </div>
                            <div class="notif-item" style="display:flex;align-items:flex-start;gap:10px">
                                <div style="width:36px;height:36px;border-radius:10px;background:rgba(20,184,166,.12);display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="ri-share-line" style="color:#2dd4bf"></i></div>
                                <div style="flex:1">
                                    <div style="font-size:.87rem;font-weight:600;color:#94a3b8">Reminder Shared</div>
                                    <div style="font-size:.76rem;color:#64748b;margin-top:2px">You shared "Mum's Birthday" with 5 people</div>
                                    <div style="font-size:.72rem;color:#475569;margin-top:4px"><i class="ri-time-line"></i> 2 days ago</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card" style="padding:18px;margin-bottom:16px">
                        <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px">
                            <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9">Quiet Hours</h3>
                            <button class="toggle" id="quiet-toggle" onclick="this.classList.toggle('on');document.getElementById('quiet-cfg').style.display=this.classList.contains('on')?'grid':'none'"></button>
                        </div>
                        <p style="font-size:.78rem;color:#64748b;margin-bottom:10px">Suppress all notifications during these hours</p>
                        <div id="quiet-cfg" class="g2" style="display:none">
                            <div><label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;margin-bottom:5px">Start Time</label><input class="inp" type="time" value="22:00"></div>
                            <div><label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;margin-bottom:5px">End Time</label><input class="inp" type="time" value="08:00"></div>
                        </div>
                    </div>
                    <div style="display:flex;gap:10px;justify-content:flex-end">
                        <button class="btn btn-ghost" onclick="toast('Settings reset to default','info')"><i class="ri-refresh-line"></i> Reset</button>
                        <button class="btn btn-primary" onclick="toast('Notification preferences saved!','success')"><i class="ri-save-line"></i> Save Preferences</button>
                    </div>
                </section>

                <!-- ===== MEMBERSHIP ===== -->
                <section id="page-membership" class="page">
                    <div style="margin-bottom:16px">
                        <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800;color:#f1f5f9">Membership & Billing</h2>
                        <p style="font-size:.82rem;color:#64748b;margin-top:3px">Manage your subscription and billing information</p>
                    </div>
                    <div class="plan-grad" style="padding:24px;margin-bottom:20px;position:relative;overflow:hidden">
                        <div style="position:absolute;top:-60px;right:-60px;width:180px;height:180px;border-radius:50%;background:rgba(124,58,237,.08);pointer-events:none"></div>
                        <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:16px;flex-wrap:wrap;gap:10px">
                            <div>
                                <div style="font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.12em;color:rgba(167,139,250,.7);margin-bottom:6px">Current Plan</div>
                                <div class="font-jakarta" style="font-size:1.4rem;font-weight:800;color:#f1f5f9">Basic Annual</div>
                            </div>
                            <span class="badge badge-green"><i class="ri-checkbox-circle-fill"></i> Active</span>
                        </div>
                        <div style="display:flex;align-items:baseline;gap:4px;margin-bottom:4px"><span class="font-jakarta" style="font-size:2.5rem;font-weight:800;color:#f1f5f9">£2.40</span><span style="font-size:.84rem;color:#64748b">/year incl. VAT</span></div>
                        <div style="font-size:.84rem;color:#64748b;margin-bottom:16px">Renews on <strong style="color:#94a3b8">April 10, 2027</strong> · 214 days remaining</div>
                        <div style="margin-bottom:20px">
                            <div style="display:flex;justify-content:space-between;font-size:.75rem;color:#64748b;margin-bottom:6px"><span>Plan Usage</span><span>24 / Unlimited</span></div>
                            <div class="prog-track">
                                <div class="prog-fill" style="width:32%"></div>
                            </div>
                        </div>
                        <div style="display:flex;flex-wrap:wrap;gap:8px">
                            <button class="btn btn-primary btn-sm" onclick="openModal('upg-modal')"><i class="ri-rocket-line"></i> Upgrade Plan</button>
                            <button class="btn btn-ghost btn-sm" onclick="openModal('pay-modal')"><i class="ri-bank-card-line"></i> Update Payment</button>
                            <button class="btn btn-ghost btn-sm" onclick="toast('Auto-Renew toggled','info')"><i class="ri-repeat-line"></i> Auto-Renew: ON</button>
                            <button class="btn btn-danger btn-sm" onclick="openModal('cancel-modal')"><i class="ri-close-circle-line"></i> Cancel Plan</button>
                        </div>
                    </div>
                    <div class="g2" style="margin-bottom:20px">
                        <div class="card" style="padding:18px">
                            <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:14px">Your Plan Features</h3>
                            <div style="display:flex;flex-direction:column;gap:12px">
                                <div style="display:flex;gap:10px;align-items:flex-start"><i class="ri-check-line" style="color:#10b981;flex-shrink:0;margin-top:2px"></i>
                                    <div>
                                        <div style="font-size:.87rem;font-weight:600;color:#94a3b8">Unlimited Reminders</div>
                                        <div style="font-size:.75rem;color:#64748b">All categories included</div>
                                    </div>
                                </div>
                                <div style="display:flex;gap:10px;align-items:flex-start"><i class="ri-check-line" style="color:#10b981;flex-shrink:0;margin-top:2px"></i>
                                    <div>
                                        <div style="font-size:.87rem;font-weight:600;color:#94a3b8">Multi-Channel Notifications</div>
                                        <div style="font-size:.75rem;color:#64748b">Email, SMS, Push & WhatsApp</div>
                                    </div>
                                </div>
                                <div style="display:flex;gap:10px;align-items:flex-start"><i class="ri-check-line" style="color:#10b981;flex-shrink:0;margin-top:2px"></i>
                                    <div>
                                        <div style="font-size:.87rem;font-weight:600;color:#94a3b8">Calendar Integration</div>
                                        <div style="font-size:.75rem;color:#64748b">Full visual calendar view</div>
                                    </div>
                                </div>
                                <div style="display:flex;gap:10px;align-items:flex-start"><i class="ri-check-line" style="color:#10b981;flex-shrink:0;margin-top:2px"></i>
                                    <div>
                                        <div style="font-size:.87rem;font-weight:600;color:#94a3b8">WhatsApp & Email Sharing</div>
                                        <div style="font-size:.75rem;color:#64748b">Share with anyone instantly</div>
                                    </div>
                                </div>
                                <div style="display:flex;gap:10px;align-items:flex-start"><i class="ri-check-line" style="color:#10b981;flex-shrink:0;margin-top:2px"></i>
                                    <div>
                                        <div style="font-size:.87rem;font-weight:600;color:#94a3b8">Analytics & Reports</div>
                                        <div style="font-size:.75rem;color:#64748b">Track your activity & spending</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card" style="padding:18px">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
                                <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9">Payment Method</h3>
                                <button class="btn btn-ghost btn-xs" onclick="openModal('pay-modal')"><i class="ri-pencil-line"></i> Edit</button>
                            </div>
                            <div style="background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06);border-radius:12px;padding:14px;margin-bottom:14px">
                                <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px">
                                    <div style="width:38px;height:26px;border-radius:6px;background:linear-gradient(135deg,#1a3a8f,#2563eb);display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="ri-bank-card-fill" style="color:#fff;font-size:.85rem"></i></div>
                                    <div>
                                        <div style="font-size:.85rem;font-weight:600;color:#94a3b8">Visa •••• 4242</div>
                                        <div style="font-size:.73rem;color:#64748b">Expires 12/2027</div>
                                    </div>
                                </div>
                                <div style="font-size:.75rem;color:#64748b"><i class="ri-user-line" style="margin-right:4px"></i> Kishore Rex</div>
                            </div>
                            <h4 style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:8px">Billing Address</h4>
                            <div style="font-size:.84rem;color:#64748b;line-height:1.8">Kishore Rex<br>123 High Street<br>London, EN1 1SP<br>United Kingdom</div>
                        </div>
                    </div>
                    <div class="card" style="padding:18px">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
                            <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9">Payment History</h3>
                            <button class="btn btn-ghost btn-sm" onclick="toast('Downloading invoices…','info')"><i class="ri-download-2-line"></i> Download All</button>
                        </div>
                        <div style="overflow-x:auto">
                            <table style="width:100%;border-collapse:collapse;font-size:.84rem">
                                <thead>
                                    <tr>
                                        <th style="text-align:left;padding-bottom:10px;font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;border-bottom:1px solid rgba(255,255,255,.06)">Transaction</th>
                                        <th style="text-align:left;padding-bottom:10px;font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;border-bottom:1px solid rgba(255,255,255,.06)">Plan</th>
                                        <th style="text-align:left;padding-bottom:10px;font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;border-bottom:1px solid rgba(255,255,255,.06)">Amount</th>
                                        <th style="text-align:left;padding-bottom:10px;font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;border-bottom:1px solid rgba(255,255,255,.06)">Status</th>
                                        <th style="text-align:left;padding-bottom:10px;font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;border-bottom:1px solid rgba(255,255,255,.06)">Date</th>
                                        <th style="border-bottom:1px solid rgba(255,255,255,.06)"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="tbl-row">
                                        <td style="padding:11px 0;font-family:'DM Mono',monospace;font-size:.73rem;color:#64748b">#TXN-00421</td>
                                        <td style="padding:11px 8px 11px 0;color:#94a3b8">Basic Annual</td>
                                        <td style="padding:11px 8px 11px 0;font-weight:700;color:#f1f5f9">£2.40</td>
                                        <td style="padding:11px 8px 11px 0"><span class="badge badge-green">Success</span></td>
                                        <td style="padding:11px 0;color:#64748b;white-space:nowrap">Apr 10, 2026</td>
                                        <td style="padding:11px 0;text-align:right"><button class="btn btn-ghost btn-xs" onclick="toast('Invoice downloaded','success')"><i class="ri-download-line"></i></button></td>
                                    </tr>
                                    <tr class="tbl-row">
                                        <td style="padding:11px 0;font-family:'DM Mono',monospace;font-size:.73rem;color:#64748b">#TXN-00312</td>
                                        <td style="padding:11px 8px 11px 0;color:#94a3b8">Basic Annual</td>
                                        <td style="padding:11px 8px 11px 0;font-weight:700;color:#f1f5f9">£2.40</td>
                                        <td style="padding:11px 8px 11px 0"><span class="badge badge-green">Success</span></td>
                                        <td style="padding:11px 0;color:#64748b;white-space:nowrap">Apr 10, 2025</td>
                                        <td style="padding:11px 0;text-align:right"><button class="btn btn-ghost btn-xs" onclick="toast('Invoice downloaded','success')"><i class="ri-download-line"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td style="padding:11px 0;font-family:'DM Mono',monospace;font-size:.73rem;color:#64748b">#TXN-00201</td>
                                        <td style="padding:11px 8px 11px 0;color:#94a3b8">Basic Annual</td>
                                        <td style="padding:11px 8px 11px 0;font-weight:700;color:#f1f5f9">£2.00</td>
                                        <td style="padding:11px 8px 11px 0"><span class="badge badge-green">Success</span></td>
                                        <td style="padding:11px 0;color:#64748b;white-space:nowrap">Apr 10, 2024</td>
                                        <td style="padding:11px 0;text-align:right"><button class="btn btn-ghost btn-xs" onclick="toast('Invoice downloaded','success')"><i class="ri-download-line"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <!-- ===== CATEGORIES ===== -->
                <section id="page-categories" class="page">
                    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:16px;flex-wrap:wrap;gap:10px">
                        <div>
                            <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800;color:#f1f5f9">Reminder Categories</h2>
                            <p style="font-size:.82rem;color:#64748b;margin-top:3px">Organize reminders with categories and subcategories</p>
                        </div>
                        <button class="btn btn-primary btn-sm" onclick="openModal('add-sub-modal')"><i class="ri-add-line"></i> Add Subcategory</button>
                    </div>
                    <div class="g4" style="margin-bottom:20px">
                        <div class="stat-card">
                            <div style="width:40px;height:40px;border-radius:11px;background:rgba(124,58,237,.15);display:flex;align-items:center;justify-content:center;margin-bottom:10px"><i class="ri-folder-3-line" style="color:#a78bfa;font-size:1.1rem"></i></div>
                            <div class="font-jakarta" style="font-size:1.5rem;font-weight:800;color:#f1f5f9">10</div>
                            <div style="font-size:.72rem;color:#64748b;margin-top:3px;font-weight:600">Total Categories</div>
                        </div>
                        <div class="stat-card">
                            <div style="width:40px;height:40px;border-radius:11px;background:rgba(20,184,166,.12);display:flex;align-items:center;justify-content:center;margin-bottom:10px"><i class="ri-folder-add-line" style="color:#2dd4bf;font-size:1.1rem"></i></div>
                            <div class="font-jakarta" style="font-size:1.5rem;font-weight:800;color:#f1f5f9" id="custom-sub-count">0</div>
                            <div style="font-size:.72rem;color:#64748b;margin-top:3px;font-weight:600">Custom Subcategories</div>
                        </div>
                        <div class="stat-card">
                            <div style="width:40px;height:40px;border-radius:11px;background:rgba(16,185,129,.12);display:flex;align-items:center;justify-content:center;margin-bottom:10px"><i class="ri-star-line" style="color:#10b981;font-size:1.1rem"></i></div>
                            <div class="font-jakarta" style="font-size:.9rem;font-weight:800;color:#f1f5f9" id="most-used-cat">—</div>
                            <div style="font-size:.72rem;color:#64748b;margin-top:3px;font-weight:600">Most Used</div>
                        </div>
                    </div>
                    <div id="cat-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:14px;margin-bottom:20px"></div>
                    <div class="card" style="padding:18px">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
                            <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9">Custom Subcategories</h3>
                            <span class="badge badge-purple" id="custom-sub-badge">0 Custom</span>
                        </div>
                        <div id="custom-sub-list" style="display:flex;flex-direction:column;gap:8px">
                            <div style="text-align:center;padding:24px;color:#475569;font-size:.83rem">No custom subcategories yet. Add one above!</div>
                        </div>
                    </div>
                </section>

                <!-- ===== ANALYTICS ===== -->
                <section id="page-analytics" class="page">
                    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:16px;flex-wrap:wrap;gap:10px">
                        <div>
                            <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800;color:#f1f5f9">Analytics & Activity</h2>
                            <p style="font-size:.82rem;color:#64748b;margin-top:3px">Track your reminder activity and insights</p>
                        </div>
                        <button class="btn btn-primary btn-sm" onclick="toast('Analytics exported!','success')"><i class="ri-download-2-line"></i> Export Report</button>
                    </div>
                    <div class="card" style="padding:14px;margin-bottom:16px">
                        <div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:10px">
                            <div style="display:flex;flex-wrap:wrap;gap:6px">
                                <button class="period-btn active" onclick="setPeriod(this)">Last 7 Days</button>
                                <button class="period-btn" onclick="setPeriod(this)">Last 30 Days</button>
                                <button class="period-btn" onclick="setPeriod(this)">Last 90 Days</button>
                                <button class="period-btn" onclick="setPeriod(this)">This Year</button>
                                <button class="period-btn" onclick="setPeriod(this)">All Time</button>
                            </div>
                            <select class="inp" style="width:auto;min-width:155px" onchange="toast('Filter applied','info')">
                                <option>All Categories</option>
                                <option>Subscriptions</option>
                                <option>Insurance</option>
                                <option>Motor Vehicle</option>
                                <option>Health</option>
                            </select>
                        </div>
                    </div>
                    <div class="g4" style="margin-bottom:20px">
                        <div class="stat-card">
                            <div style="width:40px;height:40px;border-radius:11px;background:rgba(124,58,237,.15);display:flex;align-items:center;justify-content:center;margin-bottom:10px"><i class="ri-alarm-line" style="color:#a78bfa;font-size:1.1rem"></i></div>
                            <div class="font-jakarta" style="font-size:1.5rem;font-weight:800;color:#f1f5f9">47</div>
                            <div style="font-size:.72rem;color:#64748b;margin-top:3px;font-weight:600">Total Reminders</div>
                            <div style="font-size:.72rem;color:#10b981;margin-top:4px"><i class="ri-arrow-up-line"></i> +12% from last</div>
                        </div>
                        <div class="stat-card">
                            <div style="width:40px;height:40px;border-radius:11px;background:rgba(16,185,129,.12);display:flex;align-items:center;justify-content:center;margin-bottom:10px"><i class="ri-check-double-line" style="color:#10b981;font-size:1.1rem"></i></div>
                            <div class="font-jakarta" style="font-size:1.5rem;font-weight:800;color:#10b981">89%</div>
                            <div style="font-size:.72rem;color:#64748b;margin-top:3px;font-weight:600">Completion Rate</div>
                            <div style="font-size:.72rem;color:#10b981;margin-top:4px"><i class="ri-arrow-up-line"></i> +5% improvement</div>
                        </div>
                        <div class="stat-card">
                            <div style="width:40px;height:40px;border-radius:11px;background:rgba(20,184,166,.12);display:flex;align-items:center;justify-content:center;margin-bottom:10px"><i class="ri-timer-line" style="color:#2dd4bf;font-size:1.1rem"></i></div>
                            <div class="font-jakarta" style="font-size:1.5rem;font-weight:800;color:#f1f5f9">2.4h</div>
                            <div style="font-size:.72rem;color:#64748b;margin-top:3px;font-weight:600">Avg Response Time</div>
                        </div>
                        <div class="stat-card">
                            <div style="width:40px;height:40px;border-radius:11px;background:rgba(245,158,11,.12);display:flex;align-items:center;justify-content:center;margin-bottom:10px"><i class="ri-wallet-3-line" style="color:#f59e0b;font-size:1.1rem"></i></div>
                            <div class="font-jakarta" style="font-size:1.5rem;font-weight:800;color:#f59e0b">£1.2k</div>
                            <div style="font-size:.72rem;color:#64748b;margin-top:3px;font-weight:600">Total Saved</div>
                        </div>
                    </div>
                    <div class="g2" style="margin-bottom:16px">
                        <div class="card" style="padding:18px">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
                                <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9">Activity Trend</h3>
                                <select class="inp" style="width:auto;padding:5px 28px 5px 10px;font-size:.75rem">
                                    <option>Weekly</option>
                                    <option>Daily</option>
                                    <option>Monthly</option>
                                </select>
                            </div>
                            <div style="position:relative;height:250px"><canvas id="act-trend-chart"></canvas></div>
                        </div>
                        <div class="card" style="padding:18px">
                            <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:14px">By Category</h3>
                            <div style="position:relative;height:250px"><canvas id="cat-dist-chart"></canvas></div>
                        </div>
                    </div>
                    <div class="g2" style="margin-bottom:16px">
                        <div class="card" style="padding:18px">
                            <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:14px">Completion Status</h3>
                            <div style="position:relative;height:210px"><canvas id="comp-chart"></canvas></div>
                            <div class="g2" style="margin-top:14px">
                                <div style="text-align:center;padding:12px;background:rgba(16,185,129,.1);border-radius:10px">
                                    <div style="font-size:.72rem;color:#64748b;margin-bottom:3px">Completed</div>
                                    <div class="font-jakarta" style="font-size:1.3rem;font-weight:800;color:#10b981">42</div>
                                </div>
                                <div style="text-align:center;padding:12px;background:rgba(244,63,94,.1);border-radius:10px">
                                    <div style="font-size:.72rem;color:#64748b;margin-bottom:3px">Pending</div>
                                    <div class="font-jakarta" style="font-size:1.3rem;font-weight:800;color:#f43f5e">5</div>
                                </div>
                            </div>
                        </div>
                        <div class="card" style="padding:18px">
                            <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:14px">Monthly Spending (£)</h3>
                            <div style="position:relative;height:210px"><canvas id="spend-chart"></canvas></div>
                        </div>
                    </div>
                    <div class="card" style="padding:18px;margin-bottom:16px">
                        <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:14px">Category Performance</h3>
                        <div style="overflow-x:auto">
                            <table style="width:100%;border-collapse:collapse;font-size:.83rem">
                                <thead>
                                    <tr>
                                        <th style="text-align:left;padding-bottom:10px;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;border-bottom:1px solid rgba(255,255,255,.06)">Category</th>
                                        <th style="text-align:center;padding-bottom:10px;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;border-bottom:1px solid rgba(255,255,255,.06)">Total</th>
                                        <th style="text-align:center;padding-bottom:10px;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;border-bottom:1px solid rgba(255,255,255,.06)">Done</th>
                                        <th style="text-align:center;padding-bottom:10px;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;border-bottom:1px solid rgba(255,255,255,.06)">Rate</th>
                                        <th style="text-align:center;padding-bottom:10px;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;border-bottom:1px solid rgba(255,255,255,.06)">Trend</th>
                                    </tr>
                                </thead>
                                <tbody id="cat-perf-table"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card" style="padding:18px">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
                            <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9">Recent Activity</h3>
                            <button class="btn btn-ghost btn-sm">View All <i class="ri-arrow-right-line"></i></button>
                        </div>
                        <div id="activity-log" style="display:flex;flex-direction:column;gap:8px"></div>
                    </div>
                </section>

                <!-- ===== HELP ===== -->
                <section id="page-help" class="page">
                    <div style="margin-bottom:16px">
                        <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800;color:#f1f5f9">How Can We Help?</h2>
                        <p style="font-size:.82rem;color:#64748b;margin-top:3px">Find answers, guides, and support resources</p>
                    </div>
                    <div class="card" style="padding:14px;margin-bottom:20px">
                        <div class="search-box"><i class="ri-search-line" style="color:#64748b"></i><input id="help-search" placeholder="Search help articles, FAQs…" oninput="filterFaq(this.value)" style="font-size:.87rem;color:inherit"></div>
                    </div>
                    <div class="g4" style="margin-bottom:24px">
                        <div class="help-card" onclick="document.querySelector('.faq-item .faq-q').click()">
                            <div style="width:52px;height:52px;border-radius:14px;background:rgba(20,184,166,.12);display:flex;align-items:center;justify-content:center;margin:0 auto 10px"><i class="ri-rocket-line" style="color:#2dd4bf;font-size:1.4rem"></i></div>
                            <div class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:4px">Getting Started</div>
                            <div style="font-size:.77rem;color:#64748b;margin-bottom:12px">Learn the basics of D-Remind</div><button class="btn btn-primary btn-sm">Start Tutorial</button>
                        </div>
                        <div class="help-card" onclick="openModal('support-modal')">
                            <div style="width:52px;height:52px;border-radius:14px;background:rgba(124,58,237,.15);display:flex;align-items:center;justify-content:center;margin:0 auto 10px"><i class="ri-customer-service-2-line" style="color:#a78bfa;font-size:1.4rem"></i></div>
                            <div class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:4px">Contact Support</div>
                            <div style="font-size:.77rem;color:#64748b;margin-bottom:12px">Get personalized help</div><button class="btn btn-primary btn-sm">Contact Us</button>
                        </div>
                        <div class="help-card" onclick="toast('User guide downloading…','info')">
                            <div style="width:52px;height:52px;border-radius:14px;background:rgba(16,185,129,.12);display:flex;align-items:center;justify-content:center;margin:0 auto 10px"><i class="ri-book-3-line" style="color:#10b981;font-size:1.4rem"></i></div>
                            <div class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:4px">User Guides</div>
                            <div style="font-size:.77rem;color:#64748b;margin-bottom:12px">Download comprehensive guides</div><button class="btn btn-primary btn-sm">Download PDF</button>
                        </div>
                        <div class="help-card" onclick="go('feedback')">
                            <div style="width:52px;height:52px;border-radius:14px;background:rgba(245,158,11,.12);display:flex;align-items:center;justify-content:center;margin:0 auto 10px"><i class="ri-feedback-line" style="color:#f59e0b;font-size:1.4rem"></i></div>
                            <div class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:4px">Send Feedback</div>
                            <div style="font-size:.77rem;color:#64748b;margin-bottom:12px">Help us improve D-Remind</div><button class="btn btn-primary btn-sm">Give Feedback</button>
                        </div>
                    </div>
                    <div class="card" style="padding:18px;margin-bottom:16px">
                        <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:14px">Frequently Asked Questions</h3>
                        <div id="faq-container" style="display:flex;flex-direction:column;gap:0"></div>
                    </div>
                    <div class="g2">
                        <div class="card" style="padding:18px;text-align:center"><i class="ri-mail-line" style="font-size:2.2rem;color:rgba(45,212,191,.4);display:block;margin-bottom:8px"></i>
                            <div class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:4px">Email Support</div>
                            <div style="font-size:.77rem;color:#64748b;margin-bottom:8px">Get help from our team</div><a href="mailto:support@winngoodremind.co.uk" style="font-size:.84rem;color:#a78bfa;font-weight:600;text-decoration:none">support@winngoodremind.co.uk</a>
                        </div>
                        <div class="card" style="padding:18px;text-align:center"><i class="ri-time-line" style="font-size:2.2rem;color:rgba(16,185,129,.4);display:block;margin-bottom:8px"></i>
                            <div class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:4px">Response Time</div>
                            <div style="font-size:.77rem;color:#64748b;margin-bottom:8px">Average response time</div>
                            <div class="font-jakarta" style="font-size:1.3rem;font-weight:800;color:#10b981">Within 24 Hours</div>
                        </div>
                    </div>
                </section>

                <!-- ===== FEEDBACK ===== -->
                <section id="page-feedback" class="page">
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
                            <div class="card" style="padding:18px">
                                <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:12px">Community Impact</h3>
                                <div style="display:flex;flex-direction:column;gap:10px">
                                    <div style="display:flex;justify-content:space-between;align-items:center"><span style="font-size:.82rem;color:#64748b">Total Feedback</span><span class="font-jakarta" style="font-weight:800;color:#a78bfa">1,247</span></div>
                                    <div style="display:flex;justify-content:space-between;align-items:center"><span style="font-size:.82rem;color:#64748b">Features Implemented</span><span class="font-jakarta" style="font-weight:800;color:#10b981">89</span></div>
                                    <div style="display:flex;justify-content:space-between;align-items:center"><span style="font-size:.82rem;color:#64748b">Bugs Fixed</span><span class="font-jakarta" style="font-weight:800;color:#2dd4bf">156</span></div>
                                    <div style="display:flex;justify-content:space-between;align-items:center"><span style="font-size:.82rem;color:#64748b">Avg Response</span><span class="font-jakarta" style="font-weight:800;color:#f59e0b">18hrs</span></div>
                                </div>
                            </div>
                            <div class="card" style="padding:16px;text-align:center"><a href="mailto:support@winngoodremind.co.uk" style="font-size:.84rem;color:#a78bfa;font-weight:600;text-decoration:none"><i class="ri-mail-line" style="margin-right:4px"></i>support@winngoodremind.co.uk</a></div>
                        </div>
                    </div>
                </section>

            </main>
        </div>
    </div>

    <!-- ============ MODALS ============ -->
    <!-- Share Modal -->
    <div class="modal-bg" id="share-modal">
        <div class="modal-box">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
                <h3 class="font-jakarta" style="font-weight:700;font-size:.95rem;color:#f1f5f9;display:flex;align-items:center;gap:8px"><i class="ri-share-line" style="color:#2dd4bf"></i> Share Reminder</h3>
                <button onclick="closeModal('share-modal')" class="btn btn-icon btn-ghost btn-sm"><i class="ri-close-line"></i></button>
            </div>
            <div style="margin-bottom:14px"><label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:6px">Select Reminder</label><select class="inp" id="share-rem-select">
                    <option>Mum's Birthday - Jun 3, 2026</option>
                    <option>Car Insurance Renewal - Apr 19, 2026</option>
                    <option>Netflix Subscription - Apr 24, 2026</option>
                </select></div>
            <div style="margin-bottom:14px"><label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:8px">Share Method</label>
                <div style="display:flex;gap:8px">
                    <button class="btn" style="flex:1;justify-content:center;padding:12px;border-radius:12px;border:1px solid rgba(37,211,102,.3);background:rgba(37,211,102,.08);color:#25D366;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:.84rem;cursor:pointer" onclick="toast('Opening WhatsApp…','success');closeModal('share-modal')"><i class="ri-whatsapp-line"></i> WhatsApp</button>
                    <button class="btn" style="flex:1;justify-content:center;padding:12px;border-radius:12px;border:1px solid rgba(20,184,166,.3);background:rgba(20,184,166,.08);color:#2dd4bf;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:.84rem;cursor:pointer" onclick="toast('Opening email…','info');closeModal('share-modal')"><i class="ri-mail-line"></i> Email</button>
                    <button class="btn" style="flex:1;justify-content:center;padding:12px;border-radius:12px;border:1px solid rgba(124,58,237,.3);background:rgba(124,58,237,.08);color:#a78bfa;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:.84rem;cursor:pointer" onclick="toast('Link copied!','success');closeModal('share-modal')"><i class="ri-link"></i> Copy Link</button>
                </div>
            </div>
            <div style="margin-bottom:14px"><label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:6px">Recipient</label><input class="inp" placeholder="+44 7700 900123 or email@example.com"></div>
            <div style="margin-bottom:18px"><label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:6px">Message (Optional)</label><textarea class="inp" rows="2" placeholder="Add a personal message…" style="resize:none"></textarea></div>
            <div style="display:flex;gap:10px;justify-content:flex-end"><button class="btn btn-ghost" onclick="closeModal('share-modal')">Cancel</button><button class="btn btn-primary" onclick="toast('Reminder shared successfully!','success');closeModal('share-modal')"><i class="ri-send-plane-line"></i> Share</button></div>
        </div>
    </div>

    <!-- Upgrade Modal -->
    <div class="modal-bg" id="upg-modal">
        <div class="modal-box" style="max-width:440px">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
                <h3 class="font-jakarta" style="font-weight:700;font-size:.95rem;color:#f1f5f9;display:flex;align-items:center;gap:8px"><i class="ri-rocket-line" style="color:#a78bfa"></i> Upgrade Plan</h3>
                <button onclick="closeModal('upg-modal')" class="btn btn-icon btn-ghost btn-sm"><i class="ri-close-line"></i></button>
            </div>
            <div style="text-align:center;padding:20px;background:rgba(124,58,237,.08);border-radius:14px;margin-bottom:16px"><i class="ri-information-line" style="font-size:2rem;color:#a78bfa;display:block;margin-bottom:8px"></i>
                <p style="font-size:.84rem;color:#64748b">You're on the Basic Annual plan. Pro and Family plans with advanced features are coming soon! Stay tuned for exciting updates.</p>
            </div>
            <div style="display:flex;justify-content:center"><button class="btn btn-ghost" onclick="closeModal('upg-modal')">Got it</button></div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal-bg" id="pay-modal">
        <div class="modal-box">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
                <h3 class="font-jakarta" style="font-weight:700;font-size:.95rem;color:#f1f5f9;display:flex;align-items:center;gap:8px"><i class="ri-bank-card-line" style="color:#2dd4bf"></i> Update Payment Method</h3>
                <button onclick="closeModal('pay-modal')" class="btn btn-icon btn-ghost btn-sm"><i class="ri-close-line"></i></button>
            </div>
            <div style="display:flex;flex-direction:column;gap:12px;margin-bottom:18px">
                <div><label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:6px">Name on Card <span style="color:#f43f5e">*</span></label><input class="inp" value="Kishore Rex"></div>
                <div><label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:6px">Card Number <span style="color:#f43f5e">*</span></label><input class="inp" placeholder="1234 5678 9012 3456" maxlength="19"></div>
                <div class="g2">
                    <div><label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:6px">Expiry</label><input class="inp" placeholder="MM/YYYY" maxlength="7"></div>
                    <div><label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:6px">CVC</label><input class="inp" placeholder="123" maxlength="3" type="password"></div>
                </div>
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end"><button class="btn btn-ghost" onclick="closeModal('pay-modal')">Cancel</button><button class="btn btn-primary" onclick="toast('Payment method updated!','success');closeModal('pay-modal')"><i class="ri-save-line"></i> Update Card</button></div>
        </div>
    </div>

    <!-- Cancel Plan Modal -->
    <div class="modal-bg" id="cancel-modal">
        <div class="modal-box" style="max-width:440px">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px">
                <h3 class="font-jakarta" style="font-weight:700;font-size:.95rem;color:#f43f5e;display:flex;align-items:center;gap:8px"><i class="ri-error-warning-line"></i> Cancel Membership</h3>
                <button onclick="closeModal('cancel-modal')" class="btn btn-icon btn-ghost btn-sm"><i class="ri-close-line"></i></button>
            </div>
            <div style="text-align:center;margin-bottom:18px"><i class="ri-emotion-sad-line" style="font-size:3rem;color:rgba(244,63,94,.35);display:block;margin-bottom:10px"></i>
                <div class="font-jakarta" style="font-weight:700;font-size:.95rem;color:#f1f5f9;margin-bottom:6px">We're sorry to see you go!</div>
                <p style="font-size:.83rem;color:#64748b">You'll lose access to all premium features when your plan ends on April 10, 2027.</p>
            </div>
            <div style="margin-bottom:16px"><label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:6px">Reason (Optional)</label><select class="inp">
                    <option value="">Select reason…</option>
                    <option>Too expensive</option>
                    <option>Not using enough</option>
                    <option>Missing features</option>
                    <option>Technical issues</option>
                    <option>Switching to competitor</option>
                    <option>Other</option>
                </select></div>
            <div style="display:flex;gap:10px;justify-content:flex-end"><button class="btn btn-primary" onclick="closeModal('cancel-modal')">Keep My Plan</button><button class="btn btn-danger" onclick="toast('Cancellation requested. Plan remains active until April 10, 2027.','warning');closeModal('cancel-modal')"><i class="ri-close-circle-line"></i> Confirm Cancel</button></div>
        </div>
    </div>

    <!-- Add Subcategory Modal — FIXED -->
    <div class="modal-bg" id="add-sub-modal">
        <div class="modal-box" style="max-width:500px">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
                <h3 class="font-jakarta" style="font-weight:700;font-size:.95rem;color:#f1f5f9;display:flex;align-items:center;gap:8px"><i class="ri-folder-add-line" style="color:#2dd4bf"></i> Add Custom Subcategory</h3>
                <button onclick="closeModal('add-sub-modal')" class="btn btn-icon btn-ghost btn-sm"><i class="ri-close-line"></i></button>
            </div>
            <div style="margin-bottom:14px">
                <label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:6px">Parent Category <span style="color:#f43f5e">*</span></label>
                <select class="inp" id="sub-cat-parent">
                    <option value="">Select parent category…</option>
                    <option value="special-days">Special Days</option>
                    <option value="home">Home</option>
                    <option value="insurance">Insurance</option>
                    <option value="motor-vehicle">Motor Vehicle</option>
                    <option value="subscriptions">Subscriptions</option>
                    <option value="health">Health</option>
                    <option value="travel">Travel</option>
                    <option value="pet-care">Pet Care</option>
                    <option value="tv-telephone-mobile">TV, Tel & Mobile</option>
                    <option value="others">Others</option>
                </select>
            </div>
            <div style="margin-bottom:14px">
                <label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:6px">Subcategory Name <span style="color:#f43f5e">*</span></label>
                <input class="inp" id="sub-cat-name" placeholder="Enter name (3–50 characters)" maxlength="50">
            </div>
            <div style="margin-bottom:18px">
                <label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:6px">Description (Optional)</label>
                <input class="inp" id="sub-cat-desc" placeholder="Brief description…" maxlength="100">
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end"><button class="btn btn-ghost" onclick="closeModal('add-sub-modal')">Cancel</button><button class="btn btn-primary" onclick="saveSubcat()"><i class="ri-check-line"></i> Add Subcategory</button></div>
        </div>
    </div>

    <!-- Support Modal -->
    <div class="modal-bg" id="support-modal">
        <div class="modal-box">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
                <h3 class="font-jakarta" style="font-weight:700;font-size:.95rem;color:#f1f5f9;display:flex;align-items:center;gap:8px"><i class="ri-customer-service-2-line" style="color:#a78bfa"></i> Contact Support</h3>
                <button onclick="closeModal('support-modal')" class="btn btn-icon btn-ghost btn-sm"><i class="ri-close-line"></i></button>
            </div>
            <div style="display:flex;flex-direction:column;gap:12px;margin-bottom:18px">
                <div class="g2">
                    <div><label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;color:#64748b;margin-bottom:6px">Name</label><input class="inp" value="Kishore Rex" readonly style="opacity:.7"></div>
                    <div><label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;color:#64748b;margin-bottom:6px">Email</label><input class="inp" value="Kishore@example.com" readonly style="opacity:.7"></div>
                </div>
                <div><label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;color:#64748b;margin-bottom:6px">Issue Category <span style="color:#f43f5e">*</span></label><select class="inp">
                        <option value="">Select…</option>
                        <option>Technical Issue</option>
                        <option>Billing</option>
                        <option>Feature Request</option>
                        <option>Account Help</option>
                        <option>Other</option>
                    </select></div>
                <div><label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;color:#64748b;margin-bottom:6px">Subject <span style="color:#f43f5e">*</span></label><input class="inp" placeholder="Brief description of your issue"></div>
                <div><label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;color:#64748b;margin-bottom:6px">Message <span style="color:#f43f5e">*</span></label><textarea class="inp" rows="4" placeholder="Describe in detail…" style="resize:vertical"></textarea></div>
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end"><button class="btn btn-ghost" onclick="closeModal('support-modal')">Cancel</button><button class="btn btn-primary" onclick="toast('Support request sent! We\'ll respond within 24 hours.','success');closeModal('support-modal')"><i class="ri-send-plane-line"></i> Send Request</button></div>
        </div>
    </div>

    <!-- Reminder Detail Modal -->
    <div class="modal-bg" id="detail-modal">
        <div class="modal-box">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px">
                <h3 class="font-jakarta" style="font-weight:700;font-size:.95rem;color:#f1f5f9;display:flex;align-items:center;gap:8px"><i class="ri-information-line" style="color:#2dd4bf"></i> Reminder Details</h3>
                <button onclick="closeModal('detail-modal')" class="btn btn-icon btn-ghost btn-sm"><i class="ri-close-line"></i></button>
            </div>
            <div id="detail-content"></div>
        </div>
    </div>

    <!-- Confirm Modal -->
    <div class="modal-bg" id="confirm-modal">
        <div class="modal-box" style="max-width:420px">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px">
                <div style="width:40px;height:40px;border-radius:12px;background:rgba(245,158,11,.12);display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="ri-question-line" style="color:#f59e0b;font-size:1.1rem"></i></div>
                <h3 class="font-jakarta" style="font-weight:700;font-size:.95rem;color:#f1f5f9">Confirm Action</h3>
            </div>
            <p id="confirm-msg" style="font-size:.85rem;color:#64748b;margin-bottom:22px;line-height:1.6"></p>
            <div style="display:flex;gap:10px;justify-content:flex-end"><button class="btn btn-ghost" onclick="closeModal('confirm-modal')">Cancel</button><button class="btn btn-primary" id="confirm-ok">Confirm</button></div>
        </div>
    </div>

    <style>
        @media(max-width:768px) {
            #mobile-menu-btn {
                display: flex !important
            }

            .mobile-hide-xs {
                display: none !important
            }
        }

        @media(max-width:480px) {
            .mobile-hide-sm span {
                display: none
            }

            main {
                padding: 16px !important
            }
        }
    </style>

    <script>
        // ============================================================
        // DATA
        // ============================================================
        const CATS = {
            'special-days': {
                name: 'Special Days',
                icon: 'ri-cake-3-line',
                color: '#f59e0b',
                bg: 'rgba(245,158,11,.12)',
                subs: ['Birthdays', 'Anniversaries', 'Festivals', 'Functions', 'Christenings', 'Graduations']
            },
            'home': {
                name: 'Home',
                icon: 'ri-home-4-line',
                color: '#14b8a6',
                bg: 'rgba(20,184,166,.12)',
                subs: ['Electricity', 'Gas', 'Dual Fuel Options', 'Council Tax', 'Water Bill']
            },
            'insurance': {
                name: 'Insurance',
                icon: 'ri-shield-star-line',
                color: '#f43f5e',
                bg: 'rgba(244,63,94,.12)',
                subs: ['Home Insurance', 'Contents Insurance', 'Life Insurance', 'Home & Contents Insurance', 'Critical Illness']
            },
            'tv-telephone-mobile': {
                name: 'TV, Tel & Mobile',
                icon: 'ri-smartphone-line',
                color: '#14b8a6',
                bg: 'rgba(20,184,166,.12)',
                subs: ['Phone Plans', 'SIM Only', 'Home Telephone', 'Internet Services', 'Bundled Plans', 'TV Packages']
            },
            'motor-vehicle': {
                name: 'Motor Vehicle',
                icon: 'ri-car-line',
                color: '#a78bfa',
                bg: 'rgba(167,139,250,.12)',
                subs: ['Car Insurance', 'Motorcycle Insurance', 'MOT', 'Road VAT(12-Month)', 'Road VAT(6-Month)', 'Breakdown Cover']
            },
            'travel': {
                name: 'Travel',
                icon: 'ri-flight-takeoff-line',
                color: '#ec4899',
                bg: 'rgba(236,72,153,.12)',
                subs: ['Passport Renewal', 'Driving License', 'Visa Applications', 'Travel Points', 'Travel Insurance']
            },
            'subscriptions': {
                name: 'Subscriptions',
                icon: 'ri-refresh-line',
                color: '#14b8a6',
                bg: 'rgba(20,184,166,.12)',
                subs: ['Membership Plans', 'Software Subscriptions', 'Media Streaming', 'Gaming Subscriptions', 'Newspaper / Magazine']
            },
            'pet-care': {
                name: 'Pet Care',
                icon: 'ri-footprint-line',
                color: '#10b981',
                bg: 'rgba(16,185,129,.12)',
                subs: ['Pet Insurance', 'Vaccinations', 'Annual Check-Ups', 'Grooming', 'Flea & Worm Treatment']
            },
            'health': {
                name: 'Health',
                icon: 'ri-heart-pulse-line',
                color: '#10b981',
                bg: 'rgba(16,185,129,.12)',
                subs: ['Health Insurance', 'GP Appointments', 'Vaccinations', 'Gym Memberships', 'Dental Check-Up']
            },
            'others': {
                name: 'Others',
                icon: 'ri-more-2-line',
                color: '#94a3b8',
                bg: 'rgba(148,163,184,.12)',
                subs: ['Miscellaneous']
            }
        };
        const TEMPLATES = [{
                id: 'car-ins',
                title: 'Car Insurance Renewal',
                cat: 'motor-vehicle',
                sub: 'Car Insurance',
                freq: 'Annually',
                icon: 'ri-car-line',
                col: '#a78bfa',
                bg: 'rgba(167,139,250,.12)',
                pop: 245
            },
            {
                id: 'mot',
                title: 'MOT Test',
                cat: 'motor-vehicle',
                sub: 'MOT',
                freq: 'Annually',
                icon: 'ri-tools-line',
                col: '#10b981',
                bg: 'rgba(16,185,129,.12)',
                pop: 198
            },
            {
                id: 'road-tax',
                title: 'Road VATRenewal',
                cat: 'motor-vehicle',
                sub: 'Road VAT(12-Month)',
                freq: 'Annually',
                icon: 'ri-file-shield-line',
                col: '#f43f5e',
                bg: 'rgba(244,63,94,.12)',
                pop: 167
            },
            {
                id: 'streaming',
                title: 'Streaming Subscription',
                cat: 'subscriptions',
                sub: 'Media Streaming',
                freq: 'Monthly',
                icon: 'ri-play-circle-line',
                col: '#14b8a6',
                bg: 'rgba(20,184,166,.12)',
                pop: 189
            },
            {
                id: 'birthday',
                title: 'Birthday Reminder',
                cat: 'special-days',
                sub: 'Birthdays',
                freq: '',
                icon: 'ri-cake-3-line',
                col: '#f59e0b',
                bg: 'rgba(245,158,11,.12)',
                pop: 312
            },
            {
                id: 'passport',
                title: 'Passport Renewal',
                cat: 'travel',
                sub: 'Passport Renewal',
                freq: '',
                icon: 'ri-passport-line',
                col: '#ec4899',
                bg: 'rgba(236,72,153,.12)',
                pop: 134
            },
            {
                id: 'bike-ins',
                title: 'Motorcycle Insurance',
                cat: 'motor-vehicle',
                sub: 'Motorcycle Insurance',
                freq: 'Annually',
                icon: 'ri-motorbike-line',
                col: '#a78bfa',
                bg: 'rgba(167,139,250,.12)',
                pop: 89
            },
            {
                id: 'gp',
                title: 'GP Annual Check-Up',
                cat: 'health',
                sub: 'GP Appointments',
                freq: 'Annually',
                icon: 'ri-stethoscope-line',
                col: '#10b981',
                bg: 'rgba(16,185,129,.12)',
                pop: 156
            },
            {
                id: 'gym',
                title: 'Gym Membership',
                cat: 'health',
                sub: 'Gym Memberships',
                freq: 'Monthly',
                icon: 'ri-run-line',
                col: '#10b981',
                bg: 'rgba(16,185,129,.12)',
                pop: 203
            },
            {
                id: 'pet-ins',
                title: 'Pet Insurance',
                cat: 'pet-care',
                sub: 'Pet Insurance',
                freq: 'Annually',
                icon: 'ri-footprint-line',
                col: '#10b981',
                bg: 'rgba(16,185,129,.12)',
                pop: 78
            },
            {
                id: 'home-ins',
                title: 'Home Insurance',
                cat: 'insurance',
                sub: 'Home Insurance',
                freq: 'Annually',
                icon: 'ri-home-heart-line',
                col: '#f43f5e',
                bg: 'rgba(244,63,94,.12)',
                pop: 221
            },
            {
                id: 'broadband',
                title: 'Broadband Renewal',
                cat: 'tv-telephone-mobile',
                sub: 'Internet Services',
                freq: 'Annually',
                icon: 'ri-wifi-line',
                col: '#14b8a6',
                bg: 'rgba(20,184,166,.12)',
                pop: 145
            },
            {
                id: 'life-ins',
                title: 'Life Insurance',
                cat: 'insurance',
                sub: 'Life Insurance',
                freq: 'Annually',
                icon: 'ri-shield-check-line',
                col: '#f43f5e',
                bg: 'rgba(244,63,94,.12)',
                pop: 132
            },
            {
                id: 'anniv',
                title: 'Anniversary',
                cat: 'special-days',
                sub: 'Anniversaries',
                freq: 'Annually',
                icon: 'ri-heart-line',
                col: '#f59e0b',
                bg: 'rgba(245,158,11,.12)',
                pop: 187
            },
            {
                id: 'driv-lic',
                title: 'Driving Licence Renewal',
                cat: 'travel',
                sub: 'Driving License',
                freq: '',
                icon: 'ri-drive-line',
                col: '#ec4899',
                bg: 'rgba(236,72,153,.12)',
                pop: 98
            },
            {
                id: 'elec',
                title: 'Electricity Plan',
                cat: 'home',
                sub: 'Electricity',
                freq: 'Annually',
                icon: 'ri-flashlight-line',
                col: '#14b8a6',
                bg: 'rgba(20,184,166,.12)',
                pop: 167
            },
        ];
        const FAQS = [{
                q: 'How do I create my first reminder?',
                a: 'Click "Create Reminder" in the sidebar or topbar. Fill in the title, category, subcategory, date and time. Optionally add provider, cost, and frequency. Click "Create Reminder" to save it.',
                cat: 'Getting Started'
            },
            {
                q: 'What categories are available?',
                a: 'D-Remind offers 10 categories: Special Days, Home, Insurance, TV/Tel/Mobile, Motor Vehicle, Travel, Subscriptions, Pet Care, Health, and Others. Each has multiple subcategories you can also customize.',
                cat: 'Getting Started'
            },
            {
                q: 'How do I manage notifications?',
                a: 'Go to Notification Settings in the sidebar. Toggle channels (Email, SMS, Push, WhatsApp) and set alert timing (30 days, 7 days, 3 days, 1 day before or on the day). You can also configure quiet hours.',
                cat: 'Notifications'
            },
            {
                q: 'How do I share reminders via WhatsApp or Email?',
                a: "From My Reminders, click the share icon on any reminder card or open the reminder details. Choose WhatsApp, Email, or Copy Link. Enter the recipient's number or email and optionally add a personal message.",
                cat: 'Sharing'
            },
            {
                q: 'What does my membership include?',
                a: 'Basic Annual (£2.40/year incl. VAT) includes unlimited reminders, email & SMS notifications, calendar view, WhatsApp/Email sharing, custom subcategories, analytics, template access and more.',
                cat: 'Billing'
            },
            {
                q: 'How do I cancel my membership?',
                a: "Go to Membership in the sidebar and click 'Cancel Plan'. Your membership stays active until the end of your billing period. You won't be charged again after cancellation.",
                cat: 'Billing'
            },
            {
                q: "I'm not receiving email notifications. What should I do?",
                a: "Check your spam folder and add support@winngoodremind.co.uk to your contacts. Verify email is enabled in Notification Settings and your email address is correct in Profile settings.",
                cat: 'Technical'
            },
            {
                q: 'How do I reset my password?',
                a: "Go to Profile in the sidebar, scroll to Security Settings. Enter your current password, new password (min 8 chars, 1 uppercase, 1 number), and confirm. Click 'Update Password'.",
                cat: 'Technical'
            },
            {
                q: 'Can I add custom subcategories?',
                a: "Yes! Go to Categories in the sidebar and click 'Add Subcategory'. Select a parent category, enter a name (3–50 characters), and optionally add a description. Your custom subcategory will then be available when creating reminders.",
                cat: 'Categories'
            },
        ];

        // Storage
        const S = {
            get: (k, d) => {
                try {
                    const v = localStorage.getItem('dr_' + k);
                    return v ? JSON.parse(v) : d
                } catch (e) {
                    return d
                }
            },
            set: (k, v) => {
                try {
                    localStorage.setItem('dr_' + k, JSON.stringify(v))
                } catch (e) {}
            }
        };
        const gid = () => 'r_' + Date.now() + '_' + Math.random().toString(36).substr(2, 6);
        let customSubs = S.get('custom_subs', []);

        function initData() {
            if (S.get('reminders', []).length === 0) {
                const now = new Date();
                const d = (n) => {
                    const dt = new Date(now);
                    dt.setDate(dt.getDate() + n);
                    return dt.toISOString().split('T')[0]
                };
                S.set('reminders', [{
                        id: gid(),
                        title: 'Car Insurance Renewal',
                        category: 'motor-vehicle',
                        subcategory: 'Car Insurance',
                        dueDate: d(2),
                        dueTime: '09:00',
                        provider: 'AA Insurance',
                        cost: 340,
                        frequency: 'Annually',
                        status: 'active',
                        createdAt: new Date().toISOString()
                    },
                    {
                        id: gid(),
                        title: 'Netflix Subscription',
                        category: 'subscriptions',
                        subcategory: 'Media Streaming',
                        dueDate: d(7),
                        dueTime: '09:00',
                        provider: 'Netflix',
                        cost: 10.99,
                        frequency: 'Monthly',
                        status: 'active',
                        createdAt: new Date().toISOString()
                    },
                    {
                        id: gid(),
                        title: 'GP Annual Check-Up',
                        category: 'health',
                        subcategory: 'GP Appointments',
                        dueDate: d(23),
                        dueTime: '14:30',
                        provider: 'NHS',
                        status: 'active',
                        createdAt: new Date().toISOString()
                    },
                    {
                        id: gid(),
                        title: "Mum's Birthday",
                        category: 'special-days',
                        subcategory: 'Birthdays',
                        dueDate: d(47),
                        dueTime: '09:00',
                        status: 'active',
                        createdAt: new Date().toISOString()
                    },
                    {
                        id: gid(),
                        title: 'MOT Test',
                        category: 'motor-vehicle',
                        subcategory: 'MOT',
                        dueDate: d(-5),
                        dueTime: '10:00',
                        status: 'active',
                        createdAt: new Date().toISOString()
                    },
                    {
                        id: gid(),
                        title: 'Home Insurance',
                        category: 'insurance',
                        subcategory: 'Home Insurance',
                        dueDate: d(60),
                        dueTime: '09:00',
                        provider: 'Aviva',
                        cost: 220,
                        frequency: 'Annually',
                        status: 'completed',
                        createdAt: new Date().toISOString()
                    },
                    {
                        id: gid(),
                        title: 'Broadband Renewal',
                        category: 'tv-telephone-mobile',
                        subcategory: 'Internet Services',
                        dueDate: d(14),
                        dueTime: '09:00',
                        provider: 'BT',
                        cost: 39.99,
                        frequency: 'Annually',
                        status: 'active',
                        createdAt: new Date().toISOString()
                    },
                ]);
            }
        }
        const getRems = () => S.get('reminders', []);
        const saveRems = (r) => S.set('reminders', r);
        const daysUntil = (d) => {
            const t = new Date();
            t.setHours(0, 0, 0, 0);
            const dt = new Date(d);
            dt.setHours(0, 0, 0, 0);
            return Math.ceil((dt - t) / 864e5)
        };

        function duePill(d) {
            const n = daysUntil(d);
            if (n < 0) return `<span class="pill-urgent">Overdue</span>`;
            if (n === 0) return `<span class="pill-urgent">Due today</span>`;
            if (n <= 3) return `<span class="pill-urgent">In ${n}d</span>`;
            if (n <= 7) return `<span class="pill-soon">In ${n}d</span>`;
            return `<span class="pill-ok">In ${n}d</span>`;
        }

        function fmtDate(d) {
            if (!d) return '';
            const [y, m, dy] = d.split('-');
            return `${dy}/${m}/${y}`
        }

        function pad(n) {
            return String(n).padStart(2, '0')
        }

        // ============================================================
        // THEME
        // ============================================================
        function toggleTheme() {
            document.documentElement.classList.toggle('dark');
            document.documentElement.classList.toggle('light');
            const dark = document.documentElement.classList.contains('dark');
            document.getElementById('theme-icon').className = dark ? 'ri-moon-line' : 'ri-sun-line';
            S.set('theme', dark ? 'dark' : 'light');
            setTimeout(initCharts, 350);
        }

        function initTheme() {
            const t = S.get('theme', 'dark');
            if (t === 'light') {
                document.documentElement.classList.remove('dark');
                document.documentElement.classList.add('light');
            }
            document.getElementById('theme-icon').className = t === 'dark' ? 'ri-moon-line' : 'ri-sun-line';
        }

        // ============================================================
        // SIDEBAR
        // ============================================================
        let sbCollapsed = false;

        function toggleSidebar() {
            sbCollapsed = !sbCollapsed;
            const sb = document.getElementById('sidebar');
            sb.classList.toggle('collapsed', sbCollapsed);
            S.set('sb_col', sbCollapsed);
        }

        function openMobile() {
            document.getElementById('sidebar').classList.add('mobile-open');
            document.getElementById('sb-overlay').classList.add('show');
        }

        function closeMobile() {
            document.getElementById('sidebar').classList.remove('mobile-open');
            document.getElementById('sb-overlay').classList.remove('show');
        }

        function initSidebar() {
            sbCollapsed = S.get('sb_col', false);
            if (sbCollapsed) document.getElementById('sidebar').classList.add('collapsed');
        }

        // ============================================================
        // ROUTING
        // ============================================================
        const PAGE_TITLES = {
            dashboard: 'Dashboard',
            reminders: 'My Reminders',
            create: 'Create Reminder',
            calendar: 'Calendar View',
            templates: 'Reminder Templates',
            shared: 'Shared Reminders',
            profile: 'Profile',
            notifications: 'Notifications',
            membership: 'Membership & Billing',
            categories: 'Reminder Categories',
            analytics: 'Analytics & Activity',
            help: 'Help & Support',
            feedback: 'Feedback'
        };
        let curPage = '';
        let editingId = null;

        function go(p) {
            document.querySelectorAll('.page').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.nav-link').forEach(el => el.classList.remove('active'));
            const pg = document.getElementById('page-' + p);
            if (!pg) return;
            pg.classList.add('active');
            document.getElementById('page-title').textContent = PAGE_TITLES[p] || p;
            document.querySelectorAll('.nav-link').forEach(el => {
                if (el.getAttribute('onclick') && el.getAttribute('onclick').includes(`'${p}'`)) el.classList.add('active')
            });
            curPage = p;
            if (p === 'dashboard') initDash();
            if (p === 'reminders') {
                populateCatFilter();
                loadReminders();
            }
            if (p === 'create') initCreate();
            if (p === 'calendar') initCalendar();
            if (p === 'templates') renderTemplates();
            if (p === 'categories') renderCategories();
            if (p === 'analytics') initCharts();
            if (p === 'help') renderFAQs();
            if (p === 'shared') renderShared();
            closeMobile();
        }

        // ============================================================
        // MODALS
        // ============================================================
        function openModal(id) {
            document.getElementById(id).classList.add('open');
            document.body.style.overflow = 'hidden'
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('open');
            document.body.style.overflow = ''
        }
        document.querySelectorAll('.modal-bg').forEach(m => {
            m.addEventListener('click', e => {
                if (e.target === m) {
                    m.classList.remove('open');
                    document.body.style.overflow = ''
                }
            })
        });
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') document.querySelectorAll('.modal-bg.open').forEach(m => {
                m.classList.remove('open');
                document.body.style.overflow = ''
            })
        });
        let _cb = null;

        function confirm_act(msg, cb) {
            document.getElementById('confirm-msg').textContent = msg;
            _cb = cb;
            openModal('confirm-modal')
        }
        document.getElementById('confirm-ok').onclick = () => {
            if (_cb) _cb();
            closeModal('confirm-modal')
        }

        // ============================================================
        // TOAST
        // ============================================================
        function toast(msg, type = 'info', dur = 3500) {
            const cfg = {
                success: {
                    bg: 'rgba(16,185,129,.15)',
                    bd: 'rgba(16,185,129,.3)',
                    col: '#10b981',
                    ico: 'ri-check-circle-line'
                },
                error: {
                    bg: 'rgba(244,63,94,.15)',
                    bd: 'rgba(244,63,94,.3)',
                    col: '#f43f5e',
                    ico: 'ri-error-warning-line'
                },
                warning: {
                    bg: 'rgba(245,158,11,.15)',
                    bd: 'rgba(245,158,11,.3)',
                    col: '#f59e0b',
                    ico: 'ri-alert-line'
                },
                info: {
                    bg: 'rgba(20,184,166,.15)',
                    bd: 'rgba(20,184,166,.3)',
                    col: '#14b8a6',
                    ico: 'ri-information-line'
                }
            };
            const c = cfg[type] || cfg.info;
            const el = document.createElement('div');
            el.className = 'toast';
            el.style.cssText = `background:${c.bg};border-color:${c.bd};color:${c.col}`;
            el.innerHTML = `<i class="${c.ico}" style="flex-shrink:0;font-size:1rem"></i><span style="flex:1">${msg}</span><button onclick="this.closest('.toast').remove()" style="background:none;border:none;color:inherit;cursor:pointer;opacity:.6;font-size:1rem;padding:0"><i class="ri-close-line"></i></button>`;
            document.getElementById('toast-area').appendChild(el);
            setTimeout(() => {
                el.style.cssText += ';opacity:0;transform:translateX(60px);transition:all .3s';
                setTimeout(() => el.remove(), 300)
            }, dur);
        }

        // ============================================================
        // DASHBOARD
        // ============================================================
        let dashChart = null;

        function initDash() {
            const h = new Date().getHours();
            document.getElementById('greeting').textContent = h < 12 ? 'Good morning' : h < 17 ? 'Good afternoon' : 'Good evening';
            const rems = getRems();
            const active = rems.filter(r => r.status === 'active');
            const week = active.filter(r => daysUntil(r.dueDate) >= 0 && daysUntil(r.dueDate) <= 7);
            const done = rems.filter(r => r.status === 'completed');
            const over = active.filter(r => daysUntil(r.dueDate) < 0);
            document.getElementById('s-active').textContent = active.length;
            document.getElementById('s-week').textContent = week.length;
            document.getElementById('s-done').textContent = done.length;
            document.getElementById('s-over').textContent = over.length;
            document.getElementById('dash-summary').textContent = week.length > 0 ? `You have ${week.length} reminder${week.length>1?'s':''} due this week.` : 'No reminders due this week — great job! 🎉';
            const up = active.sort((a, b) => new Date(a.dueDate) - new Date(b.dueDate)).slice(0, 5);
            const ul = document.getElementById('dash-list');
            ul.innerHTML = up.length === 0 ? '<div style="text-align:center;padding:30px;color:#475569;font-size:.83rem">No upcoming reminders</div>' : up.map(r => remCardHTML(r, true)).join('');
            initDashChart();
        }

        function initDashChart() {
            const cv = document.getElementById('dash-chart');
            if (!cv) return;
            if (dashChart) {
                dashChart.destroy();
                dashChart = null;
            }
            const isDark = document.documentElement.classList.contains('dark');
            const tc = isDark ? 'rgba(255,255,255,.3)' : 'rgba(0,0,0,.4)';
            const gc = isDark ? 'rgba(255,255,255,.05)' : 'rgba(0,0,0,.05)';
            const labels = [];
            const data = [];
            for (let i = 29; i >= 0; i--) {
                const d = new Date();
                d.setDate(d.getDate() - i);
                labels.push(i % 7 === 0 ? d.toLocaleDateString('en-GB', {
                    day: 'numeric',
                    month: 'short'
                }) : '');
                data.push(Math.floor(Math.random() * 8));
            }
            dashChart = new Chart(cv, {
                type: 'line',
                data: {
                    labels,
                    datasets: [{
                        data,
                        borderColor: '#7c3aed',
                        backgroundColor: 'rgba(124,58,237,.12)',
                        fill: true,
                        tension: .45,
                        pointRadius: 0,
                        pointHoverRadius: 4,
                        pointBackgroundColor: '#7c3aed'
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: gc
                            },
                            ticks: {
                                color: tc,
                                font: {
                                    family: 'DM Sans',
                                    size: 10
                                }
                            }
                        },
                        y: {
                            grid: {
                                color: gc
                            },
                            ticks: {
                                color: tc,
                                font: {
                                    family: 'DM Sans',
                                    size: 10
                                },
                                stepSize: 2
                            }
                        }
                    },
                    maintainAspectRatio: false
                }
            });
        }

        // ============================================================
        // REMINDER CARDS
        // ============================================================
        function remCardHTML(r, compact = false) {
            const cat = CATS[r.category] || {
                name: r.category,
                icon: 'ri-alarm-line',
                color: '#94a3b8',
                bg: 'rgba(148,163,184,.12)'
            };
            const dp = duePill(r.dueDate);
            const doneBadge = r.status === 'completed' ? '<span class="pill-done">Completed</span>' : '';
            return `<div class="rem-card group" onclick="viewDetail('${r.id}')">
    <div class="cat-ico" style="background:${cat.bg}"><i class="${cat.icon}" style="color:${cat.color}"></i></div>
    <div style="flex:1;min-width:0">
      <div style="font-size:.87rem;font-weight:600;color:#f1f5f9;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${r.title}</div>
      <div style="font-size:.75rem;color:#64748b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${cat.name} → ${r.subcategory}${r.provider?' · '+r.provider:''}${r.cost?' · £'+r.cost:''}</div>
    </div>
    ${r.status==='completed'?doneBadge:dp}
    ${!compact?`<div style="display:flex;gap:6px;flex-shrink:0" onclick="event.stopPropagation()">
      <button class="btn btn-ghost btn-xs" onclick="openReminderModal()" title="Edit"><i class="ri-pencil-line"></i></button>
      <button class="btn btn-ghost btn-xs" onclick="openModal('share-modal')" title="Share"><i class="ri-share-line"></i></button>
      ${r.status==='active'?`<button class="btn btn-teal btn-xs" onclick="markDone('${r.id}')" title="Complete"><i class="ri-check-line"></i></button>`:''}
      <button class="btn btn-danger btn-xs" onclick="deleteRem('${r.id}')" title="Delete"><i class="ri-delete-bin-line"></i></button>
    </div>`:''}
  </div>`;
        }

        function gridCardHTML(r) {
            const cat = CATS[r.category] || {
                name: r.category,
                icon: 'ri-alarm-line',
                color: '#94a3b8',
                bg: 'rgba(148,163,184,.12)'
            };
            const dp = r.status === 'completed' ? '<span class="pill-done">Completed</span>' : duePill(r.dueDate);
            return `<div class="card" style="padding:16px;cursor:pointer;transition:all .2s" onclick="viewDetail('${r.id}')">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:12px"><div class="cat-ico" style="background:${cat.bg}"><i class="${cat.icon}" style="color:${cat.color}"></i></div>${dp}</div>
    <div style="font-weight:600;font-size:.87rem;color:#f1f5f9;margin-bottom:4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${r.title}</div>
    <div style="font-size:.75rem;color:#64748b;margin-bottom:6px">${cat.name} → ${r.subcategory}</div>
    <div style="font-size:.75rem;color:#64748b;margin-bottom:${r.cost?'6':'12'}px"><i class="ri-calendar-line"></i> ${fmtDate(r.dueDate)} at ${r.dueTime||'09:00'}</div>
    ${r.cost?`<div style="font-weight:700;font-size:.85rem;color:#f1f5f9;margin-bottom:12px">£${r.cost}${r.frequency?' / '+r.frequency:''}</div>`:''}
    <div style="display:flex;gap:8px" onclick="event.stopPropagation()">
      <button class="btn btn-ghost btn-xs" style="flex:1;justify-content:center" onclick="openReminderModal()"><i class="ri-pencil-line"></i> Edit</button>
      ${r.status==='active'?`<button class="btn btn-teal btn-xs" onclick="markDone('${r.id}')"><i class="ri-check-line"></i></button>`:''}
      <button class="btn btn-danger btn-xs" onclick="deleteRem('${r.id}')"><i class="ri-delete-bin-line"></i></button>
    </div>
  </div>`;
        }

        function viewDetail(id) {
            const r = getRems().find(x => x.id === id);
            if (!r) return;
            const cat = CATS[r.category] || {
                name: r.category,
                icon: 'ri-alarm-line',
                color: '#94a3b8',
                bg: 'rgba(148,163,184,.12)'
            };
            const dp = r.status === 'completed' ? '<span class="pill-done">Completed</span>' : duePill(r.dueDate);
            document.getElementById('detail-content').innerHTML = `
    <div style="text-align:center;margin-bottom:20px">
      <div class="cat-ico" style="background:${cat.bg};width:56px;height:56px;border-radius:16px;margin:0 auto 10px"><i class="${cat.icon}" style="color:${cat.color};font-size:1.5rem"></i></div>
      <h2 class="font-jakarta" style="font-weight:700;font-size:1.05rem;color:#f1f5f9">${r.title}</h2>
      <div style="margin-top:8px">${dp}</div>
    </div>
    <div style="display:flex;flex-direction:column;gap:8px;margin-bottom:20px">
      <div style="display:flex;gap:10px;padding:12px;border-radius:10px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06)"><i class="ri-folder-line" style="color:#2dd4bf;flex-shrink:0;margin-top:2px"></i><div><div style="font-size:.73rem;color:#64748b">Category</div><div style="font-size:.87rem;font-weight:600;color:#94a3b8">${cat.name} → ${r.subcategory}</div></div></div>
      <div style="display:flex;gap:10px;padding:12px;border-radius:10px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06)"><i class="ri-calendar-line" style="color:#10b981;flex-shrink:0;margin-top:2px"></i><div><div style="font-size:.73rem;color:#64748b">Date & Time</div><div style="font-size:.87rem;font-weight:600;color:#94a3b8">${fmtDate(r.dueDate)} at ${r.dueTime||'09:00'}</div></div></div>
      ${r.provider?`<div style="display:flex;gap:10px;padding:12px;border-radius:10px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06)"><i class="ri-building-line" style="color:#f59e0b;flex-shrink:0;margin-top:2px"></i><div><div style="font-size:.73rem;color:#64748b">Provider</div><div style="font-size:.87rem;font-weight:600;color:#94a3b8">${r.provider}</div></div></div>`:''}
      ${r.cost?`<div style="display:flex;gap:10px;padding:12px;border-radius:10px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06)"><i class="ri-money-pound-circle-line" style="color:#10b981;flex-shrink:0;margin-top:2px"></i><div><div style="font-size:.73rem;color:#64748b">Cost</div><div style="font-size:.87rem;font-weight:600;color:#94a3b8">£${r.cost}${r.frequency?' / '+r.frequency:''}</div></div></div>`:''}
      ${r.description?`<div style="padding:12px;border-radius:10px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06)"><div style="font-size:.73rem;color:#64748b;margin-bottom:4px">Description</div><div style="font-size:.84rem;color:#64748b;line-height:1.6">${r.description}</div></div>`:''}
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap">
      <button class="btn btn-primary" style="flex:1;justify-content:center" onclick="closeModal('detail-modal');openReminderModal()"><i class="ri-pencil-line"></i> Edit</button>
      <button class="btn btn-ghost" onclick="openModal('share-modal')"><i class="ri-share-line"></i> Share</button>
      ${r.status==='active'?`<button class="btn btn-teal" onclick="markDone('${r.id}');closeModal('detail-modal')"><i class="ri-check-line"></i> Done</button>`:''}
    </div>`;
            openModal('detail-modal');
        }

        function markDone(id) {
            const rems = getRems();
            const i = rems.findIndex(r => r.id === id);
            if (i < 0) return;
            rems[i].status = 'completed';
            rems[i].completedAt = new Date().toISOString();
            saveRems(rems);
            if (curPage === 'reminders') loadReminders();
            if (curPage === 'dashboard') initDash();
            toast('Reminder marked as completed! ✓', 'success');
        }

        function deleteRem(id) {
            confirm_act('Delete this reminder? This cannot be undone.', () => {
                saveRems(getRems().filter(r => r.id !== id));
                if (curPage === 'reminders') loadReminders();
                if (curPage === 'dashboard') initDash();
                toast('Reminder deleted', 'success');
            });
        }

        function editReminder(id) {
            editingId = id;
            go('create');
        }

        // ============================================================
        // REMINDERS PAGE
        // ============================================================
        function populateCatFilter() {
            const sel = document.getElementById('rem-cat');
            if (!sel || sel.children.length > 1) return;
            Object.entries(CATS).forEach(([k, c]) => {
                const o = document.createElement('option');
                o.value = k;
                o.textContent = c.name;
                sel.appendChild(o)
            });
        }
        let remView = 'list';

        function setView(v) {
            remView = v;
            document.getElementById('vl').classList.toggle('active', v === 'list');
            document.getElementById('vg').classList.toggle('active', v === 'grid');
            loadReminders();
        }

        function resetFilters() {
            document.getElementById('rem-search').value = '';
            document.getElementById('rem-cat').value = 'all';
            document.getElementById('rem-status').value = 'all';
            document.getElementById('rem-sort').value = 'date-asc';
            loadReminders();
        }

        function loadReminders() {
            let rems = getRems();
            const q = (document.getElementById('rem-search')?.value || '').toLowerCase().trim();
            const cat = document.getElementById('rem-cat')?.value || 'all';
            const st = document.getElementById('rem-status')?.value || 'all';
            const sort = document.getElementById('rem-sort')?.value || 'date-asc';
            if (q) rems = rems.filter(r => (r.title + ' ' + (r.provider || '') + ' ' + (r.description || '')).toLowerCase().includes(q));
            if (cat !== 'all') rems = rems.filter(r => r.category === cat);
            if (st === 'active') rems = rems.filter(r => r.status === 'active');
            else if (st === 'completed') rems = rems.filter(r => r.status === 'completed');
            else if (st === 'upcoming') rems = rems.filter(r => r.status === 'active' && daysUntil(r.dueDate) >= 0 && daysUntil(r.dueDate) <= 30);
            else if (st === 'expired') rems = rems.filter(r => r.status === 'active' && daysUntil(r.dueDate) < 0);
            const [sf, so] = sort.split('-');
            rems.sort((a, b) => {
                let av = sf === 'title' ? a.title.toLowerCase() : sf === 'created' ? new Date(a.createdAt) : new Date(a.dueDate);
                let bv = sf === 'title' ? b.title.toLowerCase() : sf === 'created' ? new Date(b.createdAt) : new Date(b.dueDate);
                return so === 'asc' ? (av > bv ? 1 : -1) : (av < bv ? 1 : -1)
            });
            const all = getRems();
            const active = all.filter(r => r.status === 'active');
            document.getElementById('rem-display-count').textContent = rems.length;
            document.getElementById('rem-count-label').textContent = `${active.length} active · ${all.length} total`;
            const rl = document.getElementById('rem-list'),
                rg = document.getElementById('rem-grid'),
                re = document.getElementById('rem-empty');
            if (rems.length === 0) {
                rl.style.display = 'none';
                rg.style.display = 'none';
                re.style.display = 'block';
                return;
            }
            re.style.display = 'none';
            if (remView === 'list') {
                rl.style.display = 'flex';
                rg.style.display = 'none';
                rl.innerHTML = rems.map(r => remCardHTML(r, false)).join('');
            } else {
                rl.style.display = 'none';
                rg.style.display = 'grid';
                rg.innerHTML = rems.map(r => gridCardHTML(r)).join('');
            }
        }

        // ============================================================
        // CREATE REMINDER
        // ============================================================
        function initCreate() {
            const cs = document.getElementById('r-cat');
            cs.innerHTML = '<option value="">Select category…</option>';
            Object.entries(CATS).forEach(([k, c]) => {
                const o = document.createElement('option');
                o.value = k;
                o.textContent = c.name;
                cs.appendChild(o)
            });
            if (editingId) {
                const r = getRems().find(x => x.id === editingId);
                if (!r) {
                    editingId = null;
                    return;
                }
                document.getElementById('create-title').textContent = 'Edit Reminder';
                document.getElementById('create-btn-txt').textContent = 'Save Changes';
                document.getElementById('r-title').value = r.title;
                document.getElementById('r-cat').value = r.category;
                updateSubs();
                setTimeout(() => {
                    document.getElementById('r-sub').value = r.subcategory;
                }, 60);
                document.getElementById('r-date').value = r.dueDate;
                document.getElementById('r-time').value = r.dueTime || '09:00';
                document.getElementById('r-desc').value = r.description || '';
                document.getElementById('desc-len').textContent = (r.description || '').length;
                if (r.category !== 'special-days' && r.category !== 'others') {
                    document.getElementById('opt-fields').style.display = 'block';
                    document.getElementById('r-provider').value = r.provider || '';
                    document.getElementById('r-cost').value = r.cost || '';
                    document.getElementById('r-freq').value = r.frequency || '';
                }
            } else {
                document.getElementById('create-title').textContent = 'Create New Reminder';
                document.getElementById('create-btn-txt').textContent = 'Create Reminder';
                document.getElementById('rem-form').reset();
                document.getElementById('desc-len').textContent = '0';
                document.getElementById('r-sub').disabled = true;
                document.getElementById('opt-fields').style.display = 'none';
            }
        }

        function updateSubs() {
            const cat = document.getElementById('r-cat').value;
            const sub = document.getElementById('r-sub');
            sub.innerHTML = '<option value="">Select subcategory…</option>';
            if (cat && CATS[cat]) {
                // Built-in subs
                CATS[cat].subs.forEach(s => {
                    const o = document.createElement('option');
                    o.value = s;
                    o.textContent = s;
                    sub.appendChild(o)
                });
                // Custom subs for this category
                customSubs.filter(cs => cs.parent === cat).forEach(cs => {
                    const o = document.createElement('option');
                    o.value = cs.name;
                    o.textContent = cs.name + ' (Custom)';
                    sub.appendChild(o)
                });
                sub.disabled = false;
                document.getElementById('opt-fields').style.display = (cat !== 'special-days' && cat !== 'others') ? 'block' : 'none';
            } else {
                sub.disabled = true;
                document.getElementById('opt-fields').style.display = 'none';
            }
        }

        function submitReminder(e) {
            e.preventDefault();
            const title = document.getElementById('r-title').value.trim();
            const cat = document.getElementById('r-cat').value;
            const sub = document.getElementById('r-sub').value;
            const date = document.getElementById('r-date').value;
            const time = document.getElementById('r-time').value;
            if (title.length < 3) {
                toast('Title must be at least 3 characters', 'error');
                return;
            }
            if (!cat) {
                toast('Please select a category', 'error');
                return;
            }
            if (!sub) {
                toast('Please select a subcategory', 'error');
                return;
            }
            if (!date) {
                toast('Please select a Date', 'error');
                return;
            }
            const data = {
                title,
                category: cat,
                subcategory: sub,
                dueDate: date,
                dueTime: time,
                description: document.getElementById('r-desc').value.trim(),
                provider: document.getElementById('r-provider')?.value.trim() || '',
                cost: document.getElementById('r-cost')?.value ? parseFloat(document.getElementById('r-cost').value) : null,
                frequency: document.getElementById('r-freq')?.value || '',
                status: 'active'
            };
            const rems = getRems();
            if (editingId) {
                const i = rems.findIndex(r => r.id === editingId);
                if (i >= 0) {
                    rems[i] = {
                        ...rems[i],
                        ...data,
                        updatedAt: new Date().toISOString()
                    };
                    saveRems(rems);
                    toast('Reminder updated!', 'success');
                    editingId = null;
                    go('reminders');
                    return;
                }
            }
            rems.push({
                id: gid(),
                ...data,
                createdAt: new Date().toISOString()
            });
            saveRems(rems);
            toast('Reminder created! 🎉', 'success');
            editingId = null;
            go('reminders');
        }

        function cancelCreate() {
            if (editingId) {
                editingId = null;
                go('reminders');
            } else confirm_act('Discard and go back to reminders?', () => go('reminders'));
        }

        // ============================================================
        // CALENDAR
        // ============================================================
        const MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        const CAT_HEX = {
            'special-days': 'rgba(251,191,36,.6)',
            'home': 'rgba(20,184,166,.5)',
            'insurance': 'rgba(244,63,94,.5)',
            'tv-telephone-mobile': 'rgba(20,184,166,.4)',
            'motor-vehicle': 'rgba(167,139,250,.5)',
            'travel': 'rgba(236,72,153,.5)',
            'subscriptions': 'rgba(94,234,212,.5)',
            'pet-care': 'rgba(16,185,129,.4)',
            'health': 'rgba(16,185,129,.5)',
            'others': 'rgba(148,163,184,.4)'
        };
        let calY, calM;

        function initCalendar() {
            const n = new Date();
            calY = n.getFullYear();
            calM = n.getMonth();
            renderCal();
            renderMonthEvents();
        }

        function prevMonth() {
            calM--;
            if (calM < 0) {
                calM = 11;
                calY--;
            }
            renderCal();
            renderMonthEvents();
        }

        function nextMonth() {
            calM++;
            if (calM > 11) {
                calM = 0;
                calY++;
            }
            renderCal();
            renderMonthEvents();
        }

        function goToday() {
            const n = new Date();
            calY = n.getFullYear();
            calM = n.getMonth();
            renderCal();
            renderMonthEvents();
        }

        function getRemsDate(ds) {
            return getRems().filter(r => r.dueDate === ds);
        }

        function getRemsMonth(y, m) {
            return getRems().filter(r => {
                const d = new Date(r.dueDate);
                return d.getFullYear() === y && d.getMonth() === m;
            });
        }

        function renderCal() {
            document.getElementById('cal-label').textContent = `${MONTHS[calM]} ${calY}`;
            const grid = document.getElementById('cal-grid');
            grid.innerHTML = '';
            const first = new Date(calY, calM, 1).getDay();
            const days = new Date(calY, calM + 1, 0).getDate();
            const tod = new Date();
            const toStr = `${tod.getFullYear()}-${pad(tod.getMonth()+1)}-${pad(tod.getDate())}`;
            for (let i = 0; i < first; i++) {
                const c = document.createElement('div');
                c.className = 'cal-cell cal-empty';
                grid.appendChild(c);
            }
            for (let d = 1; d <= days; d++) {
                const ds = `${calY}-${pad(calM+1)}-${pad(d)}`;
                const rems = getRemsDate(ds);
                const isToday = ds === toStr;
                const c = document.createElement('div');
                c.className = 'cal-cell' + (isToday ? ' cal-today' : '');
                c.onclick = () => selectDay(d);
                let dots = rems.slice(0, 3).map(r => `<div class="ev-dot" style="background:${CAT_HEX[r.category]||'rgba(148,163,184,.4)'};">${r.title.substring(0,12)}</div>`).join('');
                if (rems.length > 3) dots += `<div style="font-size:.58rem;color:#94a3b8">+${rems.length-3} more</div>`;
                c.innerHTML = `<div style="font-size:.73rem;font-weight:700;margin-bottom:3px">${d}</div>${dots}`;
                grid.appendChild(c);
            }
        }

        function renderMonthEvents() {
            const rems = getRemsMonth(calY, calM).sort((a, b) => new Date(a.dueDate) - new Date(b.dueDate));
            document.getElementById('month-ev-cnt').textContent = `${rems.length} Events`;
            const list = document.getElementById('month-events');
            list.innerHTML = rems.length === 0 ? '<div style="text-align:center;padding:30px;color:#475569;font-size:.82rem">No events this month</div>' : rems.map(r => {
                const cat = CATS[r.category] || {
                    icon: 'ri-alarm-line',
                    color: '#94a3b8',
                    bg: 'rgba(148,163,184,.12)'
                };
                const dp = r.status === 'completed' ? '<span class="pill-done" style="font-size:.6rem">Done</span>' : duePill(r.dueDate);
                return `<div style="display:flex;align-items:center;gap:8px;padding:8px;border-radius:10px;cursor:pointer;background:rgba(255,255,255,.02);border:1px solid rgba(255,255,255,.04)" onclick="selectDayFR('${r.dueDate}')">
      <div style="width:30px;height:30px;border-radius:8px;display:flex;align-items:center;justify-content:center;background:${cat.bg};flex-shrink:0"><i class="${cat.icon}" style="color:${cat.color};font-size:.8rem"></i></div>
      <div style="flex:1;min-width:0"><div style="font-size:.78rem;font-weight:600;color:#94a3b8;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${r.title}</div><div style="font-size:.68rem;color:#64748b">${fmtDate(r.dueDate)}</div></div>${dp}
    </div>`;
            }).join('');
        }

        function selectDay(d) {
            const ds = `${calY}-${pad(calM+1)}-${pad(d)}`;
            const rems = getRemsDate(ds);
            document.getElementById('sel-day-title').textContent = `${d} ${MONTHS[calM]} ${calY}`;
            const ev = document.getElementById('sel-day-events');
            if (rems.length === 0) {
                ev.innerHTML = `<div style="text-align:center;padding:30px"><div style="font-size:2rem;color:rgba(255,255,255,.1);margin-bottom:8px"><i class="ri-calendar-check-line"></i></div><p style="font-size:.82rem;color:#475569;margin-bottom:12px">No reminders on this day</p><button class="btn btn-primary btn-sm" onclick="openReminderModal()"><i class="ri-add-line"></i> Add</button></div>`;
                return;
            }
            ev.innerHTML = rems.map(r => {
                const cat = CATS[r.category] || {
                    icon: 'ri-alarm-line',
                    color: '#94a3b8',
                    bg: 'rgba(148,163,184,.12)'
                };
                const dp = r.status === 'completed' ? '<span class="pill-done">Done</span>' : duePill(r.dueDate);
                return `<div style="padding:12px;border-radius:10px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06);margin-bottom:8px">
    <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px">
      <div style="width:28px;height:28px;border-radius:7px;display:flex;align-items:center;justify-content:center;background:${cat.bg};flex-shrink:0"><i class="${cat.icon}" style="color:${cat.color};font-size:.8rem"></i></div>
      <div style="flex:1;min-width:0"><div style="font-size:.85rem;font-weight:600;color:#f1f5f9;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${r.title}</div><div style="font-size:.72rem;color:#64748b">${r.dueTime||'09:00'}</div></div>${dp}
    </div>
    ${r.provider?`<div style="font-size:.75rem;color:#64748b;margin-bottom:4px"><i class="ri-building-line"></i> ${r.provider}</div>`:''}
    <button class="btn btn-ghost btn-xs" style="margin-top:4px" onclick="openReminderModal()"><i class="ri-pencil-line"></i> Edit</button>
  </div>`;
            }).join('');
        }

        function selectDayFR(ds) {
            const p = ds.split('-');
            selectDay(parseInt(p[2]));
        }

        // ============================================================
        // TEMPLATES
        // ============================================================
        function renderTemplates() {
            const q = (document.getElementById('tmpl-search')?.value || '').toLowerCase();
            const cf = document.getElementById('tmpl-cat')?.value || '';
            let items = TEMPLATES.filter(t => (!q || t.title.toLowerCase().includes(q)) && (!cf || t.cat === cf));
            const pop = items.filter(t => t.pop >= 150),
                rest = items.filter(t => t.pop < 150);
            let html = '';
            if (pop.length) html += `<div style="margin-bottom:22px"><div style="display:flex;align-items:center;gap:8px;margin-bottom:10px"><i class="ri-fire-fill" style="color:#f43f5e"></i><h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9">Popular Templates</h3></div><div style="display:flex;flex-direction:column;gap:8px">${pop.map(tmplCard).join('')}</div></div>`;
            if (rest.length) html += `<div><div style="display:flex;align-items:center;gap:8px;margin-bottom:10px"><i class="ri-file-list-3-line" style="color:#a78bfa"></i><h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9">All Templates</h3></div><div style="display:flex;flex-direction:column;gap:8px">${rest.map(tmplCard).join('')}</div></div>`;
            if (!html) html = '<div style="text-align:center;padding:50px;color:#475569">No templates found for your search</div>';
            document.getElementById('tmpl-container').innerHTML = html;
        }

        function tmplCard(t) {
            return `<div class="tmpl-card" onclick="useTemplate('${t.id}')">
    <div class="cat-ico" style="background:${t.bg}"><i class="${t.icon}" style="color:${t.col}"></i></div>
    <div style="flex:1"><div style="font-weight:600;font-size:.87rem;color:#f1f5f9">${t.title}</div><div style="font-size:.75rem;color:#64748b;margin-top:2px">${CATS[t.cat]?.name||t.cat}${t.freq?' · '+t.freq:''}</div></div>
    <div style="font-size:.75rem;color:#64748b;flex-shrink:0"><i class="ri-fire-line" style="color:#f59e0b"></i> ${t.pop}</div>
    <i class="ri-arrow-right-circle-line" style="color:rgba(100,116,139,.4);flex-shrink:0"></i>
  </div>`;
        }

        function filterTemplates() {
            renderTemplates();
        }

        function useTemplate(id) {
            const t = TEMPLATES.find(x => x.id === id);
            if (!t) return;
            editingId = null;
            go('create');
            setTimeout(() => {
                document.getElementById('r-title').value = t.title;
                document.getElementById('r-cat').value = t.cat;
                updateSubs();
                setTimeout(() => {
                    document.getElementById('r-sub').value = t.sub;
                    if (t.freq) document.getElementById('r-freq').value = t.freq;
                }, 80);
            }, 60);
            toast('Template loaded!', 'success');
        }

        // ============================================================
        // CATEGORIES
        // ============================================================
        function renderCategories() {
            updateCustomSubUI();
            const rems = getRems();
            let mostUsed = '—';
            let maxC = 0;
            Object.entries(CATS).forEach(([k]) => {
                const cnt = rems.filter(r => r.category === k).length;
                if (cnt > maxC) {
                    maxC = cnt;
                    mostUsed = CATS[k].name;
                }
            });
            document.getElementById('most-used-cat').textContent = mostUsed;
            const grid = document.getElementById('cat-grid');
            grid.innerHTML = '';
            Object.entries(CATS).forEach(([k, c]) => {
                const count = rems.filter(r => r.category === k).length;
                const total = Math.max(rems.length, 1);
                const pct = Math.min((count / total) * 100 * 5, 100);
                const div = document.createElement('div');
                div.className = 'cat-card';
                div.onclick = () => expandCat(k);
                div.innerHTML = `<div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:12px">
      <div style="display:flex;align-items:center;gap:10px">
        <div class="cat-ico" style="background:${c.bg}"><i class="${c.icon}" style="color:${c.color}"></i></div>
        <div><div class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9">${c.name}</div><div style="font-size:.72rem;color:#64748b">${c.subs.length} subcategories</div></div>
      </div>
      <button class="btn btn-ghost btn-xs" onclick="event.stopPropagation();document.getElementById('sub-cat-parent').value='${k}';openModal('add-sub-modal')"><i class="ri-add-line"></i></button>
    </div>
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px"><span style="font-size:.73rem;color:#64748b">Reminders</span><span style="font-weight:700;font-size:.87rem;color:#f1f5f9">${count}</span></div>
    <div class="prog-track"><div class="prog-fill" style="width:${pct}%"></div></div>`;
                grid.appendChild(div);
            });
        }

        function updateCustomSubUI() {
            document.getElementById('custom-sub-count').textContent = customSubs.length;
            document.getElementById('custom-sub-badge').textContent = customSubs.length + ' Custom';
            const list = document.getElementById('custom-sub-list');
            if (customSubs.length === 0) {
                list.innerHTML = '<div style="text-align:center;padding:24px;color:#475569;font-size:.82rem">No custom subcategories yet. Add one above!</div>';
                return;
            }
            list.innerHTML = customSubs.map((cs, i) => `<div style="display:flex;align-items:center;justify-content:space-between;padding:11px 12px;border-radius:10px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06)">
    <div style="display:flex;align-items:center;gap:10px">
      <div style="width:30px;height:30px;border-radius:8px;background:${CATS[cs.parent]?.bg||'rgba(148,163,184,.12)'};display:flex;align-items:center;justify-content:center"><i class="${CATS[cs.parent]?.icon||'ri-folder-line'}" style="color:${CATS[cs.parent]?.color||'#94a3b8'};font-size:.85rem"></i></div>
      <div><div style="font-size:.85rem;font-weight:600;color:#94a3b8">${cs.name}</div><div style="font-size:.73rem;color:#64748b">${CATS[cs.parent]?.name||cs.parent}${cs.desc?' · '+cs.desc:''}</div></div>
    </div>
    <div style="display:flex;gap:6px">
      <button class="btn btn-ghost btn-xs" onclick="toast('Edit mode coming soon','info')"><i class="ri-pencil-line"></i></button>
      <button class="btn btn-danger btn-xs" onclick="deleteCustomSub(${i})"><i class="ri-delete-bin-line"></i></button>
    </div>
  </div>`).join('');
        }

        function saveSubcat() {
            const parent = document.getElementById('sub-cat-parent').value;
            const name = document.getElementById('sub-cat-name').value.trim();
            const desc = document.getElementById('sub-cat-desc').value.trim();
            if (!parent) {
                toast('Please select a parent category', 'error');
                return;
            }
            if (name.length < 3) {
                toast('Name must be at least 3 characters', 'error');
                return;
            }
            if (name.length > 50) {
                toast('Name must be 50 characters or less', 'error');
                return;
            }
            // Check for duplicate
            const allSubs = [...CATS[parent]?.subs || [], ...customSubs.filter(cs => cs.parent === parent).map(cs => cs.name)];
            if (allSubs.some(s => s.toLowerCase() === name.toLowerCase())) {
                toast('A subcategory with this name already exists', 'error');
                return;
            }
            customSubs.push({
                parent,
                name,
                desc,
                createdAt: new Date().toISOString()
            });
            S.set('custom_subs', customSubs);
            toast(`Subcategory "${name}" added successfully!`, 'success');
            closeModal('add-sub-modal');
            document.getElementById('sub-cat-parent').value = '';
            document.getElementById('sub-cat-name').value = '';
            document.getElementById('sub-cat-desc').value = '';
            if (curPage === 'categories') renderCategories();
        }

        function deleteCustomSub(idx) {
            confirm_act('Delete this custom subcategory?', () => {
                customSubs.splice(idx, 1);
                S.set('custom_subs', customSubs);
                updateCustomSubUI();
                toast('Subcategory deleted', 'success');
            });
        }

        function expandCat(k) {
            const c = CATS[k];
            if (!c) return;
            const rems = getRems().filter(r => r.category === k);
            const html = rems.length === 0 ? '<div style="text-align:center;padding:24px;color:#475569;font-size:.82rem">No reminders in this category</div>' : rems.map(r => {
                const dp = r.status === 'completed' ? '<span class="pill-done" style="font-size:.65rem">Done</span>' : duePill(r.dueDate);
                return `<div style="display:flex;align-items:center;gap:10px;padding:10px;border-radius:10px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.05);margin-bottom:6px"><div style="flex:1"><div style="font-size:.87rem;font-weight:600;color:#94a3b8">${r.title}</div><div style="font-size:.75rem;color:#64748b">${r.subcategory}${r.dueDate?' · '+fmtDate(r.dueDate):''}</div></div>${dp}</div>`;
            }).join('');
            document.getElementById('detail-content').innerHTML = `<div style="display:flex;align-items:center;gap:12px;margin-bottom:16px"><div class="cat-ico" style="background:${c.bg}"><i class="${c.icon}" style="color:${c.color}"></i></div><div><div class="font-jakarta" style="font-weight:700;font-size:.95rem;color:#f1f5f9">${c.name}</div><div style="font-size:.77rem;color:#64748b">${rems.length} reminder${rems.length!==1?'s':''}</div></div></div>${html}<div style="margin-top:14px"><button class="btn btn-primary" style="width:100%;justify-content:center" onclick="closeModal('detail-modal');go('create')"><i class="ri-add-line"></i> Add Reminder in ${c.name}</button></div>`;
            openModal('detail-modal');
        }

        // ============================================================
        // ANALYTICS CHARTS
        // ============================================================
        let charts = {};

        function initCharts() {
            const pg = document.getElementById('page-analytics');
            if (!pg || !pg.classList.contains('active')) return;
            const isDark = document.documentElement.classList.contains('dark');
            const tc = isDark ? 'rgba(255,255,255,.3)' : 'rgba(0,0,0,.4)';
            const gc = isDark ? 'rgba(255,255,255,.05)' : 'rgba(0,0,0,.05)';
            Object.values(charts).forEach(c => {
                try {
                    c.destroy()
                } catch (e) {}
            });
            charts = {};
            const baseOpts = (extra = {}) => ({
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: tc,
                            font: {
                                family: 'DM Sans',
                                size: 11
                            },
                            boxWidth: 12
                        }
                    }
                },
                ...extra,
                scales: {
                    x: {
                        grid: {
                            color: gc
                        },
                        ticks: {
                            color: tc,
                            font: {
                                family: 'DM Sans',
                                size: 10
                            }
                        }
                    },
                    ...(extra.noY ? {} : {
                        y: {
                            grid: {
                                color: gc
                            },
                            ticks: {
                                color: tc,
                                font: {
                                    family: 'DM Sans',
                                    size: 10
                                }
                            }
                        }
                    })
                }
            });
            const ac = document.getElementById('act-trend-chart');
            if (ac) charts.act = new Chart(ac, {
                type: 'line',
                data: {
                    labels: ['Wk 1', 'Wk 2', 'Wk 3', 'Wk 4'],
                    datasets: [{
                        label: 'Created',
                        data: [5, 8, 4, 7],
                        borderColor: '#7c3aed',
                        backgroundColor: 'rgba(124,58,237,.12)',
                        fill: true,
                        tension: .45,
                        pointRadius: 4,
                        pointBackgroundColor: '#7c3aed'
                    }, {
                        label: 'Completed',
                        data: [3, 7, 4, 6],
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16,185,129,.08)',
                        fill: true,
                        tension: .45,
                        pointRadius: 4,
                        pointBackgroundColor: '#10b981'
                    }]
                },
                options: baseOpts()
            });
            const cc = document.getElementById('cat-dist-chart');
            if (cc) charts.cat = new Chart(cc, {
                type: 'doughnut',
                data: {
                    labels: ['Subscriptions', 'Insurance', 'Motor', 'Health', 'Special Days', 'Others'],
                    datasets: [{
                        data: [12, 8, 6, 7, 8, 6],
                        backgroundColor: ['#14b8a6', '#f43f5e', '#a78bfa', '#10b981', '#f59e0b', '#94a3b8'],
                        borderWidth: 0,
                        hoverOffset: 8
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                color: tc,
                                font: {
                                    family: 'DM Sans',
                                    size: 11
                                },
                                boxWidth: 12,
                                padding: 8
                            }
                        }
                    },
                    cutout: '65%',
                    maintainAspectRatio: false
                }
            });
            const cs = document.getElementById('comp-chart');
            if (cs) charts.comp = new Chart(cs, {
                type: 'doughnut',
                data: {
                    labels: ['Completed', 'Pending'],
                    datasets: [{
                        data: [42, 5],
                        backgroundColor: ['#10b981', '#f43f5e'],
                        borderWidth: 0,
                        hoverOffset: 6
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: tc,
                                font: {
                                    family: 'DM Sans',
                                    size: 11
                                },
                                boxWidth: 12
                            }
                        }
                    },
                    cutout: '60%',
                    maintainAspectRatio: false
                }
            });
            const sc = document.getElementById('spend-chart');
            if (sc) charts.spend = new Chart(sc, {
                type: 'bar',
                data: {
                    labels: ['J', 'F', 'M', 'A', 'M', 'J', 'J', 'A', 'S', 'O', 'N', 'D'],
                    datasets: [{
                        label: '£',
                        data: [120, 95, 140, 180, 110, 95, 130, 160, 145, 120, 200, 340],
                        backgroundColor: 'rgba(124,58,237,.65)',
                        borderRadius: 5,
                        borderSkipped: false
                    }]
                },
                options: {
                    ...baseOpts({
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    })
                }
            });
            renderCatPerfTable();
            renderActivityLog();
        }

        function renderCatPerfTable() {
            const rows = [{
                    name: 'Subscriptions',
                    icon: 'ri-smartphone-line',
                    col: '#14b8a6',
                    bg: 'rgba(20,184,166,.12)',
                    total: 12,
                    done: 11,
                    rate: 92,
                    trend: '+8%',
                    up: true
                },
                {
                    name: 'Insurance',
                    icon: 'ri-shield-line',
                    col: '#f43f5e',
                    bg: 'rgba(244,63,94,.12)',
                    total: 8,
                    done: 7,
                    rate: 88,
                    trend: '+4%',
                    up: true
                },
                {
                    name: 'Motor Vehicle',
                    icon: 'ri-car-line',
                    col: '#a78bfa',
                    bg: 'rgba(167,139,250,.12)',
                    total: 6,
                    done: 5,
                    rate: 83,
                    trend: '0%',
                    up: false
                },
                {
                    name: 'Health',
                    icon: 'ri-heart-pulse-line',
                    col: '#10b981',
                    bg: 'rgba(16,185,129,.12)',
                    total: 7,
                    done: 6,
                    rate: 86,
                    trend: '+12%',
                    up: true
                },
                {
                    name: 'Special Days',
                    icon: 'ri-cake-3-line',
                    col: '#f59e0b',
                    bg: 'rgba(245,158,11,.12)',
                    total: 8,
                    done: 8,
                    rate: 100,
                    trend: '+5%',
                    up: true
                },
            ];
            document.getElementById('cat-perf-table').innerHTML = rows.map(r => `<tr class="tbl-row"><td style="padding:10px 0"><div style="display:flex;align-items:center;gap:8px"><div style="width:28px;height:28px;border-radius:7px;background:${r.bg};display:flex;align-items:center;justify-content:center"><i class="${r.icon}" style="color:${r.col};font-size:.8rem"></i></div><span style="font-size:.84rem;font-weight:600;color:#94a3b8">${r.name}</span></div></td><td style="padding:10px 8px;text-align:center;font-weight:700;color:#f1f5f9">${r.total}</td><td style="padding:10px 8px;text-align:center;color:#10b981">${r.done}</td><td style="padding:10px 8px;text-align:center"><div style="display:flex;align-items:center;gap:6px;justify-content:center"><div style="width:50px;height:5px;border-radius:99px;background:rgba(255,255,255,.08);overflow:hidden"><div style="height:100%;border-radius:99px;background:#10b981;width:${r.rate}%"></div></div><span style="font-size:.77rem;font-weight:700;color:#10b981">${r.rate}%</span></div></td><td style="padding:10px 0;text-align:center;font-size:.77rem;font-weight:700;color:${r.up?'#10b981':'#64748b'}">${r.up?'↑':'–'} ${r.trend}</td></tr>`).join('');
        }

        function renderActivityLog() {
            const acts = [{
                    icon: 'ri-check-line',
                    bg: 'rgba(16,185,129,.12)',
                    col: '#10b981',
                    title: 'Completed Reminder',
                    desc: 'Marked "Gym Membership Renewal" as complete',
                    time: 'Today at 14:32'
                },
                {
                    icon: 'ri-add-circle-line',
                    bg: 'rgba(20,184,166,.12)',
                    col: '#14b8a6',
                    title: 'Created New Reminder',
                    desc: 'Added "Passport Renewal" to Travel category',
                    time: 'Today at 10:15'
                },
                {
                    icon: 'ri-share-line',
                    bg: 'rgba(167,139,250,.12)',
                    col: '#a78bfa',
                    title: 'Shared Reminder',
                    desc: "Shared \"Mum's Birthday\" via WhatsApp with 5 people",
                    time: 'Yesterday at 16:45'
                },
                {
                    icon: 'ri-pencil-line',
                    bg: 'rgba(245,158,11,.12)',
                    col: '#f59e0b',
                    title: 'Updated Reminder',
                    desc: 'Modified "Car Insurance Renewal" Date',
                    time: '2 days ago'
                },
            ];
            document.getElementById('activity-log').innerHTML = acts.map(a => `<div class="act-item" style="display:flex;align-items:flex-start;gap:10px"><div style="width:34px;height:34px;border-radius:10px;background:${a.bg};display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="${a.icon}" style="color:${a.col}"></i></div><div><div style="font-size:.85rem;font-weight:600;color:#f1f5f9">${a.title}</div><div style="font-size:.77rem;color:#64748b;margin-top:2px">${a.desc}</div><div style="font-size:.72rem;color:#475569;margin-top:4px"><i class="ri-time-line"></i> ${a.time}</div></div></div>`).join('');
        }

        function setPeriod(btn) {
            document.querySelectorAll('.period-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            toast(`Showing: ${btn.textContent}`, 'info', 1800);
        }

        // ============================================================
        // HELP
        // ============================================================
        function renderFAQs(q = '') {
            const cats = [...new Set(FAQS.map(f => f.cat))];
            let html = '';
            cats.forEach(cat => {
                const items = FAQS.filter(f => f.cat === cat && (!q || (f.q + f.a).toLowerCase().includes(q.toLowerCase())));
                if (!items.length) return;
                html += `<div style="display:inline-flex;align-items:center;padding:3px 10px;border-radius:6px;background:rgba(124,58,237,.1);border:1px solid rgba(124,58,237,.2);margin:12px 0 6px"><span style="font-size:.63rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#a78bfa">${cat}</span></div>`;
                items.forEach((f, i) => {
                    html += `<div class="faq-item"><div class="faq-q" onclick="toggleFaq(this)"><div style="display:flex;align-items:center;gap:8px;flex:1"><i class="ri-question-line" style="color:#a78bfa;flex-shrink:0"></i>${f.q}</div><i class="ri-arrow-down-s-line faq-arrow" style="color:#64748b"></i></div><div class="faq-ans">${f.a}</div></div>`;
                });
            });
            document.getElementById('faq-container').innerHTML = html || '<div style="text-align:center;padding:30px;color:#475569;font-size:.82rem">No results found for your search</div>';
        }

        function toggleFaq(el) {
            const item = el.closest('.faq-item');
            const isOpen = item.classList.contains('open');
            document.querySelectorAll('.faq-item.open').forEach(x => x.classList.remove('open'));
            if (!isOpen) item.classList.add('open');
        }

        function filterFaq(v) {
            renderFAQs(v);
        }

        // ============================================================
        // SHARED
        // ============================================================
        function renderShared() {
            const rems = getRems().filter(r => r.status === 'active').slice(0, 5);
            document.getElementById('shared-by-me-cnt').textContent = rems.length;
            document.getElementById('shared-by-me-list').innerHTML = rems.length === 0 ? '<div style="text-align:center;padding:40px;color:#475569;font-size:.82rem">No shared reminders yet</div>' : rems.map(r => {
                const cat = CATS[r.category] || {
                    icon: 'ri-alarm-line',
                    color: '#94a3b8',
                    bg: 'rgba(148,163,184,.12)',
                    name: r.category
                };
                return `<div class="card" style="padding:16px">
      <div style="display:flex;align-items:flex-start;gap:12px">
        <div class="cat-ico" style="background:${cat.bg};flex-shrink:0"><i class="${cat.icon}" style="color:${cat.color}"></i></div>
        <div style="flex:1;min-width:0">
          <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-bottom:4px"><div class="font-jakarta" style="font-weight:600;font-size:.9rem;color:#f1f5f9">${r.title}</div></div>
          <div style="font-size:.77rem;color:#64748b;margin-bottom:10px">${cat.name} · ${fmtDate(r.dueDate)}</div>
          <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px"><span style="font-size:.75rem;color:#64748b">Shared with:</span><div style="display:flex;gap:4px"><div class="sav">SM</div><div class="sav">JW</div><div class="sav">EW</div></div></div>
          <div style="display:flex;gap:6px;flex-wrap:wrap">
            <button class="btn btn-ghost btn-xs" onclick="openModal('share-modal')"><i class="ri-share-forward-line"></i> Share Again</button>
            <button class="btn btn-danger btn-xs" onclick="toast('Share access revoked','info')"><i class="ri-close-circle-line"></i> Revoke</button>
          </div>
        </div>
        <div style="text-align:right;flex-shrink:0"><div style="font-size:.7rem;color:#64748b">Shared</div><div style="font-size:.75rem;font-weight:600;color:#64748b">Apr 12</div><div style="font-size:.72rem;color:#10b981;margin-top:2px"><i class="ri-checkbox-circle-fill"></i> Active</div></div>
      </div>
    </div>`;
            }).join('');
        }

        // ============================================================
        // TAB SYSTEM
        // ============================================================
        function swTab(group, name, btn) {
            document.querySelectorAll(`[id^="${group}-tab-"]`).forEach(p => p.classList.remove('active'));
            document.getElementById(`${group}-tab-${name}`)?.classList.add('active');
            if (btn) {
                btn.closest('[style*="border-bottom"]').querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            }
        }

        // ============================================================
        // MISC
        // ============================================================
        function saveProfile() {
            const n = document.getElementById('p-name').value.trim();
            if (n.length < 2) {
                toast('Name must be at least 2 characters', 'error');
                return;
            }
            document.getElementById('profile-display-name').textContent = n;
            document.getElementById('user-name-sb').textContent = n;
            S.set('user_name', n);
            toast('Profile saved successfully!', 'success');
        }

        function handleAvatar(e) {
            const f = e.target.files[0];
            if (!f) return;
            if (f.size > 2097152) {
                toast('File size must not exceed 2MB', 'error');
                return;
            }
            const r = new FileReader();
            r.onload = ev => {
                const b = document.getElementById('av-big');
                const sb = document.getElementById('av-box');
                [b, sb].forEach(el => {
                    el.style.backgroundImage = `url(${ev.target.result})`;
                    el.style.backgroundSize = 'cover';
                    el.style.backgroundPosition = 'center';
                    el.textContent = '';
                });
                toast('Profile photo updated!', 'success');
            };
            r.readAsDataURL(f);
        }

        function clearNotifs() {
            confirm_act('Clear all notifications?', () => {
                document.getElementById('notif-list').innerHTML = '<div style="text-align:center;padding:24px;color:#475569;font-size:.83rem">No notifications</div>';
                document.getElementById('notif-count').style.display = 'none';
                document.getElementById('notif-dot').style.display = 'none';
                toast('All notifications cleared', 'success');
            });
        }

        function submitFeedback(e) {
            e.preventDefault();
            const t = document.getElementById('fb-type').value;
            const s = document.getElementById('fb-subject').value.trim();
            const m = document.getElementById('fb-msg').value.trim();
            if (!t) {
                toast('Please select a feedback type', 'error');
                return;
            }
            if (s.length < 5) {
                toast('Subject must be at least 5 characters', 'error');
                return;
            }
            if (m.length < 10) {
                toast('Message must be at least 10 characters', 'error');
                return;
            }
            toast('Feedback submitted! Thank you for helping improve D-Remind 🎉', 'success');
            e.target.reset();
            document.getElementById('fb-len').textContent = '0';
        }

        function selPri(btn) {
            btn.closest('[style*="flex"]').querySelectorAll('.pri-btn').forEach(b => b.classList.remove('sel'));
            btn.classList.add('sel');
        }

        function handleLogout() {
            confirm_act('Are you sure you want to logout?', () => {
                toast('Logged out successfully', 'success');
                setTimeout(() => window.location.reload(), 1500);
            });
        }

        // ============================================================
        // INIT
        // ============================================================
        document.addEventListener('DOMContentLoaded', () => {
            initTheme();
            initSidebar();
            initData();
            const h = new Date().getHours();
            document.getElementById('greeting').textContent = h < 12 ? 'Good morning' : h < 17 ? 'Good afternoon' : 'Good evening';
            // Restore user name
            const un = S.get('user_name', 'Kishore Rex');
            if (un) {
                document.getElementById('user-name-sb').textContent = un;
                document.getElementById('profile-display-name').textContent = un;
            }
            go('dashboard');
        });
        
    </script>
</body>

</html>