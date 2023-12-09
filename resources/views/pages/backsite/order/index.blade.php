@extends('layouts.app')
@section('title', 'Pesanan ')
@section('content')

    <!-- BEGIN: Content-->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Pesanan</h1>
                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">

            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="listorder">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Nomor Transaksi</th>
                                                <th>Nomor Meja</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $key => $item)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $item->created_at }}</td>
                                                    <td>

                                                        <a href="#" id="notransaksi" data-id="{{ $item->id }}"
                                                            data-notrx="{{ $item->no_transaksi }}">
                                                            {{ $item->no_transaksi }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $item->nomor_meja }}</td>
                                                    <td>{{ Rupiah($item->total) }}</td>
                                                    <td>

                                                        @if ($item->statusLabel->status == 'PENDING')
                                                            <span class="badge badge-warning">Cek Transaksi</span>
                                                        @elseif($item->statusLabel->status == 'IN PROGRESS')
                                                            <span class="badge badge-info">Dalam Proses</span>
                                                        @elseif($item->statusLabel->status == 'REJECT')
                                                            <span class="badge badge-danger">Pesanan Ditolak</span>
                                                            <br>
                                                            <span class="badge badge-danger">Alasan: Bukti pembayaran tidak valid</span>
                                                        @elseif($item->statusLabel->status == 'CANCEL')
                                                            <span class="badge badge-danger">Pesanan Dibatalkan</span>
                                                        @elseif($item->statusLabel->status == 'DEVLIVERED')
                                                            <span class="badge badge-success">Pesanan Diterima</span>
                                                        @elseif($item->statusLabel->status == 'COMPLETED')
                                                            <span class="badge badge-success">Pesanan Selesai</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="#" id="detail" data-id="{{ $item->id }}"
                                                            data-notrx="{{ $item->no_transaksi }}"
                                                            class="btn btn-info btn-sm">Detail</a> 
                                                        <a href="#" id="buktibayar" 
                                                            data-id="{{ $item->id }}"
                                                            data-notrx="{{ $item->no_transaksi }}"
                                                            data-buktibayar="{{ $item->bukti_bayar }}"
                                                            class="btn btn-info btn-sm">Bukti Bayar</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

    </div><!-- /.container-fluid -->

    </section>
    <!-- /.content -->
    </div>
    <!-- END: Content-->

    {{-- Modal --}}
    <div class="modal fade" id="detailpesanan" tabindex="-1" aria-labelledby="detailpesananLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailpesananLabel">Detail Pesanan - <span id="notrx"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    {{-- total in span --}}

                    <button type="button" class="btn btn-primary" data-dismiss="modal"><span
                            id="total"></span></button>

                </div>
            </div>
        </div>
    </div>
    {{-- End Modal --}}

    {{-- Modal Bukti Bayar --}}
    <div class="modal fade" id="buktibayarModal" tabindex="-1" aria-labelledby="buktibayarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="buktibayarLabel">Bukti Bayar - <span id="notrx-b"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  
                </div>
                <form action="" method="post" id="buktibayar-form">
                    @csrf
                    <div class="modal-footer">
                        <select name="buktibayar"class="form-control form-control-lg" id="buktibayar">
                            <option value="">Pilih Status</option>
                            <option value="2">IN PROGRESS</option>
                            <option value="3">REJECT</option>
                            <option value="4">CANCEL</option>
                            <option value="5">DEVLIVERED</option>
                            <option value="6">COMPLETED</option>
                        </select>
                        <input type="text" name="id" id="id" hidden>
                        <button type="submit" class="btn btn-primary" data-dismiss="modal">Simpan</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End Modal Bukti Bayar --}}


@endsection
@push('javascript-internal')
    <script>
        $(document).ready(function() {
            $('#listorder').DataTable();
            function showOrderDetail(id, notrx) {
                $('#detailpesanan').modal('show');
                $('#notrx').html(notrx);

                // use ajax
                $.ajax({
                    url: "{{ route('orderdetail') }}",
                    type: "POST",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        // foreach data
                        var html = '';
                        var total = 0;
                        $.each(response.data, function(key, value) {
                            html += '<div class="card">';
                            html += '<div class="card-body">';
                            html += '<div class="row">';
                            html += '<div class="col-md-6">';
                            html += value.nama + ' x ' + value.jumlah + ' @ ' + value.harga;
                            if (value.deskripsi != null) {
                                html += '<br>';
                                html += '<small class="badge badge-warning">Catatan : ' + value
                                    .deskripsi + '</small>';
                            }
                            html += '</div>';
                            html += '<div class="col-md-6">';
                            html += value.subtotal;
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                            // sum subtotal
                            total += value.subtotal;
                        });
                        $('.modal-body').html(html);
                        $('#total').html('Total : ' + total);
                    }
                });
            }

            $('#notransaksi').click(function() {
                var id = $(this).data('id');
                var notrx = $(this).data('notrx');
                showOrderDetail(id, notrx);
            });

            $('#detail').click(function() {
                var id = $(this).data('id');
                var notrx = $(this).data('notrx');
                showOrderDetail(id, notrx);
            });

            $('#buktibayar').click(function() {
                var id = $(this).data('id');
                var notrx = $(this).data('notrx'); 
                var buktibayar = $(this).data('buktibayar'); 
                $('#buktibayarModal').modal('show');
                $('#notrx-b').html(notrx);
                $('#id').val(id);
                var html = '';
                html += '<img src="{{ env('AWS_URL') }}' + buktibayar + '" class="img-fluid" alt="Bukti Bayar">';
                
                $('.modal-body').html(html);

            });

            $('#buktibayar-form').submit(function(e) {
                // confirm when submit form use sweetalert
                e.preventDefault();
                var id = $('#id').val();
                var buktibayar = $('#buktibayar').val();
                if (buktibayar == '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Pilih Status Bukti Bayar!',
                    })
                } else {
                    Swal.fire({
                        title: 'Apakah Anda Yakin?',
                        text: "",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                    }).then((result) => {
                        if (result.isConfirmed) {
                           
                        }
                    })
                }
               
            });

        });
    </script>
@endpush
