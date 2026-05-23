<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login — DRemind Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
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
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0
    }

    body {
      background: #030014;
      font-family: 'Inter', sans-serif;
      color: #fff;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 20px;
      overflow: hidden;
      position: relative
    }

    .gradient-blob {
      position: absolute;
      border-radius: 50%;
      filter: blur(120px);
      opacity: .12;
      pointer-events: none
    }

    .glass-strong {
      background: rgba(255, 255, 255, .06);
      border: 1px solid rgba(255, 255, 255, .12);
      backdrop-filter: blur(40px)
    }

    .auth-input {
      width: 100%;
      background: rgba(255, 255, 255, .05);
      border: 1px solid rgba(255, 255, 255, .1);
      border-radius: 12px;
      padding: 13px 16px 13px 42px;
      color: #fff;
      font-size: .875rem;
      font-family: 'Inter', sans-serif;
      transition: all .3s;
      outline: none
    }

    .auth-input:focus {
      border-color: rgba(124, 58, 237, .6);
      background: rgba(124, 58, 237, .06);
      box-shadow: 0 0 0 3px rgba(124, 58, 237, .1)
    }

    .auth-input::placeholder {
      color: rgba(255, 255, 255, .25)
    }

    .auth-input.has-right {
      padding-right: 42px
    }

    .auth-label {
      display: block;
      font-size: .75rem;
      font-weight: 600;
      color: rgba(255, 255, 255, .5);
      margin-bottom: 8px;
      letter-spacing: .04em;
      text-transform: uppercase
    }

    .btn-primary {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 14px 28px;
      border-radius: 12px;
      font-weight: 700;
      font-size: .875rem;
      color: #fff;
      background: linear-gradient(135deg, #7c3aed, #6d28d9);
      border: none;
      cursor: pointer;
      transition: all .3s;
      width: 100%
    }

    .btn-primary:hover:not(:disabled) {
      transform: translateY(-2px);
      box-shadow: 0 8px 30px rgba(124, 58, 237, .4)
    }

    .btn-primary:active:not(:disabled) {
      transform: translateY(0)
    }

    .btn-primary:disabled {
      opacity: .6;
      cursor: not-allowed
    }

    .btn-ghost {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 12px 24px;
      border-radius: 12px;
      font-weight: 600;
      font-size: .875rem;
      color: rgba(255, 255, 255, .5);
      background: transparent;
      border: 1px solid rgba(255, 255, 255, .1);
      cursor: pointer;
      transition: all .3s;
      width: 100%;
      text-decoration: none
    }

    .btn-ghost:hover {
      color: #fff;
      border-color: rgba(255, 255, 255, .2);
      background: rgba(255, 255, 255, .04)
    }

    .input-wrap {
      position: relative
    }

    .input-icon {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: rgba(255, 255, 255, .3);
      font-size: .9rem;
      pointer-events: none
    }

    .input-icon-right {
      position: absolute;
      right: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: rgba(255, 255, 255, .25);
      font-size: .9rem;
      cursor: pointer;
      transition: color .2s;
      background: none;
      border: none;
      padding: 0;
      line-height: 1
    }

    .input-icon-right:hover {
      color: rgba(255, 255, 255, .7)
    }

    .form-err {
      font-size: .72rem;
      color: #f87171;
      margin-top: 5px;
      display: none;
      align-items: center;
      gap: 4px
    }

    .form-err.show {
      display: flex
    }

    .step-dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      display: inline-block
    }

    .divider {
      display: flex;
      align-items: center;
      gap: 12px;
      margin: 20px 0
    }

    .divider span {
      font-size: .72rem;
      color: rgba(255, 255, 255, .25);
      white-space: nowrap;
      font-weight: 500;
      letter-spacing: .04em;
      text-transform: uppercase
    }

    .divider::before,
    .divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: rgba(255, 255, 255, .08)
    }

    .remember-wrap {
      display: flex;
      align-items: center;
      gap: 8px;
      cursor: pointer
    }

    .remember-wrap input[type=checkbox] {
      width: 16px;
      height: 16px;
      border-radius: 4px;
      accent-color: #7c3aed;
      cursor: pointer;
      flex-shrink: 0
    }

    .remember-wrap span {
      font-size: .8rem;
      color: rgba(255, 255, 255, .45);
      user-select: none
    }

    .security-badge {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      padding: 4px 10px;
      border-radius: 20px;
      background: rgba(16, 185, 129, .1);
      border: 1px solid rgba(16, 185, 129, .2);
      font-size: .67rem;
      font-weight: 600;
      color: #34d399;
      letter-spacing: .03em
    }

    .login-alert {
      margin-top: 14px;
      padding: 10px 14px;
      border-radius: 10px;
      background: rgba(244, 63, 94, .1);
      border: 1px solid rgba(244, 63, 94, .25);
      font-size: .78rem;
      color: #fda4af;
      display: none;
      align-items: center;
      gap: 8px
    }

    .login-alert.show {
      display: flex
    }

    .shake {
      animation: shake .4s ease
    }

    @keyframes shake {

      0%,
      100% {
        transform: translateX(0)
      }

      20%,
      60% {
        transform: translateX(-5px)
      }

      40%,
      80% {
        transform: translateX(5px)
      }
    }

    @keyframes spin {
      to {
        transform: rotate(360deg)
      }
    }

    @keyframes fadeUp {
      from {
        opacity: 0;
        transform: translateY(16px)
      }

      to {
        opacity: 1;
        transform: translateY(0)
      }
    }

    .fade-up {
      animation: fadeUp .5s ease both
    }

    canvas {
      position: absolute;
      inset: 0;
      pointer-events: none;
      z-index: 0
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
</head>

<body>

  <div class="gradient-blob" style="width:600px;height:600px;background:#06b6d4;top:-20%;right:-10%"></div>
  <div class="gradient-blob" style="width:500px;height:500px;background:#7c3aed;bottom:-15%;left:-10%"></div>
  <div class="gradient-blob" style="width:300px;height:300px;background:#7c3aed;top:60%;right:5%;opacity:.07"></div>
  <canvas id="pC"></canvas>

  <div style="width:100%;max-width:460px;position:relative;z-index:10;" class="fade-up">

    <!-- Logo + heading -->
    <div style="text-align:center;margin-bottom:28px">
      <div style="margin-bottom:16px">
        <img src="https://www.vishakarex.in/assets/img/projects/d-remind.png" style="height:54px;margin:auto" alt="DRemind" onerror="this.style.display='none'">
      </div>
      <h1 style="font-size:1.5rem;font-weight:900;margin-bottom:6px">Welcome Back</h1>
      <p style="font-size:.82rem;color:rgba(255,255,255,.35);max-width:300px;margin:0 auto">Sign in to your admin panel to manage.</p>
    </div>


    <!-- Glass card -->
    <div class="glass-strong" style="border-radius:24px;padding:32px" id="loginCard">

  <!-- Name field -->
  <div style="margin-bottom:18px">
    <label class="auth-label" for="loginName">Admin Username</label>
    <div class="input-wrap">
      <i class="input-icon ri-user-line"></i>
      <input type="text" autocomplete="off" id="loginName" name="name" class="auth-input" placeholder="Enter Username">
    </div>
    <div class="form-err" id="nameErr"></div>
  </div>

  <!-- Password field -->
  <div style="margin-bottom:20px">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px">
      <label class="auth-label" for="loginPassword" style="margin-bottom:0">Password</label>
      <a href="{{ route('admin.forgotPage') }}" style="font-size:.73rem;color:#a78bfa;text-decoration:none;font-weight:500;transition:color .2s" onmouseover="this.style.color='#c4b5fd'" onmouseout="this.style.color='#a78bfa'">Forgot password?</a>
    </div>
    <div class="input-wrap">
      <i class="input-icon ri-lock-2-line"></i>
      <input type="password" id="loginPassword" class="auth-input has-right" placeholder="Enter your password" autocomplete="current-password">
      <button type="button" class="input-icon-right" onclick="togglePassword()" title="Show / hide password">
        <i class="ri-eye-off-line" id="eyeIcon"></i>
      </button>
    </div>
    <div class="form-err" id="pwdErr"></div>
  </div>

  <!-- Remember me -->
  <div style="margin-bottom:22px">
    <label class="remember-wrap">
      <input type="checkbox" id="rememberMe">
      <span>Remember me for 30 days</span>
    </label>
  </div>

  <!-- Sign in button -->
  <button type="button" class="btn-primary" id="loginBtn" onclick="attemptLogin()">
    <i class="ri-login-box-line"></i> Sign In to Admin Panel
  </button>

</div>

    <p style="text-align:center;font-size:.7rem;color:rgba(255, 255, 255, 0.49);margin-top:20px">
      &copy; 2026 Winngoo DRemind &mdash; Admin Panel
    </p>
  </div>

  <!-- Toast container -->
  <div id="toastWrap" style="position:fixed;bottom:28px;left:50%;transform:translateX(-50%);z-index:1000;display:flex;flex-direction:column;align-items:center;gap:8px;pointer-events:none"></div>

 <script>
// ── Toggle password ───────────────────────────────────────────────────────────
function togglePassword() {
  const inp = document.getElementById('loginPassword');
  const ico = document.getElementById('eyeIcon');
  if (inp.type === 'password') { inp.type = 'text';     ico.className = 'ri-eye-line';     }
  else                         { inp.type = 'password'; ico.className = 'ri-eye-off-line'; }
}

// ── Toast ─────────────────────────────────────────────────────────────────────
function toast(msg, type) {
  type = type || 'info';
  const bg = { success:'rgba(16,185,129,.15)', info:'rgba(6,182,212,.15)', error:'rgba(244,63,94,.15)' };
  const bd = { success:'rgba(16,185,129,.3)',  info:'rgba(6,182,212,.3)',  error:'rgba(244,63,94,.3)'  };
  const ic = { success:'ri-check-circle-line', info:'ri-information-line', error:'ri-close-circle-line' };
  const tc = { success:'#34d399', info:'#22d3ee', error:'#f87171' };
  const t  = document.createElement('div');
  t.style.cssText = 'background:'+bg[type]+';border:1px solid '+bd[type]+';backdrop-filter:blur(20px);border-radius:12px;padding:10px 18px;display:flex;align-items:center;gap:8px;font-size:.8rem;color:#fff;white-space:nowrap;transition:all .3s;opacity:0;transform:translateY(8px)';
  t.innerHTML     = '<i class="'+ic[type]+'" style="color:'+tc[type]+';font-size:.95rem"></i>'+msg;
  document.getElementById('toastWrap').appendChild(t);
  requestAnimationFrame(() => { t.style.opacity='1'; t.style.transform='translateY(0)'; });
  setTimeout(() => {
    t.style.opacity='0'; t.style.transform='translateY(8px)';
    setTimeout(() => t.remove(), 300);
  }, 3000);
}

// ── Hide errors on typing ─────────────────────────────────────────────────────
document.getElementById('loginName').addEventListener('input',     () => hideFieldError('nameErr'));
document.getElementById('loginPassword').addEventListener('input', () => hideFieldError('pwdErr'));

// ── Login ─────────────────────────────────────────────────────────────────────
function attemptLogin() {
  const name = document.getElementById('loginName').value.trim();
  const pwd  = document.getElementById('loginPassword').value;
  let valid  = true;

  hideFieldError('nameErr');
  hideFieldError('pwdErr');

  // Client-side checks
  if (!name) {
    showFieldError('nameErr', 'Username is required.'); valid = false;
  }
  if (pwd.length < 8) {
    showFieldError('pwdErr', 'Password must be at least 8 characters.'); valid = false;
  }
  if (!valid) { shake(); return; }

  const btn     = document.getElementById('loginBtn');
  btn.innerHTML = '<i class="ri-loader-4-line" style="animation:spin .7s linear infinite"></i> Signing in&hellip;';
  btn.disabled  = true;

  fetch('{{ route("admin.login") }}', {
    method:  'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept':       'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
    },
    body: JSON.stringify({
      name:        name,
      password:    pwd,
      remember_me: document.getElementById('rememberMe').checked,
    }),
  })
  .then(res => res.json().then(data => ({ status: res.status, data })))
  .then(({ data }) => {
    if (data.success) {
      btn.innerHTML        = '<i class="ri-check-line"></i> Signed In!';
      btn.style.background = 'linear-gradient(135deg,#059669,#10b981)';
      toast('Welcome back, Admin! Redirecting…', 'success');
      setTimeout(() => { window.location.href = data.redirect; }, 1500);
    } else {
      btn.innerHTML        = '<i class="ri-login-box-line"></i> Sign In to Admin Panel';
      btn.style.background = '';
      btn.disabled         = false;
      if (data.errors) {
        if (data.errors.name)     showFieldError('nameErr', data.errors.name[0]);
        if (data.errors.password) showFieldError('pwdErr',  data.errors.password[0]);
      }
      shake();
    }
  })
  .catch(() => {
    btn.innerHTML        = '<i class="ri-login-box-line"></i> Sign In to Admin Panel';
    btn.style.background = '';
    btn.disabled         = false;
    toast('Network error. Please try again.', 'error');
  });
}

document.addEventListener('keydown', e => { if (e.key === 'Enter') attemptLogin(); });

// ── Helpers ───────────────────────────────────────────────────────────────────
function showFieldError(id, msg) {
  const el     = document.getElementById(id);
  el.innerHTML = '<i class="ri-error-warning-line"></i>&nbsp;' + msg;
  el.classList.add('show');
}
function hideFieldError(id) {
  document.getElementById(id).classList.remove('show');
}
function shake() {
  const card = document.getElementById('loginCard');
  card.classList.add('shake');
  setTimeout(() => card.classList.remove('shake'), 400);
}

// ── Particles ─────────────────────────────────────────────────────────────────
(function () {
  var c = document.getElementById('pC'); if (!c) return;
  var ctx = c.getContext('2d'), pts = [];
  function rz() {
    c.width = innerWidth; c.height = innerHeight; pts = [];
    for (var i = 0; i < 40; i++) pts.push({ x:Math.random()*c.width, y:Math.random()*c.height, vx:(Math.random()-.5)*.3, vy:(Math.random()-.5)*.3, s:Math.random()*1.5+.5, a:Math.random()*.15+.03, h:190 });
  }
  rz(); window.addEventListener('resize', rz);
  (function draw() {
    ctx.clearRect(0, 0, c.width, c.height);
    pts.forEach(p => {
      p.x += p.vx; p.y += p.vy;
      if (p.x < 0) p.x = c.width;  if (p.x > c.width)  p.x = 0;
      if (p.y < 0) p.y = c.height; if (p.y > c.height) p.y = 0;
      ctx.beginPath(); ctx.arc(p.x, p.y, p.s, 0, Math.PI*2);
      ctx.fillStyle = 'hsla('+p.h+',75%,65%,'+p.a+')'; ctx.fill();
    });
    requestAnimationFrame(draw);
  })();
})();
</script>
</body>

</html>