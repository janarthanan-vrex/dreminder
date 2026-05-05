@extends('layouts.app')
@section('content')
<style>
  .o2 {
    display: none !important;
  }

  input:-webkit-autofill,
  input:-webkit-autofill:hover,
  input:-webkit-autofill:focus,
  input:-webkit-autofill:active {
    -webkit-box-shadow: 0 0 0 1000px #0f172a inset !important;
    /* your bg color */
    box-shadow: 0 0 0 1000px #0f172a inset !important;
    -webkit-text-fill-color: #e5e7eb !important;
    /* your text color */
    transition: background-color 5000s ease-in-out 0s;
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
      <!-- <a href="index"><img src="https://www.vishakarex.in/assets/img/projects/d-remind.png" class="h-10 mx-auto mb-5" alt="DRemind"></a> -->
      <h1 class="text-2xl font-black tracking-tight text-white mb-1">Welcome back</h1>
      <p class="text-sm text-white/35">Log in to your DRemind account</p>
    </div>

    <!-- <div class="flex flex-col gap-3 mb-2">
      <a href="#" class="social-btn-dark"><svg width="18" height="18" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg> Continue with Google</a>
    </div> -->
    <div class="auth-divider-dark"><span>Sign in with email</span></div>

    <form class="flex flex-col gap-4" onsubmit="return false;">
      <div>
        <label class="auth-label">Email Address</label>
        <div class="auth-input-icon"><i class="ri-mail-line auth-icon"></i><input type="email" id="loginEmail" placeholder="Enter Your Email" class="auth-input" autocomplete="email" required></div>
        <div class="form-err-dark" id="emailErr">Please enter a valid email address.</div>
      </div>
      <div>
        <div class="flex items-center justify-between mb-2">
          <label class="auth-label" style="margin-bottom:0">Password</label>
          <a href="{{ route('forgotpassword.page') }}" class="text-xs text-purple-400 hover:text-purple-300 transition">Forgot password?</a>
        </div>
        <div class="auth-input-icon" style="position:relative">
          <i class="ri-lock-line auth-icon"></i>
          <input type="password" id="loginPwd" placeholder="••••••••" class="auth-input" autocomplete="current-password" required>
          <button type="button" id="togglePwd" style="position:absolute;right:16px;top:50%;transform:translateY(-50%);background:none;border:none;color:rgba(255,255,255,.3);cursor:pointer;font-size:.85rem"><i class="ri-eye-line"></i></button>
        </div>
        <div class="form-err-dark" id="pwdErr">Password must be at least 6 characters.</div>
      </div>
      <div class="flex items-center gap-3">
        <input type="checkbox" id="rememberMe" style="accent-color:#7c3aed">
        <label for="rememberMe" class="text-sm text-white/40">Keep me signed in</label>
      </div>
      <button type="button" class="auth-submit-dark" id="loginBtn"><i class="ri-login-box-line mr-2"></i>Sign In</button>
    </form>

    <p class="text-center text-sm text-white/35 mt-6">Don't have an account? <a href="{{route('registerpage')}}" class="text-purple-400 font-bold hover:text-purple-300 transition">Sign up </a></p>

    <div id="forgotPanel" class="hidden mt-5 p-4 rounded-2xl" style="background:rgba(124,58,237,.08);border:1px solid rgba(124,58,237,.2)">
      <h4 class="font-bold text-sm text-white mb-2"><i class="ri-lock-unlock-line mr-2 text-purple-400"></i>Reset Password</h4>
      <p class="text-xs text-white/35 mb-3">Enter your email and we'll send a reset link.</p>
      <div class="flex gap-2">
        <input type="email" placeholder="your@email.com" class="auth-input text-sm !py-2.5" id="resetEmail" style="padding-top:10px;padding-bottom:10px">
        <button class="btn-primary !py-2.5 !px-4 text-xs shrink-0" id="sendResetBtn">Send</button>
      </div>
      <div class="hidden text-xs font-semibold mt-2 text-emerald-400" id="resetOk"><i class="ri-check-line mr-1"></i>Reset email sent! Check your inbox.</div>
    </div>
  </div>
</div>


<script src="{{ asset('assets/js/script.js') }}"></script>

@include('user.layouts.firebase_setup')


<script>
  document.getElementById('togglePwd')?.addEventListener('click', function() {
    const inp = document.getElementById('loginPwd');
    const isT = inp.type === 'text';
    inp.type = isT ? 'password' : 'text';
    this.innerHTML = isT ? '<i class="ri-eye-line"></i>' : '<i class="ri-eye-off-line"></i>';
  });

  document.getElementById('forgotLink')?.addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('forgotPanel').classList.toggle('hidden')
  });

  document.getElementById('sendResetBtn')?.addEventListener('click', function() {
    const em = document.getElementById('resetEmail').value;
    if (!em || !em.includes('@')) return;
    this.innerHTML = '<i class="ri-loader-4-line ri-spin"></i>';
    setTimeout(() => {
      document.getElementById('resetOk').classList.remove('hidden');
      this.style.display = 'none'
    }, 1500);
  });


  // ✅ UPDATED LOGIN FUNCTION
  document.getElementById('loginBtn')?.addEventListener('click', async function() {

    const email = document.getElementById('loginEmail').value;
    const pwd = document.getElementById('loginPwd').value;
    const remember = document.getElementById('rememberMe').checked;

    let ok = true;

    document.getElementById('emailErr').classList.remove('show');
    document.getElementById('pwdErr').classList.remove('show');

    if (!email || !email.includes('@')) {
      document.getElementById('emailErr').classList.add('show');
      ok = false;
    }

    if (!pwd || pwd.length < 6) {
      document.getElementById('pwdErr').classList.add('show');
      ok = false;
    }

    if (!ok) return;

    this.innerHTML = '<i class="ri-loader-4-line ri-spin mr-2"></i>Signing in...';
    this.disabled = true;

    try {

    const permission = await Notification.requestPermission();

if (permission !== "granted") {
  console.log("Permission not granted");
  return;
}

      const token = await messaging.getToken({
        vapidKey: "BIkREF621bG6cSbBAo2Xn4VO6APwEyJ-mvnMDVm_5jsG8XLGFNpz2mLCDiP3FX8zmWfvUewvBO2Rvw8Iq0U_tkg"
      });

      let res = await fetch('/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
          email: email,
          password: pwd,
          remember: remember,
          fcm_token: token
        })
      });

      let data = await res.json();

      // 🔴 BACKEND ERROR HANDLING
      if (!data.status) {

        if (data.message === "User not found") {
          document.getElementById('emailErr').innerText = data.message;
          document.getElementById('emailErr').classList.add('show');
        } else if (data.message === "Password is incorrect") {
          document.getElementById('pwdErr').innerText = data.message;
          document.getElementById('pwdErr').classList.add('show');
        } else if (data.message === "User is inactive") {
          document.getElementById('emailErr').innerText = data.message;
          document.getElementById('emailErr').classList.add('show');
        }

        this.innerHTML = '<i class="ri-login-box-line mr-2"></i>Sign In';
        this.disabled = false;
        return;
      }

      // ✅ SUCCESS UI (UNCHANGED STYLE)
      this.innerHTML = '<i class="ri-check-line mr-2"></i>Signed In!';
      this.style.background = 'linear-gradient(135deg,#10b981,#059669)';



      setTimeout(() => {
        window.location.href = 'user-dashboard';
      }, 800);

    } catch (err) {
      console.log(err);
      this.innerHTML = '<i class="ri-login-box-line mr-2"></i>Sign In';
      this.disabled = false;
    }

  });


  // ✅ PARTICLE BACKGROUND (UNCHANGED)
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
        ctx.fill();
      });
      requestAnimationFrame(anim)
    })();
  })();
</script>

<script>
document.getElementById('loginEmail')?.addEventListener('input', function () {
  document.getElementById('emailErr')?.classList.remove('show');
});

document.getElementById('loginPwd')?.addEventListener('input', function () {
  document.getElementById('pwdErr')?.classList.remove('show');
});
</script>



@endsection