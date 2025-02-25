@extends('layouts.frontend.master')

@section('content')
    <section class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>{{ ucfirst($title) }}</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ route('home') }}">Home</a>
                            <span>{{ ucfirst($title) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shoping Cart Section Begin -->
    <section class="shoping-cart spad">
        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        @if( $products != null && $products->count()>0)
                        <table>
                            <thead>
                            <tr>
                                <th class="shoping__product">Products</th>
                                <th> </th>
                                <th width="25%"></th>
                                <th> </th>
                            </tr>
                            </thead>
                            <tbody>

                                @foreach($products as $product)

                                    <tr>
                                        <td class="shoping__cart__item">
                                            <a href="{{ route('product.details', $product->slug) }}">
                                            <img style="max-width: 100px; max-height: 100px;" src="{{ asset(isset($product->product_image[0])?$product->product_image[0]->file_path:'uploads/default.jpg') }}" alt="Product_image">
                                            <h5>{{ ucfirst($product->name) }}</h5>
                                            </a>
                                        </td>
                                        <td class="shoping__cart__price">
                                            @if (isset($product->flash) && $product->flash->flash_price != null)
                                             {{ $product->flash->flash_price }}
                                            @else
                                             {{ ($product->new_price)? $product->new_price: $product->price }}
                                            @endif
                                        </td>
                                        <td class="shoping__cart__total">
                                            <form style="display: inline" action="{{ route('add.fav',$product->id) }}" method="post">
                                                @csrf
                                                <button style="border: none" class="primary-btn">Add Cart</button>
                                            </form>
                                        </td>
                                        <td class="shoping__cart__item__close">
                                            <form style="display: inline" action="{{ route('remove.fav',$product->id) }}" method="post">
                                                @csrf
                                                <button style="border: none; background-color: unset;"><span class="icon_close"></span></button>
                                            </form>
                                            {{--<a href="#"><span class="icon_close"></span></a>--}}
                                        </td>
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                            <br>
                            <div class="col-lg-12">
                                <div class="shoping__cart__btns">
                                    <a href="{{ route('product.category') }}" class="primary-btn cart-btn">Add More Products</a>
                                    {{--<a href="{{ route('product.category') }}" class="primary-btn cart-btn cart-btn-right">CLEAR LIST</a>--}}
                                    {{--<form style="display: inline" action="{{ route('clear.fav', auth()->user()->id) }}" method="post">
                                        @csrf--}}
                                        <button type="button" class="primary-btn cart-btn cart-btn-right" data-toggle="modal" data-target="#myModal"><i class="icofont-ui-delete"></i>CLEAR LIST</button>
                                    {{--</form>--}}
                                </div>
                            </div>
                        @else
                        <h5 class="text-center">Favourite list is empty</h5>
                        @endif
                    </div>
                </div>
            </div>

            {{--<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content" style="border:none;">
                        <div class="modal-header text-white" style="background-color: #66b751;">
                            <h5 class="modal-title " id="exampleModalLabel">Clear List</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to clear your favourite list?
                        </div>
                        <div class="modal-footer">
                            <form style="display: inline" action="{{ route('clear.fav', auth()->user()->id) }}" method="post">
                                @csrf
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-success">Yes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>--}}

            <div id="myModal" class="modal fade">
                <div class="modal-dialog modal-confirm">
                    <div class="modal-content">
                        <div class="modal-header flex-column">
                            <div class="icon-box">
                                <i class="icofont-close-line"></i>
                            </div>
                            <h4 class="modal-title w-100">Are you sure?</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <p>Do you really want to clear favourite list?</p>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <form style="display: inline" action="{{ route('clear.fav', auth()->user()->id) }}" method="post">
                                @csrf
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Clear</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- Shoping Cart Section End -->

@endsection




@push('library-css')

@endpush



@push('custom-css')
    <style>
        .cart-btn-right{
            border: none;
        }

        .modal-confirm {
            color: #636363;
            width: 400px;
        }
        .modal-confirm .modal-content {
            padding: 20px;
            border-radius: 5px;
            border: none;
            text-align: center;
            font-size: 14px;
        }
        .modal-confirm .modal-header {
            border-bottom: none;
            position: relative;
        }
        .modal-confirm h4 {
            text-align: center;
            font-size: 26px;
            margin: 30px 0 -10px;
        }
        .modal-confirm .close {
            position: absolute;
            top: -5px;
            right: -2px;
        }
        .modal-confirm .modal-body {
            color: #999;
        }
        .modal-confirm .modal-footer {
            border: none;
            text-align: center;
            border-radius: 5px;
            font-size: 13px;
            padding: 10px 15px 25px;
        }
        .modal-confirm .modal-footer a {
            color: #999;
        }
        .modal-confirm .icon-box {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            border-radius: 50%;
            z-index: 9;
            text-align: center;
            border: 3px solid #f15e5e;
        }
        .modal-confirm .icon-box i {
            color: #f15e5e;
            font-size: 46px;
            display: inline-block;
            margin-top: 13px;
        }
        .modal-confirm .btn, .modal-confirm .btn:active {
            color: #fff;
            border-radius: 4px;
            background: #243789;
            text-decoration: none;
            transition: all 0.4s;
            line-height: normal;
            min-width: 120px;
            border: none;
            min-height: 40px;
            border-radius: 3px;
            margin: 0 5px;
        }
        .modal-confirm .btn-secondary {
            background: #c1c1c1;
        }
        .modal-confirm .btn-secondary:hover, .modal-confirm .btn-secondary:focus {
            background: #a8a8a8;
        }
        .modal-confirm .btn-danger {
            background: #f15e5e;
        }
        .modal-confirm .btn-danger:hover, .modal-confirm .btn-danger:focus {
            background: #ee3535;
        }
        .trigger-btn {
            display: inline-block;
            margin: 100px auto;
        }
    </style>
@endpush



@push('library-js')

@endpush



@push('custom-js')

@endpush
