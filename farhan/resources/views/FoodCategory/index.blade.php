@extends('layouts.app', ['page' => __('Food Category'), 'pageSlug' => 'foodcategory'])
@section('content')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                @include('alert2.message')
                    <div class="card-header">
                        <h5 class="title">{{ __('Food Category') }}</h5>
                        <a href="{{route('foodcategory.create')}}" class="btn btn-info btn-sm pull-right">Add Food Categroy</a>
                    </div>
                    <div class="table-reponsive">
                        <table class="table tablesorter" id="">
                            <thead class="text-primary">
                            <tr>
                            <th>ID</th>
                            <th>Name</th>
                            @if(auth()->user()->role == 'admin')
                            <th>Vendor_ID</th>
                            <th>Vendor_Name</th>
                            @endif
                            <th>Created_at</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            </tr>
                        </thead>
                        @foreach($records as $key=>$record)
                            <tr>
                            <td>{{$key+1}}</td>    
                            <td>{{$record->name}}</td>
                            @if(auth()->user()->role == 'admin')
                            <td>{{$record->vendor_id}}</td>
                            <td>{{$record->user->name}}</td>
                            @endif
                            <td>{{$record->created_at}}</td>
                            <td><a href="{{route('foodcategory.edit',$record->id)}}" class="btn btn-info btn-sm">Edit</a></td>
                            <td>
                            <form method="post" action="{{route('foodcategory.destroy',$record->id)}}">
                                @csrf
                                @method('delete')
                                <button  type="submit" class="btn btn-info btn-sm"> Delete </button>
                            </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    {{$records->links()}}
                </div>
             
            </div>
        </div>
    </div>
@endsection
