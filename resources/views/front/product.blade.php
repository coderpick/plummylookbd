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
            @if(isset($sub_categories) && count($sub_categories) > 0)
                <div class="row g-4 custom-row gy-4 mb-3 justify-content-center">
                    @forelse($sub_categories as $index=>$sub_category)
                        <div class="col-lg-2 col-md-3 col-sm-4 col-4 custom-col">
                            <div class="category-card">
                                <a href="{{ route('product.subcategory',$sub_category->slug) }}">
                                    <img src="{{ $sub_category->icon?asset($sub_category->icon): asset('uploads/default2.jpg') }}" alt="sub category" loading="lazy">
                                    <h5>{{ ucfirst($sub_category->name) }}</h5>
                                </a>
                            </div>
                        </div>
                    @empty
                    @endforelse

                </div>
            @endif
            <div class="row">
                <div class="col-lg-12 col-md-12">
                   <div class="row custom-row mb-5">
                        @forelse($products as $product)
                            <div class="col-lg-3 col-md-6 col-sm-12 col-6 custom-col">
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
                                                <img src="{{ asset(isset($product->product_image[0])?$product->product_image[0]->file_path:'uploads/default.jpg') }}" alt="{{ $product->name }}" loading="lazy">
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
                                                <button product-id="{{ $product->id }}" class="rts-btn btn-primary radious-sm with-icon add-cart ani-btn {{ ($product->stock)==0?'stock-out-btn':''}}" url="{{ route('ajax.addToCart',$product->id) }}" {{ ($product->stock)==0?'disabled': ' '}}>
                                                    <div class="btn-text">
                                                        {{ ($product->stock)==0?'Out of Stock': 'Add To Cart'}}
                                                    </div>
                                                </button>
                                                <a href="{{ $product->stock==0?'javascript:void(0)':route('buy_now', $product->slug) }}" class="buy-now-btn btn-primary radious-sm {{ $product->stock==0?'stock-out-btn':''}}">
                                                    {{ $product->stock==0?'Out of Stock':'Buy Now'}}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <h6 class="text-center">No Products Found !</h6>
                        @endforelse
                    </div>
                    {{ $products->render() }}
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
