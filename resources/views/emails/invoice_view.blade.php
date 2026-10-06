<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Invoice</title>

    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

    <style>
        :root {
            --bg: #f8fafc;
            --panel: #ffffff;
            --panel-2: #f1f5f9;
<<<<<<< HEAD
            --line: #e2e8f0;
            --border: #cbd5e1;
=======
            --line: #cbd5e1; /* was #e2e8f0 — slightly darker */
            --border: #94a3b8; /* was #cbd5e1 — slightly darker */
>>>>>>> 14b4245 (full updated code)
            --text: #1e293b;
            --muted: #64748b;
            --faint: #94a3b8;
            --primary: #7c3aed;
            --accent: #0d9488;
            --success: #10b981;
            --warning: #f59e0b;
            --white: #ffffff;
            --black: #0f172a;
            --radius: 20px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0
        }

        html,
        body {
            height: 100%
        }

        body {
            font-family: Inter, "Segoe UI", sans-serif;
            background:
                radial-gradient(circle at top left, rgba(124, 58, 237, .08), transparent 40%),
                radial-gradient(circle at bottom right, rgba(13, 148, 136, .06), transparent 35%), linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
            color: var(--text);
            padding: 24px;
        }

        .invoice-shell {
            max-width: 960px;
            margin: 0 auto;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
            flex-wrap: wrap;
        }

        .topbar-title h1 {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--black);
        }

        .topbar-title p {
            font-size: .86rem;
            color: var(--muted);
            margin-top: 4px;
        }

        .topbar-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            border: 1px solid var(--border);
            background: var(--white);
            color: var(--text);
            border-radius: 12px;
            padding: 10px 14px;
            font-size: .84rem;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all .2s ease;
        }

        .btn:hover {
            background: var(--panel-2);
            border-color: var(--muted);
        }

        .btn.primary {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-color: transparent;
            color: #fff;
        }

        .btn.primary:hover {
            box-shadow: 0 8px 20px rgba(124, 58, 237, .25);
            transform: translateY(-1px);
        }

        .invoice-card {
            background: var(--white);
            border: 1px solid var(--line);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .08);
        }

        /* ── HEADER ── */
        .invoice-head {
            padding: 28px;
            border-bottom: 1px solid var(--line);
            background: linear-gradient(135deg, rgba(124, 58, 237, .06), rgba(13, 148, 136, .04));
        }

        .head-table {
            width: 100%;
            border-collapse: collapse;
        }

        .head-table td {
            vertical-align: top;
            padding: 0;
        }

        .brand {
            width: 55%;
        }

        .brand-mark {
<<<<<<< HEAD
            width: 30%;
=======
            width: 50%;
>>>>>>> 14b4245 (full updated code)
            border-radius: 14px;
            display: grid;
            place-items: center;
            color: #fff;
            font-weight: 800;
        }

        .brand-mark img {
            width: 100%;
        }

        .brand-info h2 {
            font-size: 1rem;
            font-weight: 800;
            color: var(--black);
        }

        .brand-info p {
            font-size: .78rem;
            color: var(--muted);
            margin-top: 4px;
            line-height: 1.5;
        }

        .invoice-meta {
            text-align: right;
            min-width: 220px;
        }

        .invoice-meta h3 {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--black);
        }

        .invoice-meta p {
            font-size: .8rem;
            color: var(--muted);
            margin-top: 6px;
            line-height: 1.6;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 12px;
            padding: 7px 12px;
            border-radius: 999px;
            font-size: .72rem;
            font-weight: 800;
            letter-spacing: .03em;
        }

        .status-badge.completed {
            color: var(--success);
            background: rgba(16, 185, 129, .1);
            border: 1px solid rgba(16, 185, 129, .3);
        }

        .status-badge.pending {
            color: #d97706;
            background: rgba(245, 158, 11, .1);
            border: 1px solid rgba(245, 158, 11, .3);
        }

        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: currentColor;
        }

        /* ── BODY ── */
        .invoice-body {
            padding: 28px;
        }

        /* ── INFO GRID ── */
        .info-grid-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 8px 0;
            margin-bottom: 20px;
            table-layout: fixed;
        }

        .info-grid-table td {
            vertical-align: top;
            background: var(--panel-2);
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 16px;
        }

        .info-box {
            background: var(--panel-2);
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 16px;
        }

        .label {
            font-size: .69rem;
<<<<<<< HEAD
            color: var(--faint);
=======
            color: #717d8e;
>>>>>>> 14b4245 (full updated code)
            text-transform: uppercase;
            letter-spacing: .12em;
            font-weight: 800;
            margin-bottom: 10px;
        }

<<<<<<< HEAD
        .info-box .main {
            font-size: .9rem;
            font-weight: 700;
            color: var(--black);
            line-height: 1.6;
        }

        .info-box .sub {
            font-size: .8rem;
            color: var(--muted);
            line-height: 1.7;
            margin-top: 4px;
        }

        /* ── ITEMS TABLE ── */
        .table-wrap {
            overflow: auto;
            border: 1px solid var(--line);
            border-radius: 18px;
            margin-bottom: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 700px;
        }

=======
        /*.info-box .main {*/
        /*    font-size: .9rem;*/
        /*    font-weight: 700;*/
        /*    color: var(--black);*/
        /*    line-height: 1.6;*/
        /*    word-break:break-all;*/
        /*}*/

        /*.info-box .sub {*/
        /*    font-size: .8rem;*/
        /*    color: var(--muted);*/
        /*    color:#363636;*/
        /*    line-height: 1.7;*/
        /*    margin-top: 4px;*/
        /*    word-break:break-all;*/
        /*}*/
        .info-box .main {
    font-size: .9rem;
    /*font-weight: 700;*/
    color: var(--black);
    line-height: 1.6;
    word-break: break-all;
    overflow-wrap: break-word;
    white-space: normal;
    max-width: 100%;
    display: block;
}

.info-box .sub {
    font-size: .8rem;
    color: #363636;
    line-height: 1.7;
    margin-top: 4px;
    word-break: break-all;
    overflow-wrap: break-word;
    white-space: normal;
    max-width: 100%;
    display: block;
}

        /* ── ITEMS TABLE ── */
        /*.table-wrap {*/
        /*    overflow: auto;*/
        /*    border: 1px solid var(--line);*/
        /*    border-radius: 18px;*/
        /*    margin-bottom: 18px;*/
        /*}*/
        .table-wrap {
    overflow: hidden; 
    border: 1px solid var(--line);
    border-radius: 18px;
    margin-bottom: 18px;
}

        /*table {*/
        /*    width: 100%;*/
        /*    border-collapse: collapse;*/
        /*    min-width: 700px;*/
        /*}*/
table {
    width: 100%;
    border-collapse: collapse;
    min-width: unset;  /* remove the forced min-width */
    table-layout: fixed;  /* forces columns to stay within bounds */
}
>>>>>>> 14b4245 (full updated code)
        thead th {
            text-align: left;
            padding: 14px 16px;
            font-size: .7rem;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .1em;
            background: var(--panel-2);
            border-bottom: 1px solid var(--line);
        }

        tbody td {
            padding: 16px;
            font-size: .84rem;
            color: var(--text);
            border-bottom: 1px solid var(--line);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr:hover {
            background: rgba(124, 58, 237, .02);
        }

        .text-right {
            text-align: right;
        }

        /* ── SUMMARY ROW ── */
        .summary-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 8px 0;
            table-layout: fixed;
        }

        .summary-table td {
            vertical-align: top;
            padding: 0;
        }

        .summary-table .td-totals {
            width: 320px;
        }

        .notes-box,
        .totals-box {
            background: var(--panel-2);
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 18px;
        }

        .notes-box p {
            font-size: .82rem;
            color: var(--muted);
            line-height: 1.8;
        }

        .totals-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .totals-item {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            font-size: .84rem;
            color: var(--muted);
        }

        .totals-item strong {
            color: var(--black);
        }

        .totals-item.grand {
            margin-top: 6px;
            padding-top: 14px;
            border-top: 1px solid var(--line);
            font-size: 1rem;
            font-weight: 800;
        }

        .totals-item.grand span:first-child {
            color: var(--black);
        }

        .totals-item.grand span:last-child {
            color: #0d9488;
        }

        @media (max-width: 768px) {
            body {
                padding: 14px
            }

            .invoice-head,
            .invoice-body {
                padding: 18px
            }

            .invoice-meta {
                text-align: left
            }
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
                color: #111827;
            }

            .topbar {
                display: none;
            }

            .invoice-card {
                box-shadow: none;
                border: 1px solid #e5e7eb;
            }

            .invoice-head {
                background: #fff;
            }

            .brand-info h2,
            .invoice-meta h3,
            .info-box .main,
            tbody td,
            .totals-item strong {
                color: #111827 !important;
            }

            .brand-info p,
            .invoice-meta p,
            .info-box .sub,
            .notes-box p,
            thead th,
            .totals-item {
                color: #475569 !important;
            }

            .info-grid-table td,
            .notes-box,
            .totals-box,
            .table-wrap {
                background: var(--panel-2);
                border: 1px solid #e5e7eb;
            }
        }
        
        .totals-item {
          display: flex;
          justify-content: space-between;
          align-items: center;
        }
        
        .totals-item span:first-child,
        .totals-item strong:first-child {
          text-align: left;
        }
        
        .totals-item span:last-child,
        .totals-item strong:last-child {
          text-align: right;
        }
        .totals-item strong,
        .totals-item .amount {
          margin-left: auto;
          text-align: right;
        }
     
       
    </style>

</head>

<body>
    <div class="invoice-shell">

        {{-- TOPBAR --}}
        <div class="topbar">
            <div class="topbar-title">
                <h1>Invoice Preview</h1>
<<<<<<< HEAD
                <p>Standalone invoice route opened from your transactions drawer.</p>
=======
                
>>>>>>> 14b4245 (full updated code)
            </div>
        </div>

        <div class="invoice-card">

            {{-- HEADER --}}
            <div class="invoice-head">
                <table class="head-table">
                    <tr>
                        <td class="brand">
                            <div class="brand-mark">
                                @php
                                $path = public_path('assets/images/common/d-remind.png');
                                $type = pathinfo($path, PATHINFO_EXTENSION);
                                $data = file_get_contents($path);
                                $logo = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                @endphp
                                <img src="{{ $logo }}" alt="d-reminder-logo">
                            </div>
                            <div class="brand-info">
                                <p>
<<<<<<< HEAD
                                    123 Sample Street, Chennai, Tamil Nadu<br>
                                    support@yourstore.com · +91 98765 43210
=======
                                    Unit 5, Martinbridge Trading Estate,<br>
                                    240-242 Lincoln Road,<br>
                                    Enfield,
                                    EN1 1SP.
>>>>>>> 14b4245 (full updated code)
                                </p>
                            </div>
                        </td>

                        <td class="invoice-meta">
                            <h3>{{ $invoiceId ?? 'INV-0000' }}</h3>
                            <p>Invoice date · {{ $issueDate ?? now()->format('d M Y') }}</p>
                            <div>
                                @if(($isPaid ?? false))
                                <span class="status-badge completed">
                                    <span class="status-dot"></span>Paid
                                </span>
                                @else
                                <span class="status-badge pending">
                                    <span class="status-dot"></span>Pending
                                </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            {{-- BODY --}}
            <div class="invoice-body">

                {{-- BILL TO | INVOICE DETAILS --}}
                <table class="info-grid-table">
                    <tr>
                        <td class="info-box">
                            <div class="label">Bill To</div>
                            <div class="main">
                                {{ trim((optional($user)->first_name ?? '') . ' ' . (optional($user)->last_name ?? '')) ?: 'Customer' }}
                            </div>
                            <div class="sub">
                                {{ optional($user)->email ?? '-' }}
                            </div>
                            <div class="sub">
                                {{ optional($user)->address1 ?? '' }}
                                {{ optional($user)->address2 ?? '' }}
                                {{ optional($user)->postcode ?? '' }}
                            </div>
                        </td>

                        <td class="info-box">
<<<<<<< HEAD
                            <div class="label">Invoice Details</div>
                            <div class="sub">
                                Transaction ID:
                                <span class="main">
                                    {{ optional($payment)->stripe_payment_id ?? '-' }}
                                </span>
                            </div>
                            <div class="sub">
                                Order Ref:
                                <span class="main">
                                    {{ $invoiceId ?? '-' }}
                                </span>
                            </div>
=======
                            <!--<div class="label">Invoice Details</div>-->
                            <!--<div class="sub ">-->
                            <!--    Transaction ID:-->
                            <!--    <span class="main">-->
                            <!--        {{ optional($payment)->stripe_payment_id ?? '-' }}-->
                            <!--    </span>-->
                            <!--</div>-->
                            <!--<div class="sub ">-->
                            <!--    Order Ref:-->
                            <!--    <span class="main">-->
                            <!--        {{ $invoiceId ?? '-' }}-->
                            <!--    </span>-->
                            <!--</div>-->
>>>>>>> 14b4245 (full updated code)
                            <div class="sub">
                                Payment Method:
                                {{ ucfirst(optional($payment)->payment_mode ?? 'card') }}
                            </div>
                            <div class="sub">
                                Currency:
                                {{ optional($payment)->currency ?? 'GBP' }}
                            </div>
                        </td>
                    </tr>
                </table>

                {{-- TABLE --}}
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
<<<<<<< HEAD
                                <th>#</th>
                                <th>Description</th>
                                <th class="text-right">Qty</th>
                                <th class="text-right">Unit</th>
                                <th class="text-right">VAT</th>
                                <th class="text-right">Total</th>
=======
                                <th>S.No</th>
                                <th>Plan Name</th>
                                <!--<th class="text-right">Qty</th>-->
                                <th class="text-right">Plan Price</th>
                                <!--<th class="text-right">VAT</th>-->
                                <!--<th class="text-right">Total</th>-->
>>>>>>> 14b4245 (full updated code)
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>{{ optional($plan)->plan_name ?? 'Subscription Plan' }}</td>
<<<<<<< HEAD
                                <td class="text-right">1</td>
=======
                                <!--<td class="text-right">1</td>-->
>>>>>>> 14b4245 (full updated code)
                                <td class="text-right">
                                    {{ $currencySymbol ?? '£' }}
                                    {{ number_format($basePrice ?? 0, 2) }}
                                </td>
<<<<<<< HEAD
                                <td class="text-right">
                                    {{ number_format($vatAmount ?? 0, 2) }}
                                </td>
                                <td class="text-right">
                                    {{ $currencySymbol ?? '£' }}
                                    {{ number_format($finalAmount ?? 0, 2) }}
                                </td>
=======
                                <!--<td class="text-right">-->
                                <!--    {{ number_format($vatAmount ?? 0, 2) }}-->
                                <!--</td>-->
                                <!--<td class="text-right">-->
                                <!--    {{ $currencySymbol ?? '£' }}-->
                                <!--    {{ number_format($finalAmount ?? 0, 2) }}-->
                                <!--</td>-->
>>>>>>> 14b4245 (full updated code)
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- SUMMARY --}}
                <table class="summary-table">
                    <tr>
                        <td class="td-notes">
                            <div class="notes-box">
                                <div class="label">Notes</div>
                                <p>
                                    Thank you for your purchase. This invoice was generated automatically.
                                </p>
                            </div>
                        </td>

<<<<<<< HEAD
                        <td class="td-totals">
                            <div class="totals-box">
                                <div class="label">Amount Breakdown</div>

                                <div class="totals-list">
                                    <div class="totals-item">
                                        <span>Subtotal</span>
                                        <strong>
                                            {{ $currencySymbol ?? '£' }}
                                            {{ number_format($basePrice ?? 0, 2) }}
                                        </strong>
                                    </div>

                                    <div class="totals-item">
                                        <span>Discount</span>
                                        <strong>
                                            -{{ $currencySymbol ?? '£' }}
                                            {{ number_format($discount ?? 0, 2) }}
                                        </strong>
                                    </div>

                                    <div class="totals-item">
                                        <span>VAT</span>
                                        <strong>
                                            {{ $currencySymbol ?? '£' }}
                                            {{ number_format($vatAmount ?? 0, 2) }}
                                        </strong>
                                    </div>

                                    <div class="totals-item grand">
                                        <span>Total Due</span>
                                        <span>
                                            {{ $currencySymbol ?? '£' }}
                                            {{ number_format($finalAmount ?? 0, 2) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>
=======
                       <td class="td-totals">
    <div class="totals-box">
        <div class="label">Amount Breakdown</div>
        <table style="width:100%; border-collapse:collapse; font-size:.84rem;">
            <tr>
                <td style="padding:4px 0; color:#64748b;">Subtotal</td>
                <td style="padding:4px 0; color:#0f172a; font-weight:700; text-align:right;">{{ $currencySymbol ?? '£' }} {{ number_format($basePrice ?? 0, 2) }}</td>
            </tr>
            <tr>
                <td style="padding:4px 0; color:#64748b;">Discount</td>
                <td style="padding:4px 0; color:#0f172a; font-weight:700; text-align:right;">-{{ $currencySymbol ?? '£' }} {{ number_format($discount ?? 0, 2) }}</td>
            </tr>
            <tr>
                <td style="padding:4px 0; color:#64748b;">VAT</td>
                <td style="padding:4px 0; color:#0f172a; font-weight:700; text-align:right;">{{ $currencySymbol ?? '£' }} {{ number_format($vatAmount ?? 0, 2) }}</td>
            </tr>
            <tr>
                <td colspan="2" style="padding:0;"><hr style="border:none; border-top:1px solid #e2e8f0; margin:8px 0;"></td>
            </tr>
            <tr>
                <td style="padding:4px 0; color:#0f172a; font-weight:800; font-size:1rem;">Total Amount</td>
                <td style="padding:4px 0; color:#0d9488; font-weight:800; font-size:1rem; text-align:right;">{{ $currencySymbol ?? '£' }} {{ number_format($finalAmount ?? 0, 2) }}</td>
            </tr>
        </table>
    </div>
</td>
>>>>>>> 14b4245 (full updated code)
                    </tr>
                </table>

            </div>
        </div>
    </div>
</body>

</html>