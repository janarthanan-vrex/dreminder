@extends('admin.layouts.app')
@section('content')
<!-- ═══ USERS ═══ -->
<section id="page-users" class="page active">
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
                User Management
            </h2>
            <p style="font-size: 1.2re; color: var(--text3); margin-top: 3px">
                Manage all registered users
            </p>
        </div>
        <div style="display: flex; gap: 8px">
            <button class="btn btn-ghost btn-sm" onclick="toast('Users exported','success')">
                <i class="ri-download-2-line"></i> Export
            </button>
            <button class="btn btn-primary btn-sm" onclick="openModal('add-user-modal')">
                <i class="ri-user-add-line"></i> Add User
            </button>
        </div>
    </div>
    <div class="card" style="padding: 14px; margin-bottom: 14px">
        <div style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center">
            <div class="search-box" style="flex: 1; min-width: 200px">
                <i class="ri-search-line" style="color: var(--text3); font-size: 0.85rem"></i
                ><input
                    placeholder="Search users…"
                    oninput="filterUsers(this.value)"
                    id="users-search-inp"
                />
            </div>
            <select
                class="inp"
                style="width: auto; min-width: 130px"
                id="users-status-filter"
                onchange="filterUsers()"
            >
                <option value="all">All Status</option>
                <option value="active">Active</option>
                <option value="suspended">Suspended</option>
            </select>
            <select
                class="inp"
                style="width: auto; min-width: 130px"
                id="users-plan-filter"
                onchange="filterUsers()"
            >
                <option value="all">All Plans</option>
                <option value="Basic Annual">Basic Annual</option>
                <option value="Pro">Pro</option>
                <option value="Free">Free</option>
            </select>
        </div>
    </div>
    <div class="card" style="padding: 18px">
        <div style="overflow-x: auto">
            <table class="data-table" id="users-table">
                <thead>
                    <tr>
                        <th style="width: 38px">
                            <input
                                type="checkbox"
                                style="
                                    accent-color: var(--purple);
                                    width: 13px;
                                    height: 13px;
                                    cursor: pointer;
                                "
                                onchange="toggleAllCB(this,'user-cb')"
                            />
                        </th>
                        <th>User</th>
                        <th class="hide-mobile">Plan</th>
                        <th class="hide-mobile">Reminders</th>
                        <th>Status</th>
                        <th class="hide-mobile">Joined</th>
                        <th style="text-align: right">Actions</th>
                    </tr>
                </thead>
                <tbody id="users-tbody"></tbody>
            </table>
        </div>
        <div class="pg-wrap">
            <div class="pg-info">
                Showing <strong id="users-showing">0</strong> of
                <strong id="users-total">0</strong> users
            </div>
            <div class="pg-btns" id="users-pagination"></div>
        </div>
    </div>
</section>
@endsection
