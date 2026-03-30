<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9fafb;
        }
        .card {
            max-width: 500px;
            margin: 60px auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            background-color: #fff;
        }
        input, button {
            height: 50px;
            font-size: 16px;
        }
        button {
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="card text-center">
    <h2 class="mb-4">Create New Order</h2>

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <input type="text" name="name" class="form-control mb-3" placeholder="Enter Order Name" required>
        <button type="submit" class="btn btn-primary w-100">Create Order</button>
    </form>

    <a href="{{ route('orders.index') }}" class="btn btn-link mt-3">View All Orders</a>
</div>

</body>
</html>