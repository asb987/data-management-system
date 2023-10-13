@extends('layouts.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <style>
    .hide {
      display: none;
    }
  </style>
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
                  <h3 class="card-title">Category List</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <meta name="csrf-token" content="{{ csrf_token() }}">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>#</th>
                      <th>Category name</th>
                      <th>Category description</th>
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
                      <td>{{$value->category_name}}</td>
                      <td>{{$value->category_description}}</td>
                      <td><div class="btn-group btn-group-sm">
                        @if (auth()->user()->is_admin == 1)@endif
                        @if (auth()->user()->is_admin == 1 || auth()->user()->is_admin == 3)
                        {{-- <a href="#" class="btn btn-info"><i class="fas fa-eye"></i></a> --}}
                        <a href="{{url('updatecategory')}}/{{$value->id_category}}" class="btn btn-primary ml-1"><i class="fas fa-edit"></i></a>
                        @if ($value->deleted_at != '')
                        <a href="{{url('restoreCategory')}}/{{$value->id_category}}" class="btn btn-danger ml-1"><i class="fas fa-undo"></i></a>
                        @else
                        <button type="button" class="btn btn-danger ml-1 delete_category_{{$value->id_category}}" name="delete_category_{{$value->id_category}}" data-id="{{$value->id_category}}"><i class="fas fa-trash"></i></button>
                        <a href="{{url('restoreCategory')}}/{{$value->id_category}}" class="btn btn-danger restore_{{$value->id_category}} ml-1 hide"><i class="fas fa-undo"></i></a>
                        {{-- <a href="{{url('deleteUser')}}/{{$value->id_category}}" class="btn btn-danger ml-1"><i class="fas fa-trash"></i></a> --}}
                        @endif
                        @endif
                        <a href="#" name="category_view_modal_{{$value->id_category}}" data-id_category="{{$value->id_category}}" class="btn btn-warning ml-1"><i class="fas fa-eye"></i></a>
                      </div></td>
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
          <h4 class="modal-title">View Category</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card-body">
            <div class="form-group required">
              <label for="modal_categroy_name">Category name:</label>
              <div id="modal_categroy_name"></div>
            </div>
            <div class="form-group">
              <label for="modal_category_desc">Category description:</label>
              <p id="modal_category_desc"></p>
            </div>
            {{-- <div class="form-group">
              <label for="modal_catergory_timestamp">Timestamp:</label>
              <div id="modal_catergory_timestamp"></div>
            </div> --}}
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