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
        <div class="col-md-10">
            <div class="tile">
                <div class="col-md-12 row">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"> {{ $dispute->order->order_number }} </h4>
                            <h6 class="card-subtitle mb-2 text-muted">Submitted by {{ ucfirst($dispute->user->name) }}</h6>
                            <br>
                            <h5 class="card-subtitle mb-2">{{ ucfirst($dispute->subject) }}</h5>
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
                </div>
                <br>
                <div class="tile">
                        <h3 class="tile-title">Response</h3>
                        <div class="messanger">
                            <div class="messages" id="scroll">
                                {{--@foreach ($replies as $rep)
                                    <div class="message @if($rep->user->type != 'user') me @endif"><img style="max-width: 48px; max-height: 48px" src="{{ asset($rep->user->image != null? $rep->user->image : 'uploads/user_default.jpg') }}">
                                        <p class="info">{{ $rep->reply }}</p>
                                    </div>
                                @endforeach--}}
                            </div>
                            @if ($dispute->deleted_at == null)
                            {{--<form action="{{ route('dispute.response') }}" method="post">
                                @csrf--}}
                                    <input name="dispute_id" value="{{ $dispute->id }}" type="hidden">
                                    <input name="user_id" value="{{ auth()->user()->id }}" type="hidden">
                                <div class="sender" id="sender">
                                    <input name="reply" type="text" placeholder="Send Message">
                                    <button onclick="store()" class="btn btn-primary bs" type="submit"><i class="fa fa-lg fa-fw fa-paper-plane"></i></button>
                                </div>
                            {{--</form>--}}
                            @endif
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection




@push('library-css')
    {{--<meta http-equiv="refresh" content="50">--}}
@endpush



@push('custom-css')
    <style>
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
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
@endpush



@push('custom-js')
    <script>
        var baseUrl = '{{ url('dispute/reply/'. $dispute->id) }}';
        var sender = $('#sender');

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
                            html += '<div class="message me">'
                            html += '<img style="max-width: 48px; max-height: 48px" src="{{ URL::asset('')}}'+ img +'">'
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

                    $('.messages').html(html)
                }
            });
        }
        getRecords();

        function reset() {
            sender.find('input').each(function () {
                $(this).val(null)
            });
        }

        function getInputs() {
            var reply = $('input[name="reply"]').val()
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
