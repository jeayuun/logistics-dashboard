<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlertProximity | Check History</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #212529;
            overflow-y: hidden;
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
            padding: 3rem 2rem;
        }

        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            max-width: 1280px;
            margin: 0 auto;
        }

        h1 {
            margin-top: 0;
            font-weight: 700;
        }

        .history-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1.5rem;
        }

        .history-table th,
        .history-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }

        .history-table th {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #6c757d;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status-badge.success {
            background-color: #fa893e;
            color: white;
        }

        .status-badge.danger {
            background-color: #ef4444;
            color: white;
        }

        .pagination-links {
            margin-top: 2rem;
        }

        .pagination-links nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .pagination-links a,
        .pagination-links span {
            background-color: #f5f5f5;
            color: #fa893e;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .pagination-links a:hover {
            opacity: 0.9;
        }

        .pagination-links span {
            background-color: #e9ecef;
            color: #adb5bd;
            cursor: not-allowed;
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
            <a href="{{ route('proximity.form') }}" class="nav-button">Back to Form</a>
        </div>
    </nav>
    <div class="page-container">
        <div class="card">
            <h1 style="color: #fa893e;">Check History</h1>
            <div style="overflow-x: auto;">
                <table class="history-table">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Result</th>
                            <th>Alert Radius</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>ETA</th>
                            <th>Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td>
                                    <span class="status-badge {{ $log->within_range ? 'success' : 'danger' }}">
                                        {{ $log->within_range ? 'In Range' : 'Out of Range' }}
                                    </span>
                                </td>
                                <td>{{ round($log->distance, 2) }}m from warehouse</td>
                                <td>{{ $log->radius }}m</td>
                                <td>{{ number_format($log->delivery_lat, 4) }}</td>
                                <td>{{ number_format($log->delivery_lng, 4) }}</td>
                                <td>
                                    @if ($log->duration)
                                        {{ floor($log->duration / 60) }} min {{ round($log->duration % 60) }} sec
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $log->created_at->format('M d, Y, h:i A') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 2rem;">No history found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination-links">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</body>

</html>
