@extends('pegawai.layouts.main')
@section('content')
    <!-- App Capsule -->
    <div class="appHeader bg-primary text-light mb-5">
        <div class="left">
            <a href="{{ route('pegawai.cuti') }}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Form Cuti Pegawai</div>
        <div class="right"></div>
    </div>
    <br>
    <div id="appCapsule" class="mb-5">
        <div class="section full mt-5">
            <div class="wide-block pt-2 pb-2">
                <div class="card">
                    <div class="card-body table-responsive">
                        <form id="form">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tanggal Mulai</label>
                                <input type="text" name="start" autocomplete="off" class="form-control date" placeholder="Pilih Tanggal Mulai Cuti" id="datepicker" aria-describedby="emailHelp"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tanggal Selesai</label>
                                <input type="text" name="end" autocomplete="off" class="form-control date" placeholder="Pilih Tanggal Selesai Cuti" id="datepicker" aria-describedby="emailHelp"
                                    required>
                            </div>
                            <div class="form-group mb-5">
                                <label for="exampleInputEmail1">Keterangan</label>
                                <textarea name="description" id="" class="form-control" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100"><ion-icon name="send-outline"></ion-icon>
                                Kirim</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.date').datepicker({
                format: 'yyyy-mm-dd', // Set format to yy-mm-dd
                autoclose: true,
                todayHighlight: true
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#form').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('pegawai.storecuti') }}',
                    data: $(this).serialize(),
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Tunggu Sebentar...',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            showConfirmButton: false,
                            onOpen: () => {
                                Swal.showLoading()
                            }
                        });
                    },
                    success: function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Informasi',
                            text: "Pengajuan Cuti Pegawai berhasil terkirim!"
                        }).then(function() {
                            location.reload(); // Reload the page
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                        
                        var errorMessage = xhr.status + ': ' + xhr.statusText;
                        Swal.fire({
                            icon: 'error',
                            title: 'Informasi',
                            text: 'Ada kesalahan sistem: ' + errorMessage
                        });
                    }
                });
            });
        });
    </script>
    <!-- App Bottom Menu -->
    @include('pegawai.layouts.bottomnav')
@endsection