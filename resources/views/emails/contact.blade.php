<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DRemind — New Enquiry Notification</title>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
</head>

<body style="margin:0;padding:0;background:#EFEDE8;font-family:'DM Sans',sans-serif;color:#1A1916;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#EFEDE8;">
        <tr>
            <td align="center" style="padding:40px 20px 60px;">

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
                                        <h1 style="font-family:'Instrument Serif',serif;font-size:34px;line-height:1.15;color:#1A1916;margin:0 0 12px 0;letter-spacing:-.4px;">New Customer <br><em style="font-style:italic;">Enquiry Received</em></h1>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <p style="font-size:14.5px;color:#6B6860;line-height:1.65;max-width:400px;margin:0 auto;">A new enquiry has been submitted through <strong style="color:#1A1916;font-weight:600;">Winngoo D Remind</strong>. Please review the submitted details below.</p>
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

                                <!-- intro -->
                                <tr>
                                    <td style="font-size:14px;color:#4A4740;line-height:1.7;padding-bottom:24px;">
                                        Submitted on
                                        <strong style="color:#1A1916;">
                                            {{ now()->format('d M Y \a\t h:i A') }}
                                        </strong>.
                                        Please review and respond accordingly.
                                    </td>
                                </tr>

                                <!-- name row — two cols -->
                                <tr>
                                    <td style="padding-bottom:16px;">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td width="48%" style="vertical-align:top;background:#F5F3EF;border-radius:10px;padding:14px 16px;">
                                                    <span style="font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#A09D96;display:block;margin-bottom:5px;">First Name</span>
                                                    <span style="font-size:14px;font-weight:600;color:#1A1916;">{{ $data['first_name'] }}</span>
                                                </td>
                                                <td width="4%">&nbsp;</td>
                                                <td width="48%" style="vertical-align:top;background:#F5F3EF;border-radius:10px;padding:14px 16px;">
                                                    <span style="font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#A09D96;display:block;margin-bottom:5px;">Last Name</span>
                                                    <span style="font-size:14px;font-weight:600;color:#1A1916;">{{ $data['last_name'] }}</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <!-- email + phone row -->
                                <tr>
                                    <td style="padding-bottom:16px;">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td width="48%" style="vertical-align:top;background:#F5F3EF;border-radius:10px;padding:14px 16px;">
                                                    <span style="font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#A09D96;display:block;margin-bottom:5px;">Email Address</span>
                                                    <a href="mailto:arun.kumar@example.com" style="font-size:13.5px;font-weight:600;color:#1D4ED8;text-decoration:none;">{{ $data['email'] }}</a>
                                                </td>
                                                <td width="4%">&nbsp;</td>
                                                <td width="48%" style="vertical-align:top;background:#F5F3EF;border-radius:10px;padding:14px 16px;">
                                                    <span style="font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#A09D96;display:block;margin-bottom:5px;">Phone Number</span>
                                                    <span style="font-size:13.5px;font-weight:600;color:#1A1916;">{{ $data['phone'] ?: '-' }}</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <!-- subject full row -->
                                <tr>
                                    <td style="padding-bottom:16px;background:#F5F3EF;border-radius:10px;padding:14px 16px;">
                                        <span style="font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#A09D96;display:block;margin-bottom:5px;">Subject</span>
                                        <span style="font-size:14px;font-weight:600;color:#1A1916;">{{ $data['subject'] }}</span>
                                    </td>
                                </tr>

                                <!-- spacer -->
                                <tr>
                                    <td style="height:16px;font-size:0;">&nbsp;</td>
                                </tr>

                                <!-- message full row -->
                                <tr>
                                    <td style="padding-bottom:28px;background:#F5F3EF;border-radius:10px;padding:14px 16px;">
                                        <span style="font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#A09D96;display:block;margin-bottom:8px;">ENQUIRY MESSAGE</span>
                                        <span style="font-size:13.5px;font-weight:400;color:#4A4740;line-height:1.75;display:block;">{!! nl2br(e($data['message'])) !!}</span>
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
                        <td style="height:3px;background:linear-gradient(90deg,#1D4ED8,#3B82F6,#7C3AED);font-size:0;line-height:0;">&nbsp;</td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>

</html>