@extends('user.layouts.app')
@section('content')

<section id="page-membership" class="">
    <div style="margin-bottom:16px">
        <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800;color:#f1f5f9">Membership & Billing</h2>
        <p style="font-size:.82rem;color:#64748b;margin-top:3px">Manage your subscription and billing information</p>
    </div>
    <div class="plan-grad" style="padding:24px;margin-bottom:20px;position:relative;overflow:hidden">
        <div style="position:absolute;top:-60px;right:-60px;width:180px;height:180px;border-radius:50%;background:rgba(124,58,237,.08);pointer-events:none"></div>
        <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:16px;flex-wrap:wrap;gap:10px">
            <div>
                <div style="font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.12em;color:rgba(167,139,250,.7);margin-bottom:6px">Current Plan</div>
                <div class="font-jakarta" style="font-size:1.4rem;font-weight:800;color:#f1f5f9">Basic Annual</div>
            </div>
            <span class="badge badge-green"><i class="ri-checkbox-circle-fill"></i> Active</span>
        </div>
        <div style="display:flex;align-items:baseline;gap:4px;margin-bottom:4px"><span class="font-jakarta" style="font-size:2.5rem;font-weight:800;color:#f1f5f9">£2.40</span><span style="font-size:.84rem;color:#64748b">/year incl. VAT</span></div>
        <div style="font-size:.84rem;color:#64748b;margin-bottom:16px">Renews on <strong style="color:#94a3b8">April 10, 2027</strong> · 214 days remaining</div>
        <div style="margin-bottom:20px">
            <div style="display:flex;justify-content:space-between;font-size:.75rem;color:#64748b;margin-bottom:6px"><span>Plan Usage</span><span>24 / Unlimited</span></div>
            <div class="prog-track">
                <div class="prog-fill" style="width:32%"></div>
            </div>
        </div>
        <div style="display:flex;flex-wrap:wrap;gap:8px">
            <button class="btn btn-primary btn-sm" onclick="openModal('upg-modal')"><i class="ri-rocket-line"></i> Upgrade Plan</button>
            <button class="btn btn-ghost btn-sm" onclick="openModal('pay-modal')"><i class="ri-bank-card-line"></i> Update Payment</button>
            <button class="btn btn-danger btn-sm" onclick="openModal('cancel-modal')"><i class="ri-close-circle-line"></i> Cancel Plan</button>
        </div>
    </div>
    <div class="g2" style="margin-bottom:20px">
        <div class="card hidden" style="padding:18px">
            <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:14px">Your Plan Categories</h3>
            <div style="display:flex;flex-direction:column;gap:12px">
                <div style="display:flex;gap:10px;align-items:flex-start"><i class="ri-check-line" style="color:#10b981;flex-shrink:0;margin-top:2px"></i>
                    <div>
                        <div style="font-size:.87rem;font-weight:600;color:#94a3b8">Unlimited Reminders</div>
                        <div style="font-size:.75rem;color:#64748b">All features included</div>
                    </div>
                </div>
                <div style="display:flex;gap:10px;align-items:flex-start"><i class="ri-check-line" style="color:#10b981;flex-shrink:0;margin-top:2px"></i>
                    <div>
                        <div style="font-size:.87rem;font-weight:600;color:#94a3b8">Multi-Channel Notifications</div>
                        <div style="font-size:.75rem;color:#64748b">Email, SMS, Push & WhatsApp</div>
                    </div>
                </div>
                <div style="display:flex;gap:10px;align-items:flex-start"><i class="ri-check-line" style="color:#10b981;flex-shrink:0;margin-top:2px"></i>
                    <div>
                        <div style="font-size:.87rem;font-weight:600;color:#94a3b8">Calendar Integration</div>
                        <div style="font-size:.75rem;color:#64748b">Full visual calendar view</div>
                    </div>
                </div>
                <div style="display:flex;gap:10px;align-items:flex-start"><i class="ri-check-line" style="color:#10b981;flex-shrink:0;margin-top:2px"></i>
                    <div>
                        <div style="font-size:.87rem;font-weight:600;color:#94a3b8">WhatsApp & Email Sharing</div>
                        <div style="font-size:.75rem;color:#64748b">Share with anyone instantly</div>
                    </div>
                </div>
                <div style="display:flex;gap:10px;align-items:flex-start"><i class="ri-check-line" style="color:#10b981;flex-shrink:0;margin-top:2px"></i>
                    <div>
                        <div style="font-size:.87rem;font-weight:600;color:#94a3b8">Analytics & Reports</div>
                        <div style="font-size:.75rem;color:#64748b">Track your activity & spending</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card hidden" style="padding:18px">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
                <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9">Payment Method</h3>
                <button class="btn btn-ghost btn-xs" onclick="openModal('pay-modal')"><i class="ri-pencil-line"></i> Edit</button>
            </div>
            <div style="background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06);border-radius:12px;padding:14px;margin-bottom:14px">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px">
                    <div style="width:38px;height:26px;border-radius:6px;background:linear-gradient(135deg,#1a3a8f,#2563eb);display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="ri-bank-card-fill" style="color:#fff;font-size:.85rem"></i></div>
                    <div>
                        <div style="font-size:.85rem;font-weight:600;color:#94a3b8">Visa •••• 4242</div>
                        <div style="font-size:.73rem;color:#64748b">Expires 12/2027</div>
                    </div>
                </div>
                <div style="font-size:.75rem;color:#64748b"><i class="ri-user-line" style="margin-right:4px"></i> Kishore Rex</div>
            </div>
            <h4 style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:8px">Billing Address</h4>
            <div style="font-size:.84rem;color:#64748b;line-height:1.8">Kishore Rex<br>123 High Street<br>London, EN1 1SP<br>United Kingdom</div>
        </div>
    </div>
    <div class="card" style="padding:18px">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
            <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9">Payment History</h3>
            <button class="btn btn-ghost btn-sm" onclick="toast('Downloading invoices…','info')"><i class="ri-download-2-line"></i> Download All</button>
        </div>
        <div style="overflow-x:auto">
            <table style="width:100%;border-collapse:collapse;font-size:.84rem">
                <thead>
                    <tr>
                        <th style="text-align:left;padding-bottom:10px;font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;border-bottom:1px solid rgba(255,255,255,.06)">Transaction</th>
                        <th style="text-align:left;padding-bottom:10px;font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;border-bottom:1px solid rgba(255,255,255,.06)">Plan</th>
                        <th style="text-align:left;padding-bottom:10px;font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;border-bottom:1px solid rgba(255,255,255,.06)">Amount</th>
                        <th style="text-align:left;padding-bottom:10px;font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;border-bottom:1px solid rgba(255,255,255,.06)">Status</th>
                        <th style="text-align:left;padding-bottom:10px;font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#64748b;border-bottom:1px solid rgba(255,255,255,.06)">Date</th>
                        <th style="border-bottom:1px solid rgba(255,255,255,.06)"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="tbl-row">
                        <td style="padding:11px 0;font-family:'DM Mono',monospace;font-size:.73rem;color:#64748b">#TXN-00421</td>
                        <td style="padding:11px 8px 11px 0;color:#94a3b8">Basic Annual</td>
                        <td style="padding:11px 8px 11px 0;font-weight:700;color:#f1f5f9">£2.40</td>
                        <td style="padding:11px 8px 11px 0"><span class="badge badge-green">Success</span></td>
                        <td style="padding:11px 0;color:#64748b;white-space:nowrap">Apr 10, 2026</td>
                        <td style="padding:11px 0;text-align:right"><button class="btn btn-ghost btn-xs" onclick="toast('Invoice downloaded','success')"><i class="ri-download-line"></i></button></td>
                    </tr>
                    <tr class="tbl-row">
                        <td style="padding:11px 0;font-family:'DM Mono',monospace;font-size:.73rem;color:#64748b">#TXN-00312</td>
                        <td style="padding:11px 8px 11px 0;color:#94a3b8">Basic Annual</td>
                        <td style="padding:11px 8px 11px 0;font-weight:700;color:#f1f5f9">£2.40</td>
                        <td style="padding:11px 8px 11px 0"><span class="badge badge-green">Success</span></td>
                        <td style="padding:11px 0;color:#64748b;white-space:nowrap">Apr 10, 2025</td>
                        <td style="padding:11px 0;text-align:right"><button class="btn btn-ghost btn-xs" onclick="toast('Invoice downloaded','success')"><i class="ri-download-line"></i></button></td>
                    </tr>
                    <tr>
                        <td style="padding:11px 0;font-family:'DM Mono',monospace;font-size:.73rem;color:#64748b">#TXN-00201</td>
                        <td style="padding:11px 8px 11px 0;color:#94a3b8">Basic Annual</td>
                        <td style="padding:11px 8px 11px 0;font-weight:700;color:#f1f5f9">£2.00</td>
                        <td style="padding:11px 8px 11px 0"><span class="badge badge-green">Success</span></td>
                        <td style="padding:11px 0;color:#64748b;white-space:nowrap">Apr 10, 2024</td>
                        <td style="padding:11px 0;text-align:right"><button class="btn btn-ghost btn-xs" onclick="toast('Invoice downloaded','success')"><i class="ri-download-line"></i></button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

@endsection
