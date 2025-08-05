<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlertProximity | Proximity Status</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        body { 
            margin: 0;
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
        }
        
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
            height: 70px;
            background-color: #fa893e;
            box-sizing: border-box;
            padding-top: 10px;
        }
        .logo-area {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .logo-area img {
            height: 48px;
        }
        .logo-area span {
            font-size: 1.5rem;
            font-weight: 500;
            color: #f5f5f5;
        }
        .nav-actions { display: flex; align-items: center; gap: 1rem; }
        .nav-button {
            background-color: #f5f5f5;
            color: #fa893e;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
        }

        .alert-bar { 
            width: 100%; 
            box-sizing: border-box;
            text-align: center; 
            height: 34vh;
            padding: 1.5rem 2rem;
            padding-bottom: 2.8rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        
        .success { 
            background-color: #fa893e;
            color: #FFFFFF;
        }
        .danger {  
            background-color: #fa893e;
            color: #FFFFFF;
        }

        #map { 
            height: calc(70vh - 70px);
            width: 100%; 
        }
        
        .alert-title {
            font-size: 3rem;
            font-weight: 700;
            margin: 0 0 0.5rem 0; 
            line-height: 1.1;
        }
        .alert-description {
            font-size: 1.1rem;
            margin: 0;
        }
        .eta-container {
            display: flex;
            gap: 3rem;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.5);
        }
        .eta-box {
            text-align: center;
            min-width: 180px;
        }
        .eta-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.05em;
            opacity: 0.9;
            margin-bottom: 0.25rem;
        }
        .eta-value {
            display: block;
            font-size: 1.75rem;
            font-weight: 700;
            line-height: 1;
        }

        .custom-marker {
            border-radius: 50%;
            border: 2px solid white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.3);
            width: 12px;
            height: 12px;
        }
        .marker-delivery-success { background-color: #fa893e; }
        .marker-delivery-danger { background-color: #ef4444; }
        .warehouse-icon-frameless svg {
            filter: drop-shadow(0 2px 2px rgba(0,0,0,0.5));
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="logo-area">
            <img src="{{ asset('logo.png') }}" alt="AlertProximity Logo">
            <span>AlertProximity</span>
        </div>
        <div class="nav-actions">
            <a href="{{ route('proximity.form') }}" class="nav-button">Check Proximity</a>
        </div>
    </nav>

    <div class="alert-bar {{ $data['within_range'] ? 'success' : 'danger' }}">
        <div>
            <h2 class="alert-title">
                {{ $data['within_range'] ? 'In Range!' : 'Out of Range!' }}
            </h2>
            <p class="alert-description">
                @if ($data['within_range'])
                    Delivery is within the {{ $radius }}m alert radius.
                @else
                    Delivery is outside the {{ $radius }}m alert radius.
                @endif
            </p>
             @if ($data['duration'])
            <div class="eta-container">
                <div class="eta-box">
                    <span class="eta-label">ESTIMATED TIME OF ARRIVAL</span>
                    <span class="eta-value">{{ floor($data['duration'] / 60) }} min {{ round($data['duration'] % 60) }} sec</span>
                </div>
                <div class="eta-box">
                    <span class="eta-label">DRIVING DISTANCE</span>
                    <span class="eta-value">{{ round($data['route_distance'] / 1000, 2) }} km</span>
                </div>
            </div>
            @endif
            </div>
        </div>
    </div>

    <div id="map"></div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const warehouse = @json($warehouse);
        const delivery = @json($delivery);
        const radius = @json($radius);
        const withinRange = @json($data['within_range']);

        const map = L.map('map', { zoomControl: false }).setView(delivery, 15);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>'
        }).addTo(map);
        L.control.zoom({ position: 'topright' }).addTo(map);

        L.circle(warehouse, {
            color: '#fa893e',
            fillColor: '#fa893e',
            fillOpacity: 0.2,
            radius: radius
        }).addTo(map).bindPopup(`Alert Radius: ${radius}m`);

        const houseSVG = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" style="fill:#cd5e14; stroke:white; stroke-width:12; stroke-linejoin:round;"><path d="M216.71,92.44,136,36.1a16.1,16.1,0,0,0-16,0L40.05,91.68A16,16,0,0,0,32,104.75V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V104.2A16,16,0,0,0,216.71,92.44Z"></path></svg>`;
        const warehouseIcon = L.divIcon({
            html: houseSVG,
            className: 'warehouse-icon-frameless',
            iconSize: [36, 36],
            iconAnchor: [18, 36],
            popupAnchor: [0, -36]
        });
        L.marker(warehouse, {icon: warehouseIcon}).addTo(map).bindPopup('<b>Warehouse</b>');

        const deliveryMarkerClass = withinRange ? 'marker-delivery-success' : 'marker-delivery-danger';
        const deliveryIcon = L.divIcon({ className: `custom-marker ${deliveryMarkerClass}`, iconSize: [16, 16] });
        L.marker(delivery, {icon: deliveryIcon}).addTo(map).bindPopup('<b>Delivery Location</b>');
    </script>
</body>
</html>