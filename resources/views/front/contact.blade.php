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

    <!-- Product Section Begin -->
    <section class="product spad">
        <div id="address-section" class="section-bg-white  pt-100  pb-100">
            <div class="container">
                <!-- Start Row -->
                <div class="row">
                    <!--  Address Col -->


                </div>
                <!-- End Row -->
            </div>
        </div>
        <!-- Address area -->




        <!-- Contact Area Section -->
        <section id="contact-area" class="section-bg-white  pt-100  pb-100">
            <div class="container">
                <!-- Google Map Area   -->
                <div id="google-map-section">
                    <!-- map -->
                    @if(isset($contact) && $contact->map != null)
                    {!! $contact->map !!}
                    @endif
                    <style>
                        iframe{
                            width: 100%;
                            height:400px; !important;
                        }
                    </style>
                    <!-- end map -->
                </div>
                <!-- Google Map Area   -->
                <br>
                <br>
                    <h4 class="text-center">Leave a Message</h4>
                <br>
                <br>
                <div class="checkout__form">
                    <form action="{{ route('contact.us') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-md-6">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="checkout__input">
                                            <input type="text" class="form-control" id="form-name" name="name" placeholder="Name here" required="required" >
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="checkout__input">
                                            <input type="text" class="form-control" id="form-subject" name="subject" placeholder="Subject here"  required="required">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="checkout__input">
                                            <input type="email" class="form-control" id="form-email" name="email" placeholder="Email here"  required="required">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="checkout__input">
                                            <textarea class="form-control" name="message" placeholder="Message"  required="required" id="" cols=" " rows="6"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn-lg site-btn">SUBMIT</button>
                                </div>
                                <br>
                                <br>

                            </div>

                        </div>
                    </form>
                </div>
            </div>
        <!-- Contact Area Section -->
    </section>
    </section>
@endsection




@push('library-css')

@endpush



@push('custom-css')
            <style>
                .btn-lg{
                    border-radius: unset;
                }
            </style>
@endpush



@push('library-js')

@endpush



@push('custom-js')

@endpush
