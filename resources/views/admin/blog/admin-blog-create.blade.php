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

/* Rich Editor Toolbar */
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

/* Image Upload Zone */
.upload-zone{border:2px dashed var(--border);border-radius:12px;padding:28px;text-align:center;cursor:pointer;transition:all .3s;position:relative}
.upload-zone:hover,.upload-zone.drag-over{border-color:var(--purple);background:rgba(124,58,237,.05)}
.upload-zone input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%}

/* Tag Input */
.tag-input-wrap{display:flex;flex-wrap:wrap;gap:6px;padding:8px 10px;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);min-height:42px;cursor:text}
.tag-input-wrap:focus-within{border-color:var(--purple)}
.tag-chip{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;background:rgba(124,58,237,.15);border:1px solid rgba(124,58,237,.25);border-radius:100px;font-size:.75rem;font-weight:600;color:var(--purple-light)}
.tag-chip button{background:none;border:none;color:var(--purple-light);cursor:pointer;font-size:.7rem;padding:0;line-height:1;opacity:.6}
.tag-chip button:hover{opacity:1}
.tag-real-input{border:none;background:transparent;outline:none;color:var(--text);font-size:.82rem;min-width:80px;flex:1;padding:2px 4px}

/* Word Count */
.word-count-bar{display:flex;align-items:center;justify-content:space-between;padding:8px 12px;background:var(--bg2);border:1px solid var(--border2);border-radius:0 0 var(--radius-sm) var(--radius-sm);margin-top:-1px}

/* SEO Score Mini */
.seo-mini{display:flex;align-items:center;gap:8px;padding:10px 14px;border-radius:var(--radius-sm);border:1px solid rgba(16,185,129,.15);background:rgba(16,185,129,.05);margin-bottom:14px}

/* Reading time estimator */
.read-estimate{display:inline-flex;align-items:center;gap:5px;font-size:.75rem;color:var(--text4);background:var(--row-bg);padding:4px 10px;border-radius:100px;border:1px solid var(--border2)}

/* Preview panel mini */
.serp-preview{background:var(--bg2);border:1px solid var(--border);border-radius:12px;padding:14px}
.serp-breadcrumb{font-size:.62rem;color:var(--text4);margin-bottom:3px}
.serp-title{font-size:.9rem;color:#8ab4f8;font-weight:500;margin-bottom:4px;line-height:1.4}
.serp-desc{font-size:.75rem;color:var(--text3);line-height:1.6}

/* Author avatar select */
.author-option{display:flex;align-items:center;gap:10px;padding:8px 12px;border-radius:var(--radius-sm);cursor:pointer;transition:background .2s;border:1px solid transparent}
.author-option:hover{background:var(--row-bg)}
.author-option.selected{background:rgba(124,58,237,.08);border-color:rgba(124,58,237,.2)}
.author-avatar-sm{width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.68rem;font-weight:800;color:#fff;flex-shrink:0}

/* Publish settings */
.publish-status-row{display:flex;align-items:center;gap:10px;padding:10px 14px;border-radius:var(--radius-sm);border:1px solid var(--border);background:var(--bg2);margin-bottom:8px;cursor:pointer;transition:all .2s}
.publish-status-row:hover{border-color:rgba(124,58,237,.2);background:rgba(124,58,237,.04)}
.publish-status-row.selected{border-color:rgba(124,58,237,.3);background:rgba(124,58,237,.08)}
</style>

<!-- Header -->
<div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px">
    <div style="display:flex;align-items:center;gap:12px">
        <a href="{{ route('admin.blog.index') }}" class="btn btn-ghost btn-sm"><i class="ri-arrow-left-line"></i></a>
        <div>
            <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800">New Blog Post</h2>
            <p style="font-size:.8rem;color:var(--text3);margin-top:3px">Create and publish a new article</p>
        </div>
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap">
        <button class="btn btn-ghost btn-sm" onclick="saveDraft()"><i class="ri-draft-line"></i> Save Draft</button>
        <button class="btn btn-ghost btn-sm" onclick="previewPost()"><i class="ri-eye-line"></i> Preview</button>
        <button class="btn btn-primary btn-sm" onclick="publishPost()"><i class="ri-send-plane-line"></i> Publish</button>
    </div>
</div>

@csrf

<div class="g2" style="align-items:start">

    <!-- LEFT — Main Content -->
    <div style="flex:2">

        <!-- Tabs -->
        <div style="display:flex;gap:4px;margin-bottom:16px;border-bottom:2px solid rgba(255,255,255,.05)">
            <button type="button" class="cms-tab-btn active" onclick="switchTab('content')" id="tab-btn-content"><i class="ri-article-line"></i> Content</button>
            <button type="button" class="cms-tab-btn" onclick="switchTab('seo')" id="tab-btn-seo"><i class="ri-search-eye-line"></i> SEO</button>
            <!-- <button type="button" class="cms-tab-btn" onclick="switchTab('schema')" id="tab-btn-schema"><i class="ri-code-line"></i> Schema</button> -->
        </div>

        <!-- ---- CONTENT TAB ---- -->
        <div class="cms-tab-content active" id="tab-content">

            <!-- Title -->
            <div class="field-group">
                <label class="label">Post Title <span style="color:var(--red)">*</span></label>
                <input class="inp" id="post-title" name="title" placeholder="Write a compelling title…" style="font-size:1rem;font-weight:700" oninput="syncTitle()" required>
                <div style="display:flex;align-items:center;justify-content:space-between;margin-top:4px">
                    <div class="char-count" id="tc-title">0/80</div>
                    <div class="read-estimate" id="read-time-est"><i class="ri-time-line"></i> 0 min read</div>
                </div>
            </div>

            <!-- Excerpt -->
            <div class="field-group">
                <label class="label">Excerpt / Summary</label>
                <textarea class="inp-area inp" id="post-excerpt" name="excerpt" rows="3" placeholder="Brief summary shown on blog listing page…" oninput="cc('post-excerpt','tc-excerpt',200)"></textarea>
                <div class="char-count" id="tc-excerpt">0/200</div>
            </div>

            <!-- Rich Text Editor -->
            <div class="field-group">
                <label class="label">Article Body <span style="color:var(--red)">*</span></label>
                <!-- Toolbar -->
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
                    <button type="button" class="editor-toolbar-btn" onclick="insertInfoBox()" title="Info Box"><i class="ri-information-line"></i></button>
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
                <!-- Editor Content Area -->
                <div class="editor-body" id="editor-body" contenteditable="true" oninput="updateWordCount()">
                    <p>Start writing your article here…</p>
                </div>
                <!-- Source Mode (hidden by default) -->
                <textarea class="inp-area inp" id="editor-source" style="display:none;font-family:monospace;font-size:.78rem;min-height:300px;border-radius:0 0 10px 10px;border-top:none" rows="16"></textarea>
                <!-- Hidden input for form submission -->
                <input type="hidden" name="content" id="post-content">
                <!-- Word count bar -->
                <div class="word-count-bar">
                    <span style="font-size:.72rem;color:var(--text4)"><i class="ri-file-text-line"></i> <span id="word-count">0</span> words · <span id="char-count-body">0</span> characters</span>
                    <span style="font-size:.72rem;color:var(--text4)">Approx. <span id="read-min">0</span> min read</span>
                </div>
            </div>

            <!-- Featured Image -->
            <div class="section-card">
                <div class="section-title" style="margin-bottom:14px"><i class="ri-image-line"></i> Featured Image</div>
                <div class="upload-zone" id="upload-zone" onclick="triggerUpload()">
                    <input type="file" name="featured_image" id="img-upload" accept="image/*" onchange="handleImageUpload(this)">
                    <div id="upload-placeholder">
                        <i class="ri-image-add-line" style="font-size:2rem;color:var(--text4);margin-bottom:8px;display:block"></i>
                        <div style="font-size:.85rem;font-weight:600;color:var(--text3);margin-bottom:4px">Drop image here or click to browse</div>
                        <div style="font-size:.72rem;color:var(--text4)">Recommended: 1200 × 630px · JPG, PNG, WebP · Max 5MB</div>
                    </div>
                    <div id="upload-preview" style="display:none">
                        <img id="img-preview" src="" style="max-height:180px;border-radius:8px;margin-bottom:10px">
                        <div id="img-name" style="font-size:.78rem;color:var(--text3)"></div>
                        <button type="button" onclick="clearImage(event)" class="btn btn-danger btn-sm" style="margin-top:8px"><i class="ri-delete-bin-line"></i> Remove</button>
                    </div>
                </div>
                <div class="g2" style="margin-top:12px">
                    <div class="field-group"><label class="label">Image Alt Text</label><input class="inp" name="image_alt" placeholder="Describe the image for accessibility & SEO"></div>
                    <div class="field-group"><label class="label">Image Caption (optional)</label><input class="inp" name="image_caption" placeholder="Caption shown under image"></div>
                </div>
            </div>

            <!-- Content Blocks -->
            <div class="section-card">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
                    <div class="section-title" style="margin:0"><i class="ri-layout-2-line"></i> Content Blocks</div>
                    <div style="display:flex;gap:6px">
                        <button type="button" class="btn btn-ghost btn-sm" onclick="addBlock('infobox')"><i class="ri-information-line"></i> Info Box</button>
                        <button type="button" class="btn btn-ghost btn-sm" onclick="addBlock('callout')"><i class="ri-megaphone-line"></i> CTA</button>
                        <button type="button" class="btn btn-ghost btn-sm" onclick="addBlock('divider')"><i class="ri-separator"></i> Divider</button>
                    </div>
                </div>
                <div id="content-blocks">
                    <div style="text-align:center;padding:20px;color:var(--text4);font-size:.8rem">
                        <i class="ri-layout-2-line" style="font-size:1.5rem;display:block;margin-bottom:8px;opacity:.4"></i>
                        No content blocks added. Use the buttons above to add callouts, info boxes, or dividers after your main content.
                    </div>
                </div>
            </div>

        </div>

        <!-- ---- SEO TAB ---- -->
        <div class="cms-tab-content" id="tab-seo">
            <div class="seo-mini">
                <div style="width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:800;color:var(--green);background:conic-gradient(var(--green) 0% 0%,rgba(255,255,255,.08) 0%);flex-shrink:0" id="seo-circle">0</div>
                <div class=""><div style="font-size:.85rem;font-weight:700;color:var(--text)" id="seo-score-label">No SEO data yet</div><div style="font-size:.75rem;color:var(--text3)">Fill in the fields below to improve your score</div></div>
            </div>

            <div class="section-card">
                <div class="section-title" style="margin-bottom:14px"><i class="ri-file-text-line"></i> Meta Tags</div>
                <div class="field-group">
                    <label class="label">SEO Title <span style="color:var(--text4);font-weight:400;text-transform:none;font-size:.72rem">(defaults to post title if empty)</span></label>
                    <input class="inp" name="seo_title" id="seo-title" placeholder="SEO-optimised title…" oninput="cc('seo-title','tc-seo-title',60);updateSerp()">
                    <div class="char-count" id="tc-seo-title">0/60</div>
                </div>
                <div class="field-group">
                    <label class="label">Meta Description <span style="color:var(--red)">*</span></label>
                    <textarea class="inp-area inp" name="meta_description" id="meta-desc" rows="3" placeholder="Compelling description for search results…" oninput="cc('meta-desc','tc-meta-desc',160);updateSerp()"></textarea>
                    <div class="char-count" id="tc-meta-desc">0/160</div>
                </div>
                <div class="g2">
                    <div class="field-group"><label class="label">Focus Keyword</label><input class="inp" name="focus_keyword" id="focus-kw" placeholder="Primary keyword" oninput="calcSeoScore()"></div>
                    <div class="field-group"><label class="label">Secondary Keywords</label><input class="inp" name="keywords" placeholder="keyword1, keyword2, keyword3"></div>
                </div>
                <div class="g2">
                    <div class="field-group"><label class="label">Canonical URL</label><input class="inp" name="canonical" placeholder="https://dremin.co.uk/blog/…"></div>
                    <div class="field-group"><label class="label">Robots</label><select class="inp" name="robots"><option>index, follow</option><option>noindex, follow</option><option>index, nofollow</option><option>noindex, nofollow</option></select></div>
                </div>
            </div>

            <!-- SERP Preview -->
            <div class="section-card">
                <div class="section-title" style="margin-bottom:14px"><i class="ri-google-line"></i> SERP Preview</div>
                <div class="serp-preview">
                    <div class="serp-breadcrumb">dremin.co.uk › blog › <span id="serp-slug">your-post-title</span></div>
                    <div class="serp-title" id="serp-title">Your post title will appear here</div>
                    <div class="serp-desc" id="serp-desc">Your meta description will appear here. Make it compelling to improve click-through rates from search results.</div>
                </div>
            </div>

            <!-- SEO Checklist -->
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

        <!-- ---- SCHEMA TAB ---- -->
        <div class="hidden cms-tab-content" id="tab-schema">
            <div class="section-card">
                <div class="section-title" style="margin-bottom:14px"><i class="ri-code-line"></i> Article Schema (JSON-LD)</div>
                <div style="font-size:.8rem;color:var(--text3);margin-bottom:14px">This schema is auto-generated based on your content. You can override it below.</div>
                <div class="field-group">
                    <label class="label">Override Schema JSON</label>
                    
                    @verbatim    
                    <textarea class="inp-area inp" name="schema_override" rows="14" style="font-family:monospace;font-size:.78rem" placeholder='{
                    "@context": "https://schema.org",
                    "@type": "Article",
                    "headline": "Your article title",
                    "author": {
                        "@type": "Person",
                        "name": "Author Name"
                    },
                    "datePublished": "2026-04-28"
                    }'></textarea>
                    @endverbatim
                </div>
                <div class="field-group">
                    <label class="label">Auto-Generate Schema From</label>
                    <div style="display:flex;gap:8px;flex-wrap:wrap">
                        <label style="display:flex;align-items:center;gap:6px;font-size:.8rem;color:var(--text3);cursor:pointer"><input type="checkbox" checked> Article Schema</label>
                        <label style="display:flex;align-items:center;gap:6px;font-size:.8rem;color:var(--text3);cursor:pointer"><input type="checkbox" checked> Breadcrumb Schema</label>
                        <label style="display:flex;align-items:center;gap:6px;font-size:.8rem;color:var(--text3);cursor:pointer"><input type="checkbox"> FAQ Schema</label>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- RIGHT — Settings Sidebar -->
    <div style="flex:1;position:sticky;top:90px;display:flex;flex-direction:column;gap:14px">

        <!-- Publish Settings -->
        <div class="section-card" style="margin:0">
            <div class="section-title" style="margin-bottom:14px"><i class="ri-send-plane-line" style="color:var(--purple)"></i> Publish Settings</div>

            <!-- Status -->
            <div class="field-group">
                <label class="label">Status</label>
                <div id="status-options" style="display:flex;flex-direction:column;gap:6px;margin-top:4px">
                    <label class="publish-status-row selected" onclick="selectStatus('published',this)">
                        <input type="radio" name="status" value="published" style="display:none">
                        <span class="blog-status-dot published"></span>
                        <div style="flex:1"><div style="font-size:.82rem;font-weight:700;color:var(--text)">Publish Now</div><div style="font-size:.7rem;color:var(--text4)">Go live immediately</div></div>
                        <i class="ri-check-line" style="color:var(--purple);opacity:0" id="check-published"></i>
                    </label>
                    <label class="publish-status-row" onclick="selectStatus('draft',this)">
                        <input type="radio" name="status" value="draft" style="display:none">
                        <span class="blog-status-dot draft"></span>
                        <div style="flex:1"><div style="font-size:.82rem;font-weight:700;color:var(--text)">Save as Draft</div><div style="font-size:.7rem;color:var(--text4)">Not visible to public</div></div>
                        <i class="ri-check-line" style="color:var(--purple);opacity:0" id="check-draft"></i>
                    </label>
                    <label class="publish-status-row" onclick="selectStatus('scheduled',this)">
                        <input type="radio" name="status" value="scheduled" style="display:none">
                        <span class="blog-status-dot scheduled"></span>
                        <div style="flex:1"><div style="font-size:.82rem;font-weight:700;color:var(--text)">Schedule</div><div style="font-size:.7rem;color:var(--text4)">Set a future publish date</div></div>
                        <i class="ri-check-line" style="color:var(--purple);opacity:0" id="check-scheduled"></i>
                    </label>
                </div>
            </div>

            <!-- Scheduled Date (shown when scheduled) -->
            <div class="field-group" id="schedule-date-wrap" style="display:none">
                <label class="label">Publish Date & Time</label>
                <input class="inp" name="publish_at" type="datetime-local">
            </div>

            <!-- Slug -->
            <div class="field-group">
                <label class="label">URL Slug</label>
                <div style="display:flex;gap:6px;align-items:center">
                    <span style="font-size:.72rem;color:var(--text4);flex-shrink:0">/blog/</span>
                    <input class="inp" name="slug" id="post-slug" placeholder="auto-generated" style="font-family:monospace;font-size:.78rem">
                </div>
                <div style="display:flex;align-items:center;gap:6px;margin-top:6px">
                    <label class="toggle-switch" style="transform:scale(.85)"><input type="checkbox" id="auto-slug" checked onchange="toggleAutoSlug()"><span class="toggle-slider"></span></label>
                    <span style="font-size:.72rem;color:var(--text4)">Auto-generate from title</span>
                </div>
            </div>

            <!-- Visibility -->
            <div class="field-group">
                <label class="label">Visibility</label>
                <select class="inp" name="visibility">
                    <option>Public</option>
                    <option>Private (admin only)</option>
                    <option>Password Protected</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center" onclick="prepareSubmit()">
                <i class="ri-send-plane-line"></i> Publish Post
            </button>
            <button type="button" class="btn btn-ghost" style="width:100%;justify-content:center;margin-top:6px" onclick="saveDraft()">
                <i class="ri-draft-line"></i> Save as Draft
            </button>
        </div>

        <!-- Category & Tags -->
        <div class="section-card" style="margin:0">
            <div class="section-title" style="margin-bottom:14px"><i class="ri-folder-line"></i> Category & Tags</div>
            <div class="field-group">
                <label class="label">Category <span style="color:var(--red)">*</span></label>
                <select class="inp" name="category" required>
                    <option value="">Select category</option>
                    <option value="savings">Savings</option>
                    <option value="tips">Tips & Tricks</option>
                    <option value="guide">Guides</option>
                    <option value="news">News</option>
                    <option value="finance">Finance</option>
                </select>
            </div>
            <div class="field-group">
                <label class="label">Tags</label>
                <div class="tag-input-wrap" id="tag-wrap" onclick="document.getElementById('tag-input').focus()">
                    <span class="tag-chip">#insurance <button type="button" onclick="removeTag(this)">×</button></span>
                    <span class="tag-chip">#savings <button type="button" onclick="removeTag(this)">×</button></span>
                    <input class="tag-real-input" id="tag-input" placeholder="Add tag…" onkeydown="addTag(event)" name="tags_raw">
                </div>
                <input type="hidden" name="tags" id="tags-hidden">
                <div style="font-size:.68rem;color:var(--text4);margin-top:4px">Press Enter or comma to add</div>
            </div>
        </div>

        <!-- Author -->
        <div class="section-card" style="margin:0">
            <div class="section-title" style="margin-bottom:14px"><i class="ri-user-line"></i> Author</div>
            <div id="author-list" style="display:flex;flex-direction:column;gap:4px">
                <label class="author-option selected" onclick="selectAuthor(this)">
                    <input type="radio" name="author_id" value="1" checked style="display:none">
                    <div class="author-avatar-sm" style="background:linear-gradient(135deg,#7c3aed,#06b6d4)">SR</div>
                    <div style="flex:1">
                        <div style="font-size:.82rem;font-weight:700;color:var(--text)">Sarah Reynolds</div>
                        <div style="font-size:.7rem;color:var(--text4)">Finance Writer</div>
                    </div>
                    <i class="ri-check-line" style="color:var(--purple)"></i>
                </label>
                <label class="author-option" onclick="selectAuthor(this)">
                    <input type="radio" name="author_id" value="2" style="display:none">
                    <div class="author-avatar-sm" style="background:linear-gradient(135deg,#10b981,#06b6d4)">JM</div>
                    <div style="flex:1">
                        <div style="font-size:.82rem;font-weight:700;color:var(--text)">James Morton</div>
                        <div style="font-size:.7rem;color:var(--text4)">Content Writer</div>
                    </div>
                    <i class="ri-check-line" style="color:var(--purple);opacity:0"></i>
                </label>
                <label class="author-option" onclick="selectAuthor(this)">
                    <input type="radio" name="author_id" value="3" style="display:none">
                    <div class="author-avatar-sm" style="background:linear-gradient(135deg,#f59e0b,#ef4444)">TW</div>
                    <div style="flex:1">
                        <div style="font-size:.82rem;font-weight:700;color:var(--text)">Tom Walsh</div>
                        <div style="font-size:.7rem;color:var(--text4)">Finance Writer</div>
                    </div>
                    <i class="ri-check-line" style="color:var(--purple);opacity:0"></i>
                </label>
            </div>
        </div>

        <!-- Display Options -->
        <div class="section-card" style="margin:0">
            <div class="section-title" style="margin-bottom:14px"><i class="ri-settings-3-line"></i> Display Options</div>
            <div style="display:flex;flex-direction:column;gap:10px">
                <div style="display:flex;align-items:center;justify-content:space-between">
                    <span style="font-size:.82rem;color:var(--text2)">Show in blog listing</span>
                    <label class="toggle-switch"><input type="checkbox" name="show_in_listing" checked><span class="toggle-slider"></span></label>
                </div>
                <div style="display:flex;align-items:center;justify-content:space-between">
                    <span style="font-size:.82rem;color:var(--text2)">Featured post</span>
                    <label class="toggle-switch"><input type="checkbox" name="is_featured"><span class="toggle-slider"></span></label>
                </div>
                <div style="display:flex;align-items:center;justify-content:space-between">
                    <span style="font-size:.82rem;color:var(--text2)">Allow comments</span>
                    <label class="toggle-switch"><input type="checkbox" name="allow_comments" checked><span class="toggle-slider"></span></label>
                </div>
                <div style="display:flex;align-items:center;justify-content:space-between">
                    <span style="font-size:.82rem;color:var(--text2)">Show table of contents</span>
                    <label class="toggle-switch"><input type="checkbox" name="show_toc" checked><span class="toggle-slider"></span></label>
                </div>
                <div style="display:flex;align-items:center;justify-content:space-between">
                    <span style="font-size:.82rem;color:var(--text2)">Show reading progress bar</span>
                    <label class="toggle-switch"><input type="checkbox" name="show_progress" checked><span class="toggle-slider"></span></label>
                </div>
                <div style="display:flex;align-items:center;justify-content:space-between">
                    <span style="font-size:.82rem;color:var(--text2)">Show author box</span>
                    <label class="toggle-switch"><input type="checkbox" name="show_author_box" checked><span class="toggle-slider"></span></label>
                </div>
            </div>
        </div>

        <!-- Related Posts -->
        <div class="section-card" style="margin:0">
            <div class="section-title" style="margin-bottom:14px"><i class="ri-article-line"></i> Related Posts</div>
            <div class="field-group">
                <label class="label">Selection Mode</label>
                <select class="inp" name="related_mode">
                    <option>Auto (by category & tags)</option>
                    <option>Manual selection</option>
                    <option>Disabled</option>
                </select>
            </div>
        </div>

    </div>
</div>

</form>

<script>
var autoSlug = true;
var currentStatus = 'published';

function switchTab(t){
    document.querySelectorAll('.cms-tab-content').forEach(c=>c.classList.remove('active'));
    document.querySelectorAll('.cms-tab-btn').forEach(b=>b.classList.remove('active'));
    document.getElementById('tab-'+t).classList.add('active');
    document.getElementById('tab-btn-'+t).classList.add('active');
}

// ---- Editor Functions ----
function fmt(cmd){ document.execCommand(cmd, false, null); }
function formatBlock(tag){ if(tag==='pre') document.execCommand('formatBlock',false,'pre'); else document.execCommand('formatBlock',false,tag); }

var sourceMode = false;
function toggleSourceMode(){
    var body = document.getElementById('editor-body');
    var src = document.getElementById('editor-source');
    var btn = document.getElementById('source-btn');
    if(!sourceMode){
        src.value = body.innerHTML;
        body.style.display='none';
        src.style.display='block';
        btn.classList.add('active');
        sourceMode=true;
    } else {
        body.innerHTML = src.value;
        src.style.display='none';
        body.style.display='block';
        btn.classList.remove('active');
        sourceMode=false;
    }
}

function insertLink(){
    var url = prompt('Enter URL:');
    if(url) document.execCommand('createLink',false,url);
}

function insertImage(){
    var url = prompt('Enter image URL:');
    if(url) document.execCommand('insertImage',false,url);
}

function insertInfoBox(){
    var body = document.getElementById('editor-body');
    var box = document.createElement('div');
    box.style.cssText = 'margin:20px 0;padding:16px 20px;border-radius:12px;border:1px solid rgba(124,58,237,.2);background:rgba(124,58,237,.05);font-size:.9rem;color:rgba(255,255,255,.7)';
    box.contentEditable = 'true';
    box.innerHTML = '<strong style="color:#fff">💡 Pro Tip:</strong> Your insight here…';
    body.appendChild(box);
}

function updateWordCount(){
    var body = document.getElementById('editor-body');
    var text = body.innerText || '';
    var words = text.trim().split(/\s+/).filter(w=>w.length>0);
    var wc = words.length;
    document.getElementById('word-count').textContent = wc;
    document.getElementById('char-count-body').textContent = text.length;
    var mins = Math.ceil(wc/200);
    document.getElementById('read-min').textContent = mins;
    document.getElementById('read-time-est').innerHTML = '<i class="ri-time-line"></i> '+mins+' min read';
    // SEO check
    updateSeoChecks();
}

// ---- Title / Slug Sync ----
function syncTitle(){
    var title = document.getElementById('post-title').value;
    cc('post-title','tc-title',80);
    if(autoSlug){
        var slug = title.toLowerCase().replace(/[^a-z0-9\s-]/g,'').replace(/\s+/g,'-').replace(/-+/g,'-').slice(0,60);
        document.getElementById('post-slug').value = slug;
        document.getElementById('serp-slug').textContent = slug||'your-post-title';
    }
    document.getElementById('serp-title').textContent = document.getElementById('seo-title').value||title||'Your post title will appear here';
    updateSeoChecks();
}

function toggleAutoSlug(){
    autoSlug = document.getElementById('auto-slug').checked;
    document.getElementById('post-slug').readOnly = autoSlug;
}
document.getElementById('post-slug').readOnly = true;

// ---- SEO ----
function updateSerp(){
    var title = document.getElementById('seo-title').value || document.getElementById('post-title').value;
    var desc = document.getElementById('meta-desc').value;
    document.getElementById('serp-title').textContent = title||'Your post title will appear here';
    document.getElementById('serp-desc').textContent = desc||'Your meta description will appear here.';
}

function calcSeoScore(){
    var score = 0;
    if(document.getElementById('post-title').value.length>10) score+=25;
    if(document.getElementById('meta-desc').value.length>50) score+=25;
    if(document.getElementById('focus-kw').value.length>2) score+=25;
    var wc = parseInt(document.getElementById('word-count').textContent)||0;
    if(wc>300) score+=25;
    var circle = document.getElementById('seo-circle');
    var label = document.getElementById('seo-score-label');
    if(circle){
        circle.textContent = score;
        circle.style.background = 'conic-gradient('+(score>=80?'var(--green)':score>=50?'var(--amber)':'var(--red)')+' 0% '+score+'%,rgba(255,255,255,.08) '+score+'%)';
        circle.style.color = score>=80?'var(--green)':score>=50?'var(--amber)':'var(--red)';
    }
    if(label) label.textContent = score>=80?'Good SEO Score':score>=50?'Needs Improvement':'Poor SEO Score';
}

function updateSeoChecks(){
    var title = document.getElementById('post-title').value;
    var desc = document.getElementById('meta-desc').value;
    var kw = document.getElementById('focus-kw').value;
    var wc = parseInt(document.getElementById('word-count').textContent)||0;
    var img = document.getElementById('img-preview').src && document.getElementById('img-preview').style.display!=='none';

    setCheck('title', title.length>10, 'Post title — '+(title.length>10?'looks good':'too short'));
    setCheck('metadesc', desc.length>=50&&desc.length<=160, 'Meta description — '+(desc.length<50?'too short':desc.length>160?'too long':'good'));
    setCheck('keyword', kw.length>2, 'Focus keyword — '+(kw.length>2?'set':'not set'));
    setCheck('image', img, 'Featured image — '+(img?'uploaded':'not set'));
    setCheck('content', wc>=300, 'Content length — '+(wc>=300?wc+' words':'under 300 words'));
    calcSeoScore();
}

function setCheck(key, pass, text){
    var item = document.querySelector('.seo-check-item[data-check="'+key+'"] div');
    if(!item) return;
    item.innerHTML = '<i class="'+(pass?'ri-checkbox-circle-fill" style="color:var(--green)':'ri-error-warning-line" style="color:var(--amber)')+'" ></i> <span style="color:'+(pass?'var(--text2)':'var(--text3)')+'">' + text + '</span>';
}

// ---- Image Upload ----
function triggerUpload(){ document.getElementById('img-upload').click(); }
function handleImageUpload(input){
    if(!input.files||!input.files[0]) return;
    var file = input.files[0];
    var reader = new FileReader();
    reader.onload = function(e){
        document.getElementById('img-preview').src = e.target.result;
        document.getElementById('img-preview').style.display = 'block';
        document.getElementById('img-name').textContent = file.name+' ('+Math.round(file.size/1024)+'KB)';
        document.getElementById('upload-placeholder').style.display='none';
        document.getElementById('upload-preview').style.display='block';
        updateSeoChecks();
    };
    reader.readAsDataURL(file);
}
function clearImage(e){
    e.stopPropagation();
    document.getElementById('img-upload').value='';
    document.getElementById('upload-placeholder').style.display='block';
    document.getElementById('upload-preview').style.display='none';
    document.getElementById('img-preview').src='';
    updateSeoChecks();
}

// ---- Tags ----
function addTag(e){
    if(e.key==='Enter'||e.key===','){
        e.preventDefault();
        var val = e.target.value.replace(',','').trim();
        if(!val) return;
        var chip = document.createElement('span');
        chip.className = 'tag-chip';
        chip.innerHTML = '#'+val+' <button type="button" onclick="removeTag(this)">×</button>';
        e.target.parentElement.insertBefore(chip, e.target);
        e.target.value='';
        syncTagsHidden();
    }
}
function removeTag(btn){
    btn.closest('.tag-chip').remove();
    syncTagsHidden();
}
function syncTagsHidden(){
    var chips = document.querySelectorAll('.tag-chip');
    var tags = Array.from(chips).map(c=>c.textContent.replace('×','').trim().replace('#',''));
    document.getElementById('tags-hidden').value = tags.join(',');
}

// ---- Status ----
function selectStatus(status, row){
    document.querySelectorAll('.publish-status-row').forEach(r=>{
        r.classList.remove('selected');
        var icon = r.querySelector('.ri-check-line');
        if(icon) icon.style.opacity='0';
    });
    row.classList.add('selected');
    var icon = row.querySelector('.ri-check-line');
    if(icon) icon.style.opacity='1';
    currentStatus = status;
    document.getElementById('schedule-date-wrap').style.display = status==='scheduled'?'block':'none';
}

// ---- Author ----
function selectAuthor(label){
    document.querySelectorAll('.author-option').forEach(o=>{
        o.classList.remove('selected');
        var icon = o.querySelector('.ri-check-line');
        if(icon) icon.style.opacity='0';
    });
    label.classList.add('selected');
    var icon = label.querySelector('.ri-check-line');
    if(icon) icon.style.opacity='1';
}

// ---- Content Blocks ----
function addBlock(type){
    var wrap = document.getElementById('content-blocks');
    var d = document.createElement('div');
    d.style.cssText = 'background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.07);border-radius:10px;padding:14px;margin-bottom:8px;display:flex;gap:10px;align-items:flex-start';
    if(type==='infobox'){
        d.innerHTML = `<i class="ri-information-line" style="color:#c4b5fd;font-size:1.2rem;flex-shrink:0;margin-top:2px"></i>
        <div style="flex:1">
            <input class="inp" placeholder="Info box title" style="margin-bottom:6px">
            <textarea class="inp-area inp" rows="2" placeholder="Info box content…"></textarea>
        </div>
        <div style="display:flex;flex-direction:column;gap:4px;flex-shrink:0">
            <select class="inp" style="font-size:.72rem;padding:4px 8px"><option>Info (purple)</option><option>Warning (amber)</option><option>Success (green)</option></select>
            <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('div[style]').remove()"><i class="ri-delete-bin-line"></i></button>
        </div>`;
    } else if(type==='callout'){
        d.innerHTML = `<i class="ri-megaphone-line" style="color:#67e8f9;font-size:1.2rem;flex-shrink:0;margin-top:2px"></i>
        <div style="flex:1">
            <input class="inp" placeholder="CTA Heading" style="margin-bottom:6px">
            <input class="inp" placeholder="Button label" style="margin-bottom:6px">
            <input class="inp" placeholder="Button URL">
        </div>
        <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('div[style]').remove()" style="flex-shrink:0"><i class="ri-delete-bin-line"></i></button>`;
    } else if(type==='divider'){
        d.innerHTML = `<i class="ri-separator" style="color:var(--text4);font-size:1.2rem;flex-shrink:0"></i>
        <div style="flex:1"><span style="font-size:.8rem;color:var(--text3)">Section Divider</span></div>
        <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('div[style]').remove()"><i class="ri-delete-bin-line"></i></button>`;
    }
    // Clear placeholder if present
    var placeholder = wrap.querySelector('[style*="text-align:center"]');
    if(placeholder) placeholder.remove();
    wrap.appendChild(d);
}

// ---- Helpers ----
function cc(id,countId,max){
    var el=document.getElementById(id),cnt=document.getElementById(countId);
    if(!el||!cnt)return;
    var l=el.value.length;
    cnt.textContent=l+'/'+max;
    cnt.className='char-count'+(l>max?' bad':l>max*.85?' warn':'');
}

function prepareSubmit(){
    var body = document.getElementById('editor-body');
    document.getElementById('post-content').value = body.innerHTML;
}

function saveDraft(){
    currentStatus='draft';
    if(typeof toast==='function') toast('Draft saved!','success');
}

function previewPost(){
    if(typeof toast==='function') toast('Opening preview…','info');
}

function publishPost(){
    prepareSubmit();
    if(typeof toast==='function') toast('Post published!','success');
}

// Setup drag-over for upload zone
var zone = document.getElementById('upload-zone');
if(zone){
    zone.addEventListener('dragover',e=>{e.preventDefault();zone.classList.add('drag-over')});
    zone.addEventListener('dragleave',()=>zone.classList.remove('drag-over'));
    zone.addEventListener('drop',e=>{
        e.preventDefault();zone.classList.remove('drag-over');
        var f=e.dataTransfer.files[0];
        if(f){document.getElementById('img-upload').files=e.dataTransfer.files;handleImageUpload(document.getElementById('img-upload'));}
    });
}
</script>

@endsection