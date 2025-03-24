@extends('layouts.frontend.master')

@section('content')
    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                    <div class="owl-carousel slider-carousel">
                        @forelse($sliders as $id=>$slider)
                            <div class="item">
                                <div class="">
                                    @isset($slider->link)
                                        <a href="{{ $slider->link }}" target="_blank">
                                            @endisset
                                            <img style="max-height: 435px; object-fit: cover" class="" src="{{ asset($slider->image) }}" alt="">
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


    {{--@if(isset($flash_sale) && count($flash_sale) > 0)
        <div class="popular-product-col-7-area rts-section-gapBottom">
            <div class="container">
                <div class="cover-card-main-over-white">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="title-area-between mb--15">
                                <h2 class="title-left">
                                    Flash Sale Product
                                </h2>
                                <div>
                                    <button class="view-button"><a href="{{ route('product.flash_sale') }}">View all</a></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='Featured-cards'>
                        <div class="row g-4 mt--0 custom-row">
                            @forelse($flash_sale as $product)
                                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 custom-col">
                                    <div class="Featured-height">
                                        <div class="single-shopping-card-one deals-of-day">
                                            <div class="image-and-action-area-wrapper">
                                                <a href="{{ route('product.details', $product->slug) }}" class="thumbnail-preview">
                                                    <div class="badge">
                                                        @php
                                                            if(isset($product->flash->flash_price)){
                                                            $d_price = $product->flash->flash_price;
                                                            }
                                                            else{
                                                            $d_price = $product->new_price;
                                                            }
                                                            $per = $product->price/100 ;
                                                            $amount = $product->price - $d_price ;
                                                            $percentage =$amount / $per ;
                                                        @endphp

                                                        @if(isset($product->flash->flash_price) || isset($product->new_price))

                                                            <span>{{ round($percentage) }}% <br>
                                                Off
                                            </span>
                                                            <i class="fa fa-bookmark"></i>
                                                        @endif

                                                    </div>
                                                    <img src="{{ asset(isset($product->product_image[0])?$product->product_image[0]->file_path:'uploads/default.jpg') }}" alt="grocery">
                                                </a>
                                            </div>
                                            <div class="body-content">

                                                <a href="{{ route('product.details', $product->slug) }}">
                                                    <h4 class="title">{{ ucfirst($product->name) }}</h4>
                                                </a>
                                                <div class="price-area">
                                                    @if (isset($product->flash) && $product->flash->flash_price != null)
                                                        <span class="current">৳{{ $product->flash->flash_price }}</span>
                                                        <div class="previous">৳{{ $product->price }}</div>
                                                    @elseif (isset($product->new_price))
                                                        <span class="current">৳{{ $product->new_price }}</span>
                                                        <div class="previous">৳{{ $product->price }}</div>
                                                    @else
                                                        <span class="current">৳{{ $product->price }}</span>
                                                    @endif
                                                </div>
                                                <div class="cart-counter-action">
                                                    <button product-id="{{ $product->id }}" class="rts-btn btn-primary radious-sm with-icon add-cart ani-btn" url="{{ route('ajax.addToCart',$product->id) }}" {{ ($product->stock)==0?'disabled': ' '}}>
                                                        <div class="btn-text">
                                                            {{ ($product->stock)==0?'Out of Stock': 'Add To Cart'}}

                                                        </div>
                                                        <div class="arrow-icon">
                                                            <i class="fa fa-shopping-cart"></i>
                                                        </div>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="popular-product-col-7-area rts-section-gapBottom">
        <div class="container">
            <div class="cover-card-main-over-white">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="title-area-between mb--15">
                            <h2 class="title-left">
                                Featured Product
                            </h2>
                            <div>
                                <button class="view-button"><a href="{{ route('product.featured_sale') }}">View all</a></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='Featured-cards'>
                    <div class="row g-4 mt--0 custom-row">
                        @forelse($featured_product as $product)
                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 custom-col">
                                <div class="Featured-height">
                                    <div class="single-shopping-card-one deals-of-day">
                                        <div class="image-and-action-area-wrapper">
                                            <a href="{{ route('product.details', $product->slug) }}" class="thumbnail-preview">
                                                <div class="badge">
                                                    @php
                                                        if(isset($product->flash->flash_price)){
                                                        $d_price = $product->flash->flash_price;
                                                        }
                                                        else{
                                                        $d_price = $product->new_price;
                                                        }
                                                        $per = $product->price/100 ;
                                                        $amount = $product->price - $d_price ;
                                                        $percentage =$amount / $per ;
                                                    @endphp

                                                    @if(isset($product->flash->flash_price) || isset($product->new_price))

                                                        <span>{{ round($percentage) }}% <br>
                                                Off
                                            </span>
                                                        <i class="fa fa-bookmark"></i>
                                                    @endif

                                                </div>
                                                <img src="{{ asset(isset($product->product_image[0])?$product->product_image[0]->file_path:'uploads/default.jpg') }}" alt="grocery">
                                            </a>
                                        </div>
                                        <div class="body-content">

                                            <a href="{{ route('product.details', $product->slug) }}">
                                                <h4 class="title">{{ ucfirst($product->name) }}</h4>
                                            </a>
                                            <div class="price-area">
                                                @if (isset($product->flash) && $product->flash->flash_price != null)
                                                    <span class="current">৳{{ $product->flash->flash_price }}</span>
                                                    <div class="previous">৳{{ $product->price }}</div>
                                                @elseif (isset($product->new_price))
                                                    <span class="current">৳{{ $product->new_price }}</span>
                                                    <div class="previous">৳{{ $product->price }}</div>
                                                @else
                                                    <span class="current">৳{{ $product->price }}</span>
                                                @endif
                                            </div>
                                            <div class="cart-counter-action">
                                                <button product-id="{{ $product->id }}" class="rts-btn btn-primary radious-sm with-icon add-cart ani-btn" url="{{ route('ajax.addToCart',$product->id) }}" {{ ($product->stock)==0?'disabled': ' '}}>
                                                    <div class="btn-text">
                                                        {{ ($product->stock)==0?'Out of Stock': 'Add To Cart'}}

                                                    </div>
                                                    <div class="arrow-icon">
                                                        <i class="fa fa-shopping-cart"></i>
                                                    </div>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </div>--}}

    @foreach($category_product as $cat_product)
        @if (isset($cat_product->home_product) && count($cat_product->home_product) > 0)
            <div class="popular-product-col-7-area rts-section-gapBottom">
                <div class="container">
                    <div class="cover-card-main-over-white">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="title-area-between mb--15">
                                    <h2 class="title-left">
                                        {{ ucfirst($cat_product->name) }}
                                    </h2>
                                    <div>
                                        <button class="view-button"><a href="{{ route('merchant.product',$cat_product->slug ) }}">View all</a></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='Featured-cards'>
                            <div class="row g-4 mt--0 custom-row">
                                @foreach($cat_product->product as $index=>$product)
                                    @if($index <=3)
                                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-6 custom-col">
                                            <div class="Featured-height">
                                                <div class="single-shopping-card-one deals-of-day">
                                                    <div class="image-and-action-area-wrapper">
                                                        <a href="{{ route('product.details', $product->slug) }}" class="thumbnail-preview">
                                                            <div class="badge">
                                                                @php
                                                                    if(isset($product->flash->flash_price)){
                                                                    $d_price = $product->flash->flash_price;
                                                                    }
                                                                    else{
                                                                    $d_price = $product->new_price;
                                                                    }
                                                                    $per = $product->price/100 ;
                                                                    $amount = $product->price - $d_price ;
                                                                    $percentage =$amount / $per ;
                                                                @endphp

                                                                @if(isset($product->flash->flash_price) || isset($product->new_price))

                                                                    <span>{{ round($percentage) }}% <br>
                                                Off
                                            </span>
                                                                    <i class="fa fa-bookmark"></i>
                                                                @endif

                                                            </div>
                                                            <img src="{{ asset(isset($product->product_image[0])?$product->product_image[0]->file_path:'uploads/default.jpg') }}" alt="grocery">
                                                        </a>
                                                    </div>
                                                    <div class="body-content">

                                                        <a href="{{ route('product.details', $product->slug) }}">
                                                            <h4 class="title">{{ ucfirst($product->name) }}</h4>
                                                        </a>
                                                        <div class="price-area">
                                                            <div style="display: ruby">
                                                                @if (isset($product->flash) && $product->flash->flash_price != null)
                                                                    <span class="current">৳{{ $product->flash->flash_price }}</span>
                                                                    <div class="previous">৳{{ $product->price }}</div>
                                                                @elseif (isset($product->new_price))
                                                                    <span class="current">৳{{ $product->new_price }}</span>
                                                                    <div class="previous">৳{{ $product->price }}</div>
                                                                @else
                                                                    <span class="current">৳{{ $product->price }}</span>
                                                                @endif
                                                            </div>
                                                            <div class="pull-right">P- {{ $product->point??0 }}</div>
                                                        </div>
                                                        <div class="cart-counter-action">
                                                            <button product-id="{{ $product->id }}" class="rts-btn btn-primary radious-sm with-icon add-cart ani-btn" url="{{ route('ajax.addToCart',$product->id) }}" {{ ($product->stock)==0?'disabled': ' '}}>
                                                                <div class="btn-text">
                                                                    {{ ($product->stock)==0?'Out of Stock': 'Add To Cart'}}

                                                                </div>
                                                                <div class="arrow-icon">
                                                                    <i class="fa fa-shopping-cart"></i>
                                                                </div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach


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
    </style>
@endpush

@push('library-js')
@endpush

@push('custom-js')
@endpush
