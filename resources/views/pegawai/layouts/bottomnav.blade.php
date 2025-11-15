<div class="appBottomMenu">
    <a href="{{ route('pegawai.home') }}" class="item {{ request()->routeIs('pegawai.home') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="home-outline" role="img" class="md hydrated" aria-label="file tray full outline"></ion-icon>
            <strong>Home</strong>
        </div>
    </a>
    <a href="{{ route('pegawai.histori') }}" class="item {{ request()->routeIs('pegawai.histori') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="document-text-outline" role="img" class="md hydrated"
                aria-label="document text outline"></ion-icon>
            <strong>Histori</strong>
        </div>
    </a>
  
    <a href="{{ route('pegawai.absen') }}" class="item ">
        <div class="col">
            <div class="action-button large">
                <ion-icon name="camera" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
            </div>
        </div>
    </a>
    <a href="{{ route('pegawai.izin') }}" class="item {{ request()->routeIs('pegawai.izin') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="calendar-outline" role="img" class="md hydrated"
                aria-label="calendar outline"></ion-icon>
            <strong>Izin</strong>
        </div>
    </a>
    <a href="{{ route('pegawai.profile') }}" class="item">
        <div class="col">
            <ion-icon name="people-outline" role="img" class="md hydrated" aria-label="people outline"></ion-icon>
            <strong>Profile</strong>
        </div>
    </a>
</div>
