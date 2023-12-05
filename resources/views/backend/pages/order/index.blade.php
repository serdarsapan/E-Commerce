@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Order</h4>
                    <p class="card-description">
                    </p>

                    @if(session()->get('success'))
                        <div class="alert alert-success">{{ session()->get('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>E-mail</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Order No</th>
                                <th>QTY</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($invoices) && $invoices->count() > 0 && !empty($orders) && $orders->count() > 0)
                                @foreach($invoices as $invoice)
                                    <tr class="item" itemid="{{$invoice->id}}">
                                        <td>{{ $invoice->name }}</td>
                                        <td>{{ $invoice->email ?? '' }}</td>
                                        <td>{{ $invoice->phone}}</td>
                                        <td>{!! strLimit($invoice->address,150,route('dashboard.order.edit', $invoice->id)) !!}</td>
                                        <td>
                                            <div class="checkbox">
                                                <label>
                                            <input type="checkbox" class="case" data-on="In Progress" data-off="Pending" data-onstyle="success" data-offstyle="danger" {{ $invoice->status == '1' ? 'checked' : '' }} data-toggle="toggle">
                                                </label>
                                            </div>
                                        </td>
                                        <td>{{ $invoice->order_no }}</td>
                                        <td>{{ $invoice->orders_count }}</td>
                                        <td><a href="{{ route('dashboard.order.edit', $invoice->id) }}" class="btn btn-primary">Edit</a></td>
                                        <td>
                                            <button type="submit" class="btn delBtn btn-danger">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            {{ $orders->links('pagination::bootstrap-4') }}
                        </div>
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
                url:"{{ route('dashboard.order.status') }}",
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
                        url:"{{ route('dashboard.order.destroy') }}",
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
