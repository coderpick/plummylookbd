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
            <li class="breadcrumb-item active"><a href="{{ route('brand.index') }}">{{ $title }}</a></li>
        </ul>
    </div>

    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="col-md-12 row">
                        <a data-toggle="modal"
                           data-target="#productAddModal" class="btn btn-primary text-white">Add New {{ $title }}</a>
                    </div>
                    <br>
                    <div class="tile-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered" id="sampleTable">
                                <thead>
                                <tr>
                                    <th style="display: none;">Id</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tags as $tag)
                                    <tr>
                                        <td style="display: none;">{{ $tag->id }}</td>
                                        <td>{{ ucfirst($tag->name) }}</td>
                                        <td>{{ $tag->slug }}</td>
                                        <td>
                                            <a id="{{ $tag->id }}" href="#" data-toggle="modal"
                                               data-target="#edit-product" class="btn btn-sm btn-info edit"><i class="fa fa-edit"></i></a>
                                            <form action="{{ route('tag.destroy',$tag->id) }}" method="post" style="display: inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Are you sure to delete?')"><i class="fa fa-trash"></i></button>
                                            </form>
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
    </div>

    <div id="productAddModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Tag</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form  action="{{ route('tag.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="tag">Tag <strong class="text-danger">*</strong></label>
                            <input  name="tag_name" value="{{ old('tag_name') }}"
                                    class="form-control" placeholder="Tag Name" id="tag" type="text" required>
                            @error('tag_name')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="edit-product" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Tag</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-material m-t-40" action="{{ route('tag.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="tag_name">Tag Name:<strong class="text-danger">*</strong></label>
                            <input value="{{ old('tag_name') }}" name="tag_name" id="tag_name"
                                   class="form-control form-control-line" placeholder="Tag Name" type="text" required>
                            @error('tag_name')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <input type="hidden" name="tag_id" id="tag_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
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
        $(document).on('click', '.edit', function() {
            var tag_id = $(this).attr('id');
            var body = $(".body");
            $.ajax({
                type: 'GET',
                url: "{{ route('tag.edit') }}",
                data: {
                    'id': tag_id
                },
                success: function(data) {
                    $('#tag_name').empty();
                    $('#tag_name').val(data.name);
                    $('#tag_id').empty();
                    $('#tag_id').val(data.id);
                }
            });
        });
    </script>
@endpush
