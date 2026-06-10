@extends('admin.layouts.app')
@section('content')

<style>
    .cms-editor-wrap {
        padding: 0;
        font-family: inherit
    }

    .cms-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 10px
    }

    .cms-title {
        font-size: 1.3rem;
        font-weight: 800
    }

    .cms-subtitle {
        font-size: .8rem;
        color: var(--text3);
        margin-top: 3px
    }

    .cms-topbar-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap
    }

    .saved-badge {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: .75rem;
        color: var(--text4)
    }

    .saved-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--green);
        flex-shrink: 0
    }

    .unsaved-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--amber);
        flex-shrink: 0
    }

    .editor-shell {
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        background: var(--card)
    }

    .cms-toolbar {
        display: flex;
        align-items: center;
        gap: 2px;
        padding: 8px 10px;
        border-bottom: 1px solid var(--border);
        flex-wrap: wrap;
        background: var(--bg2)
    }

    .tb-sep {
        width: 1px;
        height: 18px;
        background: var(--border);
        margin: 0 5px;
        flex-shrink: 0
    }

    .tb-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 30px;
        border: none;
        border-radius: var(--radius-sm);
        cursor: pointer;
        background: transparent;
        color: var(--text3);
        font-size: 15px;
        transition: all .12s;
        flex-shrink: 0
    }

    .tb-btn:hover {
        background: var(--surface2);
        color: var(--text)
    }

    .tb-btn.on {
        background: var(--surface2);
        color: var(--purple);
        border: 1px solid rgba(124, 58, 237, .25)
    }

    .tb-label {
        font-size: .68rem;
        color: var(--text4);
        padding: 0 4px;
        white-space: nowrap;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .04em
    }

    .tb-select {
        padding: 4px 8px;
        font-size: .78rem;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        background: var(--surface2);
        color: var(--text3);
        cursor: pointer;
        height: 30px
    }

    .tb-select:focus {
        outline: none;
        border-color: var(--purple)
    }

    .find-bar {
        display: none;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-bottom: 1px solid var(--border);
        background: var(--bg2);
        flex-wrap: wrap
    }

    .find-bar.show {
        display: flex
    }

    .find-bar input {
        padding: 5px 10px;
        font-size: .82rem;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        background: var(--surface2);
        color: var(--text);
        width: 170px
    }

    .find-bar input:focus {
        outline: none;
        border-color: var(--purple)
    }

    .find-count {
        font-size: .75rem;
        color: var(--text4);
        min-width: 56px
    }

    /* The two editor panes live in the same shell, toggled by JS */
    .edit-area {
        width: 100%;
        min-height: 460px;
        padding: 22px 26px;
        font-size: .9rem;
        line-height: 1.9;
        font-family: inherit;
        color: var(--text);
        background: var(--card);
        border: none;
        outline: none;
        box-sizing: border-box
    }

    .edit-area:focus {
        outline: none
    }

    .edit-area:empty::before {
        content: attr(data-ph);
        color: var(--text4);
        pointer-events: none;
        white-space: pre-line
    }

    /* rich-text styles */
    .edit-area h2 {
        font-size: 1.4rem;
        font-weight: 800;
        margin: 20px 0 10px;
        color: var(--text);
        line-height: 1.3
    }

    .edit-area h3 {
        font-size: 1.15rem;
        font-weight: 700;
        margin: 16px 0 8px;
        color: var(--text);
        line-height: 1.4
    }

    .edit-area h4 {
        font-size: .98rem;
        font-weight: 700;
        margin: 12px 0 6px;
        color: var(--text2);
        line-height: 1.4
    }

    .edit-area p {
        margin: 0 0 10px
    }

    .edit-area ul {
        padding-left: 24px;
        margin: 0 0 10px;
        list-style-type: disc !important
    }

    .edit-area ol {
        padding-left: 24px;
        margin: 0 0 10px;
        list-style-type: decimal !important
    }

    .edit-area ul ul {
        list-style-type: circle !important
    }

    .edit-area ul ul ul {
        list-style-type: square !important
    }

    .edit-area li {
        margin-bottom: 5px;
        display: list-item !important
    }

    .edit-area a {
        color: var(--purple);
        text-decoration: underline
    }

    .edit-area hr {
        border: none;
        border-top: 1px solid var(--border);
        margin: 16px 0
    }

    .edit-area b,
    .edit-area strong {
        font-weight: 700
    }

    .edit-area i,
    .edit-area em {
        font-style: italic
    }

    .edit-area u {
        text-decoration: underline
    }

    .edit-area s,
    .edit-area strike {
        text-decoration: line-through
    }

    .edit-area blockquote {
        border-left: 3px solid var(--purple);
        margin: 10px 0;
        padding: 8px 16px;
        color: var(--text2);
        font-style: italic
    }

    .edit-area table {
        border-collapse: collapse;
        width: 100%;
        margin: 10px 0
    }

    .edit-area th,
    .edit-area td {
        border: 1px solid var(--border);
        padding: 8px 12px;
        text-align: left
    }

    .edit-area th {
        background: var(--bg2);
        font-weight: 700
    }

    /* HTML source textarea */
    #source-area {
        display: none;
        width: 100%;
        min-height: 460px;
        padding: 22px 26px;
        font-size: .82rem;
        line-height: 1.7;
        font-family: monospace;
        color: var(--text);
        background: var(--card);
        border: none;
        outline: none;
        resize: none;
        box-sizing: border-box
    }

    #source-area:focus {
        outline: none
    }

    #source-area.active {
        display: block
    }

    .edit-area.hidden {
        display: none
    }

    .statusbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 7px 16px;
        border-top: 1px solid var(--border);
        background: var(--bg2);
        flex-wrap: wrap;
        gap: 6px
    }

    .stat-grp {
        display: flex;
        align-items: center;
        gap: 14px
    }

    .stat-item {
        font-size: .72rem;
        color: var(--text4);
        display: flex;
        align-items: center;
        gap: 4px
    }

    .hist-strip {
        display: flex;
        align-items: center;
        gap: 7px;
        padding: 6px 14px;
        border-top: 1px solid var(--border);
        background: var(--bg2);
        font-size: .72rem;
        color: var(--text4);
        border-radius: 0 0 var(--radius) var(--radius)
    }

    .bottom-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 14px;
        flex-wrap: wrap;
        gap: 8px
    }

    .cms-toast {
        display: none;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: var(--radius);
        background: var(--surface);
        border: 1px solid var(--border);
        color: var(--text);
        font-size: .82rem;
        font-weight: 600;
        margin-bottom: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, .12)
    }

    .cms-toast.show {
        display: flex
    }

    .cms-toast .toast-icon {
        color: var(--green);
        font-size: 1rem
    }
</style>

<div class="cms-editor-wrap">

    <div class="cms-toast" id="cms-toast">
        <i class="ri-checkbox-circle-line toast-icon"></i>
        <span id="cms-toast-msg">Saved!</span>
    </div>

    <div class="cms-topbar">
        <div>
            <h2 class="cms-title font-jakarta">CMS — Terms & Conditions</h2>
            <p class="cms-subtitle">Edit the full page content and publish</p>
        </div>

        <div class="bottom-bar">
            <div style="display:flex;gap:6px">
                <button class="btn btn-ghost btn-sm" onclick="copyPlain()"><i class="ri-file-copy-line"></i> Copy text</button>
                <button class="btn btn-ghost btn-sm hidden" style="color:var(--red);border-color:rgba(239,68,68,.3)" onclick="clearAll()"><i class="ri-delete-bin-line"></i> Clear</button>
            </div>
            <div style="display:flex;gap:6px">
            @if(auth('admin')->user()->hasPermission('CMS', 'cms.edit'))
                <button class="btn btn-primary btn-sm" onclick="savePage()"><i class="ri-save-line"></i> Save &amp; Publish</button>
            @endif
            </div>
        </div>

    </div>
    <div class="cms-topbar-actions" style="display:none">
        <span class="saved-badge">
            <span class="saved-dot" id="save-dot"></span>
            <span id="save-label">All changes saved</span>
        </span>

    </div>

    <div class="editor-shell">

        <!-- Toolbar -->
        <div class="cms-toolbar" id="main-toolbar" role="toolbar" aria-label="Formatting toolbar">
            <span class="tb-label">Style</span>
            <select class="tb-select" id="block-select" onchange="applyBlock(this.value)" title="Block style">
                <option value="p">Paragraph</option>
                <option value="h2">Heading 1</option>
                <option value="h3">Heading 2</option>
                <option value="h4">Heading 3</option>
            </select>
            <div class="tb-sep"></div>
            <button class="tb-btn" id="btn-bold" onclick="fmt('bold')" title="Bold (Ctrl+B)"> <i class="ri-bold"></i></button>
            <button class="tb-btn" id="btn-italic" onclick="fmt('italic')" title="Italic (Ctrl+I)"> <i class="ri-italic"></i></button>
            <button class="tb-btn" id="btn-underline" onclick="fmt('underline')" title="Underline (Ctrl+U)"> <i class="ri-underline"></i></button>
            <button class="tb-btn" id="btn-strike" onclick="fmt('strikeThrough')" title="Strikethrough"> <i class="ri-strikethrough"></i></button>
            <div class="tb-sep"></div>
            <button class="tb-btn" id="btn-ul" onclick="doList('ul')" title="Bullet list"> <i class="ri-list-unordered"></i></button>
            <button class="tb-btn" id="btn-ol" onclick="doList('ol')" title="Numbered list"> <i class="ri-list-ordered"></i></button>
            <button class="tb-btn" onclick="fmt('indent')" title="Indent"> <i class="ri-indent-increase"></i></button>
            <button class="tb-btn" onclick="fmt('outdent')" title="Outdent"> <i class="ri-indent-decrease"></i></button>
            <div class="tb-sep"></div>
            <button class="tb-btn" onclick="fmt('justifyLeft')" title="Align left"> <i class="ri-align-left"></i></button>
            <button class="tb-btn" onclick="fmt('justifyCenter')" title="Align center"> <i class="ri-align-center"></i></button>
            <button class="tb-btn" onclick="fmt('justifyRight')" title="Align right"> <i class="ri-align-right"></i></button>
            <div class="tb-sep"></div>
            <button class="tb-btn" onclick="doInsertHR()" title="Insert divider"> <i class="ri-separator"></i></button>
            <button class="tb-btn" onclick="doInsertLink()" title="Insert link"> <i class="ri-link"></i></button>
            <button class="tb-btn" onclick="doInsertTable()" title="Insert table"> <i class="ri-table-line"></i></button>
            <div class="tb-sep"></div>
            <button class="tb-btn" onclick="fmt('removeFormat')" title="Clear formatting"> <i class="ri-format-clear"></i></button>
            <div class="tb-sep"></div>
            <button class="tb-btn" onclick="doUndo()" title="Undo (Ctrl+Z)"> <i class="ri-arrow-go-back-line"></i></button>
            <button class="tb-btn" onclick="doRedo()" title="Redo (Ctrl+Y)"> <i class="ri-arrow-go-forward-line"></i></button>
            <div class="tb-sep"></div>
            <button class="tb-btn" id="btn-find" onclick="toggleFind()" title="Find &amp; Replace"> <i class="ri-search-line"></i></button>
            <button class="tb-btn" id="btn-html" onclick="toggleSourceMode()" title="Toggle HTML source"> <i class="ri-code-line"></i></button>
            <button class="tb-btn" id="btn-fs" onclick="toggleFullscreen()" title="Expand editor"> <i class="ri-fullscreen-line"></i></button>
        </div>

        <!-- Find & Replace bar -->
        <div class="find-bar" id="find-bar">
            <i class="ri-search-line" style="color:var(--text4);font-size:.9rem"></i>
            <input type="text" id="find-input" placeholder="Find..." oninput="doFind()" aria-label="Find">
            <input type="text" id="replace-input" placeholder="Replace with..." aria-label="Replace with">
            <button class="btn btn-ghost btn-sm" onclick="doReplace()">Replace all</button>
            <span class="find-count" id="find-count"></span>
            <button class="tb-btn" onclick="toggleFind()"><i class="ri-close-line"></i></button>
        </div>

        <!-- Rich-text editor -->
        <div class="edit-area"
            id="main-editor"
            contenteditable="true"
            spellcheck="true"
            data-ph="Start typing or paste your Terms &amp; Conditions here..."
            oninput="onEdit()"
            onkeydown="handleKey(event)"
            onmouseup="updateToolbarState()"
            onkeyup="updateToolbarState()">{!! $content ?? '' !!}</div>

        <!-- HTML source view -->
        <textarea id="source-area" spellcheck="false" oninput="onSourceEdit()" placeholder="HTML source will appear here..."></textarea>

        <!-- Status bar -->
        <div class="statusbar">
            <div class="stat-grp">
                <span class="stat-item"><i class="ri-text"></i> <span id="wc">0 words</span></span>
                <span class="stat-item"><i class="ri-hashtag"></i> <span id="cc">0 chars</span></span>
                <span class="stat-item"><i class="ri-layout-row-line"></i> <span id="sc">0 sections</span></span>
            </div>
            <span class="stat-item" id="read-time"><i class="ri-time-line"></i> 0 min read</span>
        </div>

        <!-- History strip -->
        <div class="hist-strip">
            <i class="ri-history-line"></i>
            <span id="hist-label">No changes yet</span>
        </div>

    </div><!-- /editor-shell -->

    <!-- Bottom bar -->
    <!-- <div class="bottom-bar">
    <div style="display:flex;gap:6px">
      <button class="btn btn-ghost btn-sm" onclick="copyPlain()"><i class="ri-file-copy-line"></i> Copy text</button>
      <button class="btn btn-ghost btn-sm" style="color:var(--red);border-color:rgba(239,68,68,.3)" onclick="clearAll()"><i class="ri-delete-bin-line"></i> Clear</button>
    </div>
    <div style="display:flex;gap:6px">
      <a href="{{ url('terms') }}" target="_blank" class="btn btn-ghost btn-sm"><i class="ri-eye-line"></i> Preview</a>
      <button class="btn btn-primary btn-sm" onclick="savePage()"><i class="ri-save-line"></i> Save &amp; Publish</button>
    </div>
  </div> -->

</div>

<script>
    (function() {

        /* ─────────────────────────────────────────────
           REFS
        ───────────────────────────────────────────── */
        var editor = document.getElementById('main-editor');
        var sourceArea = document.getElementById('source-area');
        var toolbar = document.getElementById('main-toolbar');

        var editTimer;
        var isFullscreen = false;
        var isSourceMode = false;
        var savedRange = null;

        /* ─────────────────────────────────────────────
           SOURCE / WYSIWYG TOGGLE
           Click HTML button:
             WYSIWYG → source:  copy innerHTML into textarea, hide editor, show textarea
             source → WYSIWYG:  copy textarea back into editor, show editor, hide textarea
        ───────────────────────────────────────────── */
        function toggleSourceMode() {
            isSourceMode = !isSourceMode;
            var btn = document.getElementById('btn-html');

            if (isSourceMode) {
                /* going to source view */
                sourceArea.value = editor.innerHTML;
                editor.classList.add('hidden');
                sourceArea.classList.add('active');
                btn.classList.add('on');
                /* disable formatting toolbar buttons while in source mode */
                toolbar.querySelectorAll('.tb-btn:not(#btn-html):not(#btn-fs):not(#btn-find)').forEach(function(b) {
                    b.disabled = true;
                    b.style.opacity = '.35';
                });
                toolbar.querySelectorAll('.tb-select').forEach(function(s) {
                    s.disabled = true;
                    s.style.opacity = '.35';
                });
            } else {
                /* going back to rich-text view */
                editor.innerHTML = sourceArea.value;
                sourceArea.classList.remove('active');
                editor.classList.remove('hidden');
                btn.classList.remove('on');
                toolbar.querySelectorAll('.tb-btn').forEach(function(b) {
                    b.disabled = false;
                    b.style.opacity = '';
                });
                toolbar.querySelectorAll('.tb-select').forEach(function(s) {
                    s.disabled = false;
                    s.style.opacity = '';
                });
                onEdit();
                editor.focus();
            }
        }

        /* keep source textarea in sync with editor stats */
        function onSourceEdit() {
            onEdit();
        }

        /* ─────────────────────────────────────────────
           RANGE SAVE / RESTORE
           Needed because prompt() / focus shifts steal the selection
        ───────────────────────────────────────────── */
        function saveRange() {
            var sel = window.getSelection();
            if (sel && sel.rangeCount) savedRange = sel.getRangeAt(0).cloneRange();
        }

        function restoreRange() {
            if (!savedRange) return;
            editor.focus();
            var sel = window.getSelection();
            sel.removeAllRanges();
            sel.addRange(savedRange);
        }

        /* ─────────────────────────────────────────────
           CORE FORMATTER  (bold / italic / underline …)
        ───────────────────────────────────────────── */
        function fmt(cmd) {
            if (isSourceMode) return;
            editor.focus();
            document.execCommand(cmd, false, null);
            updateToolbarState();
            onEdit();
        }

        /* ─────────────────────────────────────────────
           HEADING / BLOCK STYLE
        ───────────────────────────────────────────── */
        function applyBlock(tag) {
            if (isSourceMode) return;
            editor.focus();

            /* execCommand formatBlock is the standard way */
            var ok = document.execCommand('formatBlock', false, tag);

            /* Firefox / some Chromium builds need angle brackets */
            if (!ok) document.execCommand('formatBlock', false, '<' + tag + '>');

            setTimeout(syncBlockSelect, 30);
            updateToolbarState();
            onEdit();
        }

        function syncBlockSelect() {
            var sel = window.getSelection();
            if (!sel || !sel.rangeCount) return;
            var node = sel.getRangeAt(0).startContainer;
            while (node && node !== editor) {
                var n = node.nodeName && node.nodeName.toLowerCase();
                if (['h2', 'h3', 'h4', 'p'].indexOf(n) !== -1) {
                    document.getElementById('block-select').value = n;
                    return;
                }
                node = node.parentNode;
            }
            document.getElementById('block-select').value = 'p';
        }

        /* ─────────────────────────────────────────────
           LISTS
           We build the list HTML manually to guarantee
           correct list-item display in all browsers.
        ───────────────────────────────────────────── */
        function doList(type) {
            if (isSourceMode) return;
            editor.focus();

            var cmd = type === 'ul' ? 'insertUnorderedList' : 'insertOrderedList';

            /* Check if caret is already inside this list type → toggle off */
            var sel = window.getSelection();
            var node = sel && sel.rangeCount ? sel.getRangeAt(0).startContainer : null;
            while (node && node !== editor) {
                if (node.nodeName === (type === 'ul' ? 'UL' : 'OL')) {
                    document.execCommand(cmd, false, null);
                    fixListItems();
                    updateToolbarState();
                    onEdit();
                    return;
                }
                node = node.parentNode;
            }

            /* Not in a list: create one */
            document.execCommand(cmd, false, null);
            fixListItems();
            updateToolbarState();
            onEdit();
        }

        function fixListItems() {
            /* Force display:list-item in case the browser strips it */
            setTimeout(function() {
                editor.querySelectorAll('li').forEach(function(li) {
                    li.style.display = 'list-item';
                });
            }, 0);
        }

        /* ─────────────────────────────────────────────
           UNDO / REDO
        ───────────────────────────────────────────── */
        function doUndo() {
            if (!isSourceMode) {
                editor.focus();
                document.execCommand('undo');
                onEdit();
            }
        }

        function doRedo() {
            if (!isSourceMode) {
                editor.focus();
                document.execCommand('redo');
                onEdit();
            }
        }

        /* ─────────────────────────────────────────────
           INSERT HELPERS
        ───────────────────────────────────────────── */
        function doInsertHR() {
            if (isSourceMode) return;
            editor.focus();
            document.execCommand('insertHTML', false, '<hr>');
            onEdit();
        }

        function doInsertLink() {
            if (isSourceMode) return;
            saveRange();
            var sel = window.getSelection();
            var txt = sel ? sel.toString() : '';
            var url = prompt('Enter URL:', 'https://');
            if (!url || url === 'https://') return;
            restoreRange();
            if (txt) {
                document.execCommand('createLink', false, url);
            } else {
                document.execCommand('insertHTML', false, '<a href="' + url + '">' + url + '</a>');
            }
            onEdit();
        }

        function doInsertTable() {
            if (isSourceMode) return;
            saveRange();
            var rows = parseInt(prompt('Number of rows:', '3')) || 3;
            var cols = parseInt(prompt('Number of columns:', '3')) || 3;
            restoreRange();
            var html = '<table style="border-collapse:collapse;width:100%;margin:10px 0">';
            for (var r = 0; r < rows; r++) {
                html += '<tr>';
                for (var c = 0; c < cols; c++) {
                    var tag = r === 0 ? 'th' : 'td';
                    html += '<' + tag + ' style="border:1px solid var(--border);padding:8px 12px;text-align:left">' + (r === 0 ? 'Header ' + (c + 1) : 'Cell') + '</' + tag + '>';
                }
                html += '</tr>';
            }
            html += '</table><p><br></p>';
            document.execCommand('insertHTML', false, html);
            onEdit();
        }

        /* ─────────────────────────────────────────────
           FIND & REPLACE
        ───────────────────────────────────────────── */
        function toggleFind() {
            var bar = document.getElementById('find-bar');
            var btn = document.getElementById('btn-find');
            var show = bar.classList.toggle('show');
            btn.classList.toggle('on', show);
            if (show) setTimeout(function() {
                document.getElementById('find-input').focus();
            }, 50);
        }

        function doFind() {
            var q = document.getElementById('find-input').value;
            var cnt = document.getElementById('find-count');
            if (!q) {
                cnt.textContent = '';
                return;
            }
            var re = new RegExp(q.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'gi');
            var m = (editor.innerText.match(re) || []).length;
            cnt.textContent = m + ' found';
        }

        function doReplace() {
            var f = document.getElementById('find-input').value;
            var r = document.getElementById('replace-input').value;
            if (!f) return;
            var re = new RegExp(f.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'gi');
            var count = (editor.innerHTML.match(re) || []).length;
            editor.innerHTML = editor.innerHTML.replace(re, r);
            onEdit();
            showToast('Replaced ' + count + ' instance' + (count !== 1 ? 's' : ''));
            document.getElementById('find-count').textContent = '';
        }

        /* ─────────────────────────────────────────────
           FULLSCREEN
        ───────────────────────────────────────────── */
        function toggleFullscreen() {
            isFullscreen = !isFullscreen;
            var btn = document.getElementById('btn-fs');
            var h = isFullscreen ? '70vh' : '460px';
            editor.style.minHeight = h;
            sourceArea.style.minHeight = h;
            btn.innerHTML = isFullscreen ?
                '<i class="ri-fullscreen-exit-line"></i>' :
                '<i class="ri-fullscreen-line"></i>';
            btn.classList.toggle('on', isFullscreen);
        }

        /* ─────────────────────────────────────────────
           TOOLBAR STATE SYNC
        ───────────────────────────────────────────── */
        function updateToolbarState() {
            if (isSourceMode) return;
            [
                ['bold', 'btn-bold'],
                ['italic', 'btn-italic'],
                ['underline', 'btn-underline'],
                ['strikeThrough', 'btn-strike'],
                ['insertUnorderedList', 'btn-ul'],
                ['insertOrderedList', 'btn-ol']
            ].forEach(function(pair) {
                var el = document.getElementById(pair[1]);
                if (el) el.classList.toggle('on', document.queryCommandState(pair[0]));
            });
            syncBlockSelect();
        }

        /* ─────────────────────────────────────────────
           STATS + AUTO-SAVE
        ───────────────────────────────────────────── */
        function onEdit() {
            clearTimeout(editTimer);

            var text = isSourceMode ?
                (function() {
                    var d = document.createElement('div');
                    d.innerHTML = sourceArea.value;
                    return d.innerText || '';
                })() :
                (editor.innerText || '');

            var words = text.trim() ? text.trim().split(/\s+/).length : 0;
            var chars = text.replace(/\s/g, '').length;
            var sections = isSourceMode ?
                (sourceArea.value.match(/<h[234]/gi) || []).length :
                editor.querySelectorAll('h2,h3,h4').length;
            var readMin = Math.max(1, Math.round(words / 200));

            document.getElementById('wc').textContent = words.toLocaleString() + ' words';
            document.getElementById('cc').textContent = chars.toLocaleString() + ' chars';
            document.getElementById('sc').textContent = sections + ' sections';
            document.getElementById('read-time').innerHTML = '<i class="ri-time-line"></i> ' + readMin + ' min read';

            var now = new Date();
            var ts = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0') + ':' + now.getSeconds().toString().padStart(2, '0');
            document.getElementById('hist-label').textContent = 'Last edited at ' + ts + ' — ' + words.toLocaleString() + ' words';

            document.getElementById('save-dot').className = 'unsaved-dot';
            document.getElementById('save-label').textContent = 'Unsaved changes';

            editTimer = setTimeout(autoSave, 2500);
        }

        function autoSave() {
    document.getElementById('save-dot').className = 'saved-dot';
    document.getElementById('save-label').textContent = 'Draft saved';
}

        // function savePage(){
        //   /* If in source mode, flush to editor first */
        //   if(isSourceMode){ editor.innerHTML = sourceArea.value; }
        //   autoSave();
        //   document.getElementById('save-dot').className    = 'saved-dot';
        //   document.getElementById('save-label').textContent = 'All changes saved';
        //   showToast('Terms & Conditions saved & published!');
        // }

        /* ─────────────────────────────────────────────
           COPY / CLEAR
        ───────────────────────────────────────────── */
        function copyPlain() {
            var txt = isSourceMode ? sourceArea.value : editor.innerText;
            navigator.clipboard.writeText(txt).then(function() {
                showToast('Copied to clipboard');
            });
        }

        function clearAll() {
            if (!confirm('Clear all content? This cannot be undone.')) return;
            editor.innerHTML = '';
            sourceArea.value = '';
            onEdit();
            showToast('Content cleared');
        }

        /* ─────────────────────────────────────────────
           TOAST
        ───────────────────────────────────────────── */
        function showToast(msg) {
            var t = document.getElementById('cms-toast');
            document.getElementById('cms-toast-msg').textContent = msg;
            t.classList.add('show');
            setTimeout(function() {
                t.classList.remove('show');
            }, 2600);
        }

        /* ─────────────────────────────────────────────
           KEYBOARD SHORTCUTS
        ───────────────────────────────────────────── */
        function handleKey(e) {
            var ctrl = e.ctrlKey || e.metaKey;
            if (ctrl && e.key === 's') {
                e.preventDefault();
                savePage();
                return;
            }
            if (ctrl && e.key === 'f') {
                e.preventDefault();
                toggleFind();
                return;
            }
            if (ctrl && e.key === 'z') {
                e.preventDefault();
                doUndo();
                return;
            }
            if (ctrl && e.key === 'y') {
                e.preventDefault();
                doRedo();
                return;
            }
            if (e.key === 'Tab') {
                e.preventDefault();
                document.execCommand('insertHTML', false, '&nbsp;&nbsp;&nbsp;&nbsp;');
            }
        }

        function savePage() {

            let html = isSourceMode ?
                sourceArea.value :
                editor.innerHTML;

            fetch("{{ route('terms-condition.save') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({
                        content: html
                    })
                })
                .then(response => response.json())
                .then(res => {
                    document.getElementById('save-dot').className = 'saved-dot';
                    document.getElementById('save-label').textContent = 'All changes saved';

                    showToast(res.message);
                })
                .catch(error => {
                    console.error(error);
                    showToast('Failed to save policy');
                });
        }

        /* ─────────────────────────────────────────────
           PASTE  — strip Word / browser cruft
        ───────────────────────────────────────────── */
        editor.addEventListener('paste', function(e) {
            e.preventDefault();
            var html = e.clipboardData.getData('text/html');
            if (html) {
                var tmp = document.createElement('div');
                tmp.innerHTML = html;
                tmp.querySelectorAll('script,style,meta,link,xml').forEach(function(n) {
                    n.remove();
                });
                tmp.querySelectorAll('[class]').forEach(function(n) {
                    if (/^(Mso|mso)/i.test(n.className)) n.removeAttribute('class');
                });
                document.execCommand('insertHTML', false, tmp.innerHTML);
            } else {
                var lines = (e.clipboardData.getData('text/plain') || '').split(/\n/);
                document.execCommand('insertHTML', false, lines.map(function(l) {
                    return '<p>' + (l || '<br>') + '</p>';
                }).join(''));
            }
            onEdit();
        });

        /* ─────────────────────────────────────────────
           INIT
        ───────────────────────────────────────────── */
       (function init() {
    onEdit();

    editor.addEventListener('mouseup', updateToolbarState);
    editor.addEventListener('keyup', updateToolbarState);
})();

        /* expose globals needed by inline onclick="" */
        window.toggleSourceMode = toggleSourceMode;
        window.applyBlock = applyBlock;
        window.fmt = fmt;
        window.doList = doList;
        window.doUndo = doUndo;
        window.doRedo = doRedo;
        window.doInsertHR = doInsertHR;
        window.doInsertLink = doInsertLink;
        window.doInsertTable = doInsertTable;
        window.toggleFind = toggleFind;
        window.doFind = doFind;
        window.doReplace = doReplace;
        window.toggleFullscreen = toggleFullscreen;
        window.updateToolbarState = updateToolbarState;
        window.handleKey = handleKey;
        window.onEdit = onEdit;
        window.onSourceEdit = onSourceEdit;
        window.savePage = savePage;
        window.copyPlain = copyPlain;
        window.clearAll = clearAll;

    })();
</script>

@endsection