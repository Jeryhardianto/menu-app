@extends('layouts.frontsite')
@section('title', '')
@section('content')

    <!-- BEGIN: Content-->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Menu</h1>
                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <a href="/" class="btn btn-primary justify-between mb-3">Semua</a>
                @foreach ($subkategoris as $sk )
                <a href="{{ '?subkategori='.$sk->id }}" class="btn btn-primary justify-between mb-3">{{ $sk->subketagori }}</a>
                @endforeach
                <div class="row">
                    @foreach ($menus as $ms )
                    
                    <div class="col-sm-6 col-md-4">

                        <div class="card">
                            <img src="{{ env('AWS_URL') }}{{ $ms->gambar }}" width="200" class="card-img-top"
                                alt="...">
                            <div class="card-body">
                                <h5 class="card-title "><b>{{ $ms->nama_menu }}</b></h5>
                                <br>
                                <p><b>{{ Rupiah($ms->harga) }}</b></p>
                                <button type="button" id="order" class="btn btn-warning btn-block text-white" onclick="getMenu(<?= $ms->id ?>)" data-toggle="modal" data-target="#modalOrder">
                                    <i class="fas fa-shopping-cart"></i> Order
                                </button>
                                <br>
                              @if ($ms->stok == 0)
                              <span class="badge badge-danger">Tidak Tersedia</span>
                              @else
                              <span class="badge badge-success">Tersedia</span>
                              @endif
                                <span class="badge badge-warning">{{ $ms->GetSubkategori->GetKategori->kategori }}</span>
                                <span class="badge badge-primary">{{ $ms->GetSubkategori->subketagori }}</span>

                            </div>
                        </div>

                    </div>
                    @endforeach
                </div>
            </div><!-- /.container-fluid -->

        </section>
        <!-- /.content -->
        {{-- Modal Order --}}
        <!-- Modal -->
        <div class="modal fade" id="modalOrder"  role="dialog" aria-labelledby="modalOrderTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalOrderTitle">Detail Menu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <span id="gambardetail"> </span>
                            </div>
                            <div class="col">
                                <h3><span id="judul"></span></h3>
                                <p><span id="deskripsi"></span></p>
                                <p><b><span id="harga"></span></b></p>
                                <form action="{{ route('addtocart') }}" method="post">
                                    @csrf
                                    <div class="input-group mb-3 row" id="qty-label">
                                        <input type="text" id="id_menu" hidden name="id_nemu">
                                        <input type="number"  id="qty" data-mask="000" name="qty" class="form-control col-xs-2" placeholder="Qty" value="0" min="0">
                                        <div class="input-group-append">
                                            <button  class="btn btn-warning text-white" type="submit" id="button-addon2"><i class="fas fa-shopping-cart"></i> Tambah</button>
                                        </div>
                                    </div>
                                </form>
                                <p><b><span id="stok-label"></span></b></p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            {{-- End Modal Order --}}
    </div>
    <!-- END: Content-->






@endsection
@push('javascript-internal')
<script>
      // create function promise for call ajax
      function ajaxPromise(url, data=null, method) {
            return new Promise(function(resolve, reject) {
                $.ajax({
                    url: url,
                    type: method,
                    data: data,
                    success: function(response) {
                        resolve(response);
                    },
                    error: function(error) {
                        reject(error);
                    }
                });
            });
        }

        // create function for get data menu
        function getMenu(id) {
            var url = 'getdetailmenu/'+id;
            var method = "GET";
            var data = {
                id: id
            };
            const aws_url = '{{ env('AWS_URL') }}';
            const result = ajaxPromise(url,data,method);

            result.then(function(response) {
                $('#id_menu').val(response.data.id);
                $('#judul').html(response.data.nama_menu);
                $('#deskripsi').html(response.data.deskripsi);
                $('#harga').html(response.data.harga);
                $('#gambardetail').html('<img width="100%" src="'+aws_url+''+response.data.gambar+'" class="img-fluid" alt="Responsive image">');
                let stok = response.data.stok;
                if(stok > 0){
                    $('#qty-label').attr('hidden', false);
                    $('#stok-label').html('<span class="badge badge-success">Tersedia</span>');
                    $('#qty').attr('max', stok);
                    
                }else{
                    $('#qty-label').attr('hidden', true);
                    $('#stok-label').html('<span class="badge badge-danger">Tidak Tersedia</span>');
                }
            });

        }


        function checkout() {
            var url = '{{ route('checkout') }}';
            var method = "POST";
            var data = $('#checkout-form').serialize();
            data += "&_token={{ csrf_token() }}";
            ajaxPromise(url, data, method)
                .then(function(response) {
                    console.log(response);
                    if (response.success) {
                        window.location.href = '{{ route('payment') }}';
                    } else {
                        if (response.errors.nomormeja) {
                            $('#nomormeja').addClass('is-invalid');
                            Swal.fire({
                                title: 'Gagal',
                                text: response.errors.nomormeja,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            })

                        }else{
                            window.location.href = '{{ route('login') }}';
                        }

                    }

                })
                .catch(function(error) {
                    console.log('Error :'+ error);
                });


        }

        $('#metode_pembayaran').on('change', function() {
            var metode = $(this).val();
            if (metode == 'QRIS') {
                $('#modalQRIS').modal('show');
            }else if(metode == 'TF'){
                $('#modalTF').modal('show');
            }else{
                $('#btn-checkout').attr('disabled', false);
            }
        });




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
