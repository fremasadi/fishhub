@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h1 class="h3 mb-2">Tambah Peternak</h1>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('peternaks.store') }}" method="POST" id="peternakForm">
                @csrf

                <h5 class="mb-3">Informasi Akun</h5>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                        <input type="password" 
                               class="form-control" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               required>
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="mb-3">Informasi Peternak</h5>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="no_hp" class="form-label">No. HP <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('no_hp') is-invalid @enderror" 
                               id="no_hp" 
                               name="no_hp" 
                               value="{{ old('no_hp') }}" 
                               placeholder="08xxxxxxxxxx"
                               required>
                        @error('no_hp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="status_aktif" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status_aktif') is-invalid @enderror" 
                                id="status_aktif" 
                                name="status_aktif" 
                                required>
                            <option value="">Pilih Status</option>
                            <option value="1" {{ old('status_aktif') == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('status_aktif') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        @error('status_aktif')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="map_search" class="form-label">Cari Lokasi <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control" 
                           id="map_search" 
                           placeholder="Ketik untuk mencari lokasi...">
                    <small class="text-muted">Cari lokasi atau klik/drag marker pada peta</small>
                </div>

                <div class="mb-3">
                    <div id="map" style="height: 400px; width: 100%; border-radius: 8px;"></div>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('alamat') is-invalid @enderror" 
                              id="alamat" 
                              name="alamat" 
                              rows="3" 
                              required>{{ old('alamat') }}</textarea>
                    <small class="text-muted">Alamat akan terisi otomatis dari peta, tetapi dapat diedit</small>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Hidden fields for latitude and longitude -->
                <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}">
                <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}">

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('peternaks.index') }}" class="btn btn-secondary">
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
    let map;
    let marker;
    let geocoder;
    let autocomplete;

    function initMap() {
        // Default location (Jakarta)
        const defaultLocation = { lat: -6.2088, lng: 106.8456 };
        
        // Initialize map
        map = new google.maps.Map(document.getElementById('map'), {
            center: defaultLocation,
            zoom: 13,
            mapTypeControl: true,
            streetViewControl: false,
            fullscreenControl: true
        });

        // Initialize geocoder
        geocoder = new google.maps.Geocoder();

        // Initialize autocomplete
        const searchInput = document.getElementById('map_search');
        autocomplete = new google.maps.places.Autocomplete(searchInput, {
            componentRestrictions: { country: 'id' },
            fields: ['formatted_address', 'geometry', 'name']
        });

        // Initialize marker
        marker = new google.maps.Marker({
            map: map,
            draggable: true,
            position: defaultLocation
        });

        // Update form when marker is dragged
        marker.addListener('dragend', function(event) {
            updateLocationData(event.latLng.lat(), event.latLng.lng());
        });

        // Update form when map is clicked
        map.addListener('click', function(event) {
            marker.setPosition(event.latLng);
            updateLocationData(event.latLng.lat(), event.latLng.lng());
        });

        // Handle autocomplete selection
        autocomplete.addListener('place_changed', function() {
            const place = autocomplete.getPlace();
            
            if (!place.geometry) {
                alert('Lokasi tidak ditemukan');
                return;
            }

            // Center map and move marker to selected place
            map.setCenter(place.geometry.location);
            map.setZoom(15);
            marker.setPosition(place.geometry.location);

            // Update form data
            updateLocationData(
                place.geometry.location.lat(), 
                place.geometry.location.lng(),
                place.formatted_address || place.name
            );
        });

        // Try to get user's current location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const userLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    map.setCenter(userLocation);
                    marker.setPosition(userLocation);
                    updateLocationData(userLocation.lat, userLocation.lng);
                },
                function() {
                    console.log('Geolocation permission denied');
                }
            );
        }
    }

    function updateLocationData(lat, lng, address = null) {
        // Update hidden fields
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        // If address is not provided, reverse geocode to get address
        if (!address) {
            geocoder.geocode({ location: { lat: lat, lng: lng } }, function(results, status) {
                if (status === 'OK' && results[0]) {
                    document.getElementById('alamat').value = results[0].formatted_address;
                }
            });
        } else {
            document.getElementById('alamat').value = address;
        }
    }

    // Form validation
    document.getElementById('peternakForm').addEventListener('submit', function(e) {
        const lat = document.getElementById('latitude').value;
        const lng = document.getElementById('longitude').value;

        if (!lat || !lng) {
            e.preventDefault();
            alert('Silakan pilih lokasi pada peta terlebih dahulu');
            return false;
        }
    });
</script>

<!-- Load Google Maps API with your API key -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8l6eRve8pNpEzOfgosulUBmxD5qFZ370&libraries=places&callback=initMap" async defer></script>
@endpush