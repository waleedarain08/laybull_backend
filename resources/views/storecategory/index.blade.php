@extends('layouts.app', ['page' => __('Store Category'), 'pageSlug' => 'storecategory'])
@section('content')
        <div class="row">
            <div class="col-md-12">
            @include('alert2.message')
                <div class="card">
                    <div class="card-header">
                        <h5 class="title">{{ __('Store Category') }}</h5>
                        <a href="{{route('storecategory.create')}}" class="btn btn-info btn-sm pull-right">Add Store Categroy</a>
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
                        @foreach($records as $key=>$category)
                            <tr>
                            <td>{{$key+1}}</td>    
                            <td>{{$category->name}}</td>
                            @if(auth()->user()->role == 'admin')
                            <td>{{$category->vendor_id}}</td>
                            <td>{{$category->user->name}}</td>
                            @endif
                            <td>{{$category->created_at}}</td>
                            <td><a href="{{route('storecategory.edit',$category->id)}}" class="btn btn-info btn-sm">Edit</a></td>
                            <td>
                            <form method="post" action="{{route('storecategory.destroy',$category->id)}}">
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
