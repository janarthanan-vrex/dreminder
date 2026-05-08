@extends('user.layouts.app')
@section('content')

<section id="page-dashboard" class="">
    <div style="margin-bottom:24px">
        <h2 class="font-jakarta" style="font-size:1.5rem;font-weight:800;color:#f1f5f9"><span id="greeting">Good morning</span>, {{$user->first_name}} {{$user->last_name}}! <span class="pulse-soft">☀️</span></h2>
        <p id="dash-summary" style="font-size:.84rem;color:#64748b;margin-top:4px"></p>
    </div>

    <style>
        .layer {
            width: 69%;
            height: 100%;
            right: -80px;
            top: 0px;
            position: absolute;
            border-radius: 154px;
        }

        .layer2 {
            width: 99%;
            height: 100%;
            right: 105px;
            top: 0px;
            position: absolute;
            border-radius: 154px;
            opacity: 0.3;
        }

        .stat-card:nth-child(1) .layer {
            background: rgba(124, 58, 237, .15);
        }

        .stat-card:nth-child(2) .layer {
            background: rgb(254 243 225);
        }

        .stat-card:nth-child(3) .layer {
            background: rgb(226 246 240);
        }

        .stat-card:nth-child(4) .layer {
            background: rgb(254 232 235);
        }

        .stat-card:nth-child(1) .layer2 {
            background: rgba(124, 58, 237, .15);
        }

        .stat-card:nth-child(2) .layer2 {
            background: rgb(254 243 225);
        }

        .stat-card:nth-child(3) .layer2 {
            background: rgb(226 246 240);
        }

        .stat-card:nth-child(4) .layer2 {
            background: rgb(254 232 235);
        }
    </style>
    <style>
        @keyframes ticker-forward {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        @keyframes ticker-reverse {
            0% {
                transform: translateX(-50%);
            }

            100% {
                transform: translateX(0);
            }
        }

        @keyframes border-flow {
            0% {
                background-position: 0% 50%;
                opacity: 0.5;
            }

            50% {
                opacity: 1;
            }

            100% {
                background-position: 200% 50%;
                opacity: 0.5;
            }
        }

        @keyframes click-pulse-anim {
            0% {
                transform: scale(0);
                opacity: 1;
            }

            100% {
                transform: scale(2.5);
                opacity: 0;
            }
        }

        .ticker-container {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .ticker-row {
            overflow: hidden;
            position: relative;
        }

        .ticker-content {
            display: flex;
            gap: 1rem;
            width: max-content;
        }

        .ticker-forward {
            animation: ticker-forward 60s linear infinite;
        }

        .ticker-reverse {
            animation: ticker-reverse 60s linear infinite;
        }

        .ticker-content:hover {
            animation-play-state: paused;
        }

        .ticker-item {
            position: relative;
            display: flex;
            align-items: center;
            gap: 0.625rem;
            padding: 0.625rem 1.25rem;
            border-radius: 0.875rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            white-space: nowrap;
        }

        .ticker-bg {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.02));
            backdrop-filter: blur(10px);
            border-radius: 0.875rem;
            transition: all 0.4s ease;
        }

        .ticker-border {
            position: absolute;
            inset: 0;
            border-radius: 0.875rem;
            padding: 1px;
            background linear-gradient(deg rgba(255, 255, 255, 0.1),
                rgba(255, 255, 255, 0.3),
                rgba(255, 255, 255, 0.1));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            background-size: 200% 100%;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .ticker-item:hover .ticker-border {
            animation: border-flow 2s linear infinite;
            opacity: 1;
        }

        .ticker-item:hover .ticker-bg {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.12), rgba(255, 255, 255, 0.06));
            transform: scale(1.02);
        }

        .ticker-item:hover {
            transform: translateY(-4px) scale(1.05);
            z-index: 10;
        }

        .ticker-item:active {
            transform: translateY(-2px) scale(1.02);
        }

        .ticker-item i {
            font-size: 1.375rem;
            position: relative;
            z-index: 2;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            filter: drop-shadow(0 0 8px currentColor);
        }

        .ticker-item:hover i {
            transform: rotate(360deg) scale(1.15);
            filter: drop-shadow(0 0 12px currentColor);
        }

        .ticker-item span {
            font-size: 0.875rem;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.85);
            position: relative;
            z-index: 2;
            transition: color 0.3s ease;
        }

        .ticker-item:hover span {
            color: #fff;
        }

        .click-pulse {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 0.875rem;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.4), transparent);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0);
            pointer-events: none;
        }

        .ticker-item.clicking .click-pulse {
            animation: click-pulse-anim 0.6s ease-out;
        }
    </style>

    <div class="g4" style="margin-bottom:24px">
        <div class="stat-card relative overflow-hidden">
            <div class="layer"></div>
            <div class="layer2"></div>
            <div style="width:40px;height:40px;border-radius:11px;background:rgba(124,58,237,.15);display:flex;align-items:center;justify-content:center;margin-bottom:12px"><i class="ri-alarm-line" style="color:#a78bfa;font-size:1.1rem"></i></div>
            <div class="font-jakarta" style="font-size:1.6rem;font-weight:800;color:#f1f5f9" id="s-active"> {{ $activeReminders }}</div>
            <div style="font-size:.73rem;color:#64748b;margin-top:3px;font-weight:600">Active Reminders</div>
        </div>
        <div class="stat-card relative overflow-hidden">
            <div class="layer"></div>
            <div class="layer2"></div>
            <div style="width:40px;height:40px;border-radius:11px;background:rgba(245,158,11,.12);display:flex;align-items:center;justify-content:center;margin-bottom:12px"><i class="ri-time-line" style="color:#f59e0b;font-size:1.1rem"></i></div>
            <div class="font-jakarta" style="font-size:1.6rem;font-weight:800;color:#f59e0b" id="s-week">{{ $dueThisWeek }}</div>
            <div style="font-size:.73rem;color:#64748b;margin-top:3px;font-weight:600">Due This Week</div>
        </div>
        <div class="stat-card relative overflow-hidden">
            <div class="layer"></div>
            <div class="layer2"></div>
            <div style="width:40px;height:40px;border-radius:11px;background:rgba(16,185,129,.12);display:flex;align-items:center;justify-content:center;margin-bottom:12px"><i class="ri-check-double-line" style="color:#10b981;font-size:1.1rem"></i></div>
            <div class="font-jakarta" style="font-size:1.6rem;font-weight:800;color:#10b981" id="s-done">{{ $completedReminders }}</div>
            <div style="font-size:.73rem;color:#64748b;margin-top:3px;font-weight:600">Completed</div>
        </div>
        <div class="stat-card relative overflow-hidden">
            <div class="layer"></div>
            <div class="layer2"></div>
            <div style="width:40px;height:40px;border-radius:11px;background:rgba(244,63,94,.12);display:flex;align-items:center;justify-content:center;margin-bottom:12px"><i class="ri-error-warning-line" style="color:#f43f5e;font-size:1.1rem"></i></div>
            <div class="font-jakarta" style="font-size:1.6rem;font-weight:800;color:#f43f5e" id="s-over"> {{ $todayReminders }}</div>
            <div style="font-size:.73rem;color:#64748b;margin-top:3px;font-weight:600">Today</div>
        </div>
    </div>



    <div class="card p-4 mb-6 overflow-hidden">

        <div class="ticker-container">

            @php
            $half = ceil($categories->count() / 2);

            $topCategories = $categories->take($half);

            $bottomCategories = $categories->skip($half);
            @endphp

            <!-- Top Row -->
            <div class="ticker-row">

                <div class="ticker-content ticker-forward">

                    {{-- ORIGINAL --}}
                    @foreach($topCategories as $category)

                    <div class="ticker-item clickable"
                        onclick="openReminderModal('{{ $category->id }}','{{ $category->name }}')">

                        <div class="ticker-bg"></div>

                        <div class="ticker-border"></div>

                        <i class="{{ $category->icon }}"
                            style="color: {{ $category->color }}"></i>

                        <span>{{ $category->name }}</span>

                        <div class="click-pulse"></div>

                    </div>

                    @endforeach


                    {{-- DUPLICATE 1 --}}
                    @foreach($topCategories as $category)

                    <div class="ticker-item clickable"
                        onclick="openReminderModal('{{ $category->id }}','{{ $category->name }}')">

                        <div class="ticker-bg"></div>

                        <div class="ticker-border"></div>

                        <i class="{{ $category->icon }}"
                            style="color: {{ $category->color }}"></i>

                        <span>{{ $category->name }}</span>

                        <div class="click-pulse"></div>

                    </div>

                    @endforeach


                    {{-- DUPLICATE 2 --}}
                    @foreach($topCategories as $category)

                    <div class="ticker-item clickable"
                        onclick="openReminderModal('{{ $category->id }}','{{ $category->name }}')">

                        <div class="ticker-bg"></div>

                        <div class="ticker-border"></div>

                        <i class="{{ $category->icon }}"
                            style="color: {{ $category->color }}"></i>

                        <span>{{ $category->name }}</span>

                        <div class="click-pulse"></div>

                    </div>

                    @endforeach


                    {{-- DUPLICATE 3 --}}
                    @foreach($topCategories as $category)

                    <div class="ticker-item clickable"
                        onclick="openReminderModal('{{ $category->id }}','{{ $category->name }}')">

                        <div class="ticker-bg"></div>

                        <div class="ticker-border"></div>

                        <i class="{{ $category->icon }}"
                            style="color: {{ $category->color }}"></i>

                        <span>{{ $category->name }}</span>

                        <div class="click-pulse"></div>

                    </div>

                    @endforeach

                </div>

            </div>


            <!-- Bottom Row -->
            <div class="ticker-row">

                <div class="ticker-content ticker-reverse">

                    {{-- ORIGINAL --}}
                    @foreach($bottomCategories as $category)

                    <div class="ticker-item clickable"
                        onclick="openReminderModal('{{ $category->id }}','{{ $category->name }}')">

                        <div class="ticker-bg"></div>

                        <div class="ticker-border"></div>

                        <i class="{{ $category->icon }}"
                            style="color: {{ $category->color }}"></i>

                        <span>{{ $category->name }}</span>

                        <div class="click-pulse"></div>

                    </div>

                    @endforeach


                    {{-- DUPLICATE 1 --}}
                    @foreach($bottomCategories as $category)

                    <div class="ticker-item clickable"
                        onclick="openReminderModal('{{ $category->id }}','{{ $category->name }}')">

                        <div class="ticker-bg"></div>

                        <div class="ticker-border"></div>

                        <i class="{{ $category->icon }}"
                            style="color: {{ $category->color }}"></i>

                        <span>{{ $category->name }}</span>

                        <div class="click-pulse"></div>

                    </div>

                    @endforeach


                    {{-- DUPLICATE 2 --}}
                    @foreach($bottomCategories as $category)

                    <div class="ticker-item clickable"
                        onclick="openReminderModal('{{ $category->id }}','{{ $category->name }}')">

                        <div class="ticker-bg"></div>

                        <div class="ticker-border"></div>

                        <i class="{{ $category->icon }}"
                            style="color: {{ $category->color }}"></i>

                        <span>{{ $category->name }}</span>

                        <div class="click-pulse"></div>

                    </div>

                    @endforeach


                    {{-- DUPLICATE 3 --}}
                    @foreach($bottomCategories as $category)

                    <div class="ticker-item clickable"
                        onclick="openReminderModal('{{ $category->id }}','{{ $category->name }}')">

                        <div class="ticker-bg"></div>

                        <div class="ticker-border"></div>

                        <i class="{{ $category->icon }}"
                            style="color: {{ $category->color }}"></i>

                        <span>{{ $category->name }}</span>

                        <div class="click-pulse"></div>

                    </div>

                    @endforeach

                </div>

            </div>

        </div>

    </div>

    <div class="g2" style="margin-bottom:24px">
        <div class="card" style="padding:20px">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
                <h3 class="font-jakarta" style="font-weight:700;font-size:.93rem;color:#f1f5f9">Upcoming Reminders</h3>
                <button class="btn btn-ghost btn-sm" onclick="window.location.href='user-notification'">View All <i class="ri-arrow-right-line"></i></button>
            </div>
            <div id="dash-list" style="display:flex;flex-direction:column;gap:8px"></div>
        </div>
        <div class="card" style="padding:20px">
            <h3 class="font-jakarta" style="font-weight:700;font-size:.93rem;color:#f1f5f9;margin-bottom:16px">Activity — Last 30 Days</h3>
            <div style="position:relative;height:420px"><canvas id="dash-chart"></canvas></div>
        </div>
    </div>
    <!-- <div class="card" style="padding:20px">
        <h3 class="font-jakarta" style="font-weight:700;font-size:.93rem;color:#f1f5f9;margin-bottom:16px">Quick Actions</h3>
        <div style="display:flex;flex-wrap:wrap;gap:10px">
            <button class="btn btn-primary" onclick="openReminderModal()"><i class="ri-add-circle-line"></i> Create Reminder</button>
            <button class="btn btn-teal" onclick="go('calendar')"><i class="ri-calendar-line"></i> View Calendar</button>
            <button class="btn btn-ghost" onclick="go('templates')"><i class="ri-file-copy-line"></i> Use Template</button>
            <button class="btn btn-ghost" onclick="go('analytics')"><i class="ri-bar-chart-line"></i> Analytics</button>
            <button class="btn btn-ghost" onclick="go('shared')"><i class="ri-share-line"></i> Shared</button>
            <button class="btn btn-ghost" onclick="go('features')"><i class="ri-folder-line"></i> Category</button>
        </div>
    </div> -->
</section>

@include('user.layouts.firebase_setup')

<script>
    async function initFCMAndSave() {
        try {
            const permission = await Notification.requestPermission();

            if (permission !== "granted") {
                console.log("Permission denied");
                return;
            }

            // 🔥 get token
            const token = await messaging.getToken({
                vapidKey: "BIkREF621bG6cSbBAo2Xn4VO6APwEyJ-mvnMDVm_5jsG8XLGFNpz2mLCDiP3FX8zmWfvUewvBO2Rvw8Iq0U_tkg"
            });

            if (!token) {
                console.log("No token ❌");
                return;
            }

            console.log("Token:", token);

            // 🔥 get existing token from DB
            const existingToken = @json(auth()->user()->fcm_token);

            // ✅ ONLY STORE IF NOT EXISTS
            if (existingToken) {
                console.log("Token already exists in DB ✅");
                return;
            }

            // 🔥 save token
            await fetch('/save-token', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    token: token
                })
            });

            console.log("Token stored successfully ✅");

        } catch (err) {
            console.log("FCM error:", err);
        }
    }

    // 🚀 run immediately
    initFCMAndSave();
</script>

<script>
    // Add click animation
    document.querySelectorAll('.ticker-item.clickable').forEach(item => {
        item.addEventListener('click', function(e) {
            this.classList.add('clicking');

            setTimeout(() => {
                this.classList.remove('clicking');
            }, 600);
        });
    });
</script>

@endsection