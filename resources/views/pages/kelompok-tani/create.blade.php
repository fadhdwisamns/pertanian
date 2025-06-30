<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            Tambah Data Kelompok Tani
        </h2>
    </x-slot>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('kelompok-tani.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    {{-- Kolom Kiri --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_kelompok" class="form-label">Nama Kelompok Tani</label>
                            <input type="text" name="nama_kelompok" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="ketua_kelompok" class="form-label">Nama Ketua Kelompok</label>
                            <input type="text" name="ketua_kelompok" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat_sekretariat" class="form-label">Alamat Sekretariat</label>
                            <textarea name="alamat_sekretariat" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="kecamatan" class="form-label">Kecamatan</label>
                            <input type="text" name="kecamatan" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="desa" class="form-label">Desa</label>
                            <input type="text" name="desa" class="form-control" required>
                        </div>
                    </div>
                    {{-- Kolom Kanan --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tahun_berdiri" class="form-label">Tahun Berdiri</label>
                            <input type="number" name="tahun_berdiri" class="form-control" required>
                        </div>
                         <div class="mb-3">
                            <label for="komoditas_unggulan" class="form-label">Komoditas Unggulan</label>
                            <input type="text" name="komoditas_unggulan" class="form-control" required>
                        </div>
                         <div class="mb-3">
                            <label for="kelas_kemampuan" class="form-label">Kelas Kemampuan</label>
                            <select name="kelas_kemampuan" class="form-select" required>
                                <option value="Pemula">Pemula</option>
                                <option value="Lanjut">Lanjut</option>
                                <option value="Madya">Madya</option>
                                <option value="Utama">Utama</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="sub_sektor" class="form-label">Sub Sektor</label>
                            <input type="text" name="sub_sektor" class="form-control" required>
                        </div>
                         <div class="mb-3">
                            <label for="foto_lokasi" class="form-label">Foto Lokasi (Sekretariat)</label>
                            <input type="file" name="foto_lokasi" class="form-control">
                        </div>
                    </div>
                    {{-- Bagian Peta --}}
                    <div class="col-12 mt-3">
                        <label class="form-label">Pilih Titik Koordinat Sekretariat</label>
                        <div id="map" style="height: 400px;"></div>
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('kelompok-tani.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
    // Lokasi default (fallback) jika GPS tidak diizinkan atau gagal
    var defaultLocation = @json($defaultLocation);
    var map = L.map('map').setView(defaultLocation, 11);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    var marker = L.marker(defaultLocation, { draggable: true }).addTo(map);

    // Update input dengan lokasi default terlebih dahulu
    document.getElementById('latitude').value = marker.getLatLng().lat;
    document.getElementById('longitude').value = marker.getLatLng().lng;

    // --- BAGIAN BARU UNTUK MENDAPATKAN LOKASI GPS ---
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            // Fungsi jika berhasil mendapatkan lokasi
            function(position) {
                var lat = position.coords.latitude;
                var lon = position.coords.longitude;
                var userLocation = [lat, lon];

                // Pindahkan peta dan marker ke lokasi pengguna
                map.setView(userLocation, 15); // Zoom lebih dekat ke 15
                marker.setLatLng(userLocation);

                // Update hidden input dengan lokasi GPS
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lon;
            },
            // Fungsi jika gagal (opsional, bisa diabaikan)
            function() {
                // Biarkan peta menggunakan lokasi default jika gagal
                console.log('Gagal mendapatkan lokasi GPS, menggunakan lokasi default.');
            }
        );
    } else {
        console.log('Browser Anda tidak mendukung Geolocation.');
    }

        marker.on('dragend', function(event) {
            var position = marker.getLatLng();
            document.getElementById('latitude').value = position.lat;
            document.getElementById('longitude').value = position.lng;
        });
    </script>
</x-app-layout>