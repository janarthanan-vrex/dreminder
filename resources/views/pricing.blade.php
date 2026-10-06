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
          sans: ['Inter', 'system-ui', 'sans-serif'],
        }
      }
    }
  }
</script>

<section class="page-hero-dark section-alt relative" data-particles="mixed" data-p-count="60" data-p-connect="false" data-p-glow="true">
     <div class="hero-bg-image prc-bnr"></div>
<div class="hero-overlay"></div>
  <div class="gradient-blob w-[260px] h-[260px] sm:w-[380px] sm:h-[380px] md:w-[500px] md:h-[500px] bg-primary top-[-20%] left-[10%]"></div>
  <div class="gradient-blob w-[220px] h-[220px] sm:w-[320px] sm:h-[320px] md:w-[400px] md:h-[400px] bg-secondary bottom-[-20%] right-[5%]"></div>
  <div class="max-w-[800px] mx-auto px-4 sm:px-6 relative z-10">
    <div class="page-breadcrumb text-sm sm:text-base flex-wrap">
      <a href="index">Home</a><span class="sep">/</span><span>Pricing</span>
    </div>
    <div class="badge bg-accent/10 border border-accent/20 text-emerald-300 mx-auto mb-6 w-fit reveal">
      <span class="w-2 h-2 rounded-full bg-accent animate-pulse"></span> Choose Your Plan
    </div>
    <h1 class="reveal text-3xl sm:text-4xl md:text-5xl lg:text-6xl leading-tight">
      Affordable Pricing for <span class="grad-text">Your Daily Reminders</span>
    </h1>
    <p class="reveal text-sm sm:text-base md:text-lg" data-delay="1">
      Choose a plan that fits your needs with straightforward pricing and full access to essential features.
    </p>
  </div>
</section>

<section class="relative py-16 sm:py-20 md:py-24 section-dark overflow-hidden">

  <!-- Background glow -->
  <div class="gradient-blob w-[320px] h-[320px] sm:w-[460px] sm:h-[460px] md:w-[600px] md:h-[600px] bg-primary top-[-20%] left-1/2 -translate-x-1/2 opacity-20"></div>

  <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center relative z-10">

    <!-- Badge -->
    <div class="badge bg-accent/10 border border-accent/20 text-emerald-300 mx-auto mb-6 w-fit">
      <i class="ri-star-smile-line mr-1"></i> Simple Pricing
    </div>

    <!-- Heading -->
    <h3 class="text-3xl sm:text-4xl md:text-5xl font-black text-white mb-4 sm:mb-6 leading-tight">
      Everything You Need <span class="grad-text">Included</span>
    </h3>

<<<<<<< HEAD
    <p class="text-lg text-white/40 max-w-2xl mx-auto mb-14">
      No tiers. No hidden upgrades. No monthly charges.
      Just full access to Winngoo D Remind for a simple annual fee.
    </p>

    <!-- Pricing Card -->
    @foreach($plans as $plan)
    <div class="glass-strong rounded-3xl p-10 md:p-14 max-w-2xl mx-auto border border-primary/30 shadow-[0_0_60px_rgba(124,58,237,.25)] mb-10">

      <div class="badge bg-accent/10 border border-accent/20 text-emerald-300 mx-auto mb-6 w-fit">
=======
    <p class="text-base sm:text-lg text-white/90 max-w-2xl mx-auto mb-10 sm:mb-14 px-2">
      Enjoy complete dashboard access with one simple plan, without hidden charges or additional upgrades.
    </p>

   <!-- Pricing Card -->
    @foreach($plans as $plan)
    <div class="glass-strong rounded-2xl sm:rounded-3xl p-6 sm:p-10 md:p-14 max-w-2xl mx-auto border border-primary/30 shadow-[0_0_60px_rgba(124,58,237,.25)] mb-8 sm:mb-10 overflow-hidden break-words">

      <div class="badge bg-accent/10 border border-accent/20 text-emerald-300 mx-auto mb-4 sm:mb-6 w-fit text-xs sm:text-sm">
>>>>>>> 14b4245 (full updated code)
        <i class="{{ $plan->icon }}"></i>
        {{ $plan->plan_name }}
      </div>

<<<<<<< HEAD
      <h4 class="text-2xl font-bold text-white mb-4">
        {{ $plan->range }}
      </h4>

      <p class="text-white/50 mb-8">
=======
      <h4 class="text-xl sm:text-2xl font-bold text-white mb-3 sm:mb-4">
        {{ $plan->range }}
      </h4>

      <p class="text-white/85 mb-6 sm:mb-8 text-sm sm:text-base px-2 sm:px-0">
>>>>>>> 14b4245 (full updated code)
        {{ $plan->description }}
      </p>

      <!-- Price -->
<<<<<<< HEAD
      <div class="flex justify-center items-end gap-3 mb-6">
        <span class="text-6xl md:text-7xl font-black text-white">
          £{{ number_format($plan->total_price, 2) }}
        </span>
        <span class="text-white/50 text-sm mb-3">
=======
      <div class="flex flex-wrap justify-center items-end gap-2 sm:gap-3 mb-4 sm:mb-6">
        <span class="text-4xl sm:text-6xl md:text-7xl font-black text-white break-all">
          £{{ number_format($plan->total_price, 2) }}
        </span>
        <span class="text-white/85 text-xs sm:text-sm mb-2 sm:mb-3">
>>>>>>> 14b4245 (full updated code)
          / year
        </span>
      </div>

      <!-- Breakdown -->
<<<<<<< HEAD
      <div class="text-sm text-white/40 mb-8">
=======
      <div class="text-xs sm:text-sm text-white/85 mb-6 sm:mb-8 px-2 break-words">
>>>>>>> 14b4245 (full updated code)
        £{{ number_format($plan->price, 2) }}
        subscription +
        £{{ number_format($plan->vat, 2) }}
        VAT
      </div>

<<<<<<< HEAD
      <div class="border-t border-white/10 my-8"></div>

      <!-- Features -->
      <ul class="space-y-4 text-left max-w-md mx-auto text-white/60 text-sm mb-10">

        @if(is_array($plan->features))
        @foreach($plan->features as $feature)
        <li class="flex items-center gap-3">
          <i class="ri-check-line text-accent text-lg"></i>
          {{ $feature }}
=======
      <div class="border-t border-white/10 my-6 sm:my-8"></div>

      <!-- Features -->
      <ul class="space-y-3 sm:space-y-4 text-left max-w-md mx-auto text-white/80 text-sm mb-8 sm:mb-10 px-2 sm:px-0">

        @if(is_array($plan->features))
        @foreach($plan->features as $feature)
        <li class="flex items-start sm:items-center gap-3">
          <i class="ri-check-line text-accent text-lg shrink-0 mt-0.5 sm:mt-0"></i>
          <span class="break-words">{{ $feature }}</span>
>>>>>>> 14b4245 (full updated code)
        </li>
        @endforeach
        @endif

      </ul>

      <!-- CTA -->
<<<<<<< HEAD
      <a href="{{ route('registerpage') }}"
        class="btn-primary w-full justify-center text-base py-4">
        <i class="ri-user-add-line mr-2"></i>
        Get Full Access Now
      </a>
    </div>
    @endforeach

    <!-- Value comparison -->
    <div class="mt-14 text-white/40 text-sm">
      That’s just <span class="text-emerald-300 font-semibold">£0.20 per month</span> —
      less than a cup of tea ☕
=======
      <a href="{{ route('registerpage', ['plan_id' => $plan->id]) }}"
        class="btn-primary w-full justify-center text-sm sm:text-base py-3 sm:py-4 plan-cta"
        data-plan-id="{{ $plan->id }}">
        <i class="ri-user-add-line mr-2"></i>
        Get Full Access Now
      </a>
>>>>>>> 14b4245 (full updated code)
    </div>
    @endforeach

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
      monthlyBtn.classList.add('bg-primary', 'text-white');
      yearlyBtn.classList.remove('bg-primary', 'text-white');
      proPriceMain.textContent = '$4.99';
      proPriceSuffix.textContent = '/month';
      proSaveLabel.textContent = 'or $49.99 billed yearly (save 17%)';
    });

    yearlyBtn.addEventListener('click', () => {
      yearlyBtn.classList.add('bg-primary', 'text-white');
      monthlyBtn.classList.remove('bg-primary', 'text-white');
      proPriceMain.textContent = '$49.99';
      proPriceSuffix.textContent = '/year';
      proSaveLabel.textContent = 'Equivalent to $4.16 per month — billed annually.';
    });
  }

  const planButtons = document.querySelectorAll('.plan-cta');
  planButtons.forEach(btn => {
    btn.addEventListener('click', (event) => {
      const planId = btn.getAttribute('data-plan-id') || '';
      if (!planId) return;

      event.preventDefault();
      const url = new URL('{{ route('registerpage') }}', window.location.href);
      url.searchParams.set('plan_id', planId);
      window.location.href = url.toString();
    });
  });
</script>

@endsection