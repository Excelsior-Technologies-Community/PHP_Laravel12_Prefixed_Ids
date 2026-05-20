<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background:#f4f7fb;
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .order-card{
            width:100%;
            max-width:550px;
            background:#fff;
            border-radius:18px;
            padding:35px;
            box-shadow:0 10px 30px rgba(0,0,0,0.08);
        }

        .title{
            font-size:32px;
            font-weight:700;
            color:#212529;
        }

        .subtitle{
            color:#6c757d;
            font-size:15px;
        }

        .form-control{
            height:55px;
            border-radius:12px;
            font-size:16px;
            border:1px solid #dfe3e8;
            box-shadow:none;
        }

        .form-control:focus{
            border-color:#0d6efd;
            box-shadow:0 0 0 0.15rem rgba(13,110,253,.15);
        }

        .btn-create{
            height:55px;
            border-radius:12px;
            font-size:17px;
            font-weight:600;
        }

        .btn-orders{
            border-radius:12px;
            height:50px;
            font-weight:600;
        }

        .icon-box{
            width:80px;
            height:80px;
            margin:auto;
            border-radius:50%;
            background:#e9f2ff;
            display:flex;
            justify-content:center;
            align-items:center;
            font-size:35px;
        }

        .alert{
            border-radius:12px;
        }

        .error-text{
            font-size:14px;
            text-align:left;
        }
    </style>
</head>
<body>

<div class="order-card">

    <div class="text-center mb-4">

        <div class="icon-box mb-3">
            📦
        </div>

        <h2 class="title">
            Create New Order
        </h2>

        <p class="subtitle">
            Laravel 12 Prefixed ID Order Management System
        </p>

    </div>

    {{-- Success Message --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    {{-- Create Form --}}
    <form action="{{ route('orders.store') }}" method="POST">

        @csrf

        <div class="mb-4">

            <label class="form-label fw-semibold mb-2">
                Order Name
            </label>

            <input
                type="text"
                name="name"
                class="form-control"
                placeholder="Enter Order Name"
                value="{{ old('name') }}"
                required
            >

            @error('name')

                <div class="text-danger mt-2 error-text">
                    {{ $message }}
                </div>

            @enderror

        </div>

        <button
            type="submit"
            class="btn btn-primary w-100 btn-create">

            🚀 Create Order

        </button>

    </form>

    <div class="d-grid mt-3">

        <a
            href="{{ route('orders.index') }}"
            class="btn btn-dark btn-orders">

            📋 View All Orders

        </a>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>