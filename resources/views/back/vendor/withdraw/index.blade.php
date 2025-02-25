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
            <li class="breadcrumb-item active"><a href="{{ route('withdraw.index') }}">{{ $title }}</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                @if (auth()->user()->type == 'vendor')
                <div class="col-md-12 row">
                    <a href="{{ route('withdraw.create') }}" class="btn btn-primary">Withdraw Now</a>
                </div>
                @endif
                <br>
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                            <tr>
                                <th style="display: none;">Id</th>
                                <th>Withdraw Date</th>
                                @if (auth()->user()->type != 'vendor')
                                <th>Shop</th>
                                @endif
                                <th>Bank</th>
                                <th>Acc. Holder Name</th>
                                <th>Account No</th>
                                <th>Routing No</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Updated By</th>
                                @if (auth()->user()->type != 'vendor')
                                    <th>Actions</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($withdraws as $withdraw)
                            <tr>
                                <td style="display: none;">{{ $withdraw->id }}</td>
                                <td>{{ $withdraw->created_at->format('d-M-Y') }}</td>
                                @if (auth()->user()->type != 'vendor')
                                <td>
                                    <a href="{{ route('withdraw.single', $withdraw->shop->slug) }}">{{ ucfirst($withdraw->shop->name) }}</a>
                                </td>
                                @endif
                                <td>{{ ucfirst($withdraw->bank) }}</td>
                                <td>{{ $withdraw->acc_name }}</td>
                                <td>{{ $withdraw->acc_no }}</td>
                                <td>{{ $withdraw->routing_no }}</td>
                                <td>{{ $withdraw->amount }}</td>
                                <td>
                                    @if($withdraw->deleted_at == !null)
                                        Rejected
                                    @else
                                        {{ ucfirst($withdraw->status) }}
                                    @endif
                                </td>
                                <td>{{ ucfirst(($withdraw->user != null)?$withdraw->user->name: 'N/A') }}</td>

                                @if (auth()->user()->type != 'vendor')
                                    <td>
                                        @if($withdraw->deleted_at == null)
                                        <div class="dropdown d-inline">
                                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Status
                                            <span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            @if($withdraw->status != 'Pending')
                                                <li>
                                                    <form action="{{ route('withdraw.status',[$withdraw->id,'Pending']) }}" method="post" style="display: inline">
                                                        @csrf
                                                        <button type="submit" class="btn stsbtn" onclick="return confirm('Are you confirm to change?')">Pending</button>
                                                    </form>
                                                </li>
                                            @endif

                                            @if($withdraw->status != 'Processing')
                                                <li>
                                                    <form action="{{ route('withdraw.status',[$withdraw->id,'Processing']) }}" method="post" style="display: inline">
                                                        @csrf
                                                        <button type="submit" class="btn stsbtn" onclick="return confirm('Are you confirm to change?')">Processing</button>
                                                    </form>
                                                </li>
                                            @endif
                                            @if($withdraw->status != 'Completed')
                                                <li>
                                                    <form action="{{ route('withdraw.status',[$withdraw->id,'Completed']) }}" method="post" style="display: inline">
                                                        @csrf
                                                        <button type="submit" class="btn stsbtn" onclick="return confirm('Are you confirm to change?')">Completed</button>
                                                    </form>
                                                </li>
                                            @endif

                                        </ul>
                                    </div>
                                        @if($withdraw->status == 'Pending')
                                                <form action="{{ route('withdraw.destroy',$withdraw->id) }}" method="post" style="display: inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to reject?')">Reject</button>
                                                </form>
                                        @endif
                                        @else
                                            <form action="{{ route('withdraw.restore',$withdraw->id) }}" method="post" style="display: inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Do you want this back?')">Reopen</button>
                                            </form>
                                        @endif
                                    </td>
                                @endif

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
    <style>
        .stsbtn{
            width:-webkit-fill-available;
            line-height: 1;
        }
    </style>
@endpush



@push('library-js')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.colVis.min.js"></script>
@endpush



@push('custom-js')
    <script type="text/javascript">

        $(document).ready(function() {
            $('#sampleTable').DataTable( {
                dom: 'Bfrtip',
                order: [ [0, 'desc'] ],
                buttons: [
                    'csv', 'excel', 'pdf',

                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible'
                        }
                    }
                ]
            } );
        } );

    </script>
@endpush
