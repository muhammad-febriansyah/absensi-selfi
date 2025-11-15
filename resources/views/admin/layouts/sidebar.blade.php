<div class="vertical-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="{{ route('main.dashboard') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('ic.png') }}" alt="" height="26">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('ic.png') }}" alt="" height="90px" width="140px">
            </span>
        </a>

        <a href="{{ route('main.dashboard') }}" class="logo logo-light">
            <span class="logo-lg">
                <img src="{{ asset('ic.png') }}" alt="" height="30">
            </span>
            <span class="logo-sm">
                <img src="{{ asset('ic.png') }}" alt="" height="90px" width="140px">
                {{-- <img src="{{ asset('assets/images/logo-light-sm.png') }}" alt="" height="26"> --}}
            </span>
        </a>
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn">
        <i class="bx bx-menu align-middle"></i>
    </button>

    <div data-simplebar class="sidebar-menu-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">Dashboard</li>
                <li>
                    <a href="{{ route('main.dashboard') }}">
                        <i class="bx bx-home-alt icon nav-icon"></i>
                        <span class="menu-item" data-key="t-calendar">Dashboard</span>
                    </a>
                </li>


                <li class="menu-title" data-key="t-applications">Main Menu</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="bx bx-book icon nav-icon"></i>
                        <span class="menu-item" data-key="t-email">Master Data</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('main.jabatan') }}" data-key="t-inbox"> Jabatan</a></li>
                        <li><a href="{{ route('main.lokasi') }}" data-key="t-read-email"> Lokasi Penempatan</a></li>
                        <li><a href="{{ route('main.jamkerja') }}" data-key="t-read-email">Jam Kerja</a></li>
                        <li><a href="{{ route('main.radius') }}" data-key="t-read-email">Radius Kantor</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('main.pegawai') }}">
                        <i class="bx bxs-user-rectangle icon nav-icon"></i>
                        <span class="menu-item" data-key="t-calendar">Data Pegawai</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('main.absen') }}">
                        <i class="bx bx-fingerprint icon nav-icon"></i>
                        <span class="menu-item" data-key="t-calendar">Data Absensi</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('main.izin') }}">
                        <i class="bx bx-calendar icon nav-icon"></i>
                        <span class="menu-item" data-key="t-calendar">Data Izin/Sakit</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('main.cuti') }}">
                        <i class="bx bx-calendar-event icon nav-icon"></i>
                        <span class="menu-item" data-key="t-calendar">Data Cuti Pegawai</span>
                    </a>
                </li>


            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
<header class="ishorizontal-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{ route('main.dashboard') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-dark-sm.png') }}" alt="" height="26">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="28">
                    </span>
                </a>

                <a href="{{ route('main.dashboard') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-light-sm.png') }}" alt="" height="26">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="30">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 d-lg-none header-item" data-bs-toggle="collapse"
                data-bs-target="#topnav-menu-content">
                <i class="bx bx-menu align-middle"></i>
            </button>

            <!-- start page title -->
            <div class="page-title-box align-self-center d-none d-md-block">
                <h4 class="page-title mb-0">{{ $title }}</h4>
            </div>
            <!-- end page title -->

        </div>

        <div class="d-flex">

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item user text-start d-flex align-items-center"
                    id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ asset('pria.png') }}"
                        alt="Header Avatar">
                    <span
                        class="d-none d-xl-inline-block ms-2 fw-medium font-size-15">{{ auth()->user()->name }}</span>
                </button>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="p-3 border-bottom">
                        <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                        <p class="mb-0 font-size-11 text-muted">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"><i
                            class="mdi mdi-logout text-muted font-size-16 align-middle me-2"></i> <span
                            class="align-middle">Logout</span></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="topnav">

    </div>
</header>
