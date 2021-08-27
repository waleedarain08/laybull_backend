@extends('layouts.app', ['page' => __('Add Food Product'), 'pageSlug' => 'foodproduct'])
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ __('Edit Food Product') }}</h5>
                </div>
                <form method="post" action="{{route('food.update',$record->id)}}" enctype="multipart/form-data">
                    <div class="card-body">
                        @csrf
                        @method('put')
                        @include('alerts.success')

                        <div class="form-group">
                            <label>Food_Category</label>
                            <select name="foodcategory" class="form-control">
                                <option value="" class="bg-danger">Select Food Category</option> 
                                @foreach($foodCategories as $category)
                                <option value="{{$category->id}}" {{$category->id == $record->food_category_id ? 'selected' : ''}}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                       <div class="form-group">
                            <label>Food_Product</label>
                            <input type="text" name="name" value="{{$record->name}}" class="form-control" placeholder="Food_Product" required >
                        </div>
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="number" name="quantity"  value="{{$record->quantity}}" class="form-control" placeholder="Quantity" required >
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" name="price" class="form-control"  value="{{$record->price}}" placeholder="Price" required >
                        </div>
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
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
