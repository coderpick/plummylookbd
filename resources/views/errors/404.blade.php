@extends('layouts.frontend.master')

@section('content')
    <section class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Not Found</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ route('home') }}">Home</a>
                            <span>Not Found</span>
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
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center pt-4">
                        <div class="mt-n4">
                            <h1 class="display-1 fw-medium">404</h1>
                            <h3>Sorry, Page not Found</h3>
                            <p class="text-muted mb-4">The page you are looking for not available!</p>
                            <div class="btn btn-custom text-white text-center mb-5">
                                <a href="{{ route('home') }}">Back to Home</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection




@push('library-css')

@endpush



@push('custom-css')
    <style>
        .set-bg {
            background-size: 260px 270px;
        }

        .fa-star {
            color: #ccc;
        }
        .checked {
            color: #ffc700;
        }
    </style>
@endpush



@push('library-js')

@endpush



@push('custom-js')

@endpush
