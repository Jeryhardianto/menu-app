@extends('layouts.app')
@section('title', 'Post')
@section('content')

    <!-- BEGIN: Content-->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Post</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            {{-- <li class="breadcrumb-item"><a href="#">Home</a></li> --}}
                            <li class="breadcrumb-item active">Post</li>
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
                        <a href="{{ route('post.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah
                            Post</a>
                        @endcan
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Post</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Test</td>
                                        <td>
                                            @can('post_detail')
                                            <a href="{{ route('post.show', 1) }}" class="btn btn-primary"><i
                                                    class="fas fa-eye"></i> Detail</a>
                                            @endcan
                                           @can('post_edit')
                                           <a href="{{ route('post.edit', 1) }}" class="btn btn-success"><i
                                                   class="fas fa-pen-square"></i> Edit</a>
                                           @endcan
                                            @can('post_delete')
                                            <form class="d-inline" method="post" role="alert" action="{{ route('post.destroy', 1) }}">
                                                @csrf
                                                @method('delete')
                                                  <button type="submit" class="btn btn-danger">
                                                      <i class="fas fa-trash"></i> Hapus</a>
                                                  </button>
                                              </form>
                                            @endcan
                                           
                                        </td>
                                    </tr>
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
                    title: 'Hapus Role',
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
