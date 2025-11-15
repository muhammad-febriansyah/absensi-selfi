@extends('pegawai.layouts.main')
@section('content')
   
    <!-- App Capsule -->
    <div class="appHeader bg-primary text-light mb-5">
        <div class="left">
            <a href="{{ route('pegawai.cuti') }}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Detail Cuti Pegawai</div>
        <div class="right"></div>
    </div>
    <br>
    <div id="appCapsule" class="mb-5">
        <div class="section full mt-5">
            <div class="wide-block pt-2 pb-2">
                <div class="card">
                    <div class="card-body table-responsive">
                        <table class="table table-hover table-bordered">
                            <tr>
                                <td>Tanggal Mulai</td>
                                <td>{{ date("d M Y", strtotime($data->start)) }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Selesai</td>
                                <td>{{ date("d M Y", strtotime($data->end)) }}</td>
                            </tr>
                            <tr>
                                <td>Jenis Pengajuan</td>
                                <td>{{ $data->jenis }}</td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td>{{ $data->description }}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>
                                    {{ $data->status }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- App Bottom Menu -->
    @include('pegawai.layouts.bottomnav')
  
@endsection
