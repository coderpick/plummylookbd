@extends('layouts.backend.master')

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-th-list"></i> Edit {{ $title }}</h1>
            <p>Save {{ $title }} Easily</p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="#">Add {{ $title }}</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="tile">
                <h3 class="tile-title">{{ $title }} Form</h3>
                <div class="tile-body">
                    <form class="row" action="{{ route('sub-category.update',$subcategories->slug) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')

                        <!--category dropdown-->
                        <div class="form-group col-md-8">
                            <label class="control-label">Category</label>
                            <select class="select2 form-control chosen-select-no-single @error('category_id') is-invalid @enderror" type="text" name="category_id" >
                            <option label="">Select A Category</option>
                            @foreach($categories as $category)
                                <option @if(isset($subcategories->category_id))@if($subcategories->category_id==$category->id){{ "selected" }}@endif @endif value="{{$category->id}}">{{ucfirst($category->name)}}</option>
                            @endforeach
                            </select>
                            @error('category_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                            <!--subcategory name-->
                            <div class="form-group col-md-8">
                                <label class="control-label">Sub-Category Name</label>
                                <input required autocomplete="off" class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="@if(isset($subcategories->name)){{ $subcategories->name }}@else{{ old('name') }}@endif" placeholder="Enter category name">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>

                        <div class="form-group col-md-8">
                            <label class="control-label">Icon</label>
                            <input type="file" name="icon" id="input-file-max-fs" class="dropify @error('icon') is-invalid @enderror" data-default-file="{{ isset($subcategories)?asset($subcategories->icon):null }}" data-max-file-size="1M">
                            @error('icon')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-4 align-self-end">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('library-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('backend/dropify/css/dropify.min.css')}}">
@endpush

@push('custom-css')
@endpush

@push('library-js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="{{asset('backend/dropify/js/dropify.min.js')}}"></script>
@endpush

@push('custom-js')
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
        $(document).ready(function(){
            // Basic
            $('.dropify').dropify();
        });
    </script>
@endpush
