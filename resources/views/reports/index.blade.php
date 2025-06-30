<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            Cetak Laporan
        </h2>
    </x-slot>

    <div class="row">
        {{-- Card untuk Laporan Data Lahan --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Laporan Data Lahan</h5>
                    <p class="card-text">Filter laporan data lahan berdasarkan tahun atau desa.</p>
                    <form action="{{ route('reports.lahan.cetak') }}" method="GET" target="_blank">
                        <div class="row">
                            {{-- Dropdown Bulan dihapus --}}
                            {{-- <div class="col-sm-6 mb-3">
                                <label for="bulan" class="form-label">Bulan</label>
                                <select name="bulan" id="bulan" class="form-select">
                                    <option value="">Semua Bulan</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 10)) }}</option>
                                    @endfor
                                </select>
                            </div> --}}
                            <div class="col-sm-6 mb-3"> {{-- Ini akan jadi col-sm-6 pertama --}}
                                <label for="tahun" class="form-label">Tahun</label>
                                <select name="tahun" id="tahun" class="form-select">
                                    <option value="">Semua Tahun</option>
                                    @foreach ($tahuns as $tahun)
                                        <option value="{{ $tahun }}">{{ $tahun }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6 mb-3"> {{-- Ini akan jadi col-sm-6 kedua --}}
                                <label for="desa" class="form-label">Desa</label>
                                <select name="desa" id="desa" class="form-select">
                                    <option value="">Semua Desa</option>
                                    @foreach ($desas as $desa)
                                        <option value="{{ $desa }}">{{ $desa }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-danger"><i class="fas fa-file-pdf me-2"></i> Cetak PDF</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Card untuk Laporan Kelompok Tani (bisa dikembangkan nanti) --}}
        <div class="col-md-6">
            {{-- ... --}}
        </div>
    </div>
</x-app-layout>