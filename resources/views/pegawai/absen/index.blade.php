@extends('pegawai.layouts.main')
@section('content')
    <style>
        #my_camera,
        #my_camera video {
            display: inline-block;
            width: 100% !important;
            margin: auto;
            height: auto !important;
            border-radius: 20px;
        }

        #map {
            border-radius: 20px;
        }
    </style>
    <!-- App Capsule -->
    <div class="appHeader bg-primary text-light mb-5">
        <div class="left">
            <a href="{{ route('pegawai.home') }}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Absensi Pegawai</div>
        <div class="right"></div>
    </div>
    <br>
    <div id="appCapsule" class="mb-5">
        <div class="section full mt-5">
            <div class="wide-block pt-2 pb-2">
                <div class="card">
                    <div class="card-body table-responsive">
                        <div class="alert alert-warning mb-3" role="alert">
                            <strong>Informasi!</strong> sebelum melakukan absensi harap tunggu sampai map lokasi anda
                            terdeteksi.
                        </div>
                        <div id="my_camera" style="width:480px; height:240px;border-radius: 20px"></div>
                        <input type="hidden" name="lat" id="latitude" readonly>
                        <input type="hidden" name="long" id="longitude" readonly>
                        <br>
                        <br>
                        @if ($check > 0)
                            <button type="submit" class="btn btn-success w-100" onclick="absenOut()"><i
                                    class="fa fa-camera-retro mr-1" aria-hidden="true"></i> Absen Pulang</button>
                        @else
                            <button type="submit" class="btn btn-primary w-100" onclick="take_snapshot()"><i
                                    class="fa fa-camera-retro mr-1" aria-hidden="true"></i> Absen Masuk</button>
                        @endif
                        <div id="map" style="height: 300px; margin-top: 20px;" class="img-thumbnail">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- App Bottom Menu -->
    @include('pegawai.layouts.bottomnav')
    <!-- * App Bottom Menu -->
    <script>
        window.onload = function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const long = position.coords.longitude;

                    // Set the latitude and longitude in the input fields
                    document.getElementById('latitude').value = lat;
                    document.getElementById('longitude').value = long;
                }, function(error) {
                    console.error("Error retrieving location: ", error);
                    alert("Unable to retrieve your location.");
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        };
        // Configure Webcam settings
        Webcam.set({
            width: 480, // Set a fixed width for the webcam feed
            height: 450,
            image_format: 'jpeg',
            jpeg_quality: 90
        });

        Webcam.attach('#my_camera');

        function take_snapshot() {
            Webcam.snap(function(data_uri) {
                var image = document.getElementById('my_camera');
                image.src = data_uri;

                // Send the image data to the server using jQuery AJAX
                $.ajax({
                    type: 'POST',
                    url: '{{ route('pegawai.saveabsen') }}',
                    data: JSON.stringify({
                        image: data_uri,
                        lat: document.getElementById('latitude').value,
                        long: document.getElementById('longitude').value
                    }),
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        if (data.status == 0) {
                            Swal.fire({
                                title: 'Success!',
                                text: data.message,
                                icon: 'success',
                                confirmButtonText: 'OK',

                            }).then(function() {
                                window.location.reload();
                            });
                        } else if (data.status == 1 || data.status == 2) {
                            // Show error message
                            Swal.fire({
                                title: 'Error!',
                                text: data.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        } else if (data.status == 3) {
                            Swal.fire({
                                title: 'Warning!',
                                text: data.message,
                                icon: 'warning',
                                confirmButtonText: 'OK',

                            }).then(function() {
                                window.location.reload();
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR);

                        Swal.fire({
                            title: 'Error!',
                            text: 'An unexpected error occurred.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        }

        function absenOut() {
            Webcam.snap(function(data_uri) {
                var image = document.getElementById('my_camera');
                image.src = data_uri;

                // Send the image data to the server using jQuery AJAX
                $.ajax({
                    type: 'POST',
                    url: '{{ route('pegawai.absenout') }}',
                    data: JSON.stringify({
                        image: data_uri,
                        lat: document.getElementById('latitude').value,
                        long: document.getElementById('longitude').value
                    }),
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        if (data.status == 0) {
                            Swal.fire({
                                title: 'Success!',
                                text: data.message,
                                icon: 'success',
                                confirmButtonText: 'OK',

                            }).then(function() {
                                window.location.reload();
                            });
                        } else {
                            // Show error message
                            Swal.fire({
                                title: 'Error!',
                                text: data.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR);

                        Swal.fire({
                            title: 'Error!',
                            text: 'An unexpected error occurred.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        }

        var map = L.map('map').setView([0, 0], 18); // Initial view (will update later)

        var googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
        }).addTo(map);

        // Get the user's location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const lat = position.coords.latitude;
                const long = position.coords.longitude;

                // Center the map on the user's location
                map.setView([lat, long], 17);

                // Add a marker at the user's location
                L.marker([lat, long]).addTo(map)
                    .bindPopup("Lokasi : {{ auth()->user()->name }}")
                    .openPopup();
                L.circle([{{ auth()->user()->radiusKantor->lat }}, {{ auth()->user()->radiusKantor->long }}], {
                    color: 'red',
                    fillColor: '#f03',
                    fillOpacity: 0.5,
                    radius: {{ auth()->user()->radiusKantor->radius }}
                }).addTo(map);
            }, function(error) {
                console.error("Error retrieving location: ", error);
                alert("Unable to retrieve your location.");
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    </script>
@endsection
