/* ─────────────────────────────────────────
Alarm-Clock particle morph
Colors: Option A palette (violet/purple)
───────────────────────────────────────── */
(function initAlarmLoader() {
const stage  = document.getElementById('loader-stage');
const canvas = document.getElementById('loader-canvas');
const ctx    = canvas.getContext('2d');

let W, H, cpts;
const N = 130;

// Option A — purple/violet palette
const PURPLES = [
    '#a855f7', '#7c3aed', '#c084fc',
    '#e879f9', '#d946ef', '#f0abfc', '#6d28d9'
];

/* ── Build alarm-clock target points ── */
function alarmPts(cx, cy, sz) {
    const pts = [];

    // Main clock body — circle rim (70 pts)
    const bodyR = sz * 0.34;
    for (let i = 0; i < 70; i++) {
    const a = (i / 70) * Math.PI * 2 - Math.PI / 2;
    pts.push({
        x: cx + Math.cos(a) * bodyR,
        y: cy + Math.sin(a) * bodyR
    });
    }

    // Left bell — small circle top-left (15 pts)
    const lbCx = cx - sz * 0.32, lbCy = cy - sz * 0.32, lbR = sz * 0.10;
    for (let i = 0; i < 15; i++) {
    const a = (i / 15) * Math.PI * 2;
    pts.push({ x: lbCx + Math.cos(a) * lbR, y: lbCy + Math.sin(a) * lbR });
    }

    // Right bell — small circle top-right (15 pts)
    const rbCx = cx + sz * 0.32, rbCy = cy - sz * 0.32, rbR = sz * 0.10;
    for (let i = 0; i < 15; i++) {
    const a = (i / 15) * Math.PI * 2;
    pts.push({ x: rbCx + Math.cos(a) * rbR, y: rbCy + Math.sin(a) * rbR });
    }

    // Hour hand (10 pts)
    const hA = -Math.PI / 2 - Math.PI / 4;
    for (let i = 0; i < 10; i++) {
    const f = i / 9;
    pts.push({
        x: cx + Math.cos(hA) * bodyR * 0.55 * f,
        y: cy + Math.sin(hA) * bodyR * 0.55 * f
    });
    }

    // Minute hand (10 pts)
    const mA = Math.PI / 6;
    for (let i = 0; i < 10; i++) {
    const f = i / 9;
    pts.push({
        x: cx + Math.cos(mA) * bodyR * 0.70 * f,
        y: cy + Math.sin(mA) * bodyR * 0.70 * f
    });
    }

    // Left foot arc (5 pts)
    for (let i = 0; i < 5; i++) {
    const a = Math.PI * 0.75 + (i / 4) * Math.PI * 0.15;
    pts.push({
        x: cx - sz * 0.12 - Math.cos(a) * sz * 0.08,
        y: cy + sz * 0.36 + Math.sin(a) * sz * 0.06
    });
    }

    // Right foot arc (5 pts)
    for (let i = 0; i < 5; i++) {
    const a = Math.PI * 0.10 + (i / 4) * Math.PI * 0.15;
    pts.push({
        x: cx + sz * 0.12 + Math.cos(a) * sz * 0.08,
        y: cy + sz * 0.36 + Math.sin(a) * sz * 0.06
    });
    }

    return pts.slice(0, N);
}

/* ── Resize helper ── */
function resize() {
    W = stage.clientWidth;
    H = stage.clientHeight;
    canvas.width  = W;
    canvas.height = H;
    cpts = alarmPts(W / 2, H / 2, Math.min(W, H) * 0.82);
    particles.forEach((p, i) => { p.tx = cpts[i].x; p.ty = cpts[i].y; });
}

/* ── Create particles ── */
// initialise W/H early so spawn positions make sense
W = stage.clientWidth  || 380;
H = stage.clientHeight || 280;
canvas.width  = W;
canvas.height = H;
cpts = alarmPts(W / 2, H / 2, Math.min(W, H) * 0.82);

const particles = Array.from({ length: N }, (_, i) => ({
    x: W / 2 + (Math.random() - 0.5) * W * 0.9,
    y: H / 2 + (Math.random() - 0.5) * H * 0.9,
    tx: cpts[i].x,
    ty: cpts[i].y,
    r:     2.4 + Math.random() * 2,
    color: PURPLES[i % PURPLES.length],
    alpha: 0.88
}));

/* ── Animation cycle ── */
function scatter() {
    const tgts = particles.map(() => ({
    x: W / 2 + (Math.random() - 0.5) * W * 0.95,
    y: H / 2 + (Math.random() - 0.5) * H * 0.95
    }));
    anime({
    targets: particles,
    x: (_, i) => tgts[i].x,
    y: (_, i) => tgts[i].y,
    alpha: 0.12,
    duration: 750,
    easing: 'easeInSine',
    complete: gather
    });
}

function gather() {
    anime({
    targets: particles,
    x:     (_, i) => cpts[i].x,
    y:     (_, i) => cpts[i].y,
    alpha: 1,
    r:     (_, i) => 2.4 + (i % 3) * 1.1,
    duration: 1150,
    easing: 'easeOutElastic(0.4, 1)',
    delay: anime.stagger(1, { from: 'last' }),
    complete: () => setTimeout(scatter, 1)
    });
}

gather();

/* ── Render loop ── */
(function draw() {
    requestAnimationFrame(draw);
    ctx.clearRect(0, 0, W, H);

    // Soft radial glow — purple tint
    const g = ctx.createRadialGradient(W/2, H/2, 0, W/2, H/2, Math.min(W, H) * 0.5);
    g.addColorStop(0, 'rgba(168, 85, 247, 0.10)');
    g.addColorStop(1, 'rgba(168, 85, 247, 0)');
    ctx.fillStyle = g;
    ctx.fillRect(0, 0, W, H);

    particles.forEach(p => {
    ctx.save();
    ctx.globalAlpha  = p.alpha;
    ctx.fillStyle    = p.color;
    ctx.shadowColor  = p.color;
    ctx.shadowBlur   = 14;
    ctx.beginPath();
    ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
    ctx.fill();
    ctx.restore();
    });
})();

new ResizeObserver(resize).observe(stage);
})();


/* ─────────────────────────────────────────
Page-ready logic
Tracks: DOM + all resources (window load)
Hides loader once everything is ready
───────────────────────────────────────── */
(function pageReady() {
const loader     = document.getElementById('page-loader');
const statusText = document.getElementById('loader-status-text');
const content    = document.getElementById('main-content');

const messages = [
    'Loading stylesheets…',
    'Fetching resources…',
    'Almost there…',
    'Finalising…'
];
let msgIdx = 0;
const msgInterval = setInterval(() => {
    msgIdx = (msgIdx + 1) % messages.length;
    if (statusText) statusText.textContent = messages[msgIdx];
}, 600);

function hideLoader() {
    clearInterval(msgInterval);
    if (statusText) statusText.textContent = 'Ready!';

    // Small delay so "Ready!" is readable for a beat
    setTimeout(() => {
    loader.classList.add('hidden');
    content.classList.add('visible');
    }, 1000);
}

// window 'load' fires only after ALL resources
// (images, fonts, scripts, stylesheets) are fully loaded
if (document.readyState === 'complete') {
    // Already loaded (e.g. cached page)
    hideLoader();
} else {
    window.addEventListener('load', hideLoader, { once: true });
}
})();