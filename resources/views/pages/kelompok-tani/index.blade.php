<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            Data Kelompok Tani
        </h2>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <h5 class="card-title">Daftar Kelompok Tani</h5>
                <a href="{{ route('kelompok-tani.create') }}" class="btn btn-primary">Tambah Data</a>
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
                            <th>Kecamatan</th>
                            <th>Desa</th>
                            <th>Nama Kelompok</th>
                            <th>Komoditas</th>
                            <th>Ketua</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kelompokTani as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->kecamatan }}</td>
                            <td>{{ $item->desa }}</td>
                            <td>{{ $item->nama_kelompok }}</td>
                            <td>{{ $item->komoditas_unggulan }}</td>
                            <td>{{ $item->ketua_kelompok }}</td>
                            <td>
                                <form action="{{ route('kelompok-tani.destroy', $item->id) }}" method="POST" class="d-inline-flex">

                                    {{-- TOMBOL SHOW DITAMBAHKAN DI SINI --}}
                                    <a href="{{ route('kelompok-tani.show', $item->id) }}" class="btn btn-info btn-sm me-1">Show</a>

                                    <a href="{{ route('kelompok-tani.edit', $item->id) }}" class="btn btn-warning btn-sm me-1">Edit</a>

                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {!! $kelompokTani->links('pagination::bootstrap-5') !!}
        </div>
    </div>
</x-app-layout>