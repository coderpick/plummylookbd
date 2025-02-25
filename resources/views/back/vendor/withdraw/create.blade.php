@extends('layouts.backend.master')

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-th-list"></i>{{ $title }}</h1>
            <p>Save New {{ $title }} Easily</p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="#">{{ $title }} Now</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="tile">
                <h6 class="text-right" >Available Balance: {{ $balance }} </h6>

                <h3 class="tile-title">{{ $title }} Now</h3>
                <div class="tile-body">
                    <form class="row" action="{{ route('withdraw.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group col-md-8">
                            <label class="control-label">Withdraw Amount <span class="text-danger">*</span></label>
                            <input class="form-control @error('amount') is-invalid @enderror" type="number" name="amount" value="{{ old('amount') }}" placeholder="Enter amount">
                            @error('amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-8">
                            <label class="control-label">Reference (Optional) </label>
                            {{--<input class="form-control @error('reference') is-invalid @enderror" type="text" name="reference" value="{{ old('reference') }}" placeholder="Reference Note">--}}
                            <textarea class="form-control @error('reference') is-invalid @enderror" name="reference" id="" cols="30" rows="5" placeholder="Reference Note">{{ old('reference') }}</textarea>
                            @error('reference')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>


                        <div class="form-group col-md-4 align-self-end">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
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
