@extends('layouts.app', ['page' => __(' Car Review'), 'pageSlug' => 'carreviews'])
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card ">
               @include('alert2.message')
                <div class="card-header">
                    <h5 class="title">{{ __('Show Room Review') }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-reponsive">
                        <table class="table tablesorter" id="">
                            <thead class="text-primary">
                                <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Reviews</th>
                                <th>Rating</th>
                                @if(auth()->user()->role == 'admin')
                                <th>Vendor_Id</th>
                                <th>Vendor_Name</th>
                                @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($records as $key=>$record) 
                                <tr>
                                    <td>{{$record->name}}</td>
                                    <td>{{$record->description}}</td>
                                    <td>{{$record->review}}</td>
                                    <td>
                                    @for($i=0; $i<$record->rating; $i++)
                                    <i class="fas fa-star"></i>
                                    @endfor
                                    </td>
                                    @if(auth()->user()->role == 'admin')
                                    <td>{{$record->vendor_id}}</td>
                                    <td>{{$record->user->name}}</td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div style="margin-left:30px">
                        {{$records->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
