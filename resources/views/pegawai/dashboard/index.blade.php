@extends('pegawai.layouts.main')
@section('content')
    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="section" id="user-section">
            <div id="user-detail">
                <div class="avatar mr-2">
                    @if (Auth::user()->image != null)
                        <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="Foto profil" class="imaged w64 rounded">
                    @else
                        <img src="{{ asset('pria.png') }}" alt="Avatar default" class="imaged w64 rounded">
                    @endif
                </div>
                <div id="user-info" class="mb-2">
                    <h3 id="user-name" class="mb-1">{{ Auth::user()->name }}</h3>
                    <span id="user-role">{{ Auth::user()->jabatan->name }}</span>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-start mt-2">
                <div class="text-white">
                    <div class="h5 mb-1">Halo, {{ strtok(Auth::user()->name, ' ') }} 👋</div>
                    <div class="small" style="opacity:.85;">
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </div>
                </div>
                <div class="text-right">
                    <div id="clock" class="text-white h4 mb-0">--:--</div>
                    <div class="small text-white-50">WIB</div>
                </div>
            </div>
        </div>

        <div class="section" id="menu-section">
            <div class="card">
                <div class="card-body text-center">
                    <div class="list-menu">

                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="{{ route('pegawai.cuti') }}" class="danger" style="font-size: 40px;">
                                    <ion-icon name="calendar"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Cuti</span>
                            </div>
                        </div>

                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="{{ route('pegawai.lokasi') }}" class="orange" style="font-size: 40px;">
                                    <ion-icon name="location"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                Lokasi
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="{{ route('pegawai.histori') }}" class="primary" style="font-size: 40px;">
                                    <ion-icon name="time-outline"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                Histori
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a class="primary" style="font-size: 40px;" href="{{ route('pegawai.logout') }}"
                                    onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                    <ion-icon name="log-out"></ion-icon>
                                </a>
                                <form id="logout-form" action="{{ route('pegawai.logout') }}" method="POST">
                                    @csrf
                                </form>

                            </div>
                            <div class="menu-name">
                                Logout
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section mt-2" id="presence-section">
            <div class="todaypresence">
                <div class="row">
                    <div class="col-6">
                        <a href="{{ route('pegawai.absen') }}" class="text-white" style="text-decoration:none;">
                        <div class="card gradasigreen shadow-sm">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="presencedetail">
                                        <h4 class="presencetitle">Absen Masuk</h4>
                                        <br>
                                        <br>
                                        @php $masukToday = $masuk->first(); @endphp
                                        @if($checkmasuk > 0)
                                            <span class="badge badge-light">Sudah Absen</span>
                                            <div class="text-white mt-1" style="opacity:.95;">
                                                Jam: {{ $masukToday ? \Carbon\Carbon::parse($masukToday->datein)->format('H:i') : '-' }}
                                                @if($masukToday && $masukToday->masuk === 'Terlambat')
                                                    <span class="badge badge-warning ml-1">Terlambat</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="badge badge-warning">Belum Absen</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('pegawai.absen') }}" class="text-white" style="text-decoration:none;">
                        <div class="card gradasired shadow-sm">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="presencedetail">
                                        <h4 class="presencetitle">Absen Pulang</h4>
                                        <br>
                                        <br>
                                        @php $pulangToday = $pulang->first(); @endphp
                                        @if($checkpulang > 0)
                                            <span class="badge badge-light">Sudah Absen</span>
                                            <div class="text-white mt-1" style="opacity:.95;">
                                                Jam: {{ $pulangToday ? \Carbon\Carbon::parse($pulangToday->dateout)->format('H:i') : '-' }}
                                            </div>
                                        @else
                                            <span class="badge badge-warning">Belum Absen</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="rekappresence">

                <div class="row">
                 
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence green">
                                        <ion-icon name="document-text"></ion-icon>
                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="rekappresencetitle">Izin</h4>
                                        <span class="rekappresencedetail">{{ $izin }} Hari</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence warning">
                                        <ion-icon name="sad"></ion-icon>
                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="rekappresencetitle">Sakit</h4>
                                        <span class="rekappresencedetail">{{ $sakit }} Hari</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                </div>
              
            </div>
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
                            @forelse ($masuk as $row)
                                <li>
                                    <div class="item">
                                        <div class="icon-box bg-primary">
                                            <ion-icon name="log-in-outline" role="img" class="md hydrated" aria-label="log in outline"></ion-icon>
                                        </div>
                                        <div class="in">
                                            <div>{{ date('d F Y g:i A', strtotime($row->datein)) }}</div>
                                            @if($row->masuk === 'Terlambat')
                                                <span class="badge badge-warning ml-1">Terlambat</span>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li>
                                    <div class="item">
                                        <div class="in">
                                            <div>Belum ada histori absen masuk.</div>
                                        </div>
                                    </div>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel">
                        <ul class="listview image-listview">
                            @forelse ($pulang as $row)
                                <li>
                                    <div class="item">
                                        <div class="icon-box bg-primary">
                                            <ion-icon name="log-out-outline" role="img" class="md hydrated" aria-label="log out outline"></ion-icon>
                                        </div>
                                        <div class="in">
                                            <div>{{ date('d F Y g:i A', strtotime($row->dateout)) }}</div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li>
                                    <div class="item">
                                        <div class="in">
                                            <div>Belum ada histori absen pulang.</div>
                                        </div>
                                    </div>
                                </li>
                            @endforelse
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->


    <!-- App Bottom Menu -->
    @include('pegawai.layouts.bottomnav')
    <!-- * App Bottom Menu -->
    <script>
        function pad(n) { return n < 10 ? '0' + n : n; }
        function updateClock() {
            const now = new Date();
            const h = pad(now.getHours());
            const m = pad(now.getMinutes());
            const el = document.getElementById('clock');
            if (el) el.textContent = `${h}:${m}`;
        }
        document.addEventListener('DOMContentLoaded', function() {
            updateClock();
            setInterval(updateClock, 30000);
        });
    </script>
@endsection
