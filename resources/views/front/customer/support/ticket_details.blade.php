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
                        <div class="col-lg-1"></div>
                        <div class="checkout__form col-lg-10">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-subtitle mb-2 text-muted">{{ $ticket->ticket_number }}</h6>
                                    <h5 class="card-subtitle mb-2 text-muted">{{ ucfirst($ticket->subject) }}</h5>
                                    <p class="card-text">{{ ucfirst($ticket->message) }}</p>
                                </div>
                            </div>
                            <br>

                            <div class="msg_box" id="scroll">
                            {{--@foreach ($replies as $rep)
                                <div class="message @if($rep->user->type != 'user') darker @endif">
                                    @if($rep->user->type == 'user')
                                    <img style="max-width: 48px; max-height: 48px" src="{{ asset($rep->user->image != null? $rep->user->image : 'uploads/user_default.jpg') }}">
                                    @endif
                                        <p class="info">{{ ucfirst($rep->reply) }}</p>
                                        <span class="@if($rep->user->type != 'user') time-left @else time-right @endif">{{ $rep->created_at->format('h:i a') }}</span>
                                </div>
                            @endforeach--}}
                            </div>
                            <br>

                            @if ($ticket->deleted_at == null)

                                <input name="ticket_id" value="{{ $ticket->id }}" type="hidden">
                                <input name="user_id" value="{{ auth()->user()->id }}" type="hidden">
                                <div class="checkout__input">
                                    <textarea name="reply" class="form-control @error('reply') is-invalid @enderror" id="reply" cols="30" rows="3" placeholder="Send Message">{{old('reply')}}</textarea>
                                </div>

                                <div class="text-right">
                                    <button onclick="store()" type="submit" class="btn-lg site-btn"><i class="fa fa-lg fa-fw fa-paper-plane"></i></button>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection




@push('library-css')
    {{--<meta http-equiv="refresh" content="50">--}}
@endpush

@push('custom-css')
    <style>
        .btn-lg{
            border-radius: unset;
        }


        .message {
            border: 2px solid #dedede;
            border-radius: 5px;
            padding: 10px;
            margin: 10px 0;
        }

        .darker {
            border-color: #ccc;
            background-color: #f5f5f5;
        }

        .message::after {
            content: "";
            clear: both;
            display: table;
        }

        .message img {
            float: left;
            max-width: 60px;
            width: 100%;
            margin-right: 20px;
            border-radius: 50%;
        }

        .message img.right {
            float: right;
            margin-left: 20px;
            margin-right:0;
        }

        .time-right {
            float: right;
            color: #aaa;
        }

        .time-left {
            float: left;
            color: #999;
        }

        .msg_box{
            overflow: scroll;
            max-height: 500px;
        }


        #scroll {
            overflow: auto;
            display: flex;
            flex-direction: column-reverse;
        }
    </style>
@endpush



@push('library-js')

@endpush



@push('custom-js')
    <script>
        var baseUrl = '{{ url('ticket/reply/'. $ticket->id) }}';
        var sender = $('.checkout__input');

        $.ajaxSetup({
            headers:{ 'X-CSRF-Token': '{{ csrf_token() }}'}
        });

        function getRecords() {
            $.ajax({
                url : baseUrl,
                method : 'GET',

                success : function (data) {
                    console.log('Success - ' + JSON.stringify(data));
                    var html = '';
                    data.forEach(function (row) {

                        if (row.user.image != null) {
                            var img = row.user.image;
                        }
                        else{
                            var img = 'uploads/user_default.jpg';
                        }

                        if (row.user.type != 'user'){
                            html += '<div class="message darker">'
                            html += '<p class="info">' + row.reply + '</p class="info">'
                            html += '</div>'
                        }
                        else{
                            html += '<div class="message">'
                            html += '<img style="max-width: 48px; max-height: 48px" src="{{ URL::asset('')}}'+ img +'">'
                            html += '<p class="info">' + row.reply + '</p>'
                            html += '</div>'
                        }
                    })

                    $('.msg_box').html(html)
                }
            });
        }
        getRecords();

        function reset() {
            sender.find('textarea').each(function () {
                $(this).val(null)
            });
        }

        function getInputs() {
            var reply = $('textarea[name="reply"]').val()
            var user_id = $('input[name="user_id"]').val()
            var ticket_id = $('input[name="ticket_id"]').val()
            return {user_id: user_id, ticket_id: ticket_id, reply: reply}
        }

        function store() {
            $.ajax({
                url : '{{ url('ticket/response') }}',
                method : 'POST',
                data : getInputs(),
                dataType: 'JSON',
                success: function () {
                    console.log('Success');
                    reset();
                    getRecords();
                }
            })
        }
    </script>
@endpush
