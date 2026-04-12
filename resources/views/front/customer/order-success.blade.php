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
    <section class="checkout spad">
        <div class="container" id="printcontent">
            @if(session('s_msg'))
            <div class="row">
                <div class="col-md-12 bs-component">
                    <div class="alert alert-dismissible alert-success">
                        <button class="close" type="button" data-dismiss="alert">×</button><strong><i class="icofont icofont-check-circled"></i> Done!</strong> Your order has been successfully <a class="alert-link" href="#">placed</a>.
                    </div>
                </div>
            </div>
            @endif
            @if(session('p_msg'))
                <div class="row">
                    <div class="col-md-12 bs-component">
                        <div class="alert alert-dismissible alert-success">
                            <button class="close" type="button" data-dismiss="alert">×</button><strong><i class="icofont icofont-check-circled"></i> Success!</strong> Your payment has been successfully <a class="alert-link" href="#">done</a>.
                        </div>
                    </div>
                </div>
            @endif
            <article class="card">
                {{--@if($order->district_id != 47)
                    @if($order->advance == null)
                        <div class="row">
                            <div class="col-md-12 bs-component">
                                <div class="alert alert-dismissible alert-danger">
                                   <strong><i class="icofont icofont-check-circled"></i> As your order is outside Dhaka,</strong> you need to pay Tk 150 in advance <a type="button" href="#" class="text-custom" data-toggle="modal" data-target="#exampleModal"><strong>Pay Now</strong></a>.
                                </div>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form action="{{ route('advance.store') }}" class="form-inline" method="post">
                                        <div class="modal-content">
                                            <div class="modal-header bg-custom text-white">
                                                <h5 class="modal-title" id="exampleModalLabel">Advance Payment</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                @csrf
                                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                <p class="clear mb-1"><span class="f_title">Order Number: </span></p>
                                                <input type="text" name="order_number" value="{{ $order->order_number }}" readonly class="form-control w-100 mb-2">

                                                <p class="clear mb-1"><span class="f_title">Payment Type: </span></p>
                                                <select id="trx_type" name="trx_type" class="form-control w-100 mb-2" required>
                                                    <option value="">Select</option>
                                                    <option value="bkash">bKash</option>
                                                    <option value="nagad">Nagad</option>
                                                </select>

                                                <p class="clear mb-1"><span class="f_title">Payment To: </span></p>
                                                <input type="text" id="account_no" name="account_no" value="" readonly class="form-control w-100 mb-2">
                                                --}}{{--<select id="account_no" name="account_no" class="form-control w-100 mb-2" required>
                                                    <option value="">Select</option>
                                                    <option value="01715123456">01715123456</option>
                                                    <option value="01219123456">01219123456</option>
                                                </select>--}}{{--

                                                <p class="clear mb-1"><span class="f_title">Amount: </span></p>
                                                <input type="text" name="amount" required class="number form-control w-100 mb-2">

                                                <p class="clear mb-1"><span class="f_title">Trxn ID: </span></p>
                                                <input type="text" name="trx_id" required class="form-control w-100 mb-2">

                                                <p class="clear mb-1"><span class="f_title">Sender Account Number: </span></p>
                                                <input type="text" name="sender_account" required class="number form-control w-100 mb-2">
                                            </div>
                                            <br>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn site-btn">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif--}}

                <header class="card-header"> My Order / {{ ucfirst($title) }} {{--<span class="float-right"><a class="btn btn-warning" href="JavaScript:window.print();">Print Page</a></span>--}}</header>

                <div class="card-body">

                    <article class="card">
                        <div class="card-body row">
                            <div class="col"> <strong>Order ID #:</strong> <br> {{ $order->order_number }} </div>
                            <div class="col"> <strong>Payment Method:</strong> <br> {{ ($order->payment_type == 'cash')? 'Cash On Delivery':'Online Payment' }} </div>
                            <div class="col"> <strong>Estimated Delivery:</strong> <br>{{ $date }} </div>
                            {{--<div class="col"> <strong>Status:</strong> <br> {{ ucfirst($order->status) }} </div>--}}
                        </div>
                    </article>
                    <div class="track">
                        @if ($order->status == 'Pending')
                            <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text"> Pending</span> </div>
                            <div class="step"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text"> Confirmed</span> </div>
                            <div class="step"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text"> Processing</span> </div>
                            <div class="step"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text"> Shipped </span> </div>
                            <div class="step"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Delivered</span> </div>
                        @endif
                        @if ($order->status == 'Confirmed')
                            <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text"> Pending</span> </div>
                            <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text"> Confirmed</span> </div>
                            <div class="step"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text"> Processing</span> </div>
                            <div class="step"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text"> Shipped </span> </div>
                            <div class="step"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Delivered</span> </div>
                        @endif
                        @if ($order->status == 'Processing')
                            <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text"> Pending</span> </div>
                            <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text"> Confirmed</span> </div>
                            <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text"> Processing</span> </div>
                            <div class="step"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text"> Shipped </span> </div>
                            <div class="step"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Delivered</span> </div>
                        @endif
                        @if ($order->status == 'Shipped')
                            <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text"> Pending</span> </div>
                            <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text"> Confirmed</span> </div>
                            <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text"> Processing</span> </div>
                            <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text"> Shipped </span> </div>
                            <div class="step"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Delivered</span> </div>
                        @endif
                        @if ($order->status == 'Delivered')
                            <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text"> Pending</span> </div>
                            <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text"> Confirmed</span> </div>
                            <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text"> Processing</span> </div>
                            <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text"> Shipped </span> </div>
                            <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Delivered</span> </div>
                        @endif
                        @if ($order->status == 'Canceled')
                            <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text text-danger"> Canceled</span> </div>
                        @endif
                    </div>
                    <hr>
                    <table class="table table-borderless">
                        <tbody>
                        <tr>
                            <th><h5 class="text-uppercase">Ship to:</h5></th>
                            <td></td>
                        </tr>

                        <tr>
                            <th>Name</th>
                            <td>{{ ucfirst($customer->name) }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $customer->phone }}</td>
                        </tr>
                        <tr>
                            <th>E-mail</th>
                            <td>{{ $customer->email }}</td>
                        </tr>
                        <tr>
                            <th>Shipping Address</th>
                            <td>{{ ucfirst($order->address).', '.$order->district->name.'  '.$order->zip }}</td>
                        </tr>
                        @if ($order->discount!= null)
                            <tr>
                                <th>Coupon Discount</th>
                                <td>{{ $order->discount }}</td>
                            </tr>
                        @endif
                        <tr>
                            <th>Payment Status</th>
                            <td>{{ ucfirst($order->payment_status) }}</td>
                        </tr>
                        <tr>
                            @if ($order->payment_status == 'unpaid')
                            <th>Payable Amount</th>
                                @else
                                <th>Paid Amount</th>
                            @endif
                            <td>{{ $order->amount - $order->advance }}/-</td>
                        </tr>

                        <tr>
                            <th> </th>
                            {{--<td>
                                @if ($order->payment_status != 'paid' && $order->payment_type != 'cash')
                                    <form action="{{ url('/pay') }}" method="POST" class="d-inline needs-validation">
                                        <input type="hidden" value="{{ csrf_token() }}" name="_token" />
                                        <input type="hidden" value="{{ $order->transaction_id }}" name="tran_id" />
                                        <button class="btn btn-custom" type="submit">Pay Now</button>
                                    </form>
                                    @if (isset($balance) && $order->amount <= $balance->point )
                                        <form action="{{ route('point.pay',$order->id) }}" method="post" style="display: inline">
                                            @csrf
                                            <button type="submit" class="btn btn-secondary" style="background: #000;" onclick="return confirm('Are Confirm to Pay?')">Pay with Point</button>
                                        </form>
                                        --}}{{--<a href="{{ route('point.pay',$order->id ) }}" class="btn btn-secondary" style="background: #000;">Pay with Balance</a>--}}{{--
                                    @endif
                            @endif
                            </td>--}}
                        </tr>
                        </tbody>
                    </table>


                    <hr>
                    {{--<div class="col-md-12">
                        @if ($order->payment_status == 'unpaid')
                        <div class="col-md-6">
                        <p>
                            <a style="color: black;" data-toggle="collapse" href="#checkout-discount-section" class="collapsed" role="button" aria-expanded="false" aria-controls="checkout-discount-section">Have Any Coupon Code?</a>
                        </p>

                        <div class="collapse" id="checkout-discount-section">

                            <form action="{{ route('discount',$order->id) }}" class="form-inline" method="get">
                                @csrf
                                <input type="text" name="coupon_code" class="form-control" placeholder="Enter Voucher"  required> &nbsp;
                                <button class="btn btn-warning" type="submit">Apply</button>
                            </form>
                        </div><!-- End .collapse -->
                    </div><!-- End .checkout-discount -->
                        @endif
                    </div>--}}

                    <!-- End .checkout-discount -->
                    <br>
                    <br>

                    {{--<a href="#" class="btn btn-warning" data-abc="true"> <i class="fa fa-chevron-left"></i> Back to orders</a>--}}
                </div>
            </article>
        </div>
    </section>
@endsection




@push('library-css')

@endpush



@push('custom-css')
    <style>

        @media print
        {
            body * { visibility: hidden; }
            #printcontent * { visibility: visible; }
            #printcontent { position: absolute; top: 50px; left: 30px; }
        }

        @import url('https://fonts.googleapis.com/css?family=Open+Sans&display=swap');

        body {
            background-color: #eeeeee;
            font-family: 'Open Sans', serif
        }


        .card {
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 0.10rem
        }

        .card-header:first-child {
            border-radius: calc(0.37rem - 1px) calc(0.37rem - 1px) 0 0
        }

        .card-header {
            padding: 0.75rem 1.25rem;
            margin-bottom: 0;
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1)
        }

        .itemside {
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            width: 100%
        }

        .itemside .aside {
            position: relative;
            -ms-flex-negative: 0;
            flex-shrink: 0
        }

        .img-sm {
            width: 80px;
            height: 80px;
            padding: 7px
        }

        ul.row,
        ul.row-sm {
            list-style: none;
            padding: 0
        }

        .itemside .info {
            padding-left: 15px;
            padding-right: 7px
        }

        .itemside .title {
            display: block;
            margin-bottom: 5px;
            color: #212529
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem
        }

    </style>
@endpush



@push('library-js')

@endpush



@push('custom-js')
    <script>
        $(document).on('change','#trx_type', function(){
            var value = $('#trx_type').val();
            var bkash = '{{ $bkash }}';
            var nagad = '{{ $nagad }}';
            if(value === 'bkash'){
                $('#account_no').val(bkash);
            }
            else if(value === 'nagad'){
                $('#account_no').val(nagad);
            }
            else {
                $('#account_no').val('');
            }
        });
    </script>
@endpush

@push('datalayer')
@if(session('s_msg') || session('p_msg') || session('success') || session('order_placed'))
<script>
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({ ecommerce: null });
    window.dataLayer.push({
        event: 'purchase',
        user_data: {
            email_address: '{{ $order->email ?? optional($customer)->email }}',
            phone_number: '{{ $order->phone ?? optional($customer)->phone }}',
            address: {
                first_name: @json($order->name ?? optional($customer)->name)
            }
        },
        ecommerce: {
            transaction_id: '{{ $order->transaction_id ?? $order->order_number }}',
            value: {{ $order->amount }},
            currency: 'BDT',
            coupon: '{{ $order->discount ? "COUPON" : "" }}',
            items: [
                @foreach($order->order_detail as $item)
                {
                    item_id: '{{ $item->product_id }}',
                    item_name: @json(optional($item->product)->name ?? 'Unknown Product'),
                    item_category: @json(optional($item->product->category)->name ?? ''),
                    item_brand: @json(optional($item->product->brand)->name ?? ''),
                    price: {{ $item->price }},
                    quantity: {{ $item->quantity }}
                }{{ !$loop->last ? ',' : '' }}
                @endforeach
            ]
        }
    });
</script>
@endif
@endpush
