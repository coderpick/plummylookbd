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

    <!-- Featured Section Begin -->
    @if (isset($shops) && count($shops) > 0)
        <section class="featured spad">
            <div class="container">
                <div class="row featured__filter">
                    @foreach ($shops as $shop)
                        <div class="nil">
                            <div class="featured__item tin-card">

                                <a href="{{ route('merchant.product', $shop->slug) }}">
                                    <div class="featured__item__pic">
                                        <img style="max-width: 165px; max-height: 200px" class=" "
                                            src="{{ asset($shop->image != null ? $shop->image : 'uploads/store.png') }}"
                                            alt="store">
                                    </div>
                                    <div class="featured__item__text">
                                        <h6>{{ ucfirst($shop->name) }}</h6>
                                    </div>
                                </a>

                            </div>
                        </div>
                    @endforeach
                </div>
                {{ $shops->render() }}
            </div>
        </section>
    @endif
    <!-- Featured Section End -->


    <!-- Featured Section Begin -->
    @if (isset($categories) && count($categories) > 0)
        <section class="featured spad">
            <div class="container">
                <div class="row custom-row">
                    @forelse($categories as $index=>$category)
                        <div class="col-lg-2 col-md-3 col-sm-4 col-4 custom-col">
                            <div class="category-card shadow-sm">
                                <a href="{{ route('product.category', $category->slug) }}">
                                    <img src="{{ asset($category->icon) }}" alt="{{ $category->name }}" loading="lazy">
                                    <h5>{{ ucfirst($category->name) }}</h5>
                                </a>
                            </div>
                        </div>
                    @empty
                    @endforelse

                </div>
            </div>
        </section>
    @endif
    <!-- Featured Section End -->


@endsection




@push('library-css')
@endpush



@push('custom-css')
    <style>
        .set-bg {
            background-size: 260px 270px;
        }
    </style>
@endpush



@push('library-js')
@endpush



@push('custom-js')
@endpush
