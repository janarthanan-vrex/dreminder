@extends('user.layouts.app')
@section('content')

<section id="page-feedback" class="">
    <div style="margin-bottom:16px">
        <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800;color:#f1f5f9">We Value Your Feedback</h2>
        <p style="font-size:.82rem;color:#64748b;margin-top:3px">Help us improve D-Remind by sharing your thoughts</p>
    </div>
    <div class="g2">
        <div class="card" style="padding:22px">
            <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:14px">Share Your Thoughts</h3>

            {{-- ✅ Removed onsubmit= attribute; handled via JS below --}}
            <form id="feedbackForm" novalidate>

                <input type="hidden" id="fb-priority" name="priority" value="Low">

                {{-- SUBJECT --}}
                <div style="margin-bottom:16px">
                    <label style="display:block;font-size:.67rem;font-weight:700;color:#64748b;margin-bottom:6px">
                        Subject <span style="color:#f43f5e">*</span>
                    </label>
                    <input
                        class="inp"
                        id="fb-subject"
                        name="subject"
                        placeholder="Brief title (5–100 chars)"
                        minlength="5"
                        maxlength="100">
                    <div id="err-subject" style="display:none;margin-top:6px;font-size:.74rem;color:#ef4444;font-weight:500"></div>
                </div>

                {{-- MESSAGE --}}
                <div style="margin-bottom:16px">
                    <label style="display:block;font-size:.67rem;font-weight:700;color:#64748b;margin-bottom:6px">
                        Message <span style="color:#f43f5e">*</span>
                    </label>
                    <textarea
                        class="inp"
                        id="fb-msg"
                        name="message"
                        rows="5"
                        placeholder="Describe your feedback… (min 10 chars)"
                        minlength="10"

                        style="resize:vertical"></textarea>
                    <div style="font-size:.72rem;color:#475569;margin-top:4px;text-align:right">
                        <span id="fb-len">0</span> characters
                    </div>
                    <div id="err-message" style="display:none;margin-top:6px;font-size:.74rem;color:#ef4444;font-weight:500"></div>
                </div>

                {{-- PRIORITY --}}
                <div style="margin-bottom:16px">
                    <label style="display:block;font-size:.67rem;font-weight:700;color:#64748b;margin-bottom:8px">
                        Priority
                    </label>
                    <div style="display:flex;gap:8px;flex-wrap:wrap">
                        {{-- ✅ Removed onclick= attributes; handled via JS below --}}
                        <button type="button" class="pri-btn sel" data-value="Low">Low</button>
                        <button type="button" class="pri-btn" data-value="Medium">Medium</button>
                        <button type="button" class="pri-btn" data-value="High">High</button>
                        <button type="button" class="pri-btn" data-value="Critical">Critical</button>
                    </div>
                    <div id="err-priority" style="display:none;margin-top:6px;font-size:.74rem;color:#ef4444;font-weight:500"></div>
                </div>

                {{-- CHECKBOX --}}
                <div style="margin-bottom:20px">
                    <label style="display:flex;align-items:center;gap:8px;color:#64748b">
                        <input type="checkbox" id="fb-receive" name="is_receive">
                        Allow team to contact me
                    </label>
                </div>

                {{-- SUCCESS --}}
                <div id="fb-success" style="display:none;background:#dcfce7;color:#166534;padding:10px;border-radius:10px;margin-bottom:14px"></div>

                {{-- BUTTONS --}}
                <div style="display:flex;gap:10px;justify-content:flex-end">
                    {{-- ✅ Removed onclick= attribute; handled via JS below --}}
                    <button type="reset" class="btn btn-ghost" id="fb-clear-btn">Clear</button>
                    <button type="submit" class="btn btn-primary" id="fb-submit-btn">Submit Feedback</button>
                </div>

            </form>
        </div>

        <div style="display:flex;flex-direction:column;gap:14px">

            <div class="card" style="padding:18px">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px">
                    <div style="width:42px;height:42px;border-radius:12px;background:rgba(16,185,129,.12);display:flex;align-items:center;justify-content:center">
                        <i class="ri-thumb-up-line" style="color:#10b981;font-size:1.1rem"></i>
                    </div>
                    <div>
                        <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9">Your Past Feedback</h3>
                        <div style="font-size:.75rem;color:#64748b">
                            {{ $feedbacks->count() }} submissions
                        </div>
                    </div>
                </div>
                <div style="display:flex;flex-direction:column;gap:8px">

                    @forelse($feedbacks as $feedback)

                    @php
                    $statusClass = match($feedback->feedback_status) {
                    'resolved' => 'badge-green',
                    'pending' => 'badge-amber',
                    'feedback' => 'badge-teal',
                    default => 'badge-amber',
                    };

                    $statusIcon = match($feedback->feedback_status) {
                    'resolved' => 'ri-check-line',
                    'pending' => 'ri-time-line',
                    'feedback' => 'ri-eye-line',
                    default => 'ri-information-line',
                    };
                    @endphp

                    <div style="padding:12px;border-radius:10px;border:1px solid rgba(16,185,129,.25);background:rgba(16,185,129,.04)">

                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:4px">

                            <span style="font-size:.85rem;font-weight:600;color:#94a3b8">
                                {{ $feedback->subject }}
                            </span>

                            <span class="badge {{ $statusClass }}">
                                <i class="{{ $statusIcon }}"></i>
                                {{ ucfirst($feedback->feedback_status) }}
                            </span>

                        </div>

                        <div style="font-size:.75rem;color:#64748b">
                            {{ ucfirst($feedback->priority) }} Priority ·
                            {{ $feedback->created_at->format('M d') }}
                        </div>

                    </div>

                    @empty

                    <div style="padding:15px;text-align:center;color:#64748b">
                        No feedback submitted yet
                    </div>

                    @endforelse

                </div>
            </div>

            <div class="card" style="padding:16px;text-align:center">
                <a href="mailto:support@winngoodremind.co.uk" style="font-size:.84rem;color:#a78bfa;font-weight:600;text-decoration:none">
                    <i class="ri-mail-line" style="margin-right:4px"></i>support@winngoodremind.co.uk
                </a>
            </div>
        </div>
    </div>
</section>

<script>
    // ✅ Entire block is wrapped in an IIFE so nothing leaks into global scope
    // ✅ DOMContentLoaded ensures elements exist before we touch them
    (function() {
        'use strict';

        // ── helpers ──────────────────────────────────────────────────────────────

        function clearErrors() {
            ['subject', 'message', 'priority'].forEach(function(f) {
                var el = document.getElementById('err-' + f);
                if (el) {
                    el.style.display = 'none';
                    el.innerHTML = '';
                }
            });
        }

        function resetPriority() {
            document.querySelectorAll('.pri-btn').forEach(function(b) {
                b.classList.remove('sel');
            });
            var first = document.querySelector('.pri-btn');
            if (first) first.classList.add('sel');

            var hidden = document.getElementById('fb-priority');
            if (hidden) hidden.value = 'Low';
        }

        function clearForm() {
            clearErrors();

            var len = document.getElementById('fb-len');
            if (len) len.textContent = '0';

            var success = document.getElementById('fb-success');
            if (success) {
                success.style.display = 'none';
                success.innerHTML = '';
            }

            resetPriority();
        }

        // ── wire up priority buttons ─────────────────────────────────────────────

        document.querySelectorAll('.pri-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.pri-btn').forEach(function(b) {
                    b.classList.remove('sel');
                });
                btn.classList.add('sel');

                var hidden = document.getElementById('fb-priority');
                if (hidden) hidden.value = btn.dataset.value;
            });
        });

        // ── character counter ────────────────────────────────────────────────────

        var msgEl = document.getElementById('fb-msg');
        var lenEl = document.getElementById('fb-len');
        if (msgEl && lenEl) {
            msgEl.addEventListener('input', function() {
                lenEl.textContent = msgEl.value.length;
            });
        }

        // ── hide errors while typing ─────────────────────────────

        // Subject field
        var subjectEl = document.getElementById('fb-subject');
        if (subjectEl) {
            subjectEl.addEventListener('input', function() {
                var err = document.getElementById('err-subject');

                if (err) {
                    err.style.display = 'none';
                    err.innerHTML = '';
                }
            });
        }

        // Message field
        if (msgEl) {
            msgEl.addEventListener('input', function() {

                // existing counter
                lenEl.textContent = msgEl.value.length;

                // hide error
                var err = document.getElementById('err-message');

                if (err) {
                    err.style.display = 'none';
                    err.innerHTML = '';
                }
            });
        }

        // ── clear button ─────────────────────────────────────────────────────────

        var clearBtn = document.getElementById('fb-clear-btn');
        if (clearBtn) {
            clearBtn.addEventListener('click', function() {
                // The `type="reset"` already resets native inputs;
                // clearForm() handles our custom state on top of that.
                clearForm();
            });
        }

        // ── form submit ──────────────────────────────────────────────────────────

        var form = document.getElementById('feedbackForm');
        if (!form) return; // not on this page — stop here safely

        form.addEventListener('submit', async function(event) {
            event.preventDefault();
            clearErrors();

            var subjectEl = document.getElementById('fb-subject');
            var messagEl = document.getElementById('fb-msg');
            var priorityEl = document.getElementById('fb-priority');
            var receiveEl = document.getElementById('fb-receive');
            var submitBtn = document.getElementById('fb-submit-btn');
            var successBox = document.getElementById('fb-success');

            // Guard: if any critical element is missing, bail out cleanly
            if (!subjectEl || !messagEl || !priorityEl || !receiveEl || !submitBtn) {
                console.error('[feedback] One or more form elements not found');
                return;
            }

            var csrfMeta = document.querySelector('meta[name="csrf-token"]');
            var csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

            submitBtn.disabled = true;
            submitBtn.textContent = 'Submitting…';

            var payload = {
                subject: subjectEl.value,
                message: messagEl.value,
                priority: priorityEl.value,
                is_receive: receiveEl.checked ? 1 : 0,
            };

            try {
                var response = await fetch("{{ route('feedback.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json', // ✅ ensures Laravel returns JSON on errors
                    },
                    body: JSON.stringify(payload),
                });

                var data = await response.json();

                if (!response.ok) {
                    // Laravel validation errors come back as { errors: { field: ['msg'] } }
                    if (data.errors) {
                        Object.keys(data.errors).forEach(function(field) {
                            var errBox = document.getElementById('err-' + field);
                            if (errBox) {
                                errBox.style.display = 'block';
                                errBox.textContent = data.errors[field][0];
                            }
                        });
                    }
                    return;
                }
                toast(data.message || 'Feedback submitted successfully','success');
                setTimeout(()=>{
                    location.reload();
                },1500)
                // ── success ──
                if (successBox) {
                    successBox.style.display = 'block';
                    successBox.textContent = data.message || 'Feedback submitted successfully';
                }

                form.reset();
                clearForm();

            } catch (err) {
                console.error('[feedback] Unexpected error:', err);
                alert('Something went wrong. Please try again.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Submit Feedback';
            }
        });

    }()); // end IIFE
</script>

@endsection