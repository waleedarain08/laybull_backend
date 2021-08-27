@extends('layouts.app',['page' => __('Order List'), 'pageSlug' => 'orders'])
@section('content')
    <section class="content">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title">Order</h3>
                        </div>
                        <div class="col-md-6">
                          
                        </div>
                    </div>
                </div>

                <div class="card-body p-0" style="padding:5px !important;">
                    @include('alert2.message')
                   
                </div>

             <div class="container">
                <div class="row">
                    <div class="col-3">
                        <h1>Buyer Detail</h1>
                    </div>
                     <div class="col-6">
                        <h1>Product Detail</h1>
                    </div>
                    
                
                    <div class="col-3">
                        <h1>Seller Detail</h1>
                    </div>
                </div>
                  <div class="row">
                    <div class="col-3">
                         <p class="mb-1"><b>Buyer Name : {{$order->user->name}}</b></p>
                           <p class="mb-1"><b>Email : {{$order->email}}</b></p>
                            <p class="mb-1"><b>Phone : {{$order->phone}}</b></p>
                             <p class="mb-1"><b>City : {{$order->city}}</b></p>
                              <p class="mb-1"><b>Country : {{$order->country}}</b></p>
                               <p class="mb-1"><b>Address : {{$order->address_1}}</b></p>
                    </div>
                    
                    <div class="col-3">
                      <img src="{{ asset('uploads/productImages/'.$order->product->feature_image) }}" alt="job image" width="250px" height="150px" title="job image"></div>
                      <div class="col-3">
                         <p class="mb-1"><b> {{$order->product->name}}</b></p>
                           <p class="mb-1"><b>{{$order->total_amount}}</b></p>
                            <p class="mb-1"><b>{{$order->product->color}}</b></p>
                             <p class="mb-1"><b>{{$order->product->size}}</b></p>
                              <p class="mb-1"><b>{{$order->product->condition}}</b></p>
                              
                    </div>
                    <div class="col-3">
                          <p class="mb-1"><b>Seller Name : {{$order->product->user->name}}</b></p>
                           <p class="mb-1"><b>Email : {{$order->product->user->email}}</b></p>
                            <p class="mb-1"><b>Phone : {{$order->product->user->detail->phone}}</b></p>
                             <p class="mb-1"><b>City : {{$order->product->user->detail->city}}</b></p>
                              <p class="mb-1"><b>Country : {{$order->product->user->detail->country}}</b></p>
                               <p class="mb-1"><b>Address : {{$order->product->user->detail->address}}</b></p>
                    </div>
                </div>
                 
             </div>
            </div>
    </section>
    
@endsection


@section('script')

     
@endsection
