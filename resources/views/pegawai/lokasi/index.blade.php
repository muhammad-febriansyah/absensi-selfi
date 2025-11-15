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
        <div class="pageTitle">Lokasi Pegawai</div>
        <div class="right"></div>
    </div>
    <br>
    <div id="appCapsule" class="mb-5">
        <div class="section full mt-5">
            <div class="wide-block pt-2 pb-2">
                <div class="card">
                    <div class="card-body table-responsive">
                      
                        <input type="hidden" name="lat" id="latitude" readonly>
                        <input type="hidden" name="long" id="longitude" readonly>
                       
                        <div id="map" style="height: 500px; margin-top: 20px;" class="img-thumbnail">
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
                map.setView([lat, long], 13);

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
