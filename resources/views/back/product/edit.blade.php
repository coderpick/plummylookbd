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
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">{{ $title }} Form</h3>
                <div class="tile-body">
                    <form class="row" action="{{ route('product.update',$product->slug) }}" method="post" enctype="multipart/form-data">
                        @method('put')

                        @include('back.product._form')

                        <div class="form-group col-md-10"></div>
                        <div class="form-group col-md-2 align-self-end">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection




@push('library-css')
    <!-- dropify CSS-->
    <link rel="stylesheet" href="{{asset('backend/dropify/css/dropify.min.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.css" rel="stylesheet">
@endpush



@push('custom-css')
    <style>
        .dropify-wrapper{
            height: 120px;
        }
    </style>
@endpush



@push('library-js')
    <!-- dropify JS-->
    <script src="{{asset('backend/dropify/js/dropify.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.js"></script>
@endpush



@push('custom-js')
    <script>
        $('#details').summernote({
            height: 200,
            minHeight: null,
            callbacks: {
                onPaste: function (e) {
                    var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                    e.preventDefault();
                    document.execCommand('insertText', false, bufferText);
                }
            }
        });
    </script>
    <script>
        $(document).ready(function(){
            // Basic
            $('.dropify').dropify();
        });

        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>

    <script type="text/javascript">
        $("#category").change(function(){
            console.log($(this).val());
            $.ajax({
                url: "{{ route('ajax.subcategory') }}?category_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    console.log(data);
                    $('#sub_category').html(data.html);
                }
            });

        });

        $(document).ready(function () {
            let isSlugEdited = false;

            // Detect manual changes to slug
            $('#slug').on('input', function () {
                isSlugEdited = true;
            });

            // Auto-generate slug unless manually changed
            $('#name').on('input', function () {
                if (!isSlugEdited) {
                    let title = $(this).val();
                    let slug = title.toLowerCase()
                        .trim()
                        .replace(/[^a-z0-9\s-]/g, '')  // Remove special chars
                        .replace(/\s+/g, '-')          // Replace spaces with -
                        .replace(/-+/g, '-');           // Collapse dashes
                    $('#slug').val(slug);
                }
            });

            $('#slug').on('keyup',function(e) {
                $( this ).val($( this ).val().replace(/\s/g, '-'));
                $( this ).val($( this ).val().replace(/[^a-zA-Z0-9]/g, '-'));
            });
        });

    </script>
@endpush
