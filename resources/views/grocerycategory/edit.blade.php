@extends('layouts.app', ['page' => __('Edit Grocery Category'), 'pageSlug' => 'grocerycategory'])
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ __('Edit Grocery Category') }}</h5>
                </div>
                <form method="post" action="{{route('grocerycategory.update',$record->id)}}">
                    <div class="card-body">
                         @csrf
                         @method('put')
                         @include('alerts.success')
                        <div class="form-group">
                            <label>Grocery Catgory</label>
                            <input type="text" name="name" class="form-control" value="{{$record->name}}" placeholder="Grocery Catgory" required >
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-primary">{{ __('Edit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
