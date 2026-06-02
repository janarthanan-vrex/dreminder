@extends('admin.layouts.app')
@section('content')

<!-- ═══ DASHBOARD ═══ -->
<section id="page-dashboard" class="page active">
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
            <h2
                class="font-jakarta"
                style="font-size: 1.3rem; font-weight: 800; color: var(--text)"
            >
                Welcome back, Admin
            </h2>
            <p style="font-size: 1.2re; color: var(--text3); margin-top: 3px">
                Here's what's happening with D-Remind today.
            </p>
        </div>
        <div style="display: flex; gap: 8px">
            <button class="btn btn-ghost btn-sm" onclick="toast('Report generated!','success')">
                <i class="ri-download-2-line"></i> Export
            </button>
            <button class="btn btn-primary btn-sm" onclick="openModal('add-user-modal')">
                <i class="ri-add-line"></i> Add User
            </button>
        </div>
    </div>
    <div class="flex flex-wrap gap-3 mb-3">
        <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-full shadow-sm border border-gray-100">
            <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
            <span class="text-sm text-gray-600">Users: <strong class="text-gray-900">1,284</strong></span>
            <span class="text-xs text-green-600 ml-1">+12%</span>
        </div>
        
        <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-full shadow-sm border border-gray-100">
            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
            <span class="text-sm text-gray-600">Reminders: <strong class="text-gray-900">48.3k</strong></span>
            <span class="text-xs text-green-600 ml-1">+8%</span>
        </div>
        
        <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-full shadow-sm border border-gray-100">
            <div class="w-2 h-2 bg-amber-500 rounded-full"></div>
            <span class="text-sm text-gray-600">Revenue: <strong class="text-gray-900">£2,880</strong></span>
            <span class="text-xs text-green-600 ml-1">+18%</span>
        </div>
        
        <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-full shadow-sm border border-gray-100">
            <div class="w-2 h-2 bg-red-500 rounded-full"></div>
            <span class="text-sm text-gray-600">Issues: <strong class="text-gray-900">3</strong></span>
            <span class="text-xs text-red-600 ml-1">Critical</span>
        </div>
    </div>
    <div class="g2" style="margin-bottom: 20px">
        <div class="card" style="padding: 18px">
            <div
                style="
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    margin-bottom: 14px;
                "
            >
                <div class="section-title" style="margin: 0">User Growth</div>
                <select
                    class="inp"
                    style="width: auto; padding: 5px 28px 5px 10px; font-size: 0.73rem"
                >
                    <option>Last 6 Months</option>
                    <option>Last Year</option>
                </select>
            </div>
            <div style="position: relative; height: 220px">
                <canvas id="user-growth-chart"></canvas>
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
                <div class="section-title" style="margin: 0">Revenue Breakdown</div>
                <span class="badge badge-green">+18% MoM</span>
            </div>
            <div style="position: relative; height: 220px">
                <canvas id="revenue-chart"></canvas>
            </div>
        </div>
    </div>
    <div class="g2" style="margin-bottom: 20px">
        <div class="card" style="padding: 18px">
            <div
                style="
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    margin-bottom: 14px;
                "
            >
                <div class="section-title" style="margin: 0">Recent Signups</div>
                <button class="btn btn-ghost btn-xs" onclick="go('users',null)">
                    View All <i class="ri-arrow-right-line"></i>
                </button>
            </div>
            <div
                style="display: flex; flex-direction: column; gap: 8px"
                id="recent-users-list"
            ></div>
        </div>
        <div style="display: flex; flex-direction: column; gap: 14px">
            <div class="card" style="padding: 18px">
                <div class="section-title">Quick Actions</div>
                <div style="display: flex; flex-wrap: wrap; gap: 8px">
                    <button class="btn btn-primary btn-sm" onclick="openModal('add-user-modal')">
                        <i class="ri-user-add-line"></i> Add User
                    </button>
                    <button class="btn btn-teal btn-sm" onclick="openModal('add-staff-modal')">
                        <i class="ri-team-line"></i> Add Staff
                    </button>
                </div>
            </div>
            <div class="card" style="padding: 18px">
                <div class="section-title">System Health</div>
                <div style="display: flex; flex-direction: column; gap: 10px" id="sys-health"></div>
            </div>
        </div>
    </div>
</section>
@endsection
