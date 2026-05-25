<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('user', 'payment')
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->recent()
            ->paginate(15)
            ->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('user', 'items.product', 'payment');

        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,confirmed,processing,shipped,delivered,cancelled,refunded'],
            'payment_status' => ['required', 'in:pending,paid,failed,refunded'],
            'tracking_number' => ['nullable', 'string', 'max:255'],
        ]);

        $order->update($data);

        return redirect()->route('admin.orders.show', $order)->with('success', 'Order updated successfully.');
    }
}
