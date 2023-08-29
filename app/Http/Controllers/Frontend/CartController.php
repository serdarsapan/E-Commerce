<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItem = session('cart',[]);
        $totalPrice = 0;

        foreach ($cartItem as $cart)
        {
            $totalPrice += $cart['price'] * $cart['qty'];
        }

        return view('frontend.pages.cart', compact('cartItem','totalPrice'));
    }
    public function add(Request $request)
    {
        $productId = $request->product_id;
        $qty = $request->qty;
        $size = $request->size;

        $product = Products::find($productId);

        if (empty($product)) {
            return back()->withErrors('Product Cannot Found!');
        }
        $cartItem = session('cart',[]);

        if (array_key_exists($productId,$cartItem)){
            $cartItem[$productId]['qty'] += $qty;
        }else{
            $cartItem[$productId] = [
                'thumbnail' => $product->thumbnail,
                'name' => $product->name,
                'price' => $product->price,
                'qty' => $qty ?? 1,
                'size' => $size,
            ];
        }
        session(['cart'=>$cartItem]);

        return back()->withSuccess('Product Successfully Added');
    }

    public function remove(Request $request)
    {
        $request->all();
        $productId = $request->product_id;
        $cartItem = session('cart',[]);
        if (array_key_exists($productId,$cartItem)) {
            unset($cartItem[$productId]);
        }
        session(['cart' => $cartItem]);
        return back()->withSuccess('Removed Successfully!');
    }
}
