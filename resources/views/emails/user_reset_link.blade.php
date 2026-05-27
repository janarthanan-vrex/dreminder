<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DRemind — Forgot Password</title>
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
                        <td style="height:4px;background:linear-gradient(90deg,#B45309,#D97706,#F59E0B);font-size:0;line-height:0;">&nbsp;</td>
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
                                    <td align="center" style="padding-bottom:12px;">
                                        <span style="font-size:10.5px;font-weight:700;letter-spacing:2.5px;text-transform:uppercase;color:#D97706;">Password Reset</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <h1 style="font-family:'Instrument Serif',serif;font-size:34px;line-height:1.15;color:#1A1916;margin:0 0 12px 0;letter-spacing:-.4px;">Update Your <br><em style="font-style:italic;">D Remind Account Password.</em></h1>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <p style="font-size:14.5px;color:#6B6860;line-height:1.65;max-width:400px;margin:0 auto;">Dear <strong style="color:#1A1916;font-weight:600;">{{ $user->first_name }} {{ $user->last_name }}</strong>, your password reset request has been received. Use the button below to securely update your password.</p>
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

                                <!-- button -->
                                <tr>
                                    <td align="center" style="padding-bottom:22px;">
                                        <table cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td align="center" style="background:#B45309;border-radius:100px;">
                                                    <a href="{{ url('/reset-password/'.$token.'?email='.$email) }}"
                                                        style="display:inline-block;padding:14px 36px;font-family:'DM Sans',sans-serif;font-size:14px;font-weight:700;text-decoration:none;letter-spacing:.2px;color:#fff;">
                                                        Reset Your Password &nbsp;&#8594;
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>

                    <!-- expiry bar -->
                    <tr>
                        <td style="background:#FEF3C7;border-top:1px solid #FDE68A;padding:12px 48px;font-size:12.5px;color:#92400E;font-weight:500;">
                            This password reset link is valid for the next <strong style="font-weight:700;color:#78350F;">15 minutes</strong>.
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
                        <td style="height:3px;opacity:.5;background:linear-gradient(90deg,#B45309,#D97706,#F59E0B);font-size:0;line-height:0;">&nbsp;</td>
                    </tr>

                </table>

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