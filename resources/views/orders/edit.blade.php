<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f7fb;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .order-card {
            width: 100%;
            max-width: 580px;
            background: #fff;
            border-radius: 18px;
            padding: 35px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }
        .icon-box {
            width: 80px; height: 80px;
            margin: auto;
            border-radius: 50%;
            background: #fff3cd;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 35px;
        }
        .form-control, .form-select { border-radius: 12px; font-size: 15px; border: 1px solid #dfe3e8; box-shadow: none; }
        .form-control:focus, .form-select:focus { border-color: #ffc107; box-shadow: 0 0 0 0.15rem rgba(255,193,7,.2); }
        .prefixed-id-box {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 14px 18px;
            font-family: monospace;
            font-size: 15px;
            color: #198754;
            font-weight: 600;
        }
        .alert { border-radius: 12px; }
    </style>
</head>
<body>
<div class="order-card">

    <div class="text-center mb-4">
        <div class="icon-box mb-3">✏️</div>
        <h2 class="fw-bold fs-4">Edit Order</h2>
        <p class="text-muted small">Update order details below</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('orders.update', $order->prefixed_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label fw-semibold">Prefixed ID</label>
            <div class="prefixed-id-box">{{ $order->prefixed_id }}</div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Order Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" style="height:50px"
                   value="{{ old('name', $order->name) }}" required>
            @error('name')<div class="text-danger mt-1 small">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Status</label>
            <select name="status" class="form-select" style="height:50px">
                @foreach(['pending' => '⏳ Pending', 'processing' => '⚙️ Processing', 'completed' => '✅ Completed', 'cancelled' => '❌ Cancelled'] as $val => $label)
                    <option value="{{ $val }}" {{ old('status', $order->status) === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Notes</label>
            <textarea name="notes" class="form-control" rows="3"
                      placeholder="Add any notes...">{{ old('notes', $order->notes) }}</textarea>
        </div>

        <button type="submit" class="btn btn-warning w-100 fw-bold" style="height:55px;border-radius:12px;font-size:17px">
            💾 Update Order
        </button>
    </form>

    <div class="row mt-3 g-2">
        <div class="col-6">
            <a href="{{ route('orders.show', $order->prefixed_id) }}"
               class="btn btn-outline-secondary w-100 fw-semibold" style="height:48px;border-radius:12px;line-height:2">
                👁 View Order
            </a>
        </div>
        <div class="col-6">
            <a href="{{ route('orders.index') }}"
               class="btn btn-dark w-100 fw-semibold" style="height:48px;border-radius:12px;line-height:2">
                📋 All Orders
            </a>
        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
