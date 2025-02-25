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
            <li class="breadcrumb-item active"><a href="#">{{ $title }}</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h2>{{ $title }}</h2>
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead class="text-center">
                            <tr>
                                <th width="30%">Parameter</th>
                                <th>Value</th>
                            </tr>
                            </thead>
                            <tbody>
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
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 30%">Status</th>
                                <td>{{ ucfirst($order->status) }} @if($user != null) &nbsp;  (By {{ ucfirst($user->name) }})@endif</td>
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
                                <th style="width: 30%">Customer Name</th>
                                <td><a href="{{ route('orders.customer',$order->user->slug ) }}">{{ ucfirst($order->user->name) }}</a></td>
                            </tr>
                            <tr>
                                <th style="width: 30%">Phone</th>
                                <td><a href="tel:{{ $order->user->phone }}">{{ $order->user->phone }}</a></td>
                            </tr>
                            <tr>
                                <th style="width: 30%">Email</th>
                                <td><a href="mailto:{{ $order->user->email }}">{{ $order->user->email }}</a></td>
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
                                            <th>Image</th>
                                            <th>Product Name</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                            <th>Seller</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach($order->order_detail as $index=>$item)
                                            @if (auth()->user()->type == 'vendor')
                                                @if ($item->shop_id == auth()->user()->shop->id)
                                                    <tr>
                                                        <td><img style="width: 75px" src="{{ asset($item->product->product_image[0]->file_path) }}" alt="product"></td>
                                                        <td>{{ ucfirst($item->product_name) }}</td>
                                                        <td>{{ $item->price }}</td>
                                                        <td>{{ $item->quantity }}</td>
                                                        <td class="text-right">{{ $item->total }}</td>
                                                        <td>{{ ($item->shop)?ucfirst($item->shop->name):config('app.name') }}</td>
                                                        <td>
                                                            @if ($item->status == 'Warehouse')
                                                                Way to Warehouse
                                                            @else
                                                                {{ $item->status }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($order->status == 'Confirmed' || $order->status == 'Processing')
                                                            @if ($item->status != 'Received')
                                                                <div class="dropdown d-inline">
                                                                    <button class="btn btn-sm btn-primary dropdown-toggle {{ ($item->status == 'Canceled')? 'disabled' : '' }}" type="button" data-toggle="dropdown">Status
                                                                        <span class="caret"></span></button>
                                                                    <ul class="dropdown-menu">
                                                                        @if($item->status != 'Processing')
                                                                            <li>
                                                                                <form action="{{ route('changeDetail',[$item->id,'Processing']) }}" method="post" style="display: inline">
                                                                                    @csrf
                                                                                    <button type="submit" class="btn stsbtn" onclick="return confirm('Are you confirm to change?')">Processing</button>
                                                                                </form>
                                                                            </li>
                                                                        @endif
                                                                        @if($item->status != 'Warehouse')
                                                                            <li>
                                                                                <form action="{{ route('changeDetail',[$item->id,'Warehouse']) }}" method="post" style="display: inline">
                                                                                    @csrf
                                                                                    <button type="submit" class="btn stsbtn" onclick="return confirm('Are you confirm to change?')">Sent to Warehouse</button>
                                                                                </form>
                                                                            </li>
                                                                        @endif

                                                                    </ul>
                                                                </div>
                                                            @endif
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @else
                                            <tr>
                                                <td><img style="width: 75px" src="{{ isset($item->product->product_image)? asset($item->product->product_image[0]->file_path):'' }}" alt="product"></td>
                                                <td>{{ ucfirst($item->product_name) }}</td>
                                                <td>{{ $item->price }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td class="text-right">{{ $item->total }}</td>
                                                <td>{{ ($item->shop)?ucfirst($item->shop->name):config('app.name') }}</td>
                                                <td>
                                                    @if ($item->status == 'Warehouse')
                                                        Way to Warehouse
                                                    @else
                                                        {{ $item->status }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (auth()->user()->type != 'vendor')
                                                            <div class="dropdown d-inline">
                                                                <button class="btn btn-sm btn-primary dropdown-toggle {{ ($item->status == 'Canceled')? 'disabled' : '' }}" type="button" data-toggle="dropdown">Status
                                                                    <span class="caret"></span></button>
                                                                <ul class="dropdown-menu">
                                                                    @if($item->status != 'Warehouse')
                                                                        <li>
                                                                            <form action="{{ route('changeDetail',[$item->id,'Warehouse']) }}" method="post" style="display: inline">
                                                                                @csrf
                                                                                <button type="submit" class="btn stsbtn" onclick="return confirm('Are you confirm to change?')">Warehouse</button>
                                                                            </form>
                                                                        </li>
                                                                    @endif
                                                                    @if($item->status != 'Received')
                                                                        <li>
                                                                            <form action="{{ route('changeDetail',[$item->id,'Received']) }}" method="post" style="display: inline">
                                                                                @csrf
                                                                                <button type="submit" class="btn stsbtn" onclick="return confirm('Are you confirm to change?')">Receive</button>
                                                                            </form>
                                                                        </li>
                                                                    @endif
                                                                </ul>
                                                            </div>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endif
                                            @php
                                                $subtotal += $item->total;
                                            @endphp
                                        @endforeach
                                    </table>
                                </td>
                            </tr>

                            @if (auth()->user()->type != 'vendor')
                            <tr>
                                <th style="width: 30%">Sub Total</th>
                                <td>{{ $subtotal }}</td>
                            </tr>

                            <tr>
                                <th>Discount</th>
                                <td>{{ ($order->discount == null)? '00' : $order->discount }}</td>
                            </tr>

                            <tr>
                                <th style="width: 30%">Shipping Charge</th>
                                <td>{{ ($order->shipping == null)? 'Free' : $order->shipping }}</td>
                            </tr>
                            <tr>
                                <th style="width: 30%">Total Amount</th>
                                <td>{{ $order->amount }}</td>
                            </tr>
                            <tr>
                                <th style="width: 30%">Advance Payment</th>
                                <td>{{ $order->advance }}</td>
                            </tr>
                            <tr>
                                <th style="width: 30%">Advance Details</th>
                                <td>
                                    Transaction Type: {{ $order->order_advance->trx_type??'' }} <br>
                                    Transaction ID: {{ $order->order_advance->trx_id??'' }} <br>
                                    Account Number: {{ $order->order_advance->account_no??'' }} <br>
                                    Sender Number: {{ $order->order_advance->sender_account??'' }}
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 30%">Net Payable Amount</th>
                                <td>{{ $order->amount - $order->advance }}</td>
                            </tr>
                            @endif
                            </tbody>
                        </table>
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
        .stsbtn{
            width:-webkit-fill-available;
            line-height: 1;
        }
    </style>
@endpush



@push('library-js')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
@endpush



@push('custom-js')

@endpush
