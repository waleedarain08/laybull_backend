@extends('layouts.app', ['page' => __('Hotel Review'), 'pageSlug' => 'hotelreview'])
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card ">
               @include('alert2.message')
                <div class="card-header">
                    <h5 class="title">{{ __('Hotel Reviews') }}</h5>
                    <!-- <a href="{{route('hotel.create')}}" class="btn btn-info btn-sm pull-right">Add Hotel</a> -->
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
                        <th>Vendor_ID</th>
                        <th>Vendor_Name</th>
                        @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($record as $key=>$records) 
                        <tr>
                        <td>{{$records->name}}</td>
                        <td>{{$records->description}}</td>
                        <td>{{$records->reviews}}</td>
                        <td>
                        @for($i=0; $i<$records->rating; $i++)    
                        <i class="fas fa-star"></i>
                        @endfor
                        </td>
                        @if(auth()->user()->role=='admin')
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
    </div>
@endsection
