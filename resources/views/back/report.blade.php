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
            <li class="breadcrumb-item active"><a href="{{ route('product.index') }}">{{ $title }}</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <form action="{{ route('report.store') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="row mb-3 justify-content-center">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-bold" for="from_date"> From Date</label>
                                    <input required type="text" name="from_date" class="datepicker form-control @error('from_date') is-invalid @enderror">
                                    @error('from_date')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-bold" for="to_date"> To Date</label>
                                    <input required type="text" name="to_date" class="datepicker form-control @error('to_date') is-invalid @enderror">
                                    @error('to_date')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for=""> &nbsp; </label>
                                <div class="form-group">
                                    <div class="form-group align-self-end">
                                        <button class="btn btn-primary" type="submit">Get Report</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection




@push('library-css')
    <link href="{{ asset('backend/datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
@endpush



@push('custom-css')

@endpush



@push('library-js')
    <script src="{{ asset('backend/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
@endpush



@push('custom-js')
    <script type="text/javascript">
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        })
    </script>
@endpush
