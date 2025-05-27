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

    <!-- Featured Section Begin -->
    @if (isset($shops) && count($shops) > 0)
    <section class="featured spad">
        <div class="container">
            <div class="row featured__filter">
                @foreach($shops as $shop)
                    <div class="nil">
                        <div class="featured__item tin-card">

                            <a href="{{ route('merchant.product',$shop->slug ) }}">
                                <div class="featured__item__pic">
                                    <img style="max-width: 165px; max-height: 200px" class=" " src="{{ asset(($shop->image != null)?$shop->image:'uploads/store.png') }}" alt="store">
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
                <div class="row featured__filter">
                    @foreach($categories as $category)
                        <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                            <a href="{{ route('product.category',$category->slug) }}">
                                <div class="tin-card cat-card">
                                    <img style="max-height: 60px" class=" " alt="" src="{{ asset($category->icon) }}"/>
                                    <h3 class="cat-title">{{ ucfirst($category->name) }}</h3>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                {{ $categories->render() }}
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
