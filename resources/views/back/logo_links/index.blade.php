@extends('layouts.backend.master')
@section('content')
    <!--title-->
    <div class="app-title">
        <div>
            <h1><i class="fa fa-th-list"></i> {{ $title }}</h1>
            <p>Display {{ $title }} Data Effectively</p>
        </div>


        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="#">{{ $title }}</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Information') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{route('link.insert')}}" enctype="multipart/form-data" >
                        @csrf
                        <!--logo-->
                        <div class="form-group row">
                            <label for="logo" class="col-md-4 col-form-label text-md-right">{{ __('Logo') }} <span class="text-danger">*</span></label>
                            <div class="col-md-6">


                                <input type="file" id="input-file-now-custom-1" name="logo" class="dropify" @error('logo') is-invalid @enderror data-default-file="@if(isset($logo_links->logo)){{asset($logo_links->logo)}}@else{{asset('uploads/default.jpg')}}@endif"/>


                            </div>
                        </div>
                            <!--logo-->
                            <div class="form-group row">
                                <label for="logo" class="col-md-4 col-form-label text-md-right">{{ __('Footer Logo') }}</label>
                                <div class="col-md-6">


                                    <input type="file" id="input-file-now-custom-1" name="footer_logo" class="dropify" @error('footer_logo') is-invalid @enderror data-default-file="@if(isset($logo_links->footer_logo)){{asset($logo_links->footer_logo)}}@else{{asset('uploads/default.jpg')}}@endif"/>


                                </div>
                            </div>


                        <!--facebook-->
                        <div class="form-group row">
                            <label for="facebook" class="col-md-4 col-form-label text-md-right">{{ __('Facebook Link') }}</label>

                            <div class="col-md-6">
                            <input id="facebook" type="text" class="form-control @error('facebook') is-invalid @enderror" value="@if(isset($logo_links->facebook)){{$logo_links->facebook}}@endif" name="facebook" >


                            </div>
                        </div>
                        <!--twitter-->
                        <div class="form-group row">
                            <label for="twitter" class="col-md-4 col-form-label text-md-right">{{ __('Twitter Link') }}</label>

                            <div class="col-md-6">
                                <input id="twitter" type="text" class="form-control @error('twitter') is-invalid @enderror" value="@if(isset($logo_links->twitter)){{$logo_links->twitter}}@endif" name="twitter" >


                            </div>
                        </div>
                        <!--instagram-->
                        <div class="form-group row">
                            <label for="instagram" class="col-md-4 col-form-label text-md-right">{{ __('Pinterest Link') }}</label>

                            <div class="col-md-6">
                                <input id="pinterest" type="text" class="form-control @error('pinterest') is-invalid @enderror" value="@if(isset($logo_links->pinterest)){{$logo_links->pinterest}}@endif" name="pinterest" >


                            </div>
                        </div>
                        <!--skype-->
                        <div class="form-group row">
                            <label for="skype" class="col-md-4 col-form-label text-md-right">{{ __('Linkedin Link') }}</label>

                            <div class="col-md-6">
                                <input id="linkedin" type="text" class="form-control @error('linkedin') is-invalid @enderror" value="@if(isset($logo_links->linkedin)){{$logo_links->linkedin}}@endif" name="linkedin" >


                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                @if (isset($logo_links))
                                <button type="submit" class="btn btn-primary" id="update_contact">
                                    {{ __('Update') }}
                                </button>
                                @else
                                <button type="submit" class="btn btn-primary" id="insert_contact">
                                    {{ __('Insert') }}
                                </button>
                                @endif


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
