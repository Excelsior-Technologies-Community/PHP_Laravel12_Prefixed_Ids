<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background:
                linear-gradient(135deg, #020617, #0f172a, #111827);
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
            color: white;
        }

        /* BACKGROUND BLUR */

        .bg-blur-1 {
            position: absolute;
            width: 350px;
            height: 350px;
            background: #8b5cf6;
            border-radius: 50%;
            filter: blur(120px);
            top: -100px;
            left: -100px;
            opacity: 0.35;
        }

        .bg-blur-2 {
            position: absolute;
            width: 350px;
            height: 350px;
            background: #06b6d4;
            border-radius: 50%;
            filter: blur(120px);
            bottom: -100px;
            right: -100px;
            opacity: 0.30;
        }

        /* CARD */

        .order-card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 550px;
            padding: 45px;
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(14px);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.35);
            text-align: center;
        }

        /* ICON */

        .success-icon {
            width: 95px;
            height: 95px;
            margin: auto;
            border-radius: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 42px;
            background: linear-gradient(135deg, #10b981, #14b8a6);
            box-shadow: 0 12px 30px rgba(16, 185, 129, 0.35);
            margin-bottom: 25px;
        }

        /* TITLE */

        .title {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 12px;
            background: linear-gradient(135deg, #8b5cf6, #06b6d4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .subtitle {
            color: #94a3b8;
            font-size: 15px;
            margin-bottom: 35px;
        }

        /* INFO BOX */

        .info-box {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 22px;
            padding: 22px;
            margin-bottom: 20px;
            text-align: left;
        }

        .info-label {
            color: #94a3b8;
            font-size: 13px;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            color: white;
            font-size: 18px;
            font-weight: 600;
            word-break: break-word;
        }

        /* PREFIXED ID */

        .prefixed-id {
            display: inline-block;
            padding: 12px 18px;
            border-radius: 14px;
            background: linear-gradient(135deg, #10b981, #14b8a6);
            color: white;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.5px;
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.35);
        }

        /* BUTTONS */

        .btn-custom {
            height: 58px;
            border: none;
            border-radius: 18px;
            font-size: 15px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: 0.3s;
            text-decoration: none;
        }

        .btn-create {
            background: linear-gradient(135deg, #8b5cf6, #06b6d4);
            color: white;
            box-shadow: 0 10px 25px rgba(139, 92, 246, 0.35);
        }

        .btn-dashboard {
            background: rgba(255, 255, 255, 0.06);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .btn-custom:hover {
            transform: translateY(-3px);
            color: white;
        }
    </style>

</head>

<body>

    {{-- BACKGROUND --}}
    <div class="bg-blur-1"></div>
    <div class="bg-blur-2"></div>

    {{-- CARD --}}
    <div class="order-card">

        {{-- SUCCESS ICON --}}
        <div class="success-icon">
            🎉
        </div>

        {{-- TITLE --}}
        <h1 class="title">
            Order Created
        </h1>

        <p class="subtitle">
            Your order has been successfully created with a unique prefixed ID.
        </p>

        {{-- ORDER NAME --}}
        <div class="info-box">

            <div class="info-label">
                Order Name
            </div>

            <div class="info-value">
                {{ $order->name }}
            </div>

        </div>

        {{-- PREFIXED ID --}}
        <div class="info-box">

            <div class="info-label">
                Prefixed ID
            </div>

            <div class="info-value">

                <span class="prefixed-id">
                    {{ $order->prefixed_id }}
                </span>

            </div>

        </div>

        {{-- BUTTONS --}}
        <div class="row mt-4 g-3">

            <div class="col-md-6">

                <a href="{{ route('orders.create') }}" class="btn btn-custom btn-create w-100">

                    ➕ Create Another

                </a>

            </div>

            <div class="col-md-6">

                <a href="{{ route('orders.index') }}" class="btn btn-custom btn-dashboard w-100">

                    📦 View Orders

                </a>

            </div>

        </div>

    </div>

</body>

</html>