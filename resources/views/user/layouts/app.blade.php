<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>D-Remind — Winngoo</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <link href="{{ asset('/assets/css/user.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,400&family=DM+Mono:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">



    <style>
        .error-text{
    display:block;
    color:#f43f5e;
    font-size:.72rem;
    margin-top:4px;
}
        /* ─── Page Loader Overlay ─── */
        #page-loader {
            position: fixed;
            inset: 0;
            background: #f7f5f0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.7s cubic-bezier(0.4, 0, 0.2, 1),
                visibility 0.7s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #page-loader.hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        /* ─── Loader Card ─── */
        #loader-card {
            width: 380px;
            max-width: 90vw;
            border-radius: 24px;
            overflow: hidden;
            transform: translateY(0);
            transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #page-loader.hidden #loader-card {
            transform: translateY(-12px);
        }

        /* ─── Accent bar ─── */
        .accent-bar {
            height: 3px;
            background: linear-gradient(90deg, #7c3aed, #a855f7, #e879f9, #c084fc);
            background-size: 200% 100%;
            animation: shimmer 2s linear infinite;
        }

        @keyframes shimmer {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }

        /* ─── Canvas Stage ─── */
        #loader-stage {
            position: relative;
            width: 100%;
            height: 280px;
            overflow: hidden;
        }

        #loader-stage canvas {
            position: absolute;
            inset: 0;
            width: 100% !important;
            height: 100% !important;
        }


        /* ─── Progress dots ─── */
        .dots {
            display: flex;
            gap: 6px;
            justify-content: center;
            margin-top: 12px;
        }

        .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #c4b5fd;
            animation: pulse-dot 1.4s ease-in-out infinite;
        }

        .dot:nth-child(2) {
            animation-delay: 0.2s;
        }

        .dot:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes pulse-dot {

            0%,
            80%,
            100% {
                transform: scale(1);
                background: #c4b5fd;
            }

            40% {
                transform: scale(1.5);
                background: #7c3aed;
            }
        }
    </style>


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

<body>

    @php
    use App\Models\Category;
    use App\Models\SubCategory;

    $user = Auth::user();

    $categories = Category::with([
    'subcategories' => function ($query) use ($user) {

    $query->where('status', 'Active')
    ->where(function ($q) use ($user) {

    $q->where('role', 'admin')
    ->orWhere(function ($subQ) use ($user) {

    $subQ->where('role', 'user')
    ->where('created_by', $user->id);
    });
    });
    }
    ])
    ->where('status', 'Active')
    ->get();

    @endphp

    <!-- LOADER START -->
    <!-- <div id="loader">
        <img src="{{ asset('assets/images/common/loader.gif') }}" alt="">
    </div> -->

    <div id="loader">
        <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.9.10/dist/dotlottie-wc.js" type="module"></script>
        <dotlottie-wc src="https://lottie.host/9e89873a-1424-4d8a-85de-8eaf04ba6f2a/x6B0SnIuaY.lottie" style="width: 300px;height: 300px" autoplay loop></dotlottie-wc>
    </div>

    <!-- <section id="page-loader" role="status" aria-label="Loading RemindMe">
        <div id="loader-card">
            <div id="loader-stage">
            <canvas id="loader-canvas"></canvas>
            </div>
        </div>
    </section> -->
    <!-- LOADER END -->


    <div id="toast-area"></div>

    <!-- Mobile Sidebar Overlay -->
    <div id="sb-overlay" onclick="closeMobile()"></div>

    <div style="display:flex;height:100vh;overflow:hidden">

        <!-- ========== SIDEBAR ========== -->
        @include('user.components.sidebar')

        <!-- ========== MAIN ========== -->
        <div style="flex:1;display:flex;flex-direction:column;overflow:hidden;min-width:0">

            <!-- TOPBAR -->
            @include('user.components.header')

            <!-- CONTENT -->
            <main id="main" style="flex:1;overflow-y:auto;padding:24px;overflow-x:hidden">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- ============ MODALS ============ -->
    <!-- Share Modal -->
    <div class="modal-bg" id="share-modal">
        <div class="modal-box">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
                <h3 class="font-jakarta" style="font-weight:700;font-size:.95rem;color:#f1f5f9;display:flex;align-items:center;gap:8px"><i class="ri-share-line" style="color:#2dd4bf"></i> Share Reminder</h3>
                <button onclick="closeModal('share-modal')" class="btn btn-icon btn-ghost btn-sm"><i class="ri-close-line"></i></button>
            </div>
            <div style="margin-bottom:14px"><label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:6px">Select Reminder</label><select class="inp" id="share-rem-select">
                    <option>Mum's Birthday - Jun 3, 2026</option>
                    <option>Car Insurance Renewal - Apr 19, 2026</option>
                    <option>Netflix Subscription - Apr 24, 2026</option>
                </select></div>
            <div style="margin-bottom:14px"><label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:8px">Share Method</label>
                <div style="display:flex;gap:8px">
                    <button class="btn" style="flex:1;justify-content:center;padding:12px;border-radius:12px;border:1px solid rgba(37,211,102,.3);background:rgba(37,211,102,.08);color:#25D366;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:.84rem;cursor:pointer" onclick="toast('Opening WhatsApp…','success');closeModal('share-modal')"><i class="ri-whatsapp-line"></i> WhatsApp</button>
                    <button class="btn" style="flex:1;justify-content:center;padding:12px;border-radius:12px;border:1px solid rgba(20,184,166,.3);background:rgba(20,184,166,.08);color:#2dd4bf;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:.84rem;cursor:pointer" onclick="toast('Opening email…','info');closeModal('share-modal')"><i class="ri-mail-line"></i> Email</button>
                    <button class="btn" style="flex:1;justify-content:center;padding:12px;border-radius:12px;border:1px solid rgba(124,58,237,.3);background:rgba(124,58,237,.08);color:#a78bfa;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:.84rem;cursor:pointer" onclick="toast('Link copied!','success');closeModal('share-modal')"><i class="ri-link"></i> Copy Link</button>
                </div>
            </div>
            <div style="margin-bottom:14px"><label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:6px">Recipient</label><input class="inp" placeholder="+44 7700 900123 or email@example.com"></div>
            <div style="margin-bottom:18px"><label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:6px">Message (Optional)</label><textarea class="inp" rows="2" placeholder="Add a personal message…" style="resize:none"></textarea></div>
            <div style="display:flex;gap:10px;justify-content:flex-end"><button class="btn btn-ghost" onclick="closeModal('share-modal')">Cancel</button><button class="btn btn-primary" onclick="toast('Reminder shared successfully!','success');closeModal('share-modal')"><i class="ri-send-plane-line"></i> Share</button></div>
        </div>
    </div>

    <!-- Upgrade Modal -->
    <div class="modal-bg" id="upg-modal">
        <div class="modal-box" style="max-width:440px">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
                <h3 class="font-jakarta" style="font-weight:700;font-size:.95rem;color:#f1f5f9;display:flex;align-items:center;gap:8px"><i class="ri-rocket-line" style="color:#a78bfa"></i> Upgrade Plan</h3>
                <button onclick="closeModal('upg-modal')" class="btn btn-icon btn-ghost btn-sm"><i class="ri-close-line"></i></button>
            </div>
            <div style="text-align:center;padding:20px;background:rgba(124,58,237,.08);border-radius:14px;margin-bottom:16px"><i class="ri-information-line" style="font-size:2rem;color:#a78bfa;display:block;margin-bottom:8px"></i>
                <p style="font-size:.84rem;color:#64748b">You're on the Basic Annual plan. Pro and Family plans with advanced features are coming soon! Stay tuned for exciting updates.</p>
            </div>
            <div style="display:flex;justify-content:center"><button class="btn btn-ghost" onclick="closeModal('upg-modal')">Got it</button></div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal-bg" id="pay-modal">
        <div class="modal-box">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
                <h3 class="font-jakarta" style="font-weight:700;font-size:.95rem;color:#f1f5f9;display:flex;align-items:center;gap:8px"><i class="ri-bank-card-line" style="color:#2dd4bf"></i> Update Payment Method</h3>
                <button onclick="closeModal('pay-modal')" class="btn btn-icon btn-ghost btn-sm"><i class="ri-close-line"></i></button>
            </div>
            <div style="display:flex;flex-direction:column;gap:12px;margin-bottom:18px">
                <div><label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:6px">Name on Card <span style="color:#f43f5e">*</span></label><input class="inp" value="Kishore Rex"></div>
                <div><label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:6px">Card Number <span style="color:#f43f5e">*</span></label><input class="inp" placeholder="1234 5678 9012 3456" maxlength="19"></div>
                <div class="g2">
                    <div><label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:6px">Expiry</label><input class="inp" placeholder="MM/YYYY" maxlength="7"></div>
                    <div><label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:6px">CVC</label><input class="inp" placeholder="123" maxlength="3" type="password"></div>
                </div>
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end"><button class="btn btn-ghost" onclick="closeModal('pay-modal')">Cancel</button><button class="btn btn-primary" onclick="toast('Payment method updated!','success');closeModal('pay-modal')"><i class="ri-save-line"></i> Update Card</button></div>
        </div>
    </div>

    <!-- Cancel Plan Modal -->
    <div class="modal-bg" id="cancel-modal">
        <div class="modal-box" style="max-width:440px">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px">
                <h3 class="font-jakarta" style="font-weight:700;font-size:.95rem;color:#f43f5e;display:flex;align-items:center;gap:8px"><i class="ri-error-warning-line"></i> Cancel Membership</h3>
                <button onclick="closeModal('cancel-modal')" class="btn btn-icon btn-ghost btn-sm"><i class="ri-close-line"></i></button>
            </div>
            <div style="text-align:center;margin-bottom:18px"><i class="ri-emotion-sad-line" style="font-size:3rem;color:rgba(244,63,94,.35);display:block;margin-bottom:10px"></i>
                <div class="font-jakarta" style="font-weight:700;font-size:.95rem;color:#f1f5f9;margin-bottom:6px">We're sorry to see you go!</div>
                <p style="font-size:.83rem;color:#64748b">You'll lose access to all premium features when your plan ends on April 10, 2027.</p>
            </div>
            <div style="margin-bottom:16px"><label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:6px">Reason (Optional)</label><select class="inp">
                    <option value="">Select reason…</option>
                    <option>Too expensive</option>
                    <option>Not using enough</option>
                    <option>Missing features</option>
                    <option>Technical issues</option>
                    <option>Switching to competitor</option>
                    <option>Other</option>
                </select></div>
            <div style="display:flex;gap:10px;justify-content:flex-end"><button class="btn btn-primary" onclick="closeModal('cancel-modal')">Keep My Plan</button><button class="btn btn-danger" onclick="toast('Cancellation requested. Plan remains active until April 10, 2027.','warning');closeModal('cancel-modal')"><i class="ri-close-circle-line"></i> Confirm Cancel</button></div>
        </div>
    </div>

    <!-- Add Subcategory Modal — FIXED -->
    <div class="modal-bg" id="add-sub-modal">
        <div class="modal-box" style="max-width:500px">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
                <h3 class="font-jakarta" style="font-weight:700;font-size:.95rem;color:#f1f5f9;display:flex;align-items:center;gap:8px"><i class="ri-folder-add-line" style="color:#2dd4bf"></i> Add Custom Subcategory</h3>
                <button onclick="closeModal('add-sub-modal')" class="btn btn-icon btn-ghost btn-sm"><i class="ri-close-line"></i></button>
            </div>
            <div style="margin-bottom:14px">
                <label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:6px">Parent Category <span style="color:#f43f5e">*</span></label>
                <select class="inp" id="sub-cat-parent">

                    <option value="">Select parent category…</option>

                    @foreach($categories as $category)

                    <option value="{{ $category->id }}">

                        {{ $category->name }}

                    </option>

                    @endforeach

                </select>
                <div class="error-text" id="err-category_id"></div>
            </div>
            <div style="margin-bottom:14px">
                <label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:6px">Subcategory Name <span style="color:#f43f5e">*</span></label>
                <input class="inp" id="sub-cat-name" placeholder="Enter name (3–50 characters)" maxlength="50">
                <div class="error-text" id="err-name"></div>

            </div>
            <div style="margin-bottom:18px">
                <label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:6px">Description (Optional)</label>
                <input class="inp" id="sub-cat-desc" placeholder="Brief description…" maxlength="100">
                <div class="error-text" id="err-description"></div>
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end"><button class="btn btn-ghost" onclick="closeModal('add-sub-modal')">Cancel</button><button class="btn btn-primary" onclick="saveSubcat()"><i class="ri-check-line"></i> Add Subcategory</button></div>
        </div>
    </div>

    <!-- Support Modal -->
    <div class="modal-bg" id="support-modal">
        <div class="modal-box">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
                <h3 class="font-jakarta" style="font-weight:700;font-size:.95rem;color:#f1f5f9;display:flex;align-items:center;gap:8px"><i class="ri-customer-service-2-line" style="color:#a78bfa"></i> Contact Support</h3>
                <button onclick="closeModal('support-modal')" class="btn btn-icon btn-ghost btn-sm"><i class="ri-close-line"></i></button>
            </div>
            <div style="display:flex;flex-direction:column;gap:12px;margin-bottom:18px">
                <div class="g2">
                    <div><label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;color:#64748b;margin-bottom:6px">Name</label><input class="inp" value="Kishore Rex" readonly style="opacity:.7"></div>
                    <div><label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;color:#64748b;margin-bottom:6px">Email</label><input class="inp" value="Kishore@example.com" readonly style="opacity:.7"></div>
                </div>
                <div><label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;color:#64748b;margin-bottom:6px">Issue Category <span style="color:#f43f5e">*</span></label><select class="inp">
                        <option value="">Select…</option>
                        <option>Technical Issue</option>
                        <option>Billing</option>
                        <option>Feature Request</option>
                        <option>Account Help</option>
                        <option>Other</option>
                    </select></div>
                <div><label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;color:#64748b;margin-bottom:6px">Subject <span style="color:#f43f5e">*</span></label><input class="inp" placeholder="Brief description of your issue"></div>
                <div><label style="display:block;font-size:.67rem;font-weight:700;text-transform:uppercase;color:#64748b;margin-bottom:6px">Message <span style="color:#f43f5e">*</span></label><textarea class="inp" rows="4" placeholder="Describe in detail…" style="resize:vertical"></textarea></div>
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end"><button class="btn btn-ghost" onclick="closeModal('support-modal')">Cancel</button><button class="btn btn-primary" onclick="toast('Support request sent! We\'ll respond within 24 hours.','success');closeModal('support-modal')"><i class="ri-send-plane-line"></i> Send Request</button></div>
        </div>
    </div>

    <!-- Reminder Detail Modal -->
    <div class="modal-bg" id="detail-modal">
        <div class="modal-box">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px">
                <h3 class="font-jakarta" style="font-weight:700;font-size:.95rem;color:#f1f5f9;display:flex;align-items:center;gap:8px"><i class="ri-information-line" style="color:#2dd4bf"></i> Reminder Details</h3>
                <button onclick="closeModal('detail-modal')" class="btn btn-icon btn-ghost btn-sm"><i class="ri-close-line"></i></button>
            </div>
            <div id="detail-content"></div>
        </div>
    </div>

    <!-- Confirm Modal -->
    <div class="modal-bg" id="confirm-modal">
        <div class="modal-box" style="max-width:420px">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px">
                <div style="width:40px;height:40px;border-radius:12px;background:rgba(245,158,11,.12);display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="ri-question-line" style="color:#f59e0b;font-size:1.1rem"></i></div>
                <h3 class="font-jakarta" style="font-weight:700;font-size:.95rem;color:#f1f5f9">Confirm Action</h3>
            </div>
            <p id="confirm-msg" style="font-size:.85rem;color:#64748b;margin-bottom:22px;line-height:1.6"></p>
            <div style="display:flex;gap:10px;justify-content:flex-end"><button class="btn btn-ghost" onclick="closeModal('confirm-modal')">Cancel</button><button class="btn btn-primary" id="confirm-ok">Confirm</button></div>
        </div>
    </div>

    <!-- Reminder Create Modal -->
    <div id="reminder-modal" class="modal-overlay" style="display:none">
        <div class="modal-container" style="max-width:720px">
            <div class="modal-header">
                <div>
                    <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800;color:#f1f5f9">Create New Reminder</h2>
                    <p style="font-size:.82rem;color:#64748b;margin-top:3px">Fill in the details to set your reminder</p>
                </div>
                <button class="modal-close" onclick="closeReminderModal()">
                    <i class="ri-close-line"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="rem-form" onsubmit="return false;">
                    <div style="margin-bottom:18px">
                        <label style="display:block;font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:7px">Title <span style="color:#f43f5e">*</span></label>
                        <input class="inp" id="r-title" placeholder="e.g. Car Insurance Renewal" maxlength="100">
                        <div class="error-text" id="err-title"></div>
                        <div style="font-size:.72rem;color:#475569;margin-top:4px">3–100 characters</div>
                    </div>
                    <div class="g2" style="margin-bottom:18px">
                        <div>
                            <label style="display:block;font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:7px">Category <span style="color:#f43f5e">*</span></label>
                            <select class="inp" id="r-cat" onchange="updateSubs()">
                                <option value="">Select category…</option>
                            </select>
                            <div class="error-text" id="err-rem-category_id"></div>
                        </div>

                        <div>
                            <label style="display:block;font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:7px">Subcategory <span style="color:#f43f5e">*</span></label>
                            <div style="display:flex;gap:6px;align-items:center">
                                <select class="inp" id="r-sub" disabled style="flex:1">
                                    <option value="">Select category first…</option>
                                </select>
                           
                                <button type="button" onclick="openSubPopup()"
                                    style="width:34px;height:34px;border-radius:8px;border:1px solid rgba(255,255,255,.1);background:rgba(255,255,255,.05);color:#a78bfa;cursor:pointer">
                                    <i class="ri-add-line"></i>
                                </button>
                            </div>
                            <div class="error-text" id="err-subcategory_name"></div>
                        </div>
                    </div>
                    <div class="g2" style="margin-bottom:18px">
                        <div>
                            <label style="display:block;font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:7px">Date <span style="color:#f43f5e">*</span></label>
                            <input class="inp" type="date" id="r-date">
                            <div class="error-text" id="err-reminder_date"></div>
                        </div>
                        <div>
                            <label style="display:block;font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:7px">Time <span style="color:#f43f5e">*</span></label>
                            <input class="inp" type="time" id="r-time" value="09:00">
                            <div class="error-text" id="err-reminder_time"></div>
                        </div>
                    </div>
                    <div style="margin-bottom:18px">
                        <label style="display:block;font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:7px">Description <span style="color:#64748b;font-weight:400;text-transform:none">(Optional · max 200 chars)</span></label>
                        <textarea class="inp" id="r-desc" rows="3" maxlength="200" placeholder="Brief notes…" oninput="document.getElementById('desc-len').textContent=this.value.length" style="resize:vertical"></textarea>
                        <div class="error-text" id="err-description"></div>
                        <div style="font-size:.72rem;color:#475569;margin-top:4px"><span id="desc-len">0</span>/200</div>
                    </div>
                    <div id="opt-fields" style="display:none">
                        <div class="g2" style="margin-bottom:18px">
                            <div>
                                <label style="display:block;font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:7px">Provider</label>
                                <input class="inp" id="r-provider" placeholder="e.g. AA Insurance" maxlength="50">
                                <div class="error-text" id="err-provider"></div>
                            </div>
                            <div>
                                <label style="display:block;font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:7px">Cost (£)</label>
                                <input class="inp" type="number" id="r-cost" placeholder="0.00" min="0" step="0.01">
                                <div class="error-text" id="err-cost"></div>
                            </div>
                        </div>
                        <div style="margin-bottom:18px">
                            <label style="display:block;font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:7px">Payment Frequency</label>
                            <select class="inp" id="r-freq">
                                <option value="">—</option>
                                <option>Monthly</option>
                                <option>Quarterly</option>
                                <option>Half-Yearly</option>
                                <option>Annually</option>
                            </select>
                            <div class="error-text" id="err-payment_frequency"></div>
                        </div>
                        <!-- <div style="margin-bottom:18px">
                            <label style="display:block;font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:7px">Theme</label>
                            <select class="inp" id="r-theme">
                                <option value="">— Select Theme —</option>
                                <option value="Default">Default</option>
                                <option value="Nature">Nature</option>
                                <option value="Minimal">Minimal</option>
                                <option value="Vibrant">Vibrant</option>
                                <option value="Dark">Dark</option>
                            </select>
                        </div> -->
                    </div>
                    <div style="display:flex;gap:10px;justify-content:flex-end;padding-top:16px;border-top:1px solid rgba(255,255,255,.06)">
                        <button type="button" class="btn btn-ghost" onclick="closeReminderModal()">
                            <i class="ri-close-line"></i> Cancel
                        </button>
                        <button type="button"
                            class="btn btn-primary"
                            id="create-btn"
                            onclick="submitReminder()">
                            <i class="ri-check-line"></i> <span id="create-btn-txt">Create Reminder</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sub-category Create Modal -->
    <div id="sub-popup" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.6);z-index:9999;align-items:center;justify-content:center">
        <div style="width:320px;background:#0f172a;padding:18px;border-radius:12px;border:1px solid rgba(255,255,255,.1)">
            <h3 style="font-size:.9rem;font-weight:700;color:#fff !important;margin-bottom:10px">Add Subcategory</h3>
            <input id="new-sub-input" placeholder="Enter subcategory..."
                style="width:100%;padding:8px;border-radius:8px;border:1px solid rgba(255,255,255,.1);background:rgba(255,255,255,.05);color:#fff;font-size:.8rem">
            <div style="display:flex;gap:8px;margin-top:14px;justify-content:flex-end">
                <button onclick="closeSubPopup()" class="btn btn-ghost btn-sm">Cancel</button>
                <button onclick="saveSubcategory()" class="btn btn-primary btn-sm">Add</button>
            </div>
        </div>
    </div>

    <!-- Sub-category Create Modal -->
    <div id="sub-popup" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.6);z-index:9999;align-items:center;justify-content:center">

        <div style="width:320px;background:#0f172a;padding:18px;border-radius:12px;border:1px solid rgba(255,255,255,.1)">

            <h3 style="font-size:.9rem;font-weight:700;color:#fff !important;margin-bottom:10px">
                Add Subcategory
            </h3>

            <input id="new-sub-input" placeholder="Enter subcategory..."
                style="width:100%;padding:8px;border-radius:8px;border:1px solid rgba(255,255,255,.1);
                    background:rgba(255,255,255,.05);color:#fff;font-size:.8rem">

            <div style="display:flex;gap:8px;margin-top:14px;justify-content:flex-end">
                <button onclick="closeSubPopup()" class="btn btn-ghost btn-sm">Cancel</button>
                <button onclick="saveSubcategory()" class="btn btn-primary btn-sm">Add</button>
            </div>
        </div>

    </div>

    <script>
        const typeSelect = document.getElementById('r-type');
        const customInput = document.getElementById('r-custom');

        typeSelect.addEventListener('change', function() {
            if (this.value === 'custom') {
                customInput.style.display = 'block';
                customInput.focus();
            } else {
                customInput.style.display = 'none';
                customInput.value = '';
            }
        });
    </script>


    <style>
        @media(max-width:768px) {
            #mobile-menu-btn {
                display: flex !important
            }

            .mobile-hide-xs {
                display: none !important
            }
        }

        @media(max-width:480px) {
            .mobile-hide-sm span {
                display: none
            }

            main {
                padding: 16px !important
            }
        }
    </style>

    <style>
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(4px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            animation: fadeIn 0.2s ease;
        }

        .modal-container {
            background: #1e293b;
            border-radius: 12px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: slideUp 0.3s ease;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 24px 24px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            position: sticky;
            top: 0;
            background: #1e293b;
            z-index: 1;
        }

        .modal-close {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #94a3b8;
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            flex-shrink: 0;
        }

        .modal-close:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #f1f5f9;
        }

        .modal-body {
            padding: 24px;
        }

        .light .modal-overlay {
            background: rgba(0, 0, 0, 0.45);
        }

        .light .modal-container {
            background: #ffffff;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .light .modal-header {
            background: #ffffff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        }

        .light .modal-close {
            background: rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: #475569;
        }

        .light .modal-close:hover {
            background: rgba(0, 0, 0, 0.08);
            color: #0f172a;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 640px) {
            .modal-container {
                max-height: 95vh;
            }

            .modal-header,
            .modal-body {
                padding: 16px;
            }
        }
    </style>
    <script src="https://www.gstatic.com/firebasejs/10.7.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/10.7.0/firebase-messaging-compat.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <!-- <script src="{{ asset('assets/js/loader.js') }}"></script> -->

    <script>
        window.CATS = @json($cats);
    </script>

    <script>
        new TomSelect("#sub-cat-parent", {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            },
            placeholder: "Search category..."
        });
    </script>

    <script src="{{ asset('assets/js/user.js') }}"></script>

</body>

</html>