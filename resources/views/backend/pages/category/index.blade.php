@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Category</h4>
                    <p class="card-description">
                        <a href="{{ route('dashboard.category.create') }}" class="btn btn-github">Add Table</a>
                    </p>

                    @if(session()->get('success'))
                        <div class="alert alert-success">{{ session()->get('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($categories) && $categories->count() > 0)
                                @foreach($categories as $category)
                                    <tr class="item" itemid="{{$category->id}}">
                                        <td><img src="{{ $category->image }}" alt="image"></td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->content ?? '' }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>
                                            <div class="checkbox">
                                                <label>
                                            <input type="checkbox" class="case" data-on="In Progress" data-off="Pending" data-onstyle="success" data-offstyle="danger" {{ $category->status == '1' ? 'checked' : '' }} data-toggle="toggle">
                                                </label>
                                            </div>
                                        </td>
                                        <td><a href="{{ route('dashboard.category.edit', $category->id) }}" class="btn btn-primary">Edit</a></td>
                                        <td>
{{--                                            <form action="{{ route('dashboard.category.destroy', $category->id) }}" method="POST">--}}
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
                url:"{{ route('dashboard.category.status') }}",
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
                        url:"{{ route('dashboard.category.destroy') }}",
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
