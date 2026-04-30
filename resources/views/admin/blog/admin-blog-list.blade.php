@extends('admin.layouts.app')
@section('content')

<style>
.blog-status-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0}
.blog-status-dot.published{background:var(--green)}
.blog-status-dot.draft{background:var(--amber)}
.blog-status-dot.scheduled{background:var(--cyan)}
.blog-status-dot.archived{background:var(--text4)}

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

.stats-mini-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-bottom:20px}
@media(max-width:768px){.stats-mini-grid{grid-template-columns:repeat(2,1fr)}}
.stat-mini{background:var(--row-bg);border:1px solid var(--border);border-radius:var(--radius);padding:14px 16px}
.stat-mini-num{font-size:1.5rem;font-weight:900;color:var(--text);line-height:1}
.stat-mini-label{font-size:.72rem;color:var(--text4);margin-top:4px;font-weight:600}
.stat-mini-change{font-size:.68rem;margin-top:6px;font-weight:700}
</style>

<!-- Header -->
<div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px">
    <div>
        <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800">Blog Posts</h2>
        <p style="font-size:.8rem;color:var(--text3);margin-top:3px">Manage articles, drafts, scheduling and categories</p>
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap">
        <a href="blog" target="_blank" class="btn btn-ghost btn-sm"><i class="ri-eye-line"></i> View Blog</a>
        <button class="btn btn-ghost btn-sm" onclick="openModal('import-modal')"><i class="ri-upload-2-line"></i> Import</button>
        <a href="{{ route('admin.blog.create') }}" class="btn btn-primary btn-sm"><i class="ri-add-line"></i> New Post</a>
    </div>
</div>

<!-- Stats -->
<div class="stats-mini-grid">
    <div class="stat-mini">
        <div class="stat-mini-num">48</div>
        <div class="stat-mini-label">Total Posts</div>
        <div class="stat-mini-change" style="color:var(--green)"><i class="ri-arrow-up-line"></i> +3 this month</div>
    </div>
    <div class="stat-mini">
        <div class="stat-mini-num">36</div>
        <div class="stat-mini-label">Published</div>
        <div class="stat-mini-change" style="color:var(--green)"><i class="ri-checkbox-circle-line"></i> Live</div>
    </div>
    <div class="stat-mini">
        <div class="stat-mini-num">8</div>
        <div class="stat-mini-label">Drafts</div>
        <div class="stat-mini-change" style="color:var(--amber)"><i class="ri-edit-line"></i> In progress</div>
    </div>
    <div class="stat-mini">
        <div class="stat-mini-num">4</div>
        <div class="stat-mini-label">Scheduled</div>
        <div class="stat-mini-change" style="color:var(--accent)"><i class="ri-calendar-line"></i> Upcoming</div>
    </div>
</div>

<!-- Filters & Search -->
<div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:14px">
    <!-- Category Pills -->
    <div style="display:flex;gap:6px;overflow-x:auto;flex-wrap:wrap" id="blog-filter-pills">
        <button class="filter-pill active" data-filter="all" onclick="filterPosts('all',this)">All <span style="opacity:.5">(48)</span></button>
        <button class="filter-pill" data-filter="published" onclick="filterPosts('published',this)"><span class="blog-status-dot published" style="display:inline-block;margin-right:4px"></span>Published <span style="opacity:.5">(36)</span></button>
        <button class="filter-pill" data-filter="draft" onclick="filterPosts('draft',this)"><span class="blog-status-dot draft" style="display:inline-block;margin-right:4px"></span>Drafts <span style="opacity:.5">(8)</span></button>
        <button class="filter-pill" data-filter="scheduled" onclick="filterPosts('scheduled',this)"><span class="blog-status-dot scheduled" style="display:inline-block;margin-right:4px"></span>Scheduled <span style="opacity:.5">(4)</span></button>
        <button class="filter-pill" data-filter="archived" onclick="filterPosts('archived',this)">Archived</button>
    </div>
    <div style="margin-left:auto;display:flex;gap:8px;align-items:center;flex-wrap:wrap">
        <!-- Category -->
        <select class="inp" style="width:130px;font-size:.78rem" onchange="filterByCategory(this.value)">
            <option value="">All Categories</option>
            <option>Savings</option>
            <option>Tips & Tricks</option>
            <option>Guides</option>
            <option>News</option>
            <option>Finance</option>
        </select>
        <!-- Search -->
        <div style="position:relative">
            <i class="ri-search-line" style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--text4);font-size:.9rem"></i>
            <input class="inp" id="blog-search" placeholder="Search posts…" style="padding-left:32px;width:200px;font-size:.8rem" oninput="searchPosts(this.value)">
        </div>
        <!-- Sort -->
        <select class="inp" style="width:140px;font-size:.78rem">
            <option>Newest First</option>
            <option>Oldest First</option>
            <option>Most Views</option>
            <option>A–Z Title</option>
        </select>
    </div>
</div>

<!-- Bulk Actions Bar -->
<div class="bulk-bar" id="bulk-bar">
    <label style="font-size:.8rem;color:var(--text2);font-weight:600"><span id="bulk-count">0</span> selected</label>
    <button class="btn btn-ghost btn-sm" onclick="bulkAction('publish')"><i class="ri-eye-line"></i> Publish</button>
    <button class="btn btn-ghost btn-sm" onclick="bulkAction('draft')"><i class="ri-draft-line"></i> Move to Draft</button>
    <button class="btn btn-ghost btn-sm" onclick="bulkAction('archive')"><i class="ri-archive-line"></i> Archive</button>
    <button class="btn btn-danger btn-sm" onclick="bulkAction('delete')"><i class="ri-delete-bin-line"></i> Delete</button>
    <button class="btn btn-ghost btn-sm" onclick="clearBulk()" style="margin-left:auto"><i class="ri-close-line"></i> Clear</button>
</div>

<!-- Table -->
<div class="card" style="padding:0;overflow:hidden">
    <table class="data-table" id="blog-table">
        <thead>
            <tr>
                <th style="width:36px"><input type="checkbox" id="select-all" onclick="selectAll(this)"></th>
                <th>Post</th>
                <th>Category</th>
                <th>Author</th>
                <th>Views</th>
                <th>Status</th>
                <th>Date</th>
                <th style="width:100px">Actions</th>
            </tr>
        </thead>
        <tbody id="blog-tbody">
            <!-- Row 1 -->
            <tr class="blog-row" data-status="published" data-cat="guide">
                <td><input type="checkbox" class="row-check" onchange="updateBulk()"></td>
                <td>
                    <div style="display:flex;align-items:center;gap:12px">
                        <img src="https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=80&q=60" class="blog-thumb" alt="">
                        <div>
                            <div style="font-weight:700;font-size:.85rem;color:var(--text);line-height:1.4;max-width:320px">The Ultimate Guide to Never Overpaying for Insurance Again</div>
                            <div style="font-size:.72rem;color:var(--text4);margin-top:3px;display:flex;align-items:center;gap:8px">
                                <i class="ri-time-line"></i> 8 min read
                                <span>·</span>
                                <i class="ri-link"></i> <a href="#" style="color:var(--text4);text-decoration:none">/blog/insurance-guide</a>
                            </div>
                        </div>
                    </div>
                </td>
                <td><span class="cat-pill guide">Guide</span></td>
                <td><span style="font-size:.8rem;color:var(--text2)">Sarah Reynolds</span></td>
                <td><span style="font-size:.85rem;font-weight:600;color:var(--text2)">4.2K</span></td>
                <td><span class="badge badge-green" style="display:inline-flex;align-items:center;gap:5px"><span class="blog-status-dot published"></span>Published</span></td>
                <td><span style="font-size:.78rem;color:var(--text3)">Apr 14, 2026</span></td>
                <td>
                    <div style="display:flex;gap:4px">
                        <a href="{{ route('admin.blog.edit', 1) }}" class="btn btn-ghost btn-sm" title="Edit"><i class="ri-edit-line"></i></a>
                        <a href="/blog-detail" target="_blank" class="btn btn-ghost btn-sm" title="View"><i class="ri-eye-line"></i></a>
                        <button class="btn btn-danger btn-sm" onclick="deletePost(1,this)" title="Delete"><i class="ri-delete-bin-line"></i></button>
                    </div>
                </td>
            </tr>
            <!-- Row 2 -->
            <tr class="blog-row" data-status="published" data-cat="savings">
                <td><input type="checkbox" class="row-check" onchange="updateBulk()"></td>
                <td>
                    <div style="display:flex;align-items:center;gap:12px">
                        <img src="https://images.unsplash.com/photo-1579621970563-ebec7560ff3e?w=80&q=60" class="blog-thumb" alt="">
                        <div>
                            <div style="font-weight:700;font-size:.85rem;color:var(--text);line-height:1.4;max-width:320px">5 Subscriptions You're Probably Paying for and Forgetting</div>
                            <div style="font-size:.72rem;color:var(--text4);margin-top:3px;display:flex;align-items:center;gap:8px">
                                <i class="ri-time-line"></i> 4 min read
                                <span>·</span>
                                <i class="ri-link"></i> <a href="#" style="color:var(--text4);text-decoration:none">/blog/forgotten-subscriptions</a>
                            </div>
                        </div>
                    </div>
                </td>
                <td><span class="cat-pill savings">Savings</span></td>
                <td><span style="font-size:.8rem;color:var(--text2)">James Morton</span></td>
                <td><span style="font-size:.85rem;font-weight:600;color:var(--text2)">1.2K</span></td>
                <td><span class="badge badge-green" style="display:inline-flex;align-items:center;gap:5px"><span class="blog-status-dot published"></span>Published</span></td>
                <td><span style="font-size:.78rem;color:var(--text3)">Apr 10, 2026</span></td>
                <td>
                    <div style="display:flex;gap:4px">
                        <a href="{{ route('admin.blog.edit', 2) }}" class="btn btn-ghost btn-sm"><i class="ri-edit-line"></i></a>
                        <a href="/blog-detail" target="_blank" class="btn btn-ghost btn-sm"><i class="ri-eye-line"></i></a>
                        <button class="btn btn-danger btn-sm" onclick="deletePost(2,this)"><i class="ri-delete-bin-line"></i></button>
                    </div>
                </td>
            </tr>
            <!-- Row 3 - Draft -->
            <tr class="blog-row" data-status="draft" data-cat="finance">
                <td><input type="checkbox" class="row-check" onchange="updateBulk()"></td>
                <td>
                    <div style="display:flex;align-items:center;gap:12px">
                        <div class="blog-thumb-placeholder"><i class="ri-image-line" style="font-size:1.2rem"></i></div>
                        <div>
                            <div style="font-weight:700;font-size:.85rem;color:var(--text);line-height:1.4;max-width:320px">Why Auto-Renewal is Costing Australians $4B a Year <span style="font-size:.68rem;color:var(--amber);font-weight:600;background:rgba(245,158,11,.1);padding:2px 7px;border-radius:6px;margin-left:4px">Draft</span></div>
                            <div style="font-size:.72rem;color:var(--text4);margin-top:3px;display:flex;align-items:center;gap:8px">
                                <i class="ri-time-line"></i> 6 min read
                                <span>·</span>
                                <span style="color:var(--amber)"><i class="ri-draft-line"></i> Unsaved changes</span>
                            </div>
                        </div>
                    </div>
                </td>
                <td><span class="cat-pill finance">Finance</span></td>
                <td><span style="font-size:.8rem;color:var(--text2)">Tom Walsh</span></td>
                <td><span style="font-size:.85rem;font-weight:600;color:var(--text4)">—</span></td>
                <td><span class="badge badge-amber" style="display:inline-flex;align-items:center;gap:5px"><span class="blog-status-dot draft"></span>Draft</span></td>
                <td><span style="font-size:.78rem;color:var(--text3)">Apr 8, 2026</span></td>
                <td>
                    <div style="display:flex;gap:4px">
                        <a href="{{ route('admin.blog.edit', 3) }}" class="btn btn-ghost btn-sm"><i class="ri-edit-line"></i></a>
                        <button class="btn btn-ghost btn-sm" title="Preview"><i class="ri-eye-off-line"></i></button>
                        <button class="btn btn-danger btn-sm" onclick="deletePost(3,this)"><i class="ri-delete-bin-line"></i></button>
                    </div>
                </td>
            </tr>
            <!-- Row 4 - Scheduled -->
            <tr class="blog-row" data-status="scheduled" data-cat="news">
                <td><input type="checkbox" class="row-check" onchange="updateBulk()"></td>
                <td>
                    <div style="display:flex;align-items:center;gap:12px">
                        <img src="https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=80&q=60" class="blog-thumb" alt="">
                        <div>
                            <div style="font-weight:700;font-size:.85rem;color:var(--text);line-height:1.4;max-width:320px">DRemind Launches Family Sharing — Protect the Whole Household</div>
                            <div style="font-size:.72rem;color:var(--text4);margin-top:3px;display:flex;align-items:center;gap:8px">
                                <i class="ri-time-line"></i> 2 min read
                                <span>·</span>
                                <i class="ri-calendar-schedule-line" style="color:var(--accent)"></i> <span style="color:var(--accent)">Publishes May 1, 2026</span>
                            </div>
                        </div>
                    </div>
                </td>
                <td><span class="cat-pill news">News</span></td>
                <td><span style="font-size:.8rem;color:var(--text2)">DRemind Team</span></td>
                <td><span style="font-size:.85rem;font-weight:600;color:var(--text4)">—</span></td>
                <td><span class="badge" style="background:rgba(6,182,212,.1);color:#67e8f9;border:1px solid rgba(6,182,212,.2);display:inline-flex;align-items:center;gap:5px"><span class="blog-status-dot scheduled"></span>Scheduled</span></td>
                <td><span style="font-size:.78rem;color:var(--text3)">May 1, 2026</span></td>
                <td>
                    <div style="display:flex;gap:4px">
                        <a href="{{ route('admin.blog.edit', 4) }}" class="btn btn-ghost btn-sm"><i class="ri-edit-line"></i></a>
                        <button class="btn btn-ghost btn-sm"><i class="ri-eye-off-line"></i></button>
                        <button class="btn btn-danger btn-sm" onclick="deletePost(4,this)"><i class="ri-delete-bin-line"></i></button>
                    </div>
                </td>
            </tr>
            <!-- Row 5 -->
            <tr class="blog-row" data-status="published" data-cat="savings">
                <td><input type="checkbox" class="row-check" onchange="updateBulk()"></td>
                <td>
                    <div style="display:flex;align-items:center;gap:12px">
                        <img src="https://images.unsplash.com/photo-1450101499163-c8848c66ca85?w=80&q=60" class="blog-thumb" alt="">
                        <div>
                            <div style="font-weight:700;font-size:.85rem;color:var(--text);line-height:1.4;max-width:320px">Car Insurance: The Loyalty VATand How to Escape It</div>
                            <div style="font-size:.72rem;color:var(--text4);margin-top:3px;display:flex;align-items:center;gap:8px">
                                <i class="ri-time-line"></i> 5 min read
                                <span>·</span>
                                <i class="ri-link"></i> <a href="#" style="color:var(--text4);text-decoration:none">/blog/car-insurance-loyalty</a>
                            </div>
                        </div>
                    </div>
                </td>
                <td><span class="cat-pill savings">Savings</span></td>
                <td><span style="font-size:.8rem;color:var(--text2)">Sarah Reynolds</span></td>
                <td><span style="font-size:.85rem;font-weight:600;color:var(--text2)">3.8K</span></td>
                <td><span class="badge badge-green" style="display:inline-flex;align-items:center;gap:5px"><span class="blog-status-dot published"></span>Published</span></td>
                <td><span style="font-size:.78rem;color:var(--text3)">Mar 28, 2026</span></td>
                <td>
                    <div style="display:flex;gap:4px">
                        <a href="{{ route('admin.blog.edit', 5) }}" class="btn btn-ghost btn-sm"><i class="ri-edit-line"></i></a>
                        <a href="/blog-detail" target="_blank" class="btn btn-ghost btn-sm"><i class="ri-eye-line"></i></a>
                        <button class="btn btn-danger btn-sm" onclick="deletePost(5,this)"><i class="ri-delete-bin-line"></i></button>
                    </div>
                </td>
            </tr>
            <!-- Row 6 -->
            <tr class="blog-row" data-status="published" data-cat="guide">
                <td><input type="checkbox" class="row-check" onchange="updateBulk()"></td>
                <td>
                    <div style="display:flex;align-items:center;gap:12px">
                        <img src="https://images.unsplash.com/photo-1542621334-a254cf47733d?w=80&q=60" class="blog-thumb" alt="">
                        <div>
                            <div style="font-weight:700;font-size:.85rem;color:var(--text);line-height:1.4;max-width:320px">Passport Renewal Checklist: Start 6 Months Early</div>
                            <div style="font-size:.72rem;color:var(--text4);margin-top:3px;display:flex;align-items:center;gap:8px">
                                <i class="ri-time-line"></i> 7 min read
                                <span>·</span>
                                <i class="ri-link"></i> <a href="#" style="color:var(--text4);text-decoration:none">/blog/passport-renewal</a>
                            </div>
                        </div>
                    </div>
                </td>
                <td><span class="cat-pill guide">Guide</span></td>
                <td><span style="font-size:.8rem;color:var(--text2)">Amy Nguyen</span></td>
                <td><span style="font-size:.85rem;font-weight:600;color:var(--text2)">2.1K</span></td>
                <td><span class="badge badge-green" style="display:inline-flex;align-items:center;gap:5px"><span class="blog-status-dot published"></span>Published</span></td>
                <td><span style="font-size:.78rem;color:var(--text3)">Mar 22, 2026</span></td>
                <td>
                    <div style="display:flex;gap:4px">
                        <a href="{{ route('admin.blog.edit', 6) }}" class="btn btn-ghost btn-sm"><i class="ri-edit-line"></i></a>
                        <a href="/blog-detail" target="_blank" class="btn btn-ghost btn-sm"><i class="ri-eye-line"></i></a>
                        <button class="btn btn-danger btn-sm" onclick="deletePost(6,this)"><i class="ri-delete-bin-line"></i></button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div style="display:flex;align-items:center;justify-content:space-between;margin-top:16px;flex-wrap:wrap;gap:10px">
    <span style="font-size:.78rem;color:var(--text3)">Showing 6 of 48 posts</span>
    <div style="display:flex;gap:6px;align-items:center">
        <button class="btn btn-ghost btn-sm" disabled><i class="ri-arrow-left-s-line"></i></button>
        <button class="btn btn-primary btn-sm">1</button>
        <button class="btn btn-ghost btn-sm">2</button>
        <button class="btn btn-ghost btn-sm">3</button>
        <span style="font-size:.78rem;color:var(--text4)">…</span>
        <button class="btn btn-ghost btn-sm">8</button>
        <button class="btn btn-ghost btn-sm"><i class="ri-arrow-right-s-line"></i></button>
    </div>
</div>

<!-- Import Modal -->
<div class="modal-bg" id="import-modal">
    <div class="modal-box" style="max-width:440px">
        <div class="modal-header">
            <div><h3 class="font-jakarta" style="font-weight:700;font-size:.95rem"><i class="ri-upload-2-line" style="color:var(--purple);margin-right:6px"></i>Import Posts</h3></div>
            <button class="modal-close" onclick="closeModal('import-modal')"><i class="ri-close-line"></i></button>
        </div>
        <p style="font-size:.8rem;color:var(--text3);margin-bottom:14px">Import posts from a CSV or JSON file. Download the template first to ensure correct formatting.</p>
        <div style="border:2px dashed rgba(255,255,255,.1);border-radius:12px;padding:32px;text-align:center;margin-bottom:14px">
            <i class="ri-file-upload-line" style="font-size:2rem;color:var(--text4);margin-bottom:8px;display:block"></i>
            <div style="font-size:.85rem;color:var(--text3);margin-bottom:10px">Drop CSV or JSON here</div>
            <button class="btn btn-ghost btn-sm">Browse File</button>
        </div>
        <div style="display:flex;gap:8px;justify-content:space-between;align-items:center">
            <a href="#" style="font-size:.78rem;color:var(--purple)"><i class="ri-download-line"></i> Download template</a>
            <button class="btn btn-primary btn-sm" onclick="closeModal('import-modal')"><i class="ri-upload-line"></i> Import</button>
        </div>
    </div>
</div>

<!-- Delete Confirm Modal -->
<div class="modal-bg" id="delete-confirm-modal">
    <div class="modal-box" style="max-width:380px;text-align:center">
        <div style="width:52px;height:52px;border-radius:50%;background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.2);display:flex;align-items:center;justify-content:center;margin:0 auto 14px;font-size:1.5rem;color:var(--red)"><i class="ri-delete-bin-line"></i></div>
        <h3 class="font-jakarta" style="font-weight:800;font-size:1rem;margin-bottom:8px">Delete Post?</h3>
        <p style="font-size:.8rem;color:var(--text3);margin-bottom:20px">This action cannot be undone. The post and all its associated data will be permanently removed.</p>
        <div style="display:flex;gap:8px;justify-content:center">
            <button class="btn btn-ghost btn-sm" onclick="closeModal('delete-confirm-modal')">Cancel</button>
            <button class="btn btn-danger btn-sm" id="confirm-delete-btn">Delete Post</button>
        </div>
    </div>
</div>

<script>
var pendingDeleteRow = null;

function filterPosts(status, btn){
    document.querySelectorAll('.filter-pill').forEach(p=>p.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('.blog-row').forEach(row=>{
        if(status==='all') row.style.display='';
        else row.style.display = row.dataset.status===status ? '' : 'none';
    });
}

function filterByCategory(cat){
    document.querySelectorAll('.blog-row').forEach(row=>{
        if(!cat) row.style.display='';
        else row.style.display = row.dataset.cat.toLowerCase()===cat.toLowerCase() ? '' : 'none';
    });
}

function searchPosts(q){
    q = q.toLowerCase().trim();
    document.querySelectorAll('.blog-row').forEach(row=>{
        const text = row.textContent.toLowerCase();
        row.style.display = !q||text.includes(q) ? '' : 'none';
    });
}

function selectAll(cb){
    document.querySelectorAll('.row-check').forEach(c=>{c.checked=cb.checked;});
    updateBulk();
}

function updateBulk(){
    var checked = document.querySelectorAll('.row-check:checked').length;
    var bar = document.getElementById('bulk-bar');
    document.getElementById('bulk-count').textContent = checked;
    bar.classList.toggle('show', checked>0);
    document.getElementById('select-all').indeterminate = checked>0 && checked<document.querySelectorAll('.row-check').length;
}

function clearBulk(){
    document.querySelectorAll('.row-check').forEach(c=>c.checked=false);
    document.getElementById('select-all').checked=false;
    updateBulk();
}

function bulkAction(action){
    var checked = document.querySelectorAll('.row-check:checked').length;
    if(!checked) return;
    if(action==='delete' && !confirm('Delete '+checked+' selected post(s)?')) return;
    if(typeof toast==='function') toast(checked+' post(s) '+action+'d','success');
    clearBulk();
}

function deletePost(id, btn){
    pendingDeleteRow = btn.closest('tr');
    document.getElementById('confirm-delete-btn').onclick = function(){
        if(pendingDeleteRow){
            pendingDeleteRow.style.opacity='0';
            pendingDeleteRow.style.transition='opacity .3s';
            setTimeout(()=>{ if(pendingDeleteRow) pendingDeleteRow.remove(); }, 300);
        }
        closeModal('delete-confirm-modal');
        if(typeof toast==='function') toast('Post deleted','success');
    };
    openModal('delete-confirm-modal');
}
</script>

@endsection