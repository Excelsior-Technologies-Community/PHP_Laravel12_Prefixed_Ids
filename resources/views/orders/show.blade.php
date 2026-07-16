<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #020617, #0f172a, #111827);
            font-family: 'Poppins', sans-serif;
            color: white;
        }
        .bg-blur-1 { position: absolute; width: 350px; height: 350px; background: #8b5cf6; border-radius: 50%; filter: blur(120px); top: -100px; left: -100px; opacity: 0.35; }
        .bg-blur-2 { position: absolute; width: 350px; height: 350px; background: #06b6d4; border-radius: 50%; filter: blur(120px); bottom: -100px; right: -100px; opacity: 0.30; }
        .order-card {
            position: relative; z-index: 10;
            width: 100%; max-width: 580px;
            padding: 45px;
            border-radius: 30px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            backdrop-filter: blur(14px);
            box-shadow: 0 15px 50px rgba(0,0,0,0.35);
            text-align: center;
        }
        .success-icon {
            width: 95px; height: 95px; margin: auto;
            border-radius: 25px;
            display: flex; align-items: center; justify-content: center;
            font-size: 42px;
            background: linear-gradient(135deg, #10b981, #14b8a6);
            box-shadow: 0 12px 30px rgba(16,185,129,0.35);
            margin-bottom: 25px;
        }
        .title {
            font-size: 34px; font-weight: 700; margin-bottom: 8px;
            background: linear-gradient(135deg, #8b5cf6, #06b6d4);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .subtitle { color: #94a3b8; font-size: 14px; margin-bottom: 30px; }
        .info-box {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 18px; padding: 18px 22px;
            margin-bottom: 16px; text-align: left;
        }
        .info-label { color: #94a3b8; font-size: 12px; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px; }
        .info-value { color: white; font-size: 17px; font-weight: 600; word-break: break-word; }
        .prefixed-id-wrap { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
        .prefixed-id {
            display: inline-block; padding: 10px 16px; border-radius: 12px;
            background: linear-gradient(135deg, #10b981, #14b8a6);
            color: white; font-size: 14px; font-weight: 700;
            box-shadow: 0 8px 20px rgba(16,185,129,0.3);
        }
        .btn-copy {
            padding: 8px 14px; border-radius: 10px; font-size: 13px; font-weight: 600;
            background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12);
            color: white; cursor: pointer; transition: 0.2s;
        }
        .btn-copy:hover { background: rgba(255,255,255,0.15); }
        .btn-copy.copied { background: #10b981; border-color: #10b981; }

        /* Status badges */
        .badge-pending    { background: linear-gradient(135deg,#f59e0b,#fbbf24); }
        .badge-processing { background: linear-gradient(135deg,#3b82f6,#06b6d4); }
        .badge-completed  { background: linear-gradient(135deg,#10b981,#14b8a6); }
        .badge-cancelled  { background: linear-gradient(135deg,#ef4444,#f97316); }
        .status-badge {
            display: inline-block; padding: 8px 16px; border-radius: 12px;
            color: white; font-size: 13px; font-weight: 700;
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
        }

        .btn-custom {
            height: 55px; border: none; border-radius: 16px;
            font-size: 15px; font-weight: 600;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            transition: 0.3s; text-decoration: none;
        }
        .btn-create  { background: linear-gradient(135deg,#8b5cf6,#06b6d4); color: white; }
        .btn-edit    { background: linear-gradient(135deg,#f59e0b,#fbbf24); color: white; }
        .btn-dash    { background: rgba(255,255,255,0.06); color: white; border: 1px solid rgba(255,255,255,0.08); }
        .btn-custom:hover { transform: translateY(-3px); color: white; }

        @media(max-width:576px){ .order-card{ padding:30px 20px; } }
    </style>
</head>
<body>
    <div class="bg-blur-1"></div>
    <div class="bg-blur-2"></div>

    <div class="order-card">

        <div class="success-icon">🎉</div>

        <h1 class="title">Order Details</h1>
        <p class="subtitle">Unique prefixed ID assigned to this order.</p>

        @if(session('success'))
            <div class="alert alert-success text-start mb-3" style="border-radius:14px;font-size:14px">
                {{ session('success') }}
            </div>
        @endif

        {{-- Order Name --}}
        <div class="info-box">
            <div class="info-label">Order Name</div>
            <div class="info-value">{{ $order->name }}</div>
        </div>

        {{-- Status --}}
        <div class="info-box">
            <div class="info-label">Status</div>
            <div class="info-value">
                <span class="status-badge {{ $order->getStatusBadgeClass() }}">
                    {{ $order->getStatusEmoji() }} {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>

        {{-- Prefixed ID with Copy --}}
        <div class="info-box">
            <div class="info-label">Prefixed ID</div>
            <div class="info-value">
                <div class="prefixed-id-wrap">
                    <span class="prefixed-id" id="prefixedIdText">{{ $order->prefixed_id }}</span>
                    <button class="btn-copy" id="copyBtn" onclick="copyPrefixedId()">
                        📋 Copy
                    </button>
                </div>
            </div>
        </div>

        {{-- Notes --}}
        @if($order->notes)
        <div class="info-box">
            <div class="info-label">Notes</div>
            <div class="info-value" style="font-size:15px;font-weight:400;color:#cbd5e1">{{ $order->notes }}</div>
        </div>
        @endif

        {{-- Created At --}}
        <div class="info-box">
            <div class="info-label">Created At</div>
            <div class="info-value" style="font-size:14px;font-weight:500;color:#94a3b8">
                {{ $order->created_at->format('d M Y, h:i A') }}
            </div>
        </div>

        {{-- Buttons --}}
        <div class="row mt-4 g-2">
            <div class="col-md-4">
                <a href="{{ route('orders.edit', $order->prefixed_id) }}" class="btn btn-custom btn-edit w-100">
                    ✏️ Edit
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('orders.create') }}" class="btn btn-custom btn-create w-100">
                    ➕ New
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('orders.index') }}" class="btn btn-custom btn-dash w-100">
                    📦 Orders
                </a>
            </div>
        </div>

    </div>

    <script>
        function copyPrefixedId() {
            const text = document.getElementById('prefixedIdText').innerText;
            navigator.clipboard.writeText(text).then(() => {
                const btn = document.getElementById('copyBtn');
                btn.innerText = '✅ Copied!';
                btn.classList.add('copied');
                setTimeout(() => { btn.innerText = '📋 Copy'; btn.classList.remove('copied'); }, 2000);
            });
        }
    </script>
</body>
</html>
