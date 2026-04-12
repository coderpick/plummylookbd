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
                    <div class="card shadow-sm border-0 rounded-lg w-100">
                        <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                            <h4 class="mb-0 text-custom font-weight-bold" style="color: var(--color-primary-dark);">{{ ucfirst($title) }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-borderless table-striped text-center align-middle mb-0" width="100%" cellspacing="0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="py-3 px-2">Order ID</th>
                                            <th class="py-3 px-2">Total Amount</th>
                                            <th class="py-3 px-2">Payment</th>
                                            <th class="py-3 px-2">Status</th>
                                            <th class="py-3 px-2">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($orders as $order)
                                            <tr>
                                                <td class="align-middle px-2">
                                                    <strong>{{ $order->order_number }}</strong>
                                                    <div class="text-muted small mt-1">{{ \Carbon\Carbon::parse($order->date)->format('d M(D), Y') }}</div>
                                                </td>
                                                <td class="align-middle px-2 text-dark font-weight-bold">
                                                    ৳{{ number_format($order->amount, 2) }}
                                                </td>
                                                <td class="align-middle px-2">
                                                    @if(strtolower($order->payment_status) == 'paid')
                                                        <span class="badge badge-success px-3 py-2 rounded-pill" style="font-size: 0.85rem;"><i class="fa fa-check-circle"></i> {{ ucfirst($order->payment_status) }}</span>
                                                    @else
                                                        <span class="badge badge-warning text-dark px-3 py-2 rounded-pill" style="font-size: 0.85rem;"><i class="fa fa-clock-o"></i> {{ ucfirst($order->payment_status) }}</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle px-2">
                                                    @if(strtolower($order->status) == 'pending')
                                                        <span class="badge badge-secondary px-3 py-2 rounded-pill" style="font-size: 0.85rem;">{{ ucfirst($order->status) }}</span>
                                                    @elseif(strtolower($order->status) == 'delivered')
                                                        <span class="badge badge-success px-3 py-2 rounded-pill" style="font-size: 0.85rem;">{{ ucfirst($order->status) }}</span>
                                                    @elseif(strtolower($order->status) == 'canceled')
                                                        <span class="badge badge-danger px-3 py-2 rounded-pill" style="font-size: 0.85rem;">{{ ucfirst($order->status) }}</span>
                                                    @else
                                                        <span class="badge badge-info px-3 py-2 rounded-pill" style="font-size: 0.85rem;">{{ ucfirst($order->status) }}</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle px-2">
                                                    <a href="{{ route('user.orders.show', base64_encode($order->id)) }}"
                                                        class="btn btn-sm btn-outline-info rounded-lg px-2 m-1" title="Order Details">
                                                        <i class="fa fa-eye"></i> Details
                                                    </a>
                                                    <a href="{{ route('track', [auth()->user()->slug, base64_encode($order->id)]) }}"
                                                        class="btn btn-sm btn-outline-success rounded-lg px-2 m-1" title="Track Order">
                                                        <i class="fa fa-map-marker"></i> Track
                                                    </a>
                                                    @if ($order->status == 'Delivered')
                                                        <a href="{{ route('product.details', $order->order_detail->first()?->product->slug) }}"
                                                            class="btn btn-sm btn-outline-secondary rounded-lg px-2 m-1" title="Write Review">
                                                            <i class="fa fa-star"></i> Review
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-5">
                                                    <img src="{{ asset('frontend/img/empty-cart.png') }}" alt="No Orders" style="max-width: 150px; opacity: 0.5;" class="mb-3">
                                                    <h5>No Orders Found</h5>
                                                    <p class="text-muted">You haven't placed any orders yet.</p>
                                                    <a href="{{ route('home') }}" class="btn site-btn rounded-pill px-4" style="background: var(--color-primary);">Start Shopping</a>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if($orders->hasPages())
                        <div class="card-footer bg-white border-top-0 pt-3 pb-3 d-flex justify-content-center">
                            {{ $orders->render() }}
                        </div>
                        @endif
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
