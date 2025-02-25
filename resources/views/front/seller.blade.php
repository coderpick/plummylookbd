@extends('layouts.frontend.master')

@section('content')
    <section class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>{{ ucfirst($title) }}</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ route('home') }}">Home</a>
                            <span>{{ ucfirst($title) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="container">
                <a href="{{ route('login') }}"><img width="100%" title="Login" src="{{ asset('uploads/seller_login.png') }}" alt=""></a>
                <br>
                <br>
                <br>
                <a href="{{ route('vendor.create') }}"><img width="100%" title="Merchant Registration" src="{{ asset('uploads/seller_banner.png') }}" alt=""></a>
            </div><!-- End .container -->
        </div>
    </section>
@endsection




@push('library-css')

@endpush



@push('custom-css')
    <style>
        .product {
            padding-top: 50px !important;
        }
    </style>
@endpush



@push('library-js')

@endpush



@push('custom-js')

@endpush
