<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Invoice {{ $invoiceId ?? '' }}</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }

  body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 12px;
    color: #1a1a2e;
    background: #ffffff;
    padding: 36px 40px;
  }

  .header-table { width: 100%; margin-bottom: 28px; border-bottom: 3px solid #7c3aed; padding-bottom: 20px; }
  .brand-name   { font-size: 24px; font-weight: 700; color: #7c3aed; }
  .brand-sub    { font-size: 10px; color: #888; margin-top: 3px; }
  .inv-title    { font-size: 26px; font-weight: 700; color: #7c3aed; text-transform: uppercase; letter-spacing: 2px; text-align: right; }
  .inv-number   { font-size: 11px; color: #666; text-align: right; margin-top: 4px; }

  .badge-paid    { display: inline-block; background: #d1fae5; color: #065f46; font-size: 9px; font-weight: 700; text-transform: uppercase; padding: 3px 10px; border-radius: 12px; }
  .badge-pending { display: inline-block; background: #fef3c7; color: #92400e; font-size: 9px; font-weight: 700; text-transform: uppercase; padding: 3px 10px; border-radius: 12px; }

  .meta-table   { width: 100%; margin-bottom: 28px; border-spacing: 10px 0; border-collapse: separate; }
  .meta-cell    { width: 50%; background: #f8f7ff; border: 1px solid #ede9fe; border-radius: 6px; padding: 14px 16px; }
  .meta-label   { font-size: 9px; text-transform: uppercase; color: #7c3aed; font-weight: 700; margin-bottom: 8px; }
  .meta-name    { font-size: 13px; font-weight: 700; }
  .meta-text    { font-size: 11px; color: #444; line-height: 1.7; }

  .items-table  { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
  .items-table thead tr { background: #7c3aed; color: #ffffff; }
  .items-table thead th { padding: 9px 12px; font-size: 10px; text-align: left; }
  .items-table thead th.right { text-align: right; }
  .items-table tbody td { padding: 10px 12px; font-size: 12px; border-bottom: 1px solid #ede9fe; }
  .items-table tbody td.right { text-align: right; font-weight: 600; }

  .totals-wrap  { width: 260px; margin-left: auto; margin-bottom: 28px; }
  .totals-table { width: 100%; border-collapse: collapse; }
  .totals-table td { padding: 5px 4px; font-size: 12px; border-bottom: 1px solid #ede9fe; }
  .totals-table td.right { text-align: right; font-weight: 600; }
  .totals-table tr.discount td { color: #059669; }
  .totals-table tr.total td { font-size: 14px; font-weight: 700; color: #7c3aed; border-bottom: none; }

  .thankyou { text-align: center; background: #f8f7ff; border-radius: 6px; padding: 12px; margin-bottom: 24px; }

  .footer-table { width: 100%; margin-top: 28px; border-top: 1px solid #ede9fe; padding-top: 12px; }
  .footer-table td { font-size: 10px; color: #aaa; }
  .footer-table td.right { text-align: right; }
  .footer-table td.center { text-align: center; }
</style>
</head>
<body>

<table class="header-table">
  <tr>
    <td>
      <div class="brand-name">DReminder</div>
      <div class="brand-sub">Bill &amp; Subscription Reminder Service</div>
    </td>
    <td style="text-align:right;">
      <div class="inv-title">Invoice</div>
      <div class="inv-number"># {{ $invoiceId ?? '' }}</div>
      <div style="margin-top:6px;">
        @if(($isPaid ?? false))
          <span class="badge-paid">Paid</span>
        @else
          <span class="badge-pending">Pending</span>
        @endif
      </div>
    </td>
  </tr>
</table>

<table class="meta-table">
  <tr>
    <td class="meta-cell">
      <div class="meta-label">Bill To</div>
      <div class="meta-name">{{ ($user->first_name ?? '') }} {{ ($user->last_name ?? '') }}</div>
      <div class="meta-text">{{ $user->email ?? '' }}</div>
      <div class="meta-text">{{ $user->phone ?? '' }}</div>
      <div class="meta-text">
        {{ $user->address1 ?? '' }}
        {{ isset($user->address2) ? ', '.$user->address2 : '' }}
      </div>
      <div class="meta-text">{{ $user->postcode ?? '' }}, {{ $user->country ?? '' }}</div>
    </td>

    <td class="meta-cell">
      <div class="meta-label">Invoice Details</div>
      <div class="meta-text"><strong>Invoice No:</strong> {{ $invoiceId ?? '' }}</div>
      <div class="meta-text"><strong>Issue Date:</strong> {{ $issueDate ?? '' }}</div>
      <div class="meta-text"><strong>Due Date:</strong> {{ $dueDate ?? '' }}</div>
      <div class="meta-text"><strong>Payment Method:</strong> Card (Stripe)</div>
      <div class="meta-text"><strong>Transaction ID:</strong> {{ $payment->stripe_payment_id ?? '' }}</div>
    </td>
  </tr>
</table>

<table class="items-table">
  <thead>
    <tr>
      <th>#</th>
      <th>Description</th>
      <th>Period</th>
      <th class="right">Amount</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>1</td>
      <td>
        {{ $plan->plan_name ?? '' }} Plan
        @if(!empty($couponCode))
          <div>Coupon: {{ $couponCode }}</div>
        @endif
      </td>
      <td>
        {{ now()->format('d M Y') }} -<br>
        {{ now()->addYear()->format('d M Y') }}
      </td>
      <td class="right">
        {{ $currencySymbol ?? '' }}{{ number_format($plan->total_price ?? 0, 2) }}
      </td>
    </tr>

    @if(($vatAmount ?? 0) > 0)
    <tr>
      <td>2</td>
      <td>VAT</td>
      <td></td>
      <td class="right">{{ $currencySymbol ?? '' }}{{ number_format($vatAmount ?? 0, 2) }}</td>
    </tr>
    @endif
  </tbody>
</table>

<div class="totals-wrap">
  <table class="totals-table">
    <tr>
      <td>Subtotal</td>
      <td class="right">{{ $currencySymbol ?? '' }}{{ number_format($plan->total_price ?? 0, 2) }}</td>
    </tr>

    @if(($discount ?? 0) > 0)
    <tr class="discount">
      <td>Discount</td>
      <td class="right">- {{ $currencySymbol ?? '' }}{{ number_format($discount ?? 0, 2) }}</td>
    </tr>
    @endif

    <tr class="total">
      <td>Total Paid</td>
      <td class="right">{{ $currencySymbol ?? '' }}{{ number_format($finalAmount ?? 0, 2) }}</td>
    </tr>
  </table>
</div>

<div class="thankyou">Thank you for your payment!</div>

<table class="footer-table">
  <tr>
    <td>DReminder &copy; {{ now()->year }}</td>
    <td class="center">Auto-generated invoice</td>
    <td class="right">support@dreminder.co.uk</td>
  </tr>
</table>

</body>
</html>