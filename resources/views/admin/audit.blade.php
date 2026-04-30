@extends('admin.layouts.app')
@section('content')

<!-- ═══ AUDIT LOG ═══ -->
<section id="page-audit" class="page active">
    <div
        style="
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        "
    >
        <div>
            <h2 class="font-jakarta" style="font-size: 1.3rem; font-weight: 800">Audit Log</h2>
            <p style="font-size: 1.2re; color: var(--text3); margin-top: 3px">
                Complete record of admin and system actions
            </p>
        </div>
        <div style="display: flex; gap: 8px">
            <button class="btn btn-ghost btn-sm" onclick="toast('Audit log exported','success')">
                <i class="ri-download-2-line"></i> Export
            </button>
            <button
                class="btn btn-danger btn-sm"
                onclick="openConfirm('Clear all audit log entries?',()=>toast('Log cleared','warning'))"
            >
                <i class="ri-delete-bin-line"></i> Clear Log
            </button>
        </div>
    </div>
    <div class="card" style="padding: 14px; margin-bottom: 14px">
        <div style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center">
            <div class="search-box" style="flex: 1; min-width: 200px">
                <i class="ri-search-line" style="color: var(--text3); font-size: 0.85rem"></i
                ><input placeholder="Search log entries…" oninput="filterAudit(this.value)" />
            </div>
            <select
                class="inp"
                style="width: auto; min-width: 130px"
                id="audit-action-filter"
                onchange="filterAudit()"
            >
                <option value="all">All Actions</option>
                <option value="Create">Create</option>
                <option value="Update">Update</option>
                <option value="Delete">Delete</option>
                <option value="Login">Login</option>
            </select>
        </div>
    </div>
    <div class="card" style="padding: 18px">
        <div style="display: flex; flex-direction: column; gap: 8px" id="audit-list"></div>
        <div class="pg-wrap">
            <div class="pg-info">
                Showing <strong id="audit-showing">0</strong> of
                <strong id="audit-total">0</strong> entries
            </div>
            <div class="pg-btns" id="audit-pagination"></div>
        </div>
    </div>
</section>

@endsection