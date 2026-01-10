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
                            <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Order ID#</th>
                                        <th>Total Amount</th>
                                        {{-- <th>Order Status</th> --}}
                                        <th>Payment Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $order->order_number }}</td>
                                            <td>{{ $order->amount }}</td>
                                            {{-- <td>{{ ucfirst($order->status) }}</td> --}}
                                            <td>{{ ucfirst($order->payment_status) }}</td>
                                            <td>
                                                <a href="{{ route('myorder.show', base64_encode($order->id)) }}"
                                                    class="btn btn-sm btn-info">Details</a>
                                                <a href="{{ route('track', [auth()->user()->slug, base64_encode($order->id)]) }}"
                                                    class="btn btn-sm btn-success">Track</a>
                                                @if ($order->status == 'Delivered')
                                                    <a href="{{ route('product.details', $order->order_detail->first()?->product->slug) }}"
                                                        class="btn btn-sm btn-secondary">
                                                        Write Review
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            {{ $orders->render() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection




@push('library-css')
    <link rel="stylesheet" href="{{ asset('backend/dropify/css/dropify.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('custom-css')
    <style>
        .btn-lg {
            border-radius: unset;
        }
    </style>
@endpush



@push('library-js')
    <script src="{{ asset('backend/dropify/js/dropify.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
@endpush



@push('custom-js')
    <script>
        $(document).ready(function() {
            // Basic
            $('.dropify').dropify();
            $('.district').select2();
        });
    </script>
@endpush
