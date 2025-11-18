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
                    <form action="{{ route('post.update',$post->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="post_title">Title <strong class="text-danger">*</strong></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                           id="title" name="title" value="{{ $post->title??old('title') }}"
                                           placeholder="Enter title" required />
                                    @error('title')
                                    <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="post_title">Slug <strong class="text-danger">*</strong></label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                           id="slug" name="slug" value="{{ $post->slug??old('slug') }}"
                                           placeholder="Enter slug" required />
                                    @error('slug')
                                    <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="short_description">Short Description <strong class="text-danger">*</strong></label>
                                    <textarea name="short_description" class="form-control @error('short_description') is-invalid @enderror" id="short_description" rows="3" required>{{ $post->short_description??old('short_description') }}</textarea>
                                    @error('short_description')
                                    <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="description">Description <strong class="text-danger">*</strong></label>
                                    <textarea name="description" id="description" rows="10" class="form-control editor" required>{{ $post->body??old('description') }}</textarea>
                                    @error('description')
                                    <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>

                                <h5 class="text-primary text-center mt-5">Meta Information</h5>
                                <div class="form-group">
                                    <input class="form-control @error('meta_title') is-invalid @enderror" type="text" name="meta_title"  value="{{ $post->meta_title??old('meta_title') }}" placeholder="Meta title">
                                    @error('meta_title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="meta_keywords">Meta Keywords</label>
                                    <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror"
                                           id="meta_keywords" name="meta_keywords" value="{{ $post->meta_key??old('meta_keywords') }}"
                                           placeholder="Enter meta keywords" />
                                    @error('meta_keywords')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="meta_description">Meta Description</label>
                                    <textarea name="meta_description" id="meta_description" rows="5" class="form-control">{{ $post->meta_description??old('meta_description') }}</textarea>
                                    @error('meta_description')
                                    <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="photo">Thumbnail (1400 x 800 pixels)<strong class="text-danger">*</strong></label>
                                    <input type="file" name="photo" id="photo" data-default-file="{{ isset($post->image)? asset($post->image) :'' }}" class="form-control dropify" data-height="220" >
                                    @error('photo')
                                    <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="tags">Tag Category</label>
                                    <select name="tags[]" id="tags" class="form-control select2">
                                        @forelse($tags as $tag)
                                            <option {{ $tag->id == $post->postTags[0]->tag->id ?'selected':'' }} value="{{ $tag->id }}">{{ $tag->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-1">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('library-css')
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
    <script src="{{asset('backend/dropify/js/dropify.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.js"></script>
@endpush

@push('custom-js')
    <script>
        $(document).ready(function(){
            // Basic
            $('.dropify').dropify();
            $('.select2').select2();
            $('.editor').summernote({
                height:250
            });
        });

        $('#slug').on('keyup',function(e) {
            $( this ).val($( this ).val().replace(/\s/g, '-'));
        });
    </script>
@endpush
