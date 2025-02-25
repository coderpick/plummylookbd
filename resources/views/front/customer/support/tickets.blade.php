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

    <section class="checkout spad">
        <div class="container">

            <div class="row">

                <div class="col-lg-3 col-md-5">
                    @include('front.customer._sideMenu')
                </div>


                <div class="col-lg-9 col-md-7">

                    <div class="row">
                        <div class="checkout__form col-lg-12">
                            <h3>{{ ucfirst($title) }} <button type="button" class="btn-lg site-btn pull-right" data-toggle="modal" data-target="#myModal">Open Support Ticket</button></h3>
                            @if ($tickets->count()>0)
                                <br>
                            <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Ticket ID</th>
                                    <th>Subject</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($tickets as $ticket)
                                    <tr>
                                        <td>{{ $ticket->ticket_number }}</td>
                                        <td>{{ ucfirst($ticket->subject) }}</td>
                                        <td>
                                            @if ($ticket->deleted_at == null)
                                                Open
                                                @else
                                                Closed
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('my_tickets.show',base64_encode($ticket->id)) }}" class="btn btn-sm btn-info">Details</a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                            {{ $tickets->render() }}
                            @else
                                <br>
                                <br>
                                <h5 class="text-center">You don't have any ticket</h5>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Open Ticket</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                        <form action="{{ route('my_tickets.store') }}" method="post">
                            @csrf
                            <div class="modal-body">

                                    <div class="form-group">
                                        <label for="subject">Subject <span class="text-danger">*</span></label>
                                        <input name="subject" type="text" class="form-control @error('subject') is-invalid @enderror" id="subject">
                                        @error('subject')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="pwd">Message <span class="text-danger">*</span></label>
                                        <textarea name="message" class="form-control @error('message') is-invalid @enderror" id="" cols="10" rows="5"></textarea>
                                        @error('message')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn-lg site-btn pull-right">Submit</button>
                            </div>
                        </form>
                </div>

            </div>
        </div>
    </section>
@endsection




@push('library-css')
    <link rel="stylesheet" href="{{asset('backend/dropify/css/dropify.min.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('custom-css')
    <style>
        .btn-lg{
            border-radius: unset;
        }
    </style>
@endpush



@push('library-js')
    <script src="{{asset('backend/dropify/js/dropify.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
@endpush



@push('custom-js')
    <script>
        $(document).ready(function(){
            // Basic
            $('.dropify').dropify();
            $('.district').select2();
        });
    </script>
@endpush
