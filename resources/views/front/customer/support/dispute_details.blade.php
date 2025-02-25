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
                                    <h5 class="card-title"> {{ $dispute->order->order_number }} </h5>
                                    <h6 class="card-subtitle mb-2 text-muted">{{ ucfirst($dispute->subject) }}</h6>
                                    <p class="card-text">{{ ucfirst($dispute->message) }}</p>
                                    <p><strong>Attachment:</strong></p>
                                    <img id="myImg" class="img-fluid" style="max-width: 30%" src="{{ asset($dispute->image != null? $dispute->image : 'uploads/default.jpg') }}">
                                </div>
                                <!-- The Modal -->
                                <div id="myModal" class="modal">
                                    <span class="close">&times;</span>
                                    <img class="modal-content" id="img01">
                                    <div id="caption"></div>
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

                            @if ($dispute->deleted_at == null)
                               {{-- <form action="{{ route('dispute.reply', $dispute->id) }}" method="post">
                                @csrf--}}
                                <input name="dispute_id" value="{{ $dispute->id }}" type="hidden">
                                <input name="user_id" value="{{ auth()->user()->id }}" type="hidden">
                                <div class="checkout__input">
                                    <textarea name="reply" class="form-control @error('reply') is-invalid @enderror" id="reply" cols="30" rows="3" placeholder="Send Message">{{old('reply')}}</textarea>
                                </div>
                                <div class="text-right">
                                    <button onclick="store()" type="button" class="btn-lg site-btn"><i class="fa fa-lg fa-fw fa-paper-plane"></i></button>
                                </div>
                            {{--</form>--}}
                            @else
                                <h5 class="text-success text-center">Closed</h5>
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

    <style>

        #myImg {
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        #myImg:hover {opacity: 0.7;}

        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
        }

        /* Modal Content (image) */
        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }

        /* Caption of Modal Image */
        #caption {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
            text-align: center;
            color: #ccc;
            padding: 10px 0;
            height: 150px;
        }

        /* Add Animation */
        .modal-content, #caption {
            -webkit-animation-name: zoom;
            -webkit-animation-duration: 0.6s;
            animation-name: zoom;
            animation-duration: 0.6s;
        }

        @-webkit-keyframes zoom {
            from {-webkit-transform:scale(0)}
            to {-webkit-transform:scale(1)}
        }

        @keyframes zoom {
            from {transform:scale(0)}
            to {transform:scale(1)}
        }

        /* The Close Button */
        .close {
            position: absolute;
            top: 100px;
            right: 85px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        /* 100% Image Width on Smaller Screens */
        @media only screen and (max-width: 700px){
            .modal-content {
                width: 100%;
            }
        }
    </style>
@endpush



@push('library-js')

@endpush


@push('custom-js')
    <script>
        var baseUrl = '{{ url('dispute/reply/'. $dispute->id) }}';
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
            var dispute_id = $('input[name="dispute_id"]').val()
            return {user_id: user_id, dispute_id: dispute_id, reply: reply}
        }

        function store() {
            $.ajax({
                url : '{{ url('dispute/response') }}',
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

    <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the image and insert it inside the modal - use its "alt" text as a caption
        var img = document.getElementById("myImg");
        var modalImg = document.getElementById("img01");
        var captionText = document.getElementById("caption");
        img.onclick = function(){
            modal.style.display = "block";
            modalImg.src = this.src;
            captionText.innerHTML = this.alt;
        }

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }
    </script>
@endpush
