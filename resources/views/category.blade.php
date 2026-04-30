<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Category — DRemind</title>
<script src="https://cdn.tailwindcss.com"></script>
<script>tailwind.config={theme:{extend:{colors:{primary:'#7c3aed',secondary:'#06b6d4',accent:'#10b981',dark:'#030014',surface:'#0a0a1f',card:'#0f0f2a'},fontFamily:{sans:['Inter','system-ui','sans-serif']}}}}</script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet">
<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>
<body>
<div id="loader"><div class="loader-ring"></div></div>
<div class="cursor-ring" id="cursorRing"></div><div class="cursor-dot" id="cursorDot"></div>
<div class="scroll-progress" id="scrollProg" style="width:0%"></div>
<button class="back-top" id="backTop"><i class="ri-arrow-up-line"></i></button>

<nav class="nav" id="mainNav">
  <div class="max-w-7xl mx-auto px-6 lg:px-8">
    <div class="flex items-center justify-between h-[76px]">
      <a href="index" class="flex items-center gap-3 z-20"><img src="https://www.vishakarex.in/assets/img/projects/d-remind.png" class="w-[160px]" alt="DRemind"></a>
      <div class="hidden md:flex items-center gap-1 nav-desktop">
        <a href="index" class="nav-link" data-page="index">Home</a>
        <a href="about" class="nav-link" data-page="about">About</a>
        <!-- <a href="category" class="nav-link" data-page="category">Category</a> -->
        <a href="faq" class="nav-link" data-page="faq">FAQ</a>
        <a href="pricing" class="nav-link" data-page="pricing">Pricing</a>
        <a href="blog" class="nav-link" data-page="blog">Blog</a>
        <a href="contact" class="nav-link" data-page="contact">Contact</a>
      </div>
      <div class="hidden md:flex items-center gap-3 nav-cta-desktop z-20">
        <a href="login" class="nav-link" data-page="login">Login</a>
        <a href="register" class="btn-primary text-sm !py-[11px] !px-6"><i class="ri-user-add-line text-base"></i>Register</a>
      </div>
      <button id="mobToggle" class="mob-toggle-btn w-10 h-10 flex flex-col items-center justify-center gap-1.5 rounded-xl border border-white/10 z-20">
        <span class="w-5 h-[1.5px] bg-white/70 rounded transition-all"></span><span class="w-5 h-[1.5px] bg-white/70 rounded transition-all"></span><span class="w-3.5 h-[1.5px] bg-white/70 rounded transition-all"></span>
      </button>
    </div>
    <div class="mob-menu" id="mobMenu"><div class="pb-6 pt-2 flex flex-col gap-1 px-2">
      <a href="index" class="nav-link block !text-base">Home</a><a href="about" class="nav-link block !text-base">About</a><a href="category" class="nav-link block !text-base">Category</a><a href="faq" class="nav-link block !text-base">FAQ</a><a href="contact" class="nav-link block !text-base">Contact</a><a href="login" class="nav-link block !text-base">Login</a>
      <a href="register" class="btn-primary text-center mt-2">Register</a>
    </div></div>
  </div>
</nav>

<section class="page-hero-dark section-alt relative" data-particles="cyan" data-p-count="50" data-p-connect="false" data-p-glow="true">
  <div class="gradient-blob w-[500px] h-[500px] bg-secondary top-[-20%] right-[5%]"></div>
  <div class="max-w-[800px] mx-auto px-6 relative z-10">
    <div class="page-breadcrumb"><a href="index">Home</a><span class="sep">/</span><span>Category</span></div>
    <div class="badge bg-secondary/10 border border-secondary/20 text-cyan-300 mx-auto mb-6 w-fit reveal"><span class="w-2 h-2 rounded-full bg-secondary"></span> Reminder Category</div>
    <h1 class="reveal">Track everything <span class="grad-text">that matters.</span></h1>
    <p class="reveal" data-delay="1">From insurance to passports — DRemind covers every expiry date you need to track, across all life features.</p>
  </div>
</section>

<section class="relative py-20 md:py-28 section-dark overflow-hidden">
  <div class="max-w-7xl mx-auto px-6 lg:px-8">
    <div class="text-center mb-14">
      <div class="badge bg-primary/10 border border-primary/20 text-purple-300 mx-auto mb-6 reveal"><span class="w-2 h-2 rounded-full bg-primary"></span> All Category</div>
      <h2 class="text-3xl md:text-4xl font-black tracking-tight text-white reveal" data-delay="1">Everything you need to <span class="grad-text-alt">track</span></h2>
      <p class="text-base text-white/35 max-w-xl mx-auto mt-4 reveal" data-delay="2">Add reminders across 8 major life features. Never pay a renewal penalty again.</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
      <div class="feature-card reveal d1 !p-7"><div class="flex items-center gap-3 mb-4"><div class="w-12 h-12 rounded-xl bg-purple-500/15 flex items-center justify-center text-xl text-purple-400"><i class="ri-shield-star-line"></i></div><div><h4 class="font-bold text-white">Insurance</h4><p class="text-[.65rem] text-white/35">Home · Car · Life · Health</p></div></div><p class="text-xs text-white/40 leading-relaxed mb-4">Get notified before your insurance renews so you can compare quotes and save hundreds.</p><div class="flex flex-wrap gap-2"><span class="text-[10px] px-2.5 py-1 rounded-full bg-purple-500/10 text-purple-400 border border-purple-500/15">Home</span><span class="text-[10px] px-2.5 py-1 rounded-full bg-purple-500/10 text-purple-400 border border-purple-500/15">Car</span><span class="text-[10px] px-2.5 py-1 rounded-full bg-purple-500/10 text-purple-400 border border-purple-500/15">Life</span><span class="text-[10px] px-2.5 py-1 rounded-full bg-purple-500/10 text-purple-400 border border-purple-500/15">Health</span></div></div>
      <div class="feature-card reveal d2 !p-7"><div class="flex items-center gap-3 mb-4"><div class="w-12 h-12 rounded-xl bg-yellow-500/15 flex items-center justify-center text-xl text-yellow-400"><i class="ri-lightbulb-flash-line"></i></div><div><h4 class="font-bold text-white">Utilities</h4><p class="text-[.65rem] text-white/35">Energy · Water · Gas</p></div></div><p class="text-xs text-white/40 leading-relaxed mb-4">Energy contracts auto-renew at higher rates. Know when to switch and save on your bills.</p><div class="flex flex-wrap gap-2"><span class="text-[10px] px-2.5 py-1 rounded-full bg-yellow-500/10 text-yellow-400 border border-yellow-500/15">Electricity</span><span class="text-[10px] px-2.5 py-1 rounded-full bg-yellow-500/10 text-yellow-400 border border-yellow-500/15">Gas</span><span class="text-[10px] px-2.5 py-1 rounded-full bg-yellow-500/10 text-yellow-400 border border-yellow-500/15">Internet</span></div></div>
      <div class="feature-card reveal d3 !p-7"><div class="flex items-center gap-3 mb-4"><div class="w-12 h-12 rounded-xl bg-cyan-500/15 flex items-center justify-center text-xl text-cyan-400"><i class="ri-smartphone-line"></i></div><div><h4 class="font-bold text-white">Telecom</h4><p class="text-[.65rem] text-white/35">Mobile · Broadband · TV</p></div></div><p class="text-xs text-white/40 leading-relaxed mb-4">Mobile and broadband plans creep up in price. Time your switch at the right moment.</p><div class="flex flex-wrap gap-2"><span class="text-[10px] px-2.5 py-1 rounded-full bg-cyan-500/10 text-cyan-400 border border-cyan-500/15">Mobile</span><span class="text-[10px] px-2.5 py-1 rounded-full bg-cyan-500/10 text-cyan-400 border border-cyan-500/15">Broadband</span><span class="text-[10px] px-2.5 py-1 rounded-full bg-cyan-500/10 text-cyan-400 border border-cyan-500/15">TV</span></div></div>
      <div class="feature-card reveal d4 !p-7"><div class="flex items-center gap-3 mb-4"><div class="w-12 h-12 rounded-xl bg-red-500/15 flex items-center justify-center text-xl text-red-400"><i class="ri-car-line"></i></div><div><h4 class="font-bold text-white">Vehicle</h4><p class="text-[.65rem] text-white/35">Rego · Licence · Service</p></div></div><p class="text-xs text-white/40 leading-relaxed mb-4">Car registration, licence renewals, service Dates — never get caught out or fined again.</p><div class="flex flex-wrap gap-2"><span class="text-[10px] px-2.5 py-1 rounded-full bg-red-500/10 text-red-400 border border-red-500/15">Rego</span><span class="text-[10px] px-2.5 py-1 rounded-full bg-red-500/10 text-red-400 border border-red-500/15">Licence</span><span class="text-[10px] px-2.5 py-1 rounded-full bg-red-500/10 text-red-400 border border-red-500/15">Service</span></div></div>
      <div class="feature-card reveal d1 !p-7"><div class="flex items-center gap-3 mb-4"><div class="w-12 h-12 rounded-xl bg-pink-500/15 flex items-center justify-center text-xl text-pink-400"><i class="ri-passport-line"></i></div><div><h4 class="font-bold text-white">Documents</h4><p class="text-[.65rem] text-white/35">Passport · Visa · ID</p></div></div><p class="text-xs text-white/40 leading-relaxed mb-4">Avoid travel disasters. Get reminded well ahead of passport and visa expiry dates.</p><div class="flex flex-wrap gap-2"><span class="text-[10px] px-2.5 py-1 rounded-full bg-pink-500/10 text-pink-400 border border-pink-500/15">Passport</span><span class="text-[10px] px-2.5 py-1 rounded-full bg-pink-500/10 text-pink-400 border border-pink-500/15">Visa</span><span class="text-[10px] px-2.5 py-1 rounded-full bg-pink-500/10 text-pink-400 border border-pink-500/15">National ID</span></div></div>
      <div class="feature-card reveal d2 !p-7"><div class="flex items-center gap-3 mb-4"><div class="w-12 h-12 rounded-xl bg-green-500/15 flex items-center justify-center text-xl text-green-400"><i class="ri-repeat-line"></i></div><div><h4 class="font-bold text-white">Subscriptions</h4><p class="text-[.65rem] text-white/35">Streaming · SaaS · Gym</p></div></div><p class="text-xs text-white/40 leading-relaxed mb-4">Cancel or switch before  trials expire. Stay in control of every recurring charge.</p><div class="flex flex-wrap gap-2"><span class="text-[10px] px-2.5 py-1 rounded-full bg-green-500/10 text-green-400 border border-green-500/15">Streaming</span><span class="text-[10px] px-2.5 py-1 rounded-full bg-green-500/10 text-green-400 border border-green-500/15">Software</span><span class="text-[10px] px-2.5 py-1 rounded-full bg-green-500/10 text-green-400 border border-green-500/15">Gym</span></div></div>
      <div class="feature-card reveal d3 !p-7"><div class="flex items-center gap-3 mb-4"><div class="w-12 h-12 rounded-xl bg-blue-500/15 flex items-center justify-center text-xl text-blue-400"><i class="ri-bank-line"></i></div><div><h4 class="font-bold text-white">Finance</h4><p class="text-[.65rem] text-white/35">Mortgage · Loan · Credit</p></div></div><p class="text-xs text-white/40 leading-relaxed mb-4">Fixed rate mortgage ending? Loan review due? Get reminders to renegotiate before rollover.</p><div class="flex flex-wrap gap-2"><span class="text-[10px] px-2.5 py-1 rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/15">Mortgage</span><span class="text-[10px] px-2.5 py-1 rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/15">Loan</span></div></div>
      <div class="feature-card reveal d4 !p-7"><div class="flex items-center gap-3 mb-4"><div class="w-12 h-12 rounded-xl bg-emerald-500/15 flex items-center justify-center text-xl text-emerald-400"><i class="ri-add-circle-line"></i></div><div><h4 class="font-bold text-white">Custom</h4><p class="text-[.65rem] text-white/35">Anything you want</p></div></div><p class="text-xs text-white/40 leading-relaxed mb-4">Track warranties, lease agreements, medication refills, annual reviews, and more.</p><div class="flex flex-wrap gap-2"><span class="text-[10px] px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/15">Warranty</span><span class="text-[10px] px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/15">Lease</span><span class="text-[10px] px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/15">Anything!</span></div></div>
    </div>
  </div>
</section>

<section class="relative py-20 section-dark overflow-hidden text-center">
  <div class="gradient-blob w-[500px] h-[400px] bg-primary top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 !opacity-8"></div>
  <div id="grid-distortion-container" style="width: 100%; top: 0; height: 100%; position: absolute;"></div>
  <div class="relative z-10 max-w-2xl mx-auto px-6">
    <h2 class="text-3xl md:text-4xl font-black text-white mb-5 reveal">Start tracking <span class="grad-text">for </span></h2>
    <p class="text-base text-white/40 mb-8 reveal" data-delay="1">Set up in 2 minutes.  forever plan available.</p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center reveal" data-delay="2">
      <a href="register" class="btn-primary"><i class="ri-rocket-line text-xl"></i>Register</a>
    </div>
  </div>
</section>

<footer class="footer-dark border-t border-white/5">
  <div class="max-w-7xl mx-auto px-6 lg:px-8 py-12">
    <div class="grid grid-cols-2 md:grid-cols-5 gap-8 mb-10">
      <div class="col-span-2">
        <a href="index">
          <img src="https://www.vishakarex.in/assets/img/projects/d-remind.png" class="w-[160px] mb-4" alt="DRemind">
        </a>
        <p class="text-sm text-white/30 max-w-xs leading-relaxed">
          Smart reminders. Zero missed deadlines. Maximum savings. Smart reminders. Zero missed deadlines. Maximum savings.
        </p>
      </div>
      <div>
        <h4 class="font-semibold text-sm text-white/60 mb-5 uppercase tracking-wider">Quick Links</h4>
        <ul class="space-y-3 text-sm text-white/35">
          <li><a href="index" class="hover:text-white transition">Home</a></li>
          <li><a href="about" class="hover:text-white transition">About</a></li>
          <li><a href="category" class="hover:text-white transition">Category</a></li>
          <li><a href="faq" class="hover:text-white transition">FAQ</a></li>
          <li><a href="contact" class="hover:text-white transition">Contact</a></li>
        </ul>
      </div>
      <div>
        <h4 class="font-semibold text-sm text-white/60 mb-5 uppercase tracking-wider">Account</h4>
        <ul class="space-y-3 text-sm text-white/35">
          <li><a href="login" class="hover:text-white transition">Login</a></li>
          <li><a href="register" class="hover:text-white transition">Register</a></li>
          <li><a href="pricing" class="hover:text-white transition">Pricing</a></li>
        </ul>
      </div>
      <div>
        <h4 class="font-semibold text-sm text-white/60 mb-5 uppercase tracking-wider">Legal</h4>
        <ul class="space-y-3 text-sm text-white/35">
          <li><a href="privacy" class="hover:text-white transition">Privacy Policy</a></li>
          <li><a href="terms" class="hover:text-white transition">Terms of Use</a></li>
           
        </ul>
      </div>
    </div>
    <div class="border-t border-white/5 pt-8 flex flex-col sm:flex-row justify-center items-center gap-3">
      <p class="text-xs text-white/25">
        &copy; 2026 Winngoo DRemind. All rights reserved.
      </p>
    </div>
  </div>
</footer>


<!-- Distortion Animation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="{{ asset('assets/js/distortion.js') }}"></script>

<script src="{{ asset('assets/js/script.js') }}"></script>
<script>setActivePage('category');</script>
</body>
</html>