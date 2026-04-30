<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>RemindMe — Advanced Loaders</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,400&family=DM+Mono:wght@300;400;500&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        fontFamily: {
          sans: ['Plus Jakarta Sans', 'system-ui', 'sans-serif'],
          mono: ['DM Mono', 'monospace'],
        }
      }
    }
  }
</script>
<!-- Libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cannon.js/0.6.2/cannon.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
<style>
  *, *::before, *::after { box-sizing: border-box; }
  body { background: #f7f5f0; }
  canvas { display: block; }
  .loader-stage { position: relative; width: 100%; height: 260px; overflow: hidden; }
  .loader-stage canvas { position: absolute; inset: 0; width: 100% !important; height: 100% !important; }
  .card { transition: transform 0.25s ease, box-shadow 0.25s ease; }
  .card:hover { transform: translateY(-4px); box-shadow: 0 16px 48px rgba(0,0,0,0.1) !important; }
  .tag { display: inline-flex; align-items: center; gap: 6px; }
  /* GSAP card inner */
  #gsap-list .task-row { will-change: transform, opacity; }
  .strike { text-decoration: line-through; }
</style>
</head>
<body class="min-h-screen font-sans">

<!-- ═══ HEADER ═══ -->
<header class="bg-white border-b border-stone-200/80 px-6 pt-10 pb-8 text-center relative overflow-hidden">
  <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse 70% 100% at 50% 140%, rgba(249,115,22,0.07) 0%, transparent 70%);"></div>
  <div class="relative">
    <span class="tag bg-orange-50 text-orange-600 border border-orange-200 rounded-full px-4 py-1.5 text-xs font-bold tracking-widest uppercase mb-5">
      🔔 RemindMe App
    </span>
    <h1 class="mt-3 text-4xl md:text-5xl font-extrabold text-stone-900 tracking-tight leading-none">
      Advanced <em class="not-italic text-orange-500">Loading</em> States
    </h1>
    <p class="mt-3 font-mono text-xs text-stone-400 tracking-widest uppercase">
      Three.js &nbsp;·&nbsp; GSAP &nbsp;·&nbsp; Cannon.js &nbsp;·&nbsp; Anime.js &nbsp;·&nbsp; WebGL GLSL
    </p>
  </div>
</header>

<!-- ═══ GRID ═══ -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5 p-5 max-w-7xl mx-auto">

  <!-- ── CARD 1: Three.js ── -->
  <div class="card bg-white rounded-2xl border border-stone-200 shadow-sm overflow-hidden flex flex-col">
    <div class="h-[3px] bg-gradient-to-r from-orange-400 via-amber-400 to-orange-300"></div>
    <div class="loader-stage" id="stage-1">
      <canvas id="c1"></canvas>
      <div class="absolute bottom-3 left-0 right-0 flex justify-center pointer-events-none">
        <span class="font-mono text-[10px] text-orange-400 bg-orange-50 border border-orange-100 rounded-full px-3 py-0.5 tracking-wider">syncing reminders…</span>
      </div>
    </div>
    <div class="p-4 border-t border-stone-100">
      <div class="flex items-start justify-between gap-2">
        <div>
          <h3 class="font-bold text-stone-800 text-sm">Orbital Notification Ring</h3>
          <p class="font-mono text-[11px] text-stone-400 mt-0.5">Three.js · Particle trails · Phong shading · Torus orbit</p>
        </div>
        <span class="font-mono text-xs bg-orange-50 text-orange-400 border border-orange-100 rounded-lg px-2 py-0.5 shrink-0">01</span>
      </div>
    </div>
  </div>

  <!-- ── CARD 2: Anime.js ── -->
  <div class="card bg-white rounded-2xl border border-stone-200 shadow-sm overflow-hidden flex flex-col">
    <div class="h-[3px] bg-gradient-to-r from-green-400 via-emerald-400 to-teal-400"></div>
    <div class="loader-stage" id="stage-2">
      <canvas id="c2"></canvas>
      <div class="absolute bottom-3 left-0 right-0 flex justify-center pointer-events-none">
        <span class="font-mono text-[10px] text-emerald-500 bg-emerald-50 border border-emerald-100 rounded-full px-3 py-0.5 tracking-wider">tasks completed…</span>
      </div>
    </div>
    <div class="p-4 border-t border-stone-100">
      <div class="flex items-start justify-between gap-2">
        <div>
          <h3 class="font-bold text-stone-800 text-sm">Particle Checkmark Morph</h3>
          <p class="font-mono text-[11px] text-stone-400 mt-0.5">Anime.js · Canvas 2D · Stagger ease · Particle swarm</p>
        </div>
        <span class="font-mono text-xs bg-emerald-50 text-emerald-500 border border-emerald-100 rounded-lg px-2 py-0.5 shrink-0">02</span>
      </div>
    </div>
  </div>

  <!-- ── CARD 3: GSAP ── -->
  <div class="card bg-white rounded-2xl border border-stone-200 shadow-sm overflow-hidden flex flex-col">
    <div class="h-[3px] bg-gradient-to-r from-blue-400 via-indigo-400 to-violet-400"></div>
    <div class="loader-stage flex items-center justify-center px-6 py-4" id="stage-3">
      <div id="gsap-list" class="w-full max-w-xs space-y-2.5"></div>
    </div>
    <div class="p-4 border-t border-stone-100">
      <div class="flex items-start justify-between gap-2">
        <div>
          <h3 class="font-bold text-stone-800 text-sm">Spring Checklist Cascade</h3>
          <p class="font-mono text-[11px] text-stone-400 mt-0.5">GSAP · Elastic.out · Stagger timeline · DOM morph</p>
        </div>
        <span class="font-mono text-xs bg-blue-50 text-blue-500 border border-blue-100 rounded-lg px-2 py-0.5 shrink-0">03</span>
      </div>
    </div>
  </div>

  <!-- ── CARD 4: Cannon.js ── -->
  <div class="card bg-white rounded-2xl border border-stone-200 shadow-sm overflow-hidden flex flex-col">
    <div class="h-[3px] bg-gradient-to-r from-violet-400 via-purple-400 to-fuchsia-400"></div>
    <div class="loader-stage" id="stage-4">
      <canvas id="c4"></canvas>
    </div>
    <div class="p-4 border-t border-stone-100">
      <div class="flex items-start justify-between gap-2">
        <div>
          <h3 class="font-bold text-stone-800 text-sm">Physics Task Inbox</h3>
          <p class="font-mono text-[11px] text-stone-400 mt-0.5">Cannon.js · Rigid bodies · Gravity · Collision response</p>
        </div>
        <span class="font-mono text-xs bg-violet-50 text-violet-500 border border-violet-100 rounded-lg px-2 py-0.5 shrink-0">04</span>
      </div>
    </div>
  </div>

  <!-- ── CARD 5: WebGL ── -->
  <div class="card bg-white rounded-2xl border border-stone-200 shadow-sm overflow-hidden flex flex-col">
    <div class="h-[3px] bg-gradient-to-r from-rose-400 via-pink-400 to-fuchsia-400"></div>
    <div class="loader-stage" id="stage-5">
      <canvas id="c5"></canvas>
      <div id="shader-overlay" class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
          <path d="M12 2C9.24 2 7 4.69 7 8V14.5H17V8C17 4.69 14.76 2 12 2Z" fill="#ec4899" opacity="0.9"/>
          <rect x="9" y="14.5" width="6" height="2.5" rx="1.2" fill="#ec4899" opacity="0.6"/>
          <path d="M10.5 18.5C10.5 19.33 11.17 20 12 20C12.83 20 13.5 19.33 13.5 18.5" stroke="#ec4899" stroke-width="1.5" fill="none" stroke-linecap="round"/>
          <circle cx="12" cy="2.8" r="1.2" fill="#ec4899"/>
        </svg>
        <div id="pct-label" class="font-mono text-sm font-bold mt-1" style="color:#ec4899">0%</div>
        <div class="font-mono text-[10px] text-stone-400 mt-0.5 tracking-wider">loading</div>
      </div>
    </div>
    <div class="p-4 border-t border-stone-100">
      <div class="flex items-start justify-between gap-2">
        <div>
          <h3 class="font-bold text-stone-800 text-sm">GLSL Countdown Timer Ring</h3>
          <p class="font-mono text-[11px] text-stone-400 mt-0.5">WebGL · Fragment shader · SDF ring · Glow pass · Tick marks</p>
        </div>
        <span class="font-mono text-xs bg-rose-50 text-rose-400 border border-rose-100 rounded-lg px-2 py-0.5 shrink-0">05</span>
      </div>
    </div>
  </div>

</div>

<!-- ═══════════════════════════════════
     SCRIPTS
═══════════════════════════════════ -->
<script>
window.addEventListener('load', () => {
  initThreeJS();
  initAnimeJS();
  initGSAP();
  initCannon();
  initWebGL();
});

/* ════════════════════════════════════════════
   LOADER 1 — THREE.JS  Orbital Ring + Particles
════════════════════════════════════════════ */
function initThreeJS() {
  const stage = document.getElementById('stage-1');
  const canvas = document.getElementById('c1');
  let W = stage.clientWidth, H = stage.clientHeight;
  canvas.width = W; canvas.height = H;

  const scene = new THREE.Scene();
  const cam = new THREE.PerspectiveCamera(52, W / H, 0.1, 100);
  cam.position.set(0, 1.2, 6);
  cam.lookAt(0, 0, 0);

  const renderer = new THREE.WebGLRenderer({ canvas, antialias: true, alpha: true });
  renderer.setPixelRatio(Math.min(devicePixelRatio, 2));
  renderer.setSize(W, H);
  renderer.setClearColor(0xffffff, 0);

  // Central torus (the "ring" of the notification)
  const torusMat = new THREE.MeshPhongMaterial({
    color: 0xf97316, shininess: 140,
    specular: 0xffd480, emissive: 0x7a2200, emissiveIntensity: 0.12
  });
  const torus = new THREE.Mesh(new THREE.TorusGeometry(1.2, 0.14, 20, 120), torusMat);
  scene.add(torus);

  // Inner fill ring (thinner, lighter)
  const innerRing = new THREE.Mesh(
    new THREE.TorusGeometry(0.85, 0.05, 12, 80),
    new THREE.MeshBasicMaterial({ color: 0xfbbf24, transparent: true, opacity: 0.35 })
  );
  scene.add(innerRing);

  // Wireframe outer sphere
  const wireMesh = new THREE.Mesh(
    new THREE.SphereGeometry(2.6, 14, 10),
    new THREE.MeshBasicMaterial({ color: 0xf97316, wireframe: true, transparent: true, opacity: 0.04 })
  );
  scene.add(wireMesh);

  // 3 orbiting notification spheres
  const orbColors = [0xf97316, 0x3b82f6, 0x22c55e];
  const orbSpeeds = [0.022, -0.015, 0.011];
  const orbInclinations = [0, Math.PI / 2.8, Math.PI / 1.6];
  const orbRadius = 1.85;
  const orbiters = orbColors.map((col, i) => {
    const mesh = new THREE.Mesh(
      new THREE.SphereGeometry(0.14, 20, 20),
      new THREE.MeshPhongMaterial({ color: col, emissive: col, emissiveIntensity: 0.25, shininess: 180 })
    );
    mesh.userData = { angle: (i / 3) * Math.PI * 2, speed: orbSpeeds[i], inc: orbInclinations[i] };
    scene.add(mesh);

    // Trail particles for this orbiter
    const trailCount = 18;
    const trailGeo = new THREE.BufferGeometry();
    const trailPos = new Float32Array(trailCount * 3);
    trailGeo.setAttribute('position', new THREE.BufferAttribute(trailPos, 3));
    const trail = new THREE.Points(trailGeo, new THREE.PointsMaterial({
      color: col, size: 0.045, transparent: true, opacity: 0.5, sizeAttenuation: true
    }));
    scene.add(trail);
    mesh.userData.trail = trail;
    mesh.userData.trailPositions = trailPos;
    mesh.userData.trailIndex = 0;
    return mesh;
  });

  // Background particle field
  const fieldCount = 280;
  const fieldPos = new Float32Array(fieldCount * 3);
  for (let i = 0; i < fieldCount; i++) {
    const th = Math.random() * Math.PI * 2, ph = Math.acos(2 * Math.random() - 1);
    const r = 2.2 + Math.random() * 1.8;
    fieldPos[i * 3] = r * Math.sin(ph) * Math.cos(th);
    fieldPos[i * 3 + 1] = r * Math.sin(ph) * Math.sin(th);
    fieldPos[i * 3 + 2] = r * Math.cos(ph);
  }
  const fieldGeo = new THREE.BufferGeometry();
  fieldGeo.setAttribute('position', new THREE.BufferAttribute(fieldPos, 3));
  const field = new THREE.Points(fieldGeo, new THREE.PointsMaterial({
    color: 0xf97316, size: 0.04, transparent: true, opacity: 0.4, sizeAttenuation: true
  }));
  scene.add(field);

  // Lights
  scene.add(new THREE.AmbientLight(0xfff8ef, 0.85));
  const key = new THREE.PointLight(0xffcc66, 2.2, 20);
  key.position.set(4, 4, 4);
  scene.add(key);
  const fill = new THREE.PointLight(0x66aaff, 0.6, 15);
  fill.position.set(-4, -2, 2);
  scene.add(fill);
  const rim = new THREE.PointLight(0xff8833, 0.9, 10);
  rim.position.set(0, -4, -3);
  scene.add(rim);

  let t = 0;
  (function tick() {
    requestAnimationFrame(tick);
    t += 0.016;

    torus.rotation.y += 0.006;
    torus.rotation.x = Math.sin(t * 0.4) * 0.18;
    innerRing.rotation.y -= 0.01;
    wireMesh.rotation.y += 0.003;
    wireMesh.rotation.x += 0.001;
    field.rotation.y += 0.0018;

    orbiters.forEach(orb => {
      const d = orb.userData;
      d.angle += d.speed;
      const cos = Math.cos(d.inc), sin = Math.sin(d.inc);
      const x = orbRadius * Math.cos(d.angle);
      const y = orbRadius * Math.sin(d.angle) * cos;
      const z = orbRadius * Math.sin(d.angle) * sin;
      orb.position.set(x, y, z);

      // Write to trail
      const tp = d.trailPositions;
      const ti = (d.trailIndex * 3) % tp.length;
      tp[ti] = x; tp[ti + 1] = y; tp[ti + 2] = z;
      d.trailIndex = (d.trailIndex + 1) % 18;
      d.trail.geometry.attributes.position.needsUpdate = true;
    });

    key.position.x = Math.sin(t * 0.35) * 5;
    key.position.z = Math.cos(t * 0.35) * 5;

    renderer.render(scene, cam);
  })();

  new ResizeObserver(() => {
    W = stage.clientWidth; H = stage.clientHeight;
    cam.aspect = W / H; cam.updateProjectionMatrix();
    renderer.setSize(W, H);
  }).observe(stage);
}

/* ════════════════════════════════════════════
   LOADER 2 — ANIME.JS  Particle Checkmark Morph
════════════════════════════════════════════ */
function initAnimeJS() {
  const stage = document.getElementById('stage-2');
  const canvas = document.getElementById('c2');
  let W = stage.clientWidth, H = stage.clientHeight;
  canvas.width = W; canvas.height = H;
  const ctx = canvas.getContext('2d');

  const N = 110;
  const GREENS = ['#22c55e','#16a34a','#4ade80','#86efac','#34d399','#6ee7b7','#bbf7d0'];

  // Build checkmark target points
  function checkPts(cx, cy, sz) {
    const pts = [];
    const lx1 = cx - sz * 0.48, ly1 = cy - sz * 0.02;
    const mx = cx - sz * 0.08, my = cy + sz * 0.38;
    const rx2 = cx + sz * 0.52, ry2 = cy - sz * 0.48;
    const n1 = Math.round(N * 0.38);
    const n2 = N - n1;
    for (let i = 0; i < n1; i++) {
      const t = i / n1;
      pts.push({ x: lx1 + (mx - lx1) * t, y: ly1 + (my - ly1) * t });
    }
    for (let i = 0; i < n2; i++) {
      const t = i / n2;
      pts.push({ x: mx + (rx2 - mx) * t, y: my + (ry2 - my) * t });
    }
    return pts;
  }

  let cpts = checkPts(W / 2, H / 2, Math.min(W, H) * 0.3);

  const particles = Array.from({ length: N }, (_, i) => ({
    x: Math.random() * W,
    y: Math.random() * H,
    tx: cpts[i].x, ty: cpts[i].y,
    r: 2.8 + Math.random() * 2.5,
    color: GREENS[i % GREENS.length],
    alpha: 0.9
  }));

  function scatter() {
    const tgts = particles.map(() => ({ x: Math.random() * W, y: Math.random() * H }));
    anime({ targets: particles, x: (_, i) => tgts[i].x, y: (_, i) => tgts[i].y,
      alpha: 0.25, duration: 800, easing: 'easeInCubic', complete: gather });
  }

  function gather() {
    anime({ targets: particles,
      x: (_, i) => cpts[i].x, y: (_, i) => cpts[i].y,
      alpha: 1, r: (_, i) => 2.8 + (i % 3) * 1.2,
      duration: 1100, easing: 'easeOutElastic(1, 0.55)',
      delay: anime.stagger(10, { from: 'center' }),
      complete: () => setTimeout(scatter, 2000)
    });
  }

  gather();

  (function draw() {
    requestAnimationFrame(draw);
    ctx.clearRect(0, 0, W, H);
    // Soft bg glow
    const g = ctx.createRadialGradient(W/2,H/2,0,W/2,H/2,Math.min(W,H)*0.45);
    g.addColorStop(0, 'rgba(34,197,94,0.05)');
    g.addColorStop(1, 'rgba(34,197,94,0)');
    ctx.fillStyle = g; ctx.fillRect(0,0,W,H);

    particles.forEach(p => {
      ctx.save();
      ctx.globalAlpha = p.alpha;
      ctx.fillStyle = p.color;
      ctx.shadowColor = p.color;
      ctx.shadowBlur = 10;
      ctx.beginPath();
      ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
      ctx.fill();
      ctx.restore();
    });
  })();

  new ResizeObserver(() => {
    W = stage.clientWidth; H = stage.clientHeight;
    canvas.width = W; canvas.height = H;
    cpts = checkPts(W/2, H/2, Math.min(W,H)*0.3);
    particles.forEach((p, i) => { p.tx = cpts[i].x; p.ty = cpts[i].y; });
  }).observe(stage);
}

/* ════════════════════════════════════════════
   LOADER 3 — GSAP  Spring Checklist
════════════════════════════════════════════ */
function initGSAP() {
  const list = document.getElementById('gsap-list');
  const items = [
    { label: 'Morning standup',    time: '9:00 AM',  color: '#3b82f6', bg: '#eff6ff', urgent: true  },
    { label: 'Review pull requests', time: '11:30',  color: '#6366f1', bg: '#eef2ff', urgent: false },
    { label: 'Client sync call',   time: '2:00 PM',  color: '#f97316', bg: '#fff7ed', urgent: true  },
    { label: 'Submit weekly log',  time: 'EOD',      color: '#22c55e', bg: '#f0fdf4', urgent: false },
  ];

  // Build DOM once
  items.forEach((item, i) => {
    const row = document.createElement('div');
    row.className = 'task-row flex items-center gap-3 rounded-xl px-3.5 py-2.5 border';
    row.style.cssText = `opacity:0;transform:translateX(-36px);background:${item.bg};border-color:${item.color}22;`;
    row.innerHTML = `
      <div class="chk w-5 h-5 rounded-md border-2 flex-shrink-0 flex items-center justify-center transition-all" 
           style="border-color:${item.color}">
        <svg class="chk-svg w-3 h-3 opacity-0" viewBox="0 0 12 10" fill="none">
          <polyline class="chk-line" points="1,5 4.5,8.5 11,1.5" stroke="white" stroke-width="2.2"
            stroke-linecap="round" stroke-linejoin="round"
            stroke-dasharray="18" stroke-dashoffset="18"/>
        </svg>
      </div>
      <span class="task-lbl flex-1 text-xs font-semibold text-stone-700 leading-tight">${item.label}</span>
      <span class="font-mono text-[10px] px-2 py-0.5 rounded-md font-medium"
            style="background:${item.color}18;color:${item.color}">${item.time}</span>`;
    list.appendChild(row);
  });

  function run() {
    const rows  = list.querySelectorAll('.task-row');
    const chks  = list.querySelectorAll('.chk');
    const svgs  = list.querySelectorAll('.chk-svg');
    const lines = list.querySelectorAll('.chk-line');
    const lbls  = list.querySelectorAll('.task-lbl');

    const tl = gsap.timeline({ onComplete: () => setTimeout(reset, 1400) });

    // Slide rows in
    tl.to(rows, { opacity: 1, x: 0, duration: 0.55,
      ease: 'elastic.out(1, 0.65)', stagger: 0.16 });

    // Check first 3 tasks
    [0, 1, 2].forEach(idx => {
      tl.to(chks[idx], {
        backgroundColor: items[idx].color, borderColor: items[idx].color,
        scale: 1.2, duration: 0.18, ease: 'back.out(2)'
      }, `>+0.28`)
      .to(chks[idx], { scale: 1, duration: 0.12 }, '>')
      .to(svgs[idx], { opacity: 1, duration: 0.1 }, '<')
      .to(lines[idx], { strokeDashoffset: 0, duration: 0.22, ease: 'power2.out' }, '<')
      .to(lbls[idx], { opacity: 0.42, duration: 0.2 }, '<+0.08')
      .call(() => { lbls[idx].classList.add('strike'); }, [], '<');
    });

    // Last item pulses (pending)
    tl.to(rows[3], {
      boxShadow: `0 0 0 3px ${items[3].color}44`,
      duration: 0.35, repeat: 4, yoyo: true, ease: 'power1.inOut'
    }, '>+0.2');
  }

  function reset() {
    const rows  = list.querySelectorAll('.task-row');
    const chks  = list.querySelectorAll('.chk');
    const svgs  = list.querySelectorAll('.chk-svg');
    const lines = list.querySelectorAll('.chk-line');
    const lbls  = list.querySelectorAll('.task-lbl');

    gsap.to(rows, {
      opacity: 0, x: -36, duration: 0.35, stagger: 0.07, ease: 'power2.in',
      onComplete: () => {
        chks.forEach((c, i) => {
          c.style.backgroundColor = '';
          c.style.borderColor = items[i].color;
          c.style.boxShadow = '';
        });
        svgs.forEach(s => s.style.opacity = '0');
        lines.forEach(l => { l.style.strokeDashoffset = '18'; });
        lbls.forEach(l => { l.style.opacity = '1'; l.classList.remove('strike'); });
        setTimeout(run, 350);
      }
    });
  }

  run();
}

/* ════════════════════════════════════════════
   LOADER 4 — CANNON.JS  Physics Task Inbox
════════════════════════════════════════════ */
function initCannon() {
  const stage = document.getElementById('stage-4');
  const canvas = document.getElementById('c4');
  let W = stage.clientWidth, H = stage.clientHeight;
  canvas.width = W; canvas.height = H;
  const ctx = canvas.getContext('2d');

  const SCALE = 42;
  const BALL_R = 0.52;
  const px = x => W / 2 + x * SCALE;
  const py = y => H - 36 - y * SCALE;

  const world = new CANNON.World();
  world.gravity.set(0, -22, 0);
  world.broadphase = new CANNON.NaiveBroadphase();
  world.solver.iterations = 12;

  // Ground
  const ground = new CANNON.Body({ mass: 0 });
  ground.addShape(new CANNON.Plane());
  ground.quaternion.setFromAxisAngle(new CANNON.Vec3(1, 0, 0), -Math.PI / 2);
  world.addBody(ground);

  // Left wall
  const lw = new CANNON.Body({ mass: 0 });
  lw.addShape(new CANNON.Plane());
  lw.position.set(-(W / 2) / SCALE, 0, 0);
  lw.quaternion.setFromAxisAngle(new CANNON.Vec3(0, 1, 0), -Math.PI / 2);
  world.addBody(lw);

  // Right wall
  const rw = new CANNON.Body({ mass: 0 });
  rw.addShape(new CANNON.Plane());
  rw.position.set((W / 2) / SCALE, 0, 0);
  rw.quaternion.setFromAxisAngle(new CANNON.Vec3(0, 1, 0), Math.PI / 2);
  world.addBody(rw);

  const taskDefs = [
    { emoji: '🔔', label: 'Meeting',  color: '#f97316', bg: '#fff7ed' },
    { emoji: '📋', label: 'Report',   color: '#3b82f6', bg: '#eff6ff' },
    { emoji: '✅', label: 'Review',   color: '#22c55e', bg: '#f0fdf4' },
    { emoji: '⏰', label: 'Call',     color: '#a855f7', bg: '#faf5ff' },
    { emoji: '📧', label: 'Email',    color: '#ec4899', bg: '#fdf2f8' },
    { emoji: '🗓', label: 'Sync',     color: '#f59e0b', bg: '#fffbeb' },
  ];

  const bodies = [];
  let spawnIdx = 0;

  function spawnBall() {
    if (spawnIdx >= taskDefs.length) {
      setTimeout(reset, 3200);
      return;
    }
    const def = taskDefs[spawnIdx++];
    const body = new CANNON.Body({ mass: 1, linearDamping: 0.25, angularDamping: 0.8 });
    body.addShape(new CANNON.Sphere(BALL_R));
    const half = (W / 2) / SCALE - BALL_R;
    body.position.set((Math.random() - 0.5) * half * 1.4, H / SCALE + spawnIdx * 1.1, 0);
    body.velocity.set((Math.random() - 0.5) * 3, 0, 0);
    body.userData = def;
    world.addBody(body);
    bodies.push(body);
    setTimeout(spawnBall, 380);
  }

  function reset() {
    bodies.forEach(b => world.removeBody(b));
    bodies.length = 0;
    spawnIdx = 0;
    setTimeout(spawnBall, 500);
  }

  spawnBall();

  let last;
  (function tick(now) {
    requestAnimationFrame(tick);
    if (last !== undefined) world.step(1 / 60, (now - last) / 1000, 3);
    last = now;

    ctx.clearRect(0, 0, W, H);

    // Tray / inbox background
    ctx.fillStyle = '#f8fafc';
    ctx.strokeStyle = '#e2e8f0';
    ctx.lineWidth = 1.5;
    roundRect(ctx, 16, H - 36, W - 32, 32, 10, true, true);

    ctx.fillStyle = '#94a3b8';
    ctx.font = '11px DM Mono, monospace';
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    ctx.fillText(`inbox  ·  ${bodies.length} task${bodies.length !== 1 ? 's' : ''}`, W / 2, H - 20);

    // Draw bodies
    bodies.forEach(b => {
      const bx = px(b.position.x);
      const by = py(b.position.y);
      const r = BALL_R * SCALE;
      if (by + r < 0 || by - r > H) return;
      const d = b.userData;

      ctx.save();
      ctx.shadowColor = d.color + '55';
      ctx.shadowBlur = 14;
      ctx.beginPath();
      ctx.arc(bx, by, r, 0, Math.PI * 2);
      ctx.fillStyle = d.bg;
      ctx.fill();
      ctx.strokeStyle = d.color;
      ctx.lineWidth = 2;
      ctx.stroke();
      ctx.restore();

      // Emoji
      ctx.font = `${r * 0.7}px serif`;
      ctx.textAlign = 'center';
      ctx.textBaseline = 'middle';
      ctx.fillText(d.emoji, bx, by - 2);

      // Label below emoji
      ctx.font = `600 ${Math.max(8, r * 0.28)}px Plus Jakarta Sans, sans-serif`;
      ctx.fillStyle = d.color;
      ctx.textAlign = 'center';
      ctx.fillText(d.label, bx, by + r * 0.52);
    });
  })(0);
}

function roundRect(ctx, x, y, w, h, r, fill, stroke) {
  ctx.beginPath();
  ctx.moveTo(x + r, y);
  ctx.lineTo(x + w - r, y);
  ctx.quadraticCurveTo(x + w, y, x + w, y + r);
  ctx.lineTo(x + w, y + h - r);
  ctx.quadraticCurveTo(x + w, y + h, x + w - r, y + h);
  ctx.lineTo(x + r, y + h);
  ctx.quadraticCurveTo(x, y + h, x, y + h - r);
  ctx.lineTo(x, y + r);
  ctx.quadraticCurveTo(x, y, x + r, y);
  ctx.closePath();
  if (fill) ctx.fill();
  if (stroke) ctx.stroke();
}

/* ════════════════════════════════════════════
   LOADER 5 — WEBGL  GLSL Fragment Shader Ring
════════════════════════════════════════════ */
function initWebGL() {
  const stage = document.getElementById('stage-5');
  const canvas = document.getElementById('c5');
  let W = stage.clientWidth, H = stage.clientHeight;
  canvas.width = W; canvas.height = H;

  const gl = canvas.getContext('webgl') || canvas.getContext('experimental-webgl');
  if (!gl) return;

  const VS = `attribute vec2 aPos; void main(){ gl_Position=vec4(aPos,0,1); }`;

  const FS = `
    precision highp float;
    uniform float uTime;
    uniform vec2  uRes;
    #define PI  3.14159265358979
    #define TAU 6.28318530718

    void main(){
      vec2 uv = (gl_FragCoord.xy - uRes * 0.5) / min(uRes.x, uRes.y);
      float t  = uTime;
      vec3 col = vec3(0.988, 0.980, 0.965); /* warm cream */

      float dist  = length(uv);
      float angle = atan(uv.y, uv.x); /* -PI..PI */

      /* ─── Track ring ─── */
      float trackR = 0.310;
      float dTrack  = abs(dist - trackR);
      float trackA  = smoothstep(0.026, 0.008, dTrack);
      col = mix(col, vec3(0.88,0.86,0.82), trackA * 0.75);

      /* ─── Progress ring ─── */
      float prog = fract(t * 0.2); /* ~5s cycle */
      /* clockwise from top: norm=0 at top, increases CW */
      float norm = fract((PI*0.5 - angle) / TAU + 1.0);
      float onArc = step(norm, prog);

      float dProg = abs(dist - trackR);
      float progA = smoothstep(0.026, 0.004, dProg);

      /* colour gradient: orange → pink along arc */
      float arcPos = clamp(norm / max(prog, 0.001), 0.0, 1.0);
      vec3 colA = vec3(1.00, 0.44, 0.10); /* orange */
      vec3 colB = vec3(0.97, 0.27, 0.57); /* pink  */
      vec3 arcCol = mix(colA, colB, arcPos * onArc);
      col = mix(col, arcCol, progA * onArc * 0.92);

      /* ─── Glow halo around progress arc ─── */
      float glow  = exp(-dProg * dProg * 320.0) * 0.22 * onArc;
      col += arcCol * glow;

      /* ─── Leading-edge hot spot ─── */
      float headAng = PI*0.5 - prog * TAU;
      vec2  headPos = trackR * vec2(cos(headAng), sin(headAng));
      float headD   = length(uv - headPos);
      float headG   = exp(-headD * headD * 380.0) * prog * 1.8;
      col += colB * headG;
      col  = clamp(col, 0.0, 1.0);

      /* ─── 12 tick marks ─── */
      for(float i=0.0; i<12.0; i++){
        float ta  = PI*0.5 - (i/12.0)*TAU;
        vec2  td  = vec2(cos(ta), sin(ta));
        float lo  = 0.285, hi = 0.338;
        float proj = clamp(dot(uv, td), lo, hi);
        float tDist = length(uv - td * proj);
        float tick  = smoothstep(0.010, 0.003, tDist);
        float tn    = fract((PI*0.5 - ta)/TAU + 1.0);
        float ton   = step(tn, prog);
        vec3  tcol  = mix(vec3(0.78,0.75,0.70), arcCol, ton);
        col = mix(col, tcol, tick * 0.85);
      }

      /* ─── Inner soft fill ─── */
      float pulse  = 0.5 + 0.5*sin(t*2.8);
      float innerA = smoothstep(0.21 + pulse*0.015, 0.18, dist);
      col = mix(col, vec3(1.0,0.97,0.93), innerA * 0.45);

      /* ─── Subtle warmth pulse ─── */
      float warmG = exp(-dist*dist*12.0) * 0.06 * prog;
      col += vec3(1.0,0.55,0.2) * warmG;
      col = clamp(col,0.0,1.0);

      gl_FragColor = vec4(col, 1.0);
    }
  `;

  function mkShader(src, type) {
    const s = gl.createShader(type);
    gl.shaderSource(s, src); gl.compileShader(s);
    if (!gl.getShaderParameter(s, gl.COMPILE_STATUS)) console.warn(gl.getShaderInfoLog(s));
    return s;
  }

  const prog = gl.createProgram();
  gl.attachShader(prog, mkShader(VS, gl.VERTEX_SHADER));
  gl.attachShader(prog, mkShader(FS, gl.FRAGMENT_SHADER));
  gl.linkProgram(prog);
  gl.useProgram(prog);

  const buf = gl.createBuffer();
  gl.bindBuffer(gl.ARRAY_BUFFER, buf);
  gl.bufferData(gl.ARRAY_BUFFER, new Float32Array([-1,-1, 1,-1, -1,1, 1,1]), gl.STATIC_DRAW);

  const aPos = gl.getAttribLocation(prog, 'aPos');
  gl.enableVertexAttribArray(aPos);
  gl.vertexAttribPointer(aPos, 2, gl.FLOAT, false, 0, 0);

  const uTime = gl.getUniformLocation(prog, 'uTime');
  const uRes  = gl.getUniformLocation(prog, 'uRes');
  gl.uniform2f(uRes, W, H);

  const t0 = performance.now();

  // Percent counter
  const pctEl = document.getElementById('pct-label');
  let lastPct = -1;

  (function tick() {
    requestAnimationFrame(tick);
    const t = (performance.now() - t0) / 1000;
    gl.uniform1f(uTime, t);
    gl.viewport(0, 0, W, H);
    gl.drawArrays(gl.TRIANGLE_STRIP, 0, 4);

    // Sync percent to shader progress
    const prog_val = ((t * 0.2) % 1);
    const pct = Math.round(prog_val * 100);
    if (pct !== lastPct && pctEl) { pctEl.textContent = pct + '%'; lastPct = pct; }
  })();

  new ResizeObserver(() => {
    W = stage.clientWidth; H = stage.clientHeight;
    canvas.width = W; canvas.height = H;
    gl.uniform2f(uRes, W, H);
  }).observe(stage);
}
</script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reminder App — Loader Collection</title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&family=DM+Mono:wght@300;400&family=Playfair+Display:ital,wght@0,700;1,400&display=swap" rel="stylesheet">
<style>
  :root {
    --bg: #f6f4f0;
    --surface: #fffdf9;
    --surface2: #f0eee9;
    --ink: #1c1917;
    --sub: #78716c;
    --accent1: #f97316;   /* orange — urgency/due */
    --accent2: #3b82f6;   /* blue — calm/scheduled */
    --accent3: #22c55e;   /* green — done/success */
    --accent4: #a855f7;   /* purple — priority */
    --accent5: #ec4899;   /* pink — personal */
    --border: rgba(28,25,23,0.1);
    --shadow: 0 2px 20px rgba(0,0,0,0.07);
  }

  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  body {
    background: var(--bg);
    font-family: 'Nunito', sans-serif;
    min-height: 100vh;
    color: var(--ink);
  }

  /* ── HERO HEADER ── */
  .hero {
    background: var(--surface);
    border-bottom: 1.5px solid var(--border);
    padding: 3.5rem 2rem 2.5rem;
    text-align: center;
    position: relative;
    overflow: hidden;
  }
  .hero::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse 60% 80% at 50% 120%, rgba(249,115,22,0.06) 0%, transparent 70%);
    pointer-events: none;
  }
  .hero-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(249,115,22,0.1);
    color: var(--accent1);
    border: 1px solid rgba(249,115,22,0.25);
    border-radius: 999px;
    padding: 0.3rem 1rem;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    margin-bottom: 1.2rem;
  }
  .hero h1 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2rem, 5vw, 3.2rem);
    font-weight: 700;
    letter-spacing: -0.02em;
    line-height: 1.05;
  }
  .hero h1 em {
    font-style: italic;
    color: var(--accent1);
  }
  .hero p {
    font-family: 'DM Mono', monospace;
    font-size: 0.72rem;
    color: var(--sub);
    letter-spacing: 0.1em;
    text-transform: uppercase;
    margin-top: 0.8rem;
  }

  /* ── GRID ── */
  .grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    padding: 2.5rem 2rem;
    max-width: 1400px;
    margin: 0 auto;
  }

  .card {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: 20px;
    padding: 2.5rem 2rem 2rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 2rem;
    min-height: 320px;
    position: relative;
    overflow: hidden;
    box-shadow: var(--shadow);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  .card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
  }

  .card-accent-bar {
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    border-radius: 20px 20px 0 0;
  }

  .card-badge {
    position: absolute;
    top: 1.2rem;
    right: 1.2rem;
    font-family: 'DM Mono', monospace;
    font-size: 0.6rem;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 6px;
    padding: 0.2rem 0.5rem;
    color: var(--sub);
  }

  .loader-stage {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
  }

  .card-info {
    width: 100%;
    border-top: 1px solid var(--border);
    padding-top: 1.2rem;
  }
  .card-info h3 {
    font-size: 1rem;
    font-weight: 800;
    letter-spacing: -0.01em;
    margin-bottom: 0.3rem;
  }
  .card-info p {
    font-family: 'DM Mono', monospace;
    font-size: 0.68rem;
    color: var(--sub);
    line-height: 1.6;
  }

  /* ════════════════════════════════════════
     LOADER 1 — COUNTDOWN RING (bell timer)
  ════════════════════════════════════════ */
  .ring-wrap {
    position: relative;
    width: 120px;
    height: 120px;
  }

  .ring-svg {
    width: 120px;
    height: 120px;
    transform: rotate(-90deg);
  }

  .ring-track {
    fill: none;
    stroke: rgba(249,115,22,0.12);
    stroke-width: 6;
  }

  .ring-fill {
    fill: none;
    stroke: var(--accent1);
    stroke-width: 6;
    stroke-linecap: round;
    stroke-dasharray: 283;
    animation: ring-countdown 3s ease-in-out infinite;
  }
  @keyframes ring-countdown {
    0%   { stroke-dashoffset: 0;   stroke: #f97316; }
    60%  { stroke-dashoffset: 200; stroke: #ef4444; }
    100% { stroke-dashoffset: 283; stroke: #ef4444; opacity: 0; }
  }

  .ring-glow {
    fill: none;
    stroke: rgba(249,115,22,0.2);
    stroke-width: 12;
    stroke-linecap: round;
    stroke-dasharray: 283;
    animation: ring-countdown 3s ease-in-out infinite;
    filter: blur(3px);
  }

  .ring-center {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 2px;
  }

  .ring-bell {
    width: 30px;
    height: 30px;
    animation: bell-shake 3s ease-in-out infinite;
    transform-origin: center top;
  }
  @keyframes bell-shake {
    0%, 60%, 100% { transform: rotate(0deg); }
    65%  { transform: rotate(-18deg); }
    70%  { transform: rotate(18deg); }
    75%  { transform: rotate(-14deg); }
    80%  { transform: rotate(14deg); }
    85%  { transform: rotate(-8deg); }
    90%  { transform: rotate(0deg); }
  }

  .ring-label {
    font-family: 'DM Mono', monospace;
    font-size: 0.6rem;
    color: var(--accent1);
    font-weight: 500;
    letter-spacing: 0.05em;
    animation: ring-countdown 3s ease-in-out infinite;
  }

  /* ════════════════════════════════════════
     LOADER 2 — CHECKLIST CASCADE
  ════════════════════════════════════════ */
  .checklist-wrap {
    display: flex;
    flex-direction: column;
    gap: 0.85rem;
    width: 200px;
  }

  .check-row {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    opacity: 0;
    transform: translateX(-12px);
  }

  .check-row:nth-child(1) { animation: row-in 0.4s ease 0.1s forwards, row-check 0.35s ease 0.7s forwards; }
  .check-row:nth-child(2) { animation: row-in 0.4s ease 0.6s forwards, row-check 0.35s ease 1.2s forwards; }
  .check-row:nth-child(3) { animation: row-in 0.4s ease 1.1s forwards, row-check 0.35s ease 1.7s forwards; }
  .check-row:nth-child(4) { animation: row-in 0.4s ease 1.6s forwards; }

  @keyframes row-in {
    to { opacity: 1; transform: translateX(0); }
  }
  @keyframes row-check {
    to { opacity: 0.45; }
  }

  .checkbox {
    width: 20px;
    height: 20px;
    border-radius: 6px;
    border: 2px solid var(--border);
    flex-shrink: 0;
    position: relative;
    background: var(--surface);
    overflow: hidden;
    transition: border-color 0.2s;
  }

  .check-row:nth-child(1) .checkbox { animation: box-fill 0.3s ease 0.7s forwards; }
  .check-row:nth-child(2) .checkbox { animation: box-fill 0.3s ease 1.2s forwards; }
  .check-row:nth-child(3) .checkbox { animation: box-fill 0.3s ease 1.7s forwards; }

  @keyframes box-fill {
    to { background: var(--accent3); border-color: var(--accent3); }
  }

  .checkmark {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .checkmark svg {
    width: 11px;
    height: 11px;
    stroke: white;
    stroke-width: 2.5;
    stroke-linecap: round;
    stroke-linejoin: round;
    fill: none;
  }
  .checkmark-path {
    stroke-dasharray: 16;
    stroke-dashoffset: 16;
  }
  .check-row:nth-child(1) .checkmark-path { animation: check-draw 0.3s ease 0.72s forwards; }
  .check-row:nth-child(2) .checkmark-path { animation: check-draw 0.3s ease 1.22s forwards; }
  .check-row:nth-child(3) .checkmark-path { animation: check-draw 0.3s ease 1.72s forwards; }

  @keyframes check-draw {
    to { stroke-dashoffset: 0; }
  }

  .check-text {
    font-size: 0.82rem;
    font-weight: 600;
    color: var(--ink);
    white-space: nowrap;
  }
  .check-row:nth-child(1) .check-text,
  .check-row:nth-child(2) .check-text,
  .check-row:nth-child(3) .check-text {
    animation: text-strike 0.3s ease forwards;
  }
  .check-row:nth-child(1) .check-text { animation-delay: 0.75s; }
  .check-row:nth-child(2) .check-text { animation-delay: 1.25s; }
  .check-row:nth-child(3) .check-text { animation-delay: 1.75s; }

  @keyframes text-strike {
    to { text-decoration: line-through; color: var(--sub); }
  }

  .check-chip {
    margin-left: auto;
    font-size: 0.58rem;
    font-family: 'DM Mono', monospace;
    background: rgba(59,130,246,0.1);
    color: var(--accent2);
    border-radius: 4px;
    padding: 0.15rem 0.4rem;
  }
  .check-chip.urgent {
    background: rgba(249,115,22,0.1);
    color: var(--accent1);
  }
  .check-chip.done {
    background: rgba(34,197,94,0.1);
    color: var(--accent3);
  }

  /* ════════════════════════════════════════
     LOADER 3 — NOTIFICATION RIPPLE BELL
  ════════════════════════════════════════ */
  .notif-wrap {
    position: relative;
    width: 130px;
    height: 130px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .ripple {
    position: absolute;
    border-radius: 50%;
    border: 2px solid var(--accent4);
    animation: ripple-out 2.4s ease-out infinite;
    opacity: 0;
  }
  .ripple-1 { width: 48px; height: 48px; animation-delay: 0s; }
  .ripple-2 { width: 48px; height: 48px; animation-delay: 0.6s; }
  .ripple-3 { width: 48px; height: 48px; animation-delay: 1.2s; }

  @keyframes ripple-out {
    0%   { transform: scale(1); opacity: 0.7; }
    100% { transform: scale(3.2); opacity: 0; }
  }

  .bell-pill {
    width: 64px;
    height: 64px;
    background: white;
    border-radius: 18px;
    border: 1.5px solid var(--border);
    box-shadow: 0 4px 20px rgba(168,85,247,0.15), 0 2px 8px rgba(0,0,0,0.06);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    z-index: 2;
    animation: pill-bob 2.4s ease-in-out infinite;
  }
  @keyframes pill-bob {
    0%, 100% { transform: translateY(0); }
    50%       { transform: translateY(-5px); }
  }

  .notif-dot {
    position: absolute;
    top: -4px;
    right: -4px;
    width: 14px;
    height: 14px;
    background: var(--accent5);
    border-radius: 50%;
    border: 2.5px solid white;
    animation: dot-pop 2.4s ease-in-out infinite;
  }
  @keyframes dot-pop {
    0%, 45%, 100% { transform: scale(1); }
    50%            { transform: scale(1.4); }
    60%            { transform: scale(0.9); }
    70%            { transform: scale(1); }
  }

  .bell-icon {
    width: 28px;
    height: 28px;
    animation: bell-sway 2.4s ease-in-out infinite;
    transform-origin: center top;
  }
  @keyframes bell-sway {
    0%, 30%, 100% { transform: rotate(0deg); }
    35% { transform: rotate(-22deg); }
    42% { transform: rotate(22deg); }
    48% { transform: rotate(-16deg); }
    54% { transform: rotate(16deg); }
    60% { transform: rotate(-8deg); }
    66% { transform: rotate(0deg); }
  }

  /* ════════════════════════════════════════
     LOADER 4 — CALENDAR PAGE FLIP
  ════════════════════════════════════════ */
  .cal-wrap {
    position: relative;
    width: 110px;
    height: 120px;
    perspective: 600px;
  }

  .cal-base {
    width: 110px;
    height: 120px;
    background: white;
    border-radius: 14px;
    border: 1.5px solid var(--border);
    box-shadow: var(--shadow);
    overflow: hidden;
    position: absolute;
  }

  .cal-header {
    background: var(--accent2);
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
  }
  .cal-rings {
    display: flex;
    gap: 18px;
  }
  .cal-ring {
    width: 10px;
    height: 14px;
    border: 2.5px solid rgba(255,255,255,0.7);
    border-radius: 3px;
    background: transparent;
  }

  .cal-body {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 90px;
    flex-direction: column;
    gap: 4px;
  }

  .cal-day {
    font-family: 'Playfair Display', serif;
    font-size: 2.8rem;
    font-weight: 700;
    line-height: 1;
    color: var(--ink);
    animation: cal-count 3s steps(1) infinite;
  }
  @keyframes cal-count {
    0%  { content: ""; }
    0%  { opacity: 1; }
    25% { opacity: 0.3; }
    50% { opacity: 1; }
    75% { opacity: 0.3; }
    100%{ opacity: 1; }
  }

  .cal-month {
    font-family: 'DM Mono', monospace;
    font-size: 0.62rem;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--accent2);
    font-weight: 500;
  }

  /* Page flip layer */
  .cal-page {
    position: absolute;
    width: 110px;
    height: 90px;
    bottom: 0;
    background: white;
    border-radius: 0 0 14px 14px;
    border: 1.5px solid var(--border);
    transform-origin: top center;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    gap: 4px;
    animation: page-flip 3s ease-in-out infinite;
    backface-visibility: hidden;
    will-change: transform;
    z-index: 3;
  }

  @keyframes page-flip {
    0%, 15%  { transform: rotateX(0deg); }
    45%, 55% { transform: rotateX(-160deg); opacity: 0; }
    60%      { transform: rotateX(0deg); opacity: 1; }
    100%     { transform: rotateX(0deg); }
  }

  .page-day {
    font-family: 'Playfair Display', serif;
    font-size: 2.8rem;
    font-weight: 700;
    line-height: 1;
    color: var(--ink);
  }
  .page-month {
    font-family: 'DM Mono', monospace;
    font-size: 0.62rem;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--sub);
  }

  /* Reminder dot */
  .cal-dot {
    position: absolute;
    bottom: 18px;
    right: 12px;
    width: 8px;
    height: 8px;
    background: var(--accent1);
    border-radius: 50%;
    animation: dot-pulse 3s ease-in-out infinite;
    z-index: 5;
  }
  @keyframes dot-pulse {
    0%, 100% { transform: scale(1); opacity: 1; }
    50%       { transform: scale(1.5); opacity: 0.6; }
  }

  /* ════════════════════════════════════════
     LOADER 5 — HOURGLASS SAND TIMER
  ════════════════════════════════════════ */
  .hourglass-wrap {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.8rem;
  }

  .hg-svg {
    width: 90px;
    height: 110px;
    overflow: visible;
    filter: drop-shadow(0 4px 16px rgba(236,72,153,0.15));
  }

  /* Glass frame */
  .hg-frame {
    fill: none;
    stroke: var(--accent5);
    stroke-width: 2;
    stroke-linejoin: round;
  }
  .hg-cap-top, .hg-cap-bot {
    fill: var(--accent5);
    rx: 3;
  }

  /* Sand top — drains */
  .hg-sand-top {
    fill: rgba(236,72,153,0.25);
    animation: sand-drain 3s ease-in-out infinite;
    transform-origin: center;
  }
  @keyframes sand-drain {
    0%   { d: path("M 20,14 L 70,14 L 52,48 L 38,48 Z"); opacity: 1; }
    80%  { d: path("M 43,46 L 47,46 L 45,48 L 43,48 Z"); opacity: 0.4; }
    100% { d: path("M 43,46 L 47,46 L 45,48 L 43,48 Z"); opacity: 0; }
  }

  /* Sand stream */
  .hg-stream {
    stroke: var(--accent5);
    stroke-width: 2;
    stroke-linecap: round;
    stroke-dasharray: 40;
    animation: stream-flow 3s ease-in-out infinite;
  }
  @keyframes stream-flow {
    0%, 10% { stroke-dashoffset: 40; opacity: 0; }
    20%      { stroke-dashoffset: 0;  opacity: 1; }
    80%      { stroke-dashoffset: 0;  opacity: 1; }
    95%      { stroke-dashoffset: 40; opacity: 0; }
    100%     { stroke-dashoffset: 40; opacity: 0; }
  }

  /* Sand bottom — fills */
  .hg-sand-bot {
    fill: rgba(236,72,153,0.3);
    animation: sand-fill 3s ease-in-out infinite;
  }
  @keyframes sand-fill {
    0%   { d: path("M 45,58 L 45,58 L 45,58 Z"); opacity: 0; }
    15%  { opacity: 1; }
    80%  { d: path("M 22,86 L 68,86 L 52,58 L 38,58 Z"); opacity: 1; }
    100% { d: path("M 22,86 L 68,86 L 52,58 L 38,58 Z"); opacity: 0; }
  }

  /* Hourglass flip */
  .hg-svg {
    animation: hg-flip 3s ease-in-out infinite;
    transform-origin: center;
  }
  @keyframes hg-flip {
    0%, 80%  { transform: rotate(0deg); }
    90%      { transform: rotate(180deg); }
    100%     { transform: rotate(180deg); }
  }

  .hg-label {
    font-family: 'DM Mono', monospace;
    font-size: 0.68rem;
    color: var(--accent5);
    letter-spacing: 0.1em;
    text-transform: uppercase;
    animation: hg-label-fade 3s ease-in-out infinite;
  }
  @keyframes hg-label-fade {
    0%, 70%  { opacity: 1; }
    80%, 95% { opacity: 0; }
    100%     { opacity: 1; }
  }

  /* ── RESPONSIVE ── */
  @media (max-width: 680px) {
    .grid { grid-template-columns: 1fr; padding: 1.5rem 1rem; gap: 1rem; }
    .card { min-height: 280px; }
  }
  @media (min-width: 681px) and (max-width: 1020px) {
    .grid { grid-template-columns: repeat(2, 1fr); }
  }
</style>
</head>
<body>

<header class="hero">
  <div class="hero-tag">🔔 Reminder App</div>
  <h1>Loading <em>States</em></h1>
  <p>5 Contextual loaders &nbsp;·&nbsp; Light Theme &nbsp;·&nbsp; CSS Only</p>
</header>

<div class="grid">

  <!-- ══ CARD 1: COUNTDOWN RING BELL ══ -->
  <div class="card">
    <div class="card-accent-bar" style="background: var(--accent1);"></div>
    <span class="card-badge">01 / ring</span>
    <div class="loader-stage">
      <div class="ring-wrap">
        <svg class="ring-svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
          <circle class="ring-track" cx="50" cy="50" r="45"/>
          <circle class="ring-glow" cx="50" cy="50" r="45"/>
          <circle class="ring-fill" cx="50" cy="50" r="45"/>
        </svg>
        <div class="ring-center">
          <!-- Bell SVG icon -->
          <svg class="ring-bell" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2C12 2 8 4 8 10V16H16V10C16 4 12 2 12 2Z" fill="var(--accent1)" opacity="0.9"/>
            <rect x="9" y="16" width="6" height="2.5" rx="1" fill="var(--accent1)" opacity="0.7"/>
            <path d="M10.5 19.5 C10.5 20.3 11.2 21 12 21 C12.8 21 13.5 20.3 13.5 19.5" stroke="var(--accent1)" stroke-width="1.5" fill="none" stroke-linecap="round"/>
            <circle cx="12" cy="3" r="1.2" fill="var(--accent1)"/>
          </svg>
          <span class="ring-label">due soon</span>
        </div>
      </div>
    </div>
    <div class="card-info">
      <h3>Countdown Ring</h3>
      <p>Animated SVG stroke countdown + bell shake on completion</p>
    </div>
  </div>

  <!-- ══ CARD 2: CHECKLIST CASCADE ══ -->
  <div class="card">
    <div class="card-accent-bar" style="background: var(--accent3);"></div>
    <span class="card-badge">02 / tasks</span>
    <div class="loader-stage">
      <div class="checklist-wrap">
        <div class="check-row">
          <div class="checkbox"><div class="checkmark"><svg viewBox="0 0 12 10"><polyline class="checkmark-path" points="1.5,5 4.5,8.5 10.5,1.5"/></svg></div></div>
          <span class="check-text">Team standup</span>
          <span class="check-chip urgent">9am</span>
        </div>
        <div class="check-row">
          <div class="checkbox"><div class="checkmark"><svg viewBox="0 0 12 10"><polyline class="checkmark-path" points="1.5,5 4.5,8.5 10.5,1.5"/></svg></div></div>
          <span class="check-text">Review PRs</span>
          <span class="check-chip">today</span>
        </div>
        <div class="check-row">
          <div class="checkbox"><div class="checkmark"><svg viewBox="0 0 12 10"><polyline class="checkmark-path" points="1.5,5 4.5,8.5 10.5,1.5"/></svg></div></div>
          <span class="check-text">Send report</span>
          <span class="check-chip">3pm</span>
        </div>
        <div class="check-row">
          <div class="checkbox"></div>
          <span class="check-text">Planning call</span>
          <span class="check-chip done">tmrw</span>
        </div>
      </div>
    </div>
    <div class="card-info">
      <h3>Checklist Cascade</h3>
      <p>Staggered slide-in + checkbox fill + strikethrough text animation</p>
    </div>
  </div>

  <!-- ══ CARD 3: NOTIFICATION RIPPLE ══ -->
  <div class="card">
    <div class="card-accent-bar" style="background: var(--accent4);"></div>
    <span class="card-badge">03 / notify</span>
    <div class="loader-stage">
      <div class="notif-wrap">
        <div class="ripple ripple-1"></div>
        <div class="ripple ripple-2"></div>
        <div class="ripple ripple-3"></div>
        <div class="bell-pill">
          <div class="notif-dot"></div>
          <svg class="bell-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2.5C9.24 2.5 7 5.02 7 8.1V14.5H17V8.1C17 5.02 14.76 2.5 12 2.5Z" fill="var(--accent4)"/>
            <rect x="9" y="14.5" width="6" height="2.5" rx="1.2" fill="var(--accent4)" opacity="0.7"/>
            <path d="M10.5 18.5C10.5 19.33 11.17 20 12 20C12.83 20 13.5 19.33 13.5 18.5" stroke="var(--accent4)" stroke-width="1.5" fill="none" stroke-linecap="round"/>
            <circle cx="12" cy="3.2" r="1.3" fill="var(--accent4)"/>
          </svg>
        </div>
      </div>
    </div>
    <div class="card-info">
      <h3>Notification Ripple</h3>
      <p>Staggered radial ripple waves + floating bell + badge pulse</p>
    </div>
  </div>

  <!-- ══ CARD 4: CALENDAR PAGE FLIP ══ -->
  <div class="card">
    <div class="card-accent-bar" style="background: var(--accent2);"></div>
    <span class="card-badge">04 / date</span>
    <div class="loader-stage">
      <div class="cal-wrap">
        <div class="cal-base">
          <div class="cal-header">
            <div class="cal-rings">
              <div class="cal-ring"></div>
              <div class="cal-ring"></div>
            </div>
          </div>
          <div class="cal-body">
            <div class="cal-day">22</div>
            <div class="cal-month">April</div>
          </div>
        </div>
        <div class="cal-page">
          <div class="page-day">23</div>
          <div class="page-month">April</div>
        </div>
        <div class="cal-dot"></div>
      </div>
    </div>
    <div class="card-info">
      <h3>Calendar Page Flip</h3>
      <p>3D CSS rotateX perspective flip + pulsing reminder dot</p>
    </div>
  </div>

  <!-- ══ CARD 5: HOURGLASS SAND TIMER ══ -->
  <div class="card">
    <div class="card-accent-bar" style="background: var(--accent5);"></div>
    <span class="card-badge">05 / timer</span>
    <div class="loader-stage">
      <div class="hourglass-wrap">
        <svg class="hg-svg" viewBox="0 0 90 110" xmlns="http://www.w3.org/2000/svg">
          <!-- Caps -->
          <rect x="16" y="8" width="58" height="8" rx="4" class="hg-cap-top" fill="var(--accent5)" opacity="0.9"/>
          <rect x="16" y="94" width="58" height="8" rx="4" class="hg-cap-bot" fill="var(--accent5)" opacity="0.9"/>
          <!-- Glass outline -->
          <path class="hg-frame" d="M 20,16 L 70,16 L 46,50 L 44,50 L 20,84 L 70,84 L 44,50 L 46,50 Z" stroke="var(--accent5)" stroke-opacity="0.4" fill="rgba(236,72,153,0.04)"/>
          <!-- Sand top -->
          <path class="hg-sand-top" d="M 20,16 L 70,16 L 46,50 L 44,50 Z"/>
          <!-- Stream -->
          <line class="hg-stream" x1="45" y1="50" x2="45" y2="58"/>
          <!-- Sand bottom -->
          <path class="hg-sand-bot" d="M 45,58 L 45,58 L 45,58 Z"/>
        </svg>
        <span class="hg-label">time remaining</span>
      </div>
    </div>
    <div class="card-info">
      <h3>Hourglass Sand Timer</h3>
      <p>SVG path morphing sand drain/fill + full flip rotation</p>
    </div>
  </div>

</div>

</body>
</html>