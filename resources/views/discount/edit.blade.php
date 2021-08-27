@extends('layouts.app',['page' => __('Edit Country'), 'pageSlug' => 'discounts.edit'])
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container">
            <form id="products-form" action="{{ route('discounts.update', $discount->id) }}" method="POST" enctype="multipart/form-data" >
                @csrf
                <input name="_method" type="hidden" value="PUT">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Edit Discount</h3>
                                <div class="card-tools">

                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="name">Coupon Name</label>
                                            <input type="text" id="coupon_name" name="coupon_name" class="form-control" value="{{ $discount->coupon_name }}">
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="price">Discount Percentage</label>
                                            <input type="text" id="discount_percent" name="discount_percent" class="form-control" value="{{$discount->discount_percent}}">
                                        </div>
                                    </div>

                                </div>
                                <!-- 2nd row starts here -->
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <a href="{{route('discounts.index')}}" class="btn btn-secondary">Cancel</a>
                        <input type="submit" value="Update Discount" class="btn btn-success float-right">
                    </div>
                </div>
            </form>
        </div>
    </section>


    <!-- /.content -->


@endsection

