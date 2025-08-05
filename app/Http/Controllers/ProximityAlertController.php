<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; 
use App\Models\AlertLog;

class ProximityAlertController extends Controller
{
    /**
     * Send coordinates to the Flask API and return the response to a view.
     */
    public function checkProximity(Request $request)
    {
        $validated = $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'radius' => 'required|integer',
        ]);

        $flaskApiUrl = 'http://127.0.0.1:5000/check_proximity';
        $warehouseCoords = [14.5995, 120.9842];

        $response = Http::post($flaskApiUrl, [
            'warehouse' => $warehouseCoords,
            'delivery' => [$validated['lat'], $validated['lng']],
            'radius' => $validated['radius'],
        ]);

        // ** NEW: Check if the API call failed **
        if ($response->failed()) {
            return back()->withErrors([
                'api_error' => 'Could not connect to the Proximity API. Please make sure the Python server is running.'
            ]);
        }

        $apiData = $response->json();

        AlertLog::create([
            'warehouse_lat' => $warehouseCoords[0],
            'warehouse_lng' => $warehouseCoords[1],
            'delivery_lat' => $validated['lat'],
            'delivery_lng' => $validated['lng'],
            'radius' => $validated['radius'],
            'distance' => $apiData['geodesic_distance'],
            'within_range' => $apiData['within_range'],
            'route_distance' => $apiData['route_distance'],
            'duration' => $apiData['duration'], 
        ]);


        // If successful, continue to the results view
        return view('dashboard.alerts', [
            'data' => $response->json(),
            'warehouse' => $warehouseCoords,
            'delivery' => [$validated['lat'], $validated['lng']],
            'radius' => $validated['radius']
        ]);
    }
}