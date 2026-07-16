<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            min-height:100vh;
            background:
                linear-gradient(135deg,#0f172a,#111827,#020617);
            font-family:'Poppins',sans-serif;
            color:white;
            overflow-x:hidden;
        }

        /* BACKGROUND */

        .bg-blur-1{
            position:fixed;
            width:350px;
            height:350px;
            background:#8b5cf6;
            border-radius:50%;
            filter:blur(120px);
            top:-100px;
            left:-100px;
            opacity:0.35;
            z-index:-1;
        }

        .bg-blur-2{
            position:fixed;
            width:350px;
            height:350px;
            background:#06b6d4;
            border-radius:50%;
            filter:blur(120px);
            bottom:-100px;
            right:-100px;
            opacity:0.30;
            z-index:-1;
        }

        /* HEADER */

        .header{
            padding:35px 0;
        }

        .dashboard-title{
            font-size:42px;
            font-weight:700;
            margin-bottom:10px;
            background:linear-gradient(135deg,#8b5cf6,#06b6d4);
            -webkit-background-clip:text;
            -webkit-text-fill-color:transparent;
        }

        .dashboard-subtitle{
            color:#94a3b8;
            font-size:15px;
        }

        /* BUTTON */

        .btn-create{
            height:58px;
            min-width:220px;
            border:none;
            border-radius:18px;
            background:linear-gradient(135deg,#8b5cf6,#06b6d4);
            color:white !important;
            font-size:15px;
            font-weight:600;
            display:flex;
            align-items:center;
            justify-content:center;
            gap:10px;
            text-decoration:none;
            box-shadow:0 10px 25px rgba(139,92,246,0.35);
            transition:0.3s;
        }

        .btn-create:hover{
            transform:translateY(-3px);
            color:white;
        }

        /* GLASS CARD */

        .glass-card{
            background:rgba(255,255,255,0.05);
            border:1px solid rgba(255,255,255,0.08);
            backdrop-filter:blur(14px);
            border-radius:28px;
            box-shadow:0 12px 40px rgba(0,0,0,0.30);
        }

        /* STATS */

        .stats-card{
            padding:30px;
            transition:0.3s;
        }

        .stats-card:hover{
            transform:translateY(-5px);
        }

        .stats-icon{
            width:78px;
            height:78px;
            border-radius:22px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:34px;
            background:linear-gradient(135deg,#8b5cf6,#06b6d4);
            box-shadow:0 10px 25px rgba(139,92,246,0.35);
        }

        .stats-label{
            color:#94a3b8;
            font-size:15px;
            margin-bottom:10px;
        }

        .stats-number{
            font-size:42px;
            font-weight:700;
            color:white;
        }

        /* SEARCH */

        .search-card{
            padding:28px;
            margin-top:30px;
        }

        .search-input{
            height:60px;
            border-radius:18px;
            border:1px solid rgba(255,255,255,0.08);
            background:rgba(255,255,255,0.05) !important;
            color:white !important;
            padding-left:22px;
            font-size:15px;
        }

        .search-input::placeholder{
            color:#94a3b8;
        }

        .search-input:focus{
            background:rgba(255,255,255,0.08) !important;
            border-color:#06b6d4;
            box-shadow:none;
            color:white !important;
        }

        .btn-search{
            height:60px;
            border:none;
            border-radius:18px;
            background:linear-gradient(135deg,#06b6d4,#3b82f6);
            font-size:15px;
            font-weight:600;
            color:white;
            transition:0.3s;
        }

        .btn-search:hover{
            transform:translateY(-2px);
            color:white;
        }

        /* TABLE */

        .table-card{
            padding:28px;
            margin-top:30px;
        }

        .table{
            color:white !important;
            background:transparent !important;
            margin-bottom:0;
        }

        .table thead{
            background:rgba(255,255,255,0.05);
        }

        .table th{
            border:none;
            padding:22px 20px;
            color:#cbd5e1 !important;
            font-size:14px;
            font-weight:600;
            background:transparent !important;
            text-transform:uppercase;
            letter-spacing:0.5px;
        }

        .table td{
            padding:22px 20px;
            border-color:rgba(255,255,255,0.06) !important;
            background:transparent !important;
            vertical-align:middle;
            font-size:15px;
            color:white !important;
        }

        .table tbody tr{
            transition:0.3s;
        }

        .table tbody tr:hover{
            background:rgba(255,255,255,0.03) !important;
        }

        /* ID FIX */

        .order-id{
            color:#ffffff !important;
            font-weight:600;
        }

        /* ORDER NAME */

        .order-name{
            font-size:15px;
            font-weight:600;
            color:white;
        }

        /* BADGE */

        .prefixed-badge{
            padding:10px 16px;
            border-radius:14px;
            background:linear-gradient(135deg,#10b981,#14b8a6);
            color:white;
            font-size:13px;
            font-weight:600;
            display:inline-block;
            box-shadow:0 10px 20px rgba(16,185,129,0.35);
        }

        /* STATUS BADGES */

        .badge-pending    { background:linear-gradient(135deg,#f59e0b,#fbbf24); }
        .badge-processing { background:linear-gradient(135deg,#3b82f6,#06b6d4); }
        .badge-completed  { background:linear-gradient(135deg,#10b981,#14b8a6); }
        .badge-cancelled  { background:linear-gradient(135deg,#ef4444,#f97316); }
        .status-badge {
            display:inline-block;
            padding:6px 14px;
            border-radius:10px;
            color:white;
            font-size:12px;
            font-weight:700;
        }

        /* ACTION BUTTONS */

        .btn-view{
            background:linear-gradient(135deg,#10b981,#14b8a6);
            border:none;
            border-radius:12px;
            padding:9px 16px;
            font-size:13px;
            font-weight:600;
            color:white !important;
        }

        .btn-edit{
            background:linear-gradient(135deg,#f59e0b,#fbbf24);
            border:none;
            border-radius:12px;
            padding:9px 16px;
            font-size:13px;
            font-weight:600;
            color:white !important;
        }

        .btn-delete{
            background:linear-gradient(135deg,#ef4444,#f97316);
            border:none;
            border-radius:12px;
            padding:9px 16px;
            font-size:13px;
            font-weight:600;
            color:white !important;
        }

        .btn-view:hover,
        .btn-edit:hover,
        .btn-delete:hover{
            transform:translateY(-2px);
        }

        /* EMPTY */

        .empty-box{
            text-align:center;
            padding:80px 0;
        }

        .empty-box h4{
            font-size:30px;
            margin-bottom:12px;
            color:white;
        }

        .empty-box p{
            color:#94a3b8;
            font-size:15px;
        }

        /* PAGINATION */

        .pagination{
            justify-content:center;
            margin-top:35px;
        }

        .page-link{
            width:46px;
            height:46px;
            border:none;
            margin:0 5px;
            border-radius:14px !important;
            background:rgba(255,255,255,0.05) !important;
            color:white !important;
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight:600;
            transition:0.3s;
        }

        .page-link:hover{
            background:linear-gradient(135deg,#8b5cf6,#06b6d4) !important;
            color:white !important;
        }

        .page-item.active .page-link{
            background:linear-gradient(135deg,#8b5cf6,#06b6d4) !important;
            color:white !important;
            box-shadow:0 10px 20px rgba(139,92,246,0.35);
        }

        .page-item.disabled .page-link{
            background:rgba(255,255,255,0.03) !important;
            color:#64748b !important;
        }

        /* ALERT */

        .alert{
            border:none;
            border-radius:18px;
            font-size:15px;
        }

    </style>

</head>
<body>

    {{-- BACKGROUND --}}
    <div class="bg-blur-1"></div>
    <div class="bg-blur-2"></div>

    <div class="container py-4">

        {{-- HEADER --}}
        <div class="header d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>

                <h1 class="dashboard-title">
                    🚀 Orders Dashboard
                </h1>

                <p class="dashboard-subtitle">
                    Modern Laravel 12 Prefixed ID Management System
                </p>

            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('prefix.dashboard') }}" class="btn-create" style="background:linear-gradient(135deg,#f59e0b,#06b6d4)">
                    <span>⚙️</span><span>Prefix Dashboard</span>
                </a>
                <a href="{{ route('orders.create') }}" class="btn-create">
                    <span>➕</span><span>Create New Order</span>
                </a>
            </div>

        </div>

        {{-- SUCCESS --}}
        @if(session('success'))

            <div class="alert alert-success alert-dismissible fade show">

                {{ session('success') }}

                <button class="btn-close"
                        data-bs-dismiss="alert">
                </button>

            </div>

        @endif

        {{-- STATS --}}
        <div class="row">

            <div class="col-lg-4">

                <div class="glass-card stats-card">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="stats-label">
                                Total Orders
                            </div>

                            <div class="stats-number">
                                {{ $totalOrders }}
                            </div>

                        </div>

                        <div class="stats-icon">
                            📦
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- SEARCH --}}
        <div class="glass-card search-card">

            <form method="GET">

                <div class="row g-3">

                    <div class="col-md-10">

                        <input
                            type="text"
                            name="search"
                            class="form-control search-input"
                            placeholder="🔍 Search orders by name or prefixed ID..."
                            value="{{ request('search') }}"
                        >

                    </div>

                    <div class="col-md-2">

                        <button class="btn btn-search w-100">

                            Search

                        </button>

                    </div>

                </div>

            </form>

        </div>

        {{-- TABLE --}}
        <div class="glass-card table-card">

            <div class="table-responsive">

                <table class="table table-borderless align-middle">

                    <thead>

                        <tr>

                            <th>ID</th>
                            <th>Order Name</th>
                            <th>Prefixed ID</th>
                            <th>Status</th>
                            <th width="260">Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($orders as $order)

                        <tr>

                            <td class="order-id">
                                #{{ $order->id }}
                            </td>

                            <td>

                                <div class="order-name">
                                    {{ $order->name }}
                                </div>

                            </td>

                            <td>

                                <span class="prefixed-badge">

                                    {{ $order->prefixed_id }}

                                </span>

                            </td>

                            <td>
                                <span class="status-badge {{ $order->getStatusBadgeClass() }}">
                                    {{ $order->getStatusEmoji() }} {{ ucfirst($order->status) }}
                                </span>
                            </td>

                            <td>

                                <div class="d-flex gap-2">

                                    <a href="{{ route('orders.show', $order->prefixed_id) }}"
                                       class="btn btn-view btn-sm">👁 View</a>

                                    <a href="{{ route('orders.edit', $order->prefixed_id) }}"
                                       class="btn btn-edit btn-sm">✏️ Edit</a>

                                    <form action="{{ route('orders.destroy', $order->prefixed_id) }}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-delete btn-sm"
                                            onclick="return confirm('Delete this order?')">
                                            🗑 Delete
                                        </button>
                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4">

                                <div class="empty-box">

                                    <h4>
                                        No Orders Found
                                    </h4>

                                    <p>
                                        Create your first order to get started 🚀
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

            {{-- PAGINATION --}}
            <div class="d-flex justify-content-center">

                {{ $orders->onEachSide(1)->links('pagination::bootstrap-5') }}

            </div>

        </div>

    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>