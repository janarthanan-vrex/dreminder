<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DRemind — Premium Email Templates</title>
  <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
</head>

<body style="margin:0;padding:0;background:#EFEDE8;font-family:'DM Sans',sans-serif;color:#1A1916;">

  <!-- outer wrapper -->
  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#EFEDE8;min-height:100vh;">
    <tr>
      <td align="center" style="padding:40px 20px 60px;">

        <!-- email card -->
        <table width="600" cellpadding="0" cellspacing="0" border="0" style="max-width:600px;background:#FFFFFF;border-radius:16px;overflow:hidden;box-shadow:0 1px 2px rgba(30,28,20,.06),0 4px 12px rgba(30,28,20,.07),0 20px 50px rgba(30,28,20,.1);">

          <!-- stripe top -->
          <tr>
            <td style="height:4px;background:linear-gradient(90deg,#1D4ED8,#3B82F6,#7C3AED);font-size:0;line-height:0;">&nbsp;</td>
          </tr>

          <!-- hero -->
          <tr>
            <td align="center" style="padding:44px 48px 36px;">
              <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td align="center" style="padding-bottom:20px;">
                    <img src="https://www.vishakarex.in/assets/img/projects/d-remind.png" alt="" width="200" style="width:200px;border-radius:18px;display:block;">
                  </td>
                </tr>
                <tr>
                  <td align="center">
                    <h1 style="font-family:'Instrument Serif',serif;font-size:34px;line-height:1.15;color:#1A1916;margin:0 0 12px 0;letter-spacing:-.4px;">Welcome to Winngoo <br><em style="font-style:italic;">D Remind</em></h1>
                  </td>
                </tr>
                <tr>
                  <td align="center">
                    <p style="font-size:14.5px;color:#6B6860;line-height:1.65;max-width:400px;margin:0 auto;">Dear <strong style="color:#1A1916;font-weight:600;">{{ $staff->name }}</strong>, Your D Remind account is now active. Start tracking your reminders and stay updated on important dates.</p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- divider -->
          <tr>
            <td style="padding:0 48px;">
              <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td style="height:1px;background:#F0EDE8;font-size:0;line-height:0;">&nbsp;</td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- body -->
          <tr>
            <td style="padding:32px 48px;">
              <table width="100%" cellpadding="0" cellspacing="0" border="0">

                <!-- intro text -->
                <tr>
                  <td style="font-size:14px;color:#4A4740;line-height:1.7;padding-bottom:22px;">
                    Find your login email below to access your dashboard securely.
                  </td>
                </tr>

                <!-- creds box -->
                <tr>
                  <td style="padding-bottom:24px;">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#FAFAF7;border:1px solid #E8E5DF;border-radius:12px;overflow:hidden;">
                      <!-- creds head -->
                      <tr>
                        <td style="padding:10px 18px;background:#F5F3EF;border-bottom:1px solid #E8E5DF;font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#9C9890;">
                          YOUR REGISTERED EMAIL
                        </td>
                      </tr>
                      <!-- email row -->
                      <tr>
                        <td style="padding:14px 18px;border-bottom:1px solid #F0EDE8;">
                          <span style="font-size:10.5px;color:#9C9890;font-weight:600;display:block;margin-bottom:3px;letter-spacing:.3px;">Email Address</span>
                          <span style="font-size:14px;font-weight:600;color:#1A1916;">{{$staff->email ?? ''}}</span>
                        </td>
                      </tr>
                     
                      <tr>
                        <td style="padding:14px 18px;border-bottom:1px solid #F0EDE8;">
                          <span style="font-size:10.5px;color:#9C9890;font-weight:600;display:block;margin-bottom:3px;letter-spacing:.3px;">Password</span>
                          <span style="font-size:14px;font-weight:600;color:#1A1916;">{{$password ?? ''}}</span>
                        </td>
                      </tr>
                     



                    </table>
                  </td>
                </tr>

               

                <!-- support text -->
                <tr>
                  <td align="center" style="padding-top:10px;font-size:12px;color:#B8B3AA;">
                    For any billing issues or account support, reach us at <a href="mailto:support@dremind.co.uk" style="color:#1D4ED8;text-decoration:none;font-weight:600;">support@dremind.co.uk</a>
                  </td>
                </tr>

              </table>
            </td>
          </tr>

          <!-- footer -->
          <tr>
            <td align="center" style="padding:20px 48px;background:#FAFAF7;border-top:1px solid #F0EDE8;">
              <p style="font-size:11.5px;color:#B8B3AA;line-height:1.6;margin:4px 0 0 0;">&copy; {{ date('Y') }} Winngoo infotech. All rights reserved</p>
            </td>
          </tr>

          <!-- stripe bottom -->
          <tr>
            <td style="height:3px;background:linear-gradient(90deg,#1D4ED8,#3B82F6,#7C3AED);opacity:.5;font-size:0;line-height:0;">&nbsp;</td>
          </tr>

        </table>
        <!-- /email card -->

      </td>
    </tr>
  </table>

  <script>
    function show(id, btn) {
      document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
      document.querySelectorAll('.type-btn').forEach(b => b.classList.remove('active'));
      document.getElementById('page-' + id).classList.add('active');
      btn.classList.add('active');
    }

    function switchVariant(page, num, btn) {
      const variants = document.querySelectorAll('#page-' + page + ' .variant');
      variants.forEach(v => v.classList.remove('active'));
      document.getElementById(page + '-v' + num).classList.add('active');
      btn.closest('.variant-tabs').querySelectorAll('.vtab').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
    }
  </script>
</body>

</html>