@extends('layouts.app')
@section('content')
<script>tailwind.config={theme:{extend:{colors:{primary:'#7c3aed',secondary:'#06b6d4',accent:'#10b981',dark:'#030014',surface:'#0a0a1f',card:'#0f0f2a'},fontFamily:{sans:['Inter','system-ui','sans-serif']}}}}</script>
<style>
  /* Contact Page Specific Styles */
  .contact-card-dark {
    padding: 24px;
    border-radius: 20px;
    background: rgba(255,255,255,.02);
    border: 1px solid rgba(255,255,255,.06);
    transition: all .4s cubic-bezier(.16,1,.3,1);
  }
  .contact-card-dark:hover {
    background: rgba(255,255,255,.04);
    border-color: rgba(124,58,237,.2);
    transform: translateY(-4px);
    box-shadow: 0 20px 50px rgba(124,58,237,.1);
  }
  .social {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: rgba(255,255,255,.03);
    border: 1px solid rgba(255,255,255,.08);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    color: rgba(255,255,255,.5);
    transition: all .3s;
  }
  .social:hover {
    background: rgba(124,58,237,.15);
    border-color: rgba(124,58,237,.3);
    color: #c4b5fd;
    transform: translateY(-2px);
  }

  /* Map Section */
  .map-section {
    position: relative;
    height: 500px;
    border-radius: 28px;
    overflow: hidden;
    border: 1px solid rgba(255,255,255,.08);
    box-shadow: 0 20px 60px rgba(0,0,0,.3);
  }
  .map-iframe {
    width: 100%;
    height: 100%;
    border: 0;
    filter: grayscale(0.3) contrast(1.1);
    transition: filter .4s;
  }
  .map-section:hover .map-iframe {
    filter: grayscale(0) contrast(1);
  }
  .map-overlay {
    position: absolute;
    top: 24px;
    left: 24px;
    background: rgba(3,0,20,.85);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 20px;
    padding: 24px 28px;
    max-width: 360px;
    z-index: 10;
    box-shadow: 0 10px 40px rgba(0,0,0,.4);
  }
  .map-overlay h4 {
    font-size: 1.1rem;
    font-weight: 800;
    color: #fff;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .map-overlay h4 i {
    font-size: 1.3rem;
    color: #7c3aed;
  }
  .map-overlay p {
    font-size: .9rem;
    color: rgba(255,255,255,.6);
    line-height: 1.7;
    margin-bottom: 16px;
  }
  .map-overlay .directions-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    border-radius: 12px;
    background: linear-gradient(135deg, #7c3aed, #6d28d9);
    color: #fff;
    font-size: .85rem;
    font-weight: 700;
    text-decoration: none;
    transition: all .3s;
    border: 1px solid rgba(255,255,255,.1);
  }
  .map-overlay .directions-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(124,58,237,.4);
  }

  /* Responsive Map */
  @media (max-width: 768px) {
    .map-section {
      height: 400px;
      border-radius: 20px;
    }
    .map-overlay {
      top: 16px;
      left: 16px;
      right: 16px;
      max-width: none;
      padding: 20px;
    }
  }

  /* Stagger delays */
  .d1 { transition-delay: 0s; }
  .d2 { transition-delay: .1s; }
  .d3 { transition-delay: .2s; }
  .d4 { transition-delay: .3s; }

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

<!-- ===================== HERO ===================== -->
<section class="page-hero-dark section-alt relative" data-particles="cyan" data-p-count="40" data-p-connect="false">
  <div class="gradient-blob w-[400px] h-[400px] bg-secondary top-[-15%] right-[10%]"></div>
  <div class="max-w-[800px] mx-auto px-6 relative z-10">
    <div class="page-breadcrumb"><a href="index">Home</a><span class="sep">/</span><span>Contact</span></div>
    <div class="badge bg-secondary/10 border border-secondary/20 text-cyan-300 mx-auto mb-6 w-fit reveal"><span class="w-2 h-2 rounded-full bg-secondary"></span> Get In Touch</div>
    <h1 class="reveal">We'd love to <span class="grad-text">hear from you.</span></h1>
    <p class="reveal" data-delay="1">Have a question, feedback, or just want to say hi? Our team typically responds within 24 hours.</p>
  </div>
</section>

<!-- ===================== CONTACT INFO + FORM ===================== -->
<section class="relative py-20 section-dark overflow-hidden">
  <div class="max-w-7xl mx-auto px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 xl:gap-10">
      
      <!-- LEFT: Info Cards -->
      <div class="flex flex-col gap-5">
        <div class="contact-card-dark reveal d1">
          <div class="w-12 h-12 rounded-xl bg-primary/15 flex items-center justify-center text-xl text-purple-400 mb-4">
            <i class="ri-map-pin-line"></i>
          </div>
          <h4 class="font-bold text-white mb-2">Our Office</h4>
          <p class="text-sm text-white/40 leading-relaxed">
            Unit 5, Martinbridge Trading Estate,<br>
            240–242 Lincoln Road,<br>
            Enfield, United Kingdom, EN1 1SP.
          </p>
        </div>
        
        <div class="contact-card-dark reveal d2">
          <div class="w-12 h-12 rounded-xl bg-secondary/15 flex items-center justify-center text-xl text-cyan-400 mb-4">
            <i class="ri-mail-line"></i>
          </div>
          <h4 class="font-bold text-white mb-2">Email Us</h4>
          <a href="mailto:info@winngoodremind.co.uk" class="text-sm text-purple-400 hover:text-purple-300 transition block mb-1">info@winngoodremind.co.uk</a>
          <p class="text-xs text-white/30 mb-3">General enquiries &amp; support</p>
          <a href="mailto:support@winngoodremind.co.uk" class="text-sm text-purple-400 hover:text-purple-300 transition block mb-1">support@winngoodremind.co.uk</a>
          <p class="text-xs text-white/30">Technical support</p>
        </div>
        
        <div class="contact-card-dark reveal d3">
          <div class="w-12 h-12 rounded-xl bg-accent/15 flex items-center justify-center text-xl text-emerald-400 mb-4">
            <i class="ri-phone-line"></i>
          </div>
          <h4 class="font-bold text-white mb-2">Call Us</h4>
          <a href="tel:+02033765250" class="text-sm text-purple-400 hover:text-purple-300 transition block mb-1">+020 3376 5250</a>
          <p class="text-xs text-white/30">Mon–Fri, 9am–6pm GMT</p>
        </div>
        
        <div class="contact-card-dark reveal d4">
          <h4 class="font-bold text-white mb-4">Follow Us</h4>
          <div class="flex gap-3">
            <a href="#" class="social" aria-label="Facebook"><i class="ri-facebook-fill"></i></a>
            <a href="#" class="social" aria-label="Instagram"><i class="ri-instagram-line"></i></a>
            <a href="#" class="social" aria-label="Twitter"><i class="ri-twitter-x-line"></i></a>
            <a href="#" class="social" aria-label="LinkedIn"><i class="ri-linkedin-fill"></i></a>
          </div>
        </div>
      </div>
      
      <!-- RIGHT: Contact Form -->
      <div class="lg:col-span-2">
        <div class="glass-strong reveal-right !rounded-3xl p-8 md:p-10">
          <h3 class="text-2xl font-bold text-white mb-2">Send us a message</h3>
          <p class="text-sm text-white/40 mb-8">Fill out the form below and we'll get back to you within 24 hours.</p>
          
          <form id="contactForm" class="flex flex-col gap-5" onsubmit="return false;">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
              <div>
                <label class="auth-label">First Name <span class="text-red-400">*</span></label>
                <input type="text" name="first_name" id="first_name" placeholder="Enter Your First Name" class="auth-input">
<div id="err-first_name" class="text-red-400 text-xs mt-1 hidden"></div>
              </div>
              <div>
                <label class="auth-label">Last Name <span class="text-red-400">*</span></label>
              <input type="text" name="last_name" id="last_name" placeholder="Enter Your Last Name" class="auth-input">
<div id="err-last_name" class="text-red-400 text-xs mt-1 hidden"></div>
              </div>
            </div>
            
            <div>
              <label class="auth-label">Email Address <span class="text-red-400">*</span></label>
              <input type="email" name="email" id="email" placeholder="Enter Your Email" class="auth-input">
<div id="err-email" class="text-red-400 text-xs mt-1 hidden"></div>
            </div>
            
            <div>
              <label class="auth-label">Phone Number <span class="text-white/25 text-xs">(optional)</span></label>
              <input type="tel" name="phone" id="phone" placeholder="+44 020 0000 0000" class="auth-input">
<div id="err-phone" class="text-red-400 text-xs mt-1 hidden"></div>
            </div>
            
            <div>
              <label class="auth-label">Subject <span class="text-red-400">*</span></label>
             <input type="text" name="subject" id="subject" placeholder="Enter Your Subject" class="auth-input">
<div id="err-subject" class="text-red-400 text-xs mt-1 hidden"></div>
            </div>
            
            <div>
              <label class="auth-label">Message <span class="text-red-400">*</span></label>
              <textarea name="message" id="message" placeholder="Tell us how we can help you..." class="textarea-dark" rows="5"></textarea>
<div id="err-message" class="text-red-400 text-xs mt-1 hidden"></div>
            </div>
            
            <!-- <div class="flex items-start gap-3">
              <input type="checkbox" id="privacyChk" style="accent-color:#7c3aed;margin-top:3px" required>
              <label for="privacyChk" class="text-xs text-white/35 leading-relaxed">
                I agree to the <a href="privacy" class="text-purple-400 hover:text-purple-300 transition">Privacy Policy</a> and consent to being contacted regarding my enquiry.
              </label>
            </div> -->
            
            <button type="button" id="submitBtn" class="auth-submit-dark">
              <i class="ri-send-plane-line mr-2"></i>Send Message
            </button>
          </form>

        </div>
      </div>
      
    </div>
  </div>
</section>

<!-- ===================== MAP SECTION ===================== -->
<section class="relative py-20 section-alt overflow-hidden">
  <div class="max-w-7xl mx-auto px-6 lg:px-8">
    
    <!-- Section Header -->
    <div class="text-center mb-12 reveal">
      <div class="badge bg-primary/10 border border-primary/20 text-purple-300 mx-auto mb-6 w-fit">
        <span class="w-2 h-2 rounded-full bg-primary"></span> Find Us
      </div>
      <h2 class="text-3xl md:text-4xl font-black text-white mb-4">
        Visit our <span class="grad-text">office</span>
      </h2>
      <p class="text-base text-white/40 max-w-2xl mx-auto">
        We're located in Enfield, North London. Drop by for a coffee or schedule a meeting with our team.
      </p>
    </div>
    
    <!-- Map Container -->
    <div class="map-section reveal" data-delay="1">
      <iframe 
        class="map-iframe"
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2476.8326449567334!2d-0.05669882346679688!3d51.65067900463867!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x48761f5e0f0f0f0f%3A0x0!2s240-242%20Lincoln%20Rd%2C%20Enfield%20EN1%201SP%2C%20UK!5e0!3m2!1sen!2sus!4v1234567890123!5m2!1sen!2sus"
        allowfullscreen="" 
        loading="lazy" 
        referrerpolicy="no-referrer-when-downgrade">
      </iframe>
      
      <!-- Map Overlay Card -->
      <div class="map-overlay">
        <h4><i class="ri-map-pin-2-fill"></i> Our Location</h4>
        <p>
          Unit 5, Martinbridge Trading Estate<br>
          240–242 Lincoln Road<br>
          Enfield, United Kingdom<br>
          EN1 1SP
        </p>
        <a href="https://maps.google.com/?q=240-242+Lincoln+Road+Enfield+EN1+1SP+UK" target="_blank" class="directions-btn">
          <i class="ri-navigation-line"></i>
          Get Directions
        </a>
      </div>
    </div>
    
  </div>
</section>

<!-- ===================== FAQ CTA ===================== -->
<!-- <section class="relative py-20 section-dark overflow-hidden text-center">
  <div id="grid-distortion-container" style="width: 100%; top: 0; height: 100%; position: absolute;"></div>

  <div class="max-w-[700px] mx-auto px-6 relative z-10">
    <div class="badge bg-primary/10 border border-primary/20 text-purple-300 mx-auto mb-6 w-fit reveal">
      <span class="w-2 h-2 rounded-full bg-primary"></span> Need Quick Answers?
    </div>
    <h2 class="text-3xl md:text-4xl font-black text-white mb-4 reveal" data-delay="1">
      Check our <span class="grad-text">FAQ first</span>
    </h2>
    <p class="text-base text-white/40 mb-8 reveal" data-delay="2">
      Most common questions are already answered in our FAQ section. Save time — take a look!
    </p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center reveal" data-delay="3">
      <a href="faq" class="btn-primary"><i class="ri-question-line text-xl"></i>Browse FAQ</a>
      <a href="register" class="btn-secondary">Try for Free <i class="ri-arrow-right-line"></i></a>
    </div>
  </div>
</section> -->

<!-- Success Toast -->
<div class="success-toast-dark" id="successToast">
  <div class="w-10 h-10 rounded-xl bg-accent/20 flex items-center justify-center text-accent text-base shrink-0">
    <i class="ri-check-line"></i>
  </div>
  <div>
    <div class="font-bold">Message sent successfully!</div>
    <div class="text-xs text-white/40">We'll get back to you within 24 hours.</div>
  </div>
</div>

<!-- Distortion Animation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="{{ asset('assets/js/distortion.js') }}"></script>

<script src="{{ asset('assets/js/script.js') }}"></script>
<script>

setActivePage('contact');

const form = document.getElementById('contactForm');
const btn = document.getElementById('submitBtn');

function clearErrors() {

    document.querySelectorAll('[id^="err-"]').forEach(el => {

        el.innerHTML = '';
        el.classList.add('hidden');

    });

}

// 🔥 hide error while typing
['first_name','last_name','email','phone','subject','message']
.forEach(id => {

    document.getElementById(id)?.addEventListener('input', () => {

        document.getElementById('err-' + id)
            ?.classList.add('hidden');

    });

});

btn?.addEventListener('click', async () => {

    clearErrors();

    btn.disabled = true;

    btn.innerHTML =
        '<i class="ri-loader-4-line ri-spin mr-2"></i>Sending...';

    try {

        const response = await fetch(
            "{{ route('contact.send') }}",
            {
                method: 'POST',

                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },

                body: JSON.stringify({

                    first_name :
                        document.getElementById('first_name').value,

                    last_name :
                        document.getElementById('last_name').value,

                    email :
                        document.getElementById('email').value,

                    phone :
                        document.getElementById('phone').value,

                    subject :
                        document.getElementById('subject').value,

                    message :
                        document.getElementById('message').value,

                })

            }
        );

        const data = await response.json();

        // 🔥 validation error
        if (!response.ok) {

            Object.keys(data.errors).forEach(field => {

                const err =
                    document.getElementById('err-' + field);

                err.innerHTML = data.errors[field][0];

                err.classList.remove('hidden');

            });

            return;

        }

        // ✅ success ui
        btn.innerHTML =
            '<i class="ri-check-line mr-2"></i>Sent Successfully!';

        btn.style.background =
            'linear-gradient(135deg,#10b981,#059669)';

        const toast =
            document.getElementById('successToast');

        toast.classList.add('show');

        form.reset();

        setTimeout(() => {

            toast.classList.remove('show');

        }, 4000);

    } catch (err) {

        console.log(err);

    } finally {

        setTimeout(() => {

            btn.disabled = false;

            btn.innerHTML =
                '<i class="ri-send-plane-line mr-2"></i>Send Message';

            btn.style.background = '';

        }, 3000);

    }

});

</script>

@endsection
