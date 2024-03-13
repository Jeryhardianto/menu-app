@extends('layouts.frontsite')
@section('title', 'Pembayaran ')
@section('content')

    <!-- BEGIN: Content-->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Pembayaran</h1>
                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
          <form action="{{ route('createorder') }}" method="post"  enctype="multipart/form-data">
            @csrf
          <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4>Detail Pesanan</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Menu</th>
                                            <th>Harga</th>
                                            <th>Jumlah</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $grandtotal = 0;
                                        @endphp
                                        @foreach ($carts as $key => $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item['nama'] }}</td>
                                                <td>{{ Rupiah($item['harga']) }}</td>
                                                <td>{{ $item['qty'] }}</td>
                                                <td>{{ Rupiah($item['harga'] * $item['qty']) }}</td>
                                                @php
                                                    $harga = $item['harga'] * $item['qty'];
                                                    $grandtotal += $harga;
                                                @endphp

                                            </tr>
                                        @endforeach

                                        <tr>
                                            <td colspan="4" align="right"><b>Total</b></td>
                                            <td>
                                                <b>{{ Rupiah($grandtotal) }}</b>
                                                <input type="text" hidden id="total" name="total"
                                                    value="{{ $grandtotal }}">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                {{-- error validation --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                      
                                            @foreach ($errors->all() as $key => $error)
                                               <i class="fas fa-exclamation-circle"></i> {{ $error }}
                                            @endforeach
                                       
                                    </div>
                                @endif
                                <h4>Metode Pembayaran</h4>
                                <select class="form-control form-control-lg mb-4" id="metodebayar" name="metodebayar">
                                    <option value="0">-- Pilih Metode Pembayaran --</option>
                                    <option value="qris">QRIS </option>
                                    <option value="tf">TRANSFER BANK</option>
                                    <option value="cash">CASH</option>
                                </select>

                                <h4>Cara Pembayaran</h4>

                                <div class="accordion" id="accordionExample">
                                    <div class="card">
                                        <div class="card-header" id="headingOne">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link btn-block text-left" type="button"
                                                    data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                                    aria-controls="collapseOne">
                                                    QRIS
                                                </button>
                                            </h2>
                                        </div>

                                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                            data-parent="#accordionExample">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <img src="{{ url('image/qr.png') }}" alt="">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>Scan QRIS untuk pembayaran</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-header" id="headingTwo">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link btn-block text-left collapsed" type="button"
                                                    data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                                    aria-controls="collapseTwo">
                                                    TRANSFER BANK
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                            data-parent="#accordionExample">
                                            <div class="card-body">
                                                <h3>1123323 - BCA - Nama Owner/Nama Tempat Makan</h3>
                                            </div>
                                        </div>
                                        <div class="card-header" id="headingThree">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link btn-block text-left collapsed" type="button"
                                                    data-toggle="collapse" data-target="#collapseThree"
                                                    aria-expanded="false" aria-controls="collapseThree">
                                                    CASH
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                            data-parent="#accordionExample">
                                            <div class="card-body">
                                                <h3>Langsung ke kasir</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label for="buktibayar">Upload bukti pembayaran :</label>
                                    <br>
                                    <input type="file" id="buktibayar" class="filepond" name="buktibayar" accept="image/*">
                                </div> 

                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6 mt-1">
                                    <a href="{{ route('order') }}" class="btn btn-danger btn-block">Kembali</a>
                                </div>
                                <div class="col-md-6 mt-1">
                                    <button type="submit" id="btn-checkout"
                                        class="btn btn-primary text-white float-right btn-block">Selesai Pesanan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
  
          </div>
        </form>



    </div><!-- /.container-fluid -->

    </section>
    <!-- /.content -->
    </div>
    <!-- END: Content-->

@endsection
