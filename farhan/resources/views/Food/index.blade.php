@extends('layouts.app', ['page' => __('Food Product'), 'pageSlug' => 'foodproduct'])
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
                    <h5 class="title">{{ __('Food Product') }}</h5>
                    <a href="{{route('food.create')}}" class="btn btn-info btn-sm pull-right">Add Food Product</a>
                </div>
                <div class="table-reponsive">
                    <table class="table tablesorter" id="">
                        <thead class="text-primary">
                        <tr>
                        <th>ID</th>
                        <th>Food Category Name</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Created_at</th>
                        <th>Image</th>
                        <th>Status</th>
                        @if(auth()->user()->role == 'admin')
                        <th>Vendor_id</th>
                        <th>Vendor_name</th>
                        @endif
                        <th>Edit</th>
                        <th>Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                       @foreach($records as $key=> $record)
                       <tr>
                       <td>{{$key+1}}</td>
                       <td>
                       @foreach($foodcategoryrecord->whereIn('id', explode(',',$record->food_category_id)) as $foodcate)    
                       {{$foodcate->name}}
                       @endforeach
                        </td>
                        <td>{{$record->name}}</td>
                        <td>{{$record->quantity}}</td>
                        <td>{{$record->price}}</td>
                        <td>{{$record->created_at}}</td>
                        <td><img src="{{$record->image}}" alt="{{$record->name}}" srcset="" style="height:50px; width:100px;"></td>
                        <td>
                        @if($record->status == 1)
                        <a href="{{route('updatefoodstatus',$record->id)}}" class="switch">
                        <input type="checkbox" checked>
                        <span class="slider round"></span>
                        </a>                        
                        @else
                        <a href="{{route('updatefoodstatus',$record->id)}}" class="switch">
                        <input type="checkbox" >
                        <span class="slider round"></span>
                        </a>                   
                        @endif
                        </td>
                        @if(auth()->user()->role=='admin')
                        <td>{{$record->vendor_id}}</td>
                        <td>{{$record->user->name}}</td>
                        @endif
                        <td><a href="{{route('food.edit',$record->id)}}" class="btn btn-info btn-sm">Edit</a></td>
                          <td >
                            <form method="post" action="{{route('food.destroy',$record->id)}}">
                                @csrf
                                @method('delete')
                                <button  type="submit" class="btn btn-info btn-sm mt-3">Delete</button>
                            </form>
                          </td>
                        </tr>
                       @endforeach
                      </tbody>
                    </table>
                    {{$records->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection
