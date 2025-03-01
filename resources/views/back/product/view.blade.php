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
                <h2>{{ $title }} <a href="{{ route('product.edit',$product->slug) }}" class="btn btn-info float-right">Edit</a></h2>
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
                                <td>Product Name</td>
                                <td>{{ ucfirst($product->name) }}</td>
                            </tr>

                            <tr>
                                <td>Shop Name</td>
                                <td>
                                    @if($product->shop!=null)
                                        {{ ucfirst($product->shop->name) }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td>Product Code</td>
                                <td>
                                    @if($product->code!=null)
                                        {{ ucfirst($product->code) }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td>Reward Point</td>
                                <td>
                                    @if($product->point!=null)
                                        {{ $product->point }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td>Is Featured?</td>
                                <td>@if($product->is_featured == 1) Yes @else No @endif</td>
                            </tr>

                            <tr>
                                <td>Flash Sale?</td>
                                <td>@if($product->flash_sale == 1) Yes &nbsp; &nbsp; {{ ($product->expires_at != null)?'Expire: '.date('d-m-Y', strtotime($product->expires_at)):'' }}@else No @endif</td>
                            </tr>

                            {{--<tr>
                                <td>Category</td>
                                <td>{{ ucfirst($product->category->name) }}</td>
                            </tr>
                            @if(count($product->category->subcategory))
                                <tr>
                                    <td>Sub-Category</td>
                                    <td>{{ ucfirst($product->category->subcategory[0]->name) }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td>Brand</td>
                                <td>{{ ucfirst($product->brand->name) }}</td>
                            </tr>--}}
                            <tr>
                                <td>Size</td>
                                <td>
                                    @if($product->size!=null)
                                        {{ $product->size }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Color</td>
                                <td>
                                    @if($product->color!=null)
                                        {{ ucfirst($product->color) }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Stock</td>
                                <td>{{ $product->stock }}</td>
                            </tr>
                            <tr>
                                <td>Price</td>
                                <td>{{ $product->price }}</td>
                            </tr>
                            <tr>
                                <td>Offer Price</td>
                                <td>
                                    @if($product->new_price!=null)
                                        {{ ucfirst($product->new_price) }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td>Status</td>
                                <td>
                                    @if($product->status == 'active')
                                        <span class="text-success">{{ ucfirst($product->status) }}</span>
                                    @else
                                        <span class="text-danger">{{ ucfirst($product->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Product Images</td>
                                <td>
                                    <div>
                                        @if(count($product->product_image))
                                            @foreach($product->product_image as $image)
                                                <div class="d-inline">
                                                    <img id="myImg" style="max-height: 130px; max-width: 28%;" src="{{ asset($image->file_path) }}" alt="">
                                                    {{--<a href="{{ route('product.delete.image',$image->id) }}" class="btn"> X </a>--}}
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>Details</td>
                                <td>
                                    {!! ucfirst($product->details) !!}
                                </td>
                            </tr>

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
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
@endpush

@push('custom-js')
@endpush
