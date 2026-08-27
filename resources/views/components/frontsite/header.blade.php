<div class="wrapper">
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{ asset('assets/backsite/dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo"
            height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Brand: menggantikan logo yang dulu ada di sidebar -->
        <a href="{{ route('makanan') }}" class="navbar-brand">
            <img src="{{ asset('logo.jpg') }}" alt="" class="brand-image img-circle elevation-2" style="opacity: .9">
            <span class="brand-text font-weight-bold d-none d-sm-inline">{{ env('APP_NAME') }}</span>
        </a>

    </nav>
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
                  @php $grandtotal = 0; @endphp
                @foreach ($cart['data'] as $key => $item )
                <div class="card">
                    <div class="card-body">
                       <div class="row">
                            <div class="col-md-6">
                              {{ $item['nama']  }} x {{ $item['qty'] }} @ {{ Rupiah($item['harga'])  }}
                                <input type="text" hidden name="id[]" value="{{ $item['id'] }}">
                              <label class="sr-only" for="catatan-{{ $item['id'] }}">Catatan {{ $item['nama'] }}</label>
                              <textarea class="form-control" name="catatan[{{ $item['id'] }}]" id="catatan-{{ $item['id'] }}" placeholder="Catatan...." cols="20" rows="2">{{ $item['catatan'] ?? '' }}</textarea>
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


                  <table class="mt-3 w-100">
                    <tr>
                        <td class="pr-2 text-nowrap"><b>Sub Total</b></td>
                        <td>:</td>
                        <td class="pl-2">
                            <b id="Subtotal-label">{{ Rupiah($grandtotal) }}</b>
                            <input type="text" hidden  id="Subtotal" name="Subtotal" value="{{ $grandtotal }}">
                        </td>
                    </tr>
                        <tr id="pengiriman-form">
                            <td class="pr-2 text-nowrap"><b>Biaya Pengiriman</b></td>
                            <td>:</td>
                            <td class="pl-2">
                                <b id="pengiriman-label">Rp 0</b>
                                <input type="text" hidden  id="pengiriman" name="pengiriman">
                            </td>
                        </tr>
                        <tr>
                            <td class="pr-2 text-nowrap"><b>Total</b></td>
                            <td>:</td>
                            <td class="pl-2">
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
    <!-- End Modal Cart -->
</div>
@push('javascript-internal')
<script>
    function checkout() {
        $.post('{{ route('checkout') }}', $('#checkout-form').serialize() + '&_token={{ csrf_token() }}')
            .done(function(response) {
                if (response.success) {
                    window.location.href = '{{ route('payment') }}';
                } else if (response.errors && response.errors.nomormeja) {
                    $('#nomormeja').addClass('is-invalid');
                    Swal.fire({
                        title: 'Gagal',
                        text: response.errors.nomormeja,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                } else {
                    window.location.href = '{{ route('login') }}';
                }
            })
            .fail(function(error) {
                console.log('Error :' + error);
            });
    }

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

@push('javascript-internal')
<script>
    $(document).ready(function() {
        $("form[role='logout']").submit(function(event) {
            event.preventDefault();
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
