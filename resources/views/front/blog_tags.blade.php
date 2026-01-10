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

    <section class="product spad">
        <div class="container">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="category-menu-area">
                            <h2 class="mb-0 mr-2"> Categories:</h2>
                            <ul class="d-flex list-unstyled gap-2 category-nav flex-wrap">
                                @forelse($blogCategories as $blogCategory)
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->segment(3) == $blogCategory->slug ? 'active' : '' }}"
                                            href="{{ route('blog.category.post', $blogCategory->slug) }}">
                                            {{ $blogCategory->name }}
                                        </a>
                                    </li>
                                @empty
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @forelse($posts as $post)
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
                            <div class="card mb-4 h-100 shadow-sm">
                                <a href="{{ route('blog.show', $post->slug) }}">
                                    <img src="{{ asset($post->image) }}" class="card-img-top"
                                        alt="{{ ucfirst($post->title) }}">
                                </a>
                                <div class="card-body">
                                    <a href="{{ route('blog.show', $post->slug) }}">
                                        <h4 class="card-title">{{ ucfirst($post->title) }}</h4>
                                    </a>
                                    <p class="card-text">
                                        <a href="{{ route('blog.category.post', $post->blogCategory?->slug) }}">
                                            <small class="text-custom">{{ $post->blogCategory?->name }}</small> <small
                                                class="text-muted float-right">{{ date('M d, Y', strtotime($post->created_at)) }}</small>
                                        </a>
                                    </p>
                                    <p class="card-text ln-4"><small>{{ $post->short_description }}</small></p>
                                    <button class="view-button">
                                        <a href="{{ route('blog.show', $post->slug) }}">View More</a>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <h6 class="text-center">No Data Found !</h6>
                    @endforelse
                </div>
            </div>
            {{ $posts->render() }}
        </div>
    </section>
@endsection

@push('library-css')
@endpush

@push('custom-css')
    <style>
        .cat-button {
            background-color: #8D72CC !important;
        }

        .ln-4 {
            display: -webkit-box !important;
            line-height: 1.5 !important;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endpush

@push('library-js')
@endpush

@push('custom-js')
@endpush
