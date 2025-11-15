@extends('pegawai.layouts.main')
@section('content')
    <!-- App Capsule -->
    <div class="appHeader bg-primary text-light mb-5">
        <div class="left">
            <a href="{{ route('pegawai.home') }}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Edit Profil {{ Auth::user()->name }}</div>
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
                            <div class="form-group boxed">
                                <div class="input-wrapper">
                                    <input type="number" min="0" name="nik" class="form-control"
                                        value="{{ $data->nik }}" id="email1" placeholder="NIK">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>
                            <div class="form-group boxed">
                                <div class="input-wrapper">
                                    <input type="text" name="name" class="form-control" value="{{ $data->name }}"
                                        id="email1" placeholder="Nama Lengkap">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>
                            <div class="form-group boxed">
                                <div class="input-wrapper">
                                    <input type="email" name="email" class="form-control" value="{{ $data->email }}"
                                        id="email1" placeholder="Email address">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>

                            <div class="form-group boxed">
                                <div class="input-wrapper">
                                    <input type="password" name="password" class="form-control" id="password1"
                                        placeholder="Kosongkan jika tidak diubah...">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>
                            <div class="form-group boxed">
                                <div class="input-wrapper">
                                    <select name="jabatan_id" id="" class="form-control">
                                        <option value="">Pilih Jabatan</option>
                                        @foreach ($jabatan as $j)
                                            @if ($data->jabatan_id == $j->id)
                                                <option value="{{ $j->id }}" selected>{{ $j->name }}</option>
                                            @else
                                                <option value="{{ $j->id }}">{{ $j->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>
                            <div class="form-group boxed">
                                <div class="input-wrapper">
                                    <select name="jam_kerja_id" id="" class="form-control">
                                        <option value="">Pilih Jam Kerja</option>
                                        @foreach ($jamkerja as $j)
                                            @if ($data->jam_kerja_id == $j->id)
                                                <option value="{{ $j->id }}" selected>{{ $j->in }} -
                                                    {{ $j->out }}
                                                </option>
                                            @else
                                                <option value="{{ $j->id }}">{{ $j->in }} -
                                                    {{ $j->out }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>
                            <div class="form-group boxed">
                                <div class="input-wrapper">
                                    <select name="radius_kantor_id" id="" class="form-control">
                                        <option value="">Pilih Lokasi</option>
                                        @foreach ($lokasi as $j)
                                            @if ($data->radiusKantor->lokasi_penempatan_id == $j->lokasi_penempatan_id)
                                                <option value="{{ $j->id }}" selected>
                                                    {{ $j->lokasiPenempatan->name }}</option>
                                            @else
                                                <option value="{{ $j->id }}">{{ $j->lokasiPenempatan->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>
                            <div class="form-group mt-4">
                                <center>
                                    @if ($data->image != '')
                                        <img id="blah" class='img-fluid mb-3' width='280'
                                            src="{{ asset('storage/' . $data->image) }}" alt="your image" />
                                    @else
                                        <img id="blah" class='img-fluid mb-3' width='280'
                                            src="{{ asset('nofoto.jpg') }}" alt="your image" />
                                    @endif
                                </center>
                                <input type="file" name="image" accept="image/*" class="form-control mb-3 bersih"
                                    onchange="readURL(this);" aria-describedby="inputGroupFileAddon01">
                                <span class="badge badge-warning mb-3"><strong>Informasi</strong> Input
                                    Foto
                                    Maksimal
                                    3mb !</span>
                            </div>
                            <button type="submit" class="btn btn-primary rounded-3 btn-block btn-lg">Simpan</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- App Bottom Menu -->
    @include('pegawai.layouts.bottomnav')
    <script>
        $(document).ready(function() {
            $('#form').on('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission
                let formData = new FormData(this); // Collect form data
                $.ajax({
                    url: "{{ route('pegawai.updateprofile') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Informasi',
                            text: response.message,
                            showConfirmButton: true,
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr);

                        let errors = xhr.responseJSON.errors;
                        let errorMessage = '';
                        for (let key in errors) {
                            errorMessage += errors[key][0] + '<br>';
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            html: errorMessage,
                            showConfirmButton: true,
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
@endsection
