<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            Detail Data: {{ $kelompokTani->nama_kelompok }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

    <div class="card">
        <div class="card-body">
            <div class="row">
                {{-- Kolom Informasi Teks --}}
                <div class="col-md-6">
                    <h4>Informasi Kelompok Tani</h4>
                    <table class="table table-borderless">
                        <tr>
                            <th>Nama Kelompok</th>
                            <td>: {{ $kelompokTani->nama_kelompok }}</td>
                        </tr>
                        <tr>
                            <th>Ketua</th>
                            <td>: {{ $kelompokTani->ketua_kelompok }}</td>
                        </tr>
                         <tr>
                            <th>Kecamatan</th>
                            <td>: {{ $kelompokTani->kecamatan }}</td>
                        </tr>
                         <tr>
                            <th>Desa</th>
                            <td>: {{ $kelompokTani->desa }}</td>
                        </tr>
                        <tr>
                            <th>Tahun Berdiri</th>
                            <td>: {{ $kelompokTani->tahun_berdiri }}</td>
                        </tr>
                        <tr>
                            <th>Komoditas Unggulan</th>
                            <td>: {{ $kelompokTani->komoditas_unggulan }}</td>
                        </tr>
                         <tr>
                            <th>Alamat Sekretariat</th>
                            <td>: {{ $kelompokTani->alamat_sekretariat }}</td>
                        </tr>
                    </table>

                    @if ($kelompokTani->foto_lokasi)
                        <h4 class="mt-4">Foto Lokasi</h4>
                        <img src="{{ asset('storage/' . $kelompokTani->foto_lokasi) }}" alt="Foto Lokasi" class="img-fluid img-thumbnail mt-2" style="max-width: 400px;">
                    @endif
                </div>

                {{-- Kolom Peta --}}
                <div class="col-md-6">
                    <h4>Lokasi Sekretariat</h4>
                    @if ($kelompokTani->latitude && $kelompokTani->longitude)
                        <div id="map" style="height: 400px; border-radius: 0.25rem;"></div>
                    @else
                        <div class="alert alert-warning">
                            Data koordinat untuk kelompok tani ini tidak tersedia.
                        </div>
                    @endif
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('kelompok-tani.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
            </div>
        </div>
    </div>

    @if ($kelompokTani->latitude && $kelompokTani->longitude)
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        var initialLocation = [{{ $kelompokTani->latitude }}, {{ $kelompokTani->longitude }}];
        var map = L.map('map').setView(initialLocation, 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        var marker = L.marker(initialLocation, { draggable: true }).addTo(map);

        marker.on('dragend', function(event) {
            var position = marker.getLatLng();
            document.getElementById('latitude').value = position.lat;
            document.getElementById('longitude').value = position.lng;
        });
    </script>
    @endif
</x-app-layout> 