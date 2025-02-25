
           @if (auth()->user()->type == 'superadmin' || auth()->user()->type == 'admin')
               <div class="form-group row">
                   @php
                       if(old("type")){
                           $type = old('type');
                       }elseif(isset($admin)){
                           $type = $admin->type;
                       }else{
                           $type = null;
                       }
                   @endphp
                   <label for="default" class="control-label col-md-3">Type </label>
                   <div class="col-md-8">
                       <select name="type" class="form-control @error('name') is-invalid @enderror">
                           <option value="">Select</option>
                           <option value="admin" @if($type=='admin') selected @endif>Admin</option>
                           <option value="operator" @if($type=='operator') selected @endif>Operator</option>

                       </select>
                       @error('type')
                       <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                    </span>
                       @enderror
                   </div>
               </div>
           @else
               <input type="hidden" name="type" value="{{ $admin->type }}">
           @endif


            <div class="form-group row">
                <label class="control-label col-md-3">Name </label>
                <div class="col-md-8">
                    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name',isset($admin)?$admin->name:null) }}" required>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>


            <div class="form-group row">
                <label for="email" class="control-label col-md-3">Email </label>
                <div class="col-md-8">
                    <input name="email" type="email" value="{{ old('email',isset($admin)?$admin->email:null) }}"  class="form-control @error('email') is-invalid @enderror" id="email" @if(auth()->user()->type == 'operator' || auth()->user()->type == 'vendor') readonly @endif>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>


            <div class="form-group row">
                <label for="phone" class="control-label col-md-3">Phone</label>
                <div class="col-md-8">
                    <input name="phone" type="text" value="{{ old('phone',isset($admin)?$admin->phone:null) }}"  class="form-control @error('phone') is-invalid @enderror" id="phone">
                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="control-label col-md-3">Image</label>
                <div class="col-md-8">
                    <input type="file" name="image" id="input-file-max-fs" class="dropify @error('image') is-invalid @enderror" data-default-file="{{ isset($admin)?asset($admin->image):null }}" data-max-file-size="2M">
                    @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>


            <div class="form-group row">
                <label for="password" class="control-label col-md-3">Password </label>
                <div class="col-md-8">
                    <input name="password" type="password"   class="form-control @error('password') is-invalid @enderror" id="password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="password_confirmation" class="control-label col-md-3">Confirm Password </label>
                <div class="col-md-8">
                <input name="password_confirmation" type="password"   class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation">

                </div>
            </div>


@push('library-css')
    <!-- dropify CSS-->
    <link rel="stylesheet" href="{{asset('backend/dropify/css/dropify.min.css')}}">
@endpush



@push('custom-css')
    <style>
        .dropify-wrapper{
            height: 120px;
        }
    </style>
@endpush



@push('library-js')
    <!-- dropify JS-->
    <script src="{{asset('backend/dropify/js/dropify.min.js')}}"></script>
@endpush



@push('custom-js')
    <script>
        $(document).ready(function(){
            // Basic
            $('.dropify').dropify();
        });
    </script>
@endpush
