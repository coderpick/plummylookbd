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
            <li class="breadcrumb-item active"><a href="{{ route('concern.index') }}">{{ $title }}</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="col-md-12 row">
                    <a href="{{ route('post.create') }}" class="btn btn-primary">Add New {{ $title }}</a>
                </div>
                <br>
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                            <tr role="row">
                                <th style="display: none">ID</th>
                                <th>S/N</th>
                                <th>Thumbnail</th>
                                <th>Title</th>
                                <th>Tag Category</th>
                                <th>Author</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($posts as $key=>$post)
                                <tr>
                                    <td style="display: none">{{ $post->id }}</td>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <img style="max-width: 100px" src="{{ asset($post->image) }}" alt="thumbnail">
                                    </td>
                                    <td>{{ Str::limit($post->title,30) }}</td>
                                    <td>
                                        {{ $post->postTags[0]->tag->name??"" }}
                                    </td>
                                    <td>{{ $post->user->name??'' }}</td>
                                    <td>
                                        @if ($post->deleted_at == null)
                                            <span class="badge bg-success">Published</span>
                                        @else
                                            <span class="badge bg-danger">Drafted</span>
                                        @endif
                                    </td>
                                    <td style="text-align: center">
                                        @if($post->deleted_at)
                                            @can('app.post.destroy')
                                                <a href="{{ route('post.restore', $post->id) }}"
                                                   class="btn btn-primary btn-sm"><i class="fa fa-recycle"></i>
                                                </a>

                                                <form id="delete-form-{{ $post->id }}" action="{{ route('post.destroy', $post->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button  type="submit" onclick="return confirm('Are you sure to permanently delete?')" class="btn btn-danger btn-sm">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        @else
                                            @can('app.post.index')
                                                <a href="{{ route('post.show', $post->id) }}"
                                                   class="btn btn-info btn-sm"><i class="fa fa-eye"></i>
                                                </a>
                                            @endcan

                                            @can('app.post.edit')
                                                <a href="{{ route('post.edit', $post->id) }}" class="btn btn-primary btn-sm" ><i class="fa fa-pencil"></i></a>
                                            @endcan

                                            @can('app.post.destroy')
                                                <form id="trash-form-{{ $post->id }}"
                                                      action="{{ route('post.trash', $post->id) }}" method="POST"
                                                      style="display: inline;">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Are you sure to delete?')"><i class="fa fa-trash-o"></i></button>
                                                </form>
                                            @endcan

                                        @endif
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
    <script type="text/javascript">$('#sampleTable').DataTable({ order: [ [0, 'desc'] ]});</script>
@endpush

@push('custom-js')
@endpush
