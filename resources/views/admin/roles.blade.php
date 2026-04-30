@extends('admin.layouts.app')
@section('content')
<!-- ═══ ROLES ═══ -->
<section id="page-roles" class="page active">
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
            <h2 class="font-jakarta" style="font-size: 1.3rem; font-weight: 800">
                Roles & Permissions
            </h2>
            <p style="font-size: 1.2re; color: var(--text3); margin-top: 3px">
                Define roles and control access
            </p>
        </div>
        <button class="btn btn-primary btn-sm" onclick="openModal('add-role-modal')">
            <i class="ri-add-line"></i> Create Role
        </button>
    </div>

    <!-- Tab Navigation -->
    <div style="display: flex; gap: 8px; margin-bottom: 20px; border-bottom: 2px solid rgba(255,255,255,.05)">
        <button class="role-tab-btn active" onclick="switchRoleTab('roles-perms')" id="tab-btn-roles-perms">
            <i class="ri-key-2-line"></i> Roles & Permissions
        </button>
        <button class="role-tab-btn" onclick="switchRoleTab('comparison')" id="tab-btn-comparison">
            <i class="ri-table-line"></i> Comparison Matrix
        </button>
    </div>

    <!-- Tab 1: Roles & Permissions -->
    <div class="role-tab-content active" id="tab-roles-perms">
        <div class="g2" style="margin-bottom: 20px; align-items: start">
            <div>
                <div class="section-title">Available Roles</div>
                <div style="display: flex; flex-direction: column; gap: 10px" id="roles-list"></div>
            </div>
            <div>
                <div
                    style="
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                        margin-bottom: 14px;
                    "
                >
                    <div class="section-title" style="margin: 0">Permission Matrix</div>
                    <span class="badge badge-purple" id="selected-role-badge">Select a role</span>
                </div>
                <div class="card" style="padding: 18px">
                    <div id="perm-matrix">
                        <div
                            style="
                                text-align: center;
                                padding: 40px;
                                color: var(--text4);
                                font-size: 1.2re;
                            "
                        >
                            <i
                                class="ri-key-2-line"
                                style="
                                    font-size: 2rem;
                                    display: block;
                                    margin-bottom: 8px;
                                    opacity: 0.3;
                                "
                            ></i>Click a role to view permissions
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab 2: Role Comparison Matrix -->
    <div class="role-tab-content" id="tab-comparison">
        <div class="card" style="padding: 18px">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px;">
                <div class="section-title" style="margin: 0;">Role Comparison Matrix</div>
                <button class="btn btn-ghost btn-sm" onclick="toggleEditMode()">
                    <i class="ri-edit-line"></i> <span id="edit-mode-text">Edit</span>
                </button>
            </div>
            <div style="overflow-x: auto">
                <table class="data-table">
                    <thead>
                        <tr id="perm-table-head"></tr>
                    </thead>
                    <tbody id="perm-table-body"></tbody>
                </table>
            </div>
            <div id="edit-mode-actions" style="display: none; margin-top: 16px; display: flex; gap: 8px; justify-content: flex-end;">
                <button class="btn btn-ghost btn-sm" onclick="cancelEditMode()">
                    <i class="ri-close-line"></i> Cancel
                </button>
                <button class="btn btn-primary btn-sm" onclick="saveComparisonChanges()">
                    <i class="ri-save-line"></i> Save Changes
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Add Role Modal -->
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
                <label class="label">Role Name <span style="color: var(--red)">*</span></label>
                <input class="inp" id="new-role-name" placeholder="e.g. Content Manager" />
            </div>
            <div>
                <label class="label">Color</label>
                <div
                    style="display: flex; gap: 8px; flex-wrap: wrap; margin-top: 4px"
                    id="role-color-picker"
                ></div>
            </div>
        </div>
        <div style="margin-bottom: 14px">
            <label class="label">Description</label>
            <input class="inp" id="new-role-desc" placeholder="What does this role do?" />
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

<!-- Edit Role Modal -->
<div class="modal-bg" id="edit-role-modal">
    <div class="modal-box" style="max-width: 640px">
        <div class="modal-header">
            <div>
                <h3 class="font-jakarta" style="font-weight: 700; font-size: 0.95rem; color: var(--text)">
                    <i class="ri-edit-line" style="color: var(--blue); margin-right: 6px"></i>Edit Role
                </h3>
                <p style="font-size: 0.76rem; color: var(--text3); margin-top: 2px">
                    Update role details and permissions
                </p>
            </div>
            <button class="modal-close" onclick="closeModal('edit-role-modal')">
                <i class="ri-close-line"></i>
            </button>
        </div>
        <div class="g2" style="margin-bottom: 14px">
            <div>
                <label class="label">Role Name <span style="color: var(--red)">*</span></label>
                <input class="inp" id="edit-role-name" placeholder="e.g. Content Manager" />
            </div>
            <div>
                <label class="label">Color</label>
                <div
                    style="display: flex; gap: 8px; flex-wrap: wrap; margin-top: 4px"
                    id="edit-role-color-picker"
                ></div>
            </div>
        </div>
        <div style="margin-bottom: 14px">
            <label class="label">Description</label>
            <input class="inp" id="edit-role-desc" placeholder="What does this role do?" />
        </div>
        <div style="margin-bottom: 16px">
            <label class="label">Permissions</label>
            <div class="perm-grid" id="edit-role-perms" style="margin-top: 8px"></div>
        </div>
        <div style="display: flex; gap: 8px; justify-content: space-between">
            <button class="btn btn-danger btn-sm" onclick="deleteRole()">
                <i class="ri-delete-bin-line"></i> Delete Role
            </button>
            <div style="display: flex; gap: 8px;">
                <button class="btn btn-ghost btn-sm" onclick="closeModal('edit-role-modal')">Cancel</button>
                <button class="btn btn-primary btn-sm" onclick="updateRole()">
                    <i class="ri-check-line"></i> Update Role
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.role-tab-btn {
    padding: 10px 18px;
    background: transparent;
    border: none;
    color: var(--text3);
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    border-bottom: 2px solid transparent;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 6px;
}
.role-tab-btn:hover {
    color: var(--text2);
}
.role-tab-btn.active {
    color: var(--purple);
    border-bottom-color: var(--purple);
}
.role-tab-content {
    display: none;
}
.role-tab-content.active {
    display: block;
}
.role-card {
    position: relative;
}
.role-edit-btn {
    position: absolute;
    top: 8px;
    right: 8px;
    background: rgba(255,255,255,.05);
    border: 1px solid rgba(255,255,255,.1);
    color: var(--text3);
    width: 28px;
    height: 28px;
    border-radius: 6px;
    display: none;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 0.85rem;
}
.role-card:hover .role-edit-btn {
    display: flex;
}
.role-edit-btn:hover {
    background: rgba(255,255,255,.1);
    color: var(--text);
}
</style>

<script>
/* ══════════════════════════════════════════
TAB SWITCHING
══════════════════════════════════════════ */
function switchRoleTab(tabName) {
    document.querySelectorAll('.role-tab-content').forEach(function(tab) {
        tab.classList.remove('active');
    });
    document.querySelectorAll('.role-tab-btn').forEach(function(btn) {
        btn.classList.remove('active');
    });
    document.getElementById('tab-' + tabName).classList.add('active');
    document.getElementById('tab-btn-' + tabName).classList.add('active');
}

/* ══════════════════════════════════════════
EDIT MODE FOR COMPARISON MATRIX
══════════════════════════════════════════ */
var isEditMode = false;
var editingRoleId = null;

function toggleEditMode() {
    isEditMode = !isEditMode;
    if (isEditMode) {
        document.getElementById('edit-mode-text').textContent = 'Cancel Edit';
        document.getElementById('edit-mode-actions').style.display = 'flex';
        renderPermTableEditable();
    } else {
        cancelEditMode();
    }
}

function cancelEditMode() {
    isEditMode = false;
    document.getElementById('edit-mode-text').textContent = 'Edit';
    document.getElementById('edit-mode-actions').style.display = 'none';
    renderPermTable();
}

function saveComparisonChanges() {
    var checkboxes = document.querySelectorAll('#perm-table-body input[type="checkbox"]');
    checkboxes.forEach(function(cb) {
        var parts = cb.dataset.perm.split('|');
        var roleId = parts[0];
        var permKey = parts[1];
        var role = ROLES_DATA.find(function(r) { return r.id === roleId; });
        if (role) {
            if (cb.checked && !role.perms.includes(permKey) && !role.perms.includes('all')) {
                role.perms.push(permKey);
            } else if (!cb.checked && role.perms.includes(permKey)) {
                role.perms = role.perms.filter(function(p) { return p !== permKey; });
            }
        }
    });
    toast('Permissions updated successfully!', 'success');
    cancelEditMode();
    renderRoles();
}

function renderPermTableEditable() {
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
                    var has = r.perms.includes("all") || r.perms.includes(p.key);
                    return (
                        '<td style="text-align:center"><input type="checkbox" ' +
                        (has ? 'checked' : '') +
                        ' data-perm="' + r.id + '|' + p.key + '"' +
                        ' style="accent-color:var(--green);width:16px;height:16px;cursor:pointer"></td>'
                    );
                }).join("") +
                "</tr>"
            );
        })
        .join("");
}

/* ══════════════════════════════════════════
ROLE EDIT/DELETE FUNCTIONS
══════════════════════════════════════════ */
function openEditRole(roleId, event) {
    event.stopPropagation();
    editingRoleId = roleId;
    var role = ROLES_DATA.find(function(r) { return r.id === roleId; });
    if (!role) return;
    
    document.getElementById('edit-role-name').value = role.name;
    document.getElementById('edit-role-desc').value = role.desc;
    selectedEditRoleColor = role.color;
    
    // Build color picker
    var cp = document.getElementById("edit-role-color-picker");
    cp.innerHTML = ROLE_COLORS.map(function (c) {
        return (
            "<div onclick=\"selectedEditRoleColor='" +
            c +
            "';document.querySelectorAll('#edit-role-color-picker div').forEach(function(d){d.style.outline='none'});this.style.outline='2px solid #fff'\" style=\"width:20px;height:20px;border-radius:50%;background:" +
            c +
            ";cursor:pointer;transition:transform .15s;outline:" +
            (c === role.color ? "2px solid #fff" : "none") +
            '" onmouseover="this.style.transform=\'scale(1.2)\'" onmouseout="this.style.transform=\'scale(1)\'"></div>'
        );
    }).join("");
    
    // Build permissions
    var permsEl = document.getElementById("edit-role-perms");
    permsEl.innerHTML = ALL_PERMS.map(function (p) {
        var checked = role.perms.includes('all') || role.perms.includes(p.key);
        return (
            '<label class="perm-item"><input type="checkbox" value="' +
            p.key +
            '" ' + (checked ? 'checked' : '') +
            ' style="accent-color:var(--purple);width:13px;height:13px;cursor:pointer"><span>' +
            p.label +
            '<div style="font-size:.63rem;color:var(--text4)">' +
            p.group +
            "</div></span></label>"
        );
    }).join("");
    
    openModal('edit-role-modal');
}

function updateRole() {
    var name = document.getElementById("edit-role-name").value.trim();
    if (!name) {
        toast("Enter a role name", "error");
        return;
    }
    
    var role = ROLES_DATA.find(function(r) { return r.id === editingRoleId; });
    if (!role) return;
    
    var desc = document.getElementById("edit-role-desc").value.trim();
    var perms = Array.from(document.querySelectorAll("#edit-role-perms input:checked")).map(function (i) {
        return i.value;
    });
    
    role.name = name;
    role.desc = desc;
    role.color = selectedEditRoleColor;
    role.perms = perms;
    
    toast('Role "' + name + '" updated!', "success");
    closeModal("edit-role-modal");
    renderRoles();
}

function deleteRole() {
    if (!confirm('Are you sure you want to delete this role? This action cannot be undone.')) {
        return;
    }
    
    var role = ROLES_DATA.find(function(r) { return r.id === editingRoleId; });
    var roleName = role ? role.name : '';
    
    ROLES_DATA = ROLES_DATA.filter(function(r) { return r.id !== editingRoleId; });
    
    toast('Role "' + roleName + '" deleted!', 'success');
    closeModal("edit-role-modal");
    renderRoles();
}

</script>
@endsection