@extends('layouts.backend.master')

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        </ul>
    </div>

    @if (auth()->user()->type != 'vendor')
    <div class="row">
        {{--<div class="col-md-6 col-lg-4">
            <a class="dashboard_link" href="{{ route('brand.index') }}">
            <div class="widget-small primary"><i class="icon fa fa-tag fa-3x"></i>
                <div class="info">
                    <h4>Brands</h4>
                    <p><b>{{ $brand }}</b></p>
                </div>
            </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-4">
            <a class="dashboard_link" href="{{ route('category.index') }}">
            <div class="widget-small info"><i class="icon fa fa-th-large fa-3x"></i>
                <div class="info">
                    <h4>Categories</h4>
                    <p><b>{{ $category }}</b></p>
                </div>
            </div>
            </a>
        </div>--}}
        <div class="col-md-12 col-lg-12">
            <a class="dashboard_link" href="{{ route('product.index') }}">
            <div class="widget-small primary"><i class="icon fa fa-archive fa-3x"></i>
                <div class="info">
                    <h4>Products</h4>
                    <p><b>{{ $product }}</b></p>
                </div>
            </div>
            </a>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-md-6 col-lg-4">
            <a class="dashboard_link" href="{{ route('orders.pending') }}">
            <div class="widget-small primary coloured-icon"><i class="icon fa fa-clock-o fa-3x"></i>
                <div class="info">
                    <h4>Pending</h4>
                    <p><b>{{ $pending }}</b></p>
                </div>
            </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-4">
            <a class="dashboard_link" href="{{ route('orders.confirmed') }}">
            <div class="widget-small info coloured-icon"><i class="icon fa fa-reply fa-3x"></i>
                <div class="info">
                    <h4>Confirmed</h4>
                    <p><b>{{ $confirmed }}</b></p>
                </div>
            </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-4">
            <a class="dashboard_link" href="{{ route('orders.processing') }}">
            <div class="widget-small primary coloured-icon"><i class="icon fa fa-spinner fa-3x"></i>
                <div class="info">
                    <h4>Processing</h4>
                    <p><b>{{ $processing }}</b></p>
                </div>
            </div>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-lg-4">
            <a class="dashboard_link" href="{{ route('orders.shipped') }}">
            <div class="widget-small primary coloured-icon"><i class="icon fa fa-truck fa-3x"></i>
                <div class="info">
                    <h4>shipped</h4>
                    <p><b>{{ $shipped }}</b></p>
                </div>
            </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-4">
            <a class="dashboard_link" href="{{ route('orders.delivered') }}">
            <div class="widget-small info coloured-icon"><i class="icon fa fa-check fa-3x"></i>
                <div class="info">
                    <h4>Delivered</h4>
                    <p><b>{{ $delivered }}</b></p>
                </div>
            </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-4">
            <a class="dashboard_link" href="{{ route('orders.canceled') }}">
            <div class="widget-small danger coloured-icon"><i class="icon fa fa-remove fa-3x"></i>
                <div class="info">
                    <h4>Canceled</h4>
                    <p><b>{{ $canceled }}</b></p>
                </div>
            </div>
            </a>
        </div>
    </div>

    @if (auth()->user()->type != 'vendor')
    {{--<div class="row">
        <div class="col-md-6 col-lg-3">
            <a class="dashboard_link" href="{{ route('dispute.index') }}">
                <div class="widget-small primary coloured-icon" id="support"><i class="icon fa fa-commenting fa-3x"></i>
                    <div class="info">
                        <h4>Disputes</h4>
                        <p><b>{{ $disputes }}</b></p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a class="dashboard_link" href="{{ route('dispute.closed') }}">
                <div class="widget-small info coloured-icon" id="support"><i class="icon fa fa-comment fa-3x"></i>
                    <div class="info">
                        <h4>Closed Disputes</h4>
                        <p><b>{{ $disputes_closed }}</b></p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a class="dashboard_link" href="{{ route('ticket.index') }}">
                <div id="support" class="widget-small primary coloured-icon"><i class="icon fa fa-commenting-o fa-3x"></i>
                    <div class="info">
                        <h4>Tickets</h4>
                        <p><b>{{ $tickets }}</b></p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a class="dashboard_link" href="{{ route('ticket.closed') }}">
                <div class="widget-small info coloured-icon" id="support"><i class="icon fa fa-comment-o fa-3x"></i>
                    <div class="info">
                        <h4>Closed Tickets</h4>
                        <p><b>{{ $tickets_closed }}</b></p>
                    </div>
                </div>
            </a>
        </div>
    </div>--}}

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Daily Sales Report</h3>
                <div class="row">
                    <div class="table-responsive col-md-12">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Product</th>
                                <th>Amount</th>
                                <th>Payment Status</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($daily_orders as $order)
                                <tr>
                                    <td>{{ $order->order_number }}</td>
                                    <td>{{ $order->order_detail_count  }}</td>
                                    <td>{{ $order->amount  }}</td>
                                    <td>{{ ucfirst($order->payment_status) }}</td>
                                    <td>{{ ucfirst($order->status) }}</td>
                                    <td>
                                        <a href="{{ route('orders.show', base64_encode($order->id)) }}" target="_blank" class="btn btn-sm btn-info">Details</a>
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                            </tbody>
                        </table>
                        <span class="pull-right">{{ $daily_orders->render() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{--<div class="row">
        <div class="col-md-6 col-lg-3">
            <a class="dashboard_link" href="{{ route('vendor.index') }}">
                <div class="widget-small primary coloured-icon" id="support"><i class="icon fa fa-users fa-3x"></i>
                    <div class="info">
                        <h4>Vendor</h4>
                        <p><b>{{ $vendors }}</b></p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a class="dashboard_link" href="{{ route('vendor.pending') }}">
                <div class="widget-small info coloured-icon" id="support"><i class="icon fa fa-users fa-3x"></i>
                    <div class="info">
                        <h4>Pending Vendor</h4>
                        <p><b>{{ $vendors_pending }}</b></p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a class="dashboard_link" href="{{ route('review.index') }}">
                <div id="support" class="widget-small primary coloured-icon"><i class="icon fa fa-star fa-3x"></i>
                    <div class="info">
                        <h4>Reviews</h4>
                        <p><b>{{ $reviews }}</b></p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a class="dashboard_link" href="{{ route('review.pending') }}">
                <div class="widget-small info coloured-icon" id="support"><i class="icon fa fa-star-o fa-3x"></i>
                    <div class="info">
                        <h4>Pending Reviews</h4>
                        <p><b>{{ $reviews_pending }}</b></p>
                    </div>
                </div>
            </a>
        </div>
    </div>--}}
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">{{ (auth()->user()->type == 'vendor')?'Products': 'Customers' }}</h3>
                <div class="card-group">
                    <!-- Card -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <p class="card-text blue-text"><i class="fa fa-user fa-2x"></i><span class="ml-2" style="font-size: 30px;">{{ $customer }}</span></p>
                            <h5 class="card-title">New {{ (auth()->user()->type == 'vendor')?'Products': 'Customers' }}</h5>
                            <p>Last 30 Days</p>
                        </div>
                    </div>
                    <!-- Card -->

                    <!-- Card -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <p class="card-text blue-text"><i class="fa fa-user fa-2x"></i><span class="ml-2" style="font-size: 30px;">{{ $total_customer }}</span></p>
                            <h5 class="card-title">Total {{ (auth()->user()->type == 'vendor')?'Products': 'Customers' }}</h5>
                            <p>All Time</p>
                        </div>
                    </div>
                    <!-- Card -->
                </div>
                <!-- Card group -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">Orders</h3>
                <div class="card-group">
                    <!-- Card -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <p class="card-text blue-text"><i class="fa fa-archive fa-2x"></i><span class="ml-2" style="font-size: 30px;">{{ $order30 }}</span></p>
                            <h5 class="card-title">New Orders</h5>
                            <p>Last 30 Days</p>
                        </div>
                    </div>
                    <!-- Card -->

                    <!-- Card -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <p class="card-text blue-text"><i class="fa fa-archive fa-2x"></i><span class="ml-2" style="font-size: 30px;">{{ $total_order }}</span></p>
                            <h5 class="card-title">Total Orders</h5>
                            <p>All Time</p>
                        </div>
                    </div>
                    <!-- Card -->
                </div>
                <!-- Card group -->
            </div>
        </div>
    </div>

    <!-- Top Selling -->
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Top Selling Products</h3>
                <div class="row">
                    <div class="table-responsive col-md-6">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Product</th>
                                <th>Sale</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($top_selling as $index=>$product)
                                @if($index <= 4)
                                    <tr>
                                        <td>
                                            <a href="{{ route('product.show',$product->slug) }}">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <img src="{{ $product->product_image->count()>0 ?asset($product->product_image[0]->file_path):'' }}" style="max-width: 50px; max-height: 60px" class="mr-1" alt="product image">
                                                    </div>
                                                    <div class="col-md-10">
                                                        <p>{{ ucfirst($product->name) }}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </td>
                                        <td class="text-center">{{ $product->order_detail_count }}</td>
                                    </tr>
                                @endif
                            @empty
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive col-md-6">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Product</th>
                                <th>Sale</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($top_selling as $index=>$product)
                                @if($index > 4)
                                    <tr>
                                        <td>
                                            <a href="{{ route('product.show',$product->slug) }}">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <img src="{{ $product->product_image->count()>0 ?asset($product->product_image[0]->file_path):'' }}" style="max-width: 50px; max-height: 60px" class="mr-1" alt="product image">
                                                    </div>
                                                    <div class="col-md-10">
                                                        <p>{{ ucfirst($product->name) }}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </td>
                                        <td class="text-center">{{ $product->order_detail_count }}</td>
                                    </tr>
                                @endif
                            @empty
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Top Selling -->



    @if (auth()->user()->type != 'vendor')
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title">Monthly Sales</h3>
                    <div class="embed-responsive embed-responsive-16by9">
                        <canvas class="embed-responsive-item" id="lineChartDemo" width="475" height="267" style="width: 475px; height: 267px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

    <div class="row">
        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">Orders Chart</h3>
                <div class="embed-responsive embed-responsive-16by9">
                    <canvas class="embed-responsive-item" id="pieChartOrder"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">Users Chart</h3>
                <div class="embed-responsive embed-responsive-16by9">
                    <canvas class="embed-responsive-item" id="pieChartDemo"></canvas>
                </div>
            </div>
        </div>

    </div>
    @endif


@endsection




@push('library-css')

@endpush



@push('custom-css')
    <style>
        .dashboard_link:hover{
            text-decoration: none;
        }
        #support .icon {
            border-right: 2px solid #009688;
            background-color: #fff; !important;
            color: #1b1e21;
        }

        #support {
            border: 2px solid #009688;
        }
    </style>

@endpush



@push('library-js')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/chart.js') }}"></script>
@endpush


@push('custom-js')
    <script type="text/javascript">
        var data = {
            labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            datasets: [
                {
                    label: "Amount",
                    fillColor: "rgba(220,220,220,0.2)",
                    strokeColor: "rgba(220,220,220,1)",
                    pointColor: "rgba(220,220,220,1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(220,220,220,1)",
                    data: [{{ implode(',', $amount) }}]
                },
                {
                    label: "Orders",
                    fillColor: "rgba(151,187,205,0.2)",
                    strokeColor: "rgba(151,187,205,1)",
                    pointColor: "rgba(151,187,205,1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(151,187,205,1)",
                    data: [{{ implode(',', $sale) }}]
                }
            ]
        };
        var ctxl = $("#lineChartDemo").get(0).getContext("2d");
        var lineChart = new Chart(ctxl).Line(data);

    </script>

    @if (auth()->user()->type != 'vendor')
    <script>

        var pdata = [
            {
                value: {{ $subscriber }},
                color:"#F7464A",
                highlight: "#FF5A5E",
                label: "Subscriber"
            },
            {
                value: {{ $total_customer }},
                color: "#46BFBD",
                highlight: "#5AD3D1",
                label: "Customer"
            }
        ]

        var ctxp = $("#pieChartDemo").get(0).getContext("2d");
        var pieChart = new Chart(ctxp).Pie(pdata);


        var odata = [
            {
                value: {{ $pending }},
                color: "#F4B183",
                highlight: "#F7CBAC",
                label: "Pending"
            },
            {
                value: {{ $confirmed }},
                color: "#9CC3E5",
                highlight: "#BDD7EE",
                label: "Confirmed"
            },
            {
                value: {{ $processing }},
                color: "#B482DA",
                highlight: "#DBC3ED",
                label: "Processing"
            },
            {
                value: {{ $shipped }},
                color: "#A8D08D",
                highlight: "#C5E0B3",
                label: "Shipped"
            },
            {
                value: {{ $delivered }},
                color: "#46BFBD",
                highlight: "#5AD3D1",
                label: "Delivered"
            },
            {
                value: {{ $canceled }},
                color:"#F7464A",
                highlight: "#FF5A5E",
                label: "Canceled"
            }
        ]

        var ctx = $("#pieChartOrder").get(0).getContext("2d");
        var pieChart = new Chart(ctx).Pie(odata);
    </script>
    @endif
@endpush
