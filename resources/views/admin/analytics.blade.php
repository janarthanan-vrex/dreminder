@extends('admin.layouts.app')
@section('content')

<!-- ═══ ANALYTICS ═══ -->
<section id="page-analytics" class="page active">
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
                Analytics Overview
            </h2>
            <p style="font-size: 1.2re; color: var(--text3); margin-top: 3px">
                Platform-wide insights and metrics
            </p>
        </div>
        <div style="display: flex; gap: 8px">
            <select class="inp" style="width: auto; min-width: 140px">
                <option>Last 30 Days</option>
                <option>Last 90 Days</option>
                <option>This Year</option>
            </select>
            <button class="btn btn-ghost btn-sm" onclick="toast('Analytics exported!','success')">
                <i class="ri-download-2-line"></i> Export
            </button>
        </div>
    </div>
    <div class="g4" style="margin-bottom: 20px">
        <div class="stat-card">
            <div class="stat-ico" style="background: rgba(124, 58, 237, 0.15)">
                <i class="ri-group-line" style="color: var(--purple-light)"></i>
            </div>
            <div class="stat-num">1,284</div>
            <div class="stat-lbl">Total Users</div>
            <div class="stat-delta" style="color: var(--green)">
                <i class="ri-arrow-up-line"></i> 12%
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-ico" style="background: rgba(20, 184, 166, 0.12)">
                <i class="ri-alarm-line" style="color: var(--teal-light)"></i>
            </div>
            <div class="stat-num">48,320</div>
            <div class="stat-lbl">Total Reminders</div>
            <div class="stat-delta" style="color: var(--green)">
                <i class="ri-arrow-up-line"></i> 8%
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-ico" style="background: rgba(16, 185, 129, 0.12)">
                <i class="ri-check-double-line" style="color: var(--green)"></i>
            </div>
            <div class="stat-num">89%</div>
            <div class="stat-lbl">Completion Rate</div>
            <div class="stat-delta" style="color: var(--green)">
                <i class="ri-arrow-up-line"></i> 5%
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-ico" style="background: rgba(245, 158, 11, 0.12)">
                <i class="ri-money-pound-circle-line" style="color: var(--amber)"></i>
            </div>
            <div class="stat-num" style="color: var(--amber)">£34,560</div>
            <div class="stat-lbl">Total Revenue</div>
            <div class="stat-delta" style="color: var(--green)">
                <i class="ri-arrow-up-line"></i> 18%
            </div>
        </div>
    </div>
    <div class="g2" style="margin-bottom: 20px">
        <div class="card" style="padding: 18px">
            <div class="section-title">User Registrations — Monthly</div>
            <div style="position: relative; height: 230px"><canvas id="an-reg-chart"></canvas></div>
        </div>
        <div class="card" style="padding: 18px">
            <div class="section-title">Reminder Categories Distribution</div>
            <div style="position: relative; height: 230px"><canvas id="an-cat-chart"></canvas></div>
        </div>
    </div>
    <div class="g2">
        <div class="card" style="padding: 18px">
            <div class="section-title">Revenue Trend</div>
            <div style="position: relative; height: 200px"><canvas id="an-rev-chart"></canvas></div>
        </div>
        <div class="card" style="padding: 18px">
            <div class="section-title">Plan Distribution</div>
            <div style="position: relative; height: 200px">
                <canvas id="an-plan-chart"></canvas>
            </div>
        </div>
    </div>
</section>

@endsection
