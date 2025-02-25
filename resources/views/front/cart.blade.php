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
            @if($cart != null)
            <form style="display: inline" action="{{ route('update.cart') }}" method="post">
                @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <table>
                            <thead>
                            <tr>
                                <th class="shoping__product">Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $total = 0;
                            @endphp
                                @foreach($cart as $item)
                                    <input type="hidden" name="id[]" value="{{ $item['product_id'] }}">
                                    <tr class="roww">
                                        <td class="shoping__cart__item">
                                            <img style="max-width: 100px; max-height: 75px;" src="{{ asset($item['image']) }}" alt="Product_image">
                                            <h5>{{ ucfirst($item['name']) }}</h5>
                                        </td>
                                        <td class="shoping__cart__price">
                                            @php
                                                if (isset($item['flash_price']) && $item['flash_price'] != null){
                                                    $price = $item['flash_price'];
                                                }
                                                elseif ($item['new_price']){
                                                    $price = $item['new_price'];
                                                }
                                                else{
                                                    $price = $item['price'];
                                                }
                                            @endphp
                                             <input class="price" type="text" name="price[]" value="{{ $price }}" readonly>

                                           {{--  {{ ($item['new_price'])? $item['new_price']: $item['price'] }}--}}
                                        </td>
                                        <td class="shoping__cart__quantity">
                                            <div class="quantity">
                                                <div class="pro-qty">
                                                    <input class="qty" type="text" name="quantity[]" value="{{ $item['quantity'] }}" readonly>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="shoping__cart__total">
                                            @php
                                                if (isset($item['flash_price']) && $item['flash_price'] != null){
                                                    $cart_total = $item['flash_price']*$item['quantity'];
                                                }
                                                elseif ($item['new_price']){
                                                    $cart_total = $item['new_price']*$item['quantity'];
                                                }
                                                else{
                                                    $cart_total = $item['price']*$item['quantity'];
                                                }
                                            @endphp
                                             <input class="total" name="total[]" type="text" value="{{ $cart_total }}" readonly>
                                            {{-- {{ $cart_total }}--}}
                                            {{-- {{ ($item['new_price'])? $item['new_price']*$item['quantity']: $item['price']*$item['quantity'] }}--}}
                                        </td>

                                        <td class="shoping__cart__item__close">
                                            <a href="{{ route('remove.cart',$item['slug']) }}"><span class="icon_close"></span></a>
                                        </td>
                                    </tr>


                                    @php
                                        $total += $cart_total ;
                                    @endphp
                                @endforeach

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__btns">
                        <a href="{{ route('clear.cart') }}" class="primary-btn cart-btn">Clear Cart</a>
                        <button type="submit" class="primary-btn cart-btn cart-btn-right"><span class="icon_loading"></span>Update Cart</button>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="shoping__checkout">
                        <h5>Cart Total</h5>
                        <ul>
                            <li>Subtotal <span> {{ $total }}</span></li>
                            <li>Total <span> {{ $total }}</span></li>
                        </ul>
                        <a href="{{ route('checkout') }}" class="primary-btn">PROCEED TO CHECKOUT</a>
                    </div>
                </div>
            </div>
            </form>
            @else
                <h5 class="text-center">Cart is empty</h5>
            @endif
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

        input[readonly]
        {
            border: none;
            width: 50px;
            font-weight: bold;
        }
    </style>
@endpush



@push('library-js')

@endpush



@push('custom-js')

@endpush
