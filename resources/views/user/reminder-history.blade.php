@extends('user.layouts.app')
@section('content')

<section id="page-reminder-history" class="">
    <div style="margin-bottom:16px">
        <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800;color:#f1f5f9">Reminder History</h2>
        <p id="history-count-label" style="font-size:.82rem;color:#64748b;margin-top:3px">View all your reminders organized by time periods</p>
    </div>

    <!-- TABS -->
    <div class="tabs-container" style="margin-bottom:20px">
        <div class="tabs-header" style="display:flex;gap:6px;border-bottom:1px solid rgba(255,255,255,.06);margin-bottom:20px;overflow-x:auto;scrollbar-width:none">
            <button class="tab-btn active" onclick="switchHistoryTab('today')" data-tab="today">
                <i class="ri-calendar-today-line"></i>
                <span>Today</span>
                <span class="badge-count" style="background:#f59e0b;color:#fff !important;font-size:.65rem;padding:2px 6px;border-radius:10px;font-weight:700;margin-left:4px">3</span>
            </button>
            <button class="tab-btn" onclick="switchHistoryTab('upcoming')" data-tab="upcoming">
                <i class="ri-calendar-event-line"></i>
                <span>Upcoming</span>
                <span class="badge-count" style="background:#7c3aed;color:#fff !important;font-size:.65rem;padding:2px 6px;border-radius:10px;font-weight:700;margin-left:4px">7</span>
            </button>
            <button class="tab-btn" onclick="switchHistoryTab('future')" data-tab="future">
                <i class="ri-calendar-line"></i>
                <span>Future</span>
                <span class="badge-count" style="background:#06b6d4;color:#fff !important;font-size:.65rem;padding:2px 6px;border-radius:10px;font-weight:700;margin-left:4px">12</span>
            </button>
            <button class="tab-btn" onclick="switchHistoryTab('completed')" data-tab="completed">
                <i class="ri-check-double-line"></i>
                <span>Completed</span>
                <span class="badge-count" style="background:#10b981;color:#fff !important;font-size:.65rem;padding:2px 6px;border-radius:10px;font-weight:700;margin-left:4px">24</span>
            </button>
            <button class="tab-btn" onclick="switchHistoryTab('expired')" data-tab="expired">
                <i class="ri-error-warning-line"></i>
                <span>Expired</span>
                <span class="badge-count" style="background:#ef4444;color:#fff !important;font-size:.65rem;padding:2px 6px;border-radius:10px;font-weight:700;margin-left:4px">5</span>
            </button>
        </div>

        <!-- Filters (common for all tabs) -->
        <div style="display:flex;flex-wrap:wrap;gap:10px;margin-bottom:16px">
            <div class="search-box" style="flex:1;min-width:200px">
                <i class="ri-search-line" style="color:#64748b;font-size:.9rem"></i>
                <input id="history-search" placeholder="Search reminders…" oninput="filterCurrentTab()" style="font-size:.85rem;color:inherit">
            </div>
            <select class="inp" style="width:auto;min-width:155px" id="history-cat" onchange="filterCurrentTab()">
                <option value="all">All Categories</option>
            </select>
            <select class="inp" style="width:auto;min-width:160px" id="history-sort" onchange="filterCurrentTab()">
                <option value="date-asc">Date ↑</option>
                <option value="date-desc">Date ↓</option>
                <option value="title-asc">Title A–Z</option>
                <option value="title-desc">Title Z–A</option>
                <option value="amount-desc">Amount High–Low</option>
            </select>
            <button class="btn btn-ghost btn-sm" onclick="resetHistoryFilters()" title="Reset filters">
                <i class="ri-refresh-line"></i>
            </button>
        </div>

        <!-- View Toggle -->
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
            <div style="display:flex;gap:6px">
                <button class="view-btn active" id="vh-list" onclick="setHistoryView('list')">
                    <i class="ri-list-check"></i> List
                </button>
                <button class="view-btn" id="vh-grid" onclick="setHistoryView('grid')">
                    <i class="ri-grid-line"></i> Grid
                </button>
            </div>
            <div style="display:flex;align-items:center;gap:10px">
                <span style="font-size:.75rem;color:#64748b;font-weight:600">
                    <span id="history-display-count">0</span> reminders
                </span>
                <button class="btn btn-ghost btn-sm" onclick="exportHistory()">
                    <i class="ri-download-line"></i> Export
                </button>
            </div>
        </div>

        <!-- TAB 1: TODAY'S REMINDERS -->
        <div class="tab-content active" id="tab-today">
            <div class="card" style="padding:16px;margin-bottom:16px;background:rgba(245,158,11,.08);border:1px solid rgba(245,158,11,.2)">
                <div style="display:flex;align-items:center;gap:12px">
                    <div class="cat-ico" style="width:40px;height:40px;background:rgba(245,158,11,.15)">
                        <i class="ri-alarm-warning-line" style="color:#f59e0b;font-size:1rem"></i>
                    </div>
                    <div>
                        <h3 style="font-size:.9rem;font-weight:700;color:#f1f5f9;margin-bottom:2px">Today's Reminders</h3>
                        <p style="font-size:.75rem;color:#94a3b8">These reminders are due today - <strong id="today-date"></strong></p>
                    </div>
                </div>
            </div>
            <div id="today-list" style="display:flex;flex-direction:column;gap:8px"></div>
            <div id="today-grid" style="display:none;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px"></div>
            <div id="today-empty" style="display:none;text-align:center;padding:40px 0">
                <div style="font-size:2.5rem;color:rgba(255,255,255,.1);margin-bottom:8px">
                    <i class="ri-check-line"></i>
                </div>
                <div style="font-size:.9rem;font-weight:600;color:#94a3b8;margin-bottom:4px">No reminders due today</div>
                <div style="font-size:.78rem;color:#64748b">You're all clear for today! 🎉</div>
            </div>
        </div>

        <!-- TAB 2: UPCOMING REMINDERS (Next 7 Days) -->
        <div class="tab-content" id="tab-upcoming" style="display:none">
            <div class="card" style="padding:16px;margin-bottom:16px;background:rgba(124,58,237,.08);border:1px solid rgba(124,58,237,.2)">
                <div style="display:flex;align-items:center;gap:12px">
                    <div class="cat-ico" style="width:40px;height:40px;background:rgba(124,58,237,.15)">
                        <i class="ri-calendar-event-line" style="color:#a78bfa;font-size:1rem"></i>
                    </div>
                    <div>
                        <h3 style="font-size:.9rem;font-weight:700;color:#f1f5f9;margin-bottom:2px">Upcoming Reminders</h3>
                        <p style="font-size:.75rem;color:#94a3b8">Due within the next 7 days</p>
                    </div>
                </div>
            </div>
            <div id="upcoming-list" style="display:flex;flex-direction:column;gap:8px"></div>
            <div id="upcoming-grid" style="display:none;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px"></div>
            <div id="upcoming-empty" style="display:none;text-align:center;padding:40px 0">
                <div style="font-size:2.5rem;color:rgba(255,255,255,.1);margin-bottom:8px">
                    <i class="ri-calendar-check-line"></i>
                </div>
                <div style="font-size:.9rem;font-weight:600;color:#94a3b8;margin-bottom:4px">No upcoming reminders</div>
                <div style="font-size:.78rem;color:#64748b">Nothing scheduled for the next 7 days</div>
            </div>
        </div>

        <!-- TAB 3: FUTURE REMINDERS (8-30 Days) -->
        <div class="tab-content" id="tab-future" style="display:none">
            <div class="card" style="padding:16px;margin-bottom:16px;background:rgba(6,182,212,.08);border:1px solid rgba(6,182,212,.2)">
                <div style="display:flex;align-items:center;gap:12px">
                    <div class="cat-ico" style="width:40px;height:40px;background:rgba(6,182,212,.15)">
                        <i class="ri-calendar-2-line" style="color:#06b6d4;font-size:1rem"></i>
                    </div>
                    <div>
                        <h3 style="font-size:.9rem;font-weight:700;color:#f1f5f9;margin-bottom:2px">Future Reminders</h3>
                        <p style="font-size:.75rem;color:#94a3b8">Due in 8-30 days from now</p>
                    </div>
                </div>
            </div>
            <div id="future-list" style="display:flex;flex-direction:column;gap:8px"></div>
            <div id="future-grid" style="display:none;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px"></div>
            <div id="future-empty" style="display:none;text-align:center;padding:40px 0">
                <div style="font-size:2.5rem;color:rgba(255,255,255,.1);margin-bottom:8px">
                    <i class="ri-calendar-line"></i>
                </div>
                <div style="font-size:.9rem;font-weight:600;color:#94a3b8;margin-bottom:4px">No future reminders</div>
                <div style="font-size:.78rem;color:#64748b">Nothing scheduled beyond 7 days</div>
            </div>
        </div>

        <!-- TAB 4: COMPLETED REMINDERS -->
        <div class="tab-content" id="tab-completed" style="display:none">
            <div class="card" style="padding:16px;margin-bottom:16px;background:rgba(16,185,129,.08);border:1px solid rgba(16,185,129,.2)">
                <div style="display:flex;align-items:center;justify-content:space-between">
                    <div style="display:flex;align-items:center;gap:12px">
                        <div class="cat-ico" style="width:40px;height:40px;background:rgba(16,185,129,.15)">
                            <i class="ri-check-double-line" style="color:#10b981;font-size:1rem"></i>
                        </div>
                        <div>
                            <h3 style="font-size:.9rem;font-weight:700;color:#f1f5f9;margin-bottom:2px">Completed Reminders</h3>
                            <p style="font-size:.75rem;color:#94a3b8">Successfully completed tasks</p>
                        </div>
                    </div>
                    <button class="btn btn-ghost btn-sm" onclick="archiveAllCompleted()">
                        <i class="ri-archive-line"></i> Archive All
                    </button>
                </div>
            </div>
            <div id="completed-list" style="display:flex;flex-direction:column;gap:8px"></div>
            <div id="completed-grid" style="display:none;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px"></div>
            <div id="completed-empty" style="display:none;text-align:center;padding:40px 0">
                <div style="font-size:2.5rem;color:rgba(255,255,255,.1);margin-bottom:8px">
                    <i class="ri-inbox-line"></i>
                </div>
                <div style="font-size:.9rem;font-weight:600;color:#94a3b8;margin-bottom:4px">No completed reminders</div>
                <div style="font-size:.78rem;color:#64748b">Completed tasks will appear here</div>
            </div>
        </div>

        <!-- TAB 5: EXPIRED REMINDERS -->
        <div class="tab-content" id="tab-expired" style="display:none">
            <div class="card" style="padding:16px;margin-bottom:16px;background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.2)">
                <div style="display:flex;align-items:center;justify-content:space-between">
                    <div style="display:flex;align-items:center;gap:12px">
                        <div class="cat-ico" style="width:40px;height:40px;background:rgba(239,68,68,.15)">
                            <i class="ri-error-warning-line" style="color:#ef4444;font-size:1rem"></i>
                        </div>
                        <div>
                            <h3 style="font-size:.9rem;font-weight:700;color:#f1f5f9;margin-bottom:2px">Expired Reminders</h3>
                            <p style="font-size:.75rem;color:#94a3b8">Overdue reminders that need attention</p>
                        </div>
                    </div>
                    <button class="btn btn-ghost btn-sm" onclick="snoozeAllExpired()">
                        <i class="ri-time-line"></i> Snooze All
                    </button>
                </div>
            </div>
            <div id="expired-list" style="display:flex;flex-direction:column;gap:8px"></div>
            <div id="expired-grid" style="display:none;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px"></div>
            <div id="expired-empty" style="display:none;text-align:center;padding:40px 0">
                <div style="font-size:2.5rem;color:rgba(255,255,255,.1);margin-bottom:8px">
                    <i class="ri-check-line"></i>
                </div>
                <div style="font-size:.9rem;font-weight:600;color:#94a3b8;margin-bottom:4px">No expired reminders</div>
                <div style="font-size:.78rem;color:#64748b">Great job staying on top of things! 🎯</div>
            </div>
        </div>

        <!-- TAB 6: ARCHIVED REMINDERS -->
        <div class="tab-content" id="tab-archived" style="display:none">
            <div class="card" style="padding:16px;margin-bottom:16px;background:rgba(100,116,139,.08);border:1px solid rgba(100,116,139,.2)">
                <div style="display:flex;align-items:center;justify-content:space-between">
                    <div style="display:flex;align-items:center;gap:12px">
                        <div class="cat-ico" style="width:40px;height:40px;background:rgba(100,116,139,.15)">
                            <i class="ri-archive-line" style="color:#94a3b8;font-size:1rem"></i>
                        </div>
                        <div>
                            <h3 style="font-size:.9rem;font-weight:700;color:#f1f5f9;margin-bottom:2px">Archived Reminders</h3>
                            <p style="font-size:.75rem;color:#94a3b8">Old reminders moved to archive</p>
                        </div>
                    </div>
                    <button class="btn btn-ghost btn-sm" onclick="deleteAllArchived()">
                        <i class="ri-delete-bin-line"></i> Delete All
                    </button>
                </div>
            </div>
            <div id="archived-list" style="display:flex;flex-direction:column;gap:8px"></div>
            <div id="archived-grid" style="display:none;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px"></div>
            <div id="archived-empty" style="display:none;text-align:center;padding:40px 0">
                <div style="font-size:2.5rem;color:rgba(255,255,255,.1);margin-bottom:8px">
                    <i class="ri-archive-line"></i>
                </div>
                <div style="font-size:.9rem;font-weight:600;color:#94a3b8;margin-bottom:4px">No archived reminders</div>
                <div style="font-size:.78rem;color:#64748b">Archived items will appear here</div>
            </div>
        </div>
    </div>
</section>

<style>
/* Tab Styles */
.tabs-header {
    position: relative;
}
.tabs-header::-webkit-scrollbar {
    display: none;
}
.tab-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    border: none;
    background: transparent;
    color: #64748b;
    font-size: .82rem;
    font-weight: 600;
    border-bottom: 2px solid transparent;
    cursor: pointer;
    transition: all .3s;
    position: relative;
    white-space: nowrap;
    flex-shrink: 0;
}
.tab-btn:hover {
    color: #94a3b8;
    background: rgba(255,255,255,.02);
}
.tab-btn.active {
    color: #f1f5f9;
    border-bottom-color: #7c3aed;
}
.tab-btn i {
    font-size: 1rem;
}
.tab-content {
    animation: fadeIn 0.3s ease-in-out;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Days Until Badge */
.days-until {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 10px;
    border-radius: 100px;
    font-size: .7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .03em;
}
.days-until.today {
    background: rgba(245,158,11,.15);
    color: #f59e0b;
    border: 1px solid rgba(245,158,11,.3);
}
.days-until.soon {
    background: rgba(124,58,237,.15);
    color: #a78bfa;
    border: 1px solid rgba(124,58,237,.3);
}
.days-until.future {
    background: rgba(6,182,212,.15);
    color: #06b6d4;
    border: 1px solid rgba(6,182,212,.3);
}
.days-until.overdue {
    background: rgba(239,68,68,.15);
    color: #ef4444;
    border: 1px solid rgba(239,68,68,.3);
    animation: pulse 2s infinite;
}
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}
</style>

<script>
// Sample Data
const allReminders = [
    // TODAY
    { id: 1, title: 'Car Insurance Payment', category: 'Insurance', date: '2026-04-16', amount: '£485', status: 'active', priority: 'high', notes: 'Due today - don\'t forget!' },
    { id: 2, title: 'Netflix Subscription', category: 'Entertainment', date: '2026-04-16', amount: '£15.99', status: 'active', priority: 'medium', notes: '' },
    { id: 3, title: 'Gym Membership Payment', category: 'Health', date: '2026-04-16', amount: '£45', status: 'active', priority: 'low', notes: '' },
    
    // UPCOMING (1-7 days)
    { id: 4, title: 'Council Tax', category: 'Bills', date: '2026-04-18', amount: '£145', status: 'active', priority: 'high', notes: '' },
    { id: 5, title: 'Amazon Prime', category: 'Entertainment', date: '2026-04-19', amount: '£8.99', status: 'active', priority: 'low', notes: '' },
    { id: 6, title: 'Electricity Bill', category: 'Utilities', date: '2026-04-20', amount: '£82', status: 'active', priority: 'high', notes: '' },
    { id: 7, title: 'Spotify Premium', category: 'Entertainment', date: '2026-04-21', amount: '£9.99', status: 'active', priority: 'low', notes: '' },
    { id: 8, title: 'Water Bill', category: 'Utilities', date: '2026-04-22', amount: '£42', status: 'active', priority: 'medium', notes: '' },
    { id: 9, title: 'Phone Contract', category: 'Utilities', date: '2026-04-22', amount: '£32', status: 'active', priority: 'medium', notes: '' },
    { id: 10, title: 'MOT Due', category: 'Vehicle', date: '2026-04-23', amount: '£54', status: 'active', priority: 'high', notes: 'Book appointment ASAP' },
    
    // FUTURE (8-30 days)
    { id: 11, title: 'Home Insurance', category: 'Insurance', date: '2026-04-28', amount: '£285', status: 'active', priority: 'high', notes: '' },
    { id: 12, title: 'TV License', category: 'Bills', date: '2026-04-30', amount: '£159', status: 'active', priority: 'high', notes: '' },
    { id: 13, title: 'Broadband Bill', category: 'Utilities', date: '2026-05-02', amount: '£35', status: 'active', priority: 'medium', notes: '' },
    { id: 14, title: 'Disney+ Subscription', category: 'Entertainment', date: '2026-05-05', amount: '£7.99', status: 'active', priority: 'low', notes: '' },
    { id: 15, title: 'Gas Bill', category: 'Utilities', date: '2026-05-08', amount: '£95', status: 'active', priority: 'high', notes: '' },
    { id: 16, title: 'Pet Insurance', category: 'Insurance', date: '2026-05-10', amount: '£28', status: 'active', priority: 'medium', notes: '' },
    { id: 17, title: 'Dentist Appointment', category: 'Health', date: '2026-05-12', amount: '£65', status: 'active', priority: 'high', notes: 'Check-up and cleaning' },
    { id: 18, title: 'Magazine Subscription', category: 'Entertainment', date: '2026-05-14', amount: '£12', status: 'active', priority: 'low', notes: '' },
    { id: 19, title: 'Storage Unit Rent', category: 'Bills', date: '2026-05-15', amount: '£45', status: 'active', priority: 'medium', notes: '' },
    { id: 20, title: 'VPN Subscription', category: 'Software', date: '2026-05-15', amount: '£5.99', status: 'active', priority: 'low', notes: '' },
    { id: 21, title: 'Life Insurance', category: 'Insurance', date: '2026-05-16', amount: '£42', status: 'active', priority: 'high', notes: '' },
    { id: 22, title: 'Mum\'s Birthday', category: 'Personal', date: '2026-05-18', amount: '£50', status: 'active', priority: 'high', notes: 'Buy present and card' },
    
    // COMPLETED
    { id: 23, title: 'Rent Payment', category: 'Bills', date: '2026-04-01', completedDate: '2026-03-31', amount: '£950', status: 'completed', priority: 'high', notes: 'Paid early' },
    { id: 24, title: 'Credit Card Bill', category: 'Finance', date: '2026-04-05', completedDate: '2026-04-04', amount: '£324', status: 'completed', priority: 'high', notes: '' },
    { id: 25, title: 'YouTube Premium', category: 'Entertainment', date: '2026-04-08', completedDate: '2026-04-08', amount: '£11.99', status: 'completed', priority: 'low', notes: '' },
    { id: 26, title: 'Car Tax', category: 'Vehicle', date: '2026-04-10', completedDate: '2026-04-09', amount: '£165', status: 'completed', priority: 'high', notes: '' },
    
    // EXPIRED
    { id: 27, title: 'Parking Fine', category: 'Bills', date: '2026-04-10', amount: '£60', status: 'expired', priority: 'high', notes: 'Overdue by 6 days' },
    { id: 28, title: 'Library Books Return', category: 'Personal', date: '2026-04-12', amount: '£0', status: 'expired', priority: 'low', notes: 'Late fees apply' },
    { id: 29, title: 'Dry Cleaning Pickup', category: 'Personal', date: '2026-04-14', amount: '£18', status: 'expired', priority: 'low', notes: '' },
    { id: 30, title: 'Passport Renewal Application', category: 'Documents', date: '2026-04-15', amount: '£82.50', status: 'expired', priority: 'high', notes: 'Urgent!' },
    { id: 31, title: 'Prescription Refill', category: 'Health', date: '2026-04-15', amount: '£9.65', status: 'expired', priority: 'high', notes: 'Call pharmacy' },
    
    // ARCHIVED
    { id: 32, title: 'Old Gym Contract', category: 'Health', date: '2026-02-15', completedDate: '2026-02-15', amount: '£45', status: 'archived', priority: 'low', notes: 'Cancelled membership' },
    { id: 33, title: 'Previous Car Insurance', category: 'Insurance', date: '2026-01-20', completedDate: '2026-01-18', amount: '£605', status: 'archived', priority: 'high', notes: 'Switched provider' },
];

let currentTab = 'today';
let currentView = 'list';
let filteredData = [];

// Populate categories
function populateCategories() {
    const cats = [...new Set(allReminders.map(item => item.category))];
    const select = document.getElementById('history-cat');
    select.innerHTML = '<option value="all">All Categories</option>';
    cats.sort().forEach(cat => {
        const opt = document.createElement('option');
        opt.value = cat.toLowerCase();
        opt.textContent = cat;
        select.appendChild(opt);
    });
}

// Get today's date
function getTodayDate() {
    return new Date().toISOString().split('T')[0];
}

// Get days difference
function getDaysDiff(dateStr) {
    const today = new Date(getTodayDate());
    const targetDate = new Date(dateStr);
    const diffTime = targetDate - today;
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    return diffDays;
}

// Get reminders by category
function getRemindersByCategory(category) {
    const today = getTodayDate();
    
    switch(category) {
        case 'today':
            return allReminders.filter(r => r.status === 'active' && r.date === today);
        case 'upcoming':
            return allReminders.filter(r => {
                if (r.status !== 'active') return false;
                const days = getDaysDiff(r.date);
                return days >= 1 && days <= 7;
            });
        case 'future':
            return allReminders.filter(r => {
                if (r.status !== 'active') return false;
                const days = getDaysDiff(r.date);
                return days >= 8 && days <= 30;
            });
        case 'completed':
            return allReminders.filter(r => r.status === 'completed');
        case 'expired':
            return allReminders.filter(r => r.status === 'expired');
        case 'archived':
            return allReminders.filter(r => r.status === 'archived');
        default:
            return [];
    }
}

// Switch Tab
function switchHistoryTab(tab) {
    currentTab = tab;
    
    // Update tab buttons
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    document.querySelector(`[data-tab="${tab}"]`).classList.add('active');
    
    // Update tab content
    document.querySelectorAll('.tab-content').forEach(content => {
        content.style.display = 'none';
        content.classList.remove('active');
    });
    document.getElementById(`tab-${tab}`).style.display = 'block';
    document.getElementById(`tab-${tab}`).classList.add('active');
    
    // Load data for tab
    filterCurrentTab();
}

// Filter Current Tab
function filterCurrentTab() {
    const searchVal = document.getElementById('history-search').value.toLowerCase();
    const catVal = document.getElementById('history-cat').value;
    const sortVal = document.getElementById('history-sort').value;
    
    // Get base data for current tab
    let data = getRemindersByCategory(currentTab);
    
    // Filter by search
    if (searchVal) {
        data = data.filter(item => 
            item.title.toLowerCase().includes(searchVal) ||
            item.category.toLowerCase().includes(searchVal) ||
            (item.notes && item.notes.toLowerCase().includes(searchVal))
        );
    }
    
    // Filter by category
    if (catVal !== 'all') {
        data = data.filter(item => item.category.toLowerCase() === catVal);
    }
    
    // Sort
    data.sort((a, b) => {
        switch(sortVal) {
            case 'date-asc': return new Date(a.date) - new Date(b.date);
            case 'date-desc': return new Date(b.date) - new Date(a.date);
            case 'title-asc': return a.title.localeCompare(b.title);
            case 'title-desc': return b.title.localeCompare(a.title);
            case 'amount-desc': 
                const aAmount = parseFloat(a.amount.replace(/[£,]/g, ''));
                const bAmount = parseFloat(b.amount.replace(/[£,]/g, ''));
                return bAmount - aAmount;
            default: return 0;
        }
    });
    
    filteredData = data;
    
    // Update count
    document.getElementById('history-display-count').textContent = data.length;
    
    // Render based on current view
    renderCurrentView();
}

// Render Current View
function renderCurrentView() {
    if (currentView === 'list') {
        renderListView(filteredData, currentTab);
    } else {
        renderGridView(filteredData, currentTab);
    }
}

// Render List View
function renderListView(data, tab) {
    const listEl = document.getElementById(`${tab}-list`);
    const gridEl = document.getElementById(`${tab}-grid`);
    const emptyEl = document.getElementById(`${tab}-empty`);
    
    listEl.style.display = 'flex';
    gridEl.style.display = 'none';
    
    if (data.length === 0) {
        listEl.style.display = 'none';
        emptyEl.style.display = 'block';
        return;
    }
    
    emptyEl.style.display = 'none';
    listEl.innerHTML = '';
    
    data.forEach(item => {
        const days = getDaysDiff(item.date);
        let daysText = '';
        let daysClass = '';
        
        if (item.status === 'active') {
            if (days === 0) {
                daysText = '<span class="days-until today"><i class="ri-alarm-warning-line"></i> DUE TODAY</span>';
            } else if (days < 0) {
                daysText = `<span class="days-until overdue"><i class="ri-error-warning-line"></i> ${Math.abs(days)} DAYS OVERDUE</span>`;
            } else if (days === 1) {
                daysText = '<span class="days-until soon"><i class="ri-calendar-event-line"></i> TOMORROW</span>';
            } else if (days <= 7) {
                daysText = `<span class="days-until soon"><i class="ri-calendar-event-line"></i> IN ${days} DAYS</span>`;
            } else {
                daysText = `<span class="days-until future"><i class="ri-calendar-line"></i> IN ${days} DAYS</span>`;
            }
        }
        
        const priorityColors = {
            high: { bg: 'rgba(239,68,68,.08)', border: 'rgba(239,68,68,.2)', icon: 'ri-flag-fill', color: '#ef4444' },
            medium: { bg: 'rgba(245,158,11,.08)', border: 'rgba(245,158,11,.2)', icon: 'ri-flag-line', color: '#f59e0b' },
            low: { bg: 'rgba(100,116,139,.08)', border: 'rgba(100,116,139,.2)', icon: 'ri-flag-line', color: '#64748b' },
        };
        const pStyle = priorityColors[item.priority];
        
        const html = `
            <div class="card" style="padding:14px;${item.status === 'expired' ? 'border-left:3px solid #ef4444;' : ''}">
                <div style="display:flex;align-items:flex-start;gap:12px">
                    <div class="cat-ico" style="width:40px;height:40px;background:${pStyle.bg}">
                        <i class="${pStyle.icon}" style="color:${pStyle.color};font-size:1rem"></i>
                    </div>
                    <div style="flex:1">
                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px;flex-wrap:wrap">
                            <div style="font-size:.92rem;font-weight:700;color:#f1f5f9">${item.title}</div>
                            <div class="badge" style="background:rgba(124,58,237,.12);color:#a78bfa;font-size:.68rem;padding:2px 8px">${item.category}</div>
                            ${daysText}
                        </div>
                        <div style="display:flex;flex-wrap:wrap;gap:12px;font-size:.75rem;color:#64748b;margin-bottom:4px">
                            <span><i class="ri-calendar-line"></i> ${formatDate(item.date)}</span>
                            ${item.completedDate ? `<span style="color:#10b981"><i class="ri-check-line"></i> Completed: ${formatDate(item.completedDate)}</span>` : ''}
                            <span><i class="ri-money-pound-circle-line"></i> ${item.amount}</span>
                        </div>
                        ${item.notes ? `<div style="font-size:.78rem;color:#94a3b8;font-style:italic"><i class="ri-sticky-note-line"></i> ${item.notes}</div>` : ''}
                    </div>
                    <div style="display:flex;gap:4px;flex-shrink:0">
                        ${item.status === 'active' ? `
                            <button class="btn btn-ghost btn-xs" onclick="completeReminder(${item.id})" title="Mark as complete">
                                <i class="ri-check-line"></i>
                            </button>
                            <button class="btn btn-ghost btn-xs" onclick="snoozeReminder(${item.id})" title="Snooze">
                                <i class="ri-time-line"></i>
                            </button>
                        ` : ''}
                        ${item.status === 'expired' ? `
                            <button class="btn btn-ghost btn-xs" onclick="completeReminder(${item.id})" title="Mark as complete">
                                <i class="ri-check-line"></i>
                            </button>
                            <button class="btn btn-ghost btn-xs" onclick="snoozeReminder(${item.id})" title="Snooze">
                                <i class="ri-time-line"></i>
                            </button>
                        ` : ''}
                        ${item.status === 'completed' || item.status === 'archived' ? `
                            <button class="btn btn-ghost btn-xs" onclick="restoreReminder(${item.id})" title="Restore">
                                <i class="ri-restart-line"></i>
                            </button>
                        ` : ''}
                        <button class="btn btn-ghost btn-xs" onclick="viewReminderDetails(${item.id})" title="View details">
                            <i class="ri-eye-line"></i>
                        </button>
                        <button class="btn btn-ghost btn-xs" onclick="deleteReminder(${item.id})" title="Delete">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        listEl.innerHTML += html;
    });
}

// Render Grid View
function renderGridView(data, tab) {
    const listEl = document.getElementById(`${tab}-list`);
    const gridEl = document.getElementById(`${tab}-grid`);
    const emptyEl = document.getElementById(`${tab}-empty`);
    
    listEl.style.display = 'none';
    gridEl.style.display = 'grid';
    
    if (data.length === 0) {
        gridEl.style.display = 'none';
        emptyEl.style.display = 'block';
        return;
    }
    
    emptyEl.style.display = 'none';
    gridEl.innerHTML = '';
    
    data.forEach(item => {
        const days = getDaysDiff(item.date);
        let daysText = '';
        
        if (item.status === 'active') {
            if (days === 0) {
                daysText = '<div class="days-until today" style="margin-bottom:8px"><i class="ri-alarm-warning-line"></i> DUE TODAY</div>';
            } else if (days < 0) {
                daysText = `<div class="days-until overdue" style="margin-bottom:8px"><i class="ri-error-warning-line"></i> ${Math.abs(days)} DAYS OVERDUE</div>`;
            } else if (days === 1) {
                daysText = '<div class="days-until soon" style="margin-bottom:8px"><i class="ri-calendar-event-line"></i> TOMORROW</div>';
            } else if (days <= 7) {
                daysText = `<div class="days-until soon" style="margin-bottom:8px"><i class="ri-calendar-event-line"></i> IN ${days} DAYS</div>`;
            } else {
                daysText = `<div class="days-until future" style="margin-bottom:8px"><i class="ri-calendar-line"></i> IN ${days} DAYS</div>`;
            }
        }
        
        const priorityColors = {
            high: { bg: 'rgba(239,68,68,.08)', border: 'rgba(239,68,68,.2)', icon: 'ri-flag-fill', color: '#ef4444' },
            medium: { bg: 'rgba(245,158,11,.08)', border: 'rgba(245,158,11,.2)', icon: 'ri-flag-line', color: '#f59e0b' },
            low: { bg: 'rgba(100,116,139,.08)', border: 'rgba(100,116,139,.2)', icon: 'ri-flag-line', color: '#64748b' },
        };
        const pStyle = priorityColors[item.priority];
        
        const html = `
            <div class="card" style="padding:16px;${item.status === 'expired' ? 'border-left:3px solid #ef4444;' : ''}">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
                    <div class="cat-ico" style="width:40px;height:40px;background:${pStyle.bg}">
                        <i class="${pStyle.icon}" style="color:${pStyle.color};font-size:1rem"></i>
                    </div>
                    <div class="badge" style="background:rgba(124,58,237,.12);color:#a78bfa;font-size:.68rem;padding:2px 8px">${item.category}</div>
                </div>
                ${daysText}
                <div style="font-size:.92rem;font-weight:700;color:#f1f5f9;margin-bottom:8px">${item.title}</div>
                <div style="font-size:.75rem;color:#64748b;margin-bottom:4px">
                    <i class="ri-calendar-line"></i> ${formatDate(item.date)}
                </div>
                <div style="font-size:.85rem;font-weight:700;color:#10b981;margin-bottom:8px">${item.amount}</div>
                ${item.notes ? `<div style="font-size:.75rem;color:#94a3b8;font-style:italic;margin-bottom:12px">${item.notes}</div>` : '<div style="margin-bottom:12px"></div>'}
                <div style="display:flex;gap:6px;margin-top:auto">
                    ${item.status === 'active' || item.status === 'expired' ? `
                        <button class="btn btn-ghost btn-sm" style="flex:1" onclick="completeReminder(${item.id})">
                            <i class="ri-check-line"></i> Complete
                        </button>
                    ` : ''}
                    ${item.status === 'completed' || item.status === 'archived' ? `
                        <button class="btn btn-ghost btn-sm" style="flex:1" onclick="restoreReminder(${item.id})">
                            <i class="ri-restart-line"></i> Restore
                        </button>
                    ` : ''}
                    <button class="btn btn-ghost btn-sm" onclick="viewReminderDetails(${item.id})">
                        <i class="ri-eye-line"></i>
                    </button>
                </div>
            </div>
        `;
        gridEl.innerHTML += html;
    });
}

// Set View
function setHistoryView(view) {
    currentView = view;
    document.querySelectorAll('.view-btn').forEach(btn => btn.classList.remove('active'));
    document.getElementById(`vh-${view}`).classList.add('active');
    renderCurrentView();
}

// Reset Filters
function resetHistoryFilters() {
    document.getElementById('history-search').value = '';
    document.getElementById('history-cat').value = 'all';
    document.getElementById('history-sort').value = 'date-asc';
    filterCurrentTab();
    toast('Filters reset', 'info');
}

// Complete Reminder
function completeReminder(id) {
    const item = allReminders.find(r => r.id === id);
    if (item) {
        item.status = 'completed';
        item.completedDate = getTodayDate();
        toast(`Completed: ${item.title}`, 'success');
        filterCurrentTab();
        updateTabCounts();
    }
}

// Snooze Reminder
function snoozeReminder(id) {
    const item = allReminders.find(r => r.id === id);
    if (item) {
        toast(`Snoozed: ${item.title} for 1 day`, 'info');
        // In real app: update date
    }
}

// Restore Reminder
function restoreReminder(id) {
    const item = allReminders.find(r => r.id === id);
    if (item && confirm(`Restore "${item.title}" to active reminders?`)) {
        item.status = 'active';
        item.completedDate = null;
        toast(`Restored: ${item.title}`, 'success');
        filterCurrentTab();
        updateTabCounts();
    }
}

// Delete Reminder
function deleteReminder(id) {
    const item = allReminders.find(r => r.id === id);
    if (item && confirm(`Delete "${item.title}"? This cannot be undone.`)) {
        const index = allReminders.indexOf(item);
        allReminders.splice(index, 1);
        toast(`Deleted: ${item.title}`, 'info');
        filterCurrentTab();
        updateTabCounts();
    }
}

// View Details
function viewReminderDetails(id) {
    const item = allReminders.find(r => r.id === id);
    if (item) {
        openModal('detail-modal')
    }
}

// Bulk Actions
function archiveAllCompleted() {
    const completed = allReminders.filter(r => r.status === 'completed');
    if (completed.length === 0) {
        toast('No completed reminders to archive', 'info');
        return;
    }
    if (confirm(`Archive all ${completed.length} completed reminders?`)) {
        completed.forEach(item => item.status = 'archived');
        toast(`Archived ${completed.length} reminders`, 'success');
        filterCurrentTab();
        updateTabCounts();
    }
}

function snoozeAllExpired() {
    const expired = allReminders.filter(r => r.status === 'expired');
    if (expired.length === 0) {
        toast('No expired reminders to snooze', 'info');
        return;
    }
    toast(`Snoozed all ${expired.length} expired reminders for 1 day`, 'info');
}

function deleteAllArchived() {
    const archived = allReminders.filter(r => r.status === 'archived');
    if (archived.length === 0) {
        toast('No archived reminders to delete', 'info');
        return;
    }
    if (confirm(`Permanently delete all ${archived.length} archived reminders? This cannot be undone.`)) {
        const filtered = allReminders.filter(r => r.status !== 'archived');
        allReminders.length = 0;
        allReminders.push(...filtered);
        toast(`Deleted ${archived.length} archived reminders`, 'success');
        filterCurrentTab();
        updateTabCounts();
    }
}

// Export History
function exportHistory() {
    toast('Exporting history as CSV...', 'info');
    // Implement CSV export
}

// Format Date
function formatDate(dateStr) {
    const date = new Date(dateStr);
    return date.toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' });
}

// Update Tab Counts
function updateTabCounts() {
    const counts = {
        today: getRemindersByCategory('today').length,
        upcoming: getRemindersByCategory('upcoming').length,
        future: getRemindersByCategory('future').length,
        completed: getRemindersByCategory('completed').length,
        expired: getRemindersByCategory('expired').length,
        archived: getRemindersByCategory('archived').length,
    };
    
    Object.keys(counts).forEach(tab => {
        const badge = document.querySelector(`[data-tab="${tab}"] .badge-count`);
        if (badge) {
            badge.textContent = counts[tab];
            badge.style.display = counts[tab] > 0 ? 'inline-block' : 'none';
        }
    });
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    // Set today's date
    const today = new Date().toLocaleDateString('en-GB', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
    const todayEl = document.getElementById('today-date');
    if (todayEl) todayEl.textContent = today;
    
    populateCategories();
    updateTabCounts();
    filterCurrentTab();
});

// Toast function (if not already defined)
function toast(message, type = 'info') {
    console.log(`[${type.toUpperCase()}] ${message}`);
    // Implement actual toast notification
}
</script>

@endsection