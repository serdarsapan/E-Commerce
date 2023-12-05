@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Order</h4>

                    @if($errors)
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif

                    @if(session()->get('success'))
                        <div class="alert alert-success">{{ session()->get('success') }}</div>
                    @endif

                    @if(!empty($order->id))
                        @php
                            $routeLink = route('dashboard.order.update',$order->id);
                        @endphp
                    @else
                        @php
                        $routeLink = route('dashboard.order.store');
                        @endphp
                    @endif
                    <form action="{{ $routeLink }}" method="POST" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        @if(!empty($invoice->id))
                            @method('GET')
                        @endif

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $invoice->name ?? '' }}" placeholder="QTY">
                        </div>
                        <div class="form-group">
                            <label for="email">E-Mail</label>
                            <input type="text" class="form-control" id="email" name="email" value="{{ $invoice->email ?? '' }}" placeholder="QTY">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ $invoice->phone ?? '' }}" placeholder="QTY">
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" name="address" id="address" cols="30" rows="1" placeholder="Address">{!! $invoice->address ?? '' !!}</textarea>
                        </div>
                        @if(isset($order->id))
                            <div class="form-group">
                                <label for="order_no">Order No</label>
                                <input type="text" class="form-control" id="order_no" name="order_no" value="{{ $order->order_no }}" placeholder="Order No" readonly>
                            </div>
                            <div class="form-group">
                                <label for="qty">QTY</label>
                                <input type="text" class="form-control" id="qty" name="qty" value="{{ $order->qty }}" placeholder="QTY" readonly>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="status">Status</label>
                            @php
                            $status = $invoice->status ?? '';
                            @endphp
                            <select name="status" id="status">
                                <option value="1" {{ $status == '1' ? 'selected' : '' }}>In Progress</option>
                                <option value="0" {{ $status == '0' ? 'selected' : '' }}>Pending</option>

                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <button class="btn btn-light">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
