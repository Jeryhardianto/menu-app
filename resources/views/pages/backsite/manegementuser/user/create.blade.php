@extends('layouts.app')
@section('title', 'Tambah User')
@section('content')

    <!-- BEGIN: Content-->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Tambah User</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">User</li>
                            <li class="breadcrumb-item active">Tambah User</li>
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
                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{ route('users.index') }}" class="btn btn-danger mb-3"><i class="fas fa-backward"></i>
                                        Kembali</a>
                                    <div class="form-group">
                                        <label for="name">Nama User</label>
                                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                                               class="form-control @error('name') is-invalid @enderror" placeholder="Masukan nama  user">
                                        @error('name')
                                        <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror

                                    </div>
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" style="width: 100%;">
                                            <option value="Owner">Owner</option>
                                            <option value="Kasir">Kasir</option>
                                            <option value="Kitchen">Kitchen</option>
                                            <option value="Pelanggan">Pelanggan</option>
                                        </select>
                                        @error('role')
                                        <span class="invalid-feedback">
                                           <strong>{{ $message }}</strong>
                                          </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                                               class="form-control @error('email') is-invalid @enderror" placeholder="Masukan email">
                                        @error('email')
                                        <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" id="password" name="password"
                                               class="form-control @error('password') is-invalid @enderror" placeholder="Masukan password">
                                        @error('password')
                                        <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="password_confirmation">Konfirmasi Password</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                               class="form-control" placeholder="Masukan ulang password">

                                    </div>

                                </div>

                                <div class="col-md-6">
                                 <br><br><br>
                                    <div class="form-group">
                                        <label for="telepon">Telepon</label>
                                        <input type="number" id="telepon" name="telepon" value="{{ old('telepon') }}"
                                               class="form-control @error('telepon') is-invalid @enderror" placeholder="Masukan telepon">
                                        @error('telepon')
                                        <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>

                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" placeholder="Masukan alamat" id="alamat" cols="30" rows="5">
                                            </textarea>
                                        @error('alamat')
                                        <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                </div>
                            </div>
                            </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                        </div>
                    </form>

                </div>

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- END: Content-->

@endsection

@push('javascript-internal')
    <script>

    </script>
@endpush
