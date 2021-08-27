@extends('layouts.app',['page' => __('Categories'), 'pageSlug' => 'categories'])
@section('sideheading')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Categories</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Categories</li>
                </ol>
            </div>
            </div>
            <div class="row mb-2">
            <div class="col-sm-12">
                @if (Session::has('success'))
                <!-- <div class="alert alert-success"> -->
                    <p class="alert alert-success">{{Session::get('success') }}</p>
                <!-- </div> -->
                @endif
            </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
</div>
@endsection
@section('content')
<!-- Main content -->
<section class="content">
<div class="container">
<!-- Default box -->
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h3 class="card-title">Categories</h3>

            </div>
            <div class="col-md-6">
                <a href="{{ route('categories.create') }}" class="nav-link pull-right">
                    <button class="btn btn-primary form-control text-capitalize">Add Category</button>
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
                @foreach($records as $key=>$record)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$record->name}}</td>
                    <td>
                        <img src="{{ asset($record->picture ? 'uploads/categoryImages/'.$record->picture : 'Images/noImage.png') }}" alt="" width="100" height="100">
                    </td>
                    <td >{{$record->created_at}}</td>
                    <td colspan="2"><a href="categories/{{ $record->id }}/edit" class="btn btn-info btn-sm float-left">Edit</a>
                        <form method="post" action="{{ route('categories.destroy',$record->id)  }}">
                            {{ csrf_field() }}
                                {{ method_field("DELETE") }}
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

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
{{--        ajax: "{{ route('categories.index') }}",--}}
{{--        columns: [--}}
{{--            {data: 'DT_RowIndex', name: 'DT_RowIndex'},--}}
{{--            {data: 'name', name: 'name'},--}}
{{--            {data: 'picture', name: 'picture'},--}}
{{--            {data: 'parent', name: 'parent'},--}}
{{--            {data: 'top_menu', name: 'top_menu'},--}}
{{--            {data: 'easy_commission', name: 'easy_commission'},--}}
{{--            {data: 'action', name: 'action', orderable: false, searchable: false},--}}
{{--        ]--}}
{{--    });--}}
{{--  });--}}
{{--</script>--}}
@endsection
