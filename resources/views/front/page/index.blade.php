@extends('layouts.frontend.master')

@section('content')
    <section class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h1>{{ ucfirst($page->title ?? 'Page Title') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Section Begin -->
    <section class="product spad py-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </section>
@endsection
