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

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-title-w-btn">
                    <h3 class="title">{{ $title ?? 'Page' }}</h3>
                    <p><a class="btn btn-danger icon-btn" href=" {{ route('page.index') }}"><i class="fa fa-reply me-2"></i> Back to page
                        </a></p>
                </div>
                <div class="tile-body">
                    <form action="{{ route('page.update', $page->id) }}" method="POST" class="form-horizontal">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Page Title <strong class="text-danger">*</strong></label>
                                    <input class="form-control" type="text" id="title" name="title"
                                        value="{{ $page->title ?? old('title') }}">
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Page Slug <strong class="text-danger">*</strong></label>
                                    <input class="form-control" type="text" id="slug" name="slug"
                                        value="{{ $page->slug ?? old('slug') }}">
                                    @error('slug')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Page Description <strong class="text-danger">*</strong></label>
                            <textarea class="form-control" id="description" name="description" rows="4">{!! $page->content ?? old('description') !!}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">Published </label>
                            <div class="toggle lg">
                                <label>
                                    <input type="checkbox" name="status" @checked($page->status == true)><span
                                        class="button-indecator"></span>
                                </label>
                            </div>
                        </div>
                        <div class="tile-footer">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-save me-2"></i> Update</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('library-css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.css" rel="stylesheet">
@endpush
@push('custom-css')
@endpush

@push('library-js')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.js"></script>
@endpush


@push('custom-js')
    <script>
        $(document).ready(function() {
            $('#description').summernote({
                height: 300
            });

            /* slug */
            $("#title").on("keyup", function() {
                var Text = $(this).val();
                Text = Text.toLowerCase();
                Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
                $("#slug").val(Text);
            })
        });
    </script>
@endpush
