@extends('layouts.app',['page' => __('Categories'), 'pageSlug' => 'add_categories'])

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container">
    <form id="categories-form" action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
    <div class="row">
        <div class="col-md-12 col-sm-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Create Category</h3>
            </div>
            <div class="card-body">
            <div class="row">
            <div class="col-md-12 col-sm-4">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="category name" required>
                </div>
            </div>

            <div class="col-md-12 col-sm-4">
                <label for="picture">Picture</label>
                <div class="form-control">
                    <input type="file" id="picture" name="picture" placeholder="Upload File" required>
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
            <!-- <a href="#" class="btn btn-secondary">Cancel</a> -->
            <input type="submit" value="Create new Category" class="btn btn-success float-right">
            </div>
        </div>
    </form>
    </div>
    </section>
    <!-- /.content -->
@endsection
