@extends('admin.layouts.app')
@section('content')
<!-- ═══ USERS ═══ -->
 <style>
.err{
    color:red;
    font-size:12px;
    margin-top:4px;
    display:block;
}
.spinner{
    animation:spin 1s linear infinite;
}

@keyframes spin{
    100%{
        transform:rotate(360deg);
    }
}
</style>
<section id="page-users" class="page active">
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
                User Management
            </h2>
            <p style="font-size: 1.2re; color: var(--text3); margin-top: 3px">
                Manage all registered users
            </p>
        </div>
        <div style="display: flex; gap: 8px">
           
            <button class="btn btn-primary btn-sm" onclick="openModal('add-user-modal')">
                <i class="ri-user-add-line"></i> Add User
            </button>
        </div>
    </div>
    <div class="card" style="padding: 14px; margin-bottom: 14px">
        <div style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center">
            <div class="search-box" style="flex: 1; min-width: 200px">
                <i class="ri-search-line" style="color: var(--text3); font-size: 0.85rem"></i><input
                    placeholder="Search users…"
                    oninput="filterUsers(this.value)"
                    id="users-search-inp" />
            </div>
            <select
                class="inp"
                style="width: auto; min-width: 130px"
                id="users-status-filter"
                onchange="filterUsers()">
                <option value="all">All Status</option>


                <option value="active">Active</option>
                <option value="suspended">Suspended</option>
            </select>
            <select
                class="inp"
                style="width: auto; min-width: 130px"
                id="users-plan-filter"
                onchange="filterUsers()">
                <option value="all">All Plans</option>
                @foreach($plans as $plan)
                <option value="{{ $plan->plan_name }}">
                    {{ $plan->plan_name }}
                </option>
                @endforeach

            </select>
        </div>
    </div>
    <div class="card" style="padding: 18px">
        <div style="overflow-x: auto">
            <table class="data-table" id="users-table">
                <thead>
                    <tr>
                        <th style="width: 38px">S.No</th>
                        <th>User</th>
                        <th class="hide-mobile">Plan</th>
                        <th class="hide-mobile">Reminders</th>
                        <th>Status</th>
                        <th class="hide-mobile">Joined</th>
                        <th style="text-align: right">Actions</th>
                    </tr>
                </thead>
                <tbody id="users-tbody"></tbody>
            </table>
        </div>
        <div class="pg-wrap">
            <div class="pg-info">
                Showing <strong id="users-showing">0</strong> of
                <strong id="users-total">0</strong> users
            </div>
            <div class="pg-btns" id="users-pagination"></div>
        </div>
    </div>
</section>

<script>
    window.USERS_DATA = @json($users);
</script>

<script>
    function deleteUser(id) {

        openConfirm('Delete this user? This cannot be undone.', function() {
            const deleteUrl = "{{ route('admin.users.delete', ':id') }}";
            fetch(deleteUrl.replace(':id', id), {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status) {
                        toast(data.message, 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1500)
                        // Remove from array
                        USERS_DATA = USERS_DATA.filter(u => u.id !== id);
                        usersFiltered = usersFiltered.filter(u => u.id !== id);
                        renderUsers();

                    }

                })
                .catch(err => {
                    console.log(err);
                    toast('Something went wrong', 'error');
                });

        });

    }
</script>

<script>
function sendVerifyMail(id){
    const btn=document.getElementById('verify-mail-btn-'+id);
    btn.disabled=true;
    btn.innerHTML='<i class="ri-loader-4-line spinner"></i> Processing...';
    fetch('/admin/send-verification-mail',{
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content,
            'Accept':'application/json'
        },
        body:JSON.stringify({
            id:id
        })
    })
    .then(res=>res.json())
    .then(data=>{
        if(data.status){
            toast(data.message,'success');
        }else{
            toast('Something went wrong','error');
        }
        btn.disabled=false;
        btn.innerHTML='<i class="ri-mail-send-line"></i> Send Verification Mail';
    })
    .catch(err=>{
        console.log(err);
        toast('Something went wrong','error');
        btn.disabled=false;
        btn.innerHTML='<i class="ri-mail-send-line"></i> Send Verification Mail';
    });
}

</script>

@endsection