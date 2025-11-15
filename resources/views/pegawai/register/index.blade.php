@extends('pegawai.layouts.main')
@section('content')
    <!-- App Capsule -->
    <div id="appCapsule" class="pt-0">

        <div class="login-form mt-1">

            <div class="section mt-1 mb-5">
                <h1>Registrasi Akun Pegawai 👋</h1>
                {{-- <h4>,isikan form ini dengan benar! </h4> --}}
            </div>
            <div class="section mt-1 mb-5">
                <form id="form">
                    @csrf
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="number" min="0" name="nik" class="form-control" required id="email1"
                                placeholder="NIK">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="text" name="name" class="form-control" required id="email1"
                                placeholder="Nama Lengkap">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="email" name="email" class="form-control" required id="email1"
                                placeholder="Email address">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="password" name="password" required class="form-control" required id="password1"
                                placeholder="Password">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <select name="jabatan_id" id="" class="form-control" required>
                                <option value="">Pilih Jabatan</option>
                                @foreach ($jabatan as $j)
                                    <option value="{{ $j->id }}">{{ $j->name }}</option>
                                @endforeach
                            </select>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <select name="jam_kerja_id" id="" class="form-control" required>
                                <option value="">Pilih Jam Kerja</option>
                                @foreach ($jamkerja as $j)
                                    <option value="{{ $j->id }}">{{ $j->in }} - {{ $j->out }}</option>
                                @endforeach
                            </select>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <select name="lokasi_id" id="" class="form-control" required>
                                <option value="">Pilih Lokasi</option>
                                @foreach ($lokasi as $j)
                                    <option value="{{ $j->id }}">{{ $j->lokasiPenempatan->name }}</option>
                                @endforeach
                            </select>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                    <div class="form-links mt-2">
                        <div class="text-muted float-right">
                            Sudah punya akun? <a href="{{ route('home') }}">Login disini!</a>
                        </div>
                    </div>

                    <div class="form-button-group">
                        <button type="submit" class="btn btn-primary rounded-3 btn-block btn-lg">Register</button>
                    </div>

                </form>
            </div>
        </div>


    </div>
    <!-- * App Capsule -->
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#form').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('home.saveregister') }}',
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
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Informasi',
                                text: "Terima kasih,data anda berhasil disimpan!"
                            }).then(function() {
                                location.reload(); // Reload the page
                            });
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Informasi',
                                text: "Email ini sudah digunakan!"
                            });
                        }
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
@endsection
