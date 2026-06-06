@extends('admin.layouts.app')
@section('content')
<!-- ═══ SETTINGS ═══ -->

<style>
    .password-wrapper {
        position: relative;
    }

    .password-wrapper .inp {
        width: 100%;
        padding-right: 45px;
        /* space for icon */
    }

    .toggle-password {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #6c757d;
        font-size: 18px;
        display: flex;
        align-items: center;
    }

    .toggle-password:hover {
        color: #000;
    }
    .switch{
    position:relative;
    display:inline-block;
    width:50px;
    height:26px;
}

.switch input{
    opacity:0;
    width:0;
    height:0;
}

.slider{
    position:absolute;
    cursor:pointer;
    inset:0;
    background:#ccc;
    border-radius:30px;
    transition:.3s;
}

.slider:before{
    content:"";
    position:absolute;
    width:20px;
    height:20px;
    left:3px;
    bottom:3px;
    background:#fff;
    border-radius:50%;
    transition:.3s;
}

.switch input:checked + .slider{
    background:#2563eb;
}

.switch input:checked + .slider:before{
    transform:translateX(24px);
}
</style>
<section id="page-settings" class="page active">
    <div style="margin-bottom: 20px">
        <h2 class="font-jakarta" style="font-size: 1.3rem; font-weight: 800">System Settings</h2>
        <p style="font-size: 1.2re; color: var(--text3); margin-top: 3px">
            Configure platform-wide settings
        </p>
    </div>
    <div class="tab-bar">
        <button class="tab-btn hidden" onclick="swTab('set','general',this)">General</button>
        <button class="tab-btn active" onclick="swTab('set','email',this)">Email</button>
        <button class="tab-btn hidden" onclick="swTab('set','billing',this)">Billing</button>
        <button class="tab-btn hidden" onclick="swTab('set','security',this)">Security</button>
        <button class="tab-btn hidden" onclick="swTab('set','integrations',this)">Integrations</button>
    </div>

    <!-- 
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
    </div> -->


    <div id="set-tab-email" class="tab-pane active">
        <div class="card p-4">

            <div class="section-title mb-3">SMTP Configuration</div>

            <!-- Row 1 -->
           <form id="emailSettingsForm" action="{{ route('settings.email.save') }}" method="POST">
    @csrf
                <div class="g2 mb-3">
                    <div>
                        <label class="label">SMTP Server</label>
                        <input type="text" name="smtp_server" class="inp"
                            value="{{ old('smtp_server', $settings['smtp_server'] ?? '') }}"
                            maxlength="50">

                        @error('smtp_server')
                        <div class="text-danger mt-1 error-msg">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="label">SMTP Port</label>
                        <input type="text" name="smtp_port" class="inp"
                            value="{{ old('smtp_port', $settings['smtp_port'] ?? '') }}"
                            oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                            maxlength="3">

                        @error('smtp_port')
                        <div class="text-danger mt-1 error-msg">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Row 2 -->

                <div class="g2 mb-3">
                    <div>
                        <label class="label">SMTP Username</label>
                        <input type="text" name="smtp_username" class="inp"
                            value="{{ old('smtp_username', $settings['smtp_username'] ?? '') }}">

                       
                    </div>

                    <div>
                        <label class="label">Encryption</label>
                        <select name="encryption_type" class="inp">
                            <option value="tls"
                                {{ old('encryption_type', $settings['encryption_type'] ?? '') == 'tls' ? 'selected' : '' }}>
                                TLS (Port 587)
                            </option>
                            <option value="ssl"
                                {{ old('encryption_type', $settings['encryption_type'] ?? '') == 'ssl' ? 'selected' : '' }}>
                                SSL (Port 465)
                            </option>
                        </select>

                       
                    </div>
                </div>

                <!-- Row 3 -->
                <div class="g2 mb-3">
                    <div>
                        <label class="label">SMTP Password</label>

                        <div class="password-wrapper">
                            <input type="password"
                                name="smtp_password"
                                id="smtp_password"
                                class="inp"
                                placeholder="Leave blank to keep current password">

                            <span class="toggle-password" data-target="smtp_password">
                                <i class="ri-eye-line"></i>
                            </span>
                        </div>

                        
                    </div>

                    <div>
                        <label class="label">From Email</label>
                        <input type="email"
                            name="from_email"
                            class="inp"
                            value="{{ old('from_email', $settings['from_email'] ?? '') }}">

                       
                    </div>
                    <div class="mb-3">
    <label class="label">From Name</label>
    <input type="text"
           name="from_name"
           class="inp"
           value="{{ old('from_name', $settings['from_name'] ?? '') }}">
           
</div>
<div class="setting-row">
    <div>
        <div class="label">Email Notifications</div>
        <div class="sub">Enable or disable all email notifications</div>
    </div>

    <label class="switch">
    <input type="checkbox"
           name="email_notifications"
           value="1"
           {{ !empty($notificationSettings['email_notifications']) ? 'checked' : '' }}>
    <span class="slider"></span>
</label>
</div>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="button" id="sendTestMailBtn" class="btn btn-outline-primary btn-sm">
                        <i class="ri-mail-send-line"></i> Send Test Email
                    </button>

                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="ri-save-line"></i> Save Settings
                    </button>
                </div>
            </form>

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
                    ">
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
                    ">
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
                    ">
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
                    <label class="label">Session Timeout (minutes)</label><input class="inp" value="60" type="number" min="5" max="1440" />
                </div>
                <button
                    class="btn btn-primary btn-sm"
                    style="align-self: flex-end"
                    onclick="toast('Security settings saved!','success')">
                    <i class="ri-save-line"></i> Save
                </button>
            </div>
        </div>
    </div>

    <div id="set-tab-integrations" class="tab-pane">
        <div style="display: flex; flex-direction: column; gap: 12px" id="integrations-list"></div>
    </div>
</section>
<script>
    document.querySelectorAll('.toggle-password').forEach(function(btn) {

        btn.addEventListener('click', function() {

            const input = document.getElementById(
                this.getAttribute('data-target')
            );

            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('ri-eye-line');
                icon.classList.add('ri-eye-off-line');
            } else {
                input.type = 'password';
                icon.classList.remove('ri-eye-off-line');
                icon.classList.add('ri-eye-line');
            }

        });

    });
</script>

<script>
    document.getElementById('sendTestMailBtn').addEventListener('click', function() {
        let btn = this;
        let originalHtml = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="ri-loader-4-line ri-spin"></i> Sending...';
        fetch("{{ route('settings.email.test') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    "Accept": "application/json",
                    "Content-Type": "application/json"
                }
            })
            .then(response => response.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = originalHtml;
                if (data.success) {
                    toast(data.message, 'success');
                } else {
                    toast(data.message, 'error');
                }
            })
            .catch(error => {
                btn.disabled = false;
                btn.innerHTML = originalHtml;
                toast('Failed to send test email.', 'error');
                console.error(error);

            });

    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        document.querySelectorAll('.inp').forEach(function(input) {

            input.addEventListener('input', function() {

                const container = this.closest('div');
                const error = container.querySelector('.error-msg');

                if (error) {
                    error.remove();
                }

            });

        });

    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('emailSettingsForm');

    form.addEventListener('submit', function (e) {

        e.preventDefault();

        document.querySelectorAll('.error-msg').forEach(el => el.remove());

        const btn = form.querySelector('button[type="submit"]');
        const originalText = btn.innerHTML;

        btn.disabled = true;
        btn.innerHTML = '<i class="ri-loader-4-line ri-spin"></i> Saving...';

        fetch(form.action, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: new FormData(form)
        })
        .then(async response => {

            const data = await response.json();

            btn.disabled = false;
            btn.innerHTML = originalText;

            if (response.ok) {

                toast(data.message, 'success');

            } else if (response.status === 422) {

                Object.keys(data.errors).forEach(field => {

                    const input = document.querySelector(`[name="${field}"]`);

                    if (input) {

                        const error = document.createElement('div');
                        error.className = 'text-danger mt-1 error-msg';
                        error.textContent = data.errors[field][0];
const wrapper = input.closest('div');
wrapper.appendChild(error);
                    }
                });

                
            }
        })
        .catch(error => {

            btn.disabled = false;
            btn.innerHTML = originalText;

            toast('Something went wrong.', 'error');
            console.error(error);
        });

    });

    // Hide error while typing
    document.querySelectorAll('.inp').forEach(input => {

        input.addEventListener('input', function () {

            const error = this.parentElement.querySelector('.error-msg');

            if (error) {
                error.remove();
            }
        });

    });

});
</script>
@endsection