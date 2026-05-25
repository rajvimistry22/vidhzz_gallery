<?php

namespace App\Http\Controllers;

use App\Models\Order;

class AccountController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user()->load('addresses');
        $orders = $user->orders()->with('items')->recent()->take(5)->get();

        return view('account.dashboard', compact('user', 'orders'));
    }

    public function orders()
    {
        $orders = auth()->user()->orders()->with('items')->recent()->paginate(10);

        return view('account.orders', compact('orders'));
    }

    public function showOrder(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        $order->load('items.product', 'payment');

        return view('orders.show', compact('order'));
    }
}
