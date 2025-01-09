<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Perkiraan Cuaca</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>
<body>
    <div id="map" style="height: 400px;"></div>
    <script>
        var map = L.map('map').setView([0, 0], 2);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        var apiKey = 'ea3d4ad54b26b04ea460ad6f3ae5c24b';
        function getWeatherData(cityName) {
            var apiUrl = `https://api.openweathermap.org/data/2.5/weather?q=${cityName}&appid=${apiKey}`;
            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    var temperature = (data.main.temp - 273.15).toFixed(2);
                    var weatherDescription = data.weather[0].description;
                    L.marker([data.coord.lat, data.coord.lon]).addTo(map)
                        .bindPopup(`Lokasi: ${data.name}<br>Temperatur: ${temperature}°C<br>Kondisi Cuaca: ${weatherDescription}`)
                        .openPopup();
                })
                .catch(error => {
                    console.error('Terjadi kesalahan:', error);
                });
        }
        function getLocationAndWeather() {
            if ('geolocation' in navigator) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat = position.coords.latitude;
                    var lon = position.coords.longitude;
                    var apiUrl = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`;
                    fetch(apiUrl)
                        .then(response => response.json())
                        .then(data => {
                            var location = data.address.suburb || data.address.village || data.address.town;
                            getWeatherData(location);
                            map.setView([lat, lon], 14);
                        })
                        .catch(error => {
                            console.error('Terjadi kesalahan:', error);
                        });
                });
            } else {
                alert('Geolokasi tidak didukung oleh peramban ini.');
            }
        }
        getLocationAndWeather();
    </script>
</body>
</html>