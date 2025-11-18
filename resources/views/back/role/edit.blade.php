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
                            @can('roles.index')
                                <a href="{{ route('roles.index') }}" class="btn btn-danger"><i class="fa fa-reply"></i> Back to {{ $title }}</a>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('roles.update',$role->id) }}">
                        @csrf
                        @isset($role)
                            @method('PUT')
                        @endisset
                        <div class="form-group">
                            <label for="role_name">Role Name</label>
                            <input type="text" class="form-control @error('role_name') is-invalid @enderror"
                                   id="role_name" name="role_name" value="{{ $role->name??old('role_name') }}"
                                   placeholder="Enter role name" />
                            @error('role_name')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="text-center">
                            <h5 class="text-white pl-1 pt-1 pb-1 bg-secondary rounded">Manage Permissions For <span class="text-warning">Role</span></h5>
                        </div>
                        <div class="form-group">
                            <div class="animated-checkbox">
                                <label>
                                    <input type="checkbox" id="selectAll" class="custom-control-input">
                                    <span class="label-text font-weight-bold">Select All</span>
                                </label>
                            </div>
                            @error('permissions')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <hr>
                        @forelse($modules->chunk(3) as $key=>$chunks)
                            <div class="form-row">
                                @foreach ($chunks as $key => $module)
                                    <div class="col">
                                        <h6 class="badge badge-primary" style="font-size: 14px">{{ $module->name }}</h6>
                                        @foreach ($module->permissions as $key => $permission)
                                            <div class="mb-3 ml-2">
                                                <div class="animated-checkbox">
                                                    <label>
                                                        <input
                                                            type="checkbox" class="custom-control-input"
                                                            id="permission-{{ $permission->id }}"
                                                            @if($role)
                                                            @foreach($role->permissions as $rolePermission)
                                                            {{ $rolePermission->id == $permission->id?'checked':'' }}
                                                            @endforeach
                                                            @endif
                                                            value="{{ $permission->id }}"
                                                            name="permissions[]">
                                                        <span class="label-text">{{ $permission->name }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        @empty
                            <div class="row">
                                <div class="col text-center">
                                    <strong>No module found.</strong>
                                </div>
                            </div>
                        @endforelse
                        <hr>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">
                               <i class="fa fa-arrow-circle-o-up"></i> Update
                            </button>
                        </div>
                    </form>
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
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
@endpush



@push('custom-js')
    <script type="text/javascript">
        // Listen for click on toggle checkbox
        $('#selectAll').on('click', function() {
            if (this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;
                });
            }
        });

    </script>
@endpush
