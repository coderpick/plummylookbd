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
                <div class="tile-title-w-btn border-bottom pb-2">
                    <h3 class="title">{{ $title ?? 'Page' }}</h3>
                    <p><a class="btn btn-danger icon-btn" href=" {{ route('page.index') }}"><i class="fa fa-reply me-2"></i>
                            Back to page
                        </a></p>
                </div>
                <div class="tile-body">
                    <h2>{{ $page->title }}</h2>
                    <p>{!! $page->content !!}</p>
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
