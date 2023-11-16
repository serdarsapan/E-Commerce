@extends('frontend.layouts.layout')
@section('content')
<div class="site-wrap">

    <div class="bg-light py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-0"><a href="{{ asset('/') }}">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Tank Top T-Shirt</strong></div>
            </div>
        </div>
    </div>

    <div class="site-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @if(session()->get('success'))
                        <div class="alert alert-success">{{ session()->get('success') }}</div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ $product->image }}" alt="Image" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <h2 class="text-black">{{ $product->name }}</h2>
                    <p>{{ $product->content }}</p>

                    <p><strong class="text-primary h4">$ {{ $product->price,2 }}</strong></p>
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="size" value="{{ $product->size }}">
                    <div class="mb-1 d-flex">



                        <label for="option-md" class="d-flex mr-3 mb-3">
                            <span class="d-inline-block mr-2" style="top:-2px; position: relative;"><input type="radio" id="option-md" name="size" value="Medium"></span> <span class="d-inline-block text-black">Medium</span>
                        </label>
                        <label for="option-lg" class="d-flex mr-3 mb-3">
                            <span class="d-inline-block mr-2" style="top:-2px; position: relative;"><input type="radio" id="option-lg" name="size" value="Large"></span> <span class="d-inline-block text-black">Large</span>
                        </label>
                        <label for="option-xl" class="d-flex mr-3 mb-3">
                            <span class="d-inline-block mr-2" style="top:-2px; position: relative;"><input type="radio" id="option-xl" name="size" value="X-Large"></span> <span class="d-inline-block text-black">X-Large</span>
                        </label>
                    </div>


                    <div class="mb-5">
                        <div class="input-group mb-3" style="max-width: 120px;">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
                            </div>
                            <input type="text" class="form-control text-center" value="1" placeholder="" name="qty" aria-label="Example text with button addon" aria-describedby="button-addon1">
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
                            </div>
                        </div>

                    </div>
                    <p><button type="submit" class="buy-now btn btn-sm btn-primary">Add To Cart</button></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="site-section block-3 site-blocks-2 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 site-section-heading text-center pt-4">
                    <h2>Featured Products</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="nonloop-block-3 owl-carousel">
                        @if(!empty($lastProducts) && $lastProducts->count() > 0)
                            @foreach($lastProducts as $item)
                                <div class="item">
                                    <div class="block-4 text-center">
                                        <figure class="block-4-image">
                                            <img src="{{ asset($item->image) }}" alt="Image placeholder" class="img-fluid">
                                        </figure>
                                        <div class="block-4-text p-4">
                                            <h3><a href="{{ route('proDetail', $item->slug) }}">{{ $item->name }}</a></h3>
                                            <p class="mb-0">{{ $item->category_name }}</p>
                                            <p class="text-primary font-weight-bold">${{ $item->price }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="nonloop-block-3 owl-carousel">
                        @if(!empty($cartItems) && $cartItems->count() > 0)
                            @foreach($cartItems as $item)
                                <div class="item">
                                    <div class="block-4 text-center">
                                        <figure class="block-4-image">
                                            <img src="{{ asset($item->thumbnail) }}" alt="{{ $item->name }}" class="img-fluid">
                                        </figure>
                                        <div class="block-4-text p-4">
                                            <h3><a href="{{ route('proDetail',$item->slug) }}">{{ $item->name }}</a></h3>
                                            <p class="text-primary font-weight-bold">${{ $item->price }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                </div>
            </div>
        </div>

    </div>
@endsection

