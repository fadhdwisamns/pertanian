<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            Detail Data Lahan: {{ $lahan->nama_lahan }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4>Informasi Lahan</h4>
                    <table class="table table-borderless">
                        {{-- TAMBAHKAN BARIS INI UNTUK NAMA PETANI --}}
                        <tr>
                            <th width="30%">Nama Petani</th>
                            <td>: {{ $lahan->nama_petani }}</td>
                        </tr>
                        <tr>
                            <th>Nama Lahan</th>
                            <td>: {{ $lahan->nama_lahan }}</td>
                        </tr>
                        <tr>
                            <th>Luas Lahan</th>
                            <td>: {{ $lahan->luas_lahan }} Ha</td>
                        </tr>
                        <tr>
                            <th>Jumlah Produksi</th>
                            <td>: {{ $lahan->jumlah_produksi }}</td>
                        </tr>
                        <tr>
                            <th>Nomor WhatsApp</th>
                            <td>: {{ $lahan->no_wa }}</td>
                        </tr>
                        <tr>
                            <th>Diinput Oleh Akun</th>
                            <td>: {{ $lahan->user->name ?? 'N/A' }}</td>
                        </tr>
                    </table>
                    @if ($lahan->foto_lahan)
                        <h4 class="mt-4">Foto Lahan</h4>
                        <img src="{{ asset('storage/' . $lahan->foto_lahan) }}" alt="Foto Lahan" class="img-fluid img-thumbnail mt-2" style="max-width: 400px;">
                    @endif
                </div>
                <div class="col-md-6">
                    <h4>Lokasi Peta</h4>
                    <div id="map" style="height: 400px; border-radius: 0.25rem;"></div>
                </div>
            </div>
            <div class="mt-4 text-center">
                 <a href="{{ route('lahan.index') }}" class="btn btn-secondary">Kembali ke Daftar Lahan</a>
                 <a href="{{ route('lahan.edit', $lahan->id) }}" class="btn btn-warning">Edit Data</a>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        var initialLocation = [{{ $lahan->latitude }}, {{ $lahan->longitude }}];
        var map = L.map('map').setView(initialLocation, 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Marker dibuat tidak bisa di-drag karena ini halaman show
        var marker = L.marker(initialLocation).addTo(map);

    </script>
</x-app-layout>
