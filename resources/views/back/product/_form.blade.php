@csrf

<div class="form-group col-md-10">
    <label class="control-label">Product Name <span class="font-weight-bold text-danger">*</span></label>
    <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name"  value="{{ old('name',isset($product)?$product->name:null) }}" placeholder="Enter product name">
    @error('name')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group col-md-7">
    <label class="control-label">Slug/Permalink <span class="font-weight-bold text-danger">* (Must be unique)</span></label>
    <input class="form-control @error('slug') is-invalid @enderror" type="text" id="slug" name="slug"  value="{{ old('slug',isset($product)?$product->slug:null) }}" placeholder="Enter product slug">
    @error('slug')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group col-md-3">
    <label class="control-label">Product SKU</label>
    <input class="form-control @error('code') is-invalid @enderror" type="text" name="code"  value="{{ old('code',isset($product)?$product->code:null) }}" placeholder="Enter product sku">
    @error('code')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="col-md-4">
    @php
        if(old("category_id")){
            $category_id = old('category_id');
        }elseif(isset($product)){
            $category_id = $product->category_id;
        }else{
            $category_id = null;
        }
    @endphp
    <div class="form-group">
        <label for="category_id">Category <span class="font-weight-bold text-danger">*</span></label>
        <select required class="form-control select2  form-control-line @error('category_id') is-invalid @enderror" name="category_id" id="category">
            <option value="">Select Category</option>
            @foreach($categories as $id=>$category)
                <option @if($category_id == $id) selected @endif value="{{ $id }}">{{ ucfirst($category) }}</option>
            @endforeach
        </select>
    </div>
    @error('category_id')
    <div class="pl-1 text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="col-md-3">
    <div class="form-group">
        <label for="sub_category_id">Sub-Category</label>
        <select class="form-control select2  form-control-line @error('sub_category_id') is-invalid @enderror" name="sub_category_id" id="sub_category">
            <option value="">Select Sub-Category</option>
            @if (isset($product))
                @foreach($sub_categories as $sub_category)
                    <option @if($product->sub_category_id == $sub_category->id) selected @endif value="{{ $sub_category->id }}">{{ ucfirst($sub_category->name) }}</option>
                @endforeach
            @endif
        </select>
    </div>
    @error('sub_category_id')
    <div class="pl-1 text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="col-md-3">
    <div class="form-group">
        @php
            if(old("brand_id")){
                $brand_id = old('brand_id');
            }elseif(isset($product)){
                $brand_id = $product->brand_id;
            }else{
                $brand_id = null;
            }
        @endphp
        <label for="brand_id">Brand <span class="font-weight-bold text-danger">*</span></label>
        <select required class="select2 form-control  form-control-line @error('brand_id') is-invalid @enderror" name="brand_id" id="brand_id">
            <option value="">Select Brand</option>
            @foreach($brands as $id=>$value)
                <option @if($brand_id == $id) selected @endif value="{{ $id }}">{{ ucfirst($value) }}</option>
            @endforeach
        </select>
    </div>
    @error('brand_id')
    <div class="pl-1 text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="col-md-2"></div>

@if (auth()->user()->type == 'vendor')

    <div class="col-md-4">
        <div class="form-group">
            <label for="size">Size </label>
            <input name="size" type="text" value="{{ old('size',isset($product)?$product->size:null) }}"  class="form-control form-control-line @error('size') is-invalid @enderror" id="size">
        </div>
        @error('size')
        <div class="pl-1 text-danger">{{ $message }}</div>
        @enderror
    </div>
    @else
    <div class="col-md-2">
        <div class="form-group">
            <label for="point">Reward Point </label>
            <input name="point" type="number" value="{{ old('point',isset($product)?$product->point:null) }}"  class="form-control form-control-line @error('point') is-invalid @enderror" id="point">
        </div>
        @error('point')
        <div class="pl-1 text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <label for="size">Size </label>
            <input name="size" type="text" value="{{ old('size',isset($product)?$product->size:null) }}"  class="form-control form-control-line @error('size') is-invalid @enderror" id="size">
        </div>
        @error('size')
        <div class="pl-1 text-danger">{{ $message }}</div>
        @enderror
    </div>
@endif


<div class="col-md-3">
    <div class="form-group">
        <label for="color">Color </label>
        <input name="color" type="text" value="{{ old('color',isset($product)?$product->color:null) }}"  class="form-control form-control-line @error('color') is-invalid @enderror" id="color">
    </div>
    @error('color')
    <div class="pl-1 text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="col-md-3">
    <div class="form-group">
        <label for="stock">Stock <span class="font-weight-bold text-danger">*</span></label>
        <input required name="stock" type="number" value="{{ old('stock',isset($product)?$product->stock:null) }}"  class="form-control form-control-line @error('stock') is-invalid @enderror" id="stock">
    </div>
    @error('stock')
    <div class="pl-1 text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="col-md-2"></div>
<div class="col-md-2">
    <div class="form-group">
        <label for="price">Price <span class="font-weight-bold text-danger">*</span></label>
        <input required name="price" type="number" step=".01" value="{{ old('price',isset($product)?$product->price:null) }}"  class="form-control form-control-line @error('price') is-invalid @enderror" id="price">
    </div>
    @error('price')
    <div class="pl-1 text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="col-md-2">
    <div class="form-group">
        <label for="price">Offer Price</label>
        <input name="new_price" type="number" step=".01" value="{{ old('new_price',isset($product)?$product->new_price:null) }}"  class="form-control form-control-line @error('new_price') is-invalid @enderror" id="new_price">
    </div>
    @error('new_price')
    <div class="pl-1 text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="col-md-3">
    <div class="form-group">
        @php
            if(old("concern_id")){
                $concern_id = old('concern_id');
            }elseif(isset($product)){
                $concern_id = $product->concern_id;
            }else{
                $concern_id = null;
            }
        @endphp
        <label for="brand_id">Concern</label>
        <select class="select2 form-control  form-control-line @error('concern_id') is-invalid @enderror" name="concern_id" id="concern_id">
            <option value="">Select Concern</option>
            @foreach($concerns as $id=>$concern)
                <option @if($concern_id == $id) selected @endif value="{{ $id }}">{{ ucfirst($concern) }}</option>
            @endforeach
        </select>
    </div>
    @error('brand_id')
    <div class="pl-1 text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="col-md-3">
    @if (auth()->user()->type != 'vendor')
    <div class="form-group">
        @php
            if(old("status")){
                $status = old('status');
            }elseif(isset($product)){
                $status = $product->status;
            }else{
                $status = null;
            }
        @endphp
        <label for="default">Status <span class="font-weight-bold text-danger">*</span></label>
        <select required class="form-control form-control-line @error('status') is-invalid @enderror" name="status">
            <option value="">Select status</option>
            <option @if($status =='active') selected @endif value="active">Active</option>
            <option @if($status =='inactive') selected @endif value="inactive">Inactive</option>
            <option @if($status =='pending') selected @endif value="inactive">Pending</option>
        </select>
    </div>
    @else
        <input type="hidden" name="status" value="pending">
    @endif
    @error('status')
    <div class="pl-1 text-danger">{{ $message }}</div>
    @enderror

</div>

<div class="col-md-10">
    <div class="form-group">
        <label for="description">Product Details </label>
        <textarea name="details" rows="10" class="form-control form-control-line @error('details') is-invalid @enderror" id="details">{{ old('details',isset($product)?$product->details:null) }}</textarea>
    </div>
    @error('description')
    <div class="pl-1 text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="col-md-10">
    <div class="card mt-3 mb-3">
        <div class="card-header bg-gradient-info">
            <h6 class="card-title">Images [Size: 925x1050 px] <b class="text-danger">*</b> <span class="float-right"><button type="button" class="btn btn-sm btn-outline-primary" onClick="addmore();">Add Item</button> </span></h6>
        </div>
        <div class="card-body">
            <div class="form-group row mr-2" id="field">

                @if(isset($product) && count($product->product_image))
                    @forelse($product->product_image as $index=>$gallery)
                        <div class="col-md-3 img-container mt-3">
                            <input type="file" data-default-file="{{ asset($gallery->file_path) }}" name="images[]" id="gallery" class="form-control dropify" data-height="120">
                            <div class="topright_btn">
                                @if($index > 0)
                                <a href="{{ route('product.delete.image', $gallery->id) }}" onclick="return confirm('Are you sure to delete?')" class="btn btn-sm btn-danger dltbtn">x</a>
                                @endif
                            </div>
                            @error('images')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    @empty
                    @endforelse
                @else
                    <div class="col-md-3 img-container mt-3">
                        <input required type="file" name="images[]" id="gallery" class="form-control dropify" data-height="120">
                        <div class="topright_btn">
                            <button type="button" class="btn btn-sm btn-danger">x</button>
                        </div>
                        @error('images')
                        <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{--<div class="col-md-10">
    <div class="form-group row">
        <div class="col-md-10">
            <label class="control-label">Youtube Embed Link</label>
            <input class="form-control @error('youtube_link') is-invalid @enderror" type="text" name="youtube_link"  value="{{ old('youtube_link',isset($product)?$product->youtube_link:null) }}" placeholder="Enter youtube embed link">
            @error('youtube_link')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="col-md-2">
            <label for="stock">No. of Review </label>
            <input name="review" type="number" class="form-control form-control-line @error('review') is-invalid @enderror" id="review">
        </div>
    </div>
</div>--}}

@if (auth()->user()->type != 'vendor')
    <div class="col-md-10">
        <div class="form-group">
            @php
                if(old("is_featured")){
                    $is_featured = old('is_featured');
                }elseif(isset($product)){
                    $is_featured = $product->is_featured;
                }else{
                    $is_featured = null;
                }
            @endphp
            <label for="default">Is Featured?</label>
            <br>
            <input name="is_featured" type="checkbox" value="1" @if($is_featured == 1) checked @endif> <label
                for="active">Yes</label>
        </div>
    </div>
@endif

<div class="col-md-10">
        <button type="button" class="collapsible">Product SEO</button>
        <div class="content">
            <br>
            <div class="form-group">
                <input class="form-control @error('meta_title') is-invalid @enderror" type="text" name="meta_title"  value="{{ old('meta_title',isset($product)?$product->meta_title:null) }}" placeholder="Product meta title">
                @error('meta_title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <input class="form-control @error('meta_key') is-invalid @enderror" type="text" name="meta_key"  value="{{ old('meta_key',isset($product)?$product->meta_key:null) }}" placeholder="Product meta keyword">
                @error('meta_key')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <textarea name="meta_description" class="form-control @error('meta_description') is-invalid @enderror" id="meta_description" cols="30" rows="5" placeholder="Product meta description (150 character max)">{{ old('meta_description',isset($product)?$product->meta_description:null) }}</textarea>
                @error('meta_description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
</div>



<style>
    .collapsible {
        background-color: #777;
        color: white;
        cursor: pointer;
        padding: 10px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
    }

    .on, .collapsible:hover {
        background-color: #555;
    }

    .collapsible:after {
        content: '\002B';
        color: white;
        font-weight: bold;
        float: right;
        margin-left: 5px;
    }

    .on:after {
        content: "\2212";
    }

    .content {
        padding: 0 18px;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.2s ease-out;
        background-color: #f1f1f1;
    }

    .img-container {
        position: relative;
    }
    .topright_btn {
        position: absolute;
        top: 0px;
        right: -7px;
    }
    .rmvbtn{
        border-radius: unset;
    }
</style>

<script>
    var coll = document.getElementsByClassName("collapsible");
    var i;

    for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            this.classList.toggle("on");
            var content = this.nextElementSibling;
            if (content.style.maxHeight){
                content.style.maxHeight = null;
            } else {
                content.style.maxHeight = content.scrollHeight + "px";
            }
        });
    }



    function myFunction() {
        var checkBox = document.getElementById("flash");
        if (checkBox.checked == true){
            $("#expire").attr('required',true);
        } else {
            $("#expire").removeAttr('required');
        }
    }


    function addmore() {

        var input = "<div class=\"col-md-3 img-container mt-3\">\n" +
            "                                                <input type=\"file\" name=\"images[]\" id=\"gallery\" class=\"form-control dropify\" data-height=\"120\" required>\n" +
            "                                                <div class=\"topright_btn\">\n" +
            "                                                    <button type=\"button\" class=\"btn btn-sm btn-danger rmvbtn\">x</button>\n" +
            "                                                </div>\n" +
            "                                                @error('gallery')\n" +
            "                                                <span class=\"text-danger\" role=\"alert\">\n" +
            "                                                    <strong>{{ $message }}</strong>\n" +
            "                                                </span>\n" +
            "                                                @enderror\n" +
            "                                            </div>";

        $("#field").append(input);
        $('.dropify').dropify();


        $(".rmvbtn").click(function(){
            $(this).parent().parent().remove();
        });
    }

</script>


