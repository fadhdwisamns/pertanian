<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Kelompok Tani</title>
    <style>
        body { font-family: sans-serif; }
        .kop-surat { text-align: center; border-bottom: 3px solid black; padding-bottom: 15px; margin-bottom: 30px;}
        .kop-surat img { width: 80px; float: left; }
        .kop-surat .kop-text { float: right; width: calc(100% - 100px); }
        .kop-surat h1, .kop-surat h2, .kop-surat p { margin: 0; }
        .kop-surat h1 { font-size: 1.5em; }
        .kop-surat h2 { font-size: 1.2em; }
        .report-title { text-align: center; font-size: 1.2em; font-weight: bold; margin-bottom: 20px; }
        .report-table { width: 100%; border-collapse: collapse; }
        .report-table th, .report-table td { border: 1px solid black; padding: 8px; font-size: 0.9em; text-align: left;}
        .report-table th { background-color: #f2f2f2; }
        .signature { margin-top: 50px; text-align: right; }
        .signature p { margin-bottom: 60px; }
        .clearfix::after { content: ""; clear: both; display: table; }
    </style>
</head>
<body>

    <div class="kop-surat clearfix">
        <img src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(public_path('images/logo-pertanian.svg'))) }}" alt="Logo">
        <div class="kop-text">
            <h2>KEMENTERIAN PERTANIAN REPUBLIK INDONESIA</h2>
            <h1>DINAS PERTANIAN KABUPATEN KUANTAN SINGINGI</h1>
            <p>Jalan Pertanian No. 123, Teluk Kuantan, Kode Pos 12345</p>
        </div>
    </div>

    <div class="report-title">
        LAPORAN DATA KELOMPOK TANI
    </div>

    <table class="report-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Desa</th>
                <th>Nama Kel. Tani</th>
                <th>Alamat</th>
                <th>Komoditas Unggulan</th>
                <th>Ketua</th>
                <th>Kelas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kelompokTani as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->desa }}</td>
                <td>{{ $item->nama_kelompok }}</td>
                <td>{{ $item->alamat_sekretariat }}</td>
                <td>{{ $item->komoditas_unggulan }}</td>
                <td>{{ $item->ketua_kelompok }}</td>
                <td>{{ $item->kelas_kemampuan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signature">
        <p>Telukkuantan, {{ date('d F Y') }}</p>
        <p>Pimpinan</p>
        <br><br><br>
        <strong>(______________________)</strong>
    </div>

</body>
</html>