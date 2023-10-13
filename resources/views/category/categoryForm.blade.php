@extends('layouts.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Category</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Category</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-12 col-6">
            <!-- small box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">{{$title}}</h3>
              </div>
              @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger alert-dismissible ml-2 mr-2 mt-2">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      <h5><i class="icon fas fa-ban"></i> {{$error}}</h5>
                    </div>
                @endforeach
              @endif
              @if ($msg = Session::get('success'))
              <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> {{$msg}}</h5>
              </div>
              @endif

              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ $url }}" method="post">
                @csrf
                <div class="card-body">
                  <div class="form-group required">
                    <label for="category_name">Category name*</label>
                    <input type="text" name="category_name" class="form-control" id="category_name" placeholder="Enter category name" value="@if (old('caegory_name') != null) {{old('caegory_name')}} @elseif (isset($category)){{ $category->category_name }}@endif" required>
                  </div>
                  <div class="form-group">
                    <label for="category_description">Category description*</label>
                    <textarea id="category_description" name="category_description" class="form-control" value="category_description" rows="4">@if (old('category_description')) {{old('category_description')}} @elseif (isset($category)){{ $category->category_description }}@endif</textarea>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection