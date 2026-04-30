@extends('layouts.app')
@section('content')


<!-- PAGE HERO -->
<section class="page-hero-dark section-alt relative" data-particles="purple" data-p-count="50" data-p-connect="false" data-p-glow="true">
  <div class="gradient-blob w-[500px] h-[500px] bg-primary top-[-20%] left-[10%]"></div>
  <div class="gradient-blob w-[400px] h-[400px] bg-secondary bottom-[-20%] right-[5%]"></div>
  <div class="max-w-[800px] mx-auto px-6 relative z-10">
    <div class="page-breadcrumb"><a href="index">Home</a><span class="sep">/</span><span>About</span></div>
    <div class="badge bg-primary/10 border border-primary/20 text-purple-300 mx-auto mb-6 w-fit reveal"><span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span> Our Story</div>
    <h1 class="reveal">Built to help you keep <span class="grad-text">more of your money.</span></h1>
    <p class="reveal" data-delay="1">DRemind was born from a simple frustration — too many people lose thousands every year to forgotten renewals and loyalty tax. We decided to fix that.</p>
  </div>
</section>

<!-- MISSION -->
<section class="relative py-20 md:py-28 section-dark overflow-hidden">
  <div class="max-w-7xl mx-auto px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
      <div class="reveal-left">
        <div class="badge bg-primary/10 border border-primary/20 text-purple-300 mb-6 w-fit">Our Mission</div>
        <h2 class="text-3xl lg:text-4xl font-black tracking-tight mb-6 text-white">Empowering people to be <span class="grad-text-alt">financially savvy</span></h2>
        <p class="text-base text-white/45 leading-relaxed mb-5">We believe every household deserves to know when their insurance, energy contracts, and subscriptions are up for renewal — and to have enough time to switch to a better deal.</p>
        <p class="text-base text-white/45 leading-relaxed mb-8">DRemind is the intelligent reminder platform that works silently in the background, so you never pay the loyalty tax again.</p>
        <div class="flex flex-col gap-5">
          <div class="flex items-start gap-4"><div class="w-12 h-12 rounded-xl bg-primary/15 flex items-center justify-center text-xl text-purple-400 flex-shrink-0"><i class="ri-crosshair-line"></i></div><div><h4 class="font-bold mb-1 text-white">Purpose-driven</h4><p class="text-sm text-white/40">Every feature we build is aimed at putting money back in your pocket.</p></div></div>
          <div class="flex items-start gap-4"><div class="w-12 h-12 rounded-xl bg-accent/15 flex items-center justify-center text-xl text-emerald-400 flex-shrink-0"><i class="ri-shield-check-line"></i></div><div><h4 class="font-bold mb-1 text-white">Privacy first</h4><p class="text-sm text-white/40">Your data is encrypted, never sold, fully GDPR &amp; APPs compliant.</p></div></div>
          <div class="flex items-start gap-4"><div class="w-12 h-12 rounded-xl bg-secondary/15 flex items-center justify-center text-xl text-cyan-400 flex-shrink-0"><i class="ri-global-line"></i></div><div><h4 class="font-bold mb-1 text-white">Global reach</h4><p class="text-sm text-white/40">Available in 8 countries with full local privacy compliance.</p></div></div>
        </div>
      </div>
      <div class="reveal-right">
        <div class="glass-strong p-10 text-center">
          <img src="https://img.freepik.com/premium-vector/notifications-page-with-floating-elements-business-planning-events-reminder-timetable_183665-586.jpg?semt=ais_hybrid&w=740&q=80" alt="">
        </div>
      </div>
    </div>
  </div>
</section>

<!-- VALUES -->
<section class="relative py-20 section-alt overflow-hidden" data-particles="mixed" data-p-count="40" data-p-connect="false">
  <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8">
    <div class="text-center mb-14">
      <div class="badge bg-secondary/10 border border-secondary/20 text-cyan-300 mx-auto mb-6 reveal"><span class="w-2 h-2 rounded-full bg-secondary"></span> Our Values</div>
      <h2 class="text-3xl md:text-4xl font-black tracking-tight mb-4 text-white reveal" data-delay="1">What we <span class="grad-text">stand for</span></h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
      <div class="feature-card reveal d1 text-center"><div class="text-4xl mb-4">💡</div><h4 class="font-bold mb-2 text-white">Transparency</h4><p class="text-sm text-white/40">No hidden fees, no data selling. What you see is what you get.</p></div>
      <div class="feature-card reveal d2 text-center"><div class="text-4xl mb-4">🚀</div><h4 class="font-bold mb-2 text-white">Simplicity</h4><p class="text-sm text-white/40">Set up in under 2 minutes. No complicated settings.</p></div>
      <div class="feature-card reveal d3 text-center"><div class="text-4xl mb-4">🔒</div><h4 class="font-bold mb-2 text-white">Security</h4><p class="text-sm text-white/40">Bank-level encryption on all your data, always.</p></div>
      <div class="feature-card reveal d4 text-center"><div class="text-4xl mb-4">🌍</div><h4 class="font-bold mb-2 text-white">Accessibility</h4><p class="text-sm text-white/40"> forever plan so everyone can benefit.</p></div>
    </div>
  </div>
</section>

<!-- TEAM -->
<section class="hidden relative py-20 section-dark overflow-hidden">
  <div class="max-w-[900px] mx-auto px-6 lg:px-8">
    <div class="text-center mb-14">
      <div class="badge bg-primary/10 border border-primary/20 text-purple-300 mx-auto mb-6 reveal"><span class="w-2 h-2 rounded-full bg-primary"></span> The Team</div>
      <h2 class="text-3xl md:text-4xl font-black tracking-tight text-white reveal" data-delay="1">The people behind <span class="grad-text">DRemind</span></h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
      <div class="feature-card reveal d1 text-center"><div class="w-16 h-16 rounded-2xl mx-auto mb-4 flex items-center justify-center text-xl font-bold text-white bg-gradient-to-br from-primary to-purple-600">JT</div><h4 class="font-bold text-white mb-1">Kishore Thompson</h4><p class="text-xs font-semibold mb-2 text-purple-400">CEO &amp; Co-founder</p><p class="text-xs text-white/35">10+ years in fintech. Previously at Monzo and TransferWise.</p></div>
      <div class="feature-card reveal d2 text-center"><div class="w-16 h-16 rounded-2xl mx-auto mb-4 flex items-center justify-center text-xl font-bold text-white bg-gradient-to-br from-secondary to-cyan-600">SR</div><h4 class="font-bold text-white mb-1">Sophie Reynolds</h4><p class="text-xs font-semibold mb-2 text-cyan-400">CTO &amp; Co-founder</p><p class="text-xs text-white/35">Full-stack engineer with a passion for clean, fast interfaces.</p></div>
      <div class="feature-card reveal d3 text-center"><div class="w-16 h-16 rounded-2xl mx-auto mb-4 flex items-center justify-center text-xl font-bold text-white bg-gradient-to-br from-primary to-secondary">ML</div><h4 class="font-bold text-white mb-1">Marcus Lee</h4><p class="text-xs font-semibold mb-2 text-emerald-400">Head of Product</p><p class="text-xs text-white/35">UX obsessive. Designed apps used by 20M+ people globally.</p></div>
    </div>
  </div>
</section>

<!-- GLOBAL -->
<section class="hidden relative py-20 section-alt overflow-hidden">
  <div class="max-w-7xl mx-auto px-6 lg:px-8">
    <div class="text-center mb-14">
      <div class="badge bg-accent/10 border border-accent/20 text-emerald-300 mx-auto mb-6 reveal"><span class="w-2 h-2 rounded-full bg-accent"></span> Global Availability</div>
      <h2 class="text-3xl md:text-4xl font-black tracking-tight text-white reveal" data-delay="1">Helping savers <span class="grad-text">worldwide</span></h2>
    </div>
    <div class="reveal-scale grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      <div class="feature-card flex items-center gap-4 !p-5"><div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-800 to-blue-600 flex items-center justify-center text-xs font-bold text-white shrink-0">AU</div><div><div class="font-bold text-white">Australia</div><div class="text-xs text-white/35">ACCC Compliant</div></div><i class="ri-check-line text-accent ml-auto"></i></div>
      <div class="feature-card flex items-center gap-4 !p-5"><div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-800 to-blue-700 flex items-center justify-center text-xs font-bold text-white shrink-0">NZ</div><div><div class="font-bold text-white">New Zealand</div><div class="text-xs text-white/35">Privacy Act 2020</div></div><i class="ri-check-line text-accent ml-auto"></i></div>
      <div class="feature-card flex items-center gap-4 !p-5"><div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-700 to-red-600 flex items-center justify-center text-xs font-bold text-white shrink-0">US</div><div><div class="font-bold text-white">United States</div><div class="text-xs text-white/35">CCPA Compliant</div></div><i class="ri-check-line text-accent ml-auto"></i></div>
      <div class="feature-card flex items-center gap-4 !p-5"><div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-800 to-red-500 flex items-center justify-center text-xs font-bold text-white shrink-0">UK</div><div><div class="font-bold text-white">United Kingdom</div><div class="text-xs text-white/35">GDPR Compliant</div></div><i class="ri-check-line text-accent ml-auto"></i></div>
      <div class="feature-card flex items-center gap-4 !p-5"><div class="w-10 h-10 rounded-full bg-gradient-to-br from-red-600 to-red-500 flex items-center justify-center text-xs font-bold text-white shrink-0">CA</div><div><div class="font-bold text-white">Canada</div><div class="text-xs text-white/35">PIPEDA</div></div><i class="ri-check-line text-accent ml-auto"></i></div>
      <div class="feature-card flex items-center gap-4 !p-5"><div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-700 to-green-500 flex items-center justify-center text-xs font-bold text-white shrink-0">IE</div><div><div class="font-bold text-white">Ireland</div><div class="text-xs text-white/35">GDPR Compliant</div></div><i class="ri-check-line text-accent ml-auto"></i></div>
      <div class="feature-card flex items-center gap-4 !p-5"><div class="w-10 h-10 rounded-full bg-gradient-to-br from-orange-500 to-green-600 flex items-center justify-center text-xs font-bold text-white shrink-0">IN</div><div><div class="font-bold text-white">India</div><div class="text-xs text-white/35">PDPB</div></div><i class="ri-check-line text-accent ml-auto"></i></div>
      <div class="feature-card flex items-center gap-4 !p-5"><div class="w-10 h-10 rounded-full bg-gradient-to-br from-red-600 to-red-400 flex items-center justify-center text-xs font-bold text-white shrink-0">SG</div><div><div class="font-bold text-white">Singapore</div><div class="text-xs text-white/35">PDPA</div></div><i class="ri-check-line text-accent ml-auto"></i></div>
    </div>
  </div>
</section>

<!-- CTA -->
<!-- <section class="relative py-28 section-dark overflow-hidden text-center">
  <div class="gradient-blob w-[500px] h-[500px] bg-primary top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 !opacity-10"></div>
    <div id="grid-distortion-container" style="width: 100%; top: 0; height: 100%; position: absolute;"></div>
    <div class="relative z-10 max-w-2xl mx-auto px-6">
    <h2 class="text-4xl md:text-5xl font-black tracking-tight mb-5 text-white reveal">Ready to start <span class="grad-text">saving?</span></h2>
    <p class="text-base text-white/80 mb-10 leading-relaxed reveal" data-delay="1">Join thousands of smart savers already using DRemind.  forever plan available.</p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center reveal" data-delay="2">
      <a href="register" class="btn-primary"><i class="ri-rocket-line text-xl"></i>Register</a>
      <a href="contact" class="btn-secondary"><i class="ri-mail-line"></i>Contact Us</a>
    </div>
  </div>
</section> -->


<!-- Distortion Animation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="{{ asset('assets/js/distortion.js') }}"></script>

<script src="{{ asset('assets/js/script.js') }}"></script>
<script>setActivePage('about');</script>
@endsection
