<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('dashboard') }}" class="brand-link">
      <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Data Management</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('dist/img/avatar5.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{auth()->user()->name}}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      {{-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> --}}

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ url('dashboard') }}" class="nav-link @if (Request::url() == url('dashboard')) active @endif">
              {{-- <i class="nav-icon far fa-image"></i> --}}
              <i class="fas fa-home"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item @if (Request::url() == url('createuser') || Request::url() == url('users')) menu-open @endif">
            <a href="#" class="nav-link @if (Request::url() == url('createuser')) active @elseif (Request::url() == url('users')) active @endif">
              <i class="nav-icon fas fa-user"></i>
              <p>
                User
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('users') }}" class="nav-link @if (Request::url() == url('users')) active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List</p>
                </a>
              </li>
              @if (auth()->user()->is_admin != 3)
              <li class="nav-item">
                <a href="{{ url('createuser') }}" class="nav-link @if (Request::url() == url('createuser')) active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create</p>
                </a>
              </li>
              @endif
            </ul>
          </li>
          @if (auth()->user()->is_admin != 2)
          <li class="nav-item  @if (Request::url() == url('category') OR Request::url() == url('createcategory')) menu-open @endif">
            <a href="#" class="nav-link @if (Request::url() == url('createcategory')) active @elseif (Request::url() == url('category')) active @endif">
              <i class="nav-icon fas fa-list"></i>
              <p>
                Category
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('category') }}" class="nav-link @if (Request::url() == url('category')) active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('createcategory') }}" class="nav-link @if (Request::url() == url('createcategory')) active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item @if (Request::url() == url('createproduct') || Request::url() == url('product')) menu-open @endif">
            <a href="#" class="nav-link @if (Request::url() == url('createproduct')) active @elseif (Request::url() == url('product')) active @endif">
              <i class="nav-icon fas fa-shopping-basket"></i>
              <p>
                Product
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('product') }}" class="nav-link @if (Request::url() == url('product')) active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('createproduct') }}" class="nav-link @if (Request::url() == url('createproduct')) active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
          <li class="nav-item">
            <a href="{{ url('logout') }}" class="nav-link">
              {{-- <i class="nav-icon far fa-image"></i> --}}
              <i class="fas fa-arrow-circle-right"></i>
              <p>
                logout
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>