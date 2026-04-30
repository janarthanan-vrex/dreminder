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
      </div>
      <!-- Requirements -->
      <!-- <div style="background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.07);border-radius:12px;padding:14px;display:flex;flex-direction:column;gap:7px">
        <p style="font-size:.7rem;font-weight:600;color:rgba(255,255,255,.4);margin-bottom:4px;text-transform:uppercase;letter-spacing:.05em">Requirements</p>
        <div class="req-item" id="r1"><i class="ri-checkbox-blank-circle-line"></i> Minimum 8 characters</div>
        <div class="req-item" id="r2"><i class="ri-checkbox-blank-circle-line"></i> At least one uppercase letter</div>
        <div class="req-item" id="r3"><i class="ri-checkbox-blank-circle-line"></i> At least one lowercase letter</div>
        <div class="req-item" id="r4"><i class="ri-checkbox-blank-circle-line"></i> At least one number</div>
        <div class="req-item" id="r5"><i class="ri-checkbox-blank-circle-line"></i> At least one special character</div>
      </div> -->
      <div>
        <label class="auth-label">Confirm New Password</label>
        <div class="input-wrap">
          <i class="input-icon ri-lock-2-line"></i>
          <input type="password" id="confirmPwd" class="auth-input" placeholder="Re-enter new password" required>
          <button type="button" class="toggle-pwd" id="toggleConfirm"><i class="ri-eye-line"></i></button>
        </div>
        <div class="form-err" id="matchErr">Passwords do not match.</div>
      </div>
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
    <a href="admin-login" style="display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:14px 28px;border-radius:12px;font-weight:700;font-size:.875rem;color:#fff;background:linear-gradient(135deg,#7c3aed,#6d28d9);text-decoration:none;transition:all .3s" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
      <i class="ri-login-box-line"></i> Go to Login
    </a>
  </div>

  <p style="text-align:center;font-size:.7rem;color:rgba(255,255,255,.15);margin-top:20px">© 2026 Winngoo DRemind — Admin Panel</p>
</div>

<script>
// Toggle passwords
['toggleNew','toggleConfirm'].forEach((id,i)=>{
  document.getElementById(id)?.addEventListener('click',function(){
    const inp=document.getElementById(i===0?'newPwd':'confirmPwd');const t=inp.type==='text';
    inp.type=t?'password':'text';this.innerHTML=t?'<i class="ri-eye-line"></i>':'<i class="ri-eye-off-line"></i>';
  });
});
// Strength checker
const colors=['#ef4444','#f97316','#eab308','#22c55e','#10b981'];
const labels=['Very weak','Weak','Fair','Strong','Very strong'];
document.getElementById('newPwd')?.addEventListener('input',function(){
  const v=this.value;
  let score=0;
  const checks={r1:v.length>=8,r2:/[A-Z]/.test(v),r3:/[a-z]/.test(v),r4:/[0-9]/.test(v),r5:/[^A-Za-z0-9]/.test(v)};
  Object.entries(checks).forEach(([id,ok])=>{
    const el=document.getElementById(id);if(!el)return;
    el.classList.toggle('ok',ok);
    el.innerHTML=`<i class="${ok?'ri-checkbox-circle-line':'ri-checkbox-blank-circle-line'}"></i> ${el.textContent.trim().split(' ').slice(1).join(' ')}`;
    if(ok)score++;
  });
  for(let i=1;i<=5;i++){const s=document.getElementById('s'+i);if(s)s.style.background=i<=score?colors[score-1]:'rgba(255,255,255,.08)'}
  document.getElementById('strengthLabel').textContent='Strength: '+(labels[score-1]||'Very weak');
  document.getElementById('strengthLabel').style.color=score>0?colors[score-1]:'rgba(255,255,255,.25)';
});
document.getElementById('resetBtn')?.addEventListener('click',function(){
  const p=document.getElementById('newPwd').value,c=document.getElementById('confirmPwd').value;
  document.getElementById('matchErr').classList.remove('show');
  if(p!==c){document.getElementById('matchErr').classList.add('show');return}
  if(p.length<8)return;
  this.innerHTML='<i class="ri-loader-4-line" style="animation:spin .7s linear infinite"></i> Updating...';
  this.disabled=true;
  setTimeout(()=>{document.getElementById('resetForm').style.display='none';document.getElementById('successBlock').style.display='block'},1600);
});
(function(){const c=document.getElementById('pC');if(!c)return;const ctx=c.getContext('2d');let pts=[];
function rz(){c.width=innerWidth;c.height=innerHeight;pts=[];for(let i=0;i<40;i++)pts.push({x:Math.random()*c.width,y:Math.random()*c.height,vx:(Math.random()-.5)*.3,vy:(Math.random()-.5)*.3,s:Math.random()*1.5+.5,a:Math.random()*.15+.03,h:[265,155][~~(Math.random()*2)]})}
rz();window.addEventListener('resize',rz);
(function draw(){ctx.clearRect(0,0,c.width,c.height);pts.forEach(p=>{p.x+=p.vx;p.y+=p.vy;if(p.x<0)p.x=c.width;if(p.x>c.width)p.x=0;if(p.y<0)p.y=c.height;if(p.y>c.height)p.y=0;ctx.beginPath();ctx.arc(p.x,p.y,p.s,0,Math.PI*2);ctx.fillStyle=`hsla(${p.h},75%,65%,${p.a})`;ctx.fill()});requestAnimationFrame(draw)})()})();
</script>
<style>@keyframes spin{to{transform:rotate(360deg)}}</style>
</body>
</html>