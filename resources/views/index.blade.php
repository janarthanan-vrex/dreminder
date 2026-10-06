@extends('layouts.app')
@section('content')


<style>.nav-desktop .nav-link:nth-child(1){color: #fff;background: rgba(124, 58, 237, 0.25);border: 1px solid rgba(124, 58, 237, 0.25);}</style>
<!-- ===== HERO ===== -->
<section id="hero" class="relative min-h-screen flex items-center overflow-hidden section-dark">
  <canvas id="plasmaC" class="section-canvas"></canvas>
  <div class="gradient-blob w-[600px] h-[600px] bg-primary top-[-15%] left-[-10%]"></div>
  <div class="gradient-blob w-[500px] h-[500px] bg-secondary bottom-[5%] right-[-8%]"></div>
  <!-- Floating decorative shapes -->
  <div class="hero-shape w-16 h-16 border-2 border-primary/20 top-[20%] right-[15%]" style="animation-delay:0s"></div>
  <div class="hero-shape w-10 h-10 bg-secondary/10 top-[65%] right-[25%]" style="animation-delay:2s;border-radius:50%"></div>
  <div class="hero-shape w-12 h-12 border-2 border-accent/15 top-[30%] left-[8%]" style="animation-delay:4s;border-radius:50%"></div>
  <div class="hero-shape w-8 h-8 bg-primary/10 bottom-[25%] left-[15%]" style="animation-delay:1s"></div>

  <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 w-full pt-[50px] pb-32 lg:pt-0 lg:pb-0 top-[60px]">
    <div class="flex flex-col lg:flex-row items-center gap-16 lg:gap-12 xl:gap-20">
      <div class="flex-1 max-w-2xl reveal-left">
        <h1 class="text-[44px] sm:text-[56px] md:text-[64px] lg:text-[72px] xl:text-[80px] font-black leading-[1.05] tracking-tight mb-6">
          Stay Ahead<br> of Every
          <span class="grad-text">Reminder</span>
         
        </h1>
        <p class="text-lg md:text-xl text-white/90 mb-4 max-w-lg leading-relaxed text-justify">
          <strong>Winngoo D-Remind </strong>helps you manage bills, subscriptions, renewals, and important events with timely, reliable notifications keeping your commitments on track.
        </p>
        <p class="text-sm text-white/80 mb-10 max-w-lg text-justify">
          A simple, dependable way to stay focused across your daily responsibilities.
        </p>
        <!--<div class="flex flex-wrap gap-4 mb-10">-->
        <!--  <a href="#cta" class="btn-primary">-->
        <!--    <i class="ri-download-cloud-line text-xl"></i>-->
        <!--    Get Started -->
        <!--  </a>-->
        <!--  <a href="#features" class="btn-secondary">-->
        <!--    Discover More <i class="ri-arrow-right-line"></i>-->
        <!--  </a>-->
        <!--</div>-->
        <!-- Trust row -->
        <div class="flex flex-wrap items-center gap-6 text-xs text-white/80">
          <div class="flex items-center gap-1.5">
            <i class="ri-shield-check-line text-accent text-sm"></i>
            <span>Data Protection</span>
          </div>
          <div class="flex items-center gap-1.5">
            <i class="ri-notification-4-line text-accent text-sm"></i>
            <span>Multi-Channel Alerts</span>
          </div>
        </div>
      </div>
      <!-- Phone --><!-- Slide Carousel -->
<div class="flex-shrink-0 reveal-right" data-delay="2">
  <div class="slide-carousel">
    <div class="phone-glow"></div>
    <div class="slide-track" id="slideTrack">
      <div class="slide-item active">
        <img src="/assets/images/mobile/1.webp" alt="Preview 1">
      </div>
      <div class="slide-item">
        <img src="/assets/images/mobile/2.webp" alt="Preview 2">
      </div>
      <div class="slide-item">
        <img src="/assets/images/mobile/3.webp" alt="Preview 3">
      </div>
    </div>
    <div class="slide-dots" id="slideDots">
      <span class="slide-dot active"></span>
      <span class="slide-dot"></span>
      <span class="slide-dot"></span>
    </div>
  </div>
</div>

<style>
.slide-carousel {
  position: relative;
  width: 280px;
}

.slide-track {
  justify-self: center;
    /*position: relative;*/
    width: 85%;
    aspect-ratio: 7 / 16;
  border-radius: 24px;
  overflow: visible;
  box-shadow: 0 25px 60px rgba(0, 0, 0, 0.5);
  /*background: #0a0a1f;*/
}

/* ── base state: GPU layer forced ── */
.slide-item {
  position: absolute;
  /*inset: 0;*/
  opacity: 0;
  pointer-events: none;
  will-change: transform, opacity;
  backface-visibility: hidden;
  -webkit-backface-visibility: hidden;
  transform: translate3d(0, 0, 0) rotate(0deg);
  transition: none;
}

.slide-item img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  border-radius: 24px;
}

/* ── visible state ── */
.slide-item.active {
  opacity: 1;
  pointer-events: auto;
}

/* ── EXIT: sweeps left + bends + fades ── */
.slide-item.is-exiting {
  transition:
    transform 0.82s cubic-bezier(0.55, 0, 0.65, 1),
    opacity   0.75s cubic-bezier(0.55, 0, 0.65, 1);
  transform: translate3d(-118%, 42px, 0) rotate(-26deg) !important;
  opacity: 0 !important;
  z-index: 2;
}

/* ── ENTER start position (no transition yet) ── */
.slide-item.enter-start {
  transform: translate3d(0, 18px, 0) scale(0.96);
  opacity: 0;
  z-index: 1;
}

/* ── ENTER: smooth fade + rise ── */
.slide-item.is-entering {
  transition:
    transform 1s cubic-bezier(0.15, 0, 0.2, 1),
    opacity   0.95s cubic-bezier(0.15, 0, 0.2, 1);
  transform: translate3d(0, 0, 0) scale(1) !important;
  opacity: 1 !important;
}

/* ── dots ── */
.slide-dots {
  display: flex;
  justify-content: center;
  gap: 6px;
  margin-top: 14px;
}
.slide-dot {
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background: rgba(255,255,255,0.2);
  transition: width 0.3s ease, background 0.3s ease;
  cursor: pointer;
}
.slide-dot.active {
  width: 20px;
  border-radius: 3px;
  background: #7c3aed;
}
</style>

<script>
(function () {
  const track = document.getElementById('slideTrack');
  const dots  = document.querySelectorAll('#slideDots .slide-dot');
  if (!track) return;

  const items = Array.from(track.querySelectorAll('.slide-item'));
  const total = items.length;
  let current     = 0;
  let isAnimating = false;

  function goTo(next) {
    if (isAnimating || next === current) return;
    isAnimating = true;

    const outItem = items[current];
    const inItem  = items[next];

    /* ── step 1: kick off exit on current ── */
    outItem.classList.add('is-exiting');

    /* ── step 2: set enter-start (no transition) ── */
    inItem.classList.add('active', 'enter-start');

    /* ── step 3: double rAF so browser paints enter-start
          before we add is-entering transition ── */
    requestAnimationFrame(() => {
      requestAnimationFrame(() => {
        inItem.classList.remove('enter-start');
        inItem.classList.add('is-entering');
      });
    });

    /* ── step 4: update dots ── */
    dots.forEach((d, i) => d.classList.toggle('active', i === next));

    /* ── step 5: cleanup after transition finishes ── */
    setTimeout(() => {
      outItem.classList.remove('active', 'is-exiting');
      inItem.classList.remove('is-entering');
      current     = next;
      isAnimating = false;
    }, 1050);
  }

  /* auto rotate every 3s */
  setInterval(() => goTo((current + 1) % total), 3000);

  /* dot click */
  dots.forEach((dot, i) => dot.addEventListener('click', () => goTo(i)));
})();
</script>
    </div>
  </div>
</section>
<div class="section-divider"></div>

<!-- ===== HOW IT WORKS ===== -->
<section id="how" class="relative py-5 md:py-10 section-alt overflow-hidden" data-particles="mixed" data-p-shape="mix" data-p-count="100" data-p-connect-dist="130" data-p-mouse-radius="180" data-p-glow="true" data-p-pulse="true">
  <div class="gradient-blob w-[400px] h-[400px] bg-secondary top-[10%] right-[-10%]"></div>
  <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8">
    <div class="text-center mb-20">
      <div class="badge bg-secondary/10 border border-secondary/20 text-cyan-300 mx-auto mb-6 reveal">
        <span class="w-2 h-2 rounded-full bg-secondary"></span> Process Overview
      </div>
      <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-5 reveal" data-delay="1">
        How <span class="grad-text">It Works</span>
      </h2>
      <p class="text-base md:text-lg text-white/90 max-w-xl mx-auto reveal" data-delay="2">
        Create and manage reminders through a structured process designed for clarity and timely notifications.
      </p>
    </div>
    <div class="relative">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-6 relative z-10">
        <!-- Step 1 -->
        <div class="step-card reveal" data-delay="1">

  <div class="step-icon">
    <img 
      src="{{ asset('assets/images/home/add-remind.webp') }}" 
      alt="Add Reminder" 
      class="step-img"
    >
  </div>

  <h3 class="text-xl font-bold mb-3">Add Your Reminders</h3>

  <p class="text-sm text-white/85 leading-relaxed mb-5">
    Add your bills, subscriptions, renewals, and important events 
    to keep everything organised in one place
  </p>

  <div class="flex flex-wrap justify-center gap-2">

    <span class="text-xs px-3 py-1.5 rounded-full bg-primary/10 text-primary border border-primary/20 flex items-center gap-1.5">
      Bills
    </span>

    <span class="text-xs px-3 py-1.5 rounded-full bg-secondary/10 text-secondary border border-secondary/20 flex items-center gap-1.5">
      Subscriptions
    </span>

    <span class="text-xs px-3 py-1.5 rounded-full bg-accent/10 text-accent border border-accent/20 flex items-center gap-1.5">
      Events
    </span>

  </div>

</div>
        <!-- Step 2 -->
       <div class="step-card reveal" data-delay="2">

  <div class="step-icon">
    <img 
      src="{{ asset('assets/images/home/receive-time-alerts.webp') }}" 
      alt="Receive Alerts" 
      class="step-img"
    >
  </div>

  <h3 class="text-xl font-bold mb-3">Receive Timely Alerts</h3>

  <p class="text-sm text-white/85 leading-relaxed mb-5">
    Get notified before due dates through your preferred channels, 
    so you never miss an important update.
  </p>

  <div class="flex flex-wrap justify-center gap-2">

    <span class="text-xs px-3 py-1.5 rounded-full bg-yellow-500/10 text-yellow-400 border border-yellow-500/20 flex items-center gap-1.5">
      Push
    </span>

    <span class="text-xs px-3 py-1.5 rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/20 flex items-center gap-1.5">
      Email
    </span>

    <span class="text-xs px-3 py-1.5 rounded-full bg-pink-500/10 text-pink-400 border border-pink-500/20 flex items-center gap-1.5">
      Alerts
    </span>

  </div>

</div>
        <!-- Step 3 -->
        <div class="step-card reveal" data-delay="3">

  <div class="step-icon">
    <img 
      src="{{ asset('assets/images/home/manage-track.webp') }}" 
      alt="Manage and Track" 
      class="step-img"
    >
  </div>

  <h3 class="text-xl font-bold mb-3">Manage and Track</h3>

  <p class="text-sm text-white/85 leading-relaxed mb-5">
    Monitor upcoming, completed, and overdue reminders 
    from a single dashboard.
  </p>

  <div class="flex flex-wrap justify-center gap-2">

    <span class="text-xs px-3 py-1.5 rounded-full bg-red-500/10 text-red-400 border border-red-500/20 flex items-center gap-1.5">
      Dashboard
    </span>

    <span class="text-xs px-3 py-1.5 rounded-full bg-green-500/10 text-green-400 border border-green-500/20 flex items-center gap-1.5">
      Tracking
    </span>

    <span class="text-xs px-3 py-1.5 rounded-full bg-pink-500/10 text-pink-400 border border-pink-500/20 flex items-center gap-1.5">
      Updates
    </span>

  </div>

</div>
      </div>
    </div>
  </div>
</section>
<div class="section-divider"></div>

<!-- ===== FEATURES ===== -->
<section id="features" class="hidden relative py-5 md:py-10 section-dark overflow-hidden">
  <canvas id="rippleC" class="section-canvas"></canvas>
  <div class="gradient-blob w-[500px] h-[500px] bg-primary bottom-[-15%] left-[-10%]"></div>
  <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8">
    <div class="text-center mb-20">
      <div class="badge bg-primary/10 border border-primary/20 text-purple-300 mx-auto mb-6 reveal">
        <span class="w-2 h-2 rounded-full bg-primary"></span> Core Features
      </div>
      <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-5 reveal" data-delay="1">
        Everything You <span class="grad-text">Need</span>
      </h2>
      <p class="text-base md:text-lg text-white/35 max-w-xl mx-auto reveal" data-delay="2">
        Powerful features designed to keep your finances organized and your mind at ease.
      </p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div class="feature-card reveal" data-delay="1" data-pixel>
        <canvas></canvas>
        <div class="f-content">
          <div class="feature-icon bg-purple-500/10 text-purple-400"><i class="ri-file-list-3-line"></i></div>
          <h3 class="text-lg font-bold mb-2 text-white">Subscription Tracking</h3>
          <p class="text-sm text-white/40 leading-relaxed mb-4">Monitor Netflix, Spotify, gym memberships, cloud storage, and every recurring charge from one unified dashboard.</p>
          <div class="flex items-center gap-2 text-xs text-primary/70"><i class="ri-arrow-right-s-line"></i> Auto-detects 200+ services</div>
        </div>
      </div>
      <div class="feature-card reveal" data-delay="2" data-pixel>
        <canvas></canvas>
        <div class="f-content">
          <div class="feature-icon bg-cyan-500/10 text-cyan-400"><i class="ri-bank-card-line"></i></div>
          <h3 class="text-lg font-bold mb-2 text-white">Bill Payment Reminders</h3>
          <p class="text-sm text-white/40 leading-relaxed mb-4">Electricity, water, internet, phone, rent — get alerts 7, 3, and 1 day before every bill is due.</p>
          <div class="flex items-center gap-2 text-xs text-secondary/70"><i class="ri-arrow-right-s-line"></i> Customizable alert timing</div>
        </div>
      </div>
      <div class="feature-card reveal" data-delay="3" data-pixel>
        <canvas></canvas>
        <div class="f-content">
          <div class="feature-icon bg-red-500/10 text-red-400"><i class="ri-shield-star-line"></i></div>
          <h3 class="text-lg font-bold mb-2 text-white">Insurance Renewal Alerts</h3>
          <p class="text-sm text-white/40 leading-relaxed mb-4">Car, health, home, and life insurance — never let coverage lapse. Get reminded 30 days before expiry.</p>
          <div class="flex items-center gap-2 text-xs text-red-400/70"><i class="ri-arrow-right-s-line"></i> Coverage gap protection</div>
        </div>
      </div>
      <div class="feature-card reveal" data-delay="1" data-pixel>
        <canvas></canvas>
        <div class="f-content">
          <div class="feature-icon bg-yellow-500/10 text-yellow-400"><i class="ri-exchange-dollar-line"></i></div>
          <h3 class="text-lg font-bold mb-2 text-white">Price Comparison Engine</h3>
          <p class="text-sm text-white/40 leading-relaxed mb-4">Before any renewal, automatically compare prices across providers. Users save an average of $120 per switch.</p>
          <div class="flex items-center gap-2 text-xs text-yellow-400/70"><i class="ri-arrow-right-s-line"></i> Powered by real-time data</div>
        </div>
      </div>
      <div class="feature-card reveal" data-delay="2" data-pixel>
        <canvas></canvas>
        <div class="f-content">
          <div class="feature-icon bg-green-500/10 text-green-400"><i class="ri-notification-3-line"></i></div>
          <h3 class="text-lg font-bold mb-2 text-white">Smart Notification System</h3>
          <p class="text-sm text-white/40 leading-relaxed mb-4">AI learns when you're most responsive and sends alerts at the optimal time. No spam, just smart reminders.</p>
          <div class="flex items-center gap-2 text-xs text-accent/70"><i class="ri-arrow-right-s-line"></i> Machine learning powered</div>
        </div>
      </div>
      <div class="feature-card reveal" data-delay="3" data-pixel>
        <canvas></canvas>
        <div class="f-content">
          <div class="feature-icon bg-pink-500/10 text-pink-400"><i class="ri-team-line"></i></div>
          <h3 class="text-lg font-bold mb-2 text-white">Family Sharing</h3>
          <p class="text-sm text-white/40 leading-relaxed mb-4">Share reminders with family members. Assign bills, track shared subscriptions, and manage household expenses together.</p>
          <div class="flex items-center gap-2 text-xs text-pink-400/70"><i class="ri-arrow-right-s-line"></i> Up to 6 family members</div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="section-divider"></div>

<!-- ===== SHOWCASE (3D Globe) ===== -->
<section id="showcase" class="relative py-5 md:py-10 section-alt overflow-hidden">
  <canvas id="lightningC" class="section-canvas" style="opacity:.5"></canvas>
  <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8">
    <div class="text-center mb-20">
      <div class="badge bg-primary/10 border border-primary/20 text-purple-300 mx-auto mb-6 reveal">
        <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span> Platform Features
      </div>
      <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-5 reveal" data-delay="1">
        Control Your <span class="grad-text">Reminders</span>
      </h2>
      <p class="text-base md:text-lg text-white/90 max-w-xl mx-auto reveal" data-delay="2">
        Simple features that give you flexibility, control, and better visibility over your reminders.
      </p>
    </div>
    <div class="flex flex-col lg:flex-row items-center gap-16">
      <!-- 3D Globe -->
      <div class="globe-wrap reveal-scale flex-shrink-0 order-2 lg:order-1 mx-auto" id="globeWrap">
        <div class="globe-glow"></div>
        <canvas id="globeC" class="w-full h-full" style="touch-action:none"></canvas>
        <div class="text-center mt-4 text-xs text-white/25"><i class="ri-drag-move-line"></i> Drag to rotate</div>
      </div>
      <!-- Content -->
      <div class="flex-1 order-1 lg:order-2 space-y-5">
       
        <div class="glass p-7 reveal" data-delay="1">
  <div class="flex items-start gap-4">

    <!-- Image with Existing Icon Background -->
    <div class="w-11 h-11 rounded-xl bg-primary/15 flex items-center justify-center flex-shrink-0 mt-0.5">
      <img 
        src="{{ asset('assets/images/home/category-based.webp') }}" 
        alt="Category Icon"
        class="w-6 h-6 object-contain"
      />
    </div>

    <div>
      <h3 class="text-lg font-bold mb-2">Category-Based Organisation</h3>
      <p class="text-sm text-white/80 leading-relaxed text-justify">
        Organise reminders across categories like bills, insurance, subscriptions, travel, health, and other daily needs.
      </p>
    </div>

  </div>
</div>
        <div class="glass p-7 reveal" data-delay="2">
  <div class="flex items-start gap-4">

    <!-- Image with Existing Icon Background -->
    <div class="w-11 h-11 rounded-xl bg-secondary/15 flex items-center justify-center flex-shrink-0 mt-0.5">
      <img 
        src="{{ asset('assets/images/home/custom-remind.webp') }}" 
        alt="Reminder Details Icon"
        class="w-6 h-6 object-contain"
      />
    </div>

    <div>
      <h3 class="text-lg font-bold mb-2">Custom Reminder Details</h3>
      <p class="text-sm text-white/80 leading-relaxed text-justify">
        Add descriptions, date and time, and set frequency as daily, weekly, or monthly for better planning.
      </p>
    </div>

  </div>
</div>
       <div class="glass p-7 reveal" data-delay="3">
  <div class="flex items-start gap-4">

    <!-- Image with Existing Icon Background -->
    <div class="w-11 h-11 rounded-xl bg-accent/15 flex items-center justify-center flex-shrink-0 mt-0.5">
      <img 
        src="{{ asset('assets/images/home/notify-prefer.webp') }}" 
        alt="Notification Preferences Icon"
        class="w-6 h-6 object-contain"
      />
    </div>

    <div>
      <h3 class="text-lg font-bold mb-2">Notification Preferences</h3>
      <p class="text-sm text-white/80 leading-relaxed text-justify">
        Choose preferred alert channels and set reminder timing based on your schedule and personal priorities.
      </p>
    </div>

  </div>
</div>
        <div class="glass p-7 reveal" data-delay="4">
  <div class="flex items-start gap-4">

    <!-- Image with Existing Icon Background -->
    <div class="w-11 h-11 rounded-xl bg-pink-500/15 flex items-center justify-center flex-shrink-0 mt-0.5">
      <img 
        src="{{ asset('assets/images/home/calender-view.webp') }}" 
        alt="Calendar View Icon"
        class="w-6 h-6 object-contain"
      />
    </div>

    <div>
      <h3 class="text-lg font-bold mb-2">Calendar View</h3>
      <p class="text-sm text-white/80 leading-relaxed text-justify">
        View reminders in a structured calendar to plan and manage upcoming tasks more effectively.
      </p>
    </div>

  </div>
</div>
      </div>
    </div>
  </div>
</section>
<div class="section-divider"></div>

<!-- ===== STATS ===== -->
<section class="hidden relative py-24 md:py-28 section-dark overflow-hidden">
  <div class="gradient-blob w-[600px] h-[300px] bg-gradient-to-r from-primary to-secondary top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"></div>
  <div class="relative z-10 max-w-6xl mx-auto px-6 lg:px-8">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
      <div class="stat-card reveal" data-delay="1">
        <div class="text-4xl mb-3"><i class="ri-group-line grad-text"></i></div>
        <div class="text-3xl md:text-4xl font-black grad-text mb-2 counter" data-target="50000">0</div>
        <div class="text-sm text-white/35">Active Users</div>
      </div>
      <div class="stat-card reveal" data-delay="2">
        <div class="text-4xl mb-3"><i class="ri-money-dollar-circle-line grad-text-alt"></i></div>
        <div class="text-3xl md:text-4xl font-black grad-text-alt mb-2">$<span class="counter" data-target="2400000">0</span></div>
        <div class="text-sm text-white/35">Late Fees Saved</div>
      </div>
      <div class="stat-card reveal" data-delay="3">
        <div class="text-4xl mb-3"><i class="ri-notification-3-line grad-purple"></i></div>
        <div class="text-3xl md:text-4xl font-black grad-purple mb-2"><span class="counter" data-target="1200000">0</span>+</div>
        <div class="text-sm text-white/35">Reminders Sent</div>
      </div>
      <div class="stat-card reveal" data-delay="4">
        <div class="text-4xl mb-3"><i class="ri-shield-check-line grad-text"></i></div>
        <div class="text-3xl md:text-4xl font-black grad-text mb-2"><span class="counter" data-target="99">0</span>.9%</div>
        <div class="text-sm text-white/35">Uptime SLA</div>
      </div>
    </div>
  </div>
</section>
<div class="section-divider"></div>

<!-- ===== USE CASES (Premium Bento Grid) ===== -->
<section id="usecases" class="relative py-5 md:py-10 section-alt overflow-hidden">
  <div class="gradient-blob w-[400px] h-[400px] bg-secondary bottom-[-10%] right-[-5%]"></div>
  <div class="gradient-blob w-[300px] h-[300px] bg-primary top-[5%] left-[-5%]"></div>
  <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8">
    
    <div class="text-center mb-16">
      <div class="badge bg-secondary/10 border border-secondary/20 text-cyan-300 mx-auto mb-6 reveal">
        <span class="w-2 h-2 rounded-full bg-secondary"></span> Use Cases
      </div>
      <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-5 reveal" data-delay="1">
        Built For <span class="grad-text">Everyday Needs</span>
      </h2>
      <p class="text-base md:text-lg text-white/90 max-w-xl mx-auto reveal" data-delay="2">
        Manage reminders across multiple categories with timely alerts to help you stay organised and never miss an important date.
      </p>
    </div>
   <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="bentoGrid">
      <!-- Track Subscriptions -->
      <div class="bento-card reveal" data-delay="1" data-tilt>
        <div class="bento-shine"></div>
        <div class="relative z-10">
          <div class="bento-icon bg-gradient-to-br from-primary/20 to-purple-600/20">
            <img src="{{ asset('assets/images/home/track-sub.webp') }}" 
                 alt="Track Subscriptions" 
                 class="w-9 h-10 object-contain">
          </div>
          <h3 class="text-lg font-bold mb-2 text-white">Track All Subscriptions</h3>
          <p class="text-sm text-white/80 leading-relaxed mb-4 text-justify">Keep all your subscriptions organised with clear visibility of renewal dates and active plans.</p>
          <div class="flex gap-2 flex-wrap">
            <span class="text-[10px] px-2 py-1 rounded-full bg-red-500/10 text-red-400 border border-red-500/15">Streaming Media</span>
            <span class="text-[10px] px-2 py-1 rounded-full bg-green-500/10 text-green-400 border border-green-500/15">Software Apps</span>
            <span class="text-[10px] px-2 py-1 rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/15">Memberships Clubs</span>
            <span class="text-[10px] px-2 py-1 rounded-full bg-purple-500/10 text-purple-400 border border-purple-500/15">Services Utilities</span>
          </div>
        </div>
      </div>

      <!-- Insurance -->
      <div class="bento-card reveal" data-delay="2" data-tilt>
        <div class="bento-shine"></div>
        <div class="relative z-10">
         <div class="bento-icon bg-gradient-to-br from-red-500/20 to-orange-500/20">
  <img src="{{ asset('assets/images/home/insurance-alert.webp') }}" 
       alt="Insurance Alerts" 
       class="w-9 h-10 object-contain">
</div>
<h3 class="text-lg font-bold mb-2 text-white">Insurance Alerts</h3>
          <p class="text-sm text-white/80 leading-relaxed mb-4 text-justify">Receive alerts before policy expiry dates to maintain continuous coverage without missed renewals.</p>
          <div class="flex gap-2 flex-wrap">
            <span class="text-[10px] px-2 py-1 rounded-full bg-red-500/10 text-red-400 border border-red-500/15">Vechicle</span>
            <span class="text-[10px] px-2 py-1 rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/15">Health</span>
            <span class="text-[10px] px-2 py-1 rounded-full bg-green-500/10 text-green-400 border border-green-500/15">Home</span>
            <span class="text-[10px] px-2 py-1 rounded-full bg-purple-500/10 text-purple-400 border border-purple-500/15">Life</span>
          </div>
        </div>
      </div>

      <!-- Price Compare -->
       <div class="bento-card reveal" data-delay="3" data-tilt>
        <div class="bento-shine"></div>
        <div class="relative z-10">
         <div class="bento-icon bg-gradient-to-br from-yellow-500/20 " style="background: linear-gradient(135deg, rgba(236, 72, 153, .15), rgba(244, 63, 94, .15));">
  <img src="{{ asset('assets/images/home/payment-plan.webp') }}" 
       alt="Payment Planning" 
       class="w-9 h-10 object-contain">
</div>
<h3 class="text-lg font-bold mb-2 text-white">Payment Planning</h3>
          <p class="text-sm text-white/80 leading-relaxed mb-3 text-justify">Plan upcoming bills and recurring payments with clear timelines to stay prepared and organised.</p>
          <div class="text-xs text-pink-400/60 flex items-center gap-1"><i class="ri-calendar-check-line"></i> Organised Payment Schedules</div>
        </div>
      </div>
      <!-- Renewal -->
      <div class="bento-card reveal" data-delay="4" data-tilt>
        <div class="bento-shine"></div>
        <div class="relative z-10">
         <div class="bento-icon bg-gradient-to-br from-cyan-500/20 to-blue-500/20 ">
  <img src="{{ asset('assets/images/home/renewal-notify.webp') }}" 
       alt="Renewal Notifications" 
       class="w-9 h-10 object-contain">
</div>
<h3 class="text-lg font-bold mb-2 text-white">Renewal Notifications</h3>
          <p class="text-sm text-white/80 leading-relaxed mb-3 text-justify">Track renewals for services, plans, and documents to keep everything updated and current.</p>
          <div class="text-xs text-cyan-400/60 flex items-center gap-1"><i class="ri-timer-flash-line"></i> Smart Timing Alerts</div>
        </div>
      </div>

      <!-- Budget -->
      <div class="bento-card reveal" data-delay="5" data-tilt>

  <div class="bento-shine"></div>

  <div class="relative z-10">

    <div class="bento-icon bg-gradient-to-br from-yellow-500/20 to-amber-500/20">
      <img 
        src="{{ asset('assets/images/home/budget-aware.webp') }}" 
        alt="Budget Awareness" 
        class="w-9 h-10 object-contain"
      >
    </div>

    <h3 class="text-lg font-bold mb-2 text-white">
      Budget Awareness
    </h3>

    <p class="text-sm text-white/80 leading-relaxed mb-3 text-justify">
      Stay aware of recurring expenses and monitor your spending 
      patterns for better financial control.
    </p>

    <div class="text-xs text-yellow-400/60 flex items-center gap-1">
      <i class="ri-line-chart-line"></i> Spending Control Insights
    </div>

  </div>

</div>

      <!-- Family -->
      <div class="bento-card reveal" data-delay="6" data-tilt>
        <div class="bento-shine"></div>
        <div class="relative z-10">
        <div class="bento-icon bg-gradient-to-br from-green-500/20 to-emerald-500/20">
  <img src="{{ asset('assets/images/home/family.webp') }}" 
       alt="Family Management" 
       class="w-9 h-10 object-contain">
</div>
<h3 class="text-lg font-bold mb-2 text-white">Family Management</h3>
          <p class="text-sm text-white/80 leading-relaxed mb-3 text-justify">Manage shared reminders across household members for better coordination and organised responsibilities.</p>
         <div class="text-xs text-green-400/60 flex items-center gap-1"><i class="ri-sparkling-line"></i> Shared Household Management</div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="section-divider"></div>

<!-- ===== TESTIMONIALS ===== -->
<section class="hidden relative py-5 md:py-10 section-dark overflow-hidden">
  <div class="gradient-blob w-[400px] h-[400px] bg-primary top-[-10%] left-[20%]"></div>
  <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8">
    <div class="text-center mb-16">
      <div class="badge bg-primary/10 border border-primary/20 text-purple-300 mx-auto mb-6 reveal">
        <span class="w-2 h-2 rounded-full bg-primary"></span> Social Proof
      </div>
      <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-5 reveal" data-delay="1">
        Loved by <span class="grad-text">Thousands</span>
      </h2>
      <p class="text-base text-white/35 max-w-lg mx-auto reveal" data-delay="2">Real stories from real users who transformed their financial habits.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="test-card reveal" data-delay="1">
        <div class="flex items-center gap-1 text-yellow-400 mb-4 text-sm">★★★★★</div>
        <p class="text-sm text-white/50 leading-relaxed mb-6">"I used to forget my car insurance renewal every year. Last year I lapsed for 2 weeks without knowing. DRemind notified me 30 days early this time — absolute lifesaver!"</p>
        <div class="flex items-center gap-3">
          <div class="w-11 h-11 rounded-full bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center text-sm font-bold text-white">SK</div>
          <div><div class="text-sm font-semibold">Sarah K.</div><div class="text-xs text-white/30">Marketing Manager</div></div>
        </div>
      </div>
      <div class="test-card reveal" data-delay="2">
        <div class="flex items-center gap-1 text-yellow-400 mb-4 text-sm">★★★★★</div>
        <p class="text-sm text-white/50 leading-relaxed mb-6">"The price comparison feature alone saved me $340 on my home insurance renewal. It found a better deal I never would have searched for on my own."</p>
        <div class="flex items-center gap-3">
          <div class="w-11 h-11 rounded-full bg-gradient-to-br from-cyan-400 to-blue-400 flex items-center justify-center text-sm font-bold text-white">MR</div>
          <div><div class="text-sm font-semibold">Mike R.</div><div class="text-xs text-white/30">Software Engineer</div></div>
        </div>
      </div>
      <div class="test-card reveal" data-delay="3">
        <div class="flex items-center gap-1 text-yellow-400 mb-4 text-sm">★★★★★</div>
        <p class="text-sm text-white/50 leading-relaxed mb-6">"As a mom managing our family's bills, subscriptions, and kids' activity fees — this app is a game changer. The family sharing feature keeps my husband in the loop too."</p>
        <div class="flex items-center gap-3">
          <div class="w-11 h-11 rounded-full bg-gradient-to-br from-green-400 to-emerald-400 flex items-center justify-center text-sm font-bold text-white">LM</div>
          <div><div class="text-sm font-semibold">Lisa M.</div><div class="text-xs text-white/30">Stay-at-Home Parent</div></div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="section-divider"></div>

<!-- ===== INTERACTIVE EXPERIENCE ===== -->
<section id="interactive" class="relative overflow-hidden bg-[#030014] py-24 md:py-32 section-alt">

  <!-- Ambient Glows -->
  <div class="absolute -top-24 -left-24 w-[600px] h-[600px] rounded-full pointer-events-none z-0"
       style="background:radial-gradient(circle,rgba(124,58,237,0.18) 0%,transparent 70%);filter:blur(120px);animation:glowDrift1 8s ease-in-out infinite alternate"></div>
  <div class="absolute -bottom-20 -right-20 w-[500px] h-[500px] rounded-full pointer-events-none z-0"
       style="background:radial-gradient(circle,rgba(6,182,212,0.12) 0%,transparent 70%);filter:blur(120px);animation:glowDrift2 10s ease-in-out infinite alternate"></div>

  <!-- Grid Overlay -->
  <div class="absolute inset-0 z-0 pointer-events-none"
       style="background-image:linear-gradient(rgba(255,255,255,0.025) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,0.025) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 80% 60% at 50% 50%,black 30%,transparent 100%)"></div>

  <style>
    @keyframes glowDrift1{from{transform:translate(0,0) scale(1)}to{transform:translate(60px,40px) scale(1.15)}}
    @keyframes glowDrift2{from{transform:translate(0,0) scale(1)}to{transform:translate(-40px,-30px) scale(1.1)}}
    @keyframes playPulse{0%,100%{box-shadow:0 0 0 0 rgba(124,58,237,.5),0 0 0 0 rgba(124,58,237,.3)}50%{box-shadow:0 0 0 16px rgba(124,58,237,0),0 0 0 32px rgba(124,58,237,0)}}

    #volumeSlider{-webkit-appearance:none;appearance:none;height:3px;background:rgba(255,255,255,.15);border-radius:3px;outline:none;cursor:pointer}
    #volumeSlider::-webkit-slider-thumb{-webkit-appearance:none;width:12px;height:12px;border-radius:50%;background:#7c3aed;cursor:pointer}
    #volumeSlider::-moz-range-thumb{width:12px;height:12px;border-radius:50%;background:#7c3aed;border:none;cursor:pointer}

    #demoProgress:hover #demoProgressFill{filter:brightness(1.25)}

    /* Controls hidden until first play */
    #demoControls{display:none}
    #demoControls.visible{display:flex}

    /* Scrollbar hide */
    #demoChapters,#demoThumbs{scrollbar-width:none}
    #demoChapters::-webkit-scrollbar,#demoThumbs::-webkit-scrollbar{display:none}

    .chap-tab{border-bottom:2px solid transparent;transition:color .2s,border-color .2s}
    .chap-tab:hover{color:rgba(255,255,255,.7)}
    .chap-tab.active{color:#c4b5fd;border-bottom-color:#7c3aed}

    .demo-thumb.active{border-color:rgba(124,58,237,.5)!important;box-shadow:0 4px 20px rgba(124,58,237,.2);transform:translateY(-2px)}
    .demo-thumb.active .thumb-title{color:#c4b5fd}
  </style>

  <!-- Inner -->
  <div class="relative z-10 max-w-[1200px] mx-auto px-6">

    <!-- Header -->
    <div class="text-center mb-14">
      
      <h2 class="text-4xl md:text-5xl font-black text-white leading-tight mb-4 reveal" data-delay="1">
        Explore How It <span class="grad-text">Works</span>
      </h2>
      <p class="text-white/90 text-base max-w-md mx-auto leading-relaxed reveal" data-delay="2">
        Watch how reminders are created, tracked, and managed in one place. Get a quick overview of how the system works in real use. 
      </p>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-6 items-start reveal" data-delay="3">

      <!-- Player Column -->
      <div>
        <div class="rounded-3xl overflow-hidden border border-purple-500/25 backdrop-blur-xl bg-[rgba(10,10,31,.8)]
                    shadow-[0_0_0_1px_rgba(255,255,255,.04),0_30px_80px_rgba(0,0,0,.6),0_0_60px_rgba(124,58,237,.1)]
                    hover:shadow-[0_0_0_1px_rgba(124,58,237,.3),0_30px_80px_rgba(0,0,0,.7),0_0_80px_rgba(124,58,237,.18)]
                    transition-shadow duration-300">

          <!-- Browser Bar -->
          <div class="flex items-center gap-3 px-4 py-2.5 bg-[rgba(15,15,42,.95)] border-b border-white/[.06]">
            <div class="flex gap-1.5">
              <div class="w-2.5 h-2.5 rounded-full bg-[#ff5f57]"></div>
              <div class="w-2.5 h-2.5 rounded-full bg-[#febc2e]"></div>
              <div class="w-2.5 h-2.5 rounded-full bg-[#28c840]"></div>
            </div>
            <div class="flex-1 flex items-center gap-1.5 bg-white/5 border border-white/[.08] rounded-md px-3 py-1">
              <i class="ri-lock-2-line text-accent text-[10px]"></i>
              <span class="text-[11px] text-white/30">app.billalert.co.uk/dashboard</span>
            </div>
            <span class="text-[9px] font-black tracking-widest px-2 py-0.5 rounded bg-purple-500/20 text-purple-300 border border-purple-500/30">HD</span>
          </div>

          <!-- Video Wrapper -->
         <div class="relative bg-black" style="aspect-ratio:16/9" id="demoVideoWrap">

              <!-- VIDEO with poster frame image -->
              <video id="demoVideo" preload="metadata"
                poster="{{ asset('assets/images/home/demo-frame.webp') }}"
                src="{{ asset('assets/video/demo.mp4') }}"
                class="w-full h-full object-cover block">
              </video>
            
              <!-- Play Overlay -->
              <div id="demoPlayOverlay" onclick="showComingSoon()"
                   class="absolute inset-0 z-10 flex flex-col items-center justify-center cursor-pointer
                          transition-opacity duration-300">
            
                <!-- Gradient overlay — sits ON TOP of poster image -->
                <div class="absolute inset-0"
                     style="background: linear-gradient(135deg, rgba(3,0,20,0.55), rgba(15,15,42,0.4));
                            backdrop-filter: blur(2px);
                            -webkit-backdrop-filter: blur(2px);">
                </div>
            
                <!-- Play button content — above the gradient -->
                <div class="relative z-10 flex flex-col items-center">
                  <div class="w-[72px] h-[72px] rounded-full flex items-center justify-center mb-3.5
                              transition-transform duration-200 hover:scale-110"
                       style="background: linear-gradient(135deg, #7c3aed, #06b6d4);
                              animation: playPulse 2.5s ease-in-out infinite">
                    <i class="ri-play-fill text-3xl text-white ml-1" id="overlayPlayIcon"></i>
                  </div>
                  <span class="text-[13px] font-bold text-white/70 tracking-widest uppercase">Watch Demo</span>
                  <span class="text-[11px] text-white/35 mt-1">1 min 58 sec · No signup required</span>
                </div>
              </div>
            
              <!-- Video Controls (hidden until first play) -->
              <div id="demoControls"
                   class="absolute bottom-0 left-0 right-0 z-20 px-4 py-3
                          bg-gradient-to-t from-black/80 to-transparent
                          opacity-0 transition-opacity duration-300"
                   style="display: none;">
            
                <!-- Progress Bar -->
                <div id="demoProgress"
                     class="w-full h-1.5 bg-white/20 rounded-full cursor-pointer mb-3 relative"
                     onclick="scrubVideo(event)">
                  <div id="demoProgressFill"
                       class="h-full rounded-full"
                       style="width: 0%; background: linear-gradient(90deg, #7c3aed, #06b6d4);">
                  </div>
                </div>
            
                <!-- Controls Row -->
                <div class="flex items-center gap-3">
            
                  <!-- Skip Back -->
                  <button onclick="skipBack()" class="text-white/70 hover:text-white transition-colors" title="Back 10s">
                    <i class="ri-skip-back-mini-fill text-lg"></i>
                  </button>
            
                  <!-- Play / Pause -->
                  <button onclick="togglePlay()" class="text-white hover:text-white/80 transition-colors" title="Play/Pause">
                    <i class="ri-play-fill text-xl" id="ctrlPlayIcon"></i>
                  </button>
            
                  <!-- Skip Forward -->
                  <button onclick="skipForward()" class="text-white/70 hover:text-white transition-colors" title="Forward 10s">
                    <i class="ri-skip-forward-mini-fill text-lg"></i>
                  </button>
            
                  <!-- Time -->
                  <span id="demoTime" class="text-[11px] text-white/50 ml-1 tabular-nums">0:00 / 0:00</span>
            
                  <div class="flex-1"></div>
            
                  <!-- Volume Toggle -->
                  <button onclick="toggleMute()" class="text-white/70 hover:text-white transition-colors" title="Mute">
                    <i class="ri-volume-up-line text-lg" id="muteIcon"></i>
                  </button>
            
                  <!-- Volume Slider -->
                  <input id="volumeSlider" type="range" min="0" max="1" step="0.05" value="1"
                         class="w-16 accent-violet-500"
                         oninput="setVolume(this.value)" />
            
                  <!-- Speed -->
                  <button id="speedBtn" onclick="cycleSpeed()"
                          class="text-[11px] font-bold text-white/60 hover:text-white transition-colors w-8 text-center">
                    1×
                  </button>
            
                  <!-- PiP -->
                  <button onclick="togglePiP()" class="text-white/70 hover:text-white transition-colors hidden sm:block" title="Picture in Picture">
                    <i class="ri-picture-in-picture-line text-lg"></i>
                  </button>
            
                  <!-- Fullscreen -->
                  <button onclick="toggleFullscreen()" class="text-white/70 hover:text-white transition-colors" title="Fullscreen">
                    <i class="ri-fullscreen-line text-lg" id="fsIcon"></i>
                  </button>
            
                </div>
              </div>
            </div>
            
            <!-- ============================================================
                 Styles
                 ============================================================ -->
            <style>
              @keyframes playPulse {
                0%, 100% { box-shadow: 0 0 0 0 rgba(124, 58, 237, 0.4); }
                50%       { box-shadow: 0 0 0 14px rgba(124, 58, 237, 0); }
              }
            
              #demoControls.visible {
                display: block !important;
                opacity: 1 !important;
              }
            
              #demoVideoWrap:hover #demoControls.visible {
                opacity: 1;
              }
            </style>

          <!-- Controls — hidden until first play -->
          <div id="demoControls" class="flex-col gap-2 px-4 py-3 bg-[rgba(10,10,28,.95)] border-t border-white/[.06]">
            <!-- Progress Bar -->
            <div id="demoProgress"
                onclick="scrubVideo(event)"
                style="position:relative; z-index:20;"
                class="relative h-1 bg-white/10 rounded-full cursor-pointer overflow-hidden">
              <div id="demoProgressFill"
                   class="h-full w-0 rounded-full transition-[width] duration-150 ease-linear"
                   style="background:linear-gradient(90deg,#7c3aed,#06b6d4)"></div>
            </div>
            <!-- Control Row -->
            <div class="flex items-center gap-3">
              <button onclick="togglePlay()" title="Play/Pause"
                      class="flex items-center p-1 rounded-md text-base text-white/50 hover:text-white hover:bg-white/[.08] transition-all duration-150">
                <i class="ri-play-fill" id="ctrlPlayIcon"></i>
              </button>
              <button onclick="skipBack()" title="Skip back 10s"
                      class="flex items-center p-1 rounded-md text-base text-white/50 hover:text-white hover:bg-white/[.08] transition-all duration-150">
                <i class="ri-replay-10-line"></i>
              </button>
              <button onclick="skipForward()" title="Skip forward 10s"
                      class="flex items-center p-1 rounded-md text-base text-white/50 hover:text-white hover:bg-white/[.08] transition-all duration-150">
                <i class="ri-forward-10-line"></i>
              </button>
              <div class="flex items-center gap-1.5">
                <button onclick="toggleMute()" title="Mute"
                        class="flex items-center p-1 rounded-md text-base text-white/50 hover:text-white hover:bg-white/[.08] transition-all duration-150">
                  <i class="ri-volume-up-line" id="muteIcon"></i>
                </button>
                <input type="range" id="volumeSlider" min="0" max="1" step="0.05" value="1" class="w-[70px]" oninput="setVolume(this.value)">
              </div>
              <span id="demoTime" class="text-[11px] text-white/35 tabular-nums min-w-[80px]">0:00 / 1:58</span>
              <div class="flex-1"></div>
              <button id="speedBtn" onclick="cycleSpeed()" title="Playback speed"
                      class="text-[10px] font-bold tracking-wide px-2 py-0.5 rounded border border-white/10 bg-white/5 text-white/40
                             hover:border-purple-500 hover:text-purple-300 transition-all duration-150">1×</button>
              <button onclick="togglePiP()" title="Picture-in-Picture"
                      class="flex items-center p-1 rounded-md text-base text-white/50 hover:text-white hover:bg-white/[.08] transition-all duration-150">
                <i class="ri-picture-in-picture-line"></i>
              </button>
              <button onclick="toggleFullscreen()" title="Fullscreen"
                      class="flex items-center p-1 rounded-md text-base text-white/50 hover:text-white hover:bg-white/[.08] transition-all duration-150">
                <i class="ri-fullscreen-line" id="fsIcon"></i>
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="flex flex-col gap-4">

        <!-- What You'll See -->
        <div class="rounded-2xl border border-white/[.07] bg-[rgba(10,10,31,.7)] backdrop-blur-xl p-[18px]
                    hover:border-purple-500/30 hover:shadow-[0_8px_30px_rgba(124,58,237,.08)] transition-all duration-200">
          <h4 class="flex items-center gap-2 text-[11px] font-bold text-white/90 uppercase tracking-widest mb-3">
            <i class="ri-star-line text-purple-500"></i>Demo Highlights
          </h4>
          <div class="flex flex-col gap-2.5">
            <div class="flex items-start gap-2.5">
              <div class="w-[30px] h-[30px] rounded-lg flex-shrink-0 flex items-center justify-center text-sm bg-purple-500/15">
                <i class="ri-layout-grid-line text-purple-400"></i>
              </div>
              <div>
                <strong class="block text-[12px] text-white font-bold mb-0.5">Reminder Dashboard</strong>
                <span class="text-[10px] text-white/80 leading-snug">Overview of upcoming, completed, and overdue reminders.</span>
              </div>
            </div>
            <div class="flex items-start gap-2.5">
              <div class="w-[30px] h-[30px] rounded-lg flex-shrink-0 flex items-center justify-center text-sm bg-emerald-500/10">
                <i class="ri-notification-3-line text-emerald-400"></i>
              </div>
              <div>
                <strong class="block text-[12px] text-white font-bold mb-0.5">Multi-Channel Alerts</strong>
                <span class="text-[10px] text-white/80 leading-snug">Receive alerts via email and push notifications.</span>
              </div>
            </div>
            <div class="flex items-start gap-2.5">
              <div class="w-[30px] h-[30px] rounded-lg flex-shrink-0 flex items-center justify-center text-sm bg-cyan-500/10">
                <i class="ri-group-line text-cyan-400"></i>
              </div>
              <div>
                <strong class="block text-[12px] text-white font-bold mb-0.5">Shared Reminders</strong>
                <span class="text-[10px] text-white/80 leading-snug">Coordinate reminders across family or shared responsibilities.</span>
              </div>
            </div>
            <div class="flex items-start gap-2.5">
              <div class="w-[30px] h-[30px] rounded-lg flex-shrink-0 flex items-center justify-center text-sm bg-amber-500/10">
                <i class="ri-bar-chart-2-line text-amber-400"></i>
              </div>
              <div>
                <strong class="block text-[12px] text-white font-bold mb-0.5">Activity Overview</strong>
                <span class="text-[10px] text-white/80 leading-snug">Track reminder status and recent activity in one place.</span>
              </div>
            </div>
          </div>
        </div>

        <!-- CTA -->
        <div class="rounded-2xl border border-purple-500/30 p-5 text-center"
             style="background:linear-gradient(135deg,rgba(124,58,237,.15),rgba(6,182,212,.08))">
          <i class="ri-vip-crown-line text-3xl text-purple-300 block mb-2.5"></i>
          <p class="text-[11px] text-white/80 mb-3 leading-relaxed">
            Ready to get started with your <strong class="text-white">reminders?</strong>.
          </p>
          <a href="register"
             class="flex items-center justify-center gap-2 w-full px-5 py-2.5 rounded-xl text-white text-[12px] font-bold
                    transition-all duration-200 hover:-translate-y-0.5 hover:shadow-[0_8px_24px_rgba(124,58,237,.4)]"
             style="background:linear-gradient(135deg,#7c3aed,#6d28d9)">
            <i class="ri-arrow-right-circle-line"></i>Create Your Account Now
          </a>
        </div>

      </div>
    </div>
  </div>
  
  <!-- Coming Soon Modal -->
    <div id="comingSoonModal" class="fixed inset-0 z-[999] flex items-center justify-center px-4" style="display:none;">
      <div id="csOverlay" class="absolute inset-0 bg-black/70" style="backdrop-filter:blur(6px);-webkit-backdrop-filter:blur(6px);" onclick="closeComingSoon()"></div>
    
      <div class="relative z-10 w-full max-w-sm rounded-2xl border border-purple-500/25 p-8 text-center"
           style="background:linear-gradient(145deg,rgba(15,15,42,.97),rgba(10,10,31,.97));
                  box-shadow:0 0 0 1px rgba(255,255,255,.05),0 30px 80px rgba(0,0,0,.6),0 0 60px rgba(124,58,237,.15);
                  animation:csPop .35s cubic-bezier(.34,1.56,.64,1);">
    
        <button onclick="closeComingSoon()"
                class="absolute top-3 right-3 w-8 h-8 rounded-full flex items-center justify-center text-white/40 hover:text-white hover:bg-white/10 transition-all duration-150">
          <i class="ri-close-line text-lg"></i>
        </button>
    
        <div class="w-16 h-16 mx-auto rounded-2xl flex items-center justify-center mb-5"
             style="background:linear-gradient(135deg,rgba(124,58,237,.18),rgba(6,182,212,.12));
                    border:1px solid rgba(124,58,237,.25);">
          <i class="ri-rocket-2-line text-3xl" style="color:#c4b5fd;"></i>
        </div>
    
        <h3 class="text-xl font-bold text-white mb-2">Demo Launching Soon</h3>
        <p class="text-sm text-white/40 leading-relaxed mb-6">
          We're finalising our interactive demo to give you the best experience. It will be available shortly.
        </p>
    
        <button onclick="closeComingSoon()"
                class="w-full px-5 py-2.5 rounded-xl text-white text-sm font-bold flex items-center justify-center gap-2
                       transition-all duration-200 hover:-translate-y-0.5 hover:shadow-[0_8px_24px_rgba(124,58,237,.4)]"
                style="background:linear-gradient(135deg,#7c3aed,#06b6d4);">
          <i class="ri-check-line"></i> Got It
        </button>
      </div>
    </div>
    
    <style>
      @keyframes csPop { from { opacity:0; transform:scale(.9) translateY(10px); } to { opacity:1; transform:scale(1) translateY(0); } }
    </style>

  <script>
    (function () {
      const video        = document.getElementById('demoVideo');
      const overlay      = document.getElementById('demoPlayOverlay');
      const overlayIcon  = document.getElementById('overlayPlayIcon');
      const ctrlPlayIcon = document.getElementById('ctrlPlayIcon');
      const controls     = document.getElementById('demoControls');
      const progressFill = document.getElementById('demoProgressFill');
      const timeEl       = document.getElementById('demoTime');
      const muteIcon     = document.getElementById('muteIcon');
      const speedBtn     = document.getElementById('speedBtn');
      const fsIcon       = document.getElementById('fsIcon');

      const speeds   = [0.5, 0.75, 1, 1.25, 1.5, 2];
      let speedIdx   = 2;
      let hasStarted = false;

      const chapters = [0, 22, 48, 75, 100];

      function fmtTime(s) {
        return `${Math.floor(s / 60)}:${Math.floor(s % 60).toString().padStart(2, '0')}`;
      }

      function setPlayUI(playing) {
        const icon = playing ? 'ri-pause-fill' : 'ri-play-fill';
        ctrlPlayIcon.className = icon;
        overlayIcon.className  = icon;
      }
      
      window.showComingSoon = function () {
          document.getElementById('comingSoonModal').style.display = 'flex';
          document.body.style.overflow = 'hidden';
        };
        
        window.closeComingSoon = function () {
          document.getElementById('comingSoonModal').style.display = 'none';
          document.body.style.overflow = '';
        };

      window.togglePlay = function () {
        if (!video || video.tagName !== 'VIDEO') return;
        if (video.paused) {
          video.play();
          overlay.style.opacity       = '0';
          overlay.style.pointerEvents = 'none';
          setPlayUI(true);
          if (!hasStarted) {
            hasStarted = true;
            controls.classList.add('visible');
          }
        } else {
          video.pause();
          overlay.style.opacity       = '1';
          overlay.style.pointerEvents = 'auto';
          setPlayUI(false);
        }
      };

      window.skipBack    = () => { if (video) video.currentTime = Math.max(0, video.currentTime - 10); };
      window.skipForward = () => { if (video) video.currentTime = Math.min(video.duration || 0, video.currentTime + 10); };

      window.scrubVideo = function (e) {
        if (!video || !video.duration) return; // wait until metadata ready

        const progress = document.getElementById('demoProgress');
        const rect = progress.getBoundingClientRect();

        let percent = (e.clientX - rect.left) / rect.width;

        // clamp between 0 and 1
        percent = Math.max(0, Math.min(1, percent));

        video.currentTime = percent * video.duration;
      };

      window.setVolume = function (val) {
        if (!video) return;
        video.volume       = val;
        muteIcon.className = val == 0 ? 'ri-volume-mute-line' : 'ri-volume-up-line';
      };

      window.toggleMute = function () {
        if (!video) return;
        video.muted        = !video.muted;
        muteIcon.className = video.muted ? 'ri-volume-mute-line' : 'ri-volume-up-line';
        document.getElementById('volumeSlider').value = video.muted ? 0 : video.volume;
      };

      window.cycleSpeed = function () {
        if (!video) return;
        speedIdx             = (speedIdx + 1) % speeds.length;
        video.playbackRate   = speeds[speedIdx];
        speedBtn.textContent = speeds[speedIdx] + '×';
      };

      window.togglePiP = function () {
        if (!video) return;
        document.pictureInPictureElement ? document.exitPictureInPicture() : video.requestPictureInPicture?.();
      };

      window.toggleFullscreen = function () {
        const wrap = document.getElementById('demoVideoWrap');
        if (!document.fullscreenElement) {
          wrap.requestFullscreen?.();
          fsIcon.className = 'ri-fullscreen-exit-line';
        } else {
          document.exitFullscreen?.();
          fsIcon.className = 'ri-fullscreen-line';
        }
      };

      if (video) {
        video.addEventListener('timeupdate', () => {
          if (!video.duration) return;
          progressFill.style.width = (video.currentTime / video.duration * 100) + '%';
          timeEl.textContent       = `${fmtTime(video.currentTime)} / ${fmtTime(video.duration)}`;
          let ac = 0;
          chapters.forEach((t, i) => { if (video.currentTime >= t) ac = i; });
          document.querySelectorAll('.chap-tab').forEach((t, i)  => t.classList.toggle('active', i === ac));
          document.querySelectorAll('.demo-thumb').forEach((t, i) => t.classList.toggle('active', i === ac));
        });

        video.addEventListener('ended', () => {
          overlay.style.opacity       = '1';
          overlay.style.pointerEvents = 'auto';
          setPlayUI(false);
        });
      }
    })();
    
  </script>
</section>


<div class="section-divider"></div>
<!-- ===== CTA ===== -->
<!-- <section id="cta" class="relative py-28 md:py-40 section-dark overflow-hidden">
  <div id="grid-distortion-container" style="width: 100%; top: 0; height: 100%; position: absolute;"></div>

  <div class="gradient-blob w-[600px] h-[600px] bg-primary top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 !opacity-10"></div>
  <div class="gradient-blob w-[400px] h-[400px] bg-secondary top-[20%] right-[10%] !opacity-10"></div>
  <div class="relative z-10 max-w-3xl mx-auto px-6 lg:px-8 text-center">
    <div class="glass-strong p-10 md:p-16 lg:p-20 reveal-scale">
      <div class="badge bg-accent/10 border border-accent/20 text-emerald-300 mx-auto mb-8">
        <span class="w-2 h-2 rounded-full bg-accent animate-pulse"></span> Available Now — 100% 
      </div>
      <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black mb-6 leading-tight">
        Start Remembering<br><span class="text-shimmer">Smarter Today.</span>
      </h2>
      <p class="text-base md:text-lg text-white/40 mb-10 max-w-md mx-auto leading-relaxed">
        Download Winngoo DRemind and join 50,000+ users who never miss an important payment.  forever for personal use.
      </p>
      <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-8">
        <a href="#" class="btn-cta bg-gradient-to-r from-primary to-purple-600 group">
          <i class="ri-google-play-fill text-xl group-hover:scale-110 transition-transform"></i>
          Google Play
        </a>
        <a href="#" class="btn-cta bg-gradient-to-r from-secondary to-cyan-600 group">
          <i class="ri-apple-fill text-xl group-hover:scale-110 transition-transform"></i>
          App Store
        </a>
      </div>
      <div class="flex flex-wrap items-center justify-center gap-4 text-xs text-white/25">
        <span class="flex items-center gap-1"><i class="ri-bank-card-line"></i> No credit card</span>
        <span class="flex items-center gap-1"><i class="ri-smartphone-line"></i> iOS & Android</span>
        <span class="flex items-center gap-1"><i class="ri-timer-line"></i> Setup in 2 min</span>
      </div>
    </div>
  </div>
</section> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="{{ asset('assets/js/distortion.js') }}"></script>

<script src="{{ asset('assets/js/script.js') }}"></script>

@endsection
