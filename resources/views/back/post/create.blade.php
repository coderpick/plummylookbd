@extends('layouts.backend.master')

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-th-list"></i> Add New {{ $title }}</h1>
            <p>Save New {{ $title }} Easily</p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="#">Add {{ $title }}</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="d-flex justify-content-between">
                    <div>
                        <h3 class="tile-title">{{ $title }} Form</h3>
                    </div>
                    <div>
                        <a class="btn btn-danger icon-btn" href=" {{ route('post.index') }}"><i
                                class="fa fa-reply me-2"></i>
                            Back to Posts
                        </a>
                    </div>
                </div>
                <div class="tile-body">
                    <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="post_title">Post Title <strong class="text-danger">*</strong></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        id="title" name="title" value="{{ old('title') }}" placeholder="Enter title"
                                        required />
                                    @error('title')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="slug">Slug <strong class="text-danger">*</strong></label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                        id="slug" name="slug" value="{{ old('slug') }}" placeholder="Enter slug"
                                        required />
                                    @error('slug')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="short_description">Short Description <strong
                                            class="text-danger">*</strong></label>
                                    <textarea name="short_description" class="form-control @error('short_description') is-invalid @enderror"
                                        id="short_description" rows="3" required></textarea>
                                    @error('short_description')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="description">Post Description <strong class="text-danger">*</strong></label>
                                    <textarea name="description" id="description" rows="10" class="form-control editor" required>{{ old('description') }}</textarea>
                                    @error('description')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>


                                <h5 class="text-primary text-center mt-5">Meta Information</h5>
                                <div class="form-group">
                                    <input class="form-control @error('meta_title') is-invalid @enderror" type="text"
                                        name="meta_title" value="{{ old('meta_title') }}" placeholder="Meta title">
                                    @error('meta_title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="meta_keywords">Meta Keywords</label>
                                    <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror"
                                        id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords') }}"
                                        placeholder="Enter meta keywords" />
                                    @error('meta_keywords')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="meta_description">Meta Description</label>
                                    <textarea name="meta_description" id="meta_description" rows="5" class="form-control">{{ old('meta_description') }}</textarea>
                                    @error('meta_description')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="photo">Thumbnail (1400 x 800 pixels)<strong
                                            class="text-danger">*</strong></label>
                                    <input type="file" name="photo" id="photo" class="form-control dropify"
                                        data-height="220" required>
                                    @error('photo')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <select name="category" id="category" class="form-control select2" required>
                                        <option value="" selected disabled>Select a category</option>
                                        @forelse($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @error('category')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="tags" class="form-label d-block">Post Tags</label>
                                    <input name='tags' class='tagify--custom-dropdown w-100' id="tags"
                                        placeholder='Type an English letter'>
                                    @error('tags')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-1">
                                <button class="btn btn-primary" type="submit"><i
                                        class="fa fa-fw fa-lg fa-check-circle"></i>Save</button>
                            </div>
                        </div>
                    </form>
                    {{-- tags --}}
                    @php
                        $tagsArray = $postTags->count() > 0 ? $postTags->pluck('name')->toArray() : [];
                    @endphp
                </div>
            </div>
        </div>
    </div>
@endsection

@push('library-css')
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
    <script src="{{ asset('backend/dropify/js/dropify.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
@endpush

@push('custom-js')
    <script>
        $(document).ready(function() {
            $('.dropify').dropify();
            $('.select2').select2();
            $('.editor').summernote({
                height: 250
            });
        });

        /* slug generator */
        function slugify(text) {
            return text
                .toString()
                .toLowerCase()
                .replace(/\s+/g, "-") // Replace spaces with -
                .replace(/\-\-+/g, "-") // Replace multiple - with single -
                .replace(/^-+/, "") // Trim - from start of text
                .replace(/-+$/, ""); // Trim - from end of text
        }

        $("#title").on("keyup", function() {
            let Text = $(this).val();
            Text = slugify(Text);
            $("#slug").val(Text);
        })

        /* Tagify js active */
        var input = document.querySelector('input[name=tags]');
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
    </script>
@endpush
