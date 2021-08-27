@extends('layouts.app',['page' => __('Edit Product'), 'pageSlug' => 'product.edit'])
@section('content')
<!-- Main content -->
<section class="content">
    <div class="container">
    <form id="products-form" action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" >
            @csrf
            <input name="_method" type="hidden" value="PUT">
    <div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit Product</h3>
            <div class="card-tools">

            </div>
        </div>
        <div class="card-body">
        <div class="row">
        <div class="col-md-12 col-sm-4">
            <div class="form-group">
            <label for="vendor">By Vendor</label>
                <input type="text" class="form-control" value="{{$vendor_name}}" readonly>
                <input type="hidden" id="vendor" name="vendor" class="form-control" readonly value="{{$vendor_id}}">
            </div>
            </div>
        <div class="col-md-12 col-sm-4">
            <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ $product->name }}">
            </div>
        </div>

        <div class="col-md-12 col-sm-4">
            <div class="form-group">
            <label for="cat_id">Category</label>
            <select id="cat_id" name="cat_id" class="form-control custom-select">
                <option selected disabled>Select one</option>
                @foreach($cats as $cat)
                    <option value="{{ $cat->id }}" @if ($cat->id == $product->category_id) selected @endif>{{ $cat->name }}</option>
                @endforeach
            </select>
            </div>
        </div>

            <div class="col-md-12 col-sm-4">
                <div class="form-group" >
                    <label for="image">Feature Image</label>
                    <input type="file" id="feature_image" name="feature_image" class="form-control" style="padding:12px;">
                    <img src="{{ asset($product->feature_image ? 'uploads/productImages/'.$product->feature_image : 'images/noImage.png') }}" alt=""  width="100" height="100">
                </div>
            </div>
            <div class="col-md-12 col-sm-4">
            <div class="form-group">
            <label for="brand_id">Brand</label>
            <select id="brand_id" name="brand_id" class="form-control custom-select">
                <option disabled>Select One</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" @if ($brand->id == $product->brand_id) selected @endif>{{$brand->name}}</option>
                @endforeach
            </select>
            </div>
            </div>

            <div class="col-md-12 col-sm-4">
            <div class="form-group">
            <label for="price">Price</label>
            <input type="text" id="price" name="price" class="form-control" value="{{$product->price}}">
            </div>
        </div>

        </div>
        <!-- 2nd row starts here -->
        <div class="row">
            <div class="col-md-12 col-sm-4">
                <div class="form-group">
                    <label for="color">Color</label>
                    <input type="text" id="color" name="color" value="{{ $product->color }}" class="form-control" placeholder="Enter a Color">
                </div>
            </div>
            <div class="col-md-12 col-sm-4">
                <div class="form-group">
                    <label for="size">Size</label>
                    <select id="size" name="size" class="form-control custom-select" required>
                        <option value="0" >none</option>
                        <option value="XS" @if($product->size == 'XS') selected @endif>XS</option>
                        <option value="S" @if($product->size == 'S') selected @endif>S</option>
                        <option value="M" @if($product->size == 'M') selected @endif>M</option>
                        <option value="L" @if($product->size == 'L') selected @endif>L</option>
                        <option value="XL" @if($product->size == 'XL') selected @endif>XL</option>
                        <option value="XXL" @if($product->size == 'XXL') selected @endif>XXL</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12 col-sm-4">
                <div class="form-group">
                    <label for="condition">Condition</label>
                    <select id="condition" name="condition" class="form-control custom-select" required>
                        <option value="0" >none</option>
                        <option value="NEW" @if($product->condition == 'NEW') selected @endif>NEW</option>
                        <option value="USED" @if($product->condition == 'USED') selected @endif>USED</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12 col-sm-4">
                <div class="form-group">
                    <label for="popularProduct">Popular Product</label>
                    <select id="popularProduct" name="popular" class="form-control custom-select" required>
                        <option value="0" >none</option>
                        <option value="1" @if($product->popular == 1) selected @endif>YES</option>
                        <option value="0" @if($product->popular == 0) selected @endif>NO</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12 col-sm-4">
                <label for="image">More Images</label>
                <span>If you add More Images then previous images will be deleted..</span>
                <div class="form-control">
                    <input type="file" id="image" name="images[]" placeholder="Enter a Images" multiple>
                </div>
            </div>
            <div class="col-md-12 col-sm-4">
                <div class="form-group">
                    @foreach ($product->images as $image)
                        <img src="{{ asset($image->image) }}" alt=""  width="100" height="100">
                    @endforeach
                </div>
            </div>
            <div class="col-md-12 col-sm-4">
                <div class="form-group">
                <label for="short_desc">Short Desc:</label>
                    <textarea id="short_desc" name="short_desc" class="form-control" rows="4">{{$product->short_desc}}</textarea>
                </div>
            </div>
        </div><!-- /.2nd row ends -->

        </div>
        <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    </div>

    <div class="row">
    <div class="col-12">
        <a href="{{route('products.index')}}" class="btn btn-secondary">Cancel</a>
        <input type="submit" value="Update Product" class="btn btn-success float-right">
    </div>
    </div>
    </form>
    </div>
</section>


    <!-- /.content -->


@endsection

