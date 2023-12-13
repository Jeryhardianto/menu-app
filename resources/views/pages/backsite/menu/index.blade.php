@extends('layouts.app')
@section('title', 'Menu')
@section('content')

    <!-- BEGIN: Content-->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">List Menu</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            {{-- <li class="breadcrumb-item"><a href="#">Home</a></li> --}}
                            <li class="breadcrumb-item active">Menu</li>
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
                    {{-- <div class="card-header">
                        <h3 class="card-title">DataTable with default features</h3>
                    </div> --}}
                    <!-- /.card-header -->

                    <div class="card-body">
                        @can('post_create')
                        <a href="{{ route('menu.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah
                            Post</a>
                        @endcan
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Menu</th>
                                    <th>Subkategori</th>
                                    <th>Harga</th>
                                    <th>Deskripsi</th>
                                    <th>Foto</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($menus as $mn)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $mn->nama_menu }}</td>
                                        <td>{{ $mn->GetSubkategori ->subketagori}}</td>
                                        <td>Rp. {{ Number::format($mn->harga, locale: 'de') }}</td>
                                        <td>{{ $mn->deskripsi }}</td>
                                        <td>
                                            <img src="{{ env('AWS_URL') }}{{ $mn->gambar }}" width="200" alt="{{ $mn->nama_menu }}">
                                        </td>
                                        <td>
                                        
                                
                                        <a href="{{ route('menu.edit', $mn->id ) }}" class="btn btn-success"><i
                                                class="fas fa-pen-square"></i> Edit</a>
                                        
                                            <form class="d-inline" method="post" role="alert" action="{{ route('menu.destroy',  $mn->id) }}">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-trash"></i> Hapus</a>
                                                </button>
                                            </form>
                                        
                                        
                                        </td>
                                    </tr>
                                    
                                @endforeach
                                {{-- @empty
                                    <tr>
                                        <td colspan="3" class="text-center"><strong>Data Role Kosong</strong></td>
                                    </tr>
                                @endforelse --}}
                            </tbody>

                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- END: Content-->

@endsection

{{-- Datatabel --}}
@push('javascript-internal')
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
@endpush

@push('javascript-internal')
    <script>
        $(document).ready(function() {
            $("form[role='alert']").submit(function(event) {
                event.preventDefault();
                // alert('Hallo');
                Swal.fire({
                    title: 'Hapus Menu',
                    text: "Apakah anda yakin menghapus data ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Hapus'
                }).then((result) => {
                    if (result.isConfirmed) {
                        event.target.submit();
                    }
                })
            });
        });
    </script>
@endpush
