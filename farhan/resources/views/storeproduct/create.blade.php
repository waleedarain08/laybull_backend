@extends('layouts.app', ['page' => __('Add Store Product'), 'pageSlug' => 'storeproduct'])
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ __('Insert Store Product') }}</h5>
                </div>
                <form method="post" action="{{ route('storeproduct.store') }}" enctype="multipart/form-data">
                    <div class="card-body">
                        @csrf
                        @include('alerts.success')
                        <div class="form-group">
                        <label>Store_Category</label>
                        <select name="storecategory" class="form-control" required>
                          <option value="" class="bg-danger">Select Store Category</option>    
                          @foreach($record as $records)
                            @if(auth()->user()->role=='admin')
                            <option value="{{$records->id}}">{{$records->name}}</option>
                            @elseif($records->vendor_id == auth()->user()->id)
                            <option value="{{$records->id}}">{{$records->name}}</option>
                            @endif
                            @endforeach
                        </select>
                        </div>
                        @if(auth()->user()->role == 'admin')
                        <div class="form-group">
                        <label>Select Vendor</label>
                        <select name="vendor" class="form-control">
                          <option value="" class="bg-danger">Select Vendor</option>    
                            @foreach($userrecords as $record)
                             <option value="{{$record->id}}">{{$record->name}}</option>
                            @endforeach
                        </select>
                        </div>
                        @endif
                        <div class="form-group">
                        <label>Store_Product</label>
                        <input type="text" name="name" class="form-control" placeholder="Store_Product" required >
                        </div>
                        <div class="form-group">
                        <label>Quantity</label>
                        <input type="number" name="quantity" class="form-control" placeholder="Quantity" required >
                        </div>
                        <div class="form-group">
                        <label>Price</label>
                        <input type="number" name="price" class="form-control" placeholder="Price" required >
                        </div>
                        <label>Image</label><br>
                        <input type="file" name="image"  class="btn btn-link btn-sm float-left" >
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
