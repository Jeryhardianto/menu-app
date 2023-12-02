@extends('layouts.app')
@section('title', 'Tambah Role')
@section('content')

    <!-- BEGIN: Content-->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Tambah Role</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">Role</a></li>
                            <li class="breadcrumb-item active">Tambah Role</li>
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
                    <form method="POST" action="{{ route('role.store') }}">
                        @csrf

                    <div class="card-body">
                        <a href="{{ route('role.index') }}" class="btn btn-danger mb-3"><i class="fas fa-backward"></i> Kembali</a>
                   
                      
                        <div class="form-group">
                            <label for="name">Nama Role</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name')
                            is-invalid                                
                            @enderror">
                            @error('name')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                         
                          </div>
                          <div class="form-group">
                          
                            <label for="permission">Permission</label>
                            
                            <div class="row">
                                @forelse ($authorities as $manageName => $permissions)
                                <div class="col-lg-3">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                          <h3 class="card-title">{{ $manageName }}</h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                          <form>
                                            <div class="row">
                                              <div class=" col-sm-6">
                                                <!-- checkbox -->
                                                <div class="form-group">
                                                    @foreach ($permissions as $permission)
                                                    <div class="custom-control custom-checkbox">
                                                        @if (old('permissions'))
                                                        <input class="custom-control-input" id="{{ $permission }}" name="permissions[]" type="checkbox" value="{{ $permission }}" {{ in_array($permission,old('permissions')) ? "checked" : null  }}>
                                                        <label for="{{ $permission }}" class="custom-control-label">{{ $permission }}</label>
                                                        @else
                                                        <input class="custom-control-input" id="{{ $permission }}" name="permissions[]" type="checkbox" value="{{ $permission }}" >
                                                        <label for="{{ $permission }}" class="custom-control-label">{{ $permission }}</label>
                                                        @endif
                                                     
                                                      </div>
                                                    @endforeach
                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                      </div>
                                </div>
                                
                                @empty
                                    <p><strong>Data Kosong</strong></p>
                                @endforelse
                                
                             
                            </div>
                           
                          </div>
                          @error('permissions')
                          <div class="alert alert-danger" role="alert">
                            {{ $message }}
                          </div>
                          @enderror
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
