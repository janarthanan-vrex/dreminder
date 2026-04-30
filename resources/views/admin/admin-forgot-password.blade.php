<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Forgot Password — DRemind Admin</title>
<script src="https://cdn.tailwindcss.com"></script>
<script>tailwind.config={theme:{extend:{colors:{primary:'#7c3aed',secondary:'#06b6d4',accent:'#10b981',dark:'#030014'},fontFamily:{sans:['Inter','system-ui','sans-serif']}}}}</script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{background:#030014;font-family:'Inter',sans-serif;color:#fff;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:40px 20px;overflow:hidden;position:relative}
.gradient-blob{position:absolute;border-radius:50%;filter:blur(120px);opacity:.12;pointer-events:none}
.glass-strong{background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);backdrop-filter:blur(40px)}
.auth-input{width:100%;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);border-radius:12px;padding:13px 16px 13px 42px;color:#fff;font-size:.875rem;font-family:'Inter',sans-serif;transition:all .3s;outline:none}
.auth-input:focus{border-color:rgba(124,58,237,.6);background:rgba(124,58,237,.06);box-shadow:0 0 0 3px rgba(124,58,237,.1)}
.auth-input::placeholder{color:rgba(255,255,255,.25)}
.auth-label{display:block;font-size:.75rem;font-weight:600;color:rgba(255,255,255,.5);margin-bottom:8px;letter-spacing:.04em;text-transform:uppercase}
.btn-primary{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:14px 28px;border-radius:12px;font-weight:700;font-size:.875rem;color:#fff;background:linear-gradient(135deg,#7c3aed,#6d28d9);border:none;cursor:pointer;transition:all .3s;width:100%}
.btn-primary:hover:not(:disabled){transform:translateY(-2px);box-shadow:0 8px 30px rgba(124,58,237,.4)}
.btn-primary:disabled{opacity:.6;cursor:not-allowed}
.btn-ghost{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:12px 24px;border-radius:12px;font-weight:600;font-size:.875rem;color:rgba(255,255,255,.5);background:transparent;border:1px solid rgba(255,255,255,.1);cursor:pointer;transition:all .3s;width:100%;text-decoration:none}
.btn-ghost:hover{color:#fff;border-color:rgba(255,255,255,.2);background:rgba(255,255,255,.04)}
.icon-ring{width:72px;height:72px;border-radius:22px;background:linear-gradient(135deg,rgba(6,182,212,.2),rgba(124,58,237,.2));border:1px solid rgba(6,182,212,.3);display:flex;align-items:center;justify-content:center;font-size:1.8rem;margin:0 auto 20px;box-shadow:0 0 50px rgba(6,182,212,.15)}
.step-dot{width:8px;height:8px;border-radius:50%;display:inline-block}
.form-err{font-size:.72rem;color:#f87171;margin-top:5px;display:none}
.form-err.show{display:block}
.input-wrap{position:relative}
.input-icon{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:rgba(255,255,255,.3);font-size:.9rem;pointer-events:none}
canvas{position:absolute;inset:0;pointer-events:none;z-index:0}
</style>
</head>
<body>
<div class="gradient-blob" style="width:600px;height:600px;background:#06b6d4;top:-20%;right:-10%"></div>
<div class="gradient-blob" style="width:500px;height:500px;background:#7c3aed;bottom:-15%;left:-10%"></div>
<canvas id="pC"></canvas>

<div style="width:100%;max-width:460px;position:relative;z-index:10">
  <div style="text-align:center;margin-bottom:28px">
    <a href="admin-login" style="display:inline-block;margin-bottom:16px">
      <img src="https://www.vishakarex.in/assets/img/projects/d-remind.png" style="height:34px;margin:auto" alt="DRemind">
    </a>
    <h1 style="font-size:1.5rem;font-weight:900;margin-bottom:6px">Forgot Password?</h1>
    <p style="font-size:.82rem;color:rgba(255,255,255,.35);max-width:300px;margin:0 auto">Enter your admin email and we'll send a secure password reset link.</p>
  </div>

  <!-- Steps indicator -->
  <div style="display:flex;align-items:center;justify-content:center;gap:8px;margin-bottom:24px">
    <div style="display:flex;align-items:center;gap:6px">
      <div class="step-dot" style="background:#7c3aed;box-shadow:0 0 8px rgba(124,58,237,.6)"></div>
      <span style="font-size:.7rem;color:#a78bfa;font-weight:600">Enter Email</span>
    </div>
    <div style="width:24px;height:1px;background:rgba(255,255,255,.1)"></div>
    <div style="display:flex;align-items:center;gap:6px">
      <div class="step-dot" style="background:rgba(255,255,255,.15)"></div>
      <span style="font-size:.7rem;color:rgba(255,255,255,.3)">Check Inbox</span>
    </div>
    <div style="width:24px;height:1px;background:rgba(255,255,255,.1)"></div>
    <div style="display:flex;align-items:center;gap:6px">
      <div class="step-dot" style="background:rgba(255,255,255,.15)"></div>
      <span style="font-size:.7rem;color:rgba(255,255,255,.3)">Reset Password</span>
    </div>
  </div>

  <div class="glass-strong" style="border-radius:24px;padding:32px">
    <div id="formStep">
      <div style="margin-bottom:20px">
        <label class="auth-label">Admin Email Address</label>
        <div class="input-wrap">
          <i class="input-icon ri-mail-line"></i>
          <input type="email" id="resetEmail" class="auth-input" placeholder="admin@dremind.co.uk" required>
        </div>
        <div class="form-err" id="emailErr">Please enter a valid email address.</div>
      </div>
      <button type="button" class="btn-primary" id="sendBtn">
        <i class="ri-send-plane-line"></i> Send Reset Link
      </button>
    </div>

    <!-- Success state -->
    <div id="successStep" style="display:none;text-align:center">
      <div style="width:64px;height:64px;border-radius:20px;background:rgba(16,185,129,.15);border:1px solid rgba(16,185,129,.3);display:flex;align-items:center;justify-content:center;font-size:1.8rem;margin:0 auto 16px">
        <i class="ri-mail-check-line" style="color:#34d399"></i>
      </div>
      <h3 style="font-size:1.1rem;font-weight:800;margin-bottom:8px;color:#fff">Reset Email Sent!</h3>
      <p style="font-size:.8rem;color:rgba(255,255,255,.4);margin-bottom:4px">We've sent a password reset link to</p>
      <p id="sentTo" style="font-size:.85rem;color:#a78bfa;font-weight:600;margin-bottom:20px"></p>
      <p style="font-size:.75rem;color:rgba(255,255,255,.25);margin-bottom:24px">Check your spam folder if it doesn't arrive within 5 minutes.</p>
      <div style="display:flex;flex-direction:column;gap:10px">
        <button onclick="resend()" style="font-size:.78rem;color:#a78bfa;background:none;border:none;cursor:pointer;text-decoration:underline">Resend email</button>
        <a href="admin-login" class="btn-ghost"><i class="ri-arrow-left-line"></i> Back to Login</a>
      </div>
    </div>

    <div style="margin-top:24px;padding-top:20px;border-top:1px solid rgba(255,255,255,.07);text-align:center">
      <a href="admin-login" style="font-size:.78rem;color:rgba(255,255,255,.35);text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:color .2s" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,.35)'">
        <i class="ri-arrow-left-line"></i> Back to Admin Login
      </a>
    </div>
  </div>

  <p style="text-align:center;font-size:.7rem;color:rgba(255,255,255,.15);margin-top:20px">
    © 2026 Winngoo DRemind — Admin Panel
  </p>
</div>

<script>
let sentEmail='';
document.getElementById('sendBtn')?.addEventListener('click',function(){
  const email=document.getElementById('resetEmail').value.trim();
  document.getElementById('emailErr').classList.remove('show');
  if(!email||!email.includes('@')||!email.includes('.')){document.getElementById('emailErr').classList.add('show');return}
  sentEmail=email;
  this.innerHTML='<i class="ri-loader-4-line" style="animation:spin .7s linear infinite"></i> Sending...';
  this.disabled=true;
  setTimeout(()=>{
    document.getElementById('formStep').style.display='none';
    document.getElementById('sentTo').textContent=email;
    document.getElementById('successStep').style.display='block';
  },1800);
});
function resend(){
  const btn=document.createElement('button');
  document.getElementById('sentTo').textContent=sentEmail+' (resent)';
}
// Particles
(function(){const c=document.getElementById('pC');if(!c)return;const ctx=c.getContext('2d');let pts=[];
function rz(){c.width=innerWidth;c.height=innerHeight;pts=[];for(let i=0;i<40;i++)pts.push({x:Math.random()*c.width,y:Math.random()*c.height,vx:(Math.random()-.5)*.3,vy:(Math.random()-.5)*.3,s:Math.random()*1.5+.5,a:Math.random()*.15+.03,h:190})}
rz();window.addEventListener('resize',rz);
(function draw(){ctx.clearRect(0,0,c.width,c.height);pts.forEach(p=>{p.x+=p.vx;p.y+=p.vy;if(p.x<0)p.x=c.width;if(p.x>c.width)p.x=0;if(p.y<0)p.y=c.height;if(p.y>c.height)p.y=0;ctx.beginPath();ctx.arc(p.x,p.y,p.s,0,Math.PI*2);ctx.fillStyle=`hsla(${p.h},75%,65%,${p.a})`;ctx.fill()});requestAnimationFrame(draw)})()})();
</script>
<style>@keyframes spin{to{transform:rotate(360deg)}}</style>
</body>
</html>