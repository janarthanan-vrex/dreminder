@extends('user.layouts.app')
@section('content')

<section id="page-analytics" class="">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:16px;flex-wrap:wrap;gap:10px">
        <div>
            <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800;color:#f1f5f9">Analytics & Activity</h2>
            <p style="font-size:.82rem;color:#64748b;margin-top:3px">Track your reminder activity and insights</p>
        </div>

    </div>
    @php
    $selectedDays = request('days', 7);
@endphp
    <div class="card" style="padding:14px;margin-bottom:16px">
        <div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:10px">
            <div style="display:flex;flex-wrap:wrap;gap:6px">

    <button
        class="period-btn {{ $selectedDays == 7 ? 'active' : '' }}"
        onclick="setPeriod(this,7)">
        Last 7 Days
    </button>

    <button
        class="period-btn {{ $selectedDays == 30 ? 'active' : '' }}"
        onclick="setPeriod(this,30)">
        Last 30 Days
    </button>

    <button
        class="period-btn {{ $selectedDays == 90 ? 'active' : '' }}"
        onclick="setPeriod(this,90)">
        Last 90 Days
    </button>

    <button
        class="period-btn {{ $selectedDays == 365 ? 'active' : '' }}"
        onclick="setPeriod(this,365)">
        This Year
    </button>

    <button
        class="period-btn {{ $selectedDays == 'all' ? 'active' : '' }}"
        onclick="setPeriod(this,'all')">
        All Time
    </button>

    <a href="{{ route('user.analytics') }}"
       class="period-btn">
        Reset
    </a>

</div>

        </div>
    </div>
    <div class="g4" style="margin-bottom:20px">
        <div class="stat-card">
            <div style="width:40px;height:40px;border-radius:11px;background:rgba(124,58,237,.15);display:flex;align-items:center;justify-content:center;margin-bottom:10px"><i class="ri-alarm-line" style="color:#a78bfa;font-size:1.1rem"></i></div>
            <div class="font-jakarta" style="font-size:1.5rem;font-weight:800;color:#f1f5f9">{{ $totalReminders }}</div>
            <div style="font-size:.72rem;color:#64748b;margin-top:3px;font-weight:600">Total Reminders</div>

        </div>
        <div class="stat-card">
            <div style="width:40px;height:40px;border-radius:11px;background:rgba(16,185,129,.12);display:flex;align-items:center;justify-content:center;margin-bottom:10px"><i class="ri-check-double-line" style="color:#10b981;font-size:1.1rem"></i></div>
            <div class="font-jakarta" style="font-size:1.5rem;font-weight:800;color:#10b981">{{$completedReminders}}</div>
            <div style="font-size:.72rem;color:#64748b;margin-top:3px;font-weight:600">Completed Reminders</div>

        </div>
        <div class="stat-card">
            <div style="width:40px;height:40px;border-radius:11px;background:rgba(20,184,166,.12);display:flex;align-items:center;justify-content:center;margin-bottom:10px"><i class="ri-timer-line" style="color:#2dd4bf;font-size:1.1rem"></i></div>
            <div class="font-jakarta" style="font-size:1.5rem;font-weight:800;color:#f1f5f9">{{$pendingReminders}}</div>
            <div style="font-size:.72rem;color:#64748b;margin-top:3px;font-weight:600">Pending Reminders</div>
        </div>
        <div class="stat-card">
            <div style="width:40px;height:40px;border-radius:11px;background:rgba(245,158,11,.12);display:flex;align-items:center;justify-content:center;margin-bottom:10px"><i class="ri-wallet-3-line" style="color:#f59e0b;font-size:1.1rem"></i></div>
            <div class="font-jakarta" style="font-size:1.5rem;font-weight:800;color:#f59e0b">£{{ number_format($totalCost, 2) }}</div>

        </div>
    </div>
    <div class="g2" style="margin-bottom:16px">
        <div class="card" style="padding:18px">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
                <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9">Activity Trend</h3>

            </div>
            <div style="position:relative;height:250px"><canvas id="act-trend-chart"></canvas></div>
        </div>
        <div class="card" style="padding:18px">
            <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:14px">By Category</h3>
            <div style="position:relative;height:250px"><canvas id="cat-dist-chart"></canvas></div>
        </div>
    </div>
    <div class="g2" style="margin-bottom:16px">
        <div class="card" style="padding:18px">
            <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:14px">Completion Status</h3>
            <div style="position:relative;height:210px"><canvas id="comp-chart"></canvas></div>
            <div class="g2" style="margin-top:14px">
                <div style="text-align:center;padding:12px;background:rgba(16,185,129,.1);border-radius:10px">
                    <div style="font-size:.72rem;color:#64748b;margin-bottom:3px">Completed</div>
                    <div class="font-jakarta" style="font-size:1.3rem;font-weight:800;color:#10b981">{{ $completedReminders }}</div>
                </div>
                <div style="text-align:center;padding:12px;background:rgba(244,63,94,.1);border-radius:10px">
                    <div style="font-size:.72rem;color:#64748b;margin-bottom:3px">Pending</div>
                    <div class="font-jakarta" style="font-size:1.3rem;font-weight:800;color:#f43f5e">{{ $pendingReminders }}</div>
                </div>
            </div>
        </div>
        <div class="card" style="padding:18px">
            <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:14px">Monthly Spending (£)</h3>
            <div style="position:relative;height:210px"><canvas id="spend-chart"></canvas></div>
        </div>
    </div>
    <div class="card hidden" style="padding:18px;margin-bottom:16px">
        <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:14px">Category Performance</h3>
        <div style="overflow-x:auto">
            <table style="width:100%;border-collapse:collapse;font-size:.83rem">
                <thead>
                    <tr>
                        <th style="text-align:left;padding-bottom:10px;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;border-bottom:1px solid rgba(255,255,255,.06)">Category</th>
                        <th style="text-align:center;padding-bottom:10px;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;border-bottom:1px solid rgba(255,255,255,.06)">Total</th>
                        <th style="text-align:center;padding-bottom:10px;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;border-bottom:1px solid rgba(255,255,255,.06)">Done</th>
                        <th style="text-align:center;padding-bottom:10px;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;border-bottom:1px solid rgba(255,255,255,.06)">Rate</th>
                        <th style="text-align:center;padding-bottom:10px;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;border-bottom:1px solid rgba(255,255,255,.06)">Trend</th>
                    </tr>
                </thead>
                <tbody id="cat-perf-table"></tbody>
            </table>
        </div>
    </div>

</section>

<script>
    window.analyticsData = {

        activityLabels: @json($activityLabels),
        createdData: @json($createdData),
        completedData: @json($completedData),

        categoryLabels: @json($categoryLabels),
        categoryTotals: @json($categoryTotals),

        completionChart: @json($completionChart),

        monthlySpending: @json($monthlySpending),
    };
</script>

@endsection