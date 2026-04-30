@extends('layouts.app')
@section('content')



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

  <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 w-full py-32 lg:py-0 top-[60px]">
    <div class="flex flex-col lg:flex-row items-center gap-16 lg:gap-12 xl:gap-20">
      <div class="flex-1 max-w-2xl reveal-left">
        <h1 class="text-[44px] sm:text-[56px] md:text-[64px] lg:text-[72px] xl:text-[80px] font-black leading-[1.05] tracking-tight mb-6">
          Never Miss<br>
          <span class="grad-text">A Payment</span><br>
          Again.
        </h1>
        <p class="text-lg md:text-xl text-white/40 mb-4 max-w-lg leading-relaxed">
          Winngoo DRemind intelligently tracks your bills, subscriptions, insurance renewals, and important dates — so you don't have to.
        </p>
        <p class="text-sm text-white/30 mb-10 max-w-lg">
          Join 50,000+ users who save an average of $480/year by never missing payments or catching better renewal deals.
        </p>
        <div class="flex flex-wrap gap-4 mb-10">
          <a href="#cta" class="btn-primary">
            <i class="ri-download-cloud-line text-xl"></i>
            Download 
          </a>
          <a href="#features" class="btn-secondary">
            Explore Features <i class="ri-arrow-right-line"></i>
          </a>
        </div>
        <!-- Trust row -->
        <div class="flex flex-wrap items-center gap-6 text-xs text-white/30">
          <div class="flex items-center gap-1.5">
            <span class="text-yellow-400 text-sm">★★★★★</span>
            <span>4.9 Rating</span>
          </div>
          <div class="flex items-center gap-1.5">
            <i class="ri-shield-check-line text-accent text-sm"></i>
            <span>Bank-Grade Security</span>
          </div>
        </div>
      </div>
      <!-- Phone -->
      <div class="flex-shrink-0 reveal-right" data-delay="2">
        <div class="phone-float relative">
          <div class="phone-glow"></div>
          <div class="phone-mock">
            <div class="phone-notch"></div>
            <div class="phone-screen" id="phoneScreen"></div>
          </div>
          <!-- Floating notification badges around phone -->
          <div class="absolute -top-4 -right-8 glass px-4 py-2 !rounded-xl animate-bounce" style="animation-duration:3s">
            <div class="flex items-center gap-2 text-xs">
              <i class="ri-notification-3-fill text-yellow-400"></i>
              <span class="text-white/70">Netflix due tomorrow!</span>
            </div>
          </div>
          <div class="absolute -bottom-2 -left-12 glass px-4 py-2 !rounded-xl animate-bounce" style="animation-duration:4s;animation-delay:1.5s">
            <div class="flex items-center gap-2 text-xs">
              <i class="ri-money-dollar-circle-fill text-accent"></i>
              <span class="text-white/70">$34 saved this month</span>
            </div>
          </div>
        </div>
      </div>
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
        <span class="w-2 h-2 rounded-full bg-secondary"></span> Simple Process
      </div>
      <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-5 reveal" data-delay="1">
        How <span class="grad-text">It Works</span>
      </h2>
      <p class="text-base md:text-lg text-white/35 max-w-xl mx-auto reveal" data-delay="2">
        Register in three simple steps and take control of your payments forever.
      </p>
    </div>
    <div class="relative">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-6 relative z-10">
        <!-- Step 1 -->
        <div class="step-card reveal" data-delay="1">
          <div class="p-5 step-icon bg-primary/10 text-primary icon-pulse"><i class="text-5xl ri-add-circle-line"></i></div>
          <h3 class="text-xl font-bold mb-3">Add Your Reminders</h3>
          <p class="text-sm text-white/40 leading-relaxed mb-5">Set up your bills, subscriptions, insurance policies, and any important dates you want to track.</p>
          <div class="flex flex-wrap justify-center gap-2">
            <span class="text-xs px-3 py-1.5 rounded-full bg-primary/10 text-primary border border-primary/20 flex items-center gap-1.5"><i class="ri-bank-card-line text-[10px]"></i>Bills</span>
            <span class="text-xs px-3 py-1.5 rounded-full bg-secondary/10 text-secondary border border-secondary/20 flex items-center gap-1.5"><i class="ri-play-circle-line text-[10px]"></i>Subscriptions</span>
            <span class="text-xs px-3 py-1.5 rounded-full bg-accent/10 text-accent border border-accent/20 flex items-center gap-1.5"><i class="ri-shield-line text-[10px]"></i>Insurance</span>
          </div>
        </div>
        <!-- Step 2 -->
        <div class="step-card reveal" data-delay="2">
          <div class="p-5 step-icon bg-secondary/10 text-secondary icon-pulse"><i class="text-5xl ri-notification-badge-line"></i></div>
          <h3 class="text-xl font-bold mb-3">Get Smart Alerts</h3>
          <p class="text-sm text-white/40 leading-relaxed mb-5">Receive intelligent notifications days before Dates. Our AI learns your preferred timing for alerts.</p>
          <div class="flex flex-wrap justify-center gap-2">
            <span class="text-xs px-3 py-1.5 rounded-full bg-yellow-500/10 text-yellow-400 border border-yellow-500/20 flex items-center gap-1.5"><i class="ri-smartphone-line text-[10px]"></i>Push</span>
            <span class="text-xs px-3 py-1.5 rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/20 flex items-center gap-1.5"><i class="ri-mail-line text-[10px]"></i>Email</span>
            <span class="text-xs px-3 py-1.5 rounded-full bg-pink-500/10 text-pink-400 border border-pink-500/20 flex items-center gap-1.5"><i class="ri-message-2-line text-[10px]"></i>SMS</span>
          </div>
        </div>
        <!-- Step 3 -->
        <div class="step-card reveal" data-delay="3">
          <div class="p-5 step-icon bg-accent/10 text-accent icon-pulse"><i class="text-5xl ri-wallet-3-line"></i></div>
          <h3 class="text-xl font-bold mb-3">Save Money</h3>
          <p class="text-sm text-white/40 leading-relaxed mb-5">Compare prices before renewals, avoid late fees, and save hundreds of dollars every year effortlessly.</p>
          <div class="flex flex-wrap justify-center gap-2">
            <span class="text-xs px-3 py-1.5 rounded-full bg-red-500/10 text-red-400 border border-red-500/20 flex items-center gap-1.5"><i class="ri-close-circle-line text-[10px]"></i>No Late Fees</span>
            <span class="text-xs px-3 py-1.5 rounded-full bg-green-500/10 text-green-400 border border-green-500/20 flex items-center gap-1.5"><i class="ri-trophy-line text-[10px]"></i>Best Deals</span>
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
        <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span> Global Network
      </div>
      <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-5 reveal" data-delay="1">
        Trusted <span class="grad-text">Worldwide</span>
      </h2>
      <p class="text-base md:text-lg text-white/35 max-w-xl mx-auto reveal" data-delay="2">
        Our intelligent network spans the globe, protecting users' finances across 140+ countries.
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
            <div class="w-11 h-11 rounded-xl bg-primary/15 flex items-center justify-center text-xl flex-shrink-0 mt-0.5 text-purple-400"><i class="ri-brain-line"></i></div>
            <div>
              <h3 class="text-lg font-bold mb-2">Predictive Analytics</h3>
              <p class="text-sm text-white/40 leading-relaxed">Analyzes your spending patterns to predict upcoming payments and suggest budget optimizations before you even think about them.</p>
            </div>
          </div>
        </div>
        <div class="glass p-7 reveal" data-delay="2">
          <div class="flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl bg-secondary/15 flex items-center justify-center text-xl flex-shrink-0 mt-0.5 text-cyan-400"><i class="ri-flashlight-line"></i></div>
            <div>
              <h3 class="text-lg font-bold mb-2">Real-Time Monitoring</h3>
              <p class="text-sm text-white/40 leading-relaxed">Continuously monitors subscription price changes, new competitor offers, and policy updates so you always have the best deal.</p>
            </div>
          </div>
        </div>
        <div class="glass p-7 reveal" data-delay="3">
          <div class="flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl bg-accent/15 flex items-center justify-center text-xl flex-shrink-0 mt-0.5 text-emerald-400"><i class="ri-lock-2-line"></i></div>
            <div>
              <h3 class="text-lg font-bold mb-2">Bank-Grade Security</h3>
              <p class="text-sm text-white/40 leading-relaxed">256-bit AES encryption, biometric authentication, and zero-knowledge architecture. We never store sensitive payment data.</p>
            </div>
          </div>
        </div>
        <div class="glass p-7 reveal" data-delay="4">
          <div class="flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl bg-pink-500/15 flex items-center justify-center text-xl flex-shrink-0 mt-0.5 text-pink-400"><i class="ri-bar-chart-grouped-line"></i></div>
            <div>
              <h3 class="text-lg font-bold mb-2">Spending Insights Dashboard</h3>
              <p class="text-sm text-white/40 leading-relaxed">Visual breakdowns of where your money goes each month. Track trends, identify wasteful subscriptions, and optimize expenses.</p>
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
        Built For <span class="grad-text">Everyone</span>
      </h2>
      <p class="text-base md:text-lg text-white/35 max-w-xl mx-auto reveal" data-delay="2">
        From individuals to families and small businesses — DRemind adapts to your life.
      </p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="bentoGrid">
      <!-- Featured large card -->
      <div class="bento-card lg:col-span-2 lg:row-span-2 reveal" data-particles="white" data-p-direction="down" data-p-speed="0.8" data-p-connect="false" data-p-count="100" data-p-shape="circle">
        <div class="bento-shine"></div>
        <div class="relative z-10">
          <div class="bento-icon bg-gradient-to-br from-primary/20 to-purple-600/20 text-purple-400"><i class="ri-smartphone-line"></i></div>
          <h3 class="text-2xl font-bold mb-3 text-white">Track All Subscriptions</h3>
          <p class="text-sm text-white/40 leading-relaxed mb-6 max-w-md">Keep all your streaming, software, and membership subscriptions organized in one unified dashboard. See exactly what you're paying and when.</p>
          <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
            <div class="glass !rounded-xl p-3 text-center">
              <div class="text-2xl mb-1"><i class="ri-netflix-fill text-red-500"></i></div>
              <div class="text-xs text-white/40">Netflix</div>
              <div class="text-xs font-bold text-white/70">$15.99</div>
            </div>
            <div class="glass !rounded-xl p-3 text-center">
              <div class="text-2xl mb-1"><i class="ri-spotify-fill text-green-500"></i></div>
              <div class="text-xs text-white/40">Spotify</div>
              <div class="text-xs font-bold text-white/70">$9.99</div>
            </div>
            <div class="glass !rounded-xl p-3 text-center">
              <div class="text-2xl mb-1"><i class="ri-cloud-line text-blue-400"></i></div>
              <div class="text-xs text-white/40">iCloud</div>
              <div class="text-xs font-bold text-white/70">$2.99</div>
            </div>
            <div class="glass !rounded-xl p-3 text-center">
              <div class="text-2xl mb-1"><i class="ri-gamepad-line text-purple-400"></i></div>
              <div class="text-xs text-white/40">PS Plus</div>
              <div class="text-xs font-bold text-white/70">$13.99</div>
            </div>
          </div>
          <div class="flex items-center gap-4 text-xs text-white/30">
            <span class="flex items-center gap-1"><i class="ri-check-line text-accent"></i> Auto-detect 200+ services</span>
            <span class="flex items-center gap-1"><i class="ri-check-line text-accent"></i> Cancel unused subs</span>
          </div>
        </div>
      </div>
      <!-- Insurance -->
      <div class="bento-card reveal" data-delay="2" data-tilt>
        <div class="bento-shine"></div>
        <div class="relative z-10">
          <div class="bento-icon bg-gradient-to-br from-red-500/20 to-orange-500/20 text-red-400"><i class="ri-shield-check-line"></i></div>
          <h3 class="text-lg font-bold mb-2 text-white">Insurance Alerts</h3>
          <p class="text-sm text-white/40 leading-relaxed mb-4">Get warned 30, 14, and 3 days before any insurance policy expires.</p>
          <div class="flex gap-2 flex-wrap">
            <span class="text-[10px] px-2 py-1 rounded-full bg-red-500/10 text-red-400 border border-red-500/15">Auto</span>
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
          <div class="bento-icon bg-gradient-to-br from-yellow-500/20 to-amber-500/20 text-yellow-400"><i class="ri-exchange-dollar-line"></i></div>
          <h3 class="text-lg font-bold mb-2 text-white">Price Comparison</h3>
          <p class="text-sm text-white/40 leading-relaxed mb-4">Before auto-renew, DRemind checks if there's a better deal available.</p>
          <div class="glass !rounded-xl p-3">
            <div class="flex justify-between items-center text-xs"><span class="text-white/50">Avg. saving per switch</span><span class="text-accent font-bold">$120</span></div>
            <div class="mt-2 h-1.5 rounded-full bg-white/5 overflow-hidden"><div class="h-full w-3/4 rounded-full bg-gradient-to-r from-accent to-emerald-400"></div></div>
          </div>
        </div>
      </div>
      <!-- Renewal -->
      <div class="bento-card reveal" data-delay="4" data-tilt>
        <div class="bento-shine"></div>
        <div class="relative z-10">
          <div class="bento-icon bg-gradient-to-br from-cyan-500/20 to-blue-500/20 text-cyan-400"><i class="ri-alarm-warning-line"></i></div>
          <h3 class="text-lg font-bold mb-2 text-white">Renewal Notifications</h3>
          <p class="text-sm text-white/40 leading-relaxed mb-3">Annual domains, software licenses, warranties — nothing slips through.</p>
          <div class="text-xs text-cyan-400/60 flex items-center gap-1"><i class="ri-timer-flash-line"></i> Smart timing alerts</div>
        </div>
      </div>
      <!-- Budget -->
      <div class="bento-card reveal" data-delay="5" data-tilt>
        <div class="bento-shine"></div>
        <div class="relative z-10">
          <div class="bento-icon bg-gradient-to-br from-pink-500/20 to-rose-500/20 text-pink-400"><i class="ri-funds-line"></i></div>
          <h3 class="text-lg font-bold mb-2 text-white">Smart Budget Alerts</h3>
          <p class="text-sm text-white/40 leading-relaxed mb-3">Set monthly spending limits and get alerted when near your cap.</p>
          <div class="text-xs text-pink-400/60 flex items-center gap-1"><i class="ri-sparkling-line"></i> AI-powered insights</div>
        </div>
      </div>
      <!-- Family -->
      <div class="bento-card reveal" data-delay="6" data-tilt>
        <div class="bento-shine"></div>
        <div class="relative z-10">
          <div class="bento-icon bg-gradient-to-br from-green-500/20 to-emerald-500/20 text-green-400"><i class="ri-parent-line"></i></div>
          <h3 class="text-lg font-bold mb-2 text-white">Family Management</h3>
          <p class="text-sm text-white/40 leading-relaxed mb-3">Share household bills and subscriptions with up to 6 family members.</p>
          <div class="flex -space-x-2 mt-2">
            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-purple-400 to-pink-400 border-2 border-card"></div>
            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-cyan-400 to-blue-400 border-2 border-card"></div>
            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-green-400 to-emerald-400 border-2 border-card"></div>
            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-yellow-400 to-orange-400 border-2 border-card flex items-center justify-center text-[9px] font-bold text-dark">+3</div>
          </div>
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
      <div class="badge bg-accent/10 border border-accent/20 text-emerald-300 mx-auto mb-6 w-fit reveal">
        <span class="w-2 h-2 rounded-full bg-accent animate-pulse"></span> Interactive Demo
      </div>
      <h2 class="text-4xl md:text-5xl font-black text-white leading-tight mb-4 reveal" data-delay="1">
        See It In <span class="grad-text">Action</span>
      </h2>
      <p class="text-white/35 text-base max-w-md mx-auto leading-relaxed reveal" data-delay="2">
        Watch how BillAlert keeps you ahead of every renewal, deadline, and subscription — in under 2 minutes.
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
            <video id="demoVideo" preload="metadata"
              src="{{ asset('assets/video/demo.mp4') }}"
              class="w-full h-full object-cover block">
            </video>

            <!-- Play Overlay -->
            <div id="demoPlayOverlay" onclick="togglePlay()"
                 class="absolute inset-0 z-10 flex flex-col items-center justify-center cursor-pointer
                        transition-opacity duration-300
                        bg-gradient-to-br from-[rgba(3,0,20,.7)] to-[rgba(15,15,42,.5)] backdrop-blur-sm">
              <div class="w-[72px] h-[72px] rounded-full flex items-center justify-center mb-3.5
                          transition-transform duration-200 hover:scale-110"
                   style="background:linear-gradient(135deg,#7c3aed,#06b6d4);animation:playPulse 2.5s ease-in-out infinite">
                <i class="ri-play-fill text-3xl text-white ml-1" id="overlayPlayIcon"></i>
              </div>
              <span class="text-[13px] font-bold text-white/70 tracking-widest uppercase">Watch Demo</span>
              <span class="text-[11px] text-white/35 mt-1">1 min 58 sec · No signup required</span>
            </div>
          </div>

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
          <h4 class="flex items-center gap-2 text-[11px] font-bold text-white/50 uppercase tracking-widest mb-3">
            <i class="ri-star-line text-purple-500"></i>What You'll See
          </h4>
          <div class="flex flex-col gap-2.5">
            <div class="flex items-start gap-2.5">
              <div class="w-[30px] h-[30px] rounded-lg flex-shrink-0 flex items-center justify-center text-sm bg-purple-500/15">
                <i class="ri-layout-grid-line text-purple-400"></i>
              </div>
              <div>
                <strong class="block text-[12px] text-white font-bold mb-0.5">Smart Dashboard</strong>
                <span class="text-[10px] text-white/30 leading-snug">All bills at a glance with urgency sorting</span>
              </div>
            </div>
            <div class="flex items-start gap-2.5">
              <div class="w-[30px] h-[30px] rounded-lg flex-shrink-0 flex items-center justify-center text-sm bg-emerald-500/10">
                <i class="ri-notification-3-line text-emerald-400"></i>
              </div>
              <div>
                <strong class="block text-[12px] text-white font-bold mb-0.5">Multi-Channel Alerts</strong>
                <span class="text-[10px] text-white/30 leading-snug">Push, email and SMS in one tap</span>
              </div>
            </div>
            <div class="flex items-start gap-2.5">
              <div class="w-[30px] h-[30px] rounded-lg flex-shrink-0 flex items-center justify-center text-sm bg-cyan-500/10">
                <i class="ri-group-line text-cyan-400"></i>
              </div>
              <div>
                <strong class="block text-[12px] text-white font-bold mb-0.5">Family Mode</strong>
                <span class="text-[10px] text-white/30 leading-snug">Share reminders across 5 members</span>
              </div>
            </div>
            <div class="flex items-start gap-2.5">
              <div class="w-[30px] h-[30px] rounded-lg flex-shrink-0 flex items-center justify-center text-sm bg-amber-500/10">
                <i class="ri-bar-chart-2-line text-amber-400"></i>
              </div>
              <div>
                <strong class="block text-[12px] text-white font-bold mb-0.5">Savings Tracker</strong>
                <span class="text-[10px] text-white/30 leading-snug">See exactly how much you've saved</span>
              </div>
            </div>
          </div>
        </div>

        <!-- CTA -->
        <div class="rounded-2xl border border-purple-500/30 p-5 text-center"
             style="background:linear-gradient(135deg,rgba(124,58,237,.15),rgba(6,182,212,.08))">
          <i class="ri-vip-crown-line text-3xl text-purple-300 block mb-2.5"></i>
          <p class="text-[11px] text-white/40 mb-3 leading-relaxed">
            Ready to never miss a renewal again? Start for just <strong class="text-white">£2.40/year</strong>.
          </p>
          <a href="register"
             class="flex items-center justify-center gap-2 w-full px-5 py-2.5 rounded-xl text-white text-[12px] font-bold
                    transition-all duration-200 hover:-translate-y-0.5 hover:shadow-[0_8px_24px_rgba(124,58,237,.4)]"
             style="background:linear-gradient(135deg,#7c3aed,#6d28d9)">
            <i class="ri-arrow-right-circle-line"></i>Get Started Now
          </a>
        </div>

      </div>
    </div>
  </div>

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
