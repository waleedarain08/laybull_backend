@extends('layouts.app', ['page' => __('Food Reservation'), 'pageSlug' => 'foodreservation'])
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
               <div class="card-header">
                    <h5 class="title">{{ __('Food Reservation') }}</h5>
                    <a href="{{route('reservation.create')}}" class="btn btn-info btn-sm pull-right">Add Food Reservation</a>
                </div>
                <div class="table-reponsive">
                    <table class="table tablesorter" id="">
                        <thead class="text-primary">
                        <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Time</th>
                        <th>No Of Person</th>
                        <th>Price</th>
                        @if(auth()->user()->role == 'admin')
                        <th>Vendor id</th>
                        <th>Vendor Name</th>
                        @endif
                        </tr>
                        </thead>
                        <tbody>
                       @foreach($records as $key=> $record)
                       <tr>
                       <td>{{$key+1}}</td>
                        <td>{{$record->name}}</td>
                        <!-- <td>{{$record->created_at}}</td> -->
                        <td>{{$record->time}}</td>
                        <td>{{$record->price}}</td>
                        <td>{{$record->person}}</td>
                        @if(auth()->user()->role=='admin')
                        <td>{{$record->vendor_id}}</td>
                        <td>{{$record->vendor->name}}</td>
                        @endif
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
