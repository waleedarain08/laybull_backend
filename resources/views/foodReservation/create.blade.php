@extends('layouts.app', ['page' => __('Create Food Reservation'), 'pageSlug' => 'foodreservation'])
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ __('Create Food Reservation') }}</h5>
                </div>
                <form method="post" action="{{ route('reservation.store') }}">
                    <div class="card-body">
                        @csrf
                        @include('alerts.success')
                        @if(auth()->user()->role == 'admin')
                        <div class="form-group">
                            <label>Select Vendor</label>
                                <select name="vendor" class="form-control">
                                   @foreach($record as $records)
                                  <option value="{{$records->id}}">{{$records->name}}</option>
                                  @endforeach
                                </select>
                        </div>
                        @endif
                        <div class="form-group">
                            <label>Name</label>
                                <select name="name" class="form-control">
                                    <option value="morning" class="bg-danger">Morning</option> 
                                    <option value="lunch" class="bg-danger">Lunch</option> 
                                    <option value="dinner" class="bg-danger">Dinner</option> 
                                </select>
                        </div>
                        <div class="form-group">
                            <label>Time</label>
                            <input type="time" name="time" class="form-control" placeholder="Time" required >
                        </div>
                        <div class="form-group">
                            <label>Person</label>
                            <input type="number" name="person" class="form-control" placeholder="Person" required >
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" name="price" class="form-control" placeholder="Price" required >
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
