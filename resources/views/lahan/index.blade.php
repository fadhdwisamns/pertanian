<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            Data Lahan Pertanian
        </h2>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <h5 class="card-title">Daftar Lahan Pertanian</h5>
                <a href="{{ route('lahan.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Tambah Data Lahan
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
                            <th>Nama Lahan</th>
                            <th>Nama Petani</th> {{-- <-- KOLOM BARU --> --}}
                            <th>No. WA</th> {{-- <-- KOLOM BARU --> --}}
                            <th>Luas Lahan (Ha)</th>
                            <th>Jumlah Produksi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($lahans as $lahan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $lahan->nama_lahan }}</td>
                            <td>{{ $lahan->nama_petani ?? 'N/A' }}</td>
                            <td>{{ $lahan->no_wa }}</td>
                            <td>{{ $lahan->luas_lahan }}</td>
                            <td>{{ $lahan->jumlah_produksi }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('lahan.show', $lahan->id) }}" class="btn btn-info btn-sm me-1">Show</a>
                                    <a href="{{ route('lahan.edit', $lahan->id) }}" class="btn btn-warning btn-sm me-1">Edit</a>
                                    <form action="{{ route('lahan.destroy', $lahan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                           <td colspan="7" class="text-center">Belum ada data lahan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {!! $lahans->links('pagination::bootstrap-5') !!}
            </div>
        </div>
    </div>
</x-app-layout>
