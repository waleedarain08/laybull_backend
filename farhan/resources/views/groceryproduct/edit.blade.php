@extends('layouts.app', ['page' => __('Edit Grocery Product'), 'pageSlug' => 'groceryproduct'])
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ __('Edit Grocery Category') }}</h5>
                </div>
                <form method="post" action="{{ route('groceryproduct.update',$record->id)}}" enctype="multipart/form-data">
                    <div class="card-body">
                        @csrf
                        @include('alerts.success')
                        @method('put')
                        <div class="form-group">
                        <label>Grocery_Category</label>
                        <select name="grocerycategory" class="form-control">
                          <option value="" class="bg-danger">Select Grocery Category</option>    
                            @foreach($groceryCategories as $records)
                            <option value="{{$records->id}}" {{$records->id == $record->grocery_category_id ? 'selected' : '' }}>{{$records->name}}</option>
                            @endforeach
                        </select>
                        </div>
                        <div class="form-group">
                        <label>Grocery_Product</label>
                        <input type="text" name="name" class="form-control" value="{{$record->name}}" placeholder="Grocery_Product" required >
                        </div>
                        <div class="form-group">
                        <label>Quantity</label>
                        <input type="number" name="quantity" class="form-control" value="{{$record->quantity}}" placeholder="Quantity" required >
                        </div>
                        <div class="form-group">
                        <label>Price</label>
                        <input type="number" name="price" class="form-control" value="{{$record->price}}" placeholder="Price" required >
                        </div>
                        <label for="file">Image</label>
                        <br>
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
