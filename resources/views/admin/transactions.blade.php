@extends('admin.layouts.app')

@section('content')
<section id="page-transactions" class="page active">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px;">
        <div>
            <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800">Transactions</h2>
            <p style="font-size:.92rem;color:var(--text3);margin-top:3px">
                All billing and payment records
            </p>
        </div>
        <button class="btn btn-ghost btn-sm" onclick="exportTransactionsCSV()">
            <i class="ri-download-2-line"></i> Export CSV
        </button>
    </div>

    <div class="flex flex-wrap gap-3 mb-6">
        <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-full shadow-sm border border-gray-100">
            <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
            <span class="text-sm text-gray-600">
                Total: <strong class="text-gray-900" id="stats-total-count">0</strong>
            </span>
        </div>
        <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-full shadow-sm border border-gray-100">
            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
            <span class="text-sm text-gray-600">
                Completed: <strong class="text-green-600" id="stats-completed-count">0</strong>
            </span>
        </div>
        <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-full shadow-sm border border-gray-100">
            <div class="w-2 h-2 bg-amber-500 rounded-full"></div>
            <span class="text-sm text-gray-600">
                Pending: <strong class="text-amber-600" id="stats-pending-count">0</strong>
            </span>
        </div>
        <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-full shadow-sm border border-gray-100">
            <div class="w-2 h-2 bg-red-500 rounded-full"></div>
            <span class="text-sm text-gray-600">
                Refunded: <strong class="text-red-600" id="stats-refunded-count">0</strong>
            </span>
        </div>
    </div>

    <div class="card" style="padding:18px">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;flex-wrap:wrap;gap:10px;">
            <div class="section-title" style="margin:0">Transaction History</div>

            <div style="display:flex;gap:8px;flex-wrap:wrap">
                <div class="search-box" style="width:220px">
                    <i class="ri-search-line" style="color:var(--text3);font-size:.85rem"></i>
                    <input id="txn-search-input" placeholder="Search transactions…" oninput="filterTxn()" />
                </div>

                <select class="inp" style="width:auto;min-width:130px" id="txn-status-filter" onchange="filterTxn()">
                    <option value="all">All Status</option>
                    <option value="completed">Completed</option>
                    <option value="pending">Pending</option>
                    <option value="refunded">Refunded</option>
                </select>
            </div>
        </div>

        <div style="overflow-x:auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Txn ID</th>
                        <th>Order ID</th>
                        <th class="hide-mobile">User</th>
                        <th class="hide-mobile">Plan</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th class="hide-mobile">Date</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody id="txn-tbody"></tbody>
            </table>
        </div>

        <div class="pg-wrap">
            <div class="pg-info">
                Showing <strong id="txn-showing">0</strong> of
                <strong id="txn-total">0</strong> transactions
            </div>
            <div class="pg-btns" id="txn-pagination"></div>
        </div>
    </div>
</section>
@endsection