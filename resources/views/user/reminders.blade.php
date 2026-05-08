@extends('user.layouts.app')
@section('content')

<section id="page-reminders" class="">
    <div style="margin-bottom:16px">
        <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800;color:#f1f5f9">All Reminders</h2>
        <p id="rem-count-label" style="font-size:.82rem;color:#64748b;margin-top:3px"></p>
    </div>
    <div style="display:flex;flex-wrap:wrap;gap:10px;margin-bottom:12px">
        <div class="search-box" style="flex:1;min-width:200px"><i class="ri-search-line" style="color:#64748b;font-size:.9rem"></i><input id="rem-search" placeholder="Search reminders…" oninput="loadReminders()" style="font-size:.85rem;color:inherit"></div>
        <select class="inp" style="width:auto;min-width:155px" id="rem-cat" onchange="loadReminders()">
            <option value="all">All Category</option>
        </select>
        <select class="inp" style="width:auto;min-width:140px" id="rem-status" onchange="loadReminders()">
            <option value="all">All Status</option>
            <option value="today">Today</option>
            <option value="upcoming">Upcoming</option>
            <option value="completed">Completed</option>
        </select>
        <select class="inp" style="width:auto;min-width:160px" id="rem-sort" onchange="loadReminders()">
            <option value="date-asc">Date ↑</option>
            <option value="date-desc">Date ↓</option>
            <option value="title-asc">Title A–Z</option>
            <option value="created-desc">Recently Added</option>
        </select>
        <button class="btn btn-ghost btn-sm" onclick="resetFilters()" title="Reset filters"><i class="ri-refresh-line"></i></button>
    </div>
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
        <div style="display:flex;gap:6px">
            <button class="view-btn active" id="vg" onclick="setView('grid')"><i class="ri-grid-line"></i> Grid</button>
            <button class="view-btn" id="vl" onclick="setView('list')"><i class="ri-list-check"></i> List</button>
        </div>
        <span style="font-size:.75rem;color:#64748b;font-weight:600"><span id="rem-display-count">0</span> reminders</span>
    </div>
    <div id="rem-list" style="display:flex;flex-direction:column;gap:8px"></div>
    <div id="rem-grid" style="display:none;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px"></div>
    <div id="rem-empty" style="display:none;text-align:center;padding:60px 0">
        <div style="font-size:3.5rem;color:rgba(255,255,255,.1);margin-bottom:10px"><i class="ri-inbox-2-line"></i></div>
        <div class="font-jakarta" style="font-weight:700;font-size:1.05rem;color:#94a3b8;margin-bottom:6px">No Reminders Found</div>
        <div style="font-size:.83rem;color:#64748b;margin-bottom:14px">Try adjusting your filters or create a new reminder</div>
        <button class="btn btn-primary" onclick="openReminderModal()"><i class="ri-add-line"></i> Create Reminder</button>
    </div>
</section>

@php

$formattedReminders = $reminders->map(function ($r) {
    return [
        'id' => $r->id,
        'title' => $r->title,
        'category' => (string) $r->category_id,
        'subcategory' => optional($r->subcategory)->name,
        'dueDate' => $r->reminder_date,
       'dueTime' => \Carbon\Carbon::parse($r->reminder_time)->format('g:i A'),
        'description' => $r->description,
        'provider' => $r->provider,
        'cost' => $r->cost,
        'frequency' => $r->payment_frequency,
        'status' => $r->status,
        'createdAt' => $r->created_at,
    ];
})->values();

$cats = $categories->mapWithKeys(function ($category) {
    return [
        $category->id => [
            'id' => $category->id,
            'name' => $category->name,
            'icon' => $category->icon ?? 'ri-folder-line',
            'color' => $category->color ?? '#14b8a6',
            'bg' => 'rgba(20,184,166,.12)',
            'subs' => $category->subcategories
                        ->pluck('name')
                        ->toArray()
        ]
    ];

})->toArray();
@endphp

<script>

window.DB_REMINDERS = @json($formattedReminders);

window.CATS = @json($cats);

</script>
@endsection
