@extends('layouts.app',['page' => __('Products'), 'pageSlug' => 'products.create'])
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container">
            <form id="products-form" action="{{ route('discounts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Add Discount</h3>
                                <div class="card-tools">
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="name">Coupon Name</label>
                                            <input type="text" id="coupon_name" name="coupon_name" class="form-control" placeholder="Enter Coupon Name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-4">
                                        <label for="image">Discount Percentage</label>
                                        <div class="form-control" >
                                            <input type="text" id="discount_percent" name="discount_percent" class="form-control" placeholder="Enter the Discount Percent" required>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('discounts.index') }}" class="btn btn-secondary">Cancel</a>
                        <input type="submit" value="Create new Discount" class="btn btn-success float-right">
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
@endsection
