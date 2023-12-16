
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset('assets/backsite/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        @auth
            @if (Auth::user()->role == 'Pelanggan')
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{env('AWS_URL')}}{{ Auth::user()->foto}}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="{{route('myaccount', Auth::user()->id)}}" class="d-block">{{ Auth::user()->nama }}</a>
                </div>
            </div>
            @endif
        @endauth

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
       with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="/" class="nav-link {{ set_active('homepage') }}">

                        <i class="fas fa-utensils"></i>
                        <p>
                            Menu
                        </p>
                    </a>
                </li>
                @auth
                    @if (Auth::user()->role == 'Pelanggan')
                    <li class="nav-item">
                        <a href="{{ route('order') }}" class="nav-link {{ set_active(['order', 'paymentsuccess']) }}">
                            <i class="fas fa-shopping-cart"></i>
                            <p>
                                Pesanan
                            </p>
                        </a>
                    </li>
                    @endif
                @endauth





            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
