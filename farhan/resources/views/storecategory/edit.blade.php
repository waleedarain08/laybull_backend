@extends('layouts.app', ['page' => __('Edit Store Category'), 'pageSlug' => 'storecategory'])
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ __('Edit Store Category') }}</h5>
                </div>
                <form method="post" action="{{ route('storecategory.update',$record->id) }}" >
                    <div class="card-body">
                         @csrf
                         @include('alerts.success')
                         @method('put')
                        <div class="form-group">
                            <label>Store Catgory</label>
                            <input type="text" name="name" class="form-control" value="{{$record->name}}" placeholder="Store Catgory" required >
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
