@extends('layouts.app', ['page' => __('Add Food Product'), 'pageSlug' => 'foodproduct'])
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ __('Insert Food Product') }}</h5>
                </div>
                <form method="post" action="{{ route('food.store') }}" enctype="multipart/form-data">
                    <div class="card-body">
                        @csrf
                        @include('alerts.success')
                        <div class="form-group">
                            <label>Food_Category</label>
                                <select name="foodcategory" class="form-control"  required>
                                    <option value="" class="bg-danger">Select Food Category</option> 
                                    @foreach($record as $records)
                                    @if(auth()->user()->role == 'admin')
                                    <option value="{{$records->id}}">{{$records->name}}</option>
                                    @elseif($records->vendor_id == auth()->user()->id)   
                                        <option value="{{$records->id}}">{{$records->name}}</option>
                                    @endif
                                    @endforeach
                                </select>
                        </div>
                        @if(auth()->user()->role == 'admin')
                            <div class="form-group">
                                <label>Vendor</label>
                              <select name="vendor" class="form-control">
                                    <option value="" class="bg-danger">Select Vendor</option> 
                                    @foreach($userrecords as $record)
                                    <option value="{{$record->id}}">{{$record->name}}</option>
                                    @endforeach
                                </select>   
                            </div>
                        @endif
                        <div class="form-group">
                            <label>Food_Product</label>
                            <input type="text" name="name" class="form-control" placeholder="Food_Product" required >
                        </div>
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="number" name="quantity" class="form-control" placeholder="Quantity" required >
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" name="price" class="form-control" placeholder="Price" required >
                        </div>
                        <input type="file" name="image">
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
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
