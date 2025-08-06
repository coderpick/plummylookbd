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
            <li class="breadcrumb-item active"><a href="{{ route('category.index') }}">{{ $title }}</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="col-md-12 row">
                    <a href="{{ route('category.create') }}" class="btn btn-primary">Add New {{ $title }}</a>
                </div>
                <br>
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                            <tr>
                                <th style="display: none;">Id</th>
                                <th>Name</th>
                                <th>Icon</th>
                                <th>Banner</th>
                                <th>Status</th>
                                @if (auth()->user()->type != 'vendor')
                                <th>Home View</th>
                                <th>Concern</th>
                                <th>Actions</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td style="display: none;">{{ $category->id }}</td>
                                <td>{{ ucfirst($category->name) }}</td>
                                    <td width="10%"><img class="img-fluid" loading="lazy" src="{{ asset($category->icon) }}" alt=""></td>
                                    <td width="20%"><img class="img-fluid" loading="lazy" src="{{ asset($category->banner) }}" alt=""></td>
                                    <td>
                                        @if($category->deleted_at == null)
                                        <span class="text-success">Active</span>
                                        @else
                                        <span class="text-danger">Inactive</span>
                                        @endif
                                    </td>

                                @if (auth()->user()->type != 'vendor')
                                <td>{{ ($category->home_view == 1)?'Yes':'No' }}</td>
                                <td>{{ ($category->concern == 1)?'Yes':'No' }}</td>
                                    <td>
                                        @if($category->deleted_at == null)
                                            <a href="{{ route('category.edit',$category->slug) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                                            <form action="{{ route('category.destroy',$category->slug) }}" method="post" style="display: inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Are you sure to delete?')"><i class="fa fa-trash"></i></button>
                                            </form>
                                        @else
                                            <form action="{{ route('category.restore',$category->id) }}" method="post" style="display: inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Do you want this back?')"><i class="fa fa-undo"></i></button>
                                            </form>

                                            <form action="{{ route('category.delete',$category->id) }}" method="post" style="display: inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Confirm to permanently remove?')"><i class="fa fa-trash"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                @endif
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
    <script type="text/javascript">$('#sampleTable').DataTable({ order: [ [0, 'desc'] ]});</script>
@endpush

@push('custom-js')
    <script type="text/javascript">
    </script>
@endpush
