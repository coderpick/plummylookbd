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
                <form action="{{ route('flash.store') }}" method="post">
                    @csrf
                <div class="col-md-12 row">
                    <button type="submit" class="btn btn-primary mr-1">Add To Flash</button>
                   </div>

                <br>
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                            <tr>
                                <th style="display: none;">Id</th>
                                <th> </th>
                                <th>Product Name</th>
                                <th>Shop</th>
                                <th>MRP</th>
                                <th>New Price</th>
                                <th>Stock</th>
                                <th>Flash Price</th>
                                <th>Flash Stock</th>
                                <th>Expires</th>

                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $now = Carbon\Carbon::now();
                                $tomorrow = $now->addDays(1)->toDateString();
                            @endphp

                            @foreach($products as $product)
                            <tr>

                                    <td style="display: none;"><input type="hidden" value="{{ $product->id }}"></td>
                                    <td><input class="flas_check" type="checkbox" name="flash[]" value="{{ $product->id }}"></td>
                                    <td>{{ ucfirst($product->name) }}</td>
                                    <td>{{ ucfirst(($product->shop != null)?$product->shop->name: 'N/A' ) }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->new_price }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td><input class="form-control price"  disabled value="{{ isset($product->new_price)? $product->new_price : $product->price }}" type="number" name="flash_price[]"></td>
                                    <td><input class="form-control stock" disabled value="{{ $product->stock }}" type="number" name="flash_stock[]"></td>
                                    <td><input class="form-control expires" disabled type="date" value="{{ $tomorrow }}" name="expires_at[]"></td>

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

       /* $('.flas_check').on("click", function() {
            var status=this.checked;
            if(status) {
                console.log(this.checked);
                $(this).parent().parent().find('.price').removeAttr('disabled');
                $(this).parent().parent().find('.stock').removeAttr('disabled');
                $(this).parent().parent().find('.expires').removeAttr('disabled');
            }else{
                console.log(this.checked);
                $(this).parent().parent().find('.price').attr('disabled',true);
                $(this).parent().parent().find('.stock').attr('disabled',true);
                $(this).parent().parent().find('.expires').attr('disabled',true);
            }
        });*/


        $('#sampleTable').on("change", ".flas_check", function (event) {
            var status = $('#sampleTable :input[type="checkbox"]:checked').length;

            if (status > 0) {
                $(this).parent().parent().find('.price').removeAttr('disabled');
                $(this).parent().parent().find('.stock').removeAttr('disabled');
                $(this).parent().parent().find('.expires').removeAttr('disabled');
            }
            else {
                $(this).parent().parent().find('.price').attr('disabled',true);
                $(this).parent().parent().find('.stock').attr('disabled',true);
                $(this).parent().parent().find('.expires').attr('disabled',true);
            }
        });
    </script>
@endpush
