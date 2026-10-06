@extends('admin.layouts.app')
<<<<<<< HEAD

=======
<style>@media (max-width: 768px) {

    /* Charts grid -> stack vertically on mobile */
    .g2 {
        display: grid;
        grid-template-columns: 1fr;
        gap: 16px;
        width: 100%;
    }

    /* Chart cards must respect container width */
    .g2 .card {
        width: 100%;
        min-width: 0;
        box-sizing: border-box;
        padding: 14px !important;
    }

    /* Chart wrapper div (height:230px inline style) */
    .g2 .card > div[style*="height:230px"] {
        position: relative;
        width: 100%;
        height: 220px !important;
    }

    /* Force canvas to respect parent, not its own pixel size */
    #an-reg-chart,
    #an-cat-chart {
        max-width: 100% !important;
        width: 100% !important;
        height: 100% !important;
    }
}

@media (max-width: 480px) {
    .g2 .card > div[style*="height:230px"] {
        height: 200px !important;
    }

    .g2 .section-title {
        font-size: 0.95rem;
        margin-bottom: 8px;
    }
}
@media (min-width: 769px) and (max-width: 1024px) {

    #page-analytics {
        padding-left: 16px;
        padding-right: 16px;
    }

    /* Header row: keep inline but allow filter to not be squished */
    #page-analytics > div:first-child {
        flex-wrap: wrap;
        gap: 12px;
    }

    #analytics-filter {
        min-width: 160px;
    }

    /* Stat cards: 2 columns reads better than 4-cramped on tablet */
    .g4 {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
    }

    .stat-card {
        padding: 16px;
    }

    /* Charts: keep side-by-side but give them breathing room */
    .g2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .g2 .card {
        min-width: 0;
        padding: 16px !important;
    }

    .g2 .card > div[style*="height:230px"] {
        height: 210px !important;
        position: relative;
    }

    #an-reg-chart,
    #an-cat-chart {
        max-width: 100% !important;
        width: 100% !important;
        height: 100% !important;
    }

    /* Legend tends to overflow on tablet too if position is 'right' */
    .g2 .card canvas#an-cat-chart {
        max-height: 180px !important;
    }
}</style>
>>>>>>> 14b4245 (full updated code)
@section('content')

<section id="page-analytics" class="page active">

    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:10px">

        <div>

            <h2 class="font-jakarta"
                style="font-size:1.3rem;font-weight:800">
                Dashboard Overview
            </h2>

            <p style="color:var(--text3)">
                Platform-wide insights and metrics
            </p>

        </div>

        <select
            class="inp"
            id="analytics-filter"
            style="width:auto;min-width:150px"
            onchange="loadAnalytics()"
        >
            <option value="30" selected>
                Last 30 Days
            </option>

            <option value="90">
                Last 90 Days
            </option>

            <option value="year">
                This Year
            </option>

            <option value="all">
                All
            </option>

        </select>

    </div>

    {{-- Stats --}}
    <div class="g4" style="margin-bottom:20px">

        <div class="stat-card">

            <div class="stat-ico"
                style="background:rgba(124,58,237,.15)">
                <i class="ri-group-line"
                    style="color:var(--purple-light)">
                </i>
            </div>

            <div class="stat-num" id="total-users">
                0
            </div>

            <div class="stat-lbl">
                Total Users
            </div>

        </div>

        <div class="stat-card">

            <div class="stat-ico"
                style="background:rgba(20,184,166,.12)">
                <i class="ri-alarm-line"
                    style="color:var(--teal-light)">
                </i>
            </div>

            <div class="stat-num" id="total-reminders">
                0
            </div>

            <div class="stat-lbl">
                Total Reminders
            </div>

        </div>

        <div class="stat-card">

            <div class="stat-ico"
                style="background:rgba(16,185,129,.12)">
                <i class="ri-check-double-line"
                    style="color:var(--green)">
                </i>
            </div>

           <div class="stat-num" id="completion-rate">0</div>
            <div class="stat-lbl">Completed Reminders</div>

        </div>

        <div class="stat-card">

            <div class="stat-ico"
                style="background:rgba(245,158,11,.12)">
                <i class="ri-money-pound-circle-line"
                    style="color:var(--amber)">
                </i>
            </div>

            <div class="stat-num"
                id="total-revenue"
                style="color:var(--amber)">
                £0
            </div>

            <div class="stat-lbl">
                Total Revenue
            </div>

        </div>

    </div>

    {{-- Charts --}}
    <div class="g2">

        <div class="card" style="padding:18px">

            <div class="section-title">
                User Registrations
            </div>

            <div style="height:230px">
                <canvas id="an-reg-chart"></canvas>
            </div>

        </div>

        <div class="card" style="padding:18px">

            <div class="section-title">
                Reminder Categories Distribution
            </div>

            <div style="height:230px">
                <canvas id="an-cat-chart"></canvas>
            </div>

        </div>

    </div>

</section>

<script>

    document.addEventListener('DOMContentLoaded', function(){

        initAnalytics();

        loadAnalytics();

    });

</script>

@endsection