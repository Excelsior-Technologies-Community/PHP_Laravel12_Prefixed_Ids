<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9fafb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            max-width: 500px;
            margin: 60px auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            background-color: #fff;
        }
        .prefixed-id {
            font-size: 20px;
            font-weight: bold;
            color: #198754;
        }
    </style>
</head>
<body>

<div class="card text-center">
    <h2 class="mb-4">Order Created Successfully 🎉</h2>

    <p><strong>Name:</strong> {{ $order->name }}</p>
    <p class="prefixed-id"><strong>Prefixed ID:</strong> {{ $order->prefixed_id }}</p>

    <a href="{{ route('orders.create') }}" class="btn btn-primary mt-3">Create Another Order</a>
    <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-3">View All Orders</a>
</div>

</body>
</html>