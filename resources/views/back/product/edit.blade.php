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
                <div class="tile-title-w-btn">
                    <h3 class="tile-title">{{ $title }} Form</h3>
                    <p>
                        <a class="btn btn-danger icon-btn" href=" {{ route('product.index') }}"><i
                                class="fa fa-reply me-2"></i> Back to product
                        </a>
                    </p>
                </div>
                <div class="tile-body">
                    <form action="{{ route('product.update', $product->slug) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @include('back.product._form')

                        <div class="form-group text-center border-top pt-3">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-fw fa-lg fa-check-circle"></i>Update Product</button>
                        </div>
                    </form>
                    {{-- tags --}}                   
                    @php
                        $tagsArray = $productTags->count() > 0 ? $productTags->pluck('name')->toArray() : [];
                    @endphp
                </div>
            </div>
        </div>
    </div>
@endsection




@push('library-css')
    <!-- dropify CSS-->
    <link rel="stylesheet" href="{{ asset('backend/dropify/css/dropify.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
@endpush



@push('custom-css')
    <style>
        .dropify-wrapper {
            height: 120px;
        }

        .tags-look .tagify__dropdown__item {
            display: inline-block;
            vertical-align: middle;
            border-radius: 3px;
            padding: .3em .5em;
            border: 1px solid #CCC;
            background: #F3F3F3;
            margin: .2em;
            font-size: .85em;
            color: black;
            transition: 0s;
        }

        .tags-look .tagify__dropdown__item--active {
            border-color: black;
        }

        .tags-look .tagify__dropdown__item:hover {
            background: lightyellow;
            border-color: gold;
        }

        .tags-look .tagify__dropdown__item--hidden {
            max-width: 0;
            max-height: initial;
            padding: .3em 0;
            margin: .2em 0;
            white-space: nowrap;
            text-indent: -20px;
            border: 0;
        }
    </style>
@endpush



@push('library-js')
    <!-- dropify JS-->
    <script src="{{ asset('backend/dropify/js/dropify.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
@endpush



@push('custom-js')
    <script>
        $('#details').summernote({
            height: 200,
            minHeight: null,
            callbacks: {
                onPaste: function(e) {
                    var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData(
                        'Text');
                    e.preventDefault();
                    document.execCommand('insertText', false, bufferText);
                }
            }
        });

        /* Tagify js active */
        var input = document.querySelector('input[name="input-custom-dropdown"]'),
            // init Tagify script on the above inputs
            tagify = new Tagify(input, {
                whitelist: @json($tagsArray),
                maxTags: 10,
                dropdown: {
                    maxItems: 200, // <- mixumum allowed rendered suggestions
                    classname: 'tags-look', // <- custom classname for this dropdown, so it could be targeted
                    enabled: 0, // <- show suggestions on focus
                    closeOnSelect: false // <- do not hide the suggestions dropdown once an item has been selected
                }
            })

        $(document).ready(function() {
            $('.dropify').dropify();
            $('.select2').select2();
        });

        $("#category").change(function() {
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


        let isSlugEdited = false;

        // Detect manual changes to slug
        $('#slug').on('input', function() {
            isSlugEdited = true;
        });

        // Auto-generate slug unless manually changed
        $('#name').on('input', function() {
            if (!isSlugEdited) {
                let title = $(this).val();
                let slug = title.toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9\s-]/g, '') // Remove special chars
                    .replace(/\s+/g, '-') // Replace spaces with -
                    .replace(/-+/g, '-'); // Collapse dashes
                $('#slug').val(slug);
            }
        });

        $('#slug').on('keyup', function(e) {
            $(this).val($(this).val().replace(/\s/g, '-'));
            $(this).val($(this).val().replace(/[^a-zA-Z0-9]/g, '-'));
        });
    </script>
@endpush
