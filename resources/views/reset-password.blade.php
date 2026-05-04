@extends('layouts.app')
@section('content')
<style>
  .o2 {
    display: none !important;
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
      <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-700 flex items-center justify-center mx-auto mb-5">
        <i class="ri-lock-password-line text-3xl text-white"></i>
      </div>
      <h1 class="text-2xl font-black tracking-tight text-white mb-1">Reset Password</h1>
      <p class="text-sm text-white/35">Enter your new password below</p>
    </div>

    <form class="flex flex-col gap-4">


      <!-- hidden fields -->
      <input type="hidden" name="email" value="{{ request()->email }}">
      <input type="hidden" name="token" value="{{ request()->token }}">
      <div>
        <label class="auth-label">New Password</label>
        <div class="auth-input-icon" style="position:relative">
          <i class="ri-lock-line auth-icon"></i>
          <input type="password" id="newPwd" name="new_password" placeholder="Enter new password" class="auth-input" required>
          <button type="button" id="togglePwd1" style="position:absolute;right:16px;top:50%;transform:translateY(-50%);background:none;border:none;color:rgba(255,255,255,.3);cursor:pointer;font-size:.85rem">
            <i class="ri-eye-line"></i>
          </button>
        </div>
        <div class="form-err-dark" id="pwdErr">Password must be at least 8 characters.</div>

        <!-- Password Strength Indicator -->
        <div class="mt-2 space-y-1">
          <div class="flex gap-1">
            <div class="h-1 flex-1 rounded-full bg-white/10" id="str1"></div>
            <div class="h-1 flex-1 rounded-full bg-white/10" id="str2"></div>
            <div class="h-1 flex-1 rounded-full bg-white/10" id="str3"></div>
            <div class="h-1 flex-1 rounded-full bg-white/10" id="str4"></div>
          </div>
          <p class="text-xs text-white/30" id="strText">Enter password to check strength</p>
        </div>
      </div>

      <div>
        <label class="auth-label">Confirm Password</label>
        <div class="auth-input-icon" style="position:relative">
          <i class="ri-lock-line auth-icon"></i>
          <input type="password" id="confirmPwd" name="new_password_confirmation" placeholder="Confirm new password" class="auth-input" required>
          <button type="button" id="togglePwd2" style="position:absolute;right:16px;top:50%;transform:translateY(-50%);background:none;border:none;color:rgba(255,255,255,.3);cursor:pointer;font-size:.85rem">
            <i class="ri-eye-line"></i>
          </button>
        </div>
        <div class="form-err-dark" id="confirmErr">Passwords do not match.</div>
      </div>


      <button type="button" class="auth-submit-dark" id="resetPasswordBtn">
        <i class="ri-refresh-line mr-2"></i>Reset Password
      </button>
    </form>

    <div class="mt-6 text-center">
      <a href="{{ route('loginpage') }}" class="inline-flex items-center gap-2 text-sm text-white/40 hover:text-purple-400 transition">
        <i class="ri-arrow-left-line"></i> Back to Login
      </a>
    </div>
  </div>
</div>

<script src="{{ asset('assets/js/script.js') }}"></script>
<script>
  // Toggle password visibility
  document.getElementById('togglePwd1')?.addEventListener('click', function() {
    const inp = document.getElementById('newPwd');
    const isText = inp.type === 'text';
    inp.type = isText ? 'password' : 'text';
    this.innerHTML = isText ? '<i class="ri-eye-line"></i>' : '<i class="ri-eye-off-line"></i>';
  });

  document.getElementById('togglePwd2')?.addEventListener('click', function() {
    const inp = document.getElementById('confirmPwd');
    const isText = inp.type === 'text';
    inp.type = isText ? 'password' : 'text';
    this.innerHTML = isText ? '<i class="ri-eye-line"></i>' : '<i class="ri-eye-off-line"></i>';
  });

  // Password strength checker
  document.getElementById('newPwd')?.addEventListener('input', function() {
    const pwd = this.value;
    let strength = 0;
    const str1 = document.getElementById('str1');
    const str2 = document.getElementById('str2');
    const str3 = document.getElementById('str3');
    const str4 = document.getElementById('str4');
    const strText = document.getElementById('strText');

    [str1, str2, str3, str4].forEach(el => el.style.background = 'rgba(255,255,255,.1)');

    const hasLength = pwd.length >= 8;
    const hasUpper = /[A-Z]/.test(pwd);
    const hasNumber = /[0-9]/.test(pwd);
    const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(pwd);

    updateReq('req1', hasLength);
    updateReq('req2', hasUpper);
    updateReq('req3', hasNumber);
    updateReq('req4', hasSpecial);

    if (hasLength) strength++;
    if (hasUpper) strength++;
    if (hasNumber) strength++;
    if (hasSpecial) strength++;

    const colors = ['#ef4444', '#f59e0b', '#eab308', '#10b981'];
    const texts = ['Weak', 'Fair', 'Good', 'Strong'];

    if (pwd.length === 0) {
      strText.textContent = 'Enter password to check strength';
      strText.style.color = 'rgba(255,255,255,.3)';
    } else {
      if (strength >= 1) str1.style.background = colors[strength - 1];
      if (strength >= 2) str2.style.background = colors[strength - 1];
      if (strength >= 3) str3.style.background = colors[strength - 1];
      if (strength >= 4) str4.style.background = colors[strength - 1];

      strText.textContent = texts[strength - 1] || 'Very Weak';
      strText.style.color = colors[strength - 1] || '#ef4444';
    }
  });

  function updateReq(id, valid) {
    const el = document.getElementById(id);
    if (!el) return;

    if (valid) {
      el.innerHTML = el.innerHTML.replace('ri-close-circle-line text-red-400', 'ri-check-line text-emerald-400');
      el.style.color = 'rgba(16,185,129,.7)';
    } else {
      el.innerHTML = el.innerHTML.replace('ri-check-line text-emerald-400', 'ri-close-circle-line text-red-400');
      el.style.color = 'rgba(255,255,255,.3)';
    }
  }

  // Hide errors while typing
  document.getElementById('newPwd')?.addEventListener('input', function() {
    const pwdErr = document.getElementById('pwdErr');

    if (this.value.length >= 8) {
      pwdErr.classList.remove('show');
    }
  });

  document.getElementById('confirmPwd')?.addEventListener('input', function() {
    const confirmErr = document.getElementById('confirmErr');
    const newPwd = document.getElementById('newPwd').value;

    if (this.value === newPwd) {
      confirmErr.classList.remove('show');
    }
  });

  // ✅ UPDATED RESET PASSWORD (AJAX like your previous)
  document.getElementById('resetPasswordBtn')?.addEventListener('click', async function() {

    const btn = this;

    const newPwd = document.getElementById('newPwd').value;
    const confirmPwd = document.getElementById('confirmPwd').value;
    const email = document.querySelector('input[name="email"]').value;
    const token = document.querySelector('input[name="token"]').value;

    const pwdErr = document.getElementById('pwdErr');
    const confirmErr = document.getElementById('confirmErr');

    let isValid = true;

    pwdErr.classList.remove('show');
    confirmErr.classList.remove('show');

    if (newPwd.length < 8) {
      pwdErr.innerText = "Password must be at least 8 characters";
      pwdErr.classList.add('show');
      isValid = false;
    }

    if (newPwd !== confirmPwd) {
      confirmErr.innerText = "Passwords do not match";
      confirmErr.classList.add('show');
      isValid = false;
    }

    if (!isValid) return;

    btn.innerHTML = '<i class="ri-loader-4-line ri-spin mr-2"></i>Resetting...';
    btn.disabled = true;

    try {

      const res = await fetch("{{ route('user.reset-password') }}", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
          email: email,
          token: token,
          new_password: newPwd,
          new_password_confirmation: confirmPwd
        })
      });

      const data = await res.json();

      // ❌ Backend validation or error
      if (!data.status) {

        if (data.errors) {
          if (data.errors.new_password) {
            pwdErr.innerText = data.errors.new_password[0];
            pwdErr.classList.add('show');
          }

          if (data.errors.new_password_confirmation) {
            confirmErr.innerText = data.errors.new_password_confirmation[0];
            confirmErr.classList.add('show');
          }
        } else {
          const msg = encodeURIComponent(data.message || "Session expired. Please try again.");

          window.location.href = "{{ route('forgotpassword.page') }}?error=" + msg;
        }

        btn.innerHTML = '<i class="ri-refresh-line mr-2"></i>Reset Password';
        btn.disabled = false;
        return;
      }

      // ✅ SUCCESS (same flow as before)
      btn.innerHTML = '<i class="ri-check-line mr-2"></i>Password Reset!';
      btn.style.background = 'linear-gradient(135deg,#10b981,#059669)';

      setTimeout(() => {
        window.location.href = "{{ route('loginpage') }}";
      }, 1500);

    } catch (err) {
      console.log(err);
      btn.innerHTML = '<i class="ri-refresh-line mr-2"></i>Reset Password';
      btn.disabled = false;
    }
  });

  // Particle animation (unchanged)
  (function() {
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
        })
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
        ctx.fill()
      });
      requestAnimationFrame(anim)
    })();
  })();
</script>

@endsection