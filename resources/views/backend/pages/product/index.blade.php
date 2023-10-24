@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Product</h4>
                    <p class="card-description">
                        <a href="{{ route('dashboard.product.create') }}" class="btn btn-github">Add Table</a>
                    </p>

                    @if(session()->get('success'))
                        <div class="alert alert-success">{{ session()->get('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Content</th>
                                <th>Short Text</th>
                                <th>Price</th>
                                <th>Size</th>
                                <th>Color</th>
                                <th>Quantity</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($products) && $products->count() > 0)
                                @foreach($products as $product)
                                    <tr class="item" itemid="{{$product->id}}">
                                        <td><img src="{{ $product->thumbnail }}" alt="image"></td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->content ?? '' }}</td>
                                        <td>{{ $product->short_text }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->size }}</td>
                                        <td>{{ $product->color }}</td>
                                        <td>{{ $product->qty }}</td>
                                        <td>
                                            <div class="checkbox">
                                                <label>
                                            <input type="checkbox" class="case" data-on="In Progress" data-off="Pending" data-onstyle="success" data-offstyle="danger" {{ $product->status == '1' ? 'checked' : '' }} data-toggle="toggle">
                                                </label>
                                            </div>
                                        </td>
                                        <td><a href="{{ route('dashboard.product.edit', $product->id) }}" class="btn btn-primary">Edit</a></td>
                                        <td>
{{--                                            <form action="{{ route('dashboard.product.destroy', $product->id) }}" method="POST">--}}
{{--                                                @csrf--}}
{{--                                                @method('DELETE')--}}
{{--                                                <button type="submit" class="btn btn-danger">Delete</button>--}}
{{--                                            </form>--}}

                                            <button type="submit" class="btn delBtn btn-danger">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customjs')
    <script>

        $(document).on('change', '.case', function (e) {

            let item = $(this).closest('.item');
            id = item.attr('itemid');
            statu = $(this).prop('checked');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                },
                type:"POST",
                url:"{{ route('dashboard.product.status') }}",
                data:{
                    id:id,
                    statu:statu
                },
                success: function (response) {
                    if (response.status == `true`)
                    {
                        alertify.success("Case is Enabled");
                    } else {
                        alertify.error("Case is Disabled");
                    }
                }
            });
        });

        $(document).on('click', '.delBtn', function (e) {
            e.preventDefault();

            let item = $(this).closest('.item');
            id = item.attr('itemid');
            alertify.confirm('Shoppers','Are You Sure You Want To Delete?',
                function () {

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                        },
                        type:"DELETE",
                        url:"{{ route('dashboard.product.destroy') }}",
                        data:{
                            id:id
                        },
                        success: function (response) {
                            if (response.error == false)
                            {
                                item.remove();
                                alertify.success(response.message);
                            } else {
                                alertify.error("Ups! Something Went Wrong");
                            }
                        }
                    });
                },
                function (){
                    alertify.error('Deleting Canceled');
                });
        });

    </script>
@endsection
