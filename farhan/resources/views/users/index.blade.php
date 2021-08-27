@extends('layouts.app', ['page' => __('Vendors List'), 'pageSlug' => 'users'])
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
            <div class="col-md-12">
                <div class="card">
                    @include('alert2.message')
                    <div class="card-header p-4 mt-3">
                        <h5 class="title">{{ __('Vendors List ') }}</h5>
                        <a href="{{route('user.create')}}" class="btn btn-info btn-sm pull-right">Add User</a>
                    </div>
                    <div class="table-reponsive p-4">
                        <table class="table tablesorter" id="">
                            <thead class="text-primary">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Created_at</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        @foreach($records as $key=>$record)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$record->name}}</td>
                                <td>{{$record->email}}</td>
                                <td>{{$record->created_at}}</td>
                                <td><a href="{{route('user.edit',['user'=>$record->id])}}" class="btn btn-info btn-sm">Edit</a>
                                    @if($record->status != 0)
                                    <a href="{{route('user.block',$record->id)}}" class="btn btn-danger btn-sm">Block</a>
                                    @else
                                        <a href="{{route('user.block',$record->id)}}" class="btn btn-success btn-sm">Unblock</a>
                                    @endif

                                </td>
{{--                                <td>--}}
{{--                                    @if($record->status == 1)--}}
{{--                                    <a href="{{route('updateuserstatus',$record->id)}}" class="switch">--}}
{{--                                    <input type="checkbox" checked>--}}
{{--                                    <span class="slider round"></span>--}}
{{--                                    </a>--}}
{{--                                    @else--}}
{{--                                    <a href="{{route('updateuserstatus',$record->id)}}" class="switch">--}}
{{--                                    <input type="checkbox" >--}}
{{--                                    <span class="slider round"></span>--}}
{{--                                    </a>--}}
{{--                                    @endif--}}
{{--                                </td>--}}
                            </tr>
                        @endforeach
                    </table>
                    {{$records->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection
