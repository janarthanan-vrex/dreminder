@extends('admin.layouts.app')
@section('content')
<!-- ═══ STAFF ═══ -->
<section id="page-staff" class="page active">
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
            <h2 class="font-jakarta" style="font-size: 1.3rem; font-weight: 800">
                Staff Management
            </h2>
            <p style="font-size: 1.2re; color: var(--text3); margin-top: 3px">
                Manage your team members and assignments
            </p>
        </div>
        <button class="btn btn-primary btn-sm" onclick="openModal('add-staff-modal')">
            <i class="ri-user-add-line"></i> Add Staff
        </button>
    </div>
    <div class="g4" style="margin-bottom: 20px">
        <div class="stat-card">
            <div class="stat-ico" style="background: rgba(124, 58, 237, 0.15)">
                <i class="ri-team-line" style="color: var(--purple-light)"></i>
            </div>
            <div class="stat-num" id="staff-count-total">8</div>
            <div class="stat-lbl">Total Staff</div>
        </div>
        <div class="stat-card">
            <div class="stat-ico" style="background: rgba(16, 185, 129, 0.12)">
                <i class="ri-user-follow-line" style="color: var(--green)"></i>
            </div>
            <div class="stat-num" style="color: var(--green)" id="staff-count-active">7</div>
            <div class="stat-lbl">Active</div>
        </div>
        <div class="stat-card">
            <div class="stat-ico" style="background: rgba(244, 63, 94, 0.12)">
                <i class="ri-user-unfollow-line" style="color: var(--red)"></i>
            </div>
            <div class="stat-num" style="color: var(--red)" id="staff-count-inactive">1</div>
            <div class="stat-lbl">Inactive</div>
        </div>
        <div class="stat-card">
            <div class="stat-ico" style="background: rgba(245, 158, 11, 0.12)">
                <i class="ri-key-2-line" style="color: var(--amber)"></i>
            </div>
            <div class="stat-num">4</div>
            <div class="stat-lbl">Roles Assigned</div>
        </div>
    </div>
    <div class="card" style="padding: 18px">
        <div
            style="
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 14px;
            "
        >
            <div class="section-title" style="margin: 0">Team Members</div>
            <div class="search-box" style="width: 200px">
                <i class="ri-search-line" style="color: var(--text3); font-size: 0.85rem"></i
                ><input placeholder="Search staff…" oninput="filterStaff(this.value)" />
            </div>
        </div>
        <div style="overflow-x: auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Staff Member</th>
                        <th class="hide-mobile">Role</th>
                        <th class="hide-mobile">Permissions</th>
                        <th>Status</th>
                        <th class="hide-mobile">Last Active</th>
                        <th style="text-align: right">Actions</th>
                    </tr>
                </thead>
                <tbody id="staff-tbody"></tbody>
            </table>
        </div>
        <div class="pg-wrap">
            <div class="pg-info">
                Showing <strong id="staff-showing">0</strong> of
                <strong id="staff-total">0</strong> members
            </div>
            <div class="pg-btns" id="staff-pagination"></div>
        </div>
    </div>
</section>
@endsection
