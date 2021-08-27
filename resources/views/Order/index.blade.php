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
                    <table class="table table-striped projects data-table" style="">
                        <thead>
                        <tr>
                            @foreach($display as $disp)
                                <th class="{{ $disp == 'Action' ? 'text-center' : '' }}">
                                    {{$disp}}
                                </th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($records as $key=>$record)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{ $record->product->user->name }}</td>
                                <td>{{ $record->user->name}}</td>
                                <td>{{ $record->product->name }}</td>
                                <td>{{ $record->total_amount}}</td>
                            
                                <td>

                                    <a class="btn btn-info btn-sm float-left mr-1" href="orders/{{ $record->id }}/detail">
                                        View Order Detail
                                        
                                    </a>
                                    @if($record->is_confirm==0)
                                   <a class="btn btn-success btn-sm float-left mr-1" href="orders/{{ $record->id }}/dispatch">
                                        Dispatch
                                        
                                    </a>
                                    @endif
                                  
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-center w-100">{{$records->links()}}</div>

            </div>
    </section>
    
@endsection


@section('script')

     
@endsection
