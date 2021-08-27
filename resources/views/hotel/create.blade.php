@extends('layouts.app', ['page' => __('Add Hotel'), 'pageSlug' => 'hotel'])
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ __('Insert Hotel') }}</h5>
                </div>
                <form method="post" action="{{ route('hotel.store') }}" enctype="multipart/form-data">
                    <div class="card-body">
                        @csrf
                        @include('alerts.success')
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
                        </div>
                        <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Name" required >
                        </div>
                        <div class="form-group">
                        <label>Description</label>
                        <input type="text" name="description" class="form-control" placeholder="Description" required >
                        </div>
                        <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" class="form-control" placeholder="Email" required >
                        </div>
                        <div class="form-group">
                        <label>Phone</label>
                        <input type="number" name="phone" class="form-control" placeholder="Phone Number" required >
                        </div>
                        <div class="form-group">
                        <label>Price</label>
                        <input type="number" name="price" class="form-control" placeholder="Price" required >
                        </div>
                        <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="address" class="form-control" placeholder="Address" required >
                        </div>
                        <label for="file">Image</label>
                        <br>
                        <input type="file" name="image" class="btn btn-link btn-sm" style="width:250px"  required>
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
                        <input type="text" name="reviews" class="form-control" placeholder="Reviews" required >
                        </div>
                        <div class="form-group">
                        <label>Rating</label>
                        <input type="number" name="rating" min="1" max="5" class="form-control" placeholder="0-5" required >
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
