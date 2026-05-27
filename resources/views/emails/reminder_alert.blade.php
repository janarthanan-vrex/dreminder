
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>RemindMe — Premium Email Templates</title>
<link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
</head>
<body style="margin:0;padding:0;background:#EFEDE8;font-family:'DM Sans',sans-serif;color:#1A1916;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#EFEDE8;">
  <tr>
    <td align="center" style="padding:40px 20px 60px;">

      <!-- email card -->
      <table width="600" cellpadding="0" cellspacing="0" border="0" style="max-width:600px;background:#FFFFFF;border-radius:16px;overflow:hidden;box-shadow:0 1px 2px rgba(30,28,20,.06),0 4px 12px rgba(30,28,20,.07),0 20px 50px rgba(30,28,20,.1);">

        <!-- stripe top -->
        <tr>
          <td style="height:4px;background:linear-gradient(90deg,#BE123C,#E11D48,#F43F5E);font-size:0;line-height:0;">&nbsp;</td>
        </tr>

        <!-- hero -->
        <tr>
          <td align="center" style="padding:30px 48px 36px;">
            <table cellpadding="0" cellspacing="0" border="0">

              <!-- cat pill -->
              <tr>
                <td align="center" style="padding-bottom:20px;">
                  <span style="display:inline-block;background:#F0FDF4;color:#15803D;border:1px solid #BBF7D0;border-radius:100px;padding:3px 12px;font-size:10.5px;font-weight:700;letter-spacing:.5px;">{{ $reminder->title ?? '' }} Reminder</span>
                </td>
              </tr>

              <!-- logo -->
              <tr>
                <td align="center" style="padding-bottom:20px;">
                  <img src="https://www.vishakarex.in/assets/img/projects/d-remind.png" alt="" width="200" style="width:200px;border-radius:18px;display:block;">
                </td>
              </tr>

              <!-- h1 -->
              <tr>
                <td align="center">
                  <h1 style="font-family:'Instrument Serif',serif;font-size:34px;line-height:1.15;color:#1A1916;margin:0 0 12px 0;letter-spacing:-.4px;">
                    @if(!empty($reminder->payment_frequency))
                        {{$reminder->payment_frequency ?? ''}}
                    @endif
                    
                  
                  <br><em style="font-style:italic;">{{ $reminder->title ?? '' }}</em></h1>
                </td>
              </tr>

              <!-- sub -->
              <tr>
                <td align="center">
                  <p style="font-size:14.5px;color:#6B6860;line-height:1.65;max-width:400px;margin:0 auto;">Hi <strong style="color:#4A4740;">{{$user->first_name ?? ''}} {{$user->last_name ?? ''}}</strong> — {{ $reminder->title ?? '' }} reminder is due today.</p>
                </td>
              </tr>

            </table>
          </td>
        </tr>

        <!-- body -->
        <tr>
          <td style="padding:15px 48px;">
            <table width="100%" cellpadding="0" cellspacing="0" border="0">

              <!-- detail card -->
              <tr>
                <td style="padding-bottom:22px;">
                  <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#FAFAF7;border:1px solid #E8E5DF;border-radius:12px;overflow:hidden;">

                    <!-- category — time remaining removed -->
                    <tr>
                      <td style="padding:12px 18px;border-bottom:1px solid #F0EDE8;">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                          <tr>
                            <td width="100%" style="vertical-align:top;">
                              <span style="font-size:10.5px;font-weight:600;color:#A09D96;letter-spacing:.3px;display:block;margin-bottom:4px;text-transform:uppercase;">Category</span>
                              <span style="font-size:13px;font-weight:600;color:#1A1916;background:#F5F3EF;border:1px solid #E0DDD6;border-radius:8px;padding:4px 12px;display:inline-block;margin-top:2px;">{{ $reminder->category->name ?? '' }}
</span>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>

                    <!-- subcategory -->
                    <tr>
                      <td style="padding:12px 18px;border-bottom:1px solid #F0EDE8;">
                        <span style="font-size:10.5px;font-weight:600;color:#A09D96;letter-spacing:.3px;display:block;margin-bottom:4px;text-transform:uppercase;">Subcategory</span>
                        <span style="font-size:13.5px;font-weight:600;color:#1A1916;">{{ $reminder->subcategory->name ?? '' }}
</span>
                      </td>
                    </tr>

                    <!-- provider -->
                   @if(!empty($reminder->provider))
<tr>
    <td style="padding:13px 18px;border-bottom:1px solid #F0EDE8;">
        <span style="font-size:10.5px;font-weight:600;color:#A09D96;letter-spacing:.3px;display:block;margin-bottom:4px;text-transform:uppercase;">
            Provider
        </span>

        <span style="font-size:13.5px;font-weight:600;color:#1A1916;">
            {{ $reminder->provider }}
        </span>
    </td>
</tr>
@endif

                   @if(!empty($reminder->cost))
<tr>
    <td style="padding:13px 18px;border-bottom:1px solid #F0EDE8;">
        <span style="font-size:10.5px;font-weight:600;color:#A09D96;letter-spacing:.3px;display:block;margin-bottom:4px;text-transform:uppercase;">
            Amount Summary
        </span>

        <span style="font-size:15px;font-weight:700;color:#15803D;">
            &#8377;{{ number_format($reminder->cost, 2) }}
        </span>
    </td>
</tr>
@endif

                    <!-- important notes -->
                   @if(!empty($reminder->description))
<tr>
    <td style="padding:13px 18px;">
        <span style="font-size:10.5px;font-weight:600;color:#A09D96;letter-spacing:.3px;display:block;margin-bottom:4px;text-transform:uppercase;">
            Important Notes
        </span>

        <span style="font-size:13px;font-weight:400;color:#6B6860;line-height:1.5;display:block;">
            {{ $reminder->description }}
        </span>
    </td>
</tr>
@endif

                  </table>
                </td>
              </tr>

              <!-- button -->
              <tr>
                <td align="center" style="padding-bottom:12px;">
                  <table cellpadding="0" cellspacing="0" border="0">
                    <tr>
                      <td align="center" style="background:#BE123C;border-radius:100px;">
                        <a href="{{route('user.reminders')}}" style="display:inline-block;padding:14px 36px;font-family:'DM Sans',sans-serif;font-size:14px;font-weight:700;text-decoration:none;letter-spacing:.2px;color:#fff;">
                          View Reminder &nbsp;&#8594;
                        </a>
                       
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>

            </table>
          </td>
        </tr>

        <!-- footer -->
        <tr>
          <td align="center" style="padding:20px 48px;background:#FAFAF7;border-top:1px solid #F0EDE8;">
            <p style="font-size:11.5px;color:#B8B3AA;line-height:1.6;margin:4px 0 0 0;">&copy; {{date('Y')}} Winngoo infotech. All rights reserved</p>
          </td>
        </tr>

        <!-- stripe bottom -->
        <tr>
          <td style="height:3px;opacity:.5;background:linear-gradient(90deg,#BE123C,#E11D48,#F43F5E);font-size:0;line-height:0;">&nbsp;</td>
        </tr>

      </table>

    </td>
  </tr>
</table>

</body>
</html>