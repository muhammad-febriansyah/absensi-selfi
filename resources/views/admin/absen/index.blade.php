@extends('admin.layouts.main')

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid mt-3">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <!-- Form Filter -->
                            <form method="GET" class="mb-5">
                                <div class="input-group">
                                    <!-- Tanggal Mulai -->
                                    <input type="text" autocomplete="off" placeholder="Pilih Tanggal Mulai"
                                        class="form-control date" name="start_date" value="{{ request('start_date') }}" />
                                    <!-- Tanggal Selesai -->
                                    <input type="text" autocomplete="off" placeholder="Pilih Tanggal Selesai"
                                        class="form-control date" name="end_date" value="{{ request('end_date') }}" />
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i>
                                        Filter</button>
                                </div>
                            </form>

                            <!-- Tab untuk Absensi Masuk dan Pulang -->
                            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Absensi Masuk</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " data-bs-toggle="tab" href="#telat" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Absensi Terlambat</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                        <span class="d-none d-sm-block">Absensi Pulang</span>
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content p-3 text-muted">
                                <div class="tab-pane active" id="home1" role="tabpanel">
                                    <table class="table table-bordered table-hover" id="dt">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Foto</th>
                                                <th>Pegawai</th>
                                                <th>Penempatan</th>
                                                <th>Tgl</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($masuk as $in)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>
                                                        <img src="{{ asset('storage/' . $in->foto_in) }}" alt=""
                                                            width="80px" height="80px"
                                                            class="img img-fluid img-thumbnail">
                                                    </td>
                                                    <td>{{ $in->user->name }}</td>
                                                    <td>{{ $in->user->radiusKantor->lokasiPenempatan->name }}</td>
                                                    <td>{{ date('d F Y g:i A', strtotime($in->datein)) }}</td>
                                                    <td>
                                                        <a href="{{ route('main.detailAbsen', $in->id) }}"
                                                            class="btn btn-primary"><i class="fa fa-eye"
                                                                aria-hidden="true"></i> Detail</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="telat" role="tabpanel">
                                    <table class="table table-bordered table-hover" id="dt">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Foto</th>
                                                <th>Pegawai</th>
                                                <th>Penempatan</th>
                                                <th>Keterangan</th>
                                                <th>Tgl</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($telat as $telat)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>
                                                        <img src="{{ asset('storage/' . $telat->foto_in) }}" alt=""
                                                            width="80px" height="80px"
                                                            class="img img-fluid img-thumbnail">
                                                    </td>
                                                    <td>{{ $telat->user->name }}</td>
                                                    <td>{{ $telat->user->radiusKantor->lokasiPenempatan->name }}</td>
                                                    <td>{{ $telat->keterangan }}</td>
                                                    <td>{{ date('d F Y g:i A', strtotime($telat->datein)) }}</td>
                                                    <td>
                                                        <a href="{{ route('main.detailAbsenPulang', $telat->id) }}"
                                                            class="btn btn-primary"><i class="fa fa-eye"
                                                                aria-hidden="true"></i> Detail</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="profile1" role="tabpanel">
                                    <table class="table table-bordered table-hover" id="dt">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Foto</th>
                                                <th>Pegawai</th>
                                                <th>Penempatan</th>
                                                <th>Keterangan</th>
                                                <th>Tgl</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($pulang as $out)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>
                                                        <img src="{{ asset('storage/' . $out->foto_in) }}" alt=""
                                                            width="80px" height="80px"
                                                            class="img img-fluid img-thumbnail">
                                                    </td>
                                                    <td>{{ $out->user->name }}</td>
                                                    <td>{{ $out->user->radiusKantor->lokasiPenempatan->name }}</td>
                                                    <td>
                                                        @if ($out->lembur === 1)
                                                            Lembur
                                                        @else
                                                            Tidak ada keterangan.
                                                        @endif
                                                    </td>
                                                    <td>{{ date('d F Y g:i A', strtotime($out->datein)) }}</td>
                                                    <td>
                                                        <a href="{{ route('main.detailAbsenPulang', $out->id) }}"
                                                            class="btn btn-primary"><i class="fa fa-eye"
                                                                aria-hidden="true"></i> Detail</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div><!-- end card-body -->
                    </div><!-- end card -->
                </div>
            </div>
        </div>
        @include('admin.layouts.footer')
        <script>
            $(document).ready(function() {
                // Inisialisasi Datepicker dengan format yang benar
                $('.date').datepicker({
                    format: 'yyyy-mm-dd', // Pastikan formatnya sesuai dengan format yang diterima di controller
                    autoclose: true,
                    todayHighlight: true
                });
            });
        </script>
    </div>
@endsection
