@extends('user.layouts.app')
@section('content')

<style>
    /* ═══════════════════════════════════════════
    CALENDAR PAGE — ADVANCED STYLES
    ═══════════════════════════════════════════ */


    /* Jump controls */
    .cal-jump-select {
        background: rgba(255, 255, 255, .05);
        border: 1px solid rgba(255, 255, 255, .1);
        color: #e2e8f0;
        border-radius: 9px;
        padding: 7px 30px 7px 12px;
        font-size: .82rem;
        font-weight: 600;
        font-family: 'Plus Jakarta Sans', sans-serif;
        cursor: pointer;
        outline: none;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='%237c3aed'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 9px center;
        transition: border-color .2s;
    }

    .light .cal-jump-select {
        background-color: #fff;
        border: 1px solid #e2e8f0;
        color: #1e1b4b;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='%237c3aed'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
    }

    .light .export-btn {
        color: #656565 !important;
    }

    .dark .cal-jump-select option {
        background: #0c0c1e;
    }

    .cal-jump-select:focus {
        border-color: #7c3aed;
    }

    /* Calendar grid cells */
    .cal-cell-v2 {
        background: rgba(18, 18, 45, .5);
        border: 1px solid rgba(255, 255, 255, .05);
        border-radius: 10px;
        padding: 8px;
        min-height: 88px;
        cursor: pointer;
        transition: all .2s;
        display: flex;
        flex-direction: column;
        position: relative;
        overflow: hidden;
    }

    .light .cal-cell-v2 {
        background: #f8f7ff;
        border: 1px solid rgba(99, 102, 241, .08);
    }

    .cal-cell-v2:hover {
        border-color: rgba(124, 58, 237, .4);
        background: rgba(124, 58, 237, .08);
    }

    .light .cal-cell-v2:hover {
        border-color: rgba(124, 58, 237, .25);
        background: rgba(124, 58, 237, .05);
    }

    .cal-cell-v2.cal-today-v2 {
        background: linear-gradient(135deg, rgba(124, 58, 237, .25), rgba(13, 148, 136, .15));
        border-color: rgba(124, 58, 237, .55) !important;
    }

    .cal-cell-v2.cal-other-month {
        opacity: .35;
        pointer-events: none;
    }

    .cal-cell-v2.has-reminders {
        border-color: rgba(124, 58, 237, .2);
    }

    /* Day number */
    .cal-day-num {
        font-size: .72rem;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 4px;
        line-height: 1;
    }

    .cal-today-v2 .cal-day-num {
        color: #a78bfa;
    }

    .light .cal-day-num {
        color: #64748b;
    }

    .light .cal-today-v2 .cal-day-num {
        color: #7c3aed;
    }

    /* Today badge */
    .today-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: linear-gradient(135deg, #7c3aed, #0d9488);
        color: #fff;
        font-size: .65rem;
        font-weight: 800;
        flex-shrink: 0;
    }

    /* Event chips on calendar */
    .cal-chip {
        display: flex;
        align-items: center;
        gap: 3px;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: .58rem;
        font-weight: 700;
        margin-bottom: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
        cursor: pointer;
        transition: opacity .15s;
    }

    .cal-chip:hover {
        opacity: .8;
    }

    .cal-chip-dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    /* Plus button on empty cell hover */
    .cal-add-btn {
        position: absolute;
        bottom: 6px;
        right: 6px;
        width: 22px;
        height: 22px;
        border-radius: 6px;
        background: rgba(124, 58, 237, .25);
        border: 1px solid rgba(124, 58, 237, .4);
        color: #a78bfa;
        display: none;
        align-items: center;
        justify-content: center;
        font-size: .75rem;
        cursor: pointer;
        transition: all .2s;
        z-index: 2;
    }

    .cal-cell-v2:hover .cal-add-btn {
        display: flex;
    }

    .cal-add-btn:hover {
        background: rgba(124, 58, 237, .5);
        transform: scale(1.1);
    }

    .light .cal-add-btn {
        background: rgba(124, 58, 237, .12);
        border-color: rgba(124, 58, 237, .3);
        color: #7c3aed;
    }

    /* More pill */
    .cal-more-pill {
        font-size: .57rem;
        color: #a78bfa;
        font-weight: 700;
        padding: 1px 5px;
        border-radius: 4px;
        background: rgba(124, 58, 237, .12);
        border: 1px solid rgba(124, 58, 237, .2);
        cursor: pointer;
        white-space: nowrap;
        margin-top: 1px;
    }

    .light .cal-more-pill {
        color: #7c3aed;
    }

    /* Day detail panel */
    .day-panel {
        background: rgba(12, 12, 30, .85);
        border: 1px solid rgba(255, 255, 255, .07);
        border-radius: 16px;
        padding: 18px;
        height: 100%;
    }

    .light .day-panel {
        background: #fff;
        border: 1px solid rgba(99, 102, 241, .1);
    }

    /* Month events list */
    .month-ev-item {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 9px 10px;
        border-radius: 10px;
        cursor: pointer;
        transition: all .18s;
        background: rgba(255, 255, 255, .02);
        border: 1px solid rgba(255, 255, 255, .04);
        margin-bottom: 5px;
    }

    .light .month-ev-item {
        background: #f8f7ff;
        border: 1px solid rgba(99, 102, 241, .08);
    }

    .month-ev-item:hover {
        border-color: rgba(124, 58, 237, .3);
        background: rgba(124, 58, 237, .06);
        transform: translateX(3px);
    }

    /* Category legend */
    .cat-legend-item {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 5px 10px;
        border-radius: 8px;
        font-size: .72rem;
        font-weight: 600;
        cursor: pointer;
        transition: all .15s;
        white-space: nowrap;
        border: 1px solid transparent;
        color: #64748b;
    }

    .light .cat-legend-item {
        color: #475569;
    }

    .cat-legend-item:hover {
        background: rgba(124, 58, 237, .07);
    }

    .cat-legend-item.active {
        background: rgba(124, 58, 237, .1);
        border-color: rgba(124, 58, 237, .25);
        color: #a78bfa;
    }

    .light .cat-legend-item.active {
        color: #7c3aed;
    }

    .cat-legend-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    /* Mini create popup overlay */
    .quick-create-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .6);
        backdrop-filter: blur(6px);
        z-index: 9998;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        opacity: 0;
        pointer-events: none;
        transition: opacity .25s;
    }

    .quick-create-overlay.open {
        opacity: 1;
        pointer-events: all;
    }

    .quick-create-box {
        background: #0c0c1e;
        border: 1px solid rgba(124, 58, 237, .3);
        border-radius: 20px;
        padding: 28px;
        width: 100%;
        max-width: 480px;
        max-height: 90vh;
        overflow-y: auto;
        transform: translateY(24px) scale(.97);
        transition: transform .3s cubic-bezier(.16, 1, .3, 1);
        box-shadow: 0 32px 64px rgba(0, 0, 0, .5), 0 0 0 1px rgba(124, 58, 237, .15);
    }

    .light .quick-create-box {
        background: #fff;
        border-color: rgba(124, 58, 237, .2);
        box-shadow: 0 32px 64px rgba(0, 0, 0, .15);
    }

    .quick-create-overlay.open .quick-create-box {
        transform: translateY(0) scale(1);
    }

    /* Day panel event card */
    .day-ev-card {
        padding: 12px;
        border-radius: 10px;
        background: rgba(255, 255, 255, .03);
        border: 1px solid rgba(255, 255, 255, .06);
        margin-bottom: 8px;
        transition: border-color .2s;
    }

    .light .day-ev-card {
        background: #f8f7ff;
        border: 1px solid rgba(99, 102, 241, .09);
    }

    .day-ev-card:hover {
        border-color: rgba(124, 58, 237, .3);
    }

    /* Stats bar */
    .cal-stat {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 10px 16px;
        border-radius: 10px;
        background: rgba(255, 255, 255, .03);
        border: 1px solid rgba(255, 255, 255, .06);
        flex: 1;
        min-width: 0;
    }

    .light .cal-stat {
        background: #fff;
        border: 1px solid rgba(99, 102, 241, .09);
    }

    .cal-stat-num {
        font-size: 1.3rem;
        font-weight: 800;
        font-family: 'Plus Jakarta Sans', sans-serif;
        line-height: 1;
        margin-bottom: 3px;
    }

    .cal-stat-lbl {
        font-size: .67rem;
        color: #64748b;
        font-weight: 600;
        text-align: center;
        white-space: nowrap;
    }

    /* Category filter bar scrollable */
    .cat-filter-bar {
        display: flex;
        gap: 6px;
        overflow-x: auto;
        padding-bottom: 2px;
        scrollbar-width: none;
    }

    .cat-filter-bar::-webkit-scrollbar {
        display: none;
    }

    /* Responsive */
    @media (max-width: 900px) {
        .cal-layout {
            grid-template-columns: 1fr !important;
        }

        .cal-side {
            display: none;
        }
    }

    @media (max-width: 640px) {
        .cal-cell-v2 {
            min-height: 56px;
            padding: 5px;
        }

        .cal-chip {
            display: none;
        }

        .cal-has-dot {
            display: block !important;
        }
    }
</style>

<section id="page-calendar">

    <!-- ── TOP CONTROLS ── -->
    <div class="card" style="padding:14px 16px;margin-bottom:14px">
        <div style="display:flex;flex-wrap:wrap;align-items:center;gap:10px">

            <!-- Nav arrows -->
            <div style="display:flex;gap:6px;align-items:center">
                <button class="btn btn-ghost btn-xs" id="cal-prev" onclick="calPrev()" style="padding:7px 10px !important"><i class="ri-arrow-left-s-line" style="font-size:1rem"></i></button>
                <button class="btn btn-ghost btn-xs" id="cal-today-btn" onclick="calGoToday()" style="padding:6px 12px !important;font-size:.75rem">Today</button>
                <button class="btn btn-ghost btn-xs" id="cal-next" onclick="calNext()" style="padding:7px 10px !important"><i class="ri-arrow-right-s-line" style="font-size:1rem"></i></button>
            </div>

            <!-- Month + Year jump -->
            <div style="display:flex;gap:6px;align-items:center">
                <select class="cal-jump-select" id="cal-month-sel" onchange="calJump()"></select>
                <select class="cal-jump-select" id="cal-year-sel" onchange="calJump()"></select>
            </div>

            <!-- Current label -->
            <div id="cal-label-v2" class="font-jakarta" style="font-weight:800;font-size:1rem;color:#f1f5f9;flex:1;text-align:center;min-width:120px"></div>

            <!-- Right side actions -->
            <div style="display:flex;gap:6px;align-items:center;margin-left:auto">
                <button class="hidden btn btn-ghost text-dark btn-xs" onclick="calExport()" style="padding:6px 12px !important;font-size:.75rem"><i class="ri-download-2-line"></i>
                    <div class="mobile-hide-xs export-btn">Export</div>
                </button>
                <button class="btn btn-primary btn-xs" onclick="openReminderModal()" style="padding:6px 12px !important;font-size:.75rem"><i class="ri-add-line"></i> <span class="mobile-hide-xs">Add Reminder</span></button>
            </div>
        </div>
    </div>

    <!-- ── STATS ROW ── -->
    <div style="display:flex;gap:10px;margin-bottom:14px;overflow-x:auto" id="cal-stats-row"></div>

    <!-- ── CATEGORY FILTER ── -->
    <div class="card" style="padding:12px 14px;margin-bottom:14px">
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap">
            <span style="font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;flex-shrink:0">Filter:</span>
            <div class="cat-filter-bar" id="cat-filter-bar">
                <button class="cat-legend-item active" data-cat="all" onclick="calSetCatFilter('all',this)">
                    <div class="cat-legend-dot" style="background:linear-gradient(135deg,#7c3aed,#0d9488)"></div> All
                </button>
            </div>
        </div>
    </div>

    <!-- ── MAIN GRID ── -->
    <div class="cal-layout" style="display:grid;grid-template-columns:1fr 300px;gap:14px;align-items:start">

        <!-- Calendar -->
        <div>
            <div class="card" style="padding:14px">
                <!-- Day headers -->
                <div style="display:grid;grid-template-columns:repeat(7,1fr);gap:4px;margin-bottom:6px" id="cal-day-headers">
                    <div style="text-align:center;font-size:.6rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;padding:5px 0">Sun</div>
                    <div style="text-align:center;font-size:.6rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;padding:5px 0">Mon</div>
                    <div style="text-align:center;font-size:.6rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;padding:5px 0">Tue</div>
                    <div style="text-align:center;font-size:.6rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;padding:5px 0">Wed</div>
                    <div style="text-align:center;font-size:.6rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;padding:5px 0">Thu</div>
                    <div style="text-align:center;font-size:.6rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;padding:5px 0">Fri</div>
                    <div style="text-align:center;font-size:.6rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;padding:5px 0">Sat</div>
                </div>
                <!-- Calendar cells -->
                <div id="cal-grid-v2" style="display:grid;grid-template-columns:repeat(7,1fr);gap:4px"></div>
            </div>
        </div>

        <!-- Side panel -->
        <div class="cal-side" style="display:flex;flex-direction:column;gap:12px">

            <!-- Selected day -->
            <div class="day-panel">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
                    <h3 class="font-jakarta" id="sel-day-title-v2" style="font-weight:700;font-size:.87rem;color:#f1f5f9">Select a day</h3>
                    <button class="btn btn-primary btn-xs" id="sel-day-add-btn" style="display:none;padding:5px 10px !important;font-size:.72rem" onclick="openReminderModal()"><i class="ri-add-line"></i></button>
                </div>
                <div id="sel-day-events-v2">
                    <div style="text-align:center;padding:32px 0;color:#64748b">
                        <i class="ri-calendar-line" style="font-size:1.8rem;display:block;margin-bottom:8px;opacity:.3"></i>
                        <p style="font-size:.8rem">Click a day to view reminders</p>
                    </div>
                </div>
            </div>

            <!-- Month events list -->
            <div class="day-panel">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
                    <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9">This Month</h3>
                    <span class="badge badge-purple" id="month-ev-cnt-v2">0</span>
                </div>
                <div id="month-events-v2" style="max-height:340px;overflow-y:auto"></div>
            </div>

        </div>
    </div>

</section>

<!-- ═══════════════════════════════════════
     QUICK CREATE POPUP
═══════════════════════════════════════ -->
<div class="quick-create-overlay" id="qc-overlay" onclick="if(event.target===this)closeQuickCreate()">
    <div class="quick-create-box">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px">
            <div>
                <h2 class="font-jakarta" style="font-size:1.1rem;font-weight:800;color:#f1f5f9">Quick Add Reminder</h2>
                <p id="qc-date-label" style="font-size:.78rem;color:#64748b;margin-top:2px"></p>
            </div>
            <button onclick="closeQuickCreate()" style="background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);color:#94a3b8;width:30px;height:30px;border-radius:7px;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:.9rem;transition:all .2s;flex-shrink:0"><i class="ri-close-line"></i></button>
        </div>

        <form id="qc-form" onsubmit="qcSubmit(event)">
            <div style="margin-bottom:14px">
                <label style="display:block;font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:6px">Title <span style="color:#f43f5e">*</span></label>
                <input class="inp" id="qc-title" placeholder="e.g. Car Insurance Renewal" maxlength="100" autocomplete="off">
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px">
                <div>
                    <label style="display:block;font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:6px">Category <span style="color:#f43f5e">*</span></label>
                    <select class="inp" id="qc-cat" onchange="qcUpdateSubs()" style="font-size:.82rem">
                        <option value="">Select…</option>
                    </select>
                </div>
                <div>
                    <label style="display:block;font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:6px">Subcategory <span style="color:#f43f5e">*</span></label>
                    <select class="inp" id="qc-sub" disabled style="font-size:.82rem">
                        <option value="">Select category…</option>
                    </select>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px">
                <div>
                    <label style="display:block;font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:6px">Date <span style="color:#f43f5e">*</span></label>
                    <input class="inp" type="date" id="qc-date" style="font-size:.82rem">
                </div>
                <div>
                    <label style="display:block;font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:6px">Time</label>
                    <input class="inp" type="time" id="qc-time" value="09:00" style="font-size:.82rem">
                </div>
            </div>
            <div style="margin-bottom:18px">
                <label style="display:block;font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:7px">
                    Reminder Type <span style="color:#f43f5e">*</span>
                </label>

                <select class="inp" id="r-type">
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly" selected>Monthly</option>
                    <option value="yearly">Yearly</option>
                    <option value="custom">Custom</option>
                </select>

                <!-- Custom input -->
                <input class="inp" type="text" id="r-custom"
                    placeholder="Enter custom schedule (e.g., every 2 days)"
                    style="display:none;margin-top:8px">
            </div>
            <div style="margin-bottom:18px">
                <label style="display:block;font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:6px">Notes <span style="font-weight:400;text-transform:none">(optional)</span></label>
                <textarea class="inp" id="qc-desc" rows="2" maxlength="200" placeholder="Brief notes…" style="resize:none;font-size:.82rem"></textarea>
            </div>
            <div style="display:flex;gap:8px;justify-content:flex-end">
                <button type="button" class="btn btn-ghost btn-xs" onclick="closeQuickCreate()" style="padding:9px 16px !important;font-size:.82rem">Cancel</button>
                <button type="submit" class="btn btn-primary btn-xs" style="padding:9px 16px !important;font-size:.82rem"><i class="ri-check-line"></i> Create Reminder</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Dynamic categories from DB — replaces hardcoded CAL_CATS
    window.CALENDAR_CATS     = @json($categories);

    // Reminder history data for calendar
    window.CALENDAR_HISTORIES = @json($histories);
</script>

<!-- <script>
    const typeSelect = document.getElementById('r-type');
    const customInput = document.getElementById('r-custom');

    typeSelect.addEventListener('change', function() {
        if (this.value === 'custom') {
            customInput.style.display = 'block';
            customInput.focus();
        } else {
            customInput.style.display = 'none';
            customInput.value = '';
        }
    });
</script> -->
@endsection