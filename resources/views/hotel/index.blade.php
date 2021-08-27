@extends('layouts.app', ['page' => __('Hotel'), 'pageSlug' => 'hotel'])
<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}
.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}
.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}
input:checked + .slider {
  background-color: #2196F3;
}
input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}
input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}
/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}
.slider.round:before {
  border-radius: 50%;
}
</style>
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
               @include('alert2.message')
                <div class="card-header">
                    <h5 class="title">{{ __('Hotel') }}</h5>
                    <a href="{{route('hotel.create')}}" class="btn btn-info btn-sm pull-right">Add Hotel</a>
                </div>
                <div class="table-reponsive">
                    <table class="table tablesorter " id="">
                        <thead class="text-primary ">
                        <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Price</th>
                        <th>Address</th>
                        <th>Created_at</th>
                        <th>Image</th>
                        <th>Status</th>
                        @if(auth()->user()->role == 'admin')
                        <th>Vendor_ID</th>
                        <th>Vendor_Name</th>
                        @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($record as $key=>$records) 
                        <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$records->name}}</td>
                        <td>{{$records->email}}</td>
                        <td>{{$records->phone}}</td>
                        <td>{{$records->price}}</td>
                        <td>{{$records->address}}</td>
                       <td>{{$records->created_at}}</td>
                        <td><img src="{{$records->image}}" alt="{{$records->name}}" srcset="" style="height:50px; width:100px;"></td>
                        <td>
                        @if($records->status==1)
                        <a href="{{route('hotelstatusupdate',$records->id)}}" class="switch">
                        <input type="checkbox" checked>
                        <span class="slider round"></span>
                        </a>
                        @else
                        <a href="{{route('hotelstatusupdate',$records->id)}}" class="switch">
                        <input type="checkbox" >
                        <span class="slider round"></span>
                        </a>
                        @endif
                        </td>
                        @if(auth()->user()->role == 'admin')
                        <td>{{$records->vendor_id}}</td>
                        <td>{{$records->user->name}}</td>
                        @endif
                        </tr>
                      @endforeach
                      </tbody>
                   </table>
                   <div style="margin-left:30px">
                    {{$record->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
