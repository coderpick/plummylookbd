@extends('layouts.frontend.master')

@section('content')
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-5">
                    <div class="img-wrap">
                        <div class="col-lg-12">

                            <div class="img-main">
                                <img style="max-width: 450px; max-height: 300px" id="imgZoom" src="{{ asset($product->product_image[0]->file_path) }}" data-zoom-image="{{ asset($product->product_image[0]->file_path) }}"/>
                            </div>

                        </div>
                        <div id="gallery" class="img-cont">
                            <div class="row">
                                @foreach($product->product_image as $image)
                                <div class="col-lg-4">
                                    <a href="#" data-image="{{ asset($image->file_path) }}" data-zoom-image="{{ asset($image->file_path) }}">
                                        <img style="max-width: 100px;" src="{{ asset($image->file_path) }}" />
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-7">
                    <div class="product__details__text">
                        @php
                            $date = \Carbon\Carbon::today()->toDateString();
                        @endphp
                        <h3 style="margin-bottom: unset">{{ ucfirst($product->name) }}</h3>

                        @if($product->sub_category_id != null)
                            <p style="margin-bottom: 10px"><a style="color: black" href="{{ route('product.category',$product->category->slug) }}">{{ ucfirst($product->category->name) }}</a><i class="icofont-caret-right"></i><a
                                    style="color: black" href="{{ route('product.subcategory',$subcategory->slug) }}">{{ ucfirst($subcategory->name) }}</a></p>
                        @else
                            <p style="margin-bottom: 10px"><a style="color: black" href="{{ route('product.category',$product->category->slug) }}">{{ ucfirst($product->category->name) }}</a></p>
                        @endif

                        @if (isset($product->flash) && $product->flash->flash_price != null)
                            <div class="product__details__price"><del class="text-black-50"> {{ $product->price }}</del>  {{ $product->flash->flash_price }} </div>
                        @elseif ($product->new_price != null)
                            <div class="product__details__price"><del class="text-black-50"> {{ $product->price }}</del>  {{ $product->new_price }} </div>
                        @else
                            <div class="product__details__price"> {{ $product->price }} </div>
                        @endif
                        <ul>
                            <li><b>Availability</b> {{ ($product->stock)==0?'Out of Stock': 'In Stock'}}</li>
                            <li><b>Brand</b> <span class="text-capitalize">{{ Str::lower($product->brand->name) }}</span></li>
                            @isset($product->size)
                            <li><b>Weight/Size</b> <span>{{ $product->size }}</span></li>
                            @endisset
                            @isset($product->color)
                                <li><b>Color</b> <span>{{ ucfirst($product->color) }}</span></li>
                            @endisset
                        </ul>
                        <br>
                        <div>
                            <form style="display: inline" action="{{ route('add.cart',$product->id) }}" method="post">
                                @csrf
                                <div class="product__details__quantity">
                                    <div class="quantity">
                                        <div class="pro-qty">
                                            <input type="text" name="quantity" value="1">
                                        </div>
                                    </div>
                                </div>
                                <button style="border: none" class="primary-btn dtl_cart_btn" {{ ($product->stock)==0?'disabled': ' '}} > {{ ($product->stock)==0?'Out of Stock': 'Add To Cart'}}</button>
                            </form>
                            <a href="#" class="primary-btn dtl_cart_btn text-white">Buy Now</a>
                            <form style="display: inline" action="{{ route('add.favourite',$product->slug) }}" method="get">
                                @csrf
                                <button class="btn btn-outline-secondary qtform"><span class="icon_heart_alt"></span></button>
                            </form>
                        </div>

                        <hr>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="product__details__tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"
                                   aria-selected="true">Description</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>Product Description</h6>
                                    @if (isset($product->details))
                                        <p> {!! $product->details !!}</p>
                                     @else
                                        <p>Description Not Available</p>
                                    @endif

                                </div>
                            </div>
                        </div>



                        @if(isset($related_product) && count($related_product) > 0)
                            <div class="popular-product-col-7-area rts-section-gapBottom mt-5">
                                <div class="container">
                                    <div class="cover-card-main-over-white">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="title-area-between mb--15">
                                                    <h2 class="title-left">
                                                        Related Product
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='Featured-cards'>
                                            <div class="row g-4 mt--0 custom-row">
                                                @forelse($related_product as $product)
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
                                                                        <button product-id="{{ $product->id }}" class="rts-btn btn-primary radious-sm with-icon add-cart ani-btn {{ ($product->stock)==0?'stock-out-btn':''}}" url="{{ route('ajax.addToCart',$product->id) }}" {{ ($product->stock)==0?'disabled': ' '}}>
                                                                            <div class="btn-text">
                                                                                {{ ($product->stock)==0?'Out of Stock': 'Add To Cart'}}
                                                                            </div>
                                                                        </button>
                                                                        <a href="#" class="buy-now-btn btn-primary radious-sm">
                                                                            Buy Now
                                                                        </a>
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
        /*css for existing review*/
        .message {
            border-radius: 5px;
            padding: 10px;
            margin: 10px 0;
        }
        .message::after {
            content: "";
            clear: both;
            display: table;
        }

        .message img {
            float: left;
            max-width: 60px;
            width: 100%;
            margin-right: 20px;
            border-radius: 50%;
        }

        .fa-star {
            color: #ccc;
        }
        .checked {
            color: #ffc700;
        }

        #more {display: none;}
        .more-btn{
            margin-left: 40%;
            border: none;
            color: #c0c0c1;
            margin-bottom: 10px;
        }
        .more-btn:hover{
            background-color: transparent !important;
        }


        /*css for radio button star*/
        div.stars {
            display: inline-block;
        }

        input.star { display: none; }

        label.star {
            float: right;
            padding: 3px;
            font-size: 20px;
            color: #444;
            transition: all .2s;
        }

        input.star:checked ~ label.star:before {
            content: '\f005';
            color: #FD4;
            transition: all .25s;
        }

        input.star-5:checked ~ label.star:before {
            color: #FE7;
            text-shadow: 0 0 20px #952;
        }

        input.star-1:checked ~ label.star:before { color: #F62; }

        label.star:hover { transform: rotate(-15deg) scale(1.3); }

        label.star:before {
            content: '\f006';
            font-family: FontAwesome;
        }


        /*css for review area design*/
        .pr-review{
            background-color: #f4f4f4;
            padding: 3rem 2rem 3.5rem;
        }
    </style>
@endpush

@push('library-js')
@endpush

@push('custom-js')
    @if($expires_at >= $date)
    <script>

        var expires = '{{ $expires_at }}';

        if(expires == null){
            var expires = '2021-12-31';
        }

        // Set the date we're counting down to
        var countDownDate = new Date(expires).getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Output the result in an element with id="demo"
            document.getElementById("demo").innerHTML = days+"d " + ": " + hours + ": "
                + minutes + ": " + seconds;

            // If the count down is over, write some text
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("demo").innerHTML = "Expired";
            }
        }, 1000);
    </script>
    @endif

    <script>
        function myFunction() {
            var dots = document.getElementById("dots");
            var moreText = document.getElementById("more");
            var btnText = document.getElementById("moreBtn");

            if (dots.style.display === "none") {
                dots.style.display = "inline";
                btnText.innerHTML = "Show more <i class=\"fa fa-angle-down\"></i>";
                moreText.style.display = "none";
            } else {
                dots.style.display = "none";
                btnText.innerHTML = "Show less <i class=\"fa fa-angle-up\"></i>";
                moreText.style.display = "inline";
            }
        }
    </script>
@endpush
