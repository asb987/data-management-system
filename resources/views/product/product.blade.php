@extends('layouts.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<style>
  .pointer {
    cursor: pointer;
  }
  .hide {
    display: none;
  }
</style>
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
          <div class="row">
            <div class="col-12">
                @if ($msg = Session::get('success'))
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> {{$msg}}</h5>
                </div>
                @endif
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Product List</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <meta name="csrf-token" content="{{ csrf_token() }}">
                  @if (auth()->user()->is_admin == 3)
                    <input type="hidden" value="1" name="refresh">
                  @endif
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>#</th>
                      <th>Image</th>
                      <th>Name</th>
                      <th>Description</th>
                      <th>Price</th>
                      <th>Category</th>
                      @if (auth()->user()->is_admin == 1 || auth()->user()->is_admin == 3)
                      <th>Action</th>
                      @endif
                    </tr>
                    </thead>
                    <tbody>
                    @php $i = 1; @endphp
                    @foreach( $data as $value)
                    <tr>
                      <td>{{$i}}</td>
                      <td>
                        @if(file_exists('dist/img/' . $value->product_image))
                          <img src="{{asset('dist/img/' . $value->product_image)}}" width="150">
                        @else
                          No image found
                        @endif
                      </td>
                      <td>{{$value->product_name}}</td>
                      <td>{{$value->product_description}}</td>
                      <td>{{$value->product_price}}</td>
                      <td class="category_modal pointer" name="category_modal_{{$value->id_product}}" data-id="{{$value->id_product}}" data-id_category="{{$value->id_category}}" >{{$value->category_name}}</td>
                      @if (auth()->user()->is_admin == 1 || auth()->user()->is_admin == 3)
                      <td><div class="btn-group btn-group-sm">
                        <a href="{{url('updateproduct')}}/{{$value->id_product}}" class="btn btn-primary ml-1"><i class="fas fa-edit"></i></a>
                        @if ($value->deleted_at != '')
                        <a href="{{url('restoreproduct')}}/{{$value->id_product}}" class="btn btn-danger ml-1"><i class="fas fa-undo"></i></a>
                        @else
                        <button type="button" class="btn btn-danger ml-1 delete_product_{{$value->id_product}}" name="delete_product_{{$value->id_product}}" data-id="{{$value->id_product}}"><i class="fas fa-trash"></i></button>
                        {{-- <a href="{{url('deleteproduct')}}/{{$value->id_product}}" class="btn btn-danger ml-1"><i class="fas fa-trash"></i></a> --}}
                        <a href="{{url('restoreproduct')}}/{{$value->id_product}}" class="btn btn-danger ml-1 restore_product_{{$value->id_product}} hide"><i class="fas fa-undo"></i></a>
                        @endif
                      </div></td>
                      @endif
                    </tr>
                    @php $i = $i+1; @endphp
                    @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">View Product</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card-body">
            <div class="form-group required">
              <label for="name">Name:</label>
              <div id="modal_name"></div>
            </div>
            <div class="form-group">
              <label for="description">Description:</label>
              <p id="modal_desc"></p>
            </div>
            <div class="form-group">
              <label for="price">Price:</label>
              <div id="modal_price"></div>
            </div>
            <div class="form-group">
              <label for="file">Image:</label>
              <div class="">
                <div class="custom-file">
                  <div><img id="modal_img" src="" width="100"></div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="category">Category:</label>
              <div id="modal_category"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
@endsection