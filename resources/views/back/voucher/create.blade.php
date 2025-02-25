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
                    <form class="row" action="{{ route('coupon.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group col-md-8">
                            <label class="control-label">Coupon Type</label>
                            <select id="type" class="select2 form-control chosen-select-no-single @error('coupon_type') is-invalid @enderror" type="text" name="coupon_type" >
                                <option value="fixed">Fixed</option>
                                <option value="percentage">Percentage</option>
                            </select>
                            @error('coupon_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                        </div>


                        <div class="form-group col-md-4">
                            <label class="control-label">Coupon Code</label>
                            <input class="form-control @error('code') is-invalid @enderror" type="text" name="code" value="{{ old('code') }}" placeholder="Enter coupon code">
                            @error('code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label id="value" class="control-label">Value (in Amount)</label>
                            <input class="form-control @error('value') is-invalid @enderror" type="number" name="value" value="{{ old('value') }}" placeholder="Enter coupon value">
                            @error('value')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                        </div>

                        <div class="form-group col-md-4">
                            <label class="control-label">Minimum Purchase</label>
                            <input class="form-control @error('min_limit') is-invalid @enderror" type="number" name="min_limit" value="{{ old('min_limit') }}" placeholder="Enter minimum limit">
                            @error('min_limit')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label class="control-label">Expire Date</label>
                            <input class="form-control @error('expires_at') is-invalid @enderror" type="date" name="expires_at" value="{{ old('expires_at') }}" placeholder="Enter expire date">
                            @error('expires_at')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-4"></div>
                        <div class="form-group col-md-4">
                            <label for="default">One time use?</label>
                            <br>
                            <input name="type" type="checkbox" value="1"> <label
                                for="active">Yes</label>
                        </div>
                        <div class="form-group col-md-4"></div>



                        <div class="form-group col-md-4 align-self-end">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save</button>
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
