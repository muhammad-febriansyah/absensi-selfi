@extends('pegawai.layouts.main')
@section('content')
    <!-- App Capsule -->
    <div id="appCapsule" class="pt-0">

        <div class="login-form mt-1">
            <div class="section">
                <img src="{{ asset('ic.png') }}" alt="image" class="form-image">
            </div>
            <div class="section mt-1 mb-5">
                <h1>Selamat datang di E-Absensi 👋</h1>
                <h4>Silahkan login terlebih dahulu! </h4>
            </div>
            <div class="section mt-1 mb-5">
                <form id="form">
                    @csrf
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="email" name="email" class="form-control" id="email1"
                                placeholder="Email address">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="password" name="password" class="form-control" id="password1"
                                placeholder="Password">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-links mt-2">
                        <div>
                            Belum punya akun? <a href="{{ route('home.register') }}">Registrasi disini!</a>
                        </div>
                    </div>

                    <div class="form-button-group">
                        <button type="submit" class="btn btn-primary btn-block btn-lg">Log in</button>
                    </div>

                </form>
            </div>
        </div>


    </div>
    <!-- * App Capsule -->
    <script>
        $(document).ready(function() {
            $('#form').on('submit', function(e) {
                e.preventDefault();
                var url = '{{ route('home.checklogin') }}';
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        console.log(response); // Debugging line
                        if (response.success) {
                            Swal.fire({
                                title: 'Informasi',
                                text: "Login Berhasil!",
                                icon: 'success',
                                confirmButtonText: 'Okay'
                            }).then(function() {
                                window.location.href = "{{ route('pegawai.home') }}";
                            });
                        } else {
                            Swal.fire({
                                title: "Informasi",
                                text: "Email atau password anda salah!",
                                icon: "warning",
                                confirmButtonColor: "#038edc"
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr); // Debugging line
                        Swal.fire({
                            title: 'Error!',
                            text: 'An unexpected error occurred.',
                            icon: 'error',
                            confirmButtonText: 'Okay'
                        });
                    }
                });
            });
        });
    </script>
@endsection
