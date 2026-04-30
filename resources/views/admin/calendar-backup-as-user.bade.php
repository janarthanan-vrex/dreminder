@extends('admin.layouts.app')
@section('content')

<style>
/* ─── YOUR EXISTING THEME (keep as-is in your project, only here for preview) ─── */
:root {
    --sb: 256px; --sb-sm: 64px;
    --bg: #07071a; --bg2: #0c0c22; --bg3: #10102e;
    --border: rgba(255,255,255,0.07); --border2: rgba(255,255,255,0.04);
    --text: #e2e8f0; --text2: #94a3b8; --text3: #64748b; --text4: #475569;
    --purple: #7c3aed; --purple-light: #a78bfa;
    --teal: #0d9488; --teal-light: #2dd4bf;
    --green: #10b981; --amber: #f59e0b; --red: #f43f5e; --cyan: #06b6d4;
    --card: rgba(12,12,30,0.9); --radius: 14px; --radius-sm: 10px; --radius-xs: 7px;
    font-size: 15px;
    --row-bg: rgba(255,255,255,0.03); --ctrl-bg: rgba(255,255,255,0.05);
}
.light {
    --bg: #f0f0fa; --bg2: #fff; --bg3: #f8f7ff;
    --border: rgba(99,102,241,0.12); --border2: rgba(99,102,241,0.07);
    --text: #1e1b4b; --text2: #334155; --text3: #475569; --text4: #64748b;
    --card: #fff; --row-bg: rgba(0,0,0,0.03); --ctrl-bg: rgba(0,0,0,0.04);
}

/* ─── CALENDAR MODULE STYLES (all colors use your vars) ─── */
.font-jakarta{font-family:'Plus Jakarta Sans',sans-serif}

/* CARD */
.card{background:var(--card);border:1px solid var(--border);border-radius:var(--radius);padding:14px 16px}

/* BADGES */
.badge{display:inline-flex;align-items:center;padding:3px 8px;border-radius:99px;font-size:.67rem;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif}
.badge-purple{background:rgba(124,58,237,.18);color:var(--purple-light);border:1px solid rgba(124,58,237,.28)}
.badge-teal{background:rgba(13,148,136,.18);color:var(--teal-light);border:1px solid rgba(13,148,136,.28)}
.badge-amber{background:rgba(245,158,11,.18);color:var(--amber);border:1px solid rgba(245,158,11,.28)}
.badge-red{background:rgba(244,63,94,.18);color:var(--red);border:1px solid rgba(244,63,94,.28)}
.badge-green{background:rgba(16,185,129,.18);color:var(--green);border:1px solid rgba(16,185,129,.28)}
.badge-gray{background:var(--ctrl-bg);color:var(--text2);border:1px solid var(--border)}

/* STATUS PILLS */
.pill-done{display:inline-flex;align-items:center;padding:2px 7px;border-radius:99px;font-size:.62rem;font-weight:700;background:rgba(16,185,129,.15);color:var(--green);border:1px solid rgba(16,185,129,.25)}
.pill-urgent{display:inline-flex;align-items:center;padding:2px 7px;border-radius:99px;font-size:.62rem;font-weight:700;background:rgba(244,63,94,.15);color:var(--red);border:1px solid rgba(244,63,94,.25)}
.pill-soon{display:inline-flex;align-items:center;padding:2px 7px;border-radius:99px;font-size:.62rem;font-weight:700;background:rgba(245,158,11,.15);color:var(--amber);border:1px solid rgba(245,158,11,.25)}
.pill-ok{display:inline-flex;align-items:center;padding:2px 7px;border-radius:99px;font-size:.62rem;font-weight:700;background:rgba(13,148,136,.12);color:var(--teal-light);border:1px solid rgba(13,148,136,.2)}

/* BUTTONS */
.btn{display:inline-flex;align-items:center;gap:5px;border-radius:var(--radius-xs);font-weight:600;font-family:'Plus Jakarta Sans',sans-serif;cursor:pointer;transition:all .15s;border:none;font-size:.78rem;padding:7px 14px}
.btn-ghost{background:var(--ctrl-bg);border:1px solid var(--border);color:var(--text2)}
.btn-ghost:hover{background:var(--row-bg);border-color:var(--border);filter:brightness(1.4)}
.btn-primary{background:linear-gradient(135deg,var(--purple),#5b21b6);color:#fff;border:none;box-shadow:0 4px 12px rgba(124,58,237,.3)}
.btn-primary:hover{opacity:.9;transform:translateY(-1px)}
.btn-teal{background:rgba(13,148,136,.18);border:1px solid rgba(13,148,136,.28);color:var(--teal-light)}
.btn-teal:hover{background:rgba(13,148,136,.28)}
.btn-xs{padding:5px 10px!important;font-size:.72rem!important}

/* JUMP SELECTS */
.cal-jump-select{background:var(--ctrl-bg);border:1px solid var(--border);color:var(--text);border-radius:var(--radius-xs);padding:7px 30px 7px 12px;font-size:.82rem;font-weight:600;font-family:'Plus Jakarta Sans',sans-serif;cursor:pointer;outline:none;appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='%237c3aed'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 9px center;transition:border-color .2s}
.cal-jump-select option{background:var(--bg2);color:var(--text)}
.cal-jump-select:focus{border-color:var(--purple)}

/* USER PICKER */
.user-picker-wrap{position:relative;flex:1;min-width:220px;max-width:320px}
.user-picker-input{width:100%;background:var(--ctrl-bg);border:1px solid var(--border);color:var(--text);border-radius:var(--radius-xs);padding:8px 36px 8px 36px;font-size:.82rem;font-family:'DM Sans',sans-serif;outline:none;transition:border-color .2s}
.user-picker-input:focus{border-color:var(--purple);box-shadow:0 0 0 3px rgba(124,58,237,.15)}
.user-picker-icon{position:absolute;left:11px;top:50%;transform:translateY(-50%);color:var(--text3);font-size:.9rem;pointer-events:none}
.user-picker-clear{position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--text3);cursor:pointer;font-size:.85rem;padding:2px;display:none;transition:color .15s}
.user-picker-clear:hover{color:var(--red)}
.user-dropdown{position:absolute;top:calc(100% + 6px);left:0;right:0;background:var(--bg2);border:1px solid rgba(124,58,237,.25);border-radius:var(--radius-sm);z-index:9999;max-height:260px;overflow-y:auto;box-shadow:0 16px 40px rgba(0,0,0,.45);display:none}
.user-dropdown.open{display:block;animation:fadeUp .15s ease}
.user-drop-item{display:flex;align-items:center;gap:9px;padding:9px 12px;cursor:pointer;transition:background .15s}
.user-drop-item:hover{background:rgba(124,58,237,.1)}
.user-drop-item:first-child{border-radius:calc(var(--radius-sm) - 1px) calc(var(--radius-sm) - 1px) 0 0}
.user-drop-item:last-child{border-radius:0 0 calc(var(--radius-sm) - 1px) calc(var(--radius-sm) - 1px)}
.user-drop-avatar{width:30px;height:30px;border-radius:var(--radius-xs);display:flex;align-items:center;justify-content:center;font-size:.58rem;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;flex-shrink:0;color:#fff}
.user-drop-name{font-size:.82rem;font-weight:600;color:var(--text)}
.user-drop-meta{font-size:.7rem;color:var(--text3)}
.user-drop-empty{padding:16px;text-align:center;font-size:.8rem;color:var(--text3)}

/* CAL CELLS */
.cal-cell-v2{background:var(--row-bg);border:1px solid var(--border);border-radius:var(--radius-sm);padding:8px;min-height:88px;cursor:pointer;transition:all .2s;display:flex;flex-direction:column;position:relative;overflow:hidden}
.cal-cell-v2:hover{border-color:rgba(124,58,237,.4);background:rgba(124,58,237,.07)}
.cal-cell-v2.cal-today-v2{background:linear-gradient(135deg,rgba(124,58,237,.22),rgba(13,148,136,.12));border-color:rgba(124,58,237,.5)!important}
.cal-cell-v2.cal-other-month{opacity:.3;pointer-events:none}
.cal-cell-v2.has-reminders{border-color:rgba(124,58,237,.18)}
.cal-cell-v2.selected-day{outline:2px solid rgba(124,58,237,.55);outline-offset:1px}
.cal-day-num{font-size:.72rem;font-weight:700;color:var(--text3);margin-bottom:4px;line-height:1}
.cal-today-v2 .cal-day-num{color:var(--purple-light)}
.today-badge{display:inline-flex;align-items:center;justify-content:center;width:20px;height:20px;border-radius:50%;background:linear-gradient(135deg,var(--purple),var(--teal));color:#fff;font-size:.65rem;font-weight:800;flex-shrink:0}
.cal-chip{display:flex;align-items:center;gap:3px;padding:2px 5px;border-radius:4px;font-size:.57rem;font-weight:700;margin-bottom:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:100%;cursor:pointer;transition:opacity .15s}
.cal-chip:hover{opacity:.8}
.cal-chip-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
.cal-add-btn{position:absolute;bottom:6px;right:6px;width:22px;height:22px;border-radius:var(--radius-xs);background:rgba(124,58,237,.22);border:1px solid rgba(124,58,237,.38);color:var(--purple-light);display:none;align-items:center;justify-content:center;font-size:.75rem;cursor:pointer;transition:all .2s;z-index:2}
.cal-cell-v2:hover .cal-add-btn{display:flex}
.cal-add-btn:hover{background:rgba(124,58,237,.45);transform:scale(1.1)}
.cal-more-pill{font-size:.57rem;color:var(--purple-light);font-weight:700;padding:1px 5px;border-radius:4px;background:rgba(124,58,237,.1);border:1px solid rgba(124,58,237,.18);cursor:pointer;white-space:nowrap;margin-top:1px}

/* SIDE PANELS */
.day-panel{background:var(--card);border:1px solid var(--border);border-radius:var(--radius);padding:18px}
.day-ev-card{padding:12px;border-radius:var(--radius-sm);background:var(--row-bg);border:1px solid var(--border2);margin-bottom:8px;transition:border-color .2s}
.day-ev-card:hover{border-color:rgba(124,58,237,.28)}
.month-ev-item{display:flex;align-items:center;gap:9px;padding:9px 10px;border-radius:var(--radius-sm);cursor:pointer;transition:all .18s;background:var(--row-bg);border:1px solid var(--border2);margin-bottom:5px}
.month-ev-item:hover{border-color:rgba(124,58,237,.28);background:rgba(124,58,237,.06);transform:translateX(3px)}

/* STATS ROW */
.cal-stat{display:flex;flex-direction:column;align-items:center;padding:10px 16px;border-radius:var(--radius-sm);background:var(--row-bg);border:1px solid var(--border);flex:1;min-width:0}
.cal-stat-num{font-size:1.3rem;font-weight:800;font-family:'Plus Jakarta Sans',sans-serif;line-height:1;margin-bottom:3px}
.cal-stat-lbl{font-size:.67rem;color:var(--text3);font-weight:600;text-align:center;white-space:nowrap}

/* CATEGORY FILTER */
.cat-filter-bar{display:flex;gap:6px;overflow-x:auto;padding-bottom:2px;scrollbar-width:none}
.cat-filter-bar::-webkit-scrollbar{display:none}
.cat-legend-item{display:flex;align-items:center;gap:6px;padding:5px 10px;border-radius:var(--radius-xs);font-size:.72rem;font-weight:600;cursor:pointer;transition:all .15s;white-space:nowrap;border:1px solid transparent;color:var(--text3);background:none}
.cat-legend-item:hover{background:rgba(124,58,237,.07)}
.cat-legend-item.active{background:rgba(124,58,237,.1);border-color:rgba(124,58,237,.25);color:var(--purple-light)}
.cat-legend-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0}

/* QUICK CREATE MODAL */
.qc-overlay{position:fixed;inset:0;background:rgba(0,0,0,.6);backdrop-filter:blur(6px);z-index:9998;display:flex;align-items:center;justify-content:center;padding:20px;opacity:0;pointer-events:none;transition:opacity .25s}
.qc-overlay.open{opacity:1;pointer-events:all}
.qc-box{background:var(--bg2);border:1px solid rgba(124,58,237,.3);border-radius:var(--radius);padding:28px;width:100%;max-width:480px;max-height:90vh;overflow-y:auto;transform:translateY(24px) scale(.97);transition:transform .3s cubic-bezier(.16,1,.3,1);box-shadow:0 32px 64px rgba(0,0,0,.45)}
.qc-overlay.open .qc-box{transform:translateY(0) scale(1)}
.qc-input{width:100%;background:var(--ctrl-bg);border:1px solid var(--border);color:var(--text);border-radius:var(--radius-xs);padding:9px 12px;font-size:.85rem;font-family:'DM Sans',sans-serif;outline:none;transition:border-color .2s}
.qc-input:focus{border-color:var(--purple);box-shadow:0 0 0 3px rgba(124,58,237,.12)}
.qc-label{font-size:.72rem;font-weight:700;color:var(--text3);margin-bottom:5px;display:block;text-transform:uppercase;letter-spacing:.06em}

/* TOAST */
#toast-container{position:fixed;bottom:24px;right:24px;z-index:99999;display:flex;flex-direction:column;gap:8px}
.toast-item{padding:10px 16px;border-radius:var(--radius-sm);font-size:.82rem;font-weight:600;font-family:'Plus Jakarta Sans',sans-serif;animation:toastIn .3s ease;display:flex;align-items:center;gap:8px;box-shadow:0 8px 24px rgba(0,0,0,.35)}
.toast-success{background:rgba(16,185,129,.18);border:1px solid rgba(16,185,129,.35);color:var(--green)}
.toast-error{background:rgba(244,63,94,.18);border:1px solid rgba(244,63,94,.35);color:var(--red)}

@keyframes fadeUp{from{opacity:0;transform:translateY(6px)}to{opacity:1;transform:translateY(0)}}
@keyframes toastIn{from{opacity:0;transform:translateX(12px)}to{opacity:1;transform:translateX(0)}}
@media(max-width:900px){.cal-layout{grid-template-columns:1fr!important}.cal-side{display:none}}
@media(max-width:640px){.cal-cell-v2{min-height:56px;padding:5px}.cal-chip{display:none}}
</style>
</head>
<body>

<section id="page-calendar" style="max-width:1280px;margin:0 auto">

  <!-- PAGE HEADER -->
  <div style="display:flex;align-items:center;gap:12px;margin-bottom:18px">
    <div style="width:38px;height:38px;border-radius:var(--radius-sm);background:linear-gradient(135deg,var(--purple),var(--teal));display:flex;align-items:center;justify-content:center">
      <i class="ri-calendar-2-line" style="color:#fff;font-size:1.1rem"></i>
    </div>
    <div>
      <h1 class="font-jakarta" style="font-size:1.1rem;font-weight:800;color:var(--text);line-height:1">Admin Calendar</h1>
      <p style="font-size:.72rem;color:var(--text3)">View and manage reminders for any user</p>
    </div>
  </div>

  <!-- USER SEARCH BAR -->
  <div class="card" style="margin-bottom:14px">
    <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap">
      <div style="display:flex;align-items:center;gap:6px;flex-shrink:0">
        <i class="ri-user-search-line" style="color:var(--purple-light);font-size:1rem"></i>
        <span class="font-jakarta" style="font-size:.82rem;font-weight:700;color:var(--text2);white-space:nowrap">Viewing as:</span>
      </div>
      <div class="user-picker-wrap" id="user-picker-wrap">
        <i class="ri-search-line user-picker-icon"></i>
        <input class="user-picker-input" id="user-picker-input"
          placeholder="Search user by name or email…"
          autocomplete="off"
          oninput="adminCalUserSearch(this.value)"
          onfocus="adminCalUserSearch(this.value)">
        <button class="user-picker-clear" id="user-picker-clear" onclick="adminCalClearUser()" title="Clear">
          <i class="ri-close-line"></i>
        </button>
        <div class="user-dropdown" id="user-dropdown"></div>
      </div>
      <!-- Selected user pill -->
      <div id="selected-user-pill" style="display:none;align-items:center;gap:8px;padding:6px 12px;border-radius:99px;background:rgba(124,58,237,.14);border:1px solid rgba(124,58,237,.28)">
        <div id="sel-user-avatar" style="width:22px;height:22px;border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:.55rem;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;color:#fff;flex-shrink:0"></div>
        <span id="sel-user-name" class="font-jakarta" style="font-size:.8rem;font-weight:700;color:var(--purple-light)"></span>
        <span id="sel-user-plan" class="badge badge-teal" style="font-size:.58rem"></span>
      </div>
      <div style="margin-left:auto;font-size:.75rem;color:var(--text3)" id="cal-user-hint">
        <i class="ri-information-line"></i> Select a user to view their reminders
      </div>
    </div>
  </div>

  <!-- TOP CONTROLS -->
  <div class="card" style="padding:14px 16px;margin-bottom:14px">
    <div style="display:flex;flex-wrap:wrap;align-items:center;gap:10px">
      <div style="display:flex;gap:6px;align-items:center">
        <button class="btn btn-ghost btn-xs" onclick="calPrev()" style="padding:7px 10px!important"><i class="ri-arrow-left-s-line" style="font-size:1rem"></i></button>
        <button class="btn btn-ghost btn-xs" onclick="calGoToday()" style="padding:6px 12px!important;font-size:.75rem">Today</button>
        <button class="btn btn-ghost btn-xs" onclick="calNext()" style="padding:7px 10px!important"><i class="ri-arrow-right-s-line" style="font-size:1rem"></i></button>
      </div>
      <div style="display:flex;gap:6px;align-items:center">
        <select class="cal-jump-select" id="cal-month-sel" onchange="calJump()"></select>
        <select class="cal-jump-select" id="cal-year-sel" onchange="calJump()"></select>
      </div>
      <div id="cal-label-v2" class="font-jakarta" style="font-weight:800;font-size:1rem;color:var(--text);flex:1;text-align:center;min-width:120px"></div>
      <div style="display:flex;gap:6px;align-items:center;margin-left:auto">
        <button class="btn btn-ghost btn-xs" onclick="calExport()" style="padding:6px 12px!important;font-size:.75rem">
          <i class="ri-download-2-line"></i> Export
        </button>
      </div>
    </div>
  </div>

  <!-- STATS ROW -->
  <div style="display:flex;gap:10px;margin-bottom:14px;overflow-x:auto" id="cal-stats-row"></div>

  <!-- CATEGORY FILTER -->
  <div class="card" style="padding:12px 14px;margin-bottom:14px">
    <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap">
      <span style="font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--text3);flex-shrink:0">Filter:</span>
      <div class="cat-filter-bar" id="cat-filter-bar">
        <button class="cat-legend-item active" data-cat="all" onclick="calSetCatFilter('all',this)">
          <div class="cat-legend-dot" style="background:linear-gradient(135deg,var(--purple),var(--teal))"></div> All
        </button>
      </div>
    </div>
  </div>

  <!-- MAIN LAYOUT -->
  <div class="cal-layout" style="display:grid;grid-template-columns:1fr 300px;gap:14px;align-items:start">

    <!-- Calendar Grid -->
    <div>
      <div class="card" style="padding:14px">
        <div style="display:grid;grid-template-columns:repeat(7,1fr);gap:4px;margin-bottom:6px">
          <div style="text-align:center;font-size:.6rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--text3);padding:5px 0">Sun</div>
          <div style="text-align:center;font-size:.6rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--text3);padding:5px 0">Mon</div>
          <div style="text-align:center;font-size:.6rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--text3);padding:5px 0">Tue</div>
          <div style="text-align:center;font-size:.6rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--text3);padding:5px 0">Wed</div>
          <div style="text-align:center;font-size:.6rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--text3);padding:5px 0">Thu</div>
          <div style="text-align:center;font-size:.6rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--text3);padding:5px 0">Fri</div>
          <div style="text-align:center;font-size:.6rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--text3);padding:5px 0">Sat</div>
        </div>
        <div id="cal-grid-v2" style="display:grid;grid-template-columns:repeat(7,1fr);gap:4px"></div>
      </div>
    </div>

    <!-- Side Panels -->
    <div class="cal-side" style="display:flex;flex-direction:column;gap:12px">
      <div class="day-panel">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
          <h3 class="font-jakarta" id="sel-day-title-v2" style="font-weight:700;font-size:.87rem;color:var(--text)">Select a day</h3>
          <button id="sel-day-add-btn" class="btn btn-primary btn-xs" style="display:none" onclick="openReminderModal()">
            <i class="ri-add-line"></i> Add
          </button>
        </div>
        <div id="sel-day-events-v2">
          <div style="text-align:center;padding:32px 0;color:var(--text3)">
            <i class="ri-calendar-line" style="font-size:1.8rem;display:block;margin-bottom:8px;opacity:.3"></i>
            <p style="font-size:.8rem">Click a day to view reminders</p>
          </div>
        </div>
      </div>
      <div class="day-panel">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
          <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:var(--text)">This Month</h3>
          <span class="badge badge-purple" id="month-ev-cnt-v2">0</span>
        </div>
        <div id="month-events-v2" style="max-height:340px;overflow-y:auto"></div>
      </div>
    </div>

  </div>
</section>

<!-- QUICK CREATE OVERLAY -->
<div class="qc-overlay" id="qc-overlay" onclick="if(event.target===this)closeQuickCreate()">
  <div class="qc-box">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
      <div>
        <h2 class="font-jakarta" style="font-size:1rem;font-weight:800;color:var(--text)">New Reminder</h2>
        <div id="qc-date-label" style="font-size:.75rem;color:var(--purple-light);margin-top:2px"></div>
      </div>
      <button onclick="closeQuickCreate()" style="background:var(--ctrl-bg);border:1px solid var(--border);color:var(--text2);width:30px;height:30px;border-radius:var(--radius-xs);cursor:pointer;display:flex;align-items:center;justify-content:center">
        <i class="ri-close-line"></i>
      </button>
    </div>
    <form onsubmit="qcSubmit(event)">
      <div style="display:flex;flex-direction:column;gap:14px">
        <div>
          <label class="qc-label">Title</label>
          <input class="qc-input" id="qc-title" placeholder="Reminder title…" required minlength="3">
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
          <div>
            <label class="qc-label">Category</label>
            <select class="qc-input" id="qc-cat" onchange="qcUpdateSubs()" required><option value="">Select…</option></select>
          </div>
          <div>
            <label class="qc-label">Subcategory</label>
            <select class="qc-input" id="qc-sub" disabled><option value="">Select category…</option></select>
          </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
          <div>
            <label class="qc-label">Date</label>
            <input class="qc-input" id="qc-date" type="date" required>
          </div>
          <div>
            <label class="qc-label">Time</label>
            <input class="qc-input" id="qc-time" type="time" value="09:00">
          </div>
        </div>
        <div>
          <label class="qc-label">Notes</label>
          <textarea class="qc-input" id="qc-desc" rows="2" placeholder="Optional notes…" style="resize:vertical"></textarea>
        </div>
        <div style="display:flex;gap:8px;margin-top:4px">
          <button type="button" onclick="closeQuickCreate()" class="btn btn-ghost" style="flex:1">Cancel</button>
          <button type="submit" class="btn btn-primary" style="flex:2"><i class="ri-check-line"></i> Create Reminder</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Toast Container -->
<div id="toast-container"></div>

<script>
document.addEventListener('click',function(e){
  if(!document.getElementById('user-picker-wrap').contains(e.target))
    document.getElementById('user-dropdown').classList.remove('open');
});
</script>

<script>
// ═══════════════════════════════════════════════════════
// STATIC SAMPLE USERS + THEIR REMINDERS
// ═══════════════════════════════════════════════════════

const SAMPLE_USERS = [
  {
    id:'u001', name:'Arjun Sharma', email:'arjun.sharma@gmail.com',
    plan:'Pro', avatar:'AS', avatarBg:'#7c3aed',
    reminders:[
      {id:'r001',title:'Car Insurance Renewal',category:'insurance',subcategory:'Motor Insurance',dueDate:'2026-04-15',dueTime:'10:00',status:'completed',provider:'LIC Insurance',cost:'8500'},
      {id:'r002',title:'Netflix Subscription',category:'subscriptions',subcategory:'Streaming',dueDate:'2026-04-28',dueTime:'09:00',status:'active',provider:'Netflix',cost:'649'},
      {id:'r003',title:'Mom Birthday',category:'special-days',subcategory:'Birthday',dueDate:'2026-04-30',dueTime:'',status:'active',provider:''},
      {id:'r004',title:'Dog Vaccination',category:'pet-care',subcategory:'Vaccination',dueDate:'2026-05-05',dueTime:'11:00',status:'active',provider:'PetCare Clinic',cost:'1200'},
      {id:'r005',title:'Home Loan EMI',category:'home',subcategory:'Loan EMI',dueDate:'2026-05-01',dueTime:'09:00',status:'active',provider:'HDFC Bank',cost:'45000'},
      {id:'r006',title:'Health Checkup',category:'health',subcategory:'Annual Checkup',dueDate:'2026-05-12',dueTime:'08:30',status:'active',provider:'Apollo Hospital',cost:'3500'},
      {id:'r007',title:'Jio Recharge',category:'tv-telephone-mobile',subcategory:'Mobile Recharge',dueDate:'2026-05-10',dueTime:'',status:'active',provider:'Jio',cost:'299'},
      {id:'r008',title:'Wedding Anniversary',category:'special-days',subcategory:'Anniversary',dueDate:'2026-05-20',dueTime:'',status:'active',provider:''},
      {id:'r009',title:'Flight to Mumbai',category:'travel',subcategory:'Domestic Flight',dueDate:'2026-05-25',dueTime:'14:00',status:'active',provider:'IndiGo',cost:'4200'},
      {id:'r010',title:'Car Service',category:'motor-vehicle',subcategory:'Periodic Service',dueDate:'2026-05-18',dueTime:'10:00',status:'active',provider:'Maruti Service',cost:'6000'},
    ]
  },
  {
    id:'u002', name:'Priya Menon', email:'priya.menon@outlook.com',
    plan:'Free', avatar:'PM', avatarBg:'#ec4899',
    reminders:[
      {id:'r011',title:'Dental Appointment',category:'health',subcategory:'Dental',dueDate:'2026-04-29',dueTime:'11:00',status:'active',provider:'SmileCare Dental',cost:'2000'},
      {id:'r012',title:'Amazon Prime',category:'subscriptions',subcategory:'Streaming',dueDate:'2026-04-29',dueTime:'',status:'active',provider:'Amazon',cost:'1499'},
      {id:'r013',title:'Rent Payment',category:'home',subcategory:'Rent',dueDate:'2026-05-01',dueTime:'',status:'active',provider:'Landlord',cost:'22000'},
      {id:'r014',title:'Bike Insurance',category:'insurance',subcategory:'Two-Wheeler',dueDate:'2026-05-08',dueTime:'',status:'active',provider:'Bajaj Allianz',cost:'3200'},
      {id:'r015',title:'Spotify Premium',category:'subscriptions',subcategory:'Music',dueDate:'2026-05-15',dueTime:'',status:'active',provider:'Spotify',cost:'119'},
      {id:'r016',title:'Sister Birthday',category:'special-days',subcategory:'Birthday',dueDate:'2026-05-22',dueTime:'',status:'active',provider:''},
      {id:'r017',title:'Eye Checkup',category:'health',subcategory:'Eye Care',dueDate:'2026-05-28',dueTime:'10:00',status:'active',provider:'Vision Plus',cost:'500'},
      {id:'r018',title:'Passport Renewal',category:'travel',subcategory:'Documents',dueDate:'2026-06-10',dueTime:'',status:'active',provider:'Passport Office',cost:'1500'},
    ]
  },
  {
    id:'u003', name:'Karthik Rajan', email:'karthik.rajan@yahoo.com',
    plan:'Pro', avatar:'KR', avatarBg:'#14b8a6',
    reminders:[
      {id:'r019',title:'Gym Membership',category:'health',subcategory:'Fitness',dueDate:'2026-04-28',dueTime:'',status:'active',provider:'FitZone Gym',cost:'2500'},
      {id:'r020',title:'Car Pollution Check',category:'motor-vehicle',subcategory:'PUC Certificate',dueDate:'2026-04-28',dueTime:'',status:'active',provider:'RTO Authorised',cost:'200'},
      {id:'r021',title:'Term Life Insurance',category:'insurance',subcategory:'Life Insurance',dueDate:'2026-05-03',dueTime:'',status:'active',provider:'Max Life',cost:'12000'},
      {id:'r022',title:'Airtel Broadband',category:'tv-telephone-mobile',subcategory:'Broadband',dueDate:'2026-05-05',dueTime:'',status:'active',provider:'Airtel',cost:'999'},
      {id:'r023',title:'Father Birthday',category:'special-days',subcategory:'Birthday',dueDate:'2026-05-07',dueTime:'',status:'active',provider:''},
      {id:'r024',title:'Mutual Fund SIP',category:'home',subcategory:'Investment',dueDate:'2026-05-10',dueTime:'',status:'active',provider:'Zerodha',cost:'5000'},
      {id:'r025',title:'Goa Trip Booking',category:'travel',subcategory:'Holiday',dueDate:'2026-05-15',dueTime:'',status:'active',provider:'MakeMyTrip',cost:'15000'},
      {id:'r026',title:'AC Annual Service',category:'home',subcategory:'Maintenance',dueDate:'2026-05-20',dueTime:'10:00',status:'active',provider:'Daikin Service',cost:'1800'},
      {id:'r027',title:'Blood Test',category:'health',subcategory:'Lab Test',dueDate:'2026-05-25',dueTime:'07:30',status:'active',provider:'SRL Diagnostics',cost:'800'},
    ]
  },
  {
    id:'u004', name:'Divya Nair', email:'divya.nair@gmail.com',
    plan:'Pro', avatar:'DN', avatarBg:'#f59e0b',
    reminders:[
      {id:'r028',title:'Kids School Fees',category:'home',subcategory:'Education',dueDate:'2026-04-30',dueTime:'',status:'active',provider:'St. Thomas School',cost:'35000'},
      {id:'r029',title:'Health Insurance Premium',category:'insurance',subcategory:'Health Insurance',dueDate:'2026-05-02',dueTime:'',status:'active',provider:'Star Health',cost:'18000'},
      {id:'r030',title:'Wedding Anniversary',category:'special-days',subcategory:'Anniversary',dueDate:'2026-05-04',dueTime:'',status:'active',provider:''},
      {id:'r031',title:'YouTube Premium',category:'subscriptions',subcategory:'Streaming',dueDate:'2026-05-08',dueTime:'',status:'active',provider:'Google',cost:'189'},
      {id:'r032',title:'Cat Vaccination',category:'pet-care',subcategory:'Vaccination',dueDate:'2026-05-12',dueTime:'10:00',status:'active',provider:'Happy Paws Vet',cost:'900'},
      {id:'r033',title:'Electricity Bill',category:'home',subcategory:'Utilities',dueDate:'2026-05-15',dueTime:'',status:'active',provider:'TNEB',cost:'3200'},
      {id:'r034',title:'Driving License Renewal',category:'motor-vehicle',subcategory:'License',dueDate:'2026-05-30',dueTime:'',status:'active',provider:'RTO',cost:'400'},
      {id:'r035',title:'Singapore Trip',category:'travel',subcategory:'International',dueDate:'2026-06-01',dueTime:'06:00',status:'active',provider:'Air India',cost:'28000'},
    ]
  },
  {
    id:'u005', name:'Rahul Pillai', email:'rahul.pillai@hotmail.com',
    plan:'Free', avatar:'RP', avatarBg:'#f43f5e',
    reminders:[
      {id:'r036',title:'Bike Service',category:'motor-vehicle',subcategory:'Periodic Service',dueDate:'2026-04-28',dueTime:'09:00',status:'active',provider:'TVS Service',cost:'1200'},
      {id:'r037',title:'BSNL Landline Bill',category:'tv-telephone-mobile',subcategory:'Landline',dueDate:'2026-05-05',dueTime:'',status:'active',provider:'BSNL',cost:'450'},
      {id:'r038',title:'Gym Renewal',category:'health',subcategory:'Fitness',dueDate:'2026-05-10',dueTime:'',status:'active',provider:'Gold\'s Gym',cost:'3000'},
      {id:'r039',title:'Mom Anniversary',category:'special-days',subcategory:'Anniversary',dueDate:'2026-05-14',dueTime:'',status:'active',provider:''},
      {id:'r040',title:'Cricket Kit Insurance',category:'insurance',subcategory:'Other',dueDate:'2026-05-18',dueTime:'',status:'active',provider:'General Insurance',cost:'2000'},
    ]
  },
  {
    id:'u006', name:'Sneha Krishnamurthy', email:'sneha.k@icloud.com',
    plan:'Pro', avatar:'SK', avatarBg:'#8b5cf6',
    reminders:[
      {id:'r041',title:'Adobe Creative Cloud',category:'subscriptions',subcategory:'Design Tools',dueDate:'2026-04-29',dueTime:'',status:'active',provider:'Adobe',cost:'4230'},
      {id:'r042',title:'House Painting',category:'home',subcategory:'Maintenance',dueDate:'2026-05-01',dueTime:'08:00',status:'active',provider:'Local Painter',cost:'25000'},
      {id:'r043',title:'Mother-in-Law Birthday',category:'special-days',subcategory:'Birthday',dueDate:'2026-05-06',dueTime:'',status:'active',provider:''},
      {id:'r044',title:'Two-Wheeler Tax',category:'motor-vehicle',subcategory:'Road Tax',dueDate:'2026-05-09',dueTime:'',status:'active',provider:'RTO',cost:'3000'},
      {id:'r045',title:'Allergy Medication',category:'health',subcategory:'Prescription',dueDate:'2026-05-11',dueTime:'08:00',status:'active',provider:'Apollo Pharmacy',cost:'600'},
      {id:'r046',title:'Maldives Honeymoon',category:'travel',subcategory:'International',dueDate:'2026-05-16',dueTime:'05:00',status:'active',provider:'Cox & Kings',cost:'75000'},
      {id:'r047',title:'Tata Sky DTH',category:'tv-telephone-mobile',subcategory:'DTH',dueDate:'2026-05-20',dueTime:'',status:'active',provider:'Tata Sky',cost:'599'},
    ]
  }
];

// ═══════════════════════════════════════════════════════
// CATEGORY CONFIG
// ═══════════════════════════════════════════════════════

const CAL_CATS = {
  'special-days':       {name:'Special Days',      color:'#f59e0b',bg:'rgba(245,158,11,.15)',  icon:'ri-cake-3-line'},
  'home':               {name:'Home',              color:'#14b8a6',bg:'rgba(20,184,166,.15)',  icon:'ri-home-4-line'},
  'insurance':          {name:'Insurance',         color:'#f43f5e',bg:'rgba(244,63,94,.15)',   icon:'ri-shield-star-line'},
  'tv-telephone-mobile':{name:'TV / Tel',          color:'#14b8a6',bg:'rgba(20,184,166,.12)',  icon:'ri-smartphone-line'},
  'motor-vehicle':      {name:'Motor Vehicle',     color:'#a78bfa',bg:'rgba(167,139,250,.15)', icon:'ri-car-line'},
  'travel':             {name:'Travel',            color:'#ec4899',bg:'rgba(236,72,153,.15)',  icon:'ri-flight-takeoff-line'},
  'subscriptions':      {name:'Subscriptions',     color:'#14b8a6',bg:'rgba(20,184,166,.12)',  icon:'ri-refresh-line'},
  'pet-care':           {name:'Pet Care',          color:'#10b981',bg:'rgba(16,185,129,.15)',  icon:'ri-footprint-line'},
  'health':             {name:'Health',            color:'#10b981',bg:'rgba(16,185,129,.15)',  icon:'ri-heart-pulse-line'},
  'others':             {name:'Others',            color:'#94a3b8',bg:'rgba(148,163,184,.12)', icon:'ri-more-2-line'}
};

const CAL_SUBS = {
  'special-days':['Birthday','Anniversary','Graduation','Festival'],
  'home':['Rent','Loan EMI','Utilities','Maintenance','Education','Investment'],
  'insurance':['Health Insurance','Motor Insurance','Life Insurance','Two-Wheeler','Other'],
  'tv-telephone-mobile':['Mobile Recharge','Broadband','DTH','Landline'],
  'motor-vehicle':['Periodic Service','PUC Certificate','Road Tax','License','Insurance'],
  'travel':['Domestic Flight','International','Holiday','Documents','Hotel'],
  'subscriptions':['Streaming','Music','Design Tools','Cloud Storage','Other'],
  'pet-care':['Vaccination','Grooming','Vet Visit','Food'],
  'health':['Annual Checkup','Dental','Eye Care','Lab Test','Fitness','Prescription'],
  'others':['Other']
};

const CAL_MONTHS = ['January','February','March','April','May','June','July','August','September','October','November','December'];
const CAL_MONTHS_SHORT = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

let _calY, _calM, _calCatFilter='all', _selDay=null, _selUserId=null;
window._selDay = null;

// ── Helpers
function _pad(n){return String(n).padStart(2,'0')}
function daysUntil(ds){
  const t=new Date(); t.setHours(0,0,0,0);
  const d=new Date(ds); d.setHours(0,0,0,0);
  return Math.round((d-t)/(1000*60*60*24));
}
function fmtDate(ds){
  const [y,m,d]=ds.split('-');
  return `${parseInt(d)} ${CAL_MONTHS_SHORT[parseInt(m)-1]} ${y}`;
}
function toast(msg,type='success'){
  const c=document.getElementById('toast-container');
  const t=document.createElement('div');
  t.className=`toast-item toast-${type}`;
  t.innerHTML=`<i class="ri-${type==='success'?'check':'error-warning'}-line"></i>${msg}`;
  c.appendChild(t);
  setTimeout(()=>{t.style.opacity='0';t.style.transform='translateX(12px)';t.style.transition='all .3s';setTimeout(()=>t.remove(),300)},3000);
}

// ── Get reminders for selected user
function getRems(){
  if(!_selUserId) return [];
  const u=SAMPLE_USERS.find(u=>u.id===_selUserId);
  return u ? [...u.reminders] : [];
}
function saveRems(rems){
  if(!_selUserId) return;
  const u=SAMPLE_USERS.find(u=>u.id===_selUserId);
  if(u) u.reminders=rems;
}
function markDone(id){
  const rems=getRems();
  const r=rems.find(r=>r.id===id);
  if(r){r.status='completed';saveRems(rems);}
}

// ═══════════════════════════════════════════════════════
// USER SEARCH + PICKER
// ═══════════════════════════════════════════════════════

function adminCalUserSearch(q){
  const dd=document.getElementById('user-dropdown');
  const cl=document.getElementById('user-picker-clear');
  cl.style.display=q.length>0?'block':'none';
  const filtered=SAMPLE_USERS.filter(u=>
    u.name.toLowerCase().includes(q.toLowerCase())||
    u.email.toLowerCase().includes(q.toLowerCase())
  );
  if(filtered.length===0){
    dd.innerHTML=`<div class="user-drop-empty"><i class="ri-user-search-line"></i><br>No users found</div>`;
  } else {
    dd.innerHTML=filtered.map(u=>`
      <div class="user-drop-item" onclick="adminCalSelectUser('${u.id}')">
        <div class="user-drop-avatar" style="background:${u.avatarBg}">${u.avatar}</div>
        <div style="flex:1;min-width:0">
          <div class="user-drop-name">${u.name}</div>
          <div class="user-drop-meta">${u.email}</div>
        </div>
        <span class="badge ${u.plan==='Pro'?'badge-purple':'badge-gray'}" style="font-size:.58rem">${u.plan}</span>
      </div>
    `).join('');
  }
  dd.classList.add('open');
}

function adminCalSelectUser(uid){
  _selUserId=uid;
  const u=SAMPLE_USERS.find(u=>u.id===uid);
  if(!u) return;

  // Close dropdown
  document.getElementById('user-dropdown').classList.remove('open');

  // Update input
  document.getElementById('user-picker-input').value=u.name;
  document.getElementById('user-picker-clear').style.display='block';

  // Show pill
  const pill=document.getElementById('selected-user-pill');
  pill.style.display='flex';
  document.getElementById('sel-user-avatar').textContent=u.avatar;
  document.getElementById('sel-user-avatar').style.background=u.avatarBg;
  document.getElementById('sel-user-name').textContent=u.name;
  document.getElementById('sel-user-plan').textContent=u.plan;
  document.getElementById('sel-user-plan').className=`badge ${u.plan==='Pro'?'badge-purple':'badge-gray'}`;

  // Update hint
  document.getElementById('cal-user-hint').innerHTML=`<i class="ri-eye-line" style="color:#a78bfa"></i> <span style="color:#a78bfa">Viewing ${u.name}'s calendar</span>`;

  // Re-render calendar
  _renderAll();
  toast(`Now viewing ${u.name}'s calendar`,'success');
}

function adminCalClearUser(){
  _selUserId=null;
  document.getElementById('user-picker-input').value='';
  document.getElementById('user-picker-clear').style.display='none';
  document.getElementById('selected-user-pill').style.display='none';
  document.getElementById('cal-user-hint').innerHTML=`<i class="ri-information-line"></i> Select a user to view their reminders`;
  _selDay=null; window._selDay=null;
  _renderAll();
}

// ═══════════════════════════════════════════════════════
// CALENDAR ENGINE
// ═══════════════════════════════════════════════════════

function initCalendarV2(){
  const n=new Date();
  _calY=n.getFullYear();
  _calM=n.getMonth();
  _buildJumpSelects();
  _buildCatFilter();
  _renderAll();
}

function _buildJumpSelects(){
  const ms=document.getElementById('cal-month-sel');
  const ys=document.getElementById('cal-year-sel');
  ms.innerHTML=CAL_MONTHS.map((m,i)=>`<option value="${i}">${m}</option>`).join('');
  const cy=new Date().getFullYear();
  ys.innerHTML='';
  for(let y=cy-5;y<=cy+10;y++) ys.innerHTML+=`<option value="${y}">${y}</option>`;
}

function _syncJumpSelects(){
  document.getElementById('cal-month-sel').value=_calM;
  document.getElementById('cal-year-sel').value=_calY;
}

function calJump(){
  _calM=parseInt(document.getElementById('cal-month-sel').value);
  _calY=parseInt(document.getElementById('cal-year-sel').value);
  _renderAll();
}
function calPrev(){_calM--;if(_calM<0){_calM=11;_calY--;}_renderAll();}
function calNext(){_calM++;if(_calM>11){_calM=0;_calY++;}_renderAll();}
function calGoToday(){const n=new Date();_calY=n.getFullYear();_calM=n.getMonth();_renderAll();_selectDay(n.getDate());}

// ── Cat filter
function _buildCatFilter(){
  const bar=document.getElementById('cat-filter-bar');
  Object.entries(CAL_CATS).forEach(([k,c])=>{
    const btn=document.createElement('button');
    btn.className='cat-legend-item';
    btn.dataset.cat=k;
    btn.onclick=()=>calSetCatFilter(k,btn);
    btn.innerHTML=`<div class="cat-legend-dot" style="background:${c.color}"></div>${c.name}`;
    bar.appendChild(btn);
  });
}

function calSetCatFilter(cat,btn){
  _calCatFilter=cat;
  document.querySelectorAll('.cat-legend-item').forEach(b=>b.classList.remove('active'));
  btn.classList.add('active');
  _renderGrid();_renderMonthEvents();_renderStats();
}

// ── Filtered rems
function _getRems(y,m){
  let rems=getRems().filter(r=>{const d=new Date(r.dueDate);return d.getFullYear()===y&&d.getMonth()===m;});
  if(_calCatFilter!=='all') rems=rems.filter(r=>r.category===_calCatFilter);
  return rems;
}
function _getRemsDate(ds){
  let rems=getRems().filter(r=>r.dueDate===ds);
  if(_calCatFilter!=='all') rems=rems.filter(r=>r.category===_calCatFilter);
  return rems;
}

// ── Render all
function _renderAll(){
  _syncJumpSelects();
  document.getElementById('cal-label-v2').textContent=`${CAL_MONTHS[_calM]} ${_calY}`;
  _renderGrid();_renderMonthEvents();_renderStats();
}

// ── Render grid
function _renderGrid(){
  const grid=document.getElementById('cal-grid-v2');
  grid.innerHTML='';
  const first=new Date(_calY,_calM,1).getDay();
  const days=new Date(_calY,_calM+1,0).getDate();
  const tod=new Date();
  const toStr=`${tod.getFullYear()}-${_pad(tod.getMonth()+1)}-${_pad(tod.getDate())}`;

  // No user selected — show muted grid with overlay prompt
  if(!_selUserId){
    const totalCells = first + days;
    const remaining = totalCells%7===0?0:7-(totalCells%7);
    const allCells = first + days + remaining;
    
    // Prev filler
    const prevDays=new Date(_calY,_calM,0).getDate();
    for(let i=0;i<first;i++){
      const dn=prevDays-first+i+1;
      const cell=document.createElement('div');
      cell.className='cal-cell-v2 cal-other-month';
      cell.innerHTML=`<div class="cal-day-num">${dn}</div>`;
      grid.appendChild(cell);
    }
    // Cur month (muted)
    for(let d=1;d<=days;d++){
      const ds=`${_calY}-${_pad(_calM+1)}-${_pad(d)}`;
      const isToday=ds===toStr;
      const cell=document.createElement('div');
      cell.className='cal-cell-v2'+(isToday?' cal-today-v2':'');
      cell.style.opacity='.4';
      cell.style.pointerEvents='none';
      cell.innerHTML=isToday
        ?`<div class="cal-day-num" style="display:flex;align-items:center;gap:4px"><span class="today-badge">${d}</span></div>`
        :`<div class="cal-day-num">${d}</div>`;
      grid.appendChild(cell);
    }
    // Next filler
    for(let i=1;i<=remaining;i++){
      const cell=document.createElement('div');
      cell.className='cal-cell-v2 cal-other-month';
      cell.innerHTML=`<div class="cal-day-num">${i}</div>`;
      grid.appendChild(cell);
    }

    // Overlay prompt on top of grid area
    const wrap=document.getElementById('cal-grid-v2').parentElement;
    if(!document.getElementById('cal-no-user-overlay')){
      const ov=document.createElement('div');
      ov.id='cal-no-user-overlay';
      ov.style.cssText='position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:14px;background:rgba(8,8,24,.75);backdrop-filter:blur(4px);border-radius:var(--radius-lg);z-index:10';
      ov.innerHTML=`
        <div style="width:64px;height:64px;border-radius:18px;background:rgba(124,58,237,.15);border:2px dashed rgba(124,58,237,.4);display:flex;align-items:center;justify-content:center">
          <i class="ri-user-search-line" style="font-size:1.6rem;color:#a78bfa"></i>
        </div>
        <div style="text-align:center">
          <div class="font-jakarta" style="font-weight:700;color:#f1f5f9;font-size:.9rem;margin-bottom:6px">No user selected</div>
          <div style="font-size:.78rem;color:#64748b;max-width:220px;line-height:1.5">Search and select a user above to view their reminders on this calendar</div>
        </div>`;
      wrap.style.position='relative';
      wrap.appendChild(ov);
    }
    return;
  }

  // Remove overlay if user selected
  const ov=document.getElementById('cal-no-user-overlay');
  if(ov) ov.remove();

  // Prev filler
  const prevDays=new Date(_calY,_calM,0).getDate();
  for(let i=0;i<first;i++){
    const dn=prevDays-first+i+1;
    const cell=document.createElement('div');
    cell.className='cal-cell-v2 cal-other-month';
    cell.innerHTML=`<div class="cal-day-num">${dn}</div>`;
    grid.appendChild(cell);
  }

  // Current month
  for(let d=1;d<=days;d++){
    const ds=`${_calY}-${_pad(_calM+1)}-${_pad(d)}`;
    const rems=_getRemsDate(ds);
    const isToday=ds===toStr;
    const isSel=ds===_selDay;
    const cell=document.createElement('div');
    cell.className='cal-cell-v2'+(isToday?' cal-today-v2':'')+(rems.length>0?' has-reminders':'')+(isSel?' selected-day':'');
    cell.setAttribute('data-date',ds);
    cell.onclick=(e)=>{if(!e.target.classList.contains('cal-add-btn')&&!e.target.closest('.cal-add-btn'))_selectDay(d);};

    const dayNumHTML=isToday
      ?`<div class="cal-day-num" style="display:flex;align-items:center;gap:4px;margin-bottom:5px"><span class="today-badge">${d}</span></div>`
      :`<div class="cal-day-num">${d}</div>`;

    const visible=rems.slice(0,3);
    const overflow=rems.length-3;
    let chipsHTML=visible.map(r=>{
      const cat=CAL_CATS[r.category]||{color:'#94a3b8',bg:'rgba(148,163,184,.15)'};
      return `<div class="cal-chip" style="background:${cat.bg};color:${cat.color}" title="${r.title}">
        <div class="cal-chip-dot" style="background:${cat.color}"></div>
        ${r.title.substring(0,13)}${r.title.length>13?'…':''}
      </div>`;
    }).join('');
    if(overflow>0) chipsHTML+=`<div class="cal-more-pill">+${overflow} more</div>`;

    const addBtn=`<div class="cal-add-btn" onclick="event.stopPropagation();openQuickCreate('${ds}')" title="Add reminder"><i class="ri-add-line"></i></div>`;
    cell.innerHTML=dayNumHTML+chipsHTML+addBtn;
    grid.appendChild(cell);
  }

  // Next filler
  const totalCells=first+days;
  const remaining=totalCells%7===0?0:7-(totalCells%7);
  for(let i=1;i<=remaining;i++){
    const cell=document.createElement('div');
    cell.className='cal-cell-v2 cal-other-month';
    cell.innerHTML=`<div class="cal-day-num">${i}</div>`;
    grid.appendChild(cell);
  }
}

// ── Select day
function _selectDay(d){
  if(!_selUserId){toast('Please select a user first','error');return;}
  const ds=`${_calY}-${_pad(_calM+1)}-${_pad(d)}`;
  _selDay=ds;window._selDay=ds;

  // Highlight
  document.querySelectorAll('.cal-cell-v2').forEach(c=>c.classList.remove('selected-day'));
  const target=document.querySelector(`[data-date="${ds}"]`);
  if(target) target.classList.add('selected-day');

  // Panel title
  const dateObj=new Date(_calY,_calM,d);
  const dayName=dateObj.toLocaleDateString('en-GB',{weekday:'long'});
  document.getElementById('sel-day-title-v2').textContent=`${dayName}, ${d} ${CAL_MONTHS_SHORT[_calM]}`;
  document.getElementById('sel-day-add-btn').style.display='flex';

  // Get all rems for this day (unfiltered)
  const rems=getRems().filter(r=>r.dueDate===ds);
  const ev=document.getElementById('sel-day-events-v2');

  if(rems.length===0){
    ev.innerHTML=`<div style="text-align:center;padding:28px 0">
      <i class="ri-calendar-check-line" style="font-size:1.8rem;color:rgba(124,58,237,.25);display:block;margin-bottom:8px"></i>
      <p style="font-size:.79rem;color:#64748b;margin-bottom:12px">No reminders on this day</p>
      <button class="btn btn-primary btn-xs" onclick="openQuickCreate('${ds}')"><i class="ri-add-line"></i> Add Reminder</button>
    </div>`;
    return;
  }

  ev.innerHTML=rems.map(r=>{
    const cat=CAL_CATS[r.category]||{color:'#94a3b8',bg:'rgba(148,163,184,.12)',icon:'ri-alarm-line',name:'Other'};
    const dl=daysUntil(r.dueDate);
    let pill='';
    if(r.status==='completed') pill=`<span class="pill-done">Done</span>`;
    else if(dl<0) pill=`<span class="pill-urgent">Overdue</span>`;
    else if(dl===0) pill=`<span class="pill-urgent">Today</span>`;
    else if(dl<=7) pill=`<span class="pill-soon">In ${dl}d</span>`;
    else pill=`<span class="pill-ok">In ${dl}d</span>`;

    return `<div class="day-ev-card">
      <div style="display:flex;align-items:flex-start;gap:8px">
        <div style="width:28px;height:28px;border-radius:7px;background:${cat.bg};display:flex;align-items:center;justify-content:center;flex-shrink:0">
          <i class="${cat.icon}" style="color:${cat.color};font-size:.8rem"></i>
        </div>
        <div style="flex:1;min-width:0">
          <div style="font-size:.83rem;font-weight:600;color:#f1f5f9;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${r.title}</div>
          <div style="font-size:.7rem;color:#64748b;margin-top:1px">${cat.name}${r.dueTime?' · '+r.dueTime:''}</div>
        </div>
        ${pill}
      </div>
      ${r.provider?`<div style="font-size:.72rem;color:#64748b;margin-top:6px;display:flex;align-items:center;gap:4px"><i class="ri-building-line"></i>${r.provider}${r.cost?' · ₹'+r.cost:''}</div>`:''}
      <div style="display:flex;gap:5px;margin-top:8px">
        ${r.status==='active'?`<button class="btn btn-teal btn-xs" onclick="markDone('${r.id}');_selectDay(${d});_renderGrid();_renderStats();_renderMonthEvents()"><i class="ri-check-line"></i> Mark Done</button>`:''}
        <button class="btn btn-ghost btn-xs" style="padding:4px 8px!important;font-size:.7rem;color:#f43f5e;border-color:rgba(244,63,94,.3)" onclick="deleteRem('${r.id}');_selectDay(${d})"><i class="ri-delete-bin-line"></i></button>
      </div>
    </div>`;
  }).join('');
}

function deleteRem(id){
  const rems=getRems().filter(r=>r.id!==id);
  saveRems(rems);
  _renderGrid();_renderStats();_renderMonthEvents();
  toast('Reminder removed','success');
}

// ── Month events
function _renderMonthEvents(){
  const rems=_getRems(_calY,_calM).sort((a,b)=>new Date(a.dueDate)-new Date(b.dueDate));
  document.getElementById('month-ev-cnt-v2').textContent=rems.length;
  const list=document.getElementById('month-events-v2');
  if(!_selUserId){
    list.innerHTML=`<div style="text-align:center;padding:20px;color:#64748b;font-size:.78rem"><i class="ri-user-line" style="display:block;font-size:1.4rem;opacity:.3;margin-bottom:6px"></i>Select a user first</div>`;
    return;
  }
  if(rems.length===0){
    list.innerHTML=`<div style="text-align:center;padding:24px;color:#64748b;font-size:.79rem">No reminders this month</div>`;
    return;
  }
  list.innerHTML=rems.map(r=>{
    const cat=CAL_CATS[r.category]||{color:'#94a3b8',bg:'rgba(148,163,184,.12)',icon:'ri-alarm-line',name:'Other'};
    const n=daysUntil(r.dueDate);
    const dp=r.status==='completed'?`<span class="pill-done" style="font-size:.58rem">Done</span>`:
      n<0?`<span class="pill-urgent" style="font-size:.58rem">Overdue</span>`:
      n<=7?`<span class="pill-soon" style="font-size:.58rem">In ${n}d</span>`:
      `<span class="pill-ok" style="font-size:.58rem">In ${n}d</span>`;
    const dn=parseInt(r.dueDate.split('-')[2]);
    return `<div class="month-ev-item" onclick="_selectDay(${dn})">
      <div style="width:7px;height:7px;border-radius:50%;background:${cat.color};flex-shrink:0"></div>
      <div style="flex:1;min-width:0">
        <div style="font-size:.78rem;font-weight:600;color:#94a3b8;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${r.title}</div>
        <div style="font-size:.67rem;color:#64748b">${fmtDate(r.dueDate)} · ${cat.name}</div>
      </div>
      ${dp}
    </div>`;
  }).join('');
}

// ── Stats
function _renderStats(){
  const allRems=getRems().filter(r=>{
    const d=new Date(r.dueDate);
    return d.getFullYear()===_calY&&d.getMonth()===_calM;
  });
  const filtered=_calCatFilter==='all'?allRems:allRems.filter(r=>r.category===_calCatFilter);
  const active=filtered.filter(r=>r.status==='active');
  const done=filtered.filter(r=>r.status==='completed');
  const overdue=active.filter(r=>daysUntil(r.dueDate)<0);
  const upcoming=active.filter(r=>{const n=daysUntil(r.dueDate);return n>=0&&n<=7;});
  const stats=[
    {num:filtered.length,lbl:'Total',    color:'#a78bfa'},
    {num:active.length,  lbl:'Active',   color:'#14b8a6'},
    {num:upcoming.length,lbl:'This Week',color:'#f59e0b'},
    {num:overdue.length, lbl:'Overdue',  color:'#f43f5e'},
    {num:done.length,    lbl:'Done',     color:'#10b981'},
  ];
  document.getElementById('cal-stats-row').innerHTML=stats.map(s=>`
    <div class="cal-stat">
      <div class="cal-stat-num" style="color:${s.color}">${s.num}</div>
      <div class="cal-stat-lbl">${s.lbl}</div>
    </div>`).join('');
}

// ── Export
function calExport(){
  if(!_selUserId){toast('Select a user first','error');return;}
  const u=SAMPLE_USERS.find(u=>u.id===_selUserId);
  toast(`Exported ${u.name}'s ${CAL_MONTHS[_calM]} ${_calY} calendar`,'success');
}

// ═══════════════════════════════════════════════════════
// QUICK CREATE
// ═══════════════════════════════════════════════════════

function openQuickCreate(dateStr){
  if(!_selUserId){toast('Please select a user first','error');return;}
  const catSel=document.getElementById('qc-cat');
  catSel.innerHTML='<option value="">Select…</option>';
  Object.entries(CAL_CATS).forEach(([k,c])=>{catSel.innerHTML+=`<option value="${k}">${c.name}</option>`;});
  document.getElementById('qc-sub').innerHTML='<option value="">Select category…</option>';
  document.getElementById('qc-sub').disabled=true;
  const ds=dateStr||(()=>{const t=new Date();return `${t.getFullYear()}-${_pad(t.getMonth()+1)}-${_pad(t.getDate())}`})();
  document.getElementById('qc-date').value=ds;
  document.getElementById('qc-time').value='09:00';
  document.getElementById('qc-title').value='';
  document.getElementById('qc-desc').value='';
  if(ds){const[y,m,d]=ds.split('-');document.getElementById('qc-date-label').textContent=`${parseInt(d)} ${CAL_MONTHS[parseInt(m)-1]} ${y}`;}
  document.getElementById('qc-overlay').classList.add('open');
  document.body.style.overflow='hidden';
  setTimeout(()=>document.getElementById('qc-title').focus(),300);
}

function closeQuickCreate(){
  document.getElementById('qc-overlay').classList.remove('open');
  document.body.style.overflow='';
}

function qcUpdateSubs(){
  const cat=document.getElementById('qc-cat').value;
  const sub=document.getElementById('qc-sub');
  sub.innerHTML='<option value="">Select subcategory…</option>';
  const subs=CAL_SUBS[cat];
  if(cat&&subs){subs.forEach(s=>{sub.innerHTML+=`<option value="${s}">${s}</option>`;});sub.disabled=false;}
  else sub.disabled=true;
}

function qcSubmit(e){
  e.preventDefault();
  const title=document.getElementById('qc-title').value.trim();
  const cat=document.getElementById('qc-cat').value;
  const sub=document.getElementById('qc-sub').value;
  const date=document.getElementById('qc-date').value;
  const time=document.getElementById('qc-time').value;
  const desc=document.getElementById('qc-desc').value.trim();
  if(title.length<3){toast('Title must be at least 3 characters','error');return;}
  if(!cat){toast('Please select a category','error');return;}
  if(!sub){toast('Please select a subcategory','error');return;}
  if(!date){toast('Please select a date','error');return;}
  const rems=getRems();
  rems.push({
    id:'r_'+Date.now()+'_'+Math.random().toString(36).substr(2,6),
    title,category:cat,subcategory:sub,
    dueDate:date,dueTime:time,
    description:desc,status:'active',
    createdAt:new Date().toISOString()
  });
  saveRems(rems);
  toast('Reminder created! 🎉','success');
  closeQuickCreate();
  _renderAll();
  if(_selDay){const dn=parseInt(_selDay.split('-')[2]);setTimeout(()=>_selectDay(dn),100);}
}

// ── Boot
if(document.readyState==='loading'){
  document.addEventListener('DOMContentLoaded',initCalendarV2);
} else {
  setTimeout(initCalendarV2,80);
}
</script>
@endsection