
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Verify Your Email — Winngoo D Remind</title>
<link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
</head>
<body style="margin:0;padding:0;background:#EFEDE8;font-family:'DM Sans',sans-serif;color:#1A1916;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#EFEDE8;">
  <tr>
    <td align="center" style="padding:40px 20px 60px;">

      <table width="600" cellpadding="0" cellspacing="0" border="0" style="max-width:600px;background:#FFFFFF;border-radius:16px;overflow:hidden;box-shadow:0 1px 2px rgba(30,28,20,.06),0 4px 12px rgba(30,28,20,.07),0 20px 50px rgba(30,28,20,.1);">

        <!-- stripe top -->
        <tr>
          <td style="height:4px;background:linear-gradient(90deg,#5B21B6,#7C3AED,#A78BFA);font-size:0;line-height:0;">&nbsp;</td>
        </tr>

        <!-- hero -->
        <tr>
          <td align="center" style="padding:40px 48px 30px;">
            <table cellpadding="0" cellspacing="0" border="0">

              <!-- pill -->
              <tr>
                <td align="center" style="padding-bottom:22px;">
                  <span style="display:inline-block;background:#F5F3FF;color:#6D28D9;border:1px solid #DDD6FE;border-radius:100px;padding:4px 16px;font-size:10.5px;font-weight:700;letter-spacing:.5px;">Email Verification</span>
                </td>
              </tr>

              <!-- logo -->
              <tr>
                <td align="center" style="padding-bottom:28px;">
                  <img src="https://www.vishakarex.in/assets/img/projects/d-remind.png" alt="Winngoo D Remind" width="180" style="width:180px;border-radius:18px;display:block;">
                </td>
              </tr>

              <!-- h1 -->
              <tr>
                <td align="center">
                  <h1 style="font-family:'Instrument Serif',serif;font-size:34px;line-height:1.15;color:#1A1916;margin:0 0 16px 0;letter-spacing:-.4px;">Verify Your <br><em style="font-style:italic;color:#7C3AED;">Registered Email</em></h1>
                </td>
              </tr>

              <!-- message -->
              <tr>
                <td align="center">
                  <p style="font-size:14.5px;color:#6B6860;line-height:1.75;max-width:420px;margin:0 auto 6px;">Dear <strong style="color:#4A4740;">{{ $user->first_name }} {{ $user->last_name }}</strong>, thank you for registering. Click the button below to verify your email address and activate your D Remind account.</p>
                </td>
              </tr>

              <tr>
                <td align="center">
                  <p style="font-size:13px;color:#A09D96;line-height:1.6;max-width:400px;margin:10px auto 0;">This confirmation link will expire in <strong style="color:#92400E;">60 minutes</strong>. If you did not create an account, please ignore this email.</p>
                </td>
              </tr>

            </table>
          </td>
        </tr>

        <!-- button -->
        <tr>
          <td align="center" style="padding:10px 48px 24px;">
            <table cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td align="center" style="background:linear-gradient(135deg,#7C3AED,#5B21B6);border-radius:100px;box-shadow:0 4px 18px rgba(124,58,237,.38);">
                  <a href="{{ $verifyUrl }}" style="display:inline-block;padding:16px 52px;font-family:'DM Sans',sans-serif;font-size:15px;font-weight:700;text-decoration:none;letter-spacing:.2px;color:#fff;">
                    Verify Email
                  </a>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        <!-- manual link -->
        <tr>
          <td align="center" style="padding:0 48px 36px;">
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#FAFAF7;border:1px solid #EDE9FE;border-radius:12px;">
              <tr>
                <td style="padding:14px 18px;">
                  <p style="font-size:11.5px;color:#A09D96;margin:0 0 6px 0;">Unable to access the button? Copy and paste the link below into your browser.</p>
                  <a href="{{ $verifyUrl }}" style="font-size:11px;color:#7C3AED;word-break:break-all;margin:0;font-family:'DM Mono',monospace;line-height:1.6;text-decoration:none;">{{ $verifyUrl }}</a>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        <!-- footer -->
        <tr>
          <td align="center" style="padding:22px 48px;background:#FAFAF7;border-top:1px solid #F0EDE8;">
            <p style="font-size:11.5px;color:#B8B3AA;line-height:1.6;margin:0;">&copy; {{date('Y')}} Winngoo Infotech. All rights reserved.</p>
          </td>
        </tr>

        <!-- stripe bottom -->
        <tr>
          <td style="height:3px;opacity:.5;background:linear-gradient(90deg,#5B21B6,#7C3AED,#A78BFA);font-size:0;line-height:0;">&nbsp;</td>
        </tr>

      </table>

    </td>
  </tr>
</table>

</body>
</html>