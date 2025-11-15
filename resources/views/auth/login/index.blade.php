@extends('auth.layouts.main')
@section('content')
    <div class="d-flex flex-column min-vh-100 px-3 pt-4">
        <div class="row justify-content-center my-auto">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="text-center mt-2">
                            <img src="{{ asset('ic.png') }}" width="80px" alt="">
                            <h5>Selamat datang kembali !</h5>
                            <p class="text-muted">Silahkan login untuk melanjutkan ke E-Absensi.</p>
                        </div>
                        <div class="p-2 mt-4">
                            <form id="loginForm" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" for="username">Email</label>
                                    <div class="position-relative input-custom-icon">
                                        <input type="email" name="email" class="form-control" id="username"
                                            placeholder="Enter username">
                                        <span class="bx bx-user"></span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="password-input">Password</label>
                                    <div class="position-relative auth-pass-inputgroup input-custom-icon">
                                        <span class="bx bx-lock-alt"></span>
                                        <input type="password" name="password" class="form-control" id="password-input"
                                            placeholder="Enter password">
                                        <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0"
                                            id="password-addon">
                                            <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="form-check py-1">
                                    <input type="checkbox" class="form-check-input" id="auth-remember-check">
                                    <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                </div>

                                <div class="mt-3">
                                    <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Log
                                        In</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

            </div><!-- end col -->
        </div><!-- end row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="text-center p-4">
                    <p>©
                        <script>
                            document.write(new Date().getFullYear())
                        </script> E-Absensi.
                    </p>
                </div>
            </div>
        </div>

    </div>
    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();
                var url = '{{ route('checklogin') }}';
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
                                window.location.href = "{{ route('main.dashboard') }}";
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
