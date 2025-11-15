@extends('admin.layouts.main')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <a href="{{ route('main.pegawai') }}" class="btn btn-danger mb-3"><i class="fas fa-sync-alt"
                                    aria-hidden="true"></i> Kembali</a>

                            <center class="mb-5">
                                @if ($data->image != null)
                                    <img src="{{ asset('storage/' . $data->image) }}" class="img img-fluid rounded-circle"
                                        width="200px" height="200px">
                                @else
                                    <img src="{{ asset('pria.png') }}" width="200px" height="200px" class="img img-fluid"
                                        alt="">
                                @endif
                            </center>
                            <table class="table table-hover table-bordered">
                                <tr>
                                    <td>NIK</td>
                                    <td>{{ $data->nik }}</td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td>{{ $data->name }}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>{{ $data->email }}</td>
                                </tr>
                                <tr>
                                    <td>Jabatan</td>
                                    <td>{{ $data->jabatan->name }}</td>
                                </tr>
                                <tr>
                                    <td>Lokasi Penempatan</td>
                                    <td>{{ $data->radiusKantor->lokasiPenempatan->name }}</td>
                                </tr>
                                <tr>
                                    <td>Jam Kerja</td>
                                    <td>{{ date('g:i A', strtotime($data->jamKerja->in)) }} - {{ date('g:i A', strtotime($data->jamKerja->out)) }}</td>
                                </tr>

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
@endsection
