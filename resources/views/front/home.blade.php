@extends('layouts.frontend.master')

@section('content')
    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 p-0">
                    <div class="owl-carousel slider-carousel">
                        @forelse($sliders as $id=>$slider)
                            <div class="item">
                                <div class="">
                                    @isset($slider->link)
                                        <a href="{{ $slider->link }}" target="_blank">
                                        @endisset
                                        <img class="home-slider" src="{{ asset($slider->image) }}" alt="{{ $slider->title }}"
                                            loading="lazy">
                                    </a>
                                </div>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    @if (isset($home_categories) && count($home_categories) > 0)
        <section id="">
            <div class="container mobile-none rts-section-gapBottom">
                <div class="row no-gutters">
                    @forelse($home_categories as $index=>$category)
                        <div class="col-6 col-md-3 col-lg-3">
                            <div class="card border-0 shadow home-category-card">
                                <div class="card-body p-0">
                                    <a href="{{ route('product.category', $category->slug) }}">
                                        <img class="img-thumbnail" src="{{ asset($category->icon) }}"
                                            alt="{{ $category->name }}" loading="lazy" />
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
            </div>
        </section>
    @endif

    <section class="Featured-Categories">
        <div class="container">
            <h2 class="title-left text-center text-custom title-bg shadow-sm">Shop By Concern</h2>
            <div class="owl-carousel owl-theme">
                @forelse($concerns as $index=>$category)
                    <a href="{{ route('product.concern', $category->slug) }}">
                        <div class="card shadow-sm concern-category-card">
                            <img class="card-img-top" src="{{ asset($category->icon) }}" alt="{{ $category->name }}"
                                loading="lazy">
                            <div class="card-body py-2 text-center">
                                <h5 class="category-card-title mb-0">{{ ucfirst($category->name) }}</h5>
                            </div>
                        </div>
                    </a>
                @empty
                    No items found
                @endforelse
            </div>
        </div>
    </section>

    <section class="Featured-Categories">
        <div class="container">
            <h2 class="title-left text-center text-custom title-bg">Shop By Brands</h2>
            <div class="owl-carousel owl-theme">
                @forelse($brands as $index=>$brand)
                    <a href="{{ route('product.brand', $brand->slug) }}">
                        <div class="card shadow-sm concern-category-card">
                            <img class="card-img-top"
                                src="{{ $brand->icon ? asset($brand->icon) : asset('uploads/default2.jpg') }}"
                                alt="{{ $brand->name }}" loading="lazy">
                            <div class="card-body py-2 text-center">
                                <h5 class="category-card-title mb-0">{{ ucfirst($brand->name) }}</h5>
                            </div>
                        </div>
                    </a>
                @empty
                @endforelse
            </div>
        </div>
    </section>


    @if (isset($categories) && count($categories) > 0)
        <section class="mb-1">
            <div class="container">
                <h2 class="title-left text-center text-custom title-bg">Categories</h2>
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

    @if (isset($flash_sale) && count($flash_sale) > 0)
        <div class="popular-product-col-7-area rts-section-gapBottom">
            <div class="container">
                <div class="cover-card-main-over-white">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="title-area-between mb--15">
                                <h2 class="title-left">
                                    Flash Sale
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class='Featured-cards'>
                        @if (setting('site_flash_sale_img') !== null)
                            <a href="{{ route('product.flash_sale') }}">
                                <img src="{{ asset(setting('site_flash_sale_img')) }}"
                                    class="img-fluid category-cards-image" alt="Flash Sale" loading="lazy">
                            </a>
                        @endif
                        <div class="row g-4 mt--0 custom-row">
                            @forelse($flash_sale as $product)
                                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-6 custom-col">
                                    <div class="Featured-height shadow">
                                        <div class="single-shopping-card-one deals-of-day">
                                            <div class="image-and-action-area-wrapper">
                                                <a href="{{ route('product.details', $product->slug) }}"
                                                    class="thumbnail-preview">
                                                    <div class="badge">
                                                        @php
                                                            if (isset($product->flash->flash_price)) {
                                                                $d_price = $product->flash->flash_price;
                                                            } else {
                                                                $d_price = $product->new_price;
                                                            }
                                                            $per = $product->price / 100;
                                                            $amount = $product->price - $d_price;
                                                            $percentage = $amount / $per;
                                                        @endphp

                                                        @if (isset($product->flash->flash_price) || isset($product->new_price))
                                                            <span>{{ round($percentage) }}% <br>
                                                                Off
                                                            </span>
                                                            <i class="fa fa-bookmark"></i>
                                                        @endif
                                                    </div>
                                                    <img src="{{ asset(isset($product->product_image[0]) ? $product->product_image[0]->file_path : 'uploads/default.jpg') }}"
                                                        alt="grocery">
                                                </a>
                                            </div>
                                            <div class="body-content">
                                                <a href="{{ route('product.details', $product->slug) }}">
                                                    <h4 class="title">{{ ucfirst($product->name) }}</h4>
                                                </a>
                                                <div class="price-area">
                                                    <div style="display: ruby">
                                                        @if (isset($product->flash) && $product->flash->flash_price != null)
                                                            <span
                                                                class="current">৳{{ $product->flash->flash_price }}</span>
                                                            <div class="previous">৳{{ $product->price }}</div>
                                                        @elseif (isset($product->new_price))
                                                            <span class="current">৳{{ $product->new_price }}</span>
                                                            <div class="previous">৳{{ $product->price }}</div>
                                                        @else
                                                            <span class="current">৳{{ $product->price }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="pull-right">
                                                        <small>{{ $product->stock == 0 ? 'Stock Out' : 'In Stock' }}</small>
                                                    </div>
                                                </div>
                                                <div class="cart-counter-action">
                                                    <button product-id="{{ $product->id }}"
                                                        class="rts-btn btn-primary radious-sm with-icon add-cart ani-btn {{ $product->stock == 0 ? 'stock-out-btn' : '' }}"
                                                        url="{{ route('ajax.addToCart', $product->id) }}"
                                                        {{ $product->stock == 0 ? 'disabled' : ' ' }}>
                                                        <div class="btn-text">
                                                            {{ $product->stock == 0 ? 'Out of Stock' : 'Add To Cart' }}
                                                        </div>
                                                    </button>
                                                    <a href="{{ $product->stock == 0 ? 'javascript:void(0)' : route('buy_now', $product->slug) }}"
                                                        class="buy-now-btn btn-primary radious-sm {{ $product->stock == 0 ? 'stock-out-btn' : '' }}">
                                                        {{ $product->stock == 0 ? 'Out of Stock' : 'Buy Now' }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                            @endforelse

                        </div>
                        <div class="text-center mt-2">
                            <button class="view-button"><a href="{{ route('product.flash_sale') }}">View all</a></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @foreach ($category_product as $cat_product)
        @if (isset($cat_product->product) && count($cat_product->product) > 0)
            <div class="popular-product-col-7-area rts-section-gapBottom">
                <div class="container">
                    <div class="cover-card-main-over-white">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="title-area-between mb--15">
                                    <h2 class="title-left">
                                        {{ ucfirst($cat_product->name) }}
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class='Featured-cards'>
                            @if ($cat_product->banner !== null)
                                <a href="{{ route('product.category', $cat_product->slug) }}">
                                    <img src="{{ asset($cat_product->banner) }}" class="img-fluid category-cards-image"
                                        alt="{{ $cat_product->name }}" loading="lazy">
                                </a>
                            @endif
                            <div class="row g-4 mt-3 custom-row">
                                @foreach ($cat_product->product as $index => $product)
                                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-6 custom-col">
                                        <div class="Featured-height">
                                            <div class="single-shopping-card-one deals-of-day shadow-sm rounded-lg h-100">
                                                <div class="image-and-action-area-wrapper">
                                                    <a href="{{ route('product.details', $product->slug) }}"
                                                        class="thumbnail-preview">
                                                        <div class="badge">
                                                            @php
                                                                if (isset($product->flash->flash_price)) {
                                                                    $d_price = $product->flash->flash_price;
                                                                } else {
                                                                    $d_price = $product->new_price;
                                                                }
                                                                $per = $product->price / 100;
                                                                $amount = $product->price - $d_price;
                                                                $percentage = $amount / $per;
                                                            @endphp

                                                            @if (isset($product->flash->flash_price) || isset($product->new_price))
                                                                <span>{{ round($percentage) }}% Off
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <img src="{{ asset(isset($product->product_image[0]) ? $product->product_image[0]->file_path : 'uploads/default.jpg') }}"
                                                            alt="{{ $product->name }}" loading="lazy">
                                                    </a>
                                                    <div class="action-share-option">
                                                        <a class="add-list"
                                                            href="{{ route('add.favourite', $product->slug) }}">
                                                            <div class="single-action openuptip message-show-action"
                                                                data-flow="up" title="Add To Wishlist">
                                                                <i class="fa fa-heart"></i>
                                                            </div>
                                                        </a>
                                                        <a href="{{ route('product.details', $product->slug) }}">
                                                            <div class="single-action openuptip" data-flow="up"
                                                                title="Quick View" data-bs-toggle="modal"
                                                                data-bs-target="#exampleModal">
                                                                <i class="fa fa-eye"></i>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="body-content">
                                                    <a href="{{ route('product.details', $product->slug) }}">
                                                        <h4 class="title">{{ ucfirst($product->name) }}</h4>
                                                    </a>
                                                    {{-- price,rating and stock --}}
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="price-area d-flex flex-column">
                                                            @if (isset($product->flash) && $product->flash->flash_price != null)
                                                                <span
                                                                    class="current">৳{{ $product->flash->flash_price }}</span>
                                                                <div class="previous">৳{{ $product->price }}</div>
                                                            @elseif (isset($product->new_price))
                                                                <span class="current">৳{{ $product->new_price }}</span>
                                                                <div class="previous">৳{{ $product->price }}</div>
                                                            @else
                                                                <span class="current">৳{{ $product->price }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="rating-area flex-column">
                                                            {{-- rating --}}
                                                            <div>
                                                                @php
                                                                    if ($product->reviews->count() > 0) {
                                                                        $reviews = $product->reviews->where(
                                                                            'status',
                                                                            1,
                                                                        );
                                                                        $rating = round(
                                                                            $reviews->avg('rating') ?? 0,
                                                                            1,
                                                                        );
                                                                    }
                                                                @endphp
                                                                <span class="fa fa-star checked"></span>
                                                                {{ $rating ?? 0 }}
                                                            </div>
                                                            <small>{{ $product->stock == 0 ? 'Stock Out' : 'In Stock' }}</small>
                                                        </div>
                                                    </div>
                                                    <div class="cart-counter-action">
                                                        <button product-id="{{ $product->id }}"
                                                            class="rts-btn btn-primary radious-sm with-icon add-cart ani-btn {{ $product->stock == 0 ? 'stock-out-btn' : '' }}"
                                                            url="{{ route('ajax.addToCart', $product->id) }}"
                                                            {{ $product->stock == 0 ? 'disabled' : ' ' }}>
                                                            <div class="btn-text">
                                                                {{ $product->stock == 0 ? 'Out of Stock' : 'Add To Cart' }}
                                                            </div>
                                                        </button>
                                                        <a href="{{ $product->stock == 0 ? 'javascript:void(0)' : route('buy_now', $product->slug) }}"
                                                            class="buy-now-btn btn-primary radious-sm {{ $product->stock == 0 ? 'stock-out-btn' : '' }}">
                                                            {{ $product->stock == 0 ? 'Out of Stock' : 'Buy Now' }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="text-center mt-4">
                                <button class="view-button"><a
                                        href="{{ route('product.category', $cat_product->slug) }}">View all</a></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    @if (isset($featured_product) && count($featured_product) > 0)
        <div class="popular-product-col-7-area rts-section-gapBottom">
            <div class="container">
                <div class="cover-card-main-over-white">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="title-area-between mb--15 featured-title-div">
                                <h2 class="title-left">
                                    Featured Product
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class='Featured-cards'>
                        <div class="row g-4 mt--0 custom-row">
                            @forelse($featured_product as $feature_product)
                                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-6 custom-col">
                                    <div class="Featured-height">
                                        <div class="single-shopping-card-one deals-of-day shadow-sm rounded-lg h-100">
                                            <div class="image-and-action-area-wrapper">
                                                <a href="{{ route('product.details', $feature_product->slug) }}"
                                                    class="thumbnail-preview">
                                                    <div class="badge">
                                                        @php
                                                            if (isset($feature_product->flash->flash_price)) {
                                                                $d_price = $feature_product->flash->flash_price;
                                                            } else {
                                                                $d_price = $feature_product->new_price;
                                                            }
                                                            $per = $feature_product->price / 100;
                                                            $amount = $feature_product->price - $d_price;
                                                            $percentage = $amount / $per;
                                                        @endphp

                                                        @if (isset($feature_product->flash->flash_price) || isset($feature_product->new_price))
                                                            <span>{{ round($percentage) }}% <br>
                                                                Off
                                                            </span>
                                                            <i class="fa fa-bookmark"></i>
                                                        @endif
                                                    </div>
                                                    <img src="{{ asset(isset($feature_product->product_image[0]) ? $feature_product->product_image[0]->file_path : 'uploads/default.jpg') }}"
                                                        alt="{{ $feature_product->name }}" loading="lazy">
                                                </a>
                                                <div class="action-share-option">
                                                    <a class="add-list"
                                                        href="{{ route('add.favourite', $feature_product->slug) }}">
                                                        <div class="single-action openuptip message-show-action"
                                                            data-flow="up" title="Add To Wishlist">
                                                            <i class="fa fa-heart"></i>
                                                        </div>
                                                    </a>
                                                    <a href="{{ route('product.details', $feature_product->slug) }}">
                                                        <div class="single-action openuptip" data-flow="up"
                                                            title="Quick View" data-bs-toggle="modal"
                                                            data-bs-target="#exampleModal">
                                                            <i class="fa fa-eye"></i>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="body-content">

                                                <a href="{{ route('product.details', $feature_product->slug) }}">
                                                    <h4 class="title">{{ ucfirst($feature_product->name) }}</h4>
                                                </a>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="price-area d-flex flex-column">
                                                        @if (isset($feature_product->flash) && $feature_product->flash->flash_price != null)
                                                            <span
                                                                class="current">৳{{ $feature_product->flash->flash_price }}</span>
                                                            <div class="previous">৳{{ $feature_product->price }}</div>
                                                        @elseif (isset($feature_product->new_price))
                                                            <span
                                                                class="current">৳{{ $feature_product->new_price }}</span>
                                                            <div class="previous">৳{{ $feature_product->price }}</div>
                                                        @else
                                                            <span class="current">৳{{ $feature_product->price }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="rating-area flex-column">
                                                        {{-- rating --}}
                                                        <div>
                                                            @php
                                                                if ($feature_product->reviews->count() > 0) {
                                                                    $reviews = $feature_product->reviews->where(
                                                                        'status',
                                                                        1,
                                                                    );
                                                                    $rating = round($reviews->avg('rating') ?? 0, 1);
                                                                }
                                                            @endphp
                                                            <span class="fa fa-star checked"></span>
                                                            {{ $rating ?? 0 }}
                                                        </div>
                                                        <small>{{ $feature_product->stock == 0 ? 'Stock Out' : 'In Stock' }}</small>
                                                    </div>
                                                </div>
                                                <div class="cart-counter-action">
                                                    <button product-id="{{ $feature_product->id }}"
                                                        class="rts-btn btn-primary radious-sm with-icon add-cart ani-btn {{ $feature_product->stock == 0 ? 'stock-out-btn' : '' }}"
                                                        url="{{ route('ajax.addToCart', $feature_product->id) }}"
                                                        {{ $feature_product->stock == 0 ? 'disabled' : '' }}>
                                                        <div class="btn-text">
                                                            {{ $feature_product->stock == 0 ? 'Out of Stock' : 'Add To Cart' }}
                                                        </div>
                                                    </button>
                                                    <a href="{{ $feature_product->stock == 0 ? 'javascript:void(0)' : route('buy_now', $feature_product->slug) }}"
                                                        class="buy-now-btn btn-primary radious-sm {{ $feature_product->stock == 0 ? 'stock-out-btn' : '' }}">
                                                        {{ $feature_product->stock == 0 ? 'Out of Stock' : 'Buy Now' }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                            @endforelse
                        </div>
                        <div class="text-center mt-4">
                            <button class="view-button"><a href="{{ route('product.featured_sale') }}">View
                                    all</a></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('library-css')
@endpush

@push('custom-css')
    <style>
        .fa-star {
            color: #ccc;
        }

        .checked {
            color: #ffc700;
        }

        @media only screen and (max-width: 575px) {
            .owl-dots {
                display: none !important;
            }

            .featured-title-div {
                margin-bottom: -13px !important;
            }

            .category-cards-image {
                margin-bottom: -14px !important;
            }
        }

        @media (max-width: 767px) {
            .category-card {
                height: 120px;
            }

            .category-cards-image {
                margin-bottom: -14px !important;
            }

            .category-card h5 {
                font-size: 12px;
            }
        }
    </style>
@endpush

@push('library-js')
@endpush

@push('custom-js')
    <script>
        $(".owl-carousel").owlCarousel({
            loop: true,
            margin: 10,
            dots: false,
            autoplay: true,
            autoplayTimeout: 2000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 3,
                },
                600: {
                    items: 4,
                },
                1000: {
                    items: 6,
                },
            },
        });
    </script>
@endpush
