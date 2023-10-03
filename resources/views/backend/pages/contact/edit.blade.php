@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add Contact</h4>

                    @if($errors)
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif

                    @if(session()->get('success'))
                        <div class="alert alert-success">{{ session()->get('success') }}</div>
                    @endif

                    @if(!empty($contact->id))
                        @php
                            $routeLink = route('dashboard.contact.update',$contact->id);
                        @endphp
                    @else
                        @php
                            $routeLink = route('dashboard.contact.store');
                        @endphp
                    @endif
                    <form action="{{ $routeLink }}" method="POST" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        @if(!empty($contact->id))
                            @method('GET')
                        @endif

                        <div class="form-group">
                            <label for="name">Title</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $contact->name ?? '' }}" placeholder="Title">
                        </div>
                        <div class="form-group">
                            <label for="email">E-Mail</label>
                            <input type="text" class="form-control" id="email" name="email" value="{{ $contact->email ?? '' }}" placeholder="Title">
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" value="{{ $contact->subject ?? '' }}" placeholder="Title">
                        </div>
                        <div class="form-group">
                            <label for="message">Content</label>
                            <textarea class="form-control" name="message" id="message" cols="30" rows="1" placeholder="Message">{!! $contact->message ?? '' !!}</textarea>
                        </div>
{{--                        <div class="form-group">--}}
{{--                            <label for="link">Link</label>--}}
{{--                            <input type="text" class="form-control" id="link" name="link" value="{{ $contact->link ?? '' }}" placeholder="Link">--}}
{{--                        </div>--}}

                        <div class="form-group">
                            <label for="status">Status</label>
                            @php
                            $status = $contact->status ?? '';
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
