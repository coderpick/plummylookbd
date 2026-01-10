@extends('layouts.frontend.master')

@section('content')
<section class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h1>{{ ucfirst($title) }}</h1>                  
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<section class="checkout spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-5">
                @include('front.customer._sideMenu')
            </div>
            <div class="col-lg-9 col-md-7">
                <!-- Overview New section add -->
                <section class='user-overview mb-5'>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-sm-12 col-12 mb-4">
                                <a href="{{ route('myorders') }}" class="link-to-tab">
                                    <div class="icon-box text-center">
                        <span class="icon-box-icon icon-orders">
                            <img src="{{ asset('frontend/img/manifest.png') }}" alt="">
                        </span>
                                        <div class="icon-box-content">
                                            <p class="text-uppercase mb-0">My Orders</p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            {{--<div class="col-lg-4 col-md-6 col-sm-12 col-12 mb-4">
                                <a href="#account-orders" class="link-to-tab">
                                    <div class="icon-box text-center">
                        <span class="icon-box-icon icon-orders">
                            <img src="{{ asset('frontend/img/address.png') }}" alt="">
                        </span>
                                        <div class="icon-box-content">
                                            <p class="text-uppercase mb-0">My Address</p>
                                        </div>
                                    </div>
                                </a>
                            </div>--}}

                            <div class="col-lg-4 col-md-6 col-sm-12 col-12 mb-4">
                                <a href="{{ route('customer.show') }}" class="link-to-tab">
                                    <div class="icon-box text-center">
                        <span class="icon-box-icon icon-orders">
                            <img src="{{ asset('frontend/img/authorized-user.png') }}" alt="">
                        </span>
                                        <div class="icon-box-content">
                                            <p class="text-uppercase mb-0">Profile Details</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 col-12 mb-4">
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();" class="link-to-tab">
                                    <div class="icon-box text-center">
                        <span class="icon-box-icon icon-orders">
                            <img src="{{ asset('frontend/img/logout.png') }}" alt="">
                        </span>
                                        <div class="icon-box-content">
                                            <p class="text-uppercase mb-0">Logout</p>
                                        </div>
                                    </div>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Overview End new section -->

                <!-- address information -->
                <section>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="info-section">
                                    <div class="seller-info">
                                        <h5 class="heading">Personal Information</h5>
                                        <div class="info-list">
                                            <div class="info-title">
                                                <p>Name:</p>
                                                <p>Email:</p>
                                                <p>Phone:</p>
                                                <p>Status:</p>
                                            </div>
                                            <div class="info-details">
                                                <p>{{ $user->name }}</p>
                                                <p>{{ $user->email }}</p>
                                                <p>{{ $user->phone }}</p>
                                                <p>{{ $user->status==1?'Active':'Inactive' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="devider"></div>
                                    <div class="shop-info">
                                        <h5 class="heading">Location Information</h5>
                                        <div class="info-list">
                                            <div class="info-title">
                                                <p>Address:</p>
                                                <p> &nbsp; </p>
                                                <p>District:</p>
                                                <p>Zip:</p>
                                            </div>
                                            <div class="info-details">
                                                <p>{{ $user->detail->address_1??'' }}</p>
                                                <p>{{ $user->detail->address_2??'' }}</p>
                                                <p>{{ $user->detail->district->name??'' }}</p>
                                                <p>{{ $user->detail->zip??'' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- End address information -->
            </div>
        </div>

    </div>
</section>


@endsection




@push('library-css')
<link rel="stylesheet" href="{{asset('backend/dropify/css/dropify.min.css')}}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('custom-css')
<style>
    .btn-lg {
        border-radius: unset;
    }


    .select2-container .select2-selection--single {
        height: 46px;
        padding-top: 9px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 38px;
    }

    .checkout__input input {
        color: #585858;
        !important;
    }
</style>
@endpush



@push('library-js')
<script src="{{asset('backend/dropify/js/dropify.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
@endpush



@push('custom-js')
<script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();
        $('.district').select2();
    });
</script>
@endpush
