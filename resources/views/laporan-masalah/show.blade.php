<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            Detail Laporan: {{ $laporanMasalah->judul_laporan }}
        </h2>
    </x-slot>

    <div class="row">
        {{-- Kolom Kiri untuk Detail Laporan --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Judul Laporan</th>
                            <td>: {{ $laporanMasalah->judul_laporan }}</td>
                        </tr>
                        <tr>
                            <th>Pelapor</th>
                            <td>: {{ $laporanMasalah->user->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Lapor</th>
                            <td>: {{ $laporanMasalah->created_at->format('d F Y, H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>: {{ $laporanMasalah->kategori_masalah }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>: 
                                <span class="badge 
                                    @if($laporanMasalah->status == 'Dikirim') bg-secondary 
                                    @elseif($laporanMasalah->status == 'Diproses') bg-warning text-dark
                                    @else bg-success @endif">
                                    {{ $laporanMasalah->status }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th style="vertical-align: top;">Deskripsi</th>
                            <td style="vertical-align: top;">: {!! nl2br(e($laporanMasalah->deskripsi_masalah)) !!}</td>
                        </tr>
                    </table>

                    @if ($laporanMasalah->foto_masalah)
                        <h5 class="mt-4">Foto Masalah</h5>
                        <img src="{{ asset('storage/' . $laporanMasalah->foto_masalah) }}" alt="Foto Masalah" class="img-fluid img-thumbnail mt-2" style="max-width: 500px;">
                    @endif
                </div>
            </div>
        </div>

        {{-- Kolom Kanan untuk Aksi Admin --}}
        @role('Admin')
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Ubah Status Laporan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('laporan-masalah.update', $laporanMasalah->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="Dikirim" @if($laporanMasalah->status == 'Dikirim') selected @endif>Dikirim</option>
                                <option value="Diproses" @if($laporanMasalah->status == 'Diproses') selected @endif>Diproses</option>
                                <option value="Selesai" @if($laporanMasalah->status == 'Selesai') selected @endif>Selesai</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
        @endrole
    </div>

    <div class="mt-4">
        <a href="{{ route('laporan-masalah.index') }}" class="btn btn-secondary">Kembali ke Daftar Laporan</a>
    </div>

</x-app-layout>
