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

                <div class="row">
                    <div class="checkout__form col-lg-12">
                        <h4>Profile Details</h4>
                        <form action="{{ route('user.info.update', auth()->user()->slug ) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="checkout__input">
                                                <p>Full Name<span>*</span></p>
                                                <input class="@error('name') is-invalid @enderror" type="text" name="name" value="{{ ucfirst(auth()->user()->name) }}" required>
                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="checkout__input">
                                                <p>Phone Number<span>*</span></p>
                                                <input class="@error('phone') is-invalid @enderror" name="phone" type="text" value="{{ auth()->user()->phone }}" required>
                                                @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="checkout__input">
                                                <p>Email Address<span>*</span></p>
                                                <input class="@error('email') is-invalid @enderror" name="email" type="email" value="{{ auth()->user()->email }}" required>
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="checkout__input">
                                                <p>Select Your Profile Image</p>

                                                <input name="image" type="file" class="dropify @error('image') is-invalid @enderror" data-default-file="{{ asset(auth()->user()->image != null? auth()->user()->image : 'uploads/user_default.jpg') }}" data-max-file-size="2M">
                                                @error('image')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>




                                    <div class="checkout__input">

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <p>Your Address<span>*</span></p>
                                                <input class="@error('address_1') is-invalid @enderror" type="text" name="address_1" value="{{ (auth()->user()->detail)?auth()->user()->detail->address_1: '' }}" placeholder="Street Address" class="checkout__input__add" required>
                                                @error('address_1')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <p>More Address<span>*</span></p>
                                                <input class="@error('address_2') is-invalid @enderror" type="text" name="address_2" value="{{ (auth()->user()->detail)?auth()->user()->detail->address_2: '' }}" placeholder="Apartment, suite, unite ect (optional)">
                                                @error('address_2')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>




                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="checkout__input">
                                                <p>District<span>*</span></p>

                                                <select id="single" name="district" class="js-states form-control wrapper district @error('district') is-invalid @enderror" required>
                                                    @foreach ($districts as $district)
                                                    <option {{ (auth()->user()->detail) && auth()->user()->detail->district_id == $district->id?'selected': '' }} value="{{ $district->id }}">{{ ucfirst($district->name) }}</option>
                                                    @endforeach
                                                </select>


                                                @error('district')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="checkout__input">
                                                <p>Postcode / Zip<span>*</span></p>
                                                <input class="@error('zip') is-invalid @enderror" name="zip" type="number" value="{{ (auth()->user()->detail)?auth()->user()->detail->zip: '' }}" required>
                                                @error('zip')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>



                                    <div class="checkout__input">
                                        <p>Your Password</p>
                                        <input placeholder="**********" class="@error('password') is-invalid @enderror" name="password" type="password" id="password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="checkout__input">
                                        <p>Confirm Password</p>
                                        <input name="password_confirmation" placeholder="**********" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation">
                                    </div>

                                    <div class="text-left">
                                        <button type="submit" class="btn-lg site-btn custom-save-btn">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>


<!-- Overview New section add -->
<section class='user-overview'>
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12 col-12 mb-4">
                <a href="#account-orders" class="link-to-tab">
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
            <div class="col-lg-4 col-md-6 col-sm-12 col-12 mb-4">
                <a href="#account-orders" class="link-to-tab">
                    <div class="icon-box text-center">
                        <span class="icon-box-icon icon-orders">
                            <img src="{{ asset('frontend/img/address.png') }}" alt="">
                        </span>
                        <div class="icon-box-content">
                            <p class="text-uppercase mb-0">My Addresses</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-12 mb-4">
                <a href="#account-orders" class="link-to-tab">
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
                <a href="#account-orders" class="link-to-tab">
                    <div class="icon-box text-center">
                        <span class="icon-box-icon icon-orders">
                            <img src="{{ asset('frontend/img/logout.png') }}" alt="">
                        </span>
                        <div class="icon-box-content">
                            <p class="text-uppercase mb-0">Logout</p>
                        </div>
                    </div>
                </a>
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