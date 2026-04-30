@extends('admin.layouts.app')
@section('content')

<!-- ═══ PROFILE ═══ -->
<section id="page-profile" class="page">
    <div style="margin-bottom: 20px">
        <h2 class="font-jakarta" style="font-size: 1.3rem; font-weight: 800">My Profile</h2>
        <p style="font-size: 1.2re; color: var(--text3); margin-top: 3px">
            Manage your admin account
        </p>
    </div>
    <div class="g2">
        <div style="display: flex; flex-direction: column; gap: 16px">
            <div class="card" style="padding: 24px">
                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 22px">
                    <div style="position: relative; cursor: pointer">
                        <div
                            style="
                                width: 72px;
                                height: 72px;
                                border-radius: 16px;
                                background: linear-gradient(135deg, #7c3aed, #0d9488);
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                color: #fff;
                                font-size: 1.4rem;
                                font-weight: 700;
                                box-shadow: 0 6px 20px rgba(124, 58, 237, 0.3);
                            "
                        >
                            SA
                        </div>
                        <div
                            style="
                                position: absolute;
                                bottom: -5px;
                                right: -5px;
                                width: 24px;
                                height: 24px;
                                border-radius: 7px;
                                background: var(--purple);
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                border: 2px solid var(--bg2);
                            "
                        >
                            <i class="ri-camera-line" style="color: #fff; font-size: 0.65rem"></i>
                        </div>
                    </div>
                    <div>
                        <div
                            class="font-jakarta"
                            style="font-weight: 700; font-size: 1rem; color: var(--text)"
                        >
                            Super Admin
                        </div>
                        <div style="font-size: 0.75rem; color: var(--text3); margin-top: 2px">
                            System Administrator
                        </div>
                        <span class="badge badge-purple" style="margin-top: 6px"
                            ><i class="ri-shield-flash-line"></i> Full Access</span
                        >
                    </div>
                </div>
                <div style="display: flex; flex-direction: column; gap: 13px">
                    <div>
                        <label class="label">Full Name</label
                        ><input class="inp" value="Super Admin" />
                    </div>
                    <div>
                        <label class="label">Email Address</label
                        ><input class="inp" type="email" value="admin@dremind.co.uk" />
                    </div>
                    <div>
                        <label class="label">Phone</label
                        ><input class="inp" type="tel" value="+44 7700 900000" />
                    </div>
                    <div>
                        <label class="label">Timezone</label
                        ><select class="inp">
                            <option>Europe/London (GMT+1)</option>
                            <option>UTC</option>
                        </select>
                    </div>
                    <button
                        class="btn btn-primary"
                        style="justify-content: center"
                        onclick="toast('Profile saved!','success')"
                    >
                        <i class="ri-save-line"></i> Save Changes
                    </button>
                </div>
            </div>
            <div class="card" style="padding: 22px">
                <div class="section-title">Security</div>
                <div style="display: flex; flex-direction: column; gap: 12px">
                    <div>
                        <label class="label">Current Password</label
                        ><input class="inp" type="password" placeholder="••••••••" />
                    </div>
                    <div>
                        <label class="label">New Password</label
                        ><input class="inp" type="password" placeholder="Min 8 characters" />
                    </div>
                    <div>
                        <label class="label">Confirm Password</label
                        ><input class="inp" type="password" placeholder="Repeat password" />
                    </div>
                    <button
                        class="btn btn-primary"
                        style="justify-content: center"
                        onclick="toast('Password updated!','success')"
                    >
                        <i class="ri-lock-password-line"></i> Update Password
                    </button>
                </div>
            </div>
        </div>
        <div style="display: flex; flex-direction: column; gap: 16px">
            <div class="card" style="padding: 22px">
                <div class="section-title">Security Preferences</div>
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
                                Two-Factor Authentication
                            </div>
                            <div style="font-size: 0.73rem; color: var(--text3)">
                                Enhance your security
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
                                Login Notifications
                            </div>
                            <div style="font-size: 0.73rem; color: var(--text3)">
                                Get alerts on new logins
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
                                Activity Digest
                            </div>
                            <div style="font-size: 0.73rem; color: var(--text3)">
                                Weekly admin summary
                            </div>
                        </div>
                        <button class="toggle" onclick="this.classList.toggle('on')"></button>
                    </div>
                </div>
            </div>
            <div class="card" style="padding: 22px">
                <div class="section-title">Recent Activity</div>
                <div
                    style="display: flex; flex-direction: column; gap: 8px"
                    id="profile-activity"
                ></div>
            </div>
            <div class="danger-zone">
                <h3
                    class="font-jakarta"
                    style="
                        font-weight: 700;
                        font-size: 0.87rem;
                        color: var(--red);
                        margin-bottom: 6px;
                    "
                >
                    <i class="ri-alert-line"></i> Danger Zone
                </h3>
                <p style="font-size: 0.8rem; color: var(--text3); margin-bottom: 10px">
                    These actions are irreversible.
                </p>
                <div style="display: flex; gap: 8px; flex-wrap: wrap">
                    <button
                        class="btn btn-danger btn-sm"
                        onclick="toast('Logged out from all devices','warning')"
                    >
                        <i class="ri-logout-box-r-line"></i> Logout Everywhere
                    </button>
                    <button
                        class="btn btn-danger btn-sm"
                        onclick="toast('Audit log cleared','warning')"
                    >
                        <i class="ri-delete-bin-line"></i> Clear Audit Log
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
