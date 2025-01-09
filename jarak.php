<!DOCTYPE html>
<html>
<head>
    <title>Peta Leaflet</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <style>
        #map {
            height: 500px;
        }
    </style>
</head>
<body>
    <center>
        <div id="map"></div>
        <br>
        <div id="coordinates"></div>
        <div id="distance"></div>
        <br>
        <div id="notification"></div>
        <br>
        <button onclick="resetMap()">Reset</button>
        <script>
            var map = L.map('map').setView([-6.886999978794732, 107.61533318332542], 15); // Koordinat Kota Bandung
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
            var markers = []; // Array untuk menyimpan marker
            var coordinates = []; // Array untuk menyimpan koordinat
            var notificationDiv = document.getElementById('notification');
            map.on('click', function (e) {
                if (markers.length < 2) { // Batasi hanya 2 marker yang dapat ditambahkan
                    var marker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map);
                    markers.push(marker);
                    coordinates.push(e.latlng);
                    updateCoordinates();
                    if (markers.length === 2) {
                        calculateDistance();
                    }
                }
            });
            function updateCoordinates() {
                var coordinatesText = "";
                for (var i = 0; i < coordinates.length; i++) {
                    coordinatesText += "Titik " + (i + 1) + ": Lat " + coordinates[i].lat.toFixed(6) + ", Lng " + coordinates[i].lng.toFixed(6) + "<br>";
                }
                document.getElementById('coordinates').innerHTML = coordinatesText;
            }
            function calculateDistance() {
                var distance = markers[0].getLatLng().distanceTo(markers[1].getLatLng()); // Jarak dalam meter
                document.getElementById('distance').innerHTML = "Jarak antara dua titik: " + distance.toFixed(2) + " meter";
                if (distance <= 500) {
                    notificationDiv.innerHTML = 'Jarak antara 2 titik adalah kurang dari / sama dengan 500 meter. <br> Buka tab penyamaran baru dan masukkan alamat dari file <b>kirim-notifikasi.php</b> untuk mengirim notifikasi.';
                } else {
                    notificationDiv.innerHTML = '';
                }
            }
            function resetMap() {
                // Menghapus marker dan mengosongkan koordinat
                for (var i = 0; i < markers.length; i++) {
                    map.removeLayer(markers[i]);
                }
                markers = [];
                coordinates = [];
                document.getElementById('coordinates').innerHTML = '';
                document.getElementById('distance').innerHTML = '';
                notificationDiv.innerHTML = '';
            }
        </script>
    </center>
</body>
</html>