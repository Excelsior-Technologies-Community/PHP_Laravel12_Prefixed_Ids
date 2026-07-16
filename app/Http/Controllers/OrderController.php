<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $orders = Order::when($search, fn($q) =>
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('prefixed_id', 'like', "%{$search}%")
        )->oldest()->paginate(10);

        $totalOrders = Order::count();

        return view('orders.index', compact('orders', 'totalOrders', 'search'));
    }

    public function create()
    {
        return view('orders.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|max:255']);

        $order = Order::create([
            'name'   => $request->name,
            'status' => $request->status ?? 'pending',
            'notes'  => $request->notes,
        ]);

        return redirect()
            ->route('orders.show', $order->prefixed_id)
            ->with('success', 'Order Created Successfully! 🎉');
    }

    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate(['name' => 'required|max:255']);

        $order->update([
            'name'   => $request->name,
            'status' => $request->status,
            'notes'  => $request->notes,
        ]);

        return redirect()
            ->route('orders.show', $order->prefixed_id)
            ->with('success', 'Order Updated Successfully! ✅');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order Deleted Successfully! 🗑️');
    }
}
