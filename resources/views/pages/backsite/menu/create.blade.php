@extends('layouts.app')
@section('title', 'Tambah Menu')
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
                            <li class="breadcrumb-item">User</a></li>
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
                    <form method="POST" action="{{ route('menu.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-body">
                                    <a href="{{ route('menu.index') }}" class="btn btn-danger mb-3"><i class="fas fa-backward"></i>
                                        Kembali</a>
                                    <div class="form-group">
                                        <label for="namamenu">Nama Menu</label>
                                        <input type="text" id="namamenu" name="namamenu" value="{{ old('namamenu') }}"
                                            class="form-control @error('namamenu') is-invalid @enderror" placeholder="Masukan nama menu">
                                        @error('namamenu')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
        
                                    </div>
                                    <div class="form-group">
                                        <label for="subkategori">Subkategori</label>
                                        <select class="form-control @error('subkategori') is-invalid @enderror" id="subkategori" name="subkategori" style="width: 100%;">
                                            <option value="0">Pilih Subkategori</option>
                                            @foreach ($subkategories as $item)
                                                <option value="{{ $item->id }}">{{ $item->subketagori }}</option>
                                            @endforeach
                                        </select>
                                        @error('subkategori')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="harga">Harga</label>
                                        <input type="harga" id="harga" name="harga" value="{{ old('harga') }}"
                                            class="form-control @error('harga') is-invalid @enderror" placeholder="Masukan harga">
                                        @error('harga')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
        
                                    <div class="form-group">
                                        <label for="deskripsi">Deskripsi</label>
                                        <textarea class="form-control" name="deskripsi" placeholder="Masukan deskripsi" id="deskripsi" cols="30" rows="5"></textarea>
                                 
                                    </div>
                                  
        
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-5">
                                    <br><br><br><br>
                                   <label for="gambarmenu">Gambar menu </label>
                                   <input type="file" id="gambarmenu" class="filepond mr-5" name="gambarmenu" accept="image/*">
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
