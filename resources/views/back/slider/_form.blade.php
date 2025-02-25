<div class="form-group row">
    <label for="logo" class="col-md-4 col-form-label text-md-right">{{ __('Image') }} <span class="text-danger">*</span></label>
    <div class="col-md-6">

        <input type="file" id="input-file-now-custom-1" name="image" class="dropify" @error('image') is-invalid @enderror data-default-file="@if(isset($slider->image)){{asset($slider->image)}}@else{{asset('uploads/default.jpg')}}@endif" data-max-file-size="2M"/>

    </div>
</div>
<!--link-->
{{--<div class="form-group row">
    <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Button Name') }}</label>

    <div class="col-md-6">
        <input id="btn" type="text" class="form-control @error('btn') is-invalid @enderror" name="btn" value="@if (isset($slider->btn)){{$slider->btn}}@endif" required autocomplete="btn">
        @error('btn')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
    </div>
</div>--}}


<div class="form-group row">
    <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Link') }}</label>

    <div class="col-md-6">
        <input id="link" type="text" class="form-control @error('link') is-invalid @enderror" name="link" value="@if (isset($slider->link)){{$slider->link}}@endif" autocomplete="link">
        @error('link')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
    </div>
</div>


<div class="form-group row">
    <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Slider Title') }} <span class="text-danger">*</span></label>

    <div class="col-md-6">
        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="@if (isset($slider->title)){{$slider->title}}@endif" required autocomplete="title">
        @error('title')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
    </div>
</div>



<!--about-->
{{--<div class="form-group row">
    <label for="embed-map" class="col-md-4 col-form-label text-md-right">{{ __('Text Content') }}</label>
    <div class="col-md-6">
        <textarea name="text" id="" class="form-control" rows="6" required>@if(isset($slider->text)){{ $slider->text}}@endif</textarea>
    </div>
</div>--}}
