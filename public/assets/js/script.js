/* ===== DREMIND DARK SHARED JS ===== */
(function(){
'use strict';

/* PRELOADER */
const loader=document.getElementById('loader');
if(loader){let p=0;const bar=loader.querySelector('.loader-ring');const pi=setInterval(()=>{p+=Math.random()*18+4;if(p>=100){p=100;clearInterval(pi);setTimeout(()=>loader.classList.add('hidden'),400)}},120)}

/* CUSTOM CURSOR */
(function(){
  const ring=document.getElementById('cursorRing'),dot=document.getElementById('cursorDot');
  if(!ring||!dot||window.innerWidth<769)return;
  let rx=0,ry=0,dx=0,dy=0;
  document.addEventListener('mousemove',e=>{dx=e.clientX;dy=e.clientY});
  (function anim(){rx+=(dx-rx)*.12;ry+=(dy-ry)*.12;ring.style.left=rx+'px';ring.style.top=ry+'px';dot.style.left=dx+'px';dot.style.top=dy+'px';requestAnimationFrame(anim)})();
  document.querySelectorAll('a,button,.btn-primary,.btn-secondary,.btn-cta,.bento-card,.feature-card,.social,.glass-strong').forEach(el=>{
    el.addEventListener('mouseenter',()=>{ring.style.transform='translate(-50%,-50%) scale(1.8)';ring.style.borderColor='rgba(6,182,212,.6)'});
    el.addEventListener('mouseleave',()=>{ring.style.transform='translate(-50%,-50%) scale(1)';ring.style.borderColor='rgba(124,58,237,.4)'});
  });
})();

/* NAVIGATION */
const nav=document.getElementById('mainNav');
const mobBtn=document.getElementById('mobToggle'),mobMenu=document.getElementById('mobMenu');
if(nav)window.addEventListener('scroll',()=>nav.classList.toggle('scrolled',scrollY>60),{passive:true});
if(mobBtn&&mobMenu){
  let open=false;
  mobBtn.addEventListener('click',()=>{
    open=!open;mobMenu.classList.toggle('open',open);
    const lines=mobBtn.querySelectorAll('span');
    if(lines[0]&&lines[1]&&lines[2]){
      lines[0].style.transform=open?'rotate(45deg) translate(3px,4px)':'';
      lines[1].style.opacity=open?'0':'1';
      lines[2].style.transform=open?'rotate(-45deg) translate(4px,-5px)':'';
      lines[2].style.width=open?'20px':'14px';
    }
  });
  mobMenu.querySelectorAll('a').forEach(a=>a.addEventListener('click',()=>{open=false;mobMenu.classList.remove('open')}));
}

/* SET ACTIVE PAGE */
window.setActivePage=function(page){
  document.querySelectorAll('.nav-link[data-page]').forEach(l=>{
    l.classList.toggle('active-link',l.dataset.page===page);
  });
};

/* SCROLL PROGRESS + BACK TO TOP */
const prog=document.getElementById('scrollProg'),btt=document.getElementById('backTop');
if(prog||btt){
  window.addEventListener('scroll',()=>{
    const h=document.documentElement.scrollHeight-innerHeight;
    if(prog)prog.style.width=((scrollY/h)*100)+'%';
    if(btt)btt.classList.toggle('show',scrollY>500);
  },{passive:true});
}
if(btt)btt.addEventListener('click',()=>window.scrollTo({top:0,behavior:'smooth'}));

/* SMOOTH SCROLL for anchor links */
document.querySelectorAll('a[href^="#"]').forEach(a=>{
  a.addEventListener('click',e=>{const t=document.querySelector(a.getAttribute('href'));if(t){e.preventDefault();t.scrollIntoView({behavior:'smooth',block:'start'})}});
});

/* SCROLL REVEAL */
const obs=new IntersectionObserver(entries=>{entries.forEach(e=>{if(e.isIntersecting)e.target.classList.add('vis')})},{threshold:.1,rootMargin:'0px 0px -40px 0px'});
document.querySelectorAll('.reveal,.reveal-left,.reveal-right,.reveal-scale').forEach(el=>obs.observe(el));

/* COUNTERS */
const co=new IntersectionObserver(entries=>{entries.forEach(x=>{if(x.isIntersecting&&!x.target.dataset.counted){x.target.dataset.counted='1';const t=+x.target.dataset.target;let c=0;const step=t/60;const inc=()=>{c=Math.min(c+step,t);x.target.textContent=t>=10000?Math.round(c).toLocaleString():Math.round(c);if(c<t)requestAnimationFrame(inc)};inc();co.unobserve(x.target)}})},{threshold:.5});
document.querySelectorAll('.counter').forEach(el=>co.observe(el));

/* MAGNETIC BUTTONS */
document.querySelectorAll('.btn-primary,.btn-secondary,.btn-cta').forEach(b=>{
  b.addEventListener('mousemove',e=>{const r=b.getBoundingClientRect();b.style.transform=`translate(${(e.clientX-r.left-r.width/2)*.12}px,${(e.clientY-r.top-r.height/2)*.12}px)`});
  b.addEventListener('mouseleave',()=>{b.style.transform=''});
});

/* BENTO TILT */
document.querySelectorAll('[data-tilt]').forEach(card=>{
  card.addEventListener('mousemove',e=>{
    const r=card.getBoundingClientRect();
    const x=(e.clientX-r.left)/r.width,y=(e.clientY-r.top)/r.height;
    card.style.transform=`perspective(800px) rotateX(${(y-.5)*-8}deg) rotateY(${(x-.5)*8}deg) translateY(-8px)`;
  });
  card.addEventListener('mouseleave',()=>{card.style.transform=''});
});

/* PARALLAX BLOBS */
window.addEventListener('scroll',()=>{
  document.querySelectorAll('.gradient-blob').forEach((b,i)=>{
    b.style.transform=`translateY(${scrollY*(.02+i*.008)}px)`;
  });
},{passive:true});

/* FAQ ACCORDION */
document.querySelectorAll('.faq-question-dark').forEach(q=>{
  q.addEventListener('click',()=>{
    const item=q.parentElement,ans=item.querySelector('.faq-answer-dark'),icon=q.querySelector('.faq-icon-dark');
    const wasOpen=ans.classList.contains('open');
    item.closest('.faq-group-dark')?.querySelectorAll('.faq-answer-dark.open').forEach(a=>{a.classList.remove('open');a.closest('.faq-item-dark')?.querySelector('.faq-icon-dark')?.classList.remove('open')});
    if(!wasOpen){ans.classList.add('open');icon?.classList.add('open')}
  });
});

/* LEGAL TABS */
window.switchLegalDoc=function(doc,el){
  document.querySelectorAll('.legal-nav-dark').forEach(n=>n.classList.remove('active'));
  el.classList.add('active');
  document.querySelectorAll('.legal-tab-dark').forEach(t=>t.classList.remove('active'));
  document.getElementById('doc-'+doc)?.classList.add('active');
  window.scrollTo({top:250,behavior:'smooth'});
  history.replaceState(null,null,'#'+doc);
};

/* PARTICLES BACKGROUND SYSTEM */
(function(){
  const THEMES={
    purple:[{h:265,s:75,l:60},{h:280,s:70,l:55},{h:250,s:80,l:65}],
    cyan:[{h:190,s:80,l:55},{h:200,s:75,l:60},{h:180,s:85,l:50}],
    green:[{h:155,s:75,l:50},{h:140,s:70,l:55},{h:170,s:80,l:45}],
    mixed:[{h:265,s:75,l:60},{h:190,s:80,l:55},{h:155,s:75,l:50},{h:340,s:80,l:60},{h:45,s:85,l:55}],
    white:[{h:0,s:0,l:80},{h:0,s:0,l:90},{h:0,s:0,l:70}],
  };

  class P{
    constructor(cv,cfg){this.cv=cv;this.cfg=cfg;this.reset(true)}
    reset(init){
      const w=this.cv.width,h=this.cv.height,dir=this.cfg.direction||'random';
      if(init||dir==='random'){this.x=Math.random()*w;this.y=Math.random()*h}
      else if(dir==='up'){this.x=Math.random()*w;this.y=h+10}
      else if(dir==='down'){this.x=Math.random()*w;this.y=-10}
      this.depth=.3+Math.random()*.7;
      this.baseSize=(Math.random()*(this.cfg.size||2)*.6+(this.cfg.size||2)*.4)*this.depth;
      this.size=this.baseSize;
      const spd=(this.cfg.speed||.3)*this.depth;
      if(dir==='random'){this.vx=(Math.random()-.5)*spd*2;this.vy=(Math.random()-.5)*spd*2}
      else if(dir==='up'){this.vx=(Math.random()-.5)*spd*.5;this.vy=-spd*(Math.random()*.5+.5)}
      else if(dir==='down'){this.vx=(Math.random()-.5)*spd*.5;this.vy=spd*(Math.random()*.5+.5)}
      const palette=THEMES[this.cfg.theme]||THEMES.mixed;
      const c=palette[~~(Math.random()*palette.length)];
      this.hue=c.h;this.sat=c.s;this.lit=c.l;
      this.alpha=(this.cfg.opacity||.4)*(Math.random()*.5+.5);
      this.driftPhase=Math.random()*Math.PI*2;
      this.pulsePhase=Math.random()*Math.PI*2;
    }
    update(mx,my){
      this.x+=this.vx;this.y+=this.vy;
      this.driftPhase+=.008;
      if(this.cfg.drift!==false){this.x+=Math.sin(this.driftPhase)*this.depth*.3;this.y+=Math.cos(this.driftPhase*.7)*this.depth*.3}
      if(this.cfg.pulse==='true'){this.pulsePhase+=.015;this.size=this.baseSize*(1+Math.sin(this.pulsePhase)*.3)}
      if(mx!==null&&this.cfg.mouse!=='false'){
        const dx=this.x-mx,dy=this.y-my,dist=Math.sqrt(dx*dx+dy*dy),rad=(this.cfg.mouseRadius||100)*devicePixelRatio;
        if(dist<rad&&dist>0){const f=(rad-dist)/rad;this.vx+=dx/dist*f*1.2;this.vy+=dy/dist*f*1.2}
      }
      this.vx*=.99;this.vy*=.99;
      const dir=this.cfg.direction||'random';
      const w=this.cv.width,h=this.cv.height,pad=20;
      if(dir==='random'){if(this.x<-pad)this.x=w+pad;if(this.x>w+pad)this.x=-pad;if(this.y<-pad)this.y=h+pad;if(this.y>h+pad)this.y=-pad}
      else if(this.x<-pad||this.x>w+pad||this.y<-pad||this.y>h+pad)this.reset(false);
    }
    draw(ctx){
      ctx.save();ctx.globalAlpha=this.alpha;
      if(this.cfg.glow==='true'){ctx.shadowBlur=this.size*4;ctx.shadowColor=`hsla(${this.hue},${this.sat}%,${this.lit}%,.5)`}
      ctx.fillStyle=`hsl(${this.hue},${this.sat}%,${this.lit}%)`;
      ctx.beginPath();ctx.arc(this.x/devicePixelRatio,this.y/devicePixelRatio,this.size,0,Math.PI*2);ctx.fill();
      ctx.restore();
    }
  }

  class PS{
    constructor(section){
      this.section=section;this.canvas=document.createElement('canvas');
      this.canvas.style.cssText='position:absolute;top:0;left:0;width:100%;height:100%;pointer-events:none;z-index:0;';
      this.ctx=this.canvas.getContext('2d');this.particles=[];this.mx=null;this.my=null;this.active=false;this.dpr=Math.min(devicePixelRatio,2);
      this.cfg={
        theme:section.dataset.particles||'mixed',count:parseInt(section.dataset.pCount)||60,
        speed:parseFloat(section.dataset.pSpeed)||.3,size:parseFloat(section.dataset.pSize)||2,
        connect:section.dataset.pConnect!=='false',connectDist:parseInt(section.dataset.pConnectDist)||100,
        mouse:section.dataset.pMouse,mouseRadius:parseInt(section.dataset.pMouseRadius)||100,
        opacity:parseFloat(section.dataset.pOpacity)||.4,
        glow:section.dataset.pGlow,pulse:section.dataset.pPulse,
        direction:section.dataset.pDirection||'random',drift:section.dataset.pDrift
      };
      const pos=getComputedStyle(section).position;
      if(pos==='static')section.style.position='relative';
      section.insertBefore(this.canvas,section.firstChild);
      this._resize();this._create();this._bind();this._anim();
    }
    _resize(){const r=this.section.getBoundingClientRect();this.canvas.width=r.width*this.dpr;this.canvas.height=r.height*this.dpr;this.ctx.scale(this.dpr,this.dpr);this.w=r.width;this.h=r.height}
    _create(){this.particles=[];const n=Math.round(this.cfg.count*Math.min((this.w*this.h)/(1920*1080),1.5));for(let i=0;i<n;i++)this.particles.push(new P(this.canvas,this.cfg))}
    _bind(){
      this.section.addEventListener('mousemove',e=>{const r=this.section.getBoundingClientRect();this.mx=(e.clientX-r.left)*this.dpr;this.my=(e.clientY-r.top)*this.dpr});
      this.section.addEventListener('mouseleave',()=>{this.mx=null;this.my=null});
      new ResizeObserver(()=>{this._resize();this._create()}).observe(this.section);
      new IntersectionObserver(([e])=>{this.active=e.isIntersecting},{threshold:.05}).observe(this.section);
    }
    _drawConn(){
      const ctx=this.ctx,pts=this.particles,md=this.cfg.connectDist*this.dpr,md2=md*md;
      for(let i=0;i<pts.length;i++){for(let j=i+1;j<pts.length;j++){
        const dx=pts[i].x-pts[j].x,dy=pts[i].y-pts[j].y,d2=dx*dx+dy*dy;
        if(d2<md2){const a=(1-d2/md2)*this.cfg.opacity*.25;ctx.save();ctx.globalAlpha=a;ctx.strokeStyle=`hsl(${pts[i].hue},${pts[i].sat}%,${pts[i].lit}%)`;ctx.lineWidth=.5;ctx.beginPath();ctx.moveTo(pts[i].x/this.dpr,pts[i].y/this.dpr);ctx.lineTo(pts[j].x/this.dpr,pts[j].y/this.dpr);ctx.stroke();ctx.restore()}
      }}
    }
    _anim(){
      (function loop(self){
        if(self.active){
          self.ctx.clearRect(0,0,self.w,self.h);
          self.particles.forEach(p=>p.update(self.mx,self.my));
          if(self.cfg.connect)self._drawConn();
          self.particles.forEach(p=>p.draw(self.ctx));
        }
        requestAnimationFrame(()=>loop(self));
      })(this);
    }
  }

  function init(){document.querySelectorAll('[data-particles]').forEach(s=>new PS(s))}
  if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',init);
  else init();
})();

/* MODAL HELPERS */
window.openModalDark=function(m){
  m.classList.remove('invisible');
  requestAnimationFrame(()=>{m.style.opacity='1';const c=m.querySelector('.modal-inner-dark');if(c){c.style.transform='scale(1)';c.style.opacity='1'}});
  document.body.style.overflow='hidden';
};
window.closeModalDark=function(m){
  m.style.opacity='0';const c=m.querySelector('.modal-inner-dark');if(c){c.style.transform='scale(.95)';c.style.opacity='0'}
  setTimeout(()=>{m.classList.add('invisible');document.body.style.overflow=''},400);
};

/* ESC KEY for modals */
document.addEventListener('keydown',e=>{
  if(e.key==='Escape')document.querySelectorAll('.fixed-modal-dark:not(.invisible)').forEach(m=>closeModalDark(m));
});

})();