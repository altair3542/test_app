<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function store(Request $request)
    {
        $product = Product::find($request->product_id);
        $cart = Session::get('cart', []);
        $cart[$product->id] = [
            "name" => $product->name,
            "quantity" => $request->quantity,
            "price" => $product->price,
            "photo" => $product->photo
        ];
        Session::put('cart', $cart);
        return redirect()->route('cart.index');
    }

    public function destroy($id)
    {
        $cart = Session::get('cart', []);
        unset($cart[$id]);
        Session::put('cart', $cart);
        return redirect()->route('cart.index');
    }
}

