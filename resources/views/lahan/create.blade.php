<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            Tambah Data Lahan
        </h2>
    </x-slot>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('lahan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                 @if ($errors->any())
                    <div class="alert alert-danger mb-3">
                        <h6 class="alert-heading">Whoops! Ada beberapa masalah dengan input Anda.</h6>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row">
                    {{-- INI ADALAH INPUT TEKS MANUAL UNTUK NAMA PETANI --}}
                    <div class="col-md-6 mb-3">
                        <label for="nama_petani" class="form-label">Nama Petani</label>
                        <input type="text" name="nama_petani" id="nama_petani" class="form-control" placeholder="Masukkan nama pemilik lahan" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nama_lahan" class="form-label">Nama Lahan/Pertanian</label>
                        <input type="text" name="nama_lahan" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="luas_lahan" class="form-label">Luas Lahan (Hektar)</label>
                        <input type="number" step="0.01" name="luas_lahan" class="form-control" required>
                    </div>
                    {{-- INPUT BARU UNTUK STATUS PRODUKTIVITAS --}}
                    <div class="col-md-6 mb-3">
                        <label for="status_produktif" class="form-label">Status Produktivitas</label>
                        <select name="status_produktif" id="status_produktif" class="form-control" required>
                            <option value="Produktif" selected>Masih Produktif</option>
                            <option value="Tidak Produktif">Tidak Produktif</option>
                        </select>
                    </div>
                    {{-- INPUT JUMLAH PRODUKSI SEKARANG DI BAWAH STATUS --}}
                    <div class="col-md-6 mb-3">
                        <label for="jumlah_produksi" class="form-label">Jumlah Produksi</label>
                        <input type="text" name="jumlah_produksi" id="jumlah_produksi" class="form-control" placeholder="Contoh: 5 Ton / Musim" required>
                    </div>
                     <div class="col-md-6 mb-3">
                        <label for="no_wa" class="form-label">Nomor WhatsApp</label>
                        <input type="text" name="no_wa" class="form-control" placeholder="Contoh: 628123456789" required>
                    </div>
                     <div class="col-md-6 mb-3">
                        <label for="foto_lahan" class="form-label">Foto Lahan</label>
                        <input type="file" name="foto_lahan" class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                         <label class="form-label">Pilih Titik Lokasi Lahan</label>
                         <div id="map" style="height: 400px;"></div>
                    </div>

                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">

                    <div class="col-12 text-center">
                      <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // --- Script untuk Leaflet Map ---
        var defaultLocation = @json($defaultLocation);
        var map = L.map('map').setView(defaultLocation, 11);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '© OpenStreetMap' }).addTo(map);
        var marker = L.marker(defaultLocation, { draggable: true }).addTo(map);
        document.getElementById('latitude').value = marker.getLatLng().lat;
        document.getElementById('longitude').value = marker.getLatLng().lng;
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    var lat = position.coords.latitude;
                    var lon = position.coords.longitude;
                    var userLocation = [lat, lon];
                    map.setView(userLocation, 15);
                    marker.setLatLng(userLocation);
                    document.getElementById('latitude').value = lat;
                    document.getElementById('longitude').value = lon;
                },
                function() { console.log('Gagal mendapatkan lokasi GPS, menggunakan lokasi default.'); }
            );
        } else { console.log('Browser Anda tidak mendukung Geolocation.'); }
        marker.on('dragend', function(event) {
            var position = marker.getLatLng();
            document.getElementById('latitude').value = position.lat;
            document.getElementById('longitude').value = position.lng;
        });

        // --- Script untuk menonaktifkan input produksi ---
        document.addEventListener('DOMContentLoaded', function () {
            const statusSelect = document.getElementById('status_produktif');
            const produksiInput = document.getElementById('jumlah_produksi');

            function toggleProduksiInput() {
                if (statusSelect.value === 'Tidak Produktif') {
                    produksiInput.disabled = true;
                    produksiInput.value = '';
                    produksiInput.required = false;
                } else {
                    produksiInput.disabled = false;
                    produksiInput.required = true;
                }
            }
            // Panggil fungsi saat halaman dimuat
            toggleProduksiInput();
            // Panggil fungsi saat dropdown berubah
            statusSelect.addEventListener('change', toggleProduksiInput);
        });
    </script>
</x-app-layout>