@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">
            <i class="fas fa-user-edit"></i> Edit Profil Peternak
        </h1>

        <a href="{{ route('benih.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- ALERT --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-store"></i> Data Profil Peternak
            </h6>
        </div>

        <div class="card-body">
            <form action="{{ route('peternak.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">

                    <!-- NAMA -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name"
                               class="form-control"
                               value="{{ old('name', $user->name) }}" required>
                    </div>

                    <!-- EMAIL -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email"
                               class="form-control"
                               value="{{ old('email', $user->email) }}" required>
                    </div>

                    <!-- NO HP -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">No HP</label>
                        <input type="text" name="no_hp"
                               class="form-control"
                               value="{{ old('no_hp', $peternak->no_hp) }}" required>
                    </div>

                    <!-- SEARCH MAP -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Cari Lokasi Peternakan</label>
                        <input type="text" id="map_search"
                               class="form-control"
                               placeholder="Cari lokasi...">
                    </div>

                    <!-- ALAMAT -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat" id="alamat"
                                  class="form-control" rows="3" required>{{ old('alamat', $peternak->alamat) }}</textarea>
                    </div>

                    <!-- MAP -->
                    <div class="col-md-12 mb-3">
                        <div id="map" style="height:350px;border-radius:10px;"></div>
                    </div>

                </div>

                <!-- HIDDEN LAT LONG -->
                <input type="hidden" id="latitude" name="latitude"
                       value="{{ old('latitude', $peternak->latitude) }}">
                <input type="hidden" id="longitude" name="longitude"
                       value="{{ old('longitude', $peternak->longitude) }}">

                <div class="mt-4">
                    <button class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>

                    <a href="{{ route('benih.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    let map, marker, geocoder, autocomplete;

    function initMap() {
        const defaultLat = parseFloat(document.getElementById('latitude').value) || -6.2088;
        const defaultLng = parseFloat(document.getElementById('longitude').value) || 106.8456;

        const defaultLocation = { lat: defaultLat, lng: defaultLng };

        map = new google.maps.Map(document.getElementById('map'), {
            center: defaultLocation,
            zoom: 14,
        });

        geocoder = new google.maps.Geocoder();

        marker = new google.maps.Marker({
            map: map,
            position: defaultLocation,
            draggable: true,
        });

        marker.addListener('dragend', function (e) {
            updateLocation(e.latLng.lat(), e.latLng.lng());
        });

        map.addListener('click', function (e) {
            marker.setPosition(e.latLng);
            updateLocation(e.latLng.lat(), e.latLng.lng());
        });

        const input = document.getElementById('map_search');
        autocomplete = new google.maps.places.Autocomplete(input, {
            componentRestrictions: { country: 'id' }
        });

        autocomplete.addListener('place_changed', function () {
            const place = autocomplete.getPlace();
            if (!place.geometry) return;

            map.setCenter(place.geometry.location);
            map.setZoom(15);
            marker.setPosition(place.geometry.location);

            updateLocation(
                place.geometry.location.lat(),
                place.geometry.location.lng(),
                place.formatted_address
            );
        });
    }

    function updateLocation(lat, lng, address = null) {
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        if (address) {
            document.getElementById('alamat').value = address;
        } else {
            geocoder.geocode({ location: { lat, lng } }, function (results, status) {
                if (status === 'OK' && results[0]) {
                    document.getElementById('alamat').value = results[0].formatted_address;
                }
            });
        }
    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8l6eRve8pNpEzOfgosulUBmxD5qFZ370&libraries=places&callback=initMap" async defer></script>
@endpush