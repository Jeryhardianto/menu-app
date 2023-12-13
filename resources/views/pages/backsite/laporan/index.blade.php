@extends('layouts.app')
@section('title', 'Laporan')
@section('content')

<!-- BEGIN: Content-->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Laporan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Laporan</a></li>
                    </ol>
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
                    {{-- create table --}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                              <div class="card-body">
                                <form action="{{ route('laporan') }}">
                                    @csrf
                                    @method('GET')
                                  <div class="col-12">
                                      <label for="dari">Periode</label>
                                  <div class="d-flex mb-3">
                                      <input type="date" class="form-control mr-5" name="dari" id="dari">
                                      <span>Sampai</span> 
                                      <input type="date" class="form-control ml-5" name="sampai" id="sampai"> 
                                  </div>
                                  </div>
                                 <div class="col-6 mb-3">
                                  <label for="status">Status</label>
                                  <select class="form-control" name="status" id="status">
                                      <option value="">Pilih Status</option>
                                      <option value="1">Pending</option>
                                      <option value="2">In Progress</option>
                                      <option value="3">Reject</option>
                                      <option value="4">Cancel</option>
                                      <option value="5">Delivered</option>
                                      <option value="6">Completed</option>
                                  </select>
                                 </div>
                                 <button type="submit" class="btn btn-primary btn-block">Filter</button>
                                </form>
                                </div>
                            </div>
                            <div class="table-responsive">


                                <table id="table" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No Transaksi</th>
                                            <th>Nomor Meja</th>
                                            <th>Total</th>
                                            <th>Status</th>

                                            <th>Tanggal Pesanan</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $order->no_transaksi }}</td>
                                            <td>{{ $order->nomor_meja }}</td>
                                            <td>
                                                
                                                @if ($order->statusLabel->status == 'PENDING')
                                                <span class="badge badge-warning">Cek Transaksi</span>
                                            @elseif($order->statusLabel->status == 'IN PROGRESS')
                                                <span class="badge badge-info">Dalam Proses</span>
                                            @elseif($order->statusLabel->status == 'REJECT')
                                                <span class="badge badge-danger">Pesanan Ditolak</span>
                                                <br>
                                                <span class="badge badge-danger">Alasan: {{ $order->catatan }}</span>
                                            @elseif($order->statusLabel->status == 'CANCEL')
                                                <span class="badge badge-danger">Pesanan Dibatalkan</span>
                                                <br>
                                                <span class="badge badge-danger">Alasan: {{ $order->catatan }}</span>
                                            @elseif($order->statusLabel->status == 'DEVLIVERED')
                                                <span class="badge badge-success">Pesanan Diterima</span>
                                            @elseif($order->statusLabel->status == 'COMPLETED')
                                                <span class="badge badge-success">Pesanan Selesai</span>
                                            @endif
                                            </td>
                                            <td>Rp. {{ Illuminate\Support\Number::format($order->total,  locale: 'de') }}</td>
                                            <td>{{ $order->created_at }}</td>
                                        </tr>
                                        @endforeach
                                      
                                    </tbody>
                                </table>
                        </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- END: Content-->

@endsection
@push('javascript-internal')
<script>
    $(document).ready(function () {
     
        $('#table').DataTable({
            "order": [[ 0, "desc" ]],
            dom: 'Bfrtip',
            buttons: [
                'pdf'
            ]
        });

    });
</script>
@endpush
