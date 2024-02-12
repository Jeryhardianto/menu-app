@extends('layouts.frontsite')
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
                                    <table class="table table-bordered table-hover" id="listpesanan">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nomor Transaksi</th>
                                                <th>Nomor Meja</th>
                                                <th>Total</th>
                                                <th>Tanggal</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $key => $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <a href="#" id="notransaksi" onclick="noTransaksi('{{ $item->id }}','{{ $item->no_transaksi }}')">
                                                            {{ $item->no_transaksi }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $item->nomor_meja }}</td>
                                                    <td>{{ Rupiah($item->total) }}</td>
                                                    <td>{{ $item->created_at }}</td>
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
                                                        @elseif($item->statusLabel->status == 'ORDER IS NOT CORRECT')
                                                            <span class="badge badge-danger">Pesanan Tidak Sesuai</span>
                                                            <br>
                                                            <span class="badge badge-danger">Alasan: {{ $item->catatan }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="#" id="detail" onclick="detail('{{ $item->id }}','{{ $item->no_transaksi }}')"
                                                            class="btn btn-info btn-sm">Detail</a>
                                                            <a href="#" id="ubahstatus" onclick="ubahstatus('{{ $item->id }}','{{ $item->no_transaksi }}')"
                                                                class="btn btn-info btn-sm">Ubah Status</a>
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

        {{-- Modal Ubah Status --}}
        <div class="modal fade" id="ubahstatusModal" tabindex="-1" aria-labelledby="ubahstatusLabel" aria-hidden="true">
            <form id="ubahstatusform">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ubahstatusLabel">Ubah Status - <span id="notrxb"></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label for="status">Status</label>
                        <select name="status" class="form-control form-control-lg" id="status">
                            <option value="">Pilih Status</option>
                           @if (Auth::user()->role == 'Kasir')
                            <option value="2">IN PROGRESS</option>
                            <option value="3">REJECT</option>
                            <option value="4">CANCEL</option>
                            @elseif (Auth::user()->role == 'Kitchen')
                            <option value="5">DEVLIVERED</option>
                            <option value="6">COMPLETED</option>
                           @elseif (Auth::user()->role == 'Pelanggan')
                            <option value="6">COMPLETED</option>
                            <option value="7">ORDER IS NOT CORRECT</option>
                           @endif

                        </select>
                        <input type="text" name="id" id="id" hidden>

                        <label class="mt-3" for="alasan">Ulasan</label>
                        <textarea class="form-control" name="alasan" required id="alasan" cols="30" rows="2" placeholder="Tulis Ulasan Anda ....."></textarea>
                    </div>

                        <div class="modal-footer">


                            <button type="button" onclick="updateStatus()" class="btn btn-primary"  data-dismiss="modal">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        {{-- End Modal Ubah Status --}}





@endsection
@push('javascript-internal')
    <script>
        $(document).ready(function() {
            $('#listpesanan').DataTable();
        });

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
                            // console.log(value);
                            html += '<div class="card">';
                            html += '<div class="card-body">';
                            html += '<div class="row">';
                            html += '<div class="col-md-6">';
                            html += value.nama + ' x ' + value.jumlah + ' @ ' + Number(value.harga).toLocaleString('id-ID', {
                                style: 'currency',
                                minimumFractionDigits: 0,
                                currency: 'IDR'
                            });
                            if (value.deskripsi != null) {
                                html += '<br>';
                                html += '<small class="badge badge-warning">Catatan : ' + value
                                    .deskripsi + '</small>';
                            }

                            html += '</div>';
                            html += '<div class="col-md-6">';
                            html += Number(value.subtotal).toLocaleString('id-ID', {
                                style: 'currency',
                                minimumFractionDigits: 0,
                                currency: 'IDR'
                            });
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                            // sum subtotal
                            total += value.subtotal;

                        });
                        $('.modal-body').html(html);
                        total = total.toLocaleString('id-ID', {
                                style: 'currency',
                                minimumFractionDigits: 0,
                                currency: 'IDR'
                        });

                        $('#total').html('Total : ' + total);
                    }
                });
            }

        function noTransaksi(id, notrx) {
                var id = id;
                var notrx = notrx;
                showOrderDetail(id, notrx);
        }

        function detail(id, notrx) {
                var id = id;
                var notrx = notrx;
                showOrderDetail(id, notrx);
        }

        function ubahstatus(id, notrx) {
                $('#ubahstatusModal').modal('show');
                $('#notrxb').html(notrx);
                $('#id').val(id);
            }

        function updateStatus() {
            var id = $('#id').val();
            var status = $('#status').val();
            var alasan = $('#alasan').val();


            // validation status
            if (status == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Status harus dipilih',
                    showConfirmButton: false,
                    timer: 1500
                });
                return false;
            }

            if(status == 3 || status == 4) {
                if(alasan == '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Alasan harus diisi',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#alasan').addClass('is-invalid');
                    return false;
                }
            }

            $.ajax({
                url: "{{ route('updatestatus') }}",
                type: "PATCH",
                data: {
                    id: id,
                    status: status,
                    alasan: alasan,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        .then(function() {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message,
                            showConfirmButton: false,
                        });
                    }
                }
            });
        }

    </script>
@endpush
