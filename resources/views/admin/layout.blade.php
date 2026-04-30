<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D-Remind Admin — Control Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        :root{--sb:256px;--sb-sm:64px;--bg:#07071a;--bg2:#0c0c22;--bg3:#10102e;--border:rgba(255,255,255,.07);--border2:rgba(255,255,255,.04);--text:#e2e8f0;--text2:#94a3b8;--text3:#64748b;--text4:#475569;--purple:#7c3aed;--purple-light:#a78bfa;--teal:#0d9488;--teal-light:#2dd4bf;--green:#10b981;--amber:#f59e0b;--red:#f43f5e;--cyan:#06b6d4;--card:rgba(12,12,30,.9);--radius:14px;--radius-sm:10px;--radius-xs:7px;font-size:15px}
        .light{--bg:#f0f0fa;--bg2:#fff;--bg3:#f8f7ff;--border:rgba(99,102,241,.12);--border2:rgba(99,102,241,.07);--text:#1e1b4b;--text2:#334155;--text3:#475569;--text4:#64748b;--card:#fff}
        *{box-sizing:border-box;margin:0;padding:0}html{scroll-behavior:smooth}
        body{font-family:'DM Sans',sans-serif;background:var(--bg);color:var(--text);overflow-x:hidden}
        ::-webkit-scrollbar{width:4px;height:4px}::-webkit-scrollbar-track{background:transparent}::-webkit-scrollbar-thumb{background:#2e2e65;border-radius:99px}
        .light ::-webkit-scrollbar-thumb{background:#c4b5fd}
        .font-jakarta{font-family:'Plus Jakarta Sans',sans-serif}.mono{font-family:'DM Mono',monospace}
        .app{display:flex;height:100vh;overflow:hidden}
        .main-wrap{flex:1;display:flex;flex-direction:column;overflow:hidden;min-width:0}
        main{flex:1;overflow-y:auto;padding:24px;overflow-x:hidden}
        /* SIDEBAR */
        .sidebar{width:var(--sb);background:var(--bg2);border-right:1px solid var(--border);flex-shrink:0;height:100vh;overflow:hidden;position:relative;z-index:50;transition:width .3s cubic-bezier(.4,0,.2,1);display:flex;flex-direction:column}
        .sidebar.collapsed{width:var(--sb-sm)}
        .sb-logo{padding:18px 16px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px;flex-shrink:0}
        .sb-logo-icon{width:34px;height:34px;border-radius:10px;background:linear-gradient(135deg,#7c3aed,#0d9488);display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .sb-logo-icon i{color:#fff;font-size:1rem}
        .sb-logo-txt{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:.9rem;color:var(--text);white-space:nowrap;transition:opacity .2s,max-width .2s}
        .sb-logo-badge{font-size:.55rem;font-weight:700;background:linear-gradient(135deg,#7c3aed,#0d9488);color:#fff;padding:2px 6px;border-radius:4px;text-transform:uppercase;letter-spacing:.05em;white-space:nowrap;transition:opacity .2s,max-width .2s}
        .sidebar.collapsed .sb-logo-txt,.sidebar.collapsed .sb-logo-badge{opacity:0;max-width:0;overflow:hidden}
        .sb-nav{flex:1;overflow-y:auto;overflow-x:hidden;padding:10px 8px;scrollbar-width:none}.sb-nav::-webkit-scrollbar{display:none}
        .sb-section{font-size:.58rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--text4);padding:10px 8px 4px;white-space:nowrap;overflow:hidden;transition:opacity .2s}
        .sidebar.collapsed .sb-section{opacity:0}
        .nav-item{display:flex;align-items:center;gap:9px;padding:9px 10px;border-radius:var(--radius-xs);cursor:pointer;transition:all .18s;color:var(--text3);font-size:1.20re;font-weight:500;white-space:nowrap;border-left:2px solid transparent;position:relative}
        .nav-item:hover{background:rgba(124,58,237,.1);color:var(--purple-light)}
        .light .nav-item:hover{color:var(--purple)}
        .nav-item.active{background:rgba(124,58,237,.15);color:var(--purple-light);border-left-color:var(--purple)}
        .light .nav-item.active{background:rgba(124,58,241,.08);color:#6d28d9}
        .nav-item i{font-size:1.05rem;flex-shrink:0;width:20px;text-align:center}
        .nav-lbl{transition:opacity .2s,max-width .2s;overflow:hidden;white-space:nowrap}
        .nav-badge{margin-left:auto;background:var(--red);color:#fff;font-size:.58rem;font-weight:700;padding:2px 6px;border-radius:99px;flex-shrink:0;transition:opacity .2s}
        .sidebar.collapsed .nav-lbl,.sidebar.collapsed .nav-badge{opacity:0;max-width:0}
        .sidebar.collapsed .nav-item{justify-content:center;padding:10px 0}
        .sb-user{padding:12px 10px;border-top:1px solid var(--border);flex-shrink:0}
        .sb-user-row{display:flex;align-items:center;gap:9px;padding:8px 6px;border-radius:var(--radius-xs);cursor:pointer;transition:all .18s}
        .sb-user-row:hover{background:rgba(255,255,255,.04)}
        .sb-avatar{width:32px;height:32px;border-radius:9px;background:linear-gradient(135deg,#7c3aed,#0d9488);display:flex;align-items:center;justify-content:center;color:#fff;font-size:.65rem;font-weight:700;flex-shrink:0}
        .sb-user-info{overflow:hidden;flex:1;transition:opacity .2s,max-width .2s}
        .sb-user-name{font-size:.8rem;font-weight:600;color:var(--text);white-space:nowrap}
        .sb-user-role{font-size:.65rem;color:var(--text3)}
        .sidebar.collapsed .sb-user-info{opacity:0;max-width:0}
        .sidebar.collapsed .sb-user-row{justify-content:center}
        /* TOPBAR */
        .topbar{background:rgba(9,9,24,.95);border-bottom:1px solid var(--border);backdrop-filter:blur(12px);height:60px;display:flex;align-items:center;justify-content:space-between;padding:0 20px;position:sticky;top:0;z-index:40;flex-shrink:0}
        .light .topbar{background:rgba(255,255,255,.95)}
        .topbar-left{display:flex;align-items:center;gap:10px}.topbar-right{display:flex;align-items:center;gap:6px}
        .tb-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:.95rem;color:var(--text)}
        .tb-breadcrumb{font-size:.75rem;color:var(--text3);margin-top:1px}
        .tb-btn{width:36px;height:36px;border-radius:var(--radius-xs);border:1px solid var(--border);background:rgba(255,255,255,.04);color:var(--text2);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .18s;font-size:.95rem}
        .tb-btn:hover{border-color:rgba(124,58,237,.4);color:var(--purple-light);background:rgba(124,58,237,.1)}
        .light .tb-btn{background:#fff;border-color:rgba(99,102,241,.15);color:var(--text2)}
        .notif-btn{position:relative}.notif-dot{position:absolute;top:6px;right:6px;width:7px;height:7px;border-radius:50%;background:var(--red);border:1.5px solid var(--bg2)}
        .tb-divider{width:1px;height:20px;background:var(--border);margin:0 4px}
        /* CARDS */
        .card{background:var(--card);border:1px solid var(--border);border-radius:var(--radius);transition:border-color .2s}
        .light .card{box-shadow:0 1px 4px rgba(0,0,0,.06)}.card:hover{border-color:rgba(124,58,237,.2)}
        .stat-card{background:var(--card);border:1px solid var(--border);border-radius:var(--radius);padding:18px;transition:all .25s;position:relative;overflow:hidden}
        .stat-card:hover{transform:translateY(-2px);box-shadow:0 10px 28px rgba(124,58,237,.18)}
        .stat-ico{width:40px;height:40px;border-radius:11px;display:flex;align-items:center;justify-content:center;margin-bottom:10px}
        .stat-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:1.5rem;font-weight:800;color:var(--text);line-height:1}
        .stat-lbl{font-size:.72rem;color:var(--text3);margin-top:3px;font-weight:600}
        .stat-delta{font-size:.7rem;margin-top:6px;display:flex;align-items:center;gap:3px}
        .g2{display:grid;grid-template-columns:repeat(2,1fr);gap:16px}
        .g3{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
        .g4{display:grid;grid-template-columns:repeat(4,1fr);gap:14px}
        .g5{display:grid;grid-template-columns:repeat(5,1fr);gap:12px}
        /* INPUTS */
        .inp{background:rgba(255,255,255,.04);border:1px solid var(--border);color:var(--text);border-radius:var(--radius-sm);padding:10px 14px;font-size:.83rem;font-family:'DM Sans',sans-serif;transition:all .2s;outline:none;width:100%}
        .light .inp{background:#fff;border-color:rgba(99,102,241,.15);color:var(--text)}
        .inp:focus{border-color:var(--purple);box-shadow:0 0 0 3px rgba(124,58,237,.15)}
        .inp::placeholder{color:var(--text4)}
        select.inp{appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='%237c3aed'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 12px center;padding-right:36px;cursor:pointer}
        .dark select.inp option{background:#0c0c1e}
        /* BUTTONS */
        .btn{display:inline-flex;align-items:center;gap:6px;border-radius:var(--radius-sm);padding:9px 16px;font-size:1.20re;font-weight:600;cursor:pointer;border:none;transition:all .2s;font-family:'Plus Jakarta Sans',sans-serif;white-space:nowrap}
        .btn-primary{background:linear-gradient(135deg,#7c3aed,#6d28d9);color:#fff}
        .btn-primary:hover{transform:translateY(-1px);box-shadow:0 6px 20px rgba(124,58,237,.4)}
        .btn-teal{background:linear-gradient(135deg,#0d9488,#0f766e);color:#fff}
        .btn-teal:hover{transform:translateY(-1px);box-shadow:0 6px 18px rgba(13,148,136,.35)}
        .btn-ghost{background:rgba(255,255,255,.05);border:1px solid var(--border);color:var(--text2)}
        .btn-ghost:hover{border-color:rgba(124,58,237,.4);color:var(--purple-light);background:rgba(124,58,237,.1)}
        .light .btn-ghost{background:rgba(0,0,0,.04);border-color:rgba(99,102,241,.15);color:var(--text2)}
        .btn-danger{background:rgba(244,63,94,.12);border:1px solid rgba(244,63,94,.3);color:var(--red)}
        .btn-danger:hover{background:var(--red);color:#fff}
        .btn-success{background:rgba(16,185,129,.12);border:1px solid rgba(16,185,129,.3);color:var(--green)}
        .btn-success:hover{background:var(--green);color:#fff}
        .btn-amber{background:rgba(245,158,11,.12);border:1px solid rgba(245,158,11,.3);color:var(--amber)}
        .btn-sm{padding:7px 13px!important;font-size:.75rem!important}
        .btn-xs{padding:4px 9px!important;font-size:.7rem!important}
        .btn-icon{width:34px;height:34px;padding:0;justify-content:center}
        /* BADGES */
        .badge{display:inline-flex;align-items:center;gap:3px;padding:3px 9px;border-radius:99px;font-size:.67rem;font-weight:700}
        .badge-purple{background:rgba(124,58,237,.15);color:var(--purple-light);border:1px solid rgba(124,58,237,.25)}
        .badge-teal{background:rgba(13,148,136,.15);color:var(--teal-light);border:1px solid rgba(13,148,136,.25)}
        .badge-green{background:rgba(16,185,129,.12);color:var(--green);border:1px solid rgba(16,185,129,.2)}
        .badge-red{background:rgba(244,63,94,.12);color:var(--red);border:1px solid rgba(244,63,94,.2)}
        .badge-amber{background:rgba(245,158,11,.12);color:var(--amber);border:1px solid rgba(245,158,11,.2)}
        .badge-slate{background:rgba(100,116,139,.12);color:var(--text2);border:1px solid rgba(100,116,139,.2)}
        .badge-cyan{background:rgba(6,182,212,.12);color:var(--cyan);border:1px solid rgba(6,182,212,.2)}
        /* TOGGLE */
        .toggle{width:42px;height:22px;background:#334155;border-radius:99px;cursor:pointer;position:relative;transition:background .3s;flex-shrink:0;border:none}
        .toggle.on{background:var(--purple)}
        .toggle::after{content:'';position:absolute;top:2px;left:2px;width:18px;height:18px;border-radius:50%;background:#fff;transition:transform .3s;box-shadow:0 1px 4px rgba(0,0,0,.3)}
        .toggle.on::after{transform:translateX(20px)}
        /* TABLE */
        .data-table{width:100%;border-collapse:separate;border-spacing:0;font-size:1.20re}
        .data-table thead th{padding:10px 14px;font-size:.63rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--text3);border-bottom:1px solid var(--border);white-space:nowrap;cursor:pointer;user-select:none;transition:color .15s}
        .data-table thead th:hover{color:var(--purple-light)}
        .data-table tbody tr{transition:background .15s}
        .data-table tbody tr:hover{background:rgba(124,58,237,.05)}
        .data-table tbody td{padding:11px 14px;border-bottom:1px solid var(--border2);color:var(--text2);vertical-align:middle;white-space:nowrap}
        .data-table tbody tr:last-child td{border-bottom:none}
        /* MODAL */
        .modal-bg{position:fixed;inset:0;background:rgba(0,0,0,.75);backdrop-filter:blur(8px);z-index:9000;display:flex;align-items:center;justify-content:center;opacity:0;pointer-events:none;transition:opacity .25s;padding:16px}
        .modal-bg.open{opacity:1;pointer-events:all}
        .modal-box{background:#0c0c1e;border:1px solid rgba(255,255,255,.1);border-radius:20px;padding:28px;width:100%;max-width:580px;max-height:90vh;overflow-y:auto;transform:translateY(20px) scale(.97);transition:transform .3s cubic-bezier(.16,1,.3,1)}
        .light .modal-box{background:#fff;border-color:rgba(99,102,241,.15)}
        .modal-bg.open .modal-box{transform:translateY(0) scale(1)}
        .modal-header{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px}
        .modal-close{background:rgba(255,255,255,.05);border:1px solid var(--border);color:var(--text2);width:30px;height:30px;border-radius:7px;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:.9rem;transition:all .2s;flex-shrink:0}
        .modal-close:hover{background:rgba(244,63,94,.1);border-color:rgba(244,63,94,.3);color:var(--red)}
        /* TOAST */
        #toast-area{position:fixed;top:20px;right:20px;z-index:99999;display:flex;flex-direction:column;gap:8px;pointer-events:none}
        .toast{display:flex;align-items:center;gap:10px;padding:12px 16px;border-radius:12px;font-size:.8rem;font-weight:600;border:1px solid;animation:toastIn .3s ease;font-family:'Plus Jakarta Sans',sans-serif;min-width:240px;max-width:320px;pointer-events:all;backdrop-filter:blur(12px)}
        @keyframes toastIn{from{opacity:0;transform:translateX(40px)}to{opacity:1;transform:translateX(0)}}
        /* PAGES */
        .page{display:none;animation:fadeUp .22s ease}
        .page.active{display:block}
        @keyframes fadeUp{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:translateY(0)}}
        /* PROGRESS */
        .prog-track{height:5px;border-radius:99px;background:rgba(255,255,255,.07);overflow:hidden}
        .prog-fill{height:100%;border-radius:99px;background:linear-gradient(90deg,#7c3aed,#0d9488);transition:width 1s ease}
        /* AVATAR */
        .avatar{display:flex;align-items:center;justify-content:center;border-radius:9px;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;flex-shrink:0}
        .avatar-sm{width:28px;height:28px;font-size:.6rem}
        .avatar-md{width:36px;height:36px;font-size:.72rem}
        .avatar-lg{width:48px;height:48px;font-size:.9rem;border-radius:13px}
        /* TABS */
        .tab-bar{display:flex;gap:4px;border-bottom:1px solid var(--border);margin-bottom:20px}
        .tab-btn{padding:9px 16px;font-size:1.20re;font-weight:600;cursor:pointer;border:none;background:none;border-bottom:2px solid transparent;color:var(--text3);transition:all .2s;font-family:'Plus Jakarta Sans',sans-serif;white-space:nowrap}
        .tab-btn.active{color:var(--purple-light);border-bottom-color:var(--purple)}
        .light .tab-btn.active{color:var(--purple)}
        .tab-pane{display:none}.tab-pane.active{display:block;animation:fadeUp .2s ease}
        /* SEARCH */
        .search-box{background:rgba(255,255,255,.04);border:1px solid var(--border);border-radius:var(--radius-sm);padding:8px 13px;display:flex;align-items:center;gap:8px;transition:border-color .2s}
        .light .search-box{background:#fff;border-color:rgba(99,102,241,.12)}
        .search-box:focus-within{border-color:rgba(124,58,237,.4)}
        .search-box input{background:none;border:none;outline:none;font-size:1.20re;color:var(--text);width:100%;font-family:'DM Sans',sans-serif}
        .search-box input::placeholder{color:var(--text4)}
        /* PERMISSIONS */
        .perm-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:8px}
        .perm-item{display:flex;align-items:center;gap:8px;padding:9px 12px;border-radius:var(--radius-xs);background:rgba(255,255,255,.03);border:1px solid var(--border2);cursor:pointer;transition:all .18s}
        .perm-item:hover{border-color:rgba(124,58,237,.3);background:rgba(124,58,237,.07)}
        .perm-item input{accent-color:var(--purple);width:13px;height:13px;cursor:pointer}
        .perm-item label{font-size:.77rem;color:var(--text2);cursor:pointer;font-weight:500}
        /* ROLE CARD */
        .role-card{background:var(--card);border:1px solid var(--border);border-radius:var(--radius);padding:16px;transition:all .22s;cursor:pointer}
        .role-card:hover{border-color:rgba(124,58,237,.35);transform:translateY(-2px);box-shadow:0 10px 28px rgba(124,58,237,.15)}
        .role-card.selected{border-color:rgba(124,58,237,.6);background:rgba(124,58,237,.08)}
        /* ACTIVITY */
        .act-item{display:flex;align-items:flex-start;gap:10px;padding:12px;border-radius:var(--radius-sm);border:1px solid var(--border2);background:rgba(255,255,255,.02);transition:border-color .18s}
        .act-item:hover{border-color:rgba(124,58,237,.2)}
        /* MISC */
        .section-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:.87rem;color:var(--text);margin-bottom:14px}
        .label{display:block;font-size:.64rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--text3);margin-bottom:6px}
        .form-row{margin-bottom:16px}
        .divider{height:1px;background:var(--border);margin:20px 0}
        .chip{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:6px;font-size:.7rem;font-weight:600;background:rgba(124,58,237,.12);color:var(--purple-light);border:1px solid rgba(124,58,237,.2)}
        .dot{width:7px;height:7px;border-radius:50%;flex-shrink:0}
        .danger-zone{border:1px solid rgba(244,63,94,.2);border-radius:var(--radius);padding:16px;background:rgba(244,63,94,.04)}
        #sb-overlay{position:fixed;inset:0;background:rgba(0,0,0,.55);z-index:45;display:none}
        #sb-overlay.show{display:block}
        .mobile-menu-btn{display:none}
        /* PAGINATION */
        .pg-wrap{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;margin-top:14px;padding-top:14px;border-top:1px solid var(--border2)}
        .pg-info{font-size:.75rem;color:var(--text3)}
        .pg-btns{display:flex;gap:4px;flex-wrap:wrap}
        @media(max-width:1100px){.g4{grid-template-columns:repeat(2,1fr)}.g5{grid-template-columns:repeat(3,1fr)}}
        @media(max-width:900px){.g2,.g3{grid-template-columns:1fr}}
        @media(max-width:768px){.sidebar{position:fixed;left:calc(-1 * var(--sb));z-index:500;transition:left .3s cubic-bezier(.4,0,.2,1)}.sidebar.mobile-open{left:0!important;width:var(--sb)!important}.sidebar.mobile-open .nav-lbl,.sidebar.mobile-open .sb-logo-txt,.sidebar.mobile-open .sb-logo-badge,.sidebar.mobile-open .sb-user-info,.sidebar.mobile-open .nav-badge{opacity:1;max-width:200px}.sidebar.mobile-open .nav-item{justify-content:flex-start;padding:9px 10px}.sidebar.mobile-open .sb-user-row{justify-content:flex-start}.sidebar.mobile-open .sb-section{opacity:1}.mobile-menu-btn{display:flex}.topbar{padding:0 14px}.g4{grid-template-columns:repeat(2,1fr)}.g5{grid-template-columns:repeat(2,1fr)}.hide-mobile{display:none!important}}
        @media(max-width:480px){.g4,.g5{grid-template-columns:1fr}.modal-box{padding:20px}}
        .light h1,.light h2,.light h3,.light h4,.light h5{color:var(--text)!important}
    </style>
</head>
<body>
<div id="toast-area"></div>
<div id="sb-overlay" onclick="closeMobile()"></div>

<div class="app">
<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
    <div class="logo-txt lbl logoo" style="display:flex;align-items:center;gap:8px;overflow:hidden;white-space:nowrap">
        <img style="width: stretch; padding: 15px 26px 0px 0px;" src="https://www.vishakarex.in/assets/img/projects/d-remind.png" alt="">
    </div>
    <nav class="sb-nav">
        <div class="sb-section">Overview</div>
        <div class="nav-item active" onclick="go('dashboard',this)"><i class="ri-dashboard-line"></i><span class="nav-lbl">Dashboard</span></div>
        <div class="nav-item" onclick="go('analytics',this)"><i class="ri-bar-chart-2-line"></i><span class="nav-lbl">Analytics</span></div>
        <div class="sb-section">Management</div>
        <div class="nav-item" onclick="go('users',this)"><i class="ri-group-line"></i><span class="nav-lbl">Users</span><span class="nav-badge">3</span></div>
        <div class="nav-item" onclick="go('reminders',this)"><i class="ri-alarm-line"></i><span class="nav-lbl">Reminders</span></div>
        <div class="nav-item" onclick="go('transactions',this)"><i class="ri-bank-card-line"></i><span class="nav-lbl">Transactions</span></div>
        <div class="nav-item" onclick="go('categories',this)"><i class="ri-folder-3-line"></i><span class="nav-lbl">Categories</span></div>
        <div class="nav-item" onclick="go('notifications',this)"><i class="ri-notification-3-line"></i><span class="nav-lbl">Notifications</span><span class="nav-badge">5</span></div>
        <div class="sb-section">Team</div>
        <div class="nav-item" onclick="go('staff',this)"><i class="ri-team-line"></i><span class="nav-lbl">Staff</span></div>
        <div class="nav-item" onclick="go('roles',this)"><i class="ri-key-2-line"></i><span class="nav-lbl">Roles & Permissions</span></div>
        <div class="sb-section">System</div>
        <div class="nav-item" onclick="go('settings',this)"><i class="ri-settings-3-line"></i><span class="nav-lbl">Settings</span></div>
        <div class="nav-item" onclick="go('audit',this)"><i class="ri-shield-check-line"></i><span class="nav-lbl">Audit Log</span></div>
        <div class="nav-item" onclick="go('feedback',this)"><i class="ri-feedback-line"></i><span class="nav-lbl">Feedback</span></div>
        <div class="nav-item" style="color:var(--red)" onclick="handleLogout()"><i class="ri-logout-box-r-line"></i><span class="nav-lbl">Logout</span></div>
    </nav>
    <div class="sb-user">
        <div class="sb-user-row" onclick="go('profile',null)">
            <div class="sb-avatar">SA</div>
            <div class="sb-user-info">
                <div class="sb-user-name">Super Admin</div>
                <div class="sb-user-role">System Administrator</div>
            </div>
        </div>
    </div>
</aside>

<!-- MAIN -->
<div class="main-wrap">
<div class="topbar">
    <div class="topbar-left">
        <button class="tb-btn mobile-menu-btn" onclick="openMobile()"><i class="ri-menu-line"></i></button>
        <button class="tb-btn hide-mobile" onclick="toggleSidebar()"><i class="ri-layout-left-line"></i></button>
        <div>
            <div class="tb-title" id="page-title">Dashboard</div>
            <div class="tb-breadcrumb">Admin Panel · D-Remind</div>
        </div>
    </div>
    <div class="topbar-right">
        <div class="search-box hide-mobile" style="width:200px">
            <i class="ri-search-line" style="color:var(--text3);font-size:.85rem"></i>
            <input placeholder="Quick search…">
        </div>
        <div class="tb-divider hide-mobile"></div>
        <button class="tb-btn notif-btn" onclick="go('notifications',null)"><i class="ri-notification-3-line"></i><span class="notif-dot"></span></button>
        <button class="tb-btn" onclick="toggleTheme()"><i class="ri-moon-line" id="theme-icon"></i></button>
        <button class="tb-btn" onclick="go('profile',null)"><i class="ri-user-settings-line"></i></button>
    </div>
</div>

<main>
<!-- ═══ DASHBOARD ═══ -->
<section id="page-dashboard" class="page active">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px">
        <div>
            <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800;color:var(--text)">Welcome back, Admin 👋</h2>
            <p style="font-size:1.20re;color:var(--text3);margin-top:3px">Here's what's happening with D-Remind today.</p>
        </div>
        <div style="display:flex;gap:8px">
            <button class="btn btn-ghost btn-sm" onclick="toast('Report generated!','success')"><i class="ri-download-2-line"></i> Export</button>
            <button class="btn btn-primary btn-sm" onclick="openModal('add-user-modal')"><i class="ri-add-line"></i> Add User</button>
        </div>
    </div>
    <div class="g4" style="margin-bottom:20px">
        <div class="stat-card"><div class="stat-ico" style="background:rgba(124,58,237,.15)"><i class="ri-group-line" style="color:var(--purple-light);font-size:1.1rem"></i></div><div class="stat-num">1,284</div><div class="stat-lbl">Total Users</div><div class="stat-delta" style="color:var(--green)"><i class="ri-arrow-up-line"></i> +12% this month</div></div>
        <div class="stat-card"><div class="stat-ico" style="background:rgba(16,185,129,.12)"><i class="ri-alarm-line" style="color:var(--green);font-size:1.1rem"></i></div><div class="stat-num" style="color:var(--green)">48,320</div><div class="stat-lbl">Active Reminders</div><div class="stat-delta" style="color:var(--green)"><i class="ri-arrow-up-line"></i> +8% this week</div></div>
        <div class="stat-card"><div class="stat-ico" style="background:rgba(245,158,11,.12)"><i class="ri-money-pound-circle-line" style="color:var(--amber);font-size:1.1rem"></i></div><div class="stat-num" style="color:var(--amber)">£2,880</div><div class="stat-lbl">Monthly Revenue</div><div class="stat-delta" style="color:var(--green)"><i class="ri-arrow-up-line"></i> +18% MoM</div></div>
        <div class="stat-card"><div class="stat-ico" style="background:rgba(244,63,94,.12)"><i class="ri-error-warning-line" style="color:var(--red);font-size:1.1rem"></i></div><div class="stat-num" style="color:var(--red)">3</div><div class="stat-lbl">Open Issues</div><div class="stat-delta" style="color:var(--red)"><i class="ri-arrow-down-line"></i> Needs attention</div></div>
    </div>
    <div class="g2" style="margin-bottom:20px">
        <div class="card" style="padding:18px">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
                <div class="section-title" style="margin:0">User Growth</div>
                <select class="inp" style="width:auto;padding:5px 28px 5px 10px;font-size:.73rem"><option>Last 6 Months</option><option>Last Year</option></select>
            </div>
            <div style="position:relative;height:220px"><canvas id="user-growth-chart"></canvas></div>
        </div>
        <div class="card" style="padding:18px">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
                <div class="section-title" style="margin:0">Revenue Breakdown</div>
                <span class="badge badge-green">+18% MoM</span>
            </div>
            <div style="position:relative;height:220px"><canvas id="revenue-chart"></canvas></div>
        </div>
    </div>
    <div class="g2" style="margin-bottom:20px">
        <div class="card" style="padding:18px">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
                <div class="section-title" style="margin:0">Recent Signups</div>
                <button class="btn btn-ghost btn-xs" onclick="go('users',null)">View All <i class="ri-arrow-right-line"></i></button>
            </div>
            <div style="display:flex;flex-direction:column;gap:8px" id="recent-users-list"></div>
        </div>
        <div style="display:flex;flex-direction:column;gap:14px">
            <div class="card" style="padding:18px">
                <div class="section-title">Quick Actions</div>
                <div style="display:flex;flex-wrap:wrap;gap:8px">
                    <button class="btn btn-primary btn-sm" onclick="openModal('add-user-modal')"><i class="ri-user-add-line"></i> Add User</button>
                    <button class="btn btn-teal btn-sm" onclick="openModal('add-staff-modal')"><i class="ri-team-line"></i> Add Staff</button>
                    <button class="btn btn-ghost btn-sm" onclick="go('settings',null)"><i class="ri-settings-3-line"></i> Settings</button>
                    <button class="btn btn-ghost btn-sm" onclick="go('audit',null)"><i class="ri-shield-check-line"></i> Audit Log</button>
                    <button class="btn btn-amber btn-sm" onclick="toast('Maintenance mode toggled','warning')"><i class="ri-tools-line"></i> Maintenance</button>
                </div>
            </div>
            <div class="card" style="padding:18px">
                <div class="section-title">System Health</div>
                <div style="display:flex;flex-direction:column;gap:10px" id="sys-health"></div>
            </div>
        </div>
    </div>
</section>

<!-- ═══ ANALYTICS ═══ -->
<section id="page-analytics" class="page">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px">
        <div><h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800">Analytics Overview</h2><p style="font-size:1.20re;color:var(--text3);margin-top:3px">Platform-wide insights and metrics</p></div>
        <div style="display:flex;gap:8px">
            <select class="inp" style="width:auto;min-width:140px"><option>Last 30 Days</option><option>Last 90 Days</option><option>This Year</option></select>
            <button class="btn btn-ghost btn-sm" onclick="toast('Analytics exported!','success')"><i class="ri-download-2-line"></i> Export</button>
        </div>
    </div>
    <div class="g4" style="margin-bottom:20px">
        <div class="stat-card"><div class="stat-ico" style="background:rgba(124,58,237,.15)"><i class="ri-group-line" style="color:var(--purple-light)"></i></div><div class="stat-num">1,284</div><div class="stat-lbl">Total Users</div><div class="stat-delta" style="color:var(--green)"><i class="ri-arrow-up-line"></i> 12%</div></div>
        <div class="stat-card"><div class="stat-ico" style="background:rgba(20,184,166,.12)"><i class="ri-alarm-line" style="color:var(--teal-light)"></i></div><div class="stat-num">48,320</div><div class="stat-lbl">Total Reminders</div><div class="stat-delta" style="color:var(--green)"><i class="ri-arrow-up-line"></i> 8%</div></div>
        <div class="stat-card"><div class="stat-ico" style="background:rgba(16,185,129,.12)"><i class="ri-check-double-line" style="color:var(--green)"></i></div><div class="stat-num">89%</div><div class="stat-lbl">Completion Rate</div><div class="stat-delta" style="color:var(--green)"><i class="ri-arrow-up-line"></i> 5%</div></div>
        <div class="stat-card"><div class="stat-ico" style="background:rgba(245,158,11,.12)"><i class="ri-money-pound-circle-line" style="color:var(--amber)"></i></div><div class="stat-num" style="color:var(--amber)">£34,560</div><div class="stat-lbl">Total Revenue</div><div class="stat-delta" style="color:var(--green)"><i class="ri-arrow-up-line"></i> 18%</div></div>
    </div>
    <div class="g2" style="margin-bottom:20px">
        <div class="card" style="padding:18px"><div class="section-title">User Registrations — Monthly</div><div style="position:relative;height:230px"><canvas id="an-reg-chart"></canvas></div></div>
        <div class="card" style="padding:18px"><div class="section-title">Reminder Categories Distribution</div><div style="position:relative;height:230px"><canvas id="an-cat-chart"></canvas></div></div>
    </div>
    <div class="g2">
        <div class="card" style="padding:18px"><div class="section-title">Revenue Trend</div><div style="position:relative;height:200px"><canvas id="an-rev-chart"></canvas></div></div>
        <div class="card" style="padding:18px"><div class="section-title">Plan Distribution</div><div style="position:relative;height:200px"><canvas id="an-plan-chart"></canvas></div></div>
    </div>
</section>

<!-- ═══ USERS ═══ -->
<section id="page-users" class="page">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px">
        <div><h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800">User Management</h2><p style="font-size:1.20re;color:var(--text3);margin-top:3px">Manage all registered users</p></div>
        <div style="display:flex;gap:8px">
            <button class="btn btn-ghost btn-sm" onclick="toast('Users exported','success')"><i class="ri-download-2-line"></i> Export</button>
            <button class="btn btn-primary btn-sm" onclick="openModal('add-user-modal')"><i class="ri-user-add-line"></i> Add User</button>
        </div>
    </div>
    <div class="card" style="padding:14px;margin-bottom:14px">
        <div style="display:flex;flex-wrap:wrap;gap:10px;align-items:center">
            <div class="search-box" style="flex:1;min-width:200px"><i class="ri-search-line" style="color:var(--text3);font-size:.85rem"></i><input placeholder="Search users…" oninput="filterUsers(this.value)" id="users-search-inp"></div>
            <select class="inp" style="width:auto;min-width:130px" id="users-status-filter" onchange="filterUsers()"><option value="all">All Status</option><option value="active">Active</option><option value="suspended">Suspended</option></select>
            <select class="inp" style="width:auto;min-width:130px" id="users-plan-filter" onchange="filterUsers()"><option value="all">All Plans</option><option value="Basic Annual">Basic Annual</option><option value="Pro">Pro</option><option value="Free">Free</option></select>
        </div>
    </div>
    <div class="card" style="padding:18px">
        <div style="overflow-x:auto">
            <table class="data-table" id="users-table">
                <thead>
                    <tr>
                        <th style="width:38px"><input type="checkbox" style="accent-color:var(--purple);width:13px;height:13px;cursor:pointer" onchange="toggleAllCB(this,'user-cb')"></th>
                        <th>User</th>
                        <th class="hide-mobile">Plan</th>
                        <th class="hide-mobile">Reminders</th>
                        <th>Status</th>
                        <th class="hide-mobile">Joined</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody id="users-tbody"></tbody>
            </table>
        </div>
        <div class="pg-wrap">
            <div class="pg-info">Showing <strong id="users-showing">0</strong> of <strong id="users-total">0</strong> users</div>
            <div class="pg-btns" id="users-pagination"></div>
        </div>
    </div>
</section>

<!-- ═══ STAFF ═══ -->
<section id="page-staff" class="page">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px">
        <div><h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800">Staff Management</h2><p style="font-size:1.20re;color:var(--text3);margin-top:3px">Manage your team members and assignments</p></div>
        <button class="btn btn-primary btn-sm" onclick="openModal('add-staff-modal')"><i class="ri-user-add-line"></i> Add Staff</button>
    </div>
    <div class="g4" style="margin-bottom:20px">
        <div class="stat-card"><div class="stat-ico" style="background:rgba(124,58,237,.15)"><i class="ri-team-line" style="color:var(--purple-light)"></i></div><div class="stat-num" id="staff-count-total">8</div><div class="stat-lbl">Total Staff</div></div>
        <div class="stat-card"><div class="stat-ico" style="background:rgba(16,185,129,.12)"><i class="ri-user-follow-line" style="color:var(--green)"></i></div><div class="stat-num" style="color:var(--green)" id="staff-count-active">7</div><div class="stat-lbl">Active</div></div>
        <div class="stat-card"><div class="stat-ico" style="background:rgba(244,63,94,.12)"><i class="ri-user-unfollow-line" style="color:var(--red)"></i></div><div class="stat-num" style="color:var(--red)" id="staff-count-inactive">1</div><div class="stat-lbl">Inactive</div></div>
        <div class="stat-card"><div class="stat-ico" style="background:rgba(245,158,11,.12)"><i class="ri-key-2-line" style="color:var(--amber)"></i></div><div class="stat-num">4</div><div class="stat-lbl">Roles Assigned</div></div>
    </div>
    <div class="card" style="padding:18px">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
            <div class="section-title" style="margin:0">Team Members</div>
            <div class="search-box" style="width:200px"><i class="ri-search-line" style="color:var(--text3);font-size:.85rem"></i><input placeholder="Search staff…" oninput="filterStaff(this.value)"></div>
        </div>
        <div style="overflow-x:auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Staff Member</th>
                        <th class="hide-mobile">Role</th>
                        <th class="hide-mobile">Permissions</th>
                        <th>Status</th>
                        <th class="hide-mobile">Last Active</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody id="staff-tbody"></tbody>
            </table>
        </div>
        <div class="pg-wrap">
            <div class="pg-info">Showing <strong id="staff-showing">0</strong> of <strong id="staff-total">0</strong> members</div>
            <div class="pg-btns" id="staff-pagination"></div>
        </div>
    </div>
</section>

<!-- ═══ ROLES ═══ -->
<section id="page-roles" class="page">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px">
        <div><h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800">Roles & Permissions</h2><p style="font-size:1.20re;color:var(--text3);margin-top:3px">Define roles and control access</p></div>
        <button class="btn btn-primary btn-sm" onclick="openModal('add-role-modal')"><i class="ri-add-line"></i> Create Role</button>
    </div>
    <div class="g2" style="margin-bottom:20px;align-items:start">
        <div>
            <div class="section-title">Available Roles</div>
            <div style="display:flex;flex-direction:column;gap:10px" id="roles-list"></div>
        </div>
        <div>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
                <div class="section-title" style="margin:0">Permission Matrix</div>
                <span class="badge badge-purple" id="selected-role-badge">Select a role</span>
            </div>
            <div class="card" style="padding:18px"><div id="perm-matrix"><div style="text-align:center;padding:40px;color:var(--text4);font-size:1.20re"><i class="ri-key-2-line" style="font-size:2rem;display:block;margin-bottom:8px;opacity:.3"></i>Click a role to view permissions</div></div></div>
        </div>
    </div>
    <div class="card" style="padding:18px">
        <div class="section-title">Role Comparison Matrix</div>
        <div style="overflow-x:auto"><table class="data-table"><thead><tr id="perm-table-head"></tr></thead><tbody id="perm-table-body"></tbody></table></div>
    </div>
</section>

<!-- ═══ REMINDERS ═══ -->
<section id="page-reminders" class="page">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px">
        <div><h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800">Reminders Overview</h2><p style="font-size:1.20re;color:var(--text3);margin-top:3px">Monitor all platform reminders</p></div>
        <button class="btn btn-ghost btn-sm" onclick="toast('Reminders exported','success')"><i class="ri-download-2-line"></i> Export</button>
    </div>
    <div class="g4" style="margin-bottom:20px">
        <div class="stat-card"><div class="stat-ico" style="background:rgba(124,58,237,.15)"><i class="ri-alarm-line" style="color:var(--purple-light)"></i></div><div class="stat-num">48,320</div><div class="stat-lbl">Total Reminders</div></div>
        <div class="stat-card"><div class="stat-ico" style="background:rgba(16,185,129,.12)"><i class="ri-check-double-line" style="color:var(--green)"></i></div><div class="stat-num" style="color:var(--green)">42,940</div><div class="stat-lbl">Completed</div></div>
        <div class="stat-card"><div class="stat-ico" style="background:rgba(20,184,166,.12)"><i class="ri-time-line" style="color:var(--teal-light)"></i></div><div class="stat-num">4,280</div><div class="stat-lbl">Active</div></div>
        <div class="stat-card"><div class="stat-ico" style="background:rgba(244,63,94,.12)"><i class="ri-error-warning-line" style="color:var(--red)"></i></div><div class="stat-num" style="color:var(--red)">1,100</div><div class="stat-lbl">Overdue</div></div>
    </div>
    <div class="card" style="padding:18px">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;flex-wrap:wrap;gap:10px">
            <div class="section-title" style="margin:0">All Reminders</div>
            <div style="display:flex;gap:8px;flex-wrap:wrap">
                <div class="search-box" style="width:180px"><i class="ri-search-line" style="color:var(--text3);font-size:.85rem"></i><input placeholder="Search…" oninput="filterReminders(this.value)"></div>
                <select class="inp" style="width:auto;min-width:120px" id="rem-status-filter" onchange="filterReminders()"><option value="all">All Status</option><option value="active">Active</option><option value="completed">Completed</option><option value="overdue">Overdue</option></select>
            </div>
        </div>
        <div style="overflow-x:auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th class="hide-mobile">User</th>
                        <th class="hide-mobile">Category</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody id="rem-tbody"></tbody>
            </table>
        </div>
        <div class="pg-wrap">
            <div class="pg-info">Showing <strong id="rem-showing">0</strong> of <strong id="rem-total">0</strong> reminders</div>
            <div class="pg-btns" id="rem-pagination"></div>
        </div>
    </div>
</section>

<!-- ═══ TRANSACTIONS ═══ -->
<section id="page-transactions" class="page">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px">
        <div><h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800">Transactions</h2><p style="font-size:1.20re;color:var(--text3);margin-top:3px">All billing and payment records</p></div>
        <button class="btn btn-ghost btn-sm" onclick="toast('Transactions exported','success')"><i class="ri-download-2-line"></i> Export CSV</button>
    </div>
    <div class="g4" style="margin-bottom:20px">
        <div class="stat-card"><div class="stat-ico" style="background:rgba(16,185,129,.12)"><i class="ri-money-pound-circle-line" style="color:var(--green)"></i></div><div class="stat-num" style="color:var(--green)">£34,560</div><div class="stat-lbl">Total Revenue</div></div>
        <div class="stat-card"><div class="stat-ico" style="background:rgba(124,58,237,.15)"><i class="ri-bank-card-line" style="color:var(--purple-light)"></i></div><div class="stat-num">1,200</div><div class="stat-lbl">Transactions</div></div>
        <div class="stat-card"><div class="stat-ico" style="background:rgba(245,158,11,.12)"><i class="ri-time-line" style="color:var(--amber)"></i></div><div class="stat-num" style="color:var(--amber)">£480</div><div class="stat-lbl">Pending</div></div>
        <div class="stat-card"><div class="stat-ico" style="background:rgba(244,63,94,.12)"><i class="ri-refund-2-line" style="color:var(--red)"></i></div><div class="stat-num" style="color:var(--red)">£120</div><div class="stat-lbl">Refunded</div></div>
    </div>
    <div class="card" style="padding:18px">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;flex-wrap:wrap;gap:10px">
            <div class="section-title" style="margin:0">Transaction History</div>
            <div style="display:flex;gap:8px;flex-wrap:wrap">
                <div class="search-box" style="width:200px"><i class="ri-search-line" style="color:var(--text3);font-size:.85rem"></i><input placeholder="Search transactions…" oninput="filterTxn(this.value)"></div>
                <select class="inp" style="width:auto;min-width:130px" id="txn-status-filter" onchange="filterTxn()"><option value="all">All Status</option><option value="completed">Completed</option><option value="pending">Pending</option><option value="refunded">Refunded</option></select>
            </div>
        </div>
        <div style="overflow-x:auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Txn ID</th>
                        <th class="hide-mobile">User</th>
                        <th class="hide-mobile">Plan</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th class="hide-mobile">Date</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody id="txn-tbody"></tbody>
            </table>
        </div>
        <div class="pg-wrap">
            <div class="pg-info">Showing <strong id="txn-showing">0</strong> of <strong id="txn-total">0</strong> transactions</div>
            <div class="pg-btns" id="txn-pagination"></div>
        </div>
    </div>
</section>

<!-- ═══ CATEGORIES ═══ -->
<section id="page-categories" class="page">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px">
        <div><h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800">Categories</h2><p style="font-size:1.20re;color:var(--text3);margin-top:3px">Manage reminder categories</p></div>
        <button class="btn btn-primary btn-sm" onclick="openModal('add-category-modal')"><i class="ri-add-line"></i> Add Category</button>
    </div>
    <div id="admin-cat-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:14px"></div>
</section>

<!-- ═══ NOTIFICATIONS ═══ -->
<section id="page-notifications" class="page">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px">
        <div><h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800">Notification Center</h2><p style="font-size:1.20re;color:var(--text3);margin-top:3px">Manage system-wide notifications</p></div>
        <button class="btn btn-primary btn-sm" onclick="openModal('send-notif-modal')"><i class="ri-send-plane-line"></i> Send Notification</button>
    </div>
    <div class="tab-bar">
        <button class="tab-btn active" onclick="swTab('notif','inbox',this)">Inbox <span class="badge badge-red" style="font-size:.6rem;padding:1px 6px">5</span></button>
        <button class="tab-btn" onclick="swTab('notif','broadcast',this)">Broadcast</button>
        <button class="tab-btn" onclick="swTab('notif','templates',this)">Templates</button>
    </div>
    <div id="notif-tab-inbox" class="tab-pane active"><div style="display:flex;flex-direction:column;gap:8px" id="admin-notif-list"></div></div>
    <div id="notif-tab-broadcast" class="tab-pane">
        <div class="card" style="padding:24px">
            <div class="section-title">Broadcast Message</div>
            <div class="form-row"><label class="label">Target Audience</label><select class="inp"><option>All Users</option><option>Active Users</option><option>Pro Plan Users</option><option>Inactive (30+ days)</option></select></div>
            <div class="form-row"><label class="label">Channel</label><div style="display:flex;gap:8px;flex-wrap:wrap"><label style="display:flex;align-items:center;gap:6px;font-size:1.20re;color:var(--text2);cursor:pointer"><input type="checkbox" style="accent-color:var(--purple)" checked> Email</label><label style="display:flex;align-items:center;gap:6px;font-size:1.20re;color:var(--text2);cursor:pointer"><input type="checkbox" style="accent-color:var(--purple)"> SMS</label><label style="display:flex;align-items:center;gap:6px;font-size:1.20re;color:var(--text2);cursor:pointer"><input type="checkbox" style="accent-color:var(--purple)" checked> Push</label><label style="display:flex;align-items:center;gap:6px;font-size:1.20re;color:var(--text2);cursor:pointer"><input type="checkbox" style="accent-color:var(--purple)"> WhatsApp</label></div></div>
            <div class="form-row"><label class="label">Subject</label><input class="inp" placeholder="Notification subject…"></div>
            <div class="form-row"><label class="label">Message</label><textarea class="inp" rows="4" placeholder="Write your message…" style="resize:vertical"></textarea></div>
            <div style="display:flex;gap:8px;justify-content:flex-end"><button class="btn btn-ghost btn-sm">Preview</button><button class="btn btn-primary btn-sm" onclick="toast('Broadcast sent to 1,284 users!','success')"><i class="ri-send-plane-line"></i> Send Now</button></div>
        </div>
    </div>
    <div id="notif-tab-templates" class="tab-pane"><div class="card" style="padding:18px"><div style="text-align:center;padding:40px;color:var(--text4)"><i class="ri-file-text-line" style="font-size:2rem;display:block;margin-bottom:8px;opacity:.3"></i><p style="font-size:1.20re">Notification templates coming soon</p></div></div></div>
</section>

<!-- ═══ PROFILE ═══ -->
<section id="page-profile" class="page">
    <div style="margin-bottom:20px"><h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800">My Profile</h2><p style="font-size:1.20re;color:var(--text3);margin-top:3px">Manage your admin account</p></div>
    <div class="g2">
        <div style="display:flex;flex-direction:column;gap:16px">
            <div class="card" style="padding:24px">
                <div style="display:flex;align-items:center;gap:16px;margin-bottom:22px">
                    <div style="position:relative;cursor:pointer">
                        <div style="width:72px;height:72px;border-radius:16px;background:linear-gradient(135deg,#7c3aed,#0d9488);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.4rem;font-weight:700;box-shadow:0 6px 20px rgba(124,58,237,.3)">SA</div>
                        <div style="position:absolute;bottom:-5px;right:-5px;width:24px;height:24px;border-radius:7px;background:var(--purple);display:flex;align-items:center;justify-content:center;border:2px solid var(--bg2)"><i class="ri-camera-line" style="color:#fff;font-size:.65rem"></i></div>
                    </div>
                    <div>
                        <div class="font-jakarta" style="font-weight:700;font-size:1rem;color:var(--text)">Super Admin</div>
                        <div style="font-size:.75rem;color:var(--text3);margin-top:2px">System Administrator</div>
                        <span class="badge badge-purple" style="margin-top:6px"><i class="ri-shield-flash-line"></i> Full Access</span>
                    </div>
                </div>
                <div style="display:flex;flex-direction:column;gap:13px">
                    <div><label class="label">Full Name</label><input class="inp" value="Super Admin"></div>
                    <div><label class="label">Email Address</label><input class="inp" type="email" value="admin@dremind.co.uk"></div>
                    <div><label class="label">Phone</label><input class="inp" type="tel" value="+44 7700 900000"></div>
                    <div><label class="label">Timezone</label><select class="inp"><option>Europe/London (GMT+1)</option><option>UTC</option></select></div>
                    <button class="btn btn-primary" style="justify-content:center" onclick="toast('Profile saved!','success')"><i class="ri-save-line"></i> Save Changes</button>
                </div>
            </div>
            <div class="card" style="padding:22px">
                <div class="section-title">Security</div>
                <div style="display:flex;flex-direction:column;gap:12px">
                    <div><label class="label">Current Password</label><input class="inp" type="password" placeholder="••••••••"></div>
                    <div><label class="label">New Password</label><input class="inp" type="password" placeholder="Min 8 characters"></div>
                    <div><label class="label">Confirm Password</label><input class="inp" type="password" placeholder="Repeat password"></div>
                    <button class="btn btn-primary" style="justify-content:center" onclick="toast('Password updated!','success')"><i class="ri-lock-password-line"></i> Update Password</button>
                </div>
            </div>
        </div>
        <div style="display:flex;flex-direction:column;gap:16px">
            <div class="card" style="padding:22px">
                <div class="section-title">Security Preferences</div>
                <div style="display:flex;flex-direction:column;gap:10px">
                    <div style="display:flex;align-items:center;justify-content:space-between;padding:11px;border-radius:var(--radius-sm);background:rgba(255,255,255,.03);border:1px solid var(--border2)"><div><div style="font-size:.85rem;font-weight:600;color:var(--text2)">Two-Factor Authentication</div><div style="font-size:.73rem;color:var(--text3)">Enhance your security</div></div><button class="toggle on" onclick="this.classList.toggle('on')"></button></div>
                    <div style="display:flex;align-items:center;justify-content:space-between;padding:11px;border-radius:var(--radius-sm);background:rgba(255,255,255,.03);border:1px solid var(--border2)"><div><div style="font-size:.85rem;font-weight:600;color:var(--text2)">Login Notifications</div><div style="font-size:.73rem;color:var(--text3)">Get alerts on new logins</div></div><button class="toggle on" onclick="this.classList.toggle('on')"></button></div>
                    <div style="display:flex;align-items:center;justify-content:space-between;padding:11px;border-radius:var(--radius-sm);background:rgba(255,255,255,.03);border:1px solid var(--border2)"><div><div style="font-size:.85rem;font-weight:600;color:var(--text2)">Activity Digest</div><div style="font-size:.73rem;color:var(--text3)">Weekly admin summary</div></div><button class="toggle" onclick="this.classList.toggle('on')"></button></div>
                </div>
            </div>
            <div class="card" style="padding:22px"><div class="section-title">Recent Activity</div><div style="display:flex;flex-direction:column;gap:8px" id="profile-activity"></div></div>
            <div class="danger-zone">
                <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:var(--red);margin-bottom:6px"><i class="ri-alert-line"></i> Danger Zone</h3>
                <p style="font-size:.8rem;color:var(--text3);margin-bottom:10px">These actions are irreversible.</p>
                <div style="display:flex;gap:8px;flex-wrap:wrap">
                    <button class="btn btn-danger btn-sm" onclick="toast('Logged out from all devices','warning')"><i class="ri-logout-box-r-line"></i> Logout Everywhere</button>
                    <button class="btn btn-danger btn-sm" onclick="toast('Audit log cleared','warning')"><i class="ri-delete-bin-line"></i> Clear Audit Log</button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══ SETTINGS ═══ -->
<section id="page-settings" class="page">
    <div style="margin-bottom:20px"><h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800">System Settings</h2><p style="font-size:1.20re;color:var(--text3);margin-top:3px">Configure platform-wide settings</p></div>
    <div class="tab-bar">
        <button class="tab-btn active" onclick="swTab('set','general',this)">General</button>
        <button class="tab-btn" onclick="swTab('set','email',this)">Email</button>
        <button class="tab-btn" onclick="swTab('set','billing',this)">Billing</button>
        <button class="tab-btn" onclick="swTab('set','security',this)">Security</button>
        <button class="tab-btn" onclick="swTab('set','integrations',this)">Integrations</button>
    </div>
    <div id="set-tab-general" class="tab-pane active">
        <div class="g2">
            <div><div class="card" style="padding:22px"><div class="section-title">Platform Settings</div><div style="display:flex;flex-direction:column;gap:13px"><div><label class="label">Platform Name</label><input class="inp" value="D-Remind"></div><div><label class="label">Support Email</label><input class="inp" value="support@dremind.co.uk"></div><div><label class="label">Default Country</label><select class="inp"><option>United Kingdom</option><option>United States</option></select></div><div><label class="label">Default Currency</label><select class="inp"><option>GBP (£)</option><option>USD ($)</option><option>EUR (€)</option></select></div><button class="btn btn-primary" style="justify-content:center" onclick="toast('Settings saved!','success')"><i class="ri-save-line"></i> Save</button></div></div></div>
            <div style="display:flex;flex-direction:column;gap:16px">
                <div class="card" style="padding:22px"><div class="section-title">Feature Flags</div><div style="display:flex;flex-direction:column;gap:10px" id="feature-flags"></div></div>
                <div class="card" style="padding:22px;background:rgba(245,158,11,.05);border:1px solid rgba(245,158,11,.2)"><div style="display:flex;align-items:center;gap:10px;margin-bottom:10px"><i class="ri-tools-line" style="color:var(--amber);font-size:1.1rem"></i><div class="section-title" style="margin:0">Maintenance Mode</div></div><p style="font-size:.8rem;color:var(--text3);margin-bottom:12px">Enabling this will show a maintenance page to all non-admin users.</p><div style="display:flex;align-items:center;gap:10px"><button class="toggle" id="maint-toggle" onclick="this.classList.toggle('on');toast(this.classList.contains('on')?'Maintenance mode ON':'Maintenance mode OFF',this.classList.contains('on')?'warning':'success')"></button><span style="font-size:1.20re;color:var(--text2)">Maintenance Mode</span></div></div>
            </div>
        </div>
    </div>
    <div id="set-tab-email" class="tab-pane">
        <div class="card" style="padding:22px"><div class="section-title">SMTP Configuration</div><div class="g2" style="margin-bottom:13px"><div><label class="label">SMTP Host</label><input class="inp" value="smtp.mailgun.org"></div><div><label class="label">SMTP Port</label><input class="inp" value="587"></div></div><div class="g2" style="margin-bottom:13px"><div><label class="label">Username</label><input class="inp" value="admin@dremind.co.uk"></div><div><label class="label">Password</label><input class="inp" type="password" value="••••••••••••"></div></div><div style="margin-bottom:13px"><label class="label">From Name</label><input class="inp" value="D-Remind"></div><div style="display:flex;gap:8px;justify-content:flex-end"><button class="btn btn-ghost btn-sm" onclick="toast('Test email sent!','success')"><i class="ri-mail-send-line"></i> Send Test</button><button class="btn btn-primary btn-sm" onclick="toast('SMTP settings saved!','success')"><i class="ri-save-line"></i> Save</button></div></div>
    </div>
    <div id="set-tab-billing" class="tab-pane"><div class="card" style="padding:22px"><div class="section-title">Plan Configuration</div><div style="display:flex;flex-direction:column;gap:10px" id="plan-config"></div></div></div>
    <div id="set-tab-security" class="tab-pane">
        <div class="card" style="padding:22px"><div class="section-title">Security Settings</div><div style="display:flex;flex-direction:column;gap:10px"><div style="display:flex;align-items:center;justify-content:space-between;padding:11px;border-radius:var(--radius-sm);background:rgba(255,255,255,.03);border:1px solid var(--border2)"><div><div style="font-size:.85rem;font-weight:600;color:var(--text2)">Force 2FA for Admins</div><div style="font-size:.73rem;color:var(--text3)">Require 2FA for all admin accounts</div></div><button class="toggle on" onclick="this.classList.toggle('on')"></button></div><div style="display:flex;align-items:center;justify-content:space-between;padding:11px;border-radius:var(--radius-sm);background:rgba(255,255,255,.03);border:1px solid var(--border2)"><div><div style="font-size:.85rem;font-weight:600;color:var(--text2)">IP Whitelist</div><div style="font-size:.73rem;color:var(--text3)">Restrict admin access to specific IPs</div></div><button class="toggle" onclick="this.classList.toggle('on')"></button></div><div style="display:flex;align-items:center;justify-content:space-between;padding:11px;border-radius:var(--radius-sm);background:rgba(255,255,255,.03);border:1px solid var(--border2)"><div><div style="font-size:.85rem;font-weight:600;color:var(--text2)">Rate Limiting</div><div style="font-size:.73rem;color:var(--text3)">API rate limits (100 req/min)</div></div><button class="toggle on" onclick="this.classList.toggle('on')"></button></div><div><label class="label">Session Timeout (minutes)</label><input class="inp" value="60" type="number" min="5" max="1440"></div><button class="btn btn-primary btn-sm" style="align-self:flex-end" onclick="toast('Security settings saved!','success')"><i class="ri-save-line"></i> Save</button></div></div>
    </div>
    <div id="set-tab-integrations" class="tab-pane"><div style="display:flex;flex-direction:column;gap:12px" id="integrations-list"></div></div>
</section>

<!-- ═══ AUDIT LOG ═══ -->
<section id="page-audit" class="page">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px">
        <div><h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800">Audit Log</h2><p style="font-size:1.20re;color:var(--text3);margin-top:3px">Complete record of admin and system actions</p></div>
        <div style="display:flex;gap:8px">
            <button class="btn btn-ghost btn-sm" onclick="toast('Audit log exported','success')"><i class="ri-download-2-line"></i> Export</button>
            <button class="btn btn-danger btn-sm" onclick="openConfirm('Clear all audit log entries?',()=>toast('Log cleared','warning'))"><i class="ri-delete-bin-line"></i> Clear Log</button>
        </div>
    </div>
    <div class="card" style="padding:14px;margin-bottom:14px">
        <div style="display:flex;flex-wrap:wrap;gap:10px;align-items:center">
            <div class="search-box" style="flex:1;min-width:200px"><i class="ri-search-line" style="color:var(--text3);font-size:.85rem"></i><input placeholder="Search log entries…" oninput="filterAudit(this.value)"></div>
            <select class="inp" style="width:auto;min-width:130px" id="audit-action-filter" onchange="filterAudit()"><option value="all">All Actions</option><option value="Create">Create</option><option value="Update">Update</option><option value="Delete">Delete</option><option value="Login">Login</option></select>
        </div>
    </div>
    <div class="card" style="padding:18px">
        <div style="display:flex;flex-direction:column;gap:8px" id="audit-list"></div>
        <div class="pg-wrap">
            <div class="pg-info">Showing <strong id="audit-showing">0</strong> of <strong id="audit-total">0</strong> entries</div>
            <div class="pg-btns" id="audit-pagination"></div>
        </div>
    </div>
</section>

<!-- ═══ FEEDBACK ═══ -->
<section id="page-feedback" class="page">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px">
        <div><h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800">User Feedback</h2><p style="font-size:1.20re;color:var(--text3);margin-top:3px">Review and manage user submitted feedback</p></div>
        <div style="display:flex;gap:6px">
            <select class="inp" style="width:auto;min-width:130px" id="fb-type-filter" onchange="filterFeedback()"><option value="all">All Types</option><option value="bug">Bug Report</option><option value="feature">Feature Request</option><option value="compliment">Compliment</option></select>
            <select class="inp" style="width:auto;min-width:130px" id="fb-status-filter" onchange="filterFeedback()"><option value="all">All Status</option><option value="open">Open</option><option value="resolved">Resolved</option><option value="pending">Pending</option></select>
        </div>
    </div>
    <div class="g4" style="margin-bottom:20px">
        <div class="stat-card"><div class="stat-ico" style="background:rgba(124,58,237,.15)"><i class="ri-feedback-line" style="color:var(--purple-light)"></i></div><div class="stat-num">128</div><div class="stat-lbl">Total Feedback</div></div>
        <div class="stat-card"><div class="stat-ico" style="background:rgba(244,63,94,.12)"><i class="ri-bug-line" style="color:var(--red)"></i></div><div class="stat-num" style="color:var(--red)">12</div><div class="stat-lbl">Bug Reports</div></div>
        <div class="stat-card"><div class="stat-ico" style="background:rgba(16,185,129,.12)"><i class="ri-thumb-up-line" style="color:var(--green)"></i></div><div class="stat-num" style="color:var(--green)">89</div><div class="stat-lbl">Resolved</div></div>
        <div class="stat-card"><div class="stat-ico" style="background:rgba(245,158,11,.12)"><i class="ri-time-line" style="color:var(--amber)"></i></div><div class="stat-num" style="color:var(--amber)">27</div><div class="stat-lbl">Pending</div></div>
    </div>
    <div class="card" style="padding:18px"><div style="display:flex;flex-direction:column;gap:8px" id="feedback-list"></div></div>
</section>

</main>
</div><!-- end main-wrap -->
</div><!-- end app -->

<!-- ═══════════════════════════════════
     MODALS
═══════════════════════════════════ -->

<!-- ADD USER -->
<div class="modal-bg" id="add-user-modal">
    <div class="modal-box">
        <div class="modal-header">
            <div><h3 class="font-jakarta" style="font-weight:700;font-size:.95rem;color:var(--text)"><i class="ri-user-add-line" style="color:var(--teal-light);margin-right:6px"></i>Add New User</h3><p style="font-size:.76rem;color:var(--text3);margin-top:2px">Create a new user account</p></div>
            <button class="modal-close" onclick="closeModal('add-user-modal')"><i class="ri-close-line"></i></button>
        </div>
        <div class="g2" style="margin-bottom:14px">
            <div><label class="label">First Name <span style="color:var(--red)">*</span></label><input class="inp" id="au-fname" placeholder="John"></div>
            <div><label class="label">Last Name <span style="color:var(--red)">*</span></label><input class="inp" id="au-lname" placeholder="Smith"></div>
        </div>
        <div style="margin-bottom:14px"><label class="label">Email <span style="color:var(--red)">*</span></label><input class="inp" id="au-email" type="email" placeholder="john@example.com"></div>
        <div class="g2" style="margin-bottom:14px">
            <div><label class="label">Plan</label><select class="inp" id="au-plan"><option>Basic Annual</option><option>Pro</option><option>Free</option></select></div>
            <div><label class="label">Status</label><select class="inp" id="au-status"><option value="active">Active</option><option value="suspended">Suspended</option></select></div>
        </div>
        <div style="margin-bottom:18px"><label class="label">Phone</label><input class="inp" id="au-phone" placeholder="+44 7700 000000"></div>
        <div style="display:flex;gap:8px;justify-content:flex-end">
            <button class="btn btn-ghost btn-sm" onclick="closeModal('add-user-modal')">Cancel</button>
            <button class="btn btn-primary btn-sm" onclick="addUser()"><i class="ri-check-line"></i> Create User</button>
        </div>
    </div>
</div>

<!-- EDIT USER -->
<div class="modal-bg" id="edit-user-modal">
    <div class="modal-box">
        <div class="modal-header">
            <div><h3 class="font-jakarta" style="font-weight:700;font-size:.95rem;color:var(--text)"><i class="ri-pencil-line" style="color:var(--purple-light);margin-right:6px"></i>Edit User</h3><p style="font-size:.76rem;color:var(--text3);margin-top:2px">Update user account details</p></div>
            <button class="modal-close" onclick="closeModal('edit-user-modal')"><i class="ri-close-line"></i></button>
        </div>
        <input type="hidden" id="eu-id">
        <div class="g2" style="margin-bottom:14px">
            <div><label class="label">Full Name <span style="color:var(--red)">*</span></label><input class="inp" id="eu-name" placeholder="Full name"></div>
            <div><label class="label">Email <span style="color:var(--red)">*</span></label><input class="inp" id="eu-email" type="email" placeholder="Email"></div>
        </div>
        <div class="g2" style="margin-bottom:14px">
            <div><label class="label">Plan</label><select class="inp" id="eu-plan"><option>Basic Annual</option><option>Pro</option><option>Free</option></select></div>
            <div><label class="label">Status</label><select class="inp" id="eu-status"><option value="active">Active</option><option value="suspended">Suspended</option></select></div>
        </div>
        <div style="margin-bottom:18px"><label class="label">Phone</label><input class="inp" id="eu-phone" placeholder="+44 7700 000000"></div>
        <div style="display:flex;gap:8px;justify-content:flex-end">
            <button class="btn btn-ghost btn-sm" onclick="closeModal('edit-user-modal')">Cancel</button>
            <button class="btn btn-primary btn-sm" onclick="saveEditUser()"><i class="ri-save-line"></i> Save Changes</button>
        </div>
    </div>
</div>

<!-- ADD STAFF -->
<div class="modal-bg" id="add-staff-modal">
    <div class="modal-box">
        <div class="modal-header">
            <div><h3 class="font-jakarta" style="font-weight:700;font-size:.95rem;color:var(--text)"><i class="ri-team-line" style="color:var(--purple-light);margin-right:6px"></i>Add Staff Member</h3><p style="font-size:.76rem;color:var(--text3);margin-top:2px">Add a new team member with a specific role</p></div>
            <button class="modal-close" onclick="closeModal('add-staff-modal')"><i class="ri-close-line"></i></button>
        </div>
        <div class="g2" style="margin-bottom:14px">
            <div><label class="label">Full Name <span style="color:var(--red)">*</span></label><input class="inp" id="as-name" placeholder="Jane Doe"></div>
            <div><label class="label">Email <span style="color:var(--red)">*</span></label><input class="inp" id="as-email" placeholder="jane@dremind.co.uk"></div>
        </div>
        <div class="g2" style="margin-bottom:14px">
            <div><label class="label">Role <span style="color:var(--red)">*</span></label><select class="inp" id="staff-role-sel"><option value="">Select role…</option></select></div>
            <div><label class="label">Department</label><select class="inp" id="as-dept"><option>Engineering</option><option>Support</option><option>Marketing</option><option>Finance</option></select></div>
        </div>
        <div style="margin-bottom:18px"><label class="label">Phone</label><input class="inp" id="as-phone" placeholder="+44 7700 000000"></div>
        <div style="display:flex;gap:8px;justify-content:flex-end">
            <button class="btn btn-ghost btn-sm" onclick="closeModal('add-staff-modal')">Cancel</button>
            <button class="btn btn-primary btn-sm" onclick="addStaffMember()"><i class="ri-check-line"></i> Add Staff</button>
        </div>
    </div>
</div>

<!-- EDIT STAFF -->
<div class="modal-bg" id="edit-staff-modal">
    <div class="modal-box">
        <div class="modal-header">
            <div><h3 class="font-jakarta" style="font-weight:700;font-size:.95rem;color:var(--text)"><i class="ri-pencil-line" style="color:var(--teal-light);margin-right:6px"></i>Edit Staff Member</h3><p style="font-size:.76rem;color:var(--text3);margin-top:2px">Update staff details and role</p></div>
            <button class="modal-close" onclick="closeModal('edit-staff-modal')"><i class="ri-close-line"></i></button>
        </div>
        <input type="hidden" id="es-id">
        <div class="g2" style="margin-bottom:14px">
            <div><label class="label">Full Name</label><input class="inp" id="es-name"></div>
            <div><label class="label">Email</label><input class="inp" id="es-email" type="email"></div>
        </div>
        <div class="g2" style="margin-bottom:14px">
            <div><label class="label">Role</label><select class="inp" id="es-role"></select></div>
            <div><label class="label">Status</label><select class="inp" id="es-status"><option value="active">Active</option><option value="inactive">Inactive</option></select></div>
        </div>
        <div style="display:flex;gap:8px;justify-content:flex-end">
            <button class="btn btn-ghost btn-sm" onclick="closeModal('edit-staff-modal')">Cancel</button>
            <button class="btn btn-primary btn-sm" onclick="saveEditStaff()"><i class="ri-save-line"></i> Save Changes</button>
        </div>
    </div>
</div>

<!-- ADD ROLE -->
<div class="modal-bg" id="add-role-modal">
    <div class="modal-box" style="max-width:640px">
        <div class="modal-header">
            <div><h3 class="font-jakarta" style="font-weight:700;font-size:.95rem;color:var(--text)"><i class="ri-key-2-line" style="color:var(--amber);margin-right:6px"></i>Create Role</h3><p style="font-size:.76rem;color:var(--text3);margin-top:2px">Define a new role with specific permissions</p></div>
            <button class="modal-close" onclick="closeModal('add-role-modal')"><i class="ri-close-line"></i></button>
        </div>
        <div class="g2" style="margin-bottom:14px">
            <div><label class="label">Role Name <span style="color:var(--red)">*</span></label><input class="inp" id="new-role-name" placeholder="e.g. Content Manager"></div>
            <div><label class="label">Color</label><div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:4px" id="role-color-picker"></div></div>
        </div>
        <div style="margin-bottom:14px"><label class="label">Description</label><input class="inp" id="new-role-desc" placeholder="What does this role do?"></div>
        <div style="margin-bottom:16px"><label class="label">Permissions</label><div class="perm-grid" id="new-role-perms" style="margin-top:8px"></div></div>
        <div style="display:flex;gap:8px;justify-content:flex-end">
            <button class="btn btn-ghost btn-sm" onclick="closeModal('add-role-modal')">Cancel</button>
            <button class="btn btn-primary btn-sm" onclick="createRole()"><i class="ri-check-line"></i> Create Role</button>
        </div>
    </div>
</div>

<!-- SEND NOTIFICATION -->
<div class="modal-bg" id="send-notif-modal">
    <div class="modal-box">
        <div class="modal-header">
            <div><h3 class="font-jakarta" style="font-weight:700;font-size:.95rem;color:var(--text)"><i class="ri-send-plane-line" style="color:var(--teal-light);margin-right:6px"></i>Send Notification</h3></div>
            <button class="modal-close" onclick="closeModal('send-notif-modal')"><i class="ri-close-line"></i></button>
        </div>
        <div style="margin-bottom:14px"><label class="label">Target</label><select class="inp"><option>All Users</option><option>Specific User</option><option>Pro Plan Users</option></select></div>
        <div style="margin-bottom:14px"><label class="label">Type</label><select class="inp"><option>Info</option><option>Warning</option><option>Success</option><option>Alert</option></select></div>
        <div style="margin-bottom:14px"><label class="label">Title</label><input class="inp" placeholder="Notification title…"></div>
        <div style="margin-bottom:18px"><label class="label">Message</label><textarea class="inp" rows="3" placeholder="Message…" style="resize:none"></textarea></div>
        <div style="display:flex;gap:8px;justify-content:flex-end">
            <button class="btn btn-ghost btn-sm" onclick="closeModal('send-notif-modal')">Cancel</button>
            <button class="btn btn-primary btn-sm" onclick="toast('Notification sent!','success');closeModal('send-notif-modal')"><i class="ri-send-plane-line"></i> Send</button>
        </div>
    </div>
</div>

<!-- VIEW REMINDER -->
<div class="modal-bg" id="view-reminder-modal">
    <div class="modal-box">
        <div class="modal-header">
            <div><h3 class="font-jakarta" style="font-weight:700;font-size:.95rem;color:var(--text)"><i class="ri-alarm-line" style="color:var(--teal-light);margin-right:6px"></i>Reminder Details</h3></div>
            <button class="modal-close" onclick="closeModal('view-reminder-modal')"><i class="ri-close-line"></i></button>
        </div>
        <div id="rem-modal-content"></div>
        <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:20px">
            <button class="btn btn-ghost btn-sm" onclick="closeModal('view-reminder-modal')">Close</button>
            <button class="btn btn-primary btn-sm" onclick="toast('Reminder updated!','success');closeModal('view-reminder-modal')"><i class="ri-save-line"></i> Save Changes</button>
        </div>
    </div>
</div>

<!-- VIEW TRANSACTION -->
<div class="modal-bg" id="view-txn-modal">
    <div class="modal-box">
        <div class="modal-header">
            <div><h3 class="font-jakarta" style="font-weight:700;font-size:.95rem;color:var(--text)"><i class="ri-bank-card-line" style="color:var(--green);margin-right:6px"></i>Transaction Details</h3></div>
            <button class="modal-close" onclick="closeModal('view-txn-modal')"><i class="ri-close-line"></i></button>
        </div>
        <div id="txn-modal-content"></div>
        <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:20px">
            <button class="btn btn-ghost btn-sm" onclick="closeModal('view-txn-modal')">Close</button>
            <button class="btn btn-ghost btn-sm" onclick="toast('Invoice downloaded!','success')"><i class="ri-download-line"></i> Download Invoice</button>
        </div>
    </div>
</div>

<!-- ADD CATEGORY -->
<div class="modal-bg" id="add-category-modal">
    <div class="modal-box">
        <div class="modal-header">
            <div><h3 class="font-jakarta" style="font-weight:700;font-size:.95rem;color:var(--text)"><i class="ri-folder-add-line" style="color:var(--amber);margin-right:6px"></i>Add Category</h3><p style="font-size:.76rem;color:var(--text3);margin-top:2px">Create a new reminder category</p></div>
            <button class="modal-close" onclick="closeModal('add-category-modal')"><i class="ri-close-line"></i></button>
        </div>
        <div style="margin-bottom:14px"><label class="label">Category Name <span style="color:var(--red)">*</span></label><input class="inp" placeholder="e.g. Fitness"></div>
        <div class="g2" style="margin-bottom:14px">
            <div><label class="label">Icon (Remixicon class)</label><input class="inp" placeholder="ri-heart-line"></div>
            <div><label class="label">Colour</label><input class="inp" type="color" value="#7c3aed" style="height:42px;padding:4px"></div>
        </div>
        <div style="margin-bottom:18px"><label class="label">Description</label><input class="inp" placeholder="Brief description…"></div>
        <div style="display:flex;gap:8px;justify-content:flex-end">
            <button class="btn btn-ghost btn-sm" onclick="closeModal('add-category-modal')">Cancel</button>
            <button class="btn btn-primary btn-sm" onclick="toast('Category created!','success');closeModal('add-category-modal')"><i class="ri-check-line"></i> Create</button>
        </div>
    </div>
</div>

<!-- CONFIRM ACTION -->
<div class="modal-bg" id="confirm-modal">
    <div class="modal-box" style="max-width:420px">
        <div class="modal-header">
            <div><h3 class="font-jakarta" style="font-weight:700;font-size:.95rem;color:var(--red)"><i class="ri-alert-line" style="margin-right:6px"></i>Confirm Action</h3></div>
            <button class="modal-close" onclick="closeModal('confirm-modal')"><i class="ri-close-line"></i></button>
        </div>
        <p id="confirm-msg" style="font-size:.85rem;color:var(--text2);margin-bottom:24px;line-height:1.6"></p>
        <div style="display:flex;gap:8px;justify-content:flex-end">
            <button class="btn btn-ghost btn-sm" onclick="closeModal('confirm-modal')">Cancel</button>
            <button class="btn btn-danger btn-sm" id="confirm-ok-btn"><i class="ri-check-line"></i> Confirm</button>
        </div>
    </div>
</div>

<!-- DRAWER -->
<div style="position:fixed;inset:0;background:rgba(0,0,0,.6);backdrop-filter:blur(5px);z-index:9997;opacity:0;pointer-events:none;transition:opacity .25s" id="drawer-overlay" onclick="closeDrawer()"></div>
<div style="position:fixed;top:0;right:0;width:min(440px,100vw);height:100vh;background:#0c0c1e;border-left:1px solid rgba(124,58,237,.2);z-index:9998;transform:translateX(100%);transition:transform .32s cubic-bezier(.16,1,.3,1);overflow-y:auto;padding:26px;box-shadow:-20px 0 60px rgba(0,0,0,.5)" id="detail-drawer">
    <div id="drawer-content"></div>
</div>

<script>
/* ══════════════════════════════════════════
   DATA
══════════════════════════════════════════ */
const ROLES_DATA = [
    {id:'superadmin',name:'Super Admin',color:'#7c3aed',desc:'Full system access',perms:['all'],count:1},
    {id:'manager',name:'Manager',color:'#0d9488',desc:'Manage users and content',perms:['users.read','users.write','reminders.read','reminders.write','analytics.read'],count:2},
    {id:'support',name:'Support Agent',color:'#f59e0b',desc:'Handle user queries',perms:['users.read','reminders.read','notifications.send'],count:3},
    {id:'analyst',name:'Analyst',color:'#06b6d4',desc:'View analytics only',perms:['analytics.read','users.read'],count:1},
    {id:'moderator',name:'Moderator',color:'#10b981',desc:'Moderate content and feedback',perms:['users.read','feedback.read','feedback.write'],count:1},
];

const ALL_PERMS = [
    {key:'users.read',label:'View Users',group:'Users'},{key:'users.write',label:'Edit Users',group:'Users'},{key:'users.delete',label:'Delete Users',group:'Users'},
    {key:'reminders.read',label:'View Reminders',group:'Reminders'},{key:'reminders.write',label:'Edit Reminders',group:'Reminders'},{key:'reminders.delete',label:'Delete Reminders',group:'Reminders'},
    {key:'analytics.read',label:'View Analytics',group:'Analytics'},{key:'analytics.export',label:'Export Analytics',group:'Analytics'},
    {key:'notifications.send',label:'Send Notifications',group:'Notifications'},{key:'notifications.manage',label:'Manage Notifications',group:'Notifications'},
    {key:'staff.manage',label:'Manage Staff',group:'Team'},{key:'roles.manage',label:'Manage Roles',group:'Team'},
    {key:'settings.read',label:'View Settings',group:'System'},{key:'settings.write',label:'Edit Settings',group:'System'},{key:'audit.read',label:'View Audit Log',group:'System'},
    {key:'billing.read',label:'View Billing',group:'Billing'},{key:'billing.write',label:'Edit Billing',group:'Billing'},
    {key:'feedback.read',label:'View Feedback',group:'Support'},{key:'feedback.write',label:'Respond Feedback',group:'Support'},
    {key:'categories.manage',label:'Manage Categories',group:'Content'},
];

const NAMES = ['Kishore Rex','Sarah Johnson','Michael Chen','Emma Williams','James Brown','Olivia Davis','William Taylor','Sophia Martinez'];
const INITS = ['KR','SJ','MC','EW','JB','OD','WT','SM'];
const COLORS_U = ['#7c3aed','#0d9488','#f59e0b','#10b981','#f43f5e','#06b6d4','#ec4899','#a78bfa'];

const USERS_DATA = Array.from({length:28},(_,i)=>({
    id:i+1,
    name:NAMES[i%8],
    email:'user'+(i+1)+'@example.com',
    plan:['Basic Annual','Basic Annual','Pro','Free'][i%4],
    rems:Math.floor(Math.random()*60+2),
    status:i===5?'suspended':'active',
    joined:new Date(Date.now()-Math.random()*3e7).toLocaleDateString('en-GB',{day:'2-digit',month:'short',year:'numeric'}),
    phone:'+44 7700 9'+String(10000+i).slice(1),
    initials:INITS[i%8],
    color:COLORS_U[i%8],
}));

const STAFF_DATA = [
    {id:1,name:'Alex Morgan',email:'alex@dremind.co.uk',role:'manager',status:'active',last:'2h ago',initials:'AM',color:'#0d9488'},
    {id:2,name:'Priya Patel',email:'priya@dremind.co.uk',role:'support',status:'active',last:'30m ago',initials:'PP',color:'#f59e0b'},
    {id:3,name:'Tom Walker',email:'tom@dremind.co.uk',role:'analyst',status:'active',last:'1d ago',initials:'TW',color:'#06b6d4'},
    {id:4,name:'Rachel Green',email:'rachel@dremind.co.uk',role:'moderator',status:'active',last:'5h ago',initials:'RG',color:'#10b981'},
    {id:5,name:'James Lee',email:'james@dremind.co.uk',role:'support',status:'inactive',last:'14d ago',initials:'JL',color:'#94a3b8'},
    {id:6,name:'Fatima Khan',email:'fatima@dremind.co.uk',role:'support',status:'active',last:'1h ago',initials:'FK',color:'#ec4899'},
    {id:7,name:'David Smith',email:'david@dremind.co.uk',role:'manager',status:'active',last:'3h ago',initials:'DS',color:'#7c3aed'},
    {id:8,name:'Nina Johansson',email:'nina@dremind.co.uk',role:'analyst',status:'active',last:'6h ago',initials:'NJ',color:'#f43f5e'},
];

const REM_TITLES = ['Car Insurance Renewal','TV Licence','MOT Due','Home Insurance','Passport Renewal','Gym Membership','Netflix Subscription','Council Tax','Water Bill','Phone Contract','Boiler Service','Road Tax','Pet Insurance','Dental Checkup','Eye Test','Dentist Appointment','Broadband Contract','Sky TV Renewal','Amazon Prime','AA Membership'];
const REM_CATS = ['Motor Vehicle','Subscriptions','Insurance','Health','Special Days','Home','TV, Tel & Mobile','Travel'];
const REMINDERS_DATA = Array.from({length:30},(_,i)=>({
    id:1001+i,
    title:REM_TITLES[i%REM_TITLES.length],
    user:USERS_DATA[i%USERS_DATA.length],
    category:REM_CATS[i%REM_CATS.length],
    due:new Date(Date.now()+((i-8)*86400000*2)),
    status:i===3||i===8||i===15?'overdue':i%3===0?'completed':'active',
    notes:'Auto-reminder set by user. Notification via Email & SMS.',
    created:new Date(Date.now()-i*86400000*5),
    priority:['low','medium','high'][i%3],
}));

const TXN_DATA = Array.from({length:30},(_,i)=>({
    id:10000+i,
    txnId:'TXN-'+(10000+i),
    user:USERS_DATA[i%USERS_DATA.length],
    plan:['Basic Annual','Basic Annual','Pro','Basic Annual'][i%4],
    amount:'£2.40',
    status:i===2?'pending':i===5?'refunded':'completed',
    date:new Date(Date.now()-i*86400000*3),
    method:['Visa •••• 4242','Mastercard •••• 8888','PayPal'][i%3],
}));

const CATS_DATA = [
    {name:'Special Days',icon:'ri-cake-3-line',color:'#f59e0b',bg:'rgba(245,158,11,.12)',count:8,total:312},
    {name:'Home',icon:'ri-home-4-line',color:'#14b8a6',bg:'rgba(20,184,166,.12)',count:5,total:198},
    {name:'Insurance',icon:'ri-shield-star-line',color:'#f43f5e',bg:'rgba(244,63,94,.12)',count:6,total:421},
    {name:'TV, Tel & Mobile',icon:'ri-smartphone-line',color:'#06b6d4',bg:'rgba(6,182,212,.12)',count:6,total:189},
    {name:'Motor Vehicle',icon:'ri-car-line',color:'#a78bfa',bg:'rgba(167,139,250,.12)',count:6,total:543},
    {name:'Travel',icon:'ri-flight-takeoff-line',color:'#ec4899',bg:'rgba(236,72,153,.12)',count:5,total:134},
    {name:'Subscriptions',icon:'ri-refresh-line',color:'#10b981',bg:'rgba(16,185,129,.12)',count:5,total:678},
    {name:'Pet Care',icon:'ri-footprint-line',color:'#10b981',bg:'rgba(16,185,129,.12)',count:5,total:78},
    {name:'Health',icon:'ri-heart-pulse-line',color:'#10b981',bg:'rgba(16,185,129,.12)',count:5,total:231},
    {name:'Others',icon:'ri-more-2-line',color:'#94a3b8',bg:'rgba(148,163,184,.12)',count:1,total:56},
];

const AUDIT_DATA = [
    {icon:'ri-user-add-line',col:'#10b981',action:'User Created',detail:'Created user Emma Williams (emma@example.com)',actor:'Super Admin',time:'Today 14:32',type:'Create'},
    {icon:'ri-key-2-line',col:'#7c3aed',action:'Role Updated',detail:'Updated Support role permissions — added feedback.write',actor:'Alex Morgan',time:'Today 12:15',type:'Update'},
    {icon:'ri-delete-bin-line',col:'#f43f5e',action:'Reminder Deleted',detail:'Deleted reminder #4821 for user ID 148',actor:'Super Admin',time:'Today 09:44',type:'Delete'},
    {icon:'ri-login-box-line',col:'#06b6d4',action:'Admin Login',detail:'Logged in from 192.168.1.10 — London, UK',actor:'Super Admin',time:'Today 09:30',type:'Login'},
    {icon:'ri-settings-3-line',col:'#f59e0b',action:'Settings Updated',detail:'Changed SMTP host to smtp.mailgun.org',actor:'Alex Morgan',time:'Yesterday 16:50',type:'Update'},
    {icon:'ri-user-unfollow-line',col:'#f43f5e',action:'User Suspended',detail:'Suspended account user ID 23 — policy violation',actor:'Priya Patel',time:'Yesterday 14:10',type:'Update'},
    {icon:'ri-send-plane-line',col:'#10b981',action:'Broadcast Sent',detail:'Email broadcast sent to 1,284 users — Q2 update',actor:'Super Admin',time:'2 days ago',type:'Create'},
    {icon:'ri-team-line',col:'#a78bfa',action:'Staff Added',detail:'Added Nina Johansson as Analyst',actor:'Super Admin',time:'3 days ago',type:'Create'},
    {icon:'ri-bank-card-line',col:'#10b981',action:'Plan Updated',detail:'Basic Annual price adjusted to £2.40/year',actor:'Super Admin',time:'3 days ago',type:'Update'},
    {icon:'ri-shield-check-line',col:'#06b6d4',action:'2FA Enforced',detail:'Forced 2FA for all admin accounts',actor:'Super Admin',time:'4 days ago',type:'Update'},
    {icon:'ri-folder-add-line',col:'#f59e0b',action:'Category Created',detail:'Added new category: Fitness',actor:'Alex Morgan',time:'5 days ago',type:'Create'},
    {icon:'ri-user-settings-line',col:'#7c3aed',action:'Profile Updated',detail:'Super Admin updated email address',actor:'Super Admin',time:'6 days ago',type:'Update'},
];

const FEEDBACK_DATA = [
    {type:'bug',icon:'ri-bug-line',col:'#f43f5e',user:'Kishore Rex',msg:'Push notifications not working on iOS 17',status:'open',time:'Apr 25'},
    {type:'feature',icon:'ri-lightbulb-line',col:'#f59e0b',user:'Sarah Johnson',msg:'Add recurring reminder types like biweekly',status:'pending',time:'Apr 24'},
    {type:'compliment',icon:'ri-thumb-up-line',col:'#10b981',user:'Michael Chen',msg:'Love the WhatsApp integration! Works perfectly.',status:'resolved',time:'Apr 22'},
    {type:'bug',icon:'ri-bug-line',col:'#f43f5e',user:'Emma Williams',msg:'Calendar export not generating correct ICS file',status:'open',time:'Apr 21'},
    {type:'feature',icon:'ri-add-circle-line',col:'#7c3aed',user:'James Brown',msg:'Could you add a family sharing feature?',status:'pending',time:'Apr 20'},
    {type:'compliment',icon:'ri-heart-line',col:'#ec4899',user:'Olivia Davis',msg:"Best reminder app I've used. Clean design!",status:'resolved',time:'Apr 18'},
    {type:'bug',icon:'ri-bug-line',col:'#f43f5e',user:'William Taylor',msg:'Date picker not showing on Safari 17',status:'open',time:'Apr 17'},
    {type:'feature',icon:'ri-lightbulb-line',col:'#f59e0b',user:'Sophia Martinez',msg:'Dark mode option on mobile would be great',status:'resolved',time:'Apr 15'},
];

const ROLE_COLORS = ['#7c3aed','#0d9488','#f59e0b','#10b981','#f43f5e','#06b6d4','#ec4899','#a78bfa'];
let selectedRoleColor = ROLE_COLORS[0];
let selectedRole = null;
let charts = {};

// Mutable copies for staff
let staffData = [...STAFF_DATA];

/* ══════════════════════════════════════════
   PAGINATION STATE
══════════════════════════════════════════ */
let usersPageNum = 1, usersPerPage = 8, usersFiltered = [...USERS_DATA];
let staffPageNum = 1, staffPerPage = 6, staffFiltered = [...staffData];
let remPageNum = 1, remPerPage = 8, remFiltered = [...REMINDERS_DATA];
let txnPageNum = 1, txnPerPage = 8, txnFiltered = [...TXN_DATA];
let auditPageNum = 1, auditPerPage = 8, auditFiltered = [...AUDIT_DATA];

/* ══════════════════════════════════════════
   GENERIC PAGINATION BUILDER
══════════════════════════════════════════ */
function buildPagination(containerId, cur, totalPages, fnName) {
    var el = document.getElementById(containerId);
    if (!el) return;
    if (totalPages <= 1) { el.innerHTML = ''; return; }
    var h = '<button class="btn btn-ghost btn-xs" onclick="' + fnName + '(' + (cur-1) + ')"' + (cur<=1?' disabled':'') + '><i class="ri-arrow-left-s-line"></i></button>';
    var start = Math.max(1, cur-2), end = Math.min(totalPages, start+4);
    if (start > 1) { h += '<button class="btn btn-ghost btn-xs" onclick="' + fnName + '(1)">1</button>'; if (start > 2) h += '<span style="color:var(--text4);padding:0 2px">…</span>'; }
    for (var i = start; i <= end; i++) h += '<button class="btn btn-' + (i===cur?'primary':'ghost') + ' btn-xs" onclick="' + fnName + '(' + i + ')">' + i + '</button>';
    if (end < totalPages) { if (end < totalPages-1) h += '<span style="color:var(--text4);padding:0 2px">…</span>'; h += '<button class="btn btn-ghost btn-xs" onclick="' + fnName + '(' + totalPages + ')">' + totalPages + '</button>'; }
    h += '<button class="btn btn-ghost btn-xs" onclick="' + fnName + '(' + (cur+1) + ')"' + (cur>=totalPages?' disabled':'') + '><i class="ri-arrow-right-s-line"></i></button>';
    el.innerHTML = h;
}

/* ══════════════════════════════════════════
   ROUTING
══════════════════════════════════════════ */
const PAGE_TITLES = {dashboard:'Dashboard',analytics:'Analytics',users:'User Management',staff:'Staff Management',roles:'Roles & Permissions',reminders:'Reminders',transactions:'Transactions',categories:'Categories',notifications:'Notifications',profile:'My Profile',settings:'Settings',audit:'Audit Log',feedback:'Feedback'};
let curPage = 'dashboard';

function go(p, navEl) {
    document.querySelectorAll('.page').forEach(function(el){el.classList.remove('active')});
    document.querySelectorAll('.nav-item').forEach(function(el){el.classList.remove('active')});
    var pg = document.getElementById('page-'+p);
    if (!pg) return;
    pg.classList.add('active');
    document.getElementById('page-title').textContent = PAGE_TITLES[p]||p;
    if (navEl) navEl.classList.add('active');
    curPage = p;
    if (p==='dashboard') initDash();
    if (p==='analytics') initAnalytics();
    if (p==='users') renderUsers();
    if (p==='staff') renderStaff();
    if (p==='roles') renderRoles();
    if (p==='reminders') renderReminders();
    if (p==='transactions') renderTransactions();
    if (p==='categories') renderAdminCategories();
    if (p==='notifications') renderNotifications();
    if (p==='audit') renderAudit();
    if (p==='feedback') renderFeedback();
    if (p==='profile') renderProfileActivity();
    if (p==='settings') initSettings();
    closeMobile();
}

/* ══════════════════════════════════════════
   THEME & SIDEBAR
══════════════════════════════════════════ */
var sbCollapsed = false;
function toggleSidebar() {
    sbCollapsed = !sbCollapsed;
    document.getElementById('sidebar').classList.toggle('collapsed', sbCollapsed);
}
function openMobile() { document.getElementById('sidebar').classList.add('mobile-open'); document.getElementById('sb-overlay').classList.add('show'); }
function closeMobile() { document.getElementById('sidebar').classList.remove('mobile-open'); document.getElementById('sb-overlay').classList.remove('show'); }
function toggleTheme() {
    document.documentElement.classList.toggle('dark');
    document.documentElement.classList.toggle('light');
    var dark = document.documentElement.classList.contains('dark');
    document.getElementById('theme-icon').className = dark ? 'ri-moon-line' : 'ri-sun-line';
    setTimeout(function(){ initDash(); if (curPage==='analytics') initAnalytics(); }, 350);
}
function handleLogout() { if (confirm('Logout from admin panel?')) toast('Logged out','success'); }

/* ══════════════════════════════════════════
   MODALS
══════════════════════════════════════════ */
function openModal(id) { document.getElementById(id).classList.add('open'); document.body.style.overflow='hidden'; }
function closeModal(id) { document.getElementById(id).classList.remove('open'); document.body.style.overflow=''; }
document.querySelectorAll('.modal-bg').forEach(function(m){ m.addEventListener('click',function(e){ if(e.target===m){m.classList.remove('open');document.body.style.overflow='';} }); });

function openConfirm(msg, onOk) {
    document.getElementById('confirm-msg').textContent = msg;
    document.getElementById('confirm-ok-btn').onclick = function(){ onOk(); closeModal('confirm-modal'); };
    openModal('confirm-modal');
}

function openDrawer(html) {
    document.getElementById('drawer-content').innerHTML = html;
    document.getElementById('detail-drawer').style.transform = 'translateX(0)';
    document.getElementById('drawer-overlay').style.opacity = '1';
    document.getElementById('drawer-overlay').style.pointerEvents = 'all';
}
function closeDrawer() {
    document.getElementById('detail-drawer').style.transform = 'translateX(100%)';
    document.getElementById('drawer-overlay').style.opacity = '0';
    document.getElementById('drawer-overlay').style.pointerEvents = 'none';
}

/* ══════════════════════════════════════════
   TOAST
══════════════════════════════════════════ */
function toast(msg, type, dur) {
    if (!dur) dur = 3200;
    var styles = {
        success:{bg:'rgba(16,185,129,.15)',bd:'rgba(16,185,129,.3)',col:'#10b981',ico:'ri-check-circle-line'},
        error:{bg:'rgba(244,63,94,.15)',bd:'rgba(244,63,94,.3)',col:'#f43f5e',ico:'ri-error-warning-line'},
        warning:{bg:'rgba(245,158,11,.15)',bd:'rgba(245,158,11,.3)',col:'#f59e0b',ico:'ri-alert-line'},
        info:{bg:'rgba(20,184,166,.15)',bd:'rgba(20,184,166,.3)',col:'#14b8a6',ico:'ri-information-line'}
    };
    var c = styles[type] || styles.info;
    var el = document.createElement('div');
    el.className = 'toast';
    el.style.cssText = 'background:'+c.bg+';border-color:'+c.bd+';color:'+c.col;
    el.innerHTML = '<i class="'+c.ico+'" style="flex-shrink:0;font-size:.95rem"></i><span style="flex:1">'+msg+'</span><button onclick="this.closest(\'.toast\').remove()" style="background:none;border:none;color:inherit;cursor:pointer;opacity:.6;font-size:.95rem;padding:0"><i class="ri-close-line"></i></button>';
    document.getElementById('toast-area').appendChild(el);
    setTimeout(function(){el.style.cssText+=';opacity:0;transform:translateX(60px);transition:all .3s';setTimeout(function(){el.remove()},300)},dur);
}

/* ══════════════════════════════════════════
   TABS
══════════════════════════════════════════ */
function swTab(group, name, btn) {
    document.querySelectorAll('[id^="'+group+'-tab-"]').forEach(function(p){p.classList.remove('active')});
    var el = document.getElementById(group+'-tab-'+name);
    if (el) el.classList.add('active');
    if (btn) { btn.closest('.tab-bar').querySelectorAll('.tab-btn').forEach(function(b){b.classList.remove('active')}); btn.classList.add('active'); }
}

/* ══════════════════════════════════════════
   DASHBOARD
══════════════════════════════════════════ */
function initDash() {
    renderRecentUsers();
    renderSysHealth();
    initDashCharts();
}

function renderRecentUsers() {
    var el = document.getElementById('recent-users-list');
    el.innerHTML = USERS_DATA.slice(0,5).map(function(u){
        return '<div style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid var(--border2)"><div class="avatar avatar-sm" style="background:'+u.color+'22;color:'+u.color+'">'+u.initials+'</div><div style="flex:1;min-width:0"><div style="font-size:.83rem;font-weight:600;color:var(--text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">'+u.name+'</div><div style="font-size:.7rem;color:var(--text3)">'+u.email+'</div></div><span class="badge badge-'+(u.plan==='Pro'?'purple':u.plan==='Free'?'slate':'teal')+'" style="font-size:.6rem">'+u.plan+'</span></div>';
    }).join('');
}

function renderSysHealth() {
    var items = [
        {label:'API Response',val:98,color:'#10b981',unit:'% uptime'},
        {label:'Email Delivery',val:96,color:'#0d9488',unit:'% rate'},
        {label:'SMS Gateway',val:99,color:'#7c3aed',unit:'% uptime'},
        {label:'Database',val:100,color:'#10b981',unit:'% healthy'},
    ];
    document.getElementById('sys-health').innerHTML = items.map(function(i){
        return '<div><div style="display:flex;justify-content:space-between;font-size:.75rem;color:var(--text3);margin-bottom:4px"><span>'+i.label+'</span><span style="color:'+i.color+';font-weight:700">'+i.val+i.unit+'</span></div><div class="prog-track"><div class="prog-fill" style="width:'+i.val+'%;background:'+i.color+'"></div></div></div>';
    }).join('');
}

function initDashCharts() {
    var isDark = document.documentElement.classList.contains('dark');
    var tc = isDark ? 'rgba(255,255,255,.3)' : 'rgba(0,0,0,.4)';
    var gc = isDark ? 'rgba(255,255,255,.05)' : 'rgba(0,0,0,.05)';
    Object.values(charts).forEach(function(c){ try{c.destroy()}catch(e){} });
    charts = {};
    var opts = {responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false}},scales:{x:{grid:{color:gc},ticks:{color:tc,font:{size:10,family:'DM Sans'}}},y:{grid:{color:gc},ticks:{color:tc,font:{size:10,family:'DM Sans'}}}}};
    var ug = document.getElementById('user-growth-chart');
    if (ug) charts.ug = new Chart(ug,{type:'line',data:{labels:['Nov','Dec','Jan','Feb','Mar','Apr'],datasets:[{data:[820,940,1020,1100,1210,1284],borderColor:'#7c3aed',backgroundColor:'rgba(124,58,237,.12)',fill:true,tension:.45,pointRadius:4,pointBackgroundColor:'#7c3aed'}]},options:opts});
    var rv = document.getElementById('revenue-chart');
    if (rv) charts.rv = new Chart(rv,{type:'bar',data:{labels:['Nov','Dec','Jan','Feb','Mar','Apr'],datasets:[{data:[1960,2100,2400,2650,2800,2880],backgroundColor:'rgba(13,148,136,.7)',borderRadius:5,borderSkipped:false}]},options:opts});
}

/* ══════════════════════════════════════════
   ANALYTICS
══════════════════════════════════════════ */
function initAnalytics() {
    var isDark = document.documentElement.classList.contains('dark');
    var tc = isDark ? 'rgba(255,255,255,.3)' : 'rgba(0,0,0,.4)';
    var gc = isDark ? 'rgba(255,255,255,.05)' : 'rgba(0,0,0,.05)';
    ['an-reg-chart','an-cat-chart','an-rev-chart','an-plan-chart'].forEach(function(id){ var c=charts[id]; if(c) try{c.destroy()}catch(e){} });
    var opts = {responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false}},scales:{x:{grid:{color:gc},ticks:{color:tc,font:{size:10}}},y:{grid:{color:gc},ticks:{color:tc,font:{size:10}}}}};
    var reg = document.getElementById('an-reg-chart');
    if (reg) charts['an-reg-chart'] = new Chart(reg,{type:'bar',data:{labels:['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],datasets:[{data:[45,72,91,110,88,124,145,132,160,178,210,229],backgroundColor:'rgba(124,58,237,.7)',borderRadius:4,borderSkipped:false}]},options:opts});
    var cat = document.getElementById('an-cat-chart');
    if (cat) charts['an-cat-chart'] = new Chart(cat,{type:'doughnut',data:{labels:['Subscriptions','Motor','Insurance','Health','Special Days','Others'],datasets:[{data:[678,543,421,231,312,174],backgroundColor:['#10b981','#a78bfa','#f43f5e','#06b6d4','#f59e0b','#94a3b8'],borderWidth:0,hoverOffset:8}]},options:{responsive:true,maintainAspectRatio:false,cutout:'62%',plugins:{legend:{position:'right',labels:{color:tc,font:{size:11,family:'DM Sans'},boxWidth:12}}}}});
    var rev = document.getElementById('an-rev-chart');
    if (rev) charts['an-rev-chart'] = new Chart(rev,{type:'line',data:{labels:['Jan','Feb','Mar','Apr','May','Jun'],datasets:[{data:[2400,2650,2800,2880,3100,3240],borderColor:'#0d9488',backgroundColor:'rgba(13,148,136,.1)',fill:true,tension:.45,pointRadius:3,pointBackgroundColor:'#0d9488'}]},options:opts});
    var plan = document.getElementById('an-plan-chart');
    if (plan) charts['an-plan-chart'] = new Chart(plan,{type:'doughnut',data:{labels:['Basic Annual','Pro','Free'],datasets:[{data:[980,180,124],backgroundColor:['#7c3aed','#10b981','#64748b'],borderWidth:0,hoverOffset:6}]},options:{responsive:true,maintainAspectRatio:false,cutout:'65%',plugins:{legend:{position:'right',labels:{color:tc,font:{size:11,family:'DM Sans'},boxWidth:12}}}}});
}

/* ══════════════════════════════════════════
   USERS
══════════════════════════════════════════ */
function renderUsers() {
    var data = usersFiltered;
    var totalPages = Math.ceil(data.length / usersPerPage);
    var start = (usersPageNum - 1) * usersPerPage;
    var slice = data.slice(start, start + usersPerPage);
    document.getElementById('users-showing').textContent = slice.length;
    document.getElementById('users-total').textContent = data.length;
    document.getElementById('users-tbody').innerHTML = slice.map(function(u){
        var planBadge = u.plan==='Pro'?'purple':u.plan==='Free'?'slate':'teal';
        return '<tr>' +
            '<td><input type="checkbox" class="user-cb" style="accent-color:var(--purple);width:13px;height:13px;cursor:pointer"></td>' +
            '<td><div style="display:flex;align-items:center;gap:9px"><div class="avatar avatar-sm" style="background:'+u.color+'22;color:'+u.color+'">'+u.initials+'</div><div><div style="font-size:.83rem;font-weight:600;color:var(--text)">'+u.name+'</div><div style="font-size:.7rem;color:var(--text3)">'+u.email+'</div></div></div></td>' +
            '<td class="hide-mobile"><span class="badge badge-'+planBadge+'">'+u.plan+'</span></td>' +
            '<td class="hide-mobile" style="font-weight:600;color:var(--text)">'+u.rems+'</td>' +
            '<td><span class="badge badge-'+(u.status==='active'?'green':'red')+'">'+(u.status==='active'?'Active':'Suspended')+'</span></td>' +
            '<td class="hide-mobile" style="font-size:.78rem;color:var(--text3)">'+u.joined+'</td>' +
            '<td style="text-align:right"><div style="display:flex;gap:4px;justify-content:flex-end">' +
            '<button class="btn btn-ghost btn-xs" onclick="openUserDrawer('+u.id+')"><i class="ri-eye-line"></i></button>' +
            '<button class="btn btn-ghost btn-xs" onclick="openEditUser('+u.id+')"><i class="ri-pencil-line"></i></button>' +
            '<button class="btn btn-'+(u.status==='active'?'amber':'success')+' btn-xs" onclick="toggleUserStatus('+u.id+')"><i class="ri-'+(u.status==='active'?'pause':'play')+'-line"></i></button>' +
            '<button class="btn btn-danger btn-xs" onclick="openConfirm(\'Delete '+u.name+'? This cannot be undone.\',function(){toast(\'User deleted\',\'error\')})"><i class="ri-delete-bin-line"></i></button>' +
            '</div></td></tr>';
    }).join('');
    buildPagination('users-pagination', usersPageNum, totalPages, 'setUsersPage');
}

function setUsersPage(p) { usersPageNum = p; renderUsers(); }

function filterUsers(q) {
    if (q === undefined) q = (document.getElementById('users-search-inp')||{}).value || '';
    q = q.toLowerCase();
    var statusF = (document.getElementById('users-status-filter')||{}).value || 'all';
    var planF = (document.getElementById('users-plan-filter')||{}).value || 'all';
    usersFiltered = USERS_DATA.filter(function(u){
        var matchQ = (u.name+u.email+u.plan).toLowerCase().includes(q);
        var matchS = statusF==='all' || u.status===statusF;
        var matchP = planF==='all' || u.plan===planF;
        return matchQ && matchS && matchP;
    });
    usersPageNum = 1;
    renderUsers();
}

function toggleUserStatus(id) {
    var u = USERS_DATA.find(function(x){return x.id===id});
    if (!u) return;
    u.status = u.status==='active' ? 'suspended' : 'active';
    toast('User '+(u.status==='active'?'activated':'suspended'), 'success');
    renderUsers();
}

function openEditUser(id) {
    var u = USERS_DATA.find(function(x){return x.id===id});
    if (!u) return;
    document.getElementById('eu-id').value = u.id;
    document.getElementById('eu-name').value = u.name;
    document.getElementById('eu-email').value = u.email;
    document.getElementById('eu-phone').value = u.phone || '';
    document.getElementById('eu-plan').value = u.plan;
    document.getElementById('eu-status').value = u.status;
    openModal('edit-user-modal');
}

function saveEditUser() {
    var id = parseInt(document.getElementById('eu-id').value);
    var u = USERS_DATA.find(function(x){return x.id===id});
    if (!u) return;
    u.name = document.getElementById('eu-name').value;
    u.email = document.getElementById('eu-email').value;
    u.plan = document.getElementById('eu-plan').value;
    u.status = document.getElementById('eu-status').value;
    u.phone = document.getElementById('eu-phone').value;
    var ini = u.name.split(' ').map(function(w){return w[0]}).join('').toUpperCase().slice(0,2);
    u.initials = ini;
    toast('User updated!', 'success');
    closeModal('edit-user-modal');
    renderUsers();
}

function addUser() {
    var fn = document.getElementById('au-fname').value.trim();
    var ln = document.getElementById('au-lname').value.trim();
    var em = document.getElementById('au-email').value.trim();
    if (!fn || !em) { toast('Name and email are required','error'); return; }
    var newId = USERS_DATA.length + 1;
    USERS_DATA.push({id:newId,name:fn+' '+ln,email:em,plan:document.getElementById('au-plan').value,rems:0,status:document.getElementById('au-status').value,joined:new Date().toLocaleDateString('en-GB',{day:'2-digit',month:'short',year:'numeric'}),phone:document.getElementById('au-phone').value,initials:(fn[0]+(ln[0]||'')).toUpperCase(),color:COLORS_U[newId%8]});
    usersFiltered = [...USERS_DATA];
    toast('User created!','success');
    closeModal('add-user-modal');
    renderUsers();
}

function openUserDrawer(id) {
    var u = USERS_DATA.find(function(x){return x.id===id});
    if (!u) return;
    openDrawer(
        '<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px"><h2 class="font-jakarta" style="font-size:1rem;font-weight:800;color:var(--text)">User Details</h2><button onclick="closeDrawer()" style="background:rgba(255,255,255,.05);border:1px solid var(--border);color:var(--text2);width:30px;height:30px;border-radius:7px;display:flex;align-items:center;justify-content:center;cursor:pointer"><i class="ri-close-line"></i></button></div>' +
        '<div style="text-align:center;margin-bottom:20px"><div class="avatar avatar-lg" style="background:'+u.color+'22;color:'+u.color+';margin:0 auto 10px">'+u.initials+'</div><div class="font-jakarta" style="font-weight:700;font-size:1rem;color:var(--text)">'+u.name+'</div><div style="font-size:.75rem;color:var(--text3)">'+u.email+'</div><div style="margin-top:8px;display:flex;gap:6px;justify-content:center"><span class="badge badge-'+(u.plan==='Pro'?'purple':u.plan==='Free'?'slate':'teal')+'">'+u.plan+'</span><span class="badge badge-'+(u.status==='active'?'green':'red')+'">'+u.status+'</span></div></div>' +
        '<div style="display:flex;flex-direction:column;gap:10px;margin-bottom:20px">' +
        '<div style="display:flex;justify-content:space-between;padding:10px;border-radius:8px;background:rgba(255,255,255,.03);border:1px solid var(--border2)"><span style="font-size:.78rem;color:var(--text3)">Total Reminders</span><span style="font-size:1.20re;font-weight:700;color:var(--text)">'+u.rems+'</span></div>' +
        '<div style="display:flex;justify-content:space-between;padding:10px;border-radius:8px;background:rgba(255,255,255,.03);border:1px solid var(--border2)"><span style="font-size:.78rem;color:var(--text3)">Member Since</span><span style="font-size:1.20re;font-weight:700;color:var(--text)">'+u.joined+'</span></div>' +
        '<div style="display:flex;justify-content:space-between;padding:10px;border-radius:8px;background:rgba(255,255,255,.03);border:1px solid var(--border2)"><span style="font-size:.78rem;color:var(--text3)">Phone</span><span style="font-size:1.20re;font-weight:700;color:var(--text)">'+(u.phone||'N/A')+'</span></div>' +
        '</div><div style="display:flex;flex-direction:column;gap:8px">' +
        '<button class="btn btn-primary btn-sm" style="width:100%;justify-content:center" onclick="toast(\'Email sent to '+u.name+'\',\'success\')"><i class="ri-mail-send-line"></i> Send Email</button>' +
        '<button class="btn btn-ghost btn-sm" style="width:100%;justify-content:center" onclick="closeDrawer();openEditUser('+u.id+')"><i class="ri-pencil-line"></i> Edit Profile</button>' +
        '<button class="btn btn-danger btn-sm" style="width:100%;justify-content:center" onclick="toggleUserStatus('+u.id+');closeDrawer()"><i class="ri-pause-line"></i> '+(u.status==='active'?'Suspend':'Activate')+' Account</button>' +
        '</div>'
    );
}

/* ══════════════════════════════════════════
   STAFF
══════════════════════════════════════════ */
function renderStaff(data) {
    staffFiltered = data || staffFiltered;
    var totalPages = Math.ceil(staffFiltered.length / staffPerPage);
    var start = (staffPageNum - 1) * staffPerPage;
    var slice = staffFiltered.slice(start, start + staffPerPage);
    document.getElementById('staff-showing').textContent = slice.length;
    document.getElementById('staff-total').textContent = staffFiltered.length;
    // Update stat counts
    var act = staffData.filter(function(s){return s.status==='active'}).length;
    var inact = staffData.filter(function(s){return s.status==='inactive'}).length;
    if (document.getElementById('staff-count-total')) document.getElementById('staff-count-total').textContent = staffData.length;
    if (document.getElementById('staff-count-active')) document.getElementById('staff-count-active').textContent = act;
    if (document.getElementById('staff-count-inactive')) document.getElementById('staff-count-inactive').textContent = inact;
    document.getElementById('staff-tbody').innerHTML = slice.map(function(s){
        var role = ROLES_DATA.find(function(r){return r.id===s.role}) || {name:s.role,color:'#94a3b8',perms:[]};
        var perms = role.perms;
        var permBadges = perms.slice(0,2).map(function(p){return '<span class="chip" style="font-size:.6rem">'+p+'</span>';}).join('');
        var morePerms = perms.length > 2 ? '<span class="chip" style="font-size:.6rem">+' + (perms.length-2) + '</span>' : '';
        return '<tr>' +
            '<td><div style="display:flex;align-items:center;gap:9px"><div class="avatar avatar-sm" style="background:'+s.color+'22;color:'+s.color+'">'+s.initials+'</div><div><div style="font-size:.83rem;font-weight:600;color:var(--text)">'+s.name+'</div><div style="font-size:.7rem;color:var(--text3)">'+s.email+'</div></div></div></td>' +
            '<td class="hide-mobile"><span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:99px;font-size:.68rem;font-weight:700;background:'+role.color+'22;color:'+role.color+';border:1px solid '+role.color+'44">'+role.name+'</span></td>' +
            '<td class="hide-mobile"><div style="display:flex;gap:4px;flex-wrap:wrap">'+permBadges+morePerms+'</div></td>' +
            '<td><span class="badge badge-'+(s.status==='active'?'green':'slate')+'">'+s.status+'</span></td>' +
            '<td class="hide-mobile" style="font-size:.75rem;color:var(--text3)">'+s.last+'</td>' +
            '<td style="text-align:right"><div style="display:flex;gap:4px;justify-content:flex-end">' +
            '<button class="btn btn-ghost btn-xs" onclick="openStaffDrawer('+s.id+')"><i class="ri-eye-line"></i></button>' +
            '<button class="btn btn-ghost btn-xs" onclick="openEditStaff('+s.id+')"><i class="ri-pencil-line"></i></button>' +
            '<button class="btn btn-danger btn-xs" onclick="openConfirm(\'Remove '+s.name+' from staff?\',function(){removeStaff('+s.id+')})"><i class="ri-delete-bin-line"></i></button>' +
            '</div></td></tr>';
    }).join('');
    buildPagination('staff-pagination', staffPageNum, totalPages, 'setStaffPage');
}

function setStaffPage(p) { staffPageNum = p; renderStaff(); }

function filterStaff(q) {
    staffFiltered = staffData.filter(function(s){ return (s.name+s.email+s.role).toLowerCase().includes(q.toLowerCase()); });
    staffPageNum = 1;
    renderStaff();
}

function removeStaff(id) {
    staffData = staffData.filter(function(s){return s.id!==id});
    staffFiltered = staffFiltered.filter(function(s){return s.id!==id});
    renderStaff();
    toast('Staff member removed','success');
}

function addStaffMember() {
    var name = document.getElementById('as-name').value.trim();
    var email = document.getElementById('as-email').value.trim();
    var role = document.getElementById('staff-role-sel').value;
    if (!name || !email || !role) { toast('Please fill required fields','error'); return; }
    var ini = name.split(' ').map(function(w){return w[0]}).join('').toUpperCase().slice(0,2);
    staffData.push({id:Date.now(),name:name,email:email,role:role,status:'active',last:'just now',initials:ini,color:COLORS_U[staffData.length%8]});
    staffFiltered = [...staffData];
    toast('Staff member added!','success');
    closeModal('add-staff-modal');
    renderStaff();
}

function openEditStaff(id) {
    var s = staffData.find(function(x){return x.id===id});
    if (!s) return;
    document.getElementById('es-id').value = s.id;
    document.getElementById('es-name').value = s.name;
    document.getElementById('es-email').value = s.email;
    document.getElementById('es-status').value = s.status;
    // populate role dropdown
    var sel = document.getElementById('es-role');
    sel.innerHTML = ROLES_DATA.map(function(r){return '<option value="'+r.id+'"'+(r.id===s.role?' selected':'')+'>'+r.name+'</option>';}).join('');
    openModal('edit-staff-modal');
}

function saveEditStaff() {
    var id = parseInt(document.getElementById('es-id').value) || document.getElementById('es-id').value;
    var s = staffData.find(function(x){return x.id==id});
    if (!s) return;
    s.name = document.getElementById('es-name').value;
    s.email = document.getElementById('es-email').value;
    s.role = document.getElementById('es-role').value;
    s.status = document.getElementById('es-status').value;
    s.initials = s.name.split(' ').map(function(w){return w[0]}).join('').toUpperCase().slice(0,2);
    staffFiltered = [...staffData];
    toast('Staff updated!','success');
    closeModal('edit-staff-modal');
    renderStaff();
}

function openStaffDrawer(id) {
    var s = staffData.find(function(x){return x.id===id});
    if (!s) return;
    var role = ROLES_DATA.find(function(r){return r.id===s.role}) || {name:s.role,color:'#94a3b8',perms:[]};
    openDrawer(
        '<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px"><h2 class="font-jakarta" style="font-size:1rem;font-weight:800;color:var(--text)">Staff Details</h2><button onclick="closeDrawer()" style="background:rgba(255,255,255,.05);border:1px solid var(--border);color:var(--text2);width:30px;height:30px;border-radius:7px;display:flex;align-items:center;justify-content:center;cursor:pointer"><i class="ri-close-line"></i></button></div>' +
        '<div style="text-align:center;margin-bottom:20px"><div class="avatar avatar-lg" style="background:'+s.color+'22;color:'+s.color+';margin:0 auto 10px">'+s.initials+'</div><div class="font-jakarta" style="font-weight:700;font-size:1rem;color:var(--text)">'+s.name+'</div><div style="font-size:.75rem;color:var(--text3)">'+s.email+'</div><span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:99px;font-size:.68rem;font-weight:700;background:'+role.color+'22;color:'+role.color+';border:1px solid '+role.color+'44;margin-top:8px">'+role.name+'</span></div>' +
        '<div style="margin-bottom:14px"><div style="font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--text3);margin-bottom:8px">Permissions</div><div style="display:flex;flex-wrap:wrap;gap:5px">'+role.perms.map(function(p){return '<span class="chip">'+p+'</span>'}).join('')+'</div></div>' +
        '<div style="display:flex;flex-direction:column;gap:8px;margin-bottom:14px"><div style="display:flex;justify-content:space-between;padding:10px;border-radius:8px;background:rgba(255,255,255,.03);border:1px solid var(--border2)"><span style="font-size:.78rem;color:var(--text3)">Status</span><span class="badge badge-'+(s.status==='active'?'green':'slate')+'">'+s.status+'</span></div><div style="display:flex;justify-content:space-between;padding:10px;border-radius:8px;background:rgba(255,255,255,.03);border:1px solid var(--border2)"><span style="font-size:.78rem;color:var(--text3)">Last Active</span><span style="font-size:1.20re;font-weight:600;color:var(--text)">'+s.last+'</span></div></div>' +
        '<div style="display:flex;flex-direction:column;gap:8px"><button class="btn btn-primary btn-sm" style="width:100%;justify-content:center" onclick="closeDrawer();openEditStaff('+s.id+')"><i class="ri-pencil-line"></i> Edit Role</button><button class="btn btn-danger btn-sm" style="width:100%;justify-content:center" onclick="openConfirm(\'Remove '+s.name+'?\',function(){removeStaff('+s.id+');closeDrawer()})"><i class="ri-delete-bin-line"></i> Remove</button></div>'
    );
}

/* ══════════════════════════════════════════
   ROLES
══════════════════════════════════════════ */
function renderRoles() {
    var list = document.getElementById('roles-list');
    list.innerHTML = ROLES_DATA.map(function(r){
        var permBadges = (r.perms.includes('all')?ALL_PERMS.slice(0,4):r.perms.slice(0,4)).map(function(p){
            return '<span class="chip" style="font-size:.58rem">'+(typeof p==='string'?p:p.label)+'</span>';
        }).join('');
        var more = r.perms.length > 4 ? '<span class="chip" style="font-size:.58rem">+'+(r.perms.length-4)+' more</span>' : '';
        return '<div class="role-card '+(selectedRole===r.id?'selected':'')+'" onclick="selectRole(\''+r.id+'\',this)">' +
            '<div style="display:flex;align-items:center;gap:10px;margin-bottom:8px"><div style="width:36px;height:36px;border-radius:9px;background:'+r.color+'22;display:flex;align-items:center;justify-content:center"><i class="ri-key-2-line" style="color:'+r.color+'"></i></div><div style="flex:1"><div style="font-size:.87rem;font-weight:700;color:var(--text)">'+r.name+'</div><div style="font-size:.72rem;color:var(--text3)">'+r.desc+'</div></div><span style="font-size:.65rem;font-weight:700;background:'+r.color+'22;color:'+r.color+';padding:2px 8px;border-radius:99px;border:1px solid '+r.color+'44">'+r.count+' member'+(r.count!==1?'s':'')+'</span></div>' +
            '<div style="display:flex;flex-wrap:wrap;gap:4px">'+permBadges+more+'</div></div>';
    }).join('');
    renderPermTable();
    buildRoleModal();
    populateStaffRoles();
}

function selectRole(id, el) {
    selectedRole = id;
    document.querySelectorAll('.role-card').forEach(function(c){c.classList.remove('selected')});
    el.classList.add('selected');
    var role = ROLES_DATA.find(function(r){return r.id===id});
    document.getElementById('selected-role-badge').textContent = role.name;
    var groups = {};
    ALL_PERMS.forEach(function(p){ if (!groups[p.group]) groups[p.group]=[]; groups[p.group].push(p); });
    var hasAll = role.perms.includes('all');
    var html = '<div style="margin-bottom:12px"><span class="badge badge-purple" style="font-size:.7rem">'+role.name+'</span><span style="font-size:.75rem;color:var(--text3);margin-left:8px">'+(hasAll?ALL_PERMS.length:role.perms.length)+' permissions</span></div>';
    Object.entries(groups).forEach(function(entry){
        var g = entry[0], perms = entry[1];
        html += '<div style="margin-bottom:12px"><div style="font-size:.63rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--text4);margin-bottom:6px">'+g+'</div><div style="display:flex;flex-direction:column;gap:4px">';
        perms.forEach(function(p){
            var has = hasAll || role.perms.includes(p.key);
            html += '<div style="display:flex;align-items:center;gap:8px;padding:5px 8px;border-radius:6px;background:rgba('+(has?'16,185,129':'255,255,255')+',.05)"><i class="ri-'+(has?'check':'close')+'-line" style="color:'+(has?'var(--green)':'var(--text4)')+';font-size:.85rem"></i><span style="font-size:.78rem;color:'+(has?'var(--text2)':'var(--text4)')+'">'+p.label+'</span></div>';
        });
        html += '</div></div>';
    });
    html += '<button class="btn btn-primary btn-sm" style="width:100%;justify-content:center;margin-top:8px" onclick="toast(\'Role permissions saved!\',\'success\')"><i class="ri-save-line"></i> Save Permissions</button>';
    document.getElementById('perm-matrix').innerHTML = html;
}

function renderPermTable() {
    var head = document.getElementById('perm-table-head');
    var body = document.getElementById('perm-table-body');
    head.innerHTML = '<th style="padding:10px 14px;font-size:.63rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--text3)">Permission</th>' +
        ROLES_DATA.map(function(r){return '<th style="padding:10px 14px;font-size:.63rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:'+r.color+'">'+r.name+'</th>';}).join('');
    body.innerHTML = ALL_PERMS.slice(0,10).map(function(p){
        return '<tr><td><span style="font-size:.78rem;color:var(--text2)">'+p.label+'</span><div style="font-size:.65rem;color:var(--text4)">'+p.group+'</div></td>' +
            ROLES_DATA.map(function(r){ var has=r.perms.includes('all')||r.perms.includes(p.key); return '<td style="text-align:center"><i class="ri-'+(has?'check':'minus')+'-line" style="color:'+(has?'var(--green)':'var(--text4)')+'"></i></td>'; }).join('') +
            '</tr>';
    }).join('');
}

function buildRoleModal() {
    var permsEl = document.getElementById('new-role-perms');
    permsEl.innerHTML = ALL_PERMS.map(function(p){
        return '<label class="perm-item"><input type="checkbox" value="'+p.key+'" style="accent-color:var(--purple);width:13px;height:13px;cursor:pointer"><span>'+p.label+'<div style="font-size:.63rem;color:var(--text4)">'+p.group+'</div></span></label>';
    }).join('');
    var cp = document.getElementById('role-color-picker');
    cp.innerHTML = ROLE_COLORS.map(function(c){
        return '<div onclick="selectedRoleColor=\''+c+'\';document.querySelectorAll(\'#role-color-picker div\').forEach(function(d){d.style.outline=\'none\'});this.style.outline=\'2px solid #fff\'" style="width:20px;height:20px;border-radius:50%;background:'+c+';cursor:pointer;transition:transform .15s;outline:'+(c===selectedRoleColor?'2px solid #fff':'none')+'" onmouseover="this.style.transform=\'scale(1.2)\'" onmouseout="this.style.transform=\'scale(1)\'"></div>';
    }).join('');
}

function createRole() {
    var name = document.getElementById('new-role-name').value.trim();
    if (!name) { toast('Enter a role name','error'); return; }
    var desc = document.getElementById('new-role-desc').value.trim();
    var perms = Array.from(document.querySelectorAll('#new-role-perms input:checked')).map(function(i){return i.value});
    ROLES_DATA.push({id:name.toLowerCase().replace(/\s+/g,'-'),name:name,color:selectedRoleColor,desc:desc,perms:perms,count:0});
    toast('Role "'+name+'" created!','success');
    closeModal('add-role-modal');
    renderRoles();
}

function populateStaffRoles() {
    var sel = document.getElementById('staff-role-sel');
    if (sel) sel.innerHTML = '<option value="">Select role…</option>' + ROLES_DATA.map(function(r){return '<option value="'+r.id+'">'+r.name+'</option>';}).join('');
}

/* ══════════════════════════════════════════
   REMINDERS
══════════════════════════════════════════ */
function renderReminders() {
    var data = remFiltered;
    var totalPages = Math.ceil(data.length / remPerPage);
    var start = (remPageNum - 1) * remPerPage;
    var slice = data.slice(start, start + remPerPage);
    document.getElementById('rem-showing').textContent = slice.length;
    document.getElementById('rem-total').textContent = data.length;
    var catColors = {active:'teal',completed:'green',overdue:'red'};
    document.getElementById('rem-tbody').innerHTML = slice.map(function(r){
        var due = r.due.toLocaleDateString('en-GB',{day:'2-digit',month:'short',year:'numeric'});
        var u = r.user;
        return '<tr>' +
            '<td><div style="font-size:.83rem;font-weight:600;color:var(--text)">'+r.title+'</div><div style="font-size:.7rem;color:var(--text3)">#'+r.id+'</div></td>' +
            '<td class="hide-mobile"><div style="display:flex;align-items:center;gap:7px"><div class="avatar avatar-sm" style="background:'+u.color+'22;color:'+u.color+'">'+u.initials+'</div><span style="font-size:.78rem;color:var(--text2)">'+u.name+'</span></div></td>' +
            '<td class="hide-mobile"><span class="badge badge-purple" style="font-size:.65rem">'+r.category+'</span></td>' +
            '<td style="font-size:.78rem;color:var(--text3)">'+due+'</td>' +
            '<td><span class="badge badge-'+(catColors[r.status]||'slate')+'">'+r.status+'</span></td>' +
            '<td style="text-align:right"><div style="display:flex;gap:4px;justify-content:flex-end">' +
            '<button class="btn btn-ghost btn-xs" onclick="openViewReminder('+r.id+')"><i class="ri-eye-line"></i></button>' +
            '<button class="btn btn-danger btn-xs" onclick="openConfirm(\'Delete this reminder?\',function(){toast(\'Reminder deleted\',\'error\')})"><i class="ri-delete-bin-line"></i></button>' +
            '</div></td></tr>';
    }).join('');
    buildPagination('rem-pagination', remPageNum, totalPages, 'setRemPage');
}

function setRemPage(p) { remPageNum = p; renderReminders(); }

function filterReminders(q) {
    if (q === undefined) q = '';
    q = q.toLowerCase();
    var statusF = (document.getElementById('rem-status-filter')||{}).value || 'all';
    remFiltered = REMINDERS_DATA.filter(function(r){
        var matchQ = (r.title+r.user.name+r.category).toLowerCase().includes(q);
        var matchS = statusF==='all' || r.status===statusF;
        return matchQ && matchS;
    });
    remPageNum = 1;
    renderReminders();
}

function openViewReminder(id) {
    var r = REMINDERS_DATA.find(function(x){return x.id===id});
    if (!r) return;
    var due = r.due.toLocaleDateString('en-GB',{day:'2-digit',month:'short',year:'numeric'});
    var created = r.created.toLocaleDateString('en-GB',{day:'2-digit',month:'short',year:'numeric'});
    document.getElementById('rem-modal-content').innerHTML =
        '<div style="display:flex;gap:10px;margin-bottom:16px"><div class="stat-ico" style="background:rgba(124,58,237,.15);margin:0"><i class="ri-alarm-line" style="color:var(--purple-light)"></i></div><div><div style="font-weight:700;font-size:.95rem;color:var(--text)">'+r.title+'</div><div style="font-size:.75rem;color:var(--text3)">#'+r.id+' · '+r.category+'</div></div></div>' +
        '<div style="display:flex;flex-direction:column;gap:8px;margin-bottom:16px">' +
        '<div style="display:flex;justify-content:space-between;padding:10px;border-radius:8px;background:rgba(255,255,255,.03);border:1px solid var(--border2)"><span style="font-size:.78rem;color:var(--text3)">User</span><span style="font-size:1.20re;font-weight:600;color:var(--text)">'+r.user.name+'</span></div>' +
        '<div style="display:flex;justify-content:space-between;padding:10px;border-radius:8px;background:rgba(255,255,255,.03);border:1px solid var(--border2)"><span style="font-size:.78rem;color:var(--text3)">Date</span><span style="font-size:1.20re;font-weight:600;color:var(--text)">'+due+'</span></div>' +
        '<div style="display:flex;justify-content:space-between;padding:10px;border-radius:8px;background:rgba(255,255,255,.03);border:1px solid var(--border2)"><span style="font-size:.78rem;color:var(--text3)">Status</span><span class="badge badge-'+(r.status==='active'?'teal':r.status==='completed'?'green':'red')+'">'+r.status+'</span></div>' +
        '<div style="display:flex;justify-content:space-between;padding:10px;border-radius:8px;background:rgba(255,255,255,.03);border:1px solid var(--border2)"><span style="font-size:.78rem;color:var(--text3)">Priority</span><span class="badge badge-'+(r.priority==='high'?'red':r.priority==='medium'?'amber':'slate')+'">'+r.priority+'</span></div>' +
        '<div style="display:flex;justify-content:space-between;padding:10px;border-radius:8px;background:rgba(255,255,255,.03);border:1px solid var(--border2)"><span style="font-size:.78rem;color:var(--text3)">Created</span><span style="font-size:1.20re;font-weight:600;color:var(--text)">'+created+'</span></div>' +
        '</div>' +
        '<div><label class="label">Notes</label><textarea class="inp" rows="2" style="resize:none">'+r.notes+'</textarea></div>' +
        '<div style="margin-top:12px"><label class="label">Status</label><select class="inp"><option '+(r.status==='active'?'selected':'')+'>active</option><option '+(r.status==='completed'?'selected':'')+'>completed</option><option '+(r.status==='overdue'?'selected':'')+'>overdue</option></select></div>';
    openModal('view-reminder-modal');
}

/* ══════════════════════════════════════════
   TRANSACTIONS
══════════════════════════════════════════ */
function renderTransactions() {
    var data = txnFiltered;
    var totalPages = Math.ceil(data.length / txnPerPage);
    var start = (txnPageNum - 1) * txnPerPage;
    var slice = data.slice(start, start + txnPerPage);
    document.getElementById('txn-showing').textContent = slice.length;
    document.getElementById('txn-total').textContent = data.length;
    document.getElementById('txn-tbody').innerHTML = slice.map(function(t){
        var d = t.date.toLocaleDateString('en-GB',{day:'2-digit',month:'short',year:'numeric'});
        return '<tr>' +
            '<td><span class="mono" style="font-size:.73rem;color:var(--purple-light)">'+t.txnId+'</span></td>' +
            '<td class="hide-mobile"><div style="display:flex;align-items:center;gap:7px"><div class="avatar avatar-sm" style="background:'+t.user.color+'22;color:'+t.user.color+'">'+t.user.initials+'</div><span style="font-size:.78rem">'+t.user.name+'</span></div></td>' +
            '<td class="hide-mobile"><span class="badge badge-teal">'+t.plan+'</span></td>' +
            '<td><span style="font-weight:700;color:var(--text)">'+t.amount+'</span></td>' +
            '<td><span class="badge badge-'+(t.status==='completed'?'green':t.status==='pending'?'amber':'red')+'">'+t.status+'</span></td>' +
            '<td class="hide-mobile" style="font-size:.75rem;color:var(--text3)">'+d+'</td>' +
            '<td style="text-align:right"><div style="display:flex;gap:4px;justify-content:flex-end">' +
            '<button class="btn btn-ghost btn-xs" onclick="openViewTxn('+t.id+')"><i class="ri-eye-line"></i></button>' +
            '<button class="btn btn-ghost btn-xs" onclick="toast(\'Invoice downloaded\',\'success\')"><i class="ri-download-line"></i></button>' +
            '</div></td></tr>';
    }).join('');
    buildPagination('txn-pagination', txnPageNum, totalPages, 'setTxnPage');
}

function setTxnPage(p) { txnPageNum = p; renderTransactions(); }

function filterTxn(q) {
    if (q === undefined) q = '';
    q = q.toLowerCase();
    var statusF = (document.getElementById('txn-status-filter')||{}).value || 'all';
    txnFiltered = TXN_DATA.filter(function(t){
        var matchQ = (t.txnId+t.user.name+t.plan).toLowerCase().includes(q);
        var matchS = statusF==='all' || t.status===statusF;
        return matchQ && matchS;
    });
    txnPageNum = 1;
    renderTransactions();
}

function openViewTxn(id) {
    var t = TXN_DATA.find(function(x){return x.id===id});
    if (!t) return;
    var d = t.date.toLocaleDateString('en-GB',{day:'2-digit',month:'short',year:'numeric'});
    document.getElementById('txn-modal-content').innerHTML =
        '<div style="display:flex;gap:10px;margin-bottom:16px"><div class="stat-ico" style="background:rgba(16,185,129,.12);margin:0"><i class="ri-bank-card-line" style="color:var(--green)"></i></div><div><div style="font-weight:700;font-size:.95rem;color:var(--text)">'+t.txnId+'</div><div style="font-size:.75rem;color:var(--text3)">'+t.plan+' Plan</div></div></div>' +
        '<div style="display:flex;flex-direction:column;gap:8px">' +
        '<div style="display:flex;justify-content:space-between;padding:10px;border-radius:8px;background:rgba(255,255,255,.03);border:1px solid var(--border2)"><span style="font-size:.78rem;color:var(--text3)">Customer</span><span style="font-size:1.20re;font-weight:600;color:var(--text)">'+t.user.name+'</span></div>' +
        '<div style="display:flex;justify-content:space-between;padding:10px;border-radius:8px;background:rgba(255,255,255,.03);border:1px solid var(--border2)"><span style="font-size:.78rem;color:var(--text3)">Amount</span><span style="font-size:.95rem;font-weight:800;color:var(--green)">'+t.amount+'</span></div>' +
        '<div style="display:flex;justify-content:space-between;padding:10px;border-radius:8px;background:rgba(255,255,255,.03);border:1px solid var(--border2)"><span style="font-size:.78rem;color:var(--text3)">Status</span><span class="badge badge-'+(t.status==='completed'?'green':t.status==='pending'?'amber':'red')+'">'+t.status+'</span></div>' +
        '<div style="display:flex;justify-content:space-between;padding:10px;border-radius:8px;background:rgba(255,255,255,.03);border:1px solid var(--border2)"><span style="font-size:.78rem;color:var(--text3)">Payment Method</span><span style="font-size:1.20re;font-weight:600;color:var(--text)">'+t.method+'</span></div>' +
        '<div style="display:flex;justify-content:space-between;padding:10px;border-radius:8px;background:rgba(255,255,255,.03);border:1px solid var(--border2)"><span style="font-size:.78rem;color:var(--text3)">Date</span><span style="font-size:1.20re;font-weight:600;color:var(--text)">'+d+'</span></div>' +
        '</div>';
    openModal('view-txn-modal');
}

/* ══════════════════════════════════════════
   CATEGORIES
══════════════════════════════════════════ */
function renderAdminCategories() {
    document.getElementById('admin-cat-grid').innerHTML = CATS_DATA.map(function(c){
        return '<div class="card" style="padding:16px;cursor:pointer" onclick="toast(\''+c.name+' details\',\'info\')">' +
            '<div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:12px"><div style="width:40px;height:40px;border-radius:11px;background:'+c.bg+';display:flex;align-items:center;justify-content:center"><i class="'+c.icon+'" style="color:'+c.color+';font-size:1.1rem"></i></div>' +
            '<button class="btn btn-ghost btn-xs" onclick="event.stopPropagation();toast(\'Edit '+c.name+'\',\'info\')"><i class="ri-pencil-line"></i></button></div>' +
            '<div style="font-weight:700;font-size:.87rem;color:var(--text);margin-bottom:3px">'+c.name+'</div>' +
            '<div style="font-size:.73rem;color:var(--text3);margin-bottom:8px">'+c.count+' subcategories</div>' +
            '<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:5px"><span style="font-size:.72rem;color:var(--text3)">Usage</span><span style="font-size:.72rem;font-weight:700;color:var(--text)">'+c.total.toLocaleString()+' reminders</span></div>' +
            '<div class="prog-track"><div class="prog-fill" style="width:'+Math.min((c.total/678)*100,100).toFixed(0)+'%;background:'+c.color+'"></div></div></div>';
    }).join('');
}

/* ══════════════════════════════════════════
   NOTIFICATIONS
══════════════════════════════════════════ */
function renderNotifications() {
    var notifs = [
        {icon:'ri-alarm-line',bg:'rgba(245,158,11,.12)',col:'#f59e0b',title:'Car Insurance Due Soon',desc:'User Kishore Rex has a reminder due in 3 days',time:'2 hours ago',unread:true},
        {icon:'ri-bug-line',bg:'rgba(244,63,94,.12)',col:'#f43f5e',title:'Bug Report: Push Notification Failure',desc:'SMS delivery failing for UK numbers with +44',time:'5 hours ago',unread:true},
        {icon:'ri-user-add-line',bg:'rgba(16,185,129,.12)',col:'#10b981',title:'New User Registration',desc:'Sarah Johnson registered with Basic Annual plan',time:'1 day ago',unread:true},
        {icon:'ri-money-pound-circle-line',bg:'rgba(16,185,129,.12)',col:'#10b981',title:'Payment Received',desc:'£2.40 from Michael Chen — Basic Annual',time:'1 day ago',unread:false},
        {icon:'ri-shield-check-line',bg:'rgba(6,182,212,.12)',col:'#06b6d4',title:'Security Alert',desc:'New admin login from 192.168.1.10',time:'2 days ago',unread:true},
    ];
    document.getElementById('admin-notif-list').innerHTML = notifs.map(function(n){
        return '<div class="act-item" style="'+(n.unread?'background:rgba(124,58,237,.06);border-color:rgba(124,58,237,.2)':'')+'">' +
            '<div style="width:36px;height:36px;border-radius:10px;background:'+n.bg+';display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="'+n.icon+'" style="color:'+n.col+'"></i></div>' +
            '<div style="flex:1;min-width:0"><div style="font-size:.84rem;font-weight:600;color:var(--text)">'+n.title+'</div><div style="font-size:.75rem;color:var(--text3);margin-top:2px">'+n.desc+'</div><div style="font-size:.7rem;color:var(--text4);margin-top:4px"><i class="ri-time-line"></i> '+n.time+'</div></div>' +
            '<div style="display:flex;gap:4px;flex-shrink:0">'+(n.unread?'<button class="btn btn-ghost btn-xs" onclick="this.closest(\'.act-item\').style.background=\'\';this.closest(\'.act-item\').style.borderColor=\'\';this.remove();toast(\'Marked as read\',\'success\')"><i class="ri-check-line"></i></button>':'')+'<button class="btn btn-danger btn-xs" onclick="this.closest(\'.act-item\').remove();toast(\'Deleted\',\'info\')"><i class="ri-delete-bin-line"></i></button></div></div>';
    }).join('');
}

/* ══════════════════════════════════════════
   AUDIT LOG
══════════════════════════════════════════ */
function renderAudit() {
    var data = auditFiltered;
    var totalPages = Math.ceil(data.length / auditPerPage);
    var start = (auditPageNum - 1) * auditPerPage;
    var slice = data.slice(start, start + auditPerPage);
    document.getElementById('audit-showing').textContent = slice.length;
    document.getElementById('audit-total').textContent = data.length;
    document.getElementById('audit-list').innerHTML = slice.map(function(a){
        return '<div class="act-item">' +
            '<div style="width:36px;height:36px;border-radius:10px;background:'+a.col+'22;display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="'+a.icon+'" style="color:'+a.col+'"></i></div>' +
            '<div style="flex:1;min-width:0"><div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap"><span style="font-size:.84rem;font-weight:700;color:var(--text)">'+a.action+'</span><span style="font-size:.65rem;color:var(--text3);font-weight:600">by '+a.actor+'</span></div><div style="font-size:.75rem;color:var(--text3);margin-top:2px">'+a.detail+'</div><div style="font-size:.7rem;color:var(--text4);margin-top:4px"><i class="ri-time-line"></i> '+a.time+'</div></div>' +
            '<span class="mono" style="font-size:.65rem;color:var(--text4);flex-shrink:0">#'+String(Math.floor(Math.random()*9000+1000))+'</span></div>';
    }).join('');
    buildPagination('audit-pagination', auditPageNum, totalPages, 'setAuditPage');
}

function setAuditPage(p) { auditPageNum = p; renderAudit(); }

function filterAudit(q) {
    if (q === undefined) q = '';
    q = q.toLowerCase();
    var actionF = (document.getElementById('audit-action-filter')||{}).value || 'all';
    auditFiltered = AUDIT_DATA.filter(function(a){
        var matchQ = (a.action+a.detail+a.actor).toLowerCase().includes(q);
        var matchA = actionF==='all' || a.type===actionF;
        return matchQ && matchA;
    });
    auditPageNum = 1;
    renderAudit();
}

/* ══════════════════════════════════════════
   FEEDBACK
══════════════════════════════════════════ */
function renderFeedback() {
    var fbFiltered = FEEDBACK_DATA;
    var typeF = (document.getElementById('fb-type-filter')||{}).value || 'all';
    var statusF = (document.getElementById('fb-status-filter')||{}).value || 'all';
    if (typeF !== 'all') fbFiltered = fbFiltered.filter(function(f){return f.type===typeF});
    if (statusF !== 'all') fbFiltered = fbFiltered.filter(function(f){return f.status===statusF});
    document.getElementById('feedback-list').innerHTML = fbFiltered.map(function(f){
        return '<div class="act-item" style="'+(f.status==='open'?'border-color:rgba(244,63,94,.25);background:rgba(244,63,94,.04)':'')+'">' +
            '<div style="width:36px;height:36px;border-radius:10px;background:'+f.col+'22;display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="'+f.icon+'" style="color:'+f.col+'"></i></div>' +
            '<div style="flex:1;min-width:0"><div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-bottom:2px"><span style="font-size:.84rem;font-weight:600;color:var(--text)">'+f.user+'</span><span class="badge badge-'+(f.type==='bug'?'red':f.type==='feature'?'amber':'green')+'" style="font-size:.6rem">'+f.type+'</span><span class="badge badge-'+(f.status==='open'?'red':f.status==='pending'?'amber':'green')+'" style="font-size:.6rem">'+f.status+'</span></div><div style="font-size:.79rem;color:var(--text3)">'+f.msg+'</div><div style="font-size:.7rem;color:var(--text4);margin-top:4px">'+f.time+'</div></div>' +
            '<div style="display:flex;gap:4px;flex-shrink:0"><button class="btn btn-success btn-xs" onclick="toast(\'Marked resolved\',\'success\')"><i class="ri-check-line"></i></button><button class="btn btn-ghost btn-xs" onclick="toast(\'Reply sent\',\'info\')"><i class="ri-reply-line"></i></button></div></div>';
    }).join('');
}

function filterFeedback() { renderFeedback(); }

/* ══════════════════════════════════════════
   PROFILE
══════════════════════════════════════════ */
function renderProfileActivity() {
    var acts = [
        {icon:'ri-login-box-line',col:'#10b981',txt:'Logged in from London, UK',time:'Today 09:30'},
        {icon:'ri-user-settings-line',col:'#7c3aed',txt:'Profile details updated',time:'Yesterday 16:45'},
        {icon:'ri-key-2-line',col:'#f59e0b',txt:'Created new role — Content Manager',time:'Apr 24'},
        {icon:'ri-send-plane-line',col:'#06b6d4',txt:'Broadcast email sent to all users',time:'Apr 22'},
    ];
    var el = document.getElementById('profile-activity');
    if (el) el.innerHTML = acts.map(function(a){
        return '<div class="act-item"><div style="width:30px;height:30px;border-radius:8px;background:'+a.col+'22;display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="'+a.icon+'" style="color:'+a.col+';font-size:.85rem"></i></div><div style="flex:1"><div style="font-size:.8rem;color:var(--text2)">'+a.txt+'</div><div style="font-size:.7rem;color:var(--text4);margin-top:2px">'+a.time+'</div></div></div>';
    }).join('');
}

/* ══════════════════════════════════════════
   SETTINGS
══════════════════════════════════════════ */
function initSettings() {
    var flags = [
        {label:'User Registration',desc:'Allow new users to sign up',on:true},
        {label:'Email Notifications',desc:'System sends email alerts',on:true},
        {label:'SMS Notifications',desc:'Twilio SMS gateway active',on:true},
        {label:'WhatsApp Integration',desc:'WhatsApp Business API',on:true},
        {label:'Analytics Tracking',desc:'Collect usage analytics',on:false},
        {label:'Referral Program',desc:'User referral rewards',on:false},
    ];
    var el = document.getElementById('feature-flags');
    if (el) el.innerHTML = flags.map(function(f){
        return '<div style="display:flex;align-items:center;justify-content:space-between;padding:10px;border-radius:var(--radius-sm);background:rgba(255,255,255,.03);border:1px solid var(--border2)"><div><div style="font-size:.84rem;font-weight:600;color:var(--text2)">'+f.label+'</div><div style="font-size:.72rem;color:var(--text3)">'+f.desc+'</div></div><button class="toggle '+(f.on?'on':'')+'" onclick="this.classList.toggle(\'on\');toast(\''+f.label+' toggled\',\'info\')"></button></div>';
    }).join('');

    var plans = [
        {name:'Basic Annual',price:'£2.40',period:'year',features:'Unlimited reminders, Email, SMS, WhatsApp',color:'#7c3aed'},
        {name:'Pro (Coming Soon)',price:'£9.99',period:'year',features:'All Basic features + Priority support + API access',color:'#0d9488'},
        {name:'Family (Coming Soon)',price:'£14.99',period:'year',features:'Up to 5 members + All Pro features',color:'#f59e0b'},
    ];
    var pc = document.getElementById('plan-config');
    if (pc) pc.innerHTML = plans.map(function(p){
        return '<div style="padding:14px;border-radius:var(--radius-sm);border:1px solid '+p.color+'33;background:'+p.color+'0d"><div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px"><div style="font-weight:700;font-size:.87rem;color:var(--text)">'+p.name+'</div><div style="font-weight:800;font-size:1rem;color:'+p.color+'">'+p.price+'<span style="font-size:.72rem;font-weight:400;color:var(--text3)">/'+p.period+'</span></div></div><div style="font-size:.77rem;color:var(--text3);margin-bottom:10px">'+p.features+'</div><div style="display:flex;gap:6px"><button class="btn btn-ghost btn-xs" onclick="toast(\'Editing plan…\',\'info\')"><i class="ri-pencil-line"></i> Edit</button><button class="toggle" onclick="this.classList.toggle(\'on\')"></button></div></div>';
    }).join('');

    var integrations = [
        {icon:'ri-mail-send-line',name:'Mailgun',desc:'Email delivery service',col:'#f43f5e',connected:true},
        {icon:'ri-message-2-line',name:'Twilio',desc:'SMS & WhatsApp gateway',col:'#f43f5e',connected:true},
        {icon:'ri-google-line',name:'Google Analytics',desc:'Usage analytics tracking',col:'#f59e0b',connected:false},
        {icon:'ri-slack-line',name:'Slack',desc:'Admin alert notifications',col:'#10b981',connected:false},
        {icon:'ri-stripe-line',name:'Stripe',desc:'Payment processing',col:'#7c3aed',connected:true},
    ];
    var il = document.getElementById('integrations-list');
    if (il) il.innerHTML = integrations.map(function(i){
        return '<div class="card" style="padding:16px;display:flex;align-items:center;gap:12px"><div style="width:44px;height:44px;border-radius:12px;background:'+i.col+'22;display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="'+i.icon+'" style="color:'+i.col+';font-size:1.2rem"></i></div><div style="flex:1"><div style="font-weight:700;font-size:.87rem;color:var(--text)">'+i.name+'</div><div style="font-size:.75rem;color:var(--text3)">'+i.desc+'</div></div><span class="badge badge-'+(i.connected?'green':'slate')+'">'+(i.connected?'Connected':'Disconnected')+'</span><button class="btn btn-'+(i.connected?'danger':'primary')+' btn-sm" onclick="toast(\''+(i.connected?'Disconnected':'Connected')+' '+i.name+'\',\''+(i.connected?'warning':'success')+'\')"><i class="ri-'+(i.connected?'link-unlink':'link')+'-line"></i> '+(i.connected?'Disconnect':'Connect')+'</button></div>';
    }).join('');
}

/* ══════════════════════════════════════════
   UTILS
══════════════════════════════════════════ */
function toggleAllCB(master, cls) {
    document.querySelectorAll('.'+cls).forEach(function(cb){cb.checked=master.checked});
}

/* ══════════════════════════════════════════
   INIT
══════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', function(){ initDash(); });
</script>
</body>
</html>