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
      <button class="faq-cat-tab" data-cat="general">General</button>
      <button class="faq-cat-tab" data-cat="account">Account</button>
      <button class="faq-cat-tab" data-cat="reminders">Reminders</button>
      <button class="faq-cat-tab" data-cat="pricing">Pricing</button>
      <button class="faq-cat-tab" data-cat="privacy">Privacy</button>
    </div>

    <div id="faqContainer">
      <div data-category="general" class="mb-10 faq-section-group show">
        <div class="flex items-center gap-3 mb-5"><div class="w-10 h-10 rounded-xl bg-primary/15 flex items-center justify-center text-sm text-purple-400"><i class="ri-information-line"></i></div><h3 class="text-lg font-bold text-white">General</h3></div>
        <div class="faq-group-dark flex flex-col gap-2">
          <div class="faq-item-dark"><div class="faq-question-dark">What is DRemind?<i class="ri-add-line faq-icon-dark"></i></div><div class="faq-answer-dark"><p class="text-sm text-white/40 leading-relaxed">DRemind is a smart reminder web app that tracks expiry dates for your insurance, utility plans, subscriptions, vehicle registrations, passports, and more. It sends you timely alerts so you always have time to compare prices and switch to better deals before auto-renewals kick in.</p></div></div>
          <div class="faq-item-dark"><div class="faq-question-dark">Who is DRemind for?<i class="ri-add-line faq-icon-dark"></i></div><div class="faq-answer-dark"><p class="text-sm text-white/40 leading-relaxed">DRemind is for anyone who wants to stay on top of recurring expenses. Homeowners, renters, families, business owners, and frequent travellers all find it incredibly useful for avoiding overpayment and missed renewals.</p></div></div>
          <div class="faq-item-dark"><div class="faq-question-dark">Which countries does DRemind support?<i class="ri-add-line faq-icon-dark"></i></div><div class="faq-answer-dark"><p class="text-sm text-white/40 leading-relaxed">DRemind is available in Australia, New Zealand, United States, United Kingdom, Canada, Ireland, India, and Singapore. We're fully compliant with local privacy laws in each country including GDPR, CCPA, and the Australian Privacy Act.</p></div></div>
          <div class="faq-item-dark"><div class="faq-question-dark">How much money can I save?<i class="ri-add-line faq-icon-dark"></i></div><div class="faq-answer-dark"><p class="text-sm text-white/40 leading-relaxed">Our users save an average of $2,847 per year by switching to better deals across insurance, energy, telecom, and subscriptions. Even saving on one renewal can pay off significantly.</p></div></div>
        </div>
      </div>

      <div data-category="account" class="mb-10 faq-section-group show">
        <div class="flex items-center gap-3 mb-5"><div class="w-10 h-10 rounded-xl bg-accent/15 flex items-center justify-center text-sm text-emerald-400"><i class="ri-user-line"></i></div><h3 class="text-lg font-bold text-white">Account &amp; Access</h3></div>
        <div class="faq-group-dark flex flex-col gap-2">
          <div class="faq-item-dark"><div class="faq-question-dark">How do I create an account?<i class="ri-add-line faq-icon-dark"></i></div><div class="faq-answer-dark"><p class="text-sm text-white/40 leading-relaxed">Click "Register", enter your name and email, choose a password — no credit card required. Setup takes under 2 minutes.</p></div></div>
          <div class="faq-item-dark"><div class="faq-question-dark">Can I use DRemind on multiple devices?<i class="ri-add-line faq-icon-dark"></i></div><div class="faq-answer-dark"><p class="text-sm text-white/40 leading-relaxed">Yes! DRemind syncs in real time across all your devices. Access via web app from any browser, or download the iOS and Android apps.</p></div></div>
          <div class="faq-item-dark"><div class="faq-question-dark">I forgot my password. How do I reset it?<i class="ri-add-line faq-icon-dark"></i></div><div class="faq-answer-dark"><p class="text-sm text-white/40 leading-relaxed">On the login page, click "Forgot password?" and enter your email. You'll receive a reset link within a few minutes. Check your spam folder if it doesn't arrive.</p></div></div>
          <div class="faq-item-dark"><div class="faq-question-dark">How do I delete my account?<i class="ri-add-line faq-icon-dark"></i></div><div class="faq-answer-dark"><p class="text-sm text-white/40 leading-relaxed">Go to Settings → Account → Delete Account. All data will be permanently removed within 30 days. You can also email <a href="mailto:info@winngoodremind.co.uk" class="text-purple-400">info@winngoodremind.co.uk</a> to request deletion.</p></div></div>
        </div>
      </div>

      <div data-category="reminders" class="mb-10 faq-section-group show">
        <div class="flex items-center gap-3 mb-5"><div class="w-10 h-10 rounded-xl bg-secondary/15 flex items-center justify-center text-sm text-cyan-400"><i class="ri-notification-3-line"></i></div><h3 class="text-lg font-bold text-white">Reminders &amp; Alerts</h3></div>
        <div class="faq-group-dark flex flex-col gap-2">
          <div class="faq-item-dark"><div class="faq-question-dark">How do I add a reminder?<i class="ri-add-line faq-icon-dark"></i></div><div class="faq-answer-dark"><p class="text-sm text-white/40 leading-relaxed">Tap the "+" button in the dock or click "Quick Add". Enter the name, expiry date, category, and preferred alert timing. You can set alerts from 7 days to 90 days before expiry.</p></div></div>
          <div class="faq-item-dark"><div class="faq-question-dark">How will I receive my reminders?<i class="ri-add-line faq-icon-dark"></i></div><div class="faq-answer-dark"><p class="text-sm text-white/40 leading-relaxed">DRemind sends reminders via push notifications, email alerts, and in-app notifications. Choose which channels you prefer in Settings and set multiple reminders at different intervals.</p></div></div>
          <div class="faq-item-dark"><div class="faq-question-dark">Can I snooze or reschedule a reminder?<i class="ri-add-line faq-icon-dark"></i></div><div class="faq-answer-dark"><p class="text-sm text-white/40 leading-relaxed">Yes. From any notification, you can snooze for 1, 3, or 7 days. You can also edit the reminder directly to change the expiry date or alert timing at any time from your dashboard.</p></div></div>
        </div>
      </div>

      <div data-category="pricing" class="mb-10 faq-section-group show">
        <div class="flex items-center gap-3 mb-5"><div class="w-10 h-10 rounded-xl bg-yellow-500/15 flex items-center justify-center text-sm text-yellow-400"><i class="ri-price-tag-3-line"></i></div><h3 class="text-lg font-bold text-white">Pricing &amp; Plans</h3></div>
        <div class="faq-group-dark flex flex-col gap-2">
          <div class="faq-item-dark"><div class="faq-question-dark">Is DRemind really ?<i class="ri-add-line faq-icon-dark"></i></div><div class="faq-answer-dark"><p class="text-sm text-white/40 leading-relaxed">Yes! The  plan is genuinely  — no credit card, no hidden fees, no time limit. You can track up to 15 reminders and receive push and email alerts forever.</p></div></div>
          <div class="faq-item-dark"><div class="faq-question-dark">What does the Pro plan include?<i class="ri-add-line faq-icon-dark"></i></div><div class="faq-answer-dark"><p class="text-sm text-white/40 leading-relaxed">Pro ($4.99/month or $49.99/year) unlocks unlimited reminders, advanced scheduling, family sharing for up to 5 members, data export, detailed analytics, and priority support.</p></div></div>
          <div class="faq-item-dark"><div class="faq-question-dark">Can I cancel my Pro subscription anytime?<i class="ri-add-line faq-icon-dark"></i></div><div class="faq-answer-dark"><p class="text-sm text-white/40 leading-relaxed">Absolutely. Cancel anytime from Settings → Billing → Cancel Subscription. You keep Pro access until the end of your billing period. No cancellation fees.</p></div></div>
        </div>
      </div>

      <div data-category="privacy" class="mb-10 faq-section-group show">
        <div class="flex items-center gap-3 mb-5"><div class="w-10 h-10 rounded-xl bg-red-500/15 flex items-center justify-center text-sm text-red-400"><i class="ri-shield-check-line"></i></div><h3 class="text-lg font-bold text-white">Privacy &amp; Security</h3></div>
        <div class="faq-group-dark flex flex-col gap-2">
          <div class="faq-item-dark"><div class="faq-question-dark">Is my data safe with DRemind?<i class="ri-add-line faq-icon-dark"></i></div><div class="faq-answer-dark"><p class="text-sm text-white/40 leading-relaxed">Yes. We use AES-256 encryption for data at rest and TLS 1.3 for all data in transit. We undergo annual third-party security audits and are fully GDPR/CCPA/APPs compliant.</p></div></div>
          <div class="faq-item-dark"><div class="faq-question-dark">Do you sell my data to third parties?<i class="ri-add-line faq-icon-dark"></i></div><div class="faq-answer-dark"><p class="text-sm text-white/40 leading-relaxed">Never. We do not sell, rent, or share your personal data with advertisers or third parties. Our revenue comes from Pro subscriptions — your data has no part in our business model.</p></div></div>
          <div class="faq-item-dark"><div class="faq-question-dark">Can I export all my data?<i class="ri-add-line faq-icon-dark"></i></div><div class="faq-answer-dark"><p class="text-sm text-white/40 leading-relaxed">Yes.  users can export a basic CSV. Pro users can export full data as CSV, PDF, or JSON from Settings → Export. You own your data and can take it with you at any time.</p></div></div>
        </div>
      </div>
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
