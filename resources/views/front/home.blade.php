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

    @if(isset($flash_sale) && count($flash_sale) > 0)
        <div class="popular-product-col-7-area rts-section-gapBottom">
            <div class="container">
                <div class="cover-card-main-over-white">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="title-area-between mb--15">
                                <h2 class="title-left">
                                    Flash Sale
                                </h2>
                                <div>
                                    <button class="view-button"><a href="{{ route('product.flash_sale') }}">View all</a></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='Featured-cards'>
                        @if(setting('site_flash_sale_img') !== null)
                            <a href="{{ route('product.flash_sale') }}">
                                <img src="{{ asset(setting('site_flash_sale_img')) }}" class="img-fluid" alt="Flash Sale" loading="lazy">
                            </a>
                        @endif
                        <div class="row g-4 mt--0 custom-row">
                            @forelse($flash_sale as $product)
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
                                                    <div class="pull-right"><small>{{ ($product->stock)==0?'Stock Out': 'In Stock'}}</small></div>
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

    <section id="">
        <div class="container mobile-none rts-section-gapBottom">
            <h2 class="title-left text-center text-custom title-bg">Categories</h2>
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        @forelse($categories as $index=>$category)
                            @if ($index <= 10)
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <a href="{{ route('product.category',$category->slug) }}">
                                        <div class="tin-card cat-card">
                                            <img style="max-height: 60px" class=" " alt="" src="{{ asset($category->icon) }}"/>
                                            <h3 class="cat-title">{{ ucfirst($category->name) }}</h3>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @empty
                        @endforelse
                        @if ($index > 10)
                            <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                <a href="{{ route('front.category') }}">
                                    <div class="tin-card cat-card">
                                        <img style="max-height: 60px" class=" " alt="" src="{{ asset('uploads/more3.png') }}"/>
                                        <h3 class="cat-title">More Categories</h3>
                                    </div>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if(isset($sub_categories) && count($sub_categories) > 0)
        <section id="">
            <div class="container mobile-none rts-section-gapBottom">
                <h2 class="title-left text-center text-custom title-bg">Sub-categories</h2>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            @forelse($sub_categories as $index=>$sub)
                                @if ($index <= 11)
                                    <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                        <a href="{{ route('product.subcategory',$sub->slug) }}">
                                            <div class="tin-card cat-card">
                                                <h3 class="cat-title pt-0">{{ ucfirst($sub->name) }}</h3>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @foreach($category_product as $cat_product)
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
                                    <div>
                                        <button class="view-button"><a href="{{ route('product.category',$cat_product->slug ) }}">View all</a></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='Featured-cards'>
                            @if($cat_product->banner !== null)
                                <a href="{{ route('product.category',$cat_product->slug) }}">
                                    <img src="{{ asset($cat_product->banner) }}" class="img-fluid" alt="{{ $cat_product->name }}" loading="lazy">
                                </a>
                            @endif
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
                                                        <div class="action-share-option">
                                                            <a class="add-list" href="{{ route('add.favourite',$product->slug) }}">
                                                                <div class="single-action openuptip message-show-action" data-flow="up" title="Add To Wishlist">
                                                                    <i class="fa fa-heart"></i>
                                                                </div>
                                                            </a>
                                                            <a href="{{ route('product.details', $product->slug) }}">
                                                                <div class="single-action openuptip" data-flow="up" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                    <i class="fa fa-eye"></i>
                                                                </div>
                                                            </a>
                                                        </div>
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
                                                            <div class="pull-right"><small>{{ ($product->stock)==0?'Stock Out': 'In Stock'}}</small></div>
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

    @if(isset($featured_product) && count($featured_product) > 0)
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
                                            <div class="action-share-option">
                                                <a class="add-list" href="{{ route('add.favourite',$product->slug) }}">
                                                    <div class="single-action openuptip message-show-action" data-flow="up" title="Add To Wishlist">
                                                        <i class="fa fa-heart"></i>
                                                    </div>
                                                </a>
                                                <a href="{{ route('product.details', $product->slug) }}">
                                                    <div class="single-action openuptip" data-flow="up" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                        <i class="fa fa-eye"></i>
                                                    </div>
                                                </a>
                                            </div>
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
                                                <div class="pull-right"><small>{{ ($product->stock)==0?'Stock Out': 'In Stock'}}</small></div>
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
