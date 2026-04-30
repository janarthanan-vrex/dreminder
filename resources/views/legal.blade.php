<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Legal — DRemind</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary:'#7c3aed',
            secondary:'#06b6d4',
            accent:'#10b981',
            dark:'#030014',
            surface:'#0a0a1f',
            card:'#0f0f2a',
          },
          fontFamily:{sans:['Inter','system-ui','sans-serif']}
        }
      }
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet">
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>
<body>
<div id="loader"><div class="loader-ring"></div></div>
<div class="cursor-ring" id="cursorRing"></div>
<div class="cursor-dot" id="cursorDot"></div>
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


<section class="page-hero-dark section-alt relative" data-particles="purple" data-p-count="40" data-p-connect="false">
  <div class="gradient-blob w-[460px] h-[460px] bg-primary top-[-18%] left-[15%]"></div>
  <div class="max-w-[840px] mx-auto px-6 relative z-10">
    <div class="page-breadcrumb">
      <a href="index">Home</a><span class="sep">/</span><span>Legal</span>
    </div>
    <div class="badge bg-primary/10 border border-primary/20 text-purple-300 mx-auto mb-6 w-fit reveal">
      <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span> Legal &amp; Compliance
    </div>
    <h1 class="reveal">Your data. <span class="grad-text">Your control.</span></h1>
    <p class="reveal" data-delay="1">
      We take privacy and security seriously. Review the key policies that govern how DRemind works.
    </p>
  </div>
</section>

<section class="relative py-16 md:py-20 section-dark overflow-hidden" id="privacy">
  <div class="max-w-6xl mx-auto px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-[0.85fr,1.9fr] gap-10">
    <aside class="reveal-left">
      <div class="glass-strong rounded-3xl p-5 sticky top-24">
        <p class="text-xs font-semibold text-white/40 mb-3 uppercase tracking-[0.18em]">
          LEGAL CENTER
        </p>
        <nav class="flex flex-col gap-1 text-sm">
          <button class="legal-nav-dark active" data-target="privacy">
            <i class="ri-shield-check-line text-purple-300"></i>
            Privacy Policy
          </button>
          <button class="legal-nav-dark" data-target="terms">
            <i class="ri-article-line text-cyan-300"></i>
            Terms of Use
          </button>
        </nav>
        <div class="mt-6 pt-4 border-t border-white/10">
          <p class="text-[11px] text-white/35 mb-2">
            Last updated: 12 April 2026
          </p>
          <p class="text-[11px] text-white/35 mb-3">
            For any legal questions, email
            <a href="mailto:info@winngoodremind.co.uk" class="text-purple-300">info@winngoodremind.co.uk</a>.
          </p>
        </div>
      </div>
    </aside>

    <div class="reveal-right">
      <!-- Privacy -->
      <div id="tab-privacy" class="legal-tab-dark active">
        <div class="legal-section-dark">
          <h3>1. Overview</h3>
          <p>
            This Privacy Policy explains how Winngoo DRemind (“we”, “us”, “our”) collects, uses, and protects your personal information when you use our websites, apps, and services (collectively, “Services”).
          </p>
          <p>
            We comply with applicable privacy laws including the UK GDPR, EU GDPR, CCPA (California), PIPEDA (Canada), and the Australian Privacy Act. We only collect data necessary to deliver and improve DRemind.
          </p>
        </div>

        <div class="legal-section-dark">
          <h3>2. Data we collect</h3>
          <h4>Account data</h4>
          <ul>
            <li>Name, email address, password (hashed), country.</li>
            <li>Subscription status (, Pro, Family).</li>
          </ul>
          <h4>Reminder data</h4>
          <ul>
            <li>Reminder titles, features, due/expiry dates.</li>
            <li>Notification settings and delivery channels.</li>
          </ul>
          <h4>Technical data</h4>
          <ul>
            <li>IP address, device information, browser type, usage analytics.</li>
          </ul>
        </div>

        <div class="legal-section-dark">
          <h3>3. How we use your data</h3>
          <ul>
            <li>To provide and maintain the DRemind service.</li>
            <li>To send reminders, alerts, and important account notifications.</li>
            <li>To improve our product using anonymised/aggregated analytics.</li>
            <li>To comply with legal obligations and prevent fraud or abuse.</li>
          </ul>
        </div>

        <div class="legal-section-dark">
          <h3>4. Data sharing</h3>
          <p>
            We do <strong>not</strong> sell your personal data to third parties or share it with advertisers.
          </p>
          <p>
            We may share data with trusted processors (e.g. cloud hosting, email providers, payment processors) strictly for operating the Service, under data processing agreements.
          </p>
        </div>
      </div>

      <!-- Terms -->
      <div id="tab-terms" class="legal-tab-dark" id="terms">
        <div class="legal-section-dark">
          <h3>1. Acceptance of terms</h3>
          <p>
            By creating an account or using DRemind, you agree to these Terms of Use. If you do not agree, please do not use our Services.
          </p>
        </div>

        <div class="legal-section-dark">
          <h3>2. Use of the service</h3>
          <ul>
            <li>You must be at least 16 years old or the age of digital consent in your country.</li>
            <li>You are responsible for maintaining the confidentiality of your login credentials.</li>
            <li>You agree not to misuse the Service, attempt to disrupt it, or reverse engineer our systems.</li>
          </ul>
        </div>

        <div class="legal-section-dark">
          <h3>3. Plans and billing</h3>
          <ul>
            <li>The  plan is  forever and does not require a payment method.</li>
            <li>Paid plans renew automatically until cancelled from your account settings.</li>
            <li>Where required by law, we will provide refunds in accordance with local regulations.</li>
          </ul>
        </div>

        <div class="legal-section-dark">
          <h3>4. Limitation of liability</h3>
          <p>
            While we strive for 99.9% uptime and reliable deliveries, DRemind cannot guarantee that every notification will arrive or be read in time. You remain responsible for your own payments and renewals.
          </p>
        </div>
      </div>
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

<script src="{{ asset('assets/js/script.js') }}"></script>
<script>
  setActivePage && setActivePage('legal');

  const navButtons = document.querySelectorAll('.legal-nav-dark');
  const tabs = {
    privacy: document.getElementById('tab-privacy'),
    terms: document.getElementById('tab-terms'),
  };

  function activateTab(key) {
    Object.keys(tabs).forEach(k => {
      if (!tabs[k]) return;
      if (k === key) {
        tabs[k].classList.add('active');
      } else {
        tabs[k].classList.remove('active');
      }
    });

    navButtons.forEach(btn => {
      if (btn.dataset.target === key) {
        btn.classList.add('active');
      } else {
        btn.classList.remove('active');
      }
    });
  }

  navButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      const tgt = btn.dataset.target;
      if (!tgt) return;
      activateTab(tgt);
      const section = document.getElementById(tgt);
      if (section) {
        window.scrollTo({
          top: section.offsetTop - 90,
          behavior: 'smooth'
        });
      }
    });
  });

  const hash = window.location.hash.replace('#','');
  if (hash && tabs[hash]) {
    activateTab(hash);
  }
</script>
</body>
</html>