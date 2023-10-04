@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Site Settings</h4>
                    <p class="card-description">
                        <a href="{{ route('dashboard.setting.create') }}" class="btn btn-github">Add Table</a>
                    </p>


                    @if(session()->get('success'))
                        <div class="alert alert-success">{{ session()->get('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Key</th>
                                <th>Value</th>
                                <th>Type</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($settings) && $settings->count() > 0)
                                @foreach($settings as $setting)
                                    <tr class="item" itemid="{{$setting->id}}">
{{--                                        <td class="py-1">--}}
{{--                                            @if($setting->type == 'image')--}}
{{--                                                <img src="{{ asset($setting->image) }}" alt="image"/>--}}
{{--                                            @endif--}}
                                        </td>
                                        <td>{{ $setting->name }}</td>
                                        <td>{{ $setting->data ?? '' }}</td>
                                        <td>{{ $setting->type }}</td>

                                        <td><a href="{{ route('dashboard.setting.edit', $setting->id) }}" class="btn btn-primary">Edit</a></td>
                                        <td>
{{--                                            <form action="{{ route('dashboard.slider.destroy', $slider->id) }}" method="POST">--}}
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
                        url:"{{ route('dashboard.setting.destroy') }}",
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
