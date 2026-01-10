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
                {{-- @if (!isset($vendor))
                <div class="col-md-12 row">
                    <a href="{{ route('product.create') }}" class="btn btn-primary mr-1">Add New Product</a>
                    <a href="{{ route('product.featured') }}" class="btn btn-info float-right mr-1 {{ Request::is('secure/products/featured')?'disabled':'' }}">Featured</a>
                </div>
                @endif --}}


                <div class="row">
                    <div class="col-md-6">

                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('product.create') }}" class="btn btn-primary float-right mr-1">Add New Product</a>
                        <a href="{{ route('product.featured') }}"
                            class="btn btn-info float-right mr-1 {{ Request::is('secure/products/featured') ? 'disabled' : '' }}">Featured</a>
                    </div>
                </div>
                <br>
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>Made In</th>
                                    <th>For</th>
                                    <th>Price</th>
                                    <th>Offer Price</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $now = \Carbon\Carbon::today()->toDateString();
                                @endphp

                                @foreach ($products as $key => $product)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <a target="_blank" href="{{ route('product.details', $product->slug) }}">
                                                <div class="media">
                                                    <img src="{{ $product->product_image->count() > 0 ? asset($product->product_image[0]->file_path) : '' }}"
                                                        style="max-width: 50px; max-height: 60px" loading="lazy"
                                                        class="align-self-center mr-3 rounded" alt="product image">
                                                    <div class="media-body product-name">
                                                        <h6 class="mt-0 text-body">{{ ucfirst($product->name) }}</h6>
                                                    </div>
                                                </div>
                                            </a>
                                        </td>
                                        <td>{{ $product->category?->name }}</td>
                                        <td>{{ $product->brand?->name }}</td>
                                        <td>{{ $product->made_in ?? 'N/A' }}</td>
                                        <td>
                                            @if ($product->is_featured == 1)
                                                <span class="badge badge-primary">Featured</span>
                                            @elseif($product->is_featured == 2)
                                                <span class="badge badge-success">New Arrival</span>
                                            @elseif($product->is_featured == 3)
                                                <span class="badge badge-danger"> Best Selling</span>
                                            @elseif($product->is_featured == 4)
                                                On Sale
                                            @else
                                                <span class="badge badge-secondary"> Regular</span>
                                            @endif
                                        </td>

                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->new_price }}</td>
                                        <td>
                                            @if ($product->stock >= 10)
                                                <span style="width: 30px;height: 30px"
                                                    class="bg-success text-white p-1 w rounded d-inline-flex align-items-center justify-content-center">
                                                    {{ $product->stock }}</span>
                                            @elseif ($product->stock >= 5)
                                                <span style="width: 30px;height: 30px"
                                                    class="bg-warning text-white p-1 w rounded d-inline-flex align-items-center justify-content-center">
                                                    {{ $product->stock }}</span>
                                            @else
                                                <span style="width: 30px;height: 30px"
                                                    class="bg-danger text-white p-1 w rounded d-inline-flex align-items-center justify-content-center">
                                                    {{ $product->stock }}</span>
                                            @endif


                                        </td>
                                        <td>
                                            @if ($product->status == 'active')
                                                <span class="badge badge-success">{{ ucfirst($product->status) }}</span>
                                            @else
                                                <span class="badge badge-secondary">{{ ucfirst($product->status) }}</span>
                                            @endif
                                        </td>

                                        <td width="12%" class="product-action-cell">
                                            @if ($product->deleted_at == null)
                                                <a href="{{ route('product.show', $product->slug) }}"
                                                    class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
                                                <a href="{{ route('product.edit', $product->slug) }}"
                                                    class="btn btn-sm btn-success"><i class="fa fa-edit"></i></a>
                                                <form action="{{ route('product.destroy', $product->slug) }}"
                                                    method="post" style="display: inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-warning"
                                                        onclick="return confirm('Are you sure to delete?')"><i
                                                            class="fa fa-trash"></i></button>
                                                </form>
                                            @else
                                                <form action="{{ route('product.restore', $product->id) }}" method="post"
                                                    style="display: inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-primary"
                                                        onclick="return confirm('Do you want this back?')"><i
                                                            class="fa fa-undo"></i></button>
                                                </form>

                                                <form action="{{ route('product.delete', $product->id) }}" method="post"
                                                    style="display: inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Confirm to permanently remove?')"><i
                                                            class="fa fa-trash"></i></button>
                                                </form>
                                            @endif
                                        </td>
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
    <style>
        td.product-name {
            text-wrap: wrap !important;
            word-wrap: break-word !important
        }


        @media only screen and (max-width: 1366px) {
            .product-action-cell {
                width: 14% !important;
                text-align: center !important
            }
        }
    </style>
@endpush



@push('library-js')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        $('#sampleTable').DataTable();
    </script>
@endpush



@push('custom-js')
    <script type="text/javascript">
        $('#checkAll').click(function() {
            $('input:checkbox').prop('checked', this.checked);
        });
    </script>
@endpush
