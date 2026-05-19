<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reminder Alert</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f1f5f9; color: #1e293b; }
        .wrapper { max-width: 560px; margin: 32px auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,.08); }
        .header { background: linear-gradient(135deg, #7c3aed, #0d9488); padding: 32px 32px 24px; text-align: center; }
        .header .bell { font-size: 2.5rem; margin-bottom: 10px; }
        .header h1 { color: #fff; font-size: 1.3rem; font-weight: 700; letter-spacing: -.01em; }
        .header p { color: rgba(255,255,255,.75); font-size: .85rem; margin-top: 5px; }
        .body { padding: 28px 32px; }
        .greeting { font-size: 1rem; font-weight: 600; color: #1e293b; margin-bottom: 6px; }
        .intro { font-size: .88rem; color: #64748b; line-height: 1.6; margin-bottom: 22px; }
        .reminder-card { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 18px; margin-bottom: 22px; }
        .reminder-card .label { font-size: .65rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #94a3b8; margin-bottom: 3px; }
        .reminder-card .value { font-size: .9rem; font-weight: 600; color: #1e293b; margin-bottom: 12px; }
        .reminder-card .value:last-child { margin-bottom: 0; }
        .reminder-card .badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: .72rem; font-weight: 700; background: rgba(124,58,237,.1); color: #7c3aed; border: 1px solid rgba(124,58,237,.2); }
        .cta { text-align: center; margin-bottom: 22px; }
        .cta a { display: inline-block; background: linear-gradient(135deg, #7c3aed, #0d9488); color: #fff; text-decoration: none; padding: 12px 28px; border-radius: 10px; font-size: .88rem; font-weight: 700; }
        .divider { border: none; border-top: 1px solid #e2e8f0; margin: 20px 0; }
        .footer { padding: 0 32px 28px; text-align: center; font-size: .75rem; color: #94a3b8; line-height: 1.7; }
        .footer a { color: #7c3aed; text-decoration: none; }
    </style>
</head>
<body>
    <div class="wrapper">

        <!-- Header -->
        <div class="header">
            <div class="bell">🔔</div>
            <h1>Reminder Alert</h1>
            <p>You have an upcoming reminder that needs your attention</p>
        </div>

        <!-- Body -->
        <div class="body">

            <div class="greeting">Hi {{ $user->first_name ?? 'there' }},</div>
            <p class="intro">
                This is your scheduled reminder from <strong>Winngoo</strong>.
                Please review the details below and take any necessary action.
            </p>

            <!-- Reminder Card -->
            <div class="reminder-card">

                <div class="label">Reminder Title</div>
                <div class="value">{{ $reminder->title }}</div>

                <div class="label">Category</div>
                <div class="value">
                    {{ $category->name ?? 'N/A' }}
                    @if($reminder->subcategory)
                        &rarr; {{ $reminder->subcategory->name }}
                    @endif
                </div>

                <div class="label">Due Date &amp; Time</div>
                <div class="value">
                    {{ \Carbon\Carbon::parse($reminder->reminder_date)->format('d M Y') }}
                    at
                    {{ \Carbon\Carbon::parse($reminder->reminder_time)->format('h:i A') }}
                </div>

                @if($reminder->provider)
                <div class="label">Provider</div>
                <div class="value">{{ $reminder->provider }}</div>
                @endif

                @if($reminder->cost)
                <div class="label">Cost</div>
                <div class="value">£{{ number_format($reminder->cost, 2) }}
                    @if($reminder->payment_frequency)
                        <span style="font-weight:400;color:#64748b;font-size:.82rem">/ {{ $reminder->payment_frequency }}</span>
                    @endif
                </div>
                @endif

                @if($reminder->description)
                <div class="label">Notes</div>
                <div class="value" style="font-weight:400;color:#475569;font-size:.85rem">{{ $reminder->description }}</div>
                @endif

                <div class="label" style="margin-top:4px">Status</div>
                <div class="value"><span class="badge">Active</span></div>

            </div>

            <!-- CTA -->
            <div class="cta">
                <a href="{{ config('app.url') }}/reminders">View My Reminders</a>
            </div>

            <hr class="divider">

            <p style="font-size:.82rem;color:#64748b;line-height:1.6;text-align:center">
                You're receiving this because you enabled email notifications in your
                <a href="{{ config('app.url') }}/notifications" style="color:#7c3aed">notification settings</a>.
                You can update or disable alerts at any time.
            </p>

        </div>

        <!-- Footer -->
        <div class="footer">
            &copy; {{ date('Y') }} Winngoo. All rights reserved.<br>
            <a href="{{ config('app.url') }}">winngoo.com</a>
        </div>

    </div>
</body>
</html>