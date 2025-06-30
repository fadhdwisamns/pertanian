<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            Laporan Kelompok Tani
        </h2>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Filter dan Cetak Laporan</h5>
            <p class="card-text">Pilih filter di bawah ini untuk mengunduh laporan data kelompok tani dalam format PDF.</p>

            {{-- Form untuk filter dan cetak --}}
            <form action="{{ route('kelompok-tani.cetak-pdf') }}" method="GET" target="_blank">
                
                <div class="row">
                    {{-- Filter Tahun --}}
                    <div class="col-md-6 mb-3">
                        <label for="tahun" class="form-label">Pilih Tahun</label>
                        <select name="tahun" id="tahun" class="form-control">
                            <option value="">Semua Tahun</option>
                            {{-- Asumsi variabel $tahuns di-passing dari controller --}}
                            @foreach($tahuns ?? [] as $tahun)
                                <option value="{{ $tahun }}">{{ $tahun }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filter Desa --}}
                    <div class="col-md-6 mb-3">
                        <label for="desa" class="form-label">Pilih Desa</label>
                        <select name="desa" id="desa" class="form-control">
                            <option value="">Semua Desa</option>
                            {{-- Asumsi variabel $desas di-passing dari controller --}}
                            @foreach($desas ?? [] as $desa)
                                <option value="{{ $desa }}">{{ $desa }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Tombol Cetak --}}
                <button type="submit" class="btn btn-danger mt-2">
                    <i class="fas fa-file-pdf me-2"></i> Cetak Laporan PDF
                </button>
            </form>
        </div>
    </div>
</x-app-layout>