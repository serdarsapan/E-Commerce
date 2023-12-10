<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceRequest;
use App\Models\Coupon;
use App\Models\Invoice;
use App\Models\Order;
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

        if (session()->get('coupon_code') && $totalPrice != 0) {
            $coupon = Coupon::where('name',session()->get('coupon_code'))->where('status','1')->first();
            $couponPrice = $coupon->price ?? 0;
            $couponCode = $coupon->name ?? '';

            $newTotalPrice = $totalPrice - $couponPrice;
        }else {
            $newTotalPrice = $totalPrice;
        }

        $breadcrumb = [
            'pages' => [

            ],
            'active'=> 'Cart'
        ];

        session()->put('total_price',$newTotalPrice);
        return view('frontend.pages.cart', compact('breadcrumb','cartItem','newTotalPrice'));
    }

    public function checkout()
    {
        $cartItem = session('cart',[]);
        $totalPrice = 0;
        $couponPrice = 0;

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
            $newTotalPrice = $totalPrice;
        }

        $breadcrumb = [
            'pages' => [

            ],
            'active'=> 'Checkout'
        ];

        if (!empty($cartItem)) {
            $breadcrumb['pages'][] = [
                'link'=> route('cart', $cart),
                'name'=> 'Cart'
            ];
        }

        session()->put('total_price',$newTotalPrice);
        return view('frontend.pages.checkout', compact('breadcrumb','cartItem','newTotalPrice','couponPrice'));
    }
    public function add(Request $request)
    {
        $productId = decrypt($request->product_id);
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
            return response()->json(['cartCount'=>count(session()->get('cart')), 'message'=>'Product Successfully Added']);
        }

        return back()->withSuccess('Product Successfully Added');
    }

    public function newQty(Request $request)
    {
        $productId = $request->product_id;
        $qty = $request->qty ?? 1;
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
        $productId = decrypt($request->product_id);
        $cartItem = session('cart',[]);
        if (array_key_exists($productId,$cartItem)) {
            unset($cartItem[$productId]);
        }
        session(['cart' => $cartItem]);

        if ($request->ajax()) {
            return response()->json(['cartCount'=>count(session()->get('cart')), 'message'=>'Removed Successfully!']);
        }
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

    function generateCode() {
        $orderNo = generateOTP(11);
        if ($this->barcodeKodExists($orderNo)) {
            return $this->generateCode();
        }
        return $orderNo;
    }


    function barcodeKodExists($orderNo) {
        return Invoice::where('order_no',$orderNo)->exists();
    }

    public function cartSave(Request $request)
    {
        $request->validate([
            'country' => 'required',
            'name' => 'required|string|max:50',
            'company_name' => 'nullable|string|max:100',
            'address' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'note' => 'nullable|string',
            ],
            [
                'country.required' => 'The country field is required.',
                'name.required' => 'The name field is required.',
                'company_name.max' => 'The company name may not be greater than :100.',
                'address.required' => 'The address field is required.',
                'zip_code.required' => 'The zip code field is required.',
                'email.required' => 'The email field is required.',
                'email.email' => 'Please enter a valid email address.',
                'phone.required' => 'The phone field is required.',]);

        $invoice = Invoice::create([
            "user_id"=>auth()->user()->id ?? null,
            "order_no"=> $this->generateCode(),
            "country"=>$request->country,
            "name"=>$request->name,
            "company_name"=>$request->company_name ?? null,
            "address"=>$request->address ?? null,
            "city"=>$request->city ?? null,
            "phone"=>$request->phone ?? null,
            "zip_code"=>$request->zip_code ?? null,
            "email"=>$request->email ?? null,
            "note"=>$request->note ?? null,
        ]);

        $cart = session()->get('cart') ?? [];
        foreach ( $cart as $key => $item ) {
            Order::create([
                'order_no'=> $invoice->order_no,
                'product_id'=>$key,
                'name'=>$item['name'],
                'price'=>$item['price'],
                'qty'=>$item['qty'],
            ]);
        }

        session()->forget('cart');
        return redirect()->route('thankYou');
    }
}
