<!DOCTYPE html>
<html lang="en">
<head>
    <title>Real-Time Delivery Tracking</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    @vite('resources/js/app.js')
    <style>
        body { margin: 0; font-family: sans-serif; }
        #map { height: 100vh; width: 100vw; }
    </style>
</head>
<body>
    <div id="map"></div>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Initial map setup
        const map = L.map('map').setView([14.5995, 120.9842], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        // Warehouse Marker
        L.marker([14.5995, 120.9842]).addTo(map).bindPopup('<b>Warehouse</b>');

        // Delivery Marker (starts at warehouse)
        const deliveryIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
            iconSize: [25, 41], iconAnchor: [12, 41]
        });
        const deliveryMarker = L.marker([14.5995, 120.9842], {icon: deliveryIcon}).addTo(map);

        // Listen for broadcasts
        window.Echo.channel('delivery-tracking')
            .listen('DeliveryLocationUpdated', (e) => {
                console.log('Location Updated:', e);
                deliveryMarker.setLatLng([e.lat, e.lng]);
                map.panTo([e.lat, e.lng]);
            });
    </script>
</body>
</html>