@extends('admin.layouts.app')

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