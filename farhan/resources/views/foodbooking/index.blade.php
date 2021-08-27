@extends('layouts.app', ['page' => __('Food Booking Details'), 'pageSlug' => 'foodbooking'])
@section('content')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="title">{{ __('Food Booking Details ') }}</h5>
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
                            <form id="submitForm-{{$record->id}}" method="post" action="{{route('status')}}">
                            @csrf()
                                <td>{{$key+1}}</td>
                                <td>{{$record->id}}
                                    <input type="hidden" value="{{$record->id}}" name="id"/>
                                </td> 
                                <td>
                                    <!-- <input type="hidden" name="statusId" value="{{$record->id}}"/> -->
                                    <select class="form-control selectpicker" name="status" onchange="myFunction({{$record->id}})">
                                        <option value="pending" {{ $record->status =='pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="vendor_accepted" {{ $record->status =='vendor_accepted' ? 'selected' : '' }}>Vendor Accepted</option>
                                        <option value="rejected" {{ $record->status =='rejected' ? 'selected' : '' }}>Rejected</option>
                                        <option value="accepted" {{ $record->status =='accepted' ? 'selected' : '' }}>Rider Accepted</option>
                                        <option value="completed" {{ $record->status =='completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                
                                </td>
                                <td>{{$record->details[0]->vendor_id}}
                                <!-- <input type="hidden" value="{{$record->details[0]->vendor_id}}" name="vendorId"/> -->
                                </td>
                                <td>{{$record->details[0]->vendor->name}}</td>
                                <td>{{$record->user_id}}
                                <!-- <input type="hidden" value="{{$record->user_id}}" name="userId"/> -->
                                </td>
                                <td>{{$record->user->name}}
                                <!-- <input type="hidden" value="{{$record->user->name}}" name="username"/> -->
                                
                                </td>
                                <td>{{$record->total_price}}</td>
                                <td><a href="{{route('foodbooking.show',['foodbooking' => $record->id])}}">Order</a></td>
                            </form>   
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
<script type="text/javascript">
    function myFunction(id)
    {
        document.getElementById("submitForm-"+id).submit();
    }


</script>
@endsection
