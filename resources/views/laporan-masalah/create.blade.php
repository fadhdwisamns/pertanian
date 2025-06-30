<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            Buat Laporan Permasalahan Baru
        </h2>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('laporan-masalah.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                @if ($errors->any())
                    <div class="alert alert-danger mb-3">
                        <strong>Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="judul_laporan" class="form-label">Judul Laporan</label>
                        <input type="text" name="judul_laporan" class="form-control" value="{{ old('judul_laporan') }}" placeholder="Contoh: Serangan Hama Wereng pada Padi" required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="kategori_masalah" class="form-label">Kategori Masalah</label>
                        <select name="kategori_masalah" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Hama" @if(old('kategori_masalah') == 'Hama') selected @endif>Hama</option>
                            <option value="Penyakit Tanaman" @if(old('kategori_masalah') == 'Penyakit Tanaman') selected @endif>Penyakit Tanaman</option>
                            <option value="Pupuk" @if(old('kategori_masalah') == 'Pupuk') selected @endif>Pupuk</option>
                            <option value="Irigasi/Air" @if(old('kategori_masalah') == 'Irigasi/Air') selected @endif>Irigasi/Air</option>
                            <option value="Lainnya" @if(old('kategori_masalah') == 'Lainnya') selected @endif>Lainnya</option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="deskripsi_masalah" class="form-label">Deskripsi Lengkap Masalah</label>
                        <textarea name="deskripsi_masalah" class="form-control" rows="5" required>{{ old('deskripsi_masalah') }}</textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="foto_masalah" class="form-label">Foto Masalah (Jika ada)</label>
                        <input type="file" name="foto_masalah" class="form-control">
                    </div>

                    <div class="col-12 text-center">
                      <button type="submit" class="btn btn-primary">Kirim Laporan</button>
                      <a href="{{ route('laporan-masalah.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
