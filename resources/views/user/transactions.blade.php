@extends('user.layouts.app')
@section('content')

<style>
    /* ═══════════════════════════════════════════
                ORDERS PAGE — CUSTOM DATATABLE STYLES
                ═══════════════════════════════════════════ */

    .dt-wrapper { position: relative; }

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

    .dt-search:focus {
        border-color: rgba(124,58,237,.5);
        width: 270px;
    }

    .dt-search::placeholder { color: #475569; }

    .light .dt-search {
        background: #fff;
        border-color: rgba(99,102,241,.15);
        color: #1e1b4b;
    }

    .light .dt-search::placeholder { color: #94a3b8; }

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

    .dt-filter-chip:hover {
        border-color: rgba(124,58,237,.3);
        color: #a78bfa;
    }

    .dt-filter-chip.active {
        background: rgba(124,58,237,.15);
        border-color: rgba(124,58,237,.4);
        color: #a78bfa;
    }

    .light .dt-filter-chip {
        background: #fff;
        border-color: #e2e8f0;
        color: #64748b;
    }

    .light .dt-filter-chip.active {
        background: rgba(124,58,237,.1);
        border-color: rgba(124,58,237,.3);
        color: #7c3aed;
    }

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

    .dt-action-btn:hover {
        border-color: rgba(124,58,237,.35);
        color: #a78bfa;
        background: rgba(124,58,237,.08);
    }

    .dt-action-btn.danger:hover {
        border-color: rgba(244,63,94,.35);
        color: #f43f5e;
        background: rgba(244,63,94,.07);
    }

    .light .dt-action-btn {
        background: #fff;
        border-color: #e2e8f0;
        color: #475569;
    }

    .dt-table-wrap { overflow-x: auto; }

    .dt-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: .82rem;
    }

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

    .light .dt-table thead tr th {
        color: #94a3b8;
        border-color: rgba(99,102,241,.1);
    }

    .light .dt-table thead tr th.sorted-asc,
    .light .dt-table thead tr th.sorted-desc { color: #7c3aed; }

    .dt-sort-icon {
        display: inline-block;
        margin-left: 4px;
        opacity: .35;
        font-size: .65rem;
        transition: opacity .15s;
        vertical-align: middle;
    }

    th:hover .dt-sort-icon,
    th.sorted-asc .dt-sort-icon,
    th.sorted-desc .dt-sort-icon { opacity: 1; }

    .dt-table tbody tr {
        transition: background .15s;
        cursor: default;
    }

    .dt-table tbody tr:hover { background: rgba(124,58,237,.06); }
    .light .dt-table tbody tr:hover { background: rgba(99,102,241,.04); }

    .dt-table tbody tr.dt-row-selected { background: rgba(124,58,237,.1) !important; }
    .light .dt-table tbody tr.dt-row-selected { background: rgba(124,58,237,.07) !important; }

    .dt-table tbody td {
        padding: 11px 14px;
        border-bottom: 1px solid rgba(255,255,255,.04);
        color: #94a3b8;
        vertical-align: middle;
        white-space: nowrap;
    }

    .light .dt-table tbody td {
        border-color: rgba(99,102,241,.06);
        color: #475569;
    }

    .dt-cb-col {
        width: 38px;
        text-align: center;
    }

    .dt-cb-col input[type=checkbox] {
        accent-color: #7c3aed;
        width: 14px;
        height: 14px;
        cursor: pointer;
    }

    .dt-order-id {
        font-family: 'DM Mono', monospace;
        font-size: .75rem;
        color: #7c3aed;
        font-weight: 600;
        letter-spacing: .03em;
    }

    .light .dt-order-id { color: #6d28d9; }

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

    .dt-customer-name {
        font-size: .82rem;
        font-weight: 600;
        color: #e2e8f0;
    }

    .light .dt-customer-name { color: #1e1b4b; }

    .dt-customer-email {
        font-size: .7rem;
        color: #475569;
    }

    .dt-items-wrap {
        display: flex;
        align-items: center;
        gap: 5px;
        flex-wrap: wrap;
    }

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

    .light .dt-item-tag {
        background: #f1f5f9;
        border-color: #e2e8f0;
        color: #475569;
    }

    .dt-amount {
        font-weight: 800;
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #f1f5f9;
    }

    .light .dt-amount { color: #1e1b4b; }

    .dt-amount-sub {
        font-size: .7rem;
        color: #475569;
        font-weight: 400;
        margin-top: 1px;
    }

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

    .dt-status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .dt-status.pending {
        background: rgba(245,158,11,.12);
        color: #f59e0b;
        border: 1px solid rgba(245,158,11,.25);
    }

    .dt-status.completed {
        background: rgba(16,185,129,.1);
        color: #10b981;
        border: 1px solid rgba(16,185,129,.2);
    }

    .dt-status-dot.pending {
        background: #f59e0b;
        box-shadow: 0 0 6px rgba(245,158,11,.6);
    }

    .dt-status-dot.completed {
        background: #10b981;
        box-shadow: 0 0 6px rgba(16,185,129,.6);
    }

    .dt-row-actions {
        display: flex;
        align-items: center;
        gap: 5px;
    }

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

    .dt-row-btn:hover {
        border-color: rgba(124,58,237,.35);
        color: #a78bfa;
        background: rgba(124,58,237,.08);
    }

    .light .dt-row-btn {
        background: #fff;
        border-color: #e2e8f0;
        color: #64748b;
    }

    .dt-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 16px;
    }

    .dt-info {
        font-size: .75rem;
        color: #475569;
    }

    .dt-info strong { color: #94a3b8; }
    .light .dt-info strong { color: #475569; }

    .dt-pagination {
        display: flex;
        align-items: center;
        gap: 4px;
    }

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

    .dt-page-btn:hover {
        border-color: rgba(124,58,237,.35);
        color: #a78bfa;
        background: rgba(124,58,237,.08);
    }

    .dt-page-btn.active {
        background: linear-gradient(135deg, #7c3aed, #0d9488);
        color: #fff;
        border-color: transparent;
        box-shadow: 0 4px 12px rgba(124,58,237,.35);
    }

    .dt-page-btn:disabled {
        opacity: .3;
        cursor: not-allowed;
        pointer-events: none;
    }

    .light .dt-page-btn {
        background: #fff;
        border-color: #e2e8f0;
        color: #64748b;
    }

    .light .dt-page-btn.active {
        color: #fff;
        border-color: transparent;
        background: #7352a8;
    }

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

    .light .dt-per-page select {
        background-color: #fff;
        border-color: #e2e8f0;
        color: #475569;
    }

    .dt-empty {
        text-align: center;
        padding: 52px 20px;
        color: #475569;
    }

    .dt-empty i {
        font-size: 2.5rem;
        display: block;
        margin-bottom: 10px;
        opacity: .25;
    }

    .dt-empty p { font-size: .84rem; }

    .dt-bulk-bar {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        background: linear-gradient(135deg, rgba(124,58,237,.15), rgba(13,148,136,.1));
        border: 1px solid rgba(124,58,237,.3);
        border-radius: 10px;
        margin-bottom: 10px;
        flex-wrap: wrap;
    }

    .dt-bulk-count {
        font-size: .8rem;
        font-weight: 700;
        color: #a78bfa;
    }

    .light .dt-bulk-count { color: #7c3aed; }

    /* ── Order detail drawer ── */
    .order-drawer-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.65);
        backdrop-filter: blur(5px);
        z-index: 9997;
        opacity: 0;
        pointer-events: none;
        transition: opacity .25s;
    }

    .order-drawer-overlay.open {
        opacity: 1;
        pointer-events: all;
    }

    .order-drawer {
        position: fixed;
        top: 0;
        right: 0;
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

    .light .order-drawer {
        background: #fff;
        border-color: rgba(99,102,241,.15);
    }

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

    .drawer-row-val {
        color: #e2e8f0;
        font-weight: 600;
        text-align: right;
    }

    .light .drawer-row-val { color: #1e1b4b; }

    @media (max-width: 768px) {
        .dt-search { width: 160px; }
        .dt-search:focus { width: 200px; }
    }
</style>

<section id="page-transactions">

    <!-- PAGE HEADER -->
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px">
        <div>
            <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800;color:#f1f5f9">Transactions</h2>
            <p style="font-size:.82rem;color:#64748b;margin-top:3px">Manage and track all your transactions</p>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap">
            <button class="btn btn-ghost btn-sm" onclick="exportTransactionsCSV()">
                <i class="ri-download-2-line"></i> Export CSV
            </button>
        </div>
    </div>

    <!-- MAIN TABLE CARD -->
    <div class="card" style="padding:18px">

        <!-- Toolbar -->
        <div class="dt-toolbar">
            <div class="dt-toolbar-left">
                <div class="dt-search-wrap">
                    <i class="ri-search-line"></i>
                    <input class="dt-search" id="transactions-search"
                        placeholder="Search transactions…"
                        oninput="transactionsTable.search(this.value)">
                </div>
                <!-- Status filter chips -->
                <div style="display:flex;gap:5px;flex-wrap:wrap;align-items:center" id="transactions-filter-chips">
                    <button class="dt-filter-chip active" data-status="all"
                        onclick="transactionsTable.filterStatus('all', this)">
                        All <span class="chip-count" id="fc-all">0</span>
                    </button>
                    <button class="dt-filter-chip" data-status="pending"
                        onclick="transactionsTable.filterStatus('pending', this)">
                        <span class="dt-status-dot pending" style="width:5px;height:5px"></span>
                        Pending <span class="chip-count" id="fc-pending">0</span>
                    </button>
                    <button class="dt-filter-chip" data-status="completed"
                        onclick="transactionsTable.filterStatus('completed', this)">
                        <span class="dt-status-dot completed" style="width:5px;height:5px"></span>
                        Completed <span class="chip-count" id="fc-completed">0</span>
                    </button>
                </div>
            </div>
            <div class="dt-toolbar-right">
                <select class="inp" style="width:auto;min-width:130px;padding:7px 28px 7px 10px;font-size:.75rem"
                    onchange="transactionsTable.filterDate(this.value)">
                    <option value="all">All Time</option>
                    <option value="7">Last 7 Days</option>
                    <option value="30" selected>Last 30 Days</option>
                    <option value="90">Last 90 Days</option>
                </select>
            </div>
        </div>

        <!-- Bulk action bar -->
        <div class="dt-bulk-bar" id="transactions-bulk-bar" style="display:none">
            <i class="ri-checkbox-multiple-line" style="color:#a78bfa"></i>
            <span class="dt-bulk-count"><span id="transactions-bulk-count">0</span> transactions selected</span>
            <div style="margin-left:auto;display:flex;gap:6px">
                <button class="dt-action-btn" onclick="transactionsTable.bulkAction('export')">
                    <i class="ri-download-line"></i> Export
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="dt-table-wrap">
            <table class="dt-table" id="transactions-table">
                <thead>
                    <tr>
                        <th class="dt-cb-col">
                            <input type="checkbox" id="transactions-cb-all"
                                onchange="transactionsTable.toggleAll(this.checked)"
                                style="accent-color:#7c3aed;width:14px;height:14px;cursor:pointer">
                        </th>
                        <th onclick="transactionsTable.sort('txn_id', this)">Transaction ID <span class="dt-sort-icon">↕</span></th>
                        <th onclick="transactionsTable.sort('order_ref', this)">Order Ref <span class="dt-sort-icon">↕</span></th>
                        <th onclick="transactionsTable.sort('customer', this)">Customer <span class="dt-sort-icon">↕</span></th>
                        <th>Plan</th>
                        <th onclick="transactionsTable.sort('amount', this)">Amount <span class="dt-sort-icon">↕</span></th>
                        <th onclick="transactionsTable.sort('status', this)">Status <span class="dt-sort-icon">↕</span></th>
                        <th onclick="transactionsTable.sort('date', this)">Date <span class="dt-sort-icon">↕</span></th>
                        <th style="text-align:right">Actions</th>
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

<!-- ORDER DETAIL DRAWER -->
<div class="order-drawer-overlay" id="order-drawer-overlay"
    onclick="if(event.target===this) closeOrderDrawer()">
    <div class="order-drawer" id="order-drawer">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px">
            <div>
                <h2 class="font-jakarta" style="font-size:1.05rem;font-weight:800;color:#f1f5f9" id="drawer-order-id"></h2>
                <p style="font-size:.75rem;color:#64748b;margin-top:2px" id="drawer-order-date"></p>
            </div>
            <button onclick="closeOrderDrawer()"
                style="background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);color:#94a3b8;width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:.9rem;transition:all .2s;flex-shrink:0">
                <i class="ri-close-line"></i>
            </button>
        </div>
        <div id="drawer-content"></div>
    </div>
</div>

<script>
const ORDERS_DATA = @json($ordersData);

/* ─── DataTable IIFE ─────────────────────────────────────────── */
const transactionsTable = (function () {

    let data     = [...ORDERS_DATA];
    let filtered = [...data];
    let page     = 1;
    let perPage  = 10;
    let sortCol  = 'date';
    let sortDir  = 'desc';
    let statusFilt = 'all';
    let searchQ    = '';
    let dateFilt   = 'all';
    let selected   = new Set();

    /* ── init ── */
    function init() {
        updateCounts();
        applyFilters();
    }

    /* ── chip counts ── */
    function updateCounts() {
        const counts = { pending: 0, completed: 0 };
        data.forEach(r => { if (counts[r.status] !== undefined) counts[r.status]++; });

        document.getElementById('fc-all').textContent       = data.length;
        document.getElementById('fc-pending').textContent   = counts.pending;
        document.getElementById('fc-completed').textContent = counts.completed;
    }

    /* ── filter + sort ── */
    function applyFilters() {
        const cutoff = dateFilt !== 'all'
            ? new Date(Date.now() - (+dateFilt) * 86400000)
            : null;

        filtered = data.filter(r => {
            if (statusFilt !== 'all' && r.status !== statusFilt) return false;
            if (cutoff && new Date(r.date) < cutoff) return false;
            if (searchQ) {
                const q = searchQ.toLowerCase();
                const haystack = [
                    r.txn_id,
                    r.order_ref,
                    r.customer.name,
                    r.customer.email,
                    r.plan_name,
                ].join(' ').toLowerCase();
                if (!haystack.includes(q)) return false;
            }
            return true;
        });

        if (sortCol) {
            filtered.sort((a, b) => {
                let va, vb;
                switch (sortCol) {
                    case 'amount':
                        va = a.amount; vb = b.amount; break;
                    case 'date':
                        va = new Date(a.date).getTime();
                        vb = new Date(b.date).getTime(); break;
                    case 'customer':
                        va = a.customer.name; vb = b.customer.name; break;
                    default:
                        va = String(a[sortCol] ?? '');
                        vb = String(b[sortCol] ?? '');
                }
                if (va > vb) return sortDir === 'asc' ?  1 : -1;
                if (va < vb) return sortDir === 'asc' ? -1 :  1;
                return 0;
            });
        }

        page = 1;
        render();
    }

    /* ── render table body ── */
    function render() {
        const tbody = document.getElementById('transactions-tbody');
        const total = filtered.length;
        const pages = Math.max(1, Math.ceil(total / perPage));
        if (page > pages) page = pages;

        const start = (page - 1) * perPage;
        const slice = filtered.slice(start, start + perPage);

        if (!slice.length) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="9">
                        <div class="dt-empty">
                            <i class="ri-receipt-line"></i>
                            <p>No transactions found</p>
                        </div>
                    </td>
                </tr>`;
        } else {
            tbody.innerHTML = slice.map(rowHTML).join('');
        }

        renderPagination(total, pages);

        document.getElementById('transactions-info').innerHTML =
            `Showing <strong>${Math.min(start + 1, total)}–${Math.min(start + perPage, total)}</strong> of <strong>${total}</strong> transactions`;

        updateBulkBar();
    }

    /* ── row template ── */
    function rowHTML(r) {
        const statusLabel = { pending: 'Pending', completed: 'Completed' };

        // Build avatar initials from customer name
        const initials = r.customer.name
            .split(' ')
            .filter(Boolean)
            .map(w => w[0].toUpperCase())
            .slice(0, 2)
            .join('');

        // Escape txn_id for use in inline onclick (handle special chars)
        const safeId = r.txn_id.replace(/'/g, "\\'");

        return `
        <tr>
            <td class="dt-cb-col">
                <input type="checkbox"
                    ${selected.has(r.txn_id) ? 'checked' : ''}
                    onchange="transactionsTable.toggleRow('${safeId}', this.checked)"
                    style="accent-color:#7c3aed;width:14px;height:14px;cursor:pointer">
            </td>

            <td>
                <span class="dt-order-id">${escHtml(r.txn_id)}</span>
            </td>

            <td>
                <span class="dt-order-id" style="color:#0ea5e9">
                    ${escHtml(r.order_ref)}
                </span>
            </td>

            <td>
                <div class="dt-customer">
                    <div class="dt-avatar"
                        style="background:${r.customer.color}22;color:${r.customer.color}">
                        ${escHtml(initials || '?')}
                    </div>
                    <div class="dt-customer-info">
                        <div class="dt-customer-name">${escHtml(r.customer.name)}</div>
                        <div class="dt-customer-email">${escHtml(r.customer.email)}</div>
                    </div>
                </div>
            </td>

            <td>
                <div class="dt-items-wrap">
                    <span class="dt-item-tag">${escHtml(r.plan_name)}</span>
                </div>
            </td>

            <td>
                <div class="dt-amount">£${r.amount.toFixed(2)}</div>
                ${r.discount > 0
                    ? `<div class="dt-amount-sub">-£${r.discount.toFixed(2)} discount</div>`
                    : `<div class="dt-amount-sub">incl. VAT</div>`}
            </td>

            <td>
                <span class="dt-status ${r.status}">
                    <span class="dt-status-dot ${r.status}"></span>
                    ${statusLabel[r.status] ?? r.status}
                </span>
            </td>

            <td>${escHtml(r.dateStr)}</td>

            <td style="text-align:right">
                <button class="dt-row-btn" title="View details"
                    onclick="openOrderDrawer('${safeId}')">
                    <i class="ri-eye-line"></i>
                </button>
            </td>
        </tr>`;
    }

    /* ── pagination ── */
    function renderPagination(total, pages) {
        const pg = document.getElementById('transactions-pagination');
        let html = '';

        html += `<button class="dt-page-btn"
            onclick="transactionsTable.goPage(${page - 1})"
            ${page <= 1 ? 'disabled' : ''}>Prev</button>`;

        // Show at most 7 page buttons to avoid overflow
        const range = paginationRange(page, pages);
        range.forEach(i => {
            if (i === '…') {
                html += `<span class="dt-page-btn" style="cursor:default;opacity:.4">…</span>`;
            } else {
                html += `<button class="dt-page-btn ${i === page ? 'active' : ''}"
                    onclick="transactionsTable.goPage(${i})">${i}</button>`;
            }
        });

        html += `<button class="dt-page-btn"
            onclick="transactionsTable.goPage(${page + 1})"
            ${page >= pages ? 'disabled' : ''}>Next</button>`;

        pg.innerHTML = html;
    }

    function paginationRange(current, total) {
        if (total <= 7) return Array.from({ length: total }, (_, i) => i + 1);
        if (current <= 4) return [1, 2, 3, 4, 5, '…', total];
        if (current >= total - 3) return [1, '…', total-4, total-3, total-2, total-1, total];
        return [1, '…', current-1, current, current+1, '…', total];
    }

    /* ── bulk bar ── */
    function updateBulkBar() {
        const bar = document.getElementById('transactions-bulk-bar');
        document.getElementById('transactions-bulk-count').textContent = selected.size;
        bar.style.display = selected.size > 0 ? 'flex' : 'none';

        // sync header checkbox
        const allOnPage = filtered
            .slice((page-1)*perPage, page*perPage)
            .every(r => selected.has(r.txn_id));
        document.getElementById('transactions-cb-all').checked = allOnPage && filtered.length > 0;
    }

    /* ── HTML escape helper ── */
    function escHtml(str) {
        return String(str ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    /* ── public API ── */
    return {
        init,

        search(q) {
            searchQ = q.trim();
            applyFilters();
        },

        /**
         * filterStatus — receives the status string AND the clicked button element
         * so we can update the active chip highlight correctly.
         */
        filterStatus(s, btnEl) {
            statusFilt = s;
            // update chip active state
            document.querySelectorAll('#transactions-filter-chips .dt-filter-chip')
                .forEach(el => el.classList.toggle('active', el === btnEl));
            applyFilters();
        },

        filterDate(v) {
            dateFilt = v;
            applyFilters();
        },

        sort(col, thEl) {
            if (sortCol === col) {
                sortDir = sortDir === 'asc' ? 'desc' : 'asc';
            } else {
                sortCol = col;
                sortDir = 'asc';
            }
            // update header sort classes
            document.querySelectorAll('.dt-table thead th').forEach(th => {
                th.classList.remove('sorted-asc', 'sorted-desc');
            });
            if (thEl) thEl.classList.add('sorted-' + sortDir);
            applyFilters();
        },

        goPage(p) {
            const pages = Math.max(1, Math.ceil(filtered.length / perPage));
            if (p < 1 || p > pages) return;
            page = p;
            render();
        },

        setPerPage(n) {
            perPage = n;
            page = 1;
            render();
        },

        toggleAll(checked) {
            const start = (page - 1) * perPage;
            filtered.slice(start, start + perPage).forEach(r => {
                checked ? selected.add(r.txn_id) : selected.delete(r.txn_id);
            });
            render();
        },

        toggleRow(id, checked) {
            checked ? selected.add(id) : selected.delete(id);
            updateBulkBar();
        },

        bulkAction(action) {
            if (!selected.size) return;
            if (action === 'export') {
                const rows = data.filter(r => selected.has(r.txn_id));
                exportCSV(rows);
            }
        },

        getSelected() { return [...selected]; },
    };

})();

/* ─── CSV Export ─────────────────────────────────────────────── */
function exportCSV(rows) {
    rows = rows || ORDERS_DATA;
    const headers = ['Transaction ID', 'Order Ref', 'Customer', 'Email', 'Plan', 'Amount (£)', 'Discount (£)', 'Status', 'Date'];
    const lines = [
        headers.join(','),
        ...rows.map(r => [
            r.txn_id,
            r.order_ref,
            `"${r.customer.name.replace(/"/g, '""')}"`,
            r.customer.email,
            `"${r.plan_name.replace(/"/g, '""')}"`,
            r.amount.toFixed(2),
            r.discount.toFixed(2),
            r.status,
            r.dateStr,
        ].join(','))
    ];
    const blob = new Blob([lines.join('\n')], { type: 'text/csv' });
    const url  = URL.createObjectURL(blob);
    const a    = document.createElement('a');
    a.href     = url;
    a.download = `transactions_${new Date().toISOString().slice(0,10)}.csv`;
    a.click();
    URL.revokeObjectURL(url);
}

function exportTransactionsCSV() { exportCSV(ORDERS_DATA); }

/* ─── Drawer ─────────────────────────────────────────────────── */
function openOrderDrawer(txnId) {
    const o = ORDERS_DATA.find(r => r.txn_id === txnId);
    if (!o) return;

    document.getElementById('drawer-order-id').textContent  = o.txn_id;
    document.getElementById('drawer-order-date').textContent = 'Placed on ' + o.dateStr;

    const statusLabel = { pending: 'Pending', completed: 'Completed' };
    const statusColor = { pending: '#f59e0b', completed: '#10b981' };

    document.getElementById('drawer-content').innerHTML = `
        <div class="drawer-section">
            <div class="drawer-section-title">Customer</div>
            <div class="drawer-row">
                <span class="drawer-row-label">Name</span>
                <span class="drawer-row-val">${esc(o.customer.name)}</span>
            </div>
            <div class="drawer-row">
                <span class="drawer-row-label">Email</span>
                <span class="drawer-row-val">${esc(o.customer.email)}</span>
            </div>
        </div>

        <div class="drawer-section">
            <div class="drawer-section-title">Order Details</div>
            <div class="drawer-row">
                <span class="drawer-row-label">Order Ref</span>
                <span class="drawer-row-val" style="font-family:'DM Mono',monospace;color:#0ea5e9">${esc(o.order_ref)}</span>
            </div>
            <div class="drawer-row">
                <span class="drawer-row-label">Plan</span>
                <span class="drawer-row-val">${esc(o.plan_name)}</span>
            </div>
            <div class="drawer-row">
                <span class="drawer-row-label">Type</span>
                <span class="drawer-row-val">${esc(o.type)}</span>
            </div>
        </div>

        <div class="drawer-section">
            <div class="drawer-section-title">Payment</div>
            <div class="drawer-row">
                <span class="drawer-row-label">Amount</span>
                <span class="drawer-row-val" style="font-size:1rem;color:#f1f5f9">£${o.amount.toFixed(2)}</span>
            </div>
            ${o.discount > 0 ? `
            <div class="drawer-row">
                <span class="drawer-row-label">Discount</span>
                <span class="drawer-row-val" style="color:#10b981">-£${o.discount.toFixed(2)}</span>
            </div>
            ` : ''}
            <div class="drawer-row">
                <span class="drawer-row-label">Status</span>
                <span class="dt-status ${o.status}" style="font-size:.72rem">
                    <span class="dt-status-dot ${o.status}"></span>
                    ${statusLabel[o.status] ?? o.status}
                </span>
            </div>
            <div class="drawer-row">
                <span class="drawer-row-label">Date</span>
                <span class="drawer-row-val">${esc(o.dateStr)}</span>
            </div>
        </div>
    `;

    document.getElementById('order-drawer-overlay').classList.add('open');
    document.getElementById('order-drawer').classList.add('open');
}

function closeOrderDrawer() {
    document.getElementById('order-drawer-overlay').classList.remove('open');
    document.getElementById('order-drawer').classList.remove('open');
}

function esc(str) {
    return String(str ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

/* ─── Boot ───────────────────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', () => transactionsTable.init());
</script>
@endsection