@extends('layouts.backend.master')

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-th-list"></i>{{ $title }}</h1>
            <p>Shop Details</p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="#">Shop</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="tile">
                <h3 class="tile-title">{{ $title }} Details</h3>
                <div class="tile-body">
                    <form class="form-horizontal" action="{{ route('shop.update',$shop->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')


                        <div class="form-group row">
                            <label class="control-label col-md-3">Shop Name </label>
                            <div class="col-md-8">
                                <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name',isset($shop)?$shop->name:null) }}" required @if($shop->routing_no != null) readonly @endif>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="email" class="control-label col-md-3">Description </label>
                            <div class="col-md-8">
                                <textarea name="description" id="" cols="30" rows="5" class="form-control @error('description') is-invalid @enderror">{{ $shop->description }}</textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="control-label col-md-3">Shop Icon/Logo (Max. 2mb)</label>
                            <div class="col-md-8">
                                <input type="file" name="image" id="input-file-max-fs" class="dropify @error('image') is-invalid @enderror" data-default-file="{{ isset($shop)?asset($shop->image):null }}" data-max-file-size="2M">
                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <br>
                        <h5>Bank Information</h5>
                        <br>


                        <div class="form-group row">
                            <label class="control-label col-md-3">Bank Name </label>
                            <div class="col-md-8">
                                <input class="form-control @error('bank') is-invalid @enderror" type="text" name="bank" value="{{ old('bank',isset($shop)?$shop->bank:null) }}">
                                @error('bank')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Branch Name </label>
                            <div class="col-md-8">
                                <input class="form-control @error('branch') is-invalid @enderror" type="text" name="branch" value="{{ old('branch',isset($shop)?$shop->branch:null) }}">
                                @error('branch')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Account Holder Name </label>
                            <div class="col-md-8">
                                <input class="form-control @error('acc_name') is-invalid @enderror" type="text" name="acc_name" value="{{ old('acc_name',isset($shop)?$shop->acc_name:null) }}">
                                @error('acc_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Account Number </label>
                            <div class="col-md-8">
                                <input class="form-control @error('acc_no') is-invalid @enderror" type="number" name="acc_no" value="{{ old('acc_no',isset($shop)?$shop->acc_no:null) }}">
                                @error('acc_no')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Routing Number </label>
                            <div class="col-md-8">
                                <input class="form-control @error('routing_no') is-invalid @enderror" type="number" name="routing_no" value="{{ old('routing_no',isset($shop)?$shop->routing_no:null) }}">
                                @error('routing_no')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3">Blank Cheque Leaf (Max. 5mb)</label>
                            <div class="col-md-8">
                                <input @if($shop->cheque == null) required @endif @if($shop->cheque != null) readonly @endif type="file" name="cheque" id="input-file-max-fs" class="dropify @error('cheque') is-invalid @enderror" data-default-file="{{ isset($shop)?asset($shop->cheque):null }}" data-max-file-size="5M">
                                @error('cheque')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>



                        <div class="form-group col-md-4 align-self-end">
                            <button class="btn btn-primary" onclick="return confirm('Make sure, all information are correct')" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>
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
