@extends('layouts.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">User</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">User List</li>
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
                  <h3 class="card-title">User</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Role</th>
                      @if (auth()->user()->is_admin == 1 || auth()->user()->is_admin == 2)
                      <th>Action</th>
                      @endif
                    </tr>
                    </thead>
                    <tbody>
                    @php $i = 1; @endphp
                    @foreach( $data as $value)
                    <tr>
                      <td>{{$i}}</td>
                      <td>{{$value->name}}</td>
                      <td>{{$value->email}}</td>
                      <td>{{$value->role_name}}</td>
                      @if (auth()->user()->is_admin == 1)@endif
                      @if (auth()->user()->is_admin == 1 || auth()->user()->is_admin == 2)
                      <td><div class="btn-group btn-group-sm">
                        {{-- <a href="#" class="btn btn-info"><i class="fas fa-eye"></i></a> --}}
                        <a href="{{url('updateUser')}}/{{$value->id}}" class="btn btn-primary ml-1"><i class="fas fa-edit"></i></a>
                        @if ($value->deleted_at != '')
                        <a href="{{url('restore')}}/{{$value->id}}" class="btn btn-danger ml-1"><i class="fas fa-undo"></i></a>
                        @else
                        <a href="{{url('deleteUser')}}/{{$value->id}}" onclick="return confirm('Are you sure you want to delete user.')" class="btn btn-danger ml-1"><i class="fas fa-trash"></i></a>
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
@endsection