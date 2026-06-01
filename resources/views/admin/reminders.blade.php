@extends('admin.layouts.app')
@section('content')
<!-- ═══ REMINDERS ═══ -->
<section id="page-reminders" class="page active">
    <div
        style="
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        ">
        <div>
            <h2 class="font-jakarta" style="font-size: 1.3rem; font-weight: 800">
                Reminders Overview
            </h2>
            <p style="font-size: 1.2re; color: var(--text3); margin-top: 3px">
                Monitor all platform reminders
            </p>
        </div>

    </div>
    <div class="flex flex-wrap gap-3 mb-6">
        <div class="flex items-center gap-2.5 px-4 py-2 bg-white rounded-full shadow-sm border border-gray-100 hover:border-purple-200 transition-colors">
            <i class="ri-alarm-line text-purple-500 text-base"></i>
            <span class="text-sm text-gray-600">Total: <strong class="text-gray-900">{{$totalReminders ?? ''}}</strong></span>
        </div>

        <div class="flex items-center gap-2.5 px-4 py-2 bg-white rounded-full shadow-sm border border-gray-100 hover:border-green-200 transition-colors">
            <i class="ri-check-double-line text-green-500 text-base"></i>
            <span class="text-sm text-gray-600">Completed: <strong class="text-green-600">{{$completedReminders ?? ''}}</strong></span>
        </div>

        <div class="flex items-center gap-2.5 px-4 py-2 bg-white rounded-full shadow-sm border border-gray-100 hover:border-teal-200 transition-colors">
            <i class="ri-time-line text-teal-500 text-base"></i>
            <span class="text-sm text-gray-600">Today: <strong class="text-gray-900">{{$todayReminders ?? ''}}</strong></span>
        </div>

        <div class="flex items-center gap-2.5 px-4 py-2 bg-white rounded-full shadow-sm border border-gray-100 hover:border-red-200 transition-colors">
            <i class="ri-error-warning-line text-red-500 text-base"></i>
            <span class="text-sm text-gray-600">Pending: <strong class="text-red-600">{{$pendingReminders ?? ''}}</strong></span>
        </div>
    </div>
    <div class="card" style="padding: 18px">
        <div style="display: flex;align-items: center;justify-content: space-between;margin-bottom: 14px;flex-wrap: wrap;gap: 10px;">
            <div class="section-title" style="margin: 0">All Reminders</div>
            <div style="display: flex; gap: 8px; flex-wrap: wrap">
                <div class="search-box" style="width: 180px">
                    <i class="ri-search-line" style="color: var(--text3); font-size: 0.85rem"></i><input placeholder="Search…" oninput="filterReminders(this.value)" />
                </div>
                <select class="inp"
                    style="width:auto;min-width:140px"
                    id="rem-date-filter"
                    onchange="filterReminders()">

                    <option value="this_month" selected>This Month</option>
                    <option value="3_months">Last 3 Months</option>
                    <option value="6_months">Last 6 Months</option>
                    <option value="this_year">This Year</option>
                    <option value="all">All</option>

                </select>
                <select class="inp" style="width: auto; min-width: 120px" id="rem-status-filter" onchange="filterReminders()">
                    <option value="all">All Status</option>
                    <option value="completed">Completed</option>
                    <option value="pending">Pending</option>
                </select>
            </div>
        </div>
        <div style="overflow-x: auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Title</th>
                        <th class="hide-mobile">User</th>
                        <th class="hide-mobile">Category</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th style="text-align: right">Actions</th>
                    </tr>
                </thead>
                <tbody id="rem-tbody"></tbody>
            </table>
        </div>
        <div class="pg-wrap">
            <div class="pg-info">
                Showing <strong id="rem-showing">0</strong> of
                <strong id="rem-total">0</strong> reminders
            </div>
            <div class="pg-btns" id="rem-pagination"></div>
        </div>
    </div>
</section>
<script>
    window.REMINDERS_DATA = @json($reminders);
</script>
@endsection