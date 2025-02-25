@extends('layouts.backend.master')

@section('content')
    @forelse($orders as $order)
        <div class="col-md-10">
            <div class="container" style="margin-bottom: 15px; background-color: #fff;-moz-border-radius: 6px;-webkit-border-radius: 6px;-o-border-radius: 6px;border-radius: 6px; page-break-after: always;">
                <!-- Header -->
                <header class="" style="padding-top: 20px;padding-bottom: 20px;">
                    <div class="row align-items-center">
                        <div class="col-4 text-center text-sm-left mb-sm-0">
                            <img class="" style="max-width: 150px" src="{{ asset($link->logo) }}" title="" alt="logo" /> <br>

                        </div>
                        <div class="col-4 text-center">
                            <address class="mb-0">
                                {{ ucwords($contact->address) }}<br>
                                Email: {{ $contact->email }}<br>
                                Contact: {{ $contact->phone }} <br>
                            </address>
                            <div class="btn-group btn-group-sm d-print-none"> <a href="javascript:window.print()" class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-print"></i> Print</a> </div>
                        </div>
                        <div class="col-4 text-sm-right">
                            <strong style="font-size: 18px;">Print Copy</strong>
                            <p class="mb-0"> Billing Date: {{ today()->format('d-M-Y') }}</p>
                            <!--<strong style="font-size: 18px;">Auboni</strong>
                            <address>
                                42 Nabadwip Boshak Lane,
                                Laxmibazar, Dhaka-1100<br>
                                Email: test@hotmail.com<br>
                                Contact: 01700000000 <br>
                            </address>-->
                        </div>
                        <div class="col-sm-3 text-center text-sm-right">
                            <!-- <strong style="font-size: 18px;">Customer Copy</strong>
                             <p class="mb-0"> Billing Date: 13 Sep 2020</p>-->
                        </div>
                    </div>
                </header>


                <div class="container-fluid">
                    <div class="row">
                        <div style="background: #575757;width: 100%;position: relative;height: 66px;">
                            <h1 style="position: absolute;color: #000;background: #fff;right: 0;font-weight: 700;padding: 12px 15px 15px 4px;font-size: 55px;border: 1px solid #575757;line-height: 37px;">INVOICE</h1>
                            <div style="color: #fff;padding-top: 7px;padding-left: 24px;text-transform: uppercase;">
                                <h1 style="font-weight: 700;">{{ $meta->title }}</h1>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Main Content -->
                <main>
                    <div class="row" style="padding-bottom: 0;padding-top: 15px;">
                        <div class="col-sm-6 order-sm-0">
                            <div class="row mb-3">
                                <div class="col-sm-12"> <strong>Order ID:</strong>
                                    <span> {{ $order->order_number }} </span> <br/>
                                </div>
                                <div class="col-sm-12"> <strong>Order Placed:</strong>
                                    <span> {{ $order->created_at->format('d-M-Y') }} </span> <br/>
                                </div>
                                <div class="col-sm-12"> <strong>Invoiced By:</strong>
                                    <span> {{ ucwords(auth()->user()->name) }} </span> <br/>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 text-sm-right order-sm-1">
                            <strong>Bill To:</strong> <br>
                            <strong style="font-size: 18px;"> {{ ucfirst($order->user->name) }}</strong>
                            <address>
                                {{ ucfirst($order->address) }}<br/>
                                {{ $order->district->name.'  '.$order->zip }}<br/>
                                {{ $order->user->phone }}<br/>
                            </address>
                        </div>
                    </div>


                    <div class="campaign-table table-responsive">
                        <table class="table no-wrap p-table">
                            @php
                                $subtotal = 0;
                            @endphp
                            <thead>
                            <tr class="border-0">
                                <th style="background: #575757!important;color:#fff!important;" class="border-0">Item Description</th>
                                <th style="background: #575757!important;color:#fff!important;" class="border-0">Unit Cost</th>
                                <th style="background: #575757!important;color:#fff!important;" class="border-0">Quantity</th>
                                <th style="background: #575757!important;color:#fff!important;" class="border-0">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order->order_detail as $index=>$item)
                                <tr>
                                    <td><img style="width: 60px" src="{{ asset($item->product->product_image[0]->file_path) }}" alt="product"> {{ ucfirst($item->product_name) }}</td>
                                    <td>৳ {{ $item->price }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>৳ {{ $item->total }}</td>
                                </tr>
                                @php
                                    $subtotal += $item->total;
                                @endphp
                            @endforeach
                            {{--<tr>
                                <td style="background-color: rgba(0,0,0,.05)!important;">Noble Brazil Instant Coffee Jar</td>
                                <td style="background-color: rgba(0,0,0,.05)!important;">৳550</td>
                                <td style="background-color: rgba(0,0,0,.05)!important;">5</td>
                                <td style="background-color: rgba(0,0,0,.05)!important;">৳2750</td>
                            </tr>--}}

                            <tr style="border-top:1.5px solid #222;">
                                <td class="text-right border-top-0" colspan="3"><strong>Sub-Total</strong></td>
                                <td class="border-top-0"><strong>৳ {{ $subtotal }}</strong></td>
                            </tr>
                            <tr class="">
                                <td class="text-right border-top-0" colspan="3"><strong>Discount</strong></td>
                                <td class="border-top-0"><strong>৳ {{ ($order->discount == null)? '00' : $order->discount }}</strong></td>
                            </tr>
                            <tr class="">
                                <td class="text-right border-top-0" colspan="3"><strong>Shipping</strong></td>
                                <td class="border-top-0"><strong>৳ {{ ($order->shipping == null)? 'Free' : $order->shipping }}</strong></td>
                            </tr>
                            <tr style="border-top:1.5px solid #222;">
                                <td style="border-top:1.5px solid #222;" class="text-right" colspan="3"><strong>Total</strong></td>
                                <td style="border-top:1.5px solid #222;"><strong>৳ {{ $order->amount }}</strong></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </main>
                {{--<div class="col-12 pt-2 pl-0" style=" bottom: 0; width: 100%;">
                    <strong>Terms & Condition</strong> <br>
                    <span> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error facere harum id illo mollitia nihil quisquam. Alias autem beatae consectetur, culpa dicta doloribus ducimus exercitationem.</span>
                </div>--}}


                <hr style="border-bottom: 1px dotted #222!important;">







                <div class="container" style="background-color: #fff;-moz-border-radius: 6px;-webkit-border-radius: 6px;-o-border-radius: 6px;border-radius: 6px;">
                    <!-- Footer -->
                    <footer class="text-center">
                        <!--print-->
                        {{--<div class="btn-group btn-group-sm d-print-none"> <a href="javascript:window.print()" class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-print"></i> Print</a> </div>--}}
                        <!--print-->
                    </footer>
                    <br>
                    <br>
                </div>

            </div>
        </div>
    @empty
    @endforelse




@endsection




@push('library-css')

@endpush



@push('custom-css')

@endpush



@push('library-js')

@endpush



@push('custom-js')

@endpush
