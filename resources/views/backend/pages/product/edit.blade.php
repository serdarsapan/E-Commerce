@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add Product</h4>

                    @if($errors)
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif

                    @if(session()->get('success'))
                        <div class="alert alert-success">{{ session()->get('success') }}</div>
                    @endif

                    @if(!empty($products->id))
                        @php
                            $routeLink = route('dashboard.product.update',$products->id);
                        @endphp
                    @else
                        @php
                            $routeLink = route('dashboard.product.store');
                        @endphp
                    @endif
                    <form action="{{ $routeLink }}" method="POST" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        @if(!empty($products->id))
                            @method('PUT')
                        @endif

                        <div class="form-group">
                            <div class="input-group col-xs-12">
                                <img src="{{ asset($product->image ?? '') }}" alt="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>File upload</label>
                            <input type="file" name="image" class="file-upload-default">
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled placeholder="{{ $product->image ?? 'Upload Image' }}">
                                <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $products->name ?? '' }}" placeholder="Title">
                        </div>
                        <div class="form-group">
                            <label for="name">Category</label>
                            <select name="parent" id="" class="form-control">
                                @if($categories)
                                    @foreach($categories as $child)
                                        <option value="{{ $child->id }}" {{ isset($category) && $products->category_id == $child->id ? 'selected' : '' }}>{{ $child->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea class="form-control" name="content" id="content" cols="30" rows="1" placeholder="Content">{{ $products->content ?? '' }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="short_text">Short Text</label>
                            <input type="text" class="form-control" id="short_text" name="short_text" value="{{ $products->short_text ?? '' }}" placeholder="Short Text">
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="text" class="form-control" id="price" name="price" value="{{ $products->price ?? '' }}" placeholder="Price">
                        </div>
                        <div class="form-group">
                            <label for="size">Size</label>

                            <select name="size" id="" class="form-control">
                                <option value="medium" {{ isset($products->size) && $products->size == "medium" ? 'selected' : '' }}>Medium</option>
                                <option value="large" {{ isset($products->size) && $products->size == "large" ? 'selected' : '' }}>Large</option>
                                <option value="x-large" {{ isset($products->size) && $products->size == "x-large" ? 'selected' : '' }}>X-Large</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="color">Color</label>
                            <input type="text" class="form-control" id="color" name="color" value="{{ $products->color ?? '' }}" placeholder="Color">
                        </div>
                        <div class="form-group">
                            <label for="qty">Quantity</label>
                            <input type="text" class="form-control" id="qty" name="qty" value="{{ $products->qty ?? '' }}" placeholder="Quantity">
                        </div>

{{--                        <div class="form-group">--}}
{{--                            <label for="category_id">Category</label>--}}
{{--                            <select name="category_id" id="" class="form-control">--}}
{{--                                @if($products)--}}
{{--                                    @foreach($products as $product)--}}
{{--                                        <option value="{{ $item->id }}" {{ isset($product) && $products->category_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>--}}
{{--                                    @endforeach--}}
{{--                                @endif--}}
{{--                            </select>--}}
{{--                        </div>--}}

                        <div class="form-group">
                            <label for="status">Status</label>
                            @php
                            $status = $product->status ?? '';
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
