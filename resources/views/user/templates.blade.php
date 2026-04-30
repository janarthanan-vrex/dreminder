@extends('user.layouts.app')
@section('content')

<section id="page-templates" class="">
    <div style="margin-bottom:16px">
        <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800;color:#f1f5f9">Quick Start Templates</h2>
        <p style="font-size:.82rem;color:#64748b;margin-top:3px">Create reminders faster with pre-configured templates</p>
    </div>
    <div style="display:flex;flex-wrap:wrap;gap:10px;margin-bottom:20px">
        <div class="search-box" style="flex:1;min-width:200px"><i class="ri-search-line" style="color:#64748b;font-size:.9rem"></i><input id="tmpl-search" placeholder="Search templates…" oninput="filterTemplates()" style="font-size:.85rem;color:inherit"></div>
        <select class="inp" style="width:auto;min-width:165px" id="tmpl-cat" onchange="filterTemplates()">
            <option value="">All Category</option>
            <option value="motor-vehicle">Motor Vehicle</option>
            <option value="subscriptions">Subscriptions</option>
            <option value="special-days">Special Days</option>
            <option value="insurance">Insurance</option>
            <option value="home">Home</option>
            <option value="health">Health</option>
            <option value="travel">Travel</option>
            <option value="pet-care">Pet Care</option>
            <option value="tv-telephone-mobile">TV & Mobile</option>
        </select>
    </div>
    <div id="tmpl-container"></div>
</section>

@endsection
