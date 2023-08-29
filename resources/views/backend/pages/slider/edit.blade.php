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
                            $routeLink = route('dashboard.slider.edit',$slider->id);
                        @endphp
                    @else
                        @php
                            $routeLink = route('dashboard.slider.store');
                        @endphp
                    @endif
                    <form method="POST" action="{{ $routeLink }}" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        @if(!empty($slider->id))
                            @method('PUT')
                        @endif
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $slider->name ?? '' }}" placeholder="Title">
                        </div>
                        <div class="form-group">
                            <label for="catchword">CatchWord</label>
                            <input type="text" class="form-control" id="content" name="content" value="{{ $slider->content ?? '' }}" placeholder="Catchword">
                        </div>
                        <div class="form-group">
                            <label for="link">Link</label>
                            <input type="text" class="form-control" id="link" name="link" value="{{ $slider->link ?? '' }}" placeholder="Link">
                        </div>

                        <div class="form-group">
                            <label>File upload</label>
                            <input type="file" name="image" class="file-upload-default">
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                                <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            @php
                            $status = $slider->status ?? '';
                            @endphp
                            <select name="status" id="status">
                                <option value="0" {{ $status == '0' ? 'selected' : '' }}>Pending</option>
                                <option value="1" {{ $status == '1' ? 'selected' : '' }}>In Progress</option>
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
