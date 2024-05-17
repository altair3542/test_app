<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function create()
    {
        $cart = Session::get('cart', []);
        return view('checkout.create', compact('cart'));
    }

    public function store(Request $request)
    {
        $cart = Session::get('cart', []);
        $order = new Order();
        $order->user_id = Auth::id();
        $order->total = array_sum(array_column($cart, 'price'));
        $order->save();

        foreach ($cart as $item) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $item['id'];
            $orderItem->quantity = $item['quantity'];
            $orderItem->price = $item['price'];
            $orderItem->save();
        }

        Session::forget('cart');
        return redirect()->route('home')->with('success', 'Order placed successfully');
    }
}
