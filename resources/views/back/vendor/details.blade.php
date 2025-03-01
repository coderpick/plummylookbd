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
        <div class="col-md-10">
            <div class="tile">
                <div class="col-md-12 row">

                        {{--<a href="{{ route('orders.customer',$user->slug ) }}" class="btn btn-sm btn-info">View Orders</a>--}}

                </div>
                <br>
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tr>
                                <th> </th>
                                <td><img class="img-fluid" style="max-width: 30%" src="{{ asset($user->image != null? Auth::user()->image : 'uploads/user_default.jpg') }}"></td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>{{ ucfirst($user->name) }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td><a href="tel:{{ $user->phone }}">{{ $user->phone }}</a></td>
                            </tr>
                            <tr>
                                <th>Address</th>

                                @if ($user->detail)
                                <td>{{ ucfirst($user->detail->address_1).', '.$user->detail->address_2.', '.$user->detail->district->name.'  '.$user->detail->zip }}</td>
                                @else
                                    <td>N/A</td>
                                @endif
                            </tr>
                            <tr>
                                <th>Shop Name</th>
                                <td>{{ ucfirst($user->shop->name) }}</td>
                            </tr>
                            {{--<tr>
                                <th>Commission</th>
                                <td>
                                    <form action="{{ route('vendor.commission',$user->shop->id) }}" method="post" style="display: inline">
                                        @csrf
                                        <input type="number" style="width: 100px; border: 1px solid #ced4da;" name="commission" value="{{ $user->shop->commission }}"> % &nbsp; &nbsp;
                                        <button type="submit" class="btn btn-sm btn-outline-primary" onclick="return confirm('Are you sure to Update?')">Update</button>
                                    </form>
                                </td>
                            </tr>--}}
                            <tr>
                                <th>Shop Description</th>
                                <td>{{ ucfirst($user->shop->description) }}</td>
                            </tr>
                        </table>

                        <h5 class="text-center">Bank Information</h5>
                        <div class="table-responsive">
                        <table class="table table-hover">
                            <tr>
                                <th style="width:25%">Bank Name</th>
                                <td>{{ ucfirst($user->shop->bank) }}</td>
                            </tr>
                            <tr>
                                <th>Branch</th>
                                <td>{{ ucfirst($user->shop->branch) }}</td>
                            </tr>
                            <tr>
                                <th>Account Holder Name</th>
                                <td>{{ ucfirst($user->shop->acc_name) }}</td>
                            </tr>
                            <tr>
                                <th>Account Number</th>
                                <td>{{ ucfirst($user->shop->acc_no) }}</td>
                            </tr>
                            <tr>
                                <th>Routing Number</th>
                               {{-- <td>{{ ucfirst($user->shop->routing_no) }}</td>--}}
                                <td>
                                    <form action="{{ route('vendor.commission',$user->shop->id) }}" method="post" style="display: inline">
                                        @csrf
                                        <input type="number" style="width: 200px; border: 1px solid #ced4da;" name="routing_no" value="{{ $user->shop->routing_no }}"> &nbsp; &nbsp;
                                        <button type="submit" class="btn btn-sm btn-outline-primary" onclick="return confirm('Are you sure to Update?')">Update</button>
                                    </form>
                                </td>

                            </tr>
                            <tr>
                                <th>Cheque Leaf</th>
                                <td><img id="myImg" class="img-fluid" style="max-width: 30%" src="{{ asset($user->shop->cheque != null? $user->shop->cheque : 'uploads/default.jpg') }}"></td>
                            </tr>
                        </table>
                    </div>
                        <!-- The Modal -->
                        <div id="myModal" class="modal">
                            <span class="close">&times;</span>
                            <img class="modal-content" id="img01">
                            <div id="caption"></div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="tile">
                            <div class="card-group">
                                <!-- Card -->
                                <div class="card mb-4">
                                    <a href="{{ route('vendor.product', $user->shop->slug ) }}" class="text-decoration-none">
                                        <div class="card-body">
                                            <p class="card-text blue-text"><i class="fa fa-archive fa-2x"></i><span class="ml-2" style="font-size: 30px;">{{ $product }}</span></p>
                                            <h5 class="card-title">Products</h5>
                                        </div>
                                    </a>
                                </div>
                                <!-- Card -->

                                <!-- Card -->
                                <div class="card mb-4">
                                    <a href="{{ route('vendor.order', $user->shop->slug ) }}" class="text-decoration-none">
                                        <div class="card-body">
                                            <p class="card-text blue-text"><i class="fa fa-archive fa-2x"></i><span class="ml-2" style="font-size: 30px;">{{ $order }}</span></p>
                                            <h5 class="card-title">Orders</h5>
                                        </div>
                                    </a>
                                </div>
                                <!-- Card -->
                            </div>
                            <!-- Card group -->
                        </div>
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

        #myImg {
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        #myImg:hover {opacity: 0.7;}

        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
        }

        /* Modal Content (image) */
        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }

        /* Caption of Modal Image */
        #caption {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
            text-align: center;
            color: #ccc;
            padding: 10px 0;
            height: 150px;
        }

        /* Add Animation */
        .modal-content, #caption {
            -webkit-animation-name: zoom;
            -webkit-animation-duration: 0.6s;
            animation-name: zoom;
            animation-duration: 0.6s;
        }

        @-webkit-keyframes zoom {
            from {-webkit-transform:scale(0)}
            to {-webkit-transform:scale(1)}
        }

        @keyframes zoom {
            from {transform:scale(0)}
            to {transform:scale(1)}
        }

        /* The Close Button */
        .close {
            position: absolute;
            top: 100px;
            right: 85px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        /* 100% Image Width on Smaller Screens */
        @media only screen and (max-width: 700px){
            .modal-content {
                width: 100%;
            }
        }
    </style>
@endpush



@push('library-js')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
@endpush



@push('custom-js')
    <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the image and insert it inside the modal - use its "alt" text as a caption
        var img = document.getElementById("myImg");
        var modalImg = document.getElementById("img01");
        var captionText = document.getElementById("caption");
        img.onclick = function(){
            modal.style.display = "block";
            modalImg.src = this.src;
            captionText.innerHTML = this.alt;
        }

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }
    </script>
@endpush
