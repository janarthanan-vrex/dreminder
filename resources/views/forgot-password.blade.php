@extends('layouts.app')
@section('content')
<style>
  .o2 {
    display: none !important;
  }

  .field-error {
    display: none;
    color: #ff4d4f;
    font-size: 13px;
    margin-top: 6px;
}

.field-error.show {
    display: block;
}
</style>

<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          primary: '#7c3aed',
          secondary: '#06b6d4',
          accent: '#10b981',
          dark: '#030014'
        },
        fontFamily: {
          sans: ['Inter', 'system-ui', 'sans-serif']
        }
      }
    }
  }
</script>

<div class="auth-wrap-dark section-dark min-h-screen relative overflow-hidden">
  <div class="gradient-blob w-[600px] h-[600px] bg-primary top-[-20%] left-[-15%]"></div>
  <div class="gradient-blob w-[500px] h-[500px] bg-secondary bottom-[-15%] right-[-10%]"></div>
  <canvas id="authParticleC" style="position:absolute;inset:0;pointer-events:none;z-index:0;width:100%;height:100%"></canvas>

  <div class="auth-card-dark relative z-10">
    <div class="text-center mb-8">
      <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-700 flex items-center justify-center mx-auto mb-5">
        <i class="ri-lock-unlock-line text-3xl text-white"></i>
      </div>
      <h1 class="text-2xl font-black tracking-tight text-white mb-1">Forgot Password?</h1>
      <p class="text-sm text-white/35">No worries, we'll send you reset instructions</p>
    </div>

    <form class="flex flex-col gap-4" onsubmit="return false;">
      <div>
        <label class="auth-label">Email Address</label>
        <div class="auth-input-icon">
          <i class="ri-mail-line auth-icon"></i>
          <input type="email" id="forgotEmail" placeholder="Enter your registered email" class="auth-input" autocomplete="email" required>
        </div>
        <div class="form-err-dark" id="emailErr">Please enter a valid email address.</div>
        @if(session('error'))
    <div class="field-error" id="sessionError" style="display:block;">
        {{ session('error') }}
    </div>
@endif
      </div>

      <button type="button" class="auth-submit-dark" id="resetBtn">
        <i class="ri-mail-send-line mr-2"></i>Send Reset Link
      </button>
    </form>

    <!-- Success Message -->
    <div id="successMsg" class="hidden mt-5 p-4 rounded-2xl" style="background:rgba(16,185,129,.08);border:1px solid rgba(16,185,129,.2)">
      <div class="flex items-start gap-3">
        <div class="w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center shrink-0">
          <i class="ri-check-line text-emerald-400"></i>
        </div>
        <div>
          <h4 class="font-bold text-sm text-white mb-1">Email Sent!</h4>
   <p class="text-xs text-white/35">
  Check your inbox for password reset instructions.
  Didn't receive it?
  <a href="{{ route('forgotpassword.page') }}" id="resendBtn"
     class="btn text-emerald-400 font-semibold hover:text-emerald-300">
     Resend
  </a>
</p>
        </div>
      </div>
    </div>

    <div class="mt-6 text-center">
      <a href="login" class="inline-flex items-center gap-2 text-sm text-white/40 hover:text-purple-400 transition">
        <i class="ri-arrow-left-line"></i> Back to Login
      </a>
    </div>

  </div>
</div>

<script src="{{ asset('assets/js/script.js') }}"></script>

<script>

/* =========================
   RESET PASSWORD (API CALL)
========================= */

document.getElementById('resetBtn')?.addEventListener('click', async function () {

  const email = document.getElementById('forgotEmail').value;
  const emailErr = document.getElementById('emailErr');

  emailErr.classList.remove('show');

  // Frontend validation
  if (!email || !email.includes('@')) {
    emailErr.innerText = "Please enter a valid email address.";
    emailErr.classList.add('show');
    return;
  }

  this.innerHTML = '<i class="ri-loader-4-line ri-spin mr-2"></i>Sending...';
  this.disabled = true;

  try {

    const res = await fetch("{{ route('storeToken.forgotpassword') }}", {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({ email: email })
    });

    const data = await res.json();

    // ❌ Backend error
    if (!data.status) {
      emailErr.innerText = data.message;
      emailErr.classList.add('show');

      this.innerHTML = '<i class="ri-mail-send-line mr-2"></i>Send Reset Link';
      this.disabled = false;
      return;
    }

    // ✅ SUCCESS
    this.classList.add('hidden');
    document.getElementById('successMsg').classList.remove('hidden');

  } catch (err) {
    console.log(err);
    this.innerHTML = '<i class="ri-mail-send-line mr-2"></i>Send Reset Link';
    this.disabled = false;
  }
});


/* =========================
   RESEND BUTTON
========================= */
document.getElementById('resendBtn')?.addEventListener('click', async function () {

  const email = document.getElementById('forgotEmail').value;
  const emailErr = document.getElementById('emailErr');

  if (!email || !email.includes('@')) {
    emailErr.innerText = "Enter valid email to resend.";
    emailErr.classList.add('show');
    return;
  }

  this.innerHTML = '<i class="ri-loader-4-line ri-spin"></i>';

  try {

    await fetch("{{ route('storeToken.forgotpassword') }}", {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({ email: email })
    });

    this.innerHTML = 'Sent!';
    setTimeout(() => {
      this.innerHTML = 'Resend';
    }, 2000);

  } catch (err) {
    console.log(err);
    this.innerHTML = 'Resend';
  }
});


/* =========================
   HIDE ERROR ON INPUT (SAFE)
========================= */
document.getElementById('forgotEmail')?.addEventListener('input', function () {
  document.getElementById('emailErr')?.classList.remove('show');
});

document.addEventListener('DOMContentLoaded', function () {

  const input = document.getElementById('forgotEmail');
  const sessionError = document.getElementById('sessionError');

  if (!input) return;

  input.addEventListener('input', function () {

    // Hide session error when user types
    if (sessionError) {
      sessionError.style.display = 'none';
      sessionError.innerText = '';
    }

  });

});


/* =========================
   PARTICLE BACKGROUND
========================= */
(function () {
  const c = document.getElementById('authParticleC');
  if (!c) return;

  const ctx = c.getContext('2d');
  let pts = [];

  function rz() {
    c.width = innerWidth;
    c.height = innerHeight;
    pts = [];

    for (let i = 0; i < 60; i++) {
      pts.push({
        x: Math.random() * c.width,
        y: Math.random() * c.height,
        vx: (Math.random() - .5) * .4,
        vy: (Math.random() - .5) * .4,
        s: Math.random() * 2 + 1,
        a: Math.random() * .3 + .05,
        h: [265, 190, 155][~~(Math.random() * 3)]
      });
    }
  }

  rz();
  window.addEventListener('resize', rz);

  (function anim() {
    ctx.clearRect(0, 0, c.width, c.height);

    pts.forEach(p => {
      p.x += p.vx;
      p.y += p.vy;

      if (p.x < -10) p.x = c.width + 10;
      if (p.x > c.width + 10) p.x = -10;
      if (p.y < -10) p.y = c.height + 10;
      if (p.y > c.height + 10) p.y = -10;

      ctx.beginPath();
      ctx.arc(p.x, p.y, p.s, 0, Math.PI * 2);
      ctx.fillStyle = `hsla(${p.h},75%,60%,${p.a})`;
      ctx.fill();
    });

    requestAnimationFrame(anim);
  })();
})();
</script>

<script>
// Show error message from URL
(function () {
  const params = new URLSearchParams(window.location.search);
  const error = params.get('error');

  if (error) {
    const emailErr = document.getElementById('emailErr');

    if (emailErr) {
      emailErr.innerText = decodeURIComponent(error);
      emailErr.classList.add('show');
    }
  }
})();
</script>

@endsection