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
                    <div class="card col-md-12">
                        <div class="card-body">
                            <h4 class="card-title"> {{ $ticket->ticket_number }} </h4>
                            <h6 class="card-subtitle mb-2 text-muted">Submitted by {{ ucfirst($ticket->user->name) }}</h6>
                            <br>
                            <h5 class="card-subtitle mb-2">{{ ucfirst($ticket->subject) }}</h5>
                            <p class="card-text">{{ ucfirst($ticket->message) }}</p>
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
                            @if ($ticket->deleted_at == null)
                            {{--<form action="{{ route('ticket.response') }}" method="post">
                                @csrf--}}
                                    <input name="ticket_id" value="{{ $ticket->id }}" type="hidden">
                                    <input name="user_id" value="{{ auth()->user()->id }}" type="hidden">
                                <div class="sender" id="sender">
                                    <input name="reply" type="text" placeholder="Send Message">
                                    <button class="btn btn-primary" onclick="store()" type="submit"><i class="fa fa-lg fa-fw fa-paper-plane"></i></button>
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
@endpush



@push('library-js')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
@endpush



@push('custom-js')
    <script>
        var baseUrl = '{{ url('ticket/reply/'. $ticket->id) }}';
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
