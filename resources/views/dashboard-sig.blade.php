<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            Peta Sebaran Lahan & Kelompok Tani
        </h2>
    </x-slot>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

     <div class="card">
        <div class="card-body">
            <div id="map" style="height: 600px; width: 100%;"></div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([-0.5336, 101.4452], 10); // Center di Kuansing

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // --- 1. DEFINISIKAN IKON CUSTOM ---
        var blueIcon = new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        var redIcon = new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });


        // --- 2. AMBIL DATA DARI CONTROLLER ---
        var lahans = @json($lahans);
        var kelompokTanis = @json($kelompokTanis);


        // --- 3. PLOTTING DATA LAHAN (PETANI) - MARKER BIRU ---
        lahans.forEach(function(lahan) {
            // Pastikan ada koordinat
            if (lahan.latitude && lahan.longitude) {
                var marker = L.marker([lahan.latitude, lahan.longitude], { icon: blueIcon }).addTo(map);
                
                // Konten untuk popup info lahan
                var popupContent = `
                    <div style="max-width: 200px;">
                        ${lahan.foto_url ? `<img src="${lahan.foto_url}" alt="Foto Lahan" style="width:100%; height:auto; border-radius: 5px; margin-bottom: 5px;">` : ''}
                        <strong>${lahan.nama_lahan}</strong><br>
                        <strong>Pemilik:</strong> ${lahan.nama_petani}<br>
                        <strong>Luas:</strong> ${lahan.luas_lahan} Ha<br>
                        <strong>Produksi:</strong> ${lahan.jumlah_produksi}<br>
                        <strong>Kontak:</strong> <a href="https://wa.me/${lahan.no_wa}" target="_blank">${lahan.no_wa}</a>
                    </div>
                `;
                marker.bindPopup(popupContent);
            }
        });


        // --- 4. PLOTTING DATA KELOMPOK TANI (KOMODITAS) - MARKER MERAH ---
        kelompokTanis.forEach(function(kelompok) {
            var marker = L.marker([kelompok.latitude, kelompok.longitude], { icon: redIcon }).addTo(map);

            // Konten untuk popup info kelompok tani
            var popupContent = `
                <div style="max-width: 200px;">
                    <strong>${kelompok.nama_kelompok}</strong><br>
                    <hr style="margin: 2px 0;">
                    <strong>Desa:</strong> ${kelompok.desa}<br>
                    <strong>Komoditas:</strong> ${kelompok.komoditas_unggulan}<br>
                    <strong>Ketua:</strong> ${kelompok.ketua_kelompok}<br>
                    <strong>Tahun Berdiri:</strong> ${kelompok.tahun_berdiri}
                </div>
            `;
            marker.bindPopup(popupContent);
        });

    </script>
</x-app-layout>
