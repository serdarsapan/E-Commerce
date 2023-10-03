@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add Category</h4>

                    @if($errors)
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif

                    @if(session()->get('success'))
                        <div class="alert alert-success">{{ session()->get('success') }}</div>
                    @endif

                    @if(!empty($category->id))
                        @php
                            $routeLink = route('dashboard.category.update',$category->id);
                        @endphp
                    @else
                        @php
                            $routeLink = route('dashboard.category.store');
                        @endphp
                    @endif
                    <form action="{{ $routeLink }}" method="POST" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        @if(!empty($category->id))
                            @method('PUT')
                        @endif

                        <div class="form-group">
                            <div class="input-group col-xs-12">
                                <img src="{{ asset($category->image ?? '') }}" alt="{{ $category->name ?? '' }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>File upload</label>
                            <input type="file" name="image" class="file-upload-default">
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled placeholder="{{ $category->image ?? 'Upload Image' }}">
                                <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $category->name ?? '' }}" placeholder="Title">
                        </div>
                        <div class="form-group">
                            <label for="catchword">Content</label>
                            <textarea class="form-control" name="content" id="content" cols="30" rows="1" placeholder="Content">{!! $category->content ?? '' !!}</textarea>
                        </div>
{{--                        <div class="form-group">--}}
{{--                            <label for="link">Link</label>--}}
{{--                            <input type="text" class="form-control" id="link" name="link" value="{{ $category->link ?? '' }}" placeholder="Link">--}}
{{--                        </div>--}}
                        <div class="form-group">
                            <label for="name">Type</label>
                            <select name="parent" id="" class="form-control">
                                @if($categories)
                                    @foreach($categories as $child)
                                        <option value="{{ $child->id }}" {{ isset($category) && $category->parent == $child->id ? 'selected' : '' }}>{{ $child->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            @php
                            $status = $category->status ?? '';
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
