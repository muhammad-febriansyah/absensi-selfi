@extends('admin.layouts.main')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <div class="row">
                                <div class="col-7">
                                    <form id="form" method="POST">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="lat">Lokasi Penempatan</label>
                                            <select name="lokasi_penempatan_id" id="" class="form-control">
                                                @foreach ($locations as $location)
                                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="lat">Latitude</label>
                                            <input type="text" id="lat" name="lat" class="form-control"
                                                required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="long">Longitude</label>
                                            <input type="text" id="long" name="long" class="form-control"
                                                required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="radius">Radius (meters)</label>
                                            <input type="number" id="radius" name="radius" class="form-control"
                                                required>
                                        </div>
                                        <a href="{{ route('main.radius') }}" class="btn btn-warning"><i
                                                class="fas fa-sync-alt    "></i> Kembali</a>
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"
                                                aria-hidden="true"></i> Simpan</button>
                                    </form>
                                </div>
                                <div class="col-5">
                                    <div id="map" style="height: 300px; margin-top: 20px;" class="img-thumbnail">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        @include('admin.layouts.footer')
    </div>
    <script>
        $(document).ready(function() {
            var map = L.map('map').setView([0, 0], 13); // Initial view (will update later)

            var googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            }).addTo(map);
            // Get current location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat = position.coords.latitude;
                    var long = position.coords.longitude;
                    // Set the map view to the user's location
                    map.setView([lat, long], 13);
                }, function() {
                    alert('Geolocation service failed. Please enable location services.');
                });
            } else {
                alert('Your browser doesn\'t support geolocation.');
            }
            var circle;

            // Create a circle based on existing radius
            function drawCircle(lat, lng, radius) {
                if (circle) {
                    map.removeLayer(circle);
                }
                circle = L.circle([lat, lng], {
                    radius: radius,
                    color: 'blue',
                    fillOpacity: 0.1,
                }).addTo(map);
            }

            // Draw the circle initially
            drawCircle(document.getElementById('lat').value, document.getElementById('long').value, document.getElementById('radius').value);

            // Update form fields on map click
            map.on('click', function(e) {
                document.getElementById('lat').value = e.latlng.lat;
                document.getElementById('long').value = e.latlng.lng;
                drawCircle(e.latlng.lat, e.latlng.lng, document.getElementById('radius').value);
            });

            // Update circle radius on input change
            document.getElementById('radius').addEventListener('input', function() {
                if (circle) {
                    circle.setRadius(this.value);
                }
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
                    url: '{{ route('main.storeradius') }}',
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
                            text: "Data berhasil disimpan!"
                        }).then(function() {
                            location.reload(); // Reload the page
                        });
                    },
                    error: function(xhr, status, error) {
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
