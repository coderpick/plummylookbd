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
                {{--@if (!isset($vendor))
                <div class="col-md-12 row">
                    <a href="{{ route('product.create') }}" class="btn btn-primary mr-1">Add New Product</a>
                    <a href="{{ route('product.featured') }}" class="btn btn-info float-right mr-1 {{ Request::is('secure/products/featured')?'disabled':'' }}">Featured</a>
                </div>
                @endif--}}

                <form action="{{ route('applyMultiple') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <label for="m_status"></label>
                                <select id="m_status" name="product_type" class="form-control">
                                    <option value="">Select Option</option>
                                    <option value="0">Regular</option>
                                    <option value="1">Featured</option>
                                    <option value="2">New Arrival</option>
                                    <option value="3">Best Selling</option>
                                    <option value="4">On Sale</option>
                                </select>
                            </div>
                            &nbsp;
                            <button type="submit" class="btn btn-primary mr-1" id="multi-btn"><span>Apply</span></button>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('product.create') }}" class="btn btn-primary float-right mr-1">Add New Product</a>
                            <a href="{{ route('product.featured') }}" class="btn btn-info float-right mr-1 {{ Request::is('secure/products/featured')?'disabled':'' }}">Featured</a>
                        </div>
                    </div>
                    <br>
                    <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th style="display: none;">Id</th>
                            <th><input type="checkbox" id="checkAll" name="checkAll"> All</th>
                            <th>Product Name</th>
                            <th>For</th>
                            <th>SKU</th>
                            <th>Price</th>
                            <th>New Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                           $now = \Carbon\Carbon::today()->toDateString();
                        @endphp

                        @foreach($products as $product)
                        <tr>
                            <td style="display: none;">{{ $product->id }}</td>
                            <td><input class="status_change" type="checkbox" name="ids[]" value="{{ $product->id }}"></td>
                            <td>
                                <a target="_blank" href="{{ route('product.details', $product->slug) }}">
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
                            <td>
                                @if($product->is_featured == 1)
                                    Featured
                                @elseif($product->is_featured == 2)
                                    New Arrival
                                @elseif($product->is_featured == 3)
                                    Best Selling
                                 @elseif($product->is_featured == 4)
                                    On Sale
                                    @else
                                    Regular
                                @endif
                            </td>
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

                            <td>
                                @if($product->deleted_at == null)
                                    <a href="{{ route('product.show',$product->slug) }}" class="btn btn-sm btn-primary"><i class="fa fa-info"></i></a>
                                    <a href="{{ route('product.edit',$product->slug) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('product.destroy',$product->slug) }}" method="post" style="display: inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Are you sure to delete?')"><i class="fa fa-trash"></i></button>
                                    </form>
                                @else
                                    <form action="{{ route('product.restore',$product->id) }}" method="post" style="display: inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Do you want this back?')"><i class="fa fa-undo"></i></button>
                                    </form>

                                    <form action="{{ route('product.delete',$product->id) }}" method="post" style="display: inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Confirm to permanently remove?')"><i class="fa fa-trash"></i></button>
                                    </form>
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
    </script>
@endpush
