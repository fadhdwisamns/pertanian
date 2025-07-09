<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- Kartu Statistik (Tampil untuk semua role) --}}
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-primary border-4 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row g-0 align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">Total Kelompok Tani</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ number_format($totalKelompokTani) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-success border-4 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row g-0 align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-success text-uppercase mb-1">Total Kecamatan</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ number_format($totalKecamatan) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map-marked-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-info border-4 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row g-0 align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-info text-uppercase mb-1">Total Luas Lahan (Ha)</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ number_format($totalLuasLahan, 2) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-layer-group fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-warning border-4 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row g-0 align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-warning text-uppercase mb-1">Jenis Komoditas</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ number_format($totalKomoditas) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-seedling fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- KONTEN DINAMIS BERDASARKAN ROLE --}}

    {{-- 1. Tampilan Peta untuk Petani dan Komoditas --}}
    @hasanyrole('Petani|Komoditas')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <div class="card shadow">
        <div class="card-header py-3">
             <h6 class="m-0 fw-bold text-primary">Peta Sebaran Lahan & Kelompok Tani</h6>
        </div>
        <div class="card-body">
            <div id="map" style="height: 600px; width: 100%;"></div>
        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([-0.5336, 101.4452], 10);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        var blueIcon = new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34], shadowSize: [41, 41]
        });

        var redIcon = new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34], shadowSize: [41, 41]
        });

        var lahans = @json($lahans);
        var kelompokTanis = @json($kelompokTanis);

        lahans.forEach(function(lahan) {
            if (lahan.latitude && lahan.longitude) {
                var marker = L.marker([lahan.latitude, lahan.longitude], { icon: blueIcon }).addTo(map);
                
                // --- KONTEN POPUP YANG DIPERBARUI ---
                var isProduktif = lahan.status_produktif !== 'Tidak Produktif';
                var produksiText = isProduktif && lahan.jumlah_produksi ? `<strong>Produksi:</strong> ${lahan.jumlah_produksi}<br>` : '';

                var popupContent = `
                    <div style="max-width: 200px;">
                        ${lahan.foto_url ? `<img src="${lahan.foto_url}" alt="Foto Lahan" style="width:100%; height:auto; border-radius: 5px; margin-bottom: 5px;">` : ''}
                        <strong>${lahan.nama_lahan}</strong><br>
                        <strong>Pemilik:</strong> ${lahan.nama_petani}<br>
                        <strong>Luas:</strong> ${lahan.luas_lahan} Ha<br>
                        <strong>Status:</strong> ${isProduktif ? 'Masih Produktif' : 'Tidak Produktif'}<br>
                        ${produksiText}
                        <strong>Kontak:</strong> <a href="https://wa.me/${lahan.no_wa}" target="_blank">${lahan.no_wa}</a>
                    </div>
                `;
                marker.bindPopup(popupContent);
            }
        });

        kelompokTanis.forEach(function(kelompok) {
            var marker = L.marker([kelompok.latitude, kelompok.longitude], { icon: redIcon }).addTo(map);
            var popupContent = `
                <div style="max-width: 200px;">
                    ${kelompok.foto_lokasi ? `<img src="${kelompok.foto_lokasi}" alt="Foto Kelompok Tani" style="width:100%; height:auto; border-radius: 5px; margin-bottom: 5px;">` : ''}
                    <strong>${kelompok.nama_kelompok}</strong><br>
                    <hr style="margin: 2px 0;">
                    <strong>Desa:</strong> ${kelompok.desa}<br>
                    <strong>Komoditas:</strong> ${kelompok.komoditas_unggulan}<br>
                    <strong>Ketua:</strong> ${kelompok.ketua_kelompok}<br>
                    <strong>Tahun Berdiri:</strong> ${kelompok.tahun_berdiri}
                </div>
            `;
            marker.bindPopup(popupContent);
        });
    </script>
    @endpush
    @endhasanyrole

    {{-- 2. Tampilan Grafik untuk Admin --}}
    @role('Admin')
    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 fw-bold text-primary">Jumlah Kelompok Tani per Kecamatan</h6>
                </div>
                <div class="card-body">
                    <canvas id="kelompokPerKecamatanChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 fw-bold text-primary">Komoditas Terpopuler</h6>
                </div>
                <div class="card-body">
                    <canvas id="komoditasPopulerChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const kelompokData = @json($kelompokPerKecamatan);
        const komoditasData = @json($komoditasPopuler);

        const ctxBar = document.getElementById('kelompokPerKecamatanChart');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: kelompokData.map(item => item.kecamatan),
                datasets: [{
                    label: 'Jumlah Kelompok',
                    data: kelompokData.map(item => item.total),
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: { responsive: true, scales: { y: { beginAtZero: true } } }
        });

        const ctxPie = document.getElementById('komoditasPopulerChart');
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: komoditasData.map(item => item.komoditas_unggulan),
                datasets: [{
                    label: 'Jumlah',
                    data: komoditasData.map(item => item.total),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)', 'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)', 'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)', 'rgba(255, 159, 64, 0.7)',
                        'rgba(199, 199, 199, 0.7)'
                    ],
                    hoverOffset: 4
                }]
            },
            options: { responsive: true }
        });
    </script>
    @endpush
    @endrole

</x-app-layout>