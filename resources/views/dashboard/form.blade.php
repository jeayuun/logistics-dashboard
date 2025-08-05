<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlertProximity | Proximity Check</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #212529;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
            height: 70px;
            background-color: #fa893e;
            box-sizing: border-box;
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

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .nav-button {
            background-color: #f5f5f5;
            color: #fa893e;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .nav-button:hover {
            opacity: 0.9;
        }

        .page-container {
            display: grid;
            place-items: center;
            height: calc(100% - 70px);
        }

        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            width: 100%;
            max-width: 500px;
        }

        h1 {
            margin-top: 0;
            font-weight: 700;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 6px;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
        }

        .form-button {
            width: 100%;
            padding: 0.75rem;
            border: none;
            border-radius: 6px;
            background-color: #fa893e;
            color: white;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .form-button:hover {
            opacity: 0.9;
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
            <a href="{{ route('history') }}" class="nav-button">Proximity Checks History</a>
        </div>
    </nav>
    <div class="page-container">
        <div class="card form-card">
            <h1 style="color: #fa893e;">Check Delivery Proximity</h1>
            <form method="POST" action="{{ route('check.proximity') }}">
                @csrf
                @if ($errors->any())
                    <div
                        style="padding: 1rem; color: #721c24; background-color: #f8d7da; border-radius: 8px; margin-bottom: 1.5rem;">
                        {{ $errors->first() }}
                    </div>
                @endif
                <div class="form-group">
                    <label for="lat">Delivery Latitude:</label>
                    <input type="text" id="lat" name="lat" required placeholder="e.g., 14.5547">
                </div>
                <div class="form-group">
                    <label for="lng">Delivery Longitude:</label>
                    <input type="text" id="lng" name="lng" required placeholder="e.g., 121.0244">
                </div>
                <div class="form-group">
                    <label for="radius">Alert Radius (m):</label>
                    <select name="radius" id="radius">
                        <option value="100">100m</option>
                        <option value="250" selected>250m</option>
                        <option value="500">500m</option>
                    </select>
                </div>
                <button type="submit" class="form-button">Check Proximity</button>
            </form>
        </div>
    </div>
</body>

</html>
