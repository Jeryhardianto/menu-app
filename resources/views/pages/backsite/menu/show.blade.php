@extends('layouts.app')
@section('title', 'Detail Role')
@section('content')

    <!-- BEGIN: Content-->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Detail Role</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">Role</a></li>
                            <li class="breadcrumb-item active">Detail Role</li>
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
                        <a href="{{ route('role.index') }}" class="btn btn-danger mb-3"><i class="fas fa-backward"></i> Kembali</a>
                        <div class="form-group">
                            <label for="role">Nama Role</label>
                            <input type="text" id="role" name="role" value="{{ $role->name }}" class="form-control" disabled>
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
                                                        <input class="custom-control-input" onclick="retrun false" type="checkbox" {{ in_array($permission,  $rolePermissions) ? "checked" : null }} >
                                                        <label class="custom-control-label">{{ $permission }}</label>
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
                       
                    </div>
                </div>
                
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- END: Content-->

@endsection
