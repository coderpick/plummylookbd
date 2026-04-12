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
                <div class="row">
                    <div class="card shadow-sm border-0 rounded-lg w-100">
                        <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                            <h4 class="mb-0 text-custom font-weight-bold" style="color: var(--color-primary-dark);"><i class="fa fa-user-circle mr-2"></i> Profile Information</h4>
                        </div>
                        <div class="card-body mt-2 p-4">
                            <form action="{{ route('user.profile.update', auth()->user()->slug ) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                
                                <h6 class="text-uppercase text-muted font-weight-bold mb-3"><i class="fa fa-id-card-o mr-2"></i> Account Details</h6>
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <div class="checkout__input">
                                            <p class="font-weight-bold mb-2">Full Name<span>*</span></p>
                                            <input class="@error('name') is-invalid @enderror form-control bg-light border-0" style="height: 46px; border-radius: 4px;" type="text" name="name" value="{{ ucfirst(auth()->user()->name) }}" required>
                                            @error('name')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <div class="checkout__input">
                                            <p class="font-weight-bold mb-2">Phone Number<span>*</span></p>
                                            <input class="@error('phone') is-invalid @enderror form-control bg-light border-0" style="height: 46px; border-radius: 4px;" name="phone" type="text" value="{{ auth()->user()->phone }}" required>
                                            @error('phone')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <div class="checkout__input">
                                            <p class="font-weight-bold mb-2">Email Address<span>*</span></p>
                                            <input class="@error('email') is-invalid @enderror form-control bg-light border-0" style="height: 46px; border-radius: 4px;" name="email" type="email" value="{{ auth()->user()->email }}" required>
                                            @error('email')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <div class="checkout__input">
                                            <p class="font-weight-bold mb-2">Profile Image</p>
                                            <input name="image" type="file" class="dropify @error('image') is-invalid @enderror" data-default-file="{{ asset(auth()->user()->image != null? auth()->user()->image : 'uploads/user_default.jpg') }}" data-max-file-size="2M" data-height="100">
                                            @error('image')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <hr class="my-4 border-light">
                                <h6 class="text-uppercase text-muted font-weight-bold mb-3"><i class="fa fa-map-marker mr-2"></i> Shipping Address</h6>
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <div class="checkout__input">
                                            <p class="font-weight-bold mb-2">Street Address<span>*</span></p>
                                            <input class="@error('address_1') is-invalid @enderror form-control bg-light border-0" style="height: 46px; border-radius: 4px;" type="text" name="address_1" value="{{ (auth()->user()->detail)?auth()->user()->detail->address_1: '' }}" placeholder="Street Address" required>
                                            @error('address_1')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <div class="checkout__input">
                                            <p class="font-weight-bold mb-2">Apartment/Suite (Optional)</p>
                                            <input class="@error('address_2') is-invalid @enderror form-control bg-light border-0" style="height: 46px; border-radius: 4px;" type="text" name="address_2" value="{{ (auth()->user()->detail)?auth()->user()->detail->address_2: '' }}" placeholder="Apartment, suite, unite ect (optional)">
                                            @error('address_2')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <div class="checkout__input">
                                            <p class="font-weight-bold mb-2">District<span>*</span></p>
                                            <select id="single" name="district" class="js-states form-control wrapper district @error('district') is-invalid @enderror" required>
                                                @foreach ($districts as $district)
                                                <option {{ (auth()->user()->detail) && auth()->user()->detail->district_id == $district->id?'selected': '' }} value="{{ $district->id }}">{{ ucfirst($district->name) }}</option>
                                                @endforeach
                                            </select>
                                            @error('district')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <div class="checkout__input">
                                            <p class="font-weight-bold mb-2">Postcode / Zip<span>*</span></p>
                                            <input class="@error('zip') is-invalid @enderror form-control bg-light border-0" style="height: 46px; border-radius: 4px;" name="zip" type="number" value="{{ (auth()->user()->detail)?auth()->user()->detail->zip: '' }}" required>
                                            @error('zip')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <hr class="my-4 border-light">
                                <h6 class="text-uppercase text-muted font-weight-bold mb-3"><i class="fa fa-lock mr-2"></i> Security</h6>
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <div class="checkout__input">
                                            <p class="font-weight-bold mb-2">New Password (Optional)</p>
                                            <input placeholder="Leave blank to keep unchanged" class="@error('password') is-invalid @enderror form-control bg-light border-0" style="height: 46px; border-radius: 4px;" name="password" type="password" id="password">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <div class="checkout__input">
                                            <p class="font-weight-bold mb-2">Confirm Password</p>
                                            <input name="password_confirmation" placeholder="Leave blank to keep unchanged" type="password" class="form-control bg-light border-0" style="height: 46px; border-radius: 4px;" id="password_confirmation">
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right mt-4 mb-2">
                                    <button type="submit" class="btn btn-primary rounded-pill px-5 py-3 font-weight-bold shadow-sm" style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%); border: none;">
                                        <i class="fa fa-save mr-2"></i> Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
