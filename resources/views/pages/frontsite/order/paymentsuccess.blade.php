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
                        <h1 class="m-0">Pesanan sudah dibuat </h1>
                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
         
          <div class="container-fluid">
             
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
        
        const error1 = '{{ $errors->first('buktibayar') }}';
        if (error1) {
            Swal.fire({
            title: "Error",
            text: error1,
            icon: "error"
            });
        }

        const error2 = '{{ $errors->first('metodebayar') }}';
        if (error2) {
            Swal.fire({
            title: "Error",
            text: error2,
            icon: "error"
            });
        }


    </script>
@endpush
