@extends('admin.layouts.app')
@section('content')
<!-- ═══ SETTINGS ═══ -->
<section id="page-settings" class="page active">
    <div style="margin-bottom: 20px">
        <h2 class="font-jakarta" style="font-size: 1.3rem; font-weight: 800">System Settings</h2>
        <p style="font-size: 1.2re; color: var(--text3); margin-top: 3px">
            Configure platform-wide settings
        </p>
    </div>
    <div class="tab-bar">
        <button class="tab-btn active" onclick="swTab('set','general',this)">General</button>
        <button class="tab-btn" onclick="swTab('set','email',this)">Email</button>
        <button class="tab-btn" onclick="swTab('set','billing',this)">Billing</button>
        <button class="tab-btn" onclick="swTab('set','security',this)">Security</button>
        <button class="tab-btn" onclick="swTab('set','integrations',this)">Integrations</button>
    </div>
    <div id="set-tab-general" class="tab-pane active">
        <div class="g2">
            <div>
                <div class="card" style="padding: 22px">
                    <div class="section-title">Platform Settings</div>
                    <div style="display: flex; flex-direction: column; gap: 13px">
                        <div>
                            <label class="label">Platform Name</label
                            ><input class="inp" value="D-Remind" />
                        </div>
                        <div>
                            <label class="label">Support Email</label
                            ><input class="inp" value="support@dremind.co.uk" />
                        </div>
                        <div>
                            <label class="label">Default Country</label
                            ><select class="inp">
                                <option>United Kingdom</option>
                                <option>United States</option>
                            </select>
                        </div>
                        <div>
                            <label class="label">Default Currency</label
                            ><select class="inp">
                                <option>GBP (£)</option>
                                <option>USD ($)</option>
                                <option>EUR (€)</option>
                            </select>
                        </div>
                        <button
                            class="btn btn-primary"
                            style="justify-content: center"
                            onclick="toast('Settings saved!','success')"
                        >
                            <i class="ri-save-line"></i> Save
                        </button>
                    </div>
                </div>
            </div>
            <div style="display: flex; flex-direction: column; gap: 16px">
                <div class="card" style="padding: 22px">
                    <div class="section-title">Feature Flags</div>
                    <div
                        style="display: flex; flex-direction: column; gap: 10px"
                        id="feature-flags"
                    ></div>
                </div>
                <div
                    class="card"
                    style="
                        padding: 22px;
                        background: rgba(245, 158, 11, 0.05);
                        border: 1px solid rgba(245, 158, 11, 0.2);
                    "
                >
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px">
                        <i class="ri-tools-line" style="color: var(--amber); font-size: 1.1rem"></i>
                        <div class="section-title" style="margin: 0">Maintenance Mode</div>
                    </div>
                    <p style="font-size: 0.8rem; color: var(--text3); margin-bottom: 12px">
                        Enabling this will show a maintenance page to all non-admin users.
                    </p>
                    <div style="display: flex; align-items: center; gap: 10px">
                        <button
                            class="toggle"
                            id="maint-toggle"
                            onclick="this.classList.toggle('on');toast(this.classList.contains('on')?'Maintenance mode ON':'Maintenance mode OFF',this.classList.contains('on')?'warning':'success')"
                        ></button
                        ><span style="font-size: 1.2re; color: var(--text2)">Maintenance Mode</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="set-tab-email" class="tab-pane">
        <div class="card" style="padding: 22px">
            <div class="section-title">SMTP Configuration</div>
            <div class="g2" style="margin-bottom: 13px">
                <div>
                    <label class="label">SMTP Host</label
                    ><input class="inp" value="smtp.mailgun.org" />
                </div>
                <div><label class="label">SMTP Port</label><input class="inp" value="587" /></div>
            </div>
            <div class="g2" style="margin-bottom: 13px">
                <div>
                    <label class="label">Username</label
                    ><input class="inp" value="admin@dremind.co.uk" />
                </div>
                <div>
                    <label class="label">Password</label
                    ><input class="inp" type="password" value="••••••••••••" />
                </div>
            </div>
            <div style="margin-bottom: 13px">
                <label class="label">From Name</label><input class="inp" value="D-Remind" />
            </div>
            <div style="display: flex; gap: 8px; justify-content: flex-end">
                <button class="btn btn-ghost btn-sm" onclick="toast('Test email sent!','success')">
                    <i class="ri-mail-send-line"></i> Send Test</button
                ><button
                    class="btn btn-primary btn-sm"
                    onclick="toast('SMTP settings saved!','success')"
                >
                    <i class="ri-save-line"></i> Save
                </button>
            </div>
        </div>
    </div>
    <div id="set-tab-billing" class="tab-pane">
        <div class="card" style="padding: 22px">
            <div class="section-title">Plan Configuration</div>
            <div style="display: flex; flex-direction: column; gap: 10px" id="plan-config"></div>
        </div>
    </div>
    <div id="set-tab-security" class="tab-pane">
        <div class="card" style="padding: 22px">
            <div class="section-title">Security Settings</div>
            <div style="display: flex; flex-direction: column; gap: 10px">
                <div
                    style="
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                        padding: 11px;
                        border-radius: var(--radius-sm);
                        background: rgba(255, 255, 255, 0.03);
                        border: 1px solid var(--border2);
                    "
                >
                    <div>
                        <div style="font-size: 0.85rem; font-weight: 600; color: var(--text2)">
                            Force 2FA for Admins
                        </div>
                        <div style="font-size: 0.73rem; color: var(--text3)">
                            Require 2FA for all admin accounts
                        </div>
                    </div>
                    <button class="toggle on" onclick="this.classList.toggle('on')"></button>
                </div>
                <div
                    style="
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                        padding: 11px;
                        border-radius: var(--radius-sm);
                        background: rgba(255, 255, 255, 0.03);
                        border: 1px solid var(--border2);
                    "
                >
                    <div>
                        <div style="font-size: 0.85rem; font-weight: 600; color: var(--text2)">
                            IP Whitelist
                        </div>
                        <div style="font-size: 0.73rem; color: var(--text3)">
                            Restrict admin access to specific IPs
                        </div>
                    </div>
                    <button class="toggle" onclick="this.classList.toggle('on')"></button>
                </div>
                <div
                    style="
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                        padding: 11px;
                        border-radius: var(--radius-sm);
                        background: rgba(255, 255, 255, 0.03);
                        border: 1px solid var(--border2);
                    "
                >
                    <div>
                        <div style="font-size: 0.85rem; font-weight: 600; color: var(--text2)">
                            Rate Limiting
                        </div>
                        <div style="font-size: 0.73rem; color: var(--text3)">
                            API rate limits (100 req/min)
                        </div>
                    </div>
                    <button class="toggle on" onclick="this.classList.toggle('on')"></button>
                </div>
                <div>
                    <label class="label">Session Timeout (minutes)</label
                    ><input class="inp" value="60" type="number" min="5" max="1440" />
                </div>
                <button
                    class="btn btn-primary btn-sm"
                    style="align-self: flex-end"
                    onclick="toast('Security settings saved!','success')"
                >
                    <i class="ri-save-line"></i> Save
                </button>
            </div>
        </div>
    </div>
    <div id="set-tab-integrations" class="tab-pane">
        <div style="display: flex; flex-direction: column; gap: 12px" id="integrations-list"></div>
    </div>
</section>
@endsection
