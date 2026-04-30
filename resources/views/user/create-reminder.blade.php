@extends('user.layouts.app')
@section('content')

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
            <form id="rem-form" onsubmit="submitReminder(event)">
                <div style="margin-bottom:18px">
                    <label style="display:block;font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:7px">Title <span style="color:#f43f5e">*</span></label>
                    <input class="inp" id="r-title" placeholder="e.g. Car Insurance Renewal" maxlength="100">
                    <div style="font-size:.72rem;color:#475569;margin-top:4px">3–100 characters</div>
                </div>
                
                <div class="g2" style="margin-bottom:18px">
                    <div>
                        <label style="display:block;font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:7px">Category <span style="color:#f43f5e">*</span></label>
                        <select class="inp" id="r-cat" onchange="updateSubs()">
                            <option value="">Select category…</option>
                        </select>
                    </div>
                    <div>
                        <label style="display:block;font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:7px">Subcategory <span style="color:#f43f5e">*</span></label>
                        <select class="inp" id="r-sub" disabled>
                            <option value="">Select category first…</option>
                        </select>
                    </div>
                </div>
                
                <div class="g2" style="margin-bottom:18px">
                    <div>
                        <label style="display:block;font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:7px">Date <span style="color:#f43f5e">*</span></label>
                        <input class="inp" type="date" id="r-date">
                    </div>
                    <div>
                        <label style="display:block;font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:7px">Time <span style="color:#f43f5e">*</span></label>
                        <input class="inp" type="time" id="r-time" value="09:00">
                    </div>
                </div>
                
                <div style="margin-bottom:18px">
                    <label style="display:block;font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:7px">Description <span style="color:#64748b;font-weight:400;text-transform:none">(Optional · max 200 chars)</span></label>
                    <textarea class="inp" id="r-desc" rows="3" maxlength="200" placeholder="Brief notes…" oninput="document.getElementById('desc-len').textContent=this.value.length" style="resize:vertical"></textarea>
                    <div style="font-size:.72rem;color:#475569;margin-top:4px"><span id="desc-len">0</span>/200</div>
                </div>
                
                <div id="opt-fields" style="display:none">
                    <div class="g2" style="margin-bottom:18px">
                        <div>
                            <label style="display:block;font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:7px">Provider</label>
                            <input class="inp" id="r-provider" placeholder="e.g. AA Insurance" maxlength="50">
                        </div>
                        <div>
                            <label style="display:block;font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;margin-bottom:7px">Cost (£)</label>
                            <input class="inp" type="number" id="r-cost" placeholder="0.00" min="0" step="0.01">
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
                    </div>
                </div>
                
                <div class="card" style="padding:18px;margin-bottom:18px;background:rgba(245,158,11,.05);border:1px solid rgba(245,158,11,.2)">
                    <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:10px">
                        <i class="ri-lightbulb-line" style="color:#f59e0b;margin-right:4px"></i> Quick Tips
                    </h3>
                    <div style="display:flex;flex-direction:column;gap:8px">
                        <div style="display:flex;gap:8px;font-size:.83rem;color:#64748b">
                            <i class="ri-checkbox-circle-line" style="color:#10b981;margin-top:2px;flex-shrink:0"></i>
                            Use clear, descriptive titles to identify reminders later
                        </div>
                        <div style="display:flex;gap:8px;font-size:.83rem;color:#64748b">
                            <i class="ri-checkbox-circle-line" style="color:#10b981;margin-top:2px;flex-shrink:0"></i>
                            Set reminders at least 30 days in advance for best coverage
                        </div>
                        <div style="display:flex;gap:8px;font-size:.83rem;color:#64748b">
                            <i class="ri-checkbox-circle-line" style="color:#10b981;margin-top:2px;flex-shrink:0"></i>
                            Add provider and cost details to track expenses over time
                        </div>
                    </div>
                </div>
                
                <div style="display:flex;gap:10px;justify-content:flex-end;padding-top:16px;border-top:1px solid rgba(255,255,255,.06)">
                    <button type="button" class="btn btn-ghost" onclick="closeReminderModal()">
                        <i class="ri-close-line"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" id="create-btn">
                        <i class="ri-check-line"></i> <span id="create-btn-txt">Create Reminder</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
