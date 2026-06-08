@extends('admin.layouts.app')
@section('content')

<style>
.cms-tab-btn{padding:10px 18px;background:transparent;border:none;color:var(--text3);font-size:.8rem;font-weight:600;cursor:pointer;border-bottom:2px solid transparent;transition:all .2s;display:flex;align-items:center;gap:6px}
.cms-tab-btn:hover{color:var(--text2)}.cms-tab-btn.active{color:var(--purple);border-bottom-color:var(--purple)}
.cms-tab-content{display:none}.cms-tab-content.active{display:block}
.field-group{margin-bottom:16px}
.field-group .label{margin-bottom:6px;display:block;font-size:.75rem;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em}
.inp-area{width:100%;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:10px 14px;color:var(--text);font-size:.85rem;resize:vertical;font-family:inherit;transition:border-color .2s}
.inp-area:focus{outline:none;border-color:var(--purple)}
.section-card{background:var(--card);border:1px solid var(--border);border-radius:var(--radius);padding:20px;margin-bottom:14px}
.char-count{font-size:.68rem;color:var(--text4);text-align:right;margin-top:4px}.char-count.warn{color:var(--amber)}.char-count.bad{color:var(--red)}
.toggle-switch{position:relative;width:40px;height:22px;flex-shrink:0}
.toggle-switch input{opacity:0;width:0;height:0}
.toggle-slider{position:absolute;inset:0;background:var(--ctrl-bg);border-radius:22px;cursor:pointer;transition:.3s}
.toggle-slider::before{content:'';position:absolute;width:16px;height:16px;left:3px;top:3px;background:var(--text);border-radius:50%;transition:.3s}
.toggle-switch input:checked+.toggle-slider{background:var(--purple)}
.toggle-switch input:checked+.toggle-slider::before{transform:translateX(18px)}
.editor-toolbar{display:flex;align-items:center;gap:2px;padding:8px 10px;background:var(--bg2);border:1px solid var(--border);border-bottom:none;border-radius:var(--radius-sm) var(--radius-sm) 0 0;flex-wrap:wrap}
.editor-toolbar-btn{width:30px;height:28px;border:none;background:transparent;color:var(--text3);border-radius:var(--radius-xs);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:.85rem;transition:all .2s;flex-shrink:0}
.editor-toolbar-btn:hover{background:var(--ctrl-bg);color:var(--text)}
.editor-toolbar-btn.active{background:rgba(124,58,237,.15);color:var(--purple-light)}
.editor-toolbar-sep{width:1px;height:18px;background:var(--border);margin:0 4px;flex-shrink:0}
.editor-toolbar-select{background:var(--ctrl-bg);border:1px solid var(--border);border-radius:var(--radius-xs);color:var(--text3);font-size:.75rem;padding:4px 8px;cursor:pointer;height:28px}
.editor-body{width:100%;min-height:360px;background:var(--surface2);border:1px solid var(--border);border-radius:0 0 var(--radius-sm) var(--radius-sm);padding:16px;color:var(--text);font-size:.9rem;line-height:1.8;outline:none;font-family:inherit}
.editor-body:focus{border-color:var(--purple)}
.editor-body[contenteditable] h2{font-size:1.4rem;font-weight:800;color:var(--text);margin:24px 0 12px}
.editor-body[contenteditable] h3{font-size:1.15rem;font-weight:700;color:var(--text2);margin:20px 0 10px}
.editor-body[contenteditable] blockquote{border-left:3px solid var(--purple);padding-left:16px;margin:16px 0;color:var(--text3);font-style:italic}
.editor-body[contenteditable] ul{padding-left:20px}
.editor-body[contenteditable] a{color:var(--purple-light)}
.upload-zone{border:2px dashed var(--border);border-radius:12px;padding:28px;text-align:center;cursor:pointer;transition:all .3s;position:relative}
.upload-zone:hover,.upload-zone.drag-over{border-color:var(--purple);background:rgba(124,58,237,.05)}
.upload-zone input[type=file]{position:absolute;inset:0;opacity:0;width:100%;height:100%;pointer-events:none}
.word-count-bar{display:flex;align-items:center;justify-content:space-between;padding:8px 12px;background:var(--bg2);border:1px solid var(--border2);border-radius:0 0 var(--radius-sm) var(--radius-sm);margin-top:-1px}
.seo-mini{display:flex;align-items:center;gap:8px;padding:10px 14px;border-radius:var(--radius-sm);border:1px solid rgba(16,185,129,.15);background:rgba(16,185,129,.05);margin-bottom:14px}
.read-estimate{display:inline-flex;align-items:center;gap:5px;font-size:.75rem;color:var(--text4);background:var(--row-bg);padding:4px 10px;border-radius:100px;border:1px solid var(--border2)}
.serp-preview{background:var(--bg2);border:1px solid var(--border);border-radius:12px;padding:14px}
.serp-breadcrumb{font-size:.62rem;color:var(--text4);margin-bottom:3px}
.serp-title{font-size:.9rem;color:#8ab4f8;font-weight:500;margin-bottom:4px;line-height:1.4}
.serp-desc{font-size:.75rem;color:var(--text3);line-height:1.6}
.status-row{display:flex;align-items:center;gap:10px;padding:12px 14px;border-radius:var(--radius-sm);border:1px solid var(--border);background:var(--bg2)}
.blog-edit-grid{display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start}
@media(max-width:900px){.blog-edit-grid{grid-template-columns:1fr}}
.blog-sidebar{position:sticky;top:90px;display:flex;flex-direction:column;gap:14px}
@media(max-width:900px){.blog-sidebar{position:static}}
</style>

<!-- Header -->
<div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px">
    <div style="display:flex;align-items:center;gap:12px">
        <a href="{{ route('admin.blog.index') }}" class="btn btn-ghost btn-sm"><i class="ri-arrow-left-line"></i></a>
        <div>
            <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800">Edit Blog Post</h2>
            <p style="font-size:.8rem;color:var(--text3);margin-top:3px">Update and republish your article</p>
        </div>
    </div>
</div>

<div class="blog-edit-grid">

    <!-- LEFT — Main Content -->
    <div>

        <div style="display:none;gap:4px;margin-bottom:16px;border-bottom:2px solid rgba(255,255,255,.05)">
            <button type="button" class="cms-tab-btn active" onclick="switchTab('content')" id="tab-btn-content"><i class="ri-article-line"></i> Content</button>
            <button type="button" class="cms-tab-btn" onclick="switchTab('seo')" id="tab-btn-seo"><i class="ri-search-eye-line"></i> SEO</button>
        </div>

        <!-- CONTENT TAB -->
        <div class="cms-tab-content active" id="tab-content">

            <div class="field-group">
                <label class="label">Post Title <span style="color:var(--red)">*</span></label>
                <input class="inp" id="post-title" name="title" placeholder="Write a compelling title…"
                       style="font-size:1rem;font-weight:700" oninput="syncTitle()" required
                       value="{{ old('title', $post->title) }}">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-top:4px">
                    <div class="char-count" id="tc-title">{{ strlen($post->title) }}/80</div>
                    
                </div>
            </div>

            <div class="field-group">
                <label class="label">Excerpt / Summary</label>
                <textarea class="inp-area inp" id="post-excerpt" name="excerpt" rows="3"
                          placeholder="Brief summary shown on blog listing page…"
                          oninput="cc('post-excerpt','tc-excerpt',200)">{{ old('excerpt', $post->excerpt) }}</textarea>
                <div class="char-count" id="tc-excerpt">{{ strlen($post->excerpt) }}/200</div>
            </div>

            <div class="field-group">
                <label class="label">Article Body <span style="color:var(--red)">*</span></label>
                <div class="editor-toolbar">
                    <select class="editor-toolbar-select" onchange="formatBlock(this.value)">
                        <option value="p">Paragraph</option>
                        <option value="h2">Heading 2</option>
                        <option value="h3">Heading 3</option>
                        <option value="h4">Heading 4</option>
                        <option value="blockquote">Blockquote</option>
                        <option value="pre">Code Block</option>
                    </select>
                    <div class="editor-toolbar-sep"></div>
                    <button type="button" class="editor-toolbar-btn" onclick="fmt('bold')" title="Bold"><i class="ri-bold"></i></button>
                    <button type="button" class="editor-toolbar-btn" onclick="fmt('italic')" title="Italic"><i class="ri-italic"></i></button>
                    <button type="button" class="editor-toolbar-btn" onclick="fmt('underline')" title="Underline"><i class="ri-underline"></i></button>
                    <button type="button" class="editor-toolbar-btn" onclick="fmt('strikeThrough')" title="Strikethrough"><i class="ri-strikethrough"></i></button>
                    <div class="editor-toolbar-sep"></div>
                    <button type="button" class="editor-toolbar-btn" onclick="fmt('insertUnorderedList')" title="Bullet List"><i class="ri-list-unordered"></i></button>
                    <button type="button" class="editor-toolbar-btn" onclick="fmt('insertOrderedList')" title="Numbered List"><i class="ri-list-ordered"></i></button>
                    <div class="editor-toolbar-sep"></div>
                    <button type="button" class="editor-toolbar-btn" onclick="insertLink()" title="Insert Link"><i class="ri-link"></i></button>
                    <button type="button" class="editor-toolbar-btn" onclick="insertImage()" title="Insert Image"><i class="ri-image-line"></i></button>
                    <div class="editor-toolbar-sep"></div>
                    <button type="button" class="editor-toolbar-btn" onclick="fmt('justifyLeft')" title="Align Left"><i class="ri-align-left"></i></button>
                    <button type="button" class="editor-toolbar-btn" onclick="fmt('justifyCenter')" title="Align Center"><i class="ri-align-center"></i></button>
                    <button type="button" class="editor-toolbar-btn" onclick="fmt('justifyRight')" title="Align Right"><i class="ri-align-right"></i></button>
                    <div class="editor-toolbar-sep"></div>
                    <button type="button" class="editor-toolbar-btn" onclick="fmt('undo')" title="Undo"><i class="ri-arrow-go-back-line"></i></button>
                    <button type="button" class="editor-toolbar-btn" onclick="fmt('redo')" title="Redo"><i class="ri-arrow-go-forward-line"></i></button>
                    <div class="editor-toolbar-sep"></div>
                    <button type="button" class="editor-toolbar-btn" onclick="toggleSourceMode()" title="HTML Source" id="source-btn"><i class="ri-code-view"></i></button>
                </div>
                <div class="editor-body" id="editor-body" contenteditable="true" oninput="updateWordCount()">
                    {!! old('content', $post->content) !!}
                </div>
                <textarea class="inp-area inp" id="editor-source" style="display:none;font-family:monospace;font-size:.78rem;min-height:300px;border-radius:0 0 10px 10px;border-top:none" rows="16"></textarea>
                <input type="hidden" name="content" id="post-content">
                <div class="word-count-bar">
                    <span style="font-size:.72rem;color:var(--text4)"><i class="ri-file-text-line"></i> <span id="word-count">0</span> words · <span id="char-count-body">0</span> characters</span>
                    <span style="font-size:.72rem;color:var(--text4)">Approx. <span id="read-min">0</span> min read</span>
                </div>
            </div>

            <div class="section-card">
                <div class="section-title" style="margin-bottom:14px"><i class="ri-image-line"></i> Featured Image</div>
                <div class="upload-zone" id="upload-zone" onclick="triggerUpload()">
                    <input type="file" name="featured_image" id="img-upload" accept="image/*" onchange="handleImageUpload(this)">
                    <input type="hidden" name="remove_image" id="remove-image-flag" value="0">
                    <div id="upload-placeholder" style="{{ $post->featured_image ? 'display:none' : '' }}">
                        <i class="ri-image-add-line" style="font-size:2rem;color:var(--text4);margin-bottom:8px;display:block"></i>
                        <div style="font-size:.85rem;font-weight:600;color:var(--text3);margin-bottom:4px">Drop image here or click to browse</div>
                        <div style="font-size:.72rem;color:var(--text4)">Recommended: 1200 × 630px · JPG, PNG, WebP · Max 5MB</div>
                    </div>

                    <div id="upload-preview" style="{{ $post->featured_image ? '' : 'display:none' }}">
                        <img id="img-preview" src="{{ $post->featured_image ? asset($post->featured_image) : '' }}"
                             style="max-height:180px;border-radius:8px;margin-bottom:10px;{{ $post->featured_image ? '' : 'display:none' }}">
                        <div id="img-name" style="font-size:.78rem;color:var(--text3)">
                            {{ $post->featured_image ? basename($post->featured_image) : '' }}
                        </div>
                        <button type="button" onclick="clearImage(event)" class="btn btn-danger btn-sm" style="margin-top:8px">
                            <i class="ri-delete-bin-line"></i> Remove
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <!-- SEO TAB -->
        <div class="cms-tab-content" id="tab-seo">
            <div class="seo-mini">
                <div style="width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:800;color:var(--green);background:conic-gradient(var(--green) 0% 0%,rgba(255,255,255,.08) 0%);flex-shrink:0" id="seo-circle">0</div>
                <div><div style="font-size:.85rem;font-weight:700;color:var(--text)" id="seo-score-label">No SEO data yet</div><div style="font-size:.75rem;color:var(--text3)">Fill in the fields below to improve your score</div></div>
            </div>

            <div class="section-card">
                <div class="section-title" style="margin-bottom:14px"><i class="ri-file-text-line"></i> Meta Tags</div>
                <div class="field-group">
                    <label class="label">SEO Title <span style="color:var(--text4);font-weight:400;text-transform:none;font-size:.72rem">(defaults to post title if empty)</span></label>
                    <input class="inp" name="seo_title" id="seo-title" placeholder="SEO-optimised title…"
                           value="{{ old('seo_title', $post->seo_title) }}"
                           oninput="cc('seo-title','tc-seo-title',60);updateSerp()">
                    <div class="char-count" id="tc-seo-title">{{ strlen($post->seo_title ?? '') }}/60</div>
                </div>
                <div class="field-group">
                    <label class="label">Meta Description <span style="color:var(--red)">*</span></label>
                    <textarea class="inp-area inp" name="meta_description" id="meta-desc" rows="3"
                              placeholder="Compelling description for search results…"
                              oninput="cc('meta-desc','tc-meta-desc',160);updateSerp()">{{ old('meta_description', $post->meta_description) }}</textarea>
                    <div class="char-count" id="tc-meta-desc">{{ strlen($post->meta_description ?? '') }}/160</div>
                </div>
                <div class="g2">
                    <div class="field-group">
                        <label class="label">Focus Keyword</label>
                        <input class="inp" name="focus_keyword" id="focus-kw" placeholder="Primary keyword"
                               value="{{ old('focus_keyword', $post->focus_keyword) }}" oninput="calcSeoScore()">
                    </div>
                    <div class="field-group">
                        <label class="label">Secondary Keywords</label>
                        <input class="inp" name="keywords" placeholder="keyword1, keyword2, keyword3"
                               value="{{ old('keywords', $post->keywords) }}">
                    </div>
                </div>
                <div class="g2">
                    <div class="field-group">
                        <label class="label">Canonical URL</label>
                        <input class="inp" name="canonical" placeholder="https://dremin.co.uk/blog/…"
                               value="{{ old('canonical', $post->canonical) }}">
                    </div>
                    <div class="field-group">
                        <label class="label">Robots</label>
                        <select class="inp" name="robots">
                            @foreach(['index, follow','noindex, follow','index, nofollow','noindex, nofollow'] as $r)
                                <option {{ old('robots', $post->robots) === $r ? 'selected' : '' }}>{{ $r }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="section-card">
                <div class="section-title" style="margin-bottom:14px"><i class="ri-google-line"></i> SERP Preview</div>
                <div class="serp-preview">
                    <div class="serp-breadcrumb">dremin.co.uk › blog › <span id="serp-slug">{{ $post->slug }}</span></div>
                    <div class="serp-title" id="serp-title">{{ $post->seo_title ?: $post->title }}</div>
                    <div class="serp-desc" id="serp-desc">{{ $post->meta_description ?: 'Your meta description will appear here.' }}</div>
                </div>
            </div>

            <div class="section-card">
                <div class="section-title" style="margin-bottom:14px"><i class="ri-checkbox-multiple-line"></i> SEO Checklist</div>
                <div id="seo-checklist" style="display:flex;flex-direction:column;gap:8px">
                    <div class="seo-check-item" data-check="title"><div style="display:flex;align-items:center;gap:8px;font-size:.82rem"><i class="ri-error-warning-line" style="color:var(--amber)"></i> <span style="color:var(--text3)">Post title — not set</span></div></div>
                    <div class="seo-check-item" data-check="metadesc"><div style="display:flex;align-items:center;gap:8px;font-size:.82rem"><i class="ri-error-warning-line" style="color:var(--amber)"></i> <span style="color:var(--text3)">Meta description — not set</span></div></div>
                    <div class="seo-check-item" data-check="keyword"><div style="display:flex;align-items:center;gap:8px;font-size:.82rem"><i class="ri-error-warning-line" style="color:var(--amber)"></i> <span style="color:var(--text3)">Focus keyword — not set</span></div></div>
                    <div class="seo-check-item" data-check="image"><div style="display:flex;align-items:center;gap:8px;font-size:.82rem"><i class="ri-error-warning-line" style="color:var(--amber)"></i> <span style="color:var(--text3)">Featured image — not set</span></div></div>
                    <div class="seo-check-item" data-check="content"><div style="display:flex;align-items:center;gap:8px;font-size:.82rem"><i class="ri-error-warning-line" style="color:var(--amber)"></i> <span style="color:var(--text3)">Content length — under 300 words</span></div></div>
                </div>
            </div>
        </div>

    </div>

    <!-- RIGHT — Sidebar -->
    <div class="blog-sidebar">
        <div class="section-card" style="margin:0">
            <div class="section-title" style="margin-bottom:14px"><i class="ri-save-line" style="color:var(--purple)"></i> Update Post</div>

            <div class="status-row" style="margin-bottom:14px">
                <label class="toggle-switch">
                    <input type="checkbox" name="is_active" id="status-toggle"
                           {{ $post->is_active ? 'checked' : '' }} onchange="syncStatusLabel()">
                    <span class="toggle-slider"></span>
                </label>
                <div>
                    <div style="font-size:.85rem;font-weight:700;color:var(--text)" id="status-label-text">
                        {{ $post->is_active ? 'Active' : 'Inactive' }}
                    </div>
                    <div style="font-size:.72rem;color:var(--text4)" id="status-sub-text">
                        {{ $post->is_active ? 'Post is visible to the public' : 'Post is hidden from the public' }}
                    </div>
                </div>
            </div>

            <div class="field-group">
                <label class="label">Category <span style="color:var(--red)">*</span></label>
                <select class="inp" name="category" id="post-category" required>
                    <option value="">Select category</option>
                    @foreach(['savings' => 'Savings', 'tips' => 'Tips & Tricks', 'guide' => 'Guides', 'news' => 'News', 'finance' => 'Finance'] as $val => $label)
                        <option value="{{ $val }}" {{ old('category', $post->category) === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <button type="button" class="btn btn-primary" style="width:100%;justify-content:center" onclick="submitPost()">
                <i class="ri-save-line"></i> Update Post
            </button>
        </div>
    </div>

</div>

<!-- Validation Error Modal -->
<div id="error-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.6);z-index:9999;align-items:center;justify-content:center">
    <div style="background:var(--card);border:1px solid var(--border);border-radius:var(--radius);padding:24px;width:100%;max-width:440px;margin:0 16px">
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px">
            <i class="ri-error-warning-line" style="font-size:1.4rem;color:var(--red)"></i>
            <h3 style="font-size:1rem;font-weight:800">Please fix the following errors</h3>
        </div>
        <ul id="error-list" style="padding-left:18px;display:flex;flex-direction:column;gap:6px;font-size:.83rem;color:var(--text3)"></ul>
        <button onclick="document.getElementById('error-modal').style.display='none'" class="btn btn-ghost btn-sm" style="margin-top:18px;width:100%;justify-content:center">Close</button>
    </div>
</div>

<script>
// Attach everything to window so inline onclick handlers can find them
window.submitPost = function() {
    document.getElementById('post-content').value = document.getElementById('editor-body').innerHTML;

    var form = new FormData();
    form.append('_token',          '{{ csrf_token() }}');
    form.append('title',           document.getElementById('post-title').value);
    form.append('excerpt',         document.getElementById('post-excerpt').value);
    form.append('content',         document.getElementById('post-content').value);
    form.append('category',        document.getElementById('post-category').value);
    form.append('is_active',       document.getElementById('status-toggle').checked ? '1' : '0');
    form.append('seo_title',       document.getElementById('seo-title').value);
    form.append('meta_description',document.getElementById('meta-desc').value);
    form.append('focus_keyword',   document.getElementById('focus-kw').value);
    form.append('keywords',        document.querySelector('[name="keywords"]').value);
    form.append('canonical',       document.querySelector('[name="canonical"]').value);
    form.append('robots',          document.querySelector('[name="robots"]').value);
    form.append('remove_image', document.getElementById('remove-image-flag').value);

    var imgFile = document.getElementById('img-upload').files[0];
    if (imgFile) form.append('featured_image', imgFile);

    fetch('{{ route("admin.blog.update", $post->id) }}', {
        method: 'POST',
        headers: { 'Accept': 'application/json' },
        body: form
    })
    .then(r => r.json().then(data => ({ status: r.status, data })))
    .then(function({ status, data }) {
        if (status === 422) {
            var list = document.getElementById('error-list');
            list.innerHTML = '';
            Object.values(data.errors).forEach(function(msgs) {
                msgs.forEach(function(msg) {
                    var li = document.createElement('li');
                    li.textContent = msg;
                    list.appendChild(li);
                });
            });
            document.getElementById('error-modal').style.display = 'flex';
        } else if (data.success) {
            if (typeof toast === 'function') toast(data.message, 'success');
            setTimeout(function() { window.location.href = '{{ route("admin.blog.index") }}'; }, 1000);
        }
    })
    .catch(function() { if (typeof toast === 'function') toast('Something went wrong.', 'error'); });
};

window.triggerUpload = function() { document.getElementById('img-upload').click(); };

window.clearImage = function(e) {
    e.stopPropagation();
    document.getElementById('img-upload').value = '';
    document.getElementById('remove-image-flag').value = '1'; // mark as removed
    document.getElementById('upload-placeholder').style.display = 'block';
    document.getElementById('upload-preview').style.display = 'none';
    document.getElementById('img-preview').src = '';
    updateSeoChecks();
};

window.handleImageUpload = function(input) {
    if (!input.files || !input.files[0]) return;
    document.getElementById('remove-image-flag').value = '0'; // new image picked, cancel removal
    var file = input.files[0];
    var reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('img-preview').src = e.target.result;
        document.getElementById('img-preview').style.display = 'block';
        document.getElementById('img-name').textContent = file.name + ' (' + Math.round(file.size / 1024) + 'KB)';
        document.getElementById('upload-placeholder').style.display = 'none';
        document.getElementById('upload-preview').style.display = 'block';
        updateSeoChecks();
    };
    reader.readAsDataURL(file);
};

window.switchTab = function(t) {
    document.querySelectorAll('.cms-tab-content').forEach(c => c.classList.remove('active'));
    document.querySelectorAll('.cms-tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + t).classList.add('active');
    document.getElementById('tab-btn-' + t).classList.add('active');
};

window.fmt = function(cmd) { document.execCommand(cmd, false, null); };
window.formatBlock = function(tag) { document.execCommand('formatBlock', false, tag); };
window.insertLink = function() { var url = prompt('Enter URL:'); if (url) document.execCommand('createLink', false, url); };
window.insertImage = function() { var url = prompt('Enter image URL:'); if (url) document.execCommand('insertImage', false, url); };

window.syncStatusLabel = function() {
    var on = document.getElementById('status-toggle').checked;
    document.getElementById('status-label-text').textContent = on ? 'Active' : 'Inactive';
    document.getElementById('status-sub-text').textContent = on ? 'Post is visible to the public' : 'Post is hidden from the public';
};

window.syncTitle = function() {
    var title = document.getElementById('post-title').value;
    cc('post-title', 'tc-title', 80);
    document.getElementById('serp-title').textContent = document.getElementById('seo-title').value || title || 'Your post title will appear here';
    updateSeoChecks();
};

window.updateSerp = function() {
    var title = document.getElementById('seo-title').value || document.getElementById('post-title').value;
    var desc  = document.getElementById('meta-desc').value;
    document.getElementById('serp-title').textContent = title || 'Your post title will appear here';
    document.getElementById('serp-desc').textContent  = desc  || 'Your meta description will appear here.';
};

window.calcSeoScore = function() {
    var score = 0;
    if (document.getElementById('post-title').value.length > 10) score += 25;
    if (document.getElementById('meta-desc').value.length > 50)  score += 25;
    if (document.getElementById('focus-kw').value.length > 2)    score += 25;
    var wc = parseInt(document.getElementById('word-count').textContent) || 0;
    if (wc > 300) score += 25;
    var circle = document.getElementById('seo-circle');
    var label  = document.getElementById('seo-score-label');
    if (circle) {
        circle.textContent = score;
        circle.style.background = 'conic-gradient(' + (score >= 80 ? 'var(--green)' : score >= 50 ? 'var(--amber)' : 'var(--red)') + ' 0% ' + score + '%,rgba(255,255,255,.08) ' + score + '%)';
        circle.style.color = score >= 80 ? 'var(--green)' : score >= 50 ? 'var(--amber)' : 'var(--red)';
    }
    if (label) label.textContent = score >= 80 ? 'Good SEO Score' : score >= 50 ? 'Needs Improvement' : 'Poor SEO Score';
};

var sourceMode = false;
window.toggleSourceMode = function() {
    var body = document.getElementById('editor-body');
    var src  = document.getElementById('editor-source');
    var btn  = document.getElementById('source-btn');
    if (!sourceMode) {
        src.value = body.innerHTML; body.style.display = 'none'; src.style.display = 'block'; btn.classList.add('active'); sourceMode = true;
    } else {
        body.innerHTML = src.value; src.style.display = 'none'; body.style.display = 'block'; btn.classList.remove('active'); sourceMode = false;
    }
};

function updateWordCount() {
    var text  = document.getElementById('editor-body').innerText || '';
    var words = text.trim().split(/\s+/).filter(w => w.length > 0);
    var wc    = words.length;
    document.getElementById('word-count').textContent      = wc;
    document.getElementById('char-count-body').textContent = text.length;
    var mins = Math.ceil(wc / 200);
    document.getElementById('read-min').textContent        = mins;
    document.getElementById('read-time-est').innerHTML     = '<i class="ri-time-line"></i> ' + mins + ' min read';
    updateSeoChecks();
}
window.updateWordCount = updateWordCount;

function updateSeoChecks() {
    var title = document.getElementById('post-title').value;
    var desc  = document.getElementById('meta-desc').value;
    var kw    = document.getElementById('focus-kw').value;
    var wc    = parseInt(document.getElementById('word-count').textContent) || 0;
    var imgEl = document.getElementById('img-preview');
    var img   = imgEl && imgEl.src && imgEl.src !== window.location.href && imgEl.style.display !== 'none';
    setCheck('title',    title.length > 10,                   'Post title — '       + (title.length > 10 ? 'looks good' : 'too short'));
    setCheck('metadesc', desc.length >= 50 && desc.length <= 160, 'Meta description — ' + (desc.length < 50 ? 'too short' : desc.length > 160 ? 'too long' : 'good'));
    setCheck('keyword',  kw.length > 2,                       'Focus keyword — '    + (kw.length > 2 ? 'set' : 'not set'));
    setCheck('image',    img,                                  'Featured image — '   + (img ? 'uploaded' : 'not set'));
    setCheck('content',  wc >= 300,                           'Content length — '   + (wc >= 300 ? wc + ' words' : 'under 300 words'));
    calcSeoScore();
}

function setCheck(key, pass, text) {
    var item = document.querySelector('.seo-check-item[data-check="' + key + '"] div');
    if (!item) return;
    item.innerHTML = '<i class="' + (pass ? 'ri-checkbox-circle-fill" style="color:var(--green)' : 'ri-error-warning-line" style="color:var(--amber)"') + '></i> <span style="color:' + (pass ? 'var(--text2)' : 'var(--text3)') + '">' + text + '</span>';
}

function cc(id, countId, max) {
    var el  = document.getElementById(id);
    var cnt = document.getElementById(countId);
    if (!el || !cnt) return;
    var l = el.value.length;
    cnt.textContent = l + '/' + max;
    cnt.className   = 'char-count' + (l > max ? ' bad' : l > max * .85 ? ' warn' : '');
}

// Drag & drop
document.addEventListener('DOMContentLoaded', function() {
    var zone = document.getElementById('upload-zone');
    if (zone) {
        zone.addEventListener('dragover',  e => { e.preventDefault(); zone.classList.add('drag-over'); });
        zone.addEventListener('dragleave', ()  => zone.classList.remove('drag-over'));
        zone.addEventListener('drop', e => {
            e.preventDefault(); zone.classList.remove('drag-over');
            var f = e.dataTransfer.files[0];
            if (f) { document.getElementById('img-upload').files = e.dataTransfer.files; handleImageUpload(document.getElementById('img-upload')); }
        });
    }
    updateWordCount();
    updateSeoChecks();
    updateSerp();
});
</script>

@endsection