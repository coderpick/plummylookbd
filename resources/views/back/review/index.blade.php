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
                <br>
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                            <tr>
                                <th style="display: none;">Id</th>
                                <th>Product</th>
                                <th>Rating</th>
                                <th>Review</th>
                                <th>User</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reviews as $review)
                            <tr>
                                <td style="display: none;">{{ $review->id }}</td>
                                <td><a href="{{ route('review.product', $review->product->slug) }}">{{ ucfirst($review->product->name) }}</a></td>
                                <td>{{ $review->rating }}</td>
                                <td width="30%"><p style="max-height: 150px" class="overflow-auto">{{ ucfirst($review->review) }}</p></td>
                                <td>
                                    @if(isset($review->user))
                                        <a href="{{ route('review.user', $review->user->slug) }}">{{ ucfirst($review->user->name) }}</a>
                                    @else
                                        {{ $review->name }} (Static)
                                    @endif
                                </td>
                                <td>{{ $review->created_at->format('d-M-Y') }}</td>
                                <td>
                                    @if($review->deleted_at != null)
                                    <form action="{{ route('review.approve',$review->id) }}" method="post" style="display: inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Are you sure to Approve?')"><i class="fa fa-check"></i>Approve</button>
                                    </form>
                                    @endif
                                    <form action="{{ route('review.delete',$review->id) }}" method="post" style="display: inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('This cannot be restored, Are you sure to Delete?')"><i class="fa fa-times"></i>Delete</button>
                                    </form>
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
