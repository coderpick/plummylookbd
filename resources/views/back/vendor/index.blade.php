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
                {{--@if ($title == 'Vendors')
                    <div class="col-md-12 row">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Send Newsletter</button>
                    </div>
                @endif--}}

                <br>
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="example" role="grid">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Shop Name</th>
                                {{--@if(! Request::is('secure/vendors/pending'))
                                    <th>Commission</th>
                                @endif--}}
                                <th>Email</th>
                                <th>Phone</th>
                                <th>NID</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ ucfirst($user->name) }}</td>
                                    <td>{{ ucfirst($user->shop->name) }}</td>
                                    {{--@if(! Request::is('secure/vendors/pending'))
                                        <td>
                                            {{ $user->shop->commission }} %
                                        </td>
                                    @endif--}}

                                    <td>{{ $user->email }}</td>
                                    <td>{{ ucfirst($user->phone) }}</td>
                                    <td>{{ $user->nid }}</td>
                                    <td>
                                        @if($user->deleted_at == null)
                                            Active
                                        @else
                                            Inactive
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->deleted_at == null)
                                            <a href="{{ route('vendor.details',$user->slug) }}" class="btn btn-sm btn-info">Details</a>
                                            <form action="{{ route('vendor.destroy',$user->slug) }}" method="post" style="display: inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Are you sure to Block?')">Block</button>
                                            </form>

                                        @elseif($user->deleted_at == null || $user->status == 'active')
                                            {{--<a href="{{ route('vendor.details',$user->slug) }}" class="btn btn-sm btn-info">Details</a>--}}
                                            <form action="{{ route('vendor.restore',$user->id) }}" method="post" style="display: inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Are you sure to Unblock?')">Unblock</button>
                                            </form>

                                        @else
                                            <form action="{{ route('vendor.accept',$user->id) }}" method="post" style="display: inline">
                                                @csrf
                                                {{--<input type="number" style="width: 50px; border: 2px solid #ced4da;" name="commission" value="{{ $user->shop->commission }}"> %--}}
                                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Are you sure?')"><i class="fa fa-check"></i>Resotre</button>
                                            </form>

                                            <form action="{{ route('vendor.delete',$user->id) }}" method="post" style="display: inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-times"></i>Delete</button>
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


    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Newsletter to Customers</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form class="row" action="{{ route('newsletter') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="type" value="vendor">
                        <div class="form-group col-md-12">
                            <label class="control-label">Title <span class="text-danger">*</span></label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" placeholder="Enter title">
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                            <label class="control-label">Newsletter Details <span class="text-danger">*</span></label>
                            <textarea name="details" class="form-control" rows="8" id="details"></textarea>
                            @error('details')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>




                        <div class="form-group col-md-12 text-center">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Send</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
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
            $('#example').DataTable( {
                dom: 'Bfrtip',
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
