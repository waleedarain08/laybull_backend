@extends('layouts.app',['page' => __('Brands'), 'pageSlug' => 'brands.edit'])
@section('sideheading')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add Brand</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Brand</a></li>
                            <li class="breadcrumb-item active">Edit Brand</li>
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
                    <div class="col-sm-12">
                    @if (Session::has('errors'))
                        <!-- <div class="alert alert-success"> -->
                            <p class="alert alert-danger">{{Session::get('errors') }}</p>
                            <!-- </div> -->
                        @endif
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
    @endsection
    @section('content')
        <!-- Main content -->
            <section class="content">
                <div class="container">
                    <form id="brand-form" action="{{ route('brands.update',$brand->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Edit Brand</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-4">
                                                <div class="form-group">
                                                    <label for="name">Name</label>
                                                    <input type="text" id="name" name="name" class="form-control"
                                                           placeholder="i.e Khadi" value="{{ $brand->name }}">
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-sm-4">
                                                <div class="form-group">
                                                    <label for="picture">Picture</label>
                                                    <input type="file" id="picture" name="picture" class="form-control" >
                                                    <img src="{{ asset($brand->picture ? 'uploads/brandImages/'.$brand->picture: 'images/noImage.png') }}" alt="" width="335" height="200">
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-sm-6">
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea type="text" id="description" name="description" class="form-control"
                                                              placeholder="i.e clothes brand" rows="5"  cols="5" required>{{$brand->description}}</textarea>
                                                </div>
                                            </div>

                                        </div><!-- /.row ends here -->

                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <a href="{{route('brands.index')}}" class="btn btn-secondary">Cancel</a>
                                <input type="submit" value="Update Brand" class="btn btn-success float-right">
                            </div>
                        </div>
                    </form>
                </div>
            </section>
            <!-- /.content -->
@endsection
