@extends('layouts.app',['page' => __('Product List'), 'pageSlug' => 'products'])
@section('content')
<section class="content">
<div class="container">
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h3 class="card-title">Products</h3>
            </div>
            <div class="col-md-6">
                <a href="{{ route('products.create') }}" class="nav-link pull-right">
                    <button class="btn btn-primary form-control text-capitalize">Add Product</button>
                </a>
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
                    <td style="width: 18.6%">{{$record->name}}</td>
                    <td>
                        <img src="{{ asset($record->feature_image ? 'uploads/productImages/'.$record->feature_image : 'Images/noImage.png') }}" alt="" width="100" height="100">
                    </td>
                    <td>{{ $record->category()->pluck('name')->implode('name') }}</td>
                    <td>{{ $record->user()->pluck('name')->implode('name') }}</td>
                    <td>{{ $record->price }}</td>
                    <td>
                        @if ($record->popular == 0)
                            NO
                        @else
                            YES
                        @endif
                    </td>
                    <td>{!! $record->status ? '<span class="text-success">Approved</span>' : 'In-Review' !!}</td>
                    <td>
                        <a class="btn btn-primary btn-sm float-left mr-1" href="products/{{ $record->id }}">
                                <i class="fas fa-eye">
                                    </i>
                        </a>
                        <a class="btn btn-info btn-sm float-left mr-1" href="products/{{ $record->id }}/edit">
                                <i class="fas fa-pencil-alt">
                                    </i>
                        </a>
                        <form method="post" action="{{ route('products.destroy',$record->id)  }}" class="">
                            {{ csrf_field() }}
                            {{ method_field("DELETE") }}
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt">
                                </i></button>
                        </form>

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
