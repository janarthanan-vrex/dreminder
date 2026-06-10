@extends('admin.layouts.app')
@section('content')
<!-- ═══ ROLES ═══ -->
<section id="page-roles" class="page active">
     @if(!auth('admin')->user()->hasPermission('Roles','roles.create'))
<style>
.create-btn {
    display: none !important;
}
</style>
@endif
@if(!auth('admin')->user()->hasPermission('Roles','roles.edit'))
<style>
.edit-btn {
    display: none !important;
}
</style>
@endif

@if(!auth('admin')->user()->hasPermission('Roles','roles.delete'))
<style>
.delete-btn {
    display: none !important;
}
</style>
@endif
    <div
        style="
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        ">
        <div>
            <h2 class="font-jakarta" style="font-size: 1.3rem; font-weight: 800">
                Roles & Permissions
            </h2>
            <p style="font-size: 1.2re; color: var(--text3); margin-top: 3px">
                Define roles and control access
            </p>
        </div>
        <button class="btn btn-primary btn-sm create-btn" onclick="openModal('add-role-modal')">
            <i class="ri-add-line"></i> Create Role
        </button>
    </div>

    <!-- Roles List Only (no tabs, no matrix) -->
    <div>
        <div class="section-title">Available Roles</div>
        <div style="display: flex; flex-direction: column; gap: 10px" id="roles-list"></div>
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
                <input class="inp" id="new-role-name" placeholder="e.g. Content Manager"  oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, ''); hideRoleError();" />

                <small id="role-name-error" style="color:#ef4444;font-size:.72rem;margin-top:4px;display:none;"></small>
            </div>
            <div>
                <label class="label">Color</label>
                <div
                    style="display: flex; gap: 8px; flex-wrap: wrap; margin-top: 4px"
                    id="role-color-picker"></div>
            </div>
        </div>

        <div style="margin-bottom: 14px">
            <label class="label">Description</label>
            <input class="inp" id="new-role-desc" placeholder="What does this role do?" />
        </div>

        <div style="margin-bottom: 14px">
    <label class="label">Status</label>
    <select class="inp" id="new-role-status">
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
    </select>
</div>

        <!-- Permissions Section with Bulk Actions -->
        <div style="margin-bottom: 16px">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                <label class="label" style="margin: 0">Permissions</label>
                <!-- Bulk Actions -->
                <div style="display: flex; gap: 6px;">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="bulkCheckAll('new-role-perms')" style="font-size: 0.72rem; padding: 3px 10px;">
                        <i class="ri-checkbox-multiple-line"></i> Select All
                    </button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="bulkUncheckAll('new-role-perms')" style="font-size: 0.72rem; padding: 3px 10px;">
                        <i class="ri-checkbox-blank-line"></i> Deselect All
                    </button>
                </div>
            </div>
            <div id="new-role-perms" style="margin-top: 4px"></div>
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
                <input class="inp" id="edit-role-name" placeholder="e.g. Content Manager"  oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, ''); hideEditRoleError();"/>
                 <small id="edit-role-name-error" style="color:#ef4444;font-size:.72rem;margin-top:4px;display:none;"></small>
            </div>
            <div>
                <label class="label">Color</label>
                <div
                    style="display: flex; gap: 8px; flex-wrap: wrap; margin-top: 4px"
                    id="edit-role-color-picker"></div>
            </div>
        </div>

        <div style="margin-bottom: 14px">
            <label class="label">Description</label>
            <input class="inp" id="edit-role-desc" placeholder="What does this role do?" />
        </div>

        <div style="margin-bottom:14px">
            <label class="label">Status</label>
            <select class="inp" id="edit-role-status">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>

        <!-- Permissions Section with Bulk Actions -->
        <div style="margin-bottom: 16px">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                <label class="label" style="margin: 0">Permissions</label>
                <!-- Bulk Actions -->
                <div style="display: flex; gap: 6px;">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="bulkCheckAll('edit-role-perms')" style="font-size: 0.72rem; padding: 3px 10px;">
                        <i class="ri-checkbox-multiple-line"></i> Select All
                    </button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="bulkUncheckAll('edit-role-perms')" style="font-size: 0.72rem; padding: 3px 10px;">
                        <i class="ri-checkbox-blank-line"></i> Deselect All
                    </button>
                </div>
            </div>
            <div id="edit-role-perms" style="margin-top: 4px"></div>
        </div>

        <div style="display: flex; gap: 8px; justify-content: space-between">
            <button class="btn btn-danger btn-sm delete-btn" onclick="deleteRole()">
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
    .role-card {
        position: relative;
    }

    .role-edit-btn {
        position: absolute;
        top: 8px;
        right: 8px;
        background: rgba(255, 255, 255, .05);
        border: 1px solid rgba(255, 255, 255, .1);
        color: var(--text3);
        width: 28px;
        height: 28px;
        border-radius: 6px;
        /* display: none; */
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
        background: rgba(255, 255, 255, .1);
        color: var(--text);
    }

    /* Module group block */
    .perm-module-group {
        border: 1px solid rgba(255, 255, 255, .07);
        border-radius: 10px;
        margin-bottom: 10px;
        overflow: hidden;
    }

    .perm-module-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 7px 12px;
        background: rgba(255, 255, 255, .04);
        border-bottom: 1px solid rgba(255, 255, 255, .06);
    }

    .perm-module-title {
        font-size: .63rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: var(--text3);
    }

    .perm-module-check-all {
        font-size: .65rem;
        font-weight: 600;
        color: var(--purple);
        background: none;
        border: none;
        cursor: pointer;
        padding: 2px 6px;
        border-radius: 4px;
        transition: background .15s;
    }

    .perm-module-check-all:hover {
        background: rgba(139, 92, 246, .12);
    }

    .perm-module-body {
        padding: 8px 12px;
    }
</style>

<script>
    var ROLES_DATA = {!! json_encode($rolesData) !!};
    // convert to plain array if it's a collection
    ROLES_DATA = Object.values(ROLES_DATA);
</script>

<script>
    /* ══════════════════════════════════════════
ROLES
══════════════════════════════════════════ */
    function renderRoles() {
    var list = document.getElementById("roles-list");
    list.innerHTML = ROLES_DATA.map(function(r) {

        // Show ALL checked permissions, no truncation
        var permBadges = r.perms.map(function(p) {
            return '<span class="chip" style="font-size:.58rem">' + p + '</span>';
        }).join('');

        // Empty state
        var permsHtml = permBadges
            ? '<div style="display:flex;flex-wrap:wrap;gap:4px">' + permBadges + '</div>'
            : '<span style="font-size:.7rem;color:var(--text3)">No permissions assigned</span>';

        return (
            '<div class="role-card ' + (selectedRole === r.id ? 'selected' : '') + '"' +
           ' onclick="selectRole(' + r.id + ',this)">' +

           '<button class="role-edit-btn edit-btn" onclick="openEditRole(' + r.id + ', event)">' +
            '<i class="ri-edit-line"></i></button>' +


            '<div style="display:flex;align-items:center;gap:10px;margin-bottom:8px">' +

            '<div style="width:36px;height:36px;border-radius:9px;background:' + r.color + '22;' +
            'display:flex;align-items:center;justify-content:center">' +
            '<i class="ri-key-2-line" style="color:' + r.color + '"></i></div>' +

            '<div style="flex:1">' +
            '<div style="font-size:.87rem;font-weight:700;color:var(--text)">' + r.name + '</div>' +
            '<div style="font-size:.72rem;color:var(--text3)">' + r.desc + '</div>' +
            '</div>' +

            '<span style="position:relative;left:-35px;font-size:.65rem;font-weight:700;background:' + r.color + '22;color:' + r.color + ';' +
            'padding:2px 8px;border-radius:99px;border:1px solid ' + r.color + '44">' +
            r.count + ' member' + (r.count !== 1 ? 's' : '') + '</span>' +

            '</div>' +
            permsHtml +
            '</div>'
        );
    }).join('');

    buildRoleModal();
    populateStaffRoles();
}

    function selectRole(id, el) {
        selectedRole = id;
        document.querySelectorAll(".role-card").forEach(function(c) {
            c.classList.remove("selected");
        });
        el.classList.add("selected");
    }

    /* ══════════════════════════════════════════
    BUILD PERMISSION GROUPS (module-wise)
    ══════════════════════════════════════════ */
    function buildPermGroupsHTML(containerId, checkedPerms) {
        var groups = {};
        ALL_PERMS.forEach(function(p) {
            if (!groups[p.group]) groups[p.group] = [];
            groups[p.group].push(p);
        });

        return Object.entries(groups).map(function(entry) {
            var groupName = entry[0];
            var perms = entry[1];
            var safeGroup = groupName.replace(/\s+/g, '-').replace(/[^a-zA-Z0-9\-]/g, '');
            var groupId = containerId + '-grp-' + safeGroup;

            var permItems = perms.map(function(p) {
                var checked = checkedPerms.includes('all') || checkedPerms.includes(p.key);
                return (
                    '<label class="perm-item">' +
                    '<input type="checkbox" value="' + p.key + '"' +
                    (checked ? ' checked' : '') +
                    ' style="accent-color:var(--purple);width:13px;height:13px;cursor:pointer"' +
                    ' onchange="updateModuleCheckAllState(\'' + groupId + '\')">' +
                    '<span>' + p.label +
                    '</span></label>'
                );
            }).join('');

            var allChecked = perms.every(function(p) {
                return checkedPerms.includes('all') || checkedPerms.includes(p.key);
            });

            return (
                '<div class="perm-module-group" id="' + groupId + '">' +
                '<div class="perm-module-header">' +
                '<span class="perm-module-title">' + groupName + '</span>' +
                '<button type="button" class="perm-module-check-all"' +
                ' onclick="toggleModulePerms(\'' + groupId + '\')"' +
                ' data-all="' + (allChecked ? '1' : '0') + '">' +
                (allChecked ? 'Uncheck All' : 'Check All') +
                '</button>' +
                '</div>' +
                '<div class="perm-module-body perm-grid">' + permItems + '</div>' +
                '</div>'
            );
        }).join('');
    }

    function buildRoleModal() {
        var permsEl = document.getElementById("new-role-perms");
        permsEl.innerHTML = buildPermGroupsHTML('new-role-perms', []);

        var cp = document.getElementById("role-color-picker");
        cp.innerHTML = ROLE_COLORS.map(function(c) {
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

    /* ══════════════════════════════════════════
    BULK CHECK ACTIONS
    ══════════════════════════════════════════ */
    function bulkCheckAll(containerId) {
        document.querySelectorAll('#' + containerId + ' input[type="checkbox"]').forEach(function(cb) {
            cb.checked = true;
        });
        refreshAllModuleHeaders(containerId);
    }

    function bulkUncheckAll(containerId) {
        document.querySelectorAll('#' + containerId + ' input[type="checkbox"]').forEach(function(cb) {
            cb.checked = false;
        });
        refreshAllModuleHeaders(containerId);
    }

    /* ══════════════════════════════════════════
    MODULE-WISE CHECK ALL TOGGLE
    ══════════════════════════════════════════ */
    function toggleModulePerms(groupId) {
        var group = document.getElementById(groupId);
        if (!group) return;
        var btn = group.querySelector('.perm-module-check-all');
        var checkboxes = group.querySelectorAll('input[type="checkbox"]');
        var isAll = btn.dataset.all === '1';

        checkboxes.forEach(function(cb) {
            cb.checked = !isAll;
        });

        btn.dataset.all = isAll ? '0' : '1';
        btn.textContent = isAll ? 'Check All' : 'Uncheck All';
    }

    function updateModuleCheckAllState(groupId) {
        var group = document.getElementById(groupId);
        if (!group) return;
        var btn = group.querySelector('.perm-module-check-all');
        var checkboxes = group.querySelectorAll('input[type="checkbox"]');
        var allChecked = Array.from(checkboxes).every(function(cb) {
            return cb.checked;
        });
        btn.dataset.all = allChecked ? '1' : '0';
        btn.textContent = allChecked ? 'Uncheck All' : 'Check All';
    }

    function refreshAllModuleHeaders(containerId) {
        document.querySelectorAll('#' + containerId + ' .perm-module-group').forEach(function(group) {
            updateModuleCheckAllState(group.id);
        });
    }

    /* ══════════════════════════════════════════
    CREATE ROLE
    ══════════════════════════════════════════ */
   function hideRoleError() {

    document.getElementById("role-name-error").style.display = "none";
    document.getElementById("role-name-error").innerText = "";
}

function createRole() {
    var name  = document.getElementById("new-role-name").value.trim();
    var desc  = document.getElementById("new-role-desc").value.trim();
    var status = document.getElementById("new-role-status").value;
    var perms = Array.from(
        document.querySelectorAll("#new-role-perms input:checked")
    ).map(function(i) { return i.value; });

    // Client-side check first
    if (!name) {
        var err = document.getElementById("role-name-error");
        err.innerText = "Role name is required.";
        err.style.display = "block";
        return;
    }

    hideRoleError();

    fetch("/admin/roles/store", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        },
        body: JSON.stringify({
            rolename:    name,
            description: desc,
            status:      status,
            color:       selectedRoleColor,
            permissions: perms
        })
    })
    .then(function(response) {
        // clone to read json regardless of status
        return response.json().then(function(data) {
            return { status: response.status, data: data };
        });
    })
    .then(function(result) {
        var status = result.status;
        var data   = result.data;

        // Handle validation errors (422)
        if (status === 422) {
            if (data.errors && data.errors.rolename) {
                var err = document.getElementById("role-name-error");
                err.innerText = data.errors.rolename[0];
                err.style.display = "block";
            } else {
                toast("Validation failed. Please check inputs.", "error");
            }
            return;
        }

        // Handle other errors
        if (status !== 200 && status !== 201) {
            toast(data.message || "Something went wrong!", "error");
            return;
        }

        // Success
        ROLES_DATA.push({
            id:    data.role.id,
            name:  data.role.rolename,
            color: data.role.color,
            desc:  data.role.description ?? '',
            perms: perms,
            count: 0
        });

        toast("Role created successfully!", "success");

        // Reset form
        document.getElementById("new-role-name").value = "";
        document.getElementById("new-role-desc").value = "";
        document.querySelectorAll("#new-role-perms input[type='checkbox']").forEach(function(cb) {
            cb.checked = false;
        });

        closeModal("add-role-modal");
        renderRoles();
    })
    .catch(function(error) {
        console.error("createRole error:", error);
        toast("Something went wrong!", "error");
    });
}

    function populateStaffRoles() {
        var sel = document.getElementById("staff-role-sel");
        if (sel)
            sel.innerHTML =
            '<option value="">Select role…</option>' +
            ROLES_DATA.map(function(r) {
                return '<option value="' + r.id + '">' + r.name + "</option>";
            }).join("");
    }

    var selectedEditRoleColor = '';

    /* ══════════════════════════════════════════
    EDIT ROLE MODAL
    ══════════════════════════════════════════ */
    var editingRoleId = null;

    function openEditRole(roleId, event) {
        event.stopPropagation();
        editingRoleId = roleId;
        var role = ROLES_DATA.find(function(r) {
            return r.id === roleId;
        });
        if (!role) return;
        document.getElementById('edit-role-name').value = role.name;
        document.getElementById('edit-role-desc').value = role.desc;
        document.getElementById('edit-role-status').value = role.status;
        selectedEditRoleColor = role.color;

        // Color picker
        var cp = document.getElementById("edit-role-color-picker");
        cp.innerHTML = ROLE_COLORS.map(function(c) {
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

        // Permissions - module-wise with pre-checked state
        var permsEl = document.getElementById("edit-role-perms");
        permsEl.innerHTML = buildPermGroupsHTML('edit-role-perms', role.perms);

        openModal('edit-role-modal');
    }

  function hideEditRoleError() {
    var err = document.getElementById("edit-role-name-error");
    err.style.display = "none";
    err.innerText = "";
}

function updateRole() {
    var name = document.getElementById("edit-role-name").value.trim();

    // Client-side check
    if (!name) {
        var err = document.getElementById("edit-role-name-error");
        err.innerText = "Role name is required.";
        err.style.display = "block";
        return;
    }

    hideEditRoleError();

    var role = ROLES_DATA.find(function(r) { return r.id === editingRoleId; });
    if (!role) return;

    var desc  = document.getElementById("edit-role-desc").value.trim();
    var status = document.getElementById("edit-role-status").value;
    var perms = Array.from(
        document.querySelectorAll("#edit-role-perms input:checked")
    ).map(function(i) { return i.value; });

    fetch("/admin/roles/" + editingRoleId, {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        },
        body: JSON.stringify({
            rolename:    name,
            description: desc,
            color:       selectedEditRoleColor,
            status:      status,
            permissions: perms
        })
    })
    .then(function(response) {
        return response.json().then(function(data) {
            return { status: response.status, data: data };
        });
    })
    .then(function(result) {
        var status = result.status;
        var data   = result.data;

        // Handle validation errors (422)
        if (status === 422) {
            if (data.errors && data.errors.rolename) {
                var err = document.getElementById("edit-role-name-error");
                err.innerText = data.errors.rolename[0];
                err.style.display = "block";
            } else {
                toast("Validation failed. Please check inputs.", "error");
            }
            return;
        }

        // Handle other errors
        if (status !== 200 && status !== 201) {
            toast(data.message || "Something went wrong!", "error");
            return;
        }

        // Success — update local data
        role.name  = name;
        role.desc  = desc;
        role.color = selectedEditRoleColor;
        role.perms = perms;

        toast('Role "' + name + '" updated!', "success");
        closeModal("edit-role-modal");
        renderRoles();
        setTimeout(()=>{
            location.reload();
        },1500)
    })
    .catch(function(error) {
        console.error("updateRole error:", error);
        toast("Something went wrong!", "error");
    });
}

   function deleteRole() {
    if (!confirm('Are you sure you want to delete this role? This action cannot be undone.')) return;

    var role = ROLES_DATA.find(function(r) { return r.id === editingRoleId; });
    var roleName = role ? role.name : '';

    fetch("/admin/roles/" + editingRoleId, {
        method: "DELETE",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        }
    })
    .then(async function(response) {
        var data = await response.json();
        if (!response.ok) {
            toast(data.message || "Delete failed!", "error");
            return;
        }

        ROLES_DATA = ROLES_DATA.filter(function(r) { return r.id !== editingRoleId; });
        toast('Role "' + roleName + '" deleted!', "success");
        closeModal("edit-role-modal");
        renderRoles();
    })
    .catch(function(error) {
        console.error(error);
        toast("Something went wrong!", "error");
    });
}


</script>
@endsection