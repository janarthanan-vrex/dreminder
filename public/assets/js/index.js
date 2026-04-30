/* ================================================================
   GLOBALS
   ================================================================ */
const M={x:0,y:0,nx:.5,ny:.5};
document.addEventListener('mousemove',e=>{M.x=e.clientX;M.y=e.clientY;M.nx=e.clientX/innerWidth;M.ny=e.clientY/innerHeight});
document.addEventListener('touchmove',e=>{const t=e.touches[0];M.x=t.clientX;M.y=t.clientY;M.nx=t.clientX/innerWidth;M.ny=t.clientY/innerHeight},{passive:true});

const VERT=`attribute vec2 a_position;varying vec2 vUv;void main(){vUv=a_position*.5+.5;gl_Position=vec4(a_position,0,1);}`;

function mkShader(canvas,frag){
  const gl=canvas.getContext('webgl',{alpha:true,premultipliedAlpha:false,antialias:false});
  if(!gl)return null;
  function comp(t,s){const sh=gl.createShader(t);gl.shaderSource(sh,s);gl.compileShader(sh);if(!gl.getShaderParameter(sh,gl.COMPILE_STATUS)){console.warn(gl.getShaderInfoLog(sh));return null}return sh}
  const v=comp(gl.VERTEX_SHADER,VERT),f=comp(gl.FRAGMENT_SHADER,frag);
  if(!v||!f)return null;
  const p=gl.createProgram();gl.attachShader(p,v);gl.attachShader(p,f);gl.linkProgram(p);
  if(!gl.getProgramParameter(p,gl.LINK_STATUS))return null;
  const b=gl.createBuffer();gl.bindBuffer(gl.ARRAY_BUFFER,b);
  gl.bufferData(gl.ARRAY_BUFFER,new Float32Array([-1,-1,1,-1,-1,1,-1,1,1,-1,1,1]),gl.STATIC_DRAW);
  const a=gl.getAttribLocation(p,'a_position');gl.enableVertexAttribArray(a);gl.vertexAttribPointer(a,2,gl.FLOAT,false,0,0);
  gl.useProgram(p);return{gl,p}
}

function szCanvas(c,d){const r=c.parentElement.getBoundingClientRect();c.width=r.width*d;c.height=r.height*d;c.style.width=r.width+'px';c.style.height=r.height+'px';return r}

/* ================================================================
   LOADER
   ================================================================ */
window.addEventListener('load',()=>{
  setTimeout(()=>{document.getElementById('loader').classList.add('hidden')},800);
});

/* ================================================================
   CUSTOM CURSOR
   ================================================================ */
(function(){
  const ring=document.getElementById('cursorRing'),dot=document.getElementById('cursorDot');
  if(!ring||!dot||window.innerWidth<769)return;
  let rx=0,ry=0,dx=0,dy=0;
  document.addEventListener('mousemove',e=>{dx=e.clientX;dy=e.clientY});
  (function anim(){
    rx+=(dx-rx)*.12;ry+=(dy-ry)*.12;
    ring.style.left=rx+'px';ring.style.top=ry+'px';
    dot.style.left=dx+'px';dot.style.top=dy+'px';
    requestAnimationFrame(anim);
  })();
  document.querySelectorAll('a,button,.btn-primary,.btn-secondary,.btn-cta,.bento-card,.feature-card,.social').forEach(el=>{
    el.addEventListener('mouseenter',()=>{ring.style.transform='translate(-50%,-50%) scale(1.8)';ring.style.borderColor='rgba(6,182,212,.6)'});
    el.addEventListener('mouseleave',()=>{ring.style.transform='translate(-50%,-50%) scale(1)';ring.style.borderColor='rgba(124,58,237,.4)'});
  });
})();

/* ================================================================
   NAVIGATION
   ================================================================ */
(function(){
  const nav=document.getElementById('mainNav');
  const btn=document.getElementById('mobToggle');
  const menu=document.getElementById('mobMenu');
  let open=false;
  window.addEventListener('scroll',()=>{nav.classList.toggle('scrolled',scrollY>60)},{passive:true});
  btn.addEventListener('click',()=>{
    open=!open;menu.classList.toggle('open',open);
    document.getElementById('mLine1').style.transform=open?'rotate(45deg) translate(3px,4px)':'';
    document.getElementById('mLine2').style.opacity=open?'0':'1';
    document.getElementById('mLine3').style.transform=open?'rotate(-45deg) translate(4px,-5px)':'';
    document.getElementById('mLine3').style.width=open?'20px':'14px';
  });
  document.querySelectorAll('a[href^="#"]').forEach(a=>{
    a.addEventListener('click',e=>{e.preventDefault();const t=document.querySelector(a.getAttribute('href'));if(t){t.scrollIntoView({behavior:'smooth'});if(open){open=false;menu.classList.remove('open')}}});
  });
})();

/* ================================================================
   SCROLL PROGRESS + BACK TO TOP
   ================================================================ */
(function(){
  const prog=document.getElementById('scrollProg');
  const btt=document.getElementById('backTop');
  window.addEventListener('scroll',()=>{
    const h=document.documentElement.scrollHeight-innerHeight;
    const p=(scrollY/h)*100;
    prog.style.width=p+'%';
    btt.classList.toggle('show',scrollY>500);
  },{passive:true});
  btt.addEventListener('click',()=>window.scrollTo({top:0,behavior:'smooth'}));
})();

/* ================================================================
   SCROLL REVEAL
   ================================================================ */
(function(){
  const obs=new IntersectionObserver(entries=>{entries.forEach(e=>{if(e.isIntersecting)e.target.classList.add('vis')})},{threshold:.12,rootMargin:'0px 0px -50px 0px'});
  document.querySelectorAll('.reveal,.reveal-left,.reveal-right,.reveal-scale').forEach(el=>obs.observe(el));
})();

/* ================================================================
   PLASMA SHADER (Hero)
   ================================================================ */
(function(){
  const c=document.getElementById('plasmaC');const dpr=Math.min(devicePixelRatio,1.5);
  const F=`precision mediump float;varying vec2 vUv;uniform float uT;uniform vec2 uM,uR;
  vec3 hsv(vec3 c){vec4 K=vec4(1.,2./3.,1./3.,3.);vec3 p=abs(fract(c.xxx+K.xyz)*6.-K.www);return c.z*mix(K.xxx,clamp(p-K.xxx,0.,1.),c.y);}
  float plasma(vec2 p,float t){float v=sin(p.x*3.+t)+sin((p.y*3.+t)/2.)+sin((p.x*3.+p.y*3.+t)/2.);float cx=p.x+.5*sin(t/5.);float cy=p.y+.5*cos(t/3.);v+=sin(sqrt(100.*(cx*cx+cy*cy)+1.)+t);return v/2.;}
  void main(){vec2 uv=vUv;vec2 p=(uv-.5)*2.;p.x*=uR.x/uR.y;float t=uT*.35;float v=plasma(p+uM*.2,t)+plasma(p*1.4-uM*.15,t*1.2)*.5;
  float h=v*.12+t*.015;vec3 col=hsv(vec3(h+.72,.55,.3))+hsv(vec3(h+.95,.4,.12));col*=pow(1.-length(uv-.5)*1.1,2.)*.6;gl_FragColor=vec4(col,1.);}`;
  const s=mkShader(c,F);if(!s)return;const{gl,p}=s;
  const uT=gl.getUniformLocation(p,'uT'),uM=gl.getUniformLocation(p,'uM'),uR=gl.getUniformLocation(p,'uR');
  function resize(){szCanvas(c,dpr);gl.viewport(0,0,c.width,c.height);gl.uniform2f(uR,c.width,c.height)}
  resize();new ResizeObserver(resize).observe(c.parentElement);
  let t=0,act=true;
  (function draw(){if(act){t+=.016;gl.uniform1f(uT,t);gl.uniform2f(uM,M.nx,1-M.ny);gl.drawArrays(gl.TRIANGLES,0,6)}requestAnimationFrame(draw)})();
  new IntersectionObserver(([e])=>{act=e.isIntersecting},{threshold:.05}).observe(c.parentElement);
})();

/* ================================================================
   PHONE SCREEN RENDER
   ================================================================ */
(function(){
  const scr=document.getElementById('phoneScreen');
  const cv=document.createElement('canvas');cv.width=360;cv.height=720;
  cv.style.cssText='width:100%;height:100%;border-radius:34px';
  scr.appendChild(cv);const ctx=cv.getContext('2d');
  function draw(){
    const g=ctx.createLinearGradient(0,0,0,720);
    g.addColorStop(0,'#0c0a20');g.addColorStop(.5,'#120e30');g.addColorStop(1,'#0c0a20');
    ctx.fillStyle=g;ctx.fillRect(0,0,360,720);
    ctx.fillStyle='rgba(255,255,255,.4)';ctx.font='600 13px Inter,sans-serif';
    ctx.fillText('9:41',20,32);ctx.fillText('100%',300,32);
    ctx.fillStyle='#fff';ctx.font='700 22px Inter,sans-serif';
    ctx.fillText('Good Morning! ☀️',20,80);
    ctx.fillStyle='rgba(255,255,255,.35)';ctx.font='400 13px Inter,sans-serif';
    ctx.fillText('You have 4 upcoming reminders',20,102);
    const ug=ctx.createLinearGradient(20,118,340,118);
    ug.addColorStop(0,'rgba(124,58,237,.3)');ug.addColorStop(1,'rgba(6,182,212,.3)');
    ctx.fillStyle=ug;ctx.beginPath();ctx.roundRect(20,112,320,36,10);ctx.fill();
    ctx.fillStyle='#fff';ctx.font='600 12px Inter,sans-serif';
    ctx.fillText('⚠️  Netflix renews tomorrow — $15.99',36,135);
    const cards=[
      {icon:'💳',title:'Netflix Subscription',sub:'Due tomorrow',amt:'$15.99',color:'#e50914',urgent:true},
      {icon:'⚡',title:'Electric Bill',sub:'Due in 3 days',amt:'$84.20',color:'#f39c12',urgent:false},
      {icon:'🛡️',title:'Car Insurance',sub:'Renews in 8 days',amt:'$120.00',color:'#7c3aed',urgent:false},
      {icon:'📱',title:'Phone Plan',sub:'Auto-renew in 12 days',amt:'$45.00',color:'#06b6d4',urgent:false}
    ];
    cards.forEach((c,i)=>{
      const y=168+i*105;
      ctx.fillStyle=c.urgent?'rgba(229,9,20,.06)':'rgba(255,255,255,.04)';
      ctx.beginPath();ctx.roundRect(16,y,328,88,14);ctx.fill();
      ctx.strokeStyle=c.urgent?'rgba(229,9,20,.2)':'rgba(255,255,255,.06)';
      ctx.lineWidth=1;ctx.beginPath();ctx.roundRect(16,y,328,88,14);ctx.stroke();
      ctx.fillStyle=c.color;ctx.beginPath();ctx.roundRect(16,y,3,88,[14,0,0,14]);ctx.fill();
      ctx.font='22px sans-serif';ctx.fillText(c.icon,32,y+38);
      ctx.fillStyle='#fff';ctx.font='600 14px Inter,sans-serif';ctx.fillText(c.title,62,y+34);
      ctx.fillStyle='rgba(255,255,255,.35)';ctx.font='400 12px Inter,sans-serif';ctx.fillText(c.sub,62,y+54);
      ctx.fillStyle=c.color;ctx.font='700 15px Inter,sans-serif';
      ctx.textAlign='right';ctx.fillText(c.amt,332,y+34);ctx.textAlign='left';
      if(c.urgent){ctx.fillStyle='#e50914';ctx.font='600 10px Inter,sans-serif';ctx.textAlign='right';ctx.fillText('URGENT',332,y+54);ctx.textAlign='left'}
    });
    ctx.fillStyle='rgba(124,58,237,.08)';ctx.beginPath();ctx.roundRect(16,592,328,68,14);ctx.fill();
    ctx.strokeStyle='rgba(124,58,237,.15)';ctx.beginPath();ctx.roundRect(16,592,328,68,14);ctx.stroke();
    ctx.fillStyle='#c4b5fd';ctx.font='600 13px Inter,sans-serif';ctx.fillText('📊 Monthly Total',32,618);
    ctx.fillStyle='#fff';ctx.font='700 18px Inter,sans-serif';ctx.fillText('$265.19',32,642);
    ctx.fillStyle='#10b981';ctx.font='600 12px Inter,sans-serif';ctx.textAlign='right';ctx.fillText('↓ $34 saved vs last month',332,635);ctx.textAlign='left';
    ctx.fillStyle='rgba(255,255,255,.03)';ctx.fillRect(0,672,360,48);
    ctx.strokeStyle='rgba(255,255,255,.05)';ctx.beginPath();ctx.moveTo(0,672);ctx.lineTo(360,672);ctx.stroke();
    ['🏠','🔔','📊','⚙️'].forEach((ic,i)=>{ctx.font='20px sans-serif';ctx.fillText(ic,40+i*80,700)});
  }
  draw();
})();

/* ================================================================
   RIPPLE GRID SHADER (Features BG)
   ================================================================ */
(function(){
  const c=document.getElementById('rippleC');const dpr=Math.min(devicePixelRatio,1.5);
  const F=`precision mediump float;varying vec2 vUv;uniform float uT;uniform vec2 uM,uR;
  void main(){vec2 uv=vUv;vec2 p=(uv-.5)*2.;p.x*=uR.x/uR.y;
  float gx=sin(p.x*30.),gy=sin(p.y*30.);float grid=max(smoothstep(.93,1.,gx),smoothstep(.93,1.,gy));
  vec2 mp=(uM-.5)*2.;mp.x*=uR.x/uR.y;float d=length(p-mp);float rip=sin(d*18.-uT*4.)*.5+.5;rip*=exp(-d*2.);
  vec3 col=vec3(.012,.005,.035);col+=vec3(.3,.15,.7)*grid*.08;col+=vec3(0,.7,.85)*rip*.2;
  col*=pow(1.-length(uv-.5)*1.3,2.);gl_FragColor=vec4(col,1.);}`;
  const s=mkShader(c,F);if(!s)return;const{gl,p:pr}=s;
  const uT=gl.getUniformLocation(pr,'uT'),uM=gl.getUniformLocation(pr,'uM'),uR=gl.getUniformLocation(pr,'uR');
  function resize(){szCanvas(c,dpr);gl.viewport(0,0,c.width,c.height);gl.uniform2f(uR,c.width,c.height)}
  resize();new ResizeObserver(resize).observe(c.parentElement);
  let t=0,act=false;
  (function draw(){if(act){t+=.016;gl.uniform1f(uT,t);gl.uniform2f(uM,M.nx,1-M.ny);gl.drawArrays(gl.TRIANGLES,0,6)}requestAnimationFrame(draw)})();
  new IntersectionObserver(([e])=>{act=e.isIntersecting},{threshold:.05}).observe(c.parentElement);
})();

/* ================================================================
   PIXEL CARD HOVER
   ================================================================ */
(function(){
  document.querySelectorAll('[data-pixel]').forEach(card=>{
    const cv=card.querySelector('canvas');if(!cv)return;const ctx=cv.getContext('2d');
    let parts=[],hover=false;
    function resize(){const r=card.getBoundingClientRect();cv.width=r.width;cv.height=r.height}
    resize();new ResizeObserver(resize).observe(card);
    class P{constructor(){this.reset()}
      reset(){this.x=Math.random()*cv.width;this.y=Math.random()*cv.height;this.s=Math.random()*2.5+1;this.vx=(Math.random()-.5)*1.2;this.vy=(Math.random()-.5)*1.2;this.life=1;this.decay=Math.random()*.012+.006;this.hue=[265,195,160][~~(Math.random()*3)]}
      update(){this.x+=this.vx;this.y+=this.vy;this.life-=this.decay;if(this.life<=0)this.reset()}
      draw(){ctx.fillStyle=`hsla(${this.hue},75%,60%,${this.life*.4})`;ctx.fillRect(~~this.x,~~this.y,this.s,this.s)}}
    function anim(){ctx.clearRect(0,0,cv.width,cv.height);if(hover&&parts.length<50)parts.push(new P);parts.forEach(p=>{p.update();p.draw()});if(!hover)parts=parts.filter(p=>p.life>0);requestAnimationFrame(anim)}
    card.addEventListener('mouseenter',()=>hover=true);card.addEventListener('mouseleave',()=>hover=false);
    anim();
  });
})();

/* ================================================================
   LIGHTNING SHADER (Showcase BG)
   ================================================================ */
(function(){
  const c=document.getElementById('lightningC');const dpr=Math.min(devicePixelRatio,1.5);
  const F=`precision mediump float;varying vec2 vUv;uniform float uT;uniform vec2 uR;
  float h(vec2 p){return fract(sin(dot(p,vec2(127.1,311.7)))*43758.5453);}
  float n(vec2 p){vec2 i=floor(p),f=fract(p);float a=h(i),b=h(i+vec2(1,0)),c=h(i+vec2(0,1)),d=h(i+vec2(1,1));vec2 u=f*f*(3.-2.*f);return mix(a,b,u.x)+(c-a)*u.y*(1.-u.x)+(d-b)*u.x*u.y;}
  float bolt(vec2 uv,float t,float off){float x=uv.x+off;float nn=n(vec2(x*2.,t*3.))*.4+n(vec2(x*8.,t*5.))*.15+n(vec2(x*16.,t*7.))*.08;float b=abs(uv.y-nn-.3);float g=.003/b;return g*(.3+(sin(t*10.+off*20.)*.5+.5)*.7);}
  void main(){vec2 uv=vUv;uv.x*=uR.x/uR.y;float t=uT*.25;vec3 col=vec3(.015,.008,.03);
  col+=vec3(.35,.25,.8)*bolt(uv,t,0.)+vec3(0,.7,.9)*bolt(uv,t*1.3,.4)*.5+vec3(0,.9,.45)*bolt(uv,t*.8,-.3)*.35+vec3(.7,.2,.9)*bolt(vec2(uv.x,uv.y-.5),t*1.1,.2)*.25;
  col*=pow(1.-length(vUv-.5)*1.2,2.);gl_FragColor=vec4(col,1.);}`;
  const s=mkShader(c,F);if(!s)return;const{gl,p:pr}=s;
  const uT=gl.getUniformLocation(pr,'uT'),uR=gl.getUniformLocation(pr,'uR');
  function resize(){szCanvas(c,dpr);gl.viewport(0,0,c.width,c.height);gl.uniform2f(uR,c.width,c.height)}
  resize();new ResizeObserver(resize).observe(c.parentElement);
  let t=0,act=false;
  (function draw(){if(act){t+=.016;gl.uniform1f(uT,t);gl.drawArrays(gl.TRIANGLES,0,6)}requestAnimationFrame(draw)})();
  new IntersectionObserver(([e])=>{act=e.isIntersecting},{threshold:.05}).observe(c.parentElement);
})();

/* ================================================================
   3D GLOBE (Three.js — replaces orb)
   ================================================================ */
(function(){
  const wrap=document.getElementById('globeWrap');
  const canvas=document.getElementById('globeC');
  if(!wrap||!canvas)return;

  const renderer=new THREE.WebGLRenderer({canvas,alpha:true,antialias:true});
  renderer.setPixelRatio(Math.min(devicePixelRatio,2));
  const scene=new THREE.Scene();
  const camera=new THREE.PerspectiveCamera(45,1,.1,100);
  camera.position.z=4.2;

  // Lighting
  scene.add(new THREE.AmbientLight(0x404070,.4));
  const dl=new THREE.DirectionalLight(0xaaaaff,.6);dl.position.set(5,3,5);scene.add(dl);
  const pl1=new THREE.PointLight(0x7c3aed,1.5,15);pl1.position.set(-3,2,3);scene.add(pl1);
  const pl2=new THREE.PointLight(0x06b6d4,1.2,15);pl2.position.set(3,-2,3);scene.add(pl2);

  const globeGroup=new THREE.Group();
  scene.add(globeGroup);

  // Wireframe sphere
  const wireGeo=new THREE.SphereGeometry(1.5,36,24);
  const wireMat=new THREE.MeshBasicMaterial({color:0x7c3aed,wireframe:true,transparent:true,opacity:.08});
  const wireSphere=new THREE.Mesh(wireGeo,wireMat);
  globeGroup.add(wireSphere);

  // Solid inner sphere with gradient-like material
  const innerGeo=new THREE.SphereGeometry(1.48,48,32);
  const innerMat=new THREE.MeshPhongMaterial({
    color:0x0a0a2a,emissive:0x0a0a2a,emissiveIntensity:.3,
    shininess:30,transparent:true,opacity:.85,
    side:THREE.FrontSide
  });
  const innerSphere=new THREE.Mesh(innerGeo,innerMat);
  globeGroup.add(innerSphere);

  // Atmosphere glow ring
  const atmoGeo=new THREE.SphereGeometry(1.62,48,32);
  const atmoMat=new THREE.MeshBasicMaterial({
    color:0x7c3aed,transparent:true,opacity:.06,side:THREE.BackSide
  });
  globeGroup.add(new THREE.Mesh(atmoGeo,atmoMat));

  // Second atmosphere layer
  const atmo2Geo=new THREE.SphereGeometry(1.75,32,24);
  const atmo2Mat=new THREE.MeshBasicMaterial({
    color:0x06b6d4,transparent:true,opacity:.03,side:THREE.BackSide
  });
  globeGroup.add(new THREE.Mesh(atmo2Geo,atmo2Mat));

  // Surface dots (simulate continents/data points)
  const dotCount=600;
  const dotGeo=new THREE.BufferGeometry();
  const dotPos=new Float32Array(dotCount*3);
  const dotCol=new Float32Array(dotCount*3);
  const dotSizes=new Float32Array(dotCount);

  for(let i=0;i<dotCount;i++){
    // Random spherical coordinates
    const phi=Math.acos(2*Math.random()-1);
    const theta=Math.random()*Math.PI*2;
    const r=1.51;
    dotPos[i*3]=r*Math.sin(phi)*Math.cos(theta);
    dotPos[i*3+1]=r*Math.sin(phi)*Math.sin(theta);
    dotPos[i*3+2]=r*Math.cos(phi);

    // Color variation
    const t=Math.random();
    if(t<.4){dotCol[i*3]=.49;dotCol[i*3+1]=.23;dotCol[i*3+2]=.93;} // purple
    else if(t<.7){dotCol[i*3]=.02;dotCol[i*3+1]=.71;dotCol[i*3+2]=.83;} // cyan
    else{dotCol[i*3]=.06;dotCol[i*3+1]=.72;dotCol[i*3+2]=.51;} // green

    dotSizes[i]=Math.random()*2+1;
  }
  dotGeo.setAttribute('position',new THREE.BufferAttribute(dotPos,3));
  dotGeo.setAttribute('color',new THREE.BufferAttribute(dotCol,3));
  const dotMat=new THREE.PointsMaterial({size:.025,vertexColors:true,transparent:true,opacity:.7,sizeAttenuation:true});
  const dots=new THREE.Points(dotGeo,dotMat);
  globeGroup.add(dots);

  // Connection arcs between random points
  const arcCount=12;
  for(let i=0;i<arcCount;i++){
    const phi1=Math.acos(2*Math.random()-1),th1=Math.random()*Math.PI*2;
    const phi2=Math.acos(2*Math.random()-1),th2=Math.random()*Math.PI*2;
    const r=1.51;
    const p1=new THREE.Vector3(r*Math.sin(phi1)*Math.cos(th1),r*Math.sin(phi1)*Math.sin(th1),r*Math.cos(phi1));
    const p2=new THREE.Vector3(r*Math.sin(phi2)*Math.cos(th2),r*Math.sin(phi2)*Math.sin(th2),r*Math.cos(phi2));
    const mid=new THREE.Vector3().addVectors(p1,p2).multiplyScalar(.5);
    const midLen=mid.length();
    if(midLen>0)mid.multiplyScalar((r+.6+Math.random()*.4)/midLen);

    const curve=new THREE.QuadraticBezierCurve3(p1,mid,p2);
    const pts=curve.getPoints(32);
    const lineGeo=new THREE.BufferGeometry().setFromPoints(pts);
    const colors=[0x7c3aed,0x06b6d4,0x10b981];
    const lineMat=new THREE.LineBasicMaterial({color:colors[i%3],transparent:true,opacity:.25});
    const line=new THREE.Line(lineGeo,lineMat);
    globeGroup.add(line);

    // Endpoint markers
    [p1,p2].forEach(pt=>{
      const mg=new THREE.SphereGeometry(.025,8,8);
      const mm=new THREE.MeshBasicMaterial({color:colors[i%3],transparent:true,opacity:.8});
      const marker=new THREE.Mesh(mg,mm);
      marker.position.copy(pt);
      globeGroup.add(marker);
    });
  }

  // Orbital ring
  const ringGeo=new THREE.RingGeometry(1.9,1.92,64);
  const ringMat=new THREE.MeshBasicMaterial({color:0x7c3aed,transparent:true,opacity:.12,side:THREE.DoubleSide});
  const ring=new THREE.Mesh(ringGeo,ringMat);
  ring.rotation.x=Math.PI/2.8;
  globeGroup.add(ring);

  // Second orbital ring
  const ring2=new THREE.Mesh(
    new THREE.RingGeometry(2.05,2.07,64),
    new THREE.MeshBasicMaterial({color:0x06b6d4,transparent:true,opacity:.06,side:THREE.DoubleSide})
  );
  ring2.rotation.x=Math.PI/2;
  ring2.rotation.y=Math.PI/4;
  globeGroup.add(ring2);

  // Mouse drag controls
  let isDrag=false,prevX=0,prevY=0,velX=0,velY=0,targetRotX=0,targetRotY=0;

  canvas.addEventListener('mousedown',e=>{isDrag=true;prevX=e.clientX;prevY=e.clientY;velX=0;velY=0;canvas.style.cursor='grabbing'});
  canvas.addEventListener('mousemove',e=>{
    if(!isDrag)return;
    const dx=e.clientX-prevX,dy=e.clientY-prevY;
    velX=dx*.005;velY=dy*.005;
    targetRotY+=velX;targetRotX+=velY;
    prevX=e.clientX;prevY=e.clientY;
  });
  canvas.addEventListener('mouseup',()=>{isDrag=false;canvas.style.cursor='grab'});
  canvas.addEventListener('mouseleave',()=>{isDrag=false;canvas.style.cursor='grab'});

  // Touch support
  canvas.addEventListener('touchstart',e=>{isDrag=true;prevX=e.touches[0].clientX;prevY=e.touches[0].clientY;velX=0;velY=0},{passive:true});
  canvas.addEventListener('touchmove',e=>{
    if(!isDrag)return;
    const dx=e.touches[0].clientX-prevX,dy=e.touches[0].clientY-prevY;
    velX=dx*.005;velY=dy*.005;
    targetRotY+=velX;targetRotX+=velY;
    prevX=e.touches[0].clientX;prevY=e.touches[0].clientY;
  },{passive:true});
  canvas.addEventListener('touchend',()=>{isDrag=false});

  function resize(){
    const r=wrap.getBoundingClientRect();
    renderer.setSize(r.width,r.height);
    camera.aspect=r.width/r.height;
    camera.updateProjectionMatrix();
  }
  resize();new ResizeObserver(resize).observe(wrap);

  let act=false,time=0;
  (function anim(){
    if(act){
      time+=.016;
      // Auto rotation when not dragging
      if(!isDrag){
        targetRotY+=.003;
        velX*=.95;velY*=.95;
        targetRotY+=velX;targetRotX+=velY;
      }
      globeGroup.rotation.y+=(targetRotY-globeGroup.rotation.y)*.08;
      globeGroup.rotation.x+=(targetRotX-globeGroup.rotation.x)*.08;

      // Animate ring
      ring.rotation.z=time*.15;
      ring2.rotation.z=-time*.1;

      // Pulse atmosphere
      atmoMat.opacity=.06+Math.sin(time*1.5)*.02;
      atmo2Mat.opacity=.03+Math.sin(time*1.2+1)*.01;

      // Pulse dots
      dotMat.opacity=.5+Math.sin(time*2)*.2;

      renderer.render(scene,camera);
    }
    requestAnimationFrame(anim);
  })();
  new IntersectionObserver(([e])=>{act=e.isIntersecting},{threshold:.1}).observe(wrap);
})();

/* ================================================================
   COUNTER ANIMATION
   ================================================================ */
(function(){
  const counters=document.querySelectorAll('.counter');
  const obs=new IntersectionObserver(entries=>{entries.forEach(e=>{if(!e.isIntersecting)return;const el=e.target;const target=+el.dataset.target;let cur=0;const step=target/60;const inc=()=>{cur=Math.min(cur+step,target);el.textContent=target>=10000?Math.round(cur).toLocaleString():Math.round(cur);if(cur<target)requestAnimationFrame(inc)};inc();obs.unobserve(el)})},{threshold:.5});
  counters.forEach(c=>obs.observe(c));
})();

/* ================================================================
   INTERACTIVE EXPERIENCE (Three.js Reminder Universe)
   ================================================================ */
(function(){
  const section=document.getElementById('interactive');
  const canvas=document.getElementById('interactiveC');
  if(!section||!canvas)return;

  const renderer=new THREE.WebGLRenderer({canvas,alpha:true,antialias:true});
  renderer.setPixelRatio(Math.min(devicePixelRatio,2));
  const scene=new THREE.Scene();
  const camera=new THREE.PerspectiveCamera(50,1,.1,100);
  camera.position.z=14;

  // Lighting
  scene.add(new THREE.AmbientLight(0x404060,.5));
  const dl=new THREE.DirectionalLight(0xffffff,.6);dl.position.set(5,8,5);scene.add(dl);
  scene.add(Object.assign(new THREE.PointLight(0x7c3aed,2,20),{position:new THREE.Vector3(-5,3,5)}));
  scene.add(Object.assign(new THREE.PointLight(0x06b6d4,2,20),{position:new THREE.Vector3(5,-3,5)}));
  scene.add(Object.assign(new THREE.PointLight(0x10b981,1.5,20),{position:new THREE.Vector3(0,5,-5)}));

  const mobile=innerWidth<768;
  const BND={x:8,y:5};

  // Create reminder-themed objects
  const items=[];
  const reminderData=[
    {color:0xe50914,label:'Netflix'},
    {color:0x1DB954,label:'Spotify'},
    {color:0x7c3aed,label:'Insurance'},
    {color:0xf39c12,label:'Electric'},
    {color:0x06b6d4,label:'Phone'},
    {color:0xec4899,label:'Gym'},
    {color:0x38bdf8,label:'Cloud'},
    {color:0x34d399,label:'Rent'},
    {color:0xfbbf24,label:'Internet'},
    {color:0xa78bfa,label:'Streaming'},
    {color:0xf43f5e,label:'Health'},
    {color:0x10b981,label:'Savings'},
  ];

  // Create card-like objects (rounded boxes)
  const cardGeo=new THREE.BoxGeometry(.8,.5,.08,2,2,1);

  // Create floating reminder cards
  const N=mobile?20:40;
  for(let i=0;i<N;i++){
    const data=reminderData[i%reminderData.length];
    const mat=new THREE.MeshStandardMaterial({
      color:data.color,metalness:.2,roughness:.5,
      emissive:data.color,emissiveIntensity:.15,
      transparent:true,opacity:.85
    });
    const mesh=new THREE.Mesh(cardGeo,mat);
    mesh.position.set(
      (Math.random()-.5)*BND.x*1.8,
      (Math.random()-.5)*BND.y*1.5+4,
      (Math.random()-.5)*4
    );
    mesh.rotation.set(Math.random()*.5,Math.random()*.5,Math.random()*.3);

    // Add edge glow
    const edgeGeo=new THREE.BoxGeometry(.82,.52,.09,1,1,1);
    const edgeMat=new THREE.MeshBasicMaterial({
      color:data.color,transparent:true,opacity:.15,wireframe:true
    });
    const edge=new THREE.Mesh(edgeGeo,edgeMat);
    mesh.add(edge);

    scene.add(mesh);
    items.push({
      mesh,
      vx:(Math.random()-.5)*.06,
      vy:0,
      vz:(Math.random()-.5)*.03,
      rx:.3,ry:.25,rz:.04,
      baseY:mesh.position.y,
      phase:Math.random()*Math.PI*2
    });
  }

  // Particle system for connections
  const particleCount=mobile?100:250;
  const pGeo=new THREE.BufferGeometry();
  const pPos=new Float32Array(particleCount*3);
  const pCol=new Float32Array(particleCount*3);
  for(let i=0;i<particleCount;i++){
    pPos[i*3]=(Math.random()-.5)*20;
    pPos[i*3+1]=(Math.random()-.5)*14;
    pPos[i*3+2]=(Math.random()-.5)*8;
    const c=new THREE.Color([0x7c3aed,0x06b6d4,0x10b981][~~(Math.random()*3)]);
    pCol[i*3]=c.r;pCol[i*3+1]=c.g;pCol[i*3+2]=c.b;
  }
  pGeo.setAttribute('position',new THREE.BufferAttribute(pPos,3));
  pGeo.setAttribute('color',new THREE.BufferAttribute(pCol,3));
  const pMat=new THREE.PointsMaterial({size:.04,vertexColors:true,transparent:true,opacity:.4,sizeAttenuation:true});
  scene.add(new THREE.Points(pGeo,pMat));

  // Central glowing sphere (hub)
  const hubGeo=new THREE.SphereGeometry(.4,24,24);
  const hubMat=new THREE.MeshStandardMaterial({
    color:0x7c3aed,emissive:0x7c3aed,emissiveIntensity:.5,
    metalness:.6,roughness:.3,transparent:true,opacity:.6
  });
  const hub=new THREE.Mesh(hubGeo,hubMat);
  scene.add(hub);

  // Hub glow
  const hubGlow=new THREE.Mesh(
    new THREE.SphereGeometry(.6,16,16),
    new THREE.MeshBasicMaterial({color:0x7c3aed,transparent:true,opacity:.08,side:THREE.BackSide})
  );
  scene.add(hubGlow);

  const mw=new THREE.Vector3(),rc=new THREE.Raycaster(),pl=new THREE.Plane(new THREE.Vector3(0,0,1),0);
  function updMouse(){const r=canvas.getBoundingClientRect();const mx=((M.x-r.left)/r.width)*2-1,my=-((M.y-r.top)/r.height)*2+1;rc.setFromCamera(new THREE.Vector2(mx,my),camera);rc.ray.intersectPlane(pl,mw)}

  function resize(){
    const r=section.getBoundingClientRect();
    renderer.setSize(r.width,r.height);
    camera.aspect=r.width/r.height;
    camera.updateProjectionMatrix();
  }
  resize();new ResizeObserver(resize).observe(section);

  const G=.002,FR=.997,BO=.6;
  let act=false,time=0;

  (function anim(){
    if(act){
      time+=.016;
      updMouse();

      // Animate hub
      hub.rotation.y=time*.3;
      hub.rotation.x=Math.sin(time*.5)*.2;
      hubMat.emissiveIntensity=.4+Math.sin(time*2)*.15;
      hubGlow.scale.setScalar(1+Math.sin(time*1.5)*.15);

      for(let i=0;i<items.length;i++){
        const b=items[i];
        b.vy-=G;

        // Mouse repulsion
        const dx=b.mesh.position.x-mw.x,dy=b.mesh.position.y-mw.y;
        const dd=Math.sqrt(dx*dx+dy*dy);
        if(dd<3.5){
          const f=(3.5-dd)*.005;
          b.vx+=dx/dd*f;
          b.vy+=dy/dd*f;
        }

        // Gentle attraction to center
        b.vx+=-b.mesh.position.x*.0002;
        b.vy+=-b.mesh.position.y*.0002;

        b.vx*=FR;b.vy*=FR;b.vz*=FR;
        b.mesh.position.x+=b.vx;
        b.mesh.position.y+=b.vy;
        b.mesh.position.z+=b.vz;

        // Boundaries
        if(b.mesh.position.x>BND.x){b.mesh.position.x=BND.x;b.vx*=-BO}
        if(b.mesh.position.x<-BND.x){b.mesh.position.x=-BND.x;b.vx*=-BO}
        if(b.mesh.position.y<-BND.y){b.mesh.position.y=-BND.y;b.vy*=-BO}
        if(b.mesh.position.y>BND.y+3){b.mesh.position.y=BND.y+3;b.vy*=-BO}
        if(Math.abs(b.mesh.position.z)>3){b.mesh.position.z=Math.sign(b.mesh.position.z)*3;b.vz*=-BO}

        // Collision between items
        for(let j=i+1;j<items.length;j++){
          const b2=items[j];
          const ex=b.mesh.position.x-b2.mesh.position.x;
          const ey=b.mesh.position.y-b2.mesh.position.y;
          const ez=b.mesh.position.z-b2.mesh.position.z;
          const ed=Math.sqrt(ex*ex+ey*ey+ez*ez);
          const md=.7;
          if(ed<md&&ed>0){
            const nx=ex/ed,ny=ey/ed,nz=ez/ed,ov=(md-ed)*.5;
            b.mesh.position.x+=nx*ov;b.mesh.position.y+=ny*ov;b.mesh.position.z+=nz*ov;
            b2.mesh.position.x-=nx*ov;b2.mesh.position.y-=ny*ov;b2.mesh.position.z-=nz*ov;
            const dot=(b.vx-b2.vx)*nx+(b.vy-b2.vy)*ny+(b.vz-b2.vz)*nz;
            if(dot>0){
              b.vx-=dot*nx*BO;b.vy-=dot*ny*BO;b.vz-=dot*nz*BO;
              b2.vx+=dot*nx*BO;b2.vy+=dot*ny*BO;b2.vz+=dot*nz*BO;
            }
          }
        }

        // Rotate cards
        b.mesh.rotation.x+=b.vy*.3;
        b.mesh.rotation.z+=b.vx*.3;
        b.mesh.rotation.y+=.005;
      }

      // Animate particles
      const positions=pGeo.attributes.position.array;
      for(let i=0;i<particleCount;i++){
        positions[i*3+1]-=.005;
        if(positions[i*3+1]<-7){
          positions[i*3]=(Math.random()-.5)*20;
          positions[i*3+1]=7;
          positions[i*3+2]=(Math.random()-.5)*8;
        }
      }
      pGeo.attributes.position.needsUpdate=true;

      renderer.render(scene,camera);
    }
    requestAnimationFrame(anim);
  })();
  new IntersectionObserver(([e])=>{act=e.isIntersecting},{threshold:.05}).observe(section);
})();

/* ================================================================
   BENTO CARD TILT EFFECT
   ================================================================ */
(function(){
  document.querySelectorAll('[data-tilt]').forEach(card=>{
    card.addEventListener('mousemove',e=>{
      const r=card.getBoundingClientRect();
      const x=(e.clientX-r.left)/r.width;
      const y=(e.clientY-r.top)/r.height;
      const tiltX=(y-.5)*-8;
      const tiltY=(x-.5)*8;
      card.style.transform=`perspective(800px) rotateX(${tiltX}deg) rotateY(${tiltY}deg) translateY(-8px)`;
      card.style.setProperty('--mx',(x*100)+'%');
      card.style.setProperty('--my',(y*100)+'%');
    });
    card.addEventListener('mouseleave',()=>{
      card.style.transform='';
    });
  });
})();

/* ================================================================
   PARALLAX BLOBS
   ================================================================ */
(function(){
  const blobs=document.querySelectorAll('.gradient-blob');
  window.addEventListener('scroll',()=>{
    const sy=scrollY;
    blobs.forEach((b,i)=>{
      const speed=.02+i*.008;
      b.style.transform=`translateY(${sy*speed}px)`;
    });
  },{passive:true});
})();




/* ================================================================
   REUSABLE PARTICLE BACKGROUND SYSTEM v2.0
   ================================================================
   Usage: Add data-particles to any section.
   
   Attributes:
     data-particles        = color theme: "purple"|"cyan"|"green"|"mixed"|"gold"|"red"|"white" (default: "mixed")
     data-p-count          = number of particles (default: 80)
     data-p-speed          = movement speed multiplier (default: 0.3)
     data-p-size           = max particle size in px (default: 2)
     data-p-connect        = draw connection lines "true"|"false" (default: "true")
     data-p-connect-dist   = max connection distance in px (default: 100)
     data-p-mouse          = mouse interaction "true"|"false" (default: "true")
     data-p-mouse-radius   = mouse repel/attract radius (default: 120)
     data-p-mouse-mode     = "repel"|"attract"|"glow" (default: "repel")
     data-p-opacity        = base opacity 0-1 (default: 0.5)
     data-p-drift          = gentle floating motion "true"|"false" (default: "true")
     data-p-shape          = "circle"|"square"|"star"|"diamond"|"mix" (default: "circle")
     data-p-pulse          = particles pulse size "true"|"false" (default: "false")
     data-p-depth          = parallax depth layers "true"|"false" (default: "true")
     data-p-glow           = glow effect "true"|"false" (default: "false")
     data-p-direction      = "random"|"up"|"down"|"left"|"right" (default: "random")
   ================================================================ */

(function(){
  'use strict';

  // ---- COLOR THEMES ----
  const THEMES={
    purple:  [{h:265,s:75,l:60},{h:280,s:70,l:55},{h:250,s:80,l:65}],
    cyan:    [{h:190,s:80,l:55},{h:200,s:75,l:60},{h:180,s:85,l:50}],
    green:   [{h:155,s:75,l:50},{h:140,s:70,l:55},{h:170,s:80,l:45}],
    gold:    [{h:45,s:85,l:55},{h:35,s:80,l:50},{h:55,s:90,l:60}],
    red:     [{h:350,s:80,l:55},{h:0,s:75,l:50},{h:340,s:85,l:60}],
    white:   [{h:0,s:0,l:80},{h:0,s:0,l:90},{h:0,s:0,l:70}],
    mixed:   [{h:265,s:75,l:60},{h:190,s:80,l:55},{h:155,s:75,l:50},{h:340,s:80,l:60},{h:45,s:85,l:55}],
  };

  // ---- PARTICLE CLASS ----
  class Particle{
    constructor(cv,cfg){
      this.cv=cv;
      this.cfg=cfg;
      this.reset(true);
    }

    reset(init){
      const w=this.cv.width, h=this.cv.height;
      const dir=this.cfg.direction;

      if(init||dir==='random'){
        this.x=Math.random()*w;
        this.y=Math.random()*h;
      }else if(dir==='up'){
        this.x=Math.random()*w;
        this.y=h+10;
      }else if(dir==='down'){
        this.x=Math.random()*w;
        this.y=-10;
      }else if(dir==='left'){
        this.x=w+10;
        this.y=Math.random()*h;
      }else if(dir==='right'){
        this.x=-10;
        this.y=Math.random()*h;
      }

      // Depth layer (0=far, 1=close)
      this.depth=this.cfg.depth?(.3+Math.random()*.7):1;

      // Size based on depth
      this.baseSize=(Math.random()*this.cfg.size*.6+this.cfg.size*.4)*this.depth;
      this.size=this.baseSize;

      // Velocity
      const spd=this.cfg.speed*this.depth;
      if(dir==='random'){
        this.vx=(Math.random()-.5)*spd*2;
        this.vy=(Math.random()-.5)*spd*2;
      }else if(dir==='up'){
        this.vx=(Math.random()-.5)*spd*.5;
        this.vy=-spd*(Math.random()*.5+.5);
      }else if(dir==='down'){
        this.vx=(Math.random()-.5)*spd*.5;
        this.vy=spd*(Math.random()*.5+.5);
      }else if(dir==='left'){
        this.vx=-spd*(Math.random()*.5+.5);
        this.vy=(Math.random()-.5)*spd*.5;
      }else if(dir==='right'){
        this.vx=spd*(Math.random()*.5+.5);
        this.vy=(Math.random()-.5)*spd*.5;
      }

      // Color from theme
      const palette=THEMES[this.cfg.theme]||THEMES.mixed;
      const c=palette[~~(Math.random()*palette.length)];
      this.hue=c.h;
      this.sat=c.s;
      this.lit=c.l;
      this.alpha=this.cfg.opacity*(this.cfg.depth?this.depth:1)*(Math.random()*.5+.5);

      // Shape
      if(this.cfg.shape==='mix'){
        this.shape=['circle','square','diamond','star'][~~(Math.random()*4)];
      }else{
        this.shape=this.cfg.shape;
      }

      // Drift
      this.driftPhase=Math.random()*Math.PI*2;
      this.driftAmp=Math.random()*15+5;
      this.driftSpeed=Math.random()*.02+.005;
      this.originX=this.x;
      this.originY=this.y;

      // Pulse
      this.pulsePhase=Math.random()*Math.PI*2;
      this.pulseSpeed=Math.random()*.03+.01;
    }

    update(mx,my,time){
      const w=this.cv.width,h=this.cv.height;

      // Base movement
      this.x+=this.vx;
      this.y+=this.vy;

      // Drift (sine wave floating)
      if(this.cfg.drift){
        this.driftPhase+=this.driftSpeed;
        this.x+=Math.sin(this.driftPhase)*this.driftAmp*.003;
        this.y+=Math.cos(this.driftPhase*.7)*this.driftAmp*.003;
      }

      // Pulse size
      if(this.cfg.pulse){
        this.pulsePhase+=this.pulseSpeed;
        this.size=this.baseSize*(1+Math.sin(this.pulsePhase)*.3);
      }

      // Mouse interaction
      if(this.cfg.mouse&&mx!==null){
        const dx=this.x-mx,dy=this.y-my;
        const dist=Math.sqrt(dx*dx+dy*dy);
        const radius=this.cfg.mouseRadius;

        if(dist<radius&&dist>0){
          const force=(radius-dist)/radius;
          const nx=dx/dist,ny=dy/dist;

          if(this.cfg.mouseMode==='repel'){
            this.vx+=nx*force*1.5;
            this.vy+=ny*force*1.5;
          }else if(this.cfg.mouseMode==='attract'){
            this.vx-=nx*force*.8;
            this.vy-=ny*force*.8;
          }
          // glow mode handled in draw
        }
      }

      // Damping
      this.vx*=.99;
      this.vy*=.99;

      // Re-add base velocity to prevent stopping
      const spd=this.cfg.speed*this.depth;
      const dir=this.cfg.direction;
      if(dir==='up')this.vy+=-spd*.002;
      if(dir==='down')this.vy+=spd*.002;
      if(dir==='left')this.vx+=-spd*.002;
      if(dir==='right')this.vx+=spd*.002;

      // Boundary handling
      const pad=20;
      if(dir==='random'){
        if(this.x<-pad)this.x=w+pad;
        if(this.x>w+pad)this.x=-pad;
        if(this.y<-pad)this.y=h+pad;
        if(this.y>h+pad)this.y=-pad;
      }else{
        if(this.x<-pad||this.x>w+pad||this.y<-pad||this.y>h+pad){
          this.reset(false);
        }
      }
    }
  }

  // ---- PARTICLE CANVAS SYSTEM ----
  class ParticleSystem{
    constructor(section){
      this.section=section;
      this.canvas=document.createElement('canvas');
      this.canvas.style.cssText='position:absolute;top:0;left:0;width:100%;height:100%;pointer-events:none;z-index:0;';
      this.ctx=this.canvas.getContext('2d');
      this.particles=[];
      this.mx=null;
      this.my=null;
      this.active=false;
      this.time=0;
      this.dpr=Math.min(devicePixelRatio,2);

      // Parse config from data attributes
      this.cfg={
        theme:    section.dataset.particles||'mixed',
        count:    parseInt(section.dataset.pCount)||80,
        speed:    parseFloat(section.dataset.pSpeed)||.3,
        size:     parseFloat(section.dataset.pSize)||6,
        connect:  section.dataset.pConnect!=='false',
        connectDist:parseInt(section.dataset.pConnectDist)||100,
        mouse:    section.dataset.pMouse!=='false',
        mouseRadius:parseInt(section.dataset.pMouseRadius)||120,
        mouseMode:section.dataset.pMouseMode||'repel',
        opacity:  parseFloat(section.dataset.pOpacity)||.5,
        drift:    section.dataset.pDrift!=='false',
        shape:    section.dataset.pShape||'circle',
        pulse:    section.dataset.pPulse==='true',
        depth:    section.dataset.pDepth!=='true',
        glow:     section.dataset.pGlow==='true',
        direction:section.dataset.pDirection||'random',
      };

      this.init();
    }

    init(){
      // Ensure section has relative positioning
      const pos=getComputedStyle(this.section).position;
      if(pos==='static')this.section.style.position='relative';

      // Insert canvas as first child
      this.section.insertBefore(this.canvas,this.section.firstChild);

      this.resize();
      this.createParticles();
      this.bindEvents();
      this.animate();
    }

    resize(){
      const r=this.section.getBoundingClientRect();
      this.canvas.width=r.width*this.dpr;
      this.canvas.height=r.height*this.dpr;
      this.ctx.scale(this.dpr,this.dpr);
      this.w=r.width;
      this.h=r.height;
    }

    createParticles(){
      // Scale count based on screen area
      const area=this.w*this.h;
      const scale=Math.min(area/(1920*1080),1.5);
      const count=Math.round(this.cfg.count*scale);

      this.particles=[];
      for(let i=0;i<count;i++){
        this.particles.push(new Particle(this.canvas,this.cfg));
      }
    }

    bindEvents(){
      // Mouse tracking relative to section
      this.section.addEventListener('mousemove',e=>{
        const r=this.section.getBoundingClientRect();
        this.mx=(e.clientX-r.left)*this.dpr;
        this.my=(e.clientY-r.top)*this.dpr;
      });
      this.section.addEventListener('mouseleave',()=>{
        this.mx=null;this.my=null;
      });

      // Touch
      this.section.addEventListener('touchmove',e=>{
        const r=this.section.getBoundingClientRect();
        this.mx=(e.touches[0].clientX-r.left)*this.dpr;
        this.my=(e.touches[0].clientY-r.top)*this.dpr;
      },{passive:true});
      this.section.addEventListener('touchend',()=>{
        this.mx=null;this.my=null;
      });

      // Resize
      new ResizeObserver(()=>{
        this.resize();
        this.createParticles();
      }).observe(this.section);

      // Visibility
      new IntersectionObserver(([e])=>{
        this.active=e.isIntersecting;
      },{threshold:.05}).observe(this.section);
    }

    drawParticle(p){
      const ctx=this.ctx;
      const x=p.x/this.dpr,y=p.y/this.dpr;
      const s=p.size;
      let alpha=p.alpha;

      // Mouse glow mode
      if(this.cfg.mouseMode==='glow'&&this.mx!==null){
        const dx=p.x-this.mx,dy=p.y-this.my;
        const dist=Math.sqrt(dx*dx+dy*dy);
        if(dist<this.cfg.mouseRadius*this.dpr){
          const boost=(this.cfg.mouseRadius*this.dpr-dist)/(this.cfg.mouseRadius*this.dpr);
          alpha=Math.min(alpha+boost*.5,1);
        }
      }

      ctx.save();
      ctx.globalAlpha=alpha;

      // Glow effect
      if(this.cfg.glow){
        ctx.shadowBlur=s*4;
        ctx.shadowColor=`hsla(${p.hue},${p.sat}%,${p.lit}%,.5)`;
      }

      ctx.fillStyle=`hsl(${p.hue},${p.sat}%,${p.lit}%)`;

      switch(p.shape){
        case 'circle':
          ctx.beginPath();
          ctx.arc(x,y,s,0,Math.PI*2);
          ctx.fill();
          break;

        case 'square':
          ctx.fillRect(x-s,y-s,s*2,s*2);
          break;

        case 'diamond':
          ctx.beginPath();
          ctx.moveTo(x,y-s*1.3);
          ctx.lineTo(x+s,y);
          ctx.lineTo(x,y+s*1.3);
          ctx.lineTo(x-s,y);
          ctx.closePath();
          ctx.fill();
          break;

        case 'star':
          ctx.beginPath();
          for(let i=0;i<5;i++){
            const a=(i*4*Math.PI/5)-Math.PI/2;
            const r1=s*1.3,r2=s*.5;
            ctx.lineTo(x+Math.cos(a)*r1,y+Math.sin(a)*r1);
            const a2=a+2*Math.PI/10;
            ctx.lineTo(x+Math.cos(a2)*r2,y+Math.sin(a2)*r2);
          }
          ctx.closePath();
          ctx.fill();
          break;
      }
      ctx.restore();
    }

    drawConnections(){
      const ctx=this.ctx;
      const maxDist=this.cfg.connectDist*this.dpr;
      const particles=this.particles;
      const len=particles.length;

      for(let i=0;i<len;i++){
        for(let j=i+1;j<len;j++){
          const a=particles[i],b=particles[j];
          const dx=a.x-b.x,dy=a.y-b.y;
          const dist=dx*dx+dy*dy;
          const maxD2=maxDist*maxDist;

          if(dist<maxD2){
            const alpha=(1-dist/maxD2)*this.cfg.opacity*.3*Math.min(a.depth,b.depth);
            if(alpha<.01)continue;

            ctx.save();
            ctx.globalAlpha=alpha;
            ctx.strokeStyle=`hsl(${a.hue},${a.sat}%,${a.lit}%)`;
            ctx.lineWidth=.5;
            ctx.beginPath();
            ctx.moveTo(a.x/this.dpr,a.y/this.dpr);
            ctx.lineTo(b.x/this.dpr,b.y/this.dpr);
            ctx.stroke();
            ctx.restore();
          }
        }
      }

      // Mouse connections
      if(this.cfg.mouse&&this.mx!==null){
        for(let i=0;i<len;i++){
          const p=particles[i];
          const dx=p.x-this.mx,dy=p.y-this.my;
          const dist=Math.sqrt(dx*dx+dy*dy);
          const radius=this.cfg.mouseRadius*this.dpr*1.5;

          if(dist<radius){
            const alpha=(1-dist/radius)*this.cfg.opacity*.4;
            ctx.save();
            ctx.globalAlpha=alpha;
            ctx.strokeStyle=`hsl(${p.hue},${p.sat}%,${p.lit}%)`;
            ctx.lineWidth=.8;
            ctx.beginPath();
            ctx.moveTo(p.x/this.dpr,p.y/this.dpr);
            ctx.lineTo(this.mx/this.dpr,this.my/this.dpr);
            ctx.stroke();
            ctx.restore();
          }
        }
      }
    }

    animate(){
      const loop=()=>{
        if(this.active){
          this.time+=.016;
          this.ctx.clearRect(0,0,this.w,this.h);

          // Update all particles
          for(let i=0;i<this.particles.length;i++){
            this.particles[i].update(this.mx,this.my,this.time);
          }

          // Draw connections first (behind particles)
          if(this.cfg.connect){
            this.drawConnections();
          }

          // Draw particles
          for(let i=0;i<this.particles.length;i++){
            this.drawParticle(this.particles[i]);
          }
        }
        requestAnimationFrame(loop);
      };
      loop();
    }
  }

  // ---- AUTO-INITIALIZE ----
  function init(){
    document.querySelectorAll('[data-particles]').forEach(section=>{
      new ParticleSystem(section);
    });
  }

  if(document.readyState==='loading'){
    document.addEventListener('DOMContentLoaded',init);
  }else{
    init();
  }

})();

(function () {
  'use strict';

  // ═══════════════════════════════════════════════════
  //  CONFIG — tweak these to your liking
  // ═══════════════════════════════════════════════════
  var LERP         = 0.095;   // lower = smoother (0.03 butter, 0.12 snappy)
  var WHEEL_SPEED  = 1;       // mouse wheel multiplier
  var TOUCH_SPEED  = 1.5;     // mobile swipe multiplier
  var KEY_STEP     = 120;     // px per arrow key press
  var SNAP         = 0.5;     // snap-to-target threshold (px)
  var SCROLLBAR    = true;    // show custom scrollbar

  // ═══════════════════════════════════════════════════
  //  STATE
  // ═══════════════════════════════════════════════════
  var wrapper, content, bar, thumb;
  var target = 0, current = 0, max = 0, vh = 0;
  var touchLastY = 0;
  var resizeTimer;
  var dragging = false, dragY = 0, dragScroll = 0;

  function clamp(v, lo, hi) {
    return v < lo ? lo : v > hi ? hi : v;
  }

  // ═══════════════════════════════════════════════════
  //  MEASURE CONTENT
  // ═══════════════════════════════════════════════════
  function measure() {
    vh = window.innerHeight;
    max = Math.max(0, content.scrollHeight - vh);
    target = clamp(target, 0, max);
    current = clamp(current, 0, max);

    if (SCROLLBAR && thumb) {
      var ratio = vh / content.scrollHeight;
      if (ratio >= 1) {
        bar.style.opacity = '0';
        bar.style.pointerEvents = 'none';
      } else {
        bar.style.opacity = '';
        bar.style.pointerEvents = '';
        thumb.style.height = Math.max(30, vh * ratio) + 'px';
      }
    }
  }

  // ═══════════════════════════════════════════════════
  //  RENDER LOOP
  // ═══════════════════════════════════════════════════
  function tick() {
    current += (target - current) * LERP;

    if (Math.abs(current - target) < SNAP) {
      current = target;
    }

    content.style.transform = 'translate3d(0,' + -current + 'px,0)';

    // scrollbar thumb
    if (SCROLLBAR && thumb && max > 0) {
      var h = parseFloat(thumb.style.height) || 30;
      var space = vh - h;
      thumb.style.transform = 'translateY(' + (current / max * space) + 'px)';
    }

    // expose for other scripts
    window.__smoothScrollY = current;

    requestAnimationFrame(tick);
  }

  // ═══════════════════════════════════════════════════
  //  WHEEL
  // ═══════════════════════════════════════════════════
  function onWheel(e) {
    e.preventDefault();
    target = clamp(target + e.deltaY * WHEEL_SPEED, 0, max);
  }

  // ═══════════════════════════════════════════════════
  //  TOUCH
  // ═══════════════════════════════════════════════════
  function onTouchStart(e) {
    touchLastY = e.touches[0].clientY;
  }

  function onTouchMove(e) {
    var y = e.touches[0].clientY;
    target = clamp(target + (touchLastY - y) * TOUCH_SPEED, 0, max);
    touchLastY = y;
    e.preventDefault();
  }

  // ═══════════════════════════════════════════════════
  //  KEYBOARD
  // ═══════════════════════════════════════════════════
  function onKeyDown(e) {
    // don't hijack if user is typing in input/textarea
    var tag = (e.target.tagName || '').toLowerCase();
    if (tag === 'input' || tag === 'textarea' || tag === 'select' || e.target.isContentEditable) return;

    var d = 0;
    switch (e.key) {
      case 'ArrowUp':   d = -KEY_STEP; break;
      case 'ArrowDown': d =  KEY_STEP; break;
      case 'PageUp':    d = -vh;       break;
      case 'PageDown':  d =  vh;       break;
      case 'Home':      target = 0;    e.preventDefault(); return;
      case 'End':       target = max;  e.preventDefault(); return;
      case ' ':
        d = e.shiftKey ? -vh * 0.8 : vh * 0.8;
        e.preventDefault();
        break;
      default: return;
    }
    target = clamp(target + d, 0, max);
    e.preventDefault();
  }

  // ═══════════════════════════════════════════════════
  //  RESIZE
  // ═══════════════════════════════════════════════════
  function onResize() {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(measure, 150);
  }

  // ═══════════════════════════════════════════════════
  //  ANCHOR LINKS
  // ═══════════════════════════════════════════════════
  function onAnchorClick(e) {
    var link = e.target.closest && e.target.closest('a[href^="#"]');
    if (!link) return;
    var href = link.getAttribute('href');
    if (!href || href === '#') return;
    try {
      var el = document.querySelector(href);
      if (!el) return;
      e.preventDefault();
      target = clamp(current + el.getBoundingClientRect().top, 0, max);
    } catch (err) { /* invalid selector */ }
  }


})();
