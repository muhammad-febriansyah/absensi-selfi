@extends('pegawai.layouts.main')
@section('content')
    <!-- App Capsule -->
    <div class="appHeader bg-primary text-light mb-5">
        <div class="left">
            <a href="{{ route('pegawai.home') }}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Data Cuti Pegawai</div>
        <div class="right"></div>
    </div>
    <br>
    <div id="appCapsule" class="mb-5">
        <div class="section full mt-5">
            <div class="wide-block pt-2 pb-2">
                <div class="card">
                    <div class="card-body table-responsive">
                        <a href="{{ route('pegawai.createcuti') }}" class="btn btn-primary mb-5"><ion-icon
                                name="add-outline"></ion-icon> Form Cuti Pegawai</a>
                        <ul class="listview image-listview">
                            @foreach ($data as $row)
                                <li>
                                    <a href="{{ route('pegawai.detailcuti', $row->id) }}">
                                        <div class="item">
                                            <div class="in">
                                                <div>{{ date('d F Y ', strtotime($row->date)) }}</div>
                                                @if ($row->status == 'Pending')
                                                    <span class="badge badge-warning">{{ $row->status }}</span>
                                                @elseif($row->status == 'Disetujui')
                                                    <span class="badge badge-primary">{{ $row->status }}</span>
                                                @else
                                                    <span class="badge badge-danger">{{ $row->status }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- App Bottom Menu -->
    @include('pegawai.layouts.bottomnav')
@endsection
