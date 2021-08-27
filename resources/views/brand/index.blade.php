@extends('layouts.app',['page' => __('Brands'), 'pageSlug' => 'brands'])
@section('content')
<!-- Main content -->
<section class="content">
    <div class="container">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="card-title">Brands</h3>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('brands.create') }}" class="nav-link pull-right">
                            <button class="btn btn-primary form-control text-capitalize">Add Brand</button>
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body p-0" style="padding:5px !important;">
                @include('alert2.message')
                <table class="table table-striped projects data-table">
                    <thead>
                        <tr>
                        @foreach($display as $disp)
                            <th style="">
                                {{$disp}}
                            </th>
                        @endforeach
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($records as $key=>$record)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$record->name}}</td>
                            <td><img src="{{ asset($record->picture ? 'uploads/brandImages/'.$record->picture: 'images/noImage.png') }}" alt="" width="100" height="100"></td>
                            <td >{{$record->description}}</td>
                            <td >{{$record->created_at}}</td>
                            <td colspan="2"><a href="brands/{{ $record->id }}/edit" class="btn btn-info btn-sm float-left">Edit</a>
                                <form method="post" action="{{ route('brands.destroy',$record->id)  }}">
                                    {{ csrf_field() }}
                                    {{ method_field("DELETE") }}
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                            <td>
                                @if($record->status == 1)
                                    <a href="{{route('category.edit',$record->id)}}" class="switch">
                                        <input type="checkbox" checked>
                                        <span class="slider round"></span>
                                    </a>
                                @else
                                    <a href="" class="switch">
                                        <input type="checkbox" >
                                        <span class="slider round"></span>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        <!-- /.card-body -->
        </div>
        {{$records->links()}}
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection


@section('script')
{{--<script type="text/javascript">--}}
{{--  $(function () {--}}
{{--    var table = $('.data-table').DataTable({--}}
{{--        processing: true,--}}
{{--        serverSide: true,--}}
{{--        ajax: "{{ route('brands.index') }}",--}}
{{--        columns: [--}}
{{--            {data: 'DT_RowIndex', name: 'DT_RowIndex'},--}}
{{--            {data: 'name', name: 'name'},--}}
{{--            {data: 'picture', name: 'picture'},--}}
{{--            {data: 'description', name: 'description'},--}}
{{--            {data: 'icon', name: 'icon'},--}}
{{--            {data: 'action', name: 'action', orderable: false, searchable: false},--}}
{{--        ]--}}
{{--    });--}}
{{--  });--}}
{{--</script>--}}
@endsection
