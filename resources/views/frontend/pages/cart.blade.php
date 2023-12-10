@extends('frontend.layouts.layout')
@section('content')
<div class="site-wrap">

    @include('frontend.layouts.breadcrumb');

    <div class="site-section">
        <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            @if(session()->get('success'))
                                <div class="alert alert-success">{{ session()->get('success') }}</div>
                            @endif
                                @if(session()->get('error'))
                                    <div class="alert alert-danger">{{ session()->get('error') }}</div>
                                @endif
                        </div>
                    </div>
            <div class="row mb-5">
                    <div class="col-lg-12 site-blocks-table">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="product-thumbnail">Image</th>
                                <th class="product-name">Product</th>
                                <th class="product-price">Price</th>
                                <th class="product-quantity">Quantity</th>
                                <th class="product-total">Total</th>
                                <th class="product-remove">Remove</th>
                            </tr>
                            </thead>
                            <tbody>
                        @if($cartItem)
                            @foreach($cartItem as $key => $cart)
                                <tr class="orderItem" data-id="{{$key}}">
                                    <td class="product-thumbnail">
                                        <img src="{{ asset($cart['thumbnail']) }}" alt="Image" class="img-fluid">
                                    </td>
                                    <td class="product-name">
                                        <h2 class="h5 text-black">{{ $cart['name'] }}</h2>
                                    </td>
                                    <td>${{ $cart['price'] }}</td>
                                    <td>
                                        <div class="input-group mb-3" style="max-width: 120px;">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-outline-primary js-btn-minus minusBtn" type="button">&minus;</button>
                                            </div>
                                            <input type="text" class="form-control text-center qtyItem" value="{{ $cart['qty'] }}" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-primary js-btn-plus plusBtn" type="button">&plus;</button>
                                            </div>
                                        </div>

                                    </td>
                                    <td class="itemTotal">${{ $cart['price'] * $cart['qty'] }}</td>
                                    <td>

                                        @php
                                            $encrypt = encrypt($key);
                                        @endphp
                                        <form class="delForm" method="POST">
                                            @csrf
                                            <input type="text" hidden name="product_id" value="{{ $encrypt }}">
                                            <button type="submit" class="btn btn-primary btn-sm">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                            </tbody>
                        </table>
                    </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="row mb-5">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <a href="{{ route('cart') }}" class="btn btn-primary btn-sm btn-block">Update Cart</a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{route('products')}}" class="btn btn-outline-primary btn-sm btn-block">Continue Shopping</a>
                        </div>
                    </div>
                    <form action="{{ route('coupon.check') }}" method="POST">
                        @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label class="text-black h4" for="coupon">Coupon</label>
                            <p>Enter your coupon code if you have one.</p>
                        </div>
                        <div class="col-md-8 mb-3 mb-md-0">
                            <input type="text" class="form-control py-3" id="coupon" name="coupon_name" value="{{ $coupon->name ?? '' }}" placeholder="Coupon Code">
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary btn-sm">Apply Coupon</button>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="col-md-6 pl-5">
                    <div class="row justify-content-end">
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-12 text-right border-bottom mb-5">
                                    <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <span class="text-black">Total</span>
                                </div>
                                <div class="col-md-6 text-right">
                                    <strong class="text-black">${{ $newTotalPrice }}</strong>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-primary btn-lg py-3 btn-block paymentButton">Proceed To Checkout</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_js')
    <script>
        $(document).on('click','.paymentButton', function(e){
            var url = "{{ route('cart.checkout') }}";

            @if(!empty(session()->get('cart')))
                window.location.href = url;
            @endif

        });

        function cartUpdate() {
            var product_id = $('.selected').closest('.orderItem').attr('data-id');
            var qty = $('.selected').closest('.orderItem').find('.qtyItem').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:"POST",
                url:"{{route('cart.newQty')}}",
                data:{
                    product_id:product_id,
                    qty:qty,
                },
                success: function (response) {

                    $('.selected').find('.itemTotal').text('$' + response.itemTotal + '' + '');
                    if (qty == 0) {
                        $('.selected').remove();
                    }
                }
            });
        }

        $(document).on('click','.minusBtn', function(e){
            $('.orderItem').removeClass('selected');
            $(this).closest('.orderItem').addClass('selected');
            cartUpdate();
        });

        $(document).on('click','.plusBtn', function(e){
            $('.orderItem').removeClass('selected');
            $(this).closest('.orderItem').addClass('selected');
            cartUpdate();
        });

        $(document).on('click', '.delForm', function (e) {
            e.preventDefault();
            const formData = $(this).serialize();
            var item = $(this);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:"POST",
                url:"{{route('cart.remove')}}",
                data:formData,
                success: function (response) {
                    toastr.success(response.message);
                    $('.count').text(response.cartCount);
                    item.closest('.orderItem').remove();
                }
            });
        });
    </script>
@endsection
