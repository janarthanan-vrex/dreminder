@extends('user.layouts.app')
@section('content')

<section id="page-categories" class="">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:16px;flex-wrap:wrap;gap:10px">
        <div>
            <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800;color:#f1f5f9">Reminder Categories</h2>
            <p style="font-size:.82rem;color:#64748b;margin-top:3px">Organize reminders with categories and subcategories</p>
        </div>
        <button class="btn btn-primary btn-sm" onclick="openModal('add-sub-modal')"><i class="ri-add-line"></i> Add Subcategory</button>
    </div>
    <div class="g4" style="margin-bottom:20px">
        <div class="stat-card">
            <div style="width:40px;height:40px;border-radius:11px;background:rgba(124,58,237,.15);display:flex;align-items:center;justify-content:center;margin-bottom:10px"><i class="ri-folder-3-line" style="color:#a78bfa;font-size:1.1rem"></i></div>
            <div class="font-jakarta" style="font-size:1.5rem;font-weight:800;color:#f1f5f9">10</div>
            <div style="font-size:.72rem;color:#64748b;margin-top:3px;font-weight:600">Total Categories</div>
        </div>
        <div class="stat-card">
            <div style="width:40px;height:40px;border-radius:11px;background:rgba(20,184,166,.12);display:flex;align-items:center;justify-content:center;margin-bottom:10px"><i class="ri-folder-add-line" style="color:#2dd4bf;font-size:1.1rem"></i></div>
            <div class="font-jakarta" style="font-size:1.5rem;font-weight:800;color:#f1f5f9" id="custom-sub-count">0</div>
            <div style="font-size:.72rem;color:#64748b;margin-top:3px;font-weight:600">Custom Subcategories</div>
        </div>
        <div class="stat-card">
            <div style="width:40px;height:40px;border-radius:11px;background:rgba(16,185,129,.12);display:flex;align-items:center;justify-content:center;margin-bottom:10px"><i class="ri-star-line" style="color:#10b981;font-size:1.1rem"></i></div>
            <div class="font-jakarta" style="font-size:.9rem;font-weight:800;color:#f1f5f9" id="most-used-cat">—</div>
            <div style="font-size:.72rem;color:#64748b;margin-top:3px;font-weight:600">Most Used</div>
        </div>
    </div>
    <div id="cat-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:14px;margin-bottom:20px"></div>
    <div class="card" style="padding:18px">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
            <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9">Custom Subcategories</h3>
            <span class="badge badge-purple" id="custom-sub-badge">0 Custom</span>
        </div>
        <div id="custom-sub-list" style="display:flex;flex-direction:column;gap:8px">
            <div style="text-align:center;padding:24px;color:#475569;font-size:.83rem">No custom subcategories yet. Add one above!</div>
        </div>
    </div>
</section>

@endsection
