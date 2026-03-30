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