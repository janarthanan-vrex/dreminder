@extends('user.layouts.app')
@section('content')

<style>
/* ═══════════════════════════════════════════
   ORDERS PAGE — CUSTOM DATATABLE STYLES
═══════════════════════════════════════════ */

/* ── DataTable Wrapper ── */
.dt-wrapper { position: relative; }

/* ── Toolbar ── */
.dt-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 14px;
}
.dt-toolbar-left, .dt-toolbar-right {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

/* ── Search box ── */
.dt-search-wrap {
    position: relative;
    display: flex;
    align-items: center;
}
.dt-search-wrap i {
    position: absolute;
    left: 11px;
    color: #475569;
    font-size: .85rem;
    pointer-events: none;
    z-index: 1;
}
.dt-search {
    background: rgba(255,255,255,.04);
    border: 1px solid rgba(255,255,255,.09);
    border-radius: 10px;
    padding: 8px 12px 8px 34px;
    color: #e2e8f0;
    font-size: .8rem;
    font-family: 'Plus Jakarta Sans', sans-serif;
    outline: none;
    width: 220px;
    transition: border-color .2s, width .3s;
}
.dt-search:focus { border-color: rgba(124,58,237,.5); width: 270px; }
.dt-search::placeholder { color: #475569; }
.light .dt-search { background: #fff; border-color: rgba(99,102,241,.15); color: #1e1b4b; }
.light .dt-search::placeholder { color: #94a3b8; }

/* ── Filter chips ── */
.dt-filter-chip {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: .73rem;
    font-weight: 700;
    cursor: pointer;
    border: 1px solid rgba(255,255,255,.08);
    background: rgba(255,255,255,.03);
    color: #64748b;
    transition: all .18s;
    white-space: nowrap;
}
.dt-filter-chip:hover { border-color: rgba(124,58,237,.3); color: #a78bfa; }
.dt-filter-chip.active { background: rgba(124,58,237,.15); border-color: rgba(124,58,237,.4); color: #a78bfa; }
.light .dt-filter-chip { background: #fff; border-color: #e2e8f0; color: #64748b; }
.light .dt-filter-chip.active { background: rgba(124,58,237,.1); border-color: rgba(124,58,237,.3); color: #7c3aed; }
.dt-filter-chip .chip-count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 18px;
    height: 18px;
    border-radius: 5px;
    background: rgba(124,58,237,.25);
    color: #a78bfa;
    font-size: .65rem;
    padding: 0 4px;
}
.dt-filter-chip.active .chip-count { background: rgba(124,58,237,.4); }

/* ── Action buttons row ── */
.dt-action-btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 7px 13px;
    border-radius: 9px;
    font-size: .75rem;
    font-weight: 700;
    cursor: pointer;
    border: 1px solid rgba(255,255,255,.09);
    background: rgba(255,255,255,.04);
    color: #94a3b8;
    transition: all .18s;
    font-family: 'Plus Jakarta Sans', sans-serif;
}
.dt-action-btn:hover { border-color: rgba(124,58,237,.35); color: #a78bfa; background: rgba(124,58,237,.08); }
.dt-action-btn.danger:hover { border-color: rgba(244,63,94,.35); color: #f43f5e; background: rgba(244,63,94,.07); }
.light .dt-action-btn { background: #fff; border-color: #e2e8f0; color: #475569; }

/* ── Column visibility dropdown ── */
.dt-col-drop {
    position: relative;
}
.dt-col-menu {
    position: absolute;
    top: calc(100% + 6px);
    right: 0;
    background: #0f0f27;
    border: 1px solid rgba(124,58,237,.25);
    border-radius: 12px;
    padding: 10px;
    min-width: 190px;
    z-index: 999;
    display: none;
    box-shadow: 0 20px 40px rgba(0,0,0,.5);
}
.light .dt-col-menu { background: #fff; border-color: rgba(99,102,241,.2); box-shadow: 0 12px 32px rgba(0,0,0,.12); }
.dt-col-menu.open { display: block; }
.dt-col-menu-item {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 7px 10px;
    border-radius: 7px;
    cursor: pointer;
    font-size: .78rem;
    color: #64748b;
    transition: all .15s;
    user-select: none;
}
.dt-col-menu-item:hover { background: rgba(124,58,237,.08); color: #a78bfa; }
.dt-col-menu-item input[type=checkbox] { accent-color: #7c3aed; width: 13px; height: 13px; cursor: pointer; }

/* ── Table ── */
.dt-table-wrap { overflow-x: auto; }
.dt-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: .82rem;
}

/* Head */
.dt-table thead tr th {
    padding: 10px 14px;
    font-size: .64rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: #475569;
    border-bottom: 1px solid rgba(255,255,255,.07);
    white-space: nowrap;
    background: transparent;
    cursor: pointer;
    user-select: none;
    transition: color .15s;
}
.dt-table thead tr th:hover { color: #a78bfa; }
.dt-table thead tr th.sorted-asc,
.dt-table thead tr th.sorted-desc { color: #a78bfa; }
.light .dt-table thead tr th { color: #94a3b8; border-color: rgba(99,102,241,.1); }
.light .dt-table thead tr th.sorted-asc,
.light .dt-table thead tr th.sorted-desc { color: #7c3aed; }

/* Sort icons */
.dt-sort-icon { display: inline-block; margin-left: 4px; opacity: .35; font-size: .65rem; transition: opacity .15s; vertical-align: middle; }
th:hover .dt-sort-icon, th.sorted-asc .dt-sort-icon, th.sorted-desc .dt-sort-icon { opacity: 1; }

/* Rows */
.dt-table tbody tr {
    transition: background .15s;
    cursor: default;
}
.dt-table tbody tr:hover { background: rgba(124,58,237,.06); }
.light .dt-table tbody tr:hover { background: rgba(99,102,241,.04); }
.dt-table tbody tr.dt-row-selected { background: rgba(124,58,237,.1) !important; }
.light .dt-table tbody tr.dt-row-selected { background: rgba(124,58,237,.07) !important; }

/* Cells */
.dt-table tbody td {
    padding: 11px 14px;
    border-bottom: 1px solid rgba(255,255,255,.04);
    color: #94a3b8;
    vertical-align: middle;
    white-space: nowrap;
}
.light .dt-table tbody td { border-color: rgba(99,102,241,.06); color: #475569; }

/* Checkbox col */
.dt-cb-col { width: 38px; text-align: center; }
.dt-cb-col input[type=checkbox] { accent-color: #7c3aed; width: 14px; height: 14px; cursor: pointer; }

/* ── Order ID cell ── */
.dt-order-id {
    font-family: 'DM Mono', monospace;
    font-size: .75rem;
    color: #7c3aed;
    font-weight: 600;
    letter-spacing: .03em;
}
.light .dt-order-id { color: #6d28d9; }

/* ── Customer cell ── */
.dt-customer {
    display: flex;
    align-items: center;
    gap: 9px;
}
.dt-avatar {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .65rem;
    font-weight: 800;
    flex-shrink: 0;
    font-family: 'Plus Jakarta Sans', sans-serif;
}
.dt-customer-info { line-height: 1.3; }
.dt-customer-name { font-size: .82rem; font-weight: 600; color: #e2e8f0; }
.light .dt-customer-name { color: #1e1b4b; }
.dt-customer-email { font-size: .7rem; color: #475569; }

/* ── Items cell ── */
.dt-items-wrap { display: flex; align-items: center; gap: 5px; flex-wrap: wrap; }
.dt-item-tag {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    padding: 2px 7px;
    border-radius: 5px;
    font-size: .67rem;
    font-weight: 600;
    background: rgba(255,255,255,.05);
    border: 1px solid rgba(255,255,255,.08);
    color: #94a3b8;
    white-space: nowrap;
}
.light .dt-item-tag { background: #f1f5f9; border-color: #e2e8f0; color: #475569; }

/* ── Amount cell ── */
.dt-amount { font-weight: 800; font-family: 'Plus Jakarta Sans', sans-serif; color: #f1f5f9; }
.light .dt-amount { color: #1e1b4b; }
.dt-amount-sub { font-size: .7rem; color: #475569; font-weight: 400; margin-top: 1px; }

/* ── Status badges ── */
.dt-status {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: .7rem;
    font-weight: 700;
    letter-spacing: .03em;
    white-space: nowrap;
}
.dt-status-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
.dt-status.pending    { background: rgba(245,158,11,.12);  color: #f59e0b;  border: 1px solid rgba(245,158,11,.25); }
.dt-status.completed  { background: rgba(16,185,129,.1);   color: #10b981;  border: 1px solid rgba(16,185,129,.2); }
.dt-status-dot.pending    { background: #f59e0b; box-shadow: 0 0 6px rgba(245,158,11,.6); }

/* ── Action cell ── */
.dt-row-actions { display: flex; align-items: center; gap: 5px; }
.dt-row-btn {
    width: 28px;
    height: 28px;
    border-radius: 7px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .8rem;
    cursor: pointer;
    border: 1px solid rgba(255,255,255,.07);
    background: rgba(255,255,255,.03);
    color: #64748b;
    transition: all .15s;
}
.dt-row-btn:hover { border-color: rgba(124,58,237,.35); color: #a78bfa; background: rgba(124,58,237,.08); }
.dt-row-btn.danger:hover { border-color: rgba(244,63,94,.3); color: #f43f5e; background: rgba(244,63,94,.06); }
.dt-row-btn.success:hover { border-color: rgba(16,185,129,.3); color: #10b981; background: rgba(16,185,129,.06); }
.light .dt-row-btn { background: #fff; border-color: #e2e8f0; color: #64748b; }

/* ── Pagination ── */
.dt-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 16px;
}
.dt-info { font-size: .75rem; color: #475569; }
.dt-info strong { color: #94a3b8; }
.light .dt-info strong { color: #475569; }
.dt-pagination { display: flex; align-items: center; gap: 4px; }
.dt-page-btn {
    min-width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .78rem;
    font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    cursor: pointer;
    border: 1px solid rgba(255,255,255,.07);
    background: rgba(255,255,255,.03);
    color: #64748b;
    transition: all .15s;
    padding: 0 8px;
}
.dt-page-btn:hover { border-color: rgba(124,58,237,.35); color: #a78bfa; background: rgba(124,58,237,.08); }
.dt-page-btn.active { background: linear-gradient(135deg,#7c3aed,#0d9488); color: #fff; border-color: transparent; box-shadow: 0 4px 12px rgba(124,58,237,.35); }
.dt-page-btn:disabled { opacity: .3; cursor: not-allowed; pointer-events: none; }
.light .dt-page-btn { background: #fff; border-color: #e2e8f0; color: #64748b; }
.light .dt-page-btn.active { color: #ffffff; border-color: transparent; background: #7352a8; }

/* ── Rows per page ── */
.dt-per-page {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: .75rem;
    color: #475569;
}
.dt-per-page select {
    background: rgba(255,255,255,.04);
    border: 1px solid rgba(255,255,255,.09);
    border-radius: 8px;
    color: #94a3b8;
    padding: 5px 26px 5px 9px;
    font-size: .75rem;
    font-family: 'Plus Jakarta Sans', sans-serif;
    outline: none;
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='%237c3aed'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 7px center;
}
.light .dt-per-page select { background-color: #fff; border-color: #e2e8f0; color: #475569; }

/* ── Empty state ── */
.dt-empty {
    text-align: center;
    padding: 52px 20px;
    color: #475569;
}
.dt-empty i { font-size: 2.5rem; display: block; margin-bottom: 10px; opacity: .25; }
.dt-empty p { font-size: .84rem; }

/* ── Loading skeleton ── */
.dt-skeleton { animation: dt-pulse 1.4s ease-in-out infinite; }
@keyframes dt-pulse { 0%,100%{opacity:.4} 50%{opacity:.8} }
.dt-skel-row { height: 14px; border-radius: 6px; background: rgba(255,255,255,.06); }
.light .dt-skel-row { background: #e2e8f0; }

/* ── Bulk action bar ── */
.dt-bulk-bar {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 14px;
    background: linear-gradient(135deg,rgba(124,58,237,.15),rgba(13,148,136,.1));
    border: 1px solid rgba(124,58,237,.3);
    border-radius: 10px;
    margin-bottom: 10px;
    flex-wrap: wrap;
}
.dt-bulk-count { font-size: .8rem; font-weight: 700; color: #a78bfa; }
.light .dt-bulk-count { color: #7c3aed; }

/* ── Progress bar for payment ── */
.dt-prog-mini { height: 4px; border-radius: 4px; background: rgba(255,255,255,.07); overflow: hidden; margin-top: 4px; min-width: 80px; }
.light .dt-prog-mini { background: #e2e8f0; }
.dt-prog-fill { height: 100%; border-radius: 4px; transition: width .6s; }

/* ── Order detail drawer ── */
.order-drawer-overlay {
    position: fixed; inset: 0;
    background: rgba(0,0,0,.65);
    backdrop-filter: blur(5px);
    z-index: 9997;
    opacity: 0; pointer-events: none;
    transition: opacity .25s;
}
.order-drawer-overlay.open { opacity: 1; pointer-events: all; }
.order-drawer {
    position: fixed;
    top: 0; right: 0;
    width: min(480px, 100vw);
    height: 100vh;
    background: #0c0c1e;
    border-left: 1px solid rgba(124,58,237,.2);
    z-index: 9998;
    transform: translateX(100%);
    transition: transform .32s cubic-bezier(.16,1,.3,1);
    overflow-y: auto;
    padding: 28px;
    box-shadow: -20px 0 60px rgba(0,0,0,.5);
}
.light .order-drawer { background: #fff; border-color: rgba(99,102,241,.15); }
.order-drawer.open { transform: translateX(0); }
.drawer-section { margin-bottom: 22px; }
.drawer-section-title {
    font-size: .65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .1em;
    color: #475569;
    margin-bottom: 10px;
    padding-bottom: 8px;
    border-bottom: 1px solid rgba(255,255,255,.06);
}
.light .drawer-section-title { border-color: rgba(99,102,241,.08); }
.drawer-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 7px 0;
    font-size: .83rem;
}
.drawer-row-label { color: #64748b; }
.drawer-row-val { color: #e2e8f0; font-weight: 600; text-align: right; }
.light .drawer-row-val { color: #1e1b4b; }
.drawer-timeline { display: flex; flex-direction: column; gap: 0; }
.tl-step { display: flex; gap: 12px; position: relative; }
.tl-step:not(:last-child) .tl-line { flex-shrink: 0; }
.tl-dot-col { display: flex; flex-direction: column; align-items: center; width: 28px; }
.tl-dot {
    width: 28px; height: 28px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .75rem;
    flex-shrink: 0;
}
.tl-connector { width: 2px; flex: 1; min-height: 24px; background: rgba(255,255,255,.06); margin: 3px 0; }
.light .tl-connector { background: rgba(99,102,241,.1); }
.tl-content { padding-bottom: 18px; flex: 1; padding-top: 4px; }
.tl-title { font-size: .82rem; font-weight: 600; color: #e2e8f0; }
.light .tl-title { color: #1e1b4b; }
.tl-time { font-size: .71rem; color: #475569; margin-top: 2px; }

/* ── Responsive ── */
@media (max-width: 768px) {
    .dt-search { width: 160px; }
    .dt-search:focus { width: 200px; }
}
</style>

<section id="page-transactions">

    <!-- ── PAGE HEADER ── -->
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px">
        <div>
            <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800;color:#f1f5f9">Transactions</h2>
            <p style="font-size:.82rem;color:#64748b;margin-top:3px">Manage and track all customer transactions</p>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap">
            <button class="btn btn-ghost btn-sm" onclick="exportTransactionsCSV()"><i class="ri-download-2-line"></i> Export CSV</button>
        </div>
    </div>

    <!-- ── STAT CARDS ── -->
    <!-- <div style="display:flex;gap:5px;flex-wrap:wrap;margin-bottom:12px" id="txn-filter-chips">
        <button class="dt-filter-chip active" data-status="all">Total Transactions <span class="chip-count" id="tfc-all">100</span></button>
        <button class="dt-filter-chip" data-status="success"><span class="txn-status-dot success" style="width:5px;height:5px;display:inline-block;border-radius:50%;background:#10b981;margin-right:1px"></span> Completed <span class="chip-count" id="tfc-success">20</span></button>
        <button class="dt-filter-chip" data-status="pending"><span class="txn-status-dot pending" style="width:5px;height:5px;display:inline-block;border-radius:50%;background:#f59e0b;margin-right:1px"></span> Pending <span class="chip-count" id="tfc-pending">70</span></button>
        <button class="dt-filter-chip" data-status="failed"><span class="txn-status-dot failed" style="width:5px;height:5px;display:inline-block;border-radius:50%;background:#f43f5e;margin-right:1px"></span> Total Revenue <span class="chip-count" id="tfc-failed">10</span></button>
    </div> -->

    <!-- ── MAIN TABLE CARD ── -->
    <div class="card" style="padding:18px">

        <!-- Toolbar -->
        <div class="dt-toolbar">
            <div class="dt-toolbar-left">
                <!-- Search -->
                <div class="dt-search-wrap">
                    <i class="ri-search-line"></i>
                    <input class="dt-search" id="transactions-search" placeholder="Search orders…" oninput="transactionsTable.search(this.value)">
                </div>
                <!-- Status filter chips -->
                <div style="display:flex;gap:5px;flex-wrap:wrap;align-items:center" id="transactions-filter-chips">
                    <button class="dt-filter-chip active" data-status="all"   onclick="transactionsTable.filterStatus('all',this)">All <span class="chip-count" id="fc-all">0</span></button>
                    <button class="dt-filter-chip" data-status="pending"      onclick="transactionsTable.filterStatus('pending',this)"><span class="dt-status-dot pending" style="width:5px;height:5px"></span> Pending <span class="chip-count" id="fc-pending">0</span></button>
                    <button class="dt-filter-chip" data-status="completed"    onclick="transactionsTable.filterStatus('completed',this)"><span class="dt-status-dot completed" style="width:5px;height:5px"></span> Completed <span class="chip-count" id="fc-completed">0</span></button>
                </div>
            </div>
            <div class="dt-toolbar-right">
                <!-- Date range -->
                <select class="inp" style="width:auto;min-width:130px;padding:7px 28px 7px 10px;font-size:.75rem" onchange="transactionsTable.filterDate(this.value)">
                    <option value="all">All Time</option>
                    <option value="7">Last 7 Days</option>
                    <option value="30" selected>Last 30 Days</option>
                    <option value="90">Last 90 Days</option>
                </select>
            </div>
        </div>

        <!-- Bulk action bar (hidden by default) -->
        <div class="dt-bulk-bar" id="transactions-bulk-bar" style="display:none">
            <i class="ri-checkbox-multiple-line" style="color:#a78bfa"></i>
            <span class="dt-bulk-count"><span id="transactions-bulk-count">0</span> transactions selected</span>
            <div style="margin-left:auto;display:flex;gap:6px">
                <button class="dt-action-btn" onclick="transactionsTable.bulkAction('complete')"><i class="ri-check-double-line"></i> Mark Complete</button>
                <button class="dt-action-btn" onclick="transactionsTable.bulkAction('export')"><i class="ri-download-line"></i> Export</button>
                <button class="dt-action-btn danger" onclick="transactionsTable.bulkAction('cancel')"><i class="ri-close-circle-line"></i> Cancel</button>
            </div>
        </div>

        <!-- Table -->
        <div class="dt-table-wrap">
            <table class="dt-table" id="transactions-table">
                <thead>
                    <tr>
                        <th class="dt-cb-col"><input type="checkbox" id="transactions-cb-all" onchange="transactionsTable.toggleAll(this.checked)" style="accent-color:#7c3aed;width:14px;height:14px;cursor:pointer"></th>
                        <th data-col="txn-id" onclick="transactionsTable.sort('txn_id',this)">Transaction ID <span class="dt-sort-icon">↕</span></th>
                        <th data-col="order-ref" onclick="transactionsTable.sort('order_ref',this)">Order Ref <span class="dt-sort-icon">↕</span></th>                        <th data-col="customer" onclick="transactionsTable.sort('customer',this)">Customer <span class="dt-sort-icon">↕</span></th>
                        <th data-col="items">Items</th>
                        <th data-col="amount" onclick="transactionsTable.sort('amount',this)">Amount <span class="dt-sort-icon">↕</span></th>
                        <th data-col="status" onclick="transactionsTable.sort('status',this)">Status <span class="dt-sort-icon">↕</span></th>
                        <th data-col="date" onclick="transactionsTable.sort('date',this)">Date <span class="dt-sort-icon">↕</span></th>
                        <th data-col="actions" style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody id="transactions-tbody"></tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="dt-footer">
            <div style="display:flex;align-items:center;gap:14px;flex-wrap:wrap">
                <div class="dt-per-page">
                    <span>Show</span>
                    <select onchange="transactionsTable.setPerPage(+this.value)">
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span>rows</span>
                </div>
                <div class="dt-info" id="transactions-info"></div>
            </div>
            <div class="dt-pagination" id="transactions-pagination"></div>
        </div>

    </div>
</section>

<!-- ═══ ORDER DETAIL DRAWER ═══ -->
<div class="order-drawer-overlay" id="order-drawer-overlay" onclick="if(event.target===this)closeOrderDrawer()">
    <div class="order-drawer" id="order-drawer">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px">
            <div>
                <h2 class="font-jakarta" style="font-size:1.05rem;font-weight:800;color:#f1f5f9" id="drawer-order-id"></h2>
                <p style="font-size:.75rem;color:#64748b;margin-top:2px" id="drawer-order-date"></p>
            </div>
            <button onclick="closeOrderDrawer()" style="background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);color:#94a3b8;width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:.9rem;transition:all .2s;flex-shrink:0"><i class="ri-close-line"></i></button>
        </div>
        <div id="drawer-content"></div>
    </div>
</div>

<script>
/* ═══════════════════════════════════════════
   ORDERS DATA & TABLE ENGINE
═══════════════════════════════════════════ */

/* ── Sample data ── */
const ORDERS_DATA = (function(){
    const statuses  = ['pending','completed'];
    const customers = [
        {name:'Kishore Rex',email:'Kishore@example.com',color:'#7c3aed'},
    ];
    const itemSets = [
        ['Basic Plan']
    ];
    const rows = [];
    const now = new Date();
    for(let i=1; i<=20; i++){
        const c   = customers[i % customers.length];
        const st  = statuses[i % statuses.length];
        const its = itemSets[i % itemSets.length];
        const d   = new Date(now - Math.random()*90*86400000);
        const amt = +(Math.random()*480 + 12).toFixed(2);
        rows.push({
            txn_id: `TXN-${String(10000+i).slice(1)}`,
            order_ref: `ORD-${String(20000+i).slice(1)}`,
            customer: c,
            items: its,
            amount: amt,
            status: st,
            date: d,
            dateStr: d.toLocaleDateString('en-GB',{day:'2-digit',month:'short',year:'numeric'}),
        });
    }
    return rows;
})();

/* ── DataTable engine ── */
const transactionsTable = (function(){
    let data       = [...ORDERS_DATA];
    let filtered   = [...data];
    let page       = 1;
    let perPage    = 10;
    let sortCol    = 'date';
    let sortDir    = 'desc';
    let statusFilt = 'all';
    let searchQ    = '';
    let dateFilt   = 'all';
    let selected   = new Set();
    let hiddenCols = new Set();

    function init(){
        updateCounts();
        render();
    }

    function updateCounts(){
        const counts = {};
        data.forEach(r=>{ counts[r.status]=(counts[r.status]||0)+1; });
        document.getElementById('fc-all').textContent = data.length;
        ['pending','processing','completed','cancelled','refunded'].forEach(s=>{
            const el = document.getElementById('fc-'+s);
            if(el) el.textContent = counts[s]||0;
        });
    }

    function applyFilters(){
        const cutoff = dateFilt!=='all' ? new Date(Date.now()-+dateFilt*86400000) : null;
        filtered = data.filter(r=>{
            if(statusFilt!=='all' && r.status!==statusFilt) return false;
            if(cutoff && r.date<cutoff) return false;
            if(searchQ){
                const q=searchQ.toLowerCase();
                if(!r.txn_id.toLowerCase().includes(q) && !r.order_ref.toLowerCase().includes(q) && !r.customer.name.toLowerCase().includes(q) && !r.customer.email.toLowerCase().includes(q) && !r.items.join(' ').toLowerCase().includes(q)) return false;
            }
            return true;
        });
        if(sortCol){
            filtered.sort((a,b)=>{
                let va=a[sortCol],vb=b[sortCol];
                if(sortCol==='amount')  { va=+va; vb=+vb; }
                else if(sortCol==='date'){ va=va.getTime(); vb=vb.getTime(); }
                else if(sortCol==='customer'){ va=va.name; vb=vb.name; }
                else { va=String(va||''); vb=String(vb||''); }
                return sortDir==='asc'?(va>vb?1:va<vb?-1:0):(va<vb?1:va>vb?-1:0);
            });
        }
        page=1;
        render();
    }

    function render(){
        const tbody  = document.getElementById('transactions-tbody');
        const total  = filtered.length;
        const pages  = Math.max(1,Math.ceil(total/perPage));
        if(page>pages) page=pages;
        const start  = (page-1)*perPage;
        const slice  = filtered.slice(start, start+perPage);

        if(!slice.length){
            tbody.innerHTML=`<tr><td colspan="9"><div class="dt-empty"><i class="ri-shopping-bag-line"></i><p>No transactions found</p><p style="font-size:.75rem;margin-top:4px;color:#475569">Try adjusting your search or filters</p></div></td></tr>`;
        } else {
            tbody.innerHTML = slice.map(r=>rowHTML(r)).join('');
        }

        renderPagination(total, pages);
        document.getElementById('transactions-info').innerHTML =
            `Showing <strong>${Math.min(start+1,total)}–${Math.min(start+perPage,total)}</strong> of <strong>${total}</strong> transactions`;

        // checkbox state
        document.getElementById('transactions-cb-all').checked = slice.length>0 && slice.every(r=>selected.has(r.txn_id));
        document.getElementById('transactions-cb-all').indeterminate = slice.some(r=>selected.has(r.txn_id)) && !slice.every(r=>selected.has(r.txn_id));

        updateBulkBar();
    }

    function rowHTML(r){
        const statusLabels = {pending:'Pending',processing:'Processing',completed:'Completed',cancelled:'Cancelled',refunded:'Refunded'};
        const initials = r.customer.name.split(' ').map(w=>w[0]).join('').slice(0,2);
        const itemsHTML = r.items.slice(0,2).map(it=>`<span class="dt-item-tag"><i class="ri-price-tag-3-line" style="font-size:.65rem"></i>${it}</span>`).join('')
            + (r.items.length>2 ? `<span class="dt-item-tag">+${r.items.length-2}</span>`:'');
        const col = c => hiddenCols.has(c)?'display:none':'';
        return `<tr class="${selected.has(r.txn_id)?'dt-row-selected':''}" data-id="${r.txn_id}">
            <td class="dt-cb-col"><input type="checkbox" ${selected.has(r.txn_id)?'checked':''} style="accent-color:#7c3aed;width:14px;height:14px;cursor:pointer" onchange="transactionsTable.toggleRow('${r.txn_id}',this.checked)"></td>
            <td><span class="dt-order-id">${r.txn_id}</span></td>
            <td><span class="dt-order-id" style="color:#0ea5e9">${r.order_ref}</span></td>
            <td style="${col('customer')}">
                <div class="dt-customer">
                    <div class="dt-avatar" style="background:${r.customer.color}22;color:${r.customer.color}">${initials}</div>
                    <div class="dt-customer-info">
                        <div class="dt-customer-name">${r.customer.name}</div>
                        <div class="dt-customer-email">${r.customer.email}</div>
                    </div>
                </div>
            </td>
            <td style="${col('items')}"><div class="dt-items-wrap">${itemsHTML}</div></td>
            <td style="${col('amount')}">
                <div class="dt-amount">£2.40</div>
                <div class="dt-amount-sub">incl. VAT</div>
            </td>
            <td style="${col('status')}"><span class="dt-status ${r.status}"><span class="dt-status-dot ${r.status}"></span>${statusLabels[r.status]}</span></td>
            <td style="${col('date')}" class="dt-hide"><span style="font-size:.8rem">${r.dateStr}</span></td>
            <td style="${col('actions')};text-align:right">
                <div class="dt-row-actions" style="justify-content:flex-end">
                    <button class="dt-row-btn" title="View" onclick="openOrderDrawer('${r.txn_id}')"><i class="ri-eye-line"></i></button>
                </div>
            </td>
        </tr>`;
    }

    function renderPagination(total, pages){
        const pg = document.getElementById('transactions-pagination');
        let html = '';
        html += `<button class="dt-page-btn" onclick="transactionsTable.goPage(${page-1})" ${page<=1?'disabled':''}><i class="ri-arrow-left-s-line"></i></button>`;
        const range = getPagRange(page,pages);
        range.forEach(p=>{
            if(p==='…') html+=`<span class="dt-page-btn" style="cursor:default;opacity:.4">…</span>`;
            else html+=`<button class="dt-page-btn ${p===page?'active':''}" onclick="transactionsTable.goPage(${p})">${p}</button>`;
        });
        html+=`<button class="dt-page-btn" onclick="transactionsTable.goPage(${page+1})" ${page>=pages?'disabled':''}><i class="ri-arrow-right-s-line"></i></button>`;
        pg.innerHTML = html;
    }

    function getPagRange(cur,total){
        if(total<=7) return Array.from({length:total},(_,i)=>i+1);
        if(cur<=4)  return [1,2,3,4,5,'…',total];
        if(cur>=total-3) return [1,'…',total-4,total-3,total-2,total-1,total];
        return [1,'…',cur-1,cur,cur+1,'…',total];
    }

    function updateBulkBar(){
        const bar = document.getElementById('transactions-bulk-bar');
        document.getElementById('transactions-bulk-count').textContent = selected.size;
        bar.style.display = selected.size>0?'flex':'none';
    }

    return {
        init,
        search(q){ searchQ=q; applyFilters(); },
        filterStatus(s,el){
            statusFilt=s;
            document.querySelectorAll('#transactions-filter-chips .dt-filter-chip').forEach(b=>b.classList.toggle('active',b.dataset.status===s));
            applyFilters();
        },
        filterDate(v){ dateFilt=v; applyFilters(); },
        sort(col,th){
            if(sortCol===col) sortDir=sortDir==='asc'?'desc':'asc'; else{ sortCol=col; sortDir='asc'; }
            document.querySelectorAll('#transactions-table th').forEach(h=>{
                h.classList.remove('sorted-asc','sorted-desc');
                const ic=h.querySelector('.dt-sort-icon');
                if(ic) ic.textContent='↕';
            });
            th.classList.add('sorted-'+sortDir);
            const ic=th.querySelector('.dt-sort-icon');
            if(ic) ic.textContent = sortDir==='asc'?'↑':'↓';
            applyFilters();
        },
        goPage(p){
            if(p<1||p>Math.ceil(filtered.length/perPage)) return;
            page=p; render();
        },
        setPerPage(n){ perPage=n; page=1; render(); },
        toggleAll(checked){
            const start=(page-1)*perPage;
            filtered.slice(start,start+perPage).forEach(r=>{ if(checked) selected.add(r.txn_id); else selected.delete(r.txn_id); });
            render();
        },
        toggleRow(id,checked){ if(checked) selected.add(txn_id); else selected.delete(txn_id); render(); },
        toggleCol(col,show){
            if(show) hiddenCols.delete(col); else hiddenCols.add(col);
            document.querySelectorAll(`#transactions-table [data-col="${col}"]`).forEach(el=>{ el.style.display=show?'':'none'; });
        },
        bulkAction(action){
            const msgs={complete:`${selected.size} transactions completed`,export:`${selected.size} transactions exported`,cancel:`${selected.size} transactions cancelled`};
            const types={complete:'success',export:'info',cancel:'error'};
            toast(msgs[action],types[action]);
            if(action==='cancel'){ selected.clear(); render(); }
        },
    };
})();

/* ── Order Drawer ── */
function openOrderDrawer(orderId){
    const o = ORDERS_DATA.find(r=>r.txn_id===orderId);
    if(!o) return;
    document.getElementById('drawer-order-id').textContent = o.txn_id;
    document.getElementById('drawer-order-date').textContent = 'Placed on ' + o.dateStr;
    const statusLabels = {pending:'Pending',completed:'Completed'};
    const steps = [
        {icon:'ri-shopping-bag-line',label:'Order Placed',done:true,color:'#7c3aed',time:o.dateStr+' · 09:41'},
        {icon:'ri-check-line',label:'Payment Confirmed',done:['processing','completed'].includes(o.status),color:'#10b981',time:'Payment verified'},
        {icon:'ri-map-pin-line',label:'Delivered',done:o.status==='completed',color:'#f59e0b',time:'Signed for delivery'},
    ];
    const initials = o.customer.name.split(' ').map(w=>w[0]).join('').slice(0,2);
    document.getElementById('drawer-content').innerHTML = `
        <div class="drawer-section">
            <div class="drawer-section-title">Customer</div>
            <div style="display:flex;align-items:center;gap:12px;padding:12px;border-radius:10px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06)">
                <div class="dt-avatar" style="width:40px;height:40px;background:${o.customer.color}22;color:${o.customer.color};font-size:.8rem">${initials}</div>
                <div><div style="font-weight:700;color:#838383;font-size:.87rem">${o.customer.name}</div><div style="font-size:.75rem;color:#64748b">${o.customer.email}</div></div>
            </div>
        </div>
        <div class="drawer-section">
            <div class="drawer-section-title">Order Details</div>
            <div class="drawer-row"><span class="drawer-row-label">Order ID</span><span class="drawer-row-val" style="font-family:'DM Mono',monospace;color:#a78bfa">${o.id}</span></div>
            <div class="drawer-row"><span class="drawer-row-label">Status</span><span class="drawer-row-val"><span class="dt-status ${o.status}" style="font-size:.68rem">${statusLabels[o.status]}</span></span></div>
            <div class="drawer-row"><span class="drawer-row-label">Items</span><span class="drawer-row-val">${o.items.join(', ')}</span></div>
            <div class="drawer-row" style="border-top:1px solid #ffffff0d;margin-top:4px;padding-top:10px"><span class="drawer-row-label" style="font-weight:700;color:#94a3b8">Total Amount</span><span class="drawer-row-val" style="font-size:1.1rem;color:#2dd4bf">£${o.amount.toFixed(2)}</span></div>
        </div>
        <div class="hidden drawer-section">
            <div class="drawer-section-title">Order Timeline</div>
            <div class="drawer-timeline">
                ${steps.map((s,i)=>`
                <div class="tl-step">
                    <div class="tl-dot-col">
                        <div class="tl-dot" style="background:${s.done?s.color+'22':'rgba(255,255,255,.04)'};border:2px solid ${s.done?s.color:'rgba(255,255,255,.1)'}">
                            <i class="${s.icon}" style="color:${s.done?s.color:'#475569'}"></i>
                        </div>
                        ${i<steps.length-1?'<div class="tl-connector"></div>':''}
                    </div>
                    <div class="tl-content">
                        <div class="tl-title" style="color:${s.done?'#838383':'#475569'}">${s.label}</div>
                        <div class="tl-time">${s.done?s.time:'Pending'}</div>
                    </div>
                </div>`).join('')}
            </div>
        </div>
        <div style="display:flex;gap:8px;margin-top:6px">
            <button class="btn btn-primary btn-sm" style="flex:1" onclick="openInvoicePopup('${o.txn_id}')">
                <i class="ri-download-line"></i> Invoice
            </button>
        </div>`;
    document.getElementById('order-drawer-overlay').classList.add('open');
    document.getElementById('order-drawer').classList.add('open');
}
function closeOrderDrawer(){
    document.getElementById('order-drawer-overlay').classList.remove('open');
    document.getElementById('order-drawer').classList.remove('open');
}


/* ── CSV Export ── */
function exportTransactionsCSV(){
    const headers=['Order ID','Customer','Email','Items','Amount','Status','Date'];
    const rows = ORDERS_DATA.map(r=>[r.txn_id,r.customer.name,r.customer.email,r.items.join(';'),r.amount.toFixed(2),r.status,r.dateStr]);
    const csv = [headers,...rows].map(r=>r.map(v=>`"${v}"`).join(',')).join('\n');
    const a=document.createElement('a'); a.href='data:text/csv,'+encodeURIComponent(csv); a.download='transactions.csv'; a.click();
    toast('Transactions exported successfully','success');
}

/* ── Boot ── */
document.addEventListener('DOMContentLoaded', ()=> transactionsTable.init());
</script>
<script>
function openInvoicePopup(txnId){
    const o = ORDERS_DATA.find(r => r.txn_id === txnId);
    if(!o) return;

    const params = new URLSearchParams({
        txn_id: o.txn_id,
        order_ref: o.order_ref,
        customer_name: o.customer.name,
        customer_email: o.customer.email,
        items: JSON.stringify(o.items),
        amount: o.amount,
        status: o.status,
        date: o.dateStr
    });

    window.open(
        `transaction-invoice?${params.toString()}`,
        'invoicePopup',
        'width=980,height=760,top=40,left=120,resizable=yes,scrollbars=yes'
    );
}
</script>
@endsection