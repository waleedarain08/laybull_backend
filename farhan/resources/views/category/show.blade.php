@extends('layouts.app')
@section('sideheading')
     <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Category Detail</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Categories</a></li>
              <li class="breadcrumb-item active">Category Detail</li>
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
@endsection
@section('content')
 <!-- Main content -->
 <section class="content">
     <div class="container">
      <div class="row">
        <div class="col-md-12 col-sm-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Category Detail</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
            <div class="row">
            <div class="col-md-12 col-sm-4">
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="form-control"
                value="{{$category->name}}" readonly>
              </div>
            </div>

            <div class="col-md-12 col-sm-4">
              <div class="form-group">
                <label for="picture">Picture</label>
                <img src="/admin/public/{{$category->picture}}" alt="" width="100" height="100">
              </div>
            </div>

            <div class="col-md-12 col-sm-4">
              <div class="form-group">
                <label for="easy_commission">Easy Commission</label>
                <input type="text" id="easy_commission" name="easy_commission" class="form-control"
                value="{{$category->easy_commission}}%" readonly>
              </div>
            </div>

            <div class="col-md-12 col-sm-4">
              <div class="form-group">
                <label for="parent">Parent Category</label>
                <select id="parent" name="parent" class="form-control custom-select">
                    @foreach($cats as $cat)
                        @if($category->parent == $cat->id)
                        <option  value="{{$category->parent}}" >{{$cat->name}}</option>
                        @endif
                    @endforeach
                </select>
              </div>
              </div>

              <div class="col-md-12 col-sm-4">
              <div class="form-group">
                <label for="top_menu">Top Menu</label>
                <select id="top_menu" name="top_menu" class="form-control custom-select">
                <option value="{{$category->top_menu}}" selected disable>{{$category->top_menu}}</option>
                </select>
              </div>
              </div>


            </div><!-- /.row ends -->


            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        </div>

      <div class="row">
        <div class="col-12">
          <a href="{{route('categories.index')}}" class="btn btn-secondary">Back</a>
        </div>
      </div>
      </div>
    </section>
    <!-- /.content -->
@endsection
