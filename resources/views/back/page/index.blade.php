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
            <li class="breadcrumb-item active"><a href="{{ route('page.index') }}">{{ $title }}</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-title float-right">
                    <a href="{{ route('page.create') }}" class="btn btn-primary">Add New {{ $title }}</a>
                </div>
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Page Title</th>
                                    <th>Page Slug</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pages as $key=>$page)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $page->title }}</td>
                                        <td>{{ $page->slug }}</td>
                                        <td>
                                            @if ($page->status == true)
                                                <span class="badge badge-success">Published</span>
                                            @else
                                                <span class="badge badge-danger">Draft</span>
                                            @endif
                                        </td>
                                        <td width="20%">
                                            @can('page_index')
                                                <a href="{{ route('page.show', $page->id) }}" class="btn btn-info btn-sm">
                                                    <i><i class="fa fa-eye"></i>
                                                </a>
                                            @endcan
                                            @can('page_edit')
                                                <a href="{{ route('page.edit', $page->id) }}" class="btn btn-success btn-sm">
                                                    <i><i class="fa fa-pencil"></i>
                                                </a>
                                            @endcan
                                            @can('page_delete')
                                                <form action="{{ route('page.destroy', $page->id) }}" method="post"
                                                    style="display: inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure to delete?')"><i
                                                            class="fa fa-trash"></i></button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                @endforelse

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
    <script type="text/javascript">
        $('#sampleTable').DataTable();
    </script>
@endpush

@push('custom-js')
@endpush
