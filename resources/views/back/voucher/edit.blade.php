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
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="tile">
                <h3 class="tile-title">{{ $title }} Form</h3>
                <div class="tile-body">
                    <form class="row" action="{{ route('coupon.update',$voucher->slug) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="form-group col-md-8">
                            <label class="control-label">Coupon Type</label>
                            <select id="type" class="select2 form-control chosen-select-no-single @error('coupon_type') is-invalid @enderror" type="text" name="coupon_type" >
                                <option @if ($voucher->coupon_type == 'fixed') selected @endif value="fixed">Fixed</option>
                                <option @if ($voucher->coupon_type == 'percentage') selected @endif value="percentage">Percentage</option>
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
                            <input class="form-control @error('code') is-invalid @enderror" type="text" name="code" value="{{ isset($voucher)?$voucher->code:null }}" placeholder="Enter voucher code">
                            @error('code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label id="value" class="control-label">Value</label>
                            <input class="form-control @error('value') is-invalid @enderror" type="number" name="value" value="{{ isset($voucher)?$voucher->value:null }}" placeholder="Enter voucher value">
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
                            <input class="form-control @error('min_limit') is-invalid @enderror" type="number" name="min_limit" value="{{ isset($voucher)?$voucher->min_limit:null }}" placeholder="Enter minimum limit">
                            @error('min_limit')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label class="control-label">Expire Date</label>
                            <input class="form-control @error('expires_at') is-invalid @enderror" type="date" name="expires_at" value="{{ isset($voucher)?$voucher->expires_at:null }}" placeholder="Enter expire date">
                            @error('expires_at')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4"></div>
                        <div class="form-group col-md-4">
                            @php
                                if(isset($voucher)){
                                    $type = $voucher->type;
                                }else{
                                    $type = null;
                                }
                            @endphp

                            <label for="default">One time use?</label>
                            <br>
                            <input name="type" type="checkbox" value="1" @if($type == 1) checked @endif> <label
                                for="active">Yes</label>
                        </div>
                        <div class="form-group col-md-4"></div>




                        <div class="form-group col-md-4 align-self-end">
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
            if ($('#type').val() == "percentage") {
                $('#value').text('Value (in %)');
            }
            if ($('#type').val() == "fixed") {
                $('#value').text('Value (in Amount)');
            }

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
