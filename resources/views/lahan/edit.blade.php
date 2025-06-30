<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            Edit Data Lahan
        </h2>
    </x-slot>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('lahan.update', $lahan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    {{-- GANTI DROPDOWN MENJADI INPUT TEKS MANUAL --}}
                    <div class="col-md-6 mb-3">
                        <label for="nama_petani" class="form-label">Nama Petani</label>
                        <input type="text" name="nama_petani" id="nama_petani" class="form-control" value="{{ old('nama_petani', $lahan->nama_petani) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nama_lahan" class="form-label">Nama Lahan/Pertanian</label>
                        <input type="text" name="nama_lahan" class="form-control" value="{{ $lahan->nama_lahan }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="luas_lahan" class="form-label">Luas Lahan (Hektar)</label>
                        <input type="number" step="0.01" name="luas_lahan" class="form-control" value="{{ $lahan->luas_lahan }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="jumlah_produksi" class="form-label">Jumlah Produksi</label>
                        <input type="text" name="jumlah_produksi" class="form-control" value="{{ $lahan->jumlah_produksi }}" required>
                    </div>
                     <div class="col-md-6 mb-3">
                        <label for="no_wa" class="form-label">Nomor WhatsApp</label>
                        <input type="text" name="no_wa" class="form-control" value="{{ $lahan->no_wa }}" required>
                    </div>
                     <div class="col-md-6 mb-3">
                        <label for="foto_lahan" class="form-label">Ganti Foto Lahan (Opsional)</label>
                        <input type="file" name="foto_lahan" class="form-control">
                        @if ($lahan->foto_lahan)
                            <small class="form-text">Foto saat ini:</small><br>
                            <img src="{{ asset('storage/' . $lahan->foto_lahan) }}" alt="Foto Lahan" class="img-thumbnail mt-2" width="200">
                        @endif
                    </div>

                    <div class="col-md-12 mb-3">
                         <label class="form-label">Pilih Ulang Titik Lokasi Lahan</label>
                         <div id="map" style="height: 400px;"></div>
                    </div>

                    <input type="hidden" name="latitude" id="latitude" value="{{ $lahan->latitude }}">
                    <input type="hidden" name="longitude" id="longitude" value="{{ $lahan->longitude }}">

                    <div class="col-12 text-center">
                      <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                      <a href="{{ route('lahan.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    {{-- SCRIPT MAPS ANDA TIDAK SAYA UBAH --}}
    <script>
        var initialLocation = [{{ $lahan->latitude ?? -0.5336 }}, {{ $lahan->longitude ?? 101.4452 }}];
        var map = L.map('map').setView(initialLocation, 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap' }).addTo(map);
        var marker = L.marker(initialLocation, { draggable: true }).addTo(map);
        marker.on('dragend', function(event) {
            var position = marker.getLatLng();
            document.getElementById('latitude').value = position.lat;
            document.getElementById('longitude').value = position.lng;
        });
    </script>
</x-app-layout>
