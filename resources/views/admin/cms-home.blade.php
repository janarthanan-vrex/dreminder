@extends('admin.layouts.app')
@section('content')

<style>
/* ══ CMS MODULE STYLES ══════════════════════════════════════════ */
.cms-layout{display:grid;grid-template-columns:280px 1fr;gap:0;height:calc(100vh - 80px);overflow:hidden;border:1px solid var(--border);border-radius:var(--radius);background:var(--card)}

/* PAGE TREE */
.cms-tree{border-right:1px solid var(--border);display:flex;flex-direction:column;overflow:hidden}
.cms-tree-header{padding:16px;border-bottom:1px solid var(--border);flex-shrink:0}
.cms-tree-search{width:100%;background:var(--row-bg);border:1px solid var(--border);color:var(--text);border-radius:var(--radius-xs);padding:7px 10px 7px 32px;font-size:.78rem;outline:none;transition:border-color .2s}
.cms-tree-search:focus{border-color:var(--purple)}
.cms-tree-body{flex:1;overflow-y:auto;padding:8px}
.page-item{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:var(--radius-xs);cursor:pointer;transition:all .18s;border:1px solid transparent;margin-bottom:3px;position:relative}
.page-item:hover{background:var(--row-bg);border-color:var(--border)}
.page-item.active{background:rgba(124,58,237,.12);border-color:rgba(124,58,237,.25)}
.page-item.active .page-item-title{color:var(--purple-light)}
.page-item-icon{width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:.9rem;flex-shrink:0}
.page-item-title{font-size:.8rem;font-weight:600;color:var(--text2);line-height:1.2}
.page-item-slug{font-size:.65rem;color:var(--text4);margin-top:1px}
.page-status-dot{width:6px;height:6px;border-radius:50%;margin-left:auto;flex-shrink:0}
.page-item-count{font-size:.6rem;font-weight:700;padding:1px 6px;border-radius:99px;background:rgba(124,58,237,.15);color:var(--purple-light);border:1px solid rgba(124,58,237,.2);margin-left:auto}

/* EDITOR MAIN */
.cms-editor{display:flex;flex-direction:column;overflow:hidden}
.cms-editor-topbar{display:flex;align-items:center;justify-content:space-between;padding:12px 20px;border-bottom:1px solid var(--border);flex-shrink:0;gap:10px}
.cms-editor-body{flex:1;overflow-y:auto;padding:0}

/* SECTION CARDS */
.cms-section-card{border-bottom:1px solid var(--border2)}
.cms-section-head{display:flex;align-items:center;gap:10px;padding:14px 20px;cursor:pointer;transition:background .15s;user-select:none}
.cms-section-head:hover{background:var(--row-bg)}
.cms-section-head.open{background:rgba(124,58,237,.04)}
.cms-section-chevron{font-size:.9rem;color:var(--text3);transition:transform .25s;flex-shrink:0}
.cms-section-head.open .cms-section-chevron{transform:rotate(90deg)}
.cms-section-label{font-size:.8rem;font-weight:700;color:var(--text2);flex:1}
.cms-section-badge{font-size:.6rem;font-weight:700;padding:2px 8px;border-radius:99px}
.cms-section-body{display:none;padding:0 20px 20px}
.cms-section-body.open{display:block}

/* FIELD GROUPS */
.cms-field{margin-bottom:14px}
.cms-field:last-child{margin-bottom:0}
.cms-field-label{font-size:.68rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.07em;margin-bottom:5px;display:flex;align-items:center;gap:6px}
.cms-input{width:100%;background:var(--row-bg);border:1px solid var(--border);color:var(--text);border-radius:var(--radius-xs);padding:8px 11px;font-size:.82rem;font-family:'DM Sans',sans-serif;outline:none;transition:border-color .2s;box-sizing:border-box}
.cms-input:focus{border-color:var(--purple);box-shadow:0 0 0 2px rgba(124,58,237,.1)}
.cms-textarea{resize:vertical;min-height:72px;line-height:1.55}
.cms-input-row{display:grid;grid-template-columns:1fr 1fr;gap:10px}
.cms-input-row-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px}
.cms-divider{height:1px;background:var(--border2);margin:16px 0}

/* TOGGLE SWITCH */
.cms-toggle{display:flex;align-items:center;justify-content:space-between;padding:10px 12px;border-radius:var(--radius-xs);background:var(--row-bg);border:1px solid var(--border);margin-bottom:6px}
.cms-toggle-label{font-size:.78rem;font-weight:600;color:var(--text2)}
.cms-toggle-sub{font-size:.65rem;color:var(--text4);margin-top:1px}
.switch{position:relative;width:36px;height:20px;flex-shrink:0}
.switch input{opacity:0;width:0;height:0}
.switch-slider{position:absolute;cursor:pointer;inset:0;background:var(--ctrl-bg);border:1px solid var(--border);border-radius:10px;transition:.25s}
.switch-slider:before{content:'';position:absolute;height:14px;width:14px;left:2px;bottom:2px;background:#fff;border-radius:50%;transition:.25s}
.switch input:checked + .switch-slider{background:var(--purple);border-color:var(--purple)}
.switch input:checked + .switch-slider:before{transform:translateX(16px)}

/* ICON PICKER */
.icon-picker-wrap{position:relative}
.icon-preview-btn{display:flex;align-items:center;gap:8px;padding:8px 12px;border-radius:var(--radius-xs);background:var(--row-bg);border:1px solid var(--border);cursor:pointer;transition:all .2s;width:100%}
.icon-preview-btn:hover{border-color:rgba(124,58,237,.4)}
.icon-preview-icon{width:28px;height:28px;border-radius:6px;background:rgba(124,58,237,.15);display:flex;align-items:center;justify-content:center;font-size:.9rem;color:var(--purple-light)}
.icon-preview-name{font-size:.78rem;color:var(--text2);flex:1}
.icon-dropdown{position:absolute;top:calc(100% + 6px);left:0;right:0;background:var(--bg2);border:1px solid rgba(124,58,237,.25);border-radius:var(--radius-sm);z-index:999;box-shadow:0 16px 40px rgba(0,0,0,.45);display:none}
.icon-dropdown.open{display:block}
.icon-search{width:100%;background:transparent;border:none;border-bottom:1px solid var(--border);color:var(--text);padding:10px 14px;font-size:.78rem;outline:none}
.icon-grid{display:grid;grid-template-columns:repeat(8,1fr);gap:2px;padding:8px;max-height:200px;overflow-y:auto}
.icon-grid-btn{width:32px;height:32px;border-radius:6px;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .15s;border:1px solid transparent;font-size:.95rem;color:var(--text3)}
.icon-grid-btn:hover{background:rgba(124,58,237,.15);color:var(--purple-light);border-color:rgba(124,58,237,.3)}
.icon-grid-btn.selected{background:rgba(124,58,237,.2);color:var(--purple-light);border-color:rgba(124,58,237,.4)}

/* COLOR PICKER ROW */
.color-swatch-row{display:flex;flex-wrap:wrap;gap:6px;margin-top:4px}
.color-swatch{width:24px;height:24px;border-radius:6px;cursor:pointer;border:2px solid transparent;transition:all .15s}
.color-swatch:hover{transform:scale(1.15)}
.color-swatch.active{border-color:#fff;box-shadow:0 0 0 2px rgba(124,58,237,.5)}

/* REPEATER */
.cms-repeater-item{background:var(--row-bg);border:1px solid var(--border);border-radius:var(--radius-sm);padding:12px;margin-bottom:8px;position:relative}
.cms-repeater-item:last-child{margin-bottom:0}
.cms-repeater-item-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:10px}
.cms-repeater-title{font-size:.75rem;font-weight:700;color:var(--text3)}
.cms-repeater-remove{background:rgba(244,63,94,.1);border:1px solid rgba(244,63,94,.2);color:var(--red);width:24px;height:24px;border-radius:5px;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:.75rem;transition:all .2s}
.cms-repeater-remove:hover{background:rgba(244,63,94,.2)}
.cms-repeater-add{display:flex;align-items:center;justify-content:center;gap:6px;padding:9px;border-radius:var(--radius-xs);border:1px dashed rgba(124,58,237,.3);background:transparent;color:var(--purple-light);cursor:pointer;font-size:.76rem;font-weight:600;transition:all .2s;width:100%;margin-top:6px}
.cms-repeater-add:hover{background:rgba(124,58,237,.08);border-color:rgba(124,58,237,.5)}

/* IMAGE UPLOAD */
.cms-img-upload{border:1px dashed var(--border);border-radius:var(--radius-sm);padding:20px;text-align:center;cursor:pointer;transition:all .2s;position:relative;overflow:hidden}
.cms-img-upload:hover{border-color:rgba(124,58,237,.4);background:rgba(124,58,237,.04)}
.cms-img-preview{width:100%;height:100px;object-fit:cover;border-radius:var(--radius-xs);display:block;margin-bottom:8px}

/* EMPTY STATE */
.cms-empty{display:flex;flex-direction:column;align-items:center;justify-content:center;height:100%;padding:60px;text-align:center}

/* TABS */
.cms-section-tabs{display:flex;gap:4px;margin-bottom:16px;border-bottom:1px solid var(--border)}
.cms-stab{padding:8px 14px;font-size:.75rem;font-weight:600;color:var(--text3);cursor:pointer;border-bottom:2px solid transparent;transition:all .2s;background:none;border-top:none;border-left:none;border-right:none}
.cms-stab.active{color:var(--purple-light);border-bottom-color:var(--purple)}

/* FOOTER SAVE BAR */
.cms-save-bar{padding:12px 20px;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-shrink:0;background:var(--card);gap:10px}

/* STATUS DOTS */
.dot-live{background:#10b981}
.dot-draft{background:#f59e0b}
.dot-hidden{background:#64748b}

/* UNSAVED INDICATOR */
.unsaved-dot{width:7px;height:7px;border-radius:50%;background:var(--amber);display:none}
.unsaved-dot.show{display:block;animation:pulse 1.5s ease-in-out infinite}
@keyframes pulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.5;transform:scale(1.3)}}

/* SCROLLBAR */
.cms-tree-body::-webkit-scrollbar,.cms-editor-body::-webkit-scrollbar{width:4px}
.cms-tree-body::-webkit-scrollbar-track,.cms-editor-body::-webkit-scrollbar-track{background:transparent}
.cms-tree-body::-webkit-scrollbar-thumb,.cms-editor-body::-webkit-scrollbar-thumb{background:var(--border);border-radius:2px}

/* TOAST */
#cms-toast{position:fixed;bottom:24px;right:24px;z-index:99999;display:flex;flex-direction:column;gap:8px}
.cms-toast-item{padding:10px 16px;border-radius:var(--radius-sm);font-size:.8rem;font-weight:600;animation:toastIn .3s ease;display:flex;align-items:center;gap:8px;box-shadow:0 8px 24px rgba(0,0,0,.35)}
.cms-t-success{background:rgba(16,185,129,.18);border:1px solid rgba(16,185,129,.35);color:#10b981}
.cms-t-error{background:rgba(244,63,94,.18);border:1px solid rgba(244,63,94,.35);color:#f43f5e}
@keyframes toastIn{from{opacity:0;transform:translateX(14px)}to{opacity:1;transform:translateX(0)}}
</style>

<section id="page-cms">

  <!-- Header -->
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;flex-wrap:wrap;gap:10px">
    <div>
      <h2 class="font-jakarta" style="font-size:1.2rem;font-weight:800">Content Management</h2>
      <p style="font-size:.75rem;color:var(--text3);margin-top:2px">Edit all frontend page content, icons and sections</p>
    </div>
    <div style="display:flex;align-items:center;gap:8px">
      <div class="unsaved-dot" id="global-unsaved-dot" title="Unsaved changes"></div>
      <button class="btn btn-ghost btn-sm" onclick="cmsPreview()" id="preview-btn" disabled>
        <i class="ri-eye-line"></i> Preview
      </button>
      <button class="btn btn-primary btn-sm" onclick="cmsSaveAll()" id="save-all-btn" disabled>
        <i class="ri-save-line"></i> Save All
      </button>
    </div>
  </div>

  <!-- Main Layout -->
  <div class="cms-layout">

    <!-- ── PAGE TREE ──────────────────────────────── -->
    <div class="cms-tree">
      <div class="cms-tree-header">
        <div style="font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--text3);margin-bottom:8px">Pages</div>
        <div style="position:relative">
          <i class="ri-search-line" style="position:absolute;left:9px;top:50%;transform:translateY(-50%);font-size:.8rem;color:var(--text3);pointer-events:none"></i>
          <input class="cms-tree-search" id="page-search" placeholder="Search pages…" oninput="filterPages(this.value)">
        </div>
      </div>
      <div class="cms-tree-body" id="page-tree"></div>
    </div>

    <!-- ── EDITOR AREA ────────────────────────────── -->
    <div class="cms-editor" id="cms-editor">

      <!-- Empty state -->
      <div class="cms-empty" id="cms-empty">
        <div style="width:64px;height:64px;border-radius:18px;background:rgba(124,58,237,.1);border:2px dashed rgba(124,58,237,.3);display:flex;align-items:center;justify-content:center;margin-bottom:16px">
          <i class="ri-file-edit-line" style="font-size:1.6rem;color:rgba(124,58,237,.4)"></i>
        </div>
        <div class="font-jakarta" style="font-weight:700;color:var(--text2);font-size:.9rem;margin-bottom:6px">No page selected</div>
        <div style="font-size:.78rem;color:var(--text4);max-width:200px;line-height:1.5">Select a page from the left panel to start editing its content</div>
      </div>

      <!-- Editor content (shown when page selected) -->
      <div id="cms-editor-inner" style="display:none;flex-direction:column;height:100%">

        <!-- Top bar -->
        <div class="cms-editor-topbar">
          <div style="display:flex;align-items:center;gap:10px;flex:1;min-width:0">
            <div id="ed-page-icon" style="width:34px;height:34px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:1rem;flex-shrink:0"></div>
            <div>
              <div class="font-jakarta" id="ed-page-title" style="font-weight:800;font-size:.9rem;color:var(--text)"></div>
              <div id="ed-page-slug" style="font-size:.65rem;color:var(--text4)"></div>
            </div>
          </div>
          <div style="display:flex;align-items:center;gap:8px">
            <div style="display:flex;align-items:center;gap:4px">
              <label style="font-size:.72rem;color:var(--text3)">Status:</label>
              <select class="cms-input" id="ed-status" style="padding:5px 8px;font-size:.72rem;width:auto" onchange="markDirty()">
                <option value="live">🟢 Live</option>
                <option value="draft">🟡 Draft</option>
                <option value="hidden">⚫ Hidden</option>
              </select>
            </div>
            <button class="btn btn-ghost btn-sm" onclick="cmsReset()"><i class="ri-refresh-line"></i> Reset</button>
            <button class="btn btn-primary btn-sm" onclick="cmsSavePage()"><i class="ri-save-line"></i> Save Page</button>
          </div>
        </div>

        <!-- Section tabs -->
        <div style="padding:0 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:0;overflow-x:auto" id="ed-section-tabs"></div>

        <!-- Editor body -->
        <div class="cms-editor-body" id="ed-body"></div>

        <!-- Save bar -->
        <div class="cms-save-bar">
          <div style="display:flex;align-items:center;gap:8px">
            <div class="unsaved-dot" id="page-unsaved-dot"></div>
            <span style="font-size:.72rem;color:var(--text3)" id="last-saved-lbl">Not saved yet</span>
          </div>
          <div style="display:flex;gap:8px">
            <a id="view-live-btn" href="#" target="_blank" class="btn btn-ghost btn-sm">
              <i class="ri-external-link-line"></i> View Live
            </a>
            <button class="btn btn-primary btn-sm" onclick="cmsSavePage()">
              <i class="ri-save-line"></i> Save Changes
            </button>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- Icon Picker Global Dropdown -->
<div class="icon-dropdown" id="global-icon-picker" onclick="event.stopPropagation()">
  <input class="icon-search" id="icon-search-inp" placeholder="Search icons…" oninput="filterIcons(this.value)">
  <div class="icon-grid" id="icon-grid"></div>
</div>

<div id="cms-toast"></div>

<script>
// ══════════════════════════════════════════════════════════
// CMS DATA — all pages + their sections
// ══════════════════════════════════════════════════════════

const CMS_ICONS = [
  'ri-home-4-line','ri-information-line','ri-price-tag-3-line','ri-question-line',
  'ri-mail-line','ri-shield-check-line','ri-file-list-3-line','ri-article-line',
  'ri-rocket-line','ri-star-smile-line','ri-user-add-line','ri-check-line',
  'ri-arrow-right-line','ri-arrow-left-line','ri-calendar-2-line','ri-alarm-line',
  'ri-notification-3-line','ri-settings-3-line','ri-dashboard-line','ri-bar-chart-2-line',
  'ri-group-line','ri-team-line','ri-key-2-line','ri-folder-3-line',
  'ri-bank-card-line','ri-shield-star-line','ri-bullseye-line','ri-global-line',
  'ri-lightbulb-flash-line','ri-refresh-line','ri-heart-pulse-line','ri-car-line',
  'ri-flight-takeoff-line','ri-footprint-line','ri-cake-3-line','ri-phone-line',
  'ri-map-pin-line','ri-facebook-fill','ri-twitter-x-line','ri-instagram-line',
  'ri-linkedin-fill','ri-youtube-line','ri-close-line','ri-add-line',
  'ri-edit-line','ri-delete-bin-line','ri-upload-line','ri-download-2-line',
  'ri-eye-line','ri-lock-line','ri-unlock-line','ri-time-line',
  'ri-fire-line','ri-trophy-line','ri-thumb-up-line','ri-chat-3-line',
  'ri-coins-line','ri-money-rupee-circle-line','ri-bank-line','ri-building-line',
  'ri-passport-line','ri-repeat-line','ri-smartphone-line','ri-laptop-line',
  'ri-map-2-line','ri-navigation-line','ri-send-plane-line','ri-gift-line',
  'ri-search-line','ri-filter-line','ri-bookmark-line','ri-share-line',
];

const ACCENT_COLORS = [
  '#7c3aed','#06b6d4','#10b981','#f59e0b','#f43f5e','#ec4899','#8b5cf6',
  '#14b8a6','#3b82f6','#ef4444','#a78bfa','#34d399','#fb923c','#e879f9',
];

// All pages with sections
const CMS_PAGES = [
  {
    id:'home', title:'Home', slug:'/', icon:'ri-home-4-line', iconBg:'rgba(124,58,237,.15)', iconColor:'#a78bfa', status:'live',
    url:'index',
    sections:[
      {id:'hero',    label:'Hero Section',        icon:'ri-layout-top-line',      badge:'Main'},
      {id:'features',label:'Features Grid',        icon:'ri-grid-line',            badge:'Cards'},
      {id:'stats',   label:'Stats / Numbers',      icon:'ri-bar-chart-line',       badge:'Data'},
      {id:'cta',     label:'Call to Action',        icon:'ri-megaphone-line',       badge:'CTA'},
    ]
  },
  {
    id:'about', title:'About', slug:'/about', icon:'ri-information-line', iconBg:'rgba(6,182,212,.15)', iconColor:'#67e8f9', status:'live',
    url:'about',
    sections:[
      {id:'hero',    label:'Page Hero',            icon:'ri-layout-top-line',      badge:'Hero'},
      {id:'mission', label:'Mission Section',       icon:'ri-bullseye-line',        badge:'Content'},
      {id:'values',  label:'Values Grid',           icon:'ri-heart-pulse-line',     badge:'Cards'},
      {id:'team',    label:'Team Members',          icon:'ri-team-line',            badge:'Hidden'},
      {id:'stats',   label:'Stats Cards',           icon:'ri-bar-chart-line',       badge:'Numbers'},
    ]
  },
  {
    id:'pricing', title:'Pricing', slug:'/pricing', icon:'ri-price-tag-3-line', iconBg:'rgba(16,185,129,.15)', iconColor:'#6ee7b7', status:'live',
    url:'pricing',
    sections:[
      {id:'hero',    label:'Page Hero',            icon:'ri-layout-top-line',      badge:'Hero'},
      {id:'plan',    label:'Pricing Card',          icon:'ri-shield-star-line',     badge:'Main'},
      {id:'features',label:'Feature List',          icon:'ri-list-check',           badge:'List'},
      {id:'cta',     label:'CTA Section',           icon:'ri-megaphone-line',       badge:'CTA'},
    ]
  },
  {
    id:'faq', title:'FAQ', slug:'/faq', icon:'ri-question-line', iconBg:'rgba(245,158,11,.15)', iconColor:'#fcd34d', status:'live',
    url:'faq',
    sections:[
      {id:'hero',    label:'Page Hero',            icon:'ri-layout-top-line',      badge:'Hero'},
      {id:'general', label:'General FAQs',          icon:'ri-information-line',     badge:'Q&A'},
      {id:'account', label:'Account FAQs',          icon:'ri-user-line',            badge:'Q&A'},
      {id:'reminders',label:'Reminders FAQs',       icon:'ri-alarm-line',           badge:'Q&A'},
      {id:'pricing', label:'Pricing FAQs',          icon:'ri-price-tag-3-line',     badge:'Q&A'},
      {id:'privacy', label:'Privacy FAQs',          icon:'ri-shield-check-line',    badge:'Q&A'},
    ]
  },
  {
    id:'contact', title:'Contact', slug:'/contact', icon:'ri-mail-line', iconBg:'rgba(124,58,237,.15)', iconColor:'#c4b5fd', status:'live',
    url:'contact',
    sections:[
      {id:'hero',    label:'Page Hero',            icon:'ri-layout-top-line',      badge:'Hero'},
      {id:'info',    label:'Contact Info Cards',   icon:'ri-card-line',            badge:'Cards'},
      {id:'form',    label:'Contact Form',          icon:'ri-file-list-3-line',     badge:'Form'},
      {id:'map',     label:'Map & Office',          icon:'ri-map-pin-line',         badge:'Location'},
      {id:'hours',   label:'Office Hours Cards',    icon:'ri-time-line',            badge:'Cards'},
    ]
  },
  {
    id:'blog', title:'Blog', slug:'/blog', icon:'ri-article-line', iconBg:'rgba(16,185,129,.15)', iconColor:'#6ee7b7', status:'live',
    url:'blog',
    sections:[
      {id:'hero',    label:'Page Hero',            icon:'ri-layout-top-line',      badge:'Hero'},
      {id:'cats',    label:'Category Pills',        icon:'ri-price-tag-3-line',     badge:'Filters'},
      {id:'featured',label:'Featured Post',         icon:'ri-fire-line',            badge:'Card'},
      {id:'sidebar', label:'Sidebar Widgets',       icon:'ri-layout-right-line',    badge:'Widgets'},
    ]
  },
  {
    id:'blog-detail', title:'Blog Detail', slug:'/blog/:slug', icon:'ri-file-text-line', iconBg:'rgba(6,182,212,.15)', iconColor:'#67e8f9', status:'live',
    url:'blog-detail',
    sections:[
      {id:'hero',    label:'Article Hero',         icon:'ri-layout-top-line',      badge:'Hero'},
      {id:'meta',    label:'Author & Meta',         icon:'ri-user-3-line',          badge:'Meta'},
      {id:'toc',     label:'Table of Contents',     icon:'ri-list-unordered',       badge:'TOC'},
      {id:'related', label:'Related Articles',      icon:'ri-links-line',           badge:'Cards'},
      {id:'share',   label:'Share Buttons',         icon:'ri-share-line',           badge:'Social'},
    ]
  },
  {
    id:'category', title:'Category', slug:'/category', icon:'ri-folder-3-line', iconBg:'rgba(239,68,68,.15)', iconColor:'#fca5a5', status:'live',
    url:'category',
    sections:[
      {id:'hero',    label:'Page Hero',            icon:'ri-layout-top-line',      badge:'Hero'},
      {id:'cats',    label:'Category Cards',        icon:'ri-grid-line',            badge:'Cards'},
      {id:'cta',     label:'CTA Section',           icon:'ri-megaphone-line',       badge:'CTA'},
    ]
  },
  {
    id:'privacy', title:'Privacy Policy', slug:'/privacy', icon:'ri-shield-check-line', iconBg:'rgba(124,58,237,.15)', iconColor:'#c4b5fd', status:'live',
    url:'privacy',
    sections:[
      {id:'hero',    label:'Page Hero',            icon:'ri-layout-top-line',      badge:'Hero'},
      {id:'content', label:'Policy Sections',       icon:'ri-file-list-3-line',     badge:'Legal'},
    ]
  },
  {
    id:'terms', title:'Terms & Conditions', slug:'/terms', icon:'ri-file-list-3-line', iconBg:'rgba(245,158,11,.15)', iconColor:'#fcd34d', status:'draft',
    url:'terms',
    sections:[
      {id:'hero',    label:'Page Hero',            icon:'ri-layout-top-line',      badge:'Hero'},
      {id:'content', label:'Terms Sections',        icon:'ri-file-list-3-line',     badge:'Legal'},
    ]
  },
];

// Default section content templates per section id
const SECTION_DEFAULTS = {
  hero: {
    badge_icon:'ri-star-smile-line', badge_text:'Our Story', badge_color:'#7c3aed',
    heading:'Built to help you keep', heading_grad:'more of your money.',
    subtext:'DRemind was born from a simple frustration — too many people lose thousands every year to forgotten renewals and loyalty tax. We decided to fix that.',
    breadcrumb_parent:'Home', breadcrumb_current:'About',
    particles:'purple', particle_count:'50', bg_blob1:'#7c3aed', bg_blob2:'#06b6d4',
    show_search: false, search_placeholder:'Search…',
    show_cta: false, cta1_text:'Register', cta1_icon:'ri-rocket-line', cta1_href:'register',
    cta2_text:'Contact Us', cta2_icon:'ri-mail-line', cta2_href:'contact',
  },
  mission: {
    badge_text:'Our Mission', badge_color:'#7c3aed',
    heading:'Empowering people to be', heading_grad:'financially savvy',
    para1:'We believe every household deserves to know when their insurance, energy contracts, and subscriptions are up for renewal — and to have enough time to switch to a better deal.',
    para2:'DRemind is the intelligent reminder platform that works silently in the background, so you never pay the loyalty tax again.',
    points:[
      {icon:'ri-bullseye-line', icon_color:'#a78bfa', icon_bg:'rgba(124,58,237,.15)', title:'Purpose-driven', text:'Every feature we build is aimed at putting money back in your pocket.'},
      {icon:'ri-shield-check-line', icon_color:'#6ee7b7', icon_bg:'rgba(16,185,129,.15)', title:'Privacy first', text:'Your data is encrypted, never sold, fully GDPR & APPs compliant.'},
      {icon:'ri-global-line', icon_color:'#67e8f9', icon_bg:'rgba(6,182,212,.15)', title:'Global reach', text:'Available in 8 countries with full local privacy compliance.'},
    ]
  },
  values: {
    badge_text:'Our Values', badge_color:'#06b6d4',
    heading:'What we', heading_grad:'stand for',
    cards:[
      {emoji:'💡', title:'Transparency', text:'No hidden fees, no data selling. What you see is what you get.'},
      {emoji:'🚀', title:'Simplicity', text:'Set up in under 2 minutes. No complicated settings.'},
      {emoji:'🔒', title:'Security', text:'Bank-level encryption on all your data, always.'},
      {emoji:'🌍', title:'Accessibility', text:'Free forever plan so everyone can benefit.'},
    ]
  },
  team: {
    badge_text:'The Team', badge_color:'#7c3aed',
    heading:'The people behind', heading_grad:'DRemind',
    visible: false,
    members:[
      {initials:'JT', name:'Kishore Thompson', role:'CEO & Co-founder', role_color:'#c4b5fd', bio:'10+ years in fintech. Previously at Monzo and TransferWise.'},
      {initials:'SR', name:'Sophie Reynolds', role:'CTO & Co-founder', role_color:'#67e8f9', bio:'Full-stack engineer with a passion for clean, fast interfaces.'},
      {initials:'ML', name:'Marcus Lee', role:'Head of Product', role_color:'#6ee7b7', bio:'UX obsessive. Designed apps used by 20M+ people globally.'},
    ]
  },
  stats: {
    founded_year:'2022', founded_city:'London, UK',
    items:[
      {value:'50000', suffix:'+', label:'Active Users', color:'#a78bfa'},
      {value:'8', suffix:'', label:'Countries', color:'#6ee7b7'},
      {value:'2', suffix:'M+', label:'Reminders Sent', color:'#67e8f9'},
      {value:'4.9★', suffix:'', label:'App Rating', color:'#fcd34d'},
    ]
  },
  cta: {
    heading:'Ready to start', heading_grad:'saving?',
    subtext:'Join thousands of smart savers already using DRemind. Free forever plan available.',
    btn1_text:'Register', btn1_icon:'ri-rocket-line', btn1_href:'register',
    btn2_text:'Contact Us', btn2_icon:'ri-mail-line', btn2_href:'contact',
  },
  plan: {
    badge_text:'One Simple Plan', badge_color:'#10b981',
    heading:'Everything.', heading_grad:'One Price.',
    subtext:'No tiers. No hidden upgrades. No monthly charges. Just full access for a simple annual fee.',
    price:'£2.40', price_period:'/year', price_note:'£2.00 subscription + £0.40 VAT',
    cta_text:'Get Full Access Now', cta_icon:'ri-user-add-line', cta_href:'register?plan=annual',
    footnote:'One payment. 365 days of peace of mind.',
    comparison_text:"That's just £0.20 per month — less than a cup of tea ☕",
  },
  info: {
    address:'Unit 5, Martinbridge Trading Estate, 240–242 Lincoln Road, Enfield, United Kingdom, EN1 1SP.',
    email_main:'info@winngoodremind.co.uk',
    email_support:'support@winngoodremind.co.uk',
    phone:'+020 3376 5250',
    hours:'Mon–Fri, 9am–6pm GMT',
    social_facebook:'#', social_instagram:'#', social_twitter:'#', social_linkedin:'#',
  },
  map: {
    heading:'Visit our', heading_grad:'office',
    subtext:"We're located in Enfield, North London. Drop by for a coffee or schedule a meeting with our team.",
    map_embed:'https://www.google.com/maps/embed?pb=...',
    overlay_title:'Our Location',
    overlay_address:'Unit 5, Martinbridge Trading Estate\n240–242 Lincoln Road\nEnfield, United Kingdom\nEN1 1SP',
    directions_url:'https://maps.google.com/?q=240-242+Lincoln+Road+Enfield+EN1+1SP+UK',
  },
  hours: {
    card1_icon:'ri-time-line', card1_title:'Office Hours', card1_text:'Monday – Friday\n9:00 AM – 6:00 PM GMT',
    card2_icon:'ri-car-line',  card2_title:'Parking',       card2_text:'Free on-site parking\navailable for visitors',
    card3_icon:'ri-train-line',card3_title:'Public Transport', card3_text:'10 min walk from\nEnfield Town Station',
  },
  cats: {
    badge_text:'All Categories', badge_color:'#7c3aed',
    heading:'Everything you need to', heading_grad:'track',
    subtext:'Add reminders across 8 major life features. Never pay a renewal penalty again.',
    cards:[
      {icon:'ri-shield-star-line', icon_color:'#c4b5fd', icon_bg:'rgba(124,58,237,.15)', title:'Insurance', subtitle:'Home · Car · Life · Health', text:'Get notified before your insurance renews so you can compare quotes and save hundreds.', tags:'Home,Car,Life,Health'},
      {icon:'ri-smartphone-line',  icon_color:'#67e8f9', icon_bg:'rgba(6,182,212,.15)',  title:'Telecom',   subtitle:'Mobile · Broadband · TV',  text:'Mobile and broadband plans creep up in price. Time your switch at the right moment.', tags:'Mobile,Broadband,TV'},
      {icon:'ri-car-line',         icon_color:'#fca5a5', icon_bg:'rgba(239,68,68,.15)',  title:'Vehicle',   subtitle:'Rego · Licence · Service', text:'Car registration, licence renewals, service Dates — never get caught out or fined.', tags:'Rego,Licence,Service'},
      {icon:'ri-repeat-line',      icon_color:'#6ee7b7', icon_bg:'rgba(16,185,129,.15)', title:'Subscriptions', subtitle:'Streaming · SaaS · Gym', text:'Cancel or switch before free trials expire. Stay in control of every recurring charge.', tags:'Streaming,Software,Gym'},
    ]
  },
  general: {
    items:[
      {q:'What is DRemind?', a:'DRemind is a smart reminder web app that tracks expiry dates for your insurance, utility plans, subscriptions, vehicle registrations, passports, and more.'},
      {q:'Who is DRemind for?', a:'DRemind is for anyone who wants to stay on top of recurring expenses. Homeowners, renters, families, business owners, and frequent travellers.'},
      {q:'Which countries does DRemind support?', a:'Available in Australia, New Zealand, United States, United Kingdom, Canada, Ireland, India, and Singapore.'},
      {q:'How much money can I save?', a:'Our users save an average of $2,847 per year by switching to better deals across insurance, energy, telecom, and subscriptions.'},
    ]
  },
  account: {
    items:[
      {q:'How do I create an account?', a:'Click "Register", enter your name and email, choose a password — no credit card required. Setup takes under 2 minutes.'},
      {q:'Can I use DRemind on multiple devices?', a:'Yes! DRemind syncs in real time across all your devices. Access via web app from any browser.'},
      {q:'I forgot my password. How do I reset it?', a:'On the login page, click "Forgot password?" and enter your email. You\'ll receive a reset link within a few minutes.'},
      {q:'How do I delete my account?', a:'Go to Settings → Account → Delete Account. All data will be permanently removed within 30 days.'},
    ]
  },
  content: {
    sections:[
      {number:'1', heading:'Acceptance of Terms', type:'para', content:'By accessing, registering, or using DRemind ("Service"), you agree to be bound by these Terms of Use and all applicable laws and regulations.'},
      {number:'2', heading:'Eligibility', type:'list', content:'You must be at least 16 years old.\nYou confirm you have legal capacity to enter a binding agreement.\nIf using on behalf of an organization, you agree on that entity\'s behalf.'},
      {number:'3', heading:'User Accounts', type:'list', content:'You are responsible for maintaining confidentiality of your credentials.\nYou agree to provide accurate and complete information during registration.\nYou are responsible for all activities that occur under your account.'},
    ]
  },
  featured: {
    image_url:'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=1200&q=80',
    cat_badge:'Guide', cat_badge_icon:'ri-map-2-line',
    read_time:'8 min read',
    heading:'The Ultimate Guide to Never Overpaying for Insurance Again',
    excerpt:'Most people auto-renew without comparing. Here\'s a step-by-step system for tracking every policy, setting reminders, and switching providers at exactly the right moment.',
    author_initials:'SR', author_name:'Sarah Reynolds', date:'April 14, 2026',
    link:'blog-detail', cta_text:'Read Article',
  },
  sidebar: {
    trending_title:'Trending This Week',
    items:[
      {title:'Why Most People Miss Their Energy Plan Renewal Window', read:'4 min'},
      {title:'The Complete Home Insurance Switching Guide 2026', read:'9 min'},
      {title:'5 Subscriptions You\'re Paying For and Forgetting', read:'4 min'},
      {title:'Passport Renewal Checklist: Start 6 Months Early', read:'7 min'},
    ],
    show_tags: true,
    tags:'#insurance,#savings,#subscriptions,#energy,#reminders,#passport,#budgeting,#renewal',
  },
  share: {
    show_twitter: true, show_linkedin: true, show_facebook: true,
    show_email: true, show_copy: true,
    twitter_text:'Check this out from DRemind',
  },
};

// Runtime page data store (simulate saved state)
const pageStore = {};
CMS_PAGES.forEach(p => {
  pageStore[p.id] = {
    status: p.status,
    sections: {},
  };
  p.sections.forEach(s => {
    pageStore[p.id].sections[s.id] = JSON.parse(JSON.stringify(SECTION_DEFAULTS[s.id] || {}));
  });
});

// ══════════════════════════════════════════════════════════
// STATE
// ══════════════════════════════════════════════════════════
let activePage = null;
let activeSection = null;
let isDirty = false;
let activeIconTarget = null; // input field to receive icon value

// ══════════════════════════════════════════════════════════
// INIT
// ══════════════════════════════════════════════════════════

function initCMS() {
  renderPageTree(CMS_PAGES);
  buildIconGrid(CMS_ICONS);
  document.addEventListener('click', () => {
    document.getElementById('global-icon-picker').classList.remove('open');
  });
}

// ══════════════════════════════════════════════════════════
// PAGE TREE
// ══════════════════════════════════════════════════════════

function renderPageTree(pages) {
  const tree = document.getElementById('page-tree');
  tree.innerHTML = pages.map(p => {
    const dot = p.status === 'live' ? 'dot-live' : p.status === 'draft' ? 'dot-draft' : 'dot-hidden';
    const secCount = p.sections.length;
    return `<div class="page-item ${activePage && activePage.id === p.id ? 'active' : ''}" onclick="selectPage('${p.id}')">
      <div class="page-item-icon" style="background:${p.iconBg}">
        <i class="${p.icon}" style="color:${p.iconColor}"></i>
      </div>
      <div style="flex:1;min-width:0">
        <div class="page-item-title">${p.title}</div>
        <div class="page-item-slug">${p.slug}</div>
      </div>
      <span class="page-item-count">${secCount}</span>
      <div class="page-status-dot ${dot}" title="${p.status}"></div>
    </div>`;
  }).join('');
}

function filterPages(q) {
  const filtered = CMS_PAGES.filter(p =>
    p.title.toLowerCase().includes(q.toLowerCase()) ||
    p.slug.toLowerCase().includes(q.toLowerCase())
  );
  renderPageTree(filtered);
}

// ══════════════════════════════════════════════════════════
// SELECT PAGE
// ══════════════════════════════════════════════════════════

function selectPage(pageId) {
  activePage = CMS_PAGES.find(p => p.id === pageId);
  if (!activePage) return;
  activeSection = activePage.sections[0]?.id || null;
  renderPageTree(CMS_PAGES);
  document.getElementById('cms-empty').style.display = 'none';
  const inner = document.getElementById('cms-editor-inner');
  inner.style.display = 'flex';

  // Topbar
  const ed = pageStore[activePage.id];
  document.getElementById('ed-page-icon').style.background = activePage.iconBg;
  document.getElementById('ed-page-icon').innerHTML = `<i class="${activePage.icon}" style="color:${activePage.iconColor}"></i>`;
  document.getElementById('ed-page-title').textContent = activePage.title;
  document.getElementById('ed-page-slug').textContent = activePage.slug;
  document.getElementById('ed-status').value = ed.status;
  document.getElementById('view-live-btn').href = activePage.url;

  // Build section tabs
  renderSectionTabs();
  // Render editor body
  renderEditorBody();
  // Update buttons
  document.getElementById('preview-btn').disabled = false;
  document.getElementById('save-all-btn').disabled = false;
  updateDirtyState(false);
}

// ══════════════════════════════════════════════════════════
// SECTION TABS
// ══════════════════════════════════════════════════════════

function renderSectionTabs() {
  const tabs = document.getElementById('ed-section-tabs');
  tabs.innerHTML = activePage.sections.map(s =>
    `<button class="cms-stab ${activeSection === s.id ? 'active' : ''}" onclick="selectSection('${s.id}')">
      <i class="${s.icon}" style="margin-right:5px;font-size:.8rem"></i>${s.label}
    </button>`
  ).join('');
}

function selectSection(sectionId) {
  activeSection = sectionId;
  renderSectionTabs();
  renderEditorBody();
}

// ══════════════════════════════════════════════════════════
// EDITOR BODY — renders fields for the active section
// ══════════════════════════════════════════════════════════

function renderEditorBody() {
  const body = document.getElementById('ed-body');
  if (!activeSection || !activePage) { body.innerHTML = ''; return; }
  const data = pageStore[activePage.id].sections[activeSection] || {};
  const sec = activePage.sections.find(s => s.id === activeSection);
  body.innerHTML = buildSectionEditor(activeSection, sec, data);
}

function buildSectionEditor(sectionId, sec, data) {
  switch(sectionId) {
    case 'hero':    return buildHeroEditor(data);
    case 'mission': return buildMissionEditor(data);
    case 'values':  return buildCardsEditor(data, 'Value Cards', ['emoji','title','text']);
    case 'team':    return buildTeamEditor(data);
    case 'stats':   return buildStatsEditor(data);
    case 'cta':     return buildCtaEditor(data);
    case 'plan':    return buildPlanEditor(data);
    case 'info':    return buildContactInfoEditor(data);
    case 'map':     return buildMapEditor(data);
    case 'hours':   return buildHoursEditor(data);
    case 'cats':    return buildCategoryCardsEditor(data);
    case 'general': case 'account': case 'reminders': case 'pricing': case 'privacy':
      return buildFaqEditor(data, sec?.label || 'FAQ Items');
    case 'content': return buildLegalEditor(data);
    case 'featured':return buildFeaturedEditor(data);
    case 'sidebar': return buildSidebarEditor(data);
    case 'share':   return buildShareEditor(data);
    case 'meta':    return buildMetaEditor(data);
    case 'toc':     return buildTocEditor(data);
    case 'related': return buildRelatedEditor(data);
    case 'features':return buildFeaturesEditor(data);
    default:        return buildGenericEditor(data);
  }
}

// ── Hero Editor
function buildHeroEditor(d) {
  return `<div style="padding:20px">
    <div class="cms-section-tabs">
      <button class="cms-stab active" onclick="switchSubTab(this,'sub-hero-badge')">Badge</button>
      <button class="cms-stab" onclick="switchSubTab(this,'sub-hero-content')">Content</button>
      <button class="cms-stab" onclick="switchSubTab(this,'sub-hero-bg')">Background</button>
      <button class="cms-stab" onclick="switchSubTab(this,'sub-hero-cta')">CTA Buttons</button>
    </div>
    <div id="sub-hero-badge">
      <div class="cms-input-row">
        <div class="cms-field">
          <div class="cms-field-label"><i class="ri-price-tag-3-line"></i> Badge Text</div>
          <input class="cms-input" value="${esc(d.badge_text||'')}" data-key="badge_text" oninput="updateField(this)">
        </div>
        <div class="cms-field">
          <div class="cms-field-label"><i class="ri-palette-line"></i> Badge Color</div>
          ${buildColorPicker('badge_color', d.badge_color||'#7c3aed')}
        </div>
      </div>
      <div class="cms-field">
        <div class="cms-field-label"><i class="ri-remixicon-line"></i> Badge Icon</div>
        ${buildIconPicker('badge_icon', d.badge_icon||'ri-star-smile-line')}
      </div>
    </div>
    <div id="sub-hero-content" style="display:none">
      <div class="cms-field">
        <div class="cms-field-label">Breadcrumb — Parent</div>
        <input class="cms-input" value="${esc(d.breadcrumb_parent||'Home')}" data-key="breadcrumb_parent" oninput="updateField(this)">
      </div>
      <div class="cms-field">
        <div class="cms-field-label">Breadcrumb — Current Page</div>
        <input class="cms-input" value="${esc(d.breadcrumb_current||'')}" data-key="breadcrumb_current" oninput="updateField(this)">
      </div>
      <div class="cms-field">
        <div class="cms-field-label">Heading (plain)</div>
        <input class="cms-input" value="${esc(d.heading||'')}" data-key="heading" oninput="updateField(this)">
      </div>
      <div class="cms-field">
        <div class="cms-field-label">Heading (gradient highlight)</div>
        <input class="cms-input" value="${esc(d.heading_grad||'')}" data-key="heading_grad" oninput="updateField(this)" placeholder="Words that appear in gradient colour">
      </div>
      <div class="cms-field">
        <div class="cms-field-label">Subtext / Description</div>
        <textarea class="cms-input cms-textarea" data-key="subtext" oninput="updateField(this)">${esc(d.subtext||'')}</textarea>
      </div>
      ${buildToggleField('show_search','Show Search Bar', d.show_search)}
      ${d.show_search ? `<div class="cms-field"><div class="cms-field-label">Search Placeholder</div><input class="cms-input" value="${esc(d.search_placeholder||'')}" data-key="search_placeholder" oninput="updateField(this)"></div>` : ''}
    </div>
    <div id="sub-hero-bg" style="display:none">
      <div class="cms-input-row">
        <div class="cms-field">
          <div class="cms-field-label">Particle Style</div>
          <select class="cms-input" data-key="particles" onchange="updateField(this)">
            ${['purple','cyan','mixed','none'].map(v => `<option value="${v}" ${d.particles===v?'selected':''}>${v}</option>`).join('')}
          </select>
        </div>
        <div class="cms-field">
          <div class="cms-field-label">Particle Count</div>
          <input class="cms-input" type="number" min="0" max="200" value="${d.particle_count||50}" data-key="particle_count" oninput="updateField(this)">
        </div>
      </div>
      <div class="cms-input-row">
        <div class="cms-field">
          <div class="cms-field-label">Blob 1 Color</div>
          ${buildColorPicker('bg_blob1', d.bg_blob1||'#7c3aed')}
        </div>
        <div class="cms-field">
          <div class="cms-field-label">Blob 2 Color</div>
          ${buildColorPicker('bg_blob2', d.bg_blob2||'#06b6d4')}
        </div>
      </div>
    </div>
    <div id="sub-hero-cta" style="display:none">
      ${buildToggleField('show_cta','Show CTA Buttons', d.show_cta)}
      <div class="cms-divider"></div>
      <div style="font-size:.72rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.07em;margin-bottom:10px">Primary Button</div>
      <div class="cms-input-row-3">
        <div class="cms-field"><div class="cms-field-label">Text</div><input class="cms-input" value="${esc(d.cta1_text||'')}" data-key="cta1_text" oninput="updateField(this)"></div>
        <div class="cms-field"><div class="cms-field-label">Link (href)</div><input class="cms-input" value="${esc(d.cta1_href||'')}" data-key="cta1_href" oninput="updateField(this)"></div>
        <div class="cms-field"><div class="cms-field-label">Icon</div>${buildIconPicker('cta1_icon', d.cta1_icon||'ri-rocket-line')}</div>
      </div>
      <div style="font-size:.72rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.07em;margin-bottom:10px">Secondary Button</div>
      <div class="cms-input-row-3">
        <div class="cms-field"><div class="cms-field-label">Text</div><input class="cms-input" value="${esc(d.cta2_text||'')}" data-key="cta2_text" oninput="updateField(this)"></div>
        <div class="cms-field"><div class="cms-field-label">Link (href)</div><input class="cms-input" value="${esc(d.cta2_href||'')}" data-key="cta2_href" oninput="updateField(this)"></div>
        <div class="cms-field"><div class="cms-field-label">Icon</div>${buildIconPicker('cta2_icon', d.cta2_icon||'ri-mail-line')}</div>
      </div>
    </div>
  </div>`;
}

// ── Mission Editor
function buildMissionEditor(d) {
  const pts = d.points || [];
  return `<div style="padding:20px">
    <div class="cms-input-row">
      <div class="cms-field"><div class="cms-field-label">Heading (plain)</div><input class="cms-input" value="${esc(d.heading||'')}" data-key="heading" oninput="updateField(this)"></div>
      <div class="cms-field"><div class="cms-field-label">Heading (gradient)</div><input class="cms-input" value="${esc(d.heading_grad||'')}" data-key="heading_grad" oninput="updateField(this)"></div>
    </div>
    <div class="cms-field"><div class="cms-field-label">Paragraph 1</div><textarea class="cms-input cms-textarea" data-key="para1" oninput="updateField(this)">${esc(d.para1||'')}</textarea></div>
    <div class="cms-field"><div class="cms-field-label">Paragraph 2</div><textarea class="cms-input cms-textarea" data-key="para2" oninput="updateField(this)">${esc(d.para2||'')}</textarea></div>
    <div class="cms-divider"></div>
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px">
      <div style="font-size:.72rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.07em">Feature Points</div>
      <button class="cms-repeater-add" style="width:auto;padding:5px 12px" onclick="addMissionPoint()"><i class="ri-add-line"></i> Add Point</button>
    </div>
    <div id="mission-pts-list">
      ${pts.map((pt,i) => buildMissionPointRow(pt, i)).join('')}
    </div>
  </div>`;
}
function buildMissionPointRow(pt, i) {
  return `<div class="cms-repeater-item" id="mpt-${i}">
    <div class="cms-repeater-item-head">
      <div class="cms-repeater-title">Point ${i+1}</div>
      <button class="cms-repeater-remove" onclick="removeMissionPoint(${i})"><i class="ri-close-line"></i></button>
    </div>
    <div class="cms-input-row">
      <div class="cms-field"><div class="cms-field-label">Icon</div>${buildIconPicker(`pt_icon_${i}`, pt.icon||'ri-check-line', `updateMissionPoint(${i},'icon',this.value)`)}</div>
      <div class="cms-field"><div class="cms-field-label">Icon Color</div>${buildColorPicker(`pt_color_${i}`, pt.icon_color||'#a78bfa', `updateMissionPoint(${i},'icon_color',v)`)}</div>
    </div>
    <div class="cms-field"><div class="cms-field-label">Title</div><input class="cms-input" value="${esc(pt.title||'')}" oninput="updateMissionPoint(${i},'title',this.value);markDirty()"></div>
    <div class="cms-field"><div class="cms-field-label">Text</div><textarea class="cms-input cms-textarea" style="min-height:54px" oninput="updateMissionPoint(${i},'text',this.value);markDirty()">${esc(pt.text||'')}</textarea></div>
  </div>`;
}

// ── Generic Cards Editor (values, etc.)
function buildCardsEditor(d, title, fields) {
  const cards = d.cards || [];
  return `<div style="padding:20px">
    <div class="cms-input-row">
      <div class="cms-field"><div class="cms-field-label">Section Heading</div><input class="cms-input" value="${esc(d.heading||'')}" data-key="heading" oninput="updateField(this)"></div>
      <div class="cms-field"><div class="cms-field-label">Gradient Part</div><input class="cms-input" value="${esc(d.heading_grad||'')}" data-key="heading_grad" oninput="updateField(this)"></div>
    </div>
    <div class="cms-divider"></div>
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px">
      <div style="font-size:.72rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.07em">${title}</div>
      <button class="cms-repeater-add" style="width:auto;padding:5px 12px" onclick="addCard()"><i class="ri-add-line"></i> Add Card</button>
    </div>
    <div id="cards-list">
      ${cards.map((c,i) => `<div class="cms-repeater-item" id="card-${i}">
        <div class="cms-repeater-item-head">
          <div class="cms-repeater-title">Card ${i+1}</div>
          <button class="cms-repeater-remove" onclick="removeCard(${i})"><i class="ri-close-line"></i></button>
        </div>
        ${fields.includes('emoji') ? `<div class="cms-field"><div class="cms-field-label">Emoji / Icon</div><input class="cms-input" value="${esc(c.emoji||'')}" oninput="updateCard(${i},'emoji',this.value);markDirty()"></div>` : ''}
        ${fields.includes('icon') ? `<div class="cms-field"><div class="cms-field-label">Icon</div>${buildIconPicker(`card_icon_${i}`, c.icon||'ri-check-line')}</div>` : ''}
        <div class="cms-field"><div class="cms-field-label">Title</div><input class="cms-input" value="${esc(c.title||'')}" oninput="updateCard(${i},'title',this.value);markDirty()"></div>
        <div class="cms-field"><div class="cms-field-label">Text</div><textarea class="cms-input cms-textarea" style="min-height:54px" oninput="updateCard(${i},'text',this.value);markDirty()">${esc(c.text||'')}</textarea></div>
      </div>`).join('')}
    </div>
  </div>`;
}

// ── Team Editor
function buildTeamEditor(d) {
  const members = d.members || [];
  return `<div style="padding:20px">
    ${buildToggleField('visible','Show Team Section', d.visible !== false)}
    <div class="cms-divider"></div>
    <div class="cms-input-row">
      <div class="cms-field"><div class="cms-field-label">Heading</div><input class="cms-input" value="${esc(d.heading||'')}" data-key="heading" oninput="updateField(this)"></div>
      <div class="cms-field"><div class="cms-field-label">Gradient Part</div><input class="cms-input" value="${esc(d.heading_grad||'')}" data-key="heading_grad" oninput="updateField(this)"></div>
    </div>
    <div class="cms-divider"></div>
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px">
      <div style="font-size:.72rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.07em">Team Members</div>
      <button class="cms-repeater-add" style="width:auto;padding:5px 12px" onclick="addTeamMember()"><i class="ri-add-line"></i> Add Member</button>
    </div>
    <div id="team-list">
      ${members.map((m,i) => `<div class="cms-repeater-item" id="member-${i}">
        <div class="cms-repeater-item-head">
          <div class="cms-repeater-title">Member ${i+1}</div>
          <button class="cms-repeater-remove" onclick="removeTeamMember(${i})"><i class="ri-close-line"></i></button>
        </div>
        <div class="cms-input-row-3">
          <div class="cms-field"><div class="cms-field-label">Initials</div><input class="cms-input" value="${esc(m.initials||'')}" oninput="updateMember(${i},'initials',this.value);markDirty()"></div>
          <div class="cms-field"><div class="cms-field-label">Name</div><input class="cms-input" value="${esc(m.name||'')}" oninput="updateMember(${i},'name',this.value);markDirty()"></div>
          <div class="cms-field"><div class="cms-field-label">Role</div><input class="cms-input" value="${esc(m.role||'')}" oninput="updateMember(${i},'role',this.value);markDirty()"></div>
        </div>
        <div class="cms-field"><div class="cms-field-label">Bio</div><textarea class="cms-input cms-textarea" style="min-height:54px" oninput="updateMember(${i},'bio',this.value);markDirty()">${esc(m.bio||'')}</textarea></div>
      </div>`).join('')}
    </div>
  </div>`;
}

// ── Stats Editor
function buildStatsEditor(d) {
  const items = d.items || [];
  return `<div style="padding:20px">
    <div class="cms-input-row">
      <div class="cms-field"><div class="cms-field-label">Founded Year</div><input class="cms-input" value="${esc(d.founded_year||'')}" data-key="founded_year" oninput="updateField(this)"></div>
      <div class="cms-field"><div class="cms-field-label">Founded City</div><input class="cms-input" value="${esc(d.founded_city||'')}" data-key="founded_city" oninput="updateField(this)"></div>
    </div>
    <div class="cms-divider"></div>
    <div style="font-size:.72rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.07em;margin-bottom:10px">Stat Items</div>
    <div id="stats-list">
      ${items.map((s,i) => `<div class="cms-repeater-item">
        <div class="cms-repeater-item-head"><div class="cms-repeater-title">Stat ${i+1}</div></div>
        <div class="cms-input-row-3">
          <div class="cms-field"><div class="cms-field-label">Value</div><input class="cms-input" value="${esc(s.value||'')}" oninput="updateStat(${i},'value',this.value);markDirty()"></div>
          <div class="cms-field"><div class="cms-field-label">Suffix</div><input class="cms-input" value="${esc(s.suffix||'')}" oninput="updateStat(${i},'suffix',this.value);markDirty()"></div>
          <div class="cms-field"><div class="cms-field-label">Label</div><input class="cms-input" value="${esc(s.label||'')}" oninput="updateStat(${i},'label',this.value);markDirty()"></div>
        </div>
      </div>`).join('')}
    </div>
  </div>`;
}

// ── CTA Editor
function buildCtaEditor(d) {
  return `<div style="padding:20px">
    <div class="cms-input-row">
      <div class="cms-field"><div class="cms-field-label">Heading</div><input class="cms-input" value="${esc(d.heading||'')}" data-key="heading" oninput="updateField(this)"></div>
      <div class="cms-field"><div class="cms-field-label">Gradient Part</div><input class="cms-input" value="${esc(d.heading_grad||'')}" data-key="heading_grad" oninput="updateField(this)"></div>
    </div>
    <div class="cms-field"><div class="cms-field-label">Subtext</div><textarea class="cms-input cms-textarea" data-key="subtext" oninput="updateField(this)">${esc(d.subtext||'')}</textarea></div>
    <div class="cms-divider"></div>
    <div class="cms-input-row-3">
      <div class="cms-field"><div class="cms-field-label">Btn 1 Text</div><input class="cms-input" value="${esc(d.btn1_text||'')}" data-key="btn1_text" oninput="updateField(this)"></div>
      <div class="cms-field"><div class="cms-field-label">Btn 1 Href</div><input class="cms-input" value="${esc(d.btn1_href||'')}" data-key="btn1_href" oninput="updateField(this)"></div>
      <div class="cms-field"><div class="cms-field-label">Btn 1 Icon</div>${buildIconPicker('btn1_icon', d.btn1_icon||'ri-rocket-line')}</div>
    </div>
    <div class="cms-input-row-3">
      <div class="cms-field"><div class="cms-field-label">Btn 2 Text</div><input class="cms-input" value="${esc(d.btn2_text||'')}" data-key="btn2_text" oninput="updateField(this)"></div>
      <div class="cms-field"><div class="cms-field-label">Btn 2 Href</div><input class="cms-input" value="${esc(d.btn2_href||'')}" data-key="btn2_href" oninput="updateField(this)"></div>
      <div class="cms-field"><div class="cms-field-label">Btn 2 Icon</div>${buildIconPicker('btn2_icon', d.btn2_icon||'ri-mail-line')}</div>
    </div>
  </div>`;
}

// ── Pricing Plan Editor
function buildPlanEditor(d) {
  return `<div style="padding:20px">
    <div class="cms-input-row">
      <div class="cms-field"><div class="cms-field-label">Heading</div><input class="cms-input" value="${esc(d.heading||'')}" data-key="heading" oninput="updateField(this)"></div>
      <div class="cms-field"><div class="cms-field-label">Gradient Part</div><input class="cms-input" value="${esc(d.heading_grad||'')}" data-key="heading_grad" oninput="updateField(this)"></div>
    </div>
    <div class="cms-field"><div class="cms-field-label">Subtext</div><textarea class="cms-input cms-textarea" data-key="subtext" oninput="updateField(this)">${esc(d.subtext||'')}</textarea></div>
    <div class="cms-divider"></div>
    <div class="cms-input-row-3">
      <div class="cms-field"><div class="cms-field-label">Price</div><input class="cms-input" value="${esc(d.price||'')}" data-key="price" oninput="updateField(this)"></div>
      <div class="cms-field"><div class="cms-field-label">Period</div><input class="cms-input" value="${esc(d.price_period||'')}" data-key="price_period" oninput="updateField(this)"></div>
      <div class="cms-field"><div class="cms-field-label">Price Note</div><input class="cms-input" value="${esc(d.price_note||'')}" data-key="price_note" oninput="updateField(this)"></div>
    </div>
    <div class="cms-divider"></div>
    <div class="cms-input-row-3">
      <div class="cms-field"><div class="cms-field-label">CTA Text</div><input class="cms-input" value="${esc(d.cta_text||'')}" data-key="cta_text" oninput="updateField(this)"></div>
      <div class="cms-field"><div class="cms-field-label">CTA Href</div><input class="cms-input" value="${esc(d.cta_href||'')}" data-key="cta_href" oninput="updateField(this)"></div>
      <div class="cms-field"><div class="cms-field-label">CTA Icon</div>${buildIconPicker('cta_icon', d.cta_icon||'ri-user-add-line')}</div>
    </div>
    <div class="cms-field"><div class="cms-field-label">Footnote</div><input class="cms-input" value="${esc(d.footnote||'')}" data-key="footnote" oninput="updateField(this)"></div>
    <div class="cms-field"><div class="cms-field-label">Comparison Note</div><input class="cms-input" value="${esc(d.comparison_text||'')}" data-key="comparison_text" oninput="updateField(this)"></div>
  </div>`;
}

// ── Contact Info Editor
function buildContactInfoEditor(d) {
  return `<div style="padding:20px">
    <div class="cms-field"><div class="cms-field-label">Office Address</div><textarea class="cms-input cms-textarea" data-key="address" oninput="updateField(this)">${esc(d.address||'')}</textarea></div>
    <div class="cms-input-row">
      <div class="cms-field"><div class="cms-field-label">Main Email</div><input class="cms-input" type="email" value="${esc(d.email_main||'')}" data-key="email_main" oninput="updateField(this)"></div>
      <div class="cms-field"><div class="cms-field-label">Support Email</div><input class="cms-input" type="email" value="${esc(d.email_support||'')}" data-key="email_support" oninput="updateField(this)"></div>
    </div>
    <div class="cms-input-row">
      <div class="cms-field"><div class="cms-field-label">Phone Number</div><input class="cms-input" value="${esc(d.phone||'')}" data-key="phone" oninput="updateField(this)"></div>
      <div class="cms-field"><div class="cms-field-label">Office Hours</div><input class="cms-input" value="${esc(d.hours||'')}" data-key="hours" oninput="updateField(this)"></div>
    </div>
    <div class="cms-divider"></div>
    <div style="font-size:.72rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.07em;margin-bottom:10px">Social Links</div>
    <div class="cms-input-row">
      <div class="cms-field"><div class="cms-field-label"><i class="ri-facebook-fill"></i> Facebook URL</div><input class="cms-input" value="${esc(d.social_facebook||'')}" data-key="social_facebook" oninput="updateField(this)"></div>
      <div class="cms-field"><div class="cms-field-label"><i class="ri-instagram-line"></i> Instagram URL</div><input class="cms-input" value="${esc(d.social_instagram||'')}" data-key="social_instagram" oninput="updateField(this)"></div>
    </div>
    <div class="cms-input-row">
      <div class="cms-field"><div class="cms-field-label"><i class="ri-twitter-x-line"></i> Twitter URL</div><input class="cms-input" value="${esc(d.social_twitter||'')}" data-key="social_twitter" oninput="updateField(this)"></div>
      <div class="cms-field"><div class="cms-field-label"><i class="ri-linkedin-fill"></i> LinkedIn URL</div><input class="cms-input" value="${esc(d.social_linkedin||'')}" data-key="social_linkedin" oninput="updateField(this)"></div>
    </div>
  </div>`;
}

// ── Map Editor
function buildMapEditor(d) {
  return `<div style="padding:20px">
    <div class="cms-input-row">
      <div class="cms-field"><div class="cms-field-label">Section Heading</div><input class="cms-input" value="${esc(d.heading||'')}" data-key="heading" oninput="updateField(this)"></div>
      <div class="cms-field"><div class="cms-field-label">Gradient Part</div><input class="cms-input" value="${esc(d.heading_grad||'')}" data-key="heading_grad" oninput="updateField(this)"></div>
    </div>
    <div class="cms-field"><div class="cms-field-label">Subtext</div><textarea class="cms-input cms-textarea" data-key="subtext" oninput="updateField(this)">${esc(d.subtext||'')}</textarea></div>
    <div class="cms-field"><div class="cms-field-label">Google Maps Embed URL</div><input class="cms-input" value="${esc(d.map_embed||'')}" data-key="map_embed" oninput="updateField(this)"></div>
    <div class="cms-divider"></div>
    <div style="font-size:.72rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.07em;margin-bottom:10px">Map Overlay Card</div>
    <div class="cms-field"><div class="cms-field-label">Overlay Title</div><input class="cms-input" value="${esc(d.overlay_title||'')}" data-key="overlay_title" oninput="updateField(this)"></div>
    <div class="cms-field"><div class="cms-field-label">Overlay Address (one line per row)</div><textarea class="cms-input cms-textarea" data-key="overlay_address" oninput="updateField(this)">${esc(d.overlay_address||'')}</textarea></div>
    <div class="cms-field"><div class="cms-field-label">Get Directions URL</div><input class="cms-input" value="${esc(d.directions_url||'')}" data-key="directions_url" oninput="updateField(this)"></div>
  </div>`;
}

// ── Hours Editor
function buildHoursEditor(d) {
  return `<div style="padding:20px">
    ${['1','2','3'].map(n => `
    <div class="cms-repeater-item" style="margin-bottom:12px">
      <div class="cms-repeater-item-head"><div class="cms-repeater-title">Card ${n}</div></div>
      <div class="cms-input-row-3">
        <div class="cms-field"><div class="cms-field-label">Icon</div>${buildIconPicker(`card${n}_icon`, d[`card${n}_icon`]||'ri-time-line')}</div>
        <div class="cms-field"><div class="cms-field-label">Title</div><input class="cms-input" value="${esc(d[`card${n}_title`]||'')}" data-key="card${n}_title" oninput="updateField(this)"></div>
        <div class="cms-field"><div class="cms-field-label">Text</div><input class="cms-input" value="${esc(d[`card${n}_text`]||'')}" data-key="card${n}_text" oninput="updateField(this)"></div>
      </div>
    </div>`).join('')}
  </div>`;
}

// ── Category Cards Editor
function buildCategoryCardsEditor(d) {
  const cards = d.cards || [];
  return `<div style="padding:20px">
    <div class="cms-input-row">
      <div class="cms-field"><div class="cms-field-label">Heading</div><input class="cms-input" value="${esc(d.heading||'')}" data-key="heading" oninput="updateField(this)"></div>
      <div class="cms-field"><div class="cms-field-label">Gradient Part</div><input class="cms-input" value="${esc(d.heading_grad||'')}" data-key="heading_grad" oninput="updateField(this)"></div>
    </div>
    <div class="cms-field"><div class="cms-field-label">Subtext</div><textarea class="cms-input cms-textarea" data-key="subtext" oninput="updateField(this)">${esc(d.subtext||'')}</textarea></div>
    <div class="cms-divider"></div>
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px">
      <div style="font-size:.72rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.07em">Category Cards</div>
      <button class="cms-repeater-add" style="width:auto;padding:5px 12px" onclick="addCatCard()"><i class="ri-add-line"></i> Add Card</button>
    </div>
    <div id="catcards-list">
      ${cards.map((c,i) => `<div class="cms-repeater-item" id="catcard-${i}">
        <div class="cms-repeater-item-head">
          <div class="cms-repeater-title">Card ${i+1}</div>
          <button class="cms-repeater-remove" onclick="removeCatCard(${i})"><i class="ri-close-line"></i></button>
        </div>
        <div class="cms-input-row">
          <div class="cms-field"><div class="cms-field-label">Icon</div>${buildIconPicker(`catcard_icon_${i}`, c.icon||'ri-check-line')}</div>
          <div class="cms-field"><div class="cms-field-label">Icon Color</div>${buildColorPicker(`catcard_color_${i}`, c.icon_color||'#a78bfa')}</div>
        </div>
        <div class="cms-input-row">
          <div class="cms-field"><div class="cms-field-label">Title</div><input class="cms-input" value="${esc(c.title||'')}" oninput="updateCatCard(${i},'title',this.value);markDirty()"></div>
          <div class="cms-field"><div class="cms-field-label">Subtitle</div><input class="cms-input" value="${esc(c.subtitle||'')}" oninput="updateCatCard(${i},'subtitle',this.value);markDirty()"></div>
        </div>
        <div class="cms-field"><div class="cms-field-label">Description</div><textarea class="cms-input cms-textarea" style="min-height:54px" oninput="updateCatCard(${i},'text',this.value);markDirty()">${esc(c.text||'')}</textarea></div>
        <div class="cms-field"><div class="cms-field-label">Tags (comma separated)</div><input class="cms-input" value="${esc(c.tags||'')}" oninput="updateCatCard(${i},'tags',this.value);markDirty()"></div>
      </div>`).join('')}
    </div>
  </div>`;
}

// ── FAQ Editor
function buildFaqEditor(d, title) {
  const items = d.items || [];
  return `<div style="padding:20px">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
      <div style="font-size:.72rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.07em">${title}</div>
      <button class="cms-repeater-add" style="width:auto;padding:5px 12px" onclick="addFaqItem()"><i class="ri-add-line"></i> Add Q&A</button>
    </div>
    <div id="faq-list">
      ${items.map((item,i) => `<div class="cms-repeater-item" id="faq-${i}">
        <div class="cms-repeater-item-head">
          <div class="cms-repeater-title">Q${i+1}</div>
          <button class="cms-repeater-remove" onclick="removeFaqItem(${i})"><i class="ri-close-line"></i></button>
        </div>
        <div class="cms-field"><div class="cms-field-label">Question</div><input class="cms-input" value="${esc(item.q||'')}" oninput="updateFaqItem(${i},'q',this.value);markDirty()"></div>
        <div class="cms-field"><div class="cms-field-label">Answer</div><textarea class="cms-input cms-textarea" oninput="updateFaqItem(${i},'a',this.value);markDirty()">${esc(item.a||'')}</textarea></div>
      </div>`).join('')}
    </div>
  </div>`;
}

// ── Legal Editor
function buildLegalEditor(d) {
  const sections = d.sections || [];
  return `<div style="padding:20px">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
      <div style="font-size:.72rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.07em">Legal Sections</div>
      <button class="cms-repeater-add" style="width:auto;padding:5px 12px" onclick="addLegalSection()"><i class="ri-add-line"></i> Add Section</button>
    </div>
    <div id="legal-list">
      ${sections.map((s,i) => `<div class="cms-repeater-item" id="legal-${i}">
        <div class="cms-repeater-item-head">
          <div class="cms-repeater-title">Section ${s.number||i+1}</div>
          <button class="cms-repeater-remove" onclick="removeLegalSection(${i})"><i class="ri-close-line"></i></button>
        </div>
        <div class="cms-input-row">
          <div class="cms-field"><div class="cms-field-label">Section Number</div><input class="cms-input" value="${esc(s.number||'')}" style="width:60px" oninput="updateLegal(${i},'number',this.value);markDirty()"></div>
          <div class="cms-field" style="flex:1"><div class="cms-field-label">Heading</div><input class="cms-input" value="${esc(s.heading||'')}" oninput="updateLegal(${i},'heading',this.value);markDirty()"></div>
          <div class="cms-field"><div class="cms-field-label">Type</div>
            <select class="cms-input" onchange="updateLegal(${i},'type',this.value);markDirty()">
              <option value="para" ${s.type==='para'?'selected':''}>Paragraph</option>
              <option value="list" ${s.type==='list'?'selected':''}>List</option>
            </select>
          </div>
        </div>
        <div class="cms-field"><div class="cms-field-label">Content (one item per line for lists)</div><textarea class="cms-input cms-textarea" rows="4" oninput="updateLegal(${i},'content',this.value);markDirty()">${esc(s.content||'')}</textarea></div>
      </div>`).join('')}
    </div>
  </div>`;
}

// ── Featured Post Editor
function buildFeaturedEditor(d) {
  return `<div style="padding:20px">
    <div class="cms-field"><div class="cms-field-label">Hero Image URL</div><input class="cms-input" value="${esc(d.image_url||'')}" data-key="image_url" oninput="updateField(this)" placeholder="https://…"></div>
    <div class="cms-input-row">
      <div class="cms-field"><div class="cms-field-label">Category Badge</div><input class="cms-input" value="${esc(d.cat_badge||'')}" data-key="cat_badge" oninput="updateField(this)"></div>
      <div class="cms-field"><div class="cms-field-label">Badge Icon</div>${buildIconPicker('cat_badge_icon', d.cat_badge_icon||'ri-map-2-line')}</div>
    </div>
    <div class="cms-field"><div class="cms-field-label">Read Time</div><input class="cms-input" value="${esc(d.read_time||'')}" data-key="read_time" oninput="updateField(this)" placeholder="8 min read"></div>
    <div class="cms-field"><div class="cms-field-label">Article Heading</div><textarea class="cms-input cms-textarea" style="min-height:54px" data-key="heading" oninput="updateField(this)">${esc(d.heading||'')}</textarea></div>
    <div class="cms-field"><div class="cms-field-label">Excerpt</div><textarea class="cms-input cms-textarea" data-key="excerpt" oninput="updateField(this)">${esc(d.excerpt||'')}</textarea></div>
    <div class="cms-input-row-3">
      <div class="cms-field"><div class="cms-field-label">Author Initials</div><input class="cms-input" value="${esc(d.author_initials||'')}" data-key="author_initials" oninput="updateField(this)"></div>
      <div class="cms-field"><div class="cms-field-label">Author Name</div><input class="cms-input" value="${esc(d.author_name||'')}" data-key="author_name" oninput="updateField(this)"></div>
      <div class="cms-field"><div class="cms-field-label">Date</div><input class="cms-input" value="${esc(d.date||'')}" data-key="date" oninput="updateField(this)"></div>
    </div>
    <div class="cms-input-row">
      <div class="cms-field"><div class="cms-field-label">Article Link (href)</div><input class="cms-input" value="${esc(d.link||'')}" data-key="link" oninput="updateField(this)"></div>
      <div class="cms-field"><div class="cms-field-label">CTA Button Text</div><input class="cms-input" value="${esc(d.cta_text||'')}" data-key="cta_text" oninput="updateField(this)"></div>
    </div>
  </div>`;
}

// ── Sidebar Editor
function buildSidebarEditor(d) {
  const items = d.items || [];
  return `<div style="padding:20px">
    <div class="cms-field"><div class="cms-field-label">Trending Section Title</div><input class="cms-input" value="${esc(d.trending_title||'')}" data-key="trending_title" oninput="updateField(this)"></div>
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;margin-top:14px">
      <div style="font-size:.72rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.07em">Trending Items</div>
      <button class="cms-repeater-add" style="width:auto;padding:5px 12px" onclick="addTrending()"><i class="ri-add-line"></i> Add</button>
    </div>
    <div id="trending-list">
      ${items.map((item,i) => `<div class="cms-repeater-item" id="tr-${i}">
        <div class="cms-repeater-item-head">
          <div class="cms-repeater-title">Item ${i+1}</div>
          <button class="cms-repeater-remove" onclick="removeTrending(${i})"><i class="ri-close-line"></i></button>
        </div>
        <div class="cms-input-row">
          <div class="cms-field"><div class="cms-field-label">Title</div><input class="cms-input" value="${esc(item.title||'')}" oninput="updateTrending(${i},'title',this.value);markDirty()"></div>
          <div class="cms-field"><div class="cms-field-label">Read Time</div><input class="cms-input" value="${esc(item.read||'')}" oninput="updateTrending(${i},'read',this.value);markDirty()" style="width:80px"></div>
        </div>
      </div>`).join('')}
    </div>
    <div class="cms-divider"></div>
    ${buildToggleField('show_tags','Show Tags Section', d.show_tags)}
    <div class="cms-field"><div class="cms-field-label">Tags (comma separated)</div><input class="cms-input" value="${esc(d.tags||'')}" data-key="tags" oninput="updateField(this)"></div>
  </div>`;
}

// ── Share Editor
function buildShareEditor(d) {
  return `<div style="padding:20px">
    <div style="font-size:.72rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.07em;margin-bottom:12px">Visible Share Buttons</div>
    ${buildToggleField('show_twitter','Twitter / X', d.show_twitter)}
    ${buildToggleField('show_linkedin','LinkedIn', d.show_linkedin)}
    ${buildToggleField('show_facebook','Facebook', d.show_facebook)}
    ${buildToggleField('show_email','Email', d.show_email)}
    ${buildToggleField('show_copy','Copy Link', d.show_copy)}
    <div class="cms-divider"></div>
    <div class="cms-field"><div class="cms-field-label">Twitter Share Text</div><input class="cms-input" value="${esc(d.twitter_text||'')}" data-key="twitter_text" oninput="updateField(this)"></div>
  </div>`;
}

// ── Meta Editor
function buildMetaEditor(d) {
  return `<div style="padding:20px">
    <div style="font-size:.72rem;color:var(--text3);margin-bottom:16px">Article meta displayed below the hero — author, date, read time, stats.</div>
    <div class="cms-input-row">
      <div class="cms-field"><div class="cms-field-label">Author Name</div><input class="cms-input" value="${esc(d.author_name||'Sarah Reynolds')}" data-key="author_name" oninput="updateField(this)"></div>
      <div class="cms-field"><div class="cms-field-label">Author Initials</div><input class="cms-input" value="${esc(d.author_initials||'SR')}" data-key="author_initials" oninput="updateField(this)"></div>
    </div>
    <div class="cms-input-row">
      <div class="cms-field"><div class="cms-field-label">Publish Date</div><input class="cms-input" type="date" value="${d.publish_date||''}" data-key="publish_date" oninput="updateField(this)"></div>
      <div class="cms-field"><div class="cms-field-label">Read Time</div><input class="cms-input" value="${esc(d.read_time||'8 min read')}" data-key="read_time" oninput="updateField(this)"></div>
    </div>
    <div class="cms-input-row">
      <div class="cms-field"><div class="cms-field-label">View Count</div><input class="cms-input" type="number" value="${d.views||2100}" data-key="views" oninput="updateField(this)"></div>
      <div class="cms-field"><div class="cms-field-label">Comment Count</div><input class="cms-input" type="number" value="${d.comments||24}" data-key="comments" oninput="updateField(this)"></div>
    </div>
  </div>`;
}

// ── TOC Editor
function buildTocEditor(d) {
  const items = d.items || [{anchor:'#why-people-overpay', label:'Why People Overpay'},{anchor:'#step-by-step', label:'Step-by-Step System'},{anchor:'#common-mistakes', label:'Common Mistakes'},{anchor:'#final-thoughts', label:'Final Thoughts'}];
  return `<div style="padding:20px">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
      <div style="font-size:.72rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.07em">TOC Items</div>
      <button class="cms-repeater-add" style="width:auto;padding:5px 12px" onclick="addTocItem()"><i class="ri-add-line"></i> Add Item</button>
    </div>
    <div id="toc-list">
      ${items.map((item,i) => `<div class="cms-repeater-item" id="toc-${i}">
        <div class="cms-repeater-item-head"><div class="cms-repeater-title">Item ${i+1}</div><button class="cms-repeater-remove" onclick="removeTocItem(${i})"><i class="ri-close-line"></i></button></div>
        <div class="cms-input-row">
          <div class="cms-field"><div class="cms-field-label">Label</div><input class="cms-input" value="${esc(item.label||'')}" oninput="markDirty()"></div>
          <div class="cms-field"><div class="cms-field-label">Anchor (#id)</div><input class="cms-input" value="${esc(item.anchor||'')}" placeholder="#section-id" oninput="markDirty()"></div>
        </div>
      </div>`).join('')}
    </div>
  </div>`;
}

// ── Related Articles Editor
function buildRelatedEditor(d) {
  const items = d.items || [
    {title:'5 Subscriptions You\'re Paying for and Forgetting', cat:'Savings', read:'4 min', img:'https://images.unsplash.com/photo-1579621970563-ebec7560ff3e?w=200&q=80', href:'blog-detail'},
    {title:'Why Auto-Renewal is Costing You $4B a Year', cat:'Finance', read:'6 min', img:'https://images.unsplash.com/photo-1526304640581-d334cdbbf45e?w=200&q=80', href:'blog-detail'},
  ];
  return `<div style="padding:20px">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
      <div style="font-size:.72rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.07em">Related Articles</div>
      <button class="cms-repeater-add" style="width:auto;padding:5px 12px" onclick="addRelated()"><i class="ri-add-line"></i> Add Article</button>
    </div>
    <div id="related-list">
      ${items.map((item,i) => `<div class="cms-repeater-item" id="rel-${i}">
        <div class="cms-repeater-item-head"><div class="cms-repeater-title">Article ${i+1}</div><button class="cms-repeater-remove" onclick="removeRelated(${i})"><i class="ri-close-line"></i></button></div>
        <div class="cms-field"><div class="cms-field-label">Title</div><input class="cms-input" value="${esc(item.title||'')}" oninput="markDirty()"></div>
        <div class="cms-input-row-3">
          <div class="cms-field"><div class="cms-field-label">Category</div><input class="cms-input" value="${esc(item.cat||'')}" oninput="markDirty()"></div>
          <div class="cms-field"><div class="cms-field-label">Read Time</div><input class="cms-input" value="${esc(item.read||'')}" oninput="markDirty()"></div>
          <div class="cms-field"><div class="cms-field-label">Link (href)</div><input class="cms-input" value="${esc(item.href||'')}" oninput="markDirty()"></div>
        </div>
        <div class="cms-field"><div class="cms-field-label">Thumbnail URL</div><input class="cms-input" value="${esc(item.img||'')}" oninput="markDirty()"></div>
      </div>`).join('')}
    </div>
  </div>`;
}

// ── Features Editor (generic)
function buildFeaturesEditor(d) {
  return buildCardsEditor(d, 'Feature Cards', ['icon','title','text']);
}

// ── Generic Editor fallback
function buildGenericEditor(d) {
  return `<div style="padding:20px;text-align:center;color:var(--text3);padding-top:60px">
    <i class="ri-tools-line" style="font-size:2rem;opacity:.3;display:block;margin-bottom:8px"></i>
    <div style="font-size:.82rem">Section editor not yet defined</div>
  </div>`;
}

// ══════════════════════════════════════════════════════════
// REUSABLE FIELD BUILDERS
// ══════════════════════════════════════════════════════════

function buildColorPicker(key, currentColor, onchangeFn) {
  return `<div class="color-swatch-row" id="cp-${key}">
    ${ACCENT_COLORS.map(c => `<div class="color-swatch ${c===currentColor?'active':''}" style="background:${c}" 
      onclick="pickColor('${key}','${c}',this${onchangeFn?','+"'"+onchangeFn+"'":''})" title="${c}"></div>`).join('')}
    <input type="color" value="${currentColor}" title="Custom color"
      style="width:24px;height:24px;border:none;border-radius:6px;cursor:pointer;padding:0;background:none"
      oninput="pickColor('${key}',this.value,null${onchangeFn?','+"'"+onchangeFn+"'":''})" data-cp-custom="${key}">
  </div>`;
}

function buildIconPicker(key, currentIcon, onchangeFn) {
  return `<div class="icon-picker-wrap">
    <div class="icon-preview-btn" onclick="openIconPicker('${key}',this,${onchangeFn?JSON.stringify(onchangeFn):'null'})">
      <div class="icon-preview-icon"><i class="${currentIcon}" id="ip-preview-${key}"></i></div>
      <span class="icon-preview-name" id="ip-name-${key}">${currentIcon}</span>
      <i class="ri-arrow-down-s-line" style="color:var(--text3);margin-left:auto"></i>
    </div>
  </div>`;
}

function buildToggleField(key, label, checked) {
  return `<div class="cms-toggle" style="margin-bottom:8px">
    <div>
      <div class="cms-toggle-label">${label}</div>
    </div>
    <label class="switch">
      <input type="checkbox" ${checked?'checked':''} data-key="${key}" onchange="updateField(this)">
      <span class="switch-slider"></span>
    </label>
  </div>`;
}

// ══════════════════════════════════════════════════════════
// ICON PICKER LOGIC
// ══════════════════════════════════════════════════════════

let iconPickerKey = null;
let iconPickerOnchange = null;

function buildIconGrid(icons) {
  const grid = document.getElementById('icon-grid');
  grid.innerHTML = icons.map(ic =>
    `<div class="icon-grid-btn" onclick="selectIcon('${ic}')" title="${ic}"><i class="${ic}"></i></div>`
  ).join('');
}

function openIconPicker(key, triggerEl, onchangeFn) {
  iconPickerKey = key;
  iconPickerOnchange = onchangeFn;
  const picker = document.getElementById('global-icon-picker');
  const rect = triggerEl.getBoundingClientRect();
  picker.style.position = 'fixed';
  picker.style.top = (rect.bottom + 6) + 'px';
  picker.style.left = rect.left + 'px';
  picker.style.width = rect.width + 'px';
  picker.style.maxWidth = '280px';
  picker.classList.add('open');
  document.getElementById('icon-search-inp').value = '';
  filterIcons('');
  event.stopPropagation();
}

function filterIcons(q) {
  const btns = document.querySelectorAll('#icon-grid .icon-grid-btn');
  btns.forEach(btn => {
    const title = btn.getAttribute('title') || '';
    btn.style.display = !q || title.includes(q.toLowerCase()) ? '' : 'none';
  });
}

function selectIcon(icon) {
  if (!iconPickerKey) return;
  const preview = document.getElementById(`ip-preview-${iconPickerKey}`);
  const name    = document.getElementById(`ip-name-${iconPickerKey}`);
  if (preview) { preview.className = icon; }
  if (name)    { name.textContent = icon; }
  // Store in section data
  if (activePage && activeSection) {
    pageStore[activePage.id].sections[activeSection][iconPickerKey] = icon;
  }
  document.getElementById('global-icon-picker').classList.remove('open');
  markDirty();
}

// ══════════════════════════════════════════════════════════
// COLOR PICKER LOGIC
// ══════════════════════════════════════════════════════════

function pickColor(key, color, swatchEl, onchangeFn) {
  if (swatchEl) {
    const container = document.getElementById('cp-' + key);
    if (container) container.querySelectorAll('.color-swatch').forEach(s => s.classList.remove('active'));
    swatchEl.classList?.add('active');
  }
  if (activePage && activeSection) {
    pageStore[activePage.id].sections[activeSection][key] = color;
  }
  markDirty();
}

// ══════════════════════════════════════════════════════════
// FIELD UPDATE
// ══════════════════════════════════════════════════════════

function updateField(el) {
  const key = el.dataset.key;
  if (!key || !activePage || !activeSection) return;
  const val = el.type === 'checkbox' ? el.checked : el.value;
  pageStore[activePage.id].sections[activeSection][key] = val;
  markDirty();
}

// Repeater updaters
function updateMissionPoint(i, field, val) { const pts = pageStore[activePage.id].sections[activeSection].points; if (pts[i]) pts[i][field] = val; }
function updateMember(i, field, val)        { const m = pageStore[activePage.id].sections[activeSection].members; if (m[i]) m[i][field] = val; }
function updateStat(i, field, val)          { const s = pageStore[activePage.id].sections[activeSection].items; if (s[i]) s[i][field] = val; }
function updateCard(i, field, val)          { const c = pageStore[activePage.id].sections[activeSection].cards; if (c[i]) c[i][field] = val; }
function updateCatCard(i, field, val)       { const c = pageStore[activePage.id].sections[activeSection].cards; if (c[i]) c[i][field] = val; }
function updateFaqItem(i, field, val)       { const f = pageStore[activePage.id].sections[activeSection].items; if (f[i]) f[i][field] = val; }
function updateLegal(i, field, val)         { const l = pageStore[activePage.id].sections[activeSection].sections; if (l[i]) l[i][field] = val; }
function updateTrending(i, field, val)      { const t = pageStore[activePage.id].sections[activeSection].items; if (t[i]) t[i][field] = val; }

// Add/remove repeater items
function addMissionPoint()  { const s = pageStore[activePage.id].sections[activeSection]; s.points = s.points||[]; s.points.push({icon:'ri-check-line',icon_color:'#a78bfa',icon_bg:'rgba(124,58,237,.15)',title:'New Point',text:'Description'}); renderEditorBody(); markDirty(); }
function removeMissionPoint(i){ const s = pageStore[activePage.id].sections[activeSection]; s.points.splice(i,1); renderEditorBody(); markDirty(); }
function addCard()           { const s = pageStore[activePage.id].sections[activeSection]; s.cards=s.cards||[]; s.cards.push({emoji:'⭐',title:'New Card',text:'Description'}); renderEditorBody(); markDirty(); }
function removeCard(i)       { const s = pageStore[activePage.id].sections[activeSection]; s.cards.splice(i,1); renderEditorBody(); markDirty(); }
function addTeamMember()     { const s = pageStore[activePage.id].sections[activeSection]; s.members=s.members||[]; s.members.push({initials:'NM',name:'New Member',role:'Role',role_color:'#a78bfa',bio:'Bio text.'}); renderEditorBody(); markDirty(); }
function removeTeamMember(i) { const s = pageStore[activePage.id].sections[activeSection]; s.members.splice(i,1); renderEditorBody(); markDirty(); }
function addFaqItem()        { const s = pageStore[activePage.id].sections[activeSection]; s.items=s.items||[]; s.items.push({q:'New Question?',a:'Answer text.'}); renderEditorBody(); markDirty(); }
function removeFaqItem(i)    { const s = pageStore[activePage.id].sections[activeSection]; s.items.splice(i,1); renderEditorBody(); markDirty(); }
function addLegalSection()   { const s = pageStore[activePage.id].sections[activeSection]; s.sections=s.sections||[]; s.sections.push({number:String(s.sections.length+1),heading:'New Section',type:'para',content:'Content here.'}); renderEditorBody(); markDirty(); }
function removeLegalSection(i){ const s = pageStore[activePage.id].sections[activeSection]; s.sections.splice(i,1); renderEditorBody(); markDirty(); }
function addCatCard()        { const s = pageStore[activePage.id].sections[activeSection]; s.cards=s.cards||[]; s.cards.push({icon:'ri-add-circle-line',icon_color:'#a78bfa',icon_bg:'rgba(124,58,237,.15)',title:'New Category',subtitle:'Sub · Sub',text:'Description.',tags:'Tag1,Tag2'}); renderEditorBody(); markDirty(); }
function removeCatCard(i)    { const s = pageStore[activePage.id].sections[activeSection]; s.cards.splice(i,1); renderEditorBody(); markDirty(); }
function addTrending()       { const s = pageStore[activePage.id].sections[activeSection]; s.items=s.items||[]; s.items.push({title:'New Article',read:'5 min'}); renderEditorBody(); markDirty(); }
function removeTrending(i)   { const s = pageStore[activePage.id].sections[activeSection]; s.items.splice(i,1); renderEditorBody(); markDirty(); }
function addTocItem()        { cmsToast('Add TOC items from the article heading IDs','success'); markDirty(); }
function removeTocItem(i)    { markDirty(); }
function addRelated()        { markDirty(); }
function removeRelated(i)    { markDirty(); }

// ══════════════════════════════════════════════════════════
// SUB-TAB SWITCHER
// ══════════════════════════════════════════════════════════

function switchSubTab(btn, targetId) {
  const parentTabs = btn.closest('.cms-section-tabs');
  parentTabs.querySelectorAll('.cms-stab').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  // Hide all sub panels under same parent
  const edBody = document.getElementById('ed-body');
  edBody.querySelectorAll('[id^="sub-"]').forEach(el => el.style.display = 'none');
  const target = document.getElementById(targetId);
  if (target) target.style.display = '';
}

// ══════════════════════════════════════════════════════════
// DIRTY STATE
// ══════════════════════════════════════════════════════════

function markDirty() {
  isDirty = true;
  document.getElementById('page-unsaved-dot').classList.add('show');
  document.getElementById('global-unsaved-dot').classList.add('show');
  document.getElementById('last-saved-lbl').textContent = 'Unsaved changes';
  document.getElementById('last-saved-lbl').style.color = 'var(--amber)';
}

function updateDirtyState(dirty) {
  isDirty = dirty;
  document.getElementById('page-unsaved-dot').classList.toggle('show', dirty);
  document.getElementById('global-unsaved-dot').classList.toggle('show', dirty);
  if (!dirty) {
    document.getElementById('last-saved-lbl').textContent = 'Saved just now';
    document.getElementById('last-saved-lbl').style.color = 'var(--green)';
  }
}

// ══════════════════════════════════════════════════════════
// SAVE
// ══════════════════════════════════════════════════════════

function cmsSavePage() {
  if (!activePage) return;
  // Update status in page object
  const status = document.getElementById('ed-status').value;
  pageStore[activePage.id].status = status;
  const page = CMS_PAGES.find(p => p.id === activePage.id);
  if (page) page.status = status;
  renderPageTree(CMS_PAGES);
  updateDirtyState(false);
  cmsToast(`"${activePage.title}" saved successfully!`, 'success');
  // In production: POST to /admin/cms/{page}/save with JSON.stringify(pageStore[activePage.id])
}

function cmsSaveAll() {
  if (!activePage) return;
  cmsSavePage();
  cmsToast('All pages saved!', 'success');
}

function cmsReset() {
  if (!activePage || !activeSection) return;
  const defaults = SECTION_DEFAULTS[activeSection];
  if (defaults) {
    pageStore[activePage.id].sections[activeSection] = JSON.parse(JSON.stringify(defaults));
    renderEditorBody();
    markDirty();
    cmsToast('Section reset to defaults', 'success');
  }
}

function cmsPreview() {
  if (!activePage) return;
  window.open(activePage.url, '_blank');
}

// ══════════════════════════════════════════════════════════
// TOAST
// ══════════════════════════════════════════════════════════

function cmsToast(msg, type) {
  const c = document.getElementById('cms-toast');
  const t = document.createElement('div');
  t.className = `cms-toast-item cms-t-${type}`;
  t.innerHTML = `<i class="ri-${type==='success'?'check':'error-warning'}-line"></i>${msg}`;
  c.appendChild(t);
  setTimeout(() => { t.style.opacity='0'; t.style.transition='opacity .3s'; setTimeout(()=>t.remove(),300); }, 3000);
}

// ══════════════════════════════════════════════════════════
// HELPERS
// ══════════════════════════════════════════════════════════

function esc(str) {
  return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

// ══════════════════════════════════════════════════════════
// BOOT
// ══════════════════════════════════════════════════════════

initCMS();
</script>
@endsection