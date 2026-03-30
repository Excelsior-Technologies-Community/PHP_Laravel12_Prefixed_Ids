# PHP_Laravel12_Prefixed_Ids

## Introduction

PHP_Laravel12_Prefixed_Ids is a modern Laravel 12 project designed to implement friendly, unique prefixed IDs for Eloquent models.

Instead of using numeric IDs (1, 2, 3…), this system generates human-readable, unique identifiers like:

- order_f83kdls93kdl
- user_x93kdls82ks

This approach makes URLs cleaner, improves security, and avoids exposing sequential numeric IDs in public routes.

---

## Project Overview

- Auto-generated Prefixed IDs: Every model can have a unique, custom prefixed ID automatically generated on creation.

- Reusable Trait System: The HasPrefixedId trait can be added to any model for instant prefixed ID support.

- Multi-Model Support: Config-driven, supports multiple models (orders, users, etc.) with different prefixes.

- Route Model Binding: Automatically binds models using prefixed IDs in routes.

- Configurable: Prefixes, attribute names, and supported models are easily configurable via config/prefixed_ids.php.

- Simple Modern UI: Blade templates demonstrate creating, viewing, and listing orders with a professional 2026-ready design.

- Service-Oriented Architecture: Includes a dedicated PrefixedIdManager service for generating and resolving IDs.

- Easy Extensibility: New models can be added to the system by updating the config and applying the trait.

---

## Features

- Auto-generated prefixed IDs
- Trait-based reusable system
- Multi-model support
- Find model by prefixed ID
- Route model binding
- Config-driven architecture
- Simple UI (Blade) for demo

---

## Step 1: Create Laravel 12 Project

```bash
composer create-project laravel/laravel PHP_Laravel12_Prefixed_Ids "12.*"
cd PHP_Laravel12_Prefixed_Ids
```

---

## Step 2: Setup Database

Update .env

```.env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=prefixed_ids_db
DB_USERNAME=root
DB_PASSWORD=
```

Run Migration Command:

```bash
php artisan migrate
```

---

## Step 3: Migration Table

```bash
php artisan make:migration create_orders_table
```

File: `database/migrations/xxxx_xx_xx_create_orders_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('prefixed_id')->unique()->nullable();
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
```
Run:

```bash
php artisan migrate
```

---

## Step 4: Config File

File: `config/prefixed_ids.php`

```php
<?php

return [
    'prefixed_id_attribute_name' => 'prefixed_id',

    'models' => [
        'order_' => App\Models\Order::class,
        'user_' => App\Models\User::class,
    ],
];
```

---

## Step 5: PrefixedIdManager

File: `app/Services/PrefixedIdManager.php`

```php
<?php

namespace App\Services;

use Illuminate\Support\Str;

class PrefixedIdManager
{
    protected $models = [];

    public function registerModels(array $models)
    {
        $this->models = $models;
    }

    public function generate(string $prefix): string
    {
        return $prefix . Str::random(12);
    }

    public function getModelClass(string $prefixedId): ?string
    {
        foreach ($this->models as $prefix => $model) {
            if (str_starts_with($prefixedId, $prefix)) {
                return $model;
            }
        }
        return null;
    }

    public function find(string $prefixedId)
    {
        $modelClass = $this->getModelClass($prefixedId);
        return $modelClass ? $modelClass::where('prefixed_id', $prefixedId)->first() : null;
    }
}
```

---

## Step 6: Trait

File: `app/Traits/HasPrefixedId.php`

```php
<?php

namespace App\Traits;

use App\Services\PrefixedIdManager;

trait HasPrefixedId
{
    protected static function bootHasPrefixedId()
    {
        static::creating(function ($model) {
            $manager = app(PrefixedIdManager::class);

            // Get prefix for this model from config
            $prefix = array_search(static::class, config('prefixed_ids.models'));

            $model->prefixed_id = $manager->generate($prefix);
        });
    }

    public function scopeFindByPrefixedId($query, $id)
    {
        return $query->where('prefixed_id', $id)->first();
    }

    public function getRouteKeyName()
    {
        return config('prefixed_ids.prefixed_id_attribute_name');
    }
}
```

---

## Step 7: Model

Run:

```bash
php artisan make:model Order
```

File: `app/Models/Order.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasPrefixedId;

class Order extends Model
{
    use HasPrefixedId;

    protected $fillable = ['name'];


    /**
     * Use prefixed_id for route model binding instead of id
     */
    public function getRouteKeyName()
    {
        return 'prefixed_id';
    }
}
```

---
	
## Step 8: Service Provider

```bash
php artisan make:provider PrefixedIdServiceProvider
```

File: `app/Providers/PrefixedIdServiceProvider.php`

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PrefixedIdManager;

class PrefixedIdServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(PrefixedIdManager::class, fn() => new PrefixedIdManager());
    }

    public function boot()
    {
        app(PrefixedIdManager::class)
            ->registerModels(config('prefixed_ids.models'));
    }
}
```

---

## Step 9: config/app.php

```php
'providers' => [

        /*
     * Laravel Framework Service Providers...
     */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class, // required for artisan make
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class, // required for file operations
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
     * Application Service Providers...
     */
        App\Providers\AppServiceProvider::class,
        App\Providers\PrefixedIdServiceProvider::class,

    ],
```

---

## Step 10: Controller 

Run:

```bash
php artisan make:controller OrderController
```

File: `app/Http/Controllers/OrderController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{

    //  Show all orders
    public function index()
    {
        $orders = Order::all();
        return view('orders.index', compact('orders'));
    }

    //  Show create form
    public function create()
    {
        return view('orders.create');
    }

    //  Store order
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|max:255']);

        $order = Order::create(['name' => $request->name]);

        return redirect()->route('orders.show', $order->prefixed_id);
    }

    //  Show single order
    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }
}
```

---

## Step 11: Blade UI Views

### Create Order Form

File: `resources/views/orders/create.blade.php`

```blade
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
```

### Index Page View

File: `resources/views/orders/index.blade.php`

```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9fafb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .btn-view {
            border-radius: 8px;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            background-color: #fff;
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>All Orders</h2>
        <a href="{{ route('orders.create') }}" class="btn btn-primary">Create New Order</a>
    </div>

    <div class="card">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Prefixed ID</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->name }}</td>
                    <td><span class="text-success">{{ $order->prefixed_id }}</span></td>
                    <td>
                        <a href="{{ route('orders.show', $order->prefixed_id) }}" class="btn btn-success btn-sm btn-view">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
```

### Show Order

File: `resources/views/orders/show.blade.php`

```blade
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
```

---

## Step 12: Routes

File: `routes/web.php`

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

Route::get('/', function () {
    return view('welcome');
});
```

---

## Step 13: Run Project

Run:

```bash
php artisan serve
```
Open in browser:

```bash
http://127.0.0.1:8000/orders
```

---

## Output

<img src="screenshots/Screenshot 2026-03-30 144655.png" width="1000">

<img src="screenshots/Screenshot 2026-03-30 144710.png" width="1000">

<img src="screenshots/Screenshot 2026-03-30 144732.png" width="1000">

---

## Project Structure

```
PHP_Laravel12_Prefixed_Ids/
│
├─ app/
│   ├─ Models/
│   │   └─ Order.php
│   │
│   ├─ Traits/
│   │   └─ HasPrefixedId.php
│   │
│   ├─ Services/
│   │   └─ PrefixedIdManager.php
│   │
│   ├─ Providers/
│   │   └─ PrefixedIdServiceProvider.php
│   │
│   └─ Http/Controllers/
│       └─ OrderController.php
│
├─ config/
│   └─ prefixed_ids.php
│
├─ resources/views/orders/
│   ├─ create.blade.php      # Form to create a new order
│   ├─ show.blade.php        # Show order details
│   └─ index.blade.php       # List all orders
│
├─ routes/
│   └─ web.php
│
├─ .env                       # Environment configuration (DB, APP_KEY, etc.)
├─ artisan
├─ composer.json
├─ composer.lock
└─ README.md                  # Step-by-step guide, code, instructions
```

---

Your PHP_Laravel12_Prefixed_Ids Project is now ready!
