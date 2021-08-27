@extends('layouts.app', ['page' => __('Add Grocery Category'), 'pageSlug' => 'grocerycategory'])
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ __('Insert Food Category') }}</h5>
                </div>
                <form method="post" action="{{ route('grocerycategory.store') }}" >
                    <div class="card-body">
                        @csrf
                        @include('alerts.success')
                    <div class="form-group">
                        <label>Grocery Catgory</label>
                        <input type="text" name="name" class="form-control" placeholder="Grocery Catgory" required >
                    </div>
                    @if(auth()->user()->role == 'admin')
                            <div class="form-group">
                                <label>Vendor</label>
                              <select name="vendor" class="form-control">
                                    <option value="" class="bg-danger">Select Vendor</option> 
                                    @foreach($records as $record)
                                        @if(!is_null($record->modules))
                                        <option value="{{$record->id}}">{{$record->name}}</option>
                                        @endif
                                    @endforeach
                                </select>   
                            </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-primary">{{ __('Insert') }}</button>
                    </div>
                </form>
            </div>
         </div>
    </div>
@endsection
