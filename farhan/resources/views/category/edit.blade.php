@extends('layouts.app',['page' => __('Categories'), 'pageSlug' => 'categories.edit'])
{{-- @section('sideheading')
     <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Category</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Categories</a></li>
              <li class="breadcrumb-item active">Edit Categories</li>
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
@endsection --}}
@section('content')
<!-- Main content -->
<section class="content">
    <div class="container">
    <form id="categories-form" action="{{ route('categories.update',$category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
    <input name="_method" type="hidden" value="PUT">
    <div class="row">
        <div class="col-md-12 col-sm-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Category</h3>
                <div class="card-tools">
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-sm-4">
                        <div class="form-group">
                            <h4 for="name">Name</h4>
                            <input type="text" id="name" name="name" class="form-control" value="{{$category->name}}">
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-4">
                        <div class="form-group">
                        <h4 for="picture">Picture</h4>
                            <input type="file" id="picture" name="picture" class="form-control" >
                            <img src="{{ asset($category->picture ? 'uploads/categoryImages/'.$category->picture : 'Images/noImage.png') }}" alt="" width="100" height="100">
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-4">
                        <div class="form-group">
                        <label for="easy_commission">Easy Commission %</label>
                        <input type="number" id="easy_commission" name="easy_commission" class="form-control" value="{{$category->easy_commission}}">
                        </div>
                    </div>

            <div class="col-md-12 col-sm-4">
                <div class="form-group">
                    <label for="parent">Parent Category</label>
                    <select id="parent" name="parent" class="form-control custom-select">
                    @if($category->parent =="0")
                        <option value="0" style="color:orange !important;background:green;">none</option>
                    @endif
                    @foreach($cats as $cat)
                        @if($category->cat == $cat->id)
                            <option class="warning" value="{{$cat->id}}" style="color:orange !important;background:green;">{{$cat->name}}</option>
                        @endif
                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                    @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-12 col-sm-4">
                <div class="form-group">
                    <label for="top_menu">Top Menu</label>
                    <select id="top_menu" name="top_menu" class="form-control custom-select">
                        {{-- <option selected disabled>Select one</option> --}}
                        @if($category->top_menu)
                            <option value="{{ $category->top_menu }}" style="color:orange !important;background:green;">{{ $category->top_menu }}</option>
                        @endif
                        <option value="0">0</option>
                        <option value="1">1</option>
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
          <a href="{{route('categories.index')}}" class="btn btn-secondary">Cancel</a>
          <input type="submit" value="Update Product" class="btn btn-success float-right">
        </div>
      </div>
      </form>
      </div>
    </section>
    <!-- /.content -->
@endsection
