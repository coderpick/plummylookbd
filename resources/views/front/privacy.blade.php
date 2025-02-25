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
            <div class="row">
                <div class="col-lg-1 col-md-2"></div>
                <div class="col-lg-10 col-md-8">
                    <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="product__item">
                                    <div class=" ">
                                        <blockquote>{!! $privacies->privacy ?? ' ' !!}</blockquote>
                                        <blockquote>{!! $cookies->cookie ?? ' ' !!}</blockquote>
                                        <blockquote>{!! $terms->terms ?? ' ' !!}</blockquote>
                                        <blockquote>{!! $faq->faq ?? ' ' !!}</blockquote>

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

@endpush



@push('custom-css')

@endpush



@push('library-js')

@endpush



@push('custom-js')

@endpush
