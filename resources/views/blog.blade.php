@extends('layouts.app')
@section('content')

<script>tailwind.config={theme:{extend:{colors:{primary:'#7c3aed',secondary:'#06b6d4',accent:'#10b981',dark:'#030014',surface:'#0a0a1f',card:'#0f0f2a'},fontFamily:{sans:['Inter','system-ui','sans-serif']}}}}}</script>
<style>
  .blog-cat-pill {
    padding: 8px 18px;
    border-radius: 100px;
    font-size: .78rem;
    font-weight: 700;
    color: rgba(255,255,255,.35);
    cursor: pointer;
    border: 1px solid rgba(255,255,255,.07);
    background: transparent;
    transition: all .3s cubic-bezier(.16,1,.3,1);
    white-space: nowrap;
    font-family: 'Inter', sans-serif;
    text-transform: uppercase;
    letter-spacing: .06em;
  }
  .blog-cat-pill:hover { color: rgba(255,255,255,.7); border-color: rgba(124,58,237,.3); background: rgba(124,58,237,.06); }
  .blog-cat-pill.active { background: linear-gradient(135deg,#7c3aed,#6d28d9); color: #fff; border-color: transparent; box-shadow: 0 4px 20px rgba(124,58,237,.4); }

  .blog-featured {
    position: relative;
    border-radius: 28px;
    overflow: hidden;
    border: 1px solid rgba(255,255,255,.07);
    background: rgba(255,255,255,.02);
    transition: all .5s cubic-bezier(.16,1,.3,1);
    text-decoration: none;
    display: block;
  }
  .blog-featured:hover { border-color: rgba(124,58,237,.25); transform: translateY(-6px); box-shadow: 0 30px 80px rgba(124,58,237,.15); }
  .blog-featured-img { width: 100%; height: 340px; object-fit: cover; transition: transform .7s cubic-bezier(.16,1,.3,1); display: block; }
  .blog-featured:hover .blog-featured-img { transform: scale(1.04); }
  .blog-featured-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(3,0,20,.95) 0%, rgba(3,0,20,.5) 50%, transparent 100%); }
  .blog-featured-body { position: absolute; bottom: 0; left: 0; right: 0; padding: 32px 36px; }

  .blog-card {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid rgba(255,255,255,.06);
    background: rgba(255,255,255,.02);
    transition: all .5s cubic-bezier(.16,1,.3,1);
    display: flex;
    flex-direction: column;
  }
  .blog-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 1px; background: linear-gradient(90deg, transparent, rgba(124,58,237,.5), transparent); opacity: 0; transition: opacity .4s; }
  .blog-card:hover { border-color: rgba(124,58,237,.2); transform: translateY(-8px); box-shadow: 0 25px 60px rgba(124,58,237,.12); }
  .blog-card:hover::before { opacity: 1; }
  .blog-card-img-wrap { overflow: hidden; position: relative; height: 200px; }
  .blog-card-img { width: 100%; height: 100%; object-fit: cover; transition: transform .7s cubic-bezier(.16,1,.3,1); }
  .blog-card:hover .blog-card-img { transform: scale(1.08); }
  .blog-card-img-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(3,0,20,.6), transparent); }
  .blog-card-body { padding: 24px; flex: 1; display: flex; flex-direction: column; }
  .blog-card-title { font-size: 1rem; font-weight: 700; color: #e2e8f0; line-height: 1.45; margin-bottom: 10px; transition: color .3s; }
  .blog-card:hover .blog-card-title { color: #c4b5fd; }
  .blog-card-excerpt { font-size: .8rem; color: rgba(255,255,255,.4); line-height: 1.75; flex: 1; margin-bottom: 18px; }
  .blog-card-footer { display: flex; align-items: center; justify-content: space-between; padding-top: 16px; border-top: 1px solid rgba(255,255,255,.06); margin-top: auto; }

  .cat-badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 12px; border-radius: 100px; font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; }
  .cat-badge.savings { background: rgba(16,185,129,.12); color: #6ee7b7; border: 1px solid rgba(16,185,129,.2); }
  .cat-badge.tips { background: rgba(124,58,237,.12); color: #c4b5fd; border: 1px solid rgba(124,58,237,.2); }
  .cat-badge.guide { background: rgba(6,182,212,.12); color: #67e8f9; border: 1px solid rgba(6,182,212,.2); }
  .cat-badge.news { background: rgba(245,158,11,.1); color: #fcd34d; border: 1px solid rgba(245,158,11,.2); }
  .cat-badge.finance { background: rgba(239,68,68,.1); color: #fca5a5; border: 1px solid rgba(239,68,68,.2); }

  .read-time { display: inline-flex; align-items: center; gap: 5px; font-size: .72rem; font-weight: 600; color: rgba(255,255,255,.3); }

  .load-more-wrap { text-align: center; padding-top: 48px; }
  @keyframes spinPulse { 0%,100%{transform:rotate(0deg) scale(1)} 50%{transform:rotate(180deg) scale(1.1)} }
  .load-more-spinner { animation: spinPulse .8s ease-in-out infinite; }

  #noBlogResults { display: none; }
  #noBlogResults.show { display: block; }

  .blog-card-item:nth-child(1){--d:0s}.blog-card-item:nth-child(2){--d:.07s}
  .blog-card-item:nth-child(3){--d:.14s}.blog-card-item:nth-child(4){--d:.21s}
  .blog-card-item:nth-child(5){--d:.28s}.blog-card-item:nth-child(6){--d:.35s}
  .blog-card-item.reveal{transition-delay:var(--d,0s)}

  .blog-card-img-placeholder { width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:rgba(124,58,237,.08);color:rgba(255,255,255,.15);font-size:3rem; }
  .blog-featured-placeholder { width:100%;height:340px;display:flex;align-items:center;justify-content:center;background:rgba(124,58,237,.08);color:rgba(255,255,255,.15);font-size:4rem; }
</style>

<!-- HERO -->
<section class="page-hero-dark section-alt relative" data-particles="purple" data-p-count="40" data-p-connect="false">
  <div class="gradient-blob w-[500px] h-[500px] bg-primary top-[-20%] left-[10%]"></div>
  <div class="gradient-blob w-[300px] h-[300px] bg-secondary top-[10%] right-[5%]"></div>
  <div class="max-w-[860px] mx-auto px-6 relative z-10">
    <div class="page-breadcrumb"><a href="index">Home</a><span class="sep">/</span><span>Blog</span></div>
    <div class="badge bg-secondary/10 border border-secondary/20 text-cyan-300 mx-auto mb-6 w-fit reveal">
      <span class="w-2 h-2 rounded-full bg-secondary"></span> Insights &amp; Guides
    </div>
    <h1 class="reveal">Smart money tips from <span class="grad-text">the DRemind team.</span></h1>
    <p class="reveal mb-10" data-delay="1">
      Practical guides on saving money, managing renewals, and getting the most out of every subscription — written for real people.
    </p>
    <div class="relative reveal" data-delay="2" style="max-width:520px;margin:20px auto">
      <i class="ri-search-line absolute left-4 top-1/2 -translate-y-1/2 text-white/30 text-base z-10"></i>
      <input type="text" id="blogSearch" placeholder="Search articles, tips, guides…" class="auth-input !pl-12 !text-base !pr-32">
      <button class="absolute right-2 top-1/2 -translate-y-1/2 btn-primary !py-2 !px-4 text-xs !rounded-xl" id="blogSearchBtn">Search</button>
    </div>
  </div>
</section>

<!-- MAIN CONTENT -->
<section class="relative py-20 section-dark">
  <div class="max-w-7xl mx-auto px-6 lg:px-8">

    @if($posts->isNotEmpty())

    <!-- Category Filter -->
    <div class="hidden items-center gap-3 overflow-x-auto pb-3 mb-10 reveal" style="scrollbar-width:none" id="blogCatFilter">
      <button class="blog-cat-pill active" data-cat="all">All</button>
      <button class="blog-cat-pill" data-cat="savings"><i class="ri-money-dollar-circle-line"></i> Savings</button>
      <button class="blog-cat-pill" data-cat="tips"><i class="ri-lightbulb-flash-line"></i> Tips &amp; Tricks</button>
      <button class="blog-cat-pill" data-cat="guide"><i class="ri-map-2-line"></i> Guides</button>
      <button class="blog-cat-pill" data-cat="news"><i class="ri-newspaper-line"></i> News</button>
      <button class="blog-cat-pill" data-cat="finance"><i class="ri-line-chart-line"></i> Finance</button>
    </div>

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
          'tips'    => 'Tips',
          'guide'   => 'Guide',
          'news'    => 'News',
          'finance' => 'Finance',
      ];
      // word count helper for read time
      $readTime = function($html) {
          $words = str_word_count(strip_tags($html));
          return max(1, ceil($words / 200));
      };
    @endphp

    <!-- Featured Post -->
    @if($featured)
    <div class="mb-12 reveal" id="featuredPost" data-cat="{{ $featured->category }}">
      <a href="{{ url('blog/' . $featured->slug) }}" class="blog-featured">
        <div style="overflow:hidden;height:340px">
          @if($featured->featured_image)
            <img src="{{ asset($featured->featured_image) }}" alt="{{ $featured->title }}" class="blog-featured-img">
          @else
            <div class="blog-featured-placeholder"><i class="ri-image-line"></i></div>
          @endif
        </div>
        <div class="blog-featured-overlay"></div>
        <div class="blog-featured-body">
          <div class="flex items-center gap-3 mb-3">
            <span class="cat-badge {{ $featured->category }}">
              <i class="{{ $catIcons[$featured->category] ?? 'ri-article-line' }}"></i>
              {{ $catLabels[$featured->category] ?? ucfirst($featured->category) }}
            </span>
            <span class="read-time"><i class="ri-time-line"></i> {{ $readTime($featured->content) }} min read</span>
            <span class="read-time"><i class="ri-fire-line text-orange-400"></i> Featured</span>
          </div>
          <h2 class="text-2xl md:text-3xl font-black text-white leading-tight mb-3 hover:text-purple-300 transition-colors" style="max-width:700px">
            {{ $featured->title }}
          </h2>
          @if($featured->excerpt)
          <p class="text-sm text-white/55 leading-relaxed mb-4" style="max-width:600px">
            {{ $featured->excerpt }}
          </p>
          @endif
          <div class="flex items-center justify-between flex-wrap gap-3">
            <div class="read-time">{{ $featured->created_at->format('F d, Y') }}</div>
            <span class="btn-secondary !py-2 !px-4 !text-xs !rounded-xl" style="pointer-events:none">Read Article <i class="ri-arrow-right-line"></i></span>
          </div>
        </div>
      </a>
    </div>
    @endif

    <!-- Blog Grid -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6" id="blogGrid">
      @foreach($rest as $post)
      <div class="blog-card blog-card-item reveal" data-cat="{{ $post->category }}">
        <div class="blog-card-img-wrap">
          @if($post->featured_image)
            <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}" class="blog-card-img">
          @else
            <div class="blog-card-img-placeholder"><i class="ri-image-line"></i></div>
          @endif
          <div class="blog-card-img-overlay"></div>
          <span class="cat-badge {{ $post->category }} absolute bottom-3 left-4">
            <i class="{{ $catIcons[$post->category] ?? 'ri-article-line' }}"></i>
            {{ $catLabels[$post->category] ?? ucfirst($post->category) }}
          </span>
        </div>
        <div class="blog-card-body">
          <h3 class="blog-card-title">
            <a href="{{ url('blog/' . $post->slug) }}" class="hover:text-purple-300 transition-colors">
              {{ $post->title }}
            </a>
          </h3>
          @if($post->excerpt)
          <p class="blog-card-excerpt">{{ Str::limit($post->excerpt, 120) }}</p>
          @endif
          <div class="blog-card-footer">
            <span class="read-time"><i class="ri-time-line"></i> {{ $readTime($post->content) }} min read</span>
            <span class="read-time">{{ $post->created_at->format('M d, Y') }}</span>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    @else
    <!-- Empty state -->
    <div class="text-center py-24">
      <div class="text-6xl mb-6">📝</div>
      <h3 class="text-2xl font-bold text-white mb-3">No articles yet</h3>
      <p class="text-sm text-white/35">Check back soon — we're working on some great content.</p>
    </div>
    @endif

    <!-- No search results -->
    <div id="noBlogResults" class="text-center py-16">
      <div class="text-5xl mb-4">📭</div>
      <h3 class="text-xl font-bold mb-3 text-white">No articles found</h3>
      <p class="text-sm text-white/35 mb-6">Try a different keyword or browse by category.</p>
      <button onclick="resetBlog()" class="btn-secondary"><i class="ri-refresh-line"></i> Clear search</button>
    </div>

  </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="{{ asset('assets/js/distortion.js') }}"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
<script>
setActivePage('blog');

document.querySelectorAll('.blog-cat-pill').forEach(pill => {
  pill.addEventListener('click', () => {
    document.querySelectorAll('.blog-cat-pill').forEach(p => p.classList.remove('active'));
    pill.classList.add('active');
    const cat = pill.dataset.cat;
    let shown = 0;
    const feat = document.getElementById('featuredPost');
    if (feat) { const match = cat === 'all' || feat.dataset.cat === cat; feat.style.display = match ? '' : 'none'; }
    document.querySelectorAll('#blogGrid .blog-card-item').forEach(card => {
      const match = cat === 'all' || card.dataset.cat === cat;
      card.style.display = match ? '' : 'none';
      if (match) shown++;
    });
    document.getElementById('noBlogResults')?.classList.toggle('show', shown === 0);
  });
});

function doBlogSearch() {
  const q = document.getElementById('blogSearch').value.toLowerCase().trim();
  let shown = 0;
  const feat = document.getElementById('featuredPost');
  if (feat) { feat.style.display = (!q || feat.textContent.toLowerCase().includes(q)) ? '' : 'none'; }
  document.querySelectorAll('#blogGrid .blog-card-item').forEach(card => {
    const match = !q || card.textContent.toLowerCase().includes(q);
    card.style.display = match ? '' : 'none';
    if (match) shown++;
  });
  document.getElementById('noBlogResults')?.classList.toggle('show', shown === 0 && !!q);
}
document.getElementById('blogSearch')?.addEventListener('input', doBlogSearch);
document.getElementById('blogSearchBtn')?.addEventListener('click', doBlogSearch);
document.getElementById('blogSearch')?.addEventListener('keydown', e => { if (e.key === 'Enter') doBlogSearch(); });

function resetBlog() {
  document.getElementById('blogSearch').value = '';
  doBlogSearch();
  document.querySelectorAll('.blog-cat-pill').forEach(p => p.classList.remove('active'));
  document.querySelector('[data-cat="all"]')?.classList.add('active');
  const feat = document.getElementById('featuredPost');
  if (feat) feat.style.display = '';
  document.querySelectorAll('#blogGrid .blog-card-item').forEach(c => c.style.display = '');
}
</script>
@endsection