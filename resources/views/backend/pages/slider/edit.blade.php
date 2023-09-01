@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add Slider</h4>

                    @if($errors)
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif

                    @if(session()->get('success'))
                        <div class="alert alert-success">{{ session()->get('success') }}</div>
                    @endif

                    @if(!empty($slider->id))
                        @php
                            $routeLink = route('dashboard.slider.update',$slider->id);
                        @endphp
                    @else
                        @php
                            $routeLink = route('dashboard.slider.store');
                        @endphp
                    @endif
                    <form action="{{ $routeLink }}" method="POST" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        @if(!empty($slider->id))
                            @method('PUT')
                        @endif

                        <div class="form-group">
                            <div class="input-group col-xs-12">
                                <img src="{{ asset($slider->image ?? '') }}" alt="{{ $slider->name ?? '' }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>File upload</label>
                            <input type="file" name="image" class="file-upload-default">
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled placeholder="{{ $slider->image ?? 'Upload Image' }}">
                                <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $slider->name ?? '' }}" placeholder="Title">
                        </div>
                        <div class="form-group">
                            <label for="catchword">CatchWord</label>
                            <textarea class="form-control" name="content" id="catchword" cols="30" rows="1" placeholder="Catchword">{!! $slider->content ?? '' !!}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="link">Link</label>
                            <input type="text" class="form-control" id="link" name="link" value="{{ $slider->link ?? '' }}" placeholder="Link">
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            @php
                            $status = $slider->status ?? '';
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
