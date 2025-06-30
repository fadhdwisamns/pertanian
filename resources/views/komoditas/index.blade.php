<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">Data Komoditas</h2>
    </x-slot>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Daftar Komoditas</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Komoditas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($komoditas as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_komoditas }}</td>
                            <td>
                                <form action="{{ route('komoditas.destroy', $item->id) }}" method="POST">
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
            {!! $komoditas->links() !!}
        </div>
    
</x-app-layout>