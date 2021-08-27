@extends('layouts.app', ['page' => __('Add Vendor'), 'pageSlug' => 'users'])
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
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{__("Add Users")}}</h5>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        @include('alerts.success')
                    </div>
                </div>

                <div class="card-body">
                    <form method="post" action="{{ route('user.store') }}" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 ">
                                <div class="form-group">
                                    <label>{{__("Name")}}</label>
                                    <input type="text" name="name" class="form-control" placeholder="Name" required>
                                </div>
                            </div>
                            <div class="col-md-4 ">
                                <div class="form-group">
                                    <label>{{__("User Name")}}</label>
                                    <input type="text" name="user_name" class="form-control" autocomplete="off" placeholder="User Name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {{ $errors->has('password') ? ' has-danger' : '' }}">
                                    <label>{{__(" password")}}</label>
                                    <input class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" autocomplete="off" placeholder="{{ __('New Password') }}" type="password" name="password" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">{{__(" Email address")}}</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                                </div>
                            </div>
                            <!--fname Hidden Field-->
                            <input type="hidden" name="fname" class="form-control" placeholder="First Name">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{__("Mobile Number")}}</label>
                                    <input type="number" name="phone" class="form-control" placeholder="Phone" required>
                                </div>
                            </div>
                            <!--Lname Hidden Field-->
                            <input type="hidden" name="lname" class="form-control" placeholder="Last Name">
                            <div class="col-md-4 pr-1">
                                <div class="form-group">
                                    <label>{{__("Address")}}</label>
                                    <input type="text" name="address" class="form-control" placeholder="Address" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                <label>{{__("Role")}}</label>
                                <select class="form-control" name="role" class="form-control bg-dark" required>
                                    <option value="vendor">Vendor</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                <label>{{__("Status")}}</label>
                                <select class="form-control" name="status" class="form-control bg-dark" required>
                                    <option value="1">Active</option>
                                    <option value="0">InActive</option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="birthday" class="form-control" placeholder="D_O_B">
                            <div class="col-md-4">
                                <div class="form-group">
                                <label>{{__("Latitude")}}</label>
                                <input type="number" name="latitude" class="form-control" placeholder="Latitude" step="any" required>
                            </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                <label>{{__("Longitude")}}</label>
                                <input type="number"  name="longitude" class="form-control" placeholder="Longitude" step="any" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                <label>{{__("Service Tax")}}</label>
                                <input type="number" name="tax" class="form-control" placeholder="Service Tax" step="any" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                <label>{{__("Delivery Fees")}}</label>
                                <input type="number" name="fees" class="form-control" placeholder="Delivery Fees" step="any" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mt-4">
                                <div class="form-control">
                                    <input type="file" style="width:80%" name="photo">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{__("Account Number")}}</label>
                                    <input type="number" name="account_number" placeholder="Account Number" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{__("Currency")}}</label>
                                    <input type="text" name="currency" class="form-control" placeholder="Currency" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{__("TakeAway Tax")}}</label>
                                    <input type="number" name="takeaway" class="form-control" placeholder="TakeAway Tax" >
                                </div>
                            </div>
                            <br><br>
                            <div class="col-md-6" style="margin-top:20px">
                                <div class="form-group">
                                    <label class="mr-4">{{__("Modules")}}</label>
                                    <select class="modules" name="modules[]" class="form-control bg-dark" multiple required>
                                        @foreach(config('constants.modules') as $key=>$module)
                                            <option value="{{$key}}">{{$module}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="custom-control custom-checkbox mb-4">
                                    <input type="checkbox" name="reservation" class="custom-control-input" id="checkbox-1" checked>
                                    <label class="custom-control-label" for="checkbox-1">{{ __("Reservation") }}</label>
                                </div>
                            </div>
                        </div>
                    <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                    </div>
                    </form>
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

