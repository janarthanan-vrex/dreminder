@extends('layouts.app')
@section('content')

@php
$catIcons = [
    'savings' => 'ri-money-dollar-circle-line',
    'tips'    => 'ri-lightbulb-flash-line',
    'guide'   => 'ri-map-2-line',
    'news'    => 'ri-newspaper-line',
    'finance' => 'ri-line-chart-line',
];
$catLabels = [
    'savings' => 'Savings',
    'tips'    => 'Tips & Tricks',
    'guide'   => 'Complete Guide',
    'news'    => 'News',
    'finance' => 'Finance',
];
@endphp

<script>tailwind.config={theme:{extend({colors:{primary:'#7c3aed',secondary:'#06b6d4',accent:'#10b981',dark:'#030014',surface:'#0a0a1f',card:'#0f0f2a'},fontFamily:{sans:['Inter','system-ui','sans-serif']}}}}}</script>
<style>
  .article-hero { position:relative; padding:140px 0 80px; background:linear-gradient(180deg,rgba(3,0,20,0) 0%,rgba(3,0,20,1) 100%); }
  .article-hero-img { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; opacity:0.15; z-index:0; }
  .article-hero-overlay { position:absolute; inset:0; background:linear-gradient(to bottom,rgba(3,0,20,0.7) 0%,rgba(3,0,20,0.85) 40%,rgba(3,0,20,0.95) 70%,rgba(3,0,20,1) 100%); z-index:1; }
  .article-meta { display:flex; align-items:center; gap:20px; flex-wrap:wrap; padding-bottom:20px; border-bottom:1px solid rgba(255,255,255,.06); margin-bottom:32px; }
  .article-stats { display:flex; align-items:center; gap:20px; flex-wrap:wrap; }
  .article-stat { display:flex; align-items:center; gap:6px; font-size:.8rem; color:rgba(255,255,255,.4); font-weight:600; }
  .article-stat i { font-size:1.1rem; color:rgba(124,58,237,.6); }
  .article-body { color:rgba(255,255,255,.75); line-height:1.85; font-size:1.05rem; }
  .article-body h2 { font-size:1.85rem; font-weight:800; color:#fff; margin:48px 0 20px; line-height:1.3; scroll-margin-top:100px; }
  .article-body h3 { font-size:1.45rem; font-weight:700; color:#e2e8f0; margin:36px 0 16px; line-height:1.4; scroll-margin-top:100px; }
  .article-body h4 { font-size:1.2rem; font-weight:700; color:#cbd5e1; margin:28px 0 14px; scroll-margin-top:100px; }
  .article-body p { margin-bottom:24px; }
  .article-body a { color:#c4b5fd; text-decoration:underline; text-decoration-color:rgba(196,181,253,.3); text-underline-offset:3px; transition:all .3s; }
  .article-body a:hover { color:#a78bfa; text-decoration-color:rgba(167,139,250,.6); }
  .article-body ul,.article-body ol { margin:24px 0; padding-left:28px; }
  .article-body ul li,.article-body ol li { margin-bottom:12px; color:rgba(255,255,255,.7); }
  .article-body ul li::marker { color:#7c3aed; }
  .article-body ol li::marker { color:#7c3aed; font-weight:700; }
  .article-body strong { color:#fff; font-weight:700; }
  .article-body em { color:#c4b5fd; font-style:italic; }
  .article-img { border-radius:20px; overflow:hidden; margin:40px 0; border:1px solid rgba(255,255,255,.08); box-shadow:0 20px 60px rgba(0,0,0,.3); }
  .article-img img { width:100%; height:auto; display:block; }
  .article-img figcaption { padding:14px 20px; background:rgba(255,255,255,.02); border-top:1px solid rgba(255,255,255,.05); font-size:.82rem; color:rgba(255,255,255,.4); text-align:center; font-style:italic; }
  .article-body blockquote { position:relative; margin:36px 0; padding:28px 32px 28px 68px; background:linear-gradient(135deg,rgba(124,58,237,.08),rgba(6,182,212,.05)); border-left:4px solid #7c3aed; border-radius:16px; font-size:1.15rem; line-height:1.75; color:rgba(255,255,255,.85); font-style:italic; font-weight:500; }
  .article-body blockquote::before { content:'"'; position:absolute; left:20px; top:20px; font-size:4rem; color:rgba(124,58,237,.2); font-family:Georgia,serif; line-height:1; }
  .article-body blockquote cite { display:block; margin-top:12px; font-size:.85rem; color:rgba(255,255,255,.5); font-style:normal; font-weight:600; }
  .article-body blockquote cite::before { content:'— '; }
  .article-body pre { margin:32px 0; padding:24px; background:rgba(0,0,0,.4); border:1px solid rgba(255,255,255,.08); border-radius:14px; overflow-x:auto; font-size:.88rem; line-height:1.7; }
  .article-body code { font-family:'Monaco','Courier New',monospace; color:#67e8f9; }
  .article-body p code { padding:3px 8px; background:rgba(124,58,237,.15); border-radius:6px; font-size:.9em; color:#c4b5fd; border:1px solid rgba(124,58,237,.2); }
  .share-box { background:rgba(255,255,255,.02); border:1px solid rgba(255,255,255,.08); border-radius:20px; padding:24px; margin-bottom:24px; }
  .share-title { font-size:.9rem; font-weight:800; color:#fff; text-transform:uppercase; letter-spacing:.06em; margin-bottom:16px; display:flex; align-items:center; gap:10px; }
  .share-title i { font-size:1.1rem; color:#06b6d4; }
  .share-buttons { display:flex; flex-direction:column; gap:10px; }
  .share-btn { display:flex; align-items:center; justify-content:center; gap:10px; padding:12px 18px; border-radius:12px; font-size:.85rem; font-weight:700; transition:all .3s; text-decoration:none; border:1px solid; cursor:pointer; background:transparent; }
  .share-btn.facebook { background:rgba(24,119,242,.1); border-color:rgba(24,119,242,.2); color:#93c5fd; }
  .share-btn.facebook:hover { background:rgba(24,119,242,.2); transform:translateX(4px); }
  .share-btn.instagram { background:rgba(180,24,242,.1); border-color:rgba(242,24,212,.2); color:#fd93e0; }
  .share-btn.instagram:hover { background:rgba(180,24,242,.2); transform:translateX(4px); }
  .share-btn.link { background:rgba(16,185,129,.1); border-color:rgba(16,185,129,.2); color:#6ee7b7; }
  .share-btn.link:hover { background:rgba(16,185,129,.2); transform:translateX(4px); }
  .article-progress { position:fixed; top:0; left:0; right:0; height:4px; background:rgba(255,255,255,.05); z-index:9999; }
  .article-progress-bar { height:100%; background:linear-gradient(90deg,#7c3aed,#06b6d4); width:0%; transition:width .2s ease-out; box-shadow:0 0 20px rgba(124,58,237,.5); }
  .article-tags { margin:40px 0; display:flex; gap:10px; flex-wrap:wrap; align-items:center; }
  .article-tags .label { font-size:.8rem; font-weight:700; color:rgba(255,255,255,.4); text-transform:uppercase; letter-spacing:.05em; }
  .article-tag { display:inline-flex; align-items:center; gap:5px; padding:8px 16px; border-radius:10px; background:rgba(255,255,255,.03); border:1px solid rgba(255,255,255,.08); font-size:.8rem; font-weight:600; color:rgba(255,255,255,.5); transition:all .3s; text-decoration:none; }
  .article-tag:hover { background:rgba(124,58,237,.1); border-color:rgba(124,58,237,.25); color:#c4b5fd; }
  .related-card { display:flex; gap:16px; padding:16px; border-radius:16px; background:rgba(255,255,255,.02); border:1px solid rgba(255,255,255,.06); transition:all .4s cubic-bezier(.16,1,.3,1); text-decoration:none; align-items:flex-start; }
  .related-card:hover { background:rgba(255,255,255,.04); border-color:rgba(124,58,237,.2); transform:translateY(-4px); box-shadow:0 15px 40px rgba(124,58,237,.1); }
  .related-card-img { width:100px; height:100px; border-radius:12px; object-fit:cover; flex-shrink:0; border:1px solid rgba(255,255,255,.08); }
  .related-card-img-placeholder { width:100px; height:100px; border-radius:12px; flex-shrink:0; background:rgba(124,58,237,.08); display:flex; align-items:center; justify-content:center; color:rgba(255,255,255,.15); font-size:1.8rem; border:1px solid rgba(255,255,255,.08); }
  .related-card-content { flex:1; min-width:0; }
  .related-card-cat { font-size:.68rem; font-weight:700; text-transform:uppercase; letter-spacing:.05em; color:#c4b5fd; margin-bottom:6px; }
  .related-card-title { font-size:.95rem; font-weight:700; color:#e2e8f0; line-height:1.5; margin-bottom:8px; transition:color .3s; }
  .related-card:hover .related-card-title { color:#c4b5fd; }
  .related-card-meta { display:flex; align-items:center; gap:12px; font-size:.72rem; color:rgba(255,255,255,.35); }
  .article-nav { display:grid; grid-template-columns:1fr 1fr; gap:20px; margin:60px 0; }
  .article-nav-item { padding:24px; border-radius:20px; background:rgba(255,255,255,.02); border:1px solid rgba(255,255,255,.06); transition:all .4s; text-decoration:none; display:flex; flex-direction:column; gap:10px; }
  .article-nav-item:hover { background:rgba(255,255,255,.04); border-color:rgba(124,58,237,.2); transform:translateY(-4px); }
  .article-nav-item.next { text-align:right; }
  .article-nav-label { font-size:.75rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:rgba(255,255,255,.4); display:flex; align-items:center; gap:8px; }
  .article-nav-item.next .article-nav-label { justify-content:flex-end; }
  .article-nav-title { font-size:1.05rem; font-weight:700; color:#e2e8f0; line-height:1.4; transition:color .3s; }
  .article-nav-item:hover .article-nav-title { color:#c4b5fd; }
  .cat-badge { display:inline-flex; align-items:center; gap:5px; padding:6px 14px; border-radius:100px; font-size:.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; }
  .cat-badge.guide { background:rgba(6,182,212,.12); color:#67e8f9; border:1px solid rgba(6,182,212,.2); }
  .cat-badge.savings { background:rgba(16,185,129,.12); color:#6ee7b7; border:1px solid rgba(16,185,129,.2); }
  .cat-badge.news { background:rgba(245,158,11,.1); color:#fcd34d; border:1px solid rgba(245,158,11,.2); }
  .cat-badge.finance { background:rgba(239,68,68,.1); color:#fca5a5; border:1px solid rgba(239,68,68,.2); }
  .cat-badge.tips { background:rgba(124,58,237,.12); color:#c4b5fd; border:1px solid rgba(124,58,237,.2); }
  @media(max-width:768px){
    .article-hero{padding:100px 0 60px}
    .article-body{font-size:.98rem}
    .article-body h2{font-size:1.5rem;margin:36px 0 16px}
    .article-body h3{font-size:1.25rem}
    .article-body blockquote{padding:20px 20px 20px 50px;font-size:1rem}
    .article-body blockquote::before{font-size:3rem;left:12px}
    .article-nav{grid-template-columns:1fr}
    .article-nav-item.next{text-align:left}
    .article-nav-item.next .article-nav-label{justify-content:flex-start}
    .related-card{flex-direction:column}
    .related-card-img,.related-card-img-placeholder{width:100%;height:180px}
  }
</style>

<!-- Reading Progress Bar -->
<div class="article-progress"><div class="article-progress-bar" id="articleProgressBar"></div></div>

<!-- ARTICLE HERO -->
<section class="article-hero section-dark relative overflow-hidden">
  @if($post->featured_image)
    <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}" class="article-hero-img">
  @endif
  <div class="article-hero-overlay"></div>

  <div class="max-w-[860px] mx-auto px-6 relative z-10">
    <div class="page-breadcrumb reveal">
      <a href="{{ url('index') }}">Home</a>
      <span class="sep">/</span>
      <a href="{{ url('blog') }}">Blog</a>
      <span class="sep">/</span>
      <span>{{ Str::limit($post->title, 40) }}</span>
    </div>

    <div class="mb-5 reveal">
      <span class="cat-badge {{ $post->category }}">
        <i class="{{ $catIcons[$post->category] ?? 'ri-article-line' }}"></i>
        {{ $catLabels[$post->category] ?? ucfirst($post->category) }}
      </span>
    </div>

    <h1 class="text-3xl md:text-5xl font-black text-white leading-tight mb-6 reveal" data-delay="1">
      {{ $post->title }}
    </h1>

    @if($post->excerpt)
    <p class="text-lg text-white/65 leading-relaxed mb-8 reveal" data-delay="2">
      {{ $post->excerpt }}
    </p>
    @endif

    <div class="article-meta reveal" data-delay="3">
      <div class="article-stats">
        <div class="article-stat"><i class="ri-calendar-line"></i><span>{{ $post->created_at->format('F d, Y') }}</span></div>
        <div class="article-stat"><i class="ri-time-line"></i><span>{{ $readTime }} min read</span></div>
      </div>
    </div>
  </div>
</section>

<!-- ARTICLE CONTENT -->
<section class="relative py-10 section-dark">
  <div class="max-w-7xl mx-auto px-6 lg:px-8">
    <div class="flex flex-col lg:flex-row gap-12">

      <!-- MAIN CONTENT -->
      <article class="flex-1 min-w-0">
        <div class="article-body">
          {!! $post->content !!}
        </div>

        <!-- TAGS -->
        @if($post->keywords)
        <div class="article-tags reveal">
          <span class="label"><i class="ri-price-tag-3-line"></i> Tags:</span>
          @foreach(array_map('trim', explode(',', $post->keywords)) as $tag)
            @if($tag)
            <a href="{{ url('blog') }}" class="article-tag">#{{ $tag }}</a>
            @endif
          @endforeach
        </div>
        @endif

        <!-- PREV / NEXT NAV -->
        @if($prev || $next)
        <div class="article-nav reveal">
          @if($prev)
          <a href="{{ url('blog/' . $prev->slug) }}" class="article-nav-item prev">
            <div class="article-nav-label"><i class="ri-arrow-left-line"></i> Previous Article</div>
            <div class="article-nav-title">{{ $prev->title }}</div>
          </a>
          @else
          <div></div>
          @endif

          @if($next)
          <a href="{{ url('blog/' . $next->slug) }}" class="article-nav-item next">
            <div class="article-nav-label">Next Article <i class="ri-arrow-right-line"></i></div>
            <div class="article-nav-title">{{ $next->title }}</div>
          </a>
          @endif
        </div>
        @endif

      </article>

      <!-- SIDEBAR -->
      <aside class="lg:w-[260px] flex-shrink-0">
        <div style="position:sticky;top:100px">
          <div class="share-box reveal hidden">
            <div class="share-title"><i class="ri-share-line"></i> Share Article</div>
            <div class="share-buttons">
              <a href="#" class="share-btn facebook" onclick="shareFacebook(); return false;"><i class="ri-facebook-fill"></i> Share on Facebook</a>
              <a href="#" class="share-btn instagram" onclick="shareInstagram(); return false;"><i class="ri-instagram-fill"></i> Share on Instagram</a>
              <button class="share-btn link" onclick="copyLink()"><i class="ri-link"></i> <span id="copyLinkText">Copy Link</span></button>
            </div>
          </div>
        </div>
      </aside>

    </div>
  </div>
</section>

<!-- RELATED ARTICLES -->
@if($related->isNotEmpty())
<section class="relative py-16 section-alt">
  <div class="max-w-7xl mx-auto px-6 lg:px-8">
    <div class="flex items-center gap-3 mb-8">
      <div class="w-10 h-10 rounded-xl bg-purple-500/15 flex items-center justify-content:center text-lg text-purple-400"><i class="ri-article-line"></i></div>
      <h2 class="text-2xl font-black text-white">Related Articles</h2>
    </div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($related as $rel)
      @php $relReadTime = max(1, ceil(str_word_count(strip_tags($rel->content)) / 200)); @endphp
      <a href="{{ url('blog/' . $rel->slug) }}" class="related-card">
        @if($rel->featured_image)
          <img src="{{ asset($rel->featured_image) }}" alt="{{ $rel->title }}" class="related-card-img">
        @else
          <div class="related-card-img-placeholder"><i class="ri-image-line"></i></div>
        @endif
        <div class="related-card-content">
          <div class="related-card-cat">{{ $catLabels[$rel->category] ?? ucfirst($rel->category) }}</div>
          <div class="related-card-title">{{ $rel->title }}</div>
          <div class="related-card-meta">
            <span><i class="ri-time-line"></i> {{ $relReadTime }} min</span>
            <span>{{ $rel->created_at->format('M d, Y') }}</span>
          </div>
        </div>
      </a>
      @endforeach
    </div>
  </div>
</section>
@endif

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="{{ asset('assets/js/distortion.js') }}"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
<script>
setActivePage('blog');

window.addEventListener('scroll', () => {
  const article = document.querySelector('.article-body');
  if (!article) return;
  const progress = Math.min(Math.max(((window.pageYOffset - article.offsetTop + window.innerHeight) / article.offsetHeight) * 100, 0), 100);
  const bar = document.getElementById('articleProgressBar');
  if (bar) bar.style.width = progress + '%';
});

function shareFacebook() {
  window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.href), '_blank', 'width=600,height=400');
}
function shareInstagram() {
  window.open('https://www.instagram.com/', '_blank');
}
function copyLink() {
  navigator.clipboard.writeText(window.location.href).then(() => {
    var btn = document.getElementById('copyLinkText');
    btn.textContent = 'Copied!';
    setTimeout(() => { btn.textContent = 'Copy Link'; }, 2000);
  });
}
</script>
@endsection