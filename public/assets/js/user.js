window.addEventListener("load", () => {
    setTimeout(() => {
        document.getElementById("loader").classList.add("hidden");
    }, 800);
});

// ============================================================
// DATA
// ============================================================
const CATS = window.PAGE_CATS || window.CATS || {};

// const CATS = {
//     'special-days': {
//         name: 'Special Days',
//         icon: 'ri-cake-3-line',
//         color: '#f59e0b',
//         bg: 'rgba(245,158,11,.12)',
//         subs: ['Birthdays', 'Anniversaries', 'Festivals', 'Functions', 'Christenings', 'Graduations']
//     },
//     'home': {
//         name: 'Home',
//         icon: 'ri-home-4-line',
//         color: '#14b8a6',
//         bg: 'rgba(20,184,166,.12)',
//         subs: ['Electricity', 'Gas', 'Dual Fuel Options', 'Council Tax', 'Water Bill']
//     },
//     'insurance': {
//         name: 'Insurance',
//         icon: 'ri-shield-star-line',
//         color: '#f43f5e',
//         bg: 'rgba(244,63,94,.12)',
//         subs: ['Home Insurance', 'Contents Insurance', 'Life Insurance', 'Home & Contents Insurance', 'Critical Illness']
//     },
//     'tv-telephone-mobile': {
//         name: 'TV, Tel & Mobile',
//         icon: 'ri-smartphone-line',
//         color: '#14b8a6',
//         bg: 'rgba(20,184,166,.12)',
//         subs: ['Phone Plans', 'SIM Only', 'Home Telephone', 'Internet Services', 'Bundled Plans', 'TV Packages']
//     },
//     'motor-vehicle': {
//         name: 'Motor Vehicle',
//         icon: 'ri-car-line',
//         color: '#a78bfa',
//         bg: 'rgba(167,139,250,.12)',
//         subs: ['Car Insurance', 'Motorcycle Insurance', 'MOT', 'Road VAT(12-Month)', 'Road VAT(6-Month)', 'Breakdown Cover']
//     },
//     'travel': {
//         name: 'Travel',
//         icon: 'ri-flight-takeoff-line',
//         color: '#ec4899',
//         bg: 'rgba(236,72,153,.12)',
//         subs: ['Passport Renewal', 'Driving License', 'Visa Applications', 'Travel Points', 'Travel Insurance']
//     },
//     'subscriptions': {
//         name: 'Subscriptions',
//         icon: 'ri-refresh-line',
//         color: '#14b8a6',
//         bg: 'rgba(20,184,166,.12)',
//         subs: ['Membership Plans', 'Software Subscriptions', 'Media Streaming', 'Gaming Subscriptions', 'Newspaper / Magazine']
//     },
//     'pet-care': {
//         name: 'Pet Care',
//         icon: 'ri-footprint-line',
//         color: '#10b981',
//         bg: 'rgba(16,185,129,.12)',
//         subs: ['Pet Insurance', 'Vaccinations', 'Annual Check-Ups', 'Grooming', 'Flea & Worm Treatment']
//     },
//     'health': {
//         name: 'Health',
//         icon: 'ri-heart-pulse-line',
//         color: '#10b981',
//         bg: 'rgba(16,185,129,.12)',
//         subs: ['Health Insurance', 'GP Appointments', 'Vaccinations', 'Gym Memberships', 'Dental Check-Up']
//     },
//     'others': {
//         name: 'Others',
//         icon: 'ri-more-2-line',
//         color: '#94a3b8',
//         bg: 'rgba(148,163,184,.12)',
//         subs: ['Miscellaneous']
//     }
// };

const TEMPLATES = [
    {
        id: "car-ins",
        title: "Car Insurance Renewal",
        cat: "motor-vehicle",
        sub: "Car Insurance",
        freq: "Annually",
        icon: "ri-car-line",
        col: "#a78bfa",
        bg: "rgba(167,139,250,.12)",
        pop: 245,
    },
    {
        id: "mot",
        title: "MOT Test",
        cat: "motor-vehicle",
        sub: "MOT",
        freq: "Annually",
        icon: "ri-tools-line",
        col: "#10b981",
        bg: "rgba(16,185,129,.12)",
        pop: 198,
    },
    {
        id: "road-tax",
        title: "Road VATRenewal",
        cat: "motor-vehicle",
        sub: "Road VAT(12-Month)",
        freq: "Annually",
        icon: "ri-file-shield-line",
        col: "#f43f5e",
        bg: "rgba(244,63,94,.12)",
        pop: 167,
    },
    {
        id: "streaming",
        title: "Streaming Subscription",
        cat: "subscriptions",
        sub: "Media Streaming",
        freq: "Monthly",
        icon: "ri-play-circle-line",
        col: "#14b8a6",
        bg: "rgba(20,184,166,.12)",
        pop: 189,
    },
    {
        id: "birthday",
        title: "Birthday Reminder",
        cat: "special-days",
        sub: "Birthdays",
        freq: "",
        icon: "ri-cake-3-line",
        col: "#f59e0b",
        bg: "rgba(245,158,11,.12)",
        pop: 312,
    },
    {
        id: "passport",
        title: "Passport Renewal",
        cat: "travel",
        sub: "Passport Renewal",
        freq: "",
        icon: "ri-passport-line",
        col: "#ec4899",
        bg: "rgba(236,72,153,.12)",
        pop: 134,
    },
    {
        id: "bike-ins",
        title: "Motorcycle Insurance",
        cat: "motor-vehicle",
        sub: "Motorcycle Insurance",
        freq: "Annually",
        icon: "ri-motorbike-line",
        col: "#a78bfa",
        bg: "rgba(167,139,250,.12)",
        pop: 89,
    },
    {
        id: "gp",
        title: "GP Annual Check-Up",
        cat: "health",
        sub: "GP Appointments",
        freq: "Annually",
        icon: "ri-stethoscope-line",
        col: "#10b981",
        bg: "rgba(16,185,129,.12)",
        pop: 156,
    },
    {
        id: "gym",
        title: "Gym Membership",
        cat: "health",
        sub: "Gym Memberships",
        freq: "Monthly",
        icon: "ri-run-line",
        col: "#10b981",
        bg: "rgba(16,185,129,.12)",
        pop: 203,
    },
    {
        id: "pet-ins",
        title: "Pet Insurance",
        cat: "pet-care",
        sub: "Pet Insurance",
        freq: "Annually",
        icon: "ri-footprint-line",
        col: "#10b981",
        bg: "rgba(16,185,129,.12)",
        pop: 78,
    },
    {
        id: "home-ins",
        title: "Home Insurance",
        cat: "insurance",
        sub: "Home Insurance",
        freq: "Annually",
        icon: "ri-home-heart-line",
        col: "#f43f5e",
        bg: "rgba(244,63,94,.12)",
        pop: 221,
    },
    {
        id: "broadband",
        title: "Broadband Renewal",
        cat: "tv-telephone-mobile",
        sub: "Internet Services",
        freq: "Annually",
        icon: "ri-wifi-line",
        col: "#14b8a6",
        bg: "rgba(20,184,166,.12)",
        pop: 145,
    },
    {
        id: "life-ins",
        title: "Life Insurance",
        cat: "insurance",
        sub: "Life Insurance",
        freq: "Annually",
        icon: "ri-shield-check-line",
        col: "#f43f5e",
        bg: "rgba(244,63,94,.12)",
        pop: 132,
    },
    {
        id: "anniv",
        title: "Anniversary",
        cat: "special-days",
        sub: "Anniversaries",
        freq: "Annually",
        icon: "ri-heart-line",
        col: "#f59e0b",
        bg: "rgba(245,158,11,.12)",
        pop: 187,
    },
    {
        id: "driv-lic",
        title: "Driving Licence Renewal",
        cat: "travel",
        sub: "Driving License",
        freq: "",
        icon: "ri-drive-line",
        col: "#ec4899",
        bg: "rgba(236,72,153,.12)",
        pop: 98,
    },
    {
        id: "elec",
        title: "Electricity Plan",
        cat: "home",
        sub: "Electricity",
        freq: "Annually",
        icon: "ri-flashlight-line",
        col: "#14b8a6",
        bg: "rgba(20,184,166,.12)",
        pop: 167,
    },
];
const FAQS = [
    {
        q: "How do I create my first reminder?",
        a: 'Click "Create Reminder" in the sidebar or topbar. Fill in the title, category, subcategory, date and time. Optionally add provider, cost, and frequency. Click "Create Reminder" to save it.',
        cat: "Getting Started",
    },
    {
        q: "What categories are available?",
        a: "D-Remind offers 10 categories: Special Days, Home, Insurance, TV/Tel/Mobile, Motor Vehicle, Travel, Subscriptions, Pet Care, Health, and Others. Each has multiple subcategories you can also customize.",
        cat: "Getting Started",
    },
    {
        q: "How do I manage notifications?",
        a: "Go to Notification Settings in the sidebar. Toggle channels (Email, SMS, Push, WhatsApp) and set alert timing (30 days, 7 days, 3 days, 1 day before or on the day). You can also configure quiet hours.",
        cat: "Notifications",
    },
    {
        q: "How do I share reminders via WhatsApp or Email?",
        a: "From My Reminders, click the share icon on any reminder card or open the reminder details. Choose WhatsApp, Email, or Copy Link. Enter the recipient's number or email and optionally add a personal message.",
        cat: "Sharing",
    },
    {
        q: "What does my membership include?",
        a: "Basic Annual (£2.40/year incl. VAT) includes unlimited reminders, email & SMS notifications, calendar view, WhatsApp/Email sharing, custom subcategories, analytics, template access and more.",
        cat: "Billing",
    },
    {
        q: "How do I cancel my membership?",
        a: "Go to Membership in the sidebar and click 'Cancel Plan'. Your membership stays active until the end of your billing period. You won't be charged again after cancellation.",
        cat: "Billing",
    },
    {
        q: "I'm not receiving email notifications. What should I do?",
        a: "Check your spam folder and add support@winngoodremind.co.uk to your contacts. Verify email is enabled in Notification Settings and your email address is correct in Profile settings.",
        cat: "Technical",
    },
    {
        q: "How do I reset my password?",
        a: "Go to Profile in the sidebar, scroll to Security Settings. Enter your current password, new password (min 8 chars, 1 uppercase, 1 number), and confirm. Click 'Update Password'.",
        cat: "Technical",
    },
    {
        q: "Can I add custom subcategories?",
        a: "Yes! Go to Categories in the sidebar and click 'Add Subcategory'. Select a parent category, enter a name (3–50 characters), and optionally add a description. Your custom subcategory will then be available when creating reminders.",
        cat: "Categories",
    },
];

// Storage
const S = {
    get: (k, d) => {
        try {
            const v = localStorage.getItem("dr_" + k);
            return v ? JSON.parse(v) : d;
        } catch (e) {
            return d;
        }
    },
    set: (k, v) => {
        try {
            localStorage.setItem("dr_" + k, JSON.stringify(v));
        } catch (e) {}
    },
};
const gid = () =>
    "r_" + Date.now() + "_" + Math.random().toString(36).substr(2, 6);
let customSubs = S.get("custom_subs", []);

let reminders = window.DB_REMINDERS || [];

const getRems = () => reminders;

const saveRems = (data) => {
    reminders = data;
};

const daysUntil = (d) => {
    const t = new Date();
    t.setHours(0, 0, 0, 0);
    const dt = new Date(d);
    dt.setHours(0, 0, 0, 0);
    return Math.ceil((dt - t) / 864e5);
};

function duePill(d) {
    const n = daysUntil(d);
    if (n < 0) return `<span class="pill-urgent">Completed</span>`;
    if (n === 0) return `<span class="pill-urgent">Due today</span>`;
    if (n <= 3) return `<span class="pill-urgent">In ${n}d</span>`;
    if (n <= 7) return `<span class="pill-soon">In ${n}d</span>`;
    return `<span class="pill-ok">In ${n}d</span>`;
}

function fmtDate(d) {
    if (!d) return "";
    const [y, m, dy] = d.split("-");
    return `${dy}/${m}/${y}`;
}

function pad(n) {
    return String(n).padStart(2, "0");
}

// ============================================================
// THEME
// ============================================================
function toggleTheme() {
    document.documentElement.classList.toggle("dark");
    document.documentElement.classList.toggle("light");
    const dark = document.documentElement.classList.contains("dark");
    document.getElementById("theme-icon").className = dark
        ? "ri-moon-line"
        : "ri-sun-line";
    S.set("theme", dark ? "dark" : "light");
    setTimeout(initCharts, 350);
}

function initTheme() {
    const t = S.get("theme", "dark");
    if (t === "light") {
        document.documentElement.classList.remove("dark");
        document.documentElement.classList.add("light");
    }
    document.getElementById("theme-icon").className =
        t === "dark" ? "ri-moon-line" : "ri-sun-line";
}

// ============================================================
// SIDEBAR
// ============================================================
let sbCollapsed = false;

function toggleSidebar() {
    sbCollapsed = !sbCollapsed;
    const sb = document.getElementById("sidebar");
    sb.classList.toggle("collapsed", sbCollapsed);
    S.set("sb_col", sbCollapsed);
}

function mobileClose() {
    closeMobile();
}

function openMobile() {
    document.getElementById("sidebar").classList.add("mobile-open");
    document.getElementById("sb-overlay").classList.add("show");
}

function closeMobile() {
    document.getElementById("sidebar").classList.remove("mobile-open");
    document.getElementById("sb-overlay").classList.remove("show");
}

function initSidebar() {
    sbCollapsed = S.get("sb_col", false);
    if (sbCollapsed)
        document.getElementById("sidebar").classList.add("collapsed");
}

// ============================================================
// ROUTING
// ============================================================
const PAGE_TITLES = {
    dashboard: "Dashboard",
    reminders: "My Reminders",
    create: "Create Reminder",
    calendar: "Calendar View",
    templates: "Reminder Templates",
    shared: "Shared Reminders",
    profile: "Profile",
    notifications: "Notifications",
    membership: "Membership & Billing",
    categories: "Reminder Categories",
    analytics: "Analytics & Activity",
    help: "Help & Support",
    feedback: "Feedback",
};
let curPage = "";
let editingId = null;

function go(p) {
    document
        .querySelectorAll(".page")
        .forEach((el) => el.classList.remove("active"));
    document
        .querySelectorAll(".nav-link")
        .forEach((el) => el.classList.remove("active"));
    const pg = document.getElementById("page-" + p);
    if (!pg) return;
    pg.classList.add("active");
    document.getElementById("page-title").textContent = PAGE_TITLES[p] || p;
    document.querySelectorAll(".nav-link").forEach((el) => {
        if (
            el.getAttribute("onclick") &&
            el.getAttribute("onclick").includes(`'${p}'`)
        )
            el.classList.add("active");
    });
    curPage = p;
    if (p === "dashboard") initDash();
    if (p === "reminders") {
        populateCatFilter();
        loadReminders();
    }
    if (p === "create") initCreate();
    if (p === "calendar") initCalendar();
    if (p === "templates") renderTemplates();
    if (p === "categories") renderCategories();
    if (p === "analytics") initCharts();
    if (p === "help") renderFAQs();
    if (p === "shared") renderShared();
    closeMobile();
}

// ============================================================
// MODALS
// ============================================================
function openModal(id) {
    document.getElementById(id).classList.add("open");
    document.body.style.overflow = "hidden";
}

function closeModal(id) {
    document.getElementById(id).classList.remove("open");
    document.body.style.overflow = "";
}
document.querySelectorAll(".modal-bg").forEach((m) => {
    m.addEventListener("click", (e) => {
        if (e.target === m) {
            m.classList.remove("open");
            document.body.style.overflow = "";
        }
    });
});
// document.addEventListener('keydown', e => {
//     if (e.key === 'Escape') document.querySelectorAll('.modal-bg.open').forEach(m => {
//         m.classList.remove('open');
//         document.body.style.overflow = ''
//     })
// });
let _cb = null;

function confirm_act(msg, cb) {
    document.getElementById("confirm-msg").textContent = msg;
    _cb = cb;
    openModal("confirm-modal");
}
document.getElementById("confirm-ok").onclick = () => {
    if (_cb) _cb();
    closeModal("confirm-modal");
};

// ============================================================
// TOAST
// ============================================================

function toast(msg, type = "info", dur = 3500) {
    const cfg = {
        success: {
            bg: "rgba(16,185,129,.15)",
            bd: "rgba(16,185,129,.3)",
            col: "#10b981",
            ico: "ri-check-circle-line",
        },
        error: {
            bg: "rgba(244,63,94,.15)",
            bd: "rgba(244,63,94,.3)",
            col: "#f43f5e",
            ico: "ri-error-warning-line",
        },
        warning: {
            bg: "rgba(245,158,11,.15)",
            bd: "rgba(245,158,11,.3)",
            col: "#f59e0b",
            ico: "ri-alert-line",
        },
        info: {
            bg: "rgba(20,184,166,.15)",
            bd: "rgba(20,184,166,.3)",
            col: "#14b8a6",
            ico: "ri-information-line",
        },
    };
    const c = cfg[type] || cfg.info;
    const el = document.createElement("div");
    el.className = "toast";
    el.style.cssText = `background:${c.bg};border-color:${c.bd};color:${c.col}`;
    el.innerHTML = `<i class="${c.ico}" style="flex-shrink:0;font-size:1rem"></i><span style="flex:1">${msg}</span><button onclick="this.closest('.toast').remove()" style="background:none;border:none;color:inherit;cursor:pointer;opacity:.6;font-size:1rem;padding:0"><i class="ri-close-line"></i></button>`;
    document.getElementById("toast-area").appendChild(el);
    setTimeout(() => {
        el.style.cssText +=
            ";opacity:0;transform:translateX(60px);transition:all .3s";
        setTimeout(() => el.remove(), 300);
    }, dur);
}

// ============================================================
// DASHBOARD
// ============================================================
let dashChart = null;

function initDash() {
    const h = new Date().getHours();

    document.getElementById("greeting").textContent =
        h < 12 ? "Good morning" : h < 17 ? "Good afternoon" : "Good evening";

    const rems = window.UPCOMING_REMINDERS || [];

    const stats = window.DASH_STATS || {};

    document.getElementById("s-active").textContent = stats.active || 0;

    document.getElementById("s-week").textContent = stats.week || 0;

    document.getElementById("s-done").textContent = stats.done || 0;

    // 🔥 TODAY REMINDER COUNT
    document.getElementById("s-over").textContent = stats.today || 0;

    document.getElementById("dash-summary").textContent =
        stats.week > 0
            ? `You have ${stats.week} reminder${stats.week > 1 ? "s" : ""} due this week.`
            : "No reminders due this week — great job! 🎉";

    const ul = document.getElementById("dash-list");

    ul.innerHTML =
        rems.length === 0
            ? '<div style="text-align:center;padding:30px;color:#475569;font-size:.83rem">No upcoming reminders</div>'
            : rems.map((r) => remCardHTML(r, true)).join("");

    initDashChart();
}

function initDashChart() {
    const cv = document.getElementById("dash-chart");
    if (!cv) return;
    if (dashChart) {
        dashChart.destroy();
        dashChart = null;
    }

    const isDark = document.documentElement.classList.contains("dark");
    const tc = isDark ? "#fff" : "#000";
    const stats = window.DASH_STATS || {};

    const labels = ["Active", "Due This Week", "Completed", "Today"];

    const data = [
        stats.active || 0,
        stats.week || 0,
        stats.done || 0,
        stats.today || 0,
    ];

    dashChart = new Chart(cv, {
        type: "pie",
        data: {
            labels,
            datasets: [
                {
                    data,
                    backgroundColor: [
                        "#7c3aed",
                        "#f59e0b",
                        "#10b981",
                        "#f43f5e",
                    ],
                },
            ],
        },

        options: {
            plugins: {
                legend: {
                    labels: {
                        color: tc,

                        font: {
                            family: "DM Sans",
                            size: 11,
                        },
                    },
                },
            },

            maintainAspectRatio: false,
        },
    });
}

// ============================================================
// REMINDER CARDS
// ============================================================
function remCardHTML(r, compact = false) {
    const cat = CATS[r.category] || {
        name: r.category,
        icon: r.icon || 'ri-alarm-line',
        color: r.color || "#94a3b8",
        bg: "rgba(148,163,184,.12)",
    };
    const dp = duePill(r.dueDate);
    const doneBadge =
        r.reminder_status === "completed"
            ? '<span class="pill-done">Completed</span>'
            : "";
    return `<div class="rem-card group" onclick="viewDetail('${r.id}')">
<div class="cat-ico" style="background:${cat.bg}"><i class="${cat.icon}" style="color:${cat.color}"></i></div>
<div style="flex:1;min-width:0">
<div style="font-size:.87rem;font-weight:600;color:#f1f5f9;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${r.title}</div>
<div style="font-size:.75rem;color:#64748b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${cat.name} → ${r.subcategory}${r.provider ? " · " + r.provider : ""}${r.cost ? " · £" + r.cost : ""}</div>
<div style="font-size:.73rem;color:#64748b;margin-top:2px"><i class="ri-calendar-line"></i> ${fmtDate(r.dueDate)} at ${r.dueTime || "09:00"}</div>
</div>
${r.reminder_status === "completed" ? doneBadge : dp}
${
    !compact
        ? `<div style="display:flex;gap:6px;flex-shrink:0" onclick="event.stopPropagation()">
            ${r.reminder_status !== 'completed' 
                ? `<button class="btn btn-ghost btn-xs" onclick="editReminder('${r.id}')" title="Edit"><i class="ri-pencil-line"></i></button>` 
                : ''
            }
            <button class="btn btn-danger btn-xs" onclick="deleteRem('${r.id}')" title="Delete"><i class="ri-delete-bin-line"></i></button>
           </div>`
        : ""
}
</div>`;
}

function gridCardHTML(r) {
    const cat = CATS[r.category] || {
        name: r.category,
        icon: "ri-alarm-line",
        color: "#94a3b8",
        bg: "rgba(148,163,184,.12)",
    };
    const dp =
        r.reminder_status === "completed"
            ? '<span class="pill-done">Completed</span>'
            : duePill(r.dueDate);
    return `<div class="card" style="padding:16px;cursor:pointer;transition:all .2s" onclick="viewDetail('${r.id}')">
<div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:12px"><div class="cat-ico" style="background:${cat.bg}"><i class="${cat.icon}" style="color:${cat.color}"></i></div>${dp}</div>
<div style="font-weight:600;font-size:.87rem;color:#f1f5f9;margin-bottom:4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${r.title}</div>
<div style="font-size:.75rem;color:#64748b;margin-bottom:6px">${cat.name} → ${r.subcategory}</div>
<div style="font-size:.75rem;color:#64748b;margin-bottom:${r.cost ? "6" : "12"}px"><i class="ri-calendar-line"></i> ${fmtDate(r.dueDate)} at ${r.dueTime || "09:00"}</div>
${r.cost ? `<div style="font-weight:700;font-size:.85rem;color:#f1f5f9;margin-bottom:12px">£${r.cost}${r.frequency ? " / " + r.frequency : ""}</div>` : ""}
<div style="display:flex;gap:8px" onclick="event.stopPropagation()">

${r.reminder_status !== 'completed' ? `
<button class="btn btn-ghost btn-xs" style="flex:1;justify-content:center" onclick="editReminder('${r.id}')">
    <i class="ri-pencil-line"></i> Edit
</button>
` : ''}


<button class="btn btn-danger btn-xs" onclick="deleteRem('${r.id}')"><i class="ri-delete-bin-line"></i></button>
</div>
</div>`;
}

function viewDetail(id) {
    const r = getRems().find((x) => String(x.id) === String(id));
    if (!r) return;
    const cat = CATS[String(r.category)] || {
        name: r.category,
        icon: "ri-alarm-line",
        color: "#94a3b8",
        bg: "rgba(148,163,184,.12)",
    };
    const dp =
        r.reminder_status === "completed"
            ? '<span class="pill-done">Completed</span>'
            : duePill(r.dueDate);
    document.getElementById("detail-content").innerHTML = `
<div style="text-align:center;margin-bottom:20px">
<div class="cat-ico" style="background:${cat.bg};width:56px;height:56px;border-radius:16px;margin:0 auto 10px"><i class="${cat.icon}" style="color:${cat.color};font-size:1.5rem"></i></div>
<h2 class="font-jakarta" style="font-weight:700;font-size:1.05rem;color:#f1f5f9">${r.title}</h2>
<div style="margin-top:8px">${dp}</div>
</div>
<div style="display:flex;flex-direction:column;gap:8px;margin-bottom:20px">
<div style="display:flex;gap:10px;padding:12px;border-radius:10px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06)"><i class="ri-folder-line" style="color:#2dd4bf;flex-shrink:0;margin-top:2px"></i><div><div style="font-size:.73rem;color:#64748b">Category</div><div style="font-size:.87rem;font-weight:600;color:#94a3b8">${cat.name} → ${r.subcategory}</div></div></div>
<div style="display:flex;gap:10px;padding:12px;border-radius:10px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06)"><i class="ri-calendar-line" style="color:#10b981;flex-shrink:0;margin-top:2px"></i><div><div style="font-size:.73rem;color:#64748b">Date & Time</div><div style="font-size:.87rem;font-weight:600;color:#94a3b8">${fmtDate(r.dueDate)} at ${r.dueTime || "09:00"}</div></div></div>
${r.provider ? `<div style="display:flex;gap:10px;padding:12px;border-radius:10px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06)"><i class="ri-building-line" style="color:#f59e0b;flex-shrink:0;margin-top:2px"></i><div><div style="font-size:.73rem;color:#64748b">Provider</div><div style="font-size:.87rem;font-weight:600;color:#94a3b8">${r.provider}</div></div></div>` : ""}
${r.cost ? `<div style="display:flex;gap:10px;padding:12px;border-radius:10px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06)"><i class="ri-money-pound-circle-line" style="color:#10b981;flex-shrink:0;margin-top:2px"></i><div><div style="font-size:.73rem;color:#64748b">Cost</div><div style="font-size:.87rem;font-weight:600;color:#94a3b8">£${r.cost}${r.frequency ? " / " + r.frequency : ""}</div></div></div>` : ""}
${r.description ? `<div style="padding:12px;border-radius:10px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06)"><div style="font-size:.73rem;color:#64748b;margin-bottom:4px">Description</div><div style="font-size:.84rem;color:#64748b;line-height:1.6">${r.description}</div></div>` : ""}

<div style="display:flex;gap:10px;padding:12px;border-radius:10px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06)"><i class="ri-checkbox-circle-line" style="color:#10b981;flex-shrink:0;margin-top:2px"></i><div><div style="font-size:.73rem;color:#64748b">Status</div><div style="font-size:.87rem;font-weight:600;color:#94a3b8">${r.status}</div></div></div>
</div>
<div style="display:flex;gap:8px;flex-wrap:wrap">
<button class="btn btn-primary" style="flex:1;justify-content:center" onclick="closeModal('detail-modal');editReminder('${r.id}')"><i class="ri-pencil-line"></i> Edit</button>
</div>`;
    openModal("detail-modal");
}
// ${r.theme ? `<div style="display:flex;gap:10px;padding:12px;border-radius:10px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06)"><i class="ri-palette-line" style="color:#a78bfa;flex-shrink:0;margin-top:2px"></i><div><div style="font-size:.73rem;color:#64748b">Theme</div><div style="font-size:.87rem;font-weight:600;color:#94a3b8">${r.theme}</div></div></div>` : ''}

function markDone(id) {
    const rems = getRems();
    const i = rems.findIndex((r) => r.id === id);
    if (i < 0) return;
    rems[i].status = "completed";
    rems[i].completedAt = new Date().toISOString();
    saveRems(rems);
    if (curPage === "reminders") loadReminders();
    if (curPage === "dashboard") initDash();
    toast("Reminder marked as completed! ✓", "success");
}

async function deleteRem(id) {
    confirm_act("Delete this reminder? This cannot be undone.", async () => {
        try {
            const res = await fetch(`/delete-reminder/${id}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]',
                    ).content,
                    Accept: "application/json",
                },
            });
            const result = await res.json();
            if (!res.ok) {
                toast(result.message, "error");

                return;
            }
            // remove from local array
            reminders = reminders.filter((r) => r.id != id);
            if (curPage === "reminders") loadReminders();

            if (curPage === "dashboard") initDash();
            toast(result.message, "success");
            setTimeout(() => {
                location.reload();
            }, 1500);
        } catch (err) {
            console.log(err);
            toast("Something went wrong", "error");
        }
    });
}

function editReminder(id) {
    editingId = id;
    const r = getRems().find((x) => String(x.id) === String(id));
    if (!r) return;
    document.getElementById("r-title").value = r.title || "";
    document.getElementById("r-cat").value = r.category || "";
    updateSubs();
    setTimeout(() => {
        document.getElementById("r-sub").value = r.subcategory || "";
    }, 50);
    document.getElementById("r-date").value = r.end_reminder_date || "";
    document.getElementById("r-time").value = r.dueTime || "09:00";
    document.getElementById("r-desc").value = r.description || "";
    document.getElementById("desc-len").textContent = (
        r.description || ""
    ).length;
    document.getElementById("r-provider").value = r.provider || "";
    document.getElementById("r-cost").value = r.cost || "";
    document.getElementById("r-freq").value = r.frequency || "";
    // document.getElementById('r-theme').value = r.theme || '';
    if (
        r.provider ||
        r.cost ||
        r.frequency
        // || r.theme
    ) {
        document.getElementById("opt-fields").style.display = "block";
    }
    document.getElementById("create-btn-txt").textContent = "Save Changes";
    openReminderModal();
}

// ============================================================
// REMINDERS PAGE
// ============================================================
function populateCatFilter() {
    const sel = document.getElementById("rem-cat");
    if (!sel || sel.children.length > 1) return;
    Object.entries(CATS).forEach(([k, c]) => {
        const o = document.createElement("option");
        o.value = k;
        o.textContent = c.name;
        sel.appendChild(o);
    });
}
let remView = "grid";

function setView(v) {
    remView = v;
    document.getElementById("vl").classList.toggle("active", v === "list");
    document.getElementById("vg").classList.toggle("active", v === "grid");
    loadReminders();
}

function resetFilters() {
    document.getElementById("rem-search").value = "";
    document.getElementById("rem-cat").value = "all";
    document.getElementById("rem-status").value = "all";
    document.getElementById("rem-sort").value = "date-asc";
    loadReminders();
}

function loadReminders() {
    let rems = getRems();
    const q = (document.getElementById("rem-search")?.value || "")
        .toLowerCase()
        .trim();
    const cat = document.getElementById("rem-cat")?.value || "all";
    const st = document.getElementById("rem-status")?.value || "all";
    const sort = document.getElementById("rem-sort")?.value || "date-asc";
    if (q)
        rems = rems.filter((r) =>
            (r.title + " " + (r.provider || "") + " " + (r.description || ""))
                .toLowerCase()
                .includes(q),
        );
    if (cat !== "all") rems = rems.filter((r) => r.category === cat);
    if (st === "today")
        rems = rems.filter(
            (r) => r.status === "active" && daysUntil(r.dueDate) === 0,
        );
    else if (st === "upcoming")
        rems = rems.filter(
            (r) => r.status === "active" && daysUntil(r.dueDate) > 0,
        );
    else if (st === "completed")
        rems = rems.filter((r) => r.status === "completed");
    const [sf, so] = sort.split("-");
    rems.sort((a, b) => {
        let av =
            sf === "title"
                ? a.title.toLowerCase()
                : sf === "created"
                  ? new Date(a.createdAt)
                  : new Date(a.dueDate);
        let bv =
            sf === "title"
                ? b.title.toLowerCase()
                : sf === "created"
                  ? new Date(b.createdAt)
                  : new Date(b.dueDate);
        return so === "asc" ? (av > bv ? 1 : -1) : av < bv ? 1 : -1;
    });
    const all = getRems();
    const active = all.filter((r) => r.status === "active");
    const displayCount = document.getElementById("rem-display-count");

    if (displayCount) {
        displayCount.textContent = rems.length;
    }
    const countLabel = document.getElementById("rem-count-label");

    if (countLabel) {
        countLabel.textContent = `${active.length} active · ${all.length} total`;
    }
    const rl = document.getElementById("rem-list"),
        rg = document.getElementById("rem-grid"),
        re = document.getElementById("rem-empty");
    if (rems.length === 0) {
        rl.style.display = "none";
        rg.style.display = "none";
        re.style.display = "block";
        return;
    }
    re.style.display = "none";
    if (remView === "list") {
        rl.style.display = "flex";
        rg.style.display = "none";
        rl.innerHTML = rems.map((r) => remCardHTML(r, false)).join("");
    } else {
        rl.style.display = "none";
        rg.style.display = "grid";
        rg.innerHTML = rems.map((r) => gridCardHTML(r)).join("");
    }
}

// ============================================================
// CREATE REMINDER
// ============================================================

function initCreate() {
    const cs = document.getElementById("r-cat");

    // 🔥 prevent duplicate TomSelect
    if (cs.tomselect) {
        cs.tomselect.destroy();
    }

    cs.innerHTML = '<option value="">Select category…</option>';

    // 🔥 dynamic categories
    Object.entries(CATS).forEach(([k, c]) => {
        const o = document.createElement("option");

        o.value = k;

        o.textContent = c.name;

        cs.appendChild(o);
    });

    // 🔥 searchable dropdown
    const categorySelect = new TomSelect("#r-cat", {
        create: false,

        sortField: {
            field: "text",
            direction: "asc",
        },

        placeholder: "Search category...",
    });

    // 🔥 MOVE ERROR DIV INSIDE TS-WRAPPER
    const wrapper = document.querySelector("#r-cat").parentElement;
    if (wrapper && wrapper.classList.contains("ts-wrapper")) {
        wrapper.appendChild(document.getElementById("err-category_id"));
    }

    // 🔥 CLEAR CATEGORY ERROR
    categorySelect.on("change", function () {
        const err = document.getElementById("err-category_id");

        err.innerText = "";

        err.style.display = "none";
    });

    // 🔥 edit mode
    if (editingId) {
        const r = getRems().find((x) => x.id === editingId);

        if (!r) {
            editingId = null;
            return;
        }
        document.getElementById("create-title").textContent = "Edit Reminder";
        document.getElementById("create-btn-txt").textContent = "Save Changes";
        cs.tomselect.setValue(r.category);
        updateSubs();
        setTimeout(() => {
            document.getElementById("r-sub").value = r.subcategory;
        }, 100);

        document.getElementById("r-title").value = r.title;
        document.getElementById("r-date").value = r.end_reminder_date || "";
        document.getElementById("r-time").value = r.dueTime || "09:00";
        document.getElementById("r-desc").value = r.description || "";
        document.getElementById("desc-len").textContent = (
            r.description || ""
        ).length;
    } else {
        document.getElementById("create-title").textContent =
            "Create New Reminder";

        document.getElementById("create-btn-txt").textContent =
            "Create Reminder";

        document.getElementById("rem-form").reset();

        document.getElementById("desc-len").textContent = "0";

        document.getElementById("r-sub").disabled = true;

        document.getElementById("opt-fields").style.display = "none";
    }
}

function updateSubs() {
    const cat = document.getElementById("r-cat").value;

    const sub = document.getElementById("r-sub");

    // clear old subcategories
    sub.innerHTML = '<option value="">Select subcategory...</option>';

    if (cat && CATS[cat]) {
        // 🔥 dynamic subcategories
        CATS[cat].subs.forEach(function (item) {
            const option = document.createElement("option");

            // 🔥 VALUE
            option.value = item.name;

            // 🔥 TEXT
            option.textContent = item.name;

            // 🔥 OPTIONAL SUBCATEGORY ID
            option.dataset.id = item.id;

            sub.appendChild(option);
        });

        sub.disabled = false;

        // 🔥 category name from DB
        const categoryName = CATS[cat].name.toLowerCase().trim();

        // 🔥 show/hide extra fields
        if (categoryName === "special day" || categoryName === "others") {
            document.getElementById("opt-fields").style.display = "none";
        } else {
            document.getElementById("opt-fields").style.display = "block";
        }
    } else {
        sub.disabled = true;

        document.getElementById("opt-fields").style.display = "none";
    }
}

async function submitReminder() {

    // 🔥 CLEAR ERRORS
    document.querySelectorAll('.error-text').forEach(el => el.innerText = '');

    const btn     = document.getElementById('create-btn');
    const btnText = document.getElementById('create-btn-txt');

    const data = {
        title:             document.getElementById('r-title').value.trim(),
        category_id:       document.getElementById('r-cat').value,
        subcategory_name:  document.getElementById('r-sub').value,
        end_reminder_date:     document.getElementById('r-date').value,
        reminder_time:     document.getElementById('r-time').value,
        description:       document.getElementById('r-desc').value.trim(),
        provider:          document.getElementById('r-provider').value.trim(),
        cost:              document.getElementById('r-cost').value,
        payment_frequency: document.getElementById('r-freq').value,
    };

    // 🔥 decide URL and method
    const isEdit = !!editingId;
    const url    = isEdit ? `/update-reminder/${editingId}` : '/store-reminder';
    const method = isEdit ? 'PUT' : 'POST';

    btn.disabled   = true;
    btnText.innerText = isEdit ? 'Saving...' : 'Creating...';

    try {
        const res = await fetch(url, {
            method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        });

        const result = await res.json();

        // 🔴 VALIDATION ERRORS
        if (res.status === 422) {
            const fieldIdMap = { category_id: 'err-rem-category_id' };
            Object.keys(result.errors).forEach(field => {
                const elId = fieldIdMap[field] || ('err-' + field);
                const el   = document.getElementById(elId);
                if (el) {
                    el.innerText       = result.errors[field][0];
                    el.style.display   = 'block';
                }
            });
            btn.disabled      = false;
            btnText.innerText = isEdit ? 'Save Changes' : 'Create Reminder';
            return;
        }

        // ✅ SUCCESS
        toast(result.message, 'success');
        closeReminderModal();
        setTimeout(() => location.reload(), 1500);

    } catch (err) {
        console.log(err);
        toast('Something went wrong', 'error');
    }

    btn.disabled      = false;
    btnText.innerText = isEdit ? 'Save Changes' : 'Create Reminder';
}

// 🔥 FORM SUBMIT BIND
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("rem-form");

    if (form) {
        form.addEventListener("submit", submitReminder);
    }
});

function clearReminderError(inputId, errorId, eventType = "input") {
    const input = document.getElementById(inputId);

    const error = document.getElementById(errorId);

    if (!input || !error) return;

    input.addEventListener(eventType, () => {
        error.innerText = "";
    });
}

clearReminderError("r-title", "err-title");

clearReminderError("r-sub", "err-subcategory_name", "change");


clearReminderError("r-date", "err-end_reminder_date", "change");

clearReminderError("r-time", "err-reminder_time", "change");

clearReminderError("r-desc", "err-description");

clearReminderError("r-provider", "err-provider");

clearReminderError("r-cost", "err-cost");

clearReminderError("r-freq", "err-payment_frequency", "change");

function cancelCreate() {
    if (editingId) {
        editingId = null;
        go("reminders");
    } else
        confirm_act("Discard and go back to reminders?", () => go("reminders"));
}

// Open popup
function openSubPopup() {
    const cat = document.getElementById("r-cat").value;
    if (!cat) {
        toast("Select category first", "error");
        return;
    }
    document.getElementById("sub-popup").style.display = "flex";
    document.getElementById("new-sub-input").value = "";
}

// Close popup
function closeSubPopup() {
    document.getElementById("sub-popup").style.display = "none";
}

// Save new subcategory

function saveSubcategory() {
    const input = document.getElementById("new-sub-input");

    const name = input.value.trim();

    const cat = document.getElementById("r-cat").value;

    const subSelect = document.getElementById("r-sub");

    // 🔥 CATEGORY CHECK
    if (!cat || !CATS[cat]) {
        toast("Invalid category", "error");

        return;
    }

    // 🔥 EMPTY CHECK
    if (!name) {
        toast("Enter subcategory name", "error");

        return;
    }

    // 🔥 MIN LENGTH
    if (name.length < 2) {
        toast("Minimum 2 characters required", "error");

        return;
    }

    // 🔥 MAX LENGTH
    if (name.length > 30) {
        toast("Max 30 characters allowed", "error");

        return;
    }

    // 🔥 DUPLICATE CHECK
    const exists = CATS[cat].subs.some(function (s) {
        return s.name.toLowerCase() === name.toLowerCase();
    });

    if (exists) {
        toast("Subcategory already exists", "error");

        return;
    }

    // 🔥 ADD OBJECT FORMAT
    CATS[cat].subs.push({
        id: "custom_" + Date.now(),

        name: name,

        description: "",
    });

    // 🔥 REFRESH SUBCATEGORY
    updateSubs();

    // 🔥 AUTO SELECT
    subSelect.value = name;

    // 🔥 ENABLE SELECT
    subSelect.disabled = false;

    // 🔥 CLEAR INPUT
    input.value = "";

    // 🔥 CLEAR ERROR
    document.getElementById("err-subcategory_name").innerText = "";

    // 🔥 CLOSE POPUP
    closeSubPopup();

    // 🔥 SUCCESS
    toast("Subcategory added!", "success");
}

// ============================================================
// CALENDAR
// ============================================================

// ═══════════════════════════════════════════════════════
// CALENDAR V2 — ADVANCED
// ═══════════════════════════════════════════════════════

const CAL_CATS = window.CALENDAR_CATS || {
    others: {
        name:  'Others',
        color: '#94a3b8',
        bg:    'rgba(148,163,184,.12)',
        icon:  'ri-more-2-line',
    }
};

const CAL_MONTHS = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
];
const CAL_MONTHS_SHORT = [
    "Jan",
    "Feb",
    "Mar",
    "Apr",
    "May",
    "Jun",
    "Jul",
    "Aug",
    "Sep",
    "Oct",
    "Nov",
    "Dec",
];

let _calY,
    _calM,
    _calCatFilter = "all",
    _selDay = null;
window._selDay = null;

// ── Init
function initCalendarV2() {
    // 🔥 FIX
    if (!document.getElementById("cal-grid-v2")) {
        return;
    }

    const n = new Date();

    _calY = n.getFullYear();

    _calM = n.getMonth();

    _buildJumpSelects();

    _buildCatFilter();

    _renderAll();
}

// ── Build month/year selects
function _buildJumpSelects() {
    const ms = document.getElementById("cal-month-sel");
    const ys = document.getElementById("cal-year-sel");

    // 🔥 IMPORTANT FIX
    if (!ms || !ys) return;

    ms.innerHTML = CAL_MONTHS.map(
        (m, i) => `<option value="${i}">${m}</option>`,
    ).join("");

    const curYear = new Date().getFullYear();

    ys.innerHTML = "";

    for (let y = curYear - 5; y <= curYear + 10; y++) {
        ys.innerHTML += `
            <option value="${y}">
                ${y}
            </option>
        `;
    }
}

function _syncJumpSelects() {
    document.getElementById("cal-month-sel").value = _calM;
    document.getElementById("cal-year-sel").value = _calY;
}

function calJump() {
    _calM = parseInt(document.getElementById("cal-month-sel").value);
    _calY = parseInt(document.getElementById("cal-year-sel").value);
    _renderAll();
}

function calPrev() {
    _calM--;
    if (_calM < 0) {
        _calM = 11;
        _calY--;
    }
    _renderAll();
}
function calNext() {
    _calM++;
    if (_calM > 11) {
        _calM = 0;
        _calY++;
    }
    _renderAll();
}
function calGoToday() {
    const n = new Date();
    _calY = n.getFullYear();
    _calM = n.getMonth();
    _renderAll();
    _selectDay(n.getDate());
}

// ── Category filter
function _buildCatFilter() {
    const bar = document.getElementById('cat-filter-bar');
    if (!bar) return;

    // Clear existing buttons except "All"
    bar.querySelectorAll('[data-cat]:not([data-cat="all"])').forEach(b => b.remove());

    // Append one button per DB category
    Object.entries(CAL_CATS).forEach(([k, c]) => {
        const btn = document.createElement('button');
        btn.className    = 'cat-legend-item';
        btn.dataset.cat  = k;
        btn.onclick      = () => calSetCatFilter(k, btn);
        btn.innerHTML    = `<div class="cat-legend-dot" style="background:${c.color}"></div> ${c.name}`;
        bar.appendChild(btn);
    });
}

function calSetCatFilter(cat, btn) {
    _calCatFilter = cat;
    document
        .querySelectorAll(".cat-legend-item")
        .forEach((b) => b.classList.remove("active"));
    btn.classList.add("active");
    _renderGrid();
    _renderMonthEvents();
    _renderStats();
}

// ── Get reminders for calendar (uses history data, falls back to DB_REMINDERS)
function _getCalRems() {
    // Prefer history-based data injected from calenderView()
    if (window.CALENDAR_HISTORIES && window.CALENDAR_HISTORIES.length > 0) {
        return window.CALENDAR_HISTORIES.filter(r => r.dueDate); // exclude null dates
    }
    // Fallback to existing reminders array (reminder_date on reminder itself)
    return typeof getRems === 'function' ? getRems() : [];
}

function _getRems(y, m) {
    let rems = _getCalRems();
    rems = rems.filter((r) => {
        const d = new Date(r.dueDate);
        return d.getFullYear() === y && d.getMonth() === m;
    });
    if (_calCatFilter !== 'all')
        rems = rems.filter((r) => r.category === _calCatFilter);
    return rems;
}

function _getRemsDate(ds) {
    let rems = _getCalRems();
    rems = rems.filter((r) => r.dueDate === ds);
    if (_calCatFilter !== 'all')
        rems = rems.filter((r) => r.category === _calCatFilter);
    return rems;
}

function _pad(n) {
    return String(n).padStart(2, "0");
}

// ── Render all
function _renderAll() {
    _syncJumpSelects();
    document.getElementById("cal-label-v2").textContent =
        `${CAL_MONTHS[_calM]} ${_calY}`;
    _renderGrid();
    _renderMonthEvents();
    _renderStats();
}

// ── Render grid
function _renderGrid() {
    const grid = document.getElementById("cal-grid-v2");
    grid.innerHTML = "";
    const first = new Date(_calY, _calM, 1).getDay();
    const days = new Date(_calY, _calM + 1, 0).getDate();
    const tod = new Date();
    const toStr = `${tod.getFullYear()}-${_pad(tod.getMonth() + 1)}-${_pad(tod.getDate())}`;

    // Prev month filler cells
    const prevDays = new Date(_calY, _calM, 0).getDate();
    for (let i = 0; i < first; i++) {
        const dayNum = prevDays - first + i + 1;
        const cell = document.createElement("div");
        cell.className = "cal-cell-v2 cal-other-month";
        cell.innerHTML = `<div class="cal-day-num" style="opacity:.4">${dayNum}</div>`;
        grid.appendChild(cell);
    }

    // Current month cells
    for (let d = 1; d <= days; d++) {
        const ds = `${_calY}-${_pad(_calM + 1)}-${_pad(d)}`;
        const rems = _getRemsDate(ds);
        const isToday = ds === toStr;
        const hasRems = rems.length > 0;

        const cell = document.createElement("div");
        cell.className =
            "cal-cell-v2" +
            (isToday ? " cal-today-v2" : "") +
            (hasRems ? " has-reminders" : "");
        cell.setAttribute("data-date", ds);
        cell.onclick = (e) => {
            if (
                !e.target.classList.contains("cal-add-btn") &&
                !e.target.closest(".cal-add-btn")
            ) {
                _selectDay(d);
            }
        };

        // Day number
        let dayNumHTML;
        if (isToday) {
            dayNumHTML = `<div class="cal-day-num" style="display:flex;align-items:center;gap:4px;margin-bottom:5px">
                <span class="today-badge">${d}</span>
            </div>`;
        } else {
            dayNumHTML = `<div class="cal-day-num">${d}</div>`;
        }

        // Event chips (max 3 visible)
        const visible = rems.slice(0, 3);
        const overflow = rems.length - 3;
        let chipsHTML = visible
            .map((r) => {
                const cat = CAL_CATS[r.category] || {
                    color: "#94a3b8",
                    bg: "rgba(148,163,184,.15)",
                };
                const textCol = cat.color;
                return `<div class="cal-chip" style="background:${cat.bg};color:${textCol}" onclick="event.stopPropagation();_selectDay(${d})" title="${r.title}">
                <div class="cal-chip-dot" style="background:${cat.color}"></div>
                ${r.title.substring(0, 14)}${r.title.length > 14 ? "…" : ""}
            </div>`;
            })
            .join("");

        if (overflow > 0) {
            chipsHTML += `<div class="cal-more-pill" onclick="event.stopPropagation();_selectDay(${d})">+${overflow} more</div>`;
        }

        // Plus button
        const addBtn = `<div class="cal-add-btn" onclick="openReminderModal()" title="Add reminder"><i class="ri-add-line"></i></div>`;

        cell.innerHTML = dayNumHTML + chipsHTML + addBtn;
        grid.appendChild(cell);
    }

    // Next month filler
    const totalCells = first + days;
    const remaining = totalCells % 7 === 0 ? 0 : 7 - (totalCells % 7);
    for (let i = 1; i <= remaining; i++) {
        const cell = document.createElement("div");
        cell.className = "cal-cell-v2 cal-other-month";
        cell.innerHTML = `<div class="cal-day-num" style="opacity:.4">${i}</div>`;
        grid.appendChild(cell);
    }
}

// ── Select day
function _selectDay(d) {
    const ds = `${_calY}-${_pad(_calM + 1)}-${_pad(d)}`;
    _selDay = ds;
    window._selDay = ds;

    // Highlight cell
    document
        .querySelectorAll(".cal-cell-v2")
        .forEach((c) => (c.style.outline = ""));
    const target = document.querySelector(`[data-date="${ds}"]`);
    if (target) target.style.outline = "2px solid rgba(124,58,237,.6)";

    // Update panel title
    const dateObj = new Date(_calY, _calM, d);
    const dayName = dateObj.toLocaleDateString("en-GB", { weekday: "long" });
    document.getElementById("sel-day-title-v2").textContent =
        `${dayName}, ${d} ${CAL_MONTHS_SHORT[_calM]}`;
    document.getElementById("sel-day-add-btn").style.display = "flex";

    // Get all rems for this day (unfiltered for display)
    // let rems = typeof getRems === "function" ? getRems() : [];
    let rems = _getCalRems().filter((r) => r.dueDate === ds);
    rems = rems.filter((r) => r.dueDate === ds);

    const ev = document.getElementById("sel-day-events-v2");
    if (rems.length === 0) {
        ev.innerHTML = `<div style="text-align:center;padding:28px 0">
            <i class="ri-calendar-check-line" style="font-size:1.8rem;color:rgba(124,58,237,.25);display:block;margin-bottom:8px"></i>
            <p style="font-size:.79rem;color:#64748b;margin-bottom:12px">No reminders on this day</p>
            <button class="btn btn-primary btn-xs" onclick="openReminderModal()" style="padding:7px 14px !important;font-size:.78rem"><i class="ri-add-line"></i> Add Reminder</button>
        </div>`;
        return;
    }

    ev.innerHTML = rems
        .map((r) => {
            const cat = CAL_CATS[r.category] || {
                color: "#94a3b8",
                bg: "rgba(148,163,184,.12)",
                icon: "ri-alarm-line",
            };
            const daysLeft =
                typeof daysUntil === "function" ? daysUntil(r.dueDate) : 0;
            let pill = "";
            if (r.status === "completed") {
                pill = `<span class="pill-done" style="font-size:.62rem">Done</span>`;
            } else if (daysLeft < 0) {
                pill = `<span class="pill-urgent" style="font-size:.62rem">Overdue</span>`;
            } else if (daysLeft === 0) {
                pill = `<span class="pill-urgent" style="font-size:.62rem">Today</span>`;
            } else if (daysLeft <= 7) {
                pill = `<span class="pill-soon" style="font-size:.62rem">In ${daysLeft}d</span>`;
            } else {
                pill = `<span class="pill-ok" style="font-size:.62rem">In ${daysLeft}d</span>`;
            }

            return `<div class="day-ev-card">
            <div style="display:flex;align-items:flex-start;gap:8px">
                <div style="width:28px;height:28px;border-radius:7px;background:${cat.bg};display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <i class="${cat.icon}" style="color:${cat.color};font-size:.8rem"></i>
                </div>
                <div style="flex:1;min-width:0">
                    <div style="font-size:.83rem;font-weight:600;color:#f1f5f9;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${r.title}</div>
                    <div style="font-size:.7rem;color:#64748b;margin-top:1px">${cat.name}${r.dueTime ? " · " + r.dueTime : ""}</div>
                </div>
                ${pill}
            </div>
            ${r.provider ? `<div style="font-size:.72rem;color:#64748b;margin-top:6px;display:flex;align-items:center;gap:4px"><i class="ri-building-line"></i> ${r.provider}${r.cost ? " · £" + r.cost : ""}</div>` : ""}
            <div style="display:flex;gap:5px;margin-top:8px">
                <button class="btn btn-ghost btn-xs" onclick="openReminderModal()" style="padding:4px 8px !important;font-size:.7rem"><i class="ri-pencil-line"></i> Edit</button>
            </div>
        </div>`;
        })
        .join("");
}

// ── Month events list
function _renderMonthEvents() {
    const rems = _getRems(_calY, _calM).sort(
        (a, b) => new Date(a.dueDate) - new Date(b.dueDate),
    );
    document.getElementById("month-ev-cnt-v2").textContent = rems.length;
    const list = document.getElementById("month-events-v2");
    if (rems.length === 0) {
        list.innerHTML = `<div style="text-align:center;padding:24px;color:#64748b;font-size:.79rem">No reminders this month</div>`;
        return;
    }
    list.innerHTML = rems
        .map((r) => {
            const cat = CAL_CATS[r.category] || {
                color: "#94a3b8",
                bg: "rgba(148,163,184,.12)",
                icon: "ri-alarm-line",
                name: "Other",
            };
            const dp =
                r.status === "completed"
                    ? '<span class="pill-done" style="font-size:.58rem">Done</span>'
                    : (() => {
                          const n =
                              typeof daysUntil === "function"
                                  ? daysUntil(r.dueDate)
                                  : 0;
                          return n < 0
                              ? '<span class="pill-urgent" style="font-size:.58rem">Overdue</span>'
                              : n <= 7
                                ? `<span class="pill-soon" style="font-size:.58rem">In ${n}d</span>`
                                : `<span class="pill-ok" style="font-size:.58rem">In ${n}d</span>`;
                      })();
            const dayNum = parseInt(r.dueDate.split("-")[2]);
            return `<div class="month-ev-item" onclick="_selectDay(${dayNum})">
            <div style="width:7px;height:7px;border-radius:50%;background:${cat.color};flex-shrink:0"></div>
            <div style="flex:1;min-width:0">
                <div style="font-size:.78rem;font-weight:600;color:#94a3b8;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${r.title}</div>
                <div style="font-size:.67rem;color:#64748b">${typeof fmtDate === "function" ? fmtDate(r.dueDate) : r.dueDate} · ${cat.name}</div>
            </div>
            ${dp}
        </div>`;
        })
        .join("");
}

// ── Stats
function _renderStats() {
    // const allRems = (typeof getRems === "function" ? getRems() : []).filter(
    //     (r) => {
    //         const d = new Date(r.dueDate);
    //         return d.getFullYear() === _calY && d.getMonth() === _calM;
    //     },
    // );
    const allRems = _getCalRems().filter((r) => {
    const d = new Date(r.dueDate);
    return d.getFullYear() === _calY && d.getMonth() === _calM;
});
    const filtered =
        _calCatFilter === "all"
            ? allRems
            : allRems.filter((r) => r.category === _calCatFilter);
    const active = filtered.filter((r) => r.status === "active");
    const done = filtered.filter((r) => r.status === "completed");
    const overdue = active.filter(
        (r) => (typeof daysUntil === "function" ? daysUntil(r.dueDate) : 0) < 0,
    );
    const upcoming = active.filter((r) => {
        const n = typeof daysUntil === "function" ? daysUntil(r.dueDate) : 0;
        return n >= 0 && n <= 7;
    });

    const stats = [
        { num: filtered.length, lbl: "Total", color: "#a78bfa" },
        { num: active.length, lbl: "Active", color: "#14b8a6" },
        { num: upcoming.length, lbl: "This Week", color: "#f59e0b" },
        { num: overdue.length, lbl: "Overdue", color: "#f43f5e" },
        { num: done.length, lbl: "Done", color: "#10b981" },
    ];
    const row = document.getElementById("cal-stats-row");
    row.innerHTML = stats
        .map(
            (s) => `
        <div class="cal-stat">
            <div class="cal-stat-num" style="color:${s.color}">${s.num}</div>
            <div class="cal-stat-lbl">${s.lbl}</div>
        </div>
    `,
        )
        .join("");
}

// ── Export
function calExport() {
    if (typeof toast === "function")
        toast(
            "Calendar exported for " + CAL_MONTHS[_calM] + " " + _calY + "!",
            "success",
        );
}

// ═══════════════════════════════════════════════════════
// QUICK CREATE POPUP
// ═══════════════════════════════════════════════════════
function openQuickCreate(dateStr) {
    // Populate category select
    const catSel = document.getElementById("qc-cat");
    catSel.innerHTML = '<option value="">Select…</option>';
    if (typeof CATS !== "undefined") {
        Object.entries(CATS).forEach(([k, c]) => {
            catSel.innerHTML += `<option value="${k}">${c.name}</option>`;
        });
    } else {
        Object.entries(CAL_CATS).forEach(([k, c]) => {
            catSel.innerHTML += `<option value="${k}">${c.name}</option>`;
        });
    }
    document.getElementById("qc-sub").innerHTML =
        '<option value="">Select category…</option>';
    document.getElementById("qc-sub").disabled = true;

    // Set date
    const ds =
        dateStr ||
        (() => {
            const t = new Date();
            return `${t.getFullYear()}-${_pad(t.getMonth() + 1)}-${_pad(t.getDate())}`;
        })();
    document.getElementById("qc-date").value = ds;
    document.getElementById("qc-time").value = "09:00";
    document.getElementById("qc-title").value = "";
    document.getElementById("qc-desc").value = "";

    // Date label
    if (ds) {
        const [y, m, d] = ds.split("-");
        document.getElementById("qc-date-label").textContent =
            `${parseInt(d)} ${CAL_MONTHS[parseInt(m) - 1]} ${y}`;
    } else {
        document.getElementById("qc-date-label").textContent = "";
    }

    document.getElementById("qc-overlay").classList.add("open");
    document.body.style.overflow = "hidden";
    setTimeout(() => document.getElementById("qc-title").focus(), 300);
}

function closeQuickCreate() {
    document.getElementById("qc-overlay").classList.remove("open");
    document.body.style.overflow = "";
}

function qcUpdateSubs() {
    const cat = document.getElementById("qc-cat").value;
    const sub = document.getElementById("qc-sub");
    sub.innerHTML = '<option value="">Select subcategory…</option>';
    const catData = typeof CATS !== "undefined" ? CATS[cat] : null;
    if (cat && catData) {
        catData.subs.forEach((s) => {
            sub.innerHTML += `<option value="${s}">${s}</option>`;
        });
        sub.disabled = false;
    } else {
        sub.disabled = true;
    }
}

function qcSubmit(e) {
    e.preventDefault();
    const title = document.getElementById("qc-title").value.trim();
    const cat = document.getElementById("qc-cat").value;
    const sub = document.getElementById("qc-sub").value;
    const date = document.getElementById("qc-date").value;
    const time = document.getElementById("qc-time").value;
    const desc = document.getElementById("qc-desc").value.trim();

    if (title.length < 3) {
        if (typeof toast === "function")
            toast("Title must be at least 3 characters", "error");
        return;
    }
    if (!cat) {
        if (typeof toast === "function")
            toast("Please select a category", "error");
        return;
    }
    if (!sub) {
        if (typeof toast === "function")
            toast("Please select a subcategory", "error");
        return;
    }
    if (!date) {
        if (typeof toast === "function") toast("Please select a date", "error");
        return;
    }

    if (typeof getRems === "function" && typeof saveRems === "function") {
        const rems = getRems();
        const newRem = {
            id:
                "r_" +
                Date.now() +
                "_" +
                Math.random().toString(36).substr(2, 6),
            title,
            category: cat,
            subcategory: sub,
            dueDate: date,
            dueTime: time,
            description: desc,
            status: "active",
            createdAt: new Date().toISOString(),
        };
        rems.push(newRem);
        saveRems(rems);
        if (typeof toast === "function")
            toast("Reminder created! 🎉", "success");
    } else {
        if (typeof toast === "function") toast("Reminder saved!", "success");
    }

    closeQuickCreate();
    _renderAll();
    // Re-select day if one was selected
    if (_selDay) {
        const dayNum = parseInt(_selDay.split("-")[2]);
        setTimeout(() => _selectDay(dayNum), 100);
    }
}

// ── Boot on DOMContentLoaded or immediately
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initCalendarV2);
} else {
    // Already loaded — wait for user.js globals
    setTimeout(initCalendarV2, 120);
}

// Also expose for the go() router in user.js
window.initCalendar = initCalendarV2;

// ============================================================
// TEMPLATES
// ============================================================
function renderTemplates() {
    const q = (
        document.getElementById("tmpl-search")?.value || ""
    ).toLowerCase();
    const cf = document.getElementById("tmpl-cat")?.value || "";
    let items = TEMPLATES.filter(
        (t) =>
            (!q || t.title.toLowerCase().includes(q)) && (!cf || t.cat === cf),
    );
    const pop = items.filter((t) => t.pop >= 150),
        rest = items.filter((t) => t.pop < 150);
    let html = "";
    if (pop.length)
        html += `<div style="margin-bottom:22px"><div style="display:flex;align-items:center;gap:8px;margin-bottom:10px"><i class="ri-fire-fill" style="color:#f43f5e"></i><h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9">Popular Templates</h3></div><div style="display:flex;flex-direction:column;gap:8px">${pop.map(tmplCard).join("")}</div></div>`;
    if (rest.length)
        html += `<div><div style="display:flex;align-items:center;gap:8px;margin-bottom:10px"><i class="ri-file-list-3-line" style="color:#a78bfa"></i><h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9">All Templates</h3></div><div style="display:flex;flex-direction:column;gap:8px">${rest.map(tmplCard).join("")}</div></div>`;
    if (!html)
        html =
            '<div style="text-align:center;padding:50px;color:#475569">No templates found for your search</div>';
    document.getElementById("tmpl-container").innerHTML = html;
}

function tmplCard(t) {
    return `<div class="tmpl-card" onclick="useTemplate('${t.id}')">
<div class="cat-ico" style="background:${t.bg}"><i class="${t.icon}" style="color:${t.col}"></i></div>
<div style="flex:1"><div style="font-weight:600;font-size:.87rem;color:#f1f5f9">${t.title}</div><div style="font-size:.75rem;color:#64748b;margin-top:2px">${CATS[t.cat]?.name || t.cat}${t.freq ? " · " + t.freq : ""}</div></div>
<div style="font-size:.75rem;color:#64748b;flex-shrink:0"><i class="ri-fire-line" style="color:#f59e0b"></i> ${t.pop}</div>
<i class="ri-arrow-right-circle-line" style="color:rgba(100,116,139,.4);flex-shrink:0"></i>
</div>`;
}

function filterTemplates() {
    renderTemplates();
}

function useTemplate(id) {
    const t = TEMPLATES.find((x) => x.id === id);
    if (!t) return;
    editingId = null;
    go("create");
    setTimeout(() => {
        document.getElementById("r-title").value = t.title;
        document.getElementById("r-cat").value = t.cat;
        updateSubs();
        setTimeout(() => {
            document.getElementById("r-sub").value = t.sub;
            if (t.freq) document.getElementById("r-freq").value = t.freq;
        }, 80);
    }, 60);
    toast("Template loaded!", "success");
}

// ============================================================
// CATEGORIES
// ============================================================

// function renderCategories() {
//     updateCustomSubUI();
//     const rems = getRems();
//     let mostUsed = '—';
//     let maxC = 0;
//     Object.entries(CATS).forEach(([k]) => {
//         const cnt = rems.filter(r => r.category === k).length;
//         if (cnt > maxC) {
//             maxC = cnt;
//             mostUsed = CATS[k].name;
//         }
//     });
//     document.getElementById('most-used-cat').textContent = mostUsed;
//     const grid = document.getElementById('cat-grid');
//     grid.innerHTML = '';
//     Object.entries(CATS).forEach(([k, c]) => {
//         const count = rems.filter(r => r.category === k).length;
//         const total = Math.max(rems.length, 1);
//         const pct = Math.min((count / total) * 100 * 5, 100);
//         const div = document.createElement('div');
//         div.className = 'cat-card';
//         div.onclick = () => expandCat(k);
//         div.innerHTML = `<div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:12px">
// <div style="display:flex;align-items:center;gap:10px">
// <div class="cat-ico" style="background:${c.bg}"><i class="${c.icon}" style="color:${c.color}"></i></div>
// <div><div class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9">${c.name}</div><div style="font-size:.72rem;color:#64748b">${c.subs.length+(customSubs.filter(cs=>cs.parent===k).length)} subcategories</div></div>
// </div>
// <button class="btn btn-ghost btn-xs" onclick="event.stopPropagation();document.getElementById('sub-cat-parent').value='${k}';openModal('add-sub-modal')"><i class="ri-add-line"></i></button>
// </div>
// <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px"><span style="font-size:.73rem;color:#64748b">Reminders</span><span style="font-weight:700;font-size:.87rem;color:#f1f5f9">${count}</span></div>
// <div class="prog-track"><div class="prog-fill" style="width:${pct}%"></div></div>`;
//         grid.appendChild(div);
//     });
// }

// function renderCategories() {
//     updateCustomSubUI();
//     const rems = getRems();
//     let mostUsed = '—';
//     let maxC = 0;
//     Object.entries(CATS).forEach(([k]) => {
//     const cnt = rems.filter(r => String(r.category) === String(k)).length;
//         if (cnt > maxC) {
//             maxC = cnt;
//             mostUsed = CATS[k].name;
//         }
//     });
//     document.getElementById('most-used-cat').textContent = mostUsed;
//     const grid = document.getElementById('cat-grid');
//     grid.innerHTML = '';
//     Object.entries(CATS).forEach(([k, c]) => {
//         const count = rems.filter(r => r.category === k).length;
//         const total = Math.max(rems.length, 1);
//         const pct = Math.min((count / total) * 100 * 5, 100);
//         const div = document.createElement('div');
//         div.className = 'cat-card';
//         div.onclick = () => expandCat(k);
//         div.innerHTML = `<div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:12px">
// <div style="display:flex;align-items:center;gap:10px">
// <div class="cat-ico" style="background:${c.bg}"><i class="${c.icon}" style="color:${c.color}"></i></div>
// <div><div class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9">${c.name}</div><div style="font-size:.72rem;color:#64748b">${c.subs.length+(customSubs.filter(cs=>cs.parent===k).length)} subcategories</div></div>
// </div>
// <button class="btn btn-ghost btn-xs" onclick="event.stopPropagation();document.getElementById('sub-cat-parent').value='${k}';openModal('add-sub-modal')"><i class="ri-add-line"></i></button>
// </div>
// <div style="background:${c.bg};border-radius:10px;padding:2px 14px;display:flex;align-items:center;justify-content:space-between;margin-bottom:6px"><span style="font-size:.73rem;color:#64748b">Reminders</span><span style="background: #fff;padding: 0 8px;border-radius: 50%;font-weight:700;font-size:.87rem;color:#f1f5f9">${count}</span></div>
// <div class="prog-track hidden"><div class="prog-fill" style="width:${pct}%"></div></div>`;
//         grid.appendChild(div);
//     });
// }

function renderCategories() {
    console.log("[Category] renderCategories start", {
        CATS: CATS,
        customSubs: customSubs,
        currentPage: "categories",
    });
    updateCustomSubUI();
    const rems = getRems();

    // 🔥 FIX: use String() comparison for mostUsed
    let mostUsed = "—";
    let maxC = 0;
    Object.entries(CATS).forEach(([k]) => {
        const cnt = rems.filter((r) => String(r.category) === String(k)).length;
        if (cnt > maxC) {
            maxC = cnt;
            mostUsed = CATS[k].name;
        }
    });
    document.getElementById("most-used-cat").textContent = mostUsed;

    const grid = document.getElementById("cat-grid");
    grid.innerHTML = "";

    Object.entries(CATS).forEach(([k, c]) => {
        // 🔥 FIX: use String() comparison for count
        const count = rems.filter(
            (r) => String(r.category) === String(k),
        ).length;

        const total = Math.max(rems.length, 1);
        const pct = Math.min((count / total) * 100 * 5, 100);

        const div = document.createElement("div");
        div.className = "cat-card";
        div.onclick = () => expandCat(k);

        // 🔥 Use the server-provided category subcount only; local storage may duplicate backend items
        const subcategoryCount = c.subs.length;

        div.innerHTML = `
            <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:12px">
                <div style="display:flex;align-items:center;gap:10px">
                    <div class="cat-ico" style="background:${c.bg}">
                        <i class="${c.icon}" style="color:${c.color}"></i>
                    </div>
                    <div>
                        <div class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9">
                            ${c.name}
                        </div>
                        <div style="font-size:.72rem;color:#64748b">
                            ${subcategoryCount} subcategories
                        </div>
                    </div>
                </div>
                <button class="btn btn-ghost btn-xs"
                    onclick="event.stopPropagation();openAddSubModal('${k}')">
                    <i class="ri-add-line"></i>
                </button>
            </div>
            <div style="background:${c.bg};border-radius:10px;padding:2px 14px;display:flex;align-items:center;justify-content:space-between;margin-bottom:6px">
                <span style="font-size:.73rem;color:#64748b">Reminders</span>
                <span style="background:#fff;padding:0 8px;border-radius:50%;font-weight:700;font-size:.87rem;color:#1e293b">
                    ${count}
                </span>
            </div>
            <div class="prog-track hidden">
                <div class="prog-fill" style="width:${pct}%"></div>
            </div>`;

        grid.appendChild(div);
    });
}

function openAddSubModal(categoryId = "") {
    document.getElementById("sub-cat-name").value = "";

    document.getElementById("sub-cat-desc").value = "";

    document
        .querySelectorAll("#add-sub-modal .error-text")
        .forEach((el) => (el.innerText = ""));

    openModal("add-sub-modal");

    // 🔥 FIX FOR TOMSELECT
    setTimeout(() => {
        const select = document.getElementById("sub-cat-parent");

        if (select.tomselect) {
            select.tomselect.setValue(categoryId);
        } else {
            select.value = categoryId;
        }
    }, 50);
}

// function updateCustomSubUI() {
//     document.getElementById('custom-sub-count').textContent = customSubs.length;
//     document.getElementById('custom-sub-badge').textContent = customSubs.length + ' Custom';
//     const list = document.getElementById('custom-sub-list');
//     if (customSubs.length === 0) {
//         list.innerHTML = '<div style="text-align:center;padding:24px;color:#475569;font-size:.82rem">No custom subcategories yet. Add one above!</div>';
//         return;
//     }
//     list.innerHTML = customSubs.map((cs, i) => `<div style="display:flex;align-items:center;justify-content:space-between;padding:11px 12px;border-radius:10px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06)">
// <div style="display:flex;align-items:center;gap:10px">
// <div style="width:30px;height:30px;border-radius:8px;background:${CATS[cs.parent]?.bg||'rgba(148,163,184,.12)'};display:flex;align-items:center;justify-content:center"><i class="${CATS[cs.parent]?.icon||'ri-folder-line'}" style="color:${CATS[cs.parent]?.color||'#94a3b8'};font-size:.85rem"></i></div>
// <div><div style="font-size:.85rem;font-weight:600;color:#94a3b8">${cs.name}</div><div style="font-size:.73rem;color:#64748b">${CATS[cs.parent]?.name||cs.parent}${cs.desc?' · '+cs.desc:''}</div></div>
// </div>
// <div style="display:flex;gap:6px">
// <button class="btn btn-ghost btn-xs" onclick="toast('Edit mode coming soon','info')"><i class="ri-pencil-line"></i></button>
// <button class="btn btn-danger btn-xs" onclick="deleteCustomSub(${i})"><i class="ri-delete-bin-line"></i></button>
// </div>
// </div>`).join('');
// }

function updateCustomSubUI() {
    const list = document.getElementById("custom-sub-list");

    console.log("[Category] updateCustomSubUI start", {
        CATS: typeof CATS !== "undefined" ? CATS : null,
        CUSTOM_SUB_COUNT: window.CUSTOM_SUB_COUNT,
        CURRENT_USER_ID: window.CURRENT_USER_ID,
        listElement: list,
    });

    let dbSubs = [];

    // 🔥 FETCH FROM DB CATEGORIES WHEN AVAILABLE
    if (typeof CATS !== "undefined" && CATS) {
        Object.entries(CATS).forEach(([catId, cat]) => {
            if (!cat.subs || !cat.subs.length) {
                return;
            }

            cat.subs.forEach((sub) => {
                if (sub.role !== "user") {
                    return;
                }

                if (
                    typeof window.CURRENT_USER_ID !== "undefined" &&
                    sub.created_by !== window.CURRENT_USER_ID
                ) {
                    return;
                }

                dbSubs.push({
                    id: sub.id,
                    parent: catId,
                    name: sub.name,
                    desc: sub.description || "",
                });
            });
        });
    }

    console.log("[Category] updateCustomSubUI built dbSubs", dbSubs);

    const customCount =
        typeof window.CUSTOM_SUB_COUNT !== "undefined"
            ? Number(window.CUSTOM_SUB_COUNT)
            : dbSubs.length;

    console.log("[Category] updateCustomSubUI customCount", customCount);

    document.getElementById("custom-sub-count").textContent = customCount;

    document.getElementById("custom-sub-badge").textContent =
        customCount + " Custom";

    // 🔥 EMPTY
    if (dbSubs.length === 0) {
        list.innerHTML = `
            <div style="
                text-align:center;
                padding:24px;
                color:#475569;
                font-size:.82rem
            ">
                No custom subcategories yet.
                Add one above!
            </div>
        `;

        return;
    }

    // 🔥 SAME UI
    list.innerHTML = dbSubs
        .map(
            (cs, i) => `

        <div style="
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:11px 12px;
            border-radius:10px;
            background:rgba(255,255,255,.03);
            border:1px solid rgba(255,255,255,.06)
        ">

            <div style="
                display:flex;
                align-items:center;
                gap:10px
            ">

                <div style="
                    width:30px;
                    height:30px;
                    border-radius:8px;
                    background:${CATS[cs.parent]?.bg || "rgba(148,163,184,.12)"};
                    display:flex;
                    align-items:center;
                    justify-content:center
                ">
                    <i class="${CATS[cs.parent]?.icon || "ri-folder-line"}"
                       style="
                           color:${CATS[cs.parent]?.color || "#94a3b8"};
                           font-size:.85rem
                       ">
                    </i>
                </div>

                <div>

                   <div style="
    font-size:.85rem;
    font-weight:600;
    color:#94a3b8
">
    ${cs.desc || "No Description"}
</div>

                    <div style="
                        font-size:.73rem;
                        color:#64748b
                    ">
                        ${CATS[cs.parent]?.name || cs.parent}
                        -> 
                        ${cs.name}
                        ${cs.desc ? " · " + cs.desc : ""}
                    </div>

                </div>

            </div>

            <div style="display:flex;gap:6px">

                <button class="btn btn-ghost btn-xs"
                    onclick='openEditSubModal(${JSON.stringify(cs)})'>

                    <i class="ri-pencil-line"></i>

                </button>

                <button class="btn btn-danger btn-xs"
                    onclick="deleteCustomSub(${cs.id})">

                    <i class="ri-delete-bin-line"></i>

                </button>

            </div>

        </div>

    `,
        )
        .join("");
}

function openEditSubModal(cs) {
    document.getElementById("edit-sub-id").value = cs.id;

    document.getElementById("edit-sub-parent").value = cs.parent;

    document.getElementById("edit-sub-name").value = cs.name;

    document.getElementById("edit-sub-desc").value = cs.desc;

    openModal("edit-sub-modal");
}

async function updateSubcategory() {
    document
        .querySelectorAll("#edit-sub-modal .error-text")
        .forEach((el) => (el.innerText = ""));

    const id = document.getElementById("edit-sub-id").value;

    const data = {
        category_id: document.getElementById("edit-sub-parent").value,
        name: document.getElementById("edit-sub-name").value,
        description: document.getElementById("edit-sub-desc").value,
    };

    try {
        const res = await fetch(`/user/update-subcategory/${id}`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]',
                ).content,
                Accept: "application/json",
            },
            body: JSON.stringify(data),
        });

        const result = await res.json();

        if (res.status === 422) {
            Object.keys(result.errors).forEach((field) => {
                const el = document.getElementById("edit-err-" + field);

                if (el) {
                    el.innerText = result.errors[field][0];
                }
            });

            return;
        }

        if (!res.ok) {
            toast(result.message, "error");
            return;
        }

        toast(result.message, "success");

        closeModal("edit-sub-modal");

        setTimeout(() => {
            location.reload();
        }, 800);
    } catch (err) {
        console.log(err);

        toast("Something went wrong", "error");
    }
}

function clearEditError(inputId, errorId, eventType = "input") {
    const input = document.getElementById(inputId);
    const error = document.getElementById(errorId);

    if (!input || !error) return;

    input.addEventListener(eventType, function () {
        error.innerText = "";
    });
}

clearEditError("edit-sub-parent", "edit-err-category_id", "change");
clearEditError("edit-sub-name", "edit-err-name");
clearEditError("edit-sub-desc", "edit-err-description");

async function deleteCustomSub(id) {
    confirm_act("Delete this custom subcategory?", async () => {
        try {
            const res = await fetch(`/user/delete-subcategory/${id}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]',
                    ).content,

                    Accept: "application/json",
                },
            });
            const result = await res.json();
            if (!res.ok) {
                toast(result.message, "error");
                return;
            }
            toast(result.message, "success");
            // 🔥 reload page
            setTimeout(() => {
                location.reload();
            }, 800);
        } catch (err) {
            console.log(err);
            toast("Something went wrong", "error");
        }
    });
}

function expandCat(k) {
    const c = CATS[k];
    if (!c) return;
    const rems = getRems().filter((r) => String(r.category) === String(k));
    const html =
        rems.length === 0
            ? '<div style="text-align:center;padding:24px;color:#475569;font-size:.82rem">No reminders in this category</div>'
            : rems
                  .map((r) => {
                      const dp =
                          r.status === "completed"
                              ? '<span class="pill-done" style="font-size:.65rem">Done</span>'
                              : duePill(r.dueDate);
                      return `<div style="display:flex;align-items:center;gap:10px;padding:10px;border-radius:10px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.05);margin-bottom:6px"><div style="flex:1"><div style="font-size:.87rem;font-weight:600;color:#94a3b8">${r.title}</div><div style="font-size:.75rem;color:#64748b">${r.subcategory}${r.dueDate ? " · " + fmtDate(r.dueDate) : ""}</div></div>${dp}</div>`;
                  })
                  .join("");
    document.getElementById("detail-content").innerHTML =
        `<div style="display:flex;align-items:center;gap:12px;margin-bottom:16px"><div class="cat-ico" style="background:${c.bg}"><i class="${c.icon}" style="color:${c.color}"></i></div><div><div class="font-jakarta" style="font-weight:700;font-size:.95rem;color:#f1f5f9">${c.name}</div><div style="font-size:.77rem;color:#64748b">${rems.length} reminder${rems.length !== 1 ? "s" : ""}</div></div></div>${html}<div style="margin-top:14px"></div>`;
    openModal("detail-modal");
}

// ============================================================
// ANALYTICS CHARTS
// ============================================================
let charts = {};

function initCharts() {

    const isDark = document.documentElement.classList.contains("dark");

    const tc = isDark
        ? "rgba(255,255,255,.3)"
        : "rgba(0,0,0,.4)";

    const gc = isDark
        ? "rgba(255,255,255,.05)"
        : "rgba(0,0,0,.05)";

    Object.values(charts).forEach((c) => {
        try {
            c.destroy();
        } catch (e) {}
    });

    charts = {};

    const baseOpts = (extra = {}) => ({
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                labels: {
                    color: tc,
                    font: {
                        family: "DM Sans",
                        size: 11,
                    },
                },
            },
        },
        ...extra,
        scales: {
            x: {
                grid: {
                    color: gc,
                },
                ticks: {
                    color: tc,
                },
            },
            y: {
                grid: {
                    color: gc,
                },
                ticks: {
                    color: tc,
                },
            },
        },
    });

    // Activity Chart
    const ac = document.getElementById("act-trend-chart");

    if (ac)
        charts.act = new Chart(ac, {
            type: "line",
            data: {
                labels: analyticsData.activityLabels,
                datasets: [
                    {
                        label: "Created",
                        data: analyticsData.createdData,
                        borderColor: "#7c3aed",
                        backgroundColor: "rgba(124,58,237,.12)",
                        fill: true,
                        tension: 0.4,
                    },
                    {
                        label: "Completed",
                        data: analyticsData.completedData,
                        borderColor: "#10b981",
                        backgroundColor: "rgba(16,185,129,.08)",
                        fill: true,
                        tension: 0.4,
                    },
                ],
            },
            options: baseOpts(),
        });

    // Category Chart
    const cc = document.getElementById("cat-dist-chart");

    if (cc)
        charts.cat = new Chart(cc, {
            type: "doughnut",
            data: {
                labels: analyticsData.categoryLabels,
                datasets: [{
                    data: analyticsData.categoryTotals,
                    backgroundColor: [
                        "#14b8a6",
                        "#f43f5e",
                        "#a78bfa",
                        "#10b981",
                        "#f59e0b",
                        "#94a3b8",
                    ],
                    borderWidth: 0,
                }],
            },
            options: {
                plugins: {
                    legend: {
                        position: "right",
                        labels: {
                            color: tc,
                        },
                    },
                },
                cutout: "65%",
                maintainAspectRatio: false,
            },
        });

    // Completion Chart
    const cs = document.getElementById("comp-chart");

    if (cs)
        charts.comp = new Chart(cs, {
            type: "doughnut",
            data: {
                labels: ["Completed", "Pending"],
                datasets: [{
                    data: analyticsData.completionChart,
                    backgroundColor: ["#10b981", "#f43f5e"],
                    borderWidth: 0,
                }],
            },
            options: {
                plugins: {
                    legend: {
                        position: "bottom",
                        labels: {
                            color: tc,
                        },
                    },
                },
                cutout: "60%",
                maintainAspectRatio: false,
            },
        });

    // Monthly Spending
    const sc = document.getElementById("spend-chart");

    if (sc)
        charts.spend = new Chart(sc, {
            type: "bar",
            data: {
                labels: [
                    "Jan","Feb","Mar","Apr","May","Jun",
                    "Jul","Aug","Sep","Oct","Nov","Dec"
                ],
                datasets: [{
                    label: "£",
                    data: analyticsData.monthlySpending,
                    backgroundColor: "rgba(124,58,237,.7)",
                    borderRadius: 6,
                }],
            },
            options: baseOpts({
                plugins: {
                    legend: {
                        display: false,
                    },
                },
            }),
        });
}

const originalAnalyticsData =
    typeof analyticsData !== "undefined"
        ? JSON.parse(JSON.stringify(analyticsData))
        : null;

function setPeriod(btn, days) {

    if (typeof analyticsData === "undefined") {
        return;
    }

    document
        .querySelectorAll(".period-btn")
        .forEach((b) => b.classList.remove("active"));

    btn.classList.add("active");

    window.location.href =
        `/user-analytics?days=${days}`;
}

// ============================================================
// HELP
// ============================================================

function renderFAQs(q = "") {
    const cats = [...new Set(FAQS.map((f) => f.cat))];
    let html = "";
    cats.forEach((cat) => {
        const items = FAQS.filter(
            (f) =>
                f.cat === cat &&
                (!q || (f.q + f.a).toLowerCase().includes(q.toLowerCase())),
        );
        if (!items.length) return;
        html += `<div style="display:inline-flex;align-items:center;padding:3px 10px;border-radius:6px;background:rgba(124,58,237,.1);border:1px solid rgba(124,58,237,.2);margin:12px 0 6px"><span style="font-size:.63rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#a78bfa">${cat}</span></div>`;
        items.forEach((f, i) => {
            html += `<div class="faq-item"><div class="faq-q" onclick="toggleFaq(this)"><div style="display:flex;align-items:center;gap:8px;flex:1"><i class="ri-question-line" style="color:#a78bfa;flex-shrink:0"></i>${f.q}</div><i class="ri-arrow-down-s-line faq-arrow" style="color:#64748b"></i></div><div class="faq-ans">${f.a}</div></div>`;
        });
    });
    document.getElementById("faq-container").innerHTML =
        html ||
        '<div style="text-align:center;padding:30px;color:#475569;font-size:.82rem">No results found for your search</div>';
}

function toggleFaq(el) {
    const item = el.closest(".faq-item");
    const isOpen = item.classList.contains("open");
    document
        .querySelectorAll(".faq-item.open")
        .forEach((x) => x.classList.remove("open"));
    if (!isOpen) item.classList.add("open");
}

function filterFaq(v) {
    renderFAQs(v);
}

// ============================================================
// SHARED
// ============================================================
function renderShared() {
    const rems = getRems()
        .filter((r) => r.status === "active")
        .slice(0, 5);
    document.getElementById("shared-by-me-cnt").textContent = rems.length;
    document.getElementById("shared-by-me-list").innerHTML =
        rems.length === 0
            ? '<div style="text-align:center;padding:40px;color:#475569;font-size:.82rem">No shared reminders yet</div>'
            : rems
                  .map((r) => {
                      const cat = CATS[r.category] || {
                          icon: "ri-alarm-line",
                          color: "#94a3b8",
                          bg: "rgba(148,163,184,.12)",
                          name: r.category,
                      };
                      return `<div class="card" style="padding:16px">
<div style="display:flex;align-items:flex-start;gap:12px">
<div class="cat-ico" style="background:${cat.bg};flex-shrink:0"><i class="${cat.icon}" style="color:${cat.color}"></i></div>
<div style="flex:1;min-width:0">
    <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-bottom:4px"><div class="font-jakarta" style="font-weight:600;font-size:.9rem;color:#f1f5f9">${r.title}</div></div>
    <div style="font-size:.77rem;color:#64748b;margin-bottom:10px">${cat.name} · ${fmtDate(r.dueDate)}</div>
    <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px"><span style="font-size:.75rem;color:#64748b">Shared with:</span><div style="display:flex;gap:4px"><div class="sav">SM</div><div class="sav">JW</div><div class="sav">EW</div></div></div>
    <div style="display:flex;gap:6px;flex-wrap:wrap">
    <button class="btn btn-danger btn-xs" onclick="toast('Share access revoked','info')"><i class="ri-close-circle-line"></i> Revoke</button>
    </div>
</div>
<div style="text-align:right;flex-shrink:0"><div style="font-size:.7rem;color:#64748b">Shared</div><div style="font-size:.75rem;font-weight:600;color:#64748b">Apr 12</div><div style="font-size:.72rem;color:#10b981;margin-top:2px"><i class="ri-checkbox-circle-fill"></i> Active</div></div>
</div>
</div>`;
                  })
                  .join("");
}

// ============================================================
// TAB SYSTEM
// ============================================================
function swTab(group, name, btn) {
    document
        .querySelectorAll(`[id^="${group}-tab-"]`)
        .forEach((p) => p.classList.remove("active"));
    document.getElementById(`${group}-tab-${name}`)?.classList.add("active");
    if (btn) {
        btn.closest('[style*="border-bottom"]')
            .querySelectorAll(".tab-btn")
            .forEach((b) => b.classList.remove("active"));
        btn.classList.add("active");
    }
}

// ============================================================
// MISC
// ============================================================

function clearNotifs() {
    confirm_act("Clear all notifications?", () => {
        document.getElementById("notif-list").innerHTML =
            '<div style="text-align:center;padding:24px;color:#475569;font-size:.83rem">No notifications</div>';
        document.getElementById("notif-count").style.display = "none";
        document.getElementById("notif-dot").style.display = "none";
        toast("All notifications cleared", "success");
    });
}

function submitFeedback(e) {
    e.preventDefault();
    const t = document.getElementById("fb-type").value;
    const s = document.getElementById("fb-subject").value.trim();
    const m = document.getElementById("fb-msg").value.trim();
    if (!t) {
        toast("Please select a feedback type", "error");
        return;
    }
    if (s.length < 5) {
        toast("Subject must be at least 5 characters", "error");
        return;
    }
    if (m.length < 10) {
        toast("Message must be at least 10 characters", "error");
        return;
    }
    toast(
        "Feedback submitted! Thank you for helping improve D-Remind 🎉",
        "success",
    );
    e.target.reset();
    document.getElementById("fb-len").textContent = "0";
}

function selPri(btn) {
    btn.closest('[style*="flex"]')
        .querySelectorAll(".pri-btn")
        .forEach((b) => b.classList.remove("sel"));
    btn.classList.add("sel");
}

function handleLogout() {
    confirm_act("Are you sure you want to logout?", () => {
        fetch(logoutUrl, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
        }).then(() => {
            toast("Logged out successfully", "success");
            setTimeout(() => {
                window.location.href = loginUrl;
            }, 1000);
        });
    });
}

// ============================================================
// INIT
// ============================================================
document.addEventListener("DOMContentLoaded", () => {
    initTheme();
    initSidebar();
    // initData();

    const un = S.get("user_name", "Kishore Rex");
    if (document.getElementById("user-name-sb")) {
        document.getElementById("user-name-sb").textContent = un;
    }
    if (document.getElementById("profile-display-name")) {
        document.getElementById("profile-display-name").textContent = un;
    }

    // Auto-detect current page and call the right init
    if (document.getElementById("page-dashboard")) initDash();
    if (document.getElementById("page-reminders")) {
        populateCatFilter();
        loadReminders();
    }
    if (document.getElementById("page-create")) initCreate();
    if (document.getElementById("page-calendar")) initCalendar();
    if (document.getElementById("page-templates")) renderTemplates();
    if (document.getElementById("page-categories")) renderCategories();
    if (document.getElementById("page-analytics")) initCharts();
    if (document.getElementById("page-help")) renderFAQs();
    if (document.getElementById("page-shared")) renderShared();
});

// Modal Open
function openReminderModal() {
    const modal = document.getElementById('reminder-modal');
    modal.style.display = 'flex';

    const catSelect = document.getElementById('r-cat');

    // 🔥 destroy old TomSelect
    if (catSelect.tomselect) {
        catSelect.tomselect.destroy();
    }

    // 🔥 clear options
    catSelect.innerHTML = '<option value="">Select category...</option>';

    // 🔥 populate categories
    Object.entries(CATS).forEach(([id, cat]) => {
        const option = document.createElement('option');
        option.value = id;
        option.textContent = cat.name;
        catSelect.appendChild(option);
    });

    // 🔥 TomSelect init
    const categorySelect = new TomSelect('#r-cat', {
        create: false,
        placeholder: 'Search category...',
        sortField: { field: 'text', direction: 'asc' }
    });

    // 🔥 move error div inside ts-wrapper
    const wrapper = document.querySelector('#r-cat').parentElement;
    if (wrapper && wrapper.classList.contains('ts-wrapper')) {
        wrapper.appendChild(document.getElementById('err-rem-category_id'));
    }

    // 🔥 clear error on change
    categorySelect.on('change', function () {
        document.getElementById('err-rem-category_id').innerText = '';
        updateSubs();
    });

    // 🔥 reset sub
    const sub = document.getElementById('r-sub');
    sub.innerHTML = '<option value="">Select category first...</option>';
    sub.disabled = true;

    // 🔥 clear all errors
    document.querySelectorAll('#reminder-modal .error-text')
        .forEach(el => el.innerText = '');

    // 🔥 EDIT MODE — populate fields
    if (editingId) {
        const r = getRems().find(x => String(x.id) === String(editingId));
        if (r) {
            // update modal title
            document.querySelector('#reminder-modal h2').textContent = 'Edit Reminder';
            document.getElementById('create-btn-txt').textContent = 'Save Changes';

            // set category in TomSelect
            categorySelect.setValue(String(r.category));

            // populate subcategories then select the right one
            updateSubs();
            setTimeout(() => {
                document.getElementById('r-sub').value = r.subcategory || '';
            }, 100);

            // populate other fields
            document.getElementById('r-title').value    = r.title || '';
            document.getElementById('r-date').value     = r.end_reminder_date || '';
            document.getElementById('r-time').value     = r.dueTime || '09:00';
            document.getElementById('r-desc').value     = r.description || '';
            document.getElementById('desc-len').textContent = (r.description || '').length;
            document.getElementById('r-provider').value = r.provider || '';
            document.getElementById('r-cost').value     = r.cost || '';
            document.getElementById('r-freq').value     = r.frequency || '';

            // show optional fields if they have values
            if (r.provider || r.cost || r.frequency) {
                document.getElementById('opt-fields').style.display = 'block';
            }
        }
    } else {
        // 🔥 CREATE MODE
        document.querySelector('#reminder-modal h2').textContent = 'Create New Reminder';
        document.getElementById('create-btn-txt').textContent = 'Create Reminder';
        document.getElementById('rem-form').reset();
        document.getElementById('desc-len').textContent = '0';
        document.getElementById('opt-fields').style.display = 'none';
    }
}

// Modal Close
function closeReminderModal() {
    document.getElementById('reminder-modal').style.display = 'none';
    document.body.style.overflow = '';
    document.getElementById('rem-form').reset();
    document.getElementById('desc-len').textContent = '0';

    // 🔥 reset editing state
    editingId = null;
    document.querySelector('#reminder-modal h2').textContent = 'Create New Reminder';
    document.getElementById('create-btn-txt').textContent = 'Create Reminder';
    document.getElementById('opt-fields').style.display = 'none';
}

// Close on outside click
// document.addEventListener('click', function(e) {
//     const modal = document.getElementById('reminder-modal');
//     if (e.target === modal) {
//         closeReminderModal();
//     }
// });

// Close on ESC key
document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
        closeReminderModal();
    }
});
