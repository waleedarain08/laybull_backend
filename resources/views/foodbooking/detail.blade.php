@extends('layouts.app', ['page' => __('Food Order Details'), 'pageSlug' => 'foodbooking'])
<style>
.smallDiv{
    margin-right: 8%;
    width: 40% !important;
    min-height: 40% !important;
}
.white{
    color:white;
}
</style>
@section('content')
        <div class="row">
            <div class="col-lg-12">
            <div class="row">
            <div class="col-lg-6">
            <div class="card ">
                    <div class="card-header">
                        <h4 class="card-title">Booking Detail</h4>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive">
                            <table class="table table-bordered">
                                <span class="white">Booking ID: <b>{{$records->id}}</b></span><br><hr>
                                <span class="white">Date: <b>{{$records->created_at}}</b></span><br><hr>
                                <span class="white">Total Price: <b>{{$records->total_price}}</b></span><br><hr>
                                <select class="form-control selectpicker">
                                    <option value="pending" {{ $records->status =='pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="accepted" {{ $records->status =='accepted' ? 'selected' : '' }}>Accepted</option>
                                    <option value="rejected" {{ $records->status =='rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
            <div class="card ">
                    <div class="card-header">
                        <h4 class="card-title">Customer Detail</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <span class="white">Customer_ID: {{$records->user->id}}</span><br><hr>  
                                <span class="white">Name: {{$records->user->name}}</span><br><hr>
                                <span class="white">Email: {{$records->user->email}}</span><br><hr>
                                <span class="white">Date: {{$records->user->created_at}}</span><br><hr>
                                <span class="white">Instruction: {{$records->instruction}}</span><br><hr>
                                <select class="form-control selectpicker">
                                    <option value="active" {{ $records->user->status =='1' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $records->user->status =='0' ? 'selected' : '' }}>InActive</option>
                                    <!-- <option value="rejected" {{ $records->status =='rejected' ? 'selected' : '' }}>Rejected</option> -->
                                </select>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="title">{{ __('Food Booking Details ') }}</h5>
                        <!-- <a href="{{route('foodcategory.create')}}" class="btn btn-info btn-sm pull-right">Add Food Categroy</a> -->
                    </div>
                    <div class="table-reponsive">
                        <table class="table tablesorter" id="">
                            <thead class="text-primary">
                            <tr>
                            <th>Food_Booking_ID</th>
                            <th>Quantity</th>
                            <th>Food Name</th>
                            <th>Vendor_ID</th>
                            <th>Vendor_Name</th>
                            <th>Price</th>
                            <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                       @foreach($recordsdetails as $record)
                       <tr>
                       <td>{{$record->id}}</td>
                       <td>{{$record->quantity}}</td>
                       <td>{{$record->food->name}}</td>
                       <td>{{$record->vendor->id}}</td>
                       <td>{{$record->vendor->name}}</td>
                       <td>{{$record->price}}</td>
                       <td>{{$record->total_price}}</td>
                       </tr>
                       @endforeach
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
