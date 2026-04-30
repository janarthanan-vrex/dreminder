
@extends('layouts.app')
@section('content')

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

<section class="page-hero-dark section-alt relative" data-particles="purple" data-p-count="40" data-p-connect="false">
  <div class="gradient-blob w-[460px] h-[460px] bg-primary top-[-18%] left-[15%]"></div>
  <div class="max-w-[840px] mx-auto px-6 relative z-10">
    <div class="page-breadcrumb">
      <a href="index">Home</a><span class="sep">/</span><span>Legal</span>
    </div>
    <div class="badge bg-primary/10 border border-primary/20 text-purple-300 mx-auto mb-6 w-fit reveal">
      <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span> Terms &amp; Conditions
    </div>
    <h1 class="reveal">Your data. <span class="grad-text">Your control.</span></h1>
    <p class="reveal" data-delay="1">
      We take privacy and security seriously. Review the key policies that govern how DRemind works.
    </p>
  </div>
</section>

<section class="relative py-16 md:py-20 section-dark overflow-hidden">
  <div class="max-w-100 mx-auto px-6 lg:px-40 grid grid-cols-1 gap-10">
    <div>
      
      <div class="legal-tab-dark">

        <!-- 1 -->
        <div class="legal-section-dark">
          <h3>1. Acceptance of Terms</h3>
          <p>
            By accessing, registering, or using DRemind (“Service”), you agree to be bound by these Terms of Use and all applicable laws and regulations. These terms constitute a legally binding agreement between you and DRemind.
          </p>
          <p>
            If you do not agree with any part of these terms, you must not use our Services. Continued use of the platform indicates your acceptance of any future updates or modifications to these Terms.
          </p>
        </div>

        <!-- 2 -->
        <div class="legal-section-dark">
          <h3>2. Eligibility</h3>
          <ul>
            <li>You must be at least 16 years old or meet the minimum digital consent age in your country.</li>
            <li>By using the Service, you confirm that you have the legal capacity to enter into a binding agreement.</li>
            <li>If you are using the Service on behalf of an organization, you agree to these Terms on behalf of that entity.</li>
          </ul>
        </div>

        <!-- 3 -->
        <div class="legal-section-dark">
          <h3>3. User Accounts</h3>
          <ul>
            <li>You are responsible for maintaining the confidentiality of your account credentials.</li>
            <li>You agree to provide accurate and complete information during registration.</li>
            <li>You are solely responsible for all activities that occur under your account.</li>
            <li>You must notify us immediately of any unauthorized use or security breach.</li>
          </ul>
        </div>

        <!-- 4 -->
        <div class="legal-section-dark">
          <h3>4. Use of the Service</h3>
          <ul>
            <li>You agree to use DRemind only for lawful purposes.</li>
            <li>You must not misuse, disrupt, or attempt to gain unauthorized access to the Service.</li>
            <li>Reverse engineering, scraping, or exploiting the platform is strictly prohibited.</li>
            <li>You must not use the Service to send spam, harmful, or misleading notifications.</li>
          </ul>
        </div>

        <!-- 5 -->
        <div class="legal-section-dark">
          <h3>5. Plans and Billing</h3>
          <ul>
            <li>The free plan is available indefinitely and does not require a payment method.</li>
            <li>Paid plans are billed on a recurring basis and renew automatically unless cancelled.</li>
            <li>You can manage or cancel your subscription anytime from account settings.</li>
            <li>All payments are non-refundable except where required by applicable law.</li>
          </ul>
        </div>

        <!-- 6 -->
        <div class="legal-section-dark">
          <h3>6. Notifications & Reliability</h3>
          <p>
            DRemind aims to provide reliable reminders and notifications. However, we do not guarantee that all reminders will be delivered, received, or acted upon on time.
          </p>
          <p>
            You acknowledge that the Service is a support tool and should not be solely relied upon for critical or time-sensitive obligations.
          </p>
        </div>

        <!-- 7 -->
        <div class="legal-section-dark">
          <h3>7. Intellectual Property</h3>
          <p>
            All content, branding, design, and technology associated with DRemind are the exclusive property of the company. You may not copy, reproduce, or distribute any part of the Service without prior written permission.
          </p>
        </div>

        <!-- 8 -->
        <div class="legal-section-dark">
          <h3>8. Termination</h3>
          <ul>
            <li>We reserve the right to suspend or terminate your account if you violate these Terms.</li>
            <li>You may stop using the Service at any time.</li>
            <li>Upon termination, your access to the Service will be revoked immediately.</li>
          </ul>
        </div>

        <!-- 9 -->
        <div class="legal-section-dark">
          <h3>9. Limitation of Liability</h3>
          <p>
            To the maximum extent permitted by law, DRemind shall not be liable for any indirect, incidental, or consequential damages arising from your use of the Service.
          </p>
          <p>
            We do not guarantee uninterrupted access, error-free operation, or complete accuracy of reminders.
          </p>
        </div>

        <!-- 10 -->
        <div class="legal-section-dark">
          <h3>10. Changes to Terms</h3>
          <p>
            We may update these Terms from time to time. Any changes will be posted on this page with an updated effective date.
          </p>
          <p>
            Continued use of the Service after changes constitutes your acceptance of the revised Terms.
          </p>
        </div>

        <!-- 11 -->
        <div class="legal-section-dark">
          <h3>11. Contact Us</h3>
          <p>
            If you have any questions about these Terms, you can contact our support team through the official DRemind platform.
          </p>
        </div>

      </div>

    </div>
  </div>
</section>

<script src="{{ asset('assets/js/distortion.js') }}"></script>

<script src="{{ asset('assets/js/script.js') }}"></script>
@endsection
