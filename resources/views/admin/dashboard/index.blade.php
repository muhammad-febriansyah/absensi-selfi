@extends('admin.layouts.main')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid mt-5">
                <div class="alert alert-info" role="alert">
                    Selamat datang <strong>{{ Auth::user()->name }}</strong> di E-Absensi.
                </div>
                <div class="row">
                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="font-size-15">Pegawai</h6>
                                        <h4 class="mt-3 pt-1 mb-0 font-size-22">{{ $pegawai }} </h4>
                                    </div>
                                    <div class="">
                                        <div class="avatar">
                                            <div class="avatar-title rounded bg-primary-subtle ">
                                                <i class="bx bx-user font-size-24 mb-0 text-primary"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="mb-0 font-size-15">Cuti</h6>
                                        <h4 class="mt-3 mb-0 font-size-22">{{ $cuti }} </h4>

                                    </div>

                                    <div class="">
                                        <div class="avatar">
                                            <div class="avatar-title rounded bg-primary-subtle ">
                                                <i class="bx bx-calendar-event font-size-24 mb-0 text-primary"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="mb-0 font-size-15">Izin</h6>
                                        <h4 class="mt-3 mb-0 font-size-22">{{ $izin }} </h4>
                                    </div>

                                    <div class="">
                                        <div class="avatar">
                                            <div class="avatar-title rounded bg-primary-subtle ">
                                                <i class="bx bx-food-menu font-size-24 mb-0 text-primary"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="mb-0 font-size-15">Sakit</h6>
                                        <h4 class="mt-3 mb-0 font-size-22">{{ $sakit }} </h4>
                                    </div>

                                    <div class="">
                                        <div class="avatar">
                                            <div class="avatar-title rounded bg-primary-subtle ">
                                                <i class="bx bxs-dizzy font-size-24 mb-0 text-primary"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- END ROW -->
                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered table-hover">

                                    <thead>
                                        <tr align="center">
                                            <th colspan="3" class="bg-primary text-white">Data Absensi Masuk Tanggal :
                                                {{ Carbon\Carbon::now()->format('d-m-Y') }}</th>
                                        </tr>
                                        <tr>
                                            <th>No</th>
                                            <th>Pegawai</th>
                                            <th>Tgl</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($masuk as $data)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $data->user->name }}</td>
                                                <td>{{ date('d F Y g:i A', strtotime($data->datein)) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered table-hover">

                                    <thead>
                                        <tr align="center">
                                            <th colspan="3" class="bg-primary text-white">Data Absensi Keluar Tanggal :
                                                {{ Carbon\Carbon::now()->format('d-m-Y') }}</th>
                                        </tr>
                                        <tr>
                                            <th>No</th>
                                            <th>Pegawai</th>
                                            <th>Tgl</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($pulang as $data)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $data->user->name }}</td>
                                                <td>{{ date('d F Y g:i A', strtotime($data->datein)) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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
