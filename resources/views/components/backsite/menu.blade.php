
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('assets/backsite/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/backsite/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->nama }}</a>
            </div>
        </div>

       

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
       with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ set_active('dashboard') }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li> 
                @can('post_show')
                <li class="nav-item">
                    <a href="{{ route('post.index') }}" class="nav-link {{ set_active(['post.index', 'post.show', 'post.create','post.edit']) }}">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>
                            Post
                        </p>
                    </a>
                </li>
                @endcan

                <li class="nav-header">EXAMPLES</li>
                <li class="nav-item">
                    <a href="pages/calendar.html" class="nav-link">
                        <i class="nav-icon far fa-calendar-alt"></i>
                        <p>
                            Calendar
                            <span class="badge badge-info right">2</span>
                        </p>
                    </a>
                </li>


                @can('role_show','user_show')
                <li class="nav-header">Manegement User</li>
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link {{ set_active(['users.index', 'users.show','users.create','users.edit']) }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            User
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('role.index') }}" class="nav-link {{ set_active(['role.index','role.show', 'role.create','role.edit']) }}">
                        <i class="nav-icon far fa-calendar-alt"></i>
                        <p>
                            Role
                        </p>
                    </a>
                </li>   
                @endcan
            

             
                
                  {{-- <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                            <button class="btn btn-danger nav-link text-left" >
                                <p style="color: #ffffff">
                                    <i class="fas fa-sign-out-alt" ></i> Logout
                                </p>
                            </button>
                      </form>
                </li> --}}
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>