@extends('layouts.backend.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="authorized">
                    <img src="{{ asset('backend/images/autho.png') }}"><br>
                    <a href="{!! URL::previous() !!}" class="btn btn-info btn-lg">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-css')
    <style>

        .authorized {
            background: #ffffff;
            width: 100%;
            height: 510px;
            text-align: center;

        }
        .authorized img {
            margin-top: 8%;
        }

    </style>
@endpush
