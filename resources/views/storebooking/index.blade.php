@extends('layouts.app', ['page' => __('Store Booking'), 'pageSlug' => 'storebooking'])
@section('content')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="title">{{ __('Store Booking') }}</h5>
                        <!-- <a href="{{route('foodcategory.create')}}" class="btn btn-info btn-sm pull-right">Add Food Categroy</a> -->
                    </div>
                    <div class="table-reponsive">
                        <table class="table tablesorter" id="">
                            <thead class="text-primary">
                            <tr>
                            <th>ID</th>
                            <th>Booking_ID</th>
                            <th>Status</th>
                            <th>Vendor_id</th>
                            <th>Vendor_Name</th>
                            <th>User_id</th>
                            <th>User_Name</th>
                            <th>Total Price</th>
                            <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($records as $key=>$record)
                            <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$record->id}}</td> 
                            <td>
                                <select class="form-control selectpicker">
                                    <option value="pending" {{ $record->status =='pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="accepted" {{ $record->status =='accepted' ? 'selected' : '' }}>Accepted</option>
                                    <option value="rejected" {{ $record->status =='rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </td>
                            <td>{{$record->details[0]->vendor_id}}</td>
                            <td>{{$record->details[0]->vendor->name}}</td>
                            <td>{{$record->user_id}}</td>
                            <td>{{$record->user->name}}</td>
                            <td>{{$record->total_price}}</td>
                            <td><a href="{{route('storebooking.show',['storebooking' => $record->id])}}">Order</a></td>
                            </tr>   
                            @endforeach
                        </tbody>
                    </table>
                    @if(count($records) < 1)
                    <div class="col-md-13 text-center pb-2" style="font-weight: 300; color: white;">
                        No records found
                    </div>
                    @endIf
                    {{$records->links()}}
                    
                </div>
            </div>
        </div>
    </div>
@endsection
