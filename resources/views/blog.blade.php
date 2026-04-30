@extends('layouts.app')
@section('content')


<script>tailwind.config={theme:{extend:{colors:{primary:'#7c3aed',secondary:'#06b6d4',accent:'#10b981',dark:'#030014',surface:'#0a0a1f',card:'#0f0f2a'},fontFamily:{sans:['Inter','system-ui','sans-serif']}}}}}</script>
<style>
  /* ---- BLOG PAGE STYLES ---- */

  /* Category Filter Pills */
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

  /* Featured Post */
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
  .blog-featured-img {
    width: 100%; height: 340px; object-fit: cover;
    transition: transform .7s cubic-bezier(.16,1,.3,1);
    display: block;
  }
  .blog-featured:hover .blog-featured-img { transform: scale(1.04); }
  .blog-featured-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(3,0,20,.95) 0%, rgba(3,0,20,.5) 50%, transparent 100%);
  }
  .blog-featured-body { position: absolute; bottom: 0; left: 0; right: 0; padding: 32px 36px; }

  /* Blog Card */
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
  .blog-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(124,58,237,.5), transparent);
    opacity: 0;
    transition: opacity .4s;
  }
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

  /* Category Badge */
  .cat-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 12px; border-radius: 100px;
    font-size: .68rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .06em;
  }
  .cat-badge.savings   { background: rgba(16,185,129,.12); color: #6ee7b7; border: 1px solid rgba(16,185,129,.2); }
  .cat-badge.tips      { background: rgba(124,58,237,.12); color: #c4b5fd; border: 1px solid rgba(124,58,237,.2); }
  .cat-badge.guide     { background: rgba(6,182,212,.12); color: #67e8f9; border: 1px solid rgba(6,182,212,.2); }
  .cat-badge.news      { background: rgba(245,158,11,.1); color: #fcd34d; border: 1px solid rgba(245,158,11,.2); }
  .cat-badge.finance   { background: rgba(239,68,68,.1); color: #fca5a5; border: 1px solid rgba(239,68,68,.2); }

  /* Reading Time */
  .read-time { display: inline-flex; align-items: center; gap: 5px; font-size: .72rem; font-weight: 600; color: rgba(255,255,255,.3); }

  /* Author chip */
  .author-chip { display: flex; align-items: center; gap: 8px; }
  .author-avatar {
    width: 28px; height: 28px; border-radius: 50%;
    background: linear-gradient(135deg,#7c3aed,#06b6d4);
    display: flex; align-items: center; justify-content: center;
    font-size: .62rem; font-weight: 800; color: #fff; flex-shrink: 0;
  }
  .author-name { font-size: .75rem; font-weight: 600; color: rgba(255,255,255,.45); }

  /* Blog Grid shimmer loader */
  @keyframes blogShimmer { 0%{opacity:.4} 50%{opacity:1} 100%{opacity:.4} }
  .blog-card-skeleton { animation: blogShimmer 1.6s ease-in-out infinite; }

  /* Newsletter inline */
  .blog-nl-wrap {
    background: linear-gradient(135deg, rgba(124,58,237,.1), rgba(6,182,212,.06));
    border: 1px solid rgba(124,58,237,.18);
    border-radius: 24px; padding: 44px 40px;
    position: relative; overflow: hidden;
  }
  .blog-nl-wrap::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; bottom: 0;
    background: radial-gradient(ellipse at 80% 20%, rgba(124,58,237,.12), transparent 60%),
                radial-gradient(ellipse at 20% 80%, rgba(6,182,212,.08), transparent 60%);
    pointer-events: none;
  }

  /* Trending sidebar */
  .trending-item {
    display: flex; gap: 14px; align-items: flex-start;
    padding: 14px 0; border-bottom: 1px solid rgba(255,255,255,.05);
    transition: all .3s; cursor: pointer; text-decoration: none;
  }
  .trending-item:last-child { border-bottom: none; padding-bottom: 0; }
  .trending-item:hover .trending-title { color: #c4b5fd; }
  .trending-num { font-size: 1.6rem; font-weight: 900; color: rgba(124,58,237,.2); line-height: 1; width: 32px; flex-shrink: 0; font-variant-numeric: tabular-nums; }
  .trending-title { font-size: .82rem; font-weight: 600; color: rgba(255,255,255,.6); line-height: 1.5; transition: color .3s; }

  /* Load More */
  .load-more-wrap { text-align: center; padding-top: 48px; }
  @keyframes spinPulse { 0%,100%{transform:rotate(0deg) scale(1)} 50%{transform:rotate(180deg) scale(1.1)} }
  .load-more-spinner { animation: spinPulse .8s ease-in-out infinite; }

  /* Stats bar */
  .blog-stats-bar {
    display: flex; align-items: center; gap: 32px; flex-wrap: wrap;
    padding: 20px 28px; border-radius: 16px;
    background: rgba(255,255,255,.02); border: 1px solid rgba(255,255,255,.06);
  }
  .blog-stat-item { display: flex; align-items: center; gap: 8px; }
  .blog-stat-num { font-size: 1.1rem; font-weight: 800; color: #fff; }
  .blog-stat-label { font-size: .72rem; font-weight: 600; color: rgba(255,255,255,.35); }

  /* Tag cloud */
  .tag-cloud-item {
    display: inline-flex; align-items: center;
    padding: 6px 14px; border-radius: 10px;
    font-size: .72rem; font-weight: 600;
    background: rgba(255,255,255,.03); border: 1px solid rgba(255,255,255,.07);
    color: rgba(255,255,255,.4); cursor: pointer; transition: all .3s; text-decoration: none;
  }
  .tag-cloud-item:hover { background: rgba(124,58,237,.1); border-color: rgba(124,58,237,.25); color: #c4b5fd; }

  /* No results */
  #noBlogResults { display: none; }
  #noBlogResults.show { display: block; }

  /* Stagger delay for cards */
  .blog-card-item:nth-child(1) { --d:0s } .blog-card-item:nth-child(2) { --d:.07s }
  .blog-card-item:nth-child(3) { --d:.14s } .blog-card-item:nth-child(4) { --d:.21s }
  .blog-card-item:nth-child(5) { --d:.28s } .blog-card-item:nth-child(6) { --d:.35s }
  .blog-card-item.reveal { transition-delay: var(--d, 0s); }
</style>

<!-- ===================== HERO ===================== -->
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
    <!-- Search Bar -->
    <div class="relative reveal" data-delay="2" style="max-width:520px;margin:20px auto">
      <i class="ri-search-line absolute left-4 top-1/2 -translate-y-1/2 text-white/30 text-base z-10"></i>
      <input type="text" id="blogSearch" placeholder="Search articles, tips, guides…" class="auth-input !pl-12 !text-base !pr-32">
      <button class="absolute right-2 top-1/2 -translate-y-1/2 btn-primary !py-2 !px-4 text-xs !rounded-xl" id="blogSearchBtn">
        Search
      </button>
    </div>
  </div>
</section>

<!-- ===================== MAIN CONTENT ===================== -->
<section class="relative py-20 section-dark ">
  <div class="max-w-7xl mx-auto px-6 lg:px-8">
    <div class="flex flex-col xl:flex-row gap-12">

      <!-- LEFT COLUMN — Main blog content -->
      <div class="flex-1 min-w-0">

        <!-- Category Filter -->
        <div class="flex items-center gap-3 overflow-x-auto pb-3 mb-10 reveal" style="scrollbar-width:none" id="blogCatFilter">
          <button class="blog-cat-pill active" data-cat="all">All</button>
          <button class="blog-cat-pill" data-cat="savings"><i class="ri-money-dollar-circle-line"></i> Savings</button>
          <button class="blog-cat-pill" data-cat="tips"><i class="ri-lightbulb-flash-line"></i> Tips &amp; Tricks</button>
          <button class="blog-cat-pill" data-cat="guide"><i class="ri-map-2-line"></i> Guides</button>
          <button class="blog-cat-pill" data-cat="news"><i class="ri-newspaper-line"></i> News</button>
          <button class="blog-cat-pill" data-cat="finance"><i class="ri-line-chart-line"></i> Finance</button>
        </div>

        <!-- Featured Post -->
        <div class="mb-12 reveal" id="featuredPost" data-cat="guide">
          <a href="blog-detail" class="blog-featured">
            <div style="overflow:hidden;height:340px">
              <img src="https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=1200&q=80" alt="Featured" class="blog-featured-img">
            </div>
            <div class="blog-featured-overlay"></div>
            <div class="blog-featured-body">
              <div class="flex items-center gap-3 mb-3">
                <span class="cat-badge guide"><i class="ri-map-2-line"></i> Guide</span>
                <span class="read-time"><i class="ri-time-line"></i> 8 min read</span>
                <span class="read-time"><i class="ri-fire-line text-orange-400"></i> Featured</span>
              </div>
              <h2 class="text-2xl md:text-3xl font-black text-white leading-tight mb-3 hover:text-purple-300 transition-colors" style="max-width:700px">
                The Ultimate Guide to Never Overpaying for Insurance Again
              </h2>
              <p class="text-sm text-white/55 leading-relaxed mb-4" style="max-width:600px">
                Most people auto-renew without comparing. Here's a step-by-step system for tracking every policy, setting reminders, and switching providers at exactly the right moment.
              </p>
              <div class="flex items-center justify-between flex-wrap gap-3">
                <div class="author-chip">
                  <div class="author-avatar">SR</div>
                  <div>
                    <div class="author-name">Sarah Reynolds</div>
                    <div class="read-time" style="margin-top:1px">April 14, 2026</div>
                  </div>
                </div>
                <span class="btn-secondary !py-2 !px-4 !text-xs !rounded-xl" style="pointer-events:none">
                  Read Article <i class="ri-arrow-right-line"></i>
                </span>
              </div>
            </div>
          </a>
        </div>

        <!-- Blog Grid -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-6" id="blogGrid">

          <!-- Card 1 -->
          <div class="blog-card blog-card-item reveal" data-cat="savings">
            <div class="blog-card-img-wrap">
              <img src="https://images.unsplash.com/photo-1579621970563-ebec7560ff3e?w=600&q=80" alt="" class="blog-card-img">
              <div class="blog-card-img-overlay"></div>
              <span class="cat-badge savings absolute bottom-3 left-4"><i class="ri-money-dollar-circle-line"></i> Savings</span>
            </div>
            <div class="blog-card-body">
              <h3 class="blog-card-title"><a href="blog-detail" class="hover:text-purple-300 transition-colors">5 Subscriptions You're Probably Paying for and Forgetting</a></h3>
              <p class="blog-card-excerpt">From streaming services to forgotten gym memberships — we break down the sneaky charges draining your bank account every month.</p>
              <div class="blog-card-footer">
                <div class="author-chip">
                  <div class="author-avatar" style="background:linear-gradient(135deg,#10b981,#06b6d4)">JM</div>
                  <div class="author-name">James Morton</div>
                </div>
                <span class="read-time"><i class="ri-time-line"></i> 4 min</span>
              </div>
            </div>
          </div>

          <!-- Card 2 -->
          <div class="blog-card blog-card-item reveal" data-cat="tips">
            <div class="blog-card-img-wrap">
              <img src="https://images.unsplash.com/photo-1611532736597-de2d4265fba3?w=600&q=80" alt="" class="blog-card-img">
              <div class="blog-card-img-overlay"></div>
              <span class="cat-badge tips absolute bottom-3 left-4"><i class="ri-lightbulb-flash-line"></i> Tips</span>
            </div>
            <div class="blog-card-body">
              <h3 class="blog-card-title"><a href="blog-detail" class="hover:text-purple-300 transition-colors">How to Set Up Your First 90-Day Expiry Reminder</a></h3>
              <p class="blog-card-excerpt">Getting started with DRemind takes under 2 minutes. Here's the exact setup flow to protect all your renewals from day one.</p>
              <div class="blog-card-footer">
                <div class="author-chip">
                  <div class="author-avatar" style="background:linear-gradient(135deg,#7c3aed,#a78bfa)">PK</div>
                  <div class="author-name">Priya Kapoor</div>
                </div>
                <span class="read-time"><i class="ri-time-line"></i> 3 min</span>
              </div>
            </div>
          </div>

          <!-- Card 3 -->
          <div class="blog-card blog-card-item reveal" data-cat="finance">
            <div class="blog-card-img-wrap">
              <img src="https://images.unsplash.com/photo-1526304640581-d334cdbbf45e?w=600&q=80" alt="" class="blog-card-img">
              <div class="blog-card-img-overlay"></div>
              <span class="cat-badge finance absolute bottom-3 left-4"><i class="ri-line-chart-line"></i> Finance</span>
            </div>
            <div class="blog-card-body">
              <h3 class="blog-card-title"><a href="blog-detail" class="hover:text-purple-300 transition-colors">Why Auto-Renewal is Costing Australians $4B a Year</a></h3>
              <p class="blog-card-excerpt">New data reveals the staggering cost of passive subscription behaviour — and the simple habit change that can fix it.</p>
              <div class="blog-card-footer">
                <div class="author-chip">
                  <div class="author-avatar" style="background:linear-gradient(135deg,#ef4444,#f97316)">TW</div>
                  <div class="author-name">Tom Walsh</div>
                </div>
                <span class="read-time"><i class="ri-time-line"></i> 6 min</span>
              </div>
            </div>
          </div>

          <!-- Card 4 -->
          <div class="blog-card blog-card-item reveal" data-cat="news">
            <div class="blog-card-img-wrap">
              <img src="https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=600&q=80" alt="" class="blog-card-img">
              <div class="blog-card-img-overlay"></div>
              <span class="cat-badge news absolute bottom-3 left-4"><i class="ri-newspaper-line"></i> News</span>
            </div>
            <div class="blog-card-body">
              <h3 class="blog-card-title"><a href="blog-detail" class="hover:text-purple-300 transition-colors">DRemind Launches Family Sharing — Protect the Whole Household</a></h3>
              <p class="blog-card-excerpt">Our most requested feature is finally here. Pro users can now add up to 5 family members and share reminder management across accounts.</p>
              <div class="blog-card-footer">
                <div class="author-chip">
                  <div class="author-avatar" style="background:linear-gradient(135deg,#06b6d4,#7c3aed)">DT</div>
                  <div class="author-name">DRemind Team</div>
                </div>
                <span class="read-time"><i class="ri-time-line"></i> 2 min</span>
              </div>
            </div>
          </div>

          <!-- Card 5 -->
          <div class="blog-card blog-card-item reveal" data-cat="savings">
            <div class="blog-card-img-wrap">
              <img src="https://images.unsplash.com/photo-1450101499163-c8848c66ca85?w=600&q=80" alt="" class="blog-card-img">
              <div class="blog-card-img-overlay"></div>
              <span class="cat-badge savings absolute bottom-3 left-4"><i class="ri-money-dollar-circle-line"></i> Savings</span>
            </div>
            <div class="blog-card-body">
              <h3 class="blog-card-title"><a href="blog-detail" class="hover:text-purple-300 transition-colors">Car Insurance: The Loyalty VATand How to Escape It</a></h3>
              <p class="blog-card-excerpt">Staying with the same insurer can cost you 23% more than switching. Here's how to time your renewal comparison perfectly.</p>
              <div class="blog-card-footer">
                <div class="author-chip">
                  <div class="author-avatar" style="background:linear-gradient(135deg,#10b981,#7c3aed)">SR</div>
                  <div class="author-name">Sarah Reynolds</div>
                </div>
                <span class="read-time"><i class="ri-time-line"></i> 5 min</span>
              </div>
            </div>
          </div>

          <!-- Card 6 -->
          <div class="blog-card blog-card-item reveal" data-cat="guide">
            <div class="blog-card-img-wrap">
              <img src="https://images.unsplash.com/photo-1542621334-a254cf47733d?w=600&q=80" alt="" class="blog-card-img">
              <div class="blog-card-img-overlay"></div>
              <span class="cat-badge guide absolute bottom-3 left-4"><i class="ri-map-2-line"></i> Guide</span>
            </div>
            <div class="blog-card-body">
              <h3 class="blog-card-title"><a href="blog-detail" class="hover:text-purple-300 transition-colors">Passport Renewal Checklist: Start 6 Months Early</a></h3>
              <p class="blog-card-excerpt">Missing a passport expiry is more common than you think. Our checklist walks you through every step of renewal for UK, AU, and US citizens.</p>
              <div class="blog-card-footer">
                <div class="author-chip">
                  <div class="author-avatar" style="background:linear-gradient(135deg,#f59e0b,#ef4444)">AM</div>
                  <div class="author-name">Amy Nguyen</div>
                </div>
                <span class="read-time"><i class="ri-time-line"></i> 7 min</span>
              </div>
            </div>
          </div>

        </div><!-- /blogGrid -->

        <!-- No results -->
        <div id="noBlogResults" class="text-center py-16">
          <div class="text-5xl mb-4">📭</div>
          <h3 class="text-xl font-bold mb-3 text-white">No articles found</h3>
          <p class="text-sm text-white/35 mb-6">Try a different keyword or browse by category.</p>
          <button onclick="resetBlog()" class="btn-secondary"><i class="ri-refresh-line"></i> Clear search</button>
        </div>

        <!-- Load More -->
        <div class="load-more-wrap reveal">
          <button class="btn-secondary gap-3" id="loadMoreBtn" onclick="loadMore()">
            <i class="ri-refresh-line text-lg" id="loadMoreIcon"></i>
            Load more articles
          </button>
          <p class="text-xs text-white/25 mt-4">Showing 6 of 48 articles</p>
        </div>

      </div><!-- /left col -->

      <!-- RIGHT SIDEBAR -->
      <div class="xl:w-[320px] flex-shrink-0">
        <div class="sticky top-24 flex flex-col gap-8">

          <!-- Trending -->
          <div class="glass rounded-2xl p-6 reveal">
            <div class="flex items-center gap-3 mb-5">
              <div class="w-8 h-8 rounded-xl bg-orange-500/15 flex items-center justify-center text-sm text-orange-400">
                <i class="ri-fire-line"></i>
              </div>
              <h4 class="font-bold text-white text-sm">Trending This Week</h4>
            </div>
            <a href="blog-detail" class="trending-item">
              <span class="trending-num">01</span>
              <div><div class="trending-title">Why Most People Miss Their Energy Plan Renewal Window</div><span class="read-time"><i class="ri-time-line"></i> 4 min</span></div>
            </a>
            <a href="blog-detail" class="trending-item">
              <span class="trending-num">02</span>
              <div><div class="trending-title">The Complete Home Insurance Switching Guide 2026</div><span class="read-time"><i class="ri-time-line"></i> 9 min</span></div>
            </a>
            <a href="blog-detail" class="trending-item">
              <span class="trending-num">03</span>
              <div><div class="trending-title">5 Subscriptions You're Paying For and Forgetting</div><span class="read-time"><i class="ri-time-line"></i> 4 min</span></div>
            </a>
            <a href="blog-detail" class="trending-item">
              <span class="trending-num">04</span>
              <div><div class="trending-title">Passport Renewal Checklist: Start 6 Months Early</div><span class="read-time"><i class="ri-time-line"></i> 7 min</span></div>
            </a>
          </div>

          <!-- Newsletter -->
          <div class="hidden glass rounded-2xl p-6 reveal" style="background:linear-gradient(135deg,rgba(124,58,237,.08),rgba(6,182,212,.05));border-color:rgba(124,58,237,.18)">
            <div class="w-10 h-10 rounded-xl bg-primary/15 flex items-center justify-center text-purple-400 text-lg mb-4">
              <i class="ri-mail-send-line"></i>
            </div>
            <h4 class="font-bold text-white mb-2">Weekly Money Tips</h4>
            <p class="text-xs text-white/40 leading-relaxed mb-4">Join 12,000+ readers getting one actionable saving tip every Thursday.</p>
            <input type="email" placeholder="Your email address" class="auth-input mb-3 !text-sm">
            <button class="auth-submit-dark !text-sm !py-3">Subscribe Free <i class="ri-arrow-right-line"></i></button>
            <p class="text-xs text-white/25 mt-3 text-center">No spam. Unsubscribe anytime.</p>
          </div>

          <!-- Tags -->
          <div class="glass rounded-2xl p-6 reveal">
            <div class="flex items-center gap-3 mb-5">
              <div class="w-8 h-8 rounded-xl bg-emerald-500/15 flex items-center justify-center text-sm text-emerald-400"><i class="ri-hashtag"></i></div>
              <h4 class="font-bold text-white text-sm">Popular Tags</h4>
            </div>
            <div class="flex flex-wrap gap-2">
              <a href="#" class="tag-cloud-item">#insurance</a>
              <a href="#" class="tag-cloud-item">#savings</a>
              <a href="#" class="tag-cloud-item">#subscriptions</a>
              <a href="#" class="tag-cloud-item">#energy</a>
              <a href="#" class="tag-cloud-item">#reminders</a>
              <a href="#" class="tag-cloud-item">#passport</a>
              <a href="#" class="tag-cloud-item">#budgeting</a>
              <a href="#" class="tag-cloud-item">#renewal</a>
              <a href="#" class="tag-cloud-item">#telecom</a>
              <a href="#" class="tag-cloud-item">#car</a>
            </div>
          </div>

        </div>
      </div>

    </div><!-- /flex -->
  </div>
</section>

<!-- ===================== NEWSLETTER CTA ===================== -->
<!-- <section class="relative py-28 section-dark overflow-hidden text-center">
  <div class="gradient-blob w-[500px] h-[500px] bg-primary top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 !opacity-10"></div>
    <div id="grid-distortion-container" style="width: 100%; top: 0; height: 100%; position: absolute;"></div>
    <div class="relative z-10 max-w-8xl w-[fit-content] mx-auto px-6">
      <div class="max-w-[860px] mx-auto px-6">
        <div class="blog-nl-wrap reveal">
            <div class="flex flex-col md:flex-row items-center gap-8 relative z-10">
                <div class="flex-1">
                <div class="badge bg-primary/10 border border-primary/20 text-purple-300 mb-4 w-fit">
                    <span class="w-2 h-2 rounded-full bg-primary"></span> Free Weekly Newsletter
                </div>
                <h2 class="text-2xl md:text-3xl font-black text-white leading-tight mb-3">
                    Never miss a money-saving <span class="grad-text">insight again.</span>
                </h2>
                <p class="text-sm text-white/45 leading-relaxed">
                    One practical tip, every Thursday. Read by 12,000 smart households in AU, UK, NZ &amp; more.
                </p>
                </div>
                <div class="w-full md:w-[320px] flex-shrink-0">
                    <div class="flex flex-col gap-3">
                        <input type="email" placeholder="Enter your email" class="auth-input">
                        <button class="auth-submit-dark">Get Weekly Tips <i class="ri-mail-send-line ml-1"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

  </div>
</section> -->


<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="{{ asset('assets/js/distortion.js') }}"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
<script>
setActivePage('blog');

/* ---- Category Filter ---- */
document.querySelectorAll('.blog-cat-pill').forEach(pill => {
  pill.addEventListener('click', () => {
    document.querySelectorAll('.blog-cat-pill').forEach(p => p.classList.remove('active'));
    pill.classList.add('active');
    const cat = pill.dataset.cat;
    let shown = 0;
    // Featured
    const feat = document.getElementById('featuredPost');
    if (feat) {
      const match = cat === 'all' || feat.dataset.cat === cat;
      feat.style.display = match ? '' : 'none';
    }
    document.querySelectorAll('#blogGrid .blog-card-item').forEach(card => {
      const match = cat === 'all' || card.dataset.cat === cat;
      card.style.display = match ? '' : 'none';
      if (match) shown++;
    });
    const noRes = document.getElementById('noBlogResults');
    if (noRes) noRes.classList.toggle('show', shown === 0);
  });
});

/* ---- Search ---- */
function doBlogSearch() {
  const q = document.getElementById('blogSearch').value.toLowerCase().trim();
  let shown = 0;
  const feat = document.getElementById('featuredPost');
  if (feat) {
    const match = !q || feat.textContent.toLowerCase().includes(q);
    feat.style.display = match ? '' : 'none';
  }
  document.querySelectorAll('#blogGrid .blog-card-item').forEach(card => {
    const match = !q || card.textContent.toLowerCase().includes(q);
    card.style.display = match ? '' : 'none';
    if (match) shown++;
  });
  const noRes = document.getElementById('noBlogResults');
  if (noRes) noRes.classList.toggle('show', shown === 0 && !!q);
}
document.getElementById('blogSearch')?.addEventListener('input', doBlogSearch);
document.getElementById('blogSearchBtn')?.addEventListener('click', doBlogSearch);
document.getElementById('blogSearch')?.addEventListener('keydown', e => { if(e.key==='Enter') doBlogSearch(); });

function resetBlog() {
  document.getElementById('blogSearch').value = '';
  doBlogSearch();
  document.querySelectorAll('.blog-cat-pill').forEach(p => p.classList.remove('active'));
  document.querySelector('[data-cat="all"]')?.classList.add('active');
}

/* ---- Load More (demo) ---- */
function loadMore() {
  const btn = document.getElementById('loadMoreBtn');
  const icon = document.getElementById('loadMoreIcon');
  btn.disabled = true;
  icon.classList.add('load-more-spinner');
  setTimeout(() => {
    icon.classList.remove('load-more-spinner');
    btn.disabled = false;
    // In production: fetch and append new cards
    btn.textContent = '✓ All articles loaded';
    btn.disabled = true;
  }, 1500);
}
</script>
@endsection
