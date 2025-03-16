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
    <section class="checkout spad">
        <div class="container">
            <div class="checkout__form">
                <h4>Billing Details</h4>
                <form action="{{ route('order.place') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8 col-md-6">

                            <div class="checkout__input__checkbox">
                                Default shipping address
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div id="def_ship" class="shipping-address-box active">
                                        <div class="checkout__input">
                                            <h>{{ ucfirst(auth()->user()->name) }}</h>
                                            <p class="clear"><span class="f_title">Phone: </span>{{ ucfirst(auth()->user()->phone) }}</p>
                                            <p class="clear"><span class="f_title">Email: </span>{{ ucfirst(auth()->user()->email) }}</p>
                                            {{--<p class="clear"><span class="f_title">District: </span>{{ (auth()->user()->detail)?auth()->user()->detail->district->name: '' }}  &nbsp; <span class="f_title">Zip: </span>{{ (auth()->user()->detail)?auth()->user()->detail->zip: '' }}</p>
                                            <p class="clear"><span class="f_title">Address: </span>{{ (auth()->user()->detail)?ucfirst(auth()->user()->detail->address_1): '' }}, {{ (auth()->user()->detail)?auth()->user()->detail->address_2: '' }}</p>
                                        --}}

                                            <br>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="checkout__input">
                                                        <p class="clear"><span class="f_title">District: </span></p>

                                                        <select id="district" name="district" class="js-states form-control wrapper district @error('district') is-invalid @enderror">
                                                            @foreach ($districts as $district)
                                                                <option {{ (auth()->user()->detail) && auth()->user()->detail->district_id == $district->id?'selected': '' }} value="{{ $district->id }}">{{ ucfirst($district->name) }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('district')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="checkout__input">
                                                        <p class="clear"><span class="f_title">Postcode / Zip: </span></p>
                                                        <input class="@error('zip') is-invalid @enderror" value="{{ (auth()->user()->detail)?ucfirst(auth()->user()->detail->zip): '' }}" name="zip" id="zip" type="number">
                                                        @error('zip')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <p class="clear"><span class="f_title ">Address: </span></p>
                                            <input class="@error('address_1') is-invalid @enderror checkout__input__add" type="text" name="address_1" value="{{ (auth()->user()->detail)?ucfirst(auth()->user()->detail->address_1): '' }}">
                                            @error('address_1')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror

                                            <br>

                                            <input class="@error('address_2') is-invalid @enderror" type="text" name="address_2" type="text" value="{{ (auth()->user()->detail)?ucfirst(auth()->user()->detail->address_2): '' }}">
                                            @error('address_2')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>

                            {{--<div class="checkout__input__checkbox">
                                <label for="diff-acc">
                                    Ship to a different address?
                                    <input type="checkbox" id="diff-acc">
                                    <span class="checkmark"></span>
                                </label>
                            </div>--}}

                           {{-- <div id="ship_address" class="checkout__input">
                                <div class="shipping-address-box active">
                                    <div class="checkout__input">
                                        <h>{{ ucfirst(auth()->user()->name) }}</h>
                                        <p class="clear"><span class="f_title">Phone: </span>{{ ucfirst(auth()->user()->phone) }}</p>
                                        <p class="clear"><span class="f_title">Email: </span>{{ ucfirst(auth()->user()->email) }}</p>
                                        --}}{{--<p class="clear"><span class="f_title">District: </span>{{ (auth()->user()->detail)?auth()->user()->detail->district->name: '' }}  &nbsp; <span class="f_title">Zip: </span>{{ (auth()->user()->detail)?auth()->user()->detail->zip: '' }}</p>--}}{{--

                                        <br>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="checkout__input">
                                                    <p class="clear"><span class="f_title">District: </span></p>

                                                    <select id="district" name="district" class="js-states form-control wrapper district @error('district') is-invalid @enderror">
                                                        @foreach ($districts as $district)
                                                            <option {{ (auth()->user()->detail) && auth()->user()->detail->district_id == $district->id?'selected': '' }} value="{{ $district->id }}">{{ ucfirst($district->name) }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('district')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="checkout__input">
                                                    <p class="clear"><span class="f_title">Postcode / Zip: </span></p>
                                                    <input class="@error('zip') is-invalid @enderror" value="{{ (auth()->user()->detail)?ucfirst(auth()->user()->detail->zip): '' }}" name="zip" id="zip" type="number">
                                                    @error('zip')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <p class="clear"><span class="f_title ">Address: </span></p>
                                        <input class="@error('address_1') is-invalid @enderror checkout__input__add" type="text" name="address_1" value="{{ (auth()->user()->detail)?ucfirst(auth()->user()->detail->address_1): '' }}">
                                        @error('address_1')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                        <br>

                                        <input class="@error('address_2') is-invalid @enderror" type="text" name="address_2" type="text" value="{{ (auth()->user()->detail)?ucfirst(auth()->user()->detail->address_2): '' }}">
                                        @error('address_2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                    </div>
                                </div>
                            </div>--}}

                            <!-- End .collapse -->

                           {{-- <div id="ship_address" class="checkout__input">
                                <p>Address<span></span></p>
                                <input class="@error('address_1') is-invalid @enderror" type="text" name="address_1" placeholder="Address line 1" class="checkout__input__add">
                                @error('address_1')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <br>
                                <br>

                                <input class="@error('address_2') is-invalid @enderror" type="text" name="address_2" type="text" placeholder="Address line 2">
                                @error('address_2')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>--}}

                        </div>
                        <div class="col-lg-4 col-md-6">
                            @php
                                $total = 0;
                                $shipping = 0;
                                $sum_for_jquery = 0;
                            @endphp
                            <div class="checkout__order">
                                <h4>Your Order</h4>
                                <strong style="color: green">{{ $setting->message??'' }}</strong>
                                <div class="checkout__order__products">Products <span>Total</span></div>
                                <ul>
                                    @if($cart != null)
                                        @foreach($cart as $item)
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
                                    <li>{{ ucfirst( Str::limit( $item['name'], 30) ) }} <span> {{ $cart_total }} </span></li>
                                            <span class="small">Qty: {{ $item['quantity'] }}</span>
                                            @php
                                                    $total += $cart_total ;

                                                    if (isset(auth()->user()->detail) && auth()->user()->detail->district_id == 47){
                                                            if ($setting->charge_by == 'quantity'){
                                                                $shipping += $item['quantity'] * $setting->shipping ;
                                                            }

                                                            if ($setting->charge_by == 'product'){
                                                                $shipping += $setting->shipping ;
                                                            }

                                                            if ($setting->charge_by == 'order'){
                                                                $shipping = $setting->shipping ;
                                                            }
                                                    }
                                                    else{
                                                        if ($setting->charge_by == 'quantity'){
                                                                $shipping += $item['quantity'] * $setting->shipping2 ;
                                                            }

                                                            if ($setting->charge_by == 'product'){
                                                                $shipping += $setting->shipping2 ;
                                                            }

                                                            if ($setting->charge_by == 'order'){
                                                                $shipping = $setting->shipping2 ;
                                                            }
                                                    }

                                                    /*else{
                                                        $shipping += $item['quantity'] * $setting->shipping2 ;
                                                    }*/

                                                $sum_for_jquery += $item['quantity'];

                                            @endphp

                                        @endforeach
                                    @endif


                                    <!-- Shipping Condition -->
                                    @php
                                        if ($total >= $setting->free_shipping){
                                               $shipping = 0;
                                           }

                                    $discount = session('discount');
                                    $coupon_type = session('coupon_type');
                                    $percent = session('percent');
                                    @endphp
                                    <!-- Shipping Condition -->
                                </ul>
                                <div class="checkout__order__subtotal">Subtotal <span> <span>{{ $total }}</span> </span></div>
                                @if($discount != null)
                                    <div class="checkout__order__total">Coupon Discount <span> <span id="js_discount">- {{ ($percent)? $percent.'%' : $discount }}</span> </span></div>
                                @endif
                                <div class="checkout__order__total">Shipping <span> <span id="js_shipping">{{ $shipping }}</span> </span></div>

                                <div class="checkout__order__total">Total <span> <span id="js_total">{{ ($discount != null)?$total+$shipping - $discount : $total+$shipping }}</span> </span></div>

                                <div class="checkout__input__checkbox">
                                    <label for="payment">
                                        Cash On Delivery
                                        <input type="checkbox" id="payment" class="chb" name="payment_type" value="cash" checked>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                {{--<div class="checkout__input__checkbox">
                                    <label for="paypal">
                                        bKash/Online Payment
                                        <input type="checkbox" id="paypal" class="chb" name="payment_type" value="gateway">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>--}}

                                @if($discount == null || $discount == 0)
                                <div class="checkout__input__checkbox">
                                    <!-- Button trigger modal -->
                                    Have any coupon?
                                    <a type="button" href="#" class="text-custom" data-toggle="modal" data-target="#exampleModal"><strong>Click Here</strong></a>
                                </div>
                                @endif



                                <button type="submit" class="site-btn">PLACE ORDER</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="{{ route('coupon_apply') }}" class="form-inline" method="get">
                        <div class="modal-content">
                            <div class="modal-header bg-custom text-white">
                                <h5 class="modal-title" id="exampleModalLabel">Apply Coupon</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @csrf
                                <p class="clear"><span class="f_title ">Coupon: </span></p>
                                <input type="text" name="coupon_code" class="form-control w-100" placeholder="Enter Coupon"  required>
                            </div>
                            <br>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn site-btn">Apply</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    @php
    /*varibales for js*/
        $count = count($cart);
        $sum = $sum_for_jquery;
        $shipping1 = $setting->shipping ;
        $shipping2 = $setting->shipping2 ;
        $charge = $setting->charge_by;
        $free = $setting->free_shipping;
        $discount = session('discount');
        if($discount == null){
            $discount = 0;
        }
    if($total >= $free){
        $shipping1 = 0 ;
        $shipping2 = 0 ;
    }
    @endphp
@endsection




@push('library-css')
@endpush



@push('custom-css')
    <style>
        .clear{
            margin-bottom: 0px !important;
        }
        .f_title{
            color: black !important;
            font-weight: bold;
        }

        .input_clear > input{
            border: unset;
            color: black;
        }


        .shipping-address-box {
            display: inline-block;
            position: relative;
            width: 100%;
            min-height: 240px;
            margin: 0;
            padding: 1.8rem 3.2rem 1rem 1.8rem;
            transition: .3s border-color;
            border: .1rem solid transparent;
            font-size: 1.3rem;
            line-height: 3rem;
            vertical-align: top;
            word-wrap: break-word;
        }

        .district {
            height: 46px;
            padding-top: 9px;
        }


        .checkout__input input{
            color: #585858; !important;
        }
    </style>
@endpush



@push('library-js')
@endpush



@push('custom-js')
    <script>
        $('#ship_address').hide();
        $(function () {
            $("#diff-acc").click(function () {
                var shipping = "{{$shipping}}";
                var total = "{{$total}}";
                var discount = "{{$discount}}";

                if ($(this).is(":checked")) {
                    $("#def_ship").removeClass("active");
                    $("#ship_address").show();
                    $('#district').attr('required',true);
                    $('#zip').attr('required',true);
                } else {
                    $("#ship_address").hide();
                    $("#def_ship").addClass("active");
                    $('#district').removeAttr('required');
                    $('#zip').removeAttr('required');
                    $("#js_shipping").html(shipping);
                    $("#js_total").html(parseFloat(total) + parseFloat(shipping) - parseFloat(discount));
                }
            });
        });


        $(".chb").change(function() {
            $(".chb").prop('checked', false);
            $(this).prop('checked', true);
        });




            $("#district").change(function() {
                var prd = "{{$count}}";
                var qnt = "{{$sum}}";
                var sp1 = "{{$shipping1}}";
                var sp2 = "{{$shipping2}}";
                var total = "{{$total}}";
                var charge = "{{$charge}}";
                var distr = $(this).val();
                var discount = "{{$discount}}";


                if (distr == 47) {

                    if(charge == 'quantity'){
                        var shipping = qnt * sp1;
                        $("#js_shipping").html(shipping);
                        $("#js_total").html(parseFloat(total) + parseFloat(shipping) - parseFloat(discount));
                    }

                    if (charge == 'product'){
                        var shipping = prd * sp1;
                        $("#js_shipping").html(shipping);
                        $("#js_total").html(parseFloat(total) + parseFloat(shipping) - parseFloat(discount));
                    }

                    if (charge == 'order'){
                        var shipping = sp1;
                        $("#js_shipping").html(shipping);
                        $("#js_total").html(parseFloat(total) + parseFloat(shipping) - parseFloat(discount));
                    }
                    else{

                    }
                }
                else {
                    if(charge == 'quantity'){
                        var shipping = qnt * sp2;
                        $("#js_shipping").html(shipping);
                        $("#js_total").html(parseFloat(total) + parseFloat(shipping) - parseFloat(discount));
                    }

                    if (charge == 'product'){
                        var shipping = prd * sp2;
                        $("#js_shipping").html(shipping);
                        $("#js_total").html(parseFloat(total) + parseFloat(shipping) - parseFloat(discount));
                    }

                    if (charge == 'order'){
                        var shipping = sp2;
                        $("#js_shipping").html(shipping);
                        $("#js_total").html(parseFloat(total) + parseFloat(shipping) - parseFloat(discount));
                    }
                    else{

                    }
                }



            });

    </script>

@endpush
