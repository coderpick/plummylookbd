@extends('layouts.backend.master')

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-th-list"></i> {{ $title }}</h1>
            <p>Display {{ $title }} Data Effectively</p>
        </div>


        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('concern.index') }}">{{ $title }}</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="row justify-content-center mb-5">
                        <div class="col-md-12">
                            <img class="image-fluid mb-3" style="max-width: 100%;" src="{{ asset($post->image) }}"
                                alt="{{ $post->title }}">
                            <h3 class="subtitle">{{ ucfirst($post->title) }}</h3>
                            <p class="content">
                                {!! $post->body !!}
                            </p>
                            <p>
                                @if ($post->tags->count() > 0)
                                    @foreach ($post->tags as $tag)
                                        <span class="badge badge-primary">{{ $tag->name }}</span>
                                    @endforeach
                                @endif
                            </p>
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
        .content img {
            width: 100% !important;
            height: auto !important;
        }
    </style>
@endpush

@push('library-js')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        $('#sampleTable').DataTable({
            order: [
                [0, 'desc']
            ]
        });
    </script>
@endpush

@push('custom-js')
    <script>
        $('.content img').each(function() {
            $(this).css({
                'max-width': '100%',
                'height': 'auto'
            });
        });
    </script>
@endpush
