@extends('admin.layouts.app')
@section('content')

<style>
    .cms-tab-btn {
        padding: 10px 18px; background: transparent; border: none;
        color: var(--text3); font-size: 0.8rem; font-weight: 600;
        cursor: pointer; border-bottom: 2px solid transparent;
        transition: all 0.2s; display: flex; align-items: center; gap: 6px;
    }
    .cms-tab-btn:hover { color: var(--text2); }
    .cms-tab-btn.active { color: var(--purple); border-bottom-color: var(--purple); }
    .cms-tab-content { display: none; }
    .cms-tab-content.active { display: block; }
    .field-group { margin-bottom: 16px; }
    .field-group .label {
        margin-bottom: 6px; display: block; font-size: 0.75rem;
        font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: 0.05em;
    }
    .inp-area {
        width: 100%; background: var(--surface2); border: 1px solid var(--border);
        border-radius: var(--radius-sm); padding: 10px 14px; color: var(--text);
        font-size: 0.85rem; resize: vertical; font-family: inherit; transition: border-color 0.2s;
    }
    .inp-area:focus { outline: none; border-color: var(--purple); }
    .faq-cat-section { margin-bottom: 20px; }
    .faq-cat-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 12px 16px; background: var(--row-bg); border: 1px solid var(--border);
        border-radius: 12px; margin-bottom: 8px; cursor: pointer;
    }
    .faq-cat-header h4 { display: flex; align-items: center; gap: 8px; font-size: 0.88rem; font-weight: 700; color: var(--text); }
    .faq-item-row {
        display: flex; align-items: flex-start; gap: 10px; padding: 12px 14px;
        background: var(--bg2); border: 1px solid var(--border2);
        border-radius: var(--radius-sm); margin-bottom: 6px; position: relative;
    }
    .faq-item-row:hover { border-color: rgba(124,58,237,0.2); }
    .drag-handle { color: var(--text4); font-size: 1.1rem; padding-top: 10px; cursor: grab; flex-shrink: 0; }
    .faq-item-body { flex: 1; }
    .faq-item-actions { display: flex; flex-direction: column; gap: 4px; flex-shrink: 0; }
    .faq-status-badge {
        display: inline-flex; align-items: center; gap: 4px; padding: 3px 8px;
        border-radius: var(--radius-xs); font-size: 0.65rem; font-weight: 700; cursor: pointer;
    }
    .faq-status-badge.active {
        background: rgba(16,185,129,0.12); color: var(--green); border: 1px solid rgba(16,185,129,0.2);
    }
    .faq-status-badge.draft {
        background: rgba(245,158,11,0.12); color: var(--amber); border: 1px solid rgba(245,158,11,0.2);
    }
    .cat-color-opt {
        width: 22px; height: 22px; border-radius: 50%; cursor: pointer;
        border: 2px solid transparent; transition: all 0.2s;
    }
    .cat-color-opt:hover, .cat-color-opt.selected { border-color: var(--text3); transform: scale(1.15); }
    .faq-item-row input[readonly], .faq-item-row textarea[readonly] { background: transparent; border-color: transparent; cursor: default; }
    .faq-item-row input:not([readonly]), .faq-item-row textarea:not([readonly]) { background: var(--surface2); border: 1px solid var(--purple); }
</style>

<div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px">
    <div>
        <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800">CMS — FAQ Page</h2>
        <p style="font-size:0.8rem;color:var(--text3);margin-top:3px">Manage questions, categories, hero text and SEO</p>
    </div>
    <div style="display:flex;gap:8px">
        
        <button class="btn btn-primary btn-sm" onclick="openModal('add-faq-modal')"><i class="ri-add-line"></i> Add FAQ</button>
    </div>
</div>

<!-- Tabs -->
<div style="display:flex;gap:8px;margin-bottom:20px;border-bottom:2px solid rgba(255,255,255,0.05)">
    <button class="cms-tab-btn active" onclick="switchTab('content')" id="tab-btn-content"><i class="ri-layout-line"></i> Content & FAQs</button>
    <button class="cms-tab-btn" onclick="switchTab('categories')" id="tab-btn-categories"><i class="ri-folder-line"></i> Categories</button>
</div>

<!-- CONTENT TAB -->
<div class="cms-tab-content active" id="tab-content">
    <div class="g2" style="align-items:center;margin-bottom:12px">
        <div class="section-title" style="margin:0">
            FAQ Items
            <span class="badge badge-purple" style="margin-left:8px" id="total-faqs">
                {{ $categories->sum('faqs_count') }} Total
            </span>
        </div>
        <div style="display:flex;gap:8px;margin-left:auto">
            <input type="text" class="inp" placeholder="Search FAQs..." style="width:220px" oninput="filterFAQs(this.value)"/>
            <select class="inp" style="width:auto" onchange="filterByCategory(this.value)">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @foreach($categories as $category)
    <div class="faq-cat-section" id="cat-{{ $category->slug }}" data-category-id="{{ $category->id }}">
        <div class="faq-cat-header" onclick="toggleCat('{{ $category->slug }}')">
            <h4>
                <i class="{{ $category->icon }}" style="color:{{ $category->color }}"></i>
                {{ $category->name }}
                <span class="badge" style="font-size:0.65rem;background:{{ $category->color }}22;color:{{ $category->color }}">
                    {{ $category->faqs->count() }}
                </span>
            </h4>
            <div style="display:flex;align-items:center;gap:8px">
                <button class="btn btn-ghost btn-sm" onclick="event.stopPropagation();openAddInCategory({{ $category->id }})">
                    <i class="ri-add-line"></i>
                </button>
                <i class="ri-arrow-down-s-line" style="color:var(--text3)"></i>
            </div>
        </div>
        <div id="{{ $category->slug }}-items">
            @foreach($category->faqs as $faq)
            <div class="faq-item-row" data-faq-id="{{ $faq->id }}">
                <i class="ri-draggable drag-handle"></i>
                <div class="faq-item-body">
                    <input class="inp faq-question" value="{{ $faq->question }}" style="margin-bottom:8px;font-weight:600" readonly/>
                    <textarea class="inp-area inp faq-answer" rows="2" readonly>{{ $faq->answer }}</textarea>
                </div>
                <div class="faq-item-actions">
                    <span class="faq-status-badge {{ $faq->status }}" onclick="toggleStatus(this)">
                        <i class="ri-{{ $faq->status === 'active' ? 'eye' : 'draft' }}-line"></i>
                        {{ ucfirst($faq->status) }}
                    </span>
                    <button class="btn btn-ghost btn-sm edit-btn" onclick="openEditFAQ(this)">
                        <i class="ri-edit-line"></i>Edit
                    </button>
                    <button class="btn btn-danger btn-sm" onclick="deleteFAQ(this)">
                        <i class="ri-delete-bin-line"></i>Delete
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
</div>

<!-- CATEGORIES TAB -->
<div class="cms-tab-content" id="tab-categories">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
        <div class="section-title" style="margin:0">Manage Categories</div>
        <!-- <button class="btn btn-primary btn-sm" onclick="openModal('add-cat-modal')">
            <i class="ri-add-line"></i> New Category
        </button> -->
        <button class="btn btn-primary btn-sm" onclick="openNewCategoryModal()">
    <i class="ri-add-line"></i> New Category
</button>
    </div>
    <div class="card" style="padding:0;overflow:hidden">
        <table class="data-table" id="cat-table">
            <thead>
                <tr>
                    <th>Category</th><th>Icon</th><th>Color</th><th>FAQ Count</th><th>Visible</th><th>Actions</th>
                </tr>
            </thead>
            <tbody id="cat-tbody">
                @foreach($categories as $cat)
                <tr data-cat-id="{{ $cat->id }}">
                    <td>
                        <div style="font-weight:700">{{ $cat->name }}</div>
                        <div style="font-size:0.72rem;color:var(--text4)">{{ $cat->description }}</div>
                    </td>
                    <td><i class="{{ $cat->icon }}" style="color:{{ $cat->color }};font-size:1.1rem"></i> {{ $cat->icon }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:6px">
                            <div style="width:18px;height:18px;border-radius:50%;background:{{ $cat->color }}"></div>
                            {{ $cat->color }}
                        </div>
                    </td>
                    <td><span class="badge" style="background:{{ $cat->color }}22;color:{{ $cat->color }}">{{ $cat->faqs_count }}</span></td>
                    <td>
                        <label class="toggle-switch">
                            <input type="checkbox" {{ $cat->is_visible ? 'checked' : '' }}
                                onchange="toggleCategoryVisible(this, {{ $cat->id }})">
                            <span class="toggle-slider"></span>
                        </label>
                    </td>
                    <td>
                        <div style="display:flex;gap:4px">
                            <button class="btn btn-ghost btn-sm" data-edit-cat="{{ $cat->id }}" onclick="openEditCategoryModal(this)">
                                <i class="ri-edit-line"></i>Edit
                            </button>
                           <button class="btn btn-danger btn-sm delete-cat-btn"
    data-cat-id="{{ $cat->id }}"
    data-cat-name="{{ $cat->name }}"
    data-cat-slug="{{ $cat->slug }}">
    <i class="ri-delete-bin-line"></i>Delete
</button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Delete Confirm Modal -->
<div class="modal-bg" id="delete-cat-modal">
    <div class="modal-box" style="max-width:400px">
        <div class="modal-header">
            <h3 class="font-jakarta" style="font-weight:700;font-size:0.95rem">
                <i class="ri-error-warning-line" style="color:var(--red);margin-right:6px"></i>Delete Category
            </h3>
            <button class="modal-close" onclick="closeModal('delete-cat-modal')"><i class="ri-close-line"></i></button>
        </div>
        <p style="font-size:0.85rem;color:var(--text3);margin-bottom:6px">
            Are you sure you want to delete <strong id="delete-cat-name" style="color:var(--text)"></strong>?
        </p>
        <p style="font-size:0.78rem;color:var(--red);margin-bottom:20px">
            <i class="ri-alert-line"></i> This will permanently delete all FAQs inside this category.
        </p>
        <div style="display:flex;gap:8px;justify-content:flex-end">
            <button class="btn btn-ghost btn-sm" onclick="closeModal('delete-cat-modal')">Cancel</button>
            <button class="btn btn-danger btn-sm" id="delete-cat-confirm-btn">
                <i class="ri-delete-bin-line"></i> Yes, Delete
            </button>
        </div>
    </div>
</div>

<!-- Add FAQ Modal -->
<div class="modal-bg" id="add-faq-modal">
    <div class="modal-box" style="max-width:600px">
        <div class="modal-header">
            <h3 class="font-jakarta" style="font-weight:700;font-size:0.95rem">
                <i class="ri-question-line" style="color:var(--purple);margin-right:6px"></i>Add FAQ Item
            </h3>
            <button class="modal-close" onclick="closeModal('add-faq-modal')"><i class="ri-close-line"></i></button>
        </div>
        <div class="field-group">
            <label class="label">Category</label>
            <select class="inp" id="faq-cat">
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="field-group">
    <label class="label">Question <span style="color:var(--red)">*</span></label>
    <input class="inp"
           id="faq-q"
           maxlength="100"
           placeholder="Enter the question..."
           oninput="clearFaqErrors()" />
    <small id="faq-q-error" style="color:red;display:none"></small>
</div>

<div class="field-group">
    <label class="label">Answer <span style="color:var(--red)">*</span></label>
    <textarea class="inp-area inp"
              id="faq-a"
              rows="4"
              placeholder="Enter the answer..."
              oninput="clearFaqErrors()"></textarea>
    <small id="faq-a-error" style="color:red;display:none"></small>
</div>
        <div class="field-group">
            <label class="label">Status</label>
            <select class="inp" id="faq-status">
                <option value="active">Active</option>
                <option value="draft">Draft</option>
            </select>
        </div>
        <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:4px">
            <button class="btn btn-ghost btn-sm" onclick="closeModal('add-faq-modal')">Cancel</button>
            <button class="btn btn-primary btn-sm" onclick="addFAQ()"><i class="ri-check-line"></i> Add FAQ</button>
        </div>
    </div>
</div>

<!-- Add/Edit Category Modal -->
<div class="modal-bg" id="add-cat-modal">
    <div class="modal-box" style="max-width:480px">
        <div class="modal-header">
            <h3 class="font-jakarta" style="font-weight:700;font-size:0.95rem">
                <i class="ri-folder-add-line" style="color:var(--purple);margin-right:6px"></i>
                <span id="cat-modal-title">New Category</span>
            </h3>
            <button class="modal-close" onclick="closeModal('add-cat-modal')"><i class="ri-close-line"></i></button>
        </div>
        <input type="hidden" id="edit-cat-id" value=""/>
        <div class="field-group">
    <label class="label">Category Name <span style="color:var(--red)">*</span></label>
    <input class="inp" id="cat-name" maxlength="100" placeholder="e.g. Technical Support" oninput="clearCategoryError()"/>
    <small id="cat-name-error" style="color:red;display:none"></small>
</div>
        <div class="field-group">
            <label class="label">Description</label>
            <input class="inp" id="cat-desc" placeholder="Short description..."/>
        </div>
        <div class="field-group">
            <label class="label">Icon (Remix Icon class)</label>
            <input class="inp" id="cat-icon" value="ri-question-line"/>
        </div>
        <div class="field-group">
            <label class="label">Color</label>
            <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:4px">
                @foreach(['#7c3aed','#10b981','#06b6d4','#f59e0b','#ef4444','#ec4899'] as $color)
                <div class="cat-color-opt {{ $color === '#7c3aed' ? 'selected' : '' }}"
                    style="background:{{ $color }}"
                    onclick="selectCatColor(this,'{{ $color }}')"></div>
                @endforeach
            </div>
        </div>
        <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:8px">
            <button class="btn btn-ghost btn-sm" onclick="closeModal('add-cat-modal')">Cancel</button>
            <button class="btn btn-primary btn-sm" onclick="saveCategory()"><i class="ri-check-line"></i> <span id="cat-save-label">Create</span></button>
        </div>
    </div>
</div>

<script>
const CSRF = '{{ csrf_token() }}';
let selectedCatColor = '#7c3aed';

/* ── Tab switching ── */
function switchTab(t) {
    document.querySelectorAll('.cms-tab-content').forEach(c => c.classList.remove('active'));
    document.querySelectorAll('.cms-tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + t).classList.add('active');
    document.getElementById('tab-btn-' + t).classList.add('active');
}

/* ── Collapse category ── */
function toggleCat(slug) {
    const el = document.getElementById(slug + '-items');
    if (el) el.style.display = el.style.display === 'none' ? '' : 'none';
}

/* ── Filter FAQs ── */
function filterFAQs(search) {
    search = search.toLowerCase().trim();

    document.querySelectorAll('.faq-item-row').forEach(row => {

        const question = row.querySelector('.faq-question')?.value.toLowerCase() || '';
        const answer = row.querySelector('.faq-answer')?.value.toLowerCase() || '';

        const match =
            question.includes(search) ||
            answer.includes(search);

        row.style.display = match || search === '' ? '' : 'none';
    });
}
function filterByCategory(slug) {
    document.querySelectorAll('.faq-cat-section').forEach(s => {
        s.style.display = (!slug || s.id === 'cat-' + slug) ? '' : 'none';
    });
}

/* ── Toggle FAQ status ── */
function toggleStatus(el) {
    const row = el.closest('.faq-item-row');
    const faqId = row.dataset.faqId;
    const isActive = el.classList.contains('active');
    const newStatus = isActive ? 'draft' : 'active';

    fetch(`/admin/cms/faqs/${faqId}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({ status: newStatus })
    }).then(r => r.json()).then(data => {
        if (data.success) {
            el.classList.toggle('active', !isActive);
            el.classList.toggle('draft', isActive);
            el.innerHTML = isActive
                ? '<i class="ri-draft-line"></i> Draft'
                : '<i class="ri-eye-line"></i> Active';
            if (typeof toast === 'function') toast('Status updated', 'success');
        }
    }).catch(() => { if (typeof toast === 'function') toast('Update failed', 'error'); });
}

/* ── Inline edit FAQ ── */
function openEditFAQ(btn) {
    const row = btn.closest('.faq-item-row');
    const faqId = row.dataset.faqId;
    const inputs = row.querySelectorAll('input.faq-question, textarea.faq-answer');
    const editing = btn.dataset.editing === 'true';

    if (!editing) {
        inputs.forEach(el => { el.removeAttribute('readonly'); });
        btn.dataset.editing = 'true';
        btn.innerHTML = '<i class="ri-check-line"></i>Save';
    } else {
        const question = row.querySelector('.faq-question').value.trim();
        const answer   = row.querySelector('.faq-answer').value.trim();
        if (!question || !answer) {
            if (typeof toast === 'function') toast('Question and answer required', 'error');
            return;
        }
        fetch(`/admin/cms/faqs/${faqId}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body: JSON.stringify({ question, answer })
        }).then(r => r.json()).then(data => {
            if (data.success) {
                inputs.forEach(el => el.setAttribute('readonly', true));
                btn.dataset.editing = 'false';
                btn.innerHTML = '<i class="ri-edit-line"></i>Edit';
                if (typeof toast === 'function') toast('FAQ updated', 'success');
            }
        }).catch(() => { if (typeof toast === 'function') toast('Save failed', 'error'); });
    }
}

/* ── Delete FAQ ── */
let currentFaqId = null;
let currentFaqRow = null;

function deleteFAQ(btn) {
    currentFaqRow = btn.closest('.faq-item-row');
    currentFaqId = currentFaqRow.dataset.faqId;

    document.getElementById('delete-cat-name').textContent = 'this FAQ';

    document.querySelector('#delete-cat-modal h3').innerHTML =
        '<i class="ri-error-warning-line" style="color:var(--red);margin-right:6px"></i>Delete FAQ';

    document.querySelector('#delete-cat-modal p:nth-of-type(2)').innerHTML =
        '<i class="ri-alert-line"></i> This action cannot be undone.';

    openModal('delete-cat-modal');
}
document.getElementById('delete-cat-confirm-btn').addEventListener('click', function () {

    if (!currentFaqId) return;

    fetch(`/admin/cms/faqs/${currentFaqId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': CSRF,
            'Accept': 'application/json'
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            currentFaqRow.remove();

            updateTotalCount();

            closeModal('delete-cat-modal');

            if (typeof toast === 'function') {
                toast('FAQ deleted', 'success');
            }
            setTimeout(()=>{
                location.reload();
            },1500)

            currentFaqId = null;
            currentFaqRow = null;
        }
    })
    .catch(() => {
        if (typeof toast === 'function') {
            toast('Delete failed', 'error');
        }
    });
});

/* ── Add FAQ ── */
function openAddInCategory(catId) {
    document.getElementById('faq-cat').value = catId;
    openModal('add-faq-modal');
}

function addFAQ() {
    const catId  = document.getElementById('faq-cat').value;
    const q      = document.getElementById('faq-q').value.trim();
    const a      = document.getElementById('faq-a').value.trim();
    const status = document.getElementById('faq-status').value;

   clearFaqErrors();

let hasError = false;

if (!q) {
    document.getElementById('faq-q-error').innerText = 'Question is required';
    document.getElementById('faq-q-error').style.display = 'block';
    hasError = true;
}

if (!a) {
    document.getElementById('faq-a-error').innerText = 'Answer is required';
    document.getElementById('faq-a-error').style.display = 'block';
    hasError = true;
}

if (hasError) {
    return;
}

    fetch('/admin/cms/faqs', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({ faq_category_id: catId, question: q, answer: a, status })
    }).then(r => r.json()).then(data => {
        if (data.success) {
            const faq = data.faq;
            const slug = faq.category?.slug ?? document.querySelector(`[data-category-id="${catId}"]`)?.id?.replace('cat-','');
            const container = document.getElementById(slug + '-items');
            if (container) {
                const html = buildFaqRow(faq);
                container.insertAdjacentHTML('beforeend', html);
            }
            document.getElementById('faq-q').value = '';
            document.getElementById('faq-a').value = '';
            closeModal('add-faq-modal');
            updateTotalCount();
            if (typeof toast === 'function') toast('FAQ added!', 'success');
            setTimeout(()=>{
                    location.reload();
            },1500);
        }
    }).catch(() => { if (typeof toast === 'function') toast('Failed to add FAQ', 'error'); });
}

function clearFaqErrors() {
    document.getElementById('faq-q-error').style.display = 'none';
    document.getElementById('faq-q-error').innerText = '';

    document.getElementById('faq-a-error').style.display = 'none';
    document.getElementById('faq-a-error').innerText = '';
}

function buildFaqRow(faq) {
    const isActive = faq.status === 'active';
    return `
    <div class="faq-item-row" data-faq-id="${faq.id}">
        <i class="ri-draggable drag-handle"></i>
        <div class="faq-item-body">
            <input class="inp faq-question" value="${escHtml(faq.question)}" style="margin-bottom:8px;font-weight:600" readonly/>
            <textarea class="inp-area inp faq-answer" rows="2" readonly>${escHtml(faq.answer)}</textarea>
        </div>
        <div class="faq-item-actions">
            <span class="faq-status-badge ${faq.status}" onclick="toggleStatus(this)">
                <i class="ri-${isActive ? 'eye' : 'draft'}-line"></i> ${isActive ? 'Active' : 'Draft'}
            </span>
            <button class="btn btn-ghost btn-sm edit-btn" onclick="openEditFAQ(this)"><i class="ri-edit-line"></i>Edit</button>
            <button class="btn btn-danger btn-sm" onclick="deleteFAQ(this)"><i class="ri-delete-bin-line"></i>Delete</button>
        </div>
    </div>`;
}

function escHtml(str) {
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

function updateTotalCount() {
    const total = document.querySelectorAll('.faq-item-row').length;
    const el = document.getElementById('total-faqs');
    if (el) el.textContent = total + ' Total';
}

/* ── Category color ── */
function selectCatColor(el, c) {
    document.querySelectorAll('.cat-color-opt').forEach(o => o.classList.remove('selected'));
    el.classList.add('selected');
    selectedCatColor = c;
}

/* ── Open edit category modal ── */

function openNewCategoryModal() {
    // Clear edit id
    document.getElementById('edit-cat-id').value = '';

    // Clear inputs
    document.getElementById('cat-name').value = '';
    document.getElementById('cat-desc').value = '';
    document.getElementById('cat-icon').value = 'ri-question-line';

    // Clear validation error
    clearCategoryError();

    // Reset modal text
    document.getElementById('cat-modal-title').textContent = 'New Category';
    document.getElementById('cat-save-label').textContent = 'Create';

    // Reset color
    selectedCatColor = '#7c3aed';

    document.querySelectorAll('.cat-color-opt').forEach(o => {
        o.classList.remove('selected');
    });

    document.querySelector('.cat-color-opt')?.classList.add('selected');

    openModal('add-cat-modal');
}
function openEditCategoryModal(btn) {
    const catId = btn.dataset.editCat;
    const row = btn.closest('tr');
    const name = row.querySelector('td:nth-child(1) div:first-child').textContent;
    const desc = row.querySelector('td:nth-child(1) div:last-child').textContent;
    const icon = row.querySelector('td:nth-child(2)').textContent.trim().split(' ').pop();
    const color = row.querySelector('td:nth-child(3) div div').style.background;
    
    document.getElementById('edit-cat-id').value = catId;
    document.getElementById('cat-name').value    = name;
    document.getElementById('cat-desc').value    = desc;
    document.getElementById('cat-icon').value    = icon;
    document.getElementById('cat-modal-title').textContent = 'Edit Category';
    document.getElementById('cat-save-label').textContent  = 'Update';
    selectedCatColor = color;
    
    document.querySelectorAll('.cat-color-opt').forEach(o => {
        const bgColor = window.getComputedStyle(o).backgroundColor;
        const hexColor = rgbToHex(bgColor);
        o.classList.toggle('selected', hexColor === color.toLowerCase() || o.style.background === color);
    });
    
    openModal('add-cat-modal');
}

function rgbToHex(rgb) {
    if (!rgb || rgb === 'rgba(0, 0, 0, 0)') return '';
    const match = rgb.match(/^rgba?\((\d+),\s*(\d+),\s*(\d+)/);
    if (!match) return rgb;
    const hex = '#' + [parseInt(match[1]), parseInt(match[2]), parseInt(match[3])]
        .map(x => x.toString(16).padStart(2, '0')).join('');
    return hex;
}

/* ── Save (create or update) category ── */
function clearCategoryError() {
    document.getElementById('cat-name-error').style.display = 'none';
    document.getElementById('cat-name-error').innerText = '';
}

function saveCategory() {
    const editId = document.getElementById('edit-cat-id').value;
    const name   = document.getElementById('cat-name').value.trim();
    const desc   = document.getElementById('cat-desc').value.trim();
    const icon   = document.getElementById('cat-icon').value.trim();

    clearCategoryError();

    if (!name) {
        document.getElementById('cat-name-error').innerText = 'Category name is required';
        document.getElementById('cat-name-error').style.display = 'block';
        return;
    }

    const isEdit = !!editId;
    const url    = isEdit ? `/admin/cms/categories/${editId}` : '/admin/cms/categories';
    const method = isEdit ? 'PUT' : 'POST';

    fetch(url, {
        method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            name,
            description: desc,
            icon,
            color: selectedCatColor
        })
    })
    .then(async response => {
        const data = await response.json();

        if (!response.ok) {
            if (data.errors?.name) {
                document.getElementById('cat-name-error').innerText = data.errors.name[0];
                document.getElementById('cat-name-error').style.display = 'block';
            }
            return;
        }

        if (data.success) {
            closeModal('add-cat-modal');
            if (typeof toast === 'function') {
                toast(isEdit ? 'Category updated!' : 'Category created!', 'success');
            }
            setTimeout(() => location.reload(), 800);
        }
    })
    .catch(() => {
        if (typeof toast === 'function') {
            toast('Save failed', 'error');
        }
    });
}

/* ── Delete category ── */
/* ── Delete category — event delegation (fixes onclick not firing) ── */
let pendingDeleteCatId   = null;
let pendingDeleteCatRow  = null;
let pendingDeleteCatSlug = null;

// Use delegation on tbody so it works even for dynamically added rows
document.getElementById('cat-tbody').addEventListener('click', function(e) {
    const btn = e.target.closest('.delete-cat-btn');
    if (!btn) return;

    pendingDeleteCatId   = btn.dataset.catId;
    pendingDeleteCatSlug = btn.dataset.catSlug;
    pendingDeleteCatRow  = btn.closest('tr');

    document.getElementById('delete-cat-name').textContent = btn.dataset.catName;
    openModal('delete-cat-modal');
});

document.getElementById('delete-cat-confirm-btn').addEventListener('click', function() {
    if (!pendingDeleteCatId) return;

    this.disabled = true;
    this.innerHTML = '<i class="ri-loader-4-line"></i> Deleting...';

    fetch(`/admin/cms/categories/${pendingDeleteCatId}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': CSRF }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            // Remove table row
            pendingDeleteCatRow?.remove();

            // Remove content-tab section (uses slug-based ID like "cat-general")
            document.getElementById('cat-' + pendingDeleteCatSlug)?.remove();

            // Remove from filter dropdown
            const opt = document.querySelector(`select option[value="${pendingDeleteCatSlug}"]`);
            opt?.remove();

            updateTotalCount();
            closeModal('delete-cat-modal');
            if (typeof toast === 'function') toast('Category deleted', 'success');
        } else {
            if (typeof toast === 'function') toast('Delete failed', 'error');
        }
    })
    .catch(() => {
        if (typeof toast === 'function') toast('Delete failed', 'error');
    })
    .finally(() => {
        this.disabled = false;
        this.innerHTML = '<i class="ri-delete-bin-line"></i> Yes, Delete';
        pendingDeleteCatId   = null;
        pendingDeleteCatRow  = null;
        pendingDeleteCatSlug = null;
    });
});

/* ── Toggle category visibility ── */
function toggleCategoryVisible(checkbox, catId) {
    fetch(`/admin/cms/categories/${catId}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({ is_visible: checkbox.checked })
    }).then(r => r.json()).then(data => {
        if (data.success && typeof toast === 'function') toast('Visibility updated', 'success');
    });
}

/* ── Reset modal on close ── */
document.getElementById('add-cat-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        document.getElementById('edit-cat-id').value = '';
        document.getElementById('cat-modal-title').textContent = 'New Category';
        document.getElementById('cat-save-label').textContent  = 'Create';
    }
});
</script>

@endsection