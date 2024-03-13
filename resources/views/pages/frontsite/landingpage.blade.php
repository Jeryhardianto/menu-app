@extends('layouts.frontsite')
@section('title', '')
@section('content')

    <!-- BEGIN: Content-->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Menu</h1>
                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                            <h3>MAKANAN</h3>
                            <br>
                            <br>
                            <br>
                            </div>
                            <div class="icon">
                                <i class="fas fa-hamburger"></i>
                            </div>
                            <a href="{{ route('makanan') }}" class="small-box-footer">Pilih Menu <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                    </div>
                    <div class="col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                            <h3>MINUMAN</h3>
                            <br>
                            <br>
                            <br>
                            </div>
                            <div class="icon">
                                <i class="fas fa-coffee"></i>
                            </div>
                            <a href="{{ route('minuman') }}" class="small-box-footer">Pilih Menu <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->

        </section>
    </div>
    <!-- END: Content-->






@endsection

