@extends('layouts.backend.master')
@section('content')
    <!--title-->
    <div class="app-title">
        <div>
            <h1><i class="fa fa-th-list"></i> Banner Content</h1>
            <p>Display Banner Content Data Effectively</p>
        </div>

        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="#">Banner Content</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Information') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{route('banner.update')}}" enctype="multipart/form-data" >
                    @method('PATCH')
                    @csrf
                        <!--logo-->
                        <div class="form-group row">
                            <label for="logo" class="col-md-4 col-form-label text-md-right">{{ __('Flash Sale Banner') }} <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input required type="file" id="input-file-now-custom-1" name="site_flash_sale_img" class="dropify @error('site_flash_sale_img') is-invalid @enderror" data-default-file="{{ setting('site_flash_sale_img') !=null ? asset(setting('site_flash_sale_img')):'' }}"/>
                            </div>
                        </div>
                        <!--logo-->
                        {{--<div class="form-group row">
                            <label for="logo" class="col-md-4 col-form-label text-md-right">{{ __('Feature Product Banner') }} <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input required type="file" id="input-file-now-custom-1" name="site_featured_img" class="dropify @error('site_featured_img') is-invalid @enderror" data-default-file="{{ setting('site_featured_img') !=null ? asset(setting('site_featured_img')):'' }}"/>
                            </div>
                        </div>--}}

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="update_contact">
                                    {{ __('Update') }}
                                </button>
                            </div>
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
@endpush



@push('custom-js')
    <script>
        $(document).ready(function(){
            // Basic
            $('.dropify').dropify();
        });
    </script>
@endpush
