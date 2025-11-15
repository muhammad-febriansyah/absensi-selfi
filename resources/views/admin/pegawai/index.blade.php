@extends('admin.layouts.main')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <a href="{{ route('main.pegawai') }}" class="btn btn-info mb-3"><i class="fas fa-sync-alt"
                                    aria-hidden="true"></i> Refresh</a>

                            <table class="table table-bordered table-hover" id="dt">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Foto</th>
                                        <th>Nik</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($data as $row)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>
                                                @if ($row->image != null)
                                                    <img src="{{ asset('storage/' . $row->image) }}"
                                                        class="img img-fluid rounded-circle" width="80px" height="80px">
                                                @else
                                                    <img src="{{ asset('pria.png') }}" width="80px" height="80px"
                                                        class="img img-fluid" alt="">
                                                @endif
                                            </td>
                                            <td>{{ $row->nik }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->email }}</td>
                                            <td>
                                                <a href="{{ route('main.detailpegawai',$row->id) }}" class="btn btn-success"><i class="fa fa-eye" aria-hidden="true"></i> Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
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
