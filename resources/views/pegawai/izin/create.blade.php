@extends('pegawai.layouts.main')
@section('content')
    <!-- App Capsule -->
    <div class="appHeader bg-primary text-light mb-5">
        <div class="left">
            <a href="{{ route('pegawai.izin') }}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Form Izin/Sakit</div>
        <div class="right"></div>
    </div>
    <br>
    <div id="appCapsule" class="mb-5">
        <div class="section full mt-5">
            <div class="wide-block pt-2 pb-2">
                <div class="card">
                    <div class="card-body table-responsive">
                        <form id="form" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tanggal</label>
                                <input type="text" name="date" autocomplete="off" class="form-control"
                                    placeholder="Pilih Tanggal" id="datepicker" aria-describedby="emailHelp" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Jenis</label>
                                <select name="jenis" class="form-control" id="">
                                    <option value="">Pilih</option>
                                    <option value="Izin">Izin</option>
                                    <option value="Sakit">Sakit</option>
                                </select>
                            </div>
                            <div class="form-group mb-5">
                                <label for="exampleInputEmail1">Keterangan</label>
                                <textarea name="description" placeholder="Keterangan" id="" class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="dusun">Foto/Gambar</label>
                                <center>
                                    <img id="blah" class='img-fluid mb-3' width='280'
                                        src="{{ asset('nofoto.jpg') }}" alt="your image" />
                                </center>
                                <input type="file" name="image" accept="image/*" class="form-control mb-3 bersih"
                                    onchange="readURL(this);" aria-describedby="inputGroupFileAddon01">
                                <span class="badge badge-warning mb-3"><strong>Informasi</strong> Input
                                    Logo
                                    Maksimal
                                    3mb !</span>
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
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd', // Set format to yy-mm-dd
                autoclose: true,
                todayHighlight: true
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#form').submit(function(e) {
                e.preventDefault();
                var url = $(this).attr("action");
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('pegawai.storeizin') }}',
                    data: formData,
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,

                    beforeSend: function() {
                        // Show image container
                        Swal.fire({
                            title: 'Loading',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            willOpen: () => {
                                Swal.showLoading();
                            }
                        })
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Informasi',
                            text: "Pengajuan izin/sakit berhasil terkirim!"
                        }).then(function() {
                            location.reload(); // Reload the page
                        });
                    },
                    error: function(response) {
                        Swal.fire({
                            title: 'Informasi',
                            text: response.responseJSON.message,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }
                });
            });
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#blah').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <!-- App Bottom Menu -->
    @include('pegawai.layouts.bottomnav')
@endsection
