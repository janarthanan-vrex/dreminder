
@extends('layouts.app')
@section('content')

<script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#7c3aed',
            secondary: '#06b6d4',
            accent: '#10b981',
            dark: '#030014',
            surface: '#0a0a1f',
            card: '#0f0f2a',
          },
          fontFamily: {
            sans: ['Inter','system-ui','sans-serif'],
          }
        }
      }
    }
  </script>

<section class="page-hero-dark section-alt relative" data-particles="mixed" data-p-count="60" data-p-connect="false" data-p-glow="true">
  <div class="gradient-blob w-[500px] h-[500px] bg-primary top-[-20%] left-[10%]"></div>
  <div class="gradient-blob w-[400px] h-[400px] bg-secondary bottom-[-20%] right-[5%]"></div>
  <div class="max-w-[800px] mx-auto px-6 relative z-10">
    <div class="page-breadcrumb">
      <a href="index">Home</a><span class="sep">/</span><span>Pricing</span>
    </div>
    <div class="badge bg-accent/10 border border-accent/20 text-emerald-300 mx-auto mb-6 w-fit reveal">
      <span class="w-2 h-2 rounded-full bg-accent animate-pulse"></span> Plans &amp; Pricing
    </div>
    <h1 class="reveal">
      Simple pricing that <span class="grad-text">pays for itself.</span>
    </h1>
    <p class="reveal" data-delay="1">
      Start , then upgrade only if you need more power. Most households never pay a cent.
    </p>
  </div>
</section>

<section class="relative py-24 section-dark overflow-hidden">

  <!-- Background glow -->
  <div class="gradient-blob w-[600px] h-[600px] bg-primary top-[-20%] left-1/2 -translate-x-1/2 opacity-20"></div>

  <div class="max-w-4xl mx-auto px-6 text-center relative z-10">

    <!-- Badge -->
    <div class="badge bg-accent/10 border border-accent/20 text-emerald-300 mx-auto mb-6 w-fit">
      <i class="ri-star-smile-line mr-1"></i> One Simple Plan
    </div>

    <!-- Heading -->
    <h3 class="text-4xl md:text-5xl font-black text-white mb-6">
      Everything. <span class="grad-text">One Price.</span>
    </h3>

    <p class="text-lg text-white/40 max-w-2xl mx-auto mb-14">
      No tiers. No hidden upgrades. No monthly charges.  
      Just full access to Winngoo D Remind for a simple annual fee.
    </p>

    <!-- Pricing Card -->
    <div class="glass-strong rounded-3xl p-10 md:p-14 max-w-2xl mx-auto border border-primary/30 shadow-[0_0_60px_rgba(124,58,237,.25)]">

      <!-- Price -->
      <div class="flex justify-center items-end gap-3 mb-6">
        <span class="text-6xl md:text-7xl font-black text-white">£2.40</span>
        <span class="text-white/50 text-sm mb-3">/ year</span>
      </div>

      <!-- Breakdown -->
      <div class="text-sm text-white/40 mb-8">
        £2.00 subscription + £0.40 VAT
      </div>

      <!-- Divider -->
      <div class="border-t border-white/10 my-8"></div>

      <!-- Category -->
      <ul class="space-y-4 text-left max-w-md mx-auto text-white/60 text-sm mb-10">
        <li class="flex items-center gap-3">
          <i class="ri-check-line text-accent text-lg"></i>
          Unlimited reminders
        </li>
        <li class="flex items-center gap-3">
          <i class="ri-check-line text-accent text-lg"></i>
          Email & push notifications
        </li>
        <li class="flex items-center gap-3">
          <i class="ri-check-line text-accent text-lg"></i>
          Smart scheduling system
        </li>
        <li class="flex items-center gap-3">
          <i class="ri-check-line text-accent text-lg"></i>
          Full access to all features
        </li>
        <li class="flex items-center gap-3">
          <i class="ri-check-line text-accent text-lg"></i>
          All updates included
        </li>
        <li class="flex items-center gap-3">
          <i class="ri-check-line text-accent text-lg"></i>
          Dedicated support
        </li>
      </ul>

      <!-- CTA -->
      <a href="register?plan=annual"
         class="btn-primary w-full justify-center text-base py-4">
        <i class="ri-user-add-line mr-2"></i> Get Full Access Now
      </a>

      <p class="text-[12px] text-white/30 mt-4">
        One payment. 365 days of peace of mind.
      </p>

    </div>

    <!-- Value comparison -->
    <div class="mt-14 text-white/40 text-sm">
      That’s just <span class="text-emerald-300 font-semibold">£0.20 per month</span> —
      less than a cup of tea ☕
    </div>

  </div>
</section>
<!-- <section class="relative py-20 section-alt overflow-hidden text-center">
  <div class="gradient-blob w-[500px] h-[400px] bg-primary top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 !opacity-10"></div>
    <div id="grid-distortion-container" style="width: 100%; top: 0; height: 100%; position: absolute;"></div>

    <div class="relative z-10 max-w-[720px] mx-auto px-6">
    <div class="badge bg-primary/10 border border-primary/20 text-purple-300 mx-auto mb-6 w-fit reveal">
      <span class="w-2 h-2 rounded-full bg-primary"></span>
      Still not sure?
    </div>
    <h2 class="text-3xl md:text-4xl font-black text-white mb-4 reveal" data-delay="1">
      Start  in under <span class="grad-text">2 minutes.</span>
    </h2>
    <p class="text-base text-white/80 mb-8 reveal" data-delay="2">
      Create your account, add a couple of reminders, and let DRemind prove its value before you pay for anything.
    </p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center reveal" data-delay="3">
      <a href="register" class="btn-primary">
        <i class="ri-user-add-line text-xl"></i> Register
      </a>
      <a href="faq" class="btn-secondary">
        <i class="ri-question-line"></i> Read pricing FAQ
      </a>
    </div>
  </div>
</section> -->


<!-- Distortion Animation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="{{ asset('assets/js/distortion.js') }}"></script>

<script src="{{ asset('assets/js/script.js') }}"></script>
<script>
  setActivePage && setActivePage('pricing');

  const monthlyBtn = document.getElementById('billingMonthly');
  const yearlyBtn = document.getElementById('billingYearly');
  const proPriceMain = document.getElementById('proPriceMain');
  const proPriceSuffix = document.getElementById('proPriceSuffix');
  const proSaveLabel = document.getElementById('proSaveLabel');

  if (monthlyBtn && yearlyBtn) {
    monthlyBtn.addEventListener('click', () => {
      monthlyBtn.classList.add('bg-primary','text-white');
      yearlyBtn.classList.remove('bg-primary','text-white');
      proPriceMain.textContent = '$4.99';
      proPriceSuffix.textContent = '/month';
      proSaveLabel.textContent = 'or $49.99 billed yearly (save 17%)';
    });

    yearlyBtn.addEventListener('click', () => {
      yearlyBtn.classList.add('bg-primary','text-white');
      monthlyBtn.classList.remove('bg-primary','text-white');
      proPriceMain.textContent = '$49.99';
      proPriceSuffix.textContent = '/year';
      proSaveLabel.textContent = 'Equivalent to $4.16 per month — billed annually.';
    });
  }

  const planButtons = document.querySelectorAll('.plan-cta');
  planButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      const plan = btn.getAttribute('data-plan') || '';
      const url = new URL('register', window.location.href);
      url.searchParams.set('plan', plan);
      window.location.href = url.toString();
    });
  });
</script>

@endsection