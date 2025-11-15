@extends('admin.layouts.main')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <a href="{{ route('main.izin') }}" class="btn btn-info mb-3"><i class="fas fa-sync-alt"
                                    aria-hidden="true"></i> Refresh</a>

                            <table class="table table-bordered table-hover" id="dt">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Foto</th>
                                        <th>Pegawai</th>
                                        <th>Tgl</th>
                                        <th>Jenis</th>
                                        <th>Keterangan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($data as $row)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>
                                                @if ($row->image != null)
                                                    <img src="{{ asset('storage/' . $row->image) }}" width="150px"
                                                        height="100px" class="img img-fluid rounded-3" alt="">
                                                @else
                                                    <img src="{{ asset('nofoto.jpg') }}" width="150px" height="100px"
                                                        class="img img-fluid" alt="">
                                                @endif
                                            </td>
                                            <td>{{ $row->user->name }}</td>
                                            <td>{{ date('d M Y', strtotime($row->date)) }}</td>
                                            <td>
                                                @if ($row->jenis == 'Izin')
                                                    <span class="badge bg-success"> {{ $row->jenis }}</span>
                                                @else
                                                    <span class="badge bg-danger">{{ $row->jenis }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $row->description }}
                                            </td>
                                            <td>
                                                @if ($row->status == 'Pending')
                                                    <span class="badge bg-warning">{{ $row->status }}</span>
                                                @elseif ($row->status == 'Disetujui')
                                                    <span class="badge bg-primary">{{ $row->status }}</span>
                                                @else
                                                    <span class="badge bg-danger">{{ $row->status }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($row->status == 'Pending')
                                                    <button type="button" class="btn approval btn-primary"
                                                        data-id="{{ $row->id }}">
                                                        <i class="fas fa-check" aria-hidden="true"></i> Setujui
                                                    </button>
                                                    <button type="button" class="btn btn-danger reject"
                                                        data-id="{{ $row->id }}"><i class="fas fa-times"></i>
                                                        Tolak</button>
                                                @elseif ($row->status == 'Disetujui')
                                                    <button type="button" class="btn btn-danger reject"
                                                        data-id="{{ $row->id }}"><i class="fas fa-times"></i>
                                                        Tolak</button>
                                                @else
                                                    <button type="button" class="btn approval btn-primary"
                                                        data-id="{{ $row->id }}">
                                                        <i class="fas fa-check" aria-hidden="true"></i> Setujui
                                                    </button>
                                                @endif
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

            $(document).on('click', '.approval', function() {
                var id = $(this).data("id");
                var url = "{{ route('main.approve') }}";
                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: 'Data yang sudah diapprove tidak dapat dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Setujui',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
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
                                    text: data.message,
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
            $(document).on('click', '.reject', function() {
                var id = $(this).data("id");
                var url = "{{ route('main.reject') }}";
                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: 'Data yang sudah ditolak tidak dapat dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Tolak',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
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
                                    text: data.message,
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
