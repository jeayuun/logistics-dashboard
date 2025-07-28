<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proximity Check</title>
    <style>
        body { font-family: sans-serif; display: grid; place-items: center; min-height: 100vh; }
        form { display: flex; flex-direction: column; gap: 10px; padding: 2rem; border: 1px solid #ccc; border-radius: 8px; }
        label, input, select, button { font-size: 1rem; }
    </style>
</head>
<body>
    {{-- ** NEW: Add this error block ** --}}
    @if ($errors->any())
        <div style="padding: 1rem; color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 8px; margin-bottom: 20px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('check.proximity') }}">
        @csrf
        <h3>Check Delivery Proximity</h3>
        <div>
            <label>Delivery Latitude:</label>
            <input type="text" name="lat" required>
        </div>
        <div>
            <label>Delivery Longitude:</label>
            <input type="text" name="lng" required>
        </div>
        <div>
            <label>Alert Radius (m):</label>
            <select name="radius">
                <option value="100">100m</option>
                <option value="250" selected>250m</option>
                <option value="500">500m</option>
            </select>
        </div>
        <button type="submit">Check Proximity</button>
    </form>
</body>
</html>