@extends('layouts.app')
@section('content')
<style>
    .o2{display: none !important;}
</style>

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
<style>
    /* Wizard Styles */
    .wizard-step { display: none; }
    .wizard-step.active { display: block; animation: wiz-fade 0.3s ease-in-out; }
    /* NOTE: use -webkit- prefix name to avoid Blade parsing @keyframes */

    /* Progress Indicator */
    .step-indicator {
      display: flex; justify-content: space-between; align-items: center;
      margin-bottom: 40px; position: relative;
    }
    .step-indicator::before {
      content: ''; position: absolute; top: 20px; left: 0; right: 0;
      height: 2px; background: rgba(255,255,255,.1); z-index: 0;
    }
    .step-progress-bar {
      position: absolute; top: 20px; left: 0; height: 2px;
      background: linear-gradient(90deg, #7c3aed, #06b6d4); z-index: 1;
      transition: width 0.4s cubic-bezier(.16,1,.3,1);
    }
    .step-item {
      display: flex; flex-direction: column; align-items: center;
      gap: 8px; position: relative; z-index: 2; flex: 1;
    }
    .step-circle {
      width: 40px; height: 40px; border-radius: 50%;
      background: rgba(255,255,255,.05); border: 2px solid rgba(255,255,255,.1);
      display: flex; align-items: center; justify-content: center;
      font-weight: 700; color: rgba(255,255,255,.3); font-size: 0.9rem;
      transition: all 0.3s; position: relative;
    }
    .step-item.active .step-circle {
      background: linear-gradient(135deg, #7c3aed, #6d28d9);
      border-color: #7c3aed; color: #fff;
      box-shadow: 0 0 20px rgba(124,58,237,.5); transform: scale(1.1);
    }
    .step-item.completed .step-circle {
      background: linear-gradient(135deg, #10b981, #059669);
      border-color: #10b981; color: #fff;
    }
    .step-item.completed .step-circle::after {
      content: '\e5ca'; font-family: 'remixicon';
      position: absolute; font-size: 1.2rem;
    }
    .step-label { font-size: 0.7rem; color: rgba(255,255,255,.3); font-weight: 600; text-align: center; transition: color 0.3s; }
    .step-item.active .step-label, .step-item.completed .step-label { color: rgba(255,255,255,.8); }

    /* Field error — use JS to toggle, NOT a CSS class toggle, to avoid Blade conflicts */
    .field-error {
      font-size: 11px;
      color: #f87171;
      margin-top: 4px;
      display: none;  /* shown/hidden via JS style.display directly */
    }
    .auth-input.inp-error {
      border-color: #f87171 !important;
      box-shadow: 0 0 0 2px rgba(248,113,113,0.15) !important;
    }
    .select-dark.inp-error {
      border-color: #f87171 !important;
      box-shadow: 0 0 0 2px rgba(248,113,113,0.15) !important;
    }

    /* Password strength bar */
    .strength-bar-dark {
      display: flex;
      gap: 4px;
      margin-top: 8px;
    }
    .strength-seg-dark {
      flex: 1;
      height: 4px;
      border-radius: 99px;
      background: rgba(255,255,255,0.08);
      transition: background 0.3s;
    }

    /* Payment Plan Cards */
    .plan-card {
      border: 2px solid rgba(255,255,255,0.08); border-radius: 16px;
      padding: 16px; cursor: pointer; transition: all 0.25s ease;
      background: rgba(255,255,255,0.03); position: relative;
    }
    .plan-card:hover { border-color: rgba(124,58,237,0.4); background: rgba(124,58,237,0.05); }
    .plan-card.selected { border-color: #7c3aed; background: rgba(124,58,237,0.12); box-shadow: 0 0 20px rgba(124,58,237,0.2); }
    .plan-card .plan-radio {
      position: absolute; top: 14px; right: 14px; width: 18px; height: 18px;
      border-radius: 50%; border: 2px solid rgba(255,255,255,0.2);
      background: transparent; transition: all 0.2s;
      display: flex; align-items: center; justify-content: center;
    }
    .plan-card.selected .plan-radio { border-color: #7c3aed; background: #7c3aed; }
    .plan-card.selected .plan-radio::after {
      content: ''; width: 6px; height: 6px; border-radius: 50%; background: white;
    }
    .plan-badge {
      display: inline-block; font-size: 9px; font-weight: 700;
      letter-spacing: 0.06em; padding: 2px 8px; border-radius: 20px; text-transform: uppercase;
    }

    /* Stripe Elements */
    .stripe-element-wrapper {
      background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
      border-radius: 10px; padding: 12px 14px; transition: border-color 0.2s;
    }
    .stripe-element-wrapper.StripeElement--focus { border-color: #7c3aed; }
    .stripe-element-wrapper.StripeElement--invalid { border-color: #f87171; }

    /* Success Toast */
    .success-toast-dark {
      position: fixed; bottom: 30px; right: 30px;
      background: rgba(3,0,20,.95); backdrop-filter: blur(20px);
      border: 1px solid rgba(16,185,129,.3); border-radius: 16px;
      padding: 18px 24px; display: flex; align-items: center; gap: 14px;
      box-shadow: 0 10px 40px rgba(16,185,129,.2); z-index: 99999;
      opacity: 0; transform: translateY(20px); pointer-events: none;
      transition: all .4s cubic-bezier(.16,1,.3,1);
    }
    .success-toast-dark.show { opacity: 1; transform: translateY(0); pointer-events: auto; }

    @media (max-width: 640px) {
      .step-label { display: none; }
      .step-circle { width: 36px; height: 36px; font-size: 0.8rem; }
    }
</style>
{{-- Keyframe animations injected via JS to avoid Blade @-directive conflicts --}}
<script>
  (function(){
    var s = document.createElement('style');
    s.textContent = '@keyframes wiz-fade { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }';
    document.head.appendChild(s);
  })();
</script>

<!-- Stripe.js -->
<script src="https://js.stripe.com/v3/"></script>

<!-- HERO -->
<section class="page-hero-dark section-alt relative" data-particles="purple" data-p-count="40" data-p-connect="false">
  <div class="gradient-blob w-[450px] h-[450px] bg-primary top-[-20%] left-[15%]"></div>
  <div class="max-w-[820px] mx-auto px-6 relative z-10">
    <div class="page-breadcrumb">
      <a href="index">Home</a><span class="sep">/</span><span>Register</span>
    </div>
    <div class="badge bg-primary/10 border border-primary/20 text-purple-300 mx-auto mb-6 w-fit reveal">
      <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span> Create your account
    </div>
    <h1 class="reveal">
      Join for just <span class="grad-text">£{{ number_format($first_plan->total_price, 2) }}/year</span>
    </h1>
    <p class="reveal" data-delay="1">
      Complete access to all features. Set up your account in minutes and never miss a deadline again.
    </p>
  </div>
</section>

<!-- REGISTRATION WIZARD -->
<section class="relative py-16 md:py-20 section-dark">
  <div class="max-w-6xl mx-auto px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-[1fr,1.5fr] gap-10 items-start">

    <!-- Sticky Sidebar -->
    <div class="reveal-right lg:sticky lg:top-24 space-y-6">
      <div class="glass-strong rounded-3xl p-7 md:p-8 border border-primary/30">
        <div class="flex items-center gap-3 mb-4">
          <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary to-secondary flex items-center justify-center">
            <i class="ri-vip-crown-line text-2xl text-white"></i>
          </div>
          <div>
            <h3 class="text-base font-bold text-white">What's included</h3>
            <p class="text-[11px] text-white/40">Everything from £{{ number_format($first_plan->total_price, 2) }}/year</p>
          </div>
        </div>
        <ul class="space-y-3 text-xs text-white/60">
          <li class="flex items-start gap-2"><i class="ri-check-line text-accent mt-0.5 flex-shrink-0"></i><span><strong class="text-white">Unlimited reminders</strong> — track every bill & subscription</span></li>
          <li class="flex items-start gap-2"><i class="ri-check-line text-accent mt-0.5 flex-shrink-0"></i><span><strong class="text-white">Smart notifications</strong> — push, email & SMS alerts</span></li>
          <li class="flex items-start gap-2"><i class="ri-check-line text-accent mt-0.5 flex-shrink-0"></i><span><strong class="text-white">Family sharing</strong> — up to 5 household members</span></li>
          <li class="flex items-start gap-2"><i class="ri-check-line text-accent mt-0.5 flex-shrink-0"></i><span><strong class="text-white">Savings dashboard</strong> — see how much you save</span></li>
          <li class="flex items-start gap-2"><i class="ri-check-line text-accent mt-0.5 flex-shrink-0"></i><span><strong class="text-white">Priority support</strong> — get help when you need it</span></li>
          <li class="flex items-start gap-2"><i class="ri-check-line text-accent mt-0.5 flex-shrink-0"></i><span><strong class="text-white">All future updates</strong> — new features automatically included</span></li>
        </ul>
      </div>

      <div class="glass-strong rounded-3xl p-6">
        <h3 class="text-sm font-semibold text-white mb-4">What happens next?</h3>
        <ol class="space-y-3">
          <li class="flex gap-3 text-[11px] text-white/40"><span class="w-6 h-6 rounded-full bg-primary/20 flex items-center justify-center text-[11px] text-purple-300 font-bold flex-shrink-0">1</span><span>Payment is processed securely and your account is created instantly.</span></li>
          <li class="flex gap-3 text-[11px] text-white/40"><span class="w-6 h-6 rounded-full bg-primary/20 flex items-center justify-center text-[11px] text-purple-300 font-bold flex-shrink-0">2</span><span>Confirm your email address via the verification link we send.</span></li>
          <li class="flex gap-3 text-[11px] text-white/40"><span class="w-6 h-6 rounded-full bg-primary/20 flex items-center justify-center text-[11px] text-purple-300 font-bold flex-shrink-0">3</span><span>Add your first reminders — insurance, energy, subscriptions, etc.</span></li>
          <li class="flex gap-3 text-[11px] text-white/40"><span class="w-6 h-6 rounded-full bg-primary/20 flex items-center justify-center text-[11px] text-purple-300 font-bold flex-shrink-0">4</span><span>Relax! We'll notify you before anything renews.</span></li>
        </ol>
      </div>

      <div class="glass-strong rounded-2xl p-4 bg-gradient-to-br from-accent/10 to-accent/5 border border-accent/20 text-center">
        <i class="ri-medal-line text-3xl text-accent mb-2"></i>
        <p class="text-[10px] text-white/40">Not happy? Get a full refund within 30 days, no questions asked.</p>
      </div>
    </div>

    <!-- WIZARD FORM -->
    <div class="glass-strong rounded-3xl p-7 md:p-10 reveal-left">
      <div class="flex items-center justify-between mb-6">
        <div>
          <h2 class="text-xl md:text-2xl font-black text-white mb-1">Create your account</h2>
          <p class="text-xs text-white/40">
            Already have an account?
            <a href="login" class="text-purple-300 hover:text-white transition">Login here</a>
          </p>
        </div>
        <div class="text-right">
          <div class="text-2xl font-black" id="headerPrice">£{{ number_format($first_plan->total_price, 2) }}</div>
          <p class="text-[10px] text-white/40">per year</p>
        </div>
      </div>

      <!-- Progress Indicator -->
      <div class="step-indicator">
        <div class="step-progress-bar" id="progressBar" style="width: 0%"></div>
        <div class="step-item active" data-step="1">
          <div class="step-circle">1</div>
          <div class="step-label">Account</div>
        </div>
        <div class="step-item" data-step="2">
          <div class="step-circle">2</div>
          <div class="step-label">Address</div>
        </div>
        <div class="step-item" data-step="3">
          <div class="step-circle">3</div>
          <div class="step-label">Payment & Confirm</div>
        </div>
      </div>

      <form id="wizardForm" class="space-y-5" autocomplete="off" novalidate>
        @csrf

        <!-- STEP 1: Account Info -->
        <div class="wizard-step active" data-step="1">
          <h3 class="text-sm font-semibold text-white/70 flex items-center gap-2 mb-4">
            <i class="ri-user-line text-primary"></i> Personal Information
          </h3>
          <div class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="auth-label">First name <span style="color:red;">*</span></label>
                <input type="text" maxlength="25" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g,'')" name="firstName" id="firstName" class="auth-input" placeholder="Enter Your First Name">
                <p class="field-error" id="err-firstName">First name is required.</p>
              </div>
              <div>
                <label class="auth-label">Last name <span style="color:red;">*</span></label>
                <input type="text" maxlength="25" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g,'')" name="lastName" id="lastName" class="auth-input" placeholder="Enter Your Last Name">
                <p class="field-error" id="err-lastName">Last name is required.</p>
              </div>
            </div>

            <div>
              <label class="auth-label">Email address <span style="color:red;">*</span></label>
              <input maxlength="40" type="email" name="email" id="email" class="auth-input" placeholder="Enter Your Email">
              <p class="field-error" id="err-email">Please enter a valid email address.</p>
              <p class="text-[11px] text-white/30 mt-1">We'll send important account updates and reminders here.</p>
            </div>

            <div>
              <label class="auth-label flex items-center gap-2">
                Password <span style="color:red;">*</span>
                <span class="text-[10px] text-white/30 font-normal">(min 8 chars, 1 uppercase, 1 lowercase, 1 number)</span>
              </label>
              <div class="relative">
                <input maxlength="100" type="password" name="password" id="password" class="auth-input pr-10" placeholder="Create a strong password">
                <button type="button" id="togglePassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-white/40 hover:text-white/70 text-lg">
                  <i class="ri-eye-off-line"></i>
                </button>
              </div>
              <div class="strength-bar-dark" id="strengthBar">
                <div class="strength-seg-dark"></div>
                <div class="strength-seg-dark"></div>
                <div class="strength-seg-dark"></div>
                <div class="strength-seg-dark"></div>
              </div>
              <p id="strengthLabel" class="text-[11px] text-white/35 mt-1">Password strength: weak</p>
              <p class="field-error" id="err-password">Password must be at least 8 chars, include uppercase, lowercase and a number.</p>
            </div>

            <div>
              <label class="auth-label">Confirm password <span style="color:red;">*</span></label>
              <div class="relative">
                <input maxlength="100" type="password" name="confirmPassword" id="confirmPassword" class="auth-input pr-10" placeholder="Re-enter your password">
                <button type="button" id="toggleConfirmPassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-white/40 hover:text-white/70 text-lg">
                  <i class="ri-eye-off-line"></i>
                </button>
              </div>
              <p class="field-error" id="err-confirmPassword">Passwords do not match.</p>
            </div>

            <div class="space-y-3">
              <div class="flex items-start gap-3">
                <input type="checkbox" id="termsChk" name="terms" style="accent-color:#7c3aed" class="mt-1">
                <label for="termsChk" class="text-[11px] text-white/40 leading-relaxed">
                  I agree to the
                  <a href="terms" target="_blank" class="text-purple-300 hover:text-white transition">Terms & Conditions</a>
                  and
                  <a href="privacy" target="_blank" class="text-purple-300 hover:text-white transition">Privacy Policy</a>.
                </label>
              </div>
              <p class="field-error" id="err-terms">You must accept the Terms & Conditions.</p>
            </div>
          </div>
        </div>

        <!-- STEP 2: Address -->
        <div class="wizard-step" data-step="2">
          <h3 class="text-sm font-semibold text-white/70 flex items-center gap-2 mb-4">
            <i class="ri-map-pin-line text-primary"></i> Address Details
          </h3>
          <div class="space-y-4">
            <div>
              <label class="auth-label">Address Line 1 <span style="color:red;">*</span></label>
              <input maxlength="100" type="text" name="address1" id="address1" class="auth-input" placeholder="123 High Street">
              <p class="field-error" id="err-address1">Address line 1 is required.</p>
            </div>

            <div>
              <label class="auth-label">Address Line 2 <span class="text-white/25 text-xs">(optional)</span></label>
              <input maxlength="100" type="text" name="address2" id="address2" class="auth-input" placeholder="Apartment, suite, etc.">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="auth-label">Post code <span style="color:red;">*</span></label>
                <input maxlength="8" type="text" name="postcode" id="postcode" class="auth-input" placeholder="SW1A 1AA">
                <p class="field-error" id="err-postcode">Please enter a valid UK postcode (e.g. SW1A 1AA).</p>
              </div>
              <div>
                <label class="auth-label">Country <span style="color:red;">*</span></label>
                <select name="country" id="country" class="select-dark" disabled>
                  <option value="United Kingdom" selected>United Kingdom</option>
                </select>
                <p class="field-error" id="err-country">Please select a country.</p>
              </div>
            </div>

            <div>
              <label class="auth-label">Phone number <span style="color:red;">*</span></label>
              <input oninput="this.value = this.value.replace(/[^0-9]/g,'')" maxlength="15" type="tel" name="phone" id="phone" class="auth-input" placeholder="+44 7123 456789">
              <p class="field-error" id="err-phone">Please enter a valid phone number (10–15 digits).</p>
              <p class="text-[11px] text-white/30 mt-1">10–15 digits, including country code.</p>
            </div>
          </div>
        </div>

        <!-- STEP 3: Payment & Confirm -->
        <div class="wizard-step" data-step="3">

          <h3 class="text-sm font-semibold text-white/70 flex items-center gap-2 mb-4">
            <i class="ri-bank-card-line text-primary"></i> Choose Your Plan
          </h3>

          <input type="hidden" name="plan_id" id="planIdInput" value="">
          <p class="field-error" id="err-plan">Please select a plan.</p>

          <div class="grid grid-cols-1 gap-3 mb-6">
            @foreach($plans as $plan)
            <div class="plan-card {{ $loop->first ? 'selected' : '' }}"
                 data-plan="{{ $plan->plan_name }}"
                 data-plan-id="{{ $plan->id }}"
                 data-price="{{ number_format($plan->total_price, 2) }}"
                 onclick="selectPlan(this)">
              <div class="plan-radio"></div>
              <div class="mb-2">
                <span class="plan-badge"
                  @if($loop->index === 0) style="background:rgba(124,58,237,0.25);color:#c4b5fd;"
                  @elseif($loop->index === 1) style="background:rgba(6,182,212,0.2);color:#67e8f9;"
                  @else style="background:rgba(255,255,255,0.08);color:rgba(255,255,255,0.5);"
                  @endif>
                  {{ $plan->plan_name }}
                </span>
              </div>
              <div class="text-xl font-black text-white">£{{ number_format($plan->total_price, 2) }}</div>
              <div class="text-[10px] text-white/35 mb-3">{{ $plan->range }}</div>
              @if($plan->features)
              <ul class="space-y-1.5 text-[10px] text-white/40">
                @foreach(is_array($plan->features) ? $plan->features : json_decode($plan->features, true) ?? [] as $feature)
                <li class="flex items-center gap-1.5"><i class="ri-check-line text-accent text-xs"></i>{{ $feature }}</li>
                @endforeach
              </ul>
              @endif
            </div>
            @endforeach
          </div>

          <!-- Selected Plan Summary Bar -->
          <div class="bg-gradient-to-br from-primary/10 to-secondary/10 border border-primary/20 rounded-2xl p-4 mb-5">
            <div class="flex items-center justify-between">
              <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-primary to-secondary flex items-center justify-center">
                  <i class="ri-vip-crown-line text-lg text-white"></i>
                </div>
                <div>
                  <h4 class="font-bold text-white text-sm" id="selectedPlanName">Select a Plan</h4>
                  <p class="text-[10px] text-white/40">Full access to all features</p>
                </div>
              </div>
              <div class="text-right">
                <div class="text-xl font-black text-white" id="selectedPlanPrice">£0.00</div>
                <p class="text-[10px] text-white/30">per year</p>
              </div>
            </div>
          </div>

          <!-- Coupon Code -->
          <div class="mb-5">
            <label class="auth-label">Coupon code <span class="text-white/25 text-xs">(optional)</span></label>
            <div class="flex gap-2">
              <input type="text" name="coupon" id="couponInput" class="auth-input flex-1" placeholder="Enter coupon code">
              <button type="button" id="applyCoupon" class="btn-secondary !py-3 !px-6 whitespace-nowrap">Apply</button>
            </div>
            <p id="couponMessage" class="text-[11px] mt-1" style="display:none;"></p>
          </div>

          <!-- Review & Confirm -->
          <div class="pt-4 border-t border-white/10 space-y-4">
            <h3 class="text-sm font-semibold text-white/70 flex items-center gap-2">
              <i class="ri-checkbox-circle-line text-primary"></i> Review & Confirm
            </h3>
            <div class="glass rounded-2xl p-5 space-y-3">
              <div class="flex items-center justify-between text-sm"><span class="text-white/50">Name:</span><span class="text-white font-semibold" id="summaryName">-</span></div>
              <div class="flex items-center justify-between text-sm"><span class="text-white/50">Email:</span><span class="text-white font-semibold" id="summaryEmail">-</span></div>
              <div class="flex items-center justify-between text-sm"><span class="text-white/50">Phone:</span><span class="text-white font-semibold" id="summaryPhone">-</span></div>
              <div class="flex items-center justify-between text-sm"><span class="text-white/50">Plan:</span><span class="text-white font-semibold capitalize" id="summaryPlan">-</span></div>
              <div class="flex items-center justify-between text-sm pt-3 border-t border-white/10" id="summaryTotalRow">
                <span class="text-white/50">Total Amount:</span>
                <span class="text-xl font-black text-accent" id="summaryTotal">£0.00</span>
              </div>
            </div>
          </div>

          <!-- Card Details via Stripe Elements -->
          <div class="space-y-4 pt-4 border-t border-white/10 mb-5">
            <h3 class="text-sm font-semibold text-white/70 flex items-center gap-2">
              <i class="ri-secure-payment-line text-primary"></i> Card Details
            </h3>
            <div class="flex items-center gap-2">
              <i class="ri-shield-check-line text-accent"></i>
              <span class="text-xs text-white/60">Secure payment via Stripe — we never store your card details</span>
            </div>

            <div>
              <label class="auth-label">Name on card <span style="color:red;">*</span></label>
              <input type="text" maxlength="100" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g,'')" name="cardName" id="cardName" class="auth-input" placeholder="Enter Your Card Name">
              <p class="field-error" id="err-cardName">Name on card is required.</p>
            </div>

            <div>
              <label class="auth-label">Card number <span style="color:red;">*</span></label>
              <div id="stripe-card-number" class="stripe-element-wrapper"></div>
              <p class="field-error" id="err-cardNumber">Please enter a valid card number.</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="auth-label">Expiry date <span style="color:red;">*</span></label>
                <div id="stripe-card-expiry" class="stripe-element-wrapper"></div>
                <p class="field-error" id="err-expiry">Please enter a valid expiry date.</p>
              </div>
              <div>
                <label class="auth-label">CVV <span style="color:red;">*</span></label>
                <div id="stripe-card-cvc" class="stripe-element-wrapper"></div>
                <p class="field-error" id="err-cvv">Please enter the CVV.</p>
              </div>
            </div>
            <!-- Hidden inputs to send to server for storage reference only -->
            <input type="hidden" name="cardNumber" id="cardNumberHidden" value="">
            <input type="hidden" name="expiry" id="expiryHidden" value="">
            <input type="hidden" name="cvv" id="cvvHidden" value="000">
            <input type="hidden" name="stripeToken" id="stripeToken" value="">
            <input type="hidden" name="coupon_code" id="appliedCouponCode" value="">
            <input type="hidden" name="discount_amount" id="discountAmountHidden" value="0">
            <input type="hidden" name="final_amount" id="finalAmountHidden" value="0">
          </div>
        </div>

        <!-- Global Error -->
        <p id="wizardError" class="text-[11px] text-rose-400 mt-3" style="display:none;"></p>

        <!-- Navigation Buttons -->
        <div class="flex items-center justify-between gap-4 pt-4 border-t border-white/10">
          <button type="button" id="prevBtn" class="btn-secondary hidden">
            <i class="ri-arrow-left-line mr-2"></i>Previous
          </button>
          <button type="button" id="nextBtn" class="auth-submit-dark ml-auto">
            Next<i class="ri-arrow-right-line ml-2"></i>
          </button>
          <button type="button" id="payBtn" class="auth-submit-dark ml-auto hidden">
            <i class="ri-shield-check-line mr-2"></i>Pay Now
          </button>
        </div>
      </form>
    </div>
  </div>
</section>

<!-- Success Toast -->
<div class="success-toast-dark" id="successToast">
  <div class="w-10 h-10 rounded-xl bg-accent/20 flex items-center justify-center text-accent text-base shrink-0">
    <i class="ri-check-line"></i>
  </div>
  <div>
    <div class="font-bold">Payment successful!</div>
    <div class="text-xs text-white/40">Redirecting to your dashboard...</div>
  </div>
</div>

<script src="{{ asset('assets/js/script.js') }}"></script>
<script>
  setActivePage && setActivePage('register');

  // ─── Wizard State ─────────────────────────────────────────────────
  var currentStep  = 1;
  var totalSteps   = 3;
  var selectedPlan    = { id: '', name: '', price: '0.00' };
  var appliedCoupon   = { code: '', discount: 0, type: '', finalPrice: 0 }; // tracks applied coupon
  var stripeState  = { cardNumber: false, cardExpiry: false, cardCvc: false };
  var stripeInited = false;
  var cardNumberEl, cardExpiryEl, cardCvcEl; // Stripe element references

  var prevBtn     = document.getElementById('prevBtn');
  var nextBtn     = document.getElementById('nextBtn');
  var payBtn      = document.getElementById('payBtn');
  var progressBar = document.getElementById('progressBar');
  var errorEl     = document.getElementById('wizardError');
  var successToast = document.getElementById('successToast');

  // ─── Field Error Helpers ──────────────────────────────────────────
  function showFieldError(fieldId, msg) {
    var el    = document.getElementById('err-' + fieldId);
    var input = document.getElementById(fieldId) || document.querySelector('[name="' + fieldId + '"]');
    if (el) {
      if (msg) el.textContent = msg;
      el.style.display = 'block';
    }
    if (input && (input.tagName === 'INPUT' || input.tagName === 'SELECT' || input.tagName === 'TEXTAREA')) {
      input.classList.add('inp-error');
    }
  }
  function hideFieldError(fieldId) {
    var el    = document.getElementById('err-' + fieldId);
    var input = document.getElementById(fieldId) || document.querySelector('[name="' + fieldId + '"]');
    if (el) el.style.display = 'none';
    if (input) input.classList.remove('inp-error');
  }

  // Clear errors on input/change
  document.querySelectorAll('.auth-input, .select-dark').forEach(function(el) {
    var key = el.id || el.name;
    if (!key) return;
    el.addEventListener('input',  function() { hideFieldError(key); });
    el.addEventListener('change', function() { hideFieldError(key); });
  });
  document.getElementById('termsChk').addEventListener('change', function() {
    hideFieldError('terms');
  });

  // ─── Password Strength ────────────────────────────────────────────
  var pwdInput      = document.getElementById('password');
  var strengthBar   = document.getElementById('strengthBar');
  var strengthLabel = document.getElementById('strengthLabel');
  var segs          = strengthBar ? strengthBar.querySelectorAll('.strength-seg-dark') : [];
  var strengthColors = ['rgba(255,255,255,.08)', '#ef4444', '#f97316', '#eab308', '#10b981'];
  var strengthTexts  = ['', 'Very weak', 'Weak', 'Fair', 'Strong'];

  function computeStrength(v) {
    var s = 0;
    if (v.length >= 8)   s++;
    if (/[0-9]/.test(v)) s++;
    if (/[A-Z]/.test(v)) s++;
    if (/[a-z]/.test(v)) s++;
    return s;
  }

  if (pwdInput) {
    pwdInput.addEventListener('input', function() {
      var val   = pwdInput.value;
      var score = val.length === 0 ? 0 : computeStrength(val);
      segs.forEach(function(seg, i) {
        seg.style.background = (i < score) ? strengthColors[score] : 'rgba(255,255,255,.08)';
      });
      strengthLabel.textContent = val.length === 0
        ? 'Password strength'
        : 'Password strength: ' + (strengthTexts[score] || 'Very weak');
      var pwRx = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
      if (pwRx.test(val)) hideFieldError('password');
    });
  }

  // Live confirm password match
  var confirmPwdInput = document.getElementById('confirmPassword');
  if (confirmPwdInput) {
    confirmPwdInput.addEventListener('input', function() {
      if (pwdInput && confirmPwdInput.value === pwdInput.value) hideFieldError('confirmPassword');
    });
  }

  // ─── Toggle Password Visibility ───────────────────────────────────
  ['togglePassword', 'toggleConfirmPassword'].forEach(function(btnId) {
    var btn = document.getElementById(btnId);
    if (!btn) return;
    btn.addEventListener('click', function() {
      var inputId  = (btnId === 'togglePassword') ? 'password' : 'confirmPassword';
      var inp      = document.getElementById(inputId);
      var isHidden = inp.type === 'password';
      inp.type      = isHidden ? 'text' : 'password';
      btn.innerHTML = isHidden ? '<i class="ri-eye-line"></i>' : '<i class="ri-eye-off-line"></i>';
    });
  });

  // ─── Plan Selection ────────────────────────────────────────────────
  function selectPlan(card) {
    document.querySelectorAll('.plan-card').forEach(function(c) { c.classList.remove('selected'); });
    card.classList.add('selected');
    selectedPlan = {
      id:    card.dataset.planId,
      name:  card.dataset.plan,
      price: card.dataset.price
    };
    document.getElementById('planIdInput').value             = selectedPlan.id;
    document.getElementById('selectedPlanName').textContent  = selectedPlan.name + ' Plan';
    document.getElementById('selectedPlanPrice').textContent = '£' + selectedPlan.price;
    document.getElementById('headerPrice').textContent       = '£' + selectedPlan.price;
    document.getElementById('summaryPlan').textContent       = selectedPlan.name;
    hideFieldError('plan');

    // Recalculate if a coupon is already applied
    recalculateTotal();
  }

  // ─── Price Calculation ─────────────────────────────────────────────
  function recalculateTotal() {
    var basePrice = parseFloat(selectedPlan.price) || 0;
    var discount  = 0;
    var finalPrice = basePrice;

    if (appliedCoupon.code) {
      if (appliedCoupon.type === 'percentage') {
        discount   = parseFloat((basePrice * appliedCoupon.discount / 100).toFixed(2));
        finalPrice = parseFloat((basePrice - discount).toFixed(2));
      } else { // fixed
        discount   = parseFloat(appliedCoupon.discount.toFixed(2));
        finalPrice = parseFloat(Math.max(0, basePrice - discount).toFixed(2));
      }
    }

    appliedCoupon.finalPrice = finalPrice;

    // Update summary
    var discountRow = document.getElementById('summaryDiscountRow');
    if (appliedCoupon.code && discount > 0) {
      if (!discountRow) {
        // Insert discount row before total row
        var totalRow = document.getElementById('summaryTotalRow');
        var row      = document.createElement('div');
        row.id       = 'summaryDiscountRow';
        row.className = 'flex items-center justify-between text-sm';
        row.innerHTML = '<span class="text-white/50">Discount:</span><span class="text-accent font-semibold" id="summaryDiscount">-£0.00</span>';
        totalRow.parentNode.insertBefore(row, totalRow);
      }
      var discEl = document.getElementById('summaryDiscount');
      if (discEl) discEl.textContent = '-£' + discount.toFixed(2);
    } else {
      if (discountRow) discountRow.remove();
    }

    document.getElementById('summaryTotal').textContent = '£' + finalPrice.toFixed(2);
  }

  // ─── Stripe Lazy Init (only when step 3 is shown) ─────────────────
  function initStripe() {
    if (stripeInited) return;
    stripeInited = true;

    // Key is injected by the controller from config('services.stripe.key')
    var stripePublishableKey = '{{ $stripeKey ?? "" }}';

    if (!stripePublishableKey) {
      showGlobalError('Stripe publishable key is missing. Please set STRIPE_KEY in your .env file and clear config cache (php artisan config:clear).');
      stripeInited = false; // allow retry after fix
      return;
    }

    var stripe   = Stripe(stripePublishableKey);
    var elements = stripe.elements();

    var stripeStyle = {
      base: {
        color: '#ffffff',
        fontFamily: 'Inter, system-ui, sans-serif',
        fontSize: '14px',
        fontSmoothing: 'antialiased',
        '::placeholder': { color: 'rgba(255,255,255,0.35)' },
        iconColor: '#ffffff',
      },
      invalid: { color: '#f87171', iconColor: '#f87171' }
    };

    cardNumberEl = elements.create('cardNumber', { style: stripeStyle, showIcon: true });
    cardExpiryEl = elements.create('cardExpiry', { style: stripeStyle });
    cardCvcEl    = elements.create('cardCvc',    { style: stripeStyle });

    cardNumberEl.mount('#stripe-card-number');
    cardExpiryEl.mount('#stripe-card-expiry');
    cardCvcEl.mount('#stripe-card-cvc');

    cardNumberEl.on('change', function(e) {
      stripeState.cardNumber = e.complete;
      if (e.error) showFieldError('cardNumber', e.error.message);
      else hideFieldError('cardNumber');
    });
    cardExpiryEl.on('change', function(e) {
      stripeState.cardExpiry = e.complete;
      if (e.error) showFieldError('expiry', e.error.message);
      else hideFieldError('expiry');
    });
    cardCvcEl.on('change', function(e) {
      stripeState.cardCvc = e.complete;
      if (e.error) showFieldError('cvv', e.error.message);
      else hideFieldError('cvv');
    });

    // Wire Pay Now here so stripe vars are in scope
    payBtn.addEventListener('click', async function() {
      if (!validateStep(3)) return;

      payBtn.disabled  = true;
      payBtn.innerHTML = '<i class="ri-loader-4-line ri-spin mr-2"></i>Processing...';

      try {
        var result = await stripe.createToken(cardNumberEl, {
          name: document.getElementById('cardName').value.trim()
        });

        if (result.error) {
          showGlobalError(result.error.message);
          payBtn.disabled  = false;
          payBtn.innerHTML = '<i class="ri-shield-check-line mr-2"></i>Pay Now';
          return;
        }

        var token = result.token;
        document.getElementById('stripeToken').value      = token.id;
        document.getElementById('cardNumberHidden').value = '•••• •••• •••• ' + token.card.last4;
        document.getElementById('expiryHidden').value     =
          String(token.card.exp_month).padStart(2, '0') + '/' + String(token.card.exp_year).slice(-2);

        // Set final pricing for server
        var basePrice  = parseFloat(selectedPlan.price) || 0;
        var finalPrice = appliedCoupon.code ? appliedCoupon.finalPrice : basePrice;
        var discount   = parseFloat((basePrice - finalPrice).toFixed(2));
        document.getElementById('discountAmountHidden').value = discount.toFixed(2);
        document.getElementById('finalAmountHidden').value    = finalPrice.toFixed(2);

        var form     = document.getElementById('wizardForm');
        var formData = new FormData(form);

        var response = await fetch('{{ route("register.store") }}', {
          method: 'POST',
          headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
          body: formData
        });

        var json = await response.json();

        if (json.success) {
          payBtn.innerHTML        = '<i class="ri-check-line mr-2"></i>Payment successful!';
          payBtn.style.background = 'linear-gradient(135deg,#10b981,#059669)';
          successToast.classList.add('show');
          setTimeout(function() { window.location.href = json.redirect; }, 2000);
        } else {
          showGlobalError(json.message || 'Payment failed. Please try again.');
          payBtn.disabled  = false;
          payBtn.innerHTML = '<i class="ri-shield-check-line mr-2"></i>Pay Now';
        }

      } catch (err) {
        showGlobalError('An unexpected error occurred. Please try again.');
        payBtn.disabled  = false;
        payBtn.innerHTML = '<i class="ri-shield-check-line mr-2"></i>Pay Now';
      }
    });
  }

  // ─── Validation ───────────────────────────────────────────────────
  function validateStep(step) {
    var valid = true;

    if (step === 1) {
      var fn = document.getElementById('firstName').value.trim();
      var ln = document.getElementById('lastName').value.trim();
      var em = document.getElementById('email').value.trim();
      var pw = document.getElementById('password').value;
      var cp = document.getElementById('confirmPassword').value;
      var tc = document.getElementById('termsChk').checked;

      if (!fn) { showFieldError('firstName', 'First name is required.');  valid = false; }
      else hideFieldError('firstName');

      if (!ln) { showFieldError('lastName', 'Last name is required.');    valid = false; }
      else hideFieldError('lastName');

      // var emailRx = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      // if (!em)               { showFieldError('email', 'Email address is required.');       valid = false; }
      // else if (!emailRx.test(em)) { showFieldError('email', 'Please enter a valid email.'); valid = false; }
      // else hideFieldError('email');
      const emailRx = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;

if (!em) {
    showFieldError('email', 'Email address is required.');
    valid = false;
} else if (!emailRx.test(em)) {
    showFieldError('email', 'Please enter a valid email.');
    valid = false;
} else {
    hideFieldError('email');
}

      var pwRx = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
      if (!pw)             { showFieldError('password', 'Password is required.');           valid = false; }
      else if (!pwRx.test(pw)) { showFieldError('password', 'Min 8 chars, uppercase, lowercase and a number.'); valid = false; }
      else hideFieldError('password');

      if (!cp)        { showFieldError('confirmPassword', 'Please confirm your password.'); valid = false; }
      else if (pw !== cp) { showFieldError('confirmPassword', 'Passwords do not match.');   valid = false; }
      else hideFieldError('confirmPassword');

      if (!tc) { showFieldError('terms', 'You must accept the Terms & Conditions.'); valid = false; }
      else hideFieldError('terms');
    }

    if (step === 2) {
      var a1      = document.getElementById('address1').value.trim();
      var pc      = document.getElementById('postcode').value.trim();
      var country = document.getElementById('country').value;
      var phone   = document.getElementById('phone').value.trim();

      if (!a1) { showFieldError('address1', 'Address line 1 is required.'); valid = false; }
      else hideFieldError('address1');

      var pcRx = /^[A-Z]{1,2}[0-9][A-Z0-9]?\s?[0-9][A-Z]{2}$/i;
      if (!pc)              { showFieldError('postcode', 'Post code is required.'); valid = false; }
      else if (!pcRx.test(pc)) { showFieldError('postcode', 'Please enter a valid UK postcode (e.g. SW1A 1AA).'); valid = false; }
      else hideFieldError('postcode');

      if (!country) { showFieldError('country', 'Please select a country.'); valid = false; }
      else hideFieldError('country');

      var phoneRx = /^\+?[\d\s\-]{10,15}$/;
      if (!phone)              { showFieldError('phone', 'Phone number is required.'); valid = false; }
      else if (!phoneRx.test(phone)) { showFieldError('phone', 'Please enter a valid phone number (10–15 digits).'); valid = false; }
      else hideFieldError('phone');
    }

    if (step === 3) {
      if (!selectedPlan.id) { showFieldError('plan', 'Please select a plan.'); valid = false; }
      else hideFieldError('plan');

      var cn = document.getElementById('cardName').value.trim();
      if (!cn) { showFieldError('cardName', 'Name on card is required.'); valid = false; }
      else hideFieldError('cardName');

      if (!stripeState.cardNumber) { showFieldError('cardNumber', 'Please enter your card number.'); valid = false; }
      else hideFieldError('cardNumber');
      if (!stripeState.cardExpiry) { showFieldError('expiry', 'Please enter card expiry date.'); valid = false; }
      else hideFieldError('expiry');
      if (!stripeState.cardCvc)    { showFieldError('cvv', 'Please enter the CVV.'); valid = false; }
      else hideFieldError('cvv');
    }

    return valid;
  }

  // ─── Step UI ──────────────────────────────────────────────────────
  function updateStepUI() {
    document.querySelectorAll('.wizard-step').forEach(function(s) { s.classList.remove('active'); });
    document.querySelector('.wizard-step[data-step="' + currentStep + '"]').classList.add('active');

    document.querySelectorAll('.step-item').forEach(function(item, i) {
      var n = i + 1;
      item.classList.remove('active', 'completed');
      if (n < currentStep)      item.classList.add('completed');
      else if (n === currentStep) item.classList.add('active');
    });

    progressBar.style.width = ((currentStep - 1) / (totalSteps - 1) * 100) + '%';
    prevBtn.classList.toggle('hidden', currentStep === 1);
    nextBtn.classList.toggle('hidden', currentStep === totalSteps);
    payBtn.classList.toggle('hidden',  currentStep !== totalSteps);

    // Populate summary + init Stripe when reaching step 3
    if (currentStep === 3) {
      var form = document.getElementById('wizardForm');
      var d    = new FormData(form);
      var fn   = (d.get('firstName') || '').trim();
      var ln   = (d.get('lastName')  || '').trim();
      document.getElementById('summaryName').textContent  = [fn, ln].filter(Boolean).join(' ') || '-';
      document.getElementById('summaryEmail').textContent = (d.get('email') || '').trim() || '-';
      document.getElementById('summaryPhone').textContent = (d.get('phone') || '').trim() || '-';
      // Init Stripe NOW — the elements are visible in the DOM
      initStripe();
      // Always pre-select the first plan card if none manually chosen yet
      var preSelected = document.querySelector('.plan-card.selected') || document.querySelector('.plan-card');
      if (preSelected && !selectedPlan.id) selectPlan(preSelected);
    }

    hideGlobalError();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function showGlobalError(msg) {
    errorEl.textContent = msg;
    errorEl.style.display = 'block';
    errorEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
  }
  function hideGlobalError() {
    errorEl.style.display = 'none';
  }

  // ─── Next Button ──────────────────────────────────────────────────
  nextBtn.addEventListener('click', function() {
    // Run all local validations first
    if (!validateStep(currentStep)) return;

    // On step 1 — check email uniqueness via AJAX before advancing
    if (currentStep === 1) {
      var email = document.getElementById('email').value.trim();

      // Disable button and show loading state
      nextBtn.disabled  = true;
      nextBtn.innerHTML = '<i class="ri-loader-4-line ri-spin mr-2"></i>Checking...';

      fetch('{{ route("check.email") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json'
        },
        body: JSON.stringify({ email: email })
      })
      .then(function(res) { return res.json(); })
      .then(function(data) {
        // Restore button
        nextBtn.disabled  = false;
        nextBtn.innerHTML = 'Next<i class="ri-arrow-right-line ml-2"></i>';

        if (data.exists) {
          // Show inline error under email field
          showFieldError('email', 'This email address is already registered. Please log in or use a different email.');
          document.getElementById('email').focus();
        } else {
          // Email is free — advance to step 2
          hideFieldError('email');
          currentStep++;
          updateStepUI();
        }
      })
      .catch(function() {
        // Network/server error — still allow advancing (server validates again on submit)
        nextBtn.disabled  = false;
        nextBtn.innerHTML = 'Next<i class="ri-arrow-right-line ml-2"></i>';
        currentStep++;
        updateStepUI();
      });

      return; // wait for async result
    }

    // Steps 2+ — advance immediately (no async check needed)
    currentStep++;
    updateStepUI();
  });

  // ─── Prev Button ─────────────────────────────────────────────────
  prevBtn.addEventListener('click', function() {
    if (currentStep > 1) { currentStep--; updateStepUI(); }
  });

  // ─── Coupon Code (Dynamic from DB) ───────────────────────────────
  var applyCouponBtn = document.getElementById('applyCoupon');
  var couponInput    = document.getElementById('couponInput');
  var couponMessage  = document.getElementById('couponMessage');
  couponInput.addEventListener('input', function () {
    couponMessage.textContent = '';
    couponMessage.style.display = 'none';
});

  if (applyCouponBtn) {
    applyCouponBtn.addEventListener('click', function() {
      var code = couponInput.value.trim();
      if (!code) {
        couponMessage.textContent   = 'Please enter a coupon code.';
        couponMessage.style.color   = '#f87171';
        couponMessage.style.display = 'block';
        return;
      }

      if (!selectedPlan.id) {
        couponMessage.textContent   = 'Please select a plan before applying a coupon.';
        couponMessage.style.color   = '#f87171';
        couponMessage.style.display = 'block';
        return;
      }

      // Reset any previously applied coupon
      appliedCoupon = { code: '', discount: 0, type: '', finalPrice: 0 };
      recalculateTotal();

      applyCouponBtn.disabled   = true;
      applyCouponBtn.textContent = 'Checking...';

      fetch('{{ route("coupon.apply") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json'
        },
        body: JSON.stringify({ code: code, plan_id: selectedPlan.id })
      })
      .then(function(res) { return res.json(); })
      .then(function(data) {
        if (data.success) {
          appliedCoupon = {
            code:       data.coupon.code,
            discount:   parseFloat(data.coupon.discount),
            type:       data.coupon.coupon_type,  // 'fixed' or 'percentage'
            finalPrice: 0
          };
          // Store hidden coupon code for server submission
          document.getElementById('appliedCouponCode').value = appliedCoupon.code;
          recalculateTotal();

          var label = appliedCoupon.type === 'percentage'
            ? appliedCoupon.discount + '% off'
            : '£' + parseFloat(appliedCoupon.discount).toFixed(2) + ' off';

          couponMessage.textContent   = '✓ Coupon applied! ' + label;
          couponMessage.style.color   = '#10b981';
          couponMessage.style.display = 'block';
          applyCouponBtn.disabled     = true;
          applyCouponBtn.textContent  = 'Applied ✓';
          couponInput.disabled        = true;
        } else {
          couponMessage.textContent   = '✗ ' + (data.message || 'Invalid coupon code.');
          couponMessage.style.color   = '#f87171';
          couponMessage.style.display = 'block';
          applyCouponBtn.disabled     = false;
          applyCouponBtn.textContent  = 'Apply';
        }
      })
      .catch(function() {
        couponMessage.textContent   = '✗ Unable to validate coupon. Please try again.';
        couponMessage.style.color   = '#f87171';
        couponMessage.style.display = 'block';
        applyCouponBtn.disabled     = false;
        applyCouponBtn.textContent  = 'Apply';
      });
    });
  }

  // ─── Init ─────────────────────────────────────────────────────────
  updateStepUI();
</script>

@endsection