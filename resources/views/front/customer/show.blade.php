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

<section class="checkout spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-5">
                @include('front.customer._sideMenu')
            </div>
            <div class="col-lg-9 col-md-7">
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
                                                <p>City:</p>
                                                <p>Zip:</p>
                                            </div>
                                            <div class="info-details">
                                                <p>Bikrom Roy</p>
                                                <p>demoemail@gmail.com</p>
                                                <p>023 434 54354</p>
                                                <p>Haydarabad, Rord 34</p>
                                                <p>3454</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="devider"></div>
                                    <div class="shop-info">
                                        <h5 class="heading">Shop Information</h5>
                                        <div class="info-list">
                                            <div class="info-title">
                                                <p>Name:</p>
                                                <p>Email:</p>
                                                <p>Phone:</p>
                                                <p>City:</p>
                                                <p>Zip:</p>
                                            </div>
                                            <div class="info-details">
                                                <p>Super-Shop</p>
                                                <p>demoemail@gmail.com</p>
                                                <p>023 434 54354</p>
                                                <p>Haydarabad, Rord 34</p>
                                                <p>3454</p>
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
