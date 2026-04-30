@extends('admin.layouts.app')
@section('content')

<!-- ═══ CATEGORIES ═══ -->
<section id="page-categories" class="page active">
    <div class="flex items-start justify-between gap-3 flex-wrap mb-[18px]">
        <div>
            <h2 class="font-jakarta text-[1.25rem] font-extrabold text-[var(--text)]">
                Categories & Subcategories
            </h2>
            <p class="text-[.82rem] text-[var(--text3)] mt-1">
                Manage parent categories and child subcategories from one place
            </p>
        </div>

        <div class="flex gap-2 flex-wrap">
            <button class="btn btn-ghost btn-sm" onclick="openModal('add-subcategory-modal')">
                <i class="ri-node-tree"></i> Add Subcategory
            </button>
            <button class="btn btn-primary btn-sm" onclick="openModal('add-category-modal')">
                <i class="ri-add-line"></i> Add Category
            </button>
        </div>
    </div>

    <div class="flex gap-2.5 mb-4 flex-wrap">

        <div class="card flex items-center gap-2 px-[14px] py-2 rounded-full">
            <span class="text-[.8rem] text-[var(--text3)] flex items-center gap-1">
                <span class="w-[7px] h-[7px] bg-red-500 inline-block rounded-full me-1"></span>
                Categories
            </span>
            <span id="stat-total-categories" class="text-[.9rem] font-bold text-[var(--text)]">
                0
            </span>
        </div>

        <div class="card flex items-center gap-2 px-[14px] py-2 rounded-full">
            <span class="text-[.8rem] text-[var(--text3)]">
                <span class="w-[7px] h-[7px] bg-green-500 inline-block rounded-full me-1"></span>
                Subcategories
            </span>
            <span id="stat-total-subcategories" class="text-[.9rem] font-bold text-[var(--text)]">
                0
            </span>
        </div>

        <div class="card flex items-center gap-2 px-[14px] py-2 rounded-full">
            <span class="text-[.8rem] text-[var(--text3)]">
                <span class="w-[7px] h-[7px] bg-blue-500 inline-block rounded-full me-1"></span>
                Top
            </span>
            <span id="stat-top-category" class="text-[.9rem] font-bold text-[var(--text)]">
                -
            </span>
        </div>

    </div>

    <div id="admin-cat-grid"
         class="grid grid-cols-[repeat(auto-fill,minmax(280px,1fr))] gap-[14px]">
    </div>
</section>

@endsection