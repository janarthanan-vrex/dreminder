<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reset Password — DRemind Admin</title>
<script src="https://cdn.tailwindcss.com"></script>
<script>tailwind.config={theme:{extend:{colors:{primary:'#7c3aed',secondary:'#06b6d4',accent:'#10b981',dark:'#030014'},fontFamily:{sans:['Inter','system-ui','sans-serif']}}}}</script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{background:#030014;font-family:'Inter',sans-serif;color:#fff;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:40px 20px;overflow:hidden;position:relative}
.gradient-blob{position:absolute;border-radius:50%;filter:blur(120px);opacity:.12;pointer-events:none}
.glass-strong{background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);backdrop-filter:blur(40px)}
.auth-input{width:100%;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);border-radius:12px;padding:13px 42px 13px 42px;color:#fff;font-size:.875rem;font-family:'Inter',sans-serif;transition:all .3s;outline:none}
.auth-input:focus{border-color:rgba(124,58,237,.6);background:rgba(124,58,237,.06);box-shadow:0 0 0 3px rgba(124,58,237,.1)}
.auth-input::placeholder{color:rgba(255,255,255,.25)}
.auth-label{display:block;font-size:.75rem;font-weight:600;color:rgba(255,255,255,.5);margin-bottom:8px;letter-spacing:.04em;text-transform:uppercase}
.btn-primary{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:14px 28px;border-radius:12px;font-weight:700;font-size:.875rem;color:#fff;background:linear-gradient(135deg,#7c3aed,#6d28d9);border:none;cursor:pointer;transition:all .3s;width:100%}
.btn-primary:hover:not(:disabled){transform:translateY(-2px);box-shadow:0 8px 30px rgba(124,58,237,.4)}
.btn-primary:disabled{opacity:.6;cursor:not-allowed}
.icon-ring{width:72px;height:72px;border-radius:22px;background:linear-gradient(135deg,rgba(124,58,237,.25),rgba(16,185,129,.15));border:1px solid rgba(124,58,237,.3);display:flex;align-items:center;justify-content:center;font-size:1.8rem;margin:0 auto 20px;box-shadow:0 0 50px rgba(124,58,237,.15)}
.form-err{font-size:.72rem;color:#f87171;margin-top:5px;display:none}
.form-err.show{display:block}
.input-wrap{position:relative}
.input-icon{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:rgba(255,255,255,.3);font-size:.9rem;pointer-events:none}
.toggle-pwd{position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;color:rgba(255,255,255,.3);cursor:pointer;font-size:.85rem;transition:color .2s}
.toggle-pwd:hover{color:rgba(255,255,255,.7)}
.strength-bar{display:flex;gap:4px;margin-top:8px}
.seg{height:3px;flex:1;border-radius:50px;background:rgba(255,255,255,.08);transition:background .3s}
.req-item{display:flex;align-items:center;gap:6px;font-size:.72rem;color:rgba(255,255,255,.3);transition:color .3s}
.req-item.ok{color:#34d399}
.req-item i{font-size:.75rem}
canvas{position:absolute;inset:0;pointer-events:none;z-index:0}
</style>
</head>
<body>
<div class="gradient-blob" style="width:600px;height:600px;background:#7c3aed;top:-15%;left:-10%"></div>
<div class="gradient-blob" style="width:400px;height:400px;background:#10b981;bottom:-10%;right:-5%;animation-delay:3s"></div>
<canvas id="pC"></canvas>

<div style="width:100%;max-width:460px;position:relative;z-index:10">
  <div style="text-align:center;margin-bottom:28px">
    <a href="admin-login" style="display:inline-block;margin-bottom:16px">
      <img src="https://www.vishakarex.in/assets/img/projects/d-remind.png" style="height:34px;margin:auto" alt="DRemind">
    </a>
    <h1 style="font-size:1.5rem;font-weight:900;margin-bottom:6px">Reset Your Password</h1>
    <p style="font-size:.82rem;color:rgba(255,255,255,.35)">Create a new secure password for your admin account</p>
  </div>

  <!-- Steps indicator -->
  <div style="display:flex;align-items:center;justify-content:center;gap:8px;margin-bottom:24px">
    <div style="display:flex;align-items:center;gap:6px">
      <div style="width:8px;height:8px;border-radius:50%;background:#10b981;box-shadow:0 0 8px rgba(16,185,129,.6)"></div>
      <span style="font-size:.7rem;color:#34d399;font-weight:600">Email Sent</span>
    </div>
    <div style="width:24px;height:1px;background:rgba(16,185,129,.3)"></div>
    <div style="display:flex;align-items:center;gap:6px">
      <div style="width:8px;height:8px;border-radius:50%;background:#10b981;box-shadow:0 0 8px rgba(16,185,129,.6)"></div>
      <span style="font-size:.7rem;color:#34d399;font-weight:600">Link Verified</span>
    </div>
    <div style="width:24px;height:1px;background:rgba(255,255,255,.1)"></div>
    <div style="display:flex;align-items:center;gap:6px">
      <div style="width:8px;height:8px;border-radius:50%;background:#7c3aed;box-shadow:0 0 8px rgba(124,58,237,.6)"></div>
      <span style="font-size:.7rem;color:#a78bfa;font-weight:600">Reset Password</span>
    </div>
  </div>

  <div class="glass-strong" style="border-radius:24px;padding:32px" id="resetForm">
    <div style="display:flex;flex-direction:column;gap:20px">

      {{-- Hidden fields --}}
      <input type="hidden" id="resetToken" value="{{ $token }}">
      <input type="hidden" id="resetEmail" value="{{ $email }}">

      <div>
        <label class="auth-label">New Password</label>
        <div class="input-wrap">
          <i class="input-icon ri-lock-line"></i>
          <input type="password" id="newPwd" class="auth-input" placeholder="Create a strong password" required>
          <button type="button" class="toggle-pwd" id="toggleNew"><i class="ri-eye-line"></i></button>
        </div>
        <!-- Strength bar -->
        <div class="strength-bar" id="strengthBar">
          <div class="seg" id="s1"></div><div class="seg" id="s2"></div>
          <div class="seg" id="s3"></div><div class="seg" id="s4"></div><div class="seg" id="s5"></div>
        </div>
        <p id="strengthLabel" style="font-size:.68rem;color:rgba(255,255,255,.25);margin-top:4px">Password strength</p>
        <div class="form-err" id="newPwdErr"></div>
      </div>

      <div>
        <label class="auth-label">Confirm New Password</label>
        <div class="input-wrap">
          <i class="input-icon ri-lock-2-line"></i>
          <input type="password" id="confirmPwd" class="auth-input" placeholder="Re-enter new password" required>
          <button type="button" class="toggle-pwd" id="toggleConfirm"><i class="ri-eye-line"></i></button>
        </div>
        <div class="form-err" id="matchErr"></div>
      </div>

      <div class="form-err" id="tokenErr"></div>

      <button type="button" class="btn-primary" id="resetBtn">
        <i class="ri-shield-check-line"></i> Update Password
      </button>
    </div>
  </div>

  <!-- Success state -->
  <div class="glass-strong" style="border-radius:24px;padding:32px;display:none;text-align:center" id="successBlock">
    <div style="width:72px;height:72px;border-radius:22px;background:rgba(16,185,129,.15);border:1px solid rgba(16,185,129,.3);display:flex;align-items:center;justify-content:center;font-size:2rem;margin:0 auto 16px">
      <i class="ri-shield-check-fill" style="color:#34d399"></i>
    </div>
    <h3 style="font-size:1.2rem;font-weight:900;margin-bottom:8px">Password Updated!</h3>
    <p style="font-size:.82rem;color:rgba(255,255,255,.4);margin-bottom:24px">Your admin password has been successfully changed. You can now log in with your new credentials.</p>
    <a href="{{ route('admin.login') }}" style="display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:14px 28px;border-radius:12px;font-weight:700;font-size:.875rem;color:#fff;background:linear-gradient(135deg,#7c3aed,#6d28d9);text-decoration:none;transition:all .3s" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
      <i class="ri-login-box-line"></i> Go to Login
    </a>
  </div>

  <p style="text-align:center;font-size:.7rem;color:rgba(255,255,255,.15);margin-top:20px">© 2026 Winngoo DRemind — Admin Panel</p>
</div>

<script>
// ── Toggle password visibility ────────────────────────────────────────────────
['toggleNew', 'toggleConfirm'].forEach((id, i) => {
  document.getElementById(id)?.addEventListener('click', function () {
    const inp  = document.getElementById(i === 0 ? 'newPwd' : 'confirmPwd');
    const isText = inp.type === 'text';
    inp.type     = isText ? 'password' : 'text';
    this.innerHTML = isText ? '<i class="ri-eye-line"></i>' : '<i class="ri-eye-off-line"></i>';
  });
});

// ── Password strength ─────────────────────────────────────────────────────────
const colors = ['#ef4444', '#f97316', '#eab308', '#22c55e', '#10b981'];
const labels = ['Very weak', 'Weak', 'Fair', 'Strong', 'Very strong'];

document.getElementById('newPwd')?.addEventListener('input', function () {
  hideErr('newPwdErr');

  const v = this.value;
  let score = 0;

  // Score purely from value — no dependency on commented-out DOM elements
  if (v.length >= 8)          score++;
  if (/[A-Z]/.test(v))        score++;
  if (/[a-z]/.test(v))        score++;
  if (/[0-9]/.test(v))        score++;
  if (/[^A-Za-z0-9]/.test(v)) score++;

  // Update 5 bar segments
  for (let i = 1; i <= 5; i++) {
    const seg = document.getElementById('s' + i);
    if (seg) seg.style.background = i <= score ? colors[score - 1] : 'rgba(255,255,255,.08)';
  }

  // Update label
  const lbl = document.getElementById('strengthLabel');
  if (v.length === 0) {
    lbl.textContent = 'Password strength';
    lbl.style.color = 'rgba(255,255,255,.25)';
  } else {
    lbl.textContent = 'Strength: ' + labels[score - 1];
    lbl.style.color = colors[score - 1];
  }
});

// ── Hide confirm error on typing ──────────────────────────────────────────────
document.getElementById('confirmPwd')?.addEventListener('input', () => hideErr('matchErr'));

// ── Submit ────────────────────────────────────────────────────────────────────
document.getElementById('resetBtn')?.addEventListener('click', function () {
  const token   = document.getElementById('resetToken').value;
  const email   = document.getElementById('resetEmail').value;
  const pwd     = document.getElementById('newPwd').value;
  const confirm = document.getElementById('confirmPwd').value;
  let valid     = true;

  hideErr('newPwdErr');
  hideErr('matchErr');
  hideErr('tokenErr');

  // ── Client-side validation ────────────────────────────────────────────────
  if (pwd.length < 8) {
    showErr('newPwdErr', 'Password must be at least 8 characters.'); valid = false;
  } else if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/.test(pwd)) {
    showErr('newPwdErr', 'Must contain uppercase, lowercase, number and special character.'); valid = false;
  }
  if (pwd !== confirm) {
    showErr('matchErr', 'Passwords do not match.'); valid = false;
  }
  if (!valid) return;

  // ── Loading state ─────────────────────────────────────────────────────────
  const btn     = this;
  btn.innerHTML = '<i class="ri-loader-4-line" style="animation:spin .7s linear infinite"></i> Updating...';
  btn.disabled  = true;

  // ── POST to backend ───────────────────────────────────────────────────────
  fetch('{{ route("admin.reset-password") }}', {
    method:  'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept':       'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
    },
    body: JSON.stringify({
      token:                     token,
      email:                     email,
      new_password:              pwd,
      new_password_confirmation: confirm,
    }),
  })
  .then(res => res.json().then(data => ({ status: res.status, data })))
  .then(({ data }) => {
    if (data.status) {
      // ✅ Success
      document.getElementById('resetForm').style.display    = 'none';
      document.getElementById('successBlock').style.display = 'block';
      setTimeout(() => { window.location.href = '{{ route("admin.login") }}'; }, 2500);
    } else {
      // ❌ Field errors from backend
      btn.innerHTML = '<i class="ri-shield-check-line"></i> Update Password';
      btn.disabled  = false;

      if (data.errors) {
        if (data.errors.new_password)              showErr('newPwdErr', data.errors.new_password[0]);
        if (data.errors.new_password_confirmation) showErr('matchErr',  data.errors.new_password_confirmation[0]);
        if (data.errors.token)                     showErr('tokenErr',  data.errors.token[0]);
        if (data.errors.email)                     showErr('tokenErr',  data.errors.email[0]);
      }
      if (data.message) showErr('tokenErr', data.message);
    }
  })
  .catch(() => {
    btn.innerHTML = '<i class="ri-shield-check-line"></i> Update Password';
    btn.disabled  = false;
    showErr('tokenErr', 'Network error. Please try again.');
  });
});

// ── Helpers ───────────────────────────────────────────────────────────────────
function showErr(id, msg) {
  const el     = document.getElementById(id);
  el.innerHTML = '<i class="ri-error-warning-line"></i>&nbsp;' + msg;
  el.classList.add('show');
}
function hideErr(id) {
  document.getElementById(id).classList.remove('show');
}

// ── Particles ─────────────────────────────────────────────────────────────────
(function () {
  const c = document.getElementById('pC'); if (!c) return;
  const ctx = c.getContext('2d'); let pts = [];
  function rz() {
    c.width = innerWidth; c.height = innerHeight; pts = [];
    for (let i = 0; i < 40; i++) pts.push({
      x:  Math.random() * c.width,
      y:  Math.random() * c.height,
      vx: (Math.random() - .5) * .3,
      vy: (Math.random() - .5) * .3,
      s:  Math.random() * 1.5 + .5,
      a:  Math.random() * .15 + .03,
      h:  [265, 155][~~(Math.random() * 2)]
    });
  }
  rz(); window.addEventListener('resize', rz);
  (function draw() {
    ctx.clearRect(0, 0, c.width, c.height);
    pts.forEach(p => {
      p.x += p.vx; p.y += p.vy;
      if (p.x < 0) p.x = c.width;  if (p.x > c.width)  p.x = 0;
      if (p.y < 0) p.y = c.height; if (p.y > c.height) p.y = 0;
      ctx.beginPath(); ctx.arc(p.x, p.y, p.s, 0, Math.PI * 2);
      ctx.fillStyle = `hsla(${p.h},75%,65%,${p.a})`; ctx.fill();
    });
    requestAnimationFrame(draw);
  })();
})();
</script>
<style>@keyframes spin { to { transform: rotate(360deg) } }</style>
</body>
</html>