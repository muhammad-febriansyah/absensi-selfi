@extends('admin.layouts.main')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <a href="{{ route('main.absen') }}" class="btn btn-danger mb-3"><i class="fas fa-sync-alt"
                                    aria-hidden="true"></i> Kembali</a>

                            <center>
                                @if ($data->foto_in != null)
                                    <img src="{{ asset('storage/' . $data->foto_in) }}" class="img img-fluid img-thumbnail"
                                        width="200px" height="200px">
                                @else
                                    <img src="{{ asset('pria.png') }}" width="200px" height="200px" class="img img-fluid"
                                        alt="">
                                @endif
                            </center>
                            <br>
                            <div class="row">
                                <div class="col-6">
                                    <table class="table table-hover table-bordered">
                                        <tr>
                                            <td align="center" class="bg-primary text-white" colspan="2">Informasi
                                                Pegawai</td>
                                        </tr>
                                        <tr>
                                            <td>NIK</td>
                                            <td>{{ $data->user->nik }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nama</td>
                                            <td>{{ $data->user->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>{{ $data->user->email }}</td>
                                        </tr>
                                        <tr>
                                            <td>Jabatan</td>
                                            <td>{{ $data->user->jabatan->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Lokasi Penempatan</td>
                                            <td>{{ $data->user->radiusKantor->lokasiPenempatan->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Jam Kerja</td>
                                            <td>{{ date('g:i A', strtotime($data->user->jamKerja->in)) }} -
                                                {{ date('g:i A', strtotime($data->user->jamKerja->out)) }}</td>
                                        </tr>

                                    </table>
                                </div>
                                <div class="col-6">
                                    <table class="table table-hover table-bordered">
                                        <tr>
                                            <td align="center" class="bg-primary text-white" colspan="2">Informasi
                                                Absensi Pegawai</td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Absen</td>
                                            <td>{{ date('d M Y g:i A', strtotime($data->dateout ?? '')) }}</td>
                                        </tr>


                                    </table>
                                </div>
                            </div>
                            <div id="map" style="height: 300px; margin-top: 20px;" class="img-thumbnail">
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
    <script>
        var map = L.map('map').setView([{{ $data->latout }}, {{ $data->longout }}],
        12); // Initial view (will update later)

        var googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
        }).addTo(map);
        const marker = L.marker([{{ $data->latout }}, {{ $data->longout }}]).addTo(map)
            .bindPopup('<b>Lokasi Absensi : </b><br />{{ $data->user->name }}.').openPopup();
        const circle = L.circle([{{ $data->user->radiusKantor->lat }}, {{ $data->user->radiusKantor->long }}], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: {{ $data->user->radiusKantor->radius }}
        }).addTo(map);
    </script>
@endsection
