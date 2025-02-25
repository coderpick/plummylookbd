@extends('layouts.backend.master')

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-th-list"></i> Edit {{ $title }}</h1>
            <p>Edit {{ $title }} Easily</p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="#">Edit {{ $title }}</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="tile">
                <h3 class="tile-title">{{ $title }} Form</h3>
                <div class="tile-body">
                    <form class="row" action="{{ route('static-review.update',$review->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="form-group col-md-8">
                            <label class="control-label">Name</label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ $review->name }}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="rating" class="control-label">Rating</label>
                            <input class="form-control @error('rating') is-invalid @enderror" type="number" name="rating" id="rating" value="{{ $review->rating }}">
                            @error('rating')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label">Review</label>
                            <textarea name="review" class="form-control @error('review') is-invalid @enderror" id="review" rows="5" required>{{ $review->review }}</textarea>
                            @error('review')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                            <div class="text-right mt-2">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>
                            </div>
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

@endpush



@push('custom-js')
    <script>
        $("#rating").keyup(function() {
            let rating = $(this).val();
            console.log(rating);
            if (rating > 5) {
                alert('Rating Can\'t be more than five')
                $('#rating').val('');
            }
        });
    </script>
@endpush
