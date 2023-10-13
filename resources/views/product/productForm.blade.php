@extends('layouts.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Product</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Product</li>
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
              <form action="{{ $url }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="form-group required">
                    <label for="name">Name*</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter product name" value="@if(old('name') != null) {{ old('name') }} @elseif (isset($product)){{ $product->product_name}} @endif" required>
                  </div>
                  <div class="form-group">
                    <label for="description">Description*</label>
                    <textarea id="description" name="description" class="form-control" required rows="4">@if(old('description') != null) {{ old('description') }} @elseif (isset($product)){{ $product->product_description }}@endif</textarea>
                  </div>
                  <div class="form-group">
                    <label for="price">Price*</label>
                    <input type="text" name="price" class="form-control" id="price" placeholder="Enter price" value="@if(old('price') != null) {{ old('price') }} @elseif (isset($product)){{$product->product_price}}@endif" required>
                  </div>
                  <div class="form-group">
                    <label for="file">Image*</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" name="file" class="custom-file-input" id="file" required>
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="category">Category*</label>
                    <select name="category" class="form-control" required>
                      <option value="">Please select</option>
                      @foreach ($category as $cat)
                      <option value="{{$cat->id_category}}" @if(old('category') != null) {{ old('category') }} @elseif (isset($product))@if ($product->id_category == $cat->id_category) selected @endif @endif>{{$cat->category_name}}</option>
                      @endforeach
                    </select>
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