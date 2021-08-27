@extends('layouts.app', ['page' => __('Add Car'), 'pageSlug' => 'carlist'])
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ __('Add Car') }}</h5>
                </div>
                <form method="post" action="{{ route('cars.store') }}" enctype="multipart/form-data">
                    <div class="card-body">
                        @csrf
                        @include('alerts.success')
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
                        <label>Select Showroom</label>
                        <select name="showroomcategory" class="form-control">
                          <option value="" class="bg-danger">Select Showroom</option>    
                            @foreach($records as $record)
                            @if(auth()->user()->role == 'admin')
                            <option value="{{$record->id}}">{{$record->name}}</option>
                            @elseif($record->vendor_id == auth()->user()->id)
                            <option value="{{$record->id}}">{{$record->name}}</option>
                            @endif
                            @endforeach
                        </select>
                        </div>
                        <div class="form-group">
                        <label>Car Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Car Name" required >
                        </div>
                        <div class="form-group">
                        <label>Description</label>
                        <input type="text" name="description" class="form-control" placeholder="Description" required >
                        </div>
                        <div class="form-group">
                        <label>Price</label>
                        <input type="number" name="price" class="form-control" placeholder="Price" required >
                        </div>
                        <label>Image</label><br>
                        <input type="file" name="image"  class="btn btn-link btn-sm float-left" required>
                       <br>
                       <br><br> 
                       <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                        </select>
                        </div>
                        <div class="form-group">
                        <label>Reviews</label>
                        <input type="text" name="review" class="form-control" placeholder="Reviews" required >
                        </div>
                        <div class="form-group">
                        <label>Rating</label>
                        <input type="number" min="1" max="5" name="rating" class="form-control" placeholder="Rating" required >
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
