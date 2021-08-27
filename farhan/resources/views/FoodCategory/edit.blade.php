@extends('layouts.app', ['page' => __('Edit Food Category'), 'pageSlug' => 'foodcategory'])
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ __('Edit Food Category') }}</h5>
                </div>
                <form method="post" action="{{route('foodcategory.update',$record->id)}}">
                    <div class="card-body">
                         @csrf
                         @method('put')
                         @include('alerts.success')
                        <div class="form-group">
                            <label>Food Catgory</label>
                            <input type="text" name="name" class="form-control" value="{{$record->name}}" placeholder="Food Catgory" required >
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
