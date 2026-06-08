<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DRemind — Premium Email Templates</title>
  <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
 
</head>

<body style="margin:0;padding:0;background:#EFEDE8;font-family:Arial,sans-serif;">

<div style="max-width:600px;margin:20px auto;background:#FFFFFF;border-radius:16px;overflow:hidden;box-shadow:0 4px 12px rgba(0,0,0,0.08);">

    <div style="height:4px;background:#7C3AED;"></div>

    <!-- Hero -->
    <div style="padding:44px 48px 36px;text-align:center;">
        <div style="width:200px;margin:0 auto;padding:10px 0 20px;">
            <img src="https://www.vishakarex.in/assets/img/projects/d-remind.png"
                 alt="D-Remind"
                 style="width:100%;display:block;">
        </div>

        <h1 style="font-family:Georgia,serif;font-size:34px;line-height:1.15;color:#1A1916;margin:0 0 12px;">
            Welcome to Your <br>
            <em>Staff Portal.</em>
        </h1>

        <p style="font-size:14.5px;color:#6B6860;line-height:1.65;margin:0;">
            Dear <strong>{{ $staff->name }}</strong>,
            Your D Remind staff account has been created successfully.
            You can now access the platform using the details below.
        </p>
    </div>

    <div style="height:1px;background:#F0EDE8;margin:0 48px;"></div>

    <!-- Body -->
    <div style="padding:32px 48px;">

        <p style="font-size:14px;color:#4A4740;line-height:1.7;margin:0 0 22px;">
            Please find your login credentials below.
        </p>

        <!-- Credentials -->
        <div style="background:#FAFAF7;border:1px solid #E8E5DF;border-radius:12px;overflow:hidden;margin-bottom:24px;">

            <div style="padding:10px 18px;background:#F5F3EF;border-bottom:1px solid #E8E5DF;font-size:10px;font-weight:bold;letter-spacing:2px;text-transform:uppercase;color:#9C9890;">
                STAFF ACCOUNT DETAILS
            </div>

            <div style="padding:14px 18px;border-bottom:1px solid #F0EDE8;">
                <span style="font-size:10.5px;color:#9C9890;font-weight:600;display:block;margin-bottom:3px;">
                    Staff Name
                </span>
                <span style="font-size:14px;font-weight:600;color:#1A1916;">
                    {{ $staff->name ?? '' }}
                </span>
            </div>

            <div style="padding:14px 18px;border-bottom:1px solid #F0EDE8;">
                <span style="font-size:10.5px;color:#9C9890;font-weight:600;display:block;margin-bottom:3px;">
                    Email Address
                </span>
                <span style="font-size:14px;font-weight:600;color:#1A1916;">
                    {{ $staff->email ?? '' }}
                </span>
            </div>

            <div style="padding:14px 18px;border-bottom:1px solid #F0EDE8;">
                <span style="font-size:10.5px;color:#9C9890;font-weight:600;display:block;margin-bottom:3px;">
                    Assigned Position
                </span>
                <span style="font-size:14px;font-weight:600;color:#1A1916;">
                    {{ $staff->roles?->rolename ?? 'No Role Assigned' }}
                </span>
            </div>

            <div style="padding:14px 18px;">
                <span style="font-size:10.5px;color:#9C9890;font-weight:600;display:block;margin-bottom:3px;">
                    Temporary Password
                </span>
                <span style="font-size:13px;font-family:monospace;letter-spacing:2px;font-weight:600;color:#1A1916;">
                    {{ $password ?? '' }}
                </span>
            </div>

        </div>

        <!-- Security Notice -->
        <div style="background:#EFF6FF;border:1px solid #BFDBFE;border-radius:10px;padding:14px 16px;margin-bottom:22px;">
            <div style="font-size:12.5px;font-weight:700;color:#1E40AF;margin-bottom:4px;">
                🔐 Security Guidance
            </div>

            <div style="font-size:12px;line-height:1.55;color:#1E3A8A;">
                Please update your password after your first login and keep your account information secure.
            </div>
        </div>

        <!-- CTA Button -->
        <div style="text-align:center;margin-bottom:16px;">
            <a href="{{ route('admin.loginpage') }}"
               style="display:inline-block;background:#7C3AED;color:#FFFFFF;text-decoration:none;padding:14px 36px;border-radius:50px;font-size:14px;font-weight:700;">
                Access Your Account →
            </a>
        </div>

        <!-- Support -->
        <div style="text-align:center;margin-top:10px;">
            <span style="font-size:12px;color:#B8B3AA;">
                Need assistance? Contact your administrator or
                <a href="mailto:support@dremind.co.uk"
                   style="color:#7C3AED;text-decoration:none;font-weight:600;">
                    support@dremind.co.uk
                </a>
            </span>
        </div>

    </div>

    <!-- Footer -->
    <div style="padding:20px 48px;background:#FAFAF7;border-top:1px solid #F0EDE8;text-align:center;">
        <p style="font-size:11.5px;color:#B8B3AA;line-height:1.6;margin:0;">
            &copy; {{ date('Y') }} Winngoo Infotech. All rights reserved.
        </p>
    </div>

    <div style="height:3px;background:#7C3AED;"></div>

</div>

</body>

</html>