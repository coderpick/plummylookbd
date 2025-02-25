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
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                            <tr>

                                <th>Product Name</th>
                                <th>Click</th>
                                <th>SKU</th>
                                <th>Price</th>
                                <th>New Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $now = \Carbon\Carbon::today()->toDateString();
                            @endphp

                            @foreach($products as $product)
                                <tr>
                                    <td>
                                        <a href="{{ route('product.details', $product->slug) }}">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <img src="{{ $product->product_image->count()>0 ?asset($product->product_image[0]->file_path):'' }}" style="max-width: 50px; max-height: 60px" loading="lazy" class="mt-2 mr-3" alt="product image">
                                                </div>
                                                <div class="col-md-10">
                                                    <h6>{{ ucfirst($product->name) }}</h6>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td>{{ $product->view_count }}</td>
                                    <td>{{ $product->code }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->new_price }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>
                                        @if($product->status == 'active')
                                            <span class="text-success">{{ ucfirst($product->status) }}</span>
                                        @else
                                            <span class="text-danger">{{ ucfirst($product->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="float-right">{{ $products->render() }}</div>
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
@endpush



@push('custom-js')
    <script type="text/javascript">

    </script>
@endpush
