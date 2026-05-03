<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Payment Successful — DReminder</title>
<style>
  body { margin:0; padding:0; background:#f3f0ff; font-family: Arial, sans-serif; }
  .wrapper { max-width:600px; margin:0 auto; background:#ffffff; border-radius:12px; overflow:hidden; }
  .header { background: linear-gradient(135deg,#7c3aed,#6d28d9); padding:40px 32px; text-align:center; }
  .header h1 { color:#fff; font-size:24px; margin:0 0 6px; }
  .header p  { color:rgba(255,255,255,0.75); font-size:14px; margin:0; }
  .body { padding:32px; }
  .greeting { font-size:16px; color:#1a1a2e; font-weight:600; margin-bottom:12px; }
  .text { font-size:14px; color:#555; line-height:1.7; margin-bottom:20px; }
  .summary-box {
    background:#f8f7ff; border:1px solid #ede9fe; border-radius:8px;
    padding:20px 24px; margin-bottom:24px;
  }
  .summary-box h3 { font-size:13px; text-transform:uppercase; letter-spacing:0.08em; color:#7c3aed; margin:0 0 14px; }
  .summary-row { display:flex; justify-content:space-between; font-size:13px; color:#444; padding:5px 0; border-bottom:1px solid #ede9fe; }
  .summary-row:last-child { border-bottom:none; font-weight:700; color:#7c3aed; font-size:15px; padding-top:10px; }
  .summary-row span:last-child { font-weight:600; }
  .cta { text-align:center; margin:28px 0; }
  .cta a {
    display:inline-block; background:linear-gradient(135deg,#7c3aed,#6d28d9);
    color:#fff; text-decoration:none; padding:14px 36px; border-radius:50px;
    font-size:14px; font-weight:700; letter-spacing:0.03em;
  }
  .note { font-size:12px; color:#999; line-height:1.6; margin-bottom:20px; }
  .footer { background:#f8f7ff; padding:20px 32px; text-align:center; font-size:11px; color:#aaa; }
  .footer a { color:#7c3aed; text-decoration:none; }
</style>
</head>
<body>
<div class="wrapper">

  {{-- Header --}}
  <div class="header">
    <h1>🎉 Payment Successful!</h1>
    <p>Your DReminder account is now active</p>
  </div>

  {{-- Body --}}
  <div class="body">
    <p class="greeting">Hi {{ $user->first_name }},</p>

    <p class="text">
      Thank you for subscribing to DReminder. Your payment has been processed successfully
      and your account is ready to use. Please find your invoice attached to this email as a PDF.
    </p>

    {{-- Order Summary --}}
    <div class="summary-box">
      <h3>Payment Summary</h3>
      <div class="summary-row">
        <span>Plan</span>
        <span>{{ $plan->plan_name }}</span>
      </div>
      <div class="summary-row">
        <span>Invoice No.</span>
        <span>{{ $invoiceId }}</span>
      </div>
      <div class="summary-row">
        <span>Date</span>
        <span>{{ now()->format('d M Y') }}</span>
      </div>
      @if($discount > 0)
      <div class="summary-row" style="color:#059669;">
        <span>Discount Applied</span>
        <span>− £{{ number_format($discount, 2) }}</span>
      </div>
      @endif
      <div class="summary-row">
        <span>Total Paid</span>
        <span>£{{ number_format($amount, 2) }}</span>
      </div>
    </div>

    <p class="text">
      Your subscription is valid for one year from today. We'll notify you before it's
      time to renew so you never miss a thing.
    </p>

    {{-- CTA --}}
    <div class="cta">
      <a href="{{ route('user.magic.login', ['id' => $user->id, 'token' => $user->email_verification_code]) }}"
   style="display:inline-block; background:linear-gradient(135deg, #14836a 0%, #5289a6 100%); color:white; text-decoration:none; padding:16px 45px; border-radius:8px; font-weight:600; font-size:15px; box-shadow:0 4px 15px rgba(102,126,234,0.3);">
   Access Dashboard →
</a>
    </div>

    <p class="note">
      If you have any questions about your invoice or account, please contact us at
      <a href="mailto:support@dreminder.co.uk" style="color:#7c3aed;">support@dreminder.co.uk</a>.
      Your invoice PDF is attached to this email for your records.
    </p>
  </div>

  {{-- Footer --}}
  <div class="footer">
    &copy; {{ now()->year }} DReminder &nbsp;|&nbsp;
    <a href="{{ route('loginpage') }}">Login</a> &nbsp;|&nbsp;
    <a href="mailto:support@dreminder.co.uk">Support</a>
  </div>

</div>
</body>
</html>