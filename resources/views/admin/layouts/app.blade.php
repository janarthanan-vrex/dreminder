<!doctype html>
<html lang="en" class="light">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>D-Remind Admin — Control Panel</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap"
        rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <link href="{{ asset('/assets/css/admin.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">

    <style>
        /* PRELOADER */
        #loader {
            position: fixed;
            inset: 0;
            z-index: 999;
            background: #030014;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: opacity .6s, visibility .6s
        }

        #loader.hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none
        }

        .loader-ring {
            width: 50px;
            height: 50px;
            border: 3px solid rgba(124, 58, 237, .15);
            border-top-color: #7c3aed;
            border-radius: 50%;
            animation: spin .8s linear infinite
        }

        @keyframes spin {
            to {
                transform: rotate(360deg)
            }
        }
    </style>

</head>
<style>
    .err {
        color: red;
        font-size: 12px;
        margin-top: 4px;
        display: block;
    }
</style>

<body>
    <!-- <div id="loader">
            <img src="{{ asset('assets/images/common/loader.gif') }}" alt="">
        </div> -->

    <div id="loader">
        <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.9.10/dist/dotlottie-wc.js" type="module"></script>
        <dotlottie-wc src="https://lottie.host/9e89873a-1424-4d8a-85de-8eaf04ba6f2a/x6B0SnIuaY.lottie" style="width: 300px;height: 300px" autoplay loop></dotlottie-wc>
    </div>

    <div id="toast-area"></div>
    <div id="sb-overlay" onclick="closeMobile()"></div>

    <div class="app">
        <!-- SIDEBAR -->
        @include('admin.components.sidebar')

        <!-- MAIN -->
        <div class="main-wrap">
            @include('admin.components.header')

            <main>
                @yield('content')
            </main>
        </div>
        <!-- end main-wrap -->
    </div>
    <!-- end app -->

    <!-- ═══════════════════════════════════
     MODALS
═══════════════════════════════════ -->

    @php
    use App\Models\Category;
    use App\Models\PlanPrice;
    $categories = Category::where('status', 'Active')
    ->orderBy('name')
    ->get();
    $plans = PlanPrice::where('status', 'Active')
    ->get();

    @endphp

    <!-- ADD USER -->
    <div class="modal-bg" id="add-user-modal">
        <div class="modal-box">
            <div class="modal-header">
                <div>
                    <h3 class="font-jakarta" style="font-weight: 700; font-size: 0.95rem; color: var(--text)">
                        <i class="ri-user-add-line" style="color: var(--teal-light); margin-right: 6px"></i>Add New
                        User
                    </h3>
                    <p style="font-size: 0.76rem; color: var(--text3); margin-top: 2px">
                        Create a new user account
                    </p>
                </div>
                <button class="modal-close" onclick="closeModal('add-user-modal')">
                    <i class="ri-close-line"></i>
                </button>
            </div>
            <div class="g2" style="margin-bottom: 14px">
                <div>
                    <label class="label">First Name <span style="color: var(--red)">*</span></label><input class="inp" id="au-fname" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g,'')" maxlength="25" placeholder="John" />
                    <small class="err" id="au-fname-error"></small>
                </div>
                <div>
                    <label class="label">Last Name <span style="color: var(--red)">*</span></label><input class="inp" id="au-lname" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g,'')" maxlength="25" placeholder="Smith" />
                    <small class="err" id="au-lname-error"></small>
                </div>
            </div>

            <div style="margin-bottom: 14px">

                <div>
                    <label class="label">Email <span style="color: var(--red)">*</span></label><input class="inp" id="au-email" type="email" placeholder="john@example.com" />
                    <small class="err" id="au-email-error"></small>
                </div>

            </div>



            <div class="g2" style="margin-bottom: 14px">
                <div>
                    <div>
                        <label class="label">Plan</label><select class="inp" id="au-plan">
                            @foreach($plans as $plan)
                            <option value="{{ $plan->plan_name }}"
                                {{ old('plan_name') == $plan->plan_name ? 'selected' : '' }}>
                                {{ $plan->plan_name }}
                            </option>
                            @endforeach
                        </select>
                        <small class="err" id="au-plan-error"></small>
                    </div>
                </div>

                <div>
                    <label class="label">Post Code <span style="color: var(--red)">*</span></label><input class="inp" id="au-postcode" type="text" maxlength="8" placeholder="Enter Post Code" />
                    <small class="err" id="au-postcode-error"></small>
                </div>

            </div>






            <div class="g2" style="margin-bottom: 14px">
                <div>
                    <label class="label">Phone <span style="color: var(--red)">*</span></label><input class="inp" id="au-phone" placeholder="+44 7700 000000" maxlength="15" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                    <small class="err" id="au-phone-error"></small>
                </div>
                <div>
                    <label class="label">Status <span style="color: var(--red)">*</span></label><select class="inp" id="au-status">
                        <option value="active">Active</option>
                        <option value="suspended">Suspended</option>
                    </select>
                    <small class="err" id="au-status-error"></small>
                </div>
            </div>
            <div style="margin-bottom: 18px">
                <label class="label">Address 1 <span style="color: var(--red)">*</span></label><input class="inp" id="address1" placeholder="Enter Address" />
                <small class="err" id="address1-error"></small>
            </div>
            <div style="display: flex; gap: 8px; justify-content: flex-end">
                <button class="btn btn-ghost btn-sm" onclick="closeModal('add-user-modal')">Cancel</button>
                <button class="btn btn-primary btn-sm" id="create-user-btn" onclick="addUser()">
                    <i class="ri-check-line"></i> Create User
                </button>
            </div>
        </div>
    </div>

    <!-- EDIT USER -->
    <div class="modal-bg z-[9999]" id="edit-user-modal">
        <div class="modal-box">
            <div class="modal-header">
                <div>
                    <h3 class="font-jakarta" style="font-weight: 700; font-size: 0.95rem; color: var(--text)">
                        <i class="ri-pencil-line" style="color: var(--purple-light); margin-right: 6px"></i>Edit
                        User
                    </h3>
                    <p style="font-size: 0.76rem; color: var(--text3); margin-top: 2px">
                        Update user account details
                    </p>
                </div>
                <button class="modal-close" onclick="closeModal('edit-user-modal')">
                    <i class="ri-close-line"></i>
                </button>
            </div>
            <input type="hidden" id="eu-id" />
            <div class="g2" style="margin-bottom: 14px">
                <div>
                    <label class="label">First Name <span style="color: var(--red)">*</span></label>
                    <input class="inp" id="eu-first_name"oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g,'')" maxlength="25" placeholder="First name" />
                    <small class="err" id="eu-first_name-error"></small>

                </div>
                <div>
                    <label class="label">Last Name <span style="color: var(--red)">*</span></label>
                    <input class="inp" id="eu-last_name" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g,'')" maxlength="25" placeholder="Last name" />
                    <small class="err" id="eu-last_name-error"></small>
                </div>

            </div>
            <div class="g2" style="margin-bottom: 14px">
                <div>
                    <label class="label">Email <span style="color: var(--red)">*</span></label><input class="inp" id="eu-email" type="email" readonly placeholder="Email" />
                </div>
                <div>
                    <label class="label">Plan</label><select class="inp" id="eu-plan">
                        @foreach($plans as $plan)
                        <option value="{{ $plan->plan_name }}"
                            {{ old('plan_name') == $plan->plan_name ? 'selected' : '' }}>
                            {{ $plan->plan_name }}
                        </option>
                        @endforeach

                    </select>
                    <small class="err" id="eu-plan-error"></small>
                </div>

                <div>
                    <label class="label">Post Code<span style="color: var(--red)">*</span></label>
                    <input class="inp" id="eu-postcode" maxlength="8" placeholder="Enter postcode" />
                    <small class="err" id="eu-postcode-error"></small>
                </div>

                <div>
                    <label class="label">Status</label><select class="inp" id="eu-status">
                        <option value="active">Active</option>
                        <option value="suspended">Suspended</option>
                    </select>
                    <small class="err" id="eu-status-error"></small>
                </div>
                <div style="margin-bottom: 18px">
                    <label class="label">Phone</label>
                    <input class="inp" maxlength="15" oninput="this.value=this.value.replace(/[^0-9]/g,'')" id="eu-phone" placeholder="+44 7700 000000" />
                    <small class="err" id="eu-phone-error"></small>
                </div>
                <div style="margin-bottom: 18px">
                <label class="label">Address 1 <span style="color: var(--red)">*</span></label><input class="inp" maxlength="80" id="eu-address1" placeholder="Enter Address" />
                <small class="err" id="eu-address1-error"></small>
            </div>
            </div>

            <div style="display: flex; gap: 8px; justify-content: flex-end">
                <button class="btn btn-ghost btn-sm" onclick="closeModal('edit-user-modal')">Cancel</button>
                <button class="btn btn-primary btn-sm" onclick="saveEditUser()">
                    <i class="ri-save-line"></i> Save Changes
                </button>
            </div>
        </div>
    </div>

    <!-- ADD STAFF -->
    <div class="modal-bg" id="add-staff-modal">
        <div class="modal-box">
            <div class="modal-header">
                <div>
                    <h3 class="font-jakarta" style="font-weight: 700; font-size: 0.95rem; color: var(--text)">
                        <i class="ri-team-line" style="color: var(--purple-light); margin-right: 6px"></i>Add Staff
                        Member
                    </h3>
                    <p style="font-size: 0.76rem; color: var(--text3); margin-top: 2px">
                        Add a new team member with a specific role
                    </p>
                </div>
                <button class="modal-close" onclick="closeModal('add-staff-modal')">
                    <i class="ri-close-line"></i>
                </button>
            </div>
            <div class="g2" style="margin-bottom: 14px">
                <div>
                    <label class="label">Full Name <span style="color: var(--red)">*</span></label><input class="inp" id="as-name" placeholder="Jane Doe" />
                </div>
                <div>
                    <label class="label">Email <span style="color: var(--red)">*</span></label><input class="inp" id="as-email" placeholder="jane@dremind.co.uk" />
                </div>
            </div>
            <div class="g2" style="margin-bottom: 14px; display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">

                <!-- Password -->
                <div style="position: relative;">
                    <label class="label">
                        Password <span style="color: var(--red)">*</span>
                    </label>
                    <input
                        type="password"
                        class="inp"
                        id="password"
                        placeholder="Enter password"
                        style="padding-right: 40px;" />
                    <i class="ri-eye-off-line toggle-eye"
                        onclick="togglePassword('password', this)"
                        style="position:absolute; right:12px; top:30px; cursor:pointer; color:#64748b;"></i>
                </div>

                <!-- Confirm Password -->
                <div style="position: relative;">
                    <label class="label">
                        Confirm Password <span style="color: var(--red)">*</span>
                    </label>
                    <input
                        type="password"
                        class="inp"
                        id="confirmPassword"
                        placeholder="Confirm password"
                        style="padding-right: 40px;" />
                    <i class="ri-eye-off-line toggle-eye"
                        onclick="togglePassword('confirmPassword', this)"
                        style="position:absolute; right:12px; top:30px; cursor:pointer; color:#64748b;"></i>
                </div>

            </div>

            <div class="g2" style="margin-bottom: 14px">
                <div>
                    <label class="label">Role <span style="color: var(--red)">*</span></label><select class="inp" id="staff-role-sel">
                        <option value="">Select role…</option>
                    </select>
                </div>
                <div>
                    <label class="label">Department</label><select class="inp" id="as-dept">
                        <option>Engineering</option>
                        <option>Support</option>
                        <option>Marketing</option>
                        <option>Finance</option>
                    </select>
                </div>
            </div>
            <div style="margin-bottom: 18px">
                <label class="label">Phone</label><input class="inp" id="as-phone" placeholder="+44 7700 000000" />
            </div>
            <div style="display: flex; gap: 8px; justify-content: flex-end">
                <button class="btn btn-ghost btn-sm" onclick="closeModal('add-staff-modal')">Cancel</button>
                <button class="btn btn-primary btn-sm" onclick="addStaffMember()">
                    <i class="ri-check-line"></i> Add Staff
                </button>
            </div>
        </div>
    </div>

    <!-- EDIT STAFF -->
    <div class="modal-bg z-[9999]" id="edit-staff-modal">
        <div class="modal-box">
            <div class="modal-header">
                <div>
                    <h3 class="font-jakarta" style="font-weight: 700; font-size: 0.95rem; color: var(--text)">
                        <i class="ri-pencil-line" style="color: var(--teal-light); margin-right: 6px"></i>Edit Staff
                        Member
                    </h3>
                    <p style="font-size: 0.76rem; color: var(--text3); margin-top: 2px">
                        Update staff details and role
                    </p>
                </div>
                <button class="modal-close" onclick="closeModal('edit-staff-modal')">
                    <i class="ri-close-line"></i>
                </button>
            </div>
            <input type="hidden" id="es-id" />
            <div class="g2" style="margin-bottom: 14px">
                <div><label class="label">Full Name</label><input class="inp" id="es-name" /></div>
                <div><label class="label">Email</label><input class="inp" id="es-email" type="email" /></div>
            </div>
            <div class="g2" style="margin-bottom: 14px">
                <div>
                    <label class="label">Role</label><select class="inp" id="es-role"></select>
                </div>
                <div>
                    <label class="label">Status</label><select class="inp" id="es-status">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>
            <div style="display: flex; gap: 8px; justify-content: flex-end">
                <button class="btn btn-ghost btn-sm" onclick="closeModal('edit-staff-modal')">Cancel</button>
                <button class="btn btn-primary btn-sm" onclick="saveEditStaff()">
                    <i class="ri-save-line"></i> Save Changes
                </button>
            </div>
        </div>
    </div>

    <!-- ADD ROLE -->
    <div class="modal-bg" id="add-role-modal">
        <div class="modal-box" style="max-width: 640px">
            <div class="modal-header">
                <div>
                    <h3 class="font-jakarta" style="font-weight: 700; font-size: 0.95rem; color: var(--text)">
                        <i class="ri-key-2-line" style="color: var(--amber); margin-right: 6px"></i>Create Role
                    </h3>
                    <p style="font-size: 0.76rem; color: var(--text3); margin-top: 2px">
                        Define a new role with specific permissions
                    </p>
                </div>
                <button class="modal-close" onclick="closeModal('add-role-modal')">
                    <i class="ri-close-line"></i>
                </button>
            </div>
            <div class="g2" style="margin-bottom: 14px">
                <div>
                    <label class="label">Role Name <span style="color: var(--red)">*</span></label><input class="inp" id="new-role-name" placeholder="e.g. Content Manager" />
                </div>
                <div>
                    <label class="label">Color</label>
                    <div
                        style="display: flex; gap: 8px; flex-wrap: wrap; margin-top: 4px"
                        id="role-color-picker"></div>
                </div>
            </div>
            <div style="margin-bottom: 14px">
                <label class="label">Description</label><input class="inp" id="new-role-desc" placeholder="What does this role do?" />
            </div>
            <div style="margin-bottom: 16px">
                <label class="label">Permissions</label>
                <div class="perm-grid" id="new-role-perms" style="margin-top: 8px"></div>
            </div>
            <div style="display: flex; gap: 8px; justify-content: flex-end">
                <button class="btn btn-ghost btn-sm" onclick="closeModal('add-role-modal')">Cancel</button>
                <button class="btn btn-primary btn-sm" onclick="createRole()">
                    <i class="ri-check-line"></i> Create Role
                </button>
            </div>
        </div>
    </div>

    <!-- SEND NOTIFICATION -->
    <div class="modal-bg" id="send-notif-modal">
        <div class="modal-box">
            <div class="modal-header">
                <div>
                    <h3 class="font-jakarta" style="font-weight: 700; font-size: 0.95rem; color: var(--text)">
                        <i class="ri-send-plane-line" style="color: var(--teal-light); margin-right: 6px"></i>Send
                        Notification
                    </h3>
                </div>
                <button class="modal-close" onclick="closeModal('send-notif-modal')">
                    <i class="ri-close-line"></i>
                </button>
            </div>
            <div style="margin-bottom: 14px">
                <label class="label">Target</label><select class="inp">
                    <option>All Users</option>
                    <option>Specific User</option>
                    <option>Pro Plan Users</option>
                </select>
            </div>
            <div style="margin-bottom: 14px">
                <label class="label">Type</label><select class="inp">
                    <option>Info</option>
                    <option>Warning</option>
                    <option>Success</option>
                    <option>Alert</option>
                </select>
            </div>
            <div style="margin-bottom: 14px">
                <label class="label">Title</label><input class="inp" placeholder="Notification title…" />
            </div>
            <div style="margin-bottom: 18px">
                <label class="label">Message</label><textarea class="inp" rows="3" placeholder="Message…" style="resize: none"></textarea>
            </div>
            <div style="display: flex; gap: 8px; justify-content: flex-end">
                <button class="btn btn-ghost btn-sm" onclick="closeModal('send-notif-modal')">Cancel</button>
                <button
                    class="btn btn-primary btn-sm"
                    onclick="toast('Notification sent!','success');closeModal('send-notif-modal')">
                    <i class="ri-send-plane-line"></i> Send
                </button>
            </div>
        </div>
    </div>

    <!-- VIEW REMINDER -->
    <div class="modal-bg" id="view-reminder-modal">
        <div class="modal-box">
            <div class="modal-header">
                <div>
                    <h3 class="font-jakarta" style="font-weight: 700; font-size: 0.95rem; color: var(--text)">
                        <i class="ri-alarm-line" style="color: var(--teal-light); margin-right: 6px"></i>Reminder
                        Details
                    </h3>
                </div>
                <button class="modal-close" onclick="closeModal('view-reminder-modal')">
                    <i class="ri-close-line"></i>
                </button>
            </div>
            <div id="rem-modal-content"></div>
            <div style="display: flex; gap: 8px; justify-content: flex-end; margin-top: 20px">
                <button class="btn btn-ghost btn-sm" onclick="closeModal('view-reminder-modal')">Close</button>
                <button
                    class="btn btn-primary btn-sm"
                    onclick="toast('Reminder updated!','success');closeModal('view-reminder-modal')">
                    <i class="ri-save-line"></i> Save Changes
                </button>
            </div>
        </div>
    </div>

    <!-- VIEW TRANSACTION -->
    <div class="modal-bg" id="view-txn-modal">
        <div class="modal-box">
            <div class="modal-header">
                <div>
                    <h3 class="font-jakarta" style="font-weight:700;font-size:.95rem;color:var(--text)">
                        <i class="ri-bank-card-line" style="color:var(--green);margin-right:6px"></i>
                        Transaction Details
                    </h3>
                </div>
                <button class="modal-close" onclick="closeModal('view-txn-modal')">
                    <i class="ri-close-line"></i>
                </button>
            </div>

            <div id="txn-modal-content"></div>

            <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:20px">
                <button class="btn btn-ghost btn-sm" onclick="closeModal('view-txn-modal')">Close</button>
                <button class="btn btn-ghost btn-sm" onclick="downloadCurrentTxnInvoice()">
                    <i class="ri-bill-line"></i> Download Invoice
                </button>
            </div>
        </div>
    </div>

    <!-- ADD CATEGORY -->
    <div class="modal-bg" id="add-category-modal">
        <div class="modal-box">

            <div class="modal-header">
                <div>
                    <h3 class="font-jakarta" style="font-weight:700;font-size:.95rem;color:var(--text)">
                        <i class="ri-folder-add-line" style="color:var(--amber);margin-right:6px"></i>
                        Add Category
                    </h3>

                    <p style="font-size:.76rem;color:var(--text3);margin-top:2px">
                        Create a new reminder category
                    </p>
                </div>

                <button class="modal-close" onclick="closeModal('add-category-modal')">
                    <i class="ri-close-line"></i>
                </button>
            </div>

            <div style="margin-bottom:14px">
                <label class="label">
                    Category Name <span style="color:var(--red)">*</span>
                </label>

                <input class="inp" id="category-name" placeholder="e.g. Fitness" oninput="clearError('name')">
                <small id="error-name" style="color:red"></small>


            </div>

            <div class="g2" style="margin-bottom:14px">

                <div>
                    <label class="label">Icon (Remixicon class)</label>

                    <input class="inp" id="category-icon" placeholder="ri-heart-line" oninput="clearError('icon')">
                    <small id="error-icon" style="color:red"></small>
                </div>

                <div>
                    <label class="label">Colour</label>
                    <input class="inp" id="category-color" type="color" value="#7c3aed" oninput="clearError('color')">
                    <small id="error-color" style="color:red"></small>
                </div>

            </div>

            <div style="margin-bottom:18px">

                <label class="label">Description</label>

                <input
                    class="inp"
                    id="category-description"
                    placeholder="Brief description…">
            </div>

            <div style="display:flex;gap:8px;justify-content:flex-end">

                <button
                    class="btn btn-ghost btn-sm"
                    onclick="closeModal('add-category-modal')">
                    Cancel
                </button>

                <button
                    class="btn btn-primary btn-sm"
                    onclick="storeCategory()">
                    <i class="ri-check-line"></i> Create
                </button>

            </div>

        </div>
    </div>

    <script>
        async function storeCategory() {

            ['name', 'icon', 'color'].forEach(field => {

                const el = document.getElementById(`error-${field}`);

                if (el) {
                    el.innerHTML = '';
                }
            });

            try {

                const response = await fetch("{{ route('admin.category.store') }}", {

                    method: 'POST',

                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document
                            .querySelector('meta[name="csrf-token"]')
                            .content
                    },

                    body: JSON.stringify({

                        name: document.getElementById('category-name').value,

                        icon: document.getElementById('category-icon').value,

                        color: document.getElementById('category-color').value,

                        description: document.getElementById('category-description').value,
                    })
                });

                const text = await response.text();

                let data;

                try {

                    data = JSON.parse(text);

                } catch (e) {

                    console.log(text);

                    toast('Server error', 'error');

                    return;
                }

                if (!response.ok) {

                    if (data.errors) {

                        Object.keys(data.errors).forEach(field => {

                            const el = document.getElementById(`error-${field}`);

                            if (el) {
                                el.innerHTML = data.errors[field][0];
                            }
                        });
                    }

                    return;
                }

                toast(data.message, 'success');

                closeModal('add-category-modal');

            } catch (error) {

                console.log(error);

                toast('Something went wrong', 'error');
            }
        }
    </script>

    <script>
        function clearError(field) {

            const el = document.getElementById(`error-${field}`);

            if (el) {
                el.innerHTML = '';
            }
        }
    </script>

    <!-- ADD SUB-CATEGORY -->
    <div class="modal-bg" id="add-subcategory-modal">
        <div class="modal-box">
            <div class="modal-header">
                <div>
                    <h3 class="font-jakarta" style="font-weight:700;font-size:.95rem;color:var(--text)">
                        <i class="ri-node-tree" style="color:var(--teal);margin-right:6px"></i>
                        Add Subcategory
                    </h3>
                    <p style="font-size:.76rem;color:var(--text3);margin-top:2px">
                        Create a child subcategory under a parent category
                    </p>
                </div>
                <button class="modal-close" onclick="closeModal('add-subcategory-modal')">
                    <i class="ri-close-line"></i>
                </button>
            </div>

            <div style="margin-bottom:14px">
                <label class="label">Parent Category <span style="color:var(--red)">*</span></label>
                <select class="inp" id="subcategory-parent" onchange="clearSubError('category_id')">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                <small id="error-category_id" style="color:red;display:block;margin-top:4px"></small>
            </div>

            <div style="margin-bottom:14px">
                <label class="label">Subcategory Name <span style="color:var(--red)">*</span></label>
                <input class="inp" id="subcategory-name" placeholder="e.g. Car Insurance" oninput="clearSubError('name')" />
                <small id="error-subname" style="color:red;display:block;margin-top:4px"></small>
            </div>

            <div style="margin-bottom:18px">
                <label class="label">Description</label>
                <input class="inp" id="subcategory-desc" placeholder="Brief description..." />
            </div>

            <div style="display:flex;gap:8px;justify-content:flex-end">
                <button class="btn btn-ghost btn-sm" onclick="closeModal('add-subcategory-modal')">Cancel</button>
                <button class="btn btn-primary btn-sm" onclick="createSubcategory()">
                    <i class="ri-check-line"></i> Create
                </button>
            </div>
        </div>
    </div>

    <script>
        function clearSubError(field) {

            const map = {
                category_id: 'error-category_id',
                name: 'error-subname'
            };

            const el = document.getElementById(map[field]);

            if (el) {
                el.innerHTML = '';
            }
        }

        async function createSubcategory() {

            const map = {
                category_id: 'error-category_id',
                name: 'error-subname'
            };

            ['category_id', 'name'].forEach(field => {

                const el = document.getElementById(map[field]);

                if (el) {
                    el.innerHTML = '';
                }
            });

            const response = await fetch("{{ route('admin.subcategory.store') }}", {

                method: 'POST',

                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]')
                        .content
                },

                body: JSON.stringify({

                    category_id: document.getElementById('subcategory-parent').value,

                    name: document.getElementById('subcategory-name').value,

                    description: document.getElementById('subcategory-desc').value
                })
            });

            const data = await response.json();

            if (!response.ok) {

                Object.keys(data.errors).forEach(field => {

                    const el = document.getElementById(map[field]);

                    if (el) {
                        el.innerHTML = data.errors[field][0];
                    }
                });

                return;
            }

            toast(data.message, 'success');

            closeModal('add-subcategory-modal');

            document.getElementById('subcategory-parent').value = '';
            document.getElementById('subcategory-name').value = '';
            document.getElementById('subcategory-desc').value = '';
        }
    </script>

    <!-- EDIT CATEGORY -->
    <div class="modal-bg z-[9999]" id="edit-category-modal">
        <div class="modal-box">
            <div class="modal-header">
                <div>
                    <h3 class="font-jakarta" style="font-weight:700;font-size:.95rem;color:var(--text)">
                        <i class="ri-pencil-line" style="color:var(--purple);margin-right:6px"></i>
                        Edit Category
                    </h3>
                    <p style="font-size:.76rem;color:var(--text3);margin-top:2px">
                        Update category details
                    </p>
                </div>
                <button class="modal-close" onclick="closeModal('edit-category-modal')">
                    <i class="ri-close-line"></i>
                </button>
            </div>

            <input type="hidden" id="edit-cat-id" />

            <div style="margin-bottom:14px">
                <label class="label">Category Name <span style="color:var(--red)">*</span></label>
                <input class="inp" id="edit-cat-name" placeholder="e.g. Insurance" />
            </div>

            <div class="g2" style="margin-bottom:14px">
                <div>
                    <label class="label">Icon</label>
                    <input class="inp" id="edit-cat-icon" placeholder="ri-shield-star-line" />
                </div>
                <div>
                    <label class="label">Colour</label>
                    <input class="inp" id="edit-cat-color" type="color" style="height:42px;padding:4px" />
                </div>
            </div>

            <div style="margin-bottom:18px">
                <label class="label">Description</label>
                <input class="inp" id="edit-cat-desc" placeholder="Brief description..." />
            </div>

            <div style="display:flex;gap:8px;justify-content:flex-end">
                <button class="btn btn-ghost btn-sm" onclick="closeModal('edit-category-modal')">Cancel</button>
                <button class="btn btn-primary btn-sm" onclick="saveCategoryEdit()">
                    <i class="ri-check-line"></i> Save Changes
                </button>
            </div>
        </div>
    </div>

    <!-- EDIT SUBCATEGORY -->
    <div class="modal-bg z-[9999]" id="edit-subcategory-modal">
        <div class="modal-box">
            <div class="modal-header">
                <div>
                    <h3 class="font-jakarta" style="font-weight:700;font-size:.95rem;color:var(--text)">
                        <i class="ri-edit-2-line" style="color:var(--teal);margin-right:6px"></i>
                        Edit Subcategory
                    </h3>
                    <p style="font-size:.76rem;color:var(--text3);margin-top:2px">
                        Update subcategory details
                    </p>
                </div>
                <button class="modal-close" onclick="closeModal('edit-subcategory-modal')">
                    <i class="ri-close-line"></i>
                </button>
            </div>

            <input type="hidden" id="edit-sub-id" />
            <input type="hidden" id="edit-sub-old-parent-id" />

            <div style="margin-bottom:14px">
                <label class="label">Parent Category <span style="color:var(--red)">*</span></label>
                <select class="inp" id="edit-sub-parent"></select>
            </div>

            <div style="margin-bottom:14px">
                <label class="label">Subcategory Name <span style="color:var(--red)">*</span></label>
                <input class="inp" id="edit-sub-name" placeholder="e.g. Car Insurance" />
            </div>

            <div style="margin-bottom:14px">
                <label class="label">Description</label>
                <input class="inp" id="edit-sub-desc" placeholder="Brief description..." />
            </div>

            <div style="display:flex;gap:8px;justify-content:flex-end">
                <button class="btn btn-ghost btn-sm" onclick="closeModal('edit-subcategory-modal')">Cancel</button>
                <button class="btn btn-primary btn-sm" onclick="saveSubcategoryEdit()">
                    <i class="ri-check-line"></i> Save Changes
                </button>
            </div>
        </div>
    </div>

    <!-- CATEGORY DETAIL -->
    <div class="modal-bg" id="category-detail-modal">
        <div class="modal-box" style="max-width:760px">
            <div class="modal-header">
                <div>
                    <h3 class="font-jakarta" style="font-weight:700;font-size:.98rem;color:var(--text)">
                        <i class="ri-folder-info-line" style="color:var(--purple);margin-right:6px"></i>
                        Category Details
                    </h3>
                    <p style="font-size:.76rem;color:var(--text3);margin-top:2px">
                        View and manage category with subcategories
                    </p>
                </div>
                <button class="modal-close" onclick="closeModal('category-detail-modal')">
                    <i class="ri-close-line"></i>
                </button>
            </div>

            <div id="category-detail-content"></div>
        </div>
    </div>

    <!-- CONFIRM ACTION -->
    <div class="modal-bg" id="confirm-modal">
        <div class="modal-box" style="max-width: 420px">
            <div class="modal-header">
                <div>
                    <h3 class="font-jakarta" style="font-weight: 700; font-size: 0.95rem; color: var(--red)">
                        <i class="ri-alert-line" style="margin-right: 6px"></i>Confirm Action
                    </h3>
                </div>
                <button class="modal-close" onclick="closeModal('confirm-modal')">
                    <i class="ri-close-line"></i>
                </button>
            </div>
            <p
                id="confirm-msg"
                style="font-size: 0.85rem; color: var(--text2); margin-bottom: 24px; line-height: 1.6"></p>
            <div style="display: flex; gap: 8px; justify-content: flex-end">
                <button class="btn btn-ghost btn-sm" onclick="closeModal('confirm-modal')">Cancel</button>
                <button class="btn btn-danger btn-sm" id="confirm-ok-btn">
                    <i class="ri-check-line"></i> Confirm
                </button>
            </div>
        </div>
    </div>

    <!-- DRAWER -->
    <div
        style="
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.6);
                backdrop-filter: blur(5px);
                z-index: 9997;
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.25s;
            "
        id="drawer-overlay"
        onclick="closeDrawer()"></div>
    <div
        style="
                    position: fixed;
                    top: 0;
                    right: 0;
                    width: min(440px, 100vw);
                    height: 100vh;
                    background: var(--bg2);
                    border-left: 1px solid rgba(124, 58, 237, 0.2);
                    z-index: 9998;
                    transform: translateX(100%);
                    transition: transform 0.32s cubic-bezier(0.16, 1, 0.3, 1);
                    overflow-y: auto;
                    padding: 26px;
                    box-shadow: -20px 0 60px rgba(0, 0, 0, 0.5);
                "
        id="detail-drawer">
        <div id="drawer-content"></div>
    </div>

    <script src="{{ asset('assets/js/admin.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <script>
        function togglePassword(id, el) {
            const input = document.getElementById(id);

            if (input.type === "password") {
                input.type = "text";
                el.classList.remove("ri-eye-off-line");
                el.classList.add("ri-eye-line");
            } else {
                input.type = "password";
                el.classList.remove("ri-eye-line");
                el.classList.add("ri-eye-off-line");
            }
        }
    </script>
    <script>
        new TomSelect('#subcategory-parent', {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });
    </script>
    <script>
        ['eu-first_name', 'eu-last_name', 'eu-phone', 'eu-plan', 'eu-status','eu-postcode','eu-address1'].forEach(function(id) {

            document.getElementById(id).addEventListener('input', function() {

                let error = document.getElementById(id + '-error');

                if (error) {
                    error.innerText = '';
                }

            });

        });
    </script>

    <script>
        ['au-fname', 'au-lname', 'au-email', 'au-postcode', 'au-phone', 'au-plan', 'au-status', 'address1'].forEach(function(id) {
            document.getElementById(id).addEventListener('input', function() {
                let error = document.getElementById(id + '-error');
                if (error) {
                    error.innerText = '';
                }
            });

        });
    </script>

</body>

</html>