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
              <li class="breadcrumb-item active">User</li>
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
                    <label for="firstname">First name*</label>
                    <input type="text" name="firstname" class="form-control" id="firstname" placeholder="Enter first name" value="@if (old('firstname') != null) {{old('firstname')}} @elseif (isset($user)){{explode(' ', $user->name)[0] ?? ''}} @endif" required>
                  </div>
                  <div class="form-group">
                    <label for="lastname">Last name*</label>
                    <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Enter last name" value="@if (old('lastname') != null) {{old('lastname')}} @elseif (isset($user)){{explode(' ', $user->name)[1] ?? ''}}@endif" required>
                  </div>
                  <div class="form-group">
                    <label for="email">Email address*</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" value="@if (old('email') != null) {{old('email')}} @elseif (isset($user)){{$user->email}}@endif" @if (isset($user))disabled @endif required>
                  </div>
                  <div class="form-group">
                    <label for="password">Password*</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                  </div>
                  <div class="form-group">
                    <label for="cpassword">Confirm Password*</label>
                    <input type="password" name="cpassword" class="form-control" id="cpassword" placeholder="Confirm Password" required>
                  </div>
                  @if (!isset($user) || ($user->is_admin != 1 || auth()->user()->is_admin != 1))
                  <div class="form-group">
                    <label for="exampleInputPassword1">User Role*</label>
                    <select name="role" class="form-control" required>
                      <option value="">Please select</option>
                      @foreach ($roles as $role)
                        <option value="{{$role->role}}" @if(old('role') != null) {{ old('category') }} @elseif (isset($user))@if ($user->is_admin == $role->role) selected @endif @endif>{{$role->name}}</option>
                      @endforeach
                      {{-- <option value="2" @if (old('role') != null && old('role') == 2) selected @elseif (isset($user))@if ($user->is_admin == 2) selected @endif @endif>Admin user</option>
                      <option value="3" @if (old('role') != null && old('role') == 3) selected @elseif (isset($user))@if ($user->is_admin == 3) selected @endif @endif>Sales</option> --}}
                    </select>
                  </div>
                  @endif
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