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
                @foreach($offers as $offer)
                    <div class="row align-items-lg-center border mb-5">
                        <div class="col-md-4">
                            <img class="image" style="width: auto; max-height: 200px; min-height: 200px;" src="{{ asset($offer->image) }}" alt="offer_image">
                        </div>
                        <div class="col-md-8 padding-left-lg">
                            <h3 class="subtitle">{{ ucfirst($offer->title) }}</h3>
                            <p class="overflow-hidden">{{ $offer->text }}</p>

                        </div>
                    </div><!-- End .row -->
                @endforeach
            </div><!-- End .container -->
            {{ $offers->render() }}
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
