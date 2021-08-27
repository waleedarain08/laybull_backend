@extends('layouts.app', ['page' => __('Add Grocery Product'), 'pageSlug' => 'groceryproduct'])
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ __('Insert Grocery Category') }}</h5>
                </div>
                <form method="post" action="{{ route('groceryproduct.store') }}" enctype="multipart/form-data">
                    <div class="card-body">
                        @csrf
                        @include('alerts.success')
                        <div class="form-group">
                        <label>Grocery_Category</label>
                        <select name="grocerycategory" class="form-control" required>
                          <option value="" class="bg-danger">Select Grocery Category</option>    
                            @foreach($grocercategory as $records)
                            @if(auth()->user()->role == 'admin')
                            <option value="{{$records->id}}">{{$records->name}}</option>
                            @elseif( $records->vendor_id == auth()->user()->id)
                            <option value="{{$records->id}}">{{$records->name}}</option>
                            @endif
                            @endforeach
                        </select>
                        </div>
                        @if(auth()->user()->role == 'admin')
                            <div class="form-group">
                                <label>Vendor</label>
                                <select name="vendor" class="form-control">
                                        <option value="" class="bg-danger">Select Vendors</option>    
                                    @foreach($userrecords as $record)
                                        @if(!is_null($record->modules))
                                        <option value="{{$record->id}}">{{$record->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="form-group">
                        <label>Grocery_Product</label>
                        <input type="text" name="name" class="form-control" placeholder="Grocery_Product" required >
                        </div>
                        <div class="form-group">
                        <label>Quantity</label>
                        <input type="number" name="quantity" class="form-control" placeholder="Quantity" required >
                        </div>
                        <div class="form-group">
                        <label>Price</label>
                        <input type="number" name="price" class="form-control" placeholder="Price" required >
                        </div>
                        <label for="file">Image</label>
                        <br>
                        <input type="file" name="image" class="btn btn-link btn-sm" style="width:250px">
                        <br>
                       <br><br> 
                       <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                        </select>
                        </div>
                        </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-primary">{{ __('Insert') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
