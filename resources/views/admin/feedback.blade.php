@extends('admin.layouts.app')
@section('content')

<!-- ═══ FEEDBACK ═══ -->
<section id="page-feedback" class="page active">
    <div
        style="
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        "
    >
        <div>
            <h2 class="font-jakarta" style="font-size: 1.3rem; font-weight: 800">User Feedback</h2>
            <p style="font-size: 1.2re; color: var(--text3); margin-top: 3px">
                Review and manage user submitted feedback
            </p>
        </div>
        <div style="display: flex; gap: 6px">
            <select
                class="inp"
                style="width: auto; min-width: 130px"
                id="fb-type-filter"
                onchange="filterFeedback()"
            >
                <option value="all">All Types</option>
                <option value="bug">Bug Report</option>
                <option value="feature">Feature Request</option>
                <option value="compliment">Compliment</option>
            </select>
            <select
                class="inp"
                style="width: auto; min-width: 130px"
                id="fb-status-filter"
                onchange="filterFeedback()"
            >
                <option value="all">All Status</option>
                <option value="open">Open</option>
                <option value="resolved">Resolved</option>
                <option value="pending">Pending</option>
            </select>
        </div>
    </div>
    <div class="flex flex-wrap gap-3 mb-6">
        <div class="flex items-center gap-2.5 px-4 py-2 bg-white rounded-full shadow-sm border border-gray-100 hover:border-purple-200 transition-colors">
            <i class="ri-feedback-line text-purple-500 text-base"></i>
            <span class="text-sm text-gray-600">Total: <strong class="text-gray-900">128</strong></span>
        </div>
        
        <div class="flex items-center gap-2.5 px-4 py-2 bg-white rounded-full shadow-sm border border-gray-100 hover:border-red-200 transition-colors">
            <i class="ri-bug-line text-red-500 text-base"></i>
            <span class="text-sm text-gray-600">Bugs: <strong class="text-red-600">12</strong></span>
        </div>
        
        <div class="flex items-center gap-2.5 px-4 py-2 bg-white rounded-full shadow-sm border border-gray-100 hover:border-green-200 transition-colors">
            <i class="ri-thumb-up-line text-green-500 text-base"></i>
            <span class="text-sm text-gray-600">Resolved: <strong class="text-green-600">89</strong></span>
        </div>
        
        <div class="flex items-center gap-2.5 px-4 py-2 bg-white rounded-full shadow-sm border border-gray-100 hover:border-amber-200 transition-colors">
            <i class="ri-time-line text-amber-500 text-base"></i>
            <span class="text-sm text-gray-600">Pending: <strong class="text-amber-600">27</strong></span>
        </div>
    </div>
    <div class="card" style="padding: 18px">
        <div style="display: flex; flex-direction: column; gap: 8px" id="feedback-list"></div>
    </div>
</section>

<!-- Reply Mail Modal -->
<div id="replyMailModal" class="modal" style="display: none;">
    <div class="modal-overlay"></div>
    <div class="modal-content" style="max-width: 650px; max-height: 90vh; overflow-y: auto;">
        <div class="modal-header">
            <h3 style="font-size: 1.1rem; font-weight: 700; margin: 0;">Feedback Details</h3>
            <button class="btn btn-ghost btn-sm" onclick="closeReplyModal()">
                <i class="ri-close-line"></i>
            </button>
        </div>
        <div class="modal-body" style="padding: 24px;">
            <!-- User Information Section -->
            <div style="background: var(--bg2); padding: 16px; border-radius: 12px; margin-bottom: 20px;">
                <h4 style="font-size: 0.9rem; font-weight: 700; margin: 0 0 12px 0; color: var(--text2);">
                    <i class="ri-user-line"></i> User Information
                </h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">
                    <div>
                        <div style="font-size: 0.75rem; color: var(--text4); margin-bottom: 3px;">Name</div>
                        <div style="font-size: 0.88rem; font-weight: 600; color: var(--text);" id="display-name">-</div>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; color: var(--text4); margin-bottom: 3px;">Email</div>
                        <div style="font-size: 0.88rem; font-weight: 600; color: var(--text);" id="display-email">-</div>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; color: var(--text4); margin-bottom: 3px;">Phone</div>
                        <div style="font-size: 0.88rem; font-weight: 600; color: var(--text);" id="display-phone">-</div>
                    </div>
                </div>
            </div>

            <!-- Feedback Details Section -->
            <div style="background: var(--bg2); padding: 16px; border-radius: 12px; margin-bottom: 20px;">
                <h4 style="font-size: 0.9rem; font-weight: 700; margin: 0 0 12px 0; color: var(--text2);">
                    <i class="ri-feedback-line"></i> Feedback Details
                </h4>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <div>
                        <div style="font-size: 0.75rem; color: var(--text4); margin-bottom: 3px;">Subject</div>
                        <div style="font-size: 0.88rem; font-weight: 600; color: var(--text);" id="display-subject">-</div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <div>
                            <div style="font-size: 0.75rem; color: var(--text4); margin-bottom: 3px;">Type</div>
                            <div id="display-type-badge"></div>
                        </div>
                        <div>
                            <div style="font-size: 0.75rem; color: var(--text4); margin-bottom: 3px;">Category</div>
                            <div style="font-size: 0.88rem; font-weight: 600; color: var(--text);" id="display-category">-</div>
                        </div>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; color: var(--text4); margin-bottom: 3px;">Message</div>
                        <div style="font-size: 0.88rem; color: var(--text3); line-height: 1.6; padding: 12px; background: var(--bg); border-radius: 8px;" id="display-message">-</div>
                    </div>
                </div>
            </div>

            <!-- Admin Reply Section -->
            <div style="background: rgba(124, 58, 237, 0.06); padding: 16px; border-radius: 12px; border: 1px solid rgba(124, 58, 237, 0.15);">
                <h4 style="font-size: 0.9rem; font-weight: 700; margin: 0 0 12px 0; color: var(--text2);">
                    <i class="ri-admin-line"></i> Admin Reply
                </h4>
                <form id="replyMailForm">
                    <textarea 
                        class="inp" 
                        id="reply-message" 
                        rows="6" 
                        placeholder="Type your reply message here..." 
                        style="resize: vertical; width: 100%; margin-bottom: 16px;"
                        required
                    ></textarea>
                    
                    <div style="display: flex; gap: 10px; justify-content: flex-end;">
                        <button type="button" class="btn btn-ghost" onclick="closeReplyModal()">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ri-send-plane-line"></i> Send Reply
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(4px);
}

.modal-content {
    position: relative;
    background: var(--bg);
    border-radius: 16px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    width: 90%;
    z-index: 1;
}

.modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 24px;
    border-bottom: 1px solid var(--border);
}
</style>

@endsection