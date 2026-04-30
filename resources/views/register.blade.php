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
    .wizard-step {
      display: none;
      animation: fadeIn 0.3s ease-in-out;
    }
    .wizard-step.active {
      display: block;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* Progress Indicator */
    .step-indicator {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 40px;
      position: relative;
    }
    .step-indicator::before {
      content: '';
      position: absolute;
      top: 20px;
      left: 0;
      right: 0;
      height: 2px;
      background: rgba(255,255,255,.1);
      z-index: 0;
    }
    .step-progress-bar {
      position: absolute;
      top: 20px;
      left: 0;
      height: 2px;
      background: linear-gradient(90deg, #7c3aed, #06b6d4);
      z-index: 1;
      transition: width 0.4s cubic-bezier(.16,1,.3,1);
    }
    .step-item {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 8px;
      position: relative;
      z-index: 2;
      flex: 1;
    }
    .step-circle {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: rgba(255,255,255,.05);
      border: 2px solid rgba(255,255,255,.1);
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      color: rgba(255,255,255,.3);
      font-size: 0.9rem;
      transition: all 0.3s;
      position: relative;
    }
    .step-item.active .step-circle {
      background: linear-gradient(135deg, #7c3aed, #6d28d9);
      border-color: #7c3aed;
      color: #fff;
      box-shadow: 0 0 20px rgba(124,58,237,.5);
      transform: scale(1.1);
    }
    .step-item.completed .step-circle {
      background: linear-gradient(135deg, #10b981, #059669);
      border-color: #10b981;
      color: #fff;
    }
    .step-item.completed .step-circle::after {
      content: '\e5ca';
      font-family: 'remixicon';
      position: absolute;
      font-size: 1.2rem;
    }
    .step-label {
      font-size: 0.7rem;
      color: rgba(255,255,255,.3);
      font-weight: 600;
      text-align: center;
      transition: color 0.3s;
    }
    .step-item.active .step-label,
    .step-item.completed .step-label {
      color: rgba(255,255,255,.8);
    }

    /* Mobile Step Indicator */
    @media (max-width: 640px) {
      .step-label { display: none; }
      .step-circle { width: 36px; height: 36px; font-size: 0.8rem; }
    }

    /* Payment Plan Cards */
    .plan-card {
      border: 2px solid rgba(255,255,255,0.08);
      border-radius: 16px;
      padding: 16px;
      cursor: pointer;
      transition: all 0.25s ease;
      background: rgba(255,255,255,0.03);
      position: relative;
    }
    .plan-card:hover {
      border-color: rgba(124,58,237,0.4);
      background: rgba(124,58,237,0.05);
    }
    .plan-card.selected {
      border-color: #7c3aed;
      background: rgba(124,58,237,0.12);
      box-shadow: 0 0 20px rgba(124,58,237,0.2);
    }
    .plan-card .plan-radio {
      position: absolute;
      top: 14px;
      right: 14px;
      width: 18px;
      height: 18px;
      border-radius: 50%;
      border: 2px solid rgba(255,255,255,0.2);
      background: transparent;
      transition: all 0.2s;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .plan-card.selected .plan-radio {
      border-color: #7c3aed;
      background: #7c3aed;
    }
    .plan-card.selected .plan-radio::after {
      content: '';
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: white;
    }
    .plan-badge {
      display: inline-block;
      font-size: 9px;
      font-weight: 700;
      letter-spacing: 0.06em;
      padding: 2px 8px;
      border-radius: 20px;
      text-transform: uppercase;
    }

    /* Success Toast */
    .success-toast-dark {
      position: fixed;
      bottom: 30px;
      right: 30px;
      background: rgba(3,0,20,.95);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(16,185,129,.3);
      border-radius: 16px;
      padding: 18px 24px;
      display: flex;
      align-items: center;
      gap: 14px;
      box-shadow: 0 10px 40px rgba(16,185,129,.2);
      z-index: 99999;
      opacity: 0;
      transform: translateY(20px);
      pointer-events: none;
      transition: all .4s cubic-bezier(.16,1,.3,1);
    }
    .success-toast-dark.show {
      opacity: 1;
      transform: translateY(0);
      pointer-events: auto;
    }
  </style>

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
      Join for just <span class="grad-text">£2.40/year</span>
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
      <!-- What's Included -->
      <div class="glass-strong rounded-3xl p-7 md:p-8 border border-primary/30">
        <div class="flex items-center gap-3 mb-4">
          <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary to-secondary flex items-center justify-center">
            <i class="ri-vip-crown-line text-2xl text-white"></i>
          </div>
          <div>
            <h3 class="text-base font-bold text-white">What's included</h3>
            <p class="text-[11px] text-white/40">Everything for £2.40/year</p>
          </div>
        </div>
        
        <ul class="space-y-3 text-xs text-white/60">
          <li class="flex items-start gap-2">
            <i class="ri-check-line text-accent mt-0.5 flex-shrink-0"></i>
            <span><strong class="text-white">Unlimited reminders</strong> — track every bill & subscription</span>
          </li>
          <li class="flex items-start gap-2">
            <i class="ri-check-line text-accent mt-0.5 flex-shrink-0"></i>
            <span><strong class="text-white">Smart notifications</strong> — push, email & SMS alerts</span>
          </li>
          <li class="flex items-start gap-2">
            <i class="ri-check-line text-accent mt-0.5 flex-shrink-0"></i>
            <span><strong class="text-white">Family sharing</strong> — up to 5 household members</span>
          </li>
          <li class="flex items-start gap-2">
            <i class="ri-check-line text-accent mt-0.5 flex-shrink-0"></i>
            <span><strong class="text-white">Savings dashboard</strong> — see how much you save</span>
          </li>
          <li class="flex items-start gap-2">
            <i class="ri-check-line text-accent mt-0.5 flex-shrink-0"></i>
            <span><strong class="text-white">Priority support</strong> — get help when you need it</span>
          </li>
          <li class="flex items-start gap-2">
            <i class="ri-check-line text-accent mt-0.5 flex-shrink-0"></i>
            <span><strong class="text-white">All future updates</strong> — new features automatically included</span>
          </li>
        </ul>
      </div>

      <!-- What happens next -->
      <div class="glass-strong rounded-3xl p-6">
        <h3 class="text-sm font-semibold text-white mb-4">What happens next?</h3>
        <ol class="space-y-3">
          <li class="flex gap-3 text-[11px] text-white/40">
            <span class="w-6 h-6 rounded-full bg-primary/20 flex items-center justify-center text-[11px] text-purple-300 font-bold flex-shrink-0">1</span>
            <span>Payment is processed securely and your account is created instantly.</span>
          </li>
          <li class="flex gap-3 text-[11px] text-white/40">
            <span class="w-6 h-6 rounded-full bg-primary/20 flex items-center justify-center text-[11px] text-purple-300 font-bold flex-shrink-0">2</span>
            <span>Confirm your email address via the verification link we send.</span>
          </li>
          <li class="flex gap-3 text-[11px] text-white/40">
            <span class="w-6 h-6 rounded-full bg-primary/20 flex items-center justify-center text-[11px] text-purple-300 font-bold flex-shrink-0">3</span>
            <span>Add your first reminders — insurance, energy, subscriptions, etc.</span>
          </li>
          <li class="flex gap-3 text-[11px] text-white/40">
            <span class="w-6 h-6 rounded-full bg-primary/20 flex items-center justify-center text-[11px] text-purple-300 font-bold flex-shrink-0">4</span>
            <span>Relax! We'll notify you before anything renews.</span>
          </li>
        </ol>
      </div>

      <!-- Money Back Guarantee -->
      <div class="glass-strong rounded-2xl p-4 bg-gradient-to-br from-accent/10 to-accent/5 border border-accent/20 text-center">
        <i class="ri-medal-line text-3xl text-accent mb-2"></i>
        <p class="text-[10px] text-white/40">
          Not happy? Get a full refund within 30 days, no questions asked.
        </p>
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
          <div class="text-2xl font-black" id="headerPrice">£2.40</div>
          <p class="text-[10px] text-white/40">per year</p>
        </div>
      </div>

      <!-- Progress Indicator (3 steps now) -->
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
        
        <!-- STEP 1: Account Info -->
        <div class="wizard-step active" data-step="1">
          <h3 class="text-sm font-semibold text-white/70 flex items-center gap-2 mb-4">
            <i class="ri-user-line text-primary"></i>
            Personal Information
          </h3>
          
          <div class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="auth-label">First name <span style="color:red;">*</span></label>
                <input type="text" name="firstName" class="auth-input" placeholder="Enter Your First Name">
              </div>
              <div>
                <label class="auth-label">Last name <span style="color:red;">*</span></label>
                <input type="text" name="lastName" class="auth-input" placeholder="Enter Your Last Name">
              </div>
            </div>

            <div>
              <label class="auth-label">Email address <span style="color:red;">*</span></label>
              <input type="email" name="email" class="auth-input" placeholder="Enter Your Email">
              <p class="text-[11px] text-white/30 mt-1">
                We'll send important account updates and reminders here.
              </p>
            </div>

            <div>
              <label class="auth-label flex items-center gap-2">
                Password<span style="color:red;">*</span>
                <span class="text-[10px] text-white/30 font-normal">
                  (min 8 chars, 1 uppercase, 1 lowercase, 1 number)
                </span>
              </label>
              <div class="relative">
                <input type="password" name="password" id="password" class="auth-input pr-10" placeholder="Create a strong password">
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
            </div>

            <div>
              <label class="auth-label">Confirm password <span style="color:red;">*</span></label>
              <div class="relative">
                <input type="password" name="confirmPassword" id="confirmPassword" class="auth-input pr-10" placeholder="Re-enter your password">
                <button type="button" id="toggleConfirmPassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-white/40 hover:text-white/70 text-lg">
                  <i class="ri-eye-off-line"></i>
                </button>
              </div>
            </div>

            
            <!-- Terms & Privacy -->
            <div class="space-y-3">
              <div class="flex items-start gap-3">
                <input type="checkbox" id="termsChk" style="accent-color:#7c3aed" class="mt-1">
                <label for="termsChk" class="text-[11px] text-white/40 leading-relaxed">
                  I agree to the
                  <a href="terms" target="_blank" class="text-purple-300 hover:text-white transition">Terms & Conditions</a>
                  and
                  <a href="privacy" target="_blank" class="text-purple-300 hover:text-white transition">Privacy Policy</a>.
                </label>
              </div>
            </div>
          </div>
        </div>

        <!-- STEP 2: Address -->
        <div class="wizard-step" data-step="2">
          <h3 class="text-sm font-semibold text-white/70 flex items-center gap-2 mb-4">
            <i class="ri-map-pin-line text-primary"></i>
            Address Details
          </h3>
          
          <div class="space-y-4">
            <div>
              <label class="auth-label">Address Line 1 <span style="color:red;">*</span></label>
              <input type="text" name="address1" class="auth-input" placeholder="123 High Street">
            </div>

            <div>
              <label class="auth-label">Address Line 2 <span class="text-white/25 text-xs">(optional)</span></label>
              <input type="text" name="address2" class="auth-input" placeholder="Apartment, suite, etc.">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="auth-label">Post code <span style="color:red;">*</span></label>
                <input type="text" name="postcode" class="auth-input" placeholder="SW1A 1AA">
                <p class="text-[11px] text-white/30 mt-1">
                  UK alphanumeric postcode.
                </p>
              </div>

              <div>
                <label class="auth-label">Country <span style="color:red;">*</span></label>
                <select name="country" class="select-dark">
                  <option value="">Select country</option>
                  <option value="United Kingdom" selected>United Kingdom</option>
                  <option value="Ireland">Ireland</option>
                  <option value="India">India</option>
                  <option value="Other">Other</option>
                </select>
              </div>
            </div>

            <div>
              <label class="auth-label">Phone number (UK) <span style="color:red;">*</span></label>
              <input type="tel" name="phone" class="auth-input" placeholder="+44 7123 456789">
              <p class="text-[11px] text-white/30 mt-1">
                10–15 digits, UK format.
              </p>
            </div>
          </div>
        </div>

        <!-- STEP 3: Payment & Confirm (merged) -->
        <div class="wizard-step" data-step="3">

          <!-- Payment Method Selection -->
          <h3 class="text-sm font-semibold text-white/70 flex items-center gap-2 mb-4">
            <i class="ri-bank-card-line text-primary"></i>
            Choose Your Plan
          </h3>

          <div class="grid grid-cols-1 sm:grid-cols-1 gap-3 mb-6">
            <!-- Basic Plan -->
            <!-- <div class="plan-card" data-plan="basic" data-price="2.40" onclick="selectPlan(this)">
              <div class="plan-radio"></div>
              <div class="mb-2">
                <span class="plan-badge" style="background:rgba(255,255,255,0.08);color:rgba(255,255,255,0.5);">Basic</span>
              </div>
              <div class="text-xl font-black text-white">£2.40</div>
              <div class="text-[10px] text-white/35 mb-3">per year</div>
              <ul class="space-y-1.5 text-[10px] text-white/40">
                <li class="flex items-center gap-1.5"><i class="ri-check-line text-accent text-xs"></i>Up to 10 reminders</li>
                <li class="flex items-center gap-1.5"><i class="ri-check-line text-accent text-xs"></i>Email notifications</li>
                <li class="flex items-center gap-1.5"><i class="ri-check-line text-accent text-xs"></i>1 user</li>
              </ul>
            </div> -->

            <!-- Standard Plan -->
            <div class="plan-card selected" data-plan="standard" data-price="4.80" onclick="selectPlan(this)">
              <div class="plan-radio"></div>
              <div class="mb-2">
                <span class="plan-badge" style="background:rgba(124,58,237,0.25);color:#c4b5fd;">Popular</span>
              </div>
              <div class="text-xl font-black text-white">£4.80</div>
              <div class="text-[10px] text-white/35 mb-3">per year</div>
              <ul class="space-y-1.5 text-[10px] text-white/40">
                <li class="flex items-center gap-1.5"><i class="ri-check-line text-accent text-xs"></i>Unlimited reminders</li>
                <li class="flex items-center gap-1.5"><i class="ri-check-line text-accent text-xs"></i>Push + Email alerts</li>
                <li class="flex items-center gap-1.5"><i class="ri-check-line text-accent text-xs"></i>Up to 3 users</li>
              </ul>
            </div>

            <!-- Pro Plan -->
            <!-- <div class="plan-card" data-plan="pro" data-price="9.60" onclick="selectPlan(this)">
              <div class="plan-radio"></div>
              <div class="mb-2">
                <span class="plan-badge" style="background:rgba(6,182,212,0.2);color:#67e8f9;">Pro</span>
              </div>
              <div class="text-xl font-black text-white">£9.60</div>
              <div class="text-[10px] text-white/35 mb-3">per year</div>
              <ul class="space-y-1.5 text-[10px] text-white/40">
                <li class="flex items-center gap-1.5"><i class="ri-check-line text-accent text-xs"></i>Unlimited reminders</li>
                <li class="flex items-center gap-1.5"><i class="ri-check-line text-accent text-xs"></i>Push + Email + SMS</li>
                <li class="flex items-center gap-1.5"><i class="ri-check-line text-accent text-xs"></i>Family (5 users)</li>
              </ul>
            </div> -->
          </div>

          <!-- Selected Plan Summary Bar -->
          <div class="bg-gradient-to-br from-primary/10 to-secondary/10 border border-primary/20 rounded-2xl p-4 mb-5">
            <div class="flex items-center justify-between">
              <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-primary to-secondary flex items-center justify-center">
                  <i class="ri-vip-crown-line text-lg text-white"></i>
                </div>
                <div>
                  <h4 class="font-bold text-white text-sm" id="selectedPlanName">Standard Plan</h4>
                  <p class="text-[10px] text-white/40">Full access to all features</p>
                </div>
              </div>
              <div class="text-right">
                <div class="text-xl font-black text-white" id="selectedPlanPrice">£4.80</div>
                <p class="text-[10px] text-white/30">per year</p>
              </div>
            </div>
          </div>

          <!-- Coupon Code -->
          <div class="mb-5">
            <label class="auth-label">Coupon code <span class="text-white/25 text-xs">(optional)</span></label>
            <div class="flex gap-2">
              <input type="text" name="coupon" id="couponInput" class="auth-input flex-1" placeholder="Enter coupon code">
              <button type="button" id="applyCoupon" class="btn-secondary !py-3 !px-6 whitespace-nowrap">
                Apply
              </button>
            </div>
            <p id="couponMessage" class="text-[11px] mt-1 hidden"></p>
          </div>

          <!-- Review & Confirm Section -->
          <div class="pt-4 border-t border-white/10 space-y-4">
            <h3 class="text-sm font-semibold text-white/70 flex items-center gap-2">
              <i class="ri-checkbox-circle-line text-primary"></i>
              Review & Confirm
            </h3>

            <!-- Summary -->
            <div class="glass rounded-2xl p-5 space-y-3">
              <div class="flex items-center justify-between text-sm">
                <span class="text-white/50">Name:</span>
                <span class="text-white font-semibold" id="summaryName">-</span>
              </div>
              <div class="flex items-center justify-between text-sm">
                <span class="text-white/50">Email:</span>
                <span class="text-white font-semibold" id="summaryEmail">-</span>
              </div>
              <div class="flex items-center justify-between text-sm">
                <span class="text-white/50">Phone:</span>
                <span class="text-white font-semibold" id="summaryPhone">-</span>
              </div>
              <div class="flex items-center justify-between text-sm">
                <span class="text-white/50">Plan:</span>
                <span class="text-white font-semibold capitalize" id="summaryPlan">Standard</span>
              </div>
              <div class="flex items-center justify-between text-sm pt-3 border-t border-white/10">
                <span class="text-white/50">Total Amount:</span>
                <span class="text-xl font-black text-accent" id="summaryTotal">£4.80</span>
              </div>
            </div>
          </div>

          <!-- Card Details -->
          <div class="space-y-4 pt-4 border-t border-white/10 mb-5">
            <h3 class="text-sm font-semibold text-white/70 flex items-center gap-2">
              <i class="ri-secure-payment-line text-primary"></i>
              Card Details
            </h3>
            <div class="flex items-center gap-2">
              <i class="ri-shield-check-line text-accent"></i>
              <span class="text-xs text-white/60">Secure payment processing</span>
            </div>

            <div>
              <label class="auth-label">Name on card <span style="color:red;">*</span></label>
              <input type="text" name="cardName" class="auth-input" placeholder="Enter Your Card Name">
            </div>

            <div>
              <label class="auth-label">Card number <span style="color:red;">*</span></label>
              <input type="text" name="cardNumber" maxlength="19" class="auth-input" placeholder="**** **** **** ****">
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="auth-label">Expiry (MM/YY) <span style="color:red;">*</span></label>
                <input type="text" name="expiry" maxlength="5" class="auth-input" placeholder="08/29">
              </div>
              <div>
                <label class="auth-label">CVV <span style="color:red;">*</span></label>
                <input type="password" name="cvv" maxlength="3" class="auth-input" placeholder="123">
              </div>
            </div>
          </div>
        </div>

        <!-- Error Message -->
        <p id="wizardError" class="text-[11px] text-rose-400 mt-3 hidden"></p>

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

  // WIZARD STATE
  let currentStep = 1;
  const totalSteps = 3;
  const formData = {};
  let selectedPlan = { name: 'standard', price: '4.80' };

  // ELEMENTS
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');
  const payBtn = document.getElementById('payBtn');
  const progressBar = document.getElementById('progressBar');
  const errorEl = document.getElementById('wizardError');
  const successToast = document.getElementById('successToast');

  // PLAN SELECTION
  function selectPlan(card) {
    document.querySelectorAll('.plan-card').forEach(c => c.classList.remove('selected'));
    card.classList.add('selected');
    selectedPlan = {
      name: card.dataset.plan,
      price: card.dataset.price
    };
    document.getElementById('selectedPlanName').textContent =
      card.dataset.plan.charAt(0).toUpperCase() + card.dataset.plan.slice(1) + ' Plan';
    document.getElementById('selectedPlanPrice').textContent = '£' + card.dataset.price;
    document.getElementById('headerPrice').textContent = '£' + card.dataset.price;
    document.getElementById('summaryPlan').textContent =
      card.dataset.plan.charAt(0).toUpperCase() + card.dataset.plan.slice(1);
    document.getElementById('summaryTotal').textContent = '£' + card.dataset.price;
  }

  // PASSWORD STRENGTH
  const pwdInput = document.getElementById('password');
  const strengthBar = document.getElementById('strengthBar');
  const strengthLabel = document.getElementById('strengthLabel');
  const segs = strengthBar ? strengthBar.querySelectorAll('.strength-seg-dark') : [];

  function computeStrength(value) {
    let score = 0;
    if (value.length >= 8) score++;
    if (/[0-9]/.test(value)) score++;
    if (/[A-Z]/.test(value)) score++;
    if (/[a-z]/.test(value)) score++;
    return score;
  }

  if (pwdInput && strengthBar) {
    pwdInput.addEventListener('input', () => {
      const score = computeStrength(pwdInput.value);
      segs.forEach((seg, idx) => {
        seg.style.background = idx < score ? '#7c3aed' : 'rgba(255,255,255,.08)';
      });
      const labels = ['very weak','weak','fair','strong','very strong'];
      strengthLabel.textContent = 'Password strength: ' + (labels[score] || labels[0]);
    });
  }

  // PASSWORD TOGGLE
  const togglePassword = document.getElementById('togglePassword');
  if (togglePassword && pwdInput) {
    togglePassword.addEventListener('click', () => {
      const isPwd = pwdInput.type === 'password';
      pwdInput.type = isPwd ? 'text' : 'password';
      togglePassword.innerHTML = isPwd ? '<i class="ri-eye-line"></i>' : '<i class="ri-eye-off-line"></i>';
    });
  }

  const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
  const confirmPwdInput = document.getElementById('confirmPassword');
  if (toggleConfirmPassword && confirmPwdInput) {
    toggleConfirmPassword.addEventListener('click', () => {
      const isPwd = confirmPwdInput.type === 'password';
      confirmPwdInput.type = isPwd ? 'text' : 'password';
      toggleConfirmPassword.innerHTML = isPwd ? '<i class="ri-eye-line"></i>' : '<i class="ri-eye-off-line"></i>';
    });
  }

  function showError(msg) {
    if (!errorEl) return;
    errorEl.textContent = msg;
    errorEl.classList.remove('hidden');
    errorEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
  }

  function hideError() {
    if (errorEl) errorEl.classList.add('hidden');
  }

  // UPDATE STEP UI
  function updateStepUI() {
    document.querySelectorAll('.wizard-step').forEach(step => {
      step.classList.remove('active');
    });
    const activeStep = document.querySelector(`.wizard-step[data-step="${currentStep}"]`);
    if (activeStep) activeStep.classList.add('active');

    document.querySelectorAll('.step-item').forEach((item, index) => {
      const stepNum = index + 1;
      item.classList.remove('active', 'completed');
      if (stepNum < currentStep) {
        item.classList.add('completed');
      } else if (stepNum === currentStep) {
        item.classList.add('active');
      }
    });

    const progress = ((currentStep - 1) / (totalSteps - 1)) * 100;
    progressBar.style.width = progress + '%';

    prevBtn.classList.toggle('hidden', currentStep === 1);
    nextBtn.classList.toggle('hidden', currentStep === totalSteps);
    payBtn.classList.toggle('hidden', currentStep !== totalSteps);

    // Populate summary when reaching step 3
    if (currentStep === 3) {
      const form = document.getElementById('wizardForm');
      const data = new FormData(form);
      const first = (data.get('firstName') || '').trim();
      const last = (data.get('lastName') || '').trim();
      document.getElementById('summaryName').textContent = (first || last) ? `${first} ${last}`.trim() : '-';
      document.getElementById('summaryEmail').textContent = (data.get('email') || '').trim() || '-';
      document.getElementById('summaryPhone').textContent = (data.get('phone') || '').trim() || '-';
      document.getElementById('summaryPlan').textContent =
        selectedPlan.name.charAt(0).toUpperCase() + selectedPlan.name.slice(1);
      document.getElementById('summaryTotal').textContent = '£' + selectedPlan.price;
    }

    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  // NEXT BUTTON (no validation)
  nextBtn.addEventListener('click', () => {
    hideError();
    if (currentStep < totalSteps) {
      currentStep++;
      updateStepUI();
    }
  });

  // PREVIOUS BUTTON
  prevBtn.addEventListener('click', () => {
    if (currentStep > 1) {
      currentStep--;
      updateStepUI();
      hideError();
    }
  });

  // PAY NOW BUTTON
  payBtn.addEventListener('click', () => {
    payBtn.disabled = true;
    payBtn.innerHTML = '<i class="ri-loader-4-line ri-spin mr-2"></i>Processing payment...';

    setTimeout(() => {
      payBtn.innerHTML = '<i class="ri-check-line mr-2"></i>Payment successful!';
      payBtn.style.background = 'linear-gradient(135deg,#10b981,#059669)';
      successToast.classList.add('show');
      setTimeout(() => {
        window.location.href = 'user-dashboard';
      }, 2000);
    }, 2500);
  });

  // Card number formatting
  const cardNumberInput = document.querySelector('input[name="cardNumber"]');
  if (cardNumberInput) {
    cardNumberInput.addEventListener('input', (e) => {
      let value = e.target.value.replace(/\s/g, '');
      let formatted = value.match(/.{1,4}/g)?.join(' ') || value;
      e.target.value = formatted;
    });
  }

  // Expiry formatting
  const expiryInput = document.querySelector('input[name="expiry"]');
  if (expiryInput) {
    expiryInput.addEventListener('input', (e) => {
      let value = e.target.value.replace(/\D/g, '');
      if (value.length >= 2) {
        value = value.substring(0, 2) + '/' + value.substring(2, 4);
      }
      e.target.value = value;
    });
  }

  // Coupon code
  const applyCouponBtn = document.getElementById('applyCoupon');
  const couponInput = document.getElementById('couponInput');
  const couponMessage = document.getElementById('couponMessage');

  if (applyCouponBtn) {
    applyCouponBtn.addEventListener('click', () => {
      const code = couponInput.value.trim().toUpperCase();
      if (!code) {
        couponMessage.textContent = 'Please enter a coupon code.';
        couponMessage.className = 'text-[11px] text-rose-400 mt-1';
        couponMessage.classList.remove('hidden');
        return;
      }
      if (code === 'SAVE10') {
        couponMessage.textContent = '✓ Coupon applied! 10% discount.';
        couponMessage.className = 'text-[11px] text-accent mt-1';
        couponMessage.classList.remove('hidden');
        applyCouponBtn.disabled = true;
        applyCouponBtn.textContent = 'Applied';
      } else {
        couponMessage.textContent = '✗ Invalid coupon code.';
        couponMessage.className = 'text-[11px] text-rose-400 mt-1';
        couponMessage.classList.remove('hidden');
      }
    });
  }

  // Initialize
  updateStepUI();
</script>

@endsection