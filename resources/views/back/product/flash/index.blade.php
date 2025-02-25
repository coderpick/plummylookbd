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
            <li class="breadcrumb-item active"><a href="{{ route('product.index') }}">{{ $title }}</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="col-md-12 row">
                    <a href="{{ route('flash.create') }}" class="btn btn-primary mr-1">Add More Items</a>
                   </div>

                <br>
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                            <tr>
                                <th style="display: none;">Id</th>
                                <th>Product Name</th>
                                <th>Shop</th>
                                <th>Expiry</th>
                                <th>MRP</th>
                                <th>New Price</th>
                                <th>Stock</th>
                                <th>Flash Price</th>
                                <th>Flash Stock</th>
                                <th>Expires</th>
                                <th>Action</th>

                            </tr>
                            </thead>
                            <tbody>
                            @php
                               $now = \Carbon\Carbon::today()->toDateString();
                            @endphp


                            @foreach($products as $product)

                                    <tr>
                                        <form action="{{ route('flash.update', $product->back_flash->id) }}" method="get">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $product->id }}">
                                            <td style="display: none;">{{ $product->id }}</td>
                                            <td>{{ ucfirst($product->name) }}</td>
                                            <td>{{ ucfirst(($product->shop != null)?$product->shop->name: 'N/A' ) }}</td>
                                            <td>{{ ($product->back_flash->expires_at < $now)?'Expired':$product->back_flash->expires_at }}</td>
                                            <td>{{ $product->price }}</td>
                                            <td>{{ $product->new_price }}</td>
                                            <td>{{ $product->stock }}</td>
                                            <td><input class="form-control" type="number" name="flash_price" value="{{ $product->back_flash->flash_price }}"></td>
                                            <td><input class="form-control" type="number" name="flash_stock" value="{{ $product->back_flash->flash_stock }}"></td>
                                            <td><input class="form-control" type="date" name="expires_at" value="{{ $product->back_flash->expires_at }}"></td>
                                            <td>
                                                <button type="submit" class="btn btn-sm btn-info">Update</button>
                                                <a href="{{ route('flash.destroy',base64_encode($product->back_flash->id)) }}" onclick="return confirm('Confirm to permanently remove?')" class="btn btn-sm btn-danger">Delete</a>
                                            </td>
                                        </form>
                                    </tr>

                            @endforeach
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

@endpush



@push('library-js')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable({ order: [ [0, 'desc'] ]});</script>
@endpush



@push('custom-js')

@endpush
