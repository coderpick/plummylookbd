@extends('layouts.backend.master')
@section('content')
    <!--title-->
    <div class="app-title">
        <div>
            <h1><i class="fa fa-th-list"></i> {{ $title }} </h1>
            <p>Display Data Effectively</p>
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
                <div class="card-body">
                    <form method="POST" action="{{route('privacy.insert')}}">
                        @csrf
                        <div class="card mt-3 tab-card">
                            <div class="card-header tab-card-header">
                                <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="one-tab" data-toggle="tab" href="#one" role="tab" aria-controls="One" aria-selected="true">FAQ</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="two-tab" data-toggle="tab" href="#two" role="tab" aria-controls="Two" aria-selected="false">Privacy Policy</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="three-tab" data-toggle="tab" href="#three" role="tab" aria-controls="Three" aria-selected="false">Terms and Conditions</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="four-tab" data-toggle="tab" href="#four" role="tab" aria-controls="Four" aria-selected="false">Cookies Policy</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active p-3" id="one" role="tabpanel" aria-labelledby="one-tab">
                                    <h5 class="card-title">FAQ</h5>
                                    <textarea id="faq" class="@error('faq') is-invalid @enderror" name="faq">@if(isset($privacies->faq)){{$privacies->faq}}@endif</textarea>
                                    @error('faq')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="tab-pane fade p-3" id="two" role="tabpanel" aria-labelledby="two-tab">
                                    <h5 class="card-title">Privacy Policy</h5>
                                    <textarea id="privacy" class="@error('privacy') is-invalid @enderror" name="privacy">@if(isset($privacies->privacy)){{$privacies->privacy}}@endif</textarea>

                                    @error('privacy')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="tab-pane fade p-3" id="three" role="tabpanel" aria-labelledby="three-tab">
                                    <h5 class="card-title">Terms and Conditions</h5>
                                    <textarea id="terms" class="@error('terms') is-invalid @enderror" name="terms">@if(isset($privacies->terms)){{$privacies->terms}}@endif</textarea>

                                    @error('terms')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="tab-pane fade p-3" id="four" role="tabpanel" aria-labelledby="four-tab">
                                    <h5 class="card-title">Cookies Policy</h5>
                                    <textarea id="cookies" class="@error('cookies') is-invalid @enderror" name="cookie">@if(isset($privacies->cookie)){{$privacies->cookie}}@endif</textarea>

                                    @error('cookies')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">

                            <div class="col-md-6">
                                <br>
                                    @if (isset($privacies))
                                    <button type="submit" class="btn btn-primary" id="insert_contact">
                                        {{ __('Update') }}
                                    </button>
                                    @else
                                    <button type="submit" class="btn btn-primary" id="insert_contact">
                                        {{ __('Insert') }}
                                    </button>
                                    @endif


                            </div>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>

@endsection


@push('library-css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.css" rel="stylesheet">
@endpush



@push('custom-css')
    <style>
        body {
            background-color: #f7f8f9;
        }

        .card {
            background-color: #ffffff;
            border: 1px solid rgba(0, 34, 51, 0.1);
            box-shadow: 2px 4px 10px 0 rgba(0, 34, 51, 0.05), 2px 4px 10px 0 rgba(0, 34, 51, 0.05);
            border-radius: 0.15rem;
        }

        /* Tabs Card */

        .tab-card {
            border:1px solid #eee;
        }

        .tab-card-header {
            background:none;
        }
        /* Default mode */
        .tab-card-header > .nav-tabs {
            border: none;
            margin: 0px;
        }
        .tab-card-header > .nav-tabs > li {
            margin-right: 2px;
        }
        .tab-card-header > .nav-tabs > li > a {
            border: 0;
            border-bottom:2px solid transparent;
            margin-right: 0;
            color: #007d71;
            padding: 2px 15px;
        }

        .tab-card-header > .nav-tabs > li > a.show {
            border-bottom:2px solid #007d71;
            color: #007d71;
        }
        .tab-card-header > .nav-tabs > li > a:hover {
            color: #007d71;
        }

        .tab-card-header > .tab-content {
            padding-bottom: 0;
        }
    </style>
@endpush



@push('library-js')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.js"></script>
@endpush



@push('custom-js')
    <script>
        $(document).ready(function() {
            $('#cookies').summernote();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#faq').summernote();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#privacy').summernote();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#terms').summernote();
        });
    </script>
@endpush
