@extends('layouts.app', ['page' => __('Grocery Category'), 'pageSlug' => 'grocerycategory'])
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                @include('alert2.message')
                <div class="card-header">
                    <h5 class="title">{{ __('Grocery Category') }}</h5>
                    <a href="{{route('grocerycategory.create')}}" class="btn btn-info btn-sm pull-right">Add Grocery Categroy</a>
                </div>
                <div class="table-reponsive">
                    <table class="table tablesorter" id="">
                        <thead class="text-primary">
                        <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Created_at</th>
                        @if(auth()->user()->role == 'admin')
                        <th>Vendor_ID</th>
                        <th>Vendor_Name</th>
                        @endif
                        <th>Edit</th>
                        <th>Delete</th>
                        </tr>
                        </thead>
                         @foreach($records as $key=>$category)
                            <tr>
                            <td>{{$key+1}}</td>    
                            <td>{{$category->name}}</td>
                            <td>{{$category->created_at}}</td>
                            @if(auth()->user()->role == 'admin')
                            <td>{{$category->vendor_id}}</td>
                            <td>{{$category->user->name}}</td>
                            @endif
                            <td><a href="{{route('grocerycategory.edit',$category->id)}}" class="btn btn-info btn-sm">Edit</a></td>
                            <td>
                            <form method="post" action="{{route('grocerycategory.destroy',$category->id)}}">
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
