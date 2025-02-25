@extends('layouts.backend.master')

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-th-list"></i> {{ $title }}</h1>
            <p>{{ $title }} Easily</p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="#">{{ $title }}</a></li>
        </ul>
    </div>
    <div class="text-right mb-2">
        <a href="{{ route('user.index') }}" class="btn btn-danger"><i class="fa fa-reply"></i> Back to User List</a>
    </div>
    <form class="form-horizontal" action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">User Info</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label id="name" class="control-label">Name <strong class="text-danger">*</strong></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name') }}" >
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div><!-- name field end-->
                        <div class="form-group">
                            <label for="email" class="control-label">Email <strong class="text-danger">*</strong></label>
                            <input name="email" type="email" value="{{ old('email') }}"  class="form-control @error('email') is-invalid @enderror" id="email" >
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div><!-- email field end-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone" class="control-label">Phone </label>
                                    <input name="phone" type="text" value="{{ old('phone') }}"  class="form-control @error('phone') is-invalid @enderror" id="phone">
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label id="nid" class="control-label">National ID Card Number </label>
                                    <input class="form-control @error('nid') is-invalid @enderror" type="number" min="0" name="nid" id="nid" value="{{ old('nid') }}">
                                    @error('nid')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="control-label">Password <strong>*</strong></label>
                                    <input name="password" type="password"   class="form-control @error('password') is-invalid @enderror" id="password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation" class="control-label">Confirm Password <strong class="text-danger">*</strong></label>
                                    <input name="password_confirmation" type="password"   class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Select Role & Image</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="role">Select Role  <strong class="text-danger">*</strong></label>
                            <select name="roles[]" id="role" class="form-control @error('roles') is-invalid @enderror" multiple="multiple" style="width: 100%">
                                <option  value=" ">Select role</option>
                                @forelse($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @empty
                                @endforelse
                            </select>
                            @error('roles')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">Profile Image</label>
                            <input type="file" name="image" id="input-file-max-fs" class="dropify @error('image') is-invalid @enderror" data-default-file="{{ isset($admin)?asset($admin->image):null }}" data-max-file-size="2M">
                            @error('image')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <label for="">Status</label>
                        <div class="toggle lg">
                            <label>
                                <input type="checkbox" name="status" checked><span class="button-indecator"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group text-center mt-3">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-plus-circle"></i> Create
            </button>
        </div>
    </form>

@endsection


@push('library-css')
    <!-- dropify CSS-->
    <link rel="stylesheet" href="{{asset('backend/dropify/css/dropify.min.css')}}">
@endpush



@push('custom-css')
    <style>
        .dropify-wrapper{
            height: 135px;
        }
    </style>
@endpush



@push('library-js')
    <!-- dropify JS-->
    <script src="{{asset('backend/dropify/js/dropify.min.js')}}"></script>
    <script src="{{asset('backend/js/plugins/select2.min.js')}}"></script>
@endpush


@push('custom-js')
    <script>
        $(document).ready(function(){
            // Basic
            $('.dropify').dropify();
            $('#role').select2();
        });
    </script>
@endpush
