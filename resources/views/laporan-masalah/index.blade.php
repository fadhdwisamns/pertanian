<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            Pelaporan Permasalahan
        </h2>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <h5 class="card-title">Daftar Laporan Anda</h5>
                <a href="{{ route('laporan-masalah.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Buat Laporan Baru
                </a>
            </div>

            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Laporan</th>
                            <th>Kategori</th>
                            @role('Admin')
                                <th>Pelapor</th>
                            @endrole
                            <th>Status</th>
                            <th>Tanggal Lapor</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($laporanMasalah as $laporan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $laporan->judul_laporan }}</td>
                            <td>{{ $laporan->kategori_masalah }}</td>
                            @role('Admin')
                                <td>{{ $laporan->user->name ?? 'N/A' }}</td>
                            @endrole
                            <td>
                                <span class="badge 
                                    @if($laporan->status == 'Dikirim') bg-secondary 
                                    @elseif($laporan->status == 'Diproses') bg-warning text-dark
                                    @else bg-success @endif">
                                    {{ $laporan->status }}
                                </span>
                            </td>
                            <td>{{ $laporan->created_at->format('d-m-Y H:i') }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('laporan-masalah.show', $laporan->id) }}" class="btn btn-info btn-sm me-1">Detail</a>
                                    <form action="{{ route('laporan-masalah.destroy', $laporan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                           <td colspan="7" class="text-center">Anda belum memiliki laporan masalah.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {!! $laporanMasalah->links('pagination::bootstrap-5') !!}
            </div>
        </div>
    </div>
</x-app-layout>
