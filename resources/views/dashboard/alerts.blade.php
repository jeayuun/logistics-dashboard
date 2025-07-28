<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proximity Alert</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>

    <style>
        body { font-family: sans-serif; margin: 0; display: flex; flex-direction: column; align-items: center; }
        .alert { padding: 1rem; width: 100%; text-align: center; box-sizing: border-box; }
        .success { color: white; background-color: #28a745; }
        .danger { color: white; background-color: #dc3545; }
        #map { height: 500px; width: 80%; margin-top: 20px; } /* 2. Define map size */
        a { margin-top: 15px; font-size: 1.2rem; }
    </style>
</head>
<body>

    <div class="alert {{ $data['within_range'] ? 'success' : 'danger' }}">
        @if ($data['within_range'])
            <p><strong>Success!</strong> Delivery is within {{ $data['distance'] }} meters!</p>
        @else
            <p><strong>Alert!</strong> Delivery is {{ $data['distance'] }} meters away.</p>
        @endif
    </div>

    <div id="map"></div>
    <a href="{{ route('proximity.form') }}">Check another</a>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>

    <script>
        // 5. Get data from PHP
        const warehouse = @json($warehouse);
        const delivery = @json($delivery);
        const radius = @json($radius);
        const withinRange = @json($data['within_range']);

        // 6. Initialize the map
        const map = L.map('map').setView(delivery, 15);

        // Add the map tiles (from OpenStreetMap)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // 7. Add warehouse marker and radius circle
        L.marker(warehouse).addTo(map).bindPopup('<b>Warehouse</b>');
        L.circle(warehouse, {
            color: 'blue',
            fillColor: '#3388ff',
            fillOpacity: 0.2,
            radius: radius
        }).addTo(map);

        // 8. Add delivery marker with different color based on proximity
        const deliveryIcon = L.icon({
            iconUrl: `https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-${withinRange ? 'green' : 'red'}.png`,
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
            shadowSize: [41, 41]
        });

        L.marker(delivery, {icon: deliveryIcon}).addTo(map).bindPopup('<b>Delivery Location</b>');
    </script>
</body>
</html>