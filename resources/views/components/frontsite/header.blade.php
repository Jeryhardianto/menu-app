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
            @unless (in_array(Route::currentRouteName(), ['payment', 'paymentsuccess', 'order', 'myaccount']))
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
    @unless (in_array(Route::currentRouteName(), ['payment', 'paymentsuccess', 'order', 'myaccount']))
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
                @auth
                <div class="form-group row">
                    <label for="nomormeja" class="col-sm-2 col-form-label">Nama</label>

                    <div class="col-sm-10">
                        <input type="text"  class="form-control" name="nama" id="nama" value="{{ Auth::user()->nama }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
                    <div class="col-sm-10">
                        @php
                            $date = date('Y-m-d H:i');
                        @endphp
                        <input type="text"  class="form-control" name="tanggal" id="tanggal" value="{{ $date }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="type" class="col-sm-2 col-form-label">Tipe</label>
                    <div class="col-sm-10">
                        <select name="type" id="type" class="form-control">
                            <option value="Dine In">DINE IN</option>
                            {{-- <option value="Take Away">TAKEAWAY</option> --}}
                        </select>
                    </div>
                  
                </div>
                <div class="form-group row" id="alamat-label">
                    <label for="type" class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                        <textarea name="alamat" id="alamat" class="form-control" cols="30" rows="2">{{ Auth::user()->alamat }}</textarea>
                    </div>
                  
                </div>
                @endauth
                <div class="form-group row" id="nomormeja-label">
                    <label for="nomormeja" class="col-sm-2 col-form-label">Nomor Meja</label>
                    <div class="col-sm-10">
                      {{-- <input type="text" data-mask="00" class="form-control" name="nomormeja" id="nomormeja" value="{{ $nomormeja }}" placeholder="Nomor Meja"> --}}
                      <select name="nomormeja" id="nomormeja" class="form-control">
                        @foreach ($nomormejas as $no)
                            @php
                                $available = $no->is_available == 1 ? 'disabled' : '';
                                $sts_available = $no->is_available == 1 ? '<h4 style="color:red">Meja Tidak Tersedia</h4>' :'<h4 style="color:green">Meja Tersedia</h4>';
                            @endphp
                            <option value="{{ $no->id }}" {{ $available }}>{{ $no->nomormeja }}  {!! $sts_available !!}
                            </option>
                        @endforeach
                    </select>
                    </div>
                  </div>
                  @php
                      $grandtotal = 0;
                      $i = 0;
                  @endphp
                @foreach ($cart['data'] as $key => $item )
                <div class="card">
                    <div class="card-body">
                       <div class="row">
                            <div class="col-md-6">
                              {{ $item['nama']  }} x {{ $item['qty'] }} @ {{ Rupiah($item['harga'])  }}
                                <input type="text" hidden name="id[]" value="{{ $item['id'] }}">
                              <textarea class="form-control" name="catatan[]" id="catatan" placeholder="Catatan...." cols="20" rows="2">{{ @$catatan[$i] }}</textarea>
                            </div>
                            <div class="col-md-6 ">
                            @php
                                $harga = $item['harga'] * $item['qty'];
                                $grandtotal += $harga;
                                echo Rupiah($harga);
                                $i++;
                            @endphp

                              <a class="badge badge-danger" href="{{ route('deletecart',$item['id']) }}">Hapus</a>

                            </div>
                       </div>
                    </div>
                  </div>

                @endforeach


                  <table class="table-responsive mt-3">
                    <tr>
                        <td width="10%"><b>Sub Total</b></td>
                        <td>:</td>
                        <td width="50%">
                            <b id="Subtotal-label">{{ Rupiah($grandtotal) }}</b>
                            <input type="text" hidden  id="Subtotal" name="Subtotal" value="{{ $grandtotal }}">
                        </td>
                    </tr>
                        <tr id="pengiriman-form">
                            <td width="10%"><b>Biaya Pengiriman</b></td>
                            <td>:</td>
                            <td width="50%">
                                <b id="pengiriman-label">Rp 0</b>
                                <input type="text" hidden  id="pengiriman" name="pengiriman">
                            </td>
                        </tr>
                        <tr>
                            <td width="10%"><b>Total</b></td>
                            <td>:</td>
                            <td width="50%">
                                <b id="total-label">{{ Rupiah($grandtotal) }}</b>
                                <input type="text" hidden  id="total" name="total" value="{{ $grandtotal }}">
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
</div>
@unless (in_array(Route::currentRouteName(), ['payment', 'paymentsuccess', 'order', 'myaccount']))
@push('javascript-internal')
<script>
    $(document).ready(function() {
        $('#alamat-label').prop('hidden', true);
        $('#pengiriman-form').prop('hidden', true);
    });
    $('#type').change(function(){
        var type = $(this).val();
        if(type == 'Take Away'){
            $('#nomormeja-label').prop('hidden', true);
            $('#alamat-label').prop('hidden', false);
            $('#pengiriman-form').prop('hidden', false);
            // add cost take away 10000
            $('#pengiriman-label').html('{{ Rupiah(10000) }}');
            $('#pengiriman').val(10000);
            $('#total').val({{ $grandtotal + 10000 }});
            $('#total-label').html('{{ Rupiah($grandtotal + 10000) }}');

        }else{
            $('#nomormeja-label').prop('hidden', false);
            $('#alamat-label').prop('hidden', true);
            $('#pengiriman-label').html('{{ Rupiah(0) }}');
            $('#pengiriman').val(0);
            $('#total').val({{ $grandtotal }});
            $('#total-label').html('{{ Rupiah($grandtotal) }}');
            $('#pengiriman-form').prop('hidden', true);
        }
    });
</script>

@endpush
@endif

