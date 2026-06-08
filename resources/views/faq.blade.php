<script>tailwind.config={theme:{extend:{colors:{primary:'#7c3aed',secondary:'#06b6d4',accent:'#10b981',dark:'#030014',surface:'#0a0a1f',card:'#0f0f2a'},fontFamily:{sans:['Inter','system-ui','sans-serif']}}}}</script>
<style>
.faq-cat-tab{padding:9px 18px;border-radius:10px;font-size:.82rem;font-weight:600;color:rgba(255,255,255,.3);cursor:pointer;border:1px solid transparent;background:transparent;transition:all .3s;white-space:nowrap;font-family:'Inter',sans-serif}
.faq-cat-tab.active{background:rgba(124,58,237,.12);color:#c4b5fd;border-color:rgba(124,58,237,.25)}
.faq-section-group{display:none}.faq-section-group.show{display:block}
</style>
@extends('layouts.app')
@section('content')


<section class="page-hero-dark section-alt relative" data-particles="purple" data-p-count="40" data-p-connect="false">
  <div class="gradient-blob w-[400px] h-[400px] bg-primary top-[-20%] left-[20%]"></div>
  <div class="max-w-[800px] mx-auto px-6 relative z-10">
    <div class="page-breadcrumb"><a href="index">Home</a><span class="sep">/</span><span>FAQ</span></div>
    <div class="badge bg-primary/10 border border-primary/20 text-purple-300 mx-auto mb-6 w-fit reveal"><span class="w-2 h-2 rounded-full bg-primary"></span> Frequently Asked Questions</div>
    <h1 class="reveal">Got questions? <span class="grad-text">We've got answers.</span></h1>
    <p class="reveal mb-8" data-delay="1">Everything you need to know about DRemind — from getting started to managing your account.</p>
    <div class="relative reveal" data-delay="2" style="max-width:500px;margin:0 auto">
      <i class="ri-search-line absolute left-4 top-1/2 -translate-y-1/2 text-white/30 text-base z-10"></i>
      <input type="text" id="faqSearch" placeholder="Search questions..." class="auth-input !pl-12 !text-base">
    </div>
  </div>
</section>

<section class="relative py-20 section-dark overflow-hidden">
  <div class="max-w-[860px] mx-auto px-6 lg:px-8">
    <!-- Category Tabs -->
    <div class="flex gap-2 overflow-x-auto pb-2 mb-10 reveal" id="faqTabs" style="scrollbar-width:none">
    <button class="faq-cat-tab active" data-cat="all">All Questions</button>
    @foreach($categories as $cat)
        <button class="faq-cat-tab" data-cat="{{ $cat->slug }}">{{ $cat->name }}</button>
    @endforeach
</div>

   <div id="faqContainer">
    @forelse($categories as $category)
        @if($category->faqs->count())
        <div data-category="{{ $category->slug }}" class="mb-10 faq-section-group show">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-sm"
                    style="background:{{ $category->color }}22;color:{{ $category->color }}">
                    <i class="{{ $category->icon }}"></i>
                </div>
                <h3 class="text-lg font-bold text-white">{{ $category->name }}</h3>
            </div>
            <div class="faq-group-dark flex flex-col gap-2">
                @foreach($category->faqs as $faq)
                <div class="faq-item-dark">
                    <div class="faq-question-dark">
                        {{ $faq->question }}
                        <i class="ri-add-line faq-icon-dark"></i>
                    </div>
                    <div class="faq-answer-dark">
                        <p class="text-sm text-white/40 leading-relaxed">
                            {!! nl2br(e($faq->answer)) !!}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    @empty
        <div class="text-center py-16">
            <p class="text-white/40">No FAQs available yet.</p>
        </div>
    @endforelse
</div>

    <div id="noFaqResults" class="hidden text-center py-16">
      <div class="text-5xl mb-4">🤔</div>
      <h3 class="text-xl font-bold mb-3 text-white">No results found</h3>
      <p class="text-sm text-white/35 mb-6">Try different keywords or contact us directly.</p>
      <a href="contact" class="btn-secondary"><i class="ri-mail-line"></i> Ask us directly</a>
    </div>
  </div>
</section>

<!-- <section class="relative py-20 section-alt overflow-hidden text-center">
  <div id="grid-distortion-container" style="width: 100%; top: 0; height: 100%; position: absolute;"></div>

  <div class="max-w-[700px] mx-auto px-6">
    <div class="badge bg-secondary/10 border border-secondary/20 text-cyan-300 mx-auto mb-6 w-fit reveal"><span class="w-2 h-2 rounded-full bg-secondary"></span> Still Need Help?</div>
    <h2 class="text-3xl md:text-4xl font-black text-white mb-4 reveal" data-delay="1">Can't find what you're <span class="grad-text-alt">looking for?</span></h2>
    <p class="text-base text-white/80 mb-8 reveal" data-delay="2">Our support team typically responds within a few hours.</p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center reveal" data-delay="3">
      <a href="contact" class="btn-primary"><i class="ri-mail-line text-xl"></i>Contact Support</a>
      <a href="register" class="btn-secondary">Try for  <i class="ri-arrow-right-line"></i></a>
    </div>
  </div>
</section> -->

<!-- Distortion Animation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="{{ asset('assets/js/distortion.js') }}"></script>

<script src="{{ asset('assets/js/script.js') }}"></script>
<script>
setActivePage('faq');
document.querySelectorAll('.faq-cat-tab').forEach(tab=>{
  tab.addEventListener('click',()=>{
    document.querySelectorAll('.faq-cat-tab').forEach(t=>t.classList.remove('active'));
    tab.classList.add('active');
    const cat=tab.dataset.cat;
    document.querySelectorAll('#faqContainer > div[data-category]').forEach(s=>{
      s.classList.toggle('show',cat==='all'||s.dataset.category===cat);
    });
  });
});
document.getElementById('faqSearch')?.addEventListener('input',function(){
  const q=this.value.toLowerCase().trim();
  let found=0;
  document.querySelectorAll('.faq-item-dark').forEach(item=>{
    const match=!q||item.textContent.toLowerCase().includes(q);
    item.style.display=match?'':'none';
    if(match)found++;
  });
  document.querySelectorAll('#faqContainer > div[data-category]').forEach(s=>{
    s.classList.toggle('show',s.querySelectorAll('.faq-item-dark:not([style*="display: none"])').length>0);
  });
  document.getElementById('noFaqResults').classList.toggle('hidden',found>0||!q);
  document.getElementById('faqContainer').style.display=(found>0||!q)?'':'none';
});
</script>

@endsection
