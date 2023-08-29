@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Basic Table</h4>
                    <p class="card-description">
                        <a href="{{ route('dashboard.slider.create') }}" class="btn btn-github">Add Table</a>
                    </p>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Catchword</th>
                                <th>Link</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($sliders) && $sliders->count() > 0)
                                @foreach($sliders as $slider)
                                    <tr>
                                        <td><img src="{{ $slider->image }}" alt="image"></td>
                                        <td>{{ $slider->name }}</td>
                                        <td>{{ $slider->content ?? '' }}</td>
                                        <td>{{ $slider->link }}</td>
                                        <td><label class="badge badge-{{ $slider->status == '1' ? 'success' : 'danger' }}">{{ $slider->status == '1' ? 'In Progress' : 'Pending' }}</label></td>
                                        <td><a href="{{ route('dashboard.slider.edit', $slider->id) }}" class="btn btn-primary">Edit</a></td>
                                        <td><form action="{{ route('dashboard.slider.destroy', $slider->id) }}" method="POST">
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form></td>
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
