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
                <form action="{{ route('changeMultiple') }}" method="post">
                    @csrf

                    @if (auth()->user()->type != 'vendor' && ! Request::is('secure/orders/canceled'))
                        <div class="col-md-12 row">
                            <div class="btn-group">
                                <select id="m_status" name="status" class="form-control">
                                    <option value=" ">Select Option</option>
                                    @if(Request::is('secure/orders/confirmed') || Request::is('secure/orders/processing'))
                                        <option style="color: #ffffff!important; background-color: #009688 !important;" value="Invoice">Invoice</option>
                                    @endif
                                    @if(! Request::is('secure/orders/pending'))
                                        <option value="Pending">Pending</option>
                                    @endif
                                    @if(! Request::is('secure/orders/confirmed'))
                                        <option value="Confirmed">Confirmed</option>
                                    @endif
                                    @if(! Request::is('secure/orders/processing'))
                                        <option value="Processing">Processing</option>
                                    @endif
                                    @if(! Request::is('secure/orders/shipped'))
                                        <option value="Shipped">Shipped</option>
                                    @endif
                                    @if(! Request::is('secure/orders/delivered'))
                                        <option value="Delivered">Delivered</option>
                                    @endif
                                    @if(! Request::is('secure/orders/canceled'))
                                        <option value="Canceled">Canceled</option>
                                    @endif
                                </select>
                            </div>
                            &nbsp;
                            <button type="submit" class="btn btn-primary mr-1" id="multi-btn"><span>Change Multi Status</span></button>
                        </div>
                    @endif
                <br>
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                            <tr>
                                <th style="display: none;">Id</th>
                                @if (auth()->user()->type != 'vendor')
                                <th><input type="checkbox" id="checkAll" name="checkAll"> All</th>
                                @endif
                                <th>Order ID</th>
                                @if (auth()->user()->type != 'vendor')
                                <th>Total Amount</th>
                                @endif
                                <th>Payment Status</th>
                                {{--<th>Advance</th>--}}
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td style="display: none;">{{ $order->id }}</td>
                                    @if (auth()->user()->type != 'vendor')
                                    <td><input class="status_change" type="checkbox" name="ids[]" value="{{ $order->id }}"></td>
                                    @endif
                                    <td>{{ $order->order_number }}</td>
                                    @if (auth()->user()->type != 'vendor')
                                    <td>{{ $order->amount  }}</td>
                                    @endif
                                    <td>{{ ucfirst($order->payment_status) }}</td>
                                    {{--<td>
                                        @if($order->district_id == 47)
                                            Inside Dhaka
                                        @else
                                            <button class="btn btn-sm btn-secondary" data-toggle="tooltip" data-placement="right" title="TrxID: {{ $order->order_advance->trx_id??'' }} ( {{$order->order_advance->sender_account??''}} by {{ $order->order_advance->trx_type??''}} )">
                                                {{ $order->advance }}
                                            </button>
                                        @endif
                                    </td>--}}
                                    <td>{{ ucfirst($order->status) }}</td>
                                    <td>
                                       @if (auth()->user()->type != 'vendor')
                                        <div class="dropdown d-inline status">
                                            <button class="btn btn-sm btn-primary bt-single dropdown-toggle {{ ($order->status == 'Canceled')? 'disabled' : '' }}" type="button" data-toggle="dropdown">Status
                                                <span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                                    @if($order->status != 'Pending')
                                                    <li>
                                                        <a class="btn stsbtn" href="{{ route('changeStatus',[base64_encode($order->id),'Pending']) }}">Pending</a>
                                                        {{--<form action="{{ route('changeStatus',[$order->id,'Pending']) }}" method="post" style="display: inline">
                                                            @csrf
                                                            <button type="submit" class="btn stsbtn" onclick="return confirm('Are you confirm to change?')">Pending</button>
                                                        </form>--}}
                                                    </li>
                                                    @endif
                                                    @if($order->status != 'Confirmed')
                                                    <li>
                                                        <a class="btn stsbtn" href="{{ route('changeStatus',[base64_encode($order->id),'Confirmed']) }}">Confirmed</a>
                                                    </li>
                                                    @endif
                                                        @if($order->status != 'Processing')
                                                            <li>
                                                                <a class="btn stsbtn" href="{{ route('changeStatus',[base64_encode($order->id),'Processing']) }}">Processing</a>
                                                            </li>
                                                        @endif
                                                        @if($order->status != 'Shipped')
                                                            <li>
                                                                <a class="btn stsbtn" href="{{ route('changeStatus',[base64_encode($order->id),'Shipped']) }}">Shipped</a>
                                                            </li>
                                                        @endif
                                                        @if($order->status != 'Delivered')
                                                            <li>
                                                                <a class="btn stsbtn" href="{{ route('changeStatus',[base64_encode($order->id),'Delivered']) }}">Delivered</a>
                                                            </li>
                                                        @endif
                                                        @if($order->status != 'Canceled')
                                                            <li>
                                                                <a class="btn stsbtn" href="{{ route('changeStatus',[base64_encode($order->id),'Canceled']) }}">Canceled</a>
                                                            </li>
                                                        @endif

                                            </ul>
                                        </div>

                                            {{--<div class="btn-group">
                                                <select name="status[]" class="btn-multi form-control btn btn-sm btn-primary">
                                                    <option>Status</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                </select>
                                            </div>--}}

                                        @endif

                                        <a target="_blank" href="{{ route('orders.show', base64_encode($order->id)) }}" class="btn btn-sm btn-info">Details</a>
                                       @if (auth()->user()->type != 'vendor')
                                           @if($order->status == 'Confirmed' || $order->status == 'Processing')
                                            <a href="{{ route('orders.invoice', base64_encode($order->id)) }}" class="btn btn-sm btn-info">Invoice</a>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                </form>
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

        #m_status option{
            font-size: 15px;
        }
    </style>
@endpush



@push('library-js')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable({ order: [ [0, 'desc'] ]});</script>
@endpush



@push('custom-js')
    <script type="text/javascript">
        $('#checkAll').click(function () {
            $('input:checkbox').prop('checked', this.checked);
        });

            $(document).ready(function(){
                $("#m_status").change(function(){
                    var status = $(this).val();

                    if (status == 'Invoice') {
                        $("#multi-btn span").text("Generate Invoice");
                    }
                    else {
                        $("#multi-btn span").text("Change Multi Status");
                    }

                });
            });
    </script>
@endpush
