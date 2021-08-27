@extends('layouts.app',['page' => __('Products'), 'pageSlug' => 'products.create'])
@section('content')
<!-- Main content -->
<section class="content">
    <div class="container">
        <form id="products-form" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add Product</h3>
                            <div class="card-tools">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-4">
                                    <div class="form-group">
                                        <label for="vendor">By Vendor</label>
                                        <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                                        <input type="hidden" id="vendor" name="vendor" class="form-control" readonly value="{{ Auth::user()->id }}">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-4">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter Product Name" required>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-4">
                                    <div class="form-group">
                                    <label for="cat_id">Category</label>
                                    <select id="cat_id" name="cat_id" class="form-control custom-select" required>
                                        <option selected disabled>Select one</option>
                                        @foreach($cats as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-4">
                                    <label for="image">Feature Image</label>
                                    <div class="form-control" >
                                        <input type="file" id="feature_image" name="feature_image" required>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-4">
                                    <div class="form-group">
                                        <label for="brand_id">Brand</label>
                                        <select id="brand_id" name="brand_id" class="form-control custom-select" required>
                                            <option value="0" >none</option>
                                            @foreach($brands as $brand)
                                                <option value="{{$brand->id}}">{{$brand->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-4">
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <input type="text" id="price" name="price" class="form-control" placeholder="Enter the Price" required>
                                    </div>
                                </div>

                            </div>
                            <!-- 2nd row starts here -->
                            <div class="row">
                                <div class="col-md-12 col-sm-4">
                                    <div class="form-group">
                                        <label for="color">Color</label>
                                        <input type="text" id="color" name="color" class="form-control" placeholder="Enter the Product Color" required>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-4">
                                    <div class="form-group">
                                        <label for="size">Size</label>
                                        <select id="size" name="size" class="form-control custom-select" required>
                                            <option value="0" >none</option>
                                            <option value="XS">XS</option>
                                            <option value="S">S</option>
                                            <option value="M">M</option>
                                            <option value="L">L</option>
                                            <option value="XL">XL</option>
                                            <option value="XXL">XXL</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-4">
                                    <div class="form-group">
                                        <label for="condition">Condition</label>
                                        <select id="condition" name="condition" class="form-control custom-select" required>
                                            <option value="0" >none</option>
                                            <option value="NEW">NEW</option>
                                            <option value="USED">USED</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-4">
                                    <div class="form-group">
                                        <label for="popularProduct">Popular Product</label>
                                        <select id="popularProduct" name="popular" class="form-control custom-select" required>
                                            <option value="0" >none</option>
                                            <option value="1">YES</option>
                                            <option value="0">NO</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-4">
                                    <label for="image">More Images</label>
                                    <div class="form-control">
                                        <input type="file" id="image" name="images[]" multiple>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-4">
                                    <div class="form-group">
                                    <label for="short_desc">Short Desc:</label>
                                        <textarea id="short_desc" name="short_desc" class="form-control" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <div class="row">
        <div class="col-12">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
            <input type="submit" value="Create new Product" class="btn btn-success float-right">
        </div>
        </div>
        </form>
    </div>
</section>
<!-- /.content -->
@endsection
