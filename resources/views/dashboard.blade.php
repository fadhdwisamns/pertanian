<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- Kartu Statistik --}}
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

    {{-- Area Grafik --}}
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
    {{-- CDN Chart.js untuk membuat grafik --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Ambil data yang dikirim dari controller
        const kelompokData = @json($kelompokPerKecamatan);
        const komoditasData = @json($komoditasPopuler);

        // 1. Grafik Batang (Bar Chart) - Kelompok Tani per Kecamatan
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
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // 2. Grafik Lingkaran (Pie Chart) - Komoditas Populer
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
            options: {
                responsive: true,
            }
        });
    </script>
    @endpush
</x-app-layout>