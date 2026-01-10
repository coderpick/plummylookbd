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
                    <div class="row col-md-12 justify-content-end">
                        <a data-toggle="modal" data-target="#productAddModal" class="btn btn-primary text-white">Add New
                            {{ $title }}</a>
                    </div>
                    <br>
                    <div class="tile-body">
                        <table class="table table-hover table-bordered table-sm" id="sampleTable">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $key => $category)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ ucfirst($category->name) }}</td>
                                        <td>{{ $category->slug }}</td>
                                        <td>
                                            <a id="{{ $category->id }}" href="#" data-toggle="modal"
                                                data-target="#edit-product" class="btn btn-sm btn-info edit"><i
                                                    class="fa fa-edit"></i></a>
                                            <form action="{{ route('blog_category.destroy', $category->id) }}"
                                                method="post" style="display: inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-warning"
                                                    onclick="return confirm('Are you sure to delete?')"><i
                                                        class="fa fa-trash"></i></button>
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

    <div id="productAddModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('blog_category.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="category">Category Name <strong class="text-danger">*</strong></label>
                            <input name="category_name" value="{{ old('category_name') }}" class="form-control"
                                placeholder="Category Name" id="category" type="text" required>
                            @error('category_name')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-material m-t-40" action="{{ route('blog_category.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="category_name">Category Name:<strong class="text-danger">*</strong></label>
                            <input value="{{ old('category_name') }}" name="category_name" id="category_name"
                                class="form-control form-control-line" type="text" required>
                            @error('category_name')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <input type="hidden" name="category_id" id="category_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
    <script type="text/javascript">
        $('#sampleTable').DataTable();
    </script>
@endpush

@push('custom-js')
    <script type="text/javascript">
        $(document).on('click', '.edit', function() {
            let categoryId = $(this).attr('id');
            var body = $(".body");
            $.ajax({
                type: 'GET',
                url: "{{ route('blog_category.edit') }}",
                data: {
                    'id': categoryId
                },
                success: function(data) {
                    $('#category_name').empty();
                    $('#category_name').val(data.name);
                    $('#category_id').empty();
                    $('#category_id').val(data.id);
                }
            });
        });
    </script>
@endpush
