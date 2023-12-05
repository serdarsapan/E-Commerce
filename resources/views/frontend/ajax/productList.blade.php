@if(!empty($products) && $products->count() > 0)
    @foreach($products as $product)
        <div class="col-sm-6 col-lg-4 mb-4" data-aos="fade-up">
            <div class="block-4 text-center border">
                <figure class="block-4-image">
                    <a href="{{ route('proDetail', $product->slug) }}"><img src="{{ asset($product->thumbnail) }}" alt="Image placeholder" class="img-fluid"></a>
                </figure>
                <div class="block-4-text p-4">
                    <h3><a href="{{ route('proDetail', $product->slug) }}">{{ $product->name }}</a></h3>
                    <p class="mb-0">{{ $product->short_text }}</p>
                    <p class="text-primary font-weight-bold">${{ $product->price }}</p>

                    @php
                    $encrypt = encrypt($product->id);
                    @endphp

                    <form id="addForm" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $encrypt }}">
                        <input type="hidden" name="size" value="{{ $product->size }}">
                        <button type="submit" class="buy-now btn btn-sm btn-primary">Add To Cart</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endif
