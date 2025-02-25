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
                    <form method="POST" action="{{route('meta.insert')}}">
                        @csrf

                        <!--email-->
                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Site Title') }}</label>

                            <div class="col-md-6">
                                <input id="title" type="title" class="form-control @error('title') is-invalid @enderror" name="title" value="@if (isset($meta->title)){{$meta->title}}@endif" required autocomplete="title">

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!--address-->
                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Meta Keywords') }}</label>

                            <div class="col-md-6">
                                <input id="keyword" type="text" class="form-control @error('keyword') is-invalid @enderror" name="keyword" value="@if (isset($meta->keyword)){{$meta->keyword}}@endif" required autocomplete="keyword">

                                @error('keyword')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!--About-->
                        <div class="form-group row">
                            <label for="about" class="col-md-4 col-form-label text-md-right">{{ __('Meta Description') }}</label>

                            <div class="col-md-6">
                                <textarea id="description" rows="5" type="text" class="form-control @error('description') is-invalid @enderror" name="description" required>@if(isset($meta->description)){{ $meta->description}}@endif</textarea>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!--map-->


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                @if (isset($meta))
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
