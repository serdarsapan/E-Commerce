@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Settings</h4>

                    @if($errors)
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif

                    @if(session()->get('success'))
                        <div class="alert alert-success">{{ session()->get('success') }}</div>
                    @endif

                    @if(!empty($setting->id))
                        @php
                            $routeLink = route('dashboard.setting.update',$setting->id);
                        @endphp
                    @else
                        @php
                            $routeLink = route('dashboard.setting.store');
                        @endphp
                    @endif
                    <form action="{{ $routeLink }}" method="POST" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        @if(!empty($setting->id))
                            @method('PUT')
                        @endif

{{--                        <div class="form-group">--}}
{{--                            <div class="input-group col-xs-12">--}}
{{--                                <img src="{{ asset($setting->data ?? '') }}" alt="{{ $setting->name ?? '' }}">--}}

{{--                                @if(isset($setting->type) && $setting->type == 'image')--}}
{{--                                    <img src="{{ asset($setting->image) }}" alt="image"/>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group">--}}
{{--                            <label>File upload</label>--}}
{{--                            <input type="file" name="image" class="file-upload-default">--}}
{{--                            <div class="input-group col-xs-12">--}}
{{--                                <input type="text" class="form-control file-upload-info" disabled placeholder="{{ $setting->image ?? 'Upload Image' }}">--}}
{{--                                <span class="input-group-append">--}}
{{--                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>--}}
{{--                        </span>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <div class="form-group">
                            <label for="name">Key</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $setting->name ?? '' }}" placeholder="Title">
                        </div>
                        <div class="form-group">
                            <label for="data">Value</label>
                            <textarea class="form-control" name="data" id="data" cols="30" rows="1" placeholder="Value">{!! $setting->data ?? '' !!}</textarea>
                        </div>
                        <div class="form-group">
                        <select name="type" id="typeSelect">
                            <option value="ckeditor" {{ isset($setting->type) && $setting->type == 'ckEditor' ? 'selected' : '' }}>ckEditor</option>
                            <option value="file" {{ isset($setting->type) && $setting->type == 'file' ? 'selected' : '' }}>File</option>
                            <option value="text" {{ isset($setting->type) && $setting->type == 'text' ? 'selected' : '' }}>Text</option>
                            <option value="textarea" {{ isset($setting->type) && $setting->type == 'textarea' ? 'selected' : '' }}>TextArea</option>
                            <option value="email" {{ isset($setting->type) && $setting->type == 'email' ? 'selected' : '' }}>Email</option>
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
@section('customjs')
    $
@endsection
