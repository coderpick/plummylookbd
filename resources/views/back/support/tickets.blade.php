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
        <div class="col-md-12">
            <div class="tile">
                <br>
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="example" role="grid">
                            <thead>
                            <tr>
                                <th style="display: none">ID</th>
                                <th>Ticket ID</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>Updated By</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tickets as $ticket)
                                <tr>
                                    <td style="display: none">{{ $ticket->id }}</td>
                                    <td>{{ ucfirst($ticket->ticket_number) }}</td>
                                    <td>{{ ucfirst($ticket->subject) }}</td>
                                    <td>
                                        @if($ticket->deleted_at == null)
                                            Open
                                        @else
                                            Closed
                                        @endif
                                    </td>
                                    <td>
                                        @if($ticket->updated_by != null)
                                        {{ ucfirst($ticket->admin->name) }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                            <a href="{{ route('ticket.show',base64_encode($ticket->id)) }}" class="btn btn-sm btn-info">Details</a>
                                        @if($ticket->deleted_at == null)
                                            <form action="{{ route('ticket.destroy',$ticket->id) }}" method="post" style="display: inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Are you sure to close?')">Close</button>
                                            </form>
                                        @else
                                            <form action="{{ route('ticket.restore',$ticket->id) }}" method="post" style="display: inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Do you want this open again?')">Reopen</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection




@push('library-css')
    <!-- dataTable css-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
@endpush



@push('custom-css')

@endpush



@push('library-js')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>

@endpush



@push('custom-js')
    <script type="text/javascript">

        $(document).ready(function() {
            $('#example').DataTable( {
             order: [ [0, 'desc'] ]
            } );
        } );

    </script>
@endpush
