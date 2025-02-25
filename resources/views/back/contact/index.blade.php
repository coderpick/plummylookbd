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
            <li class="breadcrumb-item active"><a href="{{ route('category.index') }}">{{ $title }}</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Information') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{route('contact.insert')}}">
                        @csrf
                        <!--phone-->
                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Contact Number') }}</label>
                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="@if (isset($contacts->phone)){{$contacts->phone}}@endif" required autocomplete="phone" autofocus>
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Bkash Number') }}</label>
                            <div class="col-md-6">
                                <input id="bkash" type="text" class="form-control @error('bkash') is-invalid @enderror" name="bkash" value="@if (isset($contacts->bkash)){{$contacts->bkash}}@endif" required>
                                @error('bkash')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Nagad Number') }}</label>
                            <div class="col-md-6">
                                <input id="nagad" type="text" class="form-control @error('nagad') is-invalid @enderror" name="nagad" value="@if (isset($contacts->nagad)){{$contacts->nagad}}@endif" required>
                                @error('nagad')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <!--email-->
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="@if (isset($contacts->email)){{$contacts->email}}@endif" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!--address-->
                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="@if (isset($contacts->address)){{$contacts->address}}@endif" required autocomplete="address">

                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!--map-->
                        <div class="form-group row">
                            <label for="embed-map" class="col-md-4 col-form-label text-md-right">{{ __('Embed Map Link') }}</label>

                            <div class="col-md-6">
                                <textarea name="map" id="" class="form-control" rows="5" required>@if(isset($contacts->map)){{ $contacts->map}}@endif</textarea>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                @if (isset($contacts))
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
