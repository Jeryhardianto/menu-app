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
            <!-- Navbar Search -->
            <!-- Notifications Dropdown Menu -->
           {{-- if page payment hide button cart  --}}
             @if (Route::currentRouteName() != 'payment' && Route::currentRouteName() != 'paymentsuccess')
            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalCart">
                <i class="fas fa-shopping-cart"></i> 
                <span class="badge badge-light">{{ $cart['sumQty'] }}</span>
            </button>
            @endif
            {{-- end if page payment hide button cart  --}}
            
            <li class="nav-item dropdown">
                @auth
                @if (Auth::user()->role == 'Pelanggan')
                <form action="{{ route('logout') }}" method="post" role="logout">
                    @csrf
                    <button type="submit" class="btn btn-danger ml-2 nav-link text-white">
                        <i class="fas fa-sign-out-alt" style="color: #ffffff"></i> Logout
                    </button>
                </form>
                @endif
                @endauth
                
                @guest
                    <a href="{{ route('login') }}" class="btn btn-primary ml-2 nav-link text-white">
                        <i class="fas fa-sign-out-alt" style="color: #ffffff"></i> Login
                    </a>
             
                @endguest
                  
            </li>

        </ul>
    </nav>
    @if (Route::currentRouteName() != 'payment' && Route::currentRouteName() != 'paymentsuccess')
    {{-- Modal Cart --}}
    <div class="modal fade" id="modalCart" tabindex="-1" role="dialog"  data-backdrop="static" aria-labelledby="modalCartTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <form id="checkout-form" >
            <div class="modal-header">
            <h5 class="modal-title" id="modalCartTitle">Konfirmasi Order</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="nomormeja" class="col-sm-2 col-form-label">Nomor Meja</label>
                    <div class="col-sm-10">
                      <input type="text" data-mask="00" class="form-control" name="nomormeja" id="nomormeja" value="{{ $nomormeja }}" placeholder="Nomor Meja">
                    </div>
                  </div>
                  @php
                      $grandtotal = 0;
                  @endphp
                @foreach ($cart['data'] as $key => $item )
                <div class="card">
                    <div class="card-body">
                       <div class="row">    
                            <div class="col-md-6">
                              {{ $item['nama']  }} x {{ $item['qty'] }} @ {{ Rupiah($item['harga'])  }}
                                <input type="text" hidden name="id[]" value="{{ $item['id'] }}">
                              <textarea class="form-control" name="catatan[]" id="catatan" placeholder="Catatan...." cols="20" rows="2">{{ $catatan }}</textarea>
                            </div>
                            <div class="col-md-6 ">
                            @php
                                $harga = $item['harga'] * $item['qty'];
                                $grandtotal += $harga;
                                echo Rupiah($harga);    

                            @endphp

                              <a class="badge badge-danger" href="{{ route('deletecart',$item['id']) }}">Hapus</a>
                            
                            </div>
                       </div>
                    </div>
                  </div>
                @endforeach
          

                  <table class="table-responsive mt-3">
                        <tr>
                            <td width="10%"><b>Total</b></td>
                            <td>:</td>
                            <td width="50%">
                                <b>{{ Rupiah($grandtotal) }}</b>
                                <input type="text" hidden id="total" name="total" value="{{ $grandtotal }}">
                            </td>
                        </tr>
                      
                  </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" onclick="checkout()" id="btn-checkout" class="btn btn-primary text-white" data-dismiss="modal">Checkout</button>
            </div>
            </form>
        </div>
    </div>
    </div>
    @endif
    <!-- End Modal Cart -->


        
