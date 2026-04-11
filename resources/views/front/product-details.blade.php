@extends('layouts.frontend.master')

@section('content')
    <section class="product-details spad">
        <div class="container">
            {{-- product info --}}
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-5 col-md-5">
                            <div class="img-wrap">
                                <div class="col-lg-12">

                                    <div class="img-main">
                                        <img style="width: 100%; max-height: 300px" id="imgZoom"
                                            src="{{ asset($product->product_image[0]->file_path) }}"
                                            alt="{{ $product->name }}"
                                            data-zoom-image="{{ asset($product->product_image[0]->file_path) }}" />
                                    </div>

                                </div>
                                <div id="gallery" class="img-cont">
                                    <div class="row">
                                        @foreach ($product->product_image as $image)
                                            <div class="col-lg-4">
                                                <a href="#" data-image="{{ asset($image->file_path) }}"
                                                    data-zoom-image="{{ asset($image->file_path) }}">
                                                    <img style="max-width: 100px;" src="{{ asset($image->file_path) }}"
                                                        alt="{{ $product->name }}" loading="lazy">
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
                                <h1>{{ ucfirst($product->name) }}</h1>
                                @php
                                    $ratingValue = $rating ?? 0;
                                    $fullStars = floor($ratingValue);
                                    $halfStar = $ratingValue - $fullStars >= 0.5;
                                    $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                @endphp

                                <div class="rating">
                                    {{-- Full stars --}}
                                    @for ($i = 1; $i <= $fullStars; $i++)
                                        <span class="fa fa-star checked"></span>
                                    @endfor

                                    {{-- Half star --}}
                                    @if ($halfStar)
                                        <span class="fa fa-star-half-o checked"></span>
                                    @endif

                                    {{-- Empty stars --}}
                                    @for ($i = 1; $i <= $emptyStars; $i++)
                                        <span class="fa fa-star"></span>
                                    @endfor
                                    {{-- <span>{{ number_format($ratingValue, 1) }}</span> --}}
                                    <span>({{ number_format($reviews->count()) }})</span>
                                </div>
                                {{-- product price --}}
                                <div class="product__details__price">
                                    @if (isset($product->flash) && $product->flash->flash_price != null)
                                        <strong class="text-danger">{{ $product->flash->flash_price }}</strong>
                                        <del class="text-muted small ms-2">{{ $product->price }}</del>
                                    @elseif ($product->new_price != null)
                                        <strong class="text-danger">{{ $product->new_price }}</strong>
                                        <del class="text-muted small ms-2">{{ $product->price }}</del>
                                    @else
                                         <strong>{{ $product->price }}</strong>
                                    @endif
                                </div>
                                <ul>
                                    <li><b>Availability</b> {{ $product->stock == 0 ? 'Out of Stock' : 'In Stock' }}</li>
                                    <li><b>Brand</b> <span
                                            class="text-capitalize">{{ Str::lower($product->brand->name) }}</span>
                                    </li>
                                    @isset($product->size)
                                        <li><b>Weight/Size</b> <span>{{ $product->size }}</span></li>
                                    @endisset
                                    @isset($product->color)
                                        <li><b>Color</b> <span>{{ ucfirst($product->color) }}</span></li>
                                    @endisset
                                    <li><b>Category</b>
                                        @if ($product->sub_category_id != null)
                                            <a class="text-semi-black"
                                                href="{{ route('product.category', $product->category?->slug) }}">
                                                {{ ucfirst($product->category?->name) }}
                                            </a>
                                            <span>/</span>
                                            <a class="text-semi-black"
                                                href="{{ route('product.subcategory', $subcategory->slug) }}">
                                                {{ ucfirst($subcategory->name) }}
                                            </a>
                                        @else
                                            <a class="text-semi-black"
                                                href="{{ route('product.category', $product->category?->slug) }}">{{ ucfirst($product->category?->name) }}</a>
                                        @endif
                                    </li>
                                    @isset($product->made_in)
                                        <li><b>Made In</b> <span>{{ ucfirst($product->made_in) }}</span></li>
                                    @endisset
                                </ul>
                                <br>
                                <div>
                                    <form style="display: inline" action="{{ route('add.cart', $product->id) }}"
                                        method="post">
                                        @csrf
                                        <div class="product__details__quantity">
                                            <div class="quantity">
                                                <div class="pro-qty">
                                                    <input type="text" name="quantity" value="1">
                                                </div>
                                            </div>
                                        </div>
                                        <button style="border: none" class="primary-btn dtl_cart_btn"
                                            {{ $product->stock == 0 ? 'disabled' : ' ' }}>
                                            {{ $product->stock == 0 ? 'Out of Stock' : 'Add To Cart' }}</button>
                                    </form>
                                    <a href="{{ $product->stock == 0 ? 'javascript:void(0)' : route('buy_now', $product->slug) }}"
                                        class="primary-btn dtl_cart_btn text-white {{ $product->stock == 0 ? 'stock-out-btn' : '' }}">
                                        {{ $product->stock == 0 ? 'Out of Stock' : 'Buy Now' }}
                                    </a>
                                    <form style="display: inline" action="{{ route('add.favourite', $product->slug) }}"
                                        method="get">
                                        @csrf
                                        <button class="btn btn-outline-secondary qtform"><span
                                                class="icon_heart_alt"></span></button>
                                    </form>
                                </div>
                                <hr>
                                <div class="pb-2">
                                    <strong>Tags:</strong>
                                    @forelse ($product->tags as $tag)
                                        <a class="badge badge-purple"
                                            href="{{ route('tag_product', $tag->slug) }}">{{ $tag->name }}</a>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- product description --}}
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="product__details__tab">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"
                                            aria-selected="true">Description</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab"
                                            aria-selected="false">Reviews & Rating</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                        <div class="product__details__tab__desc">
                                            @if (isset($product->details))
                                                <p> {!! $product->details !!}</p>
                                            @else
                                                <p>Description Not Available</p>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabs-2" role="tabpanel">
                                        <div class="product__details__tab__desc">
                                            {{-- Product reviews --}}
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <div class="{{ $reviews->count() > 4 ? 'overflow-auto' : '' }}"
                                                        style="max-height: 580px">

                                                        @forelse($reviews as $index => $review)
                                                            <div
                                                                class="message {{ $index >= 4 ? 'd-none more-review' : '' }}">
                                                                <div class="media">
                                                                    <img style="max-width: 48px; max-height: 48px"
                                                                        class="mr-3"
                                                                        src="{{ asset(optional($review->user)->image ?? 'uploads/user_default.jpg') }}">
                                                                    <div class="media-body">
                                                                        <div
                                                                            class="d-flex justify-content-between align-items-center">
                                                                            <div>
                                                                                <h5 class="mt-0">
                                                                                    {{ ucfirst($review->name) }}
                                                                                </h5>
                                                                                {{-- Rating stars --}}
                                                                                @for ($i = 1; $i <= 5; $i++)
                                                                                    <span
                                                                                        class="fa fa-star {{ $i <= $review->rating ? 'checked' : '' }}"></span>
                                                                                @endfor
                                                                                <p class="text-justify mt-2">
                                                                                    {{ ucfirst($review->review) }}
                                                                                </p>
                                                                            </div>
                                                                            <div>
                                                                                <p class="text-muted">
                                                                                    {{ date('M d, Y', strtotime($review->created_at)) }}
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @empty
                                                            <h5 class="text-center">No Review Available</h5>
                                                        @endforelse

                                                        @if ($reviews->count() > 4)
                                                            <button onclick="toggleReviews()"
                                                                class="btn btn-outline-light more-btn mt-3"
                                                                id="moreBtn">
                                                                Show more <i class="fa fa-angle-down"></i>
                                                            </button>
                                                        @endif
                                                    </div>

                                                </div>
                                                <div class="col-md-5">
                                                    <div class="pr-review">
                                                        <form action="{{ route('review.store') }}" method="post">
                                                            @csrf
                                                            <h4>Add a Review</h4>
                                                            <br>
                                                            <br>
                                                            <div class="row">
                                                                <input type="hidden" name="product"
                                                                    value="{{ $product->id }}">
                                                                <input type="hidden" name="shop"
                                                                    value="{{ $product->shop_id }}">
                                                                <div class="col-md-12">
                                                                    <h6 class="m-0">Your Rating</h6>
                                                                    <div class="stars">
                                                                        <input class="star star-5" id="star-5"
                                                                            type="radio" title="Excellent"
                                                                            value="5" name="star" />
                                                                        <label class="star star-5" for="star-5"></label>
                                                                        <input class="star star-4" id="star-4"
                                                                            type="radio" title="Very Good"
                                                                            value="4" name="star" />
                                                                        <label class="star star-4" for="star-4"></label>
                                                                        <input class="star star-3" id="star-3"
                                                                            type="radio" title="Good" value="3"
                                                                            name="star" />
                                                                        <label class="star star-3" for="star-3"></label>
                                                                        <input class="star star-2" id="star-2"
                                                                            type="radio" title="Fair" value="2"
                                                                            name="star" />
                                                                        <label class="star star-2" for="star-2"></label>
                                                                        <input class="star star-1" id="star-1"
                                                                            type="radio" title="Poor" value="1"
                                                                            name="star" />
                                                                        <label class="star star-1" for="star-1"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br>

                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <h6 class="mb-3">Your Review <span
                                                                            style="font-size: 10px">(Maximum 250
                                                                            Character)</span>
                                                                    </h6>
                                                                    <textarea name="review" class="form-control" id="" cols="10" rows="8"
                                                                        placeholder="Write your review here..." required></textarea>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="text-right">
                                                                <button type="submit" class="btn-lg site-btn"><i
                                                                        class="fa fa-lg fa-fw fa-paper-plane"></i></button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- related product --}}
            @if (isset($related_product) && count($related_product) > 0)
                <div class="popular-product-col-7-area rts-section-gapBottom mt-5">
                    <div class="cover-card-main-over-white shadow-sm">
                        <div class="title-area-between mb--15">
                            <h2 class="title-left">
                                Related Product
                            </h2>
                        </div>
                        <div class='Featured-cards'>
                            <div class="row g-4 mt--0 custom-row">
                                @forelse($related_product as $relatedProduct)
                                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-6 custom-col">
                                        <div class="Featured-height">
                                            <div class="single-shopping-card-one deals-of-day">
                                                <div class="image-and-action-area-wrapper">
                                                    <a href="{{ route('product.details', $relatedProduct->slug) }}"
                                                        class="thumbnail-preview">
                                                        <div class="badge">
                                                            @php
                                                                if (isset($relatedProduct->flash->flash_price)) {
                                                                    $d_price = $relatedProduct->flash->flash_price;
                                                                } else {
                                                                    $d_price = $relatedProduct->new_price;
                                                                }
                                                                $per = $relatedProduct->price / 100;
                                                                $amount = $relatedProduct->price - $d_price;
                                                                $percentage = $amount / $per;
                                                            @endphp

                                                            @if (isset($relatedProduct->flash->flash_price) || isset($relatedProduct->new_price))
                                                                <span>{{ round($percentage) }}% Off
                                                                </span>
                                                            @endif
                                                        </div>


                                                        <img src="{{ asset(isset($relatedProduct->product_image[0]) ? $relatedProduct->product_image[0]->file_path : 'uploads/default.jpg') }}"
                                                            alt="grocery">
                                                    </a>
                                                    <div class="action-share-option">
                                                        <a class="add-list"
                                                            href="{{ route('add.favourite', $relatedProduct->slug) }}">
                                                            <div class="single-action openuptip message-show-action"
                                                                data-flow="up" title="Add To Wishlist">
                                                                <i class="fa fa-heart"></i>
                                                            </div>
                                                        </a>
                                                        <a href="{{ route('product.details', $relatedProduct->slug) }}">
                                                            <div class="single-action openuptip" data-flow="up"
                                                                title="Quick View" data-bs-toggle="modal"
                                                                data-bs-target="#exampleModal">
                                                                <i class="fa fa-eye"></i>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="body-content">

                                                    <a href="{{ route('product.details', $relatedProduct->slug) }}">
                                                        <h4 class="title">
                                                            {{ ucfirst($relatedProduct->name) }}
                                                        </h4>
                                                    </a>
                                                    {{-- price,rating and stock --}}
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="price-area d-flex flex-column">
                                                            @if (isset($relatedProduct->flash) && $relatedProduct->flash->flash_price != null)
                                                                <span
                                                                    class="current">৳{{ $relatedProduct->flash->flash_price }}</span>
                                                                <div class="previous">৳{{ $relatedProduct->price }}</div>
                                                            @elseif (isset($relatedProduct->new_price))
                                                                <span
                                                                    class="current">৳{{ $relatedProduct->new_price }}</span>
                                                                <div class="previous">৳{{ $relatedProduct->price }}</div>
                                                            @else
                                                                <span class="current">৳{{ $relatedProduct->price }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="rating-area flex-column">
                                                            {{-- rating --}}
                                                            <div>
                                                                @php
                                                                    if ($relatedProduct->reviews->count() > 0) {
                                                                        $reviews = $relatedProduct->reviews->where(
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
                                                            <small>{{ $relatedProduct->stock == 0 ? 'Stock Out' : 'In Stock' }}</small>
                                                        </div>
                                                    </div>
                                                    <div class="cart-counter-action">
                                                        <button product-id="{{ $relatedProduct->id }}"
                                                            class="rts-btn btn-primary radious-sm with-icon add-cart ani-btn {{ $relatedProduct->stock == 0 ? 'stock-out-btn' : '' }}"
                                                            url="{{ route('ajax.addToCart', $relatedProduct->id) }}"
                                                            {{ $relatedProduct->stock == 0 ? 'disabled' : ' ' }}>
                                                            <div class="btn-text">
                                                                {{ $relatedProduct->stock == 0 ? 'Out of Stock' : 'Add To Cart' }}
                                                            </div>
                                                        </button>
                                                        <a href="{{ $relatedProduct->stock == 0 ? 'javascript:void(0)' : route('buy_now', $relatedProduct->slug) }}"
                                                            class="buy-now-btn btn-primary radious-sm {{ $relatedProduct->stock == 0 ? 'stock-out-btn' : '' }}">
                                                            {{ $relatedProduct->stock == 0 ? 'Out of Stock' : 'Buy Now' }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <h6 class="text-center">No related product found !</h6>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

@endsection

@php
    if (isset($product->flash) && $product->flash->flash_price != null) {
        $price = $product->flash->flash_price;
    } elseif ($product->new_price) {
        $price = $product->new_price;
    } else {
        $price = $product->price;
    }

    $imagePath = asset($product->product_image->first()->file_path);
@endphp


@push('product_price_schema')
    <meta property="product:brand" content="PlummyLook">
    <meta property="product:availability" content="In Stock">
    <meta property="product:price:amount" content="{{ $product->price ?? 0 }}">
    <meta property="product:price:currency" content="BDT">
    <meta property="product:sale_price:amount" content="{{ $product->new_price ?? $product->price }}" />
    <meta property="product:sale_price:currency" content="BDT" />

    <script type="application/ld+json">
        {!! json_encode([
            "@context" => "https://schema.org",
            "@type" => "Product",
            "name" => $product->name,
            "image" => asset($imagePath),
            "description" => strip_tags($description),
            "brand" => [
                "@type" => "Brand",
                "name" => optional($product->brand)->name
            ],
            "offers" => [
                "@type" => "Offer",
                "url" => route('product.details', $product->slug),
                "priceCurrency" => "BDT",
                "price" => (string) intval($price),
                "availability" => "https://schema.org/InStock"
            ]
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush
@push('library-css')
@endpush

@push('datalayer')
@php
    if (isset($product->flash) && $product->flash->flash_price != null) {
        $dl_price = (float) $product->flash->flash_price;
    } elseif ($product->new_price) {
        $dl_price = (float) $product->new_price;
    } else {
        $dl_price = (float) $product->price;
    }
@endphp
<script>
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({ ecommerce: null }); // Clear previous ecommerce data
    window.dataLayer.push({
        event: 'view_item',
        ecommerce: {
            currency: 'BDT',
            value: {{ $dl_price }},
            items: [{
                item_id: '{{ $product->id }}',
                item_name: @json($product->name),
                item_brand: @json(optional($product->brand)->name ?? ''),
                item_category: @json(optional($product->category)->name ?? ''),
                price: {{ $dl_price }},
                quantity: 1
            }]
        }
    });
</script>
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

        #more {
            display: none;
        }

        .more-btn {
            margin-left: 40%;
            border: none;
            color: #c0c0c1;
            margin-bottom: 10px;
        }

        .more-btn:hover {
            background-color: transparent !important;
        }


        /*css for radio button star*/
        div.stars {
            display: inline-block;
        }

        input.star {
            display: none;
        }

        label.star {
            float: right;
            padding: 3px;
            font-size: 20px;
            color: #444;
            transition: all .2s;
        }

        input.star:checked~label.star:before {
            content: '\f005';
            color: #FD4;
            transition: all .25s;
        }

        input.star-5:checked~label.star:before {
            color: #FE7;
            text-shadow: 0 0 20px #952;
        }

        input.star-1:checked~label.star:before {
            color: #F62;
        }

        label.star:hover {
            transform: rotate(-15deg) scale(1.3);
        }

        label.star:before {
            content: '\f006';
            font-family: FontAwesome;
        }


        /*css for review area design*/
        .pr-review {
            background-color: #f4f4f4;
            padding: 3rem 2rem 3.5rem;
        }
    </style>
@endpush

@push('library-js')
@endpush

@push('custom-js')
    @if ($expires_at >= $date)
        <script>
            var expires = '{{ $expires_at }}';

            if (expires == null) {
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
                document.getElementById("demo").innerHTML = days + "d " + ": " + hours + ": " +
                    minutes + ": " + seconds;

                // If the count down is over, write some text
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("demo").innerHTML = "Expired";
                }
            }, 1000);
        </script>
    @endif

    <script>
        function toggleReviews() {
            const reviews = document.querySelectorAll('.more-review');
            const btn = document.getElementById('moreBtn');

            reviews.forEach(r => r.classList.toggle('d-none'));

            btn.innerHTML = btn.innerText.includes('Show more') ?
                'Show less <i class="fa fa-angle-up"></i>' :
                'Show more <i class="fa fa-angle-down"></i>';
        }
    </script>
@endpush
