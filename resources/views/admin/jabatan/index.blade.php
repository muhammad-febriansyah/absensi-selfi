@extends('admin.layouts.main')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <a href="{{ route('main.createjabatan') }}" class="btn btn-primary mr-3 mb-3"><i class="fa fa-plus"
                                    aria-hidden="true"></i> Form Jabatan</a> <a href="{{ route('main.jabatan') }}"
                                class="btn btn-info mb-3"><i class="fas fa-sync-alt" aria-hidden="true"></i> Refresh</a>

                            <table class="table table-bordered table-hover" id="dt">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jabatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($data as $data)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $data->name }}</td>
                                            <td>
                                                <a href="{{ route('main.editjabatan', $data->id) }}"
                                                    class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                                <button type="button" data-id="{{ $data->id }}"
                                                    class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        @include('admin.layouts.footer')
    </div>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            $(document).on('click', '.delete', function() {
                    var id = $(this).data("id");
                    var url = "{{ route('main.destroyjabatan') }}";
                    Swal.fire({
                        title: 'Apakah kamu yakin?',
                        text: 'Data yang sudah dihapus tidak dapat dikembalikan!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Hapus'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "DELETE",
                                url: url,
                                data: {
                                    id: id
                                },
                                beforeSend: function() {
                                    Swal.fire({
                                        title: 'Tunggu Sebentar...',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        allowEnterKey: false,
                                        showConfirmButton: false,
                                        onBeforeOpen: () => {
                                            Swal.showLoading()
                                        },
                                    });
                                },
                                success: function(data) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Informasi',
                                        text: "Data berhasil dihapus!"

                                    }).then(function() {
                                        location.reload(); // Reload the page
                                    });
                                },
                                error: function(data) {
                                    console.log(data);
                                    Swal.fire('Informasi', 'Ada kesalahan sistem.',
                                        'error');
                                }
                            });
                        }
                    });
                });
    
        });
    </script>
@endsection
