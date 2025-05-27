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
                                <!-- <div class="product__item tin-card">
                <a href="{{ route('product.details', $product->slug) }}">
                    @if(Request::is('sale'))
                                    <span class="new">Sale</span>
@endif
                                <div class="product__item__pic set-bg">

                                    <img src="{{ asset(isset($product->product_image[0])?$product->product_image[0]->file_path:'uploads/default.jpg') }}" alt="image">


                        {{--<ul class="product__item__pic__hover">
                                    <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                    <li><a href="#"><i class="fa fa-shopping-cart add-cart"></i></a></li>
                                </ul>--}}
                                </div>
                                <div class="product__item__text">
                                    <h6>{{ ucfirst($product->name) }}</h6>
                        {{--@php
                                    $rating = $product->reviews->sum('rating');
                                    $count = count($product->reviews);
                                    if($count > 0){
                                        $rating = $rating / $count;
                                    }
                                $rating = round($rating);
                                @endphp

                                @if($rating == 0)
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                @endif
                                @if($rating == 1)
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                @endif
                                @if($rating == 2)
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                @endif
                                @if($rating == 3)
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                @endif
                                @if($rating == 4)
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star"></span>
                                @endif
                                @if($rating >= 5)
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                @endif--}}
                                @if (isset($product->flash) && $product->flash->flash_price != null)
                                    <h5><del class="text-black-50"><small>{{ $product->price }}</small></del>  {{ $product->flash->flash_price }}</h5>
                        @elseif (isset($product->new_price))
                                    <h5><del class="text-black-50"><small>৳{{ $product->price }}</small></del> ৳ {{ $product->new_price }}</h5>
                        @else
                                    <h5>৳ {{ $product->price }}</h5>
                        @endif
                                {{--<h5>৳ {{ isset($product->new_price)? $product->new_price : $product->price }}</h5>--}}
                                </div>
                            </a>
                            <div class="text-center">
                                <button type="button" class="btn w-75 add-cart ani-btn" product-id="{{ $product->id }}" url="{{ route('ajax.addToCart',$product->id) }}" {{ ($product->stock)==0?'disabled': ' '}}> {{ ($product->stock)==0?'Out of Stock': 'Add To Cart'}} </button>
                </div>
            </div> -->
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
