<div class="form-group row">
    <label for="logo" class="col-md-4 col-form-label text-md-right">{{ __('Image') }} <span class="text-danger">*</span></label>
    <div class="col-md-6">

        <input type="file" id="input-file-now-custom-1" name="image" class="dropify" @error('image') is-invalid @enderror data-default-file="@if(isset($offer->image)){{asset($offer->image)}}@else{{asset('uploads/default.jpg')}}@endif" data-max-file-size="2M"/>

    </div>
</div>
<!--link-->


<div class="form-group row">
    <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Offer Title') }} <span class="text-danger">*</span></label>

    <div class="col-md-6">
        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="@if (isset($offer->title)){{$offer->title}}@endif" required autocomplete="title">
        @error('title')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
    </div>
</div>



<!--about-->
<div class="form-group row">
    <label for="embed-map" class="col-md-4 col-form-label text-md-right">{{ __('Details') }} <span class="text-danger">*</span></label>
    <div class="col-md-6">
        <textarea name="text" id="" class="form-control" rows="6" required>@if(isset($offer->text)){{ $offer->text}}@endif</textarea>

        @error('text')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
    </div>
</div>
