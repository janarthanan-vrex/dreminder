
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DRemind — Feedback Email Templates</title>
<link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
</head>
<body style="box-sizing:border-box;margin:0;padding:40px 20px 60px;background:#EFEDE8;font-family:'DM Sans',sans-serif;color:#1A1916;min-height:100vh;">
<!-- ═══════════════════════════════════════════════════
     TEMPLATE 2 — USER REPLY
════════════════════════════════════════════════════ -->

<div style="max-width:600px;margin:0 auto 60px;background:#FFFFFF;border-radius:16px;overflow:hidden;box-shadow:0 1px 2px rgba(30,28,20,.06),0 4px 12px rgba(30,28,20,.07),0 20px 50px rgba(30,28,20,.1);">

  <!-- Top Stripe -->
  <div style="height:4px;background:linear-gradient(90deg,#15803D,#16A34A,#22C55E);"></div>

  <!-- Hero -->
  <div style="padding:44px 48px 36px;text-align:center;">

    <div style="width:200px;border-radius:18px;display:flex;align-items:center;justify-content:center;margin:0 auto;padding:10px 0 20px 0;">
      <img src="https://www.vishakarex.in/assets/img/projects/d-remind.png" alt="D-Remind" style="width:100%;">
    </div>

    <h1 style="font-family:'Instrument Serif',serif;font-size:32px;line-height:1.15;color:#1A1916;margin-bottom:12px;letter-spacing:-.4px;">
      We've <em style="font-style:italic;">reviewed</em> your<br>feedback.
    </h1>

    <p style="font-size:14.5px;color:#6B6860;line-height:1.65;max-width:440px;margin:0 auto;">
      Hi <strong>{{ $user->first_name }} {{ $user->last_name }}</strong>, thank you for taking the time to share your thoughts. Our team has reviewed your submission and has a response for you.
    </p>

  </div>

  <!-- Divider -->
  <div style="height:1px;background:#F0EDE8;margin:0 48px;"></div>

  <!-- Body -->
  <div style="padding:32px 48px;">

    <!-- Original Feedback Summary -->
    <div style="background:#FAFAF7;border:1px solid #E8E5DF;border-radius:12px;overflow:hidden;margin-bottom:22px;">

      <div style="padding:10px 18px;background:#F5F3EF;border-bottom:1px solid #E8E5DF;font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#9C9890;display:flex;align-items:center;gap:6px;">
        <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="#9C9890" stroke-width="2.5">
          <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
        </svg>
        YOUR ORIGINAL FEEDBACK
      </div>

      <!-- Date + Subject -->
      <div style="display:grid;grid-template-columns:1fr 1fr;border-bottom:1px solid #F0EDE8;">
        <div style="padding:14px 18px;">
          <span style="font-size:10.5px;font-weight:600;color:#A09D96;letter-spacing:.3px;display:block;margin-bottom:4px;text-transform:uppercase;">Subject</span>
          <span style="font-size:13.5px;font-weight:600;color:#1A1916;"> {{ $subject }}</span>
        </div>
        
      </div>

      <!-- Original Message -->
      <div style="padding:18px;">
        <span style="font-size:10.5px;font-weight:600;color:#A09D96;letter-spacing:.3px;display:block;margin-bottom:10px;text-transform:uppercase;">Your Message</span>
        <div style="font-size:13.5px;color:#4A4740;line-height:1.7;background:#fff;border:1px solid #EDE9E0;border-radius:8px;padding:14px 16px;font-style:italic;">
           {{ $feedback->message }}

        </div>
      </div>

    </div>

    <!-- Admin Reply Box -->
    <p style="font-size:14px;color:#4A4740;line-height:1.7;margin-bottom:14px;">
      <strong style="color:#1A1916;font-weight:600;">Response from our team:</strong>
    </p>

    <div style="background:linear-gradient(135deg,#F8F5FF,#F0EBFF);border:1.5px solid #DDD6FE;border-radius:12px;padding:20px;margin-bottom:22px;position:relative;border-top:3px solid #7C3AED;">
      <div style="font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#7C3AED;margin-bottom:12px;display:flex;align-items:center;gap:6px;">
        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="#7C3AED" stroke-width="2">
          <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
        </svg>
        Admin Response
      </div>
      <div style="font-size:14px;color:#4A4740;line-height:1.75;">
         {{ $reply }}
      </div>
    </div>
  </div>

  <!-- Footer -->
  <div style="padding:20px 48px;background:#FAFAF7;border-top:1px solid #F0EDE8;text-align:center;">
    <p style="font-size:11.5px;color:#B8B3AA;line-height:1.6;margin-top:6px;">
      &copy; {{date('Y')}} Winngoo Infotech. All rights reserved.
    </p>
  </div>

  <!-- Bottom Stripe -->
  <div style="height:3px;opacity:.5;background:linear-gradient(90deg,#15803D,#16A34A,#22C55E);"></div>

</div>

</body>
</html>