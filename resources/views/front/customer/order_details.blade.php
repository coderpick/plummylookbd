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
                    <div class="card shadow-sm border-0 rounded-lg w-100">
                        <div class="card-header bg-white border-bottom-0 pt-4 pb-3 d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 text-custom font-weight-bold" style="color: var(--color-primary-dark);">
                                Order <span class="text-secondary">#{{ $order->order_number }}</span>
                            </h4>
                            @if($order->status == 'Pending')
                                <form action="{{ route('cancel.order',[$order->id,'Canceled']) }}" method="post" class="m-0">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3" onclick="return confirm('Are you sure you want to cancel this order?')">
                                        <i class="fa fa-times-circle"></i> Cancel Order
                                    </button>
                                </form>
                            @endif
                        </div>
                        
                        <div class="card-body bg-light">
                            <div class="row mb-4">
                                <!-- Order Summary -->
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <div class="card h-100 border-0 shadow-sm rounded-lg">
                                        <div class="card-body">
                                            <h6 class="text-uppercase text-muted font-weight-bold mb-3"><i class="fa fa-info-circle"></i> Order Summary</h6>
                                            <ul class="list-unstyled mb-0">
                                                <li class="mb-2"><strong>Date:</strong> {{ \Carbon\Carbon::parse($order->date)->format('d M, Y h:i A') }}</li>
                                                <li class="mb-2">
                                                    <strong>Status:</strong> 
                                                    @if(strtolower($order->status) == 'pending')
                                                        <span class="badge badge-secondary px-2 py-1">{{ ucfirst($order->status) }}</span>
                                                    @elseif(strtolower($order->status) == 'delivered')
                                                        <span class="badge badge-success px-2 py-1">{{ ucfirst($order->status) }}</span>
                                                    @elseif(strtolower($order->status) == 'canceled')
                                                        <span class="badge badge-danger px-2 py-1">{{ ucfirst($order->status) }}</span>
                                                    @else
                                                        <span class="badge badge-info px-2 py-1">{{ ucfirst($order->status) }}</span>
                                                    @endif
                                                </li>
                                                <li class="mb-2">
                                                    <strong>Payment:</strong> 
                                                    @if(strtolower($order->payment_status) == 'paid')
                                                        <span class="badge badge-success px-2 py-1"><i class="fa fa-check"></i> {{ ucfirst($order->payment_status) }}</span>
                                                    @else
                                                        <span class="badge badge-warning text-dark px-2 py-1"><i class="fa fa-clock-o"></i> {{ ucfirst($order->payment_status) }}</span>
                                                    @endif
                                                    ({{ ($order->payment_type == 'cash')? 'Cash On Delivery':'Online Payment' }})
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Shipping Info -->
                                <div class="col-md-6">
                                    <div class="card h-100 border-0 shadow-sm rounded-lg">
                                        <div class="card-body">
                                            <h6 class="text-uppercase text-muted font-weight-bold mb-3"><i class="fa fa-map-marker"></i> Shipping Details</h6>
                                            <address class="mb-0">
                                                <strong>{{ Auth::user()->name }}</strong><br>
                                                {{ ucfirst($order->address) }}<br>
                                                @if(isset($order->district))
                                                    {{ $order->district->name }} {{ $order->zip ? '- '.$order->zip : '' }}<br>
                                                @else
                                                    {{ $order->zip ? 'ZIP: '.$order->zip : '' }}<br>
                                                @endif
                                                <abbr title="Phone">P:</abbr> {{ Auth::user()->phone ?? 'N/A' }}
                                            </address>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Products Table -->
                            <h6 class="text-uppercase text-muted font-weight-bold mb-3"><i class="fa fa-shopping-bag"></i> Items Ordered</h6>
                            <div class="card border-0 shadow-sm rounded-lg mb-4">
                                <div class="table-responsive">
                                    <table class="table table-hover table-borderless text-center align-middle mb-0">
                                        <thead class="bg-white border-bottom">
                                            <tr>
                                                <th class="py-3 text-left pl-4">Product Name</th>
                                                <th class="py-3">Price</th>
                                                <th class="py-3">Qty</th>
                                                <th class="py-3 text-right pr-4">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $subtotal = 0; @endphp
                                            @foreach($order->order_detail as $item)
                                            <tr>
                                                <td class="text-left pl-4">
                                                    @if($item->product)
                                                        <a class="text-dark font-weight-bold" href="{{ route('product.details', $item->product->slug) }}">{{ ucfirst($item->product_name) }}</a>
                                                    @else
                                                        <span class="text-dark font-weight-bold">{{ ucfirst($item->product_name) }}</span>
                                                    @endif
                                                </td>
                                                <td class="text-muted">৳{{ number_format($item->price, 2) }}</td>
                                                <td><strong>{{ $item->quantity }}</strong></td>
                                                <td class="text-right pr-4 font-weight-bold">৳{{ number_format($item->total, 2) }}</td>
                                            </tr>
                                            @php $subtotal += $item->total; @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Totals Summary -->
                            <div class="row justify-content-end">
                                <div class="col-md-7 col-lg-5">
                                    <div class="card border-0 shadow-sm rounded-lg">
                                        <div class="card-body p-0">
                                            <ul class="list-group list-group-flush rounded-lg">
                                                <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
                                                    <span class="text-muted">Sub Total</span>
                                                    <strong>৳{{ number_format($subtotal, 2) }}</strong>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
                                                    <span class="text-muted">Shipping Charge</span>
                                                    <strong>{{ ($order->shipping == null || $order->shipping == 0)? 'Free' : '৳'.number_format($order->shipping, 2) }}</strong>
                                                </li>
                                                @if($order->discount != null && $order->discount > 0)
                                                <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-success">
                                                    <span>Discount</span>
                                                    <strong>-৳{{ number_format($order->discount, 2) }}</strong>
                                                </li>
                                                @endif
                                                
                                                @if($order->order_number != '47')
                                                <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
                                                    <span class="text-muted">Total Amount</span>
                                                    <strong>৳{{ number_format($order->amount, 2) }}</strong>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent text-primary">
                                                    <span>Advance Payment</span>
                                                    <strong>-৳{{ number_format($order->advance, 2) }}</strong>
                                                </li>
                                                @endif
                                                <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                                                    <span class="font-weight-bold">Net Payable Amount</span>
                                                    <h5 class="mb-0 font-weight-bold" style="color: var(--color-primary-dark);">৳{{ number_format($order->amount - $order->advance, 2) }}</h5>
                                                </li>
                                            </ul>
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
    </section>
@endsection




@push('library-css')
    <link rel="stylesheet" href="{{asset('backend/dropify/css/dropify.min.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('custom-css')
    <style>
        .btn-lg{
            border-radius: unset;
        }
    </style>
@endpush



@push('library-js')
    <script src="{{asset('backend/dropify/js/dropify.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
@endpush



@push('custom-js')
    <script>
        $(document).ready(function(){
            // Basic
            $('.dropify').dropify();
            $('.district').select2();
        });
    </script>
@endpush
