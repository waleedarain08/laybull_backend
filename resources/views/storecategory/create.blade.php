@extends('layouts.app', ['page' => __('Add Store Category'), 'pageSlug' => 'storecategory'])
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ __('Insert Store Category') }}</h5>
                </div>
                <form method="post" action="{{ route('storecategory.store') }}" >
                    <div class="card-body">
                         @csrf
                         @include('alerts.success')
                        <div class="form-group">
                            <label>Store Catgory</label>
                            <input type="text" name="name" class="form-control" placeholder="Store Catgory" required >
                            @if(auth()->user()->role == 'admin')
                            <div class="form-group">
                                <label>Vendor</label>
                              <select name="vendor" class="form-control">
                                    <option value="" class="bg-danger">Select Vendor</option> 
                                    @foreach($records as $record)
                                        <option value="{{$record->id}}">{{$record->name}}</option>    
                                    @endforeach
                                </select>   
                            </div>
                        @endif
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
