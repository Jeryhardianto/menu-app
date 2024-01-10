
<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4" style="background-color: #2557e2">
    <!-- Brand Logo -->
    <a href="#" class="brand-link" >
        <img src="{{ asset('logo.jpg') }}" alt="{{ env('APP_NAME') }}" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-bold text-white">{{ env('APP_NAME') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{env('AWS_URL')}}{{ Auth::user()->foto}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{route('myaccount', Auth::user()->id)}}" class="d-block font-weight-bold text-white">{{ Auth::user()->nama }}</a>
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
                @if (in_array(Auth::user()->role, ['Kasir', 'Kitchen']))
                <li class="nav-item">
                    <a href="{{ route('order') }}" class="nav-link {{ set_active(['order', 'paymentsuccess']) }}">
                        <i class="fas fa-shopping-cart"></i>
                        <p>
                            Pesanan
                            @if (Auth::user()->role == 'Kasir')
                                @php
                                    $pesanan = App\Models\Pesanan::where('id_status', '1')->count();
                                @endphp
                                @if ($pesanan > 0)
                                <span class="badge badge-danger">
                                    {{ $pesanan }}
                                </span>
                                @endif
                            @elseif (Auth::user()->role == 'Kitchen')
                                @php
                                    $pesanan = App\Models\Pesanan::where('id_status', '2')->count();
                                @endphp
                                @if ($pesanan > 0)
                                <span class="badge badge-danger">
                                    {{ $pesanan }}
                                </span>
                                @endif

                            @endif


                        </p>
                    </a>
                </li>

                @endif



                @if (in_array(Auth::user()->role, ['Owner','Kasir']))
                <li class="nav-item">
                    <a href="{{ route('laporan') }}" class="nav-link {{ set_active(['laporan']) }}">
                        <i class="nav-icon far fa-file-alt"></i>
                        <p>
                            Laporan
                        </p>
                    </a>
                </li>
                @endif

                @if (in_array(Auth::user()->role, ['Owner','Kasir']))
                <li class="nav-header">Master Data</li>
                <li class="nav-item">
                    <a href="{{ route('menu.index') }}" class="nav-link {{ set_active(['menu.index', 'menu.show','menu.create','menu.edit']) }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Data Menu
                        </p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="{{ route('subkategori.index') }}" class="nav-link {{ set_active(['subkategori.index', 'subkategori.show','subkategori.create','subkategori.edit']) }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Data Subkategori
                        </p>
                    </a>
                </li>
                @endif
                @if (in_array(Auth::user()->role, ['Owner']))
                <li class="nav-header">Manegement User</li>
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link {{ set_active(['users.index', 'users.show','users.create','users.edit']) }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            User
                        </p>
                    </a>
                </li>
{{--                <li class="nav-item">--}}
{{--                    <a href="{{ route('role.index') }}" class="nav-link {{ set_active(['role.index','role.show', 'role.create','role.edit']) }}">--}}
{{--                        <i class="nav-icon far fa-calendar-alt"></i>--}}
{{--                        <p>--}}
{{--                            Role--}}
{{--                        </p>--}}
{{--                    </a>--}}
{{--                </li>--}}
                @endif



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
