@extends('layouts.app')
@section('content')


<!-- PAGE HERO -->
<section class="page-hero-dark section-alt relative" data-particles="purple" data-p-count="50" data-p-connect="false" data-p-glow="true">
    <div class="hero-bg-image abt-bnr"></div>
<div class="hero-overlay"></div>
  <div class="gradient-blob w-[500px] h-[500px] bg-primary top-[-20%] left-[10%]"></div>
  <div class="gradient-blob w-[400px] h-[400px] bg-secondary bottom-[-20%] right-[5%]"></div>
  <div class="max-w-[800px] mx-auto px-6 relative z-10">
    <div class="page-breadcrumb"><a href="index">Home</a><span class="sep">/</span><span>About</span></div>
    <div class="badge bg-primary/10 border border-primary/20 text-purple-300 mx-auto mb-6 w-fit reveal"><span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span> Who We Are</div>
    <h1 class="reveal">Built to keep Your Daily <span class="grad-text">Commitments on Track</span></h1>
    <p class="reveal" data-delay="1"><Strong>Winngoo D-Remind</Strong> is a UK-based smart reminder platform built to help individuals stay organised. It delivers timely alerts for bills, subscriptions, renewals, and important events, helping reduce missed due dates, penalties, and unnecessary charges.</p>
  </div>
</section>

<!-- MISSION -->
<section class="relative py-20 md:py-28 section-dark overflow-hidden">
  <div class="max-w-7xl mx-auto px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
      <div class="reveal-left">
        <div class="badge bg-primary/10 border border-primary/20 text-purple-300 mb-6 w-fit">Our Mission</div>
        <h2 class="text-3xl lg:text-4xl font-black tracking-tight mb-6 text-white">Supporting better awareness of <span class="grad-text-alt">daily tasks</span></h2>
        <p class="text-base text-white/80 leading-relaxed mb-5 text-justify">We believe people should be aware of their upcoming responsibilities without needing to track everything manually. Important dates often go unnoticed when life gets busy, and having a clear view helps people stay prepared and avoid last-minute pressure.</p>
        <p class="text-base text-white/80 leading-relaxed mb-8 text-justify">Winngoo D-Remind brings these details together in one place. It helps users stay informed and manage their responsibilities with greater control.</p>
        <div class="flex flex-col gap-5">
          <div class="flex items-start gap-4"><div class="w-12 h-12 rounded-xl bg-primary/15 flex items-center justify-center text-xl text-purple-400 flex-shrink-0"><i class="ri-crosshair-line"></i></div><div><h4 class="font-bold mb-1 text-white">User-Focused</h4><p class="text-sm text-white/80">Designed around real user needs and everyday responsibilities.</p></div></div>
          <div class="flex items-start gap-4"><div class="w-12 h-12 rounded-xl bg-accent/15 flex items-center justify-center text-xl text-emerald-400 flex-shrink-0"><i class="ri-shield-check-line"></i></div><div><h4 class="font-bold mb-1 text-white">Privacy-Minded</h4><p class="text-sm text-white/80">Your data is handled securely with care and protection.</p></div></div>
          <div class="flex items-start gap-4"><div class="w-12 h-12 rounded-xl bg-secondary/15 flex items-center justify-center text-xl text-cyan-400 flex-shrink-0"><i class="ri-global-line"></i></div><div><h4 class="font-bold mb-1 text-white">Wide Accessibility</h4><p class="text-sm text-white/80">Suitable for individuals, families, and different everyday needs.</p></div></div>
        </div>
      </div>
      <div class="reveal-right">
        <div class="glass-strong p-10 text-center">
          <img src="{{ asset('assets/images/about/our-mission.webp') }}" alt="">
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
      <h2 class="text-3xl md:text-4xl font-black tracking-tight mb-4 text-white reveal" data-delay="1">Driven by <span class="grad-text">Clear Principles</span></h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
    <div class="feature-card reveal d1 text-center">
  <div class="mb-4">
    <img src="{{ asset('assets/images/about/clarity.webp') }}" 
         alt="Clarity" 
         class="w-10 h-10 object-contain mx-auto">
  </div>
  <h4 class="font-bold mb-2 text-white">Clarity</h4>
  <p class="text-sm text-white/85">Information is presented clearly so users can understand reminders at a glance.</p>
</div>
      <div class="feature-card reveal d2 text-center">
  <div class="mb-4">
    <img src="{{ asset('assets/images/about/depend.webp') }}" 
         alt="Dependability" 
         class="w-10 h-10 object-contain mx-auto">
  </div>
  <h4 class="font-bold mb-2 text-white">Dependability</h4>
  <p class="text-sm text-white/85">Reminders are structured to support consistent tracking and better planning.</p>
</div>
      <div class="feature-card reveal d3 text-center">
  <div class="mb-4">
    <img src="{{ asset('assets/images/about/respect.webp') }}" 
         alt="Respect" 
         class="w-10 h-10 object-contain mx-auto">
  </div>
  <h4 class="font-bold mb-2 text-white">Respect</h4>
  <p class="text-sm text-white/85">User information is handled carefully with attention to privacy and responsibility.</p>
</div>
     <div class="feature-card reveal d4 text-center">
  <div class="mb-4">
    <img src="{{ asset('assets/images/about/practical.webp') }}" 
         alt="Practicality" 
         class="w-10 h-10 object-contain mx-auto">
  </div>
  <h4 class="font-bold mb-2 text-white">Practicality</h4>
  <p class="text-sm text-white/85">Features are designed to fit naturally into everyday routines and usage.</p>
</div>
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
