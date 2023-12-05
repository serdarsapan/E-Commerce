@extends('frontend.layouts.layout')
@section('content')
    <div class="site-wrap">

        <div class="bg-light py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mb-0"><a href="{{ asset('/') }}">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Shop</strong></div>
                </div>
            </div>
        </div>

        <div class="site-section">
            <div class="container">

                <div class="row mb-5">
                    <div class="col-md-9 order-2">

                        <div class="row">
                            <div class="col-md-12 mb-5">
                                <div class="float-md-left mb-4"><h2 class="text-black h5">Shop All</h2></div>
                                <div class="d-flex">
                                    <div class="dropdown mr-1 ml-md-auto">
                                        <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" id="dropdownMenuOffset" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Latest
                                        </button>

                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                                            @if($categories->count() > 0)
                                                @foreach($categories->where('parent', null) as $category)
                                                    <a class="dropdown-item" href="{{ url('products? category='.$category->slug) }}">{{ $category->name }}</a>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="btn-group">
                                        <select class="form-control" id="orderList">
                                            <option class="dropdown-item">Reference</option>
                                            <option class="dropdown-item" value="id-desc" data-order="a_z_order">Name, A to Z</option>
                                            <option class="dropdown-item" value="id-asc" data-order="z_a_order">Name, Z to A</option>
                                            <option class="dropdown-item" value="price-asc" data-order="price_min_order">Price, low to high</option>
                                            <option class="dropdown-item" value="price-desc" data-order="price_max_order">Price, high to low</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                @if(session()->get('success'))
                                    <div class="alert alert-success">{{ session()->get('success') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-5 productContent">

                            @include('frontend.ajax.productList')

                        </div>
                        <div class="row" data-aos="fade-up">
                            {{ $products->withQueryString()->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                    <div class="col-md-3 order-1 mb-5 mb-md-0">
                        <div class="border p-4 rounded mb-4">
                            <h3 class="mb-3 h6 text-uppercase text-black d-block">Categories</h3>
                            <ul class="list-unstyled mb-0">
                                @if($categories->count() > 0)
                                    @foreach($categories->where('parent', null) as $category)
                                        <li class="mb-1"><a href="{{ url('products? category='.$category->slug) }}" class="d-flex"><span>{{ $category->name }}</span> <span class="text-black ml-auto">({{ $category->items_count }})</span></a></li>
                                    @endforeach

                                @endif

                            </ul>
                        </div>

                        <div class="border p-4 rounded mb-4">
                            <div class="mb-4">
                                <h3 class="mb-3 h6 text-uppercase text-black d-block">Filter by Price</h3>
                                <div id="slider-range" class="border-primary"></div>
                                 <input type="text" name="text" id="amount" class="form-control border-0 pl-0 bg-white" disabled="" />

                                <input type="text" name="text" id="priceBetween" disabled="" hidden />
                            </div>

                            <div class="mb-4">
                                <h3 class="mb-3 h6 text-uppercase text-black d-block">Size</h3>
                                @if(!empty($sizeLists))
                                    @foreach($sizeLists as $key => $size)
                                        <label for="size{{$key}}" class="d-flex">
                                            <input type="checkbox" id="size{{$key}}" {{ isset(request()->size) && in_array($size,explode(',',request()->size)) ? 'checked' : '' }} class="mr-2 mt-1 sizeList" data-key="{{$size}}"> <span class="text-black">{{ $size }}</span>
                                        </label>
                                    @endforeach
                                @endif
                            </div>

                            <div class="mb-4">
                                <h3 class="mb-3 h6 text-uppercase text-black d-block">Color</h3>
                                @if(!empty($colors))
                                    @foreach($colors as $key => $color)
                                        <label for="color{{$key}}" class="d-flex">
                                            <input type="checkbox" id="color{{$key}}" {{ isset(request()->color) && in_array($color,explode(',',request()->color)) ? 'checked' : '' }} class="mr-2 mt-1 colorList" data-key="{{$color}}"> <span class="text-black">{{ $color }}</span>
                                        </label>
                                    @endforeach
                                @endif
                            </div>
                            <div class="mb-4">
                                <button class="btn btn-primary filterBtn">Filter</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="site-section site-blocks-2">
                            <div class="row justify-content-center text-center mb-5">
                                <div class="col-md-7 site-section-heading pt-4">
                                    <h2>Categories</h2>
                                </div>
                            </div>
                            <div class="row">
                                @if(!empty($categories))
                                    @foreach($categories->where('parent', null) as $category)
                                        <div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0" data-aos="fade" data-aos-delay="">
                                            <a class="block-2-item" href="{{ route('products',$category->slug) }}">
                                                <figure class="image">
                                                    <img src="{{ asset($category->image) }}" alt="" class="img-fluid">
                                                </figure>
                                                <div class="text">
                                                    <span class="text-uppercase">Collections</span>
                                                    <h3>{{ $category->name }}</h3>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>

@endsection
        @section('custom_js')
            <script>
                var maxPrice = "{{$maxPrice}}";
                var defaultMinPrice = "{{request()->min ?? 0 }}";
                var defaultMaxPrice = "{{ request()->max ?? $maxPrice }}";

                var url = new URL(window.location.href);

                $(document).on('click','.filterBtn', function(e){
                   filter();
                });

                function filter() {
                    let colorList = $(".colorList:checked").map(function() {
                        return $(this).data('key');
                    }).get();
                    let sizeList = $(".sizeList:checked").map(function() {
                        return $(this).data('key');
                    }).get();

                    console.log('Color List Values:', colorList);
                    console.log('Size List Values:', sizeList);

                    if (colorList.length > 0) {
                        url.searchParams.set("color", colorList.join(","))
                    }else {
                        url.searchParams.delete('color');
                    }

                    if (sizeList.length > 0) {
                        url.searchParams.set("size", sizeList.join(","))
                    }else {
                        url.searchParams.delete('size');
                    }

                    var price = $('#priceBetween').val().split('-');
                    url.searchParams.set("min", price[0])
                    url.searchParams.set("max", price[1])

                    newUrl = url.href;
                    window.history.pushState({}, '', newUrl);
                    //location.reload();

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                        },
                        type:"GET",
                        url: newUrl,
                        success: function (response) {
                            $('.productContent').html(response.data);
                            $('.paginateButtons').html(response.paginate);
                        }
                    });
                }


                $(document).on('change', '#orderList', function (e) {

                    var order = $(this).val();

                    if (order != '') {
                        orderBy = order.split('-');

                        url.searchParams.set("order", orderBy[0])
                        url.searchParams.set("sort", orderBy[1])
                    }else {
                        url.searchParams.delete('order');
                        url.searchParams.delete('sort');
                    }

                    filter();
                });

                $(document).on('submit', '#addForm', function (e) {
                    e.preventDefault();
                    const formData = $(this).serialize();
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type:"POST",
                        url:"{{route('cart.add')}}",
                        data:formData,
                        success: function (response) {
                            toastr.success(response.message);
                            $('.count').text(response.cartCount);
                        }
                    });
                });

            </script>
@endsection

