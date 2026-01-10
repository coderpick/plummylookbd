@extends('layouts.backend.master')

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-th-list"></i> Edit {{ $title }}</h1>
            <p>Edit {{ $title }} Easily</p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="#">Edit {{ $title }}</a></li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="tile">
                <h3 class="tile-title">{{ $title }} Form</h3>
                <div class="tile-body">
                    <form action="{{ route('brand.update', $brand->slug) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label class="control-label">Brand Name</label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
                                value="{{ isset($brand) ? $brand->name : null }}" placeholder="Enter brand name">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label">Icon</label>
                            <input type="file" name="icon" id="input-file-max-fs"
                                class="dropify @error('icon') is-invalid @enderror"
                                data-default-file="{{ isset($brand) ? asset($brand->icon) : null }}"
                                data-max-file-size="1M">
                            @error('icon')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">Published To Website</label>
                            <div class="toggle lg">
                                <label>
                                    <input type="checkbox" @checked($brand->published_to_web == true) name="published_to_web"><span
                                        class="button-indecator"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button class="btn btn-primary" type="submit"><i
                                    class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('library-css')
    <!-- dropify CSS-->
    <link rel="stylesheet" href="{{ asset('backend/dropify/css/dropify.min.css') }}">
@endpush



@push('custom-css')
    <style>
        .dropify-wrapper {
            height: 120px;
        }
    </style>
@endpush



@push('library-js')
    <!-- dropify JS-->
    <script src="{{ asset('backend/dropify/js/dropify.min.js') }}"></script>
@endpush



@push('custom-js')
    <script>
        $(document).ready(function() {
            // Basic
            $('.dropify').dropify();
        });
    </script>
@endpush
