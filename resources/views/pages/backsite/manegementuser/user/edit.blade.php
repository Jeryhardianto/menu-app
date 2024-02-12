@extends('layouts.app')
@section('title', 'Edit Pengguna')
@section('content')

    <!-- BEGIN: Content-->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Pengguna</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">Pengguna</li>
                            <li class="breadcrumb-item active">Edit Pengguna</li>
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
                    <form method="POST" action="{{ route('users.update', ['user' => $user]) }}">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <a href="{{ route('users.index') }}" class="btn btn-danger mb-3"><i class="fas fa-backward"></i>
                                Kembali</a>
                            <div class="form-group">
                                <label for="name">Nama User</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="Masukan nama  user" readonly>
                                @error('name')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                    class="form-control @error('email') is-invalid @enderror" placeholder="Masukan email" readonly>
                                @error('email')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            @php
                                $roles = ['Owner', 'Kasir', 'Kitchen', 'Pelanggan'];
                            @endphp
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" style="width: 100%;">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}" @if ($user->role === $role) selected @endif>{{ $role }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                <span class="invalid-feedback">
                                           <strong>{{ $message }}</strong>
                                          </span>
                                @enderror
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

@endpush
