<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            Edit Data Kelompok Tani
        </h2>
    </x-slot>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

    <div class="card">
        <div class="card-body">
            {{-- Form akan mengarah ke route 'update' dengan method 'PUT' --}}
            <form action="{{ route('kelompok-tani.update', $kelompokTani->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    {{-- Kolom Kiri --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_kelompok" class="form-label">Nama Kelompok Tani</label>
                            {{-- 'value' diisi dengan data yang sudah ada --}}
                            <input type="text" name="nama_kelompok" class="form-control" value="{{ old('nama_kelompok', $kelompokTani->nama_kelompok) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="ketua_kelompok" class="form-label">Nama Ketua Kelompok</label>
                            <input type="text" name="ketua_kelompok" class="form-control" value="{{ old('ketua_kelompok', $kelompokTani->ketua_kelompok) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat_sekretariat" class="form-label">Alamat Sekretariat</label>
                            <textarea name="alamat_sekretariat" class="form-control" rows="3" required>{{ old('alamat_sekretariat', $kelompokTani->alamat_sekretariat) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="kecamatan" class="form-label">Kecamatan</label>
                            <input type="text" name="kecamatan" class="form-control" value="{{ old('kecamatan', $kelompokTani->kecamatan) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="desa" class="form-label">Desa</label>
                            <input type="text" name="desa" class="form-control" value="{{ old('desa', $kelompokTani->desa) }}" required>
                        </div>
                    </div>
                    {{-- Kolom Kanan --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tahun_berdiri" class="form-label">Tahun Berdiri</label>
                            <input type="number" name="tahun_berdiri" class="form-control" value="{{ old('tahun_berdiri', $kelompokTani->tahun_berdiri) }}" required>
                        </div>
                         <div class="mb-3">
                            <label for="komoditas_unggulan" class="form-label">Komoditas Unggulan</label>
                            <input type="text" name="komoditas_unggulan" class="form-control" value="{{ old('komoditas_unggulan', $kelompokTani->komoditas_unggulan) }}" required>
                        </div>
                         <div class="mb-3">
                            <label for="kelas_kemampuan" class="form-label">Kelas Kemampuan</label>
                            <select name="kelas_kemampuan" class="form-select" required>
                                {{-- Opsi dipilih berdasarkan data yang ada --}}
                                <option value="Pemula" @selected(old('kelas_kemampuan', $kelompokTani->kelas_kemampuan) == 'Pemula')>Pemula</option>
                                <option value="Lanjut" @selected(old('kelas_kemampuan', $kelompokTani->kelas_kemampuan) == 'Lanjut')>Lanjut</option>
                                <option value="Madya" @selected(old('kelas_kemampuan', $kelompokTani->kelas_kemampuan) == 'Madya')>Madya</option>
                                <option value="Utama" @selected(old('kelas_kemampuan', $kelompokTani->kelas_kemampuan) == 'Utama')>Utama</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="sub_sektor" class="form-label">Sub Sektor</label>
                            <input type="text" name="sub_sektor" class="form-control" value="{{ old('sub_sektor', $kelompokTani->sub_sektor) }}" required>
                        </div>
                         <div class="mb-3">
                            <label for="foto_lokasi" class="form-label">Ganti Foto Lokasi (Opsional)</label>
                            <input type="file" name="foto_lokasi" class="form-control">
                        </div>
                    </div>
                    {{-- Bagian Peta --}}
                    <div class="col-12 mt-3">
                        <label class="form-label">Pilih Ulang Titik Koordinat Sekretariat</label>
                        <div id="map" style="height: 400px;"></div>
                        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $kelompokTani->latitude) }}">
                        <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $kelompokTani->longitude) }}">
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('kelompok-tani.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

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
</x-app-layout>