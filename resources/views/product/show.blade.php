@extends('layouts.app', ['page' => __('Product'), 'pageSlug' => 'Product'])
@section('content')
<!-- Main content -->
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Product Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-4">
                                <div class="form-group">
                                    <label for="vendor">By Vendor</label>
                                    <input type="text" id="vendor" name="vendor" class="form-control" readonly value="1">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-4">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" id="name" name="name" class="form-control" readonly value="{{$product->name}}">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-4">
                                <label for="Feature Image">Feature Image</label>
                                <div class="form-group">
                                    <img src="{{ asset('uploads/productImages/'.$product->feature_image) }}" alt=""  width="100" height="100">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-4">
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="text" id="price" name="price" class="form-control" readonly value="{{$product->price}}">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-4">
                                <div class="form-group">
                                    <label for="discount">Discount</label>
                                    <input type="text" id="discount" name="discount" class="form-control" readonly value="{{$product->discount}}">
                                </div>
                            </div>
                        </div>

                        <!-- 2nd row starts here -->
                        <div class="row">
                            <div class="col-md-12 col-sm-4">
                                <div class="form-group">
                                    <label for="original_price">Original Price</label>
                                    <input type="text" id="original_price" name="original_price" class="form-control" readonly value="{{$product->original_price}}">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-4">
                            <div class="form-group">
                                <label for="color">Color</label>
                                <input type="text" id="color" value="{{ $product->color }}" readonly class="form-control">
                            </div>
                            </div>
                            <div class="col-md-12 col-sm-4">
                                <label for="">All Images</label>
                                <div class="form-group">
                                    @foreach ($product->images as $image)
                                        <img src="{{ URL::To('/'.$image->image) }}" alt=""  width="100" height="100">
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-4">
                                <div class="form-group">
                                <label for="short_desc">Short Desc:</label>
                                    <textarea id="short_desc" name="short_desc" class="form-control" rows="4" readonly value="{{$product->short_desc}}">{{$product->short_desc}}</textarea>
                                </div>
                            </div>
                        </div><!-- /.2nd row ends -->

                    </div>
        <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    </div>

        <div class="container"></div>
        <div class="row w-100">
            <div class="col-md-10">
                <a href="{{route('products.index')}}" class="btn btn-secondary">Back</a>

            </div>
            <div class="col-md-2">
                @if($product->status == 0)
                    <a href="{{ route('products.approve',$product->id) }}" class="btn btn-success">Approve</a>@endif
                @if($product->status == 1)
                    <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#basicModal">Reject</a>
                @endif
            </div>
        </div>
{{--            Modal              --}}
        <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog">
                <form method="post" action="{{ route('products.reject')  }}" class="">

                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Reason</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body ">
                        <h3 class="text-dark"></h3>
                        <textarea name="reason" style="background-color: #f2f2f2;" placeholder="Please specify rejection reason:" id="reason" cols="60" rows="4"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ $product->id }}" >
                            <button type="submit" class="btn btn-danger btn-sm">Submit</button>

{{--                         <a type="button" href="{{URL('product/reject/' )}}" class="btn btn-success">Submit</a>--}}
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
