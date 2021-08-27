@extends('layouts.app',['page' => __(' Brands'), 'pageSlug' => 'brands.create'])
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
              <li class="breadcrumb-item active">Add Brand</li>
            </ol>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-sm-12">
            @if (Session::has('success'))
            <!-- <div class="alert alert-success"> -->
                <p class="alert alert-success">{{ Session::get('success') }}</p>
            <!-- </div> -->
            @endif
          </div>
          <div class="col-sm-12">
            @if (Session::has('errors'))
            <!-- <div class="alert alert-success"> -->
                <p class="alert alert-danger">{{ Session::get('errors') }}</p>
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
        <form id="brand-form" action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add Brand</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-4">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" id="name" name="name" class="form-control" placeholder="i.e Khadi" required>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-4">
                                    <label for="picture">Picture</label>
                                    <div class="form-control" >
                                        <input type="file" id="picture" name="picture" style="padding:2px;" required>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-4">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea type="text" id="description" name="description" class="form-control" placeholder="i.e clothes brand" rows="5" cols="5"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                <!-- <a href="#" class="btn btn-secondary">Cancel</a> -->
                <input type="submit" value="Create new Brand" class="btn btn-success float-right">
                </div>
            </div>
        </form>
    </div>
</section>
    <!-- /.content -->
@endsection
