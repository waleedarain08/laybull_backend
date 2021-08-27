@extends('layouts.app', ['page' => __('Edit User'), 'pageSlug' => 'reset'])
@section('content')
@push('css')
<link href="{{asset('assets/scripts/css/select2.min.css')}}" rel="stylesheet" />
<style>
.select2-search--dropdown{
    background-color: #000;
    border: solid black 1px;
    outline: 0;
    width: 200px;
}
.select2-search__field{
    background-color: #000;
    border: solid black 1px;
    outline: 0;
    width: 200px;
}
.select2-results {
    background-color: #000;
    border: solid black 1px;
    outline: 0;
    width: 200px;

}
.select2-selection--multiple{
    background-color: #000;
    border: solid black 1px;
    outline: 0;
    width: 200px;
}
.select2-container--default.select2-container--focus .select2-selection--multiple {
    border: solid black 1px;
    outline: 0;
    width: 200px;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice__display {
    cursor: default;
    padding-left: 2px;
    padding-right: 5px;
    background-color: black;
}
</style>
@endpush
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h5 class="title">{{__("Edit Users")}}</h5>
          </div>
          <div class="card-body">
            <form method="post" action="{{ route('user.update',['user'=>$record->id]) }}" autocomplete="off"
            enctype="multipart/form-data">
              @csrf
              @include('alerts.success')
              @method('put')
              <div class="row">
              </div>
                <div class="row">
                    <div class="col-md-4 ">
                        <div class="form-group">
                            <label>{{__("Name")}}</label>
                            <input type="text" name="name" class="form-control" placeholder="Name" value="{{$record->name}}" >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <label for="exampleInputEmail1">{{__(" Email address")}}</label>
                        <input type="email"  class="form-control" placeholder="Email" value="{{$record->email}}"  readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                    <div class="form-group {{ $errors->has('password') ? ' has-danger' : '' }}">
                        <label>{{__(" password")}}</label>
                        <input class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('New Password') }}" type="password" name="password">
                    </div>
                  </div>
                </div>
                @if($record->role=='vendor')
                <div class="row">
                  <div class="col-md-4">
                        <div class="form-group">
                            <label>{{__("Address")}}</label>
                            <input type="text"  class="form-control" placeholder="Address" value="{{$record->location->address}}" name="address" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{__("Phone")}}</label>
                            <input type="number"  class="form-control" placeholder="Phone" value="{{$record->detail->phone}}" name="phone">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{__("Account Number")}}</label>
                            <input type="number" class="form-control" placeholder="Account Number" value="{{$record->bankaccount ? $record->bankaccount->account_number : ''}}" name="account_number" step="any" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                        <div class="form-group">
                            <label>{{__("Latitude")}}</label>
                            <input type="number" class="form-control" placeholder="Latitude" value="{{ $record->location->latitude }}" name="latitude" step="any" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{__("Longitude")}}</label>
                            <input type="number" class="form-control" placeholder="Longitude" value="{{ $record->location->longitude }}" name="longitude" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <label>{{__("Service Tax")}}</label>
                        <input type="number" name="tax" class="form-control" placeholder="Service Tax" step="any" value="{{ $record->detail->service_tax }}" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                        <label>{{__("Delivery Fees")}}</label>
                        <input type="number" name="fees" class="form-control" placeholder="Delivery Fees" step="any" value="{{ $record->detail->delivery_fees }}" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{__("Modules")}}</label><br>
                            <select class="modules" name="modules[]" class="form-control bg-dark" multiple required>
                                @foreach(config('constants.modules') as $key=>$module)
                                    <option value="{{$key}}" {{in_array($key, explode(',', $record->modules)) ? 'selected' : ''}}>{{$module}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{__("Currency")}}</label><br>
                           <input type="text" value="{{$record->currency}}" name="currency" class="form-control" placeholder="currency">
                        </div>
                    </div>
                     <div class="col-md-4">
                        <div class="form-group">
                            <label>{{__("TakeAway Tax")}}</label>
                            <input type="number" name="takeaway" value="{{$record->detail->takeaway_tax}}" class="form-control" placeholder="TakeAway Tax" >
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <img src="{{$record->detail->image}}" height="150px" width="150px">
                        </div>
                    <span>Choose file</span>
                        <input type="file" name="photo">
                    </div>
                </div>
                @endif
                <div class="text-center">
                   <button type="submit" class="btn btn-primary ">{{__('Update')}}</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@push('js')
<script src="{{asset('assets/scripts/js/select2.min.js')}}"></script>
<script>
  $(document).ready(function() {
      $('.modules').select2();
  });
</script>
@endpush

