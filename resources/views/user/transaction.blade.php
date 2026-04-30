@extends('user.layouts.app')
@section('content')

<style>
/* ═══════════════════════════════════════════
   TRANSACTIONS PAGE — CUSTOM DATATABLE STYLES
═══════════════════════════════════════════ */

/* ── Shared DataTable base (same as orders, scoped) ── */
.dt-search-wrap { position: relative; display: flex; align-items: center; }
.dt-search-wrap i { position: absolute; left: 11px; color: #475569; font-size: .85rem; pointer-events: none; z-index: 1; }
.dt-search {
    background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.09); border-radius: 10px;
    padding: 8px 12px 8px 34px; color: #e2e8f0; font-size: .8rem;
    font-family: 'Plus Jakarta Sans', sans-serif; outline: none; width: 220px; transition: border-color .2s, width .3s;
}
.dt-search:focus { border-color: rgba(13,148,136,.5); width: 270px; }
.dt-search::placeholder { color: #475569; }
.light .dt-search { background: #fff; border-color: rgba(13,148,136,.15); color: #134e4a; }

/* ── TXN filter chips ── */
.dt-filter-chip {
    display: inline-flex; align-items: center; gap: 5px; padding: 6px 12px;
    border-radius: 8px; font-size: .73rem; font-weight: 700; cursor: pointer;
    border: 1px solid rgba(255,255,255,.08); background: rgba(255,255,255,.03); color: #64748b;
    transition: all .18s; white-space: nowrap;
}
.dt-filter-chip:hover { border-color: rgba(13,148,136,.3); color: #2dd4bf; }
.dt-filter-chip.active { background: rgba(13,148,136,.12); border-color: rgba(13,148,136,.4); color: #2dd4bf; }
.light .dt-filter-chip { background: #fff; border-color: #e2e8f0; color: #64748b; }
.light .dt-filter-chip.active { background: rgba(13,148,136,.1); border-color: rgba(13,148,136,.3); color: #0d9488; }
.chip-count {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 18px; height: 18px; border-radius: 5px; padding: 0 4px;
    background: rgba(13,148,136,.2); color: #2dd4bf; font-size: .65rem;
}
.dt-filter-chip.active .chip-count { background: rgba(13,148,136,.35); }

/* ── Action buttons ── */
.dt-action-btn {
    display: inline-flex; align-items: center; gap: 5px; padding: 7px 13px;
    border-radius: 9px; font-size: .75rem; font-weight: 700; cursor: pointer;
    border: 1px solid rgba(255,255,255,.09); background: rgba(255,255,255,.04); color: #94a3b8;
    transition: all .18s; font-family: 'Plus Jakarta Sans', sans-serif;
}
.dt-action-btn:hover { border-color: rgba(13,148,136,.35); color: #2dd4bf; background: rgba(13,148,136,.08); }
.dt-action-btn.danger:hover { border-color: rgba(244,63,94,.35); color: #f43f5e; background: rgba(244,63,94,.07); }
.light .dt-action-btn { background: #fff; border-color: #e2e8f0; color: #475569; }

/* ── Column dropdown ── */
.dt-col-drop { position: relative; }
.dt-col-menu {
    position: absolute; top: calc(100% + 6px); right: 0;
    background: #0f0f27; border: 1px solid rgba(13,148,136,.25); border-radius: 12px;
    padding: 10px; min-width: 190px; z-index: 999; display: none;
    box-shadow: 0 20px 40px rgba(0,0,0,.5);
}
.light .dt-col-menu { background: #fff; border-color: rgba(13,148,136,.2); box-shadow: 0 12px 32px rgba(0,0,0,.12); }
.dt-col-menu.open { display: block; }
.dt-col-menu-item {
    display: flex; align-items: center; gap: 9px; padding: 7px 10px;
    border-radius: 7px; cursor: pointer; font-size: .78rem; color: #64748b; transition: all .15s; user-select: none;
}
.dt-col-menu-item:hover { background: rgba(13,148,136,.08); color: #2dd4bf; }
.dt-col-menu-item input[type=checkbox] { accent-color: #0d9488; width: 13px; height: 13px; cursor: pointer; }

/* ── Table ── */
.dt-table-wrap { overflow-x: auto; }
.dt-table { width: 100%; border-collapse: separate; border-spacing: 0; font-size: .82rem; }

.dt-table thead tr th {
    padding: 10px 14px; font-size: .64rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .08em; color: #475569;
    border-bottom: 1px solid rgba(255,255,255,.07); white-space: nowrap;
    cursor: pointer; user-select: none; transition: color .15s;
}
.dt-table thead tr th:hover { color: #2dd4bf; }
.dt-table thead tr th.sorted-asc, .dt-table thead tr th.sorted-desc { color: #2dd4bf; }
.light .dt-table thead tr th { color: #94a3b8; border-color: rgba(13,148,136,.1); }
.light .dt-table thead tr th.sorted-asc, .light .dt-table thead tr th.sorted-desc { color: #0d9488; }

.dt-sort-icon { display: inline-block; margin-left: 4px; opacity: .35; font-size: .65rem; transition: opacity .15s; vertical-align: middle; }
th:hover .dt-sort-icon, th.sorted-asc .dt-sort-icon, th.sorted-desc .dt-sort-icon { opacity: 1; }

.dt-table tbody tr { transition: background .15s; }
.dt-table tbody tr:hover { background: rgba(13,148,136,.05); }
.light .dt-table tbody tr:hover { background: rgba(13,148,136,.04); }
.dt-table tbody tr.dt-row-selected { background: rgba(13,148,136,.1) !important; }

.dt-table tbody td {
    padding: 12px 14px; border-bottom: 1px solid rgba(255,255,255,.04);
    color: #94a3b8; vertical-align: middle; white-space: nowrap;
}
.light .dt-table tbody td { border-color: rgba(13,148,136,.06); color: #475569; }

.dt-cb-col { width: 38px; text-align: center; }
.dt-cb-col input[type=checkbox] { accent-color: #0d9488; width: 14px; height: 14px; cursor: pointer; }

/* ── TXN ID ── */
.txn-id {
    font-family: 'DM Mono', monospace; font-size: .74rem;
    color: #0d9488; font-weight: 600; letter-spacing: .04em;
}
.light .txn-id { color: #0f766e; }

/* ── Method badge ── */
.txn-method {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 10px; border-radius: 7px; font-size: .71rem; font-weight: 700;
    white-space: nowrap;
}
.txn-method.card    { background: rgba(99,102,241,.1);  color: #818cf8; border: 1px solid rgba(99,102,241,.2); }
.txn-method.bank    { background: rgba(16,185,129,.1);  color: #10b981; border: 1px solid rgba(16,185,129,.2); }
.txn-method.wallet  { background: rgba(124,58,237,.1);  color: #a78bfa; border: 1px solid rgba(124,58,237,.2); }
.txn-method.paypal  { background: rgba(6,182,212,.1);   color: #22d3ee; border: 1px solid rgba(6,182,212,.2); }
.txn-method.crypto  { background: rgba(245,158,11,.1);  color: #fbbf24; border: 1px solid rgba(245,158,11,.2); }

/* ── Type badge ── */
.txn-type {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 3px 8px; border-radius: 5px; font-size: .68rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .05em;
}
.txn-type.credit   { background: rgba(16,185,129,.1); color: #10b981; }
.txn-type.debit    { background: rgba(244,63,94,.1);  color: #f43f5e; }
.txn-type.refund   { background: rgba(148,163,184,.08); color: #94a3b8; }
.txn-type.transfer { background: rgba(20,184,166,.1);  color: #2dd4bf; }
.txn-type.fee      { background: rgba(245,158,11,.1);  color: #f59e0b; }

/* ── Status ── */
.txn-status {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 10px; border-radius: 20px; font-size: .7rem; font-weight: 700; white-space: nowrap;
}
.txn-status-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
.txn-status.success  { background: rgba(16,185,129,.1);  color: #10b981; border: 1px solid rgba(16,185,129,.2); }
.txn-status.pending  { background: rgba(245,158,11,.12); color: #f59e0b; border: 1px solid rgba(245,158,11,.25); }
.txn-status.failed   { background: rgba(244,63,94,.1);   color: #f43f5e; border: 1px solid rgba(244,63,94,.2); }
.txn-status.refunded { background: rgba(148,163,184,.08);color: #94a3b8; border: 1px solid rgba(148,163,184,.18); }
.txn-status.review   { background: rgba(124,58,237,.1);  color: #a78bfa; border: 1px solid rgba(124,58,237,.2); }
.txn-status-dot.success  { background: #10b981; box-shadow: 0 0 6px rgba(16,185,129,.6); }
.txn-status-dot.pending  { background: #f59e0b; box-shadow: 0 0 6px rgba(245,158,11,.6); }
.txn-status-dot.failed   { background: #f43f5e; box-shadow: 0 0 6px rgba(244,63,94,.6); }
.txn-status-dot.refunded { background: #94a3b8; }
.txn-status-dot.review   { background: #a78bfa; box-shadow: 0 0 6px rgba(124,58,237,.6); }

/* ── Amount cell ── */
.txn-amount-credit { color: #10b981; font-weight: 800; font-family: 'Plus Jakarta Sans', sans-serif; }
.txn-amount-debit  { color: #f43f5e; font-weight: 800; font-family: 'Plus Jakarta Sans', sans-serif; }
.txn-amount-neutral{ color: #94a3b8; font-weight: 800; font-family: 'Plus Jakarta Sans', sans-serif; }
.txn-amount-sub    { font-size: .7rem; color: #475569; margin-top: 1px; font-weight: 400; }

/* ── Account chip ── */
.txn-account {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 9px; border-radius: 7px; font-size: .73rem; font-weight: 600;
    background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.07); color: #94a3b8;
}
.light .txn-account { background: #f8f7ff; border-color: #e2e8f0; color: #475569; }

/* ── Row actions ── */
.dt-row-actions { display: flex; align-items: center; gap: 5px; }
.dt-row-btn {
    width: 28px; height: 28px; border-radius: 7px; display: flex; align-items: center; justify-content: center;
    font-size: .8rem; cursor: pointer; border: 1px solid rgba(255,255,255,.07);
    background: rgba(255,255,255,.03); color: #64748b; transition: all .15s;
}
.dt-row-btn:hover { border-color: rgba(13,148,136,.35); color: #2dd4bf; background: rgba(13,148,136,.08); }
.dt-row-btn.danger:hover { border-color: rgba(244,63,94,.3); color: #f43f5e; background: rgba(244,63,94,.06); }
.dt-row-btn.warn:hover { border-color: rgba(245,158,11,.3); color: #f59e0b; background: rgba(245,158,11,.06); }
.light .dt-row-btn { background: #fff; border-color: #e2e8f0; color: #64748b; }

/* ── Pagination ── */
.dt-footer { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; margin-top: 16px; }
.dt-info { font-size: .75rem; color: #475569; }
.dt-info strong { color: #94a3b8; }
.dt-pagination { display: flex; align-items: center; gap: 4px; }
.dt-page-btn {
    min-width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center;
    font-size: .78rem; font-weight: 700; font-family: 'Plus Jakarta Sans', sans-serif; cursor: pointer;
    border: 1px solid rgba(255,255,255,.07); background: rgba(255,255,255,.03); color: #64748b; transition: all .15s; padding: 0 8px;
}
.dt-page-btn:hover { border-color: rgba(13,148,136,.35); color: #2dd4bf; background: rgba(13,148,136,.08); }
.dt-page-btn.active { background: linear-gradient(135deg,#0d9488,#7c3aed); color: #fff; border-color: transparent; box-shadow: 0 4px 12px rgba(13,148,136,.35); }
.dt-page-btn:disabled { opacity: .3; cursor: not-allowed; pointer-events: none; }
.light .dt-page-btn { background: #fff; border-color: #e2e8f0; color: #64748b; }
.light .dt-page-btn.active { color: #fff; border-color: transparent; }

.dt-per-page { display: flex; align-items: center; gap: 8px; font-size: .75rem; color: #475569; }
.dt-per-page select {
    background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.09); border-radius: 8px;
    color: #94a3b8; padding: 5px 26px 5px 9px; font-size: .75rem; font-family: 'Plus Jakarta Sans', sans-serif;
    outline: none; cursor: pointer; appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='%230d9488'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 7px center;
}
.light .dt-per-page select { background-color: #fff; border-color: #e2e8f0; color: #475569; }

/* ── Empty state ── */
.dt-empty { text-align: center; padding: 52px 20px; color: #475569; }
.dt-empty i { font-size: 2.5rem; display: block; margin-bottom: 10px; opacity: .25; }

/* ── Bulk bar ── */
.dt-bulk-bar {
    display: flex; align-items: center; gap: 10px; padding: 10px 14px;
    background: linear-gradient(135deg,rgba(13,148,136,.15),rgba(124,58,237,.1));
    border: 1px solid rgba(13,148,136,.3); border-radius: 10px; margin-bottom: 10px; flex-wrap: wrap;
}
.dt-bulk-count { font-size: .8rem; font-weight: 700; color: #2dd4bf; }

/* ── Summary bar ── */
.txn-summary-bar {
    display: flex; gap: 0; border-radius: 12px; overflow: hidden;
    border: 1px solid rgba(255,255,255,.06); margin-bottom: 16px;
}
.txn-summary-seg {
    flex: 1; padding: 12px 16px; text-align: center;
    border-right: 1px solid rgba(255,255,255,.05); transition: background .2s;
}
.txn-summary-seg:last-child { border-right: none; }
.txn-summary-seg:hover { background: rgba(255,255,255,.02); }
.light .txn-summary-bar { border-color: rgba(13,148,136,.1); }
.light .txn-summary-seg { border-color: rgba(13,148,136,.07); }

/* ── Sparkline mini chart ── */
.txn-sparkline { display: inline-flex; align-items: flex-end; gap: 2px; height: 24px; }
.txn-spark-bar { width: 4px; border-radius: 2px; background: rgba(13,148,136,.35); transition: background .2s; }
.txn-spark-bar.active { background: #0d9488; }

/* ── TXN detail modal ── */
.txn-modal-overlay {
    position: fixed; inset: 0; background: rgba(0,0,0,.65); backdrop-filter: blur(5px);
    z-index: 9997; display: flex; align-items: center; justify-content: center; padding: 20px;
    opacity: 0; pointer-events: none; transition: opacity .25s;
}
.txn-modal-overlay.open { opacity: 1; pointer-events: all; }
.txn-modal {
    background: #0c0c1e; border: 1px solid rgba(13,148,136,.25); border-radius: 20px;
    padding: 28px; width: 100%; max-width: 520px; max-height: 90vh; overflow-y: auto;
    transform: translateY(20px) scale(.97); transition: transform .3s cubic-bezier(.16,1,.3,1);
    box-shadow: 0 32px 64px rgba(0,0,0,.5), 0 0 0 1px rgba(13,148,136,.1);
}
.light .txn-modal { background: #fff; border-color: rgba(13,148,136,.2); box-shadow: 0 32px 64px rgba(0,0,0,.15); }
.txn-modal-overlay.open .txn-modal { transform: translateY(0) scale(1); }

.detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 16px; }
.detail-tile {
    padding: 12px 14px; border-radius: 10px;
    background: rgba(255,255,255,.03); border: 1px solid rgba(255,255,255,.06);
}
.light .detail-tile { background: #f8f7ff; border-color: rgba(13,148,136,.09); }
.detail-tile-label { font-size: .65rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #475569; margin-bottom: 5px; }
.detail-tile-val { font-size: .87rem; font-weight: 700; color: #e2e8f0; }
.light .detail-tile-val { color: #1e1b4b; }

/* ── Responsive ── */
@media (max-width: 768px) {
    .dt-search { width: 160px; }
    .dt-search:focus { width: 200px; }
    .dt-hide-sm { display: none !important; }
    .txn-summary-seg .spark-wrap { display: none; }
}
</style>

<section id="page-transactions">

    <!-- ── PAGE HEADER ── -->
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px">
        <div>
            <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800;color:#f1f5f9">Transactions</h2>
            <p style="font-size:.82rem;color:#64748b;margin-top:3px">Full ledger of all payment transactions</p>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap">
            <button class="btn btn-ghost btn-sm" onclick="exportTxnCSV()"><i class="ri-download-2-line"></i> Export CSV</button>
            <button class="btn btn-primary btn-sm" style="background:linear-gradient(135deg,#0d9488,#0f766e)" onclick="toast('Manual transaction coming soon','info')"><i class="ri-add-line"></i> Record</button>
        </div>
    </div>

    <!-- Status filter chips -->
    <div style="display:flex;gap:5px;flex-wrap:wrap;margin-bottom:12px" id="txn-filter-chips">
        <button class="dt-filter-chip active" data-status="all"      onclick="txnTable.filterStatus('all',this)">All <span class="chip-count" id="tfc-all">0</span></button>
        <button class="dt-filter-chip" data-status="success"         onclick="txnTable.filterStatus('success',this)"><span class="txn-status-dot success" style="width:5px;height:5px;display:inline-block;border-radius:50%;background:#10b981;margin-right:1px"></span> Success <span class="chip-count" id="tfc-success">0</span></button>
        <button class="dt-filter-chip" data-status="pending"         onclick="txnTable.filterStatus('pending',this)"><span class="txn-status-dot pending" style="width:5px;height:5px;display:inline-block;border-radius:50%;background:#f59e0b;margin-right:1px"></span> Pending <span class="chip-count" id="tfc-pending">0</span></button>
        <button class="dt-filter-chip" data-status="failed"          onclick="txnTable.filterStatus('failed',this)"><span class="txn-status-dot failed" style="width:5px;height:5px;display:inline-block;border-radius:50%;background:#f43f5e;margin-right:1px"></span> Failed <span class="chip-count" id="tfc-failed">0</span></button>
        <button class="dt-filter-chip" data-status="refunded"        onclick="txnTable.filterStatus('refunded',this)"><span class="txn-status-dot refunded" style="width:5px;height:5px;display:inline-block;border-radius:50%;background:#94a3b8;margin-right:1px"></span> Refunded <span class="chip-count" id="tfc-refunded">0</span></button>
        <button class="dt-filter-chip" data-status="review"          onclick="txnTable.filterStatus('review',this)"><span class="txn-status-dot review" style="width:5px;height:5px;display:inline-block;border-radius:50%;background:#a78bfa;margin-right:1px"></span> Review <span class="chip-count" id="tfc-review">0</span></button>
    </div>

    <!-- ── MAIN TABLE CARD ── -->
    <div class="card" style="padding:18px">

        <!-- Toolbar -->
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;margin-bottom:12px">
            <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap">
                <div class="dt-search-wrap">
                    <i class="ri-search-line"></i>
                    <input class="dt-search" id="txn-search" placeholder="Search transactions…" oninput="txnTable.search(this.value)">
                </div>
                <!-- Method filter -->
                <select class="inp" style="width:auto;min-width:130px;padding:7px 28px 7px 10px;font-size:.75rem" onchange="txnTable.filterMethod(this.value)">
                    <option value="all">All Methods</option>
                    <option value="card">Card</option>
                    <option value="bank">Bank Transfer</option>
                    <option value="wallet">Wallet</option>
                    <option value="paypal">PayPal</option>
                    <option value="crypto">Crypto</option>
                </select>
            </div>
            <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap">
                <!-- Date range -->
                <select class="inp" style="width:auto;min-width:130px;padding:7px 28px 7px 10px;font-size:.75rem" onchange="txnTable.filterDate(this.value)">
                    <option value="all">All Time</option>
                    <option value="7">Last 7 Days</option>
                    <option value="30" selected>Last 30 Days</option>
                    <option value="90">Last 90 Days</option>
                </select>
                <button class="dt-action-btn" onclick="exportTxnCSV()"><i class="ri-download-line"></i> <span class="mobile-hide-xs">Export</span></button>
            </div>
        </div>

        <!-- Status filter chips -->
        <div style="display:none;gap:5px;flex-wrap:wrap;margin-bottom:12px" id="txn-filter-chips">
            <button class="dt-filter-chip active" data-status="all"      onclick="txnTable.filterStatus('all',this)">All <span class="chip-count" id="tfc-all">0</span></button>
            <button class="dt-filter-chip" data-status="success"         onclick="txnTable.filterStatus('success',this)"><span class="txn-status-dot success" style="width:5px;height:5px;display:inline-block;border-radius:50%;background:#10b981;margin-right:1px"></span> Success <span class="chip-count" id="tfc-success">0</span></button>
            <button class="dt-filter-chip" data-status="pending"         onclick="txnTable.filterStatus('pending',this)"><span class="txn-status-dot pending" style="width:5px;height:5px;display:inline-block;border-radius:50%;background:#f59e0b;margin-right:1px"></span> Pending <span class="chip-count" id="tfc-pending">0</span></button>
            <button class="dt-filter-chip" data-status="failed"          onclick="txnTable.filterStatus('failed',this)"><span class="txn-status-dot failed" style="width:5px;height:5px;display:inline-block;border-radius:50%;background:#f43f5e;margin-right:1px"></span> Failed <span class="chip-count" id="tfc-failed">0</span></button>
            <button class="dt-filter-chip" data-status="refunded"        onclick="txnTable.filterStatus('refunded',this)"><span class="txn-status-dot refunded" style="width:5px;height:5px;display:inline-block;border-radius:50%;background:#94a3b8;margin-right:1px"></span> Refunded <span class="chip-count" id="tfc-refunded">0</span></button>
            <button class="dt-filter-chip" data-status="review"          onclick="txnTable.filterStatus('review',this)"><span class="txn-status-dot review" style="width:5px;height:5px;display:inline-block;border-radius:50%;background:#a78bfa;margin-right:1px"></span> Review <span class="chip-count" id="tfc-review">0</span></button>
        </div>

        <!-- Bulk bar -->
        <div class="dt-bulk-bar" id="txn-bulk-bar" style="display:none">
            <i class="ri-checkbox-multiple-line" style="color:#2dd4bf"></i>
            <span class="dt-bulk-count"><span id="txn-bulk-count">0</span> transactions selected</span>
            <div style="margin-left:auto;display:flex;gap:6px">
                <button class="dt-action-btn" onclick="txnTable.bulkAction('export')"><i class="ri-download-line"></i> Export</button>
                <button class="dt-action-btn warn" onclick="txnTable.bulkAction('review')" style="color:#f59e0b" ><i class="ri-eye-line"></i> Flag Review</button>
                <button class="dt-action-btn danger" onclick="txnTable.bulkAction('void')"><i class="ri-close-circle-line"></i> Void</button>
            </div>
        </div>

        <!-- Table -->
        <div class="dt-table-wrap">
            <table class="dt-table" id="txn-table">
                <thead>
                    <tr>
                        <th class="dt-cb-col">
                            <input type="checkbox" id="txn-cb-all" onchange="txnTable.toggleAll(this.checked)">
                        </th>
                        <th data-col="id" onclick="txnTable.sort('id',this)">TXN ID <span class="dt-sort-icon">↕</span></th>
                        <th data-col="ref">Order Ref</th>
                        <th data-col="method" onclick="txnTable.sort('method',this)">Method <span class="dt-sort-icon">↕</span></th>
                        <th data-col="amount" onclick="txnTable.sort('amount',this)">Amount <span class="dt-sort-icon">↕</span></th>
                        <th data-col="status" onclick="txnTable.sort('status',this)">Status <span class="dt-sort-icon">↕</span></th>
                        <th data-col="date" onclick="txnTable.sort('date',this)">Date & Time <span class="dt-sort-icon">↕</span></th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody id="txn-tbody"></tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="dt-footer">
            <div style="display:flex;align-items:center;gap:14px;flex-wrap:wrap">
                <div class="dt-per-page">
                    <span>Show</span>
                    <select onchange="txnTable.setPerPage(+this.value)">
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span>rows</span>
                </div>
                <div class="dt-info" id="txn-info"></div>
            </div>
            <div class="dt-pagination" id="txn-pagination"></div>
        </div>
    </div>
</section>

<!-- ═══ TRANSACTION DETAIL MODAL ═══ -->
<div class="txn-modal-overlay" id="txn-modal-overlay" onclick="if(event.target===this)closeTxnModal()">
    <div class="txn-modal">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:22px">
            <div>
                <h2 class="font-jakarta" style="font-size:1.05rem;font-weight:800;color:#f1f5f9" id="modal-txn-id"></h2>
                <p style="font-size:.75rem;color:#64748b;margin-top:2px" id="modal-txn-sub"></p>
            </div>
            <button onclick="closeTxnModal()" style="background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);color:#94a3b8;width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:.9rem;transition:all .2s;flex-shrink:0"><i class="ri-close-line"></i></button>
        </div>
        <div id="modal-txn-content"></div>
    </div>
</div>

<script>
/* ═══════════════════════════════════════════
   TRANSACTIONS DATA & TABLE ENGINE
═══════════════════════════════════════════ */

/* ── Sample data ── */
const TXN_DATA = (function(){
    const statuses = ['success','success','success','pending','failed','refunded','review','success'];
    const types    = ['credit','debit','credit','debit','refund','transfer','fee','credit'];
    const methods  = ['card','bank','paypal','wallet','card','crypto','bank','card'];
    const accounts = ['Visa ••4242','HSBC ••7731','PayPal','Apple Pay','Amex ••8801','BTC Wallet','Lloyds ••2291','Mastercard ••5566'];
    const descriptions = ['Subscription Payment','Service Fee','Refund Processed','Order Payment','Annual Plan Renewal','Transfer Out','Platform Fee','Reminder Credit'];
    const refs = ['#ORD-0041','#ORD-0038','#ORD-0033','#ORD-0051','#ORD-0019','—','#ORD-0062','#ORD-0044'];
    const rows = [];
    const now = new Date();
    for(let i=1; i<=200; i++){
        const idx = i % statuses.length;
        const d = new Date(now - Math.random()*120*86400000);
        const amt = +(Math.random()*350 + 2.5).toFixed(2);
        rows.push({
            id: `#TXN-${String(20000+i).slice(1)}`,
            ref: refs[idx],
            type: types[idx],
            method: methods[idx],
            amount: amt,
            status: statuses[idx],
            description: descriptions[idx],
            date: d,
            dateStr: d.toLocaleDateString('en-GB',{day:'2-digit',month:'short',year:'numeric'}),
            timeStr: d.toLocaleTimeString('en-GB',{hour:'2-digit',minute:'2-digit'}),
            fee: +(amt * 0.025).toFixed(2),
        });
    }
    return rows;
})();

/* ── Engine ── */
const txnTable = (function(){
    let data       = [...TXN_DATA];
    let filtered   = [...data];
    let page       = 1;
    let perPage    = 10;
    let sortCol    = 'date';
    let sortDir    = 'desc';
    let statusFilt = 'all';
    let methodFilt = 'all';
    let searchQ    = '';
    let dateFilt   = 'all';
    let selected   = new Set();

    function init(){
        updateCounts();
        render();
    }

    function updateCounts(){
        const counts = {};
        data.forEach(r=>{ counts[r.status]=(counts[r.status]||0)+1; });
        document.getElementById('tfc-all').textContent = data.length;
        ['success','pending','failed','refunded','review'].forEach(s=>{
            const el = document.getElementById('tfc-'+s);
            if(el) el.textContent = counts[s]||0;
        });
    }


    function applyFilters(){
        const cutoff = dateFilt!=='all' ? new Date(Date.now()-+dateFilt*86400000) : null;
        filtered = data.filter(r=>{
            if(statusFilt!=='all' && r.status!==statusFilt) return false;
            if(typeFilt!=='all'   && r.type!==typeFilt)     return false;
            if(methodFilt!=='all' && r.method!==methodFilt) return false;
            if(cutoff && r.date<cutoff) return false;
            if(searchQ){
                const q=searchQ.toLowerCase();
                if(!r.id.toLowerCase().includes(q) && !r.ref.toLowerCase().includes(q) && !r.description.toLowerCase().includes(q) && !r.account.toLowerCase().includes(q)) return false;
            }
            return true;
        });
        if(sortCol){
            filtered.sort((a,b)=>{
                let va=a[sortCol],vb=b[sortCol];
                if(sortCol==='amount') { va=+va; vb=+vb; }
                else if(sortCol==='date') { va=va.getTime(); vb=vb.getTime(); }
                else { va=String(va||''); vb=String(vb||''); }
                return sortDir==='asc'?(va>vb?1:va<vb?-1:0):(va<vb?1:va>vb?-1:0);
            });
        }
        page=1;
        render();
    }

    function render(){
        const tbody  = document.getElementById('txn-tbody');
        const total  = filtered.length;
        const pages  = Math.max(1,Math.ceil(total/perPage));
        if(page>pages) page=pages;
        const start  = (page-1)*perPage;
        const slice  = filtered.slice(start, start+perPage);

        if(!slice.length){
            tbody.innerHTML=`<tr><td colspan="10"><div class="dt-empty"><i class="ri-exchange-line"></i><p>No transactions found</p><p style="font-size:.75rem;margin-top:4px;color:#475569">Try adjusting your filters</p></div></td></tr>`;
        } else {
            tbody.innerHTML = slice.map(r=>rowHTML(r)).join('');
        }

        renderPagination(total,pages);
        document.getElementById('txn-info').innerHTML =
            `Showing <strong>${Math.min(start+1,total)}–${Math.min(start+perPage,total)}</strong> of <strong>${total}</strong> transactions`;

        document.getElementById('txn-cb-all').checked = slice.length>0 && slice.every(r=>selected.has(r.id));
        document.getElementById('txn-cb-all').indeterminate = slice.some(r=>selected.has(r.id)) && !slice.every(r=>selected.has(r.id));
        updateBulkBar();
    }

    function rowHTML(r){
        const col = c => hiddenCols.has(c)?'display:none':'';
        const methodIcons = {card:'ri-bank-card-line',bank:'ri-building-2-line',wallet:'ri-wallet-3-line',paypal:'ri-paypal-line',crypto:'ri-bit-coin-line'};
        const typeIcons   = {credit:'ri-arrow-down-line',debit:'ri-arrow-up-line',refund:'ri-arrow-go-back-line',transfer:'ri-swap-line',fee:'ri-percent-line'};
        const typeLabels  = {credit:'Credit',debit:'Debit',refund:'Refund',transfer:'Transfer',fee:'Fee'};
        const statusLabels= {success:'Success',pending:'Pending',failed:'Failed',refunded:'Refunded',review:'Review'};
        const amtClass = r.type==='credit'?'txn-amount-credit':r.type==='debit'?'txn-amount-debit':'txn-amount-neutral';
        const amtSign  = r.type==='credit'?'+':r.type==='debit'?'−':'';
        return `<tr class="${selected.has(r.id)?'dt-row-selected':''}" data-id="${r.id}">
            <td class="dt-cb-col">
                <input type="checkbox" ${selected.has(r.id)?'checked':''}
                onchange="txnTable.toggleRow('${r.id}',this.checked)">
            </td>

            <td><span class="txn-id">${r.id}</span></td>

            <td>
                <span style="font-size:.75rem;color:#64748b;font-family:'DM Mono',monospace">
                    ${r.ref}
                </span>
            </td>

            <td>
                <span class="txn-method ${r.method}">
                    <i class="ri-bank-card-line"></i>
                    ${r.method.charAt(0).toUpperCase()+r.method.slice(1)}
                </span>
            </td>

            <td>
                <div class="${amtClass}">${amtSign}£${r.amount.toFixed(2)}</div>
            </td>

            <td>
                <span class="txn-status ${r.status}">
                    <span class="txn-status-dot ${r.status}"></span>
                    ${statusLabels[r.status]}
                </span>
            </td>

            <td class="dt-hide-sm">
                <div style="font-size:.8rem;color:#94a3b8">${r.dateStr}</div>
                <div style="font-size:.7rem;color:#475569">${r.timeStr}</div>
            </td>

            <td style="text-align:right">
                <div class="dt-row-actions" style="justify-content:flex-end">
                    <button class="dt-row-btn" title="View Details"
                        onclick="openTxnModal('${r.id}')">
                        <i class="ri-eye-line"></i>
                    </button>
                </div>
            </td>
        </tr>`;
    }

    function renderPagination(total,pages){
        const pg = document.getElementById('txn-pagination');
        let html = '';
        html+=`<button class="dt-page-btn" onclick="txnTable.goPage(${page-1})" ${page<=1?'disabled':''}><i class="ri-arrow-left-s-line"></i></button>`;
        const range = getPagRange(page,pages);
        range.forEach(p=>{
            if(p==='…') html+=`<span class="dt-page-btn" style="cursor:default;opacity:.4">…</span>`;
            else html+=`<button class="dt-page-btn ${p===page?'active':''}" onclick="txnTable.goPage(${p})">${p}</button>`;
        });
        html+=`<button class="dt-page-btn" onclick="txnTable.goPage(${page+1})" ${page>=pages?'disabled':''}><i class="ri-arrow-right-s-line"></i></button>`;
        pg.innerHTML=html;
    }

    function getPagRange(cur,total){
        if(total<=7) return Array.from({length:total},(_,i)=>i+1);
        if(cur<=4)   return [1,2,3,4,5,'…',total];
        if(cur>=total-3) return [1,'…',total-4,total-3,total-2,total-1,total];
        return [1,'…',cur-1,cur,cur+1,'…',total];
    }

    function updateBulkBar(){
        document.getElementById('txn-bulk-count').textContent = selected.size;
        document.getElementById('txn-bulk-bar').style.display = selected.size>0?'flex':'none';
    }

    return {
        init,
        search(q){ searchQ=q; applyFilters(); },
        filterStatus(s,el){
            statusFilt=s;
            document.querySelectorAll('#txn-filter-chips .dt-filter-chip').forEach(b=>b.classList.toggle('active',b.dataset.status===s));
            applyFilters();
        },
        filterMethod(v){ methodFilt=v; applyFilters(); },
        filterDate(v){ dateFilt=v; applyFilters(); },
        sort(col,th){
            if(sortCol===col) sortDir=sortDir==='asc'?'desc':'asc'; else{ sortCol=col; sortDir='asc'; }
            document.querySelectorAll('#txn-table th').forEach(h=>{
                h.classList.remove('sorted-asc','sorted-desc');
                const ic=h.querySelector('.dt-sort-icon'); if(ic) ic.textContent='↕';
            });
            th.classList.add('sorted-'+sortDir);
            const ic=th.querySelector('.dt-sort-icon'); if(ic) ic.textContent=sortDir==='asc'?'↑':'↓';
            applyFilters();
        },
        goPage(p){
            if(p<1||p>Math.ceil(filtered.length/perPage)) return;
            page=p; render();
        },
        setPerPage(n){ perPage=n; page=1; render(); },
        toggleAll(checked){
            const start=(page-1)*perPage;
            filtered.slice(start,start+perPage).forEach(r=>{ if(checked) selected.add(r.id); else selected.delete(r.id); });
            render();
        },
        toggleRow(id,checked){ if(checked) selected.add(id); else selected.delete(id); render(); },
        bulkAction(action){
            const msgs={export:`${selected.size} transactions exported`,review:`${selected.size} flagged for review`,void:`${selected.size} transactions voided`};
            const types={export:'info',review:'info',void:'error'};
            toast(msgs[action],types[action]);
            if(action==='void'){ selected.clear(); render(); }
        },
    };
})();

/* ── TXN Detail Modal ── */
function openTxnModal(txnId){
    const t = TXN_DATA.find(r=>r.id===txnId);
    if(!t) return;
    document.getElementById('modal-txn-id').textContent  = t.id;
    document.getElementById('modal-txn-sub').textContent = t.description + ' · ' + t.dateStr + ' ' + t.timeStr;
    const typeLabels   = {credit:'Credit',debit:'Debit',refund:'Refund',transfer:'Transfer',fee:'Fee'};
    const statusLabels = {success:'Success',pending:'Pending',failed:'Failed',refunded:'Refunded',review:'Under Review'};
    const amtSign = t.type==='credit'?'+':t.type==='debit'?'−':'';
    const amtClass = t.type==='credit'?'#10b981':t.type==='debit'?'#f43f5e':'#94a3b8';
    document.getElementById('modal-txn-content').innerHTML = `
        <!-- Big amount -->
        <div style="text-align:center;padding:22px;background:linear-gradient(135deg,rgba(13,148,136,.1),rgba(124,58,237,.08));border-radius:14px;margin-bottom:20px;border:1px solid rgba(13,148,136,.15)">
            <div style="font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#475569;margin-bottom:6px">${typeLabels[t.type]} Amount</div>
            <div class="font-jakarta" style="font-size:2.2rem;font-weight:800;color:${amtClass}">${amtSign}£${t.amount.toFixed(2)}</div>
            <div style="margin-top:8px"><span class="txn-status ${t.status}" style="display:inline-flex"><span class="txn-status-dot ${t.status}"></span>${statusLabels[t.status]}</span></div>
        </div>
        <!-- Detail grid -->
        <div class="detail-grid">
            <div class="detail-tile">
                <div class="detail-tile-label">Transaction ID</div>
                <div class="detail-tile-val" style="font-family:'DM Mono',monospace;font-size:.78rem;color:#2dd4bf">${t.id}</div>
            </div>
            <div class="detail-tile">
                <div class="detail-tile-label">Order Reference</div>
                <div class="detail-tile-val" style="font-family:'DM Mono',monospace;font-size:.78rem;color:#a78bfa">${t.ref}</div>
            </div>
            <div class="detail-tile">
                <div class="detail-tile-label">Payment Method</div>
                <div class="detail-tile-val">${t.method.charAt(0).toUpperCase()+t.method.slice(1)}</div>
            </div>
            <div class="detail-tile">
                <div class="detail-tile-label">Account</div>
                <div class="detail-tile-val">${t.account}</div>
            </div>
            <div class="detail-tile">
                <div class="detail-tile-label">Type</div>
                <div class="detail-tile-val"><span class="txn-type ${t.type}">${typeLabels[t.type]}</span></div>
            </div>
            <div class="detail-tile">
                <div class="detail-tile-label">Processing Fee</div>
                <div class="detail-tile-val" style="color:#f59e0b">£${t.fee.toFixed(2)}</div>
            </div>
            <div class="detail-tile">
                <div class="detail-tile-label">Date</div>
                <div class="detail-tile-val">${t.dateStr}</div>
            </div>
            <div class="detail-tile">
                <div class="detail-tile-label">Time</div>
                <div class="detail-tile-val">${t.timeStr}</div>
            </div>
        </div>
        <!-- Net amount -->
        <div style="padding:14px;border-radius:10px;background:rgba(255,255,255,.02);border:1px solid rgba(255,255,255,.06);margin-bottom:18px">
            <div style="display:flex;justify-content:space-between;font-size:.82rem;margin-bottom:8px">
                <span style="color:#64748b">Gross Amount</span>
                <span style="color:#94a3b8">£${t.amount.toFixed(2)}</span>
            </div>
            <div style="display:flex;justify-content:space-between;font-size:.82rem;margin-bottom:10px">
                <span style="color:#64748b">Processing Fee</span>
                <span style="color:#f43f5e">− £${t.fee.toFixed(2)}</span>
            </div>
            <div style="display:flex;justify-content:space-between;font-size:.88rem;font-weight:700;border-top:1px solid rgba(255,255,255,.07);padding-top:10px">
                <span style="color:#94a3b8">Net Amount</span>
                <span style="color:#2dd4bf" class="font-jakarta">£${(t.amount - t.fee).toFixed(2)}</span>
            </div>
        </div>
        <div style="display:flex;gap:8px">
            <button class="btn btn-primary btn-sm" style="flex:1;background:linear-gradient(135deg,#0d9488,#0f766e)" onclick="toast('Invoice downloaded','success')"><i class="ri-receipt-line"></i> Invoice</button>
            ${t.status==='success'?`<button class="btn btn-ghost btn-sm" style="flex:1" onclick="toast('Refund initiated','error')"><i class="ri-arrow-go-back-line"></i> Refund</button>`:''}
            ${t.status==='failed'?`<button class="btn btn-ghost btn-sm" style="flex:1" onclick="toast('Retrying transaction…','info')"><i class="ri-refresh-line"></i> Retry</button>`:''}
        </div>`;
    document.getElementById('txn-modal-overlay').classList.add('open');
}
function closeTxnModal(){
    document.getElementById('txn-modal-overlay').classList.remove('open');
}

/* ── Column menu ── */
function toggleTxnColMenu(){
    const m = document.getElementById('txn-col-menu');
    m.classList.toggle('open');
    const close=e=>{ if(!m.contains(e.target)&&!e.target.closest('.dt-col-drop')){ m.classList.remove('open'); document.removeEventListener('click',close); } };
    setTimeout(()=>document.addEventListener('click',close),50);
}

/* ── CSV Export ── */
function exportTxnCSV(){
    const headers=['TXN ID','Order Ref','Type','Method','Account','Amount','Fee','Net','Status','Date','Time'];
    const rows = TXN_DATA.map(r=>[r.id,r.ref,r.type,r.method,r.account,r.amount.toFixed(2),r.fee.toFixed(2),(r.amount-r.fee).toFixed(2),r.status,r.dateStr,r.timeStr]);
    const csv  = [headers,...rows].map(r=>r.map(v=>`"${v}"`).join(',')).join('\n');
    const a=document.createElement('a'); a.href='data:text/csv,'+encodeURIComponent(csv); a.download='transactions.csv'; a.click();
    toast('Transactions exported successfully','success');
}

/* ── Boot ── */
document.addEventListener('DOMContentLoaded', ()=> txnTable.init());
</script>

@endsection