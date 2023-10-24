<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
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

        if (session()->get('coupon_code')) {
            $coupon = Coupon::where('name',session()->get('coupon_code'))->where('status','1')->first();
            $couponPrice = $coupon->price ?? 0;
            $couponCode = $coupon->name ?? '';

            $newTotalPrice = $totalPrice - $couponPrice;
        }else {
            $newTotalPrice = 0;
        }

        session()->put('total_price',$newTotalPrice);
        return view('frontend.pages.cart', compact('cartItem','newTotalPrice'));
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

        if ($request->ajax()) {
            return response()->json('Cart Updated');
        }

        return back()->withSuccess('Product Successfully Added');
    }

    public function newQty(Request $request)
    {
        $productId = $request->product_id;
        $qty = $request->qty ?? 1;
        $size = $request->size;
        $itemTotal = 0;

        $product = Products::find($productId);

        if (empty($product)) {
            return response()->json('Product Cannot Found!');
        }
        $cartItem = session('cart',[]);

        if (array_key_exists($productId,$cartItem)){
            $cartItem[$productId]['qty'] += $qty;
            if ($qty == 0 || $qty < 0){
                unset($cartItem[$productId]);
            }
            $itemTotal = $product->price * $qty;
        }
        session(['cart'=>$cartItem]);

        if ($request->ajax()) {
            return response()->json(['itemTotal'=>$itemTotal,'message'=>'Cart Updated']);
        }

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

    public function coupon(Request $request)
    {
        $cartItem = session('cart',[]);
        $totalPrice = 0;

        foreach ($cartItem as $cart)
        {
            $totalPrice += $cart['price'] * $cart['qty'];
        }

        $coupon = Coupon::where('name',$request->coupon_name)->where('status','1')->first();

        if (empty($coupon)) {
            return back()->withError('Coupon Not Founded!');
        }

        $couponPrice = $coupon->price ?? 0;
        $couponCode = $coupon->name ?? '';

        $newTotalPrice = $totalPrice - $couponPrice;

        session()->put('total_price',$newTotalPrice);
        session()->put('coupon_code',$couponCode);

        return back()->withSuccess('Coupon Applied!');
    }
}
