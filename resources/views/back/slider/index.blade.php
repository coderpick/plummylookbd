@extends('layouts.backend.master')

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-th-list"></i> {{ $title }}</h1>
            <p>Display {{ $title }} Data Effectively</p>
        </div>


        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('slider.index') }}">{{ $title }}</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="col-md-12 row">
                    <a href="{{ route('slider.create') }}" class="btn btn-primary">Add New {{ $title }}</a>
                </div>
                <br>
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                            <tr>
                                <th width="20%">Image</th>
                                <th>Title</th>
                               {{-- <th width="20%">Text Content</th>--}}
                               {{-- <th>Button Name</th>--}}
                                <th width="20%">Slider Link</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sliders as $slider)
                            <tr>
                                    <td width="20%"><img class="img-fluid" src="{{ asset($slider->image) }}" alt="slider"></td>
                                    <td>{{ $slider->title }}</td>
                                    {{--<td width="20%" class="text-wrap">{{ $slider->text }}</td>
                                    <td>{{ $slider->btn }}</td>--}}
                                    <td width="20%" class="text-wrap">{{ $slider->link }}</td>
                                    <td>
                                        @if($slider->deleted_at == null)
                                        <span class="text-success">Active</span>
                                        @else
                                        <span class="text-danger">Inactive</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($slider->deleted_at == null)
                                            <a href="{{ route('slider.edit',$slider->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                                            <form action="{{ route('slider.destroy',$slider->id) }}" method="post" style="display: inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Are you sure to delete?')"><i class="fa fa-trash"></i></button>
                                            </form>
                                        @else
                                            <form action="{{ route('slider.restore',$slider->id) }}" method="post" style="display: inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Do you want this back?')"><i class="fa fa-undo"></i></button>
                                            </form>

                                            <form action="{{ route('slider.delete',$slider->id) }}" method="post" style="display: inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Confirm to permanently remove?')"><i class="fa fa-trash"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection




@push('library-css')

@endpush



@push('custom-css')

@endpush



@push('library-js')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
@endpush



@push('custom-js')
@endpush
