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
                        <h1 class="m-0">Tambah Menu</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">Menu</a></li>
                            <li class="breadcrumb-item active">Tambah Menu</li>
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
                    <form method="POST" action="{{ route('subkategori.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-body">
                                    <a href="{{ route('subkategori.index') }}" class="btn btn-danger mb-3"><i class="fas fa-backward"></i>
                                        Kembali</a>
                                    <div class="form-group">
                                        <label for="subkategori">Subkategori</label>
                                        <input type="text" id="subkategori" name="subkategori" value="{{ old('subkategori') }}"
                                            class="form-control @error('subkategori') is-invalid @enderror" placeholder="Masukan subkategori">
                                        @error('subkategori')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
        
                                    </div>
                                    <div class="form-group">
                                        <label for="kategori">Kategori</label>
                                        <select class="form-control @error('kategori') is-invalid @enderror" id="kategori" name="kategori" style="width: 100%;">
                                            <option value="0">Pilih kategori</option>
                                            @foreach ($kategories as $item)
                                                <option value="{{ $item->id }}">{{ $item->kategori }}</option>
                                            @endforeach
                                        </select>
                                        @error('kategori')
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
