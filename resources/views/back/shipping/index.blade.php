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
            <li class="breadcrumb-item active"><a href="{{ route('shipping.index') }}">{{ $title }}</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Shipping Information') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{route('shipping.insert')}}">
                        @csrf
                        <!--phone-->

                            <div class="form-group row">
                                <label for="shipping" class="col-md-4 col-form-label text-md-right">{{ __('Shipping charge by') }}</label>

                                <div class="col-md-6">

                                    <select class="form-control @error('charge_by') is-invalid @enderror" name="charge_by" id="">
                                        <option @if(isset($shipping) && $shipping->charge_by =='order') selected @endif value="order">Order</option>
                                        <option @if(isset($shipping) && $shipping->charge_by =='product') selected @endif value="product">Product</option>
                                        <option @if(isset($shipping) && $shipping->charge_by =='quantity') selected @endif value="quantity">Quantity</option>
                                    </select>

                                    @error('charge_by')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                            <label for="shipping" class="col-md-4 col-form-label text-md-right">{{ __('Inside Dhaka (TK)') }}</label>

                            <div class="col-md-6">

                                <input id="shipping" type="number" class="form-control @error('shipping') is-invalid @enderror" name="shipping" value="@if (isset($shipping->shipping)){{$shipping->shipping}}@endif" required autocomplete="shipping">

                                @error('shipping')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            </div>
                        <!--email-->

                            <div class="form-group row">
                                <label for="shipping2" class="col-md-4 col-form-label text-md-right">{{ __('Outside Dhaka (TK)') }}</label>

                                <div class="col-md-6">

                                    <input id="shipping2" type="number" class="form-control @error('shipping2') is-invalid @enderror" name="shipping2" value="@if (isset($shipping->shipping2)){{$shipping->shipping2}}@endif" required autocomplete="shipping2">

                                    @error('shipping2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="free_shipping" class="col-md-4 col-form-label text-md-right">{{ __('Free Shipping on Purchase (TK)') }}</label>

                                <div class="col-md-6">

                                    <input id="free_shipping" type="number" class="form-control @error('free_shipping') is-invalid @enderror" name="free_shipping" value="@if (isset($shipping->free_shipping)){{$shipping->free_shipping}}@endif" required autocomplete="free_shipping">

                                    @error('free_shipping')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>



                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                @if (isset($shipping))
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
