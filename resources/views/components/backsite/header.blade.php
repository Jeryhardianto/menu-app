<div class="wrapper">
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{ asset('assets/backsite/dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo"
            height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            @if (Auth::user()->role == 'Kasir')
                @php
                    $pesanan = App\Models\Pesanan::where('id_status', '1')->count();
                @endphp
                @if ($pesanan > 0)
                <li class="nav-item dropdown mr-2">
                    <a class="nav-link btn btn-warning text-white"  href="{{ route('order') }}">
                        Pesanan baru <span class="badge badge-light">{{ $pesanan }}</span>
                    </a>
                </li>
                @endif
            @elseif (Auth::user()->role == 'Kitchen')
                @php
                    $pesanan = App\Models\Pesanan::where('id_status', '2')->count();
                @endphp
                @if ($pesanan > 0)
                    <li class="nav-item dropdown mr-2">
                    <a class="nav-link btn btn-warning text-white"  href="{{ route('order') }}">
                        Pesanan baru <span class="badge badge-light">{{ $pesanan }}</span>
                    </a>
                    </li>
                @endif
            @endif

           
            
            <li class="nav-item dropdown">
                <form method="POST" role='logout' action="{{ route('logout') }}">
                    @csrf
                        <button class="btn btn-danger nav-link" >
                            <i class="fas fa-sign-out-alt" style="color: #ffffff"></i>
                        </button>
                  </form>
            </li>

        </ul>
    </nav>
    <!-- /.navbar -->
    @push('javascript-internal')
    <script>
        // Alert konfirmasi hapus
        $(document).ready(function() {
            $("form[role='logout']").submit(function(event) {
                event.preventDefault();
                // alert('Hallo');
                Swal.fire({
                    title: 'Apakah anda yakin ingin keluar ?',
                    text: "",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Keluar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        event.target.submit();
                    }
                })
            });
        });
    </script>
@endpush