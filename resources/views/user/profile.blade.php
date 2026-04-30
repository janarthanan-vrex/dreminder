@extends('user.layouts.app')
@section('content')

<!-- ===== PROFILE ===== -->
<section id="page-profile" class="">
    <div class="g2">
        <div class="card" style="padding:24px">
            <h3 class="font-jakarta" style="font-weight:700;font-size:.93rem;color:#f1f5f9;margin-bottom:18px">Personal Information</h3>
            <div style="display:flex;align-items:center;gap:16px;margin-bottom:22px">
                <div style="position:relative;cursor:pointer" onclick="document.getElementById('av-inp').click()">
                    <div id="av-preview" style="width:76px;height:76px;border-radius:18px;background:linear-gradient(135deg,#7c3aed,#0d9488);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.5rem;font-weight:700;box-shadow:0 6px 20px rgba(124,58,237,.35);overflow:hidden" id="av-big">JM</div>
                    <div style="position:absolute;bottom:-6px;right:-6px;width:26px;height:26px;border-radius:8px;background:#7c3aed;display:flex;align-items:center;justify-content:center;border:2px solid #090918"><i class="ri-camera-line" style="color:#fff;font-size:.7rem"></i></div>
                </div>
                <input type="file" id="av-inp" style="display:none" accept="image/*" onchange="handleAvatar(event)">
                <div>
                    <div class="font-jakarta" style="font-weight:700;font-size:1.05rem;color:#f1f5f9" id="profile-display-name">Kishore Rex</div>
                    <div style="font-size:.75rem;color:#64748b;margin-top:2px">Pro Member · Since April 2026</div>
                    <button class="btn btn-ghost btn-xs" style="margin-top:8px" onclick="document.getElementById('av-inp').click()"><i class="ri-upload-line"></i> Change Photo</button>
                </div>
            </div>
            <div style="display:flex;flex-direction:column;gap:14px">
                <div><label style="display:block;font-size:.67rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:6px">Full Name <span style="color:#f43f5e">*</span></label><input class="inp" id="p-name" value="Kishore Rex"></div>
                <div><label style="display:block;font-size:.67rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:6px">Email <span style="color:#f43f5e">*</span></label><input class="inp" type="email" id="p-email" value="Kishore@example.com"></div>
                <div><label style="display:block;font-size:.67rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:6px">Phone</label><input class="inp" type="tel" id="p-phone" value="+44 7700 900123"></div>
                <div class="g2">
                    <div><label style="display:block;font-size:.67rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:6px">Country</label><select class="inp">
                            <option selected>United Kingdom</option>
                            <option>Ireland</option>
                            <option>United States</option>
                            <option>Canada</option>
                            <option>Australia</option>
                        </select></div>
                    <div><label style="display:block;font-size:.67rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:6px">Postcode</label><input class="inp" value="EN1 1SP"></div>
                </div>
                <button class="btn btn-primary" style="justify-content:center;width:100%" onclick="saveProfile()"><i class="ri-save-line"></i> Save Changes</button>
            </div>
        </div>
        <div style="display:flex;flex-direction:column;gap:16px">
            <div class="card" style="padding:22px">
                <h3 class="font-jakarta" style="font-weight:700;font-size:.93rem;color:#f1f5f9;margin-bottom:16px">Security Settings</h3>
                <div style="display:flex;flex-direction:column;gap:12px">
                    <div><label style="display:block;font-size:.67rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:6px">Current Password <span style="color:#f43f5e">*</span></label><input class="inp" type="password" placeholder="Enter current password"></div>
                    <div><label style="display:block;font-size:.67rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:6px">New Password <span style="color:#f43f5e">*</span></label><input class="inp" type="password" placeholder="Min 8 chars, 1 uppercase, 1 number"></div>
                    <div><label style="display:block;font-size:.67rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:6px">Confirm Password <span style="color:#f43f5e">*</span></label><input class="inp" type="password" placeholder="Re-enter new password"></div>
                    <button class="btn btn-primary" style="justify-content:center;width:100%" onclick="toast('Password updated successfully!','success')"><i class="ri-lock-password-line"></i> Update Password</button>
                </div>
            </div>
            <div class="card hidden " style="padding:18px">
                <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:10px">Preferences</h3>
                <div style="display:flex;flex-direction:column;gap:10px">
                    <div style="display:flex;align-items:center;justify-content:space-between;padding:10px;border-radius:10px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06)">
                        <div style="font-size:.84rem;font-weight:500;color:#94a3b8">Email Digest (Weekly)</div><button class="toggle on" onclick="this.classList.toggle('on')"></button>
                    </div>
                    <div style="display:flex;align-items:center;justify-content:space-between;padding:10px;border-radius:10px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06)">
                        <div style="font-size:.84rem;font-weight:500;color:#94a3b8">Marketing Emails</div><button class="toggle" onclick="this.classList.toggle('on')"></button>
                    </div>
                    <div style="display:flex;align-items:center;justify-content:space-between;padding:10px;border-radius:10px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06)">
                        <div style="font-size:.84rem;font-weight:500;color:#94a3b8">2-Factor Auth</div><button class="toggle" onclick="this.classList.toggle('on')"></button>
                    </div>
                </div>
            </div>
            <div class="danger-zone">
                <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f43f5e;margin-bottom:6px"><i class="ri-alert-line" style="margin-right:4px"></i> Danger Zone</h3>
                <p style="font-size:.8rem;color:#64748b;margin-bottom:10px">Permanently delete your account and all data. This cannot be undone.</p>
                <button class="btn btn-danger btn-sm" onclick="confirm_act('Delete your account? All data will be permanently removed.',()=>toast('Account deletion initiated. You will receive an email confirmation.','warning'))"><i class="ri-delete-bin-2-line"></i> Delete Account</button>
            </div>
        </div>
    </div>
</section>

@endsection
