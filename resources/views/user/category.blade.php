@extends('user.layouts.app')
@section('content')
<style>
.error-text{
    color:#f43f5e;
    font-size:12px;
    margin-top:5px;
}
</style>

<section id="page-categories" class="">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:16px;flex-wrap:wrap;gap:10px">
        <div>
            <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800;color:#f1f5f9">Reminder Categories</h2>
            <p style="font-size:.82rem;color:#64748b;margin-top:3px">Organize reminders with categories and subcategories</p>
        </div>
        <button class="btn btn-primary btn-sm" onclick="openAddSubModal()"><i class="ri-add-line"></i> Add Subcategory</button>
    </div>
    <div class="g4" style="margin-bottom:20px">
        <div class="stat-card">
            <div style="width:40px;height:40px;border-radius:11px;background:rgba(124,58,237,.15);display:flex;align-items:center;justify-content:center;margin-bottom:10px"><i class="ri-folder-3-line" style="color:#a78bfa;font-size:1.1rem"></i></div>
            <div class="font-jakarta" style="font-size:1.5rem;font-weight:800;color:#f1f5f9"> {{ $totalCategories }}</div>
            <div style="font-size:.72rem;color:#64748b;margin-top:3px;font-weight:600">Total Categories</div>
        </div>
        <div class="stat-card">
            <div style="width:40px;height:40px;border-radius:11px;background:rgba(20,184,166,.12);display:flex;align-items:center;justify-content:center;margin-bottom:10px"><i class="ri-folder-add-line" style="color:#2dd4bf;font-size:1.1rem"></i></div>
            <div class="font-jakarta" style="font-size:1.5rem;font-weight:800;color:#f1f5f9" id="custom-sub-count">{{ $customSubCount }}</div>
            <div style="font-size:.72rem;color:#64748b;margin-top:3px;font-weight:600">Custom Subcategories</div>
        </div>
        <div class="stat-card">
            <div style="width:40px;height:40px;border-radius:11px;background:rgba(16,185,129,.12);display:flex;align-items:center;justify-content:center;margin-bottom:10px"><i class="ri-star-line" style="color:#10b981;font-size:1.1rem"></i></div>
            <div class="font-jakarta d-none" style="font-size:.9rem;font-weight:800;color:#f1f5f9" id="most-used-cat"> {{ $mostUsedCategoryName }}</div>
            <div style="font-size:.72rem;color:#64748b;margin-top:3px;font-weight:600">Most Used</div>
        </div>
    </div>
    <div id="cat-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:14px;margin-bottom:20px"></div>
    <div class="card" style="padding:18px">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
            <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9">Custom Subcategories</h3>
            <span class="badge badge-purple" id="custom-sub-badge">0 Custom</span>
        </div>
        <div id="custom-sub-list"
     style="display:flex;flex-direction:column;gap:8px">
</div>
    </div>
</section>

<script>
async function saveSubcat() {

    // 🔥 CLEAR ERRORS
    document.querySelectorAll('.error-text')
        .forEach(el => el.innerText = '');

    const btn = event.target;

    const data = {

        category_id: document.getElementById('sub-cat-parent').value,

        name: document.getElementById('sub-cat-name').value,

        description: document.getElementById('sub-cat-desc').value
    };

    btn.disabled = true;

    btn.innerHTML = 'Saving...';

    try {

        const res = await fetch(
            "{{ route('user.store.subcategory') }}",
            {
                method: 'POST',

                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },

                body: JSON.stringify(data)
            }
        );

        const result = await res.json();

        // 🔴 VALIDATION
        if (res.status === 422) {

            Object.keys(result.errors).forEach(field => {

                const el = document.getElementById('err-' + field);

                if (el) {
                    el.innerText = result.errors[field][0];
                }
            });
            btn.disabled = false;
            btn.innerHTML = '<i class="ri-check-line"></i> Add Subcategory';
            return;
        }

        // ✅ SUCCESS
        toast(result.message, 'success');
        document.getElementById('sub-cat-parent').value = '';
        document.getElementById('sub-cat-name').value = '';
        document.getElementById('sub-cat-desc').value = '';
        closeModal('add-sub-modal');
        setTimeout(function(){
            location.reload();
        },1500);

    } catch (err) {

        console.log(err);
    }

    btn.disabled = false;

    btn.innerHTML = '<i class="ri-check-line"></i> Add Subcategory';
}
</script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    function clearErrorOnInput(inputId, errorId, eventType = 'input') {

        const input = document.getElementById(inputId);

        const error = document.getElementById(errorId);

        if (!input || !error) return;

        input.addEventListener(eventType, function () {

            error.innerText = '';

        });
    }

    // 🔥 INPUTS
    clearErrorOnInput('sub-cat-name', 'err-name');

    clearErrorOnInput('sub-cat-desc', 'err-description');

    // 🔥 SELECT
    clearErrorOnInput(
        'sub-cat-parent',
        'err-category_id',
        'change'
    );

});

</script>

@php

$cats = $categories->mapWithKeys(function ($category) {
    return [
        $category->id => [
            'id' => $category->id,
            'name' => $category->name,
            'icon' => $category->icon,
            'bg' => $category->color,
            'subs' => $category->subcategories
                ->where('role', 'user')
                ->map(function ($sub) {
                    return [

                        'id' => $sub->id,
                        'name' => $sub->name,
                        'description' => $sub->description,
                    ];
                })
                ->values()
                ->toArray()
        ]
    ];

})->toArray();

@endphp
<script>
window.CATS = @json($cats);
</script>

<script>
window.DB_REMINDERS = @json($reminders);
console.log('Reminders loaded:', window.DB_REMINDERS);
</script>


@endsection


