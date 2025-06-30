<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Lahan</title>
    <style>
        body { font-family: sans-serif; margin: 0; padding: 20px; } /* Menambahkan margin dan padding dasar */
        .kop-surat { text-align: center; border-bottom: 3px solid black; padding-bottom: 15px; margin-bottom: 30px; position: relative; } /* Tambahkan relative untuk logo */
        .kop-surat .logo {
            position: absolute;
            left: 0; /* Sesuaikan posisi logo ke kiri */
            top: 0;
            width: 80px; /* Sesuaikan ukuran logo */
            height: auto;
        }
        .kop-surat .kop-text { /*float: right; width: calc(100% - 100px);*/ margin-left: 90px; } /* Sesuaikan margin-left untuk kop text */
        .kop-surat h2 { font-size: 1.2em; margin: 0; }
        .kop-surat h1 { font-size: 1.5em; margin: 0; }
        .kop-surat p { font-size: 0.9em; margin: 0; }

        .report-title { text-align: center; font-size: 1.2em; font-weight: bold; margin-bottom: 20px; }
        .report-title p { font-size: 0.8em; font-weight: normal; margin-top: 5px; } /* Style untuk sub-info filter */

        .report-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .report-table th, .report-table td { border: 1px solid black; padding: 8px; font-size: 0.9em; text-align: left;}
        .report-table th { background-color: #f2f2f2; text-align: center; } /* Judul kolom di tengah */
        .report-table td { vertical-align: top; } /* Pastikan konten sel rata atas */

        .signature { margin-top: 50px; text-align: right; }
        .signature p { margin: 0; } /* Hilangkan margin bawah default untuk p di signature */
        .signature .date { margin-bottom: 5px; } /* Margin bawah untuk tanggal */
        .signature .position { margin-bottom: 60px; } /* Margin bawah untuk posisi */
        .signature .name { font-weight: bold; } /* Bold untuk nama */

        .clearfix::after { content: ""; clear: both; display: table; }
    </style>
</head>
<body>
    {{-- Kop Surat --}}
    <div class="kop-surat clearfix">
        @php
        $logoPath = public_path('images/logo-pertanian.png'); // Sesuaikan path logo Anda dengan .png
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoBase64 = base64_encode(file_get_contents($logoPath));
        }
    @endphp
    @if($logoBase64)
        <img src="data:image/png;base64,{{ $logoBase64 }}" alt="Logo" class="logo">
    @else
        <div class="logo-placeholder">Logo</div> {{-- Placeholder jika logo tidak ditemukan --}}
    @endif
        <div class="kop-text">
            <h2>KEMENTERIAN PERTANIAN REPUBLIK INDONESIA</h2>
            <h1>DINAS PERTANIAN KABUPATEN KUANTAN SINGINGI</h1>
            <p>Jalan Pertanian No. 123, Teluk Kuantan, Kode Pos 12345</p>
        </div>
    </div>

    <div class="report-title">
        LAPORAN DATA LAHAN PERTANIAN
        <p>
            @if(!empty($filters['tahun'])) Tahun: {{ $filters['tahun'] }} @endif
            @if(!empty($filters['desa'])) Desa: {{ $filters['desa'] }} @endif
        </p>
    </div>

    <table class="report-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Nama Lahan</th>
                <th width="20%">Pemilik</th>
                <th width="15%">Desa</th>
                <th width="10%">Luas (Ha)</th>
                <th width="10%">Produksi</th>
                <th width="15%">Tgl Dibuat</th>
            </tr>
        </thead>
       <tbody>
    @forelse ($lahans as $lahan)
    <tr>
        <td style="text-align: center;">{{ $loop->iteration }}</td>
        <td>{{ $lahan->nama_lahan }}</td>
        <td>{{ $lahan->user->name ?? 'N/A' }}</td>
        <td>
            {{-- Cek apakah user ada dan memiliki kelompok tani --}}
            @if($lahan->user && $lahan->user->kelompokTanis->isNotEmpty())
                {{-- Ambil semua nama desa, buat unik, dan gabungkan dengan koma --}}
                {{ $lahan->user->kelompokTanis->pluck('desa')->unique()->implode(', ') }}
            @else
                N/A
            @endif
        </td>
        <td style="text-align: center;">{{ $lahan->luas_lahan }}</td>
        <td style="text-align: center;">{{ $lahan->jumlah_produksi }}</td>
        <td style="text-align: center;">{{ $lahan->created_at->format('d-m-Y') }}</td>
    </tr>
    @empty
    <tr>
        <td colspan="7" style="text-align: center; padding: 20px;">Data tidak ditemukan untuk filter yang dipilih.</td>
    </tr>
    @endforelse
</tbody>
    </table>

    {{-- Tanda Tangan --}}
    <div class="signature">
        <p class="date">Telukkuantan, {{ date('d F Y') }}</p>
        <p class="position">Pimpinan</p>
        <br><br><br>
        <p class="name">(____________________)</p> {{-- Anda bisa isi dengan nama pimpinan --}}
        <p>Nip : x(30)</p> {{-- Isi NIP jika ada --}}
    </div>

</body>
</html>