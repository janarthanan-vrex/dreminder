<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Invoice</title>

    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

    <style>
        :root{
            --bg:#f8fafc;
            --panel:#ffffff;
            --panel-2:#f1f5f9;
            --line:#e2e8f0;
            --border:#cbd5e1;
            --text:#1e293b;
            --muted:#64748b;
            --faint:#94a3b8;
            --primary:#7c3aed;
            --accent:#0d9488;
            --success:#10b981;
            --warning:#f59e0b;
            --white:#ffffff;
            --black:#0f172a;
            --radius:20px;
        }

        *{box-sizing:border-box;margin:0;padding:0}
        html,body{height:100%}
        body{font-family: Inter, "Segoe UI", sans-serif;background:
                radial-gradient(circle at top left, rgba(124,58,237,.08), transparent 40%),
                radial-gradient(circle at bottom right, rgba(13,148,136,.06), transparent 35%),linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);color:var(--text);padding:24px;}

        .invoice-shell{max-width:960px;margin:0 auto;}
        .topbar{display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:18px;flex-wrap:wrap;}
        .topbar-title h1{font-size:1.4rem;font-weight:800;color:var(--black);}
        .topbar-title p{font-size:.86rem;color:var(--muted);margin-top:4px;}
        .topbar-actions{display:flex;gap:10px;flex-wrap:wrap;}
        .btn{border:1px solid var(--border);background:var(--white);color:var(--text);border-radius:12px;padding:10px 14px;font-size:.84rem;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:8px;transition:all .2s ease;}
        .btn:hover{background:var(--panel-2);border-color:var(--muted);}
        .btn.primary{background:linear-gradient(135deg,var(--primary),var(--accent));border-color:transparent;color:#fff;}
        .btn.primary:hover{box-shadow:0 8px 20px rgba(124,58,237,.25);transform:translateY(-1px);}
        .invoice-card{background:var(--white);border:1px solid var(--line);border-radius:24px;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,.08);}
        .invoice-head{padding:28px;display:flex;justify-content:space-between;gap:24px;flex-wrap:wrap;border-bottom:1px solid var(--line);background:linear-gradient(135deg, rgba(124,58,237,.06), rgba(13,148,136,.04));}
        .brand{display:flex;flex-direction:column;gap:12px;width: 50%;}
        .brand-mark{width:30%;border-radius:14px;display:grid;place-items:center;color:#fff;font-weight:800;}        .brand-mark img{width:100%;}
        .brand-info h2{font-size:1rem;font-weight:800;color:var(--black);}
        .brand-info p{font-size:.78rem;color:var(--muted);margin-top:4px;line-height:1.5;}
        .invoice-meta{text-align:right;min-width:220px;}
        .invoice-meta h3{font-size:1.25rem;font-weight:800;color:var(--black);}
        .invoice-meta p{font-size:.8rem;color:var(--muted);margin-top:6px;line-height:1.6;}
        .status-badge{display:inline-flex;align-items:center;gap:6px;margin-top:12px;padding:7px 12px;border-radius:999px;font-size:.72rem;font-weight:800;letter-spacing:.03em;}
        .status-badge.completed{color:var(--success);background:rgba(16,185,129,.1);border:1px solid rgba(16,185,129,.3);}
        .status-badge.pending{color:#d97706;background:rgba(245,158,11,.1);border:1px solid rgba(245,158,11,.3);}
        .status-dot{width:7px;height:7px;border-radius:50%;background:currentColor;}
        .invoice-body{padding:28px;}
        .info-grid{display:grid;grid-template-columns:repeat(2, minmax(0,1fr));gap:16px;margin-bottom:20px;}
        .info-box{background:var(--panel-2);border:1px solid var(--line);border-radius:16px;padding:16px;}
        .label{font-size:.69rem;color:var(--faint);text-transform:uppercase;letter-spacing:.12em;font-weight:800;margin-bottom:10px;}
        .info-box .main{font-size:.9rem;font-weight:700;color:var(--black);line-height:1.6;}
        .info-box .sub{font-size:.8rem;color:var(--muted);line-height:1.7;margin-top:4px;}
        .table-wrap{overflow:auto;border:1px solid var(--line);border-radius:18px;margin-bottom:18px;}
        table{width:100%;border-collapse:collapse;min-width:700px;}
        thead th{text-align:left;padding:14px 16px;font-size:.7rem;color:var(--muted);text-transform:uppercase;letter-spacing:.1em;background:var(--panel-2);border-bottom:1px solid var(--line);}
        tbody td{padding:16px;font-size:.84rem;color:var(--text);border-bottom:1px solid var(--line);}
        tbody tr:last-child td{border-bottom:none;}
        tbody tr:hover{background:rgba(124,58,237,.02);}
        .text-right{text-align:right;}
        .summary-row{display:grid;grid-template-columns:1fr 320px;gap:18px;align-items:start;}
        .notes-box, .totals-box{background:var(--panel-2);border:1px solid var(--line);border-radius:18px;padding:18px;}
        .notes-box p{font-size:.82rem;color:var(--muted);line-height:1.8;}
        .totals-list{display:flex;flex-direction:column;gap:12px;}
        .totals-item{display:flex;justify-content:space-between;gap:16px;font-size:.84rem;color:var(--muted);}
        .totals-item strong{color:var(--black);}
        .totals-item.grand{margin-top:6px;padding-top:14px;border-top:1px solid var(--line);font-size:1rem;font-weight:800;}
        .totals-item.grand span:first-child{color:var(--black);}
        .totals-item.grand span:last-child{color:#0d9488;}
        @media (max-width: 768px){
            body{padding:14px}
            .invoice-head,.invoice-body{padding:18px}
            .info-grid,.summary-row{grid-template-columns:1fr}
            .invoice-meta{text-align:left}
        }

        @media print{
            body{background:#fff;padding:0;color:#111827;}
            .topbar{display:none;}
            .invoice-card{box-shadow:none;border:1px solid #e5e7eb;}
            .invoice-head{background:#fff;}
            .brand-info h2,
            .invoice-meta h3,
            .info-box .main,
            tbody td,
            .totals-item strong{color:#111827 !important;}
            .brand-info p,
            .invoice-meta p,
            .info-box .sub,
            .notes-box p,
            thead th,
            .totals-item{color:#475569 !important;}
            .info-box,.notes-box,.totals-box,.table-wrap{background:#fff;border:1px solid #e5e7eb;}
        }
    </style>
</head>
<body>
    <div class="invoice-shell">
        <div class="topbar">
            <div class="topbar-title">
                <h1>Invoice Preview</h1>
                <p>Standalone invoice route opened from your transactions drawer.</p>
            </div>
            <div class="topbar-actions">
                <button class="btn" onclick="window.close()">
                    <i class="ri-close-line"></i> Close
                </button>
                <button class="btn primary" onclick="window.print()">
                    <i class="ri-download-2-line"></i> Download / Print
                </button>
            </div>
        </div>

        <div class="invoice-card">
            <div class="invoice-head">
                <div class="brand">
                    <div class="brand-mark">
                        <img src="https://www.vishakarex.in/assets/img/projects/d-remind.png" alt="">
                    </div>
                    <div class="brand-info">
                        
                        <p>
                            123 Sample Street, Chennai, Tamil Nadu<br>
                            support@yourstore.com · +91 98765 43210
                        </p>
                    </div>
                </div>

                <div class="invoice-meta">
                    <h3 id="invoiceNumber">INV-0000</h3>
                    <p id="invoiceMeta">Invoice date · --</p>
                    <div id="invoiceStatus"></div>
                </div>
            </div>

            <div class="invoice-body">
                <div class="info-grid">
                    <div class="info-box">
                        <div class="label">Bill To</div>
                        <div class="main" id="billName">Customer Name</div>
                        <div class="sub" id="billEmail">customer@email.com</div>
                        <div class="sub">Chennai, Tamil Nadu, India</div>
                    </div>

                    <div class="info-box">
                        <div class="label">Invoice Details</div>
                        <div class="sub">Transaction ID: <span class="main" id="txnIdText" style="font-size:.84rem;font-weight:700"></span></div>
                        <div class="sub">Order Ref: <span class="main" id="orderRefText" style="font-size:.84rem;font-weight:700"></span></div>
                        <div class="sub">Payment Method: Card</div>
                        <div class="sub">Currency: GBP</div>
                    </div>
                </div>

                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Description</th>
                                <th class="text-right">Qty</th>
                                <th class="text-right">Unit</th>
                                <th class="text-right">Tax</th>
                                <th class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody id="itemsTableBody"></tbody>
                    </table>
                </div>

                <div class="summary-row">
                    <div class="notes-box">
                        <div class="label">Notes</div>
                        <p>
                            Thank you for your purchase. This invoice was generated electronically from the transaction panel.
                            Use the Download / Print button above to save it as a PDF from the popup window.
                        </p>
                    </div>

                    <div class="totals-box">
                        <div class="label">Amount Breakdown</div>
                        <div class="totals-list">
                            <div class="totals-item">
                                <span>Subtotal</span>
                                <strong id="subtotalText">£0.00</strong>
                            </div>
                            <div class="totals-item">
                                <span>Discount</span>
                                <strong id="discountText">£0.00</strong>
                            </div>
                            <div class="totals-item">
                                <span>VAT(18%)</span>
                                <strong id="taxText">£0.00</strong>
                            </div>
                            <div class="totals-item grand">
                                <span>Total Due</span>
                                <span id="grandTotalText">£0.00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
(function(){
    const q = new URLSearchParams(window.location.search);

    const txnId = q.get('txn_id') || 'TXN-0000';
    const orderRef = q.get('order_ref') || 'ORD-0000';
    const customerName = q.get('customer_name') || 'Customer Name';
    const customerEmail = q.get('customer_email') || 'customer@example.com';
    const amount = parseFloat(q.get('amount') || '0');
    const status = q.get('status') || 'pending';
    const date = q.get('date') || '—';

    let items = [];
    try{items = JSON.parse(q.get('items') || '[]');}
    catch(e){items = [];}
    if(!Array.isArray(items) || !items.length){items = ['Basic Plan'];}

    const invoiceNumber = 'INV-' + txnId.replace('TXN-', '');
    const subtotal = amount;
    const discount = 0;
    const tax = +(subtotal * 0.18).toFixed(2);
    const grandTotal = +(subtotal + tax - discount).toFixed(2);
    const unitPrice = items.length ? subtotal / items.length : subtotal;

    document.getElementById('invoiceNumber').textContent = invoiceNumber;
    document.getElementById('invoiceMeta').textContent = `Invoice date · ${date}`;
    document.getElementById('billName').textContent = customerName;
    document.getElementById('billEmail').textContent = customerEmail;
    document.getElementById('txnIdText').textContent = txnId;
    document.getElementById('orderRefText').textContent = orderRef;
    document.getElementById('subtotalText').textContent = `£${subtotal.toFixed(2)}`;
    document.getElementById('discountText').textContent = `£${discount.toFixed(2)}`;
    document.getElementById('taxText').textContent = `£${tax.toFixed(2)}`;
    document.getElementById('grandTotalText').textContent = `£${grandTotal.toFixed(2)}`;

    document.getElementById('invoiceStatus').innerHTML = status === 'completed'
        ? `<span class="status-badge completed"><span class="status-dot"></span>Paid</span>`
        : `<span class="status-badge pending"><span class="status-dot"></span>Pending</span>`;

    document.getElementById('itemsTableBody').innerHTML = items.map((item, i) => `
        <tr>
            <td>${i + 1}</td>
            <td>${item}</td>
            <td class="text-right">1</td>
            <td class="text-right">£${unitPrice.toFixed(2)}</td>
            <td class="text-right">18%</td>
            <td class="text-right">£${unitPrice.toFixed(2)}</td>
        </tr>
    `).join('');
})();
</script>
</body>
</html>