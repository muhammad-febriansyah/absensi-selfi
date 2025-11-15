@extends('pegawai.layouts.main')
@section('content')
    <!-- App Capsule -->
    <div class="appHeader bg-primary text-light mb-5">
        <div class="left">
            <a href="{{ route('pegawai.home') }}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Histori Data Absensi</div>
        <div class="right"></div>
    </div>
    <br>
    <div id="appCapsule" class="mb-5">
        <div class="section full mt-5">
            <div class="wide-block pt-2 pb-2">
                <div class="presencetab mt-2">
                    <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                        <ul class="nav nav-tabs style1" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                                    Histori Absensi Masuk
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                                    Histori Absensi Pulang
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content mt-2" style="margin-bottom:100px;">
                        <div class="tab-pane fade show active" id="home" role="tabpanel">
                            <ul class="listview image-listview">
                                @foreach ($masuk as $row)
                                    <li>
                                        <div class="item">
                                            <div class="icon-box bg-primary">
                                                <ion-icon name="finger-print-outline" role="img" class="md hydrated"
                                                    aria-label="camera outline"></ion-icon>
                                            </div>
                                            <div class="in">
                                                <div>{{ date('d F Y g:i A', strtotime($row->datein)) }}</div>
                                                @if ($row->masuk == 'Masuk')
                                                    <span class="badge bg-primary">{{ $row->masuk }}</span>
                                                @else
                                                    <span class="badge bg-danger">{{ $row->masuk }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel">
                            <ul class="listview image-listview">
                                @foreach ($pulang as $row)
                                    <li>
                                        <div class="item">
                                            <div class="icon-box bg-primary">
                                                <ion-icon name="finger-print-outline" role="img" class="md hydrated"
                                                    aria-label="camera outline"></ion-icon>
                                            </div>
                                            <div class="in">
                                                <div>{{ date('d F Y g:i A', strtotime($row->dateout)) }}</div>
                                                @if ($row->lembur === '1')
                                                    <span class="badge bg-primary">Lembur</span>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- App Bottom Menu -->
    @include('pegawai.layouts.bottomnav')
@endsection
