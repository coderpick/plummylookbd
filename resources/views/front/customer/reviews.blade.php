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

    <section class="checkout spad">
        <div class="container">

            <div class="row">

                <div class="col-lg-3 col-md-5">
                    @include('front.customer._sideMenu')
                </div>

                <div class="col-lg-9 col-md-7">

                    <div class="row">
                        <div class="checkout__form col-lg-12">
                            <h3>{{ ucfirst($title) }}</h3>
                            @if ($reviews->count()>0)
                                <br>
                            <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Rating</th>
                                    <th>Review</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($reviews as $review)
                                    <tr>
                                        <td>{{ ucfirst($review->product->name) }}</td>
                                        <td>{{ $review->rating }} <i class="fa fa-star"></i></td>
                                        <td width="45%"><p style="max-height: 150px" class="overflow-auto">{{ ucfirst($review->review) }}</p></td>
                                        <td>
                                            @if ($review->deleted_at == null)
                                                Approved
                                                @else
                                                Pending
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                            {{ $reviews->render() }}
                            @else
                                <br>
                                <br>
                                <h5 class="text-center">You don't have any review</h5>
                            @endif
                        </div>
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
        .btn-lg{
            border-radius: unset;
        }
    </style>
@endpush



@push('library-js')

@endpush



@push('custom-js')

@endpush
