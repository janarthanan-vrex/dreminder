window.addEventListener("load", () => {
    setTimeout(() => {
        document.getElementById("loader").classList.add("hidden");
    }, 800);
});

/* ══════════════════════════════════════════
DATA
══════════════════════════════════════════ */
const ROLES_DATA = [
    {
        id: "superadmin",
        name: "Super Admin",
        color: "#7c3aed",
        desc: "Full system access",
        perms: ["all"],
        count: 1,
    },
    {
        id: "manager",
        name: "Manager",
        color: "#0d9488",
        desc: "Manage users and content",
        perms: [
            "users.read",
            "users.write",
            "reminders.read",
            "reminders.write",
            "analytics.read",
        ],
        count: 2,
    },
    {
        id: "support",
        name: "Support Agent",
        color: "#f59e0b",
        desc: "Handle user queries",
        perms: ["users.read", "reminders.read", "notifications.send"],
        count: 3,
    },
    {
        id: "analyst",
        name: "Analyst",
        color: "#06b6d4",
        desc: "View analytics only",
        perms: ["analytics.read", "users.read"],
        count: 1,
    },
    {
        id: "moderator",
        name: "Moderator",
        color: "#10b981",
        desc: "Moderate content and feedback",
        perms: ["users.read", "feedback.read", "feedback.write"],
        count: 1,
    },
];

const ALL_PERMS = [
    { key: "users.read", label: "View Users", group: "Users" },
    { key: "users.write", label: "Edit Users", group: "Users" },
    { key: "users.delete", label: "Delete Users", group: "Users" },
    { key: "reminders.read", label: "View Reminders", group: "Reminders" },
    { key: "reminders.write", label: "Edit Reminders", group: "Reminders" },
    { key: "reminders.delete", label: "Delete Reminders", group: "Reminders" },
    { key: "analytics.read", label: "View Analytics", group: "Analytics" },
    { key: "analytics.export", label: "Export Analytics", group: "Analytics" },
    {
        key: "notifications.send",
        label: "Send Notifications",
        group: "Notifications",
    },
    {
        key: "notifications.manage",
        label: "Manage Notifications",
        group: "Notifications",
    },
    { key: "staff.manage", label: "Manage Staff", group: "Team" },
    { key: "roles.manage", label: "Manage Roles", group: "Team" },
    { key: "settings.read", label: "View Settings", group: "System" },
    { key: "settings.write", label: "Edit Settings", group: "System" },
    { key: "audit.read", label: "View Audit Log", group: "System" },
    { key: "billing.read", label: "View Billing", group: "Billing" },
    { key: "billing.write", label: "Edit Billing", group: "Billing" },
    { key: "feedback.read", label: "View Feedback", group: "Support" },
    { key: "feedback.write", label: "Respond Feedback", group: "Support" },
    { key: "categories.manage", label: "Manage Categories", group: "Content" },
];

const NAMES = [
    "Kishore Rex",
    "Sarah Johnson",
    "Michael Chen",
    "Emma Williams",
    "James Brown",
    "Olivia Davis",
    "William Taylor",
    "Sophia Martinez",
];
const INITS = ["KR", "SJ", "MC", "EW", "JB", "OD", "WT", "SM"];
const COLORS_U = [
    "#7c3aed",
    "#0d9488",
    "#f59e0b",
    "#10b981",
    "#f43f5e",
    "#06b6d4",
    "#ec4899",
    "#a78bfa",
];

// const USERS_DATA = Array.from({ length: 28 }, (_, i) => ({
//     id: i + 1,
//     name: NAMES[i % 8],
//     email: "user" + (i + 1) + "@example.com",
//     plan: ["Basic Annual", "Basic Annual", "Pro", "Free"][i % 4],
//     rems: Math.floor(Math.random() * 60 + 2),
//     status: i === 5 ? "suspended" : "active",
//     joined: new Date(Date.now() - Math.random() * 3e7).toLocaleDateString(
//         "en-GB",
//         {
//             day: "2-digit",
//             month: "short",
//             year: "numeric",
//         },
//     ),
//     phone: "+44 7700 9" + String(10000 + i).slice(1),
//     initials: INITS[i % 8],
//     color: COLORS_U[i % 8],
// }));

let USERS_DATA = window.USERS_DATA || [];

const STAFF_DATA = [
    {
        id: 1,
        name: "Alex Morgan",
        email: "alex@dremind.co.uk",
        role: "manager",
        status: "active",
        last: "2h ago",
        initials: "AM",
        color: "#0d9488",
    },
    {
        id: 2,
        name: "Priya Patel",
        email: "priya@dremind.co.uk",
        role: "support",
        status: "active",
        last: "30m ago",
        initials: "PP",
        color: "#f59e0b",
    },
    {
        id: 3,
        name: "Tom Walker",
        email: "tom@dremind.co.uk",
        role: "analyst",
        status: "active",
        last: "1d ago",
        initials: "TW",
        color: "#06b6d4",
    },
    {
        id: 4,
        name: "Rachel Green",
        email: "rachel@dremind.co.uk",
        role: "moderator",
        status: "active",
        last: "5h ago",
        initials: "RG",
        color: "#10b981",
    },
    {
        id: 5,
        name: "James Lee",
        email: "james@dremind.co.uk",
        role: "support",
        status: "inactive",
        last: "14d ago",
        initials: "JL",
        color: "#94a3b8",
    },
    {
        id: 6,
        name: "Fatima Khan",
        email: "fatima@dremind.co.uk",
        role: "support",
        status: "active",
        last: "1h ago",
        initials: "FK",
        color: "#ec4899",
    },
    {
        id: 7,
        name: "David Smith",
        email: "david@dremind.co.uk",
        role: "manager",
        status: "active",
        last: "3h ago",
        initials: "DS",
        color: "#7c3aed",
    },
    {
        id: 8,
        name: "Nina Johansson",
        email: "nina@dremind.co.uk",
        role: "analyst",
        status: "active",
        last: "6h ago",
        initials: "NJ",
        color: "#f43f5e",
    },
];

const REM_TITLES = [
    "Car Insurance Renewal",
    "TV Licence",
    "MOT Due",
    "Home Insurance",
    "Passport Renewal",
    "Gym Membership",
    "Netflix Subscription",
    "Council Tax",
    "Water Bill",
    "Phone Contract",
    "Boiler Service",
    "Road Tax",
    "Pet Insurance",
    "Dental Checkup",
    "Eye Test",
    "Dentist Appointment",
    "Broadband Contract",
    "Sky TV Renewal",
    "Amazon Prime",
    "AA Membership",
];
const REM_CATS = [
    "Motor Vehicle",
    "Subscriptions",
    "Insurance",
    "Health",
    "Special Days",
    "Home",
    "TV, Tel & Mobile",
    "Travel",
];
// const REMINDERS_DATA = Array.from({ length: 30 }, (_, i) => ({
//     id: 1001 + i,
//     title: REM_TITLES[i % REM_TITLES.length],
//     user: USERS_DATA[i % USERS_DATA.length],
//     category: REM_CATS[i % REM_CATS.length],
//     due: new Date(Date.now() + (i - 8) * 86400000 * 2),
//     status:
//         i === 3 || i === 8 || i === 15
//             ? "overdue"
//             : i % 3 === 0
//               ? "completed"
//               : "active",
//     notes: "Auto-reminder set by user. Notification via Email & SMS.",
//     created: new Date(Date.now() - i * 86400000 * 5),
//     priority: ["low", "medium", "high"][i % 3],
// }));

let REMINDERS_DATA = window.REMINDERS_DATA || [];

const TXN_DATA = Array.from({ length: 30 }, (_, i) => ({
    id: 10000 + i,
    txnId: "TXN-" + (10000 + i),
    user: USERS_DATA[i % USERS_DATA.length],
    plan: ["Basic Annual", "Basic Annual", "Pro", "Basic Annual"][i % 4],
    amount: "£2.40",
    status: i === 2 ? "pending" : i === 5 ? "refunded" : "completed",
    date: new Date(Date.now() - i * 86400000 * 3),
    method: ["Visa •••• 4242", "Mastercard •••• 8888", "PayPal"][i % 3],
}));

// const CATS_DATA = [
//     {
//         id: 1,
//         name: "Insurance",
//         icon: "ri-shield-star-line",
//         color: "#f43f5e",
//         bg: "rgba(244,63,94,.12)",
//         desc: "Policies, renewals and coverage reminders",
//         total: 421,
//         subcategories: [
//             { id: 101, name: "Car Insurance", total: 110 },
//             { id: 102, name: "Health Insurance", total: 95 },
//             { id: 103, name: "Home Insurance", total: 88 }
//         ]
//     },
//     {
//         id: 2,
//         name: "Subscriptions",
//         icon: "ri-refresh-line",
//         color: "#10b981",
//         bg: "rgba(16,185,129,.12)",
//         desc: "Recurring digital and monthly plans",
//         total: 678,
//         subcategories: [
//             { id: 201, name: "Netflix", total: 120 },
//             { id: 202, name: "Amazon Prime", total: 98 },
//             { id: 203, name: "Spotify", total: 74 }
//         ]
//     },

// ];

let CATS_DATA = window.CATS_DATA || [];

const AUDIT_DATA = [
    {
        icon: "ri-user-add-line",
        col: "#10b981",
        action: "User Created",
        detail: "Created user Emma Williams (emma@example.com)",
        actor: "Super Admin",
        time: "Today 14:32",
        type: "Create",
    },
    {
        icon: "ri-key-2-line",
        col: "#7c3aed",
        action: "Role Updated",
        detail: "Updated Support role permissions — added feedback.write",
        actor: "Alex Morgan",
        time: "Today 12:15",
        type: "Update",
    },
    {
        icon: "ri-delete-bin-line",
        col: "#f43f5e",
        action: "Reminder Deleted",
        detail: "Deleted reminder #4821 for user ID 148",
        actor: "Super Admin",
        time: "Today 09:44",
        type: "Delete",
    },
    {
        icon: "ri-login-box-line",
        col: "#06b6d4",
        action: "Admin Login",
        detail: "Logged in from 192.168.1.10 — London, UK",
        actor: "Super Admin",
        time: "Today 09:30",
        type: "Login",
    },
    {
        icon: "ri-settings-3-line",
        col: "#f59e0b",
        action: "Settings Updated",
        detail: "Changed SMTP host to smtp.mailgun.org",
        actor: "Alex Morgan",
        time: "Yesterday 16:50",
        type: "Update",
    },
    {
        icon: "ri-user-unfollow-line",
        col: "#f43f5e",
        action: "User Suspended",
        detail: "Suspended account user ID 23 — policy violation",
        actor: "Priya Patel",
        time: "Yesterday 14:10",
        type: "Update",
    },
    {
        icon: "ri-send-plane-line",
        col: "#10b981",
        action: "Broadcast Sent",
        detail: "Email broadcast sent to 1,284 users — Q2 update",
        actor: "Super Admin",
        time: "2 days ago",
        type: "Create",
    },
    {
        icon: "ri-team-line",
        col: "#a78bfa",
        action: "Staff Added",
        detail: "Added Nina Johansson as Analyst",
        actor: "Super Admin",
        time: "3 days ago",
        type: "Create",
    },
    {
        icon: "ri-bank-card-line",
        col: "#10b981",
        action: "Plan Updated",
        detail: "Basic Annual price adjusted to £2.40/year",
        actor: "Super Admin",
        time: "3 days ago",
        type: "Update",
    },
    {
        icon: "ri-shield-check-line",
        col: "#06b6d4",
        action: "2FA Enforced",
        detail: "Forced 2FA for all admin accounts",
        actor: "Super Admin",
        time: "4 days ago",
        type: "Update",
    },
    {
        icon: "ri-folder-add-line",
        col: "#f59e0b",
        action: "Category Created",
        detail: "Added new category: Fitness",
        actor: "Alex Morgan",
        time: "5 days ago",
        type: "Create",
    },
    {
        icon: "ri-user-settings-line",
        col: "#7c3aed",
        action: "Profile Updated",
        detail: "Super Admin updated email address",
        actor: "Super Admin",
        time: "6 days ago",
        type: "Update",
    },
];

// const FEEDBACK_DATA = [
//     {
//         type: "bug",
//         icon: "ri-bug-line",
//         col: "#f43f5e",
//         user: "Kishore Rex",
//         msg: "Push notifications not working on iOS 17",
//         status: "open",
//         time: "Apr 25",
//     },

// ];
let FEEDBACK_DATA = window.FEEDBACK_DATA || [];
const ROLE_COLORS = [
    "#7c3aed",
    "#0d9488",
    "#f59e0b",
    "#10b981",
    "#f43f5e",
    "#06b6d4",
    "#ec4899",
    "#a78bfa",
];
let selectedRoleColor = ROLE_COLORS[0];
let selectedRole = null;
let charts = {};

// Mutable copies for staff
let staffData = [...STAFF_DATA];

/* ══════════════════════════════════════════
PAGINATION STATE
══════════════════════════════════════════ */
let usersPageNum = 1,
    usersPerPage = 8,
    usersFiltered = [...USERS_DATA];
let staffPageNum = 1,
    staffPerPage = 6,
    staffFiltered = [...staffData];
let remPageNum = 1,
    remPerPage = 8,
    remFiltered = [...REMINDERS_DATA];
let auditPageNum = 1,
    auditPerPage = 8,
    auditFiltered = [...AUDIT_DATA];

/* ══════════════════════════════════════════
GENERIC PAGINATION BUILDER
══════════════════════════════════════════ */
function buildPagination(containerId, cur, totalPages, fnName) {
    var el = document.getElementById(containerId);
    if (!el) return;
    if (totalPages <= 1) {
        el.innerHTML = "";
        return;
    }
    var h =
        '<button class="btn btn-ghost btn-xs" onclick="' +
        fnName +
        "(" +
        (cur - 1) +
        ')"' +
        (cur <= 1 ? " disabled" : "") +
        '><i class="ri-arrow-left-s-line"></i></button>';
    var start = Math.max(1, cur - 2),
        end = Math.min(totalPages, start + 4);
    if (start > 1) {
        h +=
            '<button class="btn btn-ghost btn-xs" onclick="' +
            fnName +
            '(1)">1</button>';
        if (start > 2)
            h += '<span style="color:var(--text4);padding:0 2px">…</span>';
    }
    for (var i = start; i <= end; i++)
        h +=
            '<button class="btn btn-' +
            (i === cur ? "primary" : "ghost") +
            ' btn-xs" onclick="' +
            fnName +
            "(" +
            i +
            ')">' +
            i +
            "</button>";
    if (end < totalPages) {
        if (end < totalPages - 1)
            h += '<span style="color:var(--text4);padding:0 2px">…</span>';
        h +=
            '<button class="btn btn-ghost btn-xs" onclick="' +
            fnName +
            "(" +
            totalPages +
            ')">' +
            totalPages +
            "</button>";
    }
    h +=
        '<button class="btn btn-ghost btn-xs" onclick="' +
        fnName +
        "(" +
        (cur + 1) +
        ')"' +
        (cur >= totalPages ? " disabled" : "") +
        '><i class="ri-arrow-right-s-line"></i></button>';
    el.innerHTML = h;
}

/* ══════════════════════════════════════════
ROUTING
══════════════════════════════════════════ */
const PAGE_TITLES = {
    dashboard: "Dashboard",
    analytics: "Analytics",
    users: "User Management",
    staff: "Staff Management",
    roles: "Roles & Permissions",
    reminders: "Reminders",
    transactions: "Transactions",
    categories: "Categories",
    notifications: "Notifications",
    profile: "My Profile",
    settings: "Settings",
    audit: "Audit Log",
    feedback: "Feedback",
};
let curPage = ["dashboard"];

function go(p, navEl) {
    document.querySelectorAll(".page").forEach(function (el) {
        el.classList.remove("active");
    });
    document.querySelectorAll(".nav-item").forEach(function (el) {
        el.classList.remove("active");
    });
    var pg = document.getElementById("page-" + p);
    if (!pg) return;
    pg.classList.add("active");
    document.getElementById("page-title").textContent = PAGE_TITLES[p] || p;
    if (navEl) navEl.classList.add("active");
    curPage = p;
    if (p === "dashboard") initDash();
    if (p === "analytics") initAnalytics();
    if (p === "users") renderUsers();
    if (p === "staff") renderStaff();
    if (p === "roles") renderRoles();
    if (p === "reminders") renderReminders();
    if (p === "transactions") renderTransactions();
    if (p === "categories") renderAdminCategories();
    if (p === "notifications") renderNotifications();
    if (p === "audit") renderAudit();
    if (p === "feedback") renderFeedback();
    if (p === "profile") renderProfileActivity();
    if (p === "settings") initSettings();
    closeMobile();
}

/* ══════════════════════════════════════════
THEME & SIDEBAR
══════════════════════════════════════════ */
var sbCollapsed = false;
function toggleSidebar() {
    sbCollapsed = !sbCollapsed;
    document
        .getElementById("sidebar")
        .classList.toggle("collapsed", sbCollapsed);
}
function openMobile() {
    document.getElementById("sidebar").classList.add("mobile-open");
    document.getElementById("sb-overlay").classList.add("show");
}
function closeMobile() {
    document.getElementById("sidebar").classList.remove("mobile-open");
    document.getElementById("sb-overlay").classList.remove("show");
}

// ── Theme Toggle with View Transition Ripple ──────────────────────
function toggleTheme(event) {
    const isDarkNext = !document.documentElement.classList.contains("dark");

    if (!document.startViewTransition) {
        _applyTheme(isDarkNext);
        return;
    }

    const btn = document.getElementById("theme-toggle-btn");
    const rect = btn?.getBoundingClientRect();
    const x = rect ? rect.left + rect.width / 2 : window.innerWidth / 2;
    const y = rect ? rect.top + rect.height / 2 : window.innerHeight / 2;
    const endRadius = Math.hypot(
        Math.max(x, window.innerWidth - x),
        Math.max(y, window.innerHeight - y),
    );

    const transition = document.startViewTransition(() => {
        _applyTheme(isDarkNext);
    });

    transition.ready.then(() => {
        const clipPath = [
            `circle(0px at ${x}px ${y}px)`,
            `circle(${endRadius}px at ${x}px ${y}px)`,
        ];
        document.documentElement.animate(
            { clipPath: isDarkNext ? clipPath : [...clipPath].reverse() },
            {
                duration: 600,
                easing: "cubic-bezier(0.22, 1, 0.36, 1)",
                pseudoElement: isDarkNext
                    ? "::view-transition-new(root)"
                    : "::view-transition-old(root)",
                fill: "both",
            },
        );
    });

    transition.finished.then(() => {
        initDash();
        if (curPage === "analytics") initAnalytics();
    });
}

function _applyTheme(isDark) {
    document.documentElement.classList.toggle("dark", isDark);
    document.documentElement.classList.toggle("light", !isDark);
    localStorage.setItem("theme", isDark ? "dark" : "light");
    document.getElementById("theme-icon").className = isDark
        ? "ri-moon-line"
        : "ri-sun-line";
}

// ── Boot (unchanged logic, kept as-is) ───────────────────────────
(function () {
    const savedTheme = localStorage.getItem("theme");
    if (savedTheme === "dark") {
        document.documentElement.classList.add("dark");
        document.documentElement.classList.remove("light");
    } else {
        document.documentElement.classList.add("light");
        document.documentElement.classList.remove("dark");
    }
})();

// function handleLogout() {
//     if (confirm("Logout from admin panel?")) toast("Logged out", "success");
// }

/* ══════════════════════════════════════════
MODALS
══════════════════════════════════════════ */
function openModal(id) {
    document.getElementById(id).classList.add("open");
    document.body.style.overflow = "hidden";
}
function closeModal(id) {
    document.getElementById(id).classList.remove("open");
    document.body.style.overflow = "";
}
document.querySelectorAll(".modal-bg").forEach(function (m) {
    m.addEventListener("click", function (e) {
        if (e.target === m) {
            m.classList.remove("open");
            document.body.style.overflow = "";
        }
    });
});

function openConfirm(msg, onOk) {
    document.getElementById("confirm-msg").textContent = msg;
    document.getElementById("confirm-ok-btn").onclick = function () {
        onOk();
        closeModal("confirm-modal");
    };
    openModal("confirm-modal");
}

function openDrawer(html) {
    document.getElementById("drawer-content").innerHTML = html;
    document.getElementById("detail-drawer").style.transform = "translateX(0)";
    document.getElementById("drawer-overlay").style.opacity = "1";
    document.getElementById("drawer-overlay").style.pointerEvents = "all";
}
function closeDrawer() {
    document.getElementById("detail-drawer").style.transform =
        "translateX(100%)";
    document.getElementById("drawer-overlay").style.opacity = "0";
    document.getElementById("drawer-overlay").style.pointerEvents = "none";
}

/* ══════════════════════════════════════════
TOAST
══════════════════════════════════════════ */
function toast(msg, type, dur) {
    if (!dur) dur = 3200;
    var styles = {
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
    var c = styles[type] || styles.info;
    var el = document.createElement("div");
    el.className = "toast";
    el.style.cssText =
        "background:" + c.bg + ";border-color:" + c.bd + ";color:" + c.col;
    el.innerHTML =
        '<i class="' +
        c.ico +
        '" style="flex-shrink:0;font-size:.95rem"></i><span style="flex:1">' +
        msg +
        '</span><button onclick="this.closest(\'.toast\').remove()" style="background:none;border:none;color:inherit;cursor:pointer;opacity:.6;font-size:.95rem;padding:0"><i class="ri-close-line"></i></button>';
    document.getElementById("toast-area").appendChild(el);
    setTimeout(function () {
        el.style.cssText +=
            ";opacity:0;transform:translateX(60px);transition:all .3s";
        setTimeout(function () {
            el.remove();
        }, 300);
    }, dur);
}

/* ══════════════════════════════════════════
TABS
══════════════════════════════════════════ */
function swTab(group, name, btn) {
    document
        .querySelectorAll('[id^="' + group + '-tab-"]')
        .forEach(function (p) {
            p.classList.remove("active");
        });
    var el = document.getElementById(group + "-tab-" + name);
    if (el) el.classList.add("active");
    if (btn) {
        btn.closest(".tab-bar")
            .querySelectorAll(".tab-btn")
            .forEach(function (b) {
                b.classList.remove("active");
            });
        btn.classList.add("active");
    }
}

/* ══════════════════════════════════════════
DASHBOARD
══════════════════════════════════════════ */
function initDash() {
    renderRecentUsers();
    renderSysHealth();
    initDashCharts();
}
function renderRecentUsers() {
    var el = document.getElementById("recent-users-list");

    if (!el) return;

    el.innerHTML = USERS_DATA.slice(0, 5)
        .map(function (u) {
            return (
                '<div style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid var(--border2)">' +
                // Avatar
                (u.profile
                    ? '<img src="' +
                      u.profile +
                      '" class="avatar avatar-sm" style="width:38px;height:38px;border-radius:10px;object-fit:cover">'
                    : '<div class="avatar avatar-sm" style="background:' +
                      u.color +
                      "22;color:" +
                      u.color +
                      ';width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-weight:600">' +
                      u.initials +
                      "</div>") +
                // User Info
                '<div style="flex:1;min-width:0">' +
                '<div style="font-size:.83rem;font-weight:600;color:var(--text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">' +
                u.name +
                "</div>" +
                '<div style="font-size:.7rem;color:var(--text3)">' +
                u.email +
                "</div>" +
                "</div>" +
                // Plan Badge
                '<span class="badge badge-' +
                (u.plan === "Pro"
                    ? "purple"
                    : u.plan === "Free"
                      ? "slate"
                      : "teal") +
                '" style="font-size:.6rem">' +
                u.plan +
                "</span>" +
                "</div>"
            );
        })
        .join("");
}

function renderSysHealth() {
    var el = document.getElementById("sys-health");

    if (!el) return;

    var items = [
        { label: "API Response", val: 98, color: "#10b981", unit: "% uptime" },
        { label: "Email Delivery", val: 96, color: "#0d9488", unit: "% rate" },
        { label: "SMS Gateway", val: 99, color: "#7c3aed", unit: "% uptime" },
        { label: "Database", val: 100, color: "#10b981", unit: "% healthy" },
    ];

    el.innerHTML = items
        .map(function (i) {
            return (
                '<div><div style="display:flex;justify-content:space-between;font-size:.75rem;color:var(--text3);margin-bottom:4px"><span>' +
                i.label +
                '</span><span style="color:' +
                i.color +
                ';font-weight:700">' +
                i.val +
                i.unit +
                '</span></div><div class="prog-track"><div class="prog-fill" style="width:' +
                i.val +
                "%;background:" +
                i.color +
                '"></div></div></div>'
            );
        })
        .join("");
}

function initDashCharts() {
    var isDark = document.documentElement.classList.contains("dark");
    var tc = isDark ? "rgba(255,255,255,.3)" : "rgba(0,0,0,.4)";
    var gc = isDark ? "var(--ctrl-bg)" : "rgba(0,0,0,.05)";
    Object.values(charts).forEach(function (c) {
        try {
            c.destroy();
        } catch (e) {}
    });
    charts = {};
    var opts = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: {
                grid: { color: gc },
                ticks: { color: tc, font: { size: 10, family: "DM Sans" } },
            },
            y: {
                grid: { color: gc },
                ticks: { color: tc, font: { size: 10, family: "DM Sans" } },
            },
        },
    };
    var ug = document.getElementById("user-growth-chart");
    if (ug)
        charts.ug = new Chart(ug, {
            type: "line",
            data: {
                labels: ["Nov", "Dec", "Jan", "Feb", "Mar", "Apr"],
                datasets: [
                    {
                        data: [820, 940, 1020, 1100, 1210, 1284],
                        borderColor: "#7c3aed",
                        backgroundColor: "rgba(124,58,237,.12)",
                        fill: true,
                        tension: 0.45,
                        pointRadius: 4,
                        pointBackgroundColor: "#7c3aed",
                    },
                ],
            },
            options: opts,
        });
    var rv = document.getElementById("revenue-chart");
    if (rv)
        charts.rv = new Chart(rv, {
            type: "bar",
            data: {
                labels: ["Nov", "Dec", "Jan", "Feb", "Mar", "Apr"],
                datasets: [
                    {
                        data: [1960, 2100, 2400, 2650, 2800, 2880],
                        backgroundColor: "rgba(13,148,136,.7)",
                        borderRadius: 5,
                        borderSkipped: false,
                    },
                ],
            },
            options: opts,
        });
}

/* ══════════════════════════════════════════
ANALYTICS
══════════════════════════════════════════ */
function initAnalytics() {
    var isDark = document.documentElement.classList.contains("dark");
    var tc = isDark ? "rgba(255,255,255,.3)" : "rgba(0,0,0,.4)";
    var gc = isDark ? "var(--ctrl-bg)" : "rgba(0,0,0,.05)";
    ["an-reg-chart", "an-cat-chart", "an-rev-chart", "an-plan-chart"].forEach(
        function (id) {
            var c = charts[id];
            if (c)
                try {
                    c.destroy();
                } catch (e) {}
        },
    );
    var opts = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: {
                grid: { color: gc },
                ticks: { color: tc, font: { size: 10 } },
            },
            y: {
                grid: { color: gc },
                ticks: { color: tc, font: { size: 10 } },
            },
        },
    };
    var reg = document.getElementById("an-reg-chart");
    if (reg)
        charts["an-reg-chart"] = new Chart(reg, {
            type: "bar",
            data: {
                labels: [
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
                ],
                datasets: [
                    {
                        data: [
                            45, 72, 91, 110, 88, 124, 145, 132, 160, 178, 210,
                            229,
                        ],
                        backgroundColor: "rgba(124,58,237,.7)",
                        borderRadius: 4,
                        borderSkipped: false,
                    },
                ],
            },
            options: opts,
        });
    var cat = document.getElementById("an-cat-chart");
    if (cat)
        charts["an-cat-chart"] = new Chart(cat, {
            type: "doughnut",
            data: {
                labels: [
                    "Subscriptions",
                    "Motor",
                    "Insurance",
                    "Health",
                    "Special Days",
                    "Others",
                ],
                datasets: [
                    {
                        data: [678, 543, 421, 231, 312, 174],
                        backgroundColor: [
                            "#10b981",
                            "#a78bfa",
                            "#f43f5e",
                            "#06b6d4",
                            "#f59e0b",
                            "#94a3b8",
                        ],
                        borderWidth: 0,
                        hoverOffset: 8,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: "62%",
                plugins: {
                    legend: {
                        position: "right",
                        labels: {
                            color: tc,
                            font: { size: 11, family: "DM Sans" },
                            boxWidth: 12,
                        },
                    },
                },
            },
        });
    var rev = document.getElementById("an-rev-chart");
    if (rev)
        charts["an-rev-chart"] = new Chart(rev, {
            type: "line",
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
                datasets: [
                    {
                        data: [2400, 2650, 2800, 2880, 3100, 3240],
                        borderColor: "#0d9488",
                        backgroundColor: "rgba(13,148,136,.1)",
                        fill: true,
                        tension: 0.45,
                        pointRadius: 3,
                        pointBackgroundColor: "#0d9488",
                    },
                ],
            },
            options: opts,
        });
    var plan = document.getElementById("an-plan-chart");
    if (plan)
        charts["an-plan-chart"] = new Chart(plan, {
            type: "doughnut",
            data: {
                labels: ["Basic Annual", "Pro", "Free"],
                datasets: [
                    {
                        data: [980, 180, 124],
                        backgroundColor: ["#7c3aed", "#10b981", "#64748b"],
                        borderWidth: 0,
                        hoverOffset: 6,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: "65%",
                plugins: {
                    legend: {
                        position: "right",
                        labels: {
                            color: tc,
                            font: { size: 11, family: "DM Sans" },
                            boxWidth: 12,
                        },
                    },
                },
            },
        });
}

/* ══════════════════════════════════════════
USERS
══════════════════════════════════════════ */
function renderUsers() {
    var data = usersFiltered;
    var totalPages = Math.ceil(data.length / usersPerPage);
    var start = (usersPageNum - 1) * usersPerPage;
    var slice = data.slice(start, start + usersPerPage);
    document.getElementById("users-showing").textContent = slice.length;
    document.getElementById("users-total").textContent = data.length;
    document.getElementById("users-tbody").innerHTML = slice
        .map(function (u, index) {
            var planBadge =
                u.plan === "Pro"
                    ? "purple"
                    : u.plan === "Free"
                      ? "slate"
                      : "teal";
            return (
                "<tr>" +
                '<td style="font-weight:600;color:var(--text3)">' +
                (start + index + 1) +
                "</td>" +
                '<td><div style="display:flex;align-items:center;gap:9px">' +
                (u.profile
                    ? '<img src="' +
                      u.profile +
                      '" class="avatar avatar-sm" style="width:38px;height:38px;border-radius:10px;object-fit:cover">'
                    : '<div class="avatar avatar-sm" style="background:' +
                      u.color +
                      "22;color:" +
                      u.color +
                      ';width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-weight:600">' +
                      u.initials +
                      "</div>") +
                '<div><div style="font-size:.83rem;font-weight:600;color:var(--text)">' +
                u.first_name +
                " " +
                u.last_name +
                '</div><div style="font-size:.7rem;color:var(--text3)">' +
                u.email +
                "</div></div></div></td>" +
                '<td class="hide-mobile"><span class="badge badge-' +
                planBadge +
                '">' +
                u.plan +
                "</span></td>" +
                '<td class="hide-mobile" style="font-weight:600;color:var(--text)">' +
                u.rems +
                "</td>" +
                '<td><span class="badge badge-' +
                (u.status === "active" ? "green" : "red") +
                '">' +
                (u.status === "active" ? "Active" : "Suspended") +
                "</span></td>" +
                '<td class="hide-mobile" style="font-size:.78rem;color:var(--text3)">' +
                u.joined +
                "</td>" +
                '<td style="text-align:right"><div style="display:flex;gap:4px;justify-content:flex-end">' +
                '<button class="btn btn-ghost btn-xs" onclick="openUserDrawer(' +
                u.id +
                ')"><i class="ri-eye-line"></i></button>' +
                '<button class="btn btn-ghost btn-xs" onclick="openEditUser(' +
                u.id +
                ')"><i class="ri-pencil-line"></i></button>' +
                '<button class="btn btn-' +
                (u.status === "active" ? "amber" : "success") +
                ' btn-xs" onclick="toggleUserStatus(' +
                u.id +
                ')"><i class="ri-' +
                (u.status === "active" ? "pause" : "play") +
                '-line"></i></button>' +
                '<button class="btn btn-danger btn-xs" onclick="deleteUser(' +
                u.id +
                ')"><i class="ri-delete-bin-line"></i></button>' +
                "</div></td></tr>"
            );
        })
        .join("");
    buildPagination(
        "users-pagination",
        usersPageNum,
        totalPages,
        "setUsersPage",
    );
}

function setUsersPage(p) {
    usersPageNum = p;
    renderUsers();
}

function filterUsers(q) {
    if (q === undefined)
        q = (document.getElementById("users-search-inp") || {}).value || "";
    q = q.toLowerCase();
    var statusF =
        (document.getElementById("users-status-filter") || {}).value || "all";
    var planF =
        (document.getElementById("users-plan-filter") || {}).value || "all";
    usersFiltered = USERS_DATA.filter(function (u) {
        var matchQ = (
            u.first_name +
            " " +
            u.last_name +
            " " +
            u.email +
            " " +
            u.plan
        )
            .toLowerCase()
            .includes(q);
        var matchS = statusF === "all" || u.status === statusF;
        var matchP = planF === "all" || u.plan === planF;
        return matchQ && matchS && matchP;
    });
    usersPageNum = 1;
    renderUsers();
}

// function toggleUserStatus(id) {
//     var u = USERS_DATA.find(function (x) {
//         return x.id === id;
//     });
//     if (!u) return;
//     u.status = u.status === "active" ? "suspended" : "active";
//     toast(
//         "User " + (u.status === "active" ? "activated" : "suspended"),
//         "success",
//     );
//     renderUsers();
// }

function toggleUserStatus(id) {
    var u = USERS_DATA.find(function (x) {return x.id === id;
    });
    if (!u) return;
    openConfirm(
        "Are you sure you want to " +
        (u.status === "active" ? "suspend" : "activate") +
        " this user?",
        function () {
            fetch("/admin/users/status", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    Accept: "application/json",
                },
                body: JSON.stringify({
                    id: id,
                }),

            })
            .then((res) => res.json())
            .then((data) => {
                if (data.status) {
                    var u = USERS_DATA.find(function (x) {
                        return x.id === id;
                    });
                    if (u) {
                        u.status = data.user_status;
                    }
                    toast(data.message, "success");
                    renderUsers();
                } else {
                    toast(data.message || "Something went wrong", "error");
                }
            })
            .catch((err) => {
                console.log(err);
                toast("Something went wrong", "error");
            });
        }
    );
}

function openEditUser(id) {
    var u = USERS_DATA.find(function (x) {
        return x.id === id;
    });
    if (!u) return;
    document.getElementById("eu-id").value = u.id;
    document.getElementById("eu-first_name").value = u.first_name;
    document.getElementById("eu-last_name").value = u.last_name;
    document.getElementById("eu-email").value = u.email;
    document.getElementById("eu-phone").value = u.phone || "";
    document.getElementById("eu-plan").value = u.plan;
    document.getElementById("eu-postcode").value = u.postcode;
    document.getElementById("eu-address1").value = u.address1;
    document.getElementById("eu-status").value = u.status;
    openModal("edit-user-modal");
}

// function saveEditUser() {
//     var id = parseInt(document.getElementById("eu-id").value);
//     var u = USERS_DATA.find(function (x) {
//         return x.id === id;
//     });
//     if (!u) return;
//     u.name = document.getElementById("eu-name").value;
//     u.email = document.getElementById("eu-email").value;
//     u.plan = document.getElementById("eu-plan").value;
//     u.status = document.getElementById("eu-status").value;
//     u.phone = document.getElementById("eu-phone").value;
//     var ini = u.name
//         .split(" ")
//         .map(function (w) {
//             return w[0];
//         })
//         .join("")
//         .toUpperCase()
//         .slice(0, 2);
//     u.initials = ini;
//     toast("User updated!", "success");
//     closeModal("edit-user-modal");
//     renderUsers();
// }

function saveEditUser() {
    document.querySelectorAll(".err").forEach((el) => {
        el.innerText = "";
    });

    let payload = {
        id: document.getElementById("eu-id").value,
        first_name: document.getElementById("eu-first_name").value,
        last_name: document.getElementById("eu-last_name").value,
        plan: document.getElementById("eu-plan").value,
        status: document.getElementById("eu-status").value,
        phone: document.getElementById("eu-phone").value,
        postcode: document.getElementById("eu-postcode").value,
        address1: document.getElementById("eu-address1").value,
    };

    fetch("/admin/users/update", {
        method: "POST",

        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                .content,
            Accept: "application/json",
        },

        body: JSON.stringify(payload),
    })
        .then(async (response) => {
            const data = await response.json();

            if (response.status === 422) {
                Object.keys(data.errors).forEach((key) => {
                    let errorEl = document.getElementById(
                        "eu-" + key + "-error",
                    );

                    if (errorEl) {
                        errorEl.innerText = data.errors[key][0];
                    }
                });

                return;
            }

            if (data.status) {
                var u = USERS_DATA.find((x) => x.id == payload.id);

                if (u) {
                    u.name = payload.first_name + " " + payload.last_name;
                    u.phone = payload.phone;
                    u.plan = payload.plan;
                    u.postcode = payload.postcode;
                    u.status = payload.status;
                    u.initials = (
                        payload.first_name.charAt(0) +
                        payload.last_name.charAt(0)
                    ).toUpperCase();
                }

                toast(data.message, "success");

                closeModal("edit-user-modal");
                setTimeout(() => {
                    location.reload();
                }, 1500);

                renderUsers();
            }
        })
        .catch((err) => {
            console.log(err);
            toast("Something went wrong", "error");
        });
}

function addUser() {
    const btn = document.getElementById("create-user-btn");

    // Disable Button
    btn.disabled = true;
    btn.innerHTML = '<i class="ri-loader-4-line spinner"></i> Processing...';

    document.querySelectorAll(".err").forEach((el) => {
        el.innerText = "";
    });

    let payload = {
        first_name: document.getElementById("au-fname").value,
        last_name: document.getElementById("au-lname").value,
        email: document.getElementById("au-email").value,
        postcode: document.getElementById("au-postcode").value,
        phone: document.getElementById("au-phone").value,
        plan: document.getElementById("au-plan").value,
        status: document.getElementById("au-status").value,
        address1: document.getElementById("address1").value,
    };
    fetch("/admin/users/store", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                .content,
            Accept: "application/json",
        },
        body: JSON.stringify(payload),
    })
        .then(async (response) => {
            const data = await response.json();
            if (response.status === 422) {
                Object.keys(data.errors).forEach((key) => {
                    let map = {
                        first_name: "au-fname",
                        last_name: "au-lname",
                        email: "au-email",
                        postcode: "au-postcode",
                        phone: "au-phone",
                        plan: "au-plan",
                        status: "au-status",
                        address1: "address1",
                    };
                    let errorEl = document.getElementById(map[key] + "-error");
                    if (errorEl) {
                        errorEl.innerText = data.errors[key][0];
                    }
                });
                btn.disabled = false;
                btn.innerHTML = '<i class="ri-check-line"></i> Create User';
                return;
            }
            if (data.status) {
                toast(data.message, "success");

                closeModal("add-user-modal");

                [
                    "au-fname",
                    "au-lname",
                    "au-email",
                    "au-phone",
                    "address1",
                ].forEach((id) => {
                    document.getElementById(id).value = "";
                });

                setTimeout(() => {
                    location.reload();
                }, 1500);
            }
        })
        .catch((err) => {
            console.log(err);
            toast("Something went wrong", "error");
            // Reset Button
            btn.disabled = false;
            btn.innerHTML = '<i class="ri-check-line"></i> Create User';
        });
}

function openUserDrawer(id) {
    var u = USERS_DATA.find(function (x) {
        return x.id === id;
    });

    if (!u) return;

    openDrawer(
        '<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px"><h2 class="font-jakarta" style="font-size:1rem;font-weight:800;color:var(--text)">User Details</h2><button onclick="closeDrawer()" style="background:var(--ctrl-bg);border:1px solid var(--border);color:var(--text2);width:30px;height:30px;border-radius:7px;display:flex;align-items:center;justify-content:center;cursor:pointer"><i class="ri-close-line"></i></button></div>' +
            '<div style="text-align:center;margin-bottom:20px"><div class="avatar avatar-lg" style="background:' +
            u.color +
            "22;color:" +
            u.color +
            ';margin:0 auto 10px">' +
            u.initials +
            '</div><div class="font-jakarta" style="font-weight:700;font-size:1rem;color:var(--text)">' +
            u.first_name +
            " " +
            u.last_name +
            '</div><div style="font-size:.75rem;color:var(--text3)">' +
            u.email +
            '</div><div style="margin-top:8px;display:flex;gap:6px;justify-content:center"><span class="badge badge-' +
            (u.plan === "Pro"
                ? "purple"
                : u.plan === "Free"
                  ? "slate"
                  : "teal") +
            '">' +
            u.plan +
            '</span><span class="badge badge-' +
            (u.status === "active" ? "green" : "red") +
            '">' +
            u.status +
            "</span></div></div>" +
            '<div style="display:flex;flex-direction:column;gap:10px;margin-bottom:20px">' +
            '<div style="display:flex;justify-content:space-between;padding:10px;border-radius:8px;background:var(--row-bg);border:1px solid var(--border2)"><span style="font-size:.78rem;color:var(--text3)">Total Reminders</span><span style="font-size:1.20re;font-weight:700;color:var(--text)">' +
            u.rems +
            "</span></div>" +
            '<div style="display:flex;justify-content:space-between;padding:10px;border-radius:8px;background:var(--row-bg);border:1px solid var(--border2)"><span style="font-size:.78rem;color:var(--text3)">Member Since</span><span style="font-size:1.20re;font-weight:700;color:var(--text)">' +
            u.joined +
            "</span></div>" +
            
            '<div style="display:flex;justify-content:space-between;padding:10px;border-radius:8px;background:var(--row-bg);border:1px solid var(--border2)"><span style="font-size:.78rem;color:var(--text3)">Phone</span><span style="font-size:1.20re;font-weight:700;color:var(--text)">' +
            (u.phone || "N/A") +
            "</span></div>" +
            '<div style="display:flex;justify-content:space-between;padding:10px;border-radius:8px;background:var(--row-bg);border:1px solid var(--border2)"><span style="font-size:.78rem;color:var(--text3)">Address1</span><span style="font-size:1.20re;font-weight:700;color:var(--text)">' +
            (u.address1 || "N/A") +
            "</span></div>" +
            '<div style="display:flex;justify-content:space-between;padding:10px;border-radius:8px;background:var(--row-bg);border:1px solid var(--border2)"><span style="font-size:.78rem;color:var(--text3)">Address2</span><span style="font-size:1.20re;font-weight:700;color:var(--text)">' +
            (u.address2 || "N/A") +
            "</span></div>" +


   '<div style="display:flex;justify-content:space-between;padding:10px;border-radius:8px;background:var(--row-bg);border:1px solid var(--border2)"><span style="font-size:.78rem;color:var(--text3)">Postal code</span><span style="font-size:1.20re;font-weight:700;color:var(--text)">' +
            (u.postcode || "N/A") +
            "</span></div>" +

            '</div><div style="display:flex;flex-direction:column;gap:8px">' +
            '<button id="verify-mail-btn-' +
            u.id +
            '" class="btn btn-primary btn-sm" style="width:100%;justify-content:center" onclick="sendVerifyMail(' +
            u.id +
            ')"><i class=\"ri-mail-send-line\"></i> Send Verification Mail</button>' +
            '<button class="btn btn-ghost btn-sm" style="width:100%;justify-content:center" onclick="closeDrawer();openEditUser(' +
            u.id +
            ')"><i class="ri-pencil-line"></i> Edit Profile</button>' +
            '<button class="btn btn-danger btn-sm" style="width:100%;justify-content:center" onclick="toggleUserStatus(' +
            u.id +
            ');closeDrawer()"><i class="ri-pause-line"></i> ' +
            (u.status === "active" ? "Suspend" : "Activate") +
            " Account</button>" +
            "</div>",
    );
}

/* ══════════════════════════════════════════
STAFF
══════════════════════════════════════════ */
function renderStaff(data) {
    staffFiltered = data || staffFiltered;
    var totalPages = Math.ceil(staffFiltered.length / staffPerPage);
    var start = (staffPageNum - 1) * staffPerPage;
    var slice = staffFiltered.slice(start, start + staffPerPage);
    document.getElementById("staff-showing").textContent = slice.length;
    document.getElementById("staff-total").textContent = staffFiltered.length;
    // Update stat counts
    var act = staffData.filter(function (s) {
        return s.status === "active";
    }).length;
    var inact = staffData.filter(function (s) {
        return s.status === "inactive";
    }).length;
    if (document.getElementById("staff-count-total"))
        document.getElementById("staff-count-total").textContent =
            staffData.length;
    if (document.getElementById("staff-count-active"))
        document.getElementById("staff-count-active").textContent = act;
    if (document.getElementById("staff-count-inactive"))
        document.getElementById("staff-count-inactive").textContent = inact;
    document.getElementById("staff-tbody").innerHTML = slice
        .map(function (s) {
            var role = ROLES_DATA.find(function (r) {
                return r.id === s.role;
            }) || { name: s.role, color: "#94a3b8", perms: [] };
            var perms = role.perms;
            var permBadges = perms
                .slice(0, 2)
                .map(function (p) {
                    return (
                        '<span class="chip" style="font-size:.6rem">' +
                        p +
                        "</span>"
                    );
                })
                .join("");
            var morePerms =
                perms.length > 2
                    ? '<span class="chip" style="font-size:.6rem">+' +
                      (perms.length - 2) +
                      "</span>"
                    : "";
            return (
                "<tr>" +
                '<td><div style="display:flex;align-items:center;gap:9px"><div class="avatar avatar-sm" style="background:' +
                s.color +
                "22;color:" +
                s.color +
                '">' +
                s.initials +
                '</div><div><div style="font-size:.83rem;font-weight:600;color:var(--text)">' +
                s.name +
                '</div><div style="font-size:.7rem;color:var(--text3)">' +
                s.email +
                "</div></div></div></td>" +
                '<td class="hide-mobile"><span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:99px;font-size:.68rem;font-weight:700;background:' +
                role.color +
                "22;color:" +
                role.color +
                ";border:1px solid " +
                role.color +
                '44">' +
                role.name +
                "</span></td>" +
                '<td class="hide-mobile"><div style="display:flex;gap:4px;flex-wrap:wrap">' +
                permBadges +
                morePerms +
                "</div></td>" +
                '<td><span class="badge badge-' +
                (s.status === "active" ? "green" : "slate") +
                '">' +
                s.status +
                "</span></td>" +
                '<td class="hide-mobile" style="font-size:.75rem;color:var(--text3)">' +
                s.last +
                "</td>" +
                '<td style="text-align:right"><div style="display:flex;gap:4px;justify-content:flex-end">' +
                '<button class="btn btn-ghost btn-xs" onclick="openStaffDrawer(' +
                s.id +
                ')"><i class="ri-eye-line"></i></button>' +
                '<button class="btn btn-ghost btn-xs" onclick="openEditStaff(' +
                s.id +
                ')"><i class="ri-pencil-line"></i></button>' +
                '<button class="btn btn-danger btn-xs" onclick="openConfirm(\'Remove ' +
                s.name +
                " from staff?',function(){removeStaff(" +
                s.id +
                ')})"><i class="ri-delete-bin-line"></i></button>' +
                "</div></td></tr>"
            );
        })
        .join("");
    buildPagination(
        "staff-pagination",
        staffPageNum,
        totalPages,
        "setStaffPage",
    );
}

function setStaffPage(p) {
    staffPageNum = p;
    renderStaff();
}

function filterStaff(q) {
    staffFiltered = staffData.filter(function (s) {
        return (s.name + s.email + s.role)
            .toLowerCase()
            .includes(q.toLowerCase());
    });
    staffPageNum = 1;
    renderStaff();
}

function removeStaff(id) {
    staffData = staffData.filter(function (s) {
        return s.id !== id;
    });
    staffFiltered = staffFiltered.filter(function (s) {
        return s.id !== id;
    });
    renderStaff();
    toast("Staff member removed", "success");
}

function addStaffMember() {
    var name = document.getElementById("as-name").value.trim();
    var email = document.getElementById("as-email").value.trim();
    var role = document.getElementById("staff-role-sel").value;
    if (!name || !email || !role) {
        toast("Please fill required fields", "error");
        return;
    }
    var ini = name
        .split(" ")
        .map(function (w) {
            return w[0];
        })
        .join("")
        .toUpperCase()
        .slice(0, 2);
    staffData.push({
        id: Date.now(),
        name: name,
        email: email,
        role: role,
        status: "active",
        last: "just now",
        initials: ini,
        color: COLORS_U[staffData.length % 8],
    });
    staffFiltered = [...staffData];
    toast("Staff member added!", "success");
    closeModal("add-staff-modal");
    renderStaff();
}

function openEditStaff(id) {
    var s = staffData.find(function (x) {
        return x.id === id;
    });
    if (!s) return;
    document.getElementById("es-id").value = s.id;
    document.getElementById("es-name").value = s.name;
    document.getElementById("es-email").value = s.email;
    document.getElementById("es-status").value = s.status;
    // populate role dropdown
    var sel = document.getElementById("es-role");
    sel.innerHTML = ROLES_DATA.map(function (r) {
        return (
            '<option value="' +
            r.id +
            '"' +
            (r.id === s.role ? " selected" : "") +
            ">" +
            r.name +
            "</option>"
        );
    }).join("");
    openModal("edit-staff-modal");
}

function saveEditStaff() {
    var id =
        parseInt(document.getElementById("es-id").value) ||
        document.getElementById("es-id").value;
    var s = staffData.find(function (x) {
        return x.id == id;
    });
    if (!s) return;
    s.name = document.getElementById("es-name").value;
    s.email = document.getElementById("es-email").value;
    s.role = document.getElementById("es-role").value;
    s.status = document.getElementById("es-status").value;
    s.initials = s.name
        .split(" ")
        .map(function (w) {
            return w[0];
        })
        .join("")
        .toUpperCase()
        .slice(0, 2);
    staffFiltered = [...staffData];
    toast("Staff updated!", "success");
    closeModal("edit-staff-modal");
    renderStaff();
}

function openStaffDrawer(id) {
    var s = staffData.find(function (x) {
        return x.id === id;
    });
    if (!s) return;
    var role = ROLES_DATA.find(function (r) {
        return r.id === s.role;
    }) || { name: s.role, color: "#94a3b8", perms: [] };
    openDrawer(
        '<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px"><h2 class="font-jakarta" style="font-size:1rem;font-weight:800;color:var(--text)">Staff Details</h2><button onclick="closeDrawer()" style="background:var(--ctrl-bg);border:1px solid var(--border);color:var(--text2);width:30px;height:30px;border-radius:7px;display:flex;align-items:center;justify-content:center;cursor:pointer"><i class="ri-close-line"></i></button></div>' +
            '<div style="text-align:center;margin-bottom:20px"><div class="avatar avatar-lg" style="background:' +
            s.color +
            "22;color:" +
            s.color +
            ';margin:0 auto 10px">' +
            s.initials +
            '</div><div class="font-jakarta" style="font-weight:700;font-size:1rem;color:var(--text)">' +
            s.name +
            '</div><div style="font-size:.75rem;color:var(--text3)">' +
            s.email +
            '</div><span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:99px;font-size:.68rem;font-weight:700;background:' +
            role.color +
            "22;color:" +
            role.color +
            ";border:1px solid " +
            role.color +
            '44;margin-top:8px">' +
            role.name +
            "</span></div>" +
            '<div style="margin-bottom:14px"><div style="font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--text3);margin-bottom:8px">Permissions</div><div style="display:flex;flex-wrap:wrap;gap:5px">' +
            role.perms
                .map(function (p) {
                    return '<span class="chip">' + p + "</span>";
                })
                .join("") +
            "</div></div>" +
            '<div style="display:flex;flex-direction:column;gap:8px;margin-bottom:14px"><div style="display:flex;justify-content:space-between;padding:10px;border-radius:8px;background:var(--row-bg);border:1px solid var(--border2)"><span style="font-size:.78rem;color:var(--text3)">Status</span><span class="badge badge-' +
            (s.status === "active" ? "green" : "slate") +
            '">' +
            s.status +
            '</span></div><div style="display:flex;justify-content:space-between;padding:10px;border-radius:8px;background:var(--row-bg);border:1px solid var(--border2)"><span style="font-size:.78rem;color:var(--text3)">Last Active</span><span style="font-size:1.20re;font-weight:600;color:var(--text)">' +
            s.last +
            "</span></div></div>" +
            '<div style="display:flex;flex-direction:column;gap:8px"><button class="btn btn-primary btn-sm" style="width:100%;justify-content:center" onclick="closeDrawer();openEditStaff(' +
            s.id +
            ')"><i class="ri-pencil-line"></i> Edit Role</button><button class="btn btn-danger btn-sm" style="width:100%;justify-content:center" onclick="openConfirm(\'Remove ' +
            s.name +
            "?',function(){removeStaff(" +
            s.id +
            ');closeDrawer()})"><i class="ri-delete-bin-line"></i> Remove</button></div>',
    );
}

/* ══════════════════════════════════════════
ROLES
══════════════════════════════════════════ */
function renderRoles() {
    var list = document.getElementById("roles-list");
    list.innerHTML = ROLES_DATA.map(function (r) {
        var permBadges = (
            r.perms.includes("all")
                ? ALL_PERMS.slice(0, 4)
                : r.perms.slice(0, 4)
        )
            .map(function (p) {
                return (
                    '<span class="chip" style="font-size:.58rem">' +
                    (typeof p === "string" ? p : p.label) +
                    "</span>"
                );
            })
            .join("");
        var more =
            r.perms.length > 4
                ? '<span class="chip" style="font-size:.58rem">+' +
                  (r.perms.length - 4) +
                  " more</span>"
                : "";
        return (
            '<div class="role-card ' +
            (selectedRole === r.id ? "selected" : "") +
            '" onclick="selectRole(\'' +
            r.id +
            "',this)\">" +
            '<button class="role-edit-btn" onclick="openEditRole(\'' +
            r.id +
            '\', event)"><i class="ri-edit-line"></i></button>' +
            '<div style="display:flex;align-items:center;gap:10px;margin-bottom:8px"><div style="width:36px;height:36px;border-radius:9px;background:' +
            r.color +
            '22;display:flex;align-items:center;justify-content:center"><i class="ri-key-2-line" style="color:' +
            r.color +
            '"></i></div><div style="flex:1"><div style="font-size:.87rem;font-weight:700;color:var(--text)">' +
            r.name +
            '</div><div style="font-size:.72rem;color:var(--text3)">' +
            r.desc +
            '</div></div><span style="font-size:.65rem;font-weight:700;background:' +
            r.color +
            "22;color:" +
            r.color +
            ";padding:2px 8px;border-radius:99px;border:1px solid " +
            r.color +
            '44">' +
            r.count +
            " member" +
            (r.count !== 1 ? "s" : "") +
            "</span></div>" +
            '<div style="display:flex;flex-wrap:wrap;gap:4px">' +
            permBadges +
            more +
            "</div></div>"
        );
    }).join("");
    renderPermTable();
    buildRoleModal();
    populateStaffRoles();
}

function selectRole(id, el) {
    selectedRole = id;
    document.querySelectorAll(".role-card").forEach(function (c) {
        c.classList.remove("selected");
    });
    el.classList.add("selected");
    var role = ROLES_DATA.find(function (r) {
        return r.id === id;
    });
    document.getElementById("selected-role-badge").textContent = role.name;
    var groups = {};
    ALL_PERMS.forEach(function (p) {
        if (!groups[p.group]) groups[p.group] = [];
        groups[p.group].push(p);
    });
    var hasAll = role.perms.includes("all");
    var html =
        '<div style="margin-bottom:12px"><span class="badge badge-purple" style="font-size:.7rem">' +
        role.name +
        '</span><span style="font-size:.75rem;color:var(--text3);margin-left:8px">' +
        (hasAll ? ALL_PERMS.length : role.perms.length) +
        " permissions</span></div>";
    Object.entries(groups).forEach(function (entry) {
        var g = entry[0],
            perms = entry[1];
        html +=
            '<div style="margin-bottom:12px"><div style="font-size:.63rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--text4);margin-bottom:6px">' +
            g +
            '</div><div style="display:flex;flex-direction:column;gap:4px">';
        perms.forEach(function (p) {
            var has = hasAll || role.perms.includes(p.key);
            html +=
                '<div style="display:flex;align-items:center;gap:8px;padding:5px 8px;border-radius:6px;background:rgba(' +
                (has ? "16,185,129" : "255,255,255") +
                ',.05)"><i class="ri-' +
                (has ? "check" : "close") +
                '-line" style="color:' +
                (has ? "var(--green)" : "var(--text4)") +
                ';font-size:.85rem"></i><span style="font-size:.78rem;color:' +
                (has ? "var(--text2)" : "var(--text4)") +
                '">' +
                p.label +
                "</span></div>";
        });
        html += "</div></div>";
    });
    html +=
        '<button class="btn btn-primary btn-sm" style="width:100%;justify-content:center;margin-top:8px" onclick="toast(\'Role permissions saved!\',\'success\')"><i class="ri-save-line"></i> Save Permissions</button>';
    document.getElementById("perm-matrix").innerHTML = html;
}

function renderPermTable() {
    var head = document.getElementById("perm-table-head");
    var body = document.getElementById("perm-table-body");
    head.innerHTML =
        '<th style="padding:10px 14px;font-size:.63rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--text3)">Permission</th>' +
        ROLES_DATA.map(function (r) {
            return (
                '<th style="padding:10px 14px;font-size:.63rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:' +
                r.color +
                '">' +
                r.name +
                "</th>"
            );
        }).join("");
    body.innerHTML = ALL_PERMS.slice(0, 10)
        .map(function (p) {
            return (
                '<tr><td><span style="font-size:.78rem;color:var(--text2)">' +
                p.label +
                '</span><div style="font-size:.65rem;color:var(--text4)">' +
                p.group +
                "</div></td>" +
                ROLES_DATA.map(function (r) {
                    var has =
                        r.perms.includes("all") || r.perms.includes(p.key);
                    return (
                        '<td style="text-align:center"><i class="ri-' +
                        (has ? "check" : "minus") +
                        '-line" style="color:' +
                        (has ? "var(--green)" : "var(--text4)") +
                        '"></i></td>'
                    );
                }).join("") +
                "</tr>"
            );
        })
        .join("");
}

function buildRoleModal() {
    var permsEl = document.getElementById("new-role-perms");
    permsEl.innerHTML = ALL_PERMS.map(function (p) {
        return (
            '<label class="perm-item"><input type="checkbox" value="' +
            p.key +
            '" style="accent-color:var(--purple);width:13px;height:13px;cursor:pointer"><span>' +
            p.label +
            '<div style="font-size:.63rem;color:var(--text4)">' +
            p.group +
            "</div></span></label>"
        );
    }).join("");
    var cp = document.getElementById("role-color-picker");
    cp.innerHTML = ROLE_COLORS.map(function (c) {
        return (
            "<div onclick=\"selectedRoleColor='" +
            c +
            "';document.querySelectorAll('#role-color-picker div').forEach(function(d){d.style.outline='none'});this.style.outline='2px solid #fff'\" style=\"width:20px;height:20px;border-radius:50%;background:" +
            c +
            ";cursor:pointer;transition:transform .15s;outline:" +
            (c === selectedRoleColor ? "2px solid #fff" : "none") +
            '" onmouseover="this.style.transform=\'scale(1.2)\'" onmouseout="this.style.transform=\'scale(1)\'"></div>'
        );
    }).join("");
}

function createRole() {
    var name = document.getElementById("new-role-name").value.trim();
    if (!name) {
        toast("Enter a role name", "error");
        return;
    }
    var desc = document.getElementById("new-role-desc").value.trim();
    var perms = Array.from(
        document.querySelectorAll("#new-role-perms input:checked"),
    ).map(function (i) {
        return i.value;
    });
    ROLES_DATA.push({
        id: name.toLowerCase().replace(/\s+/g, "-"),
        name: name,
        color: selectedRoleColor,
        desc: desc,
        perms: perms,
        count: 0,
    });
    toast('Role "' + name + '" created!', "success");
    closeModal("add-role-modal");
    renderRoles();
}

function populateStaffRoles() {
    var sel = document.getElementById("staff-role-sel");
    if (sel)
        sel.innerHTML =
            '<option value="">Select role…</option>' +
            ROLES_DATA.map(function (r) {
                return '<option value="' + r.id + '">' + r.name + "</option>";
            }).join("");
}

var selectedEditRoleColor = "";

/* ══════════════════════════════════════════
REMINDERS
══════════════════════════════════════════ */
function renderReminders() {
    var data = remFiltered;
    var totalPages = Math.ceil(data.length / remPerPage);
    var start = (remPageNum - 1) * remPerPage;
    var slice = data.slice(start, start + remPerPage);

    document.getElementById("rem-showing").textContent = slice.length;
    document.getElementById("rem-total").textContent = data.length;

    var catColors = {
        active: "teal",
        completed: "green",
        overdue: "red",
    };

    document.getElementById("rem-tbody").innerHTML = slice
        .map(function (r, index) {
            var due = new Date(r.due).toLocaleDateString("en-GB", {
                day: "2-digit",
                month: "short",
                year: "numeric",
            });

            var u = r.user;

            return (
                "<tr>" +
                '<td style="font-weight:600;color:var(--text3)">' +
                (start + index + 1) +
                "</td>" +
                '<td><div style="font-size:.83rem;font-weight:600;color:var(--text)">' +
                r.title +
                '<td class="hide-mobile"><div style="display:flex;align-items:center;gap:7px">' +
                (u.profile
                    ? '<img src="' +
                      u.profile +
                      '" style="width:32px;height:32px;border-radius:50%;object-fit:cover">'
                    : '<div class="avatar avatar-sm" style="background:' +
                      u.color +
                      "22;color:" +
                      u.color +
                      '">' +
                      u.initials +
                      "</div>") +
                '<span style="font-size:.78rem;color:var(--text2)">' +
                u.name +
                "</span></div></td>" +
                '<td class="hide-mobile"><span class="badge badge-purple" style="font-size:.65rem">' +
                r.category +
                "</span></td>" +
                '<td style="font-size:.78rem;color:var(--text3)">' +
                due +
                "</td>" +
                '<td><span class="badge badge-' +

                (
    r.reminder_status === "completed"
        ? "green"
        : r.reminder_status === "pending"
          ? "amber"
          : "slate"
)
                
                +
                '">' +
                r.reminder_status +
                "</span></td>" +
                '<td style="text-align:right"><div style="display:flex;gap:4px;justify-content:flex-end">' +
                '<button class="btn btn-ghost btn-xs" onclick="openViewReminder(' +
                r.id +
                ')"><i class="ri-eye-line"></i></button>' +
            
                "</div></td></tr>"
            );
        })
        .join("");

    buildPagination("rem-pagination", remPageNum, totalPages, "setRemPage");
}

function setRemPage(p) {
    remPageNum = p;
    renderReminders();
}

function filterReminders(q) {

    if (q === undefined) {
        q = document.querySelector('.search-box input')?.value || "";
    }

    q = q.toLowerCase();

    var statusF =
        (document.getElementById("rem-status-filter") || {}).value || "all";

    var dateF =
        (document.getElementById("rem-date-filter") || {}).value || "this_month";

    var now = new Date();

    remFiltered = REMINDERS_DATA.filter(function (r) {

        var matchQ = (
            r.title +
            r.user.name +
            r.category
        )
        .toLowerCase()
        .includes(q);

        var matchS =
            statusF === "all" ||
            r.reminder_status === statusF;

        var matchD = true;

        if (r.end_reminder_date) {

            var endDate = new Date(r.end_reminder_date);

            if (dateF === "this_month") {

                matchD =
                    endDate.getMonth() === now.getMonth() &&
                    endDate.getFullYear() === now.getFullYear();

            }

            else if (dateF === "3_months") {

                var threeMonthsAgo = new Date();
                threeMonthsAgo.setMonth(now.getMonth() - 3);

                matchD = endDate >= threeMonthsAgo;

            }

            else if (dateF === "6_months") {

                var sixMonthsAgo = new Date();
                sixMonthsAgo.setMonth(now.getMonth() - 6);

                matchD = endDate >= sixMonthsAgo;

            }

            else if (dateF === "this_year") {

                matchD =
                    endDate.getFullYear() === now.getFullYear();

            }

        }

        return matchQ && matchS && matchD;

    });

    remPageNum = 1;

    renderReminders();
}

// function openViewReminder(id) {
//     var r = REMINDERS_DATA.find(function (x) {
//         return x.id === id;
//     });
//     if (!r) return;
//    var due = new Date(r.due).toLocaleDateString("en-GB", {
//     day: "2-digit",
//     month: "short",
//     year: "numeric",
// });
//     var created =  new Date(r.due).toLocaleDateString("en-GB", {
//         day: "2-digit",
//         month: "short",
//         year: "numeric",
//     });
//     document.getElementById("rem-modal-content").innerHTML =
//         '<div style="display:flex;gap:10px;margin-bottom:16px"><div class="stat-ico" style="background:rgba(124,58,237,.15);margin:0"><i class="ri-alarm-line" style="color:var(--purple-light)"></i></div><div><div style="font-weight:700;font-size:.95rem;color:var(--text)">' +
//         r.title +
//         '</div><div style="font-size:.75rem;color:var(--text3)">#' +
//         r.id +
//         " · " +
//         r.category +
//         "</div></div></div>" +
//         '<div style="display:flex;flex-direction:column;gap:8px;margin-bottom:16px">' +
//         '<div style="display:flex;justify-content:space-between;padding:10px;border-radius:8px;background:var(--row-bg);border:1px solid var(--border2)"><span style="font-size:.78rem;color:var(--text3)">User</span><span style="font-size:1.20re;font-weight:600;color:var(--text)">' +
//         r.user.name +
//         "</span></div>" +
//         '<div style="display:flex;justify-content:space-between;padding:10px;border-radius:8px;background:var(--row-bg);border:1px solid var(--border2)"><span style="font-size:.78rem;color:var(--text3)">Date</span><span style="font-size:1.20re;font-weight:600;color:var(--text)">' +
//         due +
//         "</span></div>" +
//         '<div style="display:flex;justify-content:space-between;padding:10px;border-radius:8px;background:var(--row-bg);border:1px solid var(--border2)"><span style="font-size:.78rem;color:var(--text3)">Status</span><span class="badge badge-' +
//         (r.status === "active"
//             ? "teal"
//             : r.status === "completed"
//               ? "green"
//               : "red") +
//         '">' +
//         r.status +
//         "</span></div>" +
//         '<div style="display:flex;justify-content:space-between;padding:10px;border-radius:8px;background:var(--row-bg);border:1px solid var(--border2)"><span style="font-size:.78rem;color:var(--text3)">Priority</span><span class="badge badge-' +
//         (r.priority === "high"
//             ? "red"
//             : r.priority === "medium"
//               ? "amber"
//               : "slate") +
//         '">' +
//         r.priority +
//         "</span></div>" +
//         '<div style="display:flex;justify-content:space-between;padding:10px;border-radius:8px;background:var(--row-bg);border:1px solid var(--border2)"><span style="font-size:.78rem;color:var(--text3)">Created</span><span style="font-size:1.20re;font-weight:600;color:var(--text)">' +
//         created +
//         "</span></div>" +
//         "</div>" +
//         '<div><label class="label">Notes</label><textarea class="inp" rows="2" style="resize:none">' +
//         r.description +
//         "</textarea></div>" +
//         '<div style="margin-top:12px"><label class="label">Status</label><select class="inp"><option ' +
//         (r.status === "active" ? "selected" : "") +
//         ">active</option><option " +
//         (r.status === "completed" ? "selected" : "") +
//         ">completed</option><option " +
//         (r.status === "overdue" ? "selected" : "") +
//         ">overdue</option></select></div>";
//     openModal("view-reminder-modal");
// }

function openViewReminder(id) {

    var r = REMINDERS_DATA.find(function (x) {
        return x.id === id;
    });

    if (!r) return;

    var due = new Date(r.due).toLocaleDateString("en-GB", {
        day: "2-digit",
        month: "short",
        year: "numeric",
    });

    var created = r.created;

    var endDate = r.end_reminder_date
        ? new Date(r.end_reminder_date).toLocaleDateString("en-GB", {
              day: "2-digit",
              month: "short",
              year: "numeric",
          })
        : "N/A";

    document.getElementById("rem-modal-content").innerHTML =

        '<div style="display:flex;gap:10px;margin-bottom:16px">' +

        '<div class="stat-ico" style="background:rgba(124,58,237,.15);margin:0">' +
        '<i class="ri-alarm-line" style="color:var(--purple-light)"></i>' +
        '</div>' +

        '<div>' +

        '<div style="font-weight:700;font-size:.95rem;color:var(--text)">' +
        r.title +
        '</div>' +

        '<div style="font-size:.75rem;color:var(--text3)">' 
        + r.category +
        '</div>' +

        '</div></div>' +

        '<div style="display:flex;flex-direction:column;gap:8px;margin-bottom:16px">' +

        rowItem("User", r.user.name) +

        rowItem("Email", r.user.email || 'N/A') +

        rowItem("Category", r.category) +

        rowItem("Sub Category", r.subcategory || 'N/A') +

        rowItem("Reminder Date", due) +

        rowItem("End Reminder Date", endDate) +

        rowItem("Reminder Time", r.reminder_time || 'N/A') +

        rowItem("Provider", r.provider || 'N/A') +

       rowItem("Cost", `€ ${r.cost || '0'}`) +

        rowItem("Payment Frequency", r.payment_frequency || 'N/A') +

     

        rowItem("Reminder Status", r.reminder_status || 'N/A') +

        rowItem("Created", created) +

        '</div>' +

        '<div>' +
        '<label class="label">Description</label>' +
        '<textarea class="inp" rows="4" readonly style="resize:none">' +
        (r.description || '') +
        '</textarea>' +
        '</div>';

    openModal("view-reminder-modal");
}

function rowItem(label, value){

    return (
        '<div style="display:flex;justify-content:space-between;gap:20px;padding:10px;border-radius:8px;background:var(--row-bg);border:1px solid var(--border2)">' +

        '<span style="font-size:.78rem;color:var(--text3)">' +
        label +
        '</span>' +

        '<span style="font-size:.82rem;font-weight:600;color:var(--text);text-align:right">' +
        value +
        '</span>' +

        '</div>'
    );

}

/* ══════════════════════════════════════════
TRANSACTIONS
══════════════════════════════════════════ */

const ADMIN_TXNS = window.ADMIN_TXNS || [];

window.TRANSACTIONS = ADMIN_TXNS;

let txnFiltered = [...ADMIN_TXNS];
let txnPageNum = 1;
let txnPerPage = 10;
let currentTxnId = null;

// Badge color helper
function getBadgeClass(status) {
    if (status === "successful") return "green";
    if (status === "pending") return "amber";
    if (status === "refunded") return "red";
    return "slate";
}

// Top stats pills under heading
function renderTxnStats(data) {
    const total = data.length;
    const completed = data.filter((t) => t.status === "successful").length;
    // const pending   = data.filter(t => t.status === 'pending').length;
    const failed = data.filter((t) => t.status === "failed").length;

    const elTotal = document.getElementById("stats-total-count");
    const elCompleted = document.getElementById("stats-completed-count");
    // const elPending   = document.getElementById('stats-pending-count');
    const elRefunded = document.getElementById("stats-refunded-count");

    if (elTotal) elTotal.textContent = total;
    if (elCompleted) elCompleted.textContent = completed;
    // if (elPending)   elPending.textContent   = pending;
    if (elRefunded) elRefunded.textContent = failed;
}

// Main table render

function renderTransactions() {
    const data = txnFiltered;
    const totalPages = Math.max(1, Math.ceil(data.length / txnPerPage));
    if (txnPageNum > totalPages) txnPageNum = totalPages;

    const start = (txnPageNum - 1) * txnPerPage;
    const slice = data.slice(start, start + txnPerPage);

    const tbody = document.getElementById("txn-tbody");
    if (!tbody) return;

    const showingEl = document.getElementById("txn-showing");
    const totalEl = document.getElementById("txn-total");

    if (showingEl) showingEl.textContent = slice.length;
    if (totalEl) totalEl.textContent = data.length;

    tbody.innerHTML = slice
        .map(function (t, index) {
            const serialNo = start + index + 1;
            return `
            <tr>
              <td>
            <span style="font-weight:600">
                ${serialNo}
            </span>
        </td>
                <td>
                    <span class="mono" style="font-size:.73rem;color:var(--purple)">
                        ${t.txn_id}
                    </span>
                </td>

                <td>
                    <span class="mono" style="font-size:.73rem;color:var(--purple)">
                        ${t.tnx_order}
                    </span>
                </td>

                <td class="hide-mobile">
                    <div style="font-weight:700">${t.user_name}</div>
                    <div style="font-size:.78rem;color:var(--text3)">${t.user_email}</div>
                </td>

                <td class="hide-mobile">
                    <span class="badge badge-teal">${t.plan_name}</span>
                </td>

                <td>
                    <span style="font-weight:700;color:var(--text)">
                        £${Number(t.amount).toFixed(2)}
                    </span>
                </td>

               <td>
    <span class="badge badge-${getBadgeClass(t.status)}">
        ${
            t.status === "successful"
                ? "Paid"
                : t.status.charAt(0).toUpperCase() + t.status.slice(1)
        }
    </span>
</td>

                <td class="hide-mobile" style="font-size:.75rem;color:var(--text3)">
                    ${t.date}
                </td>

                <td style="text-align:right">
                    <div style="display:flex;gap:6px;justify-content:flex-end">
                        <button class="btn btn-ghost btn-xs" onclick="openViewTxn('${t.txn_id}')">
                            <i class="ri-eye-line"></i>
                        </button>
                        <button class="btn btn-ghost btn-xs" onclick="openAdminInvoicePopup('${t.txn_id}')">
                            <i class="ri-download-line"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
        })
        .join("");

    renderTxnStats(data);
    buildTxnPagination(totalPages);
}

// Pagination controls specific to transactions
function buildTxnPagination(totalPages) {
    const wrap = document.getElementById("txn-pagination");
    if (!wrap) return;

    if (totalPages <= 1) {
        wrap.innerHTML = "";
        return;
    }

    let html = "";

    html += `
        <button class="btn btn-ghost btn-xs"
                ${txnPageNum === 1 ? "disabled" : ""}
                onclick="setTxnPage(${txnPageNum - 1})">
            Prev
        </button>
    `;

    for (let i = 1; i <= totalPages; i++) {
        html += `
            <button class="btn btn-ghost btn-xs ${i === txnPageNum ? "active" : ""}"
                    onclick="setTxnPage(${i})">
                ${i}
            </button>
        `;
    }

    html += `
        <button class="btn btn-ghost btn-xs"
                ${txnPageNum === totalPages ? "disabled" : ""}
                onclick="setTxnPage(${txnPageNum + 1})">
            Next
        </button>
    `;

    wrap.innerHTML = html;
}

function setTxnPage(page) {
    txnPageNum = page;
    renderTransactions();
}

// Search + filter
function filterTxn() {
    const q = (document.getElementById("txn-search-input")?.value || "")
        .toLowerCase()
        .trim();
    const statusF =
        document.getElementById("txn-status-filter")?.value || "all";

    txnFiltered = ADMIN_TXNS.filter(function (t) {
        const searchableStatus = t.status === "successful" ? "paid" : t.status;

        const haystack = [
            t.txn_id,
            t.txn_order,
            t.user_name,
            t.user_email,
            t.plan_name,
            t.order_ref,
            searchableStatus,
        ]
            .join(" ")
            .toLowerCase();
        const matchQ = haystack.includes(q);
        const matchS = statusF === "all" || t.status === statusF;

        return matchQ && matchS;
    });

    txnPageNum = 1;
    renderTransactions();
}

// View txn modal
function openViewTxn(txnId) {
    const t = ADMIN_TXNS.find(function (x) {
        return x.txn_id === txnId;
    });

    if (!t) {
        toast("Transaction not found", "error");
        return;
    }

    currentTxnId = t.txn_id;

    const content = `
        <div style="display:flex;gap:10px;margin-bottom:16px">
            <div class="stat-ico" style="background:rgba(16,185,129,.12);margin:0">
                <i class="ri-bank-card-line" style="color:var(--green)"></i>
            </div>
            <div>
                <div style="font-weight:700;font-size:.95rem;color:var(--text)">${t.txn_id}</div>
                <div style="font-size:.75rem;color:var(--text3)">${t.plan_name}</div>
            </div>
        </div>

        <div style="display:flex;flex-direction:column;gap:8px">
            <div style="display:flex;justify-content:space-between;padding:10px;border-radius:8px;background:var(--row-bg);border:1px solid var(--border2)">
                <span style="font-size:.78rem;color:var(--text3)">Customer</span>
                <span style="font-size:.92rem;font-weight:600;color:var(--text)">${t.user_name}</span>
            </div>

            <div style="display:flex;justify-content:space-between;padding:10px;border-radius:8px;background:var(--row-bg);border:1px solid var(--border2)">
                <span style="font-size:.78rem;color:var(--text3)">Email</span>
                <span style="font-size:.92rem;font-weight:600;color:var(--text)">${t.user_email}</span>
            </div>

            <div style="display:flex;justify-content:space-between;padding:10px;border-radius:8px;background:var(--row-bg);border:1px solid var(--border2)">
                <span style="font-size:.78rem;color:var(--text3)">Order Ref</span>
                <span style="font-size:.92rem;font-weight:600;color:var(--text)">${t.order_ref}</span>
            </div>

            <div style="display:flex;justify-content:space-between;padding:10px;border-radius:8px;background:var(--row-bg);border:1px solid var(--border2)">
                <span style="font-size:.78rem;color:var(--text3)">Amount</span>
                <span style="font-size:.95rem;font-weight:800;color:var(--green)">£${Number(t.amount).toFixed(2)}</span>
            </div>

            <div style="display:flex;justify-content:space-between;padding:10px;border-radius:8px;background:var(--row-bg);border:1px solid var(--border2)">
                <span style="font-size:.78rem;color:var(--text3)">Status</span>
                <span class="badge badge-${getBadgeClass(t.status)}">${t.status}</span>
            </div>

            <div style="display:flex;justify-content:space-between;padding:10px;border-radius:8px;background:var(--row-bg);border:1px solid var(--border2)">
                <span style="font-size:.78rem;color:var(--text3)">Payment Method</span>
                <span style="font-size:.92rem;font-weight:600;color:var(--text)">${t.method}</span>
            </div>

            <div style="display:flex;justify-content:space-between;padding:10px;border-radius:8px;background:var(--row-bg);border:1px solid var(--border2)">
                <span style="font-size:.78rem;color:var(--text3)">Date</span>
                <span style="font-size:.92rem;font-weight:600;color:var(--text)">${t.date}</span>
            </div>
        </div>
    `;

    const el = document.getElementById("txn-modal-content");
    if (el) el.innerHTML = content;

    openModal("view-txn-modal");
}

// Modal footer button
function downloadCurrentTxnInvoice() {
    if (!currentTxnId) {
        toast("No transaction selected", "error");
        return;
    }
    openAdminInvoicePopup(currentTxnId);
}

// Opens invoice popup window
// function openAdminInvoicePopup(txnId) {
//     const txn = ADMIN_TXNS.find(item => item.txn_id === txnId);

//     if (!txn) {
//         toast('Transaction not found', 'error');
//         return;
//     }

//     const params = new URLSearchParams({
//         txn_id:         txn.txn_id,
//         txn_order:         txn.txn_order,
//         order_ref:      txn.order_ref,
//         customer_name:  txn.user_name,
//         customer_email: txn.user_email,
//         items:          JSON.stringify(txn.items || [txn.plan_name]),
//         amount:         txn.amount,
//         status:         txn.status,
//         date:           txn.date,
//         method:         txn.method
//     });

//     window.open(
//         `transaction-invoice?${params.toString()}`,
//         'adminInvoicePopup',
//         'width=980,height=760,top=40,left=120,resizable=yes,scrollbars=yes'
//     );
// }

function openAdminInvoicePopup(txnId) {
    const txn = ADMIN_TXNS.find((item) => item.txn_id === txnId);

    if (!txn) {
        toast("Transaction not found", "error");
        return;
    }

    if (!txn.invoice_path) {
        toast("Invoice file not found", "error");
        return;
    }

    const invoiceUrl = `/${txn.invoice_path}`;

    window.open(
        invoiceUrl,
        "adminInvoicePopup",
        "width=980,height=760,top=40,left=120,resizable=yes,scrollbars=yes",
    );
}

// Export CSV
function exportTransactionsCSV() {
    const headers = [
        "S.no",
        "Txn ID",
        "Order Id",
        "User",
        "Email",
        "Plan",
        "Amount",
        "Status",
        "Method",
        "Date",
    ];

    const rows = ADMIN_TXNS.map((t, index) => [
        index + 1, // Serial Number
        t.txn_id,
        t.tnx_order,
        t.user_name,
        t.user_email,
        t.plan_name,
        t.amount,
        t.status,
        t.method,
        t.date,
    ]);

    const csv = [headers, ...rows]
        .map((row) =>
            row
                .map((value) => `"${String(value).replace(/"/g, '""')}"`)
                .join(","),
        )
        .join("\n");

    const blob = new Blob([csv], { type: "text/csv;charset=utf-8;" });
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = "transactions.csv";
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);

    toast("Transactions exported", "success");
}

// Initial render when page is active
document.addEventListener("DOMContentLoaded", function () {
    // If you are using router with gop(), it already calls renderTransactions()
    // when page-transactions is active; calling again is safe.
    renderTransactions();
     filterReminders();
});

/* ══════════════════════════════════════════
CATEGORIES
══════════════════════════════════════════ */

function renderCategoryStats() {
    var totalCategories = CATS_DATA.length;
    var totalSubcategories = CATS_DATA.reduce(function (sum, c) {
        return sum + c.subcategories.length;
    }, 0);

    var topCategory = CATS_DATA.reduce(function (max, c) {
        return c.total > max.total ? c : max;
    }, CATS_DATA[0]);

    document.getElementById("stat-total-categories").textContent =
        totalCategories;
    document.getElementById("stat-total-subcategories").textContent =
        totalSubcategories;
    document.getElementById("stat-top-category").textContent =
        topCategory.name + " (" + topCategory.total + ")";
}

function renderAdminCategories() {
    renderCategoryStats();

    document.getElementById("admin-cat-grid").innerHTML = CATS_DATA.map(
        function (c) {
            var previewSubs = c.subcategories
                .slice(0, 3)
                .map(function (s) {
                    return (
                        '<span class="chip" style="font-size:.65rem">' +
                        s.name +
                        "</span>"
                    );
                })
                .join("");

            var moreCount =
                c.subcategories.length > 3
                    ? '<span class="chip" style="font-size:.65rem">+' +
                      (c.subcategories.length - 3) +
                      " more</span>"
                    : "";

            return (
                '<div class="card" style="padding:16px;cursor:pointer;transition:.2s ease" onclick="openCategoryDetail(' +
                c.id +
                ')">' +
                '<div style="display:flex;align-items:flex-start;justify-content:space-between;gap:8px;margin-bottom:12px">' +
                '<div style="display:flex;align-items:center;gap:10px">' +
                '<div style="width:44px;height:44px;border-radius:12px;background:' +
                c.bg +
                ';display:flex;align-items:center;justify-content:center">' +
                '<i class="' +
                c.icon +
                '" style="color:' +
                c.color +
                ';font-size:1.1rem"></i>' +
                "</div>" +
                "<div>" +
                '<div style="font-weight:800;font-size:.92rem;color:var(--text)">' +
                c.name +
                "</div>" +
                '<div style="font-size:.72rem;color:var(--text3);margin-top:2px">' +
                c.desc +
                "</div>" +
                "</div>" +
                "</div>" +
                '<div style="display:flex;gap:4px">' +

'<button class="btn btn-ghost btn-xs" onclick="event.stopPropagation();openEditCategory(' +
c.id +
')">' +
'<i class="ri-pencil-line"></i>' +
"</button>" +

'<button class="btn btn-danger btn-xs" onclick="event.stopPropagation();deleteCategory(' +
c.id +
')">' +
'<i class="ri-delete-bin-line"></i>' +
"</button>" +

"</div>" +
                "</div>" +
                '<div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px">' +
                '<span class="badge badge-teal">' +
                c.subcategories.length +
                " subcategories</span>" +
                '<span class="badge badge-purple">' +
                c.total.toLocaleString() +
                " reminders</span>" +
                "</div>" +
                '<div  style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px">' +
                '<span class="hidden" style="font-size:.72rem;color:var(--text3)">Usage</span>' +
               
                "</div>" +
                '<div class="prog-track hidden" style="margin-bottom:12px">' +
                '<div class="prog-fill" style="width:' +
                Math.min((c.total / 700) * 100, 100).toFixed(0) +
                "%;background:" +
                c.color +
                '"></div>' +
                "</div>" +
                '<div style="font-size:.68rem;color:var(--text3);margin-bottom:7px">Subcategory Preview</div>' +
                '<div style="display:flex;gap:6px;flex-wrap:wrap">' +
                previewSubs +
                moreCount +
                "</div>" +
                "</div>"
            );
        },
    ).join("");
}

function deleteCategory(id) {
    var c = CATS_DATA.find(function (x) {
        return x.id === id;
    });
    if (!c) return;
    openConfirm(
        'Delete "' + c.name + '" category?',
        function () {
            fetch('/admin/categories/delete', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    'Accept': 'application/json'
                },

                body: JSON.stringify({
                    id: id
                })

            })
            .then(res => res.json())
            .then(data => {
                if (data.status) {
                   var index = CATS_DATA.findIndex(function (x) {
    return x.id === id;
});

if (index !== -1) {
    CATS_DATA.splice(index, 1);
}
                    renderAdminCategories();
                    toast(data.message, 'success');
                } else {
                    toast(data.message || 'Something went wrong', 'error');
                }
            })
            .catch(err => {
                console.log(err);
                toast('Something went wrong', 'error');

            });

        }

    );

}

function openCategoryDetail(categoryId) {
    var c = CATS_DATA.find(function (x) {
        return x.id === categoryId;
    });
    if (!c) return;

    var subsHtml = c.subcategories
        .map(function (s) {
            return (
                '<div class="card" style="padding:12px;border-radius:12px;background:var(--row-bg);border:1px solid var(--border2)">' +
                '<div style="display:flex;align-items:center;justify-content:space-between;gap:8px">' +
                "<div>" +
                '<div style="font-size:.86rem;font-weight:700;color:var(--text)">' +
                s.name +
                "</div>" +
                '<div style="font-size:.72rem;color:var(--text3);margin-top:2px">' +
                (s.total || 0) +
                " reminders</div>" +
                "</div>" +
                '<div style="display:flex;gap:6px">' +
                '<button class="btn btn-ghost btn-xs" onclick="openEditSubcategory(' +
                c.id +
                "," +
                s.id +
                ')">' +
                '<i class="ri-pencil-line"></i>' +
                "</button>" +
                '<button class="btn btn-danger btn-xs" onclick="deleteSubcategory(' +
                c.id +
                "," +
                s.id +
                ')">' +
                '<i class="ri-delete-bin-line"></i>' +
                "</button>" +
                "</div>" +
                "</div>" +
                "</div>"
            );
        })
        .join("");

    document.getElementById("category-detail-content").innerHTML =
        '<div style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;margin-bottom:16px;flex-wrap:wrap">' +
        '<div style="display:flex;align-items:center;gap:12px">' +
        '<div style="width:54px;height:54px;border-radius:14px;background:' +
        c.bg +
        ';display:flex;align-items:center;justify-content:center">' +
        '<i class="' +
        c.icon +
        '" style="color:' +
        c.color +
        ';font-size:1.35rem"></i>' +
        "</div>" +
        "<div>" +
        '<div style="font-size:1rem;font-weight:800;color:var(--text)">' +
        c.name +
        "</div>" +
        '<div style="font-size:.76rem;color:var(--text3);margin-top:3px">' +
        c.desc +
        "</div>" +
        "</div>" +
        "</div>" +
        '<div style="display:flex;gap:8px;flex-wrap:wrap">' +
        '<button class="btn btn-ghost btn-sm" onclick="openEditCategory(' +
        c.id +
        ')"><i class="ri-pencil-line"></i> Edit</button>' +

       '<button class="btn btn-primary btn-sm" onclick="prefillSubcategoryParent(' +
c.id +
");closeModal('category-detail-modal');openModal('add-subcategory-modal')\"><i class=\"ri-node-tree\"></i> Add Subcategory</button>"
        
        +
        "</div>" +
        "</div>" +
        '<div style="display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:10px;margin-bottom:16px">' +
        '<div class="card" style="padding:12px"><div style="font-size:.72rem;color:var(--text3)">Category</div><div style="font-weight:800;color:var(--text);margin-top:4px">' +
        c.name +
        "</div></div>" +
        '<div class="card" style="padding:12px"><div style="font-size:.72rem;color:var(--text3)">Subcategories</div><div style="font-weight:800;color:var(--text);margin-top:4px">' +
        c.subcategories.length +
        "</div></div>" +
        '<div class="card" style="padding:12px"><div style="font-size:.72rem;color:var(--text3)">Reminder</div><div style="font-weight:800;color:var(--text);margin-top:4px">' +
        c.total.toLocaleString() +
        "</div></div>" +
        "</div>" +
        '<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px">' +
        '<div style="font-size:.84rem;font-weight:700;color:var(--text)">Subcategories</div>' +
        '<span class="badge badge-purple">' +
        c.subcategories.length +
        " items</span>" +
        "</div>" +
        '<div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px">' +
        subsHtml +
        "</div>";

    openModal("category-detail-modal");
}

function prefillSubcategoryParent(id) {

    setTimeout(() => {

        const select = document.getElementById('subcategory-parent');

        if (!select) return;

        if (select.tomselect) {
            select.tomselect.setValue(String(id));
        }

        select.value = id;

    }, 50);

}

function deleteSubcategory(categoryId, subId) {
    var c = CATS_DATA.find(function (x) {
        return x.id === categoryId;
    });
    if (!c) return;
    var s = c.subcategories.find(function (x) {
        return x.id === subId;
    });
    if (!s) return;
    openConfirm(
        'Delete "' + s.name + '" subcategory?',
        function () {
            fetch('/admin/subcategories/delete', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    id: subId
                })

            })
            .then(res => res.json())
            .then(data => {
                if (data.status) {
                    c.subcategories = c.subcategories.filter(function (x) {
                        return x.id !== subId;
                    });
                    renderAdminCategories();
                    closeModal('category-detail-modal');
                    toast(data.message, 'success');
                } else {
                    toast(data.message || 'Something went wrong', 'error');
                }
            })
            .catch(err => {
                console.log(err);
                toast('Something went wrong', 'error');
            });
        }
    );
}

function populateSubcategoryParents() {
    var sel = document.getElementById("subcategory-parent");
    if (!sel) return;
    sel.innerHTML = CATS_DATA.map(function (c) {
        return '<option value="' + c.id + '">' + c.name + "</option>";
    }).join("");
}

function prefillSubcategoryParent(categoryId) {
    populateSubcategoryParents();

    setTimeout(() => {
        const select = document.getElementById("subcategory-parent");
        if (!select) return;

        if (select.tomselect) {
            select.tomselect.setValue(String(categoryId));
        } else {
            select.value = categoryId;
        }
    }, 50);
}



function createCategory() {
    var name = document.getElementById("cat-name").value.trim();
    var icon =
        document.getElementById("cat-icon").value.trim() || "ri-folder-line";
    var color = document.getElementById("cat-color").value || "#7c3aed";
    var desc = document.getElementById("cat-desc").value.trim();

    if (!name) {
        toast("Category name is required", "error");
        return;
    }

    CATS_DATA.push({
        id: Date.now(),
        name: name,
        icon: icon,
        color: color,
        bg: hexToRgba(color, 0.12),
        desc: desc || "New category",
        total: 0,
        subcategories: [],
    });

    toast("Category created!", "success");
    closeModal("add-category-modal");
    renderAdminCategories();

    document.getElementById("cat-name").value = "";
    document.getElementById("cat-icon").value = "";
    document.getElementById("cat-desc").value = "";
}

function hexToRgba(hex, alpha) {
    var r = parseInt(hex.slice(1, 3), 16);
    var g = parseInt(hex.slice(3, 5), 16);
    var b = parseInt(hex.slice(5, 7), 16);
    return "rgba(" + r + "," + g + "," + b + "," + alpha + ")";
}

function openEditCategory(categoryId) {
    var c = CATS_DATA.find(function (item) {
        return item.id === categoryId;
    });

    if (!c) {
        toast("Category not found", "error");
        return;
    }

    document.getElementById("edit-cat-id").value = c.id;
    document.getElementById("edit-cat-name").value = c.name || "";
    document.getElementById("edit-cat-icon").value = c.icon || "";
    document.getElementById("edit-cat-color").value = c.color || "#7c3aed";
    document.getElementById("edit-cat-desc").value = c.desc || "";

    openModal("edit-category-modal");
}

// function saveCategoryEdit() {
//     var id = parseInt(document.getElementById("edit-cat-id").value);
//     var c = CATS_DATA.find(function (item) {
//         return item.id === id;
//     });

//     if (!c) {
//         toast("Category not found", "error");
//         return;
//     }

//     var name = document.getElementById("edit-cat-name").value.trim();
//     var icon = document.getElementById("edit-cat-icon").value.trim();
//     var color = document.getElementById("edit-cat-color").value;
//     var desc = document.getElementById("edit-cat-desc").value.trim();

//     if (!name) {
//         toast("Category name is required", "error");
//         return;
//     }

//     c.name = name;
//     c.icon = icon || "ri-folder-line";
//     c.color = color;
//     c.bg = hexToRgba(color, 0.12);
//     c.desc = desc;

//     renderAdminCategories();
//     closeModal("edit-category-modal");
//     toast("Category updated successfully", "success");
// }

function saveCategoryEdit() {
    document.querySelectorAll('.err').forEach(el => {
        el.innerText = '';
    });
    let payload = {
        id: document.getElementById("edit-cat-id").value,
        name: document.getElementById("edit-cat-name").value.trim(),
        icon: document.getElementById("edit-cat-icon").value.trim(),
        color: document.getElementById("edit-cat-color").value,
        description: document.getElementById("edit-cat-desc").value.trim()
    };
    fetch('/admin/categories/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector(
                'meta[name="csrf-token"]'
            ).content,
            'Accept': 'application/json'
        },
        body: JSON.stringify(payload)
    })
    .then(async response => {
        const data = await response.json();
        if (response.status === 422) {
            Object.keys(data.errors).forEach(key => {
                let errorEl = document.getElementById(
                    'edit-cat-' + key + '-error'
                );
                if (errorEl) {
                    errorEl.innerText = data.errors[key][0];
                }
            });
            return;
        }
        if (data.status) {
            var c = CATS_DATA.find(function (item) {
                return item.id == payload.id;
            });
            if (c) {
                c.name = payload.name;
                c.icon = payload.icon || 'ri-folder-line';
                c.color = payload.color;
                c.bg = hexToRgba(payload.color, 0.12);
                c.desc = payload.description;
            }
            renderAdminCategories();
            closeModal("edit-category-modal");
            toast(data.message, 'success');
            setTimeout(()=>{
                location.reload();
            },1500)
        }
    })
    .catch(err => {
        console.log(err);
        toast('Something went wrong', 'error');
    });
}

function openEditSubcategory(categoryId, subId) {
    var parent = CATS_DATA.find(function (c) {
        return c.id === categoryId;
    });

    if (!parent) {
        toast("Parent category not found", "error");
        return;
    }

    var sub = parent.subcategories.find(function (s) {
        return s.id === subId;
    });

    if (!sub) {
        toast("Subcategory not found", "error");
        return;
    }

    var sel = document.getElementById("edit-sub-parent");
    sel.innerHTML = CATS_DATA.map(function (c) {
        return '<option value="' + c.id + '">' + c.name + "</option>";
    }).join("");

    document.getElementById("edit-sub-id").value = sub.id;
    document.getElementById("edit-sub-old-parent-id").value = parent.id;
    document.getElementById("edit-sub-parent").value = parent.id;
    document.getElementById("edit-sub-name").value = sub.name || "";
    document.getElementById("edit-sub-desc").value = sub.desc || "";

    openModal("edit-subcategory-modal");
}

// function saveSubcategoryEdit() {
//     var subId = parseInt(document.getElementById("edit-sub-id").value);
//     var oldParentId = parseInt(
//         document.getElementById("edit-sub-old-parent-id").value,
//     );
//     var newParentId = parseInt(
//         document.getElementById("edit-sub-parent").value,
//     );
//     var name = document.getElementById("edit-sub-name").value.trim();
//     var desc = document.getElementById("edit-sub-desc").value.trim();

//     if (!name) {
//         toast("Subcategory name is required", "error");
//         return;
//     }

//     var oldParent = CATS_DATA.find(function (c) {
//         return c.id === oldParentId;
//     });

//     var newParent = CATS_DATA.find(function (c) {
//         return c.id === newParentId;
//     });

//     if (!oldParent || !newParent) {
//         toast("Category not found", "error");
//         return;
//     }

//     var subIndex = oldParent.subcategories.findIndex(function (s) {
//         return s.id === subId;
//     });

//     if (subIndex === -1) {
//         toast("Subcategory not found", "error");
//         return;
//     }

//     var sub = oldParent.subcategories[subIndex];

//     if (oldParentId === newParentId) {
//         sub.name = name;
//         sub.desc = desc;
//     } else {
//         oldParent.subcategories.splice(subIndex, 1);
//         sub.name = name;
//         sub.desc = desc;
//         newParent.subcategories.push(sub);
//     }

//     renderAdminCategories();
//     closeModal("edit-subcategory-modal");
//     toast("Subcategory updated successfully", "success");
//     openCategoryDetail(newParentId);
// }

function saveSubcategoryEdit() {

    document.querySelectorAll('.err').forEach(el => {
        el.innerText = '';
    });

    let payload = {

        id: document.getElementById("edit-sub-id").value,

        category_id: document.getElementById("edit-sub-parent").value,

        name: document.getElementById("edit-sub-name").value.trim(),

        description: document.getElementById("edit-sub-desc").value.trim()

    };

    fetch('/admin/subcategories/update', {

        method: 'POST',

        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector(
                'meta[name="csrf-token"]'
            ).content,
            'Accept': 'application/json'
        },

        body: JSON.stringify(payload)

    })

    .then(async response => {

        const data = await response.json();

        if (response.status === 422) {

            Object.keys(data.errors).forEach(key => {

                let errorEl = document.getElementById(
                    'edit-sub-' + key + '-error'
                );

                if (errorEl) {

                    errorEl.innerText = data.errors[key][0];

                }

            });

            return;
        }

        if (data.status) {

            toast(data.message, 'success');

            closeModal("edit-subcategory-modal");

            setTimeout(() => {
                location.reload();
            }, 1000);

        }

    })

    .catch(err => {

        console.log(err);

        toast('Something went wrong', 'error');

    });

}


/* ══════════════════════════════════════════
NOTIFICATIONS
══════════════════════════════════════════ */
function renderNotifications() {
    var notifs = [
        {
            icon: "ri-alarm-line",
            bg: "rgba(245,158,11,.12)",
            col: "#f59e0b",
            title: "Car Insurance Due Soon",
            desc: "User Kishore Rex has a reminder due in 3 days",
            time: "2 hours ago",
            unread: true,
        },
        {
            icon: "ri-bug-line",
            bg: "rgba(244,63,94,.12)",
            col: "#f43f5e",
            title: "Bug Report: Push Notification Failure",
            desc: "SMS delivery failing for UK numbers with +44",
            time: "5 hours ago",
            unread: true,
        },
        {
            icon: "ri-user-add-line",
            bg: "rgba(16,185,129,.12)",
            col: "#10b981",
            title: "New User Registration",
            desc: "Sarah Johnson registered with Basic Annual plan",
            time: "1 day ago",
            unread: true,
        },
        {
            icon: "ri-money-pound-circle-line",
            bg: "rgba(16,185,129,.12)",
            col: "#10b981",
            title: "Payment Received",
            desc: "£2.40 from Michael Chen — Basic Annual",
            time: "1 day ago",
            unread: false,
        },
        {
            icon: "ri-shield-check-line",
            bg: "rgba(6,182,212,.12)",
            col: "#06b6d4",
            title: "Security Alert",
            desc: "New admin login from 192.168.1.10",
            time: "2 days ago",
            unread: true,
        },
    ];
    document.getElementById("admin-notif-list").innerHTML = notifs
        .map(function (n) {
            return (
                '<div class="act-item" style="' +
                (n.unread
                    ? "background:rgba(124,58,237,.06);border-color:rgba(124,58,237,.2)"
                    : "") +
                '">' +
                '<div style="width:36px;height:36px;border-radius:10px;background:' +
                n.bg +
                ';display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="' +
                n.icon +
                '" style="color:' +
                n.col +
                '"></i></div>' +
                '<div style="flex:1;min-width:0"><div style="font-size:.84rem;font-weight:600;color:var(--text)">' +
                n.title +
                '</div><div style="font-size:.75rem;color:var(--text3);margin-top:2px">' +
                n.desc +
                '</div><div style="font-size:.7rem;color:var(--text4);margin-top:4px"><i class="ri-time-line"></i> ' +
                n.time +
                "</div></div>" +
                '<div style="display:flex;gap:4px;flex-shrink:0">' +
                (n.unread
                    ? "<button class=\"btn btn-ghost btn-xs\" onclick=\"this.closest('.act-item').style.background='';this.closest('.act-item').style.borderColor='';this.remove();toast('Marked as read','success')\"><i class=\"ri-check-line\"></i></button>"
                    : "") +
                "<button class=\"btn btn-danger btn-xs\" onclick=\"this.closest('.act-item').remove();toast('Deleted','info')\"><i class=\"ri-delete-bin-line\"></i></button></div></div>"
            );
        })
        .join("");
}

/* ══════════════════════════════════════════
AUDIT LOG
══════════════════════════════════════════ */
function renderAudit() {
    var data = auditFiltered;
    var totalPages = Math.ceil(data.length / auditPerPage);
    var start = (auditPageNum - 1) * auditPerPage;
    var slice = data.slice(start, start + auditPerPage);
    document.getElementById("audit-showing").textContent = slice.length;
    document.getElementById("audit-total").textContent = data.length;
    document.getElementById("audit-list").innerHTML = slice
        .map(function (a) {
            return (
                '<div class="act-item">' +
                '<div style="width:36px;height:36px;border-radius:10px;background:' +
                a.col +
                '22;display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="' +
                a.icon +
                '" style="color:' +
                a.col +
                '"></i></div>' +
                '<div style="flex:1;min-width:0"><div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap"><span style="font-size:.84rem;font-weight:700;color:var(--text)">' +
                a.action +
                '</span><span style="font-size:.65rem;color:var(--text3);font-weight:600">by ' +
                a.actor +
                '</span></div><div style="font-size:.75rem;color:var(--text3);margin-top:2px">' +
                a.detail +
                '</div><div style="font-size:.7rem;color:var(--text4);margin-top:4px"><i class="ri-time-line"></i> ' +
                a.time +
                "</div></div>" +
                '<span class="mono" style="font-size:.65rem;color:var(--text4);flex-shrink:0">#' +
                String(Math.floor(Math.random() * 9000 + 1000)) +
                "</span></div>"
            );
        })
        .join("");
    buildPagination(
        "audit-pagination",
        auditPageNum,
        totalPages,
        "setAuditPage",
    );
}

function setAuditPage(p) {
    auditPageNum = p;
    renderAudit();
}

function filterAudit(q) {
    if (q === undefined) q = "";
    q = q.toLowerCase();
    var actionF =
        (document.getElementById("audit-action-filter") || {}).value || "all";
    auditFiltered = AUDIT_DATA.filter(function (a) {
        var matchQ = (a.action + a.detail + a.actor).toLowerCase().includes(q);
        var matchA = actionF === "all" || a.type === actionF;
        return matchQ && matchA;
    });
    auditPageNum = 1;
    renderAudit();
}

/* ══════════════════════════════════════════
FEEDBACK
══════════════════════════════════════════ */
var currentFeedbackIndex = null;
var currentFilteredData = [];

function renderFeedback() {
    var fbFiltered = FEEDBACK_DATA;

    var typeF =
        (document.getElementById("fb-type-filter") || {}).value || "all";

    var statusF =
        (document.getElementById("fb-status-filter") || {}).value || "all";

    if (typeF !== "all")
        fbFiltered = fbFiltered.filter(function (f) {
            return f.type === typeF;
        });

    if (statusF !== "all")
        fbFiltered = fbFiltered.filter(function (f) {
            return f.status === statusF;
        });

    currentFilteredData = fbFiltered;

    document.getElementById("feedback-list").innerHTML = fbFiltered
        .map(function (f, index) {
            return (
                '<div class="act-item" data-feedback-index="' +
                index +
                '" style="' +
                (f.status === "pending"
                    ? "border-color:rgba(244,63,94,.25);background:rgba(244,63,94,.04)"
                    : "") +
                '">' +
                '<div style="width:36px;height:36px;border-radius:10px;background:' +
                f.col +
                '22;display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="' +
                f.icon +
                '" style="color:' +
                f.col +
                '"></i></div>' +
                '<div style="flex:1;min-width:0">' +
                '<div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-bottom:2px">' +
                '<span style="font-size:.84rem;font-weight:600;color:var(--text)">' +
                f.user +
                "</span>" +
                '<span class="badge badge-' +
                (f.type === "high"
                    ? "red"
                    : f.type === "medium"
                      ? "slate"
                      : "green") +
                '" style="font-size:.6rem">' +
                f.type +
                "</span>" +
                '<span class="badge badge-' +
                (f.status === "open"
                    ? "red"
                    : f.status === "pending"
                      ? "amber"
                      : "green") +
                '" style="font-size:.6rem" data-status-badge="' +
                index +
                '">' +
                f.status +
                "</span></div>" +
                '<div style="font-size:.79rem;color:var(--text3)">' +
                f.msg +
                "</div>" +
                '<div style="font-size:.7rem;color:var(--text4);margin-top:4px">' +
                f.time +
                "</div></div>" +
                '<div style="display:flex;gap:4px;flex-shrink:0">' +
                (f.status === "resolved"
                    ? '<button class="btn btn-success btn-xs" onclick="openReplyModal(' +
                      index +
                      ')">' +
                      '<i class="ri-check-double-line"></i> Resolved' +
                      "</button>"
                    : '<button class="btn btn-primary btn-xs" onclick="openReplyModal(' +
                      index +
                      ')">' +
                      '<i class="ri-reply-line"></i> Reply' +
                      "</button>") +
                "</div></div>"
            );
        })
        .join("");
}

function filterFeedback() {
    renderFeedback();
}

// function openReplyModal(index) {
//     currentFeedbackIndex = index;
//     var feedback = currentFilteredData[index];

//     // Populate display fields
//     document.getElementById("display-name").textContent = feedback.user || "-";
//     document.getElementById("display-email").textContent =
//         feedback.email || "-";
//     document.getElementById("display-phone").textContent =
//         feedback.phone || "-";
//     document.getElementById("display-subject").textContent =
//         feedback.subject || "No Subject";
//     document.getElementById("display-category").textContent =
//         feedback.category || "-";
//     document.getElementById("display-message").textContent =
//         feedback.msg || "-";

//     // Display type badge
//     var typeBadgeColor =
//         feedback.type === "bug"
//             ? "red"
//             : feedback.type === "feature"
//               ? "amber"
//               : "green";
//     document.getElementById("display-type-badge").innerHTML =
//         '<span class="badge badge-' +
//         typeBadgeColor +
//         '" style="font-size:.7rem">' +
//         (feedback.type || "-") +
//         "</span>";

//     // Clear previous message
//     document.getElementById("reply-message").value = "";

//     // Show modal
//     document.getElementById("replyMailModal").style.display = "flex";
// }

function openReplyModal(index) {
    currentFeedbackIndex = index;

    var feedback = currentFilteredData[index];

    document.getElementById("display-name").textContent = feedback.user || "-";

    document.getElementById("display-email").textContent =
        feedback.email || "-";

    document.getElementById("display-phone").textContent =
        feedback.phone || "-";

    document.getElementById("display-subject").textContent =
        feedback.subject || "No Subject";

    document.getElementById("display-category").textContent =
        feedback.category || "-";

    document.getElementById("display-message").textContent =
        feedback.msg || "-";

    var typeBadgeColor =
        feedback.type === "high"
            ? "red"
            : feedback.type === "medium"
              ? "slate"
              : "green";

    document.getElementById("display-type-badge").innerHTML =
        '<span class="badge badge-' +
        typeBadgeColor +
        '" style="font-size:.7rem">' +
        (feedback.type || "-") +
        "</span>";

    // Reply textarea
    document.getElementById("reply-message").value = feedback.admin_reply || "";

    // Button & textarea handling
    let textarea = document.getElementById("reply-message");

    let submitBtn = document.querySelector(
        '#replyMailForm button[type="submit"]',
    );

    if (feedback.status === "resolved") {
        textarea.readOnly = true;

        textarea.style.opacity = "0.7";

        submitBtn.style.display = "none";
    } else {
        textarea.readOnly = false;

        textarea.style.opacity = "1";

        submitBtn.style.display = "inline-flex";
    }

    document.getElementById("replyMailModal").style.display = "flex";
}

function closeReplyModal() {
    document.getElementById("replyMailModal").style.display = "none";
    document.getElementById("replyMailForm").reset();
    currentFeedbackIndex = null;
}

// Handle form submission
document.addEventListener("DOMContentLoaded", function () {
    var form = document.getElementById("replyMailForm");

    if (form) {
        form.addEventListener("submit", function (e) {
            e.preventDefault();

            var message = document.getElementById("reply-message").value;

            if (!message.trim()) {
                toast("Please enter a reply message", "error");

                return;
            }

            var feedback = currentFilteredData[currentFeedbackIndex];

            var btn = this.querySelector('button[type="submit"]');

            btn.disabled = true;

            btn.innerHTML =
                '<i class="ri-loader-4-line spinner"></i> Sending...';

            fetch("/admin/feedback/reply", {
                method: "POST",

                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]',
                    ).content,
                    Accept: "application/json",
                },

                body: JSON.stringify({
                    id: feedback.id,

                    reply: message,
                }),
            })
                .then((res) => res.json())
                .then((data) => {
                    if (data.status) {
                        // Update local data
                        for (var i = 0; i < FEEDBACK_DATA.length; i++) {
                            if (FEEDBACK_DATA[i].id === feedback.id) {
                                FEEDBACK_DATA[i].status = "resolved";

                                FEEDBACK_DATA[i].admin_reply = message;

                                break;
                            }
                        }

                        toast(data.message, "success");

                        closeReplyModal();

                        setTimeout(() => {
                            location.reload();
                        }, 1500);

                        renderFeedback();
                    } else {
                        toast("Something went wrong", "error");
                    }

                    btn.disabled = false;

                    btn.innerHTML =
                        '<i class="ri-send-plane-line"></i> Send Reply';
                })
                .catch((err) => {
                    console.log(err);

                    toast("Something went wrong", "error");

                    btn.disabled = false;

                    btn.innerHTML =
                        '<i class="ri-send-plane-line"></i> Send Reply';
                });
        });
    }
});

// Close modal when clicking outside
document.addEventListener("click", function (e) {
    var modal = document.getElementById("replyMailModal");
    if (e.target === modal) {
        closeReplyModal();
    }
});

// Close modal with ESC key
document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
        closeReplyModal();
    }
});

/* ══════════════════════════════════════════
PROFILE
══════════════════════════════════════════ */
function renderProfileActivity() {
    var acts = [
        {
            icon: "ri-login-box-line",
            col: "#10b981",
            txt: "Logged in from London, UK",
            time: "Today 09:30",
        },
        {
            icon: "ri-user-settings-line",
            col: "#7c3aed",
            txt: "Profile details updated",
            time: "Yesterday 16:45",
        },
        {
            icon: "ri-key-2-line",
            col: "#f59e0b",
            txt: "Created new role — Content Manager",
            time: "Apr 24",
        },
        {
            icon: "ri-send-plane-line",
            col: "#06b6d4",
            txt: "Broadcast email sent to all users",
            time: "Apr 22",
        },
    ];
    var el = document.getElementById("profile-activity");
    if (el)
        el.innerHTML = acts
            .map(function (a) {
                return (
                    '<div class="act-item"><div style="width:30px;height:30px;border-radius:8px;background:' +
                    a.col +
                    '22;display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="' +
                    a.icon +
                    '" style="color:' +
                    a.col +
                    ';font-size:.85rem"></i></div><div style="flex:1"><div style="font-size:.8rem;color:var(--text2)">' +
                    a.txt +
                    '</div><div style="font-size:.7rem;color:var(--text4);margin-top:2px">' +
                    a.time +
                    "</div></div></div>"
                );
            })
            .join("");
}

/* ══════════════════════════════════════════
SETTINGS
══════════════════════════════════════════ */
function initSettings() {
    var flags = [
        {
            label: "User Registration",
            desc: "Allow new users to sign up",
            on: true,
        },
        {
            label: "Email Notifications",
            desc: "System sends email alerts",
            on: true,
        },
        {
            label: "SMS Notifications",
            desc: "Twilio SMS gateway active",
            on: true,
        },
        {
            label: "WhatsApp Integration",
            desc: "WhatsApp Business API",
            on: true,
        },
        {
            label: "Analytics Tracking",
            desc: "Collect usage analytics",
            on: false,
        },
        { label: "Referral Program", desc: "User referral rewards", on: false },
    ];
    var el = document.getElementById("feature-flags");
    if (el)
        el.innerHTML = flags
            .map(function (f) {
                return (
                    '<div style="display:flex;align-items:center;justify-content:space-between;padding:10px;border-radius:var(--radius-sm);background:var(--row-bg);border:1px solid var(--border2)"><div><div style="font-size:.84rem;font-weight:600;color:var(--text2)">' +
                    f.label +
                    '</div><div style="font-size:.72rem;color:var(--text3)">' +
                    f.desc +
                    '</div></div><button class="toggle ' +
                    (f.on ? "on" : "") +
                    "\" onclick=\"this.classList.toggle('on');toast('" +
                    f.label +
                    " toggled','info')\"></button></div>"
                );
            })
            .join("");

    var plans = [
        {
            name: "Basic Annual",
            price: "£2.40",
            period: "year",
            features: "Unlimited reminders, Email, SMS, WhatsApp",
            color: "#7c3aed",
        },
        {
            name: "Pro (Coming Soon)",
            price: "£9.99",
            period: "year",
            features: "All Basic features + Priority support + API access",
            color: "#0d9488",
        },
        {
            name: "Family (Coming Soon)",
            price: "£14.99",
            period: "year",
            features: "Up to 5 members + All Pro features",
            color: "#f59e0b",
        },
    ];
    var pc = document.getElementById("plan-config");
    if (pc)
        pc.innerHTML = plans
            .map(function (p) {
                return (
                    '<div style="padding:14px;border-radius:var(--radius-sm);border:1px solid ' +
                    p.color +
                    "33;background:" +
                    p.color +
                    '0d"><div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px"><div style="font-weight:700;font-size:.87rem;color:var(--text)">' +
                    p.name +
                    '</div><div style="font-weight:800;font-size:1rem;color:' +
                    p.color +
                    '">' +
                    p.price +
                    '<span style="font-size:.72rem;font-weight:400;color:var(--text3)">/' +
                    p.period +
                    '</span></div></div><div style="font-size:.77rem;color:var(--text3);margin-bottom:10px">' +
                    p.features +
                    '</div><div style="display:flex;gap:6px"><button class="btn btn-ghost btn-xs" onclick="toast(\'Editing plan…\',\'info\')"><i class="ri-pencil-line"></i> Edit</button><button class="toggle" onclick="this.classList.toggle(\'on\')"></button></div></div>'
                );
            })
            .join("");

    var integrations = [
        {
            icon: "ri-mail-send-line",
            name: "Mailgun",
            desc: "Email delivery service",
            col: "#f43f5e",
            connected: true,
        },
        {
            icon: "ri-message-2-line",
            name: "Twilio",
            desc: "SMS & WhatsApp gateway",
            col: "#f43f5e",
            connected: true,
        },
        {
            icon: "ri-google-line",
            name: "Google Analytics",
            desc: "Usage analytics tracking",
            col: "#f59e0b",
            connected: false,
        },
        {
            icon: "ri-slack-line",
            name: "Slack",
            desc: "Admin alert notifications",
            col: "#10b981",
            connected: false,
        },
        {
            icon: "ri-stripe-line",
            name: "Stripe",
            desc: "Payment processing",
            col: "#7c3aed",
            connected: true,
        },
    ];
    var il = document.getElementById("integrations-list");
    if (il)
        il.innerHTML = integrations
            .map(function (i) {
                return (
                    '<div class="card" style="padding:16px;display:flex;align-items:center;gap:12px"><div style="width:44px;height:44px;border-radius:12px;background:' +
                    i.col +
                    '22;display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="' +
                    i.icon +
                    '" style="color:' +
                    i.col +
                    ';font-size:1.2rem"></i></div><div style="flex:1"><div style="font-weight:700;font-size:.87rem;color:var(--text)">' +
                    i.name +
                    '</div><div style="font-size:.75rem;color:var(--text3)">' +
                    i.desc +
                    '</div></div><span class="badge badge-' +
                    (i.connected ? "green" : "slate") +
                    '">' +
                    (i.connected ? "Connected" : "Disconnected") +
                    '</span><button class="btn btn-' +
                    (i.connected ? "danger" : "primary") +
                    ' btn-sm" onclick="toast(\'' +
                    (i.connected ? "Disconnected" : "Connected") +
                    " " +
                    i.name +
                    "','" +
                    (i.connected ? "warning" : "success") +
                    '\')"><i class="ri-' +
                    (i.connected ? "link-unlink" : "link") +
                    '-line"></i> ' +
                    (i.connected ? "Disconnect" : "Connect") +
                    "</button></div>"
                );
            })
            .join("");
}

/* ══════════════════════════════════════════
UTILS
══════════════════════════════════════════ */
function toggleAllCB(master, cls) {
    document.querySelectorAll("." + cls).forEach(function (cb) {
        cb.checked = master.checked;
    });
}

/* ══════════════════════════════════════════
INIT
══════════════════════════════════════════ */
document.addEventListener("DOMContentLoaded", function () {
    initDash();
});
document.addEventListener("DOMContentLoaded", function () {
    const page = document.querySelector(".page.active");

    if (!page) return;

    const id = page.id;

    if (id === "page-dashboard") initDash();
    if (id === "page-analytics") initAnalytics();
    if (id === "page-users") renderUsers();
    if (id === "page-staff") renderStaff();
    if (id === "page-roles") renderRoles();
    if (id === "page-reminders") renderReminders();
    if (id === "page-transactions") renderTransactions();
    if (id === "page-categories") renderAdminCategories();
    if (id === "page-notifications") renderNotifications();
    if (id === "page-audit") renderAudit();
    if (id === "page-feedback") renderFeedback();
    if (id === "page-profile") renderProfileActivity();
    if (id === "page-settings") initSettings();
});
