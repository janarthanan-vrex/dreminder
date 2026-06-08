@extends('admin.layouts.app')
@section('content')

<style>
.blog-status-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0}
.blog-status-dot.active{background:var(--green)}
.blog-status-dot.inactive{background:var(--text4)}
.filter-pill{padding:6px 14px;border-radius:100px;font-size:.75rem;font-weight:700;cursor:pointer;border:1px solid var(--border);background:transparent;color:var(--text3);transition:all .2s;white-space:nowrap}
.filter-pill:hover{border-color:rgba(124,58,237,.3);color:var(--text2)}
.filter-pill.active{background:rgba(124,58,237,.15);border-color:rgba(124,58,237,.35);color:var(--purple-light)}
.blog-thumb{width:52px;height:52px;border-radius:var(--radius-sm);object-fit:cover;border:1px solid var(--border);flex-shrink:0}
.blog-thumb-placeholder{width:52px;height:52px;border-radius:var(--radius-sm);background:var(--ctrl-bg);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--text4);flex-shrink:0}
.cat-pill{display:inline-flex;align-items:center;padding:3px 10px;border-radius:100px;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em}
.cat-pill.savings{background:rgba(16,185,129,.12);color:#6ee7b7}
.cat-pill.tips{background:rgba(124,58,237,.12);color:var(--purple-light)}
.cat-pill.guide{background:rgba(6,182,212,.12);color:#67e8f9}
.cat-pill.news{background:rgba(245,158,11,.1);color:#fcd34d}
.cat-pill.finance{background:rgba(239,68,68,.1);color:#fca5a5}
.bulk-bar{display:none;align-items:center;gap:10px;padding:10px 16px;background:rgba(124,58,237,.08);border:1px solid rgba(124,58,237,.2);border-radius:12px;margin-bottom:14px}
.bulk-bar.show{display:flex}
</style>

<!-- Header -->
<div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px">
    <div>
        <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800">Blog Posts</h2>
        <p style="font-size:.8rem;color:var(--text3);margin-top:3px">Manage articles, drafts and categories</p>
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap">
        <a href="{{ route('admin.blog.create') }}" class="btn btn-primary btn-sm"><i class="ri-add-line"></i> New Post</a>
    </div>
</div>

<!-- Filters & Search -->
<div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:14px">
    <div style="display:flex;gap:6px;overflow-x:auto;flex-wrap:wrap" id="blog-filter-pills">
        <button class="filter-pill active" data-filter="all" onclick="filterPosts('all',this)">All <span style="opacity:.5">({{ $posts->count() }})</span></button>
        <button class="filter-pill" data-filter="active" onclick="filterPosts('active',this)"><span class="blog-status-dot active" style="display:inline-block;margin-right:4px"></span>Active <span style="opacity:.5">({{ $posts->where('is_active',true)->count() }})</span></button>
        <button class="filter-pill" data-filter="inactive" onclick="filterPosts('inactive',this)"><span class="blog-status-dot inactive" style="display:inline-block;margin-right:4px"></span>Inactive <span style="opacity:.5">({{ $posts->where('is_active',false)->count() }})</span></button>
    </div>
    <div style="margin-left:auto;display:flex;gap:8px;align-items:center;flex-wrap:wrap">
        <select class="inp" style="width:130px;font-size:.78rem" onchange="filterByCategory(this.value)">
            <option value="">All Categories</option>
            <option value="savings">Savings</option>
            <option value="tips">Tips & Tricks</option>
            <option value="guide">Guides</option>
            <option value="news">News</option>
            <option value="finance">Finance</option>
        </select>
        <div style="position:relative">
            <i class="ri-search-line" style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--text4);font-size:.9rem"></i>
            <input class="inp" id="blog-search" placeholder="Search posts…" style="padding-left:32px;width:200px;font-size:.8rem" oninput="searchPosts(this.value)">
        </div>
    </div>
</div>

<!-- Bulk Actions Bar -->
<div class="bulk-bar" id="bulk-bar">
    <label style="font-size:.8rem;color:var(--text2);font-weight:600"><span id="bulk-count">0</span> selected</label>
    <button class="btn btn-ghost btn-sm" onclick="bulkAction('activate')"><i class="ri-eye-line"></i> Activate</button>
    <button class="btn btn-ghost btn-sm" onclick="bulkAction('deactivate')"><i class="ri-eye-off-line"></i> Deactivate</button>
    <button class="btn btn-danger btn-sm" onclick="bulkAction('delete')"><i class="ri-delete-bin-line"></i> Delete</button>
    <button class="btn btn-ghost btn-sm" onclick="clearBulk()" style="margin-left:auto"><i class="ri-close-line"></i> Clear</button>
</div>

<!-- Table -->
<div class="card" style="padding:0;overflow:hidden">
    <table class="data-table" id="blog-table">
        <thead>
            <tr>
                <th style="width:36px">S.No</th>
                <th>Post</th>
                <th>Category</th>
                <th>Status</th>
                <th>Date</th>
                <th style="width:100px">Actions</th>
            </tr>
        </thead>
        <tbody id="blog-tbody">
            @forelse($posts as $post)
            <tr class="blog-row" data-status="{{ $post->is_active ? 'active' : 'inactive' }}" data-cat="{{ $post->category }}">
                <td>{{$loop->iteration}}</td>
                <td>
                    <div style="display:flex;align-items:center;gap:12px">
                        @if($post->featured_image)
                            <img src="{{ asset($post->featured_image) }}" class="blog-thumb" alt="">
                        @else
                            <div class="blog-thumb-placeholder"><i class="ri-image-line" style="font-size:1.2rem"></i></div>
                        @endif
                        <div>
                            <div style="font-weight:700;font-size:.85rem;color:var(--text);line-height:1.4;max-width:320px">{{ $post->title }}</div>
                            <div style="font-size:.72rem;color:var(--text4);margin-top:3px;display:flex;align-items:center;gap:8px">
                                <i class="ri-link"></i>
                                <span style="color:var(--text4)">/blog/{{ $post->slug }}</span>
                            </div>
                        </div>
                    </div>
                </td>
                <td><span class="cat-pill {{ $post->category }}">{{ ucfirst($post->category) }}</span></td>
                <td>
                    <label style="display:inline-flex;align-items:center;gap:6px;cursor:pointer">
                        <div class="toggle-status" onclick="toggleStatus(this,{{ $post->id }})"
                             data-active="{{ $post->is_active ? '1' : '0' }}"
                             style="width:36px;height:20px;border-radius:20px;background:{{ $post->is_active ? 'var(--green)' : 'var(--text4)' }};position:relative;transition:background .2s;flex-shrink:0">
                            <span style="position:absolute;width:14px;height:14px;background:#fff;border-radius:50%;top:3px;left:{{ $post->is_active ? '19px' : '3px' }};transition:left .2s"></span>
                        </div>
                        <span class="status-label" style="font-size:.75rem;font-weight:600;color:{{ $post->is_active ? 'var(--green)' : 'var(--text4)' }}">
                            {{ $post->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </label>
                </td>
                <td><span style="font-size:.78rem;color:var(--text3)">{{ $post->created_at->format('M d, Y') }}</span></td>
                <td>
                    <div style="display:flex;gap:4px">
                        <a href="{{ route('admin.blog.edit', $post->id) }}" class="btn btn-ghost btn-sm" title="Edit"><i class="ri-edit-line"></i></a>
                        <button class="btn btn-danger btn-sm" onclick="deletePost({{ $post->id }}, this)" title="Delete"><i class="ri-delete-bin-line"></i></button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center;padding:40px;color:var(--text4);font-size:.85rem">
                    <i class="ri-article-line" style="font-size:2rem;display:block;margin-bottom:8px"></i>
                    No blog posts found. <a href="{{ route('admin.blog.create') }}" style="color:var(--purple)">Create your first post</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div style="display:flex;align-items:center;justify-content:space-between;margin-top:16px;flex-wrap:wrap;gap:10px">
    <span style="font-size:.78rem;color:var(--text3)">Showing {{ $posts->count() }} posts</span>
</div>

<!-- Delete Confirm Modal -->
<div class="modal-bg" id="delete-confirm-modal">
    <div class="modal-box" style="max-width:380px;text-align:center">
        <div style="width:52px;height:52px;border-radius:50%;background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.2);display:flex;align-items:center;justify-content:center;margin:0 auto 14px;font-size:1.5rem;color:var(--red)"><i class="ri-delete-bin-line"></i></div>
        <h3 class="font-jakarta" style="font-weight:800;font-size:1rem;margin-bottom:8px">Delete Post?</h3>
        <p style="font-size:.8rem;color:var(--text3);margin-bottom:20px">This action cannot be undone. The post will be permanently removed.</p>
        <div style="display:flex;gap:8px;justify-content:center">
            <button class="btn btn-ghost btn-sm" onclick="closeModal('delete-confirm-modal')">Cancel</button>
            <button class="btn btn-danger btn-sm" id="confirm-delete-btn">Delete Post</button>
        </div>
    </div>
</div>

<script>
var pendingDeleteId   = null;
var pendingDeleteRow  = null;

function filterPosts(status, btn){
    document.querySelectorAll('.filter-pill').forEach(p=>p.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('.blog-row').forEach(row=>{
        row.style.display = (status==='all' || row.dataset.status===status) ? '' : 'none';
    });
}

function filterByCategory(cat){
    document.querySelectorAll('.blog-row').forEach(row=>{
        row.style.display = (!cat || row.dataset.cat.toLowerCase()===cat.toLowerCase()) ? '' : 'none';
    });
}

function searchPosts(q){
    q = q.toLowerCase().trim();
    document.querySelectorAll('.blog-row').forEach(row=>{
        row.style.display = (!q || row.textContent.toLowerCase().includes(q)) ? '' : 'none';
    });
}

function selectAll(cb){
    document.querySelectorAll('.row-check').forEach(c=>c.checked=cb.checked);
    updateBulk();
}

function updateBulk(){
    var checked = document.querySelectorAll('.row-check:checked').length;
    document.getElementById('bulk-count').textContent = checked;
    document.getElementById('bulk-bar').classList.toggle('show', checked>0);
    document.getElementById('select-all').indeterminate = checked>0 && checked<document.querySelectorAll('.row-check').length;
}

function clearBulk(){
    document.querySelectorAll('.row-check').forEach(c=>c.checked=false);
    document.getElementById('select-all').checked = false;
    updateBulk();
}

function bulkAction(action){
    var checked = document.querySelectorAll('.row-check:checked').length;
    if(!checked) return;
    if(action==='delete' && !confirm('Delete '+checked+' selected post(s)?')) return;
    if(typeof toast==='function') toast(checked+' post(s) '+action+'d','success');
    clearBulk();
}

function toggleStatus(toggle, id){
    var isActive = toggle.dataset.active === '1';
    var newVal   = isActive ? 0 : 1;
    var label    = toggle.parentElement.querySelector('.status-label');
    var knob     = toggle.querySelector('span');

    toggle.dataset.active      = newVal;
    toggle.style.background    = newVal ? 'var(--green)' : 'var(--text4)';
    knob.style.left            = newVal ? '19px' : '3px';
    label.textContent          = newVal ? 'Active' : 'Inactive';
    label.style.color          = newVal ? 'var(--green)' : 'var(--text4)';
    toggle.closest('tr').dataset.status = newVal ? 'active' : 'inactive';

    fetch('/admin/blog/' + id + '/toggle-status', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ is_active: newVal })
    }).then(r => r.json()).then(data => {
        if(typeof toast === 'function') toast(data.message, 'success');
         setTimeout(()=>{
                    location.reload();
                },1500)
    });
}

function deletePost(id, btn){
    pendingDeleteId  = id;
    pendingDeleteRow = btn.closest('tr');
    document.getElementById('confirm-delete-btn').onclick = function(){
        fetch('/admin/blog/' + pendingDeleteId, {
            method: 'DELETE',
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        })
        .then(r => r.json())
        .then(data => {
            if(data.success){
                pendingDeleteRow.style.opacity = '0';
                pendingDeleteRow.style.transition = 'opacity .3s';
                setTimeout(() => pendingDeleteRow.remove(), 300);
                if(typeof toast === 'function') toast(data.message, 'success');
                setTimeout(()=>{
                    location.reload();
                },1500)
            }
            closeModal('delete-confirm-modal');
        });
    };
    openModal('delete-confirm-modal');
}
</script>

@endsection