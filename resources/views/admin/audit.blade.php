@extends('admin.layouts.app')

@section('title', 'Audit Log')

@section('content')

<style>
/* ═══════════════════════════════════════════════════════════════
   AUDIT LOG — Premium Enterprise Styles
═══════════════════════════════════════════════════════════════ */
#loader{display: none;}
/* ── Page Header ── */
.audit-page-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 12px;
}
.audit-page-header h2 {
    font-size: 1.35rem;
    font-weight: 800;
    color: var(--text);
    margin: 0 0 4px;
    letter-spacing: -0.3px;
}
.audit-page-header p {
    font-size: 0.82rem;
    color: var(--text3);
    margin: 0;
}
.audit-header-actions {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

/* ── Filter Bar ── */
.audit-filter-card {
    padding: 14px 18px;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
}
.audit-filter-left {
    flex: 1;
    min-width: 220px;
    max-width: 340px;
}
.audit-filter-right {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    align-items: center;
}
.audit-search-wrap {
    position: relative;
    display: flex;
    align-items: center;
}
.audit-search-wrap i {
    position: absolute;
    left: 11px;
    color: var(--text3);
    font-size: 0.9rem;
    pointer-events: none;
}
.audit-search-wrap input {
    width: 100%;
    padding: 8px 12px 8px 34px;
    border: 1px solid var(--border, #e5e7eb);
    border-radius: 8px;
    font-size: 0.82rem;
    color: var(--text);
    background: var(--bg2, #f9fafb);
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.audit-search-wrap input:focus {
    border-color: var(--primary, #6366f1);
    box-shadow: 0 0 0 3px rgba(99,102,241,0.10);
    background: var(--card-bg, #fff);
}
.audit-select {
    padding: 8px 32px 8px 12px;
    border: 1px solid var(--border, #e5e7eb);
    border-radius: 8px;
    font-size: 0.80rem;
    color: var(--text);
    background: var(--bg2, #f9fafb);
    outline: none;
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 10px center;
    transition: border-color 0.2s, box-shadow 0.2s;
    min-width: 130px;
}
.audit-select:focus {
    border-color: var(--primary, #6366f1);
    box-shadow: 0 0 0 3px rgba(99,102,241,0.10);
}

/* ── Table Card ── */
.audit-table-card {
    padding: 0;
    overflow: hidden;
}
.audit-table-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px 14px;
    border-bottom: 1px solid var(--border, #e5e7eb);
    flex-wrap: wrap;
    gap: 10px;
}
.audit-table-toolbar-left {
    display: flex;
    align-items: center;
    gap: 10px;
}
.audit-entry-count {
    font-size: 0.78rem;
    color: var(--text3);
    font-weight: 500;
}
.audit-entry-count strong {
    color: var(--text);
    font-weight: 700;
}

/* ── Export Dropdown ── */
.export-dropdown-wrap {
    position: relative;
}
.export-dropdown-menu {
    position: absolute;
    top: calc(100% + 6px);
    right: 0;
    background: var(--card-bg, #fff);
    border: 1px solid var(--border, #e5e7eb);
    border-radius: 10px;
    box-shadow: 0 8px 28px rgba(0,0,0,0.10);
    min-width: 150px;
    z-index: 200;
    overflow: hidden;
    display: none;
    animation: fadeDropdown 0.15s ease;
}
.export-dropdown-menu.open { display: block; }
@keyframes fadeDropdown {
    from { opacity: 0; transform: translateY(-6px); }
    to   { opacity: 1; transform: translateY(0); }
}
.export-dropdown-menu a {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 10px 16px;
    font-size: 0.80rem;
    color: var(--text);
    text-decoration: none;
    transition: background 0.15s;
    cursor: pointer;
}
.export-dropdown-menu a:hover {
    background: var(--bg2, #f9fafb);
}
.export-dropdown-menu a i {
    font-size: 0.9rem;
    color: var(--text3);
}

/* ── Table Scroll Wrapper ── */
.audit-table-scroll {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}
.audit-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 860px;
}
.audit-table thead th {
    position: sticky;
    top: 0;
    background: var(--bg2, #f9fafb);
    z-index: 10;
    padding: 11px 16px;
    text-align: left;
    font-size: 0.72rem;
    font-weight: 700;
    color: var(--text3);
    text-transform: uppercase;
    letter-spacing: 0.6px;
    border-bottom: 1px solid var(--border, #e5e7eb);
    white-space: nowrap;
    user-select: none;
}
.audit-table thead th:first-child { padding-left: 20px; }
.audit-table thead th:last-child  { padding-right: 20px; text-align: center; }

.audit-table tbody tr {
    border-bottom: 1px solid var(--border, #e5e7eb);
    transition: background 0.15s;
    cursor: default;
}
.audit-table tbody tr:last-child { border-bottom: none; }
.audit-table tbody tr:hover { background: var(--bg2, #f9fafb); }

.audit-table tbody td {
    padding: 13px 16px;
    font-size: 0.81rem;
    color: var(--text);
    vertical-align: middle;
    white-space: nowrap;
}
.audit-table tbody td:first-child { padding-left: 20px; }
.audit-table tbody td:last-child  { padding-right: 20px; text-align: center; }

/* S.No */
.audit-sno {
    font-size: 0.74rem;
    color: var(--text3);
    font-weight: 600;
    font-variant-numeric: tabular-nums;
}

/* Date & Time */
.audit-datetime-date {
    font-size: 0.80rem;
    font-weight: 600;
    color: var(--text);
}
.audit-datetime-time {
    font-size: 0.72rem;
    color: var(--text3);
    margin-top: 2px;
}

/* Event Badges */
.audit-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.70rem;
    font-weight: 700;
    letter-spacing: 0.3px;
    white-space: nowrap;
}
.audit-badge i { font-size: 0.72rem; }
.badge-created  { background: #dcfce7; color: #16a34a; }
.badge-updated  { background: #fef3c7; color: #d97706; }
.badge-deleted  { background: #fee2e2; color: #dc2626; }
.badge-login    { background: #dbeafe; color: #2563eb; }
.badge-logout   { background: #f3f4f6; color: #6b7280; }
.badge-exported { background: #ede9fe; color: #7c3aed; }
.badge-settings { background: #e0f2fe; color: #0284c7; }

/* User Avatar Column */
.audit-user-cell {
    display: flex;
    align-items: center;
    gap: 10px;
}
.audit-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.68rem;
    font-weight: 800;
    flex-shrink: 0;
    letter-spacing: 0.3px;
}
.audit-user-name {
    font-size: 0.80rem;
    font-weight: 600;
    color: var(--text);
    line-height: 1.2;
}
.audit-user-role {
    font-size: 0.68rem;
    color: var(--text3);
    margin-top: 1px;
}

/* Module chip */
.audit-module {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 3px 10px;
    border-radius: 6px;
    font-size: 0.72rem;
    font-weight: 600;
    background: var(--bg2, #f3f4f6);
    color: var(--text2, #374151);
    border: 1px solid var(--border, #e5e7eb);
}

/* Changes summary */
.audit-changes {
    font-size: 0.78rem;
    color: var(--text2);
    font-weight: 500;
}

/* IP Address */
.audit-ip {
    font-family: 'JetBrains Mono', 'Courier New', monospace;
    font-size: 0.74rem;
    color: var(--text3);
    letter-spacing: 0.2px;
}

/* View Details Button */
.btn-view-details {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: 1px solid var(--border, #e5e7eb);
    background: transparent;
    color: var(--text3);
    cursor: pointer;
    transition: all 0.18s;
    font-size: 0.9rem;
    text-decoration: none;
}
.btn-view-details:hover {
    background: var(--primary, #6366f1);
    border-color: var(--primary, #6366f1);
    color: #fff;
    box-shadow: 0 4px 12px rgba(99,102,241,0.25);
    transform: translateY(-1px);
}

/* ── Pagination ── */
.audit-pagination-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 20px;
    border-top: 1px solid var(--border, #e5e7eb);
    flex-wrap: wrap;
    gap: 10px;
}
.audit-page-info {
    font-size: 0.78rem;
    color: var(--text3);
}
.audit-page-info strong { color: var(--text); }
.audit-page-btns {
    display: flex;
    gap: 4px;
    align-items: center;
}
.pg-btn {
    min-width: 32px;
    height: 32px;
    padding: 0 6px;
    border-radius: 7px;
    border: 1px solid var(--border, #e5e7eb);
    background: transparent;
    color: var(--text);
    font-size: 0.78rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
.pg-btn:hover:not(:disabled) {
    background: var(--primary, #6366f1);
    border-color: var(--primary, #6366f1);
    color: #fff;
}
.pg-btn.active {
    background: var(--primary, #6366f1);
    border-color: var(--primary, #6366f1);
    color: #fff;
}
.pg-btn:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}

/* ── Empty State ── */
.audit-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 72px 20px;
    text-align: center;
}
.audit-empty-icon {
    width: 72px;
    height: 72px;
    border-radius: 18px;
    background: var(--bg2, #f3f4f6);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 18px;
    font-size: 2rem;
    color: var(--text3);
}
.audit-empty h3 {
    font-size: 1rem;
    font-weight: 700;
    color: var(--text);
    margin: 0 0 6px;
}
.audit-empty p {
    font-size: 0.82rem;
    color: var(--text3);
    margin: 0;
    max-width: 300px;
}

/* ══════════════════════════════════════════════
   MODAL
══════════════════════════════════════════════ */
.audit-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.45);
    backdrop-filter: blur(4px);
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.22s ease;
}
.audit-modal-overlay.open {
    opacity: 1;
    pointer-events: all;
}
.audit-modal {
    background: var(--card-bg, #fff);
    border-radius: 16px;
    width: 100%;
    max-width: 760px;
    max-height: 90vh;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    box-shadow: 0 24px 64px rgba(0,0,0,0.18);
    transform: scale(0.95) translateY(10px);
    transition: transform 0.22s ease;
}
.audit-modal-overlay.open .audit-modal {
    transform: scale(1) translateY(0);
}

.audit-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 24px;
    border-bottom: 1px solid var(--border, #e5e7eb);
    flex-shrink: 0;
}
.audit-modal-header-left {
    display: flex;
    align-items: center;
    gap: 12px;
}
.audit-modal-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
}
.audit-modal-title {
    font-size: 1rem;
    font-weight: 800;
    color: var(--text);
    margin: 0 0 2px;
}
.audit-modal-subtitle {
    font-size: 0.74rem;
    color: var(--text3);
    margin: 0;
}
.audit-modal-close {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: 1px solid var(--border, #e5e7eb);
    background: transparent;
    color: var(--text3);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    transition: all 0.15s;
    flex-shrink: 0;
}
.audit-modal-close:hover {
    background: #fee2e2;
    border-color: #fecaca;
    color: #dc2626;
}

.audit-modal-body {
    overflow-y: auto;
    padding: 24px;
    flex: 1;
}

/* Meta Info Grid */
.audit-meta-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 12px;
    margin-bottom: 24px;
}
.audit-meta-item {
    background: var(--bg2, #f9fafb);
    border: 1px solid var(--border, #e5e7eb);
    border-radius: 10px;
    padding: 12px 14px;
}
.audit-meta-label {
    font-size: 0.68rem;
    font-weight: 700;
    color: var(--text3);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 5px;
}
.audit-meta-value {
    font-size: 0.82rem;
    font-weight: 600;
    color: var(--text);
}

/* Changes Comparison */
.audit-changes-section h4 {
    font-size: 0.80rem;
    font-weight: 700;
    color: var(--text);
    margin: 0 0 12px;
    display: flex;
    align-items: center;
    gap: 7px;
}
.audit-changes-section h4::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--border, #e5e7eb);
}
.audit-changes-table {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid var(--border, #e5e7eb);
    border-radius: 10px;
    overflow: hidden;
    font-size: 0.80rem;
}
.audit-changes-table thead th {
    padding: 9px 14px;
    background: var(--bg2, #f9fafb);
    font-size: 0.70rem;
    font-weight: 700;
    color: var(--text3);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    text-align: left;
    border-bottom: 1px solid var(--border, #e5e7eb);
}
.audit-changes-table tbody tr {
    border-bottom: 1px solid var(--border, #e5e7eb);
    transition: background 0.15s;
}
.audit-changes-table tbody tr:last-child { border-bottom: none; }
.audit-changes-table tbody tr:hover { background: var(--bg2, #f9fafb); }
.audit-changes-table tbody td {
    padding: 10px 14px;
    vertical-align: middle;
}
.change-field {
    font-weight: 700;
    color: var(--text);
    font-size: 0.78rem;
}
.change-old {
    background: #fee2e2;
    color: #b91c1c;
    padding: 3px 8px;
    border-radius: 5px;
    font-size: 0.76rem;
    font-weight: 500;
    display: inline-block;
    text-decoration: line-through;
    opacity: 0.85;
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.change-new {
    background: #dcfce7;
    color: #15803d;
    padding: 3px 8px;
    border-radius: 5px;
    font-size: 0.76rem;
    font-weight: 600;
    display: inline-block;
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.change-added {
    background: #dcfce7;
    color: #15803d;
    padding: 3px 8px;
    border-radius: 5px;
    font-size: 0.76rem;
    font-weight: 600;
    display: inline-block;
}
.change-removed {
    background: #fee2e2;
    color: #b91c1c;
    padding: 3px 8px;
    border-radius: 5px;
    font-size: 0.76rem;
    font-weight: 600;
    display: inline-block;
    text-decoration: line-through;
    opacity: 0.8;
}
.change-arrow {
    color: var(--text3);
    font-size: 0.75rem;
    padding: 0 4px;
}
.change-na {
    color: var(--text3);
    font-size: 0.75rem;
    font-style: italic;
}

.audit-modal-footer {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    padding: 16px 24px;
    border-top: 1px solid var(--border, #e5e7eb);
    gap: 8px;
    flex-shrink: 0;
}

/* ── Responsive ── */
@media (max-width: 640px) {
    .audit-filter-card { flex-direction: column; }
    .audit-filter-left { max-width: 100%; }
    .audit-filter-right { width: 100%; }
    .audit-select { flex: 1; }
    .audit-meta-grid { grid-template-columns: 1fr 1fr; }
}
</style>

<!-- ═══════════════════════════════════════════════════
     AUDIT LOG PAGE
═══════════════════════════════════════════════════ -->
<section id="page-audit" class="page active">

    <!-- ── Page Header ── -->
    <div class="audit-page-header">
        <div>
            <h2 class="font-jakarta">Audit Log</h2>
            <p>Complete record of admin and system actions</p>
        </div>
        <div class="audit-header-actions">
            <!-- Export Dropdown -->
            <div class="export-dropdown-wrap">
                <button class="btn btn-ghost btn-sm" id="exportDropBtn" onclick="toggleExportDropdown(event)">
                    <i class="ri-download-2-line"></i> Export
                    <i class="ri-arrow-down-s-line" style="margin-left:2px;"></i>
                </button>
                <div class="export-dropdown-menu" id="exportDropMenu">
                    <a onclick="handleExport('csv')">
                        <i class="ri-file-text-line"></i> Export CSV
                    </a>
                    <a onclick="handleExport('excel')">
                        <i class="ri-file-excel-2-line"></i> Export Excel
                    </a>
                    <a onclick="handleExport('pdf')">
                        <i class="ri-file-pdf-line"></i> Export PDF
                    </a>
                    <a onclick="handleExport('print')">
                        <i class="ri-printer-line"></i> Print
                    </a>
                </div>
            </div>
            <!-- Clear Log -->
            <button class="btn btn-danger btn-sm"
                onclick="confirmClearLog()">
                <i class="ri-delete-bin-line"></i> Clear Log
            </button>
        </div>
    </div>

    <!-- ── Filter Bar ── -->
    <div class="card audit-filter-card">
        <div class="audit-filter-left">
            <div class="audit-search-wrap">
                <i class="ri-search-line"></i>
                <input
                    type="text"
                    id="auditSearchInput"
                    placeholder="Search by user, module, event, IP…"
                    oninput="handleAuditSearch()"
                    autocomplete="off"
                />
            </div>
        </div>
        <div class="audit-filter-right">
            <select class="audit-select" id="auditEventFilter" onchange="handleAuditSearch()">
                <option value="">All Events</option>
                <option value="Created">Created</option>
                <option value="Updated">Updated</option>
                <option value="Deleted">Deleted</option>
                <option value="Login">Login</option>
                <option value="Logout">Logout</option>
                <option value="Exported">Exported</option>
                <option value="Settings">Settings</option>
            </select>
            <select class="audit-select" id="auditUserFilter" onchange="handleAuditSearch()">
                <option value="">All Users</option>
                <option value="Vijay">Vijay</option>
                <option value="Swetha">Swetha</option>
                <option value="Arjun">Arjun</option>
                <option value="Priya">Priya</option>
                <option value="System">System</option>
            </select>
            <select class="audit-select" id="auditDateFilter" onchange="handleAuditSearch()">
                <option value="">All Time</option>
                <option value="today">Today</option>
                <option value="week">This Week</option>
                <option value="month">This Month</option>
            </select>
        </div>
    </div>

    <!-- ── Table Card ── -->
    <div class="card audit-table-card">

        <!-- Toolbar -->
        <div class="audit-table-toolbar">
            <div class="audit-table-toolbar-left">
                <span class="audit-entry-count">
                    Showing <strong id="auditShowingStart">1</strong>–<strong id="auditShowingEnd">10</strong>
                    of <strong id="auditTotalCount">10</strong> entries
                </span>
            </div>
            <div style="display:flex;gap:6px;align-items:center;">
                <span style="font-size:0.74rem;color:var(--text3);">Rows per page:</span>
                <select class="audit-select" id="auditPerPageSelect"
                    onchange="handlePerPageChange()" style="min-width:70px;padding:5px 28px 5px 10px;">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
        </div>

        <!-- Table -->
        <div class="audit-table-scroll">
            <table class="audit-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date & Time</th>
                        <th>Event</th>
                        <th>User</th>
                        <th>Module</th>
                        <th>Changes</th>
                        <th>IP Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="auditTableBody">
                    <!-- Rendered by JS -->
                </tbody>
            </table>
            <!-- Empty State -->
            <div class="audit-empty" id="auditEmptyState" style="display:none;">
                <div class="audit-empty-icon">
                    <i class="ri-file-search-line"></i>
                </div>
                <h3>No Audit Logs Found</h3>
                <p>System activities will appear here once actions are performed. Try adjusting your filters.</p>
            </div>
        </div>

        <!-- Pagination -->
        <div class="audit-pagination-bar">
            <div class="audit-page-info" id="auditPageInfo">Page 1 of 1</div>
            <div class="audit-page-btns" id="auditPageBtns"></div>
        </div>
    </div>

</section>

<!-- ═══════════════════════════════════════════════════
     VIEW DETAILS MODAL
═══════════════════════════════════════════════════ -->
<div class="audit-modal-overlay" id="auditModalOverlay" onclick="closeAuditModal(event)">
    <div class="audit-modal" id="auditModal">

        <!-- Modal Header -->
        <div class="audit-modal-header">
            <div class="audit-modal-header-left">
                <div class="audit-modal-icon" id="modalIcon">
                    <i class="ri-file-list-3-line"></i>
                </div>
                <div>
                    <p class="audit-modal-title">Audit Details</p>
                    <p class="audit-modal-subtitle" id="modalSubtitle">Event record information</p>
                </div>
            </div>
            <button class="audit-modal-close" onclick="closeAuditModalDirect()">
                <i class="ri-close-line"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="audit-modal-body">

            <!-- Meta Grid -->
            <div class="audit-meta-grid" id="modalMetaGrid">
                <!-- Rendered by JS -->
            </div>

            <!-- Changes Section -->
            <div class="audit-changes-section">
                <h4><i class="ri-git-diff-line" style="color:var(--primary,#6366f1)"></i> Field Changes</h4>
                <table class="audit-changes-table">
                    <thead>
                        <tr>
                            <th>Field</th>
                            <th>Old Value</th>
                            <th></th>
                            <th>New Value</th>
                        </tr>
                    </thead>
                    <tbody id="modalChangesBody">
                        <!-- Rendered by JS -->
                    </tbody>
                </table>
            </div>

        </div>

        <!-- Modal Footer -->
        <div class="audit-modal-footer">
            <button class="btn btn-ghost btn-sm" onclick="closeAuditModalDirect()">
                <i class="ri-close-line"></i> Close
            </button>
            <button class="btn btn-ghost btn-sm" onclick="printAuditRecord()">
                <i class="ri-printer-line"></i> Print Record
            </button>
        </div>
    </div>
</div>

<script>
/* ════════════════════════════════════════════════════
   AUDIT LOG — API-Driven JavaScript
════════════════════════════════════════════════════ */

/* ── State ── */
let AUDIT_DATA       = [];
let auditCurrentPage = 1;
let auditPerPage     = 10;
let auditTotalRows   = 0;
let auditTotalPages  = 1;
let auditSearchTimer = null;

/* ── Badge Config ── */
const BADGE_CONFIG = {
    'Created':  { class: 'badge-created',  icon: 'ri-add-circle-line' },
    'Updated':  { class: 'badge-updated',  icon: 'ri-edit-line' },
    'Deleted':  { class: 'badge-deleted',  icon: 'ri-delete-bin-line' },
    'Login':    { class: 'badge-login',    icon: 'ri-login-circle-line' },
    'Logout':   { class: 'badge-logout',   icon: 'ri-logout-circle-line' },
    'Exported': { class: 'badge-exported', icon: 'ri-download-line' },
    'Settings': { class: 'badge-settings', icon: 'ri-settings-3-line' },
};

/* ══════════════════════════════════════
   FETCH FROM SERVER
══════════════════════════════════════ */
function fetchAuditData() {
    const search = (document.getElementById('auditSearchInput').value || '').trim();
    const event  = document.getElementById('auditEventFilter').value;
    const user   = document.getElementById('auditUserFilter').value;
    const date   = document.getElementById('auditDateFilter').value;

    const params = new URLSearchParams({
        page:     auditCurrentPage,
        per_page: auditPerPage,
        search:   search,
        event:    event,
        user:     user,
        date:     date,
    });

    fetch(`/admin/audit-log/fetch?${params}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(function(response) {
        if (!response.ok) throw new Error('Network error');
        return response.json();
    })
    .then(function(res) {
        AUDIT_DATA      = res.data;
        auditTotalRows  = res.total;
        auditTotalPages = res.last_page;

        document.getElementById('auditShowingStart').textContent = res.from || 0;
        document.getElementById('auditShowingEnd').textContent   = res.to   || 0;
        document.getElementById('auditTotalCount').textContent   = res.total;
        document.getElementById('auditPageInfo').textContent     = `Page ${res.current_page} of ${res.last_page}`;

        renderAuditRows(res.data, res.from || 1);
        renderPagination(res.total, res.last_page);
    })
    .catch(function(err) {
        console.error('Audit fetch error:', err);
    });
}

/* ══════════════════════════════════════
   RENDER TABLE ROWS
══════════════════════════════════════ */
function renderAuditRows(data, fromIndex) {
    const tbody = document.getElementById('auditTableBody');
    const empty = document.getElementById('auditEmptyState');

    if (!data || data.length === 0) {
        tbody.innerHTML = '';
        empty.style.display = 'flex';
        return;
    }
    empty.style.display = 'none';

    tbody.innerHTML = data.map(function(row, idx) {
        const sno   = (fromIndex || 1) + idx;
        const badge = BADGE_CONFIG[row.event] || { class: 'badge-logout', icon: 'ri-information-line' };
        return `
        <tr>
            <td><span class="audit-sno">${sno}</span></td>
            <td>
                <div class="audit-datetime-date">${formatDate(row.date)}</div>
                <div class="audit-datetime-time">${row.time}</div>
            </td>
            <td>
                <span class="audit-badge ${badge.class}">
                    <i class="${badge.icon}"></i>
                    ${row.event}
                </span>
            </td>
            <td>
                <div class="audit-user-cell">
                    <div class="audit-avatar" style="background:${row.user.bg};color:${row.user.color};">
                        ${row.user.initials}
                    </div>
                    <div>
                        <div class="audit-user-name">${row.user.name}</div>
                        <div class="audit-user-role">${row.user.role}</div>
                    </div>
                </div>
            </td>
            <td>
                <span class="audit-module">
                    <i class="${row.moduleIcon}" style="color:var(--primary,#6366f1);"></i>
                    ${row.module}
                </span>
            </td>
            <td><span class="audit-changes">${row.changes}</span></td>
            <td><span class="audit-ip">${row.ip}</span></td>
            <td>
                <button class="btn-view-details" onclick="openAuditModal(${row.id})" title="View Details">
                    <i class="ri-eye-line"></i>
                </button>
            </td>
        </tr>`;
    }).join('');
}

/* ── Format Date ── */
function formatDate(d) {
    const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    const parts  = d.split('-');
    return `${months[parseInt(parts[1]) - 1]} ${parseInt(parts[2])}, ${parts[0]}`;
}

/* ══════════════════════════════════════
   PAGINATION
══════════════════════════════════════ */
function renderPagination(total, pages) {
    const container = document.getElementById('auditPageBtns');
    if (total === 0) { container.innerHTML = ''; return; }

    let html = `
        <button class="pg-btn" onclick="setAuditPage(${auditCurrentPage - 1})"
            ${auditCurrentPage === 1 ? 'disabled' : ''}>
            <i class="ri-arrow-left-s-line"></i>
        </button>`;

    buildPageRange(auditCurrentPage, pages).forEach(function(p) {
        if (p === '…') {
            html += `<button class="pg-btn" disabled style="border:none;cursor:default;opacity:0.5;">…</button>`;
        } else {
            html += `<button class="pg-btn ${p === auditCurrentPage ? 'active' : ''}"
                onclick="setAuditPage(${p})">${p}</button>`;
        }
    });

    html += `
        <button class="pg-btn" onclick="setAuditPage(${auditCurrentPage + 1})"
            ${auditCurrentPage === pages ? 'disabled' : ''}>
            <i class="ri-arrow-right-s-line"></i>
        </button>`;

    container.innerHTML = html;
}

function buildPageRange(current, total) {
    if (total <= 7) return Array.from({ length: total }, function(_, i) { return i + 1; });
    const pages = [];
    if (current <= 4) {
        pages.push(1, 2, 3, 4, 5, '…', total);
    } else if (current >= total - 3) {
        pages.push(1, '…', total-4, total-3, total-2, total-1, total);
    } else {
        pages.push(1, '…', current-1, current, current+1, '…', total);
    }
    return pages;
}

function setAuditPage(p) {
    if (p < 1 || p > auditTotalPages) return;
    auditCurrentPage = p;
    fetchAuditData();
}

/* ══════════════════════════════════════
   SEARCH & FILTER
══════════════════════════════════════ */
function handleAuditSearch() {
    clearTimeout(auditSearchTimer);
    auditSearchTimer = setTimeout(function() {
        auditCurrentPage = 1;
        fetchAuditData();
    }, 300);
}

function handlePerPageChange() {
    auditPerPage     = parseInt(document.getElementById('auditPerPageSelect').value);
    auditCurrentPage = 1;
    fetchAuditData();
}

/* ══════════════════════════════════════
   MODAL
══════════════════════════════════════ */
function openAuditModal(id) {
    const row = AUDIT_DATA.find(function(r) { return r.id === id; });
    if (!row) return;

    const badge  = BADGE_CONFIG[row.event] || { class: 'badge-logout', icon: 'ri-information-line' };
    const colors = {
        'Created':  { bg: '#dcfce7', color: '#16a34a' },
        'Updated':  { bg: '#fef3c7', color: '#d97706' },
        'Deleted':  { bg: '#fee2e2', color: '#dc2626' },
        'Login':    { bg: '#dbeafe', color: '#2563eb' },
        'Logout':   { bg: '#f3f4f6', color: '#6b7280' },
        'Exported': { bg: '#ede9fe', color: '#7c3aed' },
        'Settings': { bg: '#e0f2fe', color: '#0284c7' },
    };
    const col = colors[row.event] || { bg: '#f3f4f6', color: '#6b7280' };

    // Modal icon
    const iconEl        = document.getElementById('modalIcon');
    iconEl.style.background = col.bg;
    iconEl.style.color      = col.color;
    iconEl.innerHTML        = `<i class="${badge.icon}" style="font-size:1.1rem;"></i>`;

    // Subtitle
    document.getElementById('modalSubtitle').textContent =
        `${row.event} event · ${formatDate(row.date)} at ${row.time}`;

    // Meta Grid
    document.getElementById('modalMetaGrid').innerHTML = `
        <div class="audit-meta-item">
            <div class="audit-meta-label">Event Type</div>
            <div class="audit-meta-value">
                <span class="audit-badge ${badge.class}" style="font-size:0.72rem;">
                    <i class="${badge.icon}"></i> ${row.event}
                </span>
            </div>
        </div>
        <div class="audit-meta-item">
            <div class="audit-meta-label">Performed By</div>
            <div class="audit-meta-value" style="display:flex;align-items:center;gap:8px;">
                <div class="audit-avatar" style="background:${row.user.bg};color:${row.user.color};width:26px;height:26px;font-size:0.62rem;">
                    ${row.user.initials}
                </div>
                <div>
                    <div style="font-size:0.80rem;font-weight:700;">${row.user.name}</div>
                    <div style="font-size:0.68rem;color:var(--text3);">${row.user.role}</div>
                </div>
            </div>
        </div>
        <div class="audit-meta-item">
            <div class="audit-meta-label">Date & Time</div>
            <div class="audit-meta-value">${formatDate(row.date)}</div>
            <div style="font-size:0.72rem;color:var(--text3);margin-top:2px;">${row.time}</div>
        </div>
        <div class="audit-meta-item">
            <div class="audit-meta-label">Module</div>
            <div class="audit-meta-value">
                <span class="audit-module">
                    <i class="${row.moduleIcon}" style="color:var(--primary,#6366f1);"></i>
                    ${row.module}
                </span>
            </div>
        </div>
        <div class="audit-meta-item">
            <div class="audit-meta-label">IP Address</div>
            <div class="audit-meta-value audit-ip" style="font-size:0.80rem;">${row.ip}</div>
        </div>
        <div class="audit-meta-item">
            <div class="audit-meta-label">Changes Summary</div>
            <div class="audit-meta-value">${row.changes}</div>
        </div>
    `;

    // Changes Table
    document.getElementById('modalChangesBody').innerHTML =
        row.details.fields.map(function(f) {
            let oldCell, newCell;
            if (f.old === null && f.newVal !== null) {
                oldCell = `<span class="change-na">— None —</span>`;
                newCell = `<span class="change-added">${escHtml(f.newVal)}</span>`;
            } else if (f.old !== null && f.newVal === null) {
                oldCell = `<span class="change-removed">${escHtml(f.old)}</span>`;
                newCell = `<span class="change-na">— Removed —</span>`;
            } else {
                oldCell = `<span class="change-old">${escHtml(f.old)}</span>`;
                newCell = `<span class="change-new">${escHtml(f.newVal)}</span>`;
            }
            return `
            <tr>
                <td><span class="change-field">${escHtml(f.field)}</span></td>
                <td>${oldCell}</td>
                <td class="change-arrow"><i class="ri-arrow-right-line"></i></td>
                <td>${newCell}</td>
            </tr>`;
        }).join('');

    document.getElementById('auditModalOverlay').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeAuditModal(e) {
    if (e.target === document.getElementById('auditModalOverlay')) {
        closeAuditModalDirect();
    }
}

function closeAuditModalDirect() {
    document.getElementById('auditModalOverlay').classList.remove('open');
    document.body.style.overflow = '';
}

function escHtml(str) {
    if (!str) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

function printAuditRecord() {
    window.print();
}

/* ══════════════════════════════════════
   EXPORT DROPDOWN
══════════════════════════════════════ */
function toggleExportDropdown(e) {
    e.stopPropagation();
    document.getElementById('exportDropMenu').classList.toggle('open');
}

document.addEventListener('click', function() {
    const m = document.getElementById('exportDropMenu');
    if (m) m.classList.remove('open');
});

function handleExport(type) {
    document.getElementById('exportDropMenu').classList.remove('open');
    const labels = { csv: 'CSV', excel: 'Excel', pdf: 'PDF', print: 'Print' };
    if (typeof toast === 'function') {
        toast(`Exporting as ${labels[type]}…`, 'success');
    }
    if (type === 'print') window.print();
}

/* ══════════════════════════════════════
   CLEAR LOG
══════════════════════════════════════ */
function confirmClearLog() {
    const doDelete = function() {
        fetch('/admin/audit-log/clear', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN':     document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(function(r) { return r.json(); })
        .then(function(res) {
            if (res.status) {
                auditCurrentPage = 1;
                fetchAuditData();
                if (typeof toast === 'function') toast('Audit log cleared', 'warning');
            }
        });
    };

    if (typeof openConfirm === 'function') {
        openConfirm('Clear all audit log entries? This cannot be undone.', doDelete);
    } else if (confirm('Clear all audit log entries? This cannot be undone.')) {
        doDelete();
    }
}

/* ══════════════════════════════════════
   KEYBOARD
══════════════════════════════════════ */
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeAuditModalDirect();
});

/* ── Init ── */
document.addEventListener('DOMContentLoaded', function() {
    fetchAuditData();
});
</script>

@endsection