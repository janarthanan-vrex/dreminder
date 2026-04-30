@extends('layouts.app')
@section('content')
<style>
    .o2{display: none !important;}
</style>

<script>tailwind.config={theme:{extend:{colors:{primary:'#7c3aed',secondary:'#06b6d4',accent:'#10b981',dark:'#030014'},fontFamily:{sans:['Inter','system-ui','sans-serif']}}}}</script>

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
          <p class="text-xs text-white/35">Check your inbox for password reset instructions. Didn't receive it? <button id="resendBtn" class="text-emerald-400 font-semibold hover:text-emerald-300">Resend</button></p>
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
document.getElementById('resetBtn')?.addEventListener('click', function() {
  const email = document.getElementById('forgotEmail').value;
  const emailErr = document.getElementById('emailErr');
  
  emailErr.classList.remove('show');
  
  if(!email || !email.includes('@')) {
    emailErr.classList.add('show');
    return;
  }
  
  this.innerHTML = '<i class="ri-loader-4-line ri-spin mr-2"></i>Sending...';
  this.disabled = true;
  
  // Simulate API call
  setTimeout(() => {
    this.classList.add('hidden');
    document.getElementById('successMsg').classList.remove('hidden');
  }, 1500);
});

document.getElementById('resendBtn')?.addEventListener('click', function() {
  this.innerHTML = '<i class="ri-loader-4-line ri-spin"></i>';
  setTimeout(() => {
    this.innerHTML = 'Sent!';
    setTimeout(() => {
      this.innerHTML = 'Resend';
    }, 2000);
  }, 1000);
});

// Particle background animation
(function(){
  const c=document.getElementById('authParticleC');if(!c)return;
  const ctx=c.getContext('2d');let pts=[];
  function rz(){c.width=innerWidth;c.height=innerHeight;pts=[];for(let i=0;i<60;i++){pts.push({x:Math.random()*c.width,y:Math.random()*c.height,vx:(Math.random()-.5)*.4,vy:(Math.random()-.5)*.4,s:Math.random()*2+1,a:Math.random()*.3+.05,h:[265,190,155][~~(Math.random()*3)]})}}
  rz();window.addEventListener('resize',rz);
  (function anim(){ctx.clearRect(0,0,c.width,c.height);pts.forEach(p=>{p.x+=p.vx;p.y+=p.vy;if(p.x<-10)p.x=c.width+10;if(p.x>c.width+10)p.x=-10;if(p.y<-10)p.y=c.height+10;if(p.y>c.height+10)p.y=-10;ctx.beginPath();ctx.arc(p.x,p.y,p.s,0,Math.PI*2);ctx.fillStyle=`hsla(${p.h},75%,60%,${p.a})`;ctx.fill()});requestAnimationFrame(anim)})();
})();
</script>

@endsection