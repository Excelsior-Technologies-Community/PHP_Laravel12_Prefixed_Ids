<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    // Show all orders
    public function index(Request $request)
    {
        $search = $request->search;

        $orders = Order::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('prefixed_id', 'like', "%{$search}%");
        })
        ->oldest()
        ->paginate(3);

        $totalOrders = Order::count();

        return view('orders.index', compact(
            'orders',
            'totalOrders',
            'search'
        ));
    }

    // Show create form
    public function create()
    {
        return view('orders.create');
    }

    // Store order
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255'
        ]);

        $order = Order::create([
            'name' => $request->name
        ]);

        return redirect()
            ->route('orders.show', $order->prefixed_id)
            ->with('success', 'Order Created Successfully!');
    }

    // Show single order
    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    // Delete order
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order Deleted Successfully!');
    }
}