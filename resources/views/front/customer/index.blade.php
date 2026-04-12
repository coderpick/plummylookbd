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
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('user.orders') }}" class="card shadow-sm border-0 h-100 text-decoration-none text-white custom-hover-card" style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);">
                            <div class="card-body text-center d-flex flex-column justify-content-center align-items-center py-4">
                                <i class="fa fa-shopping-bag fa-3x mb-3 text-white-50"></i>
                                <h5 class="text-white text-uppercase font-weight-bold mb-0">My Orders</h5>
                                <p class="small text-white-50 mt-2 mb-0">View & track orders</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('user.profile') }}" class="card shadow-sm border-0 h-100 text-decoration-none bg-info text-white custom-hover-card" style="background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%);">
                            <div class="card-body text-center d-flex flex-column justify-content-center align-items-center py-4">
                                <i class="fa fa-user-circle fa-3x mb-3 text-white-50"></i>
                                <h5 class="text-white text-uppercase font-weight-bold mb-0">Profile Details</h5>
                                <p class="small text-white-50 mt-2 mb-0">Manage account info</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="card shadow-sm border-0 h-100 text-decoration-none bg-danger text-white custom-hover-card" style="background: linear-gradient(135deg, #dc3545 0%, #bd2130 100%);">
                            <div class="card-body text-center d-flex flex-column justify-content-center align-items-center py-4">
                                <i class="fa fa-sign-out fa-3x mb-3 text-white-50"></i>
                                <h5 class="text-white text-uppercase font-weight-bold mb-0">Logout</h5>
                                <p class="small text-white-50 mt-2 mb-0">Securely sign out</p>
                            </div>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm border-0 rounded-lg h-100">
                            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                                <h5 class="mb-0 text-custom font-weight-bold" style="color: var(--color-primary-dark);"><i class="fa fa-id-card-o mr-2"></i> Personal Information</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0 border-light d-flex align-items-center">
                                        <div class="text-muted" style="width: 30%;"><i class="fa fa-user mr-2"></i> Name</div>
                                        <div class="font-weight-bold" style="width: 70%;">{{ $user->name }}</div>
                                    </li>
                                    <li class="list-group-item px-0 border-light d-flex align-items-center">
                                        <div class="text-muted" style="width: 30%;"><i class="fa fa-envelope mr-2"></i> Email</div>
                                        <div class="font-weight-bold" style="width: 70%; word-break: break-all;">{{ $user->email }}</div>
                                    </li>
                                    <li class="list-group-item px-0 border-light d-flex align-items-center">
                                        <div class="text-muted" style="width: 30%;"><i class="fa fa-phone mr-2"></i> Phone</div>
                                        <div class="font-weight-bold" style="width: 70%;">{{ $user->phone ?? 'N/A' }}</div>
                                    </li>
                                    <li class="list-group-item px-0 border-light d-flex align-items-center">
                                        <div class="text-muted" style="width: 30%;"><i class="fa fa-info-circle mr-2"></i> Status</div>
                                        <div style="width: 70%;">
                                            @if($user->status == 1)
                                                <span class="badge badge-success px-3 py-1 rounded-pill">Active</span>
                                            @else
                                                <span class="badge badge-danger px-3 py-1 rounded-pill">Inactive</span>
                                            @endif
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm border-0 rounded-lg h-100">
                            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                                <h5 class="mb-0 text-custom font-weight-bold" style="color: var(--color-primary-dark);"><i class="fa fa-map-marker mr-2"></i> Location Information</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0 border-light d-flex align-items-start">
                                        <div class="text-muted" style="width: 30%;"><i class="fa fa-home mr-2"></i> Address</div>
                                        <div class="font-weight-bold" style="width: 70%;">
                                            {{ $user->detail->address_1 ?? 'Not provided' }}
                                            @if(!empty($user->detail->address_2))
                                                <br>{{ $user->detail->address_2 }}
                                            @endif
                                        </div>
                                    </li>
                                    <li class="list-group-item px-0 border-light d-flex align-items-center">
                                        <div class="text-muted" style="width: 30%;"><i class="fa fa-map mr-2"></i> District</div>
                                        <div class="font-weight-bold" style="width: 70%;">{{ $user->detail->district->name ?? 'Not provided' }}</div>
                                    </li>
                                    <li class="list-group-item px-0 border-light d-flex align-items-center">
                                        <div class="text-muted" style="width: 30%;"><i class="fa fa-location-arrow mr-2"></i> Zip Code</div>
                                        <div class="font-weight-bold" style="width: 70%;">{{ $user->detail->zip ?? 'Not provided' }}</div>
                                    </li>
                                </ul>
                            </div>
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
