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
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="tile">
                <h3 class="tile-title">{{ $title }} Form</h3>
                <div class="tile-body">
                    <form method="POST" action="{{ route('vendor.store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }} <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Owner Name') }} <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="form-name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="shop" class="col-md-4 col-form-label text-md-right">{{ __('Shop Name') }} <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="shop" type="text" class="form-control @error('shop') is-invalid @enderror" name="shop" value="{{ old('shop') }}" required autocomplete="shop" autofocus>
                                @error('shop')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }} <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="phone" type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('National ID No.') }} </label>
                            <div class="col-md-6">
                                <input id="nid" type="number" class="form-control @error('nid') is-invalid @enderror" name="nid" value="{{ old('nid') }}">
                                @error('nid')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sequence" class="col-md-4 col-form-label text-md-right">{{ __('Sequence') }} </label>
                            <div class="col-md-6">
                                <input id="sequence" type="number" class="form-control @error('sequence') is-invalid @enderror" name="sequence" value="{{ old('sequence') }}">
                                @error('sequence')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }} <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }} <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="form-group col-md-4"></div>
                            <div class="form-group col-md-4"></div>
                            <div class="form-group col-md-4 align-self-end">
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
    <script>
        $('#type').change(function() {
            if (this.value == "percentage") {
                $('#value').text('Value (in %)');
            }
            if (this.value == "fixed") {
                $('#value').text('Value (in Amount)');
            }
        });
    </script>
@endpush
