@extends('layouts.frontend.master')

@section('content')
    <section class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>{{ ucfirst($post->title) }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-4">
                    <h2 class="title-left d-inline">
                        Categories:
                    </h2>
                    @forelse($tags as $tag)
                        <button class="view-button mb-1 {{ $tag->id == $post->postTags[0]->tag->id ? '' : 'cat-button' }}"><a href="{{ route('blog.tag',$tag->slug) }}"><small>{{ $tag->name }}</small></a></button>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <!-- Main Content -->
            <div class="col-md-12">
                <h2 class="mb-3">{{ ucfirst($post->title) }}</h2>
                <p class="text-muted">{{ $post->postTags[0]->tag->name??'' }} • {{ date('M d, Y', strtotime($post->created_at)) }} • By {{ $post->user->name??'Admin' }}</p>
                <img class="img-fluid mb-4 rounded" src="{{ asset($post->image) }}" alt="{{ $post->title }}">
                <div class="ml-1">
                    {!! $post->body !!}
                </div>
                <div class="mt-4 mb-4">
                    <h5 class="mb-1">Share this blog:</h5>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ Request::url() }}" class="btn btn-primary btn-sm mr-2"><i class="fa fa-facebook-f"></i></a>
                    <a href="https://twitter.com/share?url={{ Request::url() }}" class="btn btn-info btn-sm mr-2"><i class="fa fa-twitter"></i></a>
                    <a href="https://www.linkedin.com/shareArticle?url={{ Request::url() }}" class="btn btn-secondary btn-sm mr-2"><i class="fa fa-linkedin"></i></a>
                    <a href="https://api.whatsapp.com/send?text={{ Request::url() }}" class="btn btn-success btn-sm mr-2"><i class="fa fa-whatsapp"></i></a>
                </div>
            </div>
        </div>

        <div class="popular-product-col-7-area rts-section-gapBottom mt-5">
            <div class="container">
                <div class="cover-card-main-over-white pb-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="title-area-between mb--15">
                                <h2 class="title-left">
                                    Recent Blogs
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class='Featured-cards p-0'>
                        <div class="row g-4 mt--0 custom-row">
                            @forelse($recent_posts as $r_post)
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                    <div class="card mb-4">
                                        <a href="{{ route('blog.show',$r_post->slug) }}">
                                            <img src="{{ asset($r_post->image) }}" class="card-img-top" alt="{{ ucfirst($r_post->title) }}">
                                        </a>
                                        <div class="card-body">
                                            <a href="{{ route('blog.show',$r_post->slug) }}">
                                                <h4 class="card-title">{{ ucfirst($r_post->title) }}</h4>
                                            </a>
                                            <p class="card-text"><a href="{{ route('blog.tag',$r_post->postTags[0]->tag->slug) }}"><small class="text-custom">{{ $r_post->postTags[0]->tag->name??"" }}</small> <small class="text-muted float-right">{{ date('M d, Y', strtotime($r_post->created_at)) }}</small></a></p>
                                            <p class="card-text ln-4"><small>{{ $r_post->short_description }}</small></p>
                                            <button class="view-button">
                                                <a href="{{ route('blog.show',$r_post->slug) }}">View More</a>
                                            </button>
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
    </div>
@endsection




@push('library-css')

@endpush



@push('custom-css')
    <style>
        .cat-button{
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
