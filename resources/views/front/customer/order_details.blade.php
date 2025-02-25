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
                            <h3>{{ ucfirst($title) }}
                                @if($order->status == 'Pending')
                                    <form action="{{ route('cancel.order',[$order->id,'Canceled']) }}" method="post" style="display: inline">
                                        @csrf
                                        <button type="submit" class="btn btn-custom pull-right" onclick="return confirm('Are you confirm to Cancel?')">Cancel Order</button>
                                    </form>
                                @endif
                            </h3>
                            <hr>
                            <table class="table table-borderless">
                                <tr>
                                    <th style="width: 30%">Order ID</th>
                                    <td>{{ $order->order_number }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 30%">Date</th>
                                    <td>
                                        @php
                                            $cdate = date_create($order->date);
                                            echo date_format($cdate,'d-m-Y');
                                        @endphp</td>
                                </tr>
                                <tr>
                                    <th style="width: 30%">Status</th>
                                    <td>{{ ucfirst($order->status) }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 30%">Payment Status</th>
                                    <td>{{ ucfirst($order->payment_status) }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 30%">Payment Type</th>
                                    <td>{{ ($order->payment_type == 'cash')? 'Cash On Delivery':'Online Payment' }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 30%">Shipping Address</th>
                                    <td>{{ ucfirst($order->address).', '.$order->district->name.'  '.$order->zip }}</td>
                                </tr>

                                <tr>
                                    <th>Products</th>
                                    <td>
                                        <table>
                                            @php
                                                $subtotal = 0;
                                            @endphp
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                            </tr>
                                            @foreach($order->order_detail as $index=>$item)
                                                <tr>
                                                    <td><a class="text-custom" href="{{ route('product.details', $item->product->slug) }}">{{ ucfirst($item->product_name) }}</a></td>
                                                    <td>{{ $item->price }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td class="text-right">{{ $item->total }}</td>
                                                </tr>
                                                @php
                                                    $subtotal += $item->total;
                                                @endphp
                                            @endforeach
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width: 30%">Sub Total</th>
                                    <td>{{ $subtotal }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 30%">Shipping Charge</th>
                                    <td>{{ ($order->shipping == null)? 'Free' : $order->shipping }}</td>
                                </tr>

                                @if($order->discount != null)
                                    <tr>
                                        <th>Discount</th>
                                        <td>{{ $order->discount }}</td>
                                    </tr>
                                @endif
                                @if($order->order_number != 47)
                                    <tr>
                                        <th style="width: 30%">Total Amount</th>
                                        <td>{{ $order->amount }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 30%">Advance Payment</th>
                                        <td>{{ $order->advance }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <th style="width: 30%">Net Payable Amount</th>
                                    <td>{{ $order->amount - $order->advance }}</td>
                                </tr>

                            </table>

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
