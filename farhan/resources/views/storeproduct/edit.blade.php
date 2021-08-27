@extends('layouts.app', ['page' => __('Edit Store Product'), 'pageSlug' => 'storeproduct'])
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ __('Edit Store Product') }}</h5>
                </div>
                <form method="post" action="{{ route('storeproduct.update',$record->id) }}" enctype="multipart/form-data">
                    <div class="card-body">
                        @csrf
                        @include('alerts.success')
                        @method('put')
                        <div class="form-group">
                        <label>Store_Category</label>
                        <select name="storecategory" class="form-control">
                          <option value="" class="bg-danger">Select Store Category</option>    
                          @foreach($storeCategories as $records)
                            <option value="{{$records->id}}" {{$records->id == $record->store_category_id ? 'selected' :' '}}>{{$records->name}}</option>
                            @endforeach
                        </select>
                        </div>
                       <div class="form-group">
                        <label>Store_Product</label>
                        <input type="text" name="name" value="{{$record->name}}" class="form-control" placeholder="Store_Product" required >
                        </div>
                        <div class="form-group">
                        <label>Quantity</label>
                        <input type="number" name="quantity" value="{{$record->quantity}}" class="form-control" placeholder="Quantity" required >
                        </div>
                        <div class="form-group">
                        <label>Price</label>
                        <input type="number" name="price" class="form-control" value="{{$record->price}}" placeholder="Price" required >
                        </div>
                        <label>Image</label><br>
                        <div class="col-md-4">
                            <div class="form-group">
                                <img src="{{$record->image}}" height="150px" width="150px">
                            </div>
                            <span>Choose file</span>
                            <input type="file" name="photo">
                        </div>
                       <br>
                       <br><br> 
                      
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-primary">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
