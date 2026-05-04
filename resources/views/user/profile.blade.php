@extends('user.layouts.app')
@section('content')

<!-- ===== PROFILE ===== -->
<section id="page-profile" class="">
    <div class="g2">
        <div class="card" style="padding:24px">
            <h3 class="font-jakarta" style="font-weight:700;font-size:.93rem;color:#f1f5f9;margin-bottom:18px">Personal Information</h3>
            <div style="display:flex;align-items:center;gap:16px;margin-bottom:22px">
                <div style="position:relative;cursor:pointer" onclick="document.getElementById('av-inp').click()">

                    <div id="avatar-preview"
                        style="width:76px;height:76px;border-radius:18px;
         background:linear-gradient(135deg,#7c3aed,#0d9488);
         display:flex;align-items:center;justify-content:center;
         color:#fff;font-size:1.5rem;font-weight:700;
         box-shadow:0 6px 20px rgba(124,58,237,.35);
         overflow:hidden">

                        @if(!empty($user->profile))
                        <img src="{{ asset($user->profile) }}"
                            style="width:100%;height:100%;object-fit:cover;border-radius:18px;">
                        @else
                        {{ strtoupper(substr($user->first_name ?? '', 0, 1) . substr($user->last_name ?? '', 0, 1)) }}
                        @endif

                    </div>

                    <div style="position:absolute;bottom:-6px;right:-6px;width:26px;height:26px;
        border-radius:8px;background:#7c3aed;display:flex;
        align-items:center;justify-content:center;
        border:2px solid #090918">

                        <i class="ri-camera-line" style="color:#fff;font-size:.7rem"></i>
                    </div>
                </div>
                <input type="file" id="av-inp" style="display:none" accept="image/*" onchange="handleAvatar(event)">
                <div>
                    <div class="font-jakarta" style="font-weight:700;font-size:1.05rem;color:#f1f5f9" id="profile-display-nam"> {{ $user->first_name }} {{ $user->last_name }}</div>
                    <div style="font-size:.75rem;color:#64748b;margin-top:2px">{{ $user->plan->plan_name ?? 'Free ' }} Member · {{ $user->created_at->format('F Y') }}</div>
                    <button class="btn btn-ghost btn-xs" style="margin-top:8px" onclick="document.getElementById('av-inp').click()"><i class="ri-upload-line"></i> Change Photo</button>
                </div>
            </div>
            <div style="display:flex;flex-direction:column;gap:14px">
                <div><label style="display:block;font-size:.67rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:6px">Full Name <span style="color:#f43f5e">*</span></label><input class="inp" id="p-name" value="{{ $user->first_name ?? '' }}"></div>
                <div><label style="display:block;font-size:.67rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:6px">Last Name <span style="color:#f43f5e">*</span></label><input class="inp" id="p-lname" value="{{ $user->last_name ?? '' }}"></div>
                <div><label style="display:block;font-size:.67rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:6px">Email <span style="color:#f43f5e">*</span></label><input class="inp" type="email" id="p-email" readonly value="{{$user->email ?? ''}}"></div>
                <div><label style="display:block;font-size:.67rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:6px">Phone</label><input class="inp" type="tel" id="p-phone" value="{{$user->phone ?? ''}}"></div>
                <div class="g2">
                    <div><label style="display:block;font-size:.67rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:6px">Country</label>
                        <select class="inp" disabled>
                            <option selected>{{ $user->country ?? 'United Kingdom' }}</option>

                        </select>
                    </div>
                    <div><label style="display:block;font-size:.67rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:6px">Postcode</label><input class="inp" value="{{$user->postcode ?? ''}}"></div>
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

<script>
    function handleAvatar(event) {
        const file = event.target.files[0];
        if (!file) return;

        const preview = document.getElementById('avatar-preview');
        if (!preview) return;

        const reader = new FileReader();

        reader.onload = function(e) {
            preview.innerHTML = '';

            const img = document.createElement('img');
            img.src = e.target.result;

            img.style.width = "100%";
            img.style.height = "100%";
            img.style.objectFit = "cover";
            img.style.borderRadius = "18px";
            img.style.display = "block";

            preview.appendChild(img);
        };

        reader.readAsDataURL(file);
    }

    // Save Profile
    async function saveProfile() {

        const btn = event.target;

        const formData = new FormData();

        formData.append('first_name', document.getElementById('p-name').value || '');
        formData.append('last_name', document.getElementById('p-lname').value || '');
        formData.append('email', document.getElementById('p-email').value);
        formData.append('phone', document.getElementById('p-phone').value);
        formData.append('postcode', document.querySelector('input[value="{{ $user->postcode ?? '
            ' }}"]')?.value || '');

        const fileInput = document.getElementById('av-inp');
        if (fileInput.files[0]) {
            formData.append('profile', fileInput.files[0]);
        }

        btn.innerHTML = '<i class="ri-loader-4-line ri-spin"></i> Saving...';
        btn.disabled = true;

        try {

            const res = await fetch("{{ route('user.update.profile') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            });

            const data = await res.json();
        

            if (!data.status) {
                alert(data.message || "Error updating profile");
                btn.innerHTML = '<i class="ri-save-line"></i> Save Changes';
                btn.disabled = false;
                return;
            }
             // ✅ SUCCESS TOAST (only here)
        if (typeof toast === 'function') {
            toast('Profile updated successfully!', 'success');
        }


            // Update name instantly
            document.getElementById('profile-display-nam').innerText =
                document.getElementById('p-name').value;

            // Update avatar if uploaded
            if (data.image_url) {
                document.getElementById('avatar-preview').innerHTML = `
                <img src="${data.image_url}"
                     style="width:100%;height:100%;object-fit:cover;border-radius:18px;">
            `;
            }

            btn.innerHTML = '<i class="ri-check-line"></i> Saved!';
            setTimeout(() => {
                btn.innerHTML = '<i class="ri-save-line"></i> Save Changes';
                btn.disabled = false;
            }, 1500);

        } catch (err) {
            console.log(err);
            btn.innerHTML = '<i class="ri-save-line"></i> Save Changes';
            btn.disabled = false;
        }
    }
</script>

@endsection