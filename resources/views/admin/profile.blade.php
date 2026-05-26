@extends('admin.layouts.app')
@section('content')

<!-- ═══ PROFILE ═══ -->
<style>
    .err {
        color: red;
        font-size: 12px;
        margin-top: 4px;
        display: block;
    }
</style>
<section id="page-profile" class="">
    <div style="margin-bottom: 20px">
        <h2 class="font-jakarta" style="font-size: 1.3rem; font-weight: 800">My Profile</h2>
        <p style="font-size: 1.2re; color: var(--text3); margin-top: 3px">
            Manage your admin account
        </p>
    </div>
    <div class="g2">
        <div style="display: flex; flex-direction: column; gap: 16px">

            <form id="profileForm" enctype="multipart/form-data">

                @csrf

                <div class="card" style="padding: 24px">

                    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 22px">

                        <div style="position: relative; cursor: pointer">

                            <!-- Hidden File Input -->
                            <input type="file" id="profile_image" name="profile_image" accept="image/*" hidden>
                            <small class="err" id="profile_image-error"></small>

                            <!-- Image Preview -->
                            <img
                                id="preview-image"
                                onclick="document.getElementById('profile_image').click()"
                                src="{{ $admin->profile_image ? asset('profile/'.$admin->profile_image) : 'https://ui-avatars.com/api/?name='.urlencode($admin->name) }}"
                                style="
                        width: 72px;
                        height: 72px;
                        border-radius: 16px;
                        object-fit: cover;
                        border:2px solid #eee;
                    ">

                            <!-- Camera Icon -->
                            <div
                                onclick="document.getElementById('profile_image').click()"
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
                    ">
                                <i class="ri-camera-line" style="color: #fff; font-size: 0.65rem"></i>
                            </div>

                        </div>

                        <div>
                            <div
                                class="font-jakarta"
                                style="font-weight: 700; font-size: 1rem; color: var(--text)">
                                {{ $admin->name }}
                            </div>

                            <div style="font-size: 0.75rem; color: var(--text3); margin-top: 2px">
                                System Administrator
                            </div>

                            <span class="badge badge-purple" style="margin-top: 6px">
                                <i class="ri-shield-flash-line"></i> Full Access
                            </span>
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 13px">

                        <div>
                            <label class="label">Full Name</label>

                            <input class="inp" type="text" name="name" value="{{ $admin->name }}" maxlength="25" oninput="this.value=this.value.replace(/[^a-zA-Z\s]/g,'')">
                            <small class="err" id="name-error"></small>
                        </div>

                        <div>
                            <label class="label">Email Address</label>

                            <input
                                class="inp"
                                readonly
                                type="email"
                                value="{{ $admin->email }}">
                        </div>

                        <div>
                            <label class="label">Phone</label>

                            <input class="inp" type="tel" name="phone" value="{{ $admin->phone }}" oninput="this.value=this.value.replace(/[^0-9]/g,'')" maxlength="15">
                            <small class="err" id="phone-error"></small>
                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary"
                            style="justify-content: center">
                            <i class="ri-save-line"></i> Save Changes
                        </button>

                    </div>

                </div>

            </form>


            <form id="passwordForm">

                @csrf

                <div class="card" style="padding:22px">

                    <div class="section-title">Security</div>

                    <div style="display:flex;flex-direction:column;gap:12px">

                        <div>
                            <label class="label">Current Password</label>
                            <div style="position:relative">
                                <input class="inp" id="current_password" type="password" name="current_password" placeholder="••••••••" style="padding-right:45px">
                                <i class="ri-eye-line" onclick="togglePassword('current_password',this)" style="position:absolute;right:14px;top:50%;transform:translateY(-50%);cursor:pointer;color:#888;font-size:18px"></i>
                            </div>
                            <small class="err" id="current_password-error"></small>
                        </div>

                        <div>
                            <label class="label">New Password</label>
                            <div style="position:relative">
                                <input class="inp" id="new_password" type="password" name="new_password" placeholder="Min 8 characters" style="padding-right:45px">
                                <i class="ri-eye-line" onclick="togglePassword('new_password',this)" style="position:absolute;right:14px;top:50%;transform:translateY(-50%);cursor:pointer;color:#888;font-size:18px"></i>
                            </div>
                            <small class="err" id="new_password-error"></small>
                        </div>

                        <div>
                            <label class="label">Confirm Password</label>
                            <div style="position:relative">
                                <input class="inp" id="confirm_password" type="password" name="confirm_password" placeholder="Repeat password" style="padding-right:45px">
                                <i class="ri-eye-line" onclick="togglePassword('confirm_password',this)" style="position:absolute;right:14px;top:50%;transform:translateY(-50%);cursor:pointer;color:#888;font-size:18px"></i>
                            </div>
                            <small class="err" id="confirm_password-error"></small>
                        </div>

                        <button type="submit" class="btn btn-primary" style="justify-content:center">
                            <i class="ri-lock-password-line"></i> Update Password
                        </button>

                    </div>

                </div>

            </form>

            <script>
                function togglePassword(inputId, icon) {

                    let input = document.getElementById(inputId);

                    if (input.type === 'password') {

                        input.type = 'text';
                        icon.classList.remove('ri-eye-line');
                        icon.classList.add('ri-eye-off-line');

                    } else {

                        input.type = 'password';
                        icon.classList.remove('ri-eye-off-line');
                        icon.classList.add('ri-eye-line');

                    }

                }
            </script>
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
                        ">
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
                        ">
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
                        ">
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
                    id="profile-activity"></div>
            </div>
            <div class="danger-zone">
                <h3
                    class="font-jakarta"
                    style="
                        font-weight: 700;
                        font-size: 0.87rem;
                        color: var(--red);
                        margin-bottom: 6px;
                    ">
                    <i class="ri-alert-line"></i> Danger Zone
                </h3>
                <p style="font-size: 0.8rem; color: var(--text3); margin-bottom: 10px">
                    These actions are irreversible.
                </p>
                <div style="display: flex; gap: 8px; flex-wrap: wrap">
                    <button
                        class="btn btn-danger btn-sm"
                        onclick="toast('Logged out from all devices','warning')">
                        <i class="ri-logout-box-r-line"></i> Logout Everywhere
                    </button>
                    <button
                        class="btn btn-danger btn-sm"
                        onclick="toast('Audit log cleared','warning')">
                        <i class="ri-delete-bin-line"></i> Clear Audit Log
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.getElementById('profile_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        document.getElementById('profile_image-error').innerText = '';
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('preview-image').src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    document.querySelectorAll('input').forEach(input => {
        input.addEventListener('input', function() {
            let error = document.getElementById(this.name + '-error');
            if (error) {
                error.innerText = '';
            }
        });
    });

    document.getElementById('profileForm').addEventListener('submit', function(e) {

        e.preventDefault();

        let formData = new FormData(this);

        document.querySelectorAll('.err').forEach(el => {
            el.innerText = '';
        });

        fetch("{{ route('admin.profile.update') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(async response => {

                const data = await response.json();

                if (response.status === 422) {

                    Object.keys(data.errors).forEach(key => {

                        let errorEl = document.getElementById(key + '-error');

                        if (errorEl) {
                            errorEl.innerText = data.errors[key][0];
                        }

                    });

                    return;
                }

                if (data.status) {

                    toast(data.message, 'success');

                    setTimeout(() => {
                        location.reload();
                    }, 1500);

                } else {

                    toast('Something went wrong', 'error');

                }

            })
            .catch(error => {
                console.log(error);
            });

    });
</script>

<script>
    document.querySelectorAll('#passwordForm input').forEach(input => {

        input.addEventListener('input', function() {

            let error = document.getElementById(this.name + '-error');

            if (error) {
                error.innerText = '';
            }

        });

    });

    document.getElementById('passwordForm').addEventListener('submit', function(e) {

        e.preventDefault();

        let formData = new FormData(this);

        document.querySelectorAll('#passwordForm .err').forEach(el => {
            el.innerText = '';
        });

        fetch("{{ route('admin.change.password') }}", {

                method: 'POST',

                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },

                body: formData

            })
            .then(async response => {

                const data = await response.json();

                if (response.status === 422) {

                    Object.keys(data.errors).forEach(key => {

                        let errorEl = document.getElementById(key + '-error');

                        if (errorEl) {
                            errorEl.innerText = data.errors[key][0];
                        }

                    });

                    return;
                }

                if (data.status) {

                    toast(data.message, 'success');

                    document.getElementById('passwordForm').reset();
                    setTimeout(()=>{
                        location.reload();
                    },1500)

                }

            })
            .catch(error => {
                console.log(error);
            });

    });
</script>
@endsection