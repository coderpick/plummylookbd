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
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6 text-right">
                            @can('users.create')
                                <a href="{{ route('user.create') }}" class="btn btn-primary"><i class="fa fa-plus-square-o"></i> Add New {{ $title }}</a>
                            @endcan
                        </div>
                    </div>
                </div>
                <br>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Joined At</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $key=>$user)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        <div class="media">
                                            <img src="{{ $user->image != null ? asset($user->image) : config('app.placeholder') . '100.png' }}"
                                                 width="48" class="rounded-circle mt-2 mr-3" alt="User Avatar">
                                            <div class="media-body">
                                                <h6>{{ $user->name }}</h6>
                                                @foreach ($user->roles as $role )
                                                    @if($role->id !=2)
                                                        <span class="badge bg-info">{{ $role->name ?? '' }}</span>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ ucfirst($user->phone) }}</td>
                                    <td> {{ $user->created_at->diffForHumans() }}</td>
                                    <td>
                                        @if($user->status ==true)
                                            <span class="badge btn-success">Active</span>
                                        @endif
                                        @if($user->status ==false)
                                            <span class="badge btn-danger">Active</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->deleted_at == null)
                                            @can('users.edit')
                                                <a href="{{ route('user.edit',$user->id) }}" class="btn btn-sm btn-success">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endcan
                                            @can('users.trash')
                                                <form action="{{ route('user.trash',$user->id) }}" method="post" style="display: inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Are you sure to trash?')" {{ $user->id == auth()->user()->id ?'disabled':' ' }}><i class="fa fa-trash"></i></button>
                                                </form>
                                            @endcan
                                        @else
                                            @can('users.restore')
                                                <form action="{{ route('user.restore',$user->id) }}" method="post" style="display: inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-primary" onclick="return confirm('Do you want this back?')"><i class="fa fa-recycle"></i></button>
                                                </form>
                                            @endcan
                                            @can('users.destroy')
                                                <button onclick="deleteUser({{$user->id}})" type="submit" class="btn btn-sm btn-danger" >
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                <form id="delete-form-{{ $user->id }}" action="{{ route('user.destroy',$user->id) }}" method="post" style="display: inline">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @endcan
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

@endpush



@push('custom-css')

@endpush



@push('library-js')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/sweetalert.min.js') }}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
@endpush



@push('custom-js')
    <script type="text/javascript">

        // sweet alert active
        function deleteUser(id){
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary user!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function(isConfirm) {
                if (isConfirm) {
                    event.preventDefault();
                    document.getElementById('delete-form-' + id).submit();
                    swal("Deleted!", "Your imaginary user has been deleted.", "success");
                } else {
                    swal("Cancelled", "Your imaginary user is safe :)", "error");
                }
            });
        }

    </script>
@endpush
