

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winngoo D-Remind — Never Miss A Event Again</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/common/favicon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/frontend/index.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <script>
      tailwind.config={theme:{extend:{
        colors:{primary:'#7c3aed',secondary:'#06b6d4',accent:'#10b981',dark:'#030014',surface:'#0a0a1f',card:'#0f0f2a'},
        fontFamily:{sans:['Inter','system-ui','sans-serif']}
      }}}
    </script>
    <style>/* ===================================================
   DOWNLOAD APP SECTION (.o2) — RESPONSIVE OVERRIDES
   =================================================== */

/* ---------- TABLET (769px - 1024px) ---------- */
@media (min-width: 769px) and (max-width: 1024px) {

    .o2 {
        grid-template-columns: 50% 50% !important;
        height: auto !important;
        min-height: 70vh !important;
        padding: 60px 0 !important;
    }

    .o2 > div:first-child {
        padding: 0 30px 0 40px !important;
    }

    .o2 h1 {
        font-size: clamp(36px, 5vw, 56px) !important;
    }

    .o2 p {
        max-width: 100% !important;
    }

    .o2 .sbtn {
        padding: 10px 14px !important;
    }

    /* Phone container */
    .o2 > div:last-child > div {
        width: 340px !important;
        height: 400px !important;
    }

    .o2 > div:last-child img:first-child {
        width: 160px !important;
    }

    .o2 > div:last-child img:last-child {
        width: 175px !important;
    }
}

/* ---------- MOBILE (max-width: 768px) ---------- */
@media (max-width: 768px) {

    .o2 {
        grid-template-columns: 1fr !important;
        grid-template-rows: auto auto !important;
        height: auto !important;
        padding: 50px 0 !important;
    }

    .o2 > div:first-child {
        padding: 0 24px !important;
        border-right: none !important;
        border-bottom: 1px solid var(--div) !important;
        padding-bottom: 30px !important;
        text-align: center !important;
        align-items: center !important;
    }

    .o2 h1 {
        font-size: clamp(32px, 9vw, 44px) !important;
        text-align: center !important;
    }

    .o2 p.e3 {
        max-width: 100% !important;
        text-align: center !important;
        margin-left: auto !important;
        margin-right: auto !important;
    }

    .o2 .e4 {
        align-items: center !important;
    }

    .o2 .e4 > div {
        justify-content: center !important;
    }

    .o2 .e5 {
        flex-direction: column !important;
        width: 100% !important;
        max-width: 320px !important;
        margin: 0 auto 28px !important;
    }

    .o2 .sbtn {
        flex: none !important;
        width: 100% !important;
        justify-content: center !important;
    }

    /* Phone images section */
    .o2 > div:last-child {
        min-height: 320px !important;
        padding: 20px 0 !important;
    }

    .o2 > div:last-child > div {
        width: 280px !important;
        height: 320px !important;
    }

    .o2 > div:last-child img:first-child {
        width: 130px !important;
    }

    .o2 > div:last-child img:last-child {
        width: 145px !important;
    }
}

/* ---------- SMALL MOBILE (max-width: 420px) ---------- */
@media (max-width: 420px) {

    .o2 > div:first-child {
        padding: 0 16px !important;
    }

    .o2 > div:last-child > div {
        width: 240px !important;
        height: 280px !important;
    }

    .o2 > div:last-child img:first-child {
        width: 110px !important;
    }

    .o2 > div:last-child img:last-child {
        width: 122px !important;
    }
}</style>
  </head>
  <body>

    <!-- LOADER -->
    <!-- <div id="loader">
      <img src="{{ asset('assets/images/common/loader.gif') }}" alt="">
    </div> -->
    <div id="loader">
        <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.9.10/dist/dotlottie-wc.js" type="module"></script>
      <dotlottie-wc src="https://lottie.host/9e89873a-1424-4d8a-85de-8eaf04ba6f2a/x6B0SnIuaY.lottie" style="width: 300px;height: 300px" autoplay loop></dotlottie-wc>
    </div>

    <!-- CURSOR -->
    <div class="cursor-ring" id="cursorRing"></div>
    <div class="cursor-dot" id="cursorDot"></div>

    <!-- SCROLL PROGRESS -->
    <div class="scroll-progress" id="scrollProg" style="width:0%"></div>

    <!-- BACK TO TOP -->
    <div class="back-top" id="backTop"><i class="ri-arrow-up-line"></i></div>

    <!-- ===== NAVIGATION ===== -->
        @include('components.header')
        @yield('content')


    <section class="o2" style="height:80vh;background:var(--bg);overflow:hidden;position:relative;display:grid;grid-template-columns:44% 56%;font-family:var(--bf)">
        <div id="grid-distortion-container" style="z-index:1; width: 100%; top: 0; height: 100%; position: absolute;"></div>
      <!-- Cold grid lines bg decoration -->
      <div style="position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.015) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.015) 1px,transparent 1px);background-size:60px 60px;pointer-events:none"></div>
      <div class="glow1" style="width:500px;height:400px;background:radial-gradient(circle,rgba(78,122,144,.06) 0%,transparent 70%);top:20%;right:0"></div>

      <!-- ── LEFT: CONTENT ── -->
      <div style="display:flex;flex-direction:column;justify-content:center;padding:0 44px 0 60px;border-right:1px solid var(--div);position:relative;z-index:2">

        <!-- Headline: condensed stack -->
        <h1 class="e2" style="font-family:var(--hf);font-size:clamp(44px,4.8vw,74px);font-weight:900;line-height:.88;letter-spacing:-.03em;color:var(--txt);margin-bottom:20px">
          YOUR<br>
          REMINDERS<br>
          <span style="color:var(--acc)">ANYWHERE</span>
          
        </h1>

        <!-- Description: tight, technical -->
        <p class="e3" style="font-size:14.5px;color:#eef2fa;line-height:1.8;margin-bottom:24px;max-width:260px;font-weight:300;letter-spacing:.01em">
          Install our app to access and manage your reminders anytime with a simple, reliable experience.
        </p>

        <!-- Spec tags: technical pills -->
        <div class="e4" style="display:flex;flex-direction:column;gap:8px;margin-bottom:26px">
          <div style="display:flex;align-items:center;gap:10px">
            <div style="width:8px;height:8px;border:1px solid var(--acc);transform:rotate(45deg);flex-shrink:0;opacity:.7"></div>
            <span style="font-size:13px;color:#eef2fa;font-weight:300">Instant reminder updates across devices</span>
          </div>
          <div style="display:flex;align-items:center;gap:10px">
            <div style="width:8px;height:8px;border:1px solid var(--acc);transform:rotate(45deg);flex-shrink:0;opacity:.7"></div>
            <span style="font-size:13px;color:#eef2fa;font-weight:300">Timely alerts wherever you are</span>
          </div>
          <div style="display:flex;align-items:center;gap:10px">
            <div style="width:8px;height:8px;border:1px solid var(--acc);transform:rotate(45deg);flex-shrink:0;opacity:.7"></div>
            <span style="font-size:13px;color:#eef2fa;font-weight:300">Clean and easy-to-use interface</span>
          </div>
        </div>

        <!-- Store Buttons: flat outlined pair -->
        <div class="e5" style="display:flex;gap:10px;margin-bottom:28px">
          <a href="#" class="sbtn" style="display:flex;align-items:center;gap:10px;background:var(--txt);color:var(--bg);padding:11px 18px;border-radius:10px;flex:1">
            <svg width="13" height="16" viewBox="0 0 814 1000" fill="currentColor"><path d="M788.1 340.9c-5.8 4.5-108.2 62.2-108.2 190.5 0 148.4 130.3 200.9 134.2 202.2-.6 3.2-20.7 71.9-68.7 141.9-42.8 61.6-87.5 123.1-155.5 123.1s-85.5-39.5-164-39.5c-76 0-103.7 40.8-165.9 40.8s-105-57.8-155.5-127.4C46 790.7 0 663 0 541.8c0-194.3 127.4-297.5 252.8-297.5 66.1 0 121.2 43.4 162.7 43.4 39.5 0 101.1-46 176.3-46 28.5 0 130.9 2.6 198.3 99.2zm-234-181.5c31.1-36.9 53.1-88.1 53.1-139.3 0-7.1-.6-14.3-1.9-20.1-50.6 1.9-110.8 33.7-147.1 75.8-28.5 32.4-55.1 83.6-55.1 135.5 0 7.8 1.3 15.6 1.9 18.1 3.2.6 8.4 1.3 13.6 1.3 45.4 0 102.5-30.4 135.5-71.3z"/></svg>
            <div>
              <div style="font-size:7.5px;letter-spacing:.16em;text-transform:uppercase;opacity:.9;margin-bottom:1px;font-family:var(--bf)">Download on</div>
              <div style="font-size:13px;font-family:var(--hf);font-weight:800;letter-spacing:-.02em">App Store</div>
            </div>
          </a>
          <a href="#" class="sbtn" style="display:flex;align-items:center;gap:10px;background:transparent;color:var(--txt);padding:11px 18px;border-radius:10px;border:1px solid rgba(255,255,255,.3);flex:1">
            <svg width="13" height="14" viewBox="0 0 512 512" fill="white" xmlns="http://www.w3.org/2000/svg">
  <path d="M325.3 234.3L104.6 13l280.8 161.2z"/>
  <path d="M19.7 0C9.5 5.4 0 17.5 0 35.7v440.6c0 18.2 9.5 30.3 19.7 35.7l246.7-246.7z"/>
  <path d="M186.7 256l138.6-138.6 60.1 60.1L186.7 316.6z"/>
  <path d="M104.6 499l280.8-161.2-60.1-60.1z"/>
</svg>
            <div>
              <div style="font-size:7.5px;letter-spacing:.16em;text-transform:uppercase;opacity:.35;margin-bottom:1px;font-family:var(--bf)">Get it on</div>
              <div style="font-size:13px;font-family:var(--hf);font-weight:800;letter-spacing:-.02em">Google Play</div>
            </div>
          </a>
        </div>
      </div>

      <!-- ── RIGHT: PHONES (diagonal arrangement) ── -->
      <!-- RIGHT SIDE -->
<div style="position:relative;overflow:hidden;display:flex;align-items:center;justify-content:center">
  
  <div style="position:relative;width:420px;height:480px">

    <!-- BACK PHONE IMAGE -->
    <img 
      src="{{ asset('assets/images/mobile/mob-2.webp') }}"
      alt=""
      style="
        position:absolute;
        left:0;
        top:0;
        width:190px;
        height:auto;
        transform:rotate(-12deg);
        z-index:1;
        animation: floatBack 4s ease-in-out infinite;
      "
    >

    <!-- FRONT PHONE IMAGE -->
    <img 
      src="{{ asset('assets/images/mobile/mob-1.webp') }}"
      alt=""
      style="
        position:absolute;
        right:0;
        bottom:0;
        width:208px;
        height:auto;
        transform:rotate(10deg);
        z-index:2;
        animation: floatFront 4s ease-in-out infinite;
      "
    >

  </div>
</div>
    </section>


    @include('components.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="{{ asset('assets/js/index.js') }}"></script>


  </body>
</html>
