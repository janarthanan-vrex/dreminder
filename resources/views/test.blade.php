<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<title>DRemind — 3 CTA Options</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
@import url('https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,300;9..144,700;9..144,900&family=Nunito+Sans:wght@300;400;600&family=Unbounded:wght@600;800;900&family=Space+Grotesk:wght@300;400;500&family=DM+Serif+Display:ital@0;1&family=Karla:wght@300;400;500&display=swap');
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{overflow-y:scroll;background:#000}

/* ── OPTION CSS VARIABLES ── */
.o2{--bg:#080B0F;
    --bg2:#0E1318;
    --txt:#ffffff;
    --txt2:#a8b6cf;
    --txt3:#fdfdfd;
    --acc:#4E7A90;
    --acc2:rgba(78,122,144,0.12);
    --acc3:rgba(78,122,144,0.22);
    --pfb:linear-gradient(150deg,#0E1522,#0C1016);
    --pfl:linear-gradient(150deg,#1E2B3C,#192436);
    --sbg:#0E1318;
    --hf:'Unbounded',sans-serif;
    --bf:'Space Grotesk',sans-serif;
    --div:rgba(255,255,255,0.06)
}

/* ── CAROUSEL ── */
@keyframes car{0%,27%{transform:translateX(0%)}33%,60%{transform:translateX(-33.333%)}66%,93%{transform:translateX(-66.666%)}99%,100%{transform:translateX(0%)}}
.car{animation:car 12s cubic-bezier(.76,0,.24,1) infinite}

/* ── ENTRY ── */
@keyframes eu{from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:translateY(0)}}
.e1{animation:eu .75s cubic-bezier(.22,1,.36,1) .05s both}.e2{animation:eu .75s cubic-bezier(.22,1,.36,1) .15s both}.e3{animation:eu .75s cubic-bezier(.22,1,.36,1) .25s both}.e4{animation:eu .75s cubic-bezier(.22,1,.36,1) .35s both}.e5{animation:eu .75s cubic-bezier(.22,1,.36,1) .45s both}.e6{animation:eu .75s cubic-bezier(.22,1,.36,1) .55s both}

/* ── SCREEN MICRO ANIMS ── */
@keyframes ti{from{opacity:0;transform:translateX(-9px)}to{opacity:1;transform:translateX(0)}}
.ti1{animation:ti .4s ease .3s both}.ti2{animation:ti .4s ease .5s both}.ti3{animation:ti .4s ease .7s both}

@keyframes bf{from{width:0}}
.bf1{animation:bf 1.5s cubic-bezier(.4,0,.2,1) .8s both}
.bf2{animation:bf 1.5s cubic-bezier(.4,0,.2,1) 1s both}
.bf3{animation:bf 1.5s cubic-bezier(.4,0,.2,1) 1.2s both}
.bf4{animation:bf 1.5s cubic-bezier(.4,0,.2,1) 1.4s both}
.bf5{animation:bf 1.5s cubic-bezier(.4,0,.2,1) 1.6s both}

@keyframes rd{from{stroke-dashoffset:239}to{stroke-dashoffset:67}}
.rd{animation:rd 2s cubic-bezier(.4,0,.2,1) .6s both}

@keyframes brth{0%,100%{transform:scale(1);opacity:.55}50%{transform:scale(1.11);opacity:1}}
.brth{animation:brth 3.2s ease-in-out infinite}
@keyframes brthO{0%,100%{transform:scale(1);opacity:.18}50%{transform:scale(1.32);opacity:0}}
.brthO{animation:brthO 3.2s ease-in-out infinite}
.brthO2{animation:brthO 3.2s ease-in-out .7s infinite}

@keyframes npop{from{opacity:0;transform:translateY(9px) scale(.97)}to{opacity:1;transform:translateY(0) scale(1)}}
.np1{animation:npop .4s cubic-bezier(.34,1.56,.64,1) .8s both}
.np2{animation:npop .4s cubic-bezier(.34,1.56,.64,1) 1.1s both}
.np3{animation:npop .4s cubic-bezier(.34,1.56,.64,1) 1.4s both}

@keyframes pd{0%,100%{opacity:1}50%{opacity:.2}}
.pd{animation:pd 1.8s ease-in-out infinite}

/* ── CAROUSEL DOTS ── */
@keyframes don{0%,27%{opacity:1}33%,96%{opacity:.2}100%{opacity:1}}
.di1{animation:don 12s infinite 0s}.di2{animation:don 12s infinite -8s}.di3{animation:don 12s infinite -4s}

/* ── PHONE FLOATS per option ── */
@keyframes fb1{0%,100%{transform:rotate(-7deg) translateY(0)}50%{transform:rotate(-7deg) translateY(-10px)}}
@keyframes ff1{0%,100%{transform:rotate(3deg) translateY(0)}50%{transform:rotate(3deg) translateY(-9px)}}
.o1 .pb{animation:fb1 5s ease-in-out infinite}
.o1 .pf{animation:ff1 5s ease-in-out 1.5s infinite}

@keyframes fb2{0%,100%{transform:rotate(-11deg) translateY(0)}50%{transform:rotate(-11deg) translateY(-11px)}}
@keyframes ff2{0%,100%{transform:rotate(5deg) translateY(0)}50%{transform:rotate(5deg) translateY(-10px)}}
.o2 .pb{animation:fb2 4.5s ease-in-out infinite}
.o2 .pf{animation:ff2 4.5s ease-in-out 1s infinite}

@keyframes fb3{0%,100%{transform:rotate(-3deg) translateY(0)}50%{transform:rotate(-3deg) translateY(-8px)}}
@keyframes ff3{0%,100%{transform:rotate(1.5deg) translateY(0)}50%{transform:rotate(1.5deg) translateY(-7px)}}
.o3 .pb{animation:fb3 6s ease-in-out infinite}
.o3 .pf{animation:ff3 6s ease-in-out 2s infinite}

/* ── STORE BTN ── */
.sbtn{transition:transform .18s ease,box-shadow .18s ease;cursor:pointer;text-decoration:none}
.sbtn:hover{transform:translateY(-2px)}

/* ── OPTION LABEL ── */
.opt-tag{position:absolute;top:16px;left:50%;transform:translateX(-50%);font-size:9px;letter-spacing:.26em;text-transform:uppercase;padding:4px 14px;border-radius:99px;z-index:50;white-space:nowrap}

/* ── SOFT BLUR GLOW ─ */
.glow1{position:absolute;border-radius:50%;filter:blur(70px);pointer-events:none}

/* ── SMOOTH SCROLL DIVIDER ── */
.section-divider{height:1px;background:rgba(255,255,255,0.04)}
</style>
</head>
<body>


<section class="o2" style="height:90vh;background:var(--bg);overflow:hidden;position:relative;display:grid;grid-template-columns:44% 56%;font-family:var(--bf)">

  <!-- Cold grid lines bg decoration -->
  <div style="position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.015) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.015) 1px,transparent 1px);background-size:60px 60px;pointer-events:none"></div>
  <div class="glow1" style="width:500px;height:400px;background:radial-gradient(circle,rgba(78,122,144,.06) 0%,transparent 70%);top:20%;right:0"></div>

  <!-- ── LEFT: CONTENT ── -->
  <div style="display:flex;flex-direction:column;justify-content:center;padding:0 44px 0 60px;border-right:1px solid var(--div);position:relative;z-index:2">

    <!-- Headline: condensed stack -->
    <h1 class="e2" style="font-family:var(--hf);font-size:clamp(44px,4.8vw,74px);font-weight:900;line-height:.88;letter-spacing:-.03em;color:var(--txt);margin-bottom:20px">
      ZERO<br>
      FRICTION<br>
      <span style="color:var(--acc)">DONE.</span>
    </h1>

    <!-- Description: tight, technical -->
    <p class="e3" style="font-size:12.5px;color:var(--txt2);line-height:1.8;margin-bottom:24px;max-width:260px;font-weight:300;letter-spacing:.01em">
      Precision reminders. Maximum clarity. Nothing slips.
    </p>

    <!-- Spec tags: technical pills -->
    <div class="e4" style="display:flex;flex-direction:column;gap:8px;margin-bottom:26px">
      <div style="display:flex;align-items:center;gap:10px">
        <div style="width:8px;height:8px;border:1px solid var(--acc);transform:rotate(45deg);flex-shrink:0;opacity:.7"></div>
        <span style="font-size:11px;color:var(--txt2);font-weight:300">Smart priority detection</span>
      </div>
      <div style="display:flex;align-items:center;gap:10px">
        <div style="width:8px;height:8px;border:1px solid var(--acc);transform:rotate(45deg);flex-shrink:0;opacity:.7"></div>
        <span style="font-size:11px;color:var(--txt2);font-weight:300">Cross-platform sync in real time</span>
      </div>
      <div style="display:flex;align-items:center;gap:10px">
        <div style="width:8px;height:8px;border:1px solid var(--acc);transform:rotate(45deg);flex-shrink:0;opacity:.7"></div>
        <span style="font-size:11px;color:var(--txt2);font-weight:300">Focus mode with deep work timer</span>
      </div>
    </div>

    <!-- Store Buttons: flat outlined pair -->
    <div class="e5" style="display:flex;gap:10px;margin-bottom:28px">
      <a href="#" class="sbtn" style="display:flex;align-items:center;gap:10px;background:var(--txt);color:var(--bg);padding:11px 18px;border-radius:10px;flex:1">
        <svg width="13" height="16" viewBox="0 0 814 1000" fill="currentColor"><path d="M788.1 340.9c-5.8 4.5-108.2 62.2-108.2 190.5 0 148.4 130.3 200.9 134.2 202.2-.6 3.2-20.7 71.9-68.7 141.9-42.8 61.6-87.5 123.1-155.5 123.1s-85.5-39.5-164-39.5c-76 0-103.7 40.8-165.9 40.8s-105-57.8-155.5-127.4C46 790.7 0 663 0 541.8c0-194.3 127.4-297.5 252.8-297.5 66.1 0 121.2 43.4 162.7 43.4 39.5 0 101.1-46 176.3-46 28.5 0 130.9 2.6 198.3 99.2zm-234-181.5c31.1-36.9 53.1-88.1 53.1-139.3 0-7.1-.6-14.3-1.9-20.1-50.6 1.9-110.8 33.7-147.1 75.8-28.5 32.4-55.1 83.6-55.1 135.5 0 7.8 1.3 15.6 1.9 18.1 3.2.6 8.4 1.3 13.6 1.3 45.4 0 102.5-30.4 135.5-71.3z"/></svg>
        <div>
          <div style="font-size:7.5px;letter-spacing:.16em;text-transform:uppercase;opacity:.5;margin-bottom:1px;font-family:var(--bf)">Download on</div>
          <div style="font-size:13px;font-family:var(--hf);font-weight:800;letter-spacing:-.02em">App Store</div>
        </div>
      </a>
      <a href="#" class="sbtn" style="display:flex;align-items:center;gap:10px;background:transparent;color:var(--txt);padding:11px 18px;border-radius:10px;border:1px solid rgba(255,255,255,.1);flex:1">
        <svg width="13" height="14" viewBox="0 0 512 512"><path fill="#EA4335" d="M325.3 234.3L104.6 13l280.8 161.2z"/><path fill="#FBBC05" d="M19.7 0C9.5 5.4 0 17.5 0 35.7v440.6c0 18.2 9.5 30.3 19.7 35.7l246.7-246.7z"/><path fill="#34A853" d="M186.7 256l138.6-138.6 60.1 60.1L186.7 316.6z"/><path fill="#4285F4" d="M104.6 499l280.8-161.2-60.1-60.1z"/></svg>
        <div>
          <div style="font-size:7.5px;letter-spacing:.16em;text-transform:uppercase;opacity:.35;margin-bottom:1px;font-family:var(--bf)">Get it on</div>
          <div style="font-size:13px;font-family:var(--hf);font-weight:800;letter-spacing:-.02em">Google Play</div>
        </div>
      </a>
    </div>

    <!-- Stats: data-style grid -->
    <div class="e6" style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:0;border:1px solid var(--div);border-radius:12px;overflow:hidden">
      <div style="padding:14px 18px;border-right:1px solid var(--div)">
        <div style="font-family:var(--hf);font-size:24px;font-weight:800;color:var(--txt);line-height:1;letter-spacing:-.02em">1M+</div>
        <div style="font-size:7.5px;letter-spacing:.2em;text-transform:uppercase;color:var(--txt3);margin-top:5px;font-family:var(--bf)">Users</div>
      </div>
      <div style="padding:14px 18px;border-right:1px solid var(--div)">
        <div style="font-family:var(--hf);font-size:24px;font-weight:800;color:var(--txt);line-height:1;letter-spacing:-.02em">4.9</div>
        <div style="font-size:7.5px;letter-spacing:.2em;text-transform:uppercase;color:var(--txt3);margin-top:5px">Rating</div>
      </div>
      <div style="padding:14px 18px">
        <div style="font-family:var(--hf);font-size:24px;font-weight:800;color:var(--acc);line-height:1;letter-spacing:-.02em">150</div>
        <div style="font-size:7.5px;letter-spacing:.2em;text-transform:uppercase;color:var(--txt3);margin-top:5px">Countries</div>
      </div>
    </div>
  </div>

  <!-- ── RIGHT: PHONES (diagonal arrangement) ── -->
  <div style="position:relative;overflow:hidden;display:flex;align-items:center;justify-content:center">
    <div style="position:relative;width:420px;height:480px">

      <!-- BACK PHONE — upper left, steeper rotation, darker -->
      <div class="pb" style="position:absolute;left:0;top:0;z-index:1;width:190px;height:404px;border-radius:44px;background:var(--pfb);border:1px solid rgba(255,255,255,.04);box-shadow:0 24px 70px rgba(0,0,0,.75)">
        <div style="position:absolute;top:10px;left:50%;transform:translateX(-50%);width:68px;height:20px;background:#000;border-radius:11px;z-index:10"></div>
        <div style="position:absolute;right:-2px;top:68px;width:2px;height:40px;background:rgba(255,255,255,.07);border-radius:1px"></div>
        <div style="position:absolute;left:-2px;top:60px;width:2px;height:19px;background:rgba(255,255,255,.07);border-radius:1px"></div>
        <div style="position:absolute;left:-2px;top:85px;width:2px;height:19px;background:rgba(255,255,255,.07);border-radius:1px"></div>
        <!-- Screen: Calendar view -->
        <div style="position:absolute;inset:2px;border-radius:42px;overflow:hidden;background:var(--sbg);padding:34px 12px 12px">
          <div style="font-size:8px;letter-spacing:.2em;text-transform:uppercase;color:var(--txt3);margin-bottom:10px;font-family:var(--bf)">Calendar · Apr</div>
          <!-- Mini calendar grid -->
          <div style="display:grid;grid-template-columns:repeat(7,1fr);gap:3px;margin-bottom:12px">
            <div style="font-size:7px;color:var(--txt3);text-align:center;font-family:var(--bf)">M</div>
            <div style="font-size:7px;color:var(--txt3);text-align:center">T</div>
            <div style="font-size:7px;color:var(--txt3);text-align:center">W</div>
            <div style="font-size:7px;color:var(--txt3);text-align:center">T</div>
            <div style="font-size:7px;color:var(--txt3);text-align:center">F</div>
            <div style="font-size:7px;color:var(--txt3);text-align:center">S</div>
            <div style="font-size:7px;color:var(--txt3);text-align:center">S</div>
            <!-- Empty first week cells -->
            <div></div><div></div><div style="font-size:8px;color:var(--txt2);text-align:center;padding:3px 0">1</div><div style="font-size:8px;color:var(--txt2);text-align:center;padding:3px 0">2</div><div style="font-size:8px;color:var(--txt2);text-align:center;padding:3px 0">3</div><div style="font-size:8px;color:var(--txt3);text-align:center;padding:3px 0">4</div><div style="font-size:8px;color:var(--txt3);text-align:center;padding:3px 0">5</div>
            <div style="font-size:8px;color:var(--txt2);text-align:center;padding:3px 0">7</div>
            <div style="font-size:8px;color:var(--txt2);text-align:center;padding:3px 0">8</div>
            <div style="font-size:8px;color:var(--txt2);text-align:center;padding:3px 0">9</div>
            <div style="font-size:8px;color:var(--txt2);text-align:center;padding:3px 0">10</div>
            <div style="font-size:8px;color:var(--txt2);text-align:center;padding:3px 0">11</div>
            <div style="font-size:8px;color:var(--txt3);text-align:center;padding:3px 0">12</div>
            <div style="font-size:8px;color:var(--txt3);text-align:center;padding:3px 0">13</div>
            <div style="font-size:8px;color:var(--txt2);text-align:center;padding:3px 0">14</div>
            <div style="font-size:8px;color:var(--txt2);text-align:center;padding:3px 0">15</div>
            <div style="font-size:8px;color:var(--txt2);text-align:center;padding:3px 0">16</div>
            <div style="font-size:8px;color:var(--txt2);text-align:center;padding:3px 0">17</div>
            <div style="font-size:8px;color:var(--txt2);text-align:center;padding:3px 0">18</div>
            <div style="font-size:8px;color:var(--txt3);text-align:center;padding:3px 0">19</div>
            <div style="font-size:8px;color:var(--txt3);text-align:center;padding:3px 0">20</div>
            <div style="font-size:8px;color:var(--txt2);text-align:center;padding:3px 0">21</div>
            <div style="font-size:8px;color:var(--txt2);text-align:center;padding:3px 0">22</div>
            <div style="font-size:8px;color:var(--txt2);text-align:center;padding:3px 0">23</div>
            <div style="font-size:8px;color:var(--txt2);text-align:center;padding:3px 0">24</div>
            <div style="font-size:8px;color:var(--txt2);text-align:center;padding:3px 0">25</div>
            <div style="font-size:8px;color:var(--txt3);text-align:center;padding:3px 0">26</div>
            <div style="width:20px;height:20px;background:var(--acc);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:auto"><span style="font-size:7px;color:#fff;font-weight:600">27</span></div>
          </div>
          <!-- Upcoming items -->
          <div class="np1" style="background:var(--acc2);border:.5px solid var(--acc3);border-radius:10px;padding:8px 10px;margin-bottom:6px">
            <div style="font-size:9px;font-weight:600;color:var(--txt);font-family:var(--bf)">Standup</div>
            <div style="font-size:7.5px;color:var(--acc);margin-top:1px">Today · 9:30</div>
          </div>
          <div class="np2" style="background:rgba(255,255,255,.03);border:.5px solid rgba(255,255,255,.06);border-radius:10px;padding:8px 10px">
            <div style="font-size:9px;font-weight:600;color:var(--txt);font-family:var(--bf)">Design Review</div>
            <div style="font-size:7.5px;color:var(--txt2);margin-top:1px">Today · 14:00</div>
          </div>
        </div>
      </div>

      <!-- FRONT PHONE — lower right, less rotation, lighter, bigger -->
      <div class="pf" style="position:absolute;right:0;bottom:0;z-index:2;width:208px;height:446px;border-radius:46px;background:var(--pfl);border:1px solid rgba(255,255,255,.11);box-shadow:0 44px 110px rgba(0,0,0,.88),0 0 0 .5px rgba(255,255,255,.07)">
        <div style="position:absolute;top:11px;left:50%;transform:translateX(-50%);width:76px;height:22px;background:#000;border-radius:12px;z-index:10;border:.5px solid rgba(255,255,255,.06)"></div>
        <div style="position:absolute;right:-2px;top:72px;width:2px;height:44px;background:rgba(255,255,255,.1);border-radius:1px"></div>
        <div style="position:absolute;left:-2px;top:63px;width:2px;height:21px;background:rgba(255,255,255,.1);border-radius:1px"></div>
        <div style="position:absolute;left:-2px;top:90px;width:2px;height:21px;background:rgba(255,255,255,.1);border-radius:1px"></div>
        <div style="position:absolute;inset:2px;border-radius:44px;overflow:hidden;background:var(--sbg)">
          <div class="car" style="display:flex;width:300%;height:100%">

            <!-- S1: TODAY -->
            <div style="width:33.333%;flex-shrink:0;padding:38px 14px 14px;display:flex;flex-direction:column;background:var(--sbg)">
              <div style="font-size:8px;font-family:var(--bf);letter-spacing:.2em;text-transform:uppercase;color:var(--txt3);margin-bottom:2px">Good morning</div>
              <div style="font-family:var(--hf);font-size:18px;font-weight:800;color:var(--txt);line-height:1;margin-bottom:2px;letter-spacing:-.02em">MONDAY</div>
              <div style="font-size:8px;color:var(--txt2);letter-spacing:.08em;margin-bottom:14px">APR 27 · 3 TASKS</div>
              <div style="display:flex;flex-direction:column;gap:6px;flex:1">
                <div class="ti1" style="background:var(--acc2);border:.5px solid var(--acc3);border-radius:11px;padding:9px 10px;display:flex;align-items:center;gap:8px">
                  <div style="width:2.5px;height:26px;background:var(--acc);border-radius:2px"></div>
                  <div style="flex:1"><div style="font-size:10px;font-weight:600;color:var(--txt);font-family:var(--bf)">Team Standup</div><div style="font-size:7.5px;color:var(--acc);margin-top:2px;opacity:.8">9:30 AM</div></div>
                  <div style="width:15px;height:15px;border-radius:3px;border:1.5px solid var(--acc);opacity:.5"></div>
                </div>
                <div class="ti2" style="background:rgba(255,255,255,.03);border:.5px solid rgba(255,255,255,.07);border-radius:11px;padding:9px 10px;display:flex;align-items:center;gap:8px">
                  <div style="width:2.5px;height:26px;background:rgba(255,255,255,.2);border-radius:2px"></div>
                  <div style="flex:1"><div style="font-size:10px;font-weight:600;color:var(--txt);font-family:var(--bf)">Design Review</div><div style="font-size:7.5px;color:var(--txt2);margin-top:2px">2:00 PM</div></div>
                  <div style="width:15px;height:15px;border-radius:3px;border:1.5px solid rgba(255,255,255,.12)"></div>
                </div>
                <div class="ti3" style="background:rgba(255,255,255,.03);border:.5px solid rgba(255,255,255,.07);border-radius:11px;padding:9px 10px;display:flex;align-items:center;gap:8px">
                  <div style="width:2.5px;height:26px;background:rgba(255,255,255,.14);border-radius:2px"></div>
                  <div style="flex:1"><div style="font-size:10px;font-weight:600;color:var(--txt);font-family:var(--bf)">Gym Session</div><div style="font-size:7.5px;color:var(--txt2);margin-top:2px">6:30 PM</div></div>
                  <div style="width:15px;height:15px;border-radius:3px;border:1.5px solid rgba(255,255,255,.12)"></div>
                </div>
              </div>
              <div style="margin-top:10px;padding:7px 10px;background:rgba(255,255,255,.03);border-radius:10px">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:5px">
                  <span style="font-size:7.5px;color:var(--txt2);font-family:var(--bf)">Daily progress</span>
                  <span style="font-size:8px;color:var(--acc);font-family:var(--hf);font-weight:800">33%</span>
                </div>
                <div style="background:rgba(255,255,255,.05);border-radius:99px;height:2px;overflow:hidden">
                  <div class="bf1" style="height:100%;width:33%;background:var(--acc);border-radius:99px"></div>
                </div>
              </div>
              <div style="display:flex;gap:5px;justify-content:center;margin-top:9px">
                <div class="di1" style="width:14px;height:3px;border-radius:99px;background:var(--acc)"></div>
                <div class="di2" style="width:5px;height:3px;border-radius:99px;background:var(--txt3)"></div>
                <div class="di3" style="width:5px;height:3px;border-radius:99px;background:var(--txt3)"></div>
              </div>
            </div>

            <!-- S2: STATS -->
            <div style="width:33.333%;flex-shrink:0;padding:38px 14px 14px;display:flex;flex-direction:column;align-items:center;background:var(--sbg)">
              <div style="font-size:8px;font-family:var(--bf);letter-spacing:.2em;text-transform:uppercase;color:var(--txt3);margin-bottom:14px;align-self:flex-start">This Week</div>
              <div style="position:relative;width:100px;height:100px;margin-bottom:14px">
                <svg viewBox="0 0 100 100" style="transform:rotate(-90deg);width:100%;height:100%">
                  <circle cx="50" cy="50" r="38" fill="none" stroke="rgba(255,255,255,.05)" stroke-width="5.5"/>
                  <circle cx="50" cy="50" r="38" fill="none" stroke-width="5.5" stroke-linecap="round" stroke-dasharray="239" class="rd" style="stroke:var(--acc)"/>
                </svg>
                <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center">
                  <div style="font-family:var(--hf);font-size:22px;font-weight:800;color:var(--txt);line-height:1">72%</div>
                  <div style="font-size:7px;color:var(--txt3);letter-spacing:.1em;margin-top:1px">DONE</div>
                </div>
              </div>
              <div style="width:100%;display:flex;flex-direction:column;gap:5px">
                <div style="display:flex;align-items:center;gap:6px"><span style="font-size:7px;color:var(--txt3);font-family:var(--bf);width:18px;text-align:right">MON</span><div style="flex:1;background:rgba(255,255,255,.05);border-radius:2px;height:3.5px;overflow:hidden"><div class="bf1" style="height:100%;width:88%;background:var(--acc);border-radius:2px"></div></div><span style="font-size:7px;color:var(--txt2);width:10px">8</span></div>
                <div style="display:flex;align-items:center;gap:6px"><span style="font-size:7px;color:var(--txt3);font-family:var(--bf);width:18px;text-align:right">TUE</span><div style="flex:1;background:rgba(255,255,255,.05);border-radius:2px;height:3.5px;overflow:hidden"><div class="bf2" style="height:100%;width:55%;background:var(--acc);opacity:.65;border-radius:2px"></div></div><span style="font-size:7px;color:var(--txt2);width:10px">5</span></div>
                <div style="display:flex;align-items:center;gap:6px"><span style="font-size:7px;color:var(--txt3);font-family:var(--bf);width:18px;text-align:right">WED</span><div style="flex:1;background:rgba(255,255,255,.05);border-radius:2px;height:3.5px;overflow:hidden"><div class="bf3" style="height:100%;width:66%;background:var(--acc);opacity:.5;border-radius:2px"></div></div><span style="font-size:7px;color:var(--txt2);width:10px">6</span></div>
                <div style="display:flex;align-items:center;gap:6px"><span style="font-size:7px;color:var(--txt3);font-family:var(--bf);width:18px;text-align:right">THU</span><div style="flex:1;background:rgba(255,255,255,.05);border-radius:2px;height:3.5px;overflow:hidden"><div class="bf4" style="height:100%;width:44%;background:var(--acc);opacity:.4;border-radius:2px"></div></div><span style="font-size:7px;color:var(--txt2);width:10px">4</span></div>
                <div style="display:flex;align-items:center;gap:6px"><span style="font-size:7px;color:var(--txt3);font-family:var(--bf);width:18px;text-align:right">FRI</span><div style="flex:1;background:rgba(255,255,255,.05);border-radius:2px;height:3.5px;overflow:hidden"><div class="bf5" style="height:100%;width:22%;background:var(--acc);opacity:.3;border-radius:2px"></div></div><span style="font-size:7px;color:var(--txt2);width:10px">2</span></div>
              </div>
              <div style="display:flex;gap:6px;width:100%;margin-top:10px">
                <div style="flex:1;background:rgba(255,255,255,.03);border-radius:8px;padding:7px 8px;text-align:center;border:.5px solid rgba(255,255,255,.06)"><div style="font-family:var(--hf);font-size:15px;font-weight:800;color:var(--txt)">25</div><div style="font-size:7px;color:var(--txt3);letter-spacing:.08em;margin-top:1px">TOTAL</div></div>
                <div style="flex:1;background:var(--acc2);border:.5px solid var(--acc3);border-radius:8px;padding:7px 8px;text-align:center"><div style="font-family:var(--hf);font-size:15px;font-weight:800;color:var(--acc)">18</div><div style="font-size:7px;color:var(--acc);opacity:.7;letter-spacing:.08em;margin-top:1px">DONE</div></div>
              </div>
              <div style="display:flex;gap:5px;justify-content:center;margin-top:10px">
                <div class="di1" style="width:5px;height:3px;border-radius:2px;background:var(--txt3)"></div>
                <div class="di2" style="width:14px;height:3px;border-radius:2px;background:var(--acc)"></div>
                <div class="di3" style="width:5px;height:3px;border-radius:2px;background:var(--txt3)"></div>
              </div>
            </div>

            <!-- S3: FOCUS -->
            <div style="width:33.333%;flex-shrink:0;padding:38px 14px 14px;display:flex;flex-direction:column;align-items:center;background:var(--sbg)">
              <div style="font-size:8px;font-family:var(--bf);letter-spacing:.2em;text-transform:uppercase;color:var(--txt3);margin-bottom:3px;align-self:flex-start">Focus Mode</div>
              <div style="font-size:8px;color:var(--txt2);margin-bottom:18px;align-self:flex-start">Deep work session</div>
              <div style="position:relative;width:118px;height:118px;display:flex;align-items:center;justify-content:center;margin-bottom:16px">
                <div class="brthO" style="position:absolute;inset:0;border-radius:50%;border:1px solid var(--acc);opacity:.18"></div>
                <div class="brthO2" style="position:absolute;inset:10px;border-radius:50%;border:1px solid var(--acc);opacity:.22"></div>
                <div class="brth" style="width:82px;height:82px;border-radius:50%;background:var(--acc2);border:1px solid var(--acc3);display:flex;flex-direction:column;align-items:center;justify-content:center">
                  <div style="font-family:var(--hf);font-size:22px;font-weight:900;color:var(--txt);line-height:1">24</div>
                  <div style="font-size:7px;color:var(--acc);letter-spacing:.1em;margin-top:1px">MIN</div>
                </div>
              </div>
              <div style="font-size:8.5px;color:var(--txt2);letter-spacing:.12em;text-transform:uppercase;margin-bottom:14px">Breathe in...</div>
              <div style="width:100%;background:rgba(255,255,255,.03);border-radius:10px;padding:9px 11px;border:.5px solid rgba(255,255,255,.05)">
                <div style="font-size:7.5px;color:var(--txt3);letter-spacing:.15em;text-transform:uppercase;margin-bottom:5px;font-family:var(--bf)">Current Task</div>
                <div style="font-size:11px;font-weight:600;color:var(--txt);font-family:var(--bf)">UI Component Library</div>
                <div style="font-size:8px;color:var(--txt2);margin-top:2px">Design · 2h estimated</div>
              </div>
              <div style="margin-top:11px;padding:7px 22px;border-radius:6px;border:1px solid rgba(255,255,255,.08);font-size:8px;letter-spacing:.12em;text-transform:uppercase;color:var(--txt2);cursor:pointer;font-family:var(--bf)">End Session</div>
              <div style="display:flex;gap:5px;justify-content:center;margin-top:12px">
                <div class="di1" style="width:5px;height:3px;border-radius:2px;background:var(--txt3)"></div>
                <div class="di2" style="width:5px;height:3px;border-radius:2px;background:var(--txt3)"></div>
                <div class="di3" style="width:14px;height:3px;border-radius:2px;background:var(--acc)"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

</body>
</html>
