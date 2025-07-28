<!DOCTYPE html>
<html lang="en">
<head><title>Location Simulator</title></head>
<body style="font-family: sans-serif; padding: 2rem;">
    <h2>Location Simulator</h2>
    <form action="/api/update-location" method="POST">
        @csrf
        <div><label>Lat:</label><input type="text" name="lat" value="14.6000"></div>
        <div><label>Lng:</label><input type="text" name="lng" value="120.9850"></div>
        <button type="submit">Update Location</button>
    </form>
</body>
</html>