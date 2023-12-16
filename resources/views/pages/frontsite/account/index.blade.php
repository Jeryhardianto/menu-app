@extends('layouts.frontsite')
@section('title', 'Akun Saya ')
@section('content')

    <!-- BEGIN: Content-->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Akun Saya</h1>
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
                        <form method="POST" action="{{route('myaccount.update', $user->id)}}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <a href="{{ route('homepage') }}" class="btn btn-danger mb-3"><i class="fas fa-backward"></i>
                                            Kembali</a>
                                        <div class="form-group">
                                            <label for="nama">Nama</label>
                                            <input type="text" id="nama" name="nama" value="{{ old('nama', $user->nama) }}"
                                                   class="form-control @error('nama') is-invalid @enderror" placeholder="Masukan nama">
                                            @error('nama')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror

                                        </div>

                                        <div class="form-group">
                                            <label for="harga">Email</label>
                                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                                   class="form-control" readonly >

                                        </div>

                                        <div class="form-group">
                                            <label for="telepon">Telepon</label>
                                            <input type="number" id="telepon" name="telepon" value="{{ old('telepon', $user->telepon) }}"
                                                   class="form-control @error('telepon') is-invalid @enderror" placeholder="Masukan telepon">
                                            @error('telepon')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror

                                        </div>

                                        <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                            <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" placeholder="Masukan alamat" id="alamat" cols="30" rows="5">{{ $user->alamat }}
                                            </textarea>
                                            @error('alamat')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror

                                        </div>


                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-5">
                                        <br><br><br><br>
                                        <label for="fotoprofile">Foto </label>
                                        <input type="file" id="fotoprofile" class="filepond mr-5" name="fotoprofile" accept="image/*">
                                    </div>
                                    <div class="form-group mb-5">
                                        <img src="{{env('AWS_URL')}}{{$user->foto}}" class="rounded img-fluid mx-auto d-block" alt="{{$user->nama}}" width="500px" >
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>

                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#ubahpass"><i class="fas fa-key"></i> Ubah Password</button>

                            </div>
                        </form>
                    </div>
                </div>

            </div>

       <!-- /.container-fluid -->

         </section>

    <!-- /.content -->
    </div>
    <!-- END: Content-->
    {{-- Modal --}}
    <div class="modal fade" id="ubahpass" tabindex="-1" aria-labelledby="ubahpassLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form  method="post" action="{{route('resetpassword', $user->id)}}">
            @csrf
            @method('PATCH')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ubahpassLabel">Ubah Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama">Password Lama</label>
                        <input type="password" id="passlama" name="passlama"
                               class="form-control" placeholder="Masukan password lama">
                    </div>
                    <div class="form-group">
                        <label for="nama">Password Baru</label>
                        <input type="password" id="passbaru" name="passbaru"
                               class="form-control" placeholder="Masukan password baru">
                    </div>
                    <div class="form-group">
                        <label for="nama">Ulangi Password</label>
                        <input type="password" id="passulang" name="passulang"
                               class="form-control" placeholder="Masukan ulang password">
                    </div>

                </div>
                <div class="modal-footer">

                   <button type="submit" class="btn btn-primary">Simpan</button>

                </div>
            </div>
            </form>
        </div>
    </div>


@endsection
@push('javascript-internal')
    <script>

    </script>
@endpush
